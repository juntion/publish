<?php
/**
 * functions_taxes
 *
 * @package functions
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_taxes.php 16190 2010-05-03 20:18:57Z wilt $
 */

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
  function zen_get_tax_rate($class_id, $country_id = -1, $zone_id = -1) {
    global $db;

    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (isset($_SESSION['customer_id'])) {
        $country_id = $_SESSION['customer_country_id'];
        $zone_id = $_SESSION['customer_zone_id'];
      } else {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      }
    }

    if (STORE_PRODUCT_TAX_BASIS == 'Store') {
      if ($zone_id != STORE_ZONE) return 0;
    }
    return 0;
  }

////
// Return the tax description for a zone / class
// TABLES: tax_rates;
  function zen_get_tax_description($class_id, $country_id = -1, $zone_id = -1) {
    global $db;
    
    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (isset($_SESSION['customer_id'])) {
        $country_id = $_SESSION['customer_country_id'];
        $zone_id = $_SESSION['customer_zone_id'];
      } else {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      }
    }
      return TEXT_UNKNOWN_TAX_RATE;

  }
////
// Return the tax rates for each defined tax for the given class and zone
// @returns array(description => tax_rate)
  function zen_get_multiple_tax_rates($class_id, $country_id, $zone_id, $tax_description=array()) {
    global $db;

    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (isset($_SESSION['customer_id'])) {
        $country_id = $_SESSION['customer_country_id'];
        $zone_id = $_SESSION['customer_zone_id'];
      } else {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      }
    }
    // calculate appropriate tax rate respecting priorities and compounding

      // no tax at this level, set rate to 0 and description of unknown
      $rates_array[0] = TEXT_UNKNOWN_TAX_RATE;

    return $rates_array;
  }
////
// Add tax to a products price based on whether we are displaying tax "in" the price
  function zen_add_tax($price, $tax) {
    global $currencies;

    if ( (DISPLAY_PRICE_WITH_TAX == 'true') && ($tax > 0) ) {
      return $price + zen_calculate_tax($price, $tax);
    } else {
      return $price;
    }
  }

 // Calculates Tax rounding the result
  function zen_calculate_tax($price, $tax) {
    global $currencies;
    return $price * $tax / 100;
  }
////
// Output the tax percentage with optional padded decimals
  function zen_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
    if (strpos($value, '.')) {
      $loop = true;
      while ($loop) {
        if (substr($value, -1) == '0') {
          $value = substr($value, 0, -1);
        } else {
          $loop = false;
          if (substr($value, -1) == '.') {
            $value = substr($value, 0, -1);
          }
        }
      }
    }

    if ($padding > 0) {
      if ($decimal_pos = strpos($value, '.')) {
        $decimals = strlen(substr($value, ($decimal_pos+1)));
        for ($i=$decimals; $i<$padding; $i++) {
          $value .= '0';
        }
      } else {
        $value .= '.';
        for ($i=0; $i<$padding; $i++) {
          $value .= '0';
        }
      }
    }

    return $value;
  }


 function zen_get_tax_locations($store_country = -1, $store_zone = -1) {
  global $db;
    switch (STORE_PRODUCT_TAX_BASIS) {

      case 'Shipping':
        $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['sendto'] . "'";
        $tax_address_result = $db->Execute($tax_address_query);
      break;
      case 'Billing':

        $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
        $tax_address_result = $db->Execute($tax_address_query);
      break;
      case 'Store':
        $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                from " . TABLE_ADDRESS_BOOK . " ab
                                left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                and ab.address_book_id = '" . (int)$_SESSION['billto'] . "'";
        $tax_address_result = $db->Execute($tax_address_query);

        if ($tax_address_result ->fields['entry_zone_id'] == STORE_ZONE) {

        } else {
          $tax_address_query = "select ab.entry_country_id, ab.entry_zone_id
                                  from " . TABLE_ADDRESS_BOOK . " ab
                                  left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id)
                                  where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "'
                                  and ab.address_book_id = '" . (int)$_SESSION['sendto'] . "'";
        $tax_address_result = $db->Execute($tax_address_query);
       }
     }
     $tax_address['zone_id'] = $tax_address_result->fields['entry_zone_id'];
     $tax_address['country_id'] = $tax_address_result->fields['entry_country_id'];
     return $tax_address;
 }
 function zen_get_all_tax_descriptions($country_id = -1, $zone_id = -1) 
 {
   global $db;
    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (isset($_SESSION['customer_id'])) {
        $country_id = $_SESSION['customer_country_id'];
        $zone_id = $_SESSION['customer_zone_id'];
      } else {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      }
    }
   $taxDescriptions =array();
   return $taxDescriptions;
 }

