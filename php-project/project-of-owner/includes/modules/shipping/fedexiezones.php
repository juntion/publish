<?php


class fedexiezones
{
    var $code, $title, $description, $enabled, $num_zones;

    // fairy 2019.2.18 add  巴西 59196000，此邮编FedEx无服务，需要隐藏IP和IE
    private $special_country_post = array(
        'post_code' => '59196000',
        'dest_country' => 'BR',
    );

    //大陆美线出口国家
    private $line_to_us = array(
        'US','CA','MX','AI','AG','AR','AW','BS','BD','BB','BZ','BM','BT','BO',
        'BR','VG','KY','CL','CO','CR','DM','DO','EC','SV','GF','GD','GP','GT',
        'GY','HT','HN','JM','MV','MQ','MS','NP','PK','PA','PY','PE','LK','BL',
        'KN','MF','VC','SR','TT','TC','VI','UY','PR'
    );

    //大陆欧线出口国家
    private $line_to_de = array(
        'AL','AD','AM','AT','AZ','BE','BG','HR','CZ','DK','EE','FO','FI','FR',
        'GE','DE','GI','GR','GL','HU','IS','IE','IL','IT','KZ','KG','LV','LI',
        'LT','LU','MK','MT','MD','MC','ME','NL','NO','PS','PL','PT','RO','RU',
        'RS','SK','SI','ES','SE','CH','UA','GB','UZ','AF','DZ','AO','BH','BJ',
        'BW','BF','BI','CM','CV','TD','CG','CY','DJ','EG','ER','ET','GA','GM',
        'GH','GN','IN','JO','KE','KW','LS','LR','MG','MW','ML','MR','MU','MA',
        'MZ','NA','NE','NG','OM','QA','RE','RW','SA','SN','SC','ZA','SZ','TZ',
        'TG','TN','TR','UG','AE','ZM'
    );

    //大陆中东线出口国家
    private $line_to_em = array(
        'AS', 'CK', 'TL', 'FJ', 'PF', 'MH',
        'FM', 'NC', 'PW', 'PG', 'WS', 'TO',
        'VU', 'WF', 'CI'
    );

    //大陆亚线出口国家
    private $line_to_cn = array(
        'MO','VN','MN','JP','MY','TH','PH',
        'ID','HK','TW','SG','KR'
    );

    //大陆澳线出口国家
    private $line_to_au = array(
        'AS','AU','BN','CK','FJ','FM','GU','KH','LA','MH','MP','NC','NZ','PF',
        'PG','PW','TL','TO','VU','WF','WS'
    );

    // class constructor
    function fedexiezones()
    {
        $this->code = 'fedexiezones';
        $this->codes = 'FedEx_IE';
        $this->title = MODULE_SHIPPING_FEDEXIEZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_FEDEXIEZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_FEDEXIEZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/fedexiezones/fedexie_logo.gif';
        $this->tax_class = MODULE_SHIPPING_FEDEXIEZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_FEDEXIEZONES_TAX_BASIS;

        $this->extra_rate = 1.2;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_FEDEXIEZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 24;
        $this->num_zones_days = 5;
    }

