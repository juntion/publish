<?php


namespace App\Services\Avatax;

use App\Models\CountriesToZipNew;
use App\Services\BaseService;
use App\Services\Avatax\BaseAvaTaxService;
use App\Exception\AvaTaxAddressException;
use App\Services\Common\Redis\RedisService;
use App\Request\AvaTaxAddressRequest;
use Carbon\Carbon;

/**
 * 第三方 美国税收接口处理
 *
 * @author aron
 * @date 2019.5.6
 * Class AvataxService
 * @package App\Services\Avatax
 */
class AvaTaxService extends BaseService
{
    private $client; //请求端
    private $shipToAddress; //运输地址
    private $addressError; // 地址验证错误信息
    private $address; // address service
    private $orders;// 设置需要计算税收的产品订单
    private $productsTaxCode = ''; //产品税码
    private $shippingTaxCode = ''; //运输方式税码
    private $companyCode = "DEFAULT"; // 公司编码
    private $orderInfo = []; //saleInvoice 订单基本信息
    public $cache = []; // 估算记录是否缓存
    private $request; //税收地址 本地验证
    private $redis; //redis 服务
    private $validateWithAddress; // 估算税收请求的时候 是否同时发送address 验证
    private $createdOrderInfo; // 订单创建后 orders_number 以及 销售id
    public $defaultLine = 'GENERAL DELIVERY'; //ups 默认允许 运输地址,用户客户无法提供正确地址

    public function __construct()
    {
        parent::__construct();
        $this->client = new BaseAvaTaxService();
        $this->productsTaxCode = 'PC070500';
        $this->shippingTaxCode = 'FR020100';
        $this->redis = new RedisService();
        $this->request = new AvaTaxAddressRequest();
        if ($this->client->isTest) {
            $this->companyCode = 'FSTEST';
        }
    }

    /**
     * 是否缓存第三方返回数据
     * 用于createTransition
     *
     * @param bool $isCache
     * @param int $cacheTime
     * @param string $prefix
     * @return $this
     */
    public function setCache($isCache = true, $cacheTime = 300, $prefix = 'avaTax')
    {
        $this->cache = [
            'expireTime' => (int)$cacheTime,
            'isCache' => (bool)$isCache,
            'prefix' => $prefix
        ];
        return $this;
    }

    /**
     * 设置订单生成后 admin orders number 信息
     *
     * @param array $config
     * @return $this
     */
    public function setCreatedOrderInfo($config = [])
    {
        $this->createdOrderInfo = [
            'currency' => $config['currency'] ? $config['currency'] : "USD",
            'currency_value' => $config["currency_value"] ? $config["currency_value"] : 1,
            'admin_id' => $config['admin_id'] ? $config['admin_id'] : 0, //销售id
            'purchaseOrderNo' => $config['orders_number'] ? $config['orders_number'] : '', //PO号
            'customerCode' => $config['customerCode'] ? $config['customerCode'] : '', //客户id
            'documentCode' => $config['documentCode'] ? $config['documentCode'] : '', //文档id 如果为空第三方会
            //自动生成一个唯一code
            'adjustmentReason' => $config['adjustmentReason'] ? $config['adjustmentReason'] : [] // 修改交易记录原因 用于
            //CreateOrAdjustTransaction 类型税收记录
        ];
        return $this;
    }

    /**
     * 设置运输地址
     *
     * @param array $address
     * @return $this
     */
    public function setAddress(array $address = [])
    {
        foreach ($address as $key => &$value) {
            $value = trim($value);
        }
        $this->shipToAddress = $address;
        return $this;
    }


    /**
     * 美国仓库发货地址
     *
     * @return array
     */
    private static function shipFromAddress()
    {
        return [
            'line1' => '380 Centerpoint Blvd',
            'city' => 'New Castle',
            'country' => 'US',
            'postalCode' => '19720',
            'region' => 'DE'
        ];
    }

    /**
     * 设置税收订单产品信息,可以查询多个订单
     *
     * @param array $orders
     * @return $this
     */
    public function setOrders(array $orders = [])
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * 本地验证地址
     *
     * @throws AvaTaxAddressException
     */
    private function validateAddress()
    {
        $address = $this->shipToAddress;
        $this->request->data = $address;
        $result = $this->request->checkData();
        $model = new CountriesToZipNew();
        if (!empty($address['postalCode'])) {
            $data = $model->select(['zip', 'city', 'states_code'])->where('zip', $address['postalCode'])
                ->first();
            if (!empty($data)) {
                $data = $data->toArray();
                $state = $data['states_code'] ? $data['states_code'] : "";
                if (!empty($state)) {
                    if (strtolower($state) != strtolower($address['region'])) {
                        $result = ['postalCode' => 'invalid shipping address'];
                    }
                }
            }
        }
        if (!empty($result)) {
            throw new AvaTaxAddressException(json_encode($result));
        }
    }

