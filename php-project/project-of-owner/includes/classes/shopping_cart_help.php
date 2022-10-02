<?php
class shopping_cart_help {
    function shopping_cart_help(){
        $this->cart = $_SESSION['cart'];
    }
    /**
     * @todo show block of current cart products list info
     * 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动结构
     */
    function show_cart_products_block($cart_items=0){
        global $currencies,$db;
        $is_mobile = isMobile();
        $common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
        $cart_items = $this->cart->count_contents();
        if(!$common_is_mobile){
            $cart_items_str = '';
            if($cart_items>0){
                $cart_items_str = '<span class="top_cart_num">'.$cart_items.'</span>';
            }
            $cart_products_list_html = '<a class="cart_info" href="'.zen_href_link(FILENAME_SHOPPING_CART,'','SSL').'">
                <span class="icon iconfont cart">&#xf142;</span>'.$cart_items_str.'
                <span class="cart_span">'.FILENAME_HOME_CART.'</span>
                </a>
                <div class="top_cart_more">
                <div class="header_sign_more_arrow"></div>
                <div class="top_cart_more_main" id="shopping_cart">
                <div id="loader_order_alone" class="loader_order loading_products"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"></circle></svg></div>
                <p class="shopping_cart_loading_font">'.FS_TOP_CART_LOAD_TITLE.'</p>
                </div></div>';
            //头部购物车板块加载时只展示购物车产品数量 鼠标移上去以后再发送请求展示购物车具体产品
        }else{
//            $save_products = $_SESSION['save_cart']->get_products();
//            $product_off_count = 0;
//            foreach ($save_products as $k=>$save_product){
//                $save_product_id = (int)$save_product['id'];
//                if ($save_product['product_status'] == 0){
//                    $product_off_count = $save_product['quantity']+$product_off_count;
//                }
//            }
            //$cart_items = $cart_items-$product_off_count;
//            $cart_items = $cart_items-$product_off_count;
            $cart_products_list_html = '<a class="header_top_cart icon iconfont" href="'.zen_href_link('shopping_cart').'">&#xf146;';
            if($cart_items>0){
                if($cart_items>99){
                    $cart_products_list_html.= '<i>99+</i>';
                }else{
                    $cart_products_list_html.= '<i>'.$cart_items.'</i>';
                }

            }
            $cart_products_list_html.='</a>';

        }
        return $cart_products_list_html;
    }

    function show_add_to_cart_block(){
        global $currencies;
        $cart_products_list_html = '<dd id="shopping_cart"><ul class="add_cart_03">';
        if($this->cart->count_contents()){
            $cart_products = $this->cart->get_products() ;
            $num =0;
            foreach ($cart_products as $i => $product){
                $link = zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.(int)$product['id']);
                $name = substr($product['name'],0,70)."...";
                $image_src = DIR_WS_IMAGES.(file_exists(DIR_WS_IMAGES.$product['image']) ? $product['image'] : 'no_picture.gif');
                $image = zen_image($image_src,$name,100,100,' border="0" title="'.$name.'"');
                $price = $currencies->display_price($product['price'], 0);
                $cart_price = $product['price'];
                $quantity = $product['quantity'];
                $cart_products_list_html .= '<li id="cart_'.(int)$product['id'].'"><a class="add_cart_04" href="'.$link.'">'.$name.'</a><b>'.$price.' * '.$quantity.'</b>
						<a class="add_cart_05" href="javascript:void();" onclick="javascript:remove_shopping_cart(\''.$product['id'].'\','.$quantity.','.$cart_price.',this);">'.FIBERSTORE_REMOVE.'</a>
						</li>';
            }
            $cart_products_list_html .= '</ul>
				<div class="add_cart_06">'.FIBERSTORE_CART_TOTAL.'('.$cart_items = $_SESSION['cart']->count_contents().FS_ITEMS.')
				<b id="total_price">'.$currencies->display_price($_SESSION['cart']->show_total(),0).'</b>
			    <a class="button_02" href="'.zen_href_link(FILENAME_CHECKOUT).'">'.FS_PROCEED_TO_CHECKOUT.'</a>
			    <div class="ccc"></div></div>';

        }else $cart_products_list_html .= '<b class="no_add_cart">'.FIBERSTORE_SHOPPING_HELP.'</b>';
        return $cart_products_list_html;
    }
}

?>
