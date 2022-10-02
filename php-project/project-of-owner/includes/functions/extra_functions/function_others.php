<?php
//判断是否从武汉仓发货
function is_from_wuhan($country_code=""){
    $asia = array(
        0 => "CN",
        1 => "MN",
        2 => 'JP',
        3 => "KR",
        4 => "VN",
        5 => "LA",
        6 => "KH",
        7 => "MM",
        8 => "TH",
        9 => "MY",
        10 => "BN",
        11 => "SG",
        12 => "ID",
        13 => "TL",
        14 => "NP",
        15 => "BT",
        16 => "BD",
        17 => "IN",
        18 => "PK",
        19 => 'LK',
        20 => "MV",
        21 => "KZ",
        22 => "KG",
        23 => "UZ",
        24 => "TM",
        25 => "AF",
        26 => "IQ",
        27 => "IR",
        28 => "SY",
        29 => "JO",
        30 => "LB",
        31 => "IL",
        32 => "SA",
        33 => "PS",
        34 => "BH",
        35 => 'QA',
        36 => "KW",
        37 => "AW",
        38 => "OM",
        39 => "YE",
        40 => "GE",
        41 => "AM",
        42 => "AZ",
        43 => "TR",
        44 => "CN",
        45 => "HK",
        46 => "TW",
        47 => "KP"
    );
    global $db;
    $EU_code = array_values($db->getAll("select countries_iso_code_2  from countries where flag = 3"));
    //欧洲国家
    $eu_all = array(
        0 => "AL",
        1 => "TT",
        2 => "AD",
        3 => "BE",
        4 => "BA",
        5 => "BG",
        6 => "DK",
        7 => "FI",
        8 => "FR",
        9 => "IS",
        10 => "IT",
        11 => "PL",
        12 => "PT",
        13 => "RO",
        14 => "SM",
        15 => "NO",
        16 => "LI",
        17 => "CH",
        18 => "MD",
        19 => "UA",
        20 => "BY",
        21 => "VA",
        22 => "RU",
        23 => "MC",
        24 => "RS"
    );
    $eu_arr = array();
    foreach ($EU_code as $v){
        $eu_arr[]=$v['countries_iso_code_2'];
    }
    $eu_arr = array_values($eu_arr);
    $eu_all = array_values(array_diff($eu_all,$eu_arr));
    if(in_array($country_code,$asia) || $country_code =="NZ" || $country_code =="AU" || in_array($country_code,$eu_all)){
        return true;
    }else{
        return false;
    }
}
//判断是否从德国发货
function is_from_de($country_code=""){
    global $db;
    //欧洲国家
    $eu_arr = array(
        0=>'FR',
        1=>'DE',
        2=>'SE',
        3=>'CZ',
        4=>'NL',
        5=>'LU',
        6=>'PT',
        7=>'EL',
        8=>'IE',
        9=>'PL',
        10=>'LT',
        11=>'LV',
        12=>'EE',
        13=>'FI',
        14=>'AT',
        15=>'HR',
        16=>'HU',
        17=>'SK',
        18=>'RO',
        19=>'BG',
        20=>'BE',
        21=>'IT',
        22=>'ES',
        23=>'CY',
        24=>'SI',
        25=>'DK',
        26=>'MT',
        27=>'UKGB'
    );//欧盟国家
    if( in_array($country_code,$eu_arr) || $country_code=="GB" ){
        return true;
    }else{
        return false;
    }
}
function get_categories_level($categories_id,$level=1,$overflow=0){
  global $db;
  $cacheType = sqlCacheType();
  $result = $db->Execute("select {$cacheType} parent_id from categories where categories_id = ".(int)$categories_id);
  $parent_id = $result->fields['parent_id'];
  if($overflow>=10){
    return $level;
  }else{
    if($parent_id!=0){
      $level++;$overflow++;
      return get_categories_level($parent_id,$level,$overflow);
    }else{
      return $level;
    }
  }
}
/*
  获取用户购买产品的评论属性
  */
function get_customers_buy_attributes($customers_id,$products_id){
		global $db;
		$products_attributes = $db->getAll("select orders_products_attributes_id,products_options,products_options_values from orders_products_attributes as opa left join orders_products as op using(orders_products_id) left join orders as o on o.orders_id=op.orders_id 
		where o.customers_id='".$customers_id."' and op.products_id = '".$products_id."' ");
		if($products_attributes){
		
		$html = '';
			foreach($products_attributes as $key=>$v){
			$ch_products_options = fs_get_data_from_db_fields('change_word','products_options','products_options_name="'.$products_attributes[$key]['products_options'].'"','');
			$ch_products_options_values = fs_get_data_from_db_fields('change_word','products_options_values','products_options_values_name="'.$products_attributes[$key]['products_options_values'].'"','');
			
			$html.= '<span>'.$ch_products_options.' : '.$ch_products_options_values.'</span>';
			}
			echo $html;
		}
		
	}
	
	/*获取客户购买认证*/	
function get_customers_verified_purchase($customers_id,$products_id){
		global $db;
		$products_attributes = $db->getAll("select orders_products_id from orders_products as op  left join orders as o on o.orders_id=op.orders_id where o.customers_id='".$customers_id."' and op.products_id = '".$products_id."' ");
		if($products_attributes && $customers_id!=''){
		return true;
		}elseif(in_array($customers_id,array(118075))){
		return true;
		}else{
		return false;
		}
		
	}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 增加categories_of_image
function zen_get_categories_has_custom_display($cid,$level){
    global $db;
    $left_categories = array();
    $cacheType = sqlCacheType();
    $sql="select  {$cacheType} cld.cid,cld.categories_id,cld.categories_name,cld.categories_url,cld.sort,cld.categories_red,cld.is_has_new_products,cld.is_has_hot_products,c.categories_of_image,c.categories_of_image_mobile,c.categories_of_image_app 
    from categories_left_display cld
    LEFT join ".TABLE_CATEGORIES ." c on c.categories_id = cld.categories_id
    where cld.status=1 and cld.parent_id=".(int)$cid ." and cld.level_id = ".$level." and IFNULL(c.is_clearing,0) = 0 and cld.language_id = '" . (int)$_SESSION['languages_id'] . "' order by cld.sort";


    $categories = $db->Execute($sql);
    if($categories->RecordCount()){
        while(!$categories->EOF){
            $left_categories [] =array(
                'cid' => $categories->fields['cid'],
                'categories_id' => $categories->fields['categories_id'],
                'name' => swap_american_to_britain($categories->fields['categories_name']),
                'url' => $categories->fields['categories_url'],
                'red' => $categories->fields['categories_red'],
                'sort' => $categories->fields['sort'],
                'categories_of_image'=>$categories->fields['categories_of_image'],
                'categories_of_image_mobile'=>$categories->fields['categories_of_image_mobile'],
                'categories_of_image_app'=>$categories->fields['categories_of_image_app'],
                'is_has_new_products' => $categories->fields['is_has_new_products'],
                'is_has_hot_products' => $categories->fields['is_has_hot_products']
            );
            $categories->MoveNext();
        }
    }
    return $left_categories;
}

function clear_chinesechar($str){
    $arr = array(
                 '（' => '-', '）' => '-', '〔' => '-', '〕' => '-', '【' => '-',
                 '】' => '-', '〖' => '-', '〗' => '-', '“' => '-', '”' => '-',
                 '‘' => '-', '’' => '-', '｛' => '-', '｝' => '-', '《' => '-',
                 '》' => '-', '&nbsp;' => '-','&ensp;' => '-','™' => '-',' '=>'-',
                 '％' => '-', '＋' => '-', '—' => '-', '－' => '-', '～' => '-',
                 '：' => '-', '。' => '-', '、' => '-', '，' => '-', '、' => '-',
                 '；' => '-', '？' => '-', '！' => '-', '…' => '-', '‖' => '-',
                 '”' => '-', '’' => '-', '‘' => '-', '｜' => '-', '〃' => '-',
                 '　' => '-', '＄'=>'-', '＠'=>'-', '＃'=>'-', '＾'=>'-', '＆'=>'-', '＊'=>'-'
                 );
    return strtr($str, $arr);
}

function zen_get_products_is_special($pid){
 global $db;
 $sql="select products_is_special as special  from products where products_id=".(int)$pid;
 $products=$db->Execute($sql);
 if($products->fields['special']){
 return $products->fields['special'];
 }else{
 return false;
 }
}

function zen_get_meta_of_categories_narrow($cid,$nid){
 global $db;
 $meta_info = array();
 $sql = "select meta_narrow_id as id,narrow_page_title as title,narrow_page_keywords as keywords,narrow_page_description as description
         from meta_of_categories_narrow where categories_id = '".(int)$cid."' and narrow_id ='". (int)$nid ."' ";
 $meta = $db->Execute($sql);
 if($meta->RecordCount()){
  while (!$meta->EOF){
	  $meta_info [] = array(
	  'id' => $meta->fields['id'],
	  'title' => $meta->fields['title'],
	  'keywords' => $meta->fields['keywords'],
	  'description' => $meta->fields['description']
   );
   $meta->MoveNext();
  }
 }
 return $meta_info;
}

function zen_get_currencies_value_of_id($id){
    global $db;
    $sql="select value from currencies where currencies_id=".(int)$id;
    $currencies = $db->Execute($sql);
    return $currencies->fields['value'];
}

function zen_get_currencies_value_of_code($code){
 global $db;
  $sql = " select value from currencies where code= '". $code ."' ";
  $curr = $db->Execute($sql);
 return $curr->fields['value'];
}

function zen_get_currencies_of_code($code){
    global $db;
    $sql = " select code from currencies where code= '". $code ."' ";
    $curr = $db->Execute($sql);
    return $curr->fields['code'];
}

function zen_get_partner_email_has_regist($email){
   global $db;
   $sql= "select customers_id from customers where customers_email_address = '". $email ."'";
   $partner = $db->Execute($sql);
   if($partner->fields['customers_id']){
     return true;
   }else{
     return false;
   }
}

function zen_get_customer_has_submit_partner($email){
   global $db;
   $sql= "select parent_id from partner_register where company_email = '". $email ."'";
   $partner = $db->Execute($sql);
   if($partner->fields['parent_id']){
     return true;
   }else{
     return false;
   }
}

function zen_get_customers_level_of_regist($cid){
 global $db;
 $customers = $db->Execute("select member_level from customers where customers_id = '".$cid."'");
 if($customers->fields['member_level']){
  return $customers->fields['member_level'];
 }else{
  return 1;
 }
}

function week($str){
      if((date('w',strtotime($str))==6) || (date('w',strtotime($str)) == 0)){
          return true;
      }else{
       return false;
    }
   }

function zen_get_product_qty_of_id($pid){
global $db;
 $sql = " select products_quantity as qty from products where products_id = ".(int)$pid;
 $products = $db->Execute($sql);
 return $products->fields['qty'];
}

function zen_get_product_has_stock($pid){
global $db;
$sql ="select products_in_stock from products where products_id =".(int)$pid;
$product = $db->Execute($sql);
  if($product->fields['products_in_stock'] == 1){
  return true;
  }else{
  return false;
  }
}

function zen_get_product_leadtime_of_ship($pid){
global $db;
$sql = "select products_leadtime as time from products where products_id =".(int)$pid;
$products = $db->Execute($sql);
if($products->fields['time']){
return $products->fields['time'];
}else{
return 5;
}
}

//产品发货天数
function zen_get_categories_parent_of_deliver($cid){
global $db;
$cacheType = sqlCacheType();
$sql = " select {$cacheType} parent_id from ".TABLE_CATEGORIES." where categories_id='". $cid ."'  ";
$categories = $db->Execute($sql);
return $categories->fields['parent_id'];
}

function zen_get_product_deliver_time($pid,$qty=1,$attr_arr=[],$cn_qty=0){
    global $db;
    $sql = "select products_leadtime from products where products_id=" . (int)$pid;
    $products = $db->Execute($sql);
    if(is_numeric($products->fields['products_leadtime'])){
        return $products->fields['products_leadtime'];
    }else{
        return false;
    }
}

/** 春节假期
 * $start  春节假开始时间
 * $end  春节假结束时间
 * @param $contain_weekday 是否包含周末
 * @return int
 */
function get_spring_festival_holiday($contain_weekday = true) {
    $start = '2021-2-07 00:00:00';
    $end = '2021-2-16 23:59:59';
    $day = 0;
    if(empty($start) || empty($end)) {
        return $day;
    }
    date_default_timezone_set("Asia/Shanghai");
    $startTime = strtotime($start);
    $endTime = strtotime($end);
    $nowTime = time();
    if ($nowTime >= $startTime && $nowTime <= $endTime) {
        $day = ceil(($endTime-$nowTime)/86400);
    }
    if(!$contain_weekday && $nowTime<=$endTime){
        $now_date = date('Y-m-d H:i:s');
        $num = get_weekday_number($now_date, $end);
        $day = $day - $num['total_relax'];
    }
    date_default_timezone_set("America/Los_Angeles");
    return $day;
}

/**
 * $Notes: 获取某段时间内的周末天数
 *
 * $author: Quest
 * $Date: 2021/2/5
 * $Time: 18:24
 * @param string $start_date
 * @param string $end_date
 * @return array
 */
function get_weekday_number($start_date = '', $end_date = ''){
    $data = array();
    if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);

    $start_reduce = $end_add = 0;
    $start_N = date('N',strtotime($start_date));
    $start_reduce = ($start_N == 7) ? 1 : 0;

    $end_N = date('N',strtotime($end_date));
    in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;

    $days = round(abs(strtotime($end_date) - strtotime($start_date))/86400) + 1;
    $data['total_days'] = $days;
    $data['total_relax'] = floor(($days + $start_N - 1 - $end_N) / 7) * 2 - $start_reduce + $end_add;

    return $data;
}


