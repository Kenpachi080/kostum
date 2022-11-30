<?php

namespace App\Services;

use App\Helpers\DatabaseHelper;
use App\Models\TableRules;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;

class DatabaseServices extends DatabaseHelper
{


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
            $displayName = DB::table('data_types')->where('name', $table)->first();
            $table = Str::replaceFirst(DB::getTablePrefix(), '', $table);
            $table = [
                'name' => $table,
                'display_name' => $displayName->display_name ?? null,
                'slug' => $dataTypes[$table]['slug'] ?? null,
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
            $row = DB::table($table)->insert($this->formatDate($table, $date));
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }

        return ['message' => $row, 'code' => 201];
    }

    public function update($table, $id, $date): array
    {
        try {
            $this->exceptionDate($date);
            $db = $this->exceptionFind($id, $table);
            $date = $this->formatDate($table, $date);
            $row = $db->update($date);
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }

        return ['message' => $row, 'code' => 202];
    }

    public function delete($table, $id, $date): array
    {
        try {
            $this->exceptionDate($date);
            $db = $this->exceptionFind($id, $table);
            $db->delete();
        } catch (\Exception $exception) {
            return ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
        }

        return ['message' => 'Запись удалена', 'code' => 202];
    }

    public function rules($table, $request): array
    {
        foreach ($request as $key => $value) {
            if ($key == 'table_name') {
                $rules = DB::table('data_types')->updateOrInsert(['name' => $table, 'slug' => Str::slug($table)], ['display_name' => $value]);
            }
            $rules = TableRules::query()
                ->updateOrCreate(['table' => $table, 'field' => $key], ['type' => $value]);

        }

        return ['message' => 'Правила обновлены', 'code' => 201];
    }
}
