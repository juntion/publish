<?php


namespace Modules\Finance\Http\Requests\Voucher;


use Illuminate\Foundation\Http\FormRequest;

class ApiSplitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vouch_number'                    => ['required', 'exists:Modules\Finance\Entities\PaymentVoucher,number'],
            'order_info'                      => ['array'],
            'order_info.*.product_instock_id' => 'required',
            'order_info.*.parent_id'          => 'int',
            'order_info.*.origin_id'          => 'int',
            'admin_id'                        => 'required',
        ];
    }
}
