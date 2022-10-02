<?php

namespace Modules\Finance\Services;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Repositories\ManageCustomerCompanyRepository;
use Modules\ERP\Repositories\ProductsInstockShippingFieldsRepository;
use Modules\ERP\Repositories\ProductsInstockShippingPaymentInvoiceRepository;
use Modules\ERP\Repositories\ProductsInstockShippingRepository;
use Modules\ERP\Repositories\OrderOffsetInfosRepository;
use Modules\ERP\Repositories\CustomerRepository;
use Modules\ERP\Repositories\InvoiceRepository as InvoiceRepositoryMain;
use Modules\Admin\Repositories\AdminRepository;

use Modules\ERP\Support\Facades\Exchange;
use Modules\Finance\Contracts\InvoiceService as InvoiceServiceMain;
use Modules\Finance\Entities\Invoice;
use Modules\Finance\Exceptions\InvoiceException;
use Modules\Finance\Contracts\InvoiceRepository;
use Modules\Finance\Contracts\ReceiptRepository;

class InvoiceService implements InvoiceServiceMain
{

    protected $invoiceRepository;
    protected $receiptRepository;
    protected $currencyRepository;
    protected $creditRefund;//退税红冲
    protected $creditAfter;//售后红冲
    protected $concessionRes;//折让坏账
    protected $invoiceReceipt;//核销记录

    public function __construct(InvoiceRepository $invoiceRepository, ReceiptRepository $receiptRepository, CurrencyRepository $currencyRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->receiptRepository = $receiptRepository;
        $this->currencyRepository = $currencyRepository;
    }

    const RISK_EN = [
        0 => 'no',
        1 => 'low',
        2 => 'medium',
        3 => 'high',
    ];
    const RISK_CN = [
        0 => '无',
        1 => '低',
        2 => '中',
        3 => '高',
    ];
    const Offset_Infos = [
        1 => '红冲',
        2 => '折让',
        3 => '坏账',
        4 => '核销',
    ];
    const RETURN_TYPE_ONE = [
        1 => '退货',
        2 => '不退货',
        3 => '丢包索赔',
    ];
    const RETURN_TYPE_TWO = [
        1 => '发新货',
        2 => '退款',
        3 => '维修',
        4 => '不退款',
        5 => '赠送FS',
        6 => '提前发新货',
        7 => '收到退件后发货',
        8 => '重发',
        9 => '退消费税',
    ];
    /**
     * 根据客户G编号获取账期天数
     * @param string $aide
     * @return int
     */
    public static function toAccountPeriodCalculation(string $aide): int
    {
        $accountPeriodData = ProductsInstockShippingPaymentInvoiceRepository::getProductsInstockShippingPaymentInvoiceData(['company_number' => $aide])->toArray();
        if (count($accountPeriodData) === 0) {
            return 0;
        }
        $orderPayment = current($accountPeriodData)['order_payment'];
        $paymentMethods = self::toPaymentMethod();
        if (!in_array($orderPayment, array_keys($paymentMethods))) {
            return 0;
        }
        return $paymentMethods[$orderPayment];
    }

    /**
     * @return int[]|mixed
     */
    public static function toSeattleCompany()
    {
        return [
            1 => 3, //美国
            3 => 1, //德国
            4 => 4, //澳洲
            5 => 3, //美国
            6 => 5, //英国'
            7 => 6, //新加坡
            8 => 7, //俄罗斯
        ];
    }
    /**
     * @return int[]|mixed
     */
    public static function toTransportCompany()
    {
        return [
            2 => 3, //美国
            3 => 1, //德国
            4 => 4, //澳洲
            5 => 3, //美国
            8 => 7, //俄罗斯
            9 => 6, //新加坡
        ];
    }
    /**
     * @return int[]|mixed
     */
    public static function toPaymentMethod()
    {
        return [
            4 => 30, //Net 30
            7 => 45, //Net 45
            10 => 60, //Net 60
            17 => 15, //Net 15
            18 => 90, //Net 90'
            84 => 14, //Net 14
        ];
    }

