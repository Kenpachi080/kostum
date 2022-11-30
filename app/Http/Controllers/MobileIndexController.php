<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainSlider;
use Illuminate\Http\Request;

class MobileIndexController extends Controller
{
    public function main()
    {
        $return = [
            'slider' => app('images')->images(MainSlider::all()),
            'category' => app('items')->category(),
            'bestItem' => app('items')->bestItem(),
        ];

        return response()->json($return, 200);
    }
}
