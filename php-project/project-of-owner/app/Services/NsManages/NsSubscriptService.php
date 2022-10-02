<?php


namespace App\Services\NsManages;

use App\Services\BaseService;
use App\Services\Customers\CustomerService;
use GuzzleHttp\Client;

class NsSubscriptService extends BaseService
{
    /**
     * 请求地址上线会变
     *
     * @var string
     */
    private $requestUrl;
    private $secretKey = "xsacsdqweSasdc1d5f2";
    private $appId = "34252352343543";
    private $secretId = "acsadsadasda211dacsadsqwe";
    private $customer;


    public function __construct()
    {
        parent::__construct();
        $this->customer = new CustomerService();
        if (self::trans("FS_TEST_SERVICE")) {
            $this->requestUrl = 'http://test.whgxwl.com:12001/YX_kVc2yo2cmw0U/update_data_to_ns.php';
        } else {
            $this->requestUrl = 'http://cn.fs.com/YX_0evWtMz4373v/update_data_to_ns.php';
        }
    }

    /**
     * 生成请求token
     *
     * @return string
     */
    private function createToken()
    {
        $secretKey = $this->secretKey;
        $appId = $this->appId;
        $secretId = $this->secretId;
        $t = time();
        $r = mt_rand(10000000, 99999999);
        $original = 'u=' . $appId . '&k=' . $secretId . '&t=' . $t . '&r=' . $r . '&f=';
        $signStr = base64_encode(hash_hmac('sha1', $original, $secretKey) . $original);
        return $signStr;
    }

    /**
     * 通知ns 客户地址 以及个人信息发生了变更
     *
     * @param string $company_number
     * @return bool
     */
    public function subscript($company_number = "")
    {
        if (empty($company_number)) {
            return false;
        }
        $token = $this->createToken();
        $data = ['token' => $token, 'company' => $company_number];
        try {
            $client = new Client();
            $response = $client->post($this->requestUrl, [
                'headers' => [
                    'content-type' => 'application/x-www-form-urlencoded'
                ],
                'body' => $data,
            ]);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);
            if ($res['status']=='success') {
                return true;
            }
        } catch (\ Exception $e) {
            return false;
        }
    }
}
