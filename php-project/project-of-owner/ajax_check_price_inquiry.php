<?php

if(isset($_GET['request_type'])){
	
	$debug = false;
	require 'includes/application_top.php';
	
	if($_GET['request_type'] == 'is_blacklist'){
		$get_count = $db->Execute("select count(id) as total from " . TABLE_PRICE_INQUIRY . " WHERE 
				inquiry_email= '".zen_db_prepare_input($_POST['email'])."' and language_id = ".(int)$_SESSION['languages_id']."       ");		
		if ($get_count->RecordCount() && $get_count->fields['total']){
			exit('ok');
		}else{
			exit('error');
		}
	}
}