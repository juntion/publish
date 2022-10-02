<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyAddress as Import;
use Modules\ERP\Repositories\CountryRepository;
use Modules\UUMS\Entities\CompanyAddressInfo as Export;
use Modules\Base\Entities\Company\Company;

class CompanyAddress extends MigrateSeeder
{
    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_addresses 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        $dispatcher = Import::getEventDispatcher();
        Import::unsetEventDispatcher();
        foreach ($export as $item) {
            $data = $item->export();
            $data['company_uuid'] = Company::query()->where('id', $data['company_uuid'])->first()->uuid;
            $data['foreign_country_code'] = $data['country_code'] = app()->make(CountryRepository::class)->getCountryCodeByCountriesChineseName($data['country_name']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司地址信息数据->数据表：company_addresses，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }

        Import::setEventDispatcher($dispatcher);
        $bar->finish();
    }
}
