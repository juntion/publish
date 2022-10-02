<?php

namespace App\Services\Orders;

use App\Models\Country;
use App\Models\CountryTimeZone;
use App\Models\CustomerAppointmentInfo;
use App\Models\OrderCancelRequest;
use App\Models\OrderOvertime;
use App\Models\OrdersStatusHistory;
use App\Models\OrderTrackInfo;
use App\Models\PaymentLink;
use App\Models\ProductInstockOrder;
use App\Services\BaseService;
use App\Services\Customers\CustomerService;
use App\Services\Orders\OrderProductService;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderOnlineOffline;
use App\Models\OrderSplitMerge;
use App\Models\OrderSplit;
use App\Services\OrderSplit\OrderSplitService;
use App\Services\OrderSplit\OrderSplitProductService;
use App\Models\Customer;
use App\Services\Common\Upload\UploadService;
use App\Services\Rma\RmaService;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Exceptions\EachException;
use App\Models\ProductsInstockShipping;
use App\Models\OrderToAdmin;

class OrderService extends BaseService
{
    public $order;     //订单对象
    public $orderSplit; //线下订单对象
    private $orderOnlineOffline; //线上单线下操作
    private $orderSplitMerge; //合发订单操作
    private $orderProduct;      //订单产品对象
    private $customerModel;     //客户对象
    private $paymentLink;   //补款记录对象
    private $statusHistory;
    private $orderProductService;
    public $currentOrder;
    private $allCustomerId = [];
    private $rma;

    /**
     * 默认查询字段
     *
     * @var array
     */
    private $fields = [
        'orders_id',
        'orders_status',
        'orders_number',
        'main_order_id',
        'payment_link'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->order = new Order();
        $this->orderProduct = new OrderProduct();
        $this->statusHistory = new OrdersStatusHistory();
        $this->orderProductService = new OrderProductService();
        $this->customerModel = new Customer();
        $this->paymentLink = new PaymentLink();
        $this->rma = new RmaService();
        $this->orderSplit = new OrderSplit();
        $this->orderOnlineOffline = new OrderOnlineOffline();
        $this->orderSplitMerge = new OrderSplitMerge();

        //设置获取图片的大小
        $this->orderProductService->setImageSize(['size_w'=>180,'size_h'=>180]);
    }

    /**
     * 设置查询字段
     *
     * @param array $field
     * @return $this
     */
    public function setField($field = [])
    {
        if (!is_array($field)) {
            $field = [$field];
        }
        $this->fields = array_merge($this->fields, $field);
        return $this;
    }

    /**
     * 设置当前查询订单
     *
     * @param int $orders_id
     * @param string $orders_number
     * @return $this
     */
    public function setOrder($orders_id = 0, $orders_number = "")
    {
        if ($orders_number) {
            $this->currentOrder = $this->order->select($this->fields)
                ->where('orders_number', $orders_number)
                ->first();
        } else {
            $this->currentOrder = $this->order->select($this->fields)->find($orders_id);
        }
        return $this;
    }

    /**
     * $Notes: 根据订单号和用户邮箱获取订单
     *
     * $author: Quest
     * $Date: 2020/9/15
     * $Time: 16:08
     * @param string $orders_number
     * @param string $customer_eamil
     * @return $this
     */
    public function getOrdersByNmberCustomers($orders_number = '', $customer_eamil = '')
    {
        $this->currentOrder = $this->order->select($this->fields)
            ->where('orders_number', $orders_number)
            ->where('customers_email_address', $customer_eamil)
            ->first();
        return $this;
    }

    /**
     * 订单列表页 获取当前客户的所有订单
     *
     * @param array $param ,接收各种筛选订单的参数
     * customer_type_order：代表公司订单或个人订单，orders_status：订单状态筛选，date_type：下单日期筛选，search：搜索功能
     * @param [] $limit , 每页展示的条数
     * @param bool $is_count , 为true 统计满足条件的订单总数，false获取订单列表
     * @param bool $is_offline 是否查询线下单数据
     * @return mixed
     */
    public function getOrdersList($param = [], $limit = [], $is_count = false, $is_rma = false, $is_offline = false)
    {
        if ($is_count) {
            //统计订单总数
            $orderData = $this->order->whereIn('main_order_id', [0, 1]);
        } else {
            $orderData = $this->order
                ->with(
                    [
                        'orderStatus' => function ($query) {
                            $query->select(['orders_status_name', 'orders_status_id'])
                                ->where('language_id', $this->language_id);
                        },
                        'orderTotal'  => function ($query) {
                            $query->select(['orders_id', 'title', 'text', 'value', 'class'])
                                ->where('class', 'ot_total');
                        },
                        'orderTotalTax' => function ($query) {
                            $query->select(['title', 'text', 'value', 'class', 'orders_id']);
                        }
                    ]
                )
                ->whereIn('main_order_id', [0, 1]);
        }
        //客户选择了查看公司订单类型
        $this->getCompanyTypeCustomer($param['customer_type_order']);
        if (sizeof($this->allCustomerId) > 1) {
            $orderData = $orderData->whereIn('customers_id', $this->allCustomerId);
        } else {
            $orderData = $orderData->where('customers_id', $this->customer_id);
        }
        //执行订单状态查询
        if ($param['orders_status']) {
            if(in_array($param['orders_status'],['shipping','completed','transit'])){
                //这三个状态的订单查找以子单为准
                $statusOrders = $this->getStatusOrders($param['orders_status']);
                if(count($statusOrders)){
                    $orderData = $orderData->whereIn('orders_id',$statusOrders);
                }else{
                    //没有对应状态的订单 直接返回空数组
                    if ($is_count) {
                        return 0;
                    } else {
                        return [];
                    }
                }
            }else{
                switch ($param['orders_status']) {
                    case 'pending':
                        $orderData = $orderData->where('orders_status', 1);
                        break;
                    case 'completed':
                        if ($is_rma) {//售后申请，无子单判断状态,有子单则在子单中判断状态
                            $orderData = $orderData->where(function ($q) {
                                $q->where(['orders_status' => 4, 'main_order_id' => 0])->orWhere('main_order_id', 1);
                            });
                        } else {
                            $orderData = $orderData->where('orders_status', 4);
                        }
                        break;
                    case 'canceled':
                        $orderData = $orderData->where('orders_status', 5);
                        break;
                    case 'purchase':
                        $orderData = $orderData->where('payment_module_code', 'purchase');
                        break;
                    case 'po_num':
                        $orderData = $orderData->whereRaw(
                            '(payment_module_code = "purchase" or purchase_order_num <> "" or customers_po <> "")'
                        );
                        break;
                }
            }
        }
        //订单时间筛选查询
        $dateSqlWhere = $this->getOrderDateTypeSql($param['date_type']);
        if ($dateSqlWhere) {
            $orderData = $orderData->whereRaw($dateSqlWhere);
        }
        //search搜索订单号或者产品ID查询
        if ($param['search']) {
            $searchOrders = $this->getSearchOrders($param['search']);
            if (sizeof($searchOrders)) {
                $orderData = $orderData->whereIn('orders_id', $searchOrders);
            } else {
                //没有搜索到满足条件的订单 直接返回空数组
                if ($is_count) {
                    return 0;
                } else {
                    return [];
                }
            }
        }
        if ($is_count) {
            //统计订单总数
            $ordersInfo = $orderData->count();
        } else {
            $ordersInfo = [];
            $split_main_id = 0;
            $orderData = $orderData
                ->select(
                    [
                        'orders_id',
                        'orders_number',
                        'orders_status',
                        'orders_status as orders_status_id',
                        'date_purchased',
                        'purchase_order_num',
                        'pdf_file',
                        'customers_po',
                        'payment_module_code',
                        'shipping_method',
                        'currency',
                        'currency_value',
                        'is_reissue',
                        'main_order_id',
                        'is_reviewed',
                        'language_code',
                        'warehouse',
                        'is_instock',
                        'delivery_name',
                        'delivery_lastname',
                        'delivery_company',
                        'delivery_street_address',
                        'delivery_suburb',
                        'delivery_city',
                        'delivery_postcode',
                        'delivery_state',
                        'delivery_country',
                        'delivery_country_id',
                        'delivery_telephone',
                        'is_au_gsp',
                    ]
                )
                ->orderBy('orders_id', 'DESC')
                ->offset($limit['start'] ? $limit['start'] : 0)
                ->limit($limit['num'] ? $limit['num'] : 10)
                ->get();
            if (!empty($orderData)) {
                $ordersInfo = $orderData->toArray();
                foreach ($ordersInfo as $key => $orders) {
                    $son_order = [];
                    if ($orders['main_order_id'] == 1) {
                        //主单下有分单
                        $son_order = $this->getSonOrdersInfo($orders['orders_id'], 1, true);
                    } else {
                        //获取拆单数据
                        $splitParam = array(
                            'orders_id' => $orders['orders_id'],
                            'currency' => $orders['currency'],
                            'currency_value' => $orders['currency_value']
                        );
                        $splitOrdersInfo = $this->getSplitOrdersInfoById($splitParam, $is_offline);
                        $orders['is_split_order'] = false;

                        //线上单整单是否拆单
                        if($splitOrdersInfo['is_split_order']){
                            $orders['is_split_order'] = true;
                            $orders['split_order_info'] = $splitOrdersInfo;
                            $ordersInfo[$key]['is_split_order'] = true;
                            $ordersInfo[$key]['split_order_info'] = $splitOrdersInfo;
                            $son_order[] = $orders;
                        } else {
                            //是否选择了新加坡上门安装服务
                            $orders['sg_install_info'] = $this->getOrderSgInstallationInfo($orders);
                            //查找订单的运单号
                            $trackInfo = $this->getOrderTrackInfo($orders['orders_id'], $orders['orders_status']);
                            $orders['orders_track_info'] = $trackInfo;
                            //获取订单状态颜色样式
                            $orders['status_class'] = self::getOrderStatusClass($orders['orders_status']);
                            $loadingReview = false;
                            if($orders['orders_status']==4){
                                $loadingReview = true;
                            }
                            $this->orderProductService->isLoadReview($loadingReview);
                            //查找订单下的产品信息
                            $products = $this->orderProductService
                                ->getOrderProductsInfo(
                                    $orders['orders_id'],
                                    0,
                                    $orders['currency'],
                                    $orders['currency_value'],
                                    $orders['is_au_gsp']
                                );
                            $orders['products'] = $products;
                            $orders['is_payment_link'] = false;
                            $ordersInfo[$key]['is_payment_link'] = false;
                            if (empty($products)) {
                                //没有产品的订单是补款链接订单 查找补款信息
                                $paymentLinkData = $this->getPaymentLinkInfo($orders['orders_id']);
                                $orders['is_payment_link'] = true;
                                $ordersInfo[$key]['is_payment_link'] = true;
                                $orders['payment_link_data'] = $paymentLinkData;
                            }
                            $son_order[] = $orders;
                            // MUX产品
                            $ids = $this->arrayColumnNew($son_order[0]['products'], 'products_id');
                            $arr = array_intersect($ids, $this->mux_products);
                            // 查询订单的历史
                            if (!empty($arr) || $son_order[0]['orders_status']==4) {
                                $son_order[0]['history'] = $this->getAllOrderStatusHistory($son_order[0]['orders_id']);
                            }
                            if (!empty($arr)) {
                                $file = $this->getMuxFile($son_order[0]['orders_id'], $arr);
                                $son_order[0]['file_path'] = $file;
                            }
                            if ($is_offline) {
                                //线上单判断是否存在重录单
                                $son_order[0]['retake_arr'] = [];
                                if ($son_order[0]['orders_status'] == 5) {
                                    $son_order[0]['retake_arr'] = $this->getRetake($son_order[0]['orders_id']);
                                    //判断该订单是否付款
                                    $son_order[0]['is_payment'] = $this->getIsPayment($son_order[0]['orders_id']);
                                }
                                //判断是否存在合发订单
                                $son_order[0]['merge_arr'] = [];
                                if ($son_order[0]['orders_status'] == 12) {
                                    $son_order[0]['merge_arr'] = $this->getSplitMerge($son_order[0]['orders_id']);
                                }
                            }
                            //当前订单是否给退换货入口
                            $son_order[0]['returnRes'] = false;
                            $returnRes = $this->getRmaServiceLimit($son_order[0]);
                            $son_order[0]['returnRes'] = ($returnRes == 2 ? true : false);
                        }
                        if ($ordersInfo[$key]['pdf_file']) {
                            $ordersInfo[$key]['pdf_file'] = self::trans("HTTPS_IMAGE_SERVER")
                                . 'images/' . $ordersInfo[$key]['pdf_file'];
                            $son_order[0]['pdf_file'] = self::trans("HTTPS_IMAGE_SERVER")
                                . 'images/' . $son_order[0]['pdf_file'];
                        }
                    }

                    //重组订单的order total信息
                    $ordersInfo[$key]['order_total'] = $this->createNewOrderTotalInfo($orders['order_total']);
                    $ordersInfo[$key]['order_total_tax'] = $this->createNewOrderTotalInfo($orders['order_total_tax']);
                    $ordersInfo[$key]['son_orders'] = $son_order;
                    $country = new Country();
                    //查找delivery_country国家对应的country_code
                    $delivery_country_code = $country->where('countries_name', 'like', $orders['delivery_country'])
                        ->pluck('countries_iso_code_2');
                    $ordersInfo[$key]['delivery_country_code'] = $delivery_country_code;
                }
            }
        }
        return $ordersInfo;
    }

