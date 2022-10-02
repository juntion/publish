<?php

namespace Modules\Share\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BatchUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid'          => 'array',
            'uuid.*'        => [
                'required', Rule::exists('share_resources', 'uuid')->where('creator_uuid', Auth::id())
            ],
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
