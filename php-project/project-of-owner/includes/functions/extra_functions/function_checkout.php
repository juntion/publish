<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21
 * Time: 11:01
 */
function Address_format($data)
{
    if (!$data) {
        return array();
    }
    $address_book_id = $data['address_book_id'];
    $entry_company = $data['entry_company'] ? $data['entry_company'] . ", " : "";
    $entry_firstname = $data['entry_firstname'];
    $entry_lastname = $data['entry_lastname'];
    $entry_street_address = $data['entry_street_address'] ? $data['entry_street_address'] . ", " : "";
    $entry_suburb = $data['entry_suburb'] ? $data['entry_suburb'] . ", " : " ";
    $entry_postcode = $data['entry_postcode'] ? $data['entry_postcode'] . ", " : "";
    $entry_city = $data['entry_city'] ? $data['entry_city'] . " " : "";
    $entry_state = $data['entry_state'] ? $data['entry_state'] . " " : "";
    $entry_tax_number = $data['entry_tax_number'] ? ", " . $data['entry_tax_number'] : "";
    $entry_country_id = $data["entry_country"]['entry_country_id'];
    $entry_country_name = getCountryNameByCode($data["entry_country"]['entry_country_name']);
    $tel_prefix = $data["entry_country"]['tel_prefix'];
    $entry_code = $data["entry_country"]['country_code'];
    $company_type = $data['company_type'];
    $entry_telephone = $data['entry_telephone'] ? " (" . $tel_prefix . " " . $data['entry_telephone'] . ")" : "";
    $entry_zone_id = $data['entry_zone_id'];
	if($entry_country_id ==223){
		$info_entry_state =zen_get_countries_us_states_code($data['entry_state']). " ";
	}else{
		$info_entry_state = $entry_state;
	}

    $address_title = $entry_firstname . " " . $entry_lastname . " " . $entry_telephone;
    $address_info = $entry_company . $entry_street_address . $entry_suburb . $entry_city . $info_entry_state . $entry_postcode . $entry_country_name . $entry_tax_number;

    return array(
        "address_title" => $address_title,
        "address_info" => $address_info,
        "address_book_id" => $address_book_id
    );
}

/** 获取结算页提示语
 * @param $order
 */
//偏远地区提示
function get_step_tips($order){
    $tips = '';
    $conuntry_id = $order->delivery['country_id'];
    $post_code = $order->delivery['postcode'];

    if($conuntry_id == 13 && check_au_remote_areas($post_code)){
        $tips = FS_SHIPPING_TIPS_TXT1;
    }
    return $tips;
}
//重货提示
function get_buck_tips($order,$local_buck,$delay_buck){
    $tips = '';
    $conuntry_id = $order->delivery['country_id'];
    $warehouse = $order->local_warehouse;
    $post_code = $order->delivery['postcode'];
    if($local_buck || $delay_buck){
        if(in_array($warehouse,array(40,71))){
            $tips = FS_SHIPPING_TIPS_TXT3;
            if (!in_array($conuntry_id,['223','172']) && $delay_buck){
                $tips = FS_SHIPPING_TIPS_TXT5;
            }
        }else if(in_array($warehouse,array(20,37))){
            $tips = FS_SHIPPING_TIPS_TXT2;
            if (!in_array($conuntry_id,['223','172']) && $delay_buck){
                $tips = FS_SHIPPING_TIPS_TXT4;
            }
            if($conuntry_id == 13 && $delay_buck){
                $tips = FS_SHIPPING_TIPS_TXT2;
            }
            if($warehouse == 20){
                $tips = FS_NEW_BUCK_TIP;
            }
        }

        if($conuntry_id == 13 && check_au_remote_areas($post_code)){
            $tips = FS_SHIPPING_TIPS_TXT2;
            if (!in_array($conuntry_id,['223','172']) && $delay_buck){
                $tips = FS_SHIPPING_TIPS_TXT4;
            }
        }
    }
    //特定国家不包邮不显示重货提示信息
    $country_code = $order->delivery['country']['iso_code_2'];;
    $not_shipping_free_countries = array('NZ','MY','ID','TH','PH','MM','LA','TL','KH','VN','BN');
    $tips = in_array($country_code,$not_shipping_free_countries) ? '' : $tips;
    return $tips;
}



/** 判断是否为澳洲偏远地区
 * @param $post_code
 * @return bool
 */
