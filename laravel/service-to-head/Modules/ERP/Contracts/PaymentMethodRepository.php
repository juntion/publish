<?php


namespace Modules\ERP\Contracts;


use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface PaymentMethodRepository  extends RepositoryInterface,RepositoryCriteriaInterface
{
    public function getPaymentMethodById($id);

    /**
     * 支付方式
     * @return mixed
     */
    public static function getAllPaymentMethods($type);

    /**
     * 获取指定的付款name
     * @param $id
     * @return mixed
     */
    public function getPaymentMethodName($id);

    /**
     * $type=1 获取真实到款方式 $type=2 获取非真实到款方式
     */
    public static function getPaymentMethodsIDByType($type = 1);
}
