<?php
/** !!!!!!!!
 *  !!!!!!!!!!!!   本脚本有任何改动请先咨询aron
 *  !!!!!!!
 */
define('IS_ADMIN_FLAG', true);
$path = dirname(__FILE__);
chdir($path);
chdir('../../');
require_once './includes/configure.php';
require_once './vendor/autoload.php';
require_once './includes/extra_configures/enable_error_logging.php';


use App\Services\Common\SetDataBase;

SetDataBase::setConfig();


/**
 * queue日志打印
 *
 * @param $msg
 * @param array $data
 */
function queueLogReport($msg, $data = [])
{
    if (is_array($data) || is_object($data)) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    echo (string)$msg . ' | ' . (string)$data . ' | ' . time() . ' | ' . date('Y-m-d H:i:s') . "\r\n";
}
