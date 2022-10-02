<?php


namespace Modules\Finance\Repositories;

use Modules\Finance\Contracts\PaymentClaimFilesRepository as ContractsPaymentClaimFilesRepository;
use Modules\Finance\Entities\PaymentClaimApplyFile;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentClaimFilesRepository extends BaseRepository implements ContractsPaymentClaimFilesRepository
{
    public function model()
    {
        return PaymentClaimApplyFile::class;
    }
}
