<?php


namespace Modules\ERP\Service;

use Modules\ERP\Contracts\PushPaymentService as ContractsPushPaymentService;
use Modules\ERP\Contracts\PushPaymentRepository;


class PushPaymentService implements ContractsPushPaymentService
{
    protected $paymentRepository;

    public function __construct(PushPaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

}
