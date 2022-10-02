<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateFloatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'admin_id' => 'required',
            'number'   => 'required',
            'currency' => 'required',
            'float'      => 'required'
        ];
    }
}
