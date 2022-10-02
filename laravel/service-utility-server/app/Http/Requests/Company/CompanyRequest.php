<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            "type"                => ['required', "in:1,2,3"],
            "company_simple_name" => ["required", "max:10"],
            "main_tag"            => ["required", "max:5", "regex:/[A-Za-z]/"],
            "company_name"        => "required",
            "company_english_name"=> ["required", "not_regex:/[\x7f-\xff]/"],// 非中文
            "p_id"                => "required_if:type,2,3",
            "country"             => "required",
            "time_zone"           => ['required']
        ];
    }

    public function messages()
    {
       return [
           "type.required"                => "必须设置公司类型",
           "type.in"                      => "公司类型传值错误",
           "company_simple_name.required" => "必须填写公司简称",
           "main_tag.required"            => "必须填写公司主体标识",
           "company_name.required"        => "必须填写公司中文名称",
           "company_english_name.required"=> "必须填写公司外文名称",
           "p_id.required_if"             => "非母公司时必须选择父级公司",
           "country.required"             => "必须填写公司国家",
           "company_simple_name.max"      => "公司简称最大长度为10",
           "main_tag.max"                 => "主体标识最大长度为5",
           "main_tag.regex"               => "主体标识只能是英文字符",
           "company_english_name.not_regex" => "外语名称不能为中文",
           "time_zone.required"           => "时差不能为空"
       ];
    }


    protected function prepareForValidation()
    {
        if ($this->request->has('time_zone') && $this->request->get('time_zone') == null) {
            $this->request->set('time_zone',0);
        }
    }
}
