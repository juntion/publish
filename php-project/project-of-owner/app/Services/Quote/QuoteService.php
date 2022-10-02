<?php


namespace App\Services\Quote;

use App\Models\FsQuotesOfflineCustomers;
use App\Models\FsQuotesPayment;
use App\Models\FsQuotesProductsLength;
use App\Services\BaseService;
use App\Models\FsQuote;
use App\Models\FsQuotesProducts;
use App\Models\FsQuotesAddress;
use App\Models\FsQuotesTotal;
use App\Models\FsQuotesCustomers;
use App\Models\FsQuotesProductsAttributes;
use App\Models\FsQuotesOrders;
use App\Models\FsQuotesHistory;
use App\Models\FsQuotesProdcutsHistory;

use App\Services\Common\CurrencyService;
use App\Services\Products\ProductService;
use App\Services\Products\ProductAttributeService;
use App\Services\Common\Redis\RedisService;
use App\Services\Orders\OrderService;
use App\Services\Customers\CustomerService;
use App\Services\Admins\AdminService;
use Aws\CloudFront\Exception\Exception;
use classes\shipAreaSign;
use Illuminate\Database\Capsule\Manager as DB;

class QuoteService extends BaseService
{
    private $quote_m;
    private $quote_ads_m;
    private $quote_products_m;
    private $quote_total_m;
    private $quote_customers_m;
    private $quote_offline_customers_m;
    private $quote_order_m;
    private $quote_attr_m;
    private $quote_attr_length_m;
    private $quote_his_m;
    private $quote_his_products_m;

    private $curr;
    private $products_s;
    private $customers_s;
    private $products_attr_s;
    private $orders_s;
    private $admin_s;
    private $redis;
    private $field = [];
    public $totalCount = 0;
    public $quoteInfo = [];

    public function __construct()
    {
        parent::__construct();
        $this->quote_m = new FsQuote();
        $this->quote_ads_m = new FsQuotesAddress();
        $this->quote_products_m = new FsQuotesProducts();
        $this->quote_total_m = new FsQuotesTotal();
        $this->quote_customers_m = new FsQuotesCustomers();
        $this->quote_offline_customers_m = new FsQuotesOfflineCustomers();
        $this->quote_attr_m = new FsQuotesProductsAttributes();
        $this->quote_attr_length_m = new FsQuotesProductsLength();
        $this->quote_order_m = new FsQuotesOrders();
        $this->quote_his_m = new FsQuotesHistory();
        $this->quote_his_products_m = new FsQuotesProdcutsHistory();

        $this->curr = new CurrencyService();
        $this->customers_s = new CustomerService();
        $this->redis = new RedisService();
        $this->orders_s = new OrderService();
        $this->products_s = new ProductService();
        $this->products_attr_s = new ProductAttributeService();
        $this->admin_s = new AdminService();
    }

    public function setField($filed)
    {
        if (is_array($filed)) {
            $this->field = array_merge($this->field, $filed);
        } else {
            $this->field = array_merge($this->field, [$filed]);
        }
        return $this;
    }

