<?php

namespace Modules\Share\Entities\Traits;

trait CategoryTrait
{
    public function getLevelAttribute()
    {
        if ($this->parent_uuid == null) {
            return 1;
        } elseif ($this->uuid == $this->two_level_uuid) {
            return 2;
        } elseif ($this->uuid == $this->three_level_uuid) {
            return 3;
        } else {
            return 4;
        }
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_uuid', 'uuid');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_uuid', 'uuid');
    }
}
