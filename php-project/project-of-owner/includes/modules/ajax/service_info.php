<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
  $action = $_GET['ajax_request_action'];
  require DIR_WS_CLASSES . 'customer_account_info.php';
  include (DIR_WS_CLASSES.'customers_service_email.php');
  $customers_service_email = new customers_service_email();
  $customer_info = new customer_account_info();
  if(!zen_not_null($action)){
	echo "err";
  }else{
	switch($_GET['ajax_request_action']){
		case 'storeHttpReferers':
		if(isset($_POST['oID'])){
			$pID = implode(",",$_POST['pID']);
			
			$result = $db->Execute("select service_number from ".TABLE_CUSTOMERS_SERVICE." order by customers_service_id desc limit 1");
			if ($result->RecordCount() > 0)
			{
				$number = (int)substr($result->fields['service_number'],10) + 1;
				$cs_num = 'CS' . date('Ymd',time()). $number ;
			}
			else $cs_num = 'CS' . date('Ymd',time()) . '1000';
			$reason = $_POST['content'];

			$sql =" insert into ".TABLE_CUSTOMERS_SERVICE." (orders_id,products_id,customers_service_content,customers_id,service_number,service_type_id)
					values ('".$_POST['oID']."','".$pID."','".$reason."','".$_SESSION['customer_id']."','".$cs_num."','".$_POST['type_id']."') ";
				
			$db->query($sql); 
			$admin_email = $customers_service_email->admin_email_by_customers_id($_SESSION['customer_id']);
			$service_date = date('Y/m/d H:i');
			$orders_num = zen_get_orders_number_by_id($_POST['oID']);

			$customers_service_email->customers_service_send_email($admin_email,$cs_num,$service_date,$reason,$orders_num,'Service');
			
//				$his_sql = "insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added ,comments)
//		            		   values ('".$_POST['orders_id']."', '-1', now(),'" .$_POST['content']."')";
//		        $db->query($his_sql); 
			
			exit('ok');
		}
		break;

		case 'shipping_address':


		if (( isset($_POST['update_address'])) && $_POST['securityToken'] && $_POST['securityToken'] == $_SESSION['securityToken']){
			
			if (isset($_POST['address_book_id'])) $address_book_id = intval($_POST['address_book_id']);

			$entry_firstname = $_POST['entry_firstname'];
			$entry_lastname = $_POST['entry_lastname'];
			$entry_company = $_POST['entry_company'];
			$entry_street_address = $_POST['entry_street_address'];
			$entry_suburb  = $_POST['entry_suburb'];
			$entry_postcode = $_POST['entry_postcode'];
			$entry_state = $_POST['entry_state'];
			$entry_city = $_POST['entry_city'];
			
			if($_POST['country']){
				$entry_country_id = $_POST['country'];
			}else if($_POST['tagcountry']){
				$entry_country_id = $_POST['tagcountry'];
			}else{	$entry_country_id = 223;
			}
			
			$entry_zone_id = $_POST['entry_zone_id'];
			$entry_telephone = $_POST['entry_telephone'];
			
			if($entry_firstname == ''){$entry_firstname =$_POST['billing_entry_firstname'];}
			if($entry_lastname == ''){$entry_lastname =$_POST['billing_entry_lastname'];}
			if($entry_company == ''){$entry_company =$_POST['billing_entry_company'];}
			if($entry_street_address == ''){$entry_street_address =$_POST['billing_entry_street_address'];}
			if($entry_suburb == ''){$entry_suburb =$_POST['billing_entry_suburb'];}
			if($entry_postcode == ''){$entry_postcode =$_POST['billing_entry_postcode'];}
			if($entry_state == ''){$entry_state =$_POST['billing_entry_state'];}
			if($entry_city == ''){$entry_city =$_POST['billing_entry_city'];}
			if($entry_country_id == ''){$entry_country_id =$_POST['billing_entry_country_id'];}
			if($entry_zone_id == ''){$entry_zone_id =$_POST['billing_entry_zone_id'];}
			if($entry_telephone == ''){$entry_telephone =$_POST['billing_entry_telephone'];}
			
			
			$customer_address = array(
				'entry_company' => zen_db_prepare_input($entry_company),
				'entry_firstname' => zen_db_prepare_input($entry_firstname),
				'entry_lastname' => zen_db_prepare_input($entry_lastname),
				'entry_street_address' => zen_db_prepare_input($entry_street_address),
				'entry_suburb' => zen_db_prepare_input($entry_suburb),
				'entry_postcode' => zen_db_prepare_input($entry_postcode),
				'entry_state' => zen_db_prepare_input($entry_state),
				'entry_country_id' => (int)$entry_country_id,
				'entry_zone_id' => (int)$entry_zone_id,
				'entry_city' =>zen_db_prepare_input($entry_city),
				'entry_telephone' => zen_db_prepare_input($entry_telephone)
			);
			
			
			if (1 == $_POST['update_address']){
				
					/*update shipping address*/
					if(isset($customer_address)){
						$customer_info->update_address($customer_address,$address_book_id);
					}
				$shipping_addresses = $customer_info->get_customers_shipping_address();	
				$html = "";
				 foreach($shipping_addresses as $v){ 
				if($v['is_default'] == 1){
				
		   $html = '<div class="sales_shipping_address_con">
			  <span>'.$v['entry_firstname'].'&nbsp;&nbsp;'.$v['entry_lastname'].'</span>
			  <p>'.$v['entry_street_address'].'&nbsp;&nbsp; '.$v['entry_suburb'].' &nbsp;&nbsp;'. $v['entry_postcode'].'&nbsp;&nbsp;'.$v['entry_city'].'&nbsp;&nbsp;'. $v['entry_state'].'&nbsp;&nbsp;'.$v['entry_country']['entry_country_name'].'<br />'.$v['entry_telephone'].'</p></div>';
		  
				}
				}
				echo $html;

			}

			
		}
		break;

		case 'get_shipping_address':

			$shipping_addresses = $customer_info->get_customers_shipping_address();
			 
			foreach($shipping_addresses as $v){ 
			  if($v['is_default'] == 1){
	
				$html = '<div class="sales_shipping_address_con">
			  <span>'.$v['entry_firstname'].'&nbsp;&nbsp;'.$v['entry_lastname'].'</span>
			  <p>'.$v['entry_street_address'].'&nbsp;&nbsp; '.$v['entry_suburb'].' &nbsp;&nbsp;'. $v['entry_postcode'].'&nbsp;&nbsp;'.$v['entry_city'].'&nbsp;&nbsp;'. $v['entry_state'].'&nbsp;&nbsp;'.$v['entry_country']['entry_country_name'].'<br />'.$v['entry_telephone'].'</p></div>';

				echo json_encode(array('entry_firstname'=>$v['entry_firstname'],'entry_lastname'=>$v['entry_lastname'],'entry_street_address'=>$v['entry_street_address'],'entry_suburb'=>$v['entry_suburb'],'entry_postcode'=>$v['entry_postcode'],'entry_city'=>$v['entry_city'],'entry_state'=>$v['entry_state'],'entry_country_name'=>$v['entry_country']['entry_country_name'],'entry_telephone'=>$v['entry_telephone']));
		  
			  }
			}
			break;
		case 'update_from_address':
			$id = $_POST['service_id'];
			if($id){
				$entry_firstname = $_POST['entry_firstname'];
				$entry_lastname = $_POST['entry_lastname'];
				$entry_company = $_POST['entry_company'];
				$entry_street_address = $_POST['entry_street_address'];
				$entry_suburb  = $_POST['entry_suburb'];
				$entry_postcode = $_POST['entry_postcode'];
				$entry_state = $_POST['state'];
				$other_entry_state = $_POST['entry_state'];
				$entry_city = $_POST['entry_city'];
				$entry_telephone = $_POST['entry_telephone'];
				if($_POST['tagcountry']){
					$entry_country_id = $_POST['tagcountry'];
				}else{	
					$entry_country_id = 223;
				}
				if($entry_country_id==223){
					$info_entry_state =zen_get_countries_us_states_code($entry_state);
					$state = $entry_state;
				}elseif($entry_country_id==38){
					$state = $entry_state;
					$info_entry_state = $entry_state;
				}else{
					$state = $other_entry_state;
					$info_entry_state =$other_entry_state;
				}
				$entry_country_name = fs_get_data_from_db_fields('countries_name','countries','countries_id='.$entry_country_id,'limit 1');
				
				$service_address = array(
					'entry_firstname' => $entry_firstname,
					'entry_lastname' => $entry_lastname,
					'entry_company' => $entry_company,
					'entry_street_address' => $entry_street_address,
					'entry_suburb' => $entry_suburb,
					'entry_postcode' => $entry_postcode,
					'entry_city' => $entry_city,
					'entry_state' => $state,
					'entry_country_id' => $entry_country_id,
					'entry_telephone' => $entry_telephone
				);
				zen_db_perform('customers_service_address', $service_address, 'update', 'id='.(int)$id);
				$service_id = fs_get_data_from_db_fields('customers_service_id','customers_service_address','id='.$id,'limit 1');
				$serviceArr = fs_get_data_from_db_fields_array(array('orders_id','check_type'),'customers_service','customers_service_id='.$service_id,'limit 1');
				$html = '';
				$html .= $entry_firstname.' '.$entry_lastname.'<br>';
				$html .= $entry_street_address.($entry_suburb ? ', '.$entry_suburb : '').'<br>';
				$html .= $entry_city.', '.$entry_postcode.'<br>';
				$html .= ($info_entry_state ? $info_entry_state.', ' : '').$entry_country_name.'<br>';
				$html .= 'Tel: '.$entry_telephone;
				$EU_country = array(73,81,203,56,150,124,171,84,103,170,123,117,67,72,14,53,97,189,175,33,21,105,195,55,190,57,132,222,240,98,27,236,242,126,2,140,160,204,5,122,182,245,70,85,87,75,134,137,12);
				//获取退换货仓库地址
				$is_reissue = 0;
				if($serviceArr[0][0]){
					$is_reissue = fs_get_data_from_db_fields('is_reissue','orders','orders_id='.$serviceArr[0][0],'limit 1');
				}
				$instock_html = zen_get_rma_warehouse_address($entry_country_id, $is_reissue);

				$shipHtml = '';
				if(in_array($entry_country_id, array_merge($EU_country, [223])) && $serviceArr[0][1]==2){
					$shipHtml = '<div class="new17order_pickup_con"><h3 class="new_h2tit01">3. '.SALES_DETAILS_PRINT_LABEL.'     
						  <div class="track_orders_wenhao"><div class="question_bg"></div>
							<div class="question_text_01 leftjt"><div class="arrow"></div>
								<div class="popover-content">'.SALES_DETAILS_LABEL_MSG.'</div>
							</div></div></h3>
						<div class="new17order_pickup_btn"><a href="'.zen_href_link('print_shipping_label','&orders_id='.$serviceArr[0][0].'&s_id='.$service_id.'&service_id='.zen_encrypt_password($service_id)).'" class="button_11"><span class="icon iconfont"></span>'.SALES_DETAILS_PSL.'</a></div></div>';
						
					$tishi = '<ul><li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic01.jpg"><span>'.SALES_DETAILS_STEP_CONFIRM.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic02.jpg"><span>'.SALES_DETAILS_STEP_PRINT.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic03.jpg"><span>'.SALES_DETAILS_STEP_ATTACH.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic04.jpg"><span>'.SALES_DETAILS_STEP_CREATE.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic05.jpg"><span>'.SALES_DETAILS_STEP_SHIP.'</span></li></ul>';
					$firstMsg = FS_SALES_DETAILS_LABEL;
				}else{
					$shipHtml = '<form  action="'.zen_href_link('sales_service_details','service_id='.$service_id.'&action=send','SSL').'" onsubmit="return check_send()" method="post">
						<input type="hidden" name="service_id" value="'.$service_id.'" />
						<div class="new17order_pickup_con">
						  <h3 class="new_h2tit01 new_h2tit01_last">3. '.SALES_DETAILS_FILL.'</h3>
						  <ul>
							<li>
							  <p>'.FS_METHOD.':</p>
							  <select id="method" name="shipping_method" class="big_input">
								<option value="Fedex">FEDEX</option>
								<option value="DHL">DHL</option>
								<option value="EMS">EMS</option>
								<option value="UPS">UPS</option>
								<option value="TNT">TNT</option>
								<option value="AIRMAIL">AIRMAIL</option>
							  </select>
							</li>
						  </ul>
						  <ul>
							<li>
							  <p>'.SALES_DETAILS_TRACKING.':</p>
							  <input type="text" id="acount" class="big_input" name="tracking_number">
							  <p id="tishi" style="display:none;"><font color="red">'.SALES_DETAILS_PLEASE.'</font></p>
							</li>
						  </ul>
						  <div class="new17order_pickup_btn">
							<button type="submit" class="button_blue01">'.FS_SUBMIT.'</button>
						  </div>
						</div>
					  </form>';
					$tishi = '<ul><li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic01.jpg"><span>'.SALES_DETAILS_STEP_CONFIRM.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic02.jpg"><span>'.SALES_DETAILS_STEP_PRINT.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic03.jpg"><span>'.SALES_DETAILS_STEP_ATTACH.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic05.jpg"><span>'.SALES_DETAILS_STEP_SHIP.'</span></li>
						<li class="new17order_back_width"><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic06.jpg"></li>
						<li><img src="'.HTTPS_IMAGE_SERVER.'images/new17order_back_pic05.jpg"><span>'.FS_SALES_DETAILS_AWB.'</span></li></ul>';
					$firstMsg = FS_SALES_DETAILS_NO_LABEL;
				}
				$data = array("from"=>$html,"to"=>$instock_html,"ship"=>$shipHtml,"tishi"=>$tishi,"first"=>$firstMsg);
				echo json_encode($data);
			}
			exit;
		break;
		case 'select_address':
			$address_id = (int)$_POST['address_id'];
			if($address_id){
				//查找该售后单地址
				$service_address = array();
				$address_sql = "select id,entry_company,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_postcode,entry_city,entry_state,
					entry_country_id,entry_telephone,entry_email from customers_service_address where id=".$address_id." limit 1";
				$addRes = $db->Execute($address_sql);
				if($addRes->RecordCount()){
					$country_data = fs_get_data_from_db_fields_array(array('countries_name','countries_iso_code_2'),'countries','countries_id="'.$addRes->fields['entry_country_id'].'"','limit 1');
					$service_address = array(
						'id' => $addRes->fields['id'],
						'entry_firstname' => $addRes->fields['entry_firstname'],
						'entry_lastname' => $addRes->fields['entry_lastname'],
						'entry_company' => $addRes->fields['entry_company'],
						'entry_street_address' => $addRes->fields['entry_street_address'],
						'entry_suburb' => $addRes->fields['entry_suburb'],
						'entry_postcode' => $addRes->fields['entry_postcode'],
						'entry_city' => $addRes->fields['entry_city'],
						'entry_state' => $addRes->fields['entry_state'],
						'entry_country_id' => $addRes->fields['entry_country_id'],
						'entry_telephone' => $addRes->fields['entry_telephone'],
						'entry_email' => $addRes->fields['entry_email'],
						'entry_country_name' => $country_data[0][0],
						'country_code' => strtolower($country_data[0][1])
					);
				}
				echo json_encode($service_address);
			}else{
				echo 'err';
			}
			exit;
		break;
		case 'set_from_address':
			$country_id = $_POST['country_id'];
			$is_reissue = $_POST['is_reissue'];
			$instock_html = zen_get_rma_warehouse_address($country_id, $is_reissue);
			echo $instock_html;
			exit;
		break;
	}
  }
}