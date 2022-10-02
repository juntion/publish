<?php
function zen_get_order_total_item_of_id($oid){
    global $db;
    $order_total = array();
    $sql= "select title,text,value from orders_total where orders_id = '".$oid."' order by sort_order";
    $order = $db->Execute($sql);
    while (!$order->EOF){
        $order_total [] = array(
            'title'=>$order->fields['title'],
            'text'=>$order->fields['text'],
            'value'=>$order->fields['value']
        );
        $order->MoveNext();
    }
    return $order_total;
}

function zen_get_order_products_attr_of_custom($oid,$pid){
    global $db;
    $sql = " select  orders_products_id as opid from orders_products where orders_id ='". (int)$oid ."' and products_id ='". (int)$pid ."' ";
    $op = $db->Execute($sql);
    $opa = $db->Execute(" select products_options_values from  orders_products_attributes where orders_id ='". (int)$oid ."' and orders_products_id ='".$op->fields['opid']."' and products_options = '' ");
    return $opa->fields['products_options_values'];
}

function zen_get_order_products_price_of_order($oid,$pid){
    global $db;
    $order = $db->Execute("select products_price 
                         from orders_products 
                         where orders_id =". $oid ." and products_id =". $pid ." ");
    return $order->fields['products_price'];
}

//
/*
 * 查看各种状态订单的总个数
 * @para int/array $status: 订单状态id；
 * @para bool $is_has: 是否包这个状态id，默认是。否的话。就是不包含这个状态id。fairy 2018.12.18 add
 */
function zen_get_order_num_by_status($status,$is_has=true){
    global $db;
    $total = 0;
    $where = '';
    if($status==4) $where = ' AND is_reviewed=0 ';

    if(is_array($status)){
        $status_str = '('.implode(',',$status).')';
        if($is_has){
            $orders_status_where = ' orders_status in '.$status_str;
        }else{
            $orders_status_where = ' orders_status not in '.$status_str;
        }
    }else{
        if($is_has){
            $orders_status_where = ' orders_status='.(int)$status;
        }else{
            $orders_status_where = ' orders_status!='.(int)$status;
        }
    }

    $sql = "SELECT count(orders_id) as total FROM ".TABLE_ORDERS." WHERE ".$orders_status_where." AND main_order_id IN (0,1) AND mark=0 AND customers_id=:customersID {$where}";
    $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
    $res = $db->Execute($sql);
    $total = $res->fields['total'];
    return $total;
}

function zen_get_products_by_order_id($orders_id,$currency=''){
    global $db;
    $products = array();
    if(!$currency) $currency = fs_get_data_from_db_fields('currency','orders','orders_id='.(int)$orders_id,'limit 1');
    $sql="SELECT  orders_products_id,products_id,products_model,products_name,products_price,final_price,products_quantity,products_prid,composite_son_products,tax_after_price
			FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id = ".(int)$orders_id." order by orders_products_id";

    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            $attribute = array();

            $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
				options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "'";
            $attr_res = $db->Execute($attributes_query);
            while (!$attr_res->EOF) {
                $attribute[] = array(
                    'option' => $attr_res->fields['products_options'],
                    'value' => $attr_res->fields['products_options_values'],
                    'option_id' => $attr_res->fields['products_options_id'],
                    'value_id' => $attr_res->fields['products_options_values_id'],
                    'prefix' => $attr_res->fields['price_prefix'],
                    'price' => $attr_res->fields['options_values_price']
                );
                $attr_res->MoveNext();
            }
            $length_query = "select length_name,length_price,price_prefix from order_product_length where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "' limit 1";
            $length_res = $db->Execute($length_query);
            if($length_res->RecordCount()){
                $attribute[] = array(
                    //'option' => $length_res->fields['length_name'],
                    //'value' => 'length',

                    'option' => FS_LENGTH,
                    'value' => $length_res->fields['length_name'],
                    'option_id' => '',
                    'value_id' => '',
                    'prefix' => $length_res->fields['price_prefix'],
                    'price' => $length_res->fields['length_price']
                );
            }
            $pro_name = str_replace(' ',' ',$get_products->fields['products_name']);
            if(!$pro_name) $pro_name = fs_get_data_from_db_fields('products_name',TABLE_PRODUCTS_DESCRIPTION,'products_id='.$get_products->fields['products_id'].' and language_id='.$_SESSION['languages_id'],'limit 1');
            //产品的最终价格 返回对应币种保留小数位操作后的美元价格 不然有的币种的价格会存在0.01的误差
//            $final_price = get_one_products_currency_price($get_products->fields['final_price'], $currency);
            $proInfo = fs_get_data_from_db_fields_array(array('products_image','is_heavy'),TABLE_PRODUCTS,'products_id='.$get_products->fields['products_id'],'limit 1');
            $products [] = array(
                'id' => $get_products->fields['products_id'],
                'prid' => $get_products->fields['products_prid'],
                'orders_products_id' => $get_products->fields['orders_products_id'],
                'composite_son_products' => $get_products->fields['composite_son_products'],
                'products_model' => $get_products->fields['products_model'],
                'products_name' => str_replace(' ',' ',$pro_name),
                'products_price' => $get_products->fields['products_price'],
                'products_image' => $proInfo[0][0],
                'is_heavy' => $proInfo[0][1],
                'products_price_tax' => $get_products->fields['tax_after_price'],
                'final_price' => $get_products->fields['final_price'],
                'qty' => $get_products->fields['products_quantity'],
                'attribute' => $attribute,
            );
            $get_products->MoveNext();
        }
    }
    return $products;

}
function zen_get_all_reorder_products($orders_id,$orders_products_id=''){
    global $db;
    $products = array();
    if($orders_products_id){ //单个订单产品加入购物车
        $where = ' orders_products_id = '.$orders_products_id;
    }else{
        $where = ' orders_id = '.$orders_id;
    }
    $sql="SELECT  orders_products_id,products_id,products_name,products_quantity FROM ".TABLE_ORDERS_PRODUCTS . " 
			 WHERE  ".$where." order by orders_products_id";

    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            if($orders_products_id){ //单个订单产品加入购物车
                $where = " orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "'";
            }else{
                $where =  " orders_id = '" . (int)$orders_id . "' and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "'";
            }
            $attribute = array();
            $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
				options_values_price, price_prefix,upload_file from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where ".$where;
            $attr_res = $db->Execute($attributes_query);
            while (!$attr_res->EOF) {
                $option_id = $attr_res->fields['products_options_id'];
                $value_id = $attr_res->fields['products_options_values_id'];
                //获取当前属性的类型   如果是checkbox则用数组接收
                $products_options_type = fs_get_data_from_db_fields('products_options_type',TABLE_PRODUCTS_OPTIONS,'products_options_id='.$option_id);
                if($products_options_type ==3){
                    $attribute[$option_id][$value_id] = $value_id;
                }else{
                    //标签产品客户填写的内容
                    if($attr_res->fields['upload_file']){
                        $attribute['upload_prefix_'.$option_id] = array(
                            'products_options_value_text'=>$attr_res->fields['products_options_values'],
                            'upload_file'=>$attr_res->fields['upload_file']
                        );
                    }elseif ($value_id ==0){
                        $attribute['text_prefix_'.$option_id] = $attr_res->fields['products_options_values'];
                    }else{
                        $attribute[$option_id] = $value_id;
                    }
                }
                $attr_res->MoveNext();
            }
            $length_query = "select length_name,length_price,price_prefix from order_product_length where " .$where. " limit 1";
            $length_res = $db->Execute($length_query);
            $length = '';
            if($length_res->RecordCount()){
                $length = $length_res->fields['length_name'];
            }
            if($length){
                $attribute['length'] = fs_get_data_from_db_fields('id','products_length','length="'.$length.'" and product_id='.$get_products->fields['products_id'],'limit 1');
            }

            $products [] = array(
                'id' => $get_products->fields['products_id'],
                'name' => $get_products->fields['products_name'],
                'qty' => $get_products->fields['products_quantity'],
                'attribute' => $attribute,
            );
            $get_products->MoveNext();
        }
    }
    return $products;

}

function zen_get_all_son_order_id($order_id){
    global $db;
    $son_order = array();
    $main_id = fs_get_data_from_db_fields('main_order_id',TABLE_ORDERS,'orders_id='.$order_id,'limit 1');
    if($main_id==1){
        $son_sql = "SELECT orders_id FROM   " . TABLE_ORDERS . " WHERE main_order_id=".$order_id." ORDER BY orders_id ASC ";
        $res = $db->Execute($son_sql);
        while(!$res->EOF){
            $son_order[] = $res->fields['orders_id'];
            $res->MoveNext();
        }
    }
    return $son_order;
}

function zen_get_all_son_order_split_id($order_id){
    global $db;
    $son_order = array();
    $main_id = fs_get_data_from_db_fields('split_main_id',TABLE_ORDERS_SPLIT,'orders_id='.$order_id,'limit 1');
    if($main_id==1){
        $son_sql = "SELECT orders_id FROM   " . TABLE_ORDERS_SPLIT . " WHERE split_main_id=".$order_id." ORDER BY orders_id ASC ";
        $res = $db->Execute($son_sql);
        while(!$res->EOF){
            $son_order[] = $res->fields['orders_id'];
            $res->MoveNext();
        }
    }
    return $son_order;
}
//
/*
 * 根句主订单查找所有的分订单信息
 * fairy 2019.3.21 去掉用户id的限制，因为有公司用户情况，不能只针对当前用户
 */
function zen_get_all_son_order_by_main_order($order_id){
    global $db;
    $son_order = array();
    $son_sql = "SELECT o.orders_id,o.date_purchased,  o.customers_id,o.delivery_name,o.customers_name,o.purchase_order_num,
				o.delivery_name,o.delivery_lastname,o.delivery_company,o.delivery_street_address,o.delivery_suburb,o.is_reissue,
				o.delivery_city,o.delivery_postcode,o.delivery_state,o.delivery_country,o.delivery_telephone, o.billing_name, o.billing_country,ot.text as order_total,s.orders_status_name, o.orders_status, o.orders_number,o.currency,o.currency_value,o.payment_module_code
	            FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s WHERE  o.orders_id = ot.orders_id  
				AND o.orders_status = s.orders_status_id  AND o.main_order_id=".$order_id."
	            AND ot.class = 'ot_total' AND   s.language_id = ".$_SESSION['languages_id']." ORDER BY orders_id ASC ";
    $son_res = $db->Execute($son_sql);
    while(!$son_res->EOF){
        $products = zen_get_products_by_order_id($son_res->fields['orders_id'],$son_res->fields['currency']);
        $track_arr = zen_get_track_number_by_order($son_res->fields['orders_id']);
        $is_gift_order = false;	//赠品单标识
        if(in_array($son_res->fields['is_reissue'],[22,23])){
            $is_gift_order = true;
        }
        $son_order[] = array(
            'orders_id' => $son_res->fields['orders_id'],
            'orders_number' => $son_res->fields['orders_number'],
            'orders_status_id' => $son_res->fields['orders_status'],
            'orders_status_name' => $son_res->fields['orders_status_name'],
            'order_total' => $son_res->fields['order_total'],
            'track_number' => $track_arr['tracking_number'],
            'track_method' => $track_arr['shipping_method'],
            'customers_id'=>$son_res->fields['customers_id'],
            'delivery_name'=>$son_res->fields['delivery_name'],
            'delivery_lastname'=>$son_res->fields['delivery_lastname'],
            'delivery_company'=>$son_res->fields['delivery_company'],
            'delivery_street_address'=>$son_res->fields['delivery_street_address'],
            'delivery_suburb'=>$son_res->fields['delivery_suburb'],
            'delivery_city'=>$son_res->fields['delivery_city'],
            'delivery_postcode'=>$son_res->fields['delivery_postcode'],
            'delivery_state'=>$son_res->fields['delivery_state'],
            'delivery_country'=>$son_res->fields['delivery_country'],
            'delivery_telephone'=>$son_res->fields['delivery_telephone'],
            'purchase_order_num'=>$son_res->fields['purchase_order_num'],
            'date_purchased'=>$son_res->fields['date_purchased'],
            'customers_name' => $son_res->fields['customers_name'],
            'payment_module_code' => $son_res->fields['payment_module_code'],
            'currency' => $son_res->fields['currency'],
            'currency_value' => $son_res->fields['currency_value'],
            'is_reissue' => $son_res->fields['is_reissue'],
            'is_gift_order' => $is_gift_order,
            'products' => $products,
        );
        $son_res->MoveNext();
    }
    return $son_order;
}
//根据订单ID查找订单相关信息
function zen_get_order_info_by_order_id($order_id){
    global $db;
    $order = array();
    $sql = "SELECT o.orders_id,o.date_purchased,o.customers_id,o.delivery_name,o.customers_name,o.purchase_order_num,o.customers_po,o.payment_method,o.delivery_name,
		o.delivery_lastname,o.delivery_company,o.delivery_street_address,o.delivery_suburb,o.delivery_city,o.delivery_tax_number,o.shipping_method,o.d_tel_prefix,
		o.delivery_postcode,o.delivery_state,o.delivery_country,o.delivery_country_id,o.delivery_telephone, o.billing_name,o.billing_country,o.billing_lastname,o.is_reissue,main_order_id,
		o.billing_company,o.billing_company_type,o.billing_street_address,o.billing_suburb,o.billing_postcode,o.billing_state,o.billing_telephone,o.billing_tax_number,o.customers_remarks,
		o.b_tel_prefix,ot.text as order_total,s.orders_status_name, o.orders_status, o.orders_number,o.currency,o.currency_value,o.payment_module_code,o.warehouse,
		o.billing_city,o.logo_file,o.is_reviewed,o.is_au_gsp FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s WHERE  o.orders_id = ot.orders_id  
		AND o.orders_status = s.orders_status_id AND o.orders_id=".$order_id."
	    AND ot.class = 'ot_total' AND   s.language_id = ".$_SESSION['languages_id']." ORDER BY orders_id DESC LIMIT 1";
    $res = $db->Execute($sql);
    while(!$res->EOF){
        $products = zen_get_products_by_order_id($res->fields['orders_id'],$res->fields['currency']);
        $track_arr = zen_get_track_number_by_order($res->fields['orders_id']);
        if($res->fields['delivery_country_id']){
            $delivery_country_id =$res->fields['delivery_country_id'];
        }else{
            $delivery_country_id = fs_get_country_id_of_code($_SESSION['countries_iso_code']);
        }
        $delivery_country = get_countries_name($delivery_country_id);
        $billing_country = getCountryNameByCode($res->fields['billing_country']);
        $origin_billing_country = $res->fields['billing_country'];
        $is_gift_order = false;
        if(in_array($res->fields['is_reissue'],[22,23])){
            $is_gift_order = true;
        }
        $order = array(
            'orders_id' => $res->fields['orders_id'],
            'orders_number' => $res->fields['orders_number'],
            'orders_status_id' => $res->fields['orders_status'],
            'orders_status_name' => $res->fields['orders_status_name'],
            'order_total' => $res->fields['order_total'],
            'main_order_id' => $res->fields['main_order_id'],
            'track_number' => $track_arr['tracking_number'],
            'track_method' => $track_arr['shipping_method'],
            'customers_id'=>$res->fields['customers_id'],
            'delivery_name'=>$res->fields['delivery_name'],
            'delivery_lastname'=>$res->fields['delivery_lastname'],
            'delivery_company'=>$res->fields['delivery_company'],
            'delivery_street_address'=>$res->fields['delivery_street_address'],
            'delivery_suburb'=>$res->fields['delivery_suburb'],
            'delivery_city'=>$res->fields['delivery_city'],
            'delivery_postcode'=>$res->fields['delivery_postcode'],
            'delivery_state'=>$res->fields['delivery_state'],
            'd_tel_prefix'=>$res->fields['d_tel_prefix'],
            'billing_city'=>$res->fields['billing_city'],
            'delivery_country'=>$delivery_country,
            'delivery_country_id'=>$delivery_country_id,
            'delivery_telephone'=>$res->fields['delivery_telephone'],
            'delivery_tax_number'=>$res->fields['delivery_tax_number'],
            'billing_name'=>$res->fields['billing_name'],
            'billing_lastname'=>$res->fields['billing_lastname'],
            'billing_country'=>$billing_country,
            'billing_company'=>$res->fields['billing_company'],
            'billing_street_address'=>$res->fields['billing_street_address'],
            'billing_suburb'=>$res->fields['billing_suburb'],
            'billing_postcode'=>$res->fields['billing_postcode'],
            'billing_state'=>$res->fields['billing_state'],
            'billing_telephone'=>$res->fields['billing_telephone'],
            'billing_tax_number'=>$res->fields['billing_tax_number'],
            'billing_company_type'=>$res->fields['billing_company_type'],
            'b_tel_prefix'=>$res->fields['b_tel_prefix'],
            'purchase_order_num'=>$res->fields['purchase_order_num'],
            'date_purchased'=>$res->fields['date_purchased'],
            'customers_name' => $res->fields['customers_name'],
            'payment_module_code' => $res->fields['payment_module_code'],
            'payment_method' => $res->fields['payment_method'],
            'currency' => $res->fields['currency'],
            'currency_value' => $res->fields['currency_value'],
            'customers_po' => $res->fields['customers_po'],
            'is_reissue' => $res->fields['is_reissue'],
            'customers_remarks' => $res->fields['customers_remarks'],
            'shipping_method' => $res->fields['shipping_method'],
            'logo_file' => $res->fields['logo_file'],
            'warehouse' => $res->fields['warehouse'],
            'products' => $products,
            'is_reviewed' => $res->fields['is_reviewed'],
            'is_au_gsp' => $res->fields['is_au_gsp'],
            'is_gift_order' => $is_gift_order,
            'origin_billing_country' => $origin_billing_country
        );
        $res->MoveNext();
    }
    return $order;
}




//根据订单ID获取运单物流号
function zen_get_track_number_by_order($order_id){
    global $db;
    $shipping_arr = array();
    $sql = "SELECT shipping_method,tracking_number FROM `order_tracking_info` WHERE orders_id=".$order_id." limit 1";
    $res = $db->Execute($sql);
    $shipping_arr['tracking_number'] = $res->fields['tracking_number'];
    $shipping_arr['shipping_method'] = $res->fields['shipping_method'];
    return $shipping_arr;
}
//新增一个参数  判断是否需要查询 value  默认为false
function zen_get_order_cost_by_order($order_id,$is_need_value = false){
    global $db;
    $cost_data = array();
    $cost_sql = "select text,value,class from orders_total where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        if($is_need_value){
            $cost_data[$res->fields['class']] = array(
                'text' =>  $res->fields['text'],
                'value' => $res->fields['value'],
            );
        }else{
            $cost_data[$res->fields['class']] = $res->fields['text'];
        }
        $res->MoveNext();
    }
    return $cost_data;
}

//澳大利亚 -- 获取订单税后价
function zen_get_order_au_tax_order($order_id){
    global $db;
    $cost_data = array();
    $cost_sql = "select text,value,class from orders_total_tax where orders_id=".(int)$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        $cost_data[$res->fields['class']] = array(
            'text' =>  $res->fields['text'],
            'value' => $res->fields['value'],
        );
        $res->MoveNext();
    }
    return $cost_data;
}

/**
 * 查询税后总价
 * @param $order_id
 * @param bool $is_need_value
 * @return array
 */
function zen_get_order_costTax_by_order($order_id){
    global $db;
    $cost_data = array();
    $cost_sql = "select text,value,class from orders_total_tax where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        $cost_data[$res->fields['class']] = array(
            'text' =>  $res->fields['text'],
            'value' => $res->fields['value'],
        );
        $res->MoveNext();
    }
    return $cost_data;
}

function zen_get_order_split_cost_by_order($order_id,$is_need_value = false){
    global $db;
    $cost_data = array();
    $cost_sql = "select text,value,class from orders_split_total where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        if($is_need_value){
            $cost_data[$res->fields['class']] = array(
                'text' =>  $res->fields['text'],
                'value' => $res->fields['value'],
            );
        }else{
            $cost_data[$res->fields['class']] = $res->fields['text'];
        }
        $res->MoveNext();
    }
    return $cost_data;
}

function zen_get_order_value_by_order($order_id){
    global $db;
    $cost_data = array();
    $cost_sql = "select value,class from orders_total where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        $cost_data[$res->fields['class']] = $res->fields['value'];
        $res->MoveNext();
    }
    return $cost_data;
}

function zen_get_order_split_value_by_order($order_id){
    global $db;
    $cost_data = array();
    $cost_sql = "select value,class from orders_split_total where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        $cost_data[$res->fields['class']] = $res->fields['value'];
        $res->MoveNext();
    }
    return $cost_data;
}

function zen_get_order_history_status($oid,$status){
    global $db;
    $sql='select date_added from orders_status_history where orders_id ='.(int)$oid.' and orders_status_id = '.(int)$status.' order by date_added desc limit 1';
    $orders =  $db->Execute($sql);
    if($orders->fields['date_added']){
        return $orders->fields['date_added'];
    }
}