    /**
     * @return mixed|string[]
     */
    public static function toCurrenciesSymbol()
    {
        return [
            1 => 'USD', 2 => 'EUR', 3 => 'GBP', 4 => 'CAD', 5 => 'AUD',
            6 => 'CNY', 7 => 'CHF', 8 => 'HKD', 9 => 'JPY', 10 => 'BRL',
            11 => 'NOK', 12 => 'DKK', 13 => 'SEK', 14 => 'MXN', 15 => '',
            16 => 'NZD', 17 => '', 18 => 'SGD', 19 => 'RUB', 20 => 'MYR',
            21 => 'THB', 22 => 'PHP',
        ];
    }

    /**
     * @param $currencyId
     * @return string
     */
    public function getCurrenciesCode($currencyId)
    {
        if (isset(self::toCurrenciesSymbol()[$currencyId])) {
            $currenciesCode = self::toCurrenciesSymbol()[$currencyId];
        } else {
            $currenciesCode = $this->currencyRepository->getCurrenciesCodeByID($currencyId)['code'];
        }
        return $currenciesCode;
    }

    /**
     * 返回发货主体对应的公司信息
     * @param $productsInstockInfo
     * @param $ompanyRepository
     * @throws InvoiceException
     * @return mixed
     */
    public static function invoiceCompanyInfo($productsInstockInfo, CompanyRepository $companyRepository)
    {
        $seattle = $productsInstockInfo->is_seattle;
        $notTransport = $productsInstockInfo->is_not_transport;
        if ($seattle) {
            $companyId = self::toSeattleCompany()[$seattle];
        } elseif ($notTransport > 1) {
            $companyId = self::toTransportCompany()[$notTransport];
        } else {
            $companyId = 10;//国内直发的统一算深圳公司
        }
        $companyRes = $companyRepository->getCompanyBaseInfo($companyId);
        if (empty($companyRes)) throw new InvoiceException(__('finance::invoice.deliverCompanyNotExists'));
        $company['company_uuid'] = $companyRes->uuid;
        $company['company_name'] = $companyRes->name;

        return $company;
    }

    /**
     * @param $productsInstockInfo
     * @return mixed
     * @throws InvoiceException
     */
    public static function invoiceCustomerInfo($productsInstockInfo, ProductsInstockShippingApplyRepository $applyRepository)
    {
        $mergeId = $productsInstockInfo->shipping_merge_id;
        $customerNumber = $productsInstockInfo->No;
        if (preg_match('/^BK/i', $productsInstockInfo->orders_num)) {
            $shippingApply = $applyRepository->getShippingApplyInfo(['fill_money_num' => $productsInstockInfo->orders_num]);
            if (empty($shippingApply)) throw new InvoiceException(__('finance::invoice.bkApplyNotExists'));
            $company_number = $shippingApply->company_number;
        } else{
            $productsInstockFieldsMain = new ProductsInstockShippingFieldsRepository();
            $company_number = $productsInstockFieldsMain->getProductsInstockShippingFieldsByProductsInstockId($productsInstockInfo->products_instock_id)->company_number??'';
        }
        if (empty($company_number)) throw new InvoiceException(__('finance::invoice.customerCompanyNumberNotExists'));
        $customerInfo['customer_number'] = $customerNumber;
        $customerInfo['customer_company_number'] = $company_number;
        $manageCustomerCompanyMain = new ManageCustomerCompanyRepository();
        $customersCompany = $manageCustomerCompanyMain->getCustomerCompanyByCompanyNumber($company_number)->customers_company??'';
        if (empty($customersCompany)) throw new InvoiceException(__('finance::invoice.customerCompanyNotExists'));
        $customerInfo['customer_company_name'] = $customersCompany;

        return $customerInfo;
    }

    /**
     * @param $request
     * @param $invoice
     * @param $assistantData
     * @return mixed
     */
    public static function invoiceAdditionalInfo($request, $invoice, $assistantData)
    {
        $others['uuid'] = Str::uuid()->getHex()->toString();
        $others['amount'] = 0;
        $others['currency'] = '';
        $others['origin_uuid'] = null;
        $others['account_days'] = '';
        $others['assistant_name'] = $assistantData->name;
        $others['assistant_uuid'] = $assistantData->uuid;
        $others['cleared'] = 0;
        $others['cleared_status'] = 0;
        $others['relate_id'] = $invoice->relate_id;
        $others['relate_type'] = $invoice->type==2?2:1;
        $others['to_void'] = 0;
        $others['number'] = $request->invoice_number;
        $others['type'] = $request->type;
        $others['remark'] = $request->remark;

        return $others;
    }

