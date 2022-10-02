<?php

class upsltlzones
{
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function upsltlzones()
    {
        $this->code = 'upsltlzones';
        $this->codes = 'UPS LTL';
        $this->title = MODULE_SHIPPING_UPSLTLZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_UPSLTLZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_UPSLTLZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/UPSLTLZONES/upsground_logo.gif';
        $this->tax_class = MODULE_SHIPPING_UPSLTLZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_UPSLTLZONES_TAX_BASIS;

        $this->extra_rate = 1.2;

        // disable only when entire cart is free shipping
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_UPSLTLZONES_STATUS == 'True') ? true : false);
        }

        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 24;
        $this->num_zones_days = 5;

    }

// class methods
    function quote($method = '', $order_tag = false)
    {
        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies, $db;

        $cabinet_shipping_cost = 0;
        $cabinet_total_weight = 0;

        foreach ($order->local_cart_products as $local_prodcts) {
            if (array_key_exists($local_prodcts['id'], $order->local_cabinet)) {
                //加50块达到运费的安全值
                $cabinet_shipping_price = $order->local_cabinet[$local_prodcts['id']]['shipping_price'] + 50;
                $cabinet_quantity = $local_prodcts['quantity'];
                $cabinet_shipping_cost += $cabinet_quantity * $cabinet_shipping_price;
                $cabinet_total_weight += $cabinet_quantity * $local_prodcts['weight'];
            }
        }

        $shipping_cost = $cabinet_shipping_cost;

        $diff_products = array_diff($order->local_info['products_arr'], $order->local_cabinet);
        if (!empty($diff_products)) {
            if ($order->local_info['is_shipping_free']) {
                $separated_weight = bcsub($order->local_info['buck_weight'], $cabinet_total_weight, 2);
            } else {
                $separated_weight = bcsub($order->local_info['total_weight'], $cabinet_total_weight, 2);
            }
            $separated_weight = (float)$separated_weight;
        }

        if ($separated_weight > 0) {
            if (in_array($order->delivery['country_id'], array(38, 138))) {
                $shipping_price = $this->quote_dhlground($separated_weight);
            } else {
                $shipping_price = $this->quote_upsground($separated_weight);
            }
            $shipping_cost += $shipping_price;
        }

        $shipping_zones = zen_get_shipping_fedex_code_zone($order->delivery['postcode'], 1, 'groud_zone');
        $states = $shipping_zones ? $shipping_zones : '##';
        $shipping_method = MODULE_SHIPPING_UPSLTLZONES_TEXT_WAY . ' ' . $states;

        $this->quotes = array(
            'id' => $this->code,
            'module' => MODULE_SHIPPING_UPSLTLZONES_TEXT_TITLE,
            'methods' => array(
                array(
                    'id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost
                )
            )
        );

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }
        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPSLTLZONES_SKIPPED, $states)) {
            // don't show anything for this country
            $this->quotes = array();
        }

        return $this->quotes;
    }

    /**
     * add by quest 2019-12-25
     * 调取upsground 运费
     * @param $separated_weight
     * @return float
     */
    function quote_upsground($separated_weight)
    {
        global $order, $db;

        $dest_country = $order->delivery['country']['iso_code_2'];

        if ($dest_country == "PR") {
            $ground_zone = "045";
        } else {
            $ground_zone = fs_get_data_from_db_fields('ground', 'shipping_ups_special', 'zip = "' . $order->delivery['postcode'] . '"');
        }
        if (empty($ground_zone)) {
            $postcode = substr($order->delivery['postcode'], 0, 3);
            if ($postcode == 968 || in_array($dest_country, array('MX', 'CA'))) return array();
            $res = $db->getAll("select zip_from,zip_to,ground from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and location = 2");
            $ground_zone = $res[0]['ground'] ? $res[0]['ground'] : '';
        }

        $lbs = $separated_weight * 2.2046226;
        if ($ground_zone) {
            $day = $ground_zone;
            if ($lbs <= 10000) {
                $list = $db->getAll("select lbs,u_" . $day . " from shipping_ups_price where location = 2 order by id ASC");
                foreach ($list as $key => $v) {
                    if ($v['lbs'] >= $lbs) {
                        $shipping_cost = $list[$key]["u_" . $day] * (1 + MODULE_SHIPPING_UPSGROUNDEASTZONES_EXTRA_FEE);
                        break;
                    }
                }

                if ($lbs > 150) {
                    $shipping_cost = $list[count($list) - 1]["u_" . $day] * $lbs * (1 + MODULE_SHIPPING_UPSGROUNDEASTZONES_EXTRA_FEE);
                }

            } else {
                $shipping_cost = 0;
            }
        }

        return $shipping_cost;
    }

    /**
     * add by quest 2019-12-25
     * 调取dhlground 运费
     * @param $separated_weight
     * @return float
     */
    function quote_dhlground($separated_weight)
    {
        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies;

        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zone = 0;
        $error = false;

        $lb = $lbs = $separated_weight * 2.2046226;
        $shipping_price = 0;
        if ($lbs > 75) {
            $lbs = $lbs % 75;
        }

        //$order_total_amount = $_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices();

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_DHLAZONES_COUNTRIES_' . $i);
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
            $zones_cost = constant('MODULE_SHIPPING_DHLAZONES_COST_' . $dest_zone);
            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            if ($lb > 75) {
                $shipping_price = intval($lb / 75) * $zones_table[$size - 1];
            }
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_DHLAZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Weight'):
                        /*if (ceil($lbs) <= $zones_table[$i]) {*/
                        if ($lbs <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($lbs * $shipping_num_boxes, 2) . MODULE_SHIPPING_DHLAZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($lbs, 2) . MODULE_SHIPPING_DHLAZONES_TEXT_UNITS . ')';
                                    break;
                            }

                            $shipping_method = MODULE_SHIPPING_DHLAZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_DHLAZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];
                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_DHLAZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_method = MODULE_SHIPPING_DHLAZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_DHLAZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_DHLAZONES_HANDLING_' . $dest_zone);

                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_DHLAZONES_EXTRA_FEE));
                        /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
                        break;
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_DHLAZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_DHLAZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_DHLAZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost += $shipping_price;
        $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL);

        return $shipping_cost;
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
    function quotes($method = '', $total_weight, $country_id, $post_code = "", $price = 0, $products_id, $purchase_qty, $states_name)
    {
        if ($country_id == 223) {
            $states_name = fs_get_data_from_db_fields('states', 'countries_to_zip', 'zip = "' . $post_code . '"');
            $states_name = $states_name ?: 'Washington';
        } else {
            $cabinet_ca_default_price = ['73579' => 2700, '73958' => 2400];
            $cabinet_mx_default_price = ['73579' => 2000, '73958' => 1900];
            $cabinet_default_price = $country_id == 38 ? $cabinet_ca_default_price[$products_id] : $cabinet_mx_default_price[$products_id];
        }

        if (!empty($states_name)) {
            $cabinet_shipping_price = fs_get_data_from_db_fields('price', 'shipping_ups_ltl', 'products_id = ' . $products_id . ' AND country_id ="' . $country_id . '" AND (state = "' . $states_name . '" OR state_abb = "' . $states_name . '")');
            //加50块达到运费的安全值
            $cabinet_shipping_price = $cabinet_shipping_price + 50;
        } else {
            $cabinet_shipping_price = $cabinet_default_price;
        }

        $shipping_cost = $cabinet_shipping_price * $purchase_qty;
        $shipping_zones = zen_get_shipping_fedex_code_zone($post_code, 1, 'groud_zone');
        $states = $shipping_zones ? $shipping_zones : '##';
        $shipping_method = MODULE_SHIPPING_UPSLTLZONES_TEXT_WAY . ' ' . $states;

        $this->quotes = array(
            'id' => $this->code,
            'module' => MODULE_SHIPPING_UPSLTLZONES_TEXT_TITLE,
            'methods' => array(
                array(
                    'id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost
                )
            )
        );

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPSLTLZONES_SKIPPED, $states)) {
            // don't show anything for this country
            $this->quotes = array();
        }
        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSLTLZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPSLTLZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPSLTLZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPSLTLZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPSLTLZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPSLTLZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_UPSLTLZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }
        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPSLTLZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_UPSLTLZONES_DAYS_ZONES_" . $i . "','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_UPSLTLZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_UPSLTLZONES_STATUS', 'MODULE_SHIPPING_UPSLTLZONES_METHOD', 'MODULE_SHIPPING_UPSLTLZONES_TAX_CLASS', 'MODULE_SHIPPING_UPSLTLZONES_TAX_BASIS', 'MODULE_SHIPPING_UPSLTLZONES_SORT_ORDER', 'MODULE_SHIPPING_UPSLTLZONES_DAYS', 'MODULE_SHIPPING_UPSLTLZONES_SKIPPED', 'MODULE_SHIPPING_UPSLTLZONES_EXTRA_FEE');

        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSLTLZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSLTLZONES_DAYS_' . $i;
        }
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSLTLZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSLTLZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSLTLZONES_HANDLING_' . $i;
        }

        return $keys;
    }
}
