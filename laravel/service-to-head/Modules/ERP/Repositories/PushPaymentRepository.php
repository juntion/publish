<?php

namespace Modules\ERP\Repositories;

use Modules\ERP\Contracts\PushPaymentRepository as ContractsPushPaymentRepository;
use Modules\ERP\Entities\PushPayment;
use Prettus\Repository\Eloquent\BaseRepository;

class PushPaymentRepository extends BaseRepository implements ContractsPushPaymentRepository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return PushPayment::class;
    }

}
