<?php

use classes\CompositeProducts;

require_once(DIR_WS_CLASSES . 'shoppingCartModel.php');
$cartModel = new shoppingCartModel();
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	$action = $_GET['ajax_request_action'];
	$main_page =$_GET['main_page'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/saved_cart_details.php'); // 调用公共的语言包
        switch($_GET['ajax_request_action']){
            case "add_cart_product":
                if(!is_numeric($_POST['products_id'])){
                    exit(json_encode(array('status' => 6, 'data' => 'The product ID('.$_POST['products_id'].')was not found in our records.')));
                }
                $qty = (int)$_POST['qty'];
                $sql = 'select is_min_order_qty as min_qty from products where products_id = "' . $_POST['products_id'] . '"';
                $result = $db->Execute($sql);
                $min_qty = $result->fields['min_qty'];
                if ((int)$qty < (int)$min_qty) {
                    $qty = $min_qty;
                }
                if(isset($_POST['products_id']) && is_numeric($_POST['products_id']) && $qty > 0){
                    $attributes = '';
                    $products_id = $_POST['products_id'];
                    $warehouse_data = fs_products_warehouse_where();
                    $warehouse_fields = strtolower($warehouse_data['code']).'_status';//分仓开启状态字段
                    $query_warehouse_column = ','.$warehouse_fields.' ';
                    $product_info = $db->getAll("select products_status,{$fsCurrentInquiryField} is_inquiry{$query_warehouse_column} from products where products_id = {$products_id} limit 1");
                    //判断开启状态和询价
                    $products_name = _zen_get_products_name($products_id);
                    $image = get_resources_img(intval($products_id),'100','100','','','',' border="0" ');
                    if($product_info[0]['products_status']!=0 && $product_info[0][$warehouse_fields]!=0 && $product_info[0]['is_inquiry']!=1){
                        $is_pre_order = check_product_is_pre_product($products_id);
                        $productsAttributesInfo = zen_get_products_attributes_total($products_id);
                        $productLengthInfo = fs_product_length_info($products_id);
                        $custom_status = false;
                        $sql = "select column_id,column_name from attribute_custom_column where column_name = '" . (int)$products_id . "' and parent_id = 0";
                        $attribute_custom_column = $db->Execute($sql);
                        if($attribute_custom_column->fields['column_name']>0){
                            $custom_status = true;
                        }
                        if(!$productLengthInfo && !$productsAttributesInfo){
                            $quicktocart = true;
                        }
                        $product_category_status = get_product_category_status($products_id);
                        if($quicktocart && $custom_status == false && !$product_category_status){
                            //重新生成购物车数据板块HTML
                            require_once DIR_WS_CLASSES.'shipping_info.php';
                            $config['pid'] = $products_id;
                            $shipping_info = new ShippingInfo($config);
                            $is_clearance = get_current_pid_if_is_clearance($products_id); //是否是清仓产品;
                            if($is_clearance){
                                $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                                if($clearance_qty==0){
                                    //无库存的清仓产品不能加购
                                    exit(json_encode(array('status' => 5,'error_text'=>QV_CLEARANCE_EMPTY_QTY_TIPS)));
                                }else{
                                    $cart_clear_qty = $_SESSION['cart']->contents[$products_id]['qty'];
                                    if($qty){
                                        if(($cart_clear_qty+$qty)>$clearance_qty){
                                            $qty = (int)($clearance_qty-$cart_clear_qty);
                                            if($qty==0){  //购物车中已经是最大库存
                                                exit(json_encode(array('status' => 5,'clearance_qty'=>$clearance_qty)));
                                            }
                                        }
                                    }else{
                                        exit(json_encode(array('status' => 5,'clearance_qty'=>$clearance_qty)));
                                    }
                                }
                            }
                            //ery  2019.7.12  不管是标准产品还是定制产品 统一用add_cart()方法加入购物车
                            $_SESSION['cart']->add_cart($products_id, $qty);
                            $_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
                            $cart_product = $_SESSION['cart']->get_products();
                            $real_citems = $_SESSION['cart']->count_contents();
                            //获取购物车产品总价等相关数据
                            $return_data = get_shopping_cart_total_info($cart_product);
                            $vat_price = $return_data['vat_price'];     //税收价格
                            $cart_subtotal = $return_data['final_price_total_currency'];	//不加税收的纯产品总价格
                            $total_new = $return_data['total_price_currency']; //购物车总价包含税收
                            $save_total = $return_data['off'] ? $return_data['off']:'0';  //节省价格
                            $header_html = $return_data['header_cart_html'];    //头部购物HTML
                            $cart_html = get_new_cart_list($cart_product);
                            $products_info = get_google_products_info($qty,$products_id);
                            $data = array(
                                'status' => 3,
                                'products_info'=>$products_info,
                                'currencyCode'=>$_SESSION['currency'],
                                "realItem"=>$real_citems,
                                'carthtml'=>$cart_html,
                                "total"=>$total_new,
                                'savetotal'=>$save_total,
                                'headcart'=>$header_html,
                                'product_name'=>$products_name,
                                'qty'=>$qty,
                                'vat_price'=>$vat_price,
                                'subtotal'=>$cart_subtotal,
                                'shopping_total'=>$shopping_total,
                                'cart_no_html' =>get_add_product_html($real_citems),
                                'icon_html' => get_email_print_icon_html()
                            );
                            echo json_encode($data);die();
                        }elseif($quicktocart && $custom_status == false && $product_category_status){
                            exit(json_encode(array('status' => 1, 'info' => '', 'data' => '')));
                        }else{
                            //定制产品弹窗
                            exit(json_encode(array('status' => 2,'name' =>$products_name,'image'=>$image)));
                        }
                    }elseif($product_info[0]['is_inquiry'] == 1){
                        //询价产品弹窗
                        exit(json_encode(array('status' => 2,'name' =>$products_name,'image'=>$image)));
                    }
                }
                exit(json_encode(array('status' => 1, 'info' => '', 'data' => '')));
                break;
			case 'saved_cart_to_save':
                //saved_cart_details页面产品重新加入购物车
                $product_id = $_POST['products_id'];
                $save_id = (int)$_POST['time'];
				if ($product_id && $save_id && $_SESSION['customer_id']){
					$_POST['time'] = str_replace('%20'," ",$_POST['time']);
					$product_id=$_POST['products_id'];
					$customer_id = $_SESSION['customer_id'];
                    //不用session 里面的数据  直接查询  如果是新数据结构用json_decode  否则还是像以前一样分割
                    $where = ' customers_saved_id ='.$save_id .' and customer_id ='.$_SESSION['customer_id'];
                    $list_array = get_save_cart_data($where,true,1,1);
                    if($list_array[0]['is_new'] ==1){
                        $contents = json_decode($list_array[0]['value'],true);
                    }else{
                        //获取改分享记录中的所有产品数据
                        $contents = $cartModel->get_save_products_by_list_str($list_array[0]['value']);
                    }
                    //获取当前产品的数据
                    $products_data = $contents[$product_id];
                    if(!empty($products_data)){
                        $qty = $products_data['qty'];
                        //若是定制产品需要获取属性数组
                        $real_ids = get_real_ids_by_attribute($products_data);
                        $_SESSION['cart']->add_cart((int)$product_id,$qty,$real_ids);
                        $new_id = zen_get_uprid((int)$product_id,$real_ids);
                        $html = products_add_cart_new_popup();
                        require_once DIR_WS_CLASSES.'shopping_cart_help.php'; //更新头部购物车数量
                        $shopping_cart_help = new shopping_cart_help();
                        $head_num = $shopping_cart_help->show_cart_products_block();
                        $data_arr = array('str'=>$product_property,'attr'=>$real_ids,'products_id'=>$product_id,'qty'=>$qty,'new_id'=>$new_id,'html'=>$html,'head_num'=>$head_num);
                        echo json_encode($data_arr);
                    }
				}
				exit;
				break;
            case 'add_to_save':
                global $currencies;
                $products_id = zen_db_input($_POST['products_id']);
                $the_Product_id = (int)$products_id;
                $is_clearance = trim($_POST['is_clearance']);//是否为清仓产品
                $clearance_qty = trim($_POST['clearance_instock']);//清仓产品总库存

                $the_product_name = zen_get_products_name((int)$products_id);
                $the_product_href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($products_id),'NONSSL');
                $the_product = $_SESSION['cart']->contents[$products_id];
                $save_products = $_SESSION['save_cart']->contents[$products_id]['qty']; //购物车中该产品数量
                //删除购物车中当前产品
                $_SESSION['cart']->remove($products_id);
                $attributes = get_real_ids_by_attribute($the_product);
                //把当前产品加入save for later
                if($is_clearance && $clearance_qty && $save_products<=$clearance_qty){
                    $total_qty = $save_products+$the_product['qty'];  //购物车数量+save数量
                    if($total_qty > $clearance_qty){
                        $the_product['qty'] = (int)($clearance_qty-$save_products);
                    }
                }
                $_SESSION['save_cart']->add_cart((int)$products_id, $the_product['qty'], $attributes, true, [], 1);
                $_SESSION['save_pid'] = $products_id;

                $currency = $_SESSION['currency'];
                $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                $save_total = $cart_subtotal ='';

                $products = $_SESSION['cart']->get_products();
                $save_products = $_SESSION['save_cart']->get_products(false, false);
                $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
                //获取购物车产品总价等相关数据
                $return_data = get_shopping_cart_total_info($products);
                $save_total = $return_data['off']; //节省价格
                $cart_subtotal = $return_data['final_price_total_currency']; //不加税收的纯产品总价格
                $total_new = $return_data['total_price_currency']; //购物车总价
                $vat_price = $return_data['vat_price'];     //税收价格
                $header_html = $return_data['header_cart_html'];    //头部购物车板块HTML
                //2019.2.25 pico 购物车,save for later数量计算
                $product_off_count = 0;
                foreach ($save_products as $k=>$save_product){
                    $save_product_id = substr($save_product['id'],0,5);
                    if ($save_product['products_status'] == 0){
                        $product_off_count = $save_product['quantity']+$product_off_count;
                    }
                }
                //echo json_encode($product_off_count);
                $sitems = $_SESSION['save_cart']->count_contents()-$product_off_count;
                $citems = $_SESSION['cart']->count_contents()+$product_off_count;
                $real_citems = $_SESSION['cart']->count_contents();
                //判断购物车数量
                if($citems>1){
                    $qty = $_SESSION['cart']->count_contents()."  ".F_BODY_HEADER_ITEM_TWO;
                }else{
                    $qty = $_SESSION['cart']->count_contents()."  ".F_BODY_HEADER_ITEM;
                }
                $html = $save_html ='';
                $Product_id_arr =array();

                if(empty($_SESSION['customer_id'])){
                    $empty_tip ='<dd class="cart_no_login">'.FS_CART_TIP.'</dd>';
                }else{
                    $empty_tip ='<dd class="cart_no_login">'.FS_SAVE_CART_ENTRANCE.'</dd>';
                }
                if($sitems>1){
                    $save_str = F_BODY_HEADER_ITEM_TWO;
                }else{
                    $save_str = F_BODY_HEADER_ITEM;
                }
                if($citems==0){
                    $html = '<div class="cart_no">
                        <dl>
                            <dt><i class="iconfont icon shopping_iconfont">&#xf142;</i></dt>
                            <dd>'.FS_CART_EMPTY.'</dd>
                                <dd class="cart_no_login"> <?php echo FS_CART_TIP;?></dd>
                                <dd class="cart_no_login">'.($_SESSION['customer_id'] ? FS_SAVE_CART_ENTRANCE:FS_CART_TIP).' </dd>
                            <dd>
                                <a href="javascript:;" id="checkout" onClick="location.href=\''.zen_href_link('index').'\'" class="shopcart-empty-btn" value="Continue Shopping">'.FS_GO_SHOPPING.'</a>
                            </dd>
                        </dl>
                    </div>';
                }else{
                    $html ='';
                    $empty_class ='shopcartSave';
                }
                if($sitems !=0){
                    require_once DIR_WS_CLASSES.'fs_reviews.php';
                    require_once DIR_WS_CLASSES.'shipping_info.php';
                    $fs_reviews =new fs_reviews();
                    if ($_SESSION['languages_code'] == 'mx' || $_SESSION['languages_code'] == 'es'){
                        if ($sitems>1){
                            $fs_note_items = FS_SHOP_CART_SAVED.FS_SHOP_CART_SAVED_WORDS;
                        }else{
                            $fs_note_items = FS_SHOP_CART_SAVED.FS_SHOP_CART_SAVED_WORD;
                        }
                        $save_str_new = '';
                    }else{
                        $fs_note_items = FS_SHOP_CART_SAVED;
                        $save_str_new = '&nbsp;'.$save_str;
                    }
                    $save_html.='<div class="cart-title-md shopcartSaveItem">'.$fs_note_items.' (<span id="save_items">'.$sitems.'</span><span class="save_item">'.$save_str_new.'</span>)</div>';
                    $save_html.='<div class="shopcart-type-wrap shopcart-save shopcartSave" id="shopcartSave">';
                    $save_html.=get_cart_list_html();
                    $save_html.='<dl class="shipment-item">';
                    foreach($save_products as $i=>$product){
                        if(strpos($product['id'],":")){
                            $Product_id_arr = explode(":",$product['id']);
                            $Product_id  = $Product_id_arr[0];
                        }else{
                            $Product_id = $product['id'];
                        }
                        $save_product_id = substr($product['id'],0,5);
                        $product_status = $product['products_status'];
                        $attributeHiddenField = "";
                        $attr_str ='';
                        $attrArray = false;
                        $length_array = array();
                        //把产品的属性值放到一个数组中 方便有属性的组合产品查询子产品
                        $combination_attr = array();
                        $productsName = $product['name'];
                        if (isset($product['attributes']) && is_array($product['attributes'])) {
                            if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
                                $options_order_by= ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
                            } else {
                                $options_order_by= ' ORDER BY popt.products_options_name';
                            }
                            foreach ($product['attributes'] as $option => $value) {
                                if($option != 'length'){
                                    $attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
											 FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
											 WHERE pa.products_id = :productsID
											 AND pa.options_id = :optionsID
											 AND pa.options_id = popt.products_options_id
											 AND pa.options_values_id = :optionsValuesID
											 AND pa.options_values_id = poval.products_options_values_id
											 AND popt.language_id = :languageID
											 AND poval.language_id = :languageID " . $options_order_by;

                                    $attributes = $db->bindVars($attributes, ':productsID', $Product_id, 'integer');
                                    $attributes = $db->bindVars($attributes, ':optionsID', $option, 'integer');
                                    $attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
                                    $attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
                                    $attributes_values = $db->Execute($attributes);

                                    $option_name = $attributes_values->fields['products_options_name'];
                                    $value_name = $attributes_values->fields['products_options_values_name'];
                                    //clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
                                    if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
                                        $attributeHiddenField .= zen_draw_hidden_field('id[' . $Product_id . '][' . TEXT_PREFIX . $option . ']',  $product['attributes_values'][$option]);
                                        $attr_value = htmlspecialchars($product['attributes_values'][$option], ENT_COMPAT, CHARSET, TRUE);
                                    } else {
                                        if(get_attributes_others($option_name,$value_name))continue;
                                        $attributeHiddenField .= zen_draw_hidden_field('id[' . $Product_id . '][' . $option . ']', $value);
                                        $attr_value = $value_name;
                                        $combination_attr[] = (int)$value;
                                    }

                                    $attrArray[$option]['products_options_name'] = $option_name;
                                    $attrArray[$option]['options_values_id'] = $value;
                                    $attrArray[$option]['products_options_values_name'] = $attr_value;

                                }else{
                                    $attributes=$db->getAll("select id,price_prefix,length_price,length,product_id,sign,custom from products_length where product_id = '".$Product_id."' and id = '$value'");
                                    if($attributes){
                                        $attrArray[$option]['length'] = $attributes[0]['length'];
                                        $attrArray[$option]['id'] = $value;
                                        $attributeHiddenField .= zen_draw_hidden_field('length[' . $Product_id . ']', $value);
                                    }
                                }
                            }
                        }
                        $currency = $_SESSION['currency'];
                        $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                        $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
                        $productsPriceTotal = $currencies->display_price_rate(zen_round(($product['final_price']*$currency_value),$decimal), zen_get_tax_rate($product['tax_class_id']), $product['quantity']) .
                            ($product['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
                        $Length=$Attr="";
                        if (isset($attrArray) && is_array($attrArray)) {
                            $attr_str = '<div class="cartAttribsList"><ul>';
                            reset($attrArray);
                            foreach ($attrArray as $option => $value) {
                                if ($option == 'length') {
                                    $Length = $value['length'];
                                    $attr_str .="<li>" . FS_LENGTH_NAME . ' - ' . zen_show_product_length($Length,(int)$Product_id)."</li>";
                                }else{
                                    $Attr[] = $value['options_values_id'];
                                    $attr_str .="<li>".$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name'])."</li>";
                                }
                            }
                            $attr_str .="</ul></div>";
                        }
                        if ($product_status == 0){}else{
                        $image = get_resources_img(intval($Product_id),'120','120',$product['image'],'','',' border="0" ');
                        $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($Product_id),'NONSSL');
                        $min_order_qty = zen_get_products_min_order_by_productsid(intval($Product_id));
                        $shipping_info = new shippingInfo(array("pid"=>(int)$Product_id));
                        $shipping_info->main_page = $main_page;
                        $Attr ? $attr_imp=implode(',',$Attr) : $attr_imp="";
                        $Length ? $Attr['length']=$Length : "";
                        $shipping_info->attr_option_arr = $Attr ? $Attr : array();
                        $shipping_info->set_products_info($product['quantity']);
                        $instockHtml = $shipping_info->showIntockDate(false,1);


                        $attrArrHiddenHtml = zen_draw_hidden_field('attr_arr_'.$product['id'],$attr_imp).zen_draw_hidden_field('attr_length_'.$product['id'],$Length);
                        $save_html .='<dd class="shipment-shopcart-list">';
                        $product_category_status= get_product_category_status($product['id']);

                        if(!$product_category_status) {
                            $save_html .= '<div class="shipment-shopcart-list-box after shopping_cart_pro_con"><div class="new-shopcart-boxz01 new-shopcart-tableBox"><div class="shopcart-products-pic"><a href="' . $link . '">' . $image . '</a></div>';
                            $save_html .= '<div class="shopcart-products-info"> <a class="shopcart-products-name" href="' . $link . '">' . $productsName . '</a>';
                        }else{
                            $image = '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
                            $save_html .= '<div class="shipment-shopcart-list-box after shopping_cart_pro_con"><div class="new-shopcart-boxz01 new-shopcart-tableBox"><div class="shopcart-products-pic">' . $image . '</div>';
                            $save_html .= '<div class="shopcart-products-info">' . $productsName . '';
                        }

                        if($product['quantity'] ==1){
                            $style =' style="display:none"';
                        }else{
                            $style =' style="display:block"';
                        }
                        $save_html.=$attributeHiddenField.$attr_str;
                        $save_html.='<div class="shopping_cart_sku"><span class="product_sku"> #<span>'.$Product_id.'</span></span> -<span class="products_in_stock"></span>'. $instockHtml.$attrArrHiddenHtml.'</div>';
                        /*if(!$product_category_status) {
                            $save_html .= '<div class="shopcart-products-reviews after">' . $fs_reviews->get_product_list_review_show((int)$Product_id) . ' </div>';
                        }*/
                        $quotation_span = '';
                        if (isset($product['reoder_type']) && $product['reoder_type'] == 'quotation') {
                            $reoder_info_length = count($product['reoder_info']);
                            if($product['quantity'] >= $product['reoder_info'][$reoder_info_length-1]['products_quantity']){
                                $quotation_span = '<span class="icon iconfont shopping_NDiscountIcon">&#xf217;</span>';
                            }else{
                                $quotation_span = '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
                            }
                        }
                        /* 新版购物车结构 2019.9.4 Jeremy*/
                        $save_html.='<div class="shopcart-products-panel-op shopcart-products-demPc">
                                    <a class="shopping_cp_cell_move" value="'.$product['id'].'" onclick="add_to_cart(\''.$product['id'].'\',this)" href="javascript:void(0);">
                                        '.FS_SHOP_CART_MOVE.'
                                    </a>
                                    <a name="products[]" value="'.$product['id'].'" href="javascript:;" class="shopcart-remove save_for_late_remove" >
                                        <i class="icon iconfont">&#xf027;</i>
                                        <span>'.FS_REMOVED.'</span>
                                    </a>
                                </div></div>';

                        $productsPriceEach = $currencies->display_price_rate(zen_round(($product['final_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places'],2),0,1);
                        $save_html.='<div class="shopcart-products-pricez shopcart-products-demPc">';
                        $before_discount =  $currencies->total_format($product['products_price']);
                        $save_html .= $quotation_span;
                        $is_ws_price = false;
                        $save_html .= '<span class="shopcart-products-pricez-txt originalPrice_'.$product['id'].'">'.$before_discount.'</span>';
                        $save_html .= '</div><div class="shopcart-products-quantity shopcart-products-demPc">';
                        $save_html .= '<input type="hidden" class="shopping_price  shopping_price_'.$product['id'].'" value="'.zen_round(($product['price']*$currency_value),$decimal).'">
                                    <input type="hidden" class="shopping_price_us shopping_price_us_'.$product['id'].'" value="'.zen_round($product['price'],$currencies->currencies['USD']['decimal_places']).'">
                                    <input type="hidden" class="shopping_weight "  value="'.$product['pure_weight'].'">
                                    <input type="hidden" class="original_price original_price_'.$product['id'].'"  value="'.zen_round(($product['products_price']*$currency_value),$decimal).'">';
                        $save_html .= '<div class="after reset_shopcart_btn_'.$product['id'].'">';
                        $number_class ='shopcart-products-panel-count after reset_shopcart_btn_'.$product['id'].'';
                        if($product_category_status==1){
                            $number_class="shopcart-products-panel-count prevent after";
                        }
                        $save_html .= '<div class="'.$number_class.'"><div class="cart_basket_btn">';

                        //清仓产品限制加购
                        $is_clearance = get_current_pid_if_is_clearance($product["id"]);//是否是清仓产品
                        $is_clearance = $is_clearance ? 1 : 0;
                        $clearance_qty = $shipping_info->getLocalAndWuhanqty();
                        $choosez = '';
                        if($is_clearance==1){
                            if($product['quantity'] >= $clearance_qty){
                                $choosez .= ' choosez';
                            }
                            $clearance_html = zen_draw_hidden_field('is_clearance',$is_clearance).zen_draw_hidden_field('clearance_qty',$clearance_qty);
                        }
                        $save_html .= $clearance_html;
                        $save_html.=' <input type="hidden" name="product_min_qty"><input type="hidden" name="products_id[]" value="'.$product["id"].'"><input type="text" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" >';
                        if ($product_category_status==1){
                            $save_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" class="shopping_add"></a>
                                <a href="javascript:void(0);" class="cart_reduce shopping_minus"></a>
                            </div>';
                        }else{
                            $class = '';
                            if($product['quantity'] == 1){
                                $class = 'choosez';
                            }
                            $save_html .= '<div class="pro_mun">
                                <a href="javascript:void(0);" onclick="save_list_cart_change(1,\''.$product['id'].'\',this)" class="shopping_add cart_qty_add '.$choosez.'"></a>
                                <a href="javascript:void(0);" onclick="save_list_cart_change(2,\''.$product['id'].'\',this)" class="cart_reduce shopping_minus '.$class.'"></a>
                            </div>';
                        }
                        $save_html .= '<a class="remove_cart" href="'.zen_href_link(FILENAME_SHOPPING_CART,'&action=remove_product&product_id='.$Product_id).'"><i></i></a></div></div></div></div>';

                        $save_html .= '<div class="shopcart-products-panel shopcart-products-demPc">
                                            <div class="shopcart-products-panel-pay shopcart-products-panel-count">
                                                <span class="originalPrice originalPrice_'.$product['id'].'">'.$currencies->display_price_rate(zen_round(($product['products_price']*$product['quantity']*$currency_value),$decimal),0,1).'</span><br>
                                            </div>
                                        </div>';

                        $save_html .= '<div class="shopcart-products-demM">
                                                <div class="shopcart-products-playTa">
                                                    <div class="shopcart-products-playTd">
                                                        <div class="shopcart-products-panel-pay panel-pay-m shopcart-products-panel-count">';
                        $save_html .= '<span class="originalPrice originalPrice_'.$product['id'].'">'.$currencies->display_price_rate(zen_round(($product['final_price']*$product['quantity']*$currency_value),$decimal),0,1).'</span><br></div></div>';
                        $save_html .= '<div class="shopcart-products-playTd">';
                        $save_html .= '<div class="shopcart-products-panel-count shopcart-products-pricez-txt">'.$before_discount.FS_PRODUCT_PRICE_EA.'</div></div></div>';
                        $save_html .= '<div class="shopcart-products-playTa">
                                        <div class="shopcart-products-playTd">
                                            <div class="shopcart-products-panel-op">
                                            <a class="shopping_cp_cell_move" value="'.$product['id'].'" onclick="add_to_cart(\''.$product['id'].'\',this)" href="javascript:void(0);">'.FS_SHOP_CART_MOVE.'</a>
                                                <a href="javascript:;" class="shopcart-remove save_for_late_remove"  name="products[]" value="'.$product['id'].'">';
                        $save_html .= '<i class="icon iconfont">&#xf027;</i>';
                        $save_html .= '<span>'.FS_REMOVED.'</span></a></div></div>';
                        $save_html.='<div class="shopcart-products-playTd">'.$clearance_html.'<input type="hidden" name="product_min_qty"><input type="hidden" name="products_id[]" value="'.$product["id"].'"><input type="text" class="shopcart-type-idInput big_input" name="cart_quantity[]" value="'.$product['quantity'].'"  id="save_quantity_'.$product["id"].'" onblur=save_check_min_qty(this,"'.$product["id"].'") onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" onfocus="save_enterKey(this)" class="shopping_cart_01" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" ></div></div></div>';
                        $save_html .= '</div>';
                        /* 新版购物车结构结束 */
                        //子产品代码
                        if (class_exists('classes\CompositeProducts')) {
                            $option_value = '';
                            if($combination_attr){
                                $option_value = reorder_options_values($combination_attr);
                            }
                            $CompositeProducts = new classes\CompositeProducts(intval($product['id']),'',$option_value);
                            $composite_son_product_arr = $CompositeProducts->get_products_composite($product['quantity']);
                            if($composite_son_product_arr){
                                $save_html.= '<div class="shopcart_newPro_box01">
                                 <p class="shopcart_newOrder_item01" onclick="_theSlide($(this))">
                                    '.FS_ITEM_INCLUDES_PRODUCTS.'<span class="iconfont icon"></span>
                                 </p>
                                 <div class="shopcart_newPro_main01 choosez">';

                                foreach ($composite_son_product_arr as $composite_son_product_key => $composite_son_product_val ){
                                    $save_html.= '<div class="shopcart_newPro_cont01">
                                     <div class="shopcart_newPro_imgBox01">'.$composite_son_product_val['products_image_str'].'</div>
                                     <div class="shopcart_newPro_itemBox01">
                                         <p class="shopcart_newOrder_txt">'.$composite_son_product_val['products_name'].'</p>
                                         <p class="shopcart_newOrder_txt01 composite_son_product composite_save_for_later_product_'.$composite_son_product_val['products_id'].'">
                                             <em style="display:none;">'.$composite_son_product_val['one_product_corr_number'].'</em>
                                             <span>'.$composite_son_product_val['buy_number'].'</span>
                                             x <span>'.$composite_son_product_val['original_product_price'].'</span>'.FS_PRODUCT_PRICE_EA.'
                                         </p>
                                    </div>
                                    </div>';
                                }
                                $save_html.= '</div></div>';
                            }} //子产品代码结束
                            $save_html.='</dd>';
                    }}
                    $save_html.='</dl></div>';
                }else{
                    $save_html ='';
                }
                $other_quote_products_price = array();
                $ss = 0;
                foreach ($products as $k=>$v){
                    if ($products_id != $v['id'] && zen_not_null($_SESSION['cart']->contents[$v['id']]['all_ids']) && in_array($products_id ,$_SESSION['cart']->contents[$v['id']]['all_ids'])){
                        //该产品询价时其他产品的价格,整单时要跟着变
                        $other_quote_products_price[$ss]['id'] = $v['id'];
                        $other_quote_products_price[$ss]['products_proce'] = $currencies->total_format_new($products[$k]['final_price'],true,$currency, $currency_value) * $products[$k]['quantity'];
                        if(isset($v['reoder_type']) && $v['reoder_type']=="quotation"){  //可以询价
                            $other_quote_products_price[$ss]['quotation'] = 1;
                            $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, $currency, $currency_value);
                            $other_quote_products_price[$ss]['quote_us_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, 'USD');
                        }else{  //不可以询价
                            $other_quote_products_price[$ss]['quotation'] = 0;
                            $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['products_price'], true, $currency, $currency_value);
                            $other_quote_products_price[$ss]['quote_us_price'] = $v['products_price'];
                        }
                        $other_quote_products_price[$ss]['per_price'] = $currencies->display_price_rate(zen_round(($v['final_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places'],2),0,1).FS_PRODUCT_PRICE_EA;
                        $other_quote_products_price[$ss]['composite_product_price'] = $CompositeProducts->show_products_composite(0,$v['id']);  //这里传0不影响  因为对应的产品数量没变 不做计算
                        $ss++;
                    }
                }


                $product_name =zen_get_products_name($products_id);
                $data = array("type"=>"success","sItem"=>$sitems,"realItem"=>$real_citems,"cItem"=>$citems,"total"=>$total_new,"html"=>$html,"savehtml"=>$save_html,'savetotal'=>$save_total,'headcart'=>$header_html,'product_name'=>$the_product_name,'qty'=>$qty,'vat_price'=>$vat_price,'subtotal'=>$cart_subtotal,'product_href'=>$the_product_href,'other_quote_products_price'=>$other_quote_products_price,'cart_no_html' =>get_add_product_html($real_citems),'icon_html' => get_email_print_icon_html());
                echo json_encode($data);
                exit;
                break;

			case 'add_all_to_cart':

				$products=explode(',',$_POST['products_id']);
				foreach($products as $v){
					$_SESSION['save_cart']->contents[$v]['type']=0;
					$products = $_SESSION['save_cart']->contents[$v];
					$columnID = array();
					$columnID = $_SESSION['save_cart']->columnID[$v];
					$_SESSION['cart_ud'] = $v;
					unset($_SESSION['save_cart']->contents[$v]);
					unset($_SESSION['save_cart']->columnID[$v]);

					$total_qty = $products['qty'];
					if($_SESSION['cart']->in_cart($v)){
						$now_qty = $_SESSION['cart']->contents[$v]['qty'];
						$total_qty += $now_qty;
						$_SESSION['cart']->contents[$v]['qty'] = $total_qty;
					}else{
						$_SESSION['cart']->contents[$v] = $products;
						$_SESSION['cart']->columnID[$v] = $columnID;
					}
					if(isset($_SESSION['customer_id'])){
						$sql = "select customers_basket_id from customers_basket where products_id='{$v}' and customers_id={$_SESSION['customer_id']} and save_type=0";
						$query = $db->Execute($sql);
						if($query->RecordCount()){
							$db->Execute("update customers_basket set customers_basket_quantity={$total_qty} where products_id='{$v}' and customers_id={$_SESSION['customer_id']} and save_type=0");
							$db->Execute("delete from customers_basket where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
							$db->Execute("delete from customers_basket_attributes where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
							$db->Execute("delete from customers_basket_length where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
						}else{
							$db->Execute("update customers_basket set save_type=0,customers_basket_quantity={$total_qty} where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
							$db->Execute("update customers_basket_attributes set save_type=0 where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
							$db->Execute("update customers_basket_length set save_type=0 where products_id='{$v}' and customers_id=".$_SESSION['customer_id']." and save_type=1");
						}
					}
				}
				$items = $_SESSION['save_cart']->count_contents();
				$data = array("type"=>"success","item"=>$items);
				echo json_encode($data);
				exit;
				break;

			case 'add_to_cart':
			    global  $currencies;
                $products_id = trim($_POST['products_id']);
                $the_Product_id = (int)$products_id;
                $is_clearance = trim($_POST['is_clearance']);//是否为清仓产品
                $clearance_qty = trim($_POST['clearance_instock']);//清仓产品总库存

                $the_product_name = zen_get_products_name($products_id);
                $the_product_href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($products_id),'NONSSL');
				$_SESSION['cart_pid'] = $products_id;
				$cart_products = $_SESSION['cart']->contents[$products_id]['qty']; //购物车中该产品数量
                $the_products = $_SESSION['save_cart']->contents[$products_id];
                if($is_clearance && $clearance_qty && $cart_products<=$clearance_qty){
                    $total_qty = $cart_products+$the_products['qty'];  //购物车数量+save数量
                    if($total_qty > $clearance_qty){
                        $the_products['qty'] = (int)($clearance_qty-$cart_products);
                    }
                }

                //删除save for later中的该产品
                $_SESSION['save_cart']->remove($products_id,1);
                //将当前产品加入购物车
                $real_ids = get_real_ids_by_attribute($the_products);
                $_SESSION['cart']->add_cart($products_id, $the_products['qty'], $real_ids); //返回加入的赠品

                $cart_product = $_SESSION['cart']->get_products();
                $save_products = $_SESSION['save_cart']->get_products(false, false);

                //获取购物车产品总价等相关数据
                $return_data = get_shopping_cart_total_info($cart_product);
                $totalPrice = $shopping_total =$subtotal= 0;$save_total='';$cart_subtotal='';
                $not_quote_origin_price =  $not_quote_after_discount_price =0;

                $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
                $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];

                $vat_price = $return_data['vat_price'];     //税收价格
                $cart_subtotal = $return_data['final_price_total_currency'];	//不加税收的纯产品总价格
                $total_new = $return_data['total_price_currency']; //购物车总价包含税收
                $save_total = $return_data['off'] ? $return_data['off']:'0';  //节省价格
                $header_html = $return_data['header_cart_html'];    //头部购物HTML
                

                //2019.2.25 pico 购物车save for later数量计算
                $save_products = $_SESSION['save_cart']->get_products();
                $product_off_count = 0;
                foreach ($save_products as $k=>$save_product){
                    $save_product_id = substr($save_product['id'],0,5);
                    $product_status = $db->Execute("select products_status from products where products_id = {$save_product_id}")->fields['products_status'];
                    if ($product_status == 0){
                        $product_off_count = $save_product['quantity']+$product_off_count;
                    }
                }
                $items = $_SESSION['save_cart']->count_contents()-$product_off_count;
                $citems = $_SESSION['cart']->count_contents();
                $real_citems = $_SESSION['cart']->count_contents();
                //判断购物车数量
                if($citems>1){
                    $qty = $citems."  ".F_BODY_HEADER_ITEM_TWO;
                }elseif($citems==1){
                    $qty = $citems."  ".F_BODY_HEADER_ITEM;
                }

                $list_str = $cartModel->get_save_list_str_by_contents($_SESSION['cart']->contents);
				$cart_html = $quote_type_str='';
                require_once DIR_WS_CLASSES.'shipping_info.php';
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';

                //重新生成购物车数据板块HTML
                $cart_html .= get_new_cart_list($cart_product);
                //打印 分享按钮HTML结构
                $icon_html = get_email_print_icon_html();

                $products_info =get_google_products_info($products['qty'],$products_id);
                $data = array("type"=>"success",'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency'],"item"=>$items,"realItem"=>$real_citems,'carthtml'=>$cart_html,"total"=>$total_new,'savetotal'=>$save_total,'originaltotal'=>$shopping_total,'headcart'=>$header_html,'product_name'=>$the_product_name,'qty'=>$qty,'vat_price'=>$vat_price,'subtotal'=>$cart_subtotal,'shopping_total'=>$shopping_total,'product_href'=>$the_product_href,'cart_no_html' =>get_add_product_html(1),'icon_html'=>$icon_html);
                echo json_encode($data);
                exit;
                break;
			case 'remove_to_save':
				$pid = zen_db_prepare_input($_POST['products_id']);
				if($pid){
					$_SESSION['save_cart']->remove($pid,2);
				}
                //2019.2.25 pico 购物车save for later数量计算
                $save_products = $_SESSION['save_cart']->get_products();
                $product_off_count = 0;
                foreach ($save_products as $k=>$save_product){
                    $save_product_id = substr($save_product['id'],0,5);
                    $product_status = $db->Execute("select products_status from products where products_id = {$save_product_id}")->fields['products_status'];
                    if ($product_status == 0){
                        $product_off_count = $save_product['quantity']+$product_off_count;
                    }
                }
				$items = $_SESSION['save_cart']->count_contents()-$product_off_count;
				echo $items;
				exit;
				break;
			case 'remove_to_save_all':
				$products=explode(',',$_POST['products_id']);
				foreach($products as $v) {
					if ($v) {
						$_SESSION['save_cart']->remove($v, 1);
					}
//					$items = $_SESSION['save_cart']->count_contents();
//					$data = array("type" => "success", "item" => $items);
//					echo json_encode($data);
				}
				exit;
				break;
            case 'remove_to_saved_cart':
                //saved_cart_details页面删除一个产品功能
                $save_id = (int)$_POST['type'];
                $products_id = $_POST['products_id'];
                $error_ids = $_POST['error_ids'];
                $error_product_ids = explode(',', $error_ids);
				if ($products_id && $save_id && $_SESSION['customer_id']){
                    //获取分享订单数据
                    $where = ' customers_saved_id ='.$save_id.' and customer_id ='.$_SESSION['customer_id'];
                    $list_array = get_save_cart_data($where,true,1,1);
                    if($list_array[0]['is_new'] ==1){
                        $contents = json_decode($list_array[0]['value'],true);
                    }else{
                        $contents = $cartModel->get_save_products_by_list_str($list_array[0]['value']);
                    }
                    $other_products = [];
                    if(sizeof($contents)){
                        foreach($contents as $key=>$val){
                            if($key==$products_id){
                                unset($contents[$key]);
                            }else{
                                $other_products[] = (int)$key;
                            }
                        }
                        $pid = array_keys($contents);
                    }
                    $data = '';
                    if(!empty($contents)){
                        if($list_array[0]['is_new'] ==1){
                            $data = json_encode($contents);
                        }else{
                            $data = $cartModel->get_save_list_str_by_contents($contents);
                        }
                    }

					$customer_id = $_SESSION['customer_id'];
					if($customer_id){
                        if($data==""){
                            $sql="DELETE FROM customers_saved WHERE customers_saved_id = '".$save_id."' and customer_id=".$customer_id;
                        }else{
                            $sql="UPDATE customers_saved SET cart_value = '".$data."' WHERE customers_saved_id = '".$save_id."' and customer_id=".$customer_id;
                        }
                        $db->Execute($sql);
					}
					if(!empty($contents)){
						require_once(DIR_WS_CLASSES . 'shopping_cart.php');
						$cart = new shoppingCart();
						$currency = $_SESSION['currency'];
						$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];

                        $cart->contents = $contents;
                        $products = $cart->get_products();
                        //计算剩余产品总价格
                        $total_price = 0;
                        foreach($products as $product){
                            $total_price += $product['final_price']*$product['quantity'];
                        }
                        $totalPrice = $currencies->fs_format($total_price);
                        $term_number = count($products);
						$qty="";
						if($term_number >1){
							$qty= '('.$term_number.' '.FS_CART_ITEMS;
						}else{
							$qty= '('.$term_number.' '.FS_CART_ITEM;
						}
                        //更新 Email和Print功能对应的产品数据
                        $email_print_html = '
                        <a class="save-cart-head-icon" href="javascript:void(0)" onclick="open_email_windows(\''.$data.'\')">
                            <em class="icon iconfont">&#xf045;</em>
                            <span>'.FS_SAVED_CART_EMAIL.'</span>
                        </a>
                        <a class="save-cart-head-icon" target="_blank" href="'.zen_href_link(FILENAME_PRINT_SHOPPING_LIST,'&type=2&list='.$data).'">
                            <em class="icon iconfont">&#xf100;</em>
                            <span>'.FS_SHOP_CART_ALERT_JS_74.'</span>
                        </a>';
                        $reload_true = '';
                        $is_error_remian = array_diff($pid, $error_product_ids);
                        if (empty($is_error_remian)){
                            $reload_true = 1;
                        }
						if($term_number>0){
							echo json_encode(array("type"=>"success","qty"=>$qty,"price"=>$totalPrice,'products'=>$products,'email_print_html'=>$email_print_html,'reload_true' => $reload_true));
						}
					}else{
					    $empty_html.='<div class="cart_no"><dl><dt>';
                        $empty_html.='<i class="iconfont icon shopping_iconfont"></i></dt>';
                        $empty_html.='<dd>'.FS_CART_EMPTY.'</dd>';
                        $empty_html.='<dd><a href="'.$cart_link.'" id="checkout" class="shopcart-empty-btn" type="button" value="'.FS_CART_CONTINUE.'">'.FS_GO_SHOPPING.'</a></dd>';
                        $empty_html.='</dl></div>';
						echo json_encode(array("type"=>'empty', 'empty_html' => $empty_html));
					}
				}else{
					echo json_encode(array("type"=>'erro'));
				}
				exit;
				break;
			case 'remove_to_cart':

			    global $currencies;

				$pid = $_POST['products_id'];
				if($pid){
					$_SESSION['cart']->remove($pid);
				}
				$items = $_SESSION['cart']->count_contents();
				$html = '';
				if($items==0){
					$html .= '<div class="cart_no">
							<dl>
								<dt><img src="'.HTTPS_IMAGE_SERVER.'images/cart_no.png"></dt>
								<dd>'.FS_CART_EMPTY.'</dd>
								<dd> <a href="'.HTTP_SERVER.'"><input id="checkout" class="button_02" type="button" value="'.FS_CART_CONTINUE.'"></a> </dd>
							</dl>
						</div><div class="ccc"></div>';
				}
				$currency = $_SESSION['currency'];
				$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                $decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];
				$totalPrice = 0;
				$products = $_SESSION['cart']->get_products();
				if($products){
					for($i=0, $n=sizeof($products); $i<$n; $i++){

                        $current_product_total = zen_round($products[$i]['final_price'] * $currency_value, $decimal) * $products[$i]['quantity'];
                        $current_product_total = zen_round($current_product_total, $decimal);
                        $current_product_total = $current_product_total/$currency_value;
                        $totalPrice += $current_product_total;

//						$totalPrice += $products[$i]['final_price']*$products[$i]['quantity'];
					}
				}
				$totalPrice = $currencies->fs_format($totalPrice, true, $currency, $currency_value);
				$data = array("type"=>"success","item"=>$items,"total"=>$totalPrice,"html"=>$html);
				echo json_encode($data);
				exit;
				break;
			case 'show_products':
				$_POST['type'] = str_replace('%20'," ",$_POST['type']);
				$type = $_POST['type'];
				$html = '';
				if($type==0){
					$cart = $_SESSION['cart'];
				}else{
					$cart = $_SESSION['save_cart'];
				}
				$cart->store_contents($type);
				$cart->get_products(true);
				$products = $cart->get_products();
				$cart_items = $cart->count_contents();
				$totalPrice = 0;
                $quote_type_str ='';
				$currency = $_SESSION['currency'];
				$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
				$currency_symbol_left =  $currencies->currencies[$_SESSION['currency']]['symbol_left'];

				for ($i=0, $n=sizeof($products); $i<$n; $i++) {
					$attributeHiddenField = "";
					$attrArray = false;
					$length_array = array();
					$productsName = $products[$i]['name'];
					if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
						if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
							$options_order_by= ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
						} else {
							$options_order_by= ' ORDER BY popt.products_options_name';
						}
						if(isset($products[$i]['attributes']['length'])){
							$length_s = get_outer_jacket_length($products[$i]['attributes']['length']);
						}else{
							$length_s = 1;
						}
						foreach ($products[$i]['attributes'] as $option => $value) {
							if($option != 'length'){
								$attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
								 FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
								 WHERE pa.products_id = :productsID
								 AND pa.options_id = :optionsID
								 AND pa.options_id = popt.products_options_id
								 AND pa.options_values_id = :optionsValuesID
								 AND pa.options_values_id = poval.products_options_values_id
								 AND popt.language_id = :languageID
								 AND poval.language_id = :languageID " . $options_order_by;

								$attributes = $db->bindVars($attributes, ':productsID', $products[$i]['id'], 'integer');
								$attributes = $db->bindVars($attributes, ':optionsID', $option, 'integer');
								$attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
								$attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
								$attributes_values = $db->Execute($attributes);

								$option_name = $attributes_values->fields['products_options_name'];
								$value_name = $attributes_values->fields['products_options_values_name'];
								//clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
								if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
									$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . TEXT_PREFIX . $option . ']',  $products[$i]['attributes_values'][$option]);
									$attr_value = htmlspecialchars($products[$i]['attributes_values'][$option], ENT_COMPAT, CHARSET, TRUE);
								} else {
									$attributeHiddenField .= zen_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
									$attr_value = $value_name;
								}

								$attrArray[$option]['products_options_name'] = $option_name;
								$attrArray[$option]['options_values_id'] = $value;
								$attrArray[$option]['products_options_values_name'] = $attr_value;
								$attributes_values->fields['options_values_price'] = get_outer_jacket_options_values_price($option,$attributes_values->fields['options_values_price'],$length_s);
								if($re = fs_attribute_column_option_value_price($products[$i]['id'],$cart->columnID,(int)$option,(int)$value,$length_s)){
									$attributes_values->fields['options_values_price'] = $re[0];
									$attributes_values->fields['price_prefix'] = $re[1];
									if($re[1] == '-'){
										$attrArray[$option]['price_prefix'] = '-';
									}
								}
								$attrArray[$option]['options_values_price'] = $attributes_values->fields['options_values_price'];
								$attrArray[$option]['price_prefix'] = $attributes_values->fields['price_prefix'];
								if(isset($products[$i]['fiber_count']['option_id'])){
									if($products[$i]['fiber_count']['option_id'] == $option){
										$attrArray[$option]['options_values_price'] = $products[$i]['fiber_count']['options_values_price'];
									}
								}

							}else{
								$attributes=$db->getAll("select id,price_prefix,length_price,length,product_id,sign,custom from products_length where product_id = '".$products[$i]['id']."' and id = '$value'");
								if($attributes){
									$attrArray[$option]['length'] = $attributes[0]['length'];
									$attrArray[$option]['id'] = $value;
									if($attributes[0]['price_prefix'] == "+"){
										$attrArray[$option]['length_price'] = get_discount_price($attributes[0]['length_price'],$products[$i]['quantity'],$products[$i]['id']);
									}else{
										$attrArray[$option]['length_price'] = $attributes[0]['length_price'];
									}
									$attrArray[$option]['price_prefix'] = $attributes[0]['price_prefix'];
									$attributeHiddenField .= zen_draw_hidden_field('length[' . $products[$i]['id'] . ']', $value);
								}
							}
						}
					} //end foreach [attributes]

					$attr = zen_get_products_min_order_by_productsid(intval($products[$i]['id']));

					$pAttr = explode(':',$products[$i]['id']);   ########################
					$sql='select is_min_order_qty as min_qty from products where products_id = '.zen_get_prid($products[$i]['id']);
					$result = $db->Execute($sql);
					$min_qty=$result->fields['min_qty'];

					//如果是询盘的产品 则不让增加减少
					if (isset($products[$i]['reoder_type']) && $products[$i]['reoder_type'] == 'quotation' ){
						$quantityField .= zen_draw_hidden_field('product_min_qty', $min_qty) . zen_draw_hidden_field('products_id[]', $products[$i]['id']) .
							zen_draw_hidden_field('cart_quantity[]', $products[$i]['quantity'],"class='shopping_cart_01'"). $products[$i]['quantity'];
					}elseif (isset($attr) && $attr > 0) {
						$string_pid = "'".$products[$i]['id']."'";
						$quantityField .= zen_draw_hidden_field('product_min_qty', $min_qty) . zen_draw_hidden_field('products_id[]', $products[$i]['id']) . zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onblur="check_min_qty(this,'. $string_pid .');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="4"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this)" class="shopping_cart_01"  autocomplete="off"  min="1"', 'text');
					} else {
						$string_pid = "'" . $products[$i]['id'] . "'";
						$quantityField .= zen_draw_hidden_field('product_min_qty', $min_qty) . zen_draw_hidden_field('products_id[]', $products[$i]['id']) . zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onblur="check_min_qty(this,' . $string_pid . ');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="4" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this)" class="shopping_cart_01" autocomplete="off"  min="1" ', 'text');
					}

                    if (isset($products[$i]['reoder_type']) && $products[$i]['reoder_type'] == 'quotation'){
                        $quote_type_str ='<input type="hidden" name="quote_type" value="1">';
                    }else{
                        $quote_type_str ='<input type="hidden" name="quote_type" value="0">';
                    }

					$productsPriceEach =  $currencies->display_price_rate(zen_round(($products[$i]['final_price']*$currency_value),2), zen_get_tax_rate($products[$i]['tax_class_id']), 1) . ($products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) : '');

					$totalPrice += $products[$i]['final_price']*$products[$i]['quantity'];
					$productsPriceTotal = $currencies->display_price_rate(zen_round(($products[$i]['final_price']*$currency_value),2), zen_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) .
						($products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) : '');
					$quantity = $products[$i]['quantity'];
					if($_SESSION['languages_id']==5){
						$productsWeight = ((int)$products[$i]['quantity'] * round($products[$i]['view_weight'],3)) .'&nbsp;kg';
						$pure_weight =  (round($products[$i]['view_weight'],3));
						$productsWeight =str_replace('.',',',$productsWeight);
						$pure_weight =str_replace('.',',',$pure_weight);
					}else{
						$productsWeight = ((int)$products[$i]['quantity'] * round($products[$i]['view_weight'],3)) .'&nbsp;kg';
						$pure_weight =  (round($products[$i]['view_weight'],3));
					}

					$key_data = get_product_category_key((int)$products[$i]['id']);
                    $key = $key_data['key'];
					if($key == 2 || $key == 1){
						if(zen_get_instock_products_warehouse_usa((int)$products[$i]['id'],(int)$products[$i]['quantity']) == false){
							$products_id = (int)$products[$i]['id'];
						}
					}
					$productArray[$i] = array('attributeHiddenField'=>$attributeHiddenField,
						'productImageSrc' => $products[$i]['image'],
						'productsName'=>$productsName,
						'quantityField'=>$quantityField,
						'quantity'=>$quantity,
						'productsPrice'=>$productsPriceTotal,
						'price'=>$products[$i]['final_price'],
						'products_price'=>$products[$i]['products_price'],
						'products_price_total'=>$products[$i]['products_price']*$products[$i]['quantity'],
						'productsPriceEach'=>$productsPriceEach,
						'productsWeight'=> $productsWeight,
						'id'=>$products[$i]['id'],
						'attributes'=>$attrArray,
						'pure_weight' => $pure_weight ,
						'reoder_type'=>$products[$i]['reoder_type'],
						'reoder_price'=>$products[$i]['reoder_price'],
						'reoder_info'=>$products[$i]['reoder_info'],
					);


					//$ny[] = $products_ny_instock;
					if(zen_get_products_length_status((int)$products[$i]['id'])){
						$length_array[$products[$i]['id']] = (int)$attrArray['length']['length']*(int)$quantity;
					}
				}

				$check_status = false;
				$length_arr = array();
				if($length_array){
					foreach($length_array as $key=>$v){
						if($v>0){
							$length_arr[(int)$key] += $v;
						}
					}
				}
				if($length_arr){
					foreach($length_arr as $k){
						if($k<1000) $check_status = true;break;
					}
				}
				if(sizeof($productArray)){
					$status = true;
					$html .= '<div class="shopping_cart">';
					$html .= '<div class="shopping_cart_pro_tit">
				<div class="shopping_cp01">&nbsp;&nbsp;</div>
				<div class="shopping_cp02"><b>'.FS_CART_YOUR_ITEM.'</b></div>
				<div class="shopping_cp03 text_center"><b>'.FS_CART_PRICE.'</b></div>
				<div class="shopping_cp04 text_center"><b>'.FS_CART_QTY.'</b></div>
				<div class="shopping_cp05 text_center"><b>'.FS_CART_WEIGHT.'</b></div>
				<div class="shopping_cp06 text_right"><b>'.FS_CART_TOTAL.'</b></div>
				</div>';
					if($check_status){
						$html .= '<div class="shopping_cart_stock">&nbsp;&nbsp;'.FS_CART_MOQ.'</div>';
					}
					foreach ($productArray as $i => $product){
						$image = get_resources_img($product['id'],180,180,'','','',' border="0" ');
						$link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($product['id']),'NONSSL');
						$min_order_qty = zen_get_products_min_order_by_productsid(intval($product['id']));
						$html .= '<div class="shopping_cart_pro_con">';
						//shopping_cp01板块
						$html .= '<div class="shopping_cp01 shopping_cart_02"><a href="'.$link.'">'.$image.'</a></div>';
						//shopping_cp02板块
						$html .= '<div class="shopping_cp02 shopping_cart_02"><a href="'.$link.'">'.$product['productsName'].'</a>';
						$html .= $product['attributeHiddenField'];
						if (isset($product['attributes']) && is_array($product['attributes'])) {
							$html .= '<div class="cartAttribsList">';
							$html .= '<ul>';
							reset($product['attributes']);
							$Length=$Attr='';
							foreach ($product['attributes'] as $option => $value) {
								if($option == 'length'){ $Length = $value['length'];
									$html .= '<li>'.$value['length'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$value['price_prefix'].$currencies->display_currency_total_price($value['length_price'],0,1).'</li>';
								}else{
									$Attr[] = $value['options_values_id'];
									$html .= '<li>'.$value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']);
									if($value['options_values_price'] > 0){
										$html .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$value['price_prefix'].$currencies->display_currency_total_price($value['options_values_price'],0,1);
									}
									$html .= '</li>';
								}
							}
							$html .= '</ul></div>';
						}
						$html .= '<div class="shopping_cart_sku"><span class="product_sku">#<span>'.(int)$product['id'].'</span></span> - <span class="products_in_stock"></span>';

						$is_custom = true;
						$ProductsID=$product['id'];
						$FsCustomRelate = new classes\custom\FsCustomRelate();
						if(is_array($Attr)&&sizeof($Attr)){
							$FsCustomRelate::$products_id = $product['id'];
							$FsCustomRelate::$optionAttr = $Attr;
							$FsCustomRelate::$length = $Length;
							$matchProducts = $FsCustomRelate->handle();
							if($matchProducts){
								$ProductsID = $matchProducts[0];
								if($FsCustomRelate->result_is_custom) $is_custom = false;
							}else{$is_custom = false;}
						}
						$NowInstockQTY = zen_get_products_instock_total_qty_of_products_id((int)$ProductsID,$is_custom);
						if($NowInstockQTY!==FS_SHIP_AVAI){
							$html .= '<meta itemprop="availability" content="http://schema.org/InStock" />
					<meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
					<span class="products_in_stock">'.$NowInstockQTY.','.'</span> '.zen_get_products_instock_shipping_date_of_products_id((int)$product['id'],$NowInstockQTY,$countries_code_2).'<div class="track_orders_wenhao">
					<div class="question_bg"></div>
					<div class="question_text_01 leftjt"><div class="arrow"></div>
						<div class="popover-content">'.FS_THEA_CTUAL_SHIPPING_TIME.'</div></div></div>';

						}else{
							$html .= '<meta itemprop="availability" content="http://schema.org/InStock" />
					<meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
					<span class="products_in_stock"></span> '.zen_get_products_instock_shipping_date_of_products_id((int)$product['id'],$NowInstockQTY,$countries_code_2).'<div class="track_orders_wenhao">
					<div class="question_bg"></div>
						<div class="question_text_01 leftjt"><div class="arrow"></div>
							<div class="popover-content">';

							if($deliver_time == 1){
								$shipping_html= FS_CART_SHIPPING_HTML1;
							}else if($deliver_time == 2){
								$shipping_html= FS_CART_SHIPPING_HTML2;
							}else{
								$shipping_html= FS_CART_SHIPPING_HTML;
							}
							$html .= $shipping_html;

							$html .= '</div></div></div>';
						}
						$html .= '</div>';
						if($type==0){
							$html .= '<div class="shopping_details_operation">
					<a href="javascript:;" class="shopping_cp_cell_save" value="'.$product['id'].'" onclick="add_to_save(\''.$product['id'].'\',this)">'.FS_SHOP_CART_SAVE.'</a>
					<span class="shopping_cp_line line_blue">|</span>
					<a class="shopping_cp_cell_remove" name="products[]" value="'.$product['id'].'" onclick="remove_to_cart(\''.$product['id'].'\',this)" href="javascript:;">'.FS_REMOVED.'</a></div>';
						}else{
							$html .= '<div class="shopping_details_operation">
						<a class="shopping_cp_cell_move"  value="'.$product['id'].'" onclick="add_to_cart(\''.$product['id'].'\',this)" href="javascript:void(0);">'.FS_SHOP_CART_MOVE.'</a>
						<span class="shopping_cp_line line_blue">|</span>
						<a class="save_for_late_remove"  name="products[]" value="'.$product['id'].'" onclick="remove_to_later(\''.$product['id'].'\',this)"  href="javascript:;">'.FS_REMOVED.'</a></div>';
						}
						$html .= '</div>';
						//shopping_cp03板块
						$html .= '<div class="shopping_cp03 shopping_cart_03 text_center"  >';
						$html .= '<div class="shopping_cp_cell">';
						$is_ws_price = false;
						if(($_SESSION['member_level'] >1 || $product['reoder_type']) && $currencies->display_price_rate(zen_round(($product['products_price']*$currency_value),2),0,1) != $product['productsPriceEach']){
							$html .= '<span>'.FS_SHOP_CART_WAS_ACCOUNT." ".$currencies->display_price_rate(zen_round(($product['products_price']*$currency_value),2),0,1).'</span><br/><input type="hidden" class="ws_price" value="'.zen_round(($product['products_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places']).'">';
							$is_ws_price = true;
						}
						$shopping_total += $product['products_price_total'];
                        if (isset($product['reoder_type']) && $product['reoder_type'] == 'quotation'){
                            $reoder_info_length = count($product['reoder_info']);
                            if($product['quantity'] >= $product['reoder_info'][$reoder_info_length-1]['products_quantity']) {
                                $html .= '<span class="icon iconfont shopping_NDiscountIcon">&#xf217;</span>';
                            }else{
                                $html .= '<span class="icon iconfont shopping_NDiscountIcon" style="display:none">&#xf217;</span>';
                            }
                        }
						$html .= $product['productsPriceEach'];
						$html .= '</div>';
						$html .= '</div>';
						//shopping_cp04板块
						if($type==0){
							$html .= '<div  class="shopping_cp04 text_center"><div class="shopping_cp_cell">
						<div class="cart_basket_btn">'.$product['quantityField'];
							if (!(isset($product['reoder_type']) && $product['reoder_type'] == 'quotation')){
								$html .= '<div class="pro_mun"></div>';
							}
							$html .= '<a class="remove_cart" href="'.zen_href_link(FILENAME_SHOPPING_CART,"&action=remove_product&product_id=".$product['id']).'" href="javascript:void(0)"><i></i></a> </div>';
							$html .= '<div class="ccc"></div>
						<div style="display: none"> <a id="update" href="javascript:void(0);" onClick="javascript: $(\'#cart_form\').submit();">'.FIBERSTORE_CART_ACTUALIZAR.'</a></div></div></div>';
						}else{
							$unit = 'unit';
							if($product['quantity']>1) $unit = 'units';
							$html .= '<div  class="shopping_cp04 text_center">
						<div class="shopping_cp_cell">
							<div class="cart_basket_btn">'.$product['quantity'].$unit.'</div></div></div>';
						}
						//shopping_cp05板块
						$html .= '<div class="shopping_cp05 text_center"><div class="shopping_cp_cell shopping_weight_html">'.$product['productsWeight'].'</div></div>';
						//shopping_cp06板块
						$html .= '<div class="shopping_cp06 text_right"><div class="shopping_cp_cell shopping_price_html">'.$product['productsPrice'].'</div></div>';
						$html .= '<input type="hidden" class="shopping_price"  value="'.zen_round(($product['price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places']).'">
				<input type="hidden" class="shopping_weight"  value="'.$product['pure_weight'].'">';

						$html .= '</div>';
					}

					$html .= '</div>';
					//总价格板块
					if($type==0){
						if(($_SESSION['member_level']>1) && ($shopping_total - $totalPrice > 0) && !$productArray[0]['reoder_type']){
							$off =  $currencies->fs_format(($shopping_total - $totalPrice), true, $currency, $currency_value) ;
							$offers =   '<span><em class="products_in_stock"> <i class="business_icon"></i>'.FS_CART_BUSINESS.' </em> &nbsp; <span class="special_price bbb">'.FS_SHOP_CART_ALERT_JS_3.'&nbsp;&nbsp;'.$currency_symbol_left.'<span class="ws_price_js">'.$off.'</span></span></span>';
						}
						$html .= '<div class="checkout_offset">';
						if($offers){
							$html .= '<div class="checkout_price"><ul><li>'.$offers.'</li></ul></div>';
						}
						$html .= '<div class="checkout_price" id="cart_total_info"><ul>
				<li class="shopping_cart_04_03">
					<span class="bbb">'.$currency_symbol_left.'
					<span class="total_js">'.$currencies->fs_format($totalPrice, true, $currency, $currency_value).'</span></span>';

						if($cart_items >1){
							$html .= '<span>'.FS_CART_CART_TOTAL.'<em>'.FS_TAXES.'</em></span>'.FS_CART_ITEMS.':';
						}else{
							$html .= '<span>'.FS_CART_CART_TOTAL.'<em>'.FS_TAXES.'</em></span>'.FS_CART_ITEM.':';
						}
						$html .= '</li></ul></div>';
						$html .= '<div class="ccc"></div>';
						$html .= '<div class="shopping_cart_05"><span class="shopping_cart_button">';
						if($check_status){
							$html .= '<button type="button" class="contact_button_01" id="checkout_top" disabled value="Proceed to Checkout">'. FS_CART_PROCESSING.'</button>';
						}else{
							$loHref = zen_href_link(FILENAME_CHECKOUT,'','SSL');
							$html .= '<button type="button" class="button_02 " id="checkout" onClick="location.href=\''.$loHref.'\'" value="Proceed to Checkout">'.FS_CART_CHECKOUT.'<i class="security_icon"></i></button>';

						}
						$html .= '</span><div class="ccc"></div></div>';
						$html .= '</div>';
					}
				}else{
					$status = false;
					$html .= '<div class="cart_no">
							<dl>
								<dt><img src="'.HTTPS_IMAGE_SERVER.'images/cart_no.png"></dt>
								<dd>'.FS_CART_EMPTY.'</dd>
								<dd> <a href="'.HTTP_SERVER.'"><input id="checkout" class="button_02" type="button" value="'.FS_CART_CONTINUE.'"></a> </dd>
							</dl>
						</div><div class="ccc"></div>';
				}
				$data = array('status'=>$status,'html'=>$html);
				echo json_encode($data);
				exit;

				break;
			case 'ajax_delete_product':
				require_once DIR_WS_CLASSES.'order.php';
				$order = new order();
				$pid = zen_db_prepare_input($_POST['products']);
				$currency = $_SESSION['currency'];
				$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
				$is_cookie = $_POST['is_cookie'];
				$info = array();$last_info=array();
				if(!empty($pid)){
					//删除所有产品
					$products = $_SESSION['cart']->get_products();
                    if(sizeof($products)){
                        $shopping_total = $product_price_all = 0;
                        $mark = 0;
                        $google_products_info=array();
                        foreach($products as $key=>$val){
                            //获取当前删除产品的相关信息
                            if($val['id']==$pid[0]){
                                $name = $val['name'];
                                $google_products_info = get_google_products_info($val['quantity'],$val['id']);
                                /*$google_products_info = array(
                                    'id'=>(string)((int)$val['id']),
                                    "name"=> $name,
                                    "price"=> sprintf("%.2f",$currencies->fs_format_new($val['final_price'])),
                                    "brand"=> "FS.COM",
                                    "category"=> get_google_products_categories_str($val['id']),
                                    "position"=> 0,
                                    "quantity"=> (float)$val['quantity']
                                );*/
                                $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . intval($val["id"]), 'NONSSL');
                                $key = "deleted_shopping_cart-" . $products[$key]["id"];
                                $info['pro_info'] = $_SESSION['cart']->contents[$pid[0]];
                                $info['pro_column'] = $_SESSION['cart']->columnID[$pid[0]];
                                break;
                            }
                        }
                        //删除当前产品
                        $_SESSION['cart']->remove_all($pid);
                        $all_delete = $pid;  //将当前删除的产品ID也加入删除数组中
                        //计算删除之后的产品不是quote询价产品的 总价 及折算后的总价
                        $not_quote_origin_price = $not_quote_after_discount_price =0;
                        //计算优惠后产品总价格 以及 没有优惠的产品原始总价格
                        $current_product_total = $current_origin_product_total = 0;

                        $last_products = [];    //删除产品之后重新获取剩下的产品的相关数据
                        //为避免多次查询数据库 直接用上面获取到的产品数组 排除已删除的产品 ery 2019.7.9
                        foreach($products as $kk=>$product){
                            if(!in_array($product['id'], $all_delete) && $product['is_checked']==1){
                                $last_products[] = $product;
                            }
                        }
                        //获取购物车产品总价格以及其他相关数据
                        $return_data = get_shopping_cart_total_info($last_products);
                        $product_category_status = get_product_category_status((int)$pid[0]);
                        $display="";
                        if($product_category_status==1){
                            $link = 'javascript:;';
                            $display ="text-decoration:none";
                        }
                        $product_info = array("name" => $name,"link" => $link);
                        $data = array(
                            "status"=>1,
                            "display"=>$display,
                            "total"=>$return_data['total_price_currency'],
                            'subtotal'=>$return_data['final_price_total_currency'],
                            'vat_price'=>$return_data['vat_price'],
                            "tax_prompt"=>$return_data['tax'],
                            "html"=>$return_data['header_cart_html'],
                            "items"=>$return_data['cart_items'],
                            "cart_qty"=>$return_data['qty'],
                            "off"=>$return_data['off'],
                            "products_info"=>$product_info,
                            'currencyCode'=>$_SESSION['currency'],
                            "google_products_info"=>$google_products_info,
                            "info"=>$info,
                        );
                        echo json_encode($data);
                    }else{
                        echo json_encode(array("status"=>0));
                    }
				}else{
					echo json_encode(array("status"=>0));
				}
				exit;
				break;
			case 'reset_deleted_products':
				require_once DIR_WS_CLASSES.'order.php';
				$order = new order();
				$pid = zen_db_prepare_input($_POST['products'][0]);
				$checkPid = explode(':',$pid);
				if (strcmp($checkPid['0'],(int)$checkPid['0'])){
				    echo json_encode(array("status"=>0));
                    exit;
				}
				$data = json_decode($_POST['pro_info'],true);
				if(empty($data)){
					echo json_encode(array("status"=>0));
					exit;
				}
				$real_ids = array();
				$id_column = array();
				$currency = $_SESSION['currency'];
				$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
				if(!empty($data['pro_info']['attributes'])){
                    //attributes 属性数据重新处理
					$real_ids = get_real_ids_by_attribute($data['pro_info']);
				}
				if(!empty($data["pro_column"])){
					$id_column = $data["pro_column"] ;
				}
				$new_qty = $data['pro_info']['qty'];
				$_SESSION['cart']->add_cart($pid, $new_qty, $real_ids, true, $id_column);

				$products = $_SESSION['cart']->get_checked_products()['checkedProducts'];
                //获取购物车产品总价格以及其他相关数据
                $return_data = get_shopping_cart_total_info($products, 2);
				$data = array(
					"tax_prompt"=>$return_data['tax'],
					"off"=>$return_data['off'],
					"status" => 1,
					"cart_qty"=>$return_data['qty'],
					"total" =>$return_data['total_price_currency'],
					"items" => $return_data['cart_items'],
					"html" =>$return_data['header_cart_html'],
					"subtotal" => $return_data['final_price_total_currency'],
					"vat_price" => $return_data['vat_price'],
                    "icon_html" => get_email_print_icon_html(),
                    "title_html" => get_cart_list_html()
				);
				echo json_encode($data);
                exit;
				break;
            case 'open_view_window':
                $contents = $_SESSION['cart']->contents;
                $columnID = $_SESSION['cart']->columnID;
                $list = '';
                if($contents){
                    foreach($contents as $key=>$value){
                        if ($value['qty']) {
                            $list .= $key.':'.$value['qty'];
                            if($value['attributes']){
                                foreach($value['attributes'] as $k=>$v){
                                    $k = str_replace("_","/",$k);
                                    if($v==0){
                                        $list .= '_' . $k . ':{' .$value['attributes_values'][$k].'}';
                                    }else{
                                        $list .= '_'.$k.':'.$v;
                                    }
                                    if($columnID[$key][(int)$k][$v]){
                                        $list .= '-'.$columnID[$key][(int)$k][$v];
                                    }
                                }
                            }
                            $list .= '|';
                        }
                    }
                }
                $list_str = substr($list,0,count($list)-2);


                if (isset($_GET['print_type']) && $_GET['print_type'] === 'inquiry') {
                    $url = zen_href_link(FILENAME_PRINT_SHOPPING_LIST).'&list='.$list_str . "&print_type=inquiry";
                } else {
                    $url = zen_href_link(FILENAME_PRINT_SHOPPING_LIST).'&list='.$list_str;
                }
                echo $url;
                exit();
                break;
		}
	}
}

