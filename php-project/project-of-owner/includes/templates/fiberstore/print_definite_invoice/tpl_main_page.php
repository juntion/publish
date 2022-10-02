<script src="/includes/templates/fiberstore/jscript/html2canvas.min.js"></script>
<script src="/includes/templates/fiberstore/jscript/jspdf.js"></script>
<?php
switch ($warehouse_type) {
    case 2:
        require_once($template->get_template_dir('tpl_main_page_au.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_au.php');
        break;
    case 3:
        require_once($template->get_template_dir('tpl_main_page_de.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_de.php');
        break;
    case 4:
        require_once($template->get_template_dir('tpl_main_page_es.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_es.php');
        break;
    case 5:
        require_once($template->get_template_dir('tpl_main_page_sg.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_sg.php');
        break;
    case 7:
        require_once($template->get_template_dir('tpl_main_page_ru.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_ru.php');
        break;
    default:
        require_once($template->get_template_dir('tpl_main_page_cn.php',DIR_WS_TEMPLATE, $current_page_base,'print_definite_invoice').'tpl_main_page_cn.php');
        break;
}
?>
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
        var oName = $.trim($('.invoice_no').text());
        var oNumber = $.trim($('.orders_number').text());
        var oContent = $('.proforma_invoice');
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
                pdf.save(oName+'+'+oNumber+'.pdf');
            }
        })
        setTimeout(function(){
            $('#save_print,#download_pdf,.product_off_sign').show();
        },500)
    })
</script>