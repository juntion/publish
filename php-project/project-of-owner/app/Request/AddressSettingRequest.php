<?php


namespace App\Request;

/**
 * @author potato
 * Class AddressSettingRequest
 * @package App\Request
 * 账户中心 地址信息验证规则
 */
class AddressSettingRequest extends BaseRequest
{

    public function __construct()
    {
        parent::__construct();
    }

    //验证类型
    public function rules()
    {
        $data = $this->data;
        $type = $data['type'];
        $rules = [
            'type' => ['required', 'in:1,2'],
        ];
        if ($type == 1) {
            $rules['address_book_id'] = ['required'];
        } elseif ($type == 2) {
            $min_length = $_SESSION['languages_code'] == 'jp' ? 1:2;
            $rules['company_type'] = ['required'];
            $rules['entry_firstname'] = ['required', 'length:'.$min_length.',30'];
            $rules['entry_lastname'] = ['required', 'length:'.$min_length.',30'];
            $rules['entry_street_address'] = ['required'];
            $rules['entry_postcode'] = ['required'];
            $rules['entry_city'] = ['required'];
            $rules['entry_telephone'] = ['required'];
        }
        return $rules;
    }

    public function message()
    {
        $message = [
            'type.required' => "invalid code",
            'type.in' => "invalid code",
            'customers_firstname.required' => self::trans("FS_FIRST_REQUIRED_TIP"),
            'customers_lastname.required' => self::trans("FS_LAST_REQUIRED_TIP"),
            'customers_firstname.length' => self:: trans("FS_FIRST_MIN_TIP")
                ." ".self:: trans("FS_FIRST_MAX_TIP"),
            'customers_lastname.length' => self:: trans("FS_LAST_MIN_TIP")
                ." ".self:: trans("FS_LAST_MAX_TIP"),
            'entry_company.required' => self:: trans("FS_COMPANY_NAME_REQUIRED_TIP"),
            'entry_city.required' => self::trans('FS_CITY_TITLE_ERROR'),
            'entry_telephone.required' => self::trans("ENTRY_TELEPHONE_NUMBER_ERROR"),
            'entry_postcode.required' => self::trans("FS_POST_CODE_TITLE_ERROR"),
            'entry_street_address.required' => self::trans('ENTRY_STREET_ADDRESS_ERROR'),
            'entry_state.required' => self::trans("ENTRY_STATE_ERROR"),
            'company_type.required' => self::trans("ENTRY_COMPANY_ERROR"),
        ];
        return $message;
    }
}
