<?php
/**
 * Created by PhpStorm.
 * User: ARON
 * Date: 2018/7/16
 * Time: 下午5:23
 */
require_once 'vendor/autoload.php';

use Ingenico\Connect\Sdk\CommunicatorConfiguration;
use Ingenico\Connect\Sdk\Communicator;
use Ingenico\Connect\Sdk\Client;
use Ingenico\Connect\Sdk\DefaultConnection;
use Ingenico\Connect\Sdk\ApiException;
use Ingenico\Connect\Sdk\ResponseException;
use Ingenico\Connect\Sdk\DeclinedPaymentException;
use Ingenico\Connect\Sdk\InvalidResponseException;
use Ingenico\Connect\Sdk\Domain\Definitions\Address;
use Ingenico\Connect\Sdk\Domain\Definitions\AmountOfMoney;
use Ingenico\Connect\Sdk\Domain\Definitions\Card;
use Ingenico\Connect\Sdk\Domain\Definitions\CompanyInformation;
use Ingenico\Connect\Sdk\Domain\Payment\ApprovePaymentRequest;
use Ingenico\Connect\Sdk\Domain\Payment\CreatePaymentRequest;
use Ingenico\Connect\Sdk\Domain\Payment\PaymentApprovalResponse;
use Ingenico\Connect\Sdk\Domain\Payment\PaymentResponse;
use Ingenico\Connect\Sdk\Domain\Payment\TokenizePaymentRequest;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\AddressPersonal;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\ApprovePaymentNonSepaDirectDebitPaymentMethodSpecificInput;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\CardPaymentMethodSpecificInput;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\ContactDetails;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\Customer;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\Order;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\OrderApprovePayment;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\OrderReferences;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\OrderReferencesApprovePayment;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\PersonalInformation;
use Ingenico\Connect\Sdk\Domain\Payment\Definitions\PersonalName;
use Ingenico\Connect\Sdk\Domain\Token\CreateTokenResponse;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\Definitions\HostedCheckoutSpecificInput;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\Definitions\PaymentProductFiltersHostedCheckout;
use Ingenico\Connect\Sdk\Domain\Definitions\PaymentProductFilter;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\CreateHostedCheckoutRequest;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\CreateHostedCheckoutResponse;
use Ingenico\Connect\Sdk\Domain\Hostedcheckout\GetHostedCheckoutResponse;

class Globalcollect
{
    /**
     * code instruction
     * 11000->ApproveChallengedPayment
     */
    protected $is_test = false;
    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * @var Client|null
     */
    protected $proxyClient = null;
    /**
     * @var string
     * api key
     * ç prepare
     */
    private $apiKeyId = PAYMENT_GLOBALCOLLECT_API_KEY;
    /**
     * @var string
     * api secret
     * jn5XXYelyMePfTtv7NK+OYkkHHEMlGk+KwgWEhreZDE= prpare
     */
    private $apiSecret = PAYMENT_GLOBALCOLLECT_API_SECRET;
    /**
     * @var string
     * api request url
     * prepare https://world.preprod.api-ingenico.com
     */
    private $apiEndPoint = "https://world.api-ingenico.com";
    /**
     * @var string
     * company
     */
    private $intergrator = "Fiberstore";

    /**
     * merchant_id
     * prepare 4882
     */
    private $merchantId = 4882;
    private $merchantId_t = 6504;
    /**
     * @var array
     */
    public $config = array();

    /**
     * 模版
     */
    private $variant = 109;

    /**
     * Globalcollect constructor.
     */
    public function __construct()
    {
        if ($this->is_test) {
            $this->apiKeyId = "84727a1a1c8a9013";
            $this->merchantId = 4882;
            $this->merchantId_t = 6504;
            $this->variant = 106;
            $this->apiSecret = "jn5XXYelyMePfTtv7NK+OYkkHHEMlGk+KwgWEhreZDE=";
            $this->apiEndPoint = "https://world.preprod.api-ingenico.com";
            $this->apiKeyId = "e72e3cf78f3bd723";
            $this->apiSecret = "44ev6d2ZkTu+dtSxGkUFKMbc09F64YUfbl8xXi+TKtc=";
        }
        error_reporting(0);
        register_shutdown_function(function () {
            $e = error_get_last();
            switch ($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    $errorContent = implode('</br>#', explode('#', $e['message'] . ' ' . $e['file'] . ' ' . 'line:' . $e['line']));
                    return array("status" => "error", "message" => $e['message'], "code" => "1000066", "payment_id" => 0, "response_string" => "", "out_message" => $this->error(130));
                    exit;
                    break;
            }
        });
        $this->getClient();
    }