/**
 * add by rebirth  2019/04/29
 * 从order类移到此处，避免在购物车调用时初始化order类
 *
 * 判断客户是否免税
 * @param  $country //收货地址所在的国家
 * @return bool
 */
function get_apply_customer_duty_free($country = false)
{
    global $db;
    if (empty($_SESSION['customer_id'])) {
        return false;
    }
    if (!$country){
        $country  = 'UnknownCountry';
        $res = $db->execute("select `countries_name` from countries where countries_iso_code_2 = '".$_SESSION['countries_iso_code']."' limit 1");
        if (!$res->EOF) {
            $country = $res->fields['countries_name'];
        }
    }
    $customerId = $_SESSION['customer_id'];
    $customer_num = fs_get_data_from_db_fields('customers_number_new', 'customers', 'customers_id=' . $customerId);
    if (empty($customer_num)){
        $customer_num = 1;
    }
    $oderTime = getTime('Y-m-d H:i:s',time(),"","Asia/Shanghai");
    $sql_find = "SELECT `id`,`cooperate_to_time`,`verify_time` FROM `products_instock_shipping_apply` WHERE `is_delete` != 1 AND `apply_type`= 15 AND `status` = 1 AND `customers_NO` = '" . $customer_num . "' AND `country` = \"" . $country . "\" limit 1";
    $find = $db->Execute($sql_find);
    $label = false;
    $verify_time = $find->fields['verify_time'];
    if (!$find->EOF) {
        if ($oderTime && $oderTime != '0000-00-00 00:00:00' && $verify_time != '0000-00-00 00:00:00') {
            //验证订单是否在有效时间段内
            if ((strtotime($oderTime) > strtotime($verify_time)) && (strtotime($oderTime) < strtotime($find->fields['cooperate_to_time']))) {
                $label = true;
            }
        } else {
            $label = true;
        }
    }
    return $label;
}

/**
 * 判断客户是否免税
 * 免税需要订单收货国家 账单国家 账单税号 匹配 并且未超过有效期
 * @param $customer_num //客户编号
 * @param string $products_instock_id 流程id
 * @param int $orders_id 线上订单表id
 * @param string $delivery_country_name 订单收货国家
 * @param string $billing_country_name 订单账单国家
 * @param string $vat_number 订单账单税号
 * @return bool
 */
function get_apply_customer_duty_free_new($customer_num,$products_instock_id='',$orders_id=0,$delivery_country_name='',$billing_country_name='',$vat_number='')
{
    global $db;
    if (empty($customer_num) || !$delivery_country_name || !$billing_country_name) {
        return false;
    }
    $oderTime = date('Y-m-d H:i:s');
    //已录款的 获取录款时间  未录款的  获取录单时间 否则获取下单时间
    if($products_instock_id) {
        //获取订单时间
        $sqlOrderTime = "SELECT `finance_time`,`sales_add_time`,`orders_id`,`vat_number` FROM `products_instock_shipping` WHERE `products_instock_id` ='" . $products_instock_id . "' limit 1";
        $orderTimeInfo= $db->Execute($sqlOrderTime);
        $oderTime = ($orderTimeInfo->fields['finance_time']&&$orderTimeInfo->fields['finance_time']!='0000-00-00 00:00:00')?$orderTimeInfo->fields['finance_time']:$orderTimeInfo->fields['sales_add_time'];
    } elseif ($orders_id>0) {
        $sqlOrderTime = "SELECT `date_purchased` FROM `orders` WHERE `orders_id` ='" . $orders_id . "' limit 1";
        $orderTimeInfo= $db->Execute($sqlOrderTime);
        $oderTime = $orderTimeInfo->fields['date_purchased'];
        $season_type_sea = fs_get_data_from_db_fields('parent_id', 'fs_basic_data', 'fs_data_type=6 and fs_data_name="sea"', 'limit 1');
        $time_lag_sea = $season_type_sea == 2 ? 16 * 3600 : 15 * 3600;
        $oderTime=date("Y-m-d H:i:s",strtotime($oderTime)-$time_lag_sea);
    }
    $find_sql = 'SELECT id FROM products_instock_shipping_apply
          WHERE is_delete = 0 AND apply_type = 15 AND status = 1 AND verify_time < "'.$oderTime.'"
          AND cooperate_to_time > "'.$oderTime.'" AND customers_NO = "'.$customer_num.'"
          AND vat_number = "'.$vat_number.'" AND country = "'.$delivery_country_name.'" AND billing_country = "'.$billing_country_name.'"';
    $find = $db->Execute($find_sql);
    $label = false;
    if (!$find->EOF) {
        $label = true;
    }
    return $label;
}