    /**
     * 获取主单下面的所有子单信息
     * @param $main_order_id 主单id
     * @param $is_au_gsp 是否为澳大利亚税后价
     * @param bool $is_offline 是否需要调用线下单流程
     * @return mixed
     */
    public function getSonOrdersInfo($main_order_id, $discount_rate = 1, $is_offline = false)
    {
        $orderQuery = $this->order
            ->with(
                [
                    'orderStatus' => function ($query) {
                        $query->select(['orders_status_name', 'orders_status_id'])
                            ->where('language_id', $this->language_id);
                    },
                    'orderTotal'  => function ($query) {
                        $query->select(['orders_id', 'title', 'text', 'value', 'class'])->where('class', 'ot_total');
                    },
                    'orderTotalTax' => function ($query) {
                        $query->select(['title', 'text', 'value', 'class', 'orders_id']);
                    }
                ]
            )
            ->where('main_order_id', $main_order_id)
            ->select(
                [
                    'orders_id',
                    'orders_number',
                    'orders_status',
                    'date_purchased',
                    'purchase_order_num',
                    'pdf_file',
                    'customers_po',
                    'payment_module_code',
                    'shipping_method',
                    'currency',
                    'currency_value',
                    'is_reissue',
                    'main_order_id',
                    'is_reviewed',
                    'language_code',
                    'warehouse',
                    'is_instock',
                    'delivery_name',
                    'delivery_lastname',
                    'delivery_company',
                    'delivery_street_address',
                    'delivery_suburb',
                    'delivery_city',
                    'delivery_postcode',
                    'delivery_state',
                    'delivery_country',
                    'delivery_country_id',
                    'delivery_telephone',
                    'customers_remarks',
                    'is_au_gsp',
                ]
            )
            ->get();
        $sonOrder = [];
        if (!empty($orderQuery)) {
            $sonOrder = $orderQuery->toArray();
            foreach ($sonOrder as $key => $value) {
                //获取拆单数据
                $splitParam = array(
                    'orders_id' => $value['orders_id'],
                    'currency' => $value['currency'],
                    'currency_value' => $value['currency_value']
                );
                $splitOrdersInfo = $this->getSplitOrdersInfoById($splitParam, $is_offline);
                $sonOrder[$key]['is_split_order'] = false;
                //线上单分单是否拆单
                if($splitOrdersInfo['is_split_order']){
                    $sonOrder[$key]['is_split_order'] = $splitOrdersInfo['is_split_order'];
                    $sonOrder[$key]['split_order_info'] = $splitOrdersInfo;

                } else {
                    //是否选择了新加坡上门安装服务
                    $sonOrder[$key]['sg_install_info'] = $this->getOrderSgInstallationInfo($value);
                    //查找订单的运单号
                    $trackInfo = $this->getOrderTrackInfo($value['orders_id'], $value['orders_status']);
                    $sonOrder[$key]['orders_track_info'] = $trackInfo;
                    //获取订单状态颜色样式
                    $sonOrder[$key]['status_class'] = self::getOrderStatusClass($value['orders_status']);
                    $loadingReview = false;
                    if($value['orders_status']==4){
                        $loadingReview = true;
                    }
                    $this->orderProductService->isLoadReview($loadingReview);
                    $products = $this->orderProductService
                        ->getOrderProductsInfo(
                            $value['orders_id'],
                            0,
                            $value['currency'],
                            $value['currency_value'],
                            $discount_rate,
                            $value['is_au_gsp']
                        );
                    $sonOrder[$key]['products'] = $products;
                    // MUX产品 查询订单的历史
                    $products_ids = $this->arrayColumnNew($sonOrder[$key]['products'], 'products_id');
                    $products_ids_arr = array_intersect($products_ids, $this->mux_products);
                    if (!empty($products_ids_arr) || $value['orders_status']==4) {
                        $sonOrder[$key]['history'] = $this->getAllOrderStatusHistory($sonOrder[$key]['orders_id']);
                    }
                    if (!empty($products_ids_arr)) {
                        $sonOrder[$key]['history'] = $this->getAllOrderStatusHistory($sonOrder[$key]['orders_id']);
                        $file = $this->getMuxFile($sonOrder[$key]['orders_id'], $products_ids_arr);
                        $sonOrder[$key]['file_path'] = $file;
                    }
                    $sonOrder[$key]['is_payment_link'] = false;
                    if (empty($products)) {
                        //没有产品的订单是补款链接订单 查找补款信息
                        $paymentLinkData = $this->getPaymentLinkInfo($value['orders_id']);
                        $sonOrder[$key]['is_payment_link'] = true;
                        $sonOrder[$key]['payment_link_data'] = $paymentLinkData;
                    }
                    if ($sonOrder[$key]['pdf_file']) {
                        $sonOrder[$key]['pdf_file'] = self::trans("HTTPS_IMAGE_SERVER")
                            . 'images/' . $sonOrder[$key]['pdf_file'];
                    }
                    //重组订单的order total信息
                    $sonOrder[$key]['order_total'] = $this->createNewOrderTotalInfo($value['order_total']);
                    $sonOrder[$key]['order_total_tax'] = $this->createNewOrderTotalInfo($value['order_total_tax']);
                    if ($is_offline) {
                        //线上单判断是否存在重录单
                        $sonOrder[$key]['retake_arr'] = [];
                        if ($value['orders_status'] == 5) {
                            $sonOrder[$key]['retake_arr'] = $this->getRetake($value['orders_id']);
                            //判断该订单是否付款
                            $sonOrder[$key]['is_payment'] = $this->getIsPayment($value['orders_id']);
                        }
                        //判断是否存在合发订单
                        $sonOrder[$key]['merge_arr'] = [];
                        if ($value['orders_status'] == 12) {
                            $sonOrder[$key]['merge_arr'] = $this->getSplitMerge($value['orders_id']);
                        }
                    }
                    $sonOrder[$key]['returnRes'] = false;
                    $returnRes = $this->getRmaServiceLimit($sonOrder[$key]);
                    $sonOrder[$key]['returnRes'] = ($returnRes == 2 ? true : false);
                }
            }
        }
        return $sonOrder;
    }

