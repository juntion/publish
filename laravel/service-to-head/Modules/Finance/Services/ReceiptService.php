<?php


namespace Modules\Finance\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Admin;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\Admin\Contracts\AdminRepository;
use Modules\ERP\Support\Facades\Exchange;
use Modules\Finance\Contracts\ClaimApplicationRepository;
use Modules\Finance\Contracts\PaymentReceiptsVouchersDetailRepository;
use Modules\Finance\Contracts\ReceiptRepository;
use Modules\Finance\Contracts\ReceiptService as Service;
use Modules\Finance\Contracts\VoucherRepository;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentReceiptsToVoucher;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\Finance\Exceptions\ClaimException;
use Modules\Finance\Repositories\ReceiptsVouchersRepository;
use Symfony\Component\HttpFoundation\Response;
use Modules\Finance\Exceptions\ReceiptException;
use Modules\ERP\Contracts\PaymentMethodRepository;

class ReceiptService implements Service
{

    protected $receiptRepository;
    protected $claimApplicationRepository;
    protected $voucherRepository;
    protected $paymentReceiptsVouchersDetailRepository;
    protected $receiptsVouchersRepository;
    protected $customerCompanyRepository;

    public function __construct(
        ReceiptRepository $receiptRepository,
        ClaimApplicationRepository $claimApplicationRepository,
        VoucherRepository $voucherRepository,
        PaymentReceiptsVouchersDetailRepository $paymentReceiptsVouchersDetailRepository,
        ReceiptsVouchersRepository $receiptsVouchersRepository,
        CustomerCompanyRepository $customerCompanyRepository
    )
    {
        $this->receiptRepository = $receiptRepository;
        $this->claimApplicationRepository = $claimApplicationRepository;
        $this->voucherRepository = $voucherRepository;
        $this->paymentReceiptsVouchersDetailRepository = $paymentReceiptsVouchersDetailRepository;
        $this->receiptsVouchersRepository = $receiptsVouchersRepository;
        $this->customerCompanyRepository = $customerCompanyRepository;
    }

    /**
     * @param  PaymentReceipt  $paymentReceipt
     * @return PaymentReceipt
     * @throws ReceiptException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(PaymentReceipt $paymentReceipt)
    {
        if ($paymentReceipt->exists) return $paymentReceipt;

        if (!$paymentReceipt->transaction_serial_number || !$paymentReceipt->currency || !$paymentReceipt->amount || !$paymentReceipt->payment_method_id) {
            throw new ReceiptException(__('finance::receipt.validatorFailed'));
        }

        // 如果没有公司信息，则根据 到款方式和货币 确定收款账号和收款主体
        if (!$paymentReceipt->company_uuid && !$paymentReceipt->company_name && !$paymentReceipt->company_account_number) {
            $accountRepository = app()->make(CompanyBankAccountsRepository::class);
            $account = $accountRepository->getAccountAndCompanyInfoByMethodAndCurrency($paymentReceipt->payment_method_id, $paymentReceipt->currency);
            if (!$account || !$account->company) {
                throw new ReceiptException(__('finance::receipt.accountNotFound'));
            }
            $paymentReceipt->company_uuid = $account->company->uuid;
            $paymentReceipt->company_name = $account->company->name;
            $paymentReceipt->company_account_number = $account->account_number;
        }

        // 冗余付款方式名称
        if (!$paymentReceipt->payment_method_name) {
            $paymentMethodRepository = app()->make(PaymentMethodRepository::class);
            $paymentMethod = $paymentMethodRepository->getPaymentMethodById($paymentReceipt->payment_method_id);
            if (!$paymentMethod) {
                throw new ReceiptException(__('finance::receipt.invalidPaymentMethod'));
            }
            $paymentReceipt->payment_method_name = $paymentMethod->payment_method;
        }

        // 2 自动导入, 创建人为root
        if ($paymentReceipt->create_from && $paymentReceipt->create_from == 2) {
            $adminRepository = app()->make(AdminRepository::class);
            $admin = $adminRepository->getAdminByName(config('app.root'));
            $paymentReceipt->creator_uuid = $admin->uuid;
            $paymentReceipt->creator_name = $admin->name;
        }

        return $this->receiptRepository->createByModel($paymentReceipt);
    }

    /**
     * @param  PaymentReceipt  $paymentReceipt
     * @param  Admin  $admin
     * @param  PaymentClaimApplication  $application
     * @param  array  $file
     * @param  int  $claimType 认领类型 0 手动 1自动
     * @return PaymentClaimApplication
     * @throws ClaimException
     */
    public function claimApplication(PaymentReceipt $paymentReceipt, Admin $admin, PaymentClaimApplication $application, array $file = [], $claimType = 0)
    {
        $application->receipt_uuid = $paymentReceipt->uuid;
        $application->apply_uuid = $admin->uuid;
        $application->apply_name = $admin->name;
        if (!$application->apply_type) {
            $application->apply_type = 1;
        }
        $application->check_status = 0;
        if ($application->apply_type == 1 && !$application->customer_number ) {
            throw new ClaimException(__('finance::receipt.applyMustHasCustomer'));
        }

        if ($application->apply_type == 1 && !$application->customer_company_number) {
            $customer_company = $this->customerCompanyRepository->getCompanyByCustomerNumber($application->customer_number);
            if (!$customer_company) {
                throw new ClaimException(__("finance::receipt.customerNumberError"));
            }
            $application->customer_company_number = $customer_company->company_number;
        }
        $application = $this->claimApplicationRepository->createByModel($application);
        $this->claimApplicationRepository->addMedia($application, $file, 'receipt/', 1);

        $paymentReceipt->update([
            'claim_status' => 1,
            'claim_type'   => $claimType,
            'claim_time'   => Carbon::now(),
            'application_uuid' => $application->uuid
        ]);
        return $application;
    }

