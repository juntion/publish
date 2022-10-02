<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyAddressContact as Import;
use Modules\UUMS\Entities\CompanyAddressContact as Export;
use Modules\Base\Entities\Company\CompanyAddress;

class CompanyAddressContacts extends MigrateSeeder
{
    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_address_contacts 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        foreach ($export as $item) {
            $data = $item->export();
            $data['company_address_uuid'] = CompanyAddress::query()->where('id', $data['address_id'])->first()->uuid;
            unset($data['address_id']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司地址联系人数据->数据表：company_address_contacts，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }
        $bar->finish();
    }
}
