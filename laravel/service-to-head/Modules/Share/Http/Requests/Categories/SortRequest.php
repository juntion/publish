<?php

namespace Modules\Share\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort'        => 'required|array',
            'sort.*.uuid' => [
                'required',
                Rule::exists('share_resource_categories', 'uuid')
                    ->where('type', $this->type)
            ],
            'sort.*.sort' => 'required|integer|between:0,255'
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
}
