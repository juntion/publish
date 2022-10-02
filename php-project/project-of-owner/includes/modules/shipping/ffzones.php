<?php   
class ffzones {
	 var $code, $title, $description, $enabled, $num_zones;
	 function ffzones(){
	  $this->code = 'ffzones';
      $this->codes = 'ODFL';
      $this->title = MODULE_SHIPPING_FFZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FFZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FFZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/freightzones/fedexground_logo.gif';
      $this->tax_class = MODULE_SHIPPING_FFZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_FFZONES_TAX_BASIS;
	  $this->shipping_price = array('AL'=>array(368.34,662.44),'AZ'=>array(269.45,464.66),'AR'=>array(418.02,768.14),'CA'=>array(188.56,316.28),'CO'=>array(256.02,437.79),'CT'=>array(548.31,1022.38),'DE'=>array(573.84,1073.42),'FL'=>array(481.57,888.91),'GA'=>array(457.26,799.24),'AK'=>array(749.33,749.33),'ID'=>array(151.34,237.27),'IL'=>array(224.57,389.02),'IN'=>array(409.11,472.41),'IA'=>array(365.30,515.39),'KS'=>array(256.72,453.34),'KY'=>array(415.36,699.58),'LA'=>array(444.79,745.79),'ME'=>array(568.54,1062.85),'MD'=>array(447.76,821.28),'MA'=>array(509.22,944.19),'MI'=>array(412.14,750.02),'MN'=>array(296.17,518.1),'MS'=>array(404.13,734.01),'MO'=>array(230.56,401.00),'MT'=>array(161.74,260.75),'NE'=>array(324.71,575.18),'NV'=>array(205.48,339.33),'NH'=>array(509.22,944.19),'NJ'=>array(464.07,853.9),'NM'=>array(326.37,578.50),'NC'=>array(360.34,646.45),'ND'=>array(229.37,387.11),'OH'=>array(339.88,619.64),'OK'=>array(334.22,594.2),'OR'=>array(147.19,231.65),'PA'=>array(464.07,853.9),'RI'=>array(693.71,1313.18),'SC'=>array(486.26,898.28),'SD'=>array(258.57,442.92),'TN'=>array(301.98,543.83),'TX'=>array(419.38,764.52),'UT'=>array(207.81,344),'VT'=>array(545.59,1025.92),'VA'=>array(550.3,976.36),'WA'=>array(154.05,236.5),'WV'=>array(350.22,626.2),'WI'=>array(283.46,504.19),'WY'=>array(219.04,366.44));
	  $this->extra_rate = 1.2;

  if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_FFZONES_STATUS == 'True') ? true : false);
      }
      $this->num_zones = 24;
      $this->num_zones_days = 5;
	}


	  function quote($method = '') {	
      global $order,$total_weight,$shipping_num_boxes, $total_count,$currencies,$db;
	  $states = zen_get_countries_us_states_code($order->delivery['state']);
	  $country = $order->delivery['country']['iso_code_2'];
	  $states = $states ? $states : 'AL';
	 if($total_weight){
				foreach($this->shipping_price as $keys=>$v){
					if($states == $keys){
						if($total_weight <= 477){
							$shipp_price = $v[0];
						}elseif($total_weight>477 && $total_weight<=954){
							$shipp_price = $v[1];
					    }else{
							$shipp_price = round($total_weight/477,2)*$v[0];
						}
						
					
						break;

					}
				}
				}

	
	$status = false;
		foreach($_SESSION['cart']->contents as $key=>$v){
					if(fs_zen_get_product_category_id($key,array(2907,900,3093,3091))){
						$status = true;
						break;
					}
					$keys_data = get_product_category_key($key);
                    $keys = $keys_data['key'];
					if($keys == 1 || $keys == 2){
						 $status = true;
						break;
					}
      	}
      if($total_weight >= 150*0.4535924){

		  $shipp_price = $shipp_price * $this->extra_rate;
		  if($status == true){
              $this->quotes = array('id' => $this->code,
                  'module' => MODULE_SHIPPING_UPSGROUNDZONES_TEXT_TITLE,
                  'methods' => array(array('id' => $this->code,
                      'ids' => $this->codes,
                      'title' =>$this->title,
                      'cost' => $shipp_price)));
		  }else{
              return array();
		  }
      		
      }else{
			return array();
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
    function quotes($method = '',$total_weight,$country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array())
    {
        global $order, $shipping_num_boxes, $total_count, $currencies, $db;
        $states = zen_get_countries_us_states_code($state);
        $country = $country;
        $states = $states ? $states : 'AL';
        if ($total_weight) {
            foreach ($this->shipping_price as $keys => $v) {
                if ($states == $keys) {
                    if ($total_weight <= 477) {
                        $shipp_price = $v[0];
                    } elseif ($total_weight > 477 && $total_weight <= 954) {
                        $shipp_price = $v[1];
                    } else {
                        $shipp_price = round($total_weight / 477, 2) * $v[0];
                    }


                    break;

                }
            }
        }


        $status = false;
        foreach ($_SESSION['cart']->contents as $key => $v) {
            if (fs_zen_get_product_category_id($key, array(2907, 900, 3093, 3091))) {
                $status = true;
                break;
            }
            $keys_data = get_product_category_key($key);
            $keys = $keys_data['key'];
            if ($keys == 1 || $keys == 2) {
                $status = true;
                break;
            }
        }
        if ($total_weight >= 150 * 0.4535924) {

            $shipp_price = $shipp_price * $this->extra_rate;
            if ($status == true) {
                $this->quotes = array('id' => $this->code,
                    'module' => MODULE_SHIPPING_UPSGROUNDZONES_TEXT_TITLE,
                    'methods' => array(array('id' => $this->code,
                        'ids' => $this->codes,
                        'title' => $this->title,
                        'cost' => $shipp_price)));
            } else {
                return array();
            }

        } else {
            return array();
        }
        return $this->quotes;
    }



	function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FFZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }



	 function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_FFZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_FFZONES_STATUS', 'True', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_FFZONES_METHOD', 'Weight', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_2_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Weight\', \'Price\', \'Item\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_3_1 . "', 'MODULE_SHIPPING_FFZONES_TAX_CLASS', '0', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_3_2 . "', '6', '0', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_4_1 . "', 'MODULE_SHIPPING_FFZONES_TAX_BASIS', 'Shipping', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_4_2 . "', '6', '0', 'zen_cfg_select_option(array(\'Shipping\', \'Billing\', \'Store\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_5_1 . "', 'MODULE_SHIPPING_FFZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_5_2 . "', '6', '0', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_6_1 . "', 'MODULE_SHIPPING_FFZONES_SKIPPED', '', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_6_2 . "', '6', '0', 'zen_cfg_textarea(', now())");
      
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . '燃油附加费' . "', 'MODULE_SHIPPING_FFZONES_EXTRA_FEE', '填写Fedex的燃油附加费,用小数表示,例如: 0.165 ', '" . '0.165' . "', '6', '0', 'zen_cfg_textarea(', now())");
       
      for ($i = 1; $i <= $this->num_zones; $i++) {
        $default_countries = '';
        if ($i == 1) {
          $default_countries = 'US,CA';
        }
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_7_1 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_7_2 . "', 'MODULE_SHIPPING_FFZONES_COUNTRIES_" . $i ."', '" . $default_countries . "', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_7_3 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_7_4 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_8_1 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_8_2 . "', 'MODULE_SHIPPING_FFZONES_COST_" . $i ."', '3:8.50,7:10.50,99:20.00', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_8_3 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_8_4 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_8_5 . "', '6', '0', 'zen_cfg_textarea(', now())");
        $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_9_1 . $i . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_9_2 . "', 'MODULE_SHIPPING_FFZONES_HANDLING_" . $i."', '0', '" . MODULE_SHIPPING_FFZONES_TEXT_CONFIG_9_3 . "', '6', '0', now())");
      }
      $db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('时间天数','MODULE_SHIPPING_FFZONES_DAYS','1-4 Days','时间天数','6',0,'','2013-06-30 18:04:48','','')");
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_Zone".$i."','MODULE_SHIPPING_FFZONES_DAYS_ZONES_".$i."','US','countrys','6',0,'','2013-06-30 18:04:48','','zen_cfg_textarea(')");
      	 
      	$db->Execute("insert into configuration (configuration_title,configuration_key,configuration_value,configuration_description,configuration_group_id,sort_order,last_modified,date_added,use_function,set_function) values ('Delivery_Time_".$i."','MODULE_SHIPPING_FFZONES_DAYS_".$i."','3-7 Days','Delivery Time','6',0,'','2013-06-30 18:04:48','','')");
      }
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }



	 function keys() {
      $keys = array('MODULE_SHIPPING_FFZONES_STATUS', 'MODULE_SHIPPING_FFZONES_METHOD', 'MODULE_SHIPPING_FFZONES_TAX_CLASS', 'MODULE_SHIPPING_FFZONES_TAX_BASIS', 'MODULE_SHIPPING_FFZONES_SORT_ORDER', 'MODULE_SHIPPING_FFZONES_DAYS','MODULE_SHIPPING_FFZONES_SKIPPED','MODULE_SHIPPING_FFZONES_EXTRA_FEE');
	  
      for ($i=1; $i<=$this->num_zones_days; $i++) {
      	$keys[] = 'MODULE_SHIPPING_FFZONES_DAYS_ZONES_' . $i;
      	$keys[] = 'MODULE_SHIPPING_FFZONES_DAYS_' . $i;
      }
      for ($i=1; $i<=$this->num_zones; $i++) {
        $keys[] = 'MODULE_SHIPPING_FFZONES_COUNTRIES_' . $i;
        $keys[] = 'MODULE_SHIPPING_FFZONES_COST_' . $i;
        $keys[] = 'MODULE_SHIPPING_FFZONES_HANDLING_' . $i;
      }

      return $keys;
    }

}