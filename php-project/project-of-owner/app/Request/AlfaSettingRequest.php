<?php
/**
 * Notes:
 * File name:AlfaSettingRequest
 * Create by: Jay.Li
 * Created on: 2020/6/2 0002 12:27
 */


namespace App\Request;

class AlfaSettingRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        return $rules = [
            'alfa_organization' => ['required'],
            'alfa_legal_address' => ['required'],
            'alfa_inn' => ['required'],
            'alfa_kpp' => ['required'],
            'alfa_bic' => ['required'],
            'alfa_bank_name' => ['required'],
            'alfa_email' => ['required', 'email'],
            'alfa_phone' => ['required']
        ];
    }

    public function message()
    {
        return $message = [
            'alfa_organization.required' => self::trans("FS_CHECKOUT_ALFA_03"),
            'alfa_legal_address.required' => self::trans("FS_CHECKOUT_ALFA_10"),
            'alfa_inn.required' => self::trans("FS_CHECKOUT_ALFA_04"),
            'alfa_kpp.required' => self::trans("FS_CHECKOUT_ALFA_06"),
            'alfa_bic.required' => self::trans("FS_CHECKOUT_ALFA_08"),
            'alfa_bank_name.required' => self::trans("FS_CHECKOUT_ALFA_11"),
            'alfa_email.required' => self::trans("FS_CHECKOUT_ALFA_01"),
            'alfa_email.email' => self::trans("FS_CHECKOUT_ALFA_02"),
            'alfa_phone.required' => self::trans("FS_CHECKOUT_ERROR7")
        ];
    }
}
