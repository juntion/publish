<?php

namespace Modules\Admin\Database\Seeders\Migrate;

use Illuminate\Database\QueryException;
use Modules\Base\Database\Seeders\MigrateSeeder as Seeder;
use Modules\UUMS\Entities\Admin as Export;
use Modules\Admin\Entities\Admin as Import;

class UUMSAdminIncrement extends Seeder
{
    public function run()
    {
        $lastAdmin = Import::query()->max('id');
        $export = Export::query()->where('origin_id', '>', $lastAdmin)->get();
        if (!sizeof($export)) {
            $this->command->info('uums users 表暂无增量数据');
            return;
        }
        
        $this->command->info('开始迁移 uums users 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        
        foreach ($export as $item) {
            $this->migrate($item);
            $bar->advance();
        }
        
        $bar->finish();
    }
    
    private function migrate(&$item)
    {
        try {
            $UUMSAdmin = $item->export();
            $admin = Import::modelUpdateOrCreate(
                ['uuid' => $UUMSAdmin['uuid']],
                $UUMSAdmin
            );
        } catch (\Exception $e) {
            if ($e instanceof QueryException && $e->getCode() == 23000 && strpos($e->getMessage(), 'admins_email_unique') !== false) {
                $item->email = null;
                $this->migrate($item);
                return;
            }
            
            $this->error('导入Admin数据->数据表：admin，id：admin_name=' . $item->name . ',异常信息：' . $e->getMessage());
        }
    }
}