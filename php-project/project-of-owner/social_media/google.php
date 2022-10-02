<?php
header("Content-Type: text/html; charset=utf-8");
include "../includes/configure.php";
include "socialmedia_oauth_connect.php";
$oauth = new socialmedia_oauth_connect();

$oauth->provider="Google";


//现在的 account.fs
$oauth->client_id = "765249418514-eehdqlcnk8pqi2k5s9fgnpc53r3897km.apps.googleusercontent.com";
$oauth->client_secret = "oO5wl9cp2R890xng9zBvvRsD";


//$oauth->scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/admin.directory.customer.readonly https://www.googleapis.com/auth/contacts.readonly";
//去掉google的OAuth授权屏幕上的:查看和下载联系人选项
$oauth->scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/admin.directory.customer.readonly";
$redirect_url = HTTPS_SERVER.'/';
if($_GET['lang']){ $redirect_url .= trim($_GET['lang']).'/';}
$redirect_url .= 'social_media/google.php';
$oauth->redirect_uri  = $redirect_url;
$oauth->Initialize();

@$code = ($_REQUEST["code"]) ?  ($_REQUEST["code"]) : "";
if(empty($code)) {
	$oauth->Authorize();
}else{
	$oauth->code = $code;
	$getData = json_decode($oauth->getUserProfile());
    /* redirect here */
    //$oauth->debugJson($getData);
    //$oauth->E($getData);exit;
	//$oauth->debugGoogleJson($getData);
    $google_plus_id  =  $getData->id;
    $email =  $getData->email;
    $first_name =  $getData->given_name;
    $last_name =  $getData->family_name;
    $gender = $getData->gender;
    if ($email) {
        $type = "google";
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
	header('Location: https://www.fs.com');
}
?>