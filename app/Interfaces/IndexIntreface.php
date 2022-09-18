<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface IndexIntreface
{
    /**
     * @OA\Get(path="/api/title",
     *   tags={"Общая информация для сайта"},
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
     *   tags={"Лицевые блоки"},
     *   operationId="main",
     *   summary="Главная страница",
     * @OA\Response(
     *    response=200,
     *    description="Вся информация на главной странице",
     *   )
     * )
     */
    public function main(): JsonResponse;
}
