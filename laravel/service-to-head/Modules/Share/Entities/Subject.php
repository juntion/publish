<?php


namespace Modules\Share\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Facades\OssService;
use Modules\Base\Support\Search\Searchable;

class Subject extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'share_subjects';

    protected $fillable = ['uuid', 'sort', 'name', 'object'];

    public function resources()
    {
        return $this->hasManyThrough(Resource::class, SubjectToResource::class, 'subject_uuid', 'uuid','uuid','resource_uuid');
    }

    public function getImageUrlAttribute()
    {
        return OssService::getSignUrl($this->object);
    }
}
