<?php

namespace Modules\Finance\Database\Seeders\Migrate;

use Modules\Base\Database\Seeders\MigrateSeeder;
use Modules\Base\Entities\Company\Company;
use Modules\ERP\Entities\PushPayment as Export;
use Modules\ERP\Entities\ManageCustomerCompany;
use Modules\ERP\Entities\PaymentMethod;
use Modules\Admin\Entities\Admin;
use Modules\Finance\Entities\PaymentReceipt as Import;
use Illuminate\Support\Carbon;

/**
 * 从ns_push_payment迁移DK数据
 */
class PaymentreceiptsSeeder extends MigrateSeeder
{
    public function run()
    {
        $total = Export::query()->count();
        $this->command->info('开始迁移 erp ns_push_payment 表');
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();
        Export::query()->chunk(1000, function ($export) use ($bar) {
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
            $receipts['uuid'] = $data['uuid'];
            $receipts['currency'] = $data['currency'];
            $receipts['number'] = $data['number'];
            $receipts['customer_company_number'] = $data['customer_company_number'];
            if(strlen($data['customer_company_number']) > 16){
                throw new \Exception('客户公司编号长度超限,'.$data['customer_company_number'].',到款编号=' . $data['number']);
            }
            $receipts['customer_debit_account'] = $data['customer_debit_account'];
            $receipts['company_account_number'] = $data['company_account_number'];
            $receipts['transaction_serial_number'] = $data['transaction_serial_number'] ?: null;
            $receipts['claim_type'] = $data['claim_type'];
            $receipts['payment_remark'] = $data['payment_remark'];
            $receipts['payment_time'] = $this->timeChange($data['payment_time']);
            $receipts['created_at'] = $this->timeChange($data['created_at']);
            $receipts['updated_at'] = $this->timeChange($data['updated_at']);
            $receipts['claim_time'] = $data['claim_time'] == '0000-00-00 00:00:00' ? null : $this->timeChange($data['claim_time']);
            $receipts['float'] = $this->math_mul($data['float'], 100);
            $receipts['fee'] = $this->math_mul($data['fee'], 100);
            $receipts['amount'] = $this->math_mul($data['amount'], 100);
            $receipts['usable'] = $this->math_mul($data['usable'], 100);
            $receipts['used'] = $this->math_mul($data['used'], 100);
            if ($receipts['amount'] < 0) {
                $this->warn('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：到款总金额为负数,到款编号=' . $data['number']);
                $receipts['amount'] = 0;
            } 
            if ($receipts['amount'] == 0) {
                $this->warn('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：到款总金额为0,到款编号=' . $data['number']);
                $receipts['amount'] = 0;
            } 
            if ($receipts['usable'] < 0) {
                $this->warn('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：到款可用金额为负数,到款编号=' . $data['number']);
                $receipts['usable'] = 0;
            } 
            if ($receipts['used'] < 0) {
                $this->warn('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：到款已用金额为负数,到款编号=' . $data['number']);
                $receipts['used'] = 0;
            } 
            if ($receipts['used'] > $receipts['usable']) {
                $this->warn('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：到款已用金额大于可用总额,到款编号=' . $data['number']);
                $receipts['used'] = $receipts['usable'];
            }

            $receipts['fee_fs'] = $this->math_mul($data['fee_fs'], 100);
            $receipts['cleared'] = $this->math_mul(0, 100);
            //认领人转换
            $admin_info = Admin::query()->where('id', $data['renling_admin'])->first(['uuid', 'name']);
            $receipts['claim_uuid'] = $admin_info ? $admin_info->uuid : null;
            $receipts['claim_name'] = $admin_info ? $admin_info->name : ($data['renling_admin'] ? $data['renling_admin'] : null);
            $receipts['claim_status'] = $data['renling_admin']?2:0;

            // 原erp没有记录创建人，全部默认root
            $creator_admin_info = Admin::query()->where('name', 'root')->first(['uuid', 'name']);
            $receipts['creator_uuid'] = $creator_admin_info ? $creator_admin_info->uuid : null;
            $receipts['creator_name'] = $creator_admin_info ? $creator_admin_info->name : 'root';

            //付款方式数据
            $receipts['payment_method_id'] = $data['payment_method_id'];
            $paymentMethod = PaymentMethod::query()->where('id', $data['payment_method_id'])->first(['payment_method']);
            $receipts['payment_method_name'] = $paymentMethod['payment_method'] ?: 0;

            //公司信息填充
            $company = Company::query()->where('ns_internal_id', $data['subsidiary'])->first(['uuid', 'name']);
            $receipts['company_uuid'] = $company ? $company->uuid : null;
            $receipts['company_name'] = $company ? $company->name : null;

            //订单信息
            $receipts['order_number'] = $data['order_number'] ? $data['order_number'] : null;

            //客户信息填充
            $customersCompany = ManageCustomerCompany::query()->where('company_number', $data['customer_company_number'])->first(['customers_company']);
            $receipts['customer_company_name'] = $customersCompany ? $customersCompany->customers_company : null;

            if ($data['online_order']) {
                $receipts['create_from'] = 1;
            }

            Import::modelUpdateOrCreate(
                ['number' => $data['number']],
                $receipts
            );
        } catch (\Exception $e) {
            $this->error('导入到款数据->数据表：ns_push_payment，主键：id=' . $item->getKey() . ',异常信息：' . $e->getMessage());
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
