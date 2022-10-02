<?php


namespace Modules\ERP\Contracts;


interface PaymentMethodService
{
    public static function getAllPaymentMethods($type);

    public static function getPaymentMethodName($id);
}
