<?php
/**
 * functions_customers
 *
 * @package functions
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_customers.php 4793 2006-10-20 05:25:20Z ajeh $
 */

////
// Returns the address_format_id for the given country
// TABLES: countries;
  function zen_get_address_format_id($country_id) {
    global $db;
    $address_format_query = "select address_format_id as format_id
                             from " . TABLE_COUNTRIES . "
                             where countries_id = '" . (int)$country_id . "'";

    $address_format = $db->Execute($address_format_query);

    if ($address_format->RecordCount() > 0) {
      return $address_format->fields['format_id'];
    } else {
      return '1';
    }
  }

////
// Return a formatted address
// TABLES: address_format
  function zen_address_format($address_format_id, $address, $html, $boln, $eoln) {
    global $db;
    $address_format_query = "select address_format as format
                             from " . TABLE_ADDRESS_FORMAT . "
                             where address_format_id = '" . (int)$address_format_id . "'";

    $address_format = $db->Execute($address_format_query);
    $company = zen_output_string_protected($address['company']);
    if (isset($address['firstname']) && zen_not_null($address['firstname'])) {
      $firstname = zen_output_string_protected($address['firstname']);
      $lastname = zen_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && zen_not_null($address['name'])) {
      $firstname = zen_output_string_protected($address['name']);
      $lastname = '';
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = zen_output_string_protected($address['street_address']);
    $suburb = zen_output_string_protected($address['suburb']);
    $city = zen_output_string_protected($address['city']);
    $state = zen_output_string_protected($address['state']);
    if (isset($address['country_id']) && zen_not_null($address['country_id'])) {
      $country = zen_get_country_name($address['country_id']);

      if (isset($address['zone_id']) && zen_not_null($address['zone_id'])) {
        $state = zen_get_zone_code($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && zen_not_null($address['country'])) {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    } else {
      $country = '';
    }
    $postcode = zen_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') {
      if (is_array($address['country'])) {
        $country = zen_output_string_protected($address['country']['countries_name']);
      } else {
      $country = zen_output_string_protected($address['country']);
      }
    }
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format->fields['format'];
    //eval("\$address_out = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (zen_not_null($company)) ) {
      $address_out = $company . $cr . $address_out;
    }

    return $address_out;
  }

////
// Return a formatted address
// TABLES: customers, address_book
  function zen_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n") {
    global $db;
    $address_query = "select entry_firstname as firstname, entry_lastname as lastname,
                             entry_company as company, entry_street_address as street_address,
                             entry_suburb as suburb, entry_city as city, entry_postcode as postcode,
                             entry_state as state, entry_zone_id as zone_id,
                             entry_country_id as country_id
                      from " . TABLE_ADDRESS_BOOK . "
                      where customers_id = '" . (int)$customers_id . "'
                      and address_book_id = '" . (int)$address_id . "'";

    $address = $db->Execute($address_query);

    $format_id = zen_get_address_format_id($address->fields['country_id']);
    return zen_address_format($format_id, $address->fields, $html, $boln, $eoln);
  }

