<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository as ContractsProductsInstockShippingApplyRepository;
use Modules\ERP\Entities\ProductsInstockShippingApply;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductsInstockShippingApplyRepository extends BaseRepository implements ContractsProductsInstockShippingApplyRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return ProductsInstockShippingApply::class;
    }

    public function store($applyData)
    {
        $store = $this->create($applyData->toArray());
        return $store->refresh();
    }

    public static function getShippingApplyInfo($where)
    {
        return ProductsInstockShippingApply::where($where)->orderBy('id', 'desc')->first();
    }
}
