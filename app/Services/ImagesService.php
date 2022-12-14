<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Facade;

class ImagesService extends Facade
{
    /**
     * @var string
     */
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL") . '/storage/';
    }

    public function image($image)
    {
        if ($image) {
            return $this->url . $image;
        }
        return '';
    }

    public function images($item)
    {
        if ($item) {
            foreach ($item as $block) {
                if (isset($block->image)) {
                    $block->image = $this->url . $block->image;
                }
            }
        }

        return $item;
    }

    public function multiimage($image)
    {
        $return = [];
        if ($image) {
            foreach ($image as $value) {
                $return[] = $this->url . $value;
            }
        } else {
            $return = [];
        }
        return $return;
    }

    public function multifiles($file)
    {
        return $this->url . json_decode($file)[0]->download_link;
    }

    public function response($item, $type = 0)
    {
        if ($type == 1) {
            for ($i = 1; $i <= count($item); $i++) {
                $item[$i] = $this->rules($item[$i]);
            }
        } else {
            $item = $this->rules($item);
        }

        return $item;
    }

    public function rules($item)
    {
        if ($item->image) {
            $item->image = $this->url . $item->image;
        }

        return $item;
    }

}

?>