    /**
     * 报价列表
     *
     * @param $where_data
     * @return array
     */
    public function getQuotesList($where_data)
    {
        $res_arr = [];
        $res_count = 0;
        $offset = 0;
        $quotes_id_arr = $this->getAllQuotesIdByCustomers($_SESSION['customer_id']);
        if (!empty($where_data['quotes_number'])) {
            $quotes_id_arr = $this->getAllQuotesIdByQuotesNumber($where_data['quotes_number'], $quotes_id_arr);
        }
        if (empty($quotes_id_arr)) {
            return [];
        }

        $sql_obj = $this->quote_m
            ->with(['quotesProducts' => function ($q) {
                $q->select(
                    'quotes_products_id',
                    'quotes_id',
                    'products_id',
                    'products_qty',
                    'products_model',
                    'products_name',
                    'products_quotes_price',
                    'composite_son_quote_products'
                );
            }, 'quotesAddress' => function ($q) {
                $q->select()->orderby('address_type');
            }, 'quotesTotal' => function ($q) {
                $q->select();
            }, 'quotesAttributes' => function ($q) {
                $q->select()->where('products_options_values_id', '<>', 0)->where('products_options_type', 1);
            }, 'quotesLength' => function ($q) {
                $q->select();
            }, 'quotesOrders' => function ($q) {
                $q->select();
            }]);
        //不存在报价编号时才搜索其他条件
        if (empty($where_data['quotes_number'])) {
            foreach ($where_data as $w_key => $w_val) {
                if (!empty($w_val)) {
                    switch ($w_key) {
                        case 'pages':
                            $offset = (intval($where_data['pages']) - 1) * 10;
                            break;
                        case 'status':
                            if ($where_data['is_handle']) {
                                $is_handle = $where_data['is_handle'];
                                $sql_obj->where(function ($query) use ($w_val, $is_handle) {
                                    $query->where('status', $w_val)->orwhere('is_handle', $is_handle);
                                });
                            } else {
                                $sql_obj->where('status', $w_val);
                            }
                            break;
                        case 'time_type':
                            $stamp_arr = self::getWhereTimeStamp($w_val);
                            if ($w_val == 4) {//一年前的报价单
                                $sql_obj->where('create_time', '<', $stamp_arr['min']);
                            } else {
                                $sql_obj->where('create_time', '>', $stamp_arr['min']);
                                $sql_obj->where('create_time', '<', $stamp_arr['max']);
                            }
                            break;
                    }
                }
            }
            if ($where_data['pages'] != 1) {
                $offset = ((int)$where_data['pages'] - 1) * 10;
            }
        }
        $sql_obj->whereIn('id', $quotes_id_arr);
        $res_count = $sql_obj->count();

        //var_dump($sql_obj);die;
        $res_obj = $sql_obj->offset($offset)
            ->limit(10)
            ->orderby('id', 'desc')
            ->get();

        if (!$res_obj->isEmpty()) {
            $res_arr = $res_obj->toArray();

            foreach ($res_arr as $k => $val) {

                $attributes_obj = collect($val['quotes_attributes']);
                $quotes_attributes = $attributes_obj->groupBy('quotes_products_id');

                $length_obj = collect($val['quotes_length']);
                $quotes_length = $length_obj->groupBy('quotes_products_id');

                $customers_arr = $this->customers_s->setField('discount_rate')
                    ->firstCustomer($val['customers_id']);
                $discount_rate = $customers_arr['discount_rate'];

                $quotes_products_format =
                    $this->getFormatQuotesProducts(
                        $val['quotes_products'],
                        $val['currency'],
                        $val['currency_value'],
                        $quotes_attributes,
                        $quotes_length,
                        $discount_rate
                    );

                $res_arr[$k]['quotes_products'] = $quotes_products_format['data'];
                $sub_total = $quotes_products_format['sub_total'];//用于计算澳大利亚展示的税后价格

                $res_arr[$k]['quotes_total'] =
                    $this->getFormatQuotesTotal($val['quotes_total']);

                $res_arr[$k]['quotes_total_code'] =
                    $this->getFormatQuotesTotalCode($val['quotes_total']);
                //澳洲展示税后价
                if ($val['currency'] == 'AUD') {
                    $res_arr[$k]['quotes_total']['shipping_cost'] = $this->curr->format(
                        $res_arr[$k]['quotes_total_code']['shipping_cost'] * 1.1,
                        2,
                        true,
                        $val['currency'],
                        $val['currency_value']
                    );

                    //$sub_total的价格已经经过了转换,因此不用换算汇率
                    $res_arr[$k]['quotes_total']['subtotal'] = $this->curr->format(
                        $sub_total,
                        2,
                        false,
                        $val['currency'],
                        $val['currency_value']
                    );
                    $shipping_cost_data = $this->curr->format(
                        $res_arr[$k]['quotes_total_code']['shipping_cost'] * 1.1,
                        2,
                        true,
                        $val['currency'],
                        $val['currency_value'],
                        false
                    );

                    $total = $sub_total + $shipping_cost_data;
                    $res_arr[$k]['quotes_total']['total'] = $this->curr->format(
                        $total,
                        2,
                        false,
                        $val['currency'],
                        $val['currency_value']
                    );
                }


                unset($res_arr['quotes_attributes']);
                unset($res_arr['quotes_length']);
            }
        }
        return array('data' => $res_arr, 'count' => $res_count);
    }

    /**
     * $Notes: 获取用户所有报价单id
     *
     * $author: Quest
     * $Date: 2020/12/24
     * $Time: 15:14
     * @param int $customer_id
     * @return array
     */
    public function getAllQuotesIdByCustomers($customer_id = 0)
    {
        $customer_id = $customer_id == 0 ? $_SESSION['customer_id'] : $customer_id;
        $quotes_id_res = $this->quote_customers_m
            ->select('quotes_id')
            ->where('customers_id', $customer_id)
            ->get();
        if (empty($quotes_id_res)) {
            return [];
        }
        $quotes_id_res = $quotes_id_res->toArray();
        $quotes_id_arr = array_column($quotes_id_res, 'quotes_id');
        return $quotes_id_arr;
    }

    /**
     * $Notes: 根据单号或产品id获取用户所有报价单id
     *
     * $author: Quest
     * $Date: 2020/12/30
     * $Time: 17:46
     * @param $quotes_number
     * @param $quotes_id_arr
     * @return array
     */
    public function getAllQuotesIdByQuotesNumber($quotes_number, $quotes_id_arr)
    {
        $quotes_id_res = $this->quote_m
            ->select('quotes_id')->from('fs_quotes as fq')
            ->leftjoin('fs_quotes_products as fqp', 'fq.id', '=', 'fqp.quotes_id')
            ->whereIn('fq.id', $quotes_id_arr)
            ->where(function ($q) use ($quotes_number) {
                $q->where('fq.quotes_number', $quotes_number)
                    ->orwhere('fqp.products_id', $quotes_number);
            })
            ->get();

        if (empty($quotes_id_res)) {
            return [];
        }
        $quotes_id_res = $quotes_id_res->toArray();
        $quotes_id_arr = array_column($quotes_id_res, 'quotes_id');
        return $quotes_id_arr;
    }

