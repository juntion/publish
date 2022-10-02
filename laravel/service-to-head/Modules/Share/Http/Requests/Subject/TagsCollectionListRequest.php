<?php

namespace Modules\Share\Http\Requests\Subject;

use Modules\Base\Http\Requests\ListRequest;

class TagsCollectionListRequest extends ListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter'        => 'array',
            'filter.type'   => 'in:video,picture',
            'category_uuid' => 'exists:Modules\Share\Entities\ResourceCategory,uuid',
            'tag_uuid'      => 'array',
            'tag_uuid.*'    => 'exists:Modules\Share\Entities\ResourceTag,uuid',
        ];
    }

    public function allowFilter(): array
    {
        return ['type'];
    }

    public function allowSort(): array
    {
        return [];
    }
}
