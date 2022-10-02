<?php
/**
 * User: Administrator
 * Date: 2017/11/24
 * Time: 19:15
 * created by Aron
 * 根据仓库 返回运费信息
 */
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require DIR_WS_CLASSES . 'shipping.php';
require(DIR_WS_CLASSES . 'order.php');
$action = $_GET['ajax_request_action'];
if (isset($action) && $_GET['ajax_request_action'] == "get_shipping") {
    if(!isset($_POST["pro_id"])){
        echo json_encode(array("type"=>"error"));
    }
    $order = new order();
    $shipping = new shipping();
    $currencies = new currencies();
    $pro_id = explode(",",$_POST["pro_id"]);
    $pro = array_unique($pro_id);
    $warehouse = $_POST['warehouse'];
    $is_other_country = !empty($_POST['is_other_country']) ? $_POST['is_other_country'] : 0;
    $country_id = isset($_POST['country_id']) ? $_POST['country_id'] : "";
    $state = isset($_POST['state']) ? $_POST['state'] : "";
    $_SESSION['cart']->calculate_for_separate($pro);
    $total_weight = $_SESSION['cart']->weight;
    $quotes = $shipping->quote();
    $data = array();
    $j = 0;
    $is_show_free = 0;
    $rate = (zen_not_null($currencies->currencies[$_SESSION['currency']]['value'])) ? $currencies->currencies[$_SESSION['currency']]['value'] : $currencies->currencies[$_SESSION['currency']]['value'];
    switch ($warehouse) {
        case "US":
            if(in_array($country_id,array(138,38))||$is_other_country==1){
                $shipping_arr = array(

                    array(
                        'method' => 'dhlazones',
                        'title' => 'DHL'
                    ),
                    array(
                        'method' => 'upsazones',
                        'title' => 'UPS Express'
                    )

                );
            }else {
                $shipping_arr = array(
                    array(
                        'method' => 'ffzones',
                        'title' => 'ODFL'
                    ),
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
                        'method' => 'fedexovernightzones',
                        'title' => FIBER_FEDEX_CHECK_OVER
                    ),
                    array(
                        'method' => 'upsovernightzones',
                        'title' => FIBER_CHECK_ONE
                    )
                );
            }
            break;
        case "DE":
            if ($_SESSION['languages_id']) {
                if ($country_id == 81) {
                    $shipping_arr = array(
                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard<sup>®</sup> Working Days Service'
                        ),
                        array(
                            'method' => 'dhlgzones',
                            'title' => 'DHL Express Worldwide<sup>®</sup> 1-3 Working Days'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver<sup>®</sup> 1-4 Working Days Service'
                        )
                    );
                } else {
                    $shipping_arr = array(
                        array(
                            'method' => 'upsstandardzones',
                            'title' => 'UPS Standard<sup>®</sup> Working Days Service'
                        ),
                        array(
                            'method' => 'dhlezones',
                            'title' => 'DHL Express Worldwide<sup>®</sup> 1-3 Working Days'
                        ),
                        array(
                            'method' => 'upssaverzones',
                            'title' => 'UPS Express Saver<sup>®</sup> 1-4 Working Days Service'
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
                        'method' => 'upszones',
                        'title' => 'UPS'
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
                        'method' => 'tntzones',
                        'title' => 'TNT'
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
            break;
        case "WH":
            if ($_SESSION['languages_id'] == 1) {
                $shipping_arr = array(
                    array(
                        'method' => 'fedexzones',
                        'title' => 'FedEx IP'
                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
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
                        'method' => 'fedexiezones',
                        'title' => 'FedEx IE'
                    ),
                    array(
                        'method' => 'tntzones',
                        'title' => 'TNT'
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
            } else {
                $shipping_arr = array(
                    array(
                        'method' => 'dhlzones',
                        'title' => 'DHL'
                    ),
                    array(
                        'method' => 'upszones',
                        'title' => 'UPS'
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
                        'method' => 'tntzones',
                        'title' => 'TNT'
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
            break;
        default:
            $shipping_arr = array(
                array(
                    'method' => 'dhlzones',
                    'title' => 'DHL'
                ),
                array(
                    'method' => 'upszones',
                    'title' => 'UPS'
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
                    'method' => 'tntzones',
                    'title' => 'TNT'
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
    if($country_id == 44){
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
    foreach ($shipping_arr as $key => $v) {
        if (isset($quotes[$v['method']]) && is_array($quotes[$v['method']]) && $quotes[$v['method']]['methods'][0]['cost'] >= 0) {
            if($warehouse!="US"){
                $day = get_days($_SESSION['countries_code_2'], $v['method']);
            }else{
                if(in_array($country_id,array(138,38))||$is_other_country==1){
                    $day = get_days($_SESSION['countries_code_2'], $v['method']);
                }else{
                    $day = "";
                }

            }
            $data[$j]['methods'] = $v['method'];
            if($warehouse == "DE"){
                $data[$j]['title'] = $v['title']." ".$day." Service";
            }else{
                $data[$j]['title'] = $v['title']." ".$day;
            }
            if ($quotes[$v['method']]['methods'][0]['cost'] == 0) {
                $data[$j]['price'] = FIBER_CHECK_FREE;
                $data[$j]['origin_price'] = 0;
            } else {
                $data[$j]['price'] = $currencies->new_format($quotes[$v['method']]['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                $data[$j]['origin_price'] = zen_round( get_products_all_currency_final_price($quotes[$v['method']]['methods'][0]['cost']*$rate),  $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            }
            $data[$j]["s_price"] = $quotes[$v['method']]['methods'][0]['cost'];
            $j++;
        }
    }
    if ($warehouse == "US" && !in_array($country_id,array(138,38)) && !$is_other_country) {
        if (date('D') == 'Fri' || date('D') == 'Thu') {
            if (isset($quotes['saturdaydeliveryzones']) && is_array($quotes['saturdaydeliveryzones']) && $quotes['saturdaydeliveryzones']['methods'][0]['cost'] >= 0) {
                $data[$j]['methods'] = 'saturdaydeliveryzones';
                $data[$j]['title'] = 'Saturday Delivery ';
                $data[$j]['price'] = $currencies->new_format($quotes['saturdaydeliveryzones']['methods'][0]['cost'], true,$_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
                $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['saturdaydeliveryzones']['methods'][0]['cost']*$rate),  $currencies->currencies[$_SESSION['currency']]['decimal_places']);
                $data[$j]["s_price"] =$quotes['saturdaydeliveryzones']['methods'][0]['cost'];
                $j++;
            }
        }
    }
    if ((in_array($state,array('WA','Washington')) || $warehouse == "DE") && $warehouse!="WH") {

        if (isset($quotes['selfreferencezones']) && is_array($quotes['selfreferencezones']) && $quotes['selfreferencezones']['methods'][0]['cost'] >= 0) {
            $data[$j]['methods'] = 'selfreferencezones';
            $data[$j]['title'] = 'I\'ll pick it up in person ';
            $data[$j]['price'] = $currencies->new_format($quotes['selfreferencezones']['methods'][0]['cost'], true, $_SESSION['currency'], $currencies->currencies[$_SESSION['currency']]['value']);
            $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['selfreferencezones']['methods'][0]['cost']*$rate),  $currencies->currencies[$_SESSION['currency']]['decimal_places']);
            $data[$j]["s_price"] = $quotes['selfreferencezones']['methods'][0]['cost'];
            $j++;
        }
    }
    if(empty($data)){
        $no_method_em = 1;
    }else{
        $no_method_em = 0;
    }
    if (isset($quotes['customzones']) && is_array($quotes['customzones']) && $quotes['customzones']['methods'][0]['cost'] >= 0) {
        $data[$j]['methods'] = 'customzones';
        $data[$j]['title'] = FIBER_CHECK_USE;
        $data[$j]['price'] = $currencies->new_format($quotes['customzones']['methods'][0]['cost'], true, $_SESSION['currency'],  $currencies->currencies[$_SESSION['currency']]['value']);
        $data[$j]['origin_price'] = zen_round(get_products_all_currency_final_price($quotes['customzones']['methods'][0]['cost']*$rate),  $currencies->currencies[$_SESSION['currency']]['decimal_places']);
        if ($warehouse == "US") {
            if(in_array($country_id,array(138,38))|| $is_other_country==1){
                
                    $shipping_custom = array('UPS', 'FEDEX', 'DHL', 'EMS', 'TNT', 'OTHERS');
                
            }else{
                $shipping_custom = array('UPS 2DAYS', 'UPS GROUND', 'UPS OVERNIGHT', 'FEDEX GROUND', 'FEDEX OVERNIGHT', 'FEDEX 2DAY', 'OTHERS');
            }

        } else {
            $shipping_custom = array('UPS', 'FEDEX', 'DHL', 'EMS', 'TNT', 'OTHERS');
        }

        $data[$j]["s_price"] = $quotes['customzones']['methods'][0]['cost'];
        $data[$j]['custom'] = $shipping_custom;
        $j++;
    }
    if (sizeof($data)) {
        if(in_array($warehouse,array('US','DE'))&&$data[0]['s_price']==0&&$no_method_em!=1){
            $is_show_free = "1";
        }
        echo json_encode(array("type" => "success", "data" => $data,"pro"=>$total_weight,"is_show_free"=>$is_show_free,"no_method_em"=>$no_method_em));
    } else {
        echo json_encode(array("type" => "error"));
    }
}