    /**
     * 第三方验证地址
     *
     * @return array|\Avalara\AddressResolutionModel|\stdClass
     */
    public function resolveAddress()
    {
        try {
            $address = $this->shipToAddress;
            $this->validateAddress();
            $line1 = $address['line1']; //主街道地址
            $line2 = $address['line2'] ? $address['line2'] : ""; //子街道地址
            $line3 = "";
            $city = $address['city']; //城市
            $region = $address['region']; //州
            $postalCode = $address['postalCode']; //邮编
            $country = $address['country'];
            $textCase = "Mixed"; //地址类型验证 大小写 验证 是否已大小写混合类型去验证
            $data = $this->client->resolveAddress(
                $line1,
                $line2,
                $line3,
                $city,
                $region,
                $postalCode,
                $country,
                $textCase
            );
        } catch (AvaTaxAddressException $exception) {
            $data = $exception->handleError();
        }
        $this->addressError = $data;
        $data = $this->isValidAddress($data);
        return $data;
    }

    /**
     * 生成 税收计算 需要 地址 格式
     *
     * @param array $address
     * @return array
     */
    private function getTransitionAddress()
    {
        return [
            "shipFrom" => [
                'line1' => self::shipFromAddress()['line1'],
                'city' => self::shipFromAddress()['city'],
                'region' => self::shipFromAddress()['region'],
                'country' => self::shipFromAddress()['country'],
                'postalCode' => self::shipFromAddress()['postalCode']
            ],
            "shipTo" => [
                'line1' => $this->shipToAddress['line1'],
                'city' => $this->shipToAddress['city'],
                'region' => $this->shipToAddress['region'],
                'country' => $this->shipToAddress['country'],
                'postalCode' => $this->shipToAddress['postalCode']
            ]
        ];
    }

    /**
     * 修改shiptoAddress
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function changeShipToAddress($key = '', $value = '')
    {
        $this->shipToAddress[$key] = $value;
        return $this;
    }

    /**
     * 根据地址验证结果判断地址是否有效
     * type 类型 validate  需要客户修改地址   useDefault //使用ups 默认地址
     * @param $result
     * @return array
     */
    public function isValidAddress($result)
    {
        //第三方接口异常 返回的是string类型
        if (is_string($result)) {
            return $this->returnData($result, '', '', false, 'newWork');
        }
        if (is_object($result)) {
            //  程序内部验证失败
            if (isset($result->messages) && is_object($result->messages[0])
                && $result->messages[0]->severity == 'Error') {
                if (isset($result->messages[0]->source) && $result->messages[0]->source == 'validate by FS system') {
                    $message = self::trans("FS_ADDRESS_ERROR6"); // 前台需要统一 第三方错误提示
                    $filed = $result->messages[0]->refersTo;
                    return $this->returnData($message, $filed, [], false, 'validate');
                }
            }
            //第三方验证失败
            if (!empty($result->resolutionQuality) && in_array($result->resolutionQuality, ['NotCoded', 'External'])) {
                $message = self::trans("FS_ADDRESS_ERROR6"); // 前台需要统一 第三方错误提示
                return $this->returnData($message, '', [], false, 'useDefault');
            }
            //第三方验证后地址需要 修改
            if (!empty($result->resolutionQuality) && in_array($result->resolutionQuality, ['Intersection'])) {
                $message = self::trans("FS_ADDRESS_ERROR6"); // 前台需要统一 第三方错误提示
                $validatedAddress = "";
                $isValid = true;
                if (strtolower($result->validatedAddresses[0]->region) != strtolower($this->shipToAddress['region'])) {
                    $isValid = false;
                }
                if ((int)$result->validatedAddresses[0]->postalCode != (int)$this->shipToAddress['postalCode']) {
                    $isValid = false;
                }
                if (strtolower($result->validatedAddresses[0]->city) != strtolower($this->shipToAddress['city'])) {
                    $isValid = false;
                }
                if (!$isValid) {
                    $validatedAddressInfo = $result->validatedAddresses[0];
                    $line2 = $validatedAddressInfo->line2 ? $validatedAddressInfo->line2.", " : "";
                    $validatedAddress = $validatedAddressInfo->line1 . ", " .$line2 .
                        $validatedAddressInfo->city . ', ' . (int)$validatedAddressInfo->postalCode . ", " .
                        $validatedAddressInfo->region;
                    $validatedAddress = '<br/>The validated address is ' . $validatedAddress;
                    return $this->returnData(
                        $message . $validatedAddress,
                        '',
                        [],
                        false,
                        'validate'
                    );
                }
            }

            //第三方验证信息 与客户地址不一致
            if (!empty($result->validatedAddresses[0]) && is_object($result->validatedAddresses[0])) {
                //客户地址无法识别
                if ($result->validatedAddresses[0]->addressType == 'UnknownAddressType') {
                    $message = self::trans("FS_ADDRESS_ERROR6"); // 前台需要统一 第三方错误提示
                    return $this->returnData($message, '', [], false, 'useDefault');
                }
            }
            //客户地址异常
            if ((isset($result->messages) && is_object($result->messages[0])
                && $result->messages[0]->severity == 'Error')) {
                $message = $result->messages[0]->details ? $result->messages[0]->details :
                    'Your shipping address is invalid';
                $filed = $result->messages[0]->refersTo;
                return $this->returnData($message, $filed, [], false, 'useDefault');
            }
        }
        return $this->returnData('success', '', '');
    }


