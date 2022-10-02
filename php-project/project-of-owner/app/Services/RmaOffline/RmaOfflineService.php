<?php


namespace App\Services\RmaOffline;

use App\Models\ProductThumbImage;
use App\Models\Rma;
use App\Models\RmaProducts;
use App\Models\RmaAddress;
use App\Models\RmaHistory;
use App\Models\OrderSplit;
use App\Models\OrderSplitProduct;
use App\Models\OrdersStatusHistory;
use App\Models\ProductDescription;
use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use App\Services\Common\CommonService;
use App\Services\Customers\CustomerService;
use App\Services\Country\CountryService;
use App\Services\Rma\RmaService;
use Illuminate\Database\Capsule\Manager as DB;
use App\Services\Common\Upload\UploadService;

class RmaOfflineService extends BaseService
{
    private $rma_m;
    private $rma_pm;
    private $rma_am;
    private $rma_hm;
    private $orderSplit;
    private $orderSplitProduct;
    private $order_sh_m;
    private $curr;
    private $customer;
    private $common;
    private $count;
    private $productThumbImage;
    private $productDes;
    //默认产品图片尺寸
    private $defaultImageZie = ['size_w'=>180,'size_h'=>180];

    public function __construct()
    {
        parent::__construct();

        //Model类
        $this->rma_m = new Rma();
        $this->rma_pm = new RmaProducts();
        $this->rma_am = new RmaAddress();
        $this->rma_hm = new RmaHistory();
        $this->orderSplit = new OrderSplit();
        $this->orderSplitProduct = new OrderSplitProduct();
        $this->order_sh_m = new OrdersStatusHistory();
        $this->productThumbImage = new ProductThumbImage();

        //Service类
        $this->curr = new CurrencyService();
        $this->common = new CommonService();
        $this->count = new CountryService();
        $this->customer = new CustomerService();
    }

    /**
     * 设置图片默认尺寸
     *
     * @param array $size
     * @return $this
     */
    public function setImageSize(array $size)
    {
        $this->defaultImageZie = $size;
        return $this;
    }

    /**
     * 获取订单售后数据
     * @param $orders_id
     * @return array
     */
    public function getOrderRma($orders_id)
    {
        $return = array('status' => 0, 'data' => '');
        if (empty($orders_id)) {
            return $return;
        }

        $orders_data = $this->getOrderInfo($orders_id);
        if (empty($orders_data)) {
            return $return;
        }

        $orders_data['delivery_country_id'] = $this->count->getCountryidByName($orders_data['delivery_country']);

        //检测用户权限
        //收货时间
//        $transit_time = $this->getOrderStatusHisTime($orders_id, [4]);
//        if (empty($transit_time)) {
//            //发货时间
//            $transit_time = $this->getOrderStatusHisTime($orders_id, [1, 12]);
//        }

        //线下单为下单时间
        $transit_time = $orders_data['date_purchased'];

        $check_res = $this->getRmaCustomerCheck($orders_data['customers_id'], $transit_time);
        if ($check_res['status'] == 0) {
            return $return;
        }
        $orders_data['is_show_refund'] = $check_res['refund'];

        //获取订单产品数据
        $orders_currency = $orders_data['currency'];
        $orders_currency_value = $orders_data['currency_value'];
        $orders_data['products'] = $this->getOrderRmaProducts($orders_id, $orders_currency, $orders_currency_value,$orders_data['is_au_gsp']);

        if (empty($orders_data['products'])) {
            return $return;
        }
        //是否为赠品单
        $orders_data['is_gift_order'] = false;
        if (in_array($orders_data['is_reissue'], [22, 23])) {
            $orders_data['is_gift_order'] = true;
        }

        //没有当前售后服务的订单就跳回列表页面 赠品单不能申请售后
        if ($orders_data['is_gift_order'] && empty($orders_data['products'])) {
            return $return;
        }

        $return = array('status' => 1, 'data' => $orders_data);
        return $return;
    }

