<link href="includes/templates/fiberstore/css/shipping_delivery_local.css?v=91" rel="stylesheet" type="text/css">
<script>
//滚动后导航固定
$(function(){
	$(window).scroll(function(){
          height = $(window).scrollTop();
   	  	  if(height > 170){
   	  	  	$('.page_nav').fadeIn();
   	  	  }else{
   	  	  	$('.page_nav').stop(true).hide();
   	  	  };

});
});
</script>

    <div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo EU_SHIPPING_1;?></a> </div>
        <div class="short_title"><a href="payment_methods.html"><?php echo EU_SHIPPING_2;?></a><a href="net_30.html"><?php echo EU_SHIPPING_3;?></a><a href="#" class="title_selected"><?php echo EU_SHIPPING_4;?></a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con shipping_banner"></div>
      <div class="shipping_banner_text"><span><?php echo EU_SHIPPING_4;?></span><?php echo EU_SHIPPING_5;?></div>
    </div>
    <div class="shipping_domestic">
      <div class="shipping_title"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_location_icon.png"/></div>
      <p><?php echo EU_SHIPPING_6;?></p>
    </div>
    <div class="shipping_global">
      <div class="shipping_global_bg"></div>
      <div class="shipping_title"><?php echo EU_SHIPPING_7;?></div>
      <div class="shipping_global_pic"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/EU_map.png"/></div>
      <div class="shipping_global_text">
        <p><?php echo EU_SHIPPING_8;?><br />
          <?php echo EU_SHIPPING_9;?><br />
          <?php echo EU_SHIPPING_10;?><br />
          <?php echo EU_SHIPPING_11;?></p>
        <p> <?php echo EU_SHIPPING_12;?></p>
        <hr />
        <p><?php echo EU_SHIPPING_13;?><br />
          <?php echo EU_SHIPPING_14;?><br />
          <?php echo EU_SHIPPING_15;?> </p>
        <p><?php echo EU_SHIPPING_16;?></p>
      </div>
    </div>
    <div class="shipping_warehouse">
    <div class="shipping_warehouse_pic"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/de_warehouse.jpg" /></div>
    <div class="shipping_warehouse_text"><div class="shipping_title"><?php echo EU_SHIPPING_17;?></div><p>
    <?php echo EU_SHIPPING_18;?><br />
<?php echo EU_SHIPPING_19;?><br />
<?php echo EU_SHIPPING_20;?><br />
<?php echo EU_SHIPPING_21;?><br />
<?php echo EU_SHIPPING_22;?></p>
<p><?php echo EU_SHIPPING_23;?></p>
</div>
    </div>
    <div class="order_delivery">
    <div class="order_delivery_bg"></div>
    <div class="order_delivery_text">
    <div class="shipping_title"><?php echo EU_SHIPPING_24;?></div>
    <p><?php echo EU_SHIPPING_25;?></p>
    <p><?php echo EU_SHIPPING_26;?><br />
<?php echo EU_SHIPPING_27;?></p>
<p><?php echo EU_SHIPPING_28;?><br />
<?php echo EU_SHIPPING_29;?><br />
<?php echo EU_SHIPPING_30;?>
</p>
<p><?php echo EU_SHIPPING_31;?><a href="<?php echo reset_url('service/fs_support.html');?>"><?php echo EU_SHIPPING_32;?></a><?php echo EU_SHIPPING_33;?></p>
    </div>
    </div>