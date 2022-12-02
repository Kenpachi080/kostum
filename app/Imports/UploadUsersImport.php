<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UploadUsersImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        /*
     0 => "Имя"
    1 => "Телефон"
    2 => "Сумма заказа"
    3 => "Баланс"
         *  */
        foreach ($collection as $data) {
            if ($data[0] == 'Имя') {
                continue;
            }
            User::query()->updateOrCreate(['phone' => $data[1]],
                ['name' => $data[0], 'orders_sum' => $data[2], 'balance' => $data[3]]);
        }
        return response('все ок', 200);
    }

    private function date($row)
    {
        /*
        0 => "Артикул"
        1 => "Название товара"
        2 => "Бренд"
        3 => "Код изображений"
        4 => "Модель"
        5 => "Ссылка на Youtube"
        6 => "Тип"
        7 => "Назначение"
        8 => "Материал"
        9 => "Цвет"
        10 => "Застежка"
        11 => "Отделение для монет"
        12 => "Отделения для карт/визиток"
        13 => "Страна производства"
        14 => "Размеры"
        15 => "Дополнительная информация"
        16 => "Артикул производителя"
        17 => "Цена"
        18 => "Подкатегория продукта"
        19 => "Категории комплектующие"
        20 => "Комплектующие"
        21 => "Остатки"
        22 => "Описание"
        23 => "Конструктор"
        24 => "Конструктор картинка"
        25 => "Конструктор картинка 2"
        26 => "seo_title"
        27 => "seo_description"
        28 => "seo_content"
         */

        if ($row[23] == "Да") {
            $constructor = 1;
        } else {
            $constructor = 0;
        }

        $characteristics = '';
        if ($row[4] != null) {
            $characteristics .= '<p>' . $row[4] . '</p>';
        }
        if ($row[8] != null) {
            $characteristics .= '<p>' . $row[8] . '</p>';
        }
        if ($row[9] != null) {
            $characteristics .= '<p>' . $row[9] . '</p>';
        }

        $description = '<p>' . $row[22] . '</p>';

        $url = "../storage/app/public/products/$row[3]";
        $files = glob("$url/*");
        $files = json_encode(str_replace(['../storage/app/public/'], [''], $files));
        $date = [
            'code' => $row[0],
            'title' => $row[1],
            'video' => $row[5],
            'characteristics' => $characteristics,
            'is_constructor' => $constructor,
            'description' => $description,
            'price' => $row[17],
            'remainder' => $row[21],
            'seo_title' => $row[26],
            'image' => $files,
            'seo_description' => $row[27],
            'seo_content' => $row[28],
        ];

        return $date;
    }
}
