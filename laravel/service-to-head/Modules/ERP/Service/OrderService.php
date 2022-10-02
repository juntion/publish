<?php

namespace Modules\ERP\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\ERP\Contracts\CountryService;
use Modules\ERP\Contracts\OrderService as ContractsOrdersService;
use Modules\ERP\Contracts\OrderRepository;
use Modules\ERP\Enums\Countries\Flag;
use Modules\ERP\Enums\Order\PaymentMethod;
use Modules\Finance\Contracts\ReceiptRepository;
use Illuminate\Support\Arr;
use Modules\ERP\Entities\ProductsInstockShipping;
use Modules\ERP\Contracts\ProductsInstockShippingInfoRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\FsShippingReduceOrderRepository;
use Modules\ERP\Contracts\PaymentMethodRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Contracts\OrderPIRepository;
use Modules\ERP\Contracts\OrderTotalRepository;
use Modules\ERP\Contracts\OrderProductRepository;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\ProductsInstockShippingRefundTaxRepository;
use Modules\ERP\Contracts\ProductsInstockShippingSalesAfterRepository;
use Modules\ERP\Contracts\NsExpenseVoucherRecordRepository;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Exceptions\OrderException;
use Modules\Share\Entities\Collection;

class OrderService implements ContractsOrdersService
{
    const INCLUDE_FEE = [2, 6, 1, 16, 20, 21, 22, 23, 34];

    protected $ordersRepository;
    protected $receiptRepository;
    protected $reduceOrderRepository;
    protected $paymentMethodRepository;
    protected $shippingRepository;
    protected $infoRepository;
    protected $shippingApplyRepository;
    protected $orderPIRepository;
    protected $totalRepository;
    protected $orderProductRepository;
    protected $customerRepository;
    protected $companyRepository;
    protected $refundTaxRepository;
    protected $salesAfterRepository;
    protected $voucherRecordRepository;
    protected $currencyRepository;

