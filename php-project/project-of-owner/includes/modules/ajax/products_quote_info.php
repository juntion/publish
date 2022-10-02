<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){

	$action = $_GET['ajax_request_action'];

	if(!zen_not_null($action)){
		echo "err";
	}else{
		switch($_GET['ajax_request_action']){
			case 'showproductsoption':
				$content ='';
				$dot = "";
				$is_custome_new = true;
				if($_POST['pid']){
					$options_name = fs_products_option_info($_POST['pid']);
					$productLengthInfo = fs_product_length_info($_POST['pid']);
					require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));
					$name_description = FS_products_name_description($_POST['pid']);
//					$image_src= file_exists(DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid'])) ? DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid']): DIR_WS_IMAGES.'no_picture.gif';
//					$image = zen_image($image_src,zen_get_products_image_of_products_id($_POST['pid']),200,200,'title="'.zen_get_products_image_of_products_id($_POST['pid']).'"');
					$image = get_resources_img($_POST['pid'],180,180,'','',zen_get_products_image_of_products_id($_POST['pid']));
					$wholesale_products = fs_get_wholesale_products_array();
					$language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
					if($_SESSION['languages_id'] !=1){
						$code = '/'.$language_code;
					}else{
						$code ='';
					}
					if (sizeof($options_name)||$productLengthInfo){
						$is_custome_new = false;
					}
					$content .= '<div class="product_matrix_pic">
			             <a target="_blank" href="
'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'" class="thumbnail">'.$image.'</a>
			             <span class="product_sku">#<span>'.(int)$_POST['pid'].'</span></span>
				         </div>
				         <div class="product_matrix_info">
				         <div class="product_m_info_tit"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'">'.zen_get_products_name($_POST['pid']).'</a>';
					//$content .=  '<span>'.$name_description.'</span>';
					$content .= '</div>
				         <div class="product_matrix_stock"><span class="products_in_stock">'.get_instock_info((int)$_POST['pid'],$is_custome_new,false).'</span>
				         </div>';

//add by Henly
					$cPath = zen_get_product_path($_POST['pid']);
					if (zen_not_null($cPath)) {
						$cPath_array = zen_parse_category_path($cPath);
						$cPath = implode('_', $cPath_array);
						$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];

					} else {
						$current_category_id = 0;
						$cPath_array = array();
					}


					$relatedName='';
					$list = fs_fiber_optic_products_length_related($_POST['pid']);
					$related_is_custom = fs_fiber_optic_products_is_custom($_POST['pid']);

					$relatedName = fs_attribute_related_name($_POST['pid']);
					$custom_model = false;
					if(in_array($cPath_array[2],array(87,1789,65,66,111,112,2761,2763,2764,2765,1144)) ||  in_array($cPath_array[1],array(1113,2688)) || $cPath_array[0] != 9){
						$custom_model = true;
					}else{
						$custom_model = false;
					}

					if($list && !$related_is_custom){ ?>
						<?php $content .= '<div class="product_03_09 product_03_12"><span class="product_03_02 product_03_15"><label for="attrib-115" class="attribsSelect">'.$relatedName.'</label>'. ($_SESSION['languages_code'] == 'fr') ? ' ' : ''.': </span><div class="ccc"></div><div class="product_list_quick">';?>
						<?php
						$ModelCustom =$product_status='';
						foreach($list as $key=>$n){
							$product_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$n['products_id'],'');
							if($custom_model){
								if($n['length']){
									$plength=explode("[",$n['length']);//分割,不要英尺,只要米数
									$FS_length=explode("(",$plength[0]);//分割,不要英尺,只要米数
									$ModelCustom = trim($FS_length[0]);
								}else{
									$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
								}
							}else{
								$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
							}
							if($n['products_id'] == $_POST['pid']){
								?>
								<?php $content .= '<div class="pro_item  item_selected"><a href="javascript:void(0)"><b>'.$ModelCustom.'</b><i></i></a></div>';?>
							<?php }else if($product_status ==1){ ?>
								<?php $content .= '<div class="pro_item"><a onclick="LAddToCart('.$n['products_id'].')"><b>'.$ModelCustom.'</b><i></i></a></div>';?>
							<?php } ?>
						<?php } ?>
						<?php $content .='</div><div class="ccc"></div></div>';?>
					<?php }


					if(!in_array($_POST['pid'],$wholesale_products)){
						$final_price = $currencies->new_display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}else{
						$final_price = $currencies->display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}

					$content .= '<div class="product_matrix_form">
				        <span class="price aaa">'.$final_price.'</span>
				        <span class="product_matrix_btn bbb">';
					//加入购物车按钮板块
					$options_name = fs_products_option_info((int)$_POST['pid']);
					if (sizeof($options_name)||$productLengthInfo){
						$is_custome_new = false;
						$content .= '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'"><input type="submit" id="Laddbtn_'.(int)$_POST['pid'].'"  value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10"></a>';
					}else{
						$content .= '<button type="submit" id="Laddbtn_'.(int)$_POST['pid'].'" onclick="AddToCart('.(int)$_POST['pid'].')" value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10 new_pro_addCart_btn">
										<span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>
										<div class="new_addCart_loading choosez">
                                        <div class="new_chec_bg"></div>
                                        <div class="loader_order">
                                        <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                        </svg>
                                        </div>
                                        </div>'.PRODUCT_INFO_ADD.'</button>';
					}
					$content .= '<a id="href" style="display:none" href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'">
					<input type="submit" id="buttom" value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10">
					</a>';
					//数量加减框板块
					$content .=	'<div class="product_matrix_qty">
						  <span class="aaa"> '.TABLE_ATTRIBUTES_QTY_PRICE_QTY.':</span>
				          <input type="text" id="cart_quantity_'.(int)$_POST['pid'].'" name="cart_quantity" maxlength = "5"  min="1" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^\d]/g,\'\')" onblur="q_check_min_qty(this,'.$_POST['pid'].')" onfocus="q_enterKey(this,'.$_POST['pid'].')" autocomplete="off" class="p_07 product_sticky_qty"> 
						  <div class="pro_mun">
							<a href="javascript:void(q_cart_quantity_change(1,'.$_POST['pid'].'));" class="cart_qty_add"></a>
							<a href="javascript:void(q_cart_quantity_change(0,'.$_POST['pid'].'));" class="cart_qty_reduce cart_reduce"></a>           
						  </div>
						</div>
					<a href="'.zen_href_link('shopping_cart').'" class="btn go-to-cart-page" id="go_to_cart_'.(int)$_POST['pid'].'"> '.FS_CART.' <i class=""></i> </a>';

				    $content .= '</span></div></div>';
					$content .='<script type="text/javascript">
					thisUrl = this.location.href;
					if(thisUrl.indexOf("-2866") > 0 || thisUrl.indexOf("-1125") > 0){
						$("input[type=submit]").hide();
						$("#href").show();
						$("#buttom").show();
					}else{
						$("input[type=submit]").show();
						$("#href").hide();
						$("#buttom").hide();
					}</script>';
				}

				echo $content;
				exit;
				break;

			case 'showproductsoption_new':		//fallwind	2017.4.28
				$content ='';
				if($_POST['pid']){
					//$NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($_POST['pid']);

					$NowInstockQTY = zen_get_sale_stock_num($_POST['pid']);
					$NowInstockQTY = '<i>'.$NowInstockQTY.' pcs</i> in stock';

					require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));
					$name_description = FS_products_name_description($_POST['pid']);
					$image_src= file_exists(DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid'])) ? DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid']): DIR_WS_IMAGES.'no_picture.gif';
					$image = zen_image($image_src,zen_get_products_image_of_products_id($_POST['pid']),200,200,'title="'.zen_get_products_image_of_products_id($_POST['pid']).'"');
					$wholesale_products = fs_get_wholesale_products_array();
					$language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
					if($_SESSION['languages_id'] !=1){
						$code = '/'.$language_code;
					}else{
						$code ='';
					}
					$content .= '<div class="product_matrix_pic">
			             <a target="_blank" href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'" class="thumbnail">'.$image.'</a>
			             <span class="product_sku">#<span>'.(int)$_POST['pid'].'</span></span>
				         </div>
				         <div class="product_matrix_info">
				         <div class="product_m_info_tit"><a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'">'.zen_get_products_name($_POST['pid']).'</a>
				         <span>'.$name_description.'</span>
				         </div>
				         <div class="product_matrix_stock"><span class="products_in_stock">'.$NowInstockQTY.'</span>
				         <b>'.zen_get_products_instock_shipping_date_of_products_id($_POST['pid'],$NowInstockQTY).'</b></div>';