/** 遇到周末顺延
 * @param $days 天数
 * @param $area 时区
 * @param $countries_code_2
 * @return int
 */
function postponed_weekend($days=0,$area="",$countries_code_2="") {
    global $db;
    $countries_code_2 = $countries_code_2 ? $countries_code_2 : $_SESSION['countries_iso_code'];
    if(empty($area)) {
        $area = $db->Execute("select time_zone from country_time_zone where code='".strtoupper($countries_code_2)."' limit 1");
        $area = $area->fields['time_zone'];
    }
    $sun_day = 0;
    $sun_date = getTime('D',strtotime('+' . $days . ' days'),$countries_code_2,"",true,$area);
    if (($sun_date == "Sun" || $sun_date == "Sat")) {
        if ($sun_date == "Sat") {
            $sun_day = 2;
        } else {
            $sun_day = 1;
        }
    }
    return $sun_day+$days;
}
/**
 * @param $pid
 * @param $attr 客户选择属性
 * @param $cn_qty cn仓库存
 * @param $is_heavy 是否是重货
 * @param $is_us_pr bool 是否是美国站 且国家选择为美国,波多黎各
 * @return int 判断该产品转运时间
 */
function get_custom_processing_days($pid,$attr=[],$cn_qty=0,$is_heavy="",$is_us_pr){
    $processing_days = 0;
    $pid = (int)$pid;
    if(empty($pid)){
        return $processing_days;
    }
    $add_time = 0;
    if($is_us_pr){
        if ($cn_qty) {
            $add_time = 1;
        } else {
            $add_time = 2;
        }
    }
    if(!$cn_qty){
        $cn_qty = zen_get_current_qty($pid, "CN", true);//武汉仓库存
    }
    $country_iso_code = $_SESSION['countries_iso_code'] ? strtoupper($_SESSION['countries_iso_code']) : "US";
    $sg_warehouse = singapore_warehouse("country_code",$country_iso_code);
    if($cn_qty){
        if ($is_heavy && !all_german_warehouse("country_code",$country_iso_code) && !in_array($country_iso_code, ['AU']) && !ru_warehouse('country_code', $country_iso_code)) { //  欧洲仓和澳大利亚全面转运
            $origin = 0;
        }else {
            $origin = 7;
        }
        if(in_array(strtolower($country_iso_code),array('us','ca','mx','nz')) || $sg_warehouse){
            if($sg_warehouse){
                $processing_days = 0; //新加坡仓覆盖国家，武汉仓有库存和本地发货时间一样
            }else{
                $processing_days = 1;
            }
        }else{
            $processing_days = $origin; //准运时间+7
        }
    }else{
        if (ru_warehouse('country_code', $country_iso_code)) {
            $origin = 7;
        } elseif ($is_heavy && !all_german_warehouse("country_code",$country_iso_code) && !in_array($country_iso_code, ['AU'])) { //  欧洲仓和澳大利亚全面转运
            $origin = 0;
        }else {
            $origin = 5;
        }
        //根据属性匹配虚拟id
        $related_id = attribute_matching_fictitious_id($pid,$attr);
        $processing_days = get_standard_product_days($related_id,1);

        //如果匹配到的虚拟id没有交期，则调取原id的交期
        if($related_id != $pid && !$processing_days) {
            $processing_days = get_standard_product_days($pid,1);
        }
        if(!$processing_days){
            $processing_days = zen_get_product_deliver_time($pid);
            if(!$processing_days){
                if(in_array($pid,array(69219,69220))){
                    $processing_days = 30;
                }else{
                    $processing_days = 5;
                }
            }
        }
        if(all_german_warehouse("country_code",$country_iso_code) || in_array($country_iso_code,array('AU')) || ru_warehouse('country_code', $country_iso_code)){
            $processing_days = $processing_days + $origin;
        }
    }
    return $processing_days+$add_time;  //返回备货时间(工作日)
}

//设置的分类发货天数
function get_categories_deliver_time_of_id($cid){
global $db;
$sql = "select categories_delivery_time as time from categories where categories_id= ".(int)$cid;
$cate = $db->Execute($sql);
if($cate->fields['time']){
return $cate->fields['time'];
}else{
return false;
}
}

//根据产品寻找分类的发货天数
function get_deliver_time_of_product_by_category($products_id){
  global  $db;
 //产品分类ID  至少是三级分类下 才有产品 有可能是四级五级
  $products_query ="select categories_id from ".TABLE_PRODUCTS_TO_CATEGORIES." where products_id = '". (int)$products_id ."'   ";
  $products=$db->Execute($products_query);

  //分类的父级
  $sub_categories_query="select categories_id,parent_id from ".TABLE_CATEGORIES." where categories_id ='". $products->fields['categories_id'] ."'   ";
  $sub_categories=$db->Execute($sub_categories_query);

  $select_categories_query="select categories_id,parent_id from " . TABLE_CATEGORIES . " where categories_id = '". $sub_categories->fields['parent_id'] ."'  ";
  $select_categories=$db->Execute($select_categories_query);

  //判断是否到了一级

  if(zen_get_categories_parent_of_deliver($select_categories->fields['parent_id']) == 0){
    //到了一级，那么先选三级的天数，没有就选二级的
     if(get_categories_deliver_time_of_id($sub_categories->fields['categories_id'])){
      return get_categories_deliver_time_of_id($sub_categories->fields['categories_id']);
     }else if(get_categories_deliver_time_of_id($select_categories->fields['categories_id'])){
     return get_categories_deliver_time_of_id($select_categories->fields['categories_id']);
     }else{
     return false;
     }

   }//没有到一级
   else{
   //存在第四级

   $continue_categories_query="select categories_id,parent_id from ".TABLE_CATEGORIES." where categories_id='". $select_categories->fields['parent_id'] ."'  ";
   $continue_categories = $db->Execute($continue_categories_query);

       if(zen_get_categories_parent_of_deliver($continue_categories->fields['parent_id']) == 0){

            if(get_categories_deliver_time_of_id($select_categories->fields['categories_id'])){
		      return get_categories_deliver_time_of_id($select_categories->fields['categories_id']);      //这是第三级
		     }else if(get_categories_deliver_time_of_id($select_categories->fields['parent_id'])){
		     return get_categories_deliver_time_of_id($select_categories->fields['parent_id']);    //这是第二级
		     }else{
		     return false;
		     }
        }//第五级
        else{
        $last_categories_query="select parent_id from ".TABLE_CATEGORIES." where categories_id='". $continue_categories->fields['parent_id'] ."'  ";
        $last_categories=$db->Execute($last_categories_query);
         if(zen_get_categories_parent_of_deliver($continue_categories->fields['categories_id']) == 0){
             if(get_categories_deliver_time_of_id($continue_categories->fields['categories_id'])){
		      return get_categories_deliver_time_of_id($continue_categories->fields['categories_id']);      //这是第三级
		     }else if(get_categories_deliver_time_of_id($continue_categories->fields['parent_id'])){
		      return get_categories_deliver_time_of_id($continue_categories->fields['parent_id']);    //这是第二级
		     }else{
		     return false;
		     }
           }
         }
      }
    }

function zen_get_categories_status($cid){
global $db;
$cacheType = sqlCacheType();
if($cid){
$sql = "select {$cacheType} categories_status as status from categories where categories_id =".(int)$cid;
$categories = $db->Execute($sql);;
if($categories->fields['status'] == '1'){
return true;
}else{
return false;
}
}
}

//get customer default set payment method
function zen_get_customer_default_set_payment_method($cid){
 global $db;
 if($cid){
  $sql = "select payment_module_code as payment from orders where customers_id = '". (int)$cid ."' order by orders_id desc limit 1";
  $orders = $db->Execute($sql);
  if($orders->fields['payment']){
   return $orders->fields['payment'];
  }else{
  return false;
  }
 }
}

function zen_get_check_ie_browser() {
$userbrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userbrowser ) ) {
$usingie = true;
} else {
$usingie = false;
}
return $usingie;
}
// get all subcategories of parent
function zen_get_all_subcategories_of_cid($cid){
global $db;
$all_cid = array();
$sql ="select c.categories_id as id from categories_description as cd left join categories as c on(c.categories_id = cd.categories_id)
          where c.parent_id = '". $cid ."' and c.categories_status =1";
$categories = $db->Execute($sql);
while (!$categories->EOF){
			$all_cid [] = array(
					'id'=>$categories->fields['id']
					);
			$categories->MoveNext();
		}
 return $all_cid;
}