    public function set_config($config)
    {
        $this->config = $config;
    }

    /**
     * @return Client|null
     */
    protected function getClient()
    {
        $communicatorConfiguration = new CommunicatorConfiguration($this->apiKeyId, $this->apiSecret, $this->apiEndPoint, $this->intergrator);
        $connection = new DefaultConnection();
        $communicator = new Communicator($connection, $communicatorConfiguration);
        $this->client = new Client($communicator);
        return $this->client;
    }

    /**
     * @return array
     */
    public function pay_global()
    {
        $card = new Card();
        $config = $this->config;
        $card->cardNumber = $config['card_number'];
        $card->cardholderName = $config['cardholder_name'];
        $card->cvv = $config['cvv'];
        $card->expiryDate = $config['expiryDate'];
        $client = $this->client;
        $cardPaymentMethodSpecificInput = new CardPaymentMethodSpecificInput();
        $cardPaymentMethodSpecificInput->card = $card;
        $cardPaymentMethodSpecificInput->paymentProductId = $config['payment_method'];
        $cardPaymentMethodSpecificInput->authorizationMode = "SALE";
        $amountOfMoney = new AmountOfMoney();
        $amountOfMoney->amount = $config['amount'];
        $amountOfMoney->currencyCode = $config["currency"];


        $billingAddress = new Address();
        $billingAddress->countryCode = $config['billing_country_code'];

        if ($billingAddress->countryCode == 'XB' || $billingAddress->countryCode == 'XE') {
            $billingAddress->countryCode = 'BQ';
        }

        $billingAddress->city = $config['billing_city'];
        if (!empty($billingAddress->state)) {
            $billingAddress->state = $config['billing_state'];
        }
        $billingAddress->street = $config['billing_street'] ? substr($this->getNewStr($config['billing_street']), 0, 14) : "";
        $billingAddress->zip = $config['billing_zip'];


        $shippingName = new PersonalName();
        $shippingName->firstName = $config['shipping_firstName'];
        $shippingName->surname = $config['shipping_lastName'];


        $shippingAddress = new AddressPersonal();
        $shippingAddress->city = $config['shipping_city'];
        $shippingAddress->countryCode = $config['shipping_country_code'];
        $shippingAddress->name = $shippingName;
        if (!empty($config['shipping_state'])) {
            $shippingAddress->state = $config['shipping_state'];
        }
        $shippingAddress->zip = $config['shipping_zip'];

        $contactDetails = new ContactDetails();
        $contactDetails->emailAddress = $config['email'];

        $companyInformation = new CompanyInformation();
        $companyInformation->name = $config['company'];

        $customer = new Customer();
        $customer->billingAddress = $billingAddress;
        $customer->shippingAddress = $shippingAddress;
        $customer->contactDetails = $contactDetails;
        $customer->merchantCustomerId = $config['customer_id'];
        $customer->companyInformation = $companyInformation;
        $references = new OrderReferences();
        $references->merchantReference = $config['merchant_reference'];
        $references->merchantOrderId = $config['order_id'];

        $order = new Order();
        $order->amountOfMoney = $amountOfMoney;;
        $order->customer = $customer;
        $order->references = $references;

        $body = new CreatePaymentRequest();
        $body->order = $order;
        $body->cardPaymentMethodSpecificInput = $cardPaymentMethodSpecificInput;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $this->merchantId = $this->merchantId_t;
        }

