<?php


namespace Modules\Share\Entities;


use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;

class Viewed extends Model
{
    use Searchable;
    protected $table = 'share_vieweds';

    protected $fillable = ['uuid', 'admin_uuid', 'resource_uuid', 'resource_name', 'resource_type'];

    public $timestamps = false;

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_uuid', 'uuid');
    }

    public function toSearchableArray()
    {
        $resource = $this->refresh()->resource;
        $tags = $resource ? $resource->tags() : "";
        $array = [
            'uuid'          => $this->uuid,
            'admin_uuid'    => $this->admin_uuid,
            'resource_name' => $this->resource_name,
            'resource_type' => $this->resource_type,
            'tag_uuid'      => $resource ? $tags->pluck('uuid')->all() : "",
            'tag_name'      => $resource ? implode(',', $tags->pluck('name')->all()) : "",
            'created_at'    => $this->created_at,
        ];
        return $array;
    }
}
