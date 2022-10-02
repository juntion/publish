<script>
//滚动后导航固定
$(function(){
	$(window).scroll(function(){
          height = $(window).scrollTop();
   	  	  if(height > 300){
   	  	  	$('.page_nav').fadeIn();
   	  	  }else{
   	  	  	$('.page_nav').fadeOut();
   	  	  };

});
});
</script>
<script type="text/javascript">
function linkMenu(n){
	document.getElementById('link'+n).className="link"+n+"_o";
	document.getElementById('title'+n).className="left_bar_over";
	document.getElementById('divs'+n).style.display="block";
}
function showDiv(n){
	for(i=1; i<=3; i++){
		var title=document.getElementById('title'+i);
		var divs=document.getElementById('divs'+i);
		title.className=i==n?"left_bar_over":"left_bar_out";
		divs.style.display=i==n?"block":"none";
	}
}
</script>
    <div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo SHIPPING_1;?></a>
        </div>
        <div class="short_title">
		<a href="payment_methods.html"><?php echo SHIPPING_2;?></a>
		<a href="net_30.html"><?php echo SHIPPING_3;?></a>
		<a href="#" class="title_selected"><?php echo SHIPPING_4;?></a>
		</div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con shipping_banner"></div>
     <div class="shipping_banner_text"><span><?php echo SHIPPING_4;?></span><?php echo SHIPPING_5;?></div>
    </div>
    <div class="shipping_domestic">
      <div class="shipping_title"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_location_icon.png"/><?php echo SHIPPING_6;?></div>
      <p><?php echo SHIPPING_7;?></p>
      <div class="shipping_note">
     <p><?php echo SHIPPING_8;?></p>
     <p class="return_policy_dian"><?php echo SHIPPING_9;?></p>
     <p class="return_policy_dian"><?php echo SHIPPING_10;?></p>
     </div>
    </div>
    <div class="shipping_global">
    <div class="shipping_global_bg"></div>
    <div class="shipping_title"><?php echo SHIPPING_11;?></div>
    <div class="shipping_domestic">
    <p><?php echo SHIPPING_12;?>
    </p>
</div>
<ul class="shipping_global_list">
<li>
<span class="shipping_icon01"></span><b><?php echo SHIPPING_13;?></b><p><?php echo SHIPPING_14;?>
</p>
</li>
<li>
<span class="shipping_icon02"></span><b><?php echo SHIPPING_15;?></b><p><?php echo SHIPPING_16;?>
</p>
</li>
<li>
<span class="shipping_icon03"></span><b><?php echo SHIPPING_17;?></b><p><?php echo SHIPPING_18;?>
</p>
</li>
</ul>
    </div>
    <div class="shipping_time">
    <div class="shipping_title"><?php echo SHIPPING_19;?></div>
    <div class="shipping_tab">
    <div id="title1" onClick="showDiv(1)" class="tip_over top_item"><?php echo SHIPPING_20;?></div>
    <div id="title2" onClick="showDiv(2)" class="tip_out top_item"><?php echo SHIPPING_21;?></div>
    <div id="title3" onClick="showDiv(3)" class="tip_out top_item"><?php echo SHIPPING_22;?></div>
    </div>
    <div class="shipping_domestic">
    <div id="divs1">
    <div class="shipping_time_con">
    <div class="shipping_time_text"><p><?php echo SHIPPING_23;?></p>
    <p><?php echo SHIPPING_24;?></p></div>
      <div class="shipping_time_pic"><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_pic.jpg" width="392" height="275" /></div>
      </div>
      <p><b><?php echo SHIPPING_25;?></b><?php echo SHIPPING_26;?></p></div>
    <div id="divs2" style="display:none;"><p><?php echo SHIPPING_27;?></p>
<p>
    <?php echo SHIPPING_28;?>
</p>
<p><b><?php echo SHIPPING_25;?></b>
    <?php echo SHIPPING_29;?>
</p>
</div>
    <div id="divs3" style="display:none;"><p><?php echo SHIPPING_30;?></p>
<p><?php echo SHIPPING_31;?>
</p>
<p><?php echo SHIPPING_32;?></p>
   <div class="shipping_note">
     <p><b><?php echo SHIPPING_25;?></b></p>
     <p class="return_policy_dian"><?php echo SHIPPING_33;?>
</p>
     <p class="return_policy_dian"><?php echo SHIPPING_34;?>
</p>
<p class="return_policy_dian"><?php echo SHIPPING_35; ?><a href="mailto:Support@fs.com"><?php echo SHIPPING_42?></a><?php echo SHIPPING_41 ?></p>
     </div>
</div>
    </div>
    </div>
<div class="fs_net_line">&nbsp;</div>
<div class="shipping_way">
<ul><li><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon01.jpg"/><p><?php echo SHIPPING_36;?></p></li>
  <li><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon02.jpg"/><p><?php echo SHIPPING_36;?></p></li>
  <li><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon03.jpg"/><p><?php echo SHIPPING_37;?></p></li>
  <li><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon04.jpg"/><p><?php echo SHIPPING_38;?></p></li>
  <li><img src="/includes/templates/fiberstore/images/specials/shipping_delivery/shipping_way_icon05.jpg"/><p><?php echo SHIPPING_39;?></p></li>
  
  </ul>
</div>


