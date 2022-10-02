<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Illuminate\Support\Carbon;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\ERP\Entities\OrdersOfDKDataDetails as Export;
use Modules\Finance\Entities\PaymentReceiptsToVoucher as Import;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentVoucher;

/**
 * 从ns_expense_voucher_record迁移用款凭证数据
 */
class PaymentReceiptsToVouchers extends MigrateSeeder
{
    public function run()
    {
        //SELECT dk_number, order_out_of_dk,actual_symbol, vouch_id, sum(cw_finally_total) as cwtotal,dk_out_of_order,dk_symbol, create_time,sum(dk_out_of_order) as dktotal FROM `orders_of_dk_data_details` WHERE `vouch_id` = 1805614 AND is_delete=0 AND data_type=1 group BY dk_number
        //SELECT dk_number, dk_out_of_order, vouch_id, dk_out_of_ns, create_time,count(*) FROM `orders_of_dk_data_details` WHERE data_type=1 and is_delete=0 GROUP BY vouch_id ORDER BY `count(*)` DESC
        $total = PaymentVoucher::query()->count();
        $this->command->info('开始迁移 erp payment_receipts_to_vouchers 表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        PaymentVoucher::query()->chunk(500, function ($vouchers) use ($bar) {
            foreach ($vouchers as $item) {
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
        //关系重建映射
        $export = Export::query()
            ->where('data_type', 1)
            ->where('is_delete', 0)
            ->where('vouch_id', $item->ns_vouch_id)
            ->get([
                'cw_finally_total',
                'dk_out_of_order',
                'dk_number',
                'vouch_id',
                'create_time'
            ]);

        $VouchInfo = $export->groupBy('dk_number');
        foreach ($VouchInfo as $itemDetil) {
            try {
                //到款信息
                $dkNum = $itemDetil->first()->dk_number;
                $dktotal = $itemDetil->sum('dk_out_of_order');
                $receiptInfo = PaymentReceipt::query()->where('number', '=', $dkNum)->first(['uuid', 'currency']);
                if(!$receiptInfo){
                    throw new \Exception('未找到到款信息,用款凭证编号=' . $item->number);
                }
                $data['receipt_uuid'] = $receiptInfo->uuid;
                $data['receipt_number'] = $dkNum;
                $data['receipt_currency'] = $receiptInfo->currency;
                $data['receipt_use'] = $this->math_mul($dktotal, 100);
                $data['receipt_init'] = $this->math_mul($dktotal, 100);
                //@todo 验证使用金额为0的数据处理

                //凭证信息
                $cwTotal = $itemDetil->sum('cw_finally_total');
                $data['voucher_uuid'] = $item->uuid;
                $data['voucher_number'] = $item->number;
                $data['voucher_currency'] = $item->currency;
                $data['voucher_use'] = $this->math_mul($cwTotal, 100);
                $data['voucher_init'] = $this->math_mul($cwTotal, 100);
                $data['created_at'] = $this->timeChange($itemDetil->first()->create_time);

                unset($data['dk_number']);
                unset($data['cwtotal']);
                unset($data['vouch_id']);
                unset($data['dktotal']);

                Import::query()->create($data);
            } catch (\Exception $e) {
                $this->error('导入到款用款凭证关系数据->数据表：payment_receipts_to_vouchers，凭证编号' . $item->number . ',异常信息：' . $e->getMessage());
            }
        }
    }

    private function math_mul($a, $b, $scale = '0')
    {
        return bcmul($a, $b, $scale);
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