    /**
     * 发票核销、清账
     * @param $productsInstockInfo
     * @param $adminData
     * @param $invoice
     * @return array|mixed
     */
    public function  invoiceReceiptClear($productsInstockInfo, $adminData=null, $invoice=null)
    {

        $productsInstockIds[] = $productsInstockInfo->products_instock_id;
        $mergeId = $productsInstockInfo->shipping_merge_id;
        $fields = ['relate_id' => $productsInstockInfo->products_instock_id, 'relate_type' => 1];
        if ($mergeId) {
            $all = ProductsInstockShippingRepository::getProductsInstockShippingData(['shipping_merge_id' => $mergeId]);
            $productsInstockIds = $all->pluck('products_instock_id')->toArray();
            $fields = ['relate_id' => $mergeId, 'relate_type' => 2];
        }
        $invRepo = $this->invoiceRepository;
        if (!$invoice) {
            $invoice = $invRepo->getInvoiceByIdType($fields);
            if (!$invoice) {
                return true;
            }
            $invoice = $invoice->toArray();
        }
        $details = $invRepo->getPaymentReceiptsVouchersDetails($productsInstockIds);
        if (!$details) return true;
        $detailsArr = $details->toArray();
        $res = [];
        if (count($detailsArr) === 0) return $res;
        foreach ($detailsArr as $k => $v) {
            $res[$k]['uuid'] = Str::uuid()->getHex()->toString();
            $res[$k]['order_id'] = $v['order_id'];
            $res[$k]['order_number'] = $v['order_number'];
            $res[$k]['voucher_number'] = $v['voucher_number'];
            $res[$k]['voucher_currency'] = $v['voucher_currency'];
            $res[$k]['voucher_clear'] = $v['voucher_use'];
            $res[$k]['receipt_uuid'] = $v['receipt_uuid'];
            $res[$k]['receipt_number'] = $v['receipt_number'];
            $res[$k]['receipt_currency'] = $v['receipt_currency'];
            $res[$k]['receipt_clear'] = $v['receipt_use'];

            $res[$k]['invoice_uuid'] = $invoice['uuid'];
            $res[$k]['invoice_number'] = $invoice['number'];
            $res[$k]['invoice_currency'] = $invoice['currency'];
            $res[$k]['invoice_clear'] = $v['voucher_use'];
            $invRepo->toSaveInvoicesToReceipts($res[$k]);//核销数据

            $this->receiptRepository->updateCleared($v['receipt_uuid'], $v['receipt_use']);//更新到款的清账金额
            sleep(1);//避免清账时间一样，排序不准确
            $invoice = self::invoiceClearAccount($res[$k], $invoice, $adminData);//清账, 且更新发票数组中的已核销金额
        }
        return $res;
    }


