<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2021-03-26
 * Time: 18:55
 */

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\PaymentRelateOrdersRepository as ContractsPaymentRelateOrdersRepository;
use Modules\ERP\Entities\PaymentRelateOrders;
class PaymentRelateOrdersRepository implements ContractspaymentRelateOrdersRepository
{
    public function createByModel(PaymentRelateOrders $paymentRelateOrders){
        if ($paymentRelateOrders->exists) return $paymentRelateOrders;
        $paymentRelateOrders->save();
        $paymentRelateOrders->refresh();
        return $paymentRelateOrders;
    }
}