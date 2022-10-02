<?php

namespace App\Services\Payments;

use App\Models\ProuctInstockShippingApply;
use App\Services\BaseService;
use App\Traits\Loader\Payment\PurchaseLoader;
use Illuminate\Database\Query\Builder;

/**
 * po 支付服务
 *
 * Class PurchaseService
 * @package App\Services\Payments
 */
class PurchaseService extends BaseService
{

    use PurchaseLoader;

    private $from = self::NEW_FORM;

    private $customerNumbers = [];

    private $useNewPo = true;

    private $cid;

    const OLD_FORM = 'old';

    const NEW_FORM = 'new';

    public function __construct()
    {
        parent::__construct();
        $this->cid = $this->customer_id;
    }

    /**
     * 设置客户id
     *
     * @param int $cid
     * @return $this
     */
    public function setCid($cid = 0)
    {
        $cid = abs((int)$cid);
        if (!empty($cid)) {
            $this->cid = $cid;
        }
        return $this;
    }

    /**
     * 最终的返回结果
     *
     * @var array
     */
    private $info;

    /**
     * 获取purchase信息 主流程
     *
     * @return array
     */
    public function getPurchaseInfo()
    {
        $this->init();
        if (!empty($this->cid) && ($customerInfo = $this->getCustomerInfo($this->cid))) {
            $this->customerNumbers = [
                $customerInfo->customers_number_new,
                $customerInfo->customers_level . $customerInfo->customers_number_new
            ];
            $purchase = $this->fromNewProcess($this->customerNumbers); //新版的数据对接暂时搁置
            if ($this->from == self::OLD_FORM) {
                $purchase = $this->fromOldProcess($this->customerNumbers);
            }
            if (!empty($purchase)) {
                //新老账期相同数据设置
                $this->setPayDay($purchase);
                $this->setApplyMoney($purchase);
                $this->setApplyMoneyCurrency($purchase);
                $this->setSymbol($purchase);
                $this->setOthers($purchase);
            }
        }
        return $this->info;
    }

    /**
     * 金额修改申请
     *
     * @param $money
     * @param $reason
     * @return bool
     */
    public function applyCreditLimit($money, $reason)
    {
        if (empty($this->customerNumbers)) {
            return false;
        }
        $currencies_type = $this->loadCurrencyModel()
            ->where('code', $this->currency)
            ->select('currencies_id')
            ->first();
        $currencies_type = isset($currencies_type->currencies_id) ? $currencies_type->currencies_id : 0;
        $apply_time = date('Y-m-d h:i:s');
        if ($this->from == 'new') {
            $apply_data = array(
                'is_delete'      => 0,
                'type'           => 2,
                'time'           => $apply_time,
                'remarks'        => $reason,
                'status'         => 0,
                'apply_money'    => $money,
                'apply_moneys'   => $this->info['all_apply_money'],
                'order_payment'  => $this->info['po_flag'][0][1],
                'apply_payment'  => $this->info['po_flag'][0][1],
                'parent_id'      => $this->info['id'],
                'admin'          => $this->info['admin'],
                'overdue_orders' => '',
            );
            return $this->loadPispisModel()->insert($apply_data);
        }

        $apply_data = array(
            'apply_admin'     => $this->info['apply_admin'],
            'apply_type'      => 2,
            'apply_remarks'   => $reason,
            'order_payment'   => $this->info['po_flag'][0][1],
            'apply_money'     => $money,
            'apply_moneys'    => $this->info['all_apply_money'],
            'currencies_id'   => $currencies_type,
            'create_order'    => 3,
            'parent_id'       => $this->info['id'],
            'address_book_id' => $this->info['address_book_id'],
            'customer_grade'  => $this->info['customer_grade'],
            'customers_NO'    => $this->customerNumbers[0],
            'customers_email' => $this->info['customers_email'],
            'company_name'    => $this->info['company_name'],
            'apply_time'      => $apply_time
        );
        return $this->loadPisaModel()->insert($apply_data);
    }

