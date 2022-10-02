<?php


namespace Modules\Share\Entities\Traits;

use Modules\Share\Entities\CategoryTreeCache;

trait CategoryCacheTrait
{
    public static function bootCategoryCacheTrait()
    {
        static::forceDeleted(function ($modal) {
            $type = $modal->type;
            (new CategoryTreeCache())->forget($type);
        });

        static::creating(function ($modal) {
            $type = $modal->type;
            (new CategoryTreeCache())->forget($type);
        });
    }
}
