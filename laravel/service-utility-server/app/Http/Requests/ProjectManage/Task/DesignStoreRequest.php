<?php

namespace App\Http\Requests\ProjectManage\Task;

use Illuminate\Foundation\Http\FormRequest;

class DesignStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'priority' => 'integer|between:1,5',
            'expiration_date' => 'required|date',
            'description' => 'required|string',
            'media' => 'array',
            'media.*' => 'file',
            'design_type' => 'required|integer|between:0,2',
            'parts' => 'required|array',
            'parts.*.type' => 'required|integer|between:0,4',
            'parts.*.user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:pm_products,id',
            'product_modules' => 'array',
            'product_modules.*.module_id' => 'required_with:product_modules|integer|exists:pm_products,id',
            'product_modules.*.label_ids' => 'array',
            'product_modules.*.label_ids.*' => 'integer|exists:pm_products,id',
            'source_project_id' => 'exists:pm_projects,id',
            'share_address' => 'array',
            'release_version_ids' => 'array',
            'release_version_ids.*' => 'integer|exists:pm_release_versions,id',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '任务标题',
            'priority' => '优先级',
            'expiration_date' => '截至日期',
            'description' => '任务描述',
            'media' => '附件',
            'design_type' => '设计类型',
            'parts' => '设计环节',
            'parts.*.type' => '设计环节类型',
            'parts.*.user_id' => '设计环节负责人',
            'product_id' => '所属产品ID',
            'product_modules' => '产品模块',
            'product_modules.*.module_id' => '产品模块ID',
            'product_modules.*.label_ids' => '模块标签',
            'product_modules.*.label_ids.*' => '模块标签ID',
            'source_project_id' => '项目来源ID',
            'share_address' => 'URL/共享地址',
            'release_version_ids' => '纳入版本',
            'release_version_ids.*' => '纳入版本号',
        ];
    }
}
