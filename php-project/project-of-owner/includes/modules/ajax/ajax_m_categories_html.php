<?php
//?modules=ajax&handler=ajax_m_categories_html&ajax_request_action=actionAddProduct
if (!class_exists('fiberstore_category')){
    require DIR_WS_CLASSES . 'fiberstore_category.php';
}
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']) {
    $action = $_GET['ajax_request_action'];
    if (!zen_not_null($action)) {
        echo faild();
    } else {
        switch ($action) {
            case 'get_all':
                echo success(1,fiberstore_category::show_phone_second_third_all_categories());
                break;
            default:
                echo faild();
                break;
        }
    }
} else {
    echo faild();
}


function faild($msg = 'Undefined Action')
{
    $data = [
        'code' => 0,
        'msg' => $msg,
        'data' => ''
    ];
    return json_encode($data);
}

function success($code, $data)
{
    if (!$code) {
        $code = 1;
    }
    $data = [
        'code' => $code,
        'msg' => 'success',
        'data' => $data
    ];
    return json_encode($data);
}