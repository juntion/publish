<link rel="stylesheet" href="<?php echo auto_version('includes/templates/fiberstore/css/print_view_rma.css');?>">
<script src="/includes/templates/fiberstore/jscript/html2canvas.min.js"></script>
<script src="/includes/templates/fiberstore/jscript/jspdf.js"></script>
<?php if($is_de_pi){
    require_once($template->get_template_dir('tpl_main_page_eu.php',DIR_WS_TEMPLATE, $current_page_base,'print_blanket_order').'tpl_main_page_eu.php');
    ?>
<?php }else{?>
<body>
<div class="proforma_invoice">
    <div class="proforma_invoice_logo_wap">
        <div class="proforma_invoice_logo_left">
            <a class="proforma_invoice_logo" href="javascript:;"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs-logo1218.png"></a>
            <em class="new_top_border"></em>
            <span class="proforma_invoice_span_01"> <?php
                echo $invoice_title;?></span>
        </div>
    <?php if (!$is_mobile){ ?>
        <div class="proforma_invoice_logo_right">
            <a href="javascript:void(0);" id="save_print"><i class="iconfont icon">&#xf100;</i><?php echo FS_BLANKET_01;?></a>
            <a href="javascript:void(0);" id="download_pdf"><i class="iconfont icon">&#xf153;</i><?php echo FS_BLANKET_02;?></a>
        </div>
    <?php } ?>
    </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi">
        <tbody>
        <tr>
            <td><span><?php echo FS_BLANKET_ORDER;?></span><?php echo $ordersData['orders_number'];?>
            </td>
            <td><span style="text-align:center"><?php echo FS_BLANKET_CREATED_DATE;?> </span><?php echo $show_time; ?></td>
        </tr>
        <?php if($ordersData['purchase_order_num'] ||$ordersData['customers_po'] ){?>
            <tr>
                <td><span><?php echo FS_BLANKET_07;?> </span><?php if($ordersData['purchase_order_num']){
                    echo '<em class="invoice_no">'.$ordersData['purchase_order_num'] .'</em>';
                } else{
                    echo  '<em class="invoice_no">' . $ordersData['customers_po'] .'</em>';
                }?>
                </td>
                <td></td>
            </tr>
        <?php }?>
        <tr>
            <td><span><?php echo FS_BLANKET_10; ?> </span><?php echo $trade_term;?></td>
            <td></td>
        </tr>

        <tr>
            <td><span><?php echo FS_BLANKET_08;?> </span><?php echo $ordersData['currency'];?></td>
            <td></td>
        </tr>
        <tr>
            <td><span><?php echo FS_BLANKET_09;?> </span><?php
                if ($customer_pay_day && $ordersData['payment_module_code'] == 'purchase') {
                    echo $customer_pay_day;
                } else {
                    echo trim($ordersData['payment_module_code_str']);
                }?>
            </td>
            <td></td>
        </tr>
        <?php
            if ($status == 'orders_split' && $ordersData['orders_status'] == 5) {
                echo '<tr></tr>';
            } else {
                ?>
                <tr>
                    <td><span><?php echo FS_BLANKET_11; ?> </span><?php echo $ordersData['shipping_method_str']; ?>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
        ?>
        <tr>
            <td><span><?php echo FS_BLANKET_CREATED_BY;?></span><?php echo $admin_name;?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><span> <?php echo FS_BLANKET_EMAIL;?> </span><?php echo trim($admin_email);?></td>
            <td></td>
        </tr>
        </tbody>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi_three">
        <tr>
            <th><?php echo FS_BLANKET_DELIVER;?></th>
            <th><?php echo FS_BLANKET_03;?></th>
            <th><?php echo FS_BLANKET_04;?></th>
        </tr>
        <tr>
            <td><?php echo $shippingAddress;?> </td>

            <td><?php echo $billingAddress;?></td>

            <td><?php echo $instock_html;?></td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" class="new_invo_table">
        <tr>
            <th><?php echo FS_BLANKET_NO?></th>
            <th><?php echo FS_BLANKET_PRODUCT;?></th>
            <th><?php echo FS_BLANKET_DESCRIPTION;?></th>
            <th><?php echo FS_BLANKET_16;?></th>
            <th><?php echo FS_BLANKET_17.$auInc;?></th>
            <th><?php echo $Tot;?></th>
        </tr>
        <?php
        $productsHtml =  '';
        if($orderNum) {
            foreach ($ordersData['son_orders'] as $k => $order_v) {
                foreach ($order_v['products'] as $key => $product) {
                    $num = $key + 1;
                    //属性值
                    $attrHtml = '';
                    if (sizeof($product['orders_products_attributes'])) {
                        $attrHtml .= '<ul class="new_invo_custom_attribute">';
                        foreach ($product['orders_products_attributes'] as $attribute)                       {
                            $attrHtml .= '<li>' . $attribute['options_name'] . ' : ' . $attribute['values_name'] . '</li>';

                        }
                        if(!empty($product['orders_products_length'])){
                            $attrHtml .= '<li>'.FS_LENGTH_NAME. ' : '.$product['orders_products_length']['length_name'].'</li>';
                        }
                        $attrHtml .= '</ul>';
                    }

                    $productsHtml .= '<tr>
                        <td>' . $num . '</td>
                        <td>' . $product['products_id'] . '</td>
                        <td>' . $product['products_name'] . $attrHtml . '</td>
                        <td>' . $product['products_quantity'] . '</td>
                        <td>' . $product['final_price_currency'] . '</td>
                        <td>' . $product['total_price_currency'] . '</td>
                        </tr>';
                }

            }
        }
        echo $productsHtml;
        ?>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" class="new_invo_settlement">
        <tr>
            <td>
                <i><?php echo FS_BLANKET_22;?></i>
                <em><?php $remark =  stripcslashes($ordersData['customers_remarks']);
                    echo nl2br($remark);?></em>
            </td>
            <td>
                <div>
                    <?php
                        if($is_au_gsp){  //税后价
                            echo '<strong>'.FS_BLANKET_21.'</strong><span>'.$subTotal.'</span>
                                    <strong>'.FS_BLANKET_32.'</strong><span>'.$shippingCost.'</span>
                                    <strong>'.FS_BLANKET_33.'</strong><span>'.$taxTot.'</span></strong>
                                    <strong>'.FS_BLANKET_34.'</strong><span><b>'.$totalPrice.'</b></span>';
                        }else{
                            echo '<strong>'.FS_BLANKET_21.'</strong><span>'.$subTotal.'</span>
                                    <strong>'.FS_BLANKET_SHIPPING.'</strong><span>'.$shippingCost.'</span>
                                    '.$tax.'
                                    <strong><b>'.$toTal.'</b></strong>
                                    <span><b>'.$totalPrice.'</b></span>';
                        }
                    ?>

                </div>
            </td>
        </tr>
    </table>
    <?php echo isset($ach_account_tip) ? '<div class="proforma_invoice_achAlone_txt">'.$ach_account_tip.'</div>' : '';?>
    <table border="0" cellspacing="0" cellpadding="0" class="new_invo_bottom_table">
        <tr>
            <td>

                <p><?php echo $account_tip;?></p>
                <?php echo $bankHtml;?>
            </td>
            <td></td>
        </tr>
        <?php echo isset($ach_account_content) ? '<tr><td>'.$ach_account_content.'</td><td></td></tr>' : '';?>
        <tr>

            <td style="padding-top: 26px;padding-bottom: 30px;">

                <?php echo $account_note;?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><div style="page-break-before:always;"><br/></div></td>

        </tr>

        <tr>
            <td></td>
            <td>
                <strong>
                    <?php
                    if($admin_name){
                        echo $admin_name;
                    }else{
                        echo 'Fiberstore';
                    }?>
                    <em><?php echo $show_time;?></em>
                </strong>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <strong><?php echo FS_BLANKET_26;?><em><?php echo FS_BLANKET_27;?></em></strong>
            </td>
        </tr>
        <?php
        if(!$invoice && !$po_invoice){?>
         <tr>
             <td style="text-align: left;padding-top: 33px;" colspan="2">
                 <?php if($ordersData['orders_status'] == 10 || $ordersData['orders_status'] == 11) {echo FS_DOCUMENT_INFO_PAY;} else {echo FS_DOCUMENT_INFO;} ?>
             </td>
         </tr>
        <?php }?>
    </table>




</div>
<?php if ($is_mobile){ ?>
    <div class="m-print-btn">
        <a href="javascript:void(0);" id="save_print"><i class="iconfont icon">&#xf100;</i><?php echo FS_BLANKET_01;?></a>
        <a href="javascript:void(0);" id="download_pdf"><i class="iconfont icon">&#xf153;</i><?php echo FS_BLANKET_02;?></a>
    </div>
<?php } ?>
<script type="text/javascript">
    $(function () {
        var country_id = parseInt("<?php echo $ordersData['delivery_country_id'];?>");
        if ($.inArray(country_id, [38,138]) != -1) {
            $(".proforma_invoice_achAlone_txt01").remove();
        }
    })
    $('#save_print').click(function(){
        $('#save_print,#download_pdf').hide();
        window.print();
        setTimeout(function(){
            $('#save_print,#download_pdf').show();
        },500)
    });
    $('#download_pdf').click(function(){
        $('#save_print,#download_pdf,.product_off_sign').hide();
        var oName = $('.invoice_no').text();
        var oContent = $('.proforma_invoice');
        var billing_name = '<?php echo $ordersData['billing_name'];?>';
        var billing_lastname = '<?php echo $ordersData['billing_lastname'];?>';
        var orders_number = '<?php echo $ordersData['orders_number'];?>';

        html2canvas(oContent, {
            useCORS: true,
            onrendered:function(canvas) {

                var context = canvas.getContext('2d');
                //关闭抗锯齿,优化图片清晰度
                context.mozImageSmoothingEnabled = false;
                context.webkitImageSmoothingEnabled = false;
                context.msImageSmoothingEnabled = false;
                context.imageSmoothingEnabled = false;

                var contentWidth = canvas.width;
                var contentHeight = canvas.height;

                //一页pdf显示html页面生成的canvas高度;
                var pageHeight = contentWidth / 592.28 * 841.89;
                //未生成pdf的html页面高度
                var leftHeight = contentHeight;
                //pdf页面偏移
                var position = 0;
                //a4纸的尺寸[595.28,841.89]，html页面生成的canvas在pdf中图片的宽高
                var imgWidth = 595.28;
                var imgHeight = 592.28/contentWidth * contentHeight;

                var pageData = canvas.toDataURL('image/jpeg', 1.0);

                var pdf = new jsPDF('', 'pt', 'a4');

                //有两个高度需要区分，一个是html页面的实际高度，和生成pdf的页面高度(841.89)
                //当内容未超过pdf一页显示的范围，无需分页
                if (leftHeight < pageHeight) {
                    pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight );
                } else {
                    while(leftHeight > 0) {
                        pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                        leftHeight -= pageHeight;
                        position -= 841.89;
//避免添加空白页
                        if(leftHeight > 0) {
                            pdf.addPage();
                        }
                    }
                }
                //pdf.save( billing_name+' '+billing_lastname+ ', PO NO. '+oName+'.pdf');
                pdf.save(orders_number+'.pdf');
            }
        })
        setTimeout(function(){
            $('#save_print,#download_pdf,.product_off_sign').show();
        },500)
    })
        <?php  if($type==1){ ?>
    $('#save_print,#download_pdf,.product_off_sign').hide();
    var oName = $('.invoice_no').text();
    var oContent = $('.proforma_invoice');
    var billing_name = '<?php echo $ordersData['billing_name'];?>';
    var billing_lastname = '<?php echo $ordersData['billing_lastname'];?>';
    var orders_number = '<?php echo $ordersData['orders_number'];?>';

    html2canvas(oContent, {
        useCORS: true,
        onrendered:function(canvas) {

            var context = canvas.getContext('2d');
            //关闭抗锯齿,优化图片清晰度
            context.mozImageSmoothingEnabled = false;
            context.webkitImageSmoothingEnabled = false;
            context.msImageSmoothingEnabled = false;
            context.imageSmoothingEnabled = false;

            var contentWidth = canvas.width;
            var contentHeight = canvas.height;

            //一页pdf显示html页面生成的canvas高度;
            var pageHeight = contentWidth / 592.28 * 841.89;
            //未生成pdf的html页面高度
            var leftHeight = contentHeight;
            //pdf页面偏移
            var position = 0;
            //a4纸的尺寸[595.28,841.89]，html页面生成的canvas在pdf中图片的宽高
            var imgWidth = 595.28;
            var imgHeight = 592.28/contentWidth * contentHeight;

            var pageData = canvas.toDataURL('image/jpeg', 1.0);

            var pdf = new jsPDF('', 'pt', 'a4');

            //有两个高度需要区分，一个是html页面的实际高度，和生成pdf的页面高度(841.89)
            //当内容未超过pdf一页显示的范围，无需分页
            if (leftHeight < pageHeight) {
                pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight );
            } else {
                while(leftHeight > 0) {
                    pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                    leftHeight -= pageHeight;
                    position -= 841.89;
                    //避免添加空白页
                    if(leftHeight > 0) {
                        pdf.addPage();
                    }
                }
            }
            //pdf.save( billing_name+' '+billing_lastname+ ', PO NO. '+oName+'.pdf');
            pdf.save( orders_number+'.pdf');

        }
    })
    setTimeout(function(){
        $('#save_print,#download_pdf,.product_off_sign').show();
    },500)
    <?php  } ?>
</script>
</body>
<?php }?>