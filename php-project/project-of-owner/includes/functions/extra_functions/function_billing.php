<?php

function zen_get_currencies_value($id){
    global $db;
    $sql="select value from currencies where currencies_id=".(int)$id;
    $currencies = $db->Execute($sql);
    return $currencies->fields['value'];
}

function get_relate_orders_currencies($instock_id)
{
    $value1 = '';
    $order_rel_info = fs_get_data_from_db_fields_array_billing(array('orders_id', 'symbol_left'), 'products_instock_shipping', 'products_instock_id="' . $instock_id . '" ');
    if ($order_rel_info[0][1] > 0) {
        if ($order_rel_info[0][1] == 1) {
            $value1 = 1;
        } elseif ($order_rel_info[0][0]) {
            $value1 = fs_get_data_from_db_fields_billing('currency_value', 'orders', 'orders_id=' . (int)$order_rel_info[0][0] . ' limit 1');
        } else {
            $fieldsGroupId = (int)fs_get_data_from_db_fields_billing('group_id', 'products_instock_shipping_fields', 'products_instock_id=' . (int)$instock_id);
            $groupId = fs_get_data_from_db_fields_billing('group_id', 'currencies', 'currencies_id=' . (int)$order_rel_info[0][1], 'limit 1');
            if (!$fieldsGroupId || $fieldsGroupId == $groupId) {
                $value1 = fs_get_data_from_db_fields_billing('value', 'currencies', 'currencies_id=' . (int)$order_rel_info[0][1], 'limit 1');
            } else {
                $value1 = fs_get_data_from_db_fields_billing('value', 'currencies_group', 'currencies_id=' . (int)$order_rel_info[0][1] . ' and group_id=' . $fieldsGroupId, 'limit 1');
            }
        }
    }
    return $value1;
}

