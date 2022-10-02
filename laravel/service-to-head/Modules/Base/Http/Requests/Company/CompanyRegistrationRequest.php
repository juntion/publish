<?php


namespace Modules\Base\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Base\Enums\Company\AddressType;

class CompanyRegistrationRequest extends FormRequest
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
            "tax"                  => ['array'],
            "tax.*.tax_number"     => ['required'],
            "tax.*.country_name"   => ['required'],
            "tax.*.country_code"   => ['required'],
            "tax.*.uuid"           => ['exists:Modules\Base\Entities\Company\CompanyTaxInfo,uuid'],
            'old_media'            => ['array'],
            'new_media'            => ['array'],
            'new_media.*'          => 'file',
            'name'                 => ['required', 'max:255'],
            "foreign_name"         => ["not_regex:/[\x7f-\xff]/", 'required', 'max:255'],// 非中文
            "country_name"         => ['required','max:255'],
            'foreign_country_name' => ["not_regex:/[\x7f-\xff]/", 'required', 'max:255'],// 非中文
            "country_code"         => ['required', 'max:2'],
            'foreign_country_code' => ['required', 'max:2'],// 非中文
            'province'             => ['required'],
            'foreign_province'     => ["not_regex:/[\x7f-\xff]/", 'required'],
            'city'                 => ['required'],
            'foreign_city'         => ["not_regex:/[\x7f-\xff]/", 'required'],
            'area'                 => ['required'],
            'foreign_area'         => ["not_regex:/[\x7f-\xff]/", 'required'],
            'address'              => ['required'],
            'foreign_address'      => ["not_regex:/[\x7f-\xff]/", 'required'],
            'uuid'                 => [
                Rule::exists('company_addresses','uuid')->where('type', AddressType::REGISTER_TYPE)
            ]
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->request->has('postcode') && $this->request->get('postcode') == null) {
            $this->request->set('postcode',"");
        }
        if ($this->request->has('foreign_postcode') && $this->request->get('foreign_postcode') == null) {
            $this->request->set('foreign_postcode',"");
        }
        if ($this->request->has('contacts') && $this->request->get('contacts') == null) {
            $this->request->set('contacts',"");
        }
        if ($this->request->has('tel') && $this->request->get('tel') == null) {
            $this->request->set('tel',"");
        }
        if ($this->request->has('foreign_tel') && $this->request->get('foreign_tel') == null) {
            $this->request->set('foreign_tel',"");
        }
        if ($this->request->has('comment') && $this->request->get('comment') == null) {
            $this->request->set('comment', "");
        }
    }
}
