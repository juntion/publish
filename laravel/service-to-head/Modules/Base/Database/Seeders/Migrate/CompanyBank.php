<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyBank as Import;
use Modules\UUMS\Entities\CompanyPay as Export;
use Modules\Base\Entities\Company\Company;

class CompanyBank extends MigrateSeeder
{
    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_banks 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        $dispatcher = Import::getEventDispatcher();
        Import::unsetEventDispatcher();
        foreach ($export as $item) {
            $data = $item->export();
            $data['company_uuid'] = Company::query()->where('id', $data['company_id'])->first()->uuid;
            unset($data['company_id']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司银行数据->数据表：company_banks，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }
        Import::setEventDispatcher($dispatcher);
        $bar->finish();
    }
}
