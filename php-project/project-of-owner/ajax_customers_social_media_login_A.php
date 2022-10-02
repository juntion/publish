<?php
	require 'includes/application_top.php';

if (isset($_GET['ajax_request_action'])){
	$action = $_GET['ajax_request_action'];
		switch($action){

			case 'google':
				if($_POST['email'] != null){

				 $google_plus_id = zen_db_prepare_input($_POST['gid']);
				 $first_name = zen_db_prepare_input($_POST['fName']);
				 $last_name = zen_db_prepare_input($_POST['gName']);
				 $name = $first_name." ".$last_name;
				 $email = zen_db_prepare_input( $_POST ['email'] );
				 $gender = zen_db_prepare_input($_POST['gender']);
				 $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_password from customers where customers_email_address = '".$email."'");
				 if ($result->RecordCount()){
					$_SESSION ['customer_id'] = $result->fields['customers_id'];
					$_SESSION ['customer_first_name'] = $result->fields['customers_firstname'];
					$_SESSION['customers_email_address'] = $result->fields['customers_email_address'];

					                    //set cookie for customer_id ******************************
					require_once DIR_WS_CLASSES .'set_cookie.php';
					$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);

				 }else{
                     $now_time = date('Y-m-d H:i:s');
                     $customer = array(
                         'customers_firstname' => $first_name,
                         'customers_lastname' => $last_name,
                         'customers_email_address' => $email,
                         'customers_dob' => $now_time,
                         'language_id' => (int)$_SESSION['languages_id'],
                         'language_code'=>$_SESSION['languages_code'],
                         'from_where' => isMobile() ? 2 : 1,        // 客户来源
                         'social_media_id' => 4
                     );

                     //分配判断代码应置于插入数据之前,自动分配文件中叫$email_address而不是$email
                     $email_address = $email;
                     require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                     $customer['is_make_up'] = $is_make_up ? : 0;
                     $customer ['is_old'] = $is_old ? $is_old : 0;  // 标记新、老客户
                     $customer ['source'] = 27;  // 客户来源：谷歌登录
                     if($admin_id){
                         //邮箱匹配到了 标记老客户 用于统计
                         $customer['is_old'] = $is_old;
                     }

				  zen_db_perform(TABLE_CUSTOMERS, $customer);
				  $_SESSION ['customer_id'] = $db->Insert_ID();
				    $customer_info = array(
						   'customers_info_id' => $db->Insert_ID() ,
						   'customers_info_date_of_last_logon' =>$now_time ,
						   'customers_info_number_of_logons'=> 1,
						   'customers_info_date_account_created'=>$now_time,
						 );
					zen_db_perform(TABLE_CUSTOMERS_INFO, $customer_info);

                  	$cid = $_SESSION ['customer_id'];

		if($admin_id){
		    $customers_id=$cid;
            $date = get_common_cn_time();
		    $sql='INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("'.$admin_id.'","'.$customers_id.'","'.$date.'","'.time().'")';
		    $db->Execute($sql);
		    $sales_email = zen_admin_email_of_id($admin_id);
			$html=zen_get_corresponding_languages_email_common();
			$html_msg['EMAIL_HEADER'] = $html['html_header'];
			$html_msg['EMAIL_FOTTER'] = $html['html_footer'];
		    $html_msg['EMAIL_BODY'] = '
	     <tr>
		    <td><table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
		  <tbody><tr>
		    <td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
		    <td style="border-right:1px solid #d2d2d2; padding:0 30px; line-height:26px; font-size:11px;" colspan="2">
		    <span style="color:#616265; line-height:18px;"><br>This message comes from the <b>fiberstore administrator</b>, please review!</span>
		            <br>
	            <span style="  font-size:12px; font-weight:bold; display:block; padding-bottom:10px;">Customer Information</span>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Customer Name:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($firstname.$lastname ? $firstname.$lastname : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Phone Number:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($telephone ? $telephone : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">E-mail address:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($email_address ? $email_address : 'not set yet').'</span>
	            </div>


		            <div style="clear:both;"><br></div>
		</td>

		  </tr>
		  </tbody></table>
		</td>
		</tr>';
		    zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', 'service@fiberstore.net', $html_msg, 'contact_us');

		}

		//end
                    //set cookie for customer_id ******************************
					require_once DIR_WS_CLASSES .'set_cookie.php';
					$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);


                      $_SESSION ['customer_first_name'] = $first_name;
				  $_SESSION['customers_email_address'] = $email;

                        $google_plus_info = array(
                            'google_plus_id' => $google_plus_id,
				        'google_plus_email' => $email,
                        'google_plus_name' => $name,
				 		'google_plus_gender' => $gender,
                            'customers_id' => $_SESSION['customer_id'],
                        );
                        zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info);
				 }
				  exit('ok');
				  header('Location: http://www.fiberstore.com');
			}
			break;

			case 'paypal':
			if($_POST['email'] != null){
				 $first_name = zen_db_prepare_input($_POST['fName']);
				 $last_name = zen_db_prepare_input($_POST['gName']);
				 $name = $first_name." ".$last_name;
				 $email = zen_db_prepare_input( $_POST ['email'] );
				 $zoneinfo = zen_db_prepare_input($_POST['zoneinfo']);
				 $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_password from customers where customers_email_address = '".$email."'");
				 if ($result->RecordCount()){
					$_SESSION ['customer_id'] = $result->fields['customers_id'];
					$_SESSION ['customer_first_name'] = $result->fields['customers_firstname'];
					$_SESSION['customers_email_address'] = $result->fields['customers_email_address'];

					                    //set cookie for customer_id ******************************
					require_once DIR_WS_CLASSES .'set_cookie.php';
					$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);


				 }else{
                     //分配判断代码应置于插入数据之前,自动分配文件中叫$email_address而不是$email
                     $email_address = $email;
                     require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                     $now_time = date('Y-m-d H:i:s');

				 $customer = array(
			        'customers_firstname' => $first_name,
			 		'customers_lastname' => $last_name,
			 		'customers_email_address' => $email,
	 				'customers_dob' => $now_time,
                     'language_id' => (int)$_SESSION['languages_id'],
                     'language_code'=>$_SESSION['languages_code'],
	 				'social_media_id' => 5,
                     'from_where' => isMobile() ? 2 : 1,        // 客户来源
                     'is_make_up' => $is_make_up ? : 0,
                     'is_old' => $is_old ? $is_old : 0,    // 标记新、老客户
                     'source' => 29,           // 客户来源：paypal登录
		 			);

                     if($admin_id){
                         //邮箱匹配到了 标记老客户 用于统计
                         $customer['is_old'] = $is_old;
                     }
				  zen_db_perform(TABLE_CUSTOMERS, $customer);
				  $_SESSION ['customer_id'] = $db->Insert_ID();

				    $customer_info = array(
						   'customers_info_id' => $db->Insert_ID() ,
						   'customers_info_date_of_last_logon' =>$now_time ,
						   'customers_info_number_of_logons'=> 1,
						   'customers_info_date_account_created'=>$now_time,
						 );
					zen_db_perform(TABLE_CUSTOMERS_INFO, $customer_info);

					$cid = $_SESSION ['customer_id'];

		if($admin_id){
		    $customers_id=$cid;
            $date = get_common_cn_time();
		    $sql='INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("'.$admin_id.'","'.$customers_id.'","'.$date.'","'.time().'")';
		    $db->Execute($sql);
		    $sales_email = zen_admin_email_of_id($admin_id);
			$html=zen_get_corresponding_languages_email_common();
			$html_msg['EMAIL_HEADER'] = $html['html_header'];
			$html_msg['EMAIL_FOTTER'] = $html['html_footer'];
		    $html_msg['EMAIL_BODY'] = '
	     <tr>
		    <td><table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
		  <tbody><tr>
		    <td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
		    <td style="border-right:1px solid #d2d2d2; padding:0 30px; line-height:26px; font-size:11px;" colspan="2">
		    <span style="color:#616265; line-height:18px;"><br>This message comes from the <b>fiberstore administrator</b>, please review!</span>
		            <br>
	            <span style="  font-size:12px; font-weight:bold; display:block; padding-bottom:10px;">Customer Information</span>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Customer Name:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($firstname.$lastname ? $firstname.$lastname : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Phone Number:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($telephone ? $telephone : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">E-mail address:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($email_address ? $email_address : 'not set yet').'</span>
	            </div>


		            <div style="clear:both;"><br></div>
		</td>

		  </tr>
		  </tbody></table>
		</td>
		</tr>';
		    zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', 'service@fiberstore.net', $html_msg, 'contact_us');

		}

		//end
                    //set cookie for customer_id ******************************
					require_once DIR_WS_CLASSES .'set_cookie.php';
					$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);


                    $_SESSION ['customer_first_name'] = $first_name;
					$_SESSION['customers_email_address'] = $email;

                        $paypal_info = array(
				        'paypal_email' => $email,
                        'paypal_family_name' => $fName,
                        'paypal_given_name' => $gName,
				 		'paypal_zoneinfo' => $zoneinfo,
                            'customers_id' => $_SESSION['customer_id'],
                        );
                        zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_PAYPAL_INFO, $paypal_info);
				 }
				 exit('ok');
				 header('Location: http://www.fiberstore.com');
			}
			break;

            case 'facebook':

                if($_POST['email'] != null || 1==1){
                    //todo:获取用户数据
                    $name = zen_db_prepare_input($_POST['name']);
                    $id = zen_db_prepare_input($_POST['id']);
                    $email = zen_db_prepare_input( $_POST ['email'] );
                    //把用戶名拆成名和姓
                    $name_spr = explode(" ",$name);
                    $first_name = $name_spr[0];
                    $last_name = $name_spr[1];

                    //todo:根据邮箱匹配用户
                    $result = $db->Execute("select customers_id,customers_email_address,customers_firstname,customers_password from customers where customers_email_address = '".$email."'");
                    //如果非空
                    if ($result->RecordCount()){
                        //设置session
                        $_SESSION ['customer_id'] = $result->fields['customers_id'];
                        $_SESSION ['customer_first_name'] = $result->fields['customers_firstname'];
                        $_SESSION['customers_email_address'] = $result->fields['customers_email_address'];

                        //设置cookie
                        require_once DIR_WS_CLASSES .'set_cookie.php';
                        $Encryption = new Encryption;
                        $cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
                        setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);

                    //如果为空
                    }else{
                        //分配判断代码应置于插入数据之前,自动分配文件中叫$email_address而不是$email
                        $email_address = $email;
                        require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                        $now_time = date('Y-m-d H:i:s');
                        //用户数据
                        $customer = array(
                            'customers_firstname' => $first_name,
                            'customers_lastname' => $last_name,
                            'customers_email_address' => $email,
                            'customers_dob' => $now_time,
                            'language_id' => (int)$_SESSION['languages_id'],
                            'language_code'=>$_SESSION['languages_code'],
                            'social_media_id' => 1 ,//Facebook
                            'from_where' => isMobile() ? 2 : 1,        // 客户来源
                            'is_make_up' => $is_make_up ? : 0,
                            'source'  => 31 // 客户来源 ：facebook登录
                        );

                        if($admin_id){
                            //邮箱匹配到了 标记老客户 用于统计
                            $customer['is_old'] = $is_old;
                        }else{
                            echo 'is_old'.$is_old;exit;
                        }
                        zen_db_perform(TABLE_CUSTOMERS, $customer);
                        $_SESSION ['customer_id'] = $db->Insert_ID();

                        $customer_info = array(
                            'customers_info_id' => $db->Insert_ID() ,
                            'customers_info_date_of_last_logon' =>$now_time ,
                            'customers_info_number_of_logons'=> 1,
                            'customers_info_date_account_created'=>$now_time,
                        );
                        zen_db_perform(TABLE_CUSTOMERS_INFO, $customer_info);

                        $cid = $_SESSION ['customer_id'];

                        if($admin_id){
                            $customers_id=$cid;
                            $date = get_common_cn_time();
                            $sql='INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("'.$admin_id.'","'.$customers_id.'","'.$date.'","'.time().'")';
                            $db->Execute($sql);
                            $sales_email = zen_admin_email_of_id($admin_id);
							$html=zen_get_corresponding_languages_email_common();
							$html_msg['EMAIL_HEADER'] = $html['html_header'];
							$html_msg['EMAIL_FOTTER'] = $html['html_footer'];
                            $html_msg['EMAIL_BODY'] = '
	     <tr>
		    <td><table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:18px; border:0;">
		  <tbody><tr>
		    <td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>
		    <td style="border-right:1px solid #d2d2d2; padding:0 30px; line-height:26px; font-size:11px;" colspan="2">
		    <span style="color:#616265; line-height:18px;"><br>This message comes from the <b>fiberstore administrator</b>, please review!</span>
		            <br>
	            <span style="  font-size:12px; font-weight:bold; display:block; padding-bottom:10px;">Customer Information</span>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Customer Name:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($firstname.$lastname ? $firstname.$lastname : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">Phone Number:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($telephone ? $telephone : 'not set yet').'</span>
	            </div>
	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">E-mail address:</span>
	              <span style="width:68%; float:right; text-align:left;">'.($email_address ? $email_address : 'not set yet').'</span>
	            </div>


		            <div style="clear:both;"><br></div>
		</td>

		  </tr>
		  </tbody></table>
		</td>
		</tr>';
                            zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', 'service@fiberstore.net', $html_msg, 'contact_us');

                        }

                        //end
                        //set cookie for customer_id ******************************
                        require_once DIR_WS_CLASSES .'set_cookie.php';
                        $Encryption = new Encryption;
                        $cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
                        setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*365 ,"/","",COOKIE_SECURE,COOKIE_HTTPONLY);


                        $_SESSION ['customer_first_name'] = $first_name;
                        $_SESSION['customers_email_address'] = $email;

                        $paypal_info = array(
                            'paypal_email' => $email,
                            'paypal_family_name' => $fName,
                            'paypal_given_name' => $gName,
                            'paypal_zoneinfo' => $zoneinfo,
                            'customers_id' => $_SESSION['customer_id'],
                        );
                        zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_PAYPAL_INFO, $paypal_info);
                    }
                    exit('ok');
                    header('Location: http://www.fiberstore.com');
                }
                break;

		}
}
?>