//PO订单上传附件成功发送邮件
function send_email($order_id){
    require(DIR_WS_CLASSES.'order.php');
    $order = new Order($order_id);
    $html_msg['SHIPPING_INFO'] = '<div style="padding-bottom: 13px;font-size:12px;">'.$order->delivery['name'].'</div>'.
        '<div style="line-height: 20px;color: #616265;padding-bottom: 10px;font-size:12px;">'. (($order->delivery['company'])?$order->delivery['company'] : '').'<br />'.
        $order->delivery['street_address'].' '.$order->delivery['suburb'].'<br />'. $order->delivery['city'].' , '.$order->delivery['postcode'] .'<br />'.
        (($order->delivery['state']) ? $order->delivery['state'].' , ' : '').' '.$order->delivery['country'] .($order->delivery['tax_number'] ? '<br>'.EMAIL_BODY_COMMON_TAX_NUMBER.': '.$order->delivery['tax_number'] : ''). '</div>'
        .'<div style="color: #616265;font-size:12px;">'. (($order->delivery['telephone']) ? 'Phone : '.$order->delivery['tel_prefix'].'-'.$order->delivery['telephone'] : '') .'</div>';
    global $currencies;
    $son_order = array();
    $son_order = zen_get_all_son_order_id($order_id);
    if(!count($son_order)){
        $son_order[] = $order_id;
    }
    $email_html=zen_get_corresponding_languages_email_common();
    $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
    $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];
    $html = '';
    $orderNumerHtml = $orderHtml = $emialTitle = $order_number_html = '';
    $orderKey = 0;
    foreach($son_order as $key=>$id){
        $orderKey++;
        $fields = array('orders_number','currency','currency_value','shipping_method');
        $order_data = fs_get_data_from_db_fields_array($fields,'orders','orders_id='.$id,'limit 1');

        $orderNumerHtml .= '#'.$order_data[0][0].' & ';
        $orderHtml .= '#'.$order_data[0][0];
        $order_number_html .= $order_data[0][0].' & ';
    }
    $orderNumerHtml = trim($orderNumerHtml);
    $orderNumerHtml	= trim($orderNumerHtml,'&');
    $order_number_html = trim($order_number_html);
    $order_number_html	= trim($order_number_html,'&');
    $html .= '<tr>
	<td>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" >
			<thead>
				<tr style="height: 0;">
					<td width="50%"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="font-size: 14px;border-bottom: 1px solid #e5e5e5;padding-bottom: 10px;padding-top: 21px;" align="left">
						<span style="color: #616265;">Order NO:</span> '.$order_number_html.'
					</td>
				</tr>
			</tbody>
		</table>
	</td>
	</tr>';
    $orderNumerHtml = trim($orderNumerHtml);
    $orderNumerHtml	= trim($orderNumerHtml,'&');
    $orderHtml = trim($orderHtml);
    $orderHtml	= trim($orderHtml,'&');
    $cost_data = zen_get_order_cost_by_order($order_id);
    $order_data = fs_get_data_from_db_fields_array(array('purchase_order_num','customers_id'),'orders','orders_id='.$order_id,'limit 1');
    $po_number = $order_data[0][0];
    $html_msg['PO_NUMBER'] = $po_number;
    $html_msg['PO_ALL_ORDER'] = $orderHtml;
    $html_msg['PRODUCT_INFO'] = $html;
    $html_msg['SUBTOTAL'] = $cost_data['ot_subtotal'];
    $html_msg['SHIPPING_TOTAL'] = $cost_data['ot_shipping'];
    $html_msg['TOTAL'] = $cost_data['ot_total'];
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_THANK'] = EMAIL_CHECKOUT_WAREHOUSE_THANK;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_LIVE'] = EMAIL_CHECKOUT_WAREHOUSE_LIVE;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_WITH'] = EMAIL_CHECKOUT_WAREHOUSE_WITH;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_SIN'] = EMAIL_CHECKOUT_WAREHOUSE_SIN;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_DEAR'] = EMAIL_CHECKOUT_WAREHOUSE_DEAR;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_TEAM'] = EMAIL_CHECKOUT_WAREHOUSE_TEAM;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_CONCAT'] = FS_EMAIL_MY_PO_UP_CONTACT;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_YOUR'] = EMAIL_CHECKOUT_WAREHOUSE_YOUR;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_UP'] = EMAIL_CHECKOUT_WAREHOUSE_UP;
    $html_msg['EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO'] = EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_INVOICE'] = EMAIL_CHECKOUT_WAREHOUSE_INVOICE;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_ORDERS'] = EMAIL_CHECKOUT_WAREHOUSE_ORDERS;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_NOW'] = EMAIL_CHECKOUT_WAREHOUSE_NOW;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_CHARGES'] = EMAIL_CHECKOUT_WAREHOUSE_CHARGES;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_TOTAL'] = EMAIL_CHECKOUT_WAREHOUSE_TOTAL;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_PROCESS'] = EMAIL_CHECKOUT_WAREHOUSE_PROCESS;
    $html_msg['EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL'] = EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL;
    $html_msg['EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER']= EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER;
    $html_msg['EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY'] = EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY;
    $html_msg['FS_EMAIL_PERIOD'] = FS_EMAIL_PERIOD;
    $html_msg['FS_EMAIL_COMMA'] = FS_EMAIL_COMMA;
    $vat_html = '';
    if($cost_data['ot_tax']){
        $vat_html = '<td style="padding-bottom: 3px;font-size:12px;">'.EMAIL_CHECKOUT_COMMON_VAT_COST.':</td>
					 <td style="text-align: right;padding-bottom: 3px;font-size:12px;">'.$cost_data['ot_tax'].'</td>';
    }
    $html_msg['VAT_TEXT'] = $vat_html;
    $customer_id = $order_data[0][1];
    if(!$customer_id){
        $customer_id = $_SESSION['customer_id'];
    }
    $customer_name = '';
    $customer_email_address = '';
    if($customer_id){
        $customer_fields = array('customers_firstname','customers_lastname','customers_email_address');
        $customer = fs_get_data_from_db_fields_array($customer_fields,'customers','customers_id='.$customer_id,'limit 1');
        $customer_name = $customer[0][0].' '.$customer[0][1];
        $customer_email_address = $customer[0][2];
    }
    $html_msg['NAME'] = $customer_name;
    zen_mail($customer_name, $customer_email_address, 'FS.COM - PO'.$orderNumerHtml.' '.EMAIL_CHECKOUT_PO, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_purchase', $attachArray);

    if($_SESSION['customer_id']){
        $admin_id = zen_get_customer_has_allot_to_admin($_SESSION['customer_id']);
    }

    if($admin_id){
        define('EMAIL_SUBJECT', 'FS.COM Order# '.$info['orders_number']);
        $admin_name = zen_get_admin_name_of_id($admin_id);
        $admin_email = zen_get_admin_email_of_name($admin_name);
        zen_mail($admin_name, $admin_email, 'FS.COM - PO'.$orderNumerHtml.' '.EMAIL_CHECKOUT_PO, $email_order, STORE_NAME, EMAIL_FROM, $html_msg, 'checkout_purchase', $attachArray);
    }
}
//得到未评价过的产品信息
function zen_get_no_orders_reviews_by_order_id($orders_id){
    global $db;
    $products = array();
    $sql="SELECT  op.orders_products_id,op.products_id,products_name FROM ".TABLE_ORDERS_PRODUCTS . " op left join reviews r on(op.orders_products_id=r.orders_products_id) 
			 WHERE  orders_id in( ".implode(',',$orders_id)." ) and reviews_id IS NULL order by orders_products_id";
    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            $products [] = array(
                'orders_products_id' => $get_products->fields['orders_products_id'],
                'id' => $get_products->fields['products_id'],
                'products_name' => $get_products->fields['products_name'],
                'products_image' => fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$get_products->fields['products_id'],'limit 1'),
            );
            $get_products->MoveNext();
        }
    }
    return $products;
}



//得到评价过的产品信息
function zen_get_orders_reviews_by_order_id($orders_id){
    global $db;
    $products = array();
    $sql="SELECT  op.orders_products_id,op.products_id,products_name FROM ".TABLE_ORDERS_PRODUCTS . " op left join reviews r on(op.orders_products_id=r.orders_products_id) 
			 WHERE  orders_id in( ".implode(',',$orders_id)." ) and reviews_id IS NOT NULL order by reviews_id ASC";
    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            $products [] = array(
                'orders_products_id' => $get_products->fields['orders_products_id'],
                'id' => $get_products->fields['products_id'],
                'products_name' => $get_products->fields['products_name'],
                'products_image' => fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$get_products->fields['products_id'],'limit 1'),
            );
            $get_products->MoveNext();
        }
    }
    return $products;

}
function zen_get_product_by_instock_id($pid){
    global $db;
    $products_arr = array();
    $sql = "select pisi.orders_products_id from products_instock_shipping as pis left join products_instock_shipping_info as pisi on(pis.products_instock_id=pisi.products_instock_id)
                 where pis.products_instock_id=".$pid."";
    $products_res = $db->Execute($sql);
    if($products_res->RecordCount()){
        while (!$products_res->EOF){
            $products = zen_get_products_by_orders_products_id($products_res->fields['orders_products_id']);
            $products_arr[] = array(
                'products'=>$products
            );
            $products_res->MoveNext();
        }
    }
    return $products_arr;
}

function zen_get_products_by_orders_products_id($orders_products_id){
    global $db;
    $products = array();
    $sql="SELECT  orders_products_id,orders_id,products_id,products_model,products_name,products_price,final_price,products_quantity FROM ".TABLE_ORDERS_PRODUCTS . " 
			 WHERE  orders_products_id = ".$orders_products_id."";

    $get_products = $db->Execute($sql);
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            $attribute = array();
            $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
				options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$get_products->fields['orders_id'] . "' 
				and orders_products_id = '" . (int)$orders_products_id . "'";
            $attr_res = $db->Execute($attributes_query);
            while (!$attr_res->EOF) {
                $attribute[] = array(
                    'option' => $attr_res->fields['products_options'],
                    'value' => $attr_res->fields['products_options_values'],
                    'option_id' => $attr_res->fields['products_options_id'],
                    'value_id' => $attr_res->fields['products_options_values_id'],
                    'prefix' => $attr_res->fields['price_prefix'],
                    'price' => $attr_res->fields['options_values_price']
                );
                $attr_res->MoveNext();
            }
            $length_query = "select length_name,length_price,price_prefix from order_product_length where orders_id = '" . (int)$get_products->fields['orders_id'] . "' 
				and orders_products_id = '" . (int)$orders_products_id . "' limit 1";
            $length_res = $db->Execute($length_query);
            if($length_res->RecordCount()){
                $attribute[] = array(
                    'option' => $length_res->fields['length_name'],
                    'value' => 'length',
                    'option_id' => $length_res->fields['products_options_id'],
                    'value_id' => '',
                    'prefix' => $length_res->fields['price_prefix'],
                    'price' => $length_res->fields['length_price']
                );
            }
            $products [] = array(
                'id' => $get_products->fields['products_id'],
                'products_model' => $get_products->fields['products_model'],
                'products_name' => $get_products->fields['products_name'],
                'products_price' => $get_products->fields['products_price'],
                'products_image' => fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$get_products->fields['products_id'],'limit 1'),
                'final_price' => $get_products->fields['final_price'],
                'qty' => $get_products->fields['products_quantity'],
                'attribute' => $attribute
            );
            $get_products->MoveNext();
        }
    }
    return $products;
}

//获取退换货的所有产品信息
function zen_get_all_rma_products($sid,$currency = '',$currency_value = ''){
    global $db,$currencies;
    $products = array();
    $orders_id = fs_get_data_from_db_fields('orders_id','customers_service','customers_service_id='.$sid,'limit 1');
    $products_sql = "SELECT products_id,orders_products_id,products_num,reasons_type,customers_service_content,images,service_number FROM customers_service_products WHERE service_id=".$sid." ORDER BY id";
    $res = $db->Execute($products_sql);
    // 2019-10-28 potato 查询用户是否打折
    $customers_id = fs_get_data_from_db_fields('customers_id','orders','orders_id='.(int)$orders_id);
    $customer_rate_info = fs_get_data_from_db_fields_array(['discount_rate', 'member_level'], 'customers', "customers_id=" . (int)$customers_id, "");
    $rate = '';
    if ($customer_rate_info && $customer_rate_info[0][0] > 0 && $customer_rate_info[0][1])  $rate = $customer_rate_info[0][0];
    while(!$res->EOF){
        $orders_products_id = $res->fields['orders_products_id'];
        $products_id = $res->fields['products_id'];
        if($orders_products_id==0 && (int)$orders_id){
            $result = $db->Execute("select orders_products_id from orders_products where orders_id=".$orders_id." and products_id=".$res->fields['products_id']." limit 1");
            $orders_products_id = $result->fields['orders_products_id'];
        }
        if($orders_products_id){
            $attribute = array();
            $attr_res = $db->Execute("select products_options_id, products_options_values_id, products_options, products_options_values,options_values_price,price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" .(int)$orders_products_id . "'");
            while(!$attr_res->EOF){
                $attribute[] = array(
                    'option' => $attr_res->fields['products_options'],
                    'value' => $attr_res->fields['products_options_values'],
                    'option_id' => $attr_res->fields['products_options_id'],
                    'value_id' => $attr_res->fields['products_options_values_id'],
                    'prefix' => $attr_res->fields['price_prefix'],
                    'price' => $attr_res->fields['options_values_price']
                );
                $attr_res->MoveNext();
            }
            $length_query = "select length_name,length_price,price_prefix from order_product_length where 
				orders_products_id = '" . (int)$orders_products_id . "' limit 1";
            $length_res = $db->Execute($length_query);
            if($length_res->RecordCount()){
                $attribute[] = array(
                    'option' => $length_res->fields['length_name'],
                    'value' => 'length',
                    'prefix' => $length_res->fields['price_prefix'],
                    'price' => $length_res->fields['length_price']
                );
            }
            $pRes = $db->Execute("SELECT  orders_products_id,products_id,products_model,products_name,products_price,final_price,products_quantity,products_prid,composite_son_products FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_products_id = ".$orders_products_id." limit 1");

            $products[$orders_products_id.'_'.$products_id] = array(
                'products_id' => $res->fields['products_id'],
                'products_name' => $pRes->fields['products_name'],
                'products_price' => $currencies->fs_format_new($pRes->fields['products_price'],'true',$currency,$currency_value),
                'products_image' => fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.(int)$res->fields['products_id'],'limit 1'),
                'final_price' => $currencies->fs_format_new($pRes->fields['final_price'],'true',$currency,$currency_value),
                'orders_products_id' => $orders_products_id,
                'products_num' => $res->fields['products_num'],
                'reasons_type' => $res->fields['reasons_type'],
                'service_content' => $res->fields['customers_service_content'],
                'images' => $res->fields['images'],
                'service_number' => $res->fields['service_number'],
                'currency' => $currency,
                'currency_value' => 1,
                'attribute' => $attribute,
                'is_fms' => 0
            );

            if(!empty($pRes->fields['composite_son_products'])){//组合产品
                //默认为美元价格,列表页重新计算
                $pRes_real = get_return_fms_children_products($pRes->fields['composite_son_products'],$currency,$res->fields['products_id'], $rate); // $rate为组合产品的打折
                $products[$orders_products_id.'_'.$products_id]['products_price'] = $pRes_real['products_price'];
                $products[$orders_products_id.'_'.$products_id]['final_price'] = $pRes_real['products_price'];
                $products[$orders_products_id.'_'.$products_id]['products_name'] = $pRes_real['products_name'];
                $products[$orders_products_id.'_'.$products_id]['is_fms'] = 1;
                $products[$orders_products_id.'_'.$products_id]['currency_value'] = 1;
            }

        }
        $res->MoveNext();
    }
    return $products;
}

function zen_get_customers_service_products($oid){
    global $db;
    $pid = array();
    $res = $db->Execute("select cs.customers_service_id as id,cs.service_type_id,cs.service_status,csp.products_id,csp.orders_products_id,csp.products_num,op.products_id as zpid,op.composite_son_products from customers_service cs left join customers_service_products csp on cs.customers_service_id=csp.service_id left join orders_products op on csp.orders_products_id = op.orders_products_id where cs.customers_id=".$_SESSION['customer_id']." and cs.orders_id=".(int)$oid);
    while(!$res->EOF){
        if($res->fields['products_id']){
            if(!empty($res->fields['composite_son_products'])) {//组合产品
                $key = $res->fields['orders_products_id'];
                if ($key == 0) {
                    $opRes = $db->Execute("select orders_products_id from orders_products where orders_id=" . $oid . " and products_id=" . $res->fields['zpid'] . " limit 1");
                    $key = $opRes->fields['orders_products_id'];
                }
                $products_id = $res->fields['products_id'];
                if ($res->fields['service_type_id'] == 1 && $res->fields['service_status'] != 7) {
                    $pid[$key][$products_id] += $res->fields['products_num'];
                } else {
                    if (in_array($res->fields['service_status'], array(1, 9, 3, 4, 5, 10))) {
                        $pid[$key][$products_id] += $res->fields['products_num'];
                    }
                }
            }else{
                $key = $res->fields['orders_products_id'];
                if ($key == 0) {
                    $opRes = $db->Execute("select orders_products_id from orders_products where orders_id=" . $oid . " and products_id=" . $res->fields['products_id'] . " limit 1");
                    $key = $opRes->fields['orders_products_id'];
                }
                if ($res->fields['service_type_id'] == 1 && $res->fields['service_status'] != 7) {
                    $pid[$key] += $res->fields['products_num'];
                } else {
                    if (in_array($res->fields['service_status'], array(1, 9, 3, 4, 5, 10))) {
                        $pid[$key] += $res->fields['products_num'];
                    }
                }
            }
        }
        $res->MoveNext();
    }
    return $pid;
}
//获取已经评价过的产品
function get_all_reviews_order_product($order_id){
    global $db;
    $products = array();
    $son_order = zen_get_all_son_order_id($order_id);
    $son_order[] = $order_id;
    $sql = "SELECT orders_products_id,products_id FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id IN (".join(',',$son_order).") order by orders_products_id";
    $res = $db->Execute($sql);
    while(!$res->EOF){
        $products[$res->fields['orders_products_id']] = $res->fields['products_id'];
        $res->MoveNext();
    }
    return $products;
}

//获取
function zen_get_all_logo_products(){
    global $db;
    $products = $logo_products = array();
    $sql = "SELECT ptc.products_id  FROM `products_to_categories` ptc LEFT JOIN `products_narrow_by_option_values_to_products` vtp on(ptc.products_id=vtp.products_id) WHERE ptc.categories_id=3058 AND vtp.`products_narrow_by_options_values_id` = 20610";
    $result = $db->Execute($sql);
    if($result->RecordCount()){
        while(!$result->EOF){
            $logo_products[] = $result->fields['products_id'];
            $result->MoveNext();
        }
    }
    if(sizeof($logo_products)){
        $res = $db->Execute("SELECT products_id FROM products WHERE products_status=1 AND products_id IN (".join(',',$logo_products).")");
        while(!$res->EOF){
            $products[] = $res->fields['products_id'];
            $res->MoveNext();
        }
    }
    return $products;
}

//订单详情页不同状态展示当地的时间
function zen_get_country_stand_time($oID, $status, $code, $format='m/d/Y g:i a'){
    $local_time = $time = '';
    $timezone_out = date_default_timezone_get();
    $time = zen_get_order_history_status($oID,$status);
    // if($_SERVER['HTTP_HOST']=='www.fs.com'){
    //     //线上mysql时区是UTC标准时区
    //     $timezone = 'Etc/GMT';
    // }else{
    //     //测试站mysql时区是北京时间
    //     $timezone = 'Asia/Shanghai';
    // }
    $timezone = 'Asia/Shanghai';
    $local_time = zen_show_local_time($time,$code,$format,$timezone);
    if($code=='US' && $local_time){
        //订单详情页节点时间 美国展示华特拉州时间 后面加上EST标识
        $local_time .= ' EST';
    }
    return $local_time;
}

function zen_show_local_time($time, $code, $format='m/d/Y g:i a', $timezone='Etc/GMT', $countryZone = ''){
    $local_time = '';
    if($time){
        //先获取当前时区
        $timezone_out = date_default_timezone_get();
        //设置时间参数的时区
        date_default_timezone_set($timezone);
        $time_stamp = strtotime($time);
        date_default_timezone_set($timezone_out);
        if($countryZone){
            $local_time = getTime($format, $time_stamp, '', $countryZone);
        }else{
            $local_time = getTime($format, $time_stamp, $code);
        }
    }
    return $local_time;
}

//获取退换货仓库地址
function zen_get_rma_warehouse_address($country_id, $is_reissue){
    $warehouse_address = '';
    if(all_german_warehouse('country_number',$country_id)){
        if($is_reissue == 7){
            //中国直发订单退回到德国仓
            $warehouse_address = FS_COMMON_WAREHOUSE_EU;
        }else {
            //欧盟及欧盟周边国家退换货地址为德国仓
            $warehouse_address = FS_COMMON_WAREHOUSE_EU;
        }
    }elseif(in_array($country_id,[13,153]) && in_array($is_reissue, [9,10])){
//        if($is_reissue == 11){
//            //如果是澳大利亚国内后发（武汉仓直发） 澳大利亚和新西兰退到美东仓
//            $warehouse_address = FS_COMMON_WAREHOUSE_US_EAST;
//        }else{
        //澳洲仓直发 澳大利亚和新西兰退到澳大利亚仓
        $warehouse_address = FS_COMMON_WAREHOUSE_AU;
//        }
    } elseif (in_array($country_id, [44, 96, 125, 206])) {
        // 中国大陆、港澳台退到武汉仓
        $warehouse_address = FS_COMMON_WAREHOUSE_CN;
    } elseif (ru_warehouse('country_number', $country_id)) {
        //俄罗斯退到俄罗斯仓
        $warehouse_address = FS_COMMON_WAREHOUSE_RU;

    } elseif (seattle_warehouse('country_number', $country_id)) {
        //美国仓为发货仓，本地仓发货（包含转运后本地发货）退回对应本地仓；中国直发订单退回美东仓
        $warehouse_address = FS_COMMON_WAREHOUSE_US_EAST;
    } else {
        // 1、收货地址为新加坡覆盖11国，不论从哪里发货；2、收货地址为除中国大陆、港澳台、俄罗斯的其它武汉仓
        // 3、收件地址为澳大利亚和新西兰，且订单从武汉仓直发，4、其它情况
        $warehouse_address = FS_COMMON_WAREHOUSE_DELIVER_TO_SG;
    }
    return $warehouse_address;
}
//获取退换货仓库地址
function zen_get_rma_warehouse_create($country_id){
    $html = '';
    if(all_german_warehouse('country_number',$country_id)){
        //欧盟及欧盟周边国家退换货地址为德国仓
        $html = 'FS.COM GmbH';
    }elseif($country_id==13){
        //澳大利亚退到澳大利亚仓
        $html = 'FS.COM PTY LTD.';
    }else{
        $html = 'FS.COM Inc.';
    }
    return $html;
}

