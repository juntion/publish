<?php
/**
 * currencies Class.
 *
 * @package classes
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: currencies.php 15880 2010-04-11 16:24:30Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * currencies Class.
 * Class to handle currencies
 *
 * @package classes
 */
class currencies extends base {
	var $currencies;

	// class constructor
	function currencies() {
		global $db;
		$this->currencies = array();
		$currencies_query = "select currencies_id,code, title, symbol_left,symbol_google_left,symbol_var, symbol_right, decimal_point,
                                  thousands_point, decimal_places, value
                          from " . TABLE_CURRENCIES;

		$currencies = $db->Execute($currencies_query);
		while (!$currencies->EOF) {
			$decimal_point =$currencies->fields['decimal_point'];
			$thousands_point =$currencies->fields['thousands_point'];
            if(trim($currencies->fields['code'])=='EUR'){
                //欧元的价格小数点是逗号[,]，千分位分隔符是点号[.]
                $decimal_point =',';
                $thousands_point ='.';
            }
            if(trim($currencies->fields['code'])=='RUB'){
                //卢布的价格小数点是逗号[.]，千分位分隔符是点号空格
                $decimal_point ='.';
                $thousands_point =' ';
            }

            $this->currencies[$currencies->fields['code']] = array(
				'title' => $currencies->fields['title'],
				'symbol_left' => $currencies->fields['symbol_right'] ? '' : $currencies->fields['symbol_left'],
				'symbol_google_left' => $currencies->fields['symbol_google_left'],
				'symbol_var' => $currencies->fields['symbol_var'],
				'symbol_right' => $currencies->fields['symbol_right'],
				'decimal_point' => $decimal_point,
				'thousands_point' => $thousands_point,
				'decimal_places' => $currencies->fields['decimal_places'],
				'value' => $currencies->fields['value'],
                'currencies_id' => $currencies->fields['currencies_id'],
			);
			$currencies->MoveNext();
		}
	}
	// class methods
	function format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$num = get_products_specail_currency_final_price($number*$rate);
		if ($calculate_currency_value == true) {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];

		} else {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];

		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}

    // class methods
    function format_special($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $num = get_products_specail_currency_final_price($number*$rate);
        $left = $this->currencies[$currency_type]['symbol_right'] ? '' : $this->currencies[$currency_type]['symbol_var'];
        if ($calculate_currency_value == true) {
            $format_string = $left . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];

        } else {
            $format_string = $left . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];

        }

        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }

	// class methods
    function format_tax($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $num =  get_products_specail_currency_final_price($number*$rate);

        if ($calculate_currency_value == true) {
            $format_string = str_replace('AU$&nbsp;&nbsp;','A$',$this->currencies[$currency_type]['symbol_left']) . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places'])*1.1, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        } else {
            $format_string = str_replace('&nbsp;&nbsp;','',$this->currencies[$currency_type]['symbol_left']) . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places'])*1.1, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        }

        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }


    function total_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$num = $number*$rate;
		if ($calculate_currency_value == true) {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		} else {
				$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}

	function update_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];

		if ($calculate_currency_value == true) {
			$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];

			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($number , $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		} else {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}
  
	function fs_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
		//生成不带货币符号的价格
		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
  
		if ($calculate_currency_value == true) {
			$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			$format_string = number_format(zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) ;
		} else {
			$format_string = number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
		}
  
		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}
  
		return $format_string;
	}
    function fs_format_new($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

        if (empty($currency_type)) $currency_type = $_SESSION['currency'];

        if ($calculate_currency_value == true) {
            $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
            $format_string =zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']) ;
        } else {
            $format_string =zen_round($number, $this->currencies[$currency_type]['decimal_places']);
        }

        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }

    //生成int型产品价格
    function fs_format_po($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
            if (empty($currency_type)) $currency_type = $_SESSION['currency'];
            $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
            $num = get_products_specail_currency_final_price($number*$rate);
            if ($calculate_currency_value == true) {
                $format_string =  number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);

            } else {
                $format_string =  number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);

            }

            if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
                $format_string= '';
            }

            return $format_string;
        }

    /**
     * add by quest 2019-04-01
     * 其他币种转换成美元
     * @param $number
     * @param bool $calculate_currency_value
     * @param string $currency_type
     * @param string $currency_value
     * @return float|int
     */
    function fs_format_for_usd($number, $calculate_currency_value = true, $currency_type = '', $currency_value = ''){

        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        if ($currency_type == "GBP"){
            $rate *= 1.05;  //去除uk站点的1.05价格提升
        }
        $format_string = number_format(zen_round($number / $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);

        return $format_string;
    }

    function fs_format_number($number){
        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $number =  number_format(zen_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);
        return $number;
    }
	//google
	function goole_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$wholesale_products = fs_get_wholesale_products_array();
		if($_GET['cart_quantity']){
			if(!in_array($_GET['products_id'],$wholesale_products)){
				$num = $number*$rate;
			}else{
				$num = get_products_specail_currency_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity']),0)*$rate;
			}	 
		}else{ 
			if(!in_array($_GET['products_id'],$wholesale_products)){  			 
				$num = get_products_all_currency_final_price($number*$rate);
			}else{
				$num = get_products_specail_currency_final_price($number*$rate);
			}
		}
		if ($calculate_currency_value == true) {
			$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			$format_string = '<meta itemprop="priceCurrency" content="'.$currency_type.'"></span>'.'<meta itemprop="price" content="'. number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], '') .'">' . $this->currencies[$currency_type]['symbol_right'];
		} else {
			$format_string = '<meta itemprop="priceCurrency" content="'.$currency_type.'"></span>'.'<meta itemprop="price" content ="'. number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], '') .'">' . $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}
  
	function new_goole_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$wholesale_products = fs_get_wholesale_products_array();
        $vat = 1;
