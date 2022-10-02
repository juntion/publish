<?php


namespace Modules\Share\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\Share\Database\Factories\TagsFactory;

class ResourceTag extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'share_resource_tags';

    protected $fillable = ['uuid', 'name', 'creator_uuid'];

    public $timestamps = false;

    public function resources()
    {
        return $this->hasManyThrough(Resource::class, ResourcesToTag::class, 'tag_uuid', 'uuid', 'uuid', 'resource_uuid');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    public function getScoutKey()
    {
        return $this->uuid;
    }


    public function getScoutKeyName()
    {
        return 'uuid';
    }

    protected static function newFactory()
    {
        return TagsFactory::new();
    }

}
