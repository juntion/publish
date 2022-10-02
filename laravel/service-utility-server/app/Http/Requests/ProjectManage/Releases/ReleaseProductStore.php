<?php

namespace App\Http\Requests\ProjectManage\Releases;

use App\Http\Requests\BaseRequest;

class ReleaseProductStore extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'admin_ids' => 'required|array',
            'admin_ids.*' => 'required|exists:users,id',
            'release_type' => 'required|integer|between:1,3',
            'release_day' => 'required|integer',
            'product_ids' => 'required|array',
            'product_ids.*' => 'required|exists:pm_products,id',
            'online_address' => 'array',
            'online_address.*' => 'url',
            'testing_address' => 'array',
            'testing_address.*' => 'url',
            'description' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '发版产品名称',
            'admin_ids' => '管理员',
            'admin_ids.*' => '管理员ID',
            'release_type' => '发布周期',
            'release_day' => '发布时间',
            'product_ids' => '关联产品',
            'product_ids.*' => '关联产品ID',
            'online_address' => '正式站地址',
            'online_address.*' => '正式站地址',
            'testing_address' => '测试站地址',
            'testing_address.*' => '测试站地址',
            'description' => '简介',
        ];
    }
}
