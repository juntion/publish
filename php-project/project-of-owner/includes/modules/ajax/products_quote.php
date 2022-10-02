<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'storeHttpReferers':

				require_once DIR_WS_CLASSES.'show_dialog.php';
				$dialog = new show_dialog();
				$pID = $_POST['pID'];
				if(isset($pID)){
					echo $dialog->display_show_dialog($pID);
				}

			break;
			
			case 'submit_question':
				require_once DIR_WS_CLASSES.'show_dialog.php';
				$dialog = new show_dialog();
			     echo $dialog->display_question();
			break;
			case 'submit_qa':
				require_once DIR_WS_CLASSES.'show_dialog.php';
				$dialog = new show_dialog();
			     echo $dialog->display_qa();
			break;
			case 'submit_leftqa':
				require_once DIR_WS_CLASSES.'show_dialog.php';
				$dialog = new show_dialog();
			     echo $dialog->display_left_qa();
			break;
		
		}
	}
}