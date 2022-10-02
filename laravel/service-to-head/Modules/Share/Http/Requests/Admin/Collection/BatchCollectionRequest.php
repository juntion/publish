<?php

namespace Modules\Share\Http\Requests\Admin\Collection;

use Illuminate\Foundation\Http\FormRequest;

class BatchCollectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'resource_uuid'   => 'array',
            'resource_uuid.*' => 'required|exists:Modules\Share\Entities\Resource,uuid',
            'category_uuid'   => 'exists:Modules\Share\Entities\CollectionCategory,uuid'
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
