<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\Company;
use Modules\ERP\Entities\Invoice as Export;
use Modules\ERP\Entities\ProductsInstockShipping as Order;
use Modules\ERP\Entities\ManageCustomerCompany;
use Modules\ERP\Entities\CompanyOfCustomer;
use Modules\ERP\Service\OrderService;
use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\Invoice as Import;
use Modules\Finance\Entities\InvoiceToReceipts;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail as VouchersDetail;

/**
 * 从fs_invoice_number迁移发票数据
 */
class Invoices extends MigrateSeeder
{
    protected $netDay = ['4' => 30, '7' => 45, '10' => 60, '17' => 15, '18' => 90, '84' => 14, '97' => 0];
    protected $netId = [4, 7, 10, 17, 18, 84, 97];
    protected $currencyCodeArr = [1 => 'USD', 2 => 'EUR', 3 => 'GBP', 4 => 'CAD', 5 => 'AUD', 6 => 'CNY', 7 => 'CHF', 8 => 'HKD', 9 => 'JPY', 10 => 'BRL', 11 => 'NOK', 12 => 'DKK', 13 => 'SEK', 14 => 'MXN', 16 => 'NZD', 18 => 'SGD', 19 => 'RUB', 20 => 'MYR', 21 => 'THB', 22 => 'PHP'];
    protected $order;

    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    public function run()
    {
        $total = Export::query()->where('in_number','not regexp','INDC')->whereIn('type', [1, 2])->orderBy('id', 'ASC')->count();
        $this->command->info('开始迁移 Invoice 表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        Export::query()
            ->where('in_number','not regexp','INDC')
            ->whereIn('type', [1, 2])
            ->orderBy('id', 'ASC')
            ->chunk(1000, function ($export) use ($bar) {
                foreach ($export as $item) {
                    $this->migrate($item);
                    $bar->advance();
                }
            });
        $bar->finish();
    }

    /**
     * 迁移逻辑
     *
     * @param [type] $item
     * @return void
     */
    private function migrate(&$item)
    {
        $data = $item->export();
        try {
            $invoice = $this->getParms($data);
            Import::modelUpdateOrCreate(
                ['number' => $item->in_number],
                $invoice
            );
            //判断是否合发单
            if ($data['type'] == 1) {
                $this->migrateWiped($data['relate_id'], $invoice);
            } else { //合发单
                //获取所有子单
                $mergIdArr = Order::query()->where('shipping_merge_id', $item->relate_id)->get(['products_instock_id']);
                foreach ($mergIdArr as $idArr) {
                    $id = $idArr->export();
                    $this->migrateWiped($id['products_instock_id'], $invoice);
                }
            }
        } catch (\Exception $e) {
            $this->error('导入发票数据->数据表：invoice，发票编号in_number=' . $item->in_number . '|' . $item->relate_id . ',异常信息：' . $e->getMessage());
        }

    }

    private function math_mul($a, $b, $scale = '0')
    {
        return bcmul($a, $b, $scale);
    }

    /**
     * 确认子公司id
     *
     * @param $isSeattle
     * @param $isNotTransport
     * @return mixed
     */
    private function getSubSubsidiary($isSeattle, $isNotTransport)
    {
        $seattleArr = [1 => 57, 3 => 50, 4 => 53, 5 => 57, 6 => 50, 7 => 75, 8 => 116]; //海外直发对应的仓库
        $transportArr = [2 => 55, 3 => 49, 4 => 78, 5 => 55, 8 => 69, 9 => 75]; //转运对应的仓库
        $subsidiaryArr = [49 => 3, 50 => 3, 53 => 4, 55 => 6, 57 => 6, 69 => 9, 75 => 7, 78 => 4, 116 => 9, 1 => 1, 2 => 1];
        $nsIdArr = [1 => 2, 2 => 4, 3 => 5, 4 => 7, 5 => 8, 6 => 6, 7 => 9, 8 => 15, 9 => 10, 10 => 3]; //转换nsid

        if ($isSeattle) {
            $subsidiary = $subsidiaryArr[$seattleArr[$isSeattle]];
        } elseif ($isNotTransport > 1) {
            $subsidiary = $subsidiaryArr[$transportArr[$isNotTransport]];
        } else {
            $subsidiary = $subsidiaryArr[1];
        }
        return $subsidiary ? $nsIdArr[$subsidiary] : 0;
    }

    /**
     * 获取客户公司信息
     *
     * @param $orderInfo
     * @return array
     */
    private function getCompanyNum(&$orderInfo)
    {
        if (!$orderInfo) {
            return [];
        }
        $companyNumber = $customerName = '';
        $companyNum = $orderInfo->instockShippingField()->first(['company_number']); //订单G编号
        if ($companyNum) {
            $companyNumber = $companyNum->company_number;
            $customerName = ManageCustomerCompany::query()->where('company_number', $companyNum->company_number)->first(['customers_company']);
            $customerName = $customerName ?$customerName->customers_company: '';
        } elseif ($orderInfo->No) {
            $companyNum = CompanyOfCustomer::query()->where('customers_number_new', $orderInfo->No)->orderBy('id', 'DESC')->first(['company_number']);
            if ($companyNum) {
                $companyNumber = $companyNum->company_number;
                $customerInfo = ManageCustomerCompany::query()->where('company_number', $companyNum->company_number)->first(['customers_company']);
                if ($customerInfo) {
                    $customerName = $customerInfo->customers_company;
                } else {
                    $customerName = '';
                }
            }
        }

        return ['customer_company_number' => $companyNumber, 'customer_company_name' => $customerName];
    }

    /**
     * 组装参数
     *
     * @param [type] $data
     * @return array $data
     */
    private function getParms($data)
    {
        $paid = $orderUse = $amount =  0;
        $data['uuid'] = Str::uuid()->getHex()->toString();
        if ($data['status'] == 2) { //获取原发票uuid
            $data['origin_uuid'] = Import::query()->where('relate_id', $data['relate_id'])->where('to_void', 1)->where('relate_type', $data['type'])->first(['uuid'])->uuid;
        }
        $data['relate_type'] = $data['type'];
        $data['number'] = $data['in_number'];
        $data['to_void'] = $data['status'];
        //获取订单信息
        if ($data['type'] == 2) {
            $orderInfoMerge = Order::query()->where('shipping_merge_id', $data['relate_id'])->get(['order_price', 'symbol_left', 'order_payment', 'assistant_id', 'sales_admin', 'No', 'is_seattle', 'is_not_transport', 'shipping_merge_id', 'products_instock_id','vat_tax','amount_use','amount_recived','paypal_fee','orders_num','return_order','products_instock_id','invoice_comment']);
            $orderInfo = $orderInfoMerge->first();
            if (!$orderInfo) {
                throw new \Exception('订单信息未找到,发票编号=' . $data['in_number']);
            }
            foreach($orderInfoMerge as $orderCheck){
                $checkPaid = $this->order->checkOrderPaid($orderCheck,$paid);
                if($checkPaid){//结清
                    $orderUse += intval(round($orderCheck->order_price * 100));
                }else{
                    $orderUse += intval(round($orderCheck->order_price * 100)) - $paid;
                }
                $amount += intval(round($orderCheck->order_price * 100));
            }
        } else {
            $orderInfo = Order::query()->where('products_instock_id', $data['relate_id'])->first(['order_price', 'symbol_left', 'order_payment', 'assistant_id', 'sales_admin', 'No', 'is_seattle', 'is_not_transport', 'shipping_merge_id', 'products_instock_id','vat_tax','amount_use','amount_recived','paypal_fee','orders_num','return_order','products_instock_id','invoice_comment']);
            if (!$orderInfo) {
                throw new \Exception('订单信息未找到,发票编号=' . $data['in_number']);
            }
            $checkPaid = $this->order->checkOrderPaid($orderInfo,$paid);
            if($checkPaid){//结清
                $orderUse += intval(round($orderInfo->order_price * 100));
            }else{
                $orderUse += intval(round($orderInfo->order_price * 100)) - $paid;
            }
            $amount += intval(round($orderInfo->order_price * 100));
        }
        if($orderUse<0){
            $orderUse = $amount;
        }
        //验证发票结清金额
        $data['cleared'] = $orderUse; //发票对应订单已结清金额累加
        if($data['cleared']==0){
            $data['cleared_status'] = 0;
        }elseif($data['cleared']>0 && $data['cleared']<$amount){
            $data['cleared_status'] = 1;
        }else{
            $data['cleared_status'] = 2;
        }
        if ($orderInfo) {
            $orderInfoArr = $orderInfo->toArray();
        } else {
            $orderInfoArr = [];
        }
        $data['remark'] = $orderInfoArr ? $orderInfoArr['invoice_comment'] : null;
        $data['currency'] = $orderInfoArr ? $this->currencyCodeArr[$orderInfoArr['symbol_left']] : null;
        $data['amount'] = $amount ?: 0;
        $data['account_days'] = $orderInfoArr ? (in_array($orderInfoArr['order_payment'], $this->netId) ? $this->netDay[$orderInfoArr['order_payment']] : 0) : 0;
        //转换子公司信息
        $subsidiary = $this->getSubSubsidiary($orderInfoArr['is_seattle'], $orderInfoArr['is_not_transport']);
        $companyInfo = Company::query()->where('ns_internal_id', $subsidiary)->first(['uuid', 'name']);
        $data['company_uuid'] = $companyInfo ? $companyInfo->uuid : null;
        $data['company_name'] = $companyInfo ? $companyInfo->name : null;
        $data['customer_number'] = $companyInfo ? $orderInfoArr['No'] : null;
        //获取客户G编号
        $customerCompanyInfo = $this->getCompanyNum($orderInfo);
        $data['customer_company_number'] = $customerCompanyInfo ? $customerCompanyInfo['customer_company_number'] : null;
        $data['customer_company_name'] = $customerCompanyInfo ? $customerCompanyInfo['customer_company_name'] : null;
        //获取对应的销售
        $salesId = $orderInfoArr['assistant_id'] ?: $orderInfoArr['sales_admin'];

        $salesIdInfo = Admin::query()->where('id', $salesId)->first(['uuid', 'name']);
        $data['assistant_name'] = $salesIdInfo ? $salesIdInfo->name : $salesId;
        $data['assistant_uuid'] = $salesIdInfo ? $salesIdInfo->uuid : null;

        $data['created_at'] = $data['invocie_date'] == '0000-00-00 00:00:00' ? $data['create_at'] : $data['invocie_date'];
        $data['created_at'] = $data['created_at'] == '-0001-11-30 00:00:00' ? null : $this->timeChange($data['created_at']);

        unset($data['create_at']);
        unset($data['in_number']);
        unset($data['status']);
        unset($data['ns_vouch_id']);
        unset($data['products_instock_id']);
        unset($data['create_from']);
        unset($data['invocie_date']);
        unset($data['id']);
        unset($orderInfo);
        unset($orderInfoMerge);
        unset($orderUse);
        unset($amount);
        unset($checkPaid);
        unset($orderInfoArr);
        unset($subsidiary);
        unset($companyInfo);
        unset($salesId);
        unset($salesIdInfo);
        unset($customerCompanyInfo);
        return $data;
    }

    private function migrateWiped($id, $invoiceInfo)
    {
        //查询订单对应的明细
        $details = VouchersDetail::query()->where('order_id', $id)->get(['voucher_number', 'voucher_currency', 'voucher_use', 'receipt_uuid', 'receipt_number', 'receipt_currency', 'receipt_use', 'order_id','order_number']);
        foreach ($details as $detailsInfo) {
            $data = [];
            $data['uuid'] =  Str::uuid()->getHex()->toString();
            //获取发票的uuid
            $invoiceData = Import::query()->where('number',$invoiceInfo['number'])->first(['uuid']);
            $data['invoice_uuid'] = $invoiceData['uuid'];
            $data['invoice_number'] = $invoiceInfo['number'];
            $data['invoice_currency'] = $invoiceInfo['currency'];

            $data['invoice_clear'] = $detailsInfo->receipt_use;
            $data['voucher_clear'] = $detailsInfo->voucher_use;
            $data['receipt_clear'] = $detailsInfo->receipt_use;
            $data['voucher_number'] = $detailsInfo->voucher_number;
            $data['voucher_currency'] = $detailsInfo->voucher_currency;
            $data['receipt_uuid'] = $detailsInfo->receipt_uuid;
            $data['receipt_number'] = $detailsInfo->receipt_number;
            $data['receipt_currency'] = $detailsInfo->receipt_currency;
            $data['order_id'] = $detailsInfo->order_id;
            $data['order_number'] = $detailsInfo->order_number;
            $data['created_at'] = date('Y-m-d H:i:s');


            try {
                InvoiceToReceipts::query()->create($data);
                //累加核销金额到payment_receipts.cleared
                PaymentReceipt::query()->where('uuid',$detailsInfo->receipt_uuid)->update(['cleared'=>DB::raw('`cleared` + '. $detailsInfo->receipt_use)]);
            } catch (\Exception $e) {
                $this->error('导入核销数据->数据表：invoices_to_receipts，发票编号in_number=' . $data['invoice_number'] . '|' . $id . ',异常信息：' . $e->getMessage());
            }
        }
    }

    /**
     * 转换时间为utc
     *
     * @return void
     */
    private function timeChange($time)
    {
        if(is_null($time)){
            return null;
        }
        return Carbon::createFromTimeString($time, 'Asia/Shanghai')->tz(config('app.timezone'))->format('Y-m-d H:i:s');
    }
}