    /**
     * @param  PaymentClaimApplication  $application
     * @param  Admin  $admin
     * @param  PaymentReceipt  $paymentReceipt
     * @param  bool  $verify
     * @param  array  $file
     * @return PaymentClaimApplication|void
     */
    public function verifyApplication(PaymentClaimApplication $application, Admin $admin, PaymentReceipt $paymentReceipt, bool $verify, array $file = [])
    {
        $application->check_uuid = $admin->uuid;
        $application->check_name = $admin->name;
        $application->check_time = Carbon::now();
        $application->check_status = $verify ? 1 : 2;

        $this->claimApplicationRepository->verifyByModel($application);
        $this->claimApplicationRepository->addMedia($application, $file, 'receipt/', 2);

        if ($verify && $application->apply_type == 1) {
            $customer_company = $this->customerCompanyRepository->getCompanyByCustomerNumber($application->customer_number);
            $paymentReceipt->update([
                'claim_status' => 2,
                'claim_uuid' => $application->apply_uuid,
                'claim_name' => $application->apply_name,
                'customer_number' => $application->customer_number,
                'customer_company_name' => $customer_company->customerOfCompany->customers_company,
                'customer_company_number' => $customer_company->company_number,
            ]);
        } else if (!$verify && $application->apply_type == 1) {
            $this->receiptRepository->resetStatus2Unclaimed($paymentReceipt);
        } else if ($verify && $application->apply_type == 2) {
            $this->receiptRepository->resetStatus2Unclaimed($paymentReceipt);
        } else if (!$verify && $application->apply_type == 2) {
            $this->receiptRepository->resetStatus2Claimed($paymentReceipt);
        }
    }