    /**
     * 清账
     * @param $writeOffData
     * @param $invoice
     * @return array|mixed
     */
    public function invoiceClearAccount($writeOffData, $invoice, $adminData=null)
    {
        $erpShip = ProductsInstockShippingRepository::getProductsInstockShippingData(['products_instock_id' => $writeOffData['order_id']])->first();
        $orderNumber = $erpShip->order_number?$erpShip->order_number:$erpShip->order_invoice;
        if (!$adminData) {
            $adminData = AdminRepository::getAdminByName('root');
        }

        $res['uuid'] = Str::uuid()->getHex()->toString();
        $res['income_number'] = $writeOffData['receipt_number'];
        $res['income_currency'] = $writeOffData['receipt_currency'];
        $res['income_clear'] = $writeOffData['receipt_clear'];
        $res['expend_number'] = $writeOffData['invoice_number'];
        $res['expend_currency'] = $writeOffData['invoice_currency'];
        $res['expend_clear'] = $writeOffData['invoice_clear'];
        $res['expend_unclear'] = ($invoice['amount'] - $invoice['cleared'] - $writeOffData['invoice_clear']);
        $res['expend_status'] = 1;
        $res['flag'] = 1;
        $res['type'] = 1;
        $res['remark'] = '';
        $res['order_number'] = $orderNumber;
        $res['clear_uuid'] = $adminData->uuid;
        $res['clear_name'] = $adminData->name;

        $invRepo = $this->invoiceRepository;
        $invRepo->toSaveClearAccounts($res);//清账数据
        $uCleared = $invoice['amount'] - $res['expend_unclear'];//已清账总金额
        $invoice['cleared'] = $uCleared;//更新发票数组中的已核销金额
        $invRepo->toUpdate(['uuid' => $invoice['uuid']], ['cleared' => $uCleared]);

        return $invoice;
    }
    /**
     * 返回发票对应的订单信息
     * @param $productsInstockRes
     * @return array|mixed
     */
    public static function getInvoiceRelates($productsInstockRes)
    {
        $relates = $instockIds = [];
        $erpOrderUrl = config('app.service_erp_url') . '/' . 'products_instock_shipping_sales_process.php';
        foreach ($productsInstockRes as $val) {
            $instockIds[] = $val->products_instock_id;
            $orderNumber = $val->order_number?$val->order_number:$val->order_invoice;
            $relates[] = [
                'number' => $val->orders_num,
                'number_url' => $erpOrderUrl . '?search=' . $val->orders_num,
                'order_number' => $orderNumber,
                'order_number_url' =>  $erpOrderUrl . '?search=' . $orderNumber,
            ];
        }
        $data = ['relates_info' => $relates, 'instock_ids' => $instockIds];
        return $data;
    }

    /**
     * 设置发票的红冲、折让、坏账、核销记录
     * @param $instockIds
     * @param $invoiceUuid
     * @param InvoiceRepository $invoiceRepository
     */
    public function setCreditNotes($instockIds, $invoiceUuid, InvoiceRepository $invoiceRepository)
    {
        $this->creditRefund = (new OrderOffsetInfosRepository)->getOrderCreditRefund($instockIds);//退税红冲
        $this->creditAfter = (new OrderOffsetInfosRepository)->getOrderCreditAfter($instockIds);//售后红冲
        $this->concessionRes = (new OrderOffsetInfosRepository)->getOrderConcession($instockIds);//折让、坏账
        $this->invoiceReceipt = $invoiceRepository->getInvoicesToReceipts(['invoice_uuid'=>$invoiceUuid]);//核销记录
    }

    /**
     * 返回发票对应的红冲、折让、坏账数据
     * @param $instockIds
     * @param $invoiceUuid
     * @param $invoiceRepository
     * @return array|mixed
     */
    public function getInvoiceOffsetInfos($instockIds, $invoiceUuid, InvoiceRepository $invoiceRepository)
    {
        $this->setCreditNotes($instockIds, $invoiceUuid, $invoiceRepository);
        $offsetInfos = [];
        $creditAmount = $currencyId = 0;
        foreach ($this->creditRefund as $val) {
            $currencyId = $val['currencies_id'];
            $creditAmount += $val['apply_money'];
        }
        foreach ($this->creditAfter as $val) {
            $currencyId = $val['refund_symbol'];
            $creditAmount += $val['refund_money_total'];
        }
        if ($currencyId) {
            $offsetInfos[] = [
                'id' => 1,
                'type' => self::Offset_Infos[1],
                'currency' => $this->getCurrenciesCode($currencyId),
                'amount' => round($creditAmount * 100),
            ];
        }
        $twoCurrencyId = $threeCurrencyId = 0;
        $twoAmount = $threeAmount = 0;
        foreach ($this->concessionRes as $val) {
            if (isset($val['child']['id'])) {
                continue;
            }
            if (in_array($val['is_advance'], [23, 24])) {
                $twoCurrencyId = $val['currencies_id'];
                $twoAmount += $val['apply_money'];
            }
            if (in_array($val['is_advance'], [13, 14, 15])) {
                $threeCurrencyId = $val['currencies_id'];
                $threeAmount += $val['apply_money'];
            }
        }
        if ($twoCurrencyId) {
            $offsetInfos[] = [
                'id' => 2,
                'type' => self::Offset_Infos[2],
                'currency' => $this->getCurrenciesCode($twoCurrencyId),
                'amount' => round($twoAmount * 100),
            ];
        }
        if ($threeCurrencyId) {
            $offsetInfos[] = [
                'id' => 3,
                'type' => self::Offset_Infos[3],
                'currency' => $this->getCurrenciesCode($threeCurrencyId),
                'amount' => round($threeAmount * 100),
            ];
        }
        $receiptArr = $this->invoiceReceipt->toArray();
        if ($receiptArr) {
            $offsetInfos[] = [
                'id' => 4,
                'type' => self::Offset_Infos[4],
                'currency' => $receiptArr[0]['invoice_currency'],
                'amount' => round(array_sum(array_column($receiptArr, 'invoice_clear'))),
            ];
        }
        return $offsetInfos;
    }

