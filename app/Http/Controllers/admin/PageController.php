<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\FaceBlockRequest;
use App\Http\Resources\FaceBlockResource;
use App\Http\Resources\NotFoundTableResource;
use App\Interfaces\admin\PageInterface;
use App\Models\FaceBlock;
use App\Rules\RequestTableRules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function view($table): JsonResponse
    {
        try {
            return response()->json(app('pages')->view(), 200);
        } catch (\Exception $exception) {
            return response()->json(new NotFoundTableResource($table), 404);
        }
    }

    public function viewOnly($table, $id): JsonResponse
    {
        try {
            return response()->json(app('pages')->viewOnly($table, $id), 200);
        } catch (\Exception $exception) {
            return response()->json(new NotFoundTableResource($id), 404);
        }
    }

    public function create($table, FaceBlockRequest $request): JsonResponse
    {
        $date = $request->validated();
        $face = FaceBlock::create($date);

        return response()->json(['message' => 'Блок успешно создан', 'date' => new FaceBlockResource($face->id)], 201);
    }

    public function update($table, $id, FaceBlockRequest $request): JsonResponse
    {
        $db = DB::table('data_types')->where('name', $table)->first();
        $db = DB::table('data_rows')->where('data_type_id', $db->id)->get()->toArray();
        dd($db);
        foreach ($request as $value) {

        }
        return response()->json(['message' => 'Блок успешно обновлен', 'date' => new FaceBlockResource($id)], 202);
    }

    public function delete($id): JsonResponse
    {
        FaceBlock::query()
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Блок успешно удален'], 200);
    }
}
