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
	$this->icon = '';
	$this->tax_class = MODULE_SHIPPING_AIRMAIL_TAX_CLASS;
	$this->enabled = ((MODULE_SHIPPING_AIRMAIL_STATUS == 'True') ? true : false);
	$this->countries = $order->delivery['country']['iso_code_2'];

    }

// class methods
    function quote($method = '') 
	{
		global $order, $total_weight, $shipping_cost_value, $shipping_rows, $db;
	
		$shipping_cost_value =  $db->Execute( "select *  from " . TABLE_SHIPPING_AIRMAIL . " where countries_iso_code_2 = '". $this->countries . "'" );
		$shipping_rows = $shipping_cost_value->RecordCount();

    
		if( ($total_weight / 1000 ) <= 1.5 )
		{
			$num = 0;
	
			if( $total_weight < 20 )
			{
				$shipping_cost = $shipping_cost_value->fields['shipping_airmail_20'] + 13;
			}
			else if ( $total_weight >=20 && $total_weight < 30 )
			{
				$shipping_cost = $shipping_cost_value->fields['shipping_airmail_30'] + 13;
			}
			else
			{
				$num = 0;
		
				if( ( $total_weight % 10 ) != 0 )
				{
					$num =  (int) ( ( ($total_weight - 30 ) / 10 ) + 1 );
				}
				else
				{
					$num = (int) ( ( ( $total_weight - 30 ) / 10 ));
				}
		
				$shipping_cost = $shipping_cost_value->fields['shipping_airmail_30'] + ( $shipping_cost_value->fields['shipping_airmail_ex10'] * $num ) + 13;		
			}				
		}
		else	
		{
			$num = 0;		
	
			if( ( $total_weight % 500 ) != 0 )
			{
				$num =  (int) ( ( ( ( $total_weight / 1000 ) - 0.5 ) / 0.5 ) + 1 );
			}
			else
			{
				$num = (int) ( ( ( $total_weight / 1000 ) - 0.5 ) / 0.5 );
			}
	
			$shipping_cost = $shipping_cost_value->fields['shipping_airmail_1000'] + ( $shipping_cost_value->fields['shipping_airmail_ex500'] * $num );
		}
		
		if(($total_weight/1000) > $shipping_cost_value->fields['shipping_airmail_max']) 
		{
			$shipping_cost = $shipping_cost * 1.5;
		}
	
		$shipping_cost = $shipping_cost;
	
		$this->quotes = array('id' => $this->code,
				 'module' => MODULE_SHIPPING_AIRMAIL_TEXT_TITLE,
							 'methods' => array(array('id' => $this->code,
													  'title' => "Weight: " . $total_weight / 1000 . " KG.<br>" . MODULE_SHIPPING_AIRMAIL_TEXT_WAY . " " . $shipping_cost_value->fields['shipping_airmail_desc'] . " Days",
													  'cost' => $shipping_cost)));
															  													  
	
		if($shipping_rows == 0)
			$this->quotes['error'] = MODULE_SHIPPING_AIRMAIL_TEXT_UNDEFINED_RATE;
	
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
	global $db;

      	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('打开空邮配送模块', 'MODULE_SHIPPING_AIRMAIL_STATUS', 'True', '要使用空邮配送模块吗?', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
	    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('税率种类', 'MODULE_SHIPPING_AIRMAIL_TAX_CLASS', '0', '计算运费使用的税率种类。', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('排序顺序', 'MODULE_SHIPPING_AIRMAIL_SORT_ORDER', '0', '显示的顺序。', '6', '0', now())");

    }

    function remove() {
	global $db;

      	$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
	$keys = array('MODULE_SHIPPING_AIRMAIL_STATUS', 'MODULE_SHIPPING_AIRMAIL_TAX_CLASS', 'MODULE_SHIPPING_AIRMAIL_SORT_ORDER');
	return $keys;
  }
}