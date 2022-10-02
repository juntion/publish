<?php
	require 'includes/application_top.php';
//ini_set("display_errors", "On");
//error_reporting(E_ERROR);
////todo:test
//$_GET['ajax_request_action'] = 'facebook';
//$_POST['name'] = "Daye Chen";
//$_POST['id'] = 123456789;
//$_POST ['email'] = 'chendage78945@gmail.ocm';
//$_POST ['email'] = 'hknetworking@Gmail.com';
require_once('includes/languages/english/views/validation.common.php'); // 表单验证语言包
if (isset($_GET['ajax_request_action'])){
	$action = $_GET['ajax_request_action'];
    if($_POST['email']  && get_user_blacklist($_POST['email'])){
        echo json_encode(array("msg"=>"ok","url"=>zen_href_link(FILENAME_DEFAULT)));
        exit;
    }
		switch($action){
            case 'third_party_bind_handle': //2018.??? 新增 绑定已有账户处理 或者跳过，执行新增
                if ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) {
                    exit(json_encode(array('status' => 0, 'data' => FS_SECURITY_ERROR, 'info' => FS_SECURITY_ERROR)));
                }

                $third_party_type = $_SESSION['third_party_type'];
                $third_party_id = (int)$_SESSION['third_party_id'];
                if (!$third_party_id || !$third_party_type) {
                    exit(json_encode(array('status' => 0, 'data' => FS_SYSTME_BUSY, 'info' => FS_SYSTME_BUSY)));
                }
                $email = $_POST['email']?zen_db_prepare_input(trim($_POST['email'])):'';
                $password = $_POST['password']?zen_db_prepare_input($_POST['password']):'';
                switch ($third_party_type){
                    case "google":
                        $google_result = $db->Execute('select * from customers_social_media_google_info where customers_google_account_info_id =' . $third_party_id);
                        $social_media_id = 4;
                        $source = 27; // 便于标记客户来源定位重复注册位置
                        break;
                    case "linkedin":
                        $google_result = $db->Execute('select * from customers_social_media_linkedin_info where customers_LinkedIn_account_info_id  =' . $third_party_id);
                        $social_media_id = 3;
                        $source = 33;
                        break;
                    case "facebook":
                        $google_result = $db->Execute('select * from customers_social_media_facebook_info where customers_social_media_facebook_id   =' . $third_party_id);
                        $social_media_id = 1;
                        $source = 31;
                        break;
                    case "paypal":
                        $google_result = $db->Execute('select * from customers_social_media_paypal_info where customers_paypal_account_id    =' . $third_party_id);
                        $social_media_id = 5;
                        $source = 29;
                        break;

                }
                if (!$google_result->RecordCount()) {
                    exit(json_encode(array('status' => 0, 'data' => '', 'info' => '')));
                }

                if ($email) { // 如果绑定已有账号
                    //验证
                    $regist_valide = get_current_valide('username', array(
                        'email' => array(),
                        'password' => array('common_name'=>'old_password'),
                        'validate' => array(),
                    ));
                    require_once('includes/templates/fiberstore/common/fs_valide_common.php');
                    //验证码验证
                    if (isset($_POST["validate"]) && ($_POST["validate"] != $_SESSION["authnum_session"])) {
                        exit(json_encode(array('status' => 0, 'data' => '', 'info' => FS_IMAGE_FORM_TIP)));
                    }
                    //邮箱验证
                    $check_customer_query = "SELECT customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                               FROM " . TABLE_CUSTOMERS . "
                               WHERE customers_email_address = :emailAddress ";
                    $check_customer_query = $db->bindVars($check_customer_query, ':emailAddress', $email, 'string');
                    $customer_result = $db->Execute($check_customer_query);
                    if ($customer_result->RecordCount() < 1) {
                        exit(json_encode(array('status' => 0, 'data' => '', 'info' => FS_EMAIL_NOT_FOUND_TIP)));
                    }
                    if ($customer_result->fields['customers_authorization'] == '4') {
                        exit(json_encode(array('status' => 0, 'data' => '', 'info' => FS_ACCESS_DENIED)));
                    }
                    // 密码验证
                    if (!zen_validate_password($password, $customer_result->fields['customers_password'])) {
                        exit(json_encode(array('status' => 0, 'data' => '', 'info' => FS_PASSWORD_ERROR_TIP)));
                    }
                    //绑定
                    $google_plus_info = array(
                        'customers_id' => $customer_result->fields['customers_id'],
                    );
                    switch ($third_party_type){
                        case "google":
                            zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info, 'update', 'customers_google_account_info_id = "'.$third_party_id.'"');
                            break;
                        case "linkedin":
                            zen_db_perform("customers_social_media_linkedin_info", $google_plus_info, 'update', 'customers_LinkedIn_account_info_id  = "'.$third_party_id.'"');
                            break;
                        case "facebook":
                            zen_db_perform("customers_social_media_facebook_info", $google_plus_info, 'update', 'customers_social_media_facebook_id   = "'.$third_party_id.'"');
                            break;
                        case "paypal":
                            zen_db_perform("customers_social_media_paypal_info", $google_plus_info, 'update', 'customers_paypal_account_id    = "'.$third_party_id.'"');
                            break;
                    }

                    //设置登录session和cookie
                    set_login_session($customer_result,$password);
                } else {
                    // 如果没有传password，exit
                    if (!$password) {
                        exit(json_encode(array('status' => 0, 'data' => FS_SYSTME_BUSY, 'info' => FS_SYSTME_BUSY)));
                    }

                    $now_time = date('Y-m-d H:i:s');

                    $email_address = $_SESSION['third_user_info']['email'];
                    $country_code = $_SESSION['user_ip_info']['ipCountryCode'];
                    $new_password = zen_db_prepare_input($_POST['password']);
                    $crypted_password = zen_encrypt_password($new_password);
                    $country_id = $country_code ? fs_get_country_id_of_code(strtoupper($country_code)) : 223;

                    $res = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                    from customers where customers_email_address = '" .  $email_address . "'");

                    if($res->fields['customers_id'] && !$res->fields['customers_password']){
                        //如果之前用户已经注册但是没有设置密码
                        $customer_sql = array('customers_password' => $crypted_password);
                        $update_res = zen_db_perform('customers', $customer_sql, 'update', 'customers_id=' . $res->fields['customers_id']);

                        //设置登录session和cookie
                        $customer_info= $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                        from customers where customers_id = '" .  $res->fields['customers_id'] . "'");

                        set_login_session($customer_info,'',false);
                    }else{
                        //如果查不到customers_id，说明是全新用户
                        if($res->fields['customers_id']){
                            exit(json_encode(array('status' => 2, 'data' => array('jump_url'=>zen_href_link(FILENAME_MY_DASHBOARD)), 'info' => '')));
                        }

                        // 添加用户表                       
                        $customer = array(
                            'customers_firstname' => $_SESSION['third_user_info']['first_name'],
                            'customers_lastname' => $_SESSION['third_user_info']['last_name'],
                            'customers_email_address' => $email_address,
                            'customers_dob' => $now_time,
                            'social_media_id' => $social_media_id,
                            'customer_country_id' => $country_id,
                            'language_id' => (int)$_SESSION['languages_id'],
                            'language_code'=>$_SESSION['languages_code'],
                            'customers_info_date_account_created' =>date('Y-m-d H:i:s'),
                            'customers_password' => $crypted_password,
                        );
                        $customers_country_id = $country_id;
                        $allot_type = 'third_register';
                        //分配判断代码应置于插入数据之前,自动分配文件中叫$email_address而不是$email
                        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                        $customer['is_make_up'] = $is_make_up ? : 0;
                        $customer['is_old'] = $is_old ? $is_old : 0;     // 标记新、老客户
                        if ($admin_id) {
                            //邮箱匹配到了 标记老客户 用于统计
                            $customer['is_old'] = $is_old;
                        }

                    // zen_db_perform(TABLE_CUSTOMERS, $customer);
                    // $customers_id = $db->Insert_ID();
                        $customer['source'] = $source ? $source : 35;  // 便于定位重复注册账号的来源
                        // 防止重复插入
                        $customer_info = fs_get_data_from_db_fields('customers_id', TABLE_CUSTOMERS, 'customers_email_address="' . $email_address . '"', 'limit 1');
                        if ($customer_info) {
                            $email_checked = false;
                            $customers_id = $customer_info;
                        } else {
                            $email_checked = true;
                            $customer['from_where'] = isMobile() ? 2 : 1;        // 客户来源
                            zen_db_perform(TABLE_CUSTOMERS, $customer);
                            $customers_id = $db->Insert_ID();
                        }


                        if ($email_address) {
                            $prefix_email = substr($email_address, 0, (stripos($email_address, '@') + 1)); // 邮箱前缀
                            $postfix_email = strtolower(strrchr($email_address, '@'));  // 邮箱后缀
                        }
                        $allot_arr = [
                            'customers_email_address' => $email_address,
                            'customer_country_id' => $country_id ? $country_id : 223,
                            'customers_telephone' => $phone_number ? $phone_number : '',
                            'create_time' => time(),
                            'language_id' => in_array($_SESSION['languages_id'],['1', '2', '3', '4', '5', '8']) ? (int)$_SESSION['languages_id'] : 1,
                            'prefix_email' => $prefix_email ? $prefix_email : '',
                            'postfix_email' => $postfix_email ? $postfix_email : '',
                            'language_code' => $_SESSION['countries_code_21'] ? $_SESSION['countries_code_21'] : '',
                            'is_allot' => $admin_id ? 1 : 0,
                            'customers_id' => $customers_id,
                        ];
                        zen_db_perform('customers_register_allot', $allot_arr);
                        $id = $db->insert_ID();
                        $final = ($email_checked && $customers_id && $id);
                        if (!$final) {
                            $db->Execute("ROLLBACK");
                            $marked_words = 'Account information verification failed.';
                            if ($is_error) $marked_words = $is_error;
                            exit(json_encode(array('status' => '0', 'data' => '', 'info' => $marked_words)));
                        } else {
                            $db->Execute("COMMIT");
                        }

                        //绑定
                        $google_plus_info = array(
                            'customers_id' => $customers_id,
                        );

                        //$google_plus_info = insert_db_time($google_plus_info, false, $current_customer_id);
                        switch ($third_party_type){
                            case "google":
                                zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info, 'update', 'customers_google_account_info_id = "'.$third_party_id.'"');
                                break;
                            case "linkedin":
                                zen_db_perform("customers_social_media_linkedin_info", $google_plus_info, 'update', 'customers_LinkedIn_account_info_id  = "'.$third_party_id.'"');
                                break;
                            case "facebook":
                                zen_db_perform("customers_social_media_facebook_info", $google_plus_info, 'update', 'customers_social_media_facebook_id   = "'.$third_party_id.'"');
                                break;
                            case "paypal":
                                zen_db_perform("customers_social_media_paypal_info", $google_plus_info, 'update', 'customers_paypal_account_id    = "'.$third_party_id.'"');
                                break;
                        }
                        if ($admin_id) {
                            $date = get_common_cn_time();
                            $sql = 'INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("' . $admin_id . '","' . $customers_id . '","'.$date.'","'.time().'")';
                            $db->Execute($sql);


                            // fairy 2018.8.31 add 如果不是公共后缀邮箱，把公海中相同后缀也分配
                            $seanArr = array(
                                'email_address' => $email_address,
                                'customer_number' => '',
                                'customer_offline_number' => '',
                                'invalidSign' => $invalidSign,
                            );
                            auto_given_open_seas_customers($seanArr,$admin_id);

                            //客户自动关联
                            if($admin_id && $email_address){
                                auto_given_customer_manage($admin_id,$email_address,1);
                            }

                            // 发送注册成功邮件
                            send_person_regist_email($email_address);
                            // 给对应后台销售发邮件
                            $sales_email = zen_admin_email_of_id($admin_id);
                            $html = zen_get_corresponding_languages_email_common();
                            $html_msg['EMAIL_HEADER'] = $html['html_header'];
                            $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                            $html_msg['CUSTOMER_NAME'] = $_SESSION['third_user_info']['first_name'] . $_SESSION['third_user_info']['last_name'] ? $_SESSION['third_user_info']['first_name'] . $_SESSION['third_user_info']['last_name'] : 'not set yet';
                            $html_msg['NUMBER'] = $telephone ? $telephone : 'not set yet';
                            $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                            sendwebmail($sales_email,$sales_email,'第三方登陆邮件发送给销售:'.date('Y-m-d H:i:s', time()),STORE_NAME,'Customer Info',$html_msg,'regist_to_us');
                        }
                        $customer_info= $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                        from customers where customers_id = '" .  $customers_id . "'");
                        //设置登录session和cookie
                        set_login_session($customer_info,'',false);
                    }
                }

                // 更新最后一次的登录记录
                zen_update_one_customers_info($_SESSION['customer_id']);

                // 添加登录记录
                zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

                // bof: contents merge notice
                if (SHOW_SHOPPING_CART_COMBINED > 0) {
                    $zc_check_basket_before = $_SESSION['cart']->count_contents();
                }
                $_SESSION['cart']->restore_contents();
                if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                    $zc_check_basket_after = $_SESSION['cart']->count_contents();
                    if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                        if (SHOW_SHOPPING_CART_COMBINED == 2) {
                            // warning only do not send to cart
                            $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                        }
                        if (SHOW_SHOPPING_CART_COMBINED == 1) {
                            // show warning and send to shopping cart for review
                            $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                            $jump_url = FILENAME_SHOPPING_CART;
                        }
                    }
                }
                // eof: contents merge notice

                if(!$jump_url){
                    $jump_url = return_login_jump_url();
                }
                unset($_SESSION['third_party_type']);
                unset($_SESSION['third_party_id']);
                unset($_SESSION['third_user_name']);
                unset($_SESSION['third_user_info']);
                exit(json_encode(array('status' => 1, 'data' => array('jump_url'=>zen_href_link(FILENAME_MY_DASHBOARD)), 'info' => '')));
                break;
            case 'google':
                if($_POST['email'] != null){
                    $google_plus_id = zen_db_prepare_input($_POST['gid']);
                    $first_name = $_POST['fName'] ? zen_db_prepare_input($_POST['fName']) : "";
                    $last_name = $_POST['gName'] ? zen_db_prepare_input($_POST['gName']) : "";
                    $name = $first_name." ".$last_name;
                    $email = zen_db_prepare_input( $_POST ['email'] );
                    $gender = $_POST['gender'] ? zen_db_prepare_input($_POST['gender']):"";
                    $email = zen_db_prepare_input($_POST['email']);
                    $jump_url = FILENAME_MY_DASHBOARD;
                    $google_result = $db->Execute('select customers_google_account_info_id,customers_id from customers_social_media_google_info where google_plus_email = "' .  $email . '"');
                    $link_customers_id = $google_result->fields['customers_id'];
                    $where = "";
                    if($link_customers_id){
                        $where = " or customers_id=".$link_customers_id;
                    }
                    $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                    from customers where customers_email_address = '" .  $email . "'".$where);
                    if ($result->RecordCount()) { //如果改谷歌邮箱在我们用户表里面找到
                        $is_first_bind = 0;
                        $current_customer_id = $result->fields['customers_id'];
                        $customers_password = $result->fields["customers_password"];
                        if ($google_result->RecordCount()) {
                            $google_plus_info = array(
                                'google_plus_id' => $google_plus_id,
                                'google_plus_email' => $email,
                                'google_plus_name' => $name,
                                'google_plus_gender' => $gender,
                                'customers_id' => $current_customer_id,
                            );
                            //    $google_plus_info = insert_db_time($google_plus_info, false, $current_customer_id);
                            zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info, 'update', 'customers_google_account_info_id = "' . $google_result->fields['customers_google_account_info_id'] . '"');
                        } else { // 第3方表没有记录，则添加，自动绑定
                            $google_plus_info = array(
                                'google_plus_id' => $google_plus_id,
                                'google_plus_email' => $email,
                                'google_plus_name' => $name,
                                'google_plus_gender' => $gender,
                                'customers_id' => $current_customer_id,
                            );
                        //    $google_plus_info = insert_db_time($google_plus_info, true, $current_customer_id);
                            zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info);
                        }

                        if(!empty($customers_password)){
                            // 如果已经设置了密码,保持原来的流程不变,用户直接登陆.此处不会要求客户输入账号密码
                            $jump_url = "redirect_process";

                            //更新用户信息表
                            $customer_info = array(
                                'customers_firstname' => $first_name,
                                'customers_lastname' => $last_name,
                            );
                            if($first_name&&$last_name){
                                if(empty($result->fields["customers_firstname"])&&empty($result->fields["customers_lastname"])){
                                    zen_db_perform(TABLE_CUSTOMERS, $customer_info,"update","customers_id=".$current_customer_id);
                                }
                            }
                            //设置登录session和cookie
                            set_login_session($result);

                            // 更新最后一次的登录记录
                            zen_update_one_customers_info($_SESSION['customer_id']);

                            // 添加登录记录
                            zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

                            // bof: contents merge notice
                            if (SHOW_SHOPPING_CART_COMBINED > 0) {
                                $zc_check_basket_before = $_SESSION['cart']->count_contents();
                            }
                            $_SESSION['cart']->restore_contents();
                            if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                                $zc_check_basket_after = $_SESSION['cart']->count_contents();
                                if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                                    if (SHOW_SHOPPING_CART_COMBINED == 2) {
                                        // warning only do not send to cart
                                        $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                    if (SHOW_SHOPPING_CART_COMBINED == 1) {
                                        // show warning and send to shopping cart for review
                                        $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                }
                            }
                            // eof: contents merge notice
                            $_SESSION['third_party_type'] = 'google';
                            echo json_encode(array("msg"=>"ok","url"=>zen_href_link($jump_url)));
                        }else{
                            // 此时如果用户没有设置密码,跳转bind页面
                            if($google_result->RecordCount()){
                                $google_plus_info_id = $google_result->fields['customers_google_account_info_id'];
                            }else{
                                $google_plus_info_id = '';
                            }
                            $_SESSION['third_party_id'] = $google_plus_info_id;
                            $_SESSION['third_party_type'] = 'google';
                            $_SESSION['third_user_name'] = $name;
                            $_SESSION['third_user_info'] = array(
                                'id' => $google_plus_id,
                                'email' => $email,
                                'first_name' =>  $first_name,
                                'last_name' =>  $last_name,
                                'gender' => $gender,
                                'customers_id' => $current_customer_id,
                            );

                            $return =  [
                                "msg" => "ok",
                                "url" => zen_href_link('third_party_bind'),
                            ];
                            echo json_encode($return);
                        }
                       
                    } else { // 如果没有，说明是第一次
                        $google_plus_info = array(
                            'google_plus_id' => $google_plus_id,
                            'google_plus_email' => $email,
                            'google_plus_name' => $name,
                            'google_plus_gender' => $gender
                        );

                        if($google_result->RecordCount()){
                            $google_plus_info_id = $google_result->fields['customers_google_account_info_id'];
                        }else{
                            zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info);
                            $google_plus_info_id = $db->Insert_ID();
                        }

                        $_SESSION['third_party_type'] = 'google';
                        $_SESSION['third_party_id'] = $google_plus_info_id;
                        $_SESSION['third_party_from_url'] = 'social_media/google.php';
                        $_SESSION['third_user_name'] = $name;
                        $_SESSION['third_user_info'] = array(
                            'id' => $google_plus_id,
                            'email' => $email,
                            'first_name' =>  $first_name,
                            'last_name' =>  $last_name,
                            'gender' => $gender,
                        );
                        echo json_encode(array("msg"=>"ok","url"=>zen_href_link('third_party_bind')));
                    }
                    //header('Location: http://www.fiberstore.com');
                }
                break;


			case 'paypal':
			if($_POST['email'] != null){
				 $first_name = zen_db_prepare_input($_POST['fName']);
				 $last_name = zen_db_prepare_input($_POST['gName']);
				 $name = $first_name." ".$last_name;
				 $email = zen_db_prepare_input( $_POST ['email'] );
				 $zoneinfo = zen_db_prepare_input($_POST['zoneinfo']);
                 $jump_url = FILENAME_MY_DASHBOARD;
                 $google_result = $db->Execute('select customers_paypal_account_id,customers_id from customers_social_media_paypal_info where paypal_email = "' .  $email . '"');
                 $link_customers_id = $google_result->fields['customers_id'];
                 $where = "";
                 if($link_customers_id){
                  $where = " or customers_id=".$link_customers_id;
                 }
                $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                    from customers where customers_email_address = '" .  $email . "'".$where);
                if ($result->RecordCount()) { //如果改谷歌邮箱在我们用户表里面找到
                    $is_first_bind = 0;
                    $current_customer_id = $result->fields['customers_id'];
                    $customers_password = $result->fields["customers_password"];
                    if ($google_result->RecordCount()) {
                        $google_plus_info = array(
                            'customers_id' => $current_customer_id,
                            'paypal_family_name' => $first_name,
                            'paypal_given_name' => $last_name,
                            'paypal_zoneinfo' => $zoneinfo,
                            'paypal_email' => $email
                        );
                        zen_db_perform("customers_social_media_paypal_info", $google_plus_info, 'update', 'customers_paypal_account_id   = "' . $google_result->fields['customers_paypal_account_id'] . '"');
                        if(!empty($customers_password)){
                            $jump_url = "redirect_process";
                        }
                    } else { // 第3方表没有记录，则添加，自动绑定
                        $google_plus_info = array(
                            'customers_id' => $current_customer_id,
                            'paypal_family_name' => $first_name,
                            'paypal_given_name' => $last_name,
                            'paypal_zoneinfo' => $zoneinfo,
                            'paypal_email' => $email
                        );
//                            $google_plus_info = insert_db_time($google_plus_info, true, $current_customer_id);
                        zen_db_perform("customers_social_media_paypal_info", $google_plus_info);
                        if(!empty($customers_password)){
                            $jump_url = "redirect_process";
                        }
                    }

                    if(!empty($customers_password)){
                        //更新用户信息表
                        $customer_info = array(
                            'customers_firstname' => $first_name,
                            'customers_lastname' => $last_name,
                        );
                        if($first_name&&$last_name){
                            if(empty($result->fields["customers_firstname"])&&empty($result->fields["customers_lastname"])){
                                zen_db_perform(TABLE_CUSTOMERS, $customer_info,"update","customers_id=".$current_customer_id);
                            }
                        }
                        //设置登录session和cookie
                        set_login_session($result);

                        // 更新最后一次的登录记录
                        zen_update_one_customers_info($_SESSION['customer_id']);

                        // 添加登录记录
                        zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

                        // bof: contents merge notice
                        if (SHOW_SHOPPING_CART_COMBINED > 0) {
                            $zc_check_basket_before = $_SESSION['cart']->count_contents();
                        }
                        $_SESSION['cart']->restore_contents();
                        if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                            $zc_check_basket_after = $_SESSION['cart']->count_contents();
                            if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                                if (SHOW_SHOPPING_CART_COMBINED == 2) {
                                    // warning only do not send to cart
                                    $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                }
                                if (SHOW_SHOPPING_CART_COMBINED == 1) {
                                    // show warning and send to shopping cart for review
                                    $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                }
                            }
                        }
                        // eof: contents merge notice
                        $_SESSION['third_party_type'] = 'paypal';
                        echo json_encode(array("msg"=>"ok","url"=>zen_href_link($jump_url)));
                    }else{
                        // 此时如果用户没有设置密码,跳转设置密码页面
                        if($google_result->RecordCount()){
                            $google_plus_info_id = $google_result->fields['customers_paypal_account_id'];
                        }else{
                            $google_plus_info_id = '';
                        }
                        $_SESSION['third_party_id'] = $google_plus_info_id;
                        $_SESSION['third_party_type'] = 'paypal';
                        $_SESSION['third_user_name'] = $name;
                        $_SESSION['third_user_info'] = array(
                            'id' => $google_plus_id,
                            'email' => $email,
                            'first_name' =>  $first_name,
                            'last_name' =>  $last_name,
                            'gender' => $gender,
                            'customers_id' => $current_customer_id,
                        );

                        $return =  [
                            "msg" => "ok",
                            "url" => zen_href_link('third_party_bind'),
                        ];
                        echo json_encode($return);
                    }

                } else { // 如果没有，说明是第一次
                    $google_plus_info = array(
                        'paypal_family_name' => $first_name,
                        'paypal_given_name' => $last_name,
                        'paypal_zoneinfo' => $zoneinfo,
                        'paypal_email' => $email
                    );
//                        $google_plus_info = insert_db_time($google_plus_info, true);
                    if($google_result->RecordCount()){
                        $google_plus_info_id = $google_result->fields['customers_paypal_account_id'];
                    }else{
                        zen_db_perform("customers_social_media_paypal_info", $google_plus_info);
                        $google_plus_info_id = $db->Insert_ID();
                    }

                    $_SESSION['third_party_type'] = 'paypal';
                    $_SESSION['third_party_id'] = $google_plus_info_id;
                    $_SESSION['third_party_from_url'] = 'social_media/paypal.php';
                    $_SESSION['third_user_name'] = $name;
                    $_SESSION['third_user_info'] = array(
                        'id' => $google_plus_info_id,
                        'email' => $email,
                        'first_name' =>   $first_name,
                        'last_name' =>  $last_name,
                    );
                    echo json_encode(array("msg"=>"ok","url"=>zen_href_link('third_party_bind')));
                }
			}
			break;

            case 'facebook':
                //exit(json_encode($_POST['email']));
                if($_POST['email'] != null){
                    //todo:获取用户数据
                    $google_plus_id = zen_db_prepare_input($_POST['gid']);
                    $first_name = $_POST['fName'] ? zen_db_prepare_input($_POST['fName']) : "";
                    $last_name = $_POST['gName'] ? zen_db_prepare_input($_POST['gName']) : "";
                    $name = $first_name." ".$last_name;
                    $email = zen_db_prepare_input( $_POST ['email'] );
                    $gender = $_POST['gender'] ? zen_db_prepare_input($_POST['gender']):"";
                    $email = zen_db_prepare_input($_POST['email']);
                    //todo:根据邮箱匹配用户
                    $jump_url = FILENAME_MY_DASHBOARD;
                    $google_result = $db->Execute('select customers_social_media_facebook_id ,customers_id from customers_social_media_facebook_info where facebook_email = "' .  $email . '"');
                    $link_customers_id = $google_result->fields['customers_id'];
                    $where = "";
                    if($link_customers_id){
                        $where = " or customers_id=".$link_customers_id;
                    }
                    $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                    from customers where customers_email_address = '" .  $email . "'".$where);
                    if ($result->RecordCount()) { //如果改谷歌邮箱在我们用户表里面找到
                        $is_first_bind = 0;
                        $current_customer_id = $result->fields['customers_id'];
                        $customers_password = $result->fields["customers_password"];
                        if ($google_result->RecordCount()) {
                            $google_plus_info = array(
                                'customers_id' => $current_customer_id,
                                'facebook_name' => $name
                            );
                            zen_db_perform("customers_social_media_facebook_info", $google_plus_info, 'update', 'customers_social_media_facebook_id   = "' . $google_result->fields['customers_social_media_facebook_id'] . '"');
                            if(!empty($customers_password)){
                                $jump_url = "redirect_process";
                            }
                        } else { // 第3方表没有记录，则添加，自动绑定
                            $google_plus_info = array(
                                'facebook_id' => $google_plus_id,
                                'facebook_name' => $name,
                                'facebook_email' => $email,
                                'customers_id' => $current_customer_id
                            );
//                            $google_plus_info = insert_db_time($google_plus_info, true, $current_customer_id);
                            zen_db_perform("customers_social_media_facebook_info", $google_plus_info);
                            if(!empty($customers_password)){
                                $jump_url = "redirect_process";
                            }
                        }
                        if(!empty($customers_password)){
                            // 如果已经设置了密码,保持原来的流程不变,用户直接登陆.此处不会要求客户输入账号密码
                            //更新用户信息表
                            $customer_info = array(
                                'customers_firstname' => $first_name,
                                'customers_lastname' => $last_name,
                            );
                            if($first_name&&$last_name){
                                if(empty($result->fields["customers_firstname"])&&empty($result->fields["customers_lastname"])){
                                    zen_db_perform(TABLE_CUSTOMERS, $customer_info,"update","customers_id=".$current_customer_id);
                                }
                            }
                            //设置登录session和cookie
                            set_login_session($result);

                            // 更新最后一次的登录记录
                            zen_update_one_customers_info($_SESSION['customer_id']);

                            // 添加登录记录
                            zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

                            // bof: contents merge notice
                            if (SHOW_SHOPPING_CART_COMBINED > 0) {
                                $zc_check_basket_before = $_SESSION['cart']->count_contents();
                            }
                            $_SESSION['cart']->restore_contents();
                            if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                                $zc_check_basket_after = $_SESSION['cart']->count_contents();
                                if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                                    if (SHOW_SHOPPING_CART_COMBINED == 2) {
                                        // warning only do not send to cart
                                        $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                    if (SHOW_SHOPPING_CART_COMBINED == 1) {
                                        // show warning and send to shopping cart for review
                                        $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                }
                            }
                            // eof: contents merge notice
                            $_SESSION['third_party_type'] = 'facebook';
                            echo json_encode(array("msg"=>"ok","url"=>zen_href_link($jump_url)));
                        }else{
                            // 此时如果用户没有设置密码,跳转设置密码页面
                            if($google_result->RecordCount()){
                                $google_plus_info_id = $google_result->fields['customers_social_media_facebook_id'];
                            }else{
                                $google_plus_info_id = '';
                            }
                            $_SESSION['third_party_id'] = $google_plus_info_id;
                            $_SESSION['third_party_type'] = 'facebook';
                            $_SESSION['third_user_name'] = $name;
                            $_SESSION['third_user_info'] = array(
                                'id' => $google_plus_id,
                                'email' => $email,
                                'first_name' =>  $first_name,
                                'last_name' =>  $last_name,
                                'gender' => $gender,
                                'customers_id' => $current_customer_id,
                            );

                            $return =  [
                                "msg" => "ok",
                                "url" => zen_href_link('third_party_bind'),
                            ];
                            echo json_encode($return);
                        }
                       
                    } else { // 如果没有，说明是第一次
                        $google_plus_info = array(
                            'facebook_id' => $google_plus_id,
                            'facebook_name' => $name,
                            'facebook_email' => $email
                        );
//                        $google_plus_info = insert_db_time($google_plus_info, true);
                        if($google_result->RecordCount()){
                            $google_plus_info_id = $google_result->fields['customers_social_media_facebook_id'];
                        }else{
                            zen_db_perform("customers_social_media_facebook_info", $google_plus_info);
                            $google_plus_info_id = $db->Insert_ID();
                        }

                        $_SESSION['third_party_type'] = 'facebook';
                        $_SESSION['third_party_id'] = $google_plus_info_id;
                        $_SESSION['third_party_from_url'] = 'social_media/facebook.php';
                        $_SESSION['third_user_name'] = $name;
                        $_SESSION['third_user_info'] = array(
                            'id' => $google_plus_info_id,
                            'email' => $email,
                            'first_name' =>   $first_name,
                            'last_name' =>  $last_name,
                        );
                        echo json_encode(array("msg"=>"ok","url"=>zen_href_link('third_party_bind')));
                    }
                }else{
                    exit(json_encode('ok'));    //用户没邮箱
                }
            break;
			case 'Linkedin':
				if($_POST['email'] != null){
					$firstname = zen_db_prepare_input($_POST['fName']);
					$lastname = zen_db_prepare_input($_POST['gName']);
					$email = zen_db_prepare_input($_POST['email']);
					$linkedin_id = $_POST['gid'];
                    $name = $firstname." ".$lastname;
					//todo:根据邮箱匹配用户
                    $jump_url = FILENAME_MY_DASHBOARD;
                    $google_result = $db->Execute('select customers_LinkedIn_account_info_id ,customers_id from customers_social_media_linkedin_info where linkedin_id = "' .  $linkedin_id . '"');
                    $link_customers_id = $google_result->fields['customers_id'];
                    //如果非空，说明用户已经注册
                    $where = "";
                    if($link_customers_id){
                        $where = " or customers_id=".$link_customers_id;
                    }
                    $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_lastname,customers_default_address_id,customers_authorization,member_level,customers_password
                    from customers where customers_email_address = '" .  $email . "'".$where);
                    if ($result->RecordCount()) { //如果改谷歌邮箱在我们用户表里面找到
                        $is_first_bind = 0;
                        $current_customer_id = $result->fields['customers_id'];
                        $customers_password = $result->fields["customers_password"];
                        if ($google_result->RecordCount()) {
                            $google_plus_info = array(
                                'customers_id' => $current_customer_id,
                            );
                            zen_db_perform("customers_social_media_linkedin_info", $google_plus_info, 'update', 'customers_LinkedIn_account_info_id  = "' . $google_result->fields['customers_LinkedIn_account_info_id'] . '"');
                            if(!empty($customers_password)){
                                $jump_url = "redirect_process";
                            }
                        } else { // 第3方表没有记录，则添加，自动绑定
                            $google_plus_info = array(
                                'linkedin_id' => $linkedin_id,
                                'customers_id' => $current_customer_id
                            );
//                            $google_plus_info = insert_db_time($google_plus_info, true, $current_customer_id);
                            zen_db_perform("customers_social_media_linkedin_info", $google_plus_info);
                            if(!empty($customers_password)){
                                $jump_url = "redirect_process";
                            }
                        }

                        if(!empty($customers_password)){
                             //更新用户信息表
                            $customer_info = array(
                                'customers_firstname' => $firstname,
                                'customers_lastname' => $lastname,
                            );
                            if($firstname&&$lastname){
                                if(empty($result->fields["customers_firstname"])&&empty($result->fields["customers_lastname"])){
                                    zen_db_perform(TABLE_CUSTOMERS, $customer_info,"update","customers_id=".$current_customer_id);
                                }
                            }
                            //设置登录session和cookie
                            set_login_session($result);

                            // 更新最后一次的登录记录
                            zen_update_one_customers_info($_SESSION['customer_id']);

                            // 添加登录记录
                            zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

                            // bof: contents merge notice
                            if (SHOW_SHOPPING_CART_COMBINED > 0) {
                                $zc_check_basket_before = $_SESSION['cart']->count_contents();
                            }
                            $_SESSION['cart']->restore_contents();
                            if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                                $zc_check_basket_after = $_SESSION['cart']->count_contents();
                                if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                                    if (SHOW_SHOPPING_CART_COMBINED == 2) {
                                        // warning only do not send to cart
                                        $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                    if (SHOW_SHOPPING_CART_COMBINED == 1) {
                                        // show warning and send to shopping cart for review
                                        $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                                    }
                                }
                            }
                            // eof: contents merge notice
                            $_SESSION['third_party_type'] = 'linkedin';
                            echo json_encode(array("msg"=>"ok","url"=>zen_href_link($jump_url)));
                        }else{
                             // 此时如果用户没有设置密码,跳转设置密码页面
                             if($google_result->RecordCount()){
                                 $google_plus_info_id = $google_result->fields['customers_LinkedIn_account_info_id'];
                             }else{
                                 $google_plus_info_id = '';
                             }
                             $_SESSION['third_party_id'] = $google_plus_info_id;
                             $_SESSION['third_party_type'] = 'linkedin';
                             $_SESSION['third_user_name'] = $name;
                             $_SESSION['third_user_info'] = array(
                                 'id' => $google_plus_id,
                                 'email' => $email,
                                 'first_name' =>  $first_name,
                                 'last_name' =>  $last_name,
                                 'gender' => $gender,
                                 'customers_id' => $current_customer_id,
                             );
 
                             $return =  [
                                 "msg" => "ok",
                                 "url" => zen_href_link('third_party_bind'),
                             ];
                             echo json_encode($return);
                        }
                       
                    } else { // 如果没有，说明是第一次
                        $google_plus_info = array(
                            'linkedin_id' => $linkedin_id,
                        );
//                        $google_plus_info = insert_db_time($google_plus_info, true);
                        if($google_result->RecordCount()){
                            $google_plus_info_id = $google_result->fields['customers_LinkedIn_account_info_id'];
                        }else{
                            zen_db_perform("customers_social_media_linkedin_info", $google_plus_info);
                            $google_plus_info_id = $db->Insert_ID();
                        }

                        $_SESSION['third_party_type'] = 'linkedin';
                        $_SESSION['third_party_id'] = $google_plus_info_id;
                        $_SESSION['third_party_from_url'] = 'social_media/linkedin.php';
                        $_SESSION['third_user_name'] = $name;
                        $_SESSION['third_user_info'] = array(
                            'id' => $google_plus_info_id,
                            'email' => $email,
                            'first_name' =>  $firstname,
                            'last_name' =>  $lastname,
                        );
                        echo json_encode(array("msg"=>"ok","url"=>zen_href_link('third_party_bind')));
                    }
                    //header('Location: http://www.fiberstore.com');
				}
			break;

		}
}
