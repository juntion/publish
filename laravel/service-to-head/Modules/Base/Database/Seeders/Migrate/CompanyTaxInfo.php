<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyTaxInfo as Import;
use Modules\ERP\Repositories\CountryRepository;
use Modules\UUMS\Entities\CompanyTaxInfo as Export;
use Modules\Base\Entities\Company\Company;

class CompanyTaxInfo extends MigrateSeeder
{
    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_tax_info 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        $countryRepository = app()->make(CountryRepository::class);
        foreach ($export as $item) {
            $data = $item->export();
            $data['company_uuid'] = Company::query()->where('id', $data['company_id'])->first()->uuid;
            $data['country_code'] = $data['country_name'] != "" ? $countryRepository->getCountryCodeByCountriesChineseName($data['country_name'])  : "";
            unset($data['country']);
            unset($data['company_id']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司税务数据->数据表：company_tax_info，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
