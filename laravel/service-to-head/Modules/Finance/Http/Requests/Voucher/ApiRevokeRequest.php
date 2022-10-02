<?php


namespace Modules\Finance\Http\Requests\Voucher;


use Illuminate\Foundation\Http\FormRequest;

class ApiRevokeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'order_number' => ['required', 'exists:Modules\Finance\Entities\PaymentReceiptsVouchersDetail,order_number'],
//            'currency'     => 'required',
//            'give_back'    => 'required',
            'admin_id'     => 'required',
        ];
    }
}
