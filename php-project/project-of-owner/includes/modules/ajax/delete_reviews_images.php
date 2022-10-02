<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':
				$reviews_images = $_POST['name'];
				$reviews_id = $_POST['rid'];
				
				$sql = "update ".TABLE_REVIEWS_DESCRIPTION." set reviews_images = replace(reviews_images,'$reviews_images|','') where reviews_id = $reviews_id";
				
				@unlink('upload/'.$reviews_images);
				$db->query($sql); exit('ok');
				
				
			break;
		
		}
	}
}