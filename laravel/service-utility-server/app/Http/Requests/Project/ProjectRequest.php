<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name'              => 'required',
            'principal_user_id' => ['required','exists:users,id'],
            'expiration_date'   => 'required|date_format:Y-m-d',
            'contents'          => 'required',
            'status'            => ['required','in:0,1'],
            'level'             => ['required','in:S,A,B,C,D'],
            'difficulty'        => ['required','in:1,2,3,4,5'],
            'product_id'        => 'exists:pm_products,id',
            'product_user_ids'     => 'array',
            'product_user_ids.*'   => 'exists:users,id',
            'design_user_ids'      => 'array',
            'design_user_ids.*'    => 'exists:users,id',
            'dev_user_ids'         => 'array',
            'dev_user_ids.*'       => 'exists:users,id',
            'test_user_ids'        => 'array',
            'test_user_ids.*'      => 'exists:users,id',
            'business_user_ids'    => 'array',
            'business_user_ids.*'  => 'exists:users,id',
            'attention_user_ids'=> 'array',
            'attention_user_ids.*' => 'exists:users,id',
            'media'             => 'array',
            'media.*'           => 'file',
        ];
    }

    public function messages()
    {
       return [
           'name.required'                 => '项目名称不能为空',
           'principal_user_id.required'    => '负责人不能为空',
           'expiration_date.date_format'   => '项目截至时间格式错误',
           'contents.required'             => '项目内容不能为空',
           'status.required'               => '项目状态不能为空',
           'status.in'                     => '项目状态值错误',
           'level.required'                => '项目级别不能为空',
           'level.in'                      => '项目级别值错误',
           'difficulty.required'           => '项目难度不能为空',
           'difficulty.in'                 => '项目难度值错误',
           'product_id.exists'             => '项目所属产品错误，无对应产品',
           'product_user_ids.*.exists'     => '产品负责人错误！无对应人员！',
           'design_user_ids.*.exists'      => '设计负责人错误！无对应人员！',
           'dev_user_ids.*.exists'         => '开发负责人错误！无对应人员！',
           'test_user_ids.*.exists'        => '测试负责人错误！无对应人员！',
           'product_user_ids.array'        => '产品负责人错误！必须是数组',
           'design_user_ids.array'         => '设计负责人错误！必须是数组',
           'dev_user_ids.array'            => '开发负责人错误！必须是数组！',
           'test_user_ids.array'           => '测试负责人错误！必须是数组！',
           'attention_user_ids.*.exists'   => '关注人员错误!无对应人员！',
           'media.array'                   => '附件必须是数组格式！',
           'media.*.file'                  => '附件必须是文件'
       ];
    }


    public function prepareForValidation()
    {
        // 传空值
        if ($this->request->has('shared_address') &&
            (!$this->request->get('shared_address')[0] || $this->request->get('shared_address')[0] == "")) {
            $this->request->remove("shared_address");
        }
    }
}