    /**
     * 订单列表页 获取补款订单 的相关数据
     * @param $orders_id
     * @return mixed
     */
    public function getPaymentLinkInfo($orders_id)
    {
        $paymentLink = new PaymentLink();
        $paymentData = $paymentLink->where('order_id', $orders_id)
            ->select(['order_id', 'reamrk', 'order_num'])
            ->first();
        $paymentInfo = [];
        if (!empty($paymentData)) {
            $paymentInfo = $paymentData->toArray();
        }
        if ($paymentInfo['order_num']) {
            if (strpos($paymentInfo['order_num'], "-") !== false) {
                $origin_order_number = explode("-", $paymentInfo['order_num']);
                $paymentInfo['order_num'] = $origin_order_number[0];
            }
            //判断原单是 线上单 且有产品
            $this->setField(['is_offline'])->setOrder(0, $paymentInfo['order_num']);
            if (!empty($this->currentOrder)) {
                $originOrder = $this->currentOrder->toArray();
                if ($originOrder['is_offline'] != 1) {
                    //线上单 查看该订单是否有产品
                    $num = $this->orderProduct->where('orders_id', $originOrder['orders_id'])->count();
                    if ($num) {
                        $paymentInfo['origin_orders_id'] = $originOrder['orders_id'];
                    }
                }
            }
        }
        return $paymentInfo;
    }

    /**
     * 查找满足搜索结果的所有主单ID
     *
     * @param string $search
     * @return array
     */
    public function getSearchOrders($search)
    {
        $orders_id = [];
        if (empty($this->allCustomerId)) {
            $this->allCustomerId[] = $this->customer_id;
        }
        $searchOrder = $this->order->whereIn('customers_id', $this->allCustomerId);
        preg_match('/^FS[0-9]{6}/', $search, $match);
        if ($match) {
            //订单号搜索
            $searchOrder = $searchOrder
                ->whereRaw(
                    '(orders_number = ? or purchase_order_num = ? or customers_po = ?)',
                    [$search, $search, $search]
                )
                ->select(['orders_id', 'main_order_id'])
                ->get();
            if (!empty($searchOrder)) {
                $searchOrder = $searchOrder->toArray();
                foreach ($searchOrder as $key => $order) {
                    if (in_array($order['main_order_id'], [0, 1])) {
                        //是主单
                        $orders_id[] = $order['orders_id'];
                    } else {
                        //是分订单，则查找其对应的主订单ID
                        $orders_id[] = $order['main_order_id'];
                    }
                }
            }
        } elseif (is_numeric($search) && strlen($search) == 5) {
            //搜索产品id
            $allOrders = $searchOrder
                ->where('main_order_id', '!=', 1)
                //->whereOr('(customers_po = ? or purchase_order_num = ?)', [$search, $search])
                ->lists('main_order_id', 'orders_id');
            if (sizeof($allOrders)) {
                $allOrdersId = array_keys($allOrders);
                $productsOrder = $this->orderProduct->whereIn('orders_id', $allOrdersId)
                    ->where('products_id', $search)
                    ->lists('orders_id');
                if (sizeof($productsOrder)) {
                    foreach ($productsOrder as $key => $id) {
                        if ($allOrders[$id] > 1) {
                            //是分单，则查找其对应的主订单ID
                            $orders_id[] = $allOrders[$id];
                        } else {
                            $orders_id[] = $id;
                        }
                    }
                }
            }
        } else {
            //customers_po 搜索
            $searchOrder = $searchOrder
                ->whereRaw('(customers_po = ? or purchase_order_num = ?)', [$search, $search])
                ->orWhere('customers_remarks', 'like', '%'.$search.'%')
                ->select(['orders_id', 'main_order_id'])
                ->get()->toArray();
            if (!empty($searchOrder)) {
                foreach ($searchOrder as $key => $order) {
                    if (in_array($order['main_order_id'], [0, 1])) {
                        //是主单
                        $orders_id[] = $order['orders_id'];
                    } else {
                        //是分订单，则查找其对应的主订单ID
                        $orders_id[] = $order['main_order_id'];
                    }
                }
            }
            //用型号名搜索
            $allOrders = $this->order->whereIn('customers_id', $this->allCustomerId)
                ->where('main_order_id', '!=', 1)
                ->lists('main_order_id', 'orders_id');
            if (sizeof($allOrders)) {
                $allOrdersId = array_keys($allOrders);
                $productsOrder = $this->orderProduct->whereIn('orders_id', $allOrdersId)
                    ->where('products_model', 'like', '%'.$search.'%')
                    ->lists('orders_id');
                if (sizeof($productsOrder)) {
                    foreach ($productsOrder as $key => $id) {
                        if ($allOrders[$id] > 1) {
                            //是分单，则查找其对应的主订单ID
                            $orders_id[] = $allOrders[$id];
                        } else {
                            $orders_id[] = $id;
                        }
                    }
                }
            }
        }
        return $orders_id;
    }

