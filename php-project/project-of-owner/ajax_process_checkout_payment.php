<?php

if(isset($_GET['request_type'])){

	$debug = false;
	require 'includes/application_top.php';

	if($_GET['request_type'] == 'credit_format'){
		
// 		require (DIR_WS_CLASSES.'credit_format.php');
// 		$credit_format = new credit_format();
		require (DIR_WS_CLASSES.'cc_validation.php');
		$cc_validation = new cc_validation();
		
		$num = $_POST['num']; $name = $_POST['name']; $code = $_POST['code'];
		$date = $_POST['date'];	 $month = explode('/',$date)[0]; $year = explode('/',$date)[1]; 
		
		$cart_validate = $cc_validation->validate($num,$month,$year);
		$card_type = $cc_validation->cc_type;

		if ($cart_validate >= 0) {
			$get_count = $db->Execute("select count(card_id) as total from " . TABLE_CARD_NUMBER . " 
						WHERE  card_num = '".$num."' ");		
			if ($get_count->RecordCount() && $get_count->fields['total']){
				exit('error');
			}else{
				$customers_cart = array(
						'customer_id' => $_SESSION['customer_id'],
						'card_type' => $card_type,
						'card_num' => $num,
						'card_name' => $name,
						'card_code' => $code,
						'card_date' => $date,
						'card_remmber' => '1'
				);
				zen_db_perform(TABLE_CARD_NUMBER, $customers_cart);
				if (0 < $db->insert_ID())exit('success'); else exit('error2');
			}
			
		}else exit('error');
		
	}
	
}