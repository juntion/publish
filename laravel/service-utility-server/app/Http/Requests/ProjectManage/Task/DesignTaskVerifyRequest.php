<?php

namespace App\Http\Requests\ProjectManage\Task;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class DesignTaskVerifyRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('verify', $this->route('task'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'parts' => 'required|array',
            'parts.*' => 'required|integer|between:0,4',
            'design_type' => 'required|integer|between:0,2',
        ];
    }

    public function attributes()
    {
        return [
            'parts' => '设计环节',
            'parts.*' => '设计环节',
            'design_type' => '设计类型',
        ];
    }
}