    public function __construct(OrderRepository $ordersRepository, ReceiptRepository $receiptRepository, PaymentMethodRepository $paymentMethodRepository, FsShippingReduceOrderRepository $reduceOrderRepository,
                                InstockShippingRepository $shippingRepository, ProductsInstockShippingInfoRepository $infoRepository, ProductsInstockShippingApplyRepository $shippingApplyRepository,
                                OrderPIRepository $orderPIRepository, OrderTotalRepository $totalRepository, OrderProductRepository $orderProductRepository, CustomerRepository $customerRepository,
                                CustomerCompanyRepository $companyRepository, ProductsInstockShippingRefundTaxRepository $refundTaxRepository, ProductsInstockShippingSalesAfterRepository $salesAfterRepository,
                                NsExpenseVoucherRecordRepository $voucherRecordRepository, CurrencyRepository $currencyRepository)
    {
        $this->ordersRepository = $ordersRepository;
        $this->receiptRepository = $receiptRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->reduceOrderRepository = $reduceOrderRepository;
        $this->shippingRepository = $shippingRepository;
        $this->infoRepository = $infoRepository;
        $this->shippingApplyRepository = $shippingApplyRepository;
        $this->orderPIRepository = $orderPIRepository;
        $this->totalRepository = $totalRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
        $this->refundTaxRepository = $refundTaxRepository;
        $this->salesAfterRepository = $salesAfterRepository;
        $this->voucherRecordRepository = $voucherRecordRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * 前台订单支付方式转化
     * @param string $paymentModuleCode
     * @param string $currency
     * @param string $flagCountries
     * @return mixed
     */
    public static function getOrdersPaymentMethod(string $paymentModuleCode = 'paypal', string $currency = 'USD', string $flagCountries = '')
    {
        return collect([
            PaymentMethod::PAYPAL => ['paypal', 'paypalwpp', 'QIWI'],
            PaymentMethod::CREDIT_CARD_957 => ['globalcollect'],
            PaymentMethod::CREDIT_CARD_800 => ['iDEAL', 'eNETS', 'YANDEX', 'WEBMONEY', 'GV/ 折扣', 'GV/DC'],
            PaymentMethod::CREDIT_CARD_1050 => ['SOFORT'],
            PaymentMethod::CREDIT_CARD_BPAY => ['bpay'],
            PaymentMethod::WESTERN_UNION => ['westernunion'],
            PaymentMethod::WIRE_TRANSFER => ['hsbc'],
            PaymentMethod::WEIXIN => ['weixin'],
            PaymentMethod::ELECTRONIC_CHECK => ['echeck'],
            PaymentMethod::ALFA => ['alfa'],
        ])->when($paymentModuleCode == 'payeezy', function ($collection) use ($currency, $flagCountries) {
            $payeezy = [
                PaymentMethod::AMERICAN_CREDIT_CARD => ['USD'],
                PaymentMethod::EUROPEAN_CREDIT_CARD => ['EUR', 'USD', 'GBP', 'CHF', 'SEK'],
                PaymentMethod::AUSTRALIAN_CREDIT_CARD => ['AUD']
            ];
            if (in_array($currency, $payeezy[PaymentMethod::AUSTRALIAN_CREDIT_CARD])) {
                $payeezyPush = PaymentMethod::AUSTRALIAN_CREDIT_CARD;
            } elseif (in_array($currency, $payeezy[PaymentMethod::EUROPEAN_CREDIT_CARD]) && $flagCountries == Flag::GERMANY) {
                $payeezyPush = PaymentMethod::EUROPEAN_CREDIT_CARD;
            } else {
                $payeezyPush = PaymentMethod::AMERICAN_CREDIT_CARD;
            }
            return $collection->prepend(['payeezy'], $payeezyPush);
        })->filter(function ($value) use ($paymentModuleCode) {
            return in_array($paymentModuleCode, $value);
        })->keys()->first();
    }

    /**
     * 获取存款单数据
     * @return mixed
     * @throws BindingResolutionException
     */
    public function getOrdersDepositData()
    {
        $data = $this->ordersRepository->getOrdersDepositData();
        if ($data->isNotEmpty()) {
            $countryService = app()->make(CountryService::class);
            $accountRepository = app()->make(CompanyBankAccountsRepository::class);
            $orderCustomerCompanyService = app()->make(OrderCustomerCompanyService::class);
            $customerCompanyRepository = app()->make(CustomerCompanyRepository::class);
            $data->map(function ($item) use ($countryService, $accountRepository, $orderCustomerCompanyService, $customerCompanyRepository) {
                $paymentInfo = self::getGlobalcollectPaymentInfo($item['globalcollectPayment']->toArray());
                $customerInfo = $orderCustomerCompanyService->getCustomerAndCompanyInfoByOrderNumber($item['orders_number']);
                $companyInfo = $customerCompanyRepository->getCompanyByCustomerNumber($customerInfo->customerNumber);
                $payer_name = $paymentInfo['cardholder_name'] ?? $item['customers_name'];
                $bankSerial = $paymentInfo['bankserial'] ?? $item['paypal']->first()->txn_id ?? '';
                $customerCountries = $countryService->getCountryByFlag($item['delivery_country_id']);
                $paymentMethodId = self::getOrdersPaymentMethod($item['payment_module_code'], $item['currency'], $customerCountries);
                $accountInfo = $accountRepository->getAccountAndCompanyInfoByMethodAndCurrency($paymentMethodId, $item['currency']);
                $item['payment_method_id'] = $paymentMethodId;
                $item['transaction_serial_number'] = $bankSerial;
                $item['payment_remark'] = join('; ', array($item['orders_number'], $payer_name, $bankSerial));
                $item['payer_name'] = $payer_name;
                $item['payer_email'] = $item['customers_email_address'];
                $item['payment_time'] = $item['statusHistory']->where('orders_status_id', '2')->first()->date_added ?? $item['date_purchased'];
                $item['amount'] = $this->currencyRepository->getServiceFormatByErp($item['order_total'] * $item['currency_value']);
                $item['admin_id'] = $item['orderToAdmin']['admin_id'] ?? 0;
                $item['customer_number'] = $customerInfo->customerNumber ?? null;
                $item['customer_company_number'] = $item['company_number'] ?: $companyInfo->company_number ?: null;
                $item['company_uuid'] = $accountInfo->company->uuid ?? null;
                $item['company_name'] = $accountInfo->company->name ?? null;
                $item['company_account_number'] = $accountInfo->account_number ?? null;
            });
        }
        return $data;
    }

    /**
     * 获取客户付款信息
     * @param $paymentInfo
     * @return array
     */
    public static function getGlobalcollectPaymentInfo($paymentInfo): array
    {
        $res = [];
        $paymentInfo = $paymentInfo[0] ?? null;
        if (!is_null($paymentInfo)) {
            //银行流水
            if (isset($paymentInfo['payment_id'])) {
                if ($paymentInfo['type'] == 2) {
                    $json = json_decode($paymentInfo['imformation'], true);
                    $transactionStatus = isset($json['transaction_status']) ? strtolower($json['transaction_status']) : '';
                    $bankMessage = isset($json['bank_message']) ? strtolower($json['bank_message']) : '';
                    if (!empty($paymentInfo['imformation']) && $transactionStatus == 'approved' && $bankMessage == 'approved') {
                        $res['bankserial'] = $paymentInfo['payment_id'] ?? '';
                        $res['cardholder_name'] = $json['token']['token_data']['cardholder_name'] ?? '';
                    }
                } else {
                    if (strlen($paymentInfo['payment_id']) == 30) {
                        $res['bankserial'] = substr($paymentInfo['payment_id'], 10, 10);
                    }
                }
            }
        }

        return $res;
    }

    /**
     * 根据订单信息判断订单是否可支出
     * @param $orderNumber
     * @return Collection
     * @throws OrderException
     */
    public function checkOrder($orderNumber)
    {
        $totalPrice = 0; //订单金额

        $productsInstockId = 0;
        $originId = $paymentMethodId = $orderIsOnline = 0;
        $isHaveVoucher = $this->voucherRecordRepository->getVoucherInfoByOrderNumber($orderNumber);
        if ($isHaveVoucher->isNotEmpty()) {
            throw new OrderException(__('erp::order.orderVoucher'));
        }

        $orderInfo = $this->shippingRepository->getOrderByOrderNumber($orderNumber);

        $countryService = app()->make(CountryService::class);

        if ($orderInfo->isEmpty()) { // 支出录单
            // 支出 先找线上单
            $orderData = $this->ordersRepository->getAllOrderByOrderNumber($orderNumber);
            if (!$orderData->isEmpty()) {
                if (sizeof($orderData->toArray()) > 1) {
                    throw new OrderException(__('erp::order.orderFix'));
                }

                $orderData = $orderData->first();


                if ($orderData->main_order_id > 1) { // 子单 需查看主单是否已录入
                    $mainOrder = $this->shippingRepository->getOrderInfoByOrderID($orderData->main_order_id);
                    if ($mainOrder->isEmpty()) {
                        throw new OrderException(__('erp::order.orderInMain'));
                    } else {
                        throw new OrderException(__('erp::order.orderInProblem'));
                    }
                }

                if (!$orderData->customers_id || !$orderData->customers_email_address) {
                    throw new OrderException(__('erp::order.orderNoCustomer'));
                }

                if ($orderData->main_order_id == 1) { // 输入主单 验证产品数据
                    $sonOrderData = $this->ordersRepository->getSonOrderByMainOrderID($orderData->orders_id);
                    if (!$sonOrderData->isEmpty()) {
                        $sonOrderID = array_column($sonOrderData->toArray(), 'orders_id');
                        $sonOrderProduct = $this->orderProductRepository->getProductInfoByOrderID($sonOrderID);
                        if ($sonOrderProduct->isEmpty()) {
                            throw new OrderException(__('erp::order.orderNoProduct'));
                        }
                    }
                }

                $customerNumber = "";

                $companyNumber = $orderData->company_number ?? "";

                // 验证订单对应的客户公司
                if (empty($companyNumber)) {
                    if (!empty($orderData->customers_id)) {
                        $customerNum = $this->customerRepository->getCustomerOnByID($orderData->customers_id);
                        $customerNumber = $customerNum->customers_number_new ?? "";
                    } else if (!empty($orderData->customers_email_address)) {
                        $customerNum = $this->customerRepository->getCustomerOffByEmail($orderData->customers_email_address);
                        $customerNumber = $customerNum->customers_number_new ?? "";
                    }

                    if (!empty($customerNumber)) {
                        $company = $this->companyRepository->getCompanyByCustomerNumber($customerNumber);
                        $companyNumber = $company->company_number ?? "";
                    }
                }

                if (empty($companyNumber)) {
                    throw new OrderException(__('erp::order.orderNoComNum'));
                }

                // 验证订单是否欺诈
                if ($orderData->is_test > 1) {
                    throw new OrderException(__('erp::order.orderProblem'));
                }

                // 订单状态
                if (in_array($orderData->orders_status, [5, 6])) {
                    throw new OrderException(__('erp::order.orderCanceled'));
                }

                // 获取线上订单金额信息
                $orderPrice = $this->ordersRepository->getOrderPrice($orderData);

                foreach ($orderPrice->first()->prices as $price) {
                    if ($price->sort_order == '999') {
                        $totalPrice = round($price->value * 100);
                    }
                }

                // 币种
                $orderCurrency = $orderData->currency;

                $customerCountries = $countryService->getCountryByFlag($orderData->delivery_country_id);
                $paymentMethodId = self::getOrdersPaymentMethod($orderData->payment_module_code, $orderData->currency, $customerCountries);

                $orderIsOnline = 1; //线上单

            } else { //线上订单不存在 则找线下单数据
                $orderPIData = $this->orderPIRepository->getAllOrderByOrderNumber($orderNumber);
                if (!$orderPIData->isEmpty()) {
                    if (sizeof($orderPIData->toArray()) > 1) {
                        throw new OrderException(__('erp::order.orderFix'));
                    }

                    $orderPIData = $orderPIData->first();

                    if ($orderPIData->status == 2) {
                        throw new OrderException(__('erp::order.orderPICancel'));
                    }

                    $applyPIinfo = $this->shippingApplyRepository->getShippingApplyInfo([['apply_type', 27], ['is_delete', 0], ['orders_number', $orderNumber]]);
                    if (($orderPIData->is_issued_by_change && !$orderPIData->issued_by_change_type) || (!is_null($applyPIinfo) && in_array($applyPIinfo->status, [0, 3, 6]))) {
                        throw new OrderException(__('erp::order.orderIssuedByChange'));
                    }

                    $orderPIProduct = $this->orderPIRepository->getOrderProductInfo($orderPIData);
                    if ($orderPIProduct->isEmpty() || $orderPIProduct->first()->piProducts->isEmpty() || (!$orderPIProduct->first()->piProducts->isEmpty() && $orderPIProduct->first()->piProducts->first()->price <= 0)) {
                        throw new OrderException(__('erp::order.orderPIFix'));
                    }

                    if (!$orderPIData->customers_id) {
                        throw new OrderException(__('erp::order.orderNoPICus'));
                    }

                    $customerNumber = "";

                    $companyNumber = $orderPIData->company_number ?? "";

                    // 验证订单对应的客户公司
                    if (empty($companyNumber)) {
                        $piCustomerId = $orderPIData->pi_customers_id ?? ($orderPIData->customers_id ?? 0);
                        $customersType = $orderPIData->pi_customers_type ?? ($orderPIData->customers_type ?? "");
                        if (!empty($customersType) && $customersType == 1 && $piCustomerId) {
                            $customerNum = $this->customerRepository->getCustomerOnByID($piCustomerId);
                            $customerNumber = $customerNum->customers_number_new ?? "";
                        } else if (!empty($customersType) && $customersType == 2 && $piCustomerId) {
                            $customerNum = $this->customerRepository->getCustomerOffByID($piCustomerId);
                            $customerNumber = $customerNum->customers_number_new ?? "";
                        }

                        if (!empty($customerNumber)) {
                            $company = $this->companyRepository->getCompanyByCustomerNumber($customerNumber);
                            $companyNumber = $company->company_number ?? "";
                        }
                    }

                    if (empty($companyNumber)) {
                        throw new OrderException(__('erp::order.orderNoComNum'));
                    }

                    // 获取线下订单金额信息
                    $totalPrice = round($orderPIData->pi_total * 100);

                    $orderCurrency = $this->currencyRepository->getCurrenciesCodeByID($orderPIData->price_symbol)['code'];

                    $paymentMethodId = $orderPIData->order_payment;
                } else {
                    throw new OrderException(__('erp::order.orderNotFund'));
                }
            }
        } else { // 结清订单或补款单
            foreach ($orderInfo as $key => $value) {
                if ((!Str::contains($orderNumber, '-BK') && ($value->change_order > 0 || $value->delete_orders_payment > 0 || $value->is_split > 0 || in_array($value->cancel_order_status, [1, 2]))) ||
                    (Str::contains($orderNumber, '-BK') && $value->delete_orders_payment != 2)) { //排除原单及取消单
                    unset($orderInfo[$key]);
                    continue;
                }
            }

            if (!$orderInfo->isEmpty() && sizeof($orderInfo->toArray()) > 1) {
                throw new OrderException(__('erp::order.orderFix'));
            } else if ($orderInfo->isEmpty()) {
                throw new OrderException(__('erp::order.orderCancelOrigin'));
            }

            $orderInfo = $orderInfo->first();

            if (!$orderInfo->click_status && !Str::contains($orderNumber, '-BK')) {
                throw new OrderException(__('erp::order.orderClick'));
            }

            // 订单是否有产品
            $hasProduct = $this->infoRepository->getProductInfo($orderInfo);

            //如果是补款单 需要BK单无待审核的撤销申请
            if (Str::contains($orderNumber, '-BK') && is_null($hasProduct)) {
                $applyBK = $this->shippingApplyRepository->getShippingApplyInfo([['apply_type', 3], ['fill_money_num', $orderInfo->orders_num]]);

                if (!is_null($applyBK)) {
                    $isCancelBK = $this->shippingApplyRepository->getShippingApplyInfo([['apply_type', 26], ['is_delete', 0], ['fs_internal_id', '>', 0], ['fs_internal_id', $applyBK->id]]);
                    if (!is_null($isCancelBK) || (!is_null($isCancelBK) && !in_array($isCancelBK->status, [2, 4])) || !$applyBK->products_instock_id) {
                        throw new OrderException(__('erp::order.applyMoneyCancel'));
                    }
                }
            }

            // 订单对应的G编号
            $companyNumber = $this->shippingRepository->getShippingFieldInfo($orderInfo);
            if (Str::contains($orderNumber, '-BK') && !is_null($applyBK)) {
                $orderBkInfo = $this->shippingRepository->getOrderInfoByProductsInstockId($applyBK->products_instock_id);
                $companyNumber = $this->shippingRepository->getShippingFieldInfo($orderBkInfo);
            }
            $orderCustomerNumber = $companyNumber->instockShippingField->company_number ?? '';
            if (is_null($companyNumber) || (!is_null($companyNumber) && !$orderCustomerNumber)) {
                throw new OrderException(__('erp::order.orderNoComNum'));
            }

            // 订单是否已结清
            $orderClear = $this->checkOrderPaid($orderInfo, $orderTotal);
            if ($orderClear) {
                throw new OrderException(__('erp::order.orderCleared'));
            }
            // 获取订单金额等信息
            $totalPrice = $orderTotal;
            $productsInstockId = $orderInfo->products_instock_id;
            $originIdArr = [$orderInfo->products_instock_id, $orderInfo->split_order, $orderInfo->product_height, $orderInfo->origin_id];
            $originIdArr = array_unique($originIdArr);
            $originIdArr = array_filter($originIdArr);
            $originId = min($originIdArr);
            $orderCurrency = $this->currencyRepository->getCurrenciesCodeByID($orderInfo->symbol_left)['code'];

            if ($orderInfo->orders_id) {
                $orderData = $this->ordersRepository->getOrderInfoByOrderId($orderInfo->orders_id);
                if (!is_null($orderData)) {
                    $customerCountries = $countryService->getCountryByFlag($orderData->delivery_country_id);
                    $paymentMethodId = self::getOrdersPaymentMethod($orderData->payment_module_code, $orderData->currency, $customerCountries);
                    $orderIsOnline = 1;
                }
            } else {
                $orderInvoice = explode('-', $orderNumber)[0];
                $orderPIInfo = $this->orderPIRepository->getOrderInfoByOrderNumber($orderInvoice);
                $paymentMethodId = $orderPIInfo->order_payment ?? 0;
            }
        }

        $returnData = new Collection();
        $returnData->order_number = $orderNumber;
        $returnData->order_currency = $orderCurrency;
        $returnData->order_price = round($totalPrice);
        $returnData->products_instock_id = $productsInstockId;
        $returnData->origin_id = $originId;
        $returnData->payment_method_id = $paymentMethodId;
        $returnData->is_online = $orderIsOnline;

        return $returnData;
    }

    /**
     * 根据订单信息查验订单是否已结清
     *
     * @param ProductsInstockShipping $instockShipping
     * @param $orderTotal
     * @return bool
     */
    public function checkOrderPaid(ProductsInstockShipping $instockShipping, &$orderTotal)
    {
        $reduceMoney = $refundTax = $orderTotal = 0;
        // 订单冲减应收信息
        $reduceInfo = $this->reduceOrderRepository->getReduceInfoByShippingId($instockShipping->products_instock_id);
        if ($reduceInfo->isNotEmpty()) {
            foreach ($reduceInfo as $value) {
                if ($value->status == 1 && $value->is_delete == 0) {
                    $reduceMoney += (round($value->products_money * 100) + round($value->taxation * 100) + round($value->freight * 100));
                }
            }
        }
        $reduceMoney = intval($reduceMoney);

        // 订单退税信息
        $orderRefund = $this->refundTaxRepository->getOrderRefundInfo($instockShipping->products_instock_id);
        if ($orderRefund->isNotEmpty()) {
            $orderRefund = $orderRefund->first();
            if ($orderRefund->status == 1 && $orderRefund->is_delete == 0) {
                $refundTax = round($orderRefund->apply_money * 100);
                if (round($instockShipping->vat_tax * 100) < $refundTax) {
                    $refundTax = round($instockShipping->vat_tax * 100);
                }
            }
        }
        $refundTax = intval($refundTax);

        $orderTotal = intval(round($instockShipping->order_price * 100) - round($instockShipping->amount_use * 100) - $reduceMoney - $refundTax);

        $needClearPayment = $this->paymentMethodRepository->getPaymentMethodsIDByType(2);
        $needClearPayment = Arr::flatten($needClearPayment->toArray());

        //若为真实到款订单
        if (!in_array($instockShipping->order_payment, $needClearPayment)) {
            if ($orderTotal <= 0) { //已结清
                return true;
            }
        } else { //非真实到款订单
            if ($instockShipping->amount_recived && $instockShipping->order_price && ($instockShipping->amount_recived < $instockShipping->order_price) && !$instockShipping->amount_use) {
                if ($instockShipping->bad_debts) {
                    $badFee = round(json_decode($instockShipping->bad_debts)->fee * 100);
                    if ((round($instockShipping->order_price * 100) - round($instockShipping->amount_recived * 100) - $badFee - $reduceMoney - $refundTax) <= 0) {
                        return true;
                    }
                }
            } else {
                // 订单是否有产品
                $hasProduct = $this->infoRepository->getProductInfo($instockShipping);
                if (!in_array($instockShipping->order_payment, $needClearPayment) && is_null($hasProduct)) {
                    if (in_array($instockShipping->order_payment, self::INCLUDE_FEE)) {
                        $orderMoney = round($instockShipping->amount_recived * 100) - round($instockShipping->amount_use * 100);
                    } else {
                        $orderMoney = round($instockShipping->amount_recived * 100) + round($instockShipping->paypal_fee * 100) - round($instockShipping->amount_use * 100);
                    }
                    $isOrderMoney = true; //无产品 纯到款单
                } else {
                    $isOrderMoney = false; //有产品
                    $orderMoney = round($instockShipping->order_price * 100) - round($instockShipping->amount_use * 100);
                }
                $orderMoney = intval($orderMoney);

                // 如果是维修单，显示结清
                if (preg_match('/(-[0-9]{2}W)$|(-[0-9]{2}W-[0-9]{2}C)$/', $instockShipping->orders_num)) {
                    return true;
                }

                // 丢包少件-提前发新货，维修单，已结清
                if ($instockShipping->return_order) {
                    $isApplyClaim = $this->salesAfterRepository->getSaleAfterInfo([['return_type_one', 3], ['return_type_two', 6], ['new_instock_id', '>', 0], ['products_instock_id', $instockShipping->return_order]]);
                    $isApplyRepair = $this->salesAfterRepository->getSaleAfterInfo([['return_type_two', 3], ['new_instock_id', $instockShipping->products_instock_id]]);
                    if ($isApplyClaim->isNotEmpty() || $isApplyRepair->isNotEmpty()) {
                        return true;
                    }
                }

                $mountCompare = intval($orderMoney + $reduceMoney);

                if ($mountCompare == 0) {
                    return true;
                } else if ($mountCompare > 0) {
                    if ($isOrderMoney) {
                        return true;
                    }
                } else {
                    if (!$isOrderMoney) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