    // class methods
    function quote($method = '', $order_tag = false)
    {

        global $order, $total_weight, $shipping_num_boxes, $total_count, $currencies, $db, $separated_weight;

        if (0 == $total_weight) {
            return array('id' => $this->code,
                'module' => MODULE_SHIPPING_FEDEXIEZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $this->code)));
        }

        /*eof calulate the shipping cost drop products weight in 2 special categories*/

        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zone = 0;
        $error = false;


        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_FEDEXIEZONES_COUNTRIES_' . $i);
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
            $zones_cost = constant('MODULE_SHIPPING_FEDEXIEZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_FEDEXIEZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Weight'):
                        /*if (ceil($separated_weight) <= $zones_table[$i]) {*/
                        if ($separated_weight <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($separated_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($separated_weight, 2) . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $separated_weight . ' ' . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            $shipping = $zones_table[$i + 1];

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_cost = -1;
                $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_FEDEXIEZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        //$shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);

                        if ($separated_weight > 20.5) {
                            $shipping_cost = $shipping * $separated_weight;
                        } else {

                            $shipping_cost = $shipping;
                        }
                        if (in_array($order->delivery['country_id'], array(223, 38)) && $order->delivery['company_type'] == 'IndividualType') {
                            //美国、加拿大 公司类型为IndividualType 加收24RMB
                            $shipping_cost = $shipping_cost + 24;
                        }
                        $shipping_cost = $shipping_cost * (1 + MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE) / $currencies->currencies['CNY']['value'];
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }

        // fairy 2019.2.18 add
        $post_code = $order->delivery['postcode'];
        if ($shipping_cost == -1 || intval($shipping_cost) == 0 || ($post_code == $this->special_country_post['post_code'] && $dest_country == $this->special_country_post['dest_country'])) {
            $this->quotes = array();
        } else {
            $shipping_cost = $shipping_cost * $this->extra_rate;
            //港澳台<=20kg   FEDEX IE免运费;21kg-99kg  DHL免运费;>= 100kg  FEDEX IE免运费;
            if (in_array($order->delivery['country']["id"], array(96, 125, 206))) {
                if ($separated_weight <= 20 || $separated_weight > 99) {
                    $shipping_cost = 0;
                }
            } else {
                if (!(check_au_remote_areas($order->delivery['postcode']) && $dest_country == 'AU')) {//排除掉澳洲偏远地区和新加坡地区

                    switch ($order_tag) {
                        case 'global':
                            $shipping_cost = $order->global_info['is_shipping_free'] ? 0 : $shipping_cost;
                            break;
                        case 'local':
                            $shipping_cost = $order->local_info['is_shipping_free'] && !$order->is_local_buck ? 0 : $shipping_cost;
                            break;
                        case 'delay':
                            /*
                             * 中国直发美国和新加坡的订单重量≤20.5kg，FEDEX IE免运费；
                             *
                             * @author aron
                             * @date 2019.11.18
                             */
                            $is_free = ($separated_weight <= 20.5 && in_array($order->delivery['country']["id"], [223, 188, 38, 138, 172]));
                            $shipping_cost = $order->delay_info['is_shipping_free'] && $is_free && !$order->is_buck ? 0 : $shipping_cost;
                            break;
                        case 'delay-global':
                            if (!$order->is_buck && $order->delay_info['is_shipping_free'] && $order->global_info['is_shipping_free']) {
                                $shipping_cost = 0;
                            }
                            break;
                    }
                }
            }
            if ($shipping_cost != 0) {
                //新增临时航线调整附加费
                //欧美,中东 联合线
                $union_line = array_merge($this->line_to_us, $this->line_to_de, $this->line_to_em);
                switch (true){
                    case in_array($dest_country, $this->line_to_cn):
                        $shipping_surcharge = $separated_weight * 3.5;
                        break;
                    case in_array($dest_country, $union_line):
                        $shipping_surcharge = $separated_weight * 7;
                        break;
                    default:
                        $shipping_surcharge = $separated_weight * 14;
                        break;
                }
                //附加费最低7人民币
                $shipping_surcharge = $shipping_surcharge > 7 ? $shipping_surcharge : 7;
                $shipping_cost += $shipping_surcharge * (1 + MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE) / $currencies->currencies['CNY']['value'];

                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            }

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_FEDEXIEZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        }
        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_FEDEXIEZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_FEDEXIEZONES_INVALID_ZONE;
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
    function quotes($method = '', $total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(), $zone_type, $is_shipping_free = false)
    {

        global $order, $shipping_num_boxes, $total_count, $currencies, $db;

        if (0 == $total_weight) {
            return array('id' => $this->code,
                'module' => MODULE_SHIPPING_FEDEXIEZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $this->code)));
        }

        /*eof calulate the shipping cost drop products weight in 2 special categories*/

        $dest_country = $country;
        $dest_zone = 0;
        $error = false;


        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_FEDEXIEZONES_COUNTRIES_' . $i);
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
            $zones_cost = constant('MODULE_SHIPPING_FEDEXIEZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_FEDEXIEZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Weight'):
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
                                    $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes, 2) . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight, 2) . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_FEDEXIEZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            $shipping = $zones_table[$i + 1];

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Price'):
// shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i + 1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Item'):
// shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_cost = -1;
                $shipping_method = MODULE_SHIPPING_FEDEXIEZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_FEDEXIEZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
