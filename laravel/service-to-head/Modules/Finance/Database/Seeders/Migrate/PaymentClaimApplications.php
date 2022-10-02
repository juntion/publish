<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\ERP\Entities\PushPayment as Export;
use Modules\ERP\Entities\PushPaymentsFile as ExportFile;
use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\PaymentClaimApplication as Import;
use Modules\Finance\Entities\PaymentClaimApplyFile as ImportFile;
use Modules\Finance\Entities\PaymentReceipt as Receipt;
/**
 * 从ns_push_payment迁移DK认领数据
 */
class PaymentClaimApplications extends MigrateSeeder
{
    public function run()
    {
        $total = Export::query()->where('amount_total', '>', 0)
            ->where('is_cancel', '=', 0)
            ->where('renling_admin', '!=', '')
            ->where('is_auto_claim', '!=', 1)
            ->where('amount_total_not_use', '>=', 0)
            ->where('amount_total_use', '>=', 0)
            ->count();
        $this->command->info('开始迁移 erp ns_push_payment 认领申请表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        Export::query()
            ->where('amount_total', '>', 0)
            ->where('is_cancel', '=', 0)
            ->where('renling_admin', '!=', '')
            ->where('is_auto_claim', '!=', 1)
            ->where('amount_total_not_use', '>=', 0)
            ->where('amount_total_use', '>=', 0)
            ->chunk(1000, function ($export) use ($bar) {
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
     * @param [type] $item
     * @return void
     */
    private function migrate(&$item)
    {
        try {
            $data = $item->export();
            $receiptData['uuid'] = Str::uuid()->getHex()->toString();
            $receiptID = Receipt::query()->where('number', $data['number'])->first(['uuid']);
            if (!$receiptID) {
                throw new \Exception('到款导入信息查询失败,到款编号=' . $data['number']);
            }
            //关联到款uuid
            $receiptData['receipt_uuid'] = $receiptID?$receiptID->uuid:null;
            //申请人信息
            $apply_admin_info = Admin::query()->where('id', $data['renling_admin'])->first(['uuid', 'name']);
            if (!$apply_admin_info) {
                throw new \Exception('申请人信息查询失败,到款编号=' . $data['number']);
            }
            $receiptData['apply_uuid'] = $apply_admin_info ? $apply_admin_info->uuid : null;
            $receiptData['apply_name'] = $apply_admin_info ? $apply_admin_info->name : ($data['renling_admin'] ? $data['renling_admin'] : '');
            $receiptData['apply_type'] = 1;
            $receiptData['apply_remark'] = $data['renling_mark'];
            //审核人信息
            if ($data['finance_admin'] == 0 || $data['finance_admin'] == '') {
                $receiptData['check_uuid'] = null;
                $receiptData['check_name'] = null;
            } else {
                $apply_admin_info = Admin::query()->where('id', $data['finance_admin'])->first(['uuid', 'name']);
                $receiptData['check_uuid'] = $apply_admin_info ? $apply_admin_info->uuid : null;
                $receiptData['check_name'] = $apply_admin_info ? $apply_admin_info->name : $data['finance_admin'];
            }
            $receiptData['check_status'] = 1;
            $receiptData['check_remark'] = $data['finance_remark'];
            $receiptData['check_time'] = $data['finance_check_time'] == '0000-00-00 00:00:00' ? null : $this->timeChange($data['finance_check_time']);
            $receiptData['created_at'] = $data['claim_time'] == '0000-00-00 00:00:00' ? null : $this->timeChange($data['claim_time']);
            $receiptData['customer_company_number'] = $data['customer_company_number'];
            Import::modelUpdateOrCreate(
                ['receipt_uuid' => $receiptData['receipt_uuid']],
                $receiptData
            );
            //更新uuid到原到款表
            Receipt::query()->where('uuid',$receiptID->uuid)->update(['application_uuid'=>$receiptData['uuid']]);
            //同步迁移文件
            $this->migrateFile($item->id, $receiptData['uuid']);
        } catch (\Exception $e) {
            $this->error('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
        }
    }

    private function migrateFile($id, $appldyId)
    {
        $file = ExportFile::query()->where('ns_push_payments_id', $id)->where('is_cancel', 0)->get();
        foreach ($file as $fileInfo) {
            $data = $fileInfo->export();
            try {
                $saveData = [];
                $saveData['uuid'] = Str::uuid()->getHex()->toString();
                $saveData['apply_uuid'] = $appldyId;
                $saveData['name'] = $data['file_name'];
                $saveData['storage_name'] = $saveData['uuid'] . substr($data['file_storage_name'], strrpos($data['file_storage_name'], '.'));

                $saveData['created_at'] = $this->timeChange($data['add_time']);
                $saveData['type'] = $data['is_finance'] ? 2 : 1;
                //ftp迁移文件
                $path = 'receipt/claimApplication/' . substr($saveData['uuid'], 0, 2) . '/' . substr($saveData['uuid'], 2, 2);
                $saveData['path'] = $path;
                $exportPath = $fileInfo->file_path . '/' . $fileInfo->file_storage_name;
                //通过ftp导入
                if (Storage::disk('erp')->exists($exportPath)) {
                    Storage::disk('finance')->makeDirectory($path);
                    Storage::disk('finance')->put($path . '/' . $saveData['storage_name'], Storage::disk('erp')->get($exportPath));
                    ImportFile::query()->create($saveData);
                }
            } catch (\Exception $e) {
                $this->error('导入到款数据->数据表：ns_push_payment_file，主键：到款id=' . $id . ',异常信息：' . $e->getMessage());
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
