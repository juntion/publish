<?php

namespace Modules\Finance\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UnclearedInvoiceRequest extends FormRequest
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
            'customer_company_number' => 'required',
        ];
    }
}
