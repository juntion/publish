<?php


class upszones
{
    var $code, $title, $description, $enabled, $num_zones;

    //超规格产品
    private $SuperSpeProducts = array(
        array(
            'is_show' => 0,
            'products' => [73579, 73958, 96682, 96683],
            'core' => [],
            'length' => 0
        ),
        array(
            'is_show' => 0,
            'products' => [70220, 71448, 70402, 70221],
            'core' => [1065, 1094],
            'length' => 1000
        ),
        array(
            'is_show' => 0,
            'products' => [76880],
            'core' => [7487, 7773],
            'length' => 0
        ),
        array(
            'is_show' => 1,
            'products' => [
                73984, 97949, 76887, 74126, 63033, 63030,
                74154, 74155, 74156, 74157, 74158
            ],
            'core' => [],
            'length' => 0
        ),
        array(
            'is_show' => 1,
            'products' => [
                39036, 39051, 39045, 39031, 20720, 17770,
                33501, 20781, 20745, 20828, 20777, 20809
            ],
            'core' => [],
            'length' => 1000
        ),
        array(
            'is_show' => 1,
            'products' => [70220, 71448, 70402, 70221],
            'core' => [3381],
            'length' => 1000
        )
    );

    /**
     * @var array 亚太地区国家
     */
    private $AsiaPacCountry = ['HK', 'ID', 'JP', 'KR', 'MO', 'MY', 'PH', 'SG', 'TW', 'TH', 'VN'];
    /**
     * @var array 欧洲,印度地区
     */
    private $EuCountry = [
        'AT', 'BE', 'CZ', 'DK', 'FI', 'FR', 'DE', 'HU', 'IE', 'IT', 'LU', 'NL', 'NO', 'PL', 'PT',
        'ES', 'SE', 'CH', 'UK', 'IN'
    ];
    /**
     * @var array 澳洲地区
     */
    private $AuCountry = ['AU', 'NZ'];

    // class constructor
    function upszones()
    {
        $this->code = 'upszones';
        $this->codes = 'UPS';
        $this->title = MODULE_SHIPPING_UPSZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_UPSZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_UPSZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/upszones/ups_logo.gif';
        $this->tax_class = MODULE_SHIPPING_UPSZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_UPSZONES_TAX_BASIS;
        $this->extra_rate = 1.2;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_UPSZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 16;
        $this->num_zones_days = 5;
    }

    // class methods
    function quote($method = '')
    {
        global $order, $shipping_weight, $shipping_num_boxes, $total_count, $total_weight, $currencies;
        $dest_country = $order->delivery['country']['iso_code_2'];
        $shipping_weight = $total_weight;
        $dest_zone = 0;
        $error = false;

        if (in_array($dest_country, ['IT', 'GB', 'IN'])) {//因疫情影响,当前ups暂不发往这三个国家
            return array();
        }

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_UPSZONES_COUNTRIES_' . $i);
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
            $zones_cost = constant('MODULE_SHIPPING_UPSZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_UPSZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Weight'):
                        if (($shipping_weight) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($shipping_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_UPSZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($shipping_weight, 2) . MODULE_SHIPPING_UPSZONES_TEXT_UNITS . ')';
                                    break;
                            }

                            //$shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $shipping_weight . ' ' . MODULE_SHIPPING_UPSZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            $shipping = $zones_table[$i + 1];

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_method = MODULE_SHIPPING_UPSZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_UPSZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);

                        //$handfee_rate = 1;//--hand fee

                        if ($total_weight > 20) {
                            $shipping_cost = $shipping * $total_weight;
                        } else {
                            $shipping_cost = $shipping;
                        }
                        if ($order->delivery['company_type'] == 'IndividualType') {
                            //公司类型为IndividualType 加收20RMB
                            $shipping_cost = $shipping_cost + 20;
                        }
                        $shipping_cost = ($shipping_cost * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE)) / $currencies->currencies['CNY']['value'];//--get the shipping cost
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost = $shipping_cost * $this->extra_rate;
        $is_show_ups = true;
        $order_products = $order->delay_products;
        if ($order->local_warehouse == 2) {
            $order_products = array_merge($order->delay_products, $order->local_products, $order->global_products);
        }
        //出现以下产品时或者单件产品超过70kg不展示
        $limit_products = [73937, 73938, 73941, 73942, 73946, 73579, 73958, 70771, 21104, 69225];
        if (!empty($order_products)) {
            foreach ($order_products as $v) {
                if (in_array($v['id'], $limit_products) || $v['weight'] > 70) {
                    $is_show_ups = false;
                    break;
                }
            }
        }

