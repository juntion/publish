<?php


namespace App\Http\Requests\ProjectManage\Demand;


use Illuminate\Foundation\Http\FormRequest;

class DemandUpdateRequest extends FormRequest
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
        $rules =  [
            'product_id'           => ['required','exists:pm_products,id'],
            'priority'             => 'in:1,2,3,4,5',
            'expiration_date'      => 'date_format:Y-m-d',
            'source_project_id'    => 'exists:pm_projects,id',
            'name'                 => 'required',
            'content'              => 'required',
            'demand_links'         => ['required', 'array'],
            'share_address'        => 'array',
            'attention_user_ids'   => ['array'],
            'attention_user_ids.*' => 'exists:users,id',
            'old_media'            => ['array'],
            'new_media'            => ['array'],
            'new_media.*'          => 'file',
            'release_version_ids' => 'array',
            'release_version_ids.*' => 'integer|exists:pm_release_versions,id',
        ];
        $demand_links = $this->request->get('demand_links');
        if (isset($demand_links['dev'])){
            $rules['old_media'] = ['required_without:new_media', 'array'];
            $rules['new_media'] = ['required_without:old_media', 'array'];
        }
        return  $rules;
    }

    public function messages()
    {
        return [
            'product_id.required'               => '产品所属id不能为空',
            'product_id.exists'                 => '产品所属id无效',
            'priority.in'                       => '优先级传值无效',
            'expiration_date.date_format'       => '截止日期传值格式错误',
            'source_project_id.exists'          => '需求来源项目id错误',
            'name.required'                     => '需求名称不能为空',
            'content.required'                  => '需求内容不能为空',
            'demand_links.required'             => '需求环节至少存在一个',
            'share_address.array'               => 'URL/共享地址传值无效',
            'media.array'                       => '附件传值无效',
            'media.*.file'                      => '附件传值无效',
            'attention_user_ids.array'          => '需关注的用户传值无效',
            'attention_user_ids.array.*.exists' => '需关注的用户传值无效',
            'old_media.required_without'        => '勾选开发环节时新增或原来的附件不能都为空！',
            'old_media.array'                   => '原附件传值错误',
            'new_media.required_without'        => '勾选开发环节时新增或原来的附件不能都为空！',
            'new_media.array'                   => '新增附件应为数组形式',
            'new_media.*.file'                  => '新增附件必须是文件！',
            'release_version_ids'               => '纳入版本必须是一个数组',
            'release_version_ids.*'             => '纳入版本号不存在',
        ];
    }

    public function prepareForValidation()
    {
        if($this->request->get('source_project_id') == 0 ||$this->request->get('source_project_id') == "" ){
            $this->request->remove("source_project_id");
            $this->request->remove("source_project_name");
        }
        if($this->request->get('priority') == 0){
            $this->request->remove("priority");
        }
    }
}