function zen_get_narrow_by_option_id_of_values_id($vid){
global $db;
$sql = "SELECT products_narrow_by_options_id as id FROM products_narrow_by_options_values_to_options WHERE products_narrow_by_options_values_id = ".(int)$vid;
$narrow = $db->Execute($sql);
return $narrow->fields['id'];
}

/* 2014-7-30
 * judge customers has allot
 * 1.客户是否分配，然后找出所属(admin_id)。以后直接分配给admin_id
 * */
function zen_get_orders_id_of_number($number){
global $db;
$sql = "select orders_id from orders where orders_number='". $number ."' ";
$orders = $db->Execute($sql);
return $orders->fields['orders_id'];
}

function zen_get_isnot_customer_of_email($email){
global $db;
$customer = $db->Execute("select customers_id as id from customers where customers_email_address = '". $email ."' ");
if($customer->fields['id']){
return $customer->fields['id'];
}else{
return false;
}
}

function zen_get_customer_has_allot_to_admin($cid){
global $db;
if(!$cid){
    return false;
}
$sql="select admin_id from  admin_to_customers where customers_id=".(int)$cid." limit 1";
$order = $db->Execute($sql);
if($order->fields['admin_id']){
return $order->fields['admin_id'];
}else{
return false;
}
}

function zen_get_customer_order_has_admin_id($orders_id){
    global $db;
    $sql = "select admin_id from order_to_admin where orders_id=".$orders_id;
    $admin_id = $db->Execute($sql);
    if($admin_id->fields['admin_id']){
        return $admin_id->fields['admin_id'];
    }else{
        return false;
    }
}
/*end of 2014-7-30*/
/*bof add wishlist update by melo*/
function zen_get_products_wishlist_attributes($pid){
global $db;
$wishlist_attr = array();
$products_attr = $db->Execute("select products_options_id as oid,products_options_value_id as vid,products_options_sort_order as sort_order from customers_wishlist_attributes
                               where  customers_wishlist_id = '". $pid ."' order by products_options_sort_order ");
		while (!$products_attr->EOF){
			$wishlist_attr [] = array(
					'oid'=>$products_attr->fields['oid'],
			        'vid'=>$products_attr->fields['vid'],
			        'sort_order'=>$products_attr->fields['sort_order']
					);
			$products_attr->MoveNext();
		}
		return $wishlist_attr;
}

function zen_get_products_attributes_price($pid,$oid,$vid){
global $db;
$sql = "SELECT options_values_price as price FROM products_attributes WHERE products_id = '".$pid."' AND options_id = '".$oid."' AND options_values_id = '".$vid."'";
$attr_price = $db->Execute($sql);
return $attr_price->fields['price'];
}

function zen_get_products_attributes_price_prefix($pid,$oid,$vid){
global $db;
$sql = "SELECT price_prefix FROM products_attributes WHERE products_id = '".$pid."' AND options_id = '".$oid."' AND options_values_id = '".$vid."'";
$attr_price = $db->Execute($sql);
return $attr_price->fields['price_prefix'];
}

function zen_get_wishlist_quantity($wid,$cid,$pid){
$sql = "SELECT products_quantity as qty FROM customers_wishlist WHERE products_id = '".$pid."' AND options_id = '".$oid."' AND options_values_id = '".$vid."'";
$attr_price = $db->Execute($sql);
return $attr_price->fields['qty'];
}

function zen_get_option_values_id_of_wishlist($vid){
global $db;
$sql = "select products_options_values_name as name from products_options_values where products_options_values_id = '". (int)$vid ."' AND language_id =1" ;
$option = $db->Execute($sql);
return $option->fields['name'];
}

function zen_get_products_is_inquiry($pid){
global $db;
global $fsCurrentInquiryField;
$products = $db->Execute("select {$fsCurrentInquiryField} as is_inquiry from products where products_id ='". $pid ."'   ");
return $products->fields['is_inquiry'];
}
/*eof 2014-7-15*/

/*
 * get customer_name from id
 * */
  function login_delCache($dir,$all=0){
  	if($all == 0){
  		if(!is_dir($dir)){
  			unlink($dir);
  		}
  	 }else{
  	 	$dh=opendir($dir);
  	 	while ($file=readdir($dh)) {
  	 		if($file!="." && $file!="..") {
  	 			$fullpath=$dir."/".$file;
  	 			if(!is_dir($fullpath)) {
  	 				unlink($fullpath);
  	 			}else{
  	 				deldir($fullpath);
  	 			}
  	 		}
  	 	}
  	}
  }

function zen_get_lasted_support(){
global $db;
$support_article = array();
$support =$db->Execute("select sa.support_articles_id as id,sa.support_articles_title as title
                       from support_articles_description as sa left join support_articles as s on(sa.support_articles_id = s.support_articles_id)
                        order by support_articles_sort_order  limit 4");

if($support->RecordCount()){
 while(!$support->EOF){
    $support_article[] = array(
    'id' => $support->fields['id'],
    'title' => $support->fields['title']
    );
 $support->MoveNext();
 }
}
 return $support_article;
}


function zen_get_admin_email_of_name($name){
global $db;
$admin = $db->Execute("select admin_email from admin where admin_name = '". $name ."'  ");
return $admin->fields['admin_email'];
}

function zen_get_admin_phone_of_customer_id($cid){
global $db;
$customer = $db->Execute("select admin_id,customers_id from admin_to_customers where customers_id = '". $cid ."'order by add_time desc limit 1  ");
$admin = $db->Execute("select admin_telephone from admin where admin_id = '". (int)$customer->fields['admin_id'] ."'  ");
return $admin->fields['admin_telephone'];
}

function zen_customer_has_admin_of_cid($cid){
global $db;
$customer = $db->Execute("select admin_id,customers_id from admin_to_customers where customers_id = '". $cid ."' order by add_time desc limit 1  ");
$admin = $db->Execute("select admin_name from admin where admin_id = '". (int)$customer->fields['admin_id'] ."'  ");
return $admin->fields['admin_name'];
}

function zen_get_product_has_custom($products_id){
global $db;
$option = array();
 $get_option = $db->Execute("select options_id,options_values_id,is_custom from products_attributes where products_id = '". (int)$products_id ."' ");

 if ($get_option->RecordCount()){
		while(!$get_option->EOF){
			if($get_option->fields['is_custom'] > 0 or $get_option->fields['options_values_id'] == 0){
			$is_custom = 0;
			return false;
			}else{
			$is_custom = 1;
			}
			$get_option->MoveNext();
		}
	}else{
	$is_custom = 1;
	}
  return $is_custom;
//return $option;
}



function zen_get_customer_has_phl($cid){
global $db;
 $get_admin = $db->Execute("select customer_country_id as country from customers where customers_id =  '". (int)$cid ."'
                             ");
  if($get_admin->fields['country'] == 168){
  return false;
   }else{
  return true;
   }

}

function zen_get_latest_new_id(){
  global $db;
  $get_admin = $db->Execute("select na.article_id as id from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                             where language_id=1  and news_status =1 and news_status_top =1 order by na.article_id desc limit 1");
  if(empty($get_admin->fields)){
    $get_admin = $db->Execute("select na.article_id as id from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                         where language_id=1  and news_status =1 order by na.article_id desc limit 1");
  }
    return $get_admin -> fields['id'];
}

function zen_get_latest_new_title(){
  global $db;
  $get_admin = $db->Execute("select news_article_name as title from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                             where language_id=1 and news_status =1 order by na.article_id desc limit 1");
  return $get_admin -> fields['title'];
}

function zen_get_latest_new_title_top()
{
    global $db;
    $get_admin = $db->Execute("select news_article_name,nat.news_title_top from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                             where language_id=1 and news_status =1 and news_status_top =1 order by na.article_id desc limit 1");
    if($get_admin->fields['news_title_top']){
        return $get_admin->fields['news_title_top'];
    }else{
        return $get_admin->fields['news_article_name'];
    }

}


function zen_get_latest_new_date(){
  global $db;
  $get_admin = $db->Execute("select news_date_added as date from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                             where language_id=1 and news_status =1 order by na.article_id desc limit 1");
  return $get_admin -> fields['date'];
}

function zen_get_latest_new_content(){
  global $db;
  $get_admin = $db->Execute("select news_article_shorttext as content from news_articles as na left join news_articles_text as nat on (na.article_id = nat.article_id)
                             where language_id=1 and news_status =1 order by na.article_id desc limit 1");
  return $get_admin -> fields['content'];
}

function zen_get_admin_name_of_id($aid){
global $db;
  $get_admin = $db->Execute("select admin_name from admin where admin_id=".$aid);
  return $get_admin -> fields['admin_name'];
}

function zen_get_customer_fname_of_id($cid){
    if (!$_SESSION['customer_first_name']){
        global $db;
        $get_customer = $db->Execute("select customers_firstname from ".TABLE_CUSTOMERS." where customers_id= " .(int)$cid);
        return  $get_customer->fields['customers_firstname'];
    }else{
        return $_SESSION['customer_first_name'];
    }
}

function zen_get_customer_lname_of_id($cid){
      if (!$_SESSION['customer_last_name']){
          global $db;
          $get_customer = $db->Execute("select customers_lastname from ".TABLE_CUSTOMERS." where customers_id= " .(int)$cid);
          return  $get_customer->fields['customers_lastname'];
      }else{
          return $_SESSION['customer_last_name'];
      }
}

function zen_category_has_sub_category($categories_id){
	global $db;
	$cacheType = sqlCacheType();
	$get_categories = $db->Execute("select {$cacheType} count(categories_id) as total FROM " .TABLE_CATEGORIES . " AS c LEFT JOIN " .
	                						  TABLE_CATEGORIES_DESCRIPTION ." AS cd
	                						  USING(categories_id)
	                						  WHERE parent_id = " . (int)$categories_id);


		return ($get_categories->fields['total'] > 0) ? true : false;
}
/**
 *
 * tutorial function get category name
 * @param unknown_type $aid
 */
function zen_get_tutorial_detail_to_category($aid){
	global $db;
	$get_info = $db->Execute("select doc_categories_name,cd.doc_categories_id from " .TABLE_DOC_CATEGORIES_DESCRIPTION . ' as cd left join ' .
	TABLE_DOC_ARTICLE_CATEGORY . " as dac on cd.doc_categories_id = dac.doc_categories_id where dac.doc_article_id = " . intval($aid) );
	return  array('cId'=>$get_info->fields['doc_categories_id'],'cName'=>$get_info->fields['doc_categories_name']);
}




function zen_get_tutorial_detail_cid_to_category($cid){
	global $db;
	$get_cid = $db->Execute("select doc_categories_name,cd.doc_categories_id from " .TABLE_DOC_CATEGORIES_DESCRIPTION . ' as cd left join ' .
	TABLE_DOC_ARTICLE_CATEGORY . " as dac on cd.doc_categories_id = dac.doc_categories_id where dac.doc_article_id = " . intval($cid) );
	return  $get_cid->fields['doc_categories_id'];
}



function zen_get_solution_detail_to_category($aid){
	global $db;
	$get_info = $db->Execute("select doc_categories_name,cd.doc_categories_id from " .TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' as cd left join ' .
	TABLE_SOLUTION_ARTICLE_CATEGORY . " as dac on cd.doc_categories_id = dac.doc_categories_id where dac.doc_article_id = " . intval($aid) );
	return  array('cId'=>$get_info->fields['doc_categories_id'],'cName'=>$get_info->fields['doc_categories_name']);
}

function zen_get_solution_detail_cid_to_category($sid){
	global $db;
	$get_cid = $db->Execute("select doc_categories_name,cd.doc_categories_id from " .TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' as cd left join ' .
	TABLE_SOLUTION_ARTICLE_CATEGORY . " as dac on cd.doc_categories_id = dac.doc_categories_id where dac.doc_article_id = " . intval($sid) );
	return  array('sId'=>$get_cid->fields['doc_categories_id'],'sName'=>$get_cid->fields['doc_categories_name']);
	//return  $get_cid->fields['doc_categories_id'];
}

/*
function zen_get_solution_list_name_to_category($cid){
	global $db;
	$get_cid = $db->Execute("select doc_categories_name,cd.doc_categories_id from " .TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' as cd left join ' .
	TABLE_SOLUTION_ARTICLE_CATEGORY . " as dac on cd.doc_categories_id = dac.doc_categories_id where dac.doc_article_id = " . intval($cid) );
	return  $get_cid->fields['doc_categories_name'];
}
*/


function zen_get_solution_prev_or_next($prev_or_next,$aid){
	global $db;
	$sql = "select doc_article_id from " .TABLE_SOLUTION_ARTICLE . " where ";

	if ('prev' == $prev_or_next) {
		$sql .= " doc_article_id < ".(int)$aid ." order by doc_article_id desc ";
	}else
		$sql .= " doc_article_id > ".(int)$aid ." order by doc_article_id ";
	$get_aid = $db->Execute($sql);

	if ($get_aid->RecordCount()) $return = zen_href_link(FILENAME_SOLUTION_DETAIL,'&a_id='.$get_aid->fields['doc_article_id']);
	else{
		if ('prev' == $prev_or_next) $return = 'javascript:void(alert(\'Sorry, this is the first one !\'));';
		else $return = 'javascript:void(alert(\'Sorry, this is the last one !\'));';
	}
	return $return;
}
/**
 *
 * turorial function get prev or next
 * @param unknown_type $prev_or_next
 * @param unknown_type $aid
 */
function zen_get_tutorial_prev_or_next($prev_or_next,$aid){
	global $db;
	$sql = "select doc_article_id from " .TABLE_DOC_ARTICLE . " where ";

	if ('prev' == $prev_or_next) {
		$sql .= " doc_article_id < ".(int)$aid ." order by doc_article_id desc ";
	}else
		$sql .= " doc_article_id > ".(int)$aid ." order by doc_article_id ";
	$get_aid = $db->Execute($sql);

	if ($get_aid->RecordCount()) $return = zen_href_link(FILENAME_TUTORIAL_DETAIL,'&a_id='.$get_aid->fields['doc_article_id']);
	else{
		if ('prev' == $prev_or_next) $return = 'javascript:void(alert(\'Sorry, this is the first one !\'));';
		else $return = 'javascript:void(alert(\'Sorry, this is the last one !\'));';
	}
	return $return;
}


  /**
   * ============fiberstore member if or not======================
   */
//   function zen_get_customer_member_level_if_or_not($cID){

//   	global $db;
//   	$result = $db->Execute("select member_level from ".TABLE_CUSTOMERS." where customers_id= ".$cID." and language_id = ".$_SESSION['languages_id']." ");
//   	echo $result->fields['member_level'];
//   	var_dump($result);
//   	return $result->fields['member_level'];

//   }

    function zen_get_orders_number_by_id($order_id){
  	global $db;
  	$get_orders_id = $db->Execute("select orders_number from " . TABLE_ORDERS . " where  orders_id= '" . $order_id ."'");
  	return $get_orders_id->fields['orders_number'];
  }

function zen_get_orders_split_number_by_id($order_id){
    global $db;
    $get_orders_id = $db->Execute("select orders_number from " . TABLE_ORDERS_SPLIT . " where  orders_id= '" . $order_id ."'");
    if(strpos($get_orders_id->fields['orders_number'],'-')!=false){
      $orders_number = explode('-',$get_orders_id->fields['orders_number'])[0];
    }else{
        $orders_number = $get_orders_id->fields['orders_number'];
    }
    return $orders_number;
}

  function zen_get_order_status_by_id($order_id){
    global $db;
    $get_order_status = $db->Execute("select orders_status from " . TABLE_ORDERS . " where orders_id = '" . $order_id ."'");
    return $get_order_status->fields['orders_status'];
  }

  function zen_get_sale_admin_shopping_gc_status(){
	  $sale_customers_array = array(192,346,8715,8815,9134,9158,9362,2498,111657);
	  if(isset($_SESSION['customer_id'])){
		  if(in_array($_SESSION['customer_id'],$sale_customers_array)){
			  return true;
		  }
	  }
	  return false;
  }

  function zen_get_products_instock_quantity_of_products_id($product_id) {
    global $db;
    $sql = "SELECT SUM(`instock_qty`) AS total_qty FROM `products_instock` WHERE `products_id`='" . (int)$product_id . "'";
    $total_qty = $db->Execute($sql);
    return $total_qty->fields['total_qty'];
}


    function zen_get_is_hot_products($qty,$hot_type=0){
    global $db;
    $products = array();
        $wp = $db->Execute("select distinct products_id,hot_pname from hot_products
                        where type=1 and is_hot = 1 and language_id = ".$_SESSION['languages_id']." and products_id > 0 
                        order by sort limit $qty");
	if($wp->RecordCount()){
	 while(!$wp->EOF){
	    $products[] = array(
	    'products_id' => $wp->fields['products_id'],
	    'products_name' => $wp->fields['hot_pname']
	    );
	 $wp->MoveNext();
	 }
	}
	return $products;
  }

//新版首页热门产品展示
function zen_get_is_hot_products_type($qty,$hot_type=0){
    global $db;
    $products = array();
    $wp = $db->Execute("select distinct products_id,hot_pname from hot_products
                        where type=1 and is_hot = 1 and language_id = ".$_SESSION['languages_id']." and hot = ".$hot_type."
                        order by sort limit $qty");
    if($wp->RecordCount()){
        while(!$wp->EOF){
            $products[] = array(
                'products_id' => $wp->fields['products_id'],
                'products_name' => $wp->fields['hot_pname']
            );
            $wp->MoveNext();
        }
    }
    return $products;
}

function zen_get_instock_products_warehouse_ny($pid,$qty=1){
    global $db;
    $cate_array = array(3080);
    if(fs_is_bulk_fiber_cable_status($cate_array)){
        return  false;
    }else{

        return true;
    }
    $re = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id ='".$pid."' and warehouse = 3 limit 1");
    if($re->fields['products_instock_id']){
        //if($qty<$re->fields['instock_qty'] && $pid=='51308'){
        if($qty<$re->fields['instock_qty']){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}


//美国库存状态
 function zen_get_instock_products_warehouse_usa($pid,$qty=1){
  global $db;
  $re = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id ='".$pid."' and warehouse = 3 limit 1");
  if($re->fields['products_instock_id']){
	  if($qty<$re->fields['instock_qty']){
		  return true;
	  }else{
		  return false;
	  }
  }else{
	  return false;
  }
  }
function zen_get_instock_products_warehouse_eu($pid,$qty=1){
    global $db;
    $re = $db->Execute("select products_instock_id,instock_qty from products_instock where products_id ='".$pid."' and warehouse = 20 limit 1");
    if($re->fields['products_instock_id']){
        if($qty<$re->fields['instock_qty']){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
 // 购物车存在光缆并且美国是否存在库存
function zen_get_instock_products_warehouse_usa_status(){
	 $products = $_SESSION['cart']->get_products();
	 $guan_stock = true;
	 for ($i=0, $n=sizeof($products); $i<$n; $i++) {
		 $key_data = get_product_category_key((int)$products[$i]['id']);
		 $key = $key_data['key'];
			if($key == 2 || $key == 1){
					//if(zen_get_instock_products_warehouse_usa((int)$products[$i]['id'],(int)$products[$i]['quantity']) == false){
						 $guan_stock = false;
						 break;
					//}
			}
			if(fs_zen_get_product_category_id((int)$products[$i]['id'],array(2907,900,3093,3091))){
				 $guan_stock = false;
				 break;
			}

	 }
	 return $guan_stock;
 }
 //单个产品存在光缆并且美国是否存在库存
 function zen_get_instock_single_products_warehouse_usa_status($pid){
	 $guan_stock = true;
		 $key_data = get_product_category_key((int)$pid);
		 $key = $key_data['key'];
			if($key == 2 || $key == 1){
					//if(zen_get_instock_products_warehouse_usa((int)$pid,1) == false){
						 $guan_stock = false;
					//}
			}
			if(fs_zen_get_product_category_id((int)$pid,array(2907,900,3093,3091))){
				 $guan_stock = false;
			}

	 return $guan_stock;
 }

 function fs_zen_get_product_category_id($product_id,$cate_array){
	global $db;
	$result = $db->getAll("select categories_id from products_to_categories where products_id = '$product_id' order by categories_id desc limit 1");
	if($result){
		$categories_id = $result[0]['categories_id'];
		if(in_array($categories_id,$cate_array)){
			return true;
		}else{
			return false;
		}

	}else{
		return false;
	}
}

//CWDM和DWDM库存问题

function fs_products_instock_cwdm_dwdm_status($id){
  
   $cate_array1 = get_categories_son_id(65,1);
   $cate_array2 = get_categories_son_id(66,1);
   $cate_array3 = get_categories_son_id(87,1);
   $cate_array4 = get_categories_son_id(1789,1);
   $cate_array5 = get_categories_son_id(112,1);
   $cate_array6 = get_categories_son_id(111,1);
   $cate_array7 = get_categories_son_id(2764,1);
   $cate_array8 = get_categories_son_id(2765,1);
   $cate_array9 = get_categories_son_id(2985,1);
   $cate_array10 = get_categories_son_id(2879,1);
   $cate_array11 = get_categories_son_id(2874,1);
   $cate_array12 = get_categories_son_id(2951,1);
   $cate_array13 = get_categories_son_id(2878,1);
   $cate_array14 = get_categories_son_id(2875,1);
   $cate_array15 = get_categories_son_id(1073,1);
   $cate_array = array_merge($cate_array1,$cate_array2,$cate_array3,$cate_array4,$cate_array5,$cate_array6,$cate_array7,$cate_array8,$cate_array9,$cate_array10,$cate_array11,$cate_array12,$cate_array13,$cate_array14,$cate_array15);

   if(fs_zen_get_product_category_id((int)$id,$cate_array)){

	   return true;

   }else{
	  
	   return false;		
   }
}


   //$cid 三级分类id
 function fs_products_length_custom($products_id,$cid){
	 /*
 	$products_array = array(61631,61630,61629,61628,61627,61626,61625,61624,61623,61622,61621,61620,61619,61618,61617,61616,61615,61614,61613,61612,61611,61610,61609,61608,61607,61606,61605,61604,61603,61602,61601,61600,61599,61598,61597,61596,61595,61594,61593,61592,61591,61590,61589,61588,61587,61586,61585,61584,61583,61582,61581,61580,61579,61578,61577,61576,61575,61574,61573,61572,61571,61570,61569,61568,61567,61566,61565,61564,61563,61562,61561,61560,61559,61558,61557,61556,61555,61554,61553,61552,61551,61550,61549,61548,61547,61546,61545,61544,61543,61542,61541,61540,61539,61538,61537,61536,61535,61534,61533,61532,61531,61530,61529,61528,61527,61526,61525,61524,61523,61522,61521,61520,61519,61518,61517,61516,61515,61514,61513,61512,61511,61510,61509,61508,61507,61506,61505,61504,61503,61502,61501,61500,61499,61498,61497,61496,61495,61494,61493,61492,61491,61490,61489,61488,61487,61486,61485,61484,61483,61482,61481,61480,61479,61478,61477,61476,61475,61474,61473,61472,61471,61470,61469,61468,61467,61466,61465,61464,61461,61460,61459,61458,61457,61456,61455,61454,61453,61452,61451,61450,61449,61448,61447,61446,61445,61444,61443,61442,61441,61440,61439,61438,61437,61436,61435,61434,61433,61432,61431,61430,61429,61428,61427,61426,61425,61424,61423,61422,61421,61420,61419,61418,61417,61416,61415,61414,61413,61412,61411,61410,61409,61408,61407,61406,61405,61404,61403,61402,61401,61400,61399,61398,61397,61396,61395,61394,61393,61392,61391,61390,61389,61388,61387,61386,61385,61384,61383,61382,61381,61380,61379,61378,61377,61376,61375,61374,61373,61372,61371,61370,61369,61368,61367,61366,61365,61364,61363,61362,61361,61360,61359,61358,61357,61356,61355,61354,61353,61352,61351,61350,61349,61348,61347,61346,61345,61344,61343,61342,61341,61340,61339,61338,61337,61336,61335,61334,61333,61332,61331,61330,61329,61328,61327,61326,58753,58752,58751,58750,58749,38190,38189,38188,38187,38186,38185,38184,38183,38182,38181,38180,38179,38178,38177,38176,38175,38174,38047,61875,61874,61873,62987,62986,62985,62984,62983,62982,62981,62980,62979,62978,62977,62976,62975,62974,62973,62972,62971,62970,62969,62968,62967,62966,62965,62964,62963,62962,62961,62960,62959,62958,39023,39022,39021,39020,39019,39018,39017,39016,39015,39014,39013,39012,39011,39010,39009,38698,38697,38696,38695,38694,38693,38692,38691,38690,38689,38688,38687,38686,38685,38578,64223,64224,64210,64211,64212,64620,64621,64622,64623,64624,64625,64630,64640,61724,61722,61720,61710,61721,61711,61712,61713,61714,61717,61719,20720,33526,33688,20745,33609,33689,20708,33610,33678,20736,33611,39202,20702,33698,33716,20734,33699,33717,20715,33616,33682,20741,33617,33683,20703,33702,33710,20735,33703,33711,20697,33613,33692,20730,33614,33693,20694,33700,33708,20739,33707,33723,20681,33724,33771,20733,33756,33801,20695,33798,33732,20740,33803,33868,20714,33802,33867,20698,33863,20820,20726,33873,33871,20716,17646,20766,20723,33624,33684,20748,33625,33686,20713,33706,33722,20727,33725,33772,20719,33861,33869,33765,20962,17761,20701,33748,33800,20744,33862,33870,20721,33685,20728,33701,33709,20724,20711,33712,20729,33731,33799,20781,20809,20838,20871,33501,20777,17770,20828,20771,20800,20825,20855,21028,20834,17686,17710,20769,20798,20823,20852,20890,20898,17670,20788,20776,20805,20833,20863,33503,20784,17727,20845,20770,20799,20824,20854,20891,20841,17678,20779,20765,20791,20819,20848,20955,20904,17637,20768,20763,20803,20817,20860,20941,17797,17621,20822,20371,20797,20816,20851,20933,20812,17613,20889,20764,20804,20818,20861,20948,20874,17629,17662,20775,20830,20896,20774,17719,20808,22112,68284,68279,68274,68298,68303,68308,68309,68314,68319,68324,68325,68409,68414,68419,68420,64188,64189,64196,64194,64200,62567,62575,62865,62857,62849,62841,62833,62825,62799,62791,62783,62703,62695,62687,62679,62671,62663,62655,62647,62639,62631,62623,62615,62607,62599,62591,62583,36139,36140);
 	  if(in_array($products_id,$products_array)){
 	  		return true;
 	  }
 	  if(in_array($cid,array(2866,1075,2868,1125,1155,3074))){
 	  	return true;
 	  }
	  */
 	  return false;
 }

  function zen_admin_email_of_id($cid){
      global $db;
      $get_info = $db->Execute("select admin_email from admin where admin_id = ". (int)$cid);
      return $get_info->fields['admin_email'];
  }
  function _zen_get_fiber_optic_list($current_category_id){
	  global $db;
	$all_subcategories_ids = array();
    $all_subcategories = zen_get_all_subcategories_of_cid($current_category_id);
    foreach($all_subcategories as $sub){
	    $all_subcategories_ids [] = $sub['id'];
    }
  	$count_of_subcategories = sizeof($all_subcategories_ids);
  	if ($count_of_subcategories){

  		if (0 < $count_of_subcategories) {

			array_push($all_subcategories_ids,$current_category_id);

  			$category_where_sql = " where categories_id in(".join(',',$all_subcategories_ids).")";

  		}
  	}else {
  		$category_where_sql = " where categories_id = ".(int)$current_category_id;
  	}

	  $list = $db->getAll("select * from categories_products_connector ".$category_where_sql."  and status = 1 order by sort ASC");
	  return  $list;
  }

  function zen_get_products_model_id($model){
	   global $db;
	   $model = trim($model);
	  $get_info = $db->Execute("select products_id from products where products_model = '$model'");
      return $get_info->fields['products_id'];
  }

  function _zen_get_products_name_infomation($id){
	   global $db;
	  $get_info = $db->Execute("select products_name_info from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = '$id' and language_id = ".$_SESSION['languages_id']);
      return $get_info->fields['products_name_info'];
  }
  
  //add by frankie 2016.12.20
   function _zen_get_products_name($id){
	   global $db;
	  $get_info = $db->Execute("select products_name from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = '$id' and language_id = ".$_SESSION['languages_id']);
      return $get_info->fields['products_name'];
  }
  
   function _zen_get_model_name($id){
	   global $db;
	  $get_info = $db->Execute("select products_model from products where products_id = ".$id);
      return $get_info->fields['products_model'];
  }
  
  function _zen_get_cate_name_infomation($id){
	   global $db;
	  $get_info = $db->Execute("select categories_des from categories_description where categories_id = '$id' and language_id = ".$_SESSION['languages_id']);
      return $get_info->fields['categories_des'];
  }
 /*
 *调式输出数据
 * @param    mix  $val    源数据
 * @param    str  $style  是否将数据直接显示在页面,默认为隐藏，参数为show时即显示
 * @param    bool $exit   是否在调式结束设置断点,默认不设置
 * @param    bool $dump   是否启用var_dump调式,默认不启用
 * @return   void
 */
if(!function_exists("dd")){
    function dd($val,$style='hidden',$exit=false,$dump=false){
        if($dump){
            $func = 'var_dump';
        }else{
            $func = (is_array($val)||is_object($val)) ? 'print_r' : 'printf';
        }

        //输出到html
        echo '<pre '.$style.'>debug output:<hr/>';
            $func($val);
        echo '</pre>';
        if($exit) exit;
    }
}

//搜索目录下的所有文件，包含子目录
function searchDir($path,&$data){
	if(is_dir($path)){
		$dp = dir($path);
		while($file = $dp->read()){
			if($file!='.'&& $file!='..'){
				searchDir($path.'/'.$file,$data);
			}
		}
		$dp->close();
	}
	if(is_file($path)){
		if(substr($path, strrpos($path, '.')) == '.php'){      
              $data[]=$path;
        } 
		
	}
}

function searchDirPdf($path,&$data){
    if(is_dir($path)){
        $dp = dir($path);
        while($file = $dp->read()){
            if($file!='.'&& $file!='..'){
                searchDirPdf($path.'/'.$file,$data);
            }
        }
        $dp->close();
    }
    if(is_file($path)){
        if(substr($path, strrpos($path, '.')) == '.pdf'){
            $data[]=$path;
        }

    }
}

//得到目录及子目录下的所有文件
function getDir($dir){
	$data=array();
	searchDir($dir,$data);
	return $data;
}
function getDirPdf($dir){
    $data=array();
    searchDirPdf($dir,$data);
    return $data;
}

 /*
 *加载公共文件的语言包文件
 * @param    string  $language_dir    获取指定的语言包，默认为获取public下全部的语言包文件
 */
function get_public_language($language_page_directory,$language_dir='public'){
	$public_files = getDir($language_page_directory.$language_dir); 
	 while(list ($key, $value) = each($public_files)){
		require_once($value);
	}
}

/*
 *是否是移动端访问
 * @return  bool  true   是移动端访问的
 * @return	bool  false	 不是移动端访问
 */
function check_wap(){
    if(stristr($_SERVER['HTTP_VIA'],"wap")){
        return 'phone';
    }elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
        return 'phone';
    }elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
        return 'phone';           
    }else{
        return 'pc';    
    }
}

/**
 *分页函数
 *@params	string	$sql			需要分页的sql数据
 *@params	string  $url 			分页的地址,直接写当前需要添加分页的地址，如：zen_href_link('support');
 *@params	int	  	$show_how_page 	每页显示的条数，默认每页显示6条
 *@params	string	$others			地址中一些额外的参数，例如cn.fs.com:8000/support/page/2.html中的page
 *@params	string	$connect_type	地址的链接方式。默认为'/', 如cn.fs.com:8000/support/page/2.html,可写'-',则如cn.fs.com:8000/support/page-2.html
 *@params	return	array			$result包含就是第一页的数据，$page_link包含的是分页链接
 *@params	author	fallwind		2016.9.24
*/
function mypage($sql,$url,$show_how_page='5',$others='page',$connect_type='/'){
	global $db;
	//接受的页码
	$p = isset($_GET['p']) || !empty($_GET['p']) ? $_GET['p'] : 1;
	$p = intval($p);
	if($p == 0){
		$p = 1;
	}
	
	$url = substr($url,0,strripos($url,'.html'));
	
	//查询的起始页的数据
	$offset = ($p-1)*$show_how_page;
	$sql1 = $sql." limit $offset,$show_how_page";
	$result = $db->getAll($sql1);
	
	//总共有多少页数据
	$total_data = sizeof($db->getAll($sql));
	$total_how_page = ceil($total_data/$show_how_page);
	
	//始终显示中间五页
	$all_show_pageNum = 5;
	
	//当前页的前后页码偏移量
	$p_offset = ($all_show_pageNum-1)/2;
	$strat_page = ($p - $p_offset);
	$end_page = ($p + $p_offset);

	if($strat_page < 1){
		$strat_page = 1;
	}
	
	if($total_how_page < $all_show_pageNum){
		$strat_page = 1;
		$end_page = $total_how_page;
	}

	if($end_page > $total_how_page){
		$end_page = $total_how_page;
	}

	if($end_page < $all_show_pageNum){
		$end_page = $total_how_page;
	}
	//翻页条
	$page_link = '';
	if($p > 1){
		$page_link .= '<div id="myPage"><b>Page:</b><a href='.$url.'/'.$others.'/'.($p-1).'.html'.' title="Previous Page" class="prevPage">prev</a>&nbsp;&nbsp;';
	}else{
		$page_link .= "<div id='myPage'><b>Page:</b><span>prev</span>&nbsp;";
	}

	if($total_how_page > $all_show_pageNum && $p > ($p_offset+1)){
		$page_link .= '...';
	}

	for($i=$strat_page;$i<=$end_page;$i++){
		if($i==$p){
			$page_link .= '<a class="current_page">'.$i.'</a>&nbsp;&nbsp;';
		}else{
			$page_link .= '<a href='.$url.'/'.$others.'/'.$i.'.html'.'>'.$i.'</a>&nbsp;&nbsp;';
		}
	}

	if($total_how_page > $all_show_pageNum && $p < ($total_how_page-$p_offset)){
		$page_link .= '...';
	}

	if($p < $total_how_page){
		$page_link .= '<a href='.$url.'/'.$others.'/'.($p+1).'.html'.' title="Next Page" class="nextPage">next</a></div>';
	}else{
		$page_link .= '<span>next</span>&nbsp;</div>';
	}
	$page_css = "<style>
	#myPage{float:right}
	#myPage .prevPage{
		padding: 7px 18px;
	}
	#myPage .nextPage{
		padding: 7px 18px;
	}
	#myPage a{
		border: 1px solid #C0C0C0;
		border-radius: 3px;
		color: #232323;
		line-height: 14px;
		padding: 7px 10px;
		text-decoration: none;
	}
	#myPage span{
		padding: 7px 18px;
		line-height: 14px;
		color: #999;
		text-decoration: none;	
		border: 1px solid #dedede;
		border-radius: 3px;
	}
	#myPage a:hover{
		color:rgb(214,48,48);
		background-color:rgb(244,244,244);
	}
	#myPage .current_page{
		border: 1px solid rgb(214,48,48);
		background-color:rgb(214,48,48);
		color:rgb(255,255,255);
	}
	#myPage .current_page:hover{
		border: 1px solid rgb(214,48,48);
		background-color:rgb(214,48,48);
		color:rgb(255,255,255);
	}
	</style>";
	echo $page_css;		//输出分页的样式
	return array(
		'fpage_data'=>$result,
		'page_link'=>$page_link
	);
}


//屏蔽P.O. Box 地址

function zen_pb_po_box_address($address,$address1){

	$po_array = array(
		'P.O. Box',
		'PO Box',
		'P.O. box',
		'p.o.box',
		'po box',
		'P O BOX',
		'p o box',
		'P.O.BOX'
		);
   foreach($po_array as $v){
	   if(strpos($address,$v) !== false){
					return true;		
			}
	    if(strpos($address1,$v) !== false){
					return true;		
			}
   }
   return false;

}

//获取公共邮箱后缀
function zen_get_public_mail_suffix(){
    global $db;
    $pub_mail = array();
    $all_mail = $db->getAll("select mail_suffix from public_mail_suffix");
    if($all_mail){
        foreach($all_mail as $mail){
            $pub_mail[] = $mail['mail_suffix'];
        }
    }
    return $pub_mail;
}

//判断分类是否默认展开qf表格
function get_category_qf_status($cid){
	global $db;
	$status =$db->Execute("select qf_status from categories where categories_id =".$cid);
	$category_status = $status->fields['qf_status'];
	return $category_status;
}

/*
* 获取所有关联产品id
*/

function get_all_related_products($products_id){
	//quickFinder  属性关联
	$custom_array = array(64188,64189,64194,64196,64200);
	$id_type = array();
	$cPath = zen_get_product_path($products_id);
	if (zen_not_null($cPath)) {
		$cPath_array = zen_parse_category_path($cPath);
		$cPath = implode('_', $cPath_array);
		$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  
	} 
	if(in_array($products_id,$custom_array)){
		$not_run = fs_get_data_from_db_fields_array(array('id','type'),'categories_fiber_quickfinder_products','products_id='.(int)$products_id,'');
	}else{
		$id_type = fs_get_data_from_db_fields_array(array('id','type'),'categories_fiber_quickfinder_products','products_id='.(int)$products_id,'order by `pid`');
	}
	foreach($id_type as $values){
		if($values[0] && $values[1]){
			$id = $values[0];
			$type = $values[1];
		}
	}
	$crorelated = fs_get_data_from_db_fields('crorelated','categories_fiber_cables_table','id='.(int)$id,'LIMIT 1');
	$i_crorelated = fs_get_data_from_db_fields('crorelated','categories_fiber_cables_table','id='.(int)$id,'LIMIT 1,1');
	$relatename = fs_get_data_from_db_fields('relate_name','categories_fiber_cables_table','id='.(int)$id,'LIMIT 1');
	if($crorelated == 1 || $i_crorelated == 1){
		if(isset($id)){
			$all_products = array();
			$croproducts = fs_get_data_from_db_fields_array(array('products_id','id','type','brand_id'),'categories_fiber_quickfinder_products',"`type`=$type and `id`=$id and `crorelate`= 1 ",'');
			foreach($croproducts as $va){
				$croproduct_relate['brand_name'] = fs_get_data_from_db_fields('brand_name','categories_fiber_quickfinder_brand',"`brand_id`=$va[3] and `id`=$va[1]",'');
				$croproduct_relate['products_id'] = $va[0];
				$all_products[]= $croproduct_relate;
			}
		}
	}

	$review_products = array();
	$list = fs_fiber_optic_products_length_related($products_id);
	$is_wavelength = zen_get_products_is_Wavelength($products_id,106);
	if ($cPath_array[0] == 9 && !$is_wavelength && !in_array($cPath_array[3],array(2425,2427,2446,2429,2431,2432,2430,2485,2487,2506,2489,2491,2492,2490))){
	 
		$related_id = zen_get_products_related_id($products_id);                    //产品关联总组                               
		$default_brand = zen_get_default_related_brand($products_id);               //产品关联的品牌
		if($related_id && !sizeof($list)){
			$BrandProducts = zen_get_related_brand_products($related_id,$default_brand);
			if(is_array($BrandProducts) && sizeof($BrandProducts) > 1){
				//quickFinder  属性关联,有时,则不需要前台显示关联
				foreach($BrandProducts as $BP){
					$products_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$BP['id'],'');
					if($products_status && $BP['id']!=$products_id){
						$review_products['pid'][] = $BP['id'];
					}else if($BP['id']==$products_id){
						$ProductsTag = $BP['tag'] ? $BP['tag'] : zen_get_products_model_PART($BP['id']);
						$ISmodel = substr($ProductsTag, 0, 4);
						//var_dump($ISmodel);
						if($ISmodel == 'SFP-' || $ISmodel =='XFP-' || $ISmodel =='QSFP'){
							if(zen_get_products_model_PART($products_id)){
								$ModelTag = zen_get_products_model_PART($products_id);
							}else{
								$ModelTag = zen_get_products_model($products_id);
							}
						}else{
							$ModelTag = $ProductsTag;
						}
						$review_products['related'][] = array(
							'related_name' => FS_TRANSCEIVER_TYPE,
							'related_value' => $ModelTag
						);
					}
				}
		   
			}
		}
	}

	/*产品纵向关联*/
	$relatedName='';
	if($cPath_array[2] == 1000){
		$relatedName = FS_ADAPTER_TYPE;
	}elseif(in_array($cPath_array[1],array(220,261,1113,2688))){
		$relatedName = 'Length';
	}else{
		$relatedName = fs_attribute_related_name($products_id);
	} 
	$custom_model = false;
	if(in_array($cPath_array[2],array(87,1789,65,66,111,112,2761,2763,2764,2765,1144)) ||  in_array($cPath_array[1],array(1113,2688)) || $cPath_array[0] != 9){
		$custom_model = true;
	}else{
		$custom_model = false;
	}

	$related_is_custom = fs_fiber_optic_products_is_custom($products_id);
	if($list && !$related_is_custom){
		foreach($list as $key=>$n){ 
			$product_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$n['products_id'],'');
			if($product_status && $n['products_id']!=$products_id){
				$review_products['pid'][] = $n['products_id'];
			}else if($n['products_id']==$products_id){
				if($custom_model){
					if($n['length']){
						$plength=explode("[",$n['length']);//分割,不要英尺,只要米数
						$FS_length=explode("(",$plength[0]);//分割,不要英尺,只要米数
						$ModelCustom = trim($FS_length[0]);
					}else{
						$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
					}
				}else{
					$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
				}
				$review_products['related'][] = array(
					'related_name' => $relatedName,
					'related_value' => $ModelCustom
				);
			}
		} 
	}
	if($crorelated == 1 && !strstr(zen_get_categories_name($current_category_id),'Generic')){
		foreach($all_products as $value){
			$products_statu = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$value['products_id'],'');
			if($products_statu && $value['products_id']!=$products_id){
				$review_products['pid'][] = $value['products_id']; 
			}else if($value['products_id']==$products_id){
				$review_products['related'][] = array(
					'related_name' => $relatename ? $relatename : FS_TRANS_RELATED,
					'related_value' => $value['brand_name']
				);
			}
		}
	}


	/* 展示品牌关联 */
	if(strstr(zen_get_categories_name($current_category_id),'Generic')){
		$related_brand = fs_transceivers_related_brand($products_id);   //品牌产品类型

		if(sizeof($related_brand) ){
		  
			for($rb=0;$rb<sizeof($related_brand);$rb++){
				$table_id = $related_brand[$rb]['id'];
				$brand_id = $related_brand[$rb]['brand_id'];
				$products_type = fs_transceivers_related_brand_type($products_id);  //该产品类型
				$brand_type_pid = fs_transceivers_related_brand_type_products($table_id,$brand_id,$products_type);
				$products_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$brand_type_pid,'');
				if($products_statu && $brand_type_pid!=$products_id){
					$review_products['pid'][] = $brand_type_pid; 
				}else if($brand_type_pid==$products_id){
					$review_products['related'][] = array(
						'related_name' => FS_COMPATIBLE,
						'related_value' => $related_brand[$rb]['brand_name']
					);
				}
			}
		}
	}
	if(!$review_products[pid]){
		$review_products['pid'][] = $products_id;
	}else{
		array_unshift($review_products['pid'],$products_id);
	}
	return $review_products;
}

	//去掉转义字符中斜杠
