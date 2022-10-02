<?php


namespace Modules\Share\Entities;


use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Facades\OssService;
use Modules\Base\Support\Search\Searchable;
use Modules\Share\Database\Factories\ResourceFactory;
use Modules\Share\Entities\Traits\ResourceUpdateLogTrait;

class Resource extends Model
{
    use Searchable, ResourceUpdateLogTrait;
    protected $table = 'share_resources';

    protected $fillable = [
        'uuid', 'creator_uuid', 'creator_name', 'custom_category_uuid', 'type', 'name', 'object', 'size', 'mime_type', 'format', 'collection_num', 'download_num', 'object_height_500_width_930', 'object_height_216_width_216', 'duration'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->object_height_216_width_216 = $model->setObject($model, 1);
            $model->object_height_500_width_930 = $model->setObject($model, 2);
        });
    }

    protected function setObject($model, $zoomType = 1)
    {
        if ($model->type == 'picture') {
            if ($zoomType == 1) {
                $process = "m_pad,h_216,w_216,color_E6EAEB";
            } else {
                $process = "m_pad,h_500,w_930,color_E6EAEB";
            }
        } else {
            if ($zoomType == 1) {
                $process = "t_0,f_jpg,w_216,h_216,m_fast";
            } else {
                $process = "t_0,f_jpg,w_930,h_500,m_fast";
            }
        }
        try {
            $object = $this->getZoomObjectByOriginObject($model, $process);
        } catch (\Exception $exception) {
            return "";
        }
        if ($object) {
            return $object['object'];
        }
        return "";
    }

    protected function getZoomObjectByOriginObject($model, $process)
    {
        if ($model->type == 'picture') {
            return OssService::imageResize($model->object, $process, true);
        } else {
            return OssService::videoSnapshot($model->object, $process, true);
        }
    }

    public function collection()
    {
        return $this->hasMany(Collection::class, 'resource_uuid', 'uuid')->where('admin_uuid', Auth::id());
    }

    public function tags()
    {
        return $this->belongsToMany(ResourceTag::class, 'share_resources_to_tags', 'resource_uuid', 'tag_uuid')->withPivot('admin_uuid', 'admin_name')->withTrashed();
    }

    public function categories()
    {
        return $this->belongsToMany(ResourceCategory::class, 'share_resources_to_categories','resource_uuid', 'category_uuid')->withPivot('admin_uuid', 'admin_name')->withTrashed();
    }

    public function customCategory()
    {
        return $this->belongsTo(ResourceCustomCategory::class, 'custom_category_uuid', 'uuid');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'share_subject_to_resources', 'resource_uuid',
            'subject_uuid')->withTrashed();
    }

    public function downloads()
    {
        return $this->hasMany(ResourceDownload::class, 'resource_uuid', 'uuid');
    }

    public function vieweds()
    {
        return $this->hasMany(Viewed::class, 'resource_uuid', 'uuid');
    }

    /**
     * 获取文件指定的宽度 sso url
     */
    public function getImageUrlHeight216Width216Attribute()
    {
        return $this->object_height_216_width_216 ? OssService::getSignUrl($this->object_height_216_width_216) : "";
    }

    public function getImageUrlHeight500Width930Attribute()
    {
        return $this->object_height_500_width_930 ? OssService::getSignUrl($this->object_height_500_width_930) : "";
    }

    public function getIsCollectionAttribute()
    {
        return $this->collection()->where('admin_uuid', Auth::id())->count();
    }

    public function toSearchableArray()
    {
        $resource = $this->refresh();
        $tags = $resource->tags;
        $cates = $resource->categories;
        $subjects = $resource->subjects;
        $array = [
            'uuid'                 => $this->uuid,
            'name'                 => $this->name,
            'type'                 => $this->type,
            'custom_category_uuid' => $this->custom_category_uuid,
            'tag_uuid'             => $tags->pluck('uuid')->all(),
            'tag_name'             => implode(',', $tags->pluck('name')->all()),
            'cate_uuid'            => $cates->pluck('uuid')->all(),
            'subject'              => $subjects->pluck('uuid')->all(),
            'created_at'           => $this->created_at,
            'creator_uuid'         => $this->creator_uuid,
        ];
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
        return ResourceFactory::new();
    }
}