////
// Return a customer greeting
  function zen_customer_greeting() {

    if (isset($_SESSION['customer_id']) && $_SESSION['customer_first_name']) {
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, zen_output_string_protected($_SESSION['customer_first_name']), zen_href_link(FILENAME_PRODUCTS_NEW));
    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, zen_href_link(FILENAME_LOGIN, '', 'SSL'), zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }

    return $greeting_string;
  }

  function zen_count_customer_orders($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $orders_check_query = "select count(*) as total
                           from " . TABLE_ORDERS . "
                           where customers_id = '" . (int)$id . "'";

    $orders_check = $db->Execute($orders_check_query);

    return $orders_check->fields['total'];
  }

  function zen_count_customer_address_book_entries($id = '', $check_session = true) {
    global $db;

    if (is_numeric($id) == false) {
      if ($_SESSION['customer_id']) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( ($_SESSION['customer_id'] == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = "select count(*) as total
                        from " . TABLE_ADDRESS_BOOK . "
                        where customers_id = '" . (int)$id . "'";

    $addresses = $db->Execute($addresses_query);

    return $addresses->fields['total'];
  }

////
// validate customer matches session
  function zen_get_customer_validate_session($customer_id) {
    global $db, $messageStack;
    $zc_check_customer = $db->Execute("SELECT customers_id from " . TABLE_CUSTOMERS . " WHERE customers_id=" . (int)$customer_id);
      if ($zc_check_customer->RecordCount() <= 0) {
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET . " WHERE customers_id= " . $customer_id);
      $db->Execute("DELETE from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " WHERE customers_id= " . $customer_id);
      unset($_SESSION['customer_id']);
      $messageStack->add_session('header', ERROR_CUSTOMERS_ID_INVALID, 'error');
      return false;
    }
    return true;
  }

    // 获取当前用户的等级，1个人用户。2企业账号。3申请中
    function zen_get_customer_level($customer_email){
        global $db;
        $customer_email = zen_output_string_protected($customer_email);

        $sql = 'select member_level from '.TABLE_CUSTOMERS.'  where customers_email_address="'.$customer_email.'" limit 1';
        $customer = $db->Execute($sql);

        if ($customer->RecordCount() > 0) {
            if($customer->fields['member_level'] == '2'){
                return '2';
            }else {
                $sql = 'select parent_id from partner_register where company_email="'. $customer_email.'" limit 1';
                $partner = $db->Execute($sql);
                if ($partner->fields['parent_id']) {
                    return '3';
                } else {
                    return '1';
                }
            }
        } else { // 不存在该用户
            return false;
        }
    }

    // fairy 插入一条当前用户的登录
    function zen_insert_one_customers_login($customers_id,$from_where){
        global $db;
        $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
        $user_ip_address = getCustomersIP();
        $login_device = '';
        if($http_user_agent){
            preg_match('/^.*?\((.*?)\).*?$/',$http_user_agent,$match);
            $login_device = $match[1];
        }
        $login_device_type = 0;
        if($http_user_agent){
            if(is_mobile_request()){ // 如果是手机的话
                $login_device_type = 2;
            }else{
                $login_device_type = 1;
            }
        }
        $sql = 'Insert into customers_login (
                    `customers_id`,
                    `http_user_agent`,
                    `login_device`,
                    `login_device_type`,
                    `ip_address`,
                    `from_where`,
                    `language_id`,
                    `add_time`
                ) VALUES (
                    "'.$customers_id.'",
                    "'.$http_user_agent.'",
                    "'.$login_device.'",
                    "'.$login_device_type.'",
                    "'.$user_ip_address.'",
                    "'.$from_where.'",
                    "'.$_SESSION['languages_id'].'",
                    "'.time().'"
                )';
        $db->Execute($sql);
        $last_customers_login_id = $db->insert_ID();
        return $last_customers_login_id;
    }

    // 2018.??? fairy 更新用户的
    function zen_update_one_customers_info($customers_id){
        global $db;

        $is_exist = 'select customers_info_id from '.TABLE_CUSTOMERS_INFO.' WHERE customers_info_id ='.(int)$customers_id;
        $is_exist = $db->Execute($is_exist);
        if ($is_exist->RecordCount()){ // 如果存在，更新
            $last_address = getCustomersIP();
            $sql = "UPDATE ".TABLE_CUSTOMERS_INFO." SET 
                                customers_info_date_of_last_logon = now(),
                                customers_info_address_of_last_logon = '".$last_address."',
                                customers_info_number_of_logons = customers_info_number_of_logons+1
                                WHERE customers_info_id = :customersID";
            $sql = $db->bindVars($sql, ':customersID',  $customers_id, 'integer');
            $db->Execute($sql);
        }else{ // 如果不存在，添加
            $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                              (customers_info_id, customers_info_number_of_logons,
                               customers_info_date_account_created, customers_info_date_of_last_logon)
                    values ('" . ( int ) $customers_id . "', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
            $db->Execute ( $sql );
        }
    }

    // 2018.??? 设置登录session信息，cookie信息
    function set_login_session($result,$password='',$is_object_type=true){
        if(!$is_object_type){
            $result = (object)$result;
        }
        require_once DIR_WS_CLASSES . 'set_cookie.php';
        $Encryption = new Encryption;

        $_SESSION ['customer_id'] = $result->fields['customers_id'];
        $_SESSION ['customer_first_name'] = $result->fields['customers_firstname'];
        $_SESSION ['customer_last_name'] = $result->fields['customers_lastname'];
        $_SESSION['customers_email_address'] = $result->fields['customers_email_address'];
        $_SESSION['name'] = $result->fields['customers_firstname'] . ' ' . $result->fields['customers_lastname'];
        $_SESSION['customer_default_address_id'] = $result->fields['customers_default_address_id'];
        $_SESSION['customers_authorization'] = $result->fields['customers_authorization'];
        if($password){
            $_SESSION['customers_password'] = $Encryption->_encrypt($password);
        }
        $_SESSION['member_level'] = $result->fields['member_level']?$result->fields['member_level']:1;
        set_login_id();
        //set cookie for customer_id
        $cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
        setcookie("fs_login_cookie", $cookie_customer_encrypt, time() + 86400 * 365, "/");

        // 将用户的save for later 里面的数据，提取到session中
        global $db;
        $saved_query = $db->getAll("SELECT user_save_time,cart_value FROM customers_saved WHERE customer_id=" . $result->fields['customers_id'] . " and languages_id = " . (int)$_SESSION['languages_id'] . "  order by add_time desc");
        $saved_query_array = "";
        if (!empty($saved_query)) {
            foreach ($saved_query as $key => $value) {
                if ($value) {
                    $saved_query_array[(string)$value['user_save_time']] = $value['cart_value'];
                }
            }
            if (!empty($_SESSION['user_save_cart'])) {
                unset($_SESSION['user_save_cart']);
                $_SESSION['user_save_cart'] = $saved_query_array;
            } else {
                $_SESSION['user_save_cart'] = $saved_query_array;
            }
        }
    }

    // 2018.??? 登录跳转
    function return_login_jump_url(){
        $jump_url = '';
        if (sizeof($_SESSION['navigation']->snapshot) > 0) {
            if ('product_info' == $_SESSION['navigation']->snapshot['page']){
                $origin_nonssl_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), 'NONSSL');
            }else{
                $origin_href = zen_href_link($_SESSION['navigation']->snapshot['page'], zen_array_to_string($_SESSION['navigation']->snapshot['get'], array(zen_session_name())), $_SESSION['navigation']->snapshot['mode']);
            }
            $_SESSION['navigation']->clear_snapshot();

            if (isset($origin_href)){
                //zen_redirect($origin_href);
                $jump_url = $origin_href;
            }elseif (isset($origin_nonssl_href)){
                //zen_nonssl_redirect($origin_nonssl_href);
                $jump_url = $origin_nonssl_href;
            }
        } else {
            if(!empty($_GET['flag']) && isset($_GET['flag'])){
                $supportid = fliter_escape($_GET['flag']);
                //zen_redirect(zen_href_link('support_detail','&supportid='.$supportid));
                $jump_url = zen_href_link('support_detail','&supportid='.$supportid);
            }else{
                //zen_redirect(zen_href_link(FILENAME_MY_DASHBOARD,'', $request_type));
                $jump_url = FILENAME_MY_DASHBOARD;
            }
        }
        return $jump_url;
    }

    // 发送异地登录的邮件
    function sendOffsiteLogin($email_address,$email_username){
        // send the email
        $html=zen_get_corresponding_languages_email_common();
        $html_msg['EMAIL_HEADER'] = $html['html_header'];
        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];

        $emailCity = $_SESSION['user_ip_info']['ipCountryName'];
        $emailPlatform = getUserOS();
        $ip_address = getCustomersIP();

        $email_title =str_replace('EMAIL_USER_DEVICE',$emailPlatform,FS_OFFSITE_LOGIN_EAMIL_TITLE);
        $emailContent1 = str_replace('EMAIL_USER_EMAIL',$email_address,FS_OFFSITE_LOGIN_EAMIL_CONTENT1);
        $emailTime = gmdate('m/d/Y H:i').'(GMT)';
        
        $html_msg['EMAIL_BODY'] = '
        <table style="line-height: 20px;">
            <tr><td colspan="2" style="font-size:15px; font-weight:600;">'.$email_title.'</td></tr>
            <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_BODY_COMMON_DEAR.' '.$email_username.',</td></tr>
            <tr><td colspan="2" style="padding-top:20px;">'.$emailContent1.'</td></tr>
            <tr>
                <td colspan="2" style="padding-top:20px;">
                    '.FS_OFFSITE_LOGIN_EAMIL_LOCATION.': <b>'.$emailCity.'</b><br />
                    '.EMAIL_BODY_COMMON_PLATFORM.': <b>'.$emailPlatform.'</b><br />
                    '.EMAIL_BODY_COMMON_IP_ADDRESS.': <b>'.$ip_address.'</b><br />
                    '.FS_OFFSITE_LOGIN_EAMIL_TIME.': <b>'.$emailTime.'</b>
                </td>
            </tr>
            <tr><td colspan="2" style="padding-top:20px;">'.FS_OFFSITE_LOGIN_EAMIL_CONTENT2.'</td></tr>
            <tr><td colspan="2" style="padding-top:20px;">'.FS_OFFSITE_LOGIN_EAMIL_CONTENT3.'</td></tr>
            <tr><td colspan="2" style="padding-top:20px;">'.EMAIL_FOOTER_SINCERELY.'</td></tr>
            <tr><td colspan="2" style="padding-top:20px; padding-bottom:10px;">'.EMAIL_FOOTER_FS_SERVICE.'</td></tr>
        </table>';
        zen_mail($email_username, $email_address, FS_OFFSITE_LOGIN_EAMIL_THEME,'', STORE_NAME, EMAIL_FROM, $html_msg,'default');
    }

    // 判断是否异步登录
    function isOffsiteLogin($customers_login_id){
        if(!FS_OPEN_OFFSITE_LOGIN_EMAIL_TIP){ // 是否开启异步邮件提醒
            return false;
        }
        global $db;

        $sql = 'select customers_id,login_device,ip_address,login_device_type,add_time from customers_login where customers_login_id="'.$customers_login_id.'" limit 1';
        $current_customers_login = $db->getAll($sql);
        $current_customers_login = $current_customers_login[0];

        // 第一次登录、电脑登陆(对于以前没有登录信息的老用户，则有第一次登录的情况)，不发邮件
        $sql = 'select customers_login_id,ip_address from customers_login 
            where customers_id="'.$current_customers_login['customers_id'].'" and  customers_login_id!="'.$customers_login_id.'"
            order by customers_login_id asc limit 1';
        $first_customers_login = $db->getAll($sql);
        $first_customers_login = $first_customers_login[0];
        if(!$first_customers_login){
            return false;
        }

        if($current_customers_login['login_device_type'] == 2){ // 如果是手机的话
            $sql = 'select customers_login_id from customers_login 
            where customers_id="'.$current_customers_login['customers_id'].'" and login_device="'.$current_customers_login['login_device'].'" and login_device_type=2 and customers_login_id!="'.$customers_login_id.'"
            order by customers_login_id asc limit 1';
            $exist_customers_login1 = $db->getAll($sql);
            $exist_customers_login1 = $exist_customers_login1[0];
            if(!$exist_customers_login1){
                return true;
            }else{
                return false;
            }
        }else{
            // 第一次电脑登陆，不发邮件
            $sql = 'select customers_login_id,ip_address from customers_login 
            where customers_id="'.$current_customers_login['customers_id'].'" and  customers_login_id!="'.$customers_login_id.'" and login_device_type=1
            order by customers_login_id asc limit 1';
            $first_pc_customers_login = $db->getAll($sql);
            $first_pc_customers_login = $first_pc_customers_login[0];
            if(!$first_pc_customers_login){
                return false;
            }
            
            if($current_customers_login['ip_address'] == $first_pc_customers_login['ip_address']){ // 如果和第一次登录的ip一样，则不是异步登录
                return false;
            }
            $sql = 'select customers_login_id,add_time from customers_login 
            where customers_id="'.$current_customers_login['customers_id'].'" and ip_address="'.$current_customers_login['ip_address'].'" and login_device_type=1 and customers_login_id!="'.$customers_login_id.'"
            order by customers_login_id asc limit 1 ';
            $exist_customers_login2 = $db->getAll($sql);
            $exist_customers_login2 = $exist_customers_login2[0];
            if(!$exist_customers_login2['customers_login_id']){ // 以前没有该ip，则是异步登录
                return true;
            }else{
                return false;
            }
        }
    }

    // 2018.3.13 fairy 注册、修改邮箱等 验证邮箱
    // 使用公共的语言包
    function commonRegistCheckEmail($email_address){
        if(!empty($email_address)){
            global $db;
            $check_email_query = "select count(customers_id) as total from " . TABLE_CUSTOMERS . "
            where customers_email_address = '" . $email_address . "'";
            $check_email = $db->Execute ( $check_email_query );
            if ($check_email->fields['total'] > 0 ) {
                return array('status'=>'0','data'=>'','info'=>FS_EMAIL_HAS_REGISTERED_TIP);
            }
            $check_email_query = "select count(*) as total from partner_register where company_email = '" . $email_address . "'";
            $check_email = $db->Execute ( $check_email_query );
            if ($check_email->fields['total'] > 0 ) {
                return array('status'=>'0','data'=>'','info'=>FS_EMAIL_HAS_REGISTERED_TIP);
            }

            return array('status'=>'1','data'=>'','info'=>'');
        }else{
            return array('status'=>'0','data'=>'','info'=>FS_EMAIL_REQUIRED_TIP);
        }
    }

    // fairy 企业注册升级 验证邮箱函数
    function parnerCheckEmail($email_address,$current_action){
        if (!empty($email_address)) {
            global $db;
        $sql = " select customers_id as id,email_is_active from customers where customers_email_address = '" . $email_address . "' ";
            $customer = $db->Execute($sql);

            if ($current_action == 'upgrade') { // 升级
                // 是否已经注册过企业（在partner_register表里面存在）
                if (zen_get_customer_has_submit_partner($email_address)) {
                    return array('status' => '0', 'data' => '', 'info' => FS_APPLY_BUEINESS_EXIST_TIP);
                }

                if (!$customer->fields['id']) {
                    // 升级的话，必须存在该用户
                    return array('status' => '0', 'data' => '', 'info' => FS_EMAIL_NOT_FOUND_TIP);
                }
                if ($customer->fields['email_is_active'] == 0) { // 如果用户没有激活
                    // 升级的话，必须存在该用户
                    return array('status' => '0', 'data' => '', 'info' => FS_EMAIL_NOT_ACTIVED_TIP);
                }
            } else { //注册
                if ($customer->fields['id'] || zen_get_customer_has_submit_partner($email_address)) {
                    return array('status' => '0', 'data' => '', 'info' => FS_EMAIL_HAS_REGISTERED_TIP);
                }
            }
            return array('status' => '1', 'data' => '', 'info' => '');
        }else{
            return array('status' => '0', 'data' => '', 'info' => FS_EMAIL_REQUIRED_TIP);
        }
    }

    // fairy 2018.8.30 add 把该客户，分配给销售
            function auto_given_customers_to_admin($data,$is_from_order = false){
        if(($data['email_address'] || $data['customers_id']) && $data['admin_id']){
            global $db;
            $admin_id = $data['admin_id'];
            $email_address = $data['email_address'];
            $admin_id_from_table = $data['admin_id_from_table'];
            $firstname = $data['firstname']?$data['firstname']:'';
            $lastname = $data['lastname']?$data['lastname']:'';
            $nick = $data['nick']?$data['nick']:'';
            $telephone = $data['telephone']?$data['telephone']:'';
            $country = $data['country']?$data['country']:'';
            $company = $data['company']?$data['company']:'';
            $source = $data['source'] ? $data['source'] : 0;       // 标注客户来源，例如：get a quote
            $is_old = $data['is_old'] ? $data['is_old'] : 0;       // 标注新、老客户
            $customers_newsletter = $data['customers_newsletter'] ? $data['customers_newsletter'] : 1;
            $from_auto_file = $data['from_auto_file'] ? $data['from_auto_file'] : "message_entrance_auto_given";
            $is_make_up = $data['is_make_up'] ? : 0;
            $is_offline = in_array($data['is_offline'], [1,2]) ? $data['is_offline'] : 2; //该变量未使用，废弃
            $customer_info = [];
            
            $customer_number = $data['customer_number'] ? $data['customer_number'] : '';
            $customer_offline_number = $data['customer_offline_number'] ? $data['customer_offline_number'] : '';
            $invalidSign = $data['invalidSign'] ? $data['invalidSign'] : 0;
            if (isset($data['community_mail_subscribe']) && !empty($data['community_mail_subscribe'])) {
                $communityMailSubscribe = $data['community_mail_subscribe'];
            } else {
                $communityMailSubscribe = 0;
            }

            if(!isset($data['customers_id'])){
                $sql = 'select customers_id,manage_type from customers WHERE customers_email_address="'.$email_address.'" limit 1';
                $customers_id = $db->getAll($sql);
                $manage_type =$customers_id[0]['manage_type'];
                $customers_id = $customers_id[0]['customers_id'];
            }else{
                $customers_id = $data['customers_id'];
                if ($customers_id) {
                    $manage_type = fs_get_data_from_db_fields('manage_type','customers','customers_id='.(int)$customers_id,'limit 1');
                }
            }

            // 分配线上客户
            // 如果分配的依据本来就是线上客户，则不需要分配线上客户
            if($admin_id_from_table != 'admin_to_customers'){
                if($customers_id){
                    $sql = 'select customers_id from admin_to_customers WHERE customers_id='.$customers_id.' limit 1';
                    $exist_id = $db->getAll($sql);
                    $exist_id = $exist_id[0]['customers_id'];
                    if($exist_id){
                        $sql = 'update admin_to_customers ATC
                        left join customers C on ATC.customers_id= C.customers_id
                        set ATC.admin_id="'.$data['admin_id'].'",C.is_make_up="'.$is_make_up.'" 
                        where ATC.customers_id="'.$customers_id.'" and ATC.admin_id=0 and C.is_disabled = 0 ';
                    }else{
                        $date = get_common_cn_time();
                        $sql = 'INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) 
                        VALUE("'. $admin_id . '","' . $customers_id . '","'.$date.'","'.time().'")';
                    }
                    $db->Execute($sql);
                    if ($manage_type == 0) {
                        auto_given_customer_manage($admin_id,$email_address,$is_offline,$customer_info);
                    }
                }
            }

            // 分配线下客户
            // 如果分配的依据本来就是线下客户，则不需要分配线下客户
            if($admin_id_from_table != 'customers_offline') {
                $sql = 'select customers_id,manage_type from customers_offline WHERE customers_email_address="' . $email_address . '" limit 1';
                $exist_id = $db->getAll($sql);
                $manage_type = $exist_id[0]['manage_type'];
                $exist_id = $exist_id[0]['customers_id'];
                if ($exist_id) {
                    $sql = 'update customers_offline set admin_id="' . $admin_id . '",is_make_up="'.$is_make_up.'" where customers_id="' . $exist_id . '" and is_disabled = 0 and admin_id=0 ';
                    $db->Execute($sql);
                    if ($manage_type == 0) {
                        auto_given_customer_manage($admin_id,$email_address,$is_offline,$customer_info);
                    }
                } else {
                    //是否在线上用户表、线下用户表存在。不存在是新的，需要添加线下客户表
                    if (!$customers_id) {
                        //$prefix = 'lock_customers_offline';
                        $key = $email_address;
                        if (setnx_redis_key_value($key, $key)) { //加redis锁 防止重复录入数据
                            $is_mobile = isMobile() ? 2 : 1;
                            $sql = 'insert into customers_offline (
                                customers_firstname,
                                customers_lastname,
                                customers_nick,
                                customers_telephone,
                                customers_level,
                                customers_email_address,
                                customer_country_id,
                                customers_company,
                                addtime,
                                admin_id,
                                customers_newsletter,
                                is_make_up,
                                source,
                                is_old,
                                from_where,
                                community_mail_subscribe
                            ) VALUES (
                                "'.$firstname.'",
                                "'.$lastname.'",
                                "'.$nick.'",
                                "'.$telephone.'",
                                "",
                                "'.$email_address.'",
                                "'.$country.'",
                                "'.$company.'",
                                "'.date("Y-m-d H:i:s").'",
                                "'.$admin_id.'",
                                "'.$customers_newsletter.'",
                                "'.$is_make_up.'",
                                "'.$source.'",
                                "'.$is_old.'",
                                "'.$is_mobile.'",
                                "'.$communityMailSubscribe.'"
                            )';
                        }


//                        if($is_insert_offline) {
                            try {
                                $db->query($sql);
                                $off_customer_id = $db->insert_ID();
                                if (!del_redis_by_key($key)) { //删除锁
                                    set_redis_key_expire($key, 5);  //如果删除失败，设置5s过期
                                };

                                $off_customer_number = $db->getAll("SELECT customers_number_new FROM customers_offline WHERE customers_id=".(int)$off_customer_id.' limit 1');
                                $customer_info = array(
                                    'customers_id' => $off_customer_id,
                                    'customers_number_new' => $off_customer_number[0]['customers_number_new'],
                                );
                            } catch (\Exception $e) {
                                $data_log_arr = ['msg' => $e->getMessage()];
                                $data_log = array(
                                    'customers_email' => '数据:'.json_encode($data_log_arr),
                                    'created_at' => date("Y-m-d H:i:s"),
                                    'customers_email_2' => $email_address,
                                    'case_number' => '录入线下表加redis锁日志',
                                );
                                zen_db_perform('customer_service_log',$data_log);
                            }

                            //录入为线下客户之后，进行客户自动关联
                            if($off_customer_id){
                                if($data['orders_id']){
                                    $orders = new order($data['orders_id']);
                                    $delivery = $orders->delivery;
                                    $billing = $orders->billing;
                                    if($delivery){
                                        //游客下单收货地址添加到线下地址表
                                        $delivery_address = array(
                                            'address_type' => 1,
                                            'customers_id' => $off_customer_id,
                                            'company_type' => (int)($delivery['company_type']=='BusinessType') ? 1 : 2,
                                            'entry_company' => $delivery['company'],
                                            'entry_firstname' => $delivery['name'],
                                            'entry_lastname' => $delivery['lastname'],
                                            'entry_street_address' => $delivery['street_address'],
                                            'entry_suburb' => $delivery['suburb'],
                                            'entry_postcode' => $delivery['postcode'],
                                            'entry_city' => $delivery['city'],
                                            'entry_state' => $delivery['state'],
                                            'entry_country_id' => fs_get_data_from_db_fields('countries_id','countries','countries_name="'.$delivery['country'].'"','limit 1'),
                                            'entry_telephone' => $delivery['telephone'],
                                            'entry_tax_number' => $delivery['tax_number'],
                                        );
                                        zen_db_perform('address_offline_book',$delivery_address);
                                    }
                                    if($billing){
                                        //游客下单账单地址添加到线下地址表
                                        $billing_address = array(
                                            'address_type' => 2,
                                            'company_type' => (int)($billing['company_type']=='BusinessType') ? 1 : 2,
                                            'customers_id' => $off_customer_id,
                                            'entry_company' => $billing['company'],
                                            'entry_firstname' => $billing['name'],
                                            'entry_lastname' => $billing['lastname'],
                                            'entry_street_address' => $billing['street_address'],
                                            'entry_suburb' => $billing['suburb'],
                                            'entry_postcode' => $billing['postcode'],
                                            'entry_city' => $billing['city'],
                                            'entry_state' => $billing['state'],
                                            'entry_country_id' => fs_get_data_from_db_fields('countries_id','countries','countries_name="'.$billing['country'].'"','limit 1'),
                                            'entry_telephone' => $billing['telephone'],
                                            'entry_tax_number' => $billing['tax_number'],
                                        );
                                        zen_db_perform('address_offline_book',$billing_address);
                                    }
                                    $currencies_id = fs_get_data_from_db_fields('currencies_id','currencies','code = "'.$orders->info['currency'].'"','limit 1');
                                }
                            }
                            if(!$is_from_order){
                                if ($currencies_id) {
                                    $customer_info = array_merge((array)$customer_info,array('currencies_id'=>$currencies_id));
                                }
                                auto_given_customer_manage($admin_id,$email_address,$is_offline,$customer_info);
                            }
//                        }
                    }
                }
            }




            // 自动分配公海客户
            $seanArr = array(
                'email_address' => $email_address,
                'customer_number' => $customer_number,
                'customer_offline_number' => $customer_offline_number,
                'invalidSign' => $invalidSign,
                'source' => $source,
            );
            auto_given_open_seas_customers($seanArr,$admin_id);
        }
    }

    //前台留言入口新客户录入线下客户表  已废弃 2021.1.15 dylan
    function new_customers_to_offline_customers($data)
    {
        global $db;
        if ($data['email_address']) {
            $email_address = $data['email_address'];
            $firstname = $data['firstname'] ? $data['firstname'] : '';
            $lastname = $data['lastname'] ? $data['lastname'] : '';
            $nick = $data['nick'] ? $data['nick'] : '';
            $telephone = $data['telephone'] ? $data['telephone'] : '';
            $country = $data['country'] ? $data['country'] : '';
            $company = $data['company'] ? $data['company'] : '';
            $source = $data['source'] ? $data['source'] : 0;
            $customer_id = fs_get_data_from_db_fields('customers_id', 'customers', 'customers_email_address="' . $data['email_address'] . '"', '');
            if (!$customer_id) {
                $offline_customers_id = fs_get_data_from_db_fields('customers_id', 'customers_offline', 'customers_email_address="' . $data['email_address'] . '"');
                if (!$offline_customers_id) {
                    $sql = 'insert into customers_offline (
                                customers_firstname,
                                customers_lastname,
                                customers_nick,
                                customers_telephone,
                                customers_level,
                                customers_email_address,
                                customer_country_id,
                                customers_company,
                                addtime,
                                admin_id,
                                source
                            ) VALUES (
                                "' . $firstname . '",
                                "' . $lastname . '",
                                "' . $nick . '",
                                "' . $telephone . '",
                                "",
                                "' . $email_address . '",
                                "' . $country . '",
                                "' . $company . '",
                                "' . date("Y-m-d H:i:s") . '",
                                "' . 0 . '",
                                "' . $source . '"
                            )';
                    $current_root_dir = str_replace('cache', '', DIR_FS_SQL_CACHE);
                    $offline_customers_log_dir = $current_root_dir . 'debug/offline_customers';
                    if (!is_dir($offline_customers_log_dir)) {
                        mkdir($offline_customers_log_dir);
                    }
                    chmod($offline_customers_log_dir, 0777);
                    $offline_customers_log_file = $offline_customers_log_dir . '/' . date('Y-m-d H:i:s') . '.log';
                    file_put_contents($offline_customers_log_file,"前台留言入口新客户录入线下客户表：" . $sql . "】\r\n\r\n",FILE_APPEND);
                    if ($is_insert_offline) {
                        if ($is_online_website) {
                            $db->query($sql);
                            if(strpos($_SERVER['HTTP_HOST'],'www.fs.com') !== false) {
                                $db->close();
                                unset($us_db);
                            }
                        } else {
                            $db->query($sql);
                        }
                    }
                }
            }
        }
    }

    function get_guest_customer_offline_address($customers_id,$type){
        global $db;
        $shipping = array();
        if($customers_id){
            $shipping_sql = 'select CONCAT(entry_street_address,entry_city,entry_postcode,entry_telephone) as shipping_address from address_offline_book where address_type='.$type.' and customers_id='.$customers_id;
            $shipping_rst = $db->Execute($shipping_sql);
            if($shipping_rst->RecordCount()){
                while (!$shipping_rst->EOF){
                    $shipping[] = $shipping_rst->fields['shipping_address'];
                    $shipping_rst->MoveNext();
                }
            }
        }
        return $shipping;
    }

    //游客下单进行收货地址和账单地址的比对
    function update_guest_customer_offline_address($email,$orders_id){

        global $db;
        if($email && $orders_id){
            $off_cus_id = fs_get_data_from_db_fields('customers_id','customers_offline','customers_email_address="'.$email.'"','');
            if($off_cus_id){
                $shipping_address = get_guest_customer_offline_address($off_cus_id,1);
                $billing_address = get_guest_customer_offline_address($off_cus_id,2);
                $ship_is_true = false;
                $bill_is_true = false;
                $orders = new order($orders_id);
                $delivery = $orders->delivery;
                $billing = $orders->billing;
                if(sizeof($shipping_address)){
                    $new_ship = $delivery['street_address'].$delivery['city'].$delivery['postcode'].$delivery['telephone'];
                    $new_ship = preg_replace('/\s|\,|\./','',$new_ship);
                    foreach ($shipping_address as $ship){
                        $ship = preg_replace('/\s|\,|\./','',$ship);
                        if($new_ship == $ship){
                            $ship_is_true = true;
                        }
                    }
                }
                if(!$ship_is_true){
                    //游客下单收货地址添加到线下地址表
                    $delivery_address = array(
                        'address_type' => 1,
                        'customers_id' => $off_cus_id,
                        'company_type' => (int)($delivery['company_type']=='BusinessType') ? 1 : 2,
                        'entry_company' => $delivery['company'],
                        'entry_firstname' => $delivery['name'],
                        'entry_lastname' => $delivery['lastname'],
                        'entry_street_address' => $delivery['street_address'],
                        'entry_suburb' => $delivery['suburb'],
                        'entry_postcode' => $delivery['postcode'],
                        'entry_city' => $delivery['city'],
                        'entry_state' => $delivery['state'],
                        'entry_country_id' => fs_get_data_from_db_fields('countries_id','countries','countries_name="'.$delivery['country'].'"','limit 1'),
                        'entry_telephone' => $delivery['telephone'],
                        'entry_tax_number' => $delivery['tax_number'],
                    );
                    zen_db_perform('address_offline_book',$delivery_address);
                }
                if(sizeof($billing_address)){
                    $new_bill = $billing['street_address'].$billing['city'].$billing['postcode'].$billing['telephone'];
                    $new_bill = preg_replace('/\s|\,|\./','',$new_bill);
                    foreach ($billing_address as $bill){
                        $bill = preg_replace('/\s|\,|\./','',$bill);
                        if($new_bill == $bill){
                            $bill_is_true = true;
                        }
                    }
                }
                if(!$bill_is_true){
                    //游客下单账单地址添加到线下地址表
                    $billing_address = array(
                        'address_type' => 2,
                        'company_type' => (int)($billing['company_type']=='BusinessType') ? 1 : 2,
                        'customers_id' => $off_cus_id,
                        'entry_company' => $billing['company'],
                        'entry_firstname' => $billing['name'],
                        'entry_lastname' => $billing['lastname'],
                        'entry_street_address' => $billing['street_address'],
                        'entry_suburb' => $billing['suburb'],
                        'entry_postcode' => $billing['postcode'],
                        'entry_city' => $billing['city'],
                        'entry_state' => $billing['state'],
                        'entry_country_id' => fs_get_data_from_db_fields('countries_id','countries','countries_name="'.$billing['country'].'"','limit 1'),
                        'entry_telephone' => $billing['telephone'],
                        'entry_tax_number' => $billing['tax_number'],
                    );
                    zen_db_perform('address_offline_book',$billing_address);
                }
            }
        }
    }

    // sql的辅助方法
    function whereIn2($arr,$field)
    {
        if($arr) {
            $whereInStr = " in(";
            foreach ($arr as $value) {
                $whereInStr .= '"'.$value[$field] . '",';
            }
            $str = substr($whereInStr, 0, -1) . ')';
        } else {
            $str = '';
        }
        return $str;
    }

    /*
     * 公海客户进行分配
     * fairy 2018.8.30 add
     */
    function auto_given_open_seas_customers($data = [],$admin_id){
        global $db;
        // fairy 2018.8.30 add 针对公共后缀的进行公海客户分配
        $customers_email = trim($data['email_address']);
        $invalidSign = $data['invalidSign'];

        if (empty(trim($customers_email)) || !$admin_id){
            $data_log = array(
                'customers_email' => '数据:'.json_encode($data),
                'created_at' => date("Y-m-d H:i:s"),
                'customers_email_2' => $customers_email,
                'case_number' => '分配公海客户1',
                'admin_id' => $admin_id,
            );
            zen_db_perform('customer_service_log',$data_log);
            return;
        }

        $user_customers_number_new = $data['customer_number'];
        if (!$user_customers_number_new) {
            $user_customers_number_new = $data['customer_offline_number'];
        }
        if (!$user_customers_number_new && $customers_email) {
            $email_sql = 'SELECT customers_number_new  FROM customers where customers_email_address = "' . $customers_email . '" limit 1';
            $email_res = $db->Execute($email_sql);
            $user_customers_number_new = $email_res->fields['customers_number_new'];
            $regist_table = 0;
            if (!$user_customers_number_new) {
                $email_sql = 'SELECT customers_number_new  FROM customers_offline where customers_email_address = "' . $customers_email . '" limit 1';
                $email_res = $db->Execute($email_sql);
                $user_customers_number_new = $email_res->fields['customers_number_new'];
                $regist_table = 1;
            }
        }
        if($admin_id && $customers_email){
            $db->Execute("UPDATE manage_customer_company_to_customers m INNER JOIN customers c on m.customers_number_new = c.customers_number_new SET m.admin_id = ".$admin_id." where c.customers_email_address = '".$customers_email."'");
            $db->Execute("UPDATE manage_customer_company_to_customers m INNER JOIN customers_offline c on m.customers_number_new = c.customers_number_new SET m.admin_id = ".$admin_id." where c.customers_email_address = '".$customers_email."'");
        }
        // fairy 2019.2.12 add 关联公司公海客户处理
        $arr = explode('@', $customers_email);
        $domain = '@' . $arr[1];
        $commonDomain = $db->Execute("select mail_suffix from public_mail_suffix WHERE mail_suffix = '" . $domain . "' limit 1");

        // 当前公司名称
        $company_number = '';
        if($user_customers_number_new){
            $company_number = fs_get_data_from_db_fields('company_number','manage_customer_company_to_customers','customers_number_new='.$user_customers_number_new,'limit 1');
        }
        $company = $company_number;
        if (!$company) {
            return ;
        }
        $user_reason = 0;
        //如果当前客户为无效客户，再去查无效客户类型表
        if ($invalidSign && $user_customers_number_new) {
            $user_reason = fs_get_data_from_db_fields('reason','manage_customer_customers_disabled','customers_number_new='.$user_customers_number_new,'limit 1');
        }
        // 当前公司的关联客户统一进行分配
        if(!$commonDomain->fields['mail_suffix']){
            // 无效客户处理
            if ($user_reason) {
                switch ($user_reason) {
                    case 1:
                        customer_seas_company_given(array(
                            'admin_id' => $admin_id,
                            'email' => $customers_email,
                            'company' => $company,
                            'suffix_email' => $domain,
                            'current_type' => 4,
                            'isSuffix' => $commonDomain->fields['mail_suffix'],
                            'user_reason' => $user_reason,
                        ));
                        break;
                    case 3:
                        customer_seas_company_given(array(
                            'admin_id' => $admin_id,
                            'email' => $customers_email,
                            'company' => $company,
                            'suffix_email' => $domain,
                            'current_type' => 3,
                            'isSuffix' => $commonDomain->fields['mail_suffix'],
                            'user_reason' => $user_reason,
                        ));
                        break;
                }
            } else {
                // 有效客户的处理方式
                // 同后缀公海客户
                customer_seas_company_given(array(
                    'admin_id' => $admin_id,
                    'email' => $customers_email,
                    'company' => $company,
                    'suffix_email' => $domain,
                    'current_type' => 0,
                    'isSuffix' => $commonDomain->fields['mail_suffix'],
                    'user_reason' => $user_reason,
                ));
            }
        }elseif($commonDomain->fields['mail_suffix']){
            // 公共邮箱后缀

            // 获取当前账号的关联公司下的账号
            $company_sql = 'SELECT customers_number_new  FROM manage_customer_company_to_customers where company_number = "' . $company . '"';
            $customers_number = $db->getAll($company_sql);
            if ($user_reason) { //无效客户
                customer_seas_company_given(array(
                    'admin_id' => $admin_id,
                    'email' => $customers_email,
                    'company' => $company,
                    'suffix_email' => $domain,
                    'current_type' => 2,
                    'isSuffix' => $commonDomain->fields['mail_suffix'],
                    'user_reason' => $user_reason,
                ));
            } else {
                //有效客户
                customer_seas_company_given(array(
                    'admin_id' => $admin_id,
                    'email' => $customers_email,
                    'company' => $company,
                    'suffix_email' => $domain,
                    'current_type' => 1,
                    'isSuffix' => $commonDomain->fields['mail_suffix'],
                    'user_reason' => $user_reason,
                ));
            }
        }
    }


    function customer_seas_company_given($data = []){
        global $db;
        $company = $data['company'];
        $admin_id = $data['admin_id'];
        // 0.企业后缀有效客户  1.公共后缀有效客户 2.公共后缀无效客户 3.企业后缀无效客户类型3  4.企业后缀无效客户类型1
        $type = $data['current_type'];
        $suffix_email = $data['suffix_email'];
        $customers_email = $data['email'];
        $user_reason = $data['user_reason'] ? $data['user_reason'] : '';

        //是否是公共后缀
        $isSuffix = $data['isSuffix'];
        if (!$company || !$admin_id || !$customers_email) {
            return false;
        }

        $company_sql = 'SELECT customers_number_new  FROM manage_customer_company_to_customers where company_number = "' . $company . '"';
        $customers_number = $db->getAll($company_sql);

        if (($type === 0 || $type == 4) && $suffix_email) { //企业后缀 有效客户或无效类型为1的客户
            $adminToCustomersId = $db->getAll("
select c.customers_id,c.customers_email_address,c.customers_number_new,c.is_disabled,a.admin_id from customers as c 
LEFT JOIN admin_to_customers as a ON c.customers_id = a.customers_id
WHERE c.customers_email_address LIKE '%".$suffix_email."' or c.customers_number_new ".whereIn2($customers_number,'customers_number_new')."  and (a.admin_id=0 or a.admin_id=117)
        UNION ALL
select customers_id,customers_email_address,customers_number_new,is_disabled,admin_id from customers_offline 
WHERE customers_email_address like '%" . $suffix_email . "' 
or customers_number_new ".whereIn2($customers_number,'customers_number_new')."
and (admin_id=0 or admin_id=117)" );
        } else if (($type == 2 || $type == 1) && $isSuffix) {
            $adminToCustomersId = $db->getAll("
select c.customers_number_new,c.is_disabled from customers as c 
LEFT JOIN admin_to_customers as a ON c.customers_id = a.customers_id
WHERE c.customers_email_address ='".$customers_email."' or c.customers_number_new ".whereIn2($customers_number,'customers_number_new')." and (a.admin_id=0 or a.admin_id=117)
UNION ALL
select customers_number_new,is_disabled from customers_offline 
WHERE customers_email_address = '".$customers_email."' or customers_number_new ".whereIn2($customers_number,'customers_number_new')." and (admin_id=0 or admin_id=117)" );
        } else {
            $adminToCustomersId = $db->getAll("
select c.customers_id,c.customers_email_address,c.customers_number_new,c.is_disabled from customers as c 
LEFT JOIN admin_to_customers as a ON c.customers_id = a.customers_id
WHERE (a.admin_id=0 or a.admin_id=117) and c.customers_number_new ".whereIn2($customers_number,'customers_number_new')." 
UNION ALL
select customers_id,customers_email_address,customers_number_new,is_disabled from customers_offline 
WHERE (admin_id=0 or admin_id=117) and customers_number_new ".whereIn2($customers_number,'customers_number_new'));
        }

        $allDisabled = $allEndisabled = $invalid_customers_number = $invalid_customers_number_not = $all_invalid_customers_number = [];
        if(sizeof($adminToCustomersId)){
            foreach ($adminToCustomersId as $k => $v) {
                if ($v['is_disabled'] == 1) {
                    $allDisabled[]['customers_number_new'] = $v['customers_number_new']; //无效客户
                } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                    $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
                }
            }
        }

        // 2、取消同公司的所有账号，并将无效类型是1和3的取消无效标记、重新分配；非1和3的解除公司绑定
        if (!empty($allDisabled)) {
            $company_reason_sql = "SELECT reason,customers_number_new FROM manage_customer_customers_disabled WHERE customers_number_new ".whereIn2($allDisabled,'customers_number_new').' order by id ASC';
            $all_company_reason_customers = $db->getAll($company_reason_sql);
            foreach ($all_company_reason_customers as $k => $v) {
                $all_invalid_customers_number[$v['customers_number_new']] = $v['reason'];
            }
            foreach ($all_invalid_customers_number as $number => $reason){
                if ($user_reason) { //当前客户为无效客户时，同后缀且同公司下为1，3无效客户都进行分配
                    if (in_array($reason, [1,3])) {
                        $invalid_customers_number[] =  $number;
                    }else{
                        $invalid_customers_number_not[] = $number;   // 获得需要解除绑定的账号
                    }
                } else {
                    if (in_array($reason, [1])) {  //当前客户为有效客户时，同后缀且同公司下为1无效客户都进行分配
                        $invalid_customers_number[] =  $number;
                    }else{
                        $invalid_customers_number_not[] = $number;   // 获得需要解除绑定的账号
                    }
                }
            }
        }
        $invalid_customers_number = array_unique(array_merge($allEndisabled, $invalid_customers_number));

        $insert_log_data = array(
            'invalid_customers_number' => $invalid_customers_number,
            'invalid_customers_number_not' => $invalid_customers_number_not,
            'type' => $type,
        );
        $data_log = array(
            'customers_email' => '数据:'.json_encode($insert_log_data),
            'created_at' => date("Y-m-d H:i:s"),
            'customers_email_2' => $customers_email,
            'case_number' => '分配公海客户2',
            'admin_id' => $admin_id,
        );
        zen_db_perform('customer_service_log',$data_log);

        if (!empty($invalid_customers_number_not) && (in_array($type, [0, 2, 3, 4]))) { // 无效类型是非1和3解除公司绑定
            $db->Execute("delete from manage_customer_company_to_customers where customers_number_new in (".join(',',$invalid_customers_number_not).")");
            $db->Execute("update customers set manage_type=0,customers_level='' where customers_number_new in (".join(',',$invalid_customers_number_not).")");
            $db->Execute("update customers_offline set manage_type=0,customers_level='' where customers_number_new in (".join(',',$invalid_customers_number_not).")");
        }
        if (!empty($invalid_customers_number)) {  // 无效客户类型是1和3的取消无效标记并重新分配
            $db->Execute("update customers as c right JOIN admin_to_customers as a ON c.customers_id = a.customers_id set c.is_disabled = 0, a.admin_id = ".$admin_id." where c.customers_number_new in (".join(',',$invalid_customers_number).")");
            $db->Execute("update customers_offline SET is_disabled = 0,admin_id =". $admin_id ." WHERE customers_number_new in (".join(',',$invalid_customers_number).")");
            // 将无效客户类型是1和3公司进行关联
            $db->Execute("update manage_customer_company_to_customers set admin_id = ".$admin_id." WHERE customers_number_new in (".join(',',$invalid_customers_number).")");

            foreach ($invalid_customers_number as $value){
                $customers_seas_data = array(
                    'customer_number_new'=>$value,
                    'company_number'=>$company,  //分配时的公司编号,若公海客户没有公司 都用此公司编号
                    'create_at'=>time(),
                    'is_update'=>0
                );
                zen_db_perform('customers_seas', $customers_seas_data);
            }
        }
    }

    //线上客户注册,将线下表邮箱全称一样的客户自动关联
    function customers_to_customers_offline_manage($admin_id,$email_address,$customers_id){
        global $db;
        $type = true;
        if($email_address && $admin_id){
            $cus_num_new = fs_get_data_from_db_fields('customers_number_new','customers','customers_id='.$customers_id,'');
            $customer_number_new = fs_get_data_from_db_fields_array(array('customers_number_new','manage_type'),'customers_offline','customers_email_address="'.$email_address.'"','limit 1');
            if($customer_number_new){
                if($customer_number_new[0][1] != 0 && $customer_number_new[0][0]){
                    $company_number = fs_get_data_from_db_fields('company_number','manage_customer_company_to_customers','customers_number_new='.$customer_number_new[0][0],'limit 1');
                    if($company_number){
                        $customers_info = fs_get_data_from_db_fields_array(array('customers_level','company_type'),'manage_customer_company','company_number = "'.$company_number.'"','limit 1');
                        $manage_type =0;
                        $customer_level = '';
                        if($customers_info){
                            if($customers_info[0][1] ==1){
                                $manage_type =2;
                            }else{
                                $manage_type =1;
                            }
                            $customer_level = $customers_info[0][0];
                        }


                        $sql = 'INSERT INTO manage_customer_company_to_customers ( 
                                            company_number,
                                            customers_number_new,
                                            admin_id,
                                            created_at
                                            ) VALUES (
                                            "'.$company_number.'",
                                            "'.$cus_num_new.'",
                                            "'.$admin_id.'",
                                            "'.date("Y-m-d H:i:s").'"
                                            )';
                        $db->query($sql);
                        $cus_data = array(
                            'manage_type' => $manage_type,
                            'customers_level' => $customer_level,
                        );
                        zen_db_perform('customers',$cus_data,'update','customers_id='.$customers_id);

                        $data = array(
                            'customers_number_new' => $cus_num_new,
                            'after_company_number' => $company_number,
                            'admin_id' => $admin_id,
                            'change_time' => date("Y-m-d H:i:s")
                        );
                        zen_db_perform('customers_company_number_change_log',$data);
                        $type = false;
                    }
                }
            }
        }
        return $type;
    }

/**
 * @Notes: 客户添加管理
 *
 * @param $admin_id
 * @param $email_address
 * @param $is_online
 * @param array $data
 * @return bool
 * @auther: Dylan
 * @Date: 2021/1/15
 * @Time: 18:30
 */
    function auto_given_customer_manage($admin_id,$email_address,$is_online,$data=array()){
        global $db;
        $link = true;
        $theCustomerNumberSql = $db->getAll("select customers_number_new,manage_type,customers_firstname,customer_country_id,customers_level from customers WHERE customers_email_address = '".$email_address."' LIMIT 1");
        if ($theCustomerNumberSql) {
            $cus_table = 'customers';
            $theCustomerNumber = $theCustomerNumberSql[0]['customers_number_new'];
        } else {
            $cus_table = 'customers_offline';
            $theCustomerNumber = $data['customers_number_new'] ? $data['customers_number_new'] : '';
            if(empty($theCustomerNumber)){
                $theCustomerNumberSql = $db->getAll("select customers_number_new,manage_type,customers_firstname,customer_country_id,customers_level from customers_offline WHERE customers_email_address = '".$email_address."' LIMIT 1");
                $theCustomerNumber = $theCustomerNumberSql[0]['customers_number_new'];
            }
        }
        // 无效客户类型
        // $invalid_type = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', 'customers_number_new=' . $theCustomerNumber, 'limit 1');
        //写入日志
        $data_log_arr = array(
            'customers_email' => $email_address,
            'time_flow' => time(),
            'is_online' => $is_online,
            'theCustomerNumber' => $theCustomerNumber,
            'data' => $data,
            'admin_id' => $admin_id,
            'manage_type' => $theCustomerNumberSql->fields['manage_type'],
        );
        
        $data_log = array(
                        'customers_email' => '数据:'.json_encode($data_log_arr),
                        'created_at' => date("Y-m-d H:i:s"),
                        'customers_email_2' => $email_address,
                        'case_number' => '前台添加管理日志2',
                    );
        zen_db_perform('customer_service_log',$data_log);

        if($theCustomerNumberSql->fields['manage_type'] > 0 || !$admin_id || !$email_address){
            return false;
        }
        $flag = false;  //是否关联标记
        $finalCompany = '';
        if($email_address){
            $customersOfflineNumber = $db->Execute("select customers_number_new from customers_offline WHERE customers_email_address = '".$email_address."'");
            if($customersOfflineNumber->fields['customers_number_new']){
                $companyNumber = $db->Execute("select company_number from manage_customer_company_to_customers WHERE customers_number_new = '".$customersOfflineNumber->fields['customers_number_new']."'");
                if($companyNumber->fields['company_number']){
                    $flag = true;
                    $finalCompany = $companyNumber->fields['company_number'];  // 查找该账号是否已经有公司绑定
                }
            }
        }
        // 该账号没有绑定过公司的
        $email_tail = '';
        if(!$flag){
            $pub_mail = array();
            $all_mail = $db->getAll("select mail_suffix from public_mail_suffix");
            if($all_mail){
                foreach($all_mail as $mail){
                    $pub_mail[] = $mail['mail_suffix'];
                }
            }

            $email_tail = strrchr($email_address, '@');
            $email_tail = strtolower($email_tail);
             // 不是公共邮箱
            if(($email_tail && !in_array($email_tail, $pub_mail) && $admin_id) ){
                //非公共邮箱
                $numberArr = array();
                //线上同后缀的客户
                $cus_sql = 'SELECT c.customers_number_new FROM customers c left join admin_to_customers atc on (c.customers_id=atc.customers_id) where c.customers_email_address like "%' . $email_tail . '" and admin_id ='.$admin_id.' and c.manage_type=1';
                //$cus_sql = 'SELECT c.customers_number_new FROM customers c left join admin_to_customers atc on (c.customers_id=atc.customers_id) where c.customers_email_address like "%' . $email_tail . '" and c.manage_type<>0';
                $cus_res = $db->Execute($cus_sql);
                if($cus_res->RecordCount()){
                    while (!$cus_res->EOF){
                        $numberArr[]=$cus_res->fields['customers_number_new'];
                        $cus_res->MoveNext();
                    }
                }
                //线下同后缀的客户
                $cus_off_sql = 'SELECT customers_number_new FROM customers_offline  where customers_email_address like "%' . $email_tail . '" and admin_id = '.$admin_id.' and manage_type=1';
                //$cus_off_sql = 'SELECT customers_number_new FROM customers_offline  where customers_email_address like "%' . $email_tail . '" and manage_type<>0';
                $cus_off_rst = $db->Execute($cus_off_sql);
                if($cus_off_rst->RecordCount()){
                    while (!$cus_off_rst->EOF){
                        $numberArr[]=$cus_off_rst->fields['customers_number_new'];
                        $cus_off_rst->MoveNext();
                    }
                }
                if (sizeof($numberArr)){
                    $sql = 'SELECT company_number FROM manage_customer_company_to_customers where customers_number_new in('.join(',',$numberArr).') group by company_number';
                    $resultCompany = $db->getAll($sql);
                    if(sizeof($resultCompany) == 1){
                        $flag = true;
                        $finalCompany = $resultCompany[0]['company_number'];
                    }
                } else {
                    $sql = 'SELECT c.customers_number_new FROM customers c 
                            left join admin_to_customers atc on (c.customers_id=atc.customers_id) 
                            where c.customers_email_address like "%' . $email_tail . '" 
                            and admin_id = 0
                            and c.manage_type=1
                            UNION ALL
                            SELECT customers_number_new FROM customers_offline  
                            where customers_email_address like "%' . $email_tail . '" 
                            and admin_id = 0 
                            and manage_type=1
                            ';
                    $allCustomer = $db->getAll($sql);
                    $numberArr = !empty($allCustomer) ? array_column($allCustomer, 'customers_number_new') : [];
                    $sql = 'SELECT company_number FROM manage_customer_company_to_customers where customers_number_new in('.join(',',$numberArr).') group by company_number';
                    $resultCompany = $db->getAll($sql);
                    if(sizeof($resultCompany) == 1){
                        $flag = true;
                        $finalCompany = $resultCompany[0]['company_number'];
                    }
                }
            }
        }
        //开始自动关联
        if($link){
            if($flag && $finalCompany){
                // if(!$theCustomerNumber && $is_online != 1){
                //     //在后台数据库再查一遍
                //     $theCustomerNumberSql1 = $db->Execute("select customers_number_new,manage_type from customers_offline WHERE customers_email_address = '".$email_address."'");
                //     $theCustomerNumber = $theCustomerNumberSql1->fields['customers_number_new'];
                // }
                $customers_info = $db->Execute("select customers_level,company_type from manage_customer_company WHERE company_number = '".$finalCompany."' limit 1");
                $manage_type =0;
                $customer_level = '';
                if($customers_info){
                    if($customers_info->fields['company_type'] ==1){
                        $manage_type =2;
                    }else{
                        $manage_type =1;
                    }
                    $customer_level = $customers_info->fields['customers_level'];
                }
                $sql = 'INSERT INTO manage_customer_company_to_customers ( 
                                    company_number,
                                    customers_number_new,
                                    admin_id,
                                    created_at
                                    ) VALUES (
                                    "'.$finalCompany.'",
                                    "'.$theCustomerNumber.'",
                                    "'.$admin_id.'",
                                    "'.date("Y-m-d H:i:s").'"
                                    )';
                $db->query($sql);
                $db->Execute('update '.$cus_table.' set manage_type='.$manage_type.',customers_level="'.$customer_level.'" where customers_number_new = "'.$theCustomerNumber.'"');
                

                //写入日志
                $data_log_arr = array(
                    'customers_email' => $email_address,
                    'time_flow' => time(),
                    'customer_level' => $customer_level,
                    'customers_number_new' => $theCustomerNumber,
                    'data' => $data,
                    'admin_id' => $admin_id,
                    'manage_type' => $manage_type,
                    'cus_table' => $cus_table,
                    'company_number' => $finalCompany,
                );
                $data_log = array(
                        'customers_email' => '数据:'.json_encode($data_log_arr),
                        'created_at' => date("Y-m-d H:i:s"),
                        'customers_email_2' => $email_address,
                        'case_number' => '前台添加管理日志3',
                    );
                zen_db_perform('customer_service_log',$data_log);

                //同步客户信息到对应的公司（如果请求参数都满足条件）下，插入数据表
                updateNsCustomersSeas($finalCompany);

            }else{
                if(in_array($email_tail, ['@fs.com', '@feisu.com'])){  //
                    return false;
                }
                //创建新公司关联
                $chinaTime = get_common_cn_time();
                $defaultCompanyNumber = 'G' . '00000' . RAND(1000,9999);
                $defaultCompanyLevel = $theCustomerNumberSql->fields['customers_level'] ? $theCustomerNumberSql->fields['customers_level'] : 'E';
                $sql1 = 'INSERT INTO manage_customer_company (
                                    company_number,
                                    created_at,
                                    customers_country_id,
                                    customers_company,
                                    company_type
                                    ) VALUES (
                                    "'.$defaultCompanyNumber.'",
                                     "'.$chinaTime.'",
                                    "'.$theCustomerNumberSql->fields['customer_country_id'].'",
                                    "'.$theCustomerNumberSql->fields['customers_firstname'].'",
                                    "1"
                                    )';
                $db->query($sql1);

                $newCompanyId = $db->insert_ID();

                if ($newCompanyId) {
                    $newCompanyNumber = set_company_number($newCompanyId);//生成新的公司编号
                    $db->query("UPDATE `manage_customer_company` SET `company_number` = '{$newCompanyNumber}',`customers_company` = '{$newCompanyNumber}' WHERE `id` = '{$newCompanyId}'");
                    $sql = 'INSERT INTO manage_customer_company_to_customers ( 
                                    company_number,
                                    customers_number_new,
                                    admin_id,
                                    created_at
                                    ) VALUES (
                                    "'.$newCompanyNumber.'",
                                    "'.$theCustomerNumber.'",
                                    "'.$admin_id.'",
                                    "'.date("Y-m-d H:i:s").'"
                                    )';
                    $db->query($sql);
                    $db->Execute('update '.$cus_table.' set manage_type = 2,customers_level = "'.$defaultCompanyLevel.'" where customers_number_new = "'.$theCustomerNumber.'"');
                }

                //写入日志
                $data_log_arr = array(
                    'customers_email' => $email_address,
                    'time_flow' => time(),
                    'customer_level' => $defaultCompanyLevel,
                    'customers_number_new' => $theCustomerNumber,
                    'data' => $data,
                    'admin_id' => $admin_id,
                    'cus_table' => $cus_table,
                );
                $data_log = array(
                        'customers_email' => '数据:'.json_encode($data_log_arr),
                        'created_at' => date("Y-m-d H:i:s"),
                        'customers_email_2' => $email_address,
                        'case_number' => '前台添加管理日志4',
                    );
                zen_db_perform('customer_service_log',$data_log);
                
                //同步客户信息到对应的公司（如果请求参数都满足条件）下，插入数据表
                if($newCompanyNumber){
                    updateNsCustomersSeas($newCompanyNumber);
                }
            }
        }
    }

    /**
     * 生成公司编号
     *
     * @param $companyId
     * @return string
     */
    function set_company_number($companyId)
    {
        //9位数公司编号 1-2位为10-99的随机数 3位 1表示英文站 6表示中文站（暂无） 后位为company_id 中间补0
        $randNum = (string)rand(10, 99);
        $thirdNum = '1';
        $middleNum = '';
        $length = 9 - (strlen($companyId) + 3);
        for ($i = 0; $i < $length; $i++) {
            $middleNum .= '0';
        }
        $companyNum = 'G' . $randNum . $thirdNum . $middleNum . $companyId;

        return $companyNum;
    }

