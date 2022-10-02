<?php
/**
 * functions_general.php
 * General functions used throughout Zen Cart
 *
 * @package functions
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_general.php 16312 2010-05-22 08:13:42Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
function get_fiberstore_parent_categories_id($cid){
	global $db;
	$cacheType = sqlCacheType();
	$categories = $db->Execute("select {$cacheType} parent_id from categories where categories_id = '$cid'");
	return $categories->fields['parent_id'];
}
//当前时区设置 created by aron
function getTime($format = "Y-m-d H:i:s",$add="",$code="",$zone="",$is_from_home=true,$area = '') {
	global $db;
	$timezone_out = date_default_timezone_get();

	if(empty($add)){
		$add=time();
	}else{
	    if( !$is_from_home ){ // 来自于后台；使用php的时间函数的话：后台是东八区，前台西八区
            $add = $add-16*3600;
        }
    }
    if(empty($area)) {
        if (!empty($code)) {
            $code = strtoupper($code);

            $area = get_redis_key_value($code,'fs_zone_');
            if(empty($area)) {
                $area = $db->Execute("select time_zone from country_time_zone where code='$code' limit 1");
                $area = $area->fields['time_zone'];
                set_redis_key_value($code, $area, 0, 'fs_zone_');
            }
        }
    }
    
    if(empty($code)||empty($area)){
		$area = $timezone_out;
	}
    if($zone){
        $area = $zone;
    }
	date_default_timezone_set($area);
    if(strpos($format,'default') !== false){ //使用的公共的日期表达
        $time = get_all_languages_date_display($add,$format);
    }else{
        $time = date($format,$add);
        //$time = get_date_product_delivery($time,$_SESSION['languages_id']);
    }
	date_default_timezone_set("America/Los_Angeles");
	return $time;
}

/*
 * 获取国内时区
 * add 2019-4-27
 * 如果传入一个 时间 把那个时间转换成北京时间戳
 */
function get_common_cn_time($time = ''){
    date_default_timezone_set("Asia/Shanghai");
    if($time){
        $date = strtotime($time);
    }else{
        $date = date("Y-m-d H:i:s");
    }
    date_default_timezone_set("America/Los_Angeles");
    return $date;
}

/** 国内上班时间 返回false
 *  @return bool
 */
