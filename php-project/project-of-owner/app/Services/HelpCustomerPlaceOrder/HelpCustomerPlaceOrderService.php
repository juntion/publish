<?php


namespace App\Services\HelpCustomerPlaceOrder;

use App\Services\BaseService;
use App\Models\CustomerTaxSale;

/**
 * 帮客户下单
 *
 *
 * Class HelpCustomerPlaceOrderService
 * @package App\Services\HelpCustomerPlaceOrder
 */
class HelpCustomerPlaceOrderService extends BaseService
{
    private $customerTaxSale;

    public function __construct()
    {
        parent::__construct();
        $this->customerTaxSale = new CustomerTaxSale();
    }


    /**
     * 判断是否为有效的销售账号
     *
     * @param string $email
     * @return bool
     */
    private function isValidateSaleEmail()
    {
        $email = $this->customer_email;
        if (empty($email)) {
            return false;
        }
        $ext = substr($email, strpos($email, "@"));
        $ext_arr = array("@szyuxuan.com", "@feisu.com", "@fs.com");
        if (in_array($ext, $ext_arr)) {
            return true;
        }
        return false;
    }


    /**
     * 根据 销售customer code获取关联客户
     * 如果没有 绑定关联则用原始customerCode
     *
     * @param int $customerCode
     * @return int
     */
    public function getRelatedCustomerCode($customerCode = 0)
    {
        $isValidateSaleEmail = $this->isValidateSaleEmail();
        if (empty($customerCode)) {
            return 0;
        }
        if (!$isValidateSaleEmail) {
            return $customerCode;
        }
        try {
            $data = $this->customerTaxSale->select('customers_number_new')
                ->where('sale_number_new', $customerCode)->first();
            if (!empty($data)) {
                $customerCode = $data->customers_number_new;
            }
        } catch (\Exception $e) {
            return $customerCode;
        }
        return $customerCode;
    }
}
