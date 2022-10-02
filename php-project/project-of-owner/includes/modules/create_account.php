<?php
use App\Services\Subscription\SubscriptionService;
$zco_notifier->notify ( 'NOTIFY_MODULE_START_CREATE_ACCOUNT' );

if (! defined ( 'IS_ADMIN_FLAG' )) {
    die ( 'Illegal Access' );
}

$zone_name = '';
$entry_state_has_zones = '';
$error_state_input = false;
$state = '';
$zone_id = 0;
$error = false;

$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
$newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' || ACCOUNT_NEWSLETTER_STATUS == '0' ? false : true);

$regist_valide = get_current_valide('username', array(
    'firstname' => array(),'lastname' => array(),'email' => array(), 'password' => array(),'country'=>array(), 'phone_number'=>array(), 'tax_number'=>array('common_name'=>'tax_number_new'), 'customers_company'=>array()
));

if(isset ( $_GET ['action'] ) && ($_GET ['action'] == 'checkEmail') ){ // 异步验证邮箱
    $email_address = zen_db_prepare_input($_POST['email_address']);
    $return  = commonRegistCheckEmail($email_address);
    if($return['status'] == '0' ){
        exit('false');
    }else{
        exit('true');
    }
}
if(isset ( $_GET ['action'] ) && ($_GET ['action'] == 'checkEmailIsExist') ){ // 异步验证邮箱
    $email_address = zen_db_prepare_input($_POST['email_address']);
    $return  = commonRegistCheckEmail($email_address);
    if($return['status'] == '0' ){
        exit('true');
    }else{
        exit('false');
    }
}
if(isset ( $_GET ['action'] ) && ($_GET ['action'] == 'checkEmailIsNotExist') ){ // 异步验证邮箱
    $email_address = zen_db_prepare_input($_POST['email_address']);
    $return  = commonRegistCheckEmail($email_address);
    if($return['status'] == '0' ){
        exit('false');
    }else{
        exit('true');
    }
}
if(isset ( $_GET ['action'] ) && ($_GET ['action'] == 'checkPasswordIsCorrent') ){ // 异步验证密码，是否正确
    $email_address = zen_db_prepare_input($_POST['email_address']);
    $exist_customers = $db->getAll('select customers_id,customers_password from customers WHERE customers_email_address="'.$email_address.'" limit 1 ');
    if($exist_customers){
        $exist_customers = $exist_customers[0];
        $password = zen_db_prepare_input($_POST['password']);
        //RSA后台解密
        $password = zen_get_rsa_decrypt_password($password);

        if (!zen_validate_password($password, $exist_customers['customers_password'])) { //该用户密码不对
            exit('false');
        }else{
            exit('true');
        }
    }else{ //该用户不存在
        exit('false');
    }
}
else if (isset ( $_GET ['action'] ) && ($_GET ['action'] == 'process') ) { // 提交表单。这里有两种情况。1、注册成为企业会员。2、个人用户升级成为企业会员。
    // 安全认证
    if ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) {
        exit(json_encode(array('status'=>'0','data'=>'','info'=>FS_SECURITY_ERROR)));
    }

    $email_address =  $email = zen_db_prepare_input($_POST['email']);
//     $cust_number = zen_db_prepare_input (trim($_POST['company_num_regist'])) ;
//	 $is_company_regist = zen_db_prepare_input  (trim($_POST ['is_company_regist'])) ;
    $firstname = zen_db_prepare_input  (trim($_POST['firstname'])) ;
    $lastname = zen_db_prepare_input  (trim($_POST['lastname'])) ;
    $from = zen_db_prepare_input  (trim($_POST['from'])) ; // 从什么地方跳转过来的
    $password = zen_db_prepare_input ( $_POST['password']);
    $tax_number = zen_db_prepare_input($_POST['tax_number']);
    $newsletter = isset($_POST['subscribe']) ? (int)zen_db_prepare_input($_POST['subscribe']) : 1;//当前页面没有subscribe 时 新注册客户默认为1
