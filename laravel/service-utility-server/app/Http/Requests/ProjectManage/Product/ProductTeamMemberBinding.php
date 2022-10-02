<?php

namespace App\Http\Requests\ProjectManage\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductTeamMemberBinding extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_user' => 'array',
            'product_user.main_user' => 'required_with:product_user|integer|exists:users,id',
            'product_user.other_user' => 'array',
            'product_user.other_user.*' => 'integer|exists:users,id',
            'product_user.members' => 'array',
            'product_user.members.*' => 'integer|exists:users,id',
            'design_user' => 'array',
            'design_user.*.design_user_id' => 'required_with:design_user|integer|exists:users,id',
            'design_user.*.members' => 'array',
            'design_user.*.members.*.user_id' => 'required_with:design_user.*.members|integer|exists:users,id',
            'design_user.*.members.*.type' => 'required_with:design_user.*.members|integer|between:0,5',
            'dev_user' => 'array',
            'dev_user.main_user' => 'integer|exists:users,id',
            'dev_user.other_user' => 'array',
            'dev_user.other_user.*' => 'integer|exists:users,id',
            'test_user' => 'array',
            'test_user.main_user' => 'integer|exists:users,id',
            'test_user.other_user' => 'array',
            'test_user.other_user.*' => 'integer|exists:users,id',
            'frontend_user' => 'array',
            'frontend_user.main_user' => 'integer|exists:users,id',
            'frontend_user.other_user' => 'array',
            'frontend_user.other_user.*' => 'integer|exists:users,id',
            'mobile_user' => 'array',
            'mobile_user.main_user' => 'integer|exists:users,id',
            'mobile_user.other_user' => 'array',
            'mobile_user.other_user.*' => 'integer|exists:users,id',
        ];

    }

    public function attributes()
    {
        return [
            'product_user' => '产品负责人',
            'product_user.main_user' => '产品主负责人',
            'product_user.other_user' => '产品次负责人',
            'product_user.other_user.*' => '产品次负责人ID',
            'product_user.members' => '产品团队成员',
            'product_user.members.*' => '产品团队成员ID',
            'design_user' => '设计负责人',
            'design_user.*.design_user_id' => '设计负责人ID',
            'design_user.*.members' => '设计负责人成员',
            'design_user.*.members.*.user_id' => '设计团队成员ID',
            'design_user.*.members.*.type' => '设计团队成员类型',
            'dev_user' => '开发负责人',
            'dev_user.main_user' => '开发主负责人ID',
            'dev_user.other_user' => '开发次负责人',
            'dev_user.other_user.*' => '开发次负责人ID',
            'test_user' => '测试负责人',
            'test_user.main_user' => '测试主负责人ID',
            'test_user.other_user' => '测试次负责人',
            'test_user.other_user.*' => '测试次负责人ID',
            'frontend_user' => '前端负责人',
            'frontend_user.main_user' => '前端主负责人ID',
            'frontend_user.other_user' => '前端次负责人',
            'frontend_user.other_user.*' => '前端次负责人ID',
            'mobile_user' => '移动端负责人',
            'mobile_user.main_user' => '移动端主负责人ID',
            'mobile_user.other_user' => '移动端次负责人',
            'mobile_user.other_user.*' => '移动端次负责人ID',
        ];
    }
}
