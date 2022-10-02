<style>
    .shipping{margin-bottom: 15px;}
    .big_input{margin-left: 0;}
</style>


<?php
/**
 * checkout
 */?>
<script type="text/javascript">
$(function(){

	var patten = /^[a-zA-Z0-9.-]+\@[a-z0-9-]+\.[a-zA-Z0-9.-]+$/;

	$('#firstname').focus(function(){
$(this).siblings('.help_info').removeClass('no');
	});

	$('#Address_Line1').focus(function(){

		value = $(this).val();

		$(this).siblings('.help_info').removeClass('no');
	});

	$('#Address_Line2').focus(function(){

		value = $(this).val();

		$(this).siblings('.help_info').removeClass('no');

	});
	$('#City').focus(function(){

		value = $(this).val();

        $(this).siblings('.help_info').removeClass('no');

	});

	$('#entry_country_id').focus(function(){

		$(this).siblings('.help_info').removeClass('no');
	});


	$('#customers_state').focus(function(){

		value = $(this).val();

		$(this).siblings('.help_info').removeClass('no');

	});
	$('#Postal_Code').focus(function(){

		value = $(this).val();


		$(this).siblings('.help_info').removeClass('no');

	});
	$('#entry_telephone').focus(function(){

		value = $(this).val();

		$(this).siblings('.help_info').removeClass('no');

	});
});
	</script>
<script type="text/javascript">var order_totals = {"subtotal":"<?php echo $currencies->value($order->info['subtotal']);?>","shipping":"<?php echo (isset($_SESSION['shipping']['cost'])) ? $currencies->value($_SESSION['shipping']['cost']) : 0;?>","shipping_insurance":"<?php echo $currencies->value($order->info['shipping_insurance']);?>","total":"<?php echo $currencies->value($order->info['total']);?>"};

<?php
/* bof json for countries and telephone*/
$c_string = '';
foreach ($countries as $i => $country){
	$c_string .= '"'.$country['countries_id'].'":"'.$country['tel_prefix'].'",';
}
echo 'var country_to_telephone = {'.substr($c_string,0,(strlen($c_string)-1)).'};';
/* eof json for countries and telephone*/
?>
</script>
<?php $currency_symbol_left =  $currencies->currencies[$_SESSION['currency']]['symbol_left'];
      $currency_symbol_right = $currencies->currencies[$_SESSION['currency']]['symbol_right'];
?>

<body>

<div class="m_shopping_process_top ">
<div class="m_shopping_process_fixed ">
<div class="m_top">
  <span class="m_live"><a href="customer_service.html"target="_blank" ><span class="icon iconfont">&#xf137;</span></a></span>
  <span class="m_logo">
    <a href="<?php echo zen_href_link(FILENAME_DEFAULT,'','NONSSL')?>"><img src="../images/logo_fs_01.gif" border="0" ></a> 
  </span>
  <span class="m_cart"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART,'','NONSSL')?>"><span class="icon iconfont">&#xf094;</span></a></span>
</div>

<div class="login_new_01"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'','NONSSL')?>"><img src="/images/logo_fs_01.gif" border="0" class="aaa m_none"></a>
  <div class="checkout_breadcrumb">
    <ul>
      <li><?php echo FIBER_CHECK_CART;?></li>
      <li class="present"><?php echo FIBER_CHECK_CHECKOUT;?></li>
      <li><?php echo FIBER_CHECK_SUCCESS;?></li>
    </ul>
  </div>
  <div class="checkout_live"> 
  
 	<?php /*?><div>
		<!-- BEGIN ProvideSupport.com Text Chat Link Code -->
		<div id="ciKH1a"  class="checkout_now" style="z-index:100;position:absolute"></div>
		<div id="scKH1a"  class="checkout_now" style="display:inline"></div>
		<div id="sdKH1a"  class="checkout_now" style="display:none"></div>				
		<script type="text/javascript">
			var Chat_Now = "<?php echo '<em></em>Chat Now' ?>";
			var Offline = "<?php echo 'Offline' ?>";
			var seKH1a=document.createElement("script");
			seKH1a.type="text/javascript";
			var seKH1as=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/1vc93rc9z32rz0pyuigv77l5tr/safe-textlink.js?ps_h=KH1a&ps_t="+new Date().getTime()+"&online-link-html="+Chat_Now+"&offline-link-html="+Offline;
			setTimeout("seKH1a.src=seKH1as;document.getElementById('sdKH1a').appendChild(seKH1a)",1); 
		</script>
		<noscript><a href="http://www.providesupport.com?messenger=1vc93rc9z32rz0pyuigv77l5tr"><?php echo '<em></em>Online Chat';?></a></noscript>
		<!-- END ProvideSupport.com Text Chat Link Code -->
	</div><?php */?>
   <?php /* ?>
   <span><a href="<?php echo zen_href_link(FILENAME_LIVE_CHAT_SERVICE);?>" target="_blank"><em></em>Live Chat</a></span> 
   <?php */ ?>
   
   <span class="c_carticon"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>"><em></em><?php echo FIBER_CHECK_EDIT_CART;?></a></span> 
   </div>
  <!--<div class="header_04 bbb">
    <table width="230" cellspacing="0" cellpadding="0" border="0" class="pay_lc_three">
      <tbody>
        <tr>
          <td class="pay_liucheng" colspan="3"></td>
        </tr>
        <tr>
          <td width="20%"><div align="left" class="pay_lc_01">&nbsp;Cart</div></td>
          <td width="25%"><div align="center" class="pay_lc_03">&nbsp;&nbsp;&nbsp; Checkout</div></td>
          <td width="25%"><div align="right" class="pay_lc_04">Success</div></td>
        </tr>
      </tbody>
    </table>
  </div>--> 
