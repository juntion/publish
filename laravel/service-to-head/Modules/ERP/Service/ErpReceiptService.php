<?php


namespace Modules\ERP\Service;

use Modules\Admin\Contracts\AdminService;
use Modules\ERP\Contracts\CurrencyService;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Contracts\PushPaymentService;
use Modules\ERP\Contracts\ErpReceiptRepository;
use Modules\ERP\Contracts\ErpReceiptService as ContractsErpReceiptService;
use Modules\Finance\Contracts\PaymentReceiptsVouchersDetailRepository;

class ErpReceiptService implements ContractsErpReceiptService
{
    private const CANCELSTATUS = -1;

    protected $erpReceiptRepository;
    protected $pushPaymentService;
    protected $currencyService;
    protected $adminService;
    protected $paymentReceiptsVouchersDetailRepository;
    protected $productsInstockShippingApplyRepository;

    public function __construct(
        ErpReceiptRepository $erpReceiptRepository,
        PushPaymentService $pushPaymentService,
        CurrencyService $currencyService,
        AdminService $adminService,
        PaymentReceiptsVouchersDetailRepository $paymentReceiptsVouchersDetailRepository,
        ProductsInstockShippingApplyRepository $productsInstockShippingApplyRepository
    )
    {
        $this->erpReceiptRepository = $erpReceiptRepository;
        $this->pushPaymentService = $pushPaymentService;
        $this->currencyService = $currencyService;
        $this->adminService = $adminService;
        $this->paymentReceiptsVouchersDetailRepository = $paymentReceiptsVouchersDetailRepository;
        $this->productsInstockShippingApplyRepository = $productsInstockShippingApplyRepository;
    }

    /**
     * 退款记录
     * @param string $number
     * @return mixed
     */
    public function getRefunds(string $number)
    {
        return $this->erpReceiptRepository->getRefunds($number)->map(function ($item) {
            $item['status'] = $item['is_delete'] ? self::CANCELSTATUS : $item['status'];
            return $item;
        });
    }

    /**
     * 手续费用申请记录
     * @param string $number
     * @return mixed
     */
    public function getFees(string $number)
    {
        return $this->erpReceiptRepository->getFees($number)->map(function ($item) {
            if (is_numeric($item['currencies_id'])) {
                $item['currencies_code'] = $this->currencyService->getCurrenciesCodeByID($item['currencies_id'])['code'];
                $item['apply_name'] = $this->adminService->getAdminInfoById($item['apply_admin'])->name ?? '';
                $item['apply_amount'] = intval(round($item['apply_money'] * 100));
                $item['apply_number'] = $item['uniqueNumber']->income_number ?? '';
                $undoApplyExists = $this->productsInstockShippingApplyRepository->getShippingApplyInfo(['fs_internal_id' => $item['id'], ['is_delete', '!=', '1'], 'status' => 1])->exists ?? false;
                $item['status'] = $undoApplyExists ? self::CANCELSTATUS : $item['status'];
            }
            return $item;
        });
    }

    /**
     * 汇率浮动，币种转换单
     * @param string $number
     * @return mixed
     */
    public function getFloats(string $number)
    {
        return $this->erpReceiptRepository->getFloats($number)->map(function ($item) {
            if (is_numeric($item['currencies_id'])) {
                $item['currencies_code'] = $this->currencyService->getCurrenciesCodeByID($item['currencies_id'])['code'];
                $item['apply_name'] = $this->adminService->getAdminInfoById($item['apply_admin'])->name ?? '';
                $symbol = $item['is_yf'] == 0 ? '-' : '';
                $item['apply_amount'] = intval(round($symbol . $item['apply_money'] * 100));
                $item['apply_number'] = $item['uniqueNumber']->income_number ?? '';
                $undoApplyExists = $this->productsInstockShippingApplyRepository->getShippingApplyInfo(['fs_internal_id' => $item['id'], ['is_delete', '!=', '1'], 'status' => 1])->exists ?? false;
                $item['status'] = $undoApplyExists ? self::CANCELSTATUS : $item['status'];
            }
            return $item;
        });
    }

    /**
     * 到款的垫付申请
     * @param string $number
     * @return mixed
     */
    public function getPrepays(string $number)
    {
        $originId = $this->paymentReceiptsVouchersDetailRepository->getDetailCollectionByWhere('receipt_number', $number)->toArray() ?? [];
        $orderArr = array_column($originId, 'order_id') ?? [];
        return $this->erpReceiptRepository->getPrepays($orderArr)->map(function ($item) {
            if (is_numeric($item['currencies_id'])) {
                $item['currencies_code'] = $this->currencyService->getCurrenciesCodeByID($item['currencies_id'])['code'];
                $item['apply_name'] = $this->adminService->getAdminInfoById($item['apply_admin'])->name ?? '';
                $item['apply_amount'] = intval(round($item['apply_money'] * 100));
                $item['apply_number'] = $item['uniqueNumber']->income_number ?? '';
                $undoApplyExists = $this->productsInstockShippingApplyRepository->getShippingApplyInfo(['fs_internal_id' => $item['id'], ['is_delete', '!=', '1'], 'status' => 1])->exists ?? false;
                $item['status'] = $undoApplyExists ? self::CANCELSTATUS : $item['status'];
            }
            return $item;
        });
    }
}