    /**
     * my_credit 订单列表数据获取
     *
     * @param string $search
     * @param int $pay
     * @param int $page
     * @param string $orders_status
     * @return array
     */
    public function getPurchaseOrderList($search = '', $pay = 1, $page = 1, $orders_status = 'orders')
    {
        $sql = $this->getPolSql($search, $pay, $orders_status);
        $count = $sql->count();
        $perNum = 10;
        $page = abs((int)$page) ?: 1;
        $offset = $perNum * ($page - 1);
        $list = $sql->orderBy('date_purchased', 'desc')
            ->limit($perNum)
            ->offset($offset)
            ->get()
            ->toArray();
        return [
            'count' => $count,
            'list'  => $list,
        ];
    }

    /**
     * 默认返回设置
     */
    private function init()
    {
        $this->info = [
            'from'                 => $this->from,
            'customer_pay_day'     => '',
            'apply_type'           => '',
            'Po_address_arr'       => [],
            'is_delete'            => 0,
            'po_flag'              => [],
            'id'                   => 0,
            'parent_id'            => '',
            'apply_money'          => 0,
            'all_apply_money'      => 0,
            'symbol_right'         => '',
            'currency_symbol'      => 'US$',
            'currency_symbol_code' => 'USD',
            'delay_pay'            => false,
            'is_po_account'        => false,
            'apply_money_currrncy' => 'USD',
            'is_frozen'            => false,
        ];
    }

    /**
     * my_credit 订单列表sql组装
     *
     * @param $search
     * @param $pay
     * @param $orders_status
     * @return mixed
     */
    private function getPolSql($search, $pay, $orders_status)
    {
        $showFields = [
            'orders_id',
            'orders_number',
            'purchase_order_num',
            'order_total',
            'orders_status',
            'date_purchased',
            'payment_module_code',
            'currency',
            'currency_value'
        ];
        if ($orders_status == 'orders') {
            $sql = $this->loadOrderModel()
                ->where('customers_id', $this->cid)
                ->where('payment_module_code', 'purchase')
                ->where('main_order_id', '<>', 1);
        } else {
            $sql = $this->loadOrderSplitModel()
                ->where('customers_id', $this->cid)
                ->where('payment_module_code', 'purchase')
                ->whereIn('split_main_id', [0, 1]);
            $showFields = array_merge($showFields, ['split_main_id']);
        }
        if (!empty($search)) {
            $sql->where(function ($query) use ($search) {
                $query->where('orders_number', $search)
                    ->orwhere('purchase_order_num', $search);
            });
        }
        if (!empty($pay)) {
            if ($pay == 2) {
                $sql->where('orders_status', 2);
            } elseif ($pay == 3) {
                $sql->where('orders_status', '<>', 2);
            }
        }
        return $sql->select($showFields);
    }

    /**
     * 老流程获取账期
     *
     * @param $numbers
     * @return ProuctInstockShippingApply
     */
    private function fromOldProcess($numbers)
    {
        $this->init(); //切换到老流程  重置返回结果
        $purchase = $this->getOldPurchase($numbers);
        if (!empty($purchase)) {
            $this->setOldDelay($purchase);
            $pa = $purchase->toArray();
            foreach ($pa as $k => $v) {
                if (!isset($this->info[$k])) {
                    $this->info[$k] = $v;
                }
            }
        }
        return $purchase;
    }

    /**
     * 新版po 数据获取
     *
     * @param $numbers
     * @return Builder|void
     */
    private function fromNewProcess($numbers)
    {
        if (!$this->useNewPo) {
            $this->from = self::OLD_FORM;
            return;
        }
        $purchase = $this->getNewPurchase($numbers);
        if (!empty($purchase)) {
            $this->setNewDelay($purchase);
        } else {
            $this->from = self::OLD_FORM;
        }
        return $purchase;
    }

