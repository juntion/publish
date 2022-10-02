<?php

namespace Modules\Finance\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Finance\Contracts\ClaimApplicationRepository;
use Modules\Finance\Contracts\PaymentClaimFilesRepository;
use Modules\Finance\Contracts\PaymentReceiptsVouchersDetailRepository;
use Modules\Finance\Contracts\ReceiptRepository as ContractsReceiptRepository;
use Modules\Finance\Contracts\ReceiptsVouchersRepository;
use Modules\Finance\Repositories\ReceiptRepository;
use Modules\Finance\Contracts\VoucherRepository as ContractsVoucherRepository;
use Modules\Finance\Repositories\VoucherRepository;
use Modules\Finance\Contracts\InvoiceRepository as ContractsInvoiceRepository;
use Modules\Finance\Repositories\InvoiceRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ContractsReceiptRepository::class => ReceiptRepository::class,
        ContractsVoucherRepository::class => VoucherRepository::class,
        ContractsInvoiceRepository::class => InvoiceRepository::class,
        ClaimApplicationRepository::class => \Modules\Finance\Repositories\ClaimApplicationRepository::class,
        PaymentClaimFilesRepository::class => \Modules\Finance\Repositories\PaymentClaimFilesRepository::class,
        ReceiptsVouchersRepository::class => \Modules\Finance\Repositories\ReceiptsVouchersRepository::class,
        PaymentReceiptsVouchersDetailRepository::class => \Modules\Finance\Repositories\PaymentReceiptsVouchersDetailRepository::class,
    ];

    public function provides()
    {
        return [
            ContractsReceiptRepository::class,
            ContractsVoucherRepository::class,
            ContractsInvoiceRepository::class,
            ClaimApplicationRepository::class,
            PaymentClaimFilesRepository::class,
            ReceiptsVouchersRepository::class,
            PaymentReceiptsVouchersDetailRepository::class,
        ];
    }
}
