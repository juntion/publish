<?php
  class tntauzones {
    var $code, $title, $description, $enabled, $num_zones,$num_zones_days,$handfee_rate;

// class constructor
    function tntauzones()
    {
        $this->code = 'tntauzones';
        $this->codes = 'DHL';
        $this->title = MODULE_SHIPPING_TNTAUZONES_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_TNTAUZONES_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_TNTAUZONES_SORT_ORDER;
        $this->icon = DIR_WS_MODULES . 'shipping/tntauzones/dhl_logo.gif';
        $this->tax_class = MODULE_SHIPPING_TNTAUZONES_TAX_CLASS;
        $this->tax_basis = MODULE_SHIPPING_TNTAUZONES_TAX_BASIS;
        //$this->handfee_rate = 1.215;
        $this->extra_rate = 1;
        if (zen_get_shipping_enabled($this->code)) {
            $this->enabled = ((MODULE_SHIPPING_TNTAUZONES_STATUS == 'True') ? true : false);
        }
        // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
        $this->num_zones = 28;
        $this->num_zones_days = 5;
    }
// class methods
    function quote($method = '') {
   
      global $order, $total_weight, $shipping_num_boxes, $total_count,$currencies;
      //$dest_country = $order->delivery['country']['iso_code_2'];
        $postcode = substr(trim($order->delivery['postcode']),0,4);
        $dest_country =  zen_get_shipping_au_code($postcode,'tnt') ? zen_get_shipping_au_code($postcode,'tnt'):'TNTA';
      $dest_zone = 0;
      $error = false;
		  for ($i=1; $i<=$this->num_zones; $i++) {
			$countries_table = constant('MODULE_SHIPPING_TNTAUZONES_COUNTRIES_' . $i);
			$countries_table = strtoupper(str_replace(' ', '', $countries_table));
			$country_zones = split("[,]", $countries_table);
			if (in_array($dest_country, $country_zones)) {
			  $dest_zone = $i;
			  break;
			}
			if (in_array('00', $country_zones)) {
			  $dest_zone = $i;
			  break;
			}
		  }
        if(!((2000<=$postcode && $postcode<=2234) || (3000<=$postcode && $postcode<=3005) || (3007<=$postcode && $postcode<=3009) || (3011<=$postcode && $postcode<=3031)
            || (3033<=$postcode && $postcode<=3049) || ($postcode == 3051) || (3055<=$postcode && $postcode<=3056) || (3058<=$postcode && $postcode<=3120)
            || (3123<=$postcode && $postcode<=3127) || (3129<=$postcode && $postcode<=3140) || (3143<=$postcode && $postcode<=3180) || (3182<=$postcode && $postcode<=3205)
            || (4000<=$postcode && $postcode<=4207) || (4300<=$postcode && $postcode<=4305)
            || (4500<=$postcode && $postcode<=4519) || (6000<=$postcode && $postcode<=6199)  || (5000<=$postcode && $postcode<=5199) || (800<=$postcode && $postcode<=832)
            || (2600<=$postcode && $postcode<=2609))){
            $dest_zone = 0;
        }
      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
          $zones_cost = constant('MODULE_SHIPPING_TNTAUZONES_COST_' . $dest_zone);

        $zones_table = split("[:,]" , $zones_cost);
        $size = sizeof($zones_table);
        $done = false;
        for ($i=0; $i<$size; $i+=2) {
          switch (MODULE_SHIPPING_TNTAUZONES_METHOD) {
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Weight'):
              /*if (ceil($total_weight) <= $zones_table[$i]) {*/
        	  if ($total_weight <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];

                switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                case (0):
                  $show_box_weight = '';
                  break;
                case (1):
                  $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                  break;
                case (2):
                  $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes,2) . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS . ')';
                  break;
                default:
                  $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight,2) . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS . ')';
                  break;
                }

//                $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS : '');
                $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                $done = true;
                  if ($total_weight > 5){
                      $shipping = $zones_table[$i-1]+$zones_table[$i+1] * ($total_weight-5);
                  }else{
                      $shipping = $zones_table[$i+1];
                  }
        	
                break;
        	    }
      	    break;
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Price'):
// shipping adjustment
              if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];
                $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country;

          $shipping = $zones_table[$i+1];
    
                $done = true;
                break;
	            }
	          break;
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Item'):
// shipping adjustment
              if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                $shipping = $zones_table[$i+1];
                $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country;
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
          $shipping_cost = 0;
          $shipping_method = MODULE_SHIPPING_TNTAUZONES_UNDEFINED_RATE;
        } else {
          switch (MODULE_SHIPPING_TNTAUZONES_METHOD) {
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Weight'):
              // charge per box when done by Price
              $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);
              
              /*$cny_to_current__rate = number_format(($currency->currencies['CNY']['value'] / $currency->currencies[strval($_SESSION['currency'])]['value']) ,2);*/
        	  
              // use us dollar as default 
        	  //$handfee_rate = 1;//--hand fee
              //$shipping_cost = ($shipping * $this->handfee_rate) / $currencies->currencies['CNY']['value'];//--get the shipping cost
				$shipping_cost = ($shipping * (1+MODULE_SHIPPING_TNTAUZONES_EXTRA_FEE)) / $currencies->currencies['AUD']['value'];
              /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
              break;
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Price'):
              // don't charge per box when done by Price
              $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);
            break;
        	  case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Item'):
              // don't charge per box when done by Item
              $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);
            break;
          }
        }
      }
	  $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL) * $this->extra_rate;
	  if($shipping_cost){
             $is_remote = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$order->delivery['postcode'].'" and type = 0 and shipping_type = 2 and is_remote = 1 limit 1');
             if($is_remote){
                 $shipping_cost += 30/$currencies->currencies['AUD']['value'];
             }
            if ($order->delivery['company_type'] == 'IndividualType') {
                //公司类型为IndividualType 加收 5 澳元
                $shipping_cost += 5/$currencies->currencies['AUD']['value'];
            }
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_TNTAUZONES_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                            		'ids' => $this->codes,
                                                     'title' => $shipping_method,
                                                     'cost' => $shipping_cost)));
	  }else{
		  return array();
	  }

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

      if (strstr(MODULE_SHIPPING_TNTAUZONES_SKIPPED, $dest_country)) {
        // don't show anything for this country
        $this->quotes = array();
      } else {
        if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_TNTAUZONES_INVALID_ZONE;
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array()){

        global $order, $shipping_num_boxes, $total_count,$currencies;
        //$dest_country = $order->delivery['country']['iso_code_2'];
        $postcode = substr(trim($post_code),0,4);
        $dest_country =  zen_get_shipping_au_code($postcode,'tnt') ? zen_get_shipping_au_code($postcode,'tnt'):'TNTA';
        $dest_zone = 0;
        $error = false;
        
        for ($i=1; $i<=$this->num_zones; $i++) {
            $countries_table = constant('MODULE_SHIPPING_TNTAUZONES_COUNTRIES_' . $i);
            $countries_table = strtoupper(str_replace(' ', '', $countries_table));
            $country_zones = split("[,]", $countries_table);
            if (in_array($dest_country, $country_zones)) {
                $dest_zone = $i;
                break;
            }
            if (in_array('00', $country_zones)) {
                $dest_zone = $i;
                break;
            }
        }
        if(!((2000<=$post_code && $post_code<=2234) || (3000<=$post_code && $post_code<=3005) || (3007<=$post_code && $post_code<=3009) || (3011<=$post_code && $post_code<=3031)
            || (3033<=$post_code && $post_code<=3049) || ($post_code == 3051) || (3055<=$post_code && $post_code<=3056) || (3058<=$post_code && $post_code<=3120)
            || (3123<=$post_code && $post_code<=3127) || (3129<=$post_code && $post_code<=3140) || (3143<=$post_code && $post_code<=3180) || (3182<=$post_code && $post_code<=3205)
            || (4000<=$post_code && $post_code<=4207) || (4300<=$post_code && $post_code<=4305)
            || (4500<=$post_code && $post_code<=4519) || (6000<=$post_code && $post_code<=6199)  || (5000<=$post_code && $post_code<=5199) || (800<=$post_code && $post_code<=832)
            || (2600<=$post_code && $post_code<=2609))){
            $dest_zone = 0;
        }
        if ($dest_zone == 0) {
            $error = true;
        } else {
            $shipping = -1;
            $zones_cost = constant('MODULE_SHIPPING_TNTAUZONES_COST_' . $dest_zone);

            $zones_table = split("[:,]" , $zones_cost);
            $size = sizeof($zones_table);
            $done = false;
            for ($i=0; $i<$size; $i+=2) {
                switch (MODULE_SHIPPING_TNTAUZONES_METHOD) {
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Weight'):
                        /*if (ceil($total_weight) <= $zones_table[$i]) {*/
                        if ($total_weight <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];

                            switch (SHIPPING_BOX_WEIGHT_DISPLAY) {
                                case (0):
                                    $show_box_weight = '';
                                    break;
                                case (1):
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' ' . TEXT_SHIPPING_BOXES . ')';
                                    break;
                                case (2):
                                    $show_box_weight = ' (' . number_format($total_weight * $shipping_num_boxes,2) . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS . ')';
                                    break;
                                default:
                                    $show_box_weight = ' (' . $shipping_num_boxes . ' x ' . number_format($total_weight,2) . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS . ')';
                                    break;
                            }

//                $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country . (SHIPPING_BOX_WEIGHT_DISPLAY >= 2 ? ' : ' . $total_weight . ' ' . MODULE_SHIPPING_TNTAUZONES_TEXT_UNITS : '');
                            $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country . $show_box_weight;
                            $done = true;
                            if ($total_weight > 5){
                                $shipping = $zones_table[$i-1]+$zones_table[$i+1] * ($total_weight-5);
                            }else{
                                $shipping = $zones_table[$i+1];
                            }

                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Price'):
// shipping adjustment
                        if (($_SESSION['cart']->show_total() - $_SESSION['cart']->free_shipping_prices()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];
                            $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country;

                            $shipping = $zones_table[$i+1];

                            $done = true;
                            break;
                        }
                        break;
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Item'):
// shipping adjustment
                        if (($total_count - $_SESSION['cart']->free_shipping_items()) <= $zones_table[$i]) {
                            $shipping = $zones_table[$i+1];
                            $shipping_method = MODULE_SHIPPING_TNTAUZONES_TEXT_WAY . ' ' . $dest_country;
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
                $shipping_cost = 0;
                $shipping_method = MODULE_SHIPPING_TNTAUZONES_UNDEFINED_RATE;
            } else {
                switch (MODULE_SHIPPING_TNTAUZONES_METHOD) {
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Weight'):
                        // charge per box when done by Price
                        $shipping_cost = ($shipping * $shipping_num_boxes) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);

                        /*$cny_to_current__rate = number_format(($currency->currencies['CNY']['value'] / $currency->currencies[strval($_SESSION['currency'])]['value']) ,2);*/

                        // use us dollar as default
                        //$handfee_rate = 1;//--hand fee
                        //$shipping_cost = ($shipping * $this->handfee_rate) / $currencies->currencies['CNY']['value'];//--get the shipping cost
                        $shipping_cost = ($shipping * (1+MODULE_SHIPPING_TNTAUZONES_EXTRA_FEE)) / $currencies->currencies['AUD']['value'];
                        /* echo $cny_to_current__rate . ', '.$shipping .', '.$shipping_cost;exit(); */
                        break;
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Price'):
                        // don't charge per box when done by Price
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);
                        break;
                    case (MODULE_SHIPPING_TNTAUZONES_METHOD == 'Item'):
                        // don't charge per box when done by Item
                        $shipping_cost = ($shipping) + constant('MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $dest_zone);
                        break;
                }
            }
        }
        $shipping_cost = $shipping_cost * (1 + SHIPPING_METHOD_DHL) * $this->extra_rate;
        if($shipping_cost){
            $is_remote = fs_get_data_from_db_fields('id', 'fs_shipping_sameday_post', 'post_zip ="'.$post_code.'" and type = 0 and shipping_type = 2 and is_remote = 1 limit 1');
            if($is_remote){
                $shipping_cost += 30/$currencies->currencies['AUD']['value'];
            }
            $this->quotes = array('id' => $this->code,
                'module' => MODULE_SHIPPING_TNTAUZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'ids' => $this->codes,
                    'title' => $shipping_method,
                    'cost' => $shipping_cost)));
        }else{
            return array();
        }

        if ($this->tax_class > 0) {
            $this->quotes['tax'] = zen_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);

        if (strstr(MODULE_SHIPPING_TNTAUZONES_SKIPPED, $dest_country)) {
            // don't show anything for this country
            $this->quotes = array();
        } else {
            if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_TNTAUZONES_INVALID_ZONE;
        }

        return $this->quotes;
    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_TNTAUZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_TNTAUZONES_STATUS', 'True', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_TNTAUZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_TNTAUZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_TNTAUZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_TNTAUZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_TNTAUZONES_SKIPPED', '', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
	 $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_TNTAUZONES_EXTRA_FEE', '填写DHL的燃油附加费,用小数表示,例如: 0.215 ', '" . '0.215' . "', '6', '0', 'zen_cfg_textarea(', now())");
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_TNTAUZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_TNTAUZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_TNTAUZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_TNTAUZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_TNTAUZONES_STATUS', 'MODULE_SHIPPING_TNTAUZONES_METHOD', 'MODULE_SHIPPING_TNTAUZONES_TAX_CLASS', 'MODULE_SHIPPING_TNTAUZONES_TAX_BASIS', 'MODULE_SHIPPING_TNTAUZONES_SORT_ORDER','MODULE_SHIPPING_TNTAUZONES_DAYS', 'MODULE_SHIPPING_TNTAUZONES_SKIPPED','MODULE_SHIPPING_TNTAUZONES_EXTRA_FEE');
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	$keys[] = 'MODULE_SHIPPING_TNTAUZONES_DAYS_ZONES_' . $i;
      	$keys[] = 'MODULE_SHIPPING_TNTAUZONES_DAYS_' . $i;
      }

      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_TNTAUZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_TNTAUZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_TNTAUZONES_HANDLING_' . $i;
      }
      return $keys;
    }
  }
