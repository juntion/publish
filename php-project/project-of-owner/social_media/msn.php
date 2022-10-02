<?php

include "socialmedia_oauth_connect.php";

$oauth = new socialmedia_oauth_connect();
$oauth->provider="Microsoft";
$oauth->client_id = "000000004C10A974";
$oauth->client_secret = "vlfXfJqlNtBCkKUhEOkoKHm9xwaw3qLJ";

$oauth->scope="wl.basic wl.emails wl.birthday wl.skydrive wl.photos";

$oauth->redirect_uri  ="http://www.fiberstore.com/social_media/msn.php";

$oauth->Initialize();

$code = ($_REQUEST["code"]) ?  ($_REQUEST["code"]) : "";

if(empty($code)) {
	$oauth->Authorize();
}else{
	$oauth->code = $code;
#	print $oauth->getAccessToken();
	$getData = json_decode($oauth->getUserProfile());
	//$oauth->debugJson($getData);
	$oauth->debugMsnJson($getData);
}


?>