</div>
</div>
</div>
<div class="box">
  <div class="content ">
    <!--<div class="checkout_top_btn">
	<a id="order_submit_a" class="button_02 bbb order_payment_ccc m_none" href="javascript:void(0);">Proceed to Paypal 
	<i class="security_icon"></i></a> 
	</div>-->
    <div class="layout">
      <div class="layout_con">
        <div class="layout_title"><?php echo FIBER_CHECK_PAYMENT;?></div>
        <div class="checkout_payment">
          <div class="Payment_select"> 
            <!-- <select class="login_country" name="payment_method" id="paymentMethod_select">
                      <option value="-1">Please select your payment method</option>
                      <option value="paypal" <?php echo ('paypal' == $payment_method) ? ' selected="selected"' : '';?>>PayPal</option>
                      <option value="westernunion" <?php echo ('westernunion' == $payment_method) ? ' selected="selected"' : '';?>>Western Union</option>
                      <option value="hsbc" <?php echo ('hsbc' == $payment_method) ? ' selected="selected"' : '';?>>Wire Transfer</option>
                    </select> -->
            <?php
               $default_payment = zen_get_customer_default_set_payment_method($_SESSION['customer_id']);
			   $globalcollect_currency = array('AUD','CAD','EUR','GBP','HKD','JPY','RUB','SGD','USD','CHF','MXN');
			   if(!in_array($_SESSION['currency'],$globalcollect_currency)){
					
					if($default_payment == 'westernunion'){
						$default_payment = "paypal";
					}
			   }
			    $bpay_currency = array (
                'AUD' 
            );
            if (! in_array ( $_SESSION ['currency'], $bpay_currency )) {
              if ($default_payment == 'bpay') {
                $default_payment = "paypal";
              }
            }
			$eNETS_currency = array (
                'SGD' 
            );
			if (!in_array($_SESSION ['currency'],$eNETS_currency)) {
              if ($default_payment == 'eNETS') {
                $default_payment = "paypal";
              }
            }
			$iDEAL_currency = array(
				 'EUR'
			);
			//if (!in_array($_SESSION ['currency'],$iDEAL_currency) || $customer_country_id != 150) {
			if (!in_array($_SESSION ['currency'],$iDEAL_currency)) {
              if ($default_payment == 'iDEAL') {
                $default_payment = "paypal";
              }
            }

			$SOFORT_currency = array(
				 'EUR',
				 'GBP',
				 'CHF',
				 'PLN'
			);
			if (!in_array($_SESSION ['currency'],$SOFORT_currency)) {
              if ($default_payment == 'SOFORT') {
                $default_payment = "paypal";
              }
            }
               ?>
            <ul>
              <?php
     if ($only_wt == 'yes'){
     ?>
              <li id="hsbc_class">
                <label>
                  <input type="radio" name="payment_method_name" id="hsbc_payment_method" value="hsbc" checked="checked" onclick = "payment_method_select(this.value)">
                  <?php echo FIBER_CHECK_WIRE;?></label>
              </li>
              <?php }else{?>
              <li class="checkbg" id="paypal_class">
                <label>
                  <input type="radio" name="payment_method_name" id="paypal_payment_method" value="paypal"
                    <?php echo (('paypal' == $default_payment) || (!$default_payment) ) ? ' checked="checked"' : '';?>  onclick = "payment_method_select(this.value)">
                  PayPal</label>
              </li>
              <?php if(in_array($_SESSION['currency'],$globalcollect_currency)){ ?>
              <li id="globalcollect_class">
                <label>
                  <input type="radio" name="payment_method_name" id="globalcollect_payment_method" value="globalcollect"
					<?php echo (('globalcollect' == $payment_method) || ('globalcollect' == $default_payment)) ? ' checked="checked"' : '';?>  onclick = "payment_method_select(this.value)">
                 <?php echo FIBER_CHECK_CREDIT;?></label>
              </li>
              <?php } ?>
		 <?php if(in_array($_SESSION['currency'],$bpay_currency)){ ?>

			    <li id="bpay_class"><label> <input type="radio"
										name="payment_method_name" id="bpay_payment_method"
										value="bpay"
										<?php echo (('bpay' == $payment_method) || ('bpay' == $default_payment)) ? ' checked="checked"' : '';?>
										onclick="payment_method_select(this.value)"> BPAY
								</label></li>
			  <?php } ?>
		  <?php if($_SESSION['currency'] == 'SGD'){ ?>
			   <li id="eNETS_class"><label> <input type="radio"
										name="payment_method_name" id="eNETS_payment_method"
										value="eNETS"
										<?php echo (('eNETS' == $payment_method) || ('eNETS' == $default_payment)) ? ' checked="checked"' : '';?>
										onclick="payment_method_select(this.value)"> eNETS
								</label></li>
			  <?php } ?>
			   <?php 
			   //if($_SESSION['currency'] == 'EUR' && $customer_country_id == 150){ 
			    if($_SESSION['currency'] == 'EUR'){
			   ?>
								 <li id="iDEAL_class"><label> <input type="radio"
										name="payment_method_name" id="iDEAL_payment_method"
										value="iDEAL"
										<?php echo (('iDEAL' == $payment_method) || ('iDEAL' == $default_payment)) ? ' checked="checked"' : '';?>
										onclick="payment_method_select(this.value)"> iDEAL
								</label></li>
			   <?php } ?>
			     <?php if(in_array($_SESSION ['currency'],$SOFORT_currency)){ ?>
								 <li id="SOFORT_class"><label> <input type="radio"
										name="payment_method_name" id="SOFORT_payment_method"
										value="SOFORT"
										<?php echo (('SOFORT' == $payment_method) || ('SOFORT' == $default_payment)) ? ' checked="checked"' : '';?>
										onclick="payment_method_select(this.value)"> SOFORT
								</label></li>
				  <?php } ?>
              <!-- <li id="westernunion_class">
                  <label>
                    <input type="radio" name="payment_method_name" id="west_payment_method" value="westernunion"
                    <?php echo (('westernunion' == $payment_method) || ('westernunion' == $default_payment)) ? ' checked="checked"' : '';?>
                    onclick = "payment_method_select(this.value)">
                    <img title="Western Union" alt="Western Union " src="images/logo_western01.jpg">Western Union</label>
                </li> -->
              <li id="hsbc_class">
                <label>
                  <input type="radio" name="payment_method_name" id="hsbc_payment_method" value="hsbc"
                    <?php echo (('hsbc' == $payment_method) || ('hsbc' == $default_payment)) ? ' checked="checked"' : '';?> onclick = "payment_method_select(this.value)">
                 <?php echo FIBER_CHECK_WIRE;?></label>
              </li>
              <?php }?>
            </ul>
            <div class="ccc"></div>
          </div>
          <div style="display:block" id="paypal" class="Payment_wen">
            <fieldset style="border:0px dotted gray">
              <legend><?php echo FIBER_CHECK_MAKE;?>: </legend>
              <ul>
                <!--<li>New users can register PayPal account, first, and then continue to pay on the PayPal website.</li>-->
                <li> <a target="_blank"  class="width_small" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside"><img border="0" alt=" Solution Graphics" title=" Solution Graphics " src="includes/templates/fiberstore/images/english/logo/paypal.gif"><img border="0" alt=" Solution Graphics" title=" Solution Graphics " src="includes/templates/fiberstore/images/english/logo/paypal02.gif"></a> <a class="paypalIcon" target="_blank" href="https://www.paypal.com/verified/pal=paypal@fs.com"><img src="/images/logo_Paypal.jpg" width="38px"/></a> </li>

              </ul>
            </fieldset>
            <div class="pay_05_xd"><b><?php echo FIBER_CHECK_NOTE;?></b>: <?php echo FIBER_CHECK_OUR;?></div>
          </div>
          <div class="Payment_wen" style="display: <?php echo ('globalcollect' == $payment_method) ? ' block"' : ' none';?>;" id="globalcollect">
            <fieldset style="border:0px dotted gray">
              <legend><?php echo FIBER_CHECK_WE;?>:</legend>
              <p> <span class="visaIcon"></span> <span class="visaDebitIcon"></span> <span class="masterCardIcon"></span> <span class="masterCardDebitIcon"></span> <span class="visaElectronIcon"></span> <span class="americanExpressIcon"></span> <!--<span class="debitIcon"></span>--> <span class="jcbIcon"></span> <span class="Discover"></span> <span class="Diners"></span></p>
            </fieldset>
            <div class="pay_05_xd"> <b><?php echo FIBER_CHECK_NOTE;?></b>: <?php echo FIBER_CHECK_FOR;?></div>
          </div>
	<div style="display: block" id="bpay" class="Payment_wen">
							<fieldset style="border: 0px dotted gray">
								 <legend><?php echo FIBER_CHECK_TELE;?></legend>
								<!-- <ul>
									<li></li>
									
								</ul>  -->
								<p><?php echo FIBER_CHECK_CONTACT;?> </p>
							</fieldset>
						</div>	
							<div style="display: block" id="eNETS" class="Payment_wen">
							<fieldset style="border: 0px dotted gray">
								 <legend>eNETS</legend> 
				
								<p><?php echo FIBER_CHECK_OFFERS;?></p>
							</fieldset>
						</div>
						<div style="display: block" id="iDEAL" class="Payment_wen">
							<fieldset style="border: 0px dotted gray">
								 <legend>iDEAL</legend> 
				
								<p><?php echo FIBER_CHECK_OFFERS;?></p>
							</fieldset>
						</div>
						<div style="display: block" id="SOFORT" class="Payment_wen">
							<fieldset style="border: 0px dotted gray">
								 <legend>SOFORT</legend> 
				
								<p><?php echo FIBER_CHECK_OFFERS;?></p>
							</fieldset>
						</div>
          <div class="Payment_wen" style="display: <?php echo ('hsbc' == $payment_method) ? ' block"' : ' none';?>;" id="hsbc">
            <fieldset style="border:0px dotted gray">
              <legend><?php echo FIBER_CHECK_HSBC;?>: </legend>
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cartInfo">
                <tbody>
                  <!-- <tr>
							        <td colspan="2">Wire Transfer beneficiary details:</td>
							    </tr> -->
                  <tr>
                    <td width="160"><?php echo FIBER_CHECK_BANK_NAME;?>:</td>
                    <td><strong>HSBC Hong Kong</strong></td>
                  </tr>
                  <tr>
                    <td><?php echo FIBER_CHECK_AC_NAME;?>: </td>
                    <td><strong>FIBERSTORE CO., LIMITED</strong></td>
                  </tr>
                  <tr>
                    <td><?php echo FIBER_CHECK_AC_NO;?>:</td>
                    <td><strong>817-498231-838</strong></td>
                  </tr>
                  <tr>
                    <td><?php echo FIBER_CHECK_SWIFT;?>:</td>
                    <td><strong>HSBCHKHHHKH</strong></td>
                  </tr>
                  <tr>
                    <td><?php echo FIBER_CHECK_BANK_ADDRESS;?>:</td>
                    <td><strong>1 Queen's Road Central, Hong Kong</strong></td>
                  </tr>
