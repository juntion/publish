<?php
class dhlzones {
    var $code, $title, $description, $enabled, $num_zones,$num_zones_days,$handfee_rate;

    //超规格产品
    private $SuperSpeProducts = array(
        array(
            'is_show' => 0,
            'products' => [73579, 73958],
            'core' => [],
            'length' => 0
        ),
        array(
            'is_show' => 1,
            'products' => [
                97949, 76887, 74126, 63033,
                63030, 74154, 74155, 74156,
                74157, 74158
            ],
            'core' => [],
            'length' => 0
        ),
        array(
            'is_show' => 1,
            'products' => [70220, 71448, 70402, 70221],
            'core' => [1065, 1094],
            'length' => 1000
        ),
        array(
            'is_show' => 1,
            'products' => [61724,30850,30842,25884,31065,31066],
            'core' => [7546, 7547, 7548, 7549, 7558, 7559, 7560, 7561],
            'length' => 1000
        ),
        array(
            'is_show' => 1,
            'products' => [76880],
            'core' => [7487, 7773],
            'length' => 0
        )
    );

// class constructor
    function dhlzones(){
        $this->code = 'dhlzones';
        $this->codes = 'DHL';
        $this->title = MODULE_SHIPPING_DHLZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_DHLZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_DHLZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/dhlzones/dhl_logo.gif';
        $this->tax_class = MODULE_SHIPPING_DHLZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_DHLZONES_TAX_BASIS;
        //$this->handfee_rate = 1.215;
        $this->extra_rate = 1.2;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_DHLZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 28;
        $this->num_zones_days = 5;

        $this->country_zone = array(
            'HK,MO',
            'KR,TW',
            'JP',
            'BN,ID,KH,LA,MY,PH,SG,TH,VN',
            'AU,NZ',
            'CA,MX',
            'AD,AT,BE,BG,CH,CY,CZ,DE,DK,EE,ES,FI,FR,GB,GG,GI,GL,GR,HR,HU,IC,IE,IN,IS,IT,JE,LI,LT,LU,LV,MC,MT,NL,NO,PL,PT,SE,SI,SK,VA',
            'AE,BH,EG,IL,KW,SA,TR',
            'AF,AG,AI,AL,AM,AO,AR,AS,AW,AZ,BA,BB,BD,BF,BI,BJ,BM,BO,BR,BS,BT,BW,BY,BZ,CD,CF,CG,CI,CK,CL,CM,CO,CR,CU,CV,DJ,DM,DO,DZ,EC,ER,ET,FJ,FK,FM,FO,GA,GD,GE,GF,GH,GM,GN,GP,GQ,GT,GU,GW,GY,HN,HT,IQ,IR,JM,JO,KE,KG,KI,KM,KN,KP,KV,KY,KZ,LB,LC,LK,LR,LS,LY,MA,MD,ME,MG,MH,MK,ML,MM,MN,MP,MQ,MR,MS,MU,MV,MW,MZ,NA,NC,NE,NG,NI,NP,NR,NU,OM,PA,PE,PF,PG,PK,PR,PW,PY,QA,RE,RO,RS,RU,RW,SB,SC,SD,SH,SL,SM,SN,SO,SR,SS,ST,SV,SY,SZ,TC,TD,TG,TJ,TL,TM,TN,TO,TT,TV,TZ,UA,UG,UY,UZ,VC,VE,VG,VI,VU,WS,XB,XC,XE,XM,XN,XS,XY,YE,YT,ZA,ZM,ZW',
            'US'
        );

        $this->country_num = array(
            '20.5:258.83,21.0:262.47,21.5:266.11,22.0:269.75,22.5:273.39,23.0:277.03,23.5:280.67,24.0:284.31,24.5:287.95,25.0:291.59,25.5:295.23,26.0:298.87,26.5:302.51,27.0:306.15,27.5:309.79,28.0:313.43,28.5:317.07,29.0:320.71,29.5:324.35,30.0:327.99,70.0:11.48,300.0:12.64,99999.0:14.24',
            '20.5:331.43,21.0:339.57,21.5:347.71,22.0:355.85,22.5:363.99,23.0:372.13,23.5:380.27,24.0:388.41,24.5:396.55,25.0:404.69,25.5:412.83,26.0:420.97,26.5:429.11,27.0:437.25,27.5:445.39,28.0:453.53,28.5:461.67,29.0:469.81,29.5:477.95,30.0:486.09,70.0:14.30,300.0:16.56,99999.0:18.84',
            '20.5:381.60,21.0:389.40,21.5:397.20,22.0:405.00,22.5:412.80,23.0:420.60,23.5:428.40,24.0:436.20,24.5:444.00,25.0:451.80,25.5:459.60,26.0:467.40,26.5:475.20,27.0:483.00,27.5:490.80,28.0:498.60,28.5:506.40,29.0:514.20,29.5:522.00,30.0:529.80,70.0:15.73,300.0:17.94,99999.0:20.41',
            '20.5:446.94,21.0:456.17,21.5:465.40,22.0:474.63,22.5:483.86,23.0:493.09,23.5:502.32,24.0:511.55,24.5:520.78,25.0:530.01,25.5:539.24,26.0:548.47,26.5:557.70,27.0:566.93,27.5:576.16,28.0:585.39,28.5:594.62,29.0:603.85,29.5:613.08,30.0:622.31,70.0:18.60,300.0:20.72,99999.0:22.10',
            '20.5:822.32,21.0:840.94,21.5:859.56,22.0:878.18,22.5:896.80,23.0:915.42,23.5:934.04,24.0:952.66,24.5:971.28,25.0:989.90,25.5:1008.52,26.0:1027.14,26.5:1045.76,27.0:1064.38,27.5:1083.00,28.0:1101.62,28.5:1120.24,29.0:1138.86,29.5:1157.48,30.0:1176.10,70.0:36.00,300.0:36.86,99999.0:39.42',
            '20.5:853.74,21.0:867.17,21.5:880.60,22.0:894.03,22.5:907.46,23.0:920.89,23.5:934.32,24.0:947.75,24.5:961.18,25.0:974.61,25.5:988.04,26.0:1001.47,26.5:1014.90,27.0:1028.33,27.5:1041.76,28.0:1055.19,28.5:1068.62,29.0:1082.05,29.5:1095.48,30.0:1108.91,70.0:37.98,300.0:38.38,99999.0:41.76',
            '20.5:761.40,21.0:777.75,21.5:794.10,22.0:810.45,22.5:826.80,23.0:843.15,23.5:859.50,24.0:875.85,24.5:892.20,25.0:908.55,25.5:924.90,26.0:941.25,26.5:957.60,27.0:973.95,27.5:990.30,28.0:1006.65,28.5:1023.00,29.0:1039.35,29.5:1055.70,30.0:1072.05,70.0:32.34,300.0:32.85,99999.0:35.56',
            '20.5:802.88,21.0:819.13,21.5:835.38,22.0:851.63,22.5:867.88,23.0:884.13,23.5:900.38,24.0:916.63,24.5:932.88,25.0:949.13,25.5:965.38,26.0:981.63,26.5:997.88,27.0:1014.13,27.5:1030.38,28.0:1046.63,28.5:1062.88,29.0:1079.13,29.5:1095.38,30.0:1111.63,70.0:33.12,300.0:37.94,99999.0:39.39',
            '20.5:1144.92,21.0:1170.12,21.5:1195.32,22.0:1220.52,22.5:1245.72,23.0:1270.92,23.5:1296.12,24.0:1321.32,24.5:1346.52,25.0:1371.72,25.5:1396.92,26.0:1422.12,26.5:1447.32,27.0:1472.52,27.5:1497.72,28.0:1522.92,28.5:1548.12,29.0:1573.32,29.5:1598.52,30.0:1623.72,70.0:52.50,300.0:58.08,99999.0:61.50',
            '20.5:777.00,21.0:777.00,21.5:814.00,22.0:814.00,22.5:851.00,23.0:851.00,23.5:888.00,24.0:888.00,24.5:925.00,25.0:925.00,25.5:962.00,26.0:962.00,26.5:999.00,27.0:999.00,27.5:1036.00,28.0:1036.00,28.5:1073.00,29.0:1073.00,29.5:1110.00,30.0:1110.00,70.0:35.00,300.0:35.00,99999.0:50.00'
        );
    }

// class methods

