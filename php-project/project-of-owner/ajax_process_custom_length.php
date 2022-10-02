<?php
require 'includes/application_top.php';
$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
if($_GET['type'] == 'custom'){
	$products_id = $_POST['products_id'];
	$custom_length = $_POST['custom_length'];
	$allAttr = $_POST['allAttr'];
	$oPtionVal = array();
    //当前定制产品选中的属性项数组，属性值数组，层级属性数组
    $options_id = $values_id = $columnID = [];
	$totalPrice = 0;
	if($allAttr){
		$attrArr = explode(',',$allAttr);
		if(sizeof($attrArr)){
			foreach($attrArr as $v){
				$vArr = explode(':',$v);
				$option = $vArr[0];
                $options_id[] = $option;
				if(strpos($vArr[1],'_')){
					$column = explode('_',$vArr[1]);
					$oPtionVal[$option][] = $column;
                    $values_id[] = $column[0];
                    $columnID[$option][$column[0]] = $column[1];
				}else{
					$oPtionVal[$option][] = $vArr[1];
                    $values_id[] = $vArr[1];
                    $columnID[$option][$vArr[1]] = 0;
				}
				
			}
		}
	}
	if($products_id){
		if(is_numeric($custom_length) && $custom_length>0){
			$length_s = $custom_length;
			if($custom_length<1) $length_s = 1;
			//查找该产品的价格
			$currency = $_SESSION['currency'];
			$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
			$products_price = fs_get_data_from_db_fields('products_price',TABLE_PRODUCTS,'products_id='.$products_id,'limit 1');
			$wholesale_products = fs_get_wholesale_products_array();
			if (!in_array((int)$products_id, $wholesale_products)) {
				$products_price = get_products_all_currency_final_price($products_price*$currency_value);
			} else {
				$products_price = get_products_specail_currency_final_price($products_price*$currency_value);
			}
			$priceArr = get_length_range_price($products_id,$custom_length);
			$price = $products_price/$currency_value+$priceArr['length_price'];
			$custom_length = round($custom_length,2);
            $attrPrice = get_products_all_attribute_price_new($products_id, $columnID, $length_s);
			$totalPrice = $price + $attrPrice;
			$quotePriceText='';
			if(isset($_POST['type']) && $_POST['type']=="quote"){
				$quotePrice=0;
				$discount_pre=1;
				if($_SESSION['member_level']>1){
					$discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], '');
					if(!empty($discount) && $discount!=1){
						$discount_pre = $discount;
					}
					$quotePrice = $totalPrice*$discount_pre;
					$quotePriceText = $currencies->total_format($quotePrice, true, $currency, $currency_value);
				}
			}
			$totalPriceText = $currencies->total_format($price + $attrPrice, true, $currency, $currency_value);

			//报价购物车长度属性保存ternence
			if(isset($_POST['type']) && $_POST['type']=="quote"){
				$product_attr_id = $_POST['product_attr_id'];
				$old_length = $_POST['old_length'];
				$length="";
				if (isset($priceArr['length']) && $priceArr['length']) {
					$result = $db->getAll("select id from products_length where product_id = '" . $_POST['products_id'] . "' and length = '".$priceArr['length']."' limit 1");
					if ($result) {
						$length = $result[0]['id'];
					} else {
						$db->query("insert into products_length (length_price,price_prefix,weight,length,product_id,add_time,sign,custom) values ('" . $priceArr['length_price'] . "','+','" . $priceArr['weight'] . "','" .$priceArr['length']. "','" . $_POST['products_id'] . "','" . date('Y-m-d H:i:s') . "','0','1')");
						$length = $db->insert_ID();
					}
				}
				if($_SESSION['inquiry_cart']['contents'][$product_attr_id] && is_numeric($length) && $length>0){
					$_SESSION['inquiry_cart']['contents'][$product_attr_id]['attributes']=['length'=>$length];

				}
			}

			echo json_encode(array('type'=>'1','length_price'=>$priceArr['length_price'],'totle_price'=>$totalPriceText,'quote_price'=>$quotePriceText,'weight'=>$priceArr['weight'],'length'=>$priceArr['length']));
			exit;
		}else{
			echo json_encode(array('type'=>'-1'));
			exit;
		}
	}else{
		echo json_encode(array('type'=>'-2'));
	}
}elseif($_GET['type'] == 'length_update'){
	$products_id = (int)$_POST['products_id'];
	$length = (int)$_POST['length'];
	if($products_id>0 && $length>0){
		$list = $db->getAll("select * from products_length where id = '".$length."' and product_id = '".$products_id."' limit 1");
		if($list){
			//$new_price = $currencies->format(get_products_all_currency_final_price(zen_get_products_base_price((int)$products_id))+$list[0]['length_price']);
			$new_price = $currencies->total_format($list[0]['length_price']+get_products_all_currency_final_price(zen_get_products_base_price((int)$products_id)));
			//报价购物车ternence
			if(isset($_POST['type']) && $_POST['type']=="quote"){
				$product_attr_id = $_POST['product_attr_id'];
				$old_length = $_POST['old_length'];
				if($_SESSION['inquiry_cart']['contents'][$product_attr_id]){
					$_SESSION['inquiry_cart']['contents'][$product_attr_id]['attributes']['length'] = (string)$length;
				}
				$level_price='';
				$discount_pre=1;
				if($_SESSION['member_level']>1){
					$discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], '');
					if(!empty($discount) && $discount!=1){
						$discount_pre = $discount;
					}
					$level_price = $currencies->total_format(($list[0]['length_price']+get_products_all_currency_final_price(zen_get_products_base_price((int)$products_id)))*$discount_pre);
				}
				echo	json_encode(array('level_price'=>$level_price,'new_price'=>$new_price));
			}else{
				echo $new_price;
			}
		}else{
			echo "err";
		}
	}else{
		if(isset($_POST['type']) && $_POST['type']=="quote"){
			$new_price = $currencies->total_format(get_products_all_currency_final_price(zen_get_products_base_price((int)$products_id)));
			$product_attr_id = $_POST['product_attr_id'];
			if($_SESSION['inquiry_cart']['contents'][$product_attr_id]){
				unset($_SESSION['inquiry_cart']['contents'][$product_attr_id]['attributes']['length']);
				$level_price='';
				$discount_pre=1;
				if($_SESSION['member_level']>1){
					$discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], '');
					if(!empty($discount) && $discount!=1){
						$discount_pre = $discount;
					}
					$level_price = $currencies->total_format(($list[0]['length_price']+get_products_all_currency_final_price(zen_get_products_base_price((int)$products_id)))*$discount_pre);
				}
				echo json_encode(array('level_price'=>$level_price,'new_price'=>$new_price));
			}else{
				echo $new_price;
			}

		}else{
			echo "err";
		}
	}
}
?>