//              $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);

                        if ($total_weight > 20.5) {
                            $shipping_cost = $shipping * $total_weight;
                        } else {

                            $shipping_cost = $shipping;
                        }
                        $shipping_cost = $shipping_cost * (1 + MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE) / $currencies->currencies['CNY']['value'];
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_FEDEXIEZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }

        // fairy 2019.2.18 add
        $post_code = $order->delivery['postcode'];
        if ($shipping_cost == -1 || intval($shipping_cost) == 0 || ($post_code == $this->special_country_post['post_code'] && $dest_country == $this->special_country_post['dest_country'])) {
            $this->quotes = array();
        } else {
            $shipping_cost = $shipping_cost * $this->extra_rate;
            //港澳台<=20kg   FEDEX IE免运费;21kg-99kg  DHL免运费;>= 100kg  FEDEX IE免运费;
//            if (in_array($country, array("HK", "MO", "TW"))) {
//                if ($total_weight <= 20 || $total_weight >= 100) {
//                    $shipping_cost = 0;
//                }
//            }
//            $is_free = ($total_weight <= 20.5 && in_array($country,['US',"SG","MX","CA",'PR']));
//            if($is_shipping_free && !$is_buck && $is_free){//预售产品价格大于免运价格
//                $shipping_cost = 0;
//            }
//
//            if($shipping_cost != 0) {
//                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
//            }



            //新增临时航线调整附加费
            $union_line = array_merge($this->line_to_us, $this->line_to_de, $this->line_to_em);
            switch (true){
                case in_array($dest_country, $this->line_to_cn):
                    $shipping_surcharge = $total_weight * 3.5;
                    break;
                case in_array($dest_country, $union_line):
                    $shipping_surcharge = $total_weight * 7;
                    break;
                default:
                    $shipping_surcharge = $total_weight * 14;
                    break;
            }
            //附加费最低7人民币
            $shipping_surcharge = $shipping_surcharge > 7 ? $shipping_surcharge : 7;
            $shipping_cost += $shipping_surcharge * (1 + MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE) / $currencies->currencies['CNY']['value'];


            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_FEDEXIEZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        }
        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_FEDEXIEZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_FEDEXIEZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check()
    {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FEDEXIEZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install()
    {
        global $db;
        if (!defined('MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_STATUS', 'True', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_FEDEXIEZONES_SKIPPED', '', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_FEDEXIEZONES_COUNTRIES_" . $i . "', '" . $default_countries . "', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_FEDEXIEZONES_COST_" . $i . "', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_FEDEXIEZONES_HANDLING_" . $i . "', '0', '" . MODULE_SHIPPING_FEDEXIEZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }
        $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_FEDEXIEZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
        for ($i = 1; $i <= $this->num_zones_days; $i++) {

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone" . $i . "','MODULE_SHIPPING_FEDEXIEZONES_DAYS_ZONES_" . $i . "','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");

            $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_" . $i . "','MODULE_SHIPPING_FEDEXIEZONES_DAYS_" . $i . "','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
        }
    }

    function remove()
    {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        $keys = array('MODULE_SHIPPING_FEDEXIEZONES_STATUS', 'MODULE_SHIPPING_FEDEXIEZONES_METHOD', 'MODULE_SHIPPING_FEDEXIEZONES_TAX_CLASS', 'MODULE_SHIPPING_FEDEXIEZONES_TAX_BASIS', 'MODULE_SHIPPING_FEDEXIEZONES_SORT_ORDER', 'MODULE_SHIPPING_FEDEXIEZONES_DAYS', 'MODULE_SHIPPING_FEDEXIEZONES_SKIPPED', 'MODULE_SHIPPING_FEDEXIEZONES_EXTRA_FEE');

        for ($i = 1; $i <= $this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_FEDEXIEZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_FEDEXIEZONES_DAYS_' . $i;
        }
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_FEDEXIEZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_FEDEXIEZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_FEDEXIEZONES_HANDLING_' . $i;
        }

        return $keys;
    }
}
