<?php
/**
 * Created by PhpStorm.
 * User: yaowei
 * Date: 2018/12/1
 * Time: 下午9:08
 */


set_time_limit(0);


if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']) {
    $action = $_GET['ajax_request_action'];
    require_once(DIR_WS_CLASSES . 'payment.php');
    require_once DIR_WS_CLASSES . 'class.checkout.php';
    require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/checkout_common.php'); // 调用公共的语言包
    /**
     * status
     * 403 禁止服务器拒绝请求。
     * 200 – OK – 一切正常
     * 401（身份验证错误） 此页要求授权
     * 204（无内容）  服务器成功处理了请求，但未返回任何内容。
     * 406（数据验证错误） 无法使用请求的内容特性响应请求的网页。
     */
    if ($_SESSION['customer_id']) {
        $customers_authorization = $db->getAll("select customers_authorization from customers where customers_id=" . $_SESSION['customer_id'] . " and customers_authorization=4");
        if ($customers_authorization[0]['customers_authorization'] == 4) {
            echo json_encode(array("status" => 403, "data" => ""));
            exit;
        }
    }


    /**此处发现一个bug，传参过来的字符串中自身带了&符号的话，再通过&切割字符串转化为数组的时候，会导致数据丢失 Bona.guo 2020/12/1 9:45
     *临时解决方法，传参过来前在js中将 & 正则替换成 **amp** ，再在此处还原成 &
     */
    $_POST['ticker_number_mgb']&&$_POST['ticker_number_mgb']=str_replace( '**amp**', '&',$_POST['ticker_number_mgb']);
    $_POST['delivery_other_mgb']&&$_POST['delivery_other_mgb']=str_replace( '**amp**', '&',$_POST['delivery_other_mgb']);
    $_POST['remarks_local']&&$_POST['remarks_local']=str_replace( '**amp**', '&',$_POST['remarks_local']);

    if (isset($action)) {
        switch ($action) {
            case "match_country":
                $zip_code = zen_db_prepare_input($_POST['zip_code']);
                $country_id = (int)zen_db_prepare_input($_POST['country_id']);
                $city = "";
                $city_subsurb = "";
                $state = "";
                if ($zip_code == "") {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                    return false;
                }
                switch ($country_id) {
//                    case 81:
//                        $data = $db->Execute("SELECT city,city_suburb FROM `countries_de_zip` WHERE postcode = '" . $zip_code . "' AND country='Germany' LIMIT 1");
//                        if (!$data->EOF) {
//                            $city = $data->fields['city'] ? $data->fields['city'] : "";
//                            $city_subsurb = $data->fields['city_suburb'] ? $data->fields['city_suburb'] : "";
//                        }
//                        break;
                     //澳大利亚自动填充功能暂时屏蔽
//                    case 13:
//                        $data = $db->Execute("SELECT city,state FROM `countries_au_zip` WHERE postcode = '" . $zip_code . "'  LIMIT 1");
//                        if (!$data->EOF) {
//                            $city = $data->fields['city'] ? $data->fields['city'] : "";
//                            $state = $data->fields['state'] ? $data->fields['state'] : "";
//                        }
//                        break;
                    case 223:
                        $data = $db->Execute("SELECT city,states FROM `countries_to_zip_new` WHERE zip = '" . $zip_code . "'  LIMIT 1");
                        if (!$data->EOF) {
                            $city = $data->fields['city'] ? $data->fields['city'] : "";
                            $state = $data->fields['states'] ? $data->fields['states'] : "";
                        }
                        break;
                }
                $info = array(
                    "state" => $state,
                    "city" => $city,
                    "city_subsurb" => $city_subsurb
                );
                echo json_encode(array("status" => 200, "data" => $info));
                break;
            case "add_customer_address":
                if (empty($_SESSION['customer_id'])) {
                    echo json_encode(array("status" => 406));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $inquiry_id = $_POST['inquiry_id']?$_POST['inquiry_id']:"";
                $post_shipping_address = $shipping_address = $checkout::get_post_address_data();
                $checkout::$address = $shipping_address;
                $address_type = $_POST['address_type'];
                $vat_check = true;
                if ($_SESSION['customer_id'] && $_SESSION['sendto'] && $address_type == 2){
                    $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $_SESSION['customer_id'] . "");
                    $customer_num = $cus[0][1];
                    $frees =  taxFreeApplyFromAdmin($customer_num,$order->delivery['country']['title']);
                    if ($frees){
                        $billing_country_name = fs_get_data_from_db_fields_array(['countries_name'], 'countries', "countries_id=" . $shipping_address['entry_country_id'] . "");
                        $BName = strtolower($billing_country_name[0][0]);
                        $vat = strtolower($shipping_address['entry_tax_number']);
                        foreach ($frees as $free) {
                            if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName){
                                $vat_check = false;
                                break;
                            }
                        }
                    }
                }
                $validate = $checkout::validate($shipping_address,$vat_check);
//                $validate = $checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                //验证地址
                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,$address_book_id,'add',false);
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 405, "data" => $avaTaxResult['avaTaxError']));
                    exit;
                }
                $is_avaTaxCheck =  $_SESSION['useUpsDefaultAddress'] == 1 ?  false : true;
                $address_book_id = $checkout::addCustomersAddress($is_avaTaxCheck);
                if ($address_book_id) {
                    $shipping_address = $checkout::get_customers_address(1);
                    $billing_address = $checkout::get_customers_address(2);
                    $data['shipping_address'] = $shipping_address;
                    $data['billing_address'] = $billing_address;
                    $data['address_book_id'] = $address_book_id;
                    if($address_type == 1){
                        $_SESSION['sendto'] = $address_book_id;
                        if($inquiry_id){
                            require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                            $inquiry = new inquiry($currencies);
                            $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                            if($cart_products==false){
                                echo '{"error":"err","status":200}';
                                exit;
                            }
                            $order = new order("",$cart_products);
                        }else{
                            $order = new order();
                        }
                        $shipping_data = getAllShippingData();
                        $checkout::setShippingCost($shipping_data);
                        $avaTaxResult = $checkout::avaTaxHandle($order,$post_shipping_address,$address_book_id,'calculateVax');
                        if($avaTaxResult['avaTaxError']){
                            echo json_encode(array("status" => 408, "data" => $avaTaxResult['avaTaxError'],'code'=>$avaTaxResult['code']));
                            exit;
                        }
                        $order->resetOrderTotalInfo();
                        $data['info'] = $checkout::handlerShippingAddress($address_book_id,'','','',$order,$shipping_data);
                        $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $_SESSION['customer_id'] . "");
                        $data['info']['taxFreeAdmin'] = taxFreeApplyFromAdmin($cus[0][1],$data['info']['delivery_country']);
                    }
                    if(isset($_SESSION['checkout_default_ads'])){
                        unset($_SESSION['checkout_default_ads']);
                    }
                    echo json_encode(array("status" => 200, "data" => $data));
                    exit;
                } else {
                    echo json_encode(array("status" => 204, "data" => FS_SYSTME_BUSY));
                }
                break;
            case "delete_customer_address":
                if (empty($_SESSION['customer_id'])) {
                    echo json_encode(array("status" => 406));
                    exit;
                }
                $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
                if (!$address_book_id) {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $is_delete = $checkout::deleteCustomersAddress($address_book_id);
                $shipping_address = $checkout::get_customers_address(1);
                $billing_address = $checkout::get_customers_address(2);
                $data['shipping_address'] = $shipping_address;
                $data['billing_address'] = $billing_address;
                $data['address_book_id'] = $address_book_id;
                if ($is_delete) {
                    echo json_encode(array("status" => 200, "data" => $data));
                } else {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                }
                break;
            case "update_customer_address":
                if (empty($_SESSION['customer_id'])) {
                    echo json_encode(array("status" => 406));
                    exit;
                }
                $customers_id = (int)$_SESSION['customer_id'];
                $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
                if (!$address_book_id) {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $post_shipping_address = $shipping_address = $checkout::get_post_address_data($address_book_id);
                $checkout::$address = $shipping_address;
                $validate = $checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,$address_book_id,'update',false);
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 405, "data" => $avaTaxResult['avaTaxError']));
                    exit;
                }

                zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address, 'update', 'address_book_id=' . $address_book_id.' and customers_id='.$customers_id);
                $shipping_address = $checkout::get_customers_address(1);
                $billing_address = $checkout::get_customers_address(2);
                $data['shipping_address'] = $shipping_address;
                $data['billing_address'] = $billing_address;
                $data['address_book_id'] = $address_book_id;
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                $inquiry_id = $_POST['inquiry_id']?$_POST['inquiry_id']:"";
                $_SESSION['sendto'] = $address_book_id;
                if($inquiry_id){
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products =  $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                    if($cart_products==false){
                        return array("error" => FS_INQUIRY_INFO_66);
                    }
                    $order = new order("",$cart_products);
                }else{
                    $order = new order();
                }
                $shipping_data = getAllShippingData();
                $checkout::setShippingCost($shipping_data);
                $avaTaxResult = $checkout::avaTaxHandle($order,$post_shipping_address,$address_book_id,'calculateVax',true);
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 408, "data" => $avaTaxResult['avaTaxError'],'code'=>$avaTaxResult['code']));
                    exit;
                }
                $order->resetOrderTotalInfo();
                $data['info'] = $checkout::handlerShippingAddress($address_book_id,'','','',$order,$shipping_data);
                if($data['info']['avaTaxError']){
                    echo json_encode(array("status" => 405, "data" => $data['info']['avaTaxError']));
                    exit;
                }
                $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $_SESSION['customer_id'] . "");
                $data['info']['taxFreeAdmin'] = taxFreeApplyFromAdmin($cus[0][1],$data['info']['delivery_country']);
                if(isset($_SESSION['checkout_default_ads'])){
                    unset($_SESSION['checkout_default_ads']);
                }
                echo json_encode(array("status" => 200, "data" => $data));
                break;
            case "update_billing_address":
                $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
                $customers_id = (int)$_SESSION['customer_id'] ? (int)$_SESSION['customer_id'] : 0;
                $update_type = zen_db_prepare_input($_POST['update_type']);
                if (!$address_book_id) {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);

                $shipping_address = $checkout::get_post_address_data($address_book_id);
                $checkout::$address = $shipping_address;
                $vat_check = true;
                if ($customers_id && $_SESSION['sendto']){
                    $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $customers_id . "");
                    $customer_num = $cus[0][1];
                    $order = new order();
                    $frees =  taxFreeApplyFromAdmin($customer_num,$order->delivery['country']['title']);
                    if ($frees){
                        $billing_country_name = fs_get_data_from_db_fields_array(['countries_name'], 'countries', "countries_id=" . $shipping_address['entry_country_id'] . "");
                        $BName = strtolower($billing_country_name[0][0]);
                        $vat = strtolower($shipping_address['entry_tax_number']);
                        foreach ($frees as $free) {
                            if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName){
                                $vat_check = false;
                                break;
                            }
                        }
                    }
                }
                $validate = $checkout::validate($shipping_address,$vat_check);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address, 'update',
                    'address_book_id=' . $address_book_id .' and customers_id='.$customers_id);
                if(!empty($update_type) && $update_type == 'guest'){
                    $customer_info = new customer_account_info();
                    $shipping_address = $customer_info->get_customers_guest_shipping_address();
                    $billing_address = $customer_info->get_customers_guest_billing_address();
                }else{
                    $shipping_address = $checkout::get_customers_address(1);
                    $billing_address = $checkout::get_customers_address(2);
                }
                $data['shipping_address'] = $shipping_address;
                $data['billing_address'] = $billing_address;
                $data['address_book_id'] = $address_book_id;
                echo json_encode(array("status" => 200, "data" => $data));
                break;
            case "confirm_customer_address":
                if (empty($_SESSION['customer_id'])) {
                    echo json_encode(array("status" => 406));
                    exit;
                }
                $address_book_id = (int)$_POST["address_book_id"];
                if (!$address_book_id) {
                    echo json_encode(array("status" => 403, "data" => FS_SYSTME_BUSY));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $data['address_book_id'] = $address_book_id;

                //2019.1.18，fairy，修改，po地址不需要验证。因为po地址不能修改，即使验证不通过，用户也不能操作
                $error_param = [];
                if($_POST['error_type']){
                    $error_param['error_type'] = $_POST['error_type'];
                }
                $inquiry_id = $_POST['inquiry_id']?$_POST['inquiry_id']:"";
                $_SESSION['sendto'] = $address_book_id;
                if($inquiry_id){
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products =  $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                    if($cart_products==false){
                        return array("error" => FS_INQUIRY_INFO_66);
                    }
                    $order = new order("",$cart_products);
                }else{
                    $order = new order();
                }
                //重置运费
                $shipping_data = getAllShippingData();
                $checkout::setShippingCost($shipping_data);
                $shipping_address = $checkout::getShippingAddress($order);

                //英文站港澳台国家地址栏不能包含中文字符判断
                if(!empty($shipping_address) && in_array($_SESSION['languages_id'],array(1,9,10,13))) {
                    if ($order->chineseAddressDetermination($shipping_address['entry_country_id'], $shipping_address['entry_street_address'] . $shipping_address['entry_suburb']) == true) {
                        echo json_encode(array("status" => 403, "data" => FS_ADDRESSES_REGULAR_1));
                        exit;
                    }
                }
                //验证税收地址,生成税收
                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,$address_book_id,'confirm');
                if($avaTaxResult['avaTaxError'] &&  $avaTaxResult['type'] == 1){
                    echo json_encode(array("status" => 405, "data" => $avaTaxResult['avaTaxError']));
                    exit;
                }
                if($avaTaxResult['avaTaxError'] &&  $avaTaxResult['type'] == 2){
                    echo json_encode(array("status" => 408, "data" => $avaTaxResult['avaTaxError'],'code'=>$avaTaxResult['code']));
                    exit;
                }
                //重置订单价格
                $order->resetOrderTotalInfo();
                $data['info'] = $checkout::handlerShippingAddress($address_book_id, true,'',$error_param,$order,$shipping_data);
                $is_uk_business_address = false;
                if($order->billing['company_type'] == 'BusinessType' && in_array($order->billing['country']['id'],[222,244]) && $order->delivery['country_id'] !=81){
                    $is_uk_business_address = true;
                }
                $data['info']['price_data']['vat_title'] = get_checkout_vat_title($order->delivery['country']['iso_code_2'],2,'','',$is_uk_business_address);
                if ($data['info']['error']) {
                    echo json_encode(array("status" => 406, "data" => $data['info']['error']));
                    exit;
                }
                $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $_SESSION['customer_id'] . "");
                $data['info']['taxFreeAdmin'] = taxFreeApplyFromAdmin($cus[0][1],$data['info']['delivery_country']);
                if(isset($_SESSION['checkout_default_ads'])){
                    unset($_SESSION['checkout_default_ads']);
                }
                $data['info']['is_au_gsp'] = $order->delivery['country_id'] == 13 ? 1 : 0;

                echo json_encode(array("status" => 200, "data" => $data));
                break;
            case "confirm_customer_billing_address":
                $customer_info= new customer_account_info();
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $shipping_address = $customer_info->get_select_address($_SESSION['sendto']);
                $shipping_address_id = (int)zen_db_prepare_input($_POST['shipping_address_id']);

                //$is_global_shipping_free = $order->global_info['is_shipping_free'];
                $is_global_shipping_free = false;
                $validate = $checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                //如果老客户选择Brazil、Argentina、Chile没有填写税号
                if((in_array($shipping_address['entry_country_id'],array(30,10)) || ($shipping_address['entry_country_id']==43 && $shipping_address['company_type'] == "BusinessType"))){
                    if(empty($shipping_address['entry_tax_number'])){
                        echo json_encode(array("status" => 406, "data" => FS_TAX_ERROR_EMPTY, "is_validate_tax" => 1));
                        exit;
                    }
                }
                if(!$_POST['inquiry_id']) {
                    //获取购物产品
                    $order = new order();
                }else{
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_POST['inquiry_id']);
                    if($cart_products==false){
                        echo '{"error":"err","status":200}';
                        exit;
                    }
                    if($cart_products==false){
                        $order = new order();
                    }else{
                        $order = new order('',$cart_products);
                    }
                }
                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,$shipping_address_id,'confirm',false);
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 405, "data" => $avaTaxResult['avaTaxError']));
                    exit;
                }

                $billing_address_id = (int)zen_db_prepare_input($_POST['billing_address_id']);
                $is_use = (int)$_POST['is_use'];

                if ($is_use == 1) {
                    if (empty($shipping_address_id)) {
                        echo json_encode(array("status" => 406, "data" => FS_SYSTME_BUSY));
                        exit;
                    }
                    $shipping_address = $customer_info->get_select_address($shipping_address_id);
                    if (empty($shipping_address)){
                        echo json_encode(array("status" => 406, "data" => FS_SYSTME_BUSY));
                        exit;
                    }

                    //英文站港澳台国家地址栏不能包含中文字符判断
                    if(!empty($shipping_address) && in_array($_SESSION['languages_id'],array(1,9,10,13))) {
                        if ($order->chineseAddressDetermination($shipping_address['entry_country']['entry_country_id'], $shipping_address['entry_street_address'] . $shipping_address['entry_suburb']) == true) {
                            echo json_encode(array("status" => 409, "data" => FS_ADDRESSES_REGULAR_1));
                            exit;
                        }
                    }

                    $address = array(
                        'address_type' => 2,
                        'entry_company' => $shipping_address['entry_company'],

                        'entry_firstname' => $shipping_address['entry_firstname'],

                        'entry_lastname' => $shipping_address['entry_lastname'],

                        'company_type' => $shipping_address['company_type'],

                        'entry_street_address' => $shipping_address['entry_street_address'],

                        'entry_suburb' => $shipping_address['entry_suburb'],

                        'entry_postcode' => $shipping_address['entry_postcode'],

                        'entry_state' => $shipping_address['entry_state'],

                        'entry_city' => $shipping_address['entry_city'],

                        'entry_country_id' => $shipping_address['entry_country']['entry_country_id'],

                        'entry_zone_id' => $shipping_address['entry_zone_id'],

                        'entry_telephone' => $shipping_address['entry_telephone'],
                        'entry_tax_number' => $shipping_address['entry_tax_number']
                    );
                    /**
                     * 新加坡添加字段 jay
                     */
                    isset($shipping_address['ticket_number']) && $address['ticket_number'] = $shipping_address['ticket_number'];
                    $billing_address_id = $_SESSION['billto'] = $shipping_address_id;
                } else {
                    if (empty($billing_address_id)) {
                        echo json_encode(array("status" => 406, "data" => FS_SYSTME_BUSY));
                        exit;
                    }
                    $current_billing_address = $customer_info->get_select_address($billing_address_id);
                    $shipping_address = $customer_info->get_select_address($shipping_address_id);

                    //英文站港澳台国家运输地址地址栏不能包含中文字符判断
                    if(!empty($shipping_address) && in_array($_SESSION['languages_id'],array(1,9,10,13))) {
                        if ($order->chineseAddressDetermination($shipping_address['entry_country']['entry_country_id'], $shipping_address['entry_street_address'] . $shipping_address['entry_suburb']) == true) {
                            echo json_encode(array("status" => 409, "data" => FS_ADDRESSES_REGULAR_1));
                            exit;
                        }
                    }

                    //英文站港澳台国家收货地址栏不能包含中文字符判断
                    if(!empty($current_billing_address) && in_array($_SESSION['languages_id'],array(1,9,10,13))) {
                        if ($order->chineseAddressDetermination($current_billing_address['entry_country']['entry_country_id'], $current_billing_address['entry_street_address'] . $shipping_address['entry_suburb']) == true) {
                            echo json_encode(array("status" => 403, "data" => FS_ADDRESSES_REGULAR_1));
                            exit;
                        }
                    }

                    $current_address = array(
                        'address_type' => 2,
                        'entry_company' => $current_billing_address['entry_company'],

                        'entry_firstname' =>  $current_billing_address['entry_firstname'],

                        'entry_lastname' => $current_billing_address['entry_lastname'],

                        'company_type' =>  $current_billing_address['company_type'],

                        'entry_street_address' =>  $current_billing_address['entry_street_address'],

                        'entry_suburb' =>  $current_billing_address['entry_suburb'],

                        'entry_postcode' =>  $current_billing_address['entry_postcode'],

                        'entry_state' =>  $current_billing_address['entry_state'],

                        'entry_city' =>  $current_billing_address['entry_city'],

                        'entry_country_id' =>  $current_billing_address['entry_country']['entry_country_id'],

                        'entry_zone_id' =>  $current_billing_address['entry_zone_id'],

                        'entry_telephone' =>  $current_billing_address['entry_telephone'],
                        'entry_tax_number' =>  $current_billing_address['entry_tax_number']
                    );
                    /**
                     * 新加坡添加字段 jay
                     */
                    isset($current_billing_address['ticket_number']) && $current_address['ticket_number'] = $current_billing_address['ticket_number'];
                    $vat_check = true;
                    $customers_id = (int)$_SESSION['customer_id']?:0;
                    if ($customers_id && $_SESSION['sendto']){
                        $cus = fs_get_data_from_db_fields_array(['customers_email_address','customers_number_new'], TABLE_CUSTOMERS, "customers_id=" . $customers_id . "");
                        $customer_num = $cus[0][1];
                        $frees =  taxFreeApplyFromAdmin($customer_num,$order->delivery['country']['title']);
                        if ($frees){
                            $billing_country_name = fs_get_data_from_db_fields_array(['countries_name'], 'countries', "countries_id=" . $current_address['entry_country_id'] . "");
                            $BName = strtolower($billing_country_name[0][0]);
                            $vat = strtolower($shipping_address['entry_tax_number']);
                            foreach ($frees as $free) {
                                if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName){
                                    $vat_check = false;
                                    break;
                                }
                            }
                        }
                    }

                    $is_valid = $checkout::validate($current_address,$vat_check);
                    if (!empty($is_valid)) {
                        $country_id = $current_address['entry_country_id'];
                        $data = FS_VAT_ERROR;
                        if(!empty($is_valid['entry_postcode']['zip_valid'])){
                            //邮编
                            if($country_id==223){ //美国
                                $data = FS_ZIP_VALID_1;
                            }elseif($country_id==129){ //马来西亚
                                $data = FS_ZIP_VALID_2;
                            }else{
                                $data = $is_valid['entry_postcode']['zip_valid'];
                            }
                        }elseif(!empty($is_valid['tax_number']['remote_validate_tax_number'])){
                            //税号
                            $data = $current_address['entry_tax_number'];
                            echo json_encode(array("status" => 410, "tax" => $data,"country_id"=>$country_id,'erro'=>$is_valid['tax_number']['remote_validate_tax_number']));
                            exit;
                        }else{
                           $data = FS_BILLING_ADDRESS_ERROR;
                        }
                        echo json_encode(array("status" => 407, "data" => $data));
                        exit;
                    }

                    $_SESSION['billto'] = $billing_address_id;
                    $db->Execute("update " . TABLE_CUSTOMERS . " 
							SET customers_default_billing_address_id = " . $billing_address_id . " 
							WHERE customers_id = " . intval($_SESSION['customer_id']));
                }
                //2019.1.18，fairy，修改，po地址不需要验证。因为po地址不能修改，即使验证不通过，用户也不能操作
                //by  rebirth 2019/11/06  po已经没有地址标识了  所以有关判断全部取消
                $current_free_info = $order->get_free_shipping_money();
                $outPutTextPre = $current_free_info['outPutTextPre'];
                //估算税收
                $shipping_data = getAllShippingData();
                $checkout::setShippingCost($shipping_data);
                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,$shipping_address_id,'calculateVax');
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 408, "data" => $avaTaxResult['avaTaxError'],'code'=>$avaTaxResult['code']));
                    exit;
                }
                $order->resetBill();
                if(empty($order->billing['country']['id'])){
                    echo json_encode(array("status" => 403, "data" => 'The country/region of your address is not available, please choose others.'));
                    exit;
                }
                $order->resetOrderTotalInfo();
                $shipping_address = $checkout::get_customers_address(1);
                $billing_address = $checkout::get_customers_address(2);
                $data['shipping_address'] = $shipping_address;
                $data['billing_address'] = $billing_address;
                $data['address_book_id'] = $_SESSION['billto'];
                $data['payment'] = $payment_method;
                $product_info = $checkout::productInfo($order);
                $local_shipping_method = $order->handleShippingMethod($_SESSION['shipping_local']['id']);
                $delay_shipping_method = $order->handleShippingMethod($_SESSION['shipping_delay']['id']);
                $global_shipping_method = $order->handleShippingMethod($_SESSION['shipping_global']['id']);
                $order_info = $order->getCurrentOrderInfo();
                $symbol = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
                $symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
                $is_shipping_free = false;

                $shipping_price = $symbol . $currencies->fs_format_number($order_info['shipping']) . $symbol_right;
                $origin_total_us = $order->info['total'];
                $origin_total = zen_round($order_info['total'], 2);
                $total = $currencies->fs_format_number($order_info['total']);
                $subtotal = $currencies->fs_format_number($order_info['subtotal']);
                $vat = $currencies->fs_format_number($order_info['vat']);
                $insurance = $currencies->fs_format_number($order_info['insurance']);
                $warehouse = $order->local_warehouse;
                $total_before_tax = $currencies->fs_format_number($order_info['subtotal'] + $order_info['shipping']);

                //税后价
                $order_info_tax = $order->getAfterTaxCurrentOrderInfo();
                $subtotal_tax = $currencies->fs_format_number($order_info_tax['aftertax_subtotal']);
                $shipping_price_tax = $symbol . $currencies->fs_format_number($order_info_tax['aftertax_shipping']) . $symbol_right;

                $is_shipping_free = false;
                if($order_info['shipping'] == 0){
                    $is_shipping_free = true;
                    if($order->handleFreeShippingPrice($local_shipping_method,$delay_shipping_method)){
                        $shipping_price = FIBER_CHECK_FREE;
                    }
                    $shipping_price_tax = FIBER_CHECK_FREE;
                }

                $is_bill_company = false;
                if($order->billing['company_type'] == 'BusinessType' &&
                    (!german_warehouse('country_number',$order->billing['country_id']) || $order->billing['country_id'] == 81)){
                    $is_bill_company = true;
                }
                if($order->delivery['country_id'] == 21 && $order->billing['country_id'] == 223 && $order->billing['company_type'] != 'BusinessType'){
                    $is_bill_company = false;
                }
                $is_uk_business_address = false;
                if($order->billing['company_type'] == 'BusinessType' && in_array($order->billing['country']['id'],[222,244]) && $order->delivery['country_id'] !=81){
                    $is_uk_business_address = true;
                }
                $price_data = array(
                    "vat" => $vat,
                    "is_vax" => $order->is_vax,
                    "insurance" => $insurance,
                    "shipping_cost" => $shipping_price,
                    "total" => $total,
                    "subtotal" => $subtotal,
                    "origin_total" => $origin_total,
                    "is_shipping_free" => $is_shipping_free,
                    "origin_total_us" => $origin_total_us,
                    "shipping_cost_tax" => $shipping_price_tax,
                    "total_before_tax" => $total_before_tax,
                    'subtotal_tax' => $subtotal_tax,
                    "vat_title" => get_checkout_vat_title($order->delivery['country']['iso_code_2'],2,$is_bill_company,'',$is_uk_business_address)
                );
                $data['product_info'] = $product_info;
                $data['shipping_data'] = $shipping_data;
                $data['shipping_tag'] = [
                    'local' => $local_shipping_method,
                    "delay" => $delay_shipping_method,
                    "global"=> $global_shipping_method
                ];
                $data['warehouse'] = $order->local_warehouse;
                $data['price_data'] = $price_data;

                $data['currency_left'] = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
                $data['currency_right'] = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
                $data['is_global_shipping_free'] = $is_global_shipping_free;
                $data['outPutTextPre'] = $outPutTextPre;
                $data['cartCount'] = $_SESSION['cart']->count_contents();
                $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW;
                $c_id = $order->delivery['country_id'];
                if($product_info['order_num_info']['data'] == 'local'){
                    if(!in_array($c_id,['138','38','153']) && !other_eu_warehouse($c_id) && (!in_array($order->local_warehouse,[71,2]) || $c_id == 188)){
                        $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                    }
                }
                if(in_array($order->local_warehouse,[20,37]) && !other_eu_warehouse($c_id) && $c_id != 153 && !$order->is_local_buck){
                    if(in_array($product_info['order_num_info']['data'],['delay','local-delay'])){
                        $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                    }
                }
                echo json_encode(array("status" => 200, "data" => $data));
                break;
            case 'confirmPayment':
                $path = '';
                $resData = [];
                $payment_method = zen_db_prepare_input($_POST['payment_method']);
            if ($payment_method == "echeck") {
                    $account_name = zen_db_prepare_input($_POST['account_name']);
                    $account_number = zen_db_prepare_input($_POST['account_number']);
                    $account_type = zen_db_prepare_input($_POST['account_type']);
                    $account_route = zen_db_prepare_input($_POST['account_route']);
                    if (empty($account_name) || empty($account_number) || empty($account_type) || empty($account_route)) {
                        echo json_encode(array("status" => 406, "data" => FS_SYSTME_BUSY));
                       exit;
                   }
             }
                if ($payment_method == "alfa") {
                    //俄罗斯对公支付验证
                    $service = new \App\Services\Payments\RuPaymentServices();
                    $service->setInformationAddress();
                    if ('no' == zen_db_prepare_input($_POST['fileExists'])) {
                        $alfa_data = Checkout::alfa_account_validate();
                        if ($alfa_data['status'] == 403) {
                            echo json_encode($alfa_data);
                            exit;
                        }
                        $insertData = [
                            'alfa_phone' => zen_db_prepare_input($_POST['alfa_account_phone']),
                            'alfa_email' => zen_db_prepare_input($_POST['alfa_account_email']),
                            'alfa_organization' => zen_db_prepare_input($_POST['alfa_account_organization']),
                            'alfa_inn' => zen_db_prepare_input($_POST['alfa_account_inn']),
                            'alfa_kpp' => zen_db_prepare_input($_POST['alfa_account_kpp']),
                            'alfa_bic' => zen_db_prepare_input($_POST['alfa_account_bic']),
                            'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_account_legal']),
                            'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_account_bank']),
                            'card_path' => $_POST['cardPath'],
                            'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
                        ];
                        $temp = $service->createRuOrderInfo($insertData);
                        $resData = $service->encodeData($temp);
                    } else {
                        if (Checkout::fileExists()) {//有文件
                            // 文件大小，文件类型验证
                            $config = [
                                'savePath' => 'rualfa/' . $_SESSION['customer_id'],
                                'isChangeName' => false,
                                'fileExtension' => [
                                    'png',
                                    'jpg',
                                    'jpeg',
                                    'doc',
                                    'xls',
                                    'docx',
                                    'xlsx',
                                    'pdf'
                                ]
                            ];
                            $data = Checkout::fileValidate($config);

                            if (!empty($data)) {
                                echo json_encode($data);
                                exit;
                            }

                            $path = $service->uploadCard($config, 'paymentUploadFile');
                            if (empty($path)) {
                                echo json_encode(array("status" => 406, "data" => FS_CHECKOUT_RU_FILE_TIPS_2));
                                exit;
                            }
                            $insertData = [
                                'alfa_phone' => zen_db_prepare_input($_POST['alfa_account_phone']),
                                'alfa_email' => zen_db_prepare_input($_POST['alfa_account_email']),
                                'alfa_organization' => zen_db_prepare_input($_POST['alfa_account_organization']),
                                'alfa_inn' => zen_db_prepare_input($_POST['alfa_account_inn']),
                                'alfa_kpp' => zen_db_prepare_input($_POST['alfa_account_kpp']),
                                'alfa_bic' => zen_db_prepare_input($_POST['alfa_account_bic']),
                                'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_account_legal']),
                                'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_account_bank']),
                                'card_path' => $path,
                                'card_path_name' => $_FILES['paymentUploadFile']['name'],
                                'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
                            ];
                            $service->createRuOrderInfo($insertData);
                            $resData = $service->lastPaymentInformation();
                        } else {
                            if (!empty(zen_db_prepare_input($_POST['cardPath']))) {
                                $insertData = [
                                    'alfa_phone' => zen_db_prepare_input($_POST['alfa_account_phone']),
                                    'alfa_email' => zen_db_prepare_input($_POST['alfa_account_email']),
                                    'alfa_organization' => zen_db_prepare_input($_POST['alfa_account_organization']),
                                    'alfa_inn' => zen_db_prepare_input($_POST['alfa_account_inn']),
                                    'alfa_kpp' => zen_db_prepare_input($_POST['alfa_account_kpp']),
                                    'alfa_bic' => zen_db_prepare_input($_POST['alfa_account_bic']),
                                    'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_account_legal']),
                                    'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_account_bank']),
                                    'card_path' => $_POST['cardPath'],
                                    'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
                                ];
                                $service->createRuOrderInfo($insertData);
                                $resData = $service->lastPaymentInformation();
                                $_SESSION['payment'] = $payment_method;
                                echo json_encode(array("status" => 200, "data" => $resData));
                                exit;
                            } else {
                                echo json_encode(['status' => 406, "message" => FS_CHECKOUT_RU_FILE_TIPS_2]);
                                exit;
                            }
                        }
                    }
                }
                if (!zen_not_null($payment_method)) {
                    echo json_encode(array("status" => 406, "data" => FS_SYSTME_BUSY));
                    exit;
                }

                $_SESSION['payment'] = $payment_method;
                echo json_encode(array("status" => 200, "data" => $resData));
                break;
            case "change_shipping":
                require_once(DIR_WS_CLASSES . 'order.php');
                require_once(DIR_WS_CLASSES . 'shipping.php');
                if(!$_POST['inquiry_id']) {
                    //获取购物产品
                    $order = new order();
                }else{
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_POST['inquiry_id']);
                    if($cart_products==false){
                        echo '{"error":"err","status":200}';
                        exit;
                    }
                    if($cart_products==false){
                        $order = new order();
                    }else{
                        $order = new order('',$cart_products);
                    }
                }
                $customer_info = new customer_account_info();
                $delay_content = array();
                $local_sub_text = $currencies->total_format_new($order->local_info['subtotal'], true, $order->info['currency'], $order->info['currency_value']);
                $shipping_method = zen_db_prepare_input($_POST['shipping_method']);
                $shipping_type = zen_db_prepare_input($_POST['shipping_type']);

                $shipping_data = getAllShippingData();
                $shipping_cost = $shipping_data[$shipping_type];
                if(sizeof($shipping_cost)){
                    foreach ($shipping_cost as $v){
                        if($v['methods'] == $shipping_method){
                            $_SESSION['shipping_'.$shipping_type] = array('id' => $v['methods'] . '_' . $v['methods'],

                                'title' => $v['title'],

                                'cost' => $v['s_price'],

                                'origin_price' => $v['origin_price'],
                            );
                        }
                    }
                }
                $shipping_arr = ["local","delay","global",'gift'];
                $shipping_address = $customer_info->get_select_address($_SESSION['sendto']);
                $checkout =  Checkout::getInstance();
                $is_shipping_free = false;
                $symbol = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
                $symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
                $vat = $currencies->fs_format_new($order->vat, true, $order->info['currency'], $order->info['currency_value']);
                $sub_total = $currencies->total_value($order->info['subtotal']);
                $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
                $origin_shipping_cost = 0;
                foreach ($shipping_arr as $kk){
                    if($_SESSION['shipping_'.$kk]){
                        $origin_shipping_cost += $_SESSION['shipping_'.$kk]['origin_price'];
                    }else{
                        unset($_SESSION['shipping_'.$kk]);
                    }
                }

                $avaTaxResult = $checkout::avaTaxHandle($order,$shipping_address,'','calculateVax',true);
                if($avaTaxResult['avaTaxError']){
                    echo json_encode(array("status" => 408, "data" => $avaTaxResult['avaTaxError'],'code'=>$avaTaxResult['code']));
                    exit;
                }
                $order->resetOrderTotalInfo();
                $order_info = $order->getCurrentOrderInfo();

                $shipping_price = $symbol . $currencies->fs_format_number($order_info['shipping']) . $symbol_right;
                if($origin_shipping_cost == 0){
                    $is_shipping_free = true;
                    if($order->handleFreeShippingPrice($shipping_method,$shipping_method)){
                        $shipping_price = FIBER_CHECK_FREE;
                    }
                }

                $origin_total_us = $order->info['total'];
                $origin_total = zen_round($order_info['total'], 2);
                $total = $currencies->fs_format_number($order_info['total']);
                $subtotal = $currencies->fs_format_number($order_info['subtotal']);
                $vat = $currencies->fs_format_number($order_info['vat']);
                $insurance = $currencies->fs_format_number($order_info['insurance']);
                $total_before_tax = $currencies->fs_format_number($order_info['subtotal'] + $order_info['shipping']);

                //税后价
                $order_info_tax = $order->getAfterTaxCurrentOrderInfo();
                $subtotal_tax = $currencies->fs_format_number($order_info_tax['aftertax_subtotal']);

                if($is_shipping_free){
                    $shipping_price_tax = FIBER_CHECK_FREE;
                }else{
                    $shipping_price_tax = $symbol . $currencies->fs_format_number($order_info_tax['aftertax_shipping']) . $symbol_right;
                }

                $warehouse = $order->local_warehouse;
                $productInfo= Checkout::productInfo($order);
                $country_id = $order->delivery['country_id'];
                $price_data = array(
                    "vat" => $vat,
                    "is_vax" => $order->is_vax,
                    "shipping_cost" => $shipping_price,
                    "total" => $total,
                    'subtotal' => $subtotal,
                    "origin_total" => $origin_total,
                    "is_shipping_free" => $is_shipping_free,
                    "origin_total_us" => $origin_total_us,
                    "shipping_cost_tax" => $shipping_price_tax,
                    "total_before_tax" => $total_before_tax,
                    'subtotal_tax' => $subtotal_tax,
                    'insurance' => $insurance,
                    "vat_title" => get_checkout_vat_title($order->delivery['country']['iso_code_2'],2)
                );
                $data = array(
                    "status" => 200,
                    "info" => [
                        'country' => $country_id,
                        'is_delay_buck' => $order->is_buck,
                        "price_data" => $price_data,
                        "warehouse" => $warehouse,
                        "currency_left" => $currencies->currencies[$_SESSION['currency']]['symbol_left'],
                        "currency_right" => $currencies->currencies[$_SESSION['currency']]['symbol_right'],
                    ],
                    productInfo => $productInfo
                );
                echo json_encode($data);
                break;

            case 'create_order':

                if ($debug) {
                    $file = DIR_FS_SQL_CACHE . '/ajax-create-order-' . time() . '.log';
                    $handle = fopen($file, 'a+');
                    @chmod($file, 777);
                }

                $_SESSION['delivery_array'] = [
                    'ticker_number_mgb' => zen_db_prepare_input($_POST['ticker_number_mgb']),
                    'delivery_other_mgb' => zen_db_prepare_input($_POST['delivery_other_mgb'])
                ];
                require_once(DIR_WS_CLASSES . 'shipping.php');
                require_once(DIR_WS_CLASSES . 'payment.php');
                $payment = new payment();
                require_once(DIR_WS_CLASSES . 'order.php');
                $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
                if ($debug) fwrite($handle, ' init order - ' . time() . " \n");
                if ($debug) fwrite($handle, ' init shipping - ' . time() . " \n");
                $senTo = (int)$_POST['sendTo'];
                $billTo = (int)$_POST['billTo'];
                $inquiry_id = $_POST['inquiry_id']?$_POST['inquiry_id']:"";
                $post_cart_counts = (int)$_POST['cart_counts'];
                $total_count = $_SESSION['cart']->count_contents();
                if($post_cart_counts != $total_count){
                    echo json_encode(['status'=>403,'message' => FS_SHOPPING_CAUTION]);
                    exit;
                }
                if($inquiry_id){
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                    if($cart_products==false){
                        echo '{"error":"err","status":200}';
                        exit;
                    }
                    $order = new order("",$cart_products,$senTo,$billTo);/*for paypal load shipping */
                }else{
                    $order = new order("","",$senTo,$billTo);/*for paypal load shipping */
                }

                if (!zen_not_null($order->info['subtotal'])){
                    echo '{"error":"err","status":200}';
                    exit;
                }
                require_once(DIR_WS_CLASSES . 'order_total.php');
                $pick_tag = zen_db_prepare_input($_POST['pick_tag']);
                $custome_tag = zen_db_prepare_input($_POST['custome_tag']);
                $remarks_local = $_POST['remarks_local'] ? $_POST['remarks_local'] : '';
                $remarks_delay = $_POST['remarks_delay'] ? $_POST['remarks_delay'] : '';
                $insertData = [];
                $insertData['remarks'] = ['local' => $remarks_local,'delay' => $remarks_delay];
                $localInstall = $_POST['localInstall'] ? zen_db_prepare_input($_POST['localInstall']) : "";
                $installTime = $_POST['install_time'] ? zen_db_prepare_input($_POST['install_time']) : "";
                if($installTime){
                    $insertData['install'] = [
                        'localInstall' => $localInstall,
                        'installTime' => $installTime
                    ];
                }
                if($pick_tag){
                    if(strpos($pick_tag,"_")!==false){
                        $pick_tag = explode("_",$pick_tag);
                    }else{
                        $pick_tag = [$pick_tag];
                    }
                    createOrderShippingInfo($pick_tag, 1);
                }
                if($custome_tag){
                    if(strpos($custome_tag,"_")!==false){
                        $custome_tag = explode("_",$custome_tag);
                    }else{
                        $custome_tag = [$custome_tag];
                    }
                    createOrderShippingInfo($custome_tag, 2);
                }
                $order_total_modules = new order_total();
                $order_totals = $order_total_modules->process();
                if ($debug) fwrite($handle, ' init order totals - ' . time() . " \n");
                $_SESSION['payment'] = isset($_SESSION['payment']) ? $_SESSION['payment'] : 'paypal';
                $_SESSION['payment'] = $_SESSION['payment'] ? $_SESSION['payment'] : 'paypal';
                $payment = new payment($_SESSION['payment']);
                if ($debug) fwrite($handle, ' init payment - ' . time() . " \n");
                if ($_SESSION['cart']->get_products() || $inquiry_id) {
                    $customers_po = zen_db_input($_POST['customer_po']);
                    $related_email = !empty($_POST['related_email']) ? zen_db_prepare_input($_POST['related_email']) : "";
                    if (!empty($related_email)) {
                        $_SESSION['related_email'] = $related_email;
                    }
                    if (!empty($customers_po)) {
                        $_SESSION['customers_po'] = $customers_po;
                    }
                    $customer_remarks = zen_db_input($_POST['customer_remarks']);
                    if (!empty($customer_remarks)) {
                        $_SESSION['customer_remarks'] = $customer_remarks;
                    }

                    $client_type = zen_db_prepare_input($_POST['client_type']);
                    if (!empty($client_type)) {
                        $_SESSION['client_type'] = $client_type;
                    }
                    $order_id = $order->create_order_new($order_totals, $order_total_modules,$insertData);

                    /*客户分配开始*/
                    customerOrderToAdmin($order_id);
                    /*客户分配结束*/

                    $products_custom = zen_db_prepare_input($_POST['products_custom']);
                    if ($products_custom) {
                        $sql = 'update orders set products_custom = "' . $products_custom . '" where orders_id =' . $order_id;
                        $db->Execute($sql);
                    }
                    $_SESSION['order_id'] = $order_id;
                    $_SESSION['req_qreoid'] = $order_id;
                    if ($debug) fwrite($handle, ' create  order -order number is ' . $invoice . ' - ' . time() . " \n");
                    if ($debug) fwrite($handle, ' add products to  order  - ' . time() . '\n');
                    $get_orders_number = $db->Execute("select orders_number from " . TABLE_ORDERS . " where orders_id = " . $order_id);
                    $invoice = $get_orders_number->fields['orders_number'];
                    if ($debug) fwrite($handle, ' send order email - ' . time() . " \n");
                    $action = $process_string = '';
                    if(!$inquiry_id){
                        $_SESSION['cart']->reset(true);
                    }else{
                        //报价单完成 order_id保存
                        if($_SESSION['customer_id'] && $order_id){
                            zen_db_perform("customer_inquiry",array('order_id'=>$order_id),'update',"customers_id=".$_SESSION['customer_id']." and id=".$inquiry_id);
                        }
                    }

                    //订单生成后及时删除运输信息
                    if (isset($_SESSION['related_email'])) {
                        unset($_SESSION['related_email']);
                    }
                    //订单生成后及时删除客户remark信息
                    if (isset($_SESSION['customer_remarks'])) {
                        unset($_SESSION['customer_remarks']);
                    }
                    if (isset($_SESSION['customers_po'])) {
                        unset($_SESSION['customers_po']);
                    }
                    if ('paypal' == $_SESSION['payment']) {
                        if ($debug) fwrite($handle, ' process paypal action - ' . time() . " \n");
                        $class = &$_SESSION['payment'];
                        $action = $GLOBALS[$class]->form_action_url;
                        if ($debug) fwrite($handle, 'action url: ' . $action . ' - ' . time() . " \n");
                        $process_string = $GLOBALS[$class]->process_string();
                        $process_string .= '::invoice--' . $invoice;

                        if ($debug) fwrite($handle, '$process_string: ' . $process_string . ' - ' . time() . " \n");;

                        if ($debug) {
                            fclose($handle);
                            @chmod($file, 777);
                        }
                        if(isset($_SESSION['shipping_delay'])){
                            unset($_SESSION['shipping_delay']);
                        }
                        if(isset($_SESSION['shipping_local'])){
                            unset($_SESSION['shipping_local']);
                        }
                        if(isset($_SESSION['useUpsDefaultAddress'])){
                            unset($_SESSION['useUpsDefaultAddress']);
                        }
                        echo '{"type":"' . $_SESSION['payment'] . '","url":"' . $action . '","params":"' . $process_string . '","o_id":"' . (int)$_SESSION['order_id'] . '","status":200}';

                    } elseif (in_array($_SESSION['payment'], array('bpay', 'eNETS', 'iDEAL', 'SOFORT', 'YANDEX', 'WEBMONEY'))) {

                        $order = new order($order_id);

                        $class = &$_SESSION['payment'];

                        $action = $GLOBALS[$class]->form_action_url;

                        if ($debug) fwrite($handle, 'action url: ' . $action . ' - ' . time() . " \n");
                        if(isset($_SESSION['shipping_delay'])){
                            unset($_SESSION['shipping_delay']);
                        }
                        if(isset($_SESSION['shipping_local'])){
                            unset($_SESSION['shipping_local']);
                        }
                        if(isset($_SESSION['useUpsDefaultAddress'])){
                            unset($_SESSION['useUpsDefaultAddress']);
                        }
                        $process_string = $GLOBALS[$class]->process_string();
                        echo '{"params":"' . $process_string . '","o_id":"' . (int)$order_id . '","status":200}';
                    } elseif ('globalcollect' == $_SESSION['payment'] || 'payeezy' == $_SESSION['payment']) {
                        unset($_SESSION['sendto']);
                        unset($_SESSION['billto']);
                        if(isset($_SESSION['shipping_delay'])){
                            unset($_SESSION['shipping_delay']);
                        }
                        if(isset($_SESSION['shipping_local'])){
                            unset($_SESSION['shipping_local']);
                        }
                        if(isset($_SESSION['useUpsDefaultAddress'])){
                            unset($_SESSION['useUpsDefaultAddress']);
                        }
                        unset($_SESSION['payment']);
                        unset($_SESSION['comments']);
                        //unset($_SESSION['cart']);
                        echo json_encode(array("status" => 200, "order_id" => $order_id));
                        exit;
                    }
                } else {
                    if ('paypal' == $_SESSION['payment']) {
                        echo '{"error":"err","status":200}';
                        exit;
                    }
                }

                //fallwind 2016.10.14	下单成功时，判断$_SESSION['google_ads']是否有值，有值就记录其ip，同时记录该值
                if (!empty($_SESSION['google_ads']) && isset($_SESSION['google_ads'])) {
                    $customer_come_ip = getCustomersIP();
                    setComeIpByOrders($customer_come_ip, $_SESSION['order_id']);
                }
                break;
            case 'send_email':
                if ($debug) {
                    $file = DIR_FS_SQL_CACHE . '/ajax-send-mail-' . time() . '.log';
                    $handle = fopen($file, 'a+');
                    @chmod($file, 777);
                }
                function zen_check_order_exist($orders_id)
                {
                    global $db;
                    $get_info = $db->Execute("select count(orders_id) as total from " . TABLE_ORDERS . " where orders_id = " . (int)$orders_id);
                    return ($get_info->fields['total'] ? true : false);
                }

                $orders_id = $_POST['orders_id'];
