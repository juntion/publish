<?php

require 'includes/application_top.php';
if($_GET['request_type']=="setCart"){

    isset($_POST['product_id'])?$_POST['product_id']:false;
    $products_info = get_google_products_info('',$_POST['product_id']);
    if($_POST['product_id']!==false) {
        $remove_product = $_SESSION['cart']->remove($_POST['product_id']);

        //头部购物车信息
        // 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
        $cart_items = $_SESSION['cart']->count_contents();
        require_once DIR_WS_CLASSES.'shopping_cart_help.php';
        $shopping_cart_help = new shopping_cart_help();
        $html = $shopping_cart_help->show_cart_products_block($cart_items);

        exit(json_encode(array('html'=>$html,'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency'])));
    }
}

if($_GET['request_type']=="deleteCart"){

    isset($_POST['product_id'])?$_POST['product_id']:false;

    if($_POST['product_id']!==false) {
        $products_info = get_google_products_info('',$_POST['product_id']);
        $remove_product = $_SESSION['cart']->remove($_POST['product_id']);

        //头部购物车信息
        // 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
        $cart_items = $_SESSION['cart']->count_contents();
        $cart_product =$_SESSION['cart']->get_products();
        if($cart_product){
            foreach($cart_product as $kk=>$product){
                //总价
                $totalPrice += $product['final_price']*$product['quantity'];
            }
        }
        $currency = $_SESSION['currency'];
        $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
        $total_new =$currencies->fs_format($totalPrice, true, $currency, $currency_value);//总价
        if($cart_items>1){
            $qty = $cart_items.' '.F_BODY_HEADER_ITEM_TWO;
        }else{
            $qty = $cart_items.' '.F_BODY_HEADER_ITEM;
        }
        $empty_html =' ';
        if($cart_items == 0){
            $cart_link = zen_href_link('index','','SSL');
            $empty_html.='<div class="cart_no"><dl><dt>';
            $empty_html.='<i class="iconfont icon shopping_iconfont"></i></dt>';
            $empty_html.='<dd>'.FS_CART_EMPTY.'</dd>';
            $empty_html.='<dd><a href="'.$cart_link.'" id="checkout" class="shopcart-empty-btn" type="button" value="'.FS_CART_CONTINUE.'">'.FS_GO_SHOPPING.'</a></dd>';
            $empty_html.='</dl></div>';
        }
        require_once DIR_WS_CLASSES.'shopping_cart_help.php';
        $shopping_cart_help = new shopping_cart_help();
        $html = $shopping_cart_help->show_cart_products_block($cart_items);
        $addCarthtml =products_add_cart_new_popup();
        
        $other_quote_products_price = array();
        $ss = 0;
        $CompositeProducts = new classes\CompositeProducts(intval($_POST['product_id']));

        foreach ($cart_product as $k=>$v){
            if ($_POST['product_id'] != $v['id'] && zen_not_null($_SESSION['cart']->contents[$v['id']]['all_ids']) && in_array($_POST['product_id'] ,$_SESSION['cart']->contents[$v['id']]['all_ids'])){
                //该产品询价时其他产品的价格,整单时要跟着变
                $other_quote_products_price[$ss]['id'] = $v['id'];
                $other_quote_products_price[$ss]['products_proce'] = $currencies->total_format_new($cart_product[$k]['final_price'],true,$currency, $currency_value) * $cart_product[$k]['quantity'];
                if(isset($v['reoder_type']) && $v['reoder_type']=="quotation"){  //可以询价
                    $other_quote_products_price[$ss]['quotation'] = 1;
                    $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, $currency, $currency_value);
                    $other_quote_products_price[$ss]['quote_us_price'] = $currencies->total_format_new($v['reoder_info'][0]['products_price'], true, 'USD');
                }else{  //不可以询价
                    $other_quote_products_price[$ss]['quotation'] = 0;
                    $other_quote_products_price[$ss]['quote_price'] = $currencies->total_format_new($v['products_price'], true, $currency, $currency_value);
                    $other_quote_products_price[$ss]['quote_us_price'] = $v['products_price'];
                }
                $other_quote_products_price[$ss]['per_price'] = $currencies->display_price_rate(zen_round(($v['final_price']*$currency_value),$currencies->currencies[$_SESSION['currency']]['decimal_places'],2),0,1).' '.FS_PRODUCT_PRICE_EA;
                $other_quote_products_price[$ss]['composite_product_price'] = $CompositeProducts->show_products_composite(0,$v['id']);  //这里传0不影响  因为对应的产品数量没变 不做计算
                $ss++;
            }
        }

        echo json_encode(array('html'=>$html,'addCarthtml'=>$addCarthtml,'qty'=>$qty,'total'=>$total_new,'empty'=>$empty_html,'num'=>$cart_items,'other_quote_products_price'=>$other_quote_products_price,'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency']));
        die;
    }
}

