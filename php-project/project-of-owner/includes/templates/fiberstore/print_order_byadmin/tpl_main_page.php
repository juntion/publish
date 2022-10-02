<style type="text/css">
    .proforma_invoice {width: 900px; padding: 10px 30px 30px 30px;font-size: 14px;line-height: 28px;margin: 0px auto;overflow: hidden;}
    .invoice_info { margin-bottom:30px;}
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

    .print_order_tit{ font-size:16px; font-weight:600; padding-bottom:15px; display:block; overflow:hidden;}
    .print_order_tit span{ color:#999; float:right;}
    .print_order_con{ padding:20px; border:1px solid #dedede; margin-bottom:15px;}
    .print_order_con_information{}
    .print_order_con_information ul{ display:table;width: 100%;}
    .print_order_con_information ul li{display: inline-block; width:50%; padding-right:1%; line-height:18px; padding:3px 0;}
    .print_order_con_product{ border-top:1px solid #dedede; margin-top:15px;}
    .print_order_con_product dl{ padding-top:15px; overflow:hidden;}
    .print_order_con_product dl dt{ float:left; width:120px; text-align:center}
    .print_order_con_product dl dt img{  width:64px; }
    .print_order_con_product dl dd{ padding-left:140px;}
    .print_order_con_price span{ color:#999; font-size:12px; padding-right:10px;}
    .print_order_con_price em{ font-style:normal; display:inline-block; padding-left:10px;}
    .print_order_wire_transfer { margin-bottom:30px;}
    .print_order_wire_transfer dl{ overflow:hidden}
    .print_order_wire_transfer dl dt{ float:left; color:#616265;}
    .print_order_wire_transfer dl dd{ padding-left:220px;}
    .print_order_attr{ margin:5px 0;}
    .print_order_attr span { display: block; font-size: 13px;color: #999;}
    .print-logo{width: 158px;height: 38px;margin: 15px 20px 15px 0}
</style>
<body>
<div class="proforma_invoice">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="invoice_info">
    <tr>
      <td colspan="2"><img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/fs.com-logo.svg" border="0" class="aaa print-logo"><span><?php echo FS_INVOICE;?></span></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3"><div class="date"><b><?php echo FS_QUSTION_DATE;?></b>
              <?php
              if(in_array($_SESSION['languages_code'],array('ru','fr','es','mx'))){
                  echo getTime('d/m/Y',strtotime($mianOrder['date_purchased']));
              }elseif($_SESSION['languages_code'] == 'de'){
                  echo getTime('d.m.Y',strtotime($mianOrder['date_purchased']));;
              }else{
                  echo get_date_display($mianOrder['date_purchased'],$_SESSION['languages_id']);
              }
              ?>
          </div>
      </td>
    </tr>
    <tr>
      <td class="issued" valign="top" width="33%"><b><?php echo SALES_DETAILS_DELIVER;?></b> <?php echo $shippingAddress;?></td>
      <td class="issued" valign="top" width="33%"><b><?php echo FS_BILLING_TO;?></b><?php echo $billingAddress;?></td>
      <td class="issued" valign="top" width="33%"><b><?php echo FS_INSSUED_BY;?></b> <?php echo $instock_html;?></td>
    </tr>
  </table>
  <!--Order 1 of 3-->
<?php 
$orderNum =sizeof($allOrder);
if($orderNum){
	foreach($allOrder as $k=>$order){
		$shipping_method = zen_get_order_shipping_method_by_code($order['shipping_method'],$order['orders_id']);
		$itemsRes = $db->Execute("select sum(products_quantity) as total from orders_products where orders_id =".$order['orders_id']);
		$items = $itemsRes->fields['total'];
		$shipping_data = fs_get_data_from_db_fields_array(array('value','text'),'orders_total','class="ot_shipping" and orders_id='.$order['orders_id'],'limit 1');
		$shipping_cost = FS_FOR_FREE_SHIPPING_TO_FREE;
		if((float)$shipping_data[0][0]){$shipping_cost = $shipping_data[0][1];}
        $warehouse = zen_get_orders_warehouse($order['warehouse'],$order['is_reissue']);
		
		$delivery_time = '';
		$productsHtml = '';
		$date_arr = array();
		$dateFlag = true;
		$customer_level = fs_get_data_from_db_fields("customers_level","customers", "customers_id=" .$order['customers_id'], "");
		foreach($order['products'] as $product){
			//获取交期日期数据
			if(in_array($order['is_reissue'],array(1,4,6,9,12))){
				$delivery_time = FS_SHIP_SAME_DAY;
				$dateFlag = false;
			}else{
				$countries_code_2 = fs_get_data_from_db_fields('countries_iso_code_2','countries','countries_name LIKE "'.$order['delivery_country'].'"','limit 1');
				$time = zen_get_products_instock_shipping_date_of_products_id($product['id'],FS_SHIP_AVAI,$countries_code_2);
				$time = str_replace(FS_SHIP_ESTIMATED,"",$time);
				$time = str_replace("<b>","",$time);
				$time = str_replace("</b>","",$time);
				$time = trim($time);
				$date_arr[] = strtotime($time);
			}
			
			$image_src= file_exists(DIR_WS_IMAGES.$product['products_image']) ? DIR_WS_IMAGES.$product['products_image']: DIR_WS_IMAGES.'no_picture.gif';
			$pHtml = '';
			if($customer_level && $product['products_price'] != $product['final_price']){
				$pHtml .= '<span>'.FS_COMMON_LEVEL_WAS.' '.$currencies->total_format($product['products_price'],true,$order['currency'],$order['currency_value']).'</span>';
			}
			$pHtml .= $currencies->total_format($product['final_price'],true,$order['currency'],$order['currency_value']).'<em>X&nbsp '.$product['qty'].'</em>';
			$productsHtml .= '<dl><dt><img src="'.HTTPS_IMAGE_SERVER.$image_src.'" alt="'.$product['products_name'].'"></dt>
					<dd><p>'.$product['products_name'].'</p>';
			$attrHtml = '';
			if(sizeof($product['attribute'])){
				$attrHtml .= '<div class="print_order_attr">';
				foreach($product['attribute'] as $attribute){
				  if (!preg_match('/optional/i', $attribute['value'])){
					if($attribute['value'] == 'length'){
					  $attrHtml .= '<span>'.$attribute['value'].': '.$attribute['option'].'</span>';
					}else{
					  $attrHtml .= '<span>'.$attribute['option'].': '.$attribute['value'].'</span>';
					}
				  }
				}
				$attrHtml .= '</div>';
			}
			$productsHtml .= $attrHtml;
			$productsHtml .= '<div class="print_order_con_price">'.$pHtml.'</div></dd></dl>';
		}
		if($dateFlag){
			arsort($date_arr);
			$shipping_time = $date_arr[0];
              if(in_array($_SESSION['languages_code'],array('ru','fr','es','mx'))){
                  $delivery_time =  getTime('d/m/Y',strtotime($mianOrder['date_purchased']));
              }elseif($_SESSION['languages_code'] == 'de'){
                  $delivery_time = getTime('d.m.Y',strtotime($mianOrder['date_purchased']));;
              }else{
                  $delivery_time =  get_date_display($mianOrder['date_purchased'],$_SESSION['languages_id']);
              }
		}
?>
  <div class="print_order_con">
    <div class="print_order_tit"><?php echo FS_ORDER;?><?php echo $order['orders_number'];?><span><?php echo str_replace('###', $k+1,FS_ORDER_OF)?><?php echo $orderNum;?> </span></div>



    <div class="print_order_con_information">
      <ul>
          <li><?php echo FS_SHIP_FROM;?> <?php echo $warehouse;?></li>
          <li><?php echo FS_HOPE_DATE;?><?php echo $delivery_time;?></li>
          <li><?php echo FS_WAREHOUSE_AREA_30;?> <?php echo $shipping_method;?></li>
          <li><?php echo ACCOUNT_OF_SHIPPING;?> <?php echo $items;?></li>
          <li><?php echo FS_SHIPPING_COST;?>: <?php echo $shipping_cost;?></li>
          <li><?php echo ACCOUNT_OF_TOTAL;?> <?php echo $order['order_total'];?></li>
      </ul>
    </div>
    <div class="print_order_con_product">
	<?php echo $productsHtml;?>
    </div>
  </div>
  <?php }?>
<?php }?>
  <div class="order_view_total">
    <table class="tab_03" width="100%" cellspacing="0" cellpadding="0" border="0">
      
        <tr>
          <td class="big text_right" style="font-size:14px;"><?php echo FS_SUBTOTAL;?></td>
          <td width="70" class="big text_right" style="font-size:14px;text-align: left"><?php echo $cost_data['ot_subtotal'];?></td>
        </tr>
        <tr>
          <td class="big text_right" style="font-size:14px;"><?php echo FS_SHOPPING_CART;?></td>
          <td width="70" class="big text_right" style="font-size:14px;text-align: left"><?php echo $cost_data['ot_shipping'];?></td>
        </tr>
		<?php 
		if($cost_data['ot_tax']){
			echo '<tr>
			  <td class="big text_right" style="font-size:14px;">'.EMAIL_CHECKOUT_COMMON_VAT_COST.':</td>
			  <td width="70" class="big text_right" style="font-size:14px;text-align: left">'.$cost_data['ot_tax'].'</td>
			</tr>';
		}
		?>
        <tr>
          <td class="big text_right"><?php echo ACCOUNT_OF_TOTAL;?></td>
          <td width="70" class="big text_right" style="text-align: left"><?php echo $cost_data['ot_total'];?></td>
        </tr>
      
    </table>
  </div>
  
	<div class="other_comments"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><b><?php echo FS_OTHER_SPECIALS;?></b></td>
		<td><?php echo $mianOrder['customers_po'];?></td>
	  </tr>
	  </table>
	</div>
  <div class="print_order_wire_transfer">
	<?php 
	$title = $content = '';
	if($mianOrder['payment_module_code']=='paypal'){
		$title = FS_TITLE_PAYPAL;
		$content = FS_CONTENT_PAPAL;
		
	}else if($mianOrder['payment_module_code']=='globalcollect'){
		$title = FS_TITLE_PAYEEZY;
		$content = FS_CONTENT_PAYEEZY;
	}else if($mianOrder['payment_module_code']=='hsbc'){
		$title = 'Please T/T to  the following account';
		if(german_warehouse("country_code",$country_code_new)||other_eu_warehouse($country_code_new,"country_code")){
			$content = '<dl>
				 <dt>'.FS_HSBC_INFO1.':<br />
					'.FS_HSBC_INFO2.':<br />
					'.FS_HSBC_INFO3.':<br />
					'.FS_HSBC_INFO4.':<br />
					'.FS_HSBC_INFO5.':<br />
					'.FS_HSBC_INFO6.':<br />
					</dt>
				 <dd>'.FS_CONTENT_HSBC_GERMAN.'
                    </dd>
			   </dl>';
		}else{
			$content = '<dl>
				 <dt>'.FS_CONTENT_HSBC_OTHER_1.'</dt>
				 <dd>'.FS_CONTENT_HSBC_OTHER_2.'</dd>
			   </dl>';
		}
	}
	?>
     <div class="print_order_tit"><?php echo $title ? $title : "";?></div>
     <div class="print_order_wire_transfer_infor">
      <?php echo $content;?>
     </div>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60%">&nbsp;</td>
    <td width="20%" height="30" style="border-bottom:1px dotted #dedede;">
        <?php
        if(zen_get_order_has_admin_of_id($orders_id)){
            echo zen_get_admin_name_of_id(zen_get_order_has_admin_of_id($orders_id));
        }else{
            echo 'Fiberstore';
        }?>
    </td>
    <td width="20%" style="border-bottom:1px dotted #dedede;">
        <?php
        if(in_array($_SESSION['languages_code'],array('ru','fr','es','mx'))){
            echo getTime('d/m/Y',strtotime($mianOrder['date_purchased']));
        }elseif($_SESSION['languages_code'] == 'de'){
            echo getTime('d.m.Y',strtotime($mianOrder['date_purchased']));;
        }else{
            echo get_date_display($mianOrder['date_purchased'],$_SESSION['languages_id']);
        }
        ?>
    </td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td><?php echo FS_AUTHORIZED_BY;?></td>
    <td><?php echo FS_QUSTION_DATE;?></td>
  </tr>
</table>
</div>
<script type="text/javascript">
window.print();
</script>
</body>
