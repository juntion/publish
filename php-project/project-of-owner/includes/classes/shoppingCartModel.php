<?php 
class shoppingCartModel
{

	public function __construct()
	{
	}

	/**
	 * 购物车相关页面获取 产品相关数据
	 * @param $products 购物车类的get_products方法获取的数据
	 * @param $isCheckedTrue 是否获取勾选产品价格 true：是 ，false：否
	 * @return array
	 */
	public function get_products_data($products, $isCheckedTrue=true)
	{
		global $currencies, $db;
        require_once('includes/classes/shipping_info.php');
		$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
		$decimal = $currencies->currencies[$_SESSION['currency']]['decimal_places'];
		$productArr = $materialArr = $transTimeArr = array();
        $total_price_usual = 0;
		$total_price = $origin_total_price = $not_quote_origin_price = $not_quote_after_discount_price = 0; //折扣后的产品总价格和原始总价格
		$is_show_inquiry_btn = false;
		$j = 0;
		for ($i=0, $n=sizeof($products); $i<$n; $i++) {
            $label_option_arr = array();
            $combination_arr = array();
			$attributeHiddenField = "";
			$attrArray = false;
			$instockAttr = [];	//存放属性值ID用于库存匹配
			$productsName = $products[$i]['name'];
			$productsModel = $products[$i]['model'];
			$is_checked = $products[$i]['is_checked'];
			if ($is_checked == 1) {
                $j++;
            }
			// Push all attributes information in an array
			if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
				if (PRODUCTS_OPTIONS_SORT_ORDER=='0') {
					$options_order_by= ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
				} else {
					$options_order_by= ' ORDER BY popt.products_options_name';
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
						$instockAttr[] = $value;
						$label_option_arr[] = (int)$option;
                        $combination_arr[] = (int)$value;
//                        $attr_str = '';
//                        if($combination_arr){
//                            $attr_str[] = reorder_options_values($combination_arr);
//                        }
                    }else{
						$attributes=$db->getAll("select id,price_prefix,length_price,length,product_id,sign,custom from products_length where product_id = '".$products[$i]['id']."' and id = '$value'");
						if($attributes){
							$attrArray[$option]['length'] = $attributes[0]['length'];
							$attrArray[$option]['id'] = $value;
							$attributeHiddenField .= zen_draw_hidden_field('length[' . $products[$i]['id'] . ']', $value);
						}
					}
				}
			} //end foreach [attributes]

			$attr = zen_get_products_min_order_by_productsid(intval($products[$i]['id']));

			$pAttr = explode(':',$products[$i]['id']);   ########################
			$sql='select is_min_order_qty as min_qty from products where products_id = '.(int)$products[$i]['id'];
			$result = $db->Execute($sql);
			$min_qty=$result->fields['min_qty'];

