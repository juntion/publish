<?php
require 'includes/application_top.php';
require DIR_WS_CLASSES . 'shipping_info.php';

use classes\custom\FsCustomRelate;

if (isset($_GET['request_type'])) {
    switch ($_GET['request_type']) {
        case 'getCustomRelatedInstock':
            $issetType = isset($_POST['typeMgb']);
            $typeMgb = $issetType ? 'inquiry_request_edit' : 'inquiry_cart';
            $productsId = zen_db_prepare_input($_POST['products_id']);
            $Attr = zen_db_prepare_input($_POST['attr']);
            $length = zen_db_prepare_input($_POST['length']);
            $qty = (int)$_POST['qty'];
            $origin_price = 0;
			$allAttr = $_POST['allattr'];
			$attrArr = explode(',',$allAttr);
			$oPtionVal = array();
			$totalPrice = 0;
            $quotePrice = 0;
			$brandFlag = $isBrand = false;
			$attribute = array();
            $attr_value_id = zen_db_prepare_input($_POST['attr_value_id']);
            $isTrue = $_POST['is_true'];
            $tishi='';
            $pid = $_POST['product_attr_id'];
            //报价长度属性保存
            $length_id="";
            $is_show_spool =0;
            $materialData = array();
            if(isset($_POST['type']) && $_POST['type']=="quote" && !empty($_POST['attr_product_id']) && !empty($length)){

                $length_id = fs_get_data_from_db_fields('id','products_length','length="'.$length.'" and product_id = "'.$productsId.'" limit 1');

                if(empty($length_id)){
                    $attrArr = get_length_range_price($productsId, $length);
                    if(!empty($attrArr)){
                        $db->query("insert into products_length (length_price,price_prefix,weight,length,product_id,add_time,sign,custom) values ('" . $attrArr['length_price'] . "','+','" . $attrArr['weight'] . "','" .$attrArr['length']. "','" . $productsId . "','" . date('Y-m-d H:i:s') . "','0','1')");
                        $length_id = $db->insert_ID();

                    }
                }
                if($length_id){
                    $_SESSION[$typeMgb]['contents'][$_POST['attr_product_id']]['attributes']['length']=$length_id;
                    if($_SESSION['customer_id']){
                        $inquiry_id =  $db->getAll("select id from customer_inquiry where customers_id =".$_SESSION['customer_id']." and status = 5 limit 1");

                        if($inquiry_id){
                            $inquiry_product_id =  $db->getAll("select id from customer_inquiry_products where inquiry_id =".$inquiry_id[0]['id']." and attribute_product_id = '".$_POST['attr_product_id']."' limit 1");

                            if($inquiry_product_id){
                                $attr_length_id = $db->getAll("select id from customer_inquiry_products_length where  inquiry_products_id =".$inquiry_product_id[0]['id']." limit 1");
                                if($attr_length_id){
                                    zen_db_perform("customer_inquiry_products_length",array('product_length_id'=>$length_id),'update','id='.$attr_length_id[0]['id']);

                                }else{
                                    $inquiry_data = array(
                                        'inquiry_products_id'=>$inquiry_product_id[0]['id'],
                                        'products_id'=>(int)$productsId,
                                        'length_name'=>"length",
                                        'product_length_id'=>$length_id,
                                    );
                                    zen_db_perform("customer_inquiry_products_length",$inquiry_data);
                                }
                            }
                        }
                    }
                }
            }
            if (isset($_POST['ids']) && is_array($_POST['ids']) && count($_POST['ids']) > 0) {
                $id_option=[];
                foreach ($_POST['ids'] as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $v) {
                            $value_arr = explode('_', $v);
                            $id_option[$key][$value_arr[0]] = $value_arr[0];
                            $id_column[$key][$value_arr[0]] = $value_arr[1];
                        }
                    } else {
                        $value_arr = explode('_', $value);
                        $id_option[$key] = $value_arr[0];
                        $id_column[$key][$value_arr[0]] = $value_arr[1];
                    }
                }
//                unset($_SESSION['inquiry_cart']['contents'][$pid]['attributes']);
                foreach ($id_option as $option=>$value) {
                    //CLR 020606 check if input was from text box.  If so, store additional attribute information
                    //CLR 020708 check if text input is blank, if so do not add to attribute lists
                    //CLR 030228 add htmlspecialchars processing.  This handles quotes and other special chars in the user input.
                    $attr_value = NULL;
                    $blank_value = FALSE;
                    if (strstr($option, TEXT_PREFIX)!=false) {
                        if (trim($value) == NULL) {
                            $blank_value = TRUE;
                        } else {
                            $option = substr($option, strlen(TEXT_PREFIX));
                            $attr_value = stripslashes($value);
                            if(!empty($attr_value)){
                                $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                                $_SESSION['inquiry_cart']['contents'][$pid]['attributes_values'][$option] = $attr_value;
//                        if($option==159){
                                $_SESSION['inquiry_cart']['contents'][$pid]['attributes'][$option]=0;
//                        }
                            }
                        }
                    }

                    if (!$blank_value && $value!=0) {
                        if (is_array($value)) {
                            reset($value);
//                    if (strpos($option, 'upload_prefix_') !== false) {
//                        $_SESSION['inquiry_cart']['contents'][$pid]['attributes'][$option] = $value;
//                    }else{
                            while (list($opt, $val) = each($value)) {
                                $_SESSION['inquiry_cart']['contents'][$pid]['attributes'][$option . '_chk' . $val] = $val;
                            }
//                    }
                        } else {
                            $_SESSION['inquiry_cart']['contents'][$pid]['attributes'][$option] = $value;
                        }
                    }
                }
            }


            if($attr_value_id){
                $option_value_word = fs_get_data_from_db_fields('options_values_word', 'products_options_values', 'products_options_values_id=' . $_POST['attr_value_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');
                if ($option_value_word) {
                    $tishi .= getNewWordHtml($option_value_word);
                }
            }
			//产品属性数据处理
            $data_info = match_product_initialization_information($productsId,$allAttr,$Attr,$length);
			//Compatible Brands属性项下的Dual Compatibility Solutions属性值需根据不同产品展示不同提示语
            $isBrand = $data_info['isBrand'];
            $compatibility_placeholder = get_compatibility_placeholder($productsId,$isBrand,$data_info['brandFlag']);
            $brandHtml = $compatibility_placeholder['brandHtml'];
            $brandClass = $compatibility_placeholder['brandClass'];

            if ($productsId  && $_SESSION['securityToken'] == $_POST['token']) {
                $Attr = $data_info['Attr'];
                $excellentMatch = $data_info['match_products_id'];

				//查找该产品的价格
				$currency = $_SESSION['currency'];
				$currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
				
				$taxPrice = $totalPrice = $quote_price ='';
				$jp_totalPrice = ''; //jp站的币种是美元是展示日币价格
				$weight_num = 0;
                $total_price = 0;
                $related_price =0;
                //获取产品的原始价格products表中的products_price的值
                $pure_price = zen_get_products_base_price((int)$productsId);
                //返回当前产品取整或不取整后的美元价格  //出入属性值数组  查询组合产品有属性产品的价格
                $product_price = $data_info['product_price'];
                $attrPrice = $data_info['attrPrice'];
                $priceArr = $data_info['priceArr'];
                $total_price = $data_info['total_price'];
                $combination_arr = $data_info['combination_arr'];
                $attribute = $data_info['attribute'];
                $length_s = $data_info['length_s'];
                $attr_str = $data_info['attr_str'];
                $delivery_attr_arr = $data_info['delivery_attr_arr'];
                $is_show_spool = $priceArr['is_show_spool'];
                //通过美元价格乘以汇率(不带货币符号)  $one_price 主要在定制产品加购弹窗使用
                //$one_price = $total_price * $currency_value;  //当前币种的价格
                $one_price = $data_info['custom_total_price'];  //单个产品美元价格
                //生成的带货币符号的价格
                $origin_price = $total_price;
                $discount_pre=1;
                if(isset($_POST['type']) && $_POST['type']=="quote" && !empty($_SESSION['customer_id'])){
                    if($_SESSION['member_level']>1){
                        $discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], '');
                        if(!empty($discount) && $discount!=1){
                            $discount_pre = $discount;
                        }
                        $quotePrice  = $total_price*$discount_pre;
                    }
                }
                $quote_price = $currencies->total_format($quotePrice, true, $currency, $currency_value);
                $totalPrice = $currencies->total_format($total_price, true, $currency, $currency_value);

                if($_SESSION['languages_code'] == 'jp'){
                    if($_SESSION['currency']!='JPY'){
                        //jp站货币是美元是需要展示出日元价格
                        //有属性的组合产品价格处理
                        $jp_product_price = zen_get_products_final_price((int)$productsId,'JPY',$combination_arr);
                        if($combination_arr['is_composite']){
                            $jp_total_price = $jp_product_price;
                        }else{
                            $jp_total_price = $jp_product_price + $priceArr['length_price'] + $attrPrice;
                        }
                        $jp_totalPrice ='/<em>'.'JPY&nbsp;'.$currencies->total_format($jp_total_price, true,"JPY",'').'</em>';
                    }
                }

                $priceData = getAfterVatPrice($total_price,$totalPrice,'',$jp_total_price,$_POST['type']);
                $totalPrice = $priceData['totalPrice'];
                $taxPrice = $priceData['taxPrice'];

				//产品属性交期
                //$processing_days = $data_info['processing_days'];
                /**美国站且国家为美国以及波多黎各时展示Import Fees板块 2020.3.18 ery**/
                $import_fees_html = '';
                $is_clearance = $data_info['is_clearance'];
                $match_status=$data_info['match_status'];//定制产品匹配到标准产品状态
                if (!$excellentMatch) {
                    //有长度的定制产品部分属性匹配毛料ID产品
                    if($length){
                        $materialData = get_relate_material_data($productsId, $length_s, $qty, $attribute);
                        if($materialData){
                            $excellentMatch[0] = $materialData['materialProductsId'];
                        }
                    }
					$config['pid'] = $productsId;
					$config['attr_option_arr'] = $delivery_attr_arr;
					$config['purchase_qty'] = $qty;
					$config['attributes'] = $attribute;
                    $config['material_data'] = $materialData;
					$shipping_info = new ShippingInfo($config);
                    $processing_days = $shipping_info->get_processing_days();
                    // 实例化时 调换下顺序  判断初始化时模块产品是否勾选标签  2019.10.08 Yoyo
//					$shipping_info->attributes = $attribute;
					$weight_num = $shipping_info->get_weight_for_prdoucts_id();
                                   $shipping_info->weight = $weight_num;
					$warehouse_text = $shipping_info->getStockShipping($totalPrice,'',true);
					$shipping_detail = $shipping_info->getShippingDayInfo($origin_price);
                    $transTime = $shipping_info->settingDay;
					//$transTime = $shipping_info->getSettingDay();
					$shipping_location = $shipping_info->get_warehouse_location();
                    if($shipping_info->check_en_us_site()){
                        $import_fees_html = get_gsp_detail_html();
                    }
                    if((int)$quotePrice==0){
                        $quote_price = null;
                    }
                    echo json_encode(array(
                        "shipping_location"=>$shipping_location,
                        "shipping_detail"=>$shipping_detail,
                        'warehouse_text'=>$warehouse_text,
                        'quote_price'=>$quote_price,
                        'totalPrice'=>$totalPrice,
                        'pid'=>$excellentMatch[0],
                        'length_price'=>$priceArr['length_price'],
                        'length'=>$length_s,
                        'brandHtml'=>$brandHtml,
                        'isBrand'=>$isBrand,
                        'brandClass'=>$brandClass,
                        //'price'=>$products_price,
                        'taxPrice'=>$taxPrice,
                        "weight_num"=>$weight_num,
                        'tishi'=>$tishi,
                        'origin_price'=>$origin_price,
                        'one_price'=>$one_price,
                        'processing_days'=>$processing_days,
                        'attr_str'=>$attr_str,
                        'match_status'=>$match_status,
                        'weight_num'=>$weight_num,
                        'import_fees_html'=>$import_fees_html,
                        'ship_day'=>$transTime,
                        'material_arr'=>$materialData,
                        'is_show_spool' => $is_show_spool,
                    ));
                } else {
					$warehouse_text= zen_get_products_instock_date($productsId,$Attr,$length);
					//匹配到标准产品 不论标准产品是开启还是关闭 都展示标准产品的库存
					$config['pid'] = $excellentMatch[0];
					$pure_price = $related_price = $quote_price = 0;
					if($excellentMatch[0]){
						if($match_status==1){
                            $config['pid'] = $excellentMatch[0];
							$related_price = zen_get_products_final_price($excellentMatch[0]);
                            $discount_pre=1;
                            if(isset($_POST['type']) && $_POST['type']=="quote" && !empty($_SESSION['customer_id'])){
                                if($_SESSION['member_level']>1){
                                    $discount = fs_get_data_from_db_fields('discount_rate', 'customers', 'customers_id=' . (int)$_SESSION['customer_id'], '');
                                    if(!empty($discount) && $discount!=1){
                                        $discount_pre = $discount;
                                    }
                                    $quotePrice  = $related_price*$discount_pre;
                               }
                            }
                            $quote_price = $currencies->total_format($quotePrice, true, $currency, $currency_value);
							$totalPrice = $currencies->total_format($related_price, true, $currency, $currency_value);
                            $priceData = getAfterVatPrice($related_price,$totalPrice,(int)$excellentMatch[0],'',$_POST['type']);
							$totalPrice = $priceData['totalPrice'];
							$taxPrice = $priceData['taxPrice'];
                            //$one_price = $origin_price = $related_price;
                            $origin_price = $related_price;

							//获取产品的原始价格products表中的products_price的值
							$pure_price =  zen_get_products_base_price((int)$excellentMatch[0]);
						}elseif($length) {
                            //定制产品部分属性匹配毛料ID产品
                            $config['material_data'] = get_relate_material_data($productsId, $length_s, $qty, $attribute);
                        }
					}
                    $config['purchase_qty'] = $qty;
					$shipping_info = new ShippingInfo($config);
					$shipping_info->attributes = $attribute;
					$weight_num = $shipping_info->get_weight_for_prdoucts_id();
                    $shipping_info->weight = $weight_num;
                    $shipping_info->attr_option_arr = ($excellentMatch[0] && $match_status==1) ? [] : $delivery_attr_arr;
                    $warehouse_text = $shipping_info->getStockShipping($totalPrice,'',true);
					$shipping_detail = $shipping_detail = $shipping_info->getShippingDayInfo($origin_price);
					$shipping_location = $shipping_info->get_warehouse_location();
                    $processing_days = $shipping_info->get_processing_days();
                    $transTime = $shipping_info->settingDay;
                    if($is_clearance){
                        //清仓产品获取定制产品的交期数据
                        $custom_config['pid'] = $productsId;
                        $custom_config['purchase_qty'] = $qty;
                        $custom_shipping_info = new ShippingInfo($custom_config);
                        $custom_shipping_info->attributes = $attribute;
                        $custom_shipping_info->attr_option_arr = $delivery_attr_arr;
                        $custom_shipping_info->getShippingDayInfo($one_price);
                        $processing_days = $custom_shipping_info->get_processing_days();
                        $transTime = $custom_shipping_info->settingDay;
                    }
                    $clearance_qty = $clearance_other_qty = 0; //可以加购的清仓产品数量
                    if($is_clearance){
                        $clearance_other_qty = $clearance_qty = $shipping_info->getLocalAndWuhanqty();//清仓产品总库存
                        if($_SESSION['cart']->in_cart($excellentMatch[0])){
                            //当前清仓产品在购物车中
                            $cart_pid_qty = $_SESSION['cart']->contents[$excellentMatch[0]]['qty'];
                            //可加购的清仓产品数量需要去掉购物车中已经加购的
                            $clearance_other_qty = ($clearance_qty-$cart_pid_qty) ? ($clearance_qty-$cart_pid_qty):0;
                        }
                    }
                    //$transTime = $shipping_info->getSettingDay();
                    if($shipping_info->check_en_us_site()){
                        $import_fees_html = get_gsp_detail_html();
                    }
                    if((int)$quotePrice==0){
                        $quote_price = null;
                    }
                    echo json_encode(array(
                        "shipping_location"=>$shipping_location,
                        "shipping_detail"=>$shipping_detail,
                        'warehouse_text' => $warehouse_text,
                        'totalPrice'=>$totalPrice,
                        'quote_price'=>$quote_price,
                        'pid'=>$excellentMatch[0],
                        'length_price'=>$priceArr['length_price'],
                        'length'=>$length_s,
                        'brandHtml'=>$brandHtml,
                        'isBrand'=>$isBrand,
                        'brandClass'=>$brandClass,
                        //'price'=>$products_price,
                        'taxPrice'=>$taxPrice,
                        "weight_num"=>$weight_num,
                        'tishi'=>$tishi,
                        'origin_price'=>$origin_price,
                        'one_price'=>$one_price,
                        'processing_days'=>$processing_days,
                        'attr_str'=>$attr_str,
                        'match_status'=>$match_status,
                        'weight_num'=>$weight_num,
                        'import_fees_html'=>$import_fees_html,
                        'ship_day'=>$transTime,
                        'material_arr'=>$config['material_data'],
                        'is_show_spool' => $is_show_spool,
                        'is_clearance' => $is_clearance,
                        'clearance_qty' => $clearance_qty,
                        'clearance_other_qty' => $clearance_other_qty
                    ));
                }
            } else {
                echo 'illegalityRequest';
            }
            exit();
            break;
        case 'getProShippingPrice':
            $weight_num = zen_db_prepare_input($_POST['weight_num']);
            $qty = $_POST['qty'] ? (int)$_POST['qty'] : 1;
            $pid = $_POST['pid'];
            if (empty($weight_num) || empty($pid)) {
                echo json_encode(array("msg" => "error"));
                exit;
            }
            $config['pid'] = $pid;
            $config['purchase_qty'] = $qty;
            $shipping = new ShippingInfo($config);
            $shipping->weight = $weight_num;
            $shipping_price = $shipping->get_shipping_price();
            echo json_encode(array("msg" => "success", "price" => $shipping_price));
            break;
        case 'show_shipping_list':
            $wholesale_products = fs_get_wholesale_products_array();
            $purchase_qty = (int)zen_db_prepare_input($_POST['purchase_qty']);
            $weight = (float)zen_db_prepare_input($_POST['weight']);
            $products_id = (int)zen_db_prepare_input($_POST['products_id']);
            $shipping_country_id = (int)zen_db_prepare_input($_POST['shipping_country_id']);
            $state = zen_db_prepare_input($_POST['state']);
            if(empty($shipping_country_id) || empty($products_id)){
                echo json_encode(array("status" => "error","data" => FS_SYSTME_BUSY));
                exit;
            }

            $shipping_post_code = zen_db_prepare_input($_POST['shipping_post_code']);
            $shipping_country_code = fs_get_data_from_db_fields('countries_iso_code_2',TABLE_COUNTRIES,'countries_id='.$shipping_country_id,'limit 1');

            $config['pid'] = (int)$products_id;
            $config['state'] = $state;
            $config['post_code'] = $shipping_post_code;
            $config['purchase_qty'] = (int)$purchase_qty;
            $shipping_info = new ShippingInfo($config);

            switch ($shipping_country_id) {
                case 223:
                    if (empty($shipping_post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT zip FROM `countries_to_zip_new`  WHERE zip = '".$shipping_post_code."'";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['zip'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
                /*case 13:
                    if (empty($shipping_post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_au_zip`  WHERE postcode = '$shipping_post_code' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
                case 81:
                    if (empty($shipping_post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_de_zip`  WHERE postcode = '$shipping_post_code' AND country='Germany' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode'])) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    } 
                    break;*/
                case 222:
                    if (empty($shipping_post_code)) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_ERROR));
                        exit;
                    }
                    $sql = "SELECT postcode FROM `countries_de_zip`  WHERE replace(`postcode`,' ','') = '".str_replace(" ","",$shipping_post_code)."' 
                    or replace(`postcode`,' ','') LIKE '".substr(str_replace(" ","",$shipping_post_code),0,3)."%' AND country='United Kingdom' LIMIT 1";
                    $ret = $db->Execute($sql);
                    if (empty($ret->fields['postcode']) || strlen($shipping_post_code)<3 || strlen($post_code)>8) {
                        echo json_encode(array("status" => "error", "data" => FS_PRODUCTS_POST_CODE_EMPTY_INVALID));
                        exit;
                    }
                    break;
            }
			$city_name = $shipping_info->getCityInfoByPostCode($shipping_post_code);	//新邮编对应的城市名字
            if($shipping_country_id){
                $shipping_info->country_id = $shipping_country_id;
                $shipping_info->country_code = fs_get_data_from_db_fields('countries_iso_code_2', 'countries', 'countries_id =' . $shipping_country_id . ' limit 1');
                $shipping_info->country_name = get_countries_name($shipping_country_id);
            }
            if($shipping_post_code){
                $shipping_info->post_code = $shipping_post_code;
            }
            $pure_price = $_POST['pure_price'] ? zen_db_prepare_input($_POST['pure_price']) : 0;
            $shipping_info->pure_price = $pure_price;
            $shipping_info->weight = $weight;
            $shipping_info->getFreeText($pure_price);//給is_shipping_free属性赋值

            $total_weight = $weight * $purchase_qty;
            $limit = $shipping_info->getDELimit($total_weight);
            $data = $shipping_info->getShippingList('',$shipping_info->is_shipping_free,$limit);

            $ip_info = $shipping_info->getDefaultAddressInfo();
            $shipping_policy = $shipping_info->getShippingDayInfo($pure_price);
            $return = array(
                "status"=>"success",
                "data"=>$data,
                "ip_info"=>$ip_info,
				"city_name"=>$city_name,
                "shipping_policy"=>$shipping_policy,
                "country_name" => $shipping_info->country_name,
                "country_code" => $shipping_info->country_code,
                'code'=>$_SESSION['countries_iso_code']
            );
            echo json_encode($return);
            break;
        case "get_products_status":
            if(!$_POST['pid']){
                echo json_encode(array("product_status"=>true));
                exit;
            }
            $country_code = zen_db_prepare_input($_POST['country']);
            $pid = zen_db_prepare_input($_POST['pid']);
            $shipping_info = new ShippingInfo(array("pid"=>$pid));
            $product_status = $shipping_info->products_status(strtoupper($country_code));
            echo json_encode(array("product_status"=>$product_status));
            break;
        case "get_products_price_and_date":
            $pid = $_POST['pid'];
            $attr_str = $_POST['attr_str'];
            $qty = (int)$_POST['qty'];
            $ship_time = $_POST['ship_time'];
            $length = $_POST['length'];
            $type = $_POST['type'] ? $_POST['type'] : 0;
            $price = $_POST['price'];   //产品的美元总价
            $processing_days = (int)$_POST['processing_days'];
            $custom_label = $_POST['custom_label'] ?  (int)$_POST['custom_label'] : 0;
            $color_price =  $_POST['color_price'] ?  $_POST['color_price'] : 0;
            if(empty($qty) && (empty($attr_str) || empty($length))){
                echo json_encode(array("status" => "error"));
            }
            $is_show = $_POST['is_show'] ? $_POST['is_show'] :0;
            $attr_arr = explode(',',$attr_str);
            $custom_attr = $attr_arr;
            /*if($length){
                $custom_attr['length'] = $length;
            }
            $processing_total_days = 0;
            if($custom_attr){
                //根据属性匹配虚拟id  (定制产品调取与数量无关)
                $processing_total_days = get_custom_processing_days($pid,$custom_attr);
            }*/
            //$processing_total_days = get_custom_products_attr_days($pid,$attr_arr,$length,$qty);


            //$total_price = $currencies->total_format($price * $qty);
            $config['pid'] = (int)$pid;
            $config['attr_option_arr'] = $custom_attr;
            $material_arr = sizeof($_POST['material_arr']) ? $_POST['material_arr'] : [];
            if($material_arr['materialProductsId']){
                $config['material_data'] = get_relate_material_data($material_arr['materialProductsId'], $length, $qty);
            }
            $shipping_info = new ShippingInfo($config);
            $spring_days = $shipping_info->spring_festival_holiday();
            $festival_day = $shipping_info->get_festival_day();
            $no_weekday_spring_days = $shipping_info->spring_festival_holiday(false);
            $total_processing_days = $processing_days + $no_weekday_spring_days; //备货时间+春节假
            $shipping_day = get_specific_date_of_days(($processing_days+$festival_day),2,$spring_days);
            $shipping_time = get_date_time_format(($shipping_day+$spring_days)); //发货时间

            //价格展示优化2020.5.25 dylan  避免出现误差

            //$total_price = $currencies->total_format($price);
            $price = $currencies->fs_format_new($price,true) * $qty;
            $total_price = $currencies->update_format($price);

            $days = get_specific_date_of_days(($processing_days+$ship_time+$festival_day),2,$spring_days); //得到备货时间天数+运输时间;
            $days += $shipping_info->get_festival_day(($days+$spring_days));  //遇到节假日顺延
            $delivered_date = get_date_time_format($days+$spring_days); //收货时间
            $cartHtml = "";
            if($type){
                $option_values = '';
                if($attr_arr){
                    $option_values = reorder_options_values($attr_arr);
                }
                $cartHtml = products_add_cart_new_popup(true,(int)$pid,'',$custom_label,$color_price,$option_values,$qty);
            }
            echo json_encode(array("status" => "success","total_price" => $total_price,"processing_total_days"=> $total_processing_days,"delivered_date"=> $delivered_date,'cartHtml'=>$cartHtml,'shipping_time'=>$shipping_time));
            break;
        case "get_products_days_date":
            $pid = (int)$_POST['pid'];
            $qty = (int)$_POST['qty'] ? (int)$_POST['qty'] : 1;
            $attr_str = $_POST['attr_str'];
            $length = $_POST['length'];
            $type = $_POST['type'];
            $transTime = $_POST['transTime'] ? $_POST['transTime'] : 0;
            if(!$pid || !$qty){
                echo json_encode(array("status" => "error"));
            }
            $attr_arr = array();
            if(!empty($attr_str)){
                $attr_arr = explode(',',$attr_str);
            }
            $processing_days = 0;
            $shipping_methods = $_POST['shipping_methods'] ? zen_db_input($_POST['shipping_methods']) : "";
            $weight = $_POST['weight'] ? $_POST['weight']:0;
            $config['pid'] = (int)$pid;
            $config['purchase_qty'] = $qty;
            if($length){
                $attr_arr['length'] = $length;
                $material_arr = sizeof($_POST['material_arr']) ? $_POST['material_arr'] : [];
                if($material_arr['materialProductsId']){
                    $config['material_data'] = get_relate_material_data($material_arr['materialProductsId'], $length, $qty);
                }
            }

            $shipping_info = new ShippingInfo($config);
            //详情页标准产品无库存获取动态交期 Dylan.2019.8.13
            $processing_days = $shipping_info->get_standard_product_details_days();
            $shipping_info->attr_option_arr = $attr_arr;
            $spring_days = $shipping_info->spring_festival_holiday();//春节假期
            if(!$processing_days){
                //根据属性匹配虚拟id
                if($attr_arr){ //定制产品交期不根据数量调取数据
                    //$products_id = attribute_matching_fictitious_id($pid,$attr_arr);
                    $processing_days = $shipping_info->get_processing_days();
                }else{
                    $processing_days = get_standard_product_days($pid,$qty);
                }
            }
            //$a = $shipping_info->getShippingDate();
            if($type==1){ //详情页运费
                $customized_price = $_POST['product_price'];
                if($customized_price){
                    $pure_price = $customized_price;
                }else{
                    $product_price = zen_get_products_final_price((int)$pid);
                    $pure_price = $product_price;
                }
                $shipping_info->weight = $weight ? $weight : $shipping_info->get_weight_for_prdoucts_id();
                if(strtolower($_SESSION['countries_iso_code']) == 'mx'){
                    $shipping_methods = '';
                }
                $shipping_info = $shipping_info->getShippingDayInfo($pure_price,$shipping_methods);
            }
            if($spring_days) {
                $total_days = get_specific_date_of_days((int)($processing_days+$transTime),2,$spring_days);  //获取春节假前工作日+周末总天数
                $total_days = $total_days+$spring_days;
                $total_days = postponed_weekend($total_days);  //加上春节假遇到周末顺延
                $ship_on = get_date_time_format($total_days);
            } else {
                $ship_on = get_specific_date_of_days((int)($processing_days+$transTime));
            }
            echo json_encode(array("status"=>"success","process_time"=>$processing_days,"ship_on"=>$ship_on,"shipping_info"=>$shipping_info));
            break;
    }
}