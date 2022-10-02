<?php


namespace Modules\Base\Database\Seeders\Migrate;


use Modules\Admin\Repositories\AdminRepository;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\CompanyStatusLog as Import;
use Modules\UUMS\Entities\CompanyStatusLog as Export;

class CompanyStatusLog extends MigrateSeeder
{
    protected $map = [
        'App\Company\Models\Company' => \Modules\Base\Entities\Company\Company::class,
        'App\Company\Models\CompanyAddressInfo' => \Modules\Base\Entities\Company\CompanyAddress::class,
        'App\Company\Models\CompanyPay'         => \Modules\Base\Entities\Company\CompanyBank::class,
    ];

    public function run()
    {
        $export = Export::all();
        $this->command->info('开始迁移 uums 系统 company_status_log 表');
        $bar = $this->command->getOutput()->createProgressBar($export->count());
        $bar->start();
        $adminRepository = app()->make(AdminRepository::class);
        foreach ($export as $item) {
            $data = $item->export();
            $data['model_uuid'] = resolve($this->map[$data['model_type']])
                ->where('id', $data['model_id'])
                ->first()->uuid;
            $user = $adminRepository->getAdminInfoByOriginId($data['origin_id']);
            if($user) {
                $data['admin_uuid'] = $user->uuid;
                $data['admin_name'] = $user->name;
            }
            $data['model_type'] = $this->map[$data['model_type']];
            unset($data['user_id']);
            unset($data['model_id']);
            unset($data['origin_id']);
            try {
                Import::modelUpdateOrCreate(
                    ['id' => $item->id],
                    $data
                );
            } catch (\Exception $e) {
                $this->error('导入公司信息变更日志数据->数据表：company_status_log，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
