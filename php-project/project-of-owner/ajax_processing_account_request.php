<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	//if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){
			case 'fs_ajax_login':

  		        login_delCache(DIR_FS_CATALOG.'cache/products',1);

			 	$email_address = $_POST['email_address'];
                $email_address = zen_db_prepare_input($email_address);
			 	$password =  zen_db_prepare_input($_POST['password']);
				//RSA解密
				$password = zen_get_rsa_decrypt_password($password);
			 	$result = $db->Execute("select customers_id, customers_firstname, customers_lastname,customers_password as password,customers_default_address_id from customers where customers_email_address regexp'".$email_address."'");
			 	if ($result->RecordCount() && zen_validate_password($password,$result->fields['password']) && $result->fields['customers_id'] != 17377) {
			 	    $_SESSION['customer_id'] = $result->fields['customers_id'];

			 	    require_once DIR_WS_CLASSES .'set_cookie.php';
		        	$Encryption = new Encryption;
		        	$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
		        	setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/");

			 		$_SESSION['customer_first_name'] = $result->fields['customers_firstname'];
			 		$_SESSION['customers_email_address'] = $result->fields['customers_email_address'];
			 		$_SESSION['customer_default_address_id'] = $result->fields['customers_default_address_id'];
			 		exit('success');
			 	}else if ($result->RecordCount()){
			 		exit('error');
			 	}else {
			 		exit('noAccount') ;
			 	}
				break;
			case 'fs_ajax_regist':

				$email_address = $_POST['email_address_regist'];
                $email_address = zen_db_prepare_input($email_address);

				$passwords =  zen_db_prepare_input($_POST['password_regist']);
				$password = zen_encrypt_password($passwords);


				//$telephone = zen_db_prepare_input ( $_POST ['phone_number'] );
				$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$user_ip_address = $_SERVER['REMOTE_ADDR'];
				$regist_from = zen_db_prepare_input($_POST['regist_from']);

				$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
				$newsletter = (ACCOUNT_NEWSLETTER_STATUS == '1' || ACCOUNT_NEWSLETTER_STATUS == '0' ? false : true);
				$telephone = "";
				$nick = "";
				$fax = '';
				//add others fields in table costomers


			    if($_POST ['country']){
				$customer_country_id =zen_db_prepare_input ( $_POST ['country'] );
				}else{
				$customer_country_id = 223;

				}

				$customers_country_id = $customer_country_id;

				$customerDiscoveryTypeId = zen_db_prepare_input($_POST['customerDiscoveryTypeId']);
				$customer_newsletter = $_POST['customer_other'];


				//list($firstname, $lastname) = split ('[/. ]', $user_name);


				$firstname = zen_db_prepare_input  (trim($_POST ['customer_name'])) ;
				$lastname = zen_db_prepare_input  (trim($_POST ['last_name'])) ;

			    $customer_name = $firstname." ".$lastname;