        if($order->local_warehouse == 2){
            $rs_products = array_merge($order->local_products, $order->delay_products);
        }else{
            $rs_products = $order->delay_products;
        }
        $is_spe = false;
        $all_spe_qty = 0;

        //判断附加费
        foreach ($rs_products as $products_info){

            $products_id = (int)$products_info['id'];
            $spe_qty = (int)$products_info['qty'];

            //判断超规格产品附加费
            foreach ($this->SuperSpeProducts as $spe_arr_info) {
                $spe_arr_id = $spe_arr_info['products'];
                if (in_array($products_id, $spe_arr_id)) {
                    $s_core = $spe_arr_info['core'];
                    $s_len = $spe_arr_info['length'];
                    $is_s_core = empty($s_core) ? true : false;
                    $is_s_len = $s_len == 0 ? true :false;

                    //该产品需判断定制属性
                    if(!empty($products_info['attributes'])){
                        foreach ($products_info['attributes'] as $attributes_info){
                            $value = $attributes_info['value'];
                            $value_id = $attributes_info['value_id'];
                            $option = $attributes_info['option'];
                            if ($value == 'length') {
                                if ($option >= floatval($s_len)) {
                                    $is_s_len = true;
                                }
                            } else {
                                if (in_array($value_id, $s_core)) {
                                    $is_s_core = true;
                                }
                            }
                        }
                    }
                    if( $spe_arr_info['is_show'] == 0 && $is_s_len && $is_s_core){
                        $is_show_ups = false;
                    }

                }
                if (!$is_show_ups) {
                    break 2;
                }
                if ($is_s_len && $is_s_core) {
                    $is_spe = true;
                    $all_spe_qty += $spe_qty;
                    break;
                }
            }

        }