function check_au_remote_areas($post_code){

    global $db;
    //暂时判断为非偏远地区,后续若确定不需要此功能,可全局调整,并删除该funciton
    return false;
    if(empty($post_code)){
        return false;
    }
    $au_sql = "SELECT id FROM `shipping_au_code` WHERE value ='".$post_code."' AND type = 2 AND flag = 1";
    $au_ret = $db->Execute($au_sql);
    $check_flag = empty($au_ret->fields['id']) ? false : true;
    if(!$check_flag){
        $au_array = fs_get_data_from_db_fields_array(array('value'),'shipping_au_code','type = 0 AND flag = 1');
        $check_flag = check_au_zip_code($post_code,$au_array,',');
        if(!$check_flag){
            $au_array = fs_get_data_from_db_fields_array(array('value'),'shipping_au_code','type = 1 AND flag = 1');
            $check_flag = check_au_zip_code($post_code,$au_array,':');
        }
    }
    return $check_flag;
}

/**
 * 判断是否为欧洲偏远地区
 * @param $post_code 邮编
 * @param $countries 国家
 * @return bool
 */
function check_de_remote_areas($post_code, $countries){

    global $db;
    if(empty($post_code)){
        return false;
    }
    $post_code = str_replace(' ','',$post_code);

    $de_sql = "SELECT id FROM `shipping_de_code` WHERE postcode ='".$post_code."' AND country = '".$countries."' AND type = 1";
    $de_ret = $db->Execute($de_sql);
    $check_flag = empty($de_ret->fields['id']) ? false : true;
    if(!$check_flag && !in_array($countries,['PT','PL'])){
        $de_array = fs_get_data_from_db_fields_array(array('postcode'),'shipping_de_code','type = 1 AND country = "'.$countries.'"');
        $check_flag = check_spe_post_code($post_code,$de_array,'-');
    }
    return $check_flag;
}

/**
 * @param $zip_code 待验证的邮编
 * @param $post_array 邮编长字符串
 * @param $str_param 分割字符
 * @return bool
 */
function check_au_zip_code($zip_code,$post_array,$str_param){
    $check_flag = false;
    foreach ($post_array as $value){
        $val = $value[0];
        $val_array = explode($str_param,$val);
        foreach($val_array as $val_num){
            if(strpos($val_num,'-')) {
                $val_num = explode('-', $val_num);
                $val_start = $val_num[0];
                $val_end = $val_num[1];
                if ($zip_code >= $val_start && $zip_code <= $val_end) {
                    $check_flag = true;
                    break;
                }
            }else{
                if($zip_code == $val_num && !empty($val_num)){
                    $check_flag = true;
                    break;
                }
            }
        }
        if($check_flag){
            break;
        }
    }
    return $check_flag;
}

/**
 * 验证邮编是否在区间内
 * @param $code
 * @param $post_array
 * @param $str_param
 * @return bool
 */
function check_spe_post_code($code,$post_array,$str_param){
    $check_flag = false;
    foreach($post_array as $val_num){
        $val_num = is_array($val_num) ? $val_num[0] : $val_num;
        if(strpos($val_num,$str_param)) {
            $val_num = explode($str_param, $val_num);
            $val_start = $val_num[0];
            $val_end = $val_num[1];
            if ($code >= $val_start && $code <= $val_end) {
                $check_flag = true;
                break;
            }
        }else{
            if($code == $val_num && !empty($val_num)){
                $check_flag = true;
                break;
            }
        }
    }
    return $check_flag;
}

