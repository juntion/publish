<?php

namespace App\Services\Billing;

use App\Models\Country;
use App\Services\BaseService;
use App\Models\Order;
use App\Models\OrderSplit;
use App\Models\ProductsInstockShipping;
use App\Services\Common\CurrencyService;
use Aws\CloudFront\Exception\Exception;
use Guzzle\Http\Client;
use Illuminate\Database\Capsule\Manager as DB;
use Monolog\Handler\IFTTTHandler;

class BillingService extends BaseService
{
    private $order;
    private $orderSplit;
    private $productsIS;
    private $curr;
    protected $whereRelations;
    public $orderType;
    public $orderTableName;
    const ORDERS = 'orders';
    const ORDERS_SPLIT = 'orders_split';
    const SECREKEY = 'xsacsdqweSasdc1d5f2';
    const APPID    = '34252352343543';
    const SECRETID = 'acsadsadasda211dacsadsqwe';
    const API_URL  = 'http://test.whgxwl.com:8007/YX_kVc2yo2cmw0U/getAmountStatus.php';

    public function __construct($orderType = 1)
    {
        parent::__construct();

        $this->order = new order();
        $this->orderSplit = new OrderSplit();
        $this->productsIS = new ProductsInstockShipping();
        $this->curr = new CurrencyService();
        $this->orderType = $orderType;
    }

    /**
     * @Notes:线上单billing满足条件
     *
     * @return mixed
     * @auther: Helun smile
     * @Date: 2021/1/12
     * @Time: 14:34
     */
    public function whereRelation()
    {
        return $this->order
            ->whereNotExists(function ($query){
                $query->from('products_instock_shipping_apply as pr')
                    ->select(['apply_type'])
                    ->where('apply_type', '=', 23)
                    ->where('status', '=', 1)
                    ->where('pr.products_instock_id','products_instock_shipping.products_instock_id');
            })
            //查询订单状态
            ->with([
                'orderStatusHistory' => function($query) {
                    $query->where('customer_notified', '>=', '0')
                        ->where('orders_status_id', 2)
                        ->select(['orders_id', 'date_added', 'orders_status_id'])
                        ->orderBy('date_added', 'desc');
                }
            ])
            ->leftJoin('orders_total', 'orders_total.orders_id', '=', 'orders.orders_id')
            ->where('orders_total.class', 'ot_total')
            ->leftJoin('products_instock_shipping', 'products_instock_shipping.orders_id', '=', 'orders.orders_id')
            ->join('fs_invoice_number','fs_invoice_number.relate_id', '=', 'products_instock_shipping.products_instock_id')
            //限制只查询后台订单表没有进行拆单、取单处理的单
            ->whereNotIn('products_instock_shipping.delete_orders_payment', [1,3])
            ->where('products_instock_shipping.is_split', '!=', 1)
            ->where('products_instock_shipping.cancel_order_status', 0)
            //限制满足已发货
            ->where(function ($query) {
                $query->where('products_instock_shipping.is_seattle', 0)
                    ->where('products_instock_shipping.is_not_transport', '<', 2)
                    ->where('products_instock_shipping.transport_id', 0)
                    ->where('products_instock_shipping.is_pickup', '!=', 0)
                    ->orWhere('products_instock_shipping.shipping_number', '!=', '');
            })
            ->where('orders.payment_link', '0')
            ->where('orders.customers_id', $this->customer_id);
    }

    /**
     * @Notes:线下单billing满足条件
     *
     * @return mixed
     * @auther: Helun smile
     * @Date: 2021/1/12
     * @Time: 14:34
     */
    public function whereRelationOffline()
    {
        return $this->orderSplit
            ->join('products_instock_shipping', 'products_instock_shipping.products_instock_id', '=', 'orders_split.products_instock_id')
            ->join('orders_split_total', 'orders_split_total.orders_id', '=', 'orders_split.orders_id')
            ->join('fs_invoice_number','fs_invoice_number.relate_id', '=', 'products_instock_shipping.products_instock_id')
            ->where('orders_split_total.class', 'ot_total')
            ->where('orders_split.orders_status', '<>', 5)
            ->where('orders_split.split_main_id', '<>', 1)
            ->where('orders_split.customers_id', $this->customer_id);
    }