//2018.9.13 个人中心改版
function get_user_pro_info()
{
    global $db;
    global $currencies;
    $po_flag = array();
    $po_flag['is_po_account'] = false;
    $purchaseInfo = getPurchaseInfo();
    if (zen_not_null($purchaseInfo['po_flag'])) {
        if ($purchaseInfo['from'] == "new"){
            $po_flag['apply_type'] = $purchaseInfo['apply_type'] ? $purchaseInfo['apply_type'] : 0;
            $po_flag['from'] = "new";
            $po_flag['apply_money'] = $purchaseInfo['apply_money'][0][1] ? $purchaseInfo['apply_money'][0][1] : 0;
            $po_flag['is_delete'] = $purchaseInfo['is_delete'] ? $purchaseInfo['is_delete'] : 0;
            $po_flag['all_apply_money'] = $purchaseInfo['all_apply_money'] ? $purchaseInfo['all_apply_money'] : 0;
            $po_flag['apply_moneys'] = $po_flag['all_apply_money'];
            $po_flag['apply_currency_id'] = $purchaseInfo['apply_money'][0][0] ? $purchaseInfo['apply_money'][0][0] : 0;
            $po_flag['id'] = $purchaseInfo['id'];
            $po_flag['admin'] = isset($purchaseInfo['admin'])?$purchaseInfo['admin']:0;
            if ( in_array($po_flag['apply_type'],[2,13,17])  && $po_flag['is_delete'] == 0) {
                $po_flag['is_po_account'] = true;
            }
            $currency_symbol = $purchaseInfo['currency_symbol_code'];
        }else{
            //可以优化
            $sql = 'select id,customers_NO,order_payment,apply_type,apply_money,apply_moneys,is_delete,currencies_id,apply_admin,address_book_id,customers_email,company_name,customer_grade,customers_NO
                from products_instock_shipping_apply
                WHERE id ="' . $purchaseInfo['id'] . '"
                limit 1';
            $po_flag = $db->getAll($sql);
            $po_flag = $po_flag[0];
            if ($po_flag) {
                $po_flag['from'] = "old";
                $po_flag['apply_type'] = $po_flag['apply_type'] ? $po_flag['apply_type'] : 0;
                $po_flag['apply_money'] = $po_flag['apply_money'] ? $po_flag['apply_money'] : 0;
                $po_flag['all_apply_money'] = $po_flag['apply_moneys'] ? $po_flag['apply_moneys'] : 0;
                $po_flag['apply_currency_id'] = $po_flag['currencies_id'] ? $po_flag['currencies_id'] : 0;
                if ( in_array($po_flag['apply_type'],[2,13,17])  && $po_flag['is_delete'] == 0) {
                    $po_flag['is_po_account'] = true;
                }
                if ($po_flag['apply_currency_id'] == 0 || $po_flag['apply_currency_id'] == 1) {
                    $currency_symbol = "USD";
                } else {
                    $currency_symbol = fs_get_data_from_db_fields('code', 'currencies', 'currencies_id =' . $po_flag['apply_currency_id'], '');
                }
            }
        }
        $symbol_left = $currencies->currencies[$currency_symbol]['symbol_left'];
        $symbol_right = $currencies->currencies[$currency_symbol]['symbol_right'];
        $decimal_point = $currencies->currencies[$currency_symbol]['decimal_point'];
        $apply_money = number_format($po_flag['apply_money'], 2, $decimal_point, '');
        $po_flag['apply_money_str'] = $symbol_left . $apply_money . $symbol_right;
        $po_flag['apply_money_other_str'] = ($symbol_left ? '<em>' . $symbol_left . '</em>' : '') . $apply_money . ($symbol_right ? '<em>' . $symbol_right . '</em>' : '');
        $po_flag['all_apply_money_str'] = $symbol_left . number_format($po_flag['all_apply_money'], 2, $decimal_point, '') . $symbol_right;
    }
    return $po_flag;
}

