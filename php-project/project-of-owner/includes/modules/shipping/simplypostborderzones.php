<?php


class simplypostborderzones
{
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function simplypostborderzones()
    {
        $this->code = 'simplypostborderzones';
        $this->codes = 'SimplyPost Border Linehaul';
        $this->title = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/simplypostborderzones/simply_logo.gif';
        $this->tax_class = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_BASIS;
        $this->extra_rate = 1;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 15;
        $this->num_zones_days = 5;
    }

    function quote($method = '')
    {
        global $order, $shipping_weight, $shipping_num_boxes, $total_count, $total_weight, $currencies;
        $dest_country = $order->delivery['country']['iso_code_2'];
        $shipping_weight = $total_weight;
        $dest_zone = 0;
        $error = false;

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COUNTRIES_' . $i);
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
            $shipping = -1;
            $zones_cost = constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COST_' . $dest_zone);
            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i+=2) {
                switch (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD) {
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Weight'):
                        if (($shipping_weight) <= $zones_table[$i]) {
                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($shipping_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($shipping_weight, 2) . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_UNITS . ')';
                                    break;
                            }
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Price'):
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {;
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country;
                            $shipping = $zones_table[$i + 1];
                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Item'):
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                }
                if ($done == true) {
                    break;
                }
            }

            if ($shipping == -1) {
                $shipping_cost = 0;
                $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD) {
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Weight'):
                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_EXTRA_FEE)) / $currencies->currencies['SGD']['value'];
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost = $shipping_cost * $this->extra_rate;

        if ($shipping_cost) {
            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            $this->quotes = array();
        }

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_INVALID_ZONE;
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
    function quotes($method = '', $total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(), $zone_type, $is_shipping_free, $products_info)
    {
        global $order, $shipping_weight, $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $country;
        $shipping_weight = $total_weight;
        $dest_zone = 0;
        $error = false;

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COUNTRIES_' . $i);
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
            $shipping = -1;
            $zones_cost = constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COST_' . $dest_zone);
            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i+=2) {
                switch (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD) {
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Weight'):
                        if (($shipping_weight) <= $zones_table[$i]) {
                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($shipping_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($shipping_weight, 2) . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_UNITS . ')';
                                    break;
                            }
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Price'):
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {;
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country;
                            $shipping = $zones_table[$i + 1];
                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Item'):
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_WAY . ' ' . $dest_country;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                }
                if ($done == true) {
                    break;
                }
            }

            if ($shipping == -1) {
                $shipping_cost = 0;
                $shipping_method = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD) {
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Weight'):
                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_EXTRA_FEE)) / $currencies->currencies['SGD']['value'];
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }

        $shipping_cost = $shipping_cost * $this->extra_rate;

        if ($shipping_cost) {
            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            $this->quotes = array();
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_STATUS', 'True', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SKIPPED', '', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_EXTRA_FEE', '填写SIMPLY的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'MY';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }


        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS','3-7 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS_ZONES_" . $i . "','MY','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }


    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_STATUS', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_METHOD', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_CLASS', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_TAX_BASIS', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SORT_ORDER', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_SKIPPED', 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_EXTRA_FEE');
        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_DAYS_' . $i;
        }

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_SIMPLYPOSTBORDERZONES_HANDLING_' . $i;
        }
        return $keys;
    }
}

?>