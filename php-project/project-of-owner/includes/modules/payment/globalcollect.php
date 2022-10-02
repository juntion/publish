<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: globalcollect.php 001 2014-9-9 Henly $
//

 class globalcollect{
   var $code, $title, $description, $enabled;
  /**
   * order status setting for pending orders
   *
   * @var int
   */
   var $order_pending_status = 1;
   var $merchantid_t = 4793;
   var $merchantid = 8481;
   //var $ipaddress = "208.109.106.23";
   var $ipaddress = "208.109.52.66";
   var $processing_status_id = MODULE_PAYMENT_GLOBALCOLLECT_PROCESSING_STATUS_ID;
  /**
   * order status setting for completed orders
   *
   * @var int
   */
   var $order_status = DEFAULT_ORDERS_STATUS_ID;

// class constructor
   function globalcollect($globalcollect_ipn_id = '') {
     global $order;
       $this->code = 'globalcollect';
    if ($_GET['main_page'] != '') {
       $this->title = MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CATALOG_TITLE;
    }else{
       $this->title = MODULE_PAYMENT_GLOBALCOLLECT_TEXT_ADMIN_TITLE;
    }
       $this->description = MODULE_PAYMENT_GLOBALCOLLECT_TEXT_DESCRIPTION;
       $this->sort_order = MODULE_PAYMENT_GLOBALCOLLECT_SORT_ORDER;
       $this->enabled = ((MODULE_PAYMENT_GLOBALCOLLECT_STATUS == 'True') ? true : false);
       if ((int)MODULE_PAYMENT_GLOBALCOLLECT_ORDER_STATUS_ID > 0) {
         $this->order_status = MODULE_PAYMENT_GLOBALCOLLECT_ORDER_STATUS_ID;
       }

       if (is_object($order)) $this->update_status();
       $this->form_action_url = (MODULE_PAYMENT_GLOBALCOLLECT_HANDLER == 'Live') ? "https://ps.gcsip.com/wdl/wdl" : "https://ps.gcsip.nl/wdl/wdl";

   }

// class methods
   function update_status() {
     global $order, $db;

     if (($this->enabled == true) && ((int)MODULE_PAYMENT_GLOBALCOLLECT_ZONE > 0) ){
       $check_flag = false;
       $check_query = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_GLOBALCOLLECT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
       while (!$check_query->EOF) {
         if ($check_query->fields['zone_id'] < 1) {
           $check_flag = true;
           break;
         } elseif ($check_query->fields['zone_id'] == $order->billing['zone_id']) {
           $check_flag = true;
           break;
         }
                 $check_query->MoveNext();
       }
       if ($check_flag == false) {
         $this->enabled = false;
       }
     }
   }

   function javascript_validation() {
     return false;
   }

  function selection() {

    $selection = array( 'id' => $this->code,
						'module' => MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CATALOG_LOGO,
						'icon' => MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CATALOG_LOGO,
		               );

    return $selection;
  }


   function pre_confirmation_check() {
     return false;
   }

   function confirmation() {


    $confirmation = array('title' => MODULE_PAYMENT_GLOBALCOLLECT_TEXT_DESCRIPTION,

						 );

    return $confirmation;
  }

  function getNewStr($str){
		$str = str_replace('&','',$str);
		return $str;
  }

  function process_button(){
     global $db, $order, $currencies,$orders_id,$paymentproductid;


	$billing_firstname = $billing_name =  substr(str_replace('&','',$order->billing['name']),0,14);
	$billing_lastname = substr($this->getNewStr($order->billing['lastname']),0,14);
	/*
	$name = explode(" ",$billing_name);
	$lastname = "";
	foreach($name as $key=>$g){
		if($key>0){
			$lastname .= trim($g);
		}
	}*/
	$this->totalsum = $order->info['total'];
	//$my_currency = $_SESSION['currency'];
	$my_currency = $order->info['currency'];
	//$this->transaction_amount = ($this->totalsum * $currencies->get_value($my_currency));
	$this->transaction_amount = ($this->totalsum * $order->info['currency_value']);

	$ipaddress = $this->ipaddress;
	$orders_id = $orders_id;//
	if(empty($my_currency)) $my_currency = $_SESSION['currency'];
	if($my_currency == 'JPY'){
		$amount = (round($this->transaction_amount,0))*100;
	}else{
		$amount = (round($this->transaction_amount,2))*100;
	}
	$currencycode = $my_currency;
	$languagecode = 'en';
	$countrycode = get_countries_code($order->billing['country']);
	//$countrycode = "";
	//$surname =  $name[1];//lastname
	$surname =  $billing_lastname;
	$city = $order->billing['city'];
	$firstname = $billing_firstname;
	$street = substr($this->getNewStr($order->billing['street_address']),0,45);
	$housenumber = "";
	$zip = $order->billing['postcode'];
	$state = $order->billing['state'];
	$statecode = "";
	$shippingcity = $order->delivery['city'];
	$shippingcountrycode =  get_countries_code($order->delivery['country']);
	$ipaddresscustomer = getCustomersIP(); //客户ip
	$email = $order->customer['email_address'];
	$merchantreference = $order->info['orders_number']."-".date("His");
	$return_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');//
	$paymentproductid = $paymentproductid;  //1:Visa 2:American Express 3:Eurocard/Mastercard 130:CB 125:JCB
	if($paymentproductid == 128 || $paymentproductid == 132){
		$merchantid = $this->merchantid_t;
	}else{
		$merchantid = $this->merchantid;
	}
	$name = "IN";
	$option_xml = "<XML>
						<REQUEST>
							<ACTION>INSERT_ORDERWITHPAYMENT</ACTION>
							<META>
								<MERCHANTID>".$merchantid."</MERCHANTID>
								<IPADDRESS>".$ipaddress."</IPADDRESS>
								<VERSION>3.0</VERSION>
							</META>
							<PARAMS>
								<ORDER>
									<ORDERID>".$orders_id."</ORDERID>
									<AMOUNT>".$amount."</AMOUNT>
									<CURRENCYCODE>".$currencycode."</CURRENCYCODE>
									<LANGUAGECODE>".$languagecode."</LANGUAGECODE>
									<COUNTRYCODE>".$countrycode."</COUNTRYCODE>
									<SURNAME>".$surname."</SURNAME>
									<CITY>".$city."</CITY>
									<FIRSTNAME>".$firstname."</FIRSTNAME>
									<STREET>".$street."</STREET>
									<HOUSENUMBER>".$housenumber."</HOUSENUMBER>
									<ZIP>".$zip."</ZIP>
									<STATE>".$state."</STATE>
									<STATECODE>".$statecode."</STATECODE>
									<SHIPPINGCITY>".$shippingcity."</SHIPPINGCITY>
									<SHIPPINGCOUNTRYCODE>".$shippingcountrycode."</SHIPPINGCOUNTRYCODE>
									<IPADDRESSCUSTOMER>".$ipaddresscustomer."</IPADDRESSCUSTOMER>
									<EMAIL>".$email."</EMAIL>
									<MERCHANTREFERENCE>".$merchantreference."</MERCHANTREFERENCE>
								</ORDER>
								<PAYMENT>
							<RETURNURL>".$return_url."</RETURNURL>
									<PAYMENTPRODUCTID>".$paymentproductid."</PAYMENTPRODUCTID>
									<AMOUNT>".$amount."</AMOUNT>
									<CURRENCYCODE>".$currencycode."</CURRENCYCODE>
									<COUNTRYCODE>".$countrycode."</COUNTRYCODE>
									<LANGUAGECODE>".$languagecode."</LANGUAGECODE>
									<HOSTEDINDICATOR>1</HOSTEDINDICATOR>
								</PAYMENT>
							</PARAMS>
						</REQUEST>
					</XML>";
                $output = $this->fs_curl_exec($option_xml);
				$datatime = date("YmdHis");
				file_put_contents(dirname(__FILE__)."/globalcollect/respon".$orders_id.$datatime.".xml",$output);
				if(isset($output)){
					$doc = new DOMDocument();
					$doc->load(dirname(__FILE__)."/globalcollect/respon".$orders_id.$datatime.".xml");
					$response = $doc->getElementsByTagName("RESPONSE");
					foreach($response as $responses)
					{
						$ref = $responses->getElementsByTagName("REF");
						$ref_value = $ref->item(0)->nodeValue;
						$orderid = $responses->getElementsByTagName("ORDERID");

						$orderid_value = $orderid->item(0)->nodeValue;
						$action = $responses->getElementsByTagName("FORMACTION");
						$action_value = $action->item(0)->nodeValue;

                        $message = $responses->getElementsByTagName("MESSAGE");
                        $message_value = $message->item(0)->nodeValue;

					}
					$order = new order($orderid_value);
					$db->query("insert into globalcollect set orders_id = '".$orderid_value."',paymentproductid='$paymentproductid',ref='".$ref_value."',g_imformation='".serialize($output)."',addtime='".date("Y-m-d H:i:s")."'");
					if($action_value){
						return $action_value;
					}else{
                        $_SESSION['globalcollect_faild'] = 'error';
                        $_SESSION['error_info'] = $message_value;
                        return "";
					}
				}

     //return zen_draw_hidden_field($name, $option_xml);
   }

   function before_process() {
    global $db, $_POST, $order_total_modules,$currencies,$messageStack;
		$REF = $_GET['REF'];


		if($REF){
			$order_result = $db->execute("select orders_id,paymentproductid,ref from globalcollect where ref = '".$REF."'");
			$order_id = $order_result->fields['orders_id'];
			$paymentproductid = $order_result->fields['paymentproductid'];
			if($paymentproductid == 128 || $paymentproductid == 132){
				$merchantid = $this->merchantid_t;
			}else{
				$merchantid = $this->merchantid;
			}
		$ipaddress = $this->ipaddress;
		$xml = "<XML>
				<REQUEST>
					<ACTION>GET_ORDERSTATUS</ACTION>
					<META>
						<MERCHANTID>".$merchantid."</MERCHANTID>
						<IPADDRESS>".$ipaddress."</IPADDRESS>
						<VERSION>3.0</VERSION>
					</META>
					<PARAMS>
						<ORDER>
							<ORDERID>".$order_id."</ORDERID>
						</ORDER>
					</PARAMS>
				</REQUEST>
			</XML>";

                $output = $this->fs_curl_exec($xml);
				$datatime = date("YmdHis");
				file_put_contents(dirname(__FILE__)."/globalcollect/get_orderstatus".$order_id.$datatime.".xml",$output);
				$order = new order($order_id);

				if(isset($output)){
					$doc = new DOMDocument();
					$doc->load(dirname(__FILE__)."/globalcollect/get_orderstatus".$order_id.$datatime.".xml");
					$response = $doc->getElementsByTagName("RESPONSE");
					foreach($response as $responses)
					{
						$status = $responses->getElementsByTagName("STATUSID");
						$statusid = $status->item(0)->nodeValue;
					}
					$db->query("insert into globalcollect_payment_status_history set orders_id = '".$order_id."',status_id='".$statusid."',imformation='".serialize($output)."',description='".$this->error($statusid)."',datetime='".date("Y-m-d H:i:s")."'");
					if($statusid == 800){
						$db->query("update orders set orders_status = '".$this->processing_status_id."' where orders_id = '".$order_id."'");
						$sql_data_array = array('orders_id' => $order_id,
	                          'orders_status_id' =>2,
	                          'date_added' => 'now()'
	                         );
						zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);


						$_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
      					$_SESSION['order_summary']['orders_total'] = $currencies->display_currency_total_price($order->info['total'],0);
      					$_SESSION['order_summary']['items'] = $order->info['items'];
      					$_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
      					$_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
      					$_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
                        $this->fs_gc_orders_status($order_id);
						$order->send_fs_credit_card_order_email($order_id);
						return true;
					}elseif($statusid == 525){
						$this->process_challenged($merchantid,$ipaddress,$order_id);
						$datatime = date("YmdHis");
						$outputs = $this->get_challenged_status($xml,$datatime,$order_id);
						if($outputs){
							$doc = new DOMDocument();
							$doc->load(dirname(__FILE__)."/globalcollect/get_challenged_orderstatus".$order_id.$datatime.".xml");
							$response = $doc->getElementsByTagName("RESPONSE");
							foreach($response as $responses)
							{
								$status = $responses->getElementsByTagName("STATUSID");
								$statusid = $status->item(0)->nodeValue;
							}
							$db->query("insert into globalcollect_payment_status_history set orders_id = '".$order_id."',status_id='".$statusid."',imformation='".serialize($output)."',description='".$this->error($statusid)."',datetime='".date("Y-m-d H:i:s")."'");
							if($statusid == 800){
								$db->query("update orders set orders_status = '".$this->processing_status_id."' where orders_id = '".$order_id."'");
								$sql_data_array = array('orders_id' => $order_id,
									'orders_status_id' =>2,
									'date_added' => 'now()'
								);
						        zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
								$_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
								$_SESSION['order_summary']['orders_total'] = $currencies->display_currency_total_price($order->info['total'],0);
								$_SESSION['order_summary']['items'] = $order->info['items'];
								$_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
								$_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
								$_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
                                $this->fs_gc_orders_status($order_id);

								$order->send_fs_credit_card_order_email($order_id);

								return true;
							}
						}
					}
				}
		}
		if($statusid == 160){
			$_SESSION['globalcollect_faild'] = 'Declined to pay';
		}else{
			$_SESSION['globalcollect_faild'] = 'Failure to pay';
		}
		if(isset($_SESSION['url_eroor']) && $_SESSION['url_eroor'] == 'payment_against'){

			zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST,'orders_id='.$order_id.'&checkout_type=1','SSL'));

		}else{
		 zen_redirect(zen_href_link(FILENAME_CHECKOUT_GLOBALCOLLECT_BILLING,'req_qreoid='.$order_id,'SSL'));
		}
		return false;
   }
   function fs_gc_orders_status($order_id){
       global $db;
       $oid_arr = zen_get_all_son_order_id($order_id);
       foreach($oid_arr as $v){
           $db->query("update orders set orders_status = '".$this->processing_status_id."' where orders_id = '".$v."'");
           $sql_data_array = array('orders_id' => $v,
               'orders_status_id' =>2,
               'date_added' => 'now()'
           );
           zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
       }
   }
   function get_challenged_status($xml,$datatime,$order_id){
            $output = $this->fs_curl_exec($xml);
			file_put_contents(dirname(__FILE__)."/globalcollect/get_challenged_orderstatus".$order_id.$datatime.".xml",$output);
			return $output;
   }
   function process_challenged($merchantid,$ipaddress,$order_id){
   		global $db;
   			$xml = "<XML>
   				 <REQUEST>
   					<ACTION>PROCESS_CHALLENGED</ACTION>
				   		<META>
					   		<MERCHANTID>".$merchantid."</MERCHANTID>
					   		<IPADDRESS>".$ipaddress."</IPADDRESS>
					   		<VERSION>2.0</VERSION>
				   		</META>
				   		<PARAMS>
					   		<PAYMENT>
						   		<ORDERID>".$order_id."</ORDERID>
						   		<EFFORTID>1</EFFORTID>
					   		</PAYMENT>
				   		</PARAMS>
				  </REQUEST>
				</XML>";
                $output = $this->fs_curl_exec($xml);
		   		$datatime = date("YmdHis");
		   		file_put_contents(dirname(__FILE__)."/globalcollect/challenged".$order_id.$datatime.".xml",$output);

   }
   function fs_curl_exec($xml){
       $curl = curl_init(); // 启动一个CURL会话
       curl_setopt($curl, CURLOPT_URL, $this->form_action_url); // 要访问的地址
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
       curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
       curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
       curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
       curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
       curl_setopt($curl, CURLOPT_POSTFIELDS, $xml); // Post提交的数据包
       curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
       curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
       $output = curl_exec($curl); // 执行操作
       curl_close($curl);
       return $output;
   }
   function error($status_id){
	   global $db;
	   $description = "";
	   $error = array(
		    0 =>'The payment attempt was created',
		    20 =>'The HostedMerchantLink transaction is waiting for the consumer to be redirected by the merchant to WebCollect',
		    25=>'The HostedMerchantLink transaction is waiting for the consumer to enter missing data on the payment pages of GlobalCollect',
		    30=>'The Hosted Merchant Link transaction is waiting for WebCollect to redirect the consumer to the bank payment pages (optionally, after the consumer enters missing data)',
		    50=>'The payment request and consumer have been forwarded to the payment pages of the bank',
		    55=>'The consumer received all payment details to initiate the transaction the consumer must go to the (bank) office to initiate the payment',
		    60=>'The consumer is not enrolled for 3D Secure authentications',
		    65=>'The consumer is at an office to initiate a transaction 
				The status is used when the supplier polls the WebCollect database to verify if a payment on an order is (still) possible',
			70=>'The status of the payment is in doubt at the bank',
			100=>'WebCollect rejected the payment instruction',
			120=>'The bank rejected the payment',
			125=>'The consumer cancelled the payment while on the bank payment page',
			130=>'The payment has failed',
			140=>'The payment was not completed within the given set time limit by the consumer and is expired<BR/>The payment has failed',
			150=>'WebCollect did not receive information regarding the outcome of the payment at the bank',
			160=>'The transaction had been rejected for reasons of suspected fraud',
			170=>'The authorization is expired because no explicit settlement request was received in time',
			172=>'The enrolment period was pending for too long',
			175=>'The validation period was pending for too long',
			180=>'The cardholder authentication response from the bank was invalid or not completed',
			190=>'The settlement is rejected
			Used in a captured by GlobalCollect credit card online transaction, specifically ATOS',
			200=>'The cardholder was successfully authenticated',
			220=>'The authentication service was out of order; the cardholder could not be authenticated',
			230=>'The cardholder is not participating in the 3D Secure authentication program',
			280=>'The cardholder authentication response from the bank was invalid or not completed
			Authorization is not possible',
			300=>'This payment will be re-authorized and settled offline',
			310=>'The consumer is not enrolled for 3D Secure authenticationb Authorization is not possible',
			320=>'The authentication service was out of order; the cardholder could not be authenticated
			Authorization is not possible',
			330=>'The cardholder is not participating in the 3D Secure authentication program
			Authorization is not possible',
			350=>'The cardholder was successfully authenticated <br />
			Authorization is not possible',
			400=>'The consumer or WebCollect has revised the payment (with another payment product)',
			500=>'Payment was unsuccessful <br />
			This is the final status update for this transaction',
			525=>'The payment was challenged by your fraud rule set and is pending <br />
			Use the Process Challenged API or the Web Payment Console if you choose to process further',
			550=>'The payment was referred
			A manual authorization attempt will be made shortly',
			600=>'The payment instruction is waiting for one of these <br />
			Mandate (direct debit) <br />
			Settlement (credit card online) <br />
			Acceptance (recurring orders)',
			625=>'The transaction is authorized and waiting for the second message (captured) from the provider',
			650=>'The real-time bank payment is pending verification by the batch process
			If followed by 50 PENDING AT BANK, the verification could not be carried out successfully',
			800=>'successful',
			900=>'The refund was processed',
			950=>'The invoice was printed and sent',
			975=>'The settlement file was sent for processing at the financial institution',
			1000=>'The payment was paid',
			1010=>'GlobalCollect debited the consumer account',
			1020=>'GlobalCollect corrected the payment information that was given',
			1030=>'The chargeback has been withdrawn',
			1050=>'The funds have been made available for remittance to the merchant',
			1100=>'GlobalCollect rejected the payment attempt',
			1110=>'The acquiring bank rejected the direct debit',
			1120=>'Refused settlement before payment by GlobalCollect (credit card)',
			1150=>'Refused settlement after payment from Acquirer (credit card)',
			1210=>'The bank of the consumer rejected the direct debit',
			1250=>'The payment bounced',
			1500=>'The payment was charged back by the consumer',
			1510=>'The consumer reversed the direct debit payment',
			1520=>'The payment was reversed',
			1800=>'The payment was refunded',
			1810=>'GlobalCollect corrected the refund information given',
			1850=>'Refund is refused by the Acquirer',
			2000=>'GlobalCollect credited the consumer account',
			2030=>'The reversed payout was withdrawn',
			2100=>'GlobalCollect rejected the payout attempt',
			2110=>'Bank rejected the payout attempt',
			2120=>'The acquiring bank rejected the payout attempt',
			2130=>'The consumer bank rejected the payout attempt',
			2210=>'The consumer reversed the payout',
			2220=>'The payout was reversed',
			99999=>'The payment, refund, or payout attempt was cancelled by the merchant'
		   );
		   return $error[$status_id];
   }

   function check_referrer($zf_domain) {
     return true;
   }

   function admin_notification($zf_order_id){
     global $db;
   }

   function after_process() {
	 global $insert_id, $db;
	 return true;

   }

   function output_error() {
     return false;
   }

   function check() {
     global $db;
     if (!isset($this->_check)) {
       $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_GLOBALCOLLECT_STATUS'");
       $this->_check = $check_query->RecordCount();
     }
     return $this->_check;
   }

   function install() {
     global $db, $language, $module_type;

	 if (!defined('MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $this->code . '.php');

     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_STATUS', 'True', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_1_2 . "', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_SELLER', '000015', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_2_2 . "', '6', '2', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_MD5KEY', 'GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_3_2 . "', '6', '3', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_ANTIFRAUD', 'False', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_9_2 . "', '6', '4', 'zen_cfg_select_option(array(\'False\', \'True\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_4_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_ZONE', '0', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_4_2 . "', '6', '6', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_5_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_PROCESSING_STATUS_ID', '2', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_5_2 . "', '6', '8', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_6_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_6_2 . "', '6', '10', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_7_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_SORT_ORDER', '0', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_7_2 . "', '6', '12', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_HANDLER', 'Test', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_8_2 . "', '6', '18', 'zen_cfg_select_option(array(\'Live\', \'Test\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_10_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_IPN_DEBUG', 'Off', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_10_2 . "', '6', '20', 'zen_cfg_select_option(array(\'Off\',\'Log File\',\'Log and Email\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_11_1 . "', 'MODULE_PAYMENT_GLOBALCOLLECT_DEBUG_EMAIL_ADDRESS','".STORE_OWNER_EMAIL_ADDRESS."', '" . MODULE_PAYMENT_GLOBALCOLLECT_TEXT_CONFIG_11_2 . "', '6', '22', now())");


   }
   function remove() {
     global $db;
     $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE_PAYMENT_GLOBALCOLLECT%'");
   }

   function keys() {
     return array(
         'MODULE_PAYMENT_GLOBALCOLLECT_STATUS',
         'MODULE_PAYMENT_GLOBALCOLLECT_SELLER',
         'MODULE_PAYMENT_GLOBALCOLLECT_MD5KEY',
         'MODULE_PAYMENT_GLOBALCOLLECT_ANTIFRAUD',
         'MODULE_PAYMENT_GLOBALCOLLECT_ZONE',
         'MODULE_PAYMENT_GLOBALCOLLECT_PROCESSING_STATUS_ID',
         'MODULE_PAYMENT_GLOBALCOLLECT_ORDER_STATUS_ID',
         'MODULE_PAYMENT_GLOBALCOLLECT_SORT_ORDER',
         'MODULE_PAYMENT_GLOBALCOLLECT_HANDLER',
         'MODULE_PAYMENT_GLOBALCOLLECT_IPN_DEBUG',
         'MODULE_PAYMENT_GLOBALCOLLECT_DEBUG_EMAIL_ADDRESS'
         );
   }
 }
?>