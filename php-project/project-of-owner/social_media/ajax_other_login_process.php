<?php

if(!empty($_SESSION['google_info'])){
    $google_plus_id  =  $_SESSION['google_info']['google_plus_id'];
    $email  =  $_SESSION['google_info']['email'];
    $first_name  =  $_SESSION['google_info']['first_name'];
    $last_name =  $_SESSION['google_info']['last_name'];
    $gender =  $_SESSION['google_info']['gender'];
    if(!empty($email)){
        $result = $db->getAll("select customers_id,customers_email_address,customers_firstname,customers_lastname,customer_default_address_id,customers_authorization,member_level 
                    from customers where customers_email_address = '" . $email . "'");
        if ($result->RecordCount()) { //如果改谷歌邮箱在我们用户表里面找到
            $is_first_bind = 0;
            $current_customer_id = $result->fields['customers_id'];

            $google_result = $db->Execute('select customers_google_account_info_id,customers_id from customers_social_media_google_info where google_plus_email = "' . $email . '"');
            if ($google_result->RecordCount()) {
                if ($current_customer_id != $google_result->fields['customers_id']) {  // 绑定的其他账号，这种情况应该很少
                    $google_plus_info = array(
                        'customers_id' => $current_customer_id,
                    );
                    $google_plus_info = insert_db_time($google_plus_info, false, $current_customer_id);
                    zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info, 'update', 'customers_google_account_info_id = "' . $google_result->fields['customers_google_account_info_id'] . '"');
                    $_SESSION['is_first_third_bind'] = true; //第一次绑定
                }
            } else { // 第3方表没有记录，则添加，自动绑定
                $google_plus_info = array(
                    'google_plus_id' => $google_plus_id,
                    'google_plus_email' => $email,
                    'google_plus_name' => $name,
                    'google_plus_gender' => $gender,
                    'customers_id' => $current_customer_id,
                );
                $google_plus_info = insert_db_time($google_plus_info, true, $current_customer_id);
                zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info);

                $_SESSION['is_first_third_bind'] = true; //第一次绑定
            }

            //设置登录session和cookie
            set_login_session($result);

            // 更新最后一次的登录记录
            zen_update_one_customers_info($_SESSION['customer_id']);

            // 添加登录记录
            zen_insert_one_customers_login($_SESSION['customer_id'], 'google_login');

            // bof: contents merge notice
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
                    if (SHOW_SHOPPING_CART_COMBINED == 1) {
                        // show warning and send to shopping cart for review
                        $messageStack->add_session('shopping_cart', WARNING_SHOPPING_CART_COMBINED, 'caution');
                        $jump_url = FILENAME_SHOPPING_CART;
                    }
                }
            }
            // eof: contents merge notice

            if (!$jump_url) {
                $jump_url = return_login_jump_url();
                if (!$jump_url) {
                    $jump_url = FILENAME_MY_DASHBOARD;
                }
            }
            zen_redirect($jump_url);
        } else { // 如果没有，说明是第一次
            $google_plus_info = array(
                'google_plus_id' => $google_plus_id,
                'google_plus_email' => $email,
                'google_plus_name' => $name,
                'google_plus_gender' => $gender
            );
            $google_plus_info = insert_db_time($google_plus_info, true);
            zen_db_perform(TABLE_CUSTOMERS_SOCIAL_MEDIA_GOOGLE_INFO, $google_plus_info);
            $google_plus_info_id = $db->Insert_ID();

            $_SESSION['third_party_type'] = 'google';
            $_SESSION['third_party_id'] = $google_plus_info_id;
            $_SESSION['third_party_from_url'] = 'social_media/google.php';

            zen_redirect(zen_href_link('third_party_bind'));
        }
    }else{
        echo FS_SYSTME_BUSY;
        exit();
    }
}else{
    header('Location: https://www.fs.com/');
}

?>