    /**
     * 获取订单相关详细信息
     * @param $orders_id
     * @return array
     */
    public function getOrderInfo($orders_id)
    {
        $data = $this->orderSplit->with(['orderSplitTotal' => function ($q) {
            $q->select(
                'orders_id',
                'text as order_total'
            )->where('class', 'ot_total');
        }, 'OrderStatus' => function ($q) {
            $q->select(
                'orders_status_id',
                'orders_status_name'
            )->where('language_id', $this->language_id);
        }])->where('orders_id', $orders_id)
            ->first([
                'orders_id', 'date_purchased',
                'customers_id', 'delivery_name',
                'customers_name', 'purchase_order_num',
                'customers_po', 'payment_method',
                'delivery_name', 'delivery_lastname',
                'delivery_company', 'delivery_company_type',
                'delivery_street_address', 'delivery_suburb',
                'delivery_city', 'delivery_tax_number',
                'shipping_method', 'd_tel_prefix',
                'delivery_postcode', 'delivery_state',
                'delivery_country', 'delivery_telephone',
                'billing_name', 'billing_country',
                'billing_lastname', 'is_reissue',
                'split_main_id', 'billing_company',
                'billing_street_address', 'billing_suburb',
                'billing_postcode', 'billing_state',
                'billing_telephone', 'billing_tax_number',
                'customers_remarks', 'b_tel_prefix',
                'orders_status', 'orders_number',
                'currency', 'currency_value',
                'payment_module_code', 'warehouse',
                'billing_city', 'logo_file',
                'delivery_country_id'
            ]);

        if (!$data) {
            return [];
        }
        return $data->toArray();
    }

    /**
     * 获取订单历史的时间点
     * @param $orders_id
     * @param array $status
     * @return mixed
     */
    public function getOrderStatusHisTime($orders_id, $status = [])
    {

        $data_arr = $this->order_sh_m->select()
            ->where('orders_id', $orders_id)
            ->whereIn('orders_status_id', $status)
            ->orderBy('orders_status_id', 'desc')
            ->first('date_added');
        if (empty($data_arr)) {
            return array();
        }
        $data_arr = $data_arr->toArray();

        return $data_arr['date_added'];
    }

    /**
     * 检测售后用户与订单是否对应
     * @param $customers_id
     * @param $time
     * @return array
     */
    public function getRmaCustomerCheck($customers_id, $time)
    {
        $return = array('status' => 1, 'msg' => '', 'refund' => true);

        //访问的非当前用户的订单售后
        if ($customers_id != $this->customer_id) {
            $return['status'] = 0;
            $return['msg'] = 'This is not your order';
            return $return;
        }

        //判断是否显示退款,30天内才能申请退款
        $order_time = strtotime($time) + (86400 * 30);
        $now_time = time();
        if ($order_time < $now_time) {
            $return['refund'] = false;
        }

        return $return;
    }

