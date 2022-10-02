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
                if ((!isset($_SESSION['securityToken']) || !isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])) {
                    exit(json_encode(array('status' => 0, 'data' => FS_SECURITY_ERROR, 'info' => '')));
                }
                $origin_url = $_SERVER['HTTP_REFERER'];
                $parse_url = parse_url($origin_url);
                $host = $parse_url['host'];
                if(!in_array($host,array("www.fs.com","test.whgxwl.com","tx.fs.com","aron.test.com","local.fs.quest","local.fs.com","fsbox.com"))){
                    echo json_encode(array("status"=>"error","data"=>FS_SYSTME_BUSY));
                    exit;
                }
				$_POST['email'] = zen_db_prepare_input($_POST['email']);
				$email_address = $_POST['email'] ;
				if(get_user_blacklist($email_address)==true){
                    echo json_encode(array("status"=>"error","data"=>FS_ACCESS_DENIED_1));
					exit;
				}
				//含有特殊符号insert不了数据库
				$_POST['question'] = zen_db_input($_POST['question']);
				$_POST['message_subject'] = zen_db_input($_POST['message_subject']);


				if($_POST['country_id']){
					$customers_country_id = $_POST['country_id'];
				}

				$admin_id = 0;
				//judge has allot
				if($_SESSION['customer_id']){
					$admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
					$customers_country_id = $_SESSION['customer_country_id'];
				}

				// $is_old 在 auto_given.php文件也有定义 标记客户是否是老客户 用于统计
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
				$CaseNumber = createCaseNumber(1,3,$_POST['email'],$admin_id,$_POST['question'],$_SESSION['customer_id'],$service_ids,$area,$is_old);

				//var_dump($admin_id);exit;

				$sql =" insert into live_chat_service (live_chat_service_name,live_chat_service_email,live_chat_service_country_id,
				live_chat_service_number,live_chat_mail_service_question,live_chat_mail_service_type,language_id,
				is_old,is_show,live_chat_mail_service_datetime,case_number,service_admin,language_code,area)
				values ('".$_POST['name']."','".$_POST['email']."','".$_POST['country_id']."','".$_POST['number']."','".$_POST['question']."'
						,'".$_POST['service_type']."','".$_SESSION['languages_id']."','".$is_old."',1,'".date('Y-m-d H:i:s')."','".$CaseNumber."','".$service_ids."','".$_SESSION['languages_code']."','".$area."') ";

				$db->query($sql);
				$cid = $db->insert_ID();


                // fairy 2018.8.30 add
                // 如果该项分配当前销售。则也要把该用户分配给当前销售等操作
                $nick = $_POST['name'];
                $nick_arr = explode('.',$nick);
                $firstname = $nick_arr[0];
                $lastname = $nick_arr[1];
                $source = 7;  // 客户来源：email
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
                        'source' => $source,       // 客户来源：email
                        'is_old' => $is_old ? $is_old : 0,    // 标记新、老客户
                        'customer_number' => $customers_customers_number_new,
                        'customer_offline_number' => $offline_customers_number_new,
                        'invalidSign' => $invalidSign,
                    ));
                }

                $send_time = date("Y/m/d");
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
					case 5:
						$service_type = 'Orders';
						break;
				}

                $html_msg = array();  //the email content
                $html_msg_customer =array();
                get_email_langpac();
                $title_info= FS_SEND_EMAIL_3;
                if($_SESSION['languages_code']=="jp") {
                    $title_info="メールメッセージ受領済み";
                }
                $html=common_email_header_and_footer($title_info,FS_SEND_EMAIL_148);
                if($_SESSION['customers_id']){
                    $customerImageSrc = $db->getAll("select customer_photo from customers where customers_id=".(int)$_SESSION['customer_id']);
                    $img = $customerImageSrc[0]['customer_photo'];
                    $img_src =  HTTPS_IMAGE_SERVER.DIR_WS_IMAGES. (($img) ? $img : 'portrait_pic01.jpg');
                }else{
                    $customerImageSrc = $db->getAll("select customer_photo from customers where customers_email_address='".$_POST['email']."'");
                    $img = $customerImageSrc[0]['customer_photo'];
                    $img_src =  HTTPS_IMAGE_SERVER.DIR_WS_IMAGES. (($img) ? $img : 'portrait_pic01.jpg');
                }
                $pick_time = date('d.m.y',time());
                if(in_array($_SESSION['languages_code'],array('de','dn'))){
                    $pick_time = date('d.m.y',time());
                }elseif($_SESSION['languages_code']=="jp"){
                    $pick_time = date('Y/m/d',time());
                }
				$html_msg_customer['EMAIL_HEADER'] = $html['header'];
				$html_msg_customer['EMAIL_FOOTER'] = $html['footer'];
                $html_msg_customer['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            '.FS_MODIFY_EMAIL_MY_CASE_08.' '.ucwords($_POST['name']).''.FS_EMAIL_COMMA.'
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
                    <tr>';
                if($_SESSION['languages_code']=="jp") {
                    $html_msg_customer['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_150.'<a style="color: #0070BC;text-decoration: none" href="javascript:;" >'.$CaseNumber.'</a>です。
                        </td>';
                }else{
                    $html_msg_customer['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_150.'<a style="color: #0070BC;text-decoration: none" href="javascript:;" >'.$CaseNumber.'</a>.
                        </td>';
                }
               $html_msg_customer['EMAIL_BODY'].='</tr>
               </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td width="50" bgcolor="#ffffff" valign="top" style="border-collapse: collapse;padding-right: 20px;">
                                        <img width="100%" style="display: block;" src="'.$img_src.'" alt="'.$img_src.'">
                                    </td>
                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                        <span style="font-weight: 600">'.$_POST['name'].'</span> '.$pick_time.'
                                        <br>
                                        <span style="display: inline-block;margin-top: 15px">
                                        '.$_POST['question'].'  
                                        </span>
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
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>';

                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
                $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
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
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            '.FS_MODIFY_EMAIL_MY_CASE_08.' '.ucwords($_POST['name']).''.FS_EMAIL_COMMA.'
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
                            '.FS_SEND_EMAIL_150.'<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link('my_cases_details','case='.$CaseNumber).'" >'.$CaseNumber.'</a>.
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td width="50" bgcolor="#ffffff" valign="top" style="border-collapse: collapse;padding-right: 20px;">
                                        <img width="100%" style="display: block;" src="'.$img_src.'" alt="'.$img_src.'">
                                    </td>
                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                        <span style="font-weight: 600">'.$_POST['name'].'</span> '.$pick_time.'
                                        <br>
                                        <span style="display: inline-block;margin-top: 15px">
                                        '.$_POST['question'].'  
                                        </span>
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
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>';

				// EMAIL_FROM
                //var_dump($html_msg_customer);die;
				sendwebmail($_POST['name'], $email_address,'live_chat留言发送客户邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,FS_SEND_EMAIL_149,$html_msg_customer,'default');
					/* emial content */
				if($admin_id){
					$sql_data_array = array(
						'admin_id' => $admin_id,
						'customers_id' => $cid,
						'add_time' => date('Y-m-d H:i:s')
					);
					zen_db_perform('live_chat_assign_for_phone', $sql_data_array);
					$admin_name = zen_get_admin_name_of_id($admin_id);
					$admin_email = zen_get_admin_email_of_name($admin_name);
//		           $text_message = 'New message from live chat service page of Fiberstore !';
					if($admin_email){
						sendwebmail($admin_name,$admin_email,'live_chat留言发送销售邮件:'.date('Y-m-d H:i:s', time()),STORE_NAME,FS_SEND_EMAIL_149.' '.$CaseNumber,$html_msg,'default');
					}
				}else{ //发送给客服
                    sendwebmail($service_name,$service_email,'live_chat发给客服:'.date('Y-m-d H:i:s', time()),STORE_NAME,FS_SEND_EMAIL_149.' '.$CaseNumber,$html_msg,'default');
				}

                echo json_encode(array("status"=>"ok","data"=>''));
                exit;
				break;
		}
	}
}