    /**
     * 旧版po 数据获取
     *
     * @param $numbers
     * @return ProuctInstockShippingApply->object
     */
    private function getOldPurchase($numbers)
    {
        $fields = $this->oldSelectFields();
        $purchase = $this->loadPisaModel()
            ->whereIn('apply_type', [2, 13, 17])
            ->whereIn('create_order', [0, 6])
            ->where('is_delete', 0)
            ->whereIn('status', [1, 8])
            ->select($fields)
            ->whereIn('customers_NO', $numbers)
            ->first();
        if (!empty($purchase)) {
            $this->setPoFlag($purchase);  //使用子客户数据设置
            $this->info['apply_type'] = $purchase->apply_type;
            $this->setParent($purchase);  //使用子客户数据设置
            if ($purchase->parent_id) {
                $purchase = $this->loadPisaModel()
                    ->select($fields)
                    ->find($purchase->parent_id);
            }
        }
        return $purchase;
    }

    /**
     * 新版 po數據獲取
     *
     * @param $numbers
     * @return Builder|mixed
     */
    public function getNewPurchase($numbers)
    {
        $fields = $this->newSelectFields();
        $purchase = $this->loadPispiModel()
            ->select($fields)
            ->whereIn('status', [1, 7, 8])
            ->where('is_delete', 0)
            ->whereIn('customers_NO', $numbers)
            ->whereIn('type', [2, 3, 4, 5])
            ->first();
        if ($purchase) {
            $purchase->apply_type = $this->typeToApply($purchase->type);
            $this->setPoFlag($purchase);  //使用子客户数据设置
            $this->info['apply_type'] = $purchase->apply_type;
            $this->setParent($purchase);  //使用子客户数据设置
            if ($purchase->parent_id) {
                $purchase = $this->loadPispiModel()
                    ->select($fields)
                    ->whereIn('status', [1, 7, 8])
                    ->whereIn('type', [2, 3, 4])
                    ->where('id', $purchase->parent_id)
                    ->first();
                if ($purchase) {
                    $this->info['po_flag'][0][3] = 6;
                    $purchase->apply_type = $this->typeToApply($purchase->type);
                    $this->info['apply_type'] = $purchase->apply_type;
                }
            }
        }
        return $purchase;
    }

    /**
     * 旧版格式转换
     *
     * @param $purchase
     */
    private function setPoFlag($purchase)
    {
        $this->info['po_flag'] = [
            [
                $purchase->customers_NO,
                $purchase->order_payment,
                $purchase->apply_type,
                isset($purchase->create_order) ? $purchase->create_order : 0
            ]
        ];
    }

    /**
     * 旧版格式转换
     *
     * @param $purchase
     */
    private function setParent($purchase)
    {
        $this->info['parent_id'] = [
            [
                $purchase->id,
                $purchase->parent_id
            ]
        ];
    }

    /**
     * 展示的net 天数获取
     *
     * @param $purchase
     */
    private function setPayDay($purchase)
    {
        $payDay = $this->loadPMModel()
            ->select('payment_method')
            ->find($purchase->order_payment);
        $this->info['customer_pay_day'] = isset($payDay->payment_method) ? $payDay->payment_method : '';
    }

    /**
     * 展示的net 天数获取
     *
     * @param $purchase
     */
    private function setApplyMoney($purchase)
    {
        $this->info['apply_money'] = [
            [
                $purchase->currencies_id,
                $purchase->apply_money,
                $purchase->apply_moneys,
                isset($purchase->apply_time) ? $purchase->apply_time : 0,
                $purchase->order_payment
            ]
        ];
    }

    /**
     * @param $purchase
     */
    private function setSymbol($purchase)
    {
        if (in_array($purchase->currencies_id, [0, 1])) {
            $this->info['currency_symbol'] = 'US$';
            $this->info['currency_symbol_code'] = 'USD';
        } else {
            $currencices = $this->loadCurrencyModel()
                ->select('symbol_right', 'symbol_left', 'code')
                ->where('currencies_id', $purchase->currencies_id)
                ->first();
            $this->info['currency_symbol_code'] = isset($currencices->code) ? $currencices->code : 'USD';
            $this->info['symbol_right'] = isset($currencices->symbol_right) ? $currencices->symbol_right : '';
            $this->info['currency_symbol'] = isset($currencices->symbol_left) ? $currencices->symbol_left : 'US$';
        }
    }

