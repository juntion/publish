<?php

namespace Modules\Share\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class CategoriesRequest extends FormRequest
{
    use PrepareForValidationTrait;

    protected $notMustData = ['sort', 'background'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:20',
                Rule::unique('share_resource_categories', 'name')->where('parent_uuid',
                    $this->request->get('parent_uuid') ?? null),
            ],
            'type' => 'required|in:picture,video',
            'sort' => 'sometimes|integer|between:0,255'
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