/*
 * 把ip的密码错误相关信息存储到redis中
 * 2019.2.18 fairy add
 * @para string $ip_address
 * @return bool: 是否展示验证码
 */
function set_ip_login_error_redis($ip_address){
    $ip_login_error_old = get_redis_key_value($ip_address,LOGIN_ERROR_REDIS_KEY_PREFIX);
    $login_error = $ip_login_error_old?$ip_login_error_old['login_error_time']+1:1;
    $old_is_show_ver = $ip_login_error_old?$ip_login_error_old['is_show_ver']:0;
    $current_time = time();
    $ip_login_error = array(
        'login_error_time' => $login_error, //错误次数
        'first_login_error_date' => $current_time, //第一次错误登录的时间
        'second_login_error_date' => 0, //第二次错误登录的时间
        'third_login_error_date' => 0, //第三次错误登录的时间
        'is_show_ver' => 0, //是否展示验证码
    );
    if($login_error==1){
        $ip_login_error['first_login_error_date'] = $current_time;
    }elseif ($login_error==2){
        $ip_login_error['second_login_error_date'] = $current_time;
    }elseif ($login_error==3) {
        $ip_login_error['third_login_error_date'] = $current_time;
    }else{
        $ip_login_error['first_login_error_date'] = $ip_login_error_old['second_login_error_date'];
        $ip_login_error['second_login_error_date'] = $ip_login_error_old['third_login_error_date'];
        $ip_login_error['third_login_error_date'] = $current_time;
    }

    // 10s3次错误，显示验证码。登录成功或者redis过期，重新开始
    if($ip_login_error['third_login_error_date'] && $ip_login_error['third_login_error_date']-$ip_login_error['first_login_error_date']<=10){
        $ip_login_error['is_show_ver'] = 1;
    }
    set_redis_key_value($ip_address,$ip_login_error,12*3600,LOGIN_ERROR_REDIS_KEY_PREFIX);
    return array(
//        'is_show_ver' => $ip_login_error['is_show_ver'],
        'is_show_ver' => false, // 2019.8.2 暂时屏蔽验证码
        'is_first_show_ver' => ($ip_login_error['is_show_ver'] && $old_is_show_ver==0)?1:0, //是否第一次展示验证码，主要是为了第一次的时候展示的提示语有区别
    );
}


