<?php

namespace Modules\Route\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMenuRoutesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['routes' => 'present|array'];
    }
}
