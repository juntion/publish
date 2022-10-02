<?php


namespace Modules\Share\Database\Seeders\Init;

use Illuminate\Support\Str;
use Modules\Admin\Entities\Admin;
use Modules\Base\Database\Seeders\MigrateSeeder as Seeder;
use Modules\ERP\Entities\Product;
use Modules\Share\Entities\ResourceTag;

class ERPProductsId extends Seeder
{
    public function run()
    {
        $export = Product::query()->select('products_id')->get();
        $user = Admin::query()->where('name', config('app.root'))->first();

        $this->command->info('开始迁移 erp products 表提取products_id信息');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();

        foreach ($export as $item) {
            $this->migrate($item, $user->uuid);
            $bar->advance();
        }

        $bar->finish();
    }

    private function migrate(&$item, $uuid)
    {
        try {
            $importData = [
                'uuid'         => Str::uuid()->getHex()->toString(),
                'name'         => $item->products_id,
                'creator_uuid' => $uuid,
            ];
            ResourceTag::modelUpdateOrCreate(
                ['name' => $item->products_id],
                $importData
            );

        } catch (\Exception $e) {
            $this->error('导入Products数据->数据表：resource_tags，name = '.$item->products_id.',异常信息：'.$e->getMessage());
        }
    }
}