/*
 * 1分钟内连续输入错误5次邮箱，此ip禁止输入1分钟把ip的相关信息存储到redis中
 * 2020.10.27 bob add
 * @para string $ip_address
 */
function set_ip_password_forgotten_error_redis($ip_address){
    $ip_password_forgotten_error = get_redis_key_value($ip_address,PASSWORD_FORGOTTEN_ERROR_REDIS_KEY_PREFIX);
    $current_time = time();
        $password_forgotten_error = $ip_password_forgotten_error?$ip_password_forgotten_error['password_forgotten_error_time']+1:1;
        switch ($password_forgotten_error){
            case 1;
                $ip_password_forgotten_error['first_password_forgotten_error_date'] = $current_time;
                break;
            case 2;
                $ip_password_forgotten_error['second_password_forgotten_error_date'] = $current_time;
                break;
            case 3;
                $ip_password_forgotten_error['third_password_forgotten_error_date'] = $current_time;
                break;
            case 4;
                $ip_password_forgotten_error['fourth_password_forgotten_error_date'] = $current_time;
                break;
            case 5;
                $ip_password_forgotten_error['fifth_password_forgotten_error_date'] = $current_time;
                break;
        }
        $ip_password_forgotten_error['password_forgotten_error_time']=$password_forgotten_error;
    set_redis_key_value($ip_address,$ip_password_forgotten_error,60,PASSWORD_FORGOTTEN_ERROR_REDIS_KEY_PREFIX);
}




