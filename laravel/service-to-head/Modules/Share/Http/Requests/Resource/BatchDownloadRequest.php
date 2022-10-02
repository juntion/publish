<?php

namespace Modules\Share\Http\Requests\Resource;

use Illuminate\Foundation\Http\FormRequest;

class BatchDownloadRequest extends FormRequest
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
            'is_watermark'    => 'in:0,1'
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
