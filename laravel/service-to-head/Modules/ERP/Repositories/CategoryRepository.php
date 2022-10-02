<?php

namespace Modules\ERP\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Modules\ERP\Entities\Category;

class CategoryRepository implements \Modules\ERP\Contracts\CategoryRepository
{
    /**
     * @param null $idPrefix
     * @param int $maxCount
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function categoryLimitList($idPrefix = null, $maxCount = self::MAX_COUNT)
    {
        $query = Category::with(['description' => function (Relation $query) {
            $query->select(['categories_id', 'categories_name']);
        }])->select(['categories_id'])->whereHas('description')->limit($maxCount);

        if ($idPrefix) {
            if (!Str::contains($idPrefix, '%')) {
                $idPrefix = "{$idPrefix}%";
            }
            $query->where('categories_id', 'like', $idPrefix);
        }

        return $query->get();
    }
}