function getIsSendServiceEmail(){
    $result = true;
    date_default_timezone_set("Asia/Shanghai");
    $Ymd = date('Y-m-d ',time());
    $stars = strtotime($Ymd . '9:30:00');
    $end = strtotime($Ymd . '18:30:00');
    $curr_time = time();
    if($curr_time >= $stars && $curr_time <= $end){
        $result = false;
    }
    date_default_timezone_set("America/Los_Angeles");
    return $result;
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 根据session，获取不同国家的电话号码
function get_country_phone($type='site'){
    if($type == 'site'){
        $countryCode  = $_SESSION['languages_code'];
        switch ($countryCode){
            case 'es': $str = FS_PHONE_SITE_ES; break;
            case 'fr': $str = FS_PHONE_SITE_FR; break;
            case 'jp': $str = FS_PHONE_SITE_JP; break;
            case 'mx': $str = FS_PHONE_SITE_MX; break;
            case 'ru': $str = FS_PHONE_SITE_RU; break;
            case 'au': $str = FS_PHONE_SITE_AU; break;
            case 'uk': $str = FS_PHONE_SITE_UK; break;
            case 'de': $str = FS_PHONE_SITE_EU; break;
            case 'en': $str = FS_PHONE_SITE_US; break;
			case 'sg': $str = FS_PHONE_SITE_SG; break;
            default:$str = FS_PHONE_US;
        }
    }else{
        $countryCode  = strtoupper($_SESSION['countries_iso_code']);
        switch ($countryCode){
            case 'HK': $str = FS_PHONE_HK; break;
            case 'MX': $str = FS_PHONE_MX; break;
            case 'CA': $str = FS_PHONE_CA; break;
            case 'BR': $str = FS_PHONE_BR; break;
            case 'GB': $str = FS_PHONE_GB; break;
            case 'FR': $str = FS_PHONE_FR; break;
            case 'NL': $str = FS_PHONE_NL; break;
            case 'DE': $str = FS_PHONE_DE; break;
            case 'AU': $str = FS_PHONE_AU; break;
            case 'ES': $str = FS_PHONE_ES; break;
            case 'RU': $str = FS_PHONE_RU; break;
            case 'SG': $str = FS_PHONE_SG; break;
            case 'AR': $str = FS_PHONE_AR; break;
            case 'CH': $str = FS_PHONE_CH; break;
            case 'TW': $str = FS_PHONE_TW; break;
            case 'DK': $str = FS_PHONE_DK; break;
            case 'NZ': $str = FS_PHONE_NZ; break;
            case 'IC': $str = FS_PHONE_IC; break;
            default:$str = FS_PHONE_US;
        }
    }
    return $str;
}
//判断文件是否存在
function remote_file_exists($url) {
    $executeTime = ini_get('max_execution_time');
    ini_set('max_execution_time', 0);
    $headers = @get_headers($url);
    ini_set('max_execution_time', $executeTime);
    if ($headers) {
        $head = explode(' ', $headers[0]);
        if ( !empty($head[1]) && intval($head[1]) < 400) return true;
    }
    return false;
}

/**
 * 获取当前国家对应币种的免运金额
 * @param string $warehouse 仓库 (用字符串形式的传参 如: en,de,au,cn)
 * @param string $country_code 国家
 * add by Quest 2019-07-25
 */
function get_ori_free_shipping_money($warehouse = '', $country_code = '')
{
    global $currencies;

    $country_code = empty($country_code) ? $_SESSION['countries_iso_code'] : $country_code;
    if(empty($warehouse)){
        $warehouse = get_warehouse_by_code($country_code);
    }
    $country_code = strtoupper($country_code);

    switch ($warehouse) {
        case 'au':
            $free_price = 99;
            $pre_free_price = 399;
            $currencies_val = $currencies->currencies["AUD"]['value'];
            $currencies_type = "AUD";
            break;
        case 'ru':
            $free_price = 20000;
            $pre_free_price = 20000;
            $currencies_val = $currencies->currencies["AUD"]['value'];
            $currencies_type = "RUB";
            break;
        case 'de':
            $free_price = 79;
            $pre_free_price = 299;
            $currencies_val = $currencies->currencies["EUR"]['value'];
            $currencies_type = "EUR";
            if (in_array($country_code,array("GB","GG","IM","JE"))) {
                $currencies_val = $currencies->currencies["GBP"]['value'];
                $currencies_type = "GBP";
            }
            //欧洲仓非欧元的免运费价格 Quest
            if(strtoupper($_SESSION['currency']) != 'EUR') {
                switch ($country_code) {
                    case 'DK':
                    case 'FO':
                        $free_price = 599;
                        $pre_free_price = 2300;
                        $currencies_val = $currencies->currencies["DKK"]['value'];
                        $currencies_type = "DKK";
                        break;
                    case 'LT':
                    case 'MD':
                        $free_price = 90;
                        $pre_free_price = 339;
                        $currencies_val = $currencies->currencies["USD"]['value'];
                        $currencies_type = "USD";
                        break;
                    case 'NO':
                        $free_price = 799;
                        $pre_free_price = 2900;
                        $currencies_val = $currencies->currencies["NOK"]['value'];
                        $currencies_type = "NOK";
                        break;
                    case 'SE':
                        $free_price = 850;
                        $pre_free_price = 3150;
                        $currencies_val = $currencies->currencies["SEK"]['value'];
                        $currencies_type = "SEK";
                        break;
                    case 'CH':
                        $free_price = 89;
                        $pre_free_price = 350;
                        $currencies_val = $currencies->currencies["CHF"]['value'];
                        $currencies_type = "CHF";
                        break;
                }
            }
            break;
        case 'us':
            $free_price = 79;
            $pre_free_price = 299;
            $currencies_val = $currencies->currencies["USD"]['value'];
            $currencies_type = "USD";
            if($_SESSION['currency'] != 'USD') {
                if ($country_code == "CA") {
                    $free_price = 105;
                    $pre_free_price = 399;
                    $currencies_val = $currencies->currencies["CAD"]['value'];
                    $currencies_type = "CAD";
                }
                if ($country_code == "MX") {
                    $free_price = 1600;
                    $pre_free_price = 6000;
                    $currencies_val = $currencies->currencies["MXN"]['value'];
                    $currencies_type = "MXN";
                }
            }
            break;
        case 'sg':
            if($_SESSION['currency'] == "SGD"){
                $free_price = 99;
                $currencies_val = $currencies->currencies["SGD"]['value'];
                $currencies_type = "SGD";
            } elseif ($_SESSION['currency'] == "USD"){
                $free_price = 72;
                $currencies_val = $currencies->currencies["USD"]['value'];
                $currencies_type = "USD";
            }
            break;
        default:
            $free_price = 99;
            $pre_free_price = 299;
            $currencies_val = $currencies->currencies["USD"]['value'];
            $currencies_type = "USD";
            break;
    }

    return [
        "free_price" => $free_price,
        "pre_free_price" => $pre_free_price,
        "currencies_val" => $currencies_val,
        "currencies_type" => $currencies_type,
        'TextPri' => $currencies->currencies[$currencies_type]['symbol_left'] . $free_price . $currencies->currencies[$currencies_type]['symbol_right'],
        'TextPrePri' => $currencies->currencies[$currencies_type]['symbol_left'] . $pre_free_price . $currencies->currencies[$currencies_type]['symbol_right'],
    ];
}


function getWebsiteData($param,$where,$orderby = '',$groupby = ''){

    $redis_prefix = 'fs_website';
    $redis_param_str = implode(',',$param);
    $redis_param = trim($redis_param_str,',');
    $redis_key = $redis_param.'_'.$where.$orderby.$groupby;

    $data = get_redis_key_value($redis_key,$redis_prefix);
    if(empty($data) || $data == 'null'){
        $data = fs_get_data_from_db_fields_array($param,'country_to_website',$where,$orderby.' '.$groupby);
        set_redis_key_value($redis_key,$data,'',$redis_prefix);
    }
    return $data;
}

/**
 * sql查询缓存类型
 *
 * @return string
 */
function sqlCacheType(){
    $type = defined("MYSQL_QUERY_CACHE") ? MYSQL_QUERY_CACHE:"";
    return $type;
}
if (!function_exists('orders_number_limit')) {

    /**
     * 检测单号时候在数据库中
     * by rebirth   2020.06.01
     *
     * @param string $number
     * @return bool
     */
    function orders_number_limit($number = '')
    {
        $number = trim((string)$number);
        if (empty($number)) {
            return false;
        }
        global $db;
        $find = false;
        $sql = [
            "select orders_id from " . TABLE_ORDERS . " where orders_number = '" . $number . "' limit 1",
            "select products_instock_id from products_instock_shipping where (order_number = '" . $number . "' or order_invoice = '" . $number . "') limit 1",
            "select address_id from manage_customer_inquiry_PI_info where order_invoice = '" . $number . "' limit 1"
        ];
        foreach ($sql as $sqlItem) {
            $billing_address = $db->Execute($sqlItem);
            if ($billing_address->RecordCount() > 0) { //线上单查询相关信息
                $find = true;
                break;
            }
        }
        return $find;
    }
}

if (!function_exists('orders_number_style_check')) {
    /**
     * 单号格式检测
     * by rebirth   2020.06.01
     *
     * @param string $number
     * @return bool
     */
    function orders_number_style_check($number = '')
    {
        $number = trim((string)$number);
        if (empty($number)) {
            return false;
        }
        return preg_match('/^FS\d{12}(-P\d)?(R\d)?$/i', $number);
    }
}

/**
 * 分类页参数过滤xss攻击.
 * by bob   2020.11.02
 *
 * @param string $arr
 * @return bool
 */

function categories_param_remove_xss($requestUri)
{
    $get_narrow = array();
    $narrow_url = '';
    $unarrowGET = array('_requestConfirmationToken', 'cPath', 'main_page', 'page', 'sort', 'type', 'count', 'settab', 'sort_order');
    $urlArr = parse_url($requestUri);
    $urlArr['query'] = convertUrlQuery($urlArr['query']);

    foreach ($urlArr['query'] as $getname => $getvalue) {
        if (!in_array($getname, $unarrowGET)) {
            if ($getvalue && is_numeric($getvalue)) {
                $get_narrow [] = $getvalue;
                $narrow_url .= '&narrow[]=' . $getvalue;
                $narrow_arr [$getname] = $getvalue;
            } else {
                //常规参数如果值不是整形的强制转换为整型
                $urlArr['query'][$getname] = (int)$getvalue;
            }
        }
    }

    $newUrl = $urlArr['scheme'] . $urlArr['host'] . $urlArr['path'];
    $newUrl = $newUrl . "?" . http_build_query($urlArr['query']);
    return $newUrl;
}

/**
 * url参数字符串转数组
 * by bob   2020.11.02
 *
 * @param string $arr
 * @return bool
 */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $key=>$param) {
        //参数格式不正常的直接过滤掉本参数
        $pos = substr_count( $param,'=');
        if($pos !== 1){
            unset($queryParts[$key]);
            continue;
        }
        $item = explode('=', $param);
        $params[$item[0]]=$item[1];
    }

    return $params;
}


