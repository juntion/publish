<?php
if (isset($_GET['modules'])  && ($_GET['modules'] == 'ajax') &&  isset($_GET['handler']) && isset($_GET['ajax_request_action'])){
	if(file_exists(DIR_WS_MODULES.'ajax/'.$_GET['handler'].'.php')){
		require_once (DIR_WS_MODULES.'ajax/'.$_GET['handler'].'.php');exit;
	}else{
		echo "err";exit;
	}
}
