<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait RelatedChangesTrait
{
    /**
     * 关联更新
     * @return array
     */
    public function getRelatedChanges()
    {
        $changes = [];
        $cacheChanges = $this->getUpdatedCacheInstance()->get($this->getUpdatedCacheKey());
        if ($cacheChanges) {
            $changes = json_decode($cacheChanges, true);
            $this->getUpdatedCacheInstance()->forget($this->getUpdatedCacheKey());
        }
        return $changes;
    }

    public function getUpdatedCacheInstance()
    {
        return Cache::tags(['pm', 'updateInfo', class_basename($this)]);
    }

    public function getUpdatedCacheKey()
    {
        return $this->id . '_' . Auth::id();
    }
}
