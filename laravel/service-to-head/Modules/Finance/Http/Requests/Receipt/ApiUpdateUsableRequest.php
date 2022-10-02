<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateUsableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number'   => ['required', 'exists:Modules\Finance\Entities\PaymentReceipt,number'],
            'currency' => 'required',
            'use'      => ['required', 'int'],
            'admin_id' => ['required']
        ];
    }
}
