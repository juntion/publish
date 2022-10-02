<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:admins',
            'name' => 'bail|required|max:255|regex:/^[a-z]+(\.[a-z]+)*$/|unique:admins',// 格式为 aaa     aaa.bbb    aaa.bbb.ccc
        ];
    }
}
