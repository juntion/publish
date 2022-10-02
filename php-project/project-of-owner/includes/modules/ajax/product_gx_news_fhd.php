<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']) {

    $action = $_GET['ajax_request_action'];

    if (!zen_not_null($action)) {
        echo "err";
    } else {
        switch ($_GET['ajax_request_action']) {
            case 'showproductsoption':
                $content = '';
                if ($_POST['pid']) {
                    $NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($_POST['pid']);
                    require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));
                    $name_description = FS_products_name_description($_POST['pid']);
					$image = get_resources_img($_POST['pid'], 180, 180);
                    $wholesale_products = fs_get_wholesale_products_array();
                    $language_code = fs_get_data_from_db_fields('code', 'languages', 'languages_id=' . $_SESSION['languages_id'], '');
                    if ($_SESSION['languages_id'] != 1) {
                        $code = '/' . $language_code;
                    } else {
                        $code = '';
                    }
                    $content .= '<div class="product_matrix_pic">
			             <a target="_blank" href="' . $code . '/products/' . (int)$_POST['pid'] . '.html" class="thumbnail">' . $image . '</a>
			             <span class="product_sku">#<span>' . (int)$_POST['pid'] . '</span></span>
				         </div>
				         <div class="product_matrix_info">
				         <div class="product_m_info_tit"><a href="' . $code . '/products/' . (int)$_POST['pid'] . '.html">' . zen_get_products_name($_POST['pid']) . '</a>
				         <span>' . $name_description . '</span>
				         </div>
				         <div class="product_matrix_stock"><span class="products_in_stock">' . $NowInstockQTY . '</span>
				         <b>' . zen_get_products_instock_shipping_date_of_products_id($_POST['pid'], $NowInstockQTY) . '</b></div>';

//add by Henly
                    $cPath = zen_get_product_path($_POST['pid']);
                    if (zen_not_null($cPath)) {
                        $cPath_array = zen_parse_category_path($cPath);
                        $cPath = implode('_', $cPath_array);
                        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];

                    } else {
                        $current_category_id = 0;
                        $cPath_array = array();
                    }


                    $relatedName = '';
                    $list = fs_fiber_optic_products_length_related($_POST['pid']);
                    $related_is_custom = fs_fiber_optic_products_is_custom($_POST['pid']);

                    $relatedName = fs_attribute_related_name($_POST['pid']);
                    $custom_model = false;
                    if (in_array($cPath_array[2], array(87, 1789, 65, 66, 111, 112, 2761, 2763, 2764, 2765, 1144)) || in_array($cPath_array[1], array(1113, 2688)) || $cPath_array[0] != 9) {
                        $custom_model = true;
                    } else {
                        $custom_model = false;
                    }

                    if ($list && !$related_is_custom) { ?>
                        <?php $content .= '<div class="product_03_09 product_03_12"><span class="product_03_02 product_03_15"><label for="attrib-115" class="attribsSelect">' . $relatedName . '</label>: </span><div class="ccc"></div><div class="product_list_quick">'; ?>
                        <?php
                        $ModelCustom = $product_status = '';
                        foreach ($list as $key => $n) {
                            $product_status = fs_get_data_from_db_fields('products_status', 'products', 'products_id=' . (int)$n['products_id'], '');
                            if ($custom_model) {
                                if ($n['length']) {
                                    $plength = explode("[", $n['length']);//�ָ�,��ҪӢ��,ֻҪ����
                                    $FS_length = explode("(", $plength[0]);//�ָ�,��ҪӢ��,ֻҪ����
                                    $ModelCustom = trim($FS_length[0]);
                                } else {
                                    $ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
                                }
                            } else {
                                $ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
                            }
                            if ($n['products_id'] == $_POST['pid']) {
                                ?>
                                <?php $content .= '<div class="pro_item  item_selected"><a href="javascript:void(0)"><b>' . $ModelCustom . '</b><i></i></a></div>'; ?>
                            <?php } else if ($product_status == 1) { ?>
                                <?php $content .= '<div class="pro_item"><a onclick="LAddToCart(' . $n['products_id'] . ')"><b>' . $ModelCustom . '</b><i></i></a></div>'; ?>
                            <?php } ?>
                        <?php } ?>
                        <?php $content .= '</div><div class="ccc"></div></div>'; ?>
                    <?php }


                    if (!in_array($_POST['pid'], $wholesale_products)) {
                        $final_price = $currencies->new_display_price(zen_get_products_base_price((int)$_POST['pid']), 0);
                    } else {
                        $final_price = $currencies->display_price(zen_get_products_base_price((int)$_POST['pid']), 0);
                    }

                    $content .= '<div class="product_matrix_form">
				          <span class="price aaa">' . $final_price . '</span>
				          <span class="product_matrix_btn bbb"><span class="aaa"> ' . TABLE_ATTRIBUTES_QTY_PRICE_QTY . ':</span>
				          <input type="text" id="cart_quantity_' . (int)$_POST['pid'] . '" name="cart_quantity" maxlength = "4"  min="1" value="1" autocomplete="off" class="p_07 product_sticky_qty"> <div class="pro_mun">
			<a href="javascript:void(q_cart_quantity_change(1,' . $_POST['pid'] . '));" class="cart_qty_add"></a>
			<a href="javascript:void(q_cart_quantity_change(0,' . $_POST['pid'] . '));" class="cart_qty_reduce cart_reduce"></a>
		 </div>
				          <a href="' . zen_href_link('shopping_cart') . '" class="btn go-to-cart-page" id="go_to_cart_' . (int)$_POST['pid'] . '"> ' . FS_CART . ' <i class=""></i> </a>
				          <input type="submit" id="Laddbtn_' . (int)$_POST['pid'] . '" onclick="AddToCart(' . (int)$_POST['pid'] . ')" value="' . PRODUCT_INFO_ADD . '" name="Add to Cart" class="button_02 button_10"></span>
				          </div>
				         </div>
				      ';
                }
                echo $content;
                exit;
                break;


            case 'showproductsoption_new':        //fallwind	2017.4.28
                $content = '';
                if ($_POST['pid']) {
                    //$NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($_POST['pid']);

                    $NowInstockQTY = zen_get_sale_stock_num($_POST['pid']);
                    $NowInstockQTY = '<i>' . $NowInstockQTY . ' pcs</i> in stock';

                    require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));
                    $name_description = FS_products_name_description($_POST['pid']);
					$image = get_resources_img($_POST['pid'], 180, 180);
                    $wholesale_products = fs_get_wholesale_products_array();
                    $language_code = fs_get_data_from_db_fields('code', 'languages', 'languages_id=' . $_SESSION['languages_id'], '');
                    if ($_SESSION['languages_id'] != 1) {
                        $code = '/' . $language_code;
                    } else {
                        $code = '';
                    }
                    $content .= '<div class="product_matrix_pic">
			             <a target="_blank" href="' . $code . '/products/' . (int)$_POST['pid'] . '.html" class="thumbnail">' . $image . '</a>
			             <span class="product_sku">#<span>' . (int)$_POST['pid'] . '</span></span>
				         </div>
				         <div class="product_matrix_info">
				         <div class="product_m_info_tit"><a href="' . $code . '/products/' . (int)$_POST['pid'] . '.html">' . zen_get_products_name($_POST['pid']) . '</a>
				         <span>' . $name_description . '</span>
				         </div>
				         <div class="product_matrix_stock"><span class="products_in_stock">' . $NowInstockQTY . '</span>
				         <b>' . zen_get_products_instock_shipping_date_of_products_id($_POST['pid'], $NowInstockQTY) . '</b></div>';