<!--                  <tr>
                    <td><strong>Our Company Address:</strong></td>
                    <td>Eastern Side, Second Floor, Science & Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China</td>
                  </tr>-->
                </tbody>
              </table>
              
            </fieldset>
            <!--<div class="pay_05_xd"> <b>Note</b>: Customers who choose bank transfer is responsible for all handling charges and handling fees Local intermediary banks.</div>-->
          </div>
          <div class="ccc"></div>
        </div>
      </div>
      <div class="layout_con">
      
        <div class="layout_title"><?php echo FIBER_CHECK_ADDRESS;?>  <a href="<?php echo zen_href_link(address_book_edit,'','SSL');?>"><span class="checkout_edit"><i class="new_edit"></i> <?php echo FIBER_CHECK_EDIT;?></span></a></div>

        <div class="layout_son">
          <div class="checkout_address_infor"> <span><?php echo FIBER_CHECK_BILLING;?></span>
          <?php 
		   $billing_status = false;
		 
		  if($billing_addresses){ 
			  ?>
            <?php foreach ($billing_addresses as $i => $address){
                   if (isset($_SESSION['billto']) && $_SESSION['billto']==$address['address_book_id']){
					     $billing_status = true;
					  break;
                   }
			 ?>
            <?php }?>
		   <?php }?>
		   <?php if($billing_status){?>
		    <input type="hidden" id="billing_address" value="<?php echo $address['address_book_id'];?>" name="billing_address">
            <p id="bill_address" value="<?php echo $address['address_book_id'];?>" name="bill_address"  > <?php echo $address['entry_firstname'] .' ' .$address['entry_lastname'];?></p>
			  <p> <?php echo $address['entry_company'];?></p>
             <p> <?php echo $address['entry_street_address'] . $address['entry_suburb'];?></p>
               </p><p><?php echo $address['entry_city'];?>, <?php echo $address['entry_state'];?>,<?php echo $address['entry_postcode'];?> </p>
              <p><?php echo $address['entry_country']['entry_country_name'];?></p>
               <p><?php echo $address['entry_telephone'];?> </p>
			<?php }else{ ?>
			 <input type="hidden" id="billing_address" value="" name="billing_address">
			<?php } ?>
          </div>
		  
          <div class="checkout_address_infor"> <span><?php echo FIBER_CHECK_SHIPPING;?></span>
          <?php  $shipping_status = false;?>
          <?php if($shipping_addresses){ ?>
            <?php foreach ($shipping_addresses as $i => $address){
                   
                   		if (isset($_SESSION['sendto']) && $_SESSION['sendto']==$address['address_book_id']){
							$shipping_status = true;
	                   		 break;
	                   	}
					}?>
			  <?php } ?>
           <?php if($shipping_status){ ?>
            <input id="default_book_id" name="default_book_id" type="hidden" value="<?php echo $address['address_book_id']?>">
            <input type="hidden" id="ship_address" value="<?php echo $address['address_book_id'];?>" name="ship_address">
			 <p><?php echo $address['entry_firstname'] .' ' .$address['entry_lastname'];?></p>
			   <p> <?php echo $address['entry_company'];?></p>
             <p><?php echo $address['entry_street_address'] . $address['entry_suburb'];?></p>
             <p><?php echo $address['entry_city'];?>, <?php echo $address['entry_state'];?>, <?php echo $address['entry_postcode'];?></p>
             <p><?php echo $address['entry_country']['entry_country_name'];?> </p>
             <p><?php echo $address['entry_telephone'];?> </p>
			 <?php }else{ ?>
			  <input type="hidden" id="ship_address" value="" name="ship_address">
			 <?php } ?>
          </div>
		   <?php
				if(!empty($address['entry_telephone'])){
						?>

						 <input type="hidden" id="ship_entry_telephone" value="1" name="ship_entry_telephone">
						<?php
				}else{
							 	?>

							  <input type="hidden" id="ship_entry_telephone" value="0" name="ship_entry_telephone">
				<?php
				}
				if(zen_pb_po_box_address($address['entry_street_address'],$address['entry_suburb'])){
						?>

						 <input type="hidden" id="po_box" value="1" name="po_box">
						<?php
				}else{
							 	?>

							  <input type="hidden" id="po_box" value="0" name="po_box">
				<?php
				}
				
			 ?>
		
        </div>
      </div>
    </div>
    <div class="shopcart_summary">
      <table class="shopping_cart shopping_cart_checkout" width="100%" cellspacing="0" cellpadding="10" border="0">
        <tr>
          <th width="85"></th>
          <th width="45%"><?php echo FIBER_CHECK_ITEM;?></th>
          <th width="15%" class="text_center"><?php echo FIBER_CHECK_UP;?></th>
          <th width="15%" class="text_center"><?php echo FIBER_CHECK_QTY;?></th>
          <th width="10%" class="text_center"><?php echo FIBER_CHECK_WEIGHT;?></th>
          <th width="15%" class="text_right"><?php echo FIBER_CHECK_TOTAL;?> </th>
        </tr>
        <?php 
        $FsCustomRelate = new classes\custom\FsCustomRelate();
        foreach ($productArray as $i => $product){
              	//$image = zen_image(DIR_WS_IMAGES.$product['productImageSrc'],'',60,60);
              	$image_src= file_exists(DIR_WS_IMAGES.$product['productImageSrc']) ? DIR_WS_IMAGES.$product['productImageSrc']: DIR_WS_IMAGES.'no_picture.gif';
				$image = zen_image($image_src,$product['productsName'],200,200,'title="'.$product['productsName'].'"');

			    // 如果购买的数量大于  库存  显示提示语
			   // echo zen_get_products_instock_total_qty_is_show_message($product['id'],(int)$product['quantity'],$product['attributes'] );

				?>
        <tr>
          <td class="shopping_cart_02"><?php echo $image;?></td>
          <td class="shopping_cart_02"><p><?php echo $product['productsName'];?></p>
            <?php
				  if (isset($product['attributes']) && is_array($product['attributes'])){
				  echo '<div class="cartAttribsList">';
				  echo '<ul class="shopping_cart_02">';
				    reset($product['attributes']);$Length=$Attr='';
				    foreach ($product['attributes'] as $option => $value) {
								if($option == 'length'){ $Length = $value['length'];
							?>
            <li><?php echo $value['length'] ?>
              <?php

								              echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$value['price_prefix'].$currencies->display_price($value['length_price'],0,1);

								                  ?>
            </li>
            <?php
			        		}else{ $Attr[] = $value['options_values_id'];  ?>
            <li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?>
              <?php
								             if($value['options_values_price'] > 0){
												echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$value['price_prefix'].$currencies->display_price($value['options_values_price'],0,1);
											}
								                  ?>
            </li>
            <?php }
					}
				  echo '</ul>';
				  echo '</div>';
				  }
				?>
            <div class="shopping_cart_sku"><span class="product_sku">#<span><?php echo (int)$product['id'];?></span></span> <span class="products_in_stock"></span>
        <?php 
        $ProductsID=$product['id'];
            if(is_array($Attr)&&sizeof($Attr)){
              $FsCustomRelate::$products_id = $product['id'];
              $FsCustomRelate::$optionAttr = $Attr;
              $FsCustomRelate::$length = $Length;
              $matchProducts = $FsCustomRelate->handle();
              if($matchProducts){
                $ProductsID = $matchProducts[0];
              }
            }
        $NowInstockQTY = zen_get_products_instock_total_qty_of_products_id((int)$ProductsID);

		if($NowInstockQTY!=='Available'){
			echo '
		<meta itemprop="availability" content="http://schema.org/InStock" />
		<meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
		<span class="products_in_stock">'.$NowInstockQTY.','.'</span> '.zen_get_products_instock_shipping_date_of_products_id((int)$product['id'],$NowInstockQTY,$countries_code_2).

			'<div class="track_orders_wenhao">
		<div class="question_bg"></div>
		 <div class="question_text_01 leftjt"><div class="arrow"></div>
			<div class="popover-content">';
			    
				echo FS_THEA_CTUAL_SHIPPING_TIME;
				
		echo	'</div>
		 </div>
      </div>'
		;

		}else{
 		echo '
		<meta itemprop="availability" content="http://schema.org/InStock" />
		<meta itemprop="itemCondition" content="http://schema.org/NewCondition" />
		<span class="products_in_stock">'.$NowInstockQTY.','.'</span> '.zen_get_products_instock_shipping_date_of_products_id((int)$product['id'],$NowInstockQTY,$countries_code_2).' <div class="track_orders_wenhao">
		<div class="question_bg"></div>
		 <div class="question_text_01 leftjt"><div class="arrow"></div>
			<div class="popover-content">';
			    
				if($deliver_time == 1){
				 $shipping_html=FIBER_CHECK_ORDERS;
				}else if($deliver_time == 2){
				 $shipping_html=FIBER_CHECK_ORDERS1;
				}else{
				 $shipping_html= FIBER_CHECK_THERE;
				}
				echo $shipping_html;
				
		echo	'</div>
		 </div>
      </div>'
		;
 		}
  ?>
            </div>
            
            <!--mark  自适应-->
             <div class="shopping_cart_03 m_price">
             <?php
          if ($_SESSION ['member_level'] > 1 && $currencies->display_price_rate ( zen_round ( ($product ['products_price'] * $order->info ['currency_value']), 2 ), 0, 1 ) != $product ['productsPriceEach']) {
            echo '<span>' . $currencies->display_price_rate ( zen_round ( ($product ['products_price'] * $order->info ['currency_value']), 2 ), 0, 1 ) . '</span>';
          }
          $shopping_total += $product ['products_price_total'];
          echo $product ['productsPriceEach'];
          ?>
            </div>
            
            <div class="m_qty"><?php echo FIBER_CHECK_QTY;?>: <?php echo $product['quantity'];?></div>
            <!--mark  结束-->
            </td>
          
          <td class="shopping_cart_03 text_center">   <?php
				  if($_SESSION['member_level'] >1 && $currencies->display_price_rate(zen_round(($product['products_price']*$order->info['currency_value']),2),0,1) != $product['productsPriceEach']){
				  echo '<span>'.$currencies->display_price_rate(zen_round(($product['products_price']*$order->info['currency_value']),2),0,1).'</span><br/>';
				   }
                   $shopping_total += $product['products_price_total'];
				   echo $product['productsPriceEach'];?></td>
          <td class="text_center"><?php echo $product['quantity'];?></td>
		  <td class="text_center"><?php echo $product['productsWeight'];?></td>
          <td class="text_right"><?php echo  $product['productsPrice'];?></td>
        </tr>
        <?php }?>
      </table>
      
      <!-- eof shopping cart *************************************************--> 
      <!-- <div class="check2_Payment_Total"  style="display:<?php echo $no_shipping ? 'none': 'block';?>;">
                <table class="shopping_cart shopping_cart_checkout" width="100%" cellspacing="0" cellpadding="10" border="0">
                  <tr>
                    <td class="text_right checkout_05"><?php printf($order_total_lists[0]['title'],$_SESSION['cart']->count_contents());?></td>
                    <td class="text_right checkout_05" width="80">&nbsp;<strong><?php echo $currency_symbol_left;?><?php echo $currencies->fs_format($order_total_lists[0]['value'], true, $order->info['currency'], $order->info['currency_value']);//number_format($order_total_lists[0]['value'],2,'.','');?><?php echo $currency_symbol_right;?>
                    </tr>
                  <tr>
                    <td class="text_right checkout_05 checkout_08"><?php echo $order_total_lists[1]['title'];?></td>
                    <td class="text_right checkout_05 checkout_08"><strong>&nbsp;<?php echo $currency_symbol_left;?></strong><span id="shipping_cost"><?php echo $currencies->fs_format($order_total_lists[1]['value'], true, $order->info['currency'], $order->info['currency_value']);//number_format($order_total_lists[1]['value'],2,'.','');?><?php echo $currency_symbol_right;?>
                    </tr>
                  <tr>
                    <td align="right" class="text_right checkout_05 checkout_06 checkout_06_size"><?php echo $order_total_lists[2]['title'];?></td>
                    <td class="text_right checkout_05 checkout_06"><strong>&nbsp;<?php echo $currency_symbol_left;?></strong><span id="total_fee"><?php echo $currencies->fs_format($order_total_lists[2]['value'], true, $order->info['currency'], $order->info['currency_value']);//number_format($order_total_lists[2]['value'],2,'.','');?><?php echo $currency_symbol_right;?>
                    </tr>
                </table>
              </div> -->
      <div class="aaa">

	  <!-- <div class="checkout_label" id="products_custom_div">
                       <label><input type="checkbox" name="products_custom" id="products_custom" value="0"><i class="label_kuang"></i>
                       Customize private label</label>
                    </div>-->



        <div class="checkout_invoice"> 
          <!--<a id="customer_po" href="javascript:void(0);" class="checkout_invoice_bg">Fill in your PO number</a>
          <div class="ccc"></div>-->
          <input id="checkout_invoice_input" type="text" class="checkout_invoice_input " name="checkout_invoice_input">
          	<p class="checkout_invoice_prompt"><?php echo FIBER_CHECK_PO;?></p>
        </div>
        <div class="ccc"></div>
        <div class="checkout_invoice"> 
          <!--<a id="order_remarks" href="javascript:void(0);" class="checkout_invoice_bg checkout_invoice_bghover">Order remarks</a>
          <div class="ccc"></div>-->
          <div class="public_textarea"><p class="checkout_invoice_prompt"><?php echo FIBER_CHECK_CUSTOMER;?></p><textarea class="textarea"  style="display:block;" id="order_remarks_input"></textarea></div>
          
          <div class="track_orders_wenhao bbb">
                <div class="question_bg"></div>
                 <div class="question_text_01 leftjt"><div class="arrow"></div>
                    <div style="display:block;">
                      <?php echo FIBER_CHECK_REMARK;?> 
                      </div>
                 </div>
          </div>
          
          <?php if ($have_optical_module) { ?>
                      <div class="prompt"><?php echo FIBER_CHECK_ADVISE;?></div>	
           <?php }?>
          
        </div>
      </div>
      <div class="checkout_offset">
        <div class="checkout_price">
          <ul>
            <li class="price_width"><span class="aaa"><?php echo FIBER_CHECK_SUB;?>:</span><?php echo $currency_symbol_left;?><?php echo $currencies->fs_format($order_total_lists[0]['value'], true, $order->info['currency'], $order->info['currency_value']);//number_format($order_total_lists[0]['value'],2,'.','');?><?php echo $currency_symbol_right;?></li>
          </ul>
        </div>
       <div class="checkout_send">
			


			<span class="aaa">[+]<?php echo FIBER_CHECK_COST;?>
