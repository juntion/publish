<?php


namespace Modules\Finance\Contracts;

use Modules\Base\Contracts\Company\CompanyRepository;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\Finance\Services\ReceiptService;

interface InvoiceService
{
    /**
     * @param int $aide
     * @return int
     */
    public static function toAccountPeriodCalculation(string $aide): int;

    /**
     * @return mixed
     */
    public static function toSeattleCompany();
    /**
     * @return mixed
     */
    public static function toTransportCompany();
    /**
     * @return mixed
     */
    public static function toPaymentMethod();

    /**
     * @return mixed
     */
    public static function toCurrenciesSymbol();

    /**
     * @param $currencyId
     * @return string
     */
    public function getCurrenciesCode($currencyId);

    /**
     * 返回发货主体对应的公司信息
     * @param $productsInstockInfo
     * @param $companyRepository
     * @return mixed
     */
    public static function invoiceCompanyInfo($productsInstockInfo, CompanyRepository $companyRepository);

    /**
     * @param $productsInstockInfo
     * @return mixed
     */
    public static function invoiceCustomerInfo($productsInstockInfo, ProductsInstockShippingApplyRepository $applyRepository);

    /**
     * @param $request
     * @param $invoice
     * @param $assistantData
     * @return mixed
     */
    public static function invoiceAdditionalInfo($request, $invoice, $assistantData);

    /**
     * 发票核销、清账
     * @param $productsInstockInfo
     * @param $adminData
     * @param $invoice
     * @return array|mixed
     */
    public function invoiceReceiptClear($productsInstockInfo, $adminData, $invoice=null);

    /**
     * 清账
     * @param $writeOffData
     * @param $invoice
     * @param $adminData
     * @return array|mixed
     */
    public function invoiceClearAccount($writeOffData, $invoice, $adminData=null);

    /**
     * 根据发票生成日期、截止时间、账期计算发票的风险等级
     * @param $startDate
     * @param $endDate
     * @param $accountDays
     * @return mixed
     */
    public static function getInvoiceRisk($startDate, $endDate, $accountDays);

    /**
     * 根据发票订单数据，返回发票的订单数组
     * @param $productsInstockRes
     * @return mixed
     */
    public static function getInvoiceRelates($productsInstockRes);

    /**
     * 设置发票的红冲、折让、坏账、核销记录
     * @param $instockIds
     * @param $invoiceUuid
     * @param InvoiceRepository $invoiceRepository
     */
    public function setCreditNotes($instockIds, $invoiceUuid, InvoiceRepository $invoiceRepository);

    /**
     * 根据发票订单id数组，返回发票坏账、折让、红冲数据
     * @param $instockIds
     * @param $invoiceUuid
     * @param $invoiceRepository
     * @return mixed
     */
    public function getInvoiceOffsetInfos($instockIds, $invoiceUuid, InvoiceRepository $invoiceRepository);

    /**
     * 根据发票订单id数组，返回发票红冲记录
     * @return mixed
     */
    public function getInvoiceCreditNotes();

    /**
     * 返回发票详情里的核销数据
     * @return array|mixed
     */
    public function getInvoiceWriteOffs();

    /**
     * 返回发票详情里的坏账折让数据
     * @param $invoice
     * @return array|mixed
     */
    public function getInvoiceConcession($invoice);

    /**
     * 红冲
     * @param $invoice
     * @param $request
     * @param $receiptService
     * @return mixed
     */
    public function invoiceClear($invoice, $request, ReceiptService $receiptService);

    /**
     * 生成清账记录
     * @param $invoice
     * @param $request
     * @return mixed
     */
    public function createClearAccounts($invoice, $request, $invoiceReceipt, $type=0);

}