    /**
     * $Notes: 报价详情页
     *
     * $author: Quest
     * $Date: 2020/12/24
     * $Time: 12:23
     * @param $quotes_id
     * @param bool $is_all_attr
     * @param bool $is_need_shipping
     * @return array
     */
    public function getQuotesDetails($quotes_id, $is_all_attr = false)
    {
        $res_arr = [];
        $sql_obj = $this->quote_m
            ->with(['quotesProducts' => function ($q) {
                $q->select(
                    'quotes_products_id',
                    'quotes_id',
                    'products_id',
                    'products_prid',
                    'products_qty',
                    'products_model',
                    'products_name',
                    'products_price',
                    'products_origin_price',
                    'products_quotes_price',
                    'onetime_charges',
                    'relate_material_id',
                    'composite_son_quote_products'
                );
            }, 'quotesAddress' => function ($q) {
                $q->select()->orderby('address_type');
            }, 'quotesTotal' => function ($q) {
                $q->select();
            }, 'quotesAttributes' => function ($q) use ($is_all_attr) {
                if ($is_all_attr) {
                    $q->select();
                } else {
                    $q->select()->where('products_options_values_id', '<>', 0)->where('products_options_type', 1);
                }
            }, 'quotesLength' => function ($q) {
                $q->select();
            }, 'quotesOrders' => function ($q) {
                $q->select();
            }])
            ->where('id', $quotes_id);

        $res_obj = $sql_obj->first();
        if ($res_obj) {
            $res_arr = $res_obj->toArray();

            $customers_arr = $this->customers_s->setField('discount_rate')
                ->firstCustomer($res_arr['customers_id']);
            $discount_rate = $customers_arr['discount_rate'];

            $attributes_obj = collect($res_arr['quotes_attributes']);
            $quotes_attributes = $attributes_obj->groupBy('quotes_products_id');

            $length_obj = collect($res_arr['quotes_length']);
            $quotes_length = $length_obj->groupBy('quotes_products_id');

            $quotes_products_format = $this->getFormatQuotesProducts(
                $res_arr['quotes_products'],
                $res_arr['currency'],
                $res_arr['currency_value'],
                $quotes_attributes,
                $quotes_length,
                $discount_rate
            );
            $res_arr['quotes_products'] = $quotes_products_format['data'];
            $sub_total = $quotes_products_format['sub_total'];//用于计算澳大利亚展示的税后价格
            unset($res_arr['quotes_attributes']);
            unset($res_arr['quotes_length']);

            $quotes_total_ori = $res_arr['quotes_total'];
            $res_arr['quotes_total'] =
                $this->getFormatQuotesTotal($quotes_total_ori);

            $res_arr['quotes_total_code'] =
                $this->getFormatQuotesTotalCode($quotes_total_ori);

            //澳洲展示税后价
            if ($res_arr['currency'] == 'AUD') {
                $res_arr['quotes_total']['shipping_cost'] = $this->curr->format(
                    $res_arr['quotes_total_code']['shipping_cost'] * 1.1,
                    2,
                    true,
                    $res_arr['currency'],
                    $res_arr['currency_value']
                );

                //$sub_total的价格已经经过了转换,因此不用换算汇率
                $res_arr['quotes_total']['subtotal'] = $this->curr->format(
                    $sub_total,
                    2,
                    false,
                    $res_arr['currency'],
                    $res_arr['currency_value']
                );
                $shipping_cost_data = $this->curr->format(
                    $res_arr['quotes_total_code']['shipping_cost'] * 1.1,
                    2,
                    true,
                    $res_arr['currency'],
                    $res_arr['currency_value'],
                    false
                );

                $total = $sub_total + $shipping_cost_data;
                $res_arr['quotes_total']['total'] = $this->curr->format(
                    $total,
                    2,
                    false,
                    $res_arr['currency'],
                    $res_arr['currency_value']
                );
            }
        }

        return $res_arr;
    }

    /**
     * 获取报价的产品信息
     *
     * @param $products_arr
     * @param $currency
     * @param $currency_val
     * @param array $quotes_attributes
     * @param array $quotes_length
     * @return mixed
     */
    public function getFormatQuotesProducts($products_arr, $currency, $currency_val, $quotes_attributes = [],
                                            $quotes_length = [], $discount_rate = 1)
    {
        $sub_total = 0;
        foreach ($products_arr as $p_key => $p_val) {

            $products_id = $p_val['products_id'];
            $quotes_products_id = $p_val['quotes_products_id'];

            //产品状态及图片信息
            $warehouse_info = $this->fsProductsWarehouseWhere($this->countries_iso_code);
            $warehouse_code = $warehouse_info['code'] . '_status';
            $products_info = $this->products_s->setField([$warehouse_code, 'products_status'])
                ->getOneProductInfo($products_id, false, false);

            $products_arr[$p_key]['products_status'] =
                $products_info[$warehouse_code] == 1 && $products_info['products_status'] ? 1 : 0;
            $products_arr[$p_key]['images'] = $products_info['source_image'];
            $products_arr[$p_key]['products_name'] = $products_info['product_description']['products_name'];

            //价格转换币种
            $products_quotes_price = $currency == 'AUD' ?
                $p_val['products_quotes_price'] * 1.1 : $p_val['products_quotes_price'];
            $products_arr[$p_key]['products_quotes_price_text'] = $this->curr->format(
                $products_quotes_price,
                2,
                true,
                $currency,
                $currency_val
            );

            //产品总价必须用已转币种的产品价格相加, 不然税后价会产生误差
            $price_data = $this->curr->getProductFinalPrice($products_quotes_price * $currency_val,
                2);
            $price_data = self::zenRound($price_data, $this->curr->currencies[$currency]['decimal_places']);
            $sub_total += $price_data * $p_val['products_qty'];

            if (!empty($p_val['composite_son_quote_products'])) {
                if ($currency == 'AUD') {
                    $products_arr[$p_key]['composite_son_quote_products'] =
                        $this->products_s->getAuCompositeSonProducts(
                            $p_val['composite_son_quote_products'],
                            $currency,
                            $currency_val,
                            $discount_rate
                        );
                } else {
                    $products_arr[$p_key]['composite_son_quote_products'] =
                        $this->products_s->getCompositeSonProducts(
                            $p_val['composite_son_quote_products'],
                            $currency,
                            $currency_val,
                            $discount_rate
                        );
                }
            }

            if (!empty($quotes_attributes[$quotes_products_id])) {
                $products_arr[$p_key]['attributes'] = $quotes_attributes[$quotes_products_id];
            }

            if (!empty($quotes_length[$quotes_products_id])) {
                $products_arr[$p_key]['length'] = $quotes_length[$quotes_products_id];
            }

        }

        return ['sub_total' => $sub_total, 'data' => $products_arr];
    }

