<?php


namespace App\Request;

use App\Request\BaseRequest;

class AvaTaxAddressRequest extends BaseRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function rules()
    {
        $data = $this->data;
        $rules = [
            'line1' => ['required', 'length:0,50'], // First line of the street address
            'region' => ['required'], //州  ISO 3166 code
            'country' => ['required'], //国家  ISO 3166 code
            'postalCode' => ['required', 'length:0,11'], //邮编
            'line2' => ['length:0,100'], //Second line of the street address
            'city' => ['required', 'length:0,50'], //城市
        ];
        return $rules;
    }

    public function message()
    {
        $message = [
            'country.required' => self::trans('FS_CHECKOUT_ERROR6'),
            'postalCode.required' => self::trans('FS_CHECKOUT_ERROR4'),
            'postalCode.length' => self::trans("FS_ADDRESS_ERROR4"),
            'line1.length' => self::trans("FS_ADDRESS_ERROR1"),
            'line2.length' => self::trans("FS_ADDRESS_ERROR2"),
            'city.required' => self::trans("FS_CHECKOUT_ERROR5"),
            'city.length' => self::trans("FS_ADDRESS_ERROR3"),
            'region.required' => self::trans("FS_CHECKOUT_ERROR9"),
        ];
        return $message;
    }
}
