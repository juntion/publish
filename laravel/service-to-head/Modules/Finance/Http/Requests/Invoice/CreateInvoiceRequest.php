<?php

namespace Modules\Finance\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'type' => 'required|integer',
            'origin_invoice_number' => 'nullable',
            'invoice_number' => 'required',
            'remark' => 'nullable',
        ];
    }
}