<?php 
$cable_status = fs_is_bulk_fiber_cable_status();
if(in_array($entry_country_id,array(223,38,138)) && $cable_status == false){ ?>
	  <div class="track_orders_wenhao">
		<div class="question_bg"></div>
		 <div class="question_text_01 leftjt"><div class="arrow"></div>
			<div class="popover-content"><?php echo FIBER_CHECK_SHIPPING_DES;?></div>
		 </div>
      </div>
<?php } ?>
:
			
			</span>
			 <?php 
					if($address_book_result){
					 $shipping_methods = array();
                    $no_shipping = ($quotes['fedexzones']['error'] && $quotes['dhlzones']['error'] && $quotes['airmailzones']['error']) ? true  : false;
                    if (sizeof($quotes)){ ?>
					
			<div class="send">
				<ul class="send_name">
				<?php   if($n == $ny_stock){ 
				
				$us_shipping_arr =  array(
					array(
						'method'=>'ffzones',
					    'title'=>'ODFL'
					),
					array(
						'method'=>'upsgroundzones',
					    'title'=>FIBER_CHECK_STAND
					),
					array(
						'method'=>'ups2dayszones',
					    'title'=>FIBER_CHECK_TWO
					),
					array(
						'method'=>'upsovernightzones',
					    'title'=> FIBER_CHECK_ONE
					),
					
						
					array(
						'method'=>'fedexovernightzones',
					    'title'=> FIBER_FEDEX_CHECK_OVER
					),
					array(
						'method'=>'fedex2dayzones',
					    'title'=> FIBER_FEDEX_CHECK_TWO
					)
					
						
				
				);
				
				?>

					<?php 
					$j=0;
					foreach($us_shipping_arr as $key=>$v){ ?>
						
						<?php if (isset($quotes[$v['method']]) && is_array($quotes[$v['method']]) && $quotes[$v['method']]['methods'][0]['cost']>=0){
	                   			$f_display = true;$shipping_methods[] = $v['method'];$j++;
	                        	}else{
                        		$f_display = false;
                        	}?>
                <?php if($f_display){ ?>

						<li class="shipping <?php if($j==1)echo "checked";?>">
							<label>
					<input  type="radio" name="shipping_choose" <?php if($j==1)echo "checked='checked'";?> onClick="changeShipping('<?php echo $v['method'];?>')"><span class="shipping_name"><?php echo $v['title'];?><?php //echo get_days($_SESSION['countries_code_2'],$v['method']);?></span><span class="shipping_price">
							<?php 
				if($quotes[$v['method']]['methods'][0]['cost'] == 0){
								echo FIBER_CHECK_FREE;
							}else{
				echo $currencies->new_format($quotes[$v['method']]['methods'][0]['cost'], true, $order->info['currency'], $order->info['currency_value']);
							}
							?>
							</label>
							</span>
                	
						</li>
					<?php } ?>
					<?php }?>


						

	<?php
					if(date('D') == 'Fri'){ ?>
					<?php if (isset($quotes['saturdaydeliveryzones']) && is_array($quotes['saturdaydeliveryzones']) && $quotes['saturdaydeliveryzones']['methods'][0]['cost']>=0){
										$f_display = true;$shipping_methods[] = 'saturdaydeliveryzones';
										}else{
										$f_display = false;
									}?>
						<?php if($f_display){ ?>
			<li class="shipping">
							<label>
									
							<input  type="radio" name="shipping_choose" onClick="changeShipping('saturdaydeliveryzones')"><span class="shipping_name">Saturday Delivery </span><span class="shipping_price">
									<?php 
						echo $currencies->new_format($quotes['saturdaydeliveryzones']['methods'][0]['cost'], true, $order->info['currency'], $order->info['currency_value']);
									?>
									</span>
					
						</label>
				</li>
					<?php } ?>	
			<?php } ?>
	
<?php if($address['entry_state'] == 'Washington'){ ?>
<?php if (isset($quotes['selfreferencezones']) && is_array($quotes['selfreferencezones']) && $quotes['selfreferencezones']['methods'][0]['cost']>=0){
										$f_display = true;$shipping_methods[] = 'selfreferencezones';
										}else{
										$f_display = false;
									}?>
						<?php if($f_display){ ?>
				<li class="shipping">
							<label>
									
							<input  type="radio" name="shipping_choose" onClick="changeShipping('selfreferencezones')"><span class="shipping_name"> I'll pick it up in person</span><span class="shipping_price">
									<?php 
						echo $currencies->new_format($quotes['selfreferencezones']['methods'][0]['cost'], true, $order->info['currency'], $order->info['currency_value']);
									?>
									</span>
						
						</label>
				</li>
				<?php } ?>	
				<?php } ?>

						
						






				<?php }else{ ?>
								
	<?php
					$iso_shipping_arr =  array(
					array(
						'method'=>'upszones',
					    'title'=>'UPS'
					),
					array(
						'method'=>'fedexzones',
					    'title'=>'FedEx IP'
					),
					array(
						'method'=>'dhlzones',
					    'title'=>'DHL'
					),
					array(
						'method'=>'airmailzones',
					    'title'=>'Airmail'
					),
					array(
						'method'=>'emszones',
					    'title'=>'EMS'
					),
					array(
						'method'=>'fedexiezones',
					    'title'=>'FedEx IE'
					),
						array(
						'method'=>'tntzones',
					    'title'=>'TNT'
					),
						array(
						'method'=>'airliftzones',
					    'title'=>'Airlift shipping'
					),
						array(
						'method'=>'seazones',
					    'title'=>'Sea shipping'
					)
						
				
				);
				
				?>
			
					<?php 

					$j=0;
					foreach($iso_shipping_arr as $key=>$v){ ?>
						<?php if (isset($quotes[$v['method']]) && is_array($quotes[$v['method']]) && $quotes[$v['method']]['methods'][0]['cost']>=0){
	                   			$f_display = true;$shipping_methods[] = $v['method'];$j++;
	                        	}else{
                        		$f_display = false;
                        	}?>
                <?php if($f_display){ ?>
						<li class="shipping <?php if($j==1)echo "checked";?>">
						<label>
							
					<input   type="radio" name="shipping_choose" <?php if($j==1)echo "checked='checked'";?>  onClick="changeShipping('<?php echo $v['method'];?>')"><span class="shipping_name"><?php echo $v['title'];?>  <?php echo get_days($_SESSION['countries_code_2'],$v['method']);?></span><span class="shipping_price">
							<?php 
				if($quotes[$v['method']]['methods'][0]['cost'] == 0){
								echo FIBER_CHECK_FREE;
							}else{
				echo $currencies->new_format($quotes[$v['method']]['methods'][0]['cost'], true, $order->info['currency'], $order->info['currency_value']);
							}
							?>
							</span>
         
				</label>
						</li>
						<?php } ?>	
					<?php }?>


				<?php } ?>

<?php if (isset($quotes['customzones']) && is_array($quotes['customzones']) && $quotes['customzones']['methods'][0]['cost']>=0){
	                   			$f_display = true;$shipping_methods[] = 'customzones';
	                        	}else{
                        		$f_display = false;
                        	}?>
                <?php if($f_display){ ?>
				<li class="shipping">
					<label>
							
					<input  type="radio" name="shipping_choose" onClick="changeShipping('customzones')"><span class="shipping_name"><?php echo FIBER_CHECK_USE;?></span><span class="shipping_price">
							<?php 
				echo $currencies->new_format($quotes['customzones']['methods'][0]['cost'], true, $order->info['currency'], $order->info['currency_value']);
							?>
							</span>
               
				</label>
				
                <!--mark 2017.05.31-->
                <div class="shipping_freight">
                  <span>
                      <select id="method" name="method" class="login_country">
                        <option value="FEDEX">FEDEX</option>
                        <option value="DHL">DHL</option>
                        <option value="EMS">EMS</option>
                        <option value="UPS" selected="">UPS</option>
                        <option value="TNT">TNT</option>
                        <option value="OTHERS">OTHERS</option>
                      </select>
                  </span>
                  <span class="shipping_freight_nub">
                      <p class="pc_prompt"><?php echo FIBER_CHECK_EXPRESS;?></p>
                      <input type="text" id="acount" class="big_input" name="acount" value="" onBlur="return my_submit();">
                  </span>
                </div>
                 <!--mark 2017.05.31-->
						</li>
						 <?php } ?>	
						
				</ul>
				<div class="shipping_more">+ <?php echo FIBER_CHECK_MORE;?></div>
			</div>
             <div class="ccc"></div>
			
			  <div id="custom_text_1" style="display:none"></div>
            <?php }else{
                   	/*no shipping methods*/
                  ?>
            <h3 style="color: rgb(197, 0, 1); text-align: center; font-size: 15px; padding: 35px;"><img src="includes/templates/fiberstore/images/english/logo/exclamation.png"> <?php echo FIBER_CHECK_NO;?> <a href="contact_us.html"> <?php echo FIBER_CHECK_CONTACT_US;?> </a> </h3>
            <?php } ?>
            <?php if($shipping_methods){ 
					 if(isset($_SESSION['method_shppings']) && $_SESSION['method_acounts']){
							if(!empty($_SESSION['method_shppings']) && !empty($_SESSION['method_acounts'])){  
								//$shipping_methods[0] = 'customzones';
							}
					 }
			  ?>
            <script type="text/javascript">
						$(document).ready(function(){
							$("#<?php echo $shipping_methods[0];?>").attr('checked','true');
							changeShippings('<?php echo $shipping_methods[0];?>');
						});
							
					</script>
            <?php } ?>
            <?php }else{ ?>
            <div class="ccc"></div>
            <div class="checkout_prompt"> <b><?php echo FIBER_CHECK_TIPS;?></b> <span><?php echo FIBER_CHECK_ENTER?></span> </div>
            <?php }?>

        </div>
        <div class="shopping_cart_04">
          <dl>
            <dd class="shopping_cart_04_03">&nbsp;<?php echo $currency_symbol_left;?><span id="total_fee"><?php echo $currencies->fs_format($order_total_lists[0]['value'], true, $order->info['currency'], $order->info['currency_value']);?></span><?php echo $currency_symbol_right;?></dd>
            <dd class="shopping_cart_04_02"><span><?php echo FIBER_CHECK_TOTAL;?> <a href="javascript:void(0);" onClick="javascript: show_taxes();"><font >(<?php echo FIBER_CHECK_EXCLUDE;?>)</font></a>:</span></dd>
          </dl>
        </div>
        
        <!-- taxes info -->
        <div id="taxes_popup" style="display: none;"></div>
        <div id="taxes_window" class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed" style="display: none;">
          
          <div id="popup_content">
            <div class="popup_tit"><?php echo FIBER_CHECK_DIS;?></div>
            <div class="popup_con">
            <?php echo FIBER_CHECK_IMPORT;?><br />
            <br />
            <?php echo FIBER_CHECK_THESE;?></div> 
             <div class="box_close"><a onClick="$('#fs_overlay,#fs_popup').hide();" href="javascript:void(close_taxes());" class="noCtrTrack" id="lb-close"></a></div>
             </div>
        </div>
        <!-- end o taxes -->
        
        <?php   if(zen_get_customer_has_phl($_SESSION['customer_id'])){?>
        <div class="shopping_cart_05"> <span class="shopping_cart_button"><a id="order_submit" class="button_02 order_payment_ccc" href="javascript:void(0);"><?php echo (isset($_SESSION['payment']) && 'paypal' == $_SESSION['payment']) ? 'Proceed to Paypal' : 'Proceed to Paypal';?><i class="security_icon"></i></a></span>
          <?php /*?> <span class="shopping_cart_06" style="display:<?php echo $no_shipping ? 'none': 'block';?>;"> <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>" class="button_11">Edit My Order</a></span><?php */?>
          <div class="ccc"></div>
        </div>
        <?php }?>
        <!-- <div class="check2_Payment_paynow" style="display:<?php echo $no_shipping ? 'none': 'block';?>;"> <a class="checkout_09 button_04" href="<?php echo zen_href_link(FILENAME_SHOPPING_CART);?>">« Edit My Order</a>
                <?php

                        if(zen_get_customer_has_phl($_SESSION['customer_id'])){?>
                <div class="checkout_07"> <a class="button_02" href="javascript:void(0);" id="order_submit"><?php echo (isset($_SESSION['payment']) && 'paypal' == $_SESSION['payment']) ? 'Proceed to Paypal' : 'Submit Order';?></a>
                  <div class="ccc"></div>
                </div>
                <?php }?>
                <!-- <div class="Payment_paynow_anquan">Each order you place with us is safe.</div> --> 
      </div>
    </div>
  </div>
