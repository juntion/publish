<?php

namespace Modules\Blog\Entities;

class TagDetail extends Model
{
    protected $table = 'tag_details';

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
