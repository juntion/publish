<?php


namespace App\Services;

use App\Traits\ToolsTrait;
use App\Traits\TransTrait;

/**
 *基类所有service类需要继承该类
 *
 * @author aron
 * @date 2019.11.8
 * Class BaseService
 * @package App\Services
 */
class BaseService
{
    use ToolsTrait;
    //客户验证等级
    protected $customers_authorization;
    //当前站点id;
    protected $language_id;
    //当前站点code;
    protected $language_code;
    //当前客户id
    protected $customer_id;
    //当前客户邮箱
    protected $customer_email;
    //当前站点货币
    protected $currency;
    //当前站点国家code
    protected $countries_iso_code;
    //session迁移
    protected $session;

    // 被屏蔽掉的国家
    protected $not_countries = [54, 199, 101, 205, 112, 102, 224, 121, 20, 41, 118, 154, 192, 229, 235, 239];

    // MUX定制产品id
    protected $mux_products = [70410, 70407, 70851, 79580, 70411, 70412, 70852, 73959, 73961,
        73960, 70425, 70426, 73794, 70427, 70428, 73795];

    public function __construct()
    {
        if (!defined('IS_ADMIN_FLAG')) {
            die('Illegal Access');
        }
        $this->language_id = (int)$_SESSION['languages_id'];
        $this->language_code = $_SESSION['languages_code'];
        $this->customer_id = isset($_SESSION["customer_id"]) ? (int)$_SESSION["customer_id"] : "";
        $this->customer_email = (string)$_SESSION['customers_email_address'] ?
        $_SESSION['customers_email_address'] : '';
        $this->currency = (string)$_SESSION['currency'];
        $this->countries_iso_code = (string)$_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'US';
        $this->session = $_SESSION;
        $this->customers_authorization = $_SESSION['customers_authorization'] ? $_SESSION['customers_authorization'] : 0;
    }

    /**
     *  by rebirth 当session本身有修改时，调用方法以触发全站的session修改
     */
    protected function changeSession()
    {
        $_SESSION = $this->session;
    }
}
