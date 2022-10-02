<?php


namespace Modules\Base\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;

class CompanyBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'bank_name'                          => 'required',
            'other_info'                         => 'json',
            'account_info'                       => ['array'],
            'account_name'                       => 'required',
            'account_info.*.other_info'          => 'json',
            'account_info.*.payment_method_id'   => ['same:account_info.0.payment_method_id'],
            'account_info.*.payment_method_name' => ['same:account_info.0.payment_method_name'],
            'old_media'                          => ['array'],
            'new_media'                          => ['array'],
            'new_media.*'                        => 'file',
            'uuid'                               => 'exists:\Modules\Base\Entities\Company\CompanyBank,uuid'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('check_address') && $this->request->get('check_address') == null) {
            $this->request->set('check_address', "");
        }
        if ($this->request->has('pay_method') && $this->request->get('pay_method') == null) {
            $this->request->set('pay_method', "");
        }
        if ($this->request->has('comment') && $this->request->get('comment') == null) {
            $this->request->set('comment', "");
        }
        if ($this->request->has('parent_uuid') && $this->request->get('parent_uuid') == null) {
            $this->request->remove('parent_uuid');
        }
    }
}
