<?php

//  $Id: bpay.php v3.2 2016-7 Henly $
$loader = require  DIR_FS_CATALOG."bpay/vendor/autoload.php";
$loader->add('GCS_',DIR_FS_CATALOG."bpay/tests");
date_default_timezone_set('UTC');
require_once DIR_FS_CATALOG.'bpay/tests/GCS/bpay/HostedCheckout.php';
 class bpay {
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
   function bpay(){
	   global $order;
		$this->code = 'bpay';
		if ($_GET['main_page'] != '') {
		   $this->title = MODULE_PAYMENT_BPAY_TEXT_CATALOG_TITLE; 
		}else{
		   $this->title = MODULE_PAYMENT_BPAY_TEXT_ADMIN_TITLE;
		}
       $this->description = MODULE_PAYMENT_BPAY_TEXT_DESCRIPTION;
       $this->sort_order = MODULE_PAYMENT_BPAY_SORT_ORDER;
       $this->enabled = ((MODULE_PAYMENT_BPAY_STATUS == 'True') ? true : false);
       if ((int)MODULE_PAYMENT_BPAY_ORDER_STATUS_ID > 0){
         $this->order_status = MODULE_PAYMENT_BPAY_ORDER_STATUS_ID;
       }
       if (is_object($order)) $this->update_status();
       $this->form_action_url = MODULE_PAYMENT_BPAY_HANDLER;

   }
// class methods
   function update_status() {
     global $order, $db;

     if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_BPAY_ZONE > 0) ) {
       $check_flag = false;
       $check_query = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_BPAY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
                   'module' => MODULE_PAYMENT_BPAY_TEXT_CATALOG_LOGO,
                   'icon' => MODULE_PAYMENT_BPAY_TEXT_CATALOG_LOGO
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
		 global $db, $order, $currencies,$myclass;
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
	return 'https://payment.'.$myclass->CreateHostedCheckout($process_string)->partialRedirectUrl;
   }


   function before_process() {
    global $order_total_modules, $messageStack, $_GET,$myclass;
		
	}

   function after_process() {
	global $insert_id,$db ;
	return true;
   }

   function output_error() {
     return false;
   }

   function check() {
     global $db;
     if (!isset($this->_check)) {
       $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_BPAY_STATUS'");
       $this->_check = $check_query->RecordCount();
     }
     return $this->_check;
   }

   function install() {
     global $db, $language, $module_type;
	 if (!defined('MODULE_PAYMENT_BPAY_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/' . $module_type . '/' . $this->code . '.php');

     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_BPAY_STATUS', 'True', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_BPAY_SELLER', '".STORE_OWNER_EMAIL_ADDRESS."', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_2_2 . "', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_BPAY_MD5KEY', '', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_3_2 . "', '6', '4', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_4_1 . "', 'MODULE_PAYMENT_BPAY_PARTNER', '', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_4_2 . "', '6', '5', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_5_1 . "', 'MODULE_PAYMENT_BPAY_ZONE', '0', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_5_2 . "', '6', '6', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_6_1 . "', 'MODULE_PAYMENT_BPAY_PROCESSING_STATUS_ID', '2', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_6_2 . "', '6', '8', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_7_1 . "', 'MODULE_PAYMENT_BPAY_ORDER_STATUS_ID', '1', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_7_2 . "', '6', '10', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_8_1 . "', 'MODULE_PAYMENT_BPAY_SORT_ORDER', '0', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_8_2 . "', '6', '12', now())");
     $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_9_1 . "', 'MODULE_PAYMENT_BPAY_HANDLER', 'https://api.globalcollect.com', '" . MODULE_PAYMENT_BPAY_TEXT_CONFIG_9_2 . "', '6', '18', '', now())");
}

   function remove() {
     global $db;
     $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE  'MODULE_PAYMENT_BPAY%'");
   }

   function keys() {
     return array(
         'MODULE_PAYMENT_BPAY_STATUS',
         'MODULE_PAYMENT_BPAY_SELLER',
         'MODULE_PAYMENT_BPAY_MD5KEY',
         'MODULE_PAYMENT_BPAY_PARTNER',
         'MODULE_PAYMENT_BPAY_ZONE',
         'MODULE_PAYMENT_BPAY_PROCESSING_STATUS_ID',
         'MODULE_PAYMENT_BPAY_ORDER_STATUS_ID',
         'MODULE_PAYMENT_BPAY_SORT_ORDER',
         'MODULE_PAYMENT_BPAY_HANDLER'
         );
   }

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}
 }
?>