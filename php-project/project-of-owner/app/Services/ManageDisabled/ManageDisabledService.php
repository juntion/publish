<?php


namespace App\Services\ManageDisabled;

use App\Services\BaseService;
use App\Models\ManageCustomerDisabled;

class ManageDisabledService extends BaseService
{
    private $manageCustomerDisabled; // manage_customer_customers_disabled

    public function __construct()
    {
        parent::__construct();
        $this->manageCustomerDisabled = new ManageCustomerDisabled();
    }

    /**
     * 查询被定义为无效客户的原因
     * @param $customers_number_new
     * @param string[] $fields
     * @return string
     */
    public function getManageCustomerDisabled($customers_number_new, $fields = ['*'])
    {
        $res = $this->manageCustomerDisabled
            ->where('customers_number_new', $customers_number_new)
            ->limit(1)
            ->get($fields)
            ->toArray();
        return $res[0] ? $res[0] :'';
    }
}
