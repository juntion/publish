<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApplicationUnClaimRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'receipt_uuid'    => [
                'required', Rule::exists('f_payment_receipts', 'uuid')->where('claim_status', 2)
            ],
            'apply_remark'    => 'required',
            'apply_file'      => 'array',
            'apply_file.*'    => ['file']
        ];
    }
}