function zen_get_orders_warehouse($warehouse_id,$is_reissue=""){
    $warehouse = '';
    switch($warehouse_id){
        case 2:
            $warehouse = FS_WAREHOUSE_CN;
            break;
        case 3:
            $warehouse = FS_WAREHOUSE_SEA;
            if($is_reissue == 2){
                $warehouse = FS_WAREHOUSE_CN;
            }
            break;
        case 40:
            $warehouse = FS_WAREHOUSE_DEL;
            if($is_reissue == 13){
                $warehouse = FS_WAREHOUSE_CN;
            }
            break;
        case 20:
            $warehouse = FS_WAREHOUSE_EU;
            break;
        case 37:
            $warehouse = FS_WAREHOUSE_AU;
            break;
    }
    return $warehouse;
}

function zen_get_orders_warehouse_address($warehouse_id,$country_id = 0){
    $warehouse = '';
    switch($warehouse_id){
        case 2:
            $warehouse = FS_COMMON_WAREHOUSE_CN_NEW;
            if(in_array($country_id,[223,172])){
                $warehouse = FS_COMMON_WAREHOUSE_US;
            }
            break;
        case 3:
        case 40:
            $warehouse = FS_COMMON_WAREHOUSE_US;
            break;
        case 20:
            $warehouse = FS_COMMON_WAREHOUSE_EU;
            break;
        case 37:
            $warehouse = FS_COMMON_WAREHOUSE_AU;
            break;
        case 71:
            $warehouse = FS_COMMON_WAREHOUSE_SG;
            break;
        case 67:
            $warehouse = FS_COMMON_WAREHOUSE_RU;
            break;
        default :
            $warehouse = FS_COMMON_WAREHOUSE_CN_NEW;
            break;
    }
    return $warehouse;
}

//订单邮件根据仓进行公司信息展示
function get_email_warehouse_address($warehouse_id){
    switch($warehouse_id){
        case 3:
        case 40:
            $warehouse[0] = FS_CHECKOUT_FS_NAME_US;
            $warehouse[1] = FS_CHECKOUT_EMAIL_WAREHOUSE_US;
            $warehouse[2] = FS_CHECKOUT_EMAIL_TEL_US;
            $warehouse[3] = FS_CHECKOUT_EMAIL_US;
            break;
        case 20:
            $warehouse[0] = FS_CHECKOUT_FS_NAME_EU;
            $warehouse[1] = FS_CHECKOUT_EMAIL_WAREHOUSE_EU;
            $warehouse[2] = FS_CHECKOUT_EMAIL_TEL_EU;
            $warehouse[3] = FS_CHECKOUT_EMAIL_EU;
            break;
        case 37:
            $warehouse[0] = FS_CHECKOUT_FS_NAME_AU;
            $warehouse[1] = FS_CHECKOUT_EMAIL_WAREHOUSE_AU;
            $warehouse[2] = FS_CHECKOUT_EMAIL_TEL_AU;
            $warehouse[3] = FS_CHECKOUT_EMAIL_AU;
            break;
        case 71:
            $warehouse[0] = FS_CHECKOUT_FS_NAME_SG;
            $warehouse[1] = FS_CHECKOUT_EMAIL_WAREHOUSE_SG;
            $warehouse[2] = FS_CHECKOUT_EMAIL_TEL_SG;
            $warehouse[3] = FS_CHECKOUT_EMAIL_SG;
            break;
        default ://默认2
            $warehouse[0] = FS_CHECKOUT_FS_NAME_CN;
            $warehouse[1] = FS_CHECKOUT_EMAIL_WAREHOUSE_CN;
            $warehouse[2] = '';
            $warehouse[3] = '';
            break;
    }
    return $warehouse;
}

function zen_get_orders_issued_by($orders_id, $status='orders'){
    $issued_by = '';
    if ($status == 'orders') {
        $son_orders = zen_get_all_son_order_id($orders_id);
    } else {
        $son_orders = zen_get_all_son_order_id($orders_id);
    }

    if(sizeof($son_orders)){
        //主单下有分单
        $warehouse_data = array();
        foreach($son_orders as $id){
            if ($status == 'orders') {
                $warehouse_data[] = fs_get_data_from_db_fields('warehouse','orders','orders_id='.$id,'limit 1');
            } else {
                $warehouse_data[] = fs_get_data_from_db_fields('warehouse','orders_split','orders_id='.$id,'limit 1');
            }
        }
        if(in_array(37,$warehouse_data)){
            //澳大利亚仓
            $issued_by = zen_get_orders_warehouse_address(37);
        }elseif(in_array(3,$warehouse_data)){
            //美国公司和中国公司同时存在就放美国公司，美东和美西同时存在就放美西
            $issued_by = zen_get_orders_warehouse_address(3);
        }elseif(in_array(40,$warehouse_data)){
            //美东仓
            $issued_by = zen_get_orders_warehouse_address(40);
        }elseif(in_array(20,$warehouse_data)){
            //德国仓
            $issued_by = zen_get_orders_warehouse_address(20);
        }elseif(in_array(71,$warehouse_data)){
            //新加坡仓
            $issued_by = zen_get_orders_warehouse_address(71);
        }elseif(in_array(67,$warehouse_data)){
            //俄罗斯仓
            $issued_by = zen_get_orders_warehouse_address(67);
        }else{
            //中国仓
            $issued_by = zen_get_orders_warehouse_address(2);
        }
    }else{
        if ($status == 'orders') {
            $warehouse = fs_get_data_from_db_fields('warehouse','orders','orders_id='.$orders_id,'limit 1');
        } else {
            $warehouse = fs_get_data_from_db_fields('warehouse','orders_split','orders_id='.$orders_id,'limit 1');
        }
        $issued_by = zen_get_orders_warehouse_address($warehouse);
    }
    return $issued_by;
}

//获取订单value
function zen_get_value_cost_by_order($order_id){
    global $db;
    $cost_data = array();
    $cost_sql = "select value,class from orders_total where orders_id=".$order_id;
    $res = $db->Execute($cost_sql);
    while(!$res->EOF){
        $cost_data[$res->fields['class']] = $res->fields['value'];
        $res->MoveNext();
    }
    return $cost_data;
}
//获取账户
function getAccount($country_code_new,$currency='')
{
    $html = "";
    $currency = $currency ? $currency : $_SESSION['currency'];
    if(empty($country_code_new)){
        return "";
    }
    $country_code_new = strtoupper($country_code_new);
    //更新规则 只要是运输地址是英国的订单都展示对应站点的英国账号
    if (german_warehouse("country_code", $country_code_new) || other_eu_warehouse($country_code_new, "country_code")) {
        if($currency == 'USD'){
            $html ='<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top">FS.COM GmbH</td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_SPARKASSE_BANK_NAME . ' </th>
                        <td valign="top"><b>Sparkasse Freising</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO3 . '</th>
                        <td valign="top"><b>DE12 7005 1003 0970 0195 27</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO4 . '</th>
                        <td valign="top"><b>BYLADEM1FSI</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO5 . ' </th>
                        <td valign="top"><b>970 0195 27</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>Untere Hauptstrasse 29, 85354 Freising</b></td>
                    </tr>
                    </tbody>
                </table>';
        }elseif ($currency == 'GBP'){
            $html ='<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top">FS.COM GmbH</td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_SPARKASSE_BANK_NAME . ' </th>
                        <td valign="top"><b>Sparkasse Freising</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO3 . '</th>
                        <td valign="top"><b>DE38 7005 1003 0970 0272 07</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO4 . '</th>
                        <td valign="top"><b>BYLADEM1FSI</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO5 . ' </th>
                        <td valign="top"><b>970 0272 07</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>Untere Hauptstrasse 29, 85354 Freising</b></td>
                    </tr>
                    </tbody>
                </table>';
        }elseif ($currency == 'CHF'){
            $html ='<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top">FS.COM GmbH</td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_SPARKASSE_BANK_NAME . ' </th>
                        <td valign="top"><b>Sparkasse Freising</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO3 . '</th>
                        <td valign="top"><b>DE27 7005 1003 0970 0573 78</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO4 . '</th>
                        <td valign="top"><b>BYLADEM1FSI</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO5 . ' </th>
                        <td valign="top"><b>970 0573 78</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>Untere Hauptstrasse 29, 85354 Freising</b></td>
                    </tr>
                    </tbody>
                </table>';
        }elseif ($currency == 'SEK'){
            $html ='<table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top">FS.COM GmbH</td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_SPARKASSE_BANK_NAME . ' </th>
                        <td valign="top"><b>Sparkasse Freising</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO3 . '</th>
                        <td valign="top"><b>DE98 7005 1003 0970 1070 25</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO4 . '</th>
                        <td valign="top"><b>BYLADEM1FSI</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO5 . ' </th>
                        <td valign="top"><b>970 1070 25</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>Untere Hauptstrasse 29, 85354 Freising</b></td>
                    </tr>
                    </tbody>
                </table>';
        }else{
            $html = '       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top">FS.COM GmbH</td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_SPARKASSE_BANK_NAME . '</th>
                        <td valign="top"><b>Sparkasse Freising</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO3 . '</th>
                        <td valign="top"><b>DE16 7005 1003 0025 6748 88</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO4 . '</th>
                        <td valign="top"><b>BYLADEM1FSI</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FS_HSBC_INFO5 . '</th>
                        <td valign="top"><b>25674888</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>Untere Hauptstr.29, 85354, Freising</b></td>
                    </tr>
                    </tbody>
                </table>';
        }

    } elseif (au_warehouse($country_code_new,"country_code")) {
        // fairy 2018.12.12 增加 account_history_info
        if (!empty($_GET['main_page']) && !in_array($_GET['main_page'],array("account_history_info","checkout_payment_against","account_history_info_old"))) {
            $html .= "<div class='au_title'>"  . "</div>";
        }
        $html.= ' <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_ACCOUNT . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_PTY . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BSB . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_013 . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_ACCOUNT_NO . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_4167 . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SWIFT_CODE . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_ANZBAU3M . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_BANK . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_ST_VIC . '</b></td>
                    </tr>
                    </tbody>
                </table>';
    } elseif (singapore_warehouse("country_code",$country_code_new)) {
        if($currency == 'USD'){
            $html.= ' <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="250" valign="top">' . FIBER_CHECK_COMMON_ACCOUNT_NAME . '</th>
                        <td valign="top"><b>FS TECH PTE. LTD.</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_OCBC_USD . '</th>
                        <td valign="top"><b>503468316301</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_SWIFT . '</th>
                        <td valign="top"><b>OCBCSGSG</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BANK_CODE . '</th>
                        <td valign="top"><b>7339</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BRANCH_CODE . '</th>
                        <td valign="top"><b>First 3 digits of your account no.</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BRANCH_NAME . '</th>
                        <td valign="top"><b>NORTH Branch</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BANK_ADDRESS . '</th>
                        <td valign="top"><b>65 Chulia Street, OCBC Centre, Singapore 049513</b></td>
                    </tr>
                    </tbody>
                </table>';
        }else{
            $html.= ' <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                    <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_COMMON_ACCOUNT_NAME . '</th>
                        <td valign="top"><b>FS TECH PTE. LTD.</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_OCBC_SGD . '</th>
                        <td valign="top"><b>712885193001</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_SWIFT . '</th>
                        <td valign="top"><b>OCBCSGSG</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BANK_CODE . '</th>
                        <td valign="top"><b>7339</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BRANCH_CODE . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_SG_BRANCH_CODE_CONTENT . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BRANCH_NAME . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_SG_BRANCH_NAME_CONTENT . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . FIBER_CHECK_SG_BANK_ADDRESS . '</th>
                        <td valign="top"><b>' . FIBER_CHECK_SG_BANK_ADDRESS_CONTENT . '</b></td>
                    </tr>
                    </tbody>
                </table>';
        }
    } elseif (seattle_warehouse("country_code",$country_code_new)) {
        if(in_array($country_code_new,array('US','PR'))){
            $html.= '<p class="alert_popup_achViaTxt">' . PAYMENT_BANK_VIA . '</p>';
        }
        $html.= '
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_COMMON_BANK . '</th>
                        <td valign="top"><b>' . PAYMENT_BANK_OF_US . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ACCOUNT_NAME_COMMON . '</th>
                        <td valign="top"><b>FS COM INC</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ACCOUNT . '</th>
                        <td valign="top"><b>138 119 625 329</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_WIRE_ROUTING . '</th>
                        <td valign="top"><b>026 009 593</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_SWIFT_CODE . '</th>
                        <td valign="top"><b>BOFAUS3N</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ADDRESS . '</th>
                        <td valign="top"><b>380 Centerpoint Blvd, New Castle, DE 19720</b></td>
                    </tr>
                </tbody>
            </table>';
        if(in_array($country_code_new,array('US','PR'))){
            $html.= '<p class="alert_popup_achViaTxt">' . PAYMENT_BANK_VIA_ACH . '</p>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                <tbody>
                    <tr>
                        <th width="200" valign="top">' . FIBER_CHECK_COMMON_BANK . '</th>
                        <td valign="top"><b>' . PAYMENT_BANK_OF_US . '</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ACCOUNT_NAME_COMMON . '</th>
                        <td valign="top"><b>FS COM INC</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ACCOUNT . '</th>
                        <td valign="top"><b>138 119 625 329</b></td>
                    </tr>
                    <tr>
                        <th valign="top">' . PAYMENT_BANK_ACH_ROUTING . '</th>
                        <td valign="top"><b>125 000 024</b></td>
                    </tr>
                </tbody>
            </table>';
        }
    } else  {
        $html = '          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
            <tbody>
            <tr>
                <th width="200" valign="top">' . FS_SUCCESS_BANK_NAME . '</th>
                <td valign="top"><b>' . FS_SUCCESS_HSBC . '</b></td>
            </tr>
            <tr>
                <th valign="top">' . FS_SUCCESS_AC_NAME . ' </th>
                <td valign="top"><b>' . FS_SUCCESS_CO . '</b></td>
            </tr>
            <tr>
                <th valign="top">' . FS_SUCCESS_AC_NO . '</th>
                <td valign="top"><b>' . FS_SUCCESS_TEL . '</b></td>
            </tr>
            <tr>
                <th valign="top">' . FS_SUCCESS_SWIFT . '</th>
                <td valign="top"><b>' . FS_SUCCESS_HK . '</b></td>
            </tr>
            <tr>
                <th valign="top">' . FS_SUCCESS_BANK_ADRESS . '</th>
                <td valign="top"><b>' . FS_SUCCESS_ROAD . '</b></td>
            </tr>
            </tbody>
        </table>';
    }

    return $html;
}

if (!function_exists('getTTAccountTitle')) {

    /**
     * add by rebirth  2020.04.09
     * 获取TT账户展示的标题   参照订单详情页
     *
     * @param $code
     * @return string
     */
    function getTTAccountTitle($code)
    {
        $code = strtoupper($code);
        if (german_warehouse('country_code', $code) || other_eu_warehouse($code, 'country_code')) {
            return FIBERSTORE_INFO_WIRE_DE;
        } elseif (au_warehouse($code, 'country_code')) {
            return FIBER_CHECK_ANZ;
        } elseif (singapore_warehouse('country_code', $code)) {
            return FIBER_CHECK_SG_TITLE;
        } else {
            return FIBERSTORE_INFO_WIRE;
        }
    }
}

if (!function_exists('getTTAccountInfo')){
    /**
     * add by rebirth  2020.04.09
     * 获取 TT支付展示的银行信息  参照订单详情页
     *
     * @param $country_code_new
     * @param string $currency
     * @return array
     */
    function getTTAccountInfo($country_code_new,$currency='')
    {
        $info = [];
        $currency = $currency ?: $_SESSION['currency'];
        if(empty($country_code_new)){
            return $info;
        }
        $country_code_new = strtoupper($country_code_new);
        $currency = strtoupper($currency);
        //更新规则 只要是运输地址是英国的订单都展示对应站点的英国账号
        if (german_warehouse('country_code', $country_code_new) || other_eu_warehouse($country_code_new, 'country_code')) {
            if($currency == 'USD'){
                $info = [
                    FIBER_CHECK_ACCOUNT       => 'FS.COM GmbH',
                    FIBER_SPARKASSE_BANK_NAME => 'Sparkasse Freising',
                    FS_HSBC_INFO3             => 'DE12 7005 1003 0970 0195 27',
                    FS_HSBC_INFO4             => 'BYLADEM1FSI',
                    FS_HSBC_INFO5             => '970 0195 27',
                    FIBER_CHECK_BANK          => 'Untere Hauptstrasse 29, 85354 Freising',
                ];
            }elseif ($currency == 'GBP'){
                $info = [
                    FIBER_CHECK_ACCOUNT       => 'FS.COM GmbH',
                    FIBER_SPARKASSE_BANK_NAME => 'Sparkasse Freising',
                    FS_HSBC_INFO3             => 'DE38 7005 1003 0970 0272 07',
                    FS_HSBC_INFO4             => 'BYLADEM1FSI',
                    FS_HSBC_INFO5             => '970 0272 07',
                    FIBER_CHECK_BANK          => 'Untere Hauptstrasse 29, 85354 Freising',
                ];
            }elseif ($currency == 'CHF'){
                $info = [
                    FIBER_CHECK_ACCOUNT       => 'FS.COM GmbH',
                    FIBER_SPARKASSE_BANK_NAME => 'Sparkasse Freising',
                    FS_HSBC_INFO3             => 'DE27 7005 1003 0970 0573 78',
                    FS_HSBC_INFO4             => 'BYLADEM1FSI',
                    FS_HSBC_INFO5             => '970 0573 78',
                    FIBER_CHECK_BANK          => 'Untere Hauptstrasse 29, 85354 Freising',
                ];
            }elseif ($currency == 'SEK'){
                $info = [
                    FIBER_CHECK_ACCOUNT       => 'FS.COM GmbH',
                    FIBER_SPARKASSE_BANK_NAME => 'Sparkasse Freising',
                    FS_HSBC_INFO3             => 'DE98 7005 1003 0970 1070 25',
                    FS_HSBC_INFO4             => 'BYLADEM1FSI',
                    FS_HSBC_INFO5             => '970 1070 25',
                    FIBER_CHECK_BANK          => 'Untere Hauptstrasse 29, 85354 Freising',
                ];
            }else{
                $info = [
                    FIBER_CHECK_ACCOUNT       => 'FS.COM GmbH',
                    FIBER_SPARKASSE_BANK_NAME => 'Sparkasse Freising',
                    FS_HSBC_INFO3             => 'DE16 7005 1003 0025 6748 88',
                    FS_HSBC_INFO4             => 'BYLADEM1FSI',
                    FS_HSBC_INFO5             => '25674888',
                    FIBER_CHECK_BANK          => 'Untere Hauptstr.29, 85354, Freising',
                ];
            }

        } elseif (au_warehouse($country_code_new,"country_code")) {
            $info = [
                FIBER_CHECK_ACCOUNT    => FIBER_CHECK_PTY,
                FIBER_CHECK_BSB        => FIBER_CHECK_013,
                FIBER_CHECK_ACCOUNT_NO => FIBER_CHECK_4167,
                FIBER_CHECK_SWIFT_CODE => FIBER_CHECK_ANZBAU3M,
                FIBER_CHECK_BANK       => FIBER_CHECK_ST_VIC,
            ];
        } elseif (singapore_warehouse("country_code",$country_code_new)) {
            if($currency == 'USD'){
                $info = [
                    FIBER_CHECK_COMMON_ACCOUNT_NAME => 'FS TECH PTE. LTD.',
                    FIBER_CHECK_SG_OCBC_USD         => '503468316301',
                    FIBER_CHECK_SG_SWIFT            => 'OCBCSGSG',
                    FIBER_CHECK_SG_BANK_CODE        => '7339',
                    FIBER_CHECK_SG_BRANCH_CODE      => 'First 3 digits of your account no.',
                    FIBER_CHECK_SG_BRANCH_NAME      => 'NORTH Branch',
                    FIBER_CHECK_SG_BANK_ADDRESS     => '65 Chulia Street, OCBC Centre, Singapore 049513',
                ];

            }else{
                $info = [
                    FIBER_CHECK_COMMON_ACCOUNT_NAME => 'FS TECH PTE. LTD.',
                    FIBER_CHECK_SG_OCBC_SGD         => '712885193001',
                    FIBER_CHECK_SG_SWIFT            => 'OCBCSGSG',
                    FIBER_CHECK_SG_BANK_CODE        => '7339',
                    FIBER_CHECK_SG_BRANCH_CODE      => FIBER_CHECK_SG_BRANCH_CODE_CONTENT,
                    FIBER_CHECK_SG_BRANCH_NAME      => FIBER_CHECK_SG_BRANCH_NAME_CONTENT,
                    FIBER_CHECK_SG_BANK_ADDRESS     => FIBER_CHECK_SG_BANK_ADDRESS_CONTENT,
                ];
            }
        } else  {
            $info = [
                FS_SUCCESS_BANK_NAME   => FS_SUCCESS_HSBC,
                FS_SUCCESS_AC_NAME     => FS_SUCCESS_CO,
                FS_SUCCESS_AC_NO       => FS_SUCCESS_TEL,
                FS_SUCCESS_SWIFT       => FS_SUCCESS_HK,
                FS_SUCCESS_BANK_ADRESS => FS_SUCCESS_ROAD,
            ];
        }
        return $info;
    }
}


