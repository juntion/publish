<?php
if(isset($_GET['request_type'])){
	require 'includes/application_top.php';
	if (isset($_POST['securityToken']) && $_SESSION['securityToken'] == $_POST['securityToken']){
		switch ($_GET['request_type']){
			case 'set_port':
				if(isset($_POST['securityToken']) && $_POST['securityToken']){
					$_SESSION['ports'] = $_POST['port'];
					$a=13;
				}
			break;
		}
	}
}
?>