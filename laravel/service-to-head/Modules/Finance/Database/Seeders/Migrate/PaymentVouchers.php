<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\ERP\Entities\ManageCustomerCompany;
use Modules\ERP\Entities\ProductsInstockShipping as order;
use Modules\ERP\Entities\ExpenseVoucherRecord as Export;
use Modules\ERP\Entities\ExpenseVoucherRecordFiles as ExportFile;
use Modules\Finance\Entities\PaymentVoucher as Import;
use Modules\Finance\Entities\PaymentVouchersFile as ImportFile;
use Modules\Admin\Entities\Admin;


/**
 * 从ns_expense_voucher_record迁移用款凭证数据
 */
class PaymentVouchers extends MigrateSeeder
{
    public function run()
    {
        $total = Export::query()->where('ns_status', '!=', 900)->where('fs_is_delete', '=', 0)->where('fs_is_cancel', '=', 0)->count();
        $this->command->info('开始迁移 erp ns_expense_voucher_record 表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        Export::query()
            ->where('ns_status', '!=', 900)
            ->where('fs_is_delete', '=', 0)
            ->where('fs_is_cancel', '=', 0)->chunk(1000, function ($export) use ($bar) {
                foreach ($export as $item) {
                    $this->migrate($item);
                    $bar->advance();
                }
            });
        $bar->finish();
    }

    /**
     * 迁移逻辑
     *
     * @param $item
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function migrate(&$item)
    {
        try {
            $data = $item->export();
            $admin_id = '';
            $data['usable'] = $this->math_mul($data['usable'], 100);
            //$data['used'] = $this->math_mul($data['used'], 100);//后续根据明细表直接汇总计算
            $data['used'] = 0;
            $data['created_at'] = $data['fs_time'] == '-0001-11-30 00:00:00' || $data['fs_time'] == '0000-00-00 00:00:00' ? null : $this->timeChange($data['fs_time']);
            //认领人转换
            if ($data['fs_admin'] == 1||!$data['fs_admin']) {
                //获取订单对应的时间和销售
                if($data['fs_products_instock_id']){
                    $orderInfo = order::query()->where('products_instock_id',$data['fs_products_instock_id'])->first(['sales_admin','assistant_id','sales_add_time','sales_update_time','finance_time']);
                }else{
                    $orderInfo = order::query()->where('order_number',$data['order_number'])->first(['sales_admin','assistant_id','sales_add_time','sales_update_time','finance_time']);
                }
                if(!$orderInfo){
                    throw new \Exception('订单信息未找到,凭证编号=' . $data['number']);
                }
                $admin_id = $orderInfo->sales_admin?$orderInfo->sales_admin:$orderInfo->assistant_id;
                if(!$admin_id){
                    $this->warn('导入到款数据->数据表：ns_expense_voucher_record，主键：fs_id=' . $item->getKey() . ',异常信息：订单无对应销售信息,凭证编号=' . $data['number']);
                    $data['creator_uuid'] =  null;
                    $data['creator_name'] =  null;
                }else{
                    $admin_info = Admin::query()->where('id', $admin_id)->first(['uuid', 'name']);
                    $data['creator_uuid'] = $admin_info ? $admin_info->uuid : null;
                    $data['creator_name'] = $admin_info ? $admin_info->name : null;
                }
                $data['created_at'] = $orderInfo->sales_add_time == '0000-00-00 00:00:00'?($orderInfo->sales_update_time=='0000-00-00 00:00:00'?$this->timeChange($orderInfo->finance_time):$this->timeChange($orderInfo->sales_update_time)):$this->timeChange($orderInfo->sales_add_time);
                
            } elseif($data['fs_admin']) {
                $admin_info = Admin::query()->where('id', $data['fs_admin'])->first(['uuid', 'name']);
                $data['creator_uuid'] = $admin_info ? $admin_info->uuid : null;
                $data['creator_name'] = $admin_info ? $admin_info->name : null;
            }

            //客户信息填充
            $customerInfo = ManageCustomerCompany::query()->where('ns_internal_id', $data['ns_customer_id'])->first(['customers_company', 'company_number']);
            $data['customer_company_number'] = $customerInfo ? $customerInfo->company_number : null;
            $data['customer_company_name'] = $customerInfo ? $customerInfo->customers_company : null;

            unset($data['fs_products_instock_id']);
            unset($data['ns_customer_id']);
            unset($data['fs_admin']);
            unset($data['fs_time']);
            unset($data['id']);
            unset($orderInfo);

            Import::modelUpdateOrCreate(
                ['number' => $item->ns_vouch_num],
                $data
            );
            $this->migrateFile($item->fs_id, $data['uuid']);
        } catch (\Exception $e) {
            $this->error('导入到款数据->数据表：ns_expense_voucher_record，主键：fs_id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
        }
    }

    private function math_mul($a, $b, $scale = '0')
    {
        return bcmul($a, $b, $scale);
    }

    /**
     * 文件迁移
     *
     * @param $id
     * @param $applyId
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function migrateFile($id, $applyId)
    {
        $file = ExportFile::query()->where('fs_id', $id)->get();
        foreach ($file as $fileInfo) {
            try {
                $data = $fileInfo->export();
                $saveData = [];
                $saveData['uuid'] = Str::uuid()->getHex()->toString();
                $saveData['vouch_uuid'] = $applyId;
                $saveData['name'] = $data['targe_name'];
                $saveData['storage_name'] = $saveData['uuid'] . substr($data['file_name'], strrpos($data['file_name'], '.'));

                //ftp迁移文件
                $path = 'voucher/vouchers/' . substr($saveData['uuid'], 0, 2) . '/' . substr($saveData['uuid'], 2, 2);
                $saveData['path'] = $path;
                $exportPath = $fileInfo->file_path . $fileInfo->file_name;
                //通过ftp导入
                if (Storage::disk('erp')->exists($exportPath)) {
                    Storage::disk('finance')->makeDirectory($path);
                    Storage::disk('finance')->put($path . '/' . $saveData['storage_name'], Storage::disk('erp')->get($exportPath));

                    ImportFile::query()->create($saveData);
                }
            } catch (\Exception $e) {
                $this->error('导入到款数据->数据表：payment_vouchers_files，主键：uuid=' . $saveData['uuid'] . ',异常信息：' . $e->getMessage());
            }
        }
    }

    /**
     * 转换时间为utc
     *
     * @return void
     */
    private function timeChange($time)
    {
        if(is_null($time)){
            return null;
        }
        return Carbon::createFromTimeString($time, 'Asia/Shanghai')->tz(config('app.timezone'))->format('Y-m-d H:i:s');
    }
}
