<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'bail|required|max:255|regex:/^[a-z]+(\.[a-z]+)*$/',// 格式为 aaa     aaa.bbb    aaa.bbb.ccc
        ];
    }
}
