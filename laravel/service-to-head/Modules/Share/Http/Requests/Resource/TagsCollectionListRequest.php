<?php

namespace Modules\Share\Http\Requests\Resource;

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
            'filter'          => 'required|array',
            'filter.type'     => 'required|in:video,picture',
            'sort'            => 'array',
            'sort.created_at' => 'in:desc,asc'
        ];
    }

    public function allowFilter(): array
    {
        return ['type', 'creator_uuid'];
    }

    public function allowSort(): array
    {
        return ['created_at'];
    }
}
