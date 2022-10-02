<?php
/**
 * @todo checkout success page for hsbc
 */?>

<div class="m_shopping_process_top ">
<div class="m_shopping_process_fixed ">
<!-- 电汇下单-->
<div class="m_top">
  <span class="m_live"><a href="<?php echo $code;?>/customer_service.html"><span class="icon iconfont">&#xf137;</span></a></span>
  <span class="m_logo">
    <a href="<?php echo zen_href_link(FILENAME_DEFAULT,'','NONSSL')?>"><img src="../images/logo_fs_01.gif" border="0" ></a> 
  </span>
</div>


<div class="login_new_01"><a href="<?php echo zen_href_link(FILENAME_DEFAULT,'','NONSSL')?>"><img src="../images/logo_fs_01.gif" border="0" class="aaa m_none"></a>
  <div class="checkout_breadcrumb">
    <ul>
      <li><?php echo FS_SUCCESS_CART;?></li>
      <li><?php echo FS_SUCCESS_CHECKOUT;?></li>
      <li class="present"><?php echo FS_SUCCESS_SUCCESS;?></li>
    </ul>
  </div>
  <div class="checkout_live">
    <span><a href="<?php echo $code;?>/customer_service.html"><em></em><?php echo FS_SUCCESS_LIVE;?></a></span>
  </div>
</div>

</div>
</div>

<div class="box">
<div class="content ">
  <div class="pay_01"><?php echo FS_SUCCESS_THANK;?><br />
    <span class="title_small"><?php echo FS_SUCCESS_YOUR_NEXT;?></span>
  </div>
  <div class="order_summary_con">
  <div class="layout_title"><?php echo FS_SUCCESS_SUMMARY;?></div>
  <div class=" order_summary_info">
       <ul>
            <li><?php echo FS_SUCCESS_NUMBER;?>: <span class="red"><?php echo $order_summary['orders_number'];?></span></li>
            <li><?php echo FS_SUCCESS_TOTAL;?>: <span class="red"><?php echo $order_summary['orders_total'];?></span></li>
            <li><?php echo FS_SUCCESS_ITEM;?>: <?php echo $order_summary['items'];?></li>
            <li><?php echo FS_SUCCESS_METHOD;?>: <?php echo strtoupper(substr($order_summary['shipping_method'],0,strpos($order_summary['shipping_method'], '_')));?></li>
            <li><?php echo FS_SUCCESS_DATE;?>: <?php echo date('F j,Y',strtotime($order->info['date_purchased']));?></li>
            <li><?php echo FS_SUCCESS_PAYMENT;?>: <?php echo FS_SUCCESS_WIRE;?></li>
      </ul>
  </div>
  </div>
  
  <div class="print_font">
<a style="cursor: pointer" class="print" onclick="window.open('<?php echo zen_href_link(FILENAME_PRINT_ORDER,'&o_id='. $orders_id .'&orders_id='.zen_encrypt_password($orders_id));?>')" type="submit" href="javascript:;" value="FIBERSTORE_PRINT_ORDER"><?php echo FS_SUCCESS_ORDER;?></a> 
</div>
  <div class="layout_title"><?php echo FS_SUCCESS_DETAIL;?></div>
    <div class="layout_son">
         <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                  <tbody>
                    <tr>
                      <th width="170" valign="top"><?php echo FS_SUCCESS_BANK_NAME;?>:</th>
                      <td valign="top"><b><?php echo FS_SUCCESS_HSBC;?></b></td>
                    </tr>
                    <tr>
                      <th valign="top"><?php echo FS_SUCCESS_AC_NAME;?>: </th>
                      <td valign="top"><b><?php echo FS_SUCCESS_CO;?></b></td>
                    </tr>
                    <tr>
                      <th valign="top"><?php echo FS_SUCCESS_AC_NO;?>:</th>
                      <td valign="top"><b><?php echo FS_SUCCESS_TEL;?></b></td>
                    </tr>
                    <tr>
                      <th valign="top"><?php echo FS_SUCCESS_SWIFT;?>:</th>
                      <td valign="top"><b><?php echo FS_SUCCESS_HK;?></b></td>
                    </tr>
                    <tr>
                      <th valign="top"><?php echo FS_SUCCESS_BANK_ADRESS;?>:</th>
                      <td valign="top"><b><?php echo FS_SUCCESS_ROAD;?></b></td>
                    </tr>
                   <tr>
                      <th valign="top"><?php echo FS_SUCCESS_OUR;?>:</th>
                      <td valign="top"><?php echo FS_SUCCESS_NO;?></td>
                    </tr>
                    
                  </tbody>
                </table>
   </div>
   <div class="pay_05_padding">
     <span><?php echo FS_SUCCESS_YOU_CAN;?>:</span>
     <ul>
            <li><a href="<?php echo zen_href_link('my_dashboard');?>"><?php echo FS_SUCCESS_VIEW;?></a></li>
       <li><a href="<?php echo zen_href_link('edit_my_account');?>"><?php echo FS_SUCCESS_CHANGE;?></a></li>
       <li><a href="<?php echo zen_href_link('manage_addresses');?>"><?php echo FS_SUCCESS_SHIPPING;?></a></li>
       <!--  <li><a href="http://cn.fs.com:8000">Newsletter</a></li>  -->
     </ul>
    </div>
	 <div class="shopping_cart_05"><a href="https://www.fs.com<?php echo $code;?>" class="button_11 bbb"><?php echo FS_SUCCESS_BACK;?></a></div>
</div>
</div>



<?php  require($template->get_template_dir('tpl_checkout_new_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_checkout_new_footer.php');?>

<!-- 电汇结束-->

<img src="https://shareasale.com/sale.cfm?amount=<?php echo round($subtotal->fields['value'], 2);  ?>&tracking=<?php echo $zv_orders_id; ?>&transtype=sale&merchantID=47577" width="1" height="1">



<!-- START Google Trusted Stores Order -->
<?php 

$country_id=zen_get_customer_country_of_id($_SESSION['customer_id']);
require DIR_WS_CLASSES . 'order_total.php';
  $order_total = new order_total();
  $order_total_lists = $order_total->process();
  $order_total->collect_posts();

  $order_total->pre_confirmation_check();
//$order_id = zen_get_customer_order_of_id($_SESSION['customer_id']);
//$order_id = $orders_id;

?>
