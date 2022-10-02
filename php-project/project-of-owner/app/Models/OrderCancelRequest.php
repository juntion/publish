<?php

namespace App\Models;

class OrderCancelRequest extends BaseModel
{
    protected $table = 'orders_cancel_request';
    protected $primaryKey = 'orders_cancel_request';

    public $timestamps = false;
}