//判断UK站点 是否展示VAT
//英国脱欧  暂不展示税后价
function get_price_vat_uk_show(){
    return false;
    if(in_array($_SESSION['languages_code'],array('uk')) && !in_array($_SESSION['countries_iso_code'],array('gg','je'))){
        return true;
    }else{
        return false;
    }
}

/**
 * 验证后台是否有可通过的免税
 *
 * @param $customer_num
 * @param $delivery_country_name
 * @return array
 */
function taxFreeApplyFromAdmin($customer_num,$delivery_country_name){
    global $db;
    $returns = [];
    $sql = 'SELECT id,vat_number,billing_country FROM products_instock_shipping_apply
          WHERE is_delete = 0 AND apply_type = 15 AND status = 1 AND verify_time < "' . date('Y-m-d H:i:s') . '"
    AND cooperate_to_time > "' . date('Y-m-d H:i:s') . '" AND customers_NO = "' . $customer_num . '"
    AND country = "' . $delivery_country_name . '" ';
    $result = $db->Execute($sql);
    if (!$result->EOF){
        while (!$result->EOF){
            $returns[] = $result->fields;
            $result->MoveNext();
        }
    }
//    $returns = [
//        [
//            'vat_number' =>1,
//            'billing_country' =>2,
//        ]
//    ];
    return  $returns;

}

//判断当前站点 是否展示VAT  VAT为多少
function get_current_vat_by_languages_code(){
    $de_vat = 0;
    $has_vat = false;
    $subtotal_str = ACCOUNT_TOTAL .':';
//de和de-en站展示税收后的总价格
//uk(20%)，和au(10%)
//    if(in_array($_SESSION['languages_code'], ['de','dn'])){
    if(in_array($_SESSION['languages_code'], ['de', 'dn', 'it']) || ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF'))))){
        //德 德英 添加特殊国家  不展示vat 税收
        if(! in_array(strtolower($_SESSION['countries_iso_code']),array('no','ch','ad','li','sm','je','is','ba','rs','me','mk','al','md','fo','gl','gp','gf','mq','ic','yt','aw','va', 'bl', 'mf') )){
            $subtotal_str =  FS_SHOP_CART_SUBTOTAL;
            $has_vat = true;
            //2020-6-25 pico 更新规则 收货地址为德国，无论账单地址为哪个国家，一律收取16%的VAT。 2020.7.1-12.31
            if (time() > 1609455599){ //柏林2020-12-31 23：59：59时间戳
                $vax_num = 0.19;
            } else {
                $vax_num = 0.16;
            }
            // 2019-7-8 potato 添加摩纳哥的税率与法国的一样为20%
            if($_SESSION['countries_iso_code'] =='fr' || $_SESSION['countries_iso_code'] =='mc'){
                $de_vat = 0.2;
            }elseif ($_SESSION['countries_iso_code'] == 'it'){
                $de_vat = 0.22;
            }elseif ($_SESSION['countries_iso_code']== 'se' || $_SESSION['countries_iso_code']== 'dk'){
                $de_vat = 0.25;
            }elseif(in_array($_SESSION['countries_iso_code'], ['nl', 'es', 'be'])){
                $de_vat = 0.21;
            }else{
                $de_vat = $vax_num;
            }
        }
    }
    /*elseif($_SESSION['languages_code'] =='au' && $_SESSION['countries_iso_code'] !='nz'){
        $has_vat = true;
        $de_vat = 0.1;
        $subtotal_str =  FS_SHOP_CART_SUBTOTAL;
    }*/
    elseif(get_price_vat_uk_show()){
        $has_vat = true;
        $de_vat = 0.2;
        $subtotal_str =  FS_SHOP_CART_SUBTOTAL;
    }elseif($_SESSION['countries_iso_code'] =='sg'){
        $has_vat = true;
        $de_vat = 0.07;
        $subtotal_str =  FS_SHOP_CART_SUBTOTAL;
    }
    if(get_apply_customer_duty_free()){
        $de_vat = 0;
    }
    $result = array($subtotal_str,$has_vat,$de_vat);
    return $result;
}

