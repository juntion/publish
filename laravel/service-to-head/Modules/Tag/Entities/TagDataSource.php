<?php

namespace Modules\Tag\Entities;

use Illuminate\Support\Str;
use Modules\Base\Entities\Model;
use Modules\Base\Support\Search\Searchable;
use Modules\Tag\Database\Factories\TagDataSourceFactory;

class TagDataSource extends Model
{
    use Searchable;

    protected $table = 'tag_data_source';

    protected $fillable = [
        'tag_data_uuid', 'model_id', 'model_type', 'model_desc', 'priority', 'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->getHex()->toString();
        });
    }

    public function tag()
    {
        return $this->belongsTo(TagData::class, 'tag_data_uuid');
    }

    public function toSearchableArray()
    {
        $tag = $this->refresh()->tag;
        return [
            'uuid' => $this->uuid,
            'tag_data_uuid' => $this->tag_data_uuid,
            'tag_name' => $tag->name,
            'tag_number' => $tag->number,
            'tag_locale' => $tag->locale,
            'tag_type' => $tag->type,
            'model_id' => $this->model_id,
            'model_type' => $this->model_type,
            'model_desc' => $this->model_desc,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    protected static function newFactory()
    {
        return TagDataSourceFactory::new();
    }
}
