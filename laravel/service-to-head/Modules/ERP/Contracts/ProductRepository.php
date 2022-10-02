<?php


namespace Modules\ERP\Contracts;

interface ProductRepository
{
    const MAX_COUNT = 50;

    public function productLimitList($idPrefix = null, $maxCount = self::MAX_COUNT);
}