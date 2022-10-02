<?php
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

$allow_origin = array(
    'https://community.fs.com',
    'http://test-blog.whgxwl.com'
);

if(in_array($origin, $allow_origin)){
    header('Access-Control-Allow-Origin:'.$origin);
}
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	
	switch ($_GET['request_type']){
		case 'get_expire_time':
		$orders_id = trim($_POST['orders_id']);
		$payment_module_code = trim($_POST['payment_method']);
		if(isset($orders_id) && isset($payment_module_code)){
			$order_title = changeOrderRestoreType($orders_id,$payment_module_code);
			if($order_title){
				echo json_encode(['status'=>200,'msg'=>$order_title]);exit;
			}else{
				echo json_encode(['status'=>406,'msg'=>'database wrong']);exit;
			}
		}else{
			echo json_encode(['status'=>406,'msg'=>'post value wrong']);exit;
		}
		break;

		case 'bank_transfer':
		global $db;
		if (isset($_POST['orders_id']) && $_POST['orders_id']){
			$orders_id = intval($_POST['orders_id']);
			$_GET['orders_id'] = $orders_id;
			$sender_name = zen_db_prepare_input($_POST['sender_name']);
			$sender_country_id = intval($_POST['sender_country_id']);
			$payamount = $_POST['payment_amount'];
			$paytime = $_POST['payment_time'];
			$sender_telephone = zen_db_prepare_input($_POST['sender_telephone']);
		
			
			$wiretransfer_data = array(
				'orders_id' => $orders_id,
				'sender_name' => $sender_name,
				'sender_country_id' => $sender_country_id,
				'sender_amount' =>$payamount,
				'payment_time' =>$paytime,
				'sender_telephone' => $sender_telephone,
				'sender_time' => 'now()'
			);
			
			zen_db_perform(TABLE_WIRETRANSFER_ORDERS, $wiretransfer_data);
			
			$order_num = $db->Execute("select orders_number as num from ".TABLE_ORDERS." where orders_id = ".$orders_id." limit 1");
			
			//$messageStack->add_session(FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE,'<div class="contact_cgts_01">'.FS_AGAINST_UPDATE.' </div>','success');
			
			$html=zen_get_corresponding_languages_email_common('admin');	     
			 $html_msg['EMAIL_HEADER'] = $html['html_header'];
			 $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
			 $html_msg['ORDER_NUM'] = $order_num->fields['num'];
			 $html_msg['SEND_NAME'] = $sender_name;
			 $html_msg['COUNTRY'] = zen_get_countries_name_of_id($sender_country_id);
			 $html_msg['PAYMENT'] = $payamount;
			 $html_msg['PAYTIME'] = $paytime;
			 $html_msg['PHONE_NUM'] = $sender_telephone;	
			
			$email = $_SESSION['customers_email_address'];
			
			$text_message = FS_AGAINST_FIBERSTORE.$order_num->fields['num'];
			$send_to_email = 'support@fiberstore.com';
			$send_to_name =  trim(STORE_NAME);
			if (!defined('EMAIL_SUBJECT')) {
				define('EMAIL_SUBJECT', FS_AGAINST_FIBERSTORE.$order_num->fields['num']);
			}
			zen_mail($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $sender_name, $email, $html_msg,'checkout_westernunion_or_wiretransfer_send_to_us');
		
			$res = $db->Execute("select admin_id from order_to_admin where orders_id =".$orders_id);
			 if(!empty($res->fields['admin_id'])){
				 $res2 = $db->Execute("select admin_name,admin_email from admin where admin_id =".$res->fields['admin_id']);
				 $sale_name =  $res2->fields['admin_name'];
				 $sale_email = $res2->fields['admin_email'];
				 if($sale_email){
					 zen_mail($sale_name, $sale_email, EMAIL_SUBJECT, $text_message, $sender_name, $email, $html_msg,'checkout_westernunion_or_wiretransfer_send_to_us');
				 }
			 }
			//zen_redirect(zen_href_link(FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE,'','NONSSL'));
			echo json_encode(200);die;
		}
		break;

		//fallwind	2017.5.19
		case 'get_specification':
			$cpath = trim($_POST['cpath']);
			$products_id = (int)$_POST['product_id'];
			$specification_content = fs_get_data_from_db_fields('specification','categories_products_specification_info',"cPath='{$cpath}' and products_id=".$products_id,'');
			echo $specification_content;
			exit;
		break;
		
		case 'check_inquiry_mail':
			$get_count = $db->Execute("select count(products_price_inquiry_id) as total from " . TABLE_PRICE_INQUIRY . " WHERE
				products_price_inquiry_email = '".zen_db_prepare_input($_POST['email'])."' and language_id = ".(int)$_SESSION['languages_id']."
				and is_blacklist = 1       ");
			if ($get_count->RecordCount() && $get_count->fields['total']){
			exit('ok');
			}else exit('error');
		break;
		
		case 'save_customer_select':
			$type = zen_db_prepare_input($_POST['type']);
			$country = zen_db_prepare_input($_POST['country']);
			if($type == "change_shipping"){
				$code = strtoupper($country);
				$post_code = zen_db_prepare_input($_POST['country_postal']);
				if(!empty($post_code)&&$code=="US"){
					
					$sql = "SELECT country_code,city FROM `countries_to_zip`  WHERE zip = '$post_code' limit 1";
					$ret = $db->Execute($sql);
					if(!empty($ret) && $ret->fields['country_code']=="US"){
						$_SESSION['input_postal_code'] = $post_code;
						$_SESSION['input_postal_city'] =  $ret->fields['city'];
					}
				}else{
					if(!empty($_SESSION['input_postal_code'])){
						unset($_SESSION['input_postal_code']);
					}
					if(!empty($_SESSION['input_postal_city'])){
						unset($_SESSION['input_postal_city']);
					}
				}
				if(german_warehouse("country_code",$code)||other_eu_warehouse($code,"country_code")){
					$status = "eu";
					echo json_encode(array("status"=>$status));
					exit;
				}
			}else{
				if(!empty($_SESSION['user_ip_info']['input_postal_code'])){
					unset($_SESSION['user_ip_info']['input_postal_code']);
				}
				if(!empty($_SESSION['user_ip_info']['input_postal_city'])){
					unset($_SESSION['user_ip_info']['input_postal_city']);
				}
			}
			$_SESSION['currency'] = $_POST['currency'];
			$_SESSION['choice_language'] = $_POST['choice_language'];
			$_SESSION['countries_iso_code'] = $country;
			$_SESSION['ship_country'] = fs_get_country_id_of_code($country);
			delCache(DIR_FS_CATALOG.'cache/index/',1);
			/* require_once DIR_WS_CLASSES .'set_cookie.php';
            $Encryption = new Encryption; 
			$countryCode_encrypt = $Encryption->_encrypt($_SESSION['countries_iso_code']); */
			$countryCode_encrypt = $_SESSION['countries_iso_code'];
	        setcookie("countries_iso_code",$countryCode_encrypt,time()+86400*7 ,"/"); 
			$_COOKIE['countries_iso_code'] = $countryCode_encrypt;
			$data = array('session'=>$_SESSION['countries_iso_code'],'cookie'=>$_COOKIE['countries_iso_code'],'status'=>'others');
			echo json_encode($data);
			exit;
			break;	
		
		case 'subscribe';
			$get_count = $db->Execute("select count(customers_subscribe_id) as total from " . TABLE_SUBSCRIBE . " WHERE 
				customers_email_address = '".zen_db_prepare_input($_POST['customers_email_address'])."' and language_id = ".(int)$_SESSION['languages_id']."       ");		
			if ($get_count->RecordCount() && $get_count->fields['total']){
				exit('haveSubscribed');
			}else{
				$_SESSION['newsletter_customers_email_address'] = zen_db_prepare_input($_POST['customers_email_address']);
				$customers_subscribe_data = array(
					'customers_name' => zen_db_prepare_input($_POST['customers_lastname']),
					'customers_email_address' => zen_db_prepare_input($_POST['customers_email_address']),
					'language_id' => (int)$_SESSION['languages_id'],
					'timeline'=>time()
			);
			zen_db_perform(TABLE_SUBSCRIBE, $customers_subscribe_data);
			if (0 < $db->insert_ID())exit('subscribeOk'); else exit('error');
			}
		break;

		case 'subscription':
			$email = zen_db_prepare_input($_POST['email']);
			//community调用接口传参数
            if ($_POST['countries_iso_code_2']) {
                $countries_iso_code = zen_db_prepare_input($_POST['countries_iso_code']);
                $communityMailSubscribe = 1;
            } else {
                $countries_iso_code = strtoupper($_SESSION['countries_iso_code']);
                $communityMailSubscribe = 0;
            }
			//email格式验证
			if(!$email){
				echo json_encode(array('status'=>'fail','msg'=>FS_EMAIL_SUBSCRIPTION_FOOTER_04));
				exit();
			}
			$preg_email='/^[0-9A-Za-z][\w\.\-\+]*\@[\w\.\-\+]+\.[\w\.\-]+[A-Za-z]$/';
			
			if(!preg_match($preg_email,$email)){
				echo json_encode(array('status'=>'fail','msg'=>FS_EMAIL_SUBSCRIPTION_FOOTER_05));
				exit();
			}
			// 2019-9-5 potato 限制表单提交次数
            $submit_number = checkoutSubmitNumber('subscription');
            if (!$submit_number) {
                echo json_encode(array('status' => 'fail', 'msg' => FS_SUBMIT_TOO_OFTEN));
                exit();
            }
            $is_off_customer = '';
			$is_old_customer = false;
			$customerInfo = fs_get_data_from_db_fields_array(['customers_id', 'customers_number_new', 'is_disabled'],'customers','customers_email_address = "'.$email.'"','limit 1');
            $customer_id = $customerInfo[0][0];

			if($customer_id){
                $is_customer_to_admin = false;
				//更新customers表
				$db->Execute("update " . TABLE_CUSTOMERS . " SET customers_newsletter = 1 WHERE customers_id = ". (int)$customer_id);
                //更新用户添加community订阅
                if ($communityMailSubscribe) {
                    $db->Execute("update " . TABLE_CUSTOMERS . " SET community_mail_subscribe = 1 WHERE customers_id = ". (int)$customer_id);
                }
                $customers_number_new = $customerInfo[0][1];
                $isDisabled = $customerInfo[0][2];
				$admin_id = zen_get_customer_has_allot_to_admin($customer_id);
				if($admin_id){
					$is_old_customer = true;
                    $is_customer_to_admin = true;
                }
				$dataInfo = getIsDisabledEmail($customers_number_new, $isDisabled, $admin_id);
				$admin_id = $dataInfo['admin_id'];
				$reason_type = $dataInfo['reason_type'];
			}else{
				//线下客户
				$offline_data = fs_get_data_from_db_fields_array(array('admin_id','customers_id'),'customers_offline',"customers_email_address = '" .$email."'",'limit 1');
				$customer_id = $offline_data[0][1];
				$admin_id = $offline_data[0][0];
				if($customer_id){
					//更新customers_offline表
					$db->Execute("update " . 'customers_offline' . " SET customers_newsletter = 1 WHERE customers_id = ". (int)$customer_id);

					//更新用户添加community订阅
					if ($communityMailSubscribe) {
                        $db->Execute("update " . 'customers_offline' . " SET community_mail_subscribe = 1 WHERE customers_id = ". (int)$customer_id);
                    }

                    if($offline_data[0][0]){
                        $is_old_customer = true;
                    }else{
                        $is_off_customer = $offline_data[0][1];//存在客户信息未分配
                    }
                }
			}
			if($is_old_customer && $admin_id){
				//老客户发送邮件给对应销售
				$admin_data = fs_get_data_from_db_fields_array(['admin_name','admin_email'],'admin','admin_id='.$admin_id,'limit 1');
                $admin_name = $admin_data[0][0];
				$admin_email = $admin_data[0][1];
				
				$html = common_email_header_and_footer('Marketing Emails','','');
                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
				$html_msg['NAME'] = $admin_name;
				if($is_offline_customer){
					$customer_info = fs_get_data_from_db_fields_array(['customers_firstname','customers_lastname'],'customers_offline',"customers_email_address = '" .$email."'",'limit 1');
					$html_msg['CUSTOMER_NAME'] = $customer_info[0][0].' '.$customer_info[0][1];
					$html_msg['CUSTOMER_EMAIL'] = $email;
				}else{
					$customer_info = fs_get_data_from_db_fields_array(['customers_firstname','customers_lastname','customers_email_address'],'customers',"customers_id = ". intval($customer_id),'limit 1');
					$html_msg['CUSTOMER_NAME'] = $customer_info[0][0].' '.$customer_info[0][1];
					$html_msg['CUSTOMER_EMAIL'] = $customer_info[0][2];
				}
		
				$html_msg['NEVER'] = 'no';
                $html_msg['REGULAR'] = 'yes';
                $html_msg['WEEK'] = 'no';
				$html_msg['MONTH'] = 'no';
				
				$email_title = 'email subscription';
                sendwebmail($admin_name, $admin_email,'客户订阅邮件通知'.$admin_email.date('Y-m-d H:i:s', time()),STORE_NAME,$email_title, $html_msg, 'admin_subscription',81,'');
							
			}else{
				//新客户分配流程
                $allot_type='email';
                $email_address = $email;
                if ($_POST['languages_id']) {
                    $language = zen_db_prepare_input($_POST['languages_id']);
                }
				if (!$admin_id) {
                    require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                }

                if($admin_id && $email_address){
                    if($is_customer_to_admin && !$reason_type){
                        $db->Execute("update admin_to_customers set admin_id='".$admin_id."' where customers_id='".$customer_id."'");
                    }elseif ($is_off_customer && !$reason_type){
                        $db->Execute("update customers_offline set admin_id='".$admin_id."' where customers_id='".$is_off_customer."'");
                    }else{
                        auto_given_customers_to_admin(array(
                            'admin_id' => $admin_id,
                            'email_address' => $email_address,
                            'admin_id_from_table' => $admin_id_from_table,
                            'country' => fs_get_data_from_db_fields('countries_id','countries','countries_iso_code_2="'.$countries_iso_code.'"','limit 1'),
                            'is_make_up' => $is_make_up ? : 0,
                            'from_auto_file' => 'auto_given',
                            'source' => 19,      // 客户来源：订阅
                            'is_old' => $is_old ? $is_old : 0,  // 标注新、老客户
                            'community_mail_subscribe' => $communityMailSubscribe,
                            'customer_number' => $customers_customers_number_new,
                            'customer_offline_number' => $offline_customers_number_new,
                            'invalidSign' => $invalidSign,
						));

						$admin_data = fs_get_data_from_db_fields_array(['admin_name','admin_email'],'admin','admin_id='.$admin_id,'limit 1');
						$admin_name = $admin_data[0][0];
						$admin_email = $admin_data[0][1];
						
						$html = common_email_header_and_footer('Marketing Emails','','');
						$html_msg['EMAIL_HEADER'] = $html['header'];
						$html_msg['EMAIL_FOOTER'] = $html['footer'];
						$html_msg['NAME'] = $admin_name;
						
						$html_msg['CUSTOMER_NAME'] = '';
						$html_msg['CUSTOMER_EMAIL'] = $email_address;
						$html_msg['NEVER'] = 'no';
						$html_msg['REGULAR'] = 'yes';
						$html_msg['WEEK'] = 'no';
						$html_msg['MONTH'] = 'no';
						
						$email_title = 'email subscription';
						sendwebmail($admin_name, $admin_email,'客户订阅邮件通知'.$admin_email.date('Y-m-d H:i:s', time()),STORE_NAME,$email_title, $html_msg, 'admin_subscription',81,'');

						$html = zen_get_corresponding_languages_email_common();
						$html_msg['EMAIL_HEADER'] = $html['html_header'];
						$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
						$html_msg['CUSTOMER_NAME'] = 'not set yet';
						$html_msg['NUMBER'] = 'not set yet';
						$html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';		
						sendwebmail($admin_name, $admin_email,'Customer Info'.$admin_email.date('Y-m-d H:i:s', time()),STORE_NAME,"Customer Info", $html_msg, 'regist_to_us',81,'');
					}
                }
			}
			echo json_encode(array('status'=>'success','msg'=>FS_EMAIL_SUBSCRIPTION_FOOTER_06));
			exit();
		break;

		case 'save_custoemr_visted':
			$cus_id = $_POST['customer_id'];
			if(!$cus_id){
				exit();
			}
            $new_customer_visited_page=$_SERVER['HTTP_REFERER'];
            //$REMOTE_ADDR_ip=$_SERVER['REMOTE_ADDR'];
            $REMOTE_ADDR_ip = getCustomersIP() ;
            $pd_id= isset($_POST['pd_id']) ? (int)$_POST['pd_id'] : 0;

            $ACCEPT_LANGUAGE_type=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
            if (preg_match("/[zh]{2}\-[cn|CN]{2}/", $ACCEPT_LANGUAGE_type)) {
                exit();
            }

            //  59.173.240.134  F3楼的ip
            if ($REMOTE_ADDR_ip) {

//			require DIR_WS_CLASSES . 'customer_visited_pages.php';
//			$customer_visited = new customers_visited_pages();
//			$is_url = customers_visited_pages::store_customers_visited_pages($new_customer_visited_page);

                if ($pd_id > 0) {
                    $sql="SELECT customers_visited_pages_id,visited_total,customers_id 
			      FROM customers_visited_pages 
			      WHERE use_ip ='".$REMOTE_ADDR_ip."' AND DATE(`visited_time`)=DATE(NOW()) AND products_id='". $pd_id ."' LIMIT 1" ;
                }else{
                    $sql="SELECT customers_visited_pages_id,visited_total,customers_id 
			      FROM customers_visited_pages 
			      WHERE use_ip ='".$REMOTE_ADDR_ip."' AND DATE(`visited_time`)=DATE(NOW()) AND visited_page_url='". $new_customer_visited_page ."' LIMIT 1" ;
                }

                $visited_result = $db->Execute($sql);
                if ($visited_result->RecordCount()) {

                    $visited_total=$visited_result->fields['visited_total'];
                    $visited_id= $visited_result->fields['customers_visited_pages_id'];
                    $customers_id = $visited_result->fields['customers_id'];

                    if ($customers_id) {
                        $d_category = array('visited_total' =>$visited_total+1);
                    }else{
                        $d_category = array('customers_id' => isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '','visited_total' =>$visited_total+1);
                    }
                    zen_db_perform(TABLE_CUSTOMERS_VISITED_PAGES, $d_category,'update','customers_visited_pages_id='.$visited_id);

                }else{
                    $d_category = array(
                        'customers_id' => isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '',
                        'visited_page_url' => $new_customer_visited_page,
                        'language_id' => $_SESSION['languages_id'],
                        'visited_time' => 'now()',
                        'use_ip' => $REMOTE_ADDR_ip,
                        'products_id' => $pd_id,
                    );
                    zen_db_perform(TABLE_CUSTOMERS_VISITED_PAGES, $d_category);
                }
            }
            exit();
            break;

        case 'postComment':
			$products_id = (int)$_POST['pid'];
			$reviews_id =(int)$_POST['rid'];
			$comment_cotent = $_POST['post_reply'];
			$customers_id = (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0);
			if($customers_id){
			//$customers_name = (isset($_SESSION['name']) ? $_SESSION['name'] : '');
			$customers_name = (isset($_SESSION['customer_first_name']) ? $_SESSION['customer_first_name'] : '');
			$comment = array(
					'reviews_id' => $reviews_id,
					'products_id'=> $products_id,
					'status' => 1
					);
			zen_db_perform(TABLE_REVIEWS_COMMENTS, $comment);
			$cid = $db->insert_ID();
			$comment_description = array(
					'comments_id' => $cid,
					'customers_id' => $customers_id,
					'customers_name' => $customers_name,
					'comments_content'=>$comment_cotent,
					'date_added'=>'now()',
					'last_modified'=>'now()'
				);
			zen_db_perform(TABLE_REVIEWS_COMMENTS_DESCRIPTION, $comment_description);
			echo '{"rid":"'.$reviews_id.'","content":"'.$comment_cotent.'","name":"'.$customers_name.'","time":"'.date('F j, Y',time()).'"}';
			}

		break;
		
		case 'get_reviews_comments_desc':
			$products_id = (int)$_POST['pid'];
			$reviews_id =(int)$_POST['rid'];
			$sql = "select rc.comments_id,rcd.customers_name,rcd.comments_content,rcd.date_added from ".TABLE_REVIEWS_COMMENTS." as rc join ".TABLE_REVIEWS_COMMENTS_DESCRIPTION." as rcd on rc.comments_id = rcd.comments_id where rc.reviews_id = ".$reviews_id." AND rc.products_id = ".$products_id." ";
			$result = $db->Execute($sql);
		    if ($result->RecordCount()){
				while (!$result->EOF){
					//echo '{"rid":"'.$result->fields['comments_id'].'","content":"'.$result->fields['comments_content'].'","name":"'.$result->fields['customers_name'].'","time":"'.date('F j, Y',$result->fields['date_added']).'"}';
					$arr['list'][] = array(
						'rid' => $result->fields['comments_id'],
						'name' => $result->fields['customers_name'],
						'content' => $result->fields['comments_content'],
						'time' => date('F j, Y',strtotime($result->fields['date_added']))
					);
					$result->MoveNext();
				}
			}
			echo json_encode($arr);
		break;

		case 'get_two_categroy':
			if(isset($_POST['pid']) && !empty($_POST['pid'])){
				$pid = (int)$_POST['pid'];
                //优先调用自定义二级分类数据
                $custom_category = $db->getAll("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$pid." and level_id=2 and language_id = ".$_SESSION['languages_id']." order by sort");
                if($custom_category){
                    $category_level2 = $custom_category;
                }else{
                    //$category_level2 = fs_get_subcategories($pid);
                }
				echo json_encode($category_level2);
			}
		break;

		case 'get_three_categroy':
			if(isset($_POST['pid']) && !empty($_POST['pid'])){
				$pid = (int)$_POST['pid'];

                //优先调用自定义三级分类数据
                $custom_category = $db->getAll("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$pid." and level_id=3 and language_id = ".$_SESSION['languages_id']." order by sort");
                if($custom_category){
                    $category_level3 = $custom_category;
                }else{
                    $custom_category = $db->getAll("select categories_id from categories_left_display where cid=".$pid." and level_id=2 and language_id = ".$_SESSION['languages_id']." limit 1");
                    if($custom_category[0]['categories_id']){
                        $category_level3 = fs_get_subcategories($custom_category[0]['categories_id']);
                    }
/*                    if($pid == 3079){
                        $id = '3079,56,1114,2689';
                        $category_level3 = fs_get_subcategories_by_id($id);
                    }elseif($pid == 1071){
                        $id = '1071,889,1117,2691';
                        $category_level3 = fs_get_subcategories_by_id($id);
                    }elseif($pid == 2960){
                        $id = '2960,1037,1181';
                        $category_level3 = fs_get_subcategories_by_id($id);
                    }else{
                        $category_level3 = fs_get_subcategories($pid);
                    }*/
                }
				echo json_encode($category_level3);
			}
		break;
		
		case 'set_review':		//solution添加评论
			if(isset($_POST['data']) && !empty($_POST['data']) && !empty($_POST['solution_id'])){
				$review_content = $_POST['data'];
				$solution_id = (int)$_POST['solution_id'];
				$review_content = fliter_escape($review_content);
				$user_id = $_SESSION['customer_id'];
				$time = time();
				$language_id = $_SESSION['languages_id'];
				$review_array = array(
					'solution_id' =>$solution_id,
					'user_id'=>$user_id,
					'review_content'=>$review_content,
					'create_time'=>$time,
					'language_id'=>$language_id
				);																
				zen_db_perform('solutions_reviews',$review_array);
				$get_review_sql = "SELECT sr.review_id,sr.reply_id ,sr.solution_id,sr.user_id,c.customers_firstname as user_name,sr.praise_num,sr.review_content,sr.create_time FROM `solutions_reviews` as sr 
								left join `customers` as c on c.customers_id = sr.user_id
								WHERE sr.solution_id = $solution_id and sr.user_id = $user_id and sr.language_id = $language_id and sr.create_time = $time";
				$res = $db->Execute($get_review_sql);
				$reviews_nums = sizeof(get_solution_all_reviews($solution_id));
				while (!$res->EOF){
					$review_res = array(
						'r_id'=>$res->fields['review_id'],
						're_id'=>$res->fields['reply_id'],
						'so_id'=>$res->fields['solution_id'],
						'u_id'=>$res->fields['user_id'],
						'user_name'=>$res->fields['user_name'],
						'p_num'=>$res->fields['praise_num'],
						'r_content'=>$res->fields['review_content'],
						'time'=>date('M j,Y',$res->fields['create_time']),
						'reviews_nums'=>$reviews_nums
					);
					$res->MoveNext();
				}								
				echo json_encode($review_res);
			}
		break;
		
		case 'del_review':		//solution删除评论
			if(isset($_POST['data1']) && !empty($_POST['data1']) && !empty($_POST['data2'])){
				$review_id = (int)$_POST['data1'];
				$solution_id = (int)$_POST['data2'];
				$user_id = $_SESSION['customer_id'];
				$language_id = $_SESSION['languages_id'];
				$sql = "delete from `solutions_reviews` where review_id = ".$review_id." and solution_id = ".$solution_id." and user_id = ".$user_id." and language_id = ".$language_id;
				if($db->Execute($sql)){
					echo json_encode('Delete success');
				}else{
					echo json_encode('Delete failed');
				}
			}
		break;
		
		case 'reply_review':	//solution回复评论
			$review_content = fliter_escape($_POST['data1']);
			$reply_id = (int)$_POST['data2'];
			$solution_id = (int)$_POST['data3'];
			$user_id = (int)$_POST['data4'];
			$reply_name = fliter_escape($_POST['data5']);
			$time = time();
			$language_id = $_SESSION['languages_id'];
			if(isset($user_id) && !empty($review_content) && !empty($reply_id) && !empty($solution_id) && !empty($user_id) && !empty($reply_name)){
				$reply_array = array(
					'reply_id'=>$reply_id,
					'solution_id' =>$solution_id,
					'user_id'=>$user_id,
					'review_content'=>$review_content,
					'create_time'=>$time,
					'language_id'=>$language_id
				);
				zen_db_perform('solutions_reviews',$reply_array);				
				$get_reply_sql = "SELECT sr.review_id,sr.reply_id ,sr.solution_id,sr.user_id,c.customers_firstname as user_name,sr.praise_num,sr.review_content,sr.create_time FROM `solutions_reviews` as sr 
								left join `customers` as c on c.customers_id = sr.user_id
								WHERE sr.solution_id = $solution_id and sr.user_id = $user_id and sr.language_id = $language_id and sr.create_time = $time";
				$res = $db->Execute($get_reply_sql);												
				while (!$res->EOF){
					$review_res = array(
						'r_id'=>$res->fields['review_id'],
						're_id'=>$res->fields['reply_id'],
						'so_id'=>$res->fields['solution_id'],
						'u_id'=>$res->fields['user_id'],
						'user_name'=>$res->fields['user_name'],
						'reply_name'=>$reply_name,
						'p_num'=>$res->fields['praise_num'],
						'r_content'=>$res->fields['review_content'],
						'time'=>date('M j,Y',$res->fields['create_time']),
					);
					$res->MoveNext();
				}								
				echo json_encode($review_res);
			}
		break;
		
		case 'click_praise':	//solution评论点赞
			$review_id = (int)$_POST['data'];
			if(isset($review_id) && !empty($review_id)){
				$language_id = $_SESSION['languages_id'];
				$sql = "UPDATE `solutions_reviews` SET `praise_num`= `praise_num` + 1 WHERE `review_id` = {$review_id} and `language_id` = {$language_id}";	
				$db->Execute($sql);
				$get_new_praise = "SELECT `praise_num` FROM `solutions_reviews` WHERE `review_id` = {$review_id} and `language_id` = {$language_id}";
				$res = $db->Execute($get_new_praise);
				if($res->RecordCount()){
					$num = $res->fields['praise_num'];
					echo json_encode($num);
				}																			
			}
		break;
		
		case 'click_thank':		//solution点like
			$solution_id = (int)$_POST['data'];
			if(isset($solution_id) && !empty($solution_id)){
				$language_id = $_SESSION['languages_id'];
				$add_thank_sql = "UPDATE `solution_method` SET `total_thanks`=`total_thanks`+1 WHERE `solution_id` = {$solution_id} and `language_id` = {$language_id}";	
				$res = $db->Execute($add_thank_sql);
				$get_new_thank = "SELECT `total_thanks` FROM `solution_method` WHERE `solution_id` = {$solution_id} and `language_id` = {$language_id}";
				$res = $db->Execute($get_new_thank);
				if($res->RecordCount()){
					$thank_num = $res->fields['total_thanks'];
					echo json_encode($thank_num);
				}
			}
		break;
		
		case 'n_page':			//solution下一页
			$solution_id = (int)$_POST['data'];
			$last_page_num = (int)$_POST['page'];
			if(isset($solution_id) && !empty($solution_id) && !empty($last_page_num)){
				$all_reviews = get_solution_all_reviews($solution_id);
				$all_reviews_num = sizeof($all_reviews);//总共有多少条数据
				$how_page = ceil($all_reviews_num/10);	//总共有多少页
				if($all_reviews_num > 10){
					$total_page_data = array();
					for($i=0;$i<$how_page;$i++){
						$total_page_data['review_page'.$i] = array_slice($all_reviews,$i*10,10,true);
					}
					foreach($total_page_data as $key=>$val){
						foreach($val as $k=>$v){
							if($k == ($last_page_num+1)){
								$curPage_array = $val;	//当前页的评论数据
								break;
							}
						}
					}
					
					foreach($curPage_array as $k=>$v){
						$time = date('M j,Y',$v['create_time']);
						$curPage_array[$k]['create_time'] = $time;
					}
					
					$curPage_arr['solution_id'] = $solution_id;
					$curPage_arr['total_page_num'] = $how_page;
					$new_page = array();
					$new_page[] = $curPage_array;
					$new_page[] = $curPage_arr;
					echo json_encode($new_page);
				}else{
					echo json_encode('Not next page!');
				}
			}
		break;
		
		case 'p_page':			//solution上一页
			$solution_id = (int)$_POST['data'];
			$first_page_num = (int)$_POST['page'];
			if(isset($solution_id) && !empty($solution_id) && !empty($first_page_num) && $first_page_num >= 10){
				$all_reviews = get_solution_all_reviews($solution_id);
				$all_reviews_num = sizeof($all_reviews);//总共有多少条数据
				$how_page = ceil($all_reviews_num/10);	//总共有多少页
				if($all_reviews_num > 10){
					$total_page_data = array();
					for($i=0;$i<$how_page;$i++){
						$total_page_data['review_page'.$i] = array_slice($all_reviews,$i*10,10,true);
					}
					foreach($total_page_data as $key=>$val){
						foreach($val as $k=>$v){
							if($k == ($first_page_num-1)){
								$curPage_array = $val;	//当前页的评论数据
								break;
							}
						}
					}
					
					foreach($curPage_array as $k=>$v){
						$time = date('M j,Y',$v['create_time']);
						$curPage_array[$k]['create_time'] = $time;
					}
					
					$curPage_arr['solution_id'] = $solution_id;
					$curPage_arr['total_page_num'] = $how_page;
					$new_page = array();
					$new_page[] = $curPage_array;
					$new_page[] = $curPage_arr;
					echo json_encode($new_page);
				}else{
					echo json_encode('Not prev page!');
				}
			}
		break;
		
		case 'view_dialog':		//solution查看对话
			$review_id = (int)$_POST['data'];
			if(isset($review_id) && !empty($review_id)){
				$view_dialog_arr = getViewDialog($review_id,$review_id);
				sort($view_dialog_arr);
				foreach($view_dialog_arr as $k=>$v){
					$time = date('M j,Y',$v['create_time']);
					$view_dialog_arr[$k]['create_time'] = $time;
				}
				echo json_encode($view_dialog_arr);
			}else{
				echo json_encode('Not dialog!');
			}
		break;
		
		case 'show_shara':		//保存banner图内容
			if(!empty($_POST['data']) && !empty($_POST['data2'])){
				$banner_content = $_POST['data'];
				$a_id = $_POST['data2'];
				$banner_content_arr = array(
					'banner_content'=>$banner_content,
				);															
				zen_db_perform('support_articles_description', $banner_content_arr,'update','support_articles_id='.$a_id.' and language_id = '.$_SESSION['languages_id']);
			}
		break;
		
		case 'google_ads':			
			//fallwind 2016.10.14  如果是通过Google广告进来的，就保存ip
			if(!empty($_SESSION['google_ads']) && isset($_SESSION['google_ads'])){
				//$customer_come_ip = getCustomersIP();
				//setComeIp($customer_come_ip,2);
				switch($_GET['type']){
					case 'livechat_online':
						$customer_come_ip = getCustomersIP();
						setComeIpByLivechatOnline($customer_come_ip);
					break;
					case 'livechat_email':
						$name = fliter_escape($_GET['name']);
						$email = fliter_escape($_GET['email']);
						$number = fliter_escape($_GET['number']);
						$customer_come_ip = getCustomersIP();
						setComeIpByLivechatEmail($customer_come_ip,$name,$email,$number);
					break;
					case 'livechat_phone':
						$name = fliter_escape($_GET['name']);
						$email = fliter_escape($_GET['email']);
						$number = fliter_escape($_GET['number']);
						$customer_come_ip = getCustomersIP();
						setComeIpByLivechatPhone($customer_come_ip,$name,$email,$number);
					break;
				}
			}
		break;
	}
	
	
	
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){
		    // 这里代码不用了，全部挪到ajax_checkout_manage.php里面去了
			case 'send_email':
				if ($debug){
					$file = DIR_FS_SQL_CACHE.'/ajax-send-mail-'.time().'.log';
					$handle = fopen($file,'a+');
					@chmod($file, 777);
				}
				function zen_check_order_exist($orders_id){
					global $db;
					$get_info = $db->Execute("select count(orders_id) as total from " . TABLE_ORDERS ." where orders_id = " .(int)$orders_id);
					return  ($get_info->fields['total'] ? true : false);
				}
				$orders_id = $_POST['orders_id'];
//				var_dump($orders_id);
                require (DIR_WS_CLASSES.'order.php');
                $order = new order($orders_id);/*for paypal load shipping */
                //require 'includes/languages/english/checkout_process.php';
				if ($debug) fwrite($handle, $orders_id."\n");
				$complete_mail = false;
				if (isset($orders_id) && zen_check_order_exist($orders_id)){
                    if($_SESSION['customer_id']){
                        $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
                    }

                    //var_dump($admin_id);
                    if(!$admin_id){
                        if($_SESSION['customer_id']){
                            $email_address = fs_get_data_from_db_fields('customers_email_address','customers','customers_id='.$_SESSION['customer_id'],'');
                            $customers_country_id = fs_get_data_from_db_fields('customer_country_id','customers','customers_id='.$_SESSION['customer_id'],'');
                        }else{
                            $email_address = fs_get_data_from_db_fields('customers_email_address','orders','orders_id='.$orders_id,'');
                            $customers_country = fs_get_data_from_db_fields('customers_country','orders','orders_id='.$orders_id,'');
                            $customers_country_id =fs_get_data_from_db_fields('countries_id','countries',"countries_name='".$customers_country."'",'');
                        }
                        $order_cust_id = fs_get_data_from_db_fields('customers_id','orders','orders_id='.$orders_id,'');
                        if($order_cust_id){
                            $customer_from = fs_get_data_from_db_fields('customers_regist_from','customers','customers_id='.$_SESSION['customer_id'],'');
                            //新注册的用户下单进行分配
                            if($customer_from == 'regist'){
                                $allot_type = 'register_order';
                                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                                if($admin_id){
                                    $stats_data = array(
                                        'stats_order' => 1,
                                        'is_make_up' => $is_make_up,
                                        'remind' => 0,
                                        'is_old' => $is_old ? $is_old : 0, // 标注新、老用户
                                    );
                                    zen_db_perform(TABLE_CUSTOMERS, $stats_data, 'update', 'customers_id=' . $_SESSION['customer_id']);
                                    $customer_allot = array(
                                        'admin_id' => $admin_id,
                                        'customers_id' => $_SESSION['customer_id'],
                                        'add_time' => get_common_cn_time(),
                                        'assistant_id' => 0,
                                    );
                                    zen_db_perform('admin_to_customers', $customer_allot);
                                    $son_order = zen_get_all_son_order_id($orders_id);
                                    if($son_order){
                                         $son_order[] = $orders_id;
                                         for($i=0;$i<sizeof($son_order);$i++){
                                                 $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$son_order[$i].")");
                                         }
                                    }else{
                                        $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$orders_id.")");
                                    }
                                }
                                zen_db_perform(TABLE_CUSTOMERS, array('is_allot' => 1, 'stats_order' => 1), 'update', 'customers_id=' . $_SESSION['customer_id']);
                                define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
                                $sales_email = fs_get_data_from_db_fields('admin_email','admin','admin_id='.$admin_id,'');
                                $data = $db->Execute("select customers_id,customers_email_address,is_allot,customers_firstname,customers_lastname,customers_telephone from customers where customers_id=" . $_SESSION['customer_id']);
                                $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
                                $name = $data->fields['customers_firstname'] . ' ' . $data->fields['customers_lastname'];
                                $phonenumber = $data->fields['customers_telephone'];
                                $email_address = $data->fields['customers_email_address'];
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
                                $html_msg_us['PHONE_NUMBER'] = $phonenumber ? $phonenumber : 'not set yet';
                                $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                                $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
                                $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
                                $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
                                $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';

                                $admin_to_customers_admin_id = fs_get_data_from_db_fields('admin_id','admin_to_customers','customers_id='.$_SESSION['customer_id'],'');
                                if ($admin_to_customers_admin_id) {
//                                $sales_email = 'Dylan.Zhang@feisu.com';
                                    if ($sales_email) {
                                        zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
                                    }
                                }
                                $db->Execute("update  customers c inner join admin_to_customers atc using(customers_id) set is_allot=0 WHERE is_allot=1");
                            }elseif($customer_from == 'guest'){
                                //游客下单进行分配销售
                                $allot_type = 'visitor_regist_order';
                                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                                if($admin_id){
                                    $son_order = zen_get_all_son_order_id($orders_id);
                                    if($son_order){
                                        $son_order[] = $orders_id;
                                        for($i=0;$i<sizeof($son_order);$i++){
                                            $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$son_order[$i].")");
                                        }
                                    }else{
                                        $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$orders_id.")");
                                    }
                                    $customer_allot = array(
                                        'admin_id' => $admin_id,
                                        'customers_id' => $_SESSION['customer_id'],
                                        'add_time' => get_common_cn_time(),
                                        'assistant_id' => 0,
                                    );
                                    zen_db_perform('admin_to_customers',$customer_allot);
                                    zen_db_perform('orders',array('is_allot' => 1),'update','orders_id='.$orders_id);
                                }
                                zen_db_perform(TABLE_CUSTOMERS, array('is_allot' => 1, 'stats_order' => 1, 'is_make_up'=>$is_make_up ? : 0), 'update', 'customers_id=' . $_SESSION['customer_id']);
                                define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
                                $sales_email = fs_get_data_from_db_fields('admin_email','admin','admin_id='.$admin_id,'');
                                $data = $db->Execute("select customers_id,customers_email_address,is_allot,customers_firstname,customers_lastname,customers_telephone from customers where customers_id=" . $_SESSION['customer_id']);
                                $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
                                $name = $data->fields['customers_firstname'] . ' ' . $data->fields['customers_lastname'];
                                $phonenumber = $data->fields['customers_telephone'];
                                $email_address = $data->fields['customers_email_address'];
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
                                $html_msg_us['PHONE_NUMBER'] = $phonenumber ? $phonenumber : 'not set yet';
                                $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                                $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
                                $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
                                $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
                                $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';

                                $admin_to_customers_admin_id = fs_get_data_from_db_fields('admin_id','admin_to_customers','customers_id='.$_SESSION['customer_id'],'');
                                if ($admin_to_customers_admin_id) {
//                                $sales_email = 'Dylan.Zhang@feisu.com';
                                    if ($sales_email) {
                                        zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
                                    }
                                }
                            }else{
                                //第三方登陆下单
                                $allot_type = 'third_party_login_order';
                                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                                if($admin_id){
                                    $stats_data = array(
                                        'stats_order' => 1,
                                        'is_make_up' => $is_make_up,
                                        'remind' => 0,
                                        'is_old' => $is_old ? $is_old : 0,      // 标注新、老客户
                                    );
                                    zen_db_perform(TABLE_CUSTOMERS, $stats_data, 'update', 'customers_id=' . $_SESSION['customer_id']);
                                    $customer_allot = array(
                                        'admin_id' => $admin_id,
                                        'customers_id' => $_SESSION['customer_id'],
                                        'add_time' => get_common_cn_time(),
                                        'assistant_id' => 0,
                                    );
                                    zen_db_perform('admin_to_customers', $customer_allot);
                                    $son_order = zen_get_all_son_order_id($orders_id);
                                    if($son_order){
                                        $son_order[] = $orders_id;
                                        for($i=0;$i<sizeof($son_order);$i++){
                                            $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$son_order[$i].")");
                                        }
                                    }else{
                                        $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$orders_id.")");
                                    }
                                    zen_db_perform(TABLE_CUSTOMERS, array('is_allot' => 1, 'stats_order' => 1), 'update', 'customers_id=' . $_SESSION['customer_id']);
                                    define('EMAIL_SUBJECT', 'FiberStore Administrator to assign you a customer, please review!');
                                    $sales_email = fs_get_data_from_db_fields('admin_email','admin','admin_id='.$admin_id,'');
                                    $data = $db->Execute("select customers_id,customers_email_address,is_allot,customers_firstname,customers_lastname,customers_telephone from customers where customers_id=" . $_SESSION['customer_id']);
                                    $adress = $db->Execute("select entry_country_id,entry_street_address,entry_postcode,entry_city from address_book where customers_id=" . $_SESSION['customer_id']);
                                    $name = $data->fields['customers_firstname'] . ' ' . $data->fields['customers_lastname'];
                                    $phonenumber = $data->fields['customers_telephone'];
                                    $email_address = $data->fields['customers_email_address'];
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
                                    $html_msg_us['PHONE_NUMBER'] = $phonenumber ? $phonenumber : 'not set yet';
                                    $html_msg_us['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
                                    $html_msg_us['POSTCODE'] = $entry_postcode ? $entry_postcode : 'not set yet';
                                    $html_msg_us['COUNTRY'] = $country ? $country : 'not set yet';
                                    $html_msg_us['CITY'] = $entry_city ? $entry_city : 'not set yet';
                                    $html_msg_us['ADDRESS'] = $street ? $street : 'not set yet';

                                    $admin_to_customers_admin_id = fs_get_data_from_db_fields('admin_id','admin_to_customers','customers_id='.$_SESSION['customer_id'],'');
                                    if ($admin_to_customers_admin_id) {
//                                $sales_email = 'Dylan.Zhang@feisu.com';
                                        if ($sales_email) {
                                            zen_mail($sales_email, $sales_email, EMAIL_SUBJECT, $text_message, STORE_NAME, "service@fiberstore.net", $html_msg_us, 'customer_assign_to_us');
                                        }
                                    }
                                }
                            }
                        }else{
                            //游客不注册下单
//                            var_dump($orders_id);
                            $admin_id = fs_get_data_from_db_fields('admin_id','order_to_admin','orders_id='.$orders_id,'');
                            if(!$admin_id){
                                $allot_type = 'visitor_order';
                                require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                            }
                            if($admin_id){
                                $son_order = zen_get_all_son_order_id($orders_id);
                                if($son_order){
                                    $son_order[] = $orders_id;
                                    for($i=0;$i<sizeof($son_order);$i++){
                                        $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$son_order[$i].")");
                                    }
                                }else{
                                    $db->Execute("insert into order_to_admin (admin_id,orders_id) values(".$admin_id.",".$orders_id.")");
                                }
                                //将游客下单信息录入线下客户
//                                $order->guest_order_to_offline_order($admin_id);
                            }
                        }
                    }


					if ($debug) fwrite($handle, 'before send mail'."\n");
					if(isset($_GET['type']) && $_GET['type'] == 'gc'){
						$order->send_fs_credit_card_order_email($orders_id,false);
					}elseif($_GET['type'] == 'bpay' || $_GET['type'] == 'eNETS' || $_GET['type'] == 'iDEAL' || $_GET['type'] == 'SOFORT' || $_GET['type'] == 'YANDEX' || $_GET['type'] == 'WEBMONEY'){
					    $order->send_fs_gc_order_email($orders_id,$_GET['type']);
				    }else{
					    $order->send_fs_order_email($orders_id,$complete_mail);
					}
					
					if ($debug){ fwrite($handle, 'after send mail'."\n");
						fclose($handle);
					}
				}

				break;

			case 'save_customer_po':
				require (DIR_WS_CLASSES.'shipping.php');
                $_SESSION['customers_po'] = $_POST['customer_po'];
                $_SESSION['customer_remarks'] = $_POST['customer_remarks'] ;
				$_SESSION['products_custom'] = $_POST['products_custom'];
				$_SESSION['need_invoice']=$_POST['invoice_need'];
				$client_type = zen_db_prepare_input($_POST['client_type']);
				if(!empty($client_type)){
					$_SESSION['client_type'] = $client_type;
				}
				if(!empty($_SESSION['shipping'])&&$_SESSION['shipping']['id']=="selfreferencezones_selfreferencezones")	{
					$_SESSION['photo_name'] = zen_db_prepare_input($_POST['photo_name']);
					$_SESSION['pick_email'] = zen_db_prepare_input($_POST['pick_email']);
					$_SESSION['pick_phone'] = zen_db_prepare_input($_POST['pick_phone']);
					$_SESSION['pick_time'] = zen_db_prepare_input($_POST['pick_time']);
				}
				if(!empty($_SESSION['shipping'])&&$_SESSION['shipping']['id']=="customzones_customzones"){
					$_SESSION['customzones_info']['customzones_select'] = zen_db_prepare_input($_POST['customzones_select']);
					$_SESSION['customzones_info']["customzones_account"] = zen_db_prepare_input($_POST['customzones_account']);
				}
				break;

			case 'create_order':
				if ($debug){
					$file = DIR_FS_SQL_CACHE.'/ajax-create-order-'.time().'.log';
					$handle = fopen($file,'a+');
					@chmod($file, 777);
				}


				require (DIR_WS_CLASSES.'shipping.php');
				require (DIR_WS_CLASSES . 'payment.php');
				$payment = new payment();
				require (DIR_WS_CLASSES.'order.php');
				$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
				if ($debug)fwrite($handle, ' init order - '.time()." \n");
				$shipping_method = $_POST['shipping_method'];
				$shipping = new shipping();
				if ($debug)fwrite($handle, ' init shipping - '.time()." \n");
				$shipping = new shipping($_SESSION['shipping']);
				require (DIR_WS_CLASSES . 'order_total.php');
				$order = new order();/*for paypal load shipping */
				if($order->is_vax){
					if(!empty($order->vat)){
						$order->info['tax_groups']['Vat'] = $order->vat;
						$order->info['total'] += $order->vat;
					}
				}
				$order_total_modules = new order_total();
				$order_totals = $order_total_modules->process();
				if ($debug)fwrite($handle, ' init order totals - '.time()." \n");
				$_SESSION['payment'] = isset($_SESSION['payment']) ? $_SESSION['payment'] : 'paypal';
				$_SESSION['payment'] = $_SESSION['payment'] ? $_SESSION['payment'] : 'paypal';
				$payment = new payment($_SESSION['payment']);
				if ($debug)fwrite($handle, ' init payment - '.time()." \n");
				if($_SESSION['cart']->get_products()){
					$customers_po = zen_db_input($_POST['customer_po']);
					if(!empty($customers_po)){
						$_SESSION['customers_po'] = 	$customers_po;
					}
					$customer_remarks=zen_db_input($_POST['customer_remarks']);
					if(!empty($customer_remarks)){
						$_SESSION['customer_remarks'] = $customer_remarks;
					}
					if(!empty($_SESSION['shipping'])&&$_SESSION['shipping']['id']=="selfreferencezones_selfreferencezones")	{
						$_SESSION['photo_name'] = zen_db_prepare_input($_POST['photo_name']);
						$_SESSION["pick_email"] = zen_db_prepare_input($_POST['pick_email']);
						$_SESSION['pick_phone'] = zen_db_prepare_input($_POST['pick_phone']);
						$_SESSION['pick_time'] = zen_db_prepare_input($_POST['pick_time']);
					}
					if(!empty($_SESSION['shipping'])&&$_SESSION['shipping']['id']=="customzones_customzones"){
						$_SESSION['customzones_info']['customzones_select'] = zen_db_prepare_input($_POST['customzones_select']);
						$_SESSION['customzones_info']["customzones_account"] = zen_db_prepare_input($_POST['customzones_account']);
					}
					$order_id = $order->create_order_new($order_totals,$order_total_modules);
					$client_type = zen_db_prepare_input($_POST['client_type']);
					if(!empty($client_type)){
						$_SESSION['client_type'] = $client_type;
					}
					$products_custom = zen_db_prepare_input($_POST['products_custom']);
					if($products_custom){
						$sql='update orders set products_custom = "'.$products_custom.'" where orders_id ='.$order_id;
						$db->Execute($sql);
					}
					$_SESSION['order_id'] = $order_id;
					$_SESSION['req_qreoid'] = $order_id;

					//订单是否需要发票
					$invoice_need =(int)$_POST['invoice_need'];
					$sql='update orders set is_need_invoice = "'.$invoice_need.'" where orders_id ='.$order_id;
					$db->Execute($sql);
					$_SESSION['need_invoice']=$invoice_need;

					if ($debug)fwrite($handle, ' create  order -order number is '.$invoice.' - '.time()." \n");
					if ($debug)fwrite($handle, ' add products to  order  - '.time().'\n');
					$get_orders_number = $db->Execute("select orders_number from " . TABLE_ORDERS . " where orders_id = ". $order_id);
					$invoice = $get_orders_number->fields['orders_number'];
					if ($debug)fwrite($handle, ' send order email - '.time()." \n");
					$action = $process_string = '';
					$_SESSION['cart']->reset(true);
					//订单生成后及时删除运输信息
					if(isset($_SESSION['customzones_info'])){
						unset($_SESSION['customzones_info']);
					}
					//订单生成后及时删除客户remark信息
					if(isset($_SESSION['customer_remarks'])){
						unset($_SESSION['customer_remarks']);
					}
					if(isset($_SESSION['customers_po'])){
						unset($_SESSION['customers_po']);
					}
					//订单生成后及时删除客户自提信息
					if(isset($_SESSION['photo_name'] )){
						unset($_SESSION['photo_name'] );
					}
					if(isset($_SESSION["pick_email"])){
						unset($_SESSION["pick_email"]);
					}
					if(isset($_SESSION['pick_phone'] )){
						unset($_SESSION['pick_phone'] );
					}
					if(isset($_SESSION["pick_time"])){
						unset($_SESSION["pick_time"]);
					}

			if ('paypal' == $_SESSION['payment']){
					if ($debug)fwrite($handle, ' process paypal action - '.time()." \n");
					$class = & $_SESSION['payment'];
					$action = $GLOBALS[$class]->form_action_url;
					if ($debug)fwrite($handle, 'action url: '.$action.' - '.time()." \n");
					$process_string = $GLOBALS[$class]->process_string();
					$process_string .= '::invoice--'.$invoice;

					if ($debug)fwrite($handle, '$process_string: '.$process_string.' - '.time()." \n"); ;

				if($debug){ fclose($handle);@chmod($file, 777);}

				echo '{"type":"'.$_SESSION['payment'].'","url":"'.$action.'","params":"'.$process_string.'","o_id":"'.(int)$_SESSION['order_id'].'"}';

				}elseif(in_array($_SESSION['payment'],array('bpay','eNETS','iDEAL','SOFORT','YANDEX','WEBMONEY'))){

					$order = new order($order_id);

					$class = & $_SESSION['payment'];

					$action = $GLOBALS[$class]->form_action_url;

					if ($debug)fwrite($handle, 'action url: '.$action.' - '.time()." \n");

					$process_string = $GLOBALS[$class]->process_string();
					echo '{"params":"'.$process_string.'","o_id":"'.(int)$order_id.'"}';
				}elseif('globalcollect' == $_SESSION['payment']||'payeezy' == $_SESSION['payment']){
					unset($_SESSION['sendto']);
					unset($_SESSION['billto']);
					unset($_SESSION['shipping']);
					unset($_SESSION['payment']);
					unset($_SESSION['comments']);
					//unset($_SESSION['cart']);
					echo $order_id;exit;
				}
				}else{
						if('paypal' == $_SESSION['payment']){
							echo '{"error":"err"}';exit;
						}	
				}
				
						//fallwind 2016.10.14	下单成功时，判断$_SESSION['google_ads']是否有值，有值就记录其ip，同时记录该值
				if(!empty($_SESSION['google_ads']) && isset($_SESSION['google_ads']) ){
					$customer_come_ip = getCustomersIP();
					setComeIpByOrders($customer_come_ip,$_SESSION['order_id']);
				}
				
				break;

			case  'select_address':	
			
					if(isset($_POST['address_book_id'])){
						$book_id=$_POST['address_book_id'];
						require DIR_WS_CLASSES . 'customer_account_info.php';
                         $customer_info = new customer_account_info();
						 $use_address=$customer_info->get_select_address($book_id);
						echo $use_address_string.= '{"address_book_id":"'.$use_address['address_book_id'].'",
						"entry_firstname":"'.$use_address['entry_firstname'].'",
						"entry_lastname":"'.$use_address['entry_lastname'].'",
						"entry_street_address":"'.$use_address['entry_street_address'].'",
						"entry_suburb":"'.$use_address['entry_suburb'].'",
						"entry_city":"'.$use_address['entry_city'].'",
						"entry_country":{"entry_country_id":"'.$use_address['entry_country']['entry_country_id'].'",
						"entry_country_name":"'.$use_address['entry_country']['entry_country_name'].'"},
						"entry_state":"'.$use_address['entry_state'].'",
						"entry_zone_id":"'.$use_address['entry_zone_id'].'",
						"entry_postcode":"'.$use_address['entry_postcode'].'",
						"entry_company": "'.$use_address['entry_company'].'",
						"entry_telephone":"'.$use_address['entry_telephone'].'",
						"company_type":"'.$use_address['company_type'].'",
						"entry_tax_number":"'.$use_address['entry_tax_number'].'"}';
					}
	          break;

			case 'paypal_submit':

				$orders_id = isset($_POST['orders_id'])?abs((int)$_POST['orders_id']):0;
                if (can_change_order_status($orders_id) && set_cancel_order_key($orders_id)){
                    del_cancel_order_key($orders_id);
                    $_SESSION['req_qreoid'] = $orders_id;
                    require (DIR_WS_CLASSES . 'payment.php');
                    $payment = new payment('paypal');
                    require (DIR_WS_CLASSES.'order.php');
                    $order = new order($orders_id);
                    $action = $GLOBALS['paypal']->form_action_url;
                    $process_string = $GLOBALS['paypal']->process_string();
                    $process_string .= '::invoice--'.$order->info['orders_number'];
                    echo '{"status":"'."success".'","url":"'.$action.'","params":"'.$process_string.'","o_id":"'.(int)$orders_id.'"}';
                }else{
                    $message = "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>";
                    $location =zen_href_link('manage_orders');
                    $data = [
                        "status"=>"error",
                        "message"=>$message,
                        "location"=>$location,
                    ];
                    echo json_encode($data);
                }
				break;

            case 'paymentNow':

                $order_id = abs((int)$_POST['order_id']);
                if (can_change_order_status($order_id) && set_cancel_order_key($order_id)){
                    del_cancel_order_key($order_id);
                    $payment_method = $_POST['payment'];
                    $_SESSION['req_qreoid'] = $order_id;
                    require (DIR_WS_CLASSES . 'payment.php');
                    $payment = new payment($payment_method);
                    require (DIR_WS_CLASSES.'order.php');
                    $order = new order($order_id);
                    $class = $_SESSION['payment'] = $payment_method;
                    $action = $GLOBALS[$class]->form_action_url;
                    $process_string = $GLOBALS[$class]->process_string();
                    echo '{"status":"'."success".'","params":"'.$process_string.'","o_id":"'.(int)$order_id.'"}';
                }else{
                    $message = "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>";
                    $location =zen_href_link('manage_orders');
                    $data = [
                        "status"=>"error",
                        "message"=>$message,
                        "location"=>$location,
                    ];
                    echo json_encode($data);
                }
                break;

				//add by aron 8.9
			case 'set_address_new':

				if (!isset($customer_info) || !is_object($customer_info)){

					require DIR_WS_CLASSES . 'customer_account_info.php';

					$customer_info = new customer_account_info();

				}


				if (isset($_POST['tag'])){


					/* set shipping address*/

					if (3 == intval($_POST['tag'])){

						$_SESSION['sendto'] = $_POST['address_book_id'];

					}elseif(10 == intval($_POST['tag'])){

						$billing_address_list = $customer_info->get_select_address($_SESSION['billto']);


						$entry_firstname = ($billing_address_list['entry_firstname']);

						$entry_lastname = ($billing_address_list['entry_lastname']);

						$entry_company = ($billing_address_list['entry_company']);

						$entry_street_address = ($billing_address_list['entry_street_address']);

						$entry_suburb = ($billing_address_list['entry_suburb']);

						$entry_city = ($billing_address_list['entry_city']);

						$entry_country_id = ($billing_address_list['entry_country']['entry_country_id']);

						$entry_state = ($billing_address_list['entry_state']);


						$entry_postcode = ($billing_address_list['entry_postcode']);

						$entry_telephone = ($billing_address_list['entry_telephone']);



						$shipping_address = array(

							'entry_company' => zen_db_prepare_input($entry_company),

							'entry_firstname' => zen_db_prepare_input($entry_firstname),

							'entry_lastname' => zen_db_prepare_input($entry_lastname),

							'entry_street_address' => zen_db_prepare_input($entry_street_address),

							'entry_suburb' => zen_db_prepare_input($entry_suburb),

							'entry_postcode' => zen_db_prepare_input($entry_postcode),

							'entry_state' => zen_db_prepare_input($entry_state),

							'entry_city' =>  zen_db_prepare_input($entry_city),

							'entry_country_id' => (int)$entry_country_id,

							'entry_telephone' => zen_db_prepare_input($entry_telephone)

						);


						$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($shipping_address);
						//$customer_info->set_new_shipping_address_bill($_SESSION['billto']);
						//$_SESSION['sendto'] = $_SESSION['billto'];
						exit;
					}else{

						$entry_firstname = trim($_POST['entry_firstname']);

						$entry_lastname = trim($_POST['entry_lastname']);

						$entry_company = trim($_POST['entry_company']);

						$entry_street_address = trim($_POST['entry_street_address']);

						$entry_suburb = trim($_POST['entry_suburb']);

						$entry_city = trim($_POST['entry_city']);

						$entry_country_id = trim($_POST['entry_country_id']);

						$entry_state = trim($_POST['entry_state']);

						if($entry_country_id == 223){
							$entry_state = trim($_POST['shipping_us_state']);
						}

						$entry_postcode = trim($_POST['entry_postcode']);

						$entry_telephone = trim($_POST['entry_telephone']);

						$company_type = $_POST['AddressType'];

						$shipping_address = array(

							'entry_company' => zen_db_prepare_input($entry_company),

							'entry_firstname' => zen_db_prepare_input($entry_firstname),

							'entry_lastname' => zen_db_prepare_input($entry_lastname),

							'entry_street_address' => zen_db_prepare_input($entry_street_address),

							'entry_suburb' => zen_db_prepare_input($entry_suburb),

							'entry_postcode' => zen_db_prepare_input($entry_postcode),

							'entry_state' => zen_db_prepare_input($entry_state),

							'entry_city' =>  zen_db_prepare_input($entry_city),

							'entry_country_id' => (int)$entry_country_id,

							'entry_zone_id' => (int)$entry_zone_id,

							'entry_telephone' => zen_db_prepare_input($entry_telephone),

							"company_type" => zen_db_prepare_input($company_type)

						);

						switch (intval($_POST['tag'])){

							case 1:

								//changed by Aron 2017.7.17
								if (!$customer_info->get_address_records()){

									$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($shipping_address);

								}else{
									$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($shipping_address);
								}


								$shipping_addresses = $customer_info->get_customers_shipping_address();

								if (sizeof($shipping_addresses)){

									$address_string = '';

									foreach ($shipping_addresses as $i => $address){

										$address_string .= '"'.trim($address['address_book_id']).'":{"entry_company":"'.trim($address['entry_company']).'","address_book_id":"'.trim($address['address_book_id']).'","entry_firstname":"'.trim($address['entry_firstname']).'","entry_lastname":"'.trim($address['entry_lastname']).'","entry_street_address":"'.trim($address['entry_street_address']).'","entry_suburb":"'.trim($address['entry_suburb']).'","entry_city":"'.trim($address['entry_city']).'","entry_country":{"entry_country_id":"'.trim($address['entry_country']['entry_country_id']).'","entry_country_name":"'.trim($address['entry_country']['entry_country_name']).'"},"entry_state":"'.trim($address['entry_state']).'","entry_zone_id":"'.trim($address['entry_zone_id']).'","entry_postcode":"'.trim($address['entry_postcode']).'","entry_telephone":"'.trim($address['entry_telephone']).'"},';

									}

									$address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

								}
								$addrss_content =  '"type":"insert","aid": "'.$address_id.'","addresses":'.$address_string.'';

								break;

							case 2:
								/*update exist shipping address*/

								$_SESSION['sendto'] = intval($_POST['address_book_id']);

								zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address,'update','address_book_id='.intval($_POST['address_book_id']));

								$db->Execute("update " . TABLE_CUSTOMERS . " 
							SET customers_default_address_id = " .$_SESSION['sendto'] ." 
							WHERE customers_id = ". intval($_SESSION['customer_id']));


								$shipping_addresses = $customer_info->get_customers_shipping_address();

								if (sizeof($shipping_addresses)){

									$address_string = '';

									foreach ($shipping_addresses as $i => $address){

										$address_string .= '"'.trim($address['address_book_id']).'":{"entry_company":"'.trim($address['entry_company']).'","address_book_id":"'.trim($address['address_book_id']).'","entry_firstname":"'.trim($address['entry_firstname']).'","entry_lastname":"'.trim($address['entry_lastname']).'","entry_street_address":"'.trim($address['entry_street_address']).'","entry_suburb":"'.trim($address['entry_suburb']).'","entry_city":"'.trim($address['entry_city']).'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.trim($address['entry_state']).'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.trim($address['entry_postcode']).'","entry_telephone":"'.trim($address['entry_telephone']).'"},';

									}
									$address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';
								}
								$addrss_content =  '"type":"update","aid":"'.intval($_POST['address_book_id']).'","addresses":'.$address_string.'';
								break;
						}

					}

					$total_weight = $_SESSION['cart']->show_weight();

					require DIR_WS_CLASSES.'order.php';

					$order = new order();

					require DIR_WS_CLASSES.'shipping.php';

					$shipping = new shipping($_SESSION['shipping']);

					$order = new order();

					require (DIR_WS_CLASSES.'order_total.php');

					$order_total_modules = new order_total();

					$order_totals = $order_total_modules->process();

					$shipping = new shipping();

					$quotes = $shipping->quote();

					$fedex_cost = $currencies->value($quotes['fedexzones']['methods'][0]['cost']);

					$dhl_cost = $currencies->value($quotes['dhlzones']['methods'][0]['cost']);

					$airmail_cost = $currencies->value($quotes['airmailzones']['methods'][0]['cost']);

					$subtotal = $currencies->value($order->info['subtotal']);

					switch ($_SESSION['shipping']['id']){

						case 'fedexzones_fedexzones':

							if ($fedex_cost){

								$current_shipping_cost = $fedex_cost;

								$_SESSION['shipping'] = array('id' => 'fedexzones_fedexzones',

									'title' => 'Fedex Rates',

									'cost' => $quotes['fedexzones']['methods'][0]['cost']);

							}

							break;

						case 'dhlzones_dhlzones':

							if ($dhl_cost){

								$current_shipping_cost = $dhl_cost;

								$_SESSION['shipping'] = array('id' => 'dhlzones_dhlzones',

									'title' => 'DHL Rates',

									'cost' => $quotes['dhlzones']['methods'][0]['cost']);

							}

							break;

						case 'airmailzones_airmailzones':

							if ($airmail_cost){

								$current_shipping_cost = $airmail_cost;
								$_SESSION['shipping'] = array('id' => 'airmailzones_airmailzones',
									'title' => 'Airmail Rates',
									'cost' => $quotes['airmailzones']['methods'][0]['cost']);
							}

							break;
					}

					if (!$current_shipping_cost)
						$all_fee = '"all_fee":{"error":"No shipping available to the selected country",';
					else{
						$all_fee = '"all_fee":{"current_shipping":"'.$_SESSION['shipping']['id'].'","current_fee":"'.$current_shipping_cost.'",';
						if ($fedex_cost) $all_fee .= '"fedex":"'.$fedex_cost.'",';
						if ($dhl_cost) $all_fee  .= '"dhl":"'.$dhl_cost.'",';
						if ($airmail_cost) $all_fee .= '"airmail":"'.$airmail_cost.'",';
					}

					$all_fee = substr($all_fee,0,strlen($all_fee)-1).'}';

					if (isset($addrss_content) && $addrss_content){

						echo '{'.$addrss_content.','.$all_fee.'}';

					}else {

						echo '{'.$all_fee.'}';

					}
				}
			break;

			// guest set new guest shipping address add by aron 8.9
		case "set_guest_shipping_address_new":
			if(isset($_SESSION['customer_id'])){
				echo json_encode(array("type"=>5,"msg"=>"You are logged in and are jumping the page for you"));
				exit;
			}
			if (!isset($customer_info) || !is_object($customer_info)){

				require DIR_WS_CLASSES . 'customer_account_info.php';

				$customer_info = new customer_account_info();

			}
			if(isset($_POST['tag'])){
				if (3 == intval($_POST['tag'])){

					$_SESSION['sendto'] = $_POST['address_book_id'];
				}elseif(10 == intval($_POST['tag'])){
					$customer_info->set_guest_shipping_address_bill($_SESSION['billtoG']);
					$_SESSION['sendtoG'] = $_SESSION['billtoG'];
					exit;
				}else{
					$entry_firstname = ($_POST['entry_firstname']);

					$entry_lastname = ($_POST['entry_lastname']);

					$entry_company = ($_POST['entry_company']);

					$entry_street_address = ($_POST['entry_street_address']);

					$entry_suburb = ($_POST['entry_suburb']);

					$entry_city = ($_POST['entry_city']);

					$entry_country_id = ($_POST['entry_country_id']);

					$entry_state = ($_POST['entry_state']);
					$email_address = ($_POST['entry_email']);
					if($entry_country_id == 223){
						$entry_state = ($_POST['shipping_us_state']);
					}

					$entry_postcode = ($_POST['entry_postcode']);

					$entry_telephone = ($_POST['entry_telephone']);
					$entry_tax_number = $_POST['entry_tax_number'];
					$company_type = $_POST['AddressType'];
					if (strlen ( $email_address ) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
						$error = true;
						//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_ERROR );
						echo json_encode(array("type"=>0,"msg"=>ENTRY_EMAIL_ADDRESS_ERROR));exit;
					} else if (zen_validate_email ( $email_address ) == false) {
						$error = true;
						//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
						echo json_encode(array("type"=>1,"msg"=>ENTRY_EMAIL_ADDRESS_CHECK_ERROR));exit;

					} else {
						$check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
												 where customers_email_address = '" .  $email_address . "'";
						$check_email = $db->Execute ( $check_email_query );
						if ($check_email->fields['total'] > 0){
							$error = true;
							$login_in = "   <a href='/login.html'>log in »</a>";
							$html= 'The email address exists in our system, Please log in directly. &nbsp;&nbsp;&nbsp;&nbsp;'.$login_in;
							echo json_encode(array("type"=>2,"msg"=>$html));
							exit;
							//$messageStack->add_session ( FILENAME_REGIST,'<div id="fiberstore_message" class="tishi_02 display_none">Our system already has a record of that email address - please try logging in with that email address.<br /> If you do not use that address any longer you can correct it in the My Account area.</div>' );
						}
					}

					$shipping_address = array(

						'entry_company' => zen_db_prepare_input($entry_company),

						'entry_firstname' => zen_db_prepare_input($entry_firstname),

						'entry_lastname' => zen_db_prepare_input($entry_lastname),

						'entry_street_address' => zen_db_prepare_input($entry_street_address),


						'entry_suburb' => zen_db_prepare_input($entry_suburb),

						'entry_postcode' => zen_db_prepare_input($entry_postcode),

						'entry_state' => zen_db_prepare_input($entry_state),

						'entry_city' =>  zen_db_prepare_input($entry_city),

						'entry_country_id' => (int)$entry_country_id,

						'entry_zone_id' => (int)$entry_zone_id,

						'entry_telephone' => zen_db_prepare_input($entry_telephone),
						'entry_tax_number' => zen_db_prepare_input($entry_tax_number),
						'company_type' => zen_db_prepare_input($company_type)
					);

					$customer_guest = array(

						'email_address' => $email_address,

						'first_name' => $entry_firstname,

						'last_name' => $entry_lastname,

						'customer_country_id' => (int)$entry_country_id,

						'add_time' => date('Y-m-d H:i:s')

					);
					$decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
					switch (intval($_POST['tag'])){

						case 1:

								$re = $db->getAll("select customers_default_address_id,guest_id from customer_of_guest where email_address = '".trim( $email_address)."' order by guest_id DESC limit 1");
								if(!$re[0]['customers_default_address_id']) {
									$_SESSION['sendtoG'] = $address_id = $customer_info->add_guest_shipping_address_new($shipping_address, $customer_guest);
									$data = array("type"=>3,"msg"=>"success",'shipping_id'=>$address_id);
									$use_address=$customer_info->get_select_address($address_id);
								}else{
									$_SESSION['sendtoG'] = $re[0]['customers_default_address_id'];
									zen_db_perform(TABLE_CUSTOMER_OF_GUEST, $customer_guest,'update','guest_id = '.intval($re[0]['guest_id']));
									zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address,'update','address_book_id = '.intval($re[0]['customers_default_address_id']));
									$_SESSION['customers_guest_id'] = intval($re[0]['guest_id']);
									$data = array("type"=>3,"msg"=>"success",'shipping_id'=>$re[0]['customers_default_address_id']);
									$use_address=$customer_info->get_select_address($re[0]['customers_default_address_id']);
								}
								$_SESSION['vat_cost'] = 0;
								$tax_msg = 0;
								$tax_cost = 0;
								$is_ru = 0;
								$EU_country = array(21,222,73,81,105,150,124,57,103,195,84,171,14,203,72,132,55,170,97,56,189,190,67,117,123,175,33,53,141);
								$is_eu = false;
								$warehouse = "US";
								$eu_flag = false;
								$is_cn_vax = false;
								$is_show_free = false;
								$short_title_delay = FS_BULK_WAREHOUSE;
								$short_title_local = FS_WAREHOUSE_AREA_1;
								$is_need_transhipment =false;
								$shipping_percent =1;
								if(FS_IS_SPRING==1){
									$is_spring = true;
									if($use_address['entry_country']['entry_country_id']==176){
										$is_ru = 1;
									}
								}else{
									$is_spring = false;
								}
								require DIR_WS_CLASSES . 'shipping.php';
								require(DIR_WS_CLASSES . 'order.php');
								if(in_array($use_address['entry_country']['entry_country_id'],$EU_country)||other_eu_warehouse($use_address['entry_country']['entry_country_id'])){
									//判断收货地址是位于欧盟
									$eu_flag = true;
									$tax_flag = true;
									$is_eu = true;
									$warehouse = "DE";
									$is_vax = true;
									$short_title_local =  FS_WAREHOUSE_AREA_3;
									if($use_address['entry_country']['entry_country_id']!=81 && $use_address['entry_tax_number']||other_eu_warehouse($use_address['entry_country']['entry_country_id'])){
										//德国无论是否有税号都收税，其他欧盟国没有税号就是收税，有税号就不收税
										$eu_flag = false;
										$is_vax = false;
										$tax_cost = 0;
									}
								}
								if(seattle_warehouse("country_number",$use_address['entry_country']['entry_country_id'])){
									$warehouse = "US";
									$is_spring = false;
									$short_title_local =  FS_WAREHOUSE_AREA_2;
								}
								if($use_address['entry_country']['entry_country_id']==13){
									$short_title_local =  FS_WAREHOUSE_AREA_AU;
									$warehouse = "AU";
								}
								if($use_address['entry_country']['entry_country_id']==44){
									$is_cn_vax = true;
								}
								$products = fs_getProducts_by_warehouse($use_address['entry_country']['country_code']);
								$pro_local = array();
								$pro_global = array();
								$pro = array();
								$order = new order();
								$shipping = new shipping();
								$country_code = $order->delivery['country']['iso_code_2'];
								$country_id =  $order->delivery['country_id'];
								$state = $order->delivery['state'];
								if($products["type"]=="all"){
									$house ="WH";
									foreach ($products['products'] as $k=>$v){
										$pro[] = $v['id'];
									}
//						$_SESSION['cart']->calculate_for_separate($pro);
									$total_weight = $_SESSION['cart']->show_weight();;
									$quotes = $shipping->quote();
									$shipping_all = get_shipping_cost("WH",$state,$country_id,$quotes);
									$shipping_data = $shipping_all;
									$shipping_all_return =  array();
									$shipping_all_return['methods'] = $shipping_all[0]['methods'];
									$shipping_all_return['origin_price'] = $shipping_all[0]['origin_price'];
									$shipping_all_return['price'] = $shipping_all[0]['price'];
									$shipping_all_return['s_price'] = $shipping_all[0]['s_price'];
									$shipping_all_return['title'] = $shipping_all[0]['title'];
									$_SESSION['shipping'] = array('id' => $shipping_all[0]['methods'].'_'.$shipping_all[0]['methods'],

										'title' => $quotes[$shipping_all[0]['methods']]['methods'][0]['title'],

										'cost' => $quotes[$shipping_all[0]['methods']]['methods'][0]['cost']);
								}elseif($products['type']=="separate"){
									if(!empty($products['global'])&&!empty($products['global']["products"])){
										foreach ($products['global']["products"] as $kk=>$vv){
											$pro_global[] = $vv['id'];
										}
//							$_SESSION['cart']->calculate_for_separate($pro_global);
										$total_weight = $_SESSION['cart']->show_weight();
										$quotes = $shipping->quote();
										$shipping_global = get_shipping_cost("WH",$state,$country_id, $quotes );
										$shipping_data = $shipping_global;
										$shipping_global_return = array();
										$shipping_global_return['methods'] = $shipping_global[0]['methods'];
										$shipping_global_return['origin_price'] = $shipping_global[0]['origin_price'];
										$shipping_global_return['price'] = $shipping_global[0]['price'];
										$shipping_global_return['s_price'] = $shipping_global[0]['s_price'];
										$shipping_global_return['title'] = $shipping_global[0]['title'];
										$_SESSION['shipping'] = array('id' => $shipping_global[0]['methods'].'_'.$shipping_global[0]['methods'],

											'title' => $quotes[$shipping_global[0]['methods']]['methods'][0]['title'],

											'cost' => $quotes[$shipping_global[0]['methods']]['methods'][0]['cost']);
									}
									if(!empty($products['local'])&&!empty($products['local']["products"])){
										foreach ($products['local']["products"] as $kkk=>$vvv){
											if(isset($vvv['id']['quickly'])){
												$pro_local[] = $vvv['id']['quickly']['id'];
											}else{
												$pro_local[] = $vvv['id'];
											}
										}
//							$_SESSION['cart']->calculate_for_separate($pro_local);
										$delay_content = array();
										$local_sub_text = $currencies->total_format_new($order->local_info['subtotal'], true, $order->info['currency'], $order->info['currency_value']);
										if($order->local_warehouse==37&&!empty($order->delay_info['products_arr'])&&$local_sub_text>99){
											foreach ($order->delay_products as $k=>$v){
												$delay_content[$v['id']] = $v['qty'];
											}
											$_SESSION['cart']->calculate_for_separate($delay_content);
											$total_weight = $_SESSION['cart']->weight;
										}else{
											$total_weight = $_SESSION['cart']->show_weight();
										}
										$quotes = $shipping->quote();
										$is_bulk = fs_is_bulk_fiber_cable_status_local();
										if(!empty($order->delay_info['products_arr'])) {
											$is_bulk = $order->fs_is_bulk_fiber($order->delay_info['products_arr']);
											if ($is_bulk||$use_address['entry_country']['entry_country_id']==13) {
												$is_need_transhipment = true;
												$warehouse = "WH";
												$products['shipping_time']['delay_max_time']['date'] = $short_title_delay . " " . date('D. M. j', strtotime('+' . $products['shipping_time']['delay_max_time']['time'] . ' days'));
												$products['shipping_time']['quickly_time'] = $short_title_local;
											}
										}
										$shipping_local = get_shipping_cost($warehouse,$state,$country_id,$quotes,$is_spring);
										$shipping_data = $shipping_local;
										$shipping_local_return = array();
										$shipping_local_return['methods'] = $shipping_local[0]['methods'];
										$shipping_local_return['origin_price'] = $shipping_local[0]['origin_price'];
										$shipping_local_return['price'] = $shipping_local[0]['price'];
										$shipping_local_return['s_price'] = $shipping_local[0]['s_price'];
										$shipping_local_return['title'] = $shipping_local[0]['title'];
										if($shipping_local_return['origin_price']==0){
											$is_show_free = true;
										}
										$_SESSION['shipping'] = array('id' => $shipping_local[0]['methods'].'_'.$shipping_local[0]['methods'],

											'title' => $quotes[$shipping_local[0]['methods']]['methods'][0]['title'],

											'cost' => $quotes[$shipping_local[0]['methods']]['methods'][0]['cost']);
									}
								}
								$order = new order();
								$vats =  $currencies->total_format_new($order->vat, true, $order->info['currency'], $order->info['currency_value']);;
								$local_total = $order->local_info['subtotal'];
								$change_shipping = array($local_total,$shipping_percent);
								$tel =  zen_get_contact_phone_number_ajax($use_address['entry_country']['country_code']);
								$data['tax_msg'] = $tax_msg;
								$data['is_de'] = $flag_status;
								$data['products'] = $products;
								$data['shipping_all'] = $shipping_all_return;
								$data['shipping_local'] = $shipping_local_return;
								$data['shipping_global'] = $shipping_global_return;
								$data['is_eu'] = $is_eu;
								$data['country_id'] =$country_id ;
								$data['tel'] = $tel;
								$data['is_vax'] = $order->is_vax;
								$data['is_ru'] = $is_ru;
								$data['shipping_data']=$shipping_data;
								$data['is_cn_vax']=$is_cn_vax;
								$data['is_show_free'] = $is_show_free;
								$data['is_need_transhipment'] = $is_need_transhipment;
								$data['change_shipping'] = $change_shipping;
								$data['tax_cost'] = $vats;
								echo json_encode($data);
								break;
						}
					}
				}
			break;

			//add by aron 8.9

			case 'set_create_account_new':


				$entry_firstname = ($_POST['entry_firstname']);

				$entry_lastname = ($_POST['entry_lastname']);

				$entry_company = ($_POST['entry_company']);

				$entry_street_address = ($_POST['entry_street_address']);

				$entry_suburb = ($_POST['entry_suburb']);

				$entry_city = ($_POST['entry_city']);

				$entry_country_id = ($_POST['entry_country_id']);

				$entry_state = ($_POST['entry_state']);

				$shipping_us_state = ($_POST['shipping_us_state']);

				$customers_country_id = $entry_country_id;

				if($_POST['entry_country_id'] == 223){

					$entry_state =  $shipping_us_state;

				}
				$entry_postcode = ($_POST['entry_postcode']);

				$entry_telephone = ($_POST['entry_telephone']);

				$email_address = ($_POST['entry_email']);
				if(!empty($_POST['entry_email_regist'])){
					$email_address = $_POST['entry_email_regist'];
				}
				$password1 = ($_POST['password1']);
				$password2 = ($_POST['password2']);
				//RSA后台解密
				$password1 = zen_get_rsa_decrypt_password($password1);
				$password2 = zen_get_rsa_decrypt_password($password2);

				$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
				$http_user_agent =$_SERVER["HTTP_USER_AGENT"];
				//$user_ip_address =$_SERVER["REMOTE_ADDR"];
				$user_ip_address = getCustomersIP();

				$sendto = $_SESSION['sendto'] > 0  ? $_SESSION['sendto']:$_SESSION['sendtoG'];
				$sql_data_array = array (
					'customers_firstname' => zen_db_prepare_input($entry_firstname),
					'customers_lastname' =>  zen_db_prepare_input($entry_lastname),
					'customers_email_address' => $email_address,
					'customers_telephone' => zen_db_prepare_input($entry_telephone),
					'customers_newsletter' => 1,
					'customers_email_format' => $email_format,
					'customers_default_address_id' => 0,
					'customers_password' => zen_encrypt_password ( $password1 ),
					'customers_authorization' => ( int ) CUSTOMERS_APPROVAL_AUTHORIZATION,
					'language_id' => (int)$_SESSION['languages_id'],
                    'language_code'=>$_SESSION['languages_code'], // fairy 2019.2.22 add
					'customer_country_id'=>$entry_country_id,
					'hear_us' =>'',
					'customers_default_address_id' => $sendto,
					'customer_other_content'=>'',
					'http_user_agent' =>$http_user_agent,
					'user_ip_address' =>$user_ip_address,
					'customers_regist_from' => 'guest',
					'email_is_active' => '1',   // fairy 2017.10.30 通过下单来的用户，默认为已激活
                    'customers_info_date_account_created' => date('Y-m-d H:i:s'),   // fairy 2017.8.17 增加注册时间
				);


				if (strlen ( $email_address ) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
					$error = true;
					//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_ERROR );
					echo ENTRY_EMAIL_ADDRESS_ERROR;exit;
				} else if (zen_validate_email ( $email_address ) == false) {
					$error = true;
					//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
					echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR;exit;
				} else {
					$check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
							 where customers_email_address = '" .  $email_address . "'";
					$check_email = $db->Execute ( $check_email_query );
					if ($check_email->fields['total'] > 0){
						$error = true;
						$login_in = "   <a href='/login.html'>".REGITS_FROM_GUEST_EXSIT2."</a>";
						$html= REGITS_FROM_GUEST_EXSIT1.$login_in;
						echo $html;
						exit;
						//echo 'Our system already has a record of that email address - please try logging in with that email address,If you do not use that address any longer you can correct it in the My Account area.';exit;
						//$messageStack->add_session ( FILENAME_REGIST,'<div id="fiberstore_message" class="tishi_02 display_none">Our system already has a record of that email address - please try logging in with that email address.<br /> If you do not use that address any longer you can correct it in the My Account area.</div>' );
						$email_address = zen_db_prepare_input($email_address);
						$password = zen_db_prepare_input($password1);


						// Check if email exists
						$check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
																										customers_email_address, customers_default_address_id,
																										customers_authorization, customers_referral
																							   FROM " . TABLE_CUSTOMERS . "
																							   WHERE customers_email_address = :emailAddress";

						$check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
						$check_customer = $db->Execute($check_customer_query);


						if ($check_customer->RecordCount() < 1) {

							exit(FS_LOGIN_EMAIL_ERROR);
						}
						elseif ($check_customer->fields['customers_authorization'] == '4') {
							exit(TEXT_LOGIN_BANNED);
						}else {
							// Check that password is good
							if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
								exit('Password input error');
							}else {
								if (SESSION_RECREATE == 'True') {
									zen_session_recreate();
								}

								$_SESSION['customer_id'] = $check_customer->fields['customers_id'];
								$_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
								$_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
								$_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
								$_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
								$_SESSION['customers_email_address'] = $check_customer->fields['customers_email_address'];

                                // fairy 2017.10.30 下单之后，默认激活
                                $db->Execute("update customers set email_is_active = '1' where customers_id='".(int)$_SESSION['customer_id']."'");

								get_customers_member_level();

								$LoginRember = zen_db_prepare_input($_POST['LoginRember']);

								$_SESSION['name'] = $check_customer->fields['customers_firstname'] .' '. $check_customer->fields['customers_lastname'];

								$last_address=='';
								$sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
																				  SET customers_info_date_of_last_logon = now(),
																				customers_info_address_of_last_logon = '".$last_address."',
																					  customers_info_number_of_logons = customers_info_number_of_logons+1
																				  WHERE customers_info_id = :customersID";

								$sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
								$db->Execute($sql);


                                // fairy 添加登录信息
                                zen_insert_one_customers_login($_SESSION['customer_id'],'ajax_process_other_requests/set_create_account_new/1');
                                // fairy 判断设备是否是异地登录
                                if($last_customers_login_id && isOffsiteLogin($last_customers_login_id)){
                                    $email_username = $check_customer->fields['customers_firstname'].' '.$check_customer->fields['customers_lastname'];
                                    sendOffsiteLogin($check_customer->fields['customers_email_address'],$email_username);
                                    $sql = 'update customers_login set has_send_email = 1 where customers_login_id="'.$last_customers_login_id.'"';
                                    $db->Execute($sql);
                                }

								$db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where address_book_id='".$_SESSION['sendto']."'");
								$list = $db->getAll("select guest_id from customer_of_guest where email_address = '".$email_address."' order by guest_id DESC limit 1");
								if($list){
									$db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where customers_guest_id='".$list[0]['guest_id']."'");
									$db->Execute("update orders set customers_id = '".$_SESSION['customer_id']."' where guest_id='".$list[0]['guest_id']."'");
								}

								if (SHOW_SHOPPING_CART_COMBINED > 0) {
									$zc_check_basket_before = $_SESSION['cart']->count_contents();
								}

								$_SESSION['cart']->restore_contents();

							}

						}


					}else{
//                        $allot_type =  'visitor_order';
//						require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
//						if($admin_id){
							//邮箱匹配到了 标记老客户 用于统计
//							$sql_data_array ['is_old'] = $is_old;
//						}

						zen_db_perform (TABLE_CUSTOMERS, $sql_data_array );
						$_SESSION['customer_id'] = $db->Insert_ID();
						$cid = $db->insert_ID();
						$db->Execute("update customer_of_guest set customers_id = '".$_SESSION['customer_id']."' where guest_id='".$_SESSION['customers_guest_id']."'");
						if($admin_id){
							$customers_id=$cid;
                            $date = get_common_cn_time();
							$sql='INSERT INTO admin_to_customers(admin_id,customers_id,add_time,create_time) VALUE("'.$admin_id.'","'.$customers_id.'","'.$date.'","'.time().'")';
							$db->Execute($sql);
							$sales_email = zen_admin_email_of_id($admin_id);
							$html=zen_get_corresponding_languages_email_common();
							$html_msg['EMAIL_HEADER'] = $html['html_header'];
							$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
							$html_msg['CUSTOMER_NAME'] = $entry_firstname.$entry_lastname ? $entry_firstname.$entry_lastname : 'not set yet';
							$html_msg['NUMBER'] = $telephone ? $telephone : 'not set yet';
							$html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
							zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', EMAIL_FROM, $html_msg, 'regist_to_us');

						}
						$db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where address_book_id='".$sendto."'");
						$list = $db->getAll("select guest_id from customer_of_guest where guest_id = '".$SESSION['customers_guest_id']."' order by guest_id DESC limit 1");
						if($list){
							$db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where customers_guest_id='".$list[0]['guest_id']."'");
							$db->Execute("update orders set customers_id = '".$_SESSION['customer_id']."' where guest_id='".$list[0]['guest_id']."'");
						}

						require_once DIR_WS_CLASSES .'set_cookie.php';
						$Encryption = new Encryption;
						$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
						//$cookie_customer_decrypt = $Encryption->_decrypt($cookie_customer_encrypt);
						setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/");

						$_SESSION['cart']->restore_contents();

						$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created, customers_info_date_of_last_logon)
								values ('" . ( int ) $_SESSION['customer_id'] . "', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";

						$db->Execute ( $sql );


                        // fairy 添加登录信息
                        zen_insert_one_customers_login($_SESSION['customer_id'],'ajax_process_other_requests/set_create_account_new/2');

						if (SESSION_RECREATE == 'True') {
							zen_session_recreate ();
						}

						$_SESSION ['customer_first_name'] = $entry_firstname;
						$_SESSION ['customer_default_address_id'] = $address_id;
						$_SESSION ['customer_country_id'] = $country;
						$_SESSION ['customer_zone_id'] = $zone_id;
						$_SESSION ['customers_authorization'] = $customers_authorization;
						$_SESSION ['name'] = $entry_firstname;

						$_SESSION['customers_email_address'] = $email_address;

						$html_msg = array();
						$html=zen_get_corresponding_languages_email_common();
						$html_msg['EMAIL_HEADER'] = $html['html_header'];
						$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
						$html_msg['EMAIL_BODY_COMMON_DEAR'] = EMAIL_BODY_COMMON_DEAR;
						$html_msg ['EMAIL_FIRST_NAME'] = $entry_firstname;
						$html_msg ['EMAIL_LAST_NAME'] = $entry_lastname;
						$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT1'] = EMAIL_REGIST_TO_CUSTOMER_TEXT1;
						$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT2'] = EMAIL_REGIST_TO_CUSTOMER_TEXT2;
						$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT3'] = EMAIL_REGIST_TO_CUSTOMER_TEXT3;

						$email_text .= EMAIL_WELCOME;
						$email_text .=' Fiberstore ';



						$email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;

						$email_text .= "\n\n" . sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS ) . "\n\n";
						// 		$html_msg ['EMAIL_DISCLAIMER'] = sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>' );
						if (!defined('EMAIL_SUBJECT')) {
							//define('EMAIL_SUBJECT', 'Congratulations, you have a new account on FiberStore.com');
						}
						// send welcome email
						if (trim ( EMAIL_SUBJECT ) != 'n/a')
							//zen_mail ( $customer_name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );
							$send_to_email = 'support@fiberstore.com';
						zen_mail_contact_us_or_bulk_order_inquiry($customer_name, $email_address, EMAIL_REGIST_TO_CUSTOMER_SUBJECT, $email_text, STORE_NAME, $send_to_email, $html_msg,'regist_to_customer');

						$_SESSION['regist_success'] = rand(0,1000);


					}
				}
				exit('ok');
			break;


				case 'set_create_account':


										$entry_firstname = ($_POST['billing_firstname']);

										$entry_lastname = ($_POST['billing_lastname']);

										$entry_company = ($_POST['billing_company']);

										$entry_street_address = ($_POST['billing_street_address']);

										$entry_suburb = ($_POST['billing_suburb']);

										$entry_city = ($_POST['billing_city']);

										$entry_country_id = ($_POST['billing_country_id']);

										$entry_state = ($_POST['billing_state']);

										$billing_us_state = ($_POST['billing_us_state']);

										$customers_country_id = $entry_country_id;

										if($_POST['billing_country_id'] == 223){

											$entry_state =  $billing_us_state;

										}

										$entry_postcode = ($_POST['billing_postcode']);

										$entry_telephone = ($_POST['billing_telephone']);

										$email_address = ($_POST['email_address']);

										$password1 = ($_POST['password1']);
										$password2 = ($_POST['password2']);


				$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
				$http_user_agent =$_SERVER["HTTP_USER_AGENT"];
				//$user_ip_address =$_SERVER["REMOTE_ADDR"];
				$user_ip_address = getCustomersIP();

				$billto = $_SESSION['billto'] > 0  ? $_SESSION['billto']:$_SESSION['billtoG'];
				$sql_data_array = array (
		        'customers_firstname' => zen_db_prepare_input($entry_firstname),
				'customers_lastname' =>  zen_db_prepare_input($entry_lastname),
				'customers_email_address' => $email_address,
				'customers_telephone' => zen_db_prepare_input($entry_telephone),
				'customers_newsletter' => 1,
				'customers_email_format' => $email_format,
				'customers_default_address_id' => 0,
				'customers_password' => zen_encrypt_password ( $password1 ),
				'customers_authorization' => ( int ) CUSTOMERS_APPROVAL_AUTHORIZATION,
				'language_id' => (int)$_SESSION['languages_id'],
                'language_code'=>$_SESSION['languages_code'], // fairy 2019.2.22 add
		        'customer_country_id'=>$entry_country_id,
		        'hear_us' =>'',
				'customers_default_billing_address_id' => $billto,
		        'customer_other_content'=>'',
		        'http_user_agent' =>$http_user_agent,
		        'user_ip_address' =>$user_ip_address,
		        'customers_regist_from' => 'guest',
                'customers_info_date_account_created' => date("Y-m-d H:i:s"),
					);


	if (strlen ( $email_address ) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
					$error = true;
					//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_ERROR );
					echo ENTRY_EMAIL_ADDRESS_ERROR;exit;
				} else if (zen_validate_email ( $email_address ) == false) {
					$error = true;
					//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
					echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR;exit;
				} else {
					$check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
							 where customers_email_address = '" .  $email_address . "'";
					$check_email = $db->Execute ( $check_email_query );
					if ($check_email->fields['total'] > 0){
						$error = true;
						//echo 'Our system already has a record of that email address - please try logging in with that email address,If you do not use that address any longer you can correct it in the My Account area.';exit;
						//$messageStack->add_session ( FILENAME_REGIST,'<div id="fiberstore_message" class="tishi_02 display_none">Our system already has a record of that email address - please try logging in with that email address.<br /> If you do not use that address any longer you can correct it in the My Account area.</div>' );
																		$email_address = zen_db_prepare_input($email_address);
																	  $password = zen_db_prepare_input($password1);


																		// Check if email exists
																		$check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
																										customers_email_address, customers_default_address_id,
																										customers_authorization, customers_referral
																							   FROM " . TABLE_CUSTOMERS . "
																							   WHERE customers_email_address = :emailAddress";

																		$check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
																		$check_customer = $db->Execute($check_customer_query);


																		if ($check_customer->RecordCount() < 1) {

																			exit(FS_LOGIN_EMAIL_ERROR);
																		}
																		 elseif ($check_customer->fields['customers_authorization'] == '4') {
																			exit(TEXT_LOGIN_BANNED);
																		}else {
																		  // Check that password is good
																		  if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
																			   exit('Password input error');
																		  }else {
																			if (SESSION_RECREATE == 'True') {
																			  zen_session_recreate();
																			}

																			$_SESSION['customer_id'] = $check_customer->fields['customers_id'];
																			$_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
																			$_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
																			$_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
																			$_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
																			$_SESSION['customers_email_address'] = $check_customer->fields['customers_email_address'];

																			get_customers_member_level();

																			$LoginRember = zen_db_prepare_input($_POST['LoginRember']);

																			$_SESSION['name'] = $check_customer->fields['customers_firstname'] .' '. $check_customer->fields['customers_lastname'];

																	$last_address=='';
																			$sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
																				  SET customers_info_date_of_last_logon = now(),
																				customers_info_address_of_last_logon = '".$last_address."',
																					  customers_info_number_of_logons = customers_info_number_of_logons+1
																				  WHERE customers_info_id = :customersID";

																			$sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
																			$db->Execute($sql);


                                                                              // fairy 添加登录信息
                                                                              zen_insert_one_customers_login($_SESSION['customer_id'],'ajax_process_other_requests/set_create_account/1');
                                                                              // fairy 判断设备是否是异地登录
                                                                              if($last_customers_login_id && isOffsiteLogin($last_customers_login_id)){
                                                                                  $email_username = $check_customer->fields['customers_firstname'].' '.$check_customer->fields['customers_lastname'];
                                                                                  sendOffsiteLogin($check_customer->fields['customers_email_address'],$email_username);
                                                                                  $sql = 'update customers_login set has_send_email = 1 where customers_login_id="'.$last_customers_login_id.'"';
                                                                                  $db->Execute($sql);
                                                                              }



																			 $db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where address_book_id='".$_SESSION['billto']."'");
																				$list = $db->getAll("select guest_id from customer_of_guest where email_address = '".$email_address."' order by guest_id DESC limit 1");
																			if($list){
																						 $db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where customers_guest_id='".$list[0]['guest_id']."'");
																						 $db->Execute("update orders set customers_id = '".$_SESSION['customer_id']."' where guest_id='".$list[0]['guest_id']."'");
																			}

																			if (SHOW_SHOPPING_CART_COMBINED > 0) {
																			  $zc_check_basket_before = $_SESSION['cart']->count_contents();
																			}

																			$_SESSION['cart']->restore_contents();

																			 }
																		}


					}else{

				require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                    $sql_data_array ['is_make_up'] = $is_make_up ? : 0;
                    $sql_data_array ['is_old'] = $is_old ? $is_old : 0;  // 标记新、老客户
                if($admin_id){
                    //邮箱匹配到了 标记老客户 用于统计
                    $sql_data_array ['is_old'] = $is_old;
                }
                zen_db_perform (TABLE_CUSTOMERS, $sql_data_array );
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
		       $html_msg['CUSTOMER_NAME'] = $entry_firstname.$entry_lastname ? $entry_firstname.$entry_lastname : 'not set yet';
		       $html_msg['NUMBER'] = $telephone ? $telephone : 'not set yet';
		       $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';
		 zen_mail($sales_email, $sales_email, 'Customer Info', $text_message, 'service@fiberstore.net', EMAIL_FROM, $html_msg, 'regist_to_us');

					}
				 $db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where address_book_id='".$_SESSION['billto']."'");
				$list = $db->getAll("select guest_id from customer_of_guest where email_address = '".$email_address."' order by guest_id DESC limit 1");
				if($list){
					 $db->Execute("update address_book set customers_id = '".$_SESSION['customer_id']."' where customers_guest_id='".$list[0]['guest_id']."'");
					 $db->Execute("update orders set customers_id = '".$_SESSION['customer_id']."' where guest_id='".$list[0]['guest_id']."'");
				}

					require_once DIR_WS_CLASSES .'set_cookie.php';
					$Encryption = new Encryption;
					$cookie_customer_encrypt = $Encryption->_encrypt($_SESSION['customer_id']);
					//$cookie_customer_decrypt = $Encryption->_decrypt($cookie_customer_encrypt);
					setcookie("fs_login_cookie",$cookie_customer_encrypt,time()+86400*300 ,"/");

					$_SESSION['cart']->restore_contents();

						$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created, customers_info_date_of_last_logon)
								values ('" . ( int ) $_SESSION['customer_id'] . "', '1', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";

									$db->Execute ( $sql );

                                    // fairy 添加登录信息
                                    zen_insert_one_customers_login($_SESSION['customer_id'],'ajax_process_other_requests/set_create_account/2');
									if (SESSION_RECREATE == 'True') {
										zen_session_recreate ();
									}

									$_SESSION ['customer_first_name'] = $entry_firstname;
									$_SESSION ['customer_default_address_id'] = $address_id;
									$_SESSION ['customer_country_id'] = $country;
									$_SESSION ['customer_zone_id'] = $zone_id;
									$_SESSION ['customers_authorization'] = $customers_authorization;
									$_SESSION ['name'] = $entry_firstname;

									$_SESSION['customers_email_address'] = $email_address;

									$html_msg = array();
									$html=zen_get_corresponding_languages_email_common();
									$html_msg['EMAIL_HEADER'] = $html['html_header'];
									$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
									$html_msg['EMAIL_BODY_COMMON_DEAR'] = EMAIL_BODY_COMMON_DEAR;
									$html_msg ['EMAIL_FIRST_NAME'] = $entry_firstname;
									$html_msg ['EMAIL_LAST_NAME'] = $entry_lastname;
									$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT1'] = EMAIL_REGIST_TO_CUSTOMER_TEXT1;
									$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT2'] = EMAIL_REGIST_TO_CUSTOMER_TEXT2;
									$html_msg['EMAIL_REGIST_TO_CUSTOMER_TEXT3'] = EMAIL_REGIST_TO_CUSTOMER_TEXT3;

									$email_text .= EMAIL_WELCOME;
									$email_text .=' Fiberstore ';

									

									$email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;

									$email_text .= "\n\n" . sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS ) . "\n\n";
							// 		$html_msg ['EMAIL_DISCLAIMER'] = sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>' );


									if (!defined('EMAIL_SUBJECT')) {
										//define('EMAIL_SUBJECT', 'Congratulations, you have a new account on FiberStore.com');
									}
									// send welcome email
									if (trim ( EMAIL_SUBJECT ) != 'n/a')
										//zen_mail ( $customer_name, $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );
									$send_to_email = 'support@fiberstore.com';
									zen_mail_contact_us_or_bulk_order_inquiry($customer_name, $email_address, EMAIL_REGIST_TO_CUSTOMER_SUBJECT, $email_text, STORE_NAME, $send_to_email, $html_msg,'regist_to_customer');

									$_SESSION['regist_success'] = rand(0,1000);


					}
				}
				exit('ok');
				break;

				case 'checkpassword':

						$email_address = ($_POST['email_address']);

										$password = ($_POST['password1']);

						$check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
																										customers_email_address, customers_default_address_id,
																										customers_authorization, customers_referral
																							   FROM " . TABLE_CUSTOMERS . "
																							   WHERE customers_email_address = :emailAddress";

																		$check_customer_query  =$db->bindVars($check_customer_query, ':emailAddress', $email_address, 'string');
																		$check_customer = $db->Execute($check_customer_query);


														
																		  if (!zen_validate_password($password, $check_customer->fields['customers_password'])) {
																			   exit('Password input error');
																		  }else{
																			   exit('ok');
																		  }

				break;
			case 'set_address':

				
			if (!isset($customer_info) || !is_object($customer_info)){

											require DIR_WS_CLASSES . 'customer_account_info.php';

									    	$customer_info = new customer_account_info();

										}


				if (isset($_POST['tag'])){


					/* set shipping address*/

					if (3 == intval($_POST['tag'])){

						$_SESSION['sendto'] = $_POST['address_book_id'];

					}elseif(10 == intval($_POST['tag'])){

						$billing_address_list = $customer_info->get_select_address($_SESSION['billto']);

						
						$entry_firstname = ($billing_address_list['entry_firstname']);

										$entry_lastname = ($billing_address_list['entry_lastname']);

										$entry_company = ($billing_address_list['entry_company']);

										$entry_street_address = ($billing_address_list['entry_street_address']);

										$entry_suburb = ($billing_address_list['entry_suburb']);

										$entry_city = ($billing_address_list['entry_city']);

										$entry_country_id = ($billing_address_list['entry_country']['entry_country_id']);

										$entry_state = ($billing_address_list['entry_state']);
				

										$entry_postcode = ($billing_address_list['entry_postcode']);

										$entry_telephone = ($billing_address_list['entry_telephone']);

										

										$shipping_address = array(

											'entry_company' => zen_db_prepare_input($entry_company),

											'entry_firstname' => zen_db_prepare_input($entry_firstname),

											'entry_lastname' => zen_db_prepare_input($entry_lastname),

											'entry_street_address' => zen_db_prepare_input($entry_street_address),

											'entry_suburb' => zen_db_prepare_input($entry_suburb),

											'entry_postcode' => zen_db_prepare_input($entry_postcode),

											'entry_state' => zen_db_prepare_input($entry_state),

											'entry_city' =>  zen_db_prepare_input($entry_city),

											'entry_country_id' => (int)$entry_country_id,

											'entry_telephone' => zen_db_prepare_input($entry_telephone)

										);


						$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($shipping_address);
						//$customer_info->set_new_shipping_address_bill($_SESSION['billto']);
						//$_SESSION['sendto'] = $_SESSION['billto'];
						exit;
				    }else{ 

						$entry_firstname = ($_POST['entry_firstname']);

						$entry_lastname = ($_POST['entry_lastname']);

						$entry_company = ($_POST['entry_company']);

						$entry_street_address = ($_POST['entry_street_address']);

						$entry_suburb = ($_POST['entry_suburb']);

						$entry_city = ($_POST['entry_city']);

						$entry_country_id = ($_POST['entry_country_id']);

						$entry_state = ($_POST['entry_state']);
						
						$company_type = $_POST['AddressType'];

						if($entry_country_id == 223){
							$entry_state = ($_POST['shipping_us_state']);
						}

						$entry_postcode = ($_POST['entry_postcode']);

						$entry_telephone = ($_POST['entry_telephone']);
						$entry_tax_number = $_POST['tax_number'];
						$shipping_address = array(

							'entry_company' => zen_db_prepare_input($entry_company),

							'entry_firstname' => zen_db_prepare_input($entry_firstname),

							'entry_lastname' => zen_db_prepare_input($entry_lastname),

							'entry_street_address' => zen_db_prepare_input($entry_street_address),

							'entry_suburb' => zen_db_prepare_input($entry_suburb),

							'entry_postcode' => zen_db_prepare_input($entry_postcode),

							'entry_state' => zen_db_prepare_input($entry_state),

							'entry_city' =>  zen_db_prepare_input($entry_city),

							'entry_country_id' => (int)$entry_country_id,

							'entry_zone_id' => (int)$entry_zone_id,

							'entry_telephone' => zen_db_prepare_input($entry_telephone),
							'entry_tax_number' => zen_db_prepare_input($entry_tax_number),
							'company_type' =>  zen_db_prepare_input($company_type)
						);

						switch (intval($_POST['tag'])){

							case 1:					

								//changed by Aron 2017.7.17
								if (!$customer_info->get_address_records()){
									$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($shipping_address);

								}else{
									$address_id = $customer_info->add_new_shipping_address($shipping_address);
								}


								$shipping_addresses = $customer_info->get_customers_shipping_address();

								if (sizeof($shipping_addresses)){

							        $address_string = '';

							        foreach ($shipping_addresses as $i => $address){

							            $address_string .= '"'.$address['address_book_id'].'":{"company_type":"'.$address['company_type'].'","entry_company":"'.$address['entry_company'].'","address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'","entry_tax_number":"'.$address['entry_tax_number'].'"},';

							        }

							        $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

						        }
								$addrss_content =  '"type":"insert","aid": "'.$address_id.'","addresses":'.$address_string.'';

								break;

							case 2:
										/*update exist shipping address*/

								$_SESSION['sendto'] = intval($_POST['address_book_id']);

								zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address,'update','address_book_id='.intval($_POST['address_book_id']));

								$db->Execute("update " . TABLE_CUSTOMERS . " 
							SET customers_default_address_id = " .$_SESSION['sendto'] ." 
							WHERE customers_id = ". intval($_SESSION['customer_id']));


								$shipping_addresses = $customer_info->get_customers_shipping_address();

								if (sizeof($shipping_addresses)){

							        $address_string = '';

							        foreach ($shipping_addresses as $i => $address){

							            $address_string .= '"'.$address['address_book_id'].'":{"company_type":"'.$address['company_type'].'","entry_company":"'.$address['entry_company'].'","address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'","entry_tax_number":"'.$address['entry_tax_number'].'"},';

							        }
							         $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';
						        }
								$addrss_content =  '"type":"update","aid":"'.intval($_POST['address_book_id']).'","addresses":'.$address_string.'';
								break;
						}

					}

								$total_weight = $_SESSION['cart']->show_weight();

				                require DIR_WS_CLASSES.'order.php';

				                $order = new order();

				                require DIR_WS_CLASSES.'shipping.php';

				                $shipping = new shipping($_SESSION['shipping']);

				                $order = new order();				                

				                require (DIR_WS_CLASSES.'order_total.php');

								$order_total_modules = new order_total();

								$order_totals = $order_total_modules->process();

				                $shipping = new shipping();

				                $quotes = $shipping->quote();

				                $fedex_cost = $currencies->value($quotes['fedexzones']['methods'][0]['cost']);

				                $dhl_cost = $currencies->value($quotes['dhlzones']['methods'][0]['cost']);

				                $airmail_cost = $currencies->value($quotes['airmailzones']['methods'][0]['cost']);
				                
				                $subtotal = $currencies->value($order->info['subtotal']);

				                switch ($_SESSION['shipping']['id']){

				                	case 'fedexzones_fedexzones':

				                		if ($fedex_cost){

				                		$current_shipping_cost = $fedex_cost;

				                		$_SESSION['shipping'] = array('id' => 'fedexzones_fedexzones',

										                                'title' => 'Fedex Rates',

										                                'cost' => $quotes['fedexzones']['methods'][0]['cost']);

				                		}

				                		break;

				                	case 'dhlzones_dhlzones':

				                		if ($dhl_cost){

				                			$current_shipping_cost = $dhl_cost;

				                			$_SESSION['shipping'] = array('id' => 'dhlzones_dhlzones',

				                					'title' => 'DHL Rates',

				                					'cost' => $quotes['dhlzones']['methods'][0]['cost']);

				                		}

				                		break;

				                	case 'airmailzones_airmailzones':

				                		if ($airmail_cost){

				                			$current_shipping_cost = $airmail_cost;
				                			$_SESSION['shipping'] = array('id' => 'airmailzones_airmailzones',
				                					'title' => 'Airmail Rates',
				                					'cost' => $quotes['airmailzones']['methods'][0]['cost']);
				                		}

				                		break;
				                }

				                if (!$current_shipping_cost)
				                	$all_fee = '"all_fee":{"error":"No shipping available to the selected country",';
				                else{ 
				                	$all_fee = '"all_fee":{"current_shipping":"'.$_SESSION['shipping']['id'].'","current_fee":"'.$current_shipping_cost.'",';
					                if ($fedex_cost) $all_fee .= '"fedex":"'.$fedex_cost.'",';
					                if ($dhl_cost) $all_fee  .= '"dhl":"'.$dhl_cost.'",';
					               	if ($airmail_cost) $all_fee .= '"airmail":"'.$airmail_cost.'",';
				                }

				               	$all_fee = substr($all_fee,0,strlen($all_fee)-1).'}';

				                if (isset($addrss_content) && $addrss_content){

				                	echo '{'.$addrss_content.','.$all_fee.'}';

				                }else {

				                	echo '{'.$all_fee.'}';

				                }
				}
				break;

	case 'set_guest_address':
				
			if (!isset($customer_info) || !is_object($customer_info)){

					require DIR_WS_CLASSES . 'customer_account_info.php';

					$customer_info = new customer_account_info();

			}

				if (isset($_POST['tag'])){

					/* set shipping address*/

					if (3 == intval($_POST['tag'])){

						$_SESSION['sendto'] = $_POST['address_book_id'];

					}elseif(10 == intval($_POST['tag'])){
						$customer_info->set_guest_shipping_address_bill($_SESSION['billtoG']);
						$_SESSION['sendtoG'] = $_SESSION['billtoG'];
						exit;
				    }else{ 

										$entry_firstname = ($_POST['entry_firstname']);

										$entry_lastname = ($_POST['entry_lastname']);
										
										$entry_company = ($_POST['entry_company']);

										$entry_street_address = ($_POST['entry_street_address']);

										$entry_suburb = ($_POST['entry_suburb']);

										$entry_city = ($_POST['entry_city']);

										$entry_country_id = ($_POST['entry_country_id']);

										$entry_state = ($_POST['entry_state']);

										if($entry_country_id == 223){
											$entry_state = ($_POST['shipping_us_state']);
										}

										$entry_postcode = ($_POST['entry_postcode']);

										$entry_telephone = ($_POST['entry_telephone']);

										

										$shipping_address = array(

											'entry_company' => zen_db_prepare_input($entry_company),

											'entry_firstname' => zen_db_prepare_input($entry_firstname),

											'entry_lastname' => zen_db_prepare_input($entry_lastname),

											'entry_street_address' => zen_db_prepare_input($entry_street_address),
												

											'entry_suburb' => zen_db_prepare_input($entry_suburb),

											'entry_postcode' => zen_db_prepare_input($entry_postcode),

											'entry_state' => zen_db_prepare_input($entry_state),

											'entry_city' =>  zen_db_prepare_input($entry_city),

											'entry_country_id' => (int)$entry_country_id,

											'entry_zone_id' => (int)$entry_zone_id,

											'entry_telephone' => zen_db_prepare_input($entry_telephone)

										);

								switch (intval($_POST['tag'])){

									case 1:					

										
											$_SESSION['sendtoG'] = $address_id = $customer_info->add_guest_shipping_address($shipping_address);


										//$db->Execute("update " .TABLE_CUSTOMERS . " set default_address_id = ".$address_id . " where customers_id = " .intval($_SESSION['customer_id']));

										

										$shipping_addresses = $customer_info->get_customers_shipping_address();


										break;

								

								}

					}

								

				               

				               

				                

					

				}

				break;


				case 'set_billing_address':

				if (isset($_POST['tag'])){
					/* set shipping address*/
					if (3 == intval($_POST['tag'])){

						$_SESSION['billto'] = $_POST['address_book_id'];

					}else{ 
								/*add new shipping address*/

					if (!isset($customer_info) || !is_object($customer_info)){

											require DIR_WS_CLASSES . 'customer_account_info.php';

									    	$customer_info = new customer_account_info();

					}
										
					$sql = "select customers_default_billing_address_id as id from customers where customers_id = ".(int)$_SESSION['customer_id'];
					$default_billing = $db->Execute($sql);
					if($default_billing->fields['id']){
					$customer_info->update_billing_address_type($default_billing->fields['id']);
					}
								
										$entry_firstname = ($_POST['billing_firstname']);

										$entry_lastname = ($_POST['billing_lastname']);

										$entry_company = ($_POST['billing_company']);

										$entry_street_address = ($_POST['billing_street_address']);

										$entry_suburb = ($_POST['billing_suburb']);

										$entry_city = ($_POST['billing_city']);

										$entry_country_id = ($_POST['billing_country_id']);

										$entry_state = ($_POST['billing_state']);
										$billing_us_state = ($_POST['billing_us_state']);

										if($_POST['billing_country_id'] == 223){

											$entry_state =  $billing_us_state;

										}

										$entry_postcode = ($_POST['billing_postcode']);

										$entry_telephone = ($_POST['billing_telephone']);


										$billing_address = array(
                                            'address_type' => 2,
											'entry_company' => zen_db_prepare_input($entry_company),

											'entry_firstname' => zen_db_prepare_input($entry_firstname),

											'entry_lastname' => zen_db_prepare_input($entry_lastname),
											
											

											'entry_street_address' => zen_db_prepare_input($entry_street_address),

											'entry_suburb' => zen_db_prepare_input($entry_suburb),

											'entry_postcode' => zen_db_prepare_input($entry_postcode),

											'entry_state' => zen_db_prepare_input($entry_state),

											'entry_city' =>  zen_db_prepare_input($entry_city),

											'entry_country_id' => (int)$entry_country_id,

											'entry_zone_id' => (int)$entry_zone_id,

											'entry_telephone' => zen_db_prepare_input($entry_telephone)

										);

								switch (intval($_POST['tag'])){

									case 1:					
										if ($customer_info->get_address_records()){

											$_SESSION['billto'] = $address_id = $customer_info->add_new_billing_address($billing_address);

										}else{

											//$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($billing_address);

											$_SESSION['billto'] = $address_id = $customer_info->add_new_billing_address($billing_address);

										}
										echo "ok";exit;
										$billing_addresses = $customer_info->get_customers_billing_address();

										if (sizeof($billing_addresses)){

							              $address_string = '';

							              foreach ($billing_addresses as $i => $address){

							               	$address_string .= '"'.$address['address_book_id'].'":{"address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_company":"'.$address['entry_company'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'"},';

							               }

							               $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

						                 }

										$addrss_content =  '"type":"insert","aid": "'.$address_id.'","addresses":'.$address_string.'';

										break;

									case 2:
/*update exist shipping address*/

										$_SESSION['billto'] = intval($_POST['address_book_id']);

										zen_db_perform(TABLE_ADDRESS_BOOK, $billing_address,'update','address_book_id='.intval($_POST['address_book_id']));

										$billing_addresses = $customer_info->get_customers_billing_address();

										if (sizeof($billing_addresses)){

							              $address_string = '';

							              foreach ($billing_addresses as $i => $address){

							               	$address_string .= '"'.$address['address_book_id'].'":{"address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_company":"'.$address['entry_company'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'"},';

							               }

							               $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

						               }

										$addrss_content =  '"type":"update","aid":"'.intval($_POST['address_book_id']).'","addresses":'.$address_string.'';

										break;

								}

					       }

				    }

				break;	
				




				/*
					add by aron 2017.7.17
					set_billing_address_checkout	
				 */
			case 'set_billing_address_checkout':

				if (isset($_POST['tag'])){
					/* set shipping address*/
					if (3 == intval($_POST['tag'])){

						$_SESSION['billto'] = $_POST['address_book_id'];

					}else{
						/*add new shipping address*/

						if (!isset($customer_info) || !is_object($customer_info)){

							require DIR_WS_CLASSES . 'customer_account_info.php';

							$customer_info = new customer_account_info();

						}
						$sql = "select customers_default_billing_address_id as id from customers where customers_id = ".(int)$_SESSION['customer_id'];
						$default_billing = $db->Execute($sql);
						if($default_billing->fields['id']){
							$customer_info->update_billing_address_type($default_billing->fields['id']);
						}

						$entry_firstname = ($_POST['entry_firstname']);

						$entry_lastname = ($_POST['entry_lastname']);

						$entry_company = ($_POST['entry_company']);

						$entry_street_address = ($_POST['entry_street_address']);

						$entry_suburb = ($_POST['entry_suburb']);

						$entry_city = ($_POST['entry_city']);

						$entry_country_id = ($_POST['entry_country_id']);

						$entry_state = ($_POST['entry_state']);
						$billing_us_state = ($_POST['shipping_us_state']);

						if($_POST['entry_country_id'] == 223){

							$entry_state =  $billing_us_state;

						}

						$entry_postcode = ($_POST['entry_postcode']);

						$entry_telephone = ($_POST['entry_telephone']);
						$entry_tax_number = $_POST['tax_number'];

						$company_type = $_POST['AddressType'];
						$billing_address = array(
							'address_type' => 2,
							'entry_company' => zen_db_prepare_input($entry_company),

							'entry_firstname' => zen_db_prepare_input($entry_firstname),

							'entry_lastname' => zen_db_prepare_input($entry_lastname),



							'entry_street_address' => zen_db_prepare_input($entry_street_address),

							'entry_suburb' => zen_db_prepare_input($entry_suburb),

							'entry_postcode' => zen_db_prepare_input($entry_postcode),

							'entry_state' => zen_db_prepare_input($entry_state),

							'entry_city' =>  zen_db_prepare_input($entry_city),

							'entry_country_id' => (int)$entry_country_id,

							'entry_zone_id' => (int)$entry_zone_id,

							'entry_telephone' => zen_db_prepare_input($entry_telephone),
							'entry_tax_number' => zen_db_prepare_input($entry_tax_number),
							'company_type' => zen_db_prepare_input($company_type)

						);

						switch (intval($_POST['tag'])){

							case 1:
								if ($customer_info->get_address_records()){

									$_SESSION['billto'] = $address_id = $customer_info->add_new_billing_address($billing_address);

								}else{

									//$_SESSION['sendto'] = $address_id = $customer_info->add_new_shipping_address($billing_address);

									$_SESSION['billto'] = $address_id = $customer_info->add_new_billing_address($billing_address);

								}
								echo "ok";exit;
								$billing_addresses = $customer_info->get_customers_billing_address();

								if (sizeof($billing_addresses)){

									$address_string = '';

									foreach ($billing_addresses as $i => $address){

										$address_string .= '"'.$address['address_book_id'].'":{"company_type":"'.$address['company_type'].'","address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_company":"'.$address['entry_company'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'","entry_tax_number":"'.$address['entry_tax_number'].'"},';

									}

									$address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

								}

								$addrss_content =  '"type":"insert","aid": "'.$address_id.'","addresses":'.$address_string.'';

								break;

							case 2:

								/*update exist shipping address*/

								$_SESSION['billto'] = intval($_POST['address_book_id']);

								zen_db_perform(TABLE_ADDRESS_BOOK, $billing_address,'update','address_book_id='.intval($_POST['address_book_id']));

								$billing_addresses = $customer_info->get_customers_billing_address();

								if (sizeof($billing_addresses)){

									$address_string = '';

									foreach ($billing_addresses as $i => $address){

										$address_string .= '"'.$address['address_book_id'].'":{"company_type":"'.$address['company_type'].'","address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_company":"'.$address['entry_company'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'","entry_tax_number":"'.$address['entry_tax_number'].'"},';

									}

									$address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

								}

								$addrss_content =  '{"type":"update","aid":"'.intval($_POST['address_book_id']).'","addresses":'.$address_string.'}';
								echo $addrss_content;
								break;

						}

					}

				}

				break;		
			//add by aron 8.9
			case "set_defalut_billing_guest_address_new_customer":

				require DIR_WS_CLASSES . 'customer_account_info.php';
				$customer_info = new customer_account_info();
				$is_form = (int)$_POST['is_form'];

				if($is_form != 1){
					$shipping_address = $customer_info->get_select_address($_SESSION['sendtoG']);
					$address = array(
						'address_type' => 2,
						'entry_company' =>	$shipping_address['entry_company'] ,

						'entry_firstname' => $shipping_address['entry_firstname'],

						'entry_lastname' => $shipping_address['entry_lastname'],

						'entry_street_address' => $shipping_address['entry_street_address'],

						'entry_suburb' => $shipping_address['entry_suburb'],

						'entry_postcode' => $shipping_address['entry_postcode'],

						'entry_state' => $shipping_address['entry_state'],

						'entry_city' => $shipping_address['entry_city'],

						'entry_country_id' => $shipping_address['entry_country']['entry_country_id'],

						'entry_zone_id' => $shipping_address['entry_zone_id'],

						'entry_telephone' => $shipping_address['entry_telephone'],
						'entry_tax_number'=> $shipping_address['entry_tax_number'],
						'company_type' => $shipping_address['company_type']
					);
					$_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address_new($address);
					echo json_encode(array("msg"=>"success","address"=>$address,"country_name"=>$shipping_address['entry_country'],"aid"=>$address_id));
				}else{

					$entry_firstname = ($_POST['billing_firstname']);

					$entry_lastname = ($_POST['billing_lastname']);

					$entry_company = ($_POST['billing_company']);

					$entry_street_address = ($_POST['billing_street_address']);

					$entry_suburb = ($_POST['billing_suburb']);

					$entry_city = ($_POST['billing_city']);

					$entry_country_id = ($_POST['billing_country_id']);

					$entry_state = ($_POST['billing_state']);
					$billing_us_state = ($_POST['billing_us_state']);
					
					$company_type = $_POST['AddressType'];
					if($_POST['billing_country_id'] == 223){

						$entry_state =  $billing_us_state;

					}

					$entry_postcode = ($_POST['billing_postcode']);

					$entry_telephone = ($_POST['billing_telephone']);
					$entry_tax_number = $_POST['tax_number'];

					$billing_address = array(
						'address_type' => 2,
						'entry_company' => zen_db_prepare_input($entry_company),

						'entry_firstname' => zen_db_prepare_input($entry_firstname),

						'entry_lastname' => zen_db_prepare_input($entry_lastname),



						'entry_street_address' => zen_db_prepare_input($entry_street_address),

						'entry_suburb' => zen_db_prepare_input($entry_suburb),

						'entry_postcode' => zen_db_prepare_input($entry_postcode),

						'entry_state' => zen_db_prepare_input($entry_state),

						'entry_city' =>  zen_db_prepare_input($entry_city),

						'entry_country_id' => (int)$entry_country_id,

						'entry_zone_id' => (int)$entry_zone_id,
						'company_type' =>zen_db_prepare_input($company_type),
						'entry_telephone' => zen_db_prepare_input($entry_telephone),
						'entry_tax_number'=> zen_db_prepare_input($entry_tax_number)

					);
					$_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address_new($billing_address);
					echo json_encode(array("msg=>success","billing_id"=>$address_id));
				}
				break;
			//add ny aron 2017.8.9  async shpping_address to billing address
			case 'async_billing_guest':
				$email = zen_db_prepare_input($_POST['email']);
				$billing_id = (int)$_POST['billing_id'];
				$re = $db->getAll("select customers_default_billing_address_id from customer_of_guest where email_address = '".trim($email)."' order by guest_id DESC limit 1");
				if(!$re[0]['customers_default_billing_address_id']){
					if (!isset($customer_info) || !is_object($customer_info)){

						require DIR_WS_CLASSES . 'customer_account_info.php';

						$customer_info = new customer_account_info();

					}
					$customer_info = new customer_account_info();
					$shipping_address = $customer_info->get_select_address($billing_id);

					$address = array(
						'address_type' => 2,
						'entry_company' =>	$shipping_address['entry_company'] ,

						'entry_firstname' => $shipping_address['entry_firstname'],

						'entry_lastname' => $shipping_address['entry_lastname'],

						'company_type'=> $shipping_address['company_type'],

						'entry_street_address' => $shipping_address['entry_street_address'],

						'entry_suburb' => $shipping_address['entry_suburb'],

						'entry_postcode' => $shipping_address['entry_postcode'],

						'entry_state' => $shipping_address['entry_state'],

						'entry_city' => $shipping_address['entry_city'],

						'entry_country_id' => $shipping_address['entry_country']['entry_country_id'],

						'entry_zone_id' => $shipping_address['entry_zone_id'],
						'entry_tax_number'=> $shipping_address['entry_tax_number'],
						'entry_telephone' => $shipping_address['entry_telephone']
					);
					$_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address_new($address);
					echo json_encode(array("msg"=>"success",'billing_id'=>$address_id));
				}else{
					echo json_encode(array("msg"=>"exit",'billing_id'=>$address_id));
				}

			break;		
			//update  guest billing address add by Aron 8.9
			case "update_billing_address_guest":
				if (!isset($customer_info) || !is_object($customer_info)){

					require DIR_WS_CLASSES . 'customer_account_info.php';

					$customer_info = new customer_account_info();

				}
				$billing_id =  (int)$_POST['address_book_id'];
				$entry_firstname = ($_POST['bill_firstname']);

				$entry_lastname = ($_POST['bill_lastname']);

				$entry_company = ($_POST['bill_company']);

				$entry_street_address = ($_POST['bill_street_address']);

				$entry_suburb = ($_POST['bill_entry_suburb']);

				$entry_city = ($_POST['bill_city']);

				$entry_country_id = ($_POST['bill_country_id']);

				$entry_state = ($_POST['bill_state']);

				if($entry_country_id == 223){
					$entry_state = ($_POST['bill_us_state']);
				}

				$entry_postcode = ($_POST['bill_entry_postcode']);

				$entry_telephone = ($_POST['bill_telephone']);
				$entry_tax_number = $_POST['edit_tax_number'];
				$company_type = $_POST['AddressType'];

				$shipping_address = array(

					'entry_company' => zen_db_prepare_input($entry_company),

					'entry_firstname' => zen_db_prepare_input($entry_firstname),

					'entry_lastname' => zen_db_prepare_input($entry_lastname),

					'entry_street_address' => zen_db_prepare_input($entry_street_address),

					'entry_suburb' => zen_db_prepare_input($entry_suburb),

					'entry_postcode' => zen_db_prepare_input($entry_postcode),

					'entry_state' => zen_db_prepare_input($entry_state),

					'entry_city' =>  zen_db_prepare_input($entry_city),

					'entry_country_id' => (int)$entry_country_id,

					'entry_zone_id' => (int)$entry_zone_id,

					'entry_telephone' => zen_db_prepare_input($entry_telephone),
					'entry_tax_number' => zen_db_prepare_input($entry_tax_number),
					'company_type' => zen_db_prepare_input($company_type)

				);
				$bool=zen_db_perform(TABLE_ADDRESS_BOOK, $shipping_address,'update','address_book_id = '.$billing_id);
				if($bool){
					echo json_encode(array("msg"=>"success"));
				}
			break;


	case 'set_guest_billing_address':

		if (isset($_POST['tag'])){
				
				/*add new shipping address*/

					if (!isset($customer_info) || !is_object($customer_info)){

											require DIR_WS_CLASSES . 'customer_account_info.php';

									    	$customer_info = new customer_account_info();

					}
					/*					
					$sql = "select customers_default_billing_address_id as id from customers where customers_id = ".(int)$_SESSION['customer_id'];
					$default_billing = $db->Execute($sql);
					if($default_billing->fields['id']){
					$customer_info->update_billing_address_type($default_billing->fields['id']);
					}
					*/
								
										$entry_firstname = ($_POST['billing_firstname']);

										$entry_lastname = ($_POST['billing_lastname']);

										$entry_company = ($_POST['billing_company']);

										$entry_street_address = ($_POST['billing_street_address']);

										$entry_suburb = ($_POST['billing_suburb']);

										$entry_city = ($_POST['billing_city']);

										$entry_country_id = ($_POST['billing_country_id']);

										$entry_state = ($_POST['billing_state']);

										$billing_us_state = ($_POST['billing_us_state']);

										if($_POST['billing_country_id'] == 223){

											$entry_state =  $billing_us_state;

										}

									$entry_postcode = ($_POST['billing_postcode']);

										$entry_telephone = ($_POST['billing_telephone']);


										$email_address = ($_POST['email_address']);


										if (strlen ( $email_address ) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
											$error = true;
											//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_ERROR );
											echo ENTRY_EMAIL_ADDRESS_ERROR;exit;
										} else if (zen_validate_email ( $email_address ) == false) {
											$error = true;
											//$messageStack->add_session (FILENAME_REGIST, ENTRY_EMAIL_ADDRESS_CHECK_ERROR );
											echo ENTRY_EMAIL_ADDRESS_CHECK_ERROR;exit;
										} else {
											$check_email_query = "select count(customers_id) as total         from " . TABLE_CUSTOMERS . "
													 where customers_email_address = '" .  $email_address . "'";
											$check_email = $db->Execute ( $check_email_query );
											if ($check_email->fields['total'] > 0){
												$error = true;
												$login_in = "   <a href='/login.html'>Login in »</a>";
												echo 'Our system already has a record of that email address . Please try logging in with that email address . &nbsp;&nbsp;&nbsp;&nbsp;'.$login_in;exit;
												//$messageStack->add_session ( FILENAME_REGIST,'<div id="fiberstore_message" class="tishi_02 display_none">Our system already has a record of that email address - please try logging in with that email address.<br /> If you do not use that address any longer you can correct it in the My Account area.</div>' );
											}
										}
										$billing_address = array(

                                            'address_type' => 2,

											'entry_company' => zen_db_prepare_input($entry_company),

											'entry_firstname' => zen_db_prepare_input($entry_firstname),

											'entry_lastname' => zen_db_prepare_input($entry_lastname),																						

											'entry_street_address' => zen_db_prepare_input($entry_street_address),

											'entry_suburb' => zen_db_prepare_input($entry_suburb),

											'entry_postcode' => zen_db_prepare_input($entry_postcode),

											'entry_state' => zen_db_prepare_input($entry_state),

											'entry_city' =>  zen_db_prepare_input($entry_city),

											'entry_country_id' => (int)$entry_country_id,

											'entry_zone_id' => (int)$entry_zone_id,

											'entry_telephone' => zen_db_prepare_input($entry_telephone)

										);

										$customer_guest = array(
											
											'email_address' => $email_address,

											'first_name' => $entry_firstname,

											'last_name' => $entry_lastname,

											'customer_country_id' => (int)$entry_country_id,

											'add_time' => date('Y-m-d H:i:s')
										
										);
									
								switch (intval($_POST['tag'])){

									case 1:					
						
										$_SESSION['billtoG'] = $address_id = $customer_info->add_guest_billing_address($billing_address,$customer_guest);

											echo "ok";exit;
										$billing_addresses = $customer_info->get_customers_billing_address();

										if (sizeof($billing_addresses)){

							              $address_string = '';

							              foreach ($billing_addresses as $i => $address){

							               	$address_string .= '"'.$address['address_book_id'].'":{"address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_company":"'.$address['entry_company'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'"},';

							               }

							               $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

						                 }

										$addrss_content =  '"type":"insert","aid": "'.$address_id.'","addresses":'.$address_string.'';

										break;

									case 2:

										$_SESSION['billtoG'] = intval($_POST['address_book_id']);

										zen_db_perform(TABLE_ADDRESS_BOOK, $billing_address,'update','address_book_id='.intval($_POST['address_book_id']));

										$billing_addresses = $customer_info->get_customers_billing_address();

										if (sizeof($billing_addresses)){

							              $address_string = '';

							              foreach ($billing_addresses as $i => $address){

							               	$address_string .= '"'.$address['address_book_id'].'":{"address_book_id":"'.$address['address_book_id'].'","entry_firstname":"'.$address['entry_firstname'].'","entry_lastname":"'.$address['entry_lastname'].'","entry_street_address":"'.$address['entry_street_address'].'","entry_suburb":"'.$address['entry_suburb'].'","entry_city":"'.$address['entry_city'].'","entry_country":{"entry_country_id":"'.$address['entry_country']['entry_country_id'].'","entry_country_name":"'.$address['entry_country']['entry_country_name'].'"},"entry_state":"'.$address['entry_state'].'","entry_zone_id":"'.$address['entry_zone_id'].'","entry_postcode":"'.$address['entry_postcode'].'","entry_telephone":"'.$address['entry_telephone'].'"},';

							               }

							               $address_string = '{"data":{'.substr($address_string, 0, (strlen($address_string)-1)).'}}';

						               }

										$addrss_content =  '"type":"update","aid":"'.intval($_POST['address_book_id']).'","addresses":'.$address_string.'';

										break;
								}
				    }
				break;	

			case 'add_shipping_address':

				if (!isset($customer_info) || !is_object($customer_info)){

					require DIR_WS_CLASSES . 'customer_account_info.php';

			    	$customer_info = new customer_account_info();

				}
				$entry_firstname = ($_POST['entry_firstname']);

				$entry_lastname = ($_POST['entry_lastname']);

				$entry_street_addresss = ($_POST['entry_street_addresss']);

				$entry_suburb = ($_POST['entry_suburb']);

				$entry_city = ($_POST['entry_city']);

				$entry_country_id = ($_POST['entry_country_id']);

				$entry_state = ($_POST['entry_state']);

				$entry_postcode = ($_POST['entry_postcode']);

				$entry_telephone = ($_POST['entry_telephone']);

				

				$shipping_address = array(

					'entry_company' => zen_db_prepare_input($entry_company),

					'entry_firstname' => zen_db_prepare_input($entry_firstname),

					'entry_lastname' => zen_db_prepare_input($entry_lastname),

					'entry_street_address' => zen_db_prepare_input($entry_street_address),

					'entry_suburb' => zen_db_prepare_input($entry_suburb),

					'entry_postcode' => zen_db_prepare_input($entry_postcode),

					'entry_state' => zen_db_prepare_input($entry_state),

					'entry_city' =>  zen_db_prepare_input($entry_city),

					'entry_country_id' => (int)$entry_country_id,

					'entry_zone_id' => (int)$entry_zone_id,

					'entry_telephone' => zen_db_prepare_input($entry_telephone)

				);

				$customer_info->add_new_shipping_address($shipping_address);				

				break;

			case 'change_shipping':
				require (DIR_WS_CLASSES.'payment.php');
				$shipping_method = $_POST['shipping'];
				
                $shipping_code = $_POST['shipping_code'];
				
				require (DIR_WS_CLASSES.'order.php');
				$payment = new payment($_SESSION['payment']);
				$order = new order();
				$delay_content = array();
				$local_sub_text = $currencies->total_format_new($order->local_info['subtotal'], true, $order->info['currency'], $order->info['currency_value']);
				if($order->local_warehouse==37&&!empty($order->delay_info['products_arr'])&&$local_sub_text>99){
					foreach ($order->delay_products as $k=>$v){
						$delay_content[$v['id']] = $v['qty'];
					}
					$_SESSION['cart']->calculate_for_separate($delay_content);
					$total_weight = $_SESSION['cart']->weight;
				}else{
					$total_weight = $_SESSION['cart']->show_weight();
				}
				
				require (DIR_WS_CLASSES.'shipping.php');
				
				$shipping = new shipping();
				
				$init_quote = $shipping->quote($shipping_method,$shipping_method);
		
				
				$_SESSION['shipping'] = array('id' => $shipping_method.'_'.$shipping_method,

                                'title' => $init_quote[$shipping_method]['methods'][0]['title'],

                                'cost' => $init_quote[$shipping_method]['methods'][0]['cost']);
                $_SESSION['_choice'] = $shipping_code;
				$order = new order();
				$vat = $order->vat;
				$data = array(
					"cost"=>$currencies->new_value($init_quote[$shipping_method]['methods'][0]['cost']),
					"vat" => $currencies->total_format_new($order->vat, true, $order->info['currency'], $order->info['currency_value'])
				);
				echo json_encode($data);
				break;

			case 'display_shipping':

				$shipping_method = $_POST['shipping'];
				
                $shipping_code = $_POST['shipping_code'];
				
				require (DIR_WS_CLASSES.'order.php');
				
				$order = new order();
				
				$total_weight = $_SESSION['cart']->show_weight();
				
				require (DIR_WS_CLASSES.'shipping.php');
				
				$shipping = new shipping();
				
				$init_quote = $shipping->quote($shipping_method,$shipping_method);
				
				$_SESSION['shipping'] = array('id' => $shipping_method.'_'.$shipping_method,

                                'title' => $init_quote[$shipping_method]['methods'][0]['title'],

                                'cost' => $init_quote[$shipping_method]['methods'][0]['cost']);

				exit('{"cost":"'.$currencies->value($init_quote[$shipping_method]['methods'][0]['cost']).'"}');

				break;	

			case 'shipping_insurance':
				if (isset($_POST['s'])){

					require (DIR_WS_CLASSES.'order.php');

					$order = new order();

					switch ($_POST['s']){

						case 1:

							$order->info['shipping_insurance'] = 1.99;

							$order->info['total'] = $order->info['total']+ 1.99;

							break;

						case 0:

							$order->info['shipping_insurance'] = 0;

							$order->info['total'] = $order->info['total'] - 1.99;

							break;
					}
				}

				break;

			case 'setPayment':

				$_SESSION['payment'] = $_POST['payment'];
				
				echo json_encode(array('payment'=>$_POST['payment']));
				
				break;
			

			case 'set_credit_card_address':
				require_once DIR_WS_CLASSES . 'class.checkout.php';
                require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/checkout_common.php'); // 调用公共的语言包
//				if (empty($_SESSION['customer_id'])) {
//                    echo json_encode(array("status" => 406));
//                    exit;
//				}
				$req_qreoid = (int)$_POST['req_qreoid'];
				if(empty($req_qreoid)){
					echo json_encode(array("status" => 406));
					exit;
				}

				$consignee_name = zen_db_prepare_input($_POST['entry_firstname']?:'');
				$billing_lastname = zen_db_prepare_input($_POST['entry_lastname']?:'');
				$Address =zen_db_prepare_input($_POST['entry_street_address']?:'');
				$entry_country_id = (int)$_POST['entry_country_id'];
				$billing_country = get_countries_name($entry_country_id,true);
				$billing_country_code = get_countries_code($billing_country);
				$entry_state =zen_db_prepare_input($_POST['entry_state']?:'');
				// if($entry_country_id == 223){
                //     $entry_state =$_POST['shipping_us_state'];
                // }
                // if($entry_country_id == 38){
                //     $entry_state =$_POST['shipping_ca_state'];
                // }
				$entry_city =zen_db_prepare_input($_POST['entry_city']?:'');
				$entry_postcode =zen_db_prepare_input($_POST['entry_postcode']?:'');
				$entry_telephone =zen_db_prepare_input($_POST['entry_telephone']?:'');
				$s_tel_prefix_email1 = zen_db_prepare_input($_POST['s_tel_prefix_email1']?:'');
				$company=zen_db_prepare_input($_POST["entry_company"]?:'');
				$address_line2 = zen_db_prepare_input($_POST["entry_suburb"]?:'');
				$company_type =zen_db_prepare_input($_POST['AddressType']?:'');
				$billing_tax_number = zen_db_prepare_input($_POST['tax_number']?:'');

                // 初始国家不允许改变
                $firstBillingData = (new \App\Models\OrdersFirstBillingData())->where('orders_id', $req_qreoid)->first();
                if (
                    !empty($firstBillingData)
                    && german_warehouse('country_number', $firstBillingData->delivery_country_id)
                    && $firstBillingData->delivery_country_id != 81
                    && ($entry_country_id == $firstBillingData->country_id)
                    && ($firstBillingData->company_type != $company_type || $firstBillingData->vax_number != $billing_tax_number)
                ) {
                    echo json_encode(array("status" => 406));
                    exit;
                }

                if($entry_country_id == 223){
                    $state_code = !empty($entry_state) ? fs_get_data_from_db_fields('states_code', 'countries_us_states', 'states ="'.$entry_state.'"') : "";
                }else{
                    $state_code =$entry_state;
                }

				$checkout = Checkout::getInstance([
                    "validate_format" => "php",
                    "main_page" => "checkout",
                    "state_format" => "php"
				]);
				
				$shipping_address = $checkout::get_post_address_data($address_book_id);
                $checkout::$address = $shipping_address;
				$validate = $checkout::validate($shipping_address);
                if (!empty($validate)) {
                    echo json_encode(array("status" => 406, "data" => $validate));
                    exit;
				}

				$billing_address = array(
					'billing_tax_number' => $billing_tax_number,

					'billing_company_type' => $company_type,

					'billing_name' => $consignee_name,

					'billing_company' => $company,

					'billing_suburb' => $address_line2,

					'billing_lastname' => $billing_lastname,

					'billing_street_address' => $Address,

					'billing_country' => $billing_country,

					'billing_state' => $entry_state,

					'billing_city' => $entry_city,

					'billing_postcode' => $entry_postcode,

					'billing_telephone' => $entry_telephone,

					'b_tel_prefix' => $s_tel_prefix_email1

				);
				zen_db_perform('orders', $billing_address, 'update', 'orders_id = ' . $req_qreoid);
				echo json_encode(array("status"=>200,"country_code"=>$billing_country_code,"state_code"=>$state_code));
				break;

			case 'globalcollect_submit':
				$orders_id = $_POST['orders_id'];
				$_SESSION['req_qreoid'] = $orders_id;
				$paymentproductid = $_POST['paymentproductid'];

				$_SESSION['url_eroor'] = 'payment_billing';

				if(isset($_GET['act'])){

					$_SESSION['url_eroor'] = 'payment_against';
				}
				require (DIR_WS_CLASSES . 'payment.php');

				$payment = new payment('globalcollect');

				require (DIR_WS_CLASSES.'order.php');

				$order = new order($orders_id);

				$action = $GLOBALS['globalcollect']->form_action_url;

				$process_string = $GLOBALS['globalcollect']->process_button();

				echo json_encode(array('url'=>$action,'params'=>$process_string));exit;
				break;
	            
				
				case 'switch_payment_method':

				$orders_id = $_POST['orders_id'];

				$_SESSION['req_qreoid'] = $orders_id;

				$payment_method_code = $_POST['payment_method'];

					switch ($payment_method_code){
						case 'paypal':
							$payment_method = 'PayPal';
							break;
						case 'hsbc':
							$payment_method = 'HSBC Order';
							break;
						case 'globalcollect':
							$payment_method = 'Globalcollect';
							break;
						case 'payeezy':
								$payment_method = 'payeezy';
								break;
						case 'bpay':
							$payment_method = 'bpay';
							break;
						case 'eNETS':
							$payment_method = 'eNETS';
							break;
						case 'iDEAL':
							$payment_method = 'iDEAL';
							break;
						case 'SOFORT':
							$payment_method = 'SOFORT';
							break;
						case 'YANDEX':
							$payment_method = 'YANDEX';
							break;
						case 'WEBMONEY':
							$payment_method = 'WEBMONEY';
							break;
						case 'echeck':
							$payment_method = 'Electronic Check';
							break;
					}

				$oid_arr = zen_get_all_son_order_id($orders_id);
				array_push($oid_arr,$orders_id);
				if(isset($payment_method)){
					if($oid_arr){
                        //切换支付方式重设时间
                        $res = orders_overtime($orders_id, $payment_method_code);
                        if ($res){
                            foreach($oid_arr as $v){
                                $re = $db->Execute("select payment_method,payment_module_code from orders where orders_id = '".$v."'");
                                if($re){
                                    $d_payment = array(
                                        'orders_id' => $v,
                                        'payment_module_code' =>$re->fields['payment_module_code'],
                                        'payment_method' => $re->fields['payment_method'],
                                        'date_added' => 'now()'
                                    );
                                    zen_db_perform('orders_payment_history', $d_payment);

                                    $d_payment = array(
                                        'payment_module_code' =>$payment_method_code,
                                        'payment_method' => $payment_method,
                                        'last_modified' => 'now()'
                                    );
                                    zen_db_perform('orders', $d_payment,'update','orders_id='.$v);

                                }
                            }
                        }else{
                            $message = "<p>".FS_ORDERS_OVERTIMES_17."</p><p>".FS_ORDERS_OVERTIMES_18."</p>";
                            $location =zen_href_link('manage_orders');
                            $ret = [
                                "status"=> "error",
                                "message"=> $message,
                                "location"=> $location,
                            ];
                            echo json_encode($ret);
                            exit();
                        }
                        echo "ok";exit;
					}
				}else{
					echo "err";exit;
				}
			break;

			case "get_video_data":
			$id =zen_db_prepare_input($_POST['video_id']);
			$sql = "select video_url,video_title from fs_product_video where id = ".$id." and language_id =".$_SESSION['languages_id'];
            $video_info = $db->Execute($sql);
			if($video_info){
				echo json_encode(array('video_url'=>$video_info->fields['video_url'],'video_title'=>$video_info->fields['video_title']));exit;
			}
		    break;
			
		}
	}
}