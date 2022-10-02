<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){

			case 'check_coupon':

				$coupon_code = $_POST['coupon_code'];         
				$check_coupon_code = "select count(*) as total
				from " . TABLE_COUPONS . "
				where coupon_code = '" . zen_db_input ( $coupon_code ) . "'";
				$check_coupon = $db->Execute ( $check_coupon_code );
				if ($check_coupon->fields ['total'] < 1) {
					exit('error');
				}

				
				exit('success');
						
				
				break;
			

				
		}
	}
}