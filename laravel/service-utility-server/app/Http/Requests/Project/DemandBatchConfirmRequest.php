<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class DemandBatchConfirmRequest extends FormRequest
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
            'demand_ids' => ['required', 'array'],
            'demand_ids.*' => 'exists:pm_demands,id'
        ];
    }

    public function messages()
    {
        return [
            'demand_ids.required' => '批量确认的需求不能为空',
            'demand_ids.array'    => '参数必须是数组',
            'demand_ids.*.exists' => '需求参数错误,未找到指定的需求'
        ];
    }
}