    /**
     * createTransition 所需参数
     *
     * @param string $transitionType 税收记录请求类型 createTransaction 创建交易记录  CreateOrAdjustTransaction 创建或者修改交易记录
     * @param bool $isCommit 是否将 交易记录状态改为commit 用于salesInvoice
     * @param string $type
     * @return array
     */
    private function createTransitionOption(
        $type = 'SalesOrder',
        $transitionType = 'createTransaction',
        $isCommit = false
    ) {
        $options = [];
        foreach ($this->orders as $key => $order) {
            if (!empty($order)) {
                $lines = $this->getTransitionLines($order);
                $address = $this->getTransitionAddress();
                $baseOption = $this->baseTransOption();
                $baseOption['lines'] = $lines;
                $baseOption['addresses'] = $address;
                $baseOption['type'] = $type;
                $baseOption['description'] = $key;
                switch ($type) {
                    case "SalesOrder":
                        $baseOption['commit'] = false; //是否 将该交易更改为 commit 状态 commit状态 可以直接报税
                        break;
                    case "SalesInvoice":
                        $baseOption['purchaseOrderNo'] = isset($this->createdOrderInfo['purchaseOrderNo'])
                            ? $this->createdOrderInfo['purchaseOrderNo'] : ""; //订单编号
                        $baseOption['salespersonCode'] = isset($this->createdOrderInfo['admin_id'])
                            ? $this->createdOrderInfo['admin_id'] : 0;//销售id
                        $baseOption['commit'] = $isCommit;
                        if ($transitionType == 'createOrAdjustTransaction') {
                            $transData['createTransactionModel'] = $baseOption;
                            $transData['adjustmentReason'] = $this->createdOrderInfo['adjustmentReason']
                            ['adjustmentReason'] ?
                                $this->createdOrderInfo['adjustmentReason']['adjustmentReason'] : '';
                            $transData['adjustmentDescription'] = $this->createdOrderInfo['adjustmentReason']
                            [$transData['adjustmentReason']] ?
                                $this->createdOrderInfo['adjustmentReason'][$transData['adjustmentReason']] :
                                'offline';
                            $baseOption = $transData;
                        }
                        break;
                }
                $options[$key] = $baseOption;
            }
        }
        return $options;
    }

    /**
     * 查询订单信息
     *
     * @param string $transitionType 税收记录请求类型 createTransaction 创建交易记录  CreateOrAdjustTransaction 创建或者修改交易记录
     * @param string $type
     * @return array|\Avalara\TransactionModel|string
     * @throws \Throwable
     */
    public function createTransition($type = 'SalesOrder', $transitionType = 'createTransaction')
    {
        $options = $this->createTransitionOption($type, $transitionType);
        if ($this->validateWithAddress) {
            $options['address'] = $this->shipToAddress;
        }
        if ($this->cache['isCache']) {
            $key = json_encode($options);
            $data = RedisService::getRedisKeyValue($key, $this->cache['prefix']);
            if (!empty($data) && $data['status'] == 'success') {
                return $this->resolveTransitionResult($data);
            } else {
                $data = $this->client->createTransaction(null, $options, $transitionType);
                RedisService::setRedisKeyValue($key, $data, $this->cache['expireTime'], $this->cache['prefix']);
            }
        } else {
            $data = $this->client->createTransaction(null, $options, $transitionType);
        }
        $data = $this->resolveTransitionResult($data);
        return $data;
    }

