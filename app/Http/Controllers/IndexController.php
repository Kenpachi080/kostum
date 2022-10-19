<?php

namespace App\Http\Controllers;


use App\Interfaces\IndexIntreface;
use App\Models\MainCard;
use App\Models\MainSale;
use App\Models\MainSlider;
use Illuminate\Http\JsonResponse;
use Psy\Util\Json;

class IndexController extends Controller implements IndexIntreface
{
    public function title(): JsonResponse
    {
        $return = [
            'phone_call' => setting('site.phone_call'),
            'phone1' => setting('site.phone1'),
            'phone2' => setting('site.phone2'),
            'work_time' => setting('site.work_time'),
            'address' => setting('site.address'),
            'email' => setting('site.email'),
            'map' => setting('site.map'),
            'app_store' => setting('site.app_store'),
            'google_play' => setting('site.google_play')
        ];
        return response()->json($return, 200);
    }

    public function main(): JsonResponse
    {
        $return = [
            'slider' => app('image')->images(MainSlider::all()),
            'card' => app('images')->images(MainCard::query()
                ->orderBy('sort')
                ->take(5)->get()),
            'sale' => app('images')->images(MainSale::all()->take(1)),
        ];
        return response()->json($return, 200);
    }
}