/*
				if (strpos($customer_name, ' ')) {
					$lastname = substr($customer_name, strrpos($customer_name,' ')+1);
					$firstname =  substr($customer_name, 0,-strlen($lastname));
				}else{
					$firstname = $customer_name;
					$lastname = '';
				}
				*/

				//set customer name into session
				$_SESSION['name'] = $customer_name;




				$check_email_query = "select count(*) as total
				from " . TABLE_CUSTOMERS . "
				where customers_email_address = '" . zen_db_input ( $email_address ) . "'";
				$check_email = $db->Execute ( $check_email_query );
				if ($check_email->fields ['total'] > 0) {
					exit('error');
				}


            $customer_newsletter = 1;
            $customers_dob = date('Y-m-d H:i:s');
			$regist_sql = array(
						'customers_firstname' => $firstname,
						'customers_lastname' => $lastname,
						'customers_email_address' => $email_address,
						'customers_nick' => $nick,
						'customers_telephone' => $telephone,
						'customers_fax' => $fax,
						//'customers_newsletter' => ( int ) $newsletter,
						'customers_email_format' => $email_format,
						'customers_default_address_id' => 0,
						'customers_password' =>  $password ,
						'language_id' =>  (int)$_SESSION['languages_id'] ,
                        'language_code'=>$_SESSION['languages_code'], // fairy 2019.2.22 add
						'customers_newsletter' => $customer_newsletter ,
						'customers_company' => zen_db_prepare_input($customerDiscoveryTypeId),
						'customer_country_id' => $customer_country_id,
						'customers_dob' => $customers_dob ,
						'customers_authorization' => ( int ) CUSTOMERS_APPROVAL_AUTHORIZATION,
						'http_user_agent' => $http_user_agent,
						'user_ip_address' => $user_ip_address,
						'customers_regist_from' => $regist_from,
                        'from_where' => isMobile() ? 2 : 1,        // 客户来源
                        'customers_info_date_account_created' => date("Y-m-d H:i:s"),
				);
                //分配判断代码应置于插入数据之前,$email_address上面已经定义
                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                $regist_sql['is_make_up'] = $is_make_up ? : 0;
                $regist_sql ['is_old'] = $is_old ? $is_old : 0;  // 标记新、老客户
                if($admin_id){
                    //邮箱匹配到了 标记老客户 用于统计
                    $regist_sql['is_old'] = $is_old;
                }

				zen_db_perform(TABLE_CUSTOMERS,$regist_sql);
				$_SESSION['customer_id'] = $db->Insert_ID();
		        $cid = $db->insert_ID();

				if($admin_id){
					$customers_id=$cid;
                    $date = get_common_cn_time();
					$sql='INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("'.$admin_id.'","'.$customers_id.'","'.$date.'","'.time().'")';
					$db->Execute($sql);
					 $sales_email = zen_admin_email_of_id($admin_id);

                    $html=zen_get_corresponding_languages_email_common();
                    $html_msg['EMAIL_HEADER'] = $html['html_header'];
                    $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                    $html_msg['CUSTOMER_NAME'] = $firstname.$lastname ? $firstname.$lastname : 'not set yet';
                    $html_msg['NUMBER'] = $telephone ? $telephone : 'not set yet';
                    $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                    zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', EMAIL_FROM, $html_msg, 'regist_to_us');

					}

		//end
					require_once DIR_WS_CLASSES .'set_cookie.php';
						$Encryption = new Encryption;
						$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
						setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/");

					$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
							  (customers_info_id, customers_info_number_of_logons,
							   customers_info_date_account_created, customers_info_date_of_last_logon)
				  values ('" . ( int ) $_SESSION ['customer_id'] . "', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";

					$db->Execute ($sql);


				if(isset($_GET['type'])){
					if($_GET['type'] == 'link'){

						$sql_data_array = array(
							'customers_id' => $_SESSION['customer_id'],
							'customers_name' => zen_get_customers_firstname($_SESSION['customer_id']) . ' ' . zen_get_customers_lastname($_SESSION['customer_id']),
							'customers_email_address' =>zen_get_customer_name_email($_SESSION['customer_id'])
						);
						$orders_id = $_GET['orders_id'];
						$result = $db->getAll("select create_orders_id from create_order_to_customer where customers_email = '$email_address' and  orders_id = '$orders_id'");
						if($result){
							if($orders_id){
								zen_db_perform(TABLE_ORDERS, $sql_data_array,'update','orders_id='.$orders_id);
							}
						}
					}
				}



					echo 'success';exit;


				break;

            case 'fs_review_like_or_not':
                $type = (int)$_POST['type'];
                $rID = (int)$_POST['rID'];
                $ip = newGetIp();
                $product_id = (int)$_POST['product_id'];
                $count = 1;
                require ('fs_ajax/functions_fs_reviews.php');
                if(!empty($ip)){
                    $ip_sql = "select id,ip from reviews_geust_ip where source_type=0 and comments_id=".$rID." and ip='".$ip."' and type!=".$type." and add_time=curdate() and language_id=".(int)$_SESSION['languages_id'];
                    $result = $db->Execute($ip_sql);
                    if(!$result->EOF){
                        return false;
                    }else{
                        $ip_query = "select id,ip from reviews_geust_ip where source_type=0 and comments_id=".$rID." and ip='".$ip."' and type=".$type." and add_time=curdate() and language_id=".(int)$_SESSION['languages_id'];
                        $res = $db->Execute($ip_query);
                        if(!$res->EOF){
                            echo '{"rID":"","num":"","type":"0"}';
                        }else{

                            $ip_array=array('comments_id'=>$rID,'ip'=>$ip,'type'=>$type,'source_type'=>0,'add_time'=>'now()','language_id'=>(int)$_SESSION['languages_id']);
                            zen_db_perform('reviews_geust_ip',$ip_array);

                            define('PRODUCT_REVIEWS_DETAIL_DATA_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_reviewsData_product_info_'.$product_id);
                            $reviewsKeys = md5($_SESSION['languages_code'].'_reviewsData_'.$product_id,true);
                            $reviewsRedisData = get_redis_key_value($reviewsKeys, PRODUCT_REVIEWS_DETAIL_DATA_REDIS_KEY_PREFIX);
                            if($reviewsRedisData){
                                $reviewsRedisData['reviews']['reviewsData'][$rID]['r_like'] += 1;
                                set_redis_key_value($reviewsKeys,$reviewsRedisData,7*24*3600,PRODUCT_REVIEWS_DETAIL_DATA_REDIS_KEY_PREFIX);
                            }

                            if (is_exist_reviews_valuation($rID)){
                                if (1 == $type || 2 == $type) {
                                    $fs_update_column_sql = ' r_like = r_like+1 ';
                                }else if (0 == $type){
                                    $fs_update_column_sql = ' r_bad = r_bad+1 ';
                                }
                                $fs_query = "update reviews_like_or_not set " . $fs_update_column_sql. " where reviews_id = ".(int)$rID;
                                $db->Execute($fs_query);
                                $count = get_reviews_count($rID,$type);
//                                $mobile = isMobile() ? "mb":"pc";
//                                $filename = "cache/products/product_reviews_".$mobile."_" . $_SESSION['language'] . $product_id . ".html";
//                                if(file_exists($filename)){
//                                    unlink($filename);
//                                }
//                                $rev = get_redis_key_value('en_reviews_'.$product_id,'en_reviews_'.$product_id);
//                                var_dump($rev);

                                echo '{"rID":"'.$rID.'","num":"'.$count.'","type":"1"}';
                            }else {
                                $arr1 = array('reviews_id' => $rID);
                                if (1 == $type || 2 == $type) {
                                    $arr2 = array('r_like'=> 1,'r_bad'=> 0);
                                }else if (0 == $type){
                                    $arr2 = array('r_like'=> 0,'r_bad'=> 1);
                                }
                                zen_db_perform('reviews_like_or_not',array_merge($arr1,$arr2));
//                                $mobile = isMobile() ? "mb":"pc";
//                                $filename = "cache/products/product_reviews_".$mobile."_" . $_SESSION['language'] . $_GET['products_id'] . ".html";
//                                if(file_exists($filename)){
//                                    unlink($filename);
//                                }
                                echo '{"rID":"'.$rID.'","num":"'.$count.'","type":"1"}';
                            }
                        }
                    }
                }
                break;


            case 'fs_comments_like_or_not':
				$type = $_POST['type'];
				$cID = $_POST['cID'];
				$ip = $_SERVER['REMOTE_ADDR']; 
				$count = 1;
				require ('fs_ajax/functions_fs_reviews.php');
				if(!empty($ip)){
					$ip_sql = "select id from reviews_geust_ip where source_type=1 and comments_id=".$cID." and ip='".$ip."' and type!=".$type." and add_time=curdate() and language_id=".(int)$_SESSION['languages_id'];
					
					$result = $db->Execute($ip_sql);
					if(!$result->EOF){
						return false;
					}else{
						$ip_query = "select id from reviews_geust_ip where source_type=1 and comments_id=".$cID." and ip='".$ip."' and type=".$type." and add_time=curdate() and language_id=".(int)$_SESSION['languages_id'];
						$res = $db->Execute($ip_query);
						if(!$res->EOF){
							if (is_exist_comments_valuation($cID)){
								$like_bad = $db->Execute("select r_like,r_bad from reviews_comments_like_or_not where comments_id=".$cID);
								$r_like = $like_bad ->fields['r_like'];
								$r_bad = $like_bad ->fields['r_bad'];
								if (1 == $type){
									if($r_like>0){
										$fs_update_column_sql = ' r_like = r_like-1 ';
										
									}else{
										$fs_update_column_sql = ' r_like = 0 ';
									}
								}else if (0 == $type){
									if($r_bad>0){
										$fs_update_column_sql = ' r_bad = r_bad-1 ';
									}else{
										$fs_update_column_sql = ' r_bad = 0 ';
									}
								}
								$fs_query = "update reviews_comments_like_or_not set " . $fs_update_column_sql. " where comments_id = ".(int)$cID;
								$db->Execute($fs_query);
								$db->Execute("delete from reviews_geust_ip where id=".$res->fields['id']);
								$count = get_comments_count($cID,$type);
								echo '{"cID":"'.$cID.'","num":"'.$count.'","type":"0"}';
							}else{
								echo '{"cID":"0","num":"0","type":"0"}';
							}
						}else{
						
							$ip_array=array('comments_id'=>$cID,'ip'=>$ip,'type'=>$type,'source_type'=>1,'add_time'=>'now()','language_id'=>(int)$_SESSION['languages_id']);
							zen_db_perform('reviews_geust_ip',$ip_array);

							if (is_exist_comments_valuation($cID)){
								if (1 == $type) {
									$fs_update_column_sql = ' r_like = r_like+1 ';
								}else if (0 == $type){
									$fs_update_column_sql = ' r_bad = r_bad+1 ';
								}
								$fs_query = "update reviews_comments_like_or_not set " . $fs_update_column_sql. " where comments_id = ".(int)$cID;
								$db->Execute($fs_query);
			
								//get revies'count
								$count = get_comments_count($cID,$type);
								//echo $count;
			
								echo '{"cID":"'.$cID.'","num":"'.$count.'","type":"1"}';
							}else {
								$arr1 = array('comments_id' => $cID);
								if (1 == $type) {
									$arr2 = array('r_like'=> 1,'r_bad'=> 0);
								}else if (0 == $type){
									$arr2 = array('r_like'=> 0,'r_bad'=> 1);
								}
								zen_db_perform('reviews_comments_like_or_not',array_merge($arr1,$arr2));
								echo '{"cID":"'.$cID.'","num":"'.$count.'","type":"1"}';
							}
						}
					}
				}else{
					echo '{"ip":"'.$ip.'"}';
				}
				exit;
			break;	

			case 'cart_num':
					$type = $_POST['type'];
					$p_id = $_POST['p_id'];
					$p_num = $_POST['p_num'];

					$num = 1;
					require ('fs_ajax/functions_fs_reviews.php');
					if (1 == $type) {
						$cart_num = 'customers_basket_quantity = customers_basket_quantity+1';
					}else if (0 == $type){
						$cart_num = 'customers_basket_quantity = customers_basket_quantity-1';
					}
					$sql = "update " . TABLE_CUSTOMERS_BASKET . " set ".$cart_num." where products_id = '" . (int)$p_id . "'";
					$db->Execute($sql);

					$num = get_customer_quantity($p_id,$type);

					echo '{"p_id":"'.$p_id.'","count":"'.$num.'"}';
					//exit('success');
			break;

		}
	//}
}