    /**
     * 获取订单售后产品数据
     * @param $orders_id
     * @param $currency
     * @param $currency_value
     * @param  $is_au_gsp
     * @return array
     */
    public function getOrderRmaProducts($orders_id, $currency, $currency_value,$is_au_gsp=0)
    {
        $where_op = ['orders_id' => $orders_id];
        $products_data = $this->getOrdersProductsInfo($where_op);

        $rate = $this->customer->getCustomerRate();
        $products_array = [];

        if (!empty($products_data)) {
            foreach ($products_data as $products) {
                $main_products_id = $products['products_id'];
                $orders_products_id = $products['orders_products_id'];
                $products_model = $products['products_model'];
                $fms_products_str = $products['composite_son_products'];
                if (!empty($fms_products_str)) {//组合产品
                    $fms_products = $this->getCompositeProductsInfo(
                        $fms_products_str,
                        $currency,
                        $currency_value,
                        $rate
                    );

                    $fms_array = [];
                    foreach ($fms_products as $products_son) {
                        $pid_son = $products_son['products_id'];
                        //获取未进行或未完成退换货的订单产品数量
                        $rma_tnum = $this->getRmaUndoneNumber($orders_products_id, $pid_son);
                        $fms_tnum = $products_son['qty'];

                        //特殊组合产品必须等上次售后完成，才能再次申请售后--已废除，但暂时保留代码
                        if (in_array($main_products_id, [96375,96376]) && $rma_tnum > 0 && false) {
                            $fms_array = [];
                            break;
                        }
                        if ($fms_tnum > $rma_tnum) {
                            $p_num = (int)$fms_tnum - (int)$rma_tnum;
                            $fms_array[] = array(
                                'products_id' => $products_son['products_id'],
                                'orders_products_id' => $orders_products_id,
                                'products_model' => $products_model,
                                'products_name' => $products_son['products_name'],
                                'price_int' => $products_son['products_price'],
                                'products_price' => $products_son['products_price_str'],
                                'products_image' => $products_son['products_image_str'],
                                'qty' => $p_num,
                                'products_price_currency' => $products_son['products_price_str'],
                            );
                        }
                    }

                    if (!empty($fms_array)) {
                        $products_array[] = array(
                            'products_id' => $products['products_id'],
                            'prid' => $products['products_prid'],
                            'orders_products_id' => $orders_products_id,
                            'products_model' => $products_model,
                            'products_name' => $products['products_name'],
                            'products_price' => $products['products_price'],
                            'products_image' => '',
                            'final_price' => $products['final_price'],
                            'qty' => (int)$products['products_quantity'],
                            'attribute' => '',
                            'is_fms' => 1,
                            'is_light' => false,
                            'is_spe_combo' => in_array($products['products_id'], [96375, 96376]) ? true : false,
                            'fms_products' => $fms_array
                        );
                    }
                } else {//普通产品
                    $orders_products_id = $products['orders_products_id'];
                    $products_id = $products['products_id'];
                    $products_qty = $products['products_quantity'];
                    $price_add = $is_au_gsp ? $products['tax_after_price'] : $products['final_price'];
                    $rma_tnum = $this->getRmaUndoneNumber($orders_products_id, $products_id);

                    if ($products_qty > $rma_tnum) {
                        //判断是否为光模块产品
                        $cate_str = $this->common->getProductsCategories($products_id);
                        $cate_arr = explode('_', $cate_str);
                        $is_light = reset($cate_arr) == 9 ? true : false;

                        $p_num = (int)$products_qty - (int)$rma_tnum;
                        $products_array[] = array(
                            'products_id' => $products_id,
                            'orders_products_id' => $orders_products_id,
                            'products_model' => $products_model,
                            'prid' => $products['products_prid'],
                            'products_name' => $products['products_name'],
                            'final_price' => $products['final_price'],
                            'products_price' => $products['products_price'],
                            'products_image' => '',
                            'attribute' => $products['orders_products_attributes'],
                            'attribute_length' => $products['orders_products_length'],
                            'qty' => $p_num,
                            'is_fms' => 0,
                            'is_light' => $is_light,
                            'is_spe_combo' => false,
                            'fms_products' => [],
                            'products_price_currency' =>  $this->curr->format(
                                $price_add,
                                2,
                                true,
                                $currency,
                                $currency_value
                            ),
                        );
                    }
                }
            }
        }

        return $products_array;
    }

    /**
     * 获取产品及相关属性
     * @param array $where
     * @return array
     */
    public function getOrdersProductsInfo($where = [])
    {
        //产品及关联属性
        $res = $this->orderSplitProduct->with(['ordersProductsAttributes' => function ($q) {
            $q->select(
                'orders_products_id',
                'products_options_id as option_id',
                'products_options as option',
                'products_options_values_id as value_id',
                'products_options_values as value',
                'options_values_price as price',
                'price_prefix as prefix'
            );
        }, 'ordersProductsLength' => function ($q) {
            $q->select(
                'orders_products_id',
                'length_name as option',
                'length_price as price',
                'price_prefix as prefix'
            );
        }]);

        if (!empty($where)) {
            $res = $res->where($where);
        }

        $res = $res->get([
            'orders_id',
            'orders_products_id',
            'products_id',
            'products_model',
            'products_name',
            'products_price',
            'final_price',
            'products_quantity',
            'products_prid',
            'composite_son_products'
        ]);
        if (empty($res)) {
            return array();
        }
        return $res->toArray();
    }

