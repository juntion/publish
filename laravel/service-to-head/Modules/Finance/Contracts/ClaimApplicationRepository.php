<?php


namespace Modules\Finance\Contracts;

use Modules\Finance\Entities\PaymentClaimApplication;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ClaimApplicationRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function store(array $claim);

    public function createByModel(PaymentClaimApplication $applications);
    
    public function verifyByModel(PaymentClaimApplication $applications);
}
