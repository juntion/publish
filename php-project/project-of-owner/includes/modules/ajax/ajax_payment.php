<?php
/**
 * Created by PhpStorm.
 * User: Aron
 * Date: 2018/6/7
 * Time: 17:54
 */
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$action = $_GET['ajax_request_action'];
$serect_code = $_POST["serect_code"];
if (!empty($action)) {
    switch ($action) {
        case "payeezy":
            $order_id = abs((int)zen_db_prepare_input($_POST["order_id"]));
            $token = zen_db_prepare_input($_POST["value"]);
            $serect_token = $_POST['secret_token'];
            $check_status = fs_get_data_from_db_fields('orders_status','orders','orders_id ='.$order_id);
            if (!$order_id || !$token || $serect_token != $_SESSION['securityToken']) {
                $data = array("status" => "error", "error_message" => "Invalid request");
                echo json_encode($data);
                exit;
            }
            if ($check_status != 1) {
                $data = array("status" => "error", "error_message" => "Invalid request.");
                echo json_encode($data);
                exit;
            }
            require_once(DIR_WS_CLASSES . 'PayeezyTest.php');
            require_once(DIR_WS_CLASSES . 'order.php');
            $order = new order(intval($order_id));
            $order_number = $order->info['orders_number'];
            $card_type = zen_db_prepare_input($_POST["type"]);
            $card_cvv = zen_db_prepare_input($_POST['card_cvv']);//zen_db_prepare_input($_POST['card_cvv'])
            $exp_date = zen_db_prepare_input($_POST["exp_date"]);
            $cardholder_name = zen_db_prepare_input($_POST['cardholder_name']);
            $currency_code = $order->info['currency'];
            $card_number = "";
            $amount = $order->info['total'];

            $city = $order->billing['city'];
            $country = get_countries_code($order->billing['country']);
            $street = $order->billing['street_address'] ? substr(str_replace("&","",$order->billing['street_address']), 0, 28) : "";
            $state = $order->billing['state'];
            if(!empty($state)){
                $state = fs_get_data_from_db_fields('states_code', 'countries_us_states', 'states ="'.$state.'"');
            }
            $postal_code = $order->billing['postcode'] ? substr($order->billing['postcode'], 0, 10) : "";
            $email = $order->customer['email_address'];
            $phone_number = $order->billing['telephone'];
            $token_info = array(
                "city" => $city,
                "country_code" => $country_code,
                "street" => $street,
                "state" => $state,
                "postal_code" => $postal_code,
                "email" => $email,
                "phone_number" => $phone_number,
                "taToken" => "VVGB",
                "card_number" => $card_number,
                "card_type" => $card_type,
                "card_cvv" => $card_cvv,
                "card_exp_date" => $exp_date,
                "currency" => $currency_code,
                "merchant_href" => $order_number,
                "card_holder_name" => $cardholder_name,
                "auth" => "false",
                "end_point" => "https://api.payeezy.com/v1/transactions/tokens"
            );

            $token_data = array(
                "value" => $token,
                "type" => $card_type,
                "exp_date" => $exp_date,
                "cardholder_name" => $cardholder_name,
            );
            $config = array(
                "url" => "https://api.payeezy.com/v1/transactions",
                "card_holder_name" => $cardholder_name,
                "card_expiry" => $exp_date,
                "card_cvv" => $card_cvv,
                "merchant_ref" => $order_number,
                "currency_code" => $currency_code,
                "card_number" => $card_number,
                "card_type" => $card_type,
                "amount" => $amount,
                "method" => "token",
                'delivery_country_id' => $order->info['delivery_country_id'],
                "billing_address" => array(
                    "city" => $city,
                    "email" => $email,
                    "street" => $street,
                    "state_province" => $state ? $state : "",
                    "country" => $country,
                    "zip_postal_code" => $postal_code,
                    "phone" => array("number" => $phone_number,"type"=>"work")

                ),
                "token" => array(
                    "token_data" => $token_data,
                    "token_type" => "FDToken"
                )
            );
            $payeezy = new PayeezyTest();
            $config['token']['token_data']["value"] = $token;
            $transaction_amount = ($amount * $order->info['currency_value']);
            $amount = (round($transaction_amount, 2)) * 100;
            $config["amount"] = $amount;
            /**
             * 检查支付前前订单是否可以付款
             */
            $error_data = array(
                "status" => "error",
                "code_gateway" => '',
                "code_bank"=>'',
                "message" => "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>",
                "location"=>zen_href_link('manage_orders'));
            if ($order->info['orders_status_id'] == 5){
                //订单已被取消
                echo json_encode($error_data);exit;
            }else{
                $ordersOvertime =  fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $order_id,"id");
                if (zen_not_null($ordersOvertime['id'])){
                    $res = set_cancel_order_key($order_id);
                    if (!$res){
                        //正在被取消
                        echo json_encode($error_data);exit;
                    }
                }
            }

            /**
             * 付款
             */
            $payeezy->setUpBeforeClass($config);
            $return = $payeezy->testPurchase();
            if(!$return){
                $data = array("status" => "error", "code_gateway" => '', "code_bank" => '', "message" => FS_SYSTME_BUSY);
                del_cancel_order_key($order_id);
                echo json_encode($data);exit;
            }
            if (!empty($return->token->token_data->value)) {
                $return->token->token_data->value = "*********";
            }
            if (!empty($return->token->token_data->cvv)) {
                $return->token->token_data->cvv = "*********";
            }
            $reponse_string = json_encode($return, JSON_FORCE_OBJECT);
            $gateway_resp_code = $return->gateway_resp_code;
            $gateway_message = $return->gateway_message;
            $bank_resp_code = (int)$return->bank_resp_code;
            $transaction_status = $return->transaction_status;
            $validation_status = $return->validation_status;
            $bank_status = $bank_resp_code;
            $bank_success_status = array(100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 164);
            $bank_is_approved = true;
            $payment_id = $return->correlation_id;
            $transaction_tag = $return->transaction_tag;
            $response = array("status" => $transaction_status, "payment_id" => $transaction_tag, "bank_resp_code" => $bank_status, "message" => $transaction_status, "response_string" => $reponse_string);
            $globalLog = new \App\Models\GlobalCollectPaymentStatusHistory();
            try{
                $globalLog->create([
                    'orders_id' => $order_id,
                    'status_id' => $response['bank_resp_code'] ? $response['bank_resp_code'] : '',
                    'imformation' => $response['response_string'] ? $response['response_string'] : '',
                    'description' => $response['message'] ? $response['message'] : '',
                    'datetime' => date("Y-m-d H:i:s"),
                    'payment_id' => $transaction_tag ? $transaction_tag : '',
                    'type' => 2
                ]);
            }catch (Exception $e) {

            }
            if (!in_array($bank_status, $bank_success_status)) {
                $bank_is_approved = false;
            }
            if ($transaction_status != "approved" || $validation_status != "success" || !$bank_is_approved || $gateway_resp_code != "00") {             
                $error = $payeezy->getError($bank_resp_code);
                if(!$error){
                    if(!$bank_is_approved){
                        $error = $return->bank_message;
                    }
                    if(!$error){
                        if($gateway_resp_code != "00"){
                            $error = $payeezy->getGatewayMessage($gateway_resp_code);
                            if(!$error){
                                $error = $gateway_message;
                            }
                        }
                    }
                    if(!$error && isset($return->Error->messages)){
                        $type = $return->Error->messages;
                        if(is_array($type)){
                            $erros = $type[0];
                            if(is_object($erros) && isset($erros->description)){
                                $error = $erros->description;
                            }
                        }
                    }
                }               
                $data = array("status" => "error", "code_gateway" => $gateway_resp_code, "code_bank"=>$bank_resp_code, "message" => $error);
                del_cancel_order_key($order_id);
                echo json_encode($data);exit;
            }
            $son_id = zen_get_all_son_order_id($order_id);
            $son_id[] = $order_id;
            if (!empty($son_id)) {
                foreach ($son_id as $k => $v) {
                    zen_db_perform("orders", array("orders_status" => 2), "update", "orders_id={$v}");
                    $sql_data_array = array('orders_id' => $v,
                        'orders_status_id' => 2,
                        'date_added' => 'now()'
                    );
                    zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                }
            }
            if ($res){
                del_order_key_for_payment($order_id);
            }
            $_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
            $_SESSION['order_summary']['orders_total'] = $order->totals['ot_total']['text'];
            $_SESSION['order_summary']['items'] = $order->info['items'];
            $_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
            $_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
            $_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
//            $order->send_fs_credit_card_order_email($order_id);
            echo json_encode(array("status" => "success"));
            break;
        case "payeezy_email":
            require_once(DIR_WS_CLASSES . 'order.php');
            $order_id = abs((int)zen_db_prepare_input($_POST["orders_id"]));
            $order = new order(intval($order_id));
            $order->send_fs_credit_card_order_email($order_id);
            break;
        /**
         * 该case已被废弃  2019/08/27  by rebirth   已找aron确认，但是不建议删除
         * api 直接付款
         * 该付款存在风险,会触发PCI
         */
        case "globalcollect":
            require_once(DIR_WS_CLASSES . 'globalcollect.php');
            require_once(DIR_WS_CLASSES . 'order.php');
            $order_id = (int)$_POST['order_id'];
            if (empty($order_id)) {
                echo json_encode(array("status" => "error", "msg" => "invalid request"));
                exit;
            }
            $payment_method = zen_db_prepare_input($_POST['payment_method']);
            $order = new order($order_id);
            $card_number = zen_db_prepare_input($_POST['card_number']);
            $card_cvv = zen_db_prepare_input($_POST['card_cvv']);
            $expiryDate = zen_db_prepare_input($_POST['exp_date']);
            $cardholderName = zen_db_prepare_input($_POST['cardholder_name']);
            $billing_firstName = $billing_name = substr(str_replace('&', '', $order->billing['name']), 0, 14);
            $billing_lastName = substr(str_replace('&', '', $order->billing['lastname']), 0, 14);

            $shipping_firstName = $billing_name = substr(str_replace('&', '', $order->delivery['name']), 0, 14);
            $shipping_lastName = substr(str_replace('&', '', $order->delivery['lastname']), 0, 14);

            $amount = $order->info['total'];
            $currency = $order->info['currency'];
            $transaction_amount = ($amount * $order->info['currency_value']);
            $billing_zip = $order->billing['postcode'] ? $order->billing['postcode'] : "";
            $billing_state = $order->billing['state'] ? $order->billing['state'] : "";
            $billing_country_code = get_countries_code($order->billing['country']);
            $billing_city = $order->billing['city'] ? $order->billing['city'] : "";
            $billing_street = $order->billing['street_address'] ? $order->billing['street_address'] : "";
            $billing_company_name = $order->billing['company'];
            $shipping_city = $order->delivery['city'] ? $order->delivery['city'] : "";
            $shipping_country_code = get_countries_code($order->delivery['country']);
            $shipping_zip = $order->delivery['postcode'] ? $order->delivery['postcode'] : "";
            $shipping_state = $order->delivery['state'];
            $ipAddressCustomer = getCustomersIP(); //客户ip
            $email = $order->customer['email_address'];
            $merchant_reference = $order->info['orders_number'] . "-" . date("His");
            $customer_id = $order->customer["customers_id"];
            $language_code = 'en';

            if ($currency == 'JPY') {
                $amount = (round($transaction_amount, 0)) * 100;
            } else {
                $amount = (round($transaction_amount, 2)) * 100;
            }
            $config = array(
                "card_number" => $card_number,
                "cardholder_name" => $cardholderName,
                "cvv" => $card_cvv,
                "expiryDate" => $expiryDate,
                "amount" => $amount,
                "currency" => $currency,
                "merchant_reference" => $merchant_reference,
                "email" => $email,
                "ipAddressCustomer" => $ipAddressCustomer,
                "language_code" => $language_code,
                "payment_method" => $payment_method,
                "order_id" => $order_id,
                "billing_zip" => $billing_zip,
                "billing_state" => $billing_state,
                "billing_country_code" => $billing_country_code,
                "billing_firstName" => $billing_firstName,
                "billing_lastName" => $billing_lastName,
                "billing_city" => $billing_city,
                "billing_street" => $billing_street,

                "shipping_state" => $shipping_state,
                "shipping_zip" => $shipping_zip,
                "shipping_firstName" => $shipping_firstName,
                "shipping_lastName" => $shipping_lastName,
                "shipping_country_code" => $shipping_country_code,
                "shipping_city" => $shipping_city,
                "company" => $billing_company_name,
                "customer_id" => $customer_id
            );
            $globalCollect = new Globalcollect();
            $globalCollect->config = $config;
            $data = $globalCollect->pay_global();
            if (!empty($data)) {
                $status_code = $data['code'];
                $description = $data['message'];
                $response_string = $data["response_string"];
                $payment_id = $data["payment_id"];
                $db->query("insert into globalcollect_payment_status_history set orders_id = '" . $order_id . "',status_id='" . $status_code . "',imformation='" . $response_string . "',description='" . $description . "',datetime='" . date("Y-m-d H:i:s") . "',payment_id='" . $payment_id . "',type=1");
                if ($data['status'] == "success") {
                    $order->send_fs_credit_card_order_email($order_id);
                    $son_id = zen_get_all_son_order_id($order_id);
                    $son_id[] = $order_id;
                    if (!empty($son_id)) {
                        foreach ($son_id as $k => $v) {
                            zen_db_perform("orders", array("orders_status" => 2), "update", "orders_id={$v}");
                            $sql_data_array = array('orders_id' => $v,
                                'orders_status_id' => 2,
                                'date_added' => 'now()'
                            );
                            zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
                        }
                    }
                    $_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
                    $_SESSION['order_summary']['orders_total'] = $currencies->display_currency_total_price($order->info['total'], 0);
                    $_SESSION['order_summary']['items'] = $order->info['items'];
                    $_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
                    $_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
                    $_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
                }
                echo json_encode($data);
            } else {
                echo json_encode(array("status" => "error", "message" => "server error", "code" => 100099));
            }
            break;
        /**
         * 托管付款,新加坡付款渠道
         */
        case "globalcollect_host":
            global $db;
            require_once(DIR_WS_CLASSES . 'globalcollect.php');
            require_once(DIR_WS_CLASSES . 'order.php');
            $order_id = (int)$_POST['order_id'];
            if (empty($order_id)) {
                echo json_encode(array("status" => "error", "msg" => "invalid request"));
                exit;
            }
            if (isset($_GET['act'])) {

                $_SESSION['url_eroor'] = 'payment_against';
            }
            $payment_method = zen_db_prepare_input($_POST['payment_method']);
            $order = new order($order_id);
            $error_data = array(
                "status" => "error",
                "message" => "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>",
                "location"=>zen_href_link('manage_orders'));
            if ($order->info['orders_status_id'] == 5){
                //订单已被取消
                echo json_encode($error_data);exit;
            }else{
                $ordersOvertime =  fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $order_id,"id");
                if (zen_not_null($ordersOvertime['id'])){
                    $res = set_cancel_order_key($order_id);
                    if (!$res){
                        //正在被取消
                        echo json_encode($error_data);exit;
                    }else{
                        del_cancel_order_key($order_id);
                    }
                }
            }
            $billing_firstName = $billing_name = mb_substr(str_replace('&', '', $order->billing['name']), 0, 14);
            $billing_lastName = mb_substr(str_replace('&', '', $order->billing['lastname']), 0, 14);

            $shipping_firstName = $billing_name = mb_substr(str_replace('&', '', $order->delivery['name']), 0, 14);
            $shipping_lastName = mb_substr(str_replace('&', '', $order->delivery['lastname']), 0, 14);
            $amount = $order->info['total'];
            $currency = $order->info['currency'];
            $transaction_amount = ($amount * $order->info['currency_value']);
            $billing_zip = $order->billing['postcode'] ? $order->billing['postcode'] : "";
            $billing_state = $order->billing['state'] ? $order->billing['state'] : "";
            $billing_country_code = get_countries_code($order->billing['country']);
            $billing_city = $order->billing['city'] ? $order->billing['city'] : "";
            $billing_street = $order->billing['street_address'] ? $order->billing['street_address'] : "";
            $billing_company_name = $order->billing['company'];
            $shipping_city = $order->delivery['city'] ? $order->delivery['city'] : "";
            $shipping_country_code = get_countries_code($order->delivery['country']);
            $shipping_zip = $order->delivery['postcode'] ? $order->delivery['postcode'] : "";
            $shipping_state = $order->delivery['state'];
            $ipAddressCustomer = getCustomersIP(); //客户ip
            $email = $order->customer['email_address'];
            $merchant_reference = $order->info['orders_number'] . "-" . date("His");
            $customer_id = $order->customer["customers_id"];
            //设置语言包
            switch ($_SESSION['languages_id']) {
                case 2:
                    $language_code = 'es_AR';
                    break;
                case 3:
                    $language_code = "fr_FR";
                    break;

                case 4:
                    $language_code = "ru_RU";
                    break;
                case 5:
                    $language_code = "de_DE";
                    break;
                case 8:
                    $language_code = "ja_JP";
                    break;
                case 14:
                    $language_code = "it_IT";
                    break;
                default :
                    $language_code = "en_GB";
            }

            if ($currency == 'JPY') {
                $amount = (round($transaction_amount, 0)) * 100;
            } else {
                $amount = (round($transaction_amount, 2)) * 100;
            }
            $config = array(
                "amount" => $amount,
                "currency" => $currency,
                "merchant_reference" => $merchant_reference,
                "email" => $email,
                "ipAddressCustomer" => $ipAddressCustomer,
                "language_code" => $language_code,
                "payment_method" => $payment_method,
                "order_id" => $order_id,
                "billing_zip" => $billing_zip,
                "billing_state" => $billing_state,
                "billing_country_code" => $billing_country_code,
                "billing_firstName" => $billing_firstName,
                "billing_lastName" => $billing_lastName,
                "billing_city" => $billing_city,
                "billing_street" => $billing_street,

                "shipping_state" => $shipping_state,
                "shipping_zip" => $shipping_zip,
                "shipping_firstName" => $shipping_firstName,
                "shipping_lastName" => $shipping_lastName,
                "shipping_country_code" => $shipping_country_code,
                "shipping_city" => $shipping_city,
                "company" => $billing_company_name,
                "customer_id" => $customer_id
            );
            $globalCollect = new Globalcollect();
            $globalCollect->config = $config;
            /**
             * 托管支付页面
             * response
             * RETURNMAC 付款唯一标示
             * hostedCheckoutId
             * partialRedirectUrl 托管页面地址
             */
            $return = $globalCollect->testCreateHostedCheckout();
            if (!empty($return->RETURNMAC)) {
                $RETURNMAC = $return->RETURNMAC;
                $data = array("status" => "success", "partialRedirectUrl" => "https://payment." . $return->partialRedirectUrl);
                $db->query("insert into globalcollect set orders_id = '" . $order_id . "',paymentproductid='$payment_method',ref='" . $RETURNMAC . "',g_imformation='" . json_encode($return, JSON_FORCE_OBJECT) . "',addtime='" . date("Y-m-d H:i:s") . "'");
            } else {
                $data = $return;
            }
            echo json_encode($data);
            break;
        case "create_error_log":
            $code = zen_db_prepare_input($_POST["code"]);
            $message = zen_db_prepare_input($_POST["message"]);
            $order_id = (int)$_POST['order_id'];
            $db->query("insert into globalcollect_payment_status_history set orders_id = '" . $order_id . "',status_id='" . $code . "',description='" . $message . "',datetime='" . date("Y-m-d H:i:s") . "',type=2");
            echo json_encode(array("status" => "success"));
            break;
        /**
         * echeck 付款
         */
        case "echeck":
            require_once(DIR_WS_CLASSES . 'order.php');
            $account_name = zen_db_prepare_input($_POST['account_name']);
            $account_number = zen_db_prepare_input($_POST['account_number']);
            $account_type = zen_db_prepare_input($_POST['account_type']);
            $account_route = zen_db_prepare_input($_POST['account_route']);
            $orders_id = abs((int)zen_db_prepare_input($_POST['order_id']));
            if(empty($account_name) || empty($account_number) || empty($account_type) || empty($account_route) || empty($orders_id)){
                echo json_encode(array("status" => 2,"msg"=>'Please improve the form information'));
                exit;
            }
            if(!empty($_SESSION['customers_id'])){
                echo json_encode(array("status" => 3,"msg"=>'Login information expired, please log in again'));
                exit;
            }
            if (!can_change_order_status($orders_id) || !set_cancel_order_key($orders_id)){
                $message = "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>";
                $location =zen_href_link('manage_orders');
                echo json_encode(array("status" => 4,"msg"=>'$message','location' => $location));
                exit();
            }
            del_cancel_order_key($orders_id);
            $admin_id = fs_get_data_from_db_fields('admin_id','order_to_admin','orders_id='.$orders_id.'','limit 1');
            $orders_info = $db->Execute("SELECT shipping_method,payment_module_code,orders_status,orders_number,order_total,currency,customers_email_address,customers_name,customers_id FROM " . TABLE_ORDERS . " WHERE orders_id = ". $orders_id. " limit 1");
            $applyMoney = zen_round($orders_info->fields['order_total'],2);
            $customersEmail = $orders_info->fields['customers_email_address'];
            $ordersNumber = $orders_info->fields['orders_number'];
            $currency = $orders_info->fields['currency'];
            $currenciesId = 1;
            $customers_id = $orders_info->fields['customers_id'] ? $orders_info->fields['customers_id'] :"";
            $customersName = $orders_info->fields['customers_name'] ? $orders_info->fields['customers_name'] :"";
            $customersLevel = "";
            $customersNO = "";
            if($currency){
                $currenciesId = fs_get_data_from_db_fields('currencies_id','currencies','code="'.$currency.'"',' ORDER BY currencies_id ASC limit 1');
            }
            if($customers_id){
                $customer_info = $db->Execute("SELECT customers_level,customers_number_new FROM " . TABLE_CUSTOMERS . " WHERE customers_id = ". $customers_id. " limit 1");
                $customersNO =   $customer_info->fields['customers_number_new'];
                $customersLevel = $customer_info->fields['customers_level'];
            }
            $check_info = array(
                "orders_id" => $orders_id,
                "account_name" => $account_name  ? $account_name :"",
                "account_number" =>  $account_number ?  $account_number:"",
                "account_type" =>   $account_type ?   $account_type :"",
                "routing_number" => $account_route ? $account_route :"",
                'customers_email' => $customersEmail,// 客户邮箱
                'customers_NO'    => $customersNO,// 客户编号
                'customers_level' => $customersLevel,// 客户等级
                'customers_name'  => $customersName,// 客户名称
                'currencies_id'   => $currenciesId,// 币种ID
                'apply_money'     => $applyMoney,// 订单金额
                'orders_number'   => $ordersNumber,// FS单号
                'apply_admin'     =>  $admin_id ? $admin_id : "",// 销售，申请人
                'created_at'      => 'now()',
                'updated_at'      => 'now()',
            );
            zen_db_perform('fs_electrical_check_apply', $check_info);
            $_SESSION['order_summary']['orders_number'] = $ordersNumber;
            $_SESSION['order_summary']['orders_total'] = $currencies->display_currency_total_price($orders_info->fields['order_total'], 0);
            $_SESSION['order_summary']['items'] = 0;
            $_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $orders_info->fields['shipping_method']);
            $_SESSION['order_summary']['orders_status'] = $orders_info->fields['orders_status'];
            $_SESSION['order_summary']['payment_method'] = $orders_info->fields['payment_module_code'];
            echo json_encode(array("status" => 1,"msg"=>'success','url' => zen_href_link("checkout_success")));
            break;

        /**
         * 获取登陆凭证
         *
         * @author aron
         * @date 2019.6.31
         */
        case "getPayeezySession":
            require_once(DIR_WS_CLASSES . 'PayeezyTest.php');
            require_once(DIR_WS_CLASSES . 'order.php');
            $order_id = zen_db_prepare_input($_POST["order_id"]);
            if (empty($order_id)) {
                echo json_encode(array("status" => "error", "msg" => "invalid request"));
                exit;
            }
            $order = new order($order_id);
            $error_data = array(
                "status" => "error",
                "message" => "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>",
                "location"=>zen_href_link('manage_orders'));
            if ($order->info['orders_status_id'] == 5){
                //订单已被取消
                echo json_encode($error_data);exit;
            }else{
                $ordersOvertime =  fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $order_id,"id");
                if (zen_not_null($ordersOvertime['id'])){
                    $res = set_cancel_order_key($order_id);
                    if (!$res){
                        //正在被取消
                        echo json_encode($error_data);exit;
                    }
                    del_cancel_order_key($order_id);
                }
            }
            $currency_code = $order->info['currency'];
            $config['currency_code'] = $currency_code;
            $config["delivery_country_id"] = $order->info['delivery_country_id'];
            $payeezy = new PayeezyTest();
            $payeezy::setUpBeforeClass($config);
            echo json_encode($payeezy->getSession());
            break;
    }
}
