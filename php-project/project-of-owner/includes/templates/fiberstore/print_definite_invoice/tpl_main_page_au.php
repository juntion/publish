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
                        <td width="50%" align="right" valign="bottom" style="font-size: 16px;line-height: 16px;font-family: 'Microsoft YaHei', 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_01;?></td>
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
            <td width="57.6%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr height="18"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_02;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <!--                            --><?php //echo $ordersData['date_purchased_str']; ?>
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
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_03;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;" class="invoice_no">
                            <?php echo $invocie_info['in_number'] ?: '--'; ?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_04;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $ordersData['currency'] ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_05;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;" class="orders_number">
                            <?php echo $ordersData['orders_number'] ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_06;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php if($ordersData['payment_module_code']=='purchase'){echo $ordersData['purchase_order_num'] ?: '--';}else{echo $ordersData['customers_po'] ?: '--';}?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_07;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $trade_term ?: '--';?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_08;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php
                            echo $shipping_method;
                            ?>
                        </td>
                    </tr>
                    <tr height="8"></tr>
                    <tr>
                        <td width="142" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                            <?php echo FS_DEFINITE_INVOICE_AU_09;?>
                        </td>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $package_num ? $package_num .'Pkg':'1Pkg';?>
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
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_10;?></td>
                        <td width="30"></td>
                    </tr>
                    <?php
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
                    <?php }?>
                </table>
            </td>
            <td width="34.88%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_11;?></td>
                    </tr>
                    <tr height="11"></tr>
                    <?php echo $shippingAddress;?>
                </table>
            </td>
            <td valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_12;?></td>
                    </tr>
                    <tr height="11"></tr>
                    <?php echo $billingAddress;?>
                </table>
            </td>
        </tr>
        <tr height="46"></tr>
    </table>

    <table width="100%" border="1" cellpadding="11" cellspacing="0" bordercolor="#6c6d70" style="font-size: 12px;line-height: 16px;color: #333;word-wrap: break-word;border-collapse: collapse;">
        <thead>
        <tr class="print_tr" align="center" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;background-color: #6c6d70;color: #fff;line-height: 13px;">
            <td width="28%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_13;?></td>
            <td width="18%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_14;?></td>
            <td width="18%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_15;?></td>
            <td width="18%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo $is_main_au_gsp ? FS_DEFINITE_INVOICE_AU_35 : FS_DEFINITE_INVOICE_AU_16;?></td>
            <td width="18%" style="border: 0;border-right: 1px solid #fff;padding-left: 5px;padding-right: 5px;font-weight: 600;"><?php echo $is_main_au_gsp ? FS_DEFINITE_INVOICE_AU_36 : FS_DEFINITE_INVOICE_AU_17;?></td>
        </tr>
        </thead>
        <tbody>
        <?php echo $product_invoice_arr['product_table_html'];?>
        </tbody>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr height="16"></tr>
        <tr>
            <td width="55%" valign="top">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;line-height: 18px;">
                    <tr>
                        <td style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo $ordersData['delivery_remark'] ? FS_DEFINITE_INVOICE_AU_18 : '';?></td>
                        <td width="30"></td>
                    </tr>
                    <tr height="3"></tr>
                    <tr>
                        <td style="line-height: 18px;font-family: Microsoft YaHei, 思源黑体 CN Light;">
                            <?php echo $ordersData['delivery_remark'];?>
                        </td>
                        <td width="30"></td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;line-height: 16px;">
                    <?php if($is_main_au_gsp){?>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_20;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $shipping_cost;?></td>
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_37;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo !empty($tax_value) ? $tax : 0 ;?></td>
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_38;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $total;?></td>
                        </tr>
                    <?php }else{?>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_19;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $subtotal_all;?></td>
                            <!--负数书写样式-->
                            <!--<td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;">AU$ -49.50</td>-->
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_20;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $shipping_cost;?></td>
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_21;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo !empty($tax_value) ? $tax : 0 ;?></td>
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_22;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $totalOrCost;?></td>
                        </tr>
                        <tr height="8"></tr>
                        <tr>
                            <td align="right" style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_23;?></td>
                            <td width="30"></td>
                            <td width="102" style="font-family: Microsoft YaHei, 思源黑体 CN Light;"><?php echo $total;?></td>
                        </tr>
                    <?php }?>
                </table>
            </td>
        </tr>
        <tr height="26">
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
                <?php echo FS_DEFINITE_INVOICE_AU_25;?>
            </td>
        </tr>
        <tr height="43"></tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tbody><tr>
            <td width="100%" valign="top">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 12px;line-height: 16px;">
                    <tbody><tr>
                        <td style="font-family: 微软雅黑;font-weight: 600;"><?php echo FS_DEFINITE_INVOICE_AU_26;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_27;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="14"></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_28;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_29;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_30;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="4"></tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_31;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr>
                        <td style="font-family: 微软雅黑;"><?php echo FS_DEFINITE_INVOICE_AU_32;?></td>
                        <td width="50"></td>
                    </tr>
                    <tr height="48"></tr>
                    </tbody></table>
            </td>

        </tr>
        </tbody>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="color: #333;word-wrap: break-word;border-collapse: collapse;">
        <tr>
            <td align="right">
                <table border="0" cellpadding="0" style="font-size: 12px;line-height: 14px;">
                    <tr style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                        <td style="font-weight: 600;">
                            <?php
                            if(zen_get_order_has_admin_of_id($_GET['orders_id'])){
                                echo zen_get_admin_name_of_id(zen_get_order_has_admin_of_id($_GET['orders_id']));
                            }else{
                                echo 'Fiberstore';
                            }?>
                        </td>
                    </tr>
                    <tr height="11"></tr>
                    <tr style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                        <td><?php echo FS_DEFINITE_INVOICE_AU_33;?></td>
                    </tr>
                </table>
            </td>
            <td width="30"></td>
            <td width="100">
                <table width="100%" border="0" cellpadding="0" style="font-size: 12px;line-height: 14px;">
                    <tr style="font-family: Microsoft YaHei, 思源黑体 CN Medium;font-weight: 600;">
                        <td align="right"  style="font-weight: 600;"><?php
                            if($invocie_info['invocie_date'] && $invocie_info['invocie_date']!='0000-00-00 00:00:00'){
                                echo date("d . m . Y",strtotime($invocie_info['invocie_date']));
                            }else{
                                echo '--';
                            }
                            ?></td>
                    </tr>
                    <tr height="11"></tr>
                    <tr style="font-family: Microsoft YaHei, 思源黑体 CN Light;">
                        <td align="right"><?php echo FS_DEFINITE_INVOICE_AU_34;?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