function removehtml($str){     
    $farr = array(
        "/\s+/", //过滤多余空白     
         //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤     
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",    
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件     
   );     
   $tarr = array(   
        " ",     
        "＜\1\2\3＞",//如果要直接清除不安全的标签，这里可以留空     
        "\1\2",     
   );     
  $str = preg_replace($farr,$tarr,$str);  
  
  for($i=0;$i<strlen($str);$i++){
	  $str = stripslashes($str);    
  }  
  return $str;     
}
/*
 * 根据定制产品获取到所有相关联的标准产品
*/
function zen_get_all_related_products($pid){
	global $db;
	$products_id = array();
	$products = array();
	$customized_id = '';
	//查看此产品是定制产品还是标准产品
	$customized_id = fs_get_data_from_db_fields('customized_id','products_instock_other_customized_related','products_id='.$pid,'');
	if(!$customized_id){
		//定制产品
		$customized_id = $pid;
	}
	//根据定制ID获取所有的标准ID
	$query_sql = "select products_id from products_instock_other_customized_related where customized_id={$customized_id}";
	$result = $db->Execute($query_sql);
	if($result->RecordCount()){
		while(!$result->EOF){
			$products[] = $result->fields['products_id'];
			$result->MoveNext();
		}
	}
    if($products){
        $products_sql = "select products_id from products where products_id in(".implode(',',$products).") and products_status=1";
        $products_result = $db->Execute($products_sql);
        if($products_result->RecordCount()){
            while(!$products_result->EOF) {
                $products_id[] = $products_result->fields['products_id'];
                $products_result->MoveNext();
            }
        }
    }
	$products_id[] = $customized_id;
	return $products_id;
}

