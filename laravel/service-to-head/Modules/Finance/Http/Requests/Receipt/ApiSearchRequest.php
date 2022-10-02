<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class ApiSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'admin_id'     => 'required',
            'number'       => 'required_without:order_number',
            'order_number' => 'required_without:number',
        ];
    }
}