//				var_dump($orders_id);
                if ($debug) fwrite($handle, $orders_id . "\n");
                $complete_mail = false;
                if (isset($orders_id) && zen_check_order_exist($orders_id)) {
                    //var_dump($admin_id);
                    require_once(DIR_WS_CLASSES . 'order.php');
                    $order = new order($orders_id);/*for paypal load shipping */
                    if ($debug) fwrite($handle, 'before send mail' . "\n");
                    if (isset($_GET['type']) && $_GET['type'] == 'gc') {
                        $order->send_fs_credit_card_order_email($orders_id, false);
                    } elseif ($_GET['type'] == 'bpay' || $_GET['type'] == 'eNETS' || $_GET['type'] == 'iDEAL' || $_GET['type'] == 'SOFORT' || $_GET['type'] == 'YANDEX' || $_GET['type'] == 'WEBMONEY') {
                        $gc_type = $_GET['type'] == 'bpay' ? 'BPAY' : $_GET['type'];
                        $order->send_fs_gc_order_email($orders_id, $gc_type);
                    } else {
                        $order->send_fs_order_email($orders_id, $complete_mail);
                    }

                    if ($debug) {
                        fwrite($handle, 'after send mail' . "\n");
                        fclose($handle);
                    }
                }

                break;

            case 'save_customer_po':
                require_once(DIR_WS_CLASSES . 'shipping.php');


                $_SESSION['delivery_array'] = [
                    'ticker_number_mgb' => zen_db_prepare_input($_POST['ticker_number_mgb']),
                    'delivery_other_mgb' => zen_db_prepare_input($_POST['delivery_other_mgb'])
                ];
                $_SESSION['customers_po'] = $_POST['customer_po'];
                $_SESSION['customer_remarks'] = $_POST['customer_remarks'];
                $_SESSION['products_custom'] = $_POST['products_custom'];
                $_SESSION['need_invoice'] = $_POST['invoice_need'];
                $client_type = zen_db_prepare_input($_POST['client_type']);
                $related_email = !empty($_POST['related_email']) ? zen_db_prepare_input($_POST['related_email']) : "";
                $pick_tag = zen_db_prepare_input($_POST['pick_tag']);
                $custome_tag = zen_db_prepare_input($_POST['custome_tag']);
                $localInstall = $_POST['localInstall'] ? zen_db_prepare_input($_POST['localInstall']) : "";
                $installTime = $_POST['install_time'] ? zen_db_prepare_input($_POST['install_time']) : "";
                $billTo = (int)$_POST['billTo'];
                $remarks_local = $_POST['remarks_local'] ? $_POST['remarks_local'] : ''; //此处和zen_db_perform方法中都用了zen_db_prepare_input进行过滤 导致换行符转换成了n 故去掉此处的过滤
                $remarks_delay = $_POST['remarks_delay'] ? $_POST['remarks_delay'] : '';
                $_SESSION['remarks'] = ['local' => $remarks_local,'delay' => $remarks_delay];
                $post_cart_counts = (int)$_POST['cart_counts'];
                $total_count = $_SESSION['cart']->count_contents();
                if($post_cart_counts != $total_count){
                    //echo json_encode(['status'=>403,'message' =>
                    //    'You have updated the items of your shopping cart. So please return back your cart to check it, and then checkout again.']);
                    echo json_encode(['status'=>403,'message' => FS_SHOPPING_CAUTION]);
                    exit;
                }
                if($installTime){
                    $_SESSION['install'] = [
                        'localInstall' => $localInstall,
                        'installTime' => $installTime
                    ];
                }
                if (!empty($related_email)) {
                    $_SESSION['related_email'] = $related_email;
                }
                if (!empty($client_type)) {
                    $_SESSION['client_type'] = $client_type;
                }
                if($pick_tag){
                    if(strpos($pick_tag,"_")!==false){
                        $pick_tag = explode("_",$pick_tag);
                    }else{
                        $pick_tag = [$pick_tag];
                    }
                    createOrderShippingInfo($pick_tag, 1);
                }
                if($custome_tag){
                    if(strpos($custome_tag,"_")!==false){
                        $custome_tag = explode("_",$custome_tag);
                    }else{
                        $custome_tag = [$custome_tag];
                    }
                    createOrderShippingInfo($custome_tag, 2);
                }
                if (!empty($_SESSION['payment']) && $_SESSION['payment'] == "echeck") {
                    $_SESSION['echeck_info'] = array(
                        "account_name" => zen_db_prepare_input($_POST['account_name']),
                        "account_number" => zen_db_prepare_input($_POST['account_number']),
                        "account_type" => zen_db_prepare_input($_POST['account_type']),
                        "account_route" => zen_db_prepare_input($_POST['account_route'])
                    );
                }
                if (!empty($_SESSION['payment']) && $_SESSION['payment'] == "alfa") {
                    $data = array(
                        "alfa_contact_person" => zen_db_prepare_input($_POST['alfa_account_person']),
                        "alfa_phone" => zen_db_prepare_input($_POST['alfa_account_phone']),
                        "alfa_email" => zen_db_prepare_input($_POST['alfa_account_email']),
                        "alfa_organization" => zen_db_prepare_input($_POST['alfa_account_organization']),
                        "alfa_inn" => zen_db_prepare_input($_POST['alfa_account_inn']),
                        "alfa_kpp" => zen_db_prepare_input($_POST['alfa_account_kpp']),
                        "alfa_okpo" => zen_db_prepare_input($_POST['alfa_account_okpo']),
                        "alfa_bic" => zen_db_prepare_input($_POST['alfa_account_bic']),
                        "alfa_legal_address" => zen_db_prepare_input($_POST['alfa_account_legal']),
                        "alfa_postal_address" => zen_db_prepare_input($_POST['alfa_account_postal']),
                        "alfa_correspondent_accout" => zen_db_prepare_input($_POST['alfa_account_correspondent']),
                        "alfa_bank_name" => zen_db_prepare_input($_POST['alfa_account_bank']),
                        "alfa_settlement_account" => zen_db_prepare_input($_POST['alfa_account_settlement']),
                        "alfa_holder_name" => zen_db_prepare_input($_POST['alfa_account_full_name']),
                        "card_path" => $_POST['cardPath'],
                        "ru_mgb_pro_id" => $_POST["ru_mgb_pro_id"]
                    );
                    $_SESSION['alfa_info'] = $data;
                }

                echo json_encode(array("status" => 200, 'data' => $_SESSION['alfa_info']));
                break;

            //已下为游客页面操作

            case 'update_guest_address':
                if (isset($_SESSION['customer_id'])) {
                    echo json_encode(array("status" => 403, "data" => "You are logged in and are jumping the page for you"));
                    exit;
                }
                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);
                $shipping_address = $checkout::get_post_address_data();
                $validate = $checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                $entry_firstname = zen_db_prepare_input($_POST['entry_firstname']);
                $entry_lastname = zen_db_prepare_input($_POST['entry_lastname']);
                $entry_country_id = zen_db_prepare_input($_POST['entry_country_id']);

                $email_address = zen_db_prepare_input($_POST['entry_email']);
                //匹配黑名单邮箱阻止提交
                $blacklist = get_user_blacklist($email_address);
                if ($blacklist == true) {
                    $error = true;
                    echo json_encode(array("status" => 403, "data" => FS_ACCESS_DENIED_1));
                    exit;
                }
                if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
                    $error = true;
                    echo json_encode(array("status" => 403, "data" => ENTRY_EMAIL_ADDRESS_ERROR));
                    exit;
                } else if (zen_validate_email($email_address) == false) {
                    $error = true;
                    echo json_encode(array("status" => 403, "data" => ENTRY_EMAIL_ADDRESS_CHECK_ERROR));
                    exit;
                } else {
                    $check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
												 where customers_email_address = '" . $email_address . "'";
                    $check_email = $db->Execute($check_email_query);
                    if ($check_email->fields['total'] > 0) {
                        $error = true;
                        $html = FS_CHECKOUT_GUEST_LOG_MSG;
                        echo json_encode(array("status" => 403, "data" => $html));
                        exit;
                    }
                }

                $customer_guest = array(

                    'email_address' => $email_address,

                    'first_name' => $entry_firstname,

                    'last_name' => $entry_lastname,

                    'customer_country_id' => (int)$entry_country_id,

                    'add_time' => date('Y-m-d H:i:s')

                );
                $customer_info = new customer_account_info();
                $is_time_out = false;
                if($_SESSION['customers_guest_id']){
                    $re = $db->getAll("select customers_default_address_id,guest_id from customer_of_guest where guest_id = " . $_SESSION['customers_guest_id'] . " order by guest_id DESC limit 1");
                }else{
                    $re = $db->getAll("select customers_default_address_id,guest_id from customer_of_guest where email_address = '" . trim($email_address) . "' order by guest_id DESC limit 1");
                }
                //如果是新用户
                if (!$re[0]['customers_default_address_id']) {
                    $_SESSION['sendtoG'] = $address_id = $customer_info->add_guest_shipping_address_new($shipping_address, $customer_guest);
                    $use_address[] = $customer_info->get_select_address($address_id);
                    $is_time_out = true;
                } else {
                    //如果是老用户
                    $_SESSION['sendtoG'] = $address_id = $re[0]['customers_default_address_id'];
                    zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest, 'update', 'guest_id = ' . intval($re[0]['guest_id']));
                    zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address, 'update', 'address_book_id = ' . intval($re[0]['customers_default_address_id']));
                    $_SESSION['customers_guest_id'] = intval($re[0]['guest_id']);
                    $use_address[] = $customer_info->get_select_address($re[0]['customers_default_address_id']);
                }
                if ($address_id) {
                    $data['shipping_address'] = $use_address;
                    $data['address_book_id'] = $address_id;
                    $data['info'] = $checkout::handlerShippingAddress($address_id,false,true);
                    $product_info = $checkout::productInfo($order);
                    $data['product_info'] = $product_info;
                    $data['is_time_out'] = $is_time_out;
                    echo json_encode(array("status" => 200, "data" => $data));
                    exit;
                } else {
                    echo json_encode(array("status" => 204, "data" => FS_SYSTME_BUSY));
                }
                echo json_encode($data);
                break;

            case "confirm_billing_guest_address":
                $customer_info = new customer_account_info();
                $is_use = (int)$_POST["is_use"];
                $payment_method = zen_db_prepare_input($_POST['payment_method']);
                $billing_address_id = (int)$_POST['billing_address_id'];
                $_SESSION['payment'] = $payment_method;

                $checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
                ]);

                if ($payment_method == "alfa") {
                    //俄罗斯对公支付验证
                    $alfa_data = $checkout::alfa_account_validate();
                    if($alfa_data['status']==403){
                        echo json_encode($alfa_data);
                        exit;
                    }
                }
                if ($is_use) {
                    $shipping_address = $customer_info->get_select_address($_SESSION['sendtoG']);
                    $address = array(
                        'address_type' => 2,
                        'entry_company' => $shipping_address['entry_company'],

                        'entry_firstname' => $shipping_address['entry_firstname'],

                        'entry_lastname' => $shipping_address['entry_lastname'],

                        'entry_street_address' => $shipping_address['entry_street_address'],

                        'entry_suburb' => $shipping_address['entry_suburb'],

                        'entry_postcode' => $shipping_address['entry_postcode'],

                        'entry_state' => $shipping_address['entry_state'],

                        'entry_city' => $shipping_address['entry_city'],

                        'entry_country_id' => $shipping_address['entry_country']['entry_country_id'],

                        'entry_zone_id' => $shipping_address['entry_zone_id'],

                        'entry_telephone' => $shipping_address['entry_telephone'],
                        'entry_tax_number' => $shipping_address['entry_tax_number'],
                        'company_type' => $shipping_address['company_type']
                    );
                    if ($billing_address_id) {
                        zen_db_perform(TABLE_ADDRESS_BOOK, $address, 'update', 'address_book_id = ' . $billing_address_id);
                        $_SESSION['billtoG'] = $address_id = $billing_address_id;
                    } else {
                        $_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address_new($address);
                    }
                } else {
                    $_SESSION['billtoG'] = $billing_address_id;
                }
                $use_address = $customer_info->get_customers_guest_billing_address();
                $order = new order();
                $order_info = $order->getCurrentOrderInfo();
                $symbol = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
                $symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
                $is_shipping_free = false;

                $shipping_price = $symbol . $currencies->fs_format_number($order_info['shipping']) . $symbol_right;
                $origin_total_us = $order->info['total'];
                $origin_total = zen_round($order_info['total'], 2);
                $total = $currencies->fs_format_number($order_info['total']);
                $subtotal = $currencies->fs_format_number($order_info['subtotal']);
                $vat = $currencies->fs_format_number($order_info['vat']);
                $insurance = $currencies->fs_format_number($order_info['insurance']);

                if($order_info['shipping'] == 0){
                    $is_shipping_free = true;
                    if($order->handleFreeShippingPrice()){
                        $shipping_price = FIBER_CHECK_FREE;
                    }
                }

                $shipping_data = getAllShippingData();
                $local_shipping_method = $order->handleShippingMethod($_SESSION['shipping_local']['id']);
                $delay_shipping_method = $order->handleShippingMethod($_SESSION['shipping_delay']['id']);
                $global_shipping_method = $order->handleShippingMethod($_SESSION['shipping_global']['id']);
                $product_info = $checkout::productInfo($order);
                $is_global_shipping_free = false;
                if($order->global_products && !$order->is_remote_post_code && $order->local_warehouse != 2 && !in_array($order->delivery['country_id'],[153,176])){
                    $is_global_shipping_free = true;
                }

                $data = array(
                    "address_book_id" => $_SESSION['billtoG'],
                    "status" => 200
                );
                $price_data = array(
                    "vat" => $vat,
                    "is_vax" => $order->is_vax,
                    "shipping_cost" => $shipping_price,
                    "insurance" => $insurance,
                    "total" => $total,
                    'subtotal' => $subtotal,
                    "origin_total" => $origin_total,
                    "is_shipping_free" => $is_shipping_free,
                    "origin_total_us" => $origin_total_us
                );

                $data['shipping_data'] = $shipping_data;
                $data['shipping_tag'] = [
                    'local' => $local_shipping_method,
                    "delay" => $delay_shipping_method,
                    "global"=> $global_shipping_method
                ];
                $data['product_info'] = $product_info;
                $data['is_global_shipping_free'] = $is_global_shipping_free;

                $tips = get_step_tips($order);
                $data['price_data'] = $price_data;
                $data['currency_left'] = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
                $data['currency_right'] = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
                $data['step3_tips'] = $tips;

                $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW;
                $c_id = $order->delivery['country_id'];
                if($product_info['order_num_info']['data'] == 'local'){
                    if(!in_array($c_id,['138','38','153']) && !other_eu_warehouse($c_id) && (!in_array($order->local_warehouse,[71,2]) || $c_id == 188)){
                        $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                    }
                }

                if(in_array($order->local_warehouse,[20,37]) && !other_eu_warehouse($c_id) && $c_id != 153 && !$order->is_local_buck){
                    if(in_array($product_info['order_num_info']['data'],['delay','local-delay'])){
                        $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                    }
                }

                $data['billing_address'] = $use_address;
                $data['warehouse'] = $order->local_warehouse;
                echo json_encode($data);
                break;

            case "add_guest_billing_address":
                $checkout = Checkout::getInstance();
                $shipping_address = Checkout::get_post_address_data();
                $validate = Checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
                }
                $customer_info = new customer_account_info();
                $address_id = $customer_info->add_guest_billing_address_new($shipping_address);
                if($address_id){
                    $use_address = $customer_info->get_customers_guest_billing_address();
                    $data['billing_address'] = $use_address;
                    $data['address_book_id'] = $address_id;
                    echo json_encode(array("status" => 200, "data" => $data));
                    exit;
                }else{
                    echo json_encode(array("status" => 204, "data" => FS_SYSTME_BUSY));
                    exit;
                }

                break;

            case 'async_billing_guest':
                $email = zen_db_prepare_input($_POST['email']);
                $billing_id = (int)$_POST['billing_id'];
                $re = $db->getAll("select customers_default_billing_address_id from customer_of_guest where email_address = '" . trim($email) . "' order by guest_id DESC limit 1");
                if (!$re[0]['customers_default_billing_address_id']) {
                    $customer_info = new customer_account_info();
                    $shipping_address = $customer_info->get_select_address($billing_id);

                    $address = array(
                        'address_type' => 2,
                        'entry_company' => $shipping_address['entry_company'],

                        'entry_firstname' => $shipping_address['entry_firstname'],

                        'entry_lastname' => $shipping_address['entry_lastname'],

                        'company_type' => $shipping_address['company_type'],

                        'entry_street_address' => $shipping_address['entry_street_address'],

                        'entry_suburb' => $shipping_address['entry_suburb'],

                        'entry_postcode' => $shipping_address['entry_postcode'],

                        'entry_state' => $shipping_address['entry_state'],

                        'entry_city' => $shipping_address['entry_city'],

                        'entry_country_id' => $shipping_address['entry_country']['entry_country_id'],

                        'entry_zone_id' => $shipping_address['entry_zone_id'],
                        'entry_tax_number' => $shipping_address['entry_tax_number'],
                        'entry_telephone' => $shipping_address['entry_telephone']
                    );
                    $_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address_new($address);
                    $use_address = $customer_info->get_customers_guest_billing_address();
                    $data = array(
                        "address_book_id" => $_SESSION['billtoG'],
                        "data" => $use_address,
                        "status" => 1
                    );
                    echo json_encode($data);
                } else {
                    echo json_encode(array("msg" => "exit", 'billing_id' => $address_id));
                }

                break;

            case 'set_create_account_new':


                $entry_firstname = ($_POST['entry_firstname']);

                $entry_lastname = ($_POST['entry_lastname']);

                $entry_company = ($_POST['entry_company']);

                $entry_street_address = ($_POST['entry_street_address']);

                $entry_suburb = ($_POST['entry_suburb']);

                $entry_city = ($_POST['entry_city']);

                $entry_country_id = ($_POST['entry_country_id']);

                $entry_state = ($_POST['entry_state']);

                $shipping_us_state = ($_POST['shipping_us_state']);

                $shipping_au_state = ($_POST['shipping_au_state']);

                $customers_country_id = $entry_country_id;

                if ($_POST['entry_country_id'] == 223 || $_POST['entry_country_id'] == 38) {

                    $entry_state = $shipping_us_state;

                }
                if ($_POST['entry_country_id'] == 13) {

                    $entry_state = $shipping_au_state;

                }
                $entry_postcode = ($_POST['entry_postcode']);

                $entry_telephone = ($_POST['entry_telephone']);

                $email_address = ($_POST['entry_email']);
                if (!empty($_POST['entry_email_regist'])) {
                    $email_address = $_POST['entry_email_regist'];
                }
                $password1 = ($_POST['password1']);
                $password2 = ($_POST['password2']);
                //RSA后台解密
                $password1 = zen_get_rsa_decrypt_password($password1);
                $password2 = zen_get_rsa_decrypt_password($password2);

                $email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
                $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
                //$user_ip_address =$_SERVER["REMOTE_ADDR"];
                $user_ip_address = getCustomersIP();

                $sendto = $_SESSION['sendto'] > 0 ? $_SESSION['sendto'] : $_SESSION['sendtoG'];
                $sql_data_array = array(
                    'customers_firstname' => zen_db_prepare_input($entry_firstname),
                    'customers_lastname' => zen_db_prepare_input($entry_lastname),
                    'customers_email_address' => $email_address,
                    'customers_telephone' => zen_db_prepare_input($entry_telephone),
                    'customers_newsletter' => 1,
                    'customers_email_format' => $email_format,
                    'customers_default_address_id' => 0,
                    'customers_password' => zen_encrypt_password($password1),
                    'customers_authorization' => ( int )CUSTOMERS_APPROVAL_AUTHORIZATION,
                    'language_id' => (int)$_SESSION['languages_id'],
                    'language_code'=>$_SESSION['languages_code'], // fairy 2019.2.22 add
                    'customer_country_id' => $entry_country_id,
                    'hear_us' => '',
                    'customers_default_address_id' => $sendto,
                    'customer_other_content' => '',
                    'http_user_agent' => $http_user_agent,
                    'user_ip_address' => $user_ip_address,
                    'customers_regist_from' => 'guest',
                    'email_is_active' => '1',   // fairy 2017.10.30 通过下单来的用户，默认为已激活
                    'customers_info_date_account_created' => date('Y-m-d H:i:s'),
                    'source' => 3,             //   客户来源，3表示游客下单注册
                    'from_where' => isMobile() ? 2 : 1,        // 客户来源
                    'is_old' => $is_old ? $is_old : 0,   // 标记新、老客户
                );


                if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
                    $error = true;
                    //$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_ERROR );
                    echo ENTRY_EMAIL_ADDRESS_ERROR;
                    exit;
                } else if (zen_validate_email($email_address) == false) {
                    $error = true;
                    //$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
                    echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
                    exit;
                } else {
                    $check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
							 where customers_email_address = '" . $email_address . "'";
                    $check_email = $db->Execute($check_email_query);
                    if ($check_email->fields['total'] > 0) {
                        $error = true;
                        $login_in = "   <a href='/login.html'>" . REGITS_FROM_GUEST_EXSIT2 . "</a>";
                        $html = REGITS_FROM_GUEST_EXSIT1 . $login_in;
                        echo $html;
                        exit;
                        //echo 'Our system already has a record of that email address - please try logging in with that email address,If you do not use that address any longer you can correct it in the My Account area.';exit;
                        //$messageStack->add_session ( FILENAME_REGIST,'<div id="fiberstore_message" class="tishi_02 display_none">Our system already has a record of that email address - please try logging in with that email address.<br /> If you do not use that address any longer you can correct it in the My Account area.</div>' );
                        $email_address = zen_db_prepare_input($email_address);
                        $password = zen_db_prepare_input($password1);


                        // Check if email exists
                        $check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
																										customers_email_address, customers_default_address_id,
																										customers_authorization, customers_referral
																							   FROM " . TABLE_CUSTOMERS . "
																							   WHERE customers_email_address = :emailAddress";

                        $check_customer_query = $db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
                        $check_customer = $db->Execute($check_customer_query);


                        if ($check_customer->RecordCount() < 1) {

                            exit(FS_LOGIN_EMAIL_ERROR);
                        } elseif ($check_customer->fields['customers_authorization'] == '4') {
                            exit(TEXT_LOGIN_BANNED);
                        } else {
                            // Check that password is good
                            if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
                                exit('Password input error');
                            } else {
                                if (SESSION_RECREATE == 'True') {
                                    zen_session_recreate();
                                }

                                $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
                                $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
                                $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
                                $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
                                $_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
                                $_SESSION['customers_email_address'] = $check_customer->fields['customers_email_address'];

                                // fairy 2017.10.30 下单之后，默认激活
                                $db->Execute("update customers set email_is_active = '1' where customers_id='" . (int)$_SESSION['customer_id'] . "'");

                                get_customers_member_level();

                                $LoginRember = zen_db_prepare_input($_POST['LoginRember']);

                                $_SESSION['name'] = $check_customer->fields['customers_firstname'] . ' ' . $check_customer->fields['customers_lastname'];

                                $last_address == '';
                                $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
																				  SET customers_info_date_of_last_logon = now(),
																				customers_info_address_of_last_logon = '" . $last_address . "',
																					  customers_info_number_of_logons = customers_info_number_of_logons+1
																				  WHERE customers_info_id = :customersID";

                                $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
                                $db->Execute($sql);


                                // fairy 添加登录信息
                                zen_insert_one_customers_login($_SESSION['customer_id'], 'ajax_process_other_requests/set_create_account_new/1');
                                // fairy 判断设备是否是异地登录
                                if ($last_customers_login_id && isOffsiteLogin($last_customers_login_id)) {
                                    $email_username = $check_customer->fields['customers_firstname'] . ' ' . $check_customer->fields['customers_lastname'];
                                    sendOffsiteLogin($check_customer->fields['customers_email_address'], $email_username);
                                    $sql = 'update customers_login set has_send_email = 1 where customers_login_id="' . $last_customers_login_id . '"';
                                    $db->Execute($sql);
                                }

                                $db->Execute("update address_book set customers_id = '" . $_SESSION['customer_id'] . "' where address_book_id='" . $_SESSION['sendto'] . "'");
                                $list = $db->getAll("select guest_id from customer_of_guest where email_address = '" . $email_address . "' order by guest_id DESC limit 1");
                                if ($list) {
                                    $db->Execute("update address_book set customers_id = '" . $_SESSION['customer_id'] . "' where customers_guest_id='" . $list[0]['guest_id'] . "'");
                                    $db->Execute("update orders set customers_id = '" . $_SESSION['customer_id'] . "' where guest_id='" . $list[0]['guest_id'] . "'");
                                }

                                if (SHOW_SHOPPING_CART_COMBINED > 0) {
                                    $zc_check_basket_before = $_SESSION['cart']->count_contents();
                                }

                                $_SESSION['cart']->restore_contents();

                            }

                        }


                    } else {
                        //$allot_type =  'visitor_order';
						require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
						if($admin_id){
                        //邮箱匹配到了 标记老客户 用于统计
                            $sql_data_array ['is_old'] = $is_old ? $is_old : 0;
						}

                        zen_db_perform(TABLE_CUSTOMERS, $sql_data_array);
                        $_SESSION['customer_id'] = $db->Insert_ID();
                        $cid = $db->insert_ID();
                        $db->Execute("update customer_of_guest set customers_id = '" . $_SESSION['customer_id'] . "' where guest_id='" . $_SESSION['customers_guest_id'] . "'");
                        if ($admin_id) {
                            $customers_id = $cid;
                            $date = get_common_cn_time();
                            $sql = 'INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("' . $admin_id . '","' . $customers_id . '","'.$date.'","'.time().'")';
                            $db->Execute($sql);
                            $sales_email = zen_admin_email_of_id($admin_id);
                            $html = zen_get_corresponding_languages_email_common();
                            $html_msg['EMAIL_HEADER'] = $html['html_header'];
                            $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                            $html_msg['CUSTOMER_NAME'] = $entry_firstname . $entry_lastname ? $entry_firstname . $entry_lastname : 'not set yet';
                            $html_msg['NUMBER'] = $telephone ? $telephone : 'not set yet';
                            $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                            zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', EMAIL_FROM, $html_msg, 'regist_to_us');

                        }
                        $db->Execute("update address_book set customers_id = '" . $_SESSION['customer_id'] . "' where address_book_id='" . $sendto . "'");
                        $list = $db->getAll("select guest_id from customer_of_guest where guest_id = '" . $_SESSION['customers_guest_id'] . "' order by guest_id DESC limit 1");
                        if ($list) {
                            $db->Execute("update address_book set customers_id = '" . $_SESSION['customer_id'] . "' where customers_guest_id='" . $list[0]['guest_id'] . "'");
                            $db->Execute("update orders set customers_id = '" . $_SESSION['customer_id'] . "' where guest_id='" . $list[0]['guest_id'] . "'");
                        }

                        require_once DIR_WS_CLASSES . 'set_cookie.php';
                        $Encryption = new Encryption;
                        $cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
                        //$cookie_customer_decrypt = $Encryption->_decrypt($cookie_customer_encrypt);
                        setcookie("fs_login_cookie", $cookie_customer_encrypt, time() + 86400 * 300, "/");

                        $_SESSION['cart']->restore_contents();

                        $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created, customers_info_date_of_last_logon)
								values ('" . ( int )$_SESSION['customer_id'] . "', '1', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "')";

                        $db->Execute($sql);


                        // fairy 添加登录信息
                        zen_insert_one_customers_login($_SESSION['customer_id'], 'ajax_process_other_requests/set_create_account_new/2');

                        if (SESSION_RECREATE == 'True') {
                            zen_session_recreate();
                        }

                        $_SESSION ['customer_first_name'] = $entry_firstname;
                        $_SESSION ['customer_default_address_id'] = $address_id;
                        $_SESSION ['customer_country_id'] = $country;
                        $_SESSION ['customer_zone_id'] = $zone_id;
                        $_SESSION ['customers_authorization'] = $customers_authorization;
                        $_SESSION ['name'] = $entry_firstname;

                        $_SESSION['customers_email_address'] = $email_address;

                        $html_msg = array();
                        $html = zen_get_corresponding_languages_email_common();
                        $html_msg['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                        $html_msg['EMAIL_BODY_COMMON_DEAR'] = EMAIL_BODY_COMMON_DEAR;
                        $html_msg ['EMAIL_FIRST_NAME'] = $entry_firstname;
                        $html_msg ['EMAIL_LAST_NAME'] = $entry_lastname;
                        $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT1'] = EMAIL_REGIST_TO_CUSTOMER_TEXT1;
                        $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT2'] = EMAIL_REGIST_TO_CUSTOMER_TEXT2;
                        $html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT3'] = EMAIL_REGIST_TO_CUSTOMER_TEXT3;

                        $email_text .= EMAIL_WELCOME;
                        $email_text .= ' Fiberstore ';


                        $email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;

                        $email_text .= "\n\n" . sprintf(EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS) . "\n\n";
                        // 		$html_msg ['EMAIL_DISCLAIMER'] = sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>' );
                        if (!defined('EMAIL_SUBJECT')) {
                            //define('EMAIL_SUBJECT', 'Congratulations, you have a new account on FiberStore.com');
                        }
                        // send welcome email
                        if (trim(EMAIL_SUBJECT) != 'n/a')
                            //zen_mail ( $customer_name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );
                            $send_to_email = 'support@fiberstore.com';
                        zen_mail_contact_us_or_bulk_order_inquiry($customer_name, $email_address, EMAIL_REGIST_TO_CUSTOMER_SUBJECT, $email_text, STORE_NAME, $send_to_email, $html_msg, 'regist_to_customer');

                        $_SESSION['regist_success'] = rand(0, 1000);


                    }
                }
                exit('ok'.$_SESSION['securityToken']);
                break;
            case 'transfer_ns_data':
                //更新ns数据
                update_backstage_company_data($_SESSION['customer_id']);
                break;
            case 'delete_ru_payment_address':
                $id = zen_db_prepare_input($_POST['alfa_id']);
                if (empty($id)) {
                    echo json_encode(['status' => 400, 'message' => FS_SYSTME_BUSY]);
                    die();
                }
                $service = new \App\Services\Payments\RuPaymentServices();
                $res = $service->setInformationAddress()->deletePaymentInformation($id);
                if ($res['status'] == 400) {
                    echo json_encode(['status' => 400, 'message' => FS_SYSTME_BUSY]);
                } else {
                    echo json_encode($res);
                }
                die();
                break;
        }
    }

} else {
    if (isset($_GET['region']) && $_GET['region'] == "checkout") {
        if (empty($_SESSION['customer_id'])) {
            echo json_encode(array("status" => 401));
        }
    }
}