    /**
     * @Notes:线上和线下单调用各自的条件以及表名
     *
     * @return array
     * @auther: Helun smile
     * @Date: 2021/1/13
     * @Time: 10:07
     */
    protected function returnRelation()
    {
        $this->orderTableName = self::ORDERS;

        $this->whereRelations = $this->whereRelation();

        if ($this->orderType == 2) {
            $this->orderTableName = self::ORDERS_SPLIT;
            $this->whereRelations = $this->whereRelationOffline();
        }

        return [
            'orderTableName'    => $this->orderTableName,
            'whereRelation'=> $this->whereRelations
        ];
    }

    /**
     * @Notes:线上和线下单billing初始列表总数据
     *
     * @param bool $isCount 计算总数
     * @param array $limit 分页
     * @param array $isPurchaseCycle 是否为账期以及账期周期
     * @auther: Helun smile
     * @Date: 2021/1/12
     * @Time: 15:21
     */
    public function getBillingOrder($isCount = false, $limit = [], $isPurchaseCycle = [])
    {
        try {
            $whereRelation = $this->returnRelation();
            $tableName = $whereRelation['orderTableName'];
            //获取到分组bill
            $billingOrderGroupInfo = $whereRelation['whereRelation']
                ->select('fs_invoice_number.invocie_date','fs_invoice_number.id')
                ->selectRaw('sum('.$tableName.'.order_total) as total')
                ->selectRaw('year(fs_invoice_number.invocie_date) as year')
                ->selectRaw('month(fs_invoice_number.invocie_date) as month')
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year','Desc')
                ->orderBy('month','Desc');
            if ($isCount) {
                $billingOrderGroupInfo = $billingOrderGroupInfo
                    ->get()
                    ->count();
            } else {
                $billingOrderGroupInfo = $billingOrderGroupInfo
                    ->offset($limit['start'] ? $limit['start'] : 0)
                    ->limit($limit['num'] ? $limit['num'] : 4)
                    ->get()
                    ->toArray();
                //循环分组数据，获取到bill详情数据
                $billingOrderInfo = [];
                foreach ($billingOrderGroupInfo as $key => $billGroup){
                    $billingOrderGroupInfo[$key]['total'] = $this->curr->format(
                        $billingOrderGroupInfo[$key]['total'],
                        2,
                        true,
                        $this->currency
                    );
                    $billingOrderInfo = $this->getBillsList($billGroup['year'], $billGroup['month'], $isPurchaseCycle);
                    if ($billingOrderInfo) {
                        if ($isPurchaseCycle['isPurchase']) {
                            //获取账期订单结清状态和未结清总价
                            $billingOrderGroupInfo[$key]['unpaidTotal'] = 0;
                            $billingOrderGroupInfo[$key]['payment_status'] = [];
                            //账期(通过接口拿到结清状态)
                            $getBillsMoney = $this->getBillsMoney($billingOrderInfo, $isPurchaseCycle['isPurchase']);
                            if ($getBillsMoney) {
                                $billingOrderGroupInfo[$key]['unpaidTotal'] = $getBillsMoney['unpaidTotal'];
                                $billingOrderGroupInfo[$key]['payment_status'] = $getBillsMoney['status'];
                                $billingOrderGroupInfo[$key]['payment_status_name'] = $getBillsMoney['status_name'];
                            }
                        }
                        //发票子数据所有币种（判断币种是否相同）
                        $currency_arr = array_column($billingOrderInfo, 'currency');
                        $is_currency = count(array_unique($currency_arr)) > 1 ? false : true;
                        $billingOrderGroupInfo[$key]['currency'] = $currency_arr;
                        $billingOrderGroupInfo[$key]['is_currency'] = $is_currency;
                    }
                    //月份时间转换
                    $billingOrderGroupInfo[$key]['invocie_date'] = date('M Y ', strtotime($billGroup['invocie_date']));
                    $billingOrderGroupInfo[$key]['bills'] = $billingOrderInfo;
                }
            }
        } catch (\Exception $e) {
            $billingOrderGroupInfo = [];
            if ($isCount) {
                $billingOrderGroupInfo = 0;
            }
        }
        return $billingOrderGroupInfo;
    }