    /**
     * 获取组合产品
     * @param $fms_products
     * @param $currency
     * @param $currency_value
     * @param int $discount_rate
     * @return array
     */
    public function getCompositeProductsInfo($fms_products, $currency, $currency_value = '', $discount_rate = 1)
    {
        $son_products = explode(',', $fms_products);
        $son_products = array_filter($son_products);
        $new_son_products = array(); // 子产品数据
        $son_product_id_array = array(); // 子产品id数组
        foreach ($son_products as $key => $val) {
            $one = explode(':', $val);
            $buy_info = explode('-', $one[1]);
            $price[$key] = $this->getFormatNmber($buy_info[1], $discount_rate);

            $son_product_id_array[] = $one[0];
            $new_son_products[$one[0]] = array(
                'products_id' => $one[0],
                'qty' => $buy_info[0], //子产品数量
                'products_price' => $price[$key], //订单币种价格-单价
                'products_price_str' =>
                    $this->curr->format(
                        $price[$key],
                        2,
                        false,
                        $currency,
                        $currency_value
                    ),//订单币种格式化价格
                'image' => $this->productThumbImage->setThumbImage($this->defaultImageZie)
                    ->getResourceImage($one[0]),
                'products_name' =>$this->getProductName($one[0]),
            );
        }

        return $new_son_products;
    }

    public function getProductName($product_id)
    {
        $this->productDes = new ProductDescription();
        if ($product_id) {
            $productInfo = $this->productDes
                ->select('products_name')
                ->where('products_id', $product_id)
                ->where('language_id', $this->language_id)
                ->first();
            if (!empty($productInfo)) {
                $productData= $productInfo->toArray();
                return $productData['products_name'];
            }
        }
        return [];
    }

    /**
     * 获取进行中或已完成售后的订单产品数量
     * @param $orders_products_id
     * @param $products_id
     * @return mixed
     */
    public function getRmaUndoneNumber($orders_products_id, $products_id)
    {
        $numarr = $this->rma_m->select(
            DB::connection()->raw('SUM(cp.products_num) as number')
        )->from('customers_service as cs')
            ->leftJoin('customers_service_products as cp', 'cs.customers_service_id', '=', 'cp.service_id')
            ->where('cs.customers_id', $this->customer_id)
            ->where('cp.orders_products_id', $orders_products_id)
            ->where('cp.products_id', $products_id)
            ->where(function ($q) {
                $q->where(function ($q_a) {
                    $q_a->where('cs.service_type_id', 1)
                        ->where('cs.service_status', '<>', 7);
                })
                    ->orWhere(function ($q_o) {
                        $q_o->whereIn('cs.service_type_id', [2, 3])
                            ->whereNotIn('cs.service_status', [6, 7]);
                    });
            })
            ->first();
        if (empty($numarr)) {
            return 0;
        }
        $numarr = $numarr->toArray();

        return $numarr['number'];
    }