/**
 * add by ternence  2020.05.20
 * 获取 TT支付展示的银行信息  参照订单详情页
 *
 * @param $country_code_new
 * @param string $currency
 * @return array
 */
function getTTAccounthtml($code)
{
    $infoHtml='';
    if(!empty($code)){
        $code = strtoupper($code);
    }else{
        return false;
    }
    $width="38%";
    $width_two="62%";
//    if($_SESSION['languages_id']!=1){
//        $width="35%";
//        $width_two="65%";
//    }
    if(in_array($code,array('US','PR'))){
        //美国、波多黎各
        $infoHtml ='<tr><td width="'.$width.'" align="right" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;font-weight:600;">
                                                            '.PAYMENT_BANK_VIA.'
                                                        </span>
                                                    </td>
                                                    <td width="'.$width_two.'"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="'.$width.'" align="right"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;">
                                                            '.PAYMENT_BANK_ACCOUNT_NAME_COMMON.'<br>
                                                            '.PAYMENT_BANK_ACCOUNT.'<br>
                                                            '.PAYMENT_BANK_WIRE_ROUTING.'<br>
                                                            '.PAYMENT_BANK_SWIFT_CODE.'<br>
                                                            '.PAYMENT_BANK_ADDRESS.'<br>
                                                         
                                                        </span>
                                                    </td>
                                                    <td width="'.$width_two.'"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                                        <span style="color: #616265;display: inline-block;margin-bottom: 3px;">
                                                            FS COM INC <br>
                                                            138 119 625 329 <br>
                                                            026 009 593 <br>
                                                            BOFAUS3N <br>
                                                            380 Centerpoint Blvd, New Castle, DE 19720
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#F7F7F7" style="border-collapse: collapse;background: #F7F7F7;" height="15">
                
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="'.$width.'" align="right"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span
                                                            style="color: #232323;display: inline-block;margin-bottom: 3px;font-weight:600;">
                                                            '.PAYMENT_BANK_VIA_ACH.'
                                                        </span>
                                                    </td>
                                                    <td width="'.$width_two.'"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="'.$width.'" align="right"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                                        <span style="color: #232323;display: inline-block;margin-bottom: 3px;">
                                                            '.PAYMENT_BANK_ACCOUNT_NAME_COMMON.'<br>
                                                            '.PAYMENT_BANK_ACCOUNT.'<br>
                                                            '.PAYMENT_BANK_ACH_ROUTING.'
                                                        </span>
                                                    </td>
                                                    <td width="'.$width_two.'"
                                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                                        <span style="color: #616265;display: inline-block;margin-bottom: 3px;">
                                                            FS COM INC <br>
                                                            138 119 625 329 <br>
                                                            125 000 024
                                                        </span>
                                                    </td>
                                                </tr>
                                  
                                <tr>
                                    <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px;" >  
                                                <tr>
                                                    <td bgcolor="#F7F7F7" style="border-collapse: collapse;background: #F7F7F7;" height="25">
                                                    </td>
                                                </tr> ';
    }else{
        //加拿大、墨西哥
        $infoHtml ='<tr>
                                    <td width="'.$width.'" align="right"
                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;">
                                        <span
                                            style="color: #232323;display: inline-block;margin-bottom: 3px;">
                                            '.PAYMENT_BANK_ACCOUNT_NAME_COMMON.'<br>
                                            '.PAYMENT_BANK_ACCOUNT.'<br>
                                            '.PAYMENT_BANK_WIRE_ROUTING.'<br>
                                            '.PAYMENT_BANK_SWIFT_CODE.'<br>
                                            '.PAYMENT_BANK_ADDRESS.'<br>
                                        </span>
                                    </td>
                                    <td width="'.$width_two.'"
                                        style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 24px;font-family:Open Sans,arial,sans-serif;padding-left: 20px;">
                                        <span style="color: #616265;display: inline-block;margin-bottom: 3px;">
                                            FS COM INC <br>
                                            138 119 625 329 <br>
                                            026 009 593 <br>
                                            BOFAUS3N <br>
                                            380 Centerpoint Blvd, New Castle, DE 19720
                                        </span>
                                    </td>
                                </tr>
                                    <tr>
                                        <td style="border-collapse: collapse;background: #F7F7F7;" height="25" bgcolor="#F7F7F7">
                                        </td>
                                    </tr>';
    }
    return $infoHtml;
}

//获取订单交期
function getOrderDate($v,&$time_days=[]){
    $delivery_time = '';
    if(empty($v)){
        return "";
    }
    $country_code_new = fs_get_data_from_db_fields('countries_iso_code_2', 'countries', 'countries_name LIKE "' . $v['delivery_country'] . '"', 'limit 1');
    $en_us_data = [];
    $shipping_method = $v['shipping_method'];
    //获取交期日期数据
    if (in_array($v['is_reissue'], array(1, 4, 6, 9, 12,22,23,24,26))) {
        $local_data = [];
        if($v['is_reissue'] == 12 && $v['products']){
            $new_local_products = [];
            foreach ($v['products'] as $value){
                $new_local_products[] = $value['id'];
            }
            $local_data = array(
                'post_code' => $v['delivery_postcode'],
                'state' => $v['delivery_state'],
                'country_id' => $v['delivery_country_id'],
                'local_products' => $new_local_products,
            );
        }
        $delivery_time = getLocalTime($v["warehouse"],$country_code_new,false,$v['is_reissue'],$shipping_method,$local_data);
        //该参数用于在下单成功页面接收订单发货要延迟的天数 用来作为谷歌邀评邮件出发时间点数据 2020.4.7 ery
        $time_days[] = 0;
    } else {
        $new_produts = array();
        $warehouse = get_country_relate_warehouse($country_code_new);
        $hasHeavy = false;
        foreach($v['products'] as $key=>$val){
            if($val['composite_son_products']){
                $no_stock_id = [];
                //组合产品 查出子产品中所有无库存的 获取最长交期
                $composite = [];
                //子产品数据格式35887:2-1690.00,72283:2-1570.00,  产品ID:数量-价格 多个产品之间用逗号,拼接
                $composite_son_arr = explode(',', $val['composite_son_products']);
                foreach($composite_son_arr as $skey=>$sval){
                    if($sval){
                        $sval_arr = explode('-', $sval);
                        $son_val_arr = explode(':', $sval_arr[0]);
                        if((int)$son_val_arr[0]){
                            $composite[] = array('id'=>(int)$son_val_arr[0], 'num'=>$son_val_arr[1]);
                        }
                    }
                }
                if (class_exists('classes\CompositeProducts')) {
                    $CompositeProducts = new classes\CompositeProducts((int)$val,'','');
                    $CompositeProducts->CompositeRelatedInstock($warehouse, false, true, $composite);
                    $no_stock_id = $CompositeProducts->no_stock_id;
                }
                if(sizeof($no_stock_id)){
                    $new_produts = array_merge($new_produts, $no_stock_id);
                }else{
                    $new_produts[] = $val;
                }
            }else{
                $new_produts[] = $val;
            }
            if(in_array($val['is_heavy'],[1,2])){
                $hasHeavy = true;
            }
        }
        $result = zen_get_us_en_site($country_code_new,$warehouse);
        $shipping_method_arr = explode('_',$shipping_method);
        $shipping_method = $shipping_method_arr[0];
        $transport_time = zen_get_transport_limitation($warehouse,$shipping_method,$country_code_new);
        $en_us_data = array(
            'is_en_us' => $result,
            'transport_time' => $transport_time,
            'shipping_method' => $shipping_method,
        );
        $time_data = get_max_date($new_produts,$v["warehouse"],$country_code_new,$en_us_data,$hasHeavy);
        $delivery_time = str_replace([FS_WAREHOUSE_AREA_5, FS_FOR_FREE_SHIPPING_GET_ARRIVE, "fs-new-Fontweight600"], "", $time_data['delay_time']);
        $time_days[] = $time_data['max_time']['time'];
    }
    return $delivery_time;
}

// fairy 2018.10.5 转移到这个地方
function getPdfNew($order_id){
    if ($_SERVER['SERVER_NAME'] == "test.whgxwl.com") {
        $base = "http://test.whgxwl.com:8000";
    } else {
        $base = "https://www.fs.com";
    }
    $code = array("uk/","de/","au/","fr/","es/","jp/","mx/","sg/");
    $img=fs_get_data_from_db_fields("pdf_file","orders","orders_id=".$order_id."","");
    if($img){
        $ziyuan_img = HTTPS_IMAGE_SERVER.DIR_WS_IMAGES.$img;
        $image_src = file_get_contents($ziyuan_img);
        if(!empty($image_src)){
            $link = $ziyuan_img;
        }else{
            $link =  $base."/images/".$img;
            if(remote_file_exists($link)){
                return $link;
            }
            foreach ($code as $v){
                if(remote_file_exists($base."/".$v."images/".$img)){
                    $link = $base."/".$v."images/".$img;
                    break;
                }
            }
        }
    }else{
        $link = false;
    }

    return $link;
}

// fairy 2018.9.27
/*
 * 获取订单的按钮html字符串。供产品详情和列表使用
 * fairy 2018.12.19 add
 * @para array $order：订单数据
 * para string $page：来自哪个页面；list：列表；detail：订单详情
 * para int $refund_num：退款个数，也就是是否有退款；退换货按钮需要
 * $return string: 订单的按钮html
 */
function get_order_status_button($order,$page='list',$refund_num=''){
    /*
     * orders_id,orders_status_id,main_order_id，payment_module_code,is_reviewd,products
     */
    $orders_id = $order['orders_id'];
    $actionHtml = '';
    $common_mobile = isMobile();
    $view_detail_str = '';
    /*
    if(isMobile() && $page == 'list'){
        $view_detail_str.='<a class="new_alone_button new_alone_border_gray order_list_btn_common" href="'.zen_href_link("account_history_info","orders_id=".$orders_id,'SSL').'">'.FS_VIEW_DETAILS.'</a>';
    }
    */

    $cancel_actionHtml = '';
    //    查看订单里是否有特殊产品
//    $show_type = get_order_products_type($orders_id);
//    if($show_type!=1){
    // 详情页面不要这个按钮，有单个产品购买的按钮
    // 任何状态，都可以给reorder操作按钮。待付款的reorder在下面写的
    if($order['orders_status_id']!=1 && $page=='list'){
        $actionHtml .= get_order_status_button_html('reorder',$orders_id,$page,MANAGE_ORDER_BUY,"");
    }
//    }
    $pay_flag = false;
    switch($order['orders_status_id']) {
        case 1:
            // pending状态的操作按钮
            // 只有主单，才有这样的操作。upload_po_file、pay、cancel
            if($page=='list' || ($page=='detail' && $order['main_order_id']==0)) {
                if($order['payment_module_code']=='purchase'){
                    if ($page == "list"){
                        if ($common_mobile){
                            $pay_flag = true;
                        }else{
                            $actionHtml .= get_show_end_time_str($orders_id,$order['payment_module_code']);
                        }
                    }
                    $actionHtml .= get_order_status_button_html('upload_po_file',$orders_id,$page);
                }elseif($order['payment_module_code']=='echeck'){
                    $echeck_result = fs_get_data_from_db_fields('id', 'fs_electrical_check_apply', 'orders_id ='.$orders_id.'', 'limit 1');
                    if($echeck_result){
                        $actionHtml .= "";
                    }else{
                        $actionHtml .= get_order_status_button_html('pay',$orders_id,$page);
                    }
                }elseif($order['payment_module_code']=='alfa'){
                    if ($page == "list"){
                        if ($common_mobile){
                            $pay_flag = true;
                        }else{
                            $actionHtml .= get_show_end_time_str($orders_id,$order['payment_module_code']);
                        }
                    }
                    $actionHtml .= "";
                }else{
                    if ($page == "list"){
                        if ($common_mobile){
                            $pay_flag = true;
                        }else{
                            $actionHtml .= get_show_end_time_str($orders_id,$order['payment_module_code']);
                        }
                    }
                    $actionHtml .= get_order_status_button_html('pay',$orders_id,$page);
                }
                // 2019.5.21 Yang  详情页面不展示此按钮。
                // 放在这个地方，而不放在上面，是因为按钮有排序要求、颜色要求
                if($page == 'list'){
                    $actionHtml .= get_order_status_button_html('reorder',$orders_id,$page,MANAGE_ORDER_BUY,"buy_again");
                }
                // 2019-9-18 potato 订单列表补款订单只展示付款、关闭按钮
                if ($order['link_id']) {
                    $actionHtml = get_order_status_button_html('pay',$orders_id,$page);
                }
                $cancel_actionHtml = get_order_status_button_html('cancel',$orders_id,$page);
            }
            break;
        case 3:
        case 12:
            //Shipped Out状态
            if($page=='detail'){
                $actionHtml .= get_order_status_button_html('receipt_confirmation',$orders_id,$page);
            }
            break;
        case 4:
            // 列表页面单独显示退换货按钮
            if($page=='detail'){
                $actionHtml .= get_order_return_button($order,$refund_num,$page);
            }
            break;
        case 8:
            //PO Confirmed
            if($order['payment_module_code']=='purchase'){
                if($page=='list' || ($page=='detail' && $order['main_order_id']==0)) {
                    $actionHtml .= get_order_status_button_html('view_po',$orders_id,$page);
//                    $cancel_actionHtml = get_order_status_button_html('cancel', $orders_id, $page);
                }
            }
            break;
        case 9:
            //Delivered
            if($order['payment_module_code']=='purchase'){
                // fairy 2019.3.11 这个po订单，新流程已经不走这个节点。
//                if($page=='list' || ($page=='detail' && $order['main_order_id']==0)) {
//                    $actionHtml .= get_order_status_button_html('pay', $orders_id, $page);
//                }
            }else{
                if($page=='detail') {
                    $actionHtml .= get_order_status_button_html('receipt_confirmation', $orders_id, $page);
                }
            }
            break;
    }
    // 下载按钮
    // 订单列表页面，单独显示下载
    if( $page == 'detail' ){
        if($order['main_order_id'] != 1){ //总单，没有打印订单的地方
            $actionHtml .= get_order_status_button_html('download_invoice',$orders_id,$page,'','','',$order['orders_status_id']);
        }
    }
    //列表页面有评价按钮
    //详情页面单独显示
    if($page == 'list' && check_is_can_review($order['orders_status_id'],$order['payment_module_code'])){
        if($order['is_reviewed'] !=1){ //未评论
            $actionHtml .= get_order_status_button_html('review',$orders_id,$page);
        }else{
            $actionHtml .= get_order_status_button_html('reviewed',$orders_id,$page);
        }
    }
    // 2019-9-18 potato 订单列表补款订单只展示付款、关闭按钮
    if ($order['link_id'] && $order['orders_status_id'] !== '1') {
        $actionHtml = '';
    }
    $endHtml = '';
    if ($pay_flag){
        $endHtml .= get_show_end_time_str($orders_id,$order['payment_module_code']);
    }
    $actionHtml .= $view_detail_str.$cancel_actionHtml.$endHtml;

    return $actionHtml;
}

/*
 * 检查订单状态是否可以评价
 * @para $type  按钮的类型
 * para int $orders_id 订单id
 * $return bool: 是否可以评价
 */
function check_is_can_review($orders_status_id,$payment_module_code){
    if(in_array($payment_module_code,array("purchase","rechnung"))){ // po订单，付款在最后
        return in_array($orders_status_id,array(3,12,4,2))?true:false;
    }else{
        return in_array($orders_status_id,array(3,12,4))?true:false;
    }
}

/*
 * 获取某个订单状态按钮的html
 * $type  按钮的类型
 * $orders_id 订单id
 * $page list、detail
 */
function get_order_status_button_html($type,$orders_id,$page='list',$text='',$out_class="",$order_products_id='',$order_status='')
{
    $str = '';
    if(!$out_class){
        if($type == 'cancel'){ //cancel
            if ($page == 'list') {
                if(isMobile()){
                    $class = 'new_alone_button new_alone_border_gray order_list_btn_common';
                }else{
                    $class = "alone_center alone_btm_none1";
                }

            } else {
                $class = "new_alone_button new_alone_border_gray alone_his";
            }
        }elseif (in_array($type,array('pay','upload_po_file','reorder'))){ //红色按钮
            if ($page == 'list') {
                $class = "new_alone_button order_list_btn_common alone_none_border";
            } else {
                $class = "new_alone_button alone_his alone_none_border";
            }
        }else{
            if ($page == 'list') {
                $class = "new_alone_button new_alone_border_gray order_list_btn_common";
            } else {
                $class = "new_alone_button new_alone_border_gray alone_his";
            }
        }
    }
    switch ($type) {
        case 'cancel': //取消订单
            if($page == 'list'){
                $str = '<div class="'.$class .'"><a href="javascript:;" onclick="showCancelWindow(' . $orders_id . ')">'.MANAGE_ORDER_CANCEL.'</a></div>';
            }else{
                $str = '<a href="javascript:;" class="'.$class.'" onclick="showCancelWindow(' . $orders_id . ')">'.MANAGE_ORDER_CANCEL.'</a>';
            }
            break;
        case 'pay': // 去支付
//            $str = '<a class="'.$class.'"  href="'. zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST, '&orders_id='.intval($orders_id), 'SSL').'">'.MANAGE_ORDER_PAY.'</a>';
            $str = '<a class="'.$class.'"  href="javascript:void(0)" onclick="justPayNow('.$orders_id.')">'.MANAGE_ORDER_PAY.'</a>';
            break;
        case 'upload_po_file':
            $str = '<a class="'.$class.'" href="javascript:;" onclick="showUpload('.$orders_id.')">'.MANAGE_ORDER_UPLOAD_PO_FILE.'</a>';
            break;
        case 'receipt_confirmation':
            $str = '<a class="'.$class.'" id="receipt_order" href="javascript:;" onclick="show_receipt_confirmation('.$orders_id.')">'.F_RECEIPT_CONFIRMATION.'
            <span class=" track_orders_wenhao track_orders_wenhao_only">
            <i class="iconfont icon"></i><div class="question_text_01 leftjt">
                <div class="arrow"></div>
                <div class="popover-content">
                    <div class="arr_top">
                        <p>'.FS_ACCOUNT_HISTORY_1.'</p>
                    </div>
                </div>
            </div>
            </span></a>';
            break;
        case 'view_po':
            $pdf_link = getPdfNew($orders_id);
            if($pdf_link){
                $str = '<a class="'.$class.'" target="_blank" href="'.$pdf_link.'">'.MANAGE_ORDER_VIEW_PO.'</a>';
            }
            break;
        case 'reorder': //重新下单
            //未付款状态下订单重购样式独立
            if($out_class){
                if ($page == 'list') {
                    $class = "new_alone_button new_alone_border_gray order_list_btn_common ".$out_class;
                } else {
                    $class = "new_alone_button new_alone_border_gray alone_his ".$out_class;
                }
            } else {
                $class .= " reorder_btn";
            }
            $str = '<a class="'.$class.'" href="javascript:;" onclick="restore_order_products('.$orders_id.',1)" id="reorder_btn_'.$orders_id.'" data-text="'.$text.'">'.$text.'</a>';
            break;
        case 'download_invoice': //打印订单
            if($out_class){
                $class =  $out_class;
            }else{
                if($page == 'list'){
                    $class = 'new_alone_a order_view_a'; //子单的样式
                }
            }

            /*if($page == 'list'){
                 if(in_array($order_status,array(1,5))){
                    $text = FS_VIEW_INVOICE_OTHER;
                }else{
                    $text = FS_VIEW_INVOICE;
            }
        }else{
            if(in_array($order_status,array(1,5))){
                $text = FS_VIEW_INVOICE_OTHER;
            }else{
                $text = FS_PRINT_INVOICE;
            }
        }
            */
            if (!in_array($order_status,array(1,5))&& $_SESSION['languages_code'] == 'jp'){
                $payment_code = fs_get_data_from_db_fields('payment_module_code','orders','orders_id = '.$orders_id,'limit 1');
                if($payment_code == 'purchase'){
                    $text = FS_VIEW_INVOICE;
                }else{
                    $text = FS_VIEW_INVOICE_NEWDIFF;
                }
            }else{
                $text = FS_VIEW_INVOICE;
            }
            $str = '<a class="'.$class.'" href="'.zen_href_link(FILENAME_PRINT_BLANKET_ORDER, '&orders_id=' . intval($orders_id)).'" target="_blank">'.$text.'</a>';
            break;
        case 'review': // 评价按钮
            if($page == 'list'){

            }else{
                $class = 'new_alone_a';
            }
            $review_url = zen_href_link('orders_review', 'orders_id='.intval($orders_id).($order_products_id?'&opid='.$order_products_id:''));
            $str = '<a class="'.$class.'" href="'.$review_url.'" target="_blank">'.MANAGE_ORDER_WRITE. '</a>';
            break;
        case 'reviewed': // 已评论
            $str = '<a class="'.$class.'" href="'.zen_href_link('orders_review', 'orders_id='.intval($orders_id)).'" target="_blank">'.FS_MANAGE_ORDERS_RE . '</a>';
            break;
    }
    //手机端按钮样式变更 2019.6.27 Jeremy
    if(isMobile() && strpos($str,'new_alone_border_gray')){
        $str = str_replace("new_alone_border_gray","new_alone_border_gray new_alone_border_gray_m",$str);
    }
    return $str;
}

