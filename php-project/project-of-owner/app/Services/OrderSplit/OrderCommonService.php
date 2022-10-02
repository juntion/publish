<?php


namespace App\Services\OrderSplit;

use App\Models\OrderTrackInfo;
use App\Services\BaseService;
use App\Services\Customers\CustomerService;

class OrderCommonService extends BaseService
{
    public $allCustomerId = [];

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 根据客户选择的查看公司订单类型 获取所有满足条件的客户ID
     *
     * @param string $company_type company_order:公司订单,person_order:个人订单
     */
    public function getCompanyTypeCustomer($company_type = '')
    {
        //客户选择了查看公司订单类型
        if ($company_type) {
            if ($company_type == 'company_order') {
                $customerService = new CustomerService();
                $this->allCustomerId = $customerService->setField(['customer_link_account'])
                    ->setCustomer()->getCompanyAllCustomers();
            } else {
                $this->allCustomerId = [$this->customer_id];
            }
        } else {
            $this->allCustomerId = [$this->customer_id];
        }
    }

    /**
     * 把订单的orders_total数组重组为关联数组
     * @param array $order_total
     * @return array
     */
    public function createNewOrderTotalInfo($order_total = [])
    {
        $total = [];
        if (!empty($order_total)) {
            foreach ($order_total as $key => $value) {
                $total[$value['class']] = $value;
            }
        }
        return $total;
    }

    /**
     * 根据订单ID和订单状态获取 订单的物流信息
     * @param $orders_id    订单ID
     * @param $order_status 订单状态
     * @return array
     */
    public function getOrderTrackInfo($orders_id, $order_status,$products_instock_id)
    {
        $trackInfo = [];
        if ($order_status == 12 || $order_status = 4) {
            //12[In Transit]运输发货后的状态下 订单才有运单号
            $orderTrack = new OrderTrackInfo();
            if($products_instock_id){
                $trackData = $orderTrack->where('products_instock_id', $products_instock_id)
                    ->select(['shipping_method', 'tracking_number'])
                    ->get();
            }else{
                $trackData = $orderTrack->where('orders_id', $orders_id)
                    ->select(['shipping_method', 'tracking_number'])
                    ->get();
            }
            if (!empty($trackData)) {
                $trackInfo = $trackData->toArray();
            }
        }
        return $trackInfo;
    }
}
