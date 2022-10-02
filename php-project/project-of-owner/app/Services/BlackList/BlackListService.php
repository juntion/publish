<?php


namespace App\Services\BlackList;


use App\Models\BlackMailSuffix;
use App\Services\BaseService;

class BlackListService extends BaseService
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->registerModel();
    }

    /**
     * @Notes:判断当前客户是否为黑名单
     *
     * @return bool
     * @author: aron
     * @Date: 2020-12-07
     * @Time: 22:37
     */
    public function isBlack()
    {
        if ($this->customers_authorization == 4) {
            return true;
        }
        if (!empty($this->customer_email) && strpos($this->customer_email, "@") !== false) {
            $translate_email = explode("@", $this->customer_email);
            $suffix = "@" . $translate_email[1];
            $result = $this->model->select('id')->where('mail_suffix', $this->customer_email)
                ->orWhere('mail_suffix', $suffix)->first();
            if (!empty($result)) {
                return true;
            }
            return false;
        }
    }


    protected function registerModel()
    {
        $this->model = new BlackMailSuffix();
    }
}