function get_service_type_name($type_id){
    $result = '未指定服务名称';
    if($type_id){
        $name = fs_get_data_from_db_fields('name', 'service_process_type', 'id = "'.$type_id.'"', 'limit 1');
        if($name != ''){
            return $name;
        }
    }
    return $result;
}

/**
 * Quote功能埋点
 * $click_type 点击事件类型
 * $click_type=1 在shopping cart页面点击Creat Quote按钮;
 * $click_type=2 在Create Quote页面点击Creat按钮;
 * $click_type=3 在Create Quote页面点击Return to Cart按钮;
 * $click_type=4 在Create Quote页面点击Preview PDF按钮;
 * $click_type=5 在Creat Quote Success页面点击Account/Quote按钮;
 * $click_type=6 在Creat Quote Success页面点击Share via Email按钮;
 * $click_type=7 在Quote History页面点击切换online/offline下拉框;
 * $click_type=8 在Quote History页面点击切换all status下拉框;
 * $click_type=9 在Quote History页面点击切换select time下拉框;
 * $click_type=10 在Quote History页面点击搜索输入框;
 * $click_type=11 在Quote History页面点击Contact Customer Service按钮;
 * $click_type=12 在Quote History页面点击Checkout按钮;
 * $click_type=13 在Quote Details页面点击Checkout按钮;
 * $click_type=14 在Quote History页面点击Quote Again按钮;
 * $click_type=15 在Quote Details页面点击Download Quote按钮;
 * $click_type=16 来自（Creat Quote Seccuss页面）Account/Quote 入口的跳转到Quote History页面的曝光事件;
 * $click_type=17 来自（头部下拉）Active Quote 入口的跳转到Quote History页面的曝光事件;
 * $click_type=18 来自（账户中心）Quote History 入口的跳转到Quote History页面的曝光事件;
 * $click_type=19 来自（账户中心）View All Quotes 入口的跳转到Quote History页面的曝光事件;
 */
