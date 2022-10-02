<?php

namespace Modules\Finance\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Entities\Admin;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\Finance\Entities\Traits\UpdateLogTrait;

class PaymentReceipt extends Model
{
    use SoftDeletes,UpdateLogTrait,Searchable;

    protected $table = 'f_payment_receipts';

    protected $fillable
        = [
            'uuid', 'number', 'transaction_serial_number', 'is_match', 'currency', 'amount', 'fee_fs', 'fee', 'float',
            'usable', 'used', 'cleared', 'company_uuid', 'company_name', 'company_account_number',
            'customer_company_number', 'customer_company_name', 'customer_number', 'customer_debit_account',
            'payer_name', 'payer_email', 'payment_method_id', 'payment_method_name', 'payment_remark', 'payment_time',
            'claim_uuid', 'claim_name', 'claim_status', 'claim_type', 'claim_time', 'application_uuid', 'create_from',
            'creator_uuid', 'creator_name', 'deleted_at', 'created_at', 'order_number'
        ];

    public function logs()
    {
        return $this->hasMany(PaymentReceiptsLog::class, 'uuid', 'uuid');
    }

    public function claims()
    {
        return $this->hasMany(PaymentClaimApplication::class, 'receipt_uuid', 'uuid')->orderBy('created_at', "DESC");
    }

    public function application()
    {
        return $this->hasOne(PaymentClaimApplication::class, 'uuid', 'application_uuid');
    }


    public function lastApplication()
    {
        return $this->hasOne(PaymentClaimApplication::class, 'receipt_uuid', 'uuid')
            ->orderBy('created_at', 'DESC');
    }

    public function claimsUser()
    {
        return $this->belongsTo(Admin::class, 'claim_uuid', 'uuid');
    }


    public function details()
    {
        return $this->hasMany(PaymentReceiptsVouchersDetail::class, 'receipt_uuid', 'uuid');
    }

    public function toSearchableArray()
    {
        $data['number'] = $this->number;
        $data['amount'] = $this->amount;
        $data['transaction_serial_number'] = $this->transaction_serial_number;
        $data['customer_company_number'] = $this->customer_company_number;
        $data['customer_number'] = $this->customer_number;
        $data['payer_name'] = $this->payer_name;
        $data['payer_email'] = $this->payer_email;
        $data['creator_uuid'] = $this->creator_uuid;
        $data['claim_uuid'] = $this->claim_uuid;
        $data['claim_status'] = $this->claim_status;
        $data['created_at'] = $this->created_at;
        $data['order_number'] = $this->order_number;
        $data['payment_remark'] = $this->payment_remark;
        $data['customer_company_name'] = $this->customer_company_name;
        return $data;
    }
}