//重新生成购物车数据板块HTML
function get_new_cart_list($cart_product){
    $cart_html = '';
    global $cartModel;
    $product_data = $cartModel->get_products_data($cart_product);
    $productArray = $product_data['productArr'];
    $list_str = $cartModel->get_save_list_str_by_contents($_SESSION['cart']->contents);
    if(sizeof($productArray)){
        $cart_html .= '<div class="shopcart-type-wrap">';
        $cart_html .= '<input type="hidden" name="share_list_id" value="'.$list_str.'">
                        <input type="hidden" name="ids" value="'.$list_str.'">';
        $cart_html .= get_cart_list_html();
        foreach($productArray as $i=>$product){
            $cart_html .= '<dd class="shipment-shopcart-list" data-cartId="'.$product['id'].'">
                            <div class="shipment-shopcart-list-box after shopping_cart_pro_con">';
            $cart_html .= get_cart_products_list_html($product);

            //组合产品代码
            if (class_exists('classes\CompositeProducts')) {
                $option_value = '';
                if($product['attr_str']){
                    $option_value = reorder_options_values($product['attr_str']);
                }

                $CompositeProducts = new classes\CompositeProducts(intval($product['id']),'',$option_value);
                $composite_son_product_arr = $CompositeProducts->show_products_composite($product['quantity']);
                if($composite_son_product_arr){
                    $cart_html .= '<div class="shopcart_newPro_box01">
                                    <p class="shopcart_newOrder_item01" onclick="_theSlide($(this))">'.FS_ITEM_INCLUDES_PRODUCTS.'
                                        <span class="iconfont icon"></span>
                                    </p>';
                    $cart_html .= '<div class="shopcart_newPro_main01 choosez">';
                    foreach ($composite_son_product_arr as $composite_son_product_key => $composite_son_product_val ){
                        $cart_html .= '<div class="shopcart_newPro_cont01">
                                        <div class="shopcart_newPro_imgBox01">'.$composite_son_product_val['products_image_str'].'
                                        </div>
                                        <div class="shopcart_newPro_itemBox01">
                                            <p class="shopcart_newOrder_txt">'.$composite_son_product_val['products_name'].'
                                            </p>
                                            <p class="shopcart_newOrder_txt01 composite_son_product composite_product_'.$composite_son_product_val['products_id'].'">
                                                <em style="display:none;">'.$composite_son_product_val['one_product_corr_number'].'</em>
                                                <span>'.$composite_son_product_val['buy_number'].'</span>
                                                x <span>'.$composite_son_product_val['products_price_str'].'</span>'.FS_PRODUCT_PRICE_EA.'</p>
                                        </div>
                                    </div>';
                    }
                    $cart_html .= '</div></div>';
                }
            }
            $cart_html .= '</div></dd>';
        }
        $cart_html .='</div>';
    }
    return $cart_html;
}

?>