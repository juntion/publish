<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
					
					case 'storeHttpReferers':
						
						if(!empty($_POST['content'])){
							$name = $_POST['name'];
							$sql = "insert into customer_inquiry (content,add_date,customer_name,language_id) values ('".$_POST['content']."', '".date('Y-m-d')."', '".$name."', '".$_SESSION['languages_id']."')"	;
							//echo $sql;
							$db->Execute($sql);
							exit('ok');
						}
					break;
							
		}
	}
}