//税号验证接口--付费接口
function Check_vat($tax_number, $is_insert = false){
    // set API Endpoint and Access Key
    $endpoint = 'validate';
    $access_key = 'd57f6cf219a9ee2019c4d9f5e5913197';

// set VAT number
    $vat_number = $tax_number;

// Initialize CURL:
    $ch = curl_init('http://apilayer.net/api/'.$endpoint.'?access_key='.$access_key.'&vat_number='.$vat_number.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
    $json = curl_exec($ch);
    curl_close($ch);

// Decode JSON response:
    $validationResult = json_decode($json, true);

    $validationResult['query'];
    $validationResult['company_name'];
    $validationResult['company_address'];
// Access and use your preferred validation result objects
    if(isset($validationResult['error']) || !$validationResult['valid']){
        return false;
    }
    if($is_insert){
        $vat_data = array(
            'vat_num'           => $vat_number,
            'country_code'      => $validationResult['country_code'],
            'number'            => $validationResult['vat_number'],
            'company_name'      => $validationResult['company_name'],
            'company_address'   => $validationResult['company_address'],
            'create_time'       => 'now()',
            'update_time'       => 'now()'
        );
        zen_db_perform('fs_vat_number',$vat_data);
    }

    return true;
}

//税号验证
function vat_validate($tax_number,$country_id,$tax_is_code,$is_ireland = false){
    if (empty($tax_number)) {
        return false;
    }

    $tax_pre = substr($tax_number,0,2);
    //XQ20210421002 德国仓覆盖的欧盟国家税号验证：只需验证税号的真实性，不验证这个税号是否与所选的国家一致
    if(german_warehouse('country_number',$country_id)){
        $eu_allow_vat = ['AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','HU','IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE'];
        if(!in_array($tax_pre,$eu_allow_vat)){
            return false;
        }
    }else{
        switch($country_id){
            case 84://希腊税号开头是EL
                if($tax_pre != 'EL'){
                    return false;
                }
                break;
            case 141://摩纳哥验证的是法国税号
                if($tax_pre != 'FR'){
                    return false;
                }
                break;
            case 244://马恩岛验证的是英国税号
            case 222:
                $pre_demo = $is_ireland ? 'XI' : 'GB';
                if($tax_pre != $pre_demo){
                    return false;
                }
                break;
            default://一般国家的税号验证
                if ($tax_is_code != $tax_pre) {
                    return false;
                }
                break;
        }
    }

    //先调用本地VAT税号数据库，通过则不调用接口
    $vat_id = fs_get_data_from_db_fields('id','fs_vat_number',"vat_num = '".$tax_number."'");
    if(empty($vat_id)){
//        if($country_id != 81) {//使用免费的接口时，必须屏蔽德国的税号验证
            $checvat_res = Check_vat($tax_number, true);
            if (!$checvat_res) {
                return false;
            }
//        }
    }

    return true;
}

//税号验证--免费接口
function Check_vat_bak($tax_number,  $is_insert = false){
    if(empty($tax_number)){
        return false;
    }
    require DIR_WS_CLASSES . 'IXR_Library.inc.php';

    $client     = new IXR_Client('https://evatr.bff-online.de/');

    $UstId_1    = 'DE313377831';
    $UstId_2    = $tax_number;

    if (!$client->query('evatrRPC',$UstId_1,$UstId_2))
    {
        return false;
//        die('Ein Fehler ist aufgetreten -'.$client->getErrorCode().":".$client->getErrorMessage());
    }

    $outString = $client->getResponse();

    $index = strpos($outString,'ErrorCode');
    $code = substr($outString, $index+42,3);
    if($code != 200 && $code != 222)
    {
        return false;
    }

    if($is_insert){
        $vat_data = array(
            'vat_num'           => $tax_number,
            'country_code'      => '',
            'number'            => '',
            'company_name'      => '',
            'company_address'   => '',
            'create_time'       => 'now()',
            'update_time'       => 'now()'
        );
        zen_db_perform('fs_vat_number',$vat_data);
    }

    return true;
}

//获取税号格式
function getEUVatTips($code){
    switch ($code) {
        case 'LU':
        case 'DK':
        case 'FT':
        case 'FI':
        case 'SI':
        case 'HU':
            return $code.'12346578';
        case 'BE':
        case 'PL':
            return $code.'1234657890';
        case 'SK':
            return $code.'1111111111';
        case 'FR':
            return $code.'00123456789';
        case 'IT':
        case 'LV':
        case 'HR':
            return $code.'12346578901';
        case 'SE':
            return $code.'123465789012';
        case 'NL':
            return $code.'123465789B12';
        case 'IE':
            return $code.'1234657';
        case 'AT':
            return $code.'U12346578';
        case 'ES':
            return $code.'B12346578';
        default:
            return $code.'123465789';
    }
}

/**
 * @param $products
 * @param $warehouse
 * @param $country_code
 * @param array $en_us_data
 * @param bool $delayHasHeavy  判断订单中是否有重货
 * @return array
 */
function get_max_date($products,$warehouse,$country_code,$en_us_data=[],$delayHasHeavy=false)
{
    $delay_time = "";
    $max_time = array();
    if (!empty($products)) {
        foreach ($products as $k => $v) {
            $attr_arr=array();
            $buy_product_qty = $v['qty'];
            //if(check_product_is_pre_product((int)$v['id']) || check_product_is_attr_and_qty_delivery_time((int)$v['id'])){
                if($v['attributes']){ //checkout页面
                    foreach ($v['attributes'] as $vv){
                        if($vv['value']=="length"){
                            $attr_arr['length']=$vv['option'];
                        }else{
                            $attr_arr[] = $vv['value_id'];
                        }
                    }
                }

                if(empty($attr_arr) && $v['attribute']){
                     foreach ($v['attribute'] as $vv){
                         if($vv['value']=="length"){
                             $attr_arr['length']=$vv['option'];
                         }else{
                             $attr_arr[] = $vv['value_id'];
                         }
                     }//信用卡付款页面
                }
            //}
            if($v['heavy_tag']){
                $is_heavy = $v['heavy_tag'];
            }else{
                $heavy_info = get_heavy_products(array($v['id']),$warehouse);
                $is_heavy = $heavy_info['heavy_products_tag'][$v['id']] ? $heavy_info['heavy_products_tag'][$v['id']] : "";
            }
            $max_time[] = zen_get_products_instock_delivery_time((int)$v['id'], 0, $warehouse,$country_code,'','',$buy_product_qty,$attr_arr,$is_heavy,$en_us_data,$delayHasHeavy);
        }
        if (!empty($max_time)) {
            if($en_us_data['transport_time'] || in_array($en_us_data['shipping_method'], ['saturdaydeliveryzones','dhlsaturdayzones'])){
                $expression = FS_FOR_FREE_SHIPPING_GET_ARRIVE.' ';
            }else{
                $expression = FS_SHIP_ESTIMATED;
            }
            if (sizeof($max_time) == 1) {
                $max_time = $max_time[0];
                $max_time['date'] = $max_time['time'] ? $expression  . "<span class='fs-new-Fontweight600'>".$max_time['date']."</span>" : ucfirst(strtolower(FS_SHIP_TODAY));
            } else {
                $sort = array(
                    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                    'field' => 'time',       //排序字段
                );
                $arrSort = array();
                foreach ($max_time as $uniqid => $row) {
                    foreach ($row as $key => $value) {
                        $arrSort[$key][$uniqid] = $value;
                    }
                }
                if ($sort['direction']) {
                    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $max_time);
                }
                $max_time = $max_time[0];
                $max_time['date'] = $max_time['time'] ? $expression . "<span class='fs-new-Fontweight600'>" . $max_time['date']."</span>" : ucfirst(strtolower(FS_SHIP_TODAY));
            }
            $delay_time = $max_time['date'];
        }
    }
    return array("delay_time"=>$delay_time,"max_time"=> $max_time);
}
//仓库为美国或者是德国时 大于16点 不能为立马发货
function getLocalTime($warehouse,$country_code,$type=false,$is_reissue,$shipping_method,$local_data=[]){
    global $db;
    if($type){
        $text = FS_WAREHOUSE_AREA_4;
        $delay_time = FS_WAREHOUSE_AREA_5;
    }else{
        $delay_time = "";
        $text = FS_SHIP_SAME_DAY;
    }
    if(empty($warehouse)){
        return $text;
    }
    if ($shipping_method == 'selfreferencezones_selfreferencezones') {
        return FS_PICK_UP_WAREHOUSE;
    }
    $local_time = $text;
    //如果本地仓有库存，且超过当天截单时间交期+1
    $area = $db->Execute("select time_zone from country_time_zone where code='".strtoupper($country_code)."' limit 1");
    $area = $area->fields['time_zone'] ? $area->fields['time_zone'] : '';
    $add_time = getWarehouseDeliveryDeadline($warehouse, $country_code) ? 1 : 0;

    //遇到周末或姐家欸顺延
    $festival_day = get_festival_day($country_code);
    if($festival_day){
        $days = $festival_day;
    }else{
        $days = postponed_weekend(0,'',$country_code); //周末顺延
    }

    if (in_array($warehouse,[2,40,71]) && $is_reissue==4) { //国内直发加春节假
          $spring_days = get_spring_festival_holiday(); //春节假期
          if($spring_days){
              $days = postponed_weekend($spring_days,$area,$country_code);
          }
    }
    $shipping_method_arr = explode('_',$shipping_method);
    $shipping_method = $shipping_method_arr[0];
    $has_local_instock = false;
    if($is_reissue == 12){
        $has_local_instock = true;
    }
    $transport_time = zen_get_transport_limitation($warehouse,$shipping_method,$country_code,$has_local_instock,$local_data);
    if($transport_time){
        $days = get_specific_date_of_days($transport_time+$add_time,2,$days)+$days;
    }else{
        $days = get_specific_date_of_days($add_time,2,$days)+$days;
        $delay_time = FS_SHIP_ESTIMATED;
    }

    if ($days) {
        $days += get_festival_day($country_code,$days);
        $days = postponed_weekend($days,$area,$country_code);
        $local_time = $delay_time . " " .get_date_time_format($days,$country_code);
    }

    return $local_time;
}

