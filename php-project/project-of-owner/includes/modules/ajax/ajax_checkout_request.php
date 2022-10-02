<?php

use App\Services\Common\ApiResponse;
use App\Services\Address\AddressBookService;
use App\Services\Customers\CustomerService;
use App\Services\taxExemption\TaxExemptionService;
use App\Services\Country\CountryService;
use App\Services\Payments\RuPaymentServices;
use App\Services\Quote\QuoteService;
use App\Services\Email\QuotesEmailService;

$api = new ApiResponse();
$ads_s = new AddressBookService();
$customers_s = new CustomerService();
$country_s = new CountryService();
$tax_exemption = new TaxExemptionService();
//俄罗斯对公支付验证
$ru_service = new RuPaymentServices();
$quotes_s = new QuoteService();
$return = array('status' => '', 'data' => '', 'message' => '');
$action = $_GET['ajax_request_action'];
$customers_id = (int)$_SESSION['customer_id'];

/**
 * status
 * 402 客户未登录
 * 403 禁止服务器拒绝请求。
 * 200 – OK – 一切正常
 * 401（身份验证错误） 此页要求授权
 * 204（无内容）  服务器成功处理了请求，但未返回任何内容。z
 * 406（数据验证错误） 无法使用请求的内容特性响应请求的网页。
 */

//客户登录判断
if (!isset($_SESSION['customer_id']) || empty($_SESSION['customer_id'])) {
    $api->setStatus(402)->response();
}

//授权验证
if (!isset($_POST['securityToken']) || $_SESSION['securityToken'] != $_POST['securityToken']) {
    $api->setStatus(403)->setMessage('For security reason, please re-load the page to continue.')->response();
}

$customer = $customers_s->setCustomer()->currentCustomer;
////客户权限验证
if ($_SESSION['customer_id']) {
    if ($customer->customers_authorization == 4) {
        $api->setStatus(401)->setMessage('error')->response();
    }
}

if (!isset($action) || empty($action)) {
    $api->setStatus(406)->setMessage('error')->response();
}


require_once(DIR_WS_CLASSES . 'payment.php');
require_once DIR_WS_CLASSES . 'class.checkout.php';
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/checkout_common.php'); // 调用公共的语言包

/**此处发现一个bug，传参过来的字符串中自身带了&符号的话，再通过&切割字符串转化为数组的时候，会导致数据丢失 Bona.guo 2020/12/1 9:45
 *临时解决方法，传参过来前在js中将 & 正则替换成 **amp** ，再在此处还原成 &
 */
$_POST['ticker_number_mgb'] && $_POST['ticker_number_mgb'] = str_replace('**amp**', '&', $_POST['ticker_number_mgb']);
$_POST['delivery_other_mgb'] && $_POST['delivery_other_mgb'] = str_replace('**amp**', '&', $_POST['delivery_other_mgb']);
$_POST['remarks_local'] && $_POST['remarks_local'] = str_replace('**amp**', '&', $_POST['remarks_local']);

if (in_array($action, ['delete_address', 'add_customer_address', 'edit_shipping_address', 'edit_billing_address', 'confirm_shipping_address', 'confirm_billing_address', 'save_customer_po', 'create_order'])) {
    $checkout = Checkout::getInstance([
        "validate_format" => "php",
        "main_page" => "checkout",
        "state_format" => "php"
    ]);
}
//新旧的报价id参数
$inquiry_id = $_POST['inquiry_id'] ? $_POST['inquiry_id'] : "";
$quotes_id = $_POST['quotes_id'] ? $_POST['quotes_id'] : "";