//		if($_SESSION['languages_code'] =="au"){ //在zen_get_products_final_price中 AU已计算税后价
//			if($_SESSION['countries_iso_code'] !="nz"){
//				$vat = 1.1;	 //如果是新西兰则展示税前价格 澳大利亚则展示税后价格
//			}
//		}else
        if(in_array($_SESSION['languages_code'],['de','dn'])){
		    $vat = getVaxByCountry($_SESSION['countries_iso_code']);
//			if(german_warehouse("country_code",$_SESSION['countries_iso_code'])){
//				//欧盟国家展示的谷歌微数据中的价格是加上19%的税收后的总价格
//				$vat = 1.19;
//			}else{
//                $vat = 1;
//            }
		}elseif(get_price_vat_uk_show()){
                $vat = 1.2;  //UK站展示税后价
        }else{
		    if($_SESSION['countries_iso_code'] == 'sg'){
		        $vat = 1.07;
            }
		    if($_SESSION['countries_iso_code'] == 'ru'){
		        $vat = 1.2;
            }
		}

		if($_GET['cart_quantity']){
			if(!in_array($_GET['products_id'],$wholesale_products)){
				 $num = $number*$rate;
			}else{
				 $num = get_products_specail_currency_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity']),0)*$rate;
			}
		}else{
		    //在zen_get_products_final_price 函数中已经四舍五入过了 这里没有必要再次处理
//			if(!in_array($_GET['products_id'],$wholesale_products)){
//				$num = get_products_all_currency_final_price($number*$rate);
//			}else{
//				$num = get_products_specail_currency_final_price($number*$rate);
//			}
            $num = $number*$rate;
		}
		if ($calculate_currency_value == true) {
			$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			$format_string =  number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places'])*$vat, $this->currencies[$currency_type]['decimal_places'], '.', '');
		} else {
			$format_string =  number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places'])*$vat, $this->currencies[$currency_type]['decimal_places'], '.', '');
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}  
  
	function new_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '', $is_tax_shipping = false) {
		if (empty($currency_type)) $currency_type = $_SESSION['currency'];
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        if($is_tax_shipping){
            $num = $number;
        }else{
            $num = get_products_all_currency_final_price($number*$rate);
        }
		if ($calculate_currency_value == true) {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		} else {
			$format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num,  $this->currencies[$currency_type]['decimal_places']),$this->currencies[$currency_type]['decimal_places'],$this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
			$format_string= '';
		}

		return $format_string;
	}

    function new_format_clearance($number, $type, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        if($type == 0){
            $num = get_products_all_currency_final_price($number*$rate);
        }elseif ($type == 1){
            $num = get_products_specail_currency_final_price($number*$rate);
        }
        if ($calculate_currency_value == true) {
            $format_string = zen_round($num, $this->currencies[$currency_type]['decimal_places']);
        } else {
            $format_string = zen_round($num, $this->currencies[$currency_type]['decimal_places']);
        }

        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }

	 function new_format_tax($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $num = get_products_all_currency_final_price($number*$rate);
        if ($calculate_currency_value == true) {
            $format_string =  str_replace('AU$&nbsp;&nbsp;','A$',$this->currencies[$currency_type]['symbol_left']) . number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places'])*1.1, $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        } else {
            $format_string =  $this->currencies[$currency_type]['symbol_left'] . number_format(zen_round($num,  $this->currencies[$currency_type]['decimal_places'])*1.1,$this->currencies[$currency_type]['decimal_places'],$this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];
        }
        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }
  
	function total_format_new($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

        if (empty($currency_type)) $currency_type = $_SESSION['currency'];
        $rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
        $num = $number*$rate;
        if ($calculate_currency_value == true) {
            $format_string = zen_round($num, $this->currencies[$currency_type]['decimal_places']);
        } else {
            $format_string =zen_round($num, $this->currencies[$currency_type]['decimal_places']);
        }

        if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
            $format_string= '';
        }

        return $format_string;
    }
  
	function rateAdjusted($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];

		if ($calculate_currency_value == true) {
			$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			$result = zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']);
		} else {
			$result = zen_round($number, $this->currencies[$currency_type]['decimal_places']);
		}
		return $result;
	}
  
	function value($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];

		if ($calculate_currency_value == true) {
			if ($currency_type == DEFAULT_CURRENCY) {
				$rate = (zen_not_null($currency_value)) ? $currency_value : 1/$this->currencies[$_SESSION['currency']]['value'];
			} else {
				$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			}
			$currency_value = zen_round(get_products_specail_currency_final_price($number * $rate), $this->currencies[$currency_type]['decimal_places']);
		} else {
			$currency_value = zen_round(get_products_specail_currency_final_price($number), $this->currencies[$currency_type]['decimal_places']);
		}

		return $currency_value;
	}
	
	function total_value($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];

		if ($calculate_currency_value == true) {
			if ($currency_type == DEFAULT_CURRENCY) {
				$rate = (zen_not_null($currency_value)) ? $currency_value : 1/$this->currencies[$_SESSION['currency']]['value'];
			} else {
				$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			}
			$currency_value = zen_round($number * $rate, $this->currencies[$currency_type]['decimal_places']);
		} else {
			$currency_value = zen_round($number, $this->currencies[$currency_type]['decimal_places']);
		}

		return $currency_value;
	}
  
	function new_value($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {

		if (empty($currency_type)) $currency_type = $_SESSION['currency'];

		if ($calculate_currency_value == true) {
			if ($currency_type == DEFAULT_CURRENCY) {
				$rate = (zen_not_null($currency_value)) ? $currency_value : 1/$this->currencies[$_SESSION['currency']]['value'];
			} else {
				$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
			}
			$num = get_products_all_currency_final_price($number * $rate);
			$currency_value = zen_round($num, $this->currencies[$currency_type]['decimal_places']);
		} else {
			$num = get_products_all_currency_final_price($number * $rate);
			$currency_value = zen_round($num, $this->currencies[$currency_type]['decimal_places']);
		}

		return $currency_value;
	}
  

	function is_set($code) {
		if (isset($this->currencies[$code]) && zen_not_null($this->currencies[$code])) {
			return true;
		} else {
			return false;
		}
	}
	
	function current_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
    
		if (empty($currency_type)){
			if($_SESSION['languages_code'] == 'jp'){
				$currency_type = 'JPY';
			}else{
				 $currency_type = $_SESSION['currency'];
			}
		} 
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$num = get_products_specail_currency_final_price($number*$rate);
	   if ($calculate_currency_value == true) {
		  $format_string =number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']). $this->currencies[$currency_type]['symbol_right'];
		} else {
		  $format_string =number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']). $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
		  $format_string= '';
		}

		return $format_string;
    }
	
	function current_new_format($number, $calculate_currency_value = true, $currency_type = '', $currency_value = '') {
		  
		if (empty($currency_type)){
			if($_SESSION['languages_code'] == 'jp'){
				$currency_type = 'JPY';
			}else{
				 $currency_type = $_SESSION['currency'];
			}
		}
		$rate = (zen_not_null($currency_value)) ? $currency_value : $this->currencies[$currency_type]['value'];
		$num = get_products_all_currency_final_price($number*$rate);
		if ($calculate_currency_value == true) {
		 
		  $format_string =number_format(zen_round($num, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']). $this->currencies[$currency_type]['symbol_right'];
		} else {
		  $format_string =number_format(zen_round($num,  $this->currencies[$currency_type]['decimal_places']),$this->currencies[$currency_type]['decimal_places'],$this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']). $this->currencies[$currency_type]['symbol_right'];
		}

		if ((DOWN_FOR_MAINTENANCE=='true' and DOWN_FOR_MAINTENANCE_PRICES_OFF=='true') and (!strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR']))) {
		  $format_string= '';
		}

		return $format_string;
	 }
	function get_value($code) {
		return $this->currencies[$code]['value'];
	}

	function get_decimal_places($code) {
		return $this->currencies[$code]['decimal_places'];
	}

	function display_price($products_price, $products_tax, $quantity = 1) {
		return $this->format(zen_add_tax($products_price, $products_tax) * $quantity);
	}

    function display_special_price($products_price, $products_tax, $quantity = 1) {
        return $this->format_special(zen_add_tax($products_price, $products_tax) * $quantity);
    }
  
	function new_display_price($products_price, $products_tax, $quantity = 1) {
		return $this->new_format(zen_add_tax($products_price, $products_tax) * $quantity);
	}
	function display_price_tax($products_price, $products_tax, $quantity = 1) {
        return $this->format_tax(zen_add_tax($products_price, $products_tax) * $quantity);
    }
	
	function new_display_price_tax($products_price, $products_tax, $quantity = 1) {
        return $this->new_format_tax(zen_add_tax($products_price, $products_tax) * $quantity);
    }
  
	function display_price_rate($products_price, $products_tax, $quantity = 1) {
		return $this->update_format(zen_add_tax($products_price, $products_tax) * $quantity);
	}
	//currency
	function display_currency_price($products_price, $products_tax, $quantity = 1,$currency=""){
		return $this->format(zen_add_tax($products_price, $products_tax) * $quantity,true,$currency);
	}
	function display_goole_price($products_price, $products_tax, $quantity = 1) {
		return $this->goole_format(zen_add_tax($products_price, $products_tax) * $quantity);
	}
	function display_new_goole_price($products_price, $products_tax, $quantity = 1) {
		return $this->new_goole_format(zen_add_tax($products_price, $products_tax) * $quantity);
	}
	function display_currency_total_price($products_price, $products_tax, $quantity = 1,$currency=""){
		return $this->total_format(zen_add_tax($products_price, $products_tax) * $quantity,true,$currency);
	}
	function display_current_price($products_price, $products_tax, $quantity = 1) {
		return $this->current_format(zen_add_tax($products_price, $products_tax) * $quantity);
	}
  
    function display_current_new_price($products_price, $products_tax, $quantity = 1) {
       return $this->current_new_format(zen_add_tax($products_price, $products_tax) * $quantity);
    }
}
