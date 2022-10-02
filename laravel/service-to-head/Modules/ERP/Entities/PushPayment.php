<?php


namespace Modules\ERP\Entities;

use Illuminate\Support\Str;

class PushPayment extends Model
{
    protected $table = 'ns_push_payments';

    protected $primaryKey = 'id';

    public function export(): array
    {
        return [
            'id' => $this->id,
            'uuid' => Str::uuid()->getHex()->toString(),
            'number' => $this->orders_num,
            'payment_time' => $this->date,
            'payment_remark' => $this->remark,
            'subsidiary' => $this->subsidiary,//需转换
            'currency' => $this->currency,
            'amount' => $this->amount_total - (float)$this->bank_commission,
            'fee_fs' => (float)$this->bank_commission,
            'fee' => $this->pay_fee + (float)$this->bank_commission,
            'float' => $this->exchange_money,
            'usable' => $this->amount_total + $this->pay_fee + $this->exchange_money,
            'used' => $this->amount_total_use,
            'payment_method_id' => $this->payment_method_id,
            'customer_company_number' => $this->customer,//客户G编号需转换
            'customer_debit_account' => $this->customer_debit_account,
            'company_account_number' => $this->fs_shroff_account_number,
            'renling_admin' => $this->renling_admin,//需转换
            'is_cancel' => $this->is_cancel,//需转换
            'renling_mark' => $this->renling_mark,//认领迁移时需转换
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'claim_time' => $this->renling_date,
            'online_order' => $this->online_order,//需转换为create_from 1 自动导入
            'transaction_serial_number' => $this->bankser_num,
            'claim_type' => $this->is_auto_claim,
            'check_status' => $this->finance_check,//迁移到payment_claim_applications.check_status
            'finance_remark' => $this->finance_remark,//迁移到payment_claim_applications.check_remar
            'finance_check_time' => $this->finance_check_time, //迁移到payment_claim_applications.check_time
            'customer_to_check' => $this->customer_to_check,
            'order_number' => $this->order_number,
            'finance_admin' => $this->finance_admin,
        ];
    }
}
