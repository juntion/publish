<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStatusRequest extends FormRequest
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
            "status" => ['required', 'in:0,1,2,3,4']
        ];
    }

    public function messages()
    {
        return [
          'status.required'  => '项目状态不能为空',
          'status.in'        => '项目状态传值错误'
        ];
    }
}
