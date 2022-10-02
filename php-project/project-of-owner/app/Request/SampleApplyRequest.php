<?php
namespace App\Request;

use App\Request\BaseRequest;

class SampleApplyRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct();
    }
    public function rules()
    {
        $rules = [
            'entry_firstname' => ['required'],
            'entry_lastname' => ['required'],
            'email_address' => ['required'],
            'entry_telephone' => ['required','length:6,300'],
            'entry_street_address' => ['required','length:4,300'],
            'entry_city' => ['required'],
            'entry_postcode' => ['required','length:3,300'],
         ];
        if (188 === (int)$this->data['country_id']) {
            $rules['entry_suburb'] = ['required'];
        }

        return $rules;
    }
    public function message()
    {
        $message = [
            'entry_firstname.required' => self::trans("FS_FIRST_NAME_PLEASE"),
            'entry_lastname.required' => self::trans("FS_LAST_NAME_PLEASE"),
            'email_address.required' => self::trans("FS_EMAIL_REQUIRED_TIP"),
            'entry_telephone.required' => self::trans("FS_PHONE_REQUIRED_TIP"),
            'entry_telephone.length' => self::trans("FS_ADDRESS_PHONE_MSG"),
            'entry_street_address.required' => self::trans("FS_ADDRESS_SORRY"),
            'entry_street_address.length' => self::trans("FS_ADDRESS_STREET_FORMAT_TIP"),
            'entry_city.required' => self::trans("ACCOUNT_EDIT_CITY_MSG"),
            'entry_postcode.required' => self::trans("FS_ADDRESS_POSTAL_REQUIRED_TIP"),
            'entry_postcode.length' => self::trans("FS_ADDRESS_POSTAL_MSG"),
        ];
        if (188 === (int)$this->data['country_id']) {
            $message['entry_suburb.required'] = self::trans("FS_CHECKOUT_ERROR_SG_01");
        }

        return $message;
    }
}