//    $customerDiscoveryTypeId=zen_db_prepare_input ( $_POST ['customerDiscoveryTypeId'] );
//    $customer_other_content=zen_db_prepare_input ( $_POST ['customerDiscoveryContent'] );
    $regist_from = 'regist';

    $country = (int)zen_db_prepare_input($_POST['country']);
    //新增注册客户电话 客户公司名称
    $phone_number = zen_db_prepare_input($_POST['phone_number']);
    $customers_company = zen_db_prepare_input($_POST['customers_company']);
    $graph_validate_code_response = zen_db_prepare_input($_POST['token']);
    $prefix_email = substr($email_address, 0, (stripos($email_address, '@') + 1)); // 邮箱前缀
    $postfix_email = strtolower(strrchr($email_address, '@'));  // 邮箱后缀
    $is_mobile = isMobile();
    // 添加redis锁防止重复提交
    $prefix = 'lock_register';
    $key = $email;
    $lock_key = $prefix . ':' . md5($key);
    if (incr_redis_by_key($key, $prefix) == 1) {
        // 给锁添加过期时间
        $expire_time = set_redis_key_expire($lock_key, 30);
    } else {
        exit(json_encode(array('status' => '4', 'data' => '', 'info' => FS_SUBMIT_TOO_FREQUENT)));
    }
    if (FS_RECAPTCHA_SWITCH > 0) {
        if (!$is_mobile) {
            if (!$graph_validate_code_response) {
                exit(json_encode(array('status' => '4', 'data' => '', 'info' => FS_ROBOT_VERIFY_PROMOPT)));
            } else {
                // 谷歌人机验证码 recaptcha v2 隐式
                $google_verify_url = 'https://www.recaptcha.net/recaptcha/api/siteverify';
                if ($language_code_verify !== 'cn') $google_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
                if (!$graph_validate_code_response) {
                    exit(json_encode(array('status' => 4, 'data' => '', 'info' => FS_ROBOT_VERIFY_PROMOPT)));
                }
                $verify = graph_validate_code($graph_validate_code_response, $google_verify_url, $new = 1);
                if (!$verify) {
                    exit(json_encode(array('status' => 4, 'data' => '', 'info' => FS_ROBOT_VERIFY_PROMOPT)));
                }
            }
        }
    }
    //验证
    $current_valide = $regist_valide;
    require_once('includes/templates/fiberstore/common/fs_valide_common.php');
    if(get_user_blacklist($email_address)){
        exit(json_encode(array('status'=>'0','data'=>'','info'=>FS_ACCESS_DENIED_1)));
    }
    $return = commonRegistCheckEmail($email_address);
    if($return['status'] == 0 ){
        exit(json_encode($return));
    }

    //根据客户填的编号，自动归到相应的组
    $link_id = 0 ;
