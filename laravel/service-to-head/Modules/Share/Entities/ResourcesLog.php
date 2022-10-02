<?php


namespace Modules\Share\Entities;


use Modules\Base\Entities\Model;

class ResourcesLog extends Model
{
    protected $table = 'share_resources_logs';
    public $timestamps = false;

    protected $fillable = ['uuid', 'log'];
    protected $casts = [
        'log' => 'array'
    ];
}