    /**
     * @param  PaymentReceipt  $paymentReceipt
     * @param  Admin  $admin
     * @param  PaymentVoucher  $paymentVoucher
     * @param  int  $insertType
     * @return mixed
     * @throws ReceiptException
     */
    public function paymentReceiptExpend(PaymentReceipt $paymentReceipt, Admin $admin, PaymentVoucher $paymentVoucher, $insertType = 1)
    {
        if (!$paymentVoucher->order_number || !$paymentVoucher->currency || !$paymentVoucher->usable || is_null($paymentVoucher->used)) {
            throw new ReceiptException(__('finance::receipt.voucherDataError'));
        }

        if ($insertType == 1 && !$paymentVoucher->customer_number) {
            throw new ReceiptException(__('finance::receipt.voucherDataError'));
        }

        if (!$paymentVoucher->type) {
            $paymentVoucher->type = 1;
        }

        if ((!$paymentVoucher->customer_company_name || !$paymentVoucher->customer_company_number) && $insertType == 1) {

            $orderCustomerCompany = $this->customerCompanyRepository->getCompanyByCustomerNumber($paymentVoucher->customer_number);

            if(is_null($orderCustomerCompany)) {
                throw new ReceiptException(__('finance::receipt.customerNumberError'));
            }

            $paymentVoucher->customer_company_number = $orderCustomerCompany ? $orderCustomerCompany->company_number :"";
            $paymentVoucher->customer_company_name   = $orderCustomerCompany->customerOfCompany->customers_company;
        }

        $paymentVoucher->creator_uuid = $admin->uuid;
        $paymentVoucher->creator_name = $admin->name;

        $paymentVoucher = $this->voucherRepository->createByModel($paymentVoucher);

        $receiptUse = $paymentVoucher->used;
        if ($paymentReceipt->currency != $paymentVoucher->currency) {
            $receiptUse = Exchange::exchange($paymentReceipt->created_at, $paymentVoucher->currency, $receiptUse , $paymentReceipt->currency);
        }

        $this->receiptRepository->useAmount($paymentReceipt, $receiptUse);
        $relateData = [
            'receipt_uuid'     => $paymentReceipt->uuid,
            'receipt_number'   => $paymentReceipt->number,
            'receipt_currency' => $paymentReceipt->currency,
            'voucher_currency' => $paymentVoucher->currency,
            'voucher_use'      => $paymentVoucher->used,
            'receipt_use'      => $receiptUse,
            'voucher_number'   => $paymentVoucher->number,
            'created_at'       => Carbon::now()
        ];
        return $this->voucherRepository->relateReceipt($paymentVoucher, $relateData);
    }


    /**
     * @param  PaymentReceiptsVouchersDetail  $paymentReceiptsVouchersDetail
     * @param  PaymentReceiptsToVoucher  $paymentReceiptsToVoucher
     * @throws ReceiptException
     */
    public function storeReceiptVoucherDetail( PaymentReceiptsVouchersDetail $paymentReceiptsVouchersDetail, PaymentReceiptsToVoucher $paymentReceiptsToVoucher)
    {
        if (!$paymentReceiptsVouchersDetail->order_number || !$paymentReceiptsVouchersDetail->order_id) {
            throw new ReceiptException(__('finance::receipt.detailOrderDataError'));
        }

        $paymentReceiptsVouchersDetail->receipt_uuid = $paymentReceiptsToVoucher->receipt_uuid;
        $paymentReceiptsVouchersDetail->receipt_number = $paymentReceiptsToVoucher->receipt_number;
        $paymentReceiptsVouchersDetail->receipt_currency = $paymentReceiptsToVoucher->receipt_currency;
        $paymentReceiptsVouchersDetail->receipt_use = $paymentReceiptsToVoucher->receipt_use;
        $paymentReceiptsVouchersDetail->voucher_uuid = $paymentReceiptsToVoucher->voucher_uuid;
        $paymentReceiptsVouchersDetail->voucher_number = $paymentReceiptsToVoucher->voucher_number;
        $paymentReceiptsVouchersDetail->voucher_currency = $paymentReceiptsToVoucher->voucher_currency;
        $paymentReceiptsVouchersDetail->voucher_use = $paymentReceiptsToVoucher->voucher_use;

        $this->paymentReceiptsVouchersDetailRepository->creatByModel($paymentReceiptsVouchersDetail);
    }


    /**
     * @param  array $claim
     * @param  array $file
     * @param  array $receipt
     * @return mixed
     * @throws ClaimException
     */
    public function storeClaim(array $claim, array $file, array $receipt)
    {
        DB::beginTransaction();
        try {
            $claimApplication = $this->claimApplicationRepository->store($claim);
            $this->claimApplicationRepository->addMedia($claimApplication, $file, 'receipt/', 1);
            $this->receiptRepository->update($receipt, $claimApplication->receipt_uuid);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ClaimException(__('finance::receipt.storeFailed'), Response::HTTP_BAD_REQUEST, $exception);
        }
        return true;
    }

