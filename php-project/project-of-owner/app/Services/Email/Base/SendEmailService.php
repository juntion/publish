<?php


namespace App\Services\Email\Base;

use App\Config\EmailConfig;
use App\Exception\SendEmailException;
use GuzzleHttp\Client;
use App\Services\BaseService;

/**
 * 发送邮件服务者
 *
 * @author aron
 * @date 2019.11.27
 * Class SendEmailService
 * @package App\Services\Common
 */
class SendEmailService extends BaseService
{
    //配置
    private $config = [];
    //curl class
    private $client;
    //oAuth url 获取token url
    private $oauthUrl;
    //请求客户端id
    private $clientId;
    //请求客户端密码
    private $clientSecret;
    private $emailContactUrl;
    //请求url id
    private $campaignId = 3;
    //分组id
    private $groupId = 81;
    //错误日志标识
//    public $logChanel = 'checkoutOrderEmail';
    //发送邮件
    public $email;

    //有效配置
    private $invalidConfig = [
        'sendEmail',
        'emailDescription',
        'emailTemplate',
        'title',
        'sender'
    ];

    public function __construct()
    {
        $this->client = new Client();
        $this->oauthUrl = EmailConfig::OAUTH_TOKEN_URL;
        $this->clientId = EmailConfig::CLIENT_ID;
        $this->clientSecret = EmailConfig::CLIENT_SECRET;
        $this->emailContactUrl = EmailConfig::EMAIL_CONTACT_URL;
        parent::__construct();
    }


    /**
     * 设置邮件参数
     *
     * @param array $config
     * @return $this
     * @throws \Exception
     */
    public function setConfig($config)
    {
        if (!is_array($config)) {
            throw new \Exception('config不是一个数组');
        }
        foreach ($config as $key => $value) {
            if (!in_array($key, $this->invalidConfig)) {
                throw new \Exception('config 参数不正确');
                break;
            }
            $this->config[$key] = $value;
        }
        if (count($this->config) != count($this->invalidConfig)) {
            throw new \Exception('config 参数不正确');
        }
        $this->email = $this->config['sendEmail'];
        return $this;
    }

    /**
     * @return mixed
     * @throws SendEmailException
     */
    protected function createToken()
    {
        $data = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope'         => 'rest'
        ];
        $res = $this->client->get($this->oauthUrl, [
            'headers' => [
                'accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'query'   => $data,
            'timeout' => 30
        ]);
        $body = json_decode($res->getBody()->getContents(), true);
        if (empty($body['access_token'])) {
            throw new SendEmailException('auth token 获取异常');
        }
        return $body;
    }


    /**
     * 创建联系人
     *
     * @param string $accessToken
     * @param string $email
     * @return bool
     */
    protected function createContact($accessToken, $email)
    {
        $requestUrl = $this->emailContactUrl . "/{$this->campaignId}/contact";
        $item = [
            'email'  => $email,
            'groups' => [$this->groupId],
            'lang'   => 'cn',
            [
                'custom' => [
                    'field' => 'name',
                    'value' => 'jefftest'
                ]
            ]
        ];
        $headers = [
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
            'authorization' => 'Bearer ' . $accessToken,
        ];
        try {
            $res = $this->client->post($requestUrl, [
                'headers' => $headers,
                'body'    => json_encode($item),
                'timeout' => 30
            ]);
            $body = json_decode($res->getBody()->getContents(), true);
            return true;
        } catch (\  Exception $e) {
            $code = $e->getCode();
            //当前联系人已经在第三方创建
            if (in_array($code, [409])) {
                return true;
            }
//            \Log::channel($this->logChanel)->error($e->getMessage());
            return false;
        }
    }

    /**
     * @return mixed
     * @throws SendEmailException
     */
    public function sendEmail()
    {
        $tokenInfo = $this->createToken();
        $config = $this->config;
        $email = $config['sendEmail'];
        $description = $config['emailDescription'];
        $emailTemplate = $config['emailTemplate'];
        $sender = $config['sender'];
        $title = $config['title'];
        $accessToken = $tokenInfo['access_token'];
        // //创建联系人
        // $this->createContact($accessToken, $email);
        // //创建远程邮件模版
        // $data = $this->createApiEmailTemplate($accessToken, $emailTemplate, $description, $sender, $title);
        // //发送邮件
        // $response = $this->send($accessToken, $data['id'], $email);

        // 发送搭字段邮件
        $response = $this->sendSingleEmail($accessToken, $emailTemplate, $sender, $title, $email);

        return $response;
    }

