<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){

    $action = $_GET['ajax_request_action'];

    include (DIR_WS_CLASSES.'live_chat_service_email.php');
    $live_chat_service_email = new live_chat_service_email();

    if(!zen_not_null($action)){
        echo "err";
    }else{
        switch($_GET['ajax_request_action']){
            case 'storeHttpReferers':
                $_POST['phone_email'] = zen_db_prepare_input($_POST['phone_email']);
                $email_address = $_POST['phone_email'];
                if(get_user_blacklist($email_address)==true){
                    echo FS_ACCESS_DENIED_1;
                    exit;
                }
                // 2019-9-5 potato 限制表单提交次数
                $submit_number = checkoutSubmitNumber('live_chat_phone');
                if (!$submit_number) {
                    echo FS_SUBMIT_TOO_OFTEN;
                    exit;
                }

                $customers_country_id = $_POST['country_id'];
                $admin_id = 0;
                if($_SESSION['customer_id']){
                    $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);//判断是否为登录用户
                    $customers_country_id = $_SESSION['customer_country_id'];
                }

                // $is_old 在 auto_given.php文件中也有定义 标记客户是否是老客户 用于统计
                $is_go_auto_given = 0;
                if(!$admin_id){
                    $is_go_auto_given = 1;
                    $allot_type='live_chat';
                    require(DIR_WS_MODULES . zen_get_module_directory('message_entrance_auto_given.php'));
                    require (DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                }else{
                    $is_old = 1;
                }
                //生成case number
                $CaseNumber = createCaseNumber(1,3,$_POST['phone_email'],$admin_id,'',$_SESSION['customer_id'],$service_ids,$area,$is_old);
                $sql =" insert into live_chat_service (live_chat_service_name,live_chat_service_email,live_chat_service_country_id
				,live_chat_service_number,live_chat_phone_company_name,live_chat_phone_dial_back,language_id,is_old,is_show,live_chat_mail_service_datetime,case_number,service_admin,language_code,area,live_chat_mail_service_type)
					values ('".$_POST['name']."','".$_POST['phone_email']."','".$_POST['country_id']."','".$_POST['number']."','".$_POST['company']."','".$_POST['phone_dial_back']."','".$_SESSION['languages_id']."','".$is_old."',1,'".date('Y-m-d H:i:s')."','".$CaseNumber."','".$service_ids."','".$_SESSION['languages_code']."','".$area."','".$_POST['service_type']."') ";
                //die($sql);
                $db->query($sql);
                $cid = $db->insert_ID();


                // fairy 2018.8.30 add
                // 如果该项分配当前销售。则也要把该用户分配给当前销售等操作
                $nick = $_POST['name'];
                $nick_arr = explode('.',$nick);
                $firstname = $nick_arr[0];
                $lastname = $nick_arr[1];
                $source = 9;    // 客户来源：get a call
                if ($email_address) {
                    auto_given_customers_to_admin(array(
                        'admin_id' => $admin_id ? $admin_id : 0,
                        'email_address' => $email_address,
                        'admin_id_from_table' => $admin_id_from_table,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'nick' => $nick,
                        'country' => $customers_country_id,
                        'telephone' => $_POST['number'],
                        'company' => $_POST['company'],
                        'source' => $source,        // 客户来源：get a call
                        'is_old' => $is_old ? $is_old : 0,  // 标注新、老客户
                        'customer_number' => $customers_customers_number_new,
                        'customer_offline_number' => $offline_customers_number_new,
                        'invalidSign' => $invalidSign,
                    ));
                }

                $service_type = '';
                switch($_POST['service_type']){
                    case 1:
                        $service_type = 'Order & Payment Issue';
                        break;
                    case 2:
                        $service_type = 'Order Status';
                        break;
                    case 3:
                        $service_type = 'After Sales & RMA';
                        break;
                    case 4:
                        $service_type = 'Product & Technical Issue';
                        break;
                }
                /* emial content */
                $html_msg = array();  //the email content
                define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);

                $html=zen_get_corresponding_languages_email_common();
                $html_msg['EMAIL_HEADER'] = $html['html_header'];
                $html_msg['EMAIL_FOTTER'] = $html['html_footer'];
                $html_msg['EMAIL_BODY'] = '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
						  <tbody><tr>
				    		<td style="padding:0 30px; line-height:26px; font-size:11px;">
				    		<span style="line-height:22px; font-size:12px;"><br><br>Customer <b>'.$_POST['name'].'</b> live chat service submit information, please reply as soon as possible be verified. </span>
						    <br><br>
				    		<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">Customer Name :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. $_POST['name'] .'</span>
				    		</div>
				    		<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">E-mail address :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. $_POST['phone_email'] .'</span>
				    		</div>
				    		<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">Country :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. zen_get_country_name($_POST['country_id']) .'</span>
				    		</div>
							<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">Phone Number :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. $_POST['number'] .'</span>
				    		</div>
							<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">Service Type :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. $service_type .'</span>
				    		</div>
				    		<div style="clear:both;">
						    	<span style="width:30%; float:left; text-align:right;">Best Time to Dial Back :</span>
				    			<span style="width:68%; float:right; text-align:left;">'. $_POST['phone_dial_back'] .'</span>
				    		</div>
				    		<div style="clear:both;"><br></div>
						    </td>
							</tr>
							</tbody>
					</table>';
                $text_message = 'New message from live chat service page of Fiberstore !';
                if($admin_id){
                    $sql_data_array = array(
                        'admin_id' => $admin_id,
                        'customers_id' => $cid,
                        'add_time' => date('Y-m-d H:i:s')
                    );
                    zen_db_perform('live_chat_assign_for_phone', $sql_data_array);
                    $admin_name = zen_get_admin_name_of_id($admin_id);
                    $admin_email = zen_get_admin_email_of_name($admin_name);
                    if($admin_email){
                        sendwebmail($admin_name, $admin_email,'live_chat_phone留言发送销售邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME, EMAIL_SUBJECT, $html_msg,'contact_us');
                    }
                }else{
                    sendwebmail($service_name, $service_email,'live_chat_phone留言发客服售邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME, EMAIL_SUBJECT , $html_msg,'contact_us');
                }
                $html_customer = array();
                get_email_langpac();
                $html = common_email_header_and_footer(FS_SEND_EMAIL_3,FS_SEND_EMAIL_170);
                $html_customer['EMAIL_HEADER'] = $html['header'];
                $html_customer['EMAIL_FOOTER'] = $html['footer'];
                $html_customer['EMAIL_BODY']='<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.FS_MODIFY_EMAIL_MY_CASE_08.' '.ucwords($_POST['name']).FS_EMAIL_COMMA.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_170.'
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px 30px;" align="left">
                           '.RESET_PASS_SUCCESS_04.'
                        </td>
                    </tr>
                    </tbody>
                </table>';
                sendwebmail($_POST['name'], $_POST['phone_email'],'live_chat_phone留言发客戶售邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME, FS_SEND_EMAIL_171 , $html_customer,'default');
                exit('ok');
                break;

        }
    }
}