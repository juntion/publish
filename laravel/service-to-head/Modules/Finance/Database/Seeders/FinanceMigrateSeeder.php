<?php

namespace Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FinanceMigrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Migrate\PaymentReceiptsSeeder::class);
        $this->call(Migrate\PaymentClaimApplications::class);
        $this->call(Migrate\PaymentVouchers::class);
        $this->call(Migrate\PaymentReceiptsToVouchers::class);
        $this->call(Migrate\PaymentReceiptsVouchersDetails::class);
        $this->call(Migrate\Invoices::class);
    }
}
