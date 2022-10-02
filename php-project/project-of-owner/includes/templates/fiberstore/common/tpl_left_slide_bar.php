<?php 
if (!class_exists('fiberstore_category')){
require DIR_WS_CLASSES . 'fiberstore_category.php';
}
?>

<div class="sidebar">
  <div class="sidebar_menu">
    <div class="allsort">
      <div class="mc">
        <?php 
                         //show all categories
                         echo fiberstore_category::show_categories();?>
      </div>
    </div>
    <script type="text/javascript"> 
//(function($){ $.fn.hoverForIE6=function(option){ var s=$.extend({ current:"hover",delay:0 } ,option||{}); $.each(this,function(){ var timer1=null,timer2=null,flag=false; $(this).bind("mouseover",function(){ if (flag){ clearTimeout(timer2); } else{ var _this=$(this); timer1=setTimeout(function(){ _this.addClass(s.current); flag=true; } ,s.delay); } }).bind("mouseout",function(){ if (flag){ var _this=$(this); timer2=setTimeout(function(){ _this.removeClass(s.current); flag=false; } ,s.delay); } else{ clearTimeout(timer1); } }) }) } })(jQuery);
(function(MInRPg1){ MInRPg1["\x66\x6e"]["\x68\x6f\x76\x65\x72\x46\x6f\x72\x49\x45\x36"]=function(buQB2){ var KsT3=MInRPg1["\x65\x78\x74\x65\x6e\x64"]({ current:"\x68\x6f\x76\x65\x72",delay:0 } ,buQB2||{}); MInRPg1["\x65\x61\x63\x68"](this,function(){ var YUvKZ_4=null,lnw5=null,Xw6=false; MInRPg1(this)["\x62\x69\x6e\x64"]("\x6d\x6f\x75\x73\x65\x6f\x76\x65\x72",function(){ if (Xw6){ clearTimeout(lnw5); } else{ var ouPnzBvY7=MInRPg1(this); YUvKZ_4=setTimeout(function(){ ouPnzBvY7["\x61\x64\x64\x43\x6c\x61\x73\x73"](KsT3["\x63\x75\x72\x72\x65\x6e\x74"]); Xw6=true; } ,KsT3["\x64\x65\x6c\x61\x79"]); } })["\x62\x69\x6e\x64"]("\x6d\x6f\x75\x73\x65\x6f\x75\x74",function(){ if (Xw6){ var MuIfMJUn8=MInRPg1(this); lnw5=setTimeout(function(){ MuIfMJUn8["\x72\x65\x6d\x6f\x76\x65\x43\x6c\x61\x73\x73"](KsT3["\x63\x75\x72\x72\x65\x6e\x74"]); Xw6=false; } ,KsT3["\x64\x65\x6c\x61\x79"]); } else{ clearTimeout(YUvKZ_4); } }) }) } })(jQuery);
$(".allsort").hoverForIE6({current:"allsorthover",delay:0});
$(".allsort .item").hoverForIE6({delay:0});
$(".close").click(function(){$(this).parents(".item").trigger("mouseout");});
</script>
  </div>
  <div class="sidebar_contact">
    <div class="sedebar_contact_01 "><a target="_blank" href="<?php echo reset_url('service/fs_support.html');?>">
      <dl>
        <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/live_chat_yk.jpg" alt="" title="FiberStore "></dt>
        <dd><b>How can we help you today?</b> <i></i>Chat Live Now</dd>
        <div class="ccc"></div>
      </dl>
      </a> </div>
  </div>
  <div class="sidebar_03_menu vertical_height">
    <div class="sidebar_03"> <a  rel="nofollow" href="<?php echo zen_href_link(FILENAME_PARTNER,'','NONSSL');?>" title="Global Shipping" class=" sidebar_03_radius01">
      <p class="sidebar_03_01 sidebar_02_06"></p>
      <p class="sidebar_03_02 "><b>Partner  Program</b> Grows Your Business</p>
      </a> </div>
    <div class="sidebar_03"> <a  rel="nofollow" href="<?php echo zen_href_link(FILENAME_GLOBAL_SHIPPING,'','NONSSL');?>" title="Global Shipping">
      <p class="sidebar_03_01 sidebar_02_01"></p>
      <p class="sidebar_03_02 "><b>Global Shipping</b> 2 to 3 Days Delivery to Worldwide</p>
      </a> </div>
    <div class="sidebar_03"> <a  rel="nofollow" href="<?php echo zen_href_link(FILENAME_ISO_STANDARD,'','NONSSL');?>" title="ISO Standard">
      <p class="sidebar_03_01 sidebar_02_02"></p>
      <p class="sidebar_03_02"><b>ISO Standard</b> Focused on Quality and Precision</p>
      </a> </div>
    <!--               <div class="sidebar_03">-->
    <!--			   <a rel="nofollow" href="<?php // echo zen_href_link('both_ways');?>">-->
    <!--                    <p class="sidebar_03_01 sidebar_02_03"></p>-->
    <!--                    <p class="sidebar_03_02"><b>Free Shipping</b>-->
    <!--                         Fedex Overnight Supported</p>-->
    <!--						 </a>-->
    <!--               </div>-->
    <div class="sidebar_03"> <a rel="nofollow" href="<?php echo zen_href_link(FILENAME_PAYMENT_METHODS);?>" title="Payment Method">
      <p class="sidebar_03_01 sidebar_02_04"></p>
      <p class="sidebar_03_02"><b>Payment Method</b> Secured Payment</p>
      </a> </div>
    <div class="sidebar_03" > <a href="<?php echo zen_href_link(FILENAME_WARRANTY,'','NONSSL');?>" title="Lifetime Warranty" class=" sidebar_03_radius02" style="border-bottom:none; ">
      <p class="sidebar_03_01 sidebar_02_05"></p>
      <p class="sidebar_03_02"><b>Lifetime Warranty</b> Under Normal Use </p>
      </a> </div>
  </div>
  <div class="sidebar_02">
    <div class="sidebar_02_01"><a href="<?php echo zen_href_link(FILENAME_GLOBAL_SHIPPING);?>"></a></div>
    <div class="sidebar_02_02"><a href="<?php echo zen_href_link(FILENAME_ISO_STANDARD);?>"></a></div>
    <div class="sidebar_02_03"><a href="<?php echo zen_href_link('both_ways');?>"></a></div>
    <div class="sidebar_02_04"><a href="<?php echo zen_href_link(FILENAME_PAYMENT_METHODS);?>"></a></div>
    <div class="sidebar_02_05"><a href="<?php echo zen_href_link(FILENAME_RMA_SOLUTION);?>"></a></div>
  </div>
  <!-- bof OEM -->
  <div class="oem_01 oem_index"> <a title="Learn More" href="<?php echo zen_href_link(FILENAME_OEM);?>"> <span class="oem_02">OEM &amp; Custom</span> <span class="oem_03 "><ul><li>Any product </li><li>Any size</li><li>Any type</li><li>Any color</li></ul></span> <span class="oem_03 oem_04">Let's Work With You on Your Custom Project</span> </a> </div>
  <!-- eof OEM -->
</div>
