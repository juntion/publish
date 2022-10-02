<?php

namespace Modules\Route\Http\Requests;

use Modules\Base\Http\Requests\ListRequest;

class RoutesRequest extends ListRequest
{
    public function authorize()
    {
        if (!$this->isPaginate() && !$this->query('filter')['guard_name']) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                'filter.guard_name' => 'sometimes|in:admin,customer,supplier',
                'filter.type' => 'sometimes|in:2,3',
                'filter.name' => 'sometimes|regex:/^[a-z]+(\.[a-z]+)*$/',
                'sort.name' => 'sometimes|in:asc,desc',
                'sort.created_at' => 'sometimes|in:asc,desc',
                'sort.updated_at' => 'sometimes|in:asc,desc'
            ]
        );
    }

    public function allowFilter(): array
    {
        return ['guard_name', 'name', 'type'];
    }

    public function allowSort(): array
    {
        return ['name', 'created_at', 'updated_at'];
    }
}
