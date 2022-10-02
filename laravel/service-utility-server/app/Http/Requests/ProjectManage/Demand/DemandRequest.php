<?php

namespace App\Http\Requests\ProjectManage\Demand;

use App\Enums\ProjectManage\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DemandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id'                    => ['required', Rule::exists('pm_products','id')->where('type',ProductStatus::TypeProduct)],
            'priority'                      => 'in:1,2,3,4,5',
            'expiration_date'               => 'date_format:Y-m-d',
            'source_project_id'             => 'exists:pm_projects,id',
            'source_bug_id'                 => 'exists:pm_bugs,id',
            'name'                          => 'required',
            'content'                       => 'required',
            'demand_links'                  => ['required', 'array'],
            'share_address'                 => 'array',
            'media'                         => ['array'],
            'media.*'                       => ['file', 'required_with:demand_links.dev'],
            'attention_user_ids'            => ['array'],
            'attention_user_ids.*'          => 'exists:users,id',
            'demand_links.test'             => 'required_with:demand_links.dev',
            'product_modules'               => 'array',
            'product_modules.*.module_id'   => ['required',  Rule::exists('pm_products','id')->where('type',ProductStatus::TypeModule)],
            'product_modules.*.label_ids'   => 'array',
            'product_modules.*.label_ids.*' => [Rule::exists('pm_products','id')->where('type',ProductStatus::TypeCategory)],
            'release_version_ids'           => 'array',
            'release_version_ids.*'         => 'integer|exists:pm_release_versions,id',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required'                  => '产品所属id不能为空',
            'product_id.exists'                    => '产品所属id无效',
            'priority.in'                          => '优先级传值无效',
            'expiration_date.date_format'          => '截止日期传值格式错误',
            'source_project_id.exists'             => '需求来源项目id错误',
            'source_bug_id.exists'                 => '需求来源Bug id错误',
            'name.required'                        => '需求名称不能为空',
            'content.required'                     => '需求内容不能为空',
            'demand_links.required'                => '需求环节至少存在一个',
            'share_address.array'                  => 'URL/共享地址传值无效',
            'media.array'                          => '附件传值无效',
            'media.*.file'                         => '附件传值无效',
            'media.*.required_with'                => '勾选开发环节时附件不能为空',
            'attention_user_ids.array'             => '需关注的用户传值无效',
            'attention_user_ids.array.*.exists'    => '需关注的用户传值无效',
            'demand_links.test.required_with'      => '勾选开发环节必须同时勾选测试环节',
            'product_modules.array'                => '产品模块必须是一个数组',
            'product_modules.*.module_id.required' => '产品模块ID不能为空',
            'product_modules.*.module_id.exists'   => '产品模块ID无效',
            'product_modules.*.label_ids.array'    => '模块标签ID必须是一个数组',
            'product_modules.*.label_ids.*.exists' => '模块标签ID无效',
            'release_version_ids'                  => '纳入版本必须是一个数组',
            'release_version_ids.*'                => '纳入版本号不存在',
        ];
    }
}
