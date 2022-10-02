<?php


namespace Modules\Base\Providers;


use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\Base\Contracts\Company\MediaRepository;
use Modules\Base\Repositories\Company\CompanyRepository;
use Modules\Base\Contracts\Company\CompanyRepository as ContractsCompanyRepository;
use Modules\Base\Contracts\Company\AddressRepository as ContractsAddressRepository;
use Modules\Base\Repositories\Company\AddressRepository;
use Modules\Base\Contracts\Company\BankRepository as ContractsBankRepository;
use Modules\Base\Repositories\Company\BankRepository;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public $bindings = [
        ContractsCompanyRepository::class => CompanyRepository::class,
        ContractsAddressRepository::class => AddressRepository::class,
        ContractsBankRepository::class => BankRepository::class,
        MediaRepository::class => \Modules\Base\Repositories\Company\MediaRepository::class,
        CompanyBankAccountsRepository::class => \Modules\Base\Repositories\Company\CompanyBankAccountsRepository::class
    ];

    public function provides()
    {
        return [
            ContractsCompanyRepository::class,
            ContractsAddressRepository::class,
            ContractsBankRepository::class,
            MediaRepository::class,
            CompanyBankAccountsRepository::class,
        ];
    }
}