    /**
     * 提交售后申请
     * @param $rmadata
     * @return array
     */
    public function getRmaOfflineApply($rmadata)
    {
        $return = array('status' => 0, 'msg' => '', 'data' => []);
        $orders_id = $rmadata['orders_id'];
        $rma_type = $rmadata['rma_type'];
        $refund_method = $rmadata['refund_method'];

        //获取售后申请相关订单数据
        $filed = ['customers_id', 'date_purchased', 'orders_number', 'currency', 'currency_value'];
        $delivery_filed = [
            'delivery_company',
            'delivery_company_type',
            'delivery_name',
            'delivery_lastname',
            'delivery_street_address',
            'delivery_suburb',
            'delivery_city',
            'delivery_postcode',
            'delivery_state',
            'delivery_country_id',
            'delivery_telephone',
            'customers_email_address',
            'd_tel_prefix'
        ];
        $filed = array_merge($filed, $delivery_filed);
        $orders_info = $this->getRmaOrderSplitRelate($orders_id, $filed);
        $o_customer_id = $orders_info['customers_id'];
        //$o_time = $orders_info['date_purchased'];
        $o_currency = $orders_info['currency'];
        $o_currency_value = $orders_info['currency_value'];
        $orders_number = $orders_info['orders_number'];

        //收货时间
        $transit_time = $orders_info['date_purchased'];

        //检测用户是否有权限申请售后
        $check_res = $this->getRmaCustomerCheck($o_customer_id, $transit_time);
        if ($check_res['status'] == 0) {
            $return['msg'] = $check_res['msg'];
            return $return;
        }
        if ($check_res['refund'] == false && $rma_type == 1) {
            $return['msg'] = 'This order is out of date';
            return $return;
        }

        //生成售后CS编号
        $or_count = $this->rma_m->where('orders_id', $orders_id)->get()->count();
        $cs_num_add = (int)$or_count + 1;
        $cs_num_add = strlen($cs_num_add) == 1 ? '0' . $cs_num_add : $cs_num_add;
        $cs_num = 'CS' . $orders_number . $cs_num_add;

        //定制产品和组合产品一律需要人工审核,标准产品高于5000美金人工审核,低于的话自动审核
        $human_audit = false;
        $total_price = 0;
        $products_str = '';
        $products_insert = array();
        foreach ($rmadata['products'] as $products_arr) {
            $op_id = $products_arr['op_id'];
            $op_arr = explode('_', $op_id);
            $orders_products_id = $op_arr[0];
            $products_id = $op_arr[1];

            $filed = ['final_price', 'products_id', 'composite_son_products', 'products_quantity'];
            $op_info = $this->getRmaProductsRelate($orders_products_id, $filed);
            $op_products_id = $op_info['products_id'];
            $final_price = $op_info['final_price'];
            $total_qty = $op_info['products_quantity'];
            $fms_products_str = $op_info['composite_son_products'];

            //判断申请售后产品数量是否正确
            $num_check = $this->getRmaNumberCheck(
                $orders_products_id,
                $products_id,
                $total_qty,
                $fms_products_str,
                $o_currency,
                $o_currency_value,
                $products_arr['products_num']
            );
            if (!$num_check) {
                $return['msg'] = 'RMA Qty is over purchased Qty.';
                return $return;
            }

            //根据分类判断是否需要人工审核
            if (!$human_audit) {
                $human_audit = $this->getProductsHumanAduit($op_products_id, $transit_time);
            }

            $products_str .= $products_id . ',';
            $total_price += $final_price;

            //产品表数据组装
            $products_insert[] = array(
                'products_id' => $products_id,//若为组合产品,则存储子产品products_id
                'orders_products_id' => $orders_products_id,
                'products_num' => $products_arr['products_num'],
                'reasons_type' => $products_arr['reasons_type'],
                'customers_service_content' => $products_arr['customers_service_content'],
                'service_number' => isset($products_arr['service_number']) ? $products_arr['service_number'] : '',
                'images' => $products_arr['images'] ? $products_arr['images'] : '',
                'is_fms' => $op_info['composite_son_products'] ? 1 : 0
            );
        }
        $products_str = trim($products_str, ',');

        //根据金额判断是否需要人工审核
        if (!$human_audit) {
            $human_audit = floatval($total_price) > 5000 ? true : false;
        }

        $time_now = date('Y-m-d H:i:s');
        $service_status = $human_audit ? 1 : 9;
        $customers_service_data = array(
            'service_type_id' => $rma_type,
            'orders_id' => $orders_id,
            'customers_service_date' => $time_now,
            'customers_id' => $this->customer_id,
            'service_number' => $cs_num,
            'products_id' => $products_str,
            'service_status' => $service_status,
            'check_type' => $human_audit ? 1 : 2,
            'refund_method' => $refund_method,
            'customers_email' => $this->session['customers_email_address'],
            'orders_type' => 2
        );
        //客户收货地址
        $service_address[1] = array(
            'entry_company' => $rmadata['entry_company'],
            'entry_company_type' => $rmadata['entry_company_type'],
            'entry_firstname' => $rmadata['entry_firstname'],
            'entry_lastname' => $rmadata['entry_lastname'],
            'entry_street_address' => $rmadata['entry_street_address'],
            'entry_suburb' => $rmadata['entry_suburb'],
            'entry_postcode' => $rmadata['entry_postcode'],
            'entry_city' => $rmadata['entry_city'],
            'entry_state' => $rmadata['entry_state'],
            'entry_country_id' => $rmadata['entry_country_id'],
            'entry_telephone' => $rmadata['entry_telephone'],
            'entry_tel_prefix' => !empty($rmadata['entry_tel_prefix']) ? $rmadata['entry_tel_prefix'] : '',
            'entry_email' => $this->session['customers_email_address'],
        );
        //客户发货地址
        $service_address[2] = array(
            'entry_company' => $orders_info['delivery_company'],
            'entry_company_type' => $orders_info['delivery_company_type'],
            'entry_firstname' => $orders_info['delivery_name'],
            'entry_lastname' => $orders_info['delivery_lastname'],
            'entry_street_address' => $orders_info['delivery_street_address'],
            'entry_suburb' => $orders_info['delivery_suburb'],
            'entry_postcode' => $orders_info['delivery_postcode'],
            'entry_city' => $orders_info['delivery_city'],
            'entry_state' => $orders_info['delivery_state'],
            'entry_country_id' => $orders_info['delivery_country_id'],
            'entry_telephone' => $orders_info['delivery_telephone'],
            'entry_tel_prefix' => !empty($orders_info['d_tel_prefix']) ? $orders_info['d_tel_prefix'] : '',
            'entry_email' => $orders_info['customers_email_address'],
            'type' => 2
        );
        $update_his = array();
        if (!$human_audit) {
            $update_his[] = array(
                'shipping_method' => '',
                'express_account' => '',
                'admin_id' => 0,
                'admin_reply' => self::trans('SALES_MSG_SUBMIT'),
                'service_status' => 1,
                'date_added' => $time_now
            );
        }
        $update_his[] = array(
            'shipping_method' => '',
            'express_account' => '',
            'admin_id' => 0,
            'admin_reply' =>
                $human_audit ?  self::trans('SALES_MSG_SUBMIT') :  self::trans('SALES_MSG_APPROVED'),
            'service_status' => $service_status,
            'date_added' => $time_now
        );

        $rma_insert = array(
            'customers_service' => $customers_service_data,
            'customers_service_address' => $service_address,
            'customers_service_products' => $products_insert,
            'customers_service_history' => $update_his
        );
        $rma_res = $this->insertRmaApply($rma_insert);
        if ($rma_res['status'] == 0) {
            $return['msg'] = $rma_res['msg'];
            return $return;
        }

        $email_data = array(
            'audit_type' => $human_audit ? 1 : 2,
            'rma_type' => $rma_type,
            'products' => $products_insert,
            'total_price' => $total_price
        );

        $return_data = array(
            's_id' => $rma_res['data'],
            's_number' => $cs_num,
            'email_data' => $email_data,
        );

        $return = array('status' => 1, 'data' => $return_data, 'msg' => 'success');
        return $return;
    }

