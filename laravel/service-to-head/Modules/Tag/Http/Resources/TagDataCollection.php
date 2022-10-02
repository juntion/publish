<?php

namespace Modules\Tag\Http\Resources;

use Modules\Base\Http\Resources\Json\ResourceCollection;
use Modules\Tag\Entities\TagData;
use Modules\Tag\Enums\TagDataStatus;

class TagDataCollection extends ResourceCollection
{
    static public $wrap = "tags";

    public function toArray($request)
    {
        return $this->collection->map(function (TagData $tag) {
            return [
                'uuid' => $tag->uuid,
                'number' => $tag->number,
                'name' => $tag->name,
                'parent_uuid' => $tag->parent_uuid,
                'path' => $tag->path,
                'level' => $tag->level,
                'status' => $tag->status,
                'status_desc' => TagDataStatus::getStatusDesc($tag->status),
                'locale' => $tag->locale,
                'type' => $tag->type,
                'url_name' => $tag->url_name,
                'avatar' => $tag->avatar,
                'created_at' => $this->getZoneDatetime($tag->created_at),
                'updated_at' => $this->getZoneDatetime($tag->updated_at),
            ];
        })->all();
    }
}
