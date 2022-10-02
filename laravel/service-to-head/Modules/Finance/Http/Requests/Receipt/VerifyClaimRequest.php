<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class VerifyClaimRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'check_status'   => ['required', 'in:1,2'],
            'check_file'     => 'array',
            'check_file[].*' => ['file']
        ];
    }
}