/**
 * 新版po的type与老版对照
 *
 * @param $type
 * @return int|mixed
 */
function typeToApply($type){
    $applies = [
        '2'=>2,
        '3'=>13,
        '5'=>17,
    ];
    return isset($applies[$type]) ? $applies[$type] : 0;
}

/**
 * 新版po信息获取
 *
 * @return array
 */
function getPurchaseInfo(){
    return (new \App\Services\Payments\PurchaseService())->getPurchaseInfo();
    $parent_id = "";
    $is_delete = 0;
    $customer_pay_day = "";
    $apply_type = "";
    $po_flag = array();
    $Po_address_arr = array();
    $apply_money = 0;
    $apply_money_currrncy = "USD";
    if(empty($_SESSION['customer_id'])){
        return array(
            'from'=>"old",
            "customer_pay_day" => $customer_pay_day ? $customer_pay_day:"",
            "apply_type" => $apply_type,
            "Po_address_arr" => $Po_address_arr,
            "is_delete" => $is_delete,
            "po_flag" => $po_flag,
            "id" => 0,
            "parent_id" => $parent_id,
            "apply_money" => $apply_money,
            'all_apply_money' => 0,
            'symbol_right' => '',
            'currency_symbol' => "US$",
            'currency_symbol_code' => "USD",
            'delay_pay' => false,
            'admin' =>0,
            "apply_money_currrncy" => $apply_money_currrncy
        );
    }
    $customer_NO = $create_order = $id = $pid = 0;
    //账期地址
    $customer_details_info = fs_get_data_from_db_fields_array(array("customers_level", "customers_number_new"), "customers", "customers_id=" . $_SESSION['customer_id'], "");
    $customer_level = $customer_details_info[0][0];
    $customer_num = $customer_details_info[0][1];
    $customer_num_new = $customer_level . $customer_num;
    if (!empty($customer_num)) {
        $where= "(customers_NO='" . $customer_num . "' or customers_NO='" . $customer_num_new . "') and status=1 and is_delete = 0  and   type in (2,3,4,5)  ";
        $fields = 'id,parent_id,is_delete,type,customers_NO,order_payment,address_book_id,currencies_id,apply_money,apply_moneys,admin';
        $parent_id = fs_get_one_data(TABLE_PRODUCTS_INSTOCK_SHIPPING_PAYMENT_INVOICE, $where ,$fields);
        if (zen_not_null($parent_id)){ //子账户
            $customer_NO = $parent_id['customers_NO'];
            $create_order = 0;
            $id = $parent_id['id'];
            $pid = $parent_id['parent_id'];
            if (($parent_id['type'] == 5)){
                $where = " id=" . $parent_id['parent_id'] . " and status = 1 and type in (2,3,4) ";
                $parent_id = fs_get_one_data(TABLE_PRODUCTS_INSTOCK_SHIPPING_PAYMENT_INVOICE, $where ,$fields);
                $create_order = 6;
            }
        }
    }
    if (zen_not_null($parent_id) && ($parent_id['is_delete'] == 0)){  //在新表里获取到数据
        $pay_id = $parent_id['order_payment'];
        $apply_type = typeToApply($parent_id['type']);
        $customer_pay_day = fs_get_data_from_db_fields("payment_method", "payment_method", "id=" . $pay_id, "");
        $apply_money = [
            [$parent_id['currencies_id'],$parent_id['apply_money']]
        ];
        $all_apply_money =  $parent_id['apply_moneys'];
        $apply_money_currrncy = "USD";
        if($apply_money[0][0]){
            $apply_money_currrncy =fs_get_data_from_db_fields('code','currencies','currencies_id ='.$parent_id['currencies_id'],'');
        }
        $apply_currency_id =$apply_money[0][0]?$apply_money[0][0]:0;
        if($apply_currency_id == 0 || $apply_currency_id == 1){
            $currency_symbol = "US$";
            $currency_symbol_code = "USD";
        }else{
            $getCurrencies = fs_get_one_data('currencies','currencies_id ='.$apply_currency_id,'code,symbol_right,symbol_left');
            $currency_symbol_code = isset($getCurrencies['code'])?$getCurrencies['code']:"USD";
            $symbol_right = isset($getCurrencies['symbol_right'])?$getCurrencies['symbol_right']:"";
            if(empty($symbol_right)){
                $currency_symbol = isset($getCurrencies['symbol_left'])?$getCurrencies['symbol_left']:"US$";
            }
        }

        $delay_pay = false;
        $delay_where = " parent_id=".$parent_id['id']." and type in (2,3,4,5) and is_delete = 0 and is_payment <> 1 and payable_date > 2000 and payable_date <  '" .date("Y-m-d",time())."'";
        $delay =  fs_get_one_data('products_instock_shipping_payment_invoice_orders',$delay_where,"parent_id");
        if (zen_not_null($delay)){
            $delay_pay  = true;
        }
        return array(
            'from'=>"new",
            "customer_pay_day" => $customer_pay_day ? $customer_pay_day:"",
            "apply_type" => $apply_type ? $apply_type : 0,
            "Po_address_arr" => array(),  //新版去掉了地址
            "is_delete" => $parent_id['is_delete'],
            "po_flag" => [[$customer_NO, $parent_id['order_payment'], $apply_type, $create_order]],
            "parent_id" => [[$id,$pid]],
            "id"=> $parent_id['id'],
            "apply_money" => $apply_money,
            "delay_pay" => $delay_pay,
            "admin"=>isset($parent_id['admin'])?$parent_id['admin']:0,
            'all_apply_money' => isset($all_apply_money) ? $all_apply_money : 0,
            'symbol_right' => isset($symbol_right) ? $symbol_right : '',
            'currency_symbol_code' => isset($currency_symbol_code) ? $currency_symbol_code : 'USD',
            'currency_symbol' => isset($currency_symbol) ? $currency_symbol : "US$",
            "apply_money_currrncy" => $apply_money_currrncy
        );
    }else{
        $info =  getPurchaseInfoOld($customer_num,$customer_num_new);
        $info['Po_address_arr'] = [];
        return $info;
    }
}