function click_log($click_type){
    if (!$click_type||!is_numeric($click_type)) {
        return false;
    }

    $languages_code = $_SESSION['languages_code'];
    $countries_code = $_SESSION['countries_iso_code'];
    $customer_id = $_SESSION['customer_id'];

    //redis缓存前缀
    $prefix = "fs_quotes_click_log";
    $key = md5($customer_id . $languages_code . $countries_code . $click_type, true);

    //在redis缓存中查询是否已经写入过相关操作的数据id
    $click_type_id = get_redis_key_value($key, $prefix);

    if (!$click_type_id) {
        //在数据库中查询是否已经写入过相关操作的数据
        $where = " click_type=" . $click_type . " and languages_code='" . $languages_code . "' and countries_code='" . $countries_code . "' and customer_id =" . $customer_id;
        $res3 = fs_get_one_data('fs_quotes_click_log', $where, 'id');
        $click_type_id = $res3['id'];

        //$click_type_id有值，表示redis缓存丢失，重新写入
        if($click_type_id){
            set_redis_key_value($key, $click_type_id, 0, $prefix);
        }
    }

    if (!$click_type_id) {//若查询不到则执行插入操作
        $insert_data['click_type'] = $click_type;
        $insert_data['languages_code'] = $languages_code;
        $insert_data['countries_code'] = $countries_code;
        $insert_data['customer_id'] = $customer_id;
        $insert_data['click_number'] = 1;
        $res = zen_db_perform('fs_quotes_click_log', $insert_data);

        global $db;
        //获取插入数据的id，写入redis缓存中
        $res2 = $db->Execute('SELECT @@IDENTITY as click_type_id');
        $insert_id = $res2->fields['click_type_id'];
        set_redis_key_value($key, $insert_id, 0, $prefix);
    } else {//若查询到数据则执行更新操作，点击量+1
        global $db;
        $sql = "update fs_quotes_click_log set click_number=click_number+1 where id=" . $click_type_id;
        $res = $db->Execute($sql);
    }

    return $res;
}

?>
