<link rel="stylesheet" href="<?php echo auto_version('includes/templates/fiberstore/css/print_view_rma.css');?>">
<script src="/includes/templates/fiberstore/jscript/html2canvas.min.js"></script>
<script src="/includes/templates/fiberstore/jscript/jspdf.js"></script>
<!--判断账单的类型是账期或非账期,当isPurchase = false 表示非账期，isPurchase = true 表示账期-->
<?php if($isPurchase == false){?>
    <div class="proforma_invoice">
        <div class="proforma_invoice_logo_wap">
            <div class="proforma_invoice_logo_left">
                <a class="proforma_invoice_logo" href="javascript:;"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs-logo1218.png"></a>
                <em class="new_top_border"></em>
                <span class="proforma_invoice_span_01 bills_date_show"><?php echo $dateShow;?></span>
            </div>
            <div class="proforma_invoice_logo_right">
                <a href="javascript:void(0);" id="save_print"><i class="iconfont icon"></i><?php echo FS_BILLING_13;?></a>
                <a href="javascript:void(0);" id="download_pdf"><i class="iconfont icon"></i><?php echo FS_BILLING_26;?></a>
            </div>
        </div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi">
            <tbody>
            <tr>
                <td><span style="text-align:center"><?php echo FS_BILLING_INVOICE_DATE.' '?> </span>
                    <?php
                    if ($_SESSION['languages_code'] == 'jp') {
                        echo date('Y年m月d日', time());
                    } elseif (in_array($_SESSION['languages_code'],array('au','uk','dn','en'))) {
                        echo getTime('default1',time());
                    } elseif (in_array($_SESSION['languages_code'],array('de'))) {
                        echo date('d.m.Y', time());
                    } else {
                        echo date('d/m/Y', time());
                    }
                    ?>

                </td>
            </tr>
            </tbody>
        </table>

        <style type="text/css">
            .new_invo_settlement{border-bottom: none;}
            .new_invo_table{margin-top: 12px;}
            .new_invo_table th{width: auto !important;text-align: center;}
            .new_invo_table td{text-align: center !important;}
            .new_invo_settlement{padding-bottom: 0;}
        </style>

        <table border="0" cellspacing="0" cellpadding="0" class="new_invo_table">
            <tbody>
            <tr>
                <th><?php echo FS_BILLING_02?></th>
                <th><?php echo FS_BILLING_03?></th>
                <th><?php echo FS_BILLING_04?></th>
                <th><?php echo FS_BILLING_05?></th>
                <th><?php echo FS_BILLING_06?></th>
            </tr>
            <?php foreach ($bills as $bill){ ?>
                <tr>
                    <td><?php echo $bill['in_number']?></td>
                    <td><?php echo $bill['purchase_order_num'] ?: $bill['customers_po'] ?> </td>
                    <td><?php echo zen_show_local_time($bill['invocie_date'],$bill['delivery_country_code'],'default1','America/Los_Angeles');?></td>
                    <td><?php echo $bill['text'];?></td>
                    <td><?php echo zen_show_local_time($bill['payment_date'],$bill['delivery_country_code'],'default1','America/Los_Angeles');?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" class="new_invo_settlement">
            <tbody><tr>
                <td>
                    <i></i>
                    <em></em>
                </td>
                <td>
                    <div>
                        <strong><?php echo FS_BILLING_INVOICE_TOTAL?></strong><span><?php echo $billStatusResult['total']?></span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php }else{?>
    <div class="proforma_invoice">
        <div class="proforma_invoice_logo_wap">
            <div class="proforma_invoice_logo_left">
                <a class="proforma_invoice_logo" href="javascript:;"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs-logo1218.png"></a>
                <em class="new_top_border"></em>
                <span class="proforma_invoice_span_01 bills_date_show"><?php echo $dateShow; ?></span>
            </div>
            <div class="proforma_invoice_logo_right">
                <a href="javascript:void(0);" id="save_print"><i class="iconfont icon"></i><?php echo FS_BILLING_13;?></a>
                <a href="javascript:void(0);" id="download_pdf"><i class="iconfont icon"></i><?php echo FS_BILLING_26;?></a>
            </div>
        </div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="new_invoice_pi">
            <tbody>
            <tr>
                <td><span><?php echo FS_BILLING_09 ?></span><?php echo $billTypeName ?></td>
                <td><span style="text-align:center"><?php echo FS_BILLING_INVOICE_DATE.' '?> </span>
                    <?php
                    if ($_SESSION['languages_code'] == 'jp') {
                        echo date('Y年m月d日', time());
                    } elseif (in_array($_SESSION['languages_code'],array('au','uk','dn','en'))) {
                        echo getTime('default1',time());
                    } elseif (in_array($_SESSION['languages_code'],array('de'))) {
                        echo date('d.m.Y', time());
                    } else {
                        echo date('d/m/Y', time());
                    }
                    ?>
                </td>
            </tr>
            </tbody>
        </table>

        <style type="text/css">
            .new_invo_settlement{border-bottom: none;}
            .new_invo_table{margin-top: 12px;}
            .new_invo_table th{width: auto !important;text-align: center;}
            .new_invo_table td{text-align: center !important;}
            .new_invo_settlement{padding-bottom: 0;}
        </style>

        <table border="0" cellspacing="0" cellpadding="0" class="new_invo_table">
            <tbody>
            <tr>
                <th><?php echo FS_BILLING_02?></th>
                <th><?php echo FS_BILLING_03?></th>
                <th><?php echo FS_BILLING_04?></th>
                <th><?php echo FS_BILLING_07?></th>
                <th><?php echo FS_BILLING_05?></th>
                <th><?php echo FS_BILLING_08?></th>
                <th><?php echo FS_BILLING_06?></th>
            </tr>
            <?php foreach ($bills as $bill){ ?>
                <tr>
                    <td><?php echo $bill['in_number']?></td>
                    <td><?php echo $bill['purchase_order_num'] ?: $bill['customers_po'] ?> </td>
                    <td><?php echo zen_show_local_time($bill['invocie_date'],$bill['delivery_country_code'],'default1','America/Los_Angeles')?></td>
                    <td><?php echo zen_show_local_time($bill['due_date'],$bill['delivery_country_code'],'default1','America/Los_Angeles')?></td>
                    <td><?php echo $bill['text']?></td>
                    <td><?php echo $billStatusResult['status_name'][$bill['products_instock_id']] ?:'' ?></td>
                    <td><?php echo zen_show_local_time($bill['payment_date'],$bill['delivery_country_code'],'default1','America/Los_Angeles')?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" class="new_invo_settlement">
            <tbody><tr>
                <td>
                    <i></i>
                    <em></em>
                </td>
                <td>
                    <div>
                        <strong><?php echo FS_BILLING_INVOICE_TOTAL?></strong><span><?php echo $billStatusResult['total']?></span>
                        <strong><?php echo FS_BILLING_INVOICE_TOTAL_UNPAID?></strong><span><?php echo $billStatusResult['unpaidTotal']?></span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php }?>
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
        var oContent = $('.proforma_invoice');
        html2canvas(oContent, {
            useCORS: true,
            onrendered:function(canvas) {
                var date_show = $(".bills_date_show").text();

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
                pdf.save(date_show+'.pdf');
            }
        })
        setTimeout(function(){
            $('#save_print,#download_pdf,.product_off_sign').show();
        },500)
    })
</script>