			//如果是特殊的产品 则不让增加减少
			if (get_product_category_status($products[$i]['id'])==1){

			    if (isset($products[$i]['products_clearance_tips']) && $products[$i]['products_clearance_tips']) {
                    $quantityField = '<input data-replace-products-tip="'.$products[$i]['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$products[$i]['products_clearance_tips']['replace_products_id'].'" type="text" name="cart_quantity[]" value="'.$products[$i]['quantity'].'" onkeydown="if(event.keyCode==13){return false;}" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" readonly="">';
                } else {
				    $quantityField = '<input type="text" name="cart_quantity[]" value="'.$products[$i]['quantity'].'" onkeydown="if(event.keyCode==13){return false;}" maxlength="5" class="shopping_cart_01" autocomplete="off" min="1" readonly="">';
                }

			}elseif (isset($attr) && $attr > 0) {
				$string_pid = "'".$products[$i]['id']."'";
				$quantityField = zen_draw_hidden_field('product_min_qty', $min_qty);
				$quantityField .= zen_draw_hidden_field('products_id[]', $products[$i]['id']);

                if (isset($products[$i]['products_clearance_tips']) && $products[$i]['products_clearance_tips']) {
                    $quantityField .= zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onkeydown="if(event.keyCode==13){return false;}" onblur="check_min_qty(this,'. $string_pid .');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this,\'quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '\')" class="shopping_cart_01"  autocomplete="off"  min="1" data-replace-products-tip="'.$products[$i]['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$products[$i]['products_clearance_tips']['replace_products_id'].'"', 'text');
                } else {
				    $quantityField .= zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onkeydown="if(event.keyCode==13){return false;}" onblur="check_min_qty(this,'. $string_pid .');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5"  onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this,\'quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '\')" class="shopping_cart_01"  autocomplete="off"  min="1"', 'text');
                }

			} else {
				$string_pid = "'" . $products[$i]['id'] . "'";
				$quantityField = zen_draw_hidden_field('product_min_qty', $min_qty);
				$quantityField .= zen_draw_hidden_field('products_id[]', $products[$i]['id']);
                if (isset($products[$i]['products_clearance_tips']) && $products[$i]['products_clearance_tips']) {
				    $quantityField .= zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onkeydown="if(event.keyCode==13){return false;}" onblur="check_min_qty(this,' . $string_pid . ');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this,\'quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '\')" class="shopping_cart_01" autocomplete="off"  min="1" data-replace-products-tip="'.$products[$i]['products_clearance_tips']['replace_products_tip'].'" data-replace-products-id="'.$products[$i]['products_clearance_tips']['replace_products_id'].'"', 'text');
                } else {
				    $quantityField .= zen_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'id="quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '" onkeydown="if(event.keyCode==13){return false;}" onblur="check_min_qty(this,' . $string_pid . ');" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')"  onfocus="enterKey(this,\'quantity_' . (int)$products[$i]['id'] . '_' . $pAttr[1] . '\')" class="shopping_cart_01" autocomplete="off"  min="1" ', 'text');

                }
			}

