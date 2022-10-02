<?php


namespace Modules\ERP\Contracts;

interface CategoryRepository
{
    const MAX_COUNT = 50;

    public function categoryLimitList($idPrefix = null, $maxCount = self::MAX_COUNT);
}