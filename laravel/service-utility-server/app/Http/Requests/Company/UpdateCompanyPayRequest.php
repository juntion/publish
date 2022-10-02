<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyPayRequest extends FormRequest
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
            'bank_name'                     => 'required',
            'other_info'                    => 'json',
            'account_info'                  => ['array', 'required'],
            'account_name'                  => 'required',
            'account_info.*.account_number' => 'required',
            'account_info.*.other_info'     => 'json',
            'old_media'                     => ['array'],
            'new_media'                     => ['array'],
            'new_media.*'                   => 'file',
            'pay_method'                    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'bank.array'                        => "收款方式必须是一个数组",
            'bank.required'                     => "收款方式不能为空",
            'bank_name.required'                => "银行名称不能为空",
            'other_info.json'                   => "其他自定义的信息必须是一个json的字符串",
            'account_info.array'                => "账户信息必须是一个数组",
            'account_info.required'             => "账户信息不能为空",
            'account_name.required'             => '账户信息的账户名不能为空',
            'account_info.*.account_number.required' => '账户信息的账号不能为空',
            'account_info.*.other_info.json'    => "账户信息的其他自定义信息必须是一个json的字符串",
            'old_media.array'                   => '原附件传值错误',
            'new_media.required_without'        => '新增或原来的附件不能都为空！',
            'new_media.array'                   => '新增附件应为数组形式',
            'new_media.*.file'                  => '新增附件必须是文件!',
            'pay_method.required'               => '付款方式不能为空',
        ];
    }
}
