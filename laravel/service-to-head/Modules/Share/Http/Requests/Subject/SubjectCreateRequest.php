<?php

namespace Modules\Share\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Share\Http\Requests\PrepareForValidationTrait;

class SubjectCreateRequest extends FormRequest
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
            'name'            => 'required|max:255|unique:Modules\Share\Entities\Subject,name',
            'sort'            => 'sometimes|integer|between:0,255',
            'background_uuid' => 'required|exists:Modules\Base\Entities\Base\OssTempUpload,uuid'
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
