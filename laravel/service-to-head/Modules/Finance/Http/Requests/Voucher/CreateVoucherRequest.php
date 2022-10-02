<?php

namespace Modules\Finance\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class CreateVoucherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'DK_info'                    => 'array',
            'DK_info.*.number'           => [
                'required',
                'distinct'
            ],
            'DK_info.*.exchange'         => ['required', 'in:true,false'],
            'DK_info.*.currency'         => 'required',
            'DK_info.*.use'              => ['required', 'int'],
            'DK_info.*.order_currency'   => 'required',
            'DK_info.*.order_use'        => ['required', 'int'],
            'order_info'                 => 'array',
            'order_info.*.order_number'  => ['required', 'distinct'],
            'order_info.*.customer_zone' => 'nullable|in:false,true',
            'order_info.*.order_price'   => ['required', 'int'],
            'order_info.*.currency'      => ['required'],
            'remark'                     => 'required',
            'file'                       => 'array',
            'file.*'                     => 'file',
        ];
    }
}
