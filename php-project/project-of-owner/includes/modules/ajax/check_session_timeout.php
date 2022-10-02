<?php
/**
 * Created by PhpStorm.
 * User: rebirth
 * Date: 2019/07/19
 */
//取消 session 保持机制  2020.03.26   rebirth
//$action = zen_not_null($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : "";
//require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php'); // 调用公共的语言包
/**
 * code
 * 0 请求成功
 * 1 请求失败
 */
//switch ($action) {
//    case "check_session_timeout":
//        $info["is_timeout"] = 0;
//
//        if (!zen_not_null($_SESSION['customer_id']) && !isset($_COOKIE['user_login_info'])) {
//            $_SESSION['login_timeout'] = 1;
////            zen_session_start();
//            $info["is_timeout"] = 1;
//            $info['login_url'] = reset_url('login.html');
//        }
//
//        echo json_encode([
//            "code" => 1,
//            "data" => $info,
//        ]);
//        break;
//    default:
//        echo json_encode([
//            "code" => 0,
//        ]);
//}