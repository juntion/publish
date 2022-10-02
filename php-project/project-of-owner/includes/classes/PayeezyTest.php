<?php
/**
 * created by aron
 * apikey 0JO5FvSXfIVEY9QLrPOROipXJU6A84AX
 * merchant token fdoa-54a4a4df51b019510e64132f1f1f796854a4a4df51b01951
 * ApiSecret 944694868daa8212264e64e5d69aca1e71b0eacab170c3f4191902f5cf6fb10f
 * token url https://api.payeezy.com/v1/transactions/tokens
 *
 */
require_once(DIR_WS_CLASSES.'Payeezy.php');
class PayeezyTest
{
    public static $payeezy;
    public static $card_holder_name;
    public static $card_number;
    public static $card_type;
    public static $card_cvv;
    public static $amount;
    public static $currency_code;
    public static $merchant_ref;
    public static $method ;
    public static $card_expiry;
    public static $token;
    public static $rate_reference;
    public static $billing_address;
    private static $apiKey;
    private static $apiSecret;
    private static $merchat_token;
    private static $is_test = false;
    private static $transarmorToken;

    public static function setUpBeforeClass($config = array())
    {
        self::$payeezy = new Payeezy();
        self::$payeezy->setApiKey(PAYMENT_PAYEEZY_API_KEY);
        self::$payeezy->setApiSecret(PAYMENT_PAYEEZY_API_SECRET);
        self::$apiKey = PAYMENT_PAYEEZY_API_KEY;
        self::$apiSecret = PAYMENT_PAYEEZY_API_SECRET;
        self::$transarmorToken = 'VVGB';
        $merchat_token = "";
        if($config["currency_code"] == "USD"){
            self::$merchat_token = $merchat_token = "fdoa-54a4a4df51b019510e64132f1f1f796854a4a4df51b01951";
            if(all_german_warehouse('country_number', $config['delivery_country_id'])){
                self::$transarmorToken = "L8WA";
                self::$merchat_token = $merchat_token = "fdoa-7ac8805831e5a8f42c98fe1c1c2507a1d06152c71f70628c";
            }
        }elseif ($config["currency_code"] == "MXN"){
            self::$merchat_token = $merchat_token = "fdoa-37132c01dc0df7e015233dba236dea4c37132c01dc0df7e0";
        }elseif($config["currency_code"] == "CAD"){
            self::$merchat_token = $merchat_token = "fdoa-e3d507165e895b26d9199415bf64efd0e3d507165e895b26";
        }elseif ($config["currency_code"] == "AUD"){
            self::$transarmorToken = 'L2F3';
            self::$merchat_token = $merchat_token = "fdoa-0823ef67ce466ea154e9df9dbff4a2e6612679089823a819";
        }elseif($config['currency_code'] == 'GBP'){
            self::$merchat_token = $merchat_token = "fdoa-0861a81cd67992016d6def7c08dc83154629645851dacb40";
            self::$transarmorToken = 'L8WB';
        }elseif($config['currency_code'] == 'EUR'){
            self::$transarmorToken = 'L8V9';
            self::$merchat_token=$merchat_token="fdoa-cb9d5bf715fb86c4b90b3891e5e620cb971c2a675efe8ffb";
        }elseif ($config['currency_code'] == 'CHF'){
            self::$transarmorToken = 'L8WC';
            self::$merchat_token=$merchat_token="fdoa-7957ce497c0e9262a82f7f5275c7463229cb751fa223e6ec";
        }elseif($config["currency_code"] == "SEK") {
            self::$merchat_token=$merchat_token="fdoa-c837ad730b4a2fa437e6c84a687cd9f8577ac25b7052d0e5";
            self::$transarmorToken = 'L8WD';
        }
        self::$payeezy->setMerchantToken($merchat_token);
        self::$payeezy->setTokenUrl("https://api.payeezy.com/v1/transactions/tokens");
        self::$payeezy->setUrl($config['url']);
        if(self::$is_test){
            self::$payeezy->setApiKey("VRxYD548LdGnuhoDSjx0AW0YkQ1D5Zf0");
            self::$merchat_token = "fdoa-b9856d3e08163b3b2c7a58fb97765dda5b15a8ef51e9f451";
            self::$apiKey = "VRxYD548LdGnuhoDSjx0AW0YkQ1D5Zf0";
            self::$apiSecret = "4968413b46e9faee1e730033eb7be71cba2c08ab0a9289215f7bb85795b96e12";
            self::$payeezy->setUrl("https://api-cert.payeezy.com/v1/transactions");
        }
        self:: $card_holder_name = $config["card_holder_name"];
        self::$card_number = $config["card_number"];
        self:: $card_type = $config["card_type"];
        self::$card_cvv = $config["card_cvv"];
        self::$amount =  $config["amount"];
        self::$currency_code = $config["currency_code"];
        self::$merchant_ref = $config["merchant_ref"];
        self::$card_expiry = $config["card_expiry"];
        self::$method = $config["method"];
        self::$token = $config['token'];
        self::$rate_reference = $config['rate_reference'];
        self::$billing_address = $config['billing_address'];
    }
    public function processInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strval($data);
    }
    public function setTokenPayload($config){
        $card_holder_name = $transaction_type = $auth = $card_number = $ta_token = $card_type = $card_cvv = $card_expiry = $currency_code = $merchant_ref="";
        $transaction_type = $this->processInput("FDToken");
        $auth = $this->processInput("false");
        $ta_token = $this->processInput($config['taToken']);
        $card_holder_name = $this->processInput($config['card_holder_name']);
        $card_number = $this->processInput($config['card_number']);
        $card_type = $this->processInput($config['card_type']);
        $card_cvv = $this->processInput($config['card_cvv']);
        $card_expiry = $this->processInput($config['exp_date']);
        $currency_code = $this->processInput($config['currency']);
        $merchant_ref = $this->processInput($config['merchant_href']);
        $getTokenPayload = array(
            "type" => $transaction_type,
            "auth" => $auth,
            "ta_token"=> $ta_token,
            "credit_card" => array(
                "type" => $card_type,
                "cardholder_name" => $card_holder_name,
                "card_number" => $card_number,
                "exp_date" => $card_expiry,
                "cvv" => $card_cvv,
            )
        );
        return $getTokenPayload;
    }

    public function getTokenPayload($args = array())
    {
        $args = array_merge(array(
            "type"=> "",
            "auth" => "",
            "ta_token" => "",
            "card_type" => "",
            "card_holder_name" => "",
            "card_number" => "",
            "card_exp_date" => "",
            "card_cvv" => ""
        ), $args);
        $transaction_type = strtolower(func_get_arg(1));
        $data = "";
        $data = array(
            'type'=> 'FDToken',
            'auth'=>  $args['auth'],
            'ta_token'=> $args['taToken'],
            'credit_card'=> array(
                'type'=> $args['card_type'],
                'cardholder_name'=> $args['card_holder_name'],
                'card_number'=> $args['card_number'],
                'exp_date'=> $args['card_exp_date'],
                'cvv'=> $args['card_cvv'],
            )
        );
        return json_encode($data, JSON_FORCE_OBJECT);
    }

    public function testGetToken($config)
    {
        $primaryTxResponse_JSON = json_decode(self::$payeezy->get_token($this->getTokenPayload($config)));
        return $primaryTxResponse_JSON;
    }

    public function setPrimaryTxPayload(){
        $card_holder_name = $card_number = $card_type = $card_cvv = $card_expiry = $currency_code = $merchant_ref="";
        $card_holder_name = self:: $card_holder_name;
        $card_number =  self::$card_number;
        $card_type =  self:: $card_type;
        $card_cvv = self::$card_cvv;
        $card_expiry = self::$card_expiry;
        $amount = self::$amount;
        $currency_code =  self::$currency_code;
        $merchant_ref = self::$merchant_ref ;
        $billing_address = self::$billing_address;
        $primaryTxPayload = array(
            "amount"=> $amount,
            //"card_number" => $card_number,
            "card_type" => $card_type,
            "card_holder_name" => $card_holder_name,
            "card_cvv" => $card_cvv,
            "card_expiry" => $card_expiry,
            "merchant_ref" => $merchant_ref,
            "currency_code" => $currency_code,
            "method" => self::$method,
            "token" => self::$token,
            "rate_reference" =>self::$rate_reference,
            "billing_address"=>$billing_address
        );
        return $primaryTxPayload;
    }
    public  function getRate($option){
       return self::$payeezy->getRate($option);
    }
    public function setSecondaryTxPayload($transaction_id, $transaction_tag, $amount, $split_shipment){
        $transaction_type = $merchant_ref= $currency_code = "";
        $transaction_id = $this->processInput($transaction_id);
        $transaction_tag = $this->processInput($transaction_tag);
        $amount = $this->processInput($amount);
        $currency_code = $this->processInput("USD");
        $merchant_ref = $this->processInput("Astonishing-Sale");
        $split_shipment = $this->processInput($split_shipment);
        $method = $this->processInput("credit_card");
        if( is_null($split_shipment) )
        {
            $secondaryTxPayload = array(
                "amount"=> $amount,
                "transaction_tag" => $transaction_tag,
                "transaction_id" => $transaction_id,
                "merchant_ref" => $merchant_ref,
                "currency_code" => $currency_code,
                "method"=> $method,
            );
        }
        else{
            $secondaryTxPayload = array(
                "amount"=> $amount,
                "transaction_tag" => $transaction_tag,
                "transaction_id" => $transaction_id,
                "merchant_ref" => $merchant_ref,
                "currency_code" => $currency_code,
                "split_shipment" => $split_shipment,
                "method"=> $method,
            );
        }
        return $secondaryTxPayload;
    }
    public function testAuthorize()
    {
        $primaryTxResponse_JSON = json_decode(self::$payeezy->authorize($this->setPrimaryTxPayload()));
        return $primaryTxResponse_JSON;

    }
    public function testPurchase()
    {
        $primaryTxResponse_JSON = json_decode(self::$payeezy->purchase($this->setPrimaryTxPayload()));
        return $primaryTxResponse_JSON;
    }
    public function testCapture()
    {
        // first do an authorize
        $primaryTxResponse_JSON = json_decode(self::$payeezy->authorize($this->setPrimaryTxPayload()));
        $secondaryTxPayload = $this->setSecondaryTxPayload($primaryTxResponse_JSON->transaction_id
            ,$primaryTxResponse_JSON->transaction_tag
            ,$primaryTxResponse_JSON->amount
            ,null);
        // capture the previous txn using the transaction id and transaction tag
        $secondaryTxResponse_JSON = json_decode(self::$payeezy->capture($secondaryTxPayload));
    }
    public function testVoid()
    {
        // first do an authorize
        $primaryTxResponse_JSON = json_decode(self::$payeezy->authorize($this->setPrimaryTxPayload()));
        $secondaryTxPayload = $this->setSecondaryTxPayload($primaryTxResponse_JSON->transaction_id
            ,$primaryTxResponse_JSON->transaction_tag
            ,$primaryTxResponse_JSON->amount
            ,null);
        // void the previous txn using the transaction id and transaction tag
        $secondaryTxResponse_JSON = json_decode(self::$payeezy->void($secondaryTxPayload));
    }
    public function testRefund()
    {
        // first do a purchase
        $primaryTxResponse_JSON = json_decode(self::$payeezy->purchase($this->setPrimaryTxPayload()));
        $secondaryTxPayload = $this->setSecondaryTxPayload($primaryTxResponse_JSON->transaction_id
            ,$primaryTxResponse_JSON->transaction_tag
            ,$primaryTxResponse_JSON->amount
            ,null);
        // refund the purchase using the transaction id and transaction tag
        $secondaryTxResponse_JSON = json_decode(self::$payeezy->refund($secondaryTxPayload));
    }
    public function testSplit()
    {
        // first do an authorize
        $primaryTxResponse_JSON = json_decode(self::$payeezy->authorize($this->setPrimaryTxPayload()));
        // in this example, the shipment is split into 2 txns
        $split_amount = ($primaryTxResponse_JSON->amount)/2;
        // the first shipment is sent out .. split shipmant value is 01/99 since the total no. of shipments is unknown
        $secondaryTxPayload = $this->setSecondaryTxPayload($primaryTxResponse_JSON->transaction_id
            ,$primaryTxResponse_JSON->transaction_tag
            ,$split_amount
            ,"01/99");
        $secondaryTxResponse_JSON = json_decode(self::$payeezy->split_shipment($secondaryTxPayload));

        // the second shipment is sent out. It is also the final shipment .. therefore 02/02
        $secondaryTxPayload = $this->setSecondaryTxPayload($primaryTxResponse_JSON->transaction_id
            ,$primaryTxResponse_JSON->transaction_tag
            ,$split_amount
            ,"02/02");
        $secondaryTxResponse_JSON = json_decode(self::$payeezy->split_shipment($secondaryTxPayload));
    }
    public function getPayHistory(){
       return self::$payeezy->_getPayHistory();
    }
    public function getError($bank_code){
        $error_array = array(
            260 => CREDIT_CARD_ERROR_260,
            301 => CREDIT_CARD_ERROR_301,
            304 => CREDIT_CARD_ERROR_304,
            401 => CREDIT_CARD_ERROR_401,
            502 => CREDIT_CARD_ERROR_502,
            505 => CREDIT_CARD_ERROR_505,
            509 => CREDIT_CARD_ERROR_509,
            510 => CREDIT_CARD_ERROR_510,
            519 => CREDIT_CARD_ERROR_519,
            521 => CREDIT_CARD_ERROR_521,
            522 => CREDIT_CARD_ERROR_522,
            530 => CREDIT_CARD_ERROR_530,
            531 => CREDIT_CARD_ERROR_531,
            591 => CREDIT_CARD_ERROR_591,
            592 => CREDIT_CARD_ERROR_592,
            606 => CREDIT_CARD_ERROR_606,
            776 => CREDIT_CARD_ERROR_776,
            787 => CREDIT_CARD_ERROR_787,
            806 => CREDIT_CARD_ERROR_806,
            825 => CREDIT_CARD_ERROR_825,
            902 => CREDIT_CARD_ERROR_902,
            904 => CREDIT_CARD_ERROR_904,

            201 => CREDIT_CARD_ERROR_201,
            204 => CREDIT_CARD_ERROR_204,
            233 => CREDIT_CARD_ERROR_233,
            239 => CREDIT_CARD_ERROR_239,
            261 => CREDIT_CARD_ERROR_261,
            351 => CREDIT_CARD_ERROR_351,
            755 => CREDIT_CARD_ERROR_755,
            758 => CREDIT_CARD_ERROR_758,
            834 => CREDIT_CARD_ERROR_834,
        );
        if(!empty($error_array[$bank_code])){
            return $error_array[$bank_code];
        }else{
            return "";
        }
    }

    public function setConfig()
    {
        if(self::$is_test){
            return [
                "gateway" => "PAYEEZY",
                "apiKey" => "9n9muhbE9d0nVKqGRMOChJZ0kbBlq7ut",
                "apiSecret" => "r0CpIM7AvC6cAumc",
                "authToken" => self::$merchat_token,
                "transarmorToken" => "VVGB",
            ];
        }
        return [
            "gateway" => "PAYEEZY",
            "apiKey" => "V7tUSVK2XMh3xFsgTb0GSWeUb0EjGUFc",
            "apiSecret" => "7RUtFpselaCEcUJj",
            "authToken" => self::$merchat_token,
            "transarmorToken" => self::$transarmorToken,
        ];
    }

    public function getSession(){
        $config = self::setConfig();
        $payload = [
             "gateway"=> $config['gateway'],
             "apiKey"=> self::$apiKey,
             "apiSecret"=> self::$apiSecret,
             "authToken"=> $config['authToken'],
             "transarmorToken"=> $config['transarmorToken'],
             "zeroDollarAuth"=> true,
             'currency' => self::$currency_code
        ];
        $url = "https://prod.api.firstdata.com/paymentjs/v2/merchant/authorize-session";
        if(self::$is_test){
            $payload = [
                "gateway"=> $config['gateway'],
                "apiKey"=> self::$apiKey,
                "apiSecret"=> self::$apiSecret,
                "authToken"=> $config['authToken'],
                "transarmorToken"=> $config['transarmorToken'],
                "zeroDollarAuth"=> true,
                'currency' => self::$currency_code
            ];
            $url = "https://cert.api.firstdata.com/paymentjs/v2/merchant/authorize-session";
        }
        $payload = json_encode($payload , JSON_FORCE_OBJECT);
        $headArray = self::hmacAuthorizationTokeSession($payload);
        $data = self::http_request_session($url,$payload,$headArray,"POST");
        return $data;
    }

    public function hmacAuthorizationTokeSession($payload)
    {
        $config = self::setConfig();
        $apiKey = $config['apiKey'];
        $apiSecret = $config['apiSecret'];
        $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
        date_default_timezone_set('UTC');
        $timestamp = strval(time() * 1000); //time stamp in milli seconds
        $data = $apiKey . $nonce . $timestamp . $payload;
        $hashAlgorithm = "sha256";
        $hmac = hash_hmac($hashAlgorithm, $data, $apiSecret);    // HMAC Hash in hex
        $authorization = base64_encode($hmac);
        return array(
            "authorization" => $authorization,
            "nonce" => $nonce,
            "timestamp" => $timestamp,
        );
    }


    public  function http_request_session($url,$data=array(),$header=array(),$method,$setcooke=false,$cookie_file=false)
    {
        $ch = curl_init();//1.初始化;
        $config = self::setConfig();
        $apiKey = $config['apiKey'];
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $header = array(
            'Content-Type:application/json',
            'Api-Key:' . strval($apiKey),
            "Message-Signature:" . strval($header['authorization']),
            'Nonce:' . $header['nonce'],
            'Timestamp:' . $header['timestamp'],
        );
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        if ($method == "POST") {//5.post方式的时候添加数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($setcooke == true) {
//如果设置要请求的cookie，那么把cookie值保存在指定的文件中
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        } else {
//就从文件中读取cookie的信息
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($ch);
        $body = "";
        $header_info = "";
        $nonce = "";
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            list($header, $body) = explode("\r\n\r\n", $tmpInfo, 2);
            $header = explode("\r\n",$header);
            foreach ($header as $v){
                if(strpos($v,"Client-Token")!==false){
                    $header_info = $v;
                }
                if(stripos($v,"nonce")!==false){
                    $nonce = $v;
                }
            }
        }
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $nonce = trim(str_replace("Nonce:","",$nonce));
        $client_token = trim(str_replace("Client-Token:","",$header_info));
        $_SESSION['nonce'] = $nonce;
        $_SESSION['client_token'] = $client_token;
        $base64 = json_decode($body,true)['publicKeyBase64'];
        return [
            "publicKeyBase64" => $base64,
            "client_token" => $client_token,
            "nonce" => $nonce,
        ];

    }

    /**
     * payeezy 错误状态提示语
     *
     * @author aron
     * @return array
     */
    public function getErrorMessage(){
        $code_array = [
            '08' => 'Security code is incorrect. Please enter the correct code and try again.',
            '22' => 'Invalid account number/incorrect format. Please check the number and try again.',
            '25' => 'Invalid Expiry Date. Please check the expiry date or try another payment method.',
            '26' => 'System error. Please try another payment method or contact your account manager.',
            '27' => 'Invalid Cardholder. Please check the name and try again.',
            '28' => 'System error. Please try another payment method or contact your account manager.',
            '31' => 'System error. Please try another payment method or contact your account manager.',
            '32' => 'System error. Please try another payment method or contact your account manager.',
            '44' => 'Billing address on the order must match the billing address associated with the card being used.',
            '57' => 'System error. Please try another payment method or contact your account manager.',
            '58' => 'Sorry, you billing address exceeds the limit (40 characters). Please try another card or payment method.',
            '60' => 'System error. Please try another payment method or contact your account manager.',
            '63' => 'System error. Please try another payment method or contact your account manager.',
            '64' => 'System error. Please try another payment method or contact your account manager.',
            '68' => 'Your card has been restricted. Please try another card or payment method.',
            '69' => 'System error. Please try another payment method or contact your account manager.',
            '72' => 'System error. Please try another payment method or contact your account manager.',
            '93' => 'System error. Please try another payment method or contact your account manager.'
        ];
        return $code_array;
    }

    public function getGatewayMessage($gateway_resp_code){
        $code_array =  $this->getErrorMessage();
        if(!empty($code_array[$gateway_resp_code])){
            return $code_array[$gateway_resp_code];
        }else{
            return '';
        }
    }
}
?>
