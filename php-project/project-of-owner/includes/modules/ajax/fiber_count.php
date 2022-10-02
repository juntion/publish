<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];
	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
					
					case 'storeHttpReferers':
							/*
							$fiber_count = isset($_POST['fiber_count']) ? trim($_POST['fiber_count']) : "";
							$length = isset($_POST['length']) ? trim($_POST['length']) : "";
							$fiber_type = isset($_POST['fiber_type']) ? trim($_POST['fiber_type']) : "";
							$product_id = isset($_POST['product_id']) ? trim($_POST['product_id']) : "";
							$product_price = 0;
							if($product_id){
								$product_price = zen_get_products_base_price((int)$product_id);
							}
							if($fiber_count && $length && $fiber_type){
								if($fiber_count>=1){
									$fiber_cable = optical_cable_price($product_id,$fiber_type,$fiber_count);
									if($fiber_cable){
										$price = $fiber_cable['price']*$length;
										$price_j = $price-$product_price;
										$price_t = $currencies->format($price);
										$price_j = "+".$currencies->format($price_j);
										echo json_encode(array('price_t'=>$price_t,'price_j'=>$price_j));
									}
								}
							}
							*/
					break;
							
		}
	}
}
?>