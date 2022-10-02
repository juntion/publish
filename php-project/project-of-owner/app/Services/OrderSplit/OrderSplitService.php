<?php


namespace App\Services\OrderSplit;

use App\Models\Country;
use App\Models\CountryTimeZone;
use App\Models\OrderSplitProduct;
use App\Models\OrderSplitToAdmin;
use App\Models\OrderTrackInfo;
use App\Models\PaymentLink;
use App\Models\ProductsInstockShipping;
use App\Services\BaseService;
use App\Models\OrderSplit;
use App\Services\Customers\CustomerService;
use App\Services\OrderSplit\OrderCommonService;
use App\Services\OrderSplit\OrderSplitProductService;
use App\Services\Orders\OrderService;
use App\Services\Rma\RmaService;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class OrderSplitService extends BaseService
{
    public $orderSplit;
    public $currentOrder;
    private $orderProduct;      //订单产品对象
    private $orderSplitProductService;
    private $orderCommonService;
    private $orderService;

    /**
     * 默认查询字段
     *
     * @var array
     */
    private $fields = [
        'orders_id',
        'products_instock_id',
        'orders_status',
        'orders_number',
        'split_main_id',
        'payment_link'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->orderSplit = new OrderSplit();
        $this->orderProduct = new OrderSplitProduct();
        $this->orderSplitProductService = new OrderSplitProductService();
        $this->orderCommonService = new OrderCommonService();
        $this->orderService = new OrderService();
        $this->orderSplitToAdmin = new OrderSplitToAdmin();

        //设置获取图片的大小
        $this->orderSplitProductService->setImageSize(['size_w'=>180,'size_h'=>180]);
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
            $this->currentOrder = $this->orderSplit->select($this->fields)
                ->where('orders_number', $orders_number)
                ->first();
        } else {
            $this->currentOrder = $this->orderSplit->select($this->fields)->find($orders_id);
        }
        return $this;
    }

    /**
     * 判断当前订单客户是否有权限查看
     * @param $orders_id
     * @return bool
     */
    public function setCustomerVisit($orders_id = 0)
    {
        $limit = false;
        if ($orders_id) {
            $customer_id = $this->getOrdersFieldsInfo($orders_id, ['customers_id'])['customers_id'];
            $this->orderCommonService->getCompanyTypeCustomer('company_order');
            if (in_array($customer_id, $this->orderCommonService->allCustomerId)) {
                $limit = true;
            }
        }
        return $limit;
    }

    /**
     * 根据订单ID查找订单的相关信息
     *
     * @param $orders_id
     * @param array $select
     * @return mixed
     */
    public function getOrdersFieldsInfo($orders_id, $select = ['orders_status', 'split_main_id'])
    {
        $orderData = $this->orderSplit->where('orders_id', $orders_id)
            ->select($select)
            ->first();
        $info = [];
        if (!empty($orderData)) {
            $info = $orderData->toArray();
        }
        return $info;
    }


    /**
     * 获取主单下面的所有子单信息
     * @param int $split_main_id 主单id
     * @param int $discount_rate
     * @param bool $ajaxPopup
     * @return mixed
     */
    public function getSonOrdersInfo($split_main_id, $discount_rate = 1, $ajaxPopup = false)
    {
        if ($ajaxPopup) {
            $whereId = 'orders_id';
        } else {
            $whereId = 'split_main_id';
        }
        $orderQuery = $this->orderSplit
            ->with(
                [
                    'orderStatus' => function ($query) {
                        $query->select(['orders_status_name', 'orders_status_id'])
                            ->where('language_id', $this->language_id);
                    }
                ]
            )
            ->where($whereId, $split_main_id)
            ->select(
                [
                    'orders_id',
                    'split_main_id',
                    'products_instock_id',
                    'is_offline',
                    'is_retake',
                    'retake_id',
                    'retake_number',
                    'is_pi_order',
                    'shipping_method_merge',
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
                    'language_code',
                    'warehouse',
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
                    'customers_remarks',
                ]
            )->get();

        $sonOrder = [];
        if (!empty($orderQuery)) {
            $sonOrder = $orderQuery->toArray();
            foreach ($sonOrder as $key => $value) {
                //是否选择了新加坡上门安装服务
                //$sonOrder[$key]['sg_install_info'] = $this->getOrderSgInstallationInfo($value);
                //查找订单的运单号
                $trackInfo = $this->orderCommonService->getOrderTrackInfo($value['orders_id'], $value['orders_status'],$value['products_instock_id']);
                $sonOrder[$key]['orders_track_info'] = $trackInfo;
                //获取订单状态颜色样式
                $sonOrder[$key]['status_class'] = self::getOrderStatusClass($value['orders_status']);
                $products = $this->orderSplitProductService
                    ->getOrderProductsInfo(
                        $value['orders_id'],
                        0,
                        $value['currency'],
                        $value['currency_value'],
                        $discount_rate
                    );
                $sonOrder[$key]['products'] = $products;
                // MUX产品 查询订单的历史
                $products_ids = $this->arrayColumnNew($sonOrder[$key]['products'], 'products_id');
                $products_ids_arr = array_intersect($products_ids, $this->mux_products);
                if (!empty($products_ids_arr)) {
                    // $sonOrder[$key]['pdf_file']
                    //$sonOrder[$key]['history'] = $this->getAllOrderStatusHistory($sonOrder[$key]['orders_id']);
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
                //重组订单的order total信息
                $sonOrder[$key]['order_total'] = $this->orderCommonService->createNewOrderTotalInfo($value['order_total']);

                //获取订单允许申请售后的产品数据 getOrderInfoByOrderId()函数为了兼容pending状态需展示多个分单数据 son_orders是二维数组
                $returnRes = $this->getRmaServiceLimit($sonOrder[$key]);
                $sonOrder[$key]['returnRes'] = $returnRes == 2 ? true : false;

                //判断是否合发订单
                if ($value['orders_status'] == 12) {
                    $sonOrder[$key]['merge_arr'] = $this->orderService
                        ->getSplitMerge($value['orders_id'],['orders_id'],2);
                }

            }
        }
        return $sonOrder;
    }

    /**
     * 订单详情页 根据指定的orders_id 获取订单的相关数据
     *
     * @param int $order_id
     * @return mixed
     */
    public function getOrderSplitInfo($order_id)
    {
        $ordersData = $this->orderSplit
            ->with(
                [
                    'orderStatus' => function ($query) {
                        $query->select(['orders_status_name', 'orders_status_id'])
                            ->where('language_id', $this->language_id);
                    },
                    'orderSplitTotal'  => function ($query) {
                        $query->select(['orders_id', 'title', 'text', 'value', 'class']);
                    }
                ]
            )
            ->where('orders_id', $order_id)
            ->select(
                [
                    'orders_id',
                    'split_main_id',
                    'products_instock_id',
                    'is_offline',
                    'is_retake',
                    'retake_id',
                    'retake_number',
                    'is_pi_order',
                    'shipping_method_merge',
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
                    'language_code',
                    'warehouse',
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
                    'customers_id'
                ]
            )
            ->first();

        $ordersInfo = [];
        if (!empty($ordersData)) {
            $ordersInfo = $ordersData->toArray();
            //获取客户的折扣率
            $customerService = new CustomerService();
            $discount_rate = $customerService->getCustomerRate();
            $ordersInfo['order_total'] = $this->orderCommonService->createNewOrderTotalInfo($ordersInfo['order_split_total']);
            //是否选择了新加坡上门安装服务
            //$ordersInfo['sg_install_info'] = $this->getOrderSgInstallationInfo($ordersInfo);
            //销售人员
            $ordersInfo['admin_id'] = $this->getOrderAdmin($order_id);
            if ($ordersInfo['split_main_id'] == 1) {
                $ordersInfo['son_orders'] = $this->getSonOrdersInfo($order_id, $discount_rate);
                //线下单拆单未推送的产品补全
                $split_product_arr = [];
                //获取拆单已推送产品以及数量
                if ($ordersInfo['son_orders']) {
                    foreach ($ordersInfo['son_orders'] as $val) {
                        foreach ($val['products'] as $pKey => $products) {
                            $split_product_arr[] = [
                                'products_id' =>  $products['products_id'],
                                'products_quantity' => $products['products_quantity'],
                                'products_prid' => $products['products_prid'],
                            ];
                        }
                    }
                }
                $proIty = $this->orderSplitProductService->getSplitProduct($order_id, $split_product_arr);
                if ($proIty) {
                    $ordersInfo['orders_split_products'] =
                        $this->orderSplitProductService
                            ->getOrderProductsInfo(
                                $order_id,
                                0,
                                $ordersInfo['currency'],
                                $ordersInfo['currency_value'],
                                1,
                                $proIty
                            );
                    ;
                }
                //主单的运输方式信息为空 获取子单的
                if (!$ordersInfo['shipping_method']) {
                    $ordersInfo['shipping_method'] = $ordersInfo['son_orders'][0]['shipping_method'];
                }
            } else {
                $son_order = $ordersInfo;
                //查找订单的运单号
                $trackInfo = $this->orderCommonService->getOrderTrackInfo($ordersInfo['orders_id'], $ordersInfo['orders_status']);
                $son_order['orders_track_info'] = $trackInfo;
                $isReview = false;
                if ($ordersInfo['orders_status']==4) {
                    //详情页已完成的订单 需要给评论入口
                    $isReview = true;
                }
                $this->orderSplitProductService->isLoadReview($isReview);
                $son_order['products'] = $this->orderSplitProductService
                    ->getOrderProductsInfo(
                        $order_id,
                        0,
                        $ordersInfo['currency'],
                        $ordersInfo['currency_value'],
                        $discount_rate
                    );
                // MUX start
                $product_ids = $this->arrayColumnNew($son_order['products'], 'products_id');
                $product_ids = array_intersect($product_ids, $this->mux_products);
                // 是否存在MUX产品
                if (!empty($product_ids)) {
                    $file = $this->getMuxFile($son_order['orders_id'], $product_ids);
                    $son_order['file_path'] = $file;
                    //$son_order['history'] = $this->getAllOrderStatusHistory($son_order['orders_id']);
                }
                // MUX end
                $ordersInfo['son_orders'][] = $son_order;
                //子单的customers_po客户备注信息需要获取主单的
                if ($ordersInfo['split_main_id'] > 1) {
                    $mainData = $this->getOrdersFieldsInfo($ordersInfo['split_main_id'], ['customers_po']);
                    $ordersInfo['customers_po'] = $mainData['customers_po'];
                }
                //获取订单允许申请售后的产品数据 getOrderInfoByOrderId()函数为了兼容pending状态需展示多个分单数据 son_orders是二维数组
                $returnRes = $this->getRmaServiceLimit($son_order);
                $sonOrder['returnRes'] = $returnRes == 2 ? true : false;

                //判断是否合发订单
                if ($ordersInfo['orders_status'] == 12) {
                    $ordersInfo['merge_arr'] = $this->orderService
                        ->getSplitMerge($ordersInfo['orders_id'], ['orders_id'],2);
                }
            }
            //获取订单状态颜色样式
            $ordersInfo['status_class'] = self::getOrderStatusClass($ordersInfo['orders_status']);
            //po number purchase订单显示purchase_order_num 其他订单显示customers_po
            $ordersInfo['po_number_str'] = $ordersInfo['customers_po'];
            if ($ordersInfo['payment_module_code'] == 'purchase') {
                $ordersInfo['po_number_str'] = $ordersInfo['purchase_order_num'];
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

    /*获取订单对应的销售人员
     * @param $order_id 订单id
     *
     * */
    public function getOrderAdmin($order_id)
    {
        $admin_id = '';
        if ($order_id) {
            $admin_info = $this->orderSplitToAdmin
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

    /**
     * track package 页面订单相关数据
     * @param $orders_id
     * @return mixed
     */
    public function getOrdersTrackPackageInfo($orders_id)
    {
        $ordersData = $this->orderSplit
            ->with(['orderStatus' => function ($query) {
                $query->select(['orders_status_id', 'orders_status_name'])
                    ->where('language_id', $this->language_id);
            }])
            ->where('orders_id', $orders_id)
            ->select([
                'orders_id',
                'products_instock_id',
                'orders_number',
                'orders_status',
                'date_purchased',
                'completion_time',
                'payment_module_code',
                'is_reissue',
                'split_main_id',
                'delivery_country',
                'warehouse',
                'process_type',
                'shipping_method',
                'is_payment_true'
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
            $trackInfo = $this->getOrderShippingInfo($ordersInfo['products_instock_id'], $ordersInfo['orders_status']);
            $trackInfo[0]['shipping_method'] = $ordersInfo['shipping_method'];
            if ($trackInfo[0]['shipping_number']) {
                $trackInfo[0]['tracking_number'] = $trackInfo[0]['shipping_number'];
                unset($trackInfo[0]['shipping_number']);
            }

            $ordersInfo['orders_track_info'] = $trackInfo;
            //查找订单状态更新历史记录
            $ordersInfo['orders_status_history'] = $this->getOrderSplitStatusHistory($ordersInfo);
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
        $warehouse = $orders['warehouse'];
        if ($orders['orders_status'] == 4) {
            //完成状态的订单才可以提供 退换货申请入口
            $rmaService = new RmaService();
            foreach ($orders['products'] as $kk => $products) {
                $products_status_arr = $products['products'];
                $check_off = $this->getProductsOnlineStatus($products_status_arr, $warehouse);
                if (!$check_off) {
                    $returnFlag = 1;
                    break;
                }

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

                        if ($son['qty'] - $rmaProductNum > 0) {
                            //当前产品申请售后的个数没有购买产品的总数多 则当前订单还允许申请售后
                            $returnFlag = 2;
                            break;
                        } else {
                            //所有产品都申请了售后,不能进行售后
                            $returnFlag = 1;
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
     * @param  array $orders_info
     * @return array
     *
     * 线下单流程轴节点有四种类型,由 $process_type 变量判断
     * 1 => 常规订单
     * 2 => 提前备货且到款再发
     * 3 => 提前备货且提前发货
     * 4 => 售后补换货单货样品赠品单
     *
     * orders_split:
     *   date_purchased => 下单时间 [Pending状态 1]
     *   completion_time => 订单完成时间 [Delivered 4]
     *
     * products_instock_shipping:
     *   sales_update_time => 付款时间 [Payment Received 状态 2]
     *   logistics_admin_time => 装箱打包时间 [Order Packed 状态 11]
     *   shipping_date, deliver_time => 返单时间 海外仓用shipping_date,国内仓用deliver_time [In Transit 状态 12]
     *
     * products_instock_shipping_info:
     *   logistics_inventory_time => 库存清点时间 [转运单为 Back Ordering 13, 直发单为 Order Picking 10]
     *
     */
    public function getOrderSplitStatusHistory($orders_info)
    {
        $products_instock_id = $orders_info['products_instock_id'];
        //订单付款类型
        $payment_method = $orders_info['payment_module_code'];
        //订单流程类型
        $process_type = $orders_info['process_type'];
        //订单流程时间查询
        $process_time = $this->getOrdersProcessTime($products_instock_id);
        //订单流程节点描述
        $process_text = $this->getOrdersStatusProcessText();

        $transFlag = false; //转运单
        if (in_array($orders_info['is_reissue'], [2, 8, 10, 13, 14, 16, 18, 20])) {
            $transFlag = true;
        }
        $warehouse = $orders_info['warehouse'];
        $now_process = $orders_info['orders_status'];

        //流程轴起始节点
        $process_data = array(
            1 => array(
                'id' => 1,
                'date_added' => $orders_info['date_purchased'],
                'orders_status_name' => $process_text[1]
            )
        );

        //付款节点
        //付款时间判断,若该单为真实付款录单,则为录单时间.其他类型的订单无法查询该节点时间
        $payment_time = $orders_info['is_payment_true'] == 1 ? $process_time['sales_update_time'] : '';
        $process_data_payment = array(
            2 => array(
                'id' => 2,
                'date_added' => $payment_time,
                'orders_status_name' => $process_text[2]
            )
        );

        //PO confirm节点.线下单没有PO上传,时间点视为下单时间
        if ($payment_method == 'purchase') {
            $process_data_po = array(
                8 => array(
                    'id' => 8,
                    'date_added' => $orders_info['date_purchased'],
                    'orders_status_name' => $process_text[8]
                )
            );
        }

        //清点节点键值
        $picking_key = $transFlag ? 13 : 10;

        $deliver_time = $process_time['deliver_time'];
        $shipping_date = strtotime($process_time['shipping_date']) ? $process_time['shipping_date'] : '';
        //清点,打包,发货节点组合
        $process_data_combo = array(
            $picking_key => array(
                'id' => $picking_key,
                'date_added' => $process_time['logistics_inventory_time'],
                'orders_status_name' => $process_text[$picking_key]
            ),
            11 => array(
                'id' => 11,
                'date_added' => $process_time['logistics_admin_time'],
                'orders_status_name' => $process_text[11]
            ),
            12 => array(
                'id' => 12,
                'date_added' => $warehouse == 2 ? $deliver_time : $shipping_date,
                'orders_status_name' => $process_text[12]
            )
        );

        if ($process_type == 2) {
            $end_combo = array(12 => array_pop($process_data_combo));
            $process_data_combo = $process_data_combo + $process_data_payment + $end_combo;
        }

        //完成节点
        $process_data_delivery = array(
            4 => array(
                'id' => 4,
                'date_added' => $orders_info['completion_time'],
                'orders_status_name' => $process_text[4]
            )
        );

        //取消节点
        $process_data_cancel = array(
            5 => array(
                'id' => 5,
                'date_added' => '',
                'orders_status_name' => $process_text[5]
            )
        );

        if ($now_process == 5) {
            $process_data = $process_data + $process_data_cancel;
        } else {
            //尾部节点几种类型不一样
            if ((($process_type == 1 && $payment_method == 'purchase') || $process_type == 3) && $now_process == 2) {
                //当前节点为付款节点
                $process_data_combo = $process_data_combo + $process_data_delivery + $process_data_payment;
            } elseif ($now_process == 4) {
                //当前节点为完成节点
                $process_data_combo = $process_data_combo + $process_data_delivery;
            }

            //各种类型的流程,对应不同的节点
            switch ($process_type) {
                case 1:
                    if ($payment_method == 'purchase') {
                        $process_data = $process_data + $process_data_po + $process_data_combo;
                    } else {
                        $process_data = $process_data + $process_data_payment + $process_data_combo;
                    }
                    break;
                case 2:
                case 3:
                case 4:
                    $process_data = $process_data + $process_data_combo;
                    break;
            }
        }


        return $process_data;
    }

    /**
     * 获取线下单流程轴节点时间
     * @param $products_instock_id
     * @return mixed
     */
    public function getOrdersProcessTime($products_instock_id)
    {
        $time_data = $this->orderSplit->select(
            'pis.sales_update_time',
            'pis.logistics_admin_time',
            'pis.shipping_date',
            'pis.deliver_time',
            'info.logistics_inventory_time'
        )
            ->from('products_instock_shipping as pis')
            ->leftjoin(
                'products_instock_shipping_info as info',
                'pis.products_instock_id',
                '=',
                'info.products_instock_id'
            )
            ->where('pis.products_instock_id', $products_instock_id)
            ->first()
            ->toArray();

        return $time_data;
    }

    /**
     * 获取线下单流程轴文案
     * @return array
     */
    public function getOrdersStatusProcessText()
    {
        $return = [];
        $process_text = $this->orderSplit->select(
            'orders_status_id',
            'orders_status_name'
        )
            ->from('orders_status')
            ->where('language_id', $this->language_id)
            ->get()
            ->toArray();

        foreach ($process_text as $value) {
            $return[$value['orders_status_id']] = $value['orders_status_name'];
        }

        return $return;
    }

    /**
     * @param $p_status_arr
     * @param $warehouse
     * @return int
     */
    public function getProductsOnlineStatus($p_status_arr, $warehouse)
    {

        $status_value = 1;
        if (!$p_status_arr['products_status']) {
            $status_value = 0;
        } else {
            switch ($warehouse) {
                case 2:
                    $status_value = $p_status_arr['cn_status'];
                    break;
                case 20:
                    $status_value = $p_status_arr['de_status'];
                    break;
                case 37:
                    $status_value = $p_status_arr['au_status'];
                    break;
                case 40:
                    $status_value = $p_status_arr['us_status'];
                    break;
                case 71:
                    $status_value = $p_status_arr['sg_status'];
                    break;
                case 67:
                    $status_value = $p_status_arr['ru_status'];
                    break;
            }
        }

        return $status_value;
    }

    /*修改订单状态
    * @param $order_id 订单id
    *
    * */
    public function editOrderStatus($order_id)
    {
        if ($order_id) {
            $customer = new CustomerService();
            $customers_info = $customer->setCustomer()->currentCustomer;
            $customers_id = $customers_info->customers_id;
            $add_time = Carbon::now('Etc/GMT')->toDateTimeString();
            $data = [
                'orders_status' => 4,
                'completion_time' => $add_time
            ];
            $result = $this->orderSplit
                ->where('orders_id', $order_id)
                ->where('customers_id', $customers_id)
                ->update($data);
            if (!$result) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * 订单列表页面
     * @param array $param
     * @param array $limit
     * @param bool $is_count
     * @param bool $is_rma
     * @return array
     */
    public function getSplitOrdersList($param = [], $limit = [], $is_count = false, $is_rma = false)
    {
        $ordersInfo = [];
        if ($is_count) {
            //统计订单总数
            $orderSplitOrder = $this->orderSplit
                ->where('is_offline', 1)
                ->whereIn('split_main_id', [0, 1]);
        } else {
            $orderSplitOrder = $this->orderSplit
                ->with([
                    'orderStatus' => function ($query) {
                        $query->select(['orders_status_name', 'orders_status_id'])
                            ->where('language_id', $this->language_id);
                    },
                    'orderSplitTotal' => function ($query) {
                        $query->select(['orders_id', 'title', 'text', 'value', 'class']);
                    }
                ])
                ->where('is_offline', 1)
                ->whereIn('split_main_id', [0, 1]);
        }
        //客户选择了查看公司订单类型
        $this->getCompanyTypeCustomer($param['customer_type_order']);
        if (sizeof($this->allCustomerId) > 1) {
            $orderSplitOrder = $orderSplitOrder->whereIn('customers_id', $this->allCustomerId);
        } else {
            $orderSplitOrder = $orderSplitOrder->where('customers_id', $this->customer_id);
        }
        //订单时间筛选查询
        $dateSqlWhere = $this->getOrderDateTypeSql($param['date_type']);
        if ($dateSqlWhere) {
            $orderSplitOrder = $orderSplitOrder->whereRaw($dateSqlWhere);
        }
        //search搜索订单号或者产品ID查询
        if ($param['search']) {
            $searchOrders = $this->getSearchOrders($param['search']);
            if (sizeof($searchOrders)) {
                $orderSplitOrder = $orderSplitOrder->whereIn('orders_id', $searchOrders);
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
            $ordersInfo = $orderSplitOrder->count();
        } else {
            $orderSplitOrder = $orderSplitOrder->select(
                ['orders_id',
                    'orders_number',
                    'orders_status',
                    'retake_id',
                    'retake_number',
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
                    'is_offline',
                    'split_main_id',
                    'language_code',
                    'warehouse',
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
                ]
            )
                ->orderBy('orders_id', 'DESC')
                ->offset($limit['start'] ? $limit['start'] : 0)
                ->limit($limit['num'] ? $limit['num'] : 10)
                ->get();
            if (!empty($orderSplitOrder)) {
                $ordersInfo = $orderSplitOrder->toArray();
                foreach ($ordersInfo as $key => $orders) {
                    $son_order = [];
                    // 主单
                    if ($orders['split_main_id'] == 1) {
                        //主单下有分单
                        $son_order = $this->getSonOrdersInfo($orders['orders_id']);
                        //线下单拆单未推送的产品补全
                        $split_product_arr = [];
                        //获取拆单已推送产品以及数量
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
                        $proIty = $this->orderSplitProductService
                            ->getSplitProduct($orders['orders_id'], $split_product_arr);
                        if ($proIty) {
                            $ordersInfo[$key]['orders_split_products'] =
                                $this->orderSplitProductService
                                    ->getOrderProductsInfo(
                                        $orders['orders_id'],
                                        0,
                                        $orders['currency'],
                                        $orders['currency_value'],
                                        1,
                                        $proIty
                                    );
                            ;
                        }
                    } else { // 整单，只有一个订单
                        $trackInfo = $this->getOrderTrackInfo($orders['orders_id'], $orders['orders_status']);
                        $orders['orders_track_info'] = $trackInfo;
                        //获取订单状态颜色样式 todo 要跟后台的订单状态相对应
                        $orders['status_class'] = self::getOrderStatusClass($orders['orders_status']);
                        $products = $this->orderSplitProductService
                            ->getOrderProductsInfo(
                                $orders['orders_id'],
                                0,
                                $orders['currency'],
                                $orders['currency_value']
                            );
                        $orders['products'] = $products;
                        $orders['is_payment_link'] = false;
                        if (empty($products)) {
                            //没有产品的订单是补款链接订单 查找补款信息
                            $paymentLinkData = $this->getPaymentLinkInfo($orders['orders_id']);
                            $orders['is_payment_link'] = true;
                            $orders['payment_link_data'] = $paymentLinkData;
                        }
                        $son_order[] = $orders;
                        // MUX产品
                        $ids = $this->arrayColumnNew($son_order[0]['products'], 'products_id');
                        $arr = array_intersect($ids, $this->mux_products);
                        // 查询订单的历史
                        if (!empty($arr)) {
                            $file = $this->getMuxFile($son_order[$key]['orders_id'], $arr);
                            $sonOrder[$key]['file_path'] = $file;
                        }
                        //判断是否合发订单
                        if ($orders['orders_status'] == 12) {
                            $son_order[$key]['merge_arr'] = $this->orderService
                                ->getSplitMerge($son_order[$key]['orders_id'],['orders_id'],2);
                        }
                    }
                    $ordersInfo[$key]['order_total'] = $this->orderCommonService->createNewOrderTotalInfo($orders['order_split_total']);
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
     * 根据订单ID和订单状态获取 订单的物流信息
     * @param $orders_id    订单ID
     * @param $order_status 订单状态
     * @return array
     */
    public function getOrderTrackInfo($products_instock_id, $order_status)
    {
        $trackInfo = [];
        if ($order_status == 12 || $order_status = 4) {
            //12[In Transit]运输发货后的状态下 订单才有运单号
            $orderTrack = new OrderTrackInfo();
            $trackData = $orderTrack->where('products_instock_id', $products_instock_id)
                ->select(['shipping_method', 'tracking_number'])
                ->get();
            if (!empty($trackData)) {
                $trackInfo = $trackData->toArray();
            }
        }
        return $trackInfo;
    }

    /**
     * 根据订单ID和订单状态获取 订单的物流信息
     * @param $orders_id    订单ID
     * @param $order_status 订单状态
     * @return array
     */
    public function getOrderShippingInfo($products_instock_id, $order_status)
    {
        $trackInfo = [];
        if ($order_status == 12 || $order_status = 4) {
            //12[In Transit]运输发货后的状态下 订单才有运单号
            $products_instock_shipping = new ProductsInstockShipping();

            $trackData = $products_instock_shipping->where('products_instock_id', $products_instock_id)
                ->select([ 'shipping_number'])
                ->get();
            if (!empty($trackData)) {
                $trackInfo = $trackData->toArray();
            }
        }
        return $trackInfo;
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
        preg_match('/^FS[0-9]{6}/', $search, $match);
        if ($match) {
            //订单号搜索
            $searchOrder = $this->orderSplit->whereIn('customers_id', $this->allCustomerId)
                ->where('orders_number', $search)
                ->select(['orders_id', 'split_main_id'])
                ->get();
            if (!empty($searchOrder)) {
                $searchOrder = $searchOrder->toArray();
                foreach ($searchOrder as $key => $order) {
                    if (in_array($order['split_main_id'], [0, 1])) {
                        //是主单
                        $orders_id[] = $order['orders_id'];
                    } else {
                        //是分订单，则查找其对应的主订单ID
                        $orders_id[] = $order['split_main_id'];
                    }
                }
            }
        } elseif (is_numeric($search) && strlen($search) >= 5) {
            //搜索产品id
            $allOrders = $this->orderSplit->whereIn('customers_id', $this->allCustomerId)
                ->lists('split_main_id', 'orders_id');
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
            $searchOrder = $this->orderSplit->whereIn('customers_id', $this->allCustomerId)
                ->where('customers_po', $search)
                ->select(['orders_id', 'split_main_id'])
                ->get()->toArray();
            if (!empty($searchOrder)) {
                foreach ($searchOrder as $key => $order) {
                    if (in_array($order['split_main_id'], [0, 1])) {
                        //是主单
                        $orders_id[] = $order['orders_id'];
                    } else {
                        //是分订单，则查找其对应的主订单ID
                        $orders_id[] = $order['split_main_id'];
                    }
                }
            }else{
                //当做型号名搜索
                $allOrders = $this->orderSplit->whereIn('customers_id', $this->allCustomerId)
                    ->lists('split_main_id', 'orders_id');
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

    /*
     * 获取线下单拆单主id
    * @param int $orders_id
    * @return array $order_data
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

    /**
     * $Notes: 获取后台订单主单数据
     *
     * $author: Quest
     * $Date: 2020/8/21
     * $Time: 15:00
     * @param $orders_number
     * @return array
     */
    public function getProductsInstockMain($orders_number)
    {
        $data = [];
        $pis_m = new ProductsInstockShipping();
        $m_data = $pis_m->select(['products_instock_id', 'sales_update_time'])
            ->where('order_number', $orders_number)
            ->where('origin_id', '')
            ->where('split_order', '')
            ->where('product_height', '')
            ->first();

        if (!empty($m_data)) {
            $data = $m_data->toArray();
        }
        return $data;
    }
}