    /**
     * 获取报价的价格信息
     *
     * @param $total_arr
     * @return array
     */
    public function getFormatQuotesTotal($total_arr)
    {
        $res = [];
        foreach ($total_arr as $val) {
            switch ($val['code']) {
                case 'ot_tax':
                    $res['tax'] = $val['text'];
                    break;
                case 'ot_subtotal':
                    $res['subtotal'] = $val['text'];
                    break;
                case 'ot_shipping':
                    $res['shipping_cost'] = $val['text'];
                    break;
                case 'ot_total':
                    $res['total'] = $val['text'];
                    break;
            }
        }
        return $res;
    }

    /**
     * 获取报价的价格信息
     *
     * @param $total_arr
     * @return array
     */
    public function getFormatQuotesTotalCode($total_arr)
    {
        $res = [];
        foreach ($total_arr as $val) {
            switch ($val['code']) {
                case 'ot_tax':
                    $res['tax'] = $val['value'];
                    break;
                case 'ot_subtotal':
                    $res['subtotal'] = $val['value'];
                    break;
                case 'ot_shipping':
                    $res['shipping_cost'] = $val['value'];
                    break;
                case 'ot_total':
                    $res['total'] = $val['value'];
                    break;
            }
        }
        return $res;
    }


    /**
     * 检测用户报价权限
     *
     * @param $quotes_id
     * @return mixed
     */
    public function getCheckQuotesCustomers($quotes_id)
    {
        return $this->quote_customers_m->where('quotes_id', $quotes_id)
            ->where('customers_id', $_SESSION['customer_id'])->first();
    }

    /**
     * 获取报价信息
     *
     * @param $quotes_id
     * @return mixed
     */
    public function getQuotesFiled($quotes_id)
    {
        return $this->quote_m->select($this->field)->where('id', $quotes_id)->first();
    }

    /**
     * $Notes: 创建报价单数据
     *
     * $author: Quest
     * $Date: 2020/12/23
     * $Time: 19:02
     * @param $order
     * @param $p_data
     * @return array
     */
    public function createQuotesData($order)
    {
        //时间戳
        $time = time();
        $new_quotes_num = $this->getQuotesNewNumber();
        $customers_arr = $this->customers_s->setCustomer()->firstCustomer();

        //报价插入数据
        $main_quotes_data = array(
            'quotes_number' => $new_quotes_num,
            'customers_id' => $_SESSION['customer_id'],
            'language_id' => $_SESSION['languages_id'],
            'currency' => $_SESSION['currency'],
            'currency_value' => $this->curr->currencies[$_SESSION['currency']]['value'],
            'status' => 1,
            'total_price' => $order->info['total'],
            'payment_method' => !empty($_POST['currentPayment']) ?
                zen_get_order_peyment_method($_POST['currentPayment']) : PAYMENT_METHOD_GV,
            'payment_method_code' => !empty($_POST['currentPayment']) ?
                $_POST['currentPayment'] : PAYMENT_METHOD_GV,
            'shipping_local_method_code' => !empty($_SESSION['shipping_local_quotes']['id']) ?
                $_SESSION['shipping_local_quotes']['id'] : '',
            'shipping_delay_method_code' => !empty($_SESSION['shipping_delay_quotes']['id']) ?
                $_SESSION['shipping_delay_quotes']['id'] : '',
            'shipping_method_param_json' => json_encode($_POST['selectrelate']),
            'warehouse' => $order->local_warehouse,
            'is_reissue' => $order->getIssue(),
            'quotes_comments' => $_POST['quote_create_comments'],
            'admin_id' => $customers_arr['admin_to_customer']['admin_id'],
            'delivery_address_id' => $_POST['delivery_address_id'],
            'billing_address_id' => $_POST['billing_address_id'],
            'reply_time' => '',
            'expired_time' => $time + 3600 * 24 * 15,//15天后过期
            'create_time' => $time,
            'update_time' => $time,
            'site_code' => $_SESSION['languages_code']
        );
        $delivery_address = array(
            'address_type' => 1,
            'entry_firstname' => $order->delivery['firstname'],
            'entry_lastname' => $order->delivery['lastname'],
            'entry_company' => $order->delivery['company'],
            'entry_address_type' => $order->delivery['company_type'],
            'entry_street_address' => $order->delivery['street_address'],
            'entry_suburb' => $order->delivery['suburb'],
            'entry_postcode' => $order->delivery['postcode'],
            'entry_city' => $order->delivery['city'],
            'entry_state' => $order->delivery['state'],
            'entry_zone_id' => $order->delivery['country']['id'],
            'entry_country_id' => $order->delivery['country_id'],
            'entry_country' => $order->delivery['country']['title'],
            'entry_telephone' => $order->delivery['telephone'],
            'entry_tax_number' => $order->delivery['tax_number']
        );
        $billing_address = array(
            'address_type' => 2,
            'entry_firstname' => $order->billing['firstname'],
            'entry_lastname' => $order->billing['lastname'],
            'entry_company' => $order->billing['company'],
            'entry_address_type' => $order->billing['company_type'],
            'entry_street_address' => $order->billing['street_address'],
            'entry_suburb' => $order->billing['suburb'],
            'entry_postcode' => $order->billing['postcode'],
            'entry_city' => $order->billing['city'],
            'entry_state' => $order->billing['state'],
            'entry_zone_id' => $order->billing['country']['id'],
            'entry_country_id' => $order->billing['country_id'],
            'entry_country' => $order->billing['country']['title'],
            'entry_telephone' => $order->billing['telephone'],
            'entry_tax_number' => $order->billing['tax_number']
        );
        $orderTotal = $order->createTotal('all');
        $products_info = $this->getQuotesInsertProducts($order->local_products, $order->delay_products);
        $products_arr = $products_info['data'];
        $his_products = $products_info['his_products'];

        $cart_all_qty = $_SESSION['cart']->count_contents(true);
        if ($products_info['all_qty'] != $cart_all_qty) {

            //编号出列
            $num_redis = $this->redis->getRedisKeyValue('fs_quotes_number_list');
            $num_redis = array_diff($num_redis, [$new_quotes_num]);
            $this->redis->setRedisKeyValue('fs_quotes_number_list', $num_redis, 60);

            return array('flag' => 0, 'msg' => 'SYSTEM BUSY!');
        }
        //获取报价产品属性
        $products_attributes_arr = $this->getQuotesInsertProductsAttributes($order->local_cart_products,
            $order->delay_cart_products);

        //该数组排序不可变更,否则数据插入会出问题
        $insert_data = array(
            'fs_quotes' => $main_quotes_data,
            'fs_quotes_address' => array(
                1 => $delivery_address,
                2 => $billing_address
            ),
            'fs_quotes_products' => $products_arr,
            'fs_quotes_products_attributes' => $products_attributes_arr,
            'fs_quotes_total' => $orderTotal,
            'fs_quotes_customers' => array(
                'customers_id' => $_SESSION['customer_id'],
                'is_origin_customers' => 1,
                'share_time' => time(),
                'data_from' => 0
            ),
            'fs_quotes_history' => array(
                'quotes_number' => $new_quotes_num,
                'customers_id' => $_SESSION['customer_id'],
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s')
            ),
            'fs_quotes_prodcuts_history' => $his_products
        );

        $quotes_data = $this->insertQuotesData($insert_data);
        //编号出列
        $num_redis = $this->redis->getRedisKeyValue('fs_quotes_number_list');
        $num_redis = array_diff($num_redis, [$new_quotes_num]);
        $this->redis->setRedisKeyValue('fs_quotes_number_list', $num_redis, 60);

        if ($quotes_data['flag'] == 0) {
            return $quotes_data;
        }
        $_SESSION['cart']->reset(true);

        return [
            'flag' => 1,
            'msg' => $quotes_data['msg'],
            'data' => array(
                'id' => $quotes_data['data'],
                'number' => $new_quotes_num,
                'products_arr' => $products_arr,
                'products_attributes_arr' => $products_attributes_arr,
            )
        ];
    }