    /**
     * 删除申请
     * @param  string $uuid
     * @throws ClaimException
     */
    public function deleteClaim(string $uuid, Authenticatable $user)
    {
        $claim = $this->claimApplicationRepository->find($uuid);
        $receipt = $this->receiptRepository->find($claim->receipt_uuid);

        if ($receipt->claim_status != 1 || $claim->apply_uuid != $user->uuid) {
            throw new ClaimException(__('finance::receipt.notAllowDelete'));
        }

        DB::beginTransaction();
        try {
            if ($claim->apply_type == 1) {
                $this->receiptRepository->resetStatus2Unclaimed($receipt);
            } else {
                $this->receiptRepository->resetStatus2Claimed($receipt);
            }
            $this->claimApplicationRepository->deleteMedia($claim);
            $claim->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ClaimException(__('finance::receipt.deleteClaimFailed'), Response::HTTP_BAD_REQUEST, $exception);
        }
    }

    /**
     * @param  string $uuid
     * @param  array $claimData
     * @param  array $files
     * @param  bool $verify
     * @throws ClaimException
     */
    public function verifyClaim(string $uuid, array $claimData, array $files, bool $verify)
    {
        $claim = $this->claimApplicationRepository->find($uuid);
        $receipt = $this->receiptRepository->find($claim->receipt_uuid);
        if ($claim->check_status != 0 || $receipt->claim_status != 1) {
            throw new ClaimException(__('finance::receipt.notAllowVerify'));
        }
        DB::beginTransaction();
        try {
            $claim->update($claimData);
            $this->claimApplicationRepository->addMedia($claim, $files, 'receipt/', 2);
            if ($verify && $claim->apply_type == 1) {
                $customer_company = $this->customerCompanyRepository->getCompanyByCustomerNumber($claim->customer_number);
                $claim['customer_company_number'] = $customer_company->company_number;
                $receipt->update([
                    'claim_status' => 2,
                    'claim_uuid' => $claim->apply_uuid,
                    'claim_name' => $claim->apply_name,
                    'customer_number' => $claim->customer_number,
                    'customer_company_name' => $customer_company->customerOfCompany->customers_company,
                    'customer_company_number' => $customer_company->company_number,
                ]);
            } else if (!$verify && $claim->apply_type == 1) {
                $this->receiptRepository->resetStatus2Unclaimed($receipt);
            } else if ($verify && $claim->apply_type == 2) {
                $this->receiptRepository->resetStatus2Unclaimed($receipt);
            } else if (!$verify && $claim->apply_type == 2) {
                $this->receiptRepository->resetStatus2Claimed($receipt);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ClaimException(__('finance::receipt.verifyFailed'), Response::HTTP_BAD_REQUEST, $exception);
        }
    }

    public function clearReceiptVoucherAndDetail(string $receiptUuid, string $voucherNumber, string $orderNumber, int $receiptUse, int $voucherUse)
    {
        $this->receiptRepository->updateUsedAndClearByUuid($receiptUuid, $receiptUse);

        $this->voucherRepository->updateUsedByNumber($voucherNumber, $voucherUse);

        $this->receiptsVouchersRepository->updateUseByReceiptUuidAnyVoucherNumber($receiptUuid, $voucherNumber, $receiptUse, $voucherUse);

        $this->paymentReceiptsVouchersDetailRepository->updateUseByUuidNumberAndOrderNumber($receiptUuid, $voucherNumber, $orderNumber, $receiptUse, $voucherUse);
    }

    /**
     * 银行流水号验证到款是否存在
     * @param string $transaction_serial_number
     * @return bool
     */
    public function verifyRepeatTransaction(string $transaction_serial_number)
    {
        return $this->receiptRepository->getReceiptByTransaction($transaction_serial_number)->exists ?? false;
    }

}
