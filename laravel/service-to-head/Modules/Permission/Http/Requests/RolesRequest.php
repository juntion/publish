<?php

namespace Modules\Permission\Http\Requests;

use Modules\Base\Http\Requests\ListRequest;

class RolesRequest extends ListRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'filter.guard_name' => 'sometimes|in:admin,customer,supplier',
                'filter.name' => 'sometimes|regex:/^[a-z]+(\.[a-z]+)*$/',
                'sort.name' => 'sometimes|in:asc,desc',
                'sort.created_at' => 'sometimes|in:asc,desc',
                'sort.updated_at' => 'sometimes|in:asc,desc'
            ]
        );
    }

    public function allowFilter(): array
    {
        return ['guard_name', 'name'];
    }

    public function allowSort(): array
    {
        return ['name','created_at','updated_at'];
    }
}