    /**
     * 根据发票生成日期、截止日期、账期天数，返回风险等级
     * @param $startDate
     * @param $endDate
     * @param $accountDays
     * @return string
     */
    public static function getInvoiceRisk($startDate, $endDate, $accountDays)
    {
        if ($accountDays) {
            $days = round((strtotime($endDate) - strtotime($startDate)) / 86400 - (int)$accountDays);
            switch ($days) {
                case $days <= 0:
                    $risk = 0;
                    break;
                case $days <= 30:
                    $risk = 1;
                    break;
                case $days <= 90:
                    $risk = 2;
                    break;
                default:
                    $risk = 3;
                    break;
            }
        } else {
            $risk = 0;
        }
        return $risk;
    }


    /**
     * 返回发票详情里的红冲数据
     * @return array|mixed
     */
    public function getInvoiceCreditNotes()
    {
        $credit = [];
        $creditRefund = $this->creditRefund;//退税红冲
        foreach ($creditRefund as $val) {
            $invoice = InvoiceRepositoryMain::findProductsInvoice($val['products_instock_id'], 5);
            $productsInstockRes = $this->invoiceRepository->getErpProductsInstockShippingData($val['products_instock_id'], 1);
            $orderInfo = self::getInvoiceRelates($productsInstockRes);
            $customerNo = $productsInstockRes->shift()->No;
            $companyNumber = (new ProductsInstockShippingFieldsRepository())->getProductsInstockShippingFieldsByProductsInstockId($val['products_instock_id'])->company_number;
            $manageCustomerCompanyMain = (new ManageCustomerCompanyRepository())->getCustomerCompanyByCompanyNumber('G211000005');
            $customersCompany = $manageCustomerCompanyMain->customers_company??'';
            $credit[] = [
                'number' => $invoice->in_number,
                'type' => 5,
                'create_at' => $invoice->create_at? Carbon::createFromFormat('Y-m-d H:i:s',$invoice->create_at, 'Asia/Shanghai')->tz(config('app.timezone'))->toJSON() : $invoice->create_at,
                'apply_admin_name' => AdminRepository::getAdminInfoByOriginId($val['apply_admin'])->name,
                'return_type_name' => '退税',
                'relate_number' => $orderInfo['relates_info'][0]['number'],
                'relate_number_url' => $orderInfo['relates_info'][0]['number_url'],
                'order_number' => $orderInfo['relates_info'][0]['order_number'],
                'order_number_url' => $orderInfo['relates_info'][0]['order_number_url'],
                'customer_company_number' => $companyNumber,
                'customer_number' => $customerNo,
                'customer_company_name' => $customersCompany,
                'customer_email' => CustomerRepository::getCustomerByNumber($customerNo)->customers_email_address??'',
                'currency' => $this->getCurrenciesCode($val['currencies_id']),
                'amount' => round($val['apply_money'] * 100),
                'status' => 0,
            ];
        }
        $creditAfter = $this->creditAfter;//售后红冲
        foreach ($creditAfter as $val) {
            $invoice = InvoiceRepositoryMain::findProductsInvoice($val['return_id'], 3);
            $productsInstockRes = $this->invoiceRepository->getErpProductsInstockShippingData($val['products_instock_id'], 1);
            $orderInfo = self::getInvoiceRelates($productsInstockRes);
            $customerNo = $productsInstockRes->shift()->No;
            $companyNumber = (new ProductsInstockShippingFieldsRepository())->getProductsInstockShippingFieldsByProductsInstockId($val['products_instock_id'])->company_number;
            $manageCustomerCompanyMain = (new ManageCustomerCompanyRepository())->getCustomerCompanyByCompanyNumber('G211000005');
            $customersCompany = $manageCustomerCompanyMain->customers_company??'';
            $credit[] = [
                'number' => $invoice->in_number??'',
                'type' => 3,
                'create_at' => $invoice->create_at?Carbon::createFromFormat('Y-m-d H:i:s',$invoice->create_at, 'Asia/Shanghai')->tz(config('app.timezone'))->toJSON():'',
                'apply_admin_name' => AdminRepository::getAdminInfoByOriginId($val['apply_admin'])->name,
                'return_type_name' => self::RETURN_TYPE_ONE[$val['return_type_one']] . self::RETURN_TYPE_TWO[$val['return_type_two']],
                'relate_number' => $orderInfo['relates_info'][0]['number'],
                'relate_number_url' => $orderInfo['relates_info'][0]['number_url'],
                'order_number' => $orderInfo['relates_info'][0]['order_number'],
                'order_number_url' => $orderInfo['relates_info'][0]['order_number_url'],
                'customer_company_number' => $companyNumber,
                'customer_number' => $customerNo,
                'customer_company_name' => $customersCompany,
                'customer_email' => CustomerRepository::getCustomerByNumber($customerNo)->customers_email_address??'',
                'currency' => $this->getCurrenciesCode($val['refund_symbol']),
                'amount' => round($val['refund_money_total'] * 100),
                'status' => 0,
            ];
        }
        return $credit;
    }

