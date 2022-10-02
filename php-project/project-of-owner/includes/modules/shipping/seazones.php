<?php


  class seazones {
    var $code, $title, $description, $enabled, $num_zones;

// class constructor
    function seazones() {
      $this->code = 'seazones';
      $this->codes = 'SEA';
      $this->title = MODULE_SHIPPING_SEAZONES_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_SEAZONES_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_SEAZONES_SORT_ORDER;
      $this->icon = DIR_WS_MODULES . 'shipping/seazones/sea_logo.gif';
      $this->tax_class = MODULE_SHIPPING_SEAZONES_TAX_CLASS;
      $this->tax_basis = MODULE_SHIPPING_SEAZONES_TAX_BASIS;
	  $this->extra_rate = 1.2;
  if (zen_get_shipping_enabled($this->code)) {
        $this->enabled = ((MODULE_SHIPPING_SEAZONES_STATUS == 'True') ? true : false);
      }

      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      //$this->num_zones = 8;
    }

// class methods
  function quote($method = '') {
     global $order, $total_weight, $shipping_num_boxes, $total_count,$db,$currencies;
	 
     $dest_country = $order->delivery['country']['iso_code_2'];
      return array();
     $status = false;
     if($_SESSION['cart']->contents){
     	$total_price = 0;
     	foreach($_SESSION['cart']->contents as $key=>$v){
     		$qty = $v['qty'];
     		$keys_data = get_product_category_key((int)$key);
            $keys_number = $keys_data['key'];
     		$retail = get_retail_status((int)$key);
     		if($keys_number == 2 || ($keys_number == 1 && $retail==0)){
     			$list = $db->getAll("select * from products_length where id = '".$v['attributes']['length']."' limit 1");
     			if($list){
     				if(strpos($list[0]['length'],'km')){
     					$product_length = substr($list[0]['length'],0,-2)*1000;
     				}else{

     					$product_length = substr($list[0]['length'],0,-1);
     				}
     			}
     			$length = $product_length/1000;
     			$product_id = (int)$key;
     			$result = $db->getAll("select * from shipping_sea_new where countries_iso_code_2 = '$dest_country'");
     			if($length){
     				if($result){
     					$shpt_r = 1;
     					if($this->get_core_status($product_id) == 1){
     						if($length <=2){
     							$shpt = 1.9;
     						}elseif($length >2 && $length <=3){
     							$shpt = 3;
     						}elseif($length >3 && $length <=5){
     							$shpt = 4.1;
     						}else{
     							$shpt = 0;
     							$status = false;
     							break;
     						}
     					}else{

     						if($length <=2){
     							$shpt = 1.3;
     						}elseif($length >2 && $length <=3){
     							$shpt = 2;
     						}elseif($length >3 && $length <=5){
     							$shpt = 2.8;
     						}else{
     							$shpt = 0;
     							$status = false;
     							break;
     						}
							
     					}
     					if(count($result)>1){
     						foreach($result as $key=>$v){
     							if($v['conditions']){
     								if(strpos($v['conditions'],'<<')){
     									$cond_arr = explode('<<',$v['conditions']);
     									if($shpt>= $cond_arr[0] && $shpt<= $cond_arr[1]){
     										$cost = $v['cost'];
     										break;
     									}
     								}
     								if(substr($v['conditions'],0,1) == '<'){
     									if($shpt<substr($v['conditions'],1)){
     										$cost = $v['cost'];
     										break;
     									}
     								}
     								if(substr($v['conditions'],0,1) == '<='){
     									if($shpt<substr($v['conditions'],1)){
     										$cost = $v['cost'];
     										break;
     									}
     								}
     								if(substr($v['conditions'],0,1) == '>'){
     									if($shpt>substr($v['conditions'],1)){
     										$cost = $v['cost'];
     										break;
     									}
     								}
     								if(substr($v['conditions'],0,1) == '>='){
     									if($shpt>substr($v['conditions'],1)){
     										$cost = $v['cost'];
     										break;
     									}
     								}
     							}else{
     								$cost = $v['cost'];
     							}
     						}
     					}else{
     						$cost = $result[0]['cost'];  
     					}
     					$cost = $cost ? $cost : 5;
     					if($shpt == 0){
     						$shipping_cost = 0;
     						$status = false;
     						break;
     					}else{
     						$shipping_cost = $qty*($shpt*$cost*$currencies->currencies['CNY']['value']+$shpt_r*40+320+300+25*$currencies->currencies['CNY']['value']);
     						$status = true;
     					}
     					$shipping_cost = ($shipping_cost) / $currencies->currencies['CNY']['value'];//--get the shipping cost
     					$total_price = $total_price+$shipping_cost;
     				}
     			}
     		}else{
     			$status = false;
     			break;
     		}
     	}
     }
	 
     if($status){
		$total_price = $total_price * $this->extra_rate;
		$total_price = $total_price > 10 ? $total_price : 10;
		if(get_customers_shipping_discount_status()){
				$total_price = 0;
			}
			if(in_array($dest_country,array('US','CA','MX'))){
						$total_price = 0;
			}
			
     	$this->quotes = array('id' => $this->code,
     			'ids' => $this->codes,
     			'module' => MODULE_SHIPPING_SEAZONES_TEXT_TITLE,
     			'methods' => array(array('id' => $this->code,
     					'title' => $this->code,
     					'cost' => $total_price)));
     }else{
     	
     	$this->quotes = array();
     	
     }
     if (zen_not_null($this->icon)){
    	$this->quotes['icon'] = zen_image($this->icon, $this->title);
     	return $this->quotes;
    }
    
    }
    function get_core_status($product_id){
    	global $db;
    	$act = $db->getAll("select is_core from products where products_id = '".$product_id."' limit 1");
    	if($act){
    		$rt = $act[0]['is_core'];
    	}else{
    		$rt = 0;
    	}
    	return $rt;
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
    function quotes($method = '',$total_weight, $country, $post_code = "", $price = 0, $state = "", $is_buck = false, $length_array = array())
    {
        global $order, $total_weight, $shipping_num_boxes, $total_count, $db, $currencies;
        $length = intval($length_array['length']);
        $length = $length / 1000;
        $product_id = $length_array['products_id'];
        $qty = (int)$length_array['qty'];
        $dest_country = trim($country);
        $result = $db->getAll("select * from shipping_sea_new where countries_iso_code_2 = '$dest_country'");
        $shipping_status = false;
        if ($length) {
            if ($result) {
                $shpt_r = 1;
                if ($this->get_core_status($product_id) == 1) {
                    //$sh = 1.9;
                    if ($length <= 2) {
                        $shpt = 1.9;
                    } elseif ($length > 2 && $length <= 3) {
                        $shpt = 3;
                    } elseif ($length > 3 && $length <= 5) {
                        $shpt = 4.1;
                    } else {
                        $shpt = 0;
                    }
                } else {
                    //$sh = 1.3;
                    if ($length <= 2) {
                        $shpt = 1.3;
                    } elseif ($length > 2 && $length <= 3) {
                        $shpt = 2;
                    } elseif ($length > 3 && $length <= 5) {
                        $shpt = 2.8;
                    } else {
                        $shpt = 0;
                    }

                }
                /*if($length<=2){
                       $shpt_r = 1;
                       $shpt = $sh;
                }else{
                       if($length%2 == 0){
                              $shpt_r = intval($length/2);
                              $shpt = intval($length/2)*$sh;
                       }else{

                              $shpt_r = intval($length/2)+1;
                              $shpt = (intval($length/2)+1)*$sh;
                       }
                }*/
                if (count($result) > 1) {
                    foreach ($result as $key => $v) {
                        if ($v['conditions']) {
                            if (strpos($v['conditions'], '<<')) {
                                $cond_arr = explode('<<', $v['conditions']);
                                if ($shpt >= $cond_arr[0] && $shpt <= $cond_arr[1]) {
                                    $cost = $v['cost'];
                                    break;
                                }
                            }
                            if (substr($v['conditions'], 0, 1) == '<') {
                                if ($shpt < substr($v['conditions'], 1)) {
                                    $cost = $v['cost'];
                                    break;
                                }
                            }
                            if (substr($v['conditions'], 0, 1) == '<=') {
                                if ($shpt < substr($v['conditions'], 1)) {
                                    $cost = $v['cost'];
                                    break;
                                }
                            }
                            if (substr($v['conditions'], 0, 1) == '>') {
                                if ($shpt > substr($v['conditions'], 1)) {
                                    $cost = $v['cost'];
                                    break;
                                }
                            }
                            if (substr($v['conditions'], 0, 1) == '>=') {
                                if ($shpt > substr($v['conditions'], 1)) {
                                    $cost = $v['cost'];
                                    break;
                                }
                            }
                        } else {
                            $cost = $v['cost'];
                        }
                    }
                } else {
                    $cost = $result[0]['cost'];
                }
                $cost = $cost ? $cost : 5;
                if ($shpt == 0) {
                    $shipping_cost = 0;
                    $shipping_status = false;
                } else {
                    $shipping_cost = $qty * ($shpt * $cost * $currencies->currencies['CNY']['value'] + $shpt_r * 40 + 320 + 300 + 25 * $currencies->currencies['CNY']['value']);
                    $shipping_status = true;
                }
                $shipping_cost = ($shipping_cost) / $currencies->currencies['CNY']['value'];//--get the shipping cost

            }
        } else {
            return array();
        }
        $shipping_status = true;
        if ($shipping_status) {

            $shipping_cost = $shipping_cost > 10 ? $shipping_cost : 10;
            if (get_customers_shipping_discount_status()) {
                $shipping_cost = 0;
            }

            $shipping_cost = $shipping_cost * $this->extra_rate;
            if (in_array($dest_country, array('US', 'CA', 'MX'))) {
                $shipping_cost = 0;
            }
            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_SEAZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $this->code,
                    'cost' => $shipping_cost)));
        } else {
            $this->quotes = array('id' => $this->code,
                'ids' => $this->codes,
                'module' => MODULE_SHIPPING_SEAZONES_TEXT_TITLE,
                'methods' => array(array('id' => $this->code,
                    'title' => $this->code)),
                'error' => MODULE_SHIPPING_AIRMAILZONES_INVALID_ZONE);
        }

        if (zen_not_null($this->icon)) $this->quotes['icon'] = zen_image($this->icon, $this->title);
        return $this->quotes;

    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SEAZONES_STATUS'");
        $this->_check = $check_query->RecordCount();
      }
      return $this->_check;
    }

    function install() {
      global $db;
	 if (!defined('MODULE_SHIPPING_SEAZONES_TEXT_CONFIG_1_1')) include(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $this->code . '.php');

      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('" . MODULE_SHIPPING_SEAZONES_TEXT_CONFIG_1_1 . "', 'MODULE_SHIPPING_SEAZONES_STATUS', 'True', '" . MODULE_SHIPPING_SEAZONES_TEXT_CONFIG_1_2 . "', '6', '0', 'zen_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('" . MODULE_SHIPPING_SEAZONES_TEXT_CONFIG_2_1 . "', 'MODULE_SHIPPING_SEAZONES_SORT_ORDER', '0', '" . MODULE_SHIPPING_SEAZONES_TEXT_CONFIG_2_2 . "', '6', '0', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_SEAZONES_STATUS','MODULE_SHIPPING_SEAZONES_SORT_ORDER');

      return $keys;
    }
  }
?>