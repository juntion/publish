<?php

namespace Modules\Share\Http\Requests\Tag;

use Modules\Base\Http\Requests\ListRequest;

class TagsListRequest extends ListRequest
{
    public function rules()
    {
        return [
            'filter'            => 'array',
            'filter.deleted_at' => 'in:null,not_null,all',
            'sort.created_at'   => 'in:asc,desc'
        ];
    }

    public function allowSort(): array
    {
        return ['created_at'];
    }

    public function allowFilter(): array
    {
        return [];
    }
}
