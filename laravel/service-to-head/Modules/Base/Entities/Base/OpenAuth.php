<?php

namespace Modules\Base\Entities\Base;


use Modules\Base\Entities\Model;

class OpenAuth extends Model
{
    protected $table = 'open_auth';
    protected $primaryKey = 'access_key_id';
    protected $fillable = [
        'access_key_id', 'access_key_secret', 'exp_time', 'status', 'remarks'
    ];
}
