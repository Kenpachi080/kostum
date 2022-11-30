<?php

namespace App\Interfaces;

use App\Http\Requests\AddressRequest;
use Illuminate\Http\JsonResponse;

interface AddresInterface
{
    /**
     * @OA\Post(
     * path="/api/auth/address",
     * summary="Добавить адресс",
     * description="Добавить адресс",
     * operationId="createAddress",
     * tags={"Адреса"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Апи Токен",
     *    @OA\JsonContent(
     *       required={"city, street, house"},
     *       @OA\Property(property="city", type="string", format="string", example="123"),
     *       @OA\Property(property="street", type="string", format="string", example="123"),
     *       @OA\Property(property="house", type="integer", format="string", example="321"),
     *  ),
     * ),
     *     @OA\Parameter(
     *         name="api_token",
     *         in="header",
     *         description="Токен авторизации(api_token)",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с данными",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     *
     */

    public function create(AddressRequest $request): JsonResponse;
    /**
     * @OA\Post  (
     * path="/api/auth/address/{id}",
     * summary="Обновить Адресс",
     * description="Обновить Адресс",
     * operationId="updateAddress",
     * tags={"Адреса"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Апи Токен",
     *    @OA\JsonContent(
     *       required={""},
     *       @OA\Property(property="city", type="string", format="string", example="123"),
     *       @OA\Property(property="street", type="string", format="string", example="123"),
     *       @OA\Property(property="house", type="integer", format="string", example="321"),
     *  ),
     * ),
     *     @OA\Parameter(
     *         name="api_token",
     *         in="header",
     *         description="Токен авторизации(api_token)",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с данными",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     *
     */

    public function update(AddressRequest $request, $id): JsonResponse;
    /**
     * @OA\Delete(
     * path="/api/auth/address/{id}",
     * summary="Удалить адресс",
     * description="Удалить адресс",
     * operationId="deleteAddress",
     * tags={"Адреса"},
     *     @OA\Parameter(
     *         name="api_token",
     *         in="header",
     *         description="Токен авторизации(api_token)",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="CallBack с данными",
     *    @OA\JsonContent(
     *       type="object",
     *        )
     *     )
     * )
     *
     */

    public function delete($id): JsonResponse;
}