    /**
     * 查找满足所有对应状态的主单ID
     *
     * @param string $status
     * @return array
     */
    public function getStatusOrders($status)
    {
        $orders_id = [];
        if (empty($this->allCustomerId)) {
            $this->allCustomerId[] = $this->customer_id;
        }
        $statusOrder = $this->order->whereIn('customers_id', $this->allCustomerId);
        switch ($status) {
            case 'shipping':
                $statusOrder = $statusOrder->whereIn('orders_status', [2,8,7,10,11])
                    ->select(['orders_id', 'main_order_id'])
                    ->get();
                break;
            case 'completed':
                $statusOrder = $statusOrder->where('orders_status', 4)
                    ->select(['orders_id', 'main_order_id'])
                    ->get();
                break;
            case 'transit':
                $statusOrder = $statusOrder->where('orders_status', 12)
                    ->select(['orders_id', 'main_order_id'])
                    ->get();
                break;
        }
        if (!empty($statusOrder)) {
            $statusOrder = $statusOrder->toArray();
            foreach ($statusOrder as $key => $order) {
                if (in_array($order['main_order_id'], [0, 1])) {
                    //是主单
                    $orders_id[] = $order['orders_id'];
                } else {
                    //是分订单，则查找其对应的主订单ID
                    $orders_id[] = $order['main_order_id'];
                }
            }
            //去除重复ID
            $orders_id = array_flip($orders_id);
            $orders_id = array_flip($orders_id);
        }
        return $orders_id;
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
     * 获取订单日期筛选条件
     *
     * @param string $date_type
     * @return string
     */
    public function getOrderDateTypeSql($date_type = '')
    {
        $sqlWhere = '';
        switch ($date_type) {
            case 'month':   // Latest Month
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 MONTH)<= date(date_purchased)';
                break;
            case 'three_month':     // Latest 3 Months
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 3 MONTH)<= date(date_purchased)';
                break;
            case 'year':    // Latest Year
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 YEAR)<= date(date_purchased)';
                break;
            case 'one_year_ago':    //One Year Ago
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 YEAR) > date(date_purchased)';
                break;
        }
        return $sqlWhere;
    }

    /**
     * 订单详情页 根据指定的orders_id 获取订单的相关数据
     *
     * @param $order_id
     * @param $is_offline
     * @return mixed
     */
    public function getOrderInfoByOrderId($order_id, $is_offline = false)
    {
        $ordersData = $this->order
            ->with(
                [
                    'orderStatus' => function ($query) {
                        $query->select(['orders_status_name', 'orders_status_id'])
                            ->where('language_id', $this->language_id);
                    },
                    'orderTotal'  => function ($query) {
                        $query->select(['orders_id', 'title', 'text', 'value', 'class']);
                    },
                    'orderTotalTax' => function ($query) {
                        $query->select(['orders_id', 'title', 'text', 'value', 'class']);
                    },
                    'orderFields' => function ($query) {
                        $query->select(['orders_id', 'delivery_ticket_number', 'other_delivery']);
                    }
                ]
            )
            ->where('orders_id', $order_id)
            ->select(
                [
                    'orders_id',
                    'orders_number',
                    'orders_status',
                    'date_purchased',
                    'purchase_order_num',
                    'pdf_file',
                    'customers_po',
                    'customers_remarks',
                    'payment_module_code',
                    'payment_method',
                    'shipping_method',
                    'currency',
                    'currency_value',
                    'is_reissue',
                    'main_order_id',
                    'is_reviewed',
                    'language_code',
                    'warehouse',
                    'is_instock',
                    'delivery_name',
                    'delivery_lastname',
                    'delivery_company',
                    'delivery_street_address',
                    'delivery_suburb',
                    'delivery_city',
                    'delivery_postcode',
                    'delivery_state',
                    'delivery_country',
                    'delivery_country_id',
                    'delivery_telephone',
                    'delivery_company_type',
                    'billing_name',
                    'billing_lastname',
                    'billing_company',
                    'billing_street_address',
                    'billing_suburb',
                    'billing_postcode',
                    'billing_country',
                    'billing_state',
                    'billing_telephone',
                    'billing_tax_number',
                    'billing_city',
                    'billing_company_type',
                    'delivery_tax_number',
                    'customers_id',
                    'is_au_gsp',
                    'd_tel_prefix',
                    'b_tel_prefix',
                ]
            )
            ->first();
        $ordersInfo = [];
        if (!empty($ordersData)) {
            $ordersInfo = $ordersData->toArray();
            //获取客户的折扣率
            $customerService = new CustomerService();
            $discount_rate = $customerService->getCustomerRate();
            $ordersInfo['order_total'] = $this->createNewOrderTotalInfo($ordersInfo['order_total']);
            $ordersInfo['order_total_tax'] = $this->createNewOrderTotalInfo($ordersInfo['order_total_tax']);

            //是否选择了新加坡上门安装服务
            $ordersInfo['sg_install_info'] = $this->getOrderSgInstallationInfo($ordersInfo);
            //销售人员
            $ordersInfo['admin_id'] = $this->getOrderAdmin($order_id);
            if ($ordersInfo['main_order_id'] == 1) {
                $ordersInfo['son_orders'] = $this->getSonOrdersInfo($order_id, $discount_rate, $is_offline);
                //主单的运输方式信息为空 获取子单的
                $ordersInfo['shipping_method'] = $ordersInfo['son_orders'][0]['shipping_method'];
            } else {
                $son_order = $ordersInfo;
                //查找订单的运单号
                $trackInfo = $this->getOrderTrackInfo($ordersInfo['orders_id'], $ordersInfo['orders_status']);
                $son_order['orders_track_info'] = $trackInfo;
                $isReview = false;
                if ($ordersInfo['orders_status']==4) {
                    //详情页已完成的订单 需要给评论入口
                    $isReview = true;
                }
                $this->orderProductService->isLoadReview($isReview);
                $son_order['products'] = $this->orderProductService
                    ->getOrderProductsInfo(
                        $order_id,
                        0,
                        $ordersInfo['currency'],
                        $ordersInfo['currency_value'],
                        $discount_rate,
                        $ordersInfo['is_au_gsp']
                    );
                // MUX start
                $product_ids = $this->arrayColumnNew($son_order['products'], 'products_id');
                $product_ids = array_intersect($product_ids, $this->mux_products);
                // 是否存在MUX产品
                if (!empty($product_ids)) {
                    $file = $this->getMuxFile($son_order['orders_id'], $product_ids);
                    $son_order['file_path'] = $file;
                    $son_order['history'] = $this->getAllOrderStatusHistory($son_order['orders_id']);
                }
                // MUX end
                if ($is_offline) {
                    //线上单判断是否存在重录单
                    $son_order['retake_arr'] = [];
                    if ($ordersInfo['orders_status'] == 5) {
                        $son_order['retake_arr'] = $this->getRetake($ordersInfo['orders_id']);
                    }
                    //判断是否存在合发订单
                    $son_order['merge_arr'] = [];
                    if ($ordersInfo['orders_status'] == 12) {
                        $son_order['merge_arr'] = $this->getSplitMerge($ordersInfo['orders_id']);
                    }
                }
                //当前订单是否给退换货入口
                $son_order['returnRes'] = false;
                $returnRes = $this->getRmaServiceLimit($son_order);
                $son_order['returnRes'] = ($returnRes == 2 ? true : false);
                $ordersInfo['son_orders'][] = $son_order;
                //子单的customers_po客户备注信息需要获取主单的
                if ($ordersInfo['main_order_id'] > 1) {
                    $mainData = $this->getOrdersFieldsInfo($ordersInfo['main_order_id'], ['customers_po']);
                    $ordersInfo['customers_po'] = $mainData['customers_po'];
                }
            }
            //获取订单状态颜色样式
            $ordersInfo['status_class'] = self::getOrderStatusClass($ordersInfo['orders_status']);
            //po number purchase订单显示purchase_order_num 其他订单显示customers_po
            $ordersInfo['po_number_str'] = $ordersInfo['customers_po'];
            if ($ordersInfo['payment_module_code'] == 'purchase') {
                $ordersInfo['po_number_str'] = $ordersInfo['purchase_order_num'];
            }
            if ($ordersInfo['pdf_file']) {
                $ordersInfo['pdf_file'] = self::trans("HTTPS_IMAGE_SERVER")
                    . 'images/' . $ordersInfo['pdf_file'];
            }
            //查找delivery_country国家对应的country_code
            $country = new Country();
            //详情页delivery_country和billing_country都要展示对应小语种的国家名称
            $countryField = self::getCountriesNameFields($this->language_id);
            $deliveryCountryData = $country->where('countries_name', 'like', $ordersInfo['delivery_country'])
                ->select(['countries_iso_code_2', $countryField])
                ->first();
            if (!empty($deliveryCountryData)) {
                $ordersInfo['delivery_country_code'] = $deliveryCountryData->countries_iso_code_2;
                $ordersInfo['delivery_country'] = $deliveryCountryData->$countryField;
            }
            $billingCountryData = $deliveryCountryData;
            if ($ordersInfo['billing_country']!=$ordersInfo['delivery_country']) {
                $billingCountryData = $country->where('countries_name', 'like', $ordersInfo['billing_country'])
                        ->select(['countries_iso_code_2', $countryField])
                        ->first();
            }
            if (!empty($billingCountryData)) {
                $ordersInfo['billing_country'] = $billingCountryData->$countryField;
                $ordersInfo['billing_country_code'] = $billingCountryData->countries_iso_code_2;
            }
            //获取订单付款方式
            $ordersInfo['payment_module_code_str'] = self::zenGetOrderPaymentMethod(
                $ordersInfo['payment_module_code'],
                $ordersInfo['delivery_country_id']
            );
        }
        return $ordersInfo;
    }

    /**
     * 根据订单ID和订单状态获取 订单的物流信息
     * @param $orders_id    订单ID
     * @param $order_status 订单状态
     * @return array
     */
    public function getOrderTrackInfo($orders_id, $order_status)
    {
        $trackInfo = [];
        if ($order_status == 12 || $order_status = 4) {
            //12[In Transit]运输发货后的状态下 订单才有运单号
            $orderTrack = new OrderTrackInfo();
            $trackData = $orderTrack->where('orders_id', $orders_id)
                ->select(['shipping_method', 'tracking_number'])
                ->get();
            if (!empty($trackData)) {
                $trackInfo = $trackData->toArray();
            }
        }
        return $trackInfo;
    }


    /**
     * 判断订单是否可以选择上门安装服务以及 是否已经选择了上门安装
     * @param $orders
     * @return mixed
     */
    public function getOrderSgInstallationInfo($orders)
    {
        $data['is_sg_install'] = false;   //是够允许选择上门安装服务
        $data['sg_install_selected'] = false; //是否已经选择了上门安装服务
        $data['sg_install_data'] = [];
        if ($orders['orders_status'] != 5 && $orders['delivery_country_id'] == 188 && $orders['is_reissue'] == 24) {
            $data['is_sg_install'] = true;
            $appointment = new CustomerAppointmentInfo();
            $applyData = $appointment->with(
                [
                    'caseNumbers' => function ($query) {
                        $query->select(['case_number', 'status']);
                    }
                ]
            )
                ->where('orders_number', $orders['orders_number'])
                ->select(
                    [
                        'case_number',
                        'appointment_start_time',
                        'customer_remark',
                        'customer_remark_file',
                        'appointment_second_type'
                    ]
                )
                ->first();
            if ($applyData) {
                $data['sg_install_selected'] = true;
                $data['sg_install_data'] = $applyData->toArray();
            }
        }
        return $data;
    }

    /**
     * 根据主单ID获取所有的子单ID
     *
     * @param int $main_orders_id
     * @return mixed
     */
    public function getAllSonOrders($main_orders_id = 0)
    {
        $ids = $this->order->where('main_order_id', $main_orders_id)
            ->lists('orders_id');
        return $ids;
    }

    /**
     * 不同状态订单总数统计
     * @param string $type，支持的类型有：pending /progressing/completed/canceled/purchase
     * @return mixed
     */
    public function countOrdersTotalByStatus($type = 'pending')
    {
        switch ($type) {
            case 'pending':
                $orderData = $this->order->where('orders_status', 1);
                break;
            case 'progressing':
                $orderData = $this->order->whereNotIn('orders_status', [1, 4, 5]);
                break;
            case 'completed':
                $orderData = $this->order->where('orders_status', 4);
                break;
            case 'canceled':
                $orderData = $this->order->where('orders_status', 5);
                break;
            case 'purchase':
                $orderData = $this->order
                    ->whereRaw('(payment_module_code = "purchase" or purchase_order_num <> "" or customers_po <> "")');
                break;
            case 'transit':
                $orderData = $this->order->where('orders_status', 12);
                break;
            default:
                $orderData = $this->order->where('orders_status', 1);
                break;
        }
        $num = $orderData->whereIn('main_order_id', [0, 1])
            ->where('customers_id', $this->customer_id)
            ->count();
        return $num;
    }

    /**
     * 根据订单ID查找订单的相关信息
     *
     * @param $orders_id
     * @param array $select
     * @return mixed
     */
    public function getOrdersFieldsInfo($orders_id, $select = ['orders_status', 'main_order_id'])
    {
        $orderData = $this->order->where('orders_id', $orders_id)
            ->select($select)
            ->first();
        $info = [];
        if (!empty($orderData)) {
            $info = $orderData->toArray();
        }
        return $info;
    }

    /**
     * track package 页面订单相关数据
     * @param $orders_id
     * @return mixed
     */
    public function getOrdersTrackPackageInfo($orders_id)
    {
        $ordersData = $this->order
            ->with(['orderStatus' => function ($query) {
                $query->select(['orders_status_id', 'orders_status_name'])
                    ->where('language_id', $this->language_id);
            }])
            ->where('orders_id', $orders_id)
            ->select([
                'orders_id',
                'orders_number',
                'orders_status',
                'date_purchased',
                'payment_module_code',
                'is_reissue',
                'main_order_id',
                'delivery_country'
            ])
            ->first();
        $ordersInfo = [];
        if (!empty($ordersData)) {
            $ordersInfo = $ordersData->toArray();
            //获取订单状态颜色样式
            $ordersInfo['status_class'] = self::getOrderStatusClass($ordersInfo['orders_status']);
            //查找delivery_country国家对应的country_code
            $country = new Country();
            $delivery_country_code = $country->where('countries_name', 'like', $ordersInfo['delivery_country'])
                ->pluck('countries_iso_code_2');
            $ordersInfo['delivery_country_code'] = $delivery_country_code;
            //查找delivery_country国家对应时区
            $timezone = new CountryTimeZone();
            $ordersInfo['delivery_country_zone'] = $timezone->where('code', $delivery_country_code)
                ->pluck('time_zone');
            //查找订单的运单号
            $trackInfo = $this->getOrderTrackInfo($ordersInfo['orders_id'], $ordersInfo['orders_status']);
            $ordersInfo['orders_track_info'] = $trackInfo;
            //查找订单状态更新历史记录
            $ordersInfo['orders_status_history'] = $this->getAllOrderStatusHistory($orders_id);
        }
        return $ordersInfo;
    }

    /**
     * 判断当前订单是否允许申请退换货
     * @param array $orders， 改参数是getOrderInfoByOrderId()函数获取的单个订单的son_orders的一个元素
     * @return bool
     */
    public function getRmaServiceLimit($orders)
    {
        $returnFlag = 0;
        if ($orders['orders_status'] == 4) {
            //完成状态的订单才可以提供 退换货申请入口
            $rmaService = new RmaService();
            foreach ($orders['products'] as $kk => $products) {
                if ($products['composite_son_products']) {
                    //组合产品 针对子产品申请售后
                    $sonProducts = $rmaService
                        ->getCompositeProductsInfo(
                            $products['composite_son_products'],
                            $orders['currency'],
                            $orders['currency_value']
                        );
                    foreach ($sonProducts as $son) {
                        //获取当前子产品已经申请的售后个数
                        $rmaProductNum = $rmaService->getRmaUndoneNumber(
                            $products['orders_products_id'],
                            $son['products_id']
                        );

                        //特殊组合产品只要有售后单未完成,便不能再次申请--已废除,但暂时保留代码
                        if (in_array($products['products_id'], [96375,96376]) && false) {
                            if ($rmaProductNum > 0) {
                                $returnFlag = 1;
                                break;
                            } else {
                                $returnFlag = 2;
                            }
                        } else {
                            if ($son['qty'] - $rmaProductNum > 0) {
                                //当前产品申请售后的个数没有购买产品的总数多 则当前订单还允许申请售后
                                $returnFlag = 2;
                                break;
                            } else {
                                //所有产品都申请了售后,不能进行售后
                                $returnFlag = 1;
                            }
                        }
                    }
                } else {
                    //获取当前产品已经申请的售后个数
                    $rmaProductNum = $rmaService->getRmaUndoneNumber(
                        $products['orders_products_id'],
                        $products['products_id']
                    );
                    if ($products['products_quantity'] - $rmaProductNum > 0) {
                        //当前产品申请售后的个数没有购买产品的总数多 则当前订单还允许申请售后
                        $returnFlag = 2;
                        break;
                    } else {
                        //所有产品都申请了售后,不能进行售后
                        $returnFlag = 1;
                    }
                }
            }
        }
        return $returnFlag;
    }

    /**
     * 判断当前订单客户是否有权限查看
     * @param $orders_id
     * @return bool
     */
    public function checkCustomerVisitOrdersLimit($orders_id = 0)
    {
        $limit = false;
        if ($orders_id) {
            $customer_id = $this->getOrdersFieldsInfo($orders_id, ['customers_id'])['customers_id'];
            $this->getCompanyTypeCustomer('company_order');
            if (in_array($customer_id, $this->allCustomerId)) {
                $limit = true;
            }
        }
        return $limit;
    }

    /**
     * 获取当前订单的所有状态更新记录
     * @param $orders_id
     * @return array
     */
    public function getAllOrderStatusHistory($orders_id)
    {
        $statusData = $this->statusHistory->with(
            [
                'statusName' => function ($query) {
                    $query->select(['orders_status_id', 'orders_status_name'])
                        ->where('language_id', $this->language_id);
                }
            ]
        )
            ->where('orders_id', $orders_id)
            ->where('customer_notified', '>=', '0')
            ->select(['orders_status_id', 'date_added', 'comments', 'admin_id'])
            ->orderBy('date_added', 'desc')
            ->get();

        $statusIds = $statusArray = [];
        if (!empty($statusData)) {
            $statusData = $statusData->toArray();
            foreach ($statusData as $key => $status) {
                if (!in_array($status['orders_status_id'], $statusIds)) {
                    $statusArray[$status['orders_status_id']] = array(
                        'id'                 => $status['orders_status_id'],
                        'date_added'         => $status['date_added'],
                        'orders_status_name' => $status['status_name']['orders_status_name'],
                        'comments'           => $status['comments'],
                        'admin_id'           => $status['admin_id']
                    );
                }
                $statusIds[] = $status['orders_status_id'];
            }
            /**
             * 由于转运单在更新运单号的时候同时触发11[Order Packed]和12[In Transit]状态，
             * 两节点时间一样11对应的状态记录会在12后面，需调整为11操作应该在12前面
             */
            if (in_array(11, $statusIds) && in_array(12, $statusIds)) {
                $packed = $statusArray[11];
                $transit = $statusArray[12];
                $i = $packed_key = $transit_key = 0;
                foreach ($statusArray as $key => $val) {
                    $i++;
                    //找到11和12 在数组中出现的顺序
                    if ($key == 11) {
                        $packed_key = $i;
                    }
                    if ($key == 12) {
                        $transit_key = $i;
                    }
                }
                if ($packed_key < $transit_key) {
                    //11在12后面 需要调整顺序
                    $statusArray[11] = $transit;
                    $statusArray[12] = $packed;
                }
            }
        }
        return $statusArray;
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

    public function getSplitOrdersInfoById($orders_data=[], $is_offline=true){
        $ordersInfo = [];
        $orders_id = $orders_data['orders_id'];
        $currency = $orders_data['currency'];
        $currency_value = $orders_data['currency_value'];
        if($orders_id){
            $split_orders_id = $this->getSplitMain($orders_id);
            $ordersInfo['is_split_main'] = $split_orders_id;
            $ordersInfo['is_split_order'] = false;
            if ($split_orders_id && $is_offline) {
                $ordersInfo['is_split_order'] = true;
                $ordersInfo['orders_split_products'] = [];
                $orderSplitService = new OrderSplitService();
                $son_order = $all_orders = [];
                foreach ($split_orders_id as $oId) {
                    $orderSplit = $orderSplitService->getSonOrdersInfo((int)$oId, 1, true);
                    $all_orders[] = $orderSplit;
                    foreach($orderSplit as $key=>$value){
                        $son_order[] = $value;
                    }
                }
                $ordersInfo['son_orders'] = $son_order;
                $ordersInfo['all_orders'] = $all_orders;
                //获取拆单主id
                $split_main_id =  $this->getSplitMainOId($split_orders_id[0]);
                if ($split_main_id == 0) {
                    //如果为整单
                    $split_main_id = $split_orders_id[0];
                }
                $ordersInfo['split_main_id'] = $split_main_id;
                if (!in_array($split_main_id, [0, 1])) {
                    //获取拆单已推送产品以及数量
                    $split_product_arr = [];
                    if ($son_order) {
                        foreach ($son_order as $val) {
                            foreach ($val['products'] as $pKey => $products) {
                                $split_product_arr[] = [
                                    'products_id' =>  $products['products_id'],
                                    'products_quantity' => $products['products_quantity'],
                                    'products_prid' => $products['products_prid'],
                                ];
                            }
                        }
                    }
                    //线下单拆单未推送的产品补全 start
                    $orderSplitProductService = new OrderSplitProductService();
                    $proIty = $orderSplitProductService->getSplitProduct($split_main_id, $split_product_arr);
                    if ($proIty) {
                        $ordersInfo['orders_split_products'] =
                            $orderSplitProductService
                                ->getOrderProductsInfo(
                                    $split_main_id,
                                    0,
                                    $currency,
                                    $currency_value,
                                    1,
                                    $proIty
                                );
                    }
                    //线下单拆单未推送的产品补全 end
                }
            }
        }
        return $ordersInfo;
    }

    /**
     * 更新orders表数据
     *
     * @param array/int $orders_id 可以传单个订单ID，也可以传多个订单ID数组
     * @param array $orderInfo
     */
    public function updateOrdersInfo($orders_id, $orderInfo = [])
    {
        if (is_array($orders_id)) {
            $this->order->whereIn('orders_id', $orders_id)->update($orderInfo);
        } else {
            $this->order->where('orders_id', $orders_id)->update($orderInfo);
        }
    }

    /**
     * 往订单状态历史 记录表中插入订单状态更新的相关数据
     * @param array $data
     */
    public function createOrderStatusHistoryInfo($data = [])
    {
        $this->statusHistory->insert($data);
    }

    /**
     * 上传po附件 更新订单状态
     * @param $orders_id
     * @param $po_num
     * @param string $fileInput
     * @return array
     */
    public function updatePurchaseOrderFile($orders_id, $po_num, $fileInput = '')
    {
        $upload = new UploadService();
        $photo_dir = 'orderspdf/' . $this->customer_id;
        $upload->setConfig([
            'fileSize'      => '5M',
            'savePath'      => $photo_dir,
            'fileExtension' => [
                'image/png',
                'image/jpg',
                'image/jpeg',
                'application/pdf',
                'text/plain',
                'doc',
                'application/msword',
                'xls',
                'application/vnd.ms-excel',
                'application/vnd.ms-office',
                'docx',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip'
            ]
        ]);
        $bool = $upload->upload($fileInput);
        if ($bool) {
            DB::connection()->beginTransaction();
            try {
                $data = [
                    'pdf_file'           => $upload->storagePath,
                    'orders_status'      => 8,
                    'purchase_order_num' => $po_num
                ];
                $allOrders = $this->getAllSonOrders($orders_id);
                $allOrders[] = $orders_id;
                //更新订单的订单状态以及po附件路径等信息
                $this->updateOrdersInfo($allOrders, $data);
                /**
                 * orders_status_history 表中数据date_added字段的时间之前都是用now()函数生成
                 * 前台mysql数据库的时区是Asia/Shanghai 订单状态更新时间 记录在前台要做本地化展示 需要保持统一
                 */
    //            $add_time = Carbon::now('Etc/GMT');
                $add_time = Carbon::now('Asia/Shanghai');
                //往订单状态历史记录表中插入更新记录
                foreach ($allOrders as $key => $id) {
                    $historyData = array(
                        'orders_id'         => $id,
                        'orders_status_id'  => 8,
                        'date_added'        => $add_time,
                        'customer_notified' => "",
                        'comments'          => "用户提交po附件"
                    );
                    $this->createOrderStatusHistoryInfo($historyData);
                }
                DB::connection()->commit();
                return ['code' => 1, 'path' => $upload->uploadPath, 'errors' => []];
            } catch (\Exception $e) {
                DB::connection()->rollBack();
                return ['code' => 0, 'message' => '', 'error' => $e->getMessage()];
            }
        } else {
            return ['code' => 0, 'message' => '', 'error' => $upload->errors];
        }
    }

    /**
     * 取消订单操作
     * @param $orders_id
     * @param array $reason_data , 数组包含3个元素reason、reason_type、cancel_reason
     * @param int $type, 1是客户点击订单详情页的cancel按钮，2是订单倒计时上线前的旧pending单程序取消
     * @return bool
     */
    public function updateCancelOrderStatus($orders_id, $reason_data = [], $type=1)
    {
        //查看当前订单状态
        $ordersInfo = $this->getOrdersFieldsInfo($orders_id);
        if ($ordersInfo['orders_status']!=1 || !in_array($ordersInfo['main_order_id'], [0,1])) {
            //当前订单状态是pending【1】，且是主单才可以取消按钮
            return false;
        }
        $allOrders = $this->getAllSonOrders($orders_id);
        $allOrders[] = $orders_id;
        DB::connection()->beginTransaction();
        try {
            $orderData = ['orders_status' => 5];
            //更新订单状态为取消
            $this->updateOrdersInfo($allOrders, $orderData);
            /**
             * orders_status_history 表中数据date_added字段的时间之前都是用now()函数生成
             * 前台mysql数据库的时区是Asia/Shanghai 订单状态更新时间 记录在前台要做本地化展示 需要保持统一
             */
            $add_time = Carbon::now('Asia/Shanghai');
            $cancelRequest = new OrderCancelRequest();
            $history_common = "用户手动取消订单";
            if($type!=1){
                $history_common = "order is canceled by system automatically for timeout unpaid 处理人:system";
            }
            // 取消订单的详情信息
            foreach ($allOrders as $key => $id) {
                $reason_data['orders_id'] = $id;
                $reason_data['languages_id'] = $this->language_id;
                $reason_data['request_date'] = $add_time;
                //插入取消订单申请记录表中
                $cancelRequest->insert($reason_data);

                //添加订单状态流程的取消流程
                $historyData = array(
                    'orders_id'         => $id,
                    'orders_status_id'  => 5,
                    'date_added'        => $add_time,
                    'customer_notified' => "",
                    'comments'          => $history_common
                );
                $this->createOrderStatusHistoryInfo($historyData);
            }
            //恢复前台的库存锁定
            $instockOrder = new ProductInstockOrder();
            $instockOrder->whereIn('orders_id', $allOrders)->delete();

            //删除提醒和自动取消邮件
            $overtimeObj = new OrderOvertime();
            $overtimeObj->where('orders_id', $orders_id)->delete();
            DB::connection()->commit();
            return true;
        } catch (\Exception $e) {
            DB::connection()->rollBack();
            return false;
        }
    }

    /**
     * 根据订单id 查询所有关联主单和分单id
     * ['main'=> '主单id','son'=>[分单id]]
     *
     * @param bool $isFormat 是否以['main'=> '主单id','son'=>[分单id]] 格式返回 否则[]
     * @param int $orders_id
     * @return array
     */
    public function getAllOrdersIdByOrderId($orders_id = 0, $isFormat = true)
    {
        if (empty($orders_id)) {
            return [];
        }
        $currentOrder = $this->order->select(['orders_id', 'main_order_id'])->find($orders_id);
        $data = [];
        if (!empty($currentOrder)) {
            $mainOrderId = $currentOrder->main_order_id;
            $oid = $currentOrder->orders_id;
            //如果是主单，查出所有分单
            if ($mainOrderId == 1) {
                $son = $this->order->select('orders_id')->where('main_order_id', $orders_id)->get();
                if (!empty($son)) {
                    $son = $son->toArray();
                    foreach ($son as $v) {
                        $data['son'][] = $v['orders_id'];
                    }
                    $data['main'] = $orders_id;
                }
            } elseif ($mainOrderId > 1) {
                //如果是分单
                $mainOrderId = $this->order->select('orders_id')->find($mainOrderId);
                if (!empty($mainOrderId)) {
                    $data['main'] = $mainOrderId->orders_id;
                    //查出所有关联的分担id
                    $son = $this->order->select('orders_id')->where('main_order_id', $mainOrderId->orders_id)->get();
                    if (!empty($son)) {
                        $son = $son->toArray();
                        foreach ($son as $v) {
                            $data['son'][] = $v['orders_id'];
                        }
                    }
                }
            } else {
                //本身自成一单
                $data = [
                    'main' => '',
                    'son'  => [$orders_id]
                ];
            }
        }
        if (!$isFormat) {
            $format = [];
            foreach ($data as $k => $item) {
                if (!empty($item)) {
                    if ($k == 'son') {
                        foreach ($item as $vv) {
                            $format[] = $vv;
                        }
                    } else {
                        $format[] = [$item];
                    }
                }
            }
            $data = $format;
        }
        return $data;
    }

    /**
     * @param $orders_id
     * @param $type , type=1代表是客户自己在点击确认收货，type=2是自提订单在发货后自动收货
     * @return bool
     */
    public function updateReceiptConfirmOrderStatus($orders_id, $type = 1)
    {
        $all_orders_id = [];    //需要更新状态为已完成的所有订单ID
        $main_order_id = $this->currentOrder->main_order_id;
        //该订单关联的其他子单（除了当前订单）是否全部已收货
        if (!in_array($main_order_id, array(0, 1))) {
            //统计主单下除了当前分单的其他分单未完成的分单个数
            $num = $this->order->where('main_order_id', $main_order_id)
                ->where('orders_id', '!=', $orders_id)
                ->where('orders_status', '!=', 4)
                ->count();
            if (!$num) {
                //主单下的其他子单已经全部确认收货 则需要把主单状态也更新为已完成
                $all_orders_id[] = $main_order_id;
            }
        }
        $all_orders_id[] = $orders_id;
        DB::connection()->beginTransaction();
        try {
            $orderData = array(
                'orders_status' => 4,
                'mark'          => 0
            );
            //更新订单状态为已完成
            $this->updateOrdersInfo($all_orders_id, $orderData);

            /**
             * orders_status_history 表中数据date_added字段的时间之前都是用now()函数生成
             * 前台mysql数据库的时区是Asia/Shanghai 订单状态更新时间 记录在前台要做本地化展示 需要保持统一
             */
            $add_time = Carbon::now('Asia/Shanghai');
            $comment = '用户手动确认收货';
            if ($type != 1) {
                $comment = '自提订单详情页In Transit状态自动确认收货';
            }
            //往订单状态历史记录表中插入数据
            foreach ($all_orders_id as $key => $id) {
                //添加订单状态流程的取消流程
                $historyData = array(
                    'orders_id'         => $id,
                    'orders_status_id'  => 4,
                    'date_added'        => $add_time,
                    'customer_notified' => "",
                    'comments'          => $comment
                );
                $this->createOrderStatusHistoryInfo($historyData);
            }
            DB::connection()->commit();
            return true;
        } catch (\Exception $e) {
            DB::connection()->rollBack();
            return false;
        }
    }

    /**
     * 获取订单
     * @param array $orderParam
     * @param bool $is_count
     * @return mixed
     */
    public function getOrdersListAllStatus($orderParam, $is_count = false)
    {

        $sql = 'SELECT o.orders_id, o.main_order_id, o.currency, o.currency_value, 
                o.orders_status, o.orders_number, o.date_purchased, o.is_au_gsp, 
                ot.text as order_total, otx.text as order_total_tax,o.customers_po FROM orders o';
        if ($is_count) {
            $sql = 'SELECT COUNT(o.orders_id) as count FROM orders o';
        }
        $sql .= ' LEFT JOIN orders d ON o.orders_id = d.main_order_id AND o.main_order_id = 1';
        $sql .= ' LEFT JOIN orders_total ot ON o.orders_id = ot.orders_id AND ot.class = "ot_subtotal"';
        $sql .= ' LEFT JOIN orders_total_tax otx ON o.orders_id = otx.orders_id AND otx.class = "tax_subtotal"';
        $sql .= " WHERE o.customers_id = '{$this->customer_id}'";
        $sql .= ' AND ((o.main_order_id = 0 AND o.orders_status = 4) OR ';
        $sql .= ' (o.main_order_id = 1 AND d.orders_status = 4))';
        if (isset($orderParam['date_type']) && !empty($orderParam['date_type'])) {
            $date_str = $this->getDateTypeFormatSql($orderParam['date_type'], 'o.date_purchased');
            if (!empty($date_str)) {
                $sql .= ' AND ' . $date_str;
            }
        }

        if (isset($orderParam['search']) && !empty($orderParam['search'])) {
            $orders_where = $this->getSearchOrders($orderParam['search']);
            if (!empty($orders_where)) {
                $orders_where_str = implode($orders_where, ',');
                $sql .= ' AND (o.orders_id IN (' . $orders_where_str . ') 
            OR d.orders_id IN (' . $orders_where_str . '))';
            } else {
                //查询数据为空
                return $is_count ? 0 : [];
            }
        }

        $sql .= " GROUP BY o.orders_id";
        if (!$is_count) {
            $offect = 0;
            if (isset($orderParam['page']) && !empty($orderParam['page'])) {
                $offect = ((int)$orderParam['page'] - 1) * 10;
            }
            $sql .= " ORDER BY o.orders_id DESC limit {$offect},10";
        }

        $orders_list = DB::connection()->select($sql);
        if ($is_count) {
            return count($orders_list);
        }

        foreach ($orders_list as $key => $orders) {
            if ($orders['main_order_id'] == 1) {
                //分单情况
                $son_orders_arr = $this->getSonOrdersInfo($orders['orders_id']);
                $orders_list[$key]['son_orders'] = $son_orders_arr;

                foreach ($son_orders_arr as $so_key => $son_orders) {
                    $is_show_rma = false;
                    $last_rma_arr = [];
                    $son_orders_id = $son_orders['orders_id'];
                    $rma_bool = $this->getRmaServiceLimit($son_orders);
                    if ($rma_bool == 2) {
                        $is_show_rma = true;
                    } elseif ($rma_bool == 1) {
                        $last_rma_arr = $this->rma->getRmaRequestRelate(
                            $son_orders_id,
                            ['customers_service_id','service_number'],
                            'customers_service_id',
                            'DESC'
                        );
                    }

                    //获取订单状态颜色样式
                    $orders_list[$key]['son_orders'][$so_key]['status_class'] =
                        $this->getOrderStatusClass($son_orders['orders_status']);

                    $orders_list[$key]['son_orders'][$so_key]['is_show_rma'] = $is_show_rma;
                    $orders_list[$key]['son_orders'][$so_key]['last_rma'] = $last_rma_arr;

                    //查找订单的运单号
                    $trackInfo = $this->getOrderTrackInfo($son_orders['orders_id'], $son_orders['orders_status']);
                    $orders_list[$key]['son_orders'][$so_key]['orders_track_info'] = $trackInfo;
                }
            } else {
                //查找订单下的产品信息
                $products = $this->orderProductService
                    ->getOrderProductsInfo(
                        $orders['orders_id'],
                        0,
                        $orders['currency'],
                        $orders['currency_value'],
                        1,
                        $orders['is_au_gsp']
                    );
                $orders['products'] = $products;
                //改造数组,避免html结构繁杂
                $orders_arr = [0 => $orders];
                $orders_list[$key]['son_orders'] = $orders_arr;

                $is_show_rma = false;
                $last_rma_arr = [];
                $rma_bool = $this->getRmaServiceLimit($orders);
                if ($rma_bool == 2) {
                    $is_show_rma = true;
                } elseif ($rma_bool == 1) {
                    $last_rma_arr = $this->rma->getRmaRequestRelate(
                        $orders['orders_id'],
                        ['customers_service_id','service_number'],
                        'customers_service_id',
                        'DESC'
                    );
                }

                //获取订单状态颜色样式
                $orders_list[$key]['son_orders'][0]['status_class'] =
                    $this->getOrderStatusClass($orders['orders_status']);
                $orders_list[$key]['son_orders'][0]['is_show_rma'] = $is_show_rma;
                $orders_list[$key]['son_orders'][0]['last_rma'] = $last_rma_arr;

                //查找订单的运单号
                $trackInfo = $this->getOrderTrackInfo($orders['orders_id'], $orders['orders_status']);
                $orders_list[$key]['son_orders'][0]['orders_track_info'] = $trackInfo;
            }
        }
        return $orders_list;
    }

    /**
     * @param $order_id 订单id
     * @param $product_ids 产品id
     * @return array|string
     */
    public function getMuxFile($order_id, $product_ids)
    {
        if (is_array($product_ids)) {
            $where = 'whereIn';
            $fields = ['storage_name', 'file_path', 'products_id'];
        } else {
            $where = 'where';
            $fields = [
                'products_instock_shipping_test_report_file.products_instock_id',
                'file_name',
                'storage_name',
                'file_path',
                'products_id',
            ];
        }
        $products_instock_shipping = new ProductsInstockShipping();
        $file = $products_instock_shipping
            ->leftJoin(
                'products_instock_shipping_test_report_file',
                'products_instock_shipping.products_instock_id',
                '=',
                'products_instock_shipping_test_report_file.products_instock_id'
            )
            ->where('products_instock_shipping.orders_id', $order_id)
            ->$where('products_instock_shipping_test_report_file.products_id', $product_ids)
            ->get($fields)->toArray();
        if (!empty($file)) {
            $file_zip = [];
            if (is_array($product_ids)) {
                $pdf_name = $this->arrayColumnNew($file, 'storage_name', 'products_id');
                $pdf_path = $this->arrayColumnNew($file, 'file_path', 'products_id');
                foreach ($pdf_name as $k => $v) {
                    $file_zip[$k] = $pdf_path[$k] . $v;
                }
            } else {
                $mux_path = [];
                $file_zip = [];
                foreach ($file as $k => $v) {
                    $mux_path[$v['file_name']]['path'] = 'upload/' . $v['file_path'] . '/' . $v['storage_name'];
                    $mux_path[$v['file_name']]['storage_name'] = $v['storage_name'];
                    $mux_path['products_instock_id'] = $v['products_instock_id'];
                    $mux_path['products_id'] = $v['products_id'];
                    $file_zip = $mux_path;
                }
            }
        } else {
            $file_zip = '';
        }
        return $file_zip;
    }


    /*获取订单对应的销售人员
     * @param $order_id 订单id
     *
     * */
    public function getOrderAdmin($order_id)
    {
        $admin_id = '';
        if ($order_id) {
            $orderToAdmin  = new OrderToAdmin();
            $admin_info = $orderToAdmin
                ->select('admin_id')
                ->where('orders_id', $order_id)
                ->first();
            if ($admin_info) {
                $admin_data = $admin_info->toArray();
                $admin_id = $admin_data['admin_id'];
            }
        }
        return $admin_id;
    }

    /*获取线上单是否拆单
    * @param $order_id 订单id
    * @return array $split_orders_id
    * */
    public function getSplitMain($order_id)
    {
        $split_orders_id = [];
        if ($order_id) {
            $info = $this->orderOnlineOffline
                ->select('orders_split_id')
                ->where('orders_id', $order_id)
                ->where('type', 1)
                ->get();
            if (!empty($info)) {
                $data =  $info->toArray();
                foreach ($data as $val) {
                    $split_orders_id[] = $val['orders_split_id'];
                }
            }
        }
        return $split_orders_id;
    }

    /*
    * @param int $pId
    * @param array $select
    * @return array $order_data
    * */
    public function getSplitOId($pId, $select = ['orders_id'])
    {
        $order_data = [];
        if ($pId) {
            $order_info = $this->orderSplit
                ->select($select)
                ->where('products_instock_id', $pId)
                ->first();
            if ($order_info) {
                $order_data = $order_info->toArray();
            }
        }
        return $order_data;
    }

    /*
     * 获取线上单线下拆单主id
    * @param int $orders_id
    * @return int $split_main_id
    * */
    public function getSplitMainOId($orders_id)
    {
        $split_main_id = 0;
        if ($orders_id) {
            $order_info = $this->orderSplit
                ->select(
                    [
                        'split_main_id'
                    ]
                )
                ->where('orders_id', $orders_id)
                ->first();
            if ($order_info) {
                $order_data = $order_info->toArray();
                $split_main_id = $order_data['split_main_id'];
            }
        }
        return $split_main_id;
    }

    /*
     * 获取线上单是否重录
    * @param int $orders_id
    * @return array $order_data
    * */
    public function getRetake($orders_id)
    {
        $order_data = [];
        if ($orders_id) {
            $order_info = $this->orderOnlineOffline
                ->select(
                    [
                        'orders_split_id',
                        'orders_number'
                    ]
                )
                ->where('orders_id', $orders_id)
                ->where('type', 2)
                ->first();
            if ($order_info) {
                $order_data = $order_info->toArray();
            }
        }
        return $order_data;
    }

    /* 获取所有合发订单
    * @param int $order_id
    * @param array $select
    * @param int $type 1代表线上单，2代表线下单
    * @return array $order_data
    * */
    public function getSplitMerge($order_id, $select = ['orders_id'], $type=1)
    {
        $order_data = [];
        if ($order_id) {
            $order_info = $this->orderSplitMerge
                ->select($select)
                ->where('shipping_method_merge', function ($query) use ($order_id, $type) {
                    $query->select('shipping_method_merge')
                    ->from('orders_split_merge')
                    ->where('orders_id', $order_id)
                    ->where('type', $type)
                    ->limit(1);
                })->get();
            if ($order_info) {
                $order_data = $order_info->toArray();
            }
        }
        return $order_data;
    }

    /* 获取订单是否付款
    * @param int $order_id
    * @return bool $is_payment
    * */
    public function getIsPayment($order_id)
    {
        $is_payment = false;
        if ($order_id) {
            $statusNum = $this->statusHistory
                ->where('orders_id', $order_id)
                ->where('orders_status_id', 2)
                ->count();
            if ($statusNum) {
                $is_payment = true;
            }
        }
        return $is_payment;
    }

    /**
     * $Notes: 根据主单id获取子单信息
     *
     * $author: Quest
     * $Date: 2020/12/28
     * $Time: 10:44
     * @param $main_order_id
     * @return array
     */
    public function getSonOrdersByMainOrders($main_order_id)
    {
        $res = $this->order->select(['orders_id', 'orders_number'])->where('main_order_id', $main_order_id)->get();
        if(!$res->isEmpty()){
            return $res->toArray();
        }else{
            return [];
        }
    }
}
