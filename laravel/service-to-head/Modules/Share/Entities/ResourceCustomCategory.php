<?php


namespace Modules\Share\Entities;


use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\Share\Database\Factories\UploadCategoriesFactory;
use Modules\Share\Entities\Traits\CategoryTrait;

class ResourceCustomCategory extends Model
{
    use CategoryTrait, Searchable;

    protected $table = 'share_resource_custom_categories';

    protected $fillable
        = [
            'uuid', 'admin_uuid', 'type', 'parent_uuid', 'one_level_uuid', 'two_level_uuid', 'three_level_uuid', 'name',
            'sort', 'sum'
        ];

    public function resources()
    {
        return $this->hasMany(Resource::class, 'custom_category_uuid', 'uuid');
    }

    protected static function newFactory()
    {
        return UploadCategoriesFactory::new();
    }
}
