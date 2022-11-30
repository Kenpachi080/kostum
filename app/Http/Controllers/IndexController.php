<?php

namespace App\Http\Controllers;


use App\Interfaces\IndexIntreface;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\FotoAlbum;
use App\Models\MainCard;
use App\Models\MainSale;
use App\Models\MainSlider;
use App\Models\Trends;
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
            'slider' => app('images')->images(MainSlider::all()),
            'card' => app('images')->images(MainCard::query()
                ->orderBy('sort')
                ->take(5)->get()),
            'sale' => app('images')->images(MainSale::all()->take(1)),
            'album' => app('images')->images(FotoAlbum::all()->take(4))
        ];
        return response()->json($return, 200);
    }

    public function album(): JsonResponse
    {
        return response()->json(app('images')->images(FotoAlbum::all()), 200);
    }

    public function albumId($id): JsonResponse
    {
        return response()->json(app('images')->images(FotoAlbum::where('id', $id)->get()), 200);
    }

    public function trend(): JsonResponse
    {
        return response()->json(Trends::first());
    }


    public function blog(): JsonResponse
    {
        return response()->json(Blog::all(), 200);
    }

    public function blogId($id): JsonResponse
    {
        return response()->json(Blog::find($id));
    }

    public function contact(): JsonResponse
    {
        return response()->json(app('images')->images(Contact::all()));
    }

}
