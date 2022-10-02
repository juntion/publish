<?php

namespace Modules\Admin\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'required|image|dimensions:width=100,height=100'
        ];
    }
}
