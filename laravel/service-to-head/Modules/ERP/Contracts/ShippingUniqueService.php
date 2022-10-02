<?php
namespace Modules\ERP\Contracts;

/**
 * 申请唯一费用编号
 * Interface ShippingUniqueService
 * @package Modules\ERP\Contracts
 */
interface ShippingUniqueService
{
    /**
     * @param string $prefix
     * @param string $number
     * @param int $count
     * @return mixed
     */
    public function factory($prefix = 'Fy', $number = '', $count = 0);

}