    /**
     * 获取售后申请相关订单数据
     * @param $orders_id
     * @return array
     */
    public function getRmaOrderSplitRelate($orders_id, $filed)
    {
        $res = $this->orderSplit->select($filed)
            ->where('orders_id', $orders_id)
            ->first();
        if (empty($res)) {
            return [];
        }
        return $res->toArray();
    }

    /**
     * 获取售后申请相关产品数据
     * @param $orders_products_id
     * @return mixed
     */
    public function getRmaProductsRelate($orders_products_id, $filed)
    {
        $res = $this->orderSplitProduct->select($filed)
            ->where('orders_products_id', $orders_products_id)
            ->first();

        if (empty($res)) {
            return [];
        }

        return $res->toArray();
    }

    /**
     * 判断售后产品数量
     * @param $orders_products_id
     * @param $products_id
     * @param $total_num
     * @param string $fms_products_str
     * @param string $currency
     * @param string $currency_value
     * @param int $a_num
     * @return bool
     */
    public function getRmaNumberCheck(
        $orders_products_id,
        $products_id,
        $total_num,
        $fms_products_str = '',
        $currency = '',
        $currency_value = '',
        $a_num = 0
    ) {
        $cop_num = $this->getRmaUndoneNumber($orders_products_id, $products_id);
        $currency = empty($currency) ? $this->currency : $currency;
        if (!empty($fms_products_str)) {
            $fms_products = $this->getCompositeProductsInfo(
                $fms_products_str,
                $currency,
                $currency_value,
                $this->customer->getCustomerRate()
            );
            $total_num = $fms_products[$products_id]['qty'];
        }

        $cop_num = $a_num == 0 ? $cop_num : (int)$cop_num + (int)$a_num;
        if ($cop_num > $total_num) {
            return false;
        }
        return true;
    }

