<body>
<div class="proforma_invoice">
    <div class="proforma_invoice_logo_wap">
        <div class="proforma_invoice_logo_left">
            <a class="proforma_invoice_logo" href="javascript:;"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs-logo1218.png"></a>
            <em class="new_top_border"></em>
            <span class="proforma_invoice_span_01"> <?php
                echo $invoice_title_eu ;?></span>
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
            <td><span class="print_eu_span"><?php echo FS_BANK_DETAILS_13;?></span><?php echo zen_show_local_time($ordersData['date_purchased'], $ordersData['delivery_country_code'], 'd.m.Y', 'America/Los_Angeles');?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><span class="print_eu_span"><?php echo FS_PRINT_INVOICE_NO;?> </span><?php echo $ordersData['orders_number']; ?></td>
            <td></td>
        </tr>

        <tr>
            <td><span class="print_eu_span"><?php echo FS_PRINT_CUSTOMER_NO;?> </span><?php echo $customer_num;?></td>
            <td></td>
        </tr>
        <tr>
            <td><span class="print_eu_span"><?php echo FS_PRINT_PO_NO;?> </span><?php if($ordersData['payment_module_code']=='purchase'){
                echo '<em class="invoice_no">'.$ordersData['purchase_order_num'] .'</em>';
            } elseif($ordersData['customers_po']){
                echo  '<em class="invoice_no">' . $ordersData['customers_po'] .'</em>';
            }else{
                echo '--';?>
                <?php }?>
            </td>
            <td></td>
        </tr>

        <?php
        if ($status == 'orders_split' && $ordersData['orders_status'] == 5) {
            echo '<tr></tr>';
        } else {
            ?>
            <tr>
                <td><span class="print_eu_span"><?php echo FS_PRINT_SHIPPING_METHOD;?> </span><?php echo $ordersData['shipping_method_str'];?>
                </td>
                <td></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi_three">
        <tr>
            <th><?php echo FS_PRINT_EU_DELLIVERY;?></th>
            <th><?php echo FS_PRINT_EU_BILLING;?></th>
            <th><?php echo FS_PRINT_EU_ISSUED;?></th>
        </tr>
        <tr>
            <td><?php echo $shippingAddress;?> </td>

            <td><?php echo $billingAddress;?></td>

            <td><?php echo $instock_html;?></td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" class="new_invo_table germany">
        <tr>
            <th><?php echo FS_PRINT_NUMBER?></th>
            <th><?php echo FS_PRINT_PRODUCT_NO;?></th>
            <th><?php echo FS_PRINT_PRODUCT_DETAILS;?></th>
            <th><?php echo FS_PRINT_PRODUCT_QUANTITY;?></th>
            <th><?php echo FS_PRINT_EU_UNIT_PRICE;?></th>
            <th><?php echo FS_PRINT_TOTAL_PRICE;?></th>
        </tr>
        <?php
        $productsHtml =  '';
        $orderNum =sizeof($ordersData['son_orders']);
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
                    <strong><?php echo FS_PRINT_SUBSTOTAL;?></strong><span><?php echo $ordersData['order_total']['ot_subtotal']['text'];?></span>
                    <strong><?php echo FS_PRINT_FREIGHT;?></strong><span><?php echo $ordersData['order_total']['ot_shipping']['text'];?></span>
                   <strong><?php echo FS_PRINT_NET_TOTAL;?></strong><span><?php echo $net_total;?></span>
                    <strong><?php echo FS_PRINT_VAT_PERCENT;?></strong><span><?php echo $vat_percent;?></span>


                    <strong><?php echo FS_PRINT_VAT;?></strong><span><?php echo $vat;?></span>

                    <strong>
                        <b><?php
                            echo FS_PRINT_TOTAL_AMOUNT;
                            ?></b>
                    </strong><span><b><?php echo $ordersData['order_total']['ot_total']['text'];?></b></span>
                </div>
            </td>
        </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi_three new_invoice_germany_table">
        <?php
        if($declaration){?>
            <tr>
                <td style="padding-bottom: 30px;" colspan="2">
                    <p>
                    <?php echo $declaration;?>
                    </p>
                </td>
                <td></td>
            </tr>
        <?php }?>
        <tr>
            <td><?php echo FS_PRINT_FOOT_ADDRESS;?></td>
            <td><?php echo FS_PRINT_FOOT_BANK;?></td>
            <td><?php echo FS_PRINT_FOOT_MANAGING .$vat_num;?></td>
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
                pdf.save( orders_number+'.pdf');

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