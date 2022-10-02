<?php

namespace Modules\ERP\Entities;

class GlobalcollectPayment extends Model
{
    protected $table = 'globalcollect_payment_status_history';

    protected $primaryKey = 'orders_id';

    public function export(): array
    {
        return [];
    }

    public function orders(){
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
