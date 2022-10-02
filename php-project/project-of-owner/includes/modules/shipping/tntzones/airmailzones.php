<?php
// +----------------------------------------------------------------------+
// | Simplified Chinese version   http://www.zen-cart.cn                  |
// +----------------------------------------------------------------------+
//  $Id: airmail.php 001 2008-03-27 Jack $

 class airmailzones {
	var $code, $title, $description, $icon, $enabled, $countries, $check_query;

// class constructor
    function airmailzones() {
	global $order, $db;

	$this->code = 'airmailzones';
	$this->title = MODULE_SHIPPING_AIRMAIL_TEXT_TITLE;
	$this->description = MODULE_SHIPPING_AIRMAIL_TEXT_DESCRIPTION;
	$this->sort_order = MODULE_SHIPPING_AIRMAIL_SORT_ORDER;
	$this->icon = DIR_WS_MODULES.'shipping/airmailzones/hongkongpost.gif';
	$this->tax_class = MODULE_SHIPPING_AIRMAIL_TAX_CLASS;
	$this->enabled = ((MODULE_SHIPPING_AIRMAIL_STATUS == 'True') ? true : false);
	$this->countries = $order->delivery['country']['iso_code_2'];
	$this->num_zones = 5;

    }

// class methods
    function quote($method = '') 
	{
		global $order, $total_weight, $shipping_cost_value, $shipping_rows, $db,$currencies;
	
	 /*bof calulate the shipping cost drop products weight in 2 special categories*/
		if (0 == $total_weight || $total_weight > 2 || $_SESSION['cart']->show_total() > 100){
			return array('id' => $this->code,
                            'module' => MODULE_SHIPPING_AIRMAILLZONES_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $this->code,
                                                     'cost' => 0)),
							'error' => MODULE_SHIPPING_AIRMAILZONES_INVALID_ZONE);
		}
	/*eof calulate the shipping cost drop products weight in 2 special categories*/
		$usd_to_cny_rate = $currencies->currencies['CNY']['value'];
		$shipping_cost = ($total_weight > 0 ) ?	number_format( ( (($total_weight * 110) + 15) / $usd_to_cny_rate),2,'.','') : 0;
		
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_AIRMAILLZONES_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $this->code,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

//       if (strstr(MODULE_SHIPPING_AIRMAILZONES_SKIPPED, $dest_country)) {
//         // don't show anything for this country
//         $this->quotes = array();
//       } else {
        if (0 == $shipping_cost) $this->quotes['error'] = MODULE_SHIPPING_AIRMAILZONES_INVALID_ZONE;
//       }

      return $this->quotes;
    }

	function quotes($method = '',$country)
    {
    	global $order, $total_weight, $shipping_cost_value, $shipping_rows, $db,$currencies;
    
    	/*bof calulate the shipping cost drop products weight in 2 special categories*/
    	if (0 == $total_weight || $total_weight > 2){
    		
    		return array('id' => $this->code,
    				'module' => 'Hong Kong Post Airmail',
    				'methods' => array(array('id' => $this->code,
    						'title' => $this->code,
    						)),
    				'error' => MODULE_SHIPPING_AIRMAILZONES_INVALID_ZONE);
    	}
    	
    	/*eof calulate the shipping cost drop products weight in 2 special categories*/
    	$usd_to_cny_rate = $currencies->currencies['CNY']['value'];
    	$shipping_cost = ($total_weight > 0 ) ?	number_format( ( (($total_weight * 110) + 15) / $usd_to_cny_rate),2,'.','') : 0;
    
    	$this->quotes = array('id' => $this->code,
    			'module' =>'Hong Kong Post Airmail',
    			'methods' => array(array('id' => $this->code,
    					'title' => $this->code,
    					'cost' => $shipping_cost)));
    
    	if ($this->tax_class > 0) {
    		//$this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
    	}
    
    	if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
    
    	//       if (strstr(MODULE_SHIPPING_AIRMAILZONES_SKIPPED, $dest_country)) {
    	//         // don't show anything for this country
    	//         $this->quotes = array();
    	//       } else {
    	if (0 == $shipping_cost) $this->quotes['error'] = MODULE_SHIPPING_AIRMAILZONES_INVALID_ZONE;
    	//       }
    
    	return $this->quotes;
    }

    function check() {
	global $db;

  	if(!isset($this->_check)){
		$check_query = $db->Execute( "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_AIRMAIL_STATUS'");
		$this->_check = $check_query->RecordCount();
	}
	return $this->_check;
    }

    function install() {      	
		/*global $db;

      	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('æ‰“å¼€ç©ºé‚®é…�é€�æ¨¡å�—', 'MODULE_SHIPPING_AIRMAIL_STATUS', 'True', 'è¦�ä½¿ç”¨ç©ºé‚®é…�é€�æ¨¡å�—å�—?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
	    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('ç¨ŽçŽ‡ç§�ç±»', 'MODULE_SHIPPING_AIRMAIL_TAX_CLASS', '0', 'è®¡ç®—è¿�è´¹ä½¿ç”¨çš„ç¨ŽçŽ‡ç§�ç±»ã€‚', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('æŽ’åº�é¡ºåº�', 'MODULE_SHIPPING_AIRMAIL_SORT_ORDER', '0', 'æ˜¾ç¤ºçš„é¡ºåº�ã€‚', '6', '0', now())");
*/
    global $db;
	 if (!defined('MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_STATUS', 'True', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_AIRMAILZONES_SKIPPED', '', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");

      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_AIRMAILZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_AIRMAILZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_AIRMAILZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_AIRMAILZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
    }

    function remove() {
	global $db;

      	$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
	/*$keys = array('MODULE_SHIPPING_AIRMAIL_STATUS', 'MODULE_SHIPPING_AIRMAIL_TAX_CLASS', 'MODULE_SHIPPING_AIRMAIL_SORT_ORDER');*/
    $keys = array('MODULE_SHIPPING_AIRMAILZONES_STATUS', 'MODULE_SHIPPING_AIRMAILZONES_METHOD', 'MODULE_SHIPPING_AIRMAILZONES_TAX_CLASS', 'MODULE_SHIPPING_AIRMAILZONES_TAX_BASIS', 'MODULE_SHIPPING_AIRMAILZONES_SORT_ORDER', 'MODULE_SHIPPING_AIRMAILZONES_SKIPPED');

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_AIRMAILZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_AIRMAILZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_AIRMAILZONES_HANDLING_' . $i;
      }
	return $keys;
  }
}