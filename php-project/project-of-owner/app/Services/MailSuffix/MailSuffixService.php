<?php

namespace App\Services\MailSuffix;

use App\Services\BaseService;
use App\Models\PublicMailSuffix;

class MailSuffixService extends BaseService
{

    private $mailSuffixObj; // public_mail_suffix

    public function __construct()
    {
        parent::__construct();
        $this->mailSuffixObj = new PublicMailSuffix();
    }

    /**
     * 获取公共邮箱后缀
     * @return array
     */
    public function getPublicMailPostfix()
    {
        $postfix_email = $this->mailSuffixObj->get(['mail_suffix'])->toArray();
        return $postfix_email ? array_column($postfix_email, 'mail_suffix') : [];
    }

    /**
     * 根据后缀获取是否存在该条记录
     * @param $domain
     * @return string
     */
    public function getMailSuffix($domain)
    {
        $res = $this->mailSuffixObj->where('mail_suffix', $domain)
            ->limit(1)
            ->get(['mail_suffix'])
            ->toArray();
        return $res[0]['mail_suffix'] ? $res[0]['mail_suffix'] : '';
    }
}
