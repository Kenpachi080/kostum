<?php

namespace App\Services;

use App\Models\TableRules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;

class DatabaseServices
{
    public $skip = [
        '',
        'data_rows',
        'data_types',
        'failed_jobs',
        'migrations',
        'password_resets',
        'permission_role',
        'permissions',
        'personal_access_tokens',
        'roles',
        'settings',
        'translations',
        'user_roles',

    ];


    public function index()
    {
        $dataTypes = Voyager::model('DataType')->select('id', 'name', 'slug')->get()->keyBy('name')->toArray();

        function table($shema, $skip)
        {
            $return = [];
            foreach ($shema as $value) {
                if (!array_search($value, $skip)) {
                    $return[] = $value;
                }
            }
            return $return;
        }

        $table = table(SchemaManager::listTableNames(), $this->skip);
        $tables = array_map(function ($table) use ($dataTypes) {
            $table = Str::replaceFirst(DB::getTablePrefix(), '', $table);
            $table = [
                'prefix' => DB::getTablePrefix(),
                'name' => $table,
                'slug' => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];
            return (object)$table;
        }, $table);
        return $tables;
    }

    public function show($table, $id = null)
    {
        $additional_attributes = [];
        $model_name = Voyager::model('DataType')->where('name', $table)->pluck('model_name')->first();
        if (isset($model_name)) {
            $model = app($model_name);
            if (isset($model->additional_attributes)) {
                foreach ($model->additional_attributes as $attribute) {
                    $additional_attributes[$attribute] = [];
                }
            }
        }
        $db = DB::table($table);
        if (is_null($id)) {
            $db = $db->get();
        } else {
            $db = $db->where('id', $id)->first();
        }
        $response = [
            'type' => collect(SchemaManager::describeTable($table))->merge($additional_attributes),
            'date' => app('images')->images($db),
        ];

        return $response;
    }

    public function create($table, $date)
    {
        try {
            $this->exceptionDate($date);
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }
        DB::table($table)->insert($this->formatDate($table, $date));

        return ['message' => 'Запись была создана', 'code' => 201];
    }

    public function update($table, $id, $date)
    {
        try {
            $this->exceptionDate($date);
            $db = $this->exceptionFind($id, $table);
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }
        $db->update($this->formatDate($table, $date));

        return ['message' => 'Запись обновлена', 'code' => 202];
    }

    public function delete($table, $id, $date)
    {
        try {
            $this->exceptionDate($date);
            $db = $this->exceptionFind($id, $table);
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }
        $db->delete();

        return ['message' => 'Запись удалена', 'code' => 202];
    }

    public function exceptionDate($date)
    {
        if (gettype($date) != 'array') {
            throw new \Exception('Не тот тип данных', 409);
        }
    }

    public function exceptionFind($id, $table)
    {
        $db = DB::table($table)
            ->find($id);
        if (!$db) {
            throw new \Exception('Не найдена запись', 404);
        }

        return $db;
    }

    public function formatDate(string $table, array $date)
    {
        $insertDate = [];
        foreach ($date as $key => $value) {
            $type = TableRules::query()
                ->where('table', $table)
                ->where('field', $key)
                ->first();
            switch ($type->type) {
                case 'file':
                    $fileName = Storage::put("public/$table", $value);
                    $file = str_replace('public/', '', $fileName);
                    $insertDate[$key] = $file;
                    break;
                case 'multifile':
                    $files = [];
                    foreach ($value as $fileValue) {
                        $fileName = Storage::put("public/$table", $fileValue);
                        $files[] = str_replace('public/', '', $fileName);
                    }
                    $insertDate[$key] = json_encode($files);
                    break;
                default:
                    $insertDate[$key] = $value;
                    break;
            }
        }
        return $insertDate;
    }

    public function rules($table, $requests)
    {
        foreach ($requests as $key => $value) {
            TableRules::query()
                ->updateOrCreate(['table' => $table, 'field' => $key], ['type' => $value]);
        }

        return ['message' => 'Правила обновлены', 'code' => 201];
    }
}
