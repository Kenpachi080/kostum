<?php

namespace App\Helpers;

use App\Models\TableRules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

abstract class DatabaseHelper
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

    public function exceptionDate($date)
    {
        if (gettype($date) != 'array') {
            throw new \Exception('Не тот тип данных', 409);
        }
    }

    public function exceptionFind($id, $table)
    {
        $dataType = Voyager::model('DataType')->where('slug', '=', Str::slug($table))->first();
        // надо обязательно заполнить в вояджере эту таблицу, что бы модельку вытащить
        $db = app($dataType->model_name)->query()->find($id);
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
                    if (gettype($value) != 'string') {
                        throw new \Exception('Видимо вы забыли указать правила для этой таблицы, для строки пришел: ' . gettype($value) . '', 409);
                    }
                    $insertDate[$key] = $value;
                    break;
            }
        }
        if ($insertDate == []) {
            throw new \Exception('Данные не пришли', 500);
        }
        return $insertDate;
    }
}
