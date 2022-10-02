<?php

namespace App\Http\Requests\ProjectManage\Appeal;

use App\Exceptions\System\InvalidStatusException;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function authorize()
    {
        if (!$this->user()->can('verify', $this->route('appeal'))) {
            throw new InvalidStatusException();
        }
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required|integer|between:0,7',
            'crux' => 'string',
            'comment' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'status' => '诉求状态',
            'crux' => '症结点',
            'comment' => '备注',
        ];
    }
}
