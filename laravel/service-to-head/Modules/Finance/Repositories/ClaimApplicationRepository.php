<?php


namespace Modules\Finance\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Finance\Contracts\ClaimApplicationRepository as ContractsClaimApplicationRepository;
use Modules\Finance\Entities\PaymentClaimApplication;
use Modules\Finance\Exceptions\ClaimException;
use Modules\Finance\Repositories\Traits\UploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;

class ClaimApplicationRepository  extends BaseRepository implements ContractsClaimApplicationRepository
{

    use UploadTrait;

    public function model()
    {
        return PaymentClaimApplication::class;
    }

    public function store(array $claim)
    {
        $receipt = $this->create($claim);
        return $receipt->refresh();
    }

    /**
     * @param  PaymentClaimApplication  $applications
     * @return PaymentClaimApplication
     * @throws ClaimException
     */
    public function createByModel(PaymentClaimApplication $applications)
    {
        if ($applications->type == 1 && (!$applications->customer_company_number || !$applications->customer_number)) {
            throw new ClaimException(__('finance::receipt.applyMustHasCustomer'));
        }
        $applications->uuid = Str::uuid()->getHex()->toString();
        $applications->save();
        $applications->refresh();
        return $applications;
    }

    public function getUnVerifyClaimByReceiptUuid(string $uuid)
    {
        return PaymentClaimApplication::query()
            ->where('receipt_uuid', $uuid)
            ->where('check_status', 0)
            ->first();
    }


    /**
     * @param  PaymentClaimApplication  $applications
     * @throws ClaimException
     */
    public function verifyByModel(PaymentClaimApplication $applications)
    {
        if (!$applications->check_status || !$applications->check_uuid || !$applications->check_name) {
            throw new ClaimException(__('finance::receipt.verifyClaimFailed'));
        }
        $applications->check_time = Carbon::now();
        $applications->save();
        $applications->refresh();
    }
}
