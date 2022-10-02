<?php


namespace App\Request;

use Respect\Validation\Validator;
use App\Traits\TransTrait;

/**
 * 验证表单基类
 *
 * @author aron
 * @date 2019.11.8
 * Class BaseRequest
 * @package App\Request
 */
class BaseRequest
{
    use TransTrait;
    protected $rules;
    protected $message;
    public $data;
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    protected function rules()
    {
    }

    protected function message()
    {
    }

    /**
     * 验证rules数据
     *
     * @author aronß
     * @date 2019.11.8
     * @return array
     */
    public function checkData()
    {
        $rule = $this->rules();
        $message = $this->message();
        $error = [];
        foreach ($rule as $key => $value) {
            foreach ($value as $ruleList) {
                $rule = $ruleList;
                if (strpos($ruleList, ":") !== false) {
                    $rule = explode(":", $ruleList);
                }
                $ruleKey = $rule;
                $ruleValue = null;
                if (is_array($rule)) {
                    $ruleKey = $rule[0];
                    $ruleValue = isset($rule[1]) ? $rule[1] : null;
                }
                $data = $this->data[$key];
                $bool = $this->validRule($ruleKey, $ruleValue, $data);
                if (!$bool) {
                    $error[$key] = $message[$key . "." . $ruleKey];
                    break 2;
                }
            }
        }
        return $error;
    }

    /**
     * 其他验证方法可以 参考https://respect-validation.readthedocs.io/en/1.1/rules/
     *
     * @author aron
     * @date 2019.11.8
     * @param $rule
     * @param $ruleValue
     * @param string $data
     * @return bool
     */
    private function validRule($rule, $ruleValue, $data = "")
    {
        $bool = true;
        switch ($rule) {
            case "required":
                $bool = Validator::notEmpty()->validate($data);
                break;
            case 'length':
                $ruleValue = explode(",", $ruleValue);
                $bool =Validator::length($ruleValue[0], $ruleValue[1])->validate($data);
                break;
            case "in":
                $ruleValue = explode(",", $ruleValue);
                $data = (string)$data;
                $bool = Validator::stringType()->in($ruleValue)->validate($data); // true
                break;
            case "email":
                $bool = Validator::email()->validate($data);
                break;
            case "digit":
                $bool = Validator::digit()->validate($data);
                break;
            case "fs_email":
                $reg = '/^[0-9A-Za-z][\w\.\-\+]*\@[\w\.\-\+]+\.[\w\.\-]+[A-Za-z]$/';
                $bool = Validator::regex($reg)->validate($data);
                break;
            case "password":
                $reg1 = '/^(?![0-9_\.\?\@\!\#\$\%\^\&\*]+$)(?![a-zA-Z_\.\?\@\!\#\$\%\^\&\*]+$)';
                $reg2 = '(?![a-zA-Z_\.\?\@\!\#\$\%\^\&\*]+$)[0-9A-Za-z_\.\?\@\!\#\$\%\^\&\*]{6,}$/';
                $reg = $reg1.$reg2;
                $bool = Validator::regex($reg)->validate($data);
                break;
        }
        return $bool;
    }
}
