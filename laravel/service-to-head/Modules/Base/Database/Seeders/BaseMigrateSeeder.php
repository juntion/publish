<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Base\Database\Seeders\Migrate\Company;
use Modules\Base\Database\Seeders\Migrate\CompanyAddress;
use Modules\Base\Database\Seeders\Migrate\CompanyAddressContacts;
use Modules\Base\Database\Seeders\Migrate\CompanyBank;
use Modules\Base\Database\Seeders\Migrate\CompanyBankAccount;
use Modules\Base\Database\Seeders\Migrate\CompanyMedia;
use Modules\Base\Database\Seeders\Migrate\CompanyStatusLog;
use Modules\Base\Database\Seeders\Migrate\CompanyTaxInfo;

class BaseMigrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Company::class);
        $this->call(CompanyAddress::class);
        $this->call(CompanyAddressContacts::class);
        $this->call(CompanyBank::class);
        $this->call(CompanyBankAccount::class);
        $this->call(CompanyTaxInfo::class);
        $this->call(CompanyStatusLog::class);
        $this->call(CompanyMedia::class);
    }
}
