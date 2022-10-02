<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){
			
				case 'cart_num':
					$type = $_POST['type'];
					$p_id = $_POST['p_id'];
					$p_num = $_POST['p_num'];
				//if()
					require ('fs_ajax/functions_fs_reviews.php');
					if (1 == $type) {
						$cart_num = 'customers_basket_quantity = customers_basket_quantity+1';
					}else if (0 == $type){
						$cart_num = 'customers_basket_quantity = customers_basket_quantity-1';
					}
					
					$sql = "update " . TABLE_CUSTOMERS_BASKET . " set ".$cart_num." where products_id = '" . (int)$p_id . "'";
					//echo $sql;
					$db->Execute($sql);
					
					$num = get_customer_quantity($p_id,$type);
					
				echo '{"p_id":"'.$p_id.'","cart_num":"'.$num.'"}';
				//exit('success');
					break;
				
		}
	}
}