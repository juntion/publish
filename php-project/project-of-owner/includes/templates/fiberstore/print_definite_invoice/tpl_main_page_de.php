<style type="text/css">
    .proforma-invoice-btnBox a{border-radius: 2px;margin-left: 6px;transition: all .2s;height: 40px;display: inline-block;font-size: 14px;color: #232323;border: 1px solid #ccc;text-align: center;line-height: 38px;padding: 0 15px;text-decoration: none;}
    .proforma-invoice-btnBox .icon{font-size: 16px;color: #8D8D8F;}
    .proforma-invoice-btnBox a:hover {border-color: #8D8D8F;text-decoration: none;}
	body{font-family: 'Microsoft YaHei',Arial,Helvetica,sans-serif !important;}
	.proforma_invoice{width:900px;margin:0 auto;}
	.proforma-invoice-btnBox a .icon{margin-right:4px}
	.print_tr{-webkit-print-color-adjust: exact;color-adjust: exact;}
	body{background-color:#fff}
	.proforma_invoice{background-color:#fff}
</style>
<style type="text/css" media="print">
	.print_tr{background-color: #6c6d70;}
	body{background-color:#fff}
</style>
<body style="margin: 0;">
<div style="position: relative;padding: 80px;" class="proforma_invoice">
    <div style="text-align: right;">
        <div style="display: inline-block;">
            <div class="proforma-invoice-btnBox">
                <a href="javascript:void(0);" id="save_print"><i class="iconfont icon">&#xf100;</i><?php echo FS_BLANKET_01;?></a>
                <a href="javascript:void(0);" id="download_pdf"><i class="iconfont icon">&#xf153;</i><?php echo FS_BLANKET_02;?></a>
            </div>
        </div>
    </div>
    <table width="100%" border="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr>
            <td width="50%" class="logo" valign="top">
                <img src="https://img-en.fs.com/includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png" style="width: 74px;">
            </td>
            <td width="50%">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr height="33"></tr>
                    <tr>
                        <td width="50%" align="right" valign="bottom" style="font-size: 16px;line-height: 16px;font-family: 'Microsoft YaHei', 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_01;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr height="6">
            <td style="border-bottom: 1px solid #000;" colspan="2"></td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr>
            <td width="100%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr height="18"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_02;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php
                            if($invocie_date && $invocie_date!='0000-00-00 00:00:00'){
                                echo date("d . m . Y",strtotime($invocie_date));
                            }else{
                                echo '--';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_03;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;" class="invoice_no">
                            <?php echo $invocie_info['in_number'] ?: '--'; ?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_04;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $instock_shipping_info['orders_num'] ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_05;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;" class="orders_number">
                            <?php echo $instock_shipping_info['order_number'] ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_06;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $instock_shipping_info['No'] ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_07;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php if($ordersData['payment_module_code']=='purchase'){echo $ordersData['purchase_order_num'] ?: '--';}else{echo $ordersData['customers_po'] ?: '--';}?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="250" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_DE_08;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php
                                echo $shipping_method;
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr height="44"></tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr style="line-height: 14px;">
            <td width="34.88%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_09;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_10;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="11"></tr>
                    <?php echo $shippingAddress;?>
                </table>
            </td>
            <td width="34.88%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_11;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_12;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="11"></tr>
                    <?php echo $billingAddress;?>
                </table>
            </td>
            <td valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_13;?></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_14;?></td>
                    </tr>
                    <?php

                    if($vendor){
                        foreach ($vendor as $vendor_key => $vendor_val){
                            if($vendor_key == 0){
                                echo '<tr height="11"></tr>';
                            }else{
                                echo '<tr height="5"></tr>';
                            }
                            ?>
                            <tr>
                                <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $vendor_val;?></td>
                                <td width="30"></td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </td>
        </tr>
        <tr height="46"></tr>
    </table>

    <table width="100%" border="1" cellpadding="12" cellspacing="0" bordercolor="#6c6d70" style="font-size: 12px;line-height: 16px;border-collapse: collapse;color: #333;word-wrap: break-word;" class="info_table">
        <thead>
        <tr class="print_tr" align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;background-color: #6c6d70;color: #fff;line-height: 16px;">
            <td width="26.32%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;">
                <?php echo FS_DEFINITE_INVOICE_DE_15;?>
            </td>
            <td width="14.46%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_16;?></td>
            <td width="14.46%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_17;?></td>
            <td width="11.21%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;">
                <?php echo FS_DEFINITE_INVOICE_DE_18;?>
            </td>
            <td width="10.71%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;">
                <?php echo FS_DEFINITE_INVOICE_DE_19;?>
            </td>
            <td width="12.12%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;">
                <?php echo FS_DEFINITE_INVOICE_DE_20;?>
            </td>
            <td style="border: 0;border-right: 1px solid #6c6d70;padding-left: 5px;padding-right: 5px;font-weight: 600;">
                <?php echo FS_DEFINITE_INVOICE_DE_21;?>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php echo $product_invoice_arr['product_table_html'];?>
        </tbody>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr height="16"></tr>
        <tr>
            <td width="48%" valign="top">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;line-height: 18px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;line-height: 16px;font-weight: 600;"><?php echo $ordersData['delivery_remark'] ? FS_DEFINITE_INVOICE_AU_18 : '';?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="3"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $ordersData['delivery_remark'];?>
                        </td>
                        <td width="30"></td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;line-height: 16px;">
                    <?php
                    //vat 展示
                    $vat = $vat_percent = '';
                    if($ordersData['order_total']['ot_tax']){
                        $vat = $ordersData['order_total']['ot_tax']['text'];
                    }else{
                        $vat = $currencies->total_format(0, true, $ordersData['currency'], $ordersData['currency_value']);
                    }
                    $is_bill_company = $is_uk_business_address = false;
                    if($ordersData['billing_company_type'] == 'BusinessType' &&
                        (!german_warehouse('country_code',$ordersData['billing_country_code']) || $ordersData['billing_country_code'] == 'DE')){
                        $is_bill_company = true;
                    }
                    if($ordersData['billing_country_code'] == 'US' && $ordersData['billing_company_type'] != 'BusinessType' && $ordersData['delivery_country_code'] == 'BE'){
                        $is_bill_company = false;
                    }
                    if($ordersData['billing_company_type'] == 'BusinessType'  && in_array($ordersData['billing_country_code'],['GB','IM']) && $ordersData['delivery_country_id'] !=81)  {
                        $is_uk_business_address = true; //账单地址为企业类型 地址为英国 马恩岛  收货地址为欧盟 收税  19%
                    }

                    //2020-6-25 pico 更新规则 收货地址为德国，无论账单地址为哪个国家，一律收取16%的VAT。 2020.7.1-12.31
                    //发票页面以下单时间为准
                    $time = strtotime($ordersData['date_purchased']);
                    if ($time > 1609455599 || $time < 1593554400){ //柏林2020-07-01 00:00:00 和 2020-12-31 23：59：59时间戳
                        $vax_num = '19 %';
                    } else {
                        $vax_num = '16 %';
                    }
                    $vat_percent = '0 %';
                    if(!$ordersData['order_total']['ot_tax']) {
                        $vat_percent = '0 %';
                    }elseif($is_bill_company || $is_uk_business_address) {
                        $vat_percent = $vax_num;
                    } else {
                        if (german_warehouse('country_code', $ordersData['delivery_country_code'], $ordersData['delivery_postcode'])) {
                            switch ($ordersData['delivery_country_code']) {
//                                case 'GB':
//                                case 'IM':
                                case 'FR':
                                case 'MC':
                                    $vat_percent = '20 %';
                                    break;
                                case 'NL':
                                case 'ES':
                                case 'BE':
                                    $vat_percent = '21 %';
                                    break;
                                case 'IT':
                                    $vat_percent = '22 %';
                                    break;
                                case 'BL':
                                    $vat_percent = '0';
                                    break;
                                case 'MF':
                                    $vat_percent = '0';
                                    break;
                                case 'SE':
                                    $vat_percent = '25 %';
                                    break;
                                case 'DK':
                                    $vat_percent = '25 %';
                                    //2020-11-06 ery denmark税率由16% 调整为25%
                                    $denmark_vat_value_new = zen_round(($ordersData['order_total']['ot_subtotal']['value']+$ordersData['order_total']['ot_shipping']['value'])*0.16, 2);
                                    if($denmark_vat_value_new == $ordersData['order_total']['ot_tax']['value']){
                                        //税率调整前下的订单仍然展示16%
                                        $vat_percent = $vax_num;
                                    }
                                    break;
                                default :
                                    $vat_percent = $vax_num;
                                    break;
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_22;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $subtotal_all;?></td>
                        <!--负数书写样式-->
                        <!--<td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">US$ -49.50</td>-->
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_23;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $shipping_cost;?></td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_24;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $totalOrCost;?></td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_25;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $vat_percent;?></td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_26;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $vat;?></td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_DE_27;?></td>
                        <td width="30"></td>
                        <td width="94" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $total;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr height="29">
            <td colspan="2" style="border-bottom: 1px dashed #6c6d70;"></td>
        </tr>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;line-height: 16px;color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr height="28"></tr>
        <tr>
            <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_24;?></td>
        </tr>
        <tr height="6"></tr>
        <tr>
            <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;line-height: 20px;">
                <?php echo $declaration;?>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr height="76"></tr>
        <tr>
            <td width="34.88%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_28;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_29;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_30;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_31;?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_32;?></td>
                        <td width="30"></td>
                    </tr>
                </table>
            </td>
            <td width="34.88%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_33;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_34;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_35;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_36;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_37;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_38;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_39;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_40;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_41;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_42;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_43;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_44;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_45;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_DE_46;?></td>
                        <td width="50"></td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_47;?></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_48;?></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo FS_DEFINITE_INVOICE_DE_49;?></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <?php

                            //发票税号展示  针对 欧盟(非德国国家)账单地址为个人类型
                            $is_eu_delivery_address = false;
                            if(german_warehouse('country_number', $ordersData['delivery_country_id']) && $ordersData['delivery_country_id'] !=81 && $ordersData['billing_company_type'] !='BusinessType'){
                                $is_eu_delivery_address = true;
                            }

                            if($ordersData['delivery_country_id'] == 21 && $ordersData['billing_country_code'] == 'US'&& $ordersData['billing_company_type'] !='BusinessType'){
                                $is_eu_delivery_address = true;
                            }

                            if ($is_eu_delivery_address) {
                                switch ($ordersData['delivery_country_id']) {
                                    case 21:
                                        $vat_num = 'BE0753932104';
                                        break;
                                    case 105:
                                        $vat_num = 'IT00238699995';
                                        break;
                                    case 203:
                                        $vat_num = 'SE502082260601';
                                        break;
                                    case 150:
                                        $vat_num = 'NL825896058B01';
                                        break;
                                    case 73:
                                    case 141:
                                        $vat_num = 'FR55841149644';
                                        break;
//                                    case 222:
//                                    case 244:
//                                        $vat_num = 'GB312920435';
//                                        break;
                                    case 195:
                                        $vat_num = 'N2767136A';
                                        break;
                                    case 57:
                                        $vat_num = 'DK41743034';
                                        break;
                                    default:
                                        //收件地址国家为上述7个特殊国家以外的欧盟国家，账单地址为个人类型，issued by和账单底部税号都显示德国税号DE313377831
                                        $vat_num = 'DE313377831';
                                        break;
                                }
                            }else{
                                $vat_num = 'DE313377831';
                            }

                            if ($vat_num) {
                                echo '<td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">' . FS_DEFINITE_INVOICE_DE_50 . $vat_num . '</td>';
                            }
                        ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