/**
 * 创建case number
 * 1.前台从CN------000001 开始 每次创建加2
 * 2.后台从CN------000002 开始 每次创建加2
 *
 * @param $from  1.前台,2.后台
 * @param $caseNumberFrom  '1.客服信息录入，2.客户后台提问，3.在线留言管理，4.线上产品询价，5. 定制记录,',
 * @param $email  '客户邮箱'
 * @param $adminID  '分配的销售'
 * @param $content  '客户咨询的内容'
 * @param $customerID  '客户ID'
 * @return string
 */
function createCaseNumber($from,$caseNumberFrom,$email,$adminID,$content,$customerID,$service_ids='',$area='',$is_old=0)
{
    global $db;
    $time = strtotime(date("Y-m-d"));
    //获取年月日 171212
    $date = mb_substr(date("Ymd"),-6);
    //  $from '1.前台,2.后台' ,
    if ($from == 1) {
        $result = $db->Execute("select case_number from case_number where stage_from = 1 and created_at >= ".$time." order by case_number desc limit 1");
        if ($result->fields['case_number']) {
            $lastCaseNumber = mb_substr($result->fields['case_number'],-4);
            $newCaseNumber = (int)$lastCaseNumber + 2;
            $newCaseNumber = 'CN'.$date.str_pad($newCaseNumber , 4 , '0', STR_PAD_LEFT);
        } else {
            $newCaseNumber = 'CN'.$date.'0001';
        }
        if($service_ids){
            $pretreatment_status = 0;
        }else{
            $pretreatment_status = 1;
        }
        $insertArray = [
            'case_number' => $newCaseNumber,
            'case_number_from' => $caseNumberFrom,
            'status' => 0,
            'stage_from' => $from,
            'created_at' => time(),
            'email' => $email,
            'admin_id' => $adminID,
            'content' => $content,
            'customer_id' => $customerID,
            'language_id' => $_SESSION['languages_id'],
            'language_code' => $_SESSION['languages_code'],
            'service_admin' => $service_ids,
            'area'=>$area,
            'pretreatment_status'=>$pretreatment_status,
            'is_old'=>$is_old,
        ];

        $arrEmail = explode('@', $email);
        $domain = '@' . $arrEmail[1];
        $commonDomain = $db->Execute("select mail_suffix from public_mail_suffix WHERE mail_suffix = '" . $domain . "' limit 1");
        if ($email && $newCaseNumber && $caseNumberFrom == 2 && !$commonDomain->fields['mail_suffix']) {
            $last = explode('@',$email);
            $time = time() - 12*3600;
            $resOffline = $db->getAll("SELECT case_number FROM `case_number` where case_number_from = 2 and is_del = 0 and created_at > '".$time."' and email LIKE '%@".$last[1]."'");
            if (sizeof($resOffline)) {
                foreach ($resOffline as $v) {
                    $arr = [
                        'case_number' => $newCaseNumber,
                        'bind_number' => $v['case_number'],
                        'type' => 2,
                        'created_at' => date("Y-m-d H:i:s",time()),
                    ];
                    zen_db_perform('case_number_bind',$arr);
                }
            }
        }
        zen_db_perform('case_number', $insertArray);
        return $newCaseNumber;
    }
}

