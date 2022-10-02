<?php

namespace Modules\Share\Http\Requests\Admin\Collection;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class CollectionRequest extends FormRequest
{
    use PrepareForValidationTrait;

    protected $notMustData = ['category_uuid'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'resource_uuid' => 'required|exists:Modules\Share\Entities\Resource,uuid',
            'category_uuid' => 'sometimes|exists:Modules\Share\Entities\CollectionCategory,uuid'
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
