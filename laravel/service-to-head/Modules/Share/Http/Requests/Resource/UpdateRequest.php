<?php

namespace Modules\Share\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'category_uuid' => 'required|exists:Modules\Share\Entities\ResourceCategory,uuid',
            'tag_uuid'      => 'array',
            'tag_uuid.*'    => 'exists:Modules\Share\Entities\ResourceTag,uuid',
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
