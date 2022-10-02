<?php

namespace Modules\ERP\Entities;

class OrderToAdmin extends Model
{
    protected $table = 'order_to_admin';

    protected $primaryKey = 'order_to_admin_id';

    protected $fields = [];

    public function export(): array
    {
        return [];
    }

    public function orders(){
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
