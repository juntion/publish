<?php
function get_shipping_cost($warehouse, $state, $country_id, $quotes,$shipping_list=[], $type = "")
{
    global $order, $shipping;
    $currencies = new currencies();
    $data = array();
    $j = 0;
    $company_type = $order->delivery['company_type'];
    $country_code = $order->delivery['country']['iso_code_2'];
    $city = $order->delivery['state'];
    $postcode = $order->delivery['postcode'];
    $order_info = $order->get_order_num();
    $order_data = $order_info['data'];
    $is_self_lifting = true;
    $is_show_overnight = true;
    $local_hour = getTime("G",time(),$country_code);
    $local_day = getTime('D',time(),$country_code);
    $shipping_day = 0;
    $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
    $shipping_info = getShippingList($warehouse);
    $warehouse = $shipping_info['warehouse'];
    $shipping_arr = $shipping_info['shipping_arr'];
    $state = $order->delivery['state'];
    $is_super_spec_arr = CheckOrderSuperSpecProducts(true);
    $is_super_spec = $is_super_spec_arr['delay_spec'];
    if($order->local_warehouse == 2 && $warehouse == 'WH'){
        if($is_super_spec_arr['local_spec'] || $is_super_spec_arr['delay_spec']){
            $is_super_spec = true;
        }
    }

    $shipping_custom = array();
    if ($order_data != "local" && !in_array($warehouse, ['US-ES', 'AU', 'AU-NZ'])) {
        $is_self_lifting = false;
    }
    if($type == "gift"){
        //赠品设置默认运输方式
        if($country_id == 223){
            $data = [
                'methods' => "fedexgroundeastzones",
                'title' => 'FedEx Ground ® Service',
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }elseif(in_array($country_id,[138, 38])){
            $data = [
                'methods' => "dhlazones",
                'title' => "DHL 1-3 Business Days",
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }elseif ($country_id == 81){
            $data = [
                'methods' => "tntgzones",
                'title' => "TNT Express® 1 Business Day Service",
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }elseif (in_array($country_id,[5,21,33,204,14,56,57,67,195,72,73,222,84,53,97,103,105,245,122,123,124,117,141,150,170,175,203,190,189,182,171])){
            $data = [
                'methods' => "upsstandardzones",
                'title' => "UPS Standard® 1-3 Business Days Service",
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }elseif(in_array($country_id,[160,98])){
            $data = [
                'methods' => "tntezones",
                'title' => "TNT Economy Express® 1-3 Business Days Service",
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }else{
            $data = [
                'methods' => "dhlezones",
                'title' => "DHL Express Worldwide® 1-2 Business Days Service",
                'price' => $currencies->new_format(0, true, $_SESSION['currency'],
                    $currencies->currencies[$_SESSION['currency']]['value']),
                'origin_price' => 0,
                's_price' => 0
            ];
        }
        return [$data];
    }
    foreach ($shipping_arr as $key => $v) {
        if(in_array($v['method'],array("dhlsaturdayzones","customzones","selfreferencezones","saturdaydeliveryzones"))){
            continue;
        }
        if (isset($quotes[$v['method']]) && is_array($quotes[$v['method']]) && $quotes[$v['method']]['methods'][0]['cost'] >= 0) {
            if ($warehouse != "US" && $warehouse != "SG" && $country_code != 'GB') {
                $day = get_days($_SESSION['countries_code_2'], $v['method']);
            } else {
                if (in_array($country_id, array(138, 38)) || $state == "Puerto Rico") {
                    $day = get_days($_SESSION['countries_code_2'], $v['method']);
                } else {
                    $day = "";
                }
            }
            if ($v['method'] == 'upsgroundeastzones' && $country_id == 223) {
                $v['title'] = 'UPS Ground®';
            }
            if ($country_id == 172 && $v['method'] == 'upsgroundeastzones') {
                $v['title'] = 'UPS Ground®';
            }
            switch ($v['method']){
                case "fedexgroundeastzones" :
                    $shipping_day = $day = fs_get_data_from_db_fields('timeliness_md', 'countries_to_zip', 'zip ="'.$postcode.'"  limit 1');
                    $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                    //$day = $day>=1 ? $day." ".FS_BUSINESS_DAYS." Service" : " Service";
                    break;
                case "fedexgroundzones":
                    $shipping_day = $day = fs_get_data_from_db_fields('timeliness_mx', 'countries_to_zip', 'zip ="'.$postcode.'"  limit 1');
                    $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                    //$day = $day>=1 ? $day." ".FS_BUSINESS_DAYS." Service" : " Service";
                    break;
                case "upsgroundzones":
                    $shipping_day = $day = fs_get_data_from_db_fields('timeliness_mx', 'countries_to_zip', 'zip ="'.$postcode.'"  limit 1');
                    $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
                    //$day = $day>=1 ? $day." ".FS_BUSINESS_DAYS." Service" :" Service";
                    break;
                case "upsgroundeastzones":
//                    $shipping_day = $day = fs_get_data_from_db_fields('timeliness_md', 'countries_to_zip', 'zip ="'.$postcode.'"  limit 1');
//                    if($day){
//                        $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
//                    }else{
//                        $day = " ".FS_SERVICE_WORD;
//                    }
//                    if($country_id == 172) {
                        $day = " ".FS_SERVICE_WORD;
//                    }
                    //$day = $day>=1 ? $day." ".FS_BUSINESS_DAYS." Service" :" Service";
                    break;
                case "fedexltlzones":
                    $day = " ".FS_SERVICE_WORD;
                    break;
                case "upsltlzones":
//                    $shipping_day = $day = fs_get_data_from_db_fields('delivery_date', 'shipping_ups_ltl', '(state ="'.$state.'" or state_abb = "'.$state.'") AND country_id = "'.$country_id.'" limit 1');
//                    if($day){
//                        $day = $day>1 ? $day." ".FS_BUSINESS_DAYS." ".FS_SERVICE_WORD : "1 ".FS_BUSINESS_DAY." ".FS_SERVICE_WORD;
//                    }else{
                        $day = " ".FS_SERVICE_WORD;
//                    }
                    break;
                case "dhleconomyzones":
                    $day = $country_id == 195 ? '3-5 '.FS_BUSINESS_DAYS : $day;
                    break;
            }
            $data[$j]['methods'] = $v['method'];
            if(preg_match("/fedexovernight|upsovernight|fedexpriorityovernight|ups2daysamzones/i", $v['method'])){
                $data[$j]['description'] = FS_OVERNIGHT_TITLE;
            }
            if($v['method'] == 'forwarderzones'){
                $data[$j]['description'] = FS_FORWARD_SHIPPING_NOTICE;
            }
            if($v['method'] == 'tntauovernightexpresszones' || $v['method'] == 'tntauzones'){
                $data[$j]['description'] = FS_SHIPPING_TNT_AU_INFO;
            }
            if ($warehouse == "DE") {
                $word_service = "";
                if($_SESSION['languages_code'] != 'jp'){
                    $word_service .= " ".FS_SERVICE_WORD;//单个单词:Service
                }
                if($country_code == 'GB'){
                    $word_service = '';
                }
                $data[$j]['title'] = $v['title'] . " " . $day . $word_service;
                if(in_array($v['method'],array('upssaverzones','upsexpresspluszones','upsexpresszones','upsstandardzones','tntezones'))){
                    $data[$j]['title'] = $v['title'] . " " . $day . $word_service;
                    $data[$j]['description'] = FS_SHIPPING_UPS_DE_TIPS;
                }elseif (in_array($v['method'],array('dhlgzones','dhlezones','dhlexpresszones','dhlexpressdzones','dhleconomyzones'))){
                    $data[$j]['title'] = $v['title'] . " " . $day . $word_service ;
                    $data[$j]['description'] = FS_SHIPPING_UPS_DE_TIPS_02;
                }
            } elseif ($warehouse == "SG"){
                if(in_array($v['method'],array('simplyovernightzones','ninjavanovernightzones','singapostandardtzones'))){
                    $data[$j]['title'] = $v['title'];
                    $data[$j]['description'] = FS_SHIPPING_SG_TIPS;
                }elseif ($v['method'] == 'grabexpresszones') {
                    $data[$j]['title'] = $v['title'];
                    $data[$j]['description'] = FS_SHIPPING_SG_GRAB_TIPS;
                }elseif ($v['method'] == 'fsinstallzones') {
                    $data[$j]['title'] = $v['title'];
                    $data[$j]['description'] = FS_SHIPPING_SG_GRAB_TIPSFS_SHIPPING_SG_INSTALL_TIPS;
                }else{
                    $data[$j]['title'] = $v['title'] . " " . $day;
                }
            } else {
                if($warehouse == "US-ES" && $state == 'Puerto Rico' && $v['method'] == 'fedex3dayzones'){
                    $v['title'] .= $quotes[$v['method']]['methods'][0]['cost'] == 0 ? ' IE' : ' IP';
                }
                $data[$j]['title'] = $v['title'] . " " . $day;
            }
            if (in_array($_SESSION['languages_code'],array('mx','es')) && $v['method'] != 'fsinstallzones') {
                $data[$j]['title'] = str_replace('servicio','',$data[$j]['title']);
                $data[$j]['title'] = str_ireplace('service','',$data[$j]['title']);
            }

            if ($quotes[$v['method']]['methods'][0]['cost'] == 0) {
                $data[$j]['price'] = FIBER_CHECK_FREE_SHIPPING;
                $data[$j]['origin_price'] = 0;
            } else {
                $data[$j]['price'] = $currencies->new_format($quotes[$v['method']]['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes[$v['method']]['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            }

            //澳大利亚税后价
            if($country_id == 13){
                //cost_tax为已转货币的价格
                $cost_tax = get_gsp_tax_price($country_id,$data[$j]['origin_price']);
                $is_tax_shipping  = true;
                $data[$j]['price_tax'] = $data[$j]['origin_price'] == 0 ? FIBER_CHECK_FREE_SHIPPING :
                    $currencies->new_format($cost_tax, true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value'], $is_tax_shipping);
            }
            $data[$j]['s_price'] = $quotes[$v['method']]['methods'][0]['cost'];
            $j++;
        }
    }
    if (!(in_array($country_id, array(138, 38)) && $warehouse == "US-ES")){
        //按照运费对运输方式进行排序
        $data = my_sort($data, "origin_price", SORT_ASC);
    }

    //重置数组索引
    $data = array_values($data);
    if (($warehouse == "DE") && in_array($country_id, array(81, 73, 222, 21, 72, 195, 57, 105, 171, 56, 150, 14, 204))) {

        if (($local_day == 'Fri'&& $local_hour < 16) || ($local_day == 'Thu' && $local_hour>16)) {
            if (isset($quotes['dhlsaturdayzones']) && is_array($quotes['dhlsaturdayzones']) && $quotes['dhlsaturdayzones']['methods'][0]['cost'] >= 0) {
                $data[$j]['methods'] = 'dhlsaturdayzones';
                $data[$j]['title'] = 'DHL Saturday Delivery ';
                $data[$j]['price'] = $currencies->new_format($quotes['dhlsaturdayzones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['dhlsaturdayzones']['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
                $data[$j]['s_price'] = $quotes['dhlsaturdayzones']['methods'][0]['cost'];
                $j++;
            }
        }
    }
    if (($warehouse == "US" || $warehouse == "US-ES") && !in_array($country_id, array(138, 38)) && $state != "Puerto Rico") {
        if (date('D') == 'Fri' || date('D') == 'Thu') {
            if (isset($quotes['saturdaydeliveryzones']) && is_array($quotes['saturdaydeliveryzones']) && $quotes['saturdaydeliveryzones']['methods'][0]['cost'] >= 0) {
                $data[$j]['methods'] = 'saturdaydeliveryzones';
                $data[$j]['title'] = 'Saturday Delivery ';
                $data[$j]['price'] = $currencies->new_format($quotes['saturdaydeliveryzones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['saturdaydeliveryzones']['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
                $data[$j]['s_price'] = $quotes['saturdaydeliveryzones']['methods'][0]['cost'];
                $j++;
            }
        }
    }

    if (((in_array($warehouse, array("US", "US-ES")) && $country_id == 223) || german_warehouse("country_number",$country_id) || $order->is_ireland_zones || in_array($warehouse,array("AU","AU-NZ")) || $country_id == 188) && $warehouse != "WH" && $is_self_lifting) {
        if (isset($quotes['selfreferencezones']) && is_array($quotes['selfreferencezones']) && $quotes['selfreferencezones']['methods'][0]['cost'] >= 0) {
            $data[$j]['methods'] = 'selfreferencezones';
            $data[$j]['title'] = FS_PICK_UP_AT_WAREHOUSE;
            $data[$j]['price'] = $currencies->new_format($quotes['selfreferencezones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
            if($country_id == 13){
                $data[$j]['price_tax'] = $currencies->new_format($quotes['selfreferencezones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
            }
            $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['selfreferencezones']['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            $data[$j]['s_price'] = $quotes['selfreferencezones']['methods'][0]['cost'];
            $j++;
        }
    }

    //新加坡物流排序
//    if($country_id == 188){
//        if($data[4]['methods'] == 'selfreferencezones') {
//            $data = fs_array_exchange($data, 2, 4);
//        }elseif($data[3]['methods'] == 'selfreferencezones'){
//            $data = fs_array_exchange($data, 2, 3);
//        }
//    }
    $is_show_customez = true;
    if($warehouse == "WH" && in_array($country_id,[223,172])){
        $is_show_customez = false;
    }
    if (isset($quotes['customzones']) && is_array($quotes['customzones']) && $quotes['customzones']['methods'][0]['cost'] >= 0 && $is_show_customez) {
        if(empty($data) && $warehouse == "DE"){
            $data[$j]["description"] = FS_CHECKOUT_NONE_SHIPING;
        }
        $data[$j]['methods'] = 'customzones';
        $data[$j]['title'] = FIBER_CHECK_USE;
        $data[$j]['price'] = $currencies->new_format($quotes['customzones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
        if($country_id == 13){
            $data[$j]['price_tax'] = $currencies->new_format($quotes['selfreferencezones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
        }
        $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['customzones']['methods'][0]['cost'] * $rate), $currencies->currencies[$_SESSION['currency']]['decimal_places']);
        $data[$j]['s_price'] = $quotes['customzones']['methods'][0]['cost'];
        $j++;
    }
    $saturday = array();
    $overnight = array();
    $sameday = array();
    $ground = array();
    $is_first = true;
    foreach ($data as $key =>$value){
        if($value['methods'] == 'fedexsamedayzones'){
            $sameday[] = $data[$key];
            unset($data[$key]);
        }

        if(preg_match("/fedexiezones|fedexzones/i",$value['methods'])){
            $fedex[$value['methods']] = $data[$key];
            $fedex[$value['methods']]['index'] = $key;
        }

        if(preg_match("/fedexground|upsground/i",$value['methods'])){
            if($shipping_day ==1){
                $ground[] = $data[$key];
                unset($data[$key]);
            }
            if($value['origin_price'] == 0){
                $is_first = false;
            }
        }
        if(preg_match("/fedex2day|ups2day/i",$value['methods'])){
            if($value['origin_price'] == 0){
                $is_first = false;
            }
        }
        if(preg_match("/upsovernight|fedexpriorityovernight/i",$value['methods'])){
            if(!$is_show_overnight){
                unset($data[$key]);
            }
        }
    }
    if(!empty($ground)){
        $ground = array_reverse($ground);
        foreach ($ground as $k){
            array_unshift($data,$k);
        }
    }
    if(!empty($fedex) && sizeof($fedex)==2){
        if($fedex['fedexiezones']['origin_price'] == $fedex['fedexzones']['origin_price']){
            unset($data[$fedex['fedexiezones']['index']]);
        }
    }
    foreach ($data as $key =>$value){
        if(preg_match("/fedexovernight/i",$value['methods'])){
            if(!$is_show_overnight){
                unset($data[$key]);
            }
            break;
        }
    }
    if($is_first){
        if(!empty($sameday)){
            array_splice($data,0,0,$sameday);
        }
    }else{
        if(!empty($sameday)){
            array_splice($data,1,0,$sameday);
        }
    }

    $is_show_ups_fedex = false;//美国ups自提显示fedex
    foreach ($data as $key =>$value){
        if($value['methods']=="customzones"){
//            if($warehouse == 'DE' && !in_array($country_code,array('IS','NO'))){//德国仓发货的用户物流都加上tnt的方式
//                $tnt_day = get_days($_SESSION['countries_code_2'], 'tntezones');
//                $shipping_custom[] = 'TNT Economy Express®' . " " . $tnt_day . " ".FS_SRVICE_WORD;
//            }

            if($country_id == 223 && $warehouse == 'US-ES' && $is_show_ups_fedex){
                $shipping_custom = array_merge($shipping_custom, array(FIBER_FEDEX_CHECK_TWO,FIBER_FEDEX_CHECK_OVER));
            }

            $data[$key]['custom'] = $shipping_custom;
        }else{
            if(!in_array($value['methods'],['customzones','selfreferencezones','forwarderzones','courierzones','fsinstallzones','fs2dayzones','fssamedayzones'])){
                switch ($value['methods']){
                    case 'tntauovernightexpresszones':
                        $shipping_custom[] = 'TNT Overnight Express Service';
                        break;
                    case 'tntauzones':
                        $shipping_custom[] = 'TNT 9:00 Express Service';
                        break;
                    case 'upssaverzones':
                        $shipping_custom[] = UPS_EXPRESS_NEXT_DAY_SERVICE;
                        break;
                    case 'dhlezones':
                        $shipping_custom[] = DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY;
                        break;
                    case 'dhlgzones':
                        $shipping_custom[] = 'DHL Express Domestic® 1 Business Day Service';
                        break;
                    case 'upsexpresspluszones':
                        $shipping_custom[] = 'UPS Express Plus Next Day 9:00®  Service';
                        break;
                    case 'upsexpresszones':
                        $shipping_custom[] = 'UPS Express Next day 12:00®  Service';
                        break;
                    case 'simplyovernightzones':
                        $shipping_custom[] = 'SimplyPost Next Working Day';
                        break;
                    case 'grabexpresszones':
                        $shipping_custom[] = 'GrabExpress Same Day';
                        break;
                    case 'singapostandardtzones':
                        $shipping_custom[] = 'Singapost Standard 1 Working Day';
                        break;
                    case 'ninjavanovernightzones':
                        $shipping_custom[] = 'Ninja Van Next Working Day';
                        break;
                    default:
                        $shipping_custom[] = $value['title'];
                }
            }
            if(in_array($value['methods'],['upsgroundeastzones','ups2dayseastzones','upsovernighteastzones','ups2daysamzones','uspsprioritymailzones'])){
                $is_show_ups_fedex = true;
            }
        }
    }

    if(empty($shipping_custom)){
        foreach ($data as $key =>$value){
            if($value['methods']=="customzones"){
                $data[$key]['custom'] = array('UPS', 'FedEx', 'DHL', 'EMS', 'TNT', OTHERS);
                if($is_super_spec){
                    $data[$key]['custom'] = array(OTHERS);
                }
                break;
            }
        }
    }
    foreach ($data as &$ar){
        $ar['show_description'] = zen_get_order_shipping_method_by_code($ar['methods']);
    }
    //重置数组索引
    $data = array_values($data);
    return $data;
}

//分仓分库，仓库判断
/*
 * return array
 *根据国家判断 西雅图仓
 */
function seattle_warehouse($code = "country_number",$country_code)
{
	if(!is_numeric($country_code)){
		$country_code = strtoupper($country_code);
	}
	if ($code == "country_code") {
		$arr = array("US", "MX", "CA", "PR");
	} elseif ($code == "country_number") {
		$arr = array(38, 223, 138, 172);
	}
	if(in_array($country_code,$arr)){
		return true;
	}else{
		return false;
	}
}
/**
 * @param string $code
 * @param $country_code
 * @return bool
 * au仓判断
 */
function au_warehouse($country_code,$code ="country_number"){
    if(!is_numeric($country_code)){
        $country_code = strtoupper($country_code);
    }
    if ($code == "country_code") {
        $arr = array("AU","NZ");
    } elseif ($code == "country_number") {
        $arr =array(13,153);
    }
    if(in_array($country_code,$arr)){
        return true;
    }else{
        return false;
    }
}
/*
 * return array
 * 根据国家判断  德国仓
 */
function german_warehouse($code = "country_number",$country_code, $postcode = '')
{
	$arr = array();
	if(!is_numeric($country_code)){
		$country_code = strtoupper($country_code);
	}
	if ($code == "country_code") {
		 $arr = array("BE", "FR", "DE", "IT", "NL", "LU", "DK", "IE", "ES", "GR", "PT", "AT", "SE", "FI", "MT", "CY", "PL", "HU", "CZ", "SK", "SI", "EE", "LV", "LT", "RO", "BG", "HR","MC", );
	} elseif ($code == "country_number") {
		 $arr = array(21, 73, 81, 105, 150, 124, 57, 103, 195, 84, 171, 14, 203, 72, 132, 55, 170, 97, 56, 189, 190, 67, 117, 123, 175, 33, 53, 141, );
	}
    if(!empty($postcode)){//判断是否为北爱尔兰
        return checkNorthIrelandPostcode($postcode, $country_code);
    }
	if(in_array($country_code,$arr)){
		return true;
	}else{
		return false;
	}
}
//其它欧洲国家
function other_eu_warehouse($country_code,$code ="country_number")
{
	$arr = array();
	if(!is_numeric($country_code)){
		$country_code = strtoupper($country_code);
	}
	if ($code == "country_code") {
		$arr = array("IS", "BA", "RS", "ME", "MK", "AL", "MD", "NO", "CH", "AD", "LI", "SM", "JE", "FO", "GL", "GP", "GF", "MQ", "YT", "AW", "IC", 'GG',"VA","BL","MF", "GB", 'IM', "BL", "MF");
	} elseif ($code == "country_number") {
		$arr =array(98,27,236,242,126,2,140,160,204,5,122,182,245,70,85,87,75,134,137,12,250,243,228,253,254,222,244,253,254);
	}
	if(in_array($country_code,$arr)){
		return true;
	}else{
		return false;
	}
}

/*
 * return array
 * 根据国家判断  是否是新加坡站覆盖国家
 */
function singapore_warehouse($code = "country_number",$country_code)
{
    $arr = array();
    if(!is_numeric($country_code)){
        $country_code = strtoupper($country_code);
    }
    if ($code == "country_code") {
        $arr = array("SG","KH","LA","MY","TL","ID","BN","MM","PH","TH","VN");
    } elseif ($code == "country_number") {
        $arr = array(32,100,36,116,146,129,168,188,209,61,230);
    }
    if(in_array($country_code,$arr)){
        return true;
    }else{
        return false;
    }
}

/**
 * $Notes: 判断是否是俄罗斯仓库
 *
 * $author: Quest
 * $Date: 2020/11/24
 * $Time: 10:08
 * @param string $code
 * @param $country_code
 * @return bool
 */
function ru_warehouse($code = "country_number",$country_code)
{
    $arr = array();
    if(!is_numeric($country_code)){
        $country_code = strtoupper($country_code);
    }
    if ($code == "country_code") {
        $arr = array("RU");
    } elseif ($code == "country_number") {
        $arr = array(176);
    }
    if(in_array($country_code,$arr)){
        return true;
    }else{
        return false;
    }
}

function all_german_warehouse($code = "country_number",$country_code){
	if(!is_numeric($country_code)){
		$country_code = strtoupper($country_code);
	}
	if(german_warehouse($code,$country_code) || other_eu_warehouse($country_code,$code)){
		return true;
	}else{
		return false;
	}

}

/**
 * 根据国家code获取对应的仓库
 * @param string $code
 * @param $country_code
 * @return string
 */
function get_warehouse_by_code($country_code,$code = "country_code"){


    if(!is_numeric($country_code)){
        $country_code = strtoupper($country_code);
    }

    if ($code == "country_code") {
        $arr_us = ["US", "MX", "CA","PR"];
        $arr_au = ["AU","NZ"];
    } elseif ($code == "country_number") {
        $arr_us = [38, 223, 138];
        $arr_au = [13,153];
    }
    $ware_house = '';
    if(in_array($country_code,$arr_us)){
       $ware_house = 'us';
    }elseif (in_array($country_code,$arr_au)){
        $ware_house = 'au';
    }elseif ((german_warehouse($code,$country_code) || other_eu_warehouse($country_code,$code))){
        $ware_house = 'de';
    }elseif (singapore_warehouse($code,$country_code)){
        $ware_house = 'sg';
    }elseif (ru_warehouse($code,$country_code)){
        $ware_house = 'ru';
    }else{
        $ware_house = 'cn';
    }

    return $ware_house;
}

//获取是否存在光缆

function  fs_is_bulk_fiber_cable_status(){

	    $status = false;
		foreach($_SESSION['cart']->contents as $key=>$v){
					if(fs_zen_get_product_category_id($key,array(3080,939,609,914,576,2907,900,3093,3091,13,17,3078,1155,1148,978,584,3125,16,3260,3061,633,3313))){
						$status = true;
						break;
					}
					$keys_data = get_product_category_key($key);
					$keys = $keys_data['key'];
					if($keys == 1 || $keys == 2){
						 $status = true;
						break;
					}
      	}
		return  $status;

}

function fs_is_bulk_fiber_cable_status_local(){
	global $order;
	$status = false;
	$local_products = $order->local_info['products_arr'];
	$delay_products =  $order->delay_info['products_arr'];
	$global_products = $order->global_info['products_arr'];
	$product_combine = array_merge($local_products,$delay_products);
	$no_free_products = array(18015,18016,18013,18000,29669,35858,29665);
	if($order->local_warehouse==3){
		$no_free_products =  array(18015,18016,18013,18000,29669,35858,31922,72012,72020,72022,72023,29665);
	}
	if(in_array($order->local_warehouse,array(3,40))){
         $product_combine = array_merge($product_combine,$global_products);
       }
       $product_combine = array_map("intval",$product_combine);
	$products = array_diff($product_combine,$no_free_products);
	if(!empty($products)){
		foreach($products as $key=>$v){
			if(in_array($v,array(72500))){
				$status = true;
				break;
			}
			if(fs_zen_get_product_category_id($v,array(2907,900,3093,3059,13,17,3078,1155,1148,978,584,3125,16,3260,3061,633,3313,2969,1342,996)) || zen_product_in_category($v,573)){
				$status = true;
				break;
			}
			$keys_data = get_product_category_key($v);
            $keys = $keys_data['key'];
			if($keys == 1 || $keys == 2){
				$status = true;
				break;
			}
		}
	}
	return  $status;
}

//判断整单是否是从德国发货
function   fs_order_de_deliver(){
					global $db;
					  $FsCustomRelate = new classes\custom\FsCustomRelate();
					  //判断是否整个订单产品都是德国发货
					  $products = $_SESSION['cart']->get_products();
					  $flag_status = true;
					  for($i=0;$i<sizeof($products);$i++){
						//  定制产品录单   获取关联标准产品ID
						$thisAttr=array();
						$length = '';
						$standard_products = (int)$products[$i]['id'];
						if($products[$i]['attributes']){
							reset($products[$i]['attributes']);
							while (list($option, $value) = each($products[$i]['attributes'])) {
								if($option!= 'length'){
									$thisAttr[$option] = $value;
								}else{
									$length_name = fs_get_data_from_db_fields('length','products_length','product_id = '.(int)$products[$i]['id'].' and id ='. (int)$value ,'');
									if($length_name){
										$length = str_replace(' ','',$length_name);
									}
								}

							}
						}
						if(is_array($thisAttr)&&sizeof($thisAttr)){
							$FsCustomRelate::$products_id = (int)$products[$i]['id'];
							$FsCustomRelate::$optionAttr = $thisAttr;
							$FsCustomRelate::$length = $length;
							$matchProducts = $FsCustomRelate->handle();
							if($matchProducts){
							  $standard_products = $matchProducts[0];
							}
						}

						//如果该产品是有库存的,那么及时调用至订单库存表
						$relatedID = zen_get_products_related_model((int)$standard_products);
						$is_special = 0;
						if($_SESSION['customer_id']){
						  $is_special = fs_get_data_from_db_fields('is_special','customers','customers_id ='.$_SESSION['customer_id'],'');
						}
						//如果销售在后台没有指定定制客户
						if($is_special==0){
							$instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =".$relatedID." and warehouse = 20");

							if($instockSQL->fields['products_instock_id']){
//								$seattle_lock_front = fs_get_data_from_db_fields('sum(qty)','products_instock_orders','instock_id='.$instockSQL->fields['products_instock_id'],'');
								$seattle_lock_back = fs_get_data_from_db_fields('sum(change_qty)','products_instock_history_temp','products_instock_id='.$instockSQL->fields['products_instock_id'].' and type=0 and warehouse=20','');
								$remain_num = $instockSQL->fields['instock_qty']-$seattle_lock_back;
								if($remain_num<$products[$i]['quantity']){
									$flag_status = false;break;
								}
							}else{
								$flag_status = false;break;
							}
						}else{$flag_status = false;break;}

					  }

					 return $flag_status;
}
/*
 * 只要产品库存不足或者是库存为0时都需要拆单
 * 用于生成订单时对订单,对产品进行重新拆分
 * order类中调用
 * return array
 */
function fs_order_get_separate_products($warehouse, $products, $is_spring = false)
{
    global $db;
    $FsCustomRelate = new classes\custom\FsCustomRelate();
    $flag_status = true;
    $products_arr = array();
    $n = 0;
    $m = 0;
    $j = 0;
    $g = 0;
    $is_special = 0;
    $is_confirm = 0;
    if ($_SESSION['customer_id']) {
//		$is_special = fs_get_data_from_db_fields('is_special','customers','customers_id ='.$_SESSION['customer_id'],'');
        //判断是否客户定制需求
        $customer_type = fs_customer_order_product_is_instock($_SESSION['customer_id'],true);
        if ($customer_type) {
            if ($customer_type == 1) {
                $is_confirm = 1;  //全部需要销售确认
            } else {
                $instock_category = $customer_type;  //对应分类下产品需要销售确认
            }
        }
    }
    for ($i = 0; $i < sizeof($products); $i++) {
        //  定制产品录单   获取关联标准产品ID
        $thisAttr = array();
        $length = '';
        $standard_products = (int)$products[$i]['id'];
        if ($products[$i]['attributes']) {
            reset($products[$i]['attributes']);
            while (list($option, $value) = each($products[$i]['attributes'])) {
                if ($option != 'length') {
                    $thisAttr[$option] = $value;
                } else {
                    $length_name = fs_get_data_from_db_fields('length', 'products_length', 'product_id = ' . (int)$products[$i]['id'] . ' and id =' . (int)$value, '');
                    if ($length_name) {
                        $length = str_replace(' ', '', $length_name);
                    }
                }

            }
        }
        if (is_array($thisAttr) && sizeof($thisAttr)) {
            $FsCustomRelate::$products_id = (int)$products[$i]['id'];
            $FsCustomRelate::$optionAttr = $thisAttr;
            $FsCustomRelate::$length = $length;
            $matchProducts = $FsCustomRelate->handle();
            if ($matchProducts) {
                $standard_products = $matchProducts[0];
            }
        }
        if (($is_special == 0 && $is_confirm == 0)) {
            if (isset($instock_category) && is_array($instock_category)) {                                           //客户某些分类订单 需销售确认
                $update_status = fs_customer_order_product_auto_instock((int)$standard_products, $instock_category);
            } else {
                $update_status = 1;
            }
            if ($update_status) {

                //如果客户有定制产品就走武汉仓库
                if (in_array($warehouse, array(3, 20, 2, 37, 40))) {
                    if ($warehouse == 3) {
                        $remain_num = fs_products_instock_qty_of_products_id($standard_products, "US", false, $pcs = 0, false);
                    } elseif ($warehouse == 20) {
                        $remain_num = fs_products_instock_qty_of_products_id($standard_products, "DE", false, $pcs = 0, false);
                    } elseif ($warehouse == 37) {
                        $remain_num = fs_products_instock_qty_of_products_id($standard_products, "AU", false, $pcs = 0, false);
                    } elseif ($warehouse == 40){
                        $remain_num = fs_products_instock_qty_of_products_id($standard_products, "US-ES", false, $pcs = 0, false);
                    } else {
                        $remain_num = fs_products_instock_qty_of_products_id($standard_products, "CN", true, $pcs = 0, true);
                    }
                    if ($is_spring) {
                        if ($remain_num < $products[$i]['quantity']) {
                            $products_arr["global"][$m] = $products[$i];
                            $m++;
                        } else {
                            $products_arr["local"][$n] = $products[$i];
                            $n++;
                        }
                    } else {
                        if ($remain_num < $products[$i]['quantity']) {
                            if ($remain_num <= 0) {
                                $products_arr["delay"][$j] = $products[$i];
                                $j++;
                            } else {
                                $products_arr["delay"][$j] = $products[$i];
                                $products_arr["delay"][$j]['quantity'] = $products_arr["delay"][$j]['quantity'] - $remain_num;
                                if ($warehouse == 2) {
                                    $products_arr["global"][$m] = $products[$i];
                                    $products_arr["global"][$m]['quantity'] = $remain_num;
                                    $m++;
                                } else {
                                    $products_arr["local"][$n] = $products[$i];
                                    $products_arr["local"][$n]['quantity'] = $remain_num;
                                    $n++;
                                }
                                $j++;
                            }
                        } else {
                            if ($warehouse == 2) {
                                $products_arr["global"][$m] = $products[$i];
                                $m++;
                            } else {
                                $products_arr["local"][$n] = $products[$i];
                                $n++;
                            }
                        }
                    }
                }
            } else {
                $products_arr["delay"][$j] = $products[$i];
                $j++;
            }
        } else {
            $products_arr["delay"][$j] = $products[$i];
            $j++;
        }

    }

    return $products_arr;
}

function fs_getProducts_by_warehouse($country_code)
{
	$productArray =  $_SESSION['cart']->get_products();
	$product_separate_by_warehouse = fs_order_deliver_all($country_code, $productArray,true);
	if ($product_separate_by_warehouse['type'] == "global") {
		$all_title = $product_separate_by_warehouse["title"];
		$product_all = $product_separate_by_warehouse["product"]["local"]["products"];
		$warehouse_flag = "all";
		$max_time = $product_separate_by_warehouse["product"]["shipping_time"];
		return array(
			'type' => $warehouse_flag,
		    "all_title" => $all_title,
			"local" => array("title" => $all_title, "products" => $product_all),
			"shipping_time" =>$max_time
		);
	} else {
		$global_title = $product_separate_by_warehouse["product"]["global"]["title"];
		$local_title = $product_separate_by_warehouse["product"]["local"]["title"];
		$global_product = $product_separate_by_warehouse["product"]["global"]["products"];
		$local_product = $product_separate_by_warehouse["product"]["local"]["products"];
		$warehouse_flag = "separate";
		$max_time = $product_separate_by_warehouse["product"]["shipping_time"];
		return array(
			'type' => $warehouse_flag,
			"local" => array("title" => $local_title, "products" => $local_product),
			"global" => array("title" => $global_title, "products" => $global_product),
			"shipping_time" =>$max_time
		);
	}
}

function fs_order_deliver_all($country_code,$productArr,$is_ajax=false)
{
	//客户国家在欧盟地区
	if(german_warehouse($code = "country_code", $country_code)||other_eu_warehouse($country_code,"country_code")){
		//判断产品德国仓库是否有货，如果有则从本地仓库发货（库存不足也从本地发）
		if($is_ajax){
			return array("type" => "de_separate", "product" => fs_order_deliver_separate_for_ajax(20,$productArr,$country_code));
		}
		return array("type" => "de_separate", "product" => fs_order_deliver_separate(20,$productArr));

	}elseif (seattle_warehouse($code = "country_code", $country_code)){
		//判断产品西雅图仓库是否有货，如果有则从本地仓库发货（库存不足也从本地发）
		if($is_ajax){
		return array("type" => "seattle_separate", "product" => fs_order_deliver_separate_for_ajax(3,$productArr,$country_code));
		}
		return array("type" => "seattle_separate", "product" => fs_order_deliver_separate(3,$productArr));
	}elseif (strtoupper($country_code)=="AU"){
		if ($is_ajax) {
			return array("type" => "au_separate", "product" => fs_order_deliver_separate_for_ajax(37, $productArr));
		}
		return array("type" => "au_separate", "product" => fs_order_deliver_separate(37, $productArr));
	}else{
		//其余国家则从全球仓库发货.如果是春节就从西雅图
		if(FS_IS_SPRING==1){
			return array("type" => "seattle_separate", "product" => fs_order_deliver_separate_for_ajax(2,$productArr,$country_code,true));
		}else{
			return array("type" => "global","title" => FS_WAREHOUSE_AREA_1, "product" => fs_order_deliver_separate_for_ajax(2,$productArr,$country_code));
		}
	}
}
/*
 * arguments 3=>西雅图仓库 20=>德国仓库
 * return array;
 * 用于checkout页面，产品分仓数据默认展示
 * created by aron
 */
function fs_order_deliver_separate($warehouse,$productArr)
{
	global $db;
	$FsCustomRelate = new classes\custom\FsCustomRelate();
	//判断是否整个订单产品都是德国发货
	$products = $productArr;
	$flag_status = true;
	$arr = array();
	$arr["global"]['title'] = "Ship from CN. warehouse";
	if($warehouse==3){
		$arr["local"]['title'] = "Ship from U.S. warehouse";
		$arr["local"]['warehouse'] = "seattle";
	}elseif ($warehouse==20){
		$arr["local"]['title'] = "Ship from EU. warehouse";
		$arr["local"]['warehouse'] = "Munich";
	}
	for ($i = 0; $i < sizeof($products); $i++) {
		//  定制产品录单   获取关联标准产品ID
		$thisAttr = array();
		$length = '';
		$standard_products = (int)$products[$i]['id'];
		if ($products[$i]['attributes']) {
			reset($products[$i]['attributes']);
			foreach ($products[i]['attributes'] as $option => $value) {
				if ($option == 'length') {
					$length = $value['length'];
				}else{
					$thisAttr[] = $value['options_values_id'];
				}
			}
		}
		if (is_array($thisAttr) && sizeof($thisAttr)) {
			$FsCustomRelate::$products_id = (int)$products[$i]['id'];
			$FsCustomRelate::$optionAttr = $thisAttr;
			$FsCustomRelate::$length = $length;
			$matchProducts = $FsCustomRelate->handle();
			if ($matchProducts) {
				$standard_products = $matchProducts[0];
			}
		}

		//如果该产品是有库存的,那么及时调用至订单库存表
		$relatedID = zen_get_products_related_model((int)$standard_products);
		$is_special = 0;
		$is_confirm = 0;
		if ($_SESSION['customer_id']) {
			$is_special = fs_get_data_from_db_fields('is_special', 'customers', 'customers_id =' . $_SESSION['customer_id'], '');
			//判断是否客户定制需求
			$customer_type = fs_customer_order_product_is_instock($_SESSION['customer_id']);
			if($customer_type){
				if($customer_type ==1){
					$is_confirm = 1;  //全部需要销售确认
				}else{
					$instock_category = $customer_type;  //对应分类下产品需要销售确认
				}
			}
		}
		//如果销售在后台没有指定定制客户
		if ($is_special == 0 && $is_confirm == 0) {
			$instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =" . $relatedID . " and warehouse = ".$warehouse."");
			$instockQty = 0;
			//判断是否是组合产品
			if(file_exists(DIR_FS_CATALOG.'includes/classes/FSCompositeProductsClass.php')){
				require_once(DIR_FS_CATALOG.'includes/classes/FSCompositeProductsClass.php');
				$CompositeProducts = new classes\CompositeProducts($standard_products);
				if($CompositeProducts->CompositeProductsRelated()){
					$instockQty = $CompositeProducts->CompositeRelatedInstock(($warehouse?$warehouse:2),true);
				}
			}
			if(isset($instock_category)&&is_array($instock_category)){                                           //客户某些分类订单 需销售确认
				$update_status = fs_customer_order_product_auto_instock((int)$relatedID,$instock_category);
			}else{
				$update_status = 1;
			}
			if (($instockSQL->fields['products_instock_id'] ||  $instockQty>0) && $update_status) {
				if(!$instockSQL->fields['products_instock_id'] ){
					$instockSQL->fields['products_instock_id']  = 0;
				}
				$seattle_lock_front = fs_get_data_from_db_fields('sum(qty)', 'products_instock_orders', 'instock_id=' . $instockSQL->fields['products_instock_id'], '');
				$seattle_lock_back = fs_get_data_from_db_fields('sum(change_qty)', 'products_instock_history_temp', 'products_instock_id=' . $instockSQL->fields['products_instock_id'] . ' and type=0 and warehouse='.$warehouse.'', '');
				if($instockQty<=0){
					$remain_num = $instockSQL->fields['instock_qty'] - $seattle_lock_back-$seattle_lock_front;
				}else{
					$remain_num = $instockQty ;
				}
				//当仓库是美国发货时，如果库存不足将产品拆分，还是从美国仓发货
				//当仓库是从德国发货时，库存不足时统一从德国发货
				if($remain_num>0){
					if($warehouse==3){
						if($remain_num<$products[$i]['quantity']){
							$arr['local']["products"][$i]['delay']="delay";
							$arr['local']["products"][$i]['quickly']="quickly";
							$arr['local']["products"][$i]['quickly_qty']=$remain_num;
							$arr['local']["products"][$i]['delay_qty']=$products[$i]['quantity']-$remain_num;
						}else{
							$arr['local']["products"][$i] = $productArr[$i];
						}
					}elseif($warehouse==20){
						if($remain_num<$products[$i]['quantity']){
							$arr['global']["products"][$i] = $productArr[$i];
						}else{
							$arr['local']["products"][$i] = $productArr[$i];
						}
					}
				}else{
					if($remain_num<=0 && $warehouse = 3){
						if(file_exists(DIR_FS_CATALOG.'includes/classes/FSCodeRelatedProducts.php')){
							require_once(DIR_FS_CATALOG.'includes/classes/FSCodeRelatedProducts.php');
						}
						$codeRelatedClass = new classes\codeRelatedProducts($standard_products,$products[$i]['quantity'],$warehouse);
						$bool = $codeRelatedClass::verifyProductsInstock();
						$intock_info = $codeRelatedClass::getProductsEnabledNum($codeRelatedClass::$related_id,$warehouse);
						$intock_qty = $intock_info['instock_qty'];
						if($bool&&$intock_qty >0){
							if($intock_qty<$products[$i]['quantity']){
								$arr['local']["products"][$i]['delay']="delay";
								$arr['local']["products"][$i]['quickly']="quickly";
								$arr['local']["products"][$i]['quickly_qty']=$intock_qty;
								$arr['local']["products"][$i]['delay_qty']=$products[$i]['quantity']-$intock_qty;
							}else{
								$arr['local']["products"][$i] = $productArr[$i];
							}
						}else{
							$arr['global']["products"][$i]= $productArr[$i];
						}
					}else{
					  $arr['global']["products"][$i]= $productArr[$i];
					}
				}
			} else {
				if($update_status&&$warehouse==3){
					if(file_exists(DIR_FS_CATALOG.'includes/classes/FSCodeRelatedProducts.php')){
						require_once(DIR_FS_CATALOG.'includes/classes/FSCodeRelatedProducts.php');
					}
					$codeRelatedClass = new classes\codeRelatedProducts($standard_products,$products[$i]['quantity'],$warehouse);
					$bool = $codeRelatedClass::verifyProductsInstock();
					$intock_info = $codeRelatedClass::getProductsEnabledNum($codeRelatedClass::$related_id,$warehouse);
					$intock_qty = $intock_info['instock_qty'];
					if($bool&&$intock_qty >0){
						if($intock_qty<$products[$i]['quantity']){
							$arr['local']["products"][$i]['delay']="delay";
							$arr['local']["products"][$i]['quickly']="quickly";
							$arr['local']["products"][$i]['quickly_qty']=$intock_qty;
							$arr['local']["products"][$i]['delay_qty']=$products[$i]['quantity']-$intock_qty;
						}else{
							$arr['local']["products"][$i] = $productArr[$i];
						}
					}else{
						$arr['global']["products"][$i]= $productArr[$i];
					}
				}else{
					$arr['global']["products"][$i] = $productArr[$i];
				}
			}
		} else {
			$arr['global']["products"][$i] = $productArr[$i];
		}

	}

	return $arr;
}

/*
 * ajax 数据拼接返回产品id
 *用于checkout页面数据动态展示
 * 为了数据的请求速度，目前只返回id,前台通过js根据产品id重新渲染产品
 * return array
 */
function fs_order_deliver_separate_for_ajax($warehouse,$productArr,$country_code,$is_spring=false)
{
	global $db;
	$FsCustomRelate = new classes\custom\FsCustomRelate();
	//判断是否整个订单产品都是德国发货
	$products = $productArr;
	$flag_status = true;
	$arr = array();
	$arr["global"]['title'] = FS_WAREHOUSE_AREA_1;
	$is_special = 0;
	$is_confirm = 0;
	$max_time = array();
	$quickly_time = FS_WAREHOUSE_AREA_4;
	if($warehouse==3){
		$arr["local"]['title'] = FS_WAREHOUSE_AREA_2;
		$arr["local"]['warehouse'] = "seattle";
	}elseif ($warehouse==20){
		$arr["local"]['title'] = FS_WAREHOUSE_AREA_3;
		$arr["local"]['warehouse'] = "Munich";
	}elseif ($warehouse==37){
		$arr["local"]['title'] = FS_WAREHOUSE_AREA_AU;
		$arr["local"]['warehouse'] = "Australia";
	}
	if ($_SESSION['customer_id']) {
//		$is_special = fs_get_data_from_db_fields('is_special', 'customers', 'customers_id =' . $_SESSION['customer_id'], '');
		$customer_type = fs_customer_order_product_is_instock($_SESSION['customer_id']);
		if($customer_type){
			if($customer_type ==1){
				$is_confirm = 1;  //全部需要销售确认
			}else{
				$instock_category = $customer_type;  //对应分类下产品需要销售确认
			}
		}
	}
	for ($i = 0; $i < sizeof($products); $i++) {
		$standard_products = (int)$products[$i]['id'];
		if ($products[$i]['attributes']) {
			reset($products[$i]['attributes']);
			while (list($option, $value) = each($products[$i]['attributes'])) {
				if($option!= 'length'){
					$thisAttr[$option] = $value;
				}else{
					$length_name = fs_get_data_from_db_fields('length','products_length','product_id = '.(int)$products[$i]['id'].' and id ='. (int)$value ,'');
					if($length_name){
						$length = str_replace(' ','',$length_name);
					}
				}

			}
		}
		if (is_array($thisAttr) && sizeof($thisAttr)) {
			$FsCustomRelate::$products_id = (int)$products[$i]['id'];
			$FsCustomRelate::$optionAttr = $thisAttr;
			$FsCustomRelate::$length = $length;
			$matchProducts = $FsCustomRelate->handle();
			if ($matchProducts) {
				$standard_products = $matchProducts[0];
			}
		}
		//如果美加墨和欧盟地区crm没有标记了或者是发货地址是中国
		if (($is_special == 0 && $is_confirm==0)) {
			if(isset($instock_category)&&is_array($instock_category)){                                           //客户某些分类订单 需销售确认
				$update_status = fs_customer_order_product_auto_instock((int)$standard_products,$instock_category);
			}else{
				$update_status = 1;
			}
			if($update_status){
				if(in_array($warehouse,array(3,20,2,37))){
					if($warehouse==3){
						$remain_num= fs_products_instock_qty_of_products_id($standard_products,"US",false,$pcs=0,false);
					}elseif($warehouse==20){
						$remain_num= fs_products_instock_qty_of_products_id($standard_products,"DE",false,$pcs=0,false);
					}elseif ($warehouse==37){
						$remain_num= fs_products_instock_qty_of_products_id($standard_products,"AU",false,$pcs=0,false);
					}else{
						$remain_num= fs_products_instock_qty_of_products_id($standard_products,"CN",true,$pcs=0,true);
					}
					if($is_spring){
						if($remain_num<$products[$i]['quantity']){
							$arr['global']["products"][$i]['id'] = $productArr[$i]['id'];
						}else{
							$arr['local']["products"][$i]['id'] = $productArr[$i]['id'];
						}
					}else{
						if($remain_num>0){
							if($remain_num<$products[$i]['quantity']){
								//判断是否有光模块
								$delay_time = 20;
								$have_optical_path = zen_get_product_path((int)$products[$i]['id']);
								if ($have_optical_path) {
									$have_optical_path_arr = explode('_', $have_optical_path);
									if ((int)$have_optical_path_arr['0']== 9 || (int)$have_optical_path_arr['1']==918) {
										$delay_time = 10;
									}
								}
								$ship_date = date('D. M. j', strtotime('+'. $delay_time . ' days'));
								$arr['local']["products"][$i]['id']['quickly']['id'] = $productArr[$i]['id'];
								//$arr['local']["products"][$i]['id']['quickly']['time'] = FS_WAREHOUSE_AREA_4;
								$arr['local']["products"][$i]['id']['quickly']['qty'] = $remain_num;
								$arr['local']["products"][$i]['id']['delay']['qty'] = $products[$i]['quantity']-$remain_num;
								$arr['local']["products"][$i]['id']['delay']['id'] = $productArr[$i]['id'];
								//$arr['local']["products"][$i]['id']['delay']['time'] = FS_WAREHOUSE_AREA_5." ".$ship_date;
								$time = zen_get_products_instock_delivery_time((int)$standard_products,0,$warehouse,$country_code);
								$max_time[]=$time;
							}else{
								$arr['local']["products"][$i]['id'] = $productArr[$i]['id'];
							}
						}else{
							//判断是否有光模块
							$delay_time = 20;
							$have_optical_path = zen_get_product_path((int)$products[$i]['id']);
							if ($have_optical_path) {
								$have_optical_path_arr = explode('_', $have_optical_path);
								if ((int)$have_optical_path_arr['0']== 9 || (int)$have_optical_path_arr['1']==918) {
									$delay_time = 10;
								}
							}
							$ship_date = date('D. M. j', strtotime('+'. $delay_time . ' days'));
							$arr['local']["products"][$i]['id']['delay']['qty'] = $products[$i]['quantity'];
							$arr['local']["products"][$i]['id']['delay']['id'] = $productArr[$i]['id'];
							//$arr['local']["products"][$i]['id']['delay']['time'] = FS_WAREHOUSE_AREA_5." ".$ship_date;
							$time = zen_get_products_instock_delivery_time((int)$standard_products,0,$warehouse,$country_code);
							$max_time[]=$time;
						}
					}
				}
			}else{
				//判断是否有光模块
				$delay_time = 20;
				$have_optical_path = zen_get_product_path((int)$products[$i]['id']);
				if ($have_optical_path) {
					$have_optical_path_arr = explode('_', $have_optical_path);
					if ((int)$have_optical_path_arr['0']== 9 || (int)$have_optical_path_arr['1']==918) {
						$delay_time = 10;
					}
				}
				$ship_date = date('D. M. j', strtotime('+'. $delay_time . ' days'));
				$arr['local']["products"][$i]['id']['delay']['qty'] = $products[$i]['quantity'];
				$arr['local']["products"][$i]['id']['delay']['id'] = $productArr[$i]['id'];
				//$arr['local']["products"][$i]['id']['delay']['time'] = FS_WAREHOUSE_AREA_5." ".$ship_date;
				$time = zen_get_products_instock_delivery_time((int)$productArr[$i]['id'],0,$warehouse,$country_code);
				$max_time[]=$time;
			}
		} else {
			//判断是否有光模块
			$delay_time = 20;
			$have_optical_path = zen_get_product_path((int)$products[$i]['id']);
			if ($have_optical_path) {
				$have_optical_path_arr = explode('_', $have_optical_path);
				if ((int)$have_optical_path_arr['0']== 9 || (int)$have_optical_path_arr['1']==918) {
					$delay_time = 10;
				}
			}
			$ship_date = date('D. M. j', strtotime('+'. $delay_time . ' days'));
			$arr['local']["products"][$i]['id']['delay']['qty'] = $products[$i]['quantity'];
			$arr['local']["products"][$i]['id']['delay']['id'] = $productArr[$i]['id'];
			//$arr['local']["products"][$i]['id']['delay']['time'] = FS_WAREHOUSE_AREA_5." ".$ship_date;
			$time = zen_get_products_instock_delivery_time((int)$standard_products,0,$warehouse,$country_code);
			$max_time[]=$time;
		}

	}
	if (!empty($max_time)) {
		if (sizeof($max_time) == 1) {
			$max_time = $max_time[0];
			$max_time['date'] = FS_WAREHOUSE_AREA_5." ".$max_time['date'];
		} else {
			$sort = array(
				'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
				'field' => 'time',       //排序字段
			);
			$arrSort = array();
			foreach ($max_time AS $uniqid => $row) {
				foreach ($row AS $key => $value) {
					$arrSort[$key][$uniqid] = $value;
				}
			}
			if($sort['direction']){
				array_multisort($arrSort[$sort['field']], constant($sort['direction']), $max_time);
			}
			$max_time = $max_time[0];
			$max_time['date'] = FS_WAREHOUSE_AREA_5." ".$max_time['date'];
		}
	}
	$arr['shipping_time']["delay_max_time"] = $max_time;
	$arr['shipping_time']["quickly_time"] = $quickly_time;
	return $arr;
}


function fs_create_products_for_checkout($products){
	$productArray = array();
	if(empty($products)){
		return $productArray;
	}
	foreach($products as $k=>$v){
		$productArray[$k]['qty'] = $v['quantity'];
		$productArray[$k]['id'] = $v['id'];
	}
	return $productArray;
}


//判断整单是否有一单从美国发货
function   fs_order_usa_sea_deliver(){
					global $db;
					  $FsCustomRelate = new classes\custom\FsCustomRelate();
					  //判断是否整个订单产品都是德国发货
					  $products = $_SESSION['cart']->get_products();
					  $flag_status = false;
					  for($i=0;$i<sizeof($products);$i++){
						//  定制产品录单   获取关联标准产品ID
						$thisAttr=array();
						$length = '';

						$standard_products = (int)$products[$i]['id'];
						if($products[$i]['attributes']){
							reset($products[$i]['attributes']);
							while (list($option, $value) = each($products[$i]['attributes'])) {
								if($option!= 'length'){
									$thisAttr[$option] = $value;
								}else{
									$length_name = fs_get_data_from_db_fields('length','products_length','product_id = '.(int)$products[$i]['id'].' and id ='. (int)$value ,'');
									if($length_name){
										$length = str_replace(' ','',$length_name);
									}
								}

							}
						}

						if(is_array($thisAttr)&&sizeof($thisAttr)){
							$FsCustomRelate::$products_id = (int)$products[$i]['id'];
							$FsCustomRelate::$optionAttr = $thisAttr;
							$FsCustomRelate::$length = $length;
							$matchProducts = $FsCustomRelate->handle();
							if($matchProducts){
							  $standard_products = $matchProducts[0];
							}
						}

						//如果该产品是有库存的,那么及时调用至订单库存表
						$relatedID = zen_get_products_related_model((int)$standard_products);

						$is_special = 0;
						if($_SESSION['customer_id']){
						  $is_special = fs_get_data_from_db_fields('is_special','customers','customers_id ='.$_SESSION['customer_id'],'');
						}
						//如果销售在后台没有指定定制客户
						if($is_special==0){

							$instockSQL = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id =".$relatedID." and warehouse = 3");
							if($instockSQL->fields['products_instock_id']){
								$seattle_lock_front = fs_get_data_from_db_fields('sum(qty)','products_instock_orders','instock_id='.$instockSQL->fields['products_instock_id'],'');
								$seattle_lock_back = fs_get_data_from_db_fields('sum(change_qty)','products_instock_history_temp','products_instock_id='.$instockSQL->fields['products_instock_id'].' and type=0 and warehouse=3','');
								$remain_num = $instockSQL->fields['instock_qty']-$seattle_lock_front-$seattle_lock_back;
								if($remain_num>$products[$i]['quantity']){
									$flag_status = true;break;
								}
							}
						}

			}
				return $flag_status;
}



function  fs_get_shipping_de_status($entry_country_id){

$german_shipping  = 0;
$EU_country = array(73,81,203,56,150,124,171,84,103,170,123,117,67,72,14,53,97,189,175,33,21,105,195,55,190,57,132,222,240,141);

if(in_array($entry_country_id,$EU_country)){
	if(fs_order_de_deliver()){
		if($entry_country_id == 81){
			$german_shipping  = 1;
		}else{
			$german_shipping  = 2;
		}
	}
}


return $german_shipping;

}

function fs_shipping_de_ups_is_free($code,$price_total,$shipping_method = 'ups',$is_shipping_free = false){
    global $order;
    if($shipping_method == 'dhl'){
        //新添加'GG', 'IM', 'IE', 'JE', 'GB'
        $code_arr = array('MT','CY','IS','BA','RS','ME','MK','AL','MD','FO','GL','GP','GF','MQ','RE','YT','AW','IC','FR', 'GG', 'IM', 'IE', 'JE', 'GB');
    }else{
        $code_arr = array('BE','GB','FR','IT','NL','LU','DK','IE','ES','GR','PT','AT','SE','FI','MT','CY','PL','HU','CZ','SK','SI','EE','LV','LT','RO','BG','HR','MC','AD','JE','LI','NO','SM','CH','IM','GG','VA');
    }

    if(in_array($code,$code_arr)){
        if($is_shipping_free){
            return true;
        }
    }
    return false;

}



function fs_shipping_de_ups_is_free_new($code,$price_total,$shipping_method = 'ups'){
    if($shipping_method == 'dhl'){
        $code_arr = array('MT','CY','IS','BA','RS','ME','MK','AL','MD','FO','GL','GP','GF','MQ','RE','YT','AW','IC');
    }else{
        $code_arr = array('BE','GB','FR','DE','IT','NL','LU','DK','IE','ES','GR','PT','AT','SE','FI','MT','CY','PL','HU','CZ','SK','SI','EE','LV','LT','RO','BG','HR','MC','AD','JE','LI','NO','SM','CH');
    }
    if(in_array($code,$code_arr)){
        if($price_total>=79){
            return true;
        }
    }
    return false;

}



function  zen_get_shipping_title($shipping){

	switch($shipping){
		case 'DHLG':
			$shipping_title = FS_DHLG;
			break;
		case 'DHLE':
			$shipping_title = FS_DHLE;
			break;
		case 'DHLEE':
			$shipping_title = FS_DHLEE;
			break;
		default:
		$shipping_title = $shipping;

	}
	return $shipping_title;
}

//获取运输方式名称
function zen_get_order_shipping_method_by_code($shipping_method, $orders_id = "")
{
    $method = '';
    switch (1) {
        case preg_match('/fedexground/i', $shipping_method):
            $method = 'FedEx Ground';
            break;
        case preg_match('/fedexgroundeastzones/i', $shipping_method):
            $method = 'FedEx Ground';
            break;
        case preg_match('/fedex2day/i', $shipping_method):
            $method = 'FedEx 2Day';
            break;
        case preg_match('/fedex2dayeastzones/i', $shipping_method):
            $method = 'FedEx 2Day';
            break;
        case preg_match('/fedex3dayzones/i', $shipping_method):
            $method = 'FedEx 1-3 Business Days';
            break;
        case preg_match('/fedexexpresssaver/i', $shipping_method):
            $method = 'FedEx Express Saver';
            break;
        case preg_match('/fedexovernight/i', $shipping_method):
            $method = 'FedEx Overnight';
            break;
        case preg_match('/fedexovernighteastzones/i', $shipping_method):
            $method = 'FedEx Overnight';
            break;
        case preg_match('/fedexiezones/i', $shipping_method):
            $method = 'FedEx IE';
            break;
        case preg_match('/fedexzones/i', $shipping_method):
            $method = 'FedEx IP';
            break;

        case preg_match('/dhlee/i', $shipping_method):
            $method = 'DHL ECONOMY';
            break;

        case preg_match('/dhlzones/i', $shipping_method):
            $method = 'DHL';
            break;
        case preg_match('/dhlazones/i', $shipping_method):
            $method = 'DHL';
            break;
        case preg_match('/airmailzones/i', $shipping_method):
            $method = 'Airmail';
            break;
        case preg_match('/seazones/i', $shipping_method):
            $method = 'SEA';
            break;
        case preg_match('/emszones/i', $shipping_method):
            $method = 'EMS';
            break;
        case preg_match('/upszones/i', $shipping_method):
            $method = 'UPS';
            break;
        case preg_match('/tntzones/i', $shipping_method):
            $method = 'TNT';
            break;
        case preg_match('/customzones/i', $shipping_method):
            if ($orders_id) {
                $order_data = fs_get_data_from_db_fields('method', 'orders_shipping', 'orders_id=' . $orders_id, 'limit 1');
                $method = $order_data . '  ('.FS_CUSTOMER_ACCOUNT.')';
            } else {
                $method = FS_CUSTOMER_ACCOUNT;
            }
            break;
        case preg_match('/ups2dayszones/i', $shipping_method):
            $method = 'UPS2DAYS';
            break;
        case preg_match('/ups2dayseastzones/i', $shipping_method):
            $method = FIBER_CHECK_TWO;
            break;
        case preg_match('/ups2daysamzones/i', $shipping_method):
            $method = 'UPS Next Day-Early® Service';
            break;
        case preg_match('/upsgroundzones/i', $shipping_method):
            $method = 'UPS Ground';
            break;
        case preg_match('/upsgroundeastzones/i', $shipping_method):
            $method = 'UPS Ground';
            break;
        case preg_match('/upsovernightzones/i', $shipping_method):
            $method = 'UPS Overnight';
            break;
        case preg_match('/upsovernighteastzones/i', $shipping_method):
            $method = FIBER_CHECK_ONE;
            break;
        case preg_match('/ffzones/i', $shipping_method):
            $method = 'ODFL';
            break;
        case preg_match('/saturdaydeliveryzones/i', $shipping_method):
            $method = 'Saturday Delivery';
            break;
        case preg_match('/dhlsaturdayzones/i', $shipping_method):
            $method = 'DHL Saturday Delivery';
            break;
        case preg_match('/selfreferencezones/i', $shipping_method):
            $method = FS_LOCAL_PICKUP;
            break;
        case preg_match('/fedexovernightzones/i', $shipping_method):
            $method = FIBER_FEDEX_CHECK_OVER;
            break;
        case preg_match('/fedex2dayzones/i', $shipping_method):
            $method = FIBER_FEDEX_CHECK_TWO;
            break;
        case preg_match('/upsstandardzones/i', $shipping_method):
            $method = 'UPS Standard';
            break;
        case preg_match('/tntezones/i', $shipping_method):
            $method = 'TNT Economy Express';
            break;
        case preg_match('/tntgzones/i', $shipping_method):
            $method = 'TNT Express';
            break;
        case preg_match('/dhlgzones/i', $shipping_method):
            $method = 'DHL Express Domestic';
            break;
        case preg_match('/upssaverzones/i', $shipping_method):
            $method = 'UPS Express Saver';
            break;
        case preg_match('/dhlezones/i', $shipping_method):
            $method = 'DHL Express Worldwide';
            break;
        case preg_match('/seazones/i', $shipping_method):
            $method = 'Sea shipping';
            break;
        case preg_match('/airliftzones/i', $shipping_method):
            $method = 'Airlift shipping';
            break;
        case preg_match('/sfzones/i', $shipping_method):
            $method = 'SF Express';
            break;
        case preg_match('/dhlexpresszones/i', $shipping_method):
            $method = 'DHL EXPRESS 9:00';
            break;
        case preg_match('/dhlexpressdzones/i', $shipping_method):
            $method = 'DHL EXPRESS 12:00';
            break;
        case preg_match('/dhleconomyzones/i', $shipping_method):
            $method = 'DHL ECONOMY';
            break;
        case preg_match('/upsexpresspluszones/i', $shipping_method):
            $method = FS_CHECKOUT_UPS_PLUS;
            break;
        case preg_match('/upsexpresszones/i', $shipping_method):
            $method = FS_CHECKOUT_UPS;
            break;
        case preg_match('/fastwaycourierzones/i', $shipping_method):
            $method = 'Fastway Courier';
            break;
        case preg_match('/startrackzones/i', $shipping_method):
            $method = 'StarTrack Premium';
            break;
        case preg_match('/startrackfzones/i', $shipping_method):
            $method = 'StarTrack';
            break;
        case preg_match('/upsltlzones/i', $shipping_method):
            $method = 'UPS LTL Service';
            break;
        case preg_match('/dhlauzones/i', $shipping_method):
            $method = 'DHL Express Service';
            break;
        case preg_match('/tntauovernightexpresszones/i', $shipping_method):
            $method = 'TNT Overnight Express Service';
            break;
        case preg_match('/tntauroadexpresszones/i', $shipping_method):
            $method = 'TNT Road Express Service';
            break;
        case preg_match('/tntauzones/i', $shipping_method):
            $method = 'TNT 9:00 Express Service';
            break;
        case preg_match('/upsazones/i', $shipping_method):
            $method = "UPS Express";
            break;
        case preg_match('/fedexsamedayzones/i', $shipping_method):
            $method = "FedEx SameDay Standard";
            break;
        case preg_match("/aupoststandardzones/i", $shipping_method):
            $method = "Australia Post Standard";
            break;
        case preg_match("/aupostexpresszones/i", $shipping_method):
            $method = 'Australia Post Express';
            break;
        case preg_match("/dhlauexpressworldwidezones/i", $shipping_method):
            $method = 'DHL Express Worldwide Service';
            break;
        case preg_match("/fedexaunormalzones/i", $shipping_method):
            $method = 'FedEx Normal Service';
            break;
        case preg_match("/fedexauexpresszones/i", $shipping_method):
            $method = 'FedEx Express Service';
            break;
        case preg_match("/fedexpriorityovernightzones/i", $shipping_method):
            $method = 'FedEx Priority Overnight';
            break;
        case preg_match("/uspsprioritymailzones/i", $shipping_method):
            $method = 'USPS Retail Ground@ service';
            break;
        case preg_match("/forwarderzones/i",$shipping_method):
            $method = FS_FORWARD_SHIPPING;
            break;
        case preg_match("/courierzones/i",$shipping_method):
            $method = SHIPPING_COURIER_DELIVERY;
            break;
        case preg_match("/fs2dayzones/i",$shipping_method):
            $method = FS_SG_NEXT_WORKING_DAY;
            break;
        case preg_match("/fsinstallzones/i",$shipping_method):
            $method =FS_SG_DELIVERY_INSTALLATION;
            break;
        case preg_match("/fssamedayzones/i",$shipping_method):
            $method = FS_SG_SAME_WORKING_DAY;
            break;
        case preg_match("/simplyzones/i",$shipping_method):
            $method = 'SimplyPost 1-3 Working Days';
            break;
        case preg_match("/simplyovernightzones/i",$shipping_method):
            $method = 'SimplyPost Next Working Day';
            break;
        case preg_match("/grabexpresszones/i",$shipping_method):
            $method = 'GrabExpress Same Day';
            break;
        case preg_match("/ninjavanstandardzones/i",$shipping_method):
            $method = 'Ninja Van Standard';
            break;
        case preg_match("/ninjavanovernightzones/i",$shipping_method):
            $method = 'Ninja Van Next Working Day';
            break;
        case preg_match("/speedpoststandardzones/i",$shipping_method):
            $method = 'Speedpost Standard 1 Working Day';
            break;
        case preg_match("/dhlsexpresszones/i",$shipping_method):
            $method = 'DHL World Express 1-3 Working Days';
            break;
        case preg_match("/singapostandardtzones/i",$shipping_method):
            $method = 'Singapost Standard';
            break;
        case preg_match("/upsexpressworldwidezones/i",$shipping_method):
            $method = 'UPS Worldwide Express';
            break;
        case preg_match("/fedexsgiezones/i",$shipping_method):
            $method = 'FedEx IE';
            break;
        case preg_match("/fedexsgzones/i",$shipping_method):
            $method = 'FedEx IP';
            break;
        case preg_match("/simplypostborderzones/i",$shipping_method):
            $method = 'SimplyPost Border Linehaul';
            break;
    }
    return $method;
}
//获取订单付款方式
function zen_get_order_peyment_method($payment_method){
	$method = '';
	switch(1){
		case preg_match('/paypal/i',$payment_method):
			$method = FS_PAY_WAY_PAYPAL;
		break;
		case preg_match('/west/i',$payment_method):
			$method = FS_PRINT_ORDER_WESTERN;
		break;
		case preg_match('/hsbc/i',$payment_method):
			$method = FS_PRINT_ORDER_BANK;
		break;
		case preg_match('/purchase/i',$payment_method):
			$method = FS_CHECKOUT_NEW34;
		break;
		case preg_match('/globalcollect/i',$payment_method):
			$method = FS_PRINT_ORDER_CREDIT;
		break;
        case preg_match('/echeck/i',$payment_method):
               $method = FS_CHECKOUT_NEW42;
               break;
        case preg_match('/payeezy/i',$payment_method):
//            $method = FS_PAY_WAY_PAYEEZY;
            $method = FS_PRINT_ORDER_CREDIT;
            break;
        case preg_match('/alfa/i',$payment_method):
            $method = FS_CHECKOUT_NEW_CASHLESS;
            break;
        case preg_match('/bpay/i',$payment_method):
            $method = FS_CHECKOUT_NEW35;
            break;
		default:
			$method = $payment_method;
		break;
	}
	return $method;
}

//获取订单中客户备注内容
function zen_get_order_has_customer_remarks($oid)
{
    global $db;
    $sql = 'select customers_remarks from orders where orders_id =' . (int)$oid;
    $orders = $db->Execute($sql);
    if ($orders->fields['customers_remarks']) {
        return $orders->fields['customers_remarks'];
    }
}

//澳大利亚针对dhl tnt 获取邮编  zone 判断是否为偏远地区
function zen_get_shipping_au_code($postcode,$shipping_method){
    global $db;
    if($shipping_method == 'zone'){
        $list = fs_get_data_from_db_fields_array(array('code','value','type','flag'),'shipping_au_code','type = 2');
        if($list){
            foreach($list as $p){
                if($postcode == $p[1]){
                    return $p[3];
                }
            }
            foreach($list as $p){
                if(substr($postcode,0,3) == $p[1]){
                    return $p[3];
                }
            }
        }
        return 2;
    }
    if($shipping_method == 'dhl'){
        $type = 0;
    }elseif($shipping_method == 'ST'){
        $type = 3;
    }else{
        $type = 1;
    }
    $result = fs_get_data_from_db_fields_array(array('code','value','type'),'shipping_au_code','type = "'.$type.'"');

    foreach($result as $v){
        if($type == 1){
            $value = explode(':',$v[1]);
        }else{
            $value = explode(',',$v[1]);
        }

        if(sizeof($value)){
            foreach($value as $x){
                $code_value_arr = explode('-',$x);

                if(count($code_value_arr)>1){
                    $code_value1 = $code_value_arr[0];
                    $code_value2 = $code_value_arr[1];
                    if($postcode <= $code_value2 && $postcode >= $code_value1){
                        return $v[0];
                    }
                }else{
                    if($postcode == $x){

                        return $v[0];
                    }
                }

            }
            foreach($value as $x){
                $code_value_arr = explode('-',$x);

                if(count($code_value_arr)>1){
                    $code_value1 = $code_value_arr[0];
                    $code_value2 = $code_value_arr[1];
                    if(substr($postcode,0,3) <= $code_value2 && substr($postcode,0,3) >= $code_value1){
                        return $v[0];
                    }
                }else{
                    if(substr($postcode,0,3) == $x){
                        return $v[0];
                    }
                }


            }


            foreach($value as $x){
                $code_value_arr = explode('-',$x);
                if(count($code_value_arr)>1){
                    $code_value1 = $code_value_arr[0];
                    $code_value2 = $code_value_arr[1];
                    if(substr($postcode,0,3) <= $code_value2 && substr($postcode,0,3) >= $code_value1){
                        return $v[0];
                    }
                }else{
                    if(substr($postcode,0,3) == $x){
                        return $v[0];
                    }
                }


            }
        }

    }
    return "";
}
function fs_get_east_west_shipping_time($code,$type){
    global $db,$order;
    $type = "east";
    if($code) {
        if ($type == 'east') {
            $sql = "select timeliness_md from countries_to_zip where zip = '" . $code . "'";
            $result = $db->Execute($sql);
            if ($result->fields['timeliness_md']) {
                return $result->fields['timeliness_md'];
            }
        } else {
            $sql = "select timeliness_mx from countries_to_zip where zip = '" . $code . "'";
            $result = $db->Execute($sql);
            if ($result->fields['timeliness_mx']) {
                return $result->fields['timeliness_mx'];
            }
        }
    }else{
        return 0;
    }

}
//获取美国zone
function zen_get_shipping_fedex_code_zone($postcode,$zone_type,$shipping_zone){
    global $db;
    $list = fs_get_data_from_db_fields_array(array('zip_code',$shipping_zone),'shipping_fedex','zone_type = "'.$zone_type.'"');
    if($list){
        foreach($list as $p){
            $code_value_arr = explode('-',$p[0]);
            if(substr($postcode,0,2) != '00') {
                if (count($code_value_arr) > 1) {
                    $code_value1 = $code_value_arr[0];
                    $code_value2 = $code_value_arr[1];
                    if ($postcode <= $code_value2 && $postcode >= $code_value1) {
                        return $p[1];
                    }
                } else {
                    if ($postcode == $p[0]) {
                        return $p[1];
                    }
                }
            }
            if(count($code_value_arr)>1){
                $code_value1 = $code_value_arr[0];
                $code_value2 = $code_value_arr[1];
                if(substr($postcode,0,3) <= $code_value2 && substr($postcode,0,3) >= $code_value1){
                    return $p[1];
                }
            }else{
                if(substr($postcode,0,3) == $p[0]){
                    return $p[1];
                }
            }
        }

    }
}

/**
 * 获取ups saver 的zone值
 * @param $country 国家
 * @param $postcode 邮编
 * add by quest 2019-06-21
 */
function zen_get_shipping_upssaver_code_zone($country,$postcode)
{
    $return = array('flag' => 0 ,'zone' => 0, 'type' => 0);
    if(empty($postcode) || empty($country)){
        return $return;
    }

    switch ($country){
        case 'GB':
            $postcode_pre = substr($postcode,0,2);
            $c_type = fs_get_data_from_db_fields('type','countries_uk_zip','postcode LIKE "'.$postcode_pre.'%" LIMIT 1');
            if($c_type == 2){//北爱尔兰
                $return['zone'] = 4;
            }else{
                $return['zone'] = 3;
            }
            $return['flag'] = 1;
            break;
        case 'ES':
            $c_type = fs_get_data_from_db_fields('type','countries_es_zip','postcode = "'.$postcode.'"');
            if(!in_array($c_type,[1,2])){//非休达或梅利利亚
                $return['zone'] = 4;
                $return['flag'] = 1;
            }else{
                $return['flag'] = 0;
            }
            $return['type'] = $c_type;
            break;
        case 'IC'://加那利群岛
            $return['zone'] = 10;
            $return['flag'] = 1;
            break;
    }

    return $return;

}

/**
 * 获取ups plus 的zone值
 * @param $country 国家
 * @param $postcode 邮编
 * add by quest 2019-06-21
 */
function zen_get_shipping_upsplus_code_zone($country,$postcode){
    $return = array('flag' => 0 ,'zone' => 0);
    if(empty($postcode) || empty($country)){
        return $return;
    }

    switch ($country){
        case 'GB':
            $post_prefix = substr($postcode,0,2);
            $c_type = fs_get_data_from_db_fields('type','countries_uk_zip','postcode LIKE "'.$post_prefix.'%"');
            if($c_type == 1){//英格兰
                $return['zone'] = 3;
                $return['flag'] = 1;
            }
            break;
        case 'ES':
            $c_type = fs_get_data_from_db_fields('type','countries_es_zip','postcode = "'.$postcode.'"');
            if(!in_array($c_type,[1,2])){//非 休达或梅利利亚
                $return['zone'] = 4;
                $return['flag'] = 1;
            }
            break;
    }
    return $return;
}

function zen_get_shipping_upsstandard_code_zone($country,$postcode){
    $return = array('flag' => 0 ,'zone' => 0);
    if(empty($country)){
        return $return;
    }

    if(empty($postcode) && !in_array($country,['IT','VA'])){
        return $return;
    }

    switch ($country){
        case 'GB':
            $post_prefix = substr($postcode,0,2);
            $c_type = fs_get_data_from_db_fields('type','countries_uk_zip','postcode LIKE "'.$post_prefix.'%"');
            if($c_type == 2){//北爱尔兰
                $return['zone'] = 11;
                $return['flag'] = 1;
            }else{
                $return['zone'] = 8;
                $return['flag'] = 1;
            }
            $return['type'] = $c_type;
            break;
        case 'ES':
            $c_type = fs_get_data_from_db_fields('type','countries_es_zip','postcode = "'.$postcode.'"');
            if(!in_array($c_type,[1,2])){//非 休达或梅利利亚
                $return['zone'] = 11;
                $return['flag'] = 1;
            }
            $return['type'] = $c_type;
            break;
        case 'IT':
        case 'VA':
            if($postcode >= 10000 && $postcode <= 50999){
                $return['zone'] = 9;
            }else{
                $return['zone'] = 11;
            }
            $return['type'] = '';
            $return['flag'] = 1;
            break;
    }
    return $return;
}

/**
 * 获取运输方式清单
 *
 * @param string $shipping_warehouse  查询仓库
 * @param array $limit  //运输方式限制
 * @return array
 */
function getShippingList($shipping_warehouse = "", $limit = [])
{
    global $order;
    if(empty($order) || !is_object($order)){
        return array();
    }
    $currencies = new currencies();
    $data = array();
    $j = 0;
    $company_type = $order->delivery['company_type'];
    $country_code = $order->delivery['country']['iso_code_2'];
    $city = $order->delivery['state'];
    $postcode = $order->delivery['postcode'];
    $order_info = $order->get_order_num();
    $order_data = $order_info['data'];
    $order_num = $order_info['num'];
    $order_tag = $order_info['data'];
    $is_self_lifting = true;
    $is_show_overnight = true;
    $local_hour = getTime("G",time(),$country_code);
    $local_day = getTime('D',time(),$country_code);
    $shipping_day = 0;
    $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
    $country_id = $order->delivery['country_id'];
    $warehouse = $order->local_warehouse;
    $state = $order->delivery['state'];
    $states_code = !empty($state) ? fs_get_data_from_db_fields('states_code','countries_us_states','states = "'.$state.'"'.' AND status = 1 AND type = 1') : '';

    switch ($shipping_warehouse) {
        case "US":
            //是否为美西邮编
            $current_hour = getTime("G",time(),$country_code);
            $is_settle_zone = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$postcode.'" and type = 2 and shipping_type = 1 limit 1');
            //整单才展示自提
            if ($order_data != "local") {
                $is_self_lifting = false;
            }
            if (in_array($country_id, array(138, 38))) {
                $shipping_arr = array(

                    array(
                        'method' => 'dhlazones',
                        'title' => 'DHL'
                    ),
                    array(
                        'method' => 'fedex3dayzones',
                        'title' => 'FedEx'
                    ),
                    array(
                        'method' => 'upsazones',
                        'title' => 'UPS Expedited'
                    )

                );
            } else {
                $shipping_arr1 = array(
                    array(
                        'method' => 'fedexgroundzones',
                        'title' => FIBER_FEDEX_CHECK_GROUND
                    ),
                    array(
                        'method' => 'upsgroundzones',
                        'title' => FIBER_CHECK_STAND
                    ),
                    array(
                        'method' => 'fedex2dayzones',
                        'title' => FIBER_FEDEX_CHECK_TWO
                    ),
                    array(
                        'method' => 'ups2dayszones',
                        'title' => FIBER_CHECK_TWO
                    ),
                    array(
                        'method' => 'fedexpriorityovernightzones',
                        'title' => 'FedEx Priority Overnight'
                    )
                );
                $shipping_arr2 = array(
                    array(
                        'method' => 'upsovernightzones',
                        'title' => FIBER_CHECK_ONE
                    ),
                    array(
                        'method' => 'fedexovernightzones',
                        'title' => FIBER_FEDEX_CHECK_OVER
                    )
                );
                $shipping_arr3 = array(
                    array(
                        'method' => 'upsovernightzones',
                        'title' => FIBER_CHECK_ONE . FIBER_SHIPPING_MONDAY_DELIVERY
                    ),
                    array(
                        'method' => 'fedexovernightzones',
                        'title' => FIBER_FEDEX_CHECK_OVER . FIBER_SHIPPING_MONDAY_DELIVERY
                    )
                );
                $shipping_arr4 = array(
                    array(
                        'method' => 'fedexsamedayzones',
                        'title' => 'FedEx SameDay Standard'
                    )
                );
                if ($local_day == 'Fri') {
                    $shipping_arr = array_merge($shipping_arr1, $shipping_arr3);
                } else {
                    $shipping_arr = array_merge($shipping_arr1, $shipping_arr2);
                }
                if ($current_hour<13 && $is_self_lifting && $is_settle_zone){
                    $shipping_arr = array_merge($shipping_arr, $shipping_arr4);
                }
                if($order->is_buck_in_products){
                    $shipping_arr = array(
                        array(
                            'method' => 'fedexgroundzones',
                            'title' => FIBER_FEDEX_CHECK_GROUND
                        ),
                        array(
                            'method' => 'upsgroundzones',
                            'title' => FIBER_CHECK_STAND
                        )
                    );
                }
            }
            if($country_id == 223 && $state && in_array($state,array("Armed Forces Americas","Armed Forces Pacific","Armed Forces other"))){
                $shipping_arr = array(
                    array(
                        'method' => 'uspsprioritymailzones',
                        'title' => 'USPS Priority Mail® Service'
                    ),
                );
            }
            if($state == "Puerto Rico" && $country_id == 223){
                $shipping_arr = array(
                    array(
                        'method' => 'fedex3dayzones',
                        'title' => 'FedEx'
                    ),
                    array(
                        'method' => 'upsovernightzones',
                        'title' => FIBER_CHECK_ONE
                    )
                );
            }
            break;
        case "US-ES":
            $current_hour = getTime("G",time(),$country_code,"America/New_York");
            $is_east_zone = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$postcode.'" and type = 1 and shipping_type = 1 limit 1');
            //整单才展示自提
            if ($order_data != "local") {
                $is_self_lifting = false;
            }
            if (in_array($country_id, array(138, 38))) {
                $shipping_arr = array(
                    array(
                        'method' => 'dhlazones',
                        'title' => 'DHL'
                    ),
                    array(
                        'method' => 'upscmpexpresszones',
                        'title' => 'UPS Express'
                    )

                );

                if($order->info['subtotal'] > 1000 && $country_id == 138){
                    $shipping_arr_sort_o = ['method' => 'fedex3dayzones', 'title' => 'FedEx'];
                    $shipping_arr_sort_t = ['method' => 'upsazones', 'title' => 'UPS Expedited'];
                }else{
                    $shipping_arr_sort_o = ['method' => 'upsazones', 'title' => 'UPS Expedited'];
                    $shipping_arr_sort_t = ['method' => 'fedex3dayzones', 'title' => 'FedEx'];
                }
                array_unshift($shipping_arr, $shipping_arr_sort_o, $shipping_arr_sort_t);

                $is_east_zone = false;
            } else {
                $shipping_arr = array(
                    array(
                        'method' => 'upsgroundeastzones',
                        'title' => FIBER_CHECK_STAND
                    ),
//                    array(
//                        'method' => 'fedexgroundeastzones',
//                        'title' => FIBER_FEDEX_CHECK_GROUND
//                    ),
                    array(
                        'method' => 'fedex2dayeastzones',
                        'title' => FIBER_FEDEX_CHECK_TWO
                    ),
                    array(
                        'method' => 'ups2dayseastzones',
                        'title' => FIBER_CHECK_TWO
                    ),
                    array(
                        'method' => 'upsovernighteastzones',
                        'title' => FIBER_CHECK_ONE,
                    ),
                    array(
                        'method' => 'fedexovernighteastzones',
                        'title' => FIBER_FEDEX_CHECK_OVER
                    ),
                    array(
                        'method' => 'ups2daysamzones',
                        'title' => 'UPS Next Day-Early® Service'
                    )
                );
            }

            if($country_id == 223 && $state && in_array($state,array("Armed Forces Americas","Armed Forces Pacific","Armed Forces other"))){
                $shipping_arr = array(
                    array(
                        'method' => 'uspsprioritymailzones',
                        'title' => 'USPS Retail Ground@ Service'
                    ),
                );
            }
            if( $country_id == 172){
                $shipping_arr = array(
                    array(
                        'method' => 'upsgroundeastzones',
                        'title' => FIBER_CHECK_STAND
                    ),
                    array(
                        'method' => 'ups2dayseastzones',
                        'title' => FIBER_CHECK_TWO
                    ),
                    array(
                        'method' => 'upsovernighteastzones',
                        'title' => FIBER_CHECK_ONE
                    ),
                );
            }
            if(!empty($order->local_cabinet)){
                $shipping_arr = array(
                    array(
                        'method' => 'upsltlzones',
                        'title' => 'UPS LTL'
                    )
                );
            }
            break;
        case "DE":
            $is_show = true;
            //如果整单没有从德国发货就不展示
            if ($order_data != 'local') {
                $is_show = false;
            }
            if ($_SESSION['languages_id']) {
                if ($country_id == 81) {
                    $shipping_arr = array(

                        array(
                            'method' => 'tntgzones',
                            'title' => 'TNT Express®'
                        ),

                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard®'
                        ),
                        array(
                            'method' => 'dhlgzones',
                            'title' => 'DHL Express Domestic®'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver®'
                        ),
                        array(
                            'method' => 'dhlexpresszones',
                            'title' => 'DHL Express 9:00®'
                        ),
                        array(
                            'method' => 'dhlexpressdzones',
                            'title' => 'DHL Express 12:00®'
                        ),
                        array(
                            'method' => 'dhleconomyzones',
                            'title' => 'DHL Economy Select®'
                        ),
                        array(
                            'method' => 'upsexpresspluszones',
                            'title' => 'UPS Express Plus Next Day 9:00®'
                        ),
                        array(
                            'method' => 'upsexpresszones',
                            'title' => 'UPS Express Next Day 12:00®'
                        )

                    );
                } elseif ($country_id == 98) {
                    $shipping_arr = array(


                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard®'
                        ),
                        array(
                            'method' => 'tntezones',
                            'title' => 'TNT Economy Express®'
                        ),
                        array(
                            'method' => 'dhlezones',
                            'title' => 'DHL Economy Select®'
                        ),
                        array(
                            'method' => 'dhleconomyzones',
                            'title' => 'DHL Economy Select®'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver®'
                        ),
                        array(
                            'method' => 'dhlexpresszones',
                            'title' => 'DHL Express 9:00®'
                        ),
                        array(
                            'method' => 'dhlexpressdzones',
                            'title' => 'DHL Express 12:00®'
                        ),
                        array(
                            'method' => 'upsexpresspluszones',
                            'title' => 'UPS Express Plus Next Day 9:00®'
                        )
                    );
                } elseif ($country_id == 160) {
                    $shipping_arr = array(
                        array(
                            'method' => 'dhleconomyzones',
                            'title' => 'DHL Economy Select®'
                        ),
                        array(
                            'method' => 'tntezones',
                            'title' => 'TNT Economy Express®'
                        ),
                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard®'
                        ),
                        array(
                            'method' => 'dhlezones',
                            'title' => 'DHL Express Worldwide®'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver®'
                        ),
                        array(
                            'method' => 'dhlexpresszones',
                            'title' => 'DHL Express 9:00®'
                        ),
                        array(
                            'method' => 'dhlexpressdzones',
                            'title' => 'DHL Express 12:00®'
                        ),
                        array(
                            'method' => 'upsexpresspluszones',
                            'title' => 'UPS Express Plus Next Day 9:00®'
                        )
                    );
                } elseif ($country_id == 222){
                    $shipping_arr = array(

                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard® 4-7 days Working Days Service'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express® 2-4 Working Days Service'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide® 1-3 Working Days'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver® 1-4 Working Days Service'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00® Service'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00® Service'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => 'DHL Economy Select® 2-5 Working Days Service'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                }elseif($country_id == 250){
                    $shipping_arr = array(

                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => 'DHL Economy Select®'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                }elseif($country_id == 228){
                    $shipping_arr = array(

                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard®'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver®'
                        ),
                        array(
                            'method' => 'upsexpresspluszones',
                            'title' => 'UPS Express Plus Next Day 9:00®'
                        )
                    );
                } elseif($country_id == 73){
                    $shipping_arr = array(
                        array(
                            'method' => 'dhlezones',
                            'title' => 'DHL Express Worldwide®'
                        ),
                        array(
                            'method' => 'tntezones',
                            'title' => 'TNT Economy Express®'
                        ),
                        array(
                            'method' => 'dhleconomyzones',
                            'title' => 'DHL Economy Select®'
                        ),
                        array(
                            'method' => 'dhlexpresszones',
                            'title' => 'DHL Express 9:00®'
                        ),
                        array(
                            'method' => 'dhlexpressdzones',
                            'title' => 'DHL Express 12:00®'
                        ),
                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard®'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver®'
                        )
                    );
                } else {
                    $shipping_arr = array(

                            array(
                                'method' => 'upsstandardzones',
                                'title' => 'UPS Standard®'
                            ),
                            array(
                                'method' => 'tntezones',
                                'title' => 'TNT Economy Express®'
                            ),
                            array(
                                'method' => 'dhlezones',
                                'title' => 'DHL Express Worldwide®'
                            ),
                            array(
                                'method' => 'upssaverzones',
                                'title' => 'UPS Express Saver®'
                            ),
                            array(
                                'method' => 'dhlexpresszones',
                                'title' => 'DHL Express 9:00®'
                            ),
                            array(
                                'method' => 'dhlexpressdzones',
                                'title' => 'DHL Express 12:00®'
                            ),
                            array(
                                'method' => 'dhleconomyzones',
                                'title' => 'DHL Economy Select®'
                            ),
                            array(
                                'method' => 'upsexpresspluszones',
                                'title' => 'UPS Express Plus Next Day 9:00®'
                            )
                        );
                }
                if (!$is_show) {
                    foreach ($shipping_arr as $d => $l) {
                        if (in_array($l["method"], array("dhlexpresszones","dhlexpressdzones","upsexpresspluszones", "upsexpresszones"))) {
                            unset($shipping_arr[$d]);
                        }
                    }
                }
            } else {
                $shipping_arr = array(
                    array(
                        'method' => 'dhlzones',
                        'title' => 'DHL'
                    ),

                    array(
                        'method' => 'fedexzones',
                        'title' => 'FedEx IP'
                    ),
                    array(
                        'method' => 'airmailzones',
                        'title' => 'Airmail'
                    ),
                    array(
                        'method' => 'emszones',
                        'title' => 'EMS'
                    ),
                    array(
                        'method' => 'fedexiezones',
                        'title' => 'FedEx IE'
                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
                    ),
                    array(
                        'method' => 'airliftzones',
                        'title' => 'Airlift shipping'
                    ),
                    array(
                        'method' => 'seazones',
                        'title' => 'Sea shipping'
                    )
                );
            }
            if (!empty($limit)) {
                foreach ($shipping_arr as $k => $v) {
                    if (!in_array($v['method'], $limit)) {
                        unset($shipping_arr[$k]);
                    }
                }
            }
            break;
        case "AU":
            $shipping_arr = array(
                /*    array(
                        'method' => 'fastwaycourierzones',
                        'title' => 'Fastway Courier'
                    ),*/
                array(
                    'method' => 'startrackfzones',
                    'title' => 'StarTrack 1-5 Business Days'
                ),
                array(
                    'method' => 'startrackzones',
                    'title' => STARTRACK_PREMIUM_EXPRESS
                ),
                array(
                    'method' => 'tntauroadexpresszones',
                    'title' => TNT_ROAD_EXPRESS_1_4
                ),
                array(
                    'method' => 'dhlauzones',
                    'title' => DHL_EXPRESS_1_3
                ),
                array(
                    'method' => 'tntauovernightexpresszones',
                    'title' => 'TNT Overnight Express Service',
                    'description' => FS_SHIPPING_TNT_AU_INFO
                ),
            );
            if((2000<=$postcode && $postcode<=2234) || (3000<=$postcode && $postcode<=3005) || (3007<=$postcode && $postcode<=3009) || (3011<=$postcode && $postcode<=3031)
                || (3033<=$postcode && $postcode<=3049) || ($postcode == 3051) || (3055<=$postcode && $postcode<=3056) || (3058<=$postcode && $postcode<=3120)
                || (3123<=$postcode && $postcode<=3127) || (3129<=$postcode && $postcode<=3140) || (3143<=$postcode && $postcode<=3180) || (3182<=$postcode && $postcode<=3205)
                || (4000<=$postcode && $postcode<=4207) || (4300<=$postcode && $postcode<=4305)
                || (4500<=$postcode && $postcode<=4519) || (6000<=$postcode && $postcode<=6199)  || (5000<=$postcode && $postcode<=5199) || (800<=$postcode && $postcode<=832)
                || (2600<=$postcode && $postcode<=2609)){
                $shipping_arr[] =array(
                    'method' => 'tntauzones',
                    'title' => ' TNT 9:00 Express Service',
                    'description' => FS_SHIPPING_TNT_AU_INFO
                );
            }

            if (!empty($limit)) {
                foreach ($shipping_arr as $k => $v) {
                    if (!in_array($v['method'], $limit)) {
                        unset($shipping_arr[$k]);
                    }
                }
            }

            break;
        case "AU-NZ":
            $shipping_arr = array(
//                array(
//                    'method' => 'aupoststandardzones',
//                    'title' => 'Australia Post Standard'
//                ),
//                array(
//                    'method' => 'aupostexpresszones',
//                    'title' => 'Australia Post Express'
//                ),
                array(
                    'method' => 'dhlauexpressworldwidezones',
                    'title' => 'DHL Express Worldwide'
                ),
                array(
                    'method' => 'fedexaunormalzones',
                    'title' => 'FedEx Normal'
                ),
                array(
                    'method' => 'fedexauexpresszones',
                    'title' => 'FedEx Express'
                )
            );
            $local_money = $order->local_info['total']+$order->local_shipping_cost;
            $total_money = $currencies->fs_format_new($local_money,true,'AUD');
            if(intval($total_money) > 2000){
                $shipping_arr = array(
                    array(
                        'method' => 'dhlauexpressworldwidezones',
                        'title' => 'DHL Express Worldwide Service'
                    ),
                    array(
                        'method' => 'fedexaunormalzones',
                        'title' => 'FedEx Normal Service'
                    ),
                    array(
                        'method' => 'fedexauexpresszones',
                        'title' => 'FedEx Express Service'
                    )
                );
            }
            break;
        case "SG":
            if ($_SESSION['languages_id']) {
                if ($country_id == 188) {
                    $shipping_arr = array(
//                        array(
//                            'method' => 'simplyzones',
//                            'title' => FS_SG_SIMPLYPOST_SHIPPING
//                        ),
                        array(
                            'method' => 'ninjavanstandardzones',
                            'title' => 'Ninja Van 1-3 Working Days'
                        ),
                        array(
                            'method' => 'ninjavanovernightzones',
                            'title' => 'Ninja Van Next Working Day'
                        ),
                        array(
                            'method' => 'speedpoststandardzones',
                            'title' => 'Speedpost Standard 1 Working Day'
                        ),
//                        array(
//                            'method' => 'simplyovernightzones',
//                            'title' => 'SimplyPost Next Working Day'
//                        )
                    );

                    if (!in_array($local_day, ['Sat', 'Sun']) && $local_hour < 15 && $order_num == 1 && $order_tag == 'local' && $_SESSION['payment'] != 'hsbc') {
                        $shipping_arr[] = array(
                            'method' => 'grabexpresszones',
                            'title' => 'GrabExpress Same Day'
                        );
                    }

                } elseif ($country_id == 146 || $country_id == 116) {
                    $shipping_arr = array(
//                        array(
//                            'method' => 'upsexpressworldwidezones',
//                            'title' => 'UPS Worldwide Express 1-3 Working Days'
//                        ),
                        array(
                            'method' => 'dhlsexpresszones',
                            'title' => 'DHL World Express 1-3 Working Days'
                        )
                    );
                } else {
                    $shipping_arr = array(
//                        array(
//                            'method' => 'fedexsgiezones',
//                            'title' => 'FedEx IE 4-6 Working Days'
//                        ),
                        array(
                            'method' => 'fedexsgzones',
                            'title' => 'FedEx IP 1-3 Working Days'
                        ),
                        array(
                            'method' => 'dhlsexpresszones',
                            'title' => 'DHL World Express 1-3 Working Days'
                        )
                    );
                }
            }
            break;
        case "RU":
            $shipping_arr = array(
                array(
                    'method' => 'courierzones',
                    'title' => SHIPPING_COURIER_DELIVERY
                ),
            );
            break;
        case "WH":
            $is_hidden = false;
            if ($country_id == 176 && $company_type == "IndividualType") {
                $is_hidden = true;
            }
            $is_br_hidden = false;
            if($country_id == 30 && in_array($order->delivery['postcode'] ,array('89618000'))){
                $is_br_hidden = true;
            }
            if ($_SESSION['languages_id'] == 1) {
                $shipping_arr = array(
                    array(
                        'method' => 'fedexzones',
                        'title' => 'FedEx IP'
                    ),

                    array(
                        'method' => 'dhlzones',
                        'title' => 'DHL'
                    ),

                    array(
                        'method' => 'airmailzones',
                        'title' => 'Airmail'
                    ),
                    array(
                        'method' => 'emszones',
                        'title' => 'EMS'
                    ),
//                    array(
//                        'method' => 'fedexiezones',
//                        'title' => 'FedEx IE'
//                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
                    ),
                    array(
                        'method' => 'airliftzones',
                        'title' => 'Airlift shipping'
                    ),
                    array(
                        'method' => 'seazones',
                        'title' => 'Sea shipping'
                    )
                );
                if (in_array($country_id, array(96, 125, 206))) {
                    $shipping_arr = array(
//                        array(
//                            'method' => 'fedexiezones',
//                            'title' => 'FedEx IE'
//                        ),
                        array(
                            'method' => 'fedexzones',
                            'title' => 'FedEx IP'
                        ),

                        array(
                            'method' => 'dhlzones',
                            'title' => 'DHL'
                        ),

                        array(
                            'method' => 'airmailzones',
                            'title' => 'Airmail'
                        ),
                        array(
                            'method' => 'emszones',
                            'title' => 'EMS'
                        ),
                        array(
                            'method' => 'upszones',
                            'title' => 'UPS'
                        ),
                        array(
                            'method' => 'airliftzones',
                            'title' => 'Airlift shipping'
                        ),
                        array(
                            'method' => 'seazones',
                            'title' => 'Sea shipping'
                        )
                    );
                }


            } else {
                $shipping_arr = array(
                    array(
                        'method' => 'dhlzones',
                        'title' => 'DHL'
                    ),

                    array(
                        'method' => 'fedexzones',
                        'title' => 'FedEx IP'
                    ),
                    array(
                        'method' => 'airmailzones',
                        'title' => 'Airmail'
                    ),
                    array(
                        'method' => 'emszones',
                        'title' => 'EMS'
                    ),
//                    array(
//                        'method' => 'fedexiezones',
//                        'title' => 'FedEx IE'
//                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
                    ),
                    array(
                        'method' => 'airliftzones',
                        'title' => 'Airlift shipping'
                    ),
                    array(
                        'method' => 'seazones',
                        'title' => 'Sea shipping'
                    )
                );
            }
			if ($is_hidden) {
				foreach ($shipping_arr as $d => $l) {
					if (in_array($l["method"], array("dhlzones", "fedexzones", "fedexiezones","upszones"))) {
						unset($shipping_arr[$d]);
					}
				}
			}
			if($is_br_hidden){
                foreach ($shipping_arr as $d => $l) {
                    if (in_array($l["method"], array("fedexzones", "fedexiezones", "upszones"))) {
                        unset($shipping_arr[$d]);
                    }
                }
            }
            break;
        default:
            $shipping_arr = array(
                array(
                    'method' => 'dhlzones',
                    'title' => 'DHL'
                ),

                array(
                    'method' => 'fedexzones',
                    'title' => 'FedEx IP'
                ),
                array(
                    'method' => 'airmailzones',
                    'title' => 'Airmail'
                ),
                array(
                    'method' => 'emszones',
                    'title' => 'EMS'
                ),
                array(
                    'method' => 'fedexiezones',
                    'title' => 'FedEx IE'
                ),
                array(
                    'method' => 'upszones',
                    'title' => 'UPS'
                ),
                array(
                    'method' => 'airliftzones',
                    'title' => 'Airlift shipping'
                ),
                array(
                    'method' => 'seazones',
                    'title' => 'Sea shipping'
                )
            );
    }
    if ($country_id == 44) {
        $shipping_arr = array(
            array(
                'method' => 'sfzones',
                'title' => 'SF Express'
            ),
            array(
                'method' => 'emszones',
                'title' => 'EMS'
            )
        );
    }
    if($country_id == 176){
        if($company_type == "BusinessType"){
            $shipping_arr = array(
                array(
                    'method' => 'courierzones',
                    'title' => SHIPPING_COURIER_DELIVERY
                ),
            );
        }else{
            $shipping_arr = array(
                array(
                    'method' => 'emszones',
                    'title' => 'EMS'
                ),
                array(
                    'method' => 'upszones',
                    'title' => 'UPS'
                )
            );
//            $shipping_arr[] =  array(
//                'method' => 'courierzones',
//                'title' => SHIPPING_COURIER_DELIVERY
//            );
        }
    }
    $data = array();
    if(($shipping_warehouse == "WH") && in_array($country_id,array(100,168,129))){
        $shipping_arr[] = array(
            'method' => 'forwarderzones',
            'title' => FS_FORWARD_SHIPPING,
            'description' => FS_FORWARD_SHIPPING_NOTICE
        );
    }
    if (($shipping_warehouse == "DE") && in_array($country_id, array(81, 73, 222, 21, 72, 195, 57, 105, 171, 56, 150, 14, 204))) {

        if (($local_day == 'Fri'&& $local_hour < 16) || ($local_day == 'Thu' && $local_hour>16)) {

            $f_day = $local_day == 'Thu' ? 1 : 0;
            $check_festival = get_festival_day($country_code,$f_day);//周五为节假日不出现周六达

            if($check_festival == 0 && $order_data == 'local') {
                $shipping_arr[] = array(
                    'method' => 'dhlsaturdayzones',
                    'title' => 'DHL Saturday Delivery'
                );
            }
        }
    }
    if (($shipping_warehouse == "US" || $shipping_warehouse == "US-ES") && !in_array($country_id, array(138, 38)) && !$order->local_cabinet) {
        $state_no_sat = array('HI', 'RI', 'AP', 'VI', 'PR', 'AE', 'AP', 'AA', 'AK');//无法周六达的州
        if ((($local_day == 'Fri'&& $local_hour < 16) || ($local_day == 'Thu' && $local_hour>17)) && !in_array($states_code,$state_no_sat)) {

            $f_day = $local_day == 'Thu' ? 1 : 0;
            $check_festival = get_festival_day($country_code,$f_day);//周五为节假日不出现周六达

            if($check_festival == 0) {
                $shipping_arr[] = array(
                    'method' => 'saturdaydeliveryzones',
                    'title' => 'Saturday Delivery'
                );
            }
        }
    }
    if (((in_array($shipping_warehouse, array("US", "US-ES")) && $country_id == 223) || (german_warehouse("country_number",$country_id) && !in_array($country_id, [253,254])) || $order->is_ireland_zones || in_array($shipping_warehouse,array("AU", "AU-NZ")) || $country_id == 188) && $warehouse != "WH" && $is_self_lifting) {
        $shipping_arr[] = array(
            'method' => 'selfreferencezones',
            'title' => FS_PICK_UP_AT_WAREHOUSE
        );
    }
    if($country_id != 176  || $company_type != "BusinessType"){
        $shipping_arr[] = array(
            'method' => 'customzones',
            'title' => FIBER_CHECK_USE
        );
    }
    foreach ($shipping_arr as $v){
        $data["file"][] = $v['method'].".php";
    }

    $data['shipping_arr'] = $shipping_arr;
    $data['warehouse'] = $shipping_warehouse;
    return $data;
}

/**
 * @param $order order 类
 * @return bool
 * 判断所有产品中是否有重货
 */
function is_buck_in_all_products($order){
    if(empty($order) || !is_object($order)){
        return false;
    }
    $local_products = $order->local_info['products_arr'];
    $delay_products =  $order->delay_info['products_arr'];
    $global_products = $order->global_info['products_arr'];
    $product_combine = array_merge($local_products,$delay_products);
    if(in_array($order->local_warehouse,array(3,40)) && !empty($global_products)){
        $product_combine = array_merge($product_combine,$global_products);
    }
    $status = $order->fs_is_bulk_fiber($product_combine);
    return $status;
}

/**
 * @param $products
 * @return bool
 * 判断产品是否是带电磁货
 */
function is_electromagnetism($products)
{
    if (empty($products)) {
        return false;
    }
    $electromagnetism_id = array(66915, 39214, 70413, 13292, 68428, 49652,
        34153, 34154, 68427, 13975, 26694, 12601, 73643, 72764, 51611, 29127, 51610,
        15390, 39701, 14121, 11404, 21145, 70221, 70402, 14341, 71448, 51607, 11405, 23069, 70220, 42450);
    $cate = array(889, 56, 57, 58, 2757, 2758, 1668, 136, 141,  2845, 1073);
    foreach ($products as $v) {
        if (in_array($v, $electromagnetism_id)) {
            return true;
            break;
        }
    }
    foreach ($products as $v){
        foreach ($cate as $c) {
            if (zen_product_in_category($v, $c)) {
                return true;
                break 2;
            }
        }
    }
    return false;
}

/**
 * forwarder shipping 西马来西亚 运费计算 计量单位RMB
 *
 *
 * @param $weight
 * @param $total
 * @param $isElec
 * @return
 */
function forwarderWestMy($weight, $total,$isElec){
    $weight = (string)$weight ? $weight : 0;
    $total = (string)$total ? $total : 0;
    $isElec = (bool)$isElec;
    $ceilWeight = ceil($weight / 0.5);
    if ($isElec){
        if ($weight <= 0.5) {
            $cost = 105;
        } elseif ($weight <= 6) {
            $cost = 87 + $ceilWeight * 18;
        } elseif ($weight <= 11) {
            $cost = 297;
        } elseif ($weight <= 500) {
            $cost = 13.5 * $ceilWeight;
        }  else {
            $cost = 13 * $ceilWeight;
        }
    }else{
        if ($weight <= 0.5) {
            $cost = 90;
        } elseif ($weight <= 5) {
            $cost = 74 + $ceilWeight * 16;
        } elseif ($weight <= 11) {
            $cost = 242;
        } elseif ($weight <= 45) {
            $cost = 11 * $ceilWeight;
        } elseif ($weight <= 500) {
            $cost = 10.5 * $ceilWeight;
        } elseif ($weight <= 1000) {
            $cost = 10 * $ceilWeight;
        } else {
            $cost = 9.5 * $ceilWeight;
        }
    }
    if ($weight < 45){
        $cost += $total * 0.2;
        if ($cost >= 990){
            $cost = 990;
        }
    }
    $limitExtra = $total * 0.005 * 1.1;
    if ($limitExtra < 15) {
        $limitExtra = 15;
    }
    $cost += 340 + $limitExtra;
    if ($isElec){
        $cost += 260;
    }
    return $cost;
}
/**
 * 获取运费小提示
 */
function get_shipping_notice($notice){
    return "";
    $html = '<div style="padding-left: 5px" class="track_orders_wenhao"> <div class="question_bg"></div> <div class="question_text_01 leftjt"> 
    <div class="arrow"></div> <div class="popover-content">'.$notice.'<p></p> </div> </div> </div>';
    return $html;
}

/**
 * 根据当前产品，获取德国仓重货 发货方式
 *
 * @param $weight //重量
 * @param object $order order类
 * @param string $tag 当前订单发货标记
 * @return array
 */
function getDELimit($order, $weight, $tag = '')
{
    $limit = [];
    $country_id = $order->delivery['country_id'];
    if ($country_id == 13 && $tag == 'delay' && $order->is_buck) {
        $limit = ['tntauroadexpresszones'];
    } else {
        switch ($tag) {
            case 'local':
                $isLimit = $weight < 30 && !$order->is_local_oversize; // 订单中包含重货，但是重货单品都未超重或者未超尺寸：
                if ($order->is_local_buck) {
                    if (!$isLimit) {
                        $limit = ['upsstandardzones', 'upssaverzones'];
                    }
                    if ($weight > 70) {
                        $limit = ['upssaverzones'];
                    }elseif ($country_id == 73){//法国单独设置dhleconomyzones物流
                        $limit = ['dhleconomyzones'];
                    }
                }
                if ($order->is_local_oversize) {
                    if ($weight > 70) {
                        $limit = ['upssaverzones'];
                    }elseif ($country_id == 73){
                        $limit = ['upsstandardzones'];
                    }
                }
                break;
            case 'delay':
                $weight = $order->delay_info['total_weight'];
                $isLimit = $weight < 30 && !$order->is_delay_oversize; // 订单中包含重货，但是重货单品都未超重或者未超尺寸：
                if ($order->is_buck) {
                    if (!$isLimit) {
                        $limit = ['upsstandardzones', 'upssaverzones'];
                    }
                    if ($weight > 70) {
                        $limit = ['upssaverzones'];
                    }elseif ($country_id == 73){//法国单独设置dhleconomyzones物流
                        $limit = ['dhleconomyzones'];
                    }
                }
                if ($order->is_delay_oversize) {
                    if ($weight > 70) {
                        $limit = ['upssaverzones'];
                    }elseif ($country_id == 73){
                        $limit = ['upsstandardzones'];
                    }
                }
                if (in_array(73579, $order->delay_info['products_arr']) ||
                    in_array(73958, $order->delay_info['products_arr'])) {
                    $limit = ['upssaverzones'];
                }
                break;
        }

    }

    return $limit;
}

/**
 * 根据仓库 调取所有分单运费
 * gift 单不算运费,免运费
 * 美国 德国才会有gift 订单
 *
 * @author  aron
 * @date 2019.7.11
 * @return array
 */

function getAllShippingData()
{
    require_once DIR_WS_CLASSES . 'shipping.php';
    global $order;
    $warehouse = $order->local_warehouse;
    $order_info = $order->get_order_num();
    $order_num = $order_info['num'];
    $order_tag = $order_info['data'];
    $origin_order_tag = $order_tag;
    $country_id = $order->delivery['country_id'];
    $state = $order->delivery['state'];
    $shipping_data = [];
    $total_weight = 0;
    $order_tag_one =  ['local-gift'=>'local','delay-gift'=>'delay','global-gift'=>'global'];
    $order_tag_two = ['local-delay-gift'=>'local-delay','local-global-gift'=>'local-global','delay-global-gift'=>'delay-global'];

    switch ($warehouse) {
        //美东仓
        case 40:
            if ($order_num == 1 || isset($order_tag_one[$order_tag])) {
                $buck_weight = 0;
                $is_shipping_free = false;
                if(isset($order_tag_one[$order_tag])){
                    $order_tag = $order_tag_one[$order_tag];
                }
                //1单情况
                switch ($order_tag) {
                    case "local":
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        $shipping_warehouse = "US-ES";
                        break;
                    case "delay":
                        $total_weight = $order->delay_info['total_weight'];
                        $buck_weight = $order->delay_info['buck_weight'];
                        $is_shipping_free = $order->delay_info['is_shipping_free'];
                        $shipping_warehouse = "WH";
                        break;
                    case "global":
                        $total_weight = $order->global_info['total_weight'];
                        $shipping_warehouse = "WH";
                        break;
                    default:
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        $shipping_warehouse = "US-ES";
                }
                $GLOBALS['separated_weight'] = $buck_weight != 0 && $is_shipping_free ? $buck_weight : $total_weight;
                $GLOBALS['total_weight'] = $total_weight;
                $shippingList = getShippingList($shipping_warehouse);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','',$order_tag);
                $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            } elseif ($order_num == 2 || isset($order_tag_two[$order_tag])) {
                //2单情况
                if(isset($order_tag_two[$order_tag])){
                    $order_tag = $order_tag_two[$order_tag];
                }
                switch ($order_tag) {
                    case "local-delay":
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                        $shipping_warehouse = "US-ES";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                        $GLOBALS['separated_weight'] = $order->is_buck && $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','delay');;
                        $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        break;
                    case "local-global":
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                        $shipping_warehouse = "US-ES";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $total_weight = $order->global_info['total_weight'];
                        $GLOBALS['total_weight'] = $total_weight;
                        $GLOBALS['separated_weight'] = $total_weight;
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','global');
                        $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        break;
                    case "delay-global":
                        $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                        $delay_weight = $order->delay_info['is_shipping_free'] ? ($order->is_buck ? $order->delay_info['buck_weight'] : 0) : $order->delay_info['total_weight'];
                        $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                        $separated_weight = $delay_weight + $global_weight;
                        $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                        $GLOBALS['total_weight'] = $total_weight;
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','delay-global');
                        $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        break;
                }

            } else {
                //3单情况
                $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                $shipping_warehouse = "US-ES";
                $shippingList = getShippingList($shipping_warehouse);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','','local');
                $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                $delay_weight = $order->delay_info['is_shipping_free'] ? ($order->is_buck ? $order->delay_info['buck_weight'] : 0) : $order->delay_info['total_weight'];
                $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                $separated_weight = $delay_weight + $global_weight;
                $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                $GLOBALS['total_weight'] = $total_weight;
                $shipping_warehouse = "WH";
                $shippingList = getShippingList($shipping_warehouse);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','','delay-global');
                $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            }
            break;
        //德国仓
        case 20:
            //1单情况
            if ($order_num == 1 || isset($order_tag_one[$order_tag])) {
                //1单情况
                $buck_weight = 0;
                $is_shipping_free = false;
                if(isset($order_tag_one[$order_tag])){
                    $order_tag = $order_tag_one[$order_tag];
                }
                switch ($order_tag) {
                    case "local":
                        $shipping_warehouse = "DE";
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        break;
                    case "delay":
                        $shipping_warehouse = "DE";
                        $total_weight = $order->delay_info['total_weight'];
                        $buck_weight = $order->delay_info['buck_weight'];
                        $is_shipping_free = $order->delay_info['is_shipping_free'];
                        break;
                    case "global":
                        $total_weight = $order->global_info['total_weight'];
                        $shipping_warehouse = "WH";
                        break;
                    default:
                        $shipping_warehouse = "DE";
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->delay_info['is_shipping_free'];
                }

                $GLOBALS['separated_weight'] = $buck_weight != 0 && $is_shipping_free ? $buck_weight : $total_weight;
                $GLOBALS['total_weight'] = $total_weight;
                $limit = getDELimit($order, $GLOBALS['separated_weight'], $order_tag);
                $shippingList = getShippingList($shipping_warehouse, $limit);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','',$order_tag);
                if(!empty($quotes['upsstandardzones']) && !empty($limit)){
                    unset($quotes['upssaverzones']);
                }
                $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            } elseif ($order_num == 2 || isset($order_tag_two[$order_tag])) {
                if(isset($order_tag_two[$order_tag])){
                    $order_tag = $order_tag_two[$order_tag];
                }
                switch ($order_tag) {
                    case "local-delay":
                        if ($order->is_buck) {
                            $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                            $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                            $shipping_warehouse = "DE";
                            $limit = getDELimit($order, $GLOBALS['separated_weight'], 'local');
                            $shippingList = getShippingList($shipping_warehouse, $limit);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','local');
                            if(!empty($quotes['upsstandardzones']) && !empty($limit)){
                                unset($quotes['upssaverzones']);
                            }
                            $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                            $GLOBALS['separated_weight'] = $order->is_buck && $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                            $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                            $shipping_warehouse = "DE";
                            $limit = getDELimit($order, $GLOBALS['separated_weight'], 'delay');
                            $shippingList = getShippingList($shipping_warehouse, $limit);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','delay');
                            if(!empty($quotes['upsstandardzones']) && !empty($limit)){
                                unset($quotes['upssaverzones']);
                            }
                            $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        } else {
                            $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : ($order->local_info['total_weight'] + $order->delay_info['total_weight']);
                            $GLOBALS['total_weight'] = $order->local_info['total_weight'] + $order->delay_info['total_weight'];
                            $shipping_warehouse = "DE";
                            $limit = getDELimit($order, $GLOBALS['separated_weight'], 'local');
                            $shippingList = getShippingList($shipping_warehouse, $limit);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','local');
                            if(!empty($quotes['upsstandardzones']) && !empty($limit)){
                                unset($quotes['upssaverzones']);
                            }
                            $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        }
                        break;
                    case "local-global":
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                        $shipping_warehouse = "DE";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $total_weight = $order->global_info['total_weight'];
                        $GLOBALS['separated_weight'] = $total_weight;
                        $GLOBALS['total_weight'] = $total_weight;
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','global');
                        $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        break;
                    case "delay-global":
                        if ($order->is_buck) {
                            $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                            $delay_weight = $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                            $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                            $separated_weight = $delay_weight + $global_weight;
                            $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                            $GLOBALS['total_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','delay-global');
                            $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        } else {
                            $GLOBALS['separated_weight'] = $order->delay_info['total_weight'];
                            $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                            $shipping_warehouse = "DE";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','delay');
                            $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                            $total_weight = $order->global_info['total_weight'];
                            $GLOBALS['separated_weight'] = $total_weight;
                            $GLOBALS['total_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','global');
                            $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        }
                        break;
                }
            } else {
                //生成3单
                if ($order->is_buck) {
                    $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                    $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                    $shipping_warehouse = "DE";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','local');
                    $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                    $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                    $delay_weight = $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                    $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                    $separated_weight = $delay_weight + $global_weight;
                    $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                    $GLOBALS['total_weight'] = $total_weight;
                    $shipping_warehouse = "WH";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','delay-global');
                    $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                } else {
                    $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : ($order->local_info['total_weight'] + $order->delay_info['total_weight']);
                    $GLOBALS['total_weight'] = $order->local_info['total_weight'] + $order->delay_info['total_weight'];
                    $shipping_warehouse = "DE";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','local');
                    $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                    $total_weight = $order->global_info['total_weight'];
                    $GLOBALS['total_weight'] = $total_weight;
                    $GLOBALS['separated_weight'] = $total_weight;
                    $shipping_warehouse = "WH";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','global');
                    $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                }
            }
            break;
        //澳大利亚仓
        case 37:
            //国家为新西兰
            if ($country_id == 153) {
                if ($order_num == 1) {
                    //1单情况
                    switch ($order_tag) {
                        case "local":
                            $shipping_warehouse = "AU-NZ";
                            $total_weight = $order->local_info['total_weight'];
                            break;
                        case "delay":
                            $shipping_warehouse = "WH";
                            $total_weight = $order->delay_info['total_weight'];
                            break;
                        case "global":
                            $shipping_warehouse = "WH";
                            $total_weight = $order->global_info['total_weight'];
                            break;
                        default:
                            $shipping_warehouse = "AU-NZ";
                    }
                    $GLOBALS['total_weight'] = $total_weight;
                    $GLOBALS['separated_weight'] = $total_weight;
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote();
                    $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                } elseif ($order_num == 2) {
                    //2单情况
                    switch ($order_tag) {
                        case "local-delay":
                            $total_weight = $order->local_info['total_weight'];
                            $GLOBALS['total_weight'] = $total_weight;
                            $GLOBALS['separated_weight'] = $total_weight;
                            $shipping_warehouse = "AU-NZ";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote();
                            $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                            $total_weight = $order->delay_info['total_weight'];
                            $GLOBALS['total_weight'] = $total_weight;
                            $GLOBALS['separated_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote();
                            $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            break;
                        case "local-global":
                            $total_weight = $order->local_info['total_weight'];
                            $GLOBALS['total_weight'] = $total_weight;
                            $GLOBALS['separated_weight'] = $total_weight;
                            $shipping_warehouse = "AU-NZ";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote();
                            $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);


                            $total_weight = $order->global_info['total_weight'];
                            $GLOBALS['total_weight'] = $total_weight;
                            $GLOBALS['separated_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote();
                            $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            break;
                        case "delay-global":
                            $total_weight = $order->delay_info['total_weight'] + $order->global_info['total_weight'];
                            $GLOBALS['total_weight'] = $total_weight;
                            $GLOBALS['separated_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote();
                            $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            break;
                    }

                } else {
                    //3单情况
                    $total_weight = $order->local_info['total_weight'];
                    $GLOBALS['total_weight'] = $total_weight;
                    $GLOBALS['separated_weight'] = $total_weight;
                    $shipping_warehouse = "AU-NZ";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote();
                    $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                    $total_weight = $order->delay_info['total_weight'] + $order->global_info['total_weight'];
                    $GLOBALS['total_weight'] = $total_weight;
                    $GLOBALS['separated_weight'] = $total_weight;
                    $shipping_warehouse = "WH";
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote();
                    $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                }
            } else {
                //1单情况
                if ($order_num == 1) {
                    //1单情况
                    $buck_weight = 0;
                    $is_shipping_free = false;
                    $is_trans = false;
                    switch ($order_tag) {
                        case "local":
                            $total_weight = $order->local_info['total_weight'];
                            $buck_weight = $order->local_info['buck_weight'];
                            $is_shipping_free = $order->local_info['is_shipping_free'];
                            $shipping_warehouse = "AU";
                            break;
                        case "delay":
                            $total_weight = $order->delay_info['total_weight'];
                            $shipping_warehouse = "AU";
                            $buck_weight = $order->delay_info['buck_weight'];
                            $is_shipping_free = $order->delay_info['is_shipping_free'];
                            break;
                        case "global":
                            $total_weight = $order->global_info['total_weight'];
                            $shipping_warehouse = "WH";
                            break;
                        default:
                            $total_weight = $order->local_info['total_weight'];
                            $shipping_warehouse = "AU";
                            $buck_weight = $order->local_info['buck_weight'];
                            $is_shipping_free = $order->local_info['is_shipping_free'];
                    }
                    $GLOBALS['separated_weight'] = $buck_weight != 0 && $is_shipping_free ? $buck_weight : $total_weight;
                    $GLOBALS['total_weight'] = $total_weight;
                    $limit = getDELimit($order, $GLOBALS['separated_weight'], $order_tag);
                    $shippingList = getShippingList($shipping_warehouse, $limit);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','',$order_tag);
                    $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                } elseif ($order_num == 2) {
                    switch ($order_tag) {
                        case "local-delay":
                            if ($order->is_buck) {
                                $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                                $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                                $shipping_warehouse = "AU";
                                $shippingList = getShippingList($shipping_warehouse);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','local');
                                $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                                $GLOBALS['separated_weight'] = $order->is_buck && $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                                $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                                $shipping_warehouse = "AU";
                                $limit = getDELimit($order, $GLOBALS['separated_weight'], 'delay');
                                $shippingList = getShippingList($shipping_warehouse, $limit);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','delay');
                                $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            } else {
                                $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : ($order->local_info['total_weight'] + $order->delay_info['total_weight']);
                                $GLOBALS['total_weight'] = $order->local_info['total_weight'] + $order->delay_info['total_weight'];
                                $shipping_warehouse = "AU";
                                $shippingList = getShippingList($shipping_warehouse);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','local');
                                $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            }
                            break;
                        case "local-global":
                            $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                            $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                            $shipping_warehouse = "AU";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','local');
                            $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);


                            $total_weight = $order->global_info['total_weight'];
                            $GLOBALS['separated_weight'] = $total_weight;
                            $GLOBALS['total_weight'] = $total_weight;
                            $shipping_warehouse = "WH";
                            $shippingList = getShippingList($shipping_warehouse);
                            $shipping = new shipping("",$shippingList);
                            $quotes = $shipping->quote('','','','global');
                            $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            break;
                        case "delay-global":
                            if ($order->is_buck) {
                                $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                                $delay_weight = $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                                $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                                $separated_weight = $delay_weight + $global_weight;
                                $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                                $GLOBALS['total_weight'] = $total_weight;
                                $shipping_warehouse = "WH";
                                $shippingList = getShippingList($shipping_warehouse);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','delay-global');
                                $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            } else {
                                $GLOBALS['separated_weight'] = $order->delay_info['total_weight'];
                                $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                                $shipping_warehouse = "AU";
                                $shippingList = getShippingList($shipping_warehouse);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','delay');
                                $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                                $total_weight = $order->global_info['total_weight'];
                                $GLOBALS['separated_weight'] = $total_weight;
                                $GLOBALS['total_weight'] = $total_weight;
                                $shipping_warehouse = "WH";
                                $shippingList = getShippingList($shipping_warehouse);
                                $shipping = new shipping("",$shippingList);
                                $quotes = $shipping->quote('','','','global');
                                $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                            }
                            break;
                    }
                }else{
                    //生成3单
                    if ($order->is_buck) {
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                        $shipping_warehouse = "AU";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'];
                        $delay_weight = $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                        $global_weight = $order->global_info['is_shipping_free'] ? 0 : $order->global_info['total_weight'];
                        $separated_weight = $delay_weight + $global_weight;
                        $GLOBALS['separated_weight'] =  $separated_weight == 0 ? $total_weight : $separated_weight;
                        $GLOBALS['total_weight'] = $total_weight;
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','delay-global');
                        $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                    } else {
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : ($order->local_info['total_weight'] + $order->delay_info['total_weight']);
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'] + $order->delay_info['total_weight'];
                        $shipping_warehouse = "AU";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $total_weight = $order->global_info['total_weight'];
                        $GLOBALS['total_weight'] = $total_weight;
                        $GLOBALS['separated_weight'] = $total_weight;
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','global');
                        $shipping_data['global'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                    }
                }
            }
            break;
        //新加坡仓
        case 71:
            if ($order_num == 1 || isset($order_tag_one[$order_tag])) {
                $buck_weight = 0;
                $is_shipping_free = false;
                if(isset($order_tag_one[$order_tag])){
                    $order_tag = $order_tag_one[$order_tag];
                }
                //1单情况
                switch ($order_tag) {
                    case "local":
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        $shipping_warehouse = "SG";
                        break;
                    case "delay":
                        $total_weight = $order->delay_info['total_weight'];
                        $buck_weight = $order->delay_info['buck_weight'];
                        $is_shipping_free = $order->delay_info['is_shipping_free'];
                        $shipping_warehouse = "WH";
                        break;
                    default:
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        $shipping_warehouse = "SG";
                }
                $GLOBALS['separated_weight'] = $buck_weight != 0 && $is_shipping_free ? $buck_weight : $total_weight;
                $GLOBALS['total_weight'] = $total_weight;
                $shippingList = getShippingList($shipping_warehouse);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','',$order_tag);
                $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            } elseif ($order_num == 2 || isset($order_tag_two[$order_tag])) {
                //2单情况
                if(isset($order_tag_two[$order_tag])){
                    $order_tag = $order_tag_two[$order_tag];
                }

                switch ($order_tag) {
                    case "local-delay":
                        $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                        $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                        $shipping_warehouse = "SG";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','local');
                        $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                        $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                        $GLOBALS['separated_weight'] = $order->is_buck && $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                        $shipping_warehouse = "WH";
                        $shippingList = getShippingList($shipping_warehouse);
                        $shipping = new shipping("",$shippingList);
                        $quotes = $shipping->quote('','','','delay');;
                        $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                        break;
                }

            }
            break;
        case 67:
            //1单情况
            if ($order_num == 1) {
                //1单情况
                switch ($order_tag) {
                    case "local":
                        $total_weight = $order->local_info['total_weight'];
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                        $shipping_warehouse = 'RU';
                        break;
                    case "delay":
                        $total_weight = $order->delay_info['total_weight'];
                        $shipping_warehouse = 'RU';
                        $buck_weight = $order->delay_info['buck_weight'];
                        $is_shipping_free = $order->delay_info['is_shipping_free'];
                        break;
                    default:
                        $total_weight = $order->local_info['total_weight'];
                        $shipping_warehouse = 'RU';
                        $buck_weight = $order->local_info['buck_weight'];
                        $is_shipping_free = $order->local_info['is_shipping_free'];
                }
                $GLOBALS['separated_weight'] = $buck_weight != 0 && $is_shipping_free ? $buck_weight : $total_weight;
                $GLOBALS['total_weight'] = $total_weight;
                $shippingList = getShippingList($shipping_warehouse);
                $shipping = new shipping("",$shippingList);
                $quotes = $shipping->quote('','','',$order_tag);
                $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            }elseif ($order_num == 2){
                if ($order->is_buck) {
                    $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : $order->local_info['total_weight'];
                    $GLOBALS['total_weight'] = $order->local_info['total_weight'];
                    $shipping_warehouse = 'RU';
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','local');
                    $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);

                    $GLOBALS['separated_weight'] = $order->is_buck && $order->delay_info['is_shipping_free'] ? $order->delay_info['buck_weight'] : $order->delay_info['total_weight'];
                    $GLOBALS['total_weight'] = $order->delay_info['total_weight'];
                    $shipping_warehouse = 'RU';
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','delay');
                    $shipping_data['delay'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                } else {
                    $GLOBALS['separated_weight'] = $order->is_local_buck && $order->local_info['is_shipping_free'] ? $order->local_info['buck_weight'] : ($order->local_info['total_weight'] + $order->delay_info['total_weight']);
                    $GLOBALS['total_weight'] = $order->local_info['total_weight'] + $order->delay_info['total_weight'];
                    $shipping_warehouse = 'RU';
                    $shippingList = getShippingList($shipping_warehouse);
                    $shipping = new shipping("",$shippingList);
                    $quotes = $shipping->quote('','','','local');
                    $shipping_data['local'] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
                }
            }
            break;
        //中国仓
        case 2:
            $total_weight = $order->global_info['total_weight'] + $order->delay_info['total_weight'] + $order->local_info['total_weight'];
            $GLOBALS['total_weight'] = $total_weight;
            $GLOBALS['separated_weight'] = $total_weight;
            $shipping_warehouse = "WH";
            $shippingList = getShippingList($shipping_warehouse);
            $shipping = new shipping("",$shippingList);
            $quotes = $shipping->quote();
            if ($order_num == 2) {
                switch ($order_tag){
                    case "local-delay":
                        $order_tag = "local";
                        break;
                    case "local-global":
                        $order_tag = "local";
                        break;
                    case "delay-global":
                        $order_tag = "delay";
                        break;
                }
            }elseif ($order_num == 3){
                $order_tag = "local";
            }
            $shipping_data[$order_tag] = get_shipping_cost($shipping_warehouse, $state, $country_id, $quotes);
            break;
    }
    if(isset($origin_order_tag)){
        if($origin_order_tag == "gift"){
            $shipping_data['gift'] = get_shipping_cost($shipping_warehouse, $state, $country_id, [],[],'gift');
        }else{
            $last_element = array_pop(explode("-",$origin_order_tag));
            if($last_element == "gift"){
                $shipping_data['gift'] = get_shipping_cost($shipping_warehouse, $state, $country_id, [],[],'gift');
            }
        }
    }
    return $shipping_data;
}



/**
 * 定制产品属性交期调取
 * @param $pid
 * @param $attr_arr
 * @param $length
 * @return int|mixed
 */
function get_custom_products_attr_days($pid,$attr_arr=array(),$length="",$qty="",$is_add=true,$cn_qty=0){
    global $db;
    $days = 0;
    if($pid) {
        $basics_days = fs_get_data_from_db_fields_array(array('basics_days', 'length', 'qty'), 'customized_attribute_delivery_time', 'products_id=' . (int)$pid, 'limit 1');
        $days = $basics_days[0][0] ? $basics_days[0][0] : 0;
        $add_max_days = $minus_min_days = 0;    //不独立属性+交期的最大天数 / -交期的最小天数
        //获取属性对应的交期
        if(!empty($attr_arr)){
            $rst = $db->getAll('select `attr_days`,`is_independent`,`days_prefix` from customized_attribute_delivery_time where products_id=' . (int)$pid . ' and attr_value_id in(' . join(',', $attr_arr) . ')');
            //产品属性交期
            if (sizeof($rst)) {
                foreach ($rst as $value) {
                    if ($value['is_independent'] == 1) {
                        if ($value['days_prefix'] == '+') {
                            //加交期的最大天数
                            if ($value['attr_days'] > $add_max_days) {
                                $add_max_days = $value['attr_days'];
                            }
                        } else {
                            //减交期的最小天数
                            if ($minus_min_days == 0) {
                                $minus_min_days = $value['attr_days'];
                            } elseif ($value['attr_days'] < $minus_min_days) {
                                $minus_min_days = $value['attr_days'];
                            }
                        }
                    } else {
                        if ($value['days_prefix'] == '+') {
                            $days += $value['attr_days'];
                        } else {
                            $days -= $value['attr_days'];
                        }
                    }
                }
            }
        }
        $customized_length_day = 0;
        $customized_qty_day = 0;
        $ship_day = 0;
        if($is_add && $days){
            $country_iso_code = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
            if(all_german_warehouse("country_code",$country_iso_code) || in_array($country_iso_code,array('AU'))){
                if($cn_qty){
                    $ship_day = 7;//转运时间(本地仓无库存,武汉仓无库存加5天)
                }else{
                    $ship_day = 5;//转运时间(本地仓无库存,武汉仓有库存加7天)
                }
            }
        }
        //长度属性交期
        if($basics_days[0][1] && $length){
            $length = str_replace('m','',$length);
            $length_days = $basics_days[0][1];
            if(strpos($length_days,';')){
                $arr_one = explode(';',$length_days);
                for($i=0;$i<sizeof($arr_one);$i++){
                    if(strpos($arr_one[$i],':')){
                        $arr_two = explode(':',$arr_one[$i]);
                        if($arr_two[0] && strpos($arr_two[0],'-')){
                            $arr_three = explode('-',$arr_two[0]);
                            if($arr_three[0] && $arr_three[1]){
                                $arr_three[1] = str_replace('m','',$arr_three[1]);
                                if($arr_three[0] <= $length && $length < $arr_three[1]){
                                    $customized_length_day = str_replace('+','',$arr_two[1]);
                                }
                            }
                        }elseif ($arr_two[0] && strstr($arr_two[0],'>')){
                            $arr_three = str_replace('>','',$arr_two[0]);
                            $arr_three = str_replace('m','',$arr_three);
                            if($length >= $arr_three){
                                $customized_length_day = str_replace('+','',$arr_two[1]);
                            }
                        }
                    }
                }
            }
        }
        //产品数量交期
        if($basics_days[0][2] && !empty($qty)){
            $qty_days = $basics_days[0][2];
            $is_true = strpos($qty_days,';');
            if($is_true){
                $arr_one = explode(';',$qty_days);
                for($i=0;$i<sizeof($arr_one);$i++){
                    if(strpos($arr_one[$i],':')){
                        $arr_two = explode(':',$arr_one[$i]);
                        if($arr_two[0] && strpos($arr_two[0],'-')){
                            $arr_two[0] = str_replace('m','',$arr_two[0]);
                            $arr_three = explode('-',$arr_two[0]);
                            if($arr_three[0] && $arr_three[1]){
                                if($arr_three[0] <= $qty && $qty < $arr_three[1]){
                                    $customized_qty_day = str_replace('+','',$arr_two[1]);
                                }
                            }
                        }elseif ($arr_two[0] && strstr($arr_two[0],'>')){
                            $arr_two[0] = str_replace('m','',$arr_two[0]);
                            $arr_three = str_replace('>','',$arr_two[0]);
                            if($qty >= $arr_three){
                                $customized_qty_day = str_replace('+','',$arr_two[1]);
                            }
                        }
                    }
                }
            }
        }
        if($minus_min_days){
            $days = $days + $customized_length_day - $minus_min_days + $ship_day + $customized_qty_day;
        }else{
            $days = $days + $customized_length_day + $add_max_days + $ship_day + $customized_qty_day;
        }
    }
    return $days;
}

function attribute_matching_fictitious_id($pid,$attr_arr=array()){
    global $db;
    if(empty($pid)){
        return '';
    }
    if(empty($attr_arr)){
        return $pid;
    }
    $data = [];
    $sql = "SELECT cfa.create_products_id,cfa.products_id,cfai.options_value_id,cfai.origin_length,cfai.options_value_name FROM create_products_from_attribute cfa LEFT JOIN create_products_from_attribute_info cfai using (create_products_id) WHERE cfa.related_id=".(int)$pid;
    $rst = $db->Execute($sql);
    while (!$rst->EOF){
        $length = '';
        if($rst->fields['origin_length']){
            $length = str_replace('km','',$rst->fields['options_value_name']);
            $length = str_replace('m','',$length);
        }
        $data[$rst->fields['products_id']][$rst->fields['create_products_id']][] = $rst->fields['options_value_id'] ? $rst->fields['options_value_id'] : $length;
        $rst->MoveNext();
    }
    if(sizeof($data)){
        asort($attr_arr);
        $attr_str = implode(',',$attr_arr);
        foreach ($data as $products_id => $options_info){
            foreach ($options_info as $v){
                asort($v);
                $str = implode(',',$v);
                if($attr_str == $str){ //两个数组相等就结束循环
                    $pid = $products_id;
                    break;
                }
            }
        }
    }
    return $pid;
}

/**
 * @param $pid  产品ID
 * @param $cn_qty 武汉仓库存
 * @param $buy_product_qty 客户购买数量(客户购买数量减去本地仓库存)
 * @return int
 */
function get_standard_product_days($pid,$buy_product_qty){
    global $db;
    $pid = (int)$pid;
    $day=0;
    if(empty($pid)){
        return $day;
    }
    $result = get_redis_key_value("purchase_information_" . $pid, "purchase_information_" . $pid);
    if($result){
        $info = $result;
    }else{
        $sql = "SELECT deliver_num,pid.deliver_time,pid.transport_time FROM purchase_information_delivery pid 
            LEFT JOIN purchase_information pi ON (pid.information_id = pi.id)
            WHERE pi.products_id = ".$pid." AND pi.is_default = 1 AND pid.deliver_time!=0";
        $info = $db->getAll($sql);
        set_redis_key_value("purchase_information_" . $pid, $info, 7 * 24 * 3600, "purchase_information_" . $pid);
    }
    if($info){
        foreach ($info as $k => $d){
            if(strpos($d['deliver_num'],'-')){
                $arr = explode('-',$d['deliver_num']);
                if($buy_product_qty>=$arr[0] && $buy_product_qty<=$arr[1]){
                    $day = intval($d['deliver_time'] + $d['transport_time']);
                }
            }elseif(strpos($d['deliver_num'],'+')){
                $arr = str_replace('+','',$d['deliver_num']);
                if($buy_product_qty > $arr){
                    $day = intval($d['deliver_time'] + $d['transport_time']);
                }
            }
        }
    }
    if($day==0){
        $day = intval($info[sizeof($info)-1]['deliver_time'] + $info[sizeof($info)-1]['transport_time']);
    }
    return $day;
}

/**
 * 展示德国仓外币信息,根据SQ20191202033附件信息设置
 * by rebirth 2019.12.09
 *
 * @param $code
 * @return array
 */
function getDeSparkasseAccount($code)
{
    $parkasses = [
        'default' => [
            ['name' => FIBER_CHECK_ACCOUNT, 'info' => 'FS.COM GmbH'],
            ['name' => FIBER_SPARKASSE_BANK_NAME, 'info' => 'Sparkasse Freising'],
            ['name' => FS_HSBC_INFO3, 'info' => 'DE16 7005 1003 0025 6748 88'],
            ['name' => FS_HSBC_INFO4, 'info' => 'BYLADEM1FSI'],
            ['name' => FS_HSBC_INFO5, 'info' => '25674888'],
            ['name' => FIBER_CHECK_BANK, 'info' => 'Untere Hauptstr.29, 85354, Freising'],
        ],
        'USD'     => [
            ['name' => FIBER_CHECK_ACCOUNT, 'info' => 'FS.COM GmbH'],
            ['name' => FIBER_SPARKASSE_BANK_NAME, 'info' => 'Sparkasse Freising'],
            ['name' => FS_HSBC_INFO3, 'info' => 'DE12 7005 1003 0970 0195 27'],
            ['name' => FS_HSBC_INFO4, 'info' => 'BYLADEM1FSI'],
            ['name' => FS_HSBC_INFO5, 'info' => '970 0195 27'],
            ['name' => FIBER_CHECK_BANK, 'info' => 'Untere Hauptstrasse 29, 85354 Freising'],
        ],
        'GBP'     => [
            ['name' => FIBER_CHECK_ACCOUNT, 'info' => 'FS.COM GmbH'],
            ['name' => FIBER_SPARKASSE_BANK_NAME, 'info' => 'Sparkasse Freising'],
            ['name' => FS_HSBC_INFO3, 'info' => 'DE38 7005 1003 0970 0272 07'],
            ['name' => FS_HSBC_INFO4, 'info' => 'BYLADEM1FSI'],
            ['name' => FS_HSBC_INFO5, 'info' => '970 0272 07'],
            ['name' => FIBER_CHECK_BANK, 'info' => 'Untere Hauptstrasse 29, 85354 Freising'],
        ],
        'CHF'     => [
            ['name' => FIBER_CHECK_ACCOUNT, 'info' => 'FS.COM GmbH'],
            ['name' => FIBER_SPARKASSE_BANK_NAME, 'info' => 'Sparkasse Freising'],
            ['name' => FS_HSBC_INFO3, 'info' => 'DE27 7005 1003 0970 0573 78'],
            ['name' => FS_HSBC_INFO4, 'info' => 'BYLADEM1FSI'],
            ['name' => FS_HSBC_INFO5, 'info' => '970 0573 78'],
            ['name' => FIBER_CHECK_BANK, 'info' => 'Untere Hauptstrasse 29, 85354 Freising'],
        ],
        'SEK'     => [
            ['name' => FIBER_CHECK_ACCOUNT, 'info' => 'FS.COM GmbH'],
            ['name' => FIBER_SPARKASSE_BANK_NAME, 'info' => 'Sparkasse Freising'],
            ['name' => FS_HSBC_INFO3, 'info' => 'DE98 7005 1003 0970 1070 25'],
            ['name' => FS_HSBC_INFO4, 'info' => 'BYLADEM1FSI'],
            ['name' => FS_HSBC_INFO5, 'info' => '970 1070 25'],
            ['name' => FIBER_CHECK_BANK, 'info' => 'Untere Hauptstrasse 29, 85354 Freising'],
        ]
    ];
    if (!isset($parkasses[$code])){
        $code = 'default';
    }
    return $parkasses[$code];
}

/**
 * 设置专题页的信息展示
 * by rebirth 2019.12.09
 *
 * @param $infos
 * @return string
 */
function getSparkasseDom($infos){
    $html = '<tbody>';
    $k = 0;
    foreach ($infos as $info){
        if ($k){
            $css = 'PU_beneficiary_blue';
            $k = 0;
        }else{
            $css = 'PU_beneficiary_gray';
            $k = 1;
        }
        $html .= '<tr class="'.$css.'"><td class="PU_beneficiary_left">'.$info['name'].':</td><td>'.$info['info'].'</td></tr>';
    }
    $html .='</tbody>';
    return $html;
}

/**
 * 检测邮编是否符合美国UPS物流
 * @param $post_code 邮编
 * @param $country_code 国家编号
 * @return bool
 */
function checkUsUpsPostcode($post_code, $country_code){
    global $db;

    $return = true;
    if(in_array(strtoupper($country_code), ['MX','CA','PR'])){
        return $return;
    }

    $special_zone = $db->getAll("SELECT zip,ground,overnight,2day FROM shipping_ups_special  WHERE zip = '".$post_code."'");
    $th_post = substr(trim($post_code), 0, 3);
    $zone_o = $db->getAll("select zip_from,zip_to,2day from shipping_ups where zip_from<= '$th_post' and zip_to >= '$th_post' and location = 2");
    $zone_t = $db->getAll("select 2dayam from shipping_ups where zip_from<= '$th_post' and zip_to >= '$th_post' and location = 3");

    if(empty($special_zone) && empty($zone_o) && empty($zone_t)){
        $return = false;
    }
    return $return;
}

/**
 * 检测地址id是否为当前客户运输地址
 * @param $address_book_id 地址id
 */
function validationAddressBookId($address_book_id){
  global $db;
    if($_SESSION['customer_id']) {
        $address_book_id = $db->Execute("select address_book_id from " . TABLE_ADDRESS_BOOK . " where customers_id=" . $_SESSION['customer_id'] . " and address_book_id = " . $address_book_id . " and address_type=0 limit 1")->fields['address_book_id'];
        if(is_numeric($address_book_id)){
            return $address_book_id;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function is_gsp_checkout_order(){
    global $order;

    $return = false;
    $country_id = $order->delivery['country_id'];
    if(in_array($country_id,[223,172])) {
        if ($order->is_buck) {
            if(!empty($order->delay_products)){
                $return = true;
            }
        } else {
            $return = !empty($order->delay_info['products_arr']) ? true : false;
        }
    }

    return $return;

}

/**
 * 判断是否包含超规格特殊产品73579,73958
 * @return array
 */
function CheckOrderSuperSpecProducts($is_own = false)
{
    global $order;
    $local_warehourse = $order->local_warehouse;
    $local_products = $order->local_info['products_arr'];
    $delay_products = $order->delay_info['products_arr'];
    $country_id = $order->delivery['country_id'];
    $return = array(
        'local_spec' => false,
        'delay_spec' => false
    );
    $spec_arr = [73579, 73958];

    if(!in_array($order->local_warehouse, [20, 67]) && $country_id != 13){
        foreach ($spec_arr as $pid) {
            if ($local_warehourse == 2 && in_array($pid, $local_products)) {
                $return['local_spec'] = true;
            }
            $check_own = $is_own ? true : !in_array($country_id, [100, 129, 168]);
            if (in_array($pid, $delay_products) && $check_own) {
                $return['delay_spec'] = true;
            }
        }
    }

    return $return;
}
/**
 * Add By Quest
 * 获取GSP税后价格
 * @param $country country_code 和 country_id 都适用
 * @param $ori_price int 原价格
 * @return float|int
 */
function get_gsp_tax_price($country='', $ori_price)
{
    if(empty($ori_price)){
        return 0;
    }
    $country = $country ? $country : $_SESSION['countries_iso_code'];
    if(is_numeric($country)){
        switch ($country){
            case 13:
                $tax_rate = 1.1;
                break;
            default:
                $tax_rate = 1;
                break;
        }
    }else{
        $country = strtoupper($country);
        switch ($country){
            case 'AU':
                $tax_rate = 1.1;
                break;
            default:
                $tax_rate = 1;
                break;
        }
    }

    $after_tax_price = $ori_price * $tax_rate;
    return $after_tax_price;
}

/**
 * @param $product_id
 * @param string $attr  组合产品属性
 * @param string $country
 * @return bool
 */
function AU_use_gsp_tax($product_id, $attr = '',$country = '')
{
    $country = $country ?  : $_SESSION['countries_iso_code'];
    if (strtoupper($country) != 'AU'){
        return false;
    }
    /* 澳大利亚重货展示税后价  全面转运
     * $heavy = get_heavy_products([(int)$product_id], 37);
    //非重货直接使用算税
    if (!in_array($product_id, $heavy['heavy_products'])) {
        return true;
    }
    $attr = ['attr' => $attr];
    $instock = fs_products_instock_qty_of_products_id($product_id, 'AU', 0, 0, true, $attr);
    //重货有库存则算税
    return ($instock > 0);*/
    return true;
}

/**
 * $Notes: 判断是否为北爱尔兰地区
 *
 * $author: Quest
 * $Date: 2021/2/24
 * $Time: 11:56
 * @param $postcode
 * @param $countries
 * @return bool
 */
function checkNorthIrelandPostcode($postcode, $countries)
{
    if($countries != 222 && $countries != 'GB'){
        return false;
    }
    $postcode = substr($postcode,0,-2);
    $postcode = str_replace(' ', '', $postcode);
    $res = fs_get_data_from_db_fields('id','countries_north_ir_zip',"postcode = '$postcode'");

    if(empty($res)){
        return false;
    }
    return true;
}