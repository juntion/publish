<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];
	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
					
					case 'storeHttpReferers':
							
							$value = (int)$_POST['value']*PULLINGEYENUM;
							echo "+".$currencies->format($value);exit;
					break;
							
		}
	}
}
?>