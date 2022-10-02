<?php


namespace Modules\ERP\Entities;

use Illuminate\Support\Str;

class ExpenseVoucherRecord extends Model
{
    protected $table = 'ns_expense_voucher_record';

    protected $primaryKey = 'fs_id';

    public function export(): array
    {
        //真实到款凭证占用额度汇算
        //products_instock_shipping_refund_money_apply ns_internal_id apply_money
        //products_instock_shipping_sales_after ns_credit_note_id refund_total_money
        //所有正常子单金额累加 - 红冲金额
        return [
            'id'        => $this->fs_id,
            'uuid'      => Str::uuid()->getHex()->toString(),
            'number'    => $this->ns_vouch_num,
            'currency'  => $this->fs_currency,
            'usable'    => $this->fs_order_total,
            //'used'      => $this->used,//需fs跑脚本新增所有凭证占用额度数据之后再迁移,新增字段used
            'type'      => $this->fs_vouch_type,
            'order_number'  => $this->fs_so_num,
            'remark'    => $this->fs_remarks,
            'ns_customer_id'  => $this->ns_customer_id,
            'fs_admin'  => $this->fs_admin,
            'fs_time'  => $this->fs_time,
            'ns_vouch_id'  => $this->ns_vouch_id,
            'fs_products_instock_id'=>$this->fs_products_instock_id
        ];
    }
}
