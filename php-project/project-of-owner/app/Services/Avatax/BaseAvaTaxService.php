<?php


namespace App\Services\Avatax;

use App\Config\AvaTaxConfig;
use Avalara\AvaTaxClient;
use Guzzle\Http\Exception\RequestException;
use GuzzleHttp\Promise;
use http\Client\Request;
use GuzzleHttp\Exception\RequestException as RE;

/**
 * @author aron
 * Class BaseAvaTaxService
 * @package App\Services\Avatax
 */
class BaseAvaTaxService extends AvaTaxClient
{
    private $config; //第三方请求基本配置(密钥 等)
    protected $client;
    public $isTest = AVATAX_TEST == 'production' ? false : true;

    public function __construct()
    {
        $this->config = AvaTaxConfig::avaTax($this->isTest);
        parent::__construct(
            $this->config['appName'],
            $this->config['appVersion'],
            $this->config['machineName'],
            $this->config['enviroment']
        );
        $this->withLicenseKey($this->config['accountId'], $this->config["licenseKey"]);
    }

    /**
     * 修改交易记录原因
     *
     * @return array
     */
    public function adjustReason()
    {
        return [
            'NotAdjusted' => 'The transaction has not been adjusted', //交易尚未调整
            //存在采购问题，导致交易被调整
            'SourcingIssue' => 'A sourcing issue existed which caused the transaction to be adjusted',
            //调整交易以使其与总分类账一致
            'ReconciledWithGeneralLedger' => 'Transaction was adjusted to reconcile it with a general ledger',
            //申请豁免证书后，交易进行了调整
            'ExemptCertApplied' => 'Transaction was adjusted after an exemption certificate was applied',
            //物品价格改变时交易已调整
            'PriceAdjusted' => 'Transaction was adjusted when the price of an item changed',
            //由于产品退货，交易已调整//由于产品退货，交易已调整
            'ProductReturned' => 'Transaction was adjusted due to a product return',
            //由于产品交换，交易已调整
            'ProductExchanged' => 'Transaction was adjusted due to a product exchange',
            //由于坏账或无法收回的债务，交易进行了调整
            'BadDebt' => 'Transaction was adjusted due to bad or uncollectable debt',
            //由于未指定的其他原因调整了交易
            'Other' => 'Transaction was adjusted for another reason not specified',
            // 交易请求过程中,网络请求失败 重新 请求
            'Offline' => 'Offline'
        ];
    }


    /**
     * 由于每个子单需要去估算 税收,会有 多个请求 去估算税收考虑到前台速度问题,需要异步同时发送多个请求
     * 重写了第三方 估算税收接口
     *
     * @param $transactionType 交易请求类型
     * @param null $include
     * @param \Avalara\CreateTransactionModel $model
     * @return array|\Avalara\TransactionModel
     * @throws \Throwable
     */
    public function createTransaction($include = null, $model = [], $transactionType = 'createTransaction')
    {
        $path = "/api/v2/transactions/create";
        if ($transactionType == 'createOrAdjustTransaction') {
            $path = '/api/v2/transactions/createoradjust';
        }
        $headers = $this->headers();
        $data = [];
        foreach ($model as $k => $v) {
            $guzzleParams = [
                'query' => ['$include' => $include],
                'headers' => $headers,
                'body' => json_encode($v),
                'auth' => $this->auth,
                'timeout' => 200
            ];
            $promise[$k] = $this->client->requestAsync('POST', $path, $guzzleParams);
        }
        try {
            $results = Promise\unwrap($promise);
            foreach ($results as $k => $v) {
                $data[$k] = json_decode($v->getBody()->getContents(), true);
            }
            return ['status' => 'success', 'message' => "", 'data' => $data, 'isError' => false];
        } catch (RE $e) {
            $response = '';
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody()->getContents();
            }
            $message =  $response ?  $response : $e->getMessage();
            return [
                'status' => 'error',
                'message' => $message ? $message : 'net work error',
                'data' => [],
                'isError' => true
            ];
        } catch (RequestException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
                'isError' => true
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
                'isError' => true
            ];
        }
    }

    /**
     * 请求头部
     *
     * @return array
     */
    private function headers()
    {
        if (count($this->auth) == 2) {
            $auth = "{$this->appName}; {$this->appVersion}; PhpRestClient; 20.1.0; {$this->machineName}";
            $headers = [
                'Accept' => 'application/json',
                'X-Avalara-Client' => $auth
            ];
        } else {
            $headers = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->auth[0],
                'X-Avalara-Client' => "{$this->appName}; {$this->appVersion};
                 PhpRestClient; 20.1.0; {$this->machineName}"
            ];
        }
        return $headers;
    }
}
