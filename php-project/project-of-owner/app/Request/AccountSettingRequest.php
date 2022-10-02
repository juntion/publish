<?php


namespace App\Request;

/**
 * 用户账户中心 个人信息 edit_my_account 表单验证
 *
 * @author aron
 * @date 2019.11.8
 * Class AccountSettingRequest
 * @package App\Request
 */
class AccountSettingRequest extends BaseRequest
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 验证规则
     *
     * @return array|void
     */
    public function rules()
    {
        $data = $this->data;
        $type = $data['type'];
        $rules = [
            'type' => ['required', 'in:1,2,3,4,5'],
        ];
        if ($type == 2) {
            $min_length = $_SESSION['languages_code'] == 'jp' ? 1:2;
            $rules['customers_firstname'] = ['required', 'length:'.$min_length.',32'];
            $rules['customers_lastname'] = ['required', 'length:'.$min_length.',32'];
        } elseif ($type == 3) {
            $rules['customers_email_address'] = ['required', 'fs_email'];
            $rules['customers_reEmail'] = ['required', 'fs_email'];
            $rules['customers_password'] = ['required'];
        } elseif ($type == 1) {
            $rules['customers_photo'] = ['required'];
        } elseif ($type == 4) {
            $rules['newsletter'] = ['in:0,1,2,3'];
            $rules['comment_mail_subscribe'] = ['in:1,2'];
        } elseif ($type == 5) {
            $rules['password'] = ['required'];
            $rules['new_password'] = ['required','length:6,90','password'];
        }
        return $rules;
    }

    /**
     * 验证错误提示语
     *
     * @return array|void
     */
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
            'customers_email_address.required' => self:: trans("FS_NEW_EMAIL_REQUIRED_TIP"),
            'customers_reEmail.required' => self::trans('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP'),
            'customers_email_address.fs_email' => self::trans("FS_EMAIL_FORMAT_TIP"),
            'customers_reEmail.fs_email' => self::trans("FS_EMAIL_FORMAT_TIP"),
            'customers_photo.required' => '图片必须上传',
            'customers_password.required' => self::trans('FS_PASSWORD_REQUIRED_TIP'),
            'newsletter.in' => self::trans("FS_ACCESS_DENIED"),
            'comment_mail_subscribe.in' => self::trans("FS_ACCESS_DENIED"),
            'password.required' => self::trans("FS_PASSWORD_REQUIRED_TIP"),
            'new_password.required' => self::trans("FS_NEW_PASSWORD_REQUIRED_TIP"),
            'new_password.password' => self::trans("FS_PASSWORD_FORMAT_TIP"),
        ];
        return $message;
    }
}
