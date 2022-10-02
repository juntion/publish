<?php

class simplyovernightzones
{
    var $code, $title, $description, $enabled, $num_zones, $num_zones_days, $handfee_rate;

    function simplyovernightzones()
    {
        $this->code = 'simplyovernightzones';
        $this->codes = 'Simply';
        $this->title = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/simplyovernightzones/simply_logo.gif';
        $this->tax_class = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_BASIS;
        $this->extra_rate = 1;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 15;
        $this->num_zones_days = 5;
    }

    function quote($method = '', $order_tag = false)
    {

        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies, $separated_weight;

        $dest_country = $order->delivery['country']['iso_code_2'];
        $post_code = !empty($order->delivery['postcode']) ? $order->delivery['postcode'] : 0;
        $check_post = fs_get_data_from_db_fields('id','countries_sg_zip_special',"shipping_method = 'simplyovernightzones' AND postcode = '".$post_code."'");
        if($check_post){
            return array();
        }
        $dest_zone = 0;
        $error = false;

        $lbs = $separated_weight;

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COUNTRIES_' . $i);
            $countries_table = strtoupper(str_replace(' ', '', $countries_table));
            $country_zones = split("[,]", $countries_table);
            if (in_array($dest_country, $country_zones)) {
                $dest_zone = $i;
                break;
            }
            if (in_array('00', $country_zones)) {
                $dest_zone = $i;
                break;
            }
        }

        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping_cost = -1;
            switch ($lbs){
                case $lbs <= 4:
                    $shipping_cost = 6.5;
                    break;
                case $lbs > 4 && $lbs <= 10:
                    $shipping_cost = 8;
                    break;
                case $lbs > 10 && $lbs <= 20:
                    $shipping_cost = 11;
                    break;
                case $lbs > 20 && $lbs <= 30:
                    $shipping_cost = 18.5;
                    break;
                case $lbs > 30:
                    $shipping_cost = 18.5 + (intval($lbs) - 30);
                    break;
            }

            $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($lbs,2) . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_UNITS . ')';
            $shipping_method = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_WAY . ' ' . $dest_country.$show_box_weight;
        }

        $shipping_cost = $shipping_cost * $this->extra_rate;

        if ($shipping_cost != -1) {

            $shipping_cost = $shipping_cost / $currencies->currencies['SGD']['value'];

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_TITLE,
                'methods' => array(
                    array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            return array();
        }

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_INVALID_ZONE;
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

        global $order, $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $country;
        $post_code = !empty($post_code) ? $post_code : 0;
        $check_post = fs_get_data_from_db_fields('id','countries_sg_zip_special',"shipping_method = 'simplyovernightzones' AND postcode = '".$post_code."'");
        if($check_post){
            return array();
        }
        $dest_zone = 0;
        $error = false;

        $lb = $lbs = $total_weight;

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COUNTRIES_' . $i);
            $countries_table = strtoupper(str_replace(' ', '', $countries_table));
            $country_zones = split("[,]", $countries_table);
            if (in_array($dest_country, $country_zones)) {
                $dest_zone = $i;
                break;
            }
            if (in_array('00', $country_zones)) {
                $dest_zone = $i;
                break;
            }
        }

        if ($dest_zone == 0) {
            $error = true;
        } else {$shipping_cost = -1;
            switch ($lbs){
                case $lbs <= 4:
                    $shipping_cost = 6.5;
                    break;
                case $lbs > 4 && $lbs <= 10:
                    $shipping_cost = 8;
                    break;
                case $lbs > 10 && $lbs <= 20:
                    $shipping_cost = 11;
                    break;
                case $lbs > 20 && $lbs <= 30:
                    $shipping_cost = 18.5;
                    break;
                case $lbs > 30:
                    $shipping_cost = 18.5 + (intval($lbs) - 30);
                    break;
            }

            $shipping_cost = ($shipping_cost * (1+MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_EXTRA_FEE));
            $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($lbs,2) . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_UNITS . ')';
            $shipping_method = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_WAY . ' ' . $dest_country.$show_box_weight;
        }
        $$shipping_cost = $shipping_cost * $this->extra_rate;

        if ($shipping_cost != -1) {

            $shipping_cost = $shipping_cost / $currencies->currencies['SGD']['value'];

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            return array();
        }


        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_STATUS', 'True', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SKIPPED', '', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_EXTRA_FEE', '填写DHL的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'SG';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }


        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS','3-7 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS_ZONES_" . $i . "','SG','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }


    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_STATUS', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_METHOD', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_CLASS', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_TAX_BASIS', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SORT_ORDER', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_SKIPPED', 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_EXTRA_FEE');
        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_DAYS_' . $i;
        }

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYOVERNIGHTZONES_HANDLING_' . $i;
        }
        return $keys;
    }
}