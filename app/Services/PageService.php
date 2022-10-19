<?php

namespace App\Services;

use App\Http\Requests\admin\FaceBlockRequest;
use App\Http\Resources\FaceBlockResource;
use App\Models\FaceBlock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;

class PageService extends Facade
{
    public function view($table)
    {
        return DB::table($table)->paginate(10);
    }

    public function viewOnly($table, $id)
    {
        return DB::table($table)->find($id)->first();
    }

    public function update($table, $id, $array)
    {
        return DB::table($table)->find($id)->update($array);
    }
}

?>