function zen_get_use_total_reserved_funds_value_new_billing($orders_id,$productInstockId,$currencies_id=1,$type=0){
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
    $value1=$value2=zen_get_currencies_value($currencies_id);
    if($productInstockId){
        $value1 = get_relate_orders_currencies($productInstockId);
        if($type!=2){
            $value2=$value1;
        }
    }
    $sql ='SELECT  currencies_id,reserved_money,currencies_value
	           FROM   reserved_funds_history  WHERE is_delete=0  '.$orders_limit.' ' ;
    $get_reserved = $db->Execute($sql);
    if ($get_reserved->RecordCount()){
        while (!$get_reserved->EOF){
            // 直接转换成订单币种  汇率不同则转换
            if($currencies_id!=$get_reserved->fields['currencies_id']){
                $currencies_parities_value=$get_reserved->fields['currencies_value'];//新预留款使用保存了汇率
                if(floatval($currencies_parities_value)==0){
                    $currencies_parities_value=zen_get_currencies_value($get_reserved->fields['currencies_id']);
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

function fs_is_include_fee($orderPayment){
    //财务录款包含手续费
    //财务录款包含手续费[2,6,1,16,20,21,22,23]
    //财务录款不包含手续费[3,8,12,13,24,25,26,27,28,29]
    //未知[14,15,19]
    if(in_array($orderPayment,[2,6,1,16,20,21,22,23,34])){
        return true;
    }else{
        return false;
    }
}

function fs_get_realtime_payment_array($type = 0, $type2 = 0)
{
    $paymentMethod = fs_get_data_from_db_fields_array_billing(['id', 'payment_image'], 'payment_method', '', '');
    $green = $yellow = [];
    foreach ($paymentMethod as $item) {
        if ($item[1] == 'greenfs_icon.png') {
            if ($type2 == 1 && $item[0] == 19) {
                continue;
            } else {
                $green[] = $item[0];
            }
        } else {
            $yellow[] = $item[0];
        }
    }

    if ($type == 0) {
        return $green;
    } else {
        return $yellow;
    }
}

function zen_get_currencies_name_of_left($id){
    global $db;
    $sql="select symbol_left,symbol_right from currencies where currencies_id=".(int)$id;
    $currencies = $db->Execute($sql);
    $symbolName = $currencies->fields['symbol_right'] ? $currencies->fields['symbol_right'] : $currencies->fields['symbol_left'];
    return $symbolName;
}

function fs_is_filling($oredrNumber){
    $num = preg_match("/-0\d{1}B/",$oredrNumber);
    if($num > 0){
        return true;
    }else{
        return false;
    }
}

function fs_get_data_from_db_fields_billing($columns, $table, $where, $oderby = '')
{
    global $db;
    $return = '';
    //$oder_by = $oderby ? $oderby : ' limit 1';
    $sql = "select " . $columns . " from " . $table . "  where " . $where . " $oderby ";
    $query = $db->Execute($sql);
    if ($query->RecordCount()) {
        $return = $query->fields[$columns];
    }
    return $return;
}

/*
 * 公用函数  返回数据表多个字段
 * $fields_array  字段数组  如  array('products_id','products_price')
 * $table         数据表       如  'products'
 * $where         条件            如  'products_stautus=1'
 * $oderby        排序            如  'order by products_sort'
 * */
function fs_get_data_from_db_fields_array_billing($fields_array, $table, $where, $oderby = '')
{
    global $db;
    $returns = array();
    $field = implode(",", $fields_array);
    $where = !empty($where) ? ' where ' . $where : '';
    $sql = "select " . $field . " from " . $table . $where . " $oderby ";
    $result = $db->Execute($sql);
    if ($result->RecordCount()) {
        while (!$result->EOF) {
            $temp = array();
            $result_fields = $final_fields = '';
            foreach ($fields_array as $column) {
                $final_fields = explode('.', $column);
                $result_fields = sizeof($final_fields) == 2 ? $final_fields[1] : $final_fields[0];
                $temp [] = $result->fields[$result_fields];
            }
            $returns [] = $temp;
            $result->MoveNext();
        }
    }
    return $returns;
}


/**
 * @describe
 * 获取订单/到款已结清状态
 * @param $productInstockId number 订单号
 * @param int $type number 0 默认返回标签 1默认返回是否已结清状态
 * @param false $click  bool  ture 返回可点击 false 不可点击
 * @return bool|string
 * @author smile
 * @emial ywjmylove@163.com
 * @Time 2021/1/20 下午 4:45
 */
function fs_get_settle_status($productInstockId, $type = 0, $click = false)
{
    global $db;
    $str = '';
    $is_over = false;
    $orders_info = fs_get_data_from_db_fields_array_billing(array('products_instock_id', 'amount_use', 'paypal_fee', 'amount_recived', 'symbol_left', 'order_price', 'order_payment', 'order_number', 'order_invoice', 'orders_num', 'delete_orders_payment', 'renling', 'bad_debts', 'vat_tax', 'return_order'), 'products_instock_shipping', 'products_instock_id = "' . $productInstockId . '"', ' limit 1 ');

    $paymentarr = fs_get_realtime_payment_array();

    if (in_array($orders_info[0][6],$paymentarr)){
        if ( $type == 1 ){
            return true;
        }
    }

    //获取退税申请金额
    $refund_tax = fs_get_data_from_db_fields_billing('apply_money', 'products_instock_shipping_refund_money_apply', 'is_delete=0 and status=1 and products_instock_id=' . (int)$productInstockId);
    if ($refund_tax) {
        $refund_tax = floatval($refund_tax);
        if (floatval($orders_info[0][13]) < $refund_tax) {//申请金额超过订单税费  则订单税费即为申请金额
            $refund_tax = floatval($orders_info[0][13]);
        }
    } else {
        $refund_tax = 0;
    }
    //是否补款
    $isFilling = fs_is_filling($orders_info[0][7]);
    //判断amount_recived是否等于order_price
    //获取货币符号
    $symbol = zen_get_currencies_name_of_left($orders_info[0][4]);
    if ($orders_info[0][3] && $orders_info[0][5] && ($orders_info[0][3] < $orders_info[0][5]) && !$orders_info[0][1]) {
        if (zen_not_null($orders_info[0][12])) {
            $jsonArr = json_decode($orders_info[0][12], true);
            foreach ($jsonArr as $val) {
                $fee = $val['fee'];
                $apply_type = $val['apply_type'];
            }
            $feePrint = $apply_type == 6 ? '折让' : '坏账';
            $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . " " . $symbol . ($orders_info[0][5] - $orders_info[0][3] - $refund_tax) . "</span>" .
                "<br><span class=\"label label-default\">" . trans2($feePrint) . " " . $symbol . $fee . "</span>";
            $is_over = false;
        } else {
            $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . " " . $symbol . ($orders_info[0][5] - $orders_info[0][3] - $refund_tax) . "</span>";
            $is_over = false;
        }
    } else {
        //判断是否为到款
        $is_info = fs_get_data_from_db_fields_billing('products_instock_id', 'products_instock_shipping_info', 'products_instock_id="' . $productInstockId . '"', ' limit 1 ');
        $greenPayment = fs_get_realtime_payment_array();
        if (!in_array($orders_info[0][6], $paymentarr) && empty($is_info)) {
            //根据付款方式判断amount_recived是否包含手续费
            if (fs_is_include_fee($orders_info[0][6]) || $isFilling) {
                $money = $orders_info[0][3] - $orders_info[0][1];
            } else {
                $money = $orders_info[0][3] + $orders_info[0][2] - $orders_info[0][1];
            }
            $status = true;//到款
        } else {
            $money = $orders_info[0][5] - $orders_info[0][1];
            $status = false;//订单
        }
        $money -= $refund_tax;
        $mount_compare = $money;
        // 加上使用预留款的钱
        $oID_reserved = $orders_info[0][7] ? $orders_info[0][7] : $orders_info[0][8];
        //订单才计算预留款
        if (!$status) {
            $reserved_funds_value = zen_get_use_total_reserved_funds_value_new_billing($oID_reserved, $productInstockId, $orders_info[0][4]);
        } else {
            $reserved_funds_value = 0;
        }
        //将预留款转换为订单货币
        /* if($orders_info[0][4]!=1){
            //获取汇率
            $value = get_relate_orders_currencies($orders_info[0][0]);
            $reserved_funds_value = $reserved_funds_value*$value;
        }*/
        if ($status) {
            $mount_compare += $reserved_funds_value;
        } else {
            $mount_compare = $mount_compare - $reserved_funds_value;
        }
        $mount_compare = round($mount_compare, 2);
        //如果是维修单且没有维修产品,显示结清
        $repairFlag = false;
        if (preg_match("/(-[0-9]{2}W)$/", $orders_info[0][9]) || preg_match("/(-[0-9]{2}W-[0-9]{2}C)$/", $orders_info[0][9])) {
            $repairProduct = fs_get_data_from_db_fields_billing('products_shipping_info_id', 'products_instock_shipping_info', 'products_instock_id=' . $productInstockId . ' and products_id=73482', 'limit 1');
            if (!$repairProduct) {
                $repairFlag = true;
            }
        }
        //丢包少件-提前发新货，维修单，带上已结清标签
        $isLossClaim = false;
        if ($orders_info[0][14] > 0) {
            $isApplyClaim = fs_get_data_from_db_fields_billing('return_id', 'products_instock_shipping_sales_after', 'return_type_one = 3 and return_type_two = 6 and new_instock_id > 0 and products_instock_id=' . (int)$orders_info[0][14]);
            $isApplyRepair = fs_get_data_from_db_fields_billing('return_id', 'products_instock_shipping_sales_after', 'return_type_two = 3 and new_instock_id=' . (int)$productInstockId);
            if ($isApplyClaim) { //原单申请过"丢包少件-提前发新货" 或 申请过维修，并且已生成新单，带上结清标签
                $isLossClaim = true;
            }
            if ($isApplyRepair) {
                $repairFlag = true;
            }
        }
        //冲减应收账款计入欠款
        $reduceMoney = $db->getAll("select currencies_id,products_money,taxation,freight from fs_shipping_reduce_orders where `is_delete` != 1 AND `status` = 1 AND products_instock_id = {$productInstockId}  ORDER BY id DESC");
        if ($reduceMoney) {
            foreach ($reduceMoney as $reduceVal) {
                if ($status) {
                    $mount_compare += $reduceVal['products_money'] + $reduceVal['taxation'] + $reduceVal['freight'];
                } else {
                    $reduceSum = bcadd(bcadd($reduceVal['products_money'], $reduceVal['taxation'], 2), $reduceVal['freight'], 2);
                    $mount_compare = bcsub($mount_compare, $reduceSum, 2);
                }
            }
        }
        if ($mount_compare == 0 || $mount_compare == 0.00 || $repairFlag || $isLossClaim) {
            $str = "<br><span class=\"label label-info\">" . trans2('已结清') . "</span>";
            $is_over = true;
        } elseif ($mount_compare > 0) {
            if ($status) {
                if ($orders_info[0][1] > 0) {
                    $str = "<br><span class=\"label label-warning\">" . trans2('余额') . " " . $symbol . "+" . $mount_compare . "</span>";
                    $is_over = true;
                }
            } else {
                //电汇类付款方式
                $EFT = array(8, 28, 29, 24, 25, 26, 27, 43, 44);
                //判断是否为未到款订单
                $is_apply = fs_get_data_from_db_fields_billing('id', 'products_instock_shipping_apply', 'status!=2 and status!=1 and apply_type=3 and is_advance=8 and products_instock_id="' . $productInstockId . '"', 'order by id desc limit 1 ');//是否已申请且未被驳回
                if (((in_array($orders_info[0][6], $EFT) && $orders_info[0][11] == 1) || (!in_array($orders_info[0][6], $EFT) && $orders_info[0][11] == 1 && $orders_info[0][1] > 0)) && $click && !$is_apply && ($orders_info[0][10] == 0 || $orders_info[0][10] == 2)) {
                    if (zen_not_null($orders_info[0][12])) {
                        $jsonArr = json_decode($orders_info[0][12], true);
                        foreach ($jsonArr as $val) {
                            $fee = $val['fee'];
                            $apply_type = $val['apply_type'];
                        }
                        $feePrint = $apply_type == 6 ? '折让' : '坏账';
                        $str = "<br><a href='javascript:void(0)' title='坏账、手续费请至款项申请处申请'>" . trans2('欠款') . " " . $symbol . $mount_compare . "</a>" .
                            "<br><span class=\"label label-default\">" . trans2($feePrint) . " " . $symbol . $fee . "</span>";
                        $is_over = false;
                    } else {
                        $str = "<br><a href='javascript:void(0)' title='坏账、手续费请至款项申请处申请'>" . trans2('欠款') . "  " . $symbol . $mount_compare . "</a>";
                        $is_over = false;
                    }
                    //获取审核状态
                    $apply_status = fs_get_data_from_db_fields_billing('status', 'products_instock_shipping_apply', 'apply_type=3 and is_advance=8 and products_instock_id="' . $productInstockId . '"', 'order by id desc limit 1 ');
                    if ($apply_status) {
                        if ($apply_status === 0) {
                            $str .= '<img title="未审核" alt="未审核" src="./images/redfs_icon.png" class="unaudited">';
                        } elseif ($apply_status == 1) {
                            //$str .= '<img title="审核已通过" alt="审核已通过" src="./images/redfs_icon.png" class="unaudited">';
                        } elseif ($apply_status == 2) {
                            $str .= '<img title="审核未通过" alt="审核未通过" src="./images/redfs_icon.png" class="unaudited">';
                        } elseif ($apply_status == 3) {
                            $str .= '<img title="财务已录款" alt="财务已录款" src="./images/redfs_icon.png" class="unaudited">';
                        } else {
                            $str .= '<img title="已提交申请" alt="已提交申请" src="./images/redfs_icon.png" class="unaudited">';
                        }
                    }
                } else {
                    //获取审核状态
                    $apply_status = fs_get_data_from_db_fields_billing('status', 'products_instock_shipping_apply', 'apply_type=3 and is_advance=8 and products_instock_id="' . $productInstockId . '"', 'order by id desc limit 1 ');
                    if (zen_not_null($orders_info[0][12])) {
                        $jsonArr = json_decode($orders_info[0][12], true);
                        foreach ($jsonArr as $val) {
                            $fee = $val['fee'];
                            $apply_type = $val['apply_type'];
                        }
                        $feePrint = $apply_type == 6 ? '折让' : '坏账';
                        $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . "  " . $symbol . $mount_compare . "</span>" .
                            "<br><span class=\"label label-default\">" . trans2($feePrint) . "  " . $symbol . $fee . "</span>";
                        $is_over = false;
                    } else {
                        $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . "  " . $symbol . $mount_compare . "</span>";
                        $is_over = false;
                    }
                    if ($is_apply) {
                        if ($apply_status || $apply_status == 0) {
                            if ($apply_status == 0) {
                                $str .= '<img title="未审核" alt="未审核" src="./images/redfs_icon.png" class="unaudited">';
                            } elseif ($apply_status == 1) {
                                $str .= '<img title="审核已通过" alt="审核已通过" src="./images/redfs_icon.png" class="unaudited">';
                            } elseif ($apply_status == 2) {
                                $str .= '<img title="审核未通过" alt="审核未通过" src="./images/redfs_icon.png" class="unaudited">';
                            } elseif ($apply_status == 3) {
                                $str .= '<img title="财务已录款" alt="财务已录款" src="./images/redfs_icon.png" class="unaudited">';
                            } else {
                                $str .= '<img title="已提交申请" alt="已提交申请" src="./images/redfs_icon.png" class="unaudited">';
                            }
                        }
                    }
                }
            }
        } else {
            if ($status) {
                if (zen_not_null($orders_info[0][12])) {
                    $jsonArr = json_decode($orders_info[0][12], true);
                    foreach ($jsonArr as $val) {
                        $fee = $val['fee'];
                        $apply_type = $val['apply_type'];
                    }
                    $feePrint = $apply_type == 6 ? '折让' : '坏账';
                    $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . "  " . $symbol . abs($mount_compare) . "</span>" .
                        "<br><span class=\"label label-default\">" . trans2($feePrint) . "  " . $symbol . abs($fee) . "</span>";
                    $is_over = false;
                } else {
                    $str = "<br><span class=\"label label-warning\">" . trans2('欠款') . "   " . $symbol . abs($mount_compare) . "</span>";
                    $is_over = false;
                }
            } else {
                $str = "<br><span class=\"label label-warning\">" . trans2('余额') . "  " . $symbol . "+" . abs($mount_compare) . "</span>";
                $is_over = true;
            }
        }
    }
    if ($type == 1) {
        return $is_over;
    } else {
        return $str;
    }

}

/**
 * 语言转换改进版
 * @param $str
 * @return mixed
 */
function trans2($str)
{
    global $languagePackages;
    if ($languagePackages && $languagePackages[$str]) {
        return $languagePackages[$str];
    } else {
        return $str;
    }
}