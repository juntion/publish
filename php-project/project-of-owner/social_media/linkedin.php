<?php
header("Content-Type: text/html; charset=utf-8");
ini_set("display_errors", "On");
error_reporting(E_ERROR);
include "../includes/configure.php";
include "socialmedia_oauth_connect.php";
$oauth = new socialmedia_oauth_connect();   //实例化

$oauth->provider="LinkedIn";
//线上
$oauth->client_id = "8183q34i0n2eju";
$oauth->client_secret = "78FBpOEJ6aQOulC5";

$oauth->scope="r_emailaddress r_liteprofile";
$oauth->state=md5(time());
$redirect_url = HTTPS_SERVER.'/';
if($_GET['lang']){ $redirect_url .= trim($_GET['lang']).'/';}
$redirect_url .= 'social_media/linkedin.php';
$oauth->redirect_uri  = $redirect_url;

//todo:初始化参数
$oauth->Initialize();

@$code = ($_REQUEST["code"]) ?  ($_REQUEST["code"]) : "";
//$oauth->E($_REQUEST);
//todo:两次进入，第一次访问初始化配置，第二次重定向（获取code之后）
if(empty($code)) {
    $oauth->Authorize();    //第一次 code为空 获取code
}else{
    $oauth->code = $code; 	//第二次  得到code
	$userdata = $oauth->getLinkedinUserProfile();
    $email =  $userdata->emailAddress;
    if ($email) {
        $type = "Linkedin";
       $oauth->login_other_Json($userdata,$type);
    } else {
        $login_url = HTTPS_SERVER.'/';
        if($_GET['lang']){ 
            $login_url .= trim($_GET['lang']).'/';
        }
        $login_url .= 'login.html';
        header('Location: '.$login_url);
        exit();
    }
//	$str = $oauth->debugLinkedinJson($userdata);
	
}

if(isset($_GET['error']) && 'access_denied' == $_GET['error']){
    header('Location: https://www.fs.com');
}
?>