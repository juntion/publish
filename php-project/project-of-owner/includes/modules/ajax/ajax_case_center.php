<?php
use App\Services\Cases\CaseService;
use App\Services\Common\ApiResponse;
use App\Services\Customers\CustomerService;
use App\Services\Admins\AdminService;
use App\Services\Country\CountryService;

// 语言包
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require_once($language_page_directory . 'views/validation.common.php');
require_once($language_page_directory . 'views/my_cases.php');
require_once($language_page_directory . 'views/live_chat_service_mail.php');
$caseService = new CaseService();
$api = new ApiResponse();
$action = trim($_GET['ajax_request_action']) ? trim($_GET['ajax_request_action']) : '';
//接口限制
if (in_array($action, array('add_one_case', 'del', 'updateStatus','customers_append'))) {// 默认页面的权，放在前面是无需调用其他，直接退出
    if(!isAjax() || empty($_SESSION['customer_id'])){
        $api->setStatus(400)->setMessage(FS_ACCESS_DENIED)->response(['href' => zen_href_link('login')]);
    }
    if ($action != 'add_one_case') {
        $case_num = $_POST['case_num'] ? zen_db_prepare_input($_POST['case_num']) : ($_POST['case_number']);
        $new_old_data = $_POST['new_old_data'] ? zen_db_prepare_input($_POST['new_old_data']) : 1;
        if(!$case_num || ($case_num && !$caseService->getCaseList(false,$case_num,'all','',$new_old_data))){
            $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
        }
    }
} else {
    $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
}

