<?php


/*  2016 6 13  移动端接口
 *
 * http://www.fs.com/index.php?modules=phone&handler=index&request_action=top_categories
 index.php?modules=ajax&handler=pulling_eye_attribute&ajax_request_action=storeHttpReferers
 */
if (isset($_GET['modules']) && ($_GET['modules'] == 'phone') && isset($_GET['handler']) && isset($_GET['request_action'])) {
    /* 服务器接口版本兼容 */
    /* version需要校验是否含小数点，防止apk下载版本接口传的同名version参数报错 */
    if (isset($_GET['version']) && $_GET['version'] && strpos($_GET['version'],'.') !== false) {
        $_SESSION['version'] = $_GET['version'];
    }
    require_once(DIR_WS_MODULES . 'phone/includes/application_top.php');   

    if (isset($_SESSION['version']) && $_SESSION['version'] && !isset($_GET['test_version'])) {
        require_once(DIR_WS_MODULES . 'phone/includes/app_core.php');
    } else {
        if (file_exists(DIR_WS_MODULES . 'phone/' . $_GET['handler'] . '.php')) {
            require_once(DIR_WS_MODULES . 'phone/' . $_GET['handler'] . '.php');
        } else {
            echo json_encode(array('result' => 'fail', 'msg' => ''));
        }
    }
    exit;
}

