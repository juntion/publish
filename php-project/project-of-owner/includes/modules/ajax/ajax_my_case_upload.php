<?php
use App\Services\Country\CountryService;
use App\Services\Common\ApiResponse;
use App\Services\Cases\CaseService;
use App\Services\Admins\AdminService;
use App\Services\Customers\CustomerService;
use App\Request\PurchaseCaseSettingRequest;
use App\Services\Payments\PurchaseService;
use App\Services\Email\Net30ApplyEmailService;

$countryService = new CountryService();
$caseService = new CaseService();
$api = new ApiResponse();
$ajaxRequestAction = zen_db_prepare_input($_GET['ajax_request_action'] ?: '');
if($ajaxRequestAction=='addSolutionCase'){
    if($_SERVER['REQUEST_METHOD'] !='POST' ){
        echo json_encode(['code'=>0,'data'=>FS_ACCESS_DENIED]);
        exit();
    }
    require("includes/languages/email/english.php");
    require("includes/languages/".$_SESSION['language']."/views/solution_support.php");
    require("includes/languages/".$_SESSION['language']."/views/network_solution.php");
    require("includes/languages/".$_SESSION['language']."/views/request_demo.php");
    if(isset($_POST)){
        $email =  $_POST['email_address'] ? zen_db_prepare_input($_POST['email_address']) : '';
        if(get_user_blacklist($email)==true){ //验证放前面
            echo json_encode(['code'=>0,'message'=>FS_ACCESS_DENIED_1]);
            exit;
        }
        $first_name =  $_POST['entry_firstname'] ? zen_db_prepare_input($_POST['entry_firstname']) : '';
        $last_name = $_POST['entry_lastname'] ? zen_db_prepare_input($_POST['entry_lastname']) : '';
        $user_name = $first_name . ' '. $last_name;
        $user_name = trim($user_name);
        $phone = $_POST['entry_telephone'] ? zen_db_prepare_input( $_POST['entry_telephone']) : '';
        $question_content= $_POST['comments_content'] ? str_replace(array('\r\n','\n'), '<br/>', zen_db_prepare_input($_POST['comments_content'])) : 'none';
        $country_code = $_POST['country_code'] ? zen_db_prepare_input($_POST['country_code']) : $_SESSION['countries_iso_code'];
        $country_code = strtoupper($country_code);

        $type_id =  $_POST['type_id'] ? (int)zen_db_prepare_input($_POST['type_id']) : 2;
        $created_type =  $_POST['created_type'] ? (int)zen_db_prepare_input($_POST['created_type']) : 12;
        //国家
        //国家信息
        $country_data = [];
        $customers_country_id =  $customers_country_name = '';
        $countryService->setCountry('',$country_code);
        if($countryService->currentCountry){
            $country_data = $countryService->currentCountry->toArray();
            $customers_country_id = $country_data['countries_id'];
            $customers_country_name = $country_data['countries_name'];
            $tel_prefix = $country_data['tel_prefix'];
        }
        $tel_prefix = !empty($tel_prefix) ? $tel_prefix : '+1';
        //获取改客户邮箱是否注册
        $customer_info = $db->Execute("select customers_id,is_disabled,customers_number_new from customers where customers_email_address= '" . trim($email) . "' limit 1");
        if($customer_info->fields['customers_id']){
            $customer_id = $customer_info->fields['customers_id'];
            $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
            $theCustomerNumber = $customer_info->fields['customers_number_new'];
            $isDisabled = $customer_info->fields['is_disabled'];
            // 甄别无效客户类型   后台产品要求无效客户为1和3的需要重新分配
            $dataInfo = getIsDisabledEmail($theCustomerNumber, $isDisabled, $admin_id);
            $admin_id = $dataInfo['admin_id'];
            $reason_type = $dataInfo['reason_type'];
        }else{
            $customer_id = 0;
            $admin_id = 0 ;
        }
        $entrance = isset($_REQUEST['entrance'])?$_REQUEST['entrance']:1;
        $email_address = $email;
        $allot_type = 'solution_support';
        if($email_address && $customers_country_id){
            /*分配客服*/
            require(DIR_WS_MODULES . zen_get_module_directory('message_entrance_auto_given.php'));

            /*分配销售*/
            if(!$admin_id){
                if($type_id == 13){
                    $allot_type = 'network_solution';
                }elseif($type_id == 14){
                    $allot_type = 'request_demo';
                }else{
                    $allot_type = 'solution_support';
                }
                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
            }
        }
        $admin = new AdminService();
        $admin_id = $admin_id ? $admin_id : 0;
        $admin_info = $admin->setAdmin($admin_id)->currentAdmin;
        if ($admin_info) {
            $admin_name = $admin_info['admin_name'];
            $admin_email = $admin_info['admin_email'];
        }
        // fairy 2018.8.30 add
        // 如果该项分配当前销售。则也要把该用户分配给当前销售等操作
        if ($admin_id && $email_address) {
            $nick = $user_name;
            $nick_arr = explode(' ',$nick);
            $firstname = $nick_arr[0];
            $lastname = $nick_arr[1];
            auto_given_customers_to_admin(array(
                'admin_id' => $admin_id,
                'email_address' => $email_address,
                'admin_id_from_table' => $admin_id_from_table,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'nick' => $nick,
                'country' => $customers_country_id,
                'is_make_up' => $is_make_up,
                'from_auto_file' => 'auto_given',
                'source' => 5,              // 客户来源:solution
                'is_old' => $is_old ? $is_old : 0, // 标记新、老客户
                'customer_number' => $customers_customers_number_new,
                'customer_offline_number' => $offline_customers_number_new,
                'invalidSign' => $invalidSign,
            ));
        }
//        if($admin_id && $caseNumber){
//            $db->Execute("update case_number set sales_id = ".$admin_id." where case_number = '".$caseNumber."'");
//        }
        $admin_name = zen_get_admin_name_of_id($admin_id);
        $admin_email = zen_get_admin_email_of_name($admin_name);

        //服务流程开始
        if (!$admin_id) {
            $api->setStatus(501)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        $number = isset($_SESSION['service_process_number']) ? $_SESSION['service_process_number'] : create_number_new();
        if(!$number){
            $api->setStatus(502)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        //销售节点
        $saleNodeId = $caseService->getSaleNodeId($type_id, 2);
        //客服节点
        $serviceNodeId = $caseService->getSaleNodeId($type_id, 1);
        //当前类型对应的流程节点串
        $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = '.$type_id);
        if (!$saleNodeId || !$serviceNodeId) {
            $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
        }
        //服务流程需要插入的数据
        $serviceArray = array();
        $service_type = 4;
        if($type_id == 13){
            $service_type = 7;
        }
        $type_name = get_service_type_name($type_id);
        $question = array(
            'number' => $number,
            'node_flow' => $node_flow ? $node_flow : $saleNodeId,
            'urgent_level' => 1,
            'sale_id' => $admin_id,
            'sale_name' => $admin_name,
            'customer_name'=>$user_name,
            'customer_email'=>$email,
            'customer_telephone' =>$phone,
            'customer_country_id' => $customers_country_id,
            'customer_country_name' => $customers_country_name,
            'customer_describe' => $question_content,
            'language_id'=>$_SESSION['languages_id'],
            'service_id'=> 3018,
            'service_name'=> zen_get_admin_name_of_id(3018),
            'created_time' => time(),
            'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
            'created_type' => $created_type,
            'service_type' => $service_type,
            'type_id' => $type_id,
            'type_name' => $type_name,
            'customer_service' => 1, //客服区域统一给国内1
            'current_node_id' => $saleNodeId,
        );
        //添加服务流程客服表
        $assignAdminData = [
            'number'   => $number,
            'admin_id' => $admin_id,
        ];
        $nodeData = [
            [
                'number' => $number,
                'admin_id' => $admin_id,
                'node_id' => $saleNodeId,
                'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
            ],
            [
                'number' => $number,
                'admin_id' => 3018,
                'node_id' => $serviceNodeId,
                'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
            ]
        ];
        $recordData = [
            [
                'number' => $number,
                'node_id' => $serviceNodeId,
                'admin_id'=>$admin_id,
                'admin_name'=>zen_get_admin_name_of_id($admin_id),
                'comment'=>'none',
            ],
            [
                'number' => $number,
                'node_id' => $serviceNodeId,
                'admin_id'=>3018,
                'admin_name'=>zen_get_admin_name_of_id(3018),
                'comment'=>'该服务由销售发起，客服无需处理。',
            ]
        ];
        //添加服务流程所有逻辑
        $serviceArray = [
            'service_process' => $question,
            'service_process_assign_admin' => $assignAdminData,
            'service_process_assign_node' => $nodeData,
            'service_process_record' => $recordData
        ];
        $server_type = '';
        if($type_id == 13){
            //锐捷方案
            $server_type = 'ruijie';
            $plan_type =  $_POST['plan_type'] ? (int)zen_db_prepare_input($_POST['plan_type']) : '';
            if($plan_type){
                $industry =  $_POST['industry'] ? zen_db_prepare_input($_POST['industry']) : '';
                $bandwidth_requirement =  $_POST['bandwidth_requirement'] ? zen_db_prepare_input($_POST['bandwidth_requirement']) : '';
                $backup_needs =  $_POST['backup_needs'] ? zen_db_prepare_input($_POST['backup_needs']) : '';
                $industry_val =  $_POST['industry_val'] ? zen_db_prepare_input($_POST['industry_val']) : 0;
                $bandwidth_val =  $_POST['bandwidth_val'] ? zen_db_prepare_input($_POST['bandwidth_val']) : 0;
                $backup_val =  $_POST['backup_val'] ? zen_db_prepare_input($_POST['backup_val']) : 0;
                $serviceArray['service_ruijie_solution'] = [
                    'number' => $number,
                    'plan_type' => $plan_type,
                    'industry' => $industry,
                    'bandwidth_requirement' => $bandwidth_requirement,
                    'backup_needs' => $backup_needs,
                    'option_params' => $industry_val.';'.$bandwidth_val.';'.$backup_val,
                ];
            }
        }elseif($type_id == 14){
            $industry =  $_POST['industry'] ? zen_db_prepare_input($_POST['industry']) : '';
            $company_name =  $_POST['company_name'] ? zen_db_prepare_input($_POST['company_name']) : '';
            $company_size =  $_POST['company_size'] ? zen_db_prepare_input($_POST['company_size']) : '';
            $product_id =  $_POST['product_id'] ? zen_db_prepare_input($_POST['product_id']) : 0;
            $functions =  $_POST['functions'] ? zen_db_prepare_input($_POST['functions']) : '';
            $choose_date =  $_POST['choose_date'] ? zen_db_prepare_input($_POST['choose_date']) : '';
            $choose_time =  $_POST['choose_time'] ? zen_db_prepare_input($_POST['choose_time']) : '';
            $serviceArray['service_request_demo'] = [
                'number' => $number,
                'industry' => $industry,
                'company_name' => $company_name,
                'company_size' => $company_size,
                'product_id' => $product_id,
                'functions' => $functions,
                'time_zone' => $_SESSION['user_ip_info']['ipTimeZone'],
                'choose_date' => $choose_date,
                'choose_time' => $choose_time,
            ];
        }
        //上传文件到服务流程文件表
        if ($_FILES["reviews_newImg"]['name'][0]) {
            $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
            $folderName = "myCase/" . $randPath;
            $uploadfiles = $caseService->uploadFiles($_FILES["reviews_newImg"],$folderName);
            if ($uploadfiles['code'] == 0) {
                $api->setStatus(503)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
            }
            if ($uploadfiles['path']) {
                $uploadfiles_data = [];
                foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
                    $uploadfiles_data[] = array(
                        'service_process_number' => $number,
                        'file_name' => $_FILES["reviews_newImg"]['name'][$upload_k],
                        'storage_name' => explode('/',$upload_v)[2],
                        'storage_path' => $randPath,
                    );
                }
                $serviceArray['service_process_file'] = $uploadfiles_data;
            }
        }
        //服务流程插入操作
        $serviceInfo = $caseService->insertServiceProcess($serviceArray, $server_type);
        if ($serviceInfo == false) {
            unset($_SESSION['service_process_number']);
            $api->setStatus(504)->setMessage("error")->response(['info' => FS_FORM_REQUEST_ERROR,'data' => $serviceArray]);
        }
        //服务流程结束

        $pick_time = date('d.m.y',time());
        $title_info=FS_SEND_EMAIL_3;
        if(in_array($_SESSION['languages_code'],array('de','dn'))){
            $pick_time = date('d.m.y',time());
            if ($_SESSION['languages_code'] == "de") {
                $title_info = "Supportanfrage";
            }
        }elseif($_SESSION['languages_code']=="jp"){
            $pick_time = date('Y/m/d',time());
            $title_info="サポートリクエスト受領済み";
        }
        /* email content  helun 客户进行创建问题后发送邮箱给指定销售*/
        $html=common_email_header_and_footer($title_info,FS_SEND_EMAIL_9.$question['case_number']);
        get_email_langpac();

        $email_title = FS_SEND_EMAIL_8_1;
        $email_content_01 = FS_SUPPORT_EMAIL_TOUCH_SOON;
        $html_case_str = SAMPLE_EMAIL_30;
        $caselink = zen_href_link('my_cases_details','new_old_data=1&case='.$number);
        $html_case_str = str_replace('###case_number###',$number,$html_case_str);
        $html_case_str = '<td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">'.str_replace('$HREF',$caselink,$html_case_str).'</td>';
        $phone_html = $phone != '' ? SAMPLE_EMAIL_06.'<a style="text-decoration: none;color: #0070bc;" href="javascript:;">'.$tel_prefix.' '.$phone.'</a> <br />' : '';
        $email_content_02 = SAMPLE_EMAIL_03. ucfirst($user_name). '<br />
                            '.SAMPLE_EMAIL_04. '<a style="text-decoration: none;color: #0070bc;" href="mailto:donna@gmail.com">'.$email.'</a> <br />
                            '.SAMPLE_EMAIL_05. $customers_country_name.' <br />
                            '.$phone_html;

        if($type_id == 14){
            $email_title = REQUEST_DEMO_EMAIL_01;
            $email_content_01 = str_replace('#NUMBER#',$number,REQUEST_DEMO_EMAIL_02);
            $email_content_01 = str_replace('#HREF#',$caselink,$email_content_01);
            $html_case_str = '<td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">'.REQUEST_DEMO_EMAIL_03.'</td>';
            $product_info = $caseService->getRequestDemoProductInfo($product_id);
            $product_href = zen_href_link('product_info', 'products_id=' . (int)$product_info['products_id']);
            $choose_datetime = get_all_languages_date_display(strtotime($choose_date), 'default1').' '.$choose_time;
            $functions = explode(';',$functions);
            array_pop($functions);
            $functions_text = implode(', ',$functions);
            $email_content_02 = REQUEST_DEMO_EMAIL_04. '<a style="text-decoration: none;color: #0070bc;" href="'.$product_href.'">'.$product_info['products_model']. '</a><br />
                            '.REQUEST_DEMO_EMAIL_05.$functions_text. '<br />
                            '.REQUEST_DEMO_EMAIL_06. $choose_datetime.' <br />';
        }

        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.FS_MODIFY_EMAIL_MY_CASE_08. ' ' .ucfirst($user_name).FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           '.$email_content_01.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        '.$html_case_str.'
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;background-color: #fff;" align="left">
                            '.$email_content_02.'
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>';
        if($question_content != 'none'){
            $html_msg['EMAIL_BODY'] .=
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">
                            '.SAMPLE_EMAIL_07.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           '.$question_content.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
        }

        if($type_id == 14){
            $html_msg['EMAIL_BODY'] .=
                '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           '.REQUEST_DEMO_EMAIL_07.'<br/>'.REQUEST_DEMO_EMAIL_08.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
        }

        $html_msg['EMAIL_BODY'] .=
            '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                           '.RESET_PASS_SUCCESS_04.'
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
        if($_SESSION['languages_code']=="jp"){
            $title = str_replace('#NUMBER#',$number,$email_title);
        } elseif ($_SESSION['languages_code']=="de") {
            $title =$email_title.$number.' erhalten';
        }else{
            $title =$email_title.$number;
        }
        sendwebmail($user_name, $email,$allot_type.'邮件发送给客户'.date('Y-m-d h:i:s',time()), STORE_NAME,$title, $html_msg,'default');
        if($customers_id){
            $customer_name = zen_get_customers_firstname($customers_id);
        }
        //给客服发送邮件
        if($service_email && getIsSendServiceEmail()){
            sendwebmail($service_name, $service_email,$allot_type.'邮件发送给客服:'.date('Y-m-d h:i:s',time()), STORE_NAME, $title, $html_msg,'default');
        }

        if($admin_id){
            sendwebmail($admin_name, $admin_email,$allot_type.'邮件发送给销售:'.date('Y-m-d h:i:s',time()), STORE_NAME, $title, $html_msg,'default');
        }
        if($number){
            if($type_id == 14){
                $number = '<a href="'.zen_href_link('my_cases_details','&new_old_data=1&case='.$number).'" style="color:#0070bc;">'.$number.'</a>';
            }
            echo json_encode(['code'=>1,'data'=>$number]);
            exit();
        }
    }
}elseif($ajaxRequestAction == 'addLiveChatCase'){
    require("includes/languages/".$_SESSION['language']."/views/live_chat_service_mail.php");
    require("includes/languages/".$_SESSION['language']."/public/common.php");
    if ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) {
        $api->setStatus('0')->setMessage('error')->response(FS_SECURITY_ERROR);
    }
    $_POST['email_address'] = zen_db_prepare_input($_POST['email_address']);
    $email_address = $_POST['email_address'] ;
    if(get_user_blacklist($email_address)==true){
        $api->setStatus('0')->setMessage('error')->response(FS_ACCESS_DENIED_1);
    }
//含有特殊符号insert不了数据库
    $_POST['question'] = str_replace(array('\r\n','\n'), '<br/>', zen_db_input($_POST['comments_content']));
    $live_chat_mail_service_type = (int)$_POST['live_chat_mail_service_type'];
    $firstname = zen_db_prepare_input($_POST['entry_firstname']) ;
    $lastname = zen_db_prepare_input($_POST['entry_lastname']);
    $user_name = $firstname. ' ' . $lastname ;

//国家信息
    $country_code = $_POST['country_code'] ? zen_db_prepare_input($_POST['country_code']) : $_SESSION['countries_iso_code'];
    $country_code = strtoupper($country_code);
    $country_data = array();
    $countryService->setCountry('',$country_code);
    if($countryService->currentCountry){
        $country_data = $countryService->currentCountry->toArray();
    }
    $customers_country_id = $country_data['countries_id'];
    $customers_country_name = $country_data['countries_name'];

    $admin_id = $is_old =$customer_id =  0;
//judge has allot
    //获取改客户邮箱是否注册
    $customer_info = $db->Execute("select customers_id, customers_number_new, is_disabled  from customers where customers_email_address= '" . trim($email_address) . "'");
    if($customer_info->fields['customers_id']){
        $customer_id = $customer_info->fields['customers_id'];
        $isDisabled = $customer_info->fields['is_disabled'];
        $customers_number_new = $customer_info->fields['customers_number_new'];
        $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
        $dataInfo = getIsDisabledEmail($customers_number_new, $isDisabled, $admin_id);
        $admin_id = $dataInfo['admin_id'];
        $reason_type = $dataInfo['reason_type'];
    }else{
        $customer_id = 0;
        $admin_id = 0 ;
    }

// $is_old 在 auto_given.php文件也有定义 标记客户是否是老客户 用于统计
    require(DIR_WS_MODULES . zen_get_module_directory('message_entrance_auto_given.php'));

    /*客户分配*/
    if(!$admin_id){
        $allot_type = 'email';
        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
    }

//生成case number
    $case_data = array(
        'case_from'=>3,
        'customer_email' => $_POST['email_address'],
        'admin_id' => $admin_id,
        'question_content' => $_POST['question'],
        'service_admin' => $service_ids,
        'area' => $area,
        'is_old' => $is_old ? $is_old : 0,
    );
    //$CaseNumber = $caseService->createCaseNumber($case_data);
    $admin_name = $admin_email = '';
    if ($admin_id) {
        //获取销售名字和邮箱
        $admin_name = zen_get_admin_name_of_id($admin_id);
        $admin_email = zen_get_admin_email_of_name($admin_name);
    }

    //服务流程开始
    if (!$admin_id) {
        $api->setStatus('0')->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    $number = create_number_new();
    if(!$number){
        $api->setStatus('0')->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    //销售节点
    $saleNodeId = $caseService->getSaleNodeId(1, 2);
    //客服节点
    $serviceNodeId = $caseService->getSaleNodeId(1, 1);
    //当前类型对应的流程节点串
    $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = 1');
    if (!$saleNodeId || !$serviceNodeId) {
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    //服务流程需要插入的数据
    $serviceArray = array();
    $question = array(
        'number' => $number,
        'node_flow' => $node_flow ? $node_flow : $saleNodeId,
        'urgent_level' => 1,
        'sale_id' => $admin_id,
        'sale_name' => $admin_name,
        //'case_number' => $CaseNumber,
        'customer_name'=>$user_name,
        'customer_email'=>$email_address,
        'customer_telephone' =>$_POST['entry_telephone'],
        'customer_country_id' => $customers_country_id,
        'customer_country_name' => $customers_country_name,
        'customer_describe' => zen_db_prepare_input($_POST['question']),
        'language_id'=>$_SESSION['languages_id'],
        'service_id'=> 3018,
        'service_name'=> zen_get_admin_name_of_id(3018),
        'created_time' => time(),
        'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        'created_type' => 13,
        'type_id' => 1,
        'service_type' => $live_chat_mail_service_type,
        'customer_service' => 1, //客服区域统一给国内1
        'current_node_id' => $saleNodeId,
    );
    //添加服务流程客服表
    $assignAdminData = [
        'number'   => $number,
        'admin_id' => $admin_id,
    ];
    $nodeData = [
        [
            'number' => $number,
            'admin_id' => $admin_id,
            'node_id' => $saleNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
        [
            'number' => $number,
            'admin_id' => 3018,
            'node_id' => $serviceNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ]
    ];
    $recordData = [
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>$admin_id,
            'admin_name'=>zen_get_admin_name_of_id($admin_id),
            'comment'=>'none',
        ],
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>3018,
            'admin_name'=>zen_get_admin_name_of_id(3018),
            'comment'=>'该服务由销售发起，客服无需处理。',
        ]
    ];
    //添加服务流程所有逻辑
    $serviceArray = [
        'service_process' => $question,
        'service_process_assign_admin' => $assignAdminData,
        'service_process_assign_node' => $nodeData,
        'service_process_record' => $recordData
    ];
    //上传文件到服务流程文件表
    if ($_FILES["reviews_newImg"]['name'][0]) {
        $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
        $folderName = "myCase/" . $randPath;
        $uploadfiles = $caseService->uploadFiles($_FILES["reviews_newImg"],$folderName);
        if ($uploadfiles['code'] == 0) {
            $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        if ($uploadfiles['path']) {
            $uploadfiles_data = [];
            foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
                $uploadfiles_data[] = array(
                    'service_process_number' => $number,
                    'file_name' => $_FILES["reviews_newImg"]['name'][$upload_k],
                    'storage_name' => explode('/',$upload_v)[2],
                    'storage_path' => $randPath,
                );
                //$caseService->createServiceFile($uploadfiles_data);
            }
            $serviceArray['service_process_file'] = $uploadfiles_data;
        }
    }
    //服务流程插入操作
    $serviceInfo = $caseService->insertServiceProcess($serviceArray);
    if ($serviceInfo == false) {
        $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }

    if($serviceInfo) {
        // fairy 2018.8.30 add
        // 如果该项分配当前销售。则也要把该用户分配给当前销售等操作
        $source = 7;  // 客户来源：email
        if ($email_address) {
            auto_given_customers_to_admin(array(
                'admin_id' => $admin_id ? $admin_id : 0,
                'email_address' => $email_address,
                'admin_id_from_table' => $admin_id_from_table,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'nick' => $user_name,
                'country' => $customers_country_id,
                'telephone' => $_POST['entry_telephone'],
                'source' => $source,       // 客户来源：email
                'is_old' => $is_old ? $is_old : 0,    // 标记新、老客户
                'customer_number' => $customers_customers_number_new,
                'customer_offline_number' => $offline_customers_number_new,
                'invalidSign' => $invalidSign,
            ));
        }

        $send_time = date("Y/m/d");
        $service_type = '';
        switch ($live_chat_mail_service_type) {
            case 1:
                $service_type = FS_LIVE_CHAT_SERVICE_MAIL_TYPE1;
                break;
            case 2:
                $service_type = FS_LIVE_CHAT_SERVICE_MAIL_TYPE2;
                break;
            case 3:
                $service_type = FS_LIVE_CHAT_SERVICE_MAIL_TYPE3;
                break;
            case 4:
                $service_type = FS_LIVE_CHAT_SERVICE_MAIL_TYPE4;
                break;
            case 5:
                $service_type = FS_LIVE_CHAT_SERVICE_MAIL_TYPE5;
                break;
        }

        $html_msg = array();  //the email content
        $html_msg = array();
        get_email_langpac();
        $title_info = FS_SEND_EMAIL_3;
        if ($_SESSION['languages_code'] == "jp") {
            $title_info = "サポートリクエスト受領済み";
        }
        $html_case_str = str_replace('###case_number###', $number, SAMPLE_EMAIL_30);
        $html_case_str = str_replace('$HREF',zen_href_link('my_cases_details','new_old_data=1&case='.$number),$html_case_str);
        $html = common_email_header_and_footer($title_info, FS_SEND_EMAIL_9 . $number);
        $pick_time = date('d.m.y', time());
        if (in_array($_SESSION['languages_code'], array('de', 'dn'))) {
            $pick_time = date('d.m.y', time());
        } elseif ($_SESSION['languages_code'] == "jp") {
            $pick_time = date('Y/m/d', time());
        }
        $tel_prefix = fs_get_data_from_db_fields('tel_prefix','countries','countries_id = '.(int)$customers_country_id,'');
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            ' . FS_MODIFY_EMAIL_MY_CASE_08 . ' ' . ucfirst($user_name) . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody> 
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           ' . FS_SUPPORT_EMAIL_TOUCH_SOON . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                          ' . $html_case_str . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;background-color: #fff;" align="left">
                            ' . SAMPLE_EMAIL_03 . ucfirst($user_name) . '<br />
                            ' . SAMPLE_EMAIL_04 . '<a style="text-decoration: none;color: #0070bc;" href="mailto:donna@gmail.com">' . $email_address . '</a> <br />
                            ' . SAMPLE_EMAIL_05 . $customers_country_name . ' <br />
                            ' . FS_ACCOUNT_PHONE . '<a style="text-decoration: none;color: #0070bc;" href="javascript:;">'.$tel_prefix." ". $_POST['entry_telephone'] . '</a> <br />
                             ' . FS_LIVE_CHAT_SUBJECT_WIDTH_COLON . $service_type . '<br />
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">
                            ' . SAMPLE_EMAIL_07 . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           ' . $_POST['question'] . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                           ' . RESET_PASS_SUCCESS_04 . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
        if ($_SESSION['languages_code'] == "jp") {
            $title = "サポートリクエスト" . $number . "は既に受領されました。";
        }elseif ($_SESSION['languages_code'] == "de"){
            $title = FS_SEND_EMAIL_8_1 . $number . ' erhalten';
        } else {
            $title = FS_SEND_EMAIL_8_1 . $number;
        }

        // EMAIL_FROM
        //var_dump($html_msg_customer);die;
        sendwebmail($user_name, $email_address, 'live_chat留言发送客户邮件:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
        /* emial content */
        if ($service_email && getIsSendServiceEmail()) {
            sendwebmail($service_name, $service_email, 'live_chat发给客服:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
        }
        if($admin_id){
            $adminInfo = getAdminInfo($admin_id);
            sendwebmail($adminInfo['name'], $adminInfo['email'], 'live_chat发给销售:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
        }
        $api->setStatus('1')->setMessage('success')->response($number);
    }
}elseif($ajaxRequestAction == 'addOrderCase'){
    $language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
    require_once($language_page_directory . 'views/validation.common.php');
    require_once($language_page_directory . 'views/my_cases.php');
    require_once($language_page_directory . 'views/live_chat_service_mail.php');
    require_once($language_page_directory . 'views/manage_orders.php');
    if ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) {
        $api->setStatus('0')->setMessage('error')->response(FS_SECURITY_ERROR);
    }
    if(!isAjax() || empty($_SESSION['customer_id'])){
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $service_prd_arr = explode(',',zen_db_input($_POST['service_prd_arr']));
    $service_type = 4;
    $question_content = zen_db_prepare_input($_POST['comments_content']);
    $customer = new CustomerService();
    $customer_info = $customer->setField(['customers_telephone', 'is_disabled'])->setLoadCountry(true)->setCustomer()->currentCustomer;
    if ($customer_info) {
        $customer_email = $customer_info->customers_email_address;
        $customer_name = $customer_info->customers_firstname.' '.$purchase_ordercustomer_info->customers_lastname;
        $customers_telephone = $customer_info->customers_telephone;
        $customers_country_id = $customer_info->customer_country_id;
        $isDisabled = $customer_info->is_disabled;
        $customers_number_new = $customer_info->customers_number_new;
        $customer_id = $customer_info->customers_id;
        $admin_id = zen_get_customer_has_allot_to_admin($customer_id);
        $dataInfo = getIsDisabledEmail($customers_number_new, $isDisabled, $admin_id);
        $admin_id = $dataInfo['admin_id'];
        $reason_type = $dataInfo['reason_type'];
        if ($customer_info->country) {
            $customers_country_name = $customer_info->country->countries_name;
        }
    } else {
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $email_address = $customer_email;
    require_once(DIR_WS_MODULES.'/message_entrance_auto_given.php');
    if(!$admin_id){
        $allot_type = 'customer_broke';
        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
    }

    $admin_id = $admin_id ? $admin_id : 0;
    $is_old = 0;
    $admin = new AdminService();
    $admin_info = $admin->setAdmin($admin_id)->currentAdmin;
    if ($admin_info) {
        $admin_id = $admin_info['admin_id'];
        $admin_name = $admin_info['admin_name'];
        $admin_email = $admin_info['admin_email'];
    }
    $is_go_auto_given = 1;
    // fairy 2018.8.30 add 针对进行经过自动分配的用户，如果该项分配当前销售。则也要把该用户分配给当前销售
    if ($admin_id && $_SESSION['customer_id'] && $is_go_auto_given) {
        auto_given_customers_to_admin(array(
            'admin_id' => $admin_id,
            'email_address' => $email_address,
            'admin_id_from_table' => $admin_id_from_table,
            'customers_id' => $_SESSION['customer_id'], // 注册用户
            'customer_number' => $customers_customers_number_new,
            'customer_offline_number' => $offline_customers_number_new,
            'invalidSign' => $invalidSign,
        ));
    }
    $service_ids = $service_ids ? $service_ids : 0;
    if ($admin_id) {
        //获取销售名字和邮箱
        $admin_name = $admin_info['admin_name'];
        $admin_email = $admin_info['admin_email'];
    }

    //服务流程开始
    if (!$admin_id) {
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    $number = create_number_new();
    if(!$number){
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    //销售节点
    $saleNodeId = $caseService->getSaleNodeId(10, 2);
    //客服节点
    $serviceNodeId = $caseService->getSaleNodeId(10, 1);
    //当前类型对应的流程节点串
    $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = 10');
    if (!$saleNodeId || !$serviceNodeId) {
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $serviceArray = array();
    $question = array(
        'number' => $number,
        'node_flow' => $node_flow ? $node_flow : $saleNodeId,
        'urgent_level' => 1,
        'sale_id' => $admin_id,
        'sale_name' => $admin_name ? $admin_name : '',
        //'case_number' => $caseNumber,
        'customer_name'=>$customer_name,
        'customer_email'=>$customer_email,
        'customer_telephone' =>$customers_telephone,
        'customer_country_id' => $customers_country_id,
        'customer_country_name' => $customers_country_name ? $customers_country_name : '',
        'order_number' =>  zen_db_input($_POST['service_order_number']),
        'customer_describe' => $question_content,
        'language_id'=>$_SESSION['languages_id'],
        'service_id'=> 3018,
        'service_name'=> zen_get_admin_name_of_id(3018),
        'created_time' => time(),
        'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        'type_id' => 10,
        'created_type' => 15,
        'service_type' => $service_type,
        'customer_service' => 1, //客服区域统一给国内1
        'current_node_id' => $saleNodeId,
    );
    //添加服务流程客服表
    $assignAdminData = [
        'number'   => $number,
        'admin_id' => $admin_id,
    ];
    $nodeData = [
        [
            'number' => $number,
            'admin_id' => $admin_id,
            'node_id' => $saleNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
        [
            'number' => $number,
            'admin_id' => 3018,
            'node_id' => $serviceNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
    ];
    $recordData = [
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>$admin_id,
            'admin_name'=>zen_get_admin_name_of_id($admin_id),
            'comment'=>'none',
        ],
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>3018,
            'admin_name'=>zen_get_admin_name_of_id(3018),
            'comment'=>'该服务由销售发起，客服无需处理。',
        ]
    ];
    //添加服务流程数组
    $serviceArray = [
        'service_process' => $question,
        'service_process_assign_admin' => $assignAdminData,
        'service_process_assign_node' => $nodeData,
        'service_process_record' => $recordData,
    ];
    //添加服务流程产品表
    if ($service_prd_arr) {
        $order_product_info = [];
        foreach ($service_prd_arr as $value) {
            $order_product_info[] = array(
                'number' => $number,
                'products_id' => $value,
                'products_num' => 1
            );
        }
        $serviceArray['service_process_product'] = $order_product_info;
    }
    //上传文件
    if ($_FILES["reviews_newImg"]['name'][0]) {
        $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
        $folderName = "myCase/" . $randPath;
        $uploadfiles = $caseService->uploadFiles($_FILES["reviews_newImg"],$folderName);
        if ($uploadfiles['code'] == 0) {
            $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        if ($uploadfiles['path']) {
            $uploadfiles_data = [];
            foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
                $uploadfiles_data[] = array(
                    'service_process_number' => $number,
                    'file_name' => $_FILES["reviews_newImg"]['name'][$upload_k],
                    'storage_name' => explode('/',$upload_v)[2],
                    'storage_path' => $randPath,
                );
            }
            $serviceArray['service_process_file'] = $uploadfiles_data;
        }
    }
    //服务流程插入操作
    $serviceInfo = $caseService->insertServiceProcess($serviceArray);
    if ($serviceInfo == false) {
        $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }

    $html_msg = array();  //the email content
    $html_msg = array();
    get_email_langpac();
    $title_info = FS_SEND_EMAIL_3;
    $item = F_BODY_HEADER_ITEM;
    if ($_SESSION['languages_code'] == "jp") {
        $title_info = "リクエスト受領済み";
        $item = '';
    }
    $html_case_str = str_replace('###case_number###', $number, SAMPLE_EMAIL_30);
    $html_case_str = str_replace('$HREF',zen_href_link('my_cases_details','new_old_data=1&case='.$number),$html_case_str);
    $html = common_email_header_and_footer($title_info, FS_SEND_EMAIL_9 . $number);
    $service_prd_html = '';
    if ($service_prd_arr) {
        $service_prd_html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;" height="10">
    
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" align="left">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #616265;line-height: 22px;font-family: Open Sans,arial,sans-serif;border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;">
                                            '.$item.'
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;" height="20">
    
                            </td>
                        </tr>
                        </tbody>
                    </table>';
        foreach ($service_prd_arr as $prd_k => $prd_val) {
            $service_pro_name = zen_get_products_name((int)$prd_val);
            $product_href = zen_href_link('product_info', 'products_id=' . (int)$prd_val);
            $image_stock = get_resources_img((int)$prd_val, 60, 60, '', '', '', ' style="" ');
            $count = count($service_prd_arr) - 1;
            $service_prd_html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;" height="20">
    
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;padding-left:20px;" width="60">
                                <a style="text-decoration: none;" href="' . $product_href . '">
                                    '.$image_stock.'
                                </a>
                            </td>
                            <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                                <a style="text-decoration: none;color: #232323;" href="' . $product_href . '">
                                    <span>' . $service_pro_name . '</span>
                                </a>
                                <br>
                                <span style="text-decoration: none;color: #8d8d8f;font-size: 13px;display: inline-block;margin-top: 5px;">#' . $prd_val . '</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
            if ($count != $prd_k) {
                $service_prd_html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;padding:0 20px">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                        <td bgcolor="#fff" style="border-collapse: collapse;border-bottom: 1px solid #e5e5e5;" height="20">
                
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>';
            }
        }
        $service_prd_html .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td bgcolor="#fff" style="border-collapse: collapse;" height="20">
    
                            </td>
                        </tr>
                        </tbody>
                    </table>';
    }
    $pick_time = date('d.m.y', time());
    if (in_array($_SESSION['languages_code'], array('de', 'dn'))) {
        $pick_time = date('d.m.y', time());
    } elseif ($_SESSION['languages_code'] == "jp") {
        $pick_time = date('Y/m/d', time());
    }
    $tel_prefix = fs_get_data_from_db_fields('tel_prefix','countries','countries_id = '.(int)$customers_country_id,'');
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            ' . FS_MODIFY_EMAIL_MY_CASE_08 . ' ' . ucfirst($customer_name) . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody> 
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           ' . FS_SUPPORT_EMAIL_TOUCH_SOON . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                          ' . $html_case_str . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_ORDERS_SERVICE_O3 . $_POST['service_order_number'] . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                  
                ' . $service_prd_html . '    
                    
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding:0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;border-top: 1px solid #e5e5e5;" height="30">
            
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px;font-weight: 600;" align="left">
                            ' . SAMPLE_EMAIL_07 . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           ' . $question_content . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                           ' . RESET_PASS_SUCCESS_04 . '
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
    if ($_SESSION['languages_code'] == "jp") {
        $title = "サポートリクエスト" . $number . "は既に受領されました。";
    } else {
        $title = FS_SEND_EMAIL_8_1 . $number;
    }

    // EMAIL_FROM
    //var_dump($html_msg_customer);die;
    sendwebmail($customer_name, $email_address, '订单技术支持发送客户邮件:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    /* emial content */
    if($admin_id){
        sendwebmail($admin_name, $admin_email, '订单技术支持发给客服:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    }
    if ($service_email && getIsSendServiceEmail()) {
        sendwebmail($service_name, $service_email, '订单技术支持发给客服:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    }
    $api->setStatus('1')->setMessage('success')->response($number);
}elseif ($ajaxRequestAction == 'purchase_order'){
    if(!isset($_POST) || !isAjax() || empty($_SESSION['customer_id']) || !isset($_FILES["po_files"]) || $_POST['po_number'] == ''){
        $api->setStatus(401)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }
    $language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
    require_once($language_page_directory . 'views/validation.common.php');
    require_once($language_page_directory . 'views/purchase_order.php');
    require_once($language_page_directory . 'views/live_chat_service_mail.php');
    require_once($language_page_directory . 'views/manage_orders.php');

    $customer = new CustomerService();
    $customer_info = $customer->setField(['customers_telephone'])->setLoadCountry(true)->setCustomer()->currentCustomer;
    if ($customer_info) {
        $first_name = $_POST['first_name'] ? zen_db_prepare_input($_POST['first_name']) : $customer_info->customers_firstname;
        $last_name = $_POST['last_name'] ? zen_db_prepare_input($_POST['last_name']) : $customer_info->customers_lastname;
        $email = $_POST['email'] ? zen_db_prepare_input($_POST['email']) : $customer_info->customers_email_address;
        $phone_number = $_POST['phone_number'] ? zen_db_prepare_input($_POST['phone_number']) : $customer_info->customers_telephone;
        $customers_country_id = $customer_info->customer_country_id;
        if ($customer_info->country) {
            $customers_country_name = $customer_info->country->countries_name;
        }
    } else {
        $api->setStatus(402)->setMessage("error")->response(['info' => FS_ACCESS_DENIED]);
    }
    $po_number    =  zen_db_prepare_input($_POST['po_number']);
    $po_relate_number =  zen_db_prepare_input($_POST['po_relate_number']);
    $comments     =  str_replace(array('\r\n','\n'), '<br/>', zen_db_prepare_input($_POST['comments']));
    $email_address = $email;
    $allot_type = 'customer_broke';
    require_once(DIR_WS_MODULES.'/message_entrance_auto_given.php');

    /*客户销售*/
    if(!$admin_id){
        require_once(DIR_WS_MODULES.'/auto_given.php');
    }

    $admin_id = $admin_id ? $admin_id : 0;
    $is_old = 0;
    $admin = new AdminService();
    $admin_info = $admin->setAdmin($admin_id)->currentAdmin;
    if ($admin_info) {
        $admin_id = $admin_info['admin_id'];
        $admin_email = $admin_info['admin_email'];
        $admin_name = $admin_info['admin_name'];
    }
    $is_go_auto_given = 1;
    // fairy 2018.8.30 add 针对进行经过自动分配的用户，如果该项分配当前销售。则也要把该用户分配给当前销售
    if ($admin_id && $_SESSION['customer_id'] && $is_go_auto_given) {
        auto_given_customers_to_admin(array(
            'admin_id' => $admin_id,
            'email_address' => $email_address,
            'admin_id_from_table' => $admin_id_from_table,
            'customers_id' => $_SESSION['customer_id'], // 注册用户
            'customer_number' => $customers_customers_number_new,
            'customer_offline_number' => $offline_customers_number_new,
            'invalidSign' => $invalidSign,
        ));
    }
    $customer_name = $first_name.' '.$last_name;
    $service_ids = $service_ids ? $service_ids : 0;
    if ($admin_id) {
        //获取销售名字和邮箱
        $admin_name = $admin_info['admin_name'];
        $question['sale_name'] = $admin_name;
        $admin_email = $admin_info['admin_email'];
    }

    //服务流程开始
    if (!$admin_id) {
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    $number = create_number_new();
    if(!$number){
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    //销售节点
    $saleNodeId = $caseService->getSaleNodeId(11, 2);
    //客服节点
    $serviceNodeId = $caseService->getSaleNodeId(11, 1);
    //当前类型对应的流程节点串
    $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = 11');
    if (!$saleNodeId || !$serviceNodeId) {
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $serviceArray = array();
    $question = array(
        'number' => $number,
        'node_flow' => $node_flow ? $node_flow : $saleNodeId,
        'urgent_level' => 1,
        'sale_id' => $admin_id,
        'sale_name' => $admin_name,
        'customer_name'=>trim($customer_name),
        'customer_email'=>$email,
        'customer_telephone' =>$phone_number,
        'customer_country_id' => $customers_country_id,
        'customer_country_name' => $customers_country_name,
        'customer_describe' => $comments == '' ? 'none' : $comments,
        'language_id'=>$_SESSION['languages_id'],
        'service_id'=> 3018,
        'service_name'=> zen_get_admin_name_of_id(3018),
        'created_time' => time(),
        'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        'type_id' => 11,
        'created_type' => 16,
        'service_type' => 6,
        'po_number' => $po_number,
        'po_relate_number' => $po_relate_number,
        'customer_service' => 1,
        'current_node_id' => $saleNodeId,
    );
    //添加服务流程客服表
    $assignAdminData = [
        'number'   => $number,
        'admin_id' => $admin_id,
    ];
    $nodeData = [
        [
            'number' => $number,
            'admin_id' => $admin_id,
            'node_id' => $saleNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
        [
            'number' => $number,
            'admin_id' => 3018,
            'node_id' => $serviceNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ]
    ];
    $recordData = [
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>$admin_id,
            'admin_name'=>zen_get_admin_name_of_id($admin_id),
            'comment'=>'none',
        ],
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>3018,
            'admin_name'=>zen_get_admin_name_of_id(3018),
            'comment'=>'该服务由销售发起，客服无需处理。',
        ]
    ];
    //添加服务流程所有逻辑
    $serviceArray = [
        'service_process' => $question,
        'service_process_assign_admin' => $assignAdminData,
        'service_process_assign_node' => $nodeData,
        'service_process_record' => $recordData
    ];

    //上传文件
    /*
    $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
    $folderName = "myCase/" . $randPath;
    $uploadfiles = $caseService->uploadFiles($_FILES["po_files"],$folderName);
    if ($uploadfiles['code'] == 0) {
        $api->setStatus(403)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }
    */
    $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
    $savepath = "myCase/" . $randPath;

    require_once(DIR_WS_CLASSES.'uploads.php');
    $uploadfiles = array();
    $fileFormat = array('pdf', 'jpg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'txt');
    $maxsize = 5*1024*1024; //上传文件大小限制
    $overwrite = 1; //0. no 1. yes
    $f = new Uploads($savepath, $fileFormat, $maxsize, $overwrite);
    if (!$f->run("po_files",1)){
        $api->setStatus(403)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }else{
        $info = $f->returnArray;
        if($info){
            foreach($info as $key=>$v){
                $pic_name = strtolower(str_replace(' ', '-', $v['saveName']));
                $saveName = $savepath.'/'.$pic_name;
                $uploadfiles['path'][] = $saveName;
            }
        }
    }

    if ($uploadfiles['path']) {
        $uploadfiles_data = [];
        foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
            $uploadfiles_data[] = array(
                'service_process_number' => $number,
                'file_name' => $_FILES["po_files"]['name'][$upload_k],
                'storage_name' => explode('/',$upload_v)[2],
                'storage_path' => $randPath,
            );
            //$caseService->createServiceFile($uploadfiles_data);
        }
        $serviceArray['service_process_file'] = $uploadfiles_data;
    }
    //服务流程插入操作
    $serviceInfo = $caseService->insertServiceProcess($serviceArray);
    if ($serviceInfo == false) {
        $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }

    //清除表单cookie
    setcookie("purchase_form",'', time()-3600);
    $api->setStatus(200)->setMessage('success')->response([
        'info' => PURCHASE_FORM_TIP_07,
        'link' => zen_href_link('purchase_order_list'),
        'emailData' => array(
            'po_number' => $po_number,
            'customer_name' => $customer_name,
            'number' => $number,
            'email_address' => $email_address,
            'service_name' => $service_name,
            'service_email' => $service_email,
            'admin_name' => $admin_name,
            'admin_email' => $admin_email
        )
    ]);
}elseif ($ajaxRequestAction == 'purchase_order_email'){
    $po_number = $_POST['po_number'];
    $customer_name = $_POST['customer_name'];
    $number = $_POST['number'];
    $email_address = $_POST['email_address'];
    $service_name = $_POST['service_name'];
    $service_email = $_POST['service_email'];
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];

    if(!$po_number || !$customer_name || !$email_address){
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response();
    }
    $html_msg = array();  //the email content
    $html_msg = array();
    get_email_langpac();
    require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/purchase_order.php');
    $title = str_replace('POXXX',$po_number,PURCHASE_EMAIL_TITLE);
    $html = common_email_header_and_footer(PURCHASE_EMAIL_REVIEWING, $title);
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $content_01 = str_replace('#POXXX','<a href="'.zen_href_link('purchase_order_details','case='.$number).'" target="_blank" style="color: #0070bc;text-decoration: none;">#'.$po_number.'</a>',PURCHASE_EMAIL_CONTENT_01);
    $content_02 = PURCHASE_EMAIL_CONTENT_02;
    $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.FS_MODIFY_EMAIL_MY_CASE_08. ' ' .ucfirst(trim($customer_name)).FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           '.$content_01.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                           '.$content_02.'
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                           '.RESET_PASS_SUCCESS_04.'
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#f5f6f7" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
    // EMAIL_FROM
    sendwebmail($customer_name, $email_address, '提交PO发送客户邮件:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    /* emial content */
    if ($service_email && getIsSendServiceEmail()) {
        sendwebmail($service_name, $service_email, '提交PO发送给客服:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    }

    if ($admin_email){
        sendwebmail($admin_name, $admin_email, '提交PO发送给销售:' . date('Y-m-d H:i:s', time()), STORE_NAME, $title, $html_msg, 'default');
    }
    $api->setStatus(200)->setMessage('')->response(['content' => $html_msg]);
}elseif ($ajaxRequestAction == 'addPurchaseCase'){
    $api = new ApiResponse();
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $api->setStatus(403)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $languagePath = DIR_WS_LANGUAGES.$_SESSION['language'];
    require($languagePath.".php");
    require($languagePath."/views/validation.common.php");
    if (!isset($_FILES['poFile']) || empty($_FILES['poFile']['name'][0])){
        $api->setStatus(1)->setMessage(FS_NET_30_02)->response('poFile[]');
    }
    $fullName = zen_db_prepare_input($_POST['fullName']);
    $email = zen_db_prepare_input($_POST['email']);
    $phone = zen_db_prepare_input($_POST['phone']);
    $comments = zen_db_prepare_input($_POST['comments']);
    $customers_country_id = abs((int)$_POST['countryId']);
    $data = [
        'fullName' => $fullName,
        'email'    => $email,
        'phone'    => $phone,
        'comments' => $comments,
        'countryId' => $customers_country_id,
    ];
    $validate = new PurchaseCaseSettingRequest();
    $validate->data = $data;
    $error = $validate->checkData();
    if (!empty($error)){
        foreach ($error as $item => $e){
            //countryId 验证不通过标识是接口工具发送的，页面上必定有值
            if ($item == 'countryId'){
                $api->setStatus(2)->setMessage(FS_ACCESS_DENIED)->response($item);
            }
            $api->setStatus(1)->setMessage($e)->response($item);
        }
    }
    $customerService = new CustomerService();
    if ($customerService->checkBlackEmail($email)){
        $api->setStatus(2)->setMessage(FS_ACCESS_DENIED_1)->response();
    }
    $customer_info = $customerService
        ->setField(['customers_authorization', 'is_disabled'])
        ->setCustomer(0,$email)
        ->currentCustomer;
    if (!empty($customer_info)){
        if ($customerService->checkBlack()){
            $api->setStatus(2)->setMessage(FS_ACCESS_DENIED_1)->response();
        }
        $purchaseInfo = (new PurchaseService())
            ->setCid($customer_info->customers_id)
            ->getPurchaseInfo();
        if ($purchaseInfo['is_po_account']){
            $api->setStatus(1)->setMessage(FS_NET_30_03)->response('email');
        }
    }

    //服务流程需要插入的数据
    $serviceArray = array();
    $number = create_number_new();
    if(!$number){
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    $country_code = $customers_country_name =  '';
    $countryService = new CountryService();
    $countryService->setCountry($customers_country_id);
    if (!empty($countryService->currentCountry)) {
        $country_data = $countryService->currentCountry->toArray();
        $country_code = $country_data['countries_iso_code_2'];
        $customers_country_name = $country_data['countries_name'];
    }

    //获取销售信息
    $customer_id = $admin_id = $is_old =$is_go_auto_given  = 0;
    $admin_name = $admin_email = '';
    $admin = new AdminService();
    if (!empty($customer_info)){
        $customer_id = $customer_info->customers_id;
        $admin_info = $admin->getAdminByCustomer($customer_id);
        if (!empty($admin_info)){
            $admin_id = $admin_info->admin_id;
        }
        $customers_number_new = $customer_info->customers_number_new;
        $isDisabled = $customer_info->is_disabled;
        $dataInfo = getIsDisabledEmail($customers_number_new, $isDisabled, $admin_id);
        $admin_id = $dataInfo['admin_id'];
        $reason_type = $dataInfo['reason_type'];
    }
    if(!$admin_id){
        $email_address = $email;
        $allot_type='net_30_apply';
        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
        $is_go_auto_given = 1;
        // fairy 2018.8.30 add 如果该项分配当前销售。则也要把该用户分配给当前销售
        if ($admin_id) {
            auto_given_customers_to_admin(array(
                'admin_id' => $admin_id,
                'email_address' => $email_address,
                'admin_id_from_table' => $admin_id_from_table,
                'customers_id' => $customer_id, // 注册用户
                'is_make_up' => $is_make_up ? : 0,
                'from_auto_file' => 'auto_given',
                'is_old' => $is_old ? $is_old : 0,    // 标注新、老客户
                'customer_number' => $customers_customers_number_new,
                'customer_offline_number' => $offline_customers_number_new,
                'invalidSign' => $invalidSign,
            ));
        }
    }
    $admin_info = $admin->setAdmin($admin_id)->currentAdmin;
    //获取销售名字和邮箱
    $admin_name = $admin_info->admin_name;
    $admin_email = $admin_info->admin_email;

    //服务流程开始
    if (!$admin_id) {
        $api->setStatus(404)->setMessage('error')->response(FS_SYSTME_BUSY);
    }
    //销售节点
    $saleNodeId = $caseService->getSaleNodeId(12, 2);
    //客服节点
    $serviceNodeId = $caseService->getSaleNodeId(12, 1);
    //当前类型对应的流程节点串
    $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = 12');
    if (!$saleNodeId || !$serviceNodeId) {
        $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $question = array(
        'number'                => $number,
        'node_flow'             => $node_flow ? $node_flow : $saleNodeId,
        'urgent_level'          => 1,
        'customer_name'         => $fullName,
        'customer_email'        => $email,
        'customer_telephone'    => $phone,
        'customer_country_id'   => $customers_country_id,
        'customer_country_name' => $customers_country_name,
        'customer_describe'     => $comments,
        'language_id'           => $_SESSION['languages_id'],
        'service_id'=> 3018,
        'service_name'=> zen_get_admin_name_of_id(3018),
        'created_time' => time(),
        'created_at'            =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        'created_type'          => 17,
        'service_type'          => 5,
        'sale_id'               => $admin_id,
        'sale_name'             => $admin_name,
        'type_id'               => 12,
        'type_name'             => '账期申请',
        'credit_status'         => '1',
        'customer_service'      =>  1,
        'current_node_id'       => $saleNodeId,
    );
    //添加服务流程客服表
    $assignAdminData = [
        'number'   => $number,
        'admin_id' => $admin_id,
    ];
    $nodeData = [
        [
            'number' => $number,
            'admin_id' => $admin_id,
            'node_id' => $saleNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
        [
            'number' => $number,
            'admin_id' => 3018,
            'node_id' => $serviceNodeId,
            'created_at'=>  getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
        ],
    ];
    $recordData = [
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>$admin_id,
            'admin_name'=>zen_get_admin_name_of_id($admin_id),
            'comment'=>'none',
        ],
        [
            'number' => $number,
            'node_id' => $serviceNodeId,
            'admin_id'=>3018,
            'admin_name'=>zen_get_admin_name_of_id(3018),
            'comment'=>'该服务由销售发起，客服无需处理。',
        ]
    ];
    //添加服务流程所有逻辑
    $serviceArray = [
        'service_process' => $question,
        'service_process_assign_admin' => $assignAdminData,
        'service_process_assign_node' => $nodeData,
        'service_process_record' => $recordData
    ];
    //先对文件进行上传
    $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
    $folderName = "myCase/" . $randPath;
    $fileAllowedTypes = [
        'image/png',
        'image/jpg',
        'image/jpeg',
        'application/pdf',
        'text/plain',
        'doc',
        'application/msword',
        'xls',
        'application/vnd.ms-excel',
        'application/vnd.ms-office',
        'docx',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/zip'
    ];
    $uploadfiles = $caseService->uploadFiles($_FILES["poFile"],$folderName,$fileAllowedTypes);
    if ($uploadfiles['code'] == 0) {
        $api->setStatus(2)->setMessage(FS_SYSTME_BUSY)->response($uploadfiles);
    }
    if ($uploadfiles['path']) {
        $uploadfiles_data = [];
        foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
            $uploadfiles_data[] = array(
                'service_process_number' => $number,
                'file_name' => $_FILES["poFile"]['name'][$upload_k],
                'storage_name' => explode('/',$upload_v)[2],
                'storage_path' => $randPath,
            );
        }
        $serviceArray['service_process_file'] = $uploadfiles_data;
    }
    //服务流程插入操作
    $serviceInfo = $caseService->insertServiceProcess($serviceArray);
    if ($serviceInfo == false) {
        $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
    }

    $emailService = new Net30ApplyEmailService();
    $html = common_email_header_and_footer(FS_NET_30_31, '');
    $html_msg['EMAIL_HEADER'] = $html['header'];
    $html_msg['EMAIL_FOOTER'] = $html['footer'];
    $html_msg['EMAIL_BODY'] = $emailService->emailBody($fullName);
    $theme = FS_NET_30_04;
    //客户
    sendwebmail($user_name, $email, 'net30_purchase_apply:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'default');
    if ($admin_id) {
        //销售
        sendwebmail($admin_name, $admin_email, 'net30前台申请入口销售提醒邮件:' . date('Y-m-d h:i:s'), STORE_NAME, $theme, $html_msg, 'default');
    }
    $api->setStatus(200)->setMessage()->response();
}elseif ( $ajaxRequestAction == 'checkPurchaseEmail'){
    $api = new ApiResponse();
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $api->setStatus(403)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
    }
    $languagePath = DIR_WS_LANGUAGES.$_SESSION['language'];
    require($languagePath.".php");
    require($languagePath."/views/validation.common.php");
    $email = zen_db_prepare_input($_POST['email']);
    $data = [
        'email' => $email,
        'type'  => 'email',
    ];
    $validate = new PurchaseCaseSettingRequest();
    $validate->data = $data;
    $error = $validate->checkData();
    if (!empty($error)){
        foreach ($error as $item => $e){
            $api->setStatus(1)->setMessage($e)->response($item);
        }
    }
    $customerService = new CustomerService();
    if ($customerService->checkBlackEmail($email)){
        $api->setStatus(2)->setMessage(FS_ACCESS_DENIED_1)->response();
    }
    $customer_info = $customerService
        ->setField(['customers_authorization'])
        ->setCustomer(0,$email)
        ->currentCustomer;
    if (!empty($customer_info)){
        if ($customerService->checkBlack()){
            $api->setStatus(2)->setMessage(FS_ACCESS_DENIED_1)->response();
        }
        $purchaseInfo = (new PurchaseService())
            ->setCid($customer_info->customers_id)
            ->getPurchaseInfo();
        if ($purchaseInfo['is_po_account']){
            $api->setStatus(1)->setMessage(FS_NET_30_03)->response('email');
        }
    }
    $api->setStatus(200)->setMessage()->response();
}else{
    (new ApiResponse())->setStatus(403)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
}