// 获取订单的改码跳转按钮
function get_order_coding_button($order,$page='list'){
    global $db;
    if(in_array($order['orders_status_id'],array(3,4,12))){
        //获取支持写码的分类数组
        $allow_categories = get_box_validate_categories();
        $sql = "SELECT op.products_id,ptc.categories_id FROM `orders_products` op LEFT JOIN `products_to_categories` ptc using(products_id) WHERE op.orders_id = ".$order['orders_id']." ORDER BY orders_products_id";
        $query = $db->Execute($sql);
        while(!$query->EOF){
            //判断当前产品对应的分类是否允许写码
            if(isset($allow_categories[$query->fields['categories_id']])){
                $allow_products_id[] = $query->fields['products_id'];
            }
            $query->MoveNext();
        }
        if(sizeof($allow_products_id)){
            if($page == 'list'){
                $orders_number = "'".$order['orders_number']."'";
                if(isMobile()){
                    return '<div class="dash_more"><span class="dash_more_span"><a href="javascript:;" onclick="get_coding_url('.$orders_number.',1);">'.FS_ACCOUNT_CODING_REQUEST_BTN.'</a></span></div>';
                }else{
                    return '<div class="new_wap"><a href="javascript:;" onclick="get_coding_url('.$orders_number.',0);">'.FS_ACCOUNT_CODING_REQUEST_BTN.'</a></div>';
                }
            }
        }
        return '';
    }
    return '';
}

//
function get_order_sg_install($order){
    return '<div class="new_wap sg_install_entrance"><a href="javascript:;" onclick="showInstallForm('.$order['orders_id'].',this); " data-disable="1">' . FS_SG_CALENDAR_100 . '</a></div>';
}
function get_request_coding_url($orderNumber){
    $valid_time = 60*60*2;	//token有效时间 单位s
    $tokenData = fs_get_data_from_db_fields_array(array('id','update_time','token'),'customers_auth_token','customers_id="'.$_SESSION['customer_id'].'"','limit 1');
    $up_arr = array(
        "customers_id"=>$_SESSION['customer_id'],
        "start_time"=>time(),
        "update_time"=>time()
    );
    if($tokenData[0][0]){
        $upStamp = $tokenData[0][1] + $valid_time;
        if($upStamp < time()){
            $token = box_token_create($_SESSION['customer_id'],time());
            $up_arr['token'] = $token;
        }else{
            $token = $tokenData[0][2];
        }
        zen_db_perform('customers_auth_token', $up_arr, 'update', "id=".$tokenData[0][0]);//token有效更新时间
    }else{
        $token = box_token_create($_SESSION['customer_id'],time());
        $up_arr['token'] = $token;
        zen_db_perform('customers_auth_token', $up_arr);//token有效更新时间
    }
    //用户ID
    $userNo = fs_get_data_from_db_fields('customers_number_new',TABLE_CUSTOMERS,'customers_id='.$_SESSION['customer_id'],'limit 1');
    $request_url = get_box_request_url_from_host();
    if($_SESSION['languages_code'] == 'en'){
        $sitecode = '';
    }elseif($_SESSION['languages_code'] == 'dn'){
        $sitecode = 'de-en';
    }else{
        $sitecode = $_SESSION['languages_code'];
    }
    $jump_url = $request_url.'/#/main/order/myOrder?token='.$token.'&userNo='.$userNo.'&orderNumber='.$orderNumber.'&siteCode='.$sitecode;
    return $jump_url;
}

/**
 * add by rebirth 2019/08/20
 * 订单列表页 的 订单超时时间的倒计时功能
 *
 * @param $mid
 * @param $code
 * @param $page, list和details
 * @return string
 */
function get_show_end_time_str($mid, $code, $page='list'){
    $orderOvertime =   fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $mid, "*");
    $str = '';
    if (zen_not_null($orderOvertime['addtime'])) {
        $timeless = $orderOvertime['addtime'] - time();
        $timeStr = get_order_countdowm_str($timeless);
        $class = 'right-top';
        if($page!='list'){
            $class = 'middle-top';
        }
        $str .= '<div class="order_list_middle_Ends"><span id="show_end_time_'.$mid.'">'.$timeStr.'</span>
                        <div class="bubble-popover-wap m_account_bubble">
                            <div class="m-bubble-bg"></div>
                            <div class="bubble-popover">
                                <span class="iconfont icon bubble-icon"></span>
                                <div class="m-bubble-container">
                                    <div class="bubble-frame right-middle">
										<a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon">&#xf092;</i></a>
                                       
                                        <div class="bubble-arrow"></div>
                                        <div class="bubble-content">
                                            <p>'.get_payment_notice_string($code).'</p>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>';
        $range = mt_rand(0,5) + 8;
        $str .= '<script type="text/javascript">
                        var reloading = false;
                        setInterval(function () {
                            $.ajax({
                                url: "index.php?modules=ajax&handler=check_order_overtime&ajax_request_action=check_order_overtime",
                                type: "post",
                                data: {"mid":'. $mid .'},
                                dataType: "json",
                                success: function (res) {
                                if (res.code == 1){
                                    if (res.reload){
                                        if (!reloading){
                                            reloading = true;
                                            var html = \'<div class="spinWrap public_bg_wap background"><div class="bg_color"></div><div id="loader_order_alone" class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div></div>\';
                                            $("body").append(html);
                                            window.location.href = \''.zen_href_link('manage_orders', '', 'SSL').'\';
                                        }                                        
                                    }else{
                                        $("#show_end_time_"+'.$mid.').html(res.str)
                                    }
                                }
                            }
                            })
                        },' . $range .' * 1000);
                    </script>';
    }

    return $str;
}

// 获取订单的退款按钮
function get_order_return_button($order,$refund_num,$page='list'){
    //completed状态的退换货入口
    if(!$order['is_gift_order']){
        //赠品单不能给退换货按钮
        if( (($page=='detail' && $order['main_order_id']!=1) || $page=='list') && $order['orders_status_id']==4 && !$refund_num){
            $service_products = zen_get_customers_service_products($order['orders_id']);
            $service_key = array_keys($service_products);
            $service_falg = false;

            foreach($order['products'] as $p){
                if(!empty($p['composite_son_products'])){//组合产品
                    $a_num = $service_products[$p['orders_products_id']];
                    $son_products = explode(',',$p['composite_son_products']);
                    $son_products = array_filter($son_products);
                    foreach ($son_products as $key => $val){
                        $one = explode(':',$val);
                        $buy_info = explode('-',$one[1]);
                        $products_id = $one[0];
                        $qty = $buy_info[0];
                        if($qty > $a_num[$products_id]){
                            $service_falg = true;
                            break;
                        }
                    }
                }else{
                    if(!in_array($p['orders_products_id'],$service_key) || $p['qty']>$service_products[$p['orders_products_id']]) {
                        $service_falg = true;
                    }
                }
            }

            if($service_falg){
                if($page == 'list' && isMobile()){
                    return '<div class="dash_more"><span class="dash_more_span"><a href="'.zen_href_link('sales_service_info').'&orders_id='.$order['orders_id'].'">'.MANAGE_ORDER_RETURN.'</a></span></div>';
                }elseif($page == 'list'){
                    return '<div class="new_wap"><a href="'.zen_href_link('sales_service_info').'&orders_id='.$order['orders_id'].'" class="return_replace_btn" >'.MANAGE_ORDER_RETURN.'</a></div>';
                }else{
                    return '<a href="'.zen_href_link('sales_service_info').'&orders_id='.$order['orders_id'].'" class="new_alone_button new_alone_border_gray alone_his return_replace_btn">'.MANAGE_ORDER_RETURN.'</a>';
                }
            }
        }
    }
    return '';
}

// 获取订单的倒计时按钮
function get_order_close_button($mianOrder,$page='list'){
    return '';
    $str = '';
    $order_time = $data_time =$h = $i= $d = 0;
    $order_time = changeOrderRestoreTime($mianOrder);
    $h=intval($order_time/3600);
    $i=ceil(($order_time-$h*3600)/60);
    $d =intval($h/24);
    if($d>0){
        $h = ceil(($order_time - $d *24 *3600)/3600);
        $data_time = str_replace('[$DAY]',$d,FS_TIME_DAY_HOUR);
        $data_time = str_replace('[$HOUR]',$h,$data_time);
        $data_time =  MANAGE_ORDER_RESTORE_2.$data_time;
    }elseif($h>0){
        if($h>1 && $h<10){
            $h = '0'.$h;
        }
        $data_time = str_replace('[$HOUR]',$h,FS_TIME_HOUR_MINUTE);
        $data_time = str_replace('[$MINUTE]',$i,$data_time);
        $data_time =  MANAGE_ORDER_RESTORE_2.$data_time;
    }elseif($i>0){
        $data_time = str_replace('[$HOUR]',0,FS_TIME_HOUR_MINUTE);
        $data_time = str_replace('[$MINUTE]',$i,$data_time);
        $data_time =  MANAGE_ORDER_RESTORE_2.$data_time;
    }
    if($order_time>0){
        $str = '<div class="dash_time new_alone_padding_center" or ="'.$mianOrder['orders_id'].'" rel="'.$order_time.'"><i class="iconfont icon">&#xf072;</i>'.$data_time.'</div>';
        if($page=='detail'){
            $msg = changeOrderRestoreType($mianOrder['orders_id'],$mianOrder['payment_module_code']);
            $str .= '<div id="u45" class="text">
                    <p><span>'.$msg.'</span></p>
                </div>';
        }
    }
    return $str;
}

function get_order_flow_html($mianOrder,$oldFlag,$transFlag,$country_code_new,$deliverHtml,$statusID){
    $flow_str = '';
    $oID = $mianOrder['orders_id'];
    $class = ('5' == $mianOrder['orders_status_id']) ? 'withB100' : '';
    $mobile_class = (isMobile()) ? 'carr_960_none' : '';

    if(!$oldFlag){ //改版后的新版流程轴
        if(!in_array($mianOrder['payment_module_code'],array("purchase","rechnung"))){
            if ($mianOrder['payment_module_code'] == "echeck") {
                $numner_str = 'products_schedule_7';
            }else{
                $numner_str = 'products_schedule_6';
            }

            $flow_str .= '<div class="products_schedule products_schedule_deta '.$numner_str.' '.$mobile_class.'">';
            if(!isMobile()){
                $flow_str .= '<ul class="products_ul products_ul_other '.$class.'"  data="1" >';
            }else{
                $flow_str .= '<div class="details_ul_wap"><ul class="details_ul">';
            }

            $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 1, $country_code_new,'default2'),FS_INFO_ORDER_SUBMITTED, "schedule_start active" );

            if('5' == $mianOrder['orders_status_id']){
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 5, $country_code_new,'default2'),CANCELED, "schedule_end active withB45"  );
            }else{
                //如果为echck付款需要财务审核
                if ($mianOrder['payment_module_code'] == "echeck") {
                    $active_str = in_array($mianOrder['orders_status_id'],array(2,10,11,12,13,4,6,7,17)) ? " active" : '';
                    $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 17, $country_code_new,'default2'),FIBERSTORE_STATUS_PAYMENT_PENDING_REVIEW, $active_str );
                }

                $active_str = in_array($mianOrder['orders_status_id'],array(2,10,11,12,13,4,6,7)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 2, $country_code_new,'default2'),FIBERSTORE_STATUS_PAYMENT_RECEIVED, $active_str );

                if($transFlag){
                    $active_str = in_array($mianOrder['orders_status_id'],array(13,11,12,4)) ? " active" : '';
                    $flow_str .= get_order_flow_one( $deliverHtml,FS_INFO_BACK_ORDERING, $active_str );
                }else{
                    $active_str = in_array($mianOrder['orders_status_id'],array(10,11,12,4)) ? " active" : '';
                    $flow_str .= get_order_flow_one( $deliverHtml,FS_INFO_ORDER_PICKING, $active_str );
                }

                $active_str = in_array($mianOrder['orders_status_id'],array(11,12,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 11, $country_code_new,'default2'),FS_INFO_ORDER_PACKED, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(12,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 12, $country_code_new,'default2'),FS_INFO_IN_TRANSIT, $active_str);

                $active_str = in_array($mianOrder['orders_status_id'],array(4)) ? " active" : '';
                $flow_str .= get_order_flow_one(zen_get_country_stand_time($oID, 4, $country_code_new,'default2'),FS_INFO_DELIVER_COMPLETE,"schedule_end".$active_str );
            }
        }else{
            $flow_str .= '<div class="products_schedule products_schedule_deta products_schedule_7 '.$mobile_class.'" data-schedule="1">';
            if(!isMobile()){
                $flow_str .= '<ul class="products_ul products_ul_other '.$class.'"  data="2" >';
            }else{
                $flow_str .= '<div class="details_ul_wap"><ul class="details_ul">';
            }
            $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 1, $country_code_new,'default2'),FS_INFO_ORDER_SUBMITTED, "schedule_start active" );

            if('5' == $mianOrder['orders_status_id']){
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 5, $country_code_new,'default2'),CANCELED, "schedule_end active withB45"  );
            }else{
                if($mianOrder['payment_module_code']=='purchase'){
                    $active_str = in_array($mianOrder['orders_status_id'],array(7,8,13,10,11,12,2,4)) ? " active" : '';
                    $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 8, $country_code_new,'default2'),FS_INFO_PO_RECEIVED, $active_str );
                }else{
                    $active_str = in_array($mianOrder['orders_status_id'],array(7,16,13,10,11,12,2,4)) ? " active" : '';
                    $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 16, $country_code_new,'default2'),FS_INFO_INVOICE_COMFIRMED, $active_str );
                }

                if($transFlag){
                    $active_str = in_array($mianOrder['orders_status_id'],array(13,11,12,4,2)) ? " active" : '';
                    $flow_str .= get_order_flow_one( $deliverHtml,FS_INFO_BACK_ORDERING, $active_str );
                }else{
                    $active_str = in_array($mianOrder['orders_status_id'],array(10,11,12,4,2)) ? " active" : '';
                    $flow_str .= get_order_flow_one( $deliverHtml,FS_INFO_ORDER_PICKING, $active_str );
                }

                $active_str = in_array($mianOrder['orders_status_id'],array(11,12,4,2)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 11, $country_code_new,'default2'),FS_INFO_ORDER_PACKED, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(12,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 12, $country_code_new,'default2'),FS_INFO_IN_TRANSIT, $active_str);

                $active_str = in_array($mianOrder['orders_status_id'],array(4,2)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID,4, $country_code_new,'default2'),FS_INFO_DELIVER_COMPLETE, $active_str );

                $active_str = in_array(2,$statusID) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID,2, $country_code_new,'default2'),FIBERSTORE_STATUS_PAYMENT_RECEIVED, "schedule_end ".$active_str );
            }
        }
    }else{ //旧版流程轴start
        if($mianOrder['payment_module_code'] != 'purchase'){
            $flow_str .= '<div class="products_schedule products_schedule_deta products_schedule_5 '.$mobile_class.'" data-schedule="1">';
            if(!isMobile()){
                $flow_str .= '<ul class="products_ul '.$class.'" data="3" >';
            }else{
                $flow_str .= '<div class="details_ul_wap"><ul class="details_ul">';
            }
            $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,1),FIBERSTORE_STATUS_ORDER_RECIVED, "schedule_start active" );

            if('5' == $mianOrder['orders_status_id']){
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 5, $country_code_new,'default2'),CANCELED, "schedule_end active withB45"  );
            }else{
                $active_str = in_array($mianOrder['orders_status_id'],array(2,3,4,6,7)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,2),FIBERSTORE_STATUS_PAYMENT_RECEIVED, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(3,4,6,7)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,7),MANAGE_ORDER_COMMODITY, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(3,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,3),FIBERSTORE_SHIPPED_OUT, $active_str);

                $active_str = in_array($mianOrder['orders_status_id'],array(4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,4),FIBERSTORE_STATUS_DELIVERY, 'schedule_end'.$active_str );
            }
        }else{
            $flow_str .= '<div class="products_schedule products_schedule_deta products_schedule_7 '.$mobile_class.'" data-schedule="1">';
            if(!isMobile()){
                $flow_str .= '<ul class="products_ul '.$class.'" data="4">';
            }else{
                $flow_str .= '<div class="details_ul_wap"><ul class="details_ul">';
            }

            $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,1),FIBERSTORE_STATUS_ORDER_RECIVED, 'schedule_start active' );

            if('5' == $mianOrder['orders_status_id']){
                $flow_str .= get_order_flow_one( zen_get_country_stand_time($oID, 5, $country_code_new,'default2'),CANCELED, "schedule_end active withB45"  );
            }else{
                $active_str = in_array($mianOrder['orders_status_id'],array(7,8,3,9,2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,8),FIBERSTORE_STATUS_PO_COMFIRMED, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(7,3,9,2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,7),MANAGE_ORDER_COMMODITY, $active_str );

                $active_str = in_array($mianOrder['orders_status_id'],array(3,9,2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,3),FIBERSTORE_SHIPPED_OUT,$active_str);

                $active_str = in_array($mianOrder['orders_status_id'],array(9,2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,9),FIBERSTORE_STATUS_DELIVERED,$active_str);

                $active_str = in_array($mianOrder['orders_status_id'],array(2,4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,2),FIBERSTORE_STATUS_PAYMENT_RECEIVED,$active_str);

                $active_str.= in_array($mianOrder['orders_status_id'],array(4)) ? " active" : '';
                $flow_str .= get_order_flow_one( zen_get_order_history_status($oID,4),FIBERSTORE_STATUS_DELIVERY,'schedule_end'.$active_str);
            }
        } //旧版流程轴end
    }
    if(!isMobile()){
        return $flow_str.'</ul></div>';
    }else{
        return $flow_str.'</ul></div></div>';
    }
}

function get_order_flow_one($time,$status_str,$class){
    //下面的if没有任何意思：只不过将日语的日期改成24小时制的
    if ($_GET['main_page'] == 'account_history_info' && $_SESSION['languages_code'] == 'jp') {
        $time = str_replace('午後', '', $time);
        $time = str_replace('午前', '', $time);
    }
    //pc 端
    if(! isMobile()){
        return '<li class="'.$class.'" >
        <div class="schedule_proint">
        <i class="hollow"></i>
        <div class="current_progress" style="display: block">'.$time.'</div>
        <div class="new_details_schedule" style="display: block">'.$status_str.'</div>
        </div></li>';
    }else{//手机端
        return '<li data="new" class="'.$class.'">
					<span class="details_Point"><em></em></span>
					<div class="details_schedule_left">'.$time.'</div>
					<p class="details_schedule_right new_alone_padding_left">'.$status_str.'</p>
				</li>';
    }
}

/*
 * 获取订单列表，首页和订单列表共用
 * fairy 2018.12.12 add
 * @para $where: where
 * @para $is_get_data: 是否获取数据。false，获取总数
 * @para $where: $page
 * @para $where: $number
 */