    /**
     * 验证交易 税收估算结果
     *
     * @param $data
     * @return array
     */
    public function resolveTransitionResult($data)
    {
        if ($data['status'] == 'error') {
            return $this->returnData($data['message'], '', '', false, 'error');
        }
        return $this->returnData($data['message'], '', $data['data']);
    }

    /**
     * @param string $message
     * @param string $filled
     * @param array $data
     * @param bool $status
     * @param string $type
     * @return array
     */
    private function returnData($message = "", $filled = "", $data = [], $status = true, $type = 'success')
    {
        return ['status' => $status, 'message' => $message, 'type' => $type, 'filed' => $filled, 'data' => $data];
    }


    /**
     * Transition request 参数 基本信息
     *
     * @return array
     */
    private function baseTransOption()
    {
        return [
            //unique id
            'code' => $this->createdOrderInfo['documentCode'] ? $this->createdOrderInfo['documentCode'] : "",
            'companyCode' => $this->companyCode, //第三方平台设置公司code
            'date' => Carbon::now('America/Los_Angeles')->format('Y-m-d'),  //交易生成日期
            //客户编号 customerNumber 后期和免税id 关联
            'customerCode' => $this->createdOrderInfo['customerCode'] ? $this->createdOrderInfo['customerCode'] : 0,
            'entityUseCode' => $this->createdOrderInfo['customerCode'] ? $this->createdOrderInfo['customerCode'] : 0,
            // 交易货币类型
            'currencyCode' => $this->createdOrderInfo['currency'] ? $this->createdOrderInfo['currency'] : "USD",
            //交易汇率
            'exchangeRate' => $this->createdOrderInfo['currency_value'] ? $this->createdOrderInfo['currency_value'] : 1
        ];
    }


    /**
     * 根据订单产品生成lines
     *
     * @param array $products
     * @return array
     */
    private function getTransitionLines(array $products = [])
    {
        $line = [];
        foreach ($products as $k => $product) {
            $taxCode = $this->productsTaxCode;
            $prefix = "";
            if (isset($product['type']) && $product['type'] == 'shipping') {
                $itemCode = 'Shipping';
                $taxCode = $this->shippingTaxCode;
            } else {
                $itemCode = $product['id'];
            }
            $line[] = [
                'number' => $k + 1, //line 编号
                'quantity' => (int)$product['qty'], //产品数量
                'taxCode' => $taxCode, //产品税码
                'itemCode' => $prefix . $itemCode, //产品编号 后期可能会将改code 与 taxCode 绑定
                'description' => $product['name'], //产品描述
                'amount' => self::zenRound($product['paypal_price'] * $product['qty']
                    * $this->createdOrderInfo['currency_value']) //产品金额
            ];
        }
        return $line;
    }

    /**
     * 将 第三方接口返回数据 重新构造 存入 avaTaxRecords 表
     *
     * @param array $data
     * @return array
     */
    public function formatResponseData($data = [])
    {
        if (empty($data)) {
            return [];
        }
        $result = [];
        foreach ($data as $k => $v) {
            $result['transition_id'] = $v['id'];
            $result['totalTax'] = $v['totalTax'];
            $result['totalTaxable'] = $v['totalTaxable']; // 可收税金额
            $result['totalAmount'] = $v['totalAmount']; //产品总金额
            $result['totalExempt'] = $v['totalExempt']; // 总免税金额
            $result['products'] = [];//产品信息
            if (!empty($v['lines'])) {
                foreach ($v['lines'] as $vv) {
                    $result['products'][$vv['itemCode']] = [
                        'tax' => $vv['tax'], //产品总税收金额
                        'taxableAmount' => $vv['taxableAmount'], // 产品可以收税金额
                        'lineAmount' => $vv['lineAmount'], // 产品总金额
                        'qty' => $vv['quantity'] //产品总数量
                    ];
                    foreach ($vv['details'] as $vvv) {
                        $result['products'][$vv['itemCode']]['rate'][] = [
                            'jurisName' => $vvv['jurisName'], //收税机构名称
                            'jurisdictionId' => $vvv['jurisdictionId'], //收税机构 id
                            'tax' => $vvv['tax'], //当前产品税价格
                            'rate' => $vvv['rate'], // 税率
                            'taxName' => $vvv['taxName'] //税收名称
                        ];
                    }
                }
            }
        }
        return $result;
    }

    public function addressError()
    {
        $data = [
            'AddressError',
            'PostalCodeError',
            'AddressRangeError',
            'InvalidZipForStateError',
            'TaxAddressError',
            'RegionCodeError',
            'ZipNotValidError',
            'CountryError',
            'AddressNotGeocodedError'
        ];
        return array_map("strtolower", $data);
    }
}
