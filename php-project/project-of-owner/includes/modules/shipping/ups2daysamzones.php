<?php


class ups2daysamzones
{
    var $code, $title, $description, $enabled, $num_zones;

    function ups2daysamzones()
    {
        $this->code = 'ups2daysamzones';
        $this->codes = 'UPS 2nd Day';
        $this->title = MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_UPS2DAYSAMZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/ups2dayszones/ups2days_logo.gif';
        $this->tax_class = MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_BASIS;
        $this->extra_rate = 1;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_UPS2DAYSAMZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 24;
        $this->num_zones_days = 5;
    }


    function quote($method = '')
    {

        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies, $db;
        $country_code = $order->delivery['country']['iso_code_2'];
        $location = 2;
        if (in_array($country_code, array('MX', 'CA'))) {
            $overnight_zone = '208';
        }else{
            $postcode = substr($order->delivery['postcode'], 0, 3);
            //if(!fs_order_usa_sea_deliver()) return array();
            $res = $db->Execute("select zip_from,zip_to,2day,overnight from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and  location = 2");
            $overnight_zone = $res->fields['overnight'] ? $res->fields['overnight'] : '';
            if (in_array($overnight_zone,['102','103','104','105','106','107','108','124','125','126'])){
                $location = 3;
            }else{
                $res = $db->getAll("select zip_from,zip_to,2dayam from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and location = 3  ");
                $overnight_zone =  $res[0]['2dayam'];
            }
        }

        $states = zen_get_countries_us_states_code($order->delivery['state']);
        $country = $states ? $states : 'AL';
        $dest_country = $country;
        $lbs = $total_weight * 2.2046226;

        if ($overnight_zone) {
            $day = $overnight_zone;
            if ($lbs <= 10000) {
                $list = $db->getAll("select lbs,u_" . $day . " from shipping_ups_price where location = " . $location . " order by id ASC");

                foreach ($list as $key => $v) {
                    if ($v['lbs'] >= $lbs) {
                        $shipping_cost = $list[$key]["u_" . $day] * (1 + MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE);
                        break;
                    }
                }
                if ($lbs > 150) {
                    $shipping_cost = $list[count($list) - 1]["u_" . $day] * $lbs * (1 + MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE);
                }

            } else {
                $shipping_cost = 0;
            }
        } else {
            return array();
        }

        $status = false;
        $status = $order->is_buck_in_products;

        if ($lbs > 10000) {
            $this->quotes = array();
        } else {
            $show_total = $order->local_info['subtotal'] + $order->delay_info['subtotal'];
            if ($shipping_cost) {

                if($order->delivery['company_type'] == 'IndividualType'){
                    //公司类型为IndividualType 加收 4 USD
                    $shipping_cost = $shipping_cost + 4;
                }
                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;

                if ($show_total < 79) {
                    return array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));

                }
                $days = fs_get_east_west_shipping_time($order->delivery['postcode'], 'west');
                //免运费改成收运费
                if ($lbs < 50 && $show_total >= 79 && $status == false && $days > 3) {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));
                } else {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));

                }
            } else {
                $this->quotes = array();
            }

        }


        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPS2DAYSAMZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPS2DAYSAMZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function quotes($method = '', $total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array())
    {

        global $order, $shipping_num_boxes, $total_count, $currencies, $db;
        $country_code = $country;
        $location = 2;
        if (in_array($country_code, array('MX', 'CA'))) {
            $overnight_zone = '208';
        }else{
            $postcode = substr(trim($post_code), 0, 3);
            //if(!fs_order_usa_sea_deliver()) return array();
            $res = $db->Execute("select zip_from,zip_to,2day,overnight from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and  location = 2");
            $overnight_zone = $res->fields['overnight'] ? $res->fields['overnight'] : '';
            if (in_array($overnight_zone,['102','103','104','105','106','107','108','124','125','126'])){
                $location = 3;
            }else{
                $res = $db->getAll("select zip_from,zip_to,2dayam from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and location = 3  ");
                $overnight_zone =  $res[0]['2dayam'];
            }
        }
        $states = zen_get_countries_us_states_code($state);
        $country = $states ? $states : 'AL';
        $dest_country = $country;
        $lbs = $total_weight * 2.2046226;

        if ($overnight_zone) {
            $day = $overnight_zone;
            if ($lbs <= 10000) {
                $list = $db->getAll("select lbs,u_" . $day . " from shipping_ups_price where location = " . $location . " order by id ASC");
                foreach ($list as $key => $v) {
                    if ($v['lbs'] >= $lbs) {
                        $shipping_cost = $list[$key]["u_" . $day] * (1 + MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE);
                        break;
                    }
                }
                if ($lbs > 150) {
                    $shipping_cost = $list[count($list) - 1]["u_" . $day] * $lbs * (1 + MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE);
                }

            } else {
                $shipping_cost = 0;
            }
        } else {
            return array();
        }

        $status = false;
        $status = $is_buck;

        if ($lbs > 10000) {
            $this->quotes = array();
        } else {
            $show_total = $price;
            if ($shipping_cost) {

                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;

                if ($show_total < 79) {
                    return array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));

                }
                $days = fs_get_east_west_shipping_time($order->delivery['postcode'], 'west');
                //免运费改成收运费
                if ($lbs < 50 && $show_total >= 79 && $status == false && $days > 3) {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));
                } else {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));

                }
            } else {
                $this->quotes = array();
            }

        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPS2DAYSAMZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPS2DAYSAMZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }


    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPS2DAYSAMZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }


    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPS2DAYSAMZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_UPS2DAYSAMZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }
        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS_ZONES_" . $i . "','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }


    function keys()
    {
        $keys = array('MODULE_SHIPPING_UPS2DAYSAMZONES_STATUS', 'MODULE_SHIPPING_UPS2DAYSAMZONES_METHOD', 'MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_CLASS', 'MODULE_SHIPPING_UPS2DAYSAMZONES_TAX_BASIS', 'MODULE_SHIPPING_UPS2DAYSAMZONES_SORT_ORDER', 'MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS', 'MODULE_SHIPPING_UPS2DAYSAMZONES_SKIPPED', 'MODULE_SHIPPING_UPS2DAYSAMZONES_EXTRA_FEE');

        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPS2DAYSAMZONES_DAYS_' . $i;
        }
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPS2DAYSAMZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPS2DAYSAMZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPS2DAYSAMZONES_HANDLING_' . $i;
        }

        return $keys;
    }

}