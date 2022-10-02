<?php

namespace Modules\ERP\Entities;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'orders_id';

    public function export(): array
    {
        return [];
    }

    public function statusHistory(){
        return $this->hasMany(StatusHistory::class, 'orders_id');
    }

    public function globalcollectPayment(){
        return $this->hasMany(GlobalcollectPayment::class, 'orders_id');
    }

    public function paypal(){
        return $this->hasMany(Paypal::class, 'order_id','orders_id');
    }

    public function prices()
    {
        return $this->hasMany(OrderTotal::class, 'orders_id', 'orders_id');
    }

    public function ordersInputNotes()
    {
        return $this->hasMany(OrdersInputNotes::class, 'related_id', 'orders_id');
    }

    public function orderToAdmin()
    {
        return $this->hasOne(OrderToAdmin::class, 'orders_id', 'orders_id');
    }
}
