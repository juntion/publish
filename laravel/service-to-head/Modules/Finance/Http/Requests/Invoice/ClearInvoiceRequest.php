<?php

namespace Modules\Finance\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class ClearInvoiceRequest extends FormRequest
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
            'action_type' => 'required|integer',
            'income_number' => 'required',
            'income_currency' => 'required',
            'income_clear' => 'required|integer',
            'expend_number' => 'required',
            'flag' => 'required',
            'type' => 'required|integer|max:9|min:1',
            'remark' => 'required',
            'order_number' => 'required',
            'admin_id' => 'nullable',
        ];
    }

    public function prepareForValidation()
    {
        $flag = $this->request->get('flag');
        if (is_bool($flag)) {
            $flag = (int)$flag;
        } else {
            $flag = $flag=='true'?1:0;
        }
        $this->request->set('flag', $flag);
    }
}