//add by Henly
					$cPath = zen_get_product_path($_POST['pid']);
					if (zen_not_null($cPath)) {
						$cPath_array = zen_parse_category_path($cPath);
						$cPath = implode('_', $cPath_array);
						$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];

					} else {
						$current_category_id = 0;
						$cPath_array = array();
					}


					$relatedName='';
					$list = fs_fiber_optic_products_length_related($_POST['pid']);
					$related_is_custom = fs_fiber_optic_products_is_custom($_POST['pid']);

					$relatedName = fs_attribute_related_name($_POST['pid']);
					$custom_model = false;
					if(in_array($cPath_array[2],array(87,1789,65,66,111,112,2761,2763,2764,2765,1144)) ||  in_array($cPath_array[1],array(1113,2688)) || $cPath_array[0] != 9){
						$custom_model = true;
					}else{
						$custom_model = false;
					}

					if($list && !$related_is_custom){ ?>
						<?php $content .= '<div class="product_03_09 product_03_12"><span class="product_03_02 product_03_15"><label for="attrib-115" class="attribsSelect">'.$relatedName.'</label>'.($_SESSION['languages_code'] == 'fr') ? ' ' : ''.': </span><div class="ccc"></div><div class="product_list_quick">';?>
						<?php
						$ModelCustom =$product_status='';
						foreach($list as $key=>$n){
							$product_status = fs_get_data_from_db_fields('products_status','products','products_id='.(int)$n['products_id'],'');
							if($custom_model){
								if($n['length']){
									$plength=explode("[",$n['length']);//分割,不要英尺,只要米数
									$FS_length=explode("(",$plength[0]);//分割,不要英尺,只要米数
									$ModelCustom = trim($FS_length[0]);
								}else{
									$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
								}
							}else{
								$ModelCustom = zen_get_products_model_PART($n['products_id']) ? zen_get_products_model_PART($n['products_id']) : $n['products_id'];
							}
							if($n['products_id'] == $_POST['pid']){
								?>
								<?php $content .= '<div class="pro_item  item_selected"><a href="javascript:void(0)"><b>'.$ModelCustom.'</b><i></i></a></div>';?>
							<?php }else if($product_status ==1){ ?>
								<?php $content .= '<div class="pro_item"><a onclick="LAddToCart('.$n['products_id'].')"><b>'.$ModelCustom.'</b><i></i></a></div>';?>
							<?php } ?>
						<?php } ?>
						<?php $content .='</div><div class="ccc"></div></div>';?>
					<?php }


					if(!in_array($_POST['pid'],$wholesale_products)){
						$final_price = $currencies->new_display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}else{
						$final_price = $currencies->display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}

					$content .= '<div class="product_matrix_form">
				          <span class="price aaa">'.$final_price.'</span>
				          <span class="product_matrix_btn bbb"><span class="aaa"> '.TABLE_ATTRIBUTES_QTY_PRICE_QTY.':</span>
				          <input type="text" id="cart_quantity_'.(int)$_POST['pid'].'" name="cart_quantity" maxlength = "5"  min="1" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^\d]/g,\'\')" onblur="q_check_min_qty(this,'.$_POST['pid'].')" onfocus="q_enterKey(this,'.$_POST['pid'].')" autocomplete="off" class="p_07 product_sticky_qty"> <div class="pro_mun">
			<a href="javascript:void(q_cart_quantity_change(1,'.$_POST['pid'].'));" class="cart_qty_add"></a>
			<a href="javascript:void(q_cart_quantity_change(0,'.$_POST['pid'].'));" class="cart_qty_reduce cart_reduce"></a>           
		 </div>
				          <a href="'.zen_href_link('shopping_cart').'" class="btn go-to-cart-page" id="go_to_cart_'.(int)$_POST['pid'].'"> '.FS_CART.' <i class=""></i> </a>
				          <input type="submit" id="Laddbtn_'.(int)$_POST['pid'].'" onclick="AddToCart('.(int)$_POST['pid'].')" value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10"></span>
				          </div>
				         </div>
				      ';
				}
				echo $content;
				exit;
				break;

			//fallwind 	2017.5.5
			case 'actionAddProduct':
				$qty = (int)$_POST['cart_quantity'];
				$_POST['products_id'] = (int)$_POST['products_id'];
				$sql='select is_min_order_qty as min_qty from products where products_id = '.(int)$_POST['products_id'];
				$result = $db->Execute($sql);
				$min_qty=$result->fields['min_qty'];
				$clearance_qty = (int)$_POST['clearance_qty'];   //清仓产品总库存
				if((int)$qty<(int)$min_qty){	//查询最小数量
					$qty = $min_qty;
				}
				$from = $_POST['from'] ? zen_db_prepare_input($_POST['from']) : '';	//请求改接口的来源位置
				$products_clearance_tip = QV_CLEARANCE_EMPTY_QTY_TIPS;	//清仓产品的提示语
				$clearance_other_qty = 0;	//清仓产品可以加购的库存
				if(isset($_POST['products_id']) && is_numeric($_POST['products_id']) && $qty > 0){
					$attributes = '';
					$products_id = $_POST['products_id'];
                    //清仓产品限制加购 dylan 2019.8.30
                    $cart_products = $_SESSION['cart']->get_products();
                    if($_POST['is_clearance']){
						$cart_pid_qty = 0;
                    	if($_SESSION['cart']->in_cart($products_id)){
							$cart_pid_qty = $_SESSION['cart']->contents[$products_id]['qty'];
						}
						$add_clearance_qty = (int)($qty + $cart_pid_qty);
						$clearance_other_qty = ($clearance_qty-$add_clearance_qty) ? $clearance_qty-$add_clearance_qty:0;
						if($add_clearance_qty>$clearance_qty){
							//定制产品匹配到的标准产品是清仓产品时  需要获取清仓产品数量不足时限购提示语
							if($from=='custom_match' && $_POST['is_clearance']){
								$sql = "select replace_products,replace_products_tip from products_clearance where products_id=".intval($_POST['products_id']);
								$query = $db->Execute($sql);
								$products_clearance = $query->fields;
								if ($products_clearance) {
									$products_clearance['replace_products'] = explode(';', $products_clearance['replace_products']);
									$products_clearance['replace_products'] = array_filter($products_clearance['replace_products']);
									if (count($products_clearance['replace_products'])) {
										$products_clearance_replace = current($products_clearance['replace_products']);
										//有替代产品
										if ($clearance_qty > 0 ) {
											$products_clearance_tip = '<p>'.FS_CLEARANCE_TIP_01_01.'</p>'.'<p>'.FS_CLEARANCE_TIP_01_02.'</p>';
											$products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($clearance_qty, $products_clearance_replace), $products_clearance_tip);
										} else {
											$products_clearance_tip = '<p>'.FS_CLEARANCE_TIP_02_01.'</p>'.'<p>'.FS_CLEARANCE_TIP_02_02.'</p>';
											$products_clearance_tip = str_replace(array('$QTY', '$PRODUCTS_ID'), array($clearance_qty, $products_clearance_replace), $products_clearance_tip);
										}

									} else {
										//对于无替代或者不可定制产品
										if ($clearance_qty > 0 ) {
											$products_clearance_tip = '<p>'.FS_CLEARANCE_TIP_03_01.'</p>'.'<p>'.FS_CLEARANCE_TIP_03_02.'</p>';
											$products_clearance_tip = str_replace(array('$QTY'), array($clearance_qty), $products_clearance_tip);
										} else {
											$products_clearance_tip = '<p>'.FS_CLEARANCE_TIP_04_01.'</p>'.'<p>'.FS_CLEARANCE_TIP_04_02.'</p>';
										}
									}

								}
							}
							exit(json_encode(array('status'=>'error','clearanceTip'=>$products_clearance_tip)));//如果(加购+已加购)数量大于总库存之和，则不让加购
						}
					}
					//判断客户是否勾选test tool  或者是搭配产品
					$test_tool = (int)$_POST['test_tool'];
					if($test_tool !=0){
						$match_products_id = $_POST['match_products_id'] ? trim($_POST['match_products_id']) : '';
						//根据现有的产品id  查询出相对应的test_tool产品及数量
						$test_tool_arr = get_products_related_test_tool($_POST['products_id'],1,$match_products_id);
						$test_tool_products = $test_tool_arr['products_arr'];
						foreach ($test_tool_products as $key=>$test_tool_product){
							$_SESSION['cart']->add_cart($test_tool_product['products_id'], $test_tool_product['quality']);
						}
					}
					$_SESSION['cart']->add_cart($products_id, $qty);
					$_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
				}


				$cart_count = $_SESSION['cart']->count_contents();
				if($cart_count==1){  $item = F_BODY_HEADER_ITEM;}
				if($cart_count>=2 && $cart_count<=4 ){ $item= F_BODY_HEADER_ITEM_TWO; }
				if($cart_count==0 || $cart_count>=5){ $item = F_BODY_HEADER_ITEMS; }


                //刷新头部购物车信息
                //外部图标部分
                // 2018.7.5/7.14 小语种/英文新版首页上线 fairy 稍微改动顶部购物车结构
                $cart_items = $_SESSION['cart']->count_contents();
                require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                $shopping_cart_help = new shopping_cart_help();
                $html = $shopping_cart_help->show_cart_products_block($cart_items);
                $Carthtml = products_add_cart_new_popup();
                $products_info = get_google_products_info($qty,$_POST['products_id']);

                if($_POST['type'] ==1){
                    exit(json_encode(array('status'=>'success','html'=>$html,'addCarthtml'=>$Carthtml,'products_info'=>$products_info,'currencyCode'=>$_SESSION['currency'],'clearance_other_qty'=>$clearance_other_qty)));
                }else{
                    echo $html;
                }
				break;

			case 'quickfinder_list':
				$quickfinder_html = fs_products_list_quickfinder_table($_POST['cid'],$_POST['pid'],$_POST['cPath'],$_POST['subcPath']);
				echo $quickfinder_html;
				exit;
				break;

			case 'wholesaleprice':
				$wholesale_products = fs_get_wholesale_products_array();
				if(!in_array($_POST['products_id'],$wholesale_products)){
					$wholesale_price = $currencies->new_display_price(fs_get_product_wholesale_price_of_qty((int)$_POST['products_id'],(int)$_POST['cart_quantity']),0);
				}else{
					$wholesale_price = $currencies->display_price(fs_get_product_wholesale_price_of_qty((int)$_POST['products_id'],(int)$_POST['cart_quantity']),0);
				}
				echo $wholesale_price;
				exit;
				break;

			case 'storeHttpReferers':

				$email_address = zen_db_prepare_input($_POST['email']);
				$products_id = zen_db_prepare_input($_POST['pID']);
				$enquiry = zen_db_prepare_input(strip_tags($_POST['question']));
				if(isset($email_address) && $email_address != ''){
					$quote_array = array(
						'products_price_inquiry_email' => $email_address,
						'products_id' => $products_id,
						'language_id' => (int)$_SESSION['languages_id'],
						'products_price_inquiry_description' => $enquiry
					);
					//var_dump($quote_array);
					zen_db_perform(TABLE_PRICE_INQUIRY,$quote_array);
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
    			<b><a class="button_02" href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id).'" >Products Info Price Inquiry:</a></b>
    					Thank you for your letter, we will solve it as soon as possible !</span><br>
			<br>
	            <span style="  font-size:12px; font-weight:bold; display:block; padding-bottom:10px;">Inquiry Information</span>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;">E-mail:</span>
	              <span style="width:68%; float:right; text-align:left;">'.$email_address.'</span>
	            </div>

	            <div style="clear:both;">
	              <span style="width:30%; float:left; text-align:right;line-height:20px;">Comments/Questions:</span>
	              <span style="width:68%; float:right; text-align:left; line-height:20px;">'.$enquiry.'</span>
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
					$send_to_name =  trim(STORE_NAME);
					if (!defined('EMAIL_SUBJECT')) {
						define('EMAIL_SUBJECT', 'New message from partner page of  FiberStore !');
					}
					zen_mail_contact_us_or_bulk_order_inquiry($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $name, $email, $html_msg,'product_info_inquiry');

					$messageStack->add_session(FILENAME_PRODUCT_INFO_INQUIRY_SUCCESS,'<script type=\'text/javascript\'>alert(\'Post your message successfully !\');</script>','success');
				}else exit('error');


				break;

			case 'submit_broker':
				if($_POST){
					//$question_type = $_POST['type'];
					$question_title = $_POST['title'];
					$question_content = $_POST['content'];
					if($question_title == $_SESSION['question_title'] and $question_content == $_SESSION['question_content']){
						exit('more_error');
					}
					$question = array(
						'customers_id' => $_SESSION['customer_id'],
						'question_title' => $question_title,
						'question_content' => $question_content,
						'add_time' => 'now()'
					);
					zen_db_perform('customers_broker', $question);
					$_SESSION['question_title']=$question_title;
					$_SESSION['question_content']=$question_content;
					if($_SESSION['customer_id']){
						$admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
						$customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
						$customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
					}
					if($admin_id){

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
						$html=zen_get_corresponding_languages_email_common('admin');
						$html_msg['EMAIL_HEADER'] = $html['html_header'];
						$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
						$html_msg['CUSTOMER_NAME'] = $customer_name;
						$html_msg['CUSTOMER_EMAIL'] = $customer_email;
						$html_msg['QUWSTTION_TITLE'] = $question_title;
						$html_msg['QUESTION_CONTENT'] = $question_content;

						$text_message = 'New customer question ,please view';
						zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg,'customer_question_to_us');
						/* end of */
					}

					$messageStack->add_session('my_questions','<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>','success');

					exit('success');

				}else{
					exit('error');
				}

				break;
			case 'submit_qa':
				if($_POST){
					//$question_type = $_POST['type'];
					$question_title = $_POST['subject'];
					$question_content = $_POST['question'];

					$question = array(
						'customers_id' => $_SESSION['customer_id'],
						'question_title' => $question_title,
						'question_content' => $question_content,
						'add_time' => 'now()'
					);


					if($_SESSION['customer_id']){
						zen_db_perform('customers_broker', $question);
						$admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
						$customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
						$customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
					}
					if($admin_id){

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
						$html=zen_get_corresponding_languages_email_common('admin');

						$html_msg['EMAIL_HEADER'] = $html['html_header'];
						$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
						$html_msg['CUSTOMER_NAME'] = $customer_name;
						$html_msg['CUSTOMER_EMAIL'] = $customer_email;
						$html_msg['QUWSTTION_TITLE'] = $question_title;
						$html_msg['QUESTION_CONTENT'] = $question_content;
						$text_message = 'New customer question ,please view';
						zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg,'customer_question_to_us');                   /* end of */
					}

					$messageStack->add_session('my_questions','<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>','success');

					exit('success');

				}else{
					exit('error');
				}
			case 'submit_leftqa':
				if($_POST){
					//$question_type = $_POST['type'];

					$question_title = zen_db_input($_POST['subject']);
					$question_content = zen_db_input($_POST['question']);

					$question = array(
						'customers_id' => $_SESSION['customer_id'],
						'question_title' => $question_title,
						'question_content' => $question_content,
						'add_time' => 'now()'
					);


					if($_SESSION['customer_id']){
						zen_db_perform('customers_broker', $question);
						$admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
						$customer_email = zen_get_customer_name_email($_SESSION['customer_id']);
						$customers_country_id = $_SESSION['customer_country_id'];
                        if(!$admin_id){
                            $email_address = $customer_email;
                            $allot_type='customer_broke';
                            require(DIR_WS_MODULES . zen_get_module_directory('auto_given.php'));
                            $is_go_auto_given = 1;
                            // fairy 2018.8.30 add 如果该项分配当前销售。则也要把该用户分配给当前销售
                            if ($admin_id && $_SESSION['customer_id']) {
                                auto_given_customers_to_admin(array(
                                    'admin_id' => $admin_id,
                                    'email_address' => $email_address,
                                    'admin_id_from_table' => $admin_id_from_table,
                                    'customers_id' => $_SESSION['customer_id'], // 注册用户
									'is_make_up' => $is_make_up ? : 0,
									'from_auto_file' => 'auto_given',
                                    'is_old' => $is_old ? $is_old : 0,    // 标注新、老客户
									'customer_number' => $customers_customers_number_new,
									'customer_offline_number' => $offline_customers_number_new,
									'invalidSign' => $invalidSign,
                                ));
                            }
                        }
						$customer_name = zen_get_customers_firstname($_SESSION['customer_id']);
					}

					if($admin_id){

						/*				$sql_data_array = array(
                                                        'admin_id' => $admin_id,
                                                        'customers_id' => $cid
                                                        );
                                         zen_db_perform('live_chat_assign_for_phone', $sql_data_array);*/
						$admin_name = zen_get_admin_name_of_id($admin_id);
						$admin_email = zen_get_admin_email_of_name($admin_name);
						/* emial content */
						$html_msg = array();  //the email content
						define('EMAIL_SUBJECT', 'FS.COM - Question Feedback Update');
						$html=zen_get_corresponding_languages_email_common('admin');
						$html_msg['FS_EMAIL_MY_ACCOUNT_TITLE'] =  FS_EMAIL_MY_ACCOUNT_TITLE;
						$html_msg['FS_EMAIL_MY_ACCOUNT_YOUR'] =	FS_EMAIL_MY_ACCOUNT_YOUR;
						$html_msg['FS_EMAIL_MY_ACCOUNT_FOR'] =	FS_EMAIL_MY_ACCOUNT_FOR;
						$html_msg['FS_EMAIL_MY_ACCOUNT_TIT'] =	FS_EMAIL_MY_ACCOUNT_TIT;
						$html_msg['FS_EMAIL_MY_ACCOUNT_CON'] =	FS_EMAIL_MY_ACCOUNT_CON;
						$html_msg['FS_EMAIL_MY_ACCOUNT_IF'] =	FS_EMAIL_MY_ACCOUNT_IF;
						$html_msg['FS_EMAIL_MY_ACCOUNT_PHONE'] = FS_EMAIL_MY_ACCOUNT_PHONE;
						$html_msg['FS_EMAIL_MY_ACCOUNT_OR'] =	FS_EMAIL_MY_ACCOUNT_OR;
						$html_msg['FS_EMAIL_MY_ACCOUNT_TEL'] =	FS_EMAIL_MY_ACCOUNT_TEL;
						$html_msg['FS_EMAIL_MY_ACCOUNT_PHONES'] = FS_EMAIL_MY_ACCOUNT_PHONES;
						$html_msg['FS_EMAIL_MY_ACCOUNT_MAY'] =	FS_EMAIL_MY_ACCOUNT_MAY;
						$html_msg['FS_EMAIL_MY_ACCOUNT_URL'] =	FS_EMAIL_MY_ACCOUNT_URL;
						$html_msg['FS_EMAIL_MY_ACCOUNT_LIVE'] =	FS_EMAIL_MY_ACCOUNT_LIVE;
						$html_msg['FS_EMAIL_MY_ACCOUNT_GET'] =	FS_EMAIL_MY_ACCOUNT_GET;
						$html_msg['FS_EMAIL_TO_US_DEAR'] =	FS_EMAIL_TO_US_DEAR;
						$html_msg['FS_EMAIL_SIN'] =	 FS_EMAIL_SIN;
						$html_msg['FS_EMAIL_FS'] =	FS_EAIL_FS;
						$html_msg['FS_EMAIL_TEAM'] =  FS_EMAIL_TEAM;
						$html_msg['EMAIL_HEADER'] = $html['html_header'];
						$html_msg['EMAIL_FOOTER'] = $html['html_footer'];
						$html_msg['CUSTOMER_NAME'] = $customer_name;
						$html_msg['CUSTOMER_EMAIL'] = $customer_email;
						$html_msg['QUWSTTION_TITLE'] = $question_title;
						$html_msg['QUESTION_CONTENT'] = $question_content;
						$text_message = 'New customer question ,please view';
						zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $admin_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg,'customer_question_to_us');
						zen_mail_contact_us_or_bulk_order_inquiry($admin_name, $customer_email, EMAIL_SUBJECT, $text_message, $customer_name, $customer_email, $html_msg,'customer_question_to_us');
						/* end of */
					}

					$messageStack->add_session('my_questions','<div id="system_alert" class="contact_cgts_01">Your questions are submitted successfully</div>','success');
					exit('success');

				}else{
					exit('error');
				}

				break;

			case 'showsaleproductsoption':
				$content ='';
				if($_POST['pid']){
					$NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($_POST['pid']);
					require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_ATTRIBUTES));
					$name_description = FS_products_name_description($_POST['pid']);
					$image_src= file_exists(DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid'])) ? DIR_WS_IMAGES.zen_get_products_image_of_products_id($_POST['pid']): DIR_WS_IMAGES.'no_picture.gif';
					$image = zen_image($image_src,zen_get_products_image_of_products_id($_POST['pid']),200,200,'title="'.zen_get_products_image_of_products_id($_POST['pid']).'"');
					$wholesale_products = fs_get_wholesale_products_array();
					$language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
					if($_SESSION['languages_id'] !=1){
						$code = '/'.$language_code;
					}else{
						$code ='';
					}
					//每个产品对应的标题和描述
					$title_related = array(
						'36157' => array('title'=>TITLE_RELARED_01,'description'=>TITLE_RELARED_DES),
						'48354' => array('title'=>TITLE_RELARED_02,'description'=>TITLE_RELARED_DES),
						'36170' => array('title'=>TITLE_RELARED_03,'description'=>TITLE_RELARED_DES),
						'48355' => array('title'=>TITLE_RELARED_04,'description'=>TITLE_RELARED_DES)
					);

					//每个产品对应的关联品牌产品数据
					$products_related = array(
						'36157' => array('Generic'=>17931,'Cisco'=>36157,'Arista Networks'=>36189,'Juniper Networks'=>36439,'Brocade'=>36182,'HPE'=>36421,'H3C'=>36848,'Dell'=>36691,'Huawei'=>39578),
						'48354' => array('Generic'=>35182,'Cisco'=>48354,'Arista Networks'=>48852,'Brocade'=>48854,'Dell'=>48856,'Juniper Networks'=>48862,'Extreme Networks'=>48858,'Huawei'=>48860,'Ciena'=>51677) ,
						'36170' => array('Generic'=>24422,'Cisco'=>36170,'Arista Networks'=>36202,'Juniper Networks'=>36114,'Brocade'=>36185,'HPE'=>36427,'H3C'=>36858,'Dell'=>36696,'Huawei'=>39623),
						'48355' => array('Generic'=>39025,'Cisco'=>48355,'Arista Networks'=>48853,'Brocade'=>48855,'Dell'=>48857,'Juniper Networks'=>48863,'Extreme Networks'=>48859,'Huawei'=>48861,'Ciena'=>50238)
					);
					$related_key = array_keys($products_related);
					if(in_array((int)$_POST['pid'],$related_key)){
						$related = $products_related[$_POST['pid']];
						$title = $title_related[$_POST['pid']];
					}

					$content .= '<div class="product_matrix_pic">
			             <a target="_blank" href="javascript:;" class="thumbnail">'.$image.'</a>
			             <span class="product_sku">#<span>'.(int)$_POST['pid'].'</span></span>
				         </div>
				         <div class="product_matrix_info">
				         <div class="product_m_info_tit"><a href="javascript:;">'.$title['title'].'</a>
				         <span>'.$title['description'].'</span>
				         </div>';

					if($related){
						$content .= '<div class="product_03_09 product_03_12"><span class="product_03_02 product_03_15"><label for="attrib-115" class="attribsSelect">'.TITLE_RELARED_05.'</label>'.($_SESSION['languages_code'] == 'fr') ? ' ' : ''.': </span><div class="ccc"></div><div class="product_list_quick">';
						foreach($related as $brand=>$pid){
							if($pid==$_POST['pid']){
								$content .= '<div class="pro_item  item_selected" onclick="changeproducts('.$pid.',this)"><a href="javascript:void(0)" ><b>'.$brand.'</b><i></i></a></div>';
							}else{
								$content .= '<div class="pro_item" onclick="changeproducts('.$pid.',this)"><a href="javascript:void(0)" ><b>'.$brand.'</b><i></i></a></div>';
							}
						}
						$content .='</div><div class="ccc"></div></div>';
					}


//add by Henly

					if(!in_array($_POST['pid'],$wholesale_products)){
						$final_price = $currencies->new_display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}else{
						$final_price = $currencies->display_price(zen_get_products_base_price((int)$_POST['pid']),0);
					}


					$content .= '<div class="product_matrix_form">
				          <span class="price aaa">'.$final_price.'</span>
				          <span class="product_matrix_btn bbb"><span class="aaa"> '.TABLE_ATTRIBUTES_QTY_PRICE_QTY.':</span>
				          <input type="text" id="cart_quantity" name="cart_quantity" maxlength = "5"  min="1" value="1" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^\d]/g,\'\')" onblur="q_check_min_qty(this,'.$_POST['pid'].')" onfocus="q_enterKey(this,'.$_POST['pid'].')" autocomplete="off" class="p_07 product_sticky_qty"> <div class="pro_mun">
			<a href="javascript:void(q_cart_quantity_change(1,'.$_POST['pid'].'));" class="cart_qty_add"></a>
			<a href="javascript:void(q_cart_quantity_change(0,'.$_POST['pid'].'));" class="cart_qty_reduce cart_reduce"></a>           
		 </div>