    /**
     * @param string $accessToken
     * @param string $emailTemplate
     * @param string $description
     * @param string $sender
     * @param string $title
     * @return mixed
     * @throws SendEmailException
     */
    protected function createApiEmailTemplate(
        $accessToken,
        $emailTemplate,
        $description,
        $sender,
        $title
    ) {
        $requestUrl = $this->emailContactUrl . "/{$this->campaignId}/mailing";
        $headers = [
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
            'authorization' => 'Bearer ' . $accessToken,
        ];
        $item = [
            'name'          => $description,
            'lang'          => 'cn',
            'subject'       => $title,
            'preheader'     => '',
            'from_name'     => $sender,
            'forward_id'    => 35803,
            'reply_id'      => 0,
            'plaintext_msg' => '看上去似乎您的e-mail软件不支持HTML。请访问下面的网页使您能够在网页浏览其中阅读这条信息',
            'html_msg'      => $emailTemplate
        ];
        $res = $this->client->post(
            $requestUrl,
            [
                'headers' => $headers,
                'body'    => json_encode($item),
                'timeout' => 30
            ]
        );
        $body = json_decode($res->getBody()->getContents(), true);
        if (empty($body['id'])) {
            throw new SendEmailException('请求模版id不存在');
        }
        return $body;
    }

    /**
     * 发送大字段邮件
     * Create a new contact and send a mail
     */
    protected function sendSingleEmail($accessToken, $emailTemplate, $sender, $title, $email){
        $requestUrl = $this->emailContactUrl . "/{$this->campaignId}/contact/sendSingleMail";
        $headers = [
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
            'authorization' => 'Bearer ' . $accessToken,
        ];

        $item = [
            "mailingId" => 79143,
            "attachments" => [],
            "contact" => [
                "email" => $email, 
                "mobile_nr" => "", 
                "lang" => "cn",
                "custom" => [
                    [
                        "field" => "mail_subject",
                        "value" => $title,
                    ],
                    [
                        "field" => "sender_name",
                        "value" => $sender,
                    ],
                ],
            ],
            "overrideDuplicateAndSend" => true,
            "extraContactData" => array(array("field" => 'DMD_extra1', "value" => $emailTemplate))
        ];

        $res = $this->client->post(
            $requestUrl,
            [
                'headers' => $headers,
                'body'    => json_encode($item),
                'timeout' => 30
            ]
        );
        $body = json_decode($res->getBody()->getContents(), true);
        // if (empty($body['id'])) {
        //     throw new SendEmailException('请求模版id不存在');
        // }
        return $body;
    }

    /**
     * @param string $accessToken
     * @param int $templateId
     * @param string $email
     * @return mixed
     * @throws SendEmailException
     */
    protected function send($accessToken, $templateId, $email)
    {
        $requestUrl = $this->emailContactUrl . "/{$this->campaignId}/contacts/send";
        $headers = [
            'accept'        => 'application/json',
            'content-type'  => 'application/json',
            'authorization' => 'Bearer ' . $accessToken,
        ];
        $contacts = [
            [
                'email'  => $email,
                'lang'   => 'cn',
                'custom' => [
                    [
                        'field' => 'name',
                        'value' => 'jefftest'
                    ]
                ]
            ]
        ];
        $item = [
            'mailingId'           => $templateId,
            'groups'              => [$this->groupId],
            'overwrite'           => true,
            'addDuplicateToGroup' => true,
            'contacts'            => $contacts
        ];
        $res = $this->client->post($requestUrl, [
            'headers' => $headers,
            'body'    => json_encode($item),
            'timeout' => 30
        ]);
        $body = json_decode($res->getBody()->getContents(), true);
        $status = isset($body[0]['status']) ? $body[0]['status'] : 'error';
        if ($status == 'error') {
            throw new SendEmailException(json_encode($body));
        }
        return $body;
    }
}