/**
 * 旧版判断是否是账期客户
 *
 * @param $customer_num
 * @param $customer_num_new
 * @return array
 */
function getPurchaseInfoOld($customer_num,$customer_num_new){
    $parent_id = "";
    $is_delete = 0;
    $Po_address_id = "";
    $customer_pay_day = "";
    $apply_type = "";
    $po_flag = array();
    $Po_address_arr = array();
    $apply_money = 0;
    $apply_money_currrncy = "USD";
    $delay_pay = false;
    if (!empty($customer_num)) {
        $parent_id = fs_get_data_from_db_fields_array(array('id', 'parent_id'), 'products_instock_shipping_apply', "(customers_NO='" . $customer_num . "' or customers_NO='" . $customer_num_new . "') and status = 1 and is_delete = 0 and (apply_type in (2,13,17) and (create_order = 0 or create_order = 6))", '');
        $po_flag = fs_get_data_from_db_fields_array(array("customers_NO", "order_payment", "apply_type", 'create_order'), "products_instock_shipping_apply"
            , "(customers_NO='" . $customer_num . "' or customers_NO='" . $customer_num_new . "') and status=1 and (apply_type in (2,13,17) and (create_order = 0 or create_order = 6)) ", "order by id desc limit 1");
//        $pay_id = $po_flag[0][1] ? $po_flag[0][1] : 0;
        $apply_type = $po_flag[0][2] ? $po_flag[0][2] : 0;
//        $customer_pay_day = fs_get_data_from_db_fields("payment_method", "payment_method", "id=" . $pay_id, "");
    }
    if ($parent_id && !empty($parent_id)) {
        if ($parent_id[0][1] == 0) {
            $id = $parent_id[0][0];
            $is_delete = fs_get_data_from_db_fields("is_delete", "products_instock_shipping_apply", "id=" . $parent_id[0][0], "");  //主客户的记录数据是否有效
            $Po_address_id = fs_get_data_from_db_fields('address_book_id', 'products_instock_shipping_apply', "id =" . $parent_id[0][0], '');
            $apply_money =fs_get_data_from_db_fields_array(array('currencies_id','apply_money','apply_moneys','apply_time','order_payment'),'products_instock_shipping_apply', "id =".$parent_id[0][0],'');
        } else {
            $id = $parent_id[0][1];
            $is_delete = fs_get_data_from_db_fields("is_delete", "products_instock_shipping_apply", "id=" . $parent_id[0][1], "");  //通过parent_id查主客户的记录数据是否有效
            $Po_address_id = fs_get_data_from_db_fields('address_book_id', 'products_instock_shipping_apply', "id =" . $parent_id[0][1], '');
            $apply_money =fs_get_data_from_db_fields_array(array('currencies_id','apply_money','apply_moneys','apply_time','order_payment'),'products_instock_shipping_apply', "id =".$parent_id[0][1],'');
        }
        $pay_id = $apply_money[0][4] ? $apply_money[0][4] : 0;
        $customer_pay_day = fs_get_data_from_db_fields("payment_method", "payment_method", "id=" . $pay_id, "");
        if($apply_money[0][0]){
            $apply_money_currrncy =fs_get_data_from_db_fields('code','currencies','currencies_id ='.$apply_money[0][0],'');
        }
        $apply_currency_id =$apply_money[0][0]?$apply_money[0][0]:0;
        $all_apply_money = $apply_money[0][2];
        if($apply_currency_id == 0 || $apply_currency_id == 1){
            $currency_symbol = "US$";
            $currency_symbol_code = "USD";
        }else{
            $getCurrencies = fs_get_one_data('currencies','currencies_id ='.$apply_currency_id,'code,symbol_right,symbol_left');
            $currency_symbol_code = isset($getCurrencies['code'])?$getCurrencies['code']:"USD";
            $symbol_right = isset($getCurrencies['symbol_right'])?$getCurrencies['symbol_right']:"";
            if(empty($symbol_right)){
                $currency_symbol = isset($getCurrencies['symbol_left'])?$getCurrencies['symbol_left']:"US$";
            }
        }
        $delay_where = " parent_id=".$id." and 
                        apply_type in (2,13,17) and 
                        create_order in (1,11) and 
                        is_delete = 0 and 
                        is_payment = 0 and
                        status = 1 and
                        customers_NO NOT IN (791044479,791044489,761065958,901066613,921065753) and
                        payable_date > 2000 and
                        payable_date <  '" .date("Y-m-d",time())."'";
        $delay =  fs_get_one_data('products_instock_shipping_apply',$delay_where,"parent_id");
        if (zen_not_null($delay)){
            $delay_pay  = true;
        }
    }
    if ($Po_address_id && $is_delete == 0) {
        $str_pos = explode(",", $Po_address_id);
        if ($str_pos) {
            foreach ($str_pos as $k => $v) {
                $address_id = explode('-', $v);
                $on_line = $address_id[2];
                $on_line_address_id = $address_id[0];
                if ($on_line != 2) {
                    $Po_address_arr[] = $on_line_address_id;
                }
            }
        }
    }
    return array(
        "from" => 'old',
        "customer_pay_day" => $customer_pay_day ? $customer_pay_day:"",
        "apply_type" => $apply_type ? $apply_type : 0,
        "Po_address_arr" => $Po_address_arr ? $Po_address_arr: array(),
        "is_delete" => $is_delete ? $is_delete : 0,
        "po_flag" => $po_flag,
        "id" => isset($id)?$id:0,
        "admin" => 0,
        "parent_id" => $parent_id,
        "delay_pay" => $delay_pay,
        "apply_money" => $apply_money,
        'all_apply_money' => isset($all_apply_money) ? $all_apply_money : 0,
        'symbol_right' => isset($symbol_right) ? $symbol_right : '',
        'currency_symbol' => isset($currency_symbol) ? $currency_symbol : "US$",
        'currency_symbol_code' => isset($currency_symbol_code) ? $currency_symbol_code : 'USD',
        "apply_money_currrncy" => $apply_money_currrncy ? $apply_money_currrncy : "USD"
    );
}


