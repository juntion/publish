<?php

namespace Modules\Finance\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class ListInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
