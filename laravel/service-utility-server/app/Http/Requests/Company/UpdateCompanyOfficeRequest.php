<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyOfficeRequest extends FormRequest
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
            "name"          => "required",
            "country"       => "required",
            'old_media'     => ['array'],
            'new_media'     => ['array'],
            'new_media.*'   => 'file',
            "en_name"       => ["not_regex:/[\x7f-\xff]/",'required'],// 非中文
            'en_country'    => ["not_regex:/[\x7f-\xff]/", 'required'],// 非中文
            'province'      => ['required'],
            'en_province'   => ["not_regex:/[\x7f-\xff]/", 'required'],
            'city'          => ['required'],
            'en_city'       => ["not_regex:/[\x7f-\xff]/", 'required'],
            'area'          => ['required'],
            'en_area'       => ["not_regex:/[\x7f-\xff]/", 'required'],
            'address'       => ['required'],
            'en_address'    => ["not_regex:/[\x7f-\xff]/", 'required'],
            'postcode'      => ['required'],
            'en_postcode'   => ['required'],
        ];
    }

    public function messages()
    {
        return [
            "name.required"                     => "办公室中文名称不能为空",
            "country.required"                  => "办公室地址所属国家不能为空",
            'old_media.required_without'        => '新增或原来的附件不能都为空！',
            'old_media.array'                   => '原附件传值错误',
            'new_media.required_without'        => '新增或原来的附件不能都为空！',
            'new_media.array'                   => '新增附件应为数组形式',
            'new_media.*.file'                  => '新增附件必须是文件!',
            'en_name.not_regex'                 => '办公室外语名称不能为中文',
            'en_name.required'                  => '办公室外语注名不能为空',
            'en_country.required'               => '办公室外语国家不能为空',
            'en_country.not_regex'              => '办公室外语国家不能有中文',
            'province.required'                 => '办公室中文地址所属省不能为空',
            'en_province.required'              => '办公室外语地址所属省不能为空',
            'en_province.not_regex'             => '办公室外语地址所属省不能有中文',
            'city.required'                     => '办公室中文地址所属市不能为空',
            'en_city.required'                  => '办公室外语地址所属市不能为空',
            'en_city.not_regex'                 => '办公室外语地址所属市不能有中文',
            'area.required'                     => '办公室中文地址所属区不能为空',
            'en_area.required'                  => '办公室外语地址所属区不能为空',
            'en_area.not_regex'                 => '办公室外语地址所属区不能有中文',
            'address.required'                  => '办公室中文详细地址不能为空',
            'en_address.required'               => '办公室外语详细地址不能为空',
            'en_address.not_regex'              => '办公室外语详细地址不能有中文',
            'postcode.required'                 => '办公室中文邮编不能为空',
            'en_postcode.required'              => '办公室外语邮编不能为空',
        ];
    }

    protected function prepareForValidation()
    {

    }
}
