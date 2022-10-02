<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\ERP\Entities\OrdersOfDKDataDetails as Export;
use Modules\ERP\Entities\ExpenseVoucherRecord;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail as Import;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentVoucher;
/**
 * 从ns_expense_voucher_record迁移用款凭证数据
 */
class PaymentReceiptsvouchersDetails extends MigrateSeeder
{
    public function run()
    {
        $total = Export::query()->where('data_type', '=', 1)->where('is_delete', '=', 0)->where('vouch_id', '>', 0)->count();
        $this->command->info('开始迁移 erp payment_receipts_vouchers_details 表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        Export::query()
            ->where('data_type', '=', 1)
            ->where('is_delete', '=', 0)
            ->where('vouch_id', '>', 0)
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

            $vouchers['uuid'] = Str::uuid()->getHex()->toString();
            //到款信息
            $receiptInfo = PaymentReceipt::query()->where('number', '=', $data['dk_number'])->first(['uuid', 'currency','cleared','amount']);
            if (!$receiptInfo) {
                throw new \Exception('根据到款编号无法查出对应的到款信息,到款编号=' . $data['dk_number']);
            }
            $vouchers['receipt_uuid'] = $receiptInfo->uuid;
            $vouchers['receipt_number'] = $data['dk_number'];
            $vouchers['receipt_currency'] = $receiptInfo->currency;
            $vouchers['receipt_use'] = $this->math_mul($data['order_out_of_dk'], 100);

            //凭证信息
            $erpVouchInfo = ExpenseVoucherRecord::query()->where('ns_vouch_id', $data['vouch_id'])->first(['ns_vouch_num']);
            if(!$erpVouchInfo){
                throw new \Exception('根据凭证id无法查出对应的凭证编号信息,凭证id=' . $data['vouch_id']);
            }
            $vouchInfo = PaymentVoucher::query()->where('number', $erpVouchInfo->ns_vouch_num)->first(['uuid', 'currency','usable','used']);
            if (!$vouchInfo) {
                throw new \Exception('根据凭证id无法查出对应的凭证信息,凭证id=' . $data['vouch_id']);
            }
            //根据明细数据累加凭证已用总额
            PaymentVoucher::query()->where('uuid',$vouchInfo->uuid)->update(['used'=>DB::raw('`used` + '. $this->math_mul($data['order_out_of_dk'], 100))]);
            $vouchers['voucher_uuid'] = $vouchInfo->uuid;
            $vouchers['voucher_number'] = $erpVouchInfo->ns_vouch_num;
            $vouchers['voucher_currency'] = $vouchInfo->currency;
            $vouchers['voucher_use'] = $this->math_mul($data['dk_out_of_order'], 100);

            $vouchers['order_number'] = $data['orders_num'];
            $vouchers['order_id'] = $data['products_instock_id'];

            $vouchers['created_at'] = $this->timeChange($data['create_time']);
            $vouchers['parent_id'] = $data['parent_id'] ?: $vouchers['order_id'];
            $vouchers['origin_id'] = $data['origin_id'] ?: $vouchers['order_id'];

            Import::query()->create($vouchers);

        } catch (\Exception $e) {
            $this->error('导入到款拆分明细数据->数据表：payment_receipts_vouchers_details，id=' . $item->vouch_id . ',异常信息：' . $e->getMessage());
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