function get_order_data($where,$is_get_data=true,$page='',$number=''){
    global $db;
    $orders= array();

    if($is_get_data){
        $field = ' o.orders_id,o.date_purchased,o.customers_id,o.delivery_name,o.customers_name,o.purchase_order_num,o.delivery_name,o.delivery_lastname,
            o.delivery_company,o.delivery_street_address,o.delivery_suburb,o.main_order_id,o.delivery_city,o.delivery_postcode,o.delivery_state,o.delivery_country,
            o.delivery_telephone, o.billing_name, o.billing_country,ot.text as order_total,s.orders_status_name,o.orders_status, o.orders_number,o.currency,o.is_reissue,
            o.currency_value,o.payment_module_code,o.customers_po,o.is_reviewed,o.shipping_method ';
        if(!$page && $number){
            $limit = 'limit '.$number;
        }elseif ($page && $number){
            $begin_page = ($page-1)*$number ;
            $limit = 'limit '.$begin_page.','.$number;
        }
    }else{
        $field = ' count(o.orders_id) as count ';
        $limit = '';
    }
    $orders_query = "SELECT ".$field."
        FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s 
        WHERE  o.orders_id = ot.orders_id AND o.orders_status = s.orders_status_id AND ot.class = 'ot_total' AND o.main_order_id in(0,1) ".$where." AND s.language_id = :languagesID ORDER BY o.orders_id DESC ".$limit;
    $orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
    $orders_query = $db->bindVars($orders_query, ':languagesID', $_SESSION['languages_id'], 'integer');

    if($is_get_data){
        // dd($orders_query);
        $get_orders = $db->Execute($orders_query);
        while(!$get_orders->EOF){
            //get order products images
            $main_order_id = $get_orders->fields['main_order_id'];
            $son_order = array();
            if($main_order_id==1){
                //改主订单下面有分订单
                $son_order = zen_get_all_son_order_by_main_order($get_orders->fields['orders_id']);
            }else{
                $track_arr = zen_get_track_number_by_order($get_orders->fields['orders_id']);
                $is_gift_order = false;	//赠品单标识
                if(in_array($get_orders->fields['is_reissue'],[22,23])){
                    $is_gift_order = true;
                }
                $son_order[] = array(
                    'orders_id' => $get_orders->fields['orders_id'],
                    'orders_number' => $get_orders->fields['orders_number'],
                    'orders_status_id' => $get_orders->fields['orders_status'],
                    'orders_status_name' => $get_orders->fields['orders_status_name'],
                    'order_total' => $get_orders->fields['order_total'],
                    'track_number' => $track_arr['tracking_number'],
                    'track_method' => $track_arr['shipping_method'],
                    'customers_id'=>$get_orders->fields['customers_id'],
                    'delivery_name'=>$get_orders->fields['delivery_name'],
                    'delivery_lastname'=>$get_orders->fields['delivery_lastname'],
                    'delivery_company'=>$get_orders->fields['delivery_company'],
                    'delivery_street_address'=>$get_orders->fields['delivery_street_address'],
                    'delivery_suburb'=>$get_orders->fields['delivery_suburb'],
                    'delivery_city'=>$get_orders->fields['delivery_city'],
                    'delivery_postcode'=>$get_orders->fields['delivery_postcode'],
                    'delivery_state'=>$get_orders->fields['delivery_state'],
                    'delivery_country'=>$get_orders->fields['delivery_country'],
                    'delivery_telephone'=>$get_orders->fields['delivery_telephone'],
                    'purchase_order_num'=>$get_orders->fields['purchase_order_num'],
                    'shipping_method'=>$get_orders->fields['shipping_method'],
                    'customers_po'=>$get_orders->fields['customers_po'],
                    'date_purchased'=>$get_orders->fields['date_purchased'],
                    'customers_name' => $get_orders->fields['customers_name'],
                    'payment_module_code' => $get_orders->fields['payment_module_code'],
                    'currency' => $get_orders->fields['currency'],
                    'is_reissue' => $get_orders->fields['is_reissue'],
                    'currency_value' => $get_orders->fields['currency_value'],
                    'is_gift_order' => $is_gift_order,
                    'products' => zen_get_products_by_order_id($get_orders->fields['orders_id'],$get_orders->fields['currency']),
                );
            }

            $orders [] = array(
                'orders_id'=>$get_orders->fields['orders_id'],
                'customers_id'=>$get_orders->fields['customers_id'],
                'delivery_name'=>$get_orders->fields['delivery_name'],
                'delivery_lastname'=>$get_orders->fields['delivery_lastname'],
                'delivery_company'=>$get_orders->fields['delivery_company'],
                'delivery_street_address'=>$get_orders->fields['delivery_street_address'],
                'delivery_suburb'=>$get_orders->fields['delivery_suburb'],
                'delivery_city'=>$get_orders->fields['delivery_city'],
                'delivery_postcode'=>$get_orders->fields['delivery_postcode'],
                'delivery_state'=>$get_orders->fields['delivery_state'],
                'delivery_country'=>$get_orders->fields['delivery_country'],
                'delivery_telephone'=>$get_orders->fields['delivery_telephone'],
                'purchase_order_num'=>$get_orders->fields['purchase_order_num'],
                'customers_po'=>$get_orders->fields['customers_po'],
                'date_purchased'=>$get_orders->fields['date_purchased'],
                'customers_name' => $get_orders->fields['customers_name'],
                'orders_status_name'=>$get_orders->fields['orders_status_name'],
                'order_total'=>$get_orders->fields['order_total'],
                'orders_status_id' => $get_orders->fields['orders_status'],
                'shipping_method' => $get_orders->fields['shipping_method'],
                'son_order' => $son_order,
                'currency' => $get_orders->fields['currency'],
                'currency_value' => $get_orders->fields['currency_value'],
                'payment_module_code' => $get_orders->fields['payment_module_code'],
                'show_payment' => $get_orders->fields['customers_id'] == $_SESSION['customer_id'] ? 1 : 0,
                'is_reviewed' => $get_orders->fields['is_reviewed']? $get_orders->fields['is_reviewed'] : 0,
                'main_order_id' => $get_orders->fields['main_order_id'],
                'orders_number' => $get_orders->fields['orders_number'],
            );
            $get_orders->MoveNext();
        }

        return $orders;
    }else{
        $count = $db->getAll($orders_query);
        $count = $count?$count[0]['count']:0;
        return $count;
    }
}

/*
 * 获取 某个订单状态的 颜色字符串
 * fairy 2018.12.12 add
 * @para $orders_status_id：状态id
 * @return string：颜色字符串
 */
function get_order_state_color_str($orders_status_id){
    if($orders_status_id=='1'){
        $status_color = 'red';
    }elseif ($orders_status_id=='4' || $orders_status_id=='5'){
        $status_color = 'gray';
    }else{
        $status_color = 'green';
    }
    return $status_color;
}

function checkout_return_products($orders_id)
{
    global $db;
    $service_array = array('refund' => 0, 'replace' => 0, 'maintenance' => 0);
    $sql="SELECT orders_products_id FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id = ".$orders_id." order by orders_products_id";
    $products_array = $db->getAll($sql);

    $order_time = fs_get_data_from_db_fields('date_purchased','orders','orders_id='.$orders_id);
    $order_time = strtotime($order_time)+(86400*30);

    foreach ($service_array as $service_type => $val){
        if($order_time < time() && $service_type == 'refund'){
            continue;
        }
        foreach ($products_array as $op_val) {
            if (!empty($op_val)) {
                $p_qty = fs_get_data_from_db_fields('products_quantity','orders_products','orders_products_id='.$op_val['orders_products_id']);

                $complete_sql = "SELECT SUM(products_num) as tolnum FROM customers_service_products WHERE orders_products_id = " . $op_val['orders_products_id'];
                if (in_array($service_type, array('replace', 'maintenance'))) {
                    $complete_sql = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE orders_products_id = ".$op_val['orders_products_id']." AND s.service_status <> 6 AND s.service_status <> 7";
                }
                $complete_res = $db->Execute($complete_sql);
                $complete_num = (int)$complete_res->fields['tolnum'];
                $p_qty = (int)$p_qty;

                if ($p_qty > $complete_num) {
                    $service_array[$service_type] = 1;
                    break;
                }
            }
        }
        if( $service_array[$service_type] == 1){
            continue;
        }
    }
    return $service_array;
}

//根据订单ID查找退换货列表信息
function zen_get_not_complete_order_info_by_order_id($order_id){
    global $db;
    $order = array();
    $sql = "SELECT o.orders_id,o.date_purchased,o.customers_id,o.delivery_name,o.customers_name,o.purchase_order_num,o.customers_po,o.payment_method,o.delivery_name,
		o.delivery_lastname,o.delivery_company,o.delivery_company_type,o.delivery_street_address,o.delivery_suburb,o.delivery_city,o.delivery_tax_number,o.shipping_method,o.d_tel_prefix,
		o.delivery_postcode,o.delivery_state,o.delivery_country,o.delivery_telephone, o.billing_name,o.billing_country,o.billing_lastname,o.is_reissue,main_order_id,
		o.billing_company,o.billing_street_address,o.billing_suburb,o.billing_postcode,o.billing_state,o.billing_telephone,o.billing_tax_number,o.customers_remarks,
		o.b_tel_prefix,ot.text as order_total,s.orders_status_name, o.orders_status, o.orders_number,o.currency,o.currency_value,o.payment_module_code,o.warehouse,
		o.billing_city,o.logo_file FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s WHERE  o.orders_id = ot.orders_id  
		AND o.orders_status = s.orders_status_id AND o.orders_id=".$order_id."
	    AND ot.class = 'ot_total' AND   s.language_id = ".$_SESSION['languages_id']." ORDER BY orders_id DESC LIMIT 1";
    $res = $db->Execute($sql);
    while(!$res->EOF){
        $currency = $res->fields['currency'];
        $products = zen_get_not_complete_products_by_order_id($res->fields['orders_id'],$currency);
        $track_arr = zen_get_track_number_by_order($res->fields['orders_id']);
        $is_gift_order = false;
        if(in_array($res->fields['is_reissue'],[22,23])){
            $is_gift_order = true;
        }
        $order = array(
            'orders_id' => $res->fields['orders_id'],
            'orders_number' => $res->fields['orders_number'],
            'orders_status_id' => $res->fields['orders_status'],
            'orders_status_name' => $res->fields['orders_status_name'],
            'order_total' => $res->fields['order_total'],
            'main_order_id' => $res->fields['main_order_id'],
            'track_number' => $track_arr['tracking_number'],
            'track_method' => $track_arr['shipping_method'],
            'customers_id'=>$res->fields['customers_id'],
            'delivery_name'=>$res->fields['delivery_name'],
            'delivery_lastname'=>$res->fields['delivery_lastname'],
            'delivery_company'=>$res->fields['delivery_company'],
            'delivery_company_type'=>$res->fields['delivery_company_type'],
            'delivery_street_address'=>$res->fields['delivery_street_address'],
            'delivery_suburb'=>$res->fields['delivery_suburb'],
            'delivery_city'=>$res->fields['delivery_city'],
            'delivery_postcode'=>$res->fields['delivery_postcode'],
            'delivery_state'=>$res->fields['delivery_state'],
            'd_tel_prefix'=>$res->fields['d_tel_prefix'],
            'billing_city'=>$res->fields['billing_city'],
            'delivery_country'=>$res->fields['delivery_country'],
            'delivery_telephone'=>$res->fields['delivery_telephone'],
            'delivery_tax_number'=>$res->fields['delivery_tax_number'],
            'billing_name'=>$res->fields['billing_name'],
            'billing_lastname'=>$res->fields['billing_lastname'],
            'billing_country'=>$res->fields['billing_country'],
            'billing_company'=>$res->fields['billing_company'],
            'billing_street_address'=>$res->fields['billing_street_address'],
            'billing_suburb'=>$res->fields['billing_suburb'],
            'billing_postcode'=>$res->fields['billing_postcode'],
            'billing_state'=>$res->fields['billing_state'],
            'billing_telephone'=>$res->fields['billing_telephone'],
            'billing_tax_number'=>$res->fields['billing_tax_number'],
            'b_tel_prefix'=>$res->fields['b_tel_prefix'],
            'purchase_order_num'=>$res->fields['purchase_order_num'],
            'date_purchased'=>$res->fields['date_purchased'],
            'customers_name' => $res->fields['customers_name'],
            'payment_module_code' => $res->fields['payment_module_code'],
            'payment_method' => $res->fields['payment_method'],
            'currency' => $res->fields['currency'],
            'currency_value' => $res->fields['currency_value'],
            'customers_po' => $res->fields['customers_po'],
            'is_reissue' => $res->fields['is_reissue'],
            'customers_remarks' => $res->fields['customers_remarks'],
            'shipping_method' => $res->fields['shipping_method'],
            'logo_file' => $res->fields['logo_file'],
            'warehouse' => $res->fields['warehouse'],
            'products' => $products,
            'is_gift_order' => $is_gift_order
        );
        $res->MoveNext();
    }
    return $order;
}


function check_exist_order_num($order_num){
    global $db;
    $result = $db->Execute("SELECT orders_id FROM ".TABLE_ORDERS. " WHERE orders_number = '".$order_num."' limit 1");
    if($result->fields['orders_id']){
        return true;
    }else{
        return false;
    }
}


function check_return_btn($orders_id){
    global $db;

    $service_array = array('refund' => false, 'replace' => false, 'maintenance' => false);

    $sql="SELECT  orders_products_id,products_id,products_model,products_name,products_price,final_price,products_quantity,products_prid
			FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id = ".$orders_id." order by orders_products_id";
    $get_products = $db->Execute($sql);

    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {

            $orders_products_id = $get_products->fields['orders_products_id'];
            foreach ($service_array as $service_type => $val) {
                $complete_sql = "SELECT SUM(products_num) as tolnum FROM customers_service_products WHERE orders_products_id = " . $orders_products_id;
                if (in_array($service_type, array('replace', 'maintenance'))) {
                    $complete_sql = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE orders_products_id = $orders_products_id AND s.service_status <> 6 AND s.service_status <> 7";
                }
                $complete_res = $db->Execute($complete_sql);
                $complete_num = (int)$complete_res->fields['tolnum'];
                $p_qty = (int)$get_products->fields['products_quantity'];

                if (empty($complete_num) || ($p_qty > $complete_num)) {
                    $service_array[$service_type] = true;
                }
            }
            $get_products->MoveNext();
        }
    }
}

/**
 * 检测售后单是否为整个订单
 * @param int $orders_id
 */
function check_completed_return($orders_id,$service_id){

    global $db;

    $sql="SELECT  orders_products_id,products_id,products_model,products_name,products_price,final_price,products_quantity,products_prid,composite_son_products FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id = ".$orders_id." order by orders_products_id";
    $get_products = $db->Execute($sql);
    $flag = false;

    if ($get_products->RecordCount()) {
        while (!$get_products->EOF) {
            $orders_products_id = $get_products->fields['orders_products_id'];
            $composite_son_products = $get_products->fields['composite_son_products'];
            $service_res = $db->getAll("SELECT products_id,orders_products_id,products_num,is_fms,service_id FROM `customers_service_products` WHERE service_id = $service_id AND orders_products_id = $orders_products_id");

            if(empty($service_res)) {
                $flag = true;
                break;
            }else {
                if (!empty($composite_son_products)) {//组合产品
                    $service_num = 0;
                    $all_qty = 0;
                    foreach ($service_res as $service_array){
                        $service_num += (int)$service_array['products_num'];
                    }
                    $fms_son_products = get_order_composite_products_info($composite_son_products, 'USD', 60);
                    foreach ($fms_son_products as $fms_array){
                        $all_qty += (int)$fms_array['qty'];
                    }
                } else {
                    $all_qty = (int)$get_products->fields['products_quantity'];
                    $service_array = $service_res[0];
                    $service_num = (int)$service_array['products_num'];
                }

                if ($all_qty > $service_num) {
                    $flag = true;
                    break;
                }
            }
            $get_products->MoveNext();
        }
    }
    return $flag;
}


//获取退换货未退换的产品
function zen_get_not_complete_products_by_order_id($orders_id,$currency=''){
    global $db;
    $products = array();

    $sql="SELECT  orders_products_id,products_id,products_model,products_name,products_price,final_price,products_quantity,products_prid,composite_son_products
			FROM ".TABLE_ORDERS_PRODUCTS . " WHERE  orders_id = ".$orders_id." order by orders_products_id";

    $get_products = $db->Execute($sql);
    $customers_id = fs_get_data_from_db_fields('customers_id','orders','orders_id='.(int)$orders_id);
    $customer_rate_info = fs_get_data_from_db_fields_array(['discount_rate', 'member_level'], 'customers', "customers_id=" . (int)$customers_id, "");
    $rate = '';
    if ($customer_rate_info && $customer_rate_info[0][0] > 0 && $customer_rate_info[0][1])  $rate = $customer_rate_info[0][0];
    if ($get_products->RecordCount()){
        while (!$get_products->EOF) {
            $orders_products_id = $get_products->fields['orders_products_id'];
            $products_id = $get_products->fields['products_id'];

            if(!empty($get_products->fields['composite_son_products'])){//组合产品
                $fms_products_array = get_order_composite_products_info($get_products->fields['composite_son_products'],$currency,60, $rate);
                $fms_array = array();

                foreach ($fms_products_array as $fms_products){
                    $fms_complete_num = 0;
                    $complete_o = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE p.orders_products_id = ".$get_products->fields['orders_products_id']." AND p.products_id = ".$fms_products['products_id']." AND s.`service_type_id` = 1 AND s.service_status <> 7";

                    $complete_w = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE p.orders_products_id = ".$get_products->fields['orders_products_id']." AND p.products_id = ".$fms_products['products_id']." AND s.`service_type_id` IN (2,3) AND s.service_status NOT IN (6,7)";
                    $complete_o_res = $db->Execute($complete_o);//退款类型的数据
                    $complete_w_res = $db->Execute($complete_w);//换货和维修类型的数据

                    $fms_complete_num += (int)$complete_o_res->fields['tolnum'] + (int)$complete_w_res->fields['tolnum'];
                    $fms_p_qty = (int)$fms_products['qty'];

                    if($fms_p_qty > $fms_complete_num){
                        $fms_products_num = $fms_p_qty - $fms_complete_num;
                        $fms_array[] = array(
                            'id' => $fms_products['products_id'],
                            'orders_products_id' => $get_products->fields['orders_products_id'],
                            'products_model' => $get_products->fields['products_model'],
                            'products_name' => $fms_products['products_name'],
                            'price_int' => $fms_products['products_price'],
                            'products_price' => $fms_products['products_price_str'],
                            'products_image' => $fms_products['products_image_str'],
                            'qty' => $fms_products_num
                        );
                    }
                }

                if (!empty($fms_array)) {
                    $attribute = array();
                    $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
				options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "'";
                    $attr_res = $db->Execute($attributes_query);
                    while (!$attr_res->EOF) {
                        $attribute[] = array(
                            'option' => $attr_res->fields['products_options'],
                            'value' => $attr_res->fields['products_options_values'],
                            'option_id' => $attr_res->fields['products_options_id'],
                            'value_id' => $attr_res->fields['products_options_values_id'],
                            'prefix' => $attr_res->fields['price_prefix'],
                            'price' => $attr_res->fields['options_values_price']
                        );
                        $attr_res->MoveNext();
                    }
                    $length_query = "select length_name,length_price,price_prefix from order_product_length where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "' limit 1";
                    $length_res = $db->Execute($length_query);
                    if ($length_res->RecordCount()) {
                        $attribute[] = array(
                            'option' => $length_res->fields['length_name'],
                            'value' => 'length',
                            'option_id' => '',
                            'value_id' => '',
                            'prefix' => $length_res->fields['price_prefix'],
                            'price' => $length_res->fields['length_price']
                        );
                    }
                    $pro_name = $get_products->fields['products_name'];
                    if (!$pro_name) $pro_name = fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . $get_products->fields['products_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');

                    $products [] = array(
                        'id' => $get_products->fields['products_id'],
                        'prid' => $get_products->fields['products_prid'],
                        'orders_products_id' => $get_products->fields['orders_products_id'],
                        'products_model' => $get_products->fields['products_model'],
                        'products_name' => $pro_name,
                        'products_price' => $get_products->fields['products_price'],
                        'products_image' => fs_get_data_from_db_fields('products_image', TABLE_PRODUCTS, 'products_id=' . $get_products->fields['products_id'], 'limit 1'),
                        'final_price' => $get_products->fields['final_price'],
                        'qty' => (int)$get_products->fields['products_quantity'],
                        'attribute' => $attribute,
                        'fms_products' => $fms_array
                    );
                }
            }else{//非组合产品
                $complete_num = 0;
                $complete_o = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE orders_products_id = $orders_products_id AND s.`service_type_id` = 1 AND s.service_status <> 7";

                $complete_w = "SELECT SUM(p.products_num) as tolnum FROM customers_service_products p LEFT JOIN `customers_service` s ON p.`service_id`=s.customers_service_id WHERE orders_products_id = $orders_products_id AND s.`service_type_id` IN (2,3) AND s.service_status NOT IN (6,7)";
                $complete_o_res = $db->Execute($complete_o);//退款类型的数据
                $complete_w_res = $db->Execute($complete_w);//换货和维修类型的数据

                $complete_num += (int)$complete_o_res->fields['tolnum'] + (int)$complete_w_res->fields['tolnum'];
                $p_qty = (int)$get_products->fields['products_quantity'];

                if ($p_qty > $complete_num) {
                    $products_num = $p_qty - $complete_num;
                    $attribute = array();
                    $attributes_query = "select products_options_id, products_options_values_id, products_options, products_options_values,
				options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "'";
                    $attr_res = $db->Execute($attributes_query);
                    while (!$attr_res->EOF) {
                        $attribute[] = array(
                            'option' => $attr_res->fields['products_options'],
                            'value' => $attr_res->fields['products_options_values'],
                            'option_id' => $attr_res->fields['products_options_id'],
                            'value_id' => $attr_res->fields['products_options_values_id'],
                            'prefix' => $attr_res->fields['price_prefix'],
                            'price' => $attr_res->fields['options_values_price']
                        );
                        $attr_res->MoveNext();
                    }
                    $length_query = "select length_name,length_price,price_prefix from order_product_length where orders_id = '" . (int)$orders_id . "' 
				and orders_products_id = '" . (int)$get_products->fields['orders_products_id'] . "' limit 1";
                    $length_res = $db->Execute($length_query);
                    if ($length_res->RecordCount()) {
                        $attribute[] = array(
                            'option' => $length_res->fields['length_name'],
                            'value' => 'length',
                            'option_id' => '',
                            'value_id' => '',
                            'prefix' => $length_res->fields['price_prefix'],
                            'price' => $length_res->fields['length_price']
                        );
                    }
                    $pro_name = $get_products->fields['products_name'];
                    if (!$pro_name) $pro_name = fs_get_data_from_db_fields('products_name', TABLE_PRODUCTS_DESCRIPTION, 'products_id=' . $get_products->fields['products_id'] . ' and language_id=' . $_SESSION['languages_id'], 'limit 1');

                    $products [] = array(
                        'id' => $get_products->fields['products_id'],
                        'prid' => $get_products->fields['products_prid'],
                        'orders_products_id' => $get_products->fields['orders_products_id'],
                        'products_model' => $get_products->fields['products_model'],
                        'products_name' => $pro_name,
                        'products_price' => $get_products->fields['products_price'],
                        'products_image' => fs_get_data_from_db_fields('products_image', TABLE_PRODUCTS, 'products_id=' . $get_products->fields['products_id'], 'limit 1'),
                        'final_price' => $get_products->fields['final_price'],
                        'qty' => $products_num,
                        'attribute' => $attribute,
                        'fms_products' => array()
                    );
                }
            }
            $get_products->MoveNext();
        }
    }
    return $products;

}

