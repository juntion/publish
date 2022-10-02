<?php


  class freezones {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function freezones() {
      $this->code = 'freezones';
      $this->title = MODULE_SHIPPING_FREEZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FREEZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FREEZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/freezones/free_logo.jpg';
      $this->tax_class = MODULE_SHIPPING_FREEZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_FREEZONES_TAX_BASIS;

  

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      //$this->num_zones = 8;
    }

// class methods
    function quote($method = '') {
     
         return  array();
    }

    /**
     * @param string $method
     * @param $country 国家id
     * @param string $post_code 邮编
     * @param int $price 产品单价usd
     * @param string $state 洲
     * @param bool $is_buck是否16大重类
     * @param array $length_array 长度属性
     * @return array
     */
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array())
    {

        return array();
    }
    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FREEZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install(){
      global $db;
	 if (!defined('MODULE_SHIPPING_FREEZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FREEZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_FREEZONES_STATUS', 'True', '" . MODULE_SHIPPING_FREEZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FREEZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_FREEZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_FREEZONES_TEXT_CONFIG_2_2 . "', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_FREEZONES_STATUS','MODULE_SHIPPING_FREEZONES_SORT_ORDER');

      return $keys;
    }
  }
?>