<?php

// the following IF statement can be duplicated/modified as needed to set additional flags
  if (in_array($_GET['main_page'],array(FILENAME_SUBMIT_REVIEW))){
	$flag_disable_left = true;
  }
  if (in_array($current_page_base,explode(",",'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces')) ) {
    $flag_disable_right = true;
  }


  $header_template = 'tpl_header.php';
  $footer_template = 'tpl_footer.php';
  $body_template   = 'tpl_body.php';
  //$right_column_file = 'column_right.php';
  $body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);

  $check_body = "tpl_check_body.php";
  $checkout_header = "tpl_checkout_header.php";
  $checkout_body = "tpl_checkout_body.php";
  $checkout_footer = "tpl_checkout_footer.php";
  $index_body = "tpl_index_check_body.php";

 if (in_array($_GET['main_page'], array('my_cart','print_get_a_quote','shopping_products','products_payment','new_checkout','checkout','checkout_guest','password_forgotten','address_book_edit','address_book_guest','checkout_quick','checkout_paypal_confirm','checkout_wiretransfer_complete','nationality',FILENAME_CHECKOUT_WESTERUNION_COMPLETE,FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE,FILENAME_CHECKOUT_ECHECK_COMPLETE))){
     /*checkout*/
     $page_parts = array($checkout_header, $checkout_body, $checkout_footer);
 }elseif(!$_GET['main_page'] ||in_array($_GET['main_page'], array('index','new_domain','support','tutorial','about_us','bend_insensitive'))){
     $page_parts = array($header_template,$index_body,$footer_template);
 }elseif(in_array($_GET['main_page'],array('solution_support','live_chat_service_mail','file_demonstration_po'))){ //服务类不用 header footer  solution_support SQ20191112009
     $page_parts = array($index_body);
 }
 else{
     /*others*/
     $page_parts = array($header_template,$index_body,$footer_template);
    if(isset($_GET['modules']) && $_GET['modules'] == 'phone'){
      $page_parts = array($index_body);
    }
 }

  /*
  if($this_is_home_page || in_array($_GET['main_page'], array(FILENAME_LIVE_CHAT_SERVICE,FILENAME_LIVE_CHAT_SERVICE_MAIL,FILENAME_LIVE_CHAT_SERVICE_PHONE,'contact_us','partner_submit')) ){
   $phone_js = 'onload="_googWcmGet("number", "1 718 577 1006")"';
   $span ='<span class="number" style="display:none;">1 718 577 1006</span>';
  }
  */
?>

<?php if (in_array($_GET['main_page'], array('print_checkout_success',FILENAME_PRINT_ORDER,'password_forgotten','print_get_a_quote','third_party_bind','third_party_link','free_shipping_box','redirect_process','cumlums_table','cumlums_table','login_beta','regist_beta',FILENAME_LOGIN,FILENAME_LOGIN_GUEST,'partner_submit','my_cart','shopping_products','products_payment',FILENAME_CHECKOUT,'checkout_paypal_confirm','checkout_guest','checkout_cost','checkout_quick',FILENAME_CHECKOUT_SUCCESS,FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE,FILENAME_CHECKOUT_WESTERUNION_COMPLETE,FILENAME_REGIST,'print_service_order',FILENAME_PASSWORD_FORGOTTEN,FILENAME_CHECKOUT_GLOBALCOLLECT_BILLING,FILENAME_CHECKOUT_PAYMENT_AGAINST,'password_update','password_submit_success','print_main_order','password_update_success','address_book_edit','address_book_guest','service_feedback','email_share',FILENAME_PRINT_SHOPPING_LIST,'partner_update','print_shipping_label','regist_email_check',"credit_card_process",FILENAME_CHECKOUT_ECHECK_COMPLETE,"checkout_new", 'quotes_pdf', FILENAME_CHECKOUT_SUCCESS_PURCHASE))){
	?>
	<body id="<?php echo $body_id . 'Body'; ?>" <?php echo $phone_js;?>>
	<?php echo $span;?>

<?php /** Google Tag Manager **/ ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBGKN3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
<?php  /***End Google Tag Manager **/ ?>
<?php
require $body_code; ?>

</body>
<?php }else{
	if(is_array($wholesale_products) && sizeof($wholesale_products)){
	
	 if(!in_array($_GET['products_id'],$wholesale_products)){
	     $products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity'])));
	 }else{
		 $products_price = $currencies->value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity'])));
	 }
		
	}else{
	$products_price = $currencies->new_value(get_customers_products_level_final_price(fs_get_product_wholesale_price_of_qty((int)$_GET['products_id'],(int)$_GET['cart_quantity'])));
	}



?>
<body <?php echo $phone_js;?>  ondragstart="return false">
<?php echo $span;?>
<?php  /** Google Tag Manager **/ ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBGKN3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<?php  /**  End Google Tag Manager  **/ ?>
<?php
  foreach ($page_parts as $part)
  	require($template->get_template_dir($part,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$part);?>

</body>
<?php }?>
