<div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo FS_TIME_PAY_SHIPPING;?></a><div class="big_title_con"></div></div>
        <div class="short_title"><a href="payment_methods.html"><?php echo FS_TIME_PAYMENT;?></a><a href="net_30.html"><?php echo FS_TIME_NET30_W9;?></a><a href="global_shipping.html"><?php echo FS_TIME_GUIDE;?></a><a href="estimated_lead_time.html" class="title_selected"><?php echo NAVBAR_TITLE;?></a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con ds_banner">
        <div class="page_banner_text"><span><?php echo FS_TIME_SHIPMENT;?></span><?php echo FS_TIME_FIBERSTORE;?></div>
      </div>
    </div>
    <div class="fs_ds_con">
      <div class="fs_address_tite">
        <div class="fs_address_bg">
          <div class="fs_address_con">
            <div class="fs_ds_title"><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/address_icon.png" width="76" height="76" /></div>
            <div class="fs_ds_title01"><span class="bt"><?php echo FS_TIME_AMERICAN;?></span><span style=" display:table"><?php echo FS_TIME_ANDOVER;?></span></div>
			 <div class="fs_ds_title01"><span class="bt"><?php echo FS_TIME_GEAMAN;?></span><span style=" display:table"><?php echo FS_TIME_GEM;?></span></div>
            <div class="fs_ds_title01"><span class="bt"><?php echo FS_TIME_CHINA;?></span><span style=" display:table"><?php echo FS_TIME_EAST;?></span></div>
            <div class="fs_ds_title01"><span class="bt"><?php echo FS_TIME_HONG_KONG;?></span><span  style=" display:table"><?php echo FS_TIME_TUNG;?></span></div>
            <div class="fs_ds_title02"><span class="bt"><?php echo FS_TIME_SHIPS;?></span><span><?php echo FS_TIME_WORLDWIDE;?></span></div>
          </div>
        </div>
      </div>
      <div class="fs_ds_title"><?php echo FS_TIME_SHIPPING;?></div>
      <p><?php echo FS_TIME_DELIVERY;?></p>
      <p><?php echo FS_TIME_ESTIMATED;?></p>
      <p><?php echo FS_TIME_THE;?></p>
      <p><?php echo FS_TIME_BUSINESS;?></p>
      <p><?php echo FS_TIME_IF;?></p>
      <p><?php echo FS_TIME_BEFORE;?></p>
      <br />
      <br />
      <div class="fs_net_line "></div>
      <div class="fs_ds_title"><?php echo FS_TIME_OUR;?></div>
      <p><?php echo FS_TIME_WE;?></p>
      <p><?php echo FS_TIME_IMPORT;?></p>
      <p><?php echo FS_TIME_PRIMARY;?></p>
      <p><?php echo FS_TIME_PLEASE;?></p>
      <br />
      <br />
      <div class="fs_net_line "></div>
      <div class="fs_ds_title"><?php echo FS_TIME_CUSTOMS;?></div>
      <b><?php echo FS_TIME_NOTE;?></b>
      <p><?php echo FS_TIME_DUTIES;?></p>
</div>
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
