<?php

//  $Id: bpay.php v3.2 2016 Henly $
$loader = require  DIR_FS_CATALOG."bpay/vendor/autoload.php";
$loader->add('GCS_',DIR_FS_CATALOG."bpay/tests");
date_default_timezone_set('UTC');
require_once DIR_FS_CATALOG.'bpay/tests/GCS/bpay/HostedCheckout.php';
 class SOFORT {
   var $code, $title, $description, $enabled;
  /**
   * order status setting for pending orders
   *
   * @var int
   */
   var $order_pending_status = 1;
  /**
   * order status setting for completed orders
   *
   * @var int
   */
   var $order_status = DEFAULT_ORDERS_STATUS_ID;

// class constructor
   function SOFORT(){
	   global $order;
		$this->code = 'SOFORT';
		if ($_GET['main_page'] != '') {
		   $this->title = MODULE_PAYMENT_SOFORT_TEXT_CATALOG_TITLE; 
		}else{
		   $this->title = MODULE_PAYMENT_SOFORT_TEXT_ADMIN_TITLE;
		}
       $this->description = MODULE_PAYMENT_SOFORT_TEXT_DESCRIPTION;
       $this->sort_order = MODULE_PAYMENT_SOFORT_SORT_ORDER;
       $this->enabled = ((MODULE_PAYMENT_SOFORT_STATUS == 'True') ? true : false);
       if ((int)MODULE_PAYMENT_SOFORT_ORDER_STATUS_ID > 0){
         $this->order_status = MODULE_PAYMENT_SOFORT_ORDER_STATUS_ID;
       }
       if (is_object($order)) $this->update_status();
       $this->form_action_url = MODULE_PAYMENT_SOFORT_HANDLER;

   }
// class methods
   function update_status() {
     global $order, $db;

     if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SOFORT_ZONE > 0) ) {
       $check_flag = false;
       $check_query = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SOFORT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
     return array('id' => $this->code,
                   'module' => MODULE_PAYMENT_SOFORT_TEXT_CATALOG_LOGO,
                   'icon' => MODULE_PAYMENT_SOFORT_TEXT_CATALOG_LOGO
                   );
   }

   function pre_confirmation_check() {
     return false;
   }

   function confirmation() {
       return false;
   }

   function process_button() {
       return false;
   }
   function process_string(){
		global $db, $order,$order_id,$currencies;
	$myclass = new GCS_Client_HostedCheckout();
	$billing_firstname = $billing_name =  substr(str_replace('&','',$order->billing['name']),0,14);
	$billing_lastname = substr(str_replace('&','',$order->billing['lastname']),0,14);
	$this->totalsum = $order->info['total'];
	$my_currency = $order->info['currency'];

	$this->transaction_amount = ($this->totalsum * $order->info['currency_value']);
	
	$ipaddress = $this->ipaddress;
	if(empty($my_currency)) $my_currency = $_SESSION['currency'];
	$amount = (round($this->transaction_amount,2))*100;
	$currencycode = $my_currency;
	$languagecode = 'en';
	$countrycode = get_countries_code($order->billing['country']);
	$surname =  $billing_lastname;
	$city = $order->billing['city'];
	$firstname = $billing_firstname;
	$street = substr($order->billing['street_address'],0,45);
	$housenumber = "";
	$zip = $order->billing['postcode'];
	$state = $order->billing['state'];
	$statecode = "";
	$shippingcity = $order->delivery['city'];
	$shippingcountrycode =  get_countries_code($order->delivery['country']);
	$ipaddresscustomer = $_SERVER["REMOTE_ADDR"]; //客户ip
	$email = $order->customer['email_address'];
	$merchantreference = $order->info['orders_number']."-".date("His");
	$return_url = zen_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
	$process_string = array('amount'=>$amount,'currencycode'=>$currencycode,'countrycode'=>$countrycode,'city'=>$city,'street'=>$street,'zip'=>$zip,'state'=>$state,'merchantreference'=>$merchantreference,'return_url'=>$return_url);
	$payment_result = $myclass->CreateHostedeSofortdirectCheckout($process_string);
	$partialRedirectUrl = $payment_result->partialRedirectUrl;
	$RETURNMAC = $payment_result->RETURNMAC;
	$hostedCheckoutId = $payment_result->hostedCheckoutId;
	if($hostedCheckoutId){
		$db->Execute("insert into globalcollect_payment set order_id = '".$order_id."',returnmac='".$RETURNMAC."',hostedCheckoutId='".$hostedCheckoutId."'");
	}
	return 'https://payment.'.$partialRedirectUrl;
   }


   function before_process() {
    global $order_total_modules, $messageStack, $_GET,$myclass;
		
	}

   function after_process() {
	global $insert_id,$db,$order,$currencies;
	$myclass = new GCS_Client_HostedCheckout();
	$hostedCheckoutId = $_GET['hostedCheckoutId'];
	$returnmac = $_GET['RETURNMAC'];
	$status = $myclass->GetHostedCheckoutStatus($hostedCheckoutId);
    $notice = false;
	if($status->createdPaymentOutput->payment->statusOutput->statusCode==800){
        $re = $db->Execute("select order_id from globalcollect_payment where returnmac = '".$returnmac."' limit 1");
		$order_id = $re->fields['order_id'];

        //sofort获取流水号信息保存
        $status_code = $status->createdPaymentOutput->payment->statusOutput->statusCode;
        $description = $status->createdPaymentOutput->paymentStatusCategory;
        $response_string = json_encode($status->createdPaymentOutput->payment);
        $payment_id = $status->createdPaymentOutput->payment->id;
        $db->query("insert into globalcollect_payment_status_history set orders_id = '" . $order_id . "',status_id='" . $status_code . "',imformation='" . $response_string . "',description='" . $description . "',datetime='" . date("Y-m-d H:i:s") . "',payment_id='" . $payment_id . "',type=4");

        $son_id = zen_get_all_son_order_id($order_id);
        $son_id[] = $order_id;
        if (!empty($son_id)) {
            foreach ($son_id as $k => $v) {
//                $db->query("update orders set orders_status = '".$this->processing_status_id."' where orders_id = '".$v."'");
                $sql_data_array = array('orders_id' => $v,
                                        'orders_status_id' =>2,
                                        'date_added' => 'now()'
                );
                zen_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
            }
            if ($order->info['orders_status_id'] == 5){
                //订单已被取消
                $notice = true;
            }else{
                $son_id_str = '(' . implode(',', $son_id) . ')';
                $ordersOvertime =  fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $order_id,"id");
                if (zen_not_null($ordersOvertime['id'])){
                    $res = set_cancel_order_key($order_id);
                    if (!$res){
                        //正在被取消
                        $notice = true;
                    }else{
                        del_order_key_for_payment($order_id);
                        zen_db_perform("orders", array("orders_status" => 2), "update", "orders_id in " . $son_id_str);
                    }
                }else{
                    zen_db_perform("orders", array("orders_status" => 2), "update", "orders_id in " . $son_id_str);
                }
            }
        }
						$_SESSION['order_summary']['orders_number'] = $order->info['orders_number'];
      					$_SESSION['order_summary']['orders_total'] = $currencies->display_price($order->info['total'],0);
      					$_SESSION['order_summary']['items'] = $order->info['items'];
      					$_SESSION['order_summary']['shipping_method'] = preg_replace('/zones/i', '', $order->info['shipping_method']);
      					$_SESSION['order_summary']['orders_status'] = $order->info['orders_status'];
      					$_SESSION['order_summary']['payment_method'] = $order->info['payment_method'];
						//$order->send_fs_credit_card_order_email();


	}
	return $notice;
   }

   function output_error() {
     return false;
   }

   function check() {
     global $db;
     if (!isset($this->_check)) {
       $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SOFORT_STATUS'");
       $this->_check = $check_query->RecordCount();
     }
     return $this->_check;
   }

   function install() {
     global $db, $language, $module_type;
	 if (!defined('MODULE_PAYMENT_SOFORT_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $this->code . '.php');

     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_SOFORT_STATUS', 'True', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_SOFORT_SELLER', '".STORE_OWNER_EMAIL_ADDRESS."', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_2_2 . "', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_SOFORT_MD5KEY', '', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_3_2 . "', '6', '4', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_4_1 . "', 'MODULE_PAYMENT_SOFORT_PARTNER', '', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_4_2 . "', '6', '5', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_5_1 . "', 'MODULE_PAYMENT_SOFORT_ZONE', '0', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_5_2 . "', '6', '6', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_6_1 . "', 'MODULE_PAYMENT_SOFORT_PROCESSING_STATUS_ID', '2', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_6_2 . "', '6', '8', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_7_1 . "', 'MODULE_PAYMENT_SOFORT_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_7_2 . "', '6', '10', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_SOFORT_SORT_ORDER', '0', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_8_2 . "', '6', '12', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_SOFORT_HANDLER', 'https://api.globalcollect.com', '" . MODULE_PAYMENT_SOFORT_TEXT_CONFIG_9_2 . "', '6', '18', '', now())");
}

   function remove() {
     global $db;
     $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE_PAYMENT_SOFORT%'");
   }

   function keys() {
     return array(
         'MODULE_PAYMENT_SOFORT_STATUS',
         'MODULE_PAYMENT_SOFORT_SELLER',
         'MODULE_PAYMENT_SOFORT_MD5KEY',
         'MODULE_PAYMENT_SOFORT_PARTNER',
         'MODULE_PAYMENT_SOFORT_ZONE',
         'MODULE_PAYMENT_SOFORT_PROCESSING_STATUS_ID',
         'MODULE_PAYMENT_SOFORT_ORDER_STATUS_ID',
         'MODULE_PAYMENT_SOFORT_SORT_ORDER',
         'MODULE_PAYMENT_SOFORT_HANDLER'
         );
   }

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}
 }
?>