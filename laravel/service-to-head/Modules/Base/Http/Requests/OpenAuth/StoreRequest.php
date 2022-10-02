<?php


namespace Modules\Base\Http\Requests\OpenAuth;


use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exp_time' => 'required|integer',
            'remarks'  => 'required|string',
        ];
    }
}