    /**
     * @Notes:获取对应年月的发票数据
     *
     * @param int $year
     * @param int $month
     * @param array $isPurchaseCycle 是否为账期以及账期周期
     * @return mixed
     * @auther: Helun smile
     * @Date: 2021/1/13
     * @Time: 10:08
     */
    public function getBillsList($year, $month, $isPurchaseCycle = [])
    {
        try {
            $whereRelation = $this->returnRelation();
            $tableName = $whereRelation['orderTableName'];
            $fieldsDefault = [
                'fs_invoice_number.in_number',
                'fs_invoice_number.invocie_date',
                'products_instock_shipping.products_instock_id',
                $tableName.'.orders_id',
                $tableName.'.purchase_order_num',
                $tableName.'.customers_po',
                $tableName.'.currency',
                $tableName.'_total.text',
                $tableName.'.order_total',
                $tableName.'.delivery_country'
            ];
            if ($this->orderType == 2) {
                $fields = [
                    $tableName.'.is_payment_true',
                    'products_instock_shipping.sales_update_time',
                ];
                $fieldsDefault = array_merge($fieldsDefault, $fields);
            }
            $billsListInfo = $whereRelation['whereRelation']
                ->select($fieldsDefault)
                ->whereRaw('year(fs_invoice_number.invocie_date) = '.$year)
                ->whereRaw('month(fs_invoice_number.invocie_date) = '.$month)
                ->orderBy($tableName.'.orders_id', 'DESC')
                ->get()
                ->toArray();
            if ($billsListInfo) {
                foreach ($billsListInfo as $k => $value) {
                    $billsListInfo[$k]['due_date'] = '';
                    $billsListInfo[$k]['payment_date'] = '';
                    if ($isPurchaseCycle['isPurchase']) {
                        //计算账期的截止日期
                        $billsListInfo[$k]['due_date'] =
                            date("M j, Y", strtotime("+" . $isPurchaseCycle['purchaseDays'] . " day", strtotime($value['invocie_date'])));
                    }
                    //区别线上和线下获取各付款时间
                    if ($this->orderType == 1) {
                        if ($value['order_status_history']) {
                            $billsListInfo[$k]['payment_date'] =
                                date('M j, Y', strtotime($value['order_status_history'][0]['date_added'])) ?: '';
                        }
                    } else {
                        $billsListInfo[$k]['payment_date'] =
                            $value['is_payment_true'] == 1 ? date('M j, Y', strtotime($value['sales_update_time'])) : '';
                    }
                    //发票时间转换
                    $billsListInfo[$k]['invocie_date'] = date('M j, Y ', strtotime($value['invocie_date']));
                    //查找delivery_country国家对应的country_code
                    $country = new Country();
                    $delivery_country_code = $country->where('countries_name', 'like', $value['delivery_country'])
                        ->pluck('countries_iso_code_2');
                    $billsListInfo[$k]['delivery_country_code'] = $delivery_country_code;
                }
            }
        } catch (\Exception $e) {
            $billsListInfo = [];
        }
        return $billsListInfo;
    }

