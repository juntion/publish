<?php


namespace Modules\Admin\Database\Seeders\Migrate;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Base\Database\Seeders\MigrateSeeder as Seeder;
use Modules\ERP\Entities\Admin as Export;
use Modules\Admin\Entities\Admin as Import;

/**
 *
 * 处理旧数据的方式
 * 1,邮箱格式不正确，邮箱重复， -> 设为null
 * 2,头像文件不存在             -> 清空头像字段
 *
 */
class ERPAdmin extends Seeder
{
    public function run()
    {
        $export = Export::all();

        $this->command->info('开始迁移 erp admin 表');
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
            $this->check($item);

            $admin = Import::modelUpdateOrCreate(
                ['id' => $item->admin_id],
                $item->export()
            );

            $this->migrateAvatar($item, $admin);

        } catch (Exception $e) {

            if ($e instanceof QueryException && $e->getCode() == 23000 && strpos($e->getMessage(), 'admins_email_unique') !== false) {
                $item->admin_email = null;
                $this->migrate($item);
                return;
            }

            $this->error('导入Admin数据->数据表：admin，id = ' . $item->admin_id . '：admin_name=' . $item->admin_name . ',异常信息：' . $e->getMessage());
        }
    }

    private function migrateAvatar(&$item, &$admin)
    {
        // 头像导过就不导了
        if (!$item->admin_image || $admin->avatar) {
            return;
        }

        $avatarPath = 'avatar/' . substr($admin->uuid, 0, 2) . '/';
        $avatarName = $admin->uuid . substr($item->admin_image, strrpos($item->admin_image, '.'));

        // 通过http的方式导入, 头像暂时使用 http 的方式导入，后面文件的导入使用 ftp 服务
        if (config('app.service_erp_url') && strpos(config('app.service_erp_url'), 'http') !== false) {
            $exportPath = config('app.service_erp_url') . '/images/' . $item->admin_image;
            $response = Http::withOptions(['verify' => false, 'timeout' => 3])->get($exportPath);
            if ($response->successful()) {
                Storage::disk('public')->makeDirectory($avatarPath);
                Storage::disk('public')->put($avatarPath.$avatarName, $response->body());
                $admin->avatar = $avatarPath . $avatarName;
                $admin->save();
            }

            return;
        }

        // 通过本地的方式导入
//        if (Storage::disk('erp')->exists('images/' . $item->admin_image)) {
//            $exportPath = Storage::disk('erp')->path('images/') . $item->admin_image;
//            Storage::disk('public')->makeDirectory($avatarPath);
//            $importPath = Storage::disk('public')->path($avatarPath) . $avatarName;
//            copy($exportPath, $importPath);
//            $admin->avatar = $avatarPath . $avatarName;
//            $admin->save();
//            return;
//        }
    }

    private function check(&$item)
    {
        if (!filter_var($item->admin_email, FILTER_VALIDATE_EMAIL)) {
            $item->admin_email = null;
        }

//        if (!filter_var($item->admin_email, FILTER_VALIDATE_EMAIL)) {
//            $email = $this->correctEmail($item);
//            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//                $item->admin_email = $email;
//            } else {
//                throw new Exception('邮箱格式错误,无法校正:' . $item->admin_email, 100000);
//            }
//        }

//        if ($item->admin_image && !Storage::disk('erp')->exists('images/' . $item->admin_image)) {
//            $item->admin_image = '';
//        }
    }

//    private function correctEmail(&$item)
//    {
//        $email = str_replace(' ', '', $item->admin_name) . '@example.com';
//        $this->warn('导入Admin数据->数据表：admin，id：admin_name=' . $item->admin_name . ',邮箱异常，更改邮箱：' . $item->admin_email . '->' . $email);
//        return $email;
//    }
}
