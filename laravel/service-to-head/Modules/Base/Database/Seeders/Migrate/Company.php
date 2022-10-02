<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\Company as Import;
use Modules\ERP\Repositories\CountryRepository;
use Modules\UUMS\Entities\Company as Export;

class Company extends MigrateSeeder
{

    protected $waitMigrate = [];
    protected $countryRepository;
    protected $bar;

    public function run(){
        $export = Export::query()->orderBy('type','ASC')->orderBy('id', 'ASC')->orderBy('p_id', "ASC")->get();
        $this->command->info('开始迁移 uums 系统 companies 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $this->bar = $bar;
        $this->bar->start();
        $countryRepository = app()->make(CountryRepository::class);
        $this->countryRepository = $countryRepository;
        // 暂时关闭 监听status
        $dispatcher = Import::getEventDispatcher();
        Import::unsetEventDispatcher();
        foreach ($export as $item) {
            $data = $item->export();
            if ($data['p_id']){
                $parent = Import::query()->where('id', $data['p_id'])->first();
                if (is_null($parent)){
                    $this->waitMigrate[] = $item;
                    continue;
                }
                $data['parent_uuid'] = $parent->uuid;
                $data['one_level_uuid'] = $parent->one_level_uuid;
                if ($data['type'] == 2) {
                    $data['two_level_uuid'] = $data['uuid'];
                } else {
                    $data['two_level_uuid'] = $parent->two_level_uuid;
                }
            } else {
                $data['one_level_uuid'] = $data['uuid'];
            }
            unset($data['p_id']);
            $data['country_code'] = $data['country_name'] != "" ? $countryRepository->getCountryCodeByCountriesName($data['country_name']) : "";
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司数据->数据表：companies，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $this->bar->advance();
        }
        if (!empty($this->waitMigrate)){
            $this->migrateData();
        }
        Import::setEventDispatcher($dispatcher);
        $this->bar->finish();
    }

    // 递归处理未迁移的数据
    protected function migrateData()
    {
        $waitMigrate  = $this->waitMigrate;
        $toWaitMigrate = [];
        foreach ($waitMigrate as $item) {
            $data = $item->export();
            if ($data['p_id']){
                $parent = Import::query()->where('id', $data['p_id'])->first();
                if (is_null($parent)){
                    $toWaitMigrate[] = $item;
                    continue;
                }
                $data['parent_uuid'] = $parent->uuid;
                $data['one_level_uuid'] = $parent->one_level_uuid;
                if ($data['type'] == 2) {
                    $data['two_level_uuid'] = $data['uuid'];
                } else {
                    $data['two_level_uuid'] = $parent->two_level_uuid;
                }
            } else {
                $data['one_level_uuid'] = $data['uuid'];
            }
            unset($data['p_id']);
            $data['country_code'] = $data['country_name'] != "" ? $this->countryRepository->getCountryCodeByCountriesName($data['country_name']) : "";
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $data['id']],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司数据->数据表：companies，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }
            $this->bar->advance();
        }
        if (!empty($toWaitMigrate)){
            $this->waitMigrate = $toWaitMigrate;
            $this->migrateData();
        }
        return true;
    }
}
