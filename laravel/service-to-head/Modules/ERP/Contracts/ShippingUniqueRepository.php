<?php


namespace Modules\ERP\Contracts;


use Modules\ERP\Entities\ProductsInstockShippingApplyUniqueNumber;

interface ShippingUniqueRepository
{
    /**
     * 存储唯一费用编号
     * @param ProductsInstockShippingApplyUniqueNumber $instockShippingApplyUniqueNumber
     * @return mixed
     */
    public function store(ProductsInstockShippingApplyUniqueNumber $instockShippingApplyUniqueNumber);

    /**
     * @return mixed
     */
    public function showDayCount();
}
