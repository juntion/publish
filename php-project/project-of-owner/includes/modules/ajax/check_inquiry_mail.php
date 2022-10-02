<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':
				$get_count = $db->Execute("select count(products_price_inquiry_id) as total from " . TABLE_PRICE_INQUIRY . " WHERE
							 			  products_price_inquiry_email= '".zen_db_prepare_input($_POST['email'])."' and language_id = ".(int)$_SESSION['languages_id']."  
										  and is_blacklist = 1");
				if ($get_count->RecordCount() && $get_count->fields['total']) exit('ok');
				else exit('error');

			break;
		
		}
	}
}