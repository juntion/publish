<?php


namespace Modules\ERP\Contracts;


interface CustomerRepository
{
    /**
     * 根据客户编号获取客户信息
     */
    public static function getCustomerByNumber($number);

    /**
     * 根据客ID获取客户 线上客户
     */
    public static function getCustomerOnByID($customerId);

    /**
     * 根据客ID获取客户 线下客户
     */
    public static function getCustomerOffByID($customerId);

    /**
     * 根据客邮箱获取获取客户 线下客户
     */
    public static function getCustomerOffByEmail($customerEmail);
}
