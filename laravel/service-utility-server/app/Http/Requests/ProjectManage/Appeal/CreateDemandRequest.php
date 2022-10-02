<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use Illuminate\Foundation\Http\FormRequest;

class CreateDemandRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => ['required', 'exists:pm_products,id'],
            'priority' => 'in:1,2,3,4,5',
            'expiration_date' => 'date_format:Y-m-d',
            'source_project_id' => 'exists:pm_projects,id',
            'name' => 'required',
            'content' => 'required',
            'demand_links' => ['required', 'array'],
            'share_address' => 'array',
            'media' => ['array'],
            'media.*' => 'file',
            'attention_user_ids' => ['array'],
            'attention_user_ids.*' => 'exists:users,id',
            'appeal_ids' => 'required|array',
            'appeal_ids.*' => 'required|exists:pm_appeals,id',
            'release_version_ids' => 'array',
            'release_version_ids.*' => 'integer|exists:pm_release_versions,id',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => '产品所属id不能为空',
            'product_id.exists' => '产品所属id无效',
            'priority.in' => '优先级传值无效',
            'expiration_date.date_format' => '截止日期传值格式错误',
            'source_project_id.exists' => '需求来源项目id错误',
            'name.required' => '需求名称不能为空',
            'content.required' => '需求内容不能为空',
            'demand_links.required' => '需求环节至少存在一个',
            'share_address.array' => 'URL/共享地址传值无效',
            'media.array' => '附件传值无效',
            'media.*.file' => '附件传值无效',
            'attention_user_ids.array' => '需关注的用户传值无效',
            'attention_user_ids.*.exists' => '需关注的用户传值无效',
            'appeal_ids.required' => '诉求不能为空',
            'appeal_ids.array' => '诉求必须是数组',
            'appeal_ids.*.exists' => '诉求不存在',
            'release_version_ids' => '纳入版本',
            'release_version_ids.*' => '纳入版本号',
        ];
    }
}
