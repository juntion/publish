<?php

namespace Modules\Share\Http\Requests\Admin\Upload;

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
            'filter.type' => 'required|in:video,picture'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function allowSort(): array
    {
        return [];
    }

    public function allowFilter(): array
    {
        return ['type'];
    }
}