    /**
     * 获取报价新增编号
     *
     * @return string
     */
    public function getQuotesNewNumber()
    {
        //创建RQN编号
        $num_redis = $this->redis->getRedisKeyValue('fs_quotes_number_list');
        if (!empty($num_redis)) {
            $num_last = end($num_redis);
        } else {
            $date = date('Ymd');
            $quotes_obj = $this->quote_m->select('quotes_number')
                ->where('quotes_number', 'like', "%{$date}%")
                ->orderby('id', 'DESC')
                ->limit(1)
                ->first();
            $num_last = $quotes_obj->quotes_number;
            $num_redis = [];
        }

        if (empty($num_last)) {
            $new_quotes_num = 'RQN' . date('Ymd') . '0001';
        } else {
            $int_num = substr($num_last, -4);
            $int_num_nex = intval($int_num) + 1;
            $new_quotes_num = 'RQN' . date('Ymd') . sprintf('%04s', $int_num_nex);
        }
        //编号入列
        $num_redis[] = $new_quotes_num;
        $this->redis->setRedisKeyValue('fs_quotes_number_list', $num_redis, 60);

        return $new_quotes_num;
    }

    /**
     * 格式化产品数据
     *
     * @param array $local_products
     * @param array $delay_products
     * @return array
     */
    public function getQuotesInsertProducts($local_products = [], $delay_products = [])
    {
        $res_arr = [];
        $now_all_qty = 0;
        $his_products = [];
        $time = time();
        foreach ($local_products as $p_val) {

            $res_arr[$p_val['id']] = array(
                'products_id' => zen_get_prid($p_val['id']),
                'products_qty' => $p_val['qty'],
                'products_model' => $p_val['model'],
                'products_name' => $p_val['name'],
                'products_prid' => $p_val['id'],
                'products_origin_price' => $p_val['products_price'],
                'products_price' => $p_val['paypal_price'],
                'products_quotes_price' => $p_val['paypal_price'],
                'onetime_charges' => $p_val['onetime_charges'],
                'relate_material_id' => $p_val['relate_material_id'],
                'create_time' => $time,
                'update_time' => $time
            );
            $his_products[$p_val['id']] = [
                'products_id' => zen_get_prid($p_val['id']),
                'products_price' => $p_val['paypal_price']
            ];

            $products_composite_str = $_SESSION['cart']->get_cart_quotation_combination($p_val['id'], $p_val['qty']);
            $composite_son_products = zen_get_products_composite($p_val['id'], $p_val['qty']);
            $composite_son_products = empty($products_composite_str) ? $composite_son_products :
                $products_composite_str;
            $res_arr[$p_val['id']]['composite_son_products'] = $composite_son_products;
            $res_arr[$p_val['id']]['composite_son_quote_products'] = $composite_son_products;

            $now_all_qty += $p_val['qty'];
        }

        foreach ($delay_products as $p_val) {
            if (isset($res_arr[$p_val['id']])) {
                $res_arr[$p_val['id']]['products_qty'] += $p_val['qty'];
                $now_all_qty += $p_val['qty'];
                continue;
            }
            $res_arr[$p_val['id']] = array(
                'products_id' => zen_get_prid($p_val['id']),
                'products_qty' => $p_val['qty'],
                'products_model' => $p_val['model'],
                'products_name' => $p_val['name'],
                'products_prid' => $p_val['id'],
                'products_origin_price' => $p_val['products_price'],
                'products_price' => $p_val['paypal_price'],
                'products_quotes_price' => $p_val['paypal_price'],
                'onetime_charges' => $p_val['onetime_charges'],
                'relate_material_id' => $p_val['relate_material_id'],
                'create_time' => $time,
                'update_time' => $time
            );

            $his_products[$p_val['id']] = [
                'products_id' => zen_get_prid($p_val['id']),
                'products_price' => $p_val['paypal_price']
            ];

            $products_composite_str = $_SESSION['cart']->get_cart_quotation_combination($p_val['id'], $p_val['qty']);
            $composite_son_products = zen_get_products_composite($p_val['id'], $p_val['qty']);
            $composite_son_products = empty($products_composite_str) ? $composite_son_products :
                $products_composite_str;
            $res_arr[$p_val['id']]['composite_son_products'] = $composite_son_products;
            $res_arr[$p_val['id']]['composite_son_quote_products'] = $composite_son_products;

            $now_all_qty += $p_val['qty'];
        }

        return array('data' => $res_arr, 'all_qty' => $now_all_qty, 'his_products' => $his_products);
    }

