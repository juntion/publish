<?php
if (isset($_GET['type']) && $_GET['type']){
	require 'includes/application_top.php';
	switch($_GET['type']){
        case 'save_share_new':
            //ery add 2019.08.14  shopping_cart/saved_items/saved_cart_details/inquiry页面分享产品功能
            $from_email = zen_db_input($_POST['from_email']);   //分享产品的来源邮箱
            $to_emails = zen_db_input($_POST['to_emails']);     //接收分享产品的邮箱
            $message = str_replace(array('\r\n','\n'), '<br/>', zen_db_input($_POST['from_content']));    //分享产品的来源邮箱
            $products = zen_db_input($_POST['share_list_id']);
            $from_page = zen_db_input($_POST['from_page']);     //分享产品的来源页面
            if(!($from_email && $to_emails && $from_page)){
                //分享的内容为空
                echo json_encode(array("result"=>false,"msg"=>"empty information"));
                exit;
            }
            //2019-9-5 potato 限制表单提交次数
            $submit_number = checkoutSubmitNumber('save_share_new');
            if (!$submit_number) {
                echo json_encode(array("result"=>false,"msg"=>FS_SUBMIT_TOO_OFTEN));
                exit;
            }

            $to_emails = trim($to_emails,';');
            $to_emails =explode(';',$to_emails);
            //去除重复邮箱
            $to_emails = array_flip($to_emails);
            $to_emails = array_flip($to_emails);


            require_once(DIR_WS_CLASSES . 'shopping_cart.php');
            $shoppingCart = new shoppingCart();
            require_once(DIR_WS_CLASSES . 'shoppingCartModel.php');
            $cartModel = new shoppingCartModel();
            $share_contents = '';    //分享的产品数据json格式
            $contents = [];
            switch($from_page){
                case 'shopping_cart':
                    //购物车页面的分享直接拿$_SESSION['cart']中的产品数据
                    if($_SESSION['cart']->count_contents()){
                        $contents = $_SESSION['cart']->contents;
                        $share_contents = json_encode($contents);
                    }
                    break;
                case 'saved_items':
                case 'saved_cart_details':
                    $save_cart_id = (int)$_POST['save_item_id'];
                    if($save_cart_id && $_SESSION['customer_id']){
                        $cart_data = fs_get_data_from_db_fields_array(array('cart_value','is_new'),'customers_saved','customers_saved_id='.$save_cart_id.' AND customer_id='.(int)$_SESSION['customer_id'],'');
                        if($cart_data[0]){
                            //如果是新数据 直接转数据中的内容
                            if($cart_data[0][1] ==1){
                                $contents = json_decode($cart_data[0][0],true);
                                $share_contents = $cart_data[0][0];
                            }else{
                                $contents = $cartModel->get_save_products_by_list_str($cart_data[0][0]);
                                $share_contents = json_encode($contents);
                            }
                        }

                    }
                    break;
                case 'inquiry':
                    $contents = $_SESSION['inquiry_cart']['contents'];
                    if($contents){
                        $share_contents = json_encode($contents);
                    }
                    break;
                //add by ternence 报价详情分享 2019/10/4
                case 'inquiry_detail':
                    $inquiry_id = $_POST['inquiry_id'];
                    require_once(DIR_WS_CLASSES . 'inquiry.class.php'); //类或者方法
                    $inquiry = new inquiry($currencies);
                    $customer_inquiry = $inquiry->get_one_inquiry_all_info($inquiry_id);
                    $contents=[];
                    if($customer_inquiry['products']){
                        foreach ($customer_inquiry['products'] as $k=>$v){
                            $products_id =  $v['attribute_product_id']?$v['attribute_product_id']:$v['products_id'];
                            foreach ($v['attributes'] as $rel=>$item){
                                if($item['options_values_id']){
                                    $v['attributes'][$rel] = $item['options_values_id'];
                                }
                            }
                            $contents[$products_id] =array(
                                'qty'=>$v['product_num'],
                                'attributes'=>$v['attributes']
                            );
                        }
                    }
                    if($contents){
                        $share_contents = json_encode($contents);
                    }
                    break;
            }
            if(!$share_contents){
                //分享的内容为空
                echo json_encode(array("result"=>false,"msg"=>"No products!"));
                exit;
            }
            $data = array(
                'from_email' => $from_email,
                'to_email' => join(';',$to_emails),
                'share_products' => $share_contents,
                'from_page' => $from_page,
                'add_time' => 'now()'
            );
            zen_db_perform('customers_basket_share',$data);
            $share_id = $db->insert_ID();
            //分享链接
            $share_code = create_share_products_code($from_email, $share_id);
            $share_url = zen_href_link(FILENAME_SAVE_SHOPPING_LIST,'&saveID='.$share_id.'&code='.$share_code,'SSL');

            //展示分享的产品HTML
            $productsHtml = '';
            $products_data = [];
            foreach($contents as $pid=>$product){
                $products_data[][$pid] = $product;
            }
            //邮件中产品展示顺序和购物车列表页保持一致 购物等相关页面数据经过shopping_cart类中的get_products方法处理后返回的数组使用array_reverse
            $products_data = array_reverse($products_data);
            foreach($products_data as $key=>$products){
              foreach($products as $pid=>$product){
                $product_category_status = get_product_category_status((int)$pid);
                if ($product_category_status == 1) {
                    $image_stock = '<img src="' . HTTPS_IMAGE_SERVER . 'includes/templates/fiberstore/images/logo_trad.jpg" width="60" height="60">';
                } else {
                    $image_stock = get_resources_img((int)$pid, 60, 60, '', '', '', ' style="" ');
                }
                //展示产品属性
                $attrHtml = '';
                if (sizeof($product['attributes'])) {
                    foreach ($product['attributes'] as $option => $value) {
                        $option_name = $value_name = '';
                        if($option != 'length'){
                            $option_name = fs_get_data_from_db_fields('products_options_name',TABLE_PRODUCTS_OPTIONS,'products_options_id='.(int)$option.' AND language_id='.$_SESSION['languages_id'],'limit 1');
                            if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                                $value_name = htmlspecialchars($product['attributes_values'][$option], ENT_COMPAT, CHARSET, TRUE);
                            } else {
                                $value_name = fs_get_data_from_db_fields('products_options_values_name',TABLE_PRODUCTS_OPTIONS_VALUES,'products_options_values_id='.(int)$value.' AND language_id='.$_SESSION['languages_id'],'limit 1');
                            }
                        }else{
                            $option_name = FS_LENGTH_NAME;
                            $length = fs_get_data_from_db_fields('length','products_length','id='.(int)$value);
                            $value_name = zen_show_product_length($length,(int)$pid);

                        }
                        $attrHtml .= '<div style="font-size:12px;">' .$option_name. ': ' .$value_name. '&nbsp;&nbsp;</div>';
                    }
                }
                $product_name = zen_get_products_name((int)$pid);
                $product_href = zen_href_link('product_info', 'products_id=' . (int)$pid);
                $productsHtml .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;padding-left:20px;" width="60">
                                    <a style="text-decoration: none;" href="' . zen_href_link('product_info', 'products_id=' . $v['products_id']) . '">' . $image_stock . '</a>
                                </td>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" height="20">
                                    <a style="text-decoration: none;color: #232323;" href="' .$product_href. '">
                                        <span>' . $product_name . '<span style="text-decoration: none;color: #999;"> #' . (int)$pid . '</span></span>
                                    </a>
                                    <div style="padding:5px 0 0 0;color: #616265;">' . $attrHtml . '</div>
                                    <span>' . FS_SEND_EMAIL_8 . '<span>' . $product['qty'] . '</span></span>
                                    <br>
                                </td>
                            </tr>
                            </tbody>
                        </table>';
                $productsHtml .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="640" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20">
                                </td>
                            </tr>
                            </tbody>
                        </table>';
              }
            }

            $share_num = 0;
            if($from_page=='inquiry'){
                $send_email1 = INQUIRY_TITLE_9;
                $send_email2 = INQUIRY_TITLE_11;
                $send_email3 = INQUIRY_TITLE_10;
                $send_email4 = INQUIRY_TITLE_12;
            }else{
                $send_email1 = FS_SEND_EMAIL_108;
                $send_email2 = FS_SEND_EMAIL_112;
                $send_email3 = FS_SEND_EMAIL_113;
                $send_email4 = FS_SEND_EMAIL_122;
            }
            foreach ($to_emails as $to_email) {
                $html_msg = array();
                get_email_langpac();
                $html = common_email_header_and_footer($send_email1, FS_SEND_EMAIL_109 . ucwords($from_email) . FS_SEND_EMAIL_110);
                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
                $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0px 20px 0" align="left">
                            ' . FS_EMAIL_TO_US_DEAR . ' ' . ucwords($to_email) . FS_EMAIL_COMMA . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_SEND_EMAIL_109 . ucwords($from_email) . $send_email2 . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;text-align: left;padding: 0 20px">
                            <a href="' . $share_url . '" style="border-radius:2px;color: #0070BC;text-decoration:none;text-align:center;font-size:14px;display:inline-block;margin:0 auto;border:1px solid #0070BC;padding:10px 12px;font-family:Open Sans,arial,sans-serif;">' . FS_SEND_EMAIL_159 . '</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;border-bottom: 1px solid #f7f7f7;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . $send_email3 . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="20" >
                        </td>
                    </tr>
                    </tbody>
                </table>';
                $html_msg['EMAIL_BODY'] .= $productsHtml;
                //客户留言展示
                if (trim($message)) {
                    $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 14px;font-weight: 600;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            ' . FS_SEND_EMAIL_28 . '
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="15">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td bgcolor="#ffffff" style="border-collapse: collapse;border-radius: 2px;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;">
                                        ' . $message . '
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>';
                }
                //邮件底部message
                $html_msg['EMAIL_BODY'] .= '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" >

                        </td>
                    </tr>
                    </tbody>
                </table>'.FS_EMIAL_BOTTOM_MSG.'
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;" height="30" ></td>
                    </tr>
                    </tbody>
                </table>';
                $email_title = FS_SEND_EMAIL_121 . ucwords($from_email) . $send_email4;
                if ($from_email == $to_email) {
                    sendwebmail($to_email, $to_email, '购物车分享邮件给自己:' . date('Y-m-d h:i:s', time()), $from_email . '(' . $from_email . ')', $email_title, $html_msg, 'default');
                    $share_num += 1;
                } else {
                    sendwebmail($to_email, $to_email, '购物车分享邮件给他人:' . date('Y-m-d h:i:s', time()), $from_email . '(' . $from_email . ')', $email_title, $html_msg, 'default');
                    $share_num += 1;
                }
            }
            echo json_encode(array("result"=>true,"msg"=>"success"));
            exit;
            break;
        case 'add_save_product':
            //ery add 2019.08.14  上面的save_share_new分享的产品再次加入购物车或询价
            $from_page = $_POST['from_page'] ? zen_db_input($_POST['from_page']):'shopping_cart';
            $all_product = $_POST['products'] ? $_POST['products']:'';
            $saveID = (int)$_POST['saveID'];
            $check_products = $_POST['check_products'] ? $_POST['check_products']:[];
            require_once(DIR_WS_CLASSES . 'shoppingCartModel.php');
            $cartModel = new shoppingCartModel();
            $contents = [];
            if($saveID){
                //新版分享产品
                if(!empty($check_products)){
                    $share_data = get_save_products_list($saveID);
                    if($share_data['share_products']){
                        $share_data['share_products'] = json_decode($share_data['share_products'],true);
                        foreach($share_data['share_products'] as $pid=>$value){
                            //保留客户勾选加入购物车的产品数据
                            if(in_array($pid,$check_products)){
                                $contents[$pid] = $value;
                            }
                        }
                        $from_page = $share_data['from_page'];
                    }
                }
            }else{
                //旧版分享数据
                $contents_data = $cartModel->get_save_products_by_list_str($all_product);
                if(!empty($check_products) && !empty($contents_data)){
                    foreach($contents_data as $kk=>$vv){
                        //保留客户勾选加入购物车的产品数据
                        if(in_array($kk,$check_products)){
                            $contents[$kk] = $vv;
                        }
                    }
                }
            }
            if(empty($contents)){
                echo json_encode(array('result'=>false,"msg"=>"No Products!"));
                exit;
            }
            if($from_page=='inquiry'){
                //分享的询价产品数据 重新加入到询价列表页
                require_once(DIR_WS_CLASSES . 'inquiry.class.php');
                $inquiry = new inquiry($currencies,$_SESSION['inquiry_cart']);
                foreach ($contents as $k=>$v){
                    if($inquiry->in_cart($k)){
                        $_SESSION['inquiry_cart']['contents'][$k]['qty'] = $v['qty'];
                    }else{
                        $_SESSION['inquiry_cart']['contents'][$k] = $v;
                    }
                }
                //同步报价购物车数据
                if($_SESSION['customer_id']){
                    $inquiry->restore_contents();
                    $_SESSION['inquiry_cart']['contents']=$inquiry->store_contents();
                }
                $page_href = zen_href_link('inquiry');
            }else{
                //购物车相关页面分享的数据 加入到购物车
                foreach ($contents as $pid=>$val){
                    $real_ids = [];
                    if($val['attributes']){
                        $real_ids = get_real_ids_by_attribute($val);
                    }
                    $_SESSION['cart']->add_cart((int)$pid, $val['qty'], $real_ids);
                }
                $page_href = zen_href_link('shopping_cart');
            }
            echo json_encode(array("result"=>true,"msg"=>"success","href"=>$page_href));
            break;
	}
}
?>