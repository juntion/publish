<?php


class upsstandardzones {
    var $code, $title, $description, $enabled, $num_zones,$num_zones_days,$handfee_rate;

// class constructor
    function upsstandardzones(){
        $this->code = 'upsstandardzones';
        $this->codes = 'Upsstandard';
        $this->title = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_UPSSTANDARDZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/upsstandardzones/dhl_logo.gif';
        $this->tax_class = MODULE_SHIPPING_UPSSTANDARDZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_UPSSTANDARDZONES_TAX_BASIS;


        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_UPSSTANDARDZONES_STATUS == 'True') ? true : false);
        }

        //$this->handfee_rate = 1.215;
        $this->extra_rate = 1;


        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 15;
        $this->num_zones_days = 5;
    }
// class methods
    function quote($method = '',$order_tag = false)
    {

        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies, $separated_weight;
        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zone = 0;
        $error = false;
        $total_weight_new = $total_weight;
        $local_total = $order->local_info['subtotal'] + $order->delay_info['subtotal'];
        if (empty($local_total)) {
            $show_total = $_SESSION['cart']->show_total();
        } else {
            $show_total = $local_total;
        }
        $show_total = $show_total * $currencies->currencies['EUR']['value'];
        $status = $order_tag == 'local' ? $order->is_local_buck : $order->is_buck;
        $is_shipping_free = $order_tag == 'local' ? $order->local_info['is_shipping_free'] : $order->delay_info['is_shipping_free'];
        if (in_array($dest_country, ['FR', 'CH', 'NO', 'IE', 'GB'])) {
            $is_shipping_free = false;
        }
        if(in_array($dest_country, ['IT'])){
            return [];
        }
        if (fs_shipping_de_ups_is_free($dest_country, $show_total, 'ups', $is_shipping_free)) {
            $total_weight_new = $separated_weight;
        }
        $postcode = $order->delivery['postcode'];
        if(in_array($dest_country,array('GB','ES','IT','VA'))){
            $dest_res = zen_get_shipping_upsstandard_code_zone($dest_country,$postcode);
            $dest_zone = $dest_res['zone'];
        }else {
            for ($i = 1; $i <= $this->num_zones; $i++) {
                $countries_table = constant('MODULE_SHIPPING_UPSSTANDARDZONES_COUNTRIES_' . $i);
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
        }
        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping = -1;

            $zones_cost = constant('MODULE_SHIPPING_UPSSTANDARDZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Weight'):
                        /*if (ceil($total_weight) <= $zones_table[$i]) {*/
                        if ($total_weight_new <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($total_weight_new * $shipping_num_boxes, 2) . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight_new, 2) . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_UNITS . ')';
                                    break;
                            }

                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            if ($total_weight_new > 70) {
                                $shipping = $zones_table[$i+1] * $total_weight_new;
                            } else {
                                $shipping = $zones_table[$i + 1];
                            }



                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_UPSSTANDARDZONES_EXTRA_FEE)) / $currencies->currencies['EUR']['value'];
                        /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost = $shipping_cost * $this->extra_rate;
        //$show_total = $_SESSION['cart']->show_total();
        if($shipping_cost){
            if($order->delivery['company_type'] == 'IndividualType'){
                //公司类型为IndividualType 加收 2.5 欧元
                $shipping_cost = $shipping_cost + (2.5/$currencies->currencies['EUR']['value']);
            }
            if(in_array($dest_country,['GB','IM']) && !$order->is_ireland_zones){  //英国脱欧项目  收货地址为英国且非北爱尔兰 马恩岛时 UPS系列边境费加5欧元
                $shipping_cost +=  5 / $currencies->currencies['EUR']['value'];
            }

            //判断是否 超尺寸
            $is_over_size = false;
            $is_over_weight = false;
            switch ($order_tag){
                case 'local':
                    $is_over_size = $order->is_local_oversize;
                    $is_over_weight = $order->is_local_overweight;
                    break;
                case 'delay':
                    $is_over_size = $order->is_delay_oversize;
                    $is_over_weight = $order->is_delay_overweight;
                    break;
            }
            if($dest_country == 'FR' && !$status){//法国无重货不展示
                return [];
            }
            if ($status) {
                $over_fee = 15;
                if ($dest_country != "DE") {
                    $over_fee = 17;
                }
                if ($is_over_size || $is_over_weight) {
                    if (($dest_country == "ES" && !empty($dest_res['type'])
                            && in_array($dest_res['type'], [1, 2, 3]))) {
                        return [];
                    }
                    if ($total_weight_new > 70) {
                        return [];
                    }
                    if ($total_weight_new < 30) {
                        $shipping_cost = $shipping_cost + ($over_fee / $currencies->currencies['EUR']['value']);
                    }
                }
                if ($total_weight_new > 30) {
                    $shipping_cost = $shipping_cost + ($over_fee / $currencies->currencies['EUR']['value']);
                }
                $dhl_shipping_cost = 0;
                if ($order_tag == 'delay') {
                    if (in_array(73579, $order->delay_info['products_arr'])
                        || in_array(73958, $order->delay_info['products_arr'])) {
                        $shipping_cost += $total_weight_new * (50 / $currencies->currencies['CNY']['value']);
                    } else {
                        require_once DIR_WS_MODULES . 'shipping/dhlzones.php';
                        $dhlservice = new dhlzones();
                        $dhl_shipping_arr = $dhlservice->quote('', '', $total_weight_new);
                        $dhl_shipping_cost = $dhl_shipping_arr['methods'][0]['cost'];
                        $shipping_cost += $dhl_shipping_cost;
                    }
                }
            }
            if (fs_shipping_de_ups_is_free($dest_country, $show_total, 'ups',$is_shipping_free) && !$status) {
                $shipping_cost = 0;
            }

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        }else{
            return array();
        }

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_UPSSTANDARDZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSSTANDARDZONES_INVALID_ZONE;
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(),$zone_type='',$is_shipping_free=false,$products_info = [])
    {

        global $order, $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $country;
        $dest_zone = 0;
        $error = false;
        if(in_array($dest_country,array('GB','ES','IT','VA'))){
            $dest_res = zen_get_shipping_upsstandard_code_zone($dest_country,$post_code);
            $dest_zone = $dest_res['zone'];
        }else {
            for ($i = 1; $i <= $this->num_zones; $i++) {
                $countries_table = constant('MODULE_SHIPPING_UPSSTANDARDZONES_COUNTRIES_' . $i);
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
        }
        
        if(in_array($dest_country, ['IT'])){
            return [];
        }

        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping = -1;

            $zones_cost = constant('MODULE_SHIPPING_UPSSTANDARDZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Weight'):
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
                                    $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight, 2) . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_UNITS . ')';
                                    break;
                            }

                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            if ($total_weight > 70) {
                                $shipping = $zones_table[$i + 1] * $total_weight;
                            } else {
                                $shipping = $zones_table[$i + 1];
                            }


                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_method = MODULE_SHIPPING_UPSSTANDARDZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_UPSSTANDARDZONES_EXTRA_FEE)) / $currencies->currencies['EUR']['value'];
                        /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_UPSSTANDARDZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost = $shipping_cost * $this->extra_rate;
        //$show_total = $_SESSION['cart']->show_total();
        $show_total = $price * $currencies->currencies['EUR']['value'];
        if ($shipping_cost) {

            if(in_array($dest_country,['FR','CH','NO','IE','GB'])){
                $is_shipping_free = false;
            }
            if($dest_country == 'FR' && !$is_buck){//法国无重货不展示
                return [];
            }
            if(in_array($dest_country,['GB','IM'])){ //英国脱欧项目  收货地址为英国 马恩岛时 UPS系列边境费加5欧元
                $shipping_cost +=  5 / $currencies->currencies['EUR']['value'];
            }
            //判断是否 超尺寸
            if ($is_buck) {
                $over_fee = 15;
                if ($dest_country != "DE") {
                    $over_fee = 17;
                }
                $is_over_weight = $total_weight > 70;
                $is_over_size = $products_info['over_size'];
                $qty = $products_info['qty'];
                if ($is_over_size || $is_over_weight) {
                    if (($dest_country == "ES" && !empty($dest_res['type'])
                            && in_array($dest_res['type'], [1, 2, 3]))) {
                        return [];
                    }
                    if ($total_weight < 30) {
                        $shipping_cost = $shipping_cost + ($over_fee / $currencies->currencies['EUR']['value']);
                    }
                }
                if ($total_weight > 30) {
                    $shipping_cost = $shipping_cost + ($over_fee / $currencies->currencies['EUR']['value']);
                }
                if ($qty == 0) {
                    if (in_array($products_info['products_id'], [73579, 73958])) {
                        $shipping_cost += $total_weight * (50 / $currencies->currencies['CNY']['value']);
                    } else {
                        require_once DIR_WS_MODULES . 'shipping/dhlzones.php';
                        $dhlservice = new dhlzones();
                        $dhl_shipping_arr = $dhlservice->quotes($method, $total_weight, $country, $post_code, $price
                            , $state, $is_buck, $length_array, $zone_type, $is_shipping_free, $products_info);
                        $dhl_shipping_cost = $dhl_shipping_arr['methods'][0]['cost'];
                        $shipping_cost += $dhl_shipping_cost;
                    }
                }
            }
            if (fs_shipping_de_ups_is_free($dest_country, $show_total,"ups",$is_shipping_free) && !$is_buck) {
                $shipping_cost = 0;
            }
            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            return array();
        }


        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_UPSSTANDARDZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSSTANDARDZONES_INVALID_ZONE;
        }
        return $this->quotes;
    }

    function check() {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSSTANDARDZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install() {
        global $db;
        if (!defined('MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_EXTRA_FEE', '填写DHL的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_UPSSTANDARDZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }

        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPSSTANDARDZONES_DAYS','3-7 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i=1; $i<=$this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone".$i."','MODULE_SHIPPING_UPSSTANDARDZONES_DAYS_ZONES_".$i."','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_".$i."','MODULE_SHIPPING_UPSSTANDARDZONES_DAYS_".$i."','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }



    }

    function remove() {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
        $keys = array('MODULE_SHIPPING_UPSSTANDARDZONES_STATUS', 'MODULE_SHIPPING_UPSSTANDARDZONES_METHOD', 'MODULE_SHIPPING_UPSSTANDARDZONES_TAX_CLASS', 'MODULE_SHIPPING_UPSSTANDARDZONES_TAX_BASIS', 'MODULE_SHIPPING_UPSSTANDARDZONES_SORT_ORDER','MODULE_SHIPPING_UPSSTANDARDZONES_DAYS', 'MODULE_SHIPPING_UPSSTANDARDZONES_SKIPPED','MODULE_SHIPPING_UPSSTANDARDZONES_EXTRA_FEE');
        for ($i=1; $i<=$this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSSTANDARDZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSSTANDARDZONES_DAYS_' . $i;
        }

        for ($i=1; $i<=$this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSSTANDARDZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSSTANDARDZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSSTANDARDZONES_HANDLING_' . $i;
        }
        return $keys;
    }
}
