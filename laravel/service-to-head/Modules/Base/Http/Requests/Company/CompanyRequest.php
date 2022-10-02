<?php


namespace Modules\Base\Http\Requests\Company;


use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            "type"         => ['required', "in:1,2,3"],
            "simple_name"  => ["required", "max:10"],
            "code"         => ["required", "max:5", "regex:/[A-Za-z]/"],
            "name"         => "required",
            "foreign_name" => ["required", "not_regex:/[\x7f-\xff]/"],// 非中文
            "parent_uuid"  => "required_if:type,2,3|exists:Modules\Base\Entities\Company\Company,uuid",
            "country_name" => "required",
            "country_code" => "required",
            "is_show"      => ['required',"in:0,1"],
            'profile'      => ['required']
        ];
    }

    public function messages()
    {
        return [
            "parent_uuid.required_if"        => __('base::company.parentUuidRequiredIf'),
            "code.regex"                     => __('base::company.codeRegex'),
            "foreign_name.not_regex"         => __('base::company.foreignNameMustNotChinese'),
        ];
    }


    protected function prepareForValidation()
    {
        if ($this->request->has('time_zone') && $this->request->get('time_zone') == null) {
            $this->request->set('time_zone', 0);
        }
    }
}