    /**
     * 返回发票详情里的核销数据
     * @return array|mixed
     */
    public function getInvoiceWriteOffs()
    {
        $receipt = [];
        $invoiceReceipt = $this->invoiceReceipt;
        foreach ($invoiceReceipt as $val) {
            $receipt[] = [
                'invoice_number' => $val->invoice_number,
                'invoice_currency' => $val->invoice_currency,
                'invoice_clear' => $val->invoice_clear,
                'voucher_number' => $val->voucher_number,
                'voucher_currency' => $val->voucher_currency,
                'voucher_clear' => $val->voucher_clear,
                'receipt_number' => $val->receipt_number,
                'receipt_currency' => $val->receipt_currency,
                'receipt_clear' => $val->receipt_clear,
                'order_number' => $val->order_number,
                'created_at' => Carbon::parse($val->created_at)->toJSON(),
            ];
        }
        return $receipt;
    }

    /**
     * 返回发票详情里的坏账折让数据
     * @param $invoice
     * @return array|mixed
     */
    public function getInvoiceConcession($invoice)
    {
        $concessio = [
            'discounts' => [],
            'bad_debts' => [],
        ];
        $concessionRes = $this->concessionRes;//折让、坏账
        foreach ($concessionRes as $val) {
            $keyVale = in_array($val['is_advance'], [23, 24])?'discounts':'bad_debts';
            $concessio[$keyVale][] = [
                'apply_time' => $val['apply_time']?Carbon::createFromFormat('Y-m-d H:i:s', $val['apply_time'], 'Asia/Shanghai')->tz(config('app.timezone'))->toJSON():$val['apply_time'],
                'apply_name' => AdminRepository::getAdminInfoByOriginId($val['apply_admin'])->name??'',
                'apply_number' => $val['unique_number']['income_number']??'',
                'apply_currency' => $this->getCurrenciesCode($val['currencies_id']),
                'apply_amount' => round($val['apply_money'] * 100),
                'apply_status' => isset($val['child']['id'])?-1:$val['status'],
                'customer_company_number' => $invoice->customer_company_number,
                'customer_number' => $invoice->customer_number,
                'customer_company_name' => $invoice->customer_company_name,
                'customer_email' => CustomerRepository::getCustomerByNumber($invoice->customer_number)->customers_email_address??'',
            ];
        }
        return $concessio;
    }


