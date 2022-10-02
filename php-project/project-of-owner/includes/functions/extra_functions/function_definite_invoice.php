<?php

function get_products_instock_shipping($products_instock_id){
    global $db;
    $sql = 'select * from products_instock_shipping where products_instock_id = '.$products_instock_id .' limit 1';
    $info = $db->Execute($sql);
    if($info->RecordCount()){
        while(!$info->EOF){
            $invocie_info[] = array(
                'shipping_number'  => $info->fields['shipping_number'],
                'shipping_date' => $info->fields['shipping_date'],
                'orders_num' => $info->fields['orders_num'],
                'order_number' => $info->fields['order_number'],
                'No' => $info->fields['No'],
                'order_po' => $info->fields['order_po'],
                'cancel_order_status' => $info->fields['cancel_order_status'],
                'delete_orders_payment' => $info->fields['delete_orders_payment'],
                'is_split' => $info->fields['is_split'],
                'is_not_transport' => $info->fields['is_not_transport'],
                'is_packing' => $info->fields['is_packing'],
                'transport_id' => $info->fields['transport_id'],
                'transport_receive' => $info->fields['transport_receive'],
                'is_seattle' => $info->fields['is_seattle'],
                'is_pickup' => $info->fields['is_pickup'],
                'express_account' => $info->fields['express_account'],
                'tax_rate' => $info->fields['tax_rate'],
            );
            $info->MoveNext();
        }
    }
    return $invocie_info[0];
}
//获取后台发票相关信息
function get_invoice_info($products_instock_id){
    global $db;
    $sql = "select id,in_number,blind_shipping,id,invocie_date,is_created_pdf,email_status,amount_number,status,relate_id from fs_invoice_number where status!=1 and type=1 and relate_id=".$products_instock_id." limit 1";
    $info = $db->getAll($sql);
    return $info[0];
}

/*
 *根据订单发货仓匹配订单发货主体(后台获取)
 * @param $products_instock_id
 * @param $orders_id
 * @type   0返回字符串   1返回数组
 * @return  string
 */
