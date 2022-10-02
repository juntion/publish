<?php

namespace App\Models;

class OrderStatus extends BaseModel
{
    protected $table = 'orders_status';
    protected $primaryKey = 'orders_status_id,language_id';
}
