<?php
function zen_get_customer_id_of_input_email($email){
global $db;
$sql= "select customers_id from customers where customers_email_address='". $email ."'";
$customer = $db->Execute($sql);
if($customer->fields['customers_id']){
return $customer->fields['customers_id'];
}else{
return false;
}
}

function zen_get_cpf_id_of_pwd($code,$cid){
  global $db;
  $pwd_find = $db->Execute("select cpf_id from customers_find_pwd where customers_id = '". (int)$cid ."' and code ='". $code ."' ");
  return $pwd_find->fields['cpf_id'];
}

function zen_get_password_status($cpf_id) {
  global $db;
  $pwd_find = $db->Execute("select status from customers_find_pwd where cpf_id = '". $cpf_id ."' ");
  return $pwd_find->fields['status'];
}

function zen_get_password_find_time($cpf_id) {
  global $db;
  $pwd_find = $db->Execute("select addtime from customers_find_pwd where cpf_id = '". $cpf_id ."' ");
  return $pwd_find->fields['addtime'];
}

function zen_get_customers_id_of_email($email){
global $db;
$customer = $db->Execute("select customers_id from customers where customers_email_address =  '". $email ."' ");
return $customer->fields['customers_id'];
}

function zen_get_order_main_where_sql($order_id){
    global $db;
    if (fs_orders_products_is_main($order_id)) {
        $order_list = $db->getAll("select orders_id from orders where main_order_id = '".$order_id."'");
        if($order_list){
            $order_str = "";
            foreach($order_list as $v){
                $order_str .= $v['orders_id'].",";
            }
            $order_str = substr($order_str,0,-1);
        }
    }

    if($order_str){

        $where = " where orders_id  in (" . $order_str . ")";

    }else{
        $where = " where orders_id = '" . (int)$order_id . "'";
    }
    return $where;
}


function zen_get_order_products_for_customers($oid){
global $db;
$where = zen_get_order_main_where_sql($oid);
$wishlist_attr = array();
$sql = " select orders_products_id,products_id,products_name,products_quantity,products_price,final_price from orders_products 
                 ".$where;
$products_attr = $db->Execute($sql);

		while (!$products_attr->EOF){
			$wishlist_attr [] = array(
					'pid'=>$products_attr->fields['products_id'],
			        'opid'=>$products_attr->fields['orders_products_id'],
			        'name'=>$products_attr->fields['products_name'],
			        'qty'=>$products_attr->fields['products_quantity'],
			        'products_price'=>$products_attr->fields['products_price'],
			        'final_price'=>$products_attr->fields['final_price'],
					);
			$products_attr->MoveNext();
		}
		return $wishlist_attr;
}

function zen_get_orders_products_attributes($opid){
global $db;
$order_attr = array();
$sql ="select  products_options,products_options_values,options_values_price,price_prefix,products_options_id,products_options_values_id 
       from orders_products_attributes 
       where orders_products_id=".$opid;
$order = $db->Execute($sql);
while (!$order->EOF){
			$order_attr [] = array(
					'products_options'=>$order->fields['products_options'],
			        'products_options_values'=>$order->fields['products_options_values'],
			        'oid'=>$order->fields['products_options_id'],
			        'vid'=>$order->fields['products_options_values_id'],
			        'options_values_price'=>$order->fields['options_values_price'],
			        'price_prefix'=>$order->fields['price_prefix'],
					);
			$order->MoveNext();
		}
		return $order_attr;
}

function zen_get_order_product_length($opid){
global $db;
$product_length = array();
$sql = "select price_prefix,length_price,length_name,products_prid
        from order_product_length
        where orders_products_id =".$opid;
$length = $db->Execute($sql);
while (!$length->EOF){
			$product_length [] = array(
					'price_prefix'=>$length->fields['price_prefix'],
			        'length_price'=>$length->fields['length_price'],
			        'length_name'=>$length->fields['length_name'],
					);
			$length->MoveNext();
		}
 return $product_length;
}

