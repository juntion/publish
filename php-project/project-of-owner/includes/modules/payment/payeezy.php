<?php


class payeezy extends base {
	var $code, $title, $description, $enabled;

// class constructor
	function payeezy () {
		global $order;
		$this->code = 'payeezy';
		$this->title = MODULE_PAYMENT_PAYEEZY_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_PAYEEZY_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PAYEEZY_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_PAYEEZY_STATUS == 'True') ? true : false);



		if ((int)MODULE_PAYMENT_PAYEEZY_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PAYEEZY_ORDER_STATUS_ID;
		}

		if (is_object($order)) $this->update_status();


		$this->email_footer = MODULE_PAYMENT_PAYEEZY_TEXT_EMAIL_FOOTER;

	}



// class methods

	function update_status() {
		global $order, $db;

		if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PAYEEZY_ZONE > 0) ) {
			$check_flag = false;
			$check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PAYEEZY_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
			while (!$check->EOF) {
				if ($check->fields['zone_id'] < 1) {
					$check_flag = true;
					break;
				} elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
					$check_flag = true;
					break;
				}
				$check->MoveNext();
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
			'module' => MODULE_PAYMENT_PAYEEZY_TEXT_CATALOG_LOGO,
			'icon' => MODULE_PAYMENT_PAYEEZY_TEXT_CATALOG_LOGO
		);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return array('title' => MODULE_PAYMENT_PAYEEZY_TEXT_DESCRIPTION);
	}

	function process_button() {
		return false;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		return false;
	}

	function get_error() {
		return false;
	}

	function check() {
		global $db;
		if (!isset($this->_check)) {
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PAYEEZY_STATUS'");
			$this->_check = $check_query->RecordCount();
		}
		return $this->_check;
	}

	function install() {
		global $db, $language;
		if (!defined('MODULE_PAYMENT_PAYEEZY_RECEIVER_FIRST_NAME')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $this->code . '.php');

		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_1_1 . "', 'MODULE_PAYMENT_PAYEEZY_STATUS', 'True', '" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_1_2 . "', '6', '1', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now());");

		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_FIRST_NAME . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_FIRST_NAME', '' ,'', '6', '2', now());");

		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_LAST_NAME . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_LAST_NAME','', '' , '6', '3', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_ADDRESS . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_ADDRESS', '' , '' , '6', '4', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_ZIP . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_ZIP', '', '' , '6', '5', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_CITY . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_CITY', '', '' , '6', '6', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_COUNTRY . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_COUNTRY', '', '' , '6', '7', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_RECEIVER_PHONE . "', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_PHONE', '', '' , '6', '8', now());");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_2_1 . "', 'MODULE_PAYMENT_PAYEEZY_SORT_ORDER', '0', '" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_2_2 . "', '6', '0', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_3_1 . "', 'MODULE_PAYMENT_PAYEEZY_ORDER_STATUS_ID', '0', '" . MODULE_PAYMENT_PAYEEZY_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");


	}

	function remove() {
		global $db;


		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

	}

	function keys() {
		return array('MODULE_PAYMENT_PAYEEZY_STATUS' , 'MODULE_PAYMENT_PAYEEZY_RECEIVER_FIRST_NAME', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_LAST_NAME', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_ADDRESS', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_ZIP', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_CITY', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_COUNTRY', 'MODULE_PAYMENT_PAYEEZY_RECEIVER_PHONE', 'MODULE_PAYMENT_PAYEEZY_SORT_ORDER','MODULE_PAYMENT_PAYEEZY_ORDER_STATUS_ID');
	}


	function admin_notification($zf_order_id) {
		global $db;
	
	}

}