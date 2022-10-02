<?php


namespace Modules\ERP\Contracts;


interface CustomerCompanyRepository
{
    /**
     * 根据客户编号获取客户公司
     */
    public static function getCompanyByCustomerNumber($customerNumber);

}