function zen_get_order_product_length_price($oid,$pid){
global $db;
$product_length = array();
$length = $db->Execute("select price_prefix,length_price from order_product_length where orders_id = '". $oid ."' and orders_products_id = ".$pid);
while (!$length->EOF){
			$product_length [] = array(
					'price_prefix'=>$length->fields['price_prefix'],
			        'length_price'=>$length->fields['length_price'],
					);
			$length->MoveNext();
		}
 return $product_length;
}
 function zen_get_products_model($products_id) {
    global $db;
    $check = $db->Execute("select products_model
                    from " . TABLE_PRODUCTS . "
                    where products_id='" . $products_id . "'");

    return $check->fields['products_model'];
  }



function zen_get_all_customers_to_customers($main_customer){
    global $db;
    $follow_customer = array();
    if((int)$main_customer){
		//在新的关联数据表中找关联账号
		$customer_num = fs_get_data_from_db_fields('customers_number_new','customers','customers_id='.(int)$main_customer,'limit 1');
		//用客户编号去公司对应客户关系表中找出该客户对应的公司
		$company_num = fs_get_data_from_db_fields('company_number','manage_customer_company_to_customers','customers_number_new="'.$customer_num.'"','limit 1');
		//在通过公司去找所有关联的客户
		if($company_num){
			$result = $db->Execute("SELECT `customers_number_new` FROM `manage_customer_company_to_customers` WHERE company_number='".$company_num."'");
			while(!$result->EOF){
				$customer_id = fs_get_data_from_db_fields('customers_id','customers','customers_number_new="'.trim($result->fields['customers_number_new']).'"','limit 1');
				if($customer_id){
					$follow_customer[] = $customer_id;
				}
				$result->MoveNext();
			}
		}
    }
	return $follow_customer;
}

// fairy 2018.11.30 获取用户可以访问的订单数组
function get_customer_can_visit_orders(){
    global $db;
    $customers_to_customers = zen_get_all_customers_to_customers($_SESSION['customer_id']);
    if(is_array($customers_to_customers) && sizeof($customers_to_customers) > 1){
        $orders_type_order_and = "  customers_id in (".join(',',$customers_to_customers).")  ";
    }else {
        $orders_type_order_and = "  customers_id = '".$_SESSION['customer_id']."' ";
    }
    $res_orders = $db->Execute("select orders_id from ".TABLE_ORDERS." where ".$orders_type_order_and  );
    if ($res_orders->RecordCount()){
        while (!$res_orders->EOF){
            $orders_arr[] = $res_orders->fields['orders_id'];
            $res_orders->MoveNext();
        }
    }
    return $orders_arr;
}

/**
 * 获取支付方式的有效支付时间设置
 * add by rebirth
 * 2019/08/14
 *
 * @param $code
 * @return array
 */
function set_payment_over_time($code){
    $allOvertime = [
        'payeezy'  => [  //  美国信用卡支付 Credit/Debit Card 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'globalcollect'  => [  //新加坡信用卡支付  Credit/Debit Card 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'paypal'   => [  //  PayPal 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'ideal'    => [  //  iDEAL 5个工作日
            'd' => 5,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'sofort'   => [  //  SOFORT 5个工作日
            'd' => 5,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'enets'    => [  //  eNETS 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'yandex'   => [  //  YANDEX 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'webmoney' => [  //  WEBMONEY 30分钟
            'd' => 2,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'hsbc'     => [  //  Bank Transfer 7个工作日
            'd' => 7,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'purchase' => [  //  Purchase Order 7个工作日
            'd' => 7,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'alfa'     => [  //  俄罗斯对公支付 15个工作日
            'd' => 15,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'echeck'   => [  //  echeck 7个工作日
            'd' => 7,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'default'  => [  //  未匹配上的设置，直接超时
            'd' => 0,
            'h' => 0,
            'm' => 0,
            's' => 0,
        ],
    ];
    $code = strtolower($code);
    if (!isset($allOvertime[$code])) {
       $code = "default";
    }
    return $allOvertime[$code];
}

/**
 * 获取指定支付方式的有效支付时间
 * add by rebirth
 * 2019/08/14
 * @param $code string 支付方式code
 * @return array
 */
function get_payment_over_time($code)
{
    $overtime = set_payment_over_time($code);
    if (!isset($overtime['s'])){
        $overtime['s'] = translate_work_to_nature($overtime['d']) + $overtime['h'] * 3600 + $overtime['m'] * 60;
    }
    return $overtime;
}


/**
 * 获取支付方式的提醒支付时间设置
 * add by rebirth
 * 2019/09/06
 *
 * @param $code
 * @return array
 */
function set_payment_notice_time($code){
    $allNoticeTime = [
        'payeezy'  => [  //  美国信用卡支付 Credit/Debit Card 30分钟
            'd' => 1,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'globalcollect'  => [  //新加坡信用卡支付  Credit/Debit Card 30分钟
            'd' => 1,  //单位是工作日
            'h' => 0,
            'm' => 0,
        ],
        'paypal'   => [  //  PayPal 30分钟
            'd' => 1,
            'h' => 0,
            'm' => 0,
        ],
        'ideal'    => [  //  iDEAL 5个工作日
            'd' => 4,
            'h' => 0,
            'm' => 0,
        ],
        'sofort'   => [  //  SOFORT 5个工作日
            'd' => 4,
            'h' => 0,
            'm' => 0,
        ],
        'enets'    => [  //  eNETS 30分钟
            'd' => 1,
            'h' => 0,
            'm' => 0,
        ],
        'yandex'   => [  //  YANDEX 30分钟
            'd' => 1,
            'h' => 0,
            'm' => 0,
        ],
        'webmoney' => [  //  WEBMONEY 30分钟
            'd' => 1,
            'h' => 0,
            'm' => 0,
        ],
        'hsbc'     => [  //  Bank Transfer 7个工作日
            'd' => 6,
            'h' => 0,
            'm' => 0,
        ],
        'purchase' => [  //  Purchase Order 7个工作日
            'd' => 6,
            'h' => 0,
            'm' => 0,
        ],
        'alfa'     => [  //  俄罗斯对公支付 15个工作日
            'd' => 14,
            'h' => 0,
            'm' => 0,
        ],
        'echeck'   => [  //  echeck 7个工作日
            'd' => 6,
            'h' => 0,
            'm' => 0,
        ],
        'default'  => [  //  未匹配上的设置，直接超时
            'd' => 0,
            'h' => 0,
            'm' => 0,
            's' => 0,
        ],
    ];
    $code = strtolower($code);
    if (!isset($allNoticeTime[$code])) {
        $code = "default";
    }
    return $allNoticeTime[$code];
}

/**
 * 获取指定支付方式的有效支付时间
 * add by rebirth
 * 2019/09/06
 * @param $code string 支付方式code
 * @return array
 */
function get_payment_notice_time($code)
{
    $overtime = set_payment_notice_time($code);
    if (!isset($overtime['s'])){
        $overtime['s'] = translate_work_to_nature($overtime['d']) + $overtime['h'] * 3600 + $overtime['m'] * 60;
    }
    return $overtime;
}

/**
 * add by rebirth
 * 2019/08/14
 * @param $id int  主单id
 * @param $code string  支付方式
 * @return boolean
 */
function orders_overtime($id, $code)
{
    if ( !defined('USE_AUTOMATIC_CANCEL_ORDER') || !USE_AUTOMATIC_CANCEL_ORDER){
        return true;
    }
    //只有当给定有效时间时才执行失效流程
    $ret = false;
    $timeCanPay = get_payment_over_time($code)['s'];
    $timeCanNotice = get_payment_notice_time($code)['s'];
    if ($timeCanPay && $timeCanNotice) {
        $customerId = (int)$_SESSION['customer_id'];
        $order =  fs_get_one_data(TABLE_ORDERS, " orders_id= " . $id . " and customers_id=" . $customerId, "orders_status,customers_id,payment_link");
        //只有当订单存在且可以修改的情况下更新时间
        if (zen_not_null($order) && ($order['orders_status'] == '1') && !$order['payment_link']) { //剔除补款订单
            $res = set_cancel_order_key($id);
            //设置失败表示别的程序正在修改
            if ($res) {
                $time = time();
                if (
                    in_array($order['customers_id'],['179576','165132','208679','163833','186268']) || //设定正式站测试账号
                    (defined("FS_TEST_SERVICE") && FS_TEST_SERVICE === true) //设定测试站测试时间
                ){
                    $timeCanPay = 300;
                    $timeCanNotice = 240;
                }
//                selectRedisDB(2);
//                set_redis_key_value($id . "_orders_payment_module_code",$code,60);
//                selectRedisDB(0);
                $overTimeInfo =    fs_get_one_data(TABLE_ORDERS_OVERTIME, "orders_id= " . $id);
                //有则更新，无则新增
                if (zen_not_null($overTimeInfo['orders_id'])) {
                    global $db;
                    $db->Execute("DELETE FROM ".TABLE_ORDERS_OVERTIME." WHERE orders_id=" . $id);
                }
                $data = [
                    [
                        'orders_id' => $id,
                        'addtime'   => $time + (int)$timeCanPay,
                        'num'       => 0,
                        'type'      => 1,
                        'languages_code'=>$_SESSION["languages_code"]
                    ],
                    [
                        'orders_id' => $id,
                        'addtime'   => $time + (int)$timeCanNotice,
                        'num'       => 0,
                        'type'      => 2,
                        'languages_code'=>$_SESSION["languages_code"]
                    ]
                ];
                zen_db_inserts(TABLE_ORDERS_OVERTIME,$data);
                del_cancel_order_key($id);
                $ret = true;
            }
        }
    }
    return $ret;
}

/**
 * 针对订单超时流程，判断订单在进行支付时状态是否可以变更,若可以，则设置排他锁
 * @param $order_id
 * @return boolean
 * @author rebirth
 * @date 2019-08-16
 *
 */
function can_change_order_status($order_id)
{
    $can = true;
    $customerId = (int)$_SESSION['customer_id'];
    $order =   fs_get_one_data(TABLE_ORDERS, " orders_id= " . $order_id . " and customers_id=" . $customerId, "orders_status");
    //只有当订单存在且可以修改的情况下更新时间
    if (zen_not_null($order) && ($order['orders_status'] == '5')) {
        $can = false;
    }
    return $can;
}

/**
 * 订单 取消流程删除排他锁
 * @param $order_id
 * @author rebirth
 * @date 2019-08-16
 */
function del_cancel_order_key($order_id)
{
    $key = 'overtime--' . $order_id;
    selectRedisDB(2);
    $res = del_redis_by_key($key);
    if (!$res){
        error_log(date('Y-m-d H:i:s') . "\n  ERROR: 订单锁删除失败".time()." \n order_id: $order_id \n\n",
            3, str_replace('cache', '', DIR_FS_SQL_CACHE) . 'debug/delCancelOrderKey.log');
    }
    selectRedisDB(0);
}

/**
 * 订单 取消流程设置排他锁
 * @param $order_id
 * @return boolean
 * @author rebirth
 * @date 2019-08-16
 */
function set_cancel_order_key($order_id)
{
    $key = 'overtime--' . $order_id;
    selectRedisDB(2);
    $res = setnx_redis_key_value($key, $key);
    if ($res){  //设置成功了   设置30秒后过期
        set_redis_key_expire($key,10);
    }
    selectRedisDB(0);
    return  true;
//    return $res;
}


/**
 * 讲工作日转换成自然天数并转换成时间戳
 * add by rebirth
 * 2019/08/14
 * @param $days
 * @return int
 */
function translate_work_to_nature($days)
{
    $days = abs((int)$days);
    if (!$days) {  //只计算天以上的时间(目前除了天就是分钟,不涉及小时)
        return 0;
    }
    //设置为美国洛杉矶的时区
    date_default_timezone_set('America/Los_Angeles');
    $weekNum = date('w');
    $weekNum = $weekNum ?: 7;
    $natureWeek = floor($days / 5);
    $lastDay = $days % 5;
    if ($weekNum >= 6) {
        $natureTimestamps = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - time() + (7 - $weekNum + $lastDay + $natureWeek * 7) * 86400;
    } else if (($weekNum + $lastDay) <= 5) {
        $natureTimestamps = ($lastDay + $natureWeek * 7) * 86400;
    } else {
        $natureTimestamps = ($lastDay + $natureWeek * 7 + 2) * 86400;
    }
    return $natureTimestamps;
}

/**
 * 支付成功后，订单状态已被改为已支付，则删除orders_overtime里的数据，并删除排他锁
 * add by rebirth
 * 2019/08/14
 *
 * @param $main_id
 */
function del_order_key_for_payment($main_id)
{
    global $db;
    $db->Execute('DELETE FROM  orders_overtime WHERE orders_id = ' . $main_id);
    del_cancel_order_key($main_id);
}

/**
 * 获取指定支付方式在checkout_success页面展示的与限时支付有关的提示语
 * add by rebirth
 * 2019/08/16
 * @param $code string 支付方式code
 * @return string
 */
function get_payment_notice_string($code)
{
    $language = $_SESSION['languages_code'];
    $str = get_payment_notice_string_notice_time($code);
    switch ($language) {
        case "jp":
            $str = $str . get_payment_notice_string_by_payment($code)  . FS_ORDERS_OVERTIMES_04;
            break;
        default:
            $str = get_payment_notice_string_by_payment($code) . $str . '. ' . FS_ORDERS_OVERTIMES_04;
    }
    return $str;
}

/**
 * 获取指定支付方式在checkout_success页面展示的与限时支付有关的提示语中的  具体时间
 * add by rebirth
 * 2019/08/16
 * @param $code string 支付方式code
 * @param $type string 展示的时间
 * @return string
 */
function get_payment_notice_string_notice_time($code,$type = "payment")
{
    $overtime = set_payment_over_time($code);
    if ($type != "payment" ){
        $noticeTime = set_payment_notice_time($code);
        $overtime["m"] = $overtime["m"] - $noticeTime["m"];
        if ($overtime["m"] < 0 ){
            $overtime["m"] += 60;
            $overtime["h"] -= 1;
        }
        $overtime["h"] = $overtime["h"] - $noticeTime["h"];
        if ($overtime["h"] < 0 ){
            $overtime["h"] += 60;
            $overtime["d"] -= 1;
        }
        $overtime["d"] = $overtime["d"] - $noticeTime["d"];
        if ($overtime["h"] < 0 ){
            $overtime = [
                "d"=>0,
                "h"=>0,
                "m"=>0,
            ];
        }
    }
    $space = " ";
    // $str  德语的po后缀   $timeStr 工作日以及分钟的单复数  (ps:分钟主要用于测试,目前线上都是以天为单位)
    if ($overtime['d']) {
        $str = ($code == "purchase") ? FS_ORDERS_OVERTIMES_03_PO : FS_ORDERS_OVERTIMES_03;
        switch ($_SESSION['languages_code']){
            case "jp":
                    $timeStr = FS_ORDERS_OVERTIMES_31;
                    $space = "";
                break;
            case "ru":
                    $bit = $overtime['d'] % 10;
                    if (in_array($bit, [5, 6, 7, 8, 9, 0]) || in_array($overtime['d'],[11, 12, 13, 14])){
                        $timeStr = FS_ORDERS_OVERTIMES_35;
                    }else if (in_array($bit, [2, 3, 4])){
                        $timeStr = FS_ORDERS_OVERTIMES_34;
                    }else{
                        $timeStr = FS_ORDERS_OVERTIMES_33;
                    }
                break;
            default:
                if ($overtime['d'] >= 1){
                    if($_SESSION['languages_code']=="fr" && $overtime['d'] == 1){
                        $timeStr = FS_ORDERS_OVERTIMES_31;
                    }elseif (in_array($_SESSION['languages_code'],array('mx','es')) && $overtime['d'] == 1){
                        $timeStr = FS_ORDERS_OVERTIMES_32;
                    }else{
                        $timeStr = FS_ORDERS_OVERTIMES_33;
                    }
                }else{
                    $timeStr = FS_ORDERS_OVERTIMES_32;
                }
                break;
        }
        return $overtime['d'] . $space . $timeStr . $str;
    } else {
        $str = ($code == "purchase") ? FS_ORDERS_OVERTIMES_02_PO : FS_ORDERS_OVERTIMES_02;
        switch ($_SESSION['languages_code']){
            case "jp":
                $timeStr = FS_ORDERS_OVERTIMES_30;
                $space = "";
                break;
            case "ru":
                $bit = $overtime['m'] % 10;
                if (in_array($bit, [5, 6, 7, 8, 9, 0]) || in_array($overtime['m'],[11, 12, 13, 14])){
                    $timeStr = FS_ORDERS_OVERTIMES_32;
                }else if (in_array($bit, [2, 3, 4])){
                    $timeStr = FS_ORDERS_OVERTIMES_31;
                }else{
                    $timeStr = FS_ORDERS_OVERTIMES_30;
                }
                break;
            default:
                if ($overtime['m'] > 1){
                    $timeStr = FS_ORDERS_OVERTIMES_31;
                }else{
                    $timeStr = FS_ORDERS_OVERTIMES_30;
                }
                break;
        }
        return $overtime['m'] . $space . $timeStr . $str;
    }
}

/**
 * 获取指定支付方式在checkout_success页面展示的与限时支付有关的提示语中的  提示类型
 * add by rebirth
 * 2019/08/16
 * @param $code string 支付方式code
 * @return string
 */
function get_payment_notice_string_by_payment($code)
{
    switch ($code) {
        case "purchase":
            return FS_ORDERS_OVERTIMES_05;
            break;
        default:
            return FS_ORDERS_OVERTIMES_01;
    }
}

/**
 * 获取指定支付方式在订单列表与详情页页面展示的倒计时
 * add by rebirth
 * 2019/08/19
 * @param $timeless int 剩余可支付的秒数
 * @return string  剩余可支付的时间的字符串
 */
function get_order_countdowm_str($timeless)
{
    if ($timeless <= 0) {
        $timeless = 0;
    }
    $timeless = abs((int)$timeless);
    if ($timeless > 86400) {
        $d = $timeless / 86400;
        $less = $timeless % 86400;
        $h = $less / 3600;
        $str1 = floor($d) . FS_ORDERS_OVERTIMES_14;
        $str2 = floor($h) . FS_ORDERS_OVERTIMES_15;
    } else {
        if ($timeless == "86400") {
            $timeless -= 1;
        }
        $h = $timeless / 3600;
        $less = $timeless % 3600;
        $m = $less / 60;
        $str1 = floor($h) . FS_ORDERS_OVERTIMES_15;
        $str2 = floor($m) . FS_ORDERS_OVERTIMES_16;
    }
    $language = $_SESSION['languages_code'];
    switch ($language) {
        case "jp":
            $str = $str1 . $str2 . FS_ORDERS_OVERTIMES_13;
            break;
        case "de":
            $str = FS_ORDERS_OVERTIMES_13 . " " . $str1 .' '.  $str2;
            break;
        default:
            $str = FS_ORDERS_OVERTIMES_13 . " " . $str1 . '. ' .  $str2;
    }
    return $str;
}

/**
 * 支付方式的code,转换为页面上实际展示你的内容
 * add by rebirth
 * 2019/08/22
 * @param $code
 * @param $country_id
 * @return string
 */
function translate_payCode_to_title($code,$country_id = 0){
    $map = [
      'payeezy'=>FIBER_CHECK_CREDIT,
      'globalcollect'=>FIBER_CHECK_CREDIT,
      'paypal'=>PAYMENT_PAYPAL,
      'echeck'=>PAYMENT_ECHECK,
      'hsbc'=>[
          'default'=>PAYMENT_BANK,
          'au'=>PAYMENT_BANK_AU
      ],
      'purchase'=>FS_CHECKOUT_NEW34,
      'bpay'=>FS_CHECKOUT_NEW35,
      'eNETS'=>FS_CHECKOUT_NEW36,
      'YANDEX'=>FS_CHECKOUT_NEW37,
      'WEBMONEY'=>FS_CHECKOUT_NEW38,
      'iDEAL'=>FS_CHECKOUT_NEW39,
      'SOFORT'=>FS_CHECKOUT_NEW40,
      'alfa'=>FS_CHECKOUT_NEW_CASHLESS,
    ];
    if ($code == "hsbc"){
        if(in_array($country_id,array(13,153))) {
            return $map['hsbc']['au'];
        }else{
            return $map['hsbc']['default'];
        }
    }
    if (zen_not_null($map[$code])){
        return $map[$code];
    }
    return "";
}

/**
 * 拼接订单超时提示2
 * add by rebirth
 * 2019/08/22
 * @param $code
 * @param $country_id
 * @return string
 */
function get_order_notice_02_str($code,$country_id){
    $language = $_SESSION['languages_code'];
    switch ($language) {
        case "jp":
            $str = translate_payCode_to_title($code,$country_id) . FS_ORDERS_OVERTIMES_20 . FS_ORDERS_OVERTIMES_21;
            break;
        case "de":
            $str = FS_ORDERS_OVERTIMES_20 ." ". translate_payCode_to_title($code,$country_id) . " " . FS_ORDERS_OVERTIMES_21;
            break;
        default:
            $str = FS_ORDERS_OVERTIMES_20 ." ". translate_payCode_to_title($code,$country_id) . "! " . FS_ORDERS_OVERTIMES_21;
    }
    return $str;
}