/**
 * $Notes: 获取税费标题
 *
 * $author: Quest
 * $Date: 2021/2/24
 * $Time: 15:02
 * @param $country_code
 * @param int $type 1.购物车 2. 结算页 调用
 * @param bool $is_bill_company
 * @param bool $invoice 是否为发票
 * @param bool $is_uk_business_address 是否为英国企业地址
 * @return mixed|string
 */
function get_checkout_vat_title($country_code, $type = 1, $is_bill_company = false, $invoice=false,$is_uk_business_address = false)
{
    //2020-6-25 pico 更新规则 收货地址为德国，无论账单地址为哪个国家，一律收取16%的VAT。 2020.7.1-12.31
    if (time() > 1609455599){ //柏林2020-12-31 23：59：59时间戳
        $vax_num = '19%';
    } else {
        $vax_num = '16%';
    }

    $vat_title = str_replace('$VAT', $vax_num, FS_SHOP_CART_EXCL_VAT);
    $country_code = strtoupper($country_code);
    if(in_array($_SESSION['languages_code'],['en','au','uk','dn','sg']) || $type == 2){
        //欧盟国家的税率
        if(german_warehouse('country_code',$country_code)){
            if($is_uk_business_address) {
                $vat = '19%';
            }else {
                switch ($country_code) {
//                    case 'GB':
//                    case 'IM':
                    case 'FR':
                    case 'MC':
                        $vat = '20%';
                        break;
                    case 'NL':
                    case 'ES':
                    case 'BE':
                        $vat = '21%';
                        break;
                    case 'IT':
                        $vat = '22%';
                        break;
                    case 'SE':
                    case 'DK':
                        $vat = '25%';
                        break;
                    case 'BL':
                        $vat = 0;
                        break;
                    case 'MF':
                        $vat = 0;
                        break;
                    default :
                        $vat = $vax_num;
                        break;
                }
            }

            if($is_bill_company){
              $vat = $vax_num;
            }

            if($country_code == 'DE'){
                $vat_title = str_replace('$VAT', $vat, FS_SHOP_CART_EXCL_DE_VAT);
            }else {
                $vat_title = str_replace('$VAT', $vat, FS_SHOP_CART_EXCL_VAT);
            }
        }

        switch ($country_code)
        {
            case 'AU':
                $vat_title = FS_SHOP_CART_EXCL_AU_VAT;
                break;
            case 'SG':
                $vat_title = FS_SHOP_CART_EXCL_SG_VAT;
                break;
            case 'RU':
                $vat_title = str_replace('$VAT', '20%', FS_SHOP_CART_EXCL_VAT);
                break;
            case 'CN':
                $vat_title = str_replace('$VAT', '13%', FS_SHOP_CART_EXCL_VAT);
                break;
            case 'US':
                $vat_title = $invoice ? FS_VAX_TITLE_US_TAX : FS_VAX_TITLE_US;
                break;
        }
    }


    return $vat_title;

}
