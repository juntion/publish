<?php

namespace App\Services\Avatax;

use App\Services\BaseService;
use GuzzleHttp\Client;
use App\Config\AvaTaxConfig;
use App\Services\Avatax\BaseAvaTaxService;

/**
 * 免税接口申请
 *
 * Class AvaTaxExemptionsService
 * @package App\Services\Avatax
 */
class AvaTaxExemptionsService extends BaseService
{
    public $client;
    public $isTest;
    public $companyId = '124361';
    public $config = [];
    public $customers = " ";

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'base_uri' => 'https://api.certcapture.com',
            'timeout' => 30,
        ]);
        $this->config = AvaTaxConfig::avaTaxExemption();
        $this->baseService = new BaseAvaTaxService();
        if (AVATAX_TEST != 'production') {
            $this->companyId = '124372';
        }
    }

    /**
     * 设置客户编号
     *
     * @param string $customers
     * @return $this
     */
    public function setCustomers($customers = "")
    {
        $this->customers = $customers;
        return $this;
    }

    /**
     * 生成token
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createToken()
    {
        $authUrl = '/v2/auth/get-token';
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'x-customer-number' => $this->customers
            ]
        ];
        $return = $this->call("POST", $authUrl, $params);
        return $return;
    }

    /**
     * 获取客户免税信息
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryData()
    {
        $authUrl = '/v2/customers/'.$this->customers.'?page=1';
        $expand = '["certificates"]';
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'x-customer-number' => $this->customers,
                'x-customer-primary-key' => 'customer_number'
            ],
            'query' => ['expand' => $expand]
        ];
        $return = $this->call("GET", $authUrl, $params);
        return $return;
    }

    /**
     * 获取客户pdf免税信息
     * @param int $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPdf($id)
    {
        $authUrl = '/v2/certificates/'.$id.'/get-pdf';
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'x-customer-number' => $this->customers
            ]
        ];
        $return = $this->call("GET", $authUrl, $params);
        return $return;
    }

    /**
     * 获取客户单个证书
     * @param int $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCertificates($id)
    {
        $authUrl = '/v2/certificates/'.$id;
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'x-customer-number' => $this->customers
            ],
        ];
        $return = $this->call("GET", $authUrl, $params);
        return $return;
    }

    /**
     * 删除单个客户证书
     * @param int $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeCertificates($id)
    {
        $authUrl = '/v2/certificates/'.$id.'/customers';
        $body = 'customers=[{"customer_number":'.$this->customers.'}]';
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'x-customer-number' => $this->customers
            ],
            'body' => $body
        ];
        $return = $this->call("DELETE", $authUrl, $params);
        return $return;
    }

    /**
     * 删除客户证书
     * @param int $id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeOneCertificates($id)
    {
        $authUrl = '/v2/certificates/'.$id;
        $params = [
            'headers' => [
                'x-client-id' => $this->companyId,
                'Authorization' => $this->generateAuth(),
                'x-customer-number' => $this->customers
            ],
        ];
        $return = $this->call("DELETE", $authUrl, $params);
        return $return;
    }

    /**
     * @param $method
     * @param $path
     * @param array $params
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function call($method, $path, $params = [])
    {
        try {
            $response = $this->client->request($method, $path, $params);
            $data = $response->getBody()->getContents();
            return ['status' => true, 'data' => $data];
        } catch (\ Exception $e) {
            return ['status' => false, 'data' => $e->getMessage()];
        }
    }

    /**
     * 生成auth密钥
     *
     * @return string
     */
    private function generateAuth()
    {
        $code = base64_encode($this->config['userName'] . ':' . $this->config['password']);
        return 'Basic ' . $code;
    }
}