//获取后台token
function defaultEncrypt(){
    $secretKey = 'xsacsdqweSasdc1d5f2';
    $appId = '34252352343543';
    $secretId = 'acsadsadasda211dacsadsqwe';
    $t = time();
    $r = mt_rand(10000000, 99999999);
    $original = 'u=' . $appId . '&k=' . $secretId . '&t=' . $t . '&r=' . $r . '&f=';
    $signStr = base64_encode(hash_hmac('sha1', $original, $secretKey) . $original);
    return $signStr;
}

/**
 * 此函数用来触发消息推送
 */
function send_app_message($orders_id,$customers_id,$status){
    $data = [
        'token' => defaultEncrypt(),
        'c_id' => $customers_id,
        'o_id' => $orders_id,
        'status' => $status,
    ];
    $headers = array('Content-Type: application/x-www-form-urlencoded');
    $url = HTTPS_SERVER.'/index.php?version=4.0.6&modules=phone&handler=msg_push&request_action=order';
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);        
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        //echo 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $result;
}

//改变数据后请求后台接口
function update_backstage_company_data($customers_id){
    $query_array = [
        'customers_number_new',
        'customers_email_address'
    ];
    $customers_info = fs_get_data_from_db_fields_array($query_array,'customers',"customers_id =".$customers_id,'');
    $customers_number_new = $customers_info[0][0];
    $customers_email_address = $customers_info[0][1];
    if(!$customers_number_new){
        $customers_number_new = fs_get_data_from_db_fields('customers_number_new','customers_offline',"customers_email_address = '".$customers_email_address."'",'limit 1');
    }
    if($customers_number_new){
        $company_number = fs_get_data_from_db_fields('company_number','manage_customer_company_to_customers',"customers_number_new = '".$customers_number_new."'",'limit 1');
    }
    if($company_number){
        updateNsCustomersSeas($company_number);
    }
}

