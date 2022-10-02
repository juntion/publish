<?php


namespace Modules\Finance\Http\Controllers\Receipt\Import;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Base\Repositories\Company\CompanyBankAccountsRepository;
use Modules\Base\Support\Facades\Number;
use Modules\ERP\Contracts\PaymentMethodService;
use Modules\Finance\Contracts\ReceiptRepository;
use Modules\Finance\Exceptions\ClaimException;

class ReceiptImport implements ToCollection
{

    protected $commonCreditCardHeader
        = [ // 通用信用卡表头,包括 澳洲，美国，欧洲
            0  => "Name",
            1  => "Account Name",
            2  => "Ref Num",
            3  => "Cust. Ref Num",
            4  => "Card Type",
            5  => "Status",
            6  => "Auth No",
            7  => "Time",
            8  => "Merchant Name",
            9  => "Terminal Name",
            10 => "Expiry",
            11 => "Gateway",
            12 => "Merchant Code",
            13 => "Tag",
            14 => "Amount",
            15 => "Currency",
            16 => "Card Number",
            17 => "Code",
            18 => "Reference 3",
            19 => "User ID",
            20 => "Bank Resp Code",
            21 => "ETG Resp Code",
        ];


    protected $SingaporeCreditCardHeader
        = [ // 新加坡表头
            0  => "Merchant ID",
            1  => "Contract ID",
            2  => "Order ID",
            3  => "Effort ID",
            4  => "Merchant Reference",
            5  => "Payment Reference",
            6  => "CustomerID",
            7  => "StatusID",
            8  => "Status Description",
            9  => "Payment Product ID",
            10 => "Payment Product Description",
            11 => "Order Country Code",
            12 => "Order Currency Code",
            13 => "Order Amount",
            14 => "Request Currency Code",
            15 => "Request Amount",
            16 => "Paid Currency",
            17 => "Paid Amount",
            18 => "Received Date",
            19 => "Status Date",
            20 => "Rejection Code",
            21 => "Remarks",
        ];

    protected $payPalHeader
        = [ // paypal 表头
            0  => "日期",
            1  => "时间",
            2  => "时区",
            3  => "名称",
            4  => "类型",
            5  => "状态",
            6  => "币种",
            7  => "总额",
            8  => "费用",
            9  => "净额",
            10 => "发件人邮箱地址",
            11 => "收件人邮箱地址",
            12 => "交易号",
            13 => "收货地址",
            14 => "地址状态",
            15 => "物品名称",
            16 => "物品号",
            17 => "运费和手续费金额",
            18 => "保险金额",
            19 => "营业税",
            20 => "选项 1 名称",
            21 => "选项 1 值",
            22 => "选项 2 名称",
            23 => "选项 2 值",
            24 => "参考交易号",
            25 => "账单号",
            26 => "自定义号码",
            27 => "数量",
            28 => "收据号",
            29 => "余额",
            30 => "地址第1行",
            31 => "地址第2行/区/临近地区",
            32 => "城镇/城市",
            33 => "省/市/自治区/直辖市/特别行政区",
            34 => "邮政编码",
            35 => "国家/地区",
            36 => "联系电话号码",
            37 => "主题",
            38 => "备注",
            39 => "国家/地区代码",
            40 => "引起余额变动",
        ];

    protected $commonHeader
        = [ // 通用性表头
            0 => "到款方式",
            1 => "交易流水号",
            2 => "到款时间",
            3 => "付款人名称",
            4 => "备注",
            5 => "FS单号",
            6 => "到款币种",
            7 => "到款金额",
            8 => "手续费",
        ];

    public $errorData = []; // 验证失败的数据

    protected $type; // 本次上传的附件类型


    protected $receiptRepository;
    protected $service;
    protected $companyPool = [];
    protected $companyBankAccountsRepository;
    protected $updateType;
    protected $index = 1;

    public function __construct(ReceiptRepository $repository, PaymentMethodService $service, CompanyBankAccountsRepository $companyBankAccountsRepository)
    {
        $this->receiptRepository = $repository;
        $this->service = $service;
        $this->companyBankAccountsRepository = $companyBankAccountsRepository;
    }