/**
 * 获取订单税收价格的标题
 * @param $country_code_new 订单ship地址的国家code
 * @param bool $vatInvoice   发票是pi 还是ci 状态
 * @param bool $show_vat_title_type 英文站点时，选择的shipto地址是“德国仓”或者“俄罗斯国家且对公”的情况下，税费表达需更改为VAT
 * @return string
 */
function zen_get_orders_vat_title($country_code_new, $vatInvoice = false, $show_vat_title_type = false)
{
    //$title = EMAIL_CHECKOUT_COMMON_VAT_COST;

    if (in_array($country_code_new, ['SG'])) {
        $title = FS_CHECK_OUT_TAX_AU;
    } elseif ($country_code_new == "US") {
        $title = $vatInvoice ? FS_VAX_TITLE_US_TAX : FS_VAX_TITLE_US;
    } elseif (in_array($country_code_new, ['AU'])) {
        $title = FS_CHECK_OUT_TAX_AU;
    } else {
        if ($show_vat_title_type) {
            $title = EMAIL_CHECKOUT_COMMON_VAT_COST2;
        } else {
            $title = EMAIL_CHECKOUT_COMMON_VAT_COST;
        }
        // 2019-7-9   potato   // 添加摩纳哥的税率为20%
        if (strtolower($country_code_new) == 'fr' || strtolower($country_code_new) == 'gb' || strtolower($country_code_new) == 'mc') {
            $title = EMAIL_CHECKOUT_COMMON_VAT_COST_FR;
        }
    }
    return $title;
}

/**
 * 判断退换货的产品是否需要人工审核
 * @param1  int $products_id
 * @param2 date $transit_time 发货时间
 */
function zen_get_rma_products_check_status($products_id, $transit_time=''){
    global $redis;
    $check = false;
    $customArr = $customProArr = array();  //需人工审核的分类ID和产品ID数组
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/coding/rma_check_category/category.txt')){ // 从文件中获取
        $check_content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/coding/rma_check_category/category.txt');
        $check_content = trim($check_content);
        $content_arr = explode('|',$check_content);	//改文件中既有分类ID又有产品ID两者中间用|符号分隔,eg:177,178|36157,36158
        $customArr =  explode(',',$content_arr[0]);
        $customProArr = explode(',',$content_arr[1]);
    }else{
        $customArr = array(177,178,179,180,1202,1023,1017,1022,628,596,1311,1333,1153,1340,1316,3318,3203,16,1003,17,1105,13,2969,1135,1140,3087,3191,3089,1125,897,2867,1324,1194,901,1082,3254,2866,1415,974,1326,3081,1081,1083,2958,220,3253,1342,1148,996,3080,939,609,914,576,3125,2981,1155,1000,2686,384,2687,45,3358,3359,3360,3076,3361,3084,3083,3092,3082,1145,3128,3362,2960,2963,900,3093,2907,3059,1098,1067,1070,3054,3061,593,594,3049,980,3371,613,3261,3262,3263,3311,1134,1133,3073,633,3313,962,590,3347,1126,24,964,969,3072,1074,50,53,1063,47,49,3255,3256,3257,3258,3373,3309,3354,3355,3267,3375,1402,3260,1343,2968,3053,3314,3086,3075,3150,3374,1048,1181,3334,1038,1044,1047,1186,22,38,34,1321,1319,1099,19,21,48,52,51,55);
    }

    //获取自动审核分类保修期
    $auto_category = $auto_product = array();
    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/coding/rma_check_category/auto_category.txt')){ // 从文件中获取
        $check_content = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/coding/rma_check_category/auto_category.txt');
        $check_content = trim($check_content);
        $content_arr = explode('|',$check_content);	//改文件中既有分类ID又有产品ID两者中间用|符号分隔,eg 918:60,35:12|36157:6
        $cateArr =  explode(',',$content_arr[0]);
        if(sizeof($cateArr)){
            foreach($cateArr as $cate){
                if($cate){
                    $new_cate = explode(':',$cate);     //$cate是分类ID:保修期月数
                    $auto_category[$new_cate[0]] = $new_cate[1];
                }

            }
        }
        $productArr =  explode(',',$content_arr[1]);
        if(sizeof($productArr)){
            foreach($productArr as $pval){
                if($pval){
                    $new_pval = explode(':',$pval);     //$pval是 产品ID:保修期月数
                    $auto_product[$new_pval[0]] = $new_pval[1];
                }

            }
        }
    }
    //先判断该产品ID是否在需要人工审核的产品ID数组中
    if(in_array($products_id,$customProArr)){
        $check = true;
    }else{
        //根据产品ID查找对应的分类ID以及所有的父分类ID
        $cPath = zen_get_product_path($products_id);
        $cPathArr = explode('_',$cPath);
        $cNum = sizeof($cPathArr);
        for($jj=1;$jj<$cNum;$jj++){
            if(in_array($cPathArr[$jj],$customArr)){
                $check = true;
            }
        }
    }
    if(!$check && $transit_time){
        //该产品属于自动审核分类且有具体的发货时间 在判断是否有保修期限制
        $key_product = array_keys($auto_product);
        $key_category = array_keys($auto_category);
        if(in_array($products_id, $key_product)){
            //该产品有保修期限制
            $warranty_day = '+'.(int)$auto_product[$products_id].'month';
            $warranty_time = strtotime("$transit_time.$warranty_day");
            if($warranty_time<time()){
                //若是从发货之日起已经超出保修时间 则需要人工审核
                $check = true;
            }
        }else{
            //根据产品ID查找对应的分类ID以及所有的父分类ID
            $cPath = zen_get_product_path($products_id);
            $cPathArr = explode('_',$cPath);
            $cNum = sizeof($cPathArr);
            for($jj=1;$jj<$cNum;$jj++){
                if(in_array($cPathArr[$jj],$key_category)){
                    //该产品对应的分类有保修期限制 则需要人工审核
                    $warranty_day = '+'.(int)$auto_category[$cPathArr[$jj]].'month';
                    $warranty_time = strtotime("$transit_time.$warranty_day");
                    if($warranty_time<time()){
                        //若是从发货之日起已经超出保修时间 则需要人工审核
                        $check = true;
                    }
                }
            }
        }
    }
    return $check;
}

/**
 * 获取订单的组合产品的子产品信息
 * fairy 2019.2.21 add
 * @param int $orders_products_id 订单产品id
 * @param string $currency 订单购买的币种
 * @param float $currency_value 订单购买的汇率
 * @param int $size: 图片的宽度和高度
 * @return array 子产品信息
 */