/**
 * 由curl请求后台更新ns数据 改成 直接插入到表中，然后跑脚本执行
 */
function updateNsCustomersSeas($company_number){
    // 插入数据
    $data = [
        'company_number' => $company_number,
        'is_update' => 0,
        'from_where' => 1,
        'num' => 0,
        'create_at' => time(),
    ];

    $res = zen_db_perform('customers_seas', $data);
    return $res;
}

function execute_curl_post_request($company_number){
    $data = ['token'=>defaultEncrypt(),'company'=>$company_number];
    $headers = array('Content-Type: application/x-www-form-urlencoded');
    // $url = 'http://test.whgxwl.com:12001/YX_kVc2yo2cmw0U/update_data_to_ns.php';
    $url = 'http://cn.fs.com/YX_0evWtMz4373v/update_data_to_ns.php';
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);        
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        //echo 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $result;
}

//判断邮箱是否为测试邮箱
function isTestMailbox($email){
    if($email){
        $ext =  substr($email,strpos($email,"@"));
        $ext_arr = array("@szyuxuan.com","@feisu.com","@fs.com");
        if(in_array($ext,$ext_arr)){
            return 1;
        }
    }
}

/**
 * Note: 甄别无效客户类型   后台产品要求无效客户为1和3的需要重新分配
 * @author: Dylan
 * @Date: 2020/7/1
 *
 * @param string $customerNumberNew 客户编号
 * @param string $isDisable 是否是无效客户
 * @param int $admin_id
 * @return array|string
 */
function getIsDisabledEmail($customerNumberNew = '', $isDisable = '', $admin_id = 0) {
    $invalid_type = '';
    $customerNumberNew = $customerNumberNew ? $customerNumberNew : '';
    if (!$customerNumberNew && $isDisable != 1) {
        return [
            'reason_type' => $invalid_type,
            'admin_id' => $admin_id,
        ];
    }

    if (($admin_id == 0 || $admin_id == 117) && $isDisable == 1) {
        $invalid_type = fs_get_data_from_db_fields('reason', 'manage_customer_customers_disabled', 'customers_number_new="' . $customerNumberNew . '"', 'limit 1');
        if (in_array($invalid_type, [1,3])) {
            $admin_id = 0;
        }
    }
    return [
        'reason_type' => $invalid_type,
        'admin_id' => $admin_id,
    ];
}

/**
 * 英文新客户分配重置分配序列
 */