    /**
     * @param  Collection  $collection
     * @return array|bool
     * @throws ClaimException
     */
    public function collection(Collection $collection)
    {
        if ($this->index != 1) {
            return false;
        }
        $header = $collection[0]->toArray();
        $this->getDataType($header);
        unset($collection[0]);
        $collection->map(function ($item){
            $this->mapInsertData($item);
        });
        if (!empty($this->errorData)){
            $exportData = array_merge([$header], $this->errorData);
            $this->errorData = $exportData;
        }
        $this->index++;
    }

    /**
     * 判断是那种表头
     * @param  array  $header
     * @return int
     * @throws ClaimException
     */
    protected function getDataType(array $header)
    {
        if($header == $this->commonCreditCardHeader) {
            $type = 1;
        } else if ($header == $this->SingaporeCreditCardHeader) {
            $type = 2;
        } else if ($header == $this->payPalHeader) {
            $type = 3;
        } else if ($header == $this->commonHeader) {
            $type = 4;
        } else {
            throw new ClaimException(__("finance::receipt.fileError"));
        }
        $this->type = $type;
    }

    // 循环处理数据
    protected function mapInsertData(Collection $item)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $data = [];
            if ($this->type == 1) {
                $data = $this->getCommonCreditCardInsertData($item, $user);
            } elseif ($this->type == 2) {
                $data = $this->getSingaporeCreditCardInsertData($item, $user);
            } elseif ($this->type == 3) {
                $data = $this->getPayPalInsertData($item, $user);
            } elseif ($this->type == 4) {
                $data = $this->getCommonInsertData($item, $user);
            }
            $receipt = $this->checkData($data);
            $this->insertOrUpdateData($data, $receipt);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            if (!$exception instanceof ClaimException) {
                \Log::error("执行导入错误:".$exception->getMessage());
            }
            $item['error'] = $exception->getMessage();
            $this->errorData[] = $item;
        }
    }

    /**
     * 获取通用类型的数据
     * @param  Collection  $item
     * @param $user
     * @return mixed
     * @throws ClaimException
     */
    protected function getCommonCreditCardInsertData(Collection $item, $user)
    {
        if($item[5] != 'Approved' || $item['17'] != "Purchase" || $item['20'] != 100) {
            throw new ClaimException(__('finance::receipt.dataIsBad'));
        }
        $payType = trim($item[8]);
        switch ($payType) {
            case "FS.COM PTY LTD":
                $data['payment_method_id'] = 95;
                $data['payment_method_name'] = "Australian credit card";
                break;
            case "FS COM INC":
                $data['payment_method_id'] = 34;
                $data['payment_method_name'] = "American credit card";
                break;
            case "FSCOM EUR":
                $data['payment_method_id'] = 122;
                $data['payment_method_name'] = "European credit card";
                break;
            default:
                throw new ClaimException(__('finance::receipt.paymentError'));
                break;
        }
        $data['payment_remark'] = "付款人名称:" . $item[0] . ";FS单号:" . $item[2] . ";卡种:" . $item[4];
        $data['payer_name'] = $item[0];
        $data['order_number'] = $item[2];
        $data['payment_time'] = Carbon::parse($item[7])->toDateTimeString();
        if ((is_numeric($item[13]))&&(strpos($item[13],'E+')))
        {
            $transaction_serial_number = rtrim(rtrim(number_format($item[13],12,',',''),'0'),',');

            $data['transaction_serial_number'] = $transaction_serial_number; //  E+ to Number
        } else {
            $data['transaction_serial_number'] = $item[13];
        }
        $data['amount'] = $data['usable'] = round($item[14]*100);
        $data['currency'] = $item[15];
        if ((is_numeric($item[16]))&&(strpos($item[16],'.')))
        {
            $customer_debit_account = rtrim(rtrim(number_format($item[16],12,',',''),'0'),',');

            $data['customer_debit_account'] =$customer_debit_account; //  E+ to Number
        } else {
            $data['customer_debit_account'] = $item[16];
        }
        $data['used'] = 0;
        $data['cleared'] = 0;
        $data['create_from'] = 1;
        $data['creator_uuid'] = $user->uuid;
        $data['creator_name'] = $user->name;
        $data['fee_fs'] = 0;
        $data['is_match'] = 1;
        return $data;
    }

    /**
     * 获取新加坡数据
     * @param  Collection  $item
     * @param $user
     * @return mixed
     * @throws ClaimException
     */
    protected function getSingaporeCreditCardInsertData(Collection $item, $user)
    {
        if($item[3] < 1 || $item[7] < 800 || $item[7] > 1050) {
            throw new ClaimException(__('finance::receipt.dataIsBad'));
        }

        $data['payment_method_id'] = 6;
        $data['payment_method_name'] = "Credit card(800)";
        $order_number = substr($item[4],0, -7);
        $data['payment_remark'] = "StatusID:" . $item[7] . ";FS单号:" . $order_number . ";卡种:" . $item[10];
        $data['order_number'] = $order_number;
        $data['payment_time'] = Carbon::parse($item[18])->toDateTimeString();
        if ((is_numeric($item[2]))&&(strpos($item[2],'E+')))
        {
            $transaction_serial_number = rtrim(rtrim(number_format($item[2],12,',',''),'0'),',');

            $data['transaction_serial_number'] = $transaction_serial_number; //  E+ to Number
        } else {
            $data['transaction_serial_number'] = $item[2];
        }
        $data['amount'] = $data['usable'] = round($item[13]*100);
        $data['currency'] = $item[12];
        $data['used'] = 0;
        $data['cleared'] = 0;
        $data['create_from'] = 1;
        $data['creator_uuid'] = $user->uuid;
        $data['creator_name'] = $user->name;
        $data['fee_fs'] = 0;
        $data['is_match'] = 1;
        return $data;
    }

    /**
     * 获取paypal数据
     * @param  Collection  $item
     * @param $user
     * @return mixed
     * @throws ClaimException
     */
    protected function getPayPalInsertData(Collection $item, $user)
    {
        if(!in_array($item[4], ['普通付款', '网站付款', '移动支付', '集中付款', '快速结账付款']) || $item[5] != "已完成" || $item[9] < 0) {
            throw new ClaimException(__('finance::receipt.dataIsBad'));
        }
        if (!strpos($item[0], '-')){
            $day = date('Y-m-d', round(($item[0]-25569))*3600*24);
        } else {
            $day = $item[0];
        }

        if (is_numeric($item[1])) {
            $hour = date("H:i:s", round($item[1]*3600*24));
        } else {
            $hour = $item[1];
        }
        $payTime = $day . " " . $hour;
        $data['payment_time'] = Carbon::createFromTimeString($payTime, $item['2'])
            ->tz(config('app.timezone'))
            ->toDateTimeString(); // CST时区到UTC
        $data['payment_method_id'] = 2;
        $data['payment_method_name'] = "Paypal";
        $data['payer_name'] = $item[3];
        $data['currency'] = $item[6];
        $data['fee_fs'] = round(abs($item[8])*100);
        $data['fee'] = round(abs($item[8])*100);
        $data['amount'] = round($item[9]*100);
        $data['usable'] = round($item[7]*100);
        $data['payer_email'] = $data['customer_debit_account'] = $item[10];
        if ((is_numeric($item[12]))&&(strpos($item[12],'E+')))
        {
            $transaction_serial_number = rtrim(rtrim(number_format($item[12],12,',',''),'0'),',');

            $data['transaction_serial_number'] = $transaction_serial_number; //  E+ to Number
        } else {
            $data['transaction_serial_number'] = $item[12];
        }
        $data['order_number'] = $item[25];
        $data['payment_remark'] = "交易流水号:" . $data['transaction_serial_number'] . ";付款邮箱/客户打款账号:" . $item[10] .";付款人名称:" .$item[3] .";FS单号:". $item[25];
        $data['used'] = 0;
        $data['cleared'] = 0;
        $data['create_from'] = 1;
        $data['creator_uuid'] = $user->uuid;
        $data['creator_name'] = $user->name;
        $data['is_match'] = 1;
        return $data;
    }

    // 获取通用类型
    protected function getCommonInsertData(Collection $item, $user)
    {
        $data['payment_method_id'] = intval($item[0]);
        $data['payment_method_name'] = $this->service->getPaymentMethodName($item[0]);
        if (!strpos($item[2], '-')){
            $payTime = date('Y-m-d H:i:s', round(($item[2]-25569))*3600*24);
        } else {
            $payTime = $item[0];
        }
        $data['payment_time'] = Carbon::parse($payTime)->toDateTimeString();
        $data['transaction_serial_number'] = $item[1];
        $data['payer_name'] = $item[3];
        $data['payment_remark'] = $item[4];
        $data['order_number'] = $item[5];
        $data['currency'] = $item[6];
        $data['amount'] = round($item[7]*100);
        $data['fee_fs'] = round($item[8]*100);
        $data['fee'] = round($item[8]*100);
        $data['usable'] = $data['amount'] + $data['fee_fs'];
        $data['used'] = 0;
        $data['cleared'] = 0;
        $data['create_from'] = 1;
        $data['creator_uuid'] = $user->uuid;
        $data['creator_name'] = $user->name;
        $data['is_match'] = 1;
        return $data;
    }

    /**
     * 检查data是否正确
     * @param  array  $data
     * @return |null
     * @throws ClaimException
     */
    protected function checkData(array $data)
    {
        $transaction_serial_number = $data['transaction_serial_number'];
        $receipt = $this->receiptRepository->findByField('transaction_serial_number', $transaction_serial_number)->first();
        if(is_null($receipt)){
            $this->updateType = 1; // 插入
            return null;
        }
        if ($receipt->amount == $data['amount'] && $receipt->fee_fs == $data['fee_fs'])
        {
            $this->updateType = 2; // 只更新is_match
            return $receipt;
        } else if ($receipt->amount != $data['amount'] && $receipt->fee_fs != $data['fee_fs'] && ($receipt->amount + $receipt->fee_fs) == ($data['amount'] + $data['fee_fs'])) {
            $this->updateType = 3; // 更新is_match,  amount 和 fee_fs
            return $receipt;
        }

        throw new ClaimException(__('finance::receipt.dataIsBad'));
    }

    /**
     * 更新或插入数据
     * @param  array  $data
     * @param $receipt
     * @throws ClaimException
     */
    protected function insertOrUpdateData(array $data, $receipt)
    {
        if(is_null($receipt)){
            $data['uuid'] = Str::uuid()->getHex()->toString();
            $data['number'] = Number::create('DK')->get();
            if (!$data['payment_method_id'] || !$data['currency']) {
                throw new ClaimException(__('finance::receipt.dataIsBad'));
            } else {
                $account = $this->getAccountFormPool($data['payment_method_id'], $data['currency']);
            }
            if (is_null($account)) {
                throw new ClaimException(__('finance::receipt.accountNotFound'));
            }
            $data['company_uuid'] = $account->company->uuid;
            $data['company_name'] = $account->company->name;
            $data['company_account_number'] = $account->account_number;
            $this->receiptRepository->store($data);
        } else if ($this->updateType == 2) {
            $receipt->update([
                'is_match' => 1,
            ]);
        } else if ($this->updateType == 3) {
            $receipt->update([
                'is_match' => 1,
                'amount'   => $data['amount'],
                'fee_fs'   => $data['fee_fs'],
                'fee'      => DB::raw('fee +' . ($data['fee_fs'] - $receipt->fee_fs))
            ]);
        }
    }


    /**
     * 通过id-币值获取公司信息
     * @param $paymentMethodId
     * @param $currency
     * @return mixed
     */
    protected function getAccountFormPool($paymentMethodId, $currency)
    {
        $key = $paymentMethodId . '-' . $currency;
        if (!array_key_exists($key, $this->companyPool)) {
            $this->companyPool[$key] = $this->companyBankAccountsRepository->getAccountAndCompanyInfoByMethodAndCurrency($paymentMethodId, $currency);
        }
        return $this->companyPool[$key];

    }
}
