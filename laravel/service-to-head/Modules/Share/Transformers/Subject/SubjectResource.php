<?php


namespace Modules\Share\Transformers\Subject;


use Modules\Base\Http\Resources\Json\Resource;

class SubjectResource extends Resource
{
    public static $wrap = 'subject';

    public function toArray($request)
    {
        return [
            'uuid'       => $this->uuid,
            'name'       => $this->name,
            'sort'       => $this->sort,
            'deleted_at' => $this->getZoneDatetime($this->deleted_at),
            'created_at' => $this->getZoneDatetime($this->created_at),
            'updated_at' => $this->getZoneDatetime($this->updated_at),
            'image_url'  => $this->image_url,
        ];
    }
}
