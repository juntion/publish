<?php

namespace App\Support\Data;


class PageData
{
    private static $files = [
        'permission/manage/pages.json',
        'permission/projectManage/pages.json',
        'permission/Company/pages.json',
    ];

    public static function getData()
    {
        $data = collect();

        foreach (self::$files as $file) {
            $pages = getDataContents($file);
            foreach ($pages as $item) {
                $item['guard_name'] = $item['guard_name'] ?? config('app.guard');
            }
            $data = $data->merge($pages);
        }

        return $data->toArray();
    }
}
