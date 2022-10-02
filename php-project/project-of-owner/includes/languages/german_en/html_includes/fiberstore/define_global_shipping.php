<?php
/**
 * global shipping
 */?>

	      
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
<style>
    .header .search_header #search_input{
        background-color: #fff;
    }
    @media(max-width:960px){
    	#circular{
    		width: 100% !important;
    	}
    	#circular div{
    		width: 100% !important;
    	}
    	#circular div canvas{
    		width: 100% !important;
    	}
    }
</style>
<script src="includes/templates/fiberstore/jscript/echarts.common.min.js" type="text/javascript"></script>
    <div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a>Payment & Shipping</a>
        </div>
        <div class="short_title"><a href="<?php echo zen_href_link(FILENAME_PAYMENT_METHODS);?>">Payment Methods</a><a href="<?php echo zen_href_link('net_30');?>">Net 30 & W9</a><a href="<?php echo zen_href_link(FILENAME_GLOBAL_SHIPPING);?>" class="title_selected">Shipping Guide</a><a href="<?php echo zen_href_link(FILENAME_ESTIMATED_TIME);?>">Delivery & Shipment</a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con shipping_guide_banner">
        <div class="page_banner_text"><span><?php echo FS_GLOBAL_GUIDE?></span><?php echo FS_GLOBAL_WE?></div>
      </div>
    </div>
    <div class="payment_con">
      <div class="payment_title"><div class="payment_title_img"><span><img src="images/shipping_guide_icon_01.png" alt="Fs shipping_guide_icon_01.png"></span><span><img src="images/shipping_guide_icon_02.png" alt="Fs shipping_guide_icon_02.png"></span><span><img src="images/shipping_guide_icon_03.png" alt="Fs shipping_guide_icon_03.png"></span></div> <?php echo FS_GLOBAL_SHIPPING?></div>
      <div class="payment_text">
        <p><?php echo FS_GLOBAL_TOGETHER?></p>
        <p><?php echo FS_GLOBAL_FIBERSTORE?> </p>
        <p><?php echo FS_GLOBAL_VARIOUS?></p>
      </div>
    </div>
    <div class="fs_net_line">&nbsp;</div>
    <div class="payment_con">
      <div class="payment_title"><?php echo FS_GLOBAL_DELIVERY?></div>
      <div class="payment_text">
        <p><?php echo FS_GLOBAL_OFFERS?> </p>
        <p><?php echo FS_GLOBAL_IF?></p>
        <div class="return_title02"><?php echo FS_GLOBAL_SPEED?></div>
        <p><?php echo FS_GLOBAL_THIS?></p>
      </div>
      
      <div align="center">         		     
		    <div id="circular" style="width: 800px;height:430px;margin: -40px auto;"></div>    
	      <div class="Pie_shape">
          <dl><dt><span class="bule"></span></dt><dd>Order Dispatched 1-2 days after your payment</dd></dl>
          <dl><dt><span class="green"></span></dt><dd>3 working Days</dd></dl>
          <dl><dt><span class="orange"></span></dt><dd>4 working Days</dd></dl>
          <dl><dt><span class="purple"></span></dt><dd>within 1 week</dd></dl>
          <dl><dt><span class="red"></span></dt><dd>more than 1 week</dd></dl>
	      </div> 
    </div> 
	          
	</div>
	
    </div>
    <div class="fs_net_line">&nbsp;</div>
    <div class="payment_title"><?php echo FS_GLOBAL_TIME?></div>
    <div class="delivery_time">
    <ul>
    <li><dl><dt><span class="icon01"></span></dt><dd><span><?php echo FS_GLOBAL_FEDEX?></span><p><?php echo FS_GLOBAL_FEDEX_DAYS?></p></dd></dl></li>
    <li><dl><dt><span class="icon02"></span></dt><dd><span><?php echo FS_GLOBAL_DHL?></span><p><?php echo FS_GLOBAL_DHL_DAYS?></p></dd></dl></li>
    <li><dl><dt><span class="icon03"></span></dt><dd><span><?php echo FS_GLOBAL_EMS?></span><p><?php echo FS_GLOBAL_EMS_DAYS?></p></dd></dl></li>
    <li><dl><dt><span class="icon04"></span></dt><dd><span><?php echo FS_GLOBAL_UPS?></span><p><?php echo FS_GLOBAL_UPS_DAYS?></p></dd></dl></li>
    <li><dl><dt><span class="icon05"></span></dt><dd><span><?php echo FS_GLOBAL_HK?></span><p><?php echo FS_GLOBAL_HK_DAYS?></p></dd></dl></li>
    </ul>
    </div>
    <div class="fs_net_line">&nbsp;</div>
    <div class="return_policy">
    <div class="payment_title"><?php echo FS_GLOBAL_FEES?></div>
    <p class="return_policy_dian"><?php echo FS_GLOBAL_CHARGE?></p>
    <p class="return_policy_dian"><?php echo FS_GLOBAL_ANY?></p>
    <p class="return_policy_dian"><?php echo FS_GLOBAL_COSTS?></p>
    <p><?php echo FS_GLOBAL_PS?></p>
    <p><?php echo FS_GLOBAL_ALTHOUGH?></p>
    <p class="return_policy_dian"><?php echo FS_GLOBAL_PACKAGE?></p>
    <p class="return_policy_dian"><?php echo FS_GLOBAL_PLEASE?></p>
    </div>
 <script>
 	$(document).ready(function(){
	 	setInterval(function(){
	 		if($('.header_03_01').width()<=50){
	 			setTimeout(function(){
	 				$('.header_03').css('background-color','#c00000')
	 			},100)
	 		}
	 	},100)
 	}) 
 </script>
 <script>
		var myChart = echarts.init(document.getElementById('circular'));
		var option = {
			tooltip: {
				trigger: 'item',
				formatter: "{a} <br/>{b}:  {d}%"
			},
			series: [

				{
					name: 'Express time',
					type: 'pie',
					radius: ['40%', '55%'],

					data: [{
							value: 292,
							name: '1-2 days',
							itemStyle: {
								normal: {
									color: '#3ea8f5'
								}
							}
						},
						{
							value: 40,
							name: '3working Days',
							itemStyle: {
								normal: {
									color: '#04b622'
								}
							}
						},
						{
							value: 14,
							name: '4working Days',
							itemStyle: {
								normal: {
									color: '#f68e35'
								}
							}
						},
						{
							value: 10,
							name: 'within 1 week',
							itemStyle: {
								normal: {
									color: '#7f78e8'
								}
							}
						},
						{
							value: 4,
							name: 'More than 1 week',
							itemStyle: {
								normal: {
									color: '#fb4553'
								}
							}
						}
					]
				}
			]
		};
		myChart.setOption(option);
	</script>