switch ($action) {

    case "post_match_state":
        $zip_code = zen_db_prepare_input($_POST['zip_code']);
        $country_id = (int)zen_db_prepare_input($_POST['country_id']);
        $city = "";
        $state = "";
        if (empty($zip_code)) {
            $api->setStatus(406)->setMessage('error')->response();
        }
        switch ($country_id) {
            case 223:
                $res = $ads_s->isValidZipCode(223, $zip_code);
                $data = $res['data'];
                $city = !empty($data) ? $data->city : "";
                $state = !empty($data) ? $data->states : "";
                break;
            case 222:
                $res = checkNorthIrelandPostcode($zip_code, $country_id);
                if(!$res){
                    $api->setStatus(406)->setMessage('error')->response();
                }
                break;
        }
        $info = array(
            "state" => $state,
            "city" => $city
        );
        $api->setStatus(200)->response($info);
    case 'delete_address':
        $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
        if (!$address_book_id) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }

        $is_delete = $ads_s->deleteAddressBook($address_book_id);
        if($address_book_id == $_SESSION['sendto']){
            unset($_SESSION['sendto']);
        }
        if($address_book_id == $_SESSION['billto']){
            unset($_SESSION['billto']);
        }
        $all_address = $ads_s->getAddressBook();
        $data['shipping_address'] = !empty($all_address['shipping']) ? array_values($all_address['shipping']) : [];
        $data['billing_address'] = !empty($all_address['billing']) ? array_values($all_address["billing"]) : [];
        $data['address_book_id'] = $address_book_id;
        if ($is_delete) {
            $api->setStatus(200)->response($data);
        } else {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }

        break;
    case "add_customer_address":
        $post_shipping_address = $shipping_address = $checkout::get_post_address_data();
        $checkout::$address = $shipping_address;
        $address_type = (int)$_POST['editType']; //新增地址类型
        $isUseShipping = (int)$_POST['isUseShipping'];
        $vat_check = true;
        $customer_num = $customer->customers_number_new;

        if ($_SESSION['sendto'] && $address_type == 2) {
            $frees = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $order->delivery['country']['title']);
            if ($frees) {
                $billing_country_name = $country_s->getCountryNameById($shipping_address['entry_country_id']);
                $BName = $billing_country_name['countries_name'];
                $vat = strtolower($shipping_address['entry_tax_number']);
                foreach ($frees as $free_val) {
                    if (strtolower($free_val->vat_number) == $vat && strtolower($free_val->billing_country) == $BName) {
                        $vat_check = false;
                        break;
                    }
                }
            }
        }

        $validate = $checkout::validate($shipping_address, $vat_check);
        if (!empty($validate)) {
            $api->setStatus(422)->response($validate);
        }
        //验证地址
        $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, $address_book_id,
            'add', false);
        if ($avaTaxResult['avaTaxError']) {
            $api->setStatus(405)->response($avaTaxResult['avaTaxError']);
        }
        $is_avaTaxCheck = $_SESSION['useUpsDefaultAddress'] == 1 ? false : true;
        $address_book_id = $checkout::addCustomersAddress($is_avaTaxCheck);
        if ($address_book_id) {
            $all_address = $ads_s->getAddressBook();
            $data['shipping_address'] = !empty($all_address['shipping']) ? array_values($all_address['shipping']) : [];
            $data['billing_address'] = !empty($all_address['billing']) ? array_values($all_address["billing"]) : [];
            $data['address_book_id'] = $address_book_id;
            if ($address_type == 0) {
                $_SESSION['sendto'] = $address_book_id;
                if ($isUseShipping == 1) {
                    $_SESSION['billto'] = $_SESSION['sendto'];
                }

                switch (true)
                {
                    case (int)$quotes_id > 0:
                        $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                        if (empty($cart_products)) {
                            $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                        }
                        $order = new order("", $cart_products);
                        break;
                    case (int)$inquiry_id > 0:
                        require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                        $inquiry = new inquiry($currencies);
                        $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                        if($cart_products==false){
                            echo '{"error":"err","status":200}';
                            exit;
                        }
                        $order = new order("",$cart_products);
                        break;
                    default:
                        $order = new order();
                        break;
                }

                $shipping_data = getAllShippingData();
                $checkout::setShippingCost($shipping_data);
                $avaTaxResult = $checkout::avaTaxHandle($order, $post_shipping_address, $address_book_id, 'calculateVax');
                if ($avaTaxResult['avaTaxError']) {
                    $return_data = array('error' => $avaTaxResult['avaTaxError'], 'code' => $avaTaxResult['code']);
                    $api->setStatus(408)->setMessage('error')->response($return_data);
                }
                $order->resetOrderTotalInfo();
                $data['info'] = $checkout::handlerShippingAddress($address_book_id, '', '', '', $order, $shipping_data);
                $data['info']['taxFreeAdmin'] = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $data['info']['delivery_country']);
            }
            if (isset($_SESSION['checkout_default_ads'])) {
                unset($_SESSION['checkout_default_ads']);
            }
            $api->setStatus(200)->response($data);
        } else {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }
        break;
    case "edit_shipping_address":

        $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
        if (!$address_book_id) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }
        $customer_num = $customer->customers_number_new;
        $isUseShippingAddressAsBilling = (int)$_POST['isUseShippingAddressAsBilling'];
        $post_shipping_address = $shipping_address = $checkout::get_post_address_data();
        $checkout::$address = $shipping_address;
        $validate = $checkout::validate($shipping_address);
        if (!empty($validate)) {
            $api->setStatus(422)->setMessage('invalid filed')->response($validate);
        }
        $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, $address_book_id, 'update', false);
        if ($avaTaxResult['avaTaxError']) {
            $api->setStatus(405)->response($avaTaxResult['avaTaxError']);
        }
        $ads_s->updateAddress($shipping_address, $address_book_id);
        $all_address = $ads_s->getAddressBook();
        $data['shipping_address'] = !empty($all_address['shipping']) ? array_values($all_address['shipping']) : [];
        $data['billing_address'] = !empty($all_address['billing']) ? array_values($all_address["billing"]) : [];
        $data['address_book_id'] = $address_book_id;
        if (!empty($validate)) {
            $api->setStatus(422)->response($validate);
        }

        $_SESSION['sendto'] = $address_book_id;
        if ($isUseShippingAddressAsBilling) {
            $_SESSION['billto'] = $_SESSION['sendto'];
        }

        switch (true)
        {
            case (int)$quotes_id > 0:
                $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                if (empty($cart_products)) {
                    $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                }
                $order = new order("", $cart_products);
                break;
            case (int)$inquiry_id > 0:
                require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                $inquiry = new inquiry($currencies);
                $cart_products =  $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                if($cart_products==false){
                    return array("error" => FS_INQUIRY_INFO_66);
                }
                $order = new order("",$cart_products);
                break;
            default:
                $order = new order();
                break;
        }

        $shipping_data = getAllShippingData();
        $checkout::setShippingCost($shipping_data);
        $avaTaxResult = $checkout::avaTaxHandle($order, $post_shipping_address, $address_book_id, 'calculateVax', true);
        if ($avaTaxResult['avaTaxError']) {
            $api->setStatus(408)->setMessage($avaTaxResult['avaTaxError']['message'])->response($avaTaxResult['code']);
        }
        $order->resetOrderTotalInfo();
        $data['info'] = $checkout::handlerShippingAddress($address_book_id, '', '', '', $order, $shipping_data);
        if ($data['info']['avaTaxError']) {
            $api->setStatus(405)->response($data['info']['avaTaxError']);
        }
        $data['info']['taxFreeAdmin'] = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $data['info']['delivery_country']);
        if (isset($_SESSION['checkout_default_ads'])) {
            unset($_SESSION['checkout_default_ads']);
        }
        //清除购物车中国大陆限制提示语
        if($order->delivery['country_id'] != 44){
            setcookie('cn_limit_products', json_encode($order->cn_limit_products), time() - 100, '/');
        }
        $api->setStatus(200)->response($data);
    case "edit_billing_address":

        $address_book_id = (int)zen_db_prepare_input($_POST['address_book_id']);
        $update_type = zen_db_prepare_input($_POST['update_type']);
        if (!$address_book_id) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }

        $shipping_address = $checkout::get_post_address_data();
        $checkout::$address = $shipping_address;
        $vat_check = true;

        if ($_SESSION['sendto']) {
            $customer_num = $customer->customers_number_new;
            $order = new order();
            $frees = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $order->delivery['country']['title']);
            if ($frees) {
                $billing_country_name = $country_s->getCountryNameById($shipping_address['entry_country_id']);
                $BName = $billing_country_name['countries_name'];
                $vat = strtolower($shipping_address['entry_tax_number']);
                foreach ($frees as $free) {
                    if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName) {
                        $vat_check = false;
                        break;
                    }
                }
            }
        }
        $validate = $checkout::validate($shipping_address, $vat_check);
        if (!empty($validate)) {
            $api->setStatus(422)->response($validate);
        }
        $ads_s->updateAddress($shipping_address, $address_book_id);

        $shipping_address = $checkout::get_customers_address(1);
        $billing_address = $checkout::get_customers_address(2);

        $data['shipping_address'] = $shipping_address;
        $data['billing_address'] = $billing_address;
        $data['address_book_id'] = $address_book_id;
        $api->setStatus(200)->response($data);
        break;
    case 'confirm_shipping_address':
        $address_book_id = (int)$_POST["address_book_id"];
        $isUseShippingAddressAsBilling = (int)$_POST['isUseShippingAddressAsBilling'];
        $initType = (int)$_POST['initType'];
        if (!$address_book_id) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }

        $data['address_book_id'] = $address_book_id;
        //2019.1.18，fairy，修改，po地址不需要验证。因为po地址不能修改，即使验证不通过，用户也不能操作
        $error_param = [];
        if ($_POST['error_type']) {
            $error_param['error_type'] = $_POST['error_type'];
        }

        $_SESSION['sendto'] = $address_book_id;
        if ($isUseShippingAddressAsBilling) {
            $_SESSION['billto'] = $address_book_id;
        }

        switch (true)
        {
            case (int)$quotes_id > 0:
                $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                if (empty($cart_products)) {
                    $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                }
                $order = new order("", $cart_products);
                break;
            case (int)$inquiry_id > 0:
                require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                $inquiry = new inquiry($currencies);
                $cart_products =  $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                if($cart_products==false){
                    return array("error" => FS_INQUIRY_INFO_66);
                }
                $order = new order("",$cart_products);
                break;
            default:
                $order = new order();
                break;
        }
        //初始化设置 同步quote 运费
        $initQuote =  $initType == 7 && $quotes_id ? $quotes_s->quoteInfo : [];
        //重置运费
        $shipping_data = getAllShippingData();
        $checkout::setShippingCost($shipping_data, $initQuote);
        $shipping_address = $checkout::getShippingAddress($order);

        //英文站港澳台国家地址栏不能包含中文字符判断
        if (!empty($shipping_address) && in_array($_SESSION['languages_id'], array(1, 9, 10, 13))) {
            if ($order->chineseAddressDetermination($shipping_address['entry_country_id'], $shipping_address['entry_street_address'] . $shipping_address['entry_suburb']) == true) {
                $api->setStatus(406)->setMessage(FS_ADDRESSES_REGULAR_1)->response();
            }
        }
        //验证税收地址,生成税收
        $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, $address_book_id, 'confirm');
        if ($avaTaxResult['avaTaxError'] && $avaTaxResult['type'] == 1) {
            $api->setStatus(405)->response($avaTaxResult['avaTaxError']);
        }
        if ($avaTaxResult['avaTaxError'] && $avaTaxResult['type'] == 2) {
            $message = $avaTaxResult['avaTaxError']['message'] ? $avaTaxResult['avaTaxError']['message'] : FS_SYSTME_BUSY;
            $api->setStatus(408)->setMessage($message)->response($avaTaxResult['code']);
        }

        //重置订单价格
        $order->resetOrderTotalInfo();
        $data['info'] = $checkout::handlerShippingAddress($address_book_id, true, '', $error_param, $order, $shipping_data);
        $is_bill_company = false;
        if ($order->billing['company_type'] == 'BusinessType' &&
            (!german_warehouse('country_number', $order->billing['country_id']) ||
                $order->billing['country_id'] == 81)) {
            $is_bill_company = true;
        }
        if ($order->delivery['country_id'] == 21 && $order->billing['country_id'] == 223 &&
            $order->billing['company_type'] != 'BusinessType') {
            $is_bill_company = false;
        }
        $is_uk_business_address = false;
        if($order->billing['company_type'] == 'BusinessType' &&
            in_array($order->billing['country']['id'],[222,244]) && $order->delivery['country_id'] !=81) {
            $is_uk_business_address = true;
        }
        $data['info']['price_data']['vat_title'] = get_checkout_vat_title($order->delivery['country']['iso_code_2'], 2,  $is_bill_company,false, $is_uk_business_address);
        if ($data['info']['error']) {
            $api->setStatus(422)->response($data['info']['error']);
        }
        $data['info']['taxFreeAdmin'] = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $data['info']['delivery_country']);
        if (isset($_SESSION['checkout_default_ads'])) {
            unset($_SESSION['checkout_default_ads']);
        }
        //清除购物车中国大陆限制提示语
        if($order->delivery['country_id'] != 44){
            setcookie('cn_limit_products', json_encode($order->cn_limit_products), time() - 100, '/');
        }
        $data['info']['is_au_gsp'] = $order->delivery['country_id'] == 13 ? 1 : 0;
        $api->setStatus(200)->response($data);
        break;
    case 'confirm_billing_address':
        $customer_info = new customer_account_info();
        $current_shipping_id = $_SESSION['sendto'];
        $current_billing_id = $_SESSION['billto'];
        if($current_shipping_id){
            $shipping_address = $customer_info->get_select_address($current_shipping_id);
        }
        $shipping_address_id = $current_shipping_id;
        $billing_address_id = (int)zen_db_prepare_input($_POST['billing_address_id']);
        $is_global_shipping_free = false;
        $is_use = (int)$_POST['isUseShippingAddressAsBilling'];
        if ($is_use == 1) {
            if (empty($shipping_address_id)) {
                $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            }
            $shipping_address = $customer_info->get_select_address($shipping_address_id);
            if (empty($shipping_address)) {
                $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            }
            //验证运输地址
            $validate = $checkout::validate($shipping_address);
            if (!empty($validate)) {
                $api->setStatus(407)->setMessage(FS_SYSTME_BUSY)->response();
            }

            $_SESSION['billto'] = $shipping_address_id;

        } else {
            if (empty($billing_address_id)) {
                $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            }
            $current_billing_address = $customer_info->get_select_address($billing_address_id);
            if($shipping_address_id){
                $shipping_address = $customer_info->get_select_address($shipping_address_id);
            }

            $current_address = array(
                'address_type' => 2,
                'entry_company' => $current_billing_address['entry_company'],
                'entry_firstname' => $current_billing_address['entry_firstname'],
                'entry_lastname' => $current_billing_address['entry_lastname'],
                'company_type' => $current_billing_address['company_type'],
                'entry_street_address' => $current_billing_address['entry_street_address'],
                'entry_suburb' => $current_billing_address['entry_suburb'],
                'entry_postcode' => $current_billing_address['entry_postcode'],
                'entry_state' => $current_billing_address['entry_state'],
                'entry_city' => $current_billing_address['entry_city'],
                'entry_country_id' => $current_billing_address['entry_country']['entry_country_id'],
                'entry_zone_id' => $current_billing_address['entry_zone_id'],
                'entry_telephone' => $current_billing_address['entry_telephone'],
                'entry_tax_number' => $current_billing_address['entry_tax_number']
            );
//            echo '<pre>';
//            print_r($current_address);die;

            //新加坡添加字段 jay
            isset($current_billing_address['ticket_number']) && $current_address['ticket_number'] = $current_billing_address['ticket_number'];
            $vat_check = true;

            $customers_id = (int)$_SESSION['customer_id'] ?: 0;
            if ($customers_id && $current_shipping_id) {
                $customer_num = $customer->customers_number_new;
                $frees = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $order->delivery['country']['title']);
                if ($frees) {
                    $billing_country_name = $country_s->getCountryNameById($shipping_address['entry_country_id']);
                    $BName = $billing_country_name['countries_name'];
                    $vat = strtolower($shipping_address['entry_tax_number']);
                    foreach ($frees as $free) {
                        if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName) {
                            $vat_check = false;
                            break;
                        }
                    }
                }
            }
            //验证
            $is_valid = $checkout::validate($current_address, $vat_check);
            if (!empty($is_valid)) {
                $country_id = $current_address['entry_country_id'];
                $msg = FS_VAT_ERROR;
                $data = [];
                if (!empty($is_valid['entry_postcode']['zip_valid'])) {
                    //邮编
                    if ($country_id == 223) { //美国
                        $msg = FS_ZIP_VALID_1;
                    } elseif ($country_id == 129) { //马来西亚
                        $msg = FS_ZIP_VALID_2;
                    } else {
                        $msg = $is_valid['entry_postcode']['zip_valid'];
                    }
                } elseif (!empty($is_valid['entry_tax_number']['remote_validate_tax_number'])) {
                    //税号
                    $data = $current_address['entry_tax_number'];

                    $return_data = array(
                        'tax' => $data,
                        'country_id' => $country_id,
                        'erro' => $is_valid['entry_tax_number']['remote_validate_tax_number']
                    );
                    $api->setStatus(422)->setMessage($return_data['erro'])->response($return_data);
                } else {
                    $msg = FS_BILLING_ADDRESS_ERROR;
                }
                $api->setStatus(422)->setMessage($msg)->response();
            }

            $_SESSION['billto'] = $billing_address_id;
        }

        if ($current_shipping_id) {

            switch (true) {
                case (int)$quotes_id > 0:
                    $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                    if (empty($cart_products)) {
                        $_SESSION['billto'] = $current_billing_id;
                        $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                    }
                    $order = new order('', $cart_products);
                    break;
                case (int)$inquiry_id > 0:
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_POST['inquiry_id']);
                    if ($cart_products == false) {
                        echo '{"error":"err","status":200}';
                        exit;
                    }
                    $order = new order('', $cart_products);
                    break;
                default:
                    $order = new order();
                    break;
            }

            $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, $shipping_address_id,
                'confirm', false);
            if ($avaTaxResult['avaTaxError']) {
                //重置billto
                $_SESSION['billto'] = $current_billing_id;
                $api->setStatus(405)->response($avaTaxResult['avaTaxError']);
            }
            $current_free_info = $order->get_free_shipping_money();
            $outPutTextPre = $current_free_info['outPutTextPre'];
            //估算税收
            $shipping_data = getAllShippingData();
            $checkout::setShippingCost($shipping_data);
            $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, $shipping_address_id, 'calculateVax');
            if ($avaTaxResult['avaTaxError']) {
                $_SESSION['billto'] = $current_billing_id;
                $api->setStatus(408)->setMessage($avaTaxResult['avaTaxError']['message'])->response($avaTaxResult['code']);
            }
            $order->resetBill();
            $order->resetOrderTotalInfo();
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
            $total_text = $symbol.$total.$symbol_right;

            $subtotal = $currencies->fs_format_number($order_info['subtotal']);
            $subtotal_text = $symbol.$subtotal.$symbol_right;

            $vat = $currencies->fs_format_number($order_info['vat']);
            $vat_text = $symbol.$vat.$symbol_right;

            $insurance = $currencies->fs_format_number($order_info['insurance']);
            $insurance_text = $symbol.$insurance.$symbol_right;

            $warehouse = $order->local_warehouse;
            $total_before_tax = $currencies->fs_format_number($order_info['subtotal'] + $order_info['shipping']);

            //税后价
            $order_info_tax = $order->getAfterTaxCurrentOrderInfo();
            $subtotal_tax = $currencies->fs_format_number($order_info_tax['aftertax_subtotal']);
            $shipping_price_tax = $symbol . $currencies->fs_format_number($order_info_tax['aftertax_shipping']) . $symbol_right;

            $is_shipping_free = false;
            if ($order_info['shipping'] == 0) {
                $is_shipping_free = true;
                if ($order->handleFreeShippingPrice($local_shipping_method, $delay_shipping_method)) {
                    $shipping_price = FIBER_CHECK_FREE;
                }
                $shipping_price_tax = FIBER_CHECK_FREE;
            }

            $is_bill_company = false;
            if ($order->billing['company_type'] == 'BusinessType' &&
                (!german_warehouse('country_number', $order->billing['country_id']) || $order->billing['country_id'] == 81)) {
                $is_bill_company = true;
            }
            if ($order->delivery['country_id'] == 21 && $order->billing['country_id'] == 223 && $order->billing['company_type'] != 'BusinessType') {
                $is_bill_company = false;
            }
            $is_uk_business_address = false;
            if($order->billing['company_type'] == 'BusinessType' &&
                in_array($order->billing['country']['id'],[222,244]) && $order->delivery['country_id'] !=81) {
                $is_uk_business_address = true;
            }
            $total_before_tax = $currencies->fs_format_number($order_info['subtotal'] + $order_info['shipping']);
            $total_before_tax_text = $symbol.$total_before_tax.$symbol_right;
            $price_data = array(
                "is_vax" => $order->is_vax,
                "shipping_cost" => $shipping_price,
                "origin_total" => $origin_total,
                "is_shipping_free" => $is_shipping_free,
                "origin_total_us" => $origin_total_us,
                "shipping_cost_tax" => $shipping_price_tax,
                "total_before_tax" => $total_before_tax,
                'subtotal_tax' => $subtotal_tax,
                "vat_title" => get_checkout_vat_title($order->delivery['country']['iso_code_2'],
                    2, $is_bill_company, false, $is_uk_business_address),

                //产品价格信息
                'shipping' => $order_info['shipping'],
                'total' => $order_info['total'],
                'vat' => $order_info['vat'],
                'subtotal' => $order_info['subtotal'],
                'insurance' => $order_info['insurance'],
                'shipping_text' =>  $shipping_price,
                'total_text' => $total_text,
                'vat_text' => $vat_text,
                'subtotal_text' => $subtotal_text,
                'insurance_text' => $insurance_text,
                'after_sub_total_text' => $symbol.$subtotal_tax.$symbol_right,
                'after_shipping_text' => $shipping_price_tax,
                'total_before_tax_text' => $total_before_tax_text
            );

            $data['product_info'] = $product_info;
            $data['shipping_data'] = $shipping_data;
            $data['shipping_tag'] = [
                'local' => $local_shipping_method,
                "delay" => $delay_shipping_method,
                "global" => $global_shipping_method
            ];
            $data['warehouse'] = $order->local_warehouse;
            $data['price_data'] = $price_data;
            $data['outPutTextPre'] = $outPutTextPre;

            $data['is_global_shipping_free'] = $is_global_shipping_free;
            $data['cartCount'] = $_SESSION['cart']->count_contents(true);
            $data['phone'] = fs_new_get_phone($order->delivery['country']['iso_code_2']);
            $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW;
            $c_id = $order->delivery['country_id'];
            if ($product_info['order_num_info']['data'] == 'local') {
                if (!in_array($c_id, ['138', '38', '153']) && !other_eu_warehouse($c_id) && (!in_array($order->local_warehouse, [71, 2]) || $c_id == 188)) {
                    $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                }
            }
            if (in_array($order->local_warehouse, [20, 37]) && !other_eu_warehouse($c_id) && $c_id != 153 && !$order->is_local_buck) {
                if (in_array($product_info['order_num_info']['data'], ['delay', 'local-delay'])) {
                    $data['blind_msg'] = FS_CHECKOUT_NEW17_NEW_BLIND;
                }
            }
        }
        $customers_s->updateCustomerInfo(['customers_default_billing_address_id' => $billing_address_id]);


        $data['address_book_id'] = $is_use ? $current_shipping_id : $_SESSION['billto'];


        $data['currency_left'] = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        $data['currency_right'] = $currencies->currencies[$_SESSION['currency']]['symbol_right'];

        $api->setStatus(200)->response($data);
        break;
    case "saveCash":
        $ru_service->setInformationAddress();
        $cashType = (int)$_POST['cashType'];
        $actionType = (int)$_POST['actionType'];
        if ($cashType === 1) {
            $alfa_data = Checkout::alfa_account_validate();
            if ($alfa_data['status'] == 403) {
                $api->setStatus($alfa_data['status'])->setMessage($alfa_data['data'])->response();
            }
            $insertData = [
                'alfa_phone' => zen_db_prepare_input($_POST['alfa_phone']),
                'alfa_email' => zen_db_prepare_input($_POST['alfa_email']),
                'alfa_organization' => zen_db_prepare_input($_POST['alfa_organization']),
                'alfa_inn' => zen_db_prepare_input($_POST['alfa_inn']),
                'alfa_kpp' => zen_db_prepare_input($_POST['alfa_kpp']),
                'alfa_bic' => zen_db_prepare_input($_POST['alfa_bic']),
                'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_legal_address']),
                'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_bank_name']),
                'card_path' => $_POST['card_path'],
                'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
            ];
            $temp = $ru_service->createRuOrderInfo($insertData);
            $resData = $ru_service->allPaymentInformation(false);
            $api->setStatus(200)->response($resData);
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
                    $api->setStatus($data['status'])->setMessage($data['message'])->response();
                }

                $path = $ru_service->uploadCard($config, 'paymentUploadFile');
                if (empty($path)) {
                    $api->setStatus(406)->setMessage(FS_CHECKOUT_RU_FILE_TIPS_2)->response();
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
                $ru_service->createRuOrderInfo($insertData);
                $resData = $ru_service->allPaymentInformation(false);
                $api->setStatus(200)->response($resData);
            } else {
                if (!empty(zen_db_prepare_input($_POST['card_path']))) {
                    $insertData = [
                        'alfa_phone' => zen_db_prepare_input($_POST['alfa_account_phone']),
                        'alfa_email' => zen_db_prepare_input($_POST['alfa_account_email']),
                        'alfa_organization' => zen_db_prepare_input($_POST['alfa_account_organization']),
                        'alfa_inn' => zen_db_prepare_input($_POST['alfa_account_inn']),
                        'alfa_kpp' => zen_db_prepare_input($_POST['alfa_account_kpp']),
                        'alfa_bic' => zen_db_prepare_input($_POST['alfa_account_bic']),
                        'alfa_legal_address' => zen_db_prepare_input($_POST['alfa_account_legal']),
                        'alfa_bank_name' => zen_db_prepare_input($_POST['alfa_account_bank']),
                        'card_path' => $_POST['card_path'],
                        'primaryKeyId' => zen_db_prepare_input($_POST['primaryKeyId']),
                    ];
                    $ru_service->createRuOrderInfo($insertData);
                    $resData = $ru_service->allPaymentInformation(false);
                    $api->setStatus(200)->response($resData);
                } else {
                    $api->setStatus(406)->setMessage(FS_CHECKOUT_RU_FILE_TIPS_2)->response();
                }
            }
        }
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
                $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            }
        }
        if ($payment_method == "alfa") {
            $ru_service->setInformationAddress();
            if ('no' == zen_db_prepare_input($_POST['fileExists'])) {
                $alfa_data = Checkout::alfa_account_validate();
                if ($alfa_data['status'] == 403) {
                    $api->setStatus($alfa_data['status'])->setMessage($alfa_data['data'])->response();
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
                $temp = $ru_service->createRuOrderInfo($insertData);
                $resData = $ru_service->encodeData($temp);
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
                        $api->setStatus($data['status'])->setMessage($data['message'])->response();
                    }

                    $path = $ru_service->uploadCard($config, 'paymentUploadFile');
                    if (empty($path)) {
                        $api->setStatus(406)->setMessage(FS_CHECKOUT_RU_FILE_TIPS_2)->response();
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
                    $ru_service->createRuOrderInfo($insertData);
                    $resData = $ru_service->lastPaymentInformation();
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
                        $ru_service->createRuOrderInfo($insertData);
                        $resData = $ru_service->lastPaymentInformation();
                        $_SESSION['payment'] = $payment_method;
                        $api->setStatus(200)->response($resData);
                    } else {
                        $api->setStatus(406)->setMessage(FS_CHECKOUT_RU_FILE_TIPS_2)->response();
                    }
                }
            }
        }
        if (!zen_not_null($payment_method)) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }

        $_SESSION['payment'] = $payment_method;
        $api->setStatus(200)->response($resData);
        break;
    case "change_shipping":
        require_once(DIR_WS_CLASSES . 'order.php');
        require_once(DIR_WS_CLASSES . 'shipping.php');

        switch (true) {
            case (int)$quotes_id > 0:
                $check_quotes = $quotes_s->getCheckQuotesCustomers((int)$quotes_id);
                if (!$check_quotes) {
                    $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                }
                $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                $order = new order('', $cart_products);
                break;
            case (int)$inquiry_id > 0:
                require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                $inquiry = new inquiry($currencies);
                $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$_POST['inquiry_id']);
                if ($cart_products == false) {
                    echo '{"error":"err","status":200}';
                    exit;
                }
                $order = new order('', $cart_products);
                break;
            default:
                $order = new order();
                break;
        }

        $customer_info = new customer_account_info();
        $delay_content = array();
        $local_sub_text = $currencies->total_format_new($order->local_info['subtotal'], true, $order->info['currency'], $order->info['currency_value']);
        $shipping_method = zen_db_prepare_input($_POST['shipping_method']);
        $shipping_type = zen_db_prepare_input($_POST['shipping_type']);

        $shipping_data = getAllShippingData();
        $shipping_cost = $shipping_data[$shipping_type];
        if (sizeof($shipping_cost)) {
            foreach ($shipping_cost as $v) {
                if ($v['methods'] == $shipping_method) {
                    $_SESSION['shipping_' . $shipping_type] = array('id' => $v['methods'] . '_' . $v['methods'],

                        'title' => $v['title'],

                        'cost' => $v['s_price'],

                        'origin_price' => $v['origin_price'],
                    );
                }
            }
        }
        $shipping_arr = ["local", "delay", "global", 'gift'];
        $shipping_address = $customer_info->get_select_address($_SESSION['sendto']);
        $checkout = Checkout::getInstance();
        $is_shipping_free = false;
        $symbol = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
        $symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
        $vat = $currencies->fs_format_new($order->vat, true, $order->info['currency'], $order->info['currency_value']);
        $sub_total = $currencies->total_value($order->info['subtotal']);
        $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
        $origin_shipping_cost = 0;
        foreach ($shipping_arr as $kk) {
            if ($_SESSION['shipping_' . $kk]) {
                $origin_shipping_cost += $_SESSION['shipping_' . $kk]['origin_price'];
            } else {
                unset($_SESSION['shipping_' . $kk]);
            }
        }

        $avaTaxResult = $checkout::avaTaxHandle($order, $shipping_address, '', 'calculateVax', true);
        if ($avaTaxResult['avaTaxError']) {
            $api->setStatus(408)->setMessage($avaTaxResult['avaTaxError']['message'])->response($avaTaxResult['code']);
        }
        $order->resetOrderTotalInfo();
        $order_info = $order->getCurrentOrderInfo();

        $shipping_price = $symbol . $currencies->fs_format_number($order_info['shipping']) . $symbol_right;
        if ($origin_shipping_cost == 0) {
            $is_shipping_free = true;
            if ($order->handleFreeShippingPrice($shipping_method, $shipping_method)) {
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

        if ($is_shipping_free) {
            $shipping_price_tax = FIBER_CHECK_FREE;
        } else {
            $shipping_price_tax = $symbol . $currencies->fs_format_number($order_info_tax['aftertax_shipping']) . $symbol_right;
        }
        $warehouse = $order->local_warehouse;
        $productInfo = Checkout::productInfo($order);
        $country_id = $order->delivery['country_id'];
        $is_bill_company = false;
        if ($order->billing['company_type'] == 'BusinessType' &&
            (!german_warehouse('country_number', $order->billing['country_id']) ||
                $order->billing['country_id'] == 81)) {
            $is_bill_company = true;
        }
        if ($order->delivery['country_id'] == 21 && $order->billing['country_id'] == 223 &&
            $order->billing['company_type'] != 'BusinessType') {
            $is_bill_company = false;
        }
        $is_uk_business_address = false;
        if($order->billing['company_type'] == 'BusinessType' &&
            in_array($order->billing['country']['id'],[222,244]) && $order->delivery['country_id'] !=81) {
            $is_uk_business_address = true;
        }
        $total_before_tax_text = $symbol.$total_before_tax.$symbol_right;
        $price_data = array(
            "vat" => $vat,
            "is_vax" => $order->is_vax,
            "shipping_cost" => $shipping_price,
            "origin_total" => $origin_total,
            "is_shipping_free" => $is_shipping_free,
            "origin_total_us" => $origin_total_us,
            "shipping_cost_tax" => $shipping_price_tax,
            "total_before_tax" => $total_before_tax,
            'subtotal_tax' => $subtotal_tax,

            'total' => $total_info['total'],
            'insurance' => $order_info['insurance'],
            'subtotal' => $order_info['subtotal'],
            'shipping' => $order_info['shipping'],
            'total_text' => $symbol.$total.$symbol_right,
            'subtotal_text' => $symbol.$subtotal.$symbol_right,
            'shipping_text' => $shipping_price,
            'vat_text' => $symbol.$vat.$symbol_right,
            'after_sub_total_text' => $symbol.$subtotal_tax .$symbol_right,
            'after_shipping_text' => $shipping_price_tax,
            'insurance_text' => $symbol.$insurance.$symbol_right,
            "vat_title" => get_checkout_vat_title($order->delivery['country']['iso_code_2'], 2,$is_bill_company, false, $is_uk_business_address),
            'total_before_tax_text' => $total_before_tax_text
        );
        $data = array(
            "info" => [
                'country' => $country_id,
                'is_delay_buck' => $order->is_buck,
                "price_data" => $price_data,
                "warehouse" => $warehouse,
                "currency_left" => $currencies->currencies[$_SESSION['currency']]['symbol_left'],
                "currency_right" => $currencies->currencies[$_SESSION['currency']]['symbol_right'],
            ],
            'productInfo' => $productInfo
        );
        $api->setStatus(200)->response($data);
        break;
    case 'create_order':

        if ($debug) {
            $file = DIR_FS_SQL_CACHE . '/ajax-create-order-' . time() . '.log';
            $handle = fopen($file, 'a+');
            @chmod($file, 777);
        }
        //如果缺失运输地址或者账单地址
        if(empty($_SESSION['sendto'])|| empty($_SESSION['billto'])){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        $payment_method = zen_db_input($_POST['payment_method']);
        $post_quote_subtotal = zen_db_input($_POST['quote_subtotal']);
        if(empty($payment_method)){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        //如果当前支付方式不再指定支付方式内
        if(!in_array($payment_method,['paypal','eNETS','YANDEX','iDEAL','bapay',
            'SOFORT','WEBMONEY','payeezy','globalcollect'])){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        $_SESSION['payment'] = $payment_method;

        $_SESSION['delivery_array'] = zen_db_prepare_input($_POST['tikectInfo']);
        require_once(DIR_WS_CLASSES . 'shipping.php');
        require_once(DIR_WS_CLASSES . 'payment.php');
        $payment = new payment();
        require_once(DIR_WS_CLASSES . 'order.php');
        $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
        if ($debug) fwrite($handle, ' init order - ' . time() . " \n");
        if ($debug) fwrite($handle, ' init shipping - ' . time() . " \n");
        $senTo = (int)$_POST['sendTo'];
        $billTo = (int)$_POST['billTo'];
        $post_cart_counts = (int)$_POST['cart_counts'];
        $total_count = $_SESSION['cart']->count_contents(true);

        switch (true) {
            case (int)$quotes_id > 0:
                $cart_products = $quotes_s->getQuotesDataForCheckout((int)$quotes_id);
                $total_count = $quotes_s->totalCount;
                if (empty($cart_products)) {
                    $api->setStatus(406)->setMessage(FS_INQUIRY_INFO_66)->response();
                }
                $quote_subtotal = $quotes_s->getQuotesTotalInfo($quotes_id);
                $quote_subtotal = $quote_subtotal['ot_subtotal'] ? $quote_subtotal['ot_subtotal'] : 0;
                if($quote_subtotal != $post_quote_subtotal){
                    $api->setStatus(409)->setMessage('error')->response();
                }
                $order = new order("", $cart_products, $senTo, $billTo);
                break;
            case (int)$inquiry_id > 0:
                require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                $inquiry = new inquiry($currencies);
                $cart_products = $inquiry->get_one_inquiry_products_withinfo_checkout((int)$inquiry_id);
                if ($cart_products == false) {
                    echo '{"error":"err","status":200}';
                    exit;
                }
                $order = new order("", $cart_products, $senTo, $billTo);
                break;
            default:
                if ($post_cart_counts != $total_count) {
                    $api->setStatus(406)->setMessage(FS_SHOPPING_CAUTION)->response();
                    return;
                }
                $order = new order("", "", $senTo, $billTo);
                break;
        }

        //账单地址验证
        $order_billing_ads = $order->billing;
        $current_billing_address = array(
            'address_type' => 2,
            'entry_company' => $order_billing_ads['company'],
            'entry_firstname' => $order_billing_ads['firstname'],
            'entry_lastname' => $order_billing_ads['lastname'],
            'company_type' => $order_billing_ads['company_type'],
            'entry_street_address' => $order_billing_ads['street_address'],
            'entry_suburb' => $order_billing_ads['suburb'],
            'entry_postcode' => $order_billing_ads['postcode'],
            'entry_state' => $order_billing_ads['state'],
            'entry_city' => $order_billing_ads['city'],
            'entry_country_id' => $order_billing_ads['country_id'],
            'entry_zone_id' => $order_billing_ads['zone_id'],
            'entry_telephone' => $order_billing_ads['telephone'],
            'entry_tax_number' => $order_billing_ads['tax_number']
        );
        $vat_check = true;
        $customers_id = (int)$_SESSION['customer_id'] ?: 0;
        if ($customers_id && $_SESSION['sendto']) {
            $customer_num = $customer->customers_number_new;
            $frees = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $order->delivery['country']['title']);
            if ($frees) {
                $billing_country_name = $country_s->getCountryNameById($order->delivery['entry_country_id']);
                $BName = $billing_country_name['countries_name'];
                $vat = strtolower($order->delivery['entry_tax_number']);
                foreach ($frees as $free) {
                    if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName) {
                        $vat_check = false;
                        break;
                    }
                }
            }
        }
        $is_valid = $checkout::validate($current_billing_address, $vat_check);
        if(!empty($is_valid)){
            $api->setStatus(422)->setMessage(FIBER_CHECK_EDIT_BILLING_MSG)->response();
        }

        $separateInfo_page = $_POST['products_pages'];
        $check_products_info = checkCreateOrderProductsInfo($order, $separateInfo_page);
        if(!$check_products_info){
            $api->setStatus(406)->setMessage(FS_CHECKOUT_ERROR_PRODUCTS_INFO)->response();
            return;
        }

        if (!zen_not_null($order->info['subtotal'])) {
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
        }
        require_once(DIR_WS_CLASSES . 'order_total.php');
        $pick_tag = zen_db_prepare_input($_POST['pick_tag']);
        $custome_tag = zen_db_prepare_input($_POST['custome_tag']);

        $delivery_data = zen_db_prepare_input($_POST['delivery_data']);

        $insertData = [];
        $insertData['remarks'] = is_array($_POST['comments']) ? zen_db_input($_POST['comments']):[];

        $localInstall = $_POST['localInstall'] ? zen_db_prepare_input($_POST['localInstall']) : "";
        $installTime = $_POST['install_time'] ? zen_db_prepare_input($_POST['install_time']) : "";
        if ($installTime) {
            $insertData['install'] = [
                'localInstall' => $localInstall,
                'installTime' => $installTime
            ];
        }
        createOrderShippingInfo($delivery_data);
        $order_total_modules = new order_total();
        $order_totals = $order_total_modules->process();
        if ($debug) fwrite($handle, ' init order totals - ' . time() . " \n");
        $_SESSION['payment'] = isset($_SESSION['payment']) ? $_SESSION['payment'] : 'paypal';
        $_SESSION['payment'] = $_SESSION['payment'] ? $_SESSION['payment'] : 'paypal';
        $payment = new payment($_SESSION['payment']);
        if ($debug) fwrite($handle, ' init payment - ' . time() . " \n");
        if ($_SESSION['cart']->get_checked_products()['checkedProducts'] || $inquiry_id || $quotes_id) {
            $customers_po = $_POST['poNumber'] ? zen_db_input($_POST['poNumber']) : '';
            $related_email = !empty($_POST['shareInfo']) ? zen_db_prepare_input($_POST['shareInfo']) : "";
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
            $order_id = $order->create_order_new($order_totals, $order_total_modules, $insertData);

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

            switch (true)
            {
                case (int)$quotes_id > 0:
                    //报价单完成 order_id保存
                    if ($_SESSION['customer_id'] && $order_id) {
                        $quotes_id = zen_db_prepare_input($quotes_id);
                        $quotes_s->updateQuotesOrdersStatus($quotes_id, $order_id);
                    }
                    break;
                case (int)$inquiry_id > 0:
                    if($_SESSION['customer_id'] && $order_id){
                        zen_db_perform("customer_inquiry",array('order_id'=>$order_id),'update',"customers_id=".$_SESSION['customer_id']." and id=".$inquiry_id);
                    }
                    break;
                default:
                    $_SESSION['cart']->reset(true);
                    break;
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

            switch (true) {
                case 'paypal' == $_SESSION['payment']:

                    if ($debug) fwrite($handle, ' process paypal action - ' . time() . " \n");
                    $class = &$_SESSION['payment'];
                    $action = $GLOBALS[$class]->form_action_url;
                    if ($debug) fwrite($handle, 'action url: ' . $action . ' - ' . time() . " \n");
                    $process_string = $GLOBALS[$class]->process_string();
                    $process_string .= '::invoice--' . $invoice;

                    if ($debug) {
                        fwrite($handle, '$process_string: ' . $process_string . ' - ' . time() . " \n");
                    }

                    if ($debug) {
                        fclose($handle);
                        @chmod($file, 777);
                    }
                    if (isset($_SESSION['shipping_delay'])) {
                        unset($_SESSION['shipping_delay']);
                    }
                    if (isset($_SESSION['shipping_local'])) {
                        unset($_SESSION['shipping_local']);
                    }
                    if (isset($_SESSION['useUpsDefaultAddress'])) {
                        unset($_SESSION['useUpsDefaultAddress']);
                    }
                    $data = array(
                        'type' => $_SESSION['payment'],
                        'url' => $action,
                        'params' => $process_string,
                        'o_id' => (int)$_SESSION['order_id']
                    );
                    $api->setStatus(200)->response($data);
                    break;
                case  in_array($_SESSION['payment'], array('bpay', 'eNETS', 'iDEAL', 'SOFORT', 'YANDEX', 'WEBMONEY')):

                    $order = new order($order_id);
                    $class = &$_SESSION['payment'];
                    $action = $GLOBALS[$class]->form_action_url;
                    if ($debug) fwrite($handle, 'action url: ' . $action . ' - ' . time() . " \n");
                    if (isset($_SESSION['shipping_delay'])) {
                        unset($_SESSION['shipping_delay']);
                    }
                    if (isset($_SESSION['shipping_local'])) {
                        unset($_SESSION['shipping_local']);
                    }
                    if (isset($_SESSION['useUpsDefaultAddress'])) {
                        unset($_SESSION['useUpsDefaultAddress']);
                    }
                    $process_string = $GLOBALS[$class]->process_string();
                    $data = array(
                        'params' => $process_string,
                        'o_id' => (int)$order_id
                    );
                    $api->setStatus(200)->response($data);
                    break;

                case  ('globalcollect' == $_SESSION['payment'] || 'payeezy' == $_SESSION['payment']):
                    unset($_SESSION['sendto']);
                    unset($_SESSION['billto']);
                    if (isset($_SESSION['shipping_delay'])) {
                        unset($_SESSION['shipping_delay']);
                    }
                    if (isset($_SESSION['shipping_local'])) {
                        unset($_SESSION['shipping_local']);
                    }
                    if (isset($_SESSION['useUpsDefaultAddress'])) {
                        unset($_SESSION['useUpsDefaultAddress']);
                    }
                    unset($_SESSION['payment']);
                    unset($_SESSION['comments']);

                    $api->setStatus(200)->response(['orders_id' => $order_id]);
                    break;
            }

        } else {
            if ('paypal' == $_SESSION['payment']) {
                $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            }
        }

        //fallwind 2016.10.14	下单成功时，判断$_SESSION['google_ads']是否有值，有值就记录其ip，同时记录该值
        if (!empty($_SESSION['google_ads']) && isset($_SESSION['google_ads'])) {
            $customer_come_ip = getCustomersIP();
            setComeIpByOrders($customer_come_ip, $_SESSION['order_id']);
        }
        break;
    case 'save_customer_po':
        require_once(DIR_WS_CLASSES . 'shipping.php');
        //如果缺失运输地址或者账单地址
        if(empty($_SESSION['sendto'])|| empty($_SESSION['billto'])){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        $payment_method = zen_db_input($_POST['payment_method']);

        if(empty($payment_method)){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        if(!in_array($payment_method,['purchase','echeck','hsbc','alfa'])){
            $api->setStatus(406)->setMessage(FS_SYSTME_BUSY)->response();
            return;
        }
        $quotes_id = (int)$_POST['quotes_id'];
        if($quotes_id){
            $post_quote_subtotal = zen_db_input($_POST['quote_subtotal']);
            $quote_subtotal = $quotes_s->getQuotesTotalInfo($quotes_id);
            $quote_subtotal = $quote_subtotal['ot_subtotal'] ? $quote_subtotal['ot_subtotal'] : 0;
            if($quote_subtotal != $post_quote_subtotal){
                $api->setStatus(409)->setMessage('error')->response();
            }
        }

        //账单地址验证
        $customer_info = new customer_account_info();
        $shipping_address = $customer_info->get_select_address($_SESSION['sendto']);
        $current_billing_address = $customer_info->get_select_address($_SESSION['billto']);
        $current_address = array(
            'address_type' => 2,
            'entry_company' => $current_billing_address['entry_company'],
            'entry_firstname' => $current_billing_address['entry_firstname'],
            'entry_lastname' => $current_billing_address['entry_lastname'],
            'company_type' => $current_billing_address['company_type'],
            'entry_street_address' => $current_billing_address['entry_street_address'],
            'entry_suburb' => $current_billing_address['entry_suburb'],
            'entry_postcode' => $current_billing_address['entry_postcode'],
            'entry_state' => $current_billing_address['entry_state'],
            'entry_city' => $current_billing_address['entry_city'],
            'entry_country_id' => $current_billing_address['entry_country']['entry_country_id'],
            'entry_zone_id' => $current_billing_address['entry_zone_id'],
            'entry_telephone' => $current_billing_address['entry_telephone'],
            'entry_tax_number' => $current_billing_address['entry_tax_number']
        );
        $vat_check = true;
        $customers_id = (int)$_SESSION['customer_id'] ?: 0;
        if ($customers_id && $_SESSION['sendto']) {
            $customer_num = $customer->customers_number_new;
            $frees = $tax_exemption->getTaxFreeApplyFromAdmin($customer_num, $order->delivery['country']['title']);
            if ($frees) {
                $billing_country_name = $country_s->getCountryNameById($shipping_address['entry_country_id']);
                $BName = $billing_country_name['countries_name'];
                $vat = strtolower($shipping_address['entry_tax_number']);
                foreach ($frees as $free) {
                    if (strtolower($free['vat_number']) == $vat && strtolower($free['billing_country']) == $BName) {
                        $vat_check = false;
                        break;
                    }
                }
            }
        }
        $is_valid = $checkout::validate($current_address, $vat_check);
        if(!empty($is_valid)){
            $api->setStatus(422)->setMessage(FIBER_CHECK_EDIT_BILLING_MSG)->response();
        }


        $_SESSION['payment'] = $payment_method;
        $delivery_data = zen_db_prepare_input($_POST['delivery_data']);
        $_SESSION['delivery_array'] =zen_db_prepare_input($_POST['tikectInfo']);

        $_SESSION['customers_po'] = zen_db_input($_POST['poNumber']);
        $_SESSION['customer_remarks'] = $_POST['customer_remarks'];
        $_SESSION['products_custom'] = $_POST['products_custom'];
        $_SESSION['need_invoice'] = $_POST['invoice_need'];
        $alfa_id = (int)$_POST['defaultAlfaInfoId'];
        $client_type = zen_db_prepare_input($_POST['client_type']);
        $related_email = !empty($_POST['shareInfo']) ? zen_db_prepare_input($_POST['shareInfo']) : "";
        $localInstall = $_POST['localInstall'] ? zen_db_prepare_input($_POST['localInstall']) : "";
        $installTime = $_POST['install_time'] ? zen_db_prepare_input($_POST['install_time']) : "";
        $billTo = (int)$_POST['billTo'];

        if(!empty($_POST['comments'])){
            $_SESSION['remarks'] = zen_db_prepare_input($_POST['comments']);
        }
        if ($_SESSION['payment'] == "alfa" && !$alfa_id) {
            $api->setStatus(406)->setMessage(FS_SHOPPING_CAUTION)->response();
        }
        $_SESSION['alfa_info'] = $alfa_id;

        if ($installTime) {
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
        createOrderShippingInfo($delivery_data);
        if (!empty($_SESSION['payment']) && $_SESSION['payment'] == "echeck") {
            $_SESSION['echeck_info'] = zen_db_prepare_input($_POST['echeckInfo']);
        }

        $api->setStatus(200)->response($_SESSION['alfa_info']);
        break;
    case 'delete_ru_payment_address':
        $id = zen_db_prepare_input($_POST['alfa_id']);
        if (empty($id)) {
            $api->setStatus(460)->setMessage(FS_SYSTME_BUSY)->response();
        }
        $customer_id = $_SESSION['customer_id'];
        $res = $ru_service->setInformationAddress()->deletePaymentInformation($id, $customer_id);
        $data = $ru_service->allPaymentInformation(false);
        if ($res['status'] == 400) {
            $api->setStatus(460)->setMessage(FS_SYSTME_BUSY)->response();
        } else {
            $api->setStatus(200)->response($data);
        }
        break;
    case 'send_email':
        if ($debug) {
            $file = DIR_FS_SQL_CACHE . '/ajax-send-mail-' . time() . '.log';
            $handle = fopen($file, 'a+');
            @chmod($file, 777);
        }

        $orders_id = $_POST['orders_id'];

        if ($debug) fwrite($handle, $orders_id . "\n");
        $complete_mail = false;
        if (isset($orders_id) && zen_check_order_exist($orders_id)) {
            if ($_SESSION['customer_id']) {
                $customerFields = array(
                    'customers_email_address',
                    'customer_country_id',
                    'customers_regist_from',
                    'customers_number_new',
                    'is_disabled',
                    'customers_email_address',
                    'is_allot',
                    'customers_firstname',
                    'customers_lastname',
                    'customers_telephone'
                );
                $customerInfo = fs_get_data_from_db_fields_array($customerFields, 'customers', 'customers_id=' . $_SESSION['customer_id'], 'limit 1');
                $email_address = $customerInfo[0][0];
                $customers_country_id = $customerInfo[0][1];
                $customer_from = $customerInfo[0][2];
                $customers_number_new = $customerInfo[0][3];
                $isDisabled = $customerInfo[0][4];
                $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
                $dataInfo = getIsDisabledEmail($customers_number_new, $isDisabled, $admin_id);
                $admin_id = $dataInfo['admin_id'];
                $reason = $dataInfo['reason_type'];
            }

            if (!$admin_id) {
                $order_cust_id = fs_get_data_from_db_fields('customers_id', 'orders', 'orders_id=' . $orders_id, '');
                if ($order_cust_id) {
                    //新注册的用户下单进行分配
                    if ($customer_from == 'regist') {
                        $allot_type = 'register_order';
                        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                        $is_go_auto_given = 1;
                        if ($admin_id) {
                            $stats_data = array(
                                'stats_order' => 1,
                                'is_make_up' => $is_make_up,
                                'remind' => 0,
                                'is_old' => $is_old ? $is_old : 0,     // 标注新、老客户
                            );
                            zen_db_perform(TABLE_CUSTOMERS, $stats_data, 'update', 'customers_id=' . $_SESSION['customer_id']);


                            // fairy 2018.8.30 add 如果该项分配当前销售。则也要把该用户分配给当前销售
                            if ($admin_id && $_SESSION['customer_id']) {
                                auto_given_customers_to_admin(array(
                                    'admin_id' => $admin_id,
                                    'email_address' => $email_address,
                                    'admin_id_from_table' => $admin_id_from_table,
                                    'customers_id' => $_SESSION['customer_id'], // 注册用户
                                    'is_old' => $is_old ? $is_old : 0,     // 标注新、老客户
                                    'customer_number' => $customers_customers_number_new,
                                    'customer_offline_number' => $offline_customers_number_new,
                                    'invalidSign' => $invalidSign,
                                ), true);
                            }

                            $son_order = zen_get_all_son_order_id($orders_id);
                            if ($son_order) {
                                $son_order[] = $orders_id;
                                for ($i = 0; $i < sizeof($son_order); $i++) {
                                    $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $son_order[$i] . ")");
                                }
                            } else {
                                $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $orders_id . ")");
                            }
                        }
                        zen_db_perform(TABLE_CUSTOMERS, array('is_allot' => 1, 'stats_order' => 1), 'update', 'customers_id=' . $_SESSION['customer_id']);
                        define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
                        $sales_email = fs_get_data_from_db_fields('admin_email', 'admin', 'admin_id=' . $admin_id, '');
                        $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
                        $name = $customerInfo[0][7] . ' ' . $customerInfo[0][8];
                        $phonenumber = $customerInfo[0][9];
                        $email_address = $customerInfo[0][5];
                        $country = zen_get_country_name($adress->fields['entry_country_id']);
                        $street = $adress->fields['entry_street_address'];
                        $entry_postcode = $adress->fields['entry_postcode'];
                        $entry_city = $adress->fields['entry_city'];
                        $html = zen_get_corresponding_languages_email_common($_SESSION['customer_id']);
                        //send to us
                        $text_message = "Customer Info";
                        $html_msg_us['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg_us['EMAIL_FOOTER'] = $html['html_footer'];
                        $html_msg_us['CUSTOMER_NAME'] = $name ? $name : 'not set yet';
                        $html_msg_us['PHONE_NUMBER'] = $phonenumber ? $phonenumber : 'not set yet';
                        $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                        $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
                        $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
                        $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
                        $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';

                        if ($admin_id) {
                            if ($sales_email) {
                                zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
                            }
                        }
                        $db->Execute("update  customers c inner join admin_to_customers atc using(customers_id) set is_allot=0 WHERE is_allot=1");
                    } else {
                        //第三方登陆下单
                        $allot_type = 'third_party_login_order';
                        $is_go_auto_given = 1;
                        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                        if ($admin_id) {
                            $stats_data = array(
                                'stats_order' => 1,
                                'is_make_up' => $is_make_up,
                                'remind' => 0,
                                'is_old' => $is_old ? $is_old : 0,   // 标注新、老客户
                            );
                            zen_db_perform(TABLE_CUSTOMERS, $stats_data, 'update', 'customers_id=' . $_SESSION['customer_id']);
                            if ($admin_id && $_SESSION['customer_id']) {
                                auto_given_customers_to_admin(array(
                                    'admin_id' => $admin_id,
                                    'email_address' => $email_address,
                                    'admin_id_from_table' => $admin_id_from_table,
                                    'customers_id' => $_SESSION['customer_id'], // 注册用户
                                    'is_old' => $is_old ? $is_old : 0,    // 标注新、老客户
                                    'customer_number' => $customers_customers_number_new,
                                    'customer_offline_number' => $offline_customers_number_new,
                                    'invalidSign' => $invalidSign,
                                ), true);
                            }
                            $son_order = zen_get_all_son_order_id($orders_id);
                            if ($son_order) {
                                $son_order[] = $orders_id;
                                for ($i = 0; $i < sizeof($son_order); $i++) {
                                    $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $son_order[$i] . ")");
                                }
                            } else {
                                $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $orders_id . ")");
                            }
                            zen_db_perform(TABLE_CUSTOMERS, array('is_allot' => 1, 'stats_order' => 1), 'update', 'customers_id=' . $_SESSION['customer_id']);
                            define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
                            $sales_email = fs_get_data_from_db_fields('admin_email', 'admin', 'admin_id=' . $admin_id, '');
                            $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
                            $name = $customerInfo[0][7] . ' ' . $customerInfo[0][8];
                            $phonenumber = $customerInfo[0][9];
                            $email_address = $customerInfo[0][5];
                            $country = zen_get_country_name($adress->fields['entry_country_id']);
                            $street = $adress->fields['entry_street_address'];
                            $entry_postcode = $adress->fields['entry_postcode'];
                            $entry_city = $adress->fields['entry_city'];
                            $html = zen_get_corresponding_languages_email_common($_SESSION['customer_id']);
                            //send to us
                            $text_message = "Customer Info";
                            $html_msg_us['EMAIL_HEADER'] = $html['html_header'];
                            $html_msg_us['EMAIL_FOOTER'] = $html['html_footer'];
                            $html_msg_us['CUSTOMER_NAME'] = $name ? $name : 'not set yet';
                            $html_msg_us['PHONE_NUMBER'] = $phonenumber ? $phonenumber : 'not set yet';
                            $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                            $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
                            $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
                            $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
                            $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';

                            if ($admin_id) {
                                if ($sales_email) {
                                    zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
                                }
                            }
                        }
                    }
                }
            }

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
    case 'already_open_page':
        $customer_id = $_POST['customer_id'];
        $data['customer_id']=$customer_id;
        $data['type']=1;
        $data['create_time']=date('Y-m-d H:i:s');
        $res=zen_db_perform('customers_guide_tips_log',$data);
        $api->setStatus(200)->response($res);
        break;
}
