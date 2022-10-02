<?php

namespace Modules\Admin\Http\Requests;

use Modules\Base\Http\Requests\ListRequest;

class AdminsRequest extends ListRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'filter.email' => 'sometimes|email',
//                'filter.name' => 'sometimes|regex:/^[a-z]+(\.[a-z]+)*$/',
                'sort.name' => 'sometimes|in:asc,desc',
                'sort.created_at' => 'sometimes|in:asc,desc',
                'sort.updated_at' => 'sometimes|in:asc,desc'
            ]
        );
    }

    public function allowFilter(): array
    {
        return ['name', 'email'];
    }

    public function allowSort(): array
    {
        return ['name', 'created_at', 'updated_at'];
    }
}