/**
 * 获取已回答未解决的数量
 *
 * @return mixed
 */
function getReplayNumbers()
{
    global $db;
    if ($_SESSION['customer_id']) {
        $res = $db->Execute("select count(*) as num from case_number ca INNER JOIN customers_broker cu ON ca.case_number=cu.case_number WHERE ca.is_del = 0 and ca.status != 3 and ca.is_que = 1 and cu.is_click = 0 and customer_id = ".(int)$_SESSION['customer_id']);
        if($res->fields['num'] > 0){
            if($res->fields['num'] > 999){
                return $res->fields['num'].'+';
            } else {
                return $res->fields['num'];
            }
        } else {
            return '';
        }
    } else {
        return '';
    }
}
/**
 * 内容超过数量用点代替
 *
 * @return mixed
 */
function contentDisplay($text)
{
    if (mb_strlen($text) > 105) {
        return mb_substr($text,0,105)."...";
    } else {
        return $text;
    }
}

/**
 * 当传入数据不为空时，返回标点符号
 * @param str
 * @return string
 */
function returnDot($str){
    if(!empty($str)){
        $com_dot = ", ";
    }else{
        $com_dot = " ";
    }
    return $com_dot;
}
/**
 * 获取分类的视频信息
 * @param str 分类信息
 * @return string
 */