    /**
     * 获取报价单属性
     *
     * @param array $local_cart_products
     * @param array $delay_cart_products
     * @return array
     */
    public function getQuotesInsertProductsAttributes($local_cart_products = [], $delay_cart_products = [])
    {
        $res_arr = [];
        $attr_model = array(
            array('key' => 'attributes', 'type' => 1),
            array('key' => 'attributes_values', 'type' => 2),
            array('key' => 'attributes_file', 'type' => 3),
        );
        if (!empty($local_cart_products)) {
            foreach ($local_cart_products as $p_val) {
                $res_arr[$p_val['id']] = [];
                foreach ($attr_model as $val) {
                    $this->getQuotesProductsAttributeFormat($res_arr, $p_val['id'], $p_val[$val['key']], $val['type']);
                }
            }
        }
        if (!empty($delay_cart_products)) {
            foreach ($delay_cart_products as $p_val) {
                $res_arr[$p_val['id']] = [];
                foreach ($attr_model as $val) {
                    $this->getQuotesProductsAttributeFormat($res_arr, $p_val['id'], $p_val[$val['key']], $val['type']);
                }
            }
        }

        return $res_arr;
    }

    /**
     * 格式化报价产品属性
     *
     * @param $res_arr
     * @param $key
     * @param $attr_arr
     * @param $type
     */
    public function getQuotesProductsAttributeFormat(&$res_arr, $key, $attr_arr, $type)
    {
        foreach ($attr_arr as $attr_key => $attr) {

            if ($attr_key == 'length') {

                $length_obj = $this->products_attr_s->getOptionsLengthById($attr);
                $res_arr[$key]['length'] = array(
                    'quotes_products_length_id' => $attr,
                    'length_price' => !$length_obj ? '' : $length_obj->length_price,
                    'length_name' => !$length_obj ? '' : $length_obj->length,
                );

            } else {
                //获取属性项文案和属性值文案
                $option_obj = $this->products_attr_s->getOptionsNameById(
                    $attr_key,
                    'products_options_name'
                );
                $option_values_obj = $this->products_attr_s->getOptionsValuesNameById(
                    $attr,
                    'products_options_values_name'
                );

                $res_arr[$key][] = array(
                    'products_options_id' => $attr_key,
                    'products_options_values_id' => $attr,
                    'products_options' => !$option_obj ? '' : $option_obj->products_options_name,
                    'products_options_values' => ($attr == 0 || !$option_values_obj) ? '' : $option_values_obj->products_options_values_name,
                    'products_options_type' => $type
                );
            }
        }

    }

    /**
     * 生成报价单
     *
     * @param $insert_data
     * @return array
     */
    public function insertQuotesData($insert_data)
    {
        $return = array('flag' => 0, 'mag' => '');

        DB::beginTransaction();
        try {
            $products_attributes = $insert_data['fs_quotes_products_attributes'];
            $quotes_id = '';
            $total_his_price = 0;
            $quote_his_id = 0;
            foreach ($insert_data as $q_key => $q_data) {

                if (in_array($q_key, ['fs_quotes_products', 'fs_quotes_address', 'fs_quotes_total',
                    'fs_quotes_customers'])
                ) {
                    if (!isset($quotes_id) && empty($quotes_id)) {
                        $return['msg'] = 'Application for quotation failed!';
                        return $return;
                    }
                }
                switch ($q_key) {
                    case 'fs_quotes':
                        $quotes_id = $this->quote_m->insertGetId($q_data);
                        break;
                    case 'fs_quotes_products':
                        foreach ($q_data as $products_key => $products_data) {
                            $products_data['quotes_id'] = $quotes_id;
                            $quotes_products_id = $this->quote_products_m->insertGetId($products_data);
                            if (!empty($quotes_products_id) && !empty($products_attributes[$products_key])) {

                                foreach ($products_attributes[$products_key] as $a_key => $attribute_data) {
                                    $attribute_data['quotes_id'] = $quotes_id;
                                    $attribute_data['quotes_products_id'] = $quotes_products_id;
                                    if (strval($a_key) == 'length') {
                                        $this->quote_attr_length_m->insert($attribute_data);
                                    } else {
                                        $this->quote_attr_m->insert($attribute_data);
                                    }
                                }

                            }
                        }
                        break;
                    case 'fs_quotes_address':
                        foreach ($q_data as $ads_data) {
                            $ads_data['quotes_id'] = $quotes_id;
                            $this->quote_ads_m->insert($ads_data);
                        }
                        break;
                    case 'fs_quotes_total':
                        foreach ($q_data as $price_data) {
                            if ($price_data['code'] == 'ot_total') {
                                $total_his_price = $price_data['value'];
                            }
                            $price_data['quotes_id'] = $quotes_id;
                            $this->quote_total_m->insert($price_data);
                        }
                        break;
                    case 'fs_quotes_customers':
                        $q_data['quotes_id'] = $quotes_id;
                        $this->quote_customers_m->insert($q_data);
                        break;
                    case 'fs_quotes_history':
                        $q_data['quotes_id'] = $quotes_id;
                        $q_data['quotes_price'] = $total_his_price;
                        $quote_his_id = $this->quote_his_m->insertGetId($q_data);
                        break;
                    case 'fs_quotes_prodcuts_history':
                        foreach ($q_data as $his_data) {
                            $his_data['quote_his_id'] = $quote_his_id;
                            $this->quote_his_products_m->insert($his_data);
                        }
                        break;
                }
            }
            DB::commit();
            $return = array('flag' => 1, 'msg' => 'Success!', 'data' => $quotes_id);
        } catch (\Exception $e) {
            DB::rollBack();
            $return['msg'] = 'SYSTEM BUSY!';
        }
        return $return;

    }