//add by Henly
                    $cPath = zen_get_product_path($_POST['pid']);
                    if (zen_not_null($cPath)) {
                        $cPath_array = zen_parse_category_path($cPath);
                        $cPath = implode('_', $cPath_array);
                        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];

                    } else {
                        $current_category_id = 0;
                        $cPath_array = array();
                    }


                    $relatedName = '';
                    $list = fs_fiber_optic_products_length_related($_POST['pid']);
                    $related_is_custom = fs_fiber_optic_products_is_custom($_POST['pid']);

                    $relatedName = fs_attribute_related_name($_POST['pid']);
                    $custom_model = false;
                    if (in_array($cPath_array[2], array(87, 1789, 65, 66, 111, 112, 2761, 2763, 2764, 2765, 1144)) || in_array($cPath_array[1], array(1113, 2688)) || $cPath_array[0] != 9) {
                        $custom_model = true;
                    } else {
                        $custom_model = false;
                    }

                    if ($list && !$related_is_custom) { ?>
                        <?php $content .= '<div class="product_03_09 product_03_12"><span class="product_03_02 product_03_15"><label for="attrib-115" class="attribsSelect">' . $relatedName . '</label>: </span><div class="ccc"></div><div class="product_list_quick">'; ?>
                        <?php
                        $ModelCustom = $product_status = '';
                        foreach ($list as $key => $n) {
                            $product_status = fs_get_data_from_db_fields('products_status', 'products', 'products_id=' . (int)$n['products_id'], '');
                            if ($custom_model) {
                                if ($n['length']) {
                                    $plength = explode("[", $n['length']);//�ָ�,��ҪӢ��,ֻҪ����
                                    $FS_length = explode("(", $plength[0]);//�ָ�,��ҪӢ��,ֻҪ����
                                    $ModelCustom = trim($FS_length[0]);
                                } else {
                                    $ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
                                }
                            } else {
                                $ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
                            }
                            if ($n['products_id'] == $_POST['pid']) {
                                ?>
                                <?php $content .= '<div class="pro_item  item_selected"><a href="javascript:void(0)"><b>' . $ModelCustom . '</b><i></i></a></div>'; ?>
                            <?php } else if ($product_status == 1) { ?>
                                <?php $content .= '<div class="pro_item"><a onclick="LAddToCart(' . $n['products_id'] . ')"><b>' . $ModelCustom . '</b><i></i></a></div>'; ?>
                            <?php } ?>
                        <?php } ?>
                        <?php $content .= '</div><div class="ccc"></div></div>'; ?>
                    <?php }


                    if (!in_array($_POST['pid'], $wholesale_products)) {
                        $final_price = $currencies->new_display_price(zen_get_products_base_price((int)$_POST['pid']), 0);
                    } else {
                        $final_price = $currencies->display_price(zen_get_products_base_price((int)$_POST['pid']), 0);
                    }

                    $content .= '<div class="product_matrix_form">
				          <span class="price aaa">' . $final_price . '</span>
				          <span class="product_matrix_btn bbb"><span class="aaa"> ' . TABLE_ATTRIBUTES_QTY_PRICE_QTY . ':</span>
				          <input type="text" id="cart_quantity_' . (int)$_POST['pid'] . '" name="cart_quantity" maxlength = "4"  min="1" value="1" autocomplete="off" class="p_07 product_sticky_qty"> <div class="pro_mun">
			<a href="javascript:void(q_cart_quantity_change(1,' . $_POST['pid'] . '));" class="cart_qty_add"></a>
			<a href="javascript:void(q_cart_quantity_change(0,' . $_POST['pid'] . '));" class="cart_qty_reduce cart_reduce"></a>
		 </div>
				          <a href="' . zen_href_link('shopping_cart') . '" class="btn go-to-cart-page" id="go_to_cart_' . (int)$_POST['pid'] . '"> ' . FS_CART . ' <i class=""></i> </a>
				          <input type="submit" id="Laddbtn_' . (int)$_POST['pid'] . '" onclick="AddToCart(' . (int)$_POST['pid'] . ')" value="' . PRODUCT_INFO_ADD . '" name="Add to Cart" class="button_02 button_10"></span>
				          </div>
				         </div>
				      ';
                }
                echo $content;
                exit;
                break;

            //fallwind 	2017.5.5
            case 'actionAddProduct':

                if (!empty($_POST['qtys']) && !empty($_POST['ids'])) {
                    $a = "";
                    $b = "";
                    $ids_array = explode(",", $_POST['ids']);
                    $qtys_array = explode(",", $_POST['qtys']);
                    /*$number = $qtys_array[0] + $qtys_array[1] + $qtys_array[2] + $qtys_array[3] + $qtys_array[4] + $qtys_array[5] + $qtys_array[6];

                    if ($number >= 52) {*/

                    for ($i = 0; $i < count($ids_array); $i++) {

                        if(get_discount_product_qty((int)$ids_array[$i])>0){
                            if ($i == 0) {
                                $cart_products_list_html .= '<a class="header_cart_href" href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '"><span></span>Cart';
                            }
                            $_SESSION['cart']->add_cart($ids_array[$i], $_SESSION['cart']->get_quantity(zen_get_uprid($ids_array[$i],Array())) + ((int)$qtys_array[$i]), Array(), true, array());
                        }else{
                            $sql = 'select is_min_order_qty as min_qty from products where products_id = "' . $ids_array[$i] . '"';
                            $result = $db->Execute($sql);
                            $min_qty = $result->fields['min_qty'];
                            if ((int)$qtys_array[$i] < (int)$min_qty) {    //��ѯ��С����
                                $qtys_array[$i] = $min_qty;
                            }
                            if (isset($ids_array[$i]) && is_numeric($ids_array[$i]) && $qtys_array[$i] > 0) {

                                $attributes = '';
                                $products_id = $ids_array[$i];
                                //$_SESSION['new_products_id_in_cart'] = $products_id;

                                $now_qty = 0;
                                if ($_SESSION['cart']->in_cart($products_id)) {

                                    //$_SESSION['cart']->update_quantity($products_id, $qtys_array[$i], $attributes);
                                    $now_qty = $_SESSION['cart']->contents[$products_id]['qty'];
                                    $totalQTY = $now_qty + $qtys_array[$i];
                                    $_SESSION['cart']->contents[$products_id] = array('qty' => (float)$totalQTY);
                                    if (isset($_SESSION['customer_id'])) {
                                        $sql = "update " . TABLE_CUSTOMERS_BASKET . "
									set customers_basket_quantity = customers_basket_quantity + '" . (float)$qtys_array[$i] . "'
									where customers_id = '" . (int)$_SESSION['customer_id'] . "'
									and products_id = '" . zen_db_input($products_id) . "'";
                                        $db->Execute($sql);
                                    }

                                } else {
                                    //$_SESSION['cart']->contents[] = array($products_id);
                                    $_SESSION['cart']->contents[$products_id] = array('qty' => (float)$qtys_array[$i]);
                                    if (isset($_SESSION['customer_id'])) {
                                        $sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
			                              (customers_id, products_id, customers_basket_quantity,
			                              customers_basket_date_added)
			                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
                                            $qtys_array[$i] . "', '" . date('Ymd') . "')";
                                        $db->Execute($sql);
                                    }
                                }
                                $_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
                            }
//
//

                            $cart_count = $_SESSION['cart']->count_contents();
                            if ($cart_count == 1) {
                                $item = F_BODY_HEADER_ITEM;
                            }
                            if ($cart_count >= 2 && $cart_count <= 4) {
                                $item = F_BODY_HEADER_ITEM_TWO;
                            }
                            if ($cart_count == 0 || $cart_count >= 5) {
                                $item = F_BODY_HEADER_ITEMS;
                            }

                            if ($i == 0) {
                                $cart_products_list_html .= '<a class="header_cart_href" href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '"><span></span>Cart';
                            }


                            $cart_products_list_html .= '<em>' . $_SESSION['cart']->count_contents() . '</em></a>';



                            $cart_products_list_html .= '<div class="header_cart_more">';
                            $cart_products_list_html .= '<div class="header_cart_more_arrow"></div>';
                            $cart_products_list_html .= '<dd id="shopping_cart">';


                            if ($_SESSION['cart']->count_contents()) {
                                $cart_products = $_SESSION['cart']->get_products();
                                $num = 0;
                                $total_price = 0;
                                $more_cart = false;
                                $currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
                                $wholesale_products = fs_get_wholesale_products_array();


                                $productsIds = get_products_ids($cart_products);
                                foreach ($cart_products as $s=>$product) {
                                    if(!empty($productsIds) && in_array((int)$cart_products[$s]['id'],$productsIds)==ture){
                                        $bindingMark = 1;
                                    }else{
                                        unset($bindingMark);
                                    }
                                    $num++;
                                   
                                        $total_price += round($product['final_price'] * $currencies_value, 2) * $product['quantity'];
                                        if (!in_array($product['id'], $wholesale_products)) {
                                            $productsPriceEach = $currencies->new_display_price($product['final_price'], zen_get_tax_rate($product['tax_class_id']), 1) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->new_display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
                                        } else {
                                            $productsPriceEach = $currencies->display_price($product['final_price'], zen_get_tax_rate($product['tax_class_id']), 1) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->new_display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
                                        }
                                  
                                    $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . (int)$product['id']);
                                    //$name = substr($product['name'],0,40)."...";
                                    $name = $product['name'];
									$image = get_resources_img((int)$product['id'], 80, 80, $product['image'], '', '', ' border="0" title="' . $name . '"');
                                    if (!in_array($product['id'], $wholesale_products)) {
                                        $price = $currencies->new_display_price($product['price'], 0);
                                    } else {
                                        $price = $currencies->display_price($product['price'], 0);
                                    }
                                    $cart_price = $product['products_price'];
                                    $quantity = $product['quantity'];

                                    if ($num > 4) {
                                        $cart_products_list_html .= '';
                                        $more_cart = true;
                                    } else {
                                        $cart_products_list_html .= '<li id=' . (int)$product['id'] . '>';
                                        $cart_products_list_html .= '<a class="cart_image" href="' . $link . '">' . $image . ' </a><p class="cart_name_pre"><a title="' . $name . '" class="cart_name" href="' . $link . '">' . $name . '</a>';
                                        $cart_products_list_html .= '<b>' . $productsPriceEach . '*' . $quantity . '</b></p>';

                                        if($bindingMark!=1) {
                                            $cart_products_list_html .= '<a class="cart_remove" href="javascript:remove_shopping_cart(\'' . $product['id'] . '\',' . $quantity . ',' . $cart_price . ');">' . FIBERSTORE_REMOVE . '</a>';
                                        }

                                        $cart_products_list_html .= '</li>';
                                    }
                                }
                                if ($more_cart) {
                                    $cart_products_list_html .= '<a class="cart_more_21" href="' . zen_href_link(FILENAME_SHOPPING_CART) . '"><b>' . FIBERSTORE_VIEW_MORE . '</b></a>';
                                }
                                unset($_SESSION['paypal_ec_temp']);
                                unset($_SESSION['paypal_ec_token']);
                                unset($_SESSION['paypal_ec_payer_id']);
                                unset($_SESSION['paypal_ec_payer_info']);

                                $cart_items = $_SESSION['cart']->count_contents();

                                if ($cart_items == 1) {
                                    $items = F_BODY_HEADER_ITEM;
                                }
                                if ($cart_items >= 2 && $cart_items <= 4) {
                                    $items = F_BODY_HEADER_ITEM_TWO;
                                }
                                if ($cart_items == 0 || $cart_items >= 5) {
                                    $items = F_BODY_HEADER_ITEMS;
                                }
                                $a[] = $ids_array[$i];
                                $b[] = $qtys_array[$i];
                                if ($_SESSION['languages_code'] == 'jp') {
                                    $cart_products_list_html .= '<div>' . $cart_items . $items . '  <b id="total_price">' . $currencies->display_price($total_price / $currencies_value, 0) . '</b>  --  <a class="top_edit_order" href="' . zen_href_link(FILENAME_SHOPPING_CART) . '">' . FIBERSTORE_EDITE_ORDER . '</a> <br>
					<a class="button_04" href="' . zen_href_link('paypal_express.php', 'type=ec', 'SSL', true, true, true) . '">Buy with &nbsp;<img src="' . HTTPS_IMAGE_SERVER . 'images/shopping_ec_paypal.png" alt="FiberStore shopping_ec_paypal.png" title="Paypal"></a>
					<a class="button_02" href="' . zen_href_link(FILENAME_CHECKOUT, '', 'SSL') . '">' . FIBERSTORE_CHECK_YOU_ORDER . '<i class="security_icon"></i></a>
			        </div>';
                                }else {
                                    $cart_products_list_html .= '<div>' . $cart_items . ' ' . $items . '  <b id="total_price">' . $currencies->display_price($total_price / $currencies_value, 0) . '</b>  --  <a class="top_edit_order" href="' . zen_href_link(FILENAME_SHOPPING_CART) . '">' . FIBERSTORE_EDITE_ORDER . '</a> <br>
					<a class="button_04" href="' . zen_href_link('paypal_express.php', 'type=ec', 'SSL', true, true, true) . '">Buy with &nbsp;<img src="' . HTTPS_IMAGE_SERVER . 'images/shopping_ec_paypal.png" alt="FiberStore shopping_ec_paypal.png" title="Paypal"></a>
					<a class="button_02" href="' . zen_href_link(FILENAME_CHECKOUT, '', 'SSL') . '">' . FIBERSTORE_CHECK_YOU_ORDER . '<i class="security_icon"></i></a>
			        </div>';
                                }
                            } else {
                                $cart_products_list_html .= '<b class="no_add_cart">' . FIBERSTORE_SHOPPING_HELP . '</b>';
                            }
                            $cart_products_list_html .= '</dd>';
                            $cart_products_list_html .= '</div>';
                        }
                    }
                    echo $cart_products_list_html;
                    /*} else {
                        echo 1;
                        die;

                    }*/
                }

                exit;
                break;

            case 'quickfinder_list':
                $quickfinder_html = fs_products_list_quickfinder_table($_POST['cid'], $_POST['pid'], $_POST['cPath'], $_POST['subcPath']);
                echo $quickfinder_html;
                exit;
                break;

            case 'wholesaleprice':
                $wholesale_products = fs_get_wholesale_products_array();
                if (!in_array($ids_array[$i], $wholesale_products)) {
                    $wholesale_price = $currencies->new_display_price(fs_get_product_wholesale_price_of_qty((int)$ids_array[$i], (int)$_POST['cart_quantity']), 0);
                } else {
                    $wholesale_price = $currencies->display_price(fs_get_product_wholesale_price_of_qty((int)$ids_array[$i], (int)$_POST['cart_quantity']), 0);
                }
                echo $wholesale_price;
                exit;
                break;

            case 'storeHttpReferers':

                $email_address = zen_db_prepare_input($_POST['email']);
                $products_id = zen_db_prepare_input($_POST['pID']);
                $enquiry = zen_db_prepare_input(strip_tags($_POST['question']));
                if (isset($email_address) && $email_address != '') {
                    $quote_array = array(
                        'products_price_inquiry_email' => $email_address,
                        'products_id' => $products_id,
                        'language_id' => (int)$_SESSION['languages_id'],
                        'products_price_inquiry_description' => $enquiry
                    );
                    //var_dump($quote_array);
                    zen_db_perform(TABLE_PRICE_INQUIRY, $quote_array);
                    exit('success');
                    //send email
                    define('EMAIL_SUBJECT', 'New message from product info price inquiry fiberstore !');
                    $html=zen_get_corresponding_languages_email_common();
                    $html_msg['EMAIL_HEADER'] = $html['html_header'];
                    $html_msg['EMAIL_FOTTER'] = $html['html_footer'];

                    $html_msg['EMAIL_BODY'] = '<tr><td>
	      		<table width="650" border="0" cellspacing="0" cellpadding="0" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#232323; line-height:20px; border:0;">
	       		 <tbody><tr>
	          	<td width="10" bgcolor="#f4f4f4" rowspan="2">&nbsp;</td>

	          <td colspan="2" style="border-right:1px solid #d2d2d2; padding:0 30px; line-height:26px; font-size:11px;">
	    		    <span style="color:#616265; line-height:18px;"><br><br>
    			<b><a class="button_02" href="' . zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_id) . '" >Products Info Price Inquiry:</a></b>
    					Thank you for your letter, we will solve it as soon as possible !</span><br>
			<br>
	            <span style="  font-size:12px; font-weight:bold; display:block; padding-bottom:10px;">Inquiry Information</span>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">E-mail:</span>
	              <span style="width:68%; float:right; text-align:left;">' . $email_address . '</span>
	            </div>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;line-height:20px;">Comments/Questions:</span>
	              <span style="width:68%; float:right; text-align:left; line-height:20px;">' . $enquiry . '</span>
	            </div>
	    		<p style="padding-bottom:35px; height:0">&nbsp;</p>
				   </td>
	              		<td width="9" bgcolor="#f4f4f4" style="border-left:1px solid #e9e9e9;" rowspan="2">&nbsp;</td>
			     </tr></tbody>
			     </table>
	           </td></tr>
	    		';
                    $text_message = 'New message from the product page FiberStore !';
                    $send_to_email = 'support@fiberstore.com';
                    $send_to_name = trim(STORE_NAME);
                    if (!defined('EMAIL_SUBJECT')) {
                        define('EMAIL_SUBJECT', 'New message from partner page of  FiberStore !');
                    }
                    zen_mail_contact_us_or_bulk_order_inquiry($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $name, $email, $html_msg, 'product_info_inquiry');

                    $messageStack->add_session(FILENAME_PRODUCT_INFO_INQUIRY_SUCCESS, '<script type=\'text/javascript\'>alert(\'Post your message successfully !\');</script>', 'success');
                } else exit('error');


                break;

            case 'submit_broker':
                if ($_POST) {
                    //$question_type = $_POST['type'];
                    $question_title = $_POST['title'];
                    $question_content = $_POST['content'];
                    if ($question_title == $_SESSION['question_title'] and $question_content == $_SESSION['question_content']) {
                        exit('more_error');
                    }
                    $question = array(
                        'customers_id' => $_SESSION['customer_id'],
                        'question_title' => $question_title,
                        'question_content' => $question_content,
                        'add_time' => 'now()'
                    );
                    zen_db_perform('customers_broker', $question);
                    $_SESSION['question_title'] = $question_title;
                    $_SESSION['question_content'] = $question_content;
                    if ($_SESSION['customer_id']) {
                        $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
                        $customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
                        $customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
                    }
                    if ($admin_id) {

                        /*				$sql_data_array = array(
                                                        'admin_id' => $admin_id,
                                                        'customers_id' => $cid
                                                        );
                                         zen_db_perform('live_chat_assign_for_phone', $sql_data_array);*/
                        $admin_name = zen_get_admin_name_of_id($admin_id);
                        $admin_email = zen_get_admin_email_of_name($admin_name);
                        /* emial content */
                        $html_msg = array();  //the email content
                        define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
                        $html = zen_get_corresponding_languages_email_common('admin');

                        $html=zen_get_corresponding_languages_email_common();
                        $html_msg['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg['EMAIL_FOTTER'] = $html['html_footer'];

                        $html_msg['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                        $html_msg['CUSTOMER_NAME'] = $customer_name;
                        $html_msg['CUSTOMER_EMAIL'] = $customer_email;
                        $html_msg['QUWSTTION_TITLE'] = $question_title;
                        $html_msg['QUESTION_CONTENT'] = $question_content;

                        $text_message = 'New customer question ,please view';
                        zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg, 'customer_question_to_us');
                        /* end of */
                    }

                    $messageStack->add_session('my_questions', '<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>', 'success');

                    exit('success');

                } else {
                    exit('error');
                }

                break;
            case 'submit_qa':
                if ($_POST) {
                    //$question_type = $_POST['type'];
                    $question_title = $_POST['subject'];
                    $question_content = $_POST['question'];

                    $question = array(
                        'customers_id' => $_SESSION['customer_id'],
                        'question_title' => $question_title,
                        'question_content' => $question_content,
                        'add_time' => 'now()'
                    );


                    if ($_SESSION['customer_id']) {
                        zen_db_perform('customers_broker', $question);
                        $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
                        $customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
                        $customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
                    }
                    if ($admin_id) {

                        $sql_data_array = array(
                            'admin_id' => $admin_id,
                            'customers_id' => $cid
                        );
                        zen_db_perform('live_chat_assign_for_phone', $sql_data_array);
                        $admin_name = zen_get_admin_name_of_id($admin_id);
                        $admin_email = zen_get_admin_email_of_name($admin_name);
                        /* emial content */
                        $html_msg = array();  //the email content
                        define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);
                        $html = zen_get_corresponding_languages_email_common('admin');

                        $html_msg['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                        $html_msg['CUSTOMER_NAME'] = $customer_name;
                        $html_msg['CUSTOMER_EMAIL'] = $customer_email;
                        $html_msg['QUWSTTION_TITLE'] = $question_title;
                        $html_msg['QUESTION_CONTENT'] = $question_content;
                        $text_message = 'New customer question ,please view';
                        zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg, 'customer_question_to_us');                   /* end of */
                    }

                    $messageStack->add_session('my_questions', '<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>', 'success');

                    exit('success');

                } else {
                    exit('error');
                }
            case 'submit_leftqa':
                if ($_POST) {
                    //$question_type = $_POST['type'];

                    $question_title = zen_db_input($_POST['subject']);
                    $question_content = zen_db_input($_POST['question']);

                    $question = array(
                        'customers_id' => $_SESSION['customer_id'],
                        'question_title' => $question_title,
                        'question_content' => $question_content,
                        'add_time' => 'now()'
                    );


                    if ($_SESSION['customer_id']) {
                        zen_db_perform('customers_broker', $question);
                        $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
                        $customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
                        $customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
                    }
                    if ($admin_id) {

                        /*				$sql_data_array = array(
                                                        'admin_id' => $admin_id,
                                                        'customers_id' => $cid
                                                        );
                                         zen_db_perform('live_chat_assign_for_phone', $sql_data_array);*/
                        $admin_name = zen_get_admin_name_of_id($admin_id);
                        $admin_email = zen_get_admin_email_of_name($admin_name);
                        /* emial content */
                        $html_msg = array();  //the email content
                        define('EMAIL_SUBJECT', 'Message from ' . STORE_NAME);

                        $html = zen_get_corresponding_languages_email_common('admin');

                        $html_msg['EMAIL_HEADER'] = $html['html_header'];
                        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
                        $html_msg['CUSTOMER_NAME'] = $customer_name;
                        $html_msg['CUSTOMER_EMAIL'] = $customer_email;
                        $html_msg['QUWSTTION_TITLE'] = $question_title;
                        $html_msg['QUESTION_CONTENT'] = $question_content;
                        $text_message = 'New customer question ,please view';
                        zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg, 'customer_question_to_us');
                        /* end of */
                    }

                    $messageStack->add_session('my_questions', '<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>', 'success');
                    exit('success');

                } else {
                    exit('error');
                }

                break;

        }
    }
}