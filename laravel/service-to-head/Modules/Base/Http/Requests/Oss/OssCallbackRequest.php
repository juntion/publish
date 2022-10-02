<?php

namespace Modules\Base\Http\Requests\Oss;

use Illuminate\Foundation\Http\FormRequest;

class OssCallbackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'object' => 'required|string',
            'bucket' => 'required|string',
            'size'   => 'required|integer',
            'token'  => 'required|string',
        ];
    }
}