function getOrderDeliveryAddress($products_instock_id, $type=0){
    global $db;
    $addrStr = '';
    $sql = "SELECT p.`is_seattle`,p.`sales_update_time`,p.`is_not_transport`,pf.`is_sz_transport`,pf.`is_sz_forwarder`,p.`orders_id`,p.`vat_number`,p.`is_inspection`,pf.`is_gsp` FROM `products_instock_shipping` AS p LEFT JOIN `products_instock_shipping_fields` AS pf ON p.`products_instock_id` =pf.`products_instock_id` WHERE p.`products_instock_id` =".(int)$products_instock_id;
    $instockData =$db->Execute($sql);
    $company_name = '<b>FS. COM LIMITED</b>';
    if ($instockData->fields['sales_update_time'] < '2020-03-27 00:00:00'){
        $company_name = '<b>FIBERSTORE CO.,LIMITED</b>';
    }
    if ($instockData->fields['is_seattle']==5 || $instockData->fields['is_not_transport']==5 || $instockData->fields['is_gsp'] == 1 || $instockData->fields['is_not_transport']==7){
        //美东直发 美东转运 德国-->美东转运
        $addrStr = FS_DEFINITE_INVOICE_01;
    }elseif ($instockData->fields['is_seattle'] == 4 || $instockData->fields['is_not_transport'] ==4){
        //澳洲发货或澳洲转运
        $addrStr = FS_DEFINITE_INVOICE_02;
    }elseif ($instockData->fields['is_seattle'] == 3 || $instockData->fields['is_not_transport'] ==3){
        //德国发货或德国转运
        $addrStr = FS_DEFINITE_INVOICE_03 . 'DE313377831';
        //个体客户税号展示改变  （Monaco-FR841149644；Isle of Man-GB312920435）
        //查客户国家
        $countriesId = 0;
        if ($instockData->fields['orders_id']) {
            $ordersData = $db->getAll('select delivery_country,delivery_company_type,billing_country,billing_company_type from orders where orders_id ='.(int)$instockData->fields['orders_id']);
            $ordersData = $ordersData[0];
            if ($ordersData['billing_company_type'] == 'IndividualType') { //个体客户
                if (in_array($ordersData['delivery_country'],['United Kingdom','Isle of Man'])) {
                    //账单地址是 英国，马恩岛 显示税号GB312920435
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'DE313377831'; //英国脱欧 不再是超限国家 统一展示DE313377831
                }
                if (in_array($ordersData['delivery_country'],['Monaco','France'])) {
                    //账单地址是 摩纳哥，法国 显示税号FR55841149644
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'FR55841149644';
                }
                if (in_array($ordersData['delivery_country'],['Sweden'])) {
                    //账单地址是瑞典税号为SE502082260601
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'SE502082260601';
                }
                if (in_array($ordersData['delivery_country'],['Netherlands'])) {
                    //账单地址是荷兰税号为NL825896058B01
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'NL825896058B01';
                }
                if (in_array($ordersData['delivery_country'],['Spain'])) {
                    //账单地址是荷兰税号为NL825896058B01
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'N2767136A';
                }
                if (in_array($ordersData['delivery_country'],['Belgium'])) {
                    //账单地址是比利时税号为BE0753932104
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'BE0753932104';
                }
                if ($ordersData['delivery_country'] == 'Italy') {
                    //账单地址是 英国，马恩岛 显示税号IT00238699995
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'IT00238699995';
                }
                if ($ordersData['delivery_country'] == 'Denmark') {
                    //账单地址是 丹麦 显示税号DK41743034
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'DK41743034';
                }
            }

            if($ordersData['delivery_country'] == 'Belgium' && $ordersData['billing_country'] == 'United States' && $ordersData['billing_company_type'] == 'IndividualType'){
                //账单地址是比利时税号为BE0753932104
                $addrStr = FS_DEFINITE_INVOICE_03 . 'BE0753932104';
            }

        } else {
            $addressData = $db->getAll('select entry_country_id,delivery_company_type,billing_country_id,billing_company_type from products_instock_shipping_OrderAddress where products_instock_id ='.(int)$products_instock_id);
            $addressData = $addressData[0];
            $countriesId = $addressData['entry_country_id'];
            if ($addressData['billing_company_type'] == 2 || (!$instockData->fields['vat_number'] && $addressData['billing_company_type'] == 0)) {
                if (in_array($countriesId,[141,73])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'FR55841149644';
                }
                if (in_array($countriesId,[222,244])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'DE313377831'; //英国脱欧 不再是超限国家 统一展示DE313377831
                }
                if (in_array($countriesId,[203])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'SE502082260601';
                }
                if (in_array($countriesId,[150])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'NL825896058B01';
                }
                if (in_array($countriesId,[195])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'N2767136A';
                }
                if (in_array($countriesId,[105])) {
                    $addrStr = FS_DEFINITE_INVOICE_03 . 'IT00238699995';
                }
            }
        }
    }elseif ($instockData->fields['is_seattle'] == 7){
        //新加坡
        $addrStr = FS_DEFINITE_INVOICE_04;
    }elseif($instockData->fields['is_not_transport'] ==8){
        //俄罗斯转
        $addrStr = FS_DEFINITE_INVOICE_05;
    }elseif ($instockData->fields['is_seattle'] ==0){
        //国内发货
        if (!in_array($instockData->fields['is_inspection'], [0, 3]) && $instockData->fields['is_sz_transport'] == 2) {
            //海外调仓单（NC/DE/AU/SG/UK及调仓单组成的HF单）全部龙华海外调仓由龙华仓发出其他发华南
            $warehouse = $db->Execute("SELECT p.warehouse FROM `products_instock_shipping` pi left join products_instock_shipping_info psi on (pi.`products_instock_id`= psi.`products_instock_id`) left join products_instock p on (p.products_instock_id = psi.instock_id) WHERE pi.`products_instock_id` = ".$products_instock_id." limit 1")->fields['warehouse'];
            if($warehouse==113){
                $addrStr = $company_name.FS_DEFINITE_INVOICE_06;
            }else{
                $addrStr = $company_name.FS_DEFINITE_INVOICE_07;
            }
        } elseif ($instockData->fields['is_sz_transport'] == 0 && $instockData->fields['is_sz_forwarder'] == 0) {
            //整单武汉
            $addrStr = FS_DEFINITE_INVOICE_08;
        } elseif (in_array($instockData->fields['is_sz_transport'], array(1, 2)) || $instockData->fields['is_sz_forwarder'] == 1) {
            //深圳转运+深圳货代转运
            $addrStr = $company_name.FS_DEFINITE_INVOICE_09;
        }
    } else {
        //默认
        $addrStr = '<b>FS.COM LIMITED</b>'.FS_DEFINITE_INVOICE_09;
    }
    $productsInfo= fs_get_data_from_db_fields_array(array('is_packing','sales_update_time'),'products_instock_shipping','products_instock_id ='.$products_instock_id);
    if($type==1){
        $cgStr =str_replace('</b>','|',str_replace('<b>','|',$addrStr));
        $str = str_replace('</br>','|',$cgStr);
        $addrArr =explode('|',$str);
        //2019.5.13 SQ20190513004  国内发票不显示电话信息
        if ($instockData->fields['is_seattle']==0 && in_array($instockData->fields['is_not_transport'], [0,1]) &&  ($instockData->fields['is_sz_transport'] == 1 || $instockData->fields['is_sz_forwarder'] == 1 || ($instockData->fields['is_sz_transport'] == 2 && in_array($instockData->fields['is_inspection'], [0, 3])))){
            array_pop($addrArr);
        }
        //旧数据已装箱订单保留之前规则
        if($productsInfo[0][0] == 1 && $productsInfo[0][1] < '2019-05-08 00:00:00'){
            $addrArr = [];
        }
        return $addrArr;
    }else{
        if($productsInfo[0][0] == 1 && $productsInfo[0][1] < '2019-05-08 00:00:00'){
            $addrStr =FS_DEFINITE_INVOICE_10;
        }
        return $addrStr;
    }
}