/**
 * * add by aron
 * 是否展示payeezy 付款方式
 * @param string $currency
 * @param string $country_id
 * @param bool $is_use_counrty_name
 * @return bool
 */
function is_show_payeezy($currency="",$country_id = "",$is_use_country_name = false){
    if(!PAYEEZY_STATUS || !$currency || !$country_id){
        return false;
    }
    $country_arr = [223,138,38,172,13,153];
    $currency_arr = ["USD","CAD","MXN",'AUD'];
    if($is_use_country_name){
        $country_arr = ["United States","Mexico","Canada","Puerto Rico",'Australia','New Zealand'];
    }
    if(!in_array($country_id,$country_arr)){
        return false;
    }
    if(!in_array($currency,$currency_arr)){
        return false;
    }
    return true;
}

//function is_show_payeezy($currency = "", $country_id = "", $is_use_country_name = false)
//{
//    if (!PAYEEZY_STATUS || !$currency || !$country_id) {
//        return false;
//    }
//    $country_arr = [223, 138, 38, 172, 13, 153];
//    $currency_arr = ["USD", "CAD", "MXN", 'AUD'];
//    $currency_eu = ['EUR', 'GBP', 'CHF', 'SEK', 'USD'];
//    $eu_tag = 'country_number';
//    if ($is_use_country_name) {
//        $country_id = get_country_id_by_name($country_id);
//    }
//    //$is_eu = all_german_warehouse($eu_tag, $country_id);
//    if (in_array($country_id, $country_arr)) {
//        if (!in_array($currency, $currency_arr)) {
//            return false;
//        }
//        return true;
//    }
//    return false;
//}

