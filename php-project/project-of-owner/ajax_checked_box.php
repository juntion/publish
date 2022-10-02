<?php
$debug = false;
require 'includes/application_top.php';
if(!empty($_POST['product_id']) && !empty($_POST['price']) && !empty($_POST['qty']) || !empty($_GET['request_type'])=='checked_box'||!empty($_GET['request_type'])=='status'){
    //添加勾选的情况,新增checked状态
    switch ($_GET['request_type']){
        case 'checked_up';
            $price =$_POST['price'];
            $number = $_POST['number'];
            $price_filter = preg_replace('/[^\.0123456789]/s','',$price);

            //判断是否超过千元单位
            if(strpos($price_filter,",")==false){
                $price_clearing = $price_filter;//最终价格
            }else{
                $price_clearing = str_replace(',','',$price_filter);
                $price_clearing = $price_clearing;
            }
            //超过千元
            if(strpos($number,",")==true){
                $number_int = str_replace(',','',$number);
                $price_into = $number_int+$price_clearing;
            }else{
                $price_into = $number+$price_clearing;
            }
            $price_into = number_format($price_into,2);

            echo json_encode($_SESSION['currency']." ".$price_into);
            die;
            break;
        //消除勾选的情况,消除checked状态
        case 'checked_un';
            $price =$_POST['price'];
            $number = $_POST['number'];
            $price_filter = preg_replace('/[^\.0123456789]/s','',$price);
            //判断是否超过千元单位
            if(strpos($price_filter,",")==false){
                $price_clearing = $price_filter;//最终价格
            }else{
                $price_clearing = str_replace(',','',$price_filter);
                $price_clearing = $price_clearing;
            }
            //超过千元
            if(strpos($number,",")==true){
                $number_int = str_replace(',','',$number);
                $price_into = $number_int-$price_clearing;
            }else{
                $price_into = $number-$price_clearing;
            }
            $price_into = number_format($price_into,2);

            echo json_encode($_SESSION['currency']." ".$price_into);
            die;
            break;
        case 'status';
            if($_POST['status']==1){
                foreach ($_SESSION['cart']->contents as $k=>$v){
                    $_SESSION['cart']->contents[$k]['checked']=1;
                }
            }else{
                foreach ($_SESSION['cart']->contents as $k=>$v){
                    unset($_SESSION['cart']->contents[$k]['checked']);
                }
            }
            echo 1;
            break;
        default;
    }
}else{
    echo "No parameters";
}