    /**
     * 获取报价结算数据
     *
     * @param $quotes_id
     * @return array
     */
    public function getQuotesDataForCheckout($quotes_id)
    {

        $quotes_info = $this->getQuotesDetails($quotes_id, true);
        if ($quotes_info['status'] != 1) {
            return [];
        }
        $this->quoteInfo = [
            'delivery_address_id' => $quotes_info['delivery_address_id'] ? $quotes_info['delivery_address_id'] : 0,
            'billing_address_id' => $quotes_info['billing_address_id'] ? $quotes_info['billing_address_id'] : 0,
            'payment_method_code' => $quotes_info['payment_method_code'] ? $quotes_info['payment_method_code'] : '',
            'shipping_local_method_code' => $quotes_info['shipping_local_method_code'] ? $quotes_info['shipping_local_method_code'] : '',
            'shipping_delay_method_code' => $quotes_info['shipping_delay_method_code'] ? $quotes_info['shipping_delay_method_code'] : '',
            'shipping_method_param_json' => $quotes_info['shipping_method_param_json'] ? $quotes_info['shipping_method_param_json'] : []
        ];

        $quotes_products_arr = $quotes_info['quotes_products'];

        $res_data = [];
        foreach ($quotes_products_arr as $p_val) {
            $products_obj = $this->products_s->getOneProductField($p_val['products_id']);
            $this->totalCount += $p_val['products_qty'];
            $main_data = array(
                'id' => !empty($p_val['products_prid']) ? $p_val['products_prid'] : $p_val['products_id'],
                'category' => $this->products_s->getCurrentCategories($p_val['products_id'])[0],
                'name' => $p_val['products_name'],
                'model' => $p_val['products_model'],
                'image' => $products_obj->products_image,
                'price' => $p_val['products_origin_price'],
                'quantity' => $p_val['products_qty'],
                'usual_qty' => $p_val['products_qty'],
                'weight' => $products_obj->products_weight,
                'view_weight' => $products_obj->products_weight_for_view,
                'products_price' => $p_val['products_origin_price'],
                'final_price' => $p_val['products_quotes_price'],
                'onetime_charges' => empty($p_val['onetime_charges']) ? 0 : $p_val['onetime_charges'],
                'tax_class_id' => 0,
                'products_priced_by_attribute' => $products_obj->products_priced_by_attribute,
                'product_is_free' => $products_obj->product_is_free,
                'products_discount_type' => $products_obj->products_discount_type,
                'products_discount_type_from' => $products_obj->products_discount_type_from,
                'show_type' => $products_obj->show_type,
                'products_status' => $products_obj->products_status,
                'clearance_qty' => 0,//结算页没用到
                'is_clearance' => 0,//结算页没用到
                'instockHtml' => '',
                'relate_material_id' => $p_val['relate_material_id'],
                'relate_material_data' => [],//结算页没用到
                'orders_number' => '',
                'tax_after_price' => $this->curr->getWholeDollarPrice(
                    $p_val['products_quotes_price'] * 1.1, $products_obj->integer_state),
                'is_checked' => 1,
                'fiber_count' => [],
            );

            $attributes = [];
            $attributes_values = [];
            $attributes_file = [];
            if (isset($p_val['attributes'])) {
                foreach ($p_val['attributes'] as $attr_val) {
                    switch ($attr_val['products_options_type']) {
                        case 1:
                            $attributes[$attr_val['products_options_id']] = $attr_val['products_options_values_id'];
                            break;
                        case 2:
                            $attributes_values[$attr_val['products_options_id']] =
                                $attr_val['products_options_values_id'];
                            break;
                        case 3:
                            $attributes_file[$attr_val['products_options_id']] =
                                $attr_val['products_options_values_id'];
                            break;
                    }

                }
            }
            if (isset($p_val['length'])) {
                foreach ($p_val['length'] as $length_val) {
                    $attributes['length'] = $length_val['quotes_products_length_id'];
                }
            }
            $main_data['attributes'] = $attributes;
            $main_data['attributes_values'] = $attributes_values;
            $main_data['attributes_file'] = $attributes_file;

            if (!empty($attributes)) {
                $attributes_weight = $this->getAttributesWeight($attributes, $p_val['products_id']);
                $main_data['weight'] += $attributes_weight;
                $main_data['view_weight'] += $attributes_weight;
            }

            $res_data[] = $main_data;
        }

        return $res_data;
    }

    /**
     * $Notes: 获取报价总金额
     *
     * $author: Quest
     * $Date: 2020/12/31
     * $Time: 10:36
     * @param $quotes_id
     * @return array
     */
    public function getQuotesTotalInfo($quotes_id)
    {
        $total_obj = $this->quote_total_m->select()->where('quotes_id', $quotes_id)->get();
        if ($total_obj->isEmpty()) {
            return [];
        }
        $total_arr = $total_obj->toArray();
        $res = [];
        foreach ($total_arr as $t_val) {
            $res[$t_val['code']] = $t_val['value'];
        }
        return $res;
    }