switch($action) {
    //创建一个Case
    case 'add_one_case':
        //2019.11.28 服务流程页面上线，新建case的入口需要先隐藏掉
        if (!$_SESSION['customer_id']) {
            $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
        }
        $service_type = zen_db_input((int)$_POST['service_type']);
        $question_content = str_replace(array('\r\n','\n'), '<br/>', zen_db_prepare_input($_POST['question_content']));
        //验证
        $current_valide = get_current_valide( 'case', array(
            'service_type' => array(),
            'question_content' => array(),
        ));
        require_once('includes/templates/fiberstore/common/fs_valide_common.php');
        $number = create_number_new();
        if (!$number) {
            $api->setStatus(404)->setMessage(FS_SYSTME_BUSY)->response(['info' => '']);
        }
        $customer = new CustomerService();
        $customer_info = $customer->setField(['customers_telephone'])->setLoadCountry(true)->setCustomer()->currentCustomer;
        if ($customer_info) {
            $customer_email = $customer_info->customers_email_address;
            $customer_name = $customer_info->customers_firstname.' '.$customer_info->customers_lastname;
            $customers_telephone = $customer_info->customers_telephone;
            $customers_country_id = $customer_info->customer_country_id;
            if ($customer_info->country) {
                $customers_country_name = $customer_info->country->countries_name;
            }
        } else {
            $api->setStatus(404)->setMessage(FS_ACCESS_DENIED)->response(['info' => '']);
        }
        $email_address = $customer_email;
        $allot_type = 'customer_broke';
        require_once(DIR_WS_MODULES.'/message_entrance_auto_given.php');

        /*客户分配*/
        if(!$admin_id){
            require_once(DIR_WS_MODULES.'/auto_given.php');
        }
        $admin_id = $admin_id ? $admin_id : 0;
        $is_old = 0;
        $admin = new AdminService();
        $admin_info = $admin->setAdmin($admin_id)->currentAdmin;
        $admin_name = $admin_email = '';
        if($admin_id){
            //获取销售名字和邮箱
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
        $area = $area ? $area : '';
        //$question['area'] = $area;
//        $caseNumber = $caseService->createCaseNumber(
//            [
//                'case_from' => 2,
//                'customer_email' => $customer_email,
//                'admin_id' => $admin_id,
//                'question_content' => $question_content,
//                'service_admin' => $service_ids,
//                'area' => $area
//            ]
//        );
        //服务流程开始
        if ($admin_id) {
            //销售节点
            $saleNodeId = $caseService->getSaleNodeId(2, 2);
            //客服节点
            $serviceNodeId = $caseService->getSaleNodeId(2, 1);
            //当前类型对应的流程节点串
            $node_flow=fs_get_data_from_db_fields('GROUP_CONCAT(`id`)', 'service_process_node', ' is_delete = 0 and type_id = 2');
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
                //'case_number' => $caseNumber,
                'customer_name'=>$customer_name,
                'customer_email'=>$customer_email,
                'customer_telephone' =>$customers_telephone,
                'customer_country_id' => $customers_country_id,
                'customer_country_name' => $customers_country_name ? $customers_country_name : '',
                'customer_describe' => $question_content,
                'language_id'=>$_SESSION['languages_id'],
                'service_id'=> 3018,
                'service_name'=> zen_get_admin_name_of_id(3018),
                'created_time' => time(),
                'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
                'created_type' => 1,
                'service_type' => $service_type,
                'type_id' => 2,
                'customer_service' => 1, //客服区域统一给国内1
                'current_node_id' => $saleNodeId
            );

            //添加服务流程客服表
            $assignAdminData = [
                'number'   => $number,
                'admin_id' => $admin_id
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
            //服务流程上传文件
            if ($_FILES["reviews_img"]['name'][0]) {
                $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
                $folderName = "myCase/" . $randPath;
                $uploadfiles = $caseService->uploadFiles($_FILES["reviews_img"],$folderName);
                if ($uploadfiles['code'] == 0) {
                    $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
                }
                if ($uploadfiles['path']) {
                    $uploadfiles_data = [];
                    foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
                        $uploadfiles_data[] = array(
                            'service_process_number' => $number,
                            'file_name' => $_FILES["reviews_img"]['name'][$upload_k],
                            'storage_name' => explode('/',$upload_v)[2],
                            'storage_path' => $randPath,
                        );
                        ///$caseService->createServiceFile($uploadfiles_data);
                    }
                    $serviceArray['service_process_file'] = $uploadfiles_data;
                }
            }
            //服务流程插入操作
            $serviceInfo = $caseService->insertServiceProcess($serviceArray);
            if ($serviceInfo == false) {
                $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
            }
        }
        //服务流程结束
        //发邮件暂不重构
        /* email content  helun 客户进行创建问题后发送邮箱给指定销售*///发邮件暂不重构
        $title_info=FS_SEND_EMAIL_3;
        if($_SESSION['languages_code']=="jp") {
            $title = "サポートリクエスト" . $number . "は既に受領されました。";
            $title_info="サポートリクエスト受領済み";
        }else{
            $title = FS_SEND_EMAIL_19.$number;
        }
        get_email_langpac();
        $html = common_email_header_and_footer($title_info,FS_SEND_EMAIL_20);
        global $db;
        if($_SESSION['customers_id']){
            $customerImageSrc = $db->getAll("select customer_photo from customers where customers_id=".(int)$_SESSION['customer_id']);
            $img = $customerImageSrc[0]['customer_photo'];
            $img_src =  HTTPS_IMAGE_SERVER.DIR_WS_IMAGES. (($img) ? $img : 'portrait_pic01.jpg');
        }else{
            $customerImageSrc = $db->getAll("select customer_photo from customers where customers_email_address='".$customer_email."'");
            $img = $customerImageSrc[0]['customer_photo'];
            $img_src =  HTTPS_IMAGE_SERVER.DIR_WS_IMAGES. (($img) ? $img : 'portrait_pic01.jpg');
        }
        $pick_time = date('d.m.y',time());
        if(in_array($_SESSION['languages_code'],array('de','dn'))){
            $pick_time = date('d.m.y',time());
        }elseif($_SESSION['languages_code']=="jp"){
            $pick_time = date('Y/m/d',time());
        }
        $service_type = '';
        switch($_POST['service_type']){
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
        $html_case_str=SAMPLE_EMAIL_30;
        $html_case_str = str_replace('###case_number###', $number, SAMPLE_EMAIL_30);
        $html_case_str = str_replace('$HREF',zen_href_link('my_cases_details','new_old_data=1&case='.$number),$html_case_str);
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            ' . FS_MODIFY_EMAIL_MY_CASE_08 . ' ' . ucwords($customer_name)  . '' . FS_EMAIL_COMMA . '
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
                            '.SAMPLE_EMAIL_01.'
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
                            '.$html_case_str.'
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
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SUBJECT.": ".$service_type.'
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

        if($question_content){
            $html_msg['EMAIL_BODY'].= '<table width="640" border="0" cellpadding="0" cellspacing="0">
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

        $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                </table>';
        if ($admin_id) {
            sendwebmail($admin_name, $admin_email,'my_case留言入口销售提醒邮件:'.date('Y-m-d h:i:s',time()), STORE_NAME, $title, $html_msg, 'default');
        }
        if($service_email && getIsSendServiceEmail()){
            sendwebmail($service_name, $service_email,'my_case留言入口客服提醒邮件:'.date('Y-m-d h:i:s',time()), STORE_NAME, $title, $html_msg,'default');
        }
        sendwebmail($customer_name, $customer_email,'my_case留言入口销售提醒邮件:'.date('Y-m-d h:i:s',time()), STORE_NAME, $title, $html_msg, 'default');

        $api_content = str_replace('NUMBER_SERVICE', $number, SOLUTION_SUPPORT_SUB_TIP_TITLE);
        $api_tip = str_replace('##CASE_HREF##','<a href="'.zen_href_link('my_cases_details','&new_old_data=1&case='.$number).'" style="color:#0070bc;">'.SOLUTION_SUPPORT_SUB_TIP_TXT_01.'</a>',SOLUTION_SUPPORT_SUB_TIP_TXT);
        $api->response(['info' => ['content' => $api_content, 'tip' => $api_tip,'href' => zen_href_link('my_cases'),'caseNumber' => $number]]);
        break;

    case 'del'://Remove Case
        if ($new_old_data == 1) {
            $caseService->updateServiceProcess(array('status' => 5), $case_num);
            $api->response(['href' => zen_href_link('my_cases', '&new_old_data=1', 'SSL')]);
        } else {
            $caseService->updateCase(array('is_del' => 1), $case_num, true);
            $api->response(['href' => zen_href_link('my_cases', '&new_old_data=2', 'SSL')]);
        }
        break;

    case 'updateStatus'://更新Case状态
        $status_str = is_mobile_request() ? '<em class="case_960_em">'.FS_STATUS.'</em>'.FS_SOLVED : FS_SOLVED;
        if ($new_old_data == 1) {
            $caseService->updateServiceProcess(array('status' => 4), $case_num);
            $api->response(['info' => FS_SOLVED_SUCCESS_TIP, 'status_str'=> $status_str]);
        } else {
            $caseService->updateCase(array('status' => 3, 'is_que' => 0), $case_num);
            $api->response(['info' => FS_SOLVED_SUCCESS_TIP, 'status_str'=> $status_str]);
        }
        break;

    //追问
    case 'customers_append':
        //验证
        $content = $question_content = zen_db_prepare_input($_POST['question_content']);
        $current_valide = get_current_valide( 'case', array(
            'question_content' => array(),
        ));
        require_once('includes/templates/fiberstore/common/fs_valide_common.php');
        if ($new_old_data == 1) {
            $arr = [
                'number' => $case_num,
                'content' => $content,
                'created_at' =>   getTime('Y-m-d H:i:s',time(),$_SESSION['countries_iso_code']),
                'is_append' => 1,
            ];
            $case_solution_id = $caseService->createServiceSolution($arr);
            if ($case_solution_id['id']) {
                //上传文件
                if ($_FILES["reviews_img"]['name'][0]) {
                    $randPath = dechex(rand(0, 15)) . dechex(rand(0, 15));  //随机路径
                    $folderName = "myCase/" . $randPath;
                    $uploadfiles = $caseService->uploadFiles($_FILES["reviews_img"],$folderName);
                    if ($uploadfiles['code'] == 0) {
                        $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
                    }
                    if ($uploadfiles['path']) {
                        foreach ($uploadfiles['path'] as $upload_k => $upload_v) {
                            $uploadfiles_data = array(
                                'solution_id' => $case_solution_id['id'],
                                'file_name' => $_FILES["reviews_img"]['name'][$upload_k],
                                'storage_name' => explode('/',$upload_v)[2],
                                'storage_path' => $randPath,
                            );
                            $caseService->createServiceSolutionFile($uploadfiles_data);

                        }
                    }
                }
            }
            $caseService->updateServiceProcess(array('is_que' => 0), $case_num);
            //发邮件暂不重构
            $solution_info = $caseService->getServiceProcessSolutionInfo($case_num);
            $solution_info = $solution_info[0];
            if ($solution_info['admin_id']) {
                if ($solution_info['answer_type'] == 2) {
                    $appellation = FS_MODIFY_EMAIL_MY_CASE_DETAILS_07;
                } else {
                    $appellation = FS_MODIFY_EMAIL_MY_CASE_DETAILS_06;
                }
                $admin_email = zen_admin_email_of_id($solution_info['admin_id']);
                $admin_name = zen_get_admin_name_of_id($solution_info['admin_id']);
                $customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
                $customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
                /* email content  helun 客户进行追问后发送邮箱给指定销售*/
                define('EMAIL_SUBJECT', FS_MODIFY_EMAIL_MY_CASE_09.$case_num);
                $html = zen_get_corresponding_languages_email_common();
                $html_msg['EMAIL_HEADER'] = $html['html_header'];
                $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                $append_html = '';
                if($solution_info['content'] && $solution_info['content'] != ''){
                    $append_html = '<tr>
                                <td style="padding:10px 0;border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <thead>
                                            <tr style="height: 0;">
                                                <td width="100%"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 13px;padding-bottom:5px;">'.$admin_name.$appellation.'</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;">'.$solution_info['content'].'</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;padding: 20px 0 5px;">'.$customer_name.':</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;font-weight: 600;">'.$content.'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>';
                }
                $html_msg['EMAIL_BODY'] = '<table style="line-height: 20px;">
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<thead>
													<tr style="height: 0;">
														<td width="100%"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 15px;font-weight: 600;padding-bottom: 30px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_01.' '.$customer_email.' '.FS_MODIFY_EMAIL_MY_CASE_DETAILS_02.' '.$case_num.'</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<thead>
													<tr style="height: 0;">
														<td width="100%"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 12px;padding-bottom: 15px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_03.'</td>
													</tr>
													<tr>
														<td style="font-size: 12px;padding-bottom: 10px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_04.' '.$customer_email.' '.FS_MODIFY_EMAIL_MY_CASE_DETAILS_05.'</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									'.$append_html.'
									<tr>
										<td style="padding-top: 28px;">'.FS_MODIFY_EMAIL_MY_CASE_06.'</td>
									</tr>
									<tr>
										<td style="padding-top: 25px;">'.FS_MODIFY_EMAIL_MY_CASE_07.'</td>
									</tr></table>';
                // EMAIL_FROM
                zen_mail($admin_name, $admin_email, EMAIL_SUBJECT,'', STORE_NAME,  EMAIL_FROM, $html_msg,'default');
            }
        } else {
            $customers_broker = $caseService->getBrokerInfo($case_num);
            $is_append = $customers_broker[0];
            $customers_broker_id = $is_append['broker_id'];
            $admin_name = $is_append['admin_name'];
            $answer_type = $is_append['answer_type'];
            $solution_content = $is_append['solution_content'];
            //上传文件
            $uploadfiles_str = $originNameStr = '';
            //上传文件
            if ($_FILES["reviews_img"]['name'][0]) {
                $uploadfiles = $caseService->uploadFiles($_FILES["reviews_img"]);
                if ($uploadfiles['code'] == 0) {
                    $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
                }
                foreach ($_FILES["reviews_img"]['name'] as $v){
                    if($v){
                        $originName[] = $v;
                    }
                }
                $uploadfiles_str = $uploadfiles['path'];
                $originNameStr = !empty($originName) ? implode(',', $originName) : "";
            }

            $arr = [
                'broker_id' => $customers_broker_id,
                'solution_content' => $content,
                'solution_time' => date("Y-m-d H:i:s"),
                'is_append' => 1,
                'customers_id' => $_SESSION['customer_id'],
                'file' => $uploadfiles_str,
                'file_name' => $originNameStr
            ];
            $caseService->createBrokerSolution($arr);
            $caseService->updateCase(array('status' => 0, 'is_que' => 0), $case_num);
            $caseService->updateBroker(array('is_new_sale' => 1, 'is_new_tech' => 1), $case_num);
            //发邮件暂不重构
            if($admin_name){
                if($answer_type == 0){
                    $appellation = FS_MODIFY_EMAIL_MY_CASE_DETAILS_06;
                }elseif($answer_type == 1){
                    $appellation = FS_MODIFY_EMAIL_MY_CASE_DETAILS_07;
                }
                $admin_email = zen_get_admin_email_of_name($admin_name);
                $customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
                $customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
                /* email content  helun 客户进行追问后发送邮箱给指定销售*/
                define('EMAIL_SUBJECT', FS_MODIFY_EMAIL_MY_CASE_09.$case_num);
                $html = zen_get_corresponding_languages_email_common();
                $html_msg['EMAIL_HEADER'] = $html['html_header'];
                $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                $append_html = '';
                if($solution_content && $solution_content != ''){
                    $append_html = '<tr>
                                <td style="padding:10px 0;border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <thead>
                                            <tr style="height: 0;">
                                                <td width="100%"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 13px;padding-bottom:5px;">'.$admin_name.$appellation.'</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;">'.$solution_content.'</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;padding: 20px 0 5px;">'.$customer_name.':</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px;font-weight: 600;">'.$content.'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>';
                }
                $html_msg['EMAIL_BODY'] = '<table style="line-height: 20px;">
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<thead>
													<tr style="height: 0;">
														<td width="100%"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 15px;font-weight: 600;padding-bottom: 30px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_01.' '.$customer_email.' '.FS_MODIFY_EMAIL_MY_CASE_DETAILS_02.' '.$case_num.'</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<thead>
													<tr style="height: 0;">
														<td width="100%"></td>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td style="font-size: 12px;padding-bottom: 15px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_03.'</td>
													</tr>
													<tr>
														<td style="font-size: 12px;padding-bottom: 10px;">'.FS_MODIFY_EMAIL_MY_CASE_DETAILS_04.' '.$customer_email.' '.FS_MODIFY_EMAIL_MY_CASE_DETAILS_05.'</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
									'.$append_html.'
									<tr>
										<td style="padding-top: 28px;">'.FS_MODIFY_EMAIL_MY_CASE_06.'</td>
									</tr>
									<tr>
										<td style="padding-top: 25px;">'.FS_MODIFY_EMAIL_MY_CASE_07.'</td>
									</tr></table>';
                // EMAIL_FROM
                zen_mail($admin_name, $admin_email, EMAIL_SUBJECT,'', STORE_NAME,  EMAIL_FROM, $html_msg,'default');
            }
        }
        $api->response(['info' => FS_CASE_SUBMIT_SUCCESS_TIP,'href' => zen_href_link('my_cases_details','&new_old_data='.$new_old_data.'&case='.$case_num)]);
        break;
}
