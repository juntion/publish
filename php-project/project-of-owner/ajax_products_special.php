<?php
$debug = false;
require 'includes/application_top.php';
if (isset($_GET['action']) && $_GET['action'] == "addCart") {
    if (!empty($_POST['qtys']) && !empty($_POST['ids'])) {
        $a = "";
        $b = "";
        $ids_array = explode(",", $_POST['ids']);
        $qtys_array = explode(",", $_POST['qtys']);
        $is_clearance_array = explode(",",$_POST['is_clearance']);
        $clearance_qty_array = explode(",",$_POST['clearance_qty']);
        for ($i = 0; $i < count($ids_array); $i++) {
            //清仓产品加购限制
            //$is_clearance = get_current_pid_if_is_clearance($ids_array[$i]);
            if($is_clearance_array[$i]){
                $cart_pid_qty = 0;
                if($_SESSION['cart']->in_cart($ids_array[$i])){
                    $cart_pid_qty = $_SESSION['cart']->contents[$ids_array[$i]]['qty'];
                }
                $add_clearance_qty = (int)($cart_pid_qty+$qtys_array[$i]);
                if((int)$add_clearance_qty > (int)$clearance_qty_array[$i]){
                    echo json_encode(array('status'=>'error'));
                    exit();
                }
            }

            $sql = 'select is_min_order_qty as min_qty from products where products_id = "' . $ids_array[$i] . '"';
            $result = $db->Execute($sql);
            $min_qty = $result->fields['min_qty'];
            if ((int)$qtys_array[$i] < (int)$min_qty) {
                $qtys_array[$i] = $min_qty;
            }
            if (isset($ids_array[$i]) && is_numeric($ids_array[$i]) && $qtys_array[$i] > 0) {
                $attributes = '';
                $products_id = $ids_array[$i];
                $now_qty = $qtys_array[$i];
                //ery  2019.7.12  不管是标准产品还是定制产品 统一用add_cart()方法加入购物车
                $_SESSION['cart']->add_cart($products_id, $now_qty);
                $_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
            }

        }
        // 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
        $cart_items = $_SESSION['cart']->count_contents();
        require_once DIR_WS_CLASSES.'shopping_cart_help.php';
        $shopping_cart_help = new shopping_cart_help();
        $html = $shopping_cart_help->show_cart_products_block($cart_items);
        $addCarthtml =products_add_cart_new_popup();
        //google追踪数据统计 ternence.qin
        $products_info = get_google_products_info($qtys_array[0],(string)$ids_array[0]);
        $_SESSION['products_price'] = 'banner';
        echo json_encode(array('status'=>'success','html'=>$html,'addCarthtml'=>$addCarthtml,'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency']));
    }

}

if (isset($_GET['action']) && $_GET['action'] == "new_popup") {
    if (!empty($_POST['qtys']) && !empty($_POST['ids'])) {
        $new_popup = products_add_cart_popup($_POST['ids'],$_POST['qtys']);
    }
    echo $new_popup;
}
