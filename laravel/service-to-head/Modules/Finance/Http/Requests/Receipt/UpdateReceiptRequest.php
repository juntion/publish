<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transaction_serial_number' => ['required',Rule::unique('f_payment_receipts')->ignore($this->uuid, 'uuid')],
            'payment_method_id'         => 'required',
            'currency'                  => 'required',
            'amount'                    => ['int', 'required'],
            'fee_fs'                    => 'present|nullable|int',
            'payer_email'               => 'present|nullable|email',
            'payer_name'                => 'present|nullable',
            'payment_remark'            => 'present|nullable',
            'customer_debit_account'    => 'present|nullable',
        ];
    }
}