//    $is_link_error = false;
//    $check_customers_number_new = 0 ;
//    if ($is_company_regist == 'yes' && $cust_number && is_numeric($cust_number)) {
//	    $cust_prefix = (int)substr($cust_number,0,1);
//	    if ($cust_prefix <= 5) { //线上
//		    $true_cust_id = (int)fs_get_data_from_db_fields('customers_id','customers','customers_number_new="'.(int)$cust_number.'"','LIMIT 1');
//		    if ($true_cust_id) {
//		        $check_customers_number_new = (int)$cust_number;
//		        $relate_cInfo = $db->Execute("SELECT admin_id,link_id FROM  admin_to_customers
//		                                  WHERE customers_id = '" . $true_cust_id . "' LIMIT 1");
//		        if ($relate_cInfo->RecordCount()) {
//		            $admin_id = $relate_cInfo->fields['admin_id'] ;
//		            $link_id  = $relate_cInfo->fields['link_id'] ;
//		        }
//		    }
//	    }else{   //线下
//	        $relate_cInfo = $db->Execute("SELECT admin_id,link_id FROM customers_offline
//	                                 WHERE customers_number_new='". (int)$cust_number ."' LIMIT 1");
//	        if ($relate_cInfo->RecordCount()) {
//	            $check_customers_number_new = (int)$cust_number;
//	            $admin_id = $relate_cInfo->fields['admin_id'] ;
//	            $link_id  = $relate_cInfo->fields['link_id'] ;
//	        }
//        }
//	    if (!$check_customers_number_new) { $is_link_error = true;}
//    }
//    //根据客户填的编号，自动归到相应的组  结束
//    if ($is_link_error) {
//        exit(json_encode(array('status'=>'0','data'=>'','info'=>ENTRY_COMPANY_ACCOUNT_CHECK_ERROR)));
//    }

    //RSA后台解密
    $password = zen_get_rsa_decrypt_password($password);
    $http_user_agent =$_SERVER["HTTP_USER_AGENT"];
    $user_ip_address =$_SERVER["REMOTE_ADDR"];
    $customer_country_id = $country?$country:223;
    $customers_country_id = $customer_country_id;
    $sql_data_array = array (
        'customers_firstname' => $firstname,
        'customers_lastname' => $lastname ,
        'customers_email_address' => $email_address,
        'customers_newsletter' => ( int ) $newsletter,
        'customers_email_format' => $email_format,
        'customers_default_address_id' => 0,
        'customers_password' => zen_encrypt_password ( $password ),
        'customers_authorization' => ( int ) CUSTOMERS_APPROVAL_AUTHORIZATION,
        'language_id' => (int)$_SESSION['languages_id'],
        'language_code'=>$_SESSION['languages_code'],
        'customer_country_id'=>$customer_country_id,
        'customers_telephone'=>$phone_number,
        'customers_company'=>$customers_company,
//            'hear_us' =>$customerDiscoveryTypeId,
//            'customer_other_content'=>$customer_other_content,
        'http_user_agent' =>$http_user_agent,
        'user_ip_address' =>$user_ip_address,
        'customers_regist_from' => $regist_from,
        'tax_number' => $tax_number,
        'customers_info_date_account_created' =>date('Y-m-d H:i:s'),
        'source' => 1,        // 客户来源： 注册
        'from_where' => isMobile() ? 2 : 1,        // 客户来源
        'test_mailbox' => isTestMailbox($email_address)?1:0,
    );
    $allot_arr = [
        'customers_email_address' => $email_address,
        'customer_country_id' => $customer_country_id ? $customer_country_id : 223,
        'customers_telephone' => $phone_number,
        'create_time' => time(),
        'language_id' => in_array($_SESSION['languages_id'],['1', '2', '3', '4', '5', '8', '14']) ? (int)$_SESSION['languages_id'] : 1,
        'prefix_email' => $prefix_email ? $prefix_email : '',
        'postfix_email' => $postfix_email ? $postfix_email : '',
        'language_code' => $_SESSION['countries_code_21'] ? $_SESSION['countries_code_21'] : '',
    ];

    if(FS_REGIST_IS_EMAIL_CHECK){ // 邮箱验证，分配销售在邮箱激活之后
        $sql_data_array['email_is_active'] = 0;
        $sql_data_array['email_check_seed'] = createEmailCheckSeed();
        $sql_data_array['email_is_active'] = time();
    } else{ // fairy 不需要邮箱验证接口
        $sql_data_array['email_is_active'] = 1;

        //分配销售
        if (!$admin_id) {
            $customers_country_id = $customer_country_id;
            $allot_type = 'register';
            require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));

            $sql_data_array['is_make_up'] = $is_make_up ? : 0;
            $sql_data_array['is_old'] = $is_old ? $is_old : 0;      // 标记新老用户
        }
        if ($from != 'inquiry') {
            $is_old = get_customers_is_old($email_address);
            $sql_data_array['is_old'] = $is_old ? $is_old : 0;      // 标记新老用户
        }
    }

    //生成客户编号
    if ($check_customers_number_new) {
        $sql_data_array['customers_number_relate'] = $check_customers_number_new;
    }
    if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != ''))
        $sql_data_array ['customers_referral'] = $customers_referral;
    if (ACCOUNT_GENDER == 'true')
        $sql_data_array ['customers_gender'] = $gender;
    if (ACCOUNT_DOB == 'true')
        $sql_data_array ['customers_dob'] = (empty ( $_POST ['dob'] ) || $dob_entered == '0001-01-01 00:00:00' ? zen_db_prepare_input ( '0001-01-01 00:00:00' ) : zen_date_raw ( $_POST ['dob'] ));

    // 添加事务，防止客户分配以及重复注册
    $db->Execute("START TRANSACTION");
    // 查询是否已经注册过
    $check_email_query = "select customers_id from " . TABLE_CUSTOMERS . "
            where customers_email_address = '" . $email_address . "'";
    $check_email = $db->getAll($check_email_query);
    if (!empty($check_email)) {
        $email_checked = false;
        $is_error = FS_EMAIL_HAS_REGISTERED_TIP;
//        exit(json_encode(array('status' => '0', 'data' => '', 'info' => FS_EMAIL_HAS_REGISTERED_TIP)));
    } else {
        $email_checked = true;
    }
    // 写入注册customers表
    zen_db_perform ( TABLE_CUSTOMERS, $sql_data_array );
    $customers_id = $db->insert_ID();
    $final = ($email_checked && $customers_id);
    if ($from != 'inquiry') {
        if ($admin_id) {
            $allot_arr['is_allot'] = 1;
        }
        $allot_arr['customers_id'] = $customers_id;
        zen_db_perform('customers_register_allot', $allot_arr);
        $id = $db->insert_ID();
        $final = ($email_checked && $customers_id && $id);
    }
    if (!$final) {
        $db->Execute("ROLLBACK");
        $marked_words = 'Account information verification failed.';
        if ($is_error) $marked_words = $is_error;
        exit(json_encode(array('status' => '0', 'data' => '', 'info' => $marked_words)));
    } else {
        $db->Execute("COMMIT");
    }

