<?php


namespace Modules\Finance\Http\Requests\Receipt;


use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => ['required', 'file']
        ];
    }
}
