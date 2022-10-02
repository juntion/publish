<?php


namespace Modules\Share\Entities;


use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\Share\Database\Factories\CollectionCategoriesFactory;
use Modules\Share\Entities\Traits\CategoryTrait;

class CollectionCategory extends Model
{
    use CategoryTrait, Searchable;

    protected $table = 'share_collection_categories';

    protected $fillable
        = [
            'uuid', 'admin_uuid', 'type', 'parent_uuid', 'one_level_uuid', 'two_level_uuid', 'three_level_uuid', 'name',
            'sort', 'sum'
        ];

    protected static function newFactory()
    {
        return CollectionCategoriesFactory::new();
    }

    public function resources()
    {
        return $this->hasManyThrough(Resource::class, Collection::class, 'category_uuid', 'uuid', 'uuid',
            'resource_uuid');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'category_uuid', 'uuid');
    }
}
