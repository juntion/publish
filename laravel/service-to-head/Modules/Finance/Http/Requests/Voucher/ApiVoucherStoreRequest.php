<?php


namespace Modules\Finance\Http\Requests\Voucher;


use Illuminate\Foundation\Http\FormRequest;

class ApiVoucherStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_number'            => 'required',
            'currency'                => 'required',
            'order_price'             => 'nullable|int',
            'type'                    => ['required', 'in:2,3,4'],
            'remark'                  => 'required',
            'admin_id'                => 'required',
            'customer_company_number' => 'required',
            'customer_company_name'   => 'required',
            'file'                    => 'array',
            'file.*'                  => 'file'
        ];
    }
}
