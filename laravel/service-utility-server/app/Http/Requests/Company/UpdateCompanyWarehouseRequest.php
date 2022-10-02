<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyWarehouseRequest extends FormRequest
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
            "name.required"                     => "仓库中文名称不能为空",
            "country"                           => "仓库地址所属国家不能为空",
            'old_media.required_without'        => '新增或原来的附件不能都为空！',
            'old_media.array'                   => '原附件传值错误',
            'new_media.required_without'        => '新增或原来的附件不能都为空！',
            'new_media.array'                   => '新增附件应为数组形式',
            'new_media.*.file'                  => '新增附件必须是文件!',
            'en_name.not_regex'                 => '仓库外语名称不能为中文',
            'en_name.required'                  => '仓库外语注名不能为空',
            'en_country.required'               => '仓库外语所属国家不能为空',
            'en_country.not_regex'              => '仓库外语所属国家不能有中文',
            'province.required'                 => '仓库中文地址所属省不能为空',
            'en_province.required'              => '仓库外语地址所属省不能为空',
            'en_province.not_regex'             => '仓库外语地址所属省不能有中文',
            'city.required'                     => '仓库中文地址所属市不能为空',
            'en_city.required'                  => '仓库外语地址所属市不能为空',
            'en_city.not_regex'                 => '仓库外语地址所属市不能有中文',
            'area.required'                     => '仓库中文地址所属区不能为空',
            'en_area.required'                  => '仓库外语地址所属区不能为空',
            'en_area.not_regex'                 => '仓库外语地址所属区不能有中文',
            'address.required'                  => '仓库中文详细地址不能为空',
            'en_address.required'               => '仓库外语详细地址不能为空',
            'en_address.not_regex'              => '仓库外语详细地址不能有中文',
            'postcode.required'                 => '仓库中文邮编不能为空',
            'en_postcode.required'              => '仓库外语邮编不能为空',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('en_name') && $this->request->get('en_name') == null) {
            $this->request->set('en_name',"");
        }
        if ($this->request->has('address') && $this->request->get('address') == null) {
            $this->request->set('address',"");
        }
        if ($this->request->has('en_address') && $this->request->get('en_address') == null) {
            $this->request->set('en_address',"");
        }
        if ($this->request->has('province') && $this->request->get('province') == null) {
            $this->request->set('province',"");
        }
        if ($this->request->has('city') && $this->request->get('city') == null) {
            $this->request->set('city',"");
        }
        if ($this->request->has('area') && $this->request->get('area') == null) {
            $this->request->set('area',"");
        }
        if ($this->request->has('en_country') && $this->request->get('en_country') == null) {
            $this->request->set('en_country',"");
        }
        if ($this->request->has('en_province') && $this->request->get('en_province') == null) {
            $this->request->set('en_province',"");
        }
        if ($this->request->has('en_city') && $this->request->get('en_city') == null) {
            $this->request->set('en_city',"");
        }
        if ($this->request->has('en_area') && $this->request->get('en_area') == null) {
            $this->request->set('en_area',"");
        }
        if ($this->request->has('postcode') && $this->request->get('postcode') == null) {
            $this->request->set('postcode',"");
        }
        if ($this->request->has('en_postcode') && $this->request->get('en_postcode') == null) {
            $this->request->set('en_postcode',"");
        }
    }
}
