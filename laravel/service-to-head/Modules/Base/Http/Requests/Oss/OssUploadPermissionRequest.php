<?php

namespace Modules\Base\Http\Requests\Oss;

use Illuminate\Foundation\Http\FormRequest;

class OssUploadPermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_ext' => 'required|string',
            'mime_type' => 'required|string',
        ];
    }
}
