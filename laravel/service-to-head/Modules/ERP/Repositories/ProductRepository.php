<?php

namespace Modules\ERP\Repositories;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Modules\ERP\Entities\Product;

class ProductRepository implements \Modules\ERP\Contracts\ProductRepository
{
    /**
     * @param null $idPrefix
     * @param int $maxCount
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function productLimitList($idPrefix = null, $maxCount = self::MAX_COUNT)
    {
        $query = Product::with(['description' => function (Relation $query) {
            $query->select(['products_id', 'products_name']);
        }])->select(['products_id'])->whereHas('description')->limit($maxCount);

        if ($idPrefix) {
            if (!Str::contains($idPrefix, '%')) {
                $idPrefix = "{$idPrefix}%";
            }
            $query->where('products_id', 'like', $idPrefix);
        }

        return $query->get();
    }
}