    /**
     * 判断退换货的产品是否需要人工审核
     * @param $products_id
     * @param string $transit_time
     * @return bool
     */
    public function getProductsHumanAduit($products_id, $transit_time = '')
    {
        $check = false;
        $customArr = $customProArr = array();  //需人工审核的分类ID和产品ID数组

        //从文件中获取
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/coding/rma_check_category/category.txt')) {
            $check_content =
                file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/coding/rma_check_category/category.txt');
            $check_content = trim($check_content);
            //该文件中既有分类ID又有产品ID两者中间用|符号分隔,eg:177,178|36157,36158
            $content_arr = explode('|', $check_content);
            $customArr = explode(',', $content_arr[0]);
            $customProArr = explode(',', $content_arr[1]);
        } else {
            $customArr = array(
                177, 178, 179, 180, 1202, 1023, 1017, 1022, 628, 596, 1311, 1333, 1153, 1340,
                1316, 3318, 3203, 16, 1003, 17, 1105, 13, 2969, 1135, 1140, 3087, 3191, 3089,
                1125, 897, 2867, 1324, 1194, 901, 1082, 3254, 2866, 1415, 974, 1326, 3081, 1081,
                1083, 2958, 220, 3253, 1342, 1148, 996, 3080, 939, 609, 914, 576, 3125, 2981,
                1155, 1000, 2686, 384, 2687, 45, 3358, 3359, 3360, 3076, 3361, 3084, 3083, 3092,
                3082, 1145, 3128, 3362, 2960, 2963, 900, 3093, 2907, 3059, 1098, 1067, 1070,
                3390, 3054, 3061, 593, 594, 3049, 980, 3371, 613, 3261, 3262, 3263, 3311, 1134,
                1133, 3073, 633, 3313, 962, 590, 3347, 1126, 24, 964, 969, 3072, 1074, 50, 53, 1063,
                47, 49, 3255, 3256, 3257, 3258, 3373, 3309, 3354, 3355, 3267, 3375, 1402, 3260,
                1343, 2968, 3053, 3314, 3086, 3075, 3150, 3374, 1048, 1181, 3334, 1038, 1044,
                1047, 1186, 22, 38, 34, 1321, 1319, 1099, 19, 21, 48, 52, 51, 55);
        }

