<?php


namespace Modules\ERP\Service;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Contracts\AdminRepository;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\ProductsInstockShippingApplyService as ContractsShippingApplyService;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Contracts\ShippingUniqueRepository;
use Modules\ERP\Contracts\ShippingUniqueService;
use Modules\ERP\Entities\ProductsInstockShippingApply;
use Modules\ERP\Entities\ProductsInstockShippingApplyUniqueNumber;
use Modules\Finance\Contracts\ReceiptRepository;
use Modules\Finance\Entities\PaymentReceipt;


class ProductsInstockShippingApplyService implements ContractsShippingApplyService
{
    const APPLY_TYPE_FUNDS = 3;//款项申请
    const VERIFY_STATUS_SUCCESS = 1;//审核成功

    protected $shippingApplyRepository;
    protected $receiptRepository;
    protected $shippingUniqueRepository;
    protected $shippingUniqueService;

    public function __construct
    (ProductsInstockShippingApplyRepository $productsInstockShippingApplyRepository,
     ReceiptRepository $receiptRepository,
     ShippingUniqueRepository $shippingUniqueRepository,
     ShippingUniqueService $shippingUniqueService)
    {
        $this->shippingApplyRepository = $productsInstockShippingApplyRepository;
        $this->receiptRepository = $receiptRepository;
        $this->shippingUniqueRepository = $shippingUniqueRepository;
        $this->shippingUniqueService = $shippingUniqueService;
    }

    /**
     * @param PaymentReceipt $paymentReceipt
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createFloatApplyByReceipt(PaymentReceipt $paymentReceipt)
    {
        $res = ['status' => false, 'msg' => '', 'apply_id' => ''];
        if (!is_null($paymentReceipt)) {
            $validator = Validator::make($paymentReceipt->toArray(), [
                'number' => 'required',
                'customer_number' => 'required',
                'customer_company_number' => 'required',
                'claim_uuid' => 'required',
                'currency' => 'required',
                'amount' => 'required'
            ]);
            if ($validator->fails()) {
                $res['msg'] = $validator->errors()->all();
                return $res;
            }
            $admin_info = app()->make(AdminRepository::class)->getAdminByUuid($paymentReceipt->claim_uuid)->first();
            DB::beginTransaction();
            try {
                $shippingApply = new ProductsInstockShippingApply;
                $shippingApply->customer_grade = app()->make(CustomerRepository::class)->getCustomerByNumber($paymentReceipt->customer_number)->customers_level;//客户等级
                $shippingApply->apply_type = self::APPLY_TYPE_FUNDS;
                $shippingApply->apply_time = Carbon::now('Asia/shanghai');
                $shippingApply->apply_remarks = '汇兑损益自动申请';
                $shippingApply->apply_admin = $admin_info['id'];//申请人
                $shippingApply->verify_time = Carbon::now('Asia/shanghai');
                $shippingApply->verify_remarks = '自动审核通过';
                $shippingApply->verify_admin = '1';
                $shippingApply->status = self::VERIFY_STATUS_SUCCESS;
                $shippingApply->is_advance = '22';
                $shippingApply->is_fillmoney = '0';
                $shippingApply->fillmoney_type = '5';
                $shippingApply->apply_money = round(intval($paymentReceipt->usable - $paymentReceipt->use) / 100, 2);
                $shippingApply->apply_moneys = round(intval($paymentReceipt->amount) / 100, 2);
                $shippingApply->DK_number = $paymentReceipt->number;
                $shippingApply->company_number = $paymentReceipt->customer_company_number;
                $shippingApply->currencies_id = app()->make(CurrencyRepository::class)->getCurrenciesIdByCode($paymentReceipt->currency)['currencies_id'];//币种ID
                $res['status'] = true;
                $res['apply'] = $this->shippingApplyRepository->store($shippingApply);

                $shippingUnique = new ProductsInstockShippingApplyUniqueNumber;
                $shippingUnique->income_number = $this->shippingUniqueService->factory();
                $shippingUnique->related_id = $res['apply']->id;
                $shippingUnique->create_at = Carbon::now('Asia/Shanghai');
                $this->shippingUniqueRepository->store($shippingUnique);

                $this->receiptRepository->updateFloat($paymentReceipt, '-' . $shippingApply->apply_money);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                $res['status'] = false;
                $res['msg'] = $exception->getMessage();
            }

        }
        return $res;
    }
}
