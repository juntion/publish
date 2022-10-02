<?php

namespace Modules\ERP\Entities;

use Illuminate\Support\Carbon;

class ProductsInstockShippingApply extends Model
{
    protected $table = "products_instock_shipping_apply";

    protected $primaryKey = "id";

    protected $guarded = [];

    protected $attributes = [
        'is_delete' => '0',
        'customer_grade' => '',
        'apply_type' => '0',
        'apply_time' => '0000-00-00 00:00:00',
        'apply_remarks' => '',
        'apply_admin' => '0',
        'verify_time' => '0000-00-00 00:00:00',
        'verify_remarks' => '',
        'verify_admin' => '0',
        'check_arr' => '',
        'check_id' => '0',
        'check_time' => '0000-00-00 00:00:00',
        'check_remarks' => '',
        'status' => '',
        'products_instock_id' => '0',
        'orders_num' => '',
        'is_advance' => '',
        'finance_admin' => '',
        'finance_status' => '',
        'finance_time' => '0000-00-00 00:00:00',
        'finance_remark' => '',
        'order_payment' => '',
        'customers_NO' => '',
        'customers_email' => '',
        'customer_nature' => '',
        'company_name' => '',
        'company_web' => '',
        'company_profile' => '',
        'customer_analysis' => '',
        'apply_money' => '',
        'apply_moneys' => '',
        'currencies_id' => '',
        'files' => '',
        'create_order' => '',
        'payable_date' => '',
        'orders_number' => '',
        'is_payment' => '',
        'payment_remarks' => '',
        'customers_name' => '',
        'account_number' => '',
        'batch_inquiry' => '',
        'advance_delivery' => '',
        'invoice_received' => '',
        'refund_type' => '',
        'refund_method' => '',
        'bank_name' => '',
        'swift' => '',
        'swift_code' => '',
        'country' => '',
        'billing_country' => '',
        'address' => '',
        'bpay_bsb_number' => '',
        'bpay_bic' => '',
        'bpay_account_number' => '',
        'message' => '',
        'refund_json_info' => '',
        'is_referral' => '',
        'referral_status' => '',
        'referral_admin' => '',
        'referral_remarks' => '',
        'referral_time' => '0000-00-00 00:00:00',
        'audit_is_fillmoney' => '',
        'fill_money_num' => '',
        'is_fillmoney' => '',
        'is_frequently' => '',
        'fill_money' => '',
        'fill_remarks' => '',
        'parent_id' => '',
        'cooperate_from_time' => '0000-00-00 00:00:00',
        'cooperate_to_time' => '0000-00-00 00:00:00',
        'transport_country' => '',
        'added_tax' => '',
        'added_tax_state' => '',
        'difference' => '',
        'vat_number' => '',
        'address_book_id' => '',
        'entry_state' => '',
        'json_info' => '',
        'is_yf' => '',
        'money' => '',
        'email_num' => '',
        'shipping_method' => '',
        'overdue_id' => '',
        'overdue_remark' => '',
        'fillmoney_type' => '',
        'bad_money' => '',
        'is_free_shipping' => '',
        'purchase_remarks' => '',
        'purchase_time' => '0000-00-00 00:00:00',
        'purchase_admin' => '',
        'purchase_check_status' => '',
        'advance_type' => '',
        'DK_number' => '',
        'company_number' => '',
        'date_limit' => '',
        'fs_internal_id' => '',
        'ns_internal_id' => '',
        'is_cw' => '',
        'return_number' => '',
        'QA_number' => '',
        'tax_type' => '',
        'refund_bankser_num' => '',
        'auto_refund_status' => '',
        'refund_return_params' => '',
        'refund_apply_number' => '',
        'refund_rate' => '',
        'dk_method' => '',
        'dk_date' => '',
        'dk_amount' => '',
    ];

    public function export(): array
    {
        return [];
    }

    public function user()
    {
        return $this->hasOne(Admin::class, 'admin_id', 'apply_admin');
    }

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'refund_method');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'currencies_id', 'currencies_id');
    }

    public function uniqueNumber()
    {
        return $this->hasOne(ProductsInstockShippingApplyUniqueNumber::class, 'related_id', 'id');
    }

    public function child()
    {
        return $this->hasOne(ProductsInstockShippingApply::class, 'fs_internal_id', 'id')
            ->where('apply_type', '=','26')
            ->where('status', '=','1');
    }
}