			$productsPriceEach =  $currencies->display_price_rate(zen_round(($products[$i]['final_price']*$currency_value),$decimal), zen_get_tax_rate($products[$i]['tax_class_id']), 1) . ($products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) : '');

			$productsPriceTotal = $currencies->display_price_rate(zen_round(($products[$i]['final_price']*$currency_value),$decimal), zen_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) .
				($products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->display_price($products[$i]['onetime_charges'], zen_get_tax_rate($products[$i]['tax_class_id']), 1) : '');
            $productsPriceTotalUsual = $currencies->display_price_rate(zen_round(($products[$i]['final_price']*$currency_value),$decimal), zen_get_tax_rate($products[$i]['tax_class_id']), ($products[$i]['quantity']? $products[$i]['quantity'] : $products[$i]['usual_qty'])) .
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
			//获取产品属性库存及交期
            $instockHtml = '';
            $is_gsp_vat = false;
            if(!$products[$i]['instockHtml']){
                $config['pid'] = $products[$i]['standardProductsId'] ? $products[$i]['standardProductsId'] : (int)$products[$i]['id'];
                $config['attr_option_arr'] = $combination_arr;
                $config['label_option'] = $label_option_arr;    //用于判断定制模块是否勾选label service属性
                //有匹配的毛料ID  去查询库存和交期
                $config['material_data'] = $products[$i]['relate_material_data'];
                if($products[$i]['relate_material_id'] && !sizeof($products[$i]['relate_material_data']) && $attrArray['length']['length']){
                    $config['material_data'] = get_relate_material_data(
                        $products[$i]['relate_material_id'],
                        $attrArray['length']['length'],
                        $products[$i]['quantity']
                    );
                }
                $materialArr[$products[$i]['id']] = $config['material_data'];
                $shipping_info = new ShippingInfo($config);
                $shipping_info->pure_price = $products[$i]['products_price'];
                $shipping_info->main_page = "shopping_cart";
                $shipping_info->getDefaultAddressInfo();
                $shipping_info->set_products_info($products[$i]['quantity']);
                $instockHtml = $shipping_info->showIntockDate(false,1);
                $is_gsp_vat = $shipping_info->is_gsp_vat_product();
                $transTimeArr[$products[$i]['id']] = $shipping_info->getSettingDay();
            }

            //计算优惠后产品总价格
            if ($isCheckedTrue) {
                if ($products[$i]['is_checked'] == 1) {  //只计算勾选产品的总价
                    $total_price += $products[$i]['final_price'] * $products[$i]['quantity'];
                    $total_price_usual +=  $products[$i]['final_price'] * ($products[$i]['quantity'] ? $products[$i]['quantity'] : $products[$i]['usual_qty']);
                    //计算没有优惠的产品原始总价格
                    $origin_total_price += $products[$i]['products_price'] * $products[$i]['quantity'];

                    /* Yoyo 2019.06.14
                    企业用户的quote依然展示total saving
                    但是只是展示除去quote且有优惠的
                    故计算不是quote的产品的原价和总价
                    */
                    if($products[$i]['reoder_type'] !='quotation'){
                        $not_quote_origin_price += $products[$i]['products_price'] * $products[$i]['quantity'];
                        $not_quote_after_discount_price += $products[$i]['final_price'] * $products[$i]['quantity'];
                    }
                }
            } else {
                $total_price += $products[$i]['final_price'] * $products[$i]['quantity'];
                $total_price_usual +=  $products[$i]['final_price'] * ($products[$i]['quantity'] ? $products[$i]['quantity'] : $products[$i]['usual_qty']);
                //计算没有优惠的产品原始总价格
                $origin_total_price += $products[$i]['products_price'] * $products[$i]['quantity'];

                /* Yoyo 2019.06.14
                企业用户的quote依然展示total saving
                但是只是展示除去quote且有优惠的
                故计算不是quote的产品的原价和总价
                */
                if($products[$i]['reoder_type'] !='quotation'){
                    $not_quote_origin_price += $products[$i]['products_price'] * $products[$i]['quantity'];
                    $not_quote_after_discount_price += $products[$i]['final_price'] * $products[$i]['quantity'];
                }
            }


			$image = get_resources_img(intval($products[$i]['id']),'120','120',$products[$i]['image'],'','',' border="0" ');
			$link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($products[$i]['id']),'NONSSL');
			$productArr[$i] = array(
				'attributeHiddenField'=>$attributeHiddenField,
				'productImageSrc' => $products[$i]['image'],
				'resourceImage' => $image,
				'link' => $link,
				'productsName'=>$productsName,
				'productsModel' => $productsModel,
				'quantityField'=>$quantityField,
				'quantity'=>$quantity,
				'productsPrice'=>$productsPriceTotal,
				'productsPriceUsual'=>$productsPriceTotalUsual,
				'price'=>$products[$i]['final_price'],
				'usual_qty'=>$products[$i]['usual_qty'],
				'products_price'=>$products[$i]['products_price'],
				'products_price_total'=>$products[$i]['products_price']*$products[$i]['quantity'],
				'productsPriceEach'=>$productsPriceEach,
				'productsWeight'=> $productsWeight,
				'id'=>$products[$i]['id'],
				'attributes'=>$attrArray,
				'instockAttr' => $instockAttr,
				'pure_weight' => $pure_weight ,
				'reoder_type'=>$products[$i]['reoder_type'],
				'reoder_price'=>$products[$i]['reoder_price'],
				'reoder_info'=>$products[$i]['reoder_info'],
				'products_status' => $products[$i]['products_status'],
				'show_type' => $products[$i]['show_type'],
                'label_option' => $label_option_arr,
                'clearance_qty' => $products[$i]['clearance_qty'], //清仓产品总库存
                'is_clearance' => $products[$i]['is_clearance'],    //是否是清仓产品
                'instockHtml' => $products[$i]['instockHtml'] ? $products[$i]['instockHtml'] : $instockHtml,
                'attr_str' => $combination_arr,
                'is_gsp_vat' => $is_gsp_vat,
                'orders_number' => $products[$i]['orders_number'],
                'is_checked' => $is_checked,
                'products_model' => $products[$i]['model'],
                'warehouseStatus' => $products[$i]['warehouseStatus'],
                'inquiryStatus'   => $products[$i]['inquiryStatus'],
			);

			// 如果存在一个非询价的产品，则展示是否询价按钮
			if(!$is_show_inquiry_btn){
				if(!(isset($products[$i]['reoder_type']) && $products[$i]['reoder_type'] == 'quotation')) {
					$is_show_inquiry_btn = true;
				}
			}
		}
		$data = array(
			'total_price' => $total_price,	//所有产品折扣后的总价
			'total_price_usual' => $total_price_usual,	//所有产品折扣后的总价
			'origin_total_price' => $origin_total_price,	//所有产品折扣前的总价
			'is_show_inquiry_btn' => $is_show_inquiry_btn,
			'not_quote_origin_price' => $not_quote_origin_price,	//所有不含询价产品折扣前的总价
			'not_quote_after_discount_price' => $not_quote_after_discount_price,	//所有不含询价产品折扣后的总价
			'productArr' => $productArr,
            'materialArr' => $materialArr,
            'transTimeArr' => $transTimeArr,
            'is_checked_num' => $j, //购物车勾选产品总数量
		);
		return $data;
	}

	/**
	 * shoppingCart类的get_products()方法获取的产品属性数组
	 * @param $product
	 * @return array
	 */
	public function get_attributes_info($product)
	{
		global $db;
		$attrArray = [];
		if (isset($product['attributes']) && is_array($product['attributes'])) {
			if (PRODUCTS_OPTIONS_SORT_ORDER == '0') {
				$options_order_by = ' ORDER BY LPAD(popt.products_options_sort_order,11,"0")';
			} else {
				$options_order_by = ' ORDER BY popt.products_options_name';
			}
			foreach ($product['attributes'] as $option => $value) {
				if ($option != 'length') {
					$attributes = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
										 FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
										 WHERE pa.products_id = :productsID
										 AND pa.options_id = :optionsID
										 AND pa.options_id = popt.products_options_id
										 AND pa.options_values_id = :optionsValuesID
										 AND pa.options_values_id = poval.products_options_values_id
										 AND popt.language_id = :languageID
										 AND poval.language_id = :languageID " . $options_order_by;

					$attributes = $db->bindVars($attributes, ':productsID', $product['id'], 'integer');
					$attributes = $db->bindVars($attributes, ':optionsID', $option, 'integer');
					$attributes = $db->bindVars($attributes, ':optionsValuesID', $value, 'integer');
					$attributes = $db->bindVars($attributes, ':languageID', $_SESSION['languages_id'], 'integer');
					$attributes_values = $db->Execute($attributes);

					$option_name = $attributes_values->fields['products_options_name'];
					$value_name = $attributes_values->fields['products_options_values_name'];
					//clr 030714 determine if attribute is a text attribute and assign to $attr_value temporarily
					if ($value == PRODUCTS_OPTIONS_VALUES_TEXT_ID) {
						$attr_value = htmlspecialchars($product['attributes_values'][$option], ENT_COMPAT, CHARSET, TRUE);
					} else {
						$attr_value = $value_name;
					}
					$attrArray[$option]['products_options_name'] = $option_name;
					$attrArray[$option]['options_values_id'] = $value;
					$attrArray[$option]['products_options_values_name'] = $attr_value;
				} else {
					$attributes = $db->getAll("select id,price_prefix,length_price,length,product_id,sign,custom from products_length where product_id = '" . $product['id'] . "' and id = '$value'");
					if ($attributes) {
						$attrArray[$option]['length'] = $attributes[0]['length'];
					}
				}
			}
		}
		return $attrArray;
	}

	/**
	 * 购物页面 Email your cart 需要的购物车数据结构
	 * @param $contents
	 * @return string eg: 70410:a4ae22def67cf5911f6b8b1a3cfb2e24:1_38:6472_47:4262_122:{test test & test}_3:5138_46:3431_78/chk5147:5147_78/chk5146:5146|36157:3
	 * 不同产品之间用|间隔，定制产品不同属性之间用_间隔optionID:optionValueID例如38:6472_47:4262
	 */
	public function get_save_list_str_by_contents($contents=[]){
		$list = '';
		if($contents){
			foreach($contents as $key=>$value){
				//产品ID和产品数量之间用:间隔
				$list .= $key.':'.$value['qty'];
				if($value['attributes']){
					foreach($value['attributes'] as $k=>$v){
						//78_chk5147多选类型的属性项，先将_替换成/
						$k = str_replace("_","/",$k);
						if($v==0){
							//如果optionValueID为0，代表该属性项是文本类型，客户可以填写定制需求，用{}将客户填写的内容间隔
							$list .= '_' . $k . ':{' .$value['attributes_values'][$k].'}';
						}else{
							$list .= '_'.$k.':'.$v;
						}
					}
				}
				$list .= '|';
			}
			$list = substr($list,0,count($list)-2);
		}
		return $list;
	}

	/**
	 * 反解 get_save_list_str_by_contents()生成的字符串 生成购物车类的contents类型数据
	 * @param $list
	 * @return array
	 */
	public function get_save_products_by_list_str($list){
		$contents = [];
		if($list){
			$list_arr = explode('|', $list);	//拆分所有的产品数据 不同产品之期间用|间隔
			foreach ($list_arr as $k => $v) {
				if(!$v){
					continue;
				}
				//处理单个产品 产品ID和数量用:拼接  和属性之间用_拼接
				$a = explode('_', $v);
				$attr = $attr_value = array();
				$qty_arr = explode(':', $a[0]);
				if (count($qty_arr) == 3) {
					//定制产品 产品id评接有加密字符串
					$products_id = $qty_arr[0] . ':' . $qty_arr[1];
					$qty = $qty_arr[2];
				} else {
					$products_id = $qty_arr[0];
					$qty = $qty_arr[1];
				}
				$a_num = count($a);
				if ($a_num > 1) {
					//有属性数据 是定制产品
					for ($j = 1; $j < $a_num; $j++) {
						//option_id和value_id之期间用:拼接
						$b = explode(':', $a[$j]);
						$b[0] = str_replace("/", "_", $b[0]);	//多选属性项的特殊处理还原
						if(strpos($b[1],'-')){
							if(strpos($b[1],'{')!==false && strpos($b[1],'}')!==false){
								//客户选择custom属性值时自定义填写内容
								$attr[$b[0]] = 0;
								$b[1] = str_replace("{", "", $b[1]);
								$b[1] = str_replace("}", "", $b[1]);
								$attr_value[$b[0]] = $b[1];
							}else{
								$column_arr=explode('-',$b[1]);
								$attr[$b[0]] = (int)$column_arr[0];
							}
						}else{
							if(is_numeric($b[1])){
								$attr[$b[0]] = $b[1];
							}else{
								$b[1] = str_replace("{", "", $b[1]);
								$b[1] = str_replace("}", "", $b[1]);
								$attr_value[$b[0]] = $b[1];
								$attr[$b[0]] = 0;
							}
						}

					}
				}
				if((int)$qty){
					$contents[$products_id] = array(
						'qty' => (int)$qty,
					);
					if(!empty($attr)) $contents[$products_id]['attributes'] = $attr;
					if(!empty($attr_value)) $contents[$products_id]['attributes_values'] = $attr_value;
				}
			}
		}
		return $contents;
	}


	/**
	 * ery add 2019.7.12 之前pico做的将购物车中下架产品转为save for later产品 并提示客户下架
	 * 购物车页面展示save for later中关闭状态的产品HTML
	 * $param array $products
	 * @return html
	 */
	public function show_cart_close_products($products)
	{
		global $currencies;
		$close_html = '';
		if (sizeof($products)) {
			$i = $j = 0;
			foreach ($products as $product_kye=>$product_value){
                if ($product_value['products_status'] == 0 || $product_value['warehouseStatus'] == 0 || $product_value['inquiryStatus']==1 || ($product_value['clearance_qty']==0 && $product_value['is_clearance']==1)) {
                    $j++; //购物车下架产品的个数
                }
            }
			foreach ($products as $key => $product) {
                //无库存的清仓产品在购物车中和下架产品展示一致  Dylan 2019.10.2 Add
				if ($product['products_status'] == 0 || $product['warehouseStatus'] == 0 || $product['inquiryStatus']==1 || ($product['clearance_qty']==0 && $product['is_clearance']==1)) {
					$i++;
					$image = '<img src="' . HTTPS_PRODUCTS_SERVER . DIR_WS_IMAGES . $product['productImageSrc'] . '"' . ' width = 120 height=120>';
					$link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . intval($product['id']), 'NONSSL');

					$close_html .= '<dd class="shipment-shopcart-list shelves_rack_product" data-cartid="'.$product['id'].'">';
					$clearance_tip = FS_PRODUCT_OFF_TEXT_8;
					if($j > 1){
                        $clearance_tip = FS_PRODUCT_OFF_TEXT_9;
                    }
					if ($i == 1) {
                        $close_html .= '<div class="public_Prompt">
                                                        <i class="iconfont icon">&#xf071;</i>'.$clearance_tip.'
                                                    </div>';
                    }

                    $deleteP = '<div class="iconfont shipment-shopcart-newdeleteIc shopping_cp_cell_remove save_for_late_remove '.(isMobile() ? "shopcart-products-demM" : "").'" value="'.$product['id'].'"></div><input type="hidden" name="quote_type" value="0">';
                    $close_html .= '<div class="shelves_rack_product_bg"></div>
												<div class="shipment-shopcart-list-box after shopping_cart_pro_con">
													<div class="new-shopcart-tableBox-parent">
														<div class="new-shopcart-boxz01 new-shopcart-tableBox">
															<div class="shopcart-products-pic">
                                                                <span class="shipment-shopcart-checkpro-eachicbox checkpro-eachicbox-cantcheck">
                                                                    <i class="iconfont shipment-shopcart-checkpro-eachic">&#xf022;</i>
                                                                </span>
																<a href="">' . $image . '</a>
															</div>
															<div class="shopcart-products-info">
																<a class="shopcart-products-name" href="javascript:;">'.$product['productsName'].'</a>';
                                                                    //属性展示
                                                                    if (isset($product['attributes']) && is_array($product['attributes'])) {
                                                                        $close_html .= '<div class="cartAttribsList" style="display: none"><ul>';
                                                                        foreach ($product['attributes'] as $option => $value) {
                                                                            if ($option == 'length') {
                                                                                $Length = trim($value['length']);
                                                                                $close_html .= '<li class="get-quote-txt01">' . FS_LENGTH_NAME . ' - ' . zen_show_product_length($Length, (int)$product['id']) . '</li>';
                                                                            } else {
                                                                                $Attr[] = $value['options_values_id'];
                                                                                $close_html .= '<li class="get-quote-txt01">' . $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']) . '</li>';
                                                                            }
                                                                        }
                                                                        $close_html .= '</ul></div>';
                                                                    }
																$close_html .='<div class="shopping_cart_sku"><span class="product_modelid_txt">FS P/N: '.$product['productsModel'].'   <span class="product_sku"><span>&nbsp;#'.(int)$product['id'].'</span></span></span><br><span class="products_in_stock"></span></div>
															</div>
															<div class="shopcart-products-panel">
																<div class="shopcart-products-panel-pay shopcart-products-panel-count">
																    <div class="shopcart-products-notpricez-txt unavailable">';
                                                                    if ($product['products_status'] == 1 && $product['warehouseStatus'] ==1 && $product['inquiryStatus'] == 1) {
                                                                        $close_html .= '<div style="cursor:pointer;" id="inquiry_quote" name="'.$product['id'].'">'.GET_A_QUOTE.'</div>';
                                                                    }else{
                                                                        $close_html .= LIVE_CHAT_CON11;
                                                                    }
                                                                    $close_html .='</div>
                                                                    '.$deleteP.'
																</div>
															</div>
															<div class="shopcart-products-demM">
																<div class="shopcart-products-playTa"></div>
																<div class="shopcart-products-playTa">
																	<div class="shopcart-products-playTd">
																		<div class="shopcart-products-panel-op">
																			<a href="javascript:;" class="shopcart-remove save_for_late_remove" value="'.$product['id'].'">
																				<i class="icon iconfont"></i>
																				<input type="hidden" name="quote_type" value="0">
																				<span>Remove</span>
																			</a>
                                                                    </div>
																	</div>
																	<div class="shopcart-products-playTd"><div class="shopcart-products-notpricez-txt unavailable">'.LIVE_CHAT_CON11.'</div></div>
																</div>
															</div>
														</div>
														'.(isMobile() ? $deleteP : "").'
													</div>
												</div>
											</dd>';

				}
			}

		}
		return $close_html;
	}

}


