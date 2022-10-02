<?php

namespace App\Http\Requests\ProjectManage\Bug;

use Illuminate\Foundation\Http\FormRequest;

class BugsPrincipalUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'frontend_program_user_id' => 'required|exists:users,id',
            'frontend_product_user_id' => 'required|exists:users,id',
            'backend_program_user_id'  => 'required|exists:users,id',
            'backend_product_user_id'  => 'required|exists:users,id',
            'test_user_id'             => 'required|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'frontend_program_user_id' => '前台程序负责人',
            'frontend_product_user_id' => '前台产品负责人',
            'backend_program_user_id'  => '后台程序负责人',
            'backend_product_user_id'  => '后台产品负责人',
            'test_user_id'             => '测试负责人',
        ];
    }
}