        //获取自动审核分类保修期
        $auto_category = $auto_product = array();
        //从文件中获取
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/coding/rma_check_category/auto_category.txt')) {
            $check_content =
                file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/coding/rma_check_category/auto_category.txt');
            $check_content = trim($check_content);
            //该文件中既有分类ID又有产品ID两者中间用|符号分隔,eg 918:60,35:12|36157:6
            $content_arr = explode('|', $check_content);
            $cateArr = explode(',', $content_arr[0]);
            if (sizeof($cateArr)) {
                foreach ($cateArr as $cate) {
                    if ($cate) {
                        $new_cate = explode(':', $cate);//$cate是分类ID:保修期月数
                        $auto_category[$new_cate[0]] = $new_cate[1];
                    }
                }
            }
            $productArr = explode(',', $content_arr[1]);
            if (sizeof($productArr)) {
                foreach ($productArr as $pval) {
                    if ($pval) {
                        $new_pval = explode(':', $pval);     //$pval是 产品ID:保修期月数
                        $auto_product[$new_pval[0]] = $new_pval[1];
                    }
                }
            }
        }
        //先判断该产品ID是否在需要人工审核的产品ID数组中
        if (in_array($products_id, $customProArr)) {
            $check = true;
        } else {
            //根据产品ID查找对应的分类ID以及所有的父分类ID
            $cPath = $this->common->getProductsCategories($products_id);
            $cPathArr = explode('_', $cPath);
            $cNum = sizeof($cPathArr);
            for ($jj = 1; $jj < $cNum; $jj++) {
                if (in_array($cPathArr[$jj], $customArr)) {
                    $check = true;
                }
            }
        }
        if (!$check && $transit_time) {
            //该产品属于自动审核分类且有具体的发货时间 在判断是否有保修期限制
            $key_product = array_keys($auto_product);
            $key_category = array_keys($auto_category);
            if (in_array($products_id, $key_product)) {
                //该产品有保修期限制
                $warranty_day = '+' . (int)$auto_product[$products_id] . 'month';
                $warranty_time = strtotime("$transit_time.$warranty_day");
                if ($warranty_time < time()) {
                    //若是从发货之日起已经超出保修时间 则需要人工审核
                    $check = true;
                }
            } else {
                //根据产品ID查找对应的分类ID以及所有的父分类ID
                $cPath = $this->common->getProductsCategories($products_id);
                $cPathArr = explode('_', $cPath);
                $cNum = sizeof($cPathArr);
                for ($jj = 1; $jj < $cNum; $jj++) {
                    if (in_array($cPathArr[$jj], $key_category)) {
                        //该产品对应的分类有保修期限制 则需要人工审核
                        $warranty_day = '+' . (int)$auto_category[$cPathArr[$jj]] . 'month';
                        $warranty_time = strtotime("$transit_time.$warranty_day");
                        if ($warranty_time < time()) {
                            //若是从发货之日起已经超出保修时间 则需要人工审核
                            $check = true;
                        }
                    }
                }
            }
        }
        return $check;
    }

    /**
     * 售后申请数据插入
     * @param $rma_array
     * @return bool
     */
    protected function insertRmaApply($rma_array)
    {
        $return = array('status' => 0, 'data' => '', 'msg' => '');
        DB::connection()->beginTransaction();

        try {
            $customers_service_id = '';
            foreach ($rma_array as $rma_key => $rma_val) {
                switch ($rma_key) {
                    case 'customers_service':
                        $customers_service_id = $this->rma_m->insertGetId($rma_val);
                        break;
                    case 'customers_service_address':
                        if (empty($customers_service_id)) {
                            $return['msg'] = 'Data insert failed';
                            return $return;
                        }
                        foreach ($rma_val as $key => $value) {
                            $rma_val[$key]['customers_service_id'] = $customers_service_id;
                            if ($key == 1) {
                                $this->rma_am->insert($rma_val[$key]);
                            } else {
                                $rma_val[$key]['type'] = $key;
                                $this->rma_am->insert($rma_val[$key]);
                            }
                        }
                        break;
                    case 'customers_service_products':
                        foreach ($rma_val as $p_key => $products) {
                            $products['service_id'] = $customers_service_id;
                            $rma_val[$p_key] = $products;
                        }
                        $this->rma_pm->insert($rma_val);
                        break;
                    case 'customers_service_history':
                        foreach ($rma_val as $h_key => $his) {
                            $his['service_id'] = $customers_service_id;
                            $rma_val[$h_key] = $his;
                        }
                        $this->rma_hm->insert($rma_val);
                        break;
                }
            }

            DB::connection()->commit();
            $return = array('status' => 1, 'data' => $customers_service_id);
            return $return;
        } catch (\Exception $e) {
            DB::connection()->rollBack();
            $return['msg'] = 'Data insert failed';
            return $return;
        }
    }

    /**
     * dylan 2020.4.15
     *售后上传文件
     */
    public function uploadRmaPic($fileInput)
    {
        $upload = new UploadService();
        $return_dir = 'return';
        $upload->setConfig([
            'savePath' => $return_dir,
            'fileSize' => "5M",
            'fileExtension' => ['application/pdf', 'image/png', 'image/gif', 'image/jpg', 'image/bmp', 'image/jpeg']
        ]);

        if (is_array($fileInput)) {
            $paths = $upload->uploads($fileInput);
            $path = [];
            if (!empty($paths)) {
                foreach ($paths as $v) {
                    $path[] = $v['path'];
                }
            }
            if (!empty($path)) {
                return ['code' => 1 ,'path' => $path];
            } else {
                return ['code' => 0 ];
            }
        } else {
            return ['code' => 0 ];
        }
    }

    /**
     * 更新打印售后标签状态
     * @param $where
     */
    public function updateLabelStatus($where)
    {
        $this->rma_m->where($where)->update(['print_status' => 1]);
    }
}