    /**
     * 红冲
     * @param $invoice
     * @param $request
     * @param $receiptService
     * @throws InvoiceException
     * @return mixed
     */
    public function invoiceClear($invoice, $request, $receiptService)
    {
        $fields = ['invoice_uuid' => $invoice->uuid];
        $invoiceReceipt = $this->invoiceRepository->getInvoicesToReceipts($fields);//发票核销记录
        if ($invoiceReceipt) {
            $receiptTotal = array_sum(array_column($invoiceReceipt->toArray(),'invoice_clear'));//核销金额
            if (($invoice->amount - $invoice->cleared - $request->income_clear + $receiptTotal) < 0) {
                throw new InvoiceException(__('finance::invoice.clearAmountError'));
            }
            $alreadyClear = $request->income_clear + $invoice->cleared;//已核销金额
            $notClear = $invoice->amount - $alreadyClear;//未核销金额，可能为负数。
            $invoice = $this->createClearAccounts($invoice, $request, '' , 0);//生成清账记录，且更新发票数据的已核销金额
            $this->invoiceRepository->toUpdate(['uuid' => $invoice->uuid], ['cleared' => $alreadyClear]);//更新发票已核销金额
            if ($notClear < 0 ) {
                //未清金额为负数的情况，则需回退核销的金额
                foreach ($invoiceReceipt as $val) {
                    if ($notClear == 0) {
                        break;
                    }
                    $backClear = abs($notClear)>$val->invoice_clear?$val->invoice_clear:abs($notClear);//此次清账回退金额
                    $backClearDk = $backClear;
                    $notClear += $backClear;//未清金额 + 此次清账金额=剩余未清余额
                    $newInvoiceClear = $val->invoice_clear - $backClear;//核销记录中的发票金额-此次退回的金额
                    $newVoucherClear = $val->voucher_clear - $backClear;//核销记录中的用款金额-此次退回的金额
                    if ($val->receipt_currency != $val->invoice_currency) {
                        $receipt = $this->receiptRepository->find($val->receipt_uuid);
                        $backClearDk = Exchange::exchange($receipt->created_at, $val->invoice_currency, $backClear, $val->receipt_currency);
                    }
                    $newReceiptClear = $val->receipt_clear - $backClearDk;//核销记录中的到款金额-此次退回的金额

                    $this->invoiceRepository->invoiceToReceiptUpdate(
                        ['uuid' => $val->uuid],
                        ['invoice_clear' => $newInvoiceClear,'voucher_clear' => $newVoucherClear,'receipt_clear' => $newReceiptClear]
                    );
                    $receiptRes = $val;
                    $receiptRes->invoice_clear = $backClear;
                    $receiptRes->voucher_clear = $backClear;
                    $receiptRes->receipt_clear = $backClearDk;
                    sleep(1);//避免清账时间一样，排序不准确
                    $invoice = $this->createClearAccounts($invoice, $request, $receiptRes, 1);//生成到款回退清账记录，且更新发票数据的已核销金额
                    //todo 更新到款、凭证的金额，记录更新日志
                    if (abs($backClearDk) > 0 || abs($backClear) > 0 ) {
                        $receiptService->clearReceiptVoucherAndDetail($val->receipt_uuid, $val->voucher_number, $val->order_number, -$backClearDk, -$backClear);
                    }

                    $alreadyClear -= $backClear;//已核销金额 - 此次回退金额
                    $this->invoiceRepository->toUpdate(['uuid' => $invoice->uuid], ['cleared' => $alreadyClear]);//更新发票已核销金额
                }
            }

            return $invoice;
        } else {
            $alreadyClear = $request->income_clear + $invoice->cleared;//已核销金额+红冲金额
            if ($alreadyClear > $invoice->amount) {
                throw new InvoiceException(__('finance::invoice.clearAmountError'));
            }

            $this->invoiceRepository->toUpdate(['uuid' => $invoice->uuid], ['cleared' => $alreadyClear]);//更新发票已核销金额
            return $invoice;
        }
    }