function newCustomerAssignmentEn()
{
    global $db;
    //查询所有的英文销售leader
    $leaders = $db->getAll('select l.id,a.admin_id,l.customer_dist_num 
        from live_chat_admin as l left join admin as a on a.admin_id = l.admin_id 
        where a.admin_level in (2,5,13) AND l.language_id = 1 AND a.is_leader = 1 AND l.is_new = 1');
    $leaderToSale = $saleToAss = [];
    if($leaders){
        //查询所有leader绑定的sale
        $sales = $db->getAll('select asta.sales,asta.assistant,lca.id,lca.stop_dist_time,lca.stop_auto,lca.next_total_num, 
            lca.insert_dist_num from admin_sales_to_assistant as asta 
            left join live_chat_admin as lca on asta.assistant = lca.admin_id 
            where asta.assistant_tag = 1 AND asta.sales in ('.implode(',',array_column($leaders,'admin_id')).') 
            AND lca.is_new = 1');
        if($sales){
            //查询所有sale绑定的assistant
            $assistants = $db->getAll('select asta.sales,asta.assistant,lca.id,lca.stop_dist_time,lca.stop_auto,lca.next_total_num, 
                lca.insert_dist_num from admin_sales_to_assistant as asta 
                left join live_chat_admin as lca on asta.assistant = lca.admin_id 
                where asta.assistant_tag = 2 AND asta.sales in ('.implode(',',array_column($sales,'assistant')).') 
                AND lca.is_new = 1');
            foreach ($assistants as $v){
                $saleToAss[$v['sales']][] = [
                    'assistant' => $v['assistant'],
                    'liveChatId' => $v['id'],
                    'stop_dist_time' => $v['stop_dist_time'],
                    'stop_auto' => $v['stop_auto'],
                    'next_total_num' => $v['next_total_num'],
                    'insert_dist_num' => $v['insert_dist_num'],
                ];
            }
        }
        foreach ($sales as $v){
            $leaderToSale[$v['sales']][] = [
                'assistant' => $v['assistant'],
                'liveChatId' => $v['id'],
                'stop_dist_time' => $v['stop_dist_time'],
                'stop_auto' => $v['stop_auto'],
                'next_total_num' => $v['next_total_num'],
                'insert_dist_num' => $v['insert_dist_num'],
            ];
        }
    }

    $nowTime = time();  //当前的时间戳
    $noDistData = [];   //下轮不参与分配的数据
    $distData = [];     //成功分配的数据
    $logData = [];      //分配数据记录
    foreach ($leaders as $v){
        $stopNum = 0;   //停分的数量
        $myGroupAdmin = [];     //自己小组的所有组员
        $mySale = !empty($leaderToSale[$v['admin_id']]) ? $leaderToSale[$v['admin_id']] : [];  //自己的销售
        foreach ($mySale as $saleInfo){
            $myGroupAdmin[] = $saleInfo;
            if($saleInfo['stop_dist_time'] > $nowTime){
                $stopNum ++;
            }
            $logData[$saleInfo['assistant']] = [
                'admin_id' => $saleInfo['assistant'],
                'leader_id' => $v['admin_id'],
                'language_id' => 1,
                'group_dist_num' => $v['customer_dist_num'],
                'dist_num' => $saleInfo['next_total_num'],
                'insert_num' => $saleInfo['insert_dist_num'],
                'is_stop' => 0,
                'total_dist_num' => 0
            ];
            if(!empty($saleToAss[$saleInfo['assistant']])){
                foreach ($saleToAss[$saleInfo['assistant']] as $assistantInfo){
                    $myGroupAdmin[] = $assistantInfo;
                    if($assistantInfo['stop_dist_time'] > time()){
                        $stopNum ++;
                    }
                    $logData[$assistantInfo['assistant']] = [
                        'admin_id' => $assistantInfo['assistant'],
                        'leader_id' => $v['admin_id'],
                        'language_id' => 1,
                        'group_dist_num' => $v['customer_dist_num'],
                        'dist_num' => $assistantInfo['next_total_num'],
                        'insert_num' => $assistantInfo['insert_dist_num'],
                        'is_stop' => 0,
                        'total_dist_num' => 0
                    ];
                }
            }
        }
        $actualBaseNum = $v['customer_dist_num'] - $stopNum;   //该小组剩余可分配的数量（不计入新增数量）
        //开始处理小组分配
        foreach ($myGroupAdmin as $groupAdminInfo){
            $next_total_num = $groupAdminInfo['next_total_num'];
            //如果是停分状态，下轮分配数-1
            if($groupAdminInfo['stop_dist_time'] > time()){
                $next_total_num -- ;
                $logData[$groupAdminInfo['assistant']]['is_stop'] = 1;
            }
            //如果销售的下一轮分配数为0，且没有新增分配数
            if($next_total_num <= 0 && ($next_total_num + $groupAdminInfo['insert_dist_num']) <= 0){
                $noDistData[] = $groupAdminInfo['liveChatId'];
                continue;
            }
            if($actualBaseNum > 0 || $groupAdminInfo['insert_dist_num'] > 0){   //如果还有剩余分配数或额外新增分配数
                if($actualBaseNum - $next_total_num >= 0){  //如果剩余分配数足够分配
                    $actualBaseNum -= $next_total_num;      //剩余分配数减去当前分配数
                    $nowDistNum = $next_total_num + $groupAdminInfo['insert_dist_num'];
                }else{   //如果剩余分配数不够
                    $nowDistNum = $actualBaseNum + $groupAdminInfo['insert_dist_num'];
                    $actualBaseNum = 0;      //剩余分配数已分配完
                }
                $distData[$groupAdminInfo['liveChatId']] = $nowDistNum;
                $logData[$groupAdminInfo['assistant']]['total_dist_num'] = $nowDistNum;
            }else{  //如果剩余分配数为0
                $noDistData[] = $groupAdminInfo['liveChatId'];
            }
        }
    }
    if($noDistData || $distData){
        $paramSql = [];
        $sqlWhere = [];
        if($noDistData){
            $paramSql[] = ' WHEN `id` in ('.implode(',',$noDistData).') THEN 0 ';
            $sqlWhere[] = '`id` in ('.implode(',',$noDistData).')';
        }
        if($distData){
            foreach ($distData as $id=>$distNum){
                $paramSql[] = ' WHEN `id` = '.$id.' THEN '.$distNum;
            }
            $sqlWhere[] = ' `id` in ('.implode(',',array_keys($distData)).')';
        }

        if($paramSql){
            $updateSql = implode(' ',$paramSql);
            $db->Execute('UPDATE `live_chat_admin` SET `this_already_num` = 0,
            `this_total_num` = CASE '.$updateSql.' END,`this_remain_num` = CASE '.$updateSql.' END 
            WHERE '.implode(' || ',$sqlWhere));
        }
    }
    //记录当前轮次的分配数据
    if($logData){
        zen_db_batch_inserts('live_chat_admin_assignment',['admin_id','leader_id','language_id','group_dist_num','dist_num','insert_num','is_stop','total_dist_num'],$logData);
    }
}

/**
 * 多语言新客户分配重置分配序列
 * @param $language_id
 */
function newCustomerAssignmentOther($language_id)
{
    global $db;
    $saleList = $db->getAll('select l.id,l.admin_id,l.stop_auto,l.next_total_num,l.insert_dist_num,l.stop_dist_time,l.customer_ceiling 
        from live_chat_admin as l right join admin as a on l.admin_id = a.admin_id where l.is_new = 1 AND l.language_id = '.$language_id);
    $saleCustomerNum = [];
    if($saleList){
        $total_customers = $db->getAll('select count(distinct mcc.company_number) as num,mcctc.admin_id 
                                                        from manage_customer_company as mcc
                                                        left join manage_customer_company_to_customers as mcctc on mcc.company_number = mcctc.company_number
                                                        where mcctc.admin_id in ('.implode(',',array_column($saleList,'admin_id')).') 
                                                        group by mcctc.admin_id');
        $saleCustomerNum = array_column($total_customers,'num','admin_id');
    }

    $noDistData = [];       //下轮不参与分配的数据
    $stopDistData = [];     //停分数据
    $stopDistLog = [];      //停分日志数据
    $logData = [];      //分配记录
    foreach ($saleList as $saleData){
        $logData[$saleData['admin_id']] = [
            'admin_id' => $saleData['admin_id'],
            'language_id' => $language_id,
            'dist_num' => $saleData['next_total_num'],
            'dist_ceiling' => $saleData['customer_ceiling'],
            'now_customers_num' => 0,
            'is_stop' => 0,
            'total_dist_num' => 0
        ];

        $next_total_num = $saleData['next_total_num'];
        //如果是停分状态，下轮分配数-1
        if($saleData['stop_dist_time'] > time()){
            $next_total_num -- ;
            $logData[$saleData['admin_id']]['is_stop'] = 1;
        }
        $customerNum = isset($saleCustomerNum[$saleData['admin_id']]) ? $saleCustomerNum[$saleData['admin_id']] : 0;
        $logData[$saleData['admin_id']]['now_customers_num'] = $customerNum;
        //如果销售的下一轮分配数为0
        if($next_total_num <= 0){
            $noDistData[] = $saleData['id'];
            continue;
        }
        //如果该销售的当前客户数已经大于客户数上限，则停止分配
        if($customerNum > $saleData['customer_ceiling']){
            $info = '重置分配序列，销售当前客户数('.$customerNum.')大于设置的客户数上限('.$saleData['customer_ceiling'].')，停止分配';
            $stopDistData[] = $saleData['id'];
            $stopDistLog[] = [$info, $saleData['admin_id'], 0, date('Y-m-d H:i:s'), 'live_chat_admin'];
            continue;
        }
        $updateData = [
            'this_total_num' => $next_total_num,
            'this_already_num' => 0,
            'this_remain_num' => $next_total_num
        ];
        $logData[$saleData['admin_id']]['total_dist_num'] = $next_total_num;
        zen_db_perform('live_chat_admin',$updateData,'update','id = '.$saleData['id']);
    }
    if($noDistData){
        zen_db_perform('live_chat_admin',['this_total_num'=>0,'this_already_num'=>0,'this_remain_num'=>0],'update','id in ('.implode(',',$noDistData).')');
    }
    if($stopDistData){
        zen_db_perform('live_chat_admin',['stop_auto'=>1,'this_total_num'=>0,'this_already_num'=>0,'this_remain_num'=>0],'update','id in ('.implode(',',$stopDistData).')');
    }
    if($stopDistLog){
        zen_db_batch_inserts('allot_sales_operation_log',['info','admin_id','who_do_this','do_time','do_table'],$stopDistLog);
    }
    if($logData){
        zen_db_batch_inserts('live_chat_admin_assignment',['admin_id','language_id','dist_num','dist_ceiling','now_customers_num','is_stop','total_dist_num'],$logData);
    }
}

function set_login_id($customer_id = ''){
    return true;
    if($customer_id == ''){
        if(!isset($_SESSION['customer_id'])) {
            return false;
        }else{
            $customer_id = $_SESSION['customer_id'];
        }
    }
    $redis = getRedis();
    $redis->select(9);
    $key = 'FS_LOGIN:'.md5('login_'.$customer_id);
    $size = $redis->sCard($key);
    if($size >= 20){
        $redis->delete($key);
    }
    $redis->sAdd($key,session_id());
    $redis->select(0);
    return true;
}

function remove_login_id($all = false, $customer_id = ''){
    return true;
    if($customer_id == ''){
        if(!isset($_SESSION['customer_id'])) {
            return false;
        }else{
            $customer_id = $_SESSION['customer_id'];
        }
    }
    $redis = getRedis();
    $redis->select(9);
    $key = 'FS_LOGIN:'.md5('login_'.$customer_id);
    if($all){
        $redis->delete($key);
    }else{
        $redis->sRem($key,session_id());
    }
    $redis->select(0);
    return true;
}

function check_login_id(){
    if(!isset($_SESSION['customer_id'])) {
        return false;
    }
    return true;
    $redis = getRedis();
    $redis->select(9);
    $key = 'FS_LOGIN:'.md5('login_'.$_SESSION['customer_id']);
    $result = $redis->sIsMember($key,session_id());
    $redis->select(0);
    return $result;
}

/**
 * @Notes:客户下单客户分配流程
 *
 * @param string $orders_id
 * @auther: Dylan
 * @Date: 2021/1/22
 * @Time: 11:12
 */
function customerOrderToAdmin($orders_id = '')
{
    $orders_id = (int)$orders_id;
    if (!$orders_id) {
        return;
    }
    if ($_SESSION['customer_id']) {
        $customerFields = array(
            'customers_email_address',
            'customer_country_id',
            'customers_regist_from',
            'customers_number_new',
            'is_disabled',
            'is_allot',
            'customers_firstname',
            'customers_lastname',
            'customers_telephone'
        );
        $customerInfo = fs_get_data_from_db_fields_array($customerFields,'customers','customers_id=' . $_SESSION['customer_id'], 'limit 1');
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
            switch ($customer_from) {
                case 'regist':
                    $allot_type = 'register_order';
                    break;
                case 'guest':
                    //游客下单进行分配销售
                    $allot_type = 'visitor_regist_order';
                    break;
                default:
                    //第三方登陆下单
                    $allot_type = 'third_party_login_order';
                    break;
            }
            $admin_id = customerToAdminUpdate([
                'allot_type' => $allot_type,
                'email_address' => $email_address,
                'orders_id' => $orders_id,
                'customers_country_id' => $customers_country_id,
            ]);
            adminToCustomerEmail([
                'admin_id' => $admin_id,
                'name' => $customerInfo[0][6] . ' ' . $customerInfo[0][7],
                'phone_number' => $customerInfo[0][8],
                'email_address' => $email_address,
            ]);
        }
        /* 游客下单已取消故屏蔽此代码 add dylan 2021.1.15
         * else {
            //游客不注册下单
            $customer_info = fs_get_data_from_db_fields_array(array('customers_email_address', 'billing_country', 'billing_name', 'billing_lastname', 'billing_telephone'), 'orders', 'orders_id=' . $orders_id, '');
            $customers_country_id = fs_get_data_from_db_fields('countries_id', 'countries', 'countries_name="' . trim($customer_info[0][1]) . '"', '');
            $admin_id = fs_get_data_from_db_fields('admin_id', 'order_to_admin', 'orders_id=' . $orders_id, '');
            $email_address = $customer_info[0][0];

            $allot_type = 'visitor_order';
            require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
            if ($admin_id) {
                $son_order = zen_get_all_son_order_id($orders_id);
                if ($son_order) {
                    $son_order[] = $orders_id;
                    for ($i = 0; $i < sizeof($son_order); $i++) {
                        $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $son_order[$i] . ")");
                    }
                } else {
                    $db->Execute("insert into order_to_admin (admin_id,orders_id) values(" . $admin_id . "," . $orders_id . ")");
                }
                //游客下单进行收货地址和账单地址的比对
                update_guest_customer_offline_address($email_address,$orders_id);

                // fairy 2018.8.30 add 针对进行经过自动分配的用户，如果该项分配当前销售。则也要把该用户分配给当前销售
                if ($admin_id && $email_address) {
                    auto_given_customers_to_admin(array(
                        'admin_id' => $admin_id,
                        'email_address' => $email_address,
                        'admin_id_from_table' => $admin_id_from_table,
                        'country' => $customers_country_id,
                        'firstname' => $customer_info[0][2],
                        'lastname' => $customer_info[0][3],
                        'telephone' => $customer_info[0][4],
                        'orders_id' => $orders_id,
                        'is_make_up' => $is_make_up ? : 0,
                        'from_auto_file' => 'auto_given',
                        'source' => 23,      // 客户来源：游客下单，不注册
                        'is_old' => $is_old ? $is_old : 0,   // 标记新、老客户
                        'customer_number' => $customers_customers_number_new,
                        'customer_offline_number' => $offline_customers_number_new,
                        'invalidSign' => $invalidSign,
                    ),true);
                }
            }
        }*/
    }
}

/**
 * @Notes:下单客户分配
 *
 * @param array $allotData
 * @return int
 * @auther: Dylan
 * @Date: 2021/1/15
 * @Time: 11:54
 */
function customerToAdminUpdate($allotData=[])
{
    global $db;
    $email_address = $allotData['email_address'];
    $orders_id = (int)$allotData['orders_id'];
    if ($email_address) {
        $allot_type = $allotData['allot_type'];
        $customers_country_id = $allotData['customers_country_id'];
        require_once(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
        if ($admin_id) {
            $stats_data = array(
                'stats_order' => 1,
                'is_make_up' => $is_make_up ? $is_make_up : 0,
                'remind' => 0,
                'is_old' => $is_old ? $is_old : 0,     // 标注新、老客户
            );
            zen_db_perform(TABLE_CUSTOMERS, $stats_data, 'update', 'customers_id=' . $_SESSION['customer_id']);


            // fairy 2018.8.30 add 如果该项分配当前销售。则也要把该用户分配给当前销售
            if ($admin_id && $_SESSION['customer_id'] && $email_address) {
                auto_given_customers_to_admin(array(
                    'admin_id' => $admin_id,
                    'email_address' => $email_address,
                    'admin_id_from_table' => $admin_id_from_table,
                    'customers_id' => $_SESSION['customer_id'], // 注册用户
                    'is_make_up' => $is_make_up ? $is_make_up : 0,
                    'from_auto_file' => 'auto_given',
                    'is_old' => $is_old ? $is_old : 0,        // 标注新、老客户
                    'customer_number' => $customers_customers_number_new,
                    'customer_offline_number' => $offline_customers_number_new,
                    'invalidSign' => $invalidSign,
                ));
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
        }
    }
    return $admin_id ? $admin_id : 0;
}

/**
 * @Notes:客户下单分配 邮件  提醒销售
 *
 * @param array $data
 * @auther: Dylan
 * @Date: 2021/1/15
 * @Time: 11:20
 */
function adminToCustomerEmail($data=[])
{
    $admin_id = $data['admin_id'] ? $data['admin_id'] : 0;
    $name = $data['name'] ? $data['name'] : '';
    $phone_number = $data['phone_number'] ? $data['phone_number'] : '';
    $email_address = $data['email_address'] ? $data['email_address'] : '';
    if ($admin_id && $_SESSION['customer_id'] && $email_address) {
        global $db;
        define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
        $sales_email = fs_get_data_from_db_fields('admin_email', 'admin', 'admin_id=' . $admin_id, '');
        $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
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
        $html_msg_us['PHONE_NUMBER'] = $phone_number ? $phone_number : 'not set yet';
        $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
        $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
        $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
        $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
        $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';
        if ($sales_email) {
            zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
        }
    }
}
?>