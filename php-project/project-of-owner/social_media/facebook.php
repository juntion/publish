<?php
header("Content-Type: text/html; charset=utf-8");
ini_set("display_errors", "On");
error_reporting(E_ERROR);
include "../includes/configure.php";
include "socialmedia_oauth_connect.php";
$oauth = new socialmedia_oauth_connect();   //实例化

$oauth->provider="Facebook";
//$oauth->client_id = "451268705303597";
//$oauth->client_secret = "8f0cccce27c10bb3ce5e247f121092a1";

$oauth->client_id = "253502572131530";
$oauth->client_secret = "ce923ac908ac117f59051b01a90a96bc";
////tt测试
//$oauth->client_id = "1664574113621639";
//$oauth->client_secret = "bd08d4e886c1b4673045ad6b1dcad533";
$oauth->scope="email,public_profile";
$oauth->state=md5(time());
$redirect_url = HTTPS_SERVER.'/';
if($_GET['lang']){ $redirect_url .= trim($_GET['lang']).'/';}
$redirect_url .= 'social_media/facebook.php';
$oauth->redirect_uri  = $redirect_url;

//todo:初始化参数
$oauth->Initialize();

@$code = ($_REQUEST["code"]) ?  ($_REQUEST["code"]) : "";
//$oauth->E($_REQUEST);
//todo:两次进入，第一次访问初始化配置，第二次重定向（获取code之后）
if(empty($code)) {
    $oauth->Authorize();    //第一次 code为空 获取code
}else{
    $oauth->code = $code;   //第二次  得到code
    $getData = json_decode($oauth->getUserProfile());
    $email = $getData->email;
    if ($email) {
        $type = "facebook";
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