    /**
     * 生成清账记录
     * @param $invoice
     * @param $request
     * @return mixed
     */
    public function createClearAccounts($invoice, $request, $invoiceReceipt, $type=0)
    {
        $adminData = $this->invoiceRepository->getErpAssistantData($request->admin_id);//操作人
        $invoiceClear = $type==1?$invoiceReceipt->invoice_clear:$request->income_clear;
        if ($type == 1 || !$request->flag) {
            $invoice->cleared -= $invoiceClear;// type=1 或 flag=0时为退款，发票已清金额-=此次清账金额
        } else {
            $invoice->cleared += $invoiceClear;// !=1时为正常清账，发票已清金额+=此次清账金额
        }
        $clearData['uuid'] = Str::uuid()->getHex()->toString();
        //红冲退回核销金额生成清账记录，需记录DK信息
        $clearData['income_number'] = $type==1?$invoiceReceipt->receipt_number:$request->income_number;
        $clearData['income_currency'] = $type==1?$invoiceReceipt->receipt_currency:$request->income_currency;
        $clearData['income_clear'] = $type==1?$invoiceReceipt->receipt_clear:$request->income_clear;

        $clearData['expend_number'] = $request->expend_number;
        $clearData['expend_currency'] = $invoice->currency;
        $clearData['expend_clear'] = $invoiceClear;
        $clearData['expend_unclear'] = ($invoice->amount - $invoice->cleared);
        $clearData['expend_status'] = 1;
        $clearData['flag'] = $type==1?0:$request->flag;
        $clearData['type'] = $type==1?1:$request->type;
        $clearData['remark'] = $type==1?$request->income_number.$request->remark.' 退款还原'.$invoiceReceipt->receipt_number:$request->remark;
        $clearData['order_number'] = $request->order_number;
        $clearData['clear_uuid'] = $adminData->uuid;
        $clearData['clear_name'] = $adminData->name;

        $save = $this->invoiceRepository->toSaveClearAccounts($clearData);

        return $invoice;
    }

    /**
     * 返回清账表的的发票对象
     * @param $requestArr
     * @param $type
     * @param $admins
     * @return Invoice
     */
    public function getClearInvoice($requestArr, $type, $admins)
    {
        $invoice = new Invoice();
        $invoice = $this->getInvoiceByAdmin($invoice, $type, $admins);
        $invoice = $this->getInvoiceByScreen($invoice, $requestArr);
        return $invoice;
    }

    /**
     * 返回列表筛选条件
     * @param $invoice
     * @param $requestArr
     * @return mixed
     */
    public function getInvoiceByScreen($invoice, $requestArr)
    {
        foreach ($requestArr['filter'] as $k => $val) {
            if (!$val) {
                continue;
            }
            switch ($k) {
                case "type":
                    $invoice = $invoice->where('type', '=', $val);
                    break;
                case "company_uuid":
                    $invoice = $invoice->where('company_uuid', '=', $val);
                    break;
                case "assistant_uuid":
                    $invoice = $invoice->where('assistant_uuid', '=', $val);
                    break;
                case "cleared_status":
                    $invoice = $invoice->where('cleared_status', '=', $val);
                    break;
                case "to_void":
                    $invoice = $invoice->where('to_void', '=', $val);
                    break;
                case "created_at_begin":
                    $invoice = $invoice->where('created_at', '>=', Carbon::parse($val)->toDateTimeString());
                    break;
                case "created_at_end":
                    $invoice = $invoice->where('created_at', '<=', Carbon::parse($val)->toDateTimeString());
                    break;
                case "risk":
                    if ($val == 'no') {
                        $invoice = $invoice->where(function ($q){
                           $q->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days')
                            ->orWhere('account_days', '0');
                        });
                    } else if ($val == 'low') {
                        $invoice = $invoice->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days+30')
                            ->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days')
                            ->where('account_days', '<>', '0');
                    } else if ($val == 'medium') {
                        $invoice = $invoice->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days+30')
                            ->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) <= account_days+90')
                            ->where('account_days', '<>', '0');
                    } else if ($val == 'high') {
                        $invoice = $invoice->whereRaw('(TIMESTAMPDIFF(DAY,created_at,DATE_FORMAT(NOW(), \'%Y-%m-%d %H:%i:%S\'))) > account_days+90')
                            ->where('account_days', '<>', '0');
                    }
                    break;
            }
        }
        return $invoice;
    }

    /**
     * 返回用户筛选条件
     * @param $invoice
     * @param $requestArr
     * @return mixed
     */
    public function getInvoiceByAdmin($invoice, $type, $admins)
    {
        switch ($type) {
            case 2:
                return $invoice->whereIn('assistant_uuid', $admins);
                break;
            case 3:
                return $invoice->where('assistant_uuid', $admins);
                break;
        }
        return $invoice;
    }
}
