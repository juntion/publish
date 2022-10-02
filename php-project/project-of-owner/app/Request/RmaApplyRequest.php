<?php


namespace App\Request;

/**
 * 售后申请表单验证
 *
 * @author quest
 * @date 2019.11.14
 * Class AccountSettingRequest
 * @package App\Request
 */
class RmaApplyRequest extends BaseRequest
{

    public function __construct()
    {
        parent::__construct();
    }

    //验证类型
    public function rules()
    {
        $rules = [
            'service_type_id' => ['required', 'in:1,2,3'],
            'products_num' => ['required', 'digit'],
            'reasons_type' => ['required', 'length:1,300']
        ];
        return $rules;
    }

    public function message()
    {
        $message = [
            'service_type_id.required' => "invalid code",
            'service_type_id.in' => "invalid code",
            'products_num.required' => 'Please enter the number',
            'products_num.digit' => 'Please enter the number',
            'reasons_type.required' => 'Please select return reason.',
            'reasons_type.length' => 'The reason description is too long.'
        ];
        return $message;
    }
}
