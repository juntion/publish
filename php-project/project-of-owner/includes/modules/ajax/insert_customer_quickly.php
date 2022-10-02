<?php
die($_POST['email_regist']);


if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "error";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':
				$fs_query = "select count(customers_quickly_email) as email from ".TABLE_CUSTOMER_QUICKLY." where customers_quickly_email = '".$_POST['email_regist']."' and language_id = ".(int)$_SESSION['languages_id']." ";
				$exist_email = $db->Execute($fs_query);
				
				if($exist_email->RecordCount() && $exist_email->fields['email'] > 0){
					$fs_update_column_sql = ' quickly_email_count = quickly_email_count + 1 ';
					$db->query( "update ".TABLE_CUSTOMER_QUICKLY." set ".$fs_update_column_sql." where customers_quickly_email = '".$_POST['email_regist']."' and language_id = ".(int)$_SESSION['languages_id']."");
				}else $db->query(" insert into ".TABLE_CUSTOMER_QUICKLY." (customers_quickly_email,language_id) values ('".$_POST['email_regist']."','".$_SESSION['languages_id']."') ");
			break;
		
		}
	}
}