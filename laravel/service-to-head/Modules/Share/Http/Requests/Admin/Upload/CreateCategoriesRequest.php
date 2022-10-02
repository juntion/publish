<?php

namespace Modules\Share\Http\Requests\Admin\Upload;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class CreateCategoriesRequest extends FormRequest
{
    use PrepareForValidationTrait;

    protected $notMustData = ['sort'];

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
                Rule::unique('share_resource_custom_categories', 'name')
                    ->where('admin_uuid', Auth::id())
                    ->where('type', $this->request->get('type'))
                    ->where('parent_uuid', $this->request->get('parent_uuid') ?? null),
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
