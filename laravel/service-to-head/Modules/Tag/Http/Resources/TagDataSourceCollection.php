<?php

namespace Modules\Tag\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class TagDataSourceCollection extends ResourceCollection
{
    static public $wrap = "tagDataSources";

    public function toArray($request)
    {
        return $this->collection->map(function ($tagBinding) {
            return $tagBinding->toArray();
        })->all();
    }
}
