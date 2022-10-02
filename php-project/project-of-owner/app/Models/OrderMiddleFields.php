<?php
/**
 * Notes:
 * File name:OrderMiddleFields
 * Create by: Jay.Li
 * Created on: 2020/6/29 0029 18:23
 */


namespace App\Models;

class OrderMiddleFields extends BaseModel
{
    protected $table = 'orders_middle_fields';

    public $fillable = [
        'orders_id', 'delivery_ticket_number', 'other_delivery'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'orders_id', 'orders_id');
    }
}