    /**
     * @param string $method
     * @param bool $order_tag 发货单标记
     * @param $custome_weight 自定义重量
     * @return array
     */
    function quote($method = '', $order_tag = false,$custome_weight = 0) {

        global $order, $total_weight, $shipping_num_boxes, $total_count,$currencies,$separated_weight;
        $dest_country = $order->delivery['country']['iso_code_2'];
        $dest_zone = 0;
        $error = false;
        if(!empty($custome_weight)){
            $total_weight = $custome_weight;
        }
        //if($separated_weight<=20){
            for ($i=1; $i<=$this->num_zones; $i++) {
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
        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping = -1;

            $zones_cost = constant('MODULE_SHIPPING_DHLZONES_COST_' . $dest_zone);
            $zones_table = split("[:,]" , $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i=0; $i<$size; $i+=2) {
                switch (MODULE_SHIPPING_DHLZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Weight'):
                        /*if (ceil($total_weight) <= $zones_table[$i]) {*/
                        if ($total_weight <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes,2) . MODULE_SHIPPING_DHLZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight,2) . MODULE_SHIPPING_DHLZONES_TEXT_UNITS . ')';
                                    break;
                            }

                            //$shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_DHLZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;

                            if ($total_weight > 30){
                                $shipping = $zones_table[$i+1] * $total_weight;
                            }else{
                                $shipping = $zones_table[$i+1];
                            }

                            //dhl紧急附加费
                            if(in_array($dest_country,array('AU','NZ'))){
                                $add_cost = $total_weight * 16;
                            }else{
                                $add_cost = $total_weight * 7;
                            }
                            $shipping += $add_cost;

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Price'):
                        // shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i+1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Item'):
                        // shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];
                            $shipping_method = MODULE_SHIPPING_DHLZONES_TEXT_WAY . ' ' . $dest_country;
                            $done = true;
                            $shipping = $zones_table[$i+1];
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
                $shipping_method = MODULE_SHIPPING_DHLZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_DHLZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Weight'):
                        // charge per box when done by Price

                        $shipping_cost = $shipping;
                        if($order->delivery['company_type'] == 'IndividualType'){
                            //公司类型为IndividualType 加收25RMB
                            $shipping_cost = $shipping_cost + 25;
                        }
                        $shipping_cost = ($shipping_cost * (1+MODULE_SHIPPING_DHLZONES_EXTRA_FEE)) / $currencies->currencies['CNY']['value'];
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
        $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL) * $this->extra_rate;
        $is_show_dhl = true;
        $order_products = $order->delay_products;

        //出现以下产品时或者单件产品超过300kg不展示
        $limit_products = [73937,73938,73941,73942,73946,73579,73958];
        if(!empty($order_products)){
            foreach ($order_products as $v){
                if(in_array($v['id'],$limit_products) || $v['weight']>300){
                    $is_show_dhl = false;
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
                    $is_show_dhl = $spe_arr_info['is_show'] == 0 ? false : $is_show_dhl;
                    $s_core = $spe_arr_info['core'];
                    $s_len = $spe_arr_info['length'];
                    $is_s_core = empty($s_core) ? true : false;
                    $is_s_len = $s_len == 0 ? true : false;

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

                }
                if (!$is_show_dhl) {
                    break 2;
                }
                if ($is_s_len && $is_s_core) {
                    $is_spe = true;
                    $all_spe_qty += $spe_qty;
                    break;
                }
            }

        }


        if($shipping_cost && $is_show_dhl){
            //当订单包含有ID: 70856，70855，73945，70993，70771，74126，21104，69225时，
            //选择DHL为运输方式时，运费加收600RMB*（1+燃油费率）*以上id产品的产品数量n；
            $extra_product = [70856,70855,73945,70993,70771,74126,21104,69225];
            $extra_cost = 0;
            $extra_fee = 600/$currencies->currencies["CNY"]['value'];
            if(!empty($order_products)){
                foreach ($order_products as $v){
                    if (in_array($v['id'], $extra_product) || $v['weight'] > 70) {
                        $extra_cost += $extra_fee * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $v['qty'];
                    }
                }
            }
            $shipping_cost += $extra_cost;

            //超规格产品附加费
            if($is_spe){
                $shipping_cost += 600 * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $all_spe_qty /
                    $currencies->currencies['CNY']['value'];
            }

            //港澳台<=20kg   FEDEX IE免运费;21kg-99kg  DHL免运费;>= 100kg  FEDEX IE免运费;
            if(in_array($order->delivery['country']["id"],array(96,125,206))){
                if($total_weight>20&&$total_weight<=99){
                    $shipping_cost = 0;
                }
            }

            if(in_array(strtoupper($dest_country),array('EE','LV','LT'))){//满足免运条件的国家
                switch ($order_tag){
                    case 'global':
                        $shipping_cost = $order->global_info['is_shipping_free'] ? 0 : $shipping_cost;
                        break;
                    case 'local':
                        $shipping_cost = $order->local_info['is_shipping_free'] && !$order->is_local_buck ? 0 : $shipping_cost;
                        break;
                    case 'delay':
                        $shipping_cost = $order->delay_info['is_shipping_free'] && !$order->is_buck ? 0 : $shipping_cost;
                        break;
                    case 'delay-global':
                        if(!$order->is_buck && $order->delay_info['is_shipping_free'] && $order->global_info['is_shipping_free']){
                            $shipping_cost = 0;
                        }
                        break;
                }
            }

            // 中国直发美国和新加坡的订单，满足免运费条件时 weight>20.5
            if (in_array($dest_country, ['SG']) && $order->delay_info['is_shipping_free'] && $total_weight > 20 && !$order->is_buck) {
                $shipping_cost = 0;
            }

            if($shipping_cost != 0){
                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            }

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_DHLZONES_TEXT_TITLE,
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

        if (strstr(MODULE_SHIPPING_DHLZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DHLZONES_INVALID_ZONE;
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(), $zone_type,$is_shipping_free,$products_info)
    {

        global $order, $shipping_num_boxes, $total_count, $currencies;
        $dest_country = $country;
        $dest_zone = 0;
        $error = false;
        //if ($total_weight <= 20) {
            for ($i = 1; $i <= $this->num_zones; $i++) {
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
        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping = -1;
            $zones_cost = constant('MODULE_SHIPPING_DHLZONES_COST_' . $dest_zone);
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

                            if ($total_weight > 30) {
                                $shipping = $zones_table[$i + 1] * $total_weight;
                            } else {
                                $shipping = $zones_table[$i + 1];
                            }

                            //dhl紧急附加费
                            if(in_array($dest_country, array('AU','NZ'))){
                                $add_cost = $total_weight * 16;
                            }else{
                                $add_cost = $total_weight * 7;
                            }
                            $shipping += $add_cost;

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
                $shipping_cost = 0;
                $shipping_method = MODULE_SHIPPING_DHLZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_DHLZONES_METHOD) {
                    case (MODULE_SHIPPING_DHLZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE)) / $currencies->currencies['CNY']['value'];
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
        $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL) * $this->extra_rate;

        //判断附加费
        $is_spe = false;
        $all_spe_qty = $products_info['purchase_qty'];
        $is_show_dhl = true;
        $products_id = (int)$products_info['products_id'];

        //判断超规格产品附加费
        foreach ($this->SuperSpeProducts as $spe_arr_info) {
            $spe_arr_id = $spe_arr_info['products'];
            if (in_array($products_id, $spe_arr_id)) {
                $is_show_dhl = $spe_arr_info['is_show'] == 0 ? false : $is_show_dhl;
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
            }
            if (!$is_show_dhl) {
                break;
            }
            if ($is_s_len && $is_s_core) {
                $is_spe = true;
                break;
            }
        }

        if ($shipping_cost && $is_show_dhl) {

            //出现以下产品时或者单件产品超过300kg不展示
            $limit_products = [73937,73938,73941,73942,73946,73579,73958];
            if((in_array($products_info['products_id'],$limit_products) || $products_info['weight'] > 300) && $products_info['qty'] == 0){
                return array();
            }

            //当订单包含有ID: 70856，70855，73945，70993，70771，74126，21104，69225时，
            //选择DHL为运输方式时，运费加收600RMB*（1+燃油费率）*以上id产品的产品数量n；
            $extra_product = [70856,70855,73945,70993,70771,74126,21104,69225];
            $extra_fee = 600/$currencies->currencies["CNY"]['value'];

            if(in_array($products_info['products_id'],$extra_product) || $products_info['weight'] > 70){
                $extra_cost = $extra_fee * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $products_info['purchase_qty'];
            }

            $shipping_cost += $extra_cost;

            //超规格产品附加费
            if($is_spe){
                $shipping_cost += 600 * (1 + MODULE_SHIPPING_DHLZONES_EXTRA_FEE) * $all_spe_qty /
                    $currencies->currencies['CNY']['value'];
            }
            
            //港澳台<=20kg   FEDEX IE免运费;21kg-99kg  DHL免运费;>= 100kg  FEDEX IE免运费;
            if (in_array($country, array("HK", "MO", "TW"))) {
                if ($total_weight >= 21 && $total_weight <= 99) {
                    $shipping_cost = 0;
                }
            }

            /*
             * sg us  weight>=20.5kg  DHL免运费;
             *
             * author aron
             * date 2019.11.18
             */
            if(in_array($country,['SG']) && $is_shipping_free && $total_weight > 20 && !$is_buck){
                $shipping_cost = 0;
            }

            if($shipping_cost != 0){
                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            }

            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_DHLZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        } else {
            return array();
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_DHLZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_DHLZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check() {
        global $db;
        if (!isset($this->_check)) {
            $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DHLZONES_STATUS'");
            $this->_check = $check_query->RecordCount();
        }
        return $this->_check;
    }

    function install() {
        global $db;
        if (!defined('MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_DHLZONES_STATUS', 'True', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_DHLZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_DHLZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_DHLZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_DHLZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_DHLZONES_SKIPPED', '', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_DHLZONES_EXTRA_FEE', '填写DHL的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
        for ($i = 1; $i <= $this->num_zones; $i++) {
            $default_countries = '';
            if ($i == 1) {
                $default_countries = 'US,CA';
            }
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_DHLZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_DHLZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
            $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_DHLZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_DHLZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
        }
    }

    function remove() {
        global $db;
        $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
        $keys = array('MODULE_SHIPPING_DHLZONES_STATUS', 'MODULE_SHIPPING_DHLZONES_METHOD', 'MODULE_SHIPPING_DHLZONES_TAX_CLASS', 'MODULE_SHIPPING_DHLZONES_TAX_BASIS', 'MODULE_SHIPPING_DHLZONES_SORT_ORDER','MODULE_SHIPPING_DHLZONES_DAYS', 'MODULE_SHIPPING_DHLZONES_SKIPPED','MODULE_SHIPPING_DHLZONES_EXTRA_FEE');
        for ($i=1; $i<=$this->num_zones_days; $i++) {
            $keys[] = 'MODULE_SHIPPING_DHLZONES_DAYS_ZONES_' . $i;
            $keys[] = 'MODULE_SHIPPING_DHLZONES_DAYS_' . $i;
        }

        for ($i=1; $i<=$this->num_zones; $i++) {
            $keys[] = 'MODULE_SHIPPING_DHLZONES_COUNTRIES_' . $i;
            $keys[] = 'MODULE_SHIPPING_DHLZONES_COST_' . $i;
            $keys[] = 'MODULE_SHIPPING_DHLZONES_HANDLING_' . $i;
        }
        return $keys;
    }
}