if($_GET['request_type']=="showTopCart"){
    $cart_products_list_html = '';
    $cart_items = $_SESSION['cart']->count_contents();
    if($cart_items){
        $products = $_SESSION['cart']->get_products() ;
        $num = $total_price = 0;
        $more_cart=false;
        $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
        $productsIds = get_products_ids($products);
        foreach ($products as $i => $product){
            if(!empty($productsIds) && in_array($products[$i]['id'],$productsIds)==ture){
                $bindingMark = 1;
            }else{
                unset($bindingMark);
            }
            $num++;

            $total_price += $product['final_price']*$product['quantity'];
            $productsPriceEach =  $currencies->display_currency_total_price($product['final_price'], zen_get_tax_rate($product['tax_class_id']), 1) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->display_currency_total_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');

            $link = zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.(int)$product['id']);
            //$name = substr($product['name'],0,41)."...";
            $name = $product['name'];
            $image = get_resources_img((int)$product['id'],120,120,$product['image'],$name,'' ,' border="0"');
            $cart_price = $product['products_price'];
            $quantity = $product['quantity'];
            if($num > 4){
                $cart_products_list_html .='';
                $more_cart = true;
            }else{
                $product_category_status = get_product_category_status((int)$product['id']);
                if($bindingMark!=1) {
                    if(!$product_category_status) {
                        $cart_products_list_html .= '<li id=' . (int)$product['id'] . '><a class="cart_image" href="' . $link . '">' . $image . ' </a><p class="cart_name_pre"><a class="cart_name" title="' . $name . '" href="' . $link . '">' . $name . '</a><b>' . $quantity . ' x ' . $productsPriceEach . '</b></p>
						<a class="cart_remove icon iconfont" href="javascript:void();" onclick="javascript:remove_shopping_cart(\'' . $product['id'] . '\',' . $quantity . ',' . $cart_price . ',this);">&#xf092;</a>
						    <div class="cart_remove_loading" style="display: none;">
                                <div class="cart_remove_loading_bg"></div>
                                <div id="loader_order_alone" class="loader_order head_cart"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                            </div>
						</li>';
                    }else{
                        $image = '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
                        $cart_products_list_html .= '<li id=' . (int)$product['id'] . '><span class="cart_image">' . $image . '</span><p class="cart_name_pre"><span class="cart_name" title="' . $name . '">' . $name . '</span><b>' . $quantity . ' x ' . $productsPriceEach . '</b></p>
						<a class="cart_remove icon iconfont" href="javascript:void();" onclick="javascript:remove_shopping_cart(\'' . $product['id'] . '\',' . $quantity . ',' . $cart_price . ',this);">&#xf092;</a>
						    <div class="cart_remove_loading" style="display: none;">
                                <div class="cart_remove_loading_bg"></div>
                                <div id="loader_order_alone" class="loader_order head_cart"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                            </div>
						</li>';
                    }
                }else{
                    if(!$product_category_status){
                        $cart_products_list_html .= '<li id=' . (int)$product['id'] . '><a class="cart_image" href="' . $link . '">' . $image . ' </a><p class="cart_name_pre"><a class="cart_name" title="' . $name . '" href="' . $link . '">' . $name . '</a><b>' . $quantity  . ' x ' . $productsPriceEach . '</b></p>
                            </li>';
                    }else{
                        $image = '<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/logo_trad.jpg" width="120" height="120">';
                        $cart_products_list_html .= '<li id=' . (int)$product['id'] . '>' . $image . '<p class="cart_name_pre">' . $name . '<b>' . $quantity  . ' * ' . $productsPriceEach . '</b></p>
                            </li>';
                    }

                }
            }
        }
        if($more_cart) {
            $cart_products_list_html .= '<a class="top_cart_more_main_tocart" href="'.zen_href_link(FILENAME_SHOPPING_CART).'"><b>'.FIBERSTORE_VIEW_MORE.'</b></a>';
        }

        unset($_SESSION['paypal_ec_temp']);
        unset($_SESSION['paypal_ec_token']);
        unset($_SESSION['paypal_ec_payer_id']);
        unset($_SESSION['paypal_ec_payer_info']);

        if($_SESSION['languages_code']!='ru') {
            if ($cart_items == 1) {
                $items = F_BODY_HEADER_ITEM;
            }
            if ($cart_items >= 2 && $cart_items <= 4) {
                $items = F_BODY_HEADER_ITEM_TWO;
            }
            if ($cart_items == 0 || $cart_items >= 5) {
                $items = F_BODY_HEADER_ITEMS;
            }
        }else{
            $items = FS_SHOP_CART_SAVED_ITMES;
        }
        if ($_SESSION['languages_code'] == 'jp') {
            $cart_products_list_html .= '
                                    <div class="top_cart_more_main_checkout"><p><b>'.$cart_items.$items.'</b>'.FS_SYMBOL.' '.'<b id="total_price">'.$currencies->total_format($total_price,0).'</b>  <br></p>';

        } else {
            $view_cart_str = FIBERSTORE_EDITE_ORDER;
            if($_SESSION['languages_code'] =='ru' && !empty($_SESSION['customer_id'])){
                $view_cart_str = FIBERSTORE_EDITE_ORDER_RU;
            }
            $cart_products_list_html .= '
			  					<div class="top_cart_more_main_checkout"><p><b>'.$cart_items.' '.$items.'</b>'.FS_SYMBOL.' '.'<b id="total_price">'.$currencies->total_format($total_price,0).'</b>  <br></p>';

        }
        if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
            $cart_products_list_html .= '<a class="top_cart_more_main_checkout_btn" href="'.zen_href_link('paypal_express.php', 'type=ec', 'SSL', true, true, true).'">'.FS_BUY_WITH.' &nbsp;<img src="'.HTTPS_IMAGE_SERVER.'images/shopping_ec_paypal.png" alt="FiberStore shopping_ec_paypal.png" title="Paypal"></a>';
        }
        $cart_products_list_html .= '<a class="top_cart_more_main_checkout_btn" onclick="$(this).addClass(\'choosez\').find(\'.top_cart_checkoutTxt\').css(\'opacity\',\'0\');" href="'.zen_href_link(FILENAME_SHOPPING_CART,'','SSL').'"><span class="top_cart_checkoutTxt">'.FS_SHOP_CART_ALERT_JS_77.'</span>
                 <div class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
            </a>
			                    </div>';
    }else{
        $cart_products_list_html .= '<b class="no_add_cart">'.FIBERSTORE_SHOPPING_HELP.'</b>';
    }
    $data = array("result"=>true, "cartHtml" => $cart_products_list_html,"cartItems"=>$cart_items);
    exit(json_encode($data));
}
?>