        try {
            $response = $client->merchant($this->merchantId)->payments()->create($body);
            $response_string = $response ? json_encode($response, JSON_FORCE_OBJECT) : "";
            $payment_id = $response->payment->id;
            $status = $response->payment->status;
            $statusCategory = $response->payment->statusOutput->statusCategory;
            $status_code = $response->payment->statusOutput->statusCode;
            if (empty($payment_id)) {
                $data = array("status" => "error", "message" => $status, $payment_id => 0, "code" => $status_code, "response_string" => $response_string, "out_message" => $this->error($status_code));
                return $data;
            }
            /**
             * PENDING_MERCHANT
             * 需要人工审核的订单
             * Approves challenged payment 调用该接口
             */
            if ($statusCategory == "PENDING_CONNECT_OR_3RD_PARTY" || $statusCategory == "COMPLETED") {
                $data = array("status" => "success", "payment_id" => $payment_id, "code" => $status_code, "message" => "successful", "response_string" => $response_string);
            } elseif ($statusCategory == "PENDING_MERCHANT") {
                switch ($status) {
                    case "PENDING_FRAUD_APPROVAL":
                        $data = $this->ApproveChallengedPayment($payment_id);
                        break;
                    case "PENDING_APPROVAL":
                        $data = $this->ApprovePayment($payment_id);
                        break;
                    default:
                        $data = array("status" => "error", "code" => "$status_code", "message" => $status, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($status_code));
                }
            } else {
                $data = array("status" => "error", "message" => $status, "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($status_code));
            }
            return $data;
        } catch (DeclinedPaymentException $e) {
            $data = $this->handleDeclineApi($e);
            return $data;
        } catch (ApiException $e) {
            $data = $this->handleExceptionApi($e);
            return $data;
        } catch (ResponseException $e) {
            $data = $this->handleExceptionApi($e);
            return $data;
        } catch (InvalidResponseException $e) {
            $data = array("status" => "error", "message" => "Invalid content type", "code" => 11002, "payment_id" => 0, "response_string" => "", "out_message" => $this->error(130));
            return $data;
        }
    }

    /**
     * @param $e
     * @return array
     */
    protected function handleExceptionApi($e)
    {
        $errors = $e->getErrors();
        $status = $e->getHttpStatusCode();
        $response_string = $e->getResponse() ? json_encode($e->getResponse(), JSON_FORCE_OBJECT) : "";
        $data = array("status" => "error", "message" => $errors[0]->message, "code" => $status, "payment_id" => 0, "response_string" => $response_string, "out_message" => $this->error($status));
        return $data;
    }

    protected function handleDeclineApi($e)
    {
        $response = $e->getPaymentResult();
        $response_string = $response ? json_encode($response, JSON_FORCE_OBJECT) : "";
        $payment_id = $response->payment->id;
        $status = $response->payment->statusOutput->errors[0]->message;
        $error_id = $response->payment->statusOutput->errors[0]->code;
        $status_code = $response->payment->statusOutput->statusCode;
        $data = array("status" => "error", "message" => $status, "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->getDeclineMessage($status_code));
        return $data;
    }

    /**
     * @param $paymentId
     * @return array
     */
    public function ApprovePayment($paymentId)
    {
        $client = $this->client;
        $config = $this->config;
        $merchantId = $this->merchantId;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $merchantId = $this->merchantId_t;
        }
        $approvePaymentRequest = new ApprovePaymentRequest();
        $token = $this->CreateTokenFromPayment($paymentId);
        if (empty($token)) {
            $data = array("status" => "error", "message" => "invalid token", "code" => 10089, "response_string" => "", "out_message" => $this->error(130));
            return $data;
        }
        try {
            $directDebitPaymentMethodSpecificInput = new ApprovePaymentNonSepaDirectDebitPaymentMethodSpecificInput();
            $directDebitPaymentMethodSpecificInput->dateCollect = date("Ymd");
            $directDebitPaymentMethodSpecificInput->token = $token;
            $approvePaymentRequest->directDebitPaymentMethodSpecificInput = $directDebitPaymentMethodSpecificInput;

            $orderApprovePayment = new OrderApprovePayment();
            $orderReferencesApprovePayment = new OrderReferencesApprovePayment();
            $orderReferencesApprovePayment->merchantReference = $this->config['merchant_reference'];
            $orderApprovePayment->references = $orderReferencesApprovePayment;
            $approvePaymentRequest->order = $orderApprovePayment;
            $approvePaymentRequest->amount = $this->config['amount'];
            /** @var PaymentApprovalResponse $paymentApprovalResponse */
            $paymentApprovalResponse = $client->merchant($merchantId)->payments()->approve($paymentId, $approvePaymentRequest);
            $response_string = json_encode($paymentApprovalResponse, JSON_FORCE_OBJECT);
            $status_catogery = $paymentApprovalResponse->payment->statusOutput->statusCategory;
            $payment_id = $paymentApprovalResponse->payment->id;
            $status_code = $paymentApprovalResponse->payment->statusOutput->statusCode;
            if ($status_catogery == "PENDING_CONNECT_OR_3RD_PARTY" || $status_catogery == "COMPLETED") {
                $data = array("status" => "success", "code" => $status_code, "payment_id" => $payment_id, 'message' => "successful", "response_string" => $response_string);
                return $data;
            } else {
                $data = array("status" => "error", "message" => $status_catogery, "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($status_code));
                return $data;
            }
        } catch (DeclinedPaymentException $e) {
            $data = $this->handleDeclineApi($e);
            return $data;
        } catch (ApiException $e) {
            $data = $this->handleExceptionApi($e);
            return $data;
        } catch (ResponseException $e) {
            return $this->handleExceptionApi($e);
        }
    }

    /**
     * @depends testApprovePayment
     * @param string $paymentId
     * @return string
     * @throws ApiException
     */

    public function CreateTokenFromPayment($paymentId)
    {
        $client = $this->client;
        $config = $this->config;
        $merchantId = $this->merchantId;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $merchantId = $this->merchantId_t;
        }
        $tokenizePaymentRequest = new TokenizePaymentRequest();
        $tokenizePaymentRequest->alias = "Approve payment";
        /** @var CreateTokenResponse $createTokenResponse */
        $createTokenResponse = $client->merchant($merchantId)->payments()->tokenize($paymentId, $tokenizePaymentRequest);
        return $createTokenResponse->token;
    }

