<?php

namespace Modules\Finance\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceDownloadRequest extends FormRequest
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
            'filter.created_at_begin' => 'required',
            'filter.created_at_end' => 'required',
            'deadline' => 'required',
        ];
    }
}