/**
 * @Notes:是否展示美国运通卡
 *
 * @param string $currency
 * @return bool
 * @author: aron
 * @Date: 2020-11-25
 * @Time: 14:34
 */
function is_show_express_card($currency = '', $country = ''){
    if(in_array($currency, ['SEK', 'CHF'])){
        return false;
    }
    return true;
}
/**
 * @Notes:
 * @param $delivery_data
 * @return bool|void
 * @author: aron
 * @Date: 2020-12-18
 * @Time: 19:39
 */
function createOrderShippingInfo($delivery_data)
{
    if (!is_array($delivery_data)) {
        return;
    }
    foreach ($delivery_data as $k => $v){
        if(!empty($v)){
            foreach ($v as $kk=>$vv){
                if($_SESSION['shipping_'.$k] && $_SESSION['shipping_'.$k]['id'] == 'customzones_customzones'){
                    if($kk == 'own'){
                        $customzones_info = [
                            "customzones_select" => zen_db_prepare_input($vv['select']),
                            "customzones_account" => zen_db_prepare_input($vv['express_account']),
                        ];
                        $_SESSION['shipping_' . $k]['customzones_info'] = $customzones_info;
                    }
                }elseif ($kk == 'pick' && $_SESSION['shipping_'.$k]['id'] == 'selfreferencezones_selfreferencezones'){
                    $pick_info = [
                        "photo_name" => zen_db_prepare_input($vv['contact']),
                        "pick_email" => zen_db_prepare_input($vv['email']),
                        "pick_phone"=>  zen_db_prepare_input($vv['phone']),
                        "pick_time"=>  zen_db_prepare_input($vv['time']),
                    ];
                    $_SESSION['shipping_' .$k]['pick_info'] = $pick_info;
                }
            }
        }
    }
    return true;
}