    /**
     * @param $paymentId
     * @return array|bool|string
     */
    public function ApproveChallengedPayment($paymentId)
    {

        $client = $this->client;
        $config = $this->config;
        $merchantId = $this->merchantId;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $merchantId = $this->merchantId_t;
        }
        /** @var PaymentResponse $paymentApprovalResponse */
        try {
            $paymentApprovalResponse = $client->merchant($merchantId)->payments()->processchallenged($paymentId);
            $response_string = $paymentApprovalResponse ? json_encode($paymentApprovalResponse, JSON_FORCE_OBJECT) : "";
            $payment_id = $paymentApprovalResponse->id;
            $status = $paymentApprovalResponse->status;
            $status_catogery = $paymentApprovalResponse->statusOutput->statusCategory;
            $status_code = $paymentApprovalResponse->statusOutput->statusCode;
            if ($status_catogery == "PENDING_CONNECT_OR_3RD_PARTY" || $status_catogery == "COMPLETED") {
                $data = array("status" => "success", "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, 'message' => "successful");
                return $data;
            } elseif ($status_catogery == "PENDING_MERCHANT") {
                if ($status == "PENDING_APPROVAL") {
                    $data = $this->ApprovePayment($payment_id);
                    return $data;
                } else {
                    $data = array("status" => "error", "message" => $status_catogery, "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($status_code));
                    return $data;
                }
            } else {
                $data = array("status" => "error", "message" => $status_catogery, "code" => $status_code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($status_code));
                return $data;
            }
        } catch (DeclinedPaymentException $e) {
            $data = $this->handleDeclineApi($e);
            return $data;
        } catch (ApiException $e) {
            $data = $this->handleExceptionApi($e);
            return $data;
        } catch (ResponseException $e) {
            return $this->handleExceptionApi($e);
        }
    }

    public function getDeclineMessage($status)
    {
        if ($status == 160) {
            $message = "<ul><li>" . DECLINE_CREDIT . "</li><li>" . DECLINE_CREDIT1 . "</li><li>" . DECLINE_CREDIT2 . "</li><li> " . DECLINE_CREDIT3 . "</li><li> " . DECLINE_CREDIT8 . "</li><li> " . DECLINE_CREDIT4 . "</li></ul>" .
                "<a href=" . zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST, '&orders_id=' . $this->config['order_id'], 'SSL') . ">" . DECLINE_CREDIT9 . "</a>";
        } else {
            $message = DECLINE_CREDIT7 . "<a href=" . zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST, '&orders_id=' . $this->config['order_id'], 'SSL') . ">" . DECLINE_CREDIT9 . "</a>";
        }
        return $message;
    }


    /**
     * @return array|CreateHostedCheckoutResponse
     */
    public function testCreateHostedCheckout()
    {
        $client = $this->client;
        $return_url = zen_href_link("credit_cart_process");
        $createHostedCheckoutRequest = new CreateHostedCheckoutRequest();
        $config = $this->config;
        $amountOfMoney = new AmountOfMoney();
        $amountOfMoney->amount = $config['amount'];
        $amountOfMoney->currencyCode = $config["currency"];

        $billingAddress = new Address();
        $billingAddress->countryCode = $config['billing_country_code'];
        $billingAddress->city = $config['billing_city'] ? mb_substr($this->getNewStr($config['billing_city']), 0, 14, "utf-8") : "";
        if (!empty($billingAddress->state)) {
            $billingAddress->state = $config['billing_state'] ? mb_substr($this->getNewStr($config['billing_state']), 0, 14, "utf-8") : "";
        }
        $billingAddress->street = $config['billing_street'] ? mb_substr($this->getNewStr($config['billing_street']), 0, 14, "utf-8") : "";
        $billingAddress->zip = $config['billing_zip'] ? mb_substr($this->getNewStr($config['billing_zip']), 0, 14, "utf-8") : "";


        $shippingName = new PersonalName();
        $shippingName->firstName = $config['shipping_firstName'];
        $shippingName->surname = $config['shipping_lastName'];


        $shippingAddress = new AddressPersonal();
        $shippingAddress->city = $config['shipping_city'] ? mb_substr($this->getNewStr($config['shipping_city']), 0, 14, "utf-8") : "";
        $shippingAddress->countryCode = $config['shipping_country_code'];
        $shippingAddress->name = $shippingName;
        if (!empty($config['shipping_state'])) {
            $shippingAddress->state = $config['shipping_state'] ? mb_substr($this->getNewStr($config['shipping_state']), 0, 14, "utf-8") : "";
        }
        $shippingAddress->zip = $config['shipping_zip'] ? mb_substr($this->getNewStr($config['shipping_zip']), 0, 14, "utf-8") : "";

        $contactDetails = new ContactDetails();
        $contactDetails->emailAddress = $config['email'];

        $companyInformation = new CompanyInformation();
        $companyInformation->name = $config['company'] ? mb_substr($this->getNewStr($config['company']), 0, 14, "utf-8") : "";

        $customer = new Customer();
        $customer->billingAddress = $billingAddress;
        $customer->shippingAddress = $shippingAddress;
        $customer->contactDetails = $contactDetails;
        $customer->merchantCustomerId = $config['customer_id'];
        $customer->companyInformation = $companyInformation;
        $references = new OrderReferences();
        $references->merchantReference = $config['merchant_reference'];
        $references->merchantOrderId = $config['order_id'];

        $order = new Order();
        $order->amountOfMoney = $amountOfMoney;;
        $order->customer = $customer;
        $order->references = $references;

        $createHostedCheckoutRequest->order = $order;

        $hostedCheckoutSpecificInput = new HostedCheckoutSpecificInput();
        /**
         * 设置语言包
         */
        $hostedCheckoutSpecificInput->locale = $config['language_code'];
        /**
         * 付款类型为 diners 或者是discover 用另外一个账户
         */
        $merchantId = $this->merchantId;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $merchantId = $this->merchantId_t;
        }
        $variant = $this->variant;
        if (in_array($merchantId, [4882, 6504])) {
            $variant = 109;
        }
        /**
         * 设置托管支付模版
         * 110 test
         * 102 product
         */
        $hostedCheckoutSpecificInput->variant = $variant;
        $createHostedCheckoutRequest->hostedCheckoutSpecificInput = $hostedCheckoutSpecificInput;
        /**
         * 设置订单付款结果回调页面
         */
        $createHostedCheckoutRequest->hostedCheckoutSpecificInput->returnUrl = $return_url;
        /**
         * 是否为客户展示付款结果页面
         */
        $createHostedCheckoutRequest->hostedCheckoutSpecificInput->showResultPage = false;
        /**
         * 设置客户取消付款后返回CANCELLED_BY_CONSUMER状态
         */
        $createHostedCheckoutRequest->hostedCheckoutSpecificInput->returnCancelState = true;
        $hostedCheckoutSpecificInput->paymentProductFilters = new PaymentProductFiltersHostedCheckout();
        /**
         * 对付款类型进行筛选,直接拉取当前付款类型结账页面
         */
        $hostedCheckoutSpecificInput->paymentProductFilters->restrictTo = new PaymentProductFilter();
        $hostedCheckoutSpecificInput->paymentProductFilters->restrictTo->products = $config['payment_method'];
        /** @var CreateHostedCheckoutResponse $createHostedCheckoutResponse */
        try {
            $data = $createHostedCheckoutResponse = $client->merchant($merchantId)->hostedcheckouts()->create($createHostedCheckoutRequest);
            return $data;
        } catch (ResponseException $e) {
            return $this->handleExceptionApi($e);
        }
    }

    /**
     * @depends testCreateHostedCheckout
     * @param string $hostedCheckoutId
     * @return array
     * @throws ApiException
     */
    public function testGetHostedCheckoutStatus($hostedCheckoutId)
    {
        $client = $this->client;
        $config = $this->config;
        $merchantId = $this->merchantId;
        if ($config["payment_method"] == 128 || $config['payment_method'] == 132) {
            $merchantId = $this->merchantId_t;
        }
        /** @var GetHostedCheckoutResponse $getHostedCheckoutResponse */
        try {
            $response = $client->merchant($merchantId)->hostedcheckouts()->get($hostedCheckoutId);
            $response_string = $response ? json_encode($response, JSON_FORCE_OBJECT) : "";
            $origin_status = $response->status;
            /**
             * 订单付款状态由上至下逐层判断
             * CANCELLED_BY_CONSUMER IN_PROGRESS   由客户取消付款后的状态
             * PAYMENT_CREATED 付款以创建
             */
            if ($origin_status == "CANCELLED_BY_CONSUMER" || $origin_status == "IN_PROGRESS") {
                $data = array("status" => "error", "payment_id" => 0, "code" => "", "message" => $origin_status, "response_string" => $response_string);
            } elseif ($origin_status == "PAYMENT_CREATED") {
                $paymentStatusCategory = $response->createdPaymentOutput->paymentStatusCategory;
                $status = $response->createdPaymentOutput->payment->status;
                $payment_id = $response->createdPaymentOutput->payment->id;
                $statusCategory = $response->createdPaymentOutput->payment->statusOutput->statusCategory;
                $code = $response->createdPaymentOutput->payment->statusOutput->statusCode;
                if (in_array($paymentStatusCategory, array("REJECTED", "STATUS_UNKNOWN"))) {
                    $data = array("status" => "error", "payment_id" => $payment_id, "code" => $code, "message" => $status, "response_string" => $response_string);
                } else {
                    if ($statusCategory == "PENDING_CONNECT_OR_3RD_PARTY" || $statusCategory == "COMPLETED") {
                        $data = array("status" => "success", "payment_id" => $payment_id, "code" => $code, "message" => "successful", "response_string" => $response_string);
                    } elseif ($statusCategory == "PENDING_MERCHANT") {
                        /**
                         * 如果当前订单被标记为可疑订单,自动审核
                         * 如果当前订单需要人工审核,自动审核
                         */
                        switch ($status) {
                            case "PENDING_FRAUD_APPROVAL":
                                $data = $this->ApproveChallengedPayment($payment_id);
                                break;
                            case "PENDING_APPROVAL":
                                $data = $this->ApprovePayment($payment_id);
                                break;
                            default:
                                $data = array("status" => "error", "code" => $code, "message" => $status, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($code));
                        }
                    } else {
                        $data = array("status" => "error", "message" => $status, "code" => $code, "payment_id" => $payment_id, "response_string" => $response_string, "out_message" => $this->error($code));
                    }
                }
            } else {
                $data = array("status" => "error", "payment_id" => 0, "code" => 0, "message" => "UNKNOWN ERROR", "response_string" => $response_string);
            }
            return $data;
        } catch (ResponseException $e) {
            return $this->handleExceptionApi($e);
        }
    }

    function error($status_id)
    {
        global $db;
        $description = "";
        $error = array(
            0 => 'The payment attempt was created',
            20 => 'The HostedMerchantLink transaction is waiting for the consumer to be redirected by the merchant to WebCollect',
            25 => 'The HostedMerchantLink transaction is waiting for the consumer to enter missing data on the payment pages of GlobalCollect',
            30 => 'The Hosted Merchant Link transaction is waiting for WebCollect to redirect the consumer to the bank payment pages (optionally, after the consumer enters missing data)',
            50 => 'The payment request and consumer have been forwarded to the payment pages of the bank',
            55 => 'The consumer received all payment details to initiate the transaction the consumer must go to the (bank) office to initiate the payment',
            60 => 'The consumer is not enrolled for 3D Secure authentications',
            65 => 'The consumer is at an office to initiate a transaction 
				The status is used when the supplier polls the WebCollect database to verify if a payment on an order is (still) possible',
            70 => 'The status of the payment is in doubt at the bank',
            100 => 'WebCollect rejected the payment instruction',
            120 => 'The bank rejected the payment',
            125 => 'The consumer cancelled the payment while on the bank payment page',
            130 => 'The payment has failed',
            140 => 'The payment was not completed within the given set time limit by the consumer and is expired<BR/>The payment has failed',
            150 => 'WebCollect did not receive information regarding the outcome of the payment at the bank',
            160 => 'The transaction had been rejected for reasons of suspected fraud',
            170 => 'The authorization is expired because no explicit settlement request was received in time',
            172 => 'The enrolment period was pending for too long',
            175 => 'The validation period was pending for too long',
            180 => 'The cardholder authentication response from the bank was invalid or not completed',
            190 => 'The settlement is rejected
			Used in a captured by GlobalCollect credit card online transaction, specifically ATOS',
            200 => 'The cardholder was successfully authenticated',
            220 => 'The authentication service was out of order; the cardholder could not be authenticated',
            230 => 'The cardholder is not participating in the 3D Secure authentication program',
            280 => 'The cardholder authentication response from the bank was invalid or not completed
			Authorization is not possible',
            300 => 'This payment will be re-authorized and settled offline',
            310 => 'The consumer is not enrolled for 3D Secure authenticationb Authorization is not possible',
            320 => 'The authentication service was out of order; the cardholder could not be authenticated
			Authorization is not possible',
            330 => 'The cardholder is not participating in the 3D Secure authentication program
			Authorization is not possible',
            350 => 'The cardholder was successfully authenticated <br />
			Authorization is not possible',
            400 => 'The consumer or WebCollect has revised the payment (with another payment product)',
            500 => 'Payment was unsuccessful <br />
			This is the final status update for this transaction',
            525 => 'The payment was challenged by your fraud rule set and is pending <br />
			Use the Process Challenged API or the Web Payment Console if you choose to process further',
            550 => 'The payment was referred
			A manual authorization attempt will be made shortly',
            600 => 'The payment instruction is waiting for one of these <br />
			Mandate (direct debit) <br />
			Settlement (credit card online) <br />
			Acceptance (recurring orders)',
            625 => 'The transaction is authorized and waiting for the second message (captured) from the provider',
            650 => 'The real-time bank payment is pending verification by the batch process
			If followed by 50 PENDING AT BANK, the verification could not be carried out successfully',
            800 => 'successful',
            900 => 'The refund was processed',
            950 => 'The invoice was printed and sent',
            975 => 'The settlement file was sent for processing at the financial institution',
            1000 => 'The payment was paid',
            1010 => 'GlobalCollect debited the consumer account',
            1020 => 'GlobalCollect corrected the payment information that was given',
            1030 => 'The chargeback has been withdrawn',
            1050 => 'The funds have been made available for remittance to the merchant',
            1100 => 'GlobalCollect rejected the payment attempt',
            1110 => 'The acquiring bank rejected the direct debit',
            1120 => 'Refused settlement before payment by GlobalCollect (credit card)',
            1150 => 'Refused settlement after payment from Acquirer (credit card)',
            1210 => 'The bank of the consumer rejected the direct debit',
            1250 => 'The payment bounced',
            1500 => 'The payment was charged back by the consumer',
            1510 => 'The consumer reversed the direct debit payment',
            1520 => 'The payment was reversed',
            1800 => 'The payment was refunded',
            1810 => 'GlobalCollect corrected the refund information given',
            1850 => 'Refund is refused by the Acquirer',
            2000 => 'GlobalCollect credited the consumer account',
            2030 => 'The reversed payout was withdrawn',
            2100 => 'GlobalCollect rejected the payout attempt',
            2110 => 'Bank rejected the payout attempt',
            2120 => 'The acquiring bank rejected the payout attempt',
            2130 => 'The consumer bank rejected the payout attempt',
            2210 => 'The consumer reversed the payout',
            2220 => 'The payout was reversed',
            99999 => 'The payment, refund, or payout attempt was cancelled by the merchant',
            403 => 'You are not allowed to access the service or account or your API authentication failed.'
        );
        if (empty($error[$status_id])) {
            return "The payment has failed";
        }
        return $error[$status_id];
    }

    /**
     * @param $str
     * @return mixed
     * 工具方法
     */
    function getNewStr($str)
    {
        if (empty($str)) {
            return "";
        }
        $str = str_replace('&', '', $str);
        return $str;
    }

}
