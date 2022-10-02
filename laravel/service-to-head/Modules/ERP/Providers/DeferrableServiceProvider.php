<?php

namespace Modules\ERP\Providers;


use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\ERP\Contracts\AdminGroupService;
use Modules\ERP\Contracts\CountryService;
use Modules\ERP\Contracts\CurrencyService;
use Modules\ERP\Contracts\PaymentMethodService;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\ERP\Contracts\FinanceExchangeRateService as ContractsFinanceExchangeRateService;
use Modules\ERP\Contracts\OrderService as ContractsOrderService;
use Modules\ERP\Contracts\PaymentRelateOrdersService;
use Modules\ERP\Contracts\PushPaymentService as ContractsPushPaymentService;
use Modules\ERP\Contracts\ErpReceiptService as ContractsErpReceiptService;
use Modules\ERP\Contracts\AdminSalesAssistantService;
use Modules\ERP\Contracts\ProductsInstockShippingApplyService as ContractsShippingApplyService;
use Modules\ERP\Contracts\ShippingUniqueService;
use Modules\ERP\Service\OrderService;
use Modules\ERP\Service\PaymentMethodService as PaymentMethodListService;
use Modules\ERP\Service\CountrySearchService;
use Modules\ERP\Service\CurrencyListService;
use Modules\ERP\Service\FinanceExchangeRateService;
use Modules\ERP\Service\OrderCustomerCompanyService as OrderCustomerCompanyListService;
use Modules\ERP\Service\PushPaymentService;
use Modules\ERP\Service\ErpReceiptService;
use Modules\ERP\Service\AdminSalesAssistantService as AdminSalesAssistantListService;
use Modules\ERP\Service\ProductsInstockShippingApplyService;

class DeferrableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $singletons = [
        CountryService::class       => CountrySearchService::class,
        CurrencyService::class      => CurrencyListService::class,
        PaymentMethodService::class => PaymentMethodListService::class,
        AdminGroupService::class    => \Modules\ERP\Service\AdminGroupService::class,
        OrderCustomerCompanyService::class => OrderCustomerCompanyListService::class,
        ContractsFinanceExchangeRateService::class => FinanceExchangeRateService::class,
        ContractsOrderService::class => OrderService::class,
        ContractsPushPaymentService::class => PushPaymentService::class,
        ContractsErpReceiptService::class => ErpReceiptService::class,
        AdminSalesAssistantService::class => AdminSalesAssistantListService::class,
        ContractsShippingApplyService::class => ProductsInstockShippingApplyService::class,
        PaymentRelateOrdersService::class => \Modules\ERP\Service\PaymentRelateOrdersService::class,
        ShippingUniqueService::class =>\Modules\ERP\Service\ShippingUniqueService::class,
    ];

    public function provides()
    {
        return [
            CountryService::class,
            CurrencyService::class,
            PaymentMethodService::class,
            AdminGroupService::class,
            OrderCustomerCompanyService::class,
            ContractsFinanceExchangeRateService::class,
            ContractsOrderService::class,
            ContractsPushPaymentService::class,
            ContractsErpReceiptService::class,
            AdminSalesAssistantService::class,
            ContractsShippingApplyService::class,
            PaymentRelateOrdersService::class,
            ShippingUniqueService::class,
        ];
    }
}
