<?php

namespace Modules\ERP\Entities;

class Paypal extends Model
{
    protected $table = 'paypal';

    protected $primaryKey = 'paypal_ipn_id';

    public function export(): array
    {
        return [];
    }

    public function orders(){
        return $this->belongsTo(Order::class, 'order_id','orders_id');
    }
}
