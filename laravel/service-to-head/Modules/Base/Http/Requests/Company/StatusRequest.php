<?php


namespace Modules\Base\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "comment" => ['required'],
            "status"  => ['required', 'in:0,1']
        ];
    }
}
