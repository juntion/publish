<?php


namespace Modules\Finance\Entities;


use Modules\Base\Entities\Model;

class PaymentVouchersLog extends Model
{
    protected $table = "f_payment_vouchers_logs";

    protected $fillable = ['uuid', 'log', 'created_at'];

    public $timestamps = false;

    protected $primaryKey = false;

    protected $casts = [
        'log' => 'array'
    ];
}