//获取订单装箱数量
function get_package_num($products_instock_id)
{
    global $db;
    $get_package_num_sql = "SELECT COUNT(`products_instock_shipping_parcel_id`) as num FROM `products_instock_shipping_parcel` WHERE `products_instock_id`=".(int)$products_instock_id;
    $get_package_num = $db->Execute($get_package_num_sql);
    return $get_package_num->fields['num'];
}

/*
 *获取发票产品展示板块
 * @param array $ordersData 发票订单相关信息
 * @param $warehouse_type  仓库区分
 * @param $products_instock_id
 * @return  string
 */
function get_product_invoice($ordersData,$warehouse_type,$products_instock_id){
    global $db,$currencies;
    $product_invoice_arr = array();
    $product_table_html = '';
    //var_dump($ordersData);
    $orderNum =sizeof($ordersData['son_orders']);
    if($orderNum) {
        switch ($warehouse_type){
            case 2:
                 foreach ($ordersData['son_orders'] as $k => $order_v) {
                    foreach ($order_v['products'] as $key => $product) {
                        //获取HS code
                        $declaration = $db->Execute("SELECT di.HS_code
                    FROM declaration_information di 
                    LEFT JOIN products_system_number psn ON (di.declaration_information_id=psn.declaration_information_id)
                    LEFT JOIN products p ON (p.system_number_id=psn.system_number_id) WHERE p.products_id= " . (int)$product['products_id']);//报关信息
                        $hs_code = $declaration->fields['HS_code'] ? $declaration->fields['HS_code'] :'';
                        //获取单个产品后台包装单号
                        $package_no = $db->Execute('select pi.orders_num 
                    from products_instock_shipping as pi 
                    left join products_instock_shipping_info as psi 
                    using (products_instock_id) 
                    where psi.products_instock_id = ' .$products_instock_id. ' and psi.products_id = '.(int)$product['products_id']);
                        $productsMessage = $product['products_name'] . '<br/>' . FS_INVOICE_PRODUCT_01 . $hs_code . '<br>' . FS_INVOICE_PRODUCT_02 . (int)$product['products_id'];//装箱描述
                        $product_table_html .= '<tr align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $productsMessage . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $package_no->fields['orders_num'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['products_quantity'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['final_price_currency'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['total_price_currency'] . '</td>';
                        $product_table_html .= '</tr>';
                    }
                    $product_invoice_arr = array(
                        'product_table_html' => $product_table_html
                    );
                }
                break;
            case 3:
                 foreach ($ordersData['son_orders'] as $k => $order_v) {
                    foreach ($order_v['products'] as $key => $product) {
                        //获取HS code
                        $declaration = $db->Execute("SELECT di.HS_code
                    FROM declaration_information di 
                    LEFT JOIN products_system_number psn ON (di.declaration_information_id=psn.declaration_information_id)
                    LEFT JOIN products p ON (p.system_number_id=psn.system_number_id) WHERE p.products_id= " . (int)$product['products_id']);//报关信息
                        $hs_code = $declaration->fields['HS_code'] ? $declaration->fields['HS_code'] :'';
                        $product_table_html .= '<tr align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $product['products_name'] . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $product['products_model'] . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $hs_code . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $product['products_id'] . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['products_quantity'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['final_price_currency'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['total_price_currency'] . '</td>
                    </tr>';
                    }
                    $product_invoice_arr = array(
                        'product_table_html' => $product_table_html
                    );
                }
                break;
            case 4:
                 foreach ($ordersData['son_orders'] as $k => $order_v) {
                    foreach ($order_v['products'] as $key => $product) {
                        //获取HS code
                        $declaration = $db->Execute("SELECT di.HS_code
                    FROM declaration_information di 
                    LEFT JOIN products_system_number psn ON (di.declaration_information_id=psn.declaration_information_id)
                    LEFT JOIN products p ON (p.system_number_id=psn.system_number_id) WHERE p.products_id= " . (int)$product['products_id']);//报关信息
                        $hs_code = $declaration->fields['HS_code'] ? $declaration->fields['HS_code'] :'';
                        $productsMessage = $product['products_name'] . '<br/>' . FS_INVOICE_PRODUCT_01 . $hs_code . '<br>' . FS_INVOICE_PRODUCT_02.(int)$product['products_id'];//装箱描述
                        $product_table_html .= '<tr align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $productsMessage . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['products_quantity'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['final_price_currency'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['total_price_currency'] . '</td>';
                        $product_table_html .= '</tr>';
                    }
                    $product_invoice_arr = array(
                        'product_table_html' => $product_table_html
                    );
                }
                break;
            case 5:
                 foreach ($ordersData['son_orders'] as $k => $order_v) {
                    foreach ($order_v['products'] as $key => $product) {
                        //获取HS code
                        $declaration = $db->Execute("SELECT di.HS_code
                    FROM declaration_information di 
                    LEFT JOIN products_system_number psn ON (di.declaration_information_id=psn.declaration_information_id)
                    LEFT JOIN products p ON (p.system_number_id=psn.system_number_id) WHERE p.products_id= " . (int)$product['products_id']);//报关信息
                        $hs_code = $declaration->fields['HS_code'] ? $declaration->fields['HS_code'] :'';
                        //获取单个产品后台包装单号
                        $package_no = $db->Execute('select pi.orders_num 
                    from products_instock_shipping as pi 
                    left join products_instock_shipping_info as psi 
                    using (products_instock_id) 
                    where psi.products_instock_id = ' .$products_instock_id. ' and psi.products_id = '.(int)$product['products_id']);
                       $product_table_html .= '<tr align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $product['products_name'] . '<br/>' . FS_INVOICE_PRODUCT_01 . $hs_code . '<br>' . FS_INVOICE_PRODUCT_02 . (int)$product['products_id'] .'
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $package_no->fields['orders_num'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['products_quantity'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['final_price_currency'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['total_price_currency'] . '</td>';
                        $product_table_html .= '</tr>';
                    }
                    $product_invoice_arr = array(
                        'product_table_html' => $product_table_html
                    );
                }
                break;
            default :
                //us code
                $isCountry = false;
                if (in_array(trim($ordersData['delivery_country']),['United States','Puerto Rico'])) {
                    $isCountry = true; //发美国的规则 PuertoRico的规则与美国一致
                }
                //清洁笔赋值变量
                $allCleanStatus = true;
                //var_dump($ordersData['products']);
                //var_dump($ordersData['delivery_country']);
                //清洁笔对应产品id
                $cleanArr = [70807,70806,39725,39721,39697];
                foreach ($ordersData['son_orders'] as $k => $order_v) {
                    foreach ($order_v['products'] as $key => $product) {
                        if (!in_array($product['products_id'], $cleanArr)) {
                            //是否整单清洁笔
                            $allCleanStatus = false;
                        }
                        $declaration = $db->Execute("SELECT di.`us_code`,di.HS_code
                    FROM declaration_information di 
                    LEFT JOIN products_system_number psn ON (di.declaration_information_id=psn.declaration_information_id)
                    LEFT JOIN products p ON (p.system_number_id=psn.system_number_id) WHERE p.products_id= " . (int)$product['products_id']);//报关信息
                        $usCode = $declaration->fields['us_code'];
                        $productsMessage = $product['products_name'] . '<br/>' . FS_INVOICE_PRODUCT_01 . $declaration->fields['HS_code'];//装箱描述
                        $product_table_html .= '<tr align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">
                        ' . $productsMessage . '
                    </td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['products_quantity'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['final_price_currency'] . '</td>
                    <td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $product['total_price_currency'] . '</td>';
                        if ($isCountry) {
                            $product_table_html .= '<td style="border-top: 0;padding-left: 5px;padding-right: 5px;">' . $usCode . '</td>';
                        }
                        $product_table_html .= '</tr>';
                    }
                    $product_invoice_arr = array(
                        'product_table_html' => $product_table_html,
                        'allCleanStatus' => $allCleanStatus,
                        'isCountry' => $isCountry
                    );
                }
                break;
        }

    }
    return $product_invoice_arr;
}

//判断订单属于哪个仓库发货
//$is_reissue  is_reissue字段区分订单发货状态
//$warehouse_type  1 武汉仓 2澳大利亚仓 3德国仓 4美东仓 5新加坡仓 6深圳仓 7俄罗斯仓
function get_show_warehouse_type($is_reissue = 0, $delivery_country_id){
    if (in_array($delivery_country_id,array(223,172))) {
        $warehouse_type = 4;
    } else {
        switch ($is_reissue){
            case 7:
            case 11:
            case 14:
            case 25:
                $warehouse_type = 1;
                break;
            case 9:
            case 10:
                $warehouse_type = 2;
                break;
            case 6:
            case 8:
            case 20:
                $warehouse_type = 3;
                break;
            case 12:
            case 13:
                $warehouse_type = 4;
                break;
            case 24:
                $warehouse_type = 5;
                break;
            case 4:
            case 5:
                $warehouse_type = 6;
                break;
            case 26:
            case 27:
            case 28:
                $warehouse_type = 7;
                break;
            default :
                $warehouse_type = 0;
                break;
        }
    }
    return $warehouse_type;
}

//获取订单在后台进行取消 拆单 改单
function get_invoice_orders_type($instock_shipping_info, $products_instock_id, $status = 'orders'){
    global $db;
    //取消订单
    $cancel_orders = false;
    //拆单
    $demolition_orders = false;
    //改单
    $change_orders = false;
    //真实发票订单发货节点
    $isDeliver = false;
    if($products_instock_id){
        //该查询判断订单后台是否进行改单
        $apply_info = $db->Execute('select count(*) as total from products_instock_shipping_apply where apply_type = 23 and status =1 and products_instock_id = '.$products_instock_id);
        if($apply_info->fields['total'] > 0){
            $change_orders = true;
        }
        if(isset($instock_shipping_info) && !empty($instock_shipping_info)){
            if($instock_shipping_info['cancel_order_status'] > 0 || in_array($instock_shipping_info['delete_orders_payment'],[1,3])){
                $cancel_orders = true;
            }
            if($instock_shipping_info['is_split'] == 1 && $status == 'orders'){
                $demolition_orders = true;
            }
            //真实发票订单发货节点 (国内直发-取件时点、转运订单or海外直发订单-海外发单号时点)
            if($instock_shipping_info['is_seattle']==0&&$instock_shipping_info['is_not_transport']<2&&$instock_shipping_info['transport_id']==0){
                if($instock_shipping_info['is_pickup']){
                    $isDeliver = true;//已发货
                }
            }elseif($instock_shipping_info['shipping_number']){
                $isDeliver = true;
            }
        }
    }
    $invoice_orders_type = array(
        'cancel_orders' => $cancel_orders,
        'demolition_orders' => $demolition_orders,
        'change_orders' => $change_orders,
        'isDeliver' => $isDeliver
    );
    return $invoice_orders_type;
}

//获取后台重开发票
function get_restart_invoice($products_instock_id){
    global $db;
    $info = $db->Execute('select status from products_instock_shipping_apply where is_advance = 2 and products_instock_id = '.$products_instock_id .' order by id desc limit 1');
    $status = $info->fields['status'];
    return $status;
}



//获取发票展示类型
function get_show_definite_invoice($orders_id, $orders_number, $order_date, $status = 'orders')
{
    global $db;
    $demolition_orders = false;
    $show_invoice = 1;
    $in_number = $orders_number;
    $oId = $orders_id;
    if ($status == 'orders_split') {
        $products_instock_id= fs_get_data_from_db_fields('products_instock_id','orders_split','orders_id = '.(int)$orders_id, 'limit 1');
    } else {
        $sql = "select products_instock_id from products_instock_shipping where orders_id = " . (int)$orders_id . " and delete_orders_payment =0 and cancel_order_status=0";
        $info = $db->getAll($sql);
        if (count($info) > 1) {
            //多条数据代表在后台进行了拆单
            $demolition_orders = true ;
        }
        $products_instock_id = $info[0]['products_instock_id'];
    }

    //限制真实发票在上线之后生效
    $nowDate = strtotime('2020-01-27 12:00:00');
    //$nowDate = strtotime('2020-05-27 12:00:00');
    $invoiceDate = strtotime($order_date);
    if ($invoiceDate > $nowDate) {
        if ($products_instock_id) {
            $instock_shipping_info = get_products_instock_shipping($products_instock_id);
            $invoice_orders_type = get_invoice_orders_type($instock_shipping_info, $products_instock_id, $status);
            $restart_invoice = get_restart_invoice($products_instock_id);
            if ($restart_invoice == 1 || $invoice_orders_type['demolition_orders'] || $invoice_orders_type['change_orders'] || $demolition_orders) {
                //后台是否重开发票 1重开 是否拆单 改单
                $show_invoice = 3;
            } else {
                if (!$invoice_orders_type['cancel_orders']) {
                    //cancel_orders
                    if($invoice_orders_type['isDeliver']){///真实发票订单发货节点
                        $invocie_info = get_invoice_info($products_instock_id);
                        $in_number =  $invocie_info['in_number'];
                        $show_invoice = 2;
                    }
                }
            }
        }
    }
    $invoiceData = array(
        'show_invoice' =>  $show_invoice,
        'in_number' => $in_number,
        'oId' => $oId
    );
    return $invoiceData;
}
