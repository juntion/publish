<?php

namespace Modules\Finance\Http\Requests\Receipt;

use Illuminate\Foundation\Http\FormRequest;

class CreateReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transaction_serial_number' => ['required', 'unique:Modules\Finance\Entities\PaymentReceipt'],
            'payment_method_id'         => 'required',
            'currency'                  => 'required',
            'amount'                    => ['int', 'required', 'max:4294967295'],
            'fee_fs'                    => 'present|nullable|int',
            'payer_email'               => 'present|nullable|email',
            'payer_name'                => 'present|nullable',
            'payment_remark'            => 'present|nullable',
            'customer_debit_account'    => 'present|nullable',
            'payment_time'              => 'present|nullable'
        ];
    }

    public function prepareForValidation()
    {
        if ($this->query->has('fee_fs') && is_null($this->query->get('fee_fs'))) {
            $this->query->set('fee_fs', 0);
        }
    }

    public function messages()
    {
        return [
            'transaction_serial_number.unique' => __('finance::receipt.transactionSerialNumberUnique')
        ];
    }
}
