<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class ApiCreateReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transaction_serial_number' => 'present|nullable|unique:Modules\Finance\Entities\PaymentReceipt',
            'payment_method_id'         => 'required',
            'currency'                  => 'required',
            'amount'                    => ['int', 'required'],
            'fee_fs'                    => 'present|nullable|int',
            'payer_email'               => 'nullable|email',
            'admin_id'                  => 'required',
            'apply_id'                  => 'required',
            'customer_number'           => 'required',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->query->has('fee_fs') && is_null($this->query->get('fee_fs'))) {
            $this->query->set('fee_fs', 0);
        }
    }
}
