<?php

use App\Services\Orders\OrderProductService;
use App\Services\Quote\QuoteService;
use App\Services\Email\QuotesEmailService;
use App\Services\Customers\CustomerService;
use App\Services\Common\ApiResponse;
use App\Services\AdminCustomers\AdminCustomersService;
use App\Services\Products\ProductService;
use App\Services\Products\ProductAttributeService;
use App\Models\ProductThumbImage;

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php')); //语言包
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/views/print_blanket_order.php');
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/views/print_definite_invoice.php');

$quotes_s = new QuoteService();
$q_email_s = new QuotesEmailService();
$customers_s = new CustomerService();
$admin_customers_s = new AdminCustomersService();
$api = new ApiResponse();

$action = $_GET['ajax_request_action'];
if (in_array($action, ['share_quotes', 'quotes_again'])) {
    $quotes_id = $_POST['quotes_id'];
    $check_permissions = $quotes_s->getCheckQuotesCustomers($quotes_id);
    if (!$check_permissions) {
        $api->setStatus(403)->setMessage('Do not have permission')->response();
    }
}


switch ($action) {
    case 'click_log':
        $click_type = $_POST['click_type'];
        $res=click_log($click_type);
        $api->setStatus(200)->setMessage($res)->response();
        break;
    case 'create_quotes':
        click_log(2);

        //销售分配
        $customers_arr = $customers_s->setCustomer()->firstCustomer();

        $admin_id = $customers_arr['admin_to_customer']['admin_id'];
        $admin_name = $customers_arr['admin_to_customer']['admin_name'];
        $admin_email = $customers_arr['admin_to_customer']['admin_email'];
        $email_address = $customers_arr['customers_email_address'];
        $customers_country_id = $customers_arr['customer_country_id'];
        if (empty($admin_id)) {
            $allot_type = 'quotes';
            require_once(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
            $admin_customers_s->insertAdminCustomer($customers_arr['customers_id'], $admin_id, date('Y-m-d H:i:s'));
        }
        foreach ($_POST as $p_key => $p_val) {
            if ($p_key != 'quote_create_comments' && empty($p_val)) {
                $api->setStatus(403)->setMessage('The Data was Empty!')->response();
            }
        }

        require_once(DIR_WS_CLASSES . 'order_quotes.php');
        require_once DIR_WS_CLASSES . 'class.checkout_quotes.php';
        $checkout = Checkout::getInstance(
            array(
                "main_page" => "checkout",
                "validate_format" => "html",
                "state_format" => "html"
            )
        );
        $order = new order_quotes();
        $shipping_data = getAllShippingData();
        $separateInfo = $checkout::handlerShippingAddress($_SESSION['sendto_quotes'],
            false, '', '', $order, $shipping_data);

        $quotes_data = $quotes_s->createQuotesData($order);

        //var_dump($quotes_data);die;

        if ($quotes_data['flag'] == 0) {
            $api->setStatus(403)->setMessage($quotes_data['msg'])->response();
        }

        $new_quotes_id = $quotes_data['data']['id'];
        $new_quotes_num = $quotes_data['data']['number'];
        $quotes_products = $quotes_data['data']['products_arr'];
        $attributes_arr = $quotes_data['data']['products_attributes_arr'];

        //发送邮件
        $customers_arr = $customers_s->setCustomer()->firstCustomer();
        $user_name = $customers_arr['customers_firstname'] . '.' . $customers_arr['customers_lastname'];
        $email = $customers_arr['customers_email_address'];
        $admin_email = $customers_arr['admin_to_customer']['admin_email'];
        $theme = str_replace('$NUM', $new_quotes_num, FS_QUOTES_CREATE_EMAIL_THEME);

        $first_msg = EMAIL_QUOTES_SUCCESS_01;
        $html = common_email_header_and_footer(FS_SEND_EMAIL_3, $first_msg);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['QUOTES_CUSTOMERS'] = $user_name;
        $html_msg['COMMON_DEAR'] = FS_ORDER_EMAIL_28;
        $html_msg['EMAIL_FIRST_NAME'] = $customers_arr['customers_firstname'];
        $html_msg['EMAIL_LAST_NAME'] = $customers_arr['customers_lastname'];
        $html_msg['EMAIL_QUOTES_SUCCESS_01'] = EMAIL_QUOTES_SUCCESS_01;
        $html_msg['EMAIL_QUOTES_SUCCESS_02'] = EMAIL_QUOTES_SUCCESS_02;
        $html_msg['EMAIL_QUOTES_SUCCESS_03'] = EMAIL_QUOTES_SUCCESS_03;
        $html_msg['EMAIL_QUOTES_SUCCESS_04'] = $_POST['quote_create_comments'];
        $html_msg['EMAIL_QUOTES_SUCCESS_05'] = EMAIL_QUOTES_SUCCESS_05;
        $html_msg['EMAIL_QUOTES_SUCCESS_06'] = EMAIL_QUOTES_SUCCESS_06;
        $html_msg['QUOTES_NUMBER'] = $new_quotes_num;
        $html_msg['QUOTES_DETAILS_LINK'] = zen_href_link('quotes_details', 'quotes_id=' . $new_quotes_id);
        $html_msg['QUOTES_LIST_LINK'] = zen_href_link('quotes_list');
        $html_msg['QUOTES_PDF_LINK'] = zen_href_link('quotes_pdf', 'quotes_id=' . $new_quotes_id);
        //$html_msg['QUOTES_PRODUCTS'] = $q_email_s->getQuotesProductsHtml($quotes_products, $attributes_arr);

        //订单的详情信息
        //$new_quotes_id=1218;
        $quotes_data_details = $quotes_s->getQuotesDetails($new_quotes_id);

        $quotes_details_products = $quotes_data_details['quotes_products'];

        $shipping_ads = $quotes_data_details['quotes_address'][0];//收货地址
        $billing_ads = $quotes_data_details['quotes_address'][1];//账单地址
        $instock_html = zen_get_orders_warehouse_address($quotes_data_details['warehouse'], $shipping_ads['entry_country_id']);

        $quotes_total = $quotes_data_details['quotes_total'];

        //地址街道表达
        if (!empty($shipping_ads['entry_street_address']) && !empty($shipping_ads['entry_suburb'])) {
            $shipping_ads_street = $shipping_ads['entry_street_address'] . ', ' . $shipping_ads['entry_suburb'];
        } else {
            $shipping_ads_street = !empty($shipping_ads['entry_street_address']) ? $shipping_ads['entry_street_address'] : $shipping_ads['entry_suburb'];
        }
        if (!empty($billing_ads['entry_street_address']) && !empty($billing_ads['entry_suburb'])) {
            $billing_ads_street = $billing_ads['entry_street_address'] . ', ' . $billing_ads['entry_suburb'];
        } else {
            $billing_ads_street = !empty($billing_ads['entry_street_address']) ? $billing_ads['entry_street_address'] : $billing_ads['entry_suburb'];
        }

        $trade = intval($quotes_data_details['quotes_total_code']['shipping_cost']) == 0 ? 'FOB' : 'C&F';

        if (!empty($quotes_data_details['shipping_local_method_code']) && !empty($quotes_data_details['shipping_delay_method_code'])) {
            $shipping_method = zen_get_order_shipping_method_by_code($quotes_data_details['shipping_local_method_code']) . ' & ' . zen_get_order_shipping_method_by_code($quotes_data_details['shipping_delay_method_code']);
        } else {
            $shipping_method = !empty($quotes_data_details['shipping_delay_method_code']) ? zen_get_order_shipping_method_by_code($quotes_data_details['shipping_delay_method_code']) : zen_get_order_shipping_method_by_code($quotes_data_details['shipping_local_method_code']);
        }

        $is_show_vat = $quotes_data_details['currency'] == 'AUD' || (float)$quotes_data_details['quotes_total_code']['tax'] == 0 ? false : true;//澳大利亚不展示税费

        //收货地址的国家code
        $country_code = zen_get_country_iso_code($shipping_ads['entry_country_id']);
        //显示时间
        $languages_code = $_SESSION['languages_code'];
        switch ($languages_code) {
            case 'en':
                $create_time = getTime('M d, Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('M d, Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'uk':
                $create_time = getTime('d M, Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d M, Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'au':
                $create_time = getTime('d M, Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d M, Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'sg':
                $create_time = getTime('M d, Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('M d, Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'dn':
                $create_time = getTime('d M, Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d M, Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'de':
                $create_time = getTime('d.m.Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d.m.Y H:i', $quotes_data_details['expired_time'], $country_code).' Uhr';
                break;
            case 'fr':
                $create_time = getTime('d/m/Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d/m/Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'es':
                $create_time = getTime('d/m/Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d/m/Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'mx':
                $create_time = getTime('d/m/Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d/m/Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'ru':
                $create_time = getTime('d/m/Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d/m/Y h:ia', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'jp':
                $create_time = getTime('Y年m月d日', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('Y年m月d日 H:i', $quotes_data_details['expired_time'], $country_code);
                break;
            case 'it':
                $create_time = getTime('d/m/Y', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('d/m/Y h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
            default :
                $create_time = getTime('Y-m-d', $quotes_data_details['create_time'], $country_code);
                $expired_time = getTime('Y-m-d h:iA', $quotes_data_details['expired_time'], $country_code);
                break;
        }

        //税费文案
        $warehouse = $quotes_data_details['warehouse'];
        switch ($warehouse) {
            case 2:
                $var_title = FS_BLANKET_VAT_US;
                break;
            case 20:
                $var_title = FS_BLANKET_VAT_DE;
                break;
            case 37:
            case 71:
                $var_title = FS_BLANKET_VAT_SG;
                break;
            case 40:
                $var_title = FS_VAX_TITLE_US_TAX;
                break;
        }

        //新增字段
        $html_msg['QUOTES_NOTE_TITLE'] = QUOTES_NOTE_TITLE;
        $html_msg['QUOTES_NOTE_TIPS'] = QUOTES_NOTE_TIPS;
        $html_msg['QUOTES_RQN_NUMBER_TITLE'] = QUOTES_RQN_NUMBER_TITLE;
        $html_msg['QUOTES_TRADE_TERM_TITLE'] = QUOTES_TRADE_TERM_TITLE;
        $html_msg['QUOTES_TRADE_TERM'] = $trade;
        $html_msg['QUOTES_PAYMENT_TERM_TITLE'] = QUOTES_PAYMENT_TERM_TITLE;
        $html_msg['QUOTES_PAYMENT_TERM'] = $quotes_data_details['payment_method'];
        $html_msg['QUOTES_SHIP_VIA_TITLE'] = QUOTES_SHIP_VIA_TITLE;
        $html_msg['QUOTES_SHIP_VIA'] = $shipping_method;
        $html_msg['QUOTES_DATE_ISSUED_TITLE'] = QUOTES_DATE_ISSUED_TITLE;
        $html_msg['QUOTES_DATE_ISSUED'] = $create_time;
        $html_msg['QUOTES_EXPIRES_TITLE'] = QUOTES_EXPIRES_TITLE;
        $html_msg['QUOTES_EXPIRES'] = $expired_time;
        $html_msg['QUOTES_ACCOUNT_MANAGER_TITLE'] = QUOTES_ACCOUNT_MANAGER_TITLE;
        $html_msg['QUOTES_ACCOUNT_MANAGER'] = $admin_name;
        $html_msg['QUOTES_ACCOUNT_EMAIL_TITLE'] = QUOTES_ACCOUNT_EMAIL_TITLE;
        $html_msg['QUOTES_ACCOUNT_EMAIL'] = $admin_email;

        $html_msg['QUOTES_DELIVER_TO'] = QUOTES_DELIVER_TO;
        $html_msg['QUOTES_DELIVER_ADDRESS1'] = $shipping_ads['entry_company']?$shipping_ads['entry_company']."<br>":'';
        $html_msg['QUOTES_DELIVER_ADDRESS2'] = $shipping_ads_street;
        $html_msg['QUOTES_DELIVER_ADDRESS3'] = $shipping_ads['entry_city'] . ', ' . $shipping_ads['entry_postcode'];
        $html_msg['QUOTES_DELIVER_ADDRESS4'] = (!empty($shipping_ads['entry_state']) ? $shipping_ads['entry_state'] . ', ' : '') . $shipping_ads['entry_country'];
        $html_msg['QUOTES_DELIVER_ADDRESS5'] = FS_INVOICE_DELIIVER_NAME . $shipping_ads['entry_firstname'] . '.' . $shipping_ads['entry_lastname'];
        $html_msg['QUOTES_DELIVER_ADDRESS6'] = FS_BLANKET_29 . $shipping_ads['entry_telephone'];

        $html_msg['QUOTES_BILLING_TO'] = QUOTES_BILLING_TO;
        $html_msg['QUOTES_BILLING_ADDRESS1'] = $billing_ads['entry_company']?$billing_ads['entry_company']."<br>":'';
        $html_msg['QUOTES_BILLING_ADDRESS2'] = $billing_ads_street;
        $html_msg['QUOTES_BILLING_ADDRESS3'] = $billing_ads['entry_city'] . ', ' . $billing_ads['entry_postcode'];
        $html_msg['QUOTES_BILLING_ADDRESS4'] = (!empty($billing_ads['entry_state']) ? $billing_ads['entry_state'] . ', ' : '') . $billing_ads['entry_country'];
        $html_msg['QUOTES_BILLING_ADDRESS5'] = FS_INVOICE_DELIIVER_NAME . $billing_ads['entry_firstname'] . '.' . $billing_ads['entry_lastname'];
        $html_msg['QUOTES_BILLING_ADDRESS6'] = FS_BLANKET_29 . $billing_ads['entry_telephone'];

        $html_msg['QUOTES_ISSUED_BY_TITLE'] = FS_BLANKET_04;
        $html_msg['QUOTES_ISSUED_BY'] = $instock_html;
        $html_msg['QUOTES_QUOTE_LIST'] = FS_SEND_EMAIL_6;
        $html_msg['QUOTES_QUOTE_TITLE1'] = QUOTES_QUOTE_TITLE1;
        $html_msg['QUOTES_QUOTE_TITLE2'] = QUOTES_QUOTE_TITLE2;
        $html_msg['QUOTES_QUOTE_TITLE3'] = QUOTES_QUOTE_TITLE3;
        $html_msg['QUOTES_QUOTE_TITLE4'] = FS_BLANKET_TOTAL;
        if ($_SESSION['languages_code'] == 'fr') {
            $_str = " :";
        } else {
            $_str = ":";
        }
        $html_msg['QUOTES_SUBTOTAL_TITLE'] = ACCOUNT_TOTAL.$_str;
        $html_msg['QUOTES_SUBTOTAL'] = $quotes_total['subtotal'];

        $html_msg['QUOTES_SHIPPING_COST_TITLE'] = FS_BLANKET_SHIPPING.$_str;
        $html_msg['QUOTES_SHIPPING_COST'] = !empty($quotes_total['shipping_cost']) ? $quotes_total['shipping_cost'] : '&nbsp;';

        $html_msg['QUOTES_SALES_TAX_TITLE'] = $is_show_vat ? $var_title.$_str : '';
        $html_msg['QUOTES_SALES_TAX'] = $is_show_vat ? $quotes_total['tax'] : '';

        $html_msg['QUOTES_TOTAL_TITLE'] = $is_show_vat ? FS_BLANKET_TOTAL.$_str : FS_QUOTES_PDF_TOTAL_TAX.$_str;
        $html_msg['QUOTES_TOTAL'] =$quotes_total['total'];

        $html_msg['QUOTES_PRODUCTS'] = $q_email_s->getQuotesProductsHtmlNew($quotes_details_products,$quotes_data_details['currency'],$quotes_data_details['currency_value']);

        sendwebmail($user_name, $email, 'quotes_success_new:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'quotes_success_new');
        sendwebmail($user_name, $admin_email, 'quotes_success_new:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'quotes_success_new');

        $api->setStatus(200)->setMessage($quotes_data['msg'])->response($quotes_data['data']);
        break;
    case 'share_quotes':
        $share_to_email = $_POST['share_to_email'];
        $quotes_id = $_POST['quotes_id'];
        $isSendToSale = $_POST['isSendToSale'];
        $isSendToFsAccount = $_POST['isSendToFsAccount'];
        $share_comments = $_POST['quote_comments'];
        $share_to_email_arr = explode(';', $share_to_email);

        $customers_obj = $customers_s->setCustomer()->firstCustomer();
        $user_name = $customers_obj['customers_firstname'] . '.' . $customers_obj['customers_lastname'];
        $email = $customers_obj['customers_email_address'];
        if($isSendToSale == 1){
            $share_to_email_arr = array_merge($share_to_email_arr, [$customers_obj['admin_to_customer']['admin_email']]);
        }
        $share_to_email_arr = array_unique($share_to_email_arr);
        $theme = str_replace('$EMAIL',$email,FS_QUOTES_SHARE_EMAIL_THEME);

        $first_msg = EMAIL_QUOTES_SHARE_01.' '.EMAIL_QUOTES_SHARE_02.' '.EMAIL_QUOTES_SHARE_03;
        $html = common_email_header_and_footer(EMAIL_QUOTES_SHARE_04, $first_msg);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['QUOTES_PDF_LINK'] = zen_href_link('quotes_pdf', 'quotes_id=' . $quotes_id);
        $html_msg['EMAIL_QUOTES_SHARE_01'] = EMAIL_QUOTES_SHARE_01;
        $html_msg['EMAIL_QUOTES_SHARE_02'] = EMAIL_QUOTES_SHARE_02;
        $html_msg['EMAIL_QUOTES_SHARE_03'] = EMAIL_QUOTES_SHARE_03;
        $html_msg['EMAIL_QUOTES_SHARE_05'] = EMAIL_QUOTES_SHARE_05;
        $html_msg['EMAIL_QUOTES_SHARE_06'] = EMAIL_QUOTES_SUCCESS_03;
        $html_msg['EMAIL_QUOTES_SHARE_07'] = $share_comments;
        $html_msg['EMAIL_QUOTES_SUCCESS_06'] = EMAIL_QUOTES_SUCCESS_06;

        foreach ($share_to_email_arr as $email_val) {
            $check_share_email = $customers_s->setCustomer('', $email_val)->currentCustomer;

            if (!$check_share_email || $isSendToFsAccount != 1) {
                $html_msg['QUOTES_VIEW_BTN'] = '';
                $insert_data = array(
                    'quotes_id' => $quotes_id,
                    'customers_email' => $email_val,
                    'create_time' => time(),
                    'update_time' => time()
                );
                $quotes_s->shareQuotesOfflineCustomers($insert_data);
            } else {
                //分享至客户的账户中心
                if($isSendToFsAccount == 1 && $email_val != $email) {
                    $share_customers_id = $check_share_email->customers_id;
                    $insert_data = array(
                        'quotes_id' => $quotes_id,
                        'customers_id' => $share_customers_id,
                        'is_origin_customers' => 0,
                        'share_time' => time(),
                        'share_remark' => $share_comments,
                        'share_admin' => $customers_obj['customers_id'],
                        'data_from' => 0
                    );
                    $quotes_s->shareQuotesData($insert_data);
                }
                $html_msg['QUOTES_VIEW_BTN'] = $q_email_s->getShareEmailBtn();
            }

            sendwebmail($user_name, $email_val, 'quotes_share:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'quotes_share');
        }
        $api->setStatus(200)->response();
        break;
    case 'create_quote_pdf':
        $quotes_s->createQuotesPdf();
        break;
    case 'quotes_again':
        require_once(DIR_WS_CLASSES . 'shipping_info.php');
        require_once DIR_WS_CLASSES . 'shopping_cart_help.php';

        $quotes_id = $_POST['quotes_id'];
        $type = (int)zen_db_prepare_input($_POST['type']);
        //status标识客户操作 1点击quotes again按钮 2:Skip and Continue 3:Add to Cart
        $status = (int)zen_db_prepare_input($_POST['status']);

        //报价产品数据
        $quotes_info = $quotes_s->getQuotesDetails($quotes_id);
        $quotes_products = $quotes_info['quotes_products'];
        $orderData = [
            'quotes_id' => $quotes_id,
            'quotes_number' => $quotes_info['quotes_number'],
        ];

        $cart_quantity = $_POST['cart_quantity'];
        if ($status == 3 && !count($_POST['cart_quantity'])) {
            //确认加购 却没有产品
            $api->response(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => ''));
        }

        $opService = new OrderProductService();
        //设置产品图片尺寸
        $opService->setImageSize(['size_w'=>80,'size_h'=>80]);
        $column_products = $close_products = $clearance_products = $clearance_products_no = [];   //不能直接加购的产品
        $is_add = true; //  是否可以整单加入购物车
        $add_products = []; //加入购物车的产品ID

        $current_warehouse = get_warehouse_by_code($_SESSION['countries_iso_code']);
        //if ($status == 3) {
            $productsDataNew = [];
            //确认加购产品 只加购客户选中的产品
            $add_key = array_keys($cart_quantity);  //key是orders_products表中的orders_products_id
            $productService = new ProductService();
            $productService->setField([
                    'products_status',
                    'de_status',
                    'us_status',
                    'cn_status',
                    'au_status',
                    'sg_status',
                    'ru_status'
                ]);
            foreach ($quotes_products as $kk => $vv) {
                $productsInfo = $productService->getOneProductField($vv['products_id']);
                $img = (new ProductThumbImage())->setThumbImage(['size_w'=>80,'size_h'=>80])
                    ->getResourceImage($vv['products_id'], false, $productsInfo['products_status']);
                $attributes = $length = [];
                if ($vv['attributes']) {
                    foreach ($vv['attributes'] as $item) {
                        $attributes[] = [
                            'options_name' => $item['products_options'],
                            'values_name' => $item['products_options_values'],
                            'upload_file' => $item['upload_file'],
                            'options_id' => $item['products_options_id'],
                            'values_id' => $item['products_options_values_id'],
                        ];
                    }
                }

                if ($vv['length']) {
                    //每个产品只有一个长度属性
                    foreach ($vv['length'] as $length) {
                        $length = [
                            'length_price' => $length['length_price'],
                            'length_name' => $length['length_name'],
                        ];
                    }
                }


                if ($status == 3 && in_array($vv['products_id'], $add_key)) {
                    //$vv['products_quantity'] = $cart_quantity[$vv['orders_products_id']];
                    $product_quantity = $cart_quantity[$vv['products_id']];

                    $is_close = $is_custom = false;
                    if ($productsInfo[$current_warehouse.'_status']==0 ||
                        $productsInfo['products_status']==0) {
                        $is_close = true;
                    }

                    if ($vv['attributes'] || $vv['length']) {
                        $is_custom = true;
                    }
                    $productsDataNew[] = [
                        'products_id' => $vv['products_id'],
                        'orders_products_id' => $vv['products_id'],
                        'products_prid' => $vv['products_prid'],
                        'composite_son_products' => $vv['composite_son_quote_products'],
                        'products_model' => $vv['products_model'],
                        'products_name' => $vv['products_name'],
                        'products_price' => $vv['products_price'],
                        'products_quantity' => $product_quantity>0?$product_quantity:$vv['products_qty'],
                        'orders_products_attributes' => $attributes,
                        'orders_products_length' => $length,
                        'is_custom' => $is_custom, //有用参数
                        'is_close' => $is_close, //有用参数
                        'image' => $img,
                        'products_href' => 'products/'.$vv['products_id'].'.html',
                    ];
                } else {
                    //$vv['products_quantity'] = $cart_quantity[$vv['orders_products_id']];
                    $productsInfo = $productService->getOneProductField($vv['products_id']);
                    $is_close = $is_custom = false;
                    if ($productsInfo[$current_warehouse.'_status']==0 ||
                        $productsInfo['products_status']==0) {
                        $is_close = true;
                    }

                    if ($vv['attributes'] || $vv['length']) {
                        $is_custom = true;
                    }
                    $productsDataNew[] = [
                        'products_id' => $vv['products_id'],
                        'orders_products_id' => $vv['products_id'],
                        'products_prid' => $vv['products_prid'],
                        'composite_son_products' => $vv['composite_son_quote_products'],
                        'products_model' => $vv['products_model'],
                        'products_name' => $vv['products_name'],
                        'products_price' => $vv['products_price'],
                        'products_quantity' => $vv['products_qty'],
                        'orders_products_attributes' => $attributes,
                        'orders_products_length' => $length,
                        'is_custom' => $is_custom, //有用参数
                        'is_close' => $is_close, //有用参数
                        'image' => $img,
                        'products_href' => 'products/'.$vv['products_id'].'.html',
                    ];
                }
        }
        $quotes_products = $productsDataNew;

        foreach ($quotes_products as $key => $products) {
            $products['is_clearance'] = 0;      //是否是清仓产品
            $products['clearance_qty'] = 0;     //清仓产品数量
            $config = [];
            if ($products['is_close']) {
                //关闭产品不能加入购物车
                $is_add = false;
                $close_products[] = $products;
            } else {
                //为了防止订单中定制产品丢失属性的再次加购仍然属性丢失的情况 针对没有属性产品查询其是否有属性
                if (!$products['is_custom']) {
                    $paService = new ProductAttributeService();
                    $lengthTotal = $paService->getProductLengthTotal($products['products_id']);
                    $attributeTotal = $paService->getProductAttributeTotal($products['products_id']);
                    //任意一个属性总数不为0 即为定制产品
                    if ($lengthTotal || $attributeTotal) {
                        $products['is_custom'] = true;
                    }
                }

                if (!$products['is_custom']) {
                    //判断是否是清仓产品
                    $is_clearance = get_current_pid_if_is_clearance($products['products_id']);
                    if ($is_clearance) {
                        $products['is_clearance'] = 1;
                        $config['pid'] = $products['products_id'];
                        $shipping_info = new ShippingInfo($config);
                        $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                        $products['clearance_qty'] = $clearance_qty;
                        //判断当前产品是否已经在购物车中
                        if ($_SESSION['cart']->in_cart($products['products_id'])) {
                            $cart_qty = $_SESSION['cart']->contents[$products['products_id']]['qty'];//加购数量
                            if ($clearance_qty >= $cart_qty) {
                                //清仓产品数量 需要减掉购物车中已加购的产品数据
                                $clearance_qty = $clearance_qty - $cart_qty;
                            } else {
                                $clearance_qty = 0;
                            }
                        }
                        if ($clearance_qty >= $products['products_quantity']) {
                            //清仓产品库存大于或者等于当前产品个数允许直接加购
                            if ($status == 3 && $products['products_quantity'] > 0 && in_array($products['products_id'], $add_key)) {
                                $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0);
                            }
                            $add_products[] = $products;
                        } else {
                            $is_add = false;
                            if ($clearance_qty == 0) {
                                //清仓产品无库存
                                $clearance_products_no[] = $products;
                            } else {
                                //清仓产品库存不足
                                $products['products_quantity'] = $clearance_qty;
                                $clearance_products[] = $products;
                                $add_products[] = $products;
                                //将现有的库存数量的清仓产品加入购物车
                                if ($status == 3 && $products['products_quantity'] > 0 && in_array($products['products_id'], $add_key)) {
                                    $_SESSION['cart']->add_cart($products['products_id'], $clearance_qty, '', true, [], 0);
                                }
                            }
                        }
                    } else {
                        //标准产品直接加入购物车
                        if ($status == 3 && $products['products_quantity'] > 0 && in_array($products['products_id'], $add_key)) {
                            $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], '', true, [], 0);
                        }
                        $add_products[] = $products;
                    }
                } else {
                    //针对缺少属性的定制产品直接不让加购
                    if (empty($products['orders_products_length']) && empty($products['orders_products_attributes'])) {
                        $is_add = false;
                        $column_products[] = $products;
                    } else {
                        //判断是否是层级属性定制产品
                        $column_id = zen_get_products_column_id($products['products_id']);
                        if (!$column_id) {
                            //层级属性产品不允许直接加入购物车
                            if ($status == 3 && $products['products_quantity'] > 0 && in_array($products['products_id'], $add_key)) {
                                $real_ids = $opService->createAttributeForAddCart($products);
                                $_SESSION['cart']->add_cart($products['products_id'], $products['products_quantity'], $real_ids, true, [], 0);
                            }
                            $add_products[] = $products;
                        } else {
                            $is_add = false;
                            $column_products[] = $products;
                        }
                    }
                }
            }
        }
        $shopping_cart_help = new shopping_cart_help();
        $html = $topCartHtml = '';
        $noAddProducts = [];
        if ($status == 1) {
            $noAddProducts['close'] = $close_products;
            $noAddProducts['custom'] = $column_products;
            $noAddProducts['clearance'] = $clearance_products;
            $noAddProducts['clearance_no'] = $clearance_products_no;
            //客户第一次点击订单列表页的buy again按钮
            if ($is_add) {
                //可以整单加购 展示加购弹框
                $html = createBuyAgainAddProductsHtml($add_products, $orderData, $type);
            } else {
                //有不能加购的产品
                if (!count($add_products)) {
                    //整单产品都不能加购
                    $html = createBuyMoreProductsHtml($noAddProducts, $quotes_id, $type, false, true);
                } else {
                    //部分产品不能加购
                    $html = createBuyMoreProductsHtml($noAddProducts, $quotes_id, $type, true , true);
                }
            }
        } elseif ($status == 2) {
            //给客户展示不能加购的产品 客户点击skip and continue按钮确认加购 展示可以加购的产品弹窗 供客户修改数量
            $html = createBuyAgainAddProductsHtml($add_products, $orderData, $type);
        } else {
            //客户点击add to cart按钮加购
            $topCartHtml = $shopping_cart_help->show_cart_products_block();
            //产品加购成功弹窗
            $html = products_add_cart_new_popup();
        }
        $data = array('result' => true, 'type' => 2, 'html' => $html, 'topCartHtml' => $topCartHtml);

        $api->setStatus(200)->setMessage('success')->response($data);
        break;

    case 'submit_question':
        $data_post = $_POST;

        $customers_arr = $customers_s->setCustomer()->firstCustomer();

        $user_name = $customers_arr['customers_firstname'] . '.' . $customers_arr['customers_lastname'];
        $user_email = $customers_arr['customers_email_address'];

        $admin_id = $customers_arr['admin_to_customer']['admin_id'];
        $admin_name = $customers_arr['admin_to_customer']['admin_name'];
        $admin_email = $customers_arr['admin_to_customer']['admin_email'];

        $data['languages_code'] = $_SESSION['languages_code'];
        $data['countries_code'] = $_SESSION['countries_iso_code'];
        $data['customer_id'] = $_SESSION['customer_id']; //客户id
        $data['customer_name'] = $user_name; //客户姓名
        $data['customers_email_address'] = $user_email; //客户邮箱
        $data['admin_name'] = $admin_name;//销售人员姓名
        $data['admin_id'] = $admin_id;//销售人员id
        $data['select_star'] = $data_post['select_star'];//星级
        $data['content'] = $data_post['QuestionContent'];//反馈内容
        $data['create_time'] = time();//反馈时间
        $data['status'] = 0;//状态，默认未处理

        $res=zen_db_perform('fs_quotes_question',$data);

        //给销售人员发送邮件，只发英文，客户提交的content保持不变
        if($res){
            $theme = 'New customer feedback of quote function';
            $first_msg = "You received new feedback of quote function, please kindly follow up if necessary.";

            $html = common_email_header_and_footer("Feedback", $first_msg);

            $html_msg['EMAIL_HEADER'] = $html['header'];
            $html_msg['EMAIL_FOOTER'] = $html['footer'];
            $html_msg['EMAIL_ADMIN_NAME'] = $admin_name;
            $html_msg['EMAIL_TITLE'] = ' You received new feedback of quote function, please kindly follow up if necessary.';
            $html_msg['EMAIL_CUSTOMER_NAME'] = $user_name;
            $html_msg['EMAIL_CUSTOMERS_EMAIL'] = $user_email;
            $html_msg['EMAIL_PAGE'] = "Quote success page";
            $html_msg['EMAIL_SELECT_STAR'] = $data_post['select_star'];
            $html_msg['EMAIL_CONTENT'] = $data_post['QuestionContent'];

            sendwebmail($user_name, $admin_email, 'quotes_question:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'quotes_question');
            $api->setStatus(200)->response($res);
        }else{
            $api->setStatus(201)->response($res);
        }
        break;
}
