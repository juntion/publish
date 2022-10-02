<?php

namespace Modules\Share\Http\Requests\Subject;

use Modules\Base\Http\Requests\ListRequest;

class SubjectListRequest extends ListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter'            => 'array',
            'filter.deleted_at' => 'in:null,not_null,all'
        ];
    }

    public function allowSort(): array
    {
        return [];
    }

    public function allowFilter(): array
    {
        return [];
    }
}
