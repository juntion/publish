<?php

namespace Modules\Share\Http\Requests\Categories;

use Modules\Base\Http\Requests\ListRequest;

class TopCategoriesRequest extends ListRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filter'      => 'array',
            'filter.type' => 'required|in:picture,video'
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

    public function authorize()
    {
        return true;
    }
}
