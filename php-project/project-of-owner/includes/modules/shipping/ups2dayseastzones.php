<?php

         
class ups2dayseastzones {
	 var $code, $title, $description, $enabled, $num_zones;
	function ups2dayseastzones(){
	  $this->code = 'ups2dayseastzones';
      $this->codes = 'UPS 2nd Day';
      $this->title = MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_UPS2DAYSEASTZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/ups2dayseastzones/ups2days_logo.gif';
      $this->tax_class = MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_BASIS;
	  $this->extra_rate = 1;
  if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_UPS2DAYSEASTZONES_STATUS == 'True') ? true : false);
      }
      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 24;
      $this->num_zones_days = 5;
	}


	  function quote($method = '') {
    	
     global $order,$total_weight,$shipping_num_boxes, $total_count,$currencies,$db;
	  $states = zen_get_countries_us_states_code($order->delivery['state']);
      $country_code = $order->delivery['country']['iso_code_2'];
      if($country_code == "PR"){
          $twoday_zone = "225";
      }else{
          $twoday_zone = $db->getAll("SELECT 2day FROM shipping_ups_special  WHERE zip = '".$order->delivery['postcode']."'");
          $twoday_zone = !empty($twoday_zone) ? $twoday_zone[0]['2day'] : '';
      }
      if(empty($twoday_zone)) {
          $postcode = substr(trim($order->delivery['postcode']), 0, 3);
          $res = $db->getAll("select zip_from,zip_to,2day from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and location = 2");
          if(in_array($country_code,array('MX','CA'))){
              $res[0]['2day'] = '208';
          }
          $twoday_zone = $res[0]['2day'] ? $res[0]['2day'] : '';
      }

	  $country = $states ? $states : 'AL'; 
	  $lbs = $total_weight*2.2046226;

	  if($twoday_zone){
		 $day = $twoday_zone;
		
		  if($lbs <= 10000){
				$list = $db->getAll("select lbs,u_".$day." from shipping_ups_price where location = 2 order by id ASC");
				foreach($list as $key=>$v){
					if($v['lbs'] >= $lbs){
						$shipping_cost =  $list[$key]["u_".$day] * (1+MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE);
						break;
					}
				}
				if($lbs>150){
					$shipping_cost = $list[count($list)-1]["u_".$day] * $lbs * (1+MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE);
				}
				  
		  }else{
				$shipping_cost = 0 ;
		  }
	  }else{
		  return array();
	  }
    
	$status = false;
    $status = $order->is_buck_in_products;
	
	if($lbs>10000){
		 $this->quotes = array();
	}else{
        $show_total = $order->local_info['subtotal']+$order->delay_info['subtotal'];
        $status = $order->is_local_buck;
        /**
         * ups2day 不在免运费统一ups ground 免运费
         *
         * update by aron
         * 2019.11.7
         */
        $is_shipping_free = false;
        if($shipping_cost) {

            if($order->delivery['company_type'] == 'IndividualType'){
                //公司类型为IndividualType 加收 4 USD
                $shipping_cost = $shipping_cost + 4;
            }
            $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;

            $days = fs_get_east_west_shipping_time($order->delivery['postcode'],'east');
            //免运费改成收运费
            if ($lbs < 50 && $is_shipping_free && $status == false && $days>3) {
                $this->quotes = array('id' => $this->code,
                    'ids' => $this->codes,
                    'module' => MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_TITLE,
                    'methods' => array(array('id' => $this->code,
                        'title' => $this->title,
                        'cost' => 0)));
            } else {
                $this->quotes = array('id' => $this->code,
                    'ids' => $this->codes,
                    'module' => MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_TITLE,
                    'methods' => array(array('id' => $this->code,
                        'title' => $this->title,
                        'cost' => $shipping_cost)));

            }
        }else{
            $this->quotes = array();
        }

	}
		
  
      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
      if (strstr(MODULE_SHIPPING_UPS2DAYSEASTZONES_SKIPPED, $dest_country)) {
        // don't show anything for this country
        $this->quotes = array();
      } else {
        if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPS2DAYSEASTZONES_INVALID_ZONE;
      }

      return $this->quotes;
    }

        function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(),$zone_type = 0,$is_shipping_free = false) {

        global $order,$shipping_num_boxes, $total_count,$currencies,$db;
        $states = zen_get_countries_us_states_code($state);
        if($country == "PR"){
            $twoday_zone = "225";
        }else{
            $twoday_zone = fs_get_data_from_db_fields('ground','shipping_ups_special','zip = "'.$post_code.'"');
        }
        $country = $states ? $states : 'AL';
        if(empty($twoday_zone)) {
            $postcode = substr(trim($post_code), 0, 3);
            $res = $db->getAll("select zip_from,zip_to,2day from shipping_ups where zip_from<= '$postcode' and zip_to >= '$postcode' and location = 2");
            $country_code = $country;
            if(in_array($country_code,array('MX','CA'))){
                $res[0]['2day'] = '208';
            }
            $twoday_zone = $res[0]['2day'] ? $res[0]['2day'] : '';
        }

        $lbs = $total_weight*2.2046226;

        if($twoday_zone){
            $day = $twoday_zone;

            if($lbs <= 10000){
                $list = $db->getAll("select lbs,u_".$day." from shipping_ups_price where location = 2 order by id ASC");
                foreach($list as $key=>$v){
                    if($v['lbs'] >= $lbs){
                        $shipping_cost =  $list[$key]["u_".$day] * (1+MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE);
                        break;
                    }
                }
                if($lbs>150){
                    $shipping_cost = $list[count($list)-1]["u_".$day] * $lbs * (1+MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE);
                }

            }else{
                $shipping_cost = 0 ;
            }
        }else{
            return array();
        }

        $status = false;
        $status = $is_buck;

        if($lbs>10000){
            $this->quotes = array();
        }else{
            //$show_total = $_SESSION['cart']->show_total();
            //$show_total = $show_total*0.15;
            //$show_total = $_SESSION['cart']->show_total();
            //$local_total = $order->local_info['subtotal']+$order->delay_info['subtotal'];
            //if(empty($local_total)){
            // $show_total = $_SESSION['cart']->show_total();
            // }else{
            // $show_total = $local_total;
            // }
            $show_total = $price;
            /**
             * ups2day 不在免运费统一ups ground 免运费
             *
             * update by aron
             * 2019.11.7
             */
            $is_shipping_free = false;
            if($shipping_cost) {
                $days = fs_get_east_west_shipping_time($post_code,'east');
                $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
                
                //免运费改成收运费
                if ($lbs < 50 && $is_shipping_free && $status == false && $days>3) {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => 0)));
                } else {
                    $this->quotes = array('id' => $this->code,
                        'ids' => $this->codes,
                        'module' => MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'title' => $this->title,
                            'cost' => $shipping_cost)));

                }
            }else{
                $this->quotes = array();
            }

        }



        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_UPS2DAYSEASTZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_UPS2DAYSEASTZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }



	function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }



	 function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_STATUS', 'True', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_SKIPPED', '', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");
       
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_UPS2DAYSEASTZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
      $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone".$i."','MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS_ZONES_".$i."','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_".$i."','MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS_".$i."','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }



	 function keys() {
      $keys = array('MODULE_SHIPPING_UPS2DAYSEASTZONES_STATUS', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_METHOD', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_CLASS', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_TAX_BASIS', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_SORT_ORDER', 'MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS','MODULE_SHIPPING_UPS2DAYSEASTZONES_SKIPPED','MODULE_SHIPPING_UPS2DAYSEASTZONES_EXTRA_FEE');
	  
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	$keys[] = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS_ZONES_' . $i;
      	$keys[] = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_DAYS_' . $i;
      }
      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_UPS2DAYSEASTZONES_HANDLING_' . $i;
      }

      return $keys;
    }

}
