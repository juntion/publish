<?php


namespace Modules\ERP\Service;

use Modules\ERP\Contracts\PaymentMethodRepository;
use Modules\ERP\Contracts\PaymentMethodService as ContractPaymentMethod;

class PaymentMethodService implements ContractPaymentMethod
{
    public static function getAllPaymentMethods($type)
    {
        return app()->make(PaymentMethodRepository::class)->getAllPaymentMethods($type);
    }

    public static function getPaymentMethodName($id)
    {
        return app()->make(PaymentMethodRepository::class)->getPaymentMethodName($id);
    }
}
