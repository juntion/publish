<?php

namespace Modules\ERP\Contracts;

use Modules\ERP\Entities\ProductsInstockShipping;

interface OrderService
{

    /**
     * 获取订单到款方式
     * @param string $paymentModuleCode
     * @param string $currency
     * @param string $flagCountries
     * @return mixed
     */
    public static function getOrdersPaymentMethod(string $paymentModuleCode = 'paypal', string $currency = 'USD', string $flagCountries = '');

    /**
     * 获取存款单数据
     * @return mixed
     */
    public function getOrdersDepositData();

    /**
     * 获取支付信息
     * @param $paymentInfo
     * @return mixed
     */
    public static function getGlobalcollectPaymentInfo($paymentInfo): array;

    /**
     * 根据订单信息判断订单是否可支出
     */
    public function checkOrder($orderNumber);

    /**
     * 根据订单信息查验订单是否已结清
     *
     * @param ProductsInstockShipping $instockShipping
     */
    public function checkOrderPaid(ProductsInstockShipping $instockShipping, &$orderTotal);
}
