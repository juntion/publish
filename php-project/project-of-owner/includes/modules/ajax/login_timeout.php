<?php
//ternence.qin 2019.6.13 登陆超时验证
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
    if($_POST['customer_id'] && $_SESSION['customer_id']) {
        //获取Sisson过期时间，如果过期 清空用户登陆信息
//        if($_SESSION['analysis_session_expires_time']<time()){
//            $_SESSION['login_timeout'] = 1;
//            unset($_SESSION['customer_id']);
//             setcookie("old_password", '');
//        }
//        exit(json_encode(array('status' => '1', 'data' => $_SESSION['analysis_session_expires_time'], 'info' => time())));
    }
}else{
    exit(json_encode(array('status'=>'0','data'=>$_SESSION['analysis_session_expires_time'],'info'=>time())));
}