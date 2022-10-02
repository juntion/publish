<?php

namespace App\Support\Data;


class PermissionData
{
    private static $files = [
        'permission/manage/features.json',
        'permission/projectManage/features.json',
        'permission/Company/features.json',
    ];

    public static function getData()
    {
        $data = collect();
        foreach (self::$files as $file) {
            $data = collect(getDataContents($file))->map(function ($item, $group) {
                $tmp = [];
                foreach ($item as $val) {
                    $val['group'] = $group;
                    $val['guard_name'] = $val['guard_name'] ?? config('app.guard');
                    $tmp[] = $val;
                }
                return $tmp;
            })->flatten(1)->merge($data);
        }

        return $data->toArray();
    }
}
