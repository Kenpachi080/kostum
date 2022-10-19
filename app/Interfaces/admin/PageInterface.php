<?php

namespace App\Interfaces\admin;

use App\Http\Requests\admin\FaceBlockRequest;
use Illuminate\Http\JsonResponse;

interface PageInterface
{
    /**
     * @OA\Get(path="/api/admin/face/",
     *   tags={"Лицевые блоки"},
     *   operationId="viewAll",
     *   summary="Все лицевые блоки",
     * @OA\Response(
     *    response=200,
     *    description="Все лицевые блоки",
     *   )
     * )
     */
    /* показываем все записи  */
    public function view($table): JsonResponse;
    /**
     * @OA\Get(path="/api/admin/face/{id}",
     *   tags={"Лицевые блоки"},
     *   operationId="viewSingle",
     *   summary="Отдельный лицевой блок",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Айди лицевого блока",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="Отдельный лицевой блок",
     *   )
     * )
     */

    /* показ отдельного блока */
    public function viewOnly($table, $id): JsonResponse;
    /**
     * @OA\Post(
     * path="/api/admin/face",
     * summary="Создать лицевой блок",
     * description="Создать лицевой блок",
     * operationId="faceCreate",
     * tags={"Лицевые блоки"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Апи Токен",
     *    @OA\JsonContent(
     *       required={"name, content"},
     *       @OA\Property(property="parentID", type="integer", format="string", example="1"),
     *       @OA\Property(property="name", type="string", format="string", example="Условия доставки"),
     *       @OA\Property(property="content", type="string", format="string", example="Доставка курьером по г. Алматы"),
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
     *    response=201,
     *    description="Массив с: Message - Блок успешно создан, date - блок",
     *    @OA\JsonContent(
     *       type="object",
     *             @OA\Property(
     *                property="user",
     *                type="object",
     *               example={
     *                  }
     *              ),
     *     @OA\Property(
     *                property="message",
     *                type="string",
     *               example="Блок успешно создан",
     *              ),
     *          ),
     *        )
     *     )
     * )
     */
    /* Создать блок */
    public function create(FaceBlockRequest $request): JsonResponse;
    /**
     * @OA\Put(
     *     path="/api/admin/face/{id}",
     *     tags={"Лицевые блоки"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Апи Токен",
     *    @OA\JsonContent(
     *       required={"name, content"},
     *       @OA\Property(property="parentID", type="integer", format="string", example="1"),
     *       @OA\Property(property="name", type="string", format="string", example="Условия доставки"),
     *       @OA\Property(property="content", type="string", format="string", example="Доставка курьером по г. Алматы"),
     *  ),
     * ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Айди лицевого блока",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns matching Person Object",
     *     )
     * )
     */
    /* Обновить блок */
    public function update($id, FaceBlockRequest $request): JsonResponse;
    /**
     * @OA\Delete (
     *     path="/api/admin/face/{id}",
     *     tags={"Лицевые блоки"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Айди лицевого блока",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns matching Person Object",
     *     )
     * )
     */
    /* удалить блок */
    public function delete($id): JsonResponse;
}
