<?php

//自动登录并延后30天
if(isset($_COOKIE['user_login_info'])){
    $login_info = json_decode($_COOKIE['user_login_info'],true);

    if(!empty($login_info['customer_id'])) {

        if(!$_SESSION['customer_id']) {
            $_SESSION['customer_id'] = $login_info['customer_id'];
            $_SESSION['customer_default_address_id'] = $login_info['customer_default_address_id'];
            $_SESSION['customers_authorization'] = $login_info['customers_authorization'];
            $_SESSION['customer_first_name'] = $login_info['customer_first_name'];
            $_SESSION['customer_last_name'] = $login_info['customer_last_name'];
            $_SESSION['customers_email_address'] = $login_info['customers_email_address'];
            $_SESSION['customers_password'] = $login_info['customers_password'];
            $_SESSION['name'] = $login_info['name'];
            $_SESSION['member_level'] = $login_info['member_level'];
            $_SESSION['authnum_session'] = $login_info['authnum_session'];
        }

        setcookie('user_login_info', $_COOKIE['user_login_info'], time() + 60 * 60 * 24 * 30, '/',"",COOKIE_SECURE,COOKIE_HTTPONLY);

        if(empty($_SESSION['cart']->cartID)){
            //报价购物车数据同步用户数据库
            require_once(DIR_WS_CLASSES . 'inquiry.class.php');
            global $currencies;
            $inquiry = new inquiry($currencies,$_SESSION['inquiry_cart']);
            $inquiry->restore_contents();


            // 设置session购物车
            //Ternence 2019/6/20 修改Save cart Session数据结构,将$_SESSION['user_save_cart'][$key],$key替换为数据库主键ID->customers_saved_id
            $saved_query = $db->getAll("SELECT customers_saved_id,cart_value FROM customers_saved WHERE customer_id=".$check_customer->fields['customers_id']." order by add_time desc");
            $saved_query_array="";
            if(!empty($saved_query)){
                $time = time();
                foreach ($saved_query as $key=>$value){
                    if($value){
                        $saved_query_array[$value['customers_saved_id']]=$value['cart_value'];
                    }
                }
                if(!empty($_SESSION['user_save_cart'])){
                    unset($_SESSION['user_save_cart']);
                    $_SESSION['user_save_cart'] = $saved_query_array;
                }else{
                    $_SESSION['user_save_cart'] = $saved_query_array;
                }
            }
            if (SHOW_SHOPPING_CART_COMBINED > 0) {
                $zc_check_basket_before = $_SESSION['cart']->count_contents();
            }
            $_SESSION['cart']->restore_contents();
            if (SHOW_SHOPPING_CART_COMBINED > 0 && $zc_check_basket_before > 0) {
                $zc_check_basket_after = $_SESSION['cart']->count_contents();
                if (($zc_check_basket_before != $zc_check_basket_after) && $_SESSION['cart']->count_contents() > 0 && SHOW_SHOPPING_CART_COMBINED > 0) {
                    if (SHOW_SHOPPING_CART_COMBINED == 2) {
                        // warning only do not send to cart
                        $messageStack->add_session('header', WARNING_SHOPPING_CART_COMBINED, 'caution');
                    }
                }
            }
        }
    }
}