<?php


namespace App\Request;

/**
 * 账户中心  my_credit页面数据验证
 *
 * @author aron
 * @date 2019.11.8
 * Class AccountSettingRequest
 * @package App\Request
 */
class MyCreditSettingRequest extends BaseRequest
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
            'type' => ['required', 'in:1,2'],
        ];
        if ($type == 2) {
            $rules['apply_reason'] = ['required'];
            $rules['apply_money'] = ['required'];
        } else {
            $rules['search'] = ['length:0,200'];
            $rules['state'] = ['in:1,2,3'];
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
            'type.required'   => "invalid code",
            'type.in'         => "invalid code",
            'state.in'        => "invalid code",
            'search.length'   => "invalid code",
            'apply_money.required'  => self:: trans("FS_APPLY_MONEY_REQUIRED_TIP"),
            'apply_reason.required' => self:: trans("FS_APPLY_MONEY_REASON_TIP"),
        ];
        return $message;
    }
}