function get_order_composite_products_info($composite_son_products,$currency,$size=60, $discount_rate =''){
    if(empty($composite_son_products)){
        return '';
    }
    global $currencies,$db;
    $son_products = explode(',',$composite_son_products);
    $son_products = array_filter($son_products);
    $new_son_products = array(); // 子产品数据
    $son_product_id_array = array(); // 子产品id数组
    foreach ($son_products as $key => $val){
        $one = explode(':',$val);
        $buy_info = explode('-',$one[1]);
        //价格保留位数调整 之前的不准确
        if($discount_rate){
            $price[$key] = number_format(zen_round($buy_info[1] * $discount_rate, 2), 2, '.', '');//保留2位小数
        }else{
            $price[$key] = number_format(zen_round($buy_info[1], 2), 2, '.', '');//保留2位小数
        }
//        $price[$key] = !empty($discount_rate) ? bcmul($buy_info[1], $discount_rate,2) : $buy_info[1];
        $son_product_id_array[] = $one[0];
        $new_son_products[$one[0]] = array(
            'products_id' => $one[0],
            'qty' => $buy_info[0], //购买了几个子产品
            'products_price' => $price[$key], //当前币种价格
            'products_price_str' =>$currencies->update_format($price[$key], false, $currency),//带有单位的，当前币种价格
        );
    }

    // 获取产品其他数据
    $son_product_ids = implode(',', $son_product_id_array);
    $res = $db->Execute('SELECT p.products_id,p.products_image,pd.products_name
        FROM ' . TABLE_PRODUCTS . ' p
        LEFT JOIN   ' . TABLE_PRODUCTS_DESCRIPTION . ' pd ON pd.products_id = p.products_id
        WHERE p.products_id in (' . $son_product_ids . ')');
    while (!$res->EOF) {
        $new_son_products[$res->fields['products_id']]['products_name'] = $res->fields['products_name'];
        $new_son_products[$res->fields['products_id']]['products_image'] = $res->fields['products_image'];
        $new_son_products[$res->fields['products_id']]['products_image_str'] = get_resources_img(intval($res->fields['products_id']), $size, $size, $res->fields['products_image'], '', '', ' border="0" ');
        $res->MoveNext();
    }

    return $new_son_products;
}

/**
 * 获取售后列表单个子产品的数据
 * quest 2019.2.25 add
 * @param string $composite_son_products 组合产品信息
 * @param int $currency 币种信息
 * @param int $c_pid 子产品id
 * @param string $rate 为组合产品的折扣
 * @return array|string
 */
function get_return_fms_children_products($composite_son_products,$currency,$c_pid, $rate = ''){
    if(empty($composite_son_products)){
        return '';
    }

    global $currencies,$db;
    $son_products = explode(',',$composite_son_products);
    $son_products = array_filter($son_products);
    $new_son_products = array(); // 子产品数据
    $son_product_id_array = array(); // 子产品id数组
    foreach ($son_products as $key => $val){
        $one = explode(':',$val);
        $buy_info = explode('-',$one[1]);
        $son_product_id_array[] = $one[0];
        $price[$key] = !empty($rate) ? bcmul($buy_info[1], $rate,2) : $buy_info[1]; // 有折扣就计算打折，没有就显示原价
        if($one[0] == $c_pid){
            $new_son_products = array(
                'qty' => $buy_info[0], //购买了几个子产品
                'products_price' => $price[$key], //当前币种价格
                'products_price_str' =>$currencies->update_format($price[$key],false,$currency),//带有单位的，当前币种价格
            );
        }
    }

    $res = $db->Execute('SELECT pd.products_name
        FROM ' . TABLE_PRODUCTS_DESCRIPTION . ' pd
        WHERE pd.products_id = ' . $c_pid);
    $new_son_products['products_name'] = $res->fields['products_name'];

    return $new_son_products;
}


/**
 * 获取对应单号的物流结果
 * helun 2019.3.19 add
 * @param string $shipping_method 物流方式
 * @param string $shipping_number 物流单号
 * @param
 */
function get_shipping_fms($shipping_method,$shipping_number){
    $language_id = $_SESSION['languages_id'];
    if (preg_match('/FEDEX/i', strtoupper($shipping_method))){
        switch ($language_id){
            case '2':
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers='.$shipping_number .'&locale=es_ES';
                break;
            case '3':
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers='.$shipping_number .'&locale=fr_FR';
                break;
            case '4':
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers='.$shipping_number .'&locale=ru_RU';
                break;
            case '5':
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers='.$shipping_number .'&locale=de_DE';
                break;
            case '8':
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers='.$shipping_number .'&locale=ja_JP';
                break;
            default:
                $ship_order_url = 'https://www.fedex.com/apps/fedextrack/index.html?action=track&tracknumbers=' .$shipping_number;
        }
    }elseif (preg_match('/UPS/i', strtoupper($shipping_method))) {
        switch ($language_id){
            case '2':
                $ship_order_url = 'https://www.ups.com/track?loc=es_ES&tracknum='.$shipping_number .'&requester=ST/';
                break;
            case '3':
                $ship_order_url = 'https://www.ups.com/track?loc=fr_FR&tracknum='.$shipping_number .'&requester=ST/';
                break;
            case '4':
                $ship_order_url = 'https://www.ups.com/track?loc=ru_RU&tracknum='.$shipping_number .'&requester=ST/';
                break;
            case '5':
                $ship_order_url = 'https://www.ups.com/track?loc=de_DE&tracknum='.$shipping_number .'&requester=ST/';
                break;
            case '8':
                $ship_order_url = 'https://www.ups.com/track?loc=ja_JP&tracknum='.$shipping_number .'&requester=ST/';
                break;
            default:
                $ship_order_url = 'https://www.ups.com/track?loc=en_DE&tracknum='.$shipping_number .'&requester=WT/';
        }
    }else if (preg_match('/DHL/i', strtoupper($shipping_method))) {
        switch ($language_id){
            case '2':
                $ship_order_url = 'https://www.logistics.dhl/es-es/home/seguimiento.html?tracking-id='.$shipping_number;
                break;
            case '3':
                $ship_order_url = 'https://www.logistics.dhl/fr-fr/home/suivi.html?tracking-id='.$shipping_number;
                break;
            case '4':
                $ship_order_url = 'https://www.logistics.dhl.ru/ru-ru/home/tracking.html?tracking-id='.$shipping_number;
                break;
            case '5':
                $ship_order_url = 'https://www.logistics.dhl/de-de/home/sendungsverfolgung.html?tracking-id='.$shipping_number;
                break;
            case '8':
                $ship_order_url = 'https://www.logistics.dhl/jp-ja/home/tracking.html?tracking-id='.$shipping_number;
                break;
            default:
                $ship_order_url = 'https://www.logistics.dhl/global-en/home/tracking.html?tracking-id='.$shipping_number;
        }
    }else if (preg_match('/TNT/i', strtoupper($shipping_method))) {
        $ship_order_url = 'https://www.tnt.com/express/en_cn/site/shipping-tools/tracking.html?searchType=con&cons='.$shipping_number;
    }else if(preg_match('/StarTrack/i',$shipping_method)){
        $ship_order_url = 'https://startrack.com.au/';
    }else if(preg_match('/Fastway/i',$shipping_method)){
        $ship_order_url = 'https://www.fastway.com.au/tools/track?l=' .$shipping_number;
    }else if(preg_match('/Australia Post/i',$shipping_method)){
        $ship_order_url = 'https://auspost.com.au/mypost/track/#/search';
    }else if(preg_match('/ODFL/i',$shipping_method)){
        $ship_order_url = 'https://www.odfl.com/Trace/standardResult.faces?pro='.$shipping_number;
    }else if(preg_match('/simplypost/i',$shipping_method)){
        $ship_order_url = 'https://app.jtexpress.sg/track.html?utm_referrer=https://www.jtexpress.sg/';
    }else {
        $ship_order_url = 'javascript:;';
    }
    return $ship_order_url;
}

/**
 * @param $orders_id 订单表（orders）主键id
 * @param int $currencies_id 订单币种id
 * @param int $type 返回数据类型 0 默认原币；1 美元 汇率取订单；2 美元 汇率未实时汇率
 * @return float
 * @author quest  20190422 copy admin_function
 */
function zen_get_use_total_reserved_funds_value_new($orders_id,$currencies_id=1,$type=0){
    global $db;
    $all_reserved = 0 ;
    if(empty($orders_id)){
        return $all_reserved;
    }
    if (is_numeric($orders_id)) {
        $orders_limit= ' AND orders_id="'.$orders_id.'" '  ;
    }else{
        $orders_limit= ' AND orders_number = "'.$orders_id.'" '   ;
    }
    $value1=$value2=zen_get_currencies_value_of_id($currencies_id);

    $sql ='SELECT  currencies_id,reserved_money,currencies_value
	           FROM   reserved_funds_history  WHERE is_delete=0  '.$orders_limit.' ' ;
    $get_reserved = $db->Execute($sql);
    if ($get_reserved->RecordCount()){
        while (!$get_reserved->EOF){
            // 直接转换成订单币种  汇率不同则转换
            if($currencies_id!=$get_reserved->fields['currencies_id']){
                $currencies_parities_value=$get_reserved->fields['currencies_value'];//新预留款使用保存了汇率
                if(floatval($currencies_parities_value)==0){
                    $currencies_parities_value=zen_get_currencies_value_of_id($get_reserved->fields['currencies_id']);
                }
                $dol_reserved_money = $get_reserved->fields['reserved_money']*$value1/$currencies_parities_value ;
                $all_reserved +=  $dol_reserved_money ;
            }else{
                $dol_reserved_money = $get_reserved->fields['reserved_money'];
                $all_reserved +=  $dol_reserved_money ;
            }
            $get_reserved->MoveNext();
        }
    }
    if($type){//返回美元
        $all_reserved=$all_reserved/$value2;
    }
    return $all_reserved;
}

/**
 * 网站中同一个产品购买多个时 总价计算
 * @param $final_price 单个产品 最终的总价格 单位是美元
 * @param $currency 当前货币
 * @return $new_price 转换币种并保留小数位操作后的美元价格
 */
function get_one_products_currency_price($final_price, $currency=''){
    global $currencies;
    $new_price = 0;
    if(!$currency) $currency = $_SESSION['currency'];
    if($final_price){
        $currency_value = $currencies->currencies[$currency]['value'];
        $decimal =  $currencies->currencies[$currency]['decimal_places'];
        $new_price = zen_round($final_price * $currency_value, $decimal);
        $new_price = $new_price/$currency_value;
    }
    return $new_price;
}

/**
 * 新版账户中心公用头部
 * add helun
 */
function get_account_common_header_html(){
    $number = '';
    if($_SESSION['customers_number_new']){
        if($_SESSION['languages_code'] == 'ru'){
            $number = FS_ACCOUNT_NO.' #'.$_SESSION['customers_number_new'];
        }elseif($_SESSION['languages_code'] == 'de'){
            $number = FS_COMMON_ACCOUNT.' #'.$_SESSION['customers_number_new'];
        }else{
            $number = FS_COMMON_HEADER_ACCOUNT.' '.FS_ACCOUNT_NO.' #'.$_SESSION['customers_number_new'];
        }

    }
    $account_head_html = '
        <div class="account-public-top-container account-public-background-8d8d8f">
            <div class="account-public-top account-public-after account-public-1420">
                <div class="account-public-Blank account-public-float-left"></div>
                <div class="account-public-head account-public-float-left">
                <h2 class="account-public-head-tit account-public-txt-26 account-public-color-ffffff account-public-400">' . FS_ACCOUNT_MY_ACCOUNT . '</h2>
                <p class="account-public-txt-14 account-public-color-ffffff">' . $_SESSION['customer_first_name'] . '<em class="account-Vertical"></em>
                 '. $number .'
                </p>
                </div>	
            </div>
        </div>';
    return $account_head_html;
}

/**
 * pc端 新版账户中心公用左部
 * m端 新版账户中心公用上半部分
 * add helun
 */
function get_account_common_left_html(){

    $apply_info = getPurchaseInfo();
    $apply_info['apply_money'] =  $apply_info['apply_money'][0][1];
    $apply_type = $apply_info['apply_type'];
    $is_delete = $apply_info['is_delete'];

    $name = $my_credit_html = $email_name = $phone_code = $review_html = '';
    if($_SESSION['customer_id']){
        $name = ucfirst(zen_customer_has_admin_of_cid($_SESSION['customer_id']));
        $email_name = zen_get_admin_email_of_name(zen_customer_has_admin_of_cid($_SESSION['customer_id']));
    }
    if($_SESSION['countries_iso_code']){
        $phone_code = fs_new_get_phone($_SESSION['countries_iso_code']);
    }

    switch($_GET['main_page']){
        case 'edit_my_account':
            $action_1 = 'active';
            $navi_title_m = FS_ACCOUNT_MANAGE_SET;
            break;
        case 'manage_addresses':
            $action_2 = 'active';
            $navi_title_m = FS_ACCOUNT_MANAGE_ADDRESS;
            break;
        case 'my_cases':
            $action_3 = 'active';
            $navi_title_m = FS_ACCOUNT_SERVICE_CASES;
            break;
        case 'my_credit':
            $action_4 = 'active';
            $navi_title_m = FS_ACCOUNT_MANAGE_CREDIT;
            break;
        case 'manage_orders':
            $action_5 = 'active';
            $navi_title_m = FS_ACCOUNT_ORDER_HIS;
            break;
        case 'return_guidelines':
            $action_6 = 'active';
            $navi_title_m = FS_RETURN_BUTTON;
            break;
        case 'orders_review':
            $action_7 = 'active';
            $navi_title_m = FS_ACCOUNT_ORDER_REVIEW_WRITE;
            break;
        case 'inquiry_list':
            $action_8 = 'active';
            $navi_title_m = FS_QUOTE_INFO_12;
            break;
        case 'inquiry':
            $action_9 = 'active';
            $navi_title_m = FS_ACCOUNT_BUSINESS_MY_QUOTES;
            break;
        case 'coding_requests':
            $action_10 = 'active';
            $navi_title_m = FS_ACCOUNT_MY_CODING_REQUESTS;
            break;
        case 'my_dashboard':
            $action_11 = 'active';
            $navi_title_m = FS_ACCOUNT_MY_ACCOUNT;
            break;
        default:
            $navi_title_m = FS_ACCOUNT_MY_ACCOUNT;
            break;
    }

    //账期客户和普通、企业客户的区别
    if ( in_array($apply_type,[2,13,17]) && $is_delete == 0) {
        $my_credit_html = '<dd class="'.$action_4.'"><a href="' . zen_href_link('my_credit','','SSL') . '">' . FS_ACCOUNT_MANAGE_CREDIT . '</a></dd>';
    }
    // 获取用户未评论数据
    $review_html = '<dd class="'.$action_7.'"><a href="' . zen_href_link('orders_review','&from=order_details','SSL') . '">' . FS_ACCOUNT_ORDER_REVIEW_WRITE . '</a></dd>';
    //获取改码申请记录
    $res_obj = get_coding_request('list');
    $res_obj = $res_obj['data'];
    $total = $res_obj->total;//总条数

    $coding_requests_html = '';
    if($total > 0){
        $coding_requests_html = '<dl class="account-public-Navigation-dl">
                    <dt class="account-public-txt-16 account-public-color-232323 account-public-600">'.FS_ACCOUNT_CODING_REQUESTS.'</dt>
                    <dd class="'.$action_10.'"><a href="' . zen_href_link('coding_requests','','SSL') . '">'.FS_ACCOUNT_MY_CODING_REQUESTS.'</a></dd>
                </dl>';
    }
    $account_left_html = '
        <div class="account-public-left account-public-float-left account-public-background-White">
            <div class="account-public-left-head account-public-text-center account-public-background-White">
                <div class="account-left-portrait account-public-border-radius account-public-600">
                    <i class="iconfont icon account-public-color-616265">&#xf304;</i>
                </div>
                <p class="account-public-txt-16 account-public-color-232323">' . FS_ACCOUNT_NEW_01 . '</p>
                <dl class="account-left-head-dl">
                    <dt class="account-public-txt-14 account-public-color-232323">' . FS_ACCOUNT_ACCOUNT_MANAGER . ' <i class="iconfont icon account-public-transition">&#xf087;</i></dt>
                    <dd class="account-public-text-center">
                        <p class="account-public-txt-13 account-public-color-616265">' . $name . '</p>
                        <p class="account-public-txt-13 account-public-color-616265"><a href="mailto: ' . $email_name . '">' . $email_name . '</a></p>
                        <p class="account-public-txt-13 account-public-color-616265">' . FS_ACCOUNT_NEW_02 . '</p>
                        <p class="account-left-head-dl-live">
                            <i class="iconfont icon account-public-color-0070BC">&#xf209;</i>
                            <a class="account-public-color-0070BC" href="javascript:;" onclick="LC_API.open_chat_window();return false;">' . FS_ACCOUNT_LIVE_CHAT . '</a>
                        </p>
                        <p class="account-public-txt-14 account-public-color-616265 account-icon-margin"><i class="iconfont icon">&#xf005;</i> ' . $phone_code . '</p>
                    </dd>
                </dl>
            </div>
            <div class="account-public-Navigation-container">
                <dl class="account-public-Navigation-dl">
                    <dt class="account-public-txt-16 account-public-color-232323 account-public-600">' . FS_ACCOUNT . '</dt>
                    <dd class="'.$action_11.'"><a href="' . zen_href_link('my_dashboard','','SSL') . '">' . FS_MY_ACCOUNT . '</a></dd>
                    <dd class="'.$action_1.'"><a href="' . zen_href_link('edit_my_account','','SSL') . '">' . FS_ACCOUNT_MANAGE_SET . '</a></dd>
                        <dd class="'.$action_2.'"><a href="' . zen_href_link('manage_addresses','','SSL') . '">' . FS_ACCOUNT_MANAGE_ADDRESS . '</a></dd>
                    <dd class="'.$action_3.'"><a href="' . zen_href_link('my_cases','','SSL') . '">' . FS_ACCOUNT_SERVICE_CASES . '</a></dd>
                    ' . $my_credit_html . '
                </dl>
                <dl class="account-public-Navigation-dl">
                    <dt class="account-public-txt-16 account-public-color-232323 account-public-600">' . FS_ACCOUNT_NEW_03 . '</dt>
                    <dd class="'.$action_5.'"><a href="' . zen_href_link('manage_orders','','SSL') . '">' . FS_ACCOUNT_ORDER_HIS . '</a></dd>
                    <dd class="'.$action_6.'"><a href="' . zen_href_link('return_guidelines','','SSL',true) . '">' . FS_RETURN_BUTTON . '</a></dd>
                    ' . $review_html . '
                    <dd><a target="_blank" href="' . reset_url('policies/net_30.html') . '">' . FS_ACCOUNT_BUSINESS_PURCHASE_ORDER . '</a></dd>
                </dl>
                <dl class="account-public-Navigation-dl">
                    <dt class="account-public-txt-16 account-public-color-232323 account-public-600">' . FS_ACCOUNT_BUSINESS_QUOTES . '</dt>
                    <dd class="'.$action_8.'"><a href="' . zen_href_link('inquiry_list','','SSL') . '">' . FS_ACCOUNT_BUSINESS_MY_QUOTES . '</a></dd>
                    <dd class="'.$action_9.'"><a target="_blank" href="' . zen_href_link('inquiry','','SSL') . '">' . FS_INQUIRY_INFO_25 . '</a></dd>
                </dl>
                '.$coding_requests_html.'
            </div>
        </div>';


    $coding_requests_html = '';
    if($total > 0){
        $coding_requests_html = '<dl class="m-acc-dl">
                        <dt class="account-public-txt-16 account-public-color-232323 account-public-600">'.FS_ACCOUNT_CODING_REQUESTS.'</dt>
                        <dd><a href="' . zen_href_link('coding_requests','','SSL') . '">'.FS_ACCOUNT_MY_CODING_REQUESTS.'</a></dd>
                    </dl>';
    }

    //手机端dom结构
    $account_left_html_m = '
        <div class="m-account-Navigation">
            <div class="m-account-Navigation-dl account-public-background-White">
                <div class="account-public-txt-20 account-public-color-232323 m-nav-tit">' . $navi_title_m . ' <i class="iconfont icon account-public-float-right account-public-400 account-public-transition">&#xf087;</i></div>
                <div class="m-account-Navigation-dl-dd">
                    <dl class="m-acc-dl">
                        <dt class="account-public-txt-16 account-public-color-232323 account-public-600"><a href="' . zen_href_link('my_dashboard','','SSL') . '">' . FS_ACCOUNT . '</a></dt>
                        <dd><a href="' . zen_href_link('my_dashboard','','SSL') . '">' . FS_MY_ACCOUNT . '</a></dd>
                        <dd><a href="' . zen_href_link('edit_my_account','','SSL') . '">' . FS_ACCOUNT_MANAGE_SET . '</a></dd>
                        <dd><a href="' . zen_href_link('manage_addresses','','SSL') . '">' . FS_ACCOUNT_MANAGE_ADDRESS . '</a></dd>
                        <dd><a href="' . zen_href_link('my_cases','','SSL') . '">' . FS_ACCOUNT_SERVICE_CASES . '</a></dd>
                        ' . $my_credit_html . '
                    </dl>
                    <dl class="m-acc-dl">
                        <dt class="account-public-txt-16 account-public-color-232323 account-public-600">' . FS_ACCOUNT_NEW_03 . '</dt>
                        <dd><a href="' . zen_href_link('manage_orders','','SSL') . '">' . FS_ACCOUNT_ORDER_HIS . '</a></dd>
                        <dd><a href="' . zen_href_link('return_guidelines','','SSL',true) . '">' . FS_RETURN_BUTTON . '</a></dd>
                        ' . $review_html . '
                        <dd><a href="' . reset_url('policies/net_30.html') . '">' . FS_ACCOUNT_BUSINESS_PURCHASE_ORDER . '</a></dd>
                    </dl>
                    <dl class="m-acc-dl">
                        <dt class="account-public-txt-16 account-public-color-232323 account-public-600">' . FS_ACCOUNT_BUSINESS_QUOTES . '</dt>
                        <dd><a href="' . zen_href_link('inquiry_list','','SSL') . '">' . FS_ACCOUNT_BUSINESS_MY_QUOTES . '</a></dd>
                        <dd><a href="' . zen_href_link('inquiry','','SSL') . '">' . FS_QUOTE_INFO_12 . '</a></dd>
                    </dl>
                    '.$coding_requests_html.'
                </div>
            </div>
            
            
            <div class="m-account-Navigation-need account-public-background-White">
                <div class="m-account-Navigation-need-top account-public-after">
                    <p class="account-public-txt-18 account-public-color-232323 ">' . FS_ACCOUNT_NEW_01 . '</p>
                    <p class="account-left-head-dl-live account-public-float-right account-public-txt-14 account-public-color-0070BC">
                        <i class="iconfont icon account-public-color-0070BC">&#xf209;</i>
                        <a class="account-public-color-0070BC" href="javascript:;" onclick="LC_API.open_chat_window();return false;">' . FS_ACCOUNT_LIVE_CHAT . '</a>
                    </p>
                </div>
                <dl class="m-account-Navigation-need-dl">
                    <dt class="account-public-txt-16 account-public-color-232323">' . FS_ACCOUNT_ACCOUNT_MANAGER . '  <i class="iconfont icon account-public-float-right account-public-400 account-public-transition">&#xf087;</i></dt>
                    <dd><i class="iconfont icon">&#xf145;</i> ' . $name . '</dd>
                    <dd><i class="iconfont icon">&#xf227;</i> <a href="mailto: ' . $email_name . '">' . $email_name . '</a></dd>
                    <dd><i class="iconfont icon">&#xf323;</i>' . FS_ACCOUNT_NEW_02 . '</dd>
                    <dd><i class="iconfont icon">&#xf005;</i>' . $phone_code . '</dd>
                    
                </dl>
            </div>
        </div>';

    $return = array(
        'apply_data' => $apply_info,
        'navi_html' => $account_left_html,
        'navi_html_m' => $account_left_html_m
    );
    return $return;
}

//查询最新浏览记录
function get_recently_viewed(){
    global $fsCurrentInquiryField;
    $str = '';
    if(isset($_COOKIE['fs_views'])){
        global $currencies;
        require_once DIR_WS_CLASSES.'fs_reviews.php';
        $fs_reviews =new fs_reviews();
        if(isMobile()){
            $str .= '<p class="account-public-txt-20 account-public-color-232323 m-account-content-tit">'.FS_ACCOUNT_NEW_10.'</p>';
        }else{
            $str .= '<p class="account-public-txt account-public-txt-20 account-public-color-232323">'.FS_ACCOUNT_NEW_10.'</p>';
        }
        $str .= '<div class="account-Recently-bottom">';
        $str .= '<div class="v_show_shopping_cart shopcart-carousel-wrap">';
        $str .= '<div class="v_show">';
        $pIDs = array_reverse(explode('|',$_COOKIE['fs_views']));
        $wholesale_products = fs_get_wholesale_products_array();
        if($pIDs){
            $str.= '<div class="swiper-container swiper-container-horizontal" style="display:block;">';
            $str.= '<div class="swiper-wrapper">';
            foreach($pIDs as $value=>$pID) {
                $status = 0;
                $is_inquiry = 0;
                if ($pID) {
                    $pData = fs_get_data_from_db_fields_array(['products_status',$fsCurrentInquiryField],'products','products_id=' . (int)$pID, 'limit 1');
                    $status = $pData[0][0];
                    $is_inquiry = $pData[0][1];
                }
                if ($status == 1) {
                    $current_product_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . (int)$pID, 'NONSSL');
                    if ($is_inquiry == 1) {
                        $final_price = '<a href="' . $current_product_link . '" target="_blank">' . GET_A_QUOTE . '</a>';
                    } else {

                        $is_composite_products = false;
                        if (class_exists('classes\CompositeProducts')) {
                            $CompositeProducts = new classes\CompositeProducts(intval($pID));
                            $composite_product_price = $CompositeProducts->get_composite_product_price(false);
                            if(!empty($composite_product_price['composite_product_price'])){
                                $is_composite_products = true;
                            }
                        }
                        if ($is_composite_products) {//判断是否是组合产品
                            $final_price = $composite_product_price['composite_product_price_str'];
                        }else {

                            if (!in_array($pID, $wholesale_products)) {
                                $final_price = $currencies->new_display_price(zen_get_products_base_price((int)$pID), 0);
                            } else {
                                $final_price = $currencies->display_price(zen_get_products_base_price((int)$pID), 0);
                            }
                        }
                    }
                    if (zen_get_products_name($pID, $_SESSION['langusges_id']) != null) {
                        $str.='<div class="swiper-slide swiper-no-swiping">
                              <div class="list_10">
                              <a target="_blank" href="' . $current_product_link . '">' . get_resources_img($pID, '120', '120') . '</a>
                              </div><span><a target="_blank" href="' . $current_product_link . '" title="' . zen_get_products_name($pID, $_SESSION['langusges_id']) . '" >' . zen_get_products_name($pID, $_SESSION['langusges_id']) . '</a>
                              </span>' . '<p>' . $final_price . '</p>
                              <div class="shopcart-products-reviews after">' . $fs_reviews->get_product_list_review_show($pID) . '
                              </div></div>';
                    }
                }
            }
            $str .= '</div>';
            $str.= '<div class="swiper-button-prev icon iconfont">&#xf090;</div>';
            $str .= '<div class="swiper-button-next icon iconfont">&#xf089;</div>';

            $str .= '</div>';
        }
        $str .= '</div></div></div>';
    }
    return $str;
}
//获取87233的子产品html
function get_son_products_html($main_product_qty,$currency,$currency_value){
    $son_products_html ='';
    $currencies = new currencies();
    $son_products = array(
        '84489'=>array(
            'products_name' => zen_get_products_name(84489,$_SESSION['languages_id']),
            'products_price' => zen_get_products_final_price(84489,$currency),
            'products_img' => HTTPS_IMAGE_SERVER .'images/return_03.png',
        ),
        '84488'=>array(
            'products_name' => zen_get_products_name(84488,$_SESSION['languages_id']),
            'products_price' => zen_get_products_final_price(84488,$currency),
            'products_img' => HTTPS_IMAGE_SERVER .'images/return_02.png',
        ),
        '84490'=>array(
            'products_name' => zen_get_products_name(84490,$_SESSION['languages_id']),
            'products_price' => zen_get_products_final_price(84490,$currency),
            'products_img' => HTTPS_IMAGE_SERVER .'images/return_01.png',
        ),
    );
    if(isMobile()){
        $son_products_html .= '<div class="order_return" style="width: auto;"><i class="iconfont icon"></i>'.FS_RETURN_ALL_MTP_PRODUCTS.'</div>';
    }
    $son_products_html .= '<div class="new_run_click active">
                                <span>'.FS_ITEM_INCLUDES_PRODUCTS.'</span>
                                <i class="iconfont icon">&#xf087;</i>
                            </div>
                            <div class="new_run_border mtp_return"></div>
                            <div class="new_return_table alone_left_top new_run_junior mtp_return">';
    foreach ($son_products as $key=>$son) {
        $son_products_html .= '
                              <div class="new_return_tr">
                                <div class="new_return_td new_run_td_one">
                                    <div class="new_run_content">
                                        <div class="new_run_wap active">
                                            <div class="quest_img alone_float mtp_return">
                                                <img src="'.$son['products_img'].'" width="80" height="80">
                                            </div>
                                            <div class="quest_txt_wap alone_float mtp_return">
                                                <p class="quest_txt01">'.$son['products_name'].'</p><span class="quest_pic">'.$main_product_qty.' x '.$currencies->total_format($son['products_price'],true,$currency,$currency_value).'/'.MANAGE_ORDER_EA.'</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>';
    }
    $son_products_html .='</div>';
    return $son_products_html;
}

function local_date_time($time = '')
{
    $date_time = [
        'jp' => date('Y/m/d', $time),
        'es' => date('d/m/Y', $time),
        'de' => date('d.m.Y', $time),
        'fr' => date('d/m/Y', $time),
    ];
    if (!$date_time[$_SESSION['languages_code']]) return date('d/m/Y', $time);
    return $date_time[$_SESSION['languages_code']];
}

//打印发票页面 Vat No. 表达优化
function get_vat_number_str($country_code){
    $vat_number_str = '';
    if($country_code){
        $country_code = strtoupper($country_code);
        switch ($country_code){
            case 'AU':
                $vat_number_str = FS_VAT_NO_AU;
                break;
            case 'BR':
                $vat_number_str = FS_VAT_NO_BR;
                break;
            case 'CL':
                $vat_number_str = FS_VAT_NO_CL;
                break;
            case 'AR':
                $vat_number_str = FS_VAT_NO_AR;
                break;
            default:
                if(all_german_warehouse('country_code',$country_code)){
                    $vat_number_str = FS_VAT_NO_EU;
                }elseif (singapore_warehouse('country_code',$country_code) ){
                    $vat_number_str = FS_VAT_NO_SG;
                }else{
                    $vat_number_str = FS_VAT_NO_DEFAULT;
                }
        }
    }
    return $vat_number_str;
}

/**
 * add by rebirth 2019/08/20
 * 订单列表页 的 订单超时时间的倒计时功能
 *
 * @param $mid
 * @param $code
 * @param $page, list和details
 * @return string
 */
function get_show_end_time_str_new($mid, $code, $page='list')
{
    $orderOvertime = fs_get_one_data(TABLE_ORDERS_OVERTIME, " type=1 and orders_id=" . $mid, "*");
    $str = '';
    if (zen_not_null($orderOvertime['addtime'])) {
        $timeless = $orderOvertime['addtime'] - time();
        $timeStr = get_order_countdowm_str($timeless);
        $class = 'right-top';
        if ($page != 'list') {
            $class = 'middle-top';
        }
        $str .= '<div class="fs_account_order_transit_expire"><span id="show_end_time_' . $mid . '">' . $timeStr . '</span>
                    <div class="bubble-popover-wap m_account_bubble">
                        <div class="m-bubble-bg"></div>
                        <div class="bubble-popover">
                            <span class="iconfont icon bubble-icon"></span>
                            <div class="m-bubble-container">
                                <div class="bubble-frame middle-top">
                                    <a class="bubble_popup_close_a m_960_close new_m_icon_Close m-bubble-Close" href="javascript:;"><i class="iconfont icon"></i></a>
                                   
                                    <div class="bubble-arrow"></div>
                                    <div class="bubble-content">
                                        <p>' . get_payment_notice_string($code) . '</p>
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div>
                  </div>';
        $range = mt_rand(0, 5) + 8;
        $str .= '<script type="text/javascript">
                        var reloading = false;
                        setInterval(function () {
                            $.ajax({
                                url: "index.php?modules=ajax&handler=check_order_overtime&ajax_request_action=check_order_overtime",
                                type: "post",
                                data: {"mid":' . $mid . '},
                                dataType: "json",
                                success: function (res) {
                                if (res.code == 1){
                                    if (res.reload){
                                        if (!reloading){
                                            reloading = true;
                                            var html = \'<div class="spinWrap public_bg_wap background"><div class="bg_color"></div><div id="loader_order_alone" class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div></div>\';
                                            $("body").append(html);
                                            window.location.href = \'' . zen_href_link('manage_orders', '', 'SSL') . '\';
                                        }                                        
                                    }else{
                                        $("#show_end_time_"+' . $mid . ').html(res.str)
                                    }
                                }
                            }
                            })
                        },' . $range . ' * 1000);
                    </script>';
    }else{
        //订单倒计时功能上线前的旧pending单数据 19年及之前的都直接取消
        $orders_number = fs_get_data_from_db_fields('orders_number','orders','orders_id='.$mid,'limit 1');
        $year = substr($orders_number,2,2);
        if($year<20){
            $orderService = new App\Services\Orders\OrderService;
            $reason_data = array(
                'reason' => "Others",
                'reason_type' => 9,
                'cancel_reason' => "order is canceled by system automatically for timeout unpaid 处理人:system",
            );
            //取消订单相关操作
            $orderService->updateCancelOrderStatus($mid, $reason_data, 2);
        }
    }

    return $str;
}

/** 同 zen_get_rma_warehouse_address html结构不同
 * @param $country_id
 * @param $is_reissue
 * @return string
 */
function zenGetRmaWarehouseAddressNew($country_id, $is_reissue){
    $warehouse_address = '';
    if(all_german_warehouse('country_number',$country_id)){
        if($is_reissue == 7){
            //中国直发订单退回到德国仓
            $warehouse_address = FS_RMA_WAREHOUSE_EU;
        }else {
            //欧盟及欧盟周边国家退换货地址为德国仓
            $warehouse_address = FS_RMA_WAREHOUSE_EU;
        }
    }elseif(in_array($country_id,[13,153]) && in_array($is_reissue, [9,10])){
        $warehouse_address = FS_RMA_WAREHOUSE_AU;
//        }
    } elseif (in_array($country_id, [44, 96, 125, 206])) {
        // 中国大陆、港澳台退到武汉仓
        $warehouse_address = FS_RMA_WAREHOUSE_CN;
    } elseif (ru_warehouse('country_number', $country_id)) {
        //俄罗斯退到俄罗斯仓
        $warehouse_address = FS_RMA_WAREHOUSE_RU;

    } elseif (seattle_warehouse('country_number', $country_id)) {
        //美国仓为发货仓，本地仓发货（包含转运后本地发货）退回对应本地仓；中国直发订单退回美东仓
        $warehouse_address = FS_RMA_WAREHOUSE_US_EAST;
    } else {
        // 1、收货地址为新加坡覆盖11国，不论从哪里发货；2、收货地址为除中国大陆、港澳台、俄罗斯的其它武汉仓
        // 3、收件地址为澳大利亚和新西兰，且订单从武汉仓直发，4、其它情况
        $warehouse_address = FS_RMA_WAREHOUSE_SG;
    }
    return $warehouse_address;
}

?>

