<?php

namespace App\Models;

class PaymentMethod extends BaseModel
{
    protected $table = 'payment_method';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
