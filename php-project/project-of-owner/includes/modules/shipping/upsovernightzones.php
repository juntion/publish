<?php

  class upsovernightzones {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function upsovernightzones() {
      $this->code = 'upsovernightzones';
      $this->codes = 'UPS Overnight';
      $this->title = MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_UPSOVERNIGHTZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/upsovernightzones/upsground_logo.gif';
      $this->tax_class = MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_BASIS;

	  $this->extra_rate = 1;
   if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_UPSOVERNIGHTZONES_STATUS == 'True') ? true : false);
      }

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 3;
      $this->num_zones_days = 2;
    }

// class methods
    function quote($method = '') {
    	
     global $order,$total_weight,$shipping_num_boxes, $total_count,$currencies,$db;
	

	 $states = zen_get_countries_us_states_code($order->delivery['state']);
	 $postcode = substr($order->delivery['postcode'],0,3);
	  //if(!fs_order_usa_sea_deliver()) return array();
	  
	 $res = $db->Execute("select zip_from,zip_to,2day,overnight from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode'");	
	  $country = $states ? $states : 'AL';

        $country_code = $order->delivery['country']['iso_code_2'];
        if($country_code != 'US'){
            return array();
        }

	  $lbs = $total_weight*2.2046226;
	
	  $lbs1 = ceil($lbs);
	  
	  if($res->fields['overnight']){
		 $day = $res->fields['overnight'];
		 
		  if($lbs1 <= 10000){
				$list = $db->getAll("select lbs,u_".$day." from shipping_ups_price where location = 1 order by id ASC");
				foreach($list as $key=>$v){
					if($v['lbs']>=$lbs){
						$shipping_cost =  $list[$key]["u_".$day] * (1+MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE);
						break;
					}
					
				}	
			
				if($lbs>150){
					$shipping_cost = $list[count($list)-1]["u_".$day] * $lbs * (1+MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE);
				}
		  }else{
				$shipping_cost = 0 ;
		  }
	  }else{
		  $shipping_cost = 0 ;
	  }
        if (!empty($order->local_products) || !empty($order->delay_products)) {
            if($lbs>10000){
                 $this->quotes = array();
            }else{
                $show_total = $order->local_info['subtotal']+$order->delay_info['subtotal'];
                if($shipping_cost){
                    if($order->delivery['company_type'] == 'IndividualType'){
                        //公司类型为IndividualType 加收 4 USD
                        $shipping_cost = $shipping_cost + 4;
                    }
                     $this->quotes = array('id' => $this->code,
                                        'ids' => $this->codes,
                                    'module' => MODULE_SHIPPING_UPS2DAYSZONES_TEXT_TITLE,
                                    'methods' => array(array('id' => $this->code,
                                                             'title' => $this->title,
                                                             'cost' => $shipping_cost)));
                }
            }

              if ($this->tax_class > 0) {
                $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
              }

              return $this->quotes;
        }else{
            return array();
        }
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array()) {

        global $order,$shipping_num_boxes, $total_count,$currencies,$db;


        $states = zen_get_countries_us_states_code($state);
        $postcode = substr($post_code,0,3);
        //if(!fs_order_usa_sea_deliver()) return array();

        $res = $db->Execute("select zip_from,zip_to,2day,overnight from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode'");

        $country_code = $country;
        if($country_code != 'US'){
            return array();
        }

        $lbs = $total_weight*2.2046226;

        $lbs1 = ceil($lbs);

        if($res->fields['overnight']){
            $day = $res->fields['overnight'];

            if($lbs1 <= 10000){
                $list = $db->getAll("select lbs,u_".$day." from shipping_ups_price where location = 1 order by id ASC");
                foreach($list as $key=>$v){
                    if($v['lbs']>=$lbs){
                        $shipping_cost =  $list[$key]["u_".$day] * (1+MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE);
                        break;
                    }

                }

                if($lbs>150){
                    $shipping_cost = $list[count($list)-1]["u_".$day] * $lbs * (1+MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE);
                }
            }else{
                $shipping_cost = 0 ;
            }
        }else{
            $shipping_cost = 0 ;
        }
            if($lbs>10000){
                $this->quotes = array();
            }else{
                $show_total = $price;
                if($shipping_cost){
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));
                }
            }

            return $this->quotes;

    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");
       
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_UPSOVERNIGHTZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
      $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone".$i."','MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS_ZONES_".$i."','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_".$i."','MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS_".$i."','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_UPSOVERNIGHTZONES_STATUS', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_METHOD', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_CLASS', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_TAX_BASIS', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_SORT_ORDER', 'MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS','MODULE_SHIPPING_UPSOVERNIGHTZONES_SKIPPED','MODULE_SHIPPING_UPSOVERNIGHTZONES_EXTRA_FEE');
	  
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	$keys[] = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS_ZONES_' . $i;
      	$keys[] = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_DAYS_' . $i;
      }
      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_UPSOVERNIGHTZONES_HANDLING_' . $i;
      }

      return $keys;
    }
  }