    /**
     * @Notes: 获取到账单的状态信息，总total，逾期total，未付款total
     *
     * @param $bills
     * @param bool $isPurchase
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @auther: Helun smile
     * @Date: 2021/1/16
     * @Time: 15:19
     */
    public function getBillsMoney($bills,$isPurchase = true)
    {
        $total = 0;
        $overDueTotal = 0;
        $unpaidTotal  = 0;
        $status = [];
        if(!empty($bills) && is_array($bills) && is_bool($isPurchase)){

            $bill_numbers = array_column($bills,'products_instock_id');
            $status = $this->getPayStatus($bill_numbers);

            $total  +=array_sum( array_column($bills,'order_total') );

            $status_name = [];
            foreach ($bills as $key=>$val){
                $status_name[$val['products_instock_id']] = self::trans('FS_BILLING_PAID');

                if($status[$val['products_instock_id']] != 'paid'){
                    $status_name[$val['products_instock_id']] = self::trans('FS_BILLING_UNPAID');
                    $unpaidTotal  += $val['order_total'];

                    if($isPurchase){
                        //判断是否逾期
                        if(strtotime($val['due_date']) < time() ){
                            $status[$val['products_instock_id']] = 'overdue';
                            $status_name[$val['products_instock_id']] = self::trans('FS_BILLING_OVERDUE');
                            $overDueTotal += $val['order_total'];
                        }
                    }
                }
            }
        }

        $total = ($total == 0) ? 0: $this->curr->format(
            $total,2,true,$this->currency
        ) ;

        $overdue_total = $overDueTotal;

        $overDueTotal = ($overDueTotal === 0) ? 0 : $this->curr->format(
            $overDueTotal,2,true,$this->currency
        );

        $unpaidTotal = ($unpaidTotal === 0) ? 0 : $this->curr->format(
            $unpaidTotal,2,true,$this->currency
        );

        return compact('status','status_name','total','overDueTotal','unpaidTotal','overdue_total');
    }

