<?php

namespace Modules\ERP\Repositories;

use Illuminate\Support\Carbon;
use Modules\ERP\Contracts\ShippingUniqueRepository as ContractsShippingUniqueRepository;
use Modules\ERP\Entities\ProductsInstockShippingApplyUniqueNumber;

class ShippingUniqueRepository implements ContractsShippingUniqueRepository
{
    /**
     * @inheritDoc
     */
    public function store(ProductsInstockShippingApplyUniqueNumber $instockShippingApplyUniqueNumber)
    {
        $instockShippingApplyUniqueNumber->save();
        return $instockShippingApplyUniqueNumber->refresh();
    }

    /**
     * @return int
     */
    public function showDayCount()
    {
        return ProductsInstockShippingApplyUniqueNumber::query()
            ->where([
                ['create_at', '>', Carbon::today('Asia/shanghai')],
                ['create_at', '<', Carbon::tomorrow('Asia/shanghai')]
            ])
            ->count();
    }

    /**
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function get(array $where)
    {
        return ProductsInstockShippingApplyUniqueNumber::query()
            ->where($where)
            ->first();
    }
}
