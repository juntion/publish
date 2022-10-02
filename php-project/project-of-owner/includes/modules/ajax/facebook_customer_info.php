<?php

if (!zen_not_null($_POST)){
	exit('0');
}

if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];
	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
					
					case 'get_customer_info':

						 $facebook_id = zen_db_prepare_input($_POST['cid']);
						 $email = zen_db_prepare_input($_POST ['email']); 
						 $firstname = zen_db_prepare_input($_POST['first_name']);
						 $lastname = zen_db_prepare_input($_POST['last_name']);
						 $gender = zen_db_prepare_input($_POST['gender']);
						 $birthday = zen_db_prepare_input($_POST['birthday']);
						 //$password = zen_db_prepare_input($_POST['pwd']);
						 $password = zen_create_random_value( (ENTRY_PASSWORD_MIN_LENGTH > 0 ? ENTRY_PASSWORD_MIN_LENGTH : 5) );
						 $locale = zen_db_prepare_input($_POST['locale']);
		
						$facebook_info = array(
                                'facebook_name' => $firstname,
						        'facebook_email' => $email,
						 		'facebook_gender' => $gender,
						        'facebook_birthday' => $birthday , 
                                'facebook_locale' =>$locale,
                                'customers_id' =>$_SESSION ['customer_id'],
                                'facebook_id' =>$facebook_id,
                        );
                        
                        zen_db_perform('customers_social_media_facebook_info', $facebook_info);
						 
					 $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_password from customers where customers_email_address = '".$email."'");
						 if ($result->RecordCount()){
						$_SESSION ['customer_id'] = $result->fields['customers_id'];
						require_once DIR_WS_CLASSES .'set_cookie.php';
		        	$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
						$_SESSION ['customer_first_name'] = $result->fields['customers_firstname'];
						
						$_SESSION['customers_email_address'] = $result->fields['customers_email_address'];
						 }else{
						 
						 $customer = array(
						        'customers_firstname' => $firstname,
						        'customers_lastname' => $lastname,
						 		'customers_email_address' => $email,
						        'customers_password' => zen_encrypt_password ( $password ), 
				 				'customers_dob' => 'now()',
				 				'email_is_active' => 1, //fairy 2017.11.2
				 				'social_media_id' => 1,
                                'language_id' => (int)$_SESSION['languages_id'],
                                'language_code'=>$_SESSION['languages_code'],
                                'from_where' => isMobile() ? 2 : 1,        // 客户来源
							    'customers_info_date_account_created' =>date('Y-m-d H:i:s')
				 			);
						  zen_db_perform(TABLE_CUSTOMERS, $customer);
						  
						 $customer_info = array(
						   'customers_info_id' => $db->Insert_ID() ,
						   'customers_info_date_of_last_logon' =>'now()' ,
						   'customers_info_number_of_logons'=> 1,
						   'customers_info_date_account_created'=>'now()',
						 );
						 zen_db_perform(TABLE_CUSTOMERS_INFO, $customer_info);
						  
                        $_SESSION ['customer_id'] = $db->Insert_ID();
//						if (SESSION_RECREATE == 'True') {
//							zen_session_recreate ();
//						}
						require_once DIR_WS_CLASSES .'set_cookie.php';
		        	$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);
						$_SESSION ['customer_first_name'] = $firstname;
						
						$_SESSION['customers_email_address'] = $email;
						
                        $facebook_info = array(
                                'facebook_name' => $firstname,
						        'facebook_email' => $email,
						 		'facebook_gender' => $gender,
						        'facebook_birthday' => $birthday , 
                                'facebook_locale' =>$locale,
                                'customers_id' =>$_SESSION ['customer_id'],
                                'facebook_id' =>$facebook_id,
                        );
                        
                        zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_FACEBOOK_INFO, $facebook_info);
						  
						$email_text .= EMAIL_WELCOME;
						$email_text .=' fiberstore ';
						$email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;
						$email_text .= "\n\n" . sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS ) . "\n\n";				   
				        $send_to_email = 'support@fiberstore.com';
				        $text_message = 'New message from contact us page of  FiberStore !';
						$send_to_name =  trim(STORE_NAME);
				        $auto_reply_subject = 'Congratulations, you have a new account on FiberStore.com';
				        $html_msg['EMAIL_BODY'] = '
				    		<tr><td>
					    		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
								<tbody>
						    		<tr>
									    <td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
									    <td style="border-right:1px solid #d2d2d2; padding:0 30px; font-size:11px;" colspan="2">
									    <b style=" display:block; padding-bottom:10px;"><br><br>Dear '.$firstname.' ,</b>
									    You have a new account on FiberStore<br><br>
									    Your password is: '.$password.'<br><br><br>
								<br><br><br>Thanks,<br>
								FiberStore.com<br><br><br><br>
								<span style=" color:#999999">PS. Please do not reply to this email. Emails sent to this address will not be answered.</span><br><br><br>
								</td>
								<td width="9" bgcolor="#f4f4f4" style="border-left:1px solid #e9e9e9;" rowspan="2"> </td>
									  </tr>
								 </tbody></table>
							</td></tr>
				    		
				    		';

                   //zen_mail_contact_us_or_bulk_order_inquiry($firstname, $email, $auto_reply_subject, $text_message, $send_to_name, $send_to_email, $html_msg,'contact_us_auto_reply');
        
						 } 
						exit('1');
						//}
					break;
							
		}
	}
}
?>