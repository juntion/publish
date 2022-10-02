<style type="text/css">
    .proforma_invoice {width: 900px; padding: 10px 30px 30px 30px;font-size: 14px;line-height: 28px;margin: 0px auto;overflow: hidden;background-color:#fff}
    .invoice_info span { font-weight:normal; font-size:28px; color:#999; display:inline-block; margin-top:18px;}
    .pint_pi a { background:#e5e5e5; border:1px solid #ccc;padding: 0 15px; line-height:40px; display:block; border-radius:3px; color:#616265;}
    .pint_pi a em {font-size: 14px; margin-right:2px;}
    .pint_pi a:hover {transition: background-position .05s linear; background:#e5e5e5; text-decoration:none;}
    .invoice_info .date b{ font-weight:600; color:#232323; margin-right:5px}
    .invoice_info .date { color:#232323; margin-left:5px;}
    .invoice_info .issued { padding-top:20px;}
    .invoice_info .issued b { display:block; font-size:16px; font-weight:600; color:#232323; margin-bottom:5px;}
    .invoice_info .issued { color:#616265; line-height:24px;}
    .proforma_invoice .company_info { background:#f6f6f6; padding:0 10px; margin-top:30px;}
    .company_info table tr td{ border-top:1px solid #e5e5e5; text-align:center; color:#616265; padding:5px;}
    .company_info table tr th { font-weight:600; color:#232323; padding:8px;}
    .shopcart_summary { margin-top:20px;}
    .shopcart_summary table tr th { font-weight:600;}
    .shopping_cart tr td{ padding:10px;}
    .tab_03 tr td.big { font-weight:600;}
    .checkout_btn { overflow:hidden; margin-bottom:10px;}
    .checkout_btn button{ float:right;}
    .other_comments b{ font-size:16px; font-weight:600; color:#232323;}
    .other_comments {  min-height:60px; margin-bottom:30px;}
    #save_print,#download_pdf{display:inline-block;padding:0 14px;height:40px;border:1px solid #dcdcdc;border-radius:3px;color:#616265;line-height:40px;font-size:14px;}
    #save_print:hover,#download_pdf:hover{text-decoration:none}
    #save_print{margin-right:10px;}
    #save_print .icon,#download_pdf .icon{font-size:13px;margin-right:10px;margin-top:0;font-size:14px;color:#616265}
    .table_bottom_s{margin-bottom:30px}
    .print-logo{width: 158px;height: 38px;margin: 15px 20px 15px 0}
</style>
<style text="text/css" media="print">
  #save_print,#download_pdf{display:none}
</style>
<script src="<?php echo HTTPS_IMAGE_SERVER;?>/includes/templates/fiberstore/jscript/html2canvas.min.js"></script>
<script src="<?php echo HTTPS_IMAGE_SERVER;?>/includes/templates/fiberstore/jscript/jspdf.js"></script>
<body>
<div class="proforma_invoice">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="invoice_info">
    <tr>
      <td colspan="2"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs.com-logo.svg" border="0" class="aaa print-logo"><span>
	  <?php if($mianOrder['orders_status_id']==1){echo 'PROFORMA INVOICE';}else{echo 'INVOICE';}?></span></td>
      <td style="text-align:right">
        <a href="javascript:;" id="save_print"><span class="icon iconfont">&#xf100;</span><?php echo FS_PRINT_ORDER_ONE19;?></a>
        <a href="javascript:;" id="download_pdf"><span class="icon iconfont">&#xf153;</span><?php echo FS_PRINT_ORDER_ONE16;?></a>
      </td>
    </tr>

    <tr>
      <td class="issued" valign="top" width="33%"><b><?php echo SALES_DETAILS_DELIVER;?></b> <?php echo $shippingAddress;?></td>
      <td class="issued" valign="top" width="33%"><b><?php echo FS_PRINT_ORDER_ONE2;?></b><?php echo $billingAddress;?></td>
      <td class="issued" valign="top" width="33%"><b><?php echo FS_PRINT_ORDER_ONE10;?></b>  <?php echo $instock_html;?></td>
    </tr>
  </table>
  <div class="company_info">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <th><?php echo FS_PRINT_ORDER_ONE1;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE3;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE4;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE5;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE6;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE7;?></th>
        <th><?php echo FS_PRINT_ORDER_ONE8;?></th>
      </tr>
      <tr>
        <td><?php echo $customer_num;?> </td>
        <td class="invoice_no"><?php echo $mianOrder['orders_number'];?></td>
        <td><?php if($mianOrder['payment_module_code']=='purchase'){echo $mianOrder['purchase_order_num'];}else{echo $mianOrder['customers_po'];}?></td>
        <td><?php echo $mianOrder['currency'];?></td>
        <td><?php echo zen_get_order_peyment_method($mianOrder['payment_module_code']);?></td>
        <td><?php echo $trade_term;?> </td>
        <td><?php echo zen_get_order_shipping_method_by_code($mianOrder['shipping_method'],$orders_id);?></td>
      </tr>
    </table>
  </div>
  <div class="shopcart_summary">
    <table class="shopping_cart shopping_cart_checkout" width="100%" cellspacing="0" cellpadding="10" border="0">
      <tr>
        <th width="82"><?php echo F_BODY_HEADER_ITEM;?></th>
        <th> </th>
        <th width="180" class="text_center"><?php echo FS_PRINT_ORDER_ONE12;?></th>
        <th width="140" class=""><?php echo FS_PRINT_ORDER_ONE13;?></th>
        <th width="80" class="text_right"><?php echo FS_PRINT_ORDER_ONE14;?></th>
      </tr>
      <?php
      if($mianOrder['products']){
//        $customer_level = fs_get_data_from_db_fields("customers_level","customers", "customers_id=" .$mianOrder['customers_id'], "");
        foreach($mianOrder['products'] as $product){
          $product_href = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' .$product['id'], 'SSL');
          $image= file_exists(DIR_WS_IMAGES.$product['products_image']) ? DIR_WS_IMAGES.$product['products_image']: DIR_WS_IMAGES.'no_picture.gif';
            $image_src = get_resources_img($product['id'],'120','120',$image,'','');
          $attrHtml = '';
          if(sizeof($product['attribute'])){
            $attrHtml .= '<div class="cartAttribsList"><ul>';
            foreach($product['attribute'] as $attribute){
              if (!preg_match('/optional/i', $attribute['value'])){
                if($attribute['value'] == 'length'){
                  $attrHtml .= '<li>'.$attribute['value'].': '.$attribute['option'].'</li>';
                }else{
                  $attrHtml .= '<li>'.$attribute['option'].': '.$attribute['value'].'</li>';
                }
              }
            }
            $attrHtml .= '</ul></div>';
          }
          $pHtml = '';
//          if(($customer_level && $product['products_price'] != $product['final_price'])){
//            $pHtml .= '<span>'.FS_COMMON_LEVEL_WAS.' '.$currencies->total_format($product['products_price'],true,$order['currency'],$order['currency_value']).'</span><br>';
//          }
          $pHtml .= $currencies->total_format($product['final_price'],true,$order['currency'],$order['currency_value']);
          $totalPHtml = '';
          $totalPHtml = $currencies->total_format($product['final_price']*$product['qty'],true,$order['currency'],$order['currency_value']);
          ?>
          <tr>
            <td><a href="<?php echo $product_href;?>"><?php echo $image_src;?></a></td>
            <td class="shopping_cart_02"><p><a href="<?php echo $product_href;?>"><?php echo $product['products_name'];?></a> </p>
              <?php echo $attrHtml;?>
              <!-- eof  --></td>
            <td class="text_center"><p> <?php echo $product['qty'];?> </p>
              <div class="ccc"></div>
              <p></p></td>
            <td class="shopping_cart_03"><?php echo $pHtml;?></td>
            <td class="text_center"><?php echo $totalPHtml;?></td>
          </tr>
          <?php
        }
      }?>
    </table>
  </div>
  <div class="order_view_total">
    <table class="tab_03" width="100%" cellspacing="0" cellpadding="0" border="0">

      <tr>
        <td class="big text_right" style="font-size:14px;"><?php echo ACCOUNT_TOTAL;?></td>
        <td width="200" class="big text_right" style="font-size:14px;"><?php echo $subtotal;?></td>
      </tr>
      <tr>
        <td class="big text_right" style="font-size:14px;"><?php echo FS_SHIPPING_COST;?>:</td>
        <td width="200" class="big text_right" style="font-size:14px;"><?php echo $shipping_cost;?></td>
      </tr>
      <?php
      if($tax_value){
        if(strtolower($mianOrder['delivery_country'])=="australia"){
            $vat_text = FS_CHECK_OUT_TAX_AU;
        }else{
          $vat_text = EMAIL_CHECKOUT_COMMON_VAT_COST;
        }
        echo '<tr>
			  <td class="big text_right" style="font-size:14px;">'.$vat_text.':</td>
			  <td width="100" class="big text_right" style="font-size:14px;">'.$tax.'</td>
			</tr>';
      }
      ?>
      <tr>
        <td class="big text_right"><?php echo MANAGE_ORDER_TOTAL;?>:</td>
        <td width="200" class="big text_right"><?php echo $total;?></td>
      </tr>

    </table>
  </div>

  <div class="other_comments"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="35.5%"><b><?php echo FS_PRINT_ORDER_ONE9;?></b></td>
        <td><?php echo $mianOrder['customers_remarks'];?></td>
      </tr>
    </table>
  </div>

  <?php
  $warehouse = zen_get_orders_warehouse($mianOrder['warehouse'],$mianOrder['is_reissue']);
  if($warehouse == 'EU Warehouse' && $country_code_new != "GB") {
    ?>
    <div class="table_bottom_s">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="invoice_info">
        <tbody>
        <tr>
          <td class="issued" valign="top" width="36%">
            <?php echo FS_BLANKET_23;?>
          </td>
          <td class="issued" valign="top" width="36%">
            <?php echo FS_BLANKET_24;?>
          </td>
          <td class="issued" valign="top" width="28%">
            <?php echo FS_BLANKET_25;?>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <?php
  }
  ?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="60%">&nbsp;</td>
      <td width="20%" height="30" style="border-bottom:1px dotted #dedede;">
        <?php
        if(zen_get_order_has_admin_of_id($_GET['orders_id'])){
          echo zen_get_admin_name_of_id(zen_get_order_has_admin_of_id($_GET['orders_id']));
        }else{
          echo 'Fiberstore';
        }?>
      </td>
      <td width="20%" style="border-bottom:1px dotted #dedede;"><?php echo  in_array($_SESSION['languages_code'],array('uk','au','dn','ru')) ? getTime('d/m/Y',strtotime($mianOrder['date_purchased']),get_countries_code($mianOrder['delivery_country'])) : getTime('m/d/Y',strtotime($mianOrder['date_purchased']),get_countries_code($mianOrder['delivery_country']));?></td>
    </tr>
    <tr>
      <td height="30">&nbsp;</td>
        <td><?php echo FS_PRINT_ORDER_ONE17;?></td>
      <td><?php echo FS_PRINT_ORDER_ONE18;?></td>
    </tr>
  </table>
</div>

<script type="text/javascript">
  $('#save_print').click(function(){
    window.print();
  })
  $('#download_pdf').click(function(){
    $('#save_print,#download_pdf').hide();
    var oName = $('.invoice_no').text();
    var oContent = $('.proforma_invoice');
    html2canvas(oContent, {
      onrendered:function(canvas) {

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

        pdf.save(oName + '.pdf');
      }
    })
    setTimeout(function(){
      $('#save_print,#download_pdf').show();
    },500)
  })
</script>
</body>
