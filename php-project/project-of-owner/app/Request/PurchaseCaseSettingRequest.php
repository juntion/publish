<?php


namespace App\Request;

/**
 * @author rebirth
 * Class PurchaseCaseSettingRequest
 * @package App\Request
 * po申请外围页数据验证
 */
class PurchaseCaseSettingRequest extends BaseRequest
{

    public function __construct()
    {
        parent::__construct();
    }

    //验证类型
    public function rules()
    {
        $data = $this->data;
        if (isset($data['type']) && $data['type'] == 'email') {
            return [
                'email' => ['required', 'fs_email']
            ];
        }
        return [
            'fullName'  => ['required'],
            'email'     => ['required', 'fs_email'],
            'phone'     => ['required', 'digit', 'length:6,100'],
            'countryId' => ['required']
        ];
    }

    public function message()
    {
        $message = [
            'fullName.required'  => self::trans("FS_NET_30_01"),
            'email.required'     => self::trans("FS_EMAIL_REQUIRED_TIP"),
            'email.fs_email'     => self:: trans("FS_EMAIL_FORMAT_TIP"),
            'phone.required'     => self:: trans("FS_PHONE_REQUIRED_TIP"),
            'phone.digit'        => self::trans('FS_ADDRESS_PHONE_MSG'),
            'phone.length'       => self::trans("FS_ADDRESS_PHONE_MSG"),
            'countryId.required' => self::trans("FS_ACCESS_DENIED_1"),
        ];
        return $message;
    }
}
