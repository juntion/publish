<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Admin\Repositories\AdminRepository;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyMedia as Import;
use Modules\UUMS\Entities\Media as Export;

class CompanyMedia extends MigrateSeeder
{
    protected $map = [
        'App\Company\Models\CompanyAddressInfo' => \Modules\Base\Entities\Company\CompanyAddress::class,
        'App\Company\Models\CompanyPay'         => \Modules\Base\Entities\Company\CompanyBank::class
    ];

    public function run()
    {
        $export = Export::query()->whereIn('model_type', array_keys($this->map))->get();
        $this->command->info('开始迁移 uums 系统 medias 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        foreach ($export as $item) {
            $data = $item->export();
            $model = resolve($this->map[$data['model_type']])
                ->where('id', $data['model_id'])
                ->first();
            $data['model_uuid'] = $model->uuid;
            $user = app()->make(AdminRepository::class)->getAdminInfoByOriginId($data['origin_id']);
            if ($user) {
                $data['admin_uuid'] = $user->uuid;
                $data['admin_name'] = $user->name;
            }
            unset($data['model_id']);
            unset($data['user_id']);
            unset($data['origin_id']);
            $data['model_type'] = $this->map[$data['model_type']];
            $file_name = $data['file_name'];
            unset($data['file_name']);
            $data['path'] = 'company/'. $model->getMediaCollection() . '/' . substr($file_name,0,2) . '/'. substr($file_name,2,2) . '/' . $file_name;
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司附件数据->数据表：medias，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
