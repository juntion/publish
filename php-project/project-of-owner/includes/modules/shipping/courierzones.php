<?php

class courierzones
{
    var $code, $title, $description, $enabled, $num_zones, $num_zones_days, $handfee_rate;

// class constructor
    function courierzones()
    {
        $this->code = 'courierzones';
        $this->codes = 'courier';
        $this->title = MODULE_SHIPPING_COURIERZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_COURIERZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_COURIERZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/COURIERZONES/dhl_logo.gif';
        $this->tax_class = MODULE_SHIPPING_COURIERZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_COURIERZONES_TAX_BASIS;
        $this->enabled = true;
    }

// class methods
    function quote($method = '', $order_tag = false)
    {
        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $order->delivery['country']['iso_code_2'];
        $company_type = $order->delivery['company_type'];
        //ru对公运输方式
        if ($company_type == "BusinessType" && $dest_country == 'RU') {

            $is_only_buck = false;
            $is_ru_local_shipping = false;//是否只计算俄罗斯分仓local的1000卢布
            if($order_tag == 'local'){
                $is_shipping_free = $order->local_info['is_shipping_free'];
                $shipping_weight = $order->local_info['buck_weight'];
                if($order->heavy_products == $order->local_info['products_arr']){
                    $is_only_buck = true;
                }
            }else{
                $is_shipping_free = $order->delay_info['is_shipping_free'];
                $shipping_weight = $order->delay_info['buck_weight'];
                if($order->heavy_products == $order->delay_info['products_arr']){
                    $is_only_buck = true;
                }
                if($shipping_weight && !empty($order->local_products) && !empty($order->delay_products)){
                    $is_ru_local_shipping = true;
                }
            }

            if ($is_shipping_free || $is_ru_local_shipping) {
                $shipping_cost = 0;
            } else {
                $shipping_cost = 1000 / $currencies->currencies['RUB']['value'];
            }

            $weightFee = 0;
            if ($shipping_weight) { //存在重货
                $weightFee = $this->ruGetDhlShippingCost($shipping_weight,'', $order_tag);
                if ($weightFee <= 0) { //无法调取Dhl的运费规则
                    return [];
                }
            }
            if($is_only_buck){
                $shipping_cost = $weightFee;
            }else{
                $shipping_cost += $weightFee;
            }
        } else {
            return [];
        }
        $this->quotes = array('id'      => $this->code,
                              'module'  => MODULE_SHIPPING_COURIERZONES_TEXT_TITLE,
                              'methods' => array(array('id'    => $this->code,
                                                       'ids'   => $this->codes,
                                                       'title' => $this->title,
                                                       'cost'  => $shipping_cost)));
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
        global  $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $country;
        $dest_zone = 0;
        $total = $price * $currencies->currencies['RUB']['value'];
        if ($total > 20000) {
            $shipping_cost = 0;
        } else {
            $shipping_cost = 1000/$currencies->currencies['RUB']['value'];
        }

        $weightFee = 0;
        if ($is_buck) { //存在重货
            $products_info = array(['weight' => ($total_weight / $products_info['purchase_qty']), 'qty' => $products_info['purchase_qty'], 'id' => $products_info['products_id']]);
            $weightFee = $this->ruGetDhlShippingCost($total_weight, $products_info);
            if ($weightFee <= 0) { //无法调取Dhl的运费规则
                return [];
            }
            $shipping_cost = $weightFee;
        }

        $this->quotes = array('id' => $this->code,
            'module' => MODULE_SHIPPING_COURIERZONES_TEXT_TITLE,
            'methods' => array(array('id' => $this->code,
                'ids' => $this->codes,
                'title' => $this->title,
                'cost' => $shipping_cost)));
        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_COURIERZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_COURIERZONES_STATUS', 'True', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_COURIERZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_COURIERZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_COURIERZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_COURIERZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_COURIERZONES_SKIPPED', '', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_COURIERZONES_EXTRA_FEE', '填写DHL的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_COURIERZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_COURIERZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_COURIERZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_COURIERZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_COURIERZONES_STATUS', 'MODULE_SHIPPING_COURIERZONES_METHOD', 'MODULE_SHIPPING_COURIERZONES_TAX_CLASS', 'MODULE_SHIPPING_COURIERZONES_TAX_BASIS', 'MODULE_SHIPPING_COURIERZONES_SORT_ORDER', 'MODULE_SHIPPING_COURIERZONES_DAYS', 'MODULE_SHIPPING_COURIERZONES_SKIPPED', 'MODULE_SHIPPING_COURIERZONES_EXTRA_FEE');
        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_COURIERZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_COURIERZONES_DAYS_' . $i;
        }

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_COURIERZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_COURIERZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_COURIERZONES_HANDLING_' . $i;
        }
        return $keys;
    }

    /**
     * 俄罗斯对公重货调取dhl的收费标准
     *
     * @param $total_weight
     * @param $products_info
     * @param $order_tag
     * @return bool|float|int
     */
    function ruGetDhlShippingCost($total_weight, $products_info = [], $order_tag = 'local')
    {
        global $currencies, $shipping_num_boxes, $total_count, $order;
        require_once DIR_WS_MODULES . "/shipping/dhlzones.php";
        $dhl = new dhlzones();
        $dest_country = "RU";
        $dest_zone = 0;
        if (strstr(MODULE_SHIPPING_DHLZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            return false;
        }
        if ($total_weight <= 20) {
            for ($i = 1; $i <= $dhl->num_zones; $i++) {
                $countries_table = constant('MODULE_SHIPPING_DHLZONES_COUNTRIES_' . $i);
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
        } else {
            $count = count($dhl->country_zone);
            for ($i = 0; $i < $count; $i++) {
                $countries_table = $dhl->country_zone[$i];
                $countries_table = strtoupper(str_replace(' ', '', $countries_table));
                $country_zones = split("[,]", $countries_table);

                if (in_array($dest_country, $country_zones)) {
                    $dest_zone = $i + 1;
                    break;
                }
            }
        }
        $shipping_cost = -1;
        if ($dest_zone == 0) {
            return false;
        } else {
            $shipping = -1;
            if ($total_weight <= 20) {
                $zones_cost = constant('MODULE_SHIPPING_DHLZONES_COST_' . $dest_zone);
            } else {
                $zones_cost = $dhl->country_num[$dest_zone - 1];
            }
            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_DHLZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Weight'):
                        /*if (ceil($total_weight) <= $zones_table[$i]) {*/
                        if ($total_weight <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_DHLZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight, 2) . MODULE_SHIPPING_DHLZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_DHLZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            if ($total_weight > 20) {
                                $shipping = $zones_table[$i + 1] * $total_weight;
                            } else {
                                $shipping = $zones_table[$i + 1];
                            }

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Price'):
// shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Item'):
// shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country;
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
                return false;
            } else {
                switch (MODULE_SHIPPING_DHLZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Weight'):

                        $shipping_cost = $shipping;
                        $shipping_cost = ($shipping_cost * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE)) / $currencies->currencies['CNY']['value'];
                        /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_DHLZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_DHLZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }


        $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL) * $dhl->extra_rate;
        $is_show_dhl = true;
        $pro_arr = $order_tag == 'local' ? $order->local_products : $order->delay_products;
        $order_products = empty($products_info) ? $pro_arr : $products_info;

        //出现以下产品时或者单件产品超过300kg不展示
//        $limit_products = [73937, 73938, 73941, 73942, 73946, 73579, 73958];
//        if (!empty($order_products)) {
//            foreach ($order_products as $v) {
//                if (in_array($v['id'], $limit_products) || $v['weight'] > 300) {
//                    $is_show_dhl = false;
//                    break;
//                }
//            }
//        }


        if ($shipping_cost && $is_show_dhl) {
            //当订单包含有ID: 70856，70855，73945，70993，70771，74126，21104，69225时，
            //选择DHL为运输方式时，运费加收600RMB*（1+燃油费率）*以上id产品的产品数量n；
            $extra_product = [70856, 70855, 73945, 70993, 70771, 74126, 21104, 69225];
            $extra_cost = 0;
            $extra_fee = 600 / $currencies->currencies["CNY"]['value'];
            if (!empty($order_products)) {
                foreach ($order_products as $v) {
                    if (in_array($v['id'], $extra_product) || $v['weight'] > 70) {
                        $extra_cost += $extra_fee * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $v['qty'];
                    }
                }
            }
            $shipping_cost += $extra_cost;

            if ($shipping_cost != 0) {
                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            }

        } else {
            return false;
        }


        return $shipping_cost;
    }
}
