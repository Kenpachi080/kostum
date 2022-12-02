<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface IndexIntreface
{
    /**
     * @OA\Get(path="/api/title",
     *   tags={"Общая информация"},
     *   operationId="title",
     *   summary="Настройки сайта",
     * @OA\Response(
     *    response=200,
     *    description="Возврощается полная информация про сайт",
     *   )
     * )
     */
    public function title(): JsonResponse;

    /**
     * @OA\Get(path="/api/main",
     *   tags={"Общая информация"},
     *   operationId="main",
     *   summary="Главная страница",
     * @OA\Response(
     *    response=200,
     *    description="Вся информация на главной странице",
     *   )
     * )
     */
    public function main(): JsonResponse;

    /**
     * @OA\Get(path="/api/album",
     *   tags={"Общая информация"},
     *   operationId="album",
     *   summary="Альбом",
     * @OA\Response(
     *    response=200,
     *    description="Все альбомы",
     *   )
     * )
     */
    public function album(): JsonResponse;

    /**
     * @OA\Get(path="/api/album/{id}",
     *   tags={"Общая информация"},
     *   operationId="albumid",
     *   summary="Альбом по айди",
     * @OA\Response(
     *    response=200,
     *    description="Один альбом по айди",
     *   )
     * )
     */
    public function albumId($id): JsonResponse;

    /**
     * @OA\Get(path="/api/trend",
     *   tags={"Общая информация"},
     *   operationId="trend",
     *   summary="Тренды",
     * @OA\Response(
     *    response=200,
     *    description="Вся информация на главной странице",
     *   )
     * )
     */
    public function trend(): JsonResponse;

    /**
     * @OA\Get(path="/api/blog",
     *   tags={"Общая информация"},
     *   operationId="blog",
     *   summary="Блог",
     * @OA\Response(
     *    response=200,
     *    description="Вся информация про блог",
     *   )
     * )
     */
    public function blog(): JsonResponse;

    /**
     * @OA\Get(path="/api/blog/{id}",
     *   tags={"Общая информация"},
     *   operationId="blogId",
     *   summary="Блог по айди",
     * @OA\Response(
     *    response=200,
     *    description="Блог по айди",
     *   )
     * )
     */
    public function blogId($id): JsonResponse;

    /**
     * @OA\Get(path="/api/contact",
     *   tags={"Общая информация"},
     *   operationId="contact",
     *   summary="Контакты",
     * @OA\Response(
     *    response=200,
     *    description="Контакты",
     *   )
     * )
     */
    public function contact(): JsonResponse;
}
