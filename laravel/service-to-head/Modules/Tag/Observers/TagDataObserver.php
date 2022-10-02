<?php

namespace Modules\Tag\Observers;

use Modules\Tag\Entities\TagData;
use Modules\Tag\Enums\TagDataColumn;
use Modules\Tag\Enums\TagDataStatus;
use Modules\Tag\Enums\TagDataType;

class TagDataObserver
{
    /**
     * @param TagData $tag
     */
    public function updating(TagData $tag)
    {
        if ($tag->getOriginal('parent_uuid') != $tag->parent_uuid) {
            [$path, $level] = TagData::newPathAndLevel($tag->parent_uuid);
            $tag->path = $path;
            $tag->level = $level;
        }
    }

    /**
     * @param TagData $tag
     */
    public function created(TagData $tag)
    {
        $tag->createOperationLog();
    }

    /**
     * @param TagData $tag
     */
    public function updated(TagData $tag)
    {
        $properties = [];
        $changes = array_keys($tag->getChanges());
        foreach ($changes as $change) {
            if (in_array($change, TagData::LOG_ATTRIBUTES)) {
                if ($change == 'parent_uuid') {
                    $old = ($oldParent = TagData::query()->find($tag->getOriginal('parent_uuid'))) ? $oldParent->name : '';
                    $new = ($newParent = TagData::query()->find($tag->parent_uuid)) ? $newParent->name : '';
                } else if ($change == 'status') {
                    $old = TagDataStatus::getStatusDesc($tag->getOriginal('status'));
                    $new = TagDataStatus::getStatusDesc($tag->status);
                } else if ($change == 'type') {
                    $old = TagDataType::getTypeDesc($tag->getOriginal('type'));
                    $new = TagDataType::getTypeDesc($tag->type);
                } else {
                    $old = $tag->getOriginal($change);
                    $new = $tag->{$change};
                }
                $properties[] = [
                    'name' => TagDataColumn::COLUMN_DESC[$change],
                    'old' => $old,
                    'new' => $new,
                ];
            }
        }
        $tag->createOperationLog($properties);
    }

    public function deleted(TagData $tag)
    {
        $tag->createOperationLog();
    }
}
