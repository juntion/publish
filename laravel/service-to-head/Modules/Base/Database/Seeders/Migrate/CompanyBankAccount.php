<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyBankAccount as Import;
use Modules\UUMS\Entities\CompanyPayAccountInfo as Export;
use Modules\Base\Entities\Company\CompanyBank;

class CompanyBankAccount extends MigrateSeeder
{
    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_banks_accout 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        foreach ($export as $item) {
            $data = $item->export();
            $data['company_bank_uuid'] = CompanyBank::query()->where('id', $data['pay_id'])->first()->uuid;
            // $data['payment_method_id'] = 0;
            $data['payment_method_name'] = "";
            unset($data['pay_id']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司银行账户数据->数据表：company_banks_accout，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
