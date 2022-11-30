<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Facade;

class ItemService extends Facade
{
    public function category()
    {
        $categoryes = app('images')->images(Category::all());
        foreach ($categoryes as $category) {
            $subCategory = app('images')->images(SubCategory::query()->where('category', $category->id)->get());
            $category->sub_categury = $subCategory;
        }

        return $categoryes;
    }

    public function bestItem() {
//        $item = Item::query()->where('best', 1)->orderBy('sort')->get();
        return 1231;
    }
}
