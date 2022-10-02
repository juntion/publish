<?php


class startrackfzones
{
    var $code, $title, $description, $enabled, $num_zones;

    function startrackfzones()
    {
        $this->code = 'startrackfzones';
        $this->title = MODULE_SHIPPING_STARTRACKFZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_STARTRACKFZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_STARTRACKFZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/startrackzones/free_logo.jpg';
        $this->tax_class = MODULE_SHIPPING_STARTRACKFZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_STARTRACKFZONES_TAX_BASIS;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_STARTRACKZONES_STATUS == 'True') ? true : false);
        }
    }

    function quote($method = '', $order_tag = 'local')
    {
        global $order;

        $status = $order_tag == 'local' ? $order->is_local_buck : $order->is_buck;
        $is_shipping_free = $order_tag == 'local' ? $order->local_info['is_shipping_free'] : $order->delay_info['is_shipping_free'];

        if ($is_shipping_free && !$status) {
            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_STARTRACKFZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $this->code,
                    'cost' => 0)));
        } else {
            $this->quotes = array();
        }

        return $this->quotes;
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
    function quotes($method = '', $total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(), $zone_type = 0, $is_shipping_free = false)
    {

        if ($is_shipping_free && !$is_buck) {
            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_STARTRACKFZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $this->code,
                    'cost' => 0)));
        } else {
            $this->quotes = array();
        }

        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_STARTRACKFZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_STARTRACKFZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_STARTRACKFZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_STARTRACKFZONES_STATUS', 'True', '" . MODULE_SHIPPING_STARTRACKFZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_STARTRACKFZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_STARTRACKFZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_STARTRACKFZONES_TEXT_CONFIG_2_2 . "', '6', '0', now())");
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_STARTRACKFZONES_STATUS', 'MODULE_SHIPPING_STARTRACKFZONES_SORT_ORDER');

        return $keys;
    }
}

?>