</div>


    <div class="ui-widget-overlay" style="display: none;" id="fs_overlays"></div>
    <div id="basic-modal-content" class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed" style="display:none;">
	  <div class = "popup_tit"><?php echo FIBER_CHECK_FREIGHT;?> &nbsp;</div>
      <div class="popup_con"><ul class="login_zhu_left checkout_shipping_01">
        <li>
          <p><?php echo FIBER_CHECK_METHOD;?>:</p>
           <select id="method" name="method" class="login_country">
		  <?PHP
		  $session_method = isset($_SESSION['method_shppings']) ? $_SESSION['method_shppings']:"";
		  $session_acount = isset($_SESSION['method_acounts']) ? $_SESSION['method_acounts']:"";
		  $shippingmethod = array('FEDEX','DHL','EMS','UPS','TNT','OTHERS');
		  foreach($shippingmethod as $jk){
					if($jk == $session_method){
						echo '<option value="'.$jk.'" selected>'.$jk.'</option>';
					}else{
						echo '<option value="'.$jk.'">'.$jk.'</option>';
					}
				}
				?>
          </select>
          <div class="ccc"></div>
        </li>
        <li>
          <p><?php echo FIBER_CHECK_EXPRESS;?>:</p>
         <input type="text" id="acount" class="big_input" name="acount" value="<?php echo $session_acount;?>">
          <i class="help_info"></i>
          <div style="display:none" class="error_prompt" id="_acount"></div>
          <div class="ccc"></div>
        </li>
        <li class="login_02">
          <input type="button" value="Submit" class="button_02" onClick="return my_submit();">
          <i class="help_info"></i>
          <div class="ccc"></div>
        </li>
      </ul>
	  </div>
      <div class="box_close"><a href="javascript: ;" onClick="$('#taxes_popup,#basic-modal-content,#fs_overlays').hide();"></a></div>
    </div>
</div>
</div>


<div id="overlayer" class="processing_bg" style="display:none;"></div>
        
    <div id="fs_loading" class="processing"  style="display:none;">
      <div class="processing_sub">
      <img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/loading.gif" />
      <div class="loader">
          <div class="loader-inner line-scale">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
              document.querySelector('main').className += 'loaded';
            });
          </script>
      </div>
      
      <?php echo FS_COMMON_PROCESSING;?> ...</div>
        
      </div>
  </div>
<?php  require($template->get_template_dir('tpl_checkout_new_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_checkout_new_footer.php');?>
</body>
<?php
$get_client_type = check_wap();
?>
<script type="text/javascript">
if($('.shipping').length>3){
      $('.shipping_more').show();
      $('.send_name').height('102px');
    }else if($('.shipping').length==3){
      $('.shipping_more').hide();
      $('.send_name').height('102px');
    }else{
      $('.shipping_more').hide();
       $('.send_name').height('70px')
    }
    var oSendHeight = $('.send_name').height();
$('.shipping').click(function(){
      var oHeight = $(this).height();
      var oFHeight = $('.send_name').height();
      var AllHeight = oFHeight + oHeight -20;
      if(oHeight>20){
        if(!$(this).hasClass('checked')){
          $('.send_name').stop().animate({'height':AllHeight});
        }
      }else if(!$('.send_name').hasClass('more')){
          $('.send_name').css({'height':oSendHeight});
      }else{
        if($('.shipping').length>3){
            $('.send_name').stop().animate({'height':oShippingHeight})
        }else{
          $('.send_name').stop().animate({'height':oSendHeight});
        }
      }
			$(this).addClass('checked').siblings().removeClass('checked');
			$(this).find('input').prop('checked','checked').siblings().find('input').removeAttr('checked')
		})
		var oShippingNum = $('.shipping').length;
		var oLiHeight = $('.shipping').height()+15;
		var oShippingHeight = oShippingNum * oLiHeight;
		$('.shipping_more').click(function(){
			if($('.send_name').hasClass('more')){
				$('.send_name').removeClass('more');
				$('.send_name').stop().animate({'height':'102px'})
				$(this).html('+ <?php echo FIBER_CHECK_MORE;?>')
			}else{
				$('.send_name').addClass('more');
				$(this).html('- <?php echo FIBER_CHECK_LESS;?>');
				$('.send_name').stop().animate({'height':oShippingHeight})
			}
		})
    $('.pc_prompt').click(function(){
      $(this).hide();
      $(this).siblings('.big_input').focus();
    })
    $('.big_input').focus(function(){
      $(this).siblings('.pc_prompt').hide();
    })
    $('.big_input').blur(function(){
      if($(this).val()==""){
        $(this).siblings('.pc_prompt').show();
      }else{
        $(this).siblings('.pc_prompt').hide();
      }
    })
$("#products_custom").toggle(function(){
    $("#products_custom_div label").addClass('label_kuang_h');
	$("#products_custom").val(1);
	},
   function(){
     $("#products_custom_div label").removeClass('label_kuang_h');
	 $("#products_custom").val(0);
	});


$("#customer_po").toggle(function(){
    $("#customer_po").addClass('checkout_invoice_bghover');
	$("#checkout_invoice_input").slideDown();},
   function(){
    $("#customer_po").removeClass('checkout_invoice_bghover');
    $("#checkout_invoice_input").slideUp();
	});
$("#order_remarks").toggle(function(){
	  $("#order_remarks").removeClass('checkout_invoice_bghover');
    $("#order_remarks_input").slideUp();
    $('.prompt').slideUp();
	},
   function(){    
    $("#order_remarks").addClass('checkout_invoice_bghover');
    $("#order_remarks_input").slideDown();
    $('.prompt').slideDown();
	});
function my_submit(){
	var method = $("#method").val();
	var acount = $("#acount").val();
	acount = acount.replace(/^\s+|\s+$/g, '');
	if(!method){
		alert('<?php echo FIBER_CHECK_THE;?>');return false;
	}
	if(!acount){
		//alert('Express Acount cannot be empty');return false;
	}
	$.ajax({
			url: "ajax_process_custom_shipping.php?request_type=custom_shipping",
			data: "&method="+method+"&acount="+acount+"&securityToken=<?php echo $_SESSION['securityToken'];?>&s=1",
			type: "POST",
			success: function(jtext){
			}
	});
	$("#custom_text_1").html("<span>Shipping Method: "+method+"<br />Express Account: "+acount+"</span>");
	$('#fs_overlays,#basic-modal-content').css('display','none');
}
$("#checkbox_weekend").click(function(){
	if($(this).is(":checked")){
		week_price = 10;
	}else{
		week_price = 0;
	}
    var shipping_method = $("#shipping_method").val();
	$.ajax({
			url: "ajax_process_custom_shipping.php?request_type=custom_weekend_up",
			data: "shipping_method="+shipping_method+"&week_price="+week_price+"&securityToken=<?php echo $_SESSION['securityToken'];?>",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#total_fee").text((parseFloat(order_totals.subtotal) + parseFloat(data.cost)).toFixed(2));
			}
	});
});
function apps(){
		$('#fs_overlays,#basic-modal-content').show();
}
$("#coupon_code_form").submit(function(){
	var code = $.trim($('#check_coupon').val());
	if (! code){
		$('#check_coupon').focus().css({border:'1px solid #f1ca7f'}).blur(function() {$(this).removeAttr('style');});
		return false;
	}
});

/*caculate the shipping insurance*/
$("#shipping_insurance").click(function(){
	if($("#shipping_insurance").is(":checked")){
		$.ajax({
			url: "ajax_process_other_requests.php?request_type=shipping_insurance",
			data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&s=1",
			type: "POST",
			beforeSend: function(){
//				alert('before');
				},
			success: function(jtext){
			}
		});
		/*get shipping insurance fee*/
		s_insurance_fee = order_totals.total;
		$("#total_fee").replaceWith('<span id="total_fee">' + s_insurance_fee + '</span>');

		 $("#shipping_insurance_charges").show();
		 //$("#is_insurance_charge").val(1);
	}else{
		$.ajax({
			url: "ajax_process_other_requests.php?request_type=shipping_insurance",
			data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&s=0",
			type: "POST",
			beforeSend: function(){
//				alert('before');
				},
			success: function(jtext){
			}
		});
		/*get shipping insurance fee*/
		s_insurance_fee = parseFloat(order_totals.total) - parseFloat(order_totals.shipping_insurance);
		$("#total_fee").replaceWith('<span id="total_fee">' + s_insurance_fee + '</span>');
		 $("#shipping_insurance_charges").hide();
		 //$("#is_insurance_charge").val(0);
	}
});


/*submit address form*/
$("input[name='entry_firstname']").blur(function(){$(this).css("border","");});
//$("input[name='entry_lastname']").blur(function(){$(this).css("border","");});
$("input[name='entry_street_addresss']").blur(function(){$(this).css("border","");});
$("input[name='entry_suburb']").blur(function(){$(this).css("border","");});
$("select[name='entry_country_id']").blur(function(){$(this).css("border","");});
$("input[name='entry_state']").blur(function(){$(this).css("border","");});
$("input[name='entry_postcode']").blur(function(){$(this).css("border","");});
$("input[name='customer_telephone']").blur(function(){$(this).css("border","");});