    /**
     * $Notes: 分享报价
     *
     * $author: Quest
     * $Date: 2020/12/24
     * $Time: 11:39
     * @param $insert_data
     */
    public function shareQuotesData($insert_data)
    {
        $this->quote_customers_m->insert($insert_data);
    }

    /**
     * $Notes: 存储线下客户邮箱数据
     *
     * $author: Quest
     * $Date: 2021/2/6
     * $Time: 16:36
     * @param $insert_data
     */
    public function shareQuotesOfflineCustomers($insert_data)
    {
        $this->quote_offline_customers_m->insert($insert_data);
    }

    /**
     * $Notes: 检测查看报价pdf权限
     *
     * $author: Quest
     * $Date: 2021/2/7
     * $Time: 9:58
     * @param $quotes_id
     * @return bool
     */
    public function checkQuotesPdfPermissions($quotes_id)
    {
        $customers_id = $_SESSION['customer_id'];
        $customers_email = $_SESSION['customers_email_address'];
        $bool_return = false;

        $res_id_obj = $this->quote_customers_m
            ->select('id')
            ->where('quotes_id', $quotes_id)
            ->where('customers_id', $customers_id)
            ->get();
        if (!$res_id_obj->isEmpty()) {
            $bool_return = true;
        }

        //该报价单对应的销售拥有查看权限
        $res_admin_obj = $this->quote_m->select('admin_id')->where('id', $quotes_id)->first();
        $res_admin_name = $this->admin_s->setField(['admin_email', 'code_email'])->setAdmin($res_admin_obj->admin_id);
        if (strtolower($res_admin_name->currentAdmin->admin_email) == strtolower($customers_email) || strtolower($res_admin_name->currentAdmin->code_email) == strtolower($customers_email)) {
            $bool_return = true;
        }

        $res_email_obj = $this->quote_offline_customers_m
            ->select('id')
            ->where('customers_email', $customers_email)
            ->get();
        if (!$res_email_obj->isEmpty()) {
            $bool_return = true;
        }

        return $bool_return;
    }

    /**
     * $Notes: 报价下单更新
     *
     * $author: Quest
     * $Date: 2020/12/22
     * $Time: 20:57
     * @param $quotes_id
     * @param $orders_id
     * @return array
     */
    public function updateQuotesOrdersStatus($quotes_id, $orders_id)
    {
        $return = array('status' => 0, 'msg' => '');
        $time = time();
        $currentOrder = $this->orders_s->setField('customers_id')->setOrder($orders_id)->currentOrder;
        $orders_number = $currentOrder->orders_number;
        $customers_id = $currentOrder->customers_id;
        $quotes_orders_data = array(
            'quotes_id' => $quotes_id,
            'orders_id' => $orders_id,
            'orders_number' => $orders_number,
            'customers_id' => $customers_id,
            'create_time' => $time,
            'update_time' => $time
        );

        DB::beginTransaction();
        try {
            $insert_res = $this->quote_order_m->insert($quotes_orders_data);
            $update_res = $this->quote_m->where('id', $quotes_id)->update(['status' => 2]);
            if (empty($insert_res) || empty($update_res)) {
                $return['msg'] = 'error';
                return $return;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $return['msg'] = 'error';
            return $return;
        }
        return array('status' => 200, 'msg' => 'success');
    }


    /**
     * $Notes: 更新报价单的过期状态
     *
     * $author: Quest
     * $Date: 2021/1/14
     * $Time: 14:41
     */
    public function updateQuotesExpiredStatus()
    {
        $time = time();
        $data = $data = ['status' => 3];

        $res = 0;
        try {
            $res_select = $this->quote_m
                ->select()
                ->where('status', '<>', 3)
                ->where('expired_time', '<=', $time)
                ->get();
            if (!$res_select->isEmpty()) {
                $res = $this->quote_m
                    ->where('status', '<>', 3)
                    ->where('expired_time', '<=', $time)
                    ->update($data);
            }
            return $res;
        } catch (Exception $e) {
            return $res;
        }

    }

    /**
     * $Notes: 获取定制产品定制属性重量
     *
     * $author: Quest
     * $Date: 2021/1/28
     * $Time: 17:15
     * @param $attr_data
     * @param $products_id
     * @return float|int|mixed
     */
    public function getAttributesWeight($attr_data, $products_id)
    {
        $attribute_weight = 0;
        $options_id = $values_id = $attributes = [];
        reset($attr_data);
        while (list($option, $value) = each($attr_data)) {
            //长度属性的重量
            if ($option == 'length') {
                //如果长度区间重量[products_length_weight]数据存在就获取不同长度区间的加重数据
                $length = fs_get_data_from_db_fields('length', 'products_length', 'id=' . (int)$value, 'limit 1');
                if (get_products_length_weight_count((int)$products_id)) {
                    $lengthWeight = zen_get_products_length_weight((int)$products_id, $length, $attr_data);
                } else {
                    //仍然查找之前的products_length重量记录
                    $lengthWeight = get_length_weight($value);
                }
                $attribute_weight += $lengthWeight;
            } else {
                $options_id[] = (int)$option;
                $values_id[] = (int)$value;
                $attributes[(int)$option][(int)$value] = 0;
            }
        }
        // 一条SQL查所有属性项的重量
        $attribute_weight_new = get_products_all_attribute_weight_new((int)$products_id, $attributes);
        $attribute_weight += $attribute_weight_new;

        return $attribute_weight;
    }

}
