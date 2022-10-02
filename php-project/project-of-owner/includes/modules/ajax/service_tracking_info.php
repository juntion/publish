<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];
	
	if(!zen_not_null($action)){
		echo "err";
	}else{
	
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':

			if(isset($_POST['cID']) && isset($_POST['account'])){
				$sql =" insert into ".TABLE_CUSTOMERS_SERVICE_HISTORY." (shipping_method,express_account,service_id,customers_id,date_added,service_status)
					values ('".$_POST['method']."','".$_POST['account']."','".$_POST['ser_id']."','".$_POST['cID']."',now(),3) ";
				$db->query($sql); 
				
				$ser_sql = "update ".TABLE_CUSTOMERS_SERVICE." set service_status = 3 where customers_service_id = ".$_POST['ser_id']."";
				$db->Execute($ser_sql);
				exit('ok');
			}
				
			break;
		
		}
	}
}