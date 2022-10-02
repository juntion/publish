<?php

namespace Modules\Finance\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "time" => ['required','date'],
        ];
    }
}