/**
 * 根据国家获取税率
 *
 * @author aron
 * @date 2019.8.20
 * @param string $country
 * @return float|int
 */
function getVaxByCountry($country = ""){
    if(empty($country)){
        return 1;
    }
    $vax = 1;
    $country = strtoupper($country);
    if (time() > 1609455599){ //柏林2020-12-31 23：59：59时间戳
        $vax_num = 1.19;
    } else {
        $vax_num = 1.16;
    }
    switch ($country){
        case "FR":
        case 'GB':
        case 'MC':
        case "IM":
            $vax = 1.2;
            break;
        case "DE":
            $vax = $vax_num;
            break;
        case "SE":
        case 'DK':
            $vax = 1.25;
            break;
        case "NL":
        case "ES":
        case "BE":
            $vax = 1.21;
            break;
        case "IT":
            $vax = 1.22;
            break;
        case german_warehouse('country_code',$country):
            $vax = $vax_num;
            break;
    }
    return $vax;
}

/**
 *  限制form表单提交的次数
 * @param $source 提交的来源
 * @return bool
 */
function checkoutSubmitNumber($source)
{
    $sta = 0;
    if ($_SESSION[$source][$_SESSION['securityToken']]['sub_time']) {
        if (time() - $_SESSION[$source][$_SESSION['securityToken']]['sub_time'] < 60) {
            if ($_SESSION[$source][$_SESSION['securityToken']]['sub_num'] < 5) {
                $sta = 1;
            }
        } else {
            $_SESSION[$source][$_SESSION['securityToken']]['sub_time'] = time();
            $_SESSION[$source][$_SESSION['securityToken']]['sub_num'] = 0;
            $sta = 1;
        }
    } else {
        $_SESSION[$source][$_SESSION['securityToken']]['sub_time'] = time();
        $_SESSION[$source][$_SESSION['securityToken']]['sub_num'] = 0;
        $sta = 1;
    }
    if ($sta) {
        $_SESSION[$source][$_SESSION['securityToken']]['sub_num'] = $_SESSION[$source][$_SESSION['securityToken']]['sub_num'] + 1;
        return true;
    } else {
        return false;
    }
}

/**
 * 判断当前站点是否是美国站 且国家选择为美国,波多黎各
 * @param string $countries_code 国家code
 * @param string $warehouse 本地仓id
 * @return bool $result
 */

function zen_get_us_en_site($countries_code="",$warehouse=40){
    $is_true = false;
    $countries_code = $countries_code ? $countries_code : $_SESSION['countries_iso_code'];
    if(in_array(strtolower($countries_code),array('us','pr')) && $warehouse == 40){
        $is_true = true;
    }
    return $is_true;
}

function zen_check_order_exist($orders_id)
{
    global $db;
    $get_info = $db->Execute("select count(orders_id) as total from " . TABLE_ORDERS . " where orders_id = " . (int)$orders_id);
    return ($get_info->fields['total'] ? true : false);
}

/**
 * $Notes: 检测最终结算时产品信息是否和刚进页面时一致
 *
 * $author: Quest
 * $Date: 2021/2/23
 * $Time: 12:16
 * @param $order
 * @param $page_order_info
 * @return bool
 */
function checkCreateOrderProductsInfo($order, $page_order_info)
{
    $local_now = $order->local_products;
    $delay_now = $order->delay_products;
    $local_page = $page_order_info['local'];
    $delay_page = $page_order_info['delay'];

    if (!empty($local_now)) {

        if(empty($local_page)){
            $local_check = false;
        }else {
            foreach ($local_now as $v_now) {
                $products_id = $v_now['id'];
                $products_qty = $v_now['qty'];
                $local_check = false;
                foreach ($local_page as $v_page) {
                    if ($v_page['id'] == $products_id && $v_page['qty'] == $products_qty) {
                        $local_check = true;
                    }
                }
                if ($local_check == false) {
                    break;
                }
            }
        }

    } else {
        $local_check = true;
    }

    if (!empty($delay_now)) {

        if (empty($delay_page)) {
            $delay_check = false;
        } else {
            foreach ($delay_now as $v_now) {
                $products_id = $v_now['id'];
                $products_qty = $v_now['qty'];
                $delay_check = false;
                foreach ($delay_page as $v_page) {
                    if ($v_page['id'] == $products_id && $v_page['qty'] == $products_qty) {
                        $delay_check = true;
                    }
                }
                if ($delay_check == false) {
                    break;
                }
            }
        }

    } else {
        $delay_check = true;
    }

    $is_complete =  ($local_check == false || $delay_check == false) ? false : true;

    return $is_complete;
}