//    zen_db_perform ( TABLE_CUSTOMERS, $sql_data_array );
//    $customers_id = $db->insert_ID();

    // 添加注册信息
    $sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                      (customers_info_id, customers_info_number_of_logons,
                       customers_info_date_account_created, customers_info_date_of_last_logon)
          values ('" . ( int ) $customers_id . "', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
    $db->Execute ( $sql );

    if (SESSION_RECREATE == 'True') {
        zen_session_recreate ();
    }
    //fallwind 2016.10.14	注册成功时，判断$_SESSION['google_ads']是否有值，有值就记录其ip，同时记录该值
    if(!empty($_SESSION['google_ads']) && isset($_SESSION['google_ads']) ){
        $customer_come_ip = getCustomersIP();
        setComeIpByRegis($customer_come_ip,$firstname,$email_address);
    }

    if(FS_REGIST_IS_EMAIL_CHECK) {   // 邮箱验证
        // 发送激活邮件
        send_active_email($email_address);
        // 跳转到邮箱验证页面
        $_SESSION['fs_email_address'] = $email_address;
        $href = reset_url('index.php?main_page=regist_email_check');
        exit(json_encode(array('status'=>'1','data'=>'','info'=>'','href'=>$href)));
    }else{ // fairy 不需要邮箱验证接口
        // 添加客户销售对应关系，并给相应的销售发邮件
        $data_log = array(
            'admin_id' => $admin_id,
            'regist_from' => 'regist',
        );
        $data_log = array(
            'customers_email' => '数据:'.json_encode($data_log),
            'created_at' => date("Y-m-d H:i:s"),
            'customers_email_2' => $email_address,
        );
        $data_log['case_number'] = '前台注册客户分配1';
        zen_db_perform('customer_service_log',$data_log);

        if($admin_id) {
            $data_log['case_number'] = '前台注册客户分配2';
            zen_db_perform('customer_service_log',$data_log);
            $date = get_common_cn_time();
            $sql = 'INSERT INTO admin_to_customers(admin_id,customers_id,add_time,link_id,create_time) VALUE("' . $admin_id . '","' . $customers_id . '","'.$date.'","' . (int)$link_id . '","'.time().'")';
            $db->Execute($sql);

            //客户自动关联
            if($admin_id && $email_address){
                auto_given_customer_manage($admin_id,$email_address,1);
            }

            // fairy 2018.8.31 add 如果不是公共后缀邮箱，把公海中相同后缀也分配
            $seanArr = array(
                'email_address' => $email_address,
                'customer_number' => '',
                'customer_offline_number' => '',
                'invalidSign' => $invalidSign,
            );
            auto_given_open_seas_customers($seanArr,$admin_id);

            //同步第三方接口数据， customers_level为E或者D时，同步到DMT平台
            if($newsletter === 1){
                $customers_level = fs_get_data_from_db_fields('customers_level','customers','customers_email_address = "'.$email_address.'"','limit 1');
                if(in_array($customers_level,['D','E'])){
                    $admin_name = fs_get_data_from_db_fields('admin_name','admin','admin_id = '.$admin_id,'limit 1');
                    $subscription = new SubscriptionService();
                    $sub_data =  [
                        'customers_email_address' => $email_address,
                        'customers_firstname' => $sql_data_array['customers_firstname'],
                        'customers_lastname' => $sql_data_array['customers_lastname'],
                        'customers_number_new' => $sql_data_array['customers_number_new'] ? $sql_data_array['customers_number_new'] : '',
                        'country' => [
                            'countries_chinese_name' =>  $sql_data_array['countries_chinese_name'] ? $sql_data_array['countries_chinese_name'] : '',
                        ],
                        'customers_birthday' => $sql_data_array['customers_birthday'] ? $sql_data_array['customers_birthday'] : '',
                        'position' => [
                            'position_name' =>  $sql_data_array['position_name'] ? $sql_data_array['position_name'] : '',
                        ],
                        'customers_level' => $customers_level ?  $customers_level : '',
                        'admin_name' => $admin_name ?  $admin_name : '',
                        'admin_id' => $admin_id,
                    ];
                    $res = $subscription->setData($sub_data)->requestApi($newsletter);
                }
            }

            // 给对应后台销售发邮件
            $tel_prefix = fs_get_data_from_db_fields('tel_prefix','countries','countries_id = '.(int)$customer_country_id,'');
            $sales_email = zen_admin_email_of_id($admin_id);
            $html = zen_get_corresponding_languages_email_common();
            $html_msg['EMAIL_HEADER'] = $html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
            $html_msg['CUSTOMER_NAME'] = $firstname . $lastname ? $firstname . $lastname : 'not set yet';
            $html_msg['NUMBER'] = $phone_number ? $tel_prefix.' '.$phone_number : 'not set yet';
            $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
            sendwebmail($sales_email, $sales_email,'注册客户销售提醒邮件'.$sales_email.date('Y-m-d H:i:s', time()),STORE_NAME,'Customer Info', $html_msg, 'regist_to_us',81,'');

            //客户注册给对应区域销售发送邮件
            $regional_sales = '';
            if(au_warehouse($customer_country_id)){
                $regional_sales = 'au@fs.com';
            }elseif(singapore_warehouse('country_number',$customer_country_id)){
                $regional_sales = 'sg@fs.com';
            }elseif($customer_country_id == 176){
                $regional_sales = 'ru@fs.com';
            }
            if(!empty($regional_sales)){
                sendwebmail($regional_sales, $regional_sales, '注册客户销售提醒邮件'.$regional_sales.date('Y-m-d H:i:s', time()), STORE_NAME, 'Customer Info', $html_msg, 'regist_to_us', 81, '');
            }
        }

        // 如果是报价跳转过来的，要同步报价
        if($from == 'inquiry'){
            $time = date('Y-m-d H:i:s');
            $inquiry_arr = array(
                'customers_id' => $customers_id,
                'updated_person' => $customers_id,
                'updated_at' => $time,
            );
            $ret = zen_db_perform('customer_inquiry', $inquiry_arr,'update','email="'.$email_address.'"');
        }

        // session与cookie的设置
        // 设置cookie
        $_SESSION ['customer_id'] = $customers_id;
        /**** Begin 统计埋点标记 ****/
        $_SESSION ['is_regist'] = $customers_id;//标记客户注册
        /**** End 统计埋点标记 ****/
        require_once DIR_WS_CLASSES .'set_cookie.php';
        $Encryption = new Encryption;
        $cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
        setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
        // 设置session
        if (SESSION_RECREATE == 'True') {
            zen_session_recreate ();
        }
        $_SESSION ['customer_first_name'] = $sql_data_array['customers_firstname'];
        $_SESSION['customer_last_name'] = $sql_data_array['customers_lastname'];
        $_SESSION ['customer_default_address_id'] = $sql_data_array['customers_default_address_id'];
        $_SESSION ['customer_country_id'] = $sql_data_array['customer_country_id'];
        $_SESSION ['customer_zone_id'] = $zone_id;
        $_SESSION ['customers_authorization'] = $sql_data_array['customers_authorization'];
        $_SESSION ['name'] = $sql_data_array['customers_firstname'].' '.$sql_data_array['customers_lastname'];
        $_SESSION['customers_password'] = $Encryption->_encrypt($password);
        $_SESSION['customers_email_address'] = $email_address;
        $_SESSION['regist_success'] = rand(0,1000);

        // fairy 添加登录信息
        zen_insert_one_customers_login($_SESSION['customer_id'],'regist');
        //将购物车产品同步用户
        $_SESSION['cart']->restore_contents();
        // 发送注册成功邮件
        send_person_regist_email($email_address);
        //同步报价购物车数据
        require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
        global $currencies;
        $inquiry = new inquiry($currencies,$_SESSION['inquiry_cart']);
        $inquiry->restore_contents();
        if($_POST['inquiry_type']==1 || $_POST['main_page']=='inquiry'){
            $href = reset_url('index.php?main_page=inquiry');
        }else{
            $href = reset_url('index.php?main_page=my_dashboard');
        }

        if (sizeof($_SESSION['navigation']->snapshot) > 0) {
            //服务政策页面    购物车  结算页 注册成功 回到当前页
            if(in_array($_SESSION['navigation']->snapshot['page'],array('shopping_cart','checkout','solution_support','customer_service_others','sample_application','live_chat_service_mail'))){
                if(in_array($_SESSION['navigation']->snapshot['page'],array('solution_support','customer_service_others','sample_application','live_chat_service_mail'))){
                    $href = reset_url($_SESSION['navigation']->snapshot['page'].'.html');
                }else{
                    //购物车  结算页面用动态
                    $href = reset_url('index.php?main_page='.$_SESSION['navigation']->snapshot['page']);
                }
            }
//            if ('shopping_cart' == $_SESSION['navigation']->snapshot['page']){
//                //若是从购物车页面跳转到注册页面的注册成功后仍然跳回到购物车页面
//                $href = reset_url('index.php?main_page=shopping_cart');
//            }elseif ('checkout' == $_SESSION['navigation']->snapshot['page']){
//                //若是从结算页面跳转到注册页面的注册成功后仍然跳回到结算页面
//                $href = reset_url('index.php?main_page=checkout');
//            }
        }
        exit(json_encode(array('status'=>'2','data'=>'','info'=>FS_REG_SUCCESS,'href'=>$href)));
    }
}
echo '<script> var regist_valide = '.json_encode($regist_valide).'; </script> ';
$zco_notifier->notify ( 'NOTIFY_MODULE_END_CREATE_ACCOUNT' );

