<?php
/**
 * User: Administrator
 * Date: 2018/11/24
 * Time: 19:15
 * created by Ternence
 * 购物车保存
 */

use App\Services\Saved\CustomersSavedService;
 
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
  $action = $_GET['ajax_request_action'];
  if(!zen_not_null($action)){
	echo "err";
  }else{
	switch($action){
		case 'saved_shipping':
			$customer_id = $_SESSION['customer_id'];
			if ($customer_id) {
				$debug = false;
				$time = time();
				$date_mark = "";
				if (!empty($_SESSION['user_save_cart'])) {
					foreach ($_SESSION['user_save_cart'] as $key => $value) {
						if ($_POST['date'] == $key) {
							$date_mark = 1;
						}
					}
				}
				if ($date_mark == 1) {
					echo 2;die;
				} else {
                    $user_save_date = zen_db_input($_POST['date']);
                    $sql = "SELECT user_save_time FROM customers_saved WHERE customer_id =" . $customer_id . " and user_save_time ='" . $user_save_date . "'";
                    $data = $db->Execute($sql);
                    if (!$data->EOF) {
                        echo 4;die;
                    }
					if (isset($_POST['date']) && !empty($_POST['date'])) {
						$contents = $_SESSION['cart']->contents;
						$columnid = $_SESSION['cart']->columnID;
						$cart_value = '';
						if ($contents) {
						    //直接通过json_encode 把session中的contents 保存到数据库
                            $cart_value = json_encode($contents);
							foreach ($contents as $key => $value) {
								$_SESSION['cart']->remove($key);
//								$cart_value .= $key . ':' . $value['qty'];
//								if ($value['attributes']) {
//									foreach ($value['attributes'] as $k => $v) {
//										$k = str_replace("_", "/", $k);
//										if($v==0){
//											$cart_value .= '_' . $k . ':{' .$value['attributes_values'][$k].'}';
//										}else{
//											$cart_value .= '_' . $k . ':' . $v;
//										}
//										if ($columnid[$key][$k][$v]) {
//											$cart_value .= "-" . $columnid[$key][$k][$v];
//										}
//									}
//								}
//								$cart_value .= '|';
							}
						}

						$cart_value_str = substr($cart_value, 0, count($cart_value) - 2);
						if ($customer_id) {
							$comment = array(
								'user_save_time' => $user_save_date,
								'add_time' => $time,
								'cart_value' => $cart_value,
								'customer_id' => $customer_id,
								'languages_id' => $_SESSION['languages_id'],
                                'is_new' =>1
							);
						zen_db_perform('customers_saved', $comment);
							$cid = $db->insert_ID();
							unset($_SESSION['cart']);
                            if (!isset($_SESSION['user_save_cart'])) {
                                $_SESSION['user_save_cart'] = array($cid => $cart_value);
                            } else {
                                $user_save_cart = $_SESSION['user_save_cart'];
                                $_SESSION['user_save_cart'] = "";
                                $_SESSION['user_save_cart'][$cid] = $cart_value;
                                foreach ($user_save_cart as $r => $n) {
                                    $_SESSION['user_save_cart'][$r] = $n;
                                }
                            }
                            echo $cid;die;
						}
					}
				}
			} else {
				echo 1;die;
			}
			exit;
		break;
		case 'view_all':
			//saved_cart_details页面将save记录中的所有产品都加入购物车中
//			$list_array = $_SESSION['user_save_cart'];
			$_POST['time'] = str_replace('%20'," ",$_POST['time']);
			$data_time =$_POST['time'];
			$product_key = [];
            $headNum = '';
		    //不用session 里面的数据  直接查询  如果是新数据结构用json_decode  否则还是像以前一样分割
            if($data_time) {
                require_once DIR_WS_CLASSES . 'shoppingCartModel.php';
                require_once DIR_WS_CLASSES . 'shipping_info.php';
                $cartModel = new shoppingCartModel();
                $where = ' customers_saved_id ='.(int)$data_time .' and customer_id ='.$_SESSION['customer_id'];
                $list_array = get_save_cart_data($where,true,1,1);
                if ($list_array) {
                    if ($list_array[0]['is_new'] == 1) {
                        $contens = json_decode($list_array[0]['value'], true);
                    } else {
                        //获取当前记录中的所有产品
                        $contens = $cartModel->get_save_products_by_list_str($list_array[0]['value']);
                    }
                    if (sizeof($contens)) {
                        // 失效的产品不能加人购物车
                        foreach ($contens as $k => $v) {
                            $product_status = fs_get_data_from_db_fields('products_status', 'products', 'products_id=' . intval($k), 'limit 1');
                            if ($product_status == '0') {
                                unset($contens[$k]);
                                array_push($product_key, intval($k));
                            }
                            foreach ($v['attributes'] as $option => $val) {
                                if ($option != 'length') {
                                    $query_sql = "SELECT popt.products_options_name,poval.products_options_values_name,pa.options_values_price,pa.price_prefix FROM products_options AS popt,products_options_values AS poval,products_attributes AS pa WHERE pa.products_id = " . intval($k) . " AND pa.options_id = '" . $option . "' AND pa.options_id = popt.products_options_id AND pa.options_values_id = " . $val . " AND pa.options_values_id = poval.products_options_values_id AND popt.language_id = " . $_SESSION['languages_id'] . " AND poval.language_id = " . $_SESSION['languages_id'];
                                    $data = $db->getAll($query_sql);
                                    if (!$data) {
                                        unset($contens[$k]);
                                        array_push($product_key, intval($k));
                                        break;
                                    }
                                }
                                }
                        }
                        foreach ($contens as $pid => $content) {
                            $qty = $content['qty'];
                            $is_clearance = get_current_pid_if_is_clearance($pid); //是否是清仓产品;
                            // 清仓产品限制加购 dylan 2019.10.9
                            if($is_clearance){
                                $shipping_info = new ShippingInfo(array('pid'=>(int)$pid));
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();
                                $cart_clear_qty = $_SESSION['cart']->contents[$pid]['qty'];
                                if(($cart_clear_qty+$qty)>=$clearance_qty && $qty){
                                    if($clearance_qty==0){
                                        $qty = 0;
                                    }else{
                                        $qty = (int)($clearance_qty-$cart_clear_qty);
                                    }
                                }
                            }
                            if($qty){
                                //若是定制产品需要获取属性数组
                                $real_ids = get_real_ids_by_attribute($content);
                                $_SESSION['cart']->add_cart((int)$pid,$qty,$real_ids);
                            }
                            $html = products_add_cart_new_popup();
                        }
                        //更新头部购物车数量
                        require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                        $shopping_cart_help = new shopping_cart_help();
                        $headNum = $shopping_cart_help->show_cart_products_block();
                        if ($_SESSION['view_cart']) {
                            unset($_SESSION['view_cart']);
                        }
                        $mark = 1;
                    }
                    if ($mark == 1) {
//                        echo 1;
                        exit(json_encode(array('status' => 200, 'data' => !empty($product_key) ? $product_key : '', 'info' => '','html'=>$html,'headNum'=>$headNum)));
                    }
                }
            }
			exit;
		break;
        case 'view_all_check':
            //saved_cart_details页面将save记录中的所有产品都加入购物车中
//			$list_array = $_SESSION['user_save_cart'];
            $_POST['time'] = str_replace('%20'," ",$_POST['time']);
            $data_time =$_POST['time'];
            $product_key = [];
            //不用session 里面的数据  直接查询  如果是新数据结构用json_decode  否则还是像以前一样分割
            if($data_time) {
                require_once DIR_WS_CLASSES . 'shoppingCartModel.php';
                require_once DIR_WS_CLASSES . 'shipping_info.php';
                require_once(DIR_WS_CLASSES . 'shopping_cart.php');
                $cart = new shoppingCart();
                $cartModel = new shoppingCartModel();
                $customers_cart = new CustomersSavedService();
                $where = ' customers_saved_id ='.(int)$data_time .' and customer_id ='.$_SESSION['customer_id'];
                $list_array = get_save_cart_data($where,true,1,1);
                $lists = $customers_cart->getCartDetail((int)$data_time);
                if ($list_array) {
                    if ($list_array[0]['is_new'] == 1) {
                        $contens = json_decode($list_array[0]['value'], true);
                    } else {
                        //获取当前记录中的所有产品
                        $contens = $cartModel->get_save_products_by_list_str($list_array[0]['value']);
                    }
                    if (sizeof($contens)) {
                        // 失效的产品不能加人购物车
                        foreach ($contens as $k => $v) {
                            $product_status = fs_get_data_from_db_fields('products_status', 'products', 'products_id=' . intval($k), 'limit 1');
                            if ($product_status == '0') {
                                unset($contens[$k]);
                                array_push($product_key, ['id' => $k,'type'=>1]);
                            }
                            foreach ($v['attributes'] as $option => $val) {
                                if ($option != 'length') {
                                    $query_sql = "SELECT popt.products_options_name,poval.products_options_values_name,pa.options_values_price,pa.price_prefix FROM products_options AS popt,products_options_values AS poval,products_attributes AS pa WHERE pa.products_id = " . intval($k) . " AND pa.options_id = '" . $option . "' AND pa.options_id = popt.products_options_id AND pa.options_values_id = " . $val . " AND pa.options_values_id = poval.products_options_values_id AND popt.language_id = " . $_SESSION['languages_id'] . " AND poval.language_id = " . $_SESSION['languages_id'];
                                    $data = $db->getAll($query_sql);
                                    if (!$data) {
                                        unset($contens[$k]);
                                        array_push($product_key,  ['id' => $k,'type'=>2]);
                                        break;
                                    }
                                }
                            }
                        }
                        foreach ($contens as $pid => $content) {
                            $qty = $content['qty'];
                            $is_clearance = get_current_pid_if_is_clearance($pid); //是否是清仓产品;
                            // 清仓产品限制加购 dylan 2019.10.9
                            if($is_clearance){
                                $shipping_info = new ShippingInfo(array('pid'=>(int)$pid));
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();
                                $cart_clear_qty = $_SESSION['cart']->contents[$pid]['qty'];
                                if(($cart_clear_qty+$qty)>=$clearance_qty && $qty){
                                    if($clearance_qty==0){
                                        array_push($product_key,  ['id' => $pid,'type'=>3]);
                                        $qty = 0;
                                    }
                                }
                            }
                        }
                        // 生成html弹窗展示
                            $contents = array();
                            if($lists){
                                if($lists[0]['is_new'] ==1){
                                    $contents = json_decode($lists[0]['cart_value'],true);
                                }else{
                                    $contents = $cartModel->get_save_products_by_list_str($lists[0]['cart_value']);
                                }
                            }
                        if($contents){
                            $products = $productArray = array();

                            $cart->contents = $contents;
                            $totalquantity = $cart->count_contents();
                            $products = $cart->get_products(true);
                            $productsData = $cartModel->get_products_data($products);
                            $productArray = $productsData['productArr'];
                            $totalPrice = $productsData['total_price'];
                            $totalPrice_usual = $productsData['total_price_usual'];
                            $totalPrice_usual_text = $currencies->total_format($totalPrice_usual, true, $currency, $currency_value);
                            $totalPrice_text = $currencies->total_format($totalPrice, true, $currency, $currency_value);
                        }
                        $html = '';
                        $title_type = array_unique(i_array_column($product_key, 'type'));
                        $key1 =[];
                        $key2 =[];
                        $key3 =[];
                        foreach ($product_key as $kk => $vv) {
                            if ($vv['type'] == 1) {
                                array_push($key1, $vv['id']);
                            }else if ($vv['type'] == 2){
                                array_push($key2, $vv['id']);
                            }else if ($vv['type'] == 3){
                                array_push($key3, $vv['id']);
                            }
                        }
                        if (in_array(1, $title_type)) {
                        $html .= '<div class="order_list_dl" style="">
                <div class="public_Prompt">
                    <i class="iconfont icon"></i>';
                        $html .= FS_CART_SHOPPING_CART_DIRECTLY;
                        $html .= '</div>';
                    }
                        if (!empty($key1)) {
                            foreach ($productArray as $i => $product) {
                                if (in_array($product['id'], $key1)){
                                    $image = get_resources_img(intval($product['id']),70,70,$product['productImageSrc'],'','',' border="0" ');
                                    $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($product['id']),'NONSSL');
                                    $html .= '<dl class="save_cart_confirm_dl after option_white">
                    <dt>
                        <a href="'.$link.'">'.$image .'</a>';
                                    $html .= '</dt>
                    <dd>
                        <p class="save_cart_confirm_tit"><a href="" class="alone_a">'.$product['productsName'].'</a></p>'.$product['attributeHiddenField'];
                                    if (isset($product['attributes']) && is_array($product['attributes'])) {
                                        $html .= '<div class="cartAttribsList">';
                                        $html .= '<ul>';
                                        reset($product['attributes']);
                                        $Length=$Attr='';
                                        foreach ($product['attributes'] as $option => $value) {
                                            if($option == 'length'){ $Length = trim($value['length']);
                                                $html .= '<li>'.FS_LENGTH_NAME . ' - ' . zen_show_product_length($Length,(int)$product['id']).'</li>';

                                            }else{  $Attr[] = $value['options_values_id'];
                                                $html .= '<li>'.$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']) .'</li>';
                                            }
                                        }
                                        $html .= '</ul></div>';
                                    }


                                    if (empty($product['attributes']) && $product['quantity'] == 0) {
                                        $is_qty = $contents[$product['id']]['qty'];
                                    }else{
                                        $is_qty = $product['quantity'];
                                    }
                                    if ($product['attributes'] && is_array($product['attributes'])) {
                                        $simliar = FS_PRODUCT_OFF_TEXT_3;
                                    }else{
                                        $simliar = FS_SHOP_CART_SIMILAR;
                                    }
                                    $html .= '<p class="order_list_qty">'.FS_SEND_EMAIL_2019_10 .':'.$is_qty.'</p>
                        <a target="_blank" href="'. $link .'" class="alone_a">'. $simliar .'</a>
                    </dd>
                </dl>';
                                }
                            }
                            $html .= '</div>';
                        }
                        if (in_array(2, $title_type)) {
                            $html .= '<div class="order_list_dl" style="">
                <div class="public_Prompt">
                    <i class="iconfont icon"></i>';
                            $html .= FS_CART_CUSTOMIZED_SHOPPING_CART;
                            $html .= '</div>';
                        }
                        if (!empty($key2)) {
                            foreach ($productArray as $i => $product) {
                                if (in_array($product['id'], $key2)){
                                    $image = get_resources_img(intval($product['id']),70,70,$product['productImageSrc'],'','',' border="0" ');
                                    $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($product['id']),'NONSSL');
                                    $html .= '<dl class="save_cart_confirm_dl after option_white">
                    <dt>
                        <a href="'.$link.'">'.$image .'</a>';
                                    $html .= '</dt>
                    <dd>
                        <p class="save_cart_confirm_tit"><a href="" class="alone_a">'.$product['productsName'].'</a></p>'.$product['attributeHiddenField'];
                                    if (isset($product['attributes']) && is_array($product['attributes'])) {
                                        $html .= '<div class="cartAttribsList">';
                                        $html .= '<ul>';
                                        reset($product['attributes']);
                                        $Length=$Attr='';
                                        foreach ($product['attributes'] as $option => $value) {
                                            if($option == 'length'){ $Length = trim($value['length']);
                                                $html .= '<li>'.FS_LENGTH_NAME . ' - ' . zen_show_product_length($Length,(int)$product['id']).'</li>';

                                            }else{  $Attr[] = $value['options_values_id'];
                                                $html .= '<li>'.$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']) .'</li>';
                                            }
                                        }
                                        $html .= '</ul></div>';
                                    }


                                    if (empty($product['attributes']) && $product['quantity'] == 0) {
                                        $is_qty = $contents[$product['id']]['qty'];
                                    }else{
                                        $is_qty = $product['quantity'];
                                    }
                                    if ($product['attributes'] && is_array($product['attributes'])) {
                                        $simliar = FS_PRODUCT_OFF_TEXT_3;
                                    }else{
                                        $simliar = FS_SHOP_CART_SIMILAR;
                                    }
                                    $html .= '<p class="order_list_qty">'.FS_SEND_EMAIL_2019_10 .':'.$is_qty.'</p>
                        <a target="_blank" href="'. $link .'" class="alone_a">'. $simliar .'</a>
                    </dd>
                </dl>';
                                }
                            }
                            $html .= '</div>';
                        }
                        if (in_array(3, $title_type)) {
                            $html .= '<div class="order_list_dl" style="">
                <div class="public_Prompt">
                    <i class="iconfont icon"></i>';
                            $html .= FS_CART_THE_QUANTITY;
                            $html .= '</div>';
                        }
                        if (!empty($key3)) {
                            foreach ($productArray as $i => $product) {
                                if (in_array($product['id'], $key3)){
                                    $image = get_resources_img(intval($product['id']),70,70,$product['productImageSrc'],'','',' border="0" ');
                                    $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($product['id']),'NONSSL');
                                    $html .= '<dl class="save_cart_confirm_dl after option_white">
                    <dt>
                        <a href="'.$link.'">'.$image .'</a>';
                                    $html .= '</dt>
                    <dd>
                        <p class="save_cart_confirm_tit"><a href="" class="alone_a">'.$product['productsName'].'</a></p>'.$product['attributeHiddenField'];
                                    if (isset($product['attributes']) && is_array($product['attributes'])) {
                                        $html .= '<div class="cartAttribsList">';
                                        $html .= '<ul>';
                                        reset($product['attributes']);
                                        $Length=$Attr='';
                                        foreach ($product['attributes'] as $option => $value) {
                                            if($option == 'length'){ $Length = trim($value['length']);
                                                $html .= '<li>'.FS_LENGTH_NAME . ' - ' . zen_show_product_length($Length,(int)$product['id']).'</li>';

                                            }else{  $Attr[] = $value['options_values_id'];
                                                $html .= '<li>'.$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']) .'</li>';
                                            }
                                        }
                                        $html .= '</ul></div>';
                                    }


                                    if (empty($product['attributes']) && $product['quantity'] == 0) {
                                        $is_qty = $contents[$product['id']]['qty'];
                                    }else{
                                        $is_qty = $product['quantity'];
                                    }
                                    if ($product['attributes'] && is_array($product['attributes'])) {
                                        $simliar = FS_PRODUCT_OFF_TEXT_3;
                                    }else{
                                        $simliar = FS_SHOP_CART_SIMILAR;
                                    }
                                    $html .= '<p class="order_list_qty">'.FS_SEND_EMAIL_2019_10 .':'.$is_qty.'</p>
                        <a target="_blank" href="'. $link .'" class="alone_a">'. $simliar .'</a>
                    </dd>
                </dl>';
                                }
                            }
                            $html .= '</div>';
                        }
                        exit(json_encode(array('status' => 200, 'data' => !empty($html) ? $html : '', 'info' => '')));
                    }
                        exit(json_encode(array('status' => 0, 'data' => !empty($product_key) ? $product_key : '', 'info' => '')));
                }
            }
            exit;
            break;
		case 'delete_saved':
            if($_POST['time']){
                $user_save = $_SESSION['user_save_cart'];
                $customer_id = $_SESSION['customer_id'];
                if(sizeof($user_save)){
                    foreach ($user_save as $key=>$value){
                        if($key==$_POST['time']){
                            unset($user_save[$key]);
                        }
                    }
                }
				if($customer_id){
					$sql="DELETE FROM customers_saved WHERE customer_id =".$customer_id." and customers_saved_id =".(int)$_POST['time'];
					$db->Execute($sql);
				}
				$_SESSION['user_save_cart']=$user_save;
				echo 1;

            }
			exit;
		break;

        case 'add_all_to_cart':
            if($_POST['products_id']){
                $id =$_POST['products_id'];
                $pid=array();
                if(strpos($id,";")){
                    $pid = explode(";",$id);
                }else{
                    $pid[] =$id;
                }
                if(sizeof($pid)){
                    foreach ($pid as $v){
                        if($_SESSION['cart']->in_cart($v)){
                            $now_qty = $_SESSION['cart']->contents[$v]['qty'];
                            $totalQTY = $now_qty + 1;
                            $_SESSION['cart']->contents[$v] = array('qty' => (float)$totalQTY);
                            if (isset($_SESSION['customer_id'])) {
                                $sql = "update " . TABLE_CUSTOMERS_BASKET . "
									set customers_basket_quantity = customers_basket_quantity + '" . (float)$qty . "'
									where customers_id = '" . (int)$_SESSION['customer_id'] . "'
									and products_id = '" . zen_db_input($v) . "'";
                                $db->Execute($sql);
                            }
                        }else{
                            $_SESSION['cart']->add_cart((int)$v,1,'',true,'',0);
                            if (isset($_SESSION['customer_id'])) {
                                $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
			                              (customers_id, products_id, customers_basket_quantity,
			                              customers_basket_date_added)
			                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($v) . "', '" .
                                    $qty . "', '" . date('Ymd') . "')";
                                $db->Execute($sql);
                            }
                        }

                    }
                }
                //刷新头部购物车信息
                $cart_items = $_SESSION['cart']->count_contents();
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $html = $shopping_cart_help->show_cart_products_block($cart_items);
                $Carthtml = products_add_cart_new_popup();

                echo json_encode(array('id'=>$id,'status'=>1,'html'=>$html,'addCarthtml'=>$Carthtml));

            }
         break;
        case 'saved_shipping_name':
            $customer_id = $_SESSION['customer_id'];
            $user_save_time = zen_db_prepare_input($_POST['cart_save_name']) ? zen_db_prepare_input($_POST['cart_save_name']) : '';
            if ($customer_id) {
                $sql = "SELECT user_save_time FROM customers_saved WHERE customer_id =" . $customer_id . " and user_save_time ='" . $user_save_time . "'";
                $data = $db->Execute($sql);
                if ($data->EOF) {
                    exit(json_encode(array('status' => 200, 'data' => '', 'info' => '')));
                }
                exit(json_encode(array('status' => 0, 'data' => '', 'info' => '')));
            }
            exit(json_encode(array('status' => 0, 'data' => FS_SYSTME_BUSY, 'info' => '')));
        case 'update_save_cart':
            $customer_id = $_SESSION['customer_id'];
            if ($customer_id) {
                $debug = false;
                $time = time();
                    $customers_saved_id = zen_db_prepare_input($_POST['cart_name']);  // cart_name
                    if (isset($_POST['cart_name']) && !empty($_POST['cart_name'])) {
                        $contents = $_SESSION['cart']->contents;
                        $columnid = $_SESSION['cart']->columnID;
                        $cart_value = '';
                        if ($contents) {
                            // 查询购物车表 customers_saved表
                            $where = ' customers_saved_id ='.$customers_saved_id.' and customer_id ='.$_SESSION['customer_id'];
                            $list_array = get_save_cart_data($where,true,1,1);
                            if($list_array[0]['is_new'] ==1){
                                $saved_contents = json_decode($list_array[0]['value'],true);
                            }else{
                                require_once DIR_WS_CLASSES.'shoppingCartModel.php';
                                $cartModel = new shoppingCartModel();
                                $saved_contents = $cartModel->get_save_products_by_list_str($list_array[0]['value']);
                            }
                            $saved_products_ids = array_keys($saved_contents);
                            foreach ($contents as $k =>$v) {
                                if (in_array($k,$saved_products_ids)) {
                                    $saved_contents[$k]['qty'] = $saved_contents[$k]['qty'] + $v['qty'];
                                }else{
                                    $saved_contents[$k] = $v;
                                }
                            }
                            //直接通过json_encode 把session中的contents 保存到数据库
                            $cart_value = json_encode($saved_contents);
                            foreach ($contents as $key => $value) {
                                $_SESSION['cart']->remove($key);
                            }
                        }

                        $cart_value_str = substr($cart_value, 0, count($cart_value) - 2);
                            $comment = array(
                                'add_time' => $time,
                                'cart_value' => $cart_value,
                                'customer_id' => $customer_id,
                                'languages_id' => $_SESSION['languages_id'],
                                'is_new' =>1
                            );
                           $result = zen_db_perform('customers_saved', $comment,"update","customer_id=".$customer_id.' and customers_saved_id = '.$customers_saved_id);
                           if ($result) {
                            unset($_SESSION['cart']);
                            if (!isset($_SESSION['user_save_cart'])) {
                                $_SESSION['user_save_cart'] = array($customers_saved_id => $cart_value);
                            } else {
                                $_SESSION['user_save_cart'][$customers_saved_id] = $cart_value;
                            }
                               echo 200;die;
                          }
                    }
                echo 2;die;
            }else{
                echo 0;die;
            }
            break;
        case 'count_num' :
            $data = $_POST['data'];
            $total_num = $total_price = 0;
            foreach ($data as $item) {
                $total_num += (int)$item['num'];
                $total_price += (float)$item['price'] * (int)$item['num'];
            }
            $total_num = $total_num . '&nbsp;' . ($total_num > 1 ? F_BODY_HEADER_ITEMS : F_BODY_HEADER_ITEM);
            $total_price = $currencies->total_format($total_price);
            $ret = ['num' => $total_num, 'price' => $total_price];
            exit(json_encode(array('status' => 200, 'data' => $ret, 'info' => '')));
            break;


        case 'add_to_cart' :
            $data = $_POST['data'];
            if ($data) {
                foreach ($data as $item) {
                    $_SESSION['cart']->add_cart((int)$item['id'], (int)$item['num']);
                }
                $html = products_add_cart_new_popup();
                //更新头部购物车数量
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $headNum = $shopping_cart_help->show_cart_products_block();
                if ($_SESSION['view_cart']) {
                    unset($_SESSION['view_cart']);
                }
                exit(json_encode(array('status' => 200, 'html' => $html, 'info' => $headNum)));
            }
            exit(json_encode(array('status' => 201, 'html' => '', 'info' => '')));
            break;
	}
  }
}

?>