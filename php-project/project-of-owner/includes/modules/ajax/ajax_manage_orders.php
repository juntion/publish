<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/'.'views/manage_orders.php'); // 订单语言包  解决语言包缺失问题
$action = $_GET['ajax_request_action'];
if (isset($action)) {
    switch ($action) {
        case 'submit_reorders':

            $products_id = (array)json_decode($_POST['opid_array']);
            $ser_num = (array)json_decode($_POST['ser_num']);
            $quantity = (array)json_decode($_POST['quantity']);
            $reason_type = (array)json_decode($_POST['reason_type']);
            $comment = $_POST['reorder_des'];
            $orders_id = zen_db_prepare_input($_POST['orders_id']);
            $type_id = $_POST['type_id'];

            require(DIR_WS_CLASSES . 'uploads.php');

            print_r($_FILES);exit();
            $fileFormat = array('pdf','jpg','png');
            $savepath = DIR_WS_IMAGES .'return/';// 上传的文件存放目录,注:chmod 777 upload
            $maxsize = 5 * 1024 * 1024; //上传文件大小限制
            $overwrite = 0; //0. no 1. yes
            $f = new Uploads( $savepath, $fileFormat, $maxsize, $overwrite);

            if (!$f->run("reviews_img",1)){
                 echo 'upload was failed!';
            }else{
                $info = $f->returnArray;
                $saveName = "";
                if($info){
                    foreach($info as $key=>$v){
                        if($v['name']){
                            $pic_name = strtolower(str_replace(' ', '-', $v['saveName']));
                            $saveName .= DIR_WS_IMAGES .'return/'.$pic_name.':';
                        }
                    }
                }
            }
            $saveName = trim($saveName,':');
            $img_arr = $saveName;

            echo '<pre>';
            print_r($img_arr);exit();
            $order_number = fs_get_data_from_db_fields('orders_number','orders','orders_id='.$order_id,'limit 1');


            print_r($_POST);exit();
            break;
        default:
            break;
    }
}