    /**
     * 检测是否延期
     *
     * @param $purchase
     */
    private function setOldDelay($purchase)
    {
        $delayInfo = $this->loadPisaModel()
            ->where('parent_id', $purchase->id)
            ->where('is_delete', 0)
            ->where('is_payment', 0)
            ->where('status', 1)
            ->where('payable_date', '>', 2000)
            ->where('payable_date', '<', date('Y-m-d'))
            ->whereIn('apply_type', [2, 13, 17])
            ->whereIn('create_order', [1, 11])
            ->whereNotIn('customers_NO', [791044479, 791044489, 761065958, 901066613, 921065753])
            ->select('parent_id')
            ->first();
        if ($delayInfo) {
            $this->info['delay_pay'] = true;
        }
    }

    /**
     * 检测是否延期
     *
     * @param $purchase
     */
    private function setNewDelay($purchase)
    {
        $delayInfo = $this->loadPispioModel()
            ->where('parent_id', $purchase->id)
            ->where('is_delete', 0)
            ->where('status', 1)
            ->where('is_payment', '<>', 1)
            ->where('payable_date', '>', 2000)
            ->where('payable_date', '<', date('Y-m-d'))
            ->whereIn('type', [2, 3, 4, 5])
            ->select('parent_id')
            ->first();
        if ($delayInfo) {
            $this->info['delay_pay'] = true;
        }
    }


    /**
     * @param $purchase
     */
    private function setOthers($purchase)
    {
        $this->info['all_apply_money'] = $purchase->apply_moneys;
        $this->info['id'] = $purchase->id;
        $this->info['is_delete'] = $purchase->is_delete;
        $this->info['admin'] = isset($purchase->admin) ? $purchase->admin : 0;
        if (in_array($purchase->apply_type, [2, 13, 17]) && $purchase->is_delete == 0) {
            $this->info['is_po_account'] = true;
        }
        //暂停授信或者暂停使用
        if ($purchase->status == 8 || ($this->from == self::NEW_FORM && $purchase->status == 7)) {
            $this->info['is_frozen'] = true;
        }
    }

    /**
     * @param $purchase
     */
    private function setApplyMoneyCurrency($purchase)
    {
        $payDay = $this->loadCurrencyModel()
            ->select('code')
            ->where('currencies_id', $purchase->currencies_id)
            ->first();
        $this->info['apply_money_currrncy'] = isset($payDay->code) ? $payDay->code : '';
    }

    /**
     * 新版po的type与老版对照
     *
     * @param $type
     * @return int|mixed
     */
    private function typeToApply($type)
    {
        $applies = [
            '2' => 2,
            '3' => 13,
            '4' => 17,
        ];
        return isset($applies[$type]) ? $applies[$type] : 0;
    }

    /**
     * 获取用户信息
     *
     * @param $id
     * @return object
     */
    private function getCustomerInfo($id)
    {
        return $this->loadCustomerService()
            ->setField(['customers_level', 'customers_number_new'])
            ->setCustomer($id)
            ->currentCustomer;
    }

    /**
     * 旧版po查询的字段
     *
     * @return array
     */
    private function oldSelectFields()
    {
        return [
            'id',
            'parent_id',
            'customers_NO',
            'order_payment',
            'apply_type',
            'is_delete',
            'address_book_id',
            'currencies_id',
            'apply_money',
            'apply_moneys',
            'apply_time',
            'order_payment',
            'create_order',
            'apply_admin',
            'customers_email',
            'company_name',
            'customer_grade',
            'customers_NO',
            'status'
        ];
    }

    /**
     * po新流程所需要查询的字段
     *
     * @return array
     */
    private function newSelectFields()
    {
        return [
            'id',
            'parent_id',
            'is_delete',
            'type',
            'customers_NO',
            'order_payment',
            'address_book_id',
            'currencies_id',
            'apply_money',
            'apply_moneys',
            'admin',
            'status'
        ];
    }
}