function get_product_video_info($cid){
	global $db;
	if($cid){
		$sql = "select id,video_url,upload_time,video_title,video_banner_url,video_rank from fs_product_video where sort = ".$cid." and language_id =".$_SESSION['languages_id']." order by video_rank asc,id asc";
	}else{
		$sql = "select id,video_url,upload_time,video_title,video_banner_url,video_rank from fs_product_video where language_id =".$_SESSION['languages_id']." order by video_rank asc,id asc";
	}
	$video_info = $db->Execute($sql);
	$video_arr =array();
	if($video_info ->RecordCount()){
		while(!$video_info->EOF){
			$video_arr []=array(
				'id'=>$video_info->fields['id'],
				'video_url'=>$video_info->fields['video_url'],
				'upload_time'=>$video_info->fields['upload_time'],
				'video_title'=>$video_info->fields['video_title'],
				'video_banner_url'=>$video_info->fields['video_banner_url'],
				'video_rank'=>$video_info->fields['video_rank'],
			);
			$video_info->MoveNext();
		}
	}
	return $video_arr;
}

/**
 * @param $arrays
 * @param $sort_key
 * @param int $sort_order
 * @param int $sort_type
 * SORT_REGULAR - 默认。将每一项按常规顺序排列。
 * SORT_NUMERIC - 将每一项按数字顺序排列。
 * SORT_STRING - 将每一项按字母顺序排列
 * SORT_ASC - 默认，按升序排列。(A-Z)
 * SORT_DESC - 按降序排列。(Z-A)
 * @return bool
 */
function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    if(isset($key_arrays) && is_array($key_arrays)){
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    }
    return $arrays;
}

/**
 * @param $string
 * @return bool
 * @author frankie
 */
 function checkout_code($check_string){
     global $db;
     $code =strtoupper($check_string);
     $sql = "select countries_iso_code_2 from countries where countries_iso_code_2 = '$code'";
     $all_info = $db->Execute($sql);
     if($all_info){
         return true;
     }else{
         return false;
     }
 }
function csv_export($data = array(), $headlist = array(), $fileName) {

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
    header('Cache-Control: max-age=0');

    //打开PHP文件句柄,php://output 表示直接输出到浏览器
    $fp = fopen('php://output', 'a');

    //输出Excel列名信息
    foreach ($headlist as $key => $value) {
        //CSV的Excel支持GBK编码，一定要转换，否则乱码
        $headlist[$key] = iconv('utf-8', 'gbk', $value);
    }

    //将数据通过fputcsv写到文件句柄
    fputcsv($fp, $headlist);

    //计数器
    $num = 0;

    //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 100000;

    //逐行取出数据，不浪费内存
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {

        $num++;

        //刷新一下输出buffer，防止由于数据过多造成问题
        if ($limit == $num) {
            ob_flush();
            flush();
            $num = 0;
        }

        $row = $data[$i];
        foreach ($row as $key => $value) {
            $row[$key] = iconv('utf-8', 'gbk', $value);
        }

        fputcsv($fp, $row);
    }
}
/***
 * 禁止使用该方法
 * restet orders
 */
