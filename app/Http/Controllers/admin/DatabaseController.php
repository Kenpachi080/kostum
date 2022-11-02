<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    public function index()
    {
        return app('databases')->index();
    }

    public function show($table): JsonResponse
    {
        $response = app('databases')->show($table);
        return response()->json($response, 200);
    }

    public function showOnly($table, $id): JsonResponse
    {
        $response = app('databases')->show($table, $id);
        return response()->json($response, 200);
    }

    public function create($table): JsonResponse
    {
        $date = app('databases')->create($table, request()->all());
        return response()->json(['message' => $date['message']], $date['code']);
    }

    public function update($table, $id): JsonResponse
    {
        $date = app('databases')->update($table, $id, request()->all());
        return response()->json(['message' => $date['message'], $date['code']]);
    }

    public function rules($table): JsonResponse
    {
        $date = app('databases')->rules($table, request()->all());
        return response()->json(['message' => $date['message'], $date['code']]);
    }
}
