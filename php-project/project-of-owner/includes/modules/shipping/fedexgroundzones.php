<?php

  class fedexgroundzones {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function fedexgroundzones() {
      $this->code = 'fedexgroundzones';
      $this->codes = 'FedEx Ground';
      $this->title = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FEDEXGROUNDZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/fedexgroundzones/fedexground_logo.gif';
      $this->tax_class = MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_BASIS;

	  $this->extra_rate = 1.2;

      // disable only when entire cart is free shipping
      if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_FEDEXGROUNDZONES_STATUS == 'True') ? true : false);
      }

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_zones = 24;
      $this->num_zones_days = 5;

    }

// class methods
    function quote($method = '', $order_tag = false) {
    	
      global $order,$total_weight,$shipping_num_boxes, $total_count,$currencies,$db,$separated_weight;
	 // $states = $order->delivery['state'];
	   $dest_country = $order->delivery['country']['iso_code_2'];
        $shipping_zones = zen_get_shipping_fedex_code_zone($order->delivery['postcode'],1,'groud_zone');
        $states = $shipping_zones ? $shipping_zones : '##';
        $lb = $lbs = $separated_weight*2.2046226;
        $shipping_price = 0;
        if($lbs>150){
            $lbs = $lbs%150;
        }

        if($dest_country = $order->delivery['country']['iso_code_2'] != 'US'){
             return array('id' => $this->code,
                            'ids' => $this->codes,
                                    'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                                    'methods' => array(array('id' => $this->code,
                                                             'title' => $this->code,
                                                             )));
        }

      $dest_zone = 0;
      $error = false;

      for ($i=1; $i<=$this->num_zones; $i++) {
        $countries_table = constant('MODULE_SHIPPING_FEDEXGROUNDZONES_COUNTRIES_' . $i);
        $countries_table = strtoupper(str_replace(' ', '', $countries_table));
        $country_zones = split("[,]", $countries_table);
        if (in_array($states, $country_zones)) {
          $dest_zone = $i;
          break;
        }
        if (in_array('00', $country_zones)){
          $dest_zone = $i;
          break;
        }
      }
      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $zones_cost = constant('MODULE_SHIPPING_FEDEXGROUNDZONES_COST_' . $dest_zone);

        $zones_table = split("[:,]" , $zones_cost);
        $size = sizeof($zones_table);
          if($lb>150){
              $shipping_price = intval($lb/150)*$zones_table[$size-1];
          }
        $done = false;
        for ($i=0; $i<$size; $i+=2) {
          switch (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD) {
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Weight'):
              /*if (ceil($lbs) <= $zones_table[$i]) {*/
        	  if ($lbs <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];

                switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                case (0):
                  $show_box_weight = '';
                  break;
                case (1):
                  $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                  break;
                case (2):
                  $show_box_weight = ' (' . number_format($lbs * $shipping_num_boxes,2) . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS . ')';
                  break;
                default:
                  $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($lbs,2) . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS . ')';
                  break;
                }
                $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states . $show_box_weight;
                $done = true;
          $shipping = $zones_table[$i+1];
                break;
        	    }
      	    break;
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Price'):
// shipping adjustment
              if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];
                $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states;
          $shipping = $zones_table[$i+1];
                $done = true;
                break;
	            }
	          break;
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Item'):
// shipping adjustment
              if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];
                $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states;
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
          $shipping_cost = -1;
          $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_UNDEFINED_RATE;
        } else {
          switch (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD) {
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Weight'):
              // charge per box when done by Price
//              $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);


					$shipping_cost = $shipping;
				
        	  		//$shipping_cost = $shipping_cost * (1 + MODULE_SHIPPING_FEDEXOVERNIGHTZONES_EXTRA_FEE)/ $currencies->currencies['CNY']['value'];
              break;
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Price'):
              // don't charge per box when done by Price
              $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);
            break;
        	  case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Item'):
              // don't charge per box when done by Item
              $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);
            break;
          }
        }
      }
        $shipping_cost += $shipping_price;
        $status = $order->is_local_buck;
        $show_total = $order->local_info['subtotal'];
        $is_shipping_free = $order->local_info['is_shipping_free'];
      if($shipping_cost) {
          $shipping_cost = $shipping_cost * $this->extra_rate;
          if($order->delivery['company_type'] == 'IndividualType'){
              //公司类型为IndividualType 加收 4.15 USD
              $shipping_cost = $shipping_cost + 4.15;
          }
              if ($lb >= 50 && $is_shipping_free && $status == false) {
                  $this->quotes = array('id' => $this->code,
                      'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                      'methods' => array(array('id' => $this->code,
                          'ids' => $this->codes,
                          'title' => $shipping_method,
                          'cost' => 0)));
              } else {
                  $days = fs_get_east_west_shipping_time($order->delivery['postcode'],'east');
                  if($lb < 50 && $is_shipping_free && $days<=3 && $status == false){
                      $this->quotes = array('id' => $this->code,
                          'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                          'methods' => array(array('id' => $this->code,
                              'ids' => $this->codes,
                              'title' => $shipping_method,
                              'cost' => 0)));
                  }else {
                      if($lb < 50 && $is_shipping_free && $days>3 && !$status) {
                          $this->quotes = array();
                      }else {
                          $this->quotes = array('id' => $this->code,
                              'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                              'methods' => array(array('id' => $this->code,
                                  'ids' => $this->codes,
                                  'title' => $shipping_method,
                                  'cost' => $shipping_cost)));
                      }
                  }
              }


      }else{
			
			$this->quotes = array();
      }
      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
      if (strstr(MODULE_SHIPPING_FEDEXGROUNDZONES_SKIPPED, $states)) {
        // don't show anything for this country
        $this->quotes = array();
      } else {
        if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_FEDEXGROUNDZONES_INVALID_ZONE;
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array(),$zone_type = 0,$is_shipping_free = false)
    {

        global $order, $shipping_num_boxes, $total_count, $currencies, $db;
        // $states = $order->delivery['state'];
        $dest_country = $country;
        $shipping_zones = zen_get_shipping_fedex_code_zone($post_code, 1, 'groud_zone');
        $states = $shipping_zones ? $shipping_zones : '##';
        $lb = $lbs = $total_weight * 2.2046226;
        $shipping_price = 0;
        if ($lbs > 150) {
            $lbs = $lbs % 150;
        }

        if ($dest_country = $country != 'US') {
            return array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $this->code,
                )));
        }

        $dest_zone = 0;
        $error = false;

        for ($i = 1; $i <= $this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_FEDEXGROUNDZONES_COUNTRIES_' . $i);
            $countries_table = strtoupper(str_replace(' ', '', $countries_table));
            $country_zones = split("[,]", $countries_table);
            if (in_array($states, $country_zones)) {
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
            $zones_cost = constant('MODULE_SHIPPING_FEDEXGROUNDZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]", $zones_cost);
            $size = sizeof($zones_table);
            if ($lb > 150) {
                $shipping_price = intval($lb / 150) * $zones_table[$size - 1];
            }
            $done = false;
            for ($i = 0; $i < $size; $i += 2) {
                switch (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Weight'):
                        /*if (ceil($lbs) <= $zones_table[$i]) {*/
                        if ($lbs <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($lbs * $shipping_num_boxes, 2) . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($lbs, 2) . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states . $show_box_weight;
                            $done = true;
                            $shipping = $zones_table[$i + 1];
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Price'):
// shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states;
                            $shipping = $zones_table[$i + 1];
                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Item'):
// shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i + 1];
                            $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_WAY . ' ' . $states;
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
                $shipping_cost = -1;
                $shipping_method = MODULE_SHIPPING_FEDEXGROUNDZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD) {
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
//              $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);


                        $shipping_cost = $shipping;

                        //$shipping_cost = $shipping_cost * (1 + MODULE_SHIPPING_FEDEXOVERNIGHTZONES_EXTRA_FEE)/ $currencies->currencies['CNY']['value'];
                        break;
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost += $shipping_price;
        $status = false;
        $status = $is_buck;
        //$local_total = $order->local_info['subtotal']+$order->delay_info['subtotal'];
        //if(empty($local_total)){
        // $show_total = $_SESSION['cart']->show_total();
        // }else{
        // $show_total = $local_total;
        // }
        $show_total = $price;
        if ($shipping_cost) {
            $shipping_cost = $shipping_cost * $this->extra_rate;
            if ($lb >= 50 && $is_shipping_free && $status == false) {
                $this->quotes = array('id' => $this->code,
                    'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                    'methods' => array(array('id' => $this->code,
                        'ids' => $this->codes,
                        'title' => $shipping_method,
                        'cost' => 0)));
            } else {
                $days = fs_get_east_west_shipping_time($post_code, 'west');
                if ($lb < 50 && $is_shipping_free && $days <= 3) {
                    $this->quotes = array('id' => $this->code,
                        'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                        'methods' => array(array('id' => $this->code,
                            'ids' => $this->codes,
                            'title' => $shipping_method,
                            'cost' => 0)));
                } else {
                    if ($lb < 50 && $is_shipping_free && $days > 3) {
                        $this->quotes = array();
                    } else {
                        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                'ids' => $this->codes,
                                'title' => $shipping_method,
                                'cost' => $shipping_cost)));
                    }
                }
            }


        } else {

            $this->quotes = array();
        }
        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        if (strstr(MODULE_SHIPPING_FEDEXGROUNDZONES_SKIPPED, $states)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_FEDEXGROUNDZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FEDEXGROUNDZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_STATUS', 'True', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_SKIPPED', '', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");
       
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_FEDEXGROUNDZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
      $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone".$i."','MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS_ZONES_".$i."','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_".$i."','MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS_".$i."','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_FEDEXGROUNDZONES_STATUS', 'MODULE_SHIPPING_FEDEXGROUNDZONES_METHOD', 'MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_CLASS', 'MODULE_SHIPPING_FEDEXGROUNDZONES_TAX_BASIS', 'MODULE_SHIPPING_FEDEXGROUNDZONES_SORT_ORDER', 'MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS','MODULE_SHIPPING_FEDEXGROUNDZONES_SKIPPED','MODULE_SHIPPING_FEDEXGROUNDZONES_EXTRA_FEE');
	  
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	$keys[] = 'MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS_ZONES_' . $i;
      	$keys[] = 'MODULE_SHIPPING_FEDEXGROUNDZONES_DAYS_' . $i;
      }
      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_FEDEXGROUNDZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_FEDEXGROUNDZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_FEDEXGROUNDZONES_HANDLING_' . $i;
      }

      return $keys;
    }
  }