    /**
     * @Notes:筛选之后的列表数据
     *
     * @param array $billingParam 筛选条件
     * @param bool $isCount 总数
     * @param array $limit 分页
     * @param array $isPurchaseCycle 是否为账期以及账期周期
     * @return array
     * @auther: Helun Smile
     * @Date: 2021/1/14
     * @Time: 18:15
     */
    public function conditionBillingOrder($billingParam = [], $isCount = false, $limit = [], $isPurchaseCycle = [])
    {
        //逾期默认金额
        $overdueDefault = 0;
        $whereRelation = $this->returnRelation();
        $tableName = $whereRelation['orderTableName'];
        $fieldsDefault = [
            'fs_invoice_number.in_number',
            'fs_invoice_number.invocie_date',
            'products_instock_shipping.products_instock_id',
            $tableName.'.orders_id',
            $tableName.'.purchase_order_num',
            $tableName.'.customers_po',
            $tableName.'.currency',
            $tableName.'_total.text',
            $tableName.'.order_total',
            $tableName.'.delivery_country'
        ];

        //判断是线下单，还是线上单
        if ($this->orderType == 2) {
            $fields = [
                $tableName.'.is_payment_true',
                'products_instock_shipping.sales_update_time',
            ];
            $fieldsDefault = array_merge($fieldsDefault, $fields);
        }

        $model = $whereRelation['whereRelation'];

        //判断是否存在日期筛选
        if($billingParam['left_date'] && $billingParam['right_date']){
            //将日期进行拼接
            $left_date  = date("Y-m-d H:i:s",strtotime(substr($billingParam['left_date'],0,4).'/'.substr($billingParam['left_date'],4).'/0 00:00:00'));
            //获取到右边年份月份的天数
            $right_date = substr($billingParam['right_date'],0,4).'-'.substr($billingParam['right_date'],4);
            $days = date('t', strtotime($right_date));
            $right_date = date("Y-m-d H:i:s",strtotime(substr($billingParam['right_date'],0,4).'/'.substr($billingParam['right_date'],4).'/'.$days.'12:00:00'));

            $model->whereBetween('fs_invoice_number.invocie_date',[$left_date,$right_date]);
        }

        //搜索
        //判断是否存在订单号赛选
        if ($billingParam['search']) {
            $search = $billingParam['search'];
            $model->whereRaw(
                '(fs_invoice_number.in_number = ? or '.$tableName.'.purchase_order_num = ? or '.$tableName.'.customers_po = ?)',
                [$search, $search, $search]
            );
        }

        try {
            if ($isCount) {
                $billingOrderInfo = $model->count();
            } else {
                $model->select($fieldsDefault)
                    ->orderBy('fs_invoice_number.invocie_date','DESC');
                //筛选结清状态不进行分页
                if (!in_array($billingParam['payStatus'], ['unpaid', 'overdue', 'paid'])) {
                    $model->offset($limit['start'] ? $limit['start'] : 0)
                        ->limit($limit['num'] ? $limit['num'] : 2);
                }
                $billingOrderInfo = $model
                    ->get()
                    ->toArray();
                if ($billingOrderInfo) {
                    foreach ($billingOrderInfo as $k => $val) {
                        //账期周期 付款时间 结清状态
                        $billingOrderInfo[$k]['due_date'] = '';
                        $billingOrderInfo[$k]['payment_date'] = '';
                        $billingOrderInfo[$k]['payment_status'] = '';
                        if ($isPurchaseCycle['isPurchase']) {
                            //计算账期的截止日期
                            $billingOrderInfo[$k]['due_date'] =
                                date("M j, Y", strtotime("+" . $isPurchaseCycle['purchaseDays'] . " day", strtotime($val['invocie_date'])));
                        }
                        //区别线上和线下获取各付款时间
                        if ($this->orderType == 1) {
                            if ($val['order_status_history']) {
                                $billingOrderInfo[$k]['payment_date'] =
                                    date('M j, Y', strtotime($val['order_status_history'][0]['date_added'])) ?: '';
                            }
                        } else {
                            $billingOrderInfo[$k]['payment_date'] =
                                $val['is_payment_true'] == 1 ? date('M j, Y', strtotime($val['sales_update_time'])) : '';
                        }
                        //发票时间转换
                        $billingOrderInfo[$k]['invocie_date'] = date('M j, Y ', strtotime($val['invocie_date']));
                        //查找delivery_country国家对应的country_code
                        $country = new Country();
                        $delivery_country_code = $country->where('countries_name', 'like', $val['delivery_country'])
                            ->pluck('countries_iso_code_2');
                        $billingOrderInfo[$k]['delivery_country_code'] = $delivery_country_code;
                    }
                    if ($isPurchaseCycle['isPurchase']) {
                        //账期(通过接口拿到结清状态)
                        $getBillsMoney = $this->getBillsMoney($billingOrderInfo, $isPurchaseCycle['isPurchase']);
                        $overdueDefault = $getBillsMoney['overdue_total'];
                        if ($getBillsMoney['status']) {
                            //如果进行筛选结清状态 以及返回状态值
                            foreach ($billingOrderInfo as $k => $val) {
                                //获取账期订单结清状态
                                $billingOrderInfo[$k]['unpaidTotal'] = $getBillsMoney['unpaidTotal'];
                                $billingOrderInfo[$k]['payment_status'] = $getBillsMoney['status'][$val['products_instock_id']];
                                $billingOrderInfo[$k]['payment_status_name'] = $getBillsMoney['status_name'][$val['products_instock_id']];
                                switch ($billingParam['payStatus']) {
                                    case 'unpaid' :
                                        if ($getBillsMoney['status'][$val['products_instock_id']] !='unpaid') {
                                            unset($billingOrderInfo[$k]);
                                        }
                                        break;
                                    case 'overdue' :
                                        if ($getBillsMoney['status'][$val['products_instock_id']] !='overdue') {
                                            unset($billingOrderInfo[$k]);
                                        }
                                        break;
                                    case 'paid' :
                                        if ($getBillsMoney['status'][$val['products_instock_id']] !='paid') {
                                            unset($billingOrderInfo[$k]);
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            }

            if ($billingParam['payStatus'] == 'overdue') {
                $billingOrderInfo = [
                    'billingListInfo' => $billingOrderInfo,
                    'overdueDefault' => $overdueDefault
                ];
            } else {
                $billingOrderInfo = [
                    'billingListInfo' => $billingOrderInfo,
                    'overdueDefault' => 0
                ];
            }
        } catch (\Exception $e) {
            $billingOrderInfo = [
                'billingListInfo' => [],
                'overdueDefault' => 0
            ];
            if ($isCount) {
                $billingOrderInfo = [
                    'billingListInfo' => 0,
                    'overdueDefault' => 0
                ];
            }
        }
        return $billingOrderInfo;
    }


    /**
     * @Notes:账户中心首页获取所有billings子数据
     *
     * @param $isPurchaseCycle
     * @return mixed
     * @auther: Helun
     * @Date: 2021/1/20
     * @Time: 19:08
     */
    public function getAllBills($isPurchaseCycle)
    {
        $billingOrderInfo = [];
        if ($isPurchaseCycle['isPurchase']) {
            $whereRelation = $this->returnRelation();

            $tableName = $whereRelation['orderTableName'];

            $fieldsDefault = [
                'fs_invoice_number.in_number',
                'fs_invoice_number.invocie_date',
                'products_instock_shipping.products_instock_id',
                $tableName.'.orders_id',
                $tableName.'.purchase_order_num',
                $tableName.'.customers_po',
                $tableName.'.currency',
                $tableName.'_total.text',
                $tableName.'.order_total'
            ];

            //判断是线下单，还是线上单
            if ($this->orderType == 2) {
                $fields = [
                    $tableName.'.is_payment_true',
                    'products_instock_shipping.sales_update_time',
                ];
                $fieldsDefault = array_merge($fieldsDefault, $fields);
            }

            $model = $whereRelation['whereRelation'];

            $model->select($fieldsDefault)
                ->orderBy('fs_invoice_number.invocie_date','DESC');
            $billingOrderInfo = $model
                ->get()
                ->toArray();

            if($billingOrderInfo){

                foreach ($billingOrderInfo as $k=>$val){
                    $billingOrderInfo[$k]['due_date'] = '';

                    if ($isPurchaseCycle['isPurchase']){
                        $billingOrderInfo[$k]['due_date'] =
                            date("M j, Y", strtotime("+" . $isPurchaseCycle['purchaseDays'] . " day", strtotime($val['invocie_date'])));
                    }
                }
            }
        }
        return $billingOrderInfo;
    }

    /**
     * @Notes:获取到token
     *
     * @return string smile
     * @auther: Helun smile
     * @Date: 2021/1/16
     * @Time: 11:15
     */
    public function defaultEncrypt()
    {
        $time = time();
        $number = mt_rand(10000000, 99999999);
        $original = 'u=' . self::APPID . '&k=' . self::SECRETID . '&t=' . $time . '&r=' . $number . '&f=';
        return base64_encode(hash_hmac('sha1', $original, self::SECREKEY) . $original);
    }

    /**
     * @Notes:发送POST请求
     *
     * @param $numbers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @auther: Helun smile
     * @Date: 2021/1/16
     * @Time: 11:15
     */
    public function sendPayStatusApi($ids)
    {
        //获取所有id的结清状态
        $amountStatus = [];
        if(is_array($ids)){
            foreach($ids as $vid){
                if(is_numeric($vid)){
                    //判断结清状态
                    $amountStr = fs_get_settle_status($vid, 1);
                    if($amountStr){
                        $amountStatus[$vid] = 'paid';
                    }else{
                        $amountStatus[$vid] = 'unpaid';
                    }
                }else{
                    $result = [
                        'status'  => 'error',
                        'message' => 'error id type num',
                    ];
                }
            }
            $result = [
                'status'  => 'success',
                'message' => 'success',
                'data'=>$amountStatus
            ];
        }else{
            $result = [
                'status'  => 'error',
                'message' => 'error id type',
                'data'=>$amountStatus
            ];
        }
        return $result['data'];
    }

    /**
     * @Notes: 获取到账单状态
     *
     * @param $numbers
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @auther: Helun Smile
     * @Date: 2021/1/16
     * @Time: 11:16
     */
    public function getPayStatus($numbers)
    {
        //计算出numbers的数量，由于该接口每次最多支持20个同时查询
        $count = count($numbers);

        //结果集
        $status =[];

        $times = ceil($count / 20);

        for ($i = 0;$i< $times;$i++){
            $count = 0;

            $numbers = array_values($numbers);
            $templates = [];

            for($j =0;$j< 20;$j++){
                if(isset($numbers[$j])){
                    $templates[] = $numbers[$j];
                    unset($numbers[$j]);
                }
            }

            //发送请求
            $res = $this->sendPayStatusApi($templates);

            //每秒可以请求2次数据，然后进行休眠1S处理
            $count ++;

            if($count % 2 == 0){
                time_sleep_until(1 + time());
            }

            foreach ($res ?: [] as $key=>$val){
                $status[$key] = $val;
            }
        }

        return $status;
    }
}
