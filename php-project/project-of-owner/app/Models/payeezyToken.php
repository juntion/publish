<?php

namespace App\Models;

use App\Models\BaseModel;

class payeezyToken extends BaseModel
{
    protected $table = 'payeezy_tokens';
    protected $fillable = [
        'clientToken',
        'nonce',
        'data_info',
        'created_at',
        'is_error'
    ];
    public $timestamps = false;
}