$("#saveAddress").click(function(){

	var
	 entry_firstname = $("input[name='entry_firstname']").val(),
	 entry_street_addresss = $("input[name='entry_street_address']").val(),
	 //entry_suburb = $("input[name='entry_suburb']").val(),
	 entry_city = $("input[name='entry_city']").val(),
	 entry_country_id = parseInt($("select[name='entry_country_id']").val()),
	 entry_state = $("input[name='entry_state']").val(),
	 entry_postcode = $("input[name='entry_postcode']").val(),
	 customer_telephone = $("input[name='entry_telephone']").val(),
	 error=false,
	 style="2px dotted red";

	if(entry_firstname.length < 1){
		//$("input[name='entry_firstname']").css("border",style).focus();
		$('#firstname').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_street_addresss.length < 4){
		//$("input[name='entry_street_address']").css("border",style).focus();
		$('#Address_Line1').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

//	if(entry_suburb.length < 1){
//		//$("input[name='entry_suburb']").css("border",style).focus();
//		$('#Address_Line2').siblings('.help_info').removeClass('yes').addClass('no');
//		error = true;
//	}


	if(entry_city.length < 1){
		//$("input[name='entry_city']").css("border",style).focus();
		$('#City').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_country_id < 1){
		//$("select[name='entry_country_id']").css("border",style).focus();
		$('#entry_country_id').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_state.length < 1){
		//$("input[name='entry_state']").css("border",style).focus();
		$('#customers_state').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_postcode.length < 1){
		//$("input[name='entry_postcode']").css("border",style).focus();
		$('#Postal_Code').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(customer_telephone.length < 1){
		//$("input[name='entry_telephone']").css("border",style).focus();
		$('#entry_telephone').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(error){
		return true;
	}



//	alert('yes');
	$.ajax({
		url: "ajax_process_other_requests.php?request_type=set_address",
		data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&" + $("#addAddressForm").serialize(),
		type: "POST",
		dataType: "json",
		beforeSend: function(){
			fslocking();
			},
		success: function(jtext){
			location = '<?php echo zen_href_link(FILENAME_CHECKOUT,'','SSL');?>';
				switch(jtext.type){
					case 'update':
						addresses = jtext.addresses;
						address = addresses.data[jtext.aid];
						update_text = '<label for="address_'+ jtext.aid+'"><input type="radio" name="shipping_Address_id" class="check2_Address_xuanzhe" id="address_'+jtext.aid+'" value="'+jtext.aid+'" checked="checked" onclick="set_shipping_address('+jtext.aid+');"/><strong>'+address.entry_firstname+' '+ address.entry_lastname +'</strong> ('+ address.entry_street_address+' '+ address.entry_suburb + ', ' + address.entry_city + ', '+ address.entry_state + ', ' + address.entry_postcode +  ', ' + address.entry_country.entry_country_name +')<span class="check2_Address_Edit"> <a onclick="javascript: edit_address('+jtext.aid+');" href="javascript:void(0);">Editar</a></span></label>';
						$("label[for='address_"+jtext.aid+"']").replaceWith(update_text);
						order_totals.shipping = jtext.all_fee.current_fee;
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexzones_fee").text(parseFloat(jtext.all_fee.fedex).toFixed(2));
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexiezones_fee").text(parseFloat(jtext.all_fee.fedexie).toFixed(2));
						if(parseFloat(jtext.all_fee.dhl) > 0) $("#dhlzones_fee").text(parseFloat(jtext.all_fee.dhl).toFixed(2));
						if(parseFloat(jtext.all_fee.airmail) > 0) $("#airmailzones_fee").text(parseFloat(jtext.all_fee.airmail).toFixed(2));
						$("#emszones_fee").text(parseFloat(jtext.all_fee.ems).toFixed(2));
						if(parseFloat(jtext.all_fee.ups) > 0) $("#upszones_fee").text(parseFloat(jtext.all_fee.ups).toFixed(2));
						if(parseFloat(jtext.all_fee.tnt) > 0) $("#tntzones_fee").text(parseFloat(jtext.all_fee.tnt).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#airliftzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#seazones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)
						$("#customzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)

						$("#shipping_cost").text(parseFloat(order_totals.shipping).toFixed(2));
						$("#total_fee").text((parseFloat(order_totals.subtotal)+parseFloat(order_totals.shipping)).toFixed(2));
						break;
					case 'insert':
						addresses = jtext.addresses;
						order_totals.shipping = jtext.shipping_cost;
						$("#shipping_cost").text(jtext.shipping_cost);
						address = addresses.data[jtext.aid];
						$('.checkout_03 > ul > li > label > span').each(function(){$(this).css({"display":"none"});});
						new_address = '<li><label for="address_'+jtext.aid+'"><input type="radio" name="shipping_Address_id" class="check2_Address_xuanzhe" id="address_'+jtext.aid+'" value="15" checked="checked" onclick="set_shipping_address('+jtext.aid+');"/>&nbsp;<strong>'+address.entry_firstname+' '+ address.entry_lastname +'</strong> ('+ address.entry_street_address+' '+ address.entry_suburb + ', ' + address.entry_city + ', '+ address.entry_state + ', ' + address.entry_postcode +  ', ' + address.entry_country.entry_country_name +')<span class="check2_Address_Edit"> <a onclick="javascript: edit_address('+jtext.aid+');" href="javascript:void(0);">Editar</a></span></label></li>';
		//				alert(new_address);return false;
						$('.checkout_03 > ul').prepend(new_address);

						order_totals.shipping = jtext.all_fee.current_fee;
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexzones_fee").text(parseFloat(jtext.all_fee.fedex).toFixed(2));
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexiezones_fee").text(parseFloat(jtext.all_fee.fedexie).toFixed(2));
						if(parseFloat(jtext.all_fee.dhl) > 0) $("#dhlzones_fee").text(parseFloat(jtext.all_fee.dhl).toFixed(2));
						if(parseFloat(jtext.all_fee.airmail) > 0) $("#airmailzones_fee").text(parseFloat(jtext.all_fee.airmail).toFixed(2));
						$("#emszones_fee").text(parseFloat(jtext.all_fee.ems).toFixed(2));
						if(parseFloat(jtext.all_fee.ups) > 0) $("#upszones_fee").text(parseFloat(jtext.all_fee.ups).toFixed(2));
						if(parseFloat(jtext.all_fee.tnt) > 0) $("#tntzones_fee").text(parseFloat(jtext.all_fee.tnt).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#airliftzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#seazones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)
						$("#customzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)

						$("#shipping_cost").text(parseFloat(order_totals.shipping).toFixed(2));
						$("#total_fee").text((parseFloat(order_totals.subtotal)+parseFloat(order_totals.shipping)).toFixed(2));
						break;

				}
			},
		error: function(msg){
			//fsunlocking();
			//alert('error:' + msg);
			fslocking();
			location = '<?php echo zen_href_link(FILENAME_CHECKOUT,'','SSL');?>';
			}
	});

	Close_Popup();
});


$("#savebillingAddress").click(function(){

	var
	 entry_firstname = $("input[name='billing_firstname']").val(),
	 entry_street_addresss = $("input[name='billing_street_address']").val(),
	 entry_city = $("input[name='billing_city']").val(),
	 entry_country_id = parseInt($("select[name='billing_country_id']").val()),
	 entry_state = $("input[name='billing_state']").val(),
	 entry_postcode = $("input[name='billing_postcode']").val(),
	 customer_telephone = $("input[name='billing_telephone']").val(),
	 error=false,
	 style="2px dotted red";

	if(entry_firstname.length < 1){
		$('#billingfirstname').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_street_addresss.length < 4){
		$('#billingAddress_Line1').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_city.length < 1){
		$('#billingCity').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_country_id < 1){
		$('#billingentry_country_id').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_state.length < 1){
		$('#billingcustomers_state').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(entry_postcode.length < 1){
		$('#billingPostal_Code').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(customer_telephone.length < 1){
		$('#billingentry_telephone').siblings('.help_info').removeClass('yes').addClass('no');
		error = true;
	}

	if(error){
		return true;
	}

	$.ajax({
		url: "ajax_process_other_requests.php?request_type=set_billing_address",
		data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&" + $("#billingAddressForm").serialize(),
		type: "POST",
		dataType: "json",
		beforeSend: function(){
			fslocking();
			},
		success: function(jtext){
			location = '<?php echo zen_href_link(FILENAME_CHECKOUT,'','SSL');?>';
				switch(jtext.type){
					case 'update':
						addresses = jtext.billing_addresses;
						address = addresses.data[jtext.aid];
						update_text = '<label for="address_'+ jtext.aid+'"><input type="radio" name="shipping_Address_id" class="check2_Address_xuanzhe" id="address_'+jtext.aid+'" value="'+jtext.aid+'" checked="checked" onclick="set_shipping_address('+jtext.aid+');"/><strong>'+address.entry_firstname+' '+ address.entry_lastname +'</strong> ('+ address.entry_street_address+' '+ address.entry_suburb + ', ' + address.entry_city + ', '+ address.entry_state + ', ' + address.entry_postcode +  ', ' + address.entry_country.entry_country_name +')<span class="check2_Address_Edit"> <a onclick="javascript: edit_address('+jtext.aid+');" href="javascript:void(0);">Editar</a></span></label>';
						$("label[for='address_"+jtext.aid+"']").replaceWith(update_text);
						order_totals.shipping = jtext.all_fee.current_fee;
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexzones_fee").text(parseFloat(jtext.all_fee.fedex).toFixed(2));
						if(parseFloat(jtext.all_fee.dhl) > 0) $("#dhlzones_fee").text(parseFloat(jtext.all_fee.dhl).toFixed(2));
						if(parseFloat(jtext.all_fee.airmail) > 0) $("#airmailzones_fee").text(parseFloat(jtext.all_fee.airmail).toFixed(2));
						$("#emszones_fee").text(parseFloat(jtext.all_fee.ems).toFixed(2));
						if(parseFloat(jtext.all_fee.ups) > 0) $("#upszones_fee").text(parseFloat(jtext.all_fee.ups).toFixed(2));
						if(parseFloat(jtext.all_fee.tnt) > 0) $("#tntzones_fee").text(parseFloat(jtext.all_fee.tnt).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#airliftzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#seazones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)
						$("#customzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)

						$("#shipping_cost").text(parseFloat(order_totals.shipping).toFixed(2));
						$("#total_fee").text((parseFloat(order_totals.subtotal)+parseFloat(order_totals.shipping)).toFixed(2));
						break;
					case 'insert':
						addresses = jtext.billing_addresses;
						order_totals.shipping = jtext.shipping_cost;
						$("#shipping_cost").text(jtext.shipping_cost);
						address = addresses.data[jtext.aid];
						$('.checkout_03 > ul > li > label > span').each(function(){$(this).css({"display":"none"});});
						new_address = '<li><label for="address_'+jtext.aid+'"><input type="radio" name="shipping_Address_id" class="check2_Address_xuanzhe" id="address_'+jtext.aid+'" value="15" checked="checked" onclick="set_shipping_address('+jtext.aid+');"/>&nbsp;<strong>'+address.entry_firstname+' '+ address.entry_lastname +'</strong> ('+ address.entry_street_address+' '+ address.entry_suburb + ', ' + address.entry_city + ', '+ address.entry_state + ', ' + address.entry_postcode +  ', ' + address.entry_country.entry_country_name +')<span class="check2_Address_Edit"> <a onclick="javascript: edit_address('+jtext.aid+');" href="javascript:void(0);">Editar</a></span></label></li>';
		//				alert(new_address);return false;
						$('.checkout_03 > ul').prepend(new_address);

						order_totals.shipping = jtext.all_fee.current_fee;
						if(parseFloat(jtext.all_fee.fedex) > 0) $("#fedexzones_fee").text(parseFloat(jtext.all_fee.fedex).toFixed(2));
						if(parseFloat(jtext.all_fee.dhl) > 0) $("#dhlzones_fee").text(parseFloat(jtext.all_fee.dhl).toFixed(2));
						if(parseFloat(jtext.all_fee.airmail) > 0) $("#airmailzones_fee").text(parseFloat(jtext.all_fee.airmail).toFixed(2));
						$("#emszones_fee").text(parseFloat(jtext.all_fee.ems).toFixed(2));
						if(parseFloat(jtext.all_fee.ups) > 0) $("#upszones_fee").text(parseFloat(jtext.all_fee.ups).toFixed(2));
						if(parseFloat(jtext.all_fee.tnt) > 0) $("#tntzones_fee").text(parseFloat(jtext.all_fee.tnt).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#airliftzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0) $("#seazones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)
						$("#customzones_fee").text(parseFloat(jtext.all_fee.free).toFixed(2));
						if(parseFloat(jtext.all_fee.free) > 0)

						$("#shipping_cost").text(parseFloat(order_totals.shipping).toFixed(2));
						$("#total_fee").text((parseFloat(order_totals.subtotal)+parseFloat(order_totals.shipping)).toFixed(2));
						break;

				}
			},
		error: function(msg){
			fsunlocking();
			//alert('error:' + msg);

			location = '<?php echo zen_href_link(FILENAME_CHECKOUT,'','SSL');?>';
			}
	});

	Close_billingPopup();
});

$("#cancelbillingAddress").click(function(){
	$("#eidt_select_billing").hide();$("#show_all_billing").show();
});

$("#paymentMethod_select").change(function(){
	//fslocking();
	/*
	var payment_method =  $("#paymentMethod_select").val();
	if(-1 != payment_method){
		$.ajax({
			url: "ajax_process_other_requests.php?request_type=setPayment",
			type:"POST",
			data:"&securityToken=<?php echo $_SESSION['securityToken'];?>&payment=" + payment_method,
			beforeSend: function(){
				//alert('send payment method ');
				},
			success: function(msg){

				}
			});
	}
		if('paypal' == payment_method)$("#order_submit").text('Proceed to Paypal');
		else $("#order_submit").text('Submit Order');
		$('.Payment_select').siblings().hide();
		$("#" + payment_method).show('normal');*/
		//fsunlocking();
});
$("#document").ready(function(){
////*************select products HSBC
	var only_wt = '<?php echo $only_wt?>';
	if(only_wt == 'yes'){
		default_payment = 'hsbc';
	}else{
		var default_payment = "<?php echo $default_payment;?>";
	}
	if(!default_payment){
		default_payment = 'paypal';
	}
	//$("#paypal_payment_method").attr('checked','true');
	payment_method_select(default_payment);


});

function payment_method_select(value){
	var payment_method = value;

		$.ajax({
			url: "ajax_process_other_requests.php?request_type=setPayment",
			type:"POST",
			data:"&securityToken=<?php echo $_SESSION['securityToken'];?>&payment=" + payment_method,
			beforeSend: function(){
				//alert('send payment method ');
				},
			success: function(msg){
				}
			});
		if('paypal' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_PAYPAL;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_PAYPAL;?><i class="security_icon">');
		}else if('bpay' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_BPAY;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_BPAY;?><i class="security_icon">');
		}else if('eNETS' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_ENETS;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_ENETS;?><i class="security_icon">');
		}else if('iDEAL' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_IDEAL;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_IDEAL;?><i class="security_icon">');
		}else if('SOFORT' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_SOFORT;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_SOFORT;?><i class="security_icon">');
		}else if('globalcollect' == payment_method){
			$("#order_submit").html('<?php echo FIBER_CHECK_CONFIRM;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_CONFIRM;?><i class="security_icon">');
		}else{
			$("#order_submit").html('<?php echo FIBER_CHECK_SUBMIT;?><i class="security_icon">');
			$("#order_submit_a").html('<?php echo FIBER_CHECK_SUBMIT;?><i class="security_icon">');
			}
		$('.Payment_select').siblings().hide();
		$("#" + payment_method).show();
		//fsunlocking();

		$("#paypal_class").removeClass('checkbg');
		$("#westernunion_class").removeClass('checkbg');
		$("#hsbc_class").removeClass('checkbg');
		$("#globalcollect_class").removeClass('checkbg');
		$("#bpay_class").removeClass('checkbg');
		$("#eNETS_class").removeClass('checkbg');
		$("#iDEAL_class").removeClass('checkbg');
		$("#SOFORT_class").removeClass('checkbg');
		$("#"+value+"_class").addClass('checkbg');

}

/* shipping methods change */
/*
function changeShipping(shipping_method,shipping_code){
	//fslocking();
	$.ajax({
		url: "ajax_process_other_requests.php?request_type=change_shipping",
		type: "POST",
		data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&shipping=" + shipping_method+"&shipping_code=" + shipping_code,
		dataType: "json",
		beforeSend: function(){
			//alert('send shipping method ');
			},
		success: function(data){
			$("#shipping_cost").text(parseFloat(data.cost).toFixed(2));
			$("#total_fee").text((parseFloat(order_totals.subtotal) + parseFloat(data.cost)).toFixed(2));
			order_totals.shipping = data.cost;
			}
		});
	//fsunlocking();
	if(shipping_method == 'customzones'){
		apps();
	}

	$("#tr_fedexzones").removeClass("bghover");
	$("#tr_fedexiezones").removeClass("bghover");
	$("#tr_dhlzones").removeClass("bghover");
	$("#tr_emszones").removeClass("bghover");
	$("#tr_airmailzones").removeClass("bghover");
	$("#tr_upszones").removeClass("bghover");
	$("#tr_tntzones").removeClass("bghover");
	$("#tr_airliftzones").removeClass("bghover");
	$("#tr_seazones").removeClass("bghover");
	$("#tr_customzones").removeClass("bghover");
	$("#tr_"+shipping_method).addClass("bghover");
}
*/
function changeShipping(shipping_method){
	//fslocking();
	$.ajax({
		url: "ajax_process_other_requests.php?request_type=change_shipping",
		type: "POST",
		data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&shipping=" + shipping_method,
		dataType: "json",
		beforeSend: function(){
			//alert('send shipping method ');
			},
		success: function(data){
			$("#shipping_cost").text(parseFloat(data.cost).toFixed(2));
			$("#total_fee").text((parseFloat(order_totals.subtotal) + parseFloat(data.cost)).toFixed(2));
			order_totals.shipping = data.cost;
			}
		});
	//fsunlocking();
	// if(shipping_method == 'customzones'){
	// 	apps();
	// }

	$("#tr_fedexzones").removeClass("bghover");
	$("#tr_fedexiezones").removeClass("bghover");
	$("#tr_dhlzones").removeClass("bghover");
	$("#tr_emszones").removeClass("bghover");
	$("#tr_airmailzones").removeClass("bghover");
	$("#tr_upszones").removeClass("bghover");
	$("#tr_tntzones").removeClass("bghover");
	$("#tr_airliftzones").removeClass("bghover");
	$("#tr_seazones").removeClass("bghover");
	$("#tr_customzones").removeClass("bghover");
	$("#tr_"+shipping_method).addClass("bghover");
}

function changeShippings(shipping_method){

	$.ajax({
		url: "ajax_process_other_requests.php?request_type=change_shipping",
		type: "POST",
		data: "&securityToken=<?php echo $_SESSION['securityToken'];?>&shipping=" + shipping_method,
		dataType: "json",
		beforeSend: function(){
			//alert('send shipping method ');
			},
		success: function(data){
			$("#shipping_cost").text(parseFloat(data.cost).toFixed(2));
			$("#total_fee").text((parseFloat(order_totals.subtotal) + parseFloat(data.cost)).toFixed(2));
			order_totals.shipping = data.cost;
			}
		});

	$("#tr_fedexzones").removeClass("bghover");
	$("#tr_fedexiezones").removeClass("bghover");
	$("#tr_dhlzones").removeClass("bghover");
	$("#tr_emszones").removeClass("bghover");
	$("#tr_airmailzones").removeClass("bghover");
	$("#tr_upszones").removeClass("bghover");
	$("#tr_tntzones").removeClass("bghover");
	$("#tr_airliftzones").removeClass("bghover");
	$("#tr_seazones").removeClass("bghover");
	$("#tr_customzones").removeClass("bghover");
	$("#tr_"+shipping_method).addClass("bghover");


}



$("#paymentMethod_select").click(function(){
	//$("#paymentMethod_select").css('border','1px solid #000');
});
$("#paymentMethod_select").change(function(){
	//$("#paymentMethod_select").css('border','1px solid #000');
	if($("#paymentMethod_select").val() != -1){
		$("#paymentMethod_select").css('border','1px solid #CCCCCC');
	}
});

$(".order_payment_ccc").click(function(){
//	alert('no' + $("input[name='shipping_method']").length);return false;
	$(this).attr('disabled','disabled');
    

    if($("#billing_address").attr("value")==""){
		alert('<?php echo FIBER_CHECK_PLEASE1;?>');
		$('html,body').animate({scrollTop:0},{duration:'slow'});
		return false;
	}


	if($("#ship_address").attr("value")==""){
		alert('<?php echo FIBER_CHECK_PLEASE2;?>');
		$('html,body').animate({scrollTop:0},{duration:'slow'});
		return false;
	}


	if($("#ship_entry_telephone").attr("value")==0){
		alert('<?php echo FIBER_CHECK_PLEASE3;?>');
		$('html,body').animate({scrollTop:0},{duration:'slow'});
		return false;
	}
						
					
	if($("#po_box").attr("value")==1){
		alert('<?php echo FIBER_CHECK_BOX;?>');
		$('html,body').animate({scrollTop:0},{duration:'slow'});
		return false;
	}



	if($("#shipping_method").val() == 'customzones'){
		if(!$("#custom_text_1").html()){
			alert("<?php echo FIBER_CHECK_PLEASE4;?>");return false;
		}
	}

	var check_shipping = false,shipping_method = '';
	var check_shipping_address = false,shipping_address = '';
	var customer_po = $("input[name='checkout_invoice_input']").val();
	var customer_remarks=$('#order_remarks_input').val();
	var products_custom=$("input[name='products_custom']").val();


	$("input[name='shipping_choose']").each(function(i,n){

		if($(this).is(":checked")) check_shipping = true;
	});

	if(!check_shipping){
		$('html,body').animate({scrollTop:0},{duration:'slow'});
		alert('<?php echo FIBER_CHECK_PLEASE5;?>');return false;
	}
/*

    $shipping_method = $("#shipping_method").val();
	if(!$shipping_method){
		alert('Please choose your payment method !');return false;
	}
*/
	if(-1 == $("#paymentMethod_select").val()){
		$("#paymentMethod_select").css('border','2px solid red');
		alert('<?php echo FIBER_CHECK_PLEASE6?>');return false;
	}

	fslocking();
		var payment_method_name = $("input[name='payment_method_name']:checked").val();
		var client_type = "<?php echo $get_client_type?>";
	//if('paypal' == $("#paymentMethod_select").val()){
	if('paypal' == payment_method_name){
	$.ajax({
		   type: "POST",
		   url: "ajax_process_other_requests.php?request_type=create_order",
		   data: "&customer_po="+customer_po+"&securityToken=<?php echo $_SESSION['securityToken'];?>&customer_remarks="+customer_remarks+"&products_custom="+products_custom+"&client_type="+client_type,
		   dataType: "json",
		   success: function(data){
					if(data.error == 'err'){
							alert('<?php echo FIBER_CHECK_SOME?>');
							location.href="index.php?main_page=checkout";return false;
					}
					var paramArray = data.params.split('::');
					var newParamArray = new Array(100);
					for(var i = 0,j=0, n = paramArray.length; i < n; i++){
						if(-1 != paramArray[i].indexOf('--')){
							var tempArray = paramArray[i].split('--');
							newParamArray[j++] = tempArray[0];
							newParamArray[j++] = tempArray[1];
						}
					}
					var submit_string = '';
					for(var i = 0, n = newParamArray.length; i < n; i+=2){
						if(newParamArray[i]){
							submit_string += '<input type="hidden" name="'+ newParamArray[i] + '" value="' + newParamArray[i+1] + '" />';
						}
					}
					//send order mail
					 $.ajax({
						   async: false,
				 		   type: "POST",
				 		   url: "ajax_process_other_requests.php?request_type=send_email",
				 		   data: "&orders_id="+data.o_id+"&securityToken=<?php echo $_SESSION['securityToken'];?>",
					 	   dataType: "text"
				        });
				    //go to paypal
			        $('<form id="paypal_submit_form" method="POST" style="display:none">'+submit_string+'</form>').attr({action:data.url}).appendTo('body').submit();
		   },
		  error: function(msg){
			 	 alert('<?php echo FIBER_CHECK_SOME?>');
			  }
		});
	}else if('globalcollect' == payment_method_name){
		$.ajax({
		   type: "POST",
		   url: "ajax_process_other_requests.php?request_type=create_order",
		   data: "&customer_po="+customer_po+"&securityToken=<?php echo $_SESSION['securityToken'];?>&customer_remarks="+customer_remarks+"&products_custom="+products_custom+"&client_type="+client_type,
		   dataType: "html",
		   success: function(data){
			   //send order mail
					 $.ajax({
						   async: false,
				 		   type: "POST",
				 		   url: "ajax_process_other_requests.php?request_type=send_email&type=gc",
				 		   data: "&orders_id="+data+"&securityToken=<?php echo $_SESSION['securityToken'];?>",
					 	   dataType: "text"
				        });
			   url = "<?php echo zen_href_link(FILENAME_CHECKOUT_GLOBALCOLLECT_BILLING,'','SSL');?>&req_qreoid="+data;
			   window.location.href=url;
		   }
		});
	}else if('bpay' == payment_method_name || 'eNETS' == payment_method_name || 'iDEAL' == payment_method_name || 'SOFORT' == payment_method_name){
		$.ajax({
		   type: "POST",
		   url: "ajax_process_other_requests.php?request_type=create_order",
		   data: "&customer_po="+customer_po+"&securityToken=<?php echo $_SESSION['securityToken'];?>&customer_remarks="+customer_remarks+"&products_custom="+products_custom+"&client_type="+client_type,
		   dataType: "json",
		   success: function(data){
			   //send order mail
					 $.ajax({
						   async: false,
				 		   type: "POST",
				 		   url: "ajax_process_other_requests.php?request_type=send_email&type="+payment_method_name,
				 		   data: "&orders_id="+data.o_id+"&securityToken=<?php echo $_SESSION['securityToken'];?>",
					 	   dataType: "text"
				        });
			   window.location.href=data.params;
		   }
		});
		

	}else{
		$.ajax({
			   type: "POST",
			   url: "ajax_process_other_requests.php?request_type=save_customer_po",
			   data: "&customer_po="+customer_po+"&securityToken=<?php echo $_SESSION['securityToken'];?>&customer_remarks="+customer_remarks+"&products_custom="+products_custom,
			   dataType: "html",
			   success: function(data){
				window.location.href="<?php echo zen_href_link(FILENAME_CHECKOUT_PROCESS,'','NONSSL');?>";
			   }
			});
		}
});

/* total fee */
//var order_fee = {
//		"cart_total":"<?php //echo $_SESSION['cart']->show_total();?>",
//		"shipping_charge":" ",
//		"shipping_insurance":"1.99"
//};
$("#processing_shipping_time").toggle(function(){$("#fiberstore_shipping_introduction").slideDown();},function(){$("#fiberstore_shipping_introduction").slideUp();});


/*change country and change telephone*/
$("#entry_country_id").change(function(){
	c_id = $(this).val();
	if(c_id > 0){
		$('#tel_prefix').text(country_to_telephone[c_id]);
	}
});
function fslocking() {
	if($('bigbox').siblings(":contains('#overlayer')").length) {
		$('bigbox').siblings('#overlayer').show();
	}else $('#overlayer').prependTo('html,body').show();

	if($('#window').is(':visible')) $('#window').hide();
	$('#fs_loading').show();
}
function fsbillinglocking() {
	if($('bigbox').siblings(":contains('#overlayer')").length) {
		$('bigbox').siblings('#overlayer').show();
	}else $('#billingoverlayer').prependTo('html,body').show();

	if($('#window').is(':visible')) $('#window').hide();
	$('#billingfs_loading').show();
}

function fsunlocking() {$('bigbox').siblings('#overlayer').hide();
$('#fs_loading').hide();}
function Show_Popup(is_shipping) {
	if(is_shipping){
		//$('html,body').animate({scrollTop:$(".checkout2_box").children().find(".shopcart_summary_bt").offset().top},{duration:'slow'});
// 		$('html,body').animate({scrollTop:$(".check2_Address").children("div:first").offset().top},{duration:'slow'});
	}
	//var left=((screen.width-$("#window").width())/2+document.documentElement.scrollLeft)+'px';
	//var left = ((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px';
	//var top=((screen.height-$("#window").height())/2+$('html,body').scrollTop())+'px';
	//$("#popup").css({"background":"#ccc","position":"fixed"});
	$("#popup").css({"background-color":"#000","position":"fixed","width":"100%","height":"100%","filter":"alpha(opacity=30);","opacity":"0.3","z-index":"999"});
	$("body").prepend($("#popup"));
	if(is_shipping)
		//$("#window").css({"display":"block","left":(((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px'),"top":$(".checkout2_box").children().find(".shopcart_summary_bt").offset().top+25});
			$("#window").css({"display":"block","position":"absolute","width":"600px","background":"#fff","box-shadow":"0 0 16px #000000","border-radius":"6px","left":"50%","top":"50%","margin-left":"-310px","margin-top":"-200px","z-index":"9999",});<!--"left":(((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px'),"top":$(".check2_Address").children("div:first").offset().top+25-->
	else{
		var left = ((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px';
		var top=((screen.height-$("#window").height())/2+$('html,body').scrollTop())+'px';
		 $("#window").css({"display":"block","left":left,"top":top});
	}
	$('#popup,#window').show();
	}

function Close_Popup() {$('#popup,#window').hide();}

function Show_billingPopup(is_shipping) {
	$("#billingpopup").css({"background-color":"#000","position":"fixed","width":"100%","height":"100%","filter":"alpha(opacity=30);","opacity":"0.3","z-index":"999"});
	$("body").prepend($("#billingpopup"));
	if(is_shipping)
		$("#billingwindow").css({"display":"block","position":"absolute","width":"600px","background":"#fff","box-shadow":"0 0 16px #000000","border-radius":"6px","left":"50%","top":"50%","margin-left":"-310px","margin-top":"-200px","z-index":"9999",});<!--"left":(((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px'),"top":$(".check2_Address").children("div:first").offset().top+25-->
	else{
		var left = ((screen.width-$("#billingwindow").width())/2+$('html,body').scrollLeft())+'px';
		var top=((screen.height-$("#billingwindow").height())/2+$('html,body').scrollTop())+'px';
		 $("#billingwindow").css({"display":"block","left":left,"top":top});
	}
	$('#billingpopup,#billingwindow').show();
	}
function Close_billingPopup() {$('#billingpopup,#billingwindow').hide();}

function show_taxes() {
	$("#taxes_popup").css({"background-color":"#000","position":"fixed","width":"100%","height":"100%","filter":"alpha(opacity=30);","opacity":"0.3","z-index":"999"});
	$("body").prepend($("#taxes_popup"));
	//$("#taxes_window").css({"display":"block","position":"fixed","width":"600px","box-shadow": "rgb(0, 0, 0) 0px 0px 16px","border-radius": "6px", "left": "50%", "top": "50%", "margin-left": "-315px","padding": "0 30px 30px 30px", "margin-top": "-150px", "z-index": "9999", "background": "rgb(255, 255, 255)",});
	<!--"left":(((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px'),"top":$(".check2_Address").children("div:first").offset().top+25-->

	$('#taxes_popup,#taxes_window').show();
	}
function close_taxes() {$('#taxes_popup,#taxes_window').hide();}
</script>

<!-- BEGIN: Google Trusted Stores -->
<script type="text/javascript">
  var gts = gts || [];

  gts.push(["id", "229574"]);
  gts.push(["badge_position", "BOTTOM_RIGHT"]);
  gts.push(["locale", "en_US"]);
  gts.push(["google_base_offer_id", "<?php echo (isset($_GET['products_id']) && $_GET['products_id']) ? zen_get_products_sku_of_google($_GET['products_id']) : '';?>"]);
  gts.push(["google_base_subaccount_id", "9038559"]);

  (function() {
    var gts = document.createElement("script");
    gts.type = "text/javascript";
    gts.async = true;
    gts.src = "https://www.googlecommerce.com/trustedstores/api/js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(gts, s);
  })();
  $('.checkout_invoice_input').focus(function(){
  	$(this).siblings('.checkout_invoice_prompt').hide();
  })
  $('.checkout_invoice_input').blur(function(){
  	if($(this).val()==""){
  		$(this).siblings('.checkout_invoice_prompt').show();
  	}
  })
  $('.checkout_invoice_prompt').click(function(){
  	$(this).hide();
  	$(this).siblings().focus();
  })
  $('#order_remarks_input').focus(function(){
  	$(this).siblings('.checkout_invoice_prompt').hide();
  }) 
  $('#order_remarks_input').blur(function(){
  	if($(this).val()==""){
  		$(this).siblings('.checkout_invoice_prompt').show();
  	}
  })
  function show_shipping() {
	$("#taxes_popup").css({"background-color":"#000","position":"fixed","width":"100%","height":"100%","filter":"alpha(opacity=30);","opacity":"0.3","z-index":"999"});
	$("body").prepend($("#taxes_popup"));
	//$("#taxes_window").css({"display":"block","position":"fixed","width":"600px","box-shadow": "rgb(0, 0, 0) 0px 0px 16px","border-radius": "6px", "left": "50%", "top": "50%", "margin-left": "-315px","padding": "0 30px 30px 30px", "margin-top": "-150px", "z-index": "9999", "background": "rgb(255, 255, 255)",});
	<!--"left":(((screen.width-$("#window").width())/2+$('html,body').scrollLeft())+'px'),"top":$(".check2_Address").children("div:first").offset().top+25-->

	$('#taxes_popup,#basic-modal-content').show();
	}
  $('#shipping_method').change(function(){
  	console.log($(this).val())
		if($(this).val()== 'customzones'){
			show_shipping();
		}
	});
</script>
<!-- END: Google Trusted Stores -->

