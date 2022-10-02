<?php

namespace Modules\Tag\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;

class TagOperationLogCollection extends ResourceCollection
{
    static public $wrap = "operationLogs";

    public function toArray($request)
    {
        return $this->collection->map(function ($operationLog) {
            return $operationLog->toArray();
        })->all();
    }
}