<a href="'.zen_href_link('shopping_cart').'" class="btn go-to-cart-page" id="go_to_cart"> '.FS_CART.' <i class=""></i> </a>';
					$content .= '<input type="hidden" id="type_id" value="'.(int)$_POST['pid'].'"><input type="submit" id="Laddbtn" onclick="AddToCart()" value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10">';
					$content .= '<a id="href" style="display:none" href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$_POST['pid']).'">
					<input type="submit" id="buttom" value="'.PRODUCT_INFO_ADD.'" name="Add to Cart" class="button_02 button_10"></a>';
				      $content .= '</span></div></div>';
					$content .='<script type="text/javascript">
					thisUrl = this.location.href;
					if(thisUrl.indexOf("-2866") > 0 || thisUrl.indexOf("-1125") > 0){
						$("input[type=submit]").hide();
						$("#href").show();
						$("#buttom").show();
					}else{
						$("input[type=submit]").show();
						$("#href").hide();
						$("#buttom").hide();
					}</script>';
				}

				echo $content;
				exit;
			break;

			case 'actionAddSaleProduct':
				$qty = (int)$_POST['cart_quantity'];
				$sql='select is_min_order_qty as min_qty from products where products_id = '.(int)$_POST['products_id'];
				$result = $db->Execute($sql);
				$min_qty=$result->fields['min_qty'];
				if((int)$qty<(int)$min_qty){	//查询最小数量
					$qty = $min_qty;
				}
				$type = array();
				if(isset($_POST['products_id']) && $qty > 0){
					$attributes = '';
					$products_id = $_POST['products_id'];

					$now_qty=0;
					if ($_SESSION['cart']->in_cart($products_id)) {
						$now_qty = $_SESSION['cart']->contents[$products_id]['qty'];
						$totalQTY = $now_qty + $qty;
						$_SESSION['cart']->contents[$products_id] = array('qty' => (float)$totalQTY);
						if (isset($_SESSION['customer_id'])) {
							$sql = "update " . TABLE_CUSTOMERS_BASKET . "
									set customers_basket_quantity = customers_basket_quantity + '" . (float)$qty . "'
									where customers_id = '" . (int)$_SESSION['customer_id'] . "'
									and products_id = '" . zen_db_input($products_id) . "'";
							$db->Execute($sql);
						}

					}else{
						//$_SESSION['cart']->contents[] = array($products_id);
						$_SESSION['cart']->contents[$products_id] = array('qty' => (float)$qty);
						if (isset($_SESSION['customer_id'])) {
							$sql = "insert into " . TABLE_CUSTOMERS_BASKET . "
			                              (customers_id, products_id, customers_basket_quantity,
			                              customers_basket_date_added)
			                              values ('" . (int)$_SESSION['customer_id'] . "', '" . zen_db_input($products_id) . "', '" .
								$qty . "', '" . date('Ymd') . "')";
							$db->Execute($sql);
						}
					}
					$_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
				}


				$cart_count = $_SESSION['cart']->count_contents();
				if($cart_count==1){  $item = F_BODY_HEADER_ITEM;}
				if($cart_count>=2 && $cart_count<=4 ){ $item= F_BODY_HEADER_ITEM_TWO; }
				if($cart_count==0 || $cart_count>=5){ $item = F_BODY_HEADER_ITEMS; }


				//刷新头部购物车信息
				//外部图标部分
				$cart_products_list_html .='<a class="header_cart_href" href="'.zen_href_link(FILENAME_SHOPPING_CART,'','SSL').'"><span></span>'.FS_CART;
				$cart_products_list_html .='<em>'.$_SESSION['cart']->count_contents().'</em></a>';

				//弹框内容部分
				$cart_products_list_html .='<div class="header_cart_more">';
				$cart_products_list_html .='<div class="header_cart_more_arrow"></div>';
				//$cart_products_list_html .='<script type="text/javascript" src="/includes/templates/fiberstore/jscript/addproducts_to_cart.js"></script>';
				$cart_products_list_html .= '<dd id="shopping_cart">';

				if($_SESSION['cart']->count_contents()){
					$cart_products = $_SESSION['cart']->get_products() ;
					$num =0;
					$total_price = 0;$more_cart=false;
					$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
					$wholesale_products = fs_get_wholesale_products_array();
					foreach ($cart_products as $i => $product){
						$num++;

						
							$total_price += round($product['final_price']*$currencies_value,2)*$product['quantity'];
							if(!in_array($product['id'],$wholesale_products)){
								$productsPriceEach =  $currencies->new_display_price($product['final_price'], zen_get_tax_rate($product['tax_class_id']), 1) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->new_display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
							}else{
								$productsPriceEach =  $currencies->display_price($product['final_price'], zen_get_tax_rate($product['tax_class_id']), 1) . ($product['onetime_charges'] != 0 ? '<br />' . $currencies->new_display_price($product['onetime_charges'], zen_get_tax_rate($product['tax_class_id']), 1) : '');
							}
					

						$link = zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.(int)$product['id']);
						//$name = substr($product['name'],0,40)."...";
						$name =  $product['name'];
						$image_src = DIR_WS_IMAGES.(file_exists(DIR_WS_IMAGES.$product['image']) ? $product['image'] : 'no_picture.gif');
						$image = zen_image($image_src,$name,100,100,' border="0" title="'.$name.'"');
						if(!in_array($product['id'],$wholesale_products)){
							$price = $currencies->new_display_price($product['price'], 0);
						}else{
							$price = $currencies->display_price($product['price'], 0);
						}
						$cart_price = $product['products_price'];
						$quantity = $product['quantity'];

						if($num > 4){
							$cart_products_list_html .='';
							$more_cart = true;
						}else{
							$cart_products_list_html .= '<li id='.(int)$product['id'].'>';
							$cart_products_list_html .='<a class="cart_image" href="'.$link.'">'.$image.' </a><p class="cart_name_pre"><a title="' . $name . '" class="cart_name" href="'.$link.'">'.$name.'</a>';
							$cart_products_list_html .='<b>'.$productsPriceEach.'*'.$quantity.'</b></p>';
							$cart_products_list_html .='<a class="cart_remove" href="javascript:remove_shopping_cart(\''.$product['id'].'\','.$quantity.','.$cart_price.');">'.FIBERSTORE_REMOVE.'</a>';
							$cart_products_list_html .='</li>';
						}
					}
					if ($more_cart) {
						$cart_products_list_html .= '<a class="cart_more_21" href="'.zen_href_link(FILENAME_SHOPPING_CART).'"><b>'.FIBERSTORE_VIEW_MORE.'</b></a>';
					}
					unset($_SESSION['paypal_ec_temp']);
					unset($_SESSION['paypal_ec_token']);
					unset($_SESSION['paypal_ec_payer_id']);
					unset($_SESSION['paypal_ec_payer_info']);

					$cart_items = $_SESSION['cart']->count_contents();

					if($cart_items==1){  $items =  F_BODY_HEADER_ITEM;}
					if($cart_items>=2 && $cart_items<=4 ){ $items =  F_BODY_HEADER_ITEM_TWO; }
					if($cart_items==0 || $cart_items>=5){ $items =  F_BODY_HEADER_ITEMS; }
					$cart_products_list_html .= '<div>'.$cart_items.' '.$items.'  <b id="total_price">'.$currencies->display_price($total_price/$currencies_value,0).'</b>  --  <a class="top_edit_order" href="'.zen_href_link(FILENAME_SHOPPING_CART).'">'.FIBERSTORE_EDITE_ORDER.'</a> <br>
					<a class="button_04" href="'.zen_href_link('paypal_express.php', 'type=ec', 'SSL', true, true, true).'">Buy with &nbsp;<img src="'.HTTPS_IMAGE_SERVER.'images/shopping_ec_paypal.png" alt="FiberStore shopping_ec_paypal.png" title="Paypal"></a>
					<a class="button_02" href="'.zen_href_link(FILENAME_CHECKOUT,'','SSL').'">'.FIBERSTORE_CHECK_YOU_ORDER.'<i class="security_icon"></i></a>
			        </div>';
				}else{
					$cart_products_list_html .= '<b class="no_add_cart">'.FIBERSTORE_SHOPPING_HELP.'</b>';
				}
				$cart_products_list_html .='</dd>';
				$cart_products_list_html .='</div>';

				echo $cart_products_list_html;
				exit;
			break;
			case 'actionAddBrand':
				if(!empty($_POST['id'])){
					$product_price = zen_get_products_price($_POST['id']);
					$instock=get_instock_info($_POST['id']);
					$html='<p class="sale_con_main_price"> '.$currencies->display_price($product_price,0).'</p>&nbsp;'.$instock.'';
					echo $html;
				}
				exit;
				break;

			case 'share_email':
				$from_email = zen_db_prepare_input($_POST['from_email']);
				$from_name = zen_db_prepare_input($_POST['from_name']);
				$to_name = zen_db_prepare_input($_POST['to_name']);
				$to_email = zen_db_prepare_input($_POST['to_email']);
				$message = zen_db_prepare_input($_POST['message']);
				$is_active = zen_db_prepare_input($_POST['is_active']);   // string类型  下边代码用到了 "true"
				$products_id = (int)zen_db_prepare_input($_POST['products_id']);
                $to_name_arr = explode(',',$to_name);
                $to_email_arr = explode(',',$to_email);
				$products_name = fs_get_data_from_db_fields('products_name',TABLE_PRODUCTS_DESCRIPTION,'products_id='.$products_id.' and language_id='.$_SESSION['languages_id'],'');
				$Info = fs_get_data_from_db_fields_array(array($fsCurrentInquiryField.' as is_inquiry','products_price','integer_state'),'products','products_id="'.$products_id.'"','limit 1');
				$is_inquiry = $Info[0][0];
				$products_price = $Info[0][1];
				$integer_state = $Info[0][2];
				$country_code = $_SESSION['countries_iso_code'];
				$product_price = zen_get_new_products_final_price((int)$products_id,$products_price,$integer_state,$country_code);
				$product_price = $currencies->total_format($product_price);

				//澳大利亚展示税后价
				if(strtolower($country_code) == 'au'){
					$product_price .= ' (Incl. GST)';
				}

                $productImageSrc = fs_get_data_from_db_fields('products_image','products','products_id="'.$products_id.'"','');
