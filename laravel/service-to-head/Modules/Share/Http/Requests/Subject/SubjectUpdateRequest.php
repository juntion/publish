<?php

namespace Modules\Share\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class SubjectUpdateRequest extends FormRequest
{
    use PrepareForValidationTrait;

    protected $notMustData = ['sort', 'background_uuid'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'            => [
                'required',
                'max:255',
                Rule::unique('share_subjects', 'name')->ignore($this->uuid, 'uuid')
            ],
            'sort'            => 'sometimes|integer|between:0,255',
            'background_uuid' => 'exists:Modules\Base\Entities\Base\OssTempUpload,uuid'
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
