<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	$action = $_GET['ajax_request_action'];
	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($action){
			case 'change_power_type':
				$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
				$pid = $_POST['products_id'];
				$option_value_id = $_POST['option_value_id'];
				$option_id = $_POST['option_id'];
				$attr_sql = "select price_prefix,options_values_price from products_attributes where products_id={$pid} and options_id={$option_id} and options_values_id={$option_value_id}";
				$attr_query = $db->Execute($attr_sql);
				
				$price_prefix = $attr_query->fields['price_prefix'];
				$options_values_price = $attr_query->fields['options_values_price'];
				
				$products_price = zen_get_products_base_price((int)$pid);
				$final_price = 0;
				if($price_prefix == '+'){
					$final_price = $products_price+$options_values_price;
				}else if($price_prefix == '-'){
					$final_price = $products_price-$options_values_price;
				}else{
					$final_price = $products_price;
				}
				$wholesale_products = fs_get_wholesale_products_array();
				if(!in_array($pid,$wholesale_products)){                        
					$price =  $currencies->new_display_price(get_customers_products_level_final_price($final_price),0);
				}else{
					$price = $currencies->display_price(get_customers_products_level_final_price($final_price),0);
				}
				echo $price;
				exit;
				
			break;
		}
	}
}
?>