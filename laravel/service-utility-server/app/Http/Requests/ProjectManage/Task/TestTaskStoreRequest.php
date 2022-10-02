<?php

namespace App\Http\Requests\ProjectManage\Task;

use Illuminate\Foundation\Http\FormRequest;

class TestTaskStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string',
            'priority' => 'integer|between:1,5',
            'expiration_date' => 'required|date',
            'description' => 'required|string',
            'media' => 'array',
            'media.*' => 'file',
            'product_id' => 'integer|exists:pm_products,id',
            'product_modules' => 'array',
            'product_modules.*.module_id' => 'required_with:product_modules|integer|exists:pm_products,id',
            'product_modules.*.label_ids' => 'array',
            'product_modules.*.label_ids.*' => 'integer|exists:pm_products,id',
            'source_project_id' => 'exists:pm_projects,id',
            'share_address' => 'array',
            'main_sub_task' => 'array',
            'main_sub_task.handler_id' => 'required_with:main_sub_task|exists:users,id',
            'main_sub_task.expiration_date' => 'date',
            'main_sub_task.description' => 'string',
            'other_sub_tasks' => 'array',
            'other_sub_tasks.*.handler_id' => 'required_with:other_sub_tasks|exists:users,id',
            'other_sub_tasks.*.expiration_date' => 'date',
            'other_sub_tasks.*.description' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => '负责人ID',
            'title' => '任务标题',
            'priority' => '优先级',
            'expiration_date' => '截至日期',
            'description' => '任务描述',
            'media' => '附件',
            'product_id' => '所属产品ID',
            'product_modules' => '产品模块',
            'product_modules.*.module_id' => '产品模块ID',
            'product_modules.*.label_ids' => '模块标签',
            'product_modules.*.label_ids.*' => '模块标签ID',
            'source_project_id' => '项目来源ID',
            'share_address' => 'URL/共享地址',
            'main_sub_task' => '主跟进人',
            'main_sub_task.handler_id' => '主要跟进人ID',
            'main_sub_task.expiration_date' => '任务截至日期',
            'main_sub_task.description' => '任务分工要求',
            'other_sub_tasks' => '次要跟进人',
            'other_sub_tasks.*.handler_id' => '跟进人ID',
            'other_sub_tasks.*.expiration_date' => '任务截至日期',
            'other_sub_tasks.*.description' => '任务分工要求',
        ];
    }
}
