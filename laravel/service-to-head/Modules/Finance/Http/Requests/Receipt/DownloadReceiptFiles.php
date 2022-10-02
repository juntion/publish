<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class DownloadReceiptFiles extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_uuid'   => 'array',
            'file_uuid.*' => ['required', 'exists:Modules\Finance\Entities\PaymentClaimApplyFile,uuid']
        ];
    }
}
