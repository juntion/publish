<?php

namespace Modules\Blog\Entities;

class Tag extends Model
{
    protected $table = 'tags';

    public function details()
    {
        return $this->hasMany(TagDetail::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags')->withPivot(['language_id']);
    }
}