//                $img_src =  DIR_WS_IMAGES. (file_exists(DIR_WS_IMAGES.$productImageSrc) ? $productImageSrc : 'no_picture.gif');
//                $image_stock = zen_image($img_src,'',100,100,' border="0" ');
                $image_stock = get_resources_img($products_id,'60','60',$productImageSrc);
                $html_msg = array();
                get_email_langpac();
                $html=common_email_header_and_footer(FS_SEND_EMAIL_123,FS_SEND_EMAIL_152);
                $html_msg['EMAIL_HEADER'] = $html['header'];
                $html_msg['EMAIL_FOOTER'] = $html['footer'];
				$email_body = '';
				$email_body_two = '';
				$email_body_three = '';
                $html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>';
                if($_SESSION['languages_code']=="jp"){
                    $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            この電子メールは<a href="'.zen_href_link('index').'" style="color: #232323;text-decoration: none">FS.COM</a>の「友達とシェア」サービスを使って'.ucwords($from_name).'によって送られました。
                             </td>';
				} elseif ($_SESSION['languages_code'] == "de") {
					$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.'Ihr(e)  Freund*in '.ucwords($from_name).' hat Ihnen dieses Produkt von '.'<a href="'.zen_href_link('index').'" style="color: #232323;text-decoration: none">FS</a> geteilt
                             </td>';
				} else {
                    $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.FS_SEND_EMAIL_153.ucwords($from_name).FS_SEND_EMAIL_155.'<a href="'.zen_href_link('index').'" style="color: #232323;text-decoration: none">FS</a>
                             </td>';
                }

                    $html_msg['EMAIL_BODY'].= '</tr></tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px" align="left">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td width="60" valign="middle" style="border-collapse: collapse">
                                        <a href="'.zen_href_link('product_info','products_id='.$products_id,'SSL').'" style="text-decoration: none">
                                            '.$image_stock.'
                                        </a>
                                    </td>
                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding-left:20px;" valign="middle" align="left">
                                        <a href="'.zen_href_link('product_info','products_id='.$products_id,'SSL').'" style="text-decoration: none;color: #232323">
                                            '.$products_name.'
                                            <span style= "color: #999">#'.$products_id.'</span>
                                        </a>';
                                    if($is_inquiry!=1){
                                        $html_msg['EMAIL_BODY'].='<br>
                                                            <span style="display: inline-block;padding-top: 8px">'.$product_price.'</span>';
                                    }
            $html_msg['EMAIL_BODY'].='</td>
                                    <td width="180" align="right" valign="middle" style="border-collapse: collapse">
                                        <a href="'.zen_href_link('product_info','products_id='.$products_id,'SSL').'" style="font-size: 14px;display: inline-block;text-decoration: none;color: #0070BC;padding: 10px 12px;border: 1px solid #0070BC;border-radius:2px;">'.FS_SEND_EMAIL_125.'</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="60">

                        </td>
                    </tr>
                    </tbody>
                </table>';
                if($message){
                    $html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>';
                    if($_SESSION['languages_code']=="jp"){
                        $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-weight: 600;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                            '.ucwords($from_name).' '.FS_SEND_EMAIL_158.'：
                                        </td>';
                    }else{
                        $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-weight: 600;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                            '.FS_SEND_EMAIL_158.' '.ucwords($from_name).' :
                                        </td>';
                    }

                    $html_msg['EMAIL_BODY'].='</tr>
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
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;" align="left">
                                                        '.$message.'
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table><table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
                }

                $html_msg['EMAIL_BODY'].='
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>';
                if($_SESSION['languages_code']=='de'){
                    $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_115.'<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>'.FS_SEND_EMAIL_116.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a> gesandt.
                            '.FS_SEND_EMAIL_118.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS</a>
                            '.FS_SEND_EMAIL_119.'<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">'.FS_SEND_EMAIL_120.'</a> für mehr Informationen über unsere Datenschutzerklärung. 
                        </td>';
                }elseif ($_SESSION['languages_code']=='es'){
					$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_115.'<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>'.FS_SEND_EMAIL_116.FS_SEND_EMAIL_118.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS</a>
                            '.FS_SEND_EMAIL_119.'<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">'.FS_SEND_EMAIL_120.'</a>.
                        </td>';
				}else{
                    if($_SESSION['languages_code']=="jp"){
                        $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            この電子メールは<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>の「友達とシェア」サービスを使って<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>によって送られました。
                             このメッセージを受信しても、<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>からの迷惑メッセージは受信されません。詳細では当社の<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">プライバシーポリシー</a>をご覧下さい。
                        </td>';
                    }else{
                        $item_info=".";
                        if($_SESSION['languages_code']=="fr"){
                            $item_info =",";
                        }
                        $html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_115.'<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>'.FS_SEND_EMAIL_116.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>.
                            '.FS_SEND_EMAIL_118.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>'.$item_info.'
                            '.FS_SEND_EMAIL_119.'<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">'.FS_SEND_EMAIL_120.'</a>.
                        </td>';
                    }
                }
                $html_msg['EMAIL_BODY'].='</tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>';
                $subject_title = FS_SEND_EMAIL_121.ucwords($from_name).FS_SEND_EMAIL_129;
                if(sizeof($to_name_arr)==1 && sizeof($to_email_arr)==1){
                    if($from_email == $to_email){
                        sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                    }else{
                        if($is_active == 'true'){
                            sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                            sendwebmail($to_name,$to_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                        }else{
                            sendwebmail($to_name,$to_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                        }
                    }
				}else{
                    if($is_active == 'true'){
						for($i=0;$i<sizeof($to_name_arr);$i++){
                            sendwebmail($to_name_arr[$i],$to_email_arr[$i],'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
						}
                        sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                    }else{
                        for($i=0;$i<sizeof($to_name_arr);$i++){
                            sendwebmail($to_name_arr[$i],$to_email_arr[$i],'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
                        }
					}
				}
				echo json_encode(array('status'=>'success'));
				break;
				//分享case studies文章邮件
			case 'share_case_studies_email':
				$from_email = zen_db_prepare_input($_POST['from_email']);
				$from_name = zen_db_prepare_input($_POST['from_name']);
				$to_name = zen_db_prepare_input($_POST['to_name']);
				$to_email = zen_db_prepare_input($_POST['to_email']);
				$message = zen_db_prepare_input($_POST['message']);
				$is_active = $_POST['is_active'];
				$a_id = zen_db_prepare_input($_POST['a_id']);
				$to_name_arr = explode(',',$to_name);
				$to_email_arr = explode(',',$to_email);
				$doc_article_title = fs_get_data_from_db_fields('doc_article_title',TABLE_DOC_ARTICLE_DESCRIPTION,'doc_article_id="'.$a_id.'"','');
				$doc_article_des = fs_get_data_from_db_fields('doc_article_des',TABLE_DOC_ARTICLE_DESCRIPTION,'doc_article_id="'.$a_id.'"','');
				$productImageSrc = fs_get_data_from_db_fields('doc_article_image',TABLE_DOC_ARTICLE,'doc_article_id="'.$a_id.'"','');
				$image_stock = zen_get_img_change_src('images/'.$productImageSrc);
//                $img_src =  DIR_WS_IMAGES. (file_exists(DIR_WS_IMAGES.$productImageSrc) ? $productImageSrc : 'no_picture.gif');
//                $image_stock = zen_image($img_src,'',100,100,' border="0" ');
				$html_msg = array();
				get_email_langpac();
				$html=common_email_header_and_footer(FS_SEND_EMAIL_123,FS_SEND_EMAIL_152);
				$html_msg['EMAIL_HEADER'] = $html['header'];
				$html_msg['EMAIL_FOOTER'] = $html['footer'];
				$email_body = '';
				$email_body_two = '';
				$email_body_three = '';
				$html_msg['EMAIL_BODY'] = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>';
				if($_SESSION['languages_code']=="jp"){
					$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            この電子メールは<a href="'.zen_href_link('index').'" style="color: #232323;text-decoration: none">FS.COM</a>の「友達とシェア」サービスを使って'.ucwords($from_name).'によって送られました。
                             </td>';
				}else{
					$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 18px;color: #232323;line-height: 24px;font-weight: 600;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            '.FS_SEND_EMAIL_153.ucwords($from_name).FS_SEND_EMAIL_155.'<a href="'.zen_href_link('index').'" style="color: #232323;text-decoration: none">FS</a>
                             </td>';
				}

				$html_msg['EMAIL_BODY'].= '</tr></tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse;padding: 0 20px" align="left">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td width="60" valign="middle" style="border-collapse: collapse">
                                        <a href="'.zen_href_link('tutorial_detail','&a_id='.$a_id,'SSL').'" style="text-decoration: none">
                                            <img src="'.$image_stock.'" title="" width="60" height="60">
                                        </a>
                                    </td>
                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding-left:20px;" valign="middle" align="left">
                                        <a href="'.zen_href_link('tutorial_detail','&a_id='.$a_id,'SSL').'" style="text-decoration: none;color: #232323">
                                            '.$doc_article_title.'
                                        </a>';
					$html_msg['EMAIL_BODY'].='<br>
                                                            <span style="display: inline-block;padding-top: 8px;color: #999">'.stripcslashes($doc_article_des).'</span>';
				$html_msg['EMAIL_BODY'].='</td>
                                    <td width="180" align="right" valign="middle" style="border-collapse: collapse">
                                        <a href="'.zen_href_link('tutorial_detail','&a_id='.$a_id,'SSL').'" style="font-size: 14px;display: inline-block;text-decoration: none;color: #0070BC;padding: 10px 12px;border: 1px solid #0070BC;border-radius:2px;">'.FS_SEND_EMAIL_125.'</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="60">

                        </td>
                    </tr>
                    </tbody>
                </table>';
				if($message){
					$html_msg['EMAIL_BODY'].='<table width="640" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>';
					if($_SESSION['languages_code']=="jp"){
						$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-weight: 600;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                            '.ucwords($from_name).' '.FS_SEND_EMAIL_158.'：
                                        </td>';
					}else{
						$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-weight: 600;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                                            '.FS_SEND_EMAIL_158.' '.ucwords($from_name).' :
                                        </td>';
					}

					$html_msg['EMAIL_BODY'].='</tr>
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
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <td style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;" align="left">
                                                        '.$message.'
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table><table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
				}

				$html_msg['EMAIL_BODY'].='
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>';
				if($_SESSION['languages_code']=='de'){
					$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_115.'<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>'.FS_SEND_EMAIL_116.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a> gesandt.
                            '.FS_SEND_EMAIL_118.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS</a>
                            '.FS_SEND_EMAIL_119.'<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">'.FS_SEND_EMAIL_120.'</a> für mehr Informationen über unsere Datenschutzerklärung.
                        </td>';
				}else{
					if($_SESSION['languages_code']=="jp"){
						$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            この電子メールは<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>の「友達とシェア」サービスを使って<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>によって送られました。
                             このメッセージを受信しても、<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>からの迷惑メッセージは受信されません。詳細では当社の<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">プライバシーポリシー</a>をご覧下さい。
                        </td>';
					}else{
						$item_info=".";
						if($_SESSION['languages_code']=="fr"){
							$item_info =",";
						}
						$html_msg['EMAIL_BODY'].='<td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            '.FS_SEND_EMAIL_115.'<a style="color: #232323;text-decoration: none;" href="javascript:;">'.$from_email.'</a>'.FS_SEND_EMAIL_116.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>.
                            '.FS_SEND_EMAIL_118.'<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>'.$item_info.'
                            '.FS_SEND_EMAIL_119.'<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">'.FS_SEND_EMAIL_120.'</a>.
                        </td>';
					}
				}
				$html_msg['EMAIL_BODY'].='</tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#ffffff" style="border-collapse: collapse" height="30">

                        </td>
                    </tr>
                    </tbody>
                </table>';
				$subject_title = FS_SEND_EMAIL_121.ucwords($from_name).FS_SEND_EMAIL_129;
				if(sizeof($to_name_arr)==1 && sizeof($to_email_arr)==1){
					if($from_email == $to_email){
						sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
					}else{
						if($is_active == 'true'){
							sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
							sendwebmail($to_name,$to_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
						}else{
							sendwebmail($to_name,$to_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
						}
					}
				}else{
					if($is_active == 'true'){
						for($i=0;$i<sizeof($to_name_arr);$i++){
							sendwebmail($to_name_arr[$i],$to_email_arr[$i],'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
						}
						sendwebmail($from_name,$from_email,'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
					}else{
						for($i=0;$i<sizeof($to_name_arr);$i++){
							sendwebmail($to_name_arr[$i],$to_email_arr[$i],'分享产品群发邮件:'.date('Y-m-d h:i:s',time()),STORE_NAME,$subject_title,$html_msg,'default');
						}
					}
				}
				exit('ok');
				break;
			case 'packing_conditions':
                require_once(DIR_FS_CATALOG.'includes/classes/shipping_info.php');
				$product_id = $_POST['products_id'];
				$qty = $_POST['qty'];
				if($product_id){
					$packing_conditions = get_product_packing_conditions($product_id);
					$discount_price=0;
					$currency = $_SESSION['currency'];
					$currency_symbol_left =  $currencies->currencies[$_SESSION['currency']]['symbol_left'];
					$currency_symbol_right =  $currencies->currencies[$_SESSION['currency']]['symbol_right'];
					$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
					$currencies_value = zen_get_currencies_value_of_code($_SESSION['currency']);
					if(get_price_vat_uk_show()){
                        $Excl_tax =' (Excl. VAT)';
                        $Excl_tax_two = '(Incl. VAT)';
						$productsPrice = zen_get_products_base_price((int)$product_id);
						$taxPrice = $productsPrice*1.20;
						if($wholesale_products && !in_array($product_id,$wholesale_products)){
							$pure_price =	 get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id));
							$products_price = $currencies->new_display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id)),0);
//							$taxPriceText = $currencies->new_display_price($taxPrice,0);
						}else{
							$pure_price =	 get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id));
							$products_price =  $currencies->new_display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id)),0);
//							$taxPriceText = number_format($currencies->new_display_price($taxPrice,0));
						}
						$products_price = str_replace($currency_symbol_left,'',$products_price);
						$products_price = str_replace($currency_symbol_right,'',$products_price);
						$taxPriceText = sprintf('%.2f',$products_price*1.20);
					}elseif($_SESSION['languages_code']=="au"){
						$productsPrice = zen_get_products_base_price((int)$product_id);
						if(!$Is_NewLand){
							$Excl_tax =' (Excl. GST)';
						}else{
							$Excl_tax = '';
						}

						if(!in_array($product_id,$wholesale_products)){
							$pure_price =	 get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id));
							$products_price = $currencies->new_display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id)),0);
							$taxPriceText = $currencies->new_display_price_tax($productsPrice,10);
						}else{
							$pure_price =	 get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id));
							$products_price = $currencies->display_price(get_customers_products_level_final_price(zen_get_products_base_price((int)$product_id)),0);
							$taxPriceText = $currencies->display_price_tax($productsPrice,10);
						}
						$products_price = str_replace($currency_symbol_left,'',$products_price);
						$products_price = str_replace($currency_symbol_right,'',$products_price);
						$taxPriceText = str_replace($currency_symbol_left,'',$taxPriceText);
						$taxPriceText = str_replace($currency_symbol_right,'',$taxPriceText);

					}elseif(in_array($_SESSION['languages_code'],['de','dn'])){

                        $product_price = zen_get_products_final_price((int)$product_id);
                        $products_price = $currencies->total_format($product_price);

                        //de站和de-en站的价格展示
                        if(german_warehouse("country_code",$_SESSION['countries_iso_code'])){
                            //欧盟国家才展示是否含税信息
							$times = getVaxByCountry($_SESSION['countries_iso_code']);
                            $taxPriceText = $currencies->total_format($product_price*$times);
                            //德国仓展示税收
                            $priceHtml = '<br/><i class="price_bef_tax">'.$taxPriceText. FS_PRICE_INCL_VAT . '</i>';

                        }
                    }else{
                        $products_price= $packing_conditions['products_price'] * $currencies_value;
                        $pure_price = $packing_conditions['products_price'];
                        if (!in_array((int)$product_id, $wholesale_products)) {
                            $products_price = get_products_all_currency_final_price($products_price);
                        } else {
                            $products_price = get_products_specail_currency_final_price($products_price);
                        }

                    }
                    $discount="";
                    $old_price_was="";

                    if($qty>=$packing_conditions['packing_quantity'] && $_SESSION['member_level']<=1) {
                        if($_POST['type']==2){
                            $qty=1;
                        }
                        $old_price =sprintf('%.2f',$products_price)*$qty;
                        if($_SESSION['languages_code']=='en' && $packing_conditions['discount']!=1){
                            $old_price_was=	'<strong id="old_price_was"><i class="old_price_was">'.FS_COMMON_LEVEL_WAS_1.' </i><strong class="old_price_z">'.$currency_symbol_left.sprintf('%.2f',$old_price).$currency_symbol_right.'<span class="old_price_line"></span></strong></strong>';
                        }
                        if(in_array($_SESSION['languages_code'],['de','dn']) && $currency!="NOK"){
                            $products_price = str_replace('.','',$products_price);
                            $products_price = str_replace(',','.',$products_price);
                            $taxPriceText = str_replace('.','',$taxPriceText);
                            $taxPriceText = str_replace(',','.',$taxPriceText);
                            $products_price = sprintf('%.2f', $products_price * $packing_conditions['discount'])*$qty;
                        }else{
                            $products_price = sprintf('%.2f', $products_price * $packing_conditions['discount'])*$qty;
                        }

                        if($packing_conditions['discount']!=1){
                            $discount = 'Save  '.$currency_symbol_left.sprintf('%.2f',($old_price-$products_price)).$currency_symbol_right;
                        }


                        if(in_array($_SESSION['languages_code'],['uk','au','de','dn'])){
                            $taxPriceText = sprintf('%.2f', $taxPriceText * $packing_conditions['discount'])* $qty;
                            if(in_array($_SESSION['languages_code'],['de','dn'])  && $currency!="NOK"){
                                $taxPriceText = $currency_symbol_left.number_format(zen_round($taxPriceText, 2), 2, ',', '').$currency_symbol_right;
                                $products_price = $currency_symbol_left.number_format(zen_round($products_price, 2), 2, ',', '').$currency_symbol_right;
                            }
                        }else{
                            $taxPriceText=0;
                        }
                    }
                    if($_SESSION['languages_code']=='jp'){
                        $discount_price = $currency_symbol_left . number_format($products_price) .$currency_symbol_right;
                    }else{
                        if($_SESSION['languages_code']=='au'){
                            if(!$Is_NewLand){
                                $discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right.$Excl_tax.'<br/><li class="price_bef_tax">'.$currency_symbol_left . sprintf('%.2f',$taxPriceText) .$currency_symbol_right.' (Incl. GST)</li></span><div class="ccc"></div>';
                            }else{
                                $discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right;
                            }
                        }elseif($_SESSION['languages_code']=='uk'){
                            if(german_warehouse("country_code",$_SESSION['countries_iso_code'])){
                                $discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right.$Excl_tax.'<br/><li class="price_bef_tax">'.$currency_symbol_left . sprintf('%.2f',$taxPriceText) .$currency_symbol_right.' (Incl. VAT)</li></span><div class="ccc"></div>';
                            }else{
                                $discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right;
                            }
                        }elseif($_SESSION['languages_code']=='en'){
                            $discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right.$old_price_was;
                        }elseif(in_array($_SESSION['languages_code'],['de','dn'])  && $currency!="NOK"){

                            $discount_price = $products_price .FS_PRICE_EXCL_VAT.'<br/><li class="price_bef_tax">'.$taxPriceText.'  '.FS_PRICE_INCL_VAT.'</li></span><div class="ccc"></div>';
                        }else{
							$discount_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right;
						}
					}
					$shipping_info = new ShippingInfo(array("pid" => $product_id, 'purchase_qty' => $qty));
					$shipping_text = $shipping_info->getShippingDayInfo($pure_price * $qty);
					$product_price = $currency_symbol_left . sprintf('%.2f',$products_price) .$currency_symbol_right;
					echo json_encode(array('price'=>$discount_price,'discount'=>$discount,'product_price'=>$product_price,'shipping_text'=>$shipping_text));
				}
				break;

			case 'packing_conditions_new':
				require_once(DIR_FS_CATALOG.'includes/classes/shipping_info.php');
				$product_id = $_POST['products_id'];
				$qty = $origin_qty = $_POST['qty'];
				if($product_id){
					$packing_conditions = get_product_packing_conditions($product_id);

					$currency = $_SESSION['currency'];
					$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
					$decimal =  $currencies->currencies[$_SESSION['currency']]['decimal_places'];

					//返回当前产品取整或不取整后的美元价格
					$product_price = zen_get_products_final_price((int)$product_id);

					$discount=0;
					$old_price_was = $discountText = "";	//折扣前的原始价格  节省价格 带货币符号
					$old_price = $products_price = $product_price;

						if($_POST['type']==2){
							$qty=1;
						}

                    if($_SESSION['member_level']>1 || $qty<$packing_conditions['packing_quantity']){
                    	//企业会员装箱不打折
						$packing_conditions['discount'] =1;
					}


						//装箱产品没有折扣的原始价格
						$old_price = $product_price*$qty;
						$oldPriceText = $currencies->total_format($old_price);
						/*注意：1. 装箱产品整箱价格结算方式和购物车页面保持一致 需要先把单个产品取整后的美元价格乘上装箱折扣率 计算出折扣后的美元价格
							  * 2. 再把上面折扣美元价格 转成对应币种价格 进行保留小数位操作
							  * 3. 最后 保持小数位后对应币种价格 乘上装箱产品个数 最后再转成美元价格
							  *  不这样结算会导致详情页的装箱产品价格和购物车页面计算不一致
							 */
						//装箱处理后的单个产品的价格 原始价格*折扣
						$products_price = $products_price * $packing_conditions['discount'];
						//转成对应币种价格 进行保留小数位操作
						$products_price =  zen_round($products_price * $currency_value, $decimal);
						//计算一箱产品价格
						$products_price = ($products_price * $qty)/$currency_value;
					if($_SESSION['member_level']<=1 && $qty>=$packing_conditions['packing_quantity']) {
						//节省价格 目前只有英文站展示
						$discount = $old_price - $products_price;
						$discountText = 'Save  ' . $currencies->total_format($discount);
					}

					//生成的对应币种的带货币符号的价格
					$priceText = $currencies->total_format($products_price);
					$priceHtml = $taxPriceText = '';

					if($_SESSION['languages_code']=='en' && $discount>0 && strtolower($_SESSION['countries_iso_code']) !='ru') {
						//英文站展示 装箱购买的原始总价格
						$priceHtml .= $priceText.'<strong id="old_price_was"><i class="old_price_was">'.FS_COMMON_LEVEL_WAS_1.' </i><strong class="old_price_z">'.$oldPriceText.'<span class="old_price_line"></span></strong></strong>';
					} else if ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code']) && (!in_array(strtoupper($_SESSION['countries_iso_code']), array('BL', 'MF')))) {
                        if (in_array(strtolower($_SESSION['countries_iso_code']), ['fr', 'be', 'mc', 'lu'])) {
                            $priceText = $priceText.' HT';
                        }
                        $current_vat = get_current_vat_by_languages_code();
                        $taxPriceText = $currencies->total_format($products_price * (1 + $current_vat[2]));
                        $taxPriceHtml = '<br/><i class="price_bef_tax">'.$taxPriceText.' TTC</i>';
                        $priceHtml .= $priceText.$taxPriceHtml;

                    } else{
						if($_SESSION['languages_code'] == 'jp'){
							if($_SESSION['currency']!='JPY'){
								//jp站货币是美元是需要展示出日元价格
								$jp_product_price = zen_get_products_final_price((int)$product_id,'JPY');
								if($origin_qty>=$packing_conditions['packing_quantity'] && $_SESSION['member_level']<=1) {
									if($_POST['type']==2){
										$qty=1;
									}
									//日元汇率
									$currency_value_jp = $currencies->currencies['JPY']['value'];
									//日元保留小数位个数
									$decimal_jp = $currencies->currencies['JPY']['decimal_places'];
									//装箱处理后的日元价格 处理方式同上
									$jp_product_price = $jp_product_price * $packing_conditions['discount'];
									$jp_product_price = zen_round($jp_product_price * $currency_value_jp, $decimal_jp);
									$jp_product_price = ($jp_product_price * $qty)/$currency_value_jp;
								}
							}
						}

						$priceData = getAfterVatPrice($products_price, $priceText,'',$jp_product_price);
						$priceHtml .= $priceData['totalPrice'] . $priceData['taxPrice'];

					}

					$shipping_info = new ShippingInfo(array("pid" => $product_id, 'purchase_qty' => $qty));
					$shipping_text = $shipping_info->getShippingDayInfo($pure_price*$qty);
					echo json_encode(array('price'=>$priceHtml,'shipping_text'=>$shipping_text,'discount'=>$discountText,'product_price'=>$priceText));
				}
				break;
		}
	}
}