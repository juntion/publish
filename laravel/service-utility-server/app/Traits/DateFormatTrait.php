<?php

namespace App\Traits;

use DateTimeInterface;

/**
 * 时间格式化
 */
trait DateFormatTrait
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
