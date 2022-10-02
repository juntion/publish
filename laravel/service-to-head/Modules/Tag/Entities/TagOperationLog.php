<?php

namespace Modules\Tag\Entities;

use Illuminate\Support\Str;
use Modules\Base\Entities\Model;
use Modules\Tag\Enums\TagOperationLogActionDesc;
use Modules\Tag\Observers\TagOperationLogObserver;

class TagOperationLog extends Model
{
    protected $fillable = ['uuid', 'tag_data_uuid', 'admin_uuid', 'admin_name', 'action_name', 'properties', 'comment', 'description', 'tag_number', 'tag_name'];

    protected $appends = ['action_desc'];

    protected $casts = [
        'properties' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->getHex()->toString();
        });
    }

    protected static function booted()
    {
        parent::booted();

        TagOperationLog::observe(TagOperationLogObserver::class);
    }

    public function getActionDescAttribute()
    {
        return TagOperationLogActionDesc::getActionDesc($this->action_name);
    }

    public function tag()
    {
        return $this->belongsTo(TagData::class, 'tag_data_uuid', 'uuid');
    }
}
