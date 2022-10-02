<?php
/**
 * Created by PhpStorm.
 * User: rebirth.ma
 * Date: 2019/10/24
 * Time: 下午9:08
 */
$action = zen_not_null($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : "";
if (!in_array($action, ['sgInstall', 'getInstallTime', 'notice_email'], true)) {
    exit(json_encode(["status" => 0, "message" => FS_ACCESS_DENIED]));
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php'); //导入公用语言包
require_once(DIR_FS_CATALOG . 'includes/classes/SGInstallerServiceClass.php');
switch ($action) {
    case 'getInstallTime':
        $data = SGInstallerServiceClass::getInstallTimeTemplate();
        echo json_encode(['status' => 200, 'data' => $data]);
        break;
    case 'sgInstall':
        $order_id = (int)$_POST['order_id'];
        $type = zen_db_prepare_input($_POST['type']);
        $startTime = zen_db_prepare_input($_POST['sgInstallStartTime']);
        $customerRemark = zen_db_prepare_input($_POST['customer_remark']);
        $endTime = zen_db_prepare_input($_POST['sgInstallEndTime']);
        if (
            !zen_not_null($order_id) ||
            !zen_not_null($type) ||
            !zen_not_null($customerRemark) ||
            strlen($customerRemark) < 4 ||
            strlen($customerRemark) > 500 ||
            !zen_not_null($startTime) ||
            !zen_not_null($endTime) ||
            !zen_not_null($_SESSION['customer_id'])
        ) {
            exit(json_encode(["status" => 0, "message" => FS_ACCESS_DENIED]));
        }
        //接收上传文件
        $file = "";
        if ($_FILES["SGFile"]['name']) {
            require_once(DIR_WS_CLASSES . 'uploads.php');
            $savepath = 'SGInstall/'.$_SESSION['customer_id'].date("Ymd",time());
            $fileFormat = array('pdf', 'jpg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'txt');
            $maxsize = 5 * 1024 * 1024; //上传文件大小限制
            $f = new Uploads($savepath, $fileFormat, $maxsize, 1);
            if (!$f->run("SGFile", 2 , 1)) {
                exit(json_encode(["status" => 0, "message" => $f->errmsg()]));
            } else {
                $info = $f->returnArray;
                if (zen_not_null($info)) {
                    $info = $f->returnArray;
                    $file = $savepath . '/' . str_replace(' ', '-', $info[0]['saveName']);
                } else {
                    exit(json_encode(["status" => 0, "message" => FS_SYSTME_BUSY]));
                }
            }
        }
        $insert = [
            'second_type'     => $type,
            'start_time'      => $startTime,
            'end_time'        => $endTime,
            'customer_remark' => $customerRemark,
            'file'            => $file,
            'resource'        => 7
        ];
        $pIds = [];
        $ids = fs_get_datas(TABLE_ORDERS_PRODUCTS, " orders_id=" . $order_id, "is_install,products_id");
        foreach ($ids as $item) {
            if (!$item['is_install']) {
                $pIds[] = $item['products_id'];
            }
        }
        require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
        $SGInstall = new SGInstallerServiceClass();
        if ($SGInstall->insertByOrder($order_id, $insert, $pIds)) {
            exit(json_encode(["status" => 1, "message" => ""]));
        } else {
            exit(json_encode(["status" => 0, "message" => FS_SYSTME_BUSY]));
        }
        break;
    case 'notice_email':
        set_time_limit(0);
        $id = abs((int)($_POST['id'] ?: 0));
        $orders_id = abs((int)($_POST['orders_id'] ?: 0));
        $orderOvertime = fs_get_one_data(TABLE_CUSTOMER_APPOINTMENT_QUEUE, " id=" . $id);
        if ($orders_id != $orderOvertime['orders_id'] || $type != $orderOvertime['type']) {
            set_data(2);
        }
        //取消单不发  已经处理过的不发   进行中的不发
        $fields = "orders_id,orders_status,orders_number";
        $where = " orders_id = $orders_id AND orders_status <> 5  ORDER BY orders_id DESC ";
        $order = fs_get_one_data(TABLE_ORDERS, $where, $fields);
        if (!zen_not_null($order)) {
            set_data(3);
        }
        $installInfo = fs_get_one_data(TABLE_CUSTOMER_APPOINTMENT_INFO, " orders_number = '" . $order['orders_number'] . "'", "case_number");
        if (!zen_not_null($installInfo)) {
            set_data(4);
        }
        $caseInfo = fs_get_one_data('case_number', " case_number = '" . $installInfo['case_number'] . "' and status in (0,1)", "case_number");
        if (!zen_not_null($caseInfo)) {
            set_data(5);
        }
        if ($order['orders_status'] == 1) {
            //提醒支付的邮件
            //取消新加坡上门服务的流程
            require_once(DIR_WS_CLASSES . 'SGInstallerServiceClass.php');
            (new SGInstallerServiceClass())->cancelCase($orders_id,3,false);
            get_mail_sg_payment($order['orders_id']);
        } else {
            //提醒时间快到了的邮件
            get_mail_sg_installation($order['orders_id']);
        }
        $caq_success_log[] = [
            'orders_id'     => $order['orders_id'],
            'orders_number' => $order['orders_number'],
            'addtime'       => time(),
            'datetime'      => 'now()',
        ];
        zen_db_inserts(TABLE_CAQ_SUCCESS_LOG, $caq_success_log);
        set_data(1);
        break;
    default:
        exit();
}

/**
 * 针对订单取消脚本设置统一返回
 *
 * @param int $code
 */
function set_data($code = 0)
{
    $messages = [
        '2' => "未从数据库找到要处理的数据",
        '3' => "未从订单表里找到对应订单",
        '4' => "case已被取消",
        '5' => "case已被取消1",
    ];
    echo json_encode(
        [
            "code"    => $code,
            "message" => isset($messages[$code]) ? $messages[$code] : "success",
        ]
    );
    exit();
}