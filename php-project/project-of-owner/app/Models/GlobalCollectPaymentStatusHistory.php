<?php


namespace App\Models;

use App\Models\BaseModel;

class GlobalCollectPaymentStatusHistory extends BaseModel
{
    protected $table = 'globalcollect_payment_status_history';
    protected $fillable = [
        'orders_id',
        'status_id',
        'imformation',
        'description',
        'datetime',
        'payment_id',
        'type'
    ];
    public $timestamps = false;
}