function reset_orders_bak(){
    global $db;
    set_time_limit(0);
    $now_time = date('Y-m-d H:i:s');
    $orders = $db->getAll("SELECT o.orders_status,o.orders_id,o.orders_number from  orders as o where o.date_purchased >= '2017-1-1 00:00:00' AND o.date_purchased <= '2017-6-30 00:00:00' AND o.orders_status=5");
    $update_orders_list = [];
    $num = 0;
    $button = false;
    $diff = [];
    exit(1);
    foreach ($orders as $k=>$v){
        $cancle_orders_id = fs_get_data_from_db_fields("orders_id","orders_cancel_request","orders_id = {$v['orders_id']} limit 1");
        $orders_status_id = fs_get_data_from_db_fields("orders_status_id","orders_status_history","orders_id = {$v['orders_id']}  ORDER BY orders_status_id DESC limit 1");
        $orders_status_id_copy = fs_get_data_from_db_fields("orders_status_id","manage_customer_orders_status_history","orders_id = {$v['orders_id']}  ORDER BY orders_status_id DESC limit 1");
        if($orders_status_id_copy!=$orders_status_id){
            $diff[] = $v['orders_id'];
        }
        if($orders_status_id && !$cancle_orders_id && $orders_status_id_copy==$orders_status_id){
            if($orders_status_id != $v['orders_status'] && $orders_status_id !=1 && in_array($orders_status_id,[3,4])){
                //$admin_id = fs_get_data_from_db_fields("admin_id","order_to_admin","orders_id = {$v['orders_id']} limit 1");
                $admin_name = "";
                $update_orders_list[$num]['orders_id']= $v['orders_id'];
                $update_orders_list[$num]['orders_status']= $v['orders_status'];
                $update_orders_list[$num]['orders_status_id']= $orders_status_id;
                $update_orders_list[$num]['orders_status_name']= fs_get_data_from_db_fields("orders_status_name","orders_status","orders_status_id = {$orders_status_id} and language_id =1 limit 1");
                $update_orders_list[$num]['orders_number'] = $v['orders_number'];
                $update_orders_list[$num]['admin_name'] = "";
                //$update_orders_list[$num]['last_history_status'] = $orders_status_id;
                if($cancle_orders_id){
                    $update_orders_list[$num]['is_cancel_order'] = 1;
                }else{
                    $update_orders_list[$num]['is_cancel_order'] = 0;
                }
                $num++;
            }
        }
    }
    if($update_orders_list){
       foreach ($update_orders_list as $k => $v){
           if($v['orders_status_id'] && $v['orders_id']){
               $db->Execute("update orders set orders_status = {$v['orders_status_id']} where orders_id={$v['orders_id']}");
               $db->Execute("INSERT INTO orders_status_update_history_bak (orders_id,old_orders_status,new_orders_status,updated_data,is_cancle_order) VALUES (".$v['orders_id'].",".$v['orders_status'].",{$v['orders_status_id']},'{$now_time}',{$v['is_cancel_order']})");
           }
       }
       exit("更新成功");
   }
}

/**
 * 获取俄语站数量单复数表达
 * @param int $num
 * @return string
 * */
function get_russian_item_str($num){
    $end_str = (string)$num;
    $end_num =substr($end_str,-1,1);
    if($end_num == '1' && $num != 11){
        $items_str =F_BODY_HEADER_ITEM ;
        //排除12,13,14
    }elseif(in_array($end_num,array('2','3','4')) && $num != 12 && $num != 13 && $num != 14 ){
        $items_str =F_BODY_HEADER_ITEM_TWO ;
    }else{
        $items_str =F_BODY_HEADER_ITEMS;
    }

    return $items_str;


}

/*
 * 获取客户保存的购物车数据
 * frankie 2019.3.11 add
 * @para $where: where条件
 * @para $is_get_data: 是否获取数据。false，获取总数
 * @para $page: 当前页
 * @para $number: 每页数量
 * @para $is_all: 是否获取所有的数据
 */
function get_save_cart_data($where,$is_get_data=true,$page='',$number='',$is_all =false){
    global $db;
    $save_cart =array();$list_cart =array(); $list_array =array();
    if($is_get_data){
        $field =" customers_saved_id,user_save_time,cart_value,is_new ";
        $begin_page = ($page-1)*$number;
        if($is_all){   //如果是获取总记录数据则不需要偏移量
            $limit ='';
        }else{
            $limit = " limit ".$begin_page.",".$number."";//偏移量
        }
    }else{
        $field =' count(customers_saved_id) as total';//统计总数量
        $limit ='';
    }

    $field_query ="select ".$field." from customers_saved where ".$where. " order by add_time desc".$limit;
    $field_array = $db->Execute($field_query);
    if($is_get_data){ //获取每页的数据
        while(!$field_array->EOF){
            $save_cart[] =array(
                'key'=> $field_array->fields['user_save_time'],
                'value'=>$field_array->fields['cart_value'],
                'customers_saved_id'=>$field_array->fields['customers_saved_id'],
                'is_new' => $field_array->fields['is_new'],
            );
            $field_array->MoveNext();

        }
        return $save_cart;
    }else{  //获取记录总数
        $count = $db->getAll($field_query);
        $count = $count?$count[0]['total']:0;
        return $count;
    }


}

//start 加密解密URL参数
function keyED($txt, $encrypt_key)
{
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = "";
    for ($i = 0; $i < strlen($txt); $i++) {
        if ($ctr == strlen($encrypt_key))
            $ctr = 0;
        $tmp .= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1);
        $ctr++;
    }
    return $tmp;
}

function encrypt($txt, $key)
{
    $encrypt_key = md5(mt_rand(0, 100));
    $ctr = 0;
    $tmp = "";
    for ($i = 0; $i < strlen($txt); $i++) {
        if ($ctr == strlen($encrypt_key))
            $ctr = 0;
        $tmp .= substr($encrypt_key, $ctr, 1) . (substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
        $ctr++;
    }
    return keyED($tmp, $key);
}

function decrypt($txt, $key)
{
    $txt = keyED($txt, $key);
    $tmp = "";
    for ($i = 0; $i < strlen($txt); $i++) {
        $md5 = substr($txt, $i, 1);
        $i++;
        $tmp .= (substr($txt, $i, 1) ^ $md5);
    }
    return $tmp;
}

function encrypt_url($url, $key)
{
    return rawurlencode(base64_encode(encrypt($url, $key)));
}

function decrypt_url($url, $key)
{
    return decrypt(base64_decode(rawurldecode($url)), $key);
}

function geturl($str, $key)
{
    $str = decrypt_url($str, $key);
    $url_array = explode('&', $str);
    if (is_array($url_array)) {
        foreach ($url_array as $var) {
            $var_array = explode("=", $var);
            $vars[$var_array[0]] = $var_array[1];
        }
    }
    return $vars;
}
//end 加密解密URL参数
/**
 * 判断是否https
 * @return bool
 */
function is_https() {
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        return true;
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}
/*
 * 美式英语转换成英式英语
 * @param string $content
 * @return string $content
 * */
function swap_american_to_britain($content, $resultData = [])
{
    if ($content) {
        if(!in_array($_SESSION['languages_code'],array('uk','au','dn'))){
            return $content;
        }
        require_once(DIR_WS_CLASSES . 'AmericanBritishSpellings.php');
        $american_british_spellings = new AmericanBritishSpellings(['text'=>$content], $resultData);
        if (strpos($content, '<') !== false) {//带有html的内容
            $extraPreg = '/<!--[\s\S]*?-->/';  //去掉原文中的注释部分
            $content = preg_replace($extraPreg, '', $content);
            //源码中的js 和 css不能被替换
            $jsPreg = "/<script[\s\S]*?<\/script>/i";
            preg_match_all($jsPreg, $content, $jsMatch);
            $content = preg_replace($jsPreg, '', $content);

            $cssPreg = '/<style[\s\S]*?<\/style>/i';
            preg_match_all($cssPreg, $content, $cssMatch);
            $content = preg_replace($cssPreg, '', $content);
            $arr = explode('<', $content);
            foreach ($arr as $key => $value) {
                $new_arr[] = explode('>', $value);
            }
            if ($new_arr) {
                $final_html = '';
                foreach ($new_arr as $kk => $vv) {
                    //像 字符<br> 字符这样的特殊情况
                    if(count($vv) ==1 &&!empty($vv[0])){
                        $final_html .= $vv[0];
                    }elseif (count($vv) > 1) {
                        $final_html .= '<' . $vv[0] . '>';
                        if ($vv[1]) {
                            $vv[1] = $american_british_spellings->SwapAmericanSpellingsForBritishSpellings(['text' => $vv[1]]);
                            $final_html .= $vv[1];
                        }
                    }
                }
                $content = $final_html;
                //如果原文中有js  css 则追加在content中
                if ($cssMatch) {
                    $cssContent = '';
                    foreach ($cssMatch[0] as $key => $val) {
                        $cssContent .= $val;
                    }
                    $content .= $cssContent;
                }
                if ($jsMatch) {
                    $jsContent = '';
                    foreach ($jsMatch[0] as $key => $val) {
                        $jsContent .= $val;
                    }
                    $content .= $jsContent;
                }
            }
        } else {//没有html的内容
            $content = $american_british_spellings->SwapAmericanSpellingsForBritishSpellings(['text' => $content]);
        }
    }
    return $content;
}
//封装获取产品库存的方法

function get_products_stock($product_id){
    $td_content ='<div class="track_orders_wenhao track_orders_wenhao_only stock">';
    $shipping_info = new ShippingInfo(array('pid' => $product_id));
    //库存
    $shipping_stock = zen_get_products_channel_number_qty($shipping_info->get_all_qty());
    //弹框
    $stock_pop =  $shipping_info->get_10g_sfp_optical_qty();
    $td_content.= '<em></em><span>'.$shipping_stock.'</span>' .$stock_pop .'</div>';
    return $td_content;
}
//生成number的方法  number规则  CN+6位数字的年月日+4位随机数  仿createCaseNumber 方法

function create_number_new(){
    global $db;
    $time = strtotime(date("Y-m-d"));
    $case_key = "CASE_NUMBER_NEW";
    //根据当前时间去service_process  查询最新的一个 number  在这个number的后4位数字基础加2
    $number = $db->getAll('select `number` from service_process where (SUBSTRING(number,13,2) mod 2) = 1 and `created_time` >= '.$time.' order by number desc limit 1');
    $new_number = creatNewCaseNumber($number[0]);
    if(setnx_redis_key_value($case_key,$new_number)){
        set_redis_key_expire($case_key,5);
    }else{
        $new_number = creatNewCaseNumber($new_number);
    }
    return $new_number;
}

function creatNewCaseNumber($number){
    $date = date('Ymd');
    if($number){
        $last_number = mb_substr($number['number'],-4);
        $last_number_new = (int)$last_number +2;
        $last_number_new = str_pad($last_number_new, 4, '0',STR_PAD_LEFT);
        $new_number = 'CN' . $date . $last_number_new;
    }else{
        $new_number = 'CN' . $date . '0001';
    }
    return $new_number;
}

/**
 * 得到销售信息
 * @param $admin_id
 * @return array
 */
function getAdminInfo($admin_id){
    $data = [];
    if($admin_id){
        $adminInfo = fs_get_data_from_db_fields_array(array('admin_name','admin_email'),'admin','admin_id='.(int)$admin_id,'limit 1');
        $data = array(
            'name' => $adminInfo[0][0],
            'email' => $adminInfo[0][1],
        );
    }
    return $data;
}

function hide_file_name($name,$first_len =4 ,$last_len = 8){
    if(strlen($name) > 12){
        $first_str = mb_substr($name,0,$first_len,'utf-8');
        $last_str = mb_substr($name,-($last_len),$last_len,'utf-8');
        return $first_str."...".$last_str;
    }else{
        return $name;
    }
}

function getDeDnFrGoTopClass(){
    if (in_array($_SESSION['languages_code'], ['de', 'dn', 'fr'])) {
        return $_SESSION['languages_code'].'_goTop';
    }
    return '';
}
?>
