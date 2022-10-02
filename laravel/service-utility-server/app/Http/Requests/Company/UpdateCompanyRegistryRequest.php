<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use function Complex\theta;

class UpdateCompanyRegistryRequest extends FormRequest
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
            "tax"              => ['array'],
            "tax.*.tax_number" => ['required'],
            "tax.*.country"    => ['required'],
            'old_media'        => ['array'],
            'new_media'        => ['array'],
            'new_media.*'      => 'file',
            'name'             => ['required'],
            "en_name"          => ["not_regex:/[\x7f-\xff]/", 'required'],// 非中文
            "country"          => ['required'],
            'en_country'       => ["not_regex:/[\x7f-\xff]/", 'required'],// 非中文
            'province'         => ['required'],
            'en_province'      => ["not_regex:/[\x7f-\xff]/", 'required'],
            'city'             => ['required'],
            'en_city'          => ["not_regex:/[\x7f-\xff]/", 'required'],
            'area'             => ['required'],
            'en_area'          => ["not_regex:/[\x7f-\xff]/", 'required'],
            'address'          => ['required'],
            'en_address'       => ["not_regex:/[\x7f-\xff]/", 'required'],
        ];
    }

    public function messages()
    {
        return [
            "tax.*.country.required"     => "税务国家信息不能为空",
            "tax.*.tax_number.required"  => "税号信息不能为空",
            'old_media.required_without' => '新增或原来的附件不能都为空！',
            'old_media.array'            => '原附件传值错误',
            'new_media.required_without' => '新增或原来的附件不能都为空！',
            'new_media.array'            => '新增附件应为数组形式',
            'new_media.*.file'           => '新增附件必须是文件!',
            'name.required'              => '中文注册名称不能为空',
            'en_name.not_regex'          => '外语注册名称不能有中文',
            'en_name.required'           => '外语注册名不能为空',
            'country.required'           => '中文注册国家不能为空',
            'en_country.required'        => '外语注册国家不能为空',
            'en_country.not_regex'       => '外语注册国家不能有中文',
            'province.required'          => '中文注册省不能为空',
            'en_province.required'       => '外语注册省不能为空',
            'en_province.not_regex'      => '外语注册省不能有中文',
            'city.required'              => '中文注册市不能为空',
            'en_city.required'           => '外语注册市不能为空',
            'en_city.not_regex'          => '外语注册市不能有中文',
            'area.required'              => '中文注册区不能为空',
            'en_area.required'           => '外语注册区不能为空',
            'en_area.not_regex'          => '外语注册区不能有中文',
            'address.required'           => '中文注册详细地址不能为空',
            'en_address.required'        => '外语注册详细地址不能为空',
            'en_address.not_regex'       => '外语注册详细地址不能有中文',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('postcode') && $this->request->get('postcode') == null) {
            $this->request->set('postcode',"");
        }
        if ($this->request->has('en_postcode') && $this->request->get('en_postcode') == null) {
            $this->request->set('en_postcode',"");
        }
        if ($this->request->has('contacts') && $this->request->get('contacts') == null) {
            $this->request->set('contacts',"");
        }
        if ($this->request->has('tel') && $this->request->get('tel') == null) {
            $this->request->set('tel',"");
        }
        if ($this->request->has('en_tel') && $this->request->get('en_tel') == null) {
            $this->request->set('en_tel',"");
        }
    }

}
