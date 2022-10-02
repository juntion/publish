<?php
require 'includes/application_top.php';
/*用于记录用户已进入过账户中心首页-bills、报价历史，并点击了 I got it*/
$type = $_POST['type'];

if (!is_numeric($type)) {
    exit('非法操作');
}
if ($_SESSION['customer_id']) {
    $data['customer_id'] = $_SESSION['customer_id'];
    $data['type'] = $type;
    $data['create_time'] = date('Y-m-d H:i:s');
    $res = zen_db_perform('customers_guide_tips_log', $data);
    echo $res;
    //$api->setStatus(200)->response($res);
}