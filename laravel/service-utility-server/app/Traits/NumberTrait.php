<?php


namespace App\Traits;


Trait NumberTrait
{
    static public function findAvailableNumber()
    {
        $prefix = self::PREFIX_STR . date('Ymd');
        for ($i = 0; $i < 10; $i++) {
            $lastTask = static::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))->orderBy('id', 'desc')->first();
            if ($lastTask) {
                $lastNo = substr($lastTask->number, -3);
                $no = $prefix . str_pad((intval($lastNo) + 1), 3, '0', STR_PAD_LEFT);
            } else {
                $no = $prefix . '001';
            }
            // 判断编号是否存在
            if (!self::query()->where('number', $no)->exists()) {
                return $no;
            }
        }
        logger()->warning('生成编号失败');
        return false;
    }
}