        if ($shipping_cost && $is_show_ups) {
            $total = $order->global_info['subtotal'] + $order->delay_info['subtotal'] + $order->local_info['subtotal'];
            if ($total < (5000 / $currencies->currencies["CNY"]['value'])) {
                $shipping_cost = $shipping_cost + 13;
            }
            $extra_product = [70856, 70855, 73945, 74126];
            $extra_cost = 0;
            $extra_fee = 40 / $currencies->currencies["CNY"]['value'];
            if (!empty($order_products)) {
                foreach ($order_products as $v) {
                    if (in_array($v['id'], $extra_product) || $v['weight'] > 32) {
                        $extra_cost += $extra_fee * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE) * $v['qty'];
                    }
                    if ($v['id'] == 70993) {
                        $extra_cost += (378 / $currencies->currencies["CNY"]['value']) * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE) * $v['qty'];
                    }
                }
            }
            $shipping_cost += $extra_cost;

            //因疫情影响,这些国家要加附加费
            switch (true) {
                case in_array($dest_country, $this->EuCountry) :
                    $mul_standard = 10.8;
                    break;
                case in_array($dest_country, $this->AsiaPacCountry) :
                    $mul_standard = 5.4;
                    break;
                case in_array($dest_country, $this->AuCountry) :
                    $mul_standard = 28.8;
                    break;
                default:
                    $mul_standard = 19.8;
                    break;
            }

            $mul_price = ceil($total_weight) * $mul_standard * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE)
                / $currencies->currencies["CNY"]['value'];
            $shipping_cost += $mul_price;

            if($is_spe){
                $shipping_cost += 48 * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $all_spe_qty /
                    $currencies->currencies['CNY']['value'];
            }

            $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;

            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_UPSZONES_TEXT_TITLE,
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

        if (strstr(MODULE_SHIPPING_UPSZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSZONES_INVALID_ZONE;
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

        if (in_array($dest_country, ['IT', 'GB', 'IN'])) {//因疫情影响,当前ups暂不发往这三个国家
            return array();
        }

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_UPSZONES_COUNTRIES_' . $i);
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
            $zones_cost = constant('MODULE_SHIPPING_UPSZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_UPSZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Weight'):
                        if (($shipping_weight) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($shipping_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_UPSZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($shipping_weight, 2) . MODULE_SHIPPING_UPSZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $shipping_weight . ' ' . MODULE_SHIPPING_UPSZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            $shipping = $zones_table[$i + 1];

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Price'):
// shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Item'):
// shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_UPSZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_method = MODULE_SHIPPING_UPSZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_UPSZONES_METHOD) {
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);

                        //$handfee_rate = 1;//--hand fee

                        if ($total_weight > 20) {
                            $shipping_cost = $shipping * $total_weight;
                        } else {

                            $shipping_cost = $shipping;
                        }
                        $shipping_cost = ($shipping_cost * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE)) / $currencies->currencies['CNY']['value'];//--get the shipping cost
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_UPSZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_UPSZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }

        $shipping_cost = $shipping_cost * $this->extra_rate;

        //判断附加费
        $is_spe = false;
        $all_spe_qty = $products_info['purchase_qty'];
        $is_show_ups = true;
        $products_id = (int)$products_info['products_id'];

        //判断超规格产品附加费
        foreach ($this->SuperSpeProducts as $spe_arr_info) {
            $spe_arr_id = $spe_arr_info['products'];
            if (in_array($products_id, $spe_arr_id)) {
                $s_core = $spe_arr_info['core'];
                $s_len = $spe_arr_info['length'];
                $is_s_core = empty($s_core) ? true : false;
                $is_s_len = $s_len == 0 ? true : false;

                //该产品需判断定制属性
                if(!empty($products_info['attributes'])){
                    foreach ($products_info['attributes'] as $a_key => $a_value){
                        if (strval($a_key) === 'length') {
                            if ($a_value >= floatval($s_len)) {
                                $is_s_len = true;
                            }
                        } else {
                            if (in_array($a_value, $s_core)) {
                                $is_s_core = true;
                            }
                        }
                    }
                }
                if($spe_arr_info['is_show'] == 0 && $is_s_len && $is_s_core){
                    $is_show_ups = false;
                }
            }
            if (!$is_show_ups) {
                break;
            }
            if ($is_s_len && $is_s_core) {
                $is_spe = true;
                break;
            }
        }

        if ($shipping_cost && $is_show_ups) {
            if ($price < (5000 / $currencies->currencies["CNY"]['value'])) {
                $shipping_cost = $shipping_cost + 13;
            }

            //出现以下产品时或者单件产品超过70kg不展示
            $limit_products = [73937, 73938, 73941, 73942, 73946, 73579, 73958, 70771, 21104, 69225];
            if ((in_array($products_info['products_id'], $limit_products) || $products_info['weight'] > 70) && $products_info['qty'] == 0) {
                return array();
            }

            $extra_product = [70856, 70855, 73945, 74126];
            $extra_cost = 0;
            $extra_fee = 40 / $currencies->currencies["CNY"]['value'];

            if (in_array($products_info['products_id'], $extra_product) || $products_info['weight'] > 32) {
                $extra_cost += $extra_fee * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE) * $products_info['purchase_qty'];
            }
            if ($products_info['products_id'] == 70993) {
                $extra_cost += (378 / $currencies->currencies["CNY"]['value']) * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE) * $products_info['qty'];
            }

            $shipping_cost += $extra_cost;

            //因疫情影响,这些国家要加附加费
            switch (true) {
                case in_array($dest_country, $this->EuCountry) :
                    $mul_standard = 10.8;
                    break;
                case in_array($dest_country, $this->AsiaPacCountry) :
                    $mul_standard = 5.4;
                    break;
                case in_array($dest_country, $this->AuCountry) :
                    $mul_standard = 28.8;
                    break;
                default:
                    $mul_standard = 19.8;
                    break;
            }

            $mul_price = ceil($total_weight) * $mul_standard * (1 + MODULE_SHIPPING_UPSZONES_EXTRA_FEE)
                / $currencies->currencies["CNY"]['value'];
            $shipping_cost += $mul_price;

            if($is_spe){
                $shipping_cost += 48 * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $all_spe_qty /
                    $currencies->currencies['CNY']['value'];
            }

            $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_UPSZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            $this->quotes = array();
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPSZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPSZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPSZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPSZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPSZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPSZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPSZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPSZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPSZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPSZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPSZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_UPSZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPSZONES_EXTRA_FEE', '填写UPS的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        }
        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPSZONES_DAYS','3-7 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_UPSZONES_DAYS_ZONES_" . $i . "','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_UPSZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_UPSZONES_STATUS', 'MODULE_SHIPPING_UPSZONES_METHOD', 'MODULE_SHIPPING_UPSZONES_TAX_CLASS', 'MODULE_SHIPPING_UPSZONES_TAX_BASIS', 'MODULE_SHIPPING_UPSZONES_SORT_ORDER', 'MODULE_SHIPPING_UPSZONES_DAYS', 'MODULE_SHIPPING_UPSZONES_SKIPPED', 'MODULE_SHIPPING_UPSZONES_EXTRA_FEE');

        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSZONES_DAYS_' . $i;
        }
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_UPSZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_UPSZONES_HANDLING_' . $i;
        }

        return $keys;
    }
}

?>