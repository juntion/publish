<?php

if ($_GET['ajax_request_action'] == 'optical') {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        failed();
    }
    require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
    require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/sfp_optical_module.php'); // 调用公共的语言包
    require_once(DIR_WS_CLASSES . 'sfpOpticalModule.php');
    $sfpOpticalModule = new sfpOpticalModule();
    $whichTable = 1;
    $html = "";
    while (true) {
        $whichTable++;
        $sfpOpticalModule->setTable($whichTable);
        $html .= $sfpOpticalModule->getAllHtml();
        if ($whichTable >= 6) {
            break;
        }
    }
    success($html);
} else {
    failed();
}

/**
 * by rebirth  2019/09/24
 * 返回错误信息
 *
 * @param string $msg
 */
function failed($msg = FS_ACCESS_DENIED)
{
    echo json_encode([
        "code" => 0,
        "msg"  => $msg
    ]);
    exit();
}

/**
 * by rebirth 2019/09/24
 * 返回正确信息
 *
 * @param $data
 */
function success($data)
{
    echo json_encode([
        "code" => 1,
        "data" => $data
    ]);
    exit();
}