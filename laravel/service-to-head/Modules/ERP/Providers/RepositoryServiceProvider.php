<?php

namespace Modules\ERP\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\ERP\Contracts\AdminGroupRepository;
use Modules\ERP\Contracts\AdminRepository;
use Modules\ERP\Contracts\AdminSalesAssistantRepository;
use Modules\ERP\Contracts\CategoryRepository;
use Modules\ERP\Contracts\CountryRepository;
use Modules\ERP\Contracts\CurrencyRepository;
use Modules\ERP\Contracts\CustomerCompanyRepository;
use Modules\ERP\Contracts\CustomerRepository;
use Modules\ERP\Contracts\ErpReceiptRepository;
use Modules\ERP\Contracts\FinanceCurrencyRepository;
use Modules\ERP\Contracts\FsShippingReduceOrderRepository;
use Modules\ERP\Contracts\InstockShippingRepository;
use Modules\ERP\Contracts\NsExpenseVoucherRecordRepository;
use Modules\ERP\Contracts\OrderPIRepository;
use Modules\ERP\Contracts\OrderProductRepository;
use Modules\ERP\Contracts\OrderRepository;
use Modules\ERP\Contracts\OrdersInputNotesRepository;
use Modules\ERP\Contracts\OrderTotalRepository;
use Modules\ERP\Contracts\PaymentMethodRepository;
use Modules\ERP\Contracts\PaymentRelateOrdersRepository;
use Modules\ERP\Contracts\ProductRepository;
use Modules\ERP\Contracts\ProductsInstockShippingApplyRepository;
use Modules\ERP\Contracts\ProductsInstockShippingInfoRepository;
use Modules\ERP\Contracts\ProductsInstockShippingRefundTaxRepository;
use Modules\ERP\Contracts\ProductsInstockShippingSalesAfterRepository;
use Modules\ERP\Contracts\ProductsInstockShippingService;
use Modules\ERP\Contracts\PushPaymentRepository;
use Modules\ERP\Contracts\RechnungInvoiceRepository;
use Modules\ERP\Contracts\ShippingUniqueRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings
        = [
            ProductRepository::class                           => \Modules\ERP\Repositories\ProductRepository::class,
            CategoryRepository::class                          => \Modules\ERP\Repositories\CategoryRepository::class,
            CountryRepository::class                           => \Modules\ERP\Repositories\CountryRepository::class,
            CurrencyRepository::class                          => \Modules\ERP\Repositories\CurrencyRepository::class,
            PaymentMethodRepository::class                     => \Modules\ERP\Repositories\PaymentMethodRepository::class,
            AdminGroupRepository::class                        => \Modules\ERP\Repositories\AdminGroupRepository::class,
            ErpReceiptRepository::class                        => \Modules\ERP\Repositories\ErpReceiptRepository::class,
            CustomerRepository::class                          => \Modules\ERP\Repositories\CustomerRepository::class,
            CustomerCompanyRepository::class                   => \Modules\ERP\Repositories\CustomerCompanyRepository::class,
            OrderRepository::class                             => \Modules\ERP\Repositories\OrderRepository::class,
            OrderPIRepository::class                           => \Modules\ERP\Repositories\OrderPIRepository::class,
            InstockShippingRepository::class                   => \Modules\ERP\Repositories\InstockShippingRepository::class,
            FinanceCurrencyRepository::class                   => \Modules\ERP\Repositories\FinanceCurrencyRepository::class,
            PushPaymentRepository::class                       => \Modules\ERP\Repositories\PushPaymentRepository::class,
            ProductsInstockShippingInfoRepository::class       => \Modules\ERP\Repositories\ProductsInstockShippingInfoRepository::class,
            FsShippingReduceOrderRepository::class             => \Modules\ERP\Repositories\FsShippingReduceOrderRepository::class,
            NsExpenseVoucherRecordRepository::class            => \Modules\ERP\Repositories\NsExpenseVoucherRecordRepository::class,
            OrderTotalRepository::class                        => \Modules\ERP\Repositories\OrderTotalRepository::class,
            ProductsInstockShippingApplyRepository::class      => \Modules\ERP\Repositories\ProductsInstockShippingApplyRepository::class,
            OrderProductRepository::class                      => \Modules\ERP\Repositories\OrderProductRepository::class,
            ProductsInstockShippingRefundTaxRepository::class  => \Modules\ERP\Repositories\ProductsInstockShippingRefundTaxRepository::class,
            ProductsInstockShippingSalesAfterRepository::class => \Modules\ERP\Repositories\ProductsInstockShippingSalesAfterRepository::class,
            AdminRepository::class                             => \Modules\ERP\Repositories\AdminRepository::class,
            AdminSalesAssistantRepository::class               => \Modules\ERP\Repositories\AdminSalesAssistantRepository::class,
            RechnungInvoiceRepository::class                   => \Modules\ERP\Repositories\RechnungInvoiceRepository::class,
            PaymentRelateOrdersRepository::class               => \Modules\ERP\Repositories\PaymentRelateOrdersRepository::class,
            OrdersInputNotesRepository::class                  => \Modules\ERP\Repositories\OrdersInputNotesRepository::class,
            ShippingUniqueRepository::class                    => \Modules\ERP\Repositories\ShippingUniqueRepository::class,
            ProductsInstockShippingService::class              => \Modules\ERP\Service\ProductsInstockShippingService::class,
        ];

    public function provides()
    {
        return [
            ProductRepository::class,
            CategoryRepository::class,
            CountryRepository::class,
            CurrencyRepository::class,
            PaymentMethodRepository::class,
            AdminGroupRepository::class,
            ErpReceiptRepository::class,
            CustomerRepository::class,
            CustomerCompanyRepository::class,
            OrderRepository::class,
            OrderPIRepository::class,
            InstockShippingRepository::class,
            FinanceCurrencyRepository::class,
            PushPaymentRepository::class,
            ProductsInstockShippingInfoRepository::class,
            FsShippingReduceOrderRepository::class,
            NsExpenseVoucherRecordRepository::class,
            OrderTotalRepository::class,
            ProductsInstockShippingApplyRepository::class,
            OrderProductRepository::class,
            ProductsInstockShippingRefundTaxRepository::class,
            ProductsInstockShippingSalesAfterRepository::class,
            AdminRepository::class,
            AdminSalesAssistantRepository::class,
            RechnungInvoiceRepository::class,
            ProductsInstockShippingService::class,
            PaymentRelateOrdersRepository::class,
            OrdersInputNotesRepository::class,
        ];
    }
}
