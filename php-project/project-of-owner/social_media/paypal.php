<?php
header("Content-Type: text/html; charset=utf-8");
include "../includes/configure.php";
include "socialmedia_oauth_connect.php";
$oauth = new socialmedia_oauth_connect();
$oauth->provider="Paypal";
//$oauth->client_id = "AWQBhRCal-xSrqQ78Y_MikISpXF-ajVhAWYbZxK8qeyg85eMj1Wpa7jOdWqw";
//$oauth->client_secret = "ENlY7RAK8DEEtjoGyxDq30bz7TGu2GBuubVXg7chd0BxOFmIRPp7AcsbqXrJ";
$oauth->client_id = "AcFly0MU9Hy8oC-QkqLJUU8Bc6ceUmermKp-wPesbC89l_GYnTtznTJrR_UNhRmsXnJDyU_3LarkPZPE";
$oauth->client_secret = "EDUKXpEvopeVvJJXuwKtMso_hrtzZVF3xUFlr6cSSjGv02N1gvIDePd9Hsr2EYSoCgyC7thmYE7UfXL9";
//$oauth->client_id = "AcwpBToP3wkgYWTx8fUY-6d2KPMRnzUayeuMW5WBi9Vk8s7b4r0dl0CWDJHrjYKoljfSArhcW-HiWRCO";
//$oauth->client_secret = "EDWkMkAAy6beFupkULRewcbrsS0U1t9xDtUR7IU8LGUyumFdGWqv8X8Nwt-8S2QbPqQSEkyLJvsPSplW";
$oauth->scope="email profile";
$redirect_url = HTTPS_SERVER.'/';
if($_GET['lang']){ $redirect_url .= trim($_GET['lang']).'/';}
$redirect_url .= 'social_media/paypal.php';
$oauth->redirect_uri  = $redirect_url;
$oauth->Initialize();

@$code = ($_REQUEST["code"]) ?  ($_REQUEST["code"]) : "";

if(empty($code)) {
	$oauth->Authorize();
}else{
	$oauth->code = $code;
#	print $oauth->getAccessToken();
	$getData = json_decode($oauth->getUserProfile());
	$email = $getData->email;
	//$oauth->debugJson($getData);
	if ($email) {
		$type = "paypal";
		$oauth->login_other_Json($getData,$type);
	} else {
        $login_url = HTTPS_SERVER.'/';
        if($_GET['lang']){ 
            $login_url .= trim($_GET['lang']).'/';
        }
        $login_url .= 'login.html';
        header('Location: '.$login_url);
		exit();
	}
}

if(isset($_GET['error']) && 'access_denied' == $_GET['error']){
	header('Location:'.zen_href_link('index'));
}
?>