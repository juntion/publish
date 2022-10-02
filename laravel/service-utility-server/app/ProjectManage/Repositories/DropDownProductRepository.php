<?php

namespace App\ProjectManage\Repositories;

use App\ProjectManage\Models\Product;

class DropDownProductRepository
{
    /**
     * @param int $type
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByType($type = 0)
    {
        return Product::query()
            ->select(['id', 'name', 'status', 'description', 'type', 'parent_id'])
            ->where('type', $type)
            ->get();
    }
}
