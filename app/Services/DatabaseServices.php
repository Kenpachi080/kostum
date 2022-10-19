<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
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
        $db = app('images')->images(DB::table($table));
        if (is_null($id)) {
            $db->get();
        } else {
            $db->where('id', $id)->first();
        }
        $response = [
            'type' => collect(SchemaManager::describeTable($table))->merge($additional_attributes),
            'date' => $db
        ];

        return $response;
    }


}
