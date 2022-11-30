<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Interfaces\AddresInterface;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller implements AddresInterface
{

    public function create(AddressRequest $request): JsonResponse
    {
        $date = $request->validated();
        $date['user_id'] = Auth::id();
        $address = UserAddress::query()->create($date);

        return response()->json(['message' => 'Адрес был успешно создан', 'date' => $address], 201);
    }

    public function update(AddressRequest $request, $id): JsonResponse
    {
        $address = UserAddress::query()->find($id);
        if (!$address || $address->user_id != Auth::id()) {
            return response()->json(['message' => 'Адрес не был найден'], 404);
        }
        $address->update($request->validated());

        return response()->json(['message' => 'Адрес был успешно обновлен', 'date' => $address], 202);
    }

    public function delete($id): JsonResponse
    {
        $address = UserAddress::query()->find($id);
        if (!$address || $address->user_id != Auth::id()) {
            return response()->json(['message' => 'Адрес не был найден'], 404);
        }
        $address->delete();

        return response()->json(['message' => 'Адрес был удален'], 200);
    }
}
