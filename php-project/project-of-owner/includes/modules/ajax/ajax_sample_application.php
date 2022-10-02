<?php

use App\Services\Common\ApiResponse;
use App\Services\Products\ProductService;
use App\Services\Cases\CaseService;
use App\Services\Customers\CustomerService;
use App\Services\Country\CountryService;
use App\Services\Sample\SampleApplyService;
use App\Request\SampleApplyRequest;

$api = new ApiResponse();

$action = isset($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : '';
require DIR_WS_INCLUDES . 'languages/' . $_SESSION['language'] . '/views/sample_application.php';
switch ($action) {
    case 'get_sample_one_product_info':
        $product_id = (int)zen_db_prepare_input($_POST['product_id']);
        if (!$product_id || !is_numeric($product_id)) {
            $api->setStatus(0)->setMessage('error')->response(FS_SYSTME_BUSY);
        }
        $productService = new ProductService();
        $product_info = $productService->getOneProductInfo((int)$product_id);
        if (!$product_info) {
            $error_tip = str_replace('PRODUCT_ID', $product_id, SAMPLE_APPLICATION_NOT_FOUND);
            $api->setStatus(0)->setMessage('error')->response($error_tip);
        }
        //产品价格
        $product_price = $product_info['products_price'];

        // fairy 2019.2.27 add 组合产品主产品价格
        $is_composite_products = false;
        if (class_exists('classes\CompositeProducts')) {
            $CompositeProducts = new classes\CompositeProducts(intval($product_id));
            $composite_product_price = $CompositeProducts->get_composite_product_price();

            if (!empty($composite_product_price['composite_product_price'])) {
                $is_composite_products = true;
            }
        }
        if ($is_composite_products) {
            $price = $composite_product_price['composite_product_price'];
        } else {
            $currencies_value = $currencies->currencies[$_SESSION['currency']]['value'];
            if ($product_info['integer_state'] != 1) {
                //美元价格
                $related_price = get_products_all_currency_final_price($product_price * $currencies_value);
                $price = $related_price;
                //转成对应币种不带货币符号的价格
                $price = zen_round($price, $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            } else {
                //美元价格
                $related_price = get_products_specail_currency_final_price($product_price * $currencies_value);
                $price = $related_price;
                //转成对应币种不带货币符号的价格
                $price = zen_round($price, $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            }
        }

        $product_href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . (int)$product_id, 'SSL');

        $product_html = '<div class="sample-request-form-content-product-information-detail after">
                    <div class="sample-request-form-content-product-information-detail-con con01">
                        <a href="' . $product_href . '" target="blank">
                           ' . $product_info['source_image'] . '
                        </a>
                    </div>
                    <div class="sample-request-form-content-product-information-detail-con con02">
                        <a href="' . $product_href . '" target="blank">' . $product_info['product_description']['products_name'] . '</a>
                        <span>#' . (int)$product_id . '</span>
                    </div>
                    <div class="sample-request-form-content-product-information-detail-con con03">
                        <input type="text" name="product_num[]" value="1" maxlength="5" min="1" onblur="check_min_qty(this);" onkeyup="onkey(this)" onafterpaste="limit_input_number(this)" class="sam_request_input" autocomplete="off" id="product_num_' . (int)$product_id . '">
                        <input type="hidden" name="products_id[]" value="' . (int)$product_id . '">
                        <input type="hidden" name="products_price[]" value="' . $price . '">
                        <div class="pro_num">
                            <a href="javascript:;" class="shopping_add" onclick="move_cart_quantity_change1(1,this,' . (int)$product_id . ');"></a>
                            <a href="javascript:;" class="cart_reduce shopping_minus choosez" onclick="move_cart_quantity_change1(0,this,' . (int)$product_id . ');"></a>
                        </div>
                    </div>
                    <div class="sample-request-form-content-product-information-detail-con con04">
                        <a href="javascript:;" onclick="del_one_product(this)" class="icon iconfont">&#xf027;</a>
                    </div>
                </div>';
        $api->setStatus(1)->setMessage('success')->response($product_html);
        break;
    case 'submit_sample_apply':
        $customer_email = $_POST['email_address'] ? zen_db_prepare_input($_POST['email_address']) : '';
        //验证信息
        if (get_user_blacklist($customer_email) == true) {
            $api->setStatus(0)->setMessage('error')->response(FS_ACCESS_DENIED_1);
        }

        if(!$_SESSION['customer_id']){
            if($customer_email){
                $customers_id = fs_get_data_from_db_fields('customers_id', 'customers', "customers_email_address='".$customer_email."'",' limit 1');
                if($customers_id){
                    $api->setStatus(405)->setMessage('found')->response(FS_ACCESS_DENIED_1);
                }
            }
            $api->setStatus(404)->setMessage('not found')->response(FS_ACCESS_DENIED_1);
        }

        //$products_ids_data = $_POST['products_id'] ? zen_db_prepare_input($_POST['products_id']) : array();
        //$products_num_data = $_POST['products_num'] ? zen_db_prepare_input($_POST['products_num']) : array();
        //$products_price_data = $_POST['products_price'] ? $_POST['products_price'] : array();
        $products_ids_data = $products_num_data = $products_price_data = array();
        $product_count = $_POST['product_count'] ? (int)$_POST['product_count'] : 0;
        $country_code = zen_db_prepare_input($_POST['country_code']);
        $state_code = $_POST['state'] ? zen_db_prepare_input($_POST['state']) : '';
        $first_name = zen_db_prepare_input($_POST['entry_firstname']);
        $last_name = zen_db_prepare_input($_POST['entry_lastname']);
        $customer_name = $first_name . ' ' . $last_name;
        $entry_telephone = $_POST['entry_telephone'] ? zen_db_prepare_input($_POST['entry_telephone']) : '';
        $entry_street_address = $_POST['entry_street_address'] ? zen_db_prepare_input($_POST['entry_street_address']) : '';
        $entry_suburb = $_POST['entry_suburb'] ? zen_db_prepare_input($_POST['entry_suburb']) : '';
        $entry_postcode = $_POST['entry_postcode'] ? zen_db_prepare_input($_POST['entry_postcode']) : '';
        $entry_city = $_POST['entry_city'] ? zen_db_prepare_input($_POST['entry_city']) : '';
        $question_content = $_POST['comments'] ? str_replace(array('\r\n','\n'), '<br/>', zen_db_input($_POST['comments'])) : '';
        $ticket_number = $_POST['ticket_number'] ? zen_db_input($_POST['ticket_number']) : '';

        $validate_data = array(
            'entry_firstname' => $first_name,
            'entry_lastname' => $last_name,
            'email_address' => $customer_email,
            'entry_telephone' => $entry_telephone,
            'entry_street_address' => $entry_street_address,
            'entry_postcode' => $entry_postcode,
            'entry_city' => $entry_city,
            'entry_suburb' => $entry_suburb,
            'country_id' => zen_db_input($_POST['country_id'])
        );
        $validate = new SampleApplyRequest();
        $validate->data = $validate_data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus('406')->setMessage('error')->response($error);
        }

        $products_data = $_SESSION['sample_cart']['contents'];
        if(!$products_data){
            //没有产品
            $api->setStatus('410')->setMessage('error')->response($products_data);
        }
        $products_count=0;
        foreach ($products_data as $rel=>$item){
            if((int)$item['qty']>0){
                $products_count += 1;
            }
        }
        if($product_count!=$products_count){
            //产品种类和当前页面对应不上
            $api->setStatus('411')->setMessage('error')->response($products_count);
        }

        $currency = $_SESSION['currency'];
        global $currencies;
        $currencies_id = $currencies->currencies[$currency]['currencies_id'];
        //客户国家信息
        $country_data = $state_data = [];
        $countryService = new CountryService();
        $countryService->setCountry('', strtoupper($country_code));
        if ($countryService->currentCountry) {
            $country_data = $countryService->currentCountry->toArray();
            $customers_country_id = $country_data['countries_id'];
            $customer_country_name = $country_data['countries_name'];
        }

        $street_address2 = empty($entry_suburb) ? '' : $entry_suburb.', ';
        $email_state_code = empty($state_code) ? '' : $state_code.', ';
        $eamil_address_info = $entry_street_address.', '.$street_address2.$entry_city.', '.$email_state_code.$entry_postcode.', '.$customer_country_name;
        //分配相关
        $email_address = $customer_email;
        $customer_data = array();
        $customerService = new CustomerService();
        $admin_id = $is_old = 0;
        $customer_level = $customer_number = '';
        $customer_id = $_SESSION['customer_id'] ? $_SESSION['customer_id'] : 0;
        $customerService->setField(['customers_number_new', 'customers_level', 'customers_id', 'is_disabled'])->setCustomer($customer_id, $customer_email);
        if ($customerService->currentCustomer) {
            $customer_data = $customerService->currentCustomer->toArray();
            $customer_id = $customer_data['customers_id'];
            $customer_level = $customer_data['customers_level'];
            $customer_number = $customer_data['customers_number_new'];
            $isDisabled = $customer_data['is_disabled'];
            $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
            $dataInfo = getIsDisabledEmail($customer_number, $isDisabled, $admin_id);
            $admin_id = $dataInfo['admin_id'];
            $reason_type = $dataInfo['reason_type'];
        }
        if(!$customer_id){ //线下客户
            $customers = $customerService->getOfflineCustomer('', $customer_email, ['customers_number_new', 'customers_level', 'customers_id']);
            if (!empty($customers)) {
                $customer_data = $customers->toArray();
                $customer_id = $customer_data['customers_id'];
                $customer_level = $customer_data['customers_level'];
                $customer_number = $customer_data['customers_number_new'];
            }
        }
        $is_old = $customer_id ? $is_old = 1 : 0;
        //不管新老客户 都分配客服
        require(DIR_WS_MODULES . zen_get_module_directory('message_entrance_auto_given.php'));

        /*分配销售*/
        if(!$admin_id){
            $allot_type = 'sample_apply';
            require (DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
        }

        // fairy 2018.8.30 add
        // 如果该项分配当前销售。则也要把该用户分配给当前销售等操作
        if ($customer_email) {
            auto_given_customers_to_admin(array(
                'admin_id' => $admin_id ? $admin_id : 0,
                'email_address' => $customer_email,
                'admin_id_from_table' => $admin_id_from_table,
                'firstname' => $first_name,
                'lastname' => $last_name,
                'country' => $customers_country_id,
                'phone' => $entry_telephone,
                'source' => 11,   // 客户来源：申请样品 sample_application
                'is_old' => $is_old ? $is_old : 0,   // 标记新、老客户
                'customer_number' => $customers_customers_number_new,
                'customer_offline_number' => $offline_customers_number_new,
                'invalidSign' => $invalidSign,
            ));
        }
        //生成 caseNumber 编号
        $caseService = new CaseService();
        $case_data = array(
            'case_from' => '9',
            'customer_email' => $customer_email,
            'admin_id' => $admin_id,
            'service_admin' => $service_ids,
            'area' => $area,
            'question_content' => $question_content,
        );
        $caseNumber = $caseService->createCaseNumber($case_data);


        //$attributes_data = array();
        foreach ($products_data as $k=>$v){
            $products_ids_data[] = (int)$k;
            $products_num_data[] = $v['qty'];
            $products_price_data[] = $v['original_price'];
            //if(sizeof($v) > 2){
            //    $attributes_data[$k] = $v;
            //}
        }
        $products_id = $products_ids_data ? join(',', $products_ids_data) : '';
        $products_num = $products_num_data ? join(',', $products_num_data) : '';
        //单价
        $products_price = $products_price_data ? join(',', $products_price_data) : '';

        //总价
        $total_price = 0;
        if ($products_price_data) {
            foreach ($products_price_data as $key => $val) {
                $total_price += $val * (int)$products_num_data[$key];
            }
        }

        $sample_data = array(
            'service_admin' => $service_ids ? $service_ids : '',
            'customers_country_id' => $customers_country_id,
            'area' => $area ? $area : '',
            'apply_date' => date('Y-m-d H:i:s'),
            'currencies_id' => $currencies_id,
            'sample_money' => $total_price,
            'sale_admin' => $admin_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'category' => 1,
            'customers_NO' => $customer_number ? $customer_number : '',
            'customers_level' => $customer_level ? $customer_level : '',
            'products_id' => $products_id,
            'products_num' => $products_num,
            'products_price_total' => $products_price,
            'is_old' => $is_old,
            'entry_telephone' => $entry_telephone,
            'entry_street_address' => $entry_street_address,
            'entry_suburb' => $entry_suburb,
            'entry_city' => $entry_city,
            'entry_postcode' => $entry_postcode,
            'entry_state' => $state_code,
            'sample_remark' => $question_content,
            'case_number' => $caseNumber,
            'status' => -1,
            'ticket_number' => (int)$ticket_number,
            //'products_attributes' => json_encode($attributes_data)
        );
        $sampleService = new SampleApplyService();
        $info = $sampleService->createSample($sample_data);
        if ($info) {
            unset($_SESSION['sample_cart']);
            //发送邮件
            $html_msg = array();
            get_email_langpac();
            if ($_SESSION['language_code'] == "jp") {
                $title_info = "リクエスト受領済み";
            } else {
                $title_info = FS_SEND_EMAIL_3;
            }
            $html = common_email_header_and_footer($title_info, FS_SEND_EMAIL_84);
            $html_msg['EMAIL_HEADER'] = $html['header'];
            $html_msg['EMAIL_FOOTER'] = $html['footer'];
            //采用新版的邮件模板
            $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                                                    ' . SAMPLE_EMAIL_DEAR . ' ' . ucwords($customer_name) . FS_EMAIL_COMMA . '
                                                </td>
                                            </tr>
                                        </tbody>
                                   </table>';
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                                    ' . SAMPLE_EMAIL_01 . '
                                                </td>
                                            </tr>
                                        </tbody>
                                     </table>';
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                                    ' . str_replace('###case_number###', $caseNumber, SAMPLE_EMAIL_02) . '
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                                    ' . SAMPLE_EMAIL_03 . ucwords($customer_name) . '<br>
                                                    ' . SAMPLE_EMAIL_04 . '<a style="text-decoration: none;color: #0070bc;" href="mailto:' . $customer_email . '">' . $customer_email . '</a> <br>
                                                    ' . SAMPLE_EMAIL_05 . $customer_country_name . ' <br>
                                                    ' . SAMPLE_EMAIL_06 . '<a style="text-decoration: none;color: #0070bc;" href="javascript:;">' . $entry_telephone . '</a> <br>
                                                    ' . SAMPLE_EMAIL_31 . $eamil_address_info . ' <br>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="20">
                    
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">
                                                    '.SAMPLE_EMAIL_33.'
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>';

            $products_info = '';
            foreach ($products_ids_data as $key => $products_id_rel){
                $products_num_rel = $products_num_data[$key];
                $products_info .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 20px 0;">
                                <tbody>
                                <tr>
                                    <td width="60" valign="middle" style="border-collapse: collapse;">
                                        <a style="text-decoration: none" href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $products_id_rel).'">
                                            '.get_resources_img($products_id_rel,60,60).'
                                        </a>
                                    </td>
                                    <td valign="middle" style="border-collapse: collapse;padding-left: 20px;color: #333;text-decoration: none;font-size: 14px;font-family: Open Sans,arial,sans-serif;line-height: 22px">
                                        <a style="color: #333;text-decoration: none;font-size: 14px;line-height: 22px;font-family: Open Sans,arial,sans-serif;margin-bottom: 5px;display: inline-block" href="'.zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $products_id_rel).'">
                                            '.zen_get_products_name($products_id_rel).'
                                            <span style="color: #999;font-family: Open Sans,arial,sans-serif;">#'.$products_id_rel.'</span>
                                        </a>
                                        <br>

                                        '.SAMPLE_EMAIL_32.$products_num_rel.'
                                    </td>
                                </tr>
                                </tbody>
                            </table>';

                if(count($products_ids_data) != $key + 1) {
                    $products_info .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;border-top: 1px solid #f7f8f9">

                                    </td>
                                </tr>
                                </tbody>
                            </table>';
                }
            }

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;border-top: 1px solid #f7f8f9;border-bottom: 1px solid #f7f8f9">
                                                    '.$products_info.'
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>';

            if ($question_content) {
                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">
                                                   ' . SAMPLE_EMAIL_07 . '
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                                    ' . $question_content . '
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';
            }
            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="background-color: #fff;border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                                                    ' . SAMPLE_EMAIL_08 . '
                                                    <br>
                                                    ' . SAMPLE_EMAIL_09 . '
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#f5f6f7" style="background-color: #fff;border-collapse: collapse" height="20">
                        
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>';

            if ($_SESSION['languages_code'] == "jp") {
                $subject_title = "FS - サンプルお申し込み" . $caseNumber . "は既に受領されました";
            } else {
                $subject_title = FS_SEND_EMAIL_90 . $caseNumber;
            }
            if ($customer_email) {
                sendwebmail($customer_name, $customer_email, '样品申请客户提醒:' . date('Y-m-d H:i:s', time()), STORE_NAME, $subject_title, $html_msg, 'default');
            }

            if($admin_id){
                $adminInfo = getAdminInfo($admin_id);
                sendwebmail($adminInfo['name'], $adminInfo['email'], '样品申请客服提醒:' . date('Y-m-d H:i:s', time()), STORE_NAME, $subject_title, $html_msg, 'default');
            }

            if($service_email && getIsSendServiceEmail()) {
                sendwebmail($service_name, $service_email, '样品申请客服提醒:' . date('Y-m-d H:i:s', time()), STORE_NAME, $subject_title, $html_msg, 'default');
            }

            $api->setStatus(1)->setMessage('success')->response($caseNumber);
        }
        break;
}