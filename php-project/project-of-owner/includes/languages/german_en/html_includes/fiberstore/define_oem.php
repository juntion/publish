<style type="text/css">
.categories_select ul {
	margin: 0;
	padding: 0;
}
.categories_select ul li {
	width: 32%;
	margin-right: 2%;
	float: left;
	margin-top: 10px;
	height: 200px;
	margin-bottom: 20px;
	float: left;
	transition: box-shadow .2s linear;
}
.categories_select ul li:last-child {
	margin-right: 0;
}
.categories_select .select01 {
	background: url(/images/all_categories/cate_select01.jpg) no-repeat center;
}
.categories_select .select02 {
	background: url(/images/all_categories/cate_select02.jpg) no-repeat center;
}
.categories_select .select03 {
	background: url(/images/all_categories/cate_select03.jpg) no-repeat center;
}
.categories_select ul li a {
	color: #fff;
	font-size: 16px;
	text-align: center;
	display: block;
	text-decoration: none;
	height: 200px;
	line-height: 200px;
}
.categories_select ul li span {
	background-color: rgba(0, 0, 0, 0.3);
	padding: 10px 20px;
}
/*.categories_select ul li:hover {
	z-index: 2;
	-webkit-box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
	box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}*/
.categories_select ul li:hover span {
    background-color: rgba(0, 0, 0, 0.4);
}
/*header*/
.page_nav {
  width: 100%;
  line-height: 56px;
  background: #fff;
  position: fixed;
  height: 56px;
  top: 0;
  display: none;
  z-index: 22;
  left: 0;/* transition: all 250ms;*/
  box-shadow: 0px 1px 5px #ccc;
  border-bottom: 1px solid #ccc;
}
.page_nav_con {
  width: 1440px;
  margin: 0 auto;
}
.big_title {
  float: left;
}
.big_title a {
  font-size: 16px;
  color: #232323;
  font-weight: 600;
  text-decoration: none;
  padding-left: 20px;
  display: block;
  width: 200px;
}
.big_title a em {
  background: url(/images/partner_bg.png) no-repeat 0 0;
  width: 13px;
  height: 8px;
  display: inline-block;
  margin-left: 10px;
}
.big_title:hover a em {
  background: url(/images/partner_bg.png) no-repeat 0 -29px;
}
.short_title {
  float: right;
}
.short_title a {
  padding: 0 30px;
  text-decoration: none;
  color: #232323;
  font-size: 14px;
  border-right: 1px solid #dedede;
}
.short_title a.title_selected {
  color: #c00000;
}
.short_title a:last-child {
  border-right: none;
}
.short_title a:hover {
  color: #c00000;
}
.big_title .big_title_con {
  display: none;
  line-height: 35px;
  box-shadow: 0 3px 4px rgba(0, 0, 0, 0.18);
  background: #1886cc;
  -webkit-transition: height 0.5s;
  position: absolute;
  z-index: 222;
}
.big_title:hover .big_title_con {
  display: block;
}
.big_title_con span a {
  display: block;
  text-align: left;
  padding-left: 20px;
  font-size: 16px;
  line-height: 70px;
  color: #fff;
  border-bottom: 1px solid #459ed6;
}
.oem_customs_catalog_btn a .icon{
	font-size: 14px;
	margin-left: 8px;
	vertical-align: middle;
}
/*header*/
@media(max-width:1440px){
  .page_nav_con {
    width: 1200px;
  }
}
@media(max-width:1220px){
    .page_nav_con {
  width: 960px;
}
.short_title a{
	  padding: 0 25px;
  }
}
 @media (max-width:960px) {

  .page_nav {
    display: none !important;
  }
  .categories_select ul {
    margin: 0 auto;
  }
  .categories_select ul li:hover {
    box-shadow: none
  }
}
@media (max-width:768px) {
  .categories_select ul li {
  	margin: 0 auto 20px auto;
  	width: inherit;
  	float: none;
  }
}
@media (max-width:480px) {
.categories_select ul {
}
.categories_select ul li a {
	width: inherit;
}
}
</style>
<script>
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
        <div class="big_title">
        <a><?php echo FS_FOOTER_CUSTOMER_SERVICE;?></a>
        </div>
        <div class="short_title"><a class="title_selected" href="<?php echo zen_href_link(FILENAME_OEM);?>"><?php echo FS_FOOTER_OEM;?></a><a href="<?php echo zen_href_link(FILENAME_DAY_RETURN_POLICY);?>"><?php echo FS_FOOTER_POLICY;?></a><a href="<?php echo zen_href_link(FILENAME_WARRANTY);?>"><?php echo FS_FOOTER_WARRANTY;?></a><a href="<?php echo zen_href_link('quality_control');?>"><?php echo FS_FOOTER_QUALITY;?></a><a href="<?php echo $code?>/partner.html"><?php echo FS_FOOTER_PARTNER;?></a></div>
      </div>
    </div>
<div class="oem_top_pic">
  <div class="oem_top_pic_con">
    <div class="oem_top_pic_text"><img src="/includes/templates/fiberstore/images/oem_bg_icon.png" alt="FiberStore.jpg"> <br />
      <em><?php echo FS_OEM_CUSTOMS;?></em> <span><?php echo FS_OEM_EXCELLENT;?></span> </div>
  </div>
</div>
<div class="oem_customs_con">
  <div class="oem_title"><?php echo FS_OEM_MANUFACTURING;?></div>
  <p class="oem_customs_padding"><?php echo FS_OEM_FULL_SERVICE;?></p>
  <div class="oem_customs_any">
    <dl>
      <dt><img src="/images/img/2016oem_icon01.jpg" alt="FiberStore.jpg"></dt>
      <dd><?php echo FS_OEM_ORODUCT;?></dd>
    </dl>
    <dl>
      <dt><img src="/images/img/2016oem_icon02.jpg" alt="FiberStore.jpg"></dt>
      <dd><?php echo FS_OEM_SIZE;?></dd>
    </dl>
    <dl>
      <dt><img src="/images/img/2016oem_icon03.jpg" alt="FiberStore.jpg"></dt>
      <dd><?php echo FS_OEM_TYPE;?></dd>
    </dl>
    <dl>
      <dt><img src="/images/img/2016oem_icon04.jpg" alt="FiberStore.jpg"></dt>
      <dd><?php echo FS_OEM_COLOR;?></dd>
    </dl>
  </div>
  <div class="oem_customs_type">
  <div class="oem_customs_type_bg"></div>
    <ul>
      <li>
        <dl>
          <dt><a href="<?php echo $code?>/custom-fiber-cable-assemblies.html" target="_blank"><img src="/images/img/2016oem_pic01.png" alt="FiberStore.png"></a></dt>
          <dd><span><?php echo FS_OEM_ASSEMBLIES;?></span>
            <p><?php echo FS_OEM_SUPPLIER;?> </p>
            <a href="<?php echo $code?>/custom-fiber-cable-assemblies.html" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><a href="<?php echo $code?>/custom-fiber-optic-transceivers.html" target="_blank"><img src="/images/img/2016oem_pic02.png" alt="FiberStore.png"></a></dt>
          <dd><span><?php echo FS_OEM_MODULES;?></span>
            <p><?php echo FS_OEM_GUIDE;?></p>
            <a href="<?php echo $code?>/custom-fiber-optic-transceivers.html" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><a href="<?php echo $code?>/c/fiber-enclosures-2997" target="_blank"><img src="/images/img/2016oem_pic03.png" alt="FiberStore.png"></a></dt>
          <dd><span><?php echo FS_OEM_PATCHING;?></span>
            <p><?php echo FS_OEM_OPTIONS_ALLOWING;?></p>
            <a href="<?php echo $code?>/c/fiber-enclosures-2997" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
    </ul>
  </div>
  <div class="oem_title"><?php echo FS_OEM_INDUSTRY;?></div>
  <p class="oem_customs_padding"><?php echo FS_OEM_LOOKING;?></p>
  <div class="categories_select">
    <ul>
      <li class="select01"><a href="<?php echo $code?>/data-center-solutions-1308" target="_blank"><span><?php echo FS_OEM_CLOUD;?></span></a></li>
      <li class="select02"><a href="<?php echo $code?>/support/custom-wdm-otn-solutions-for-long-haul-applications-100" target="_blank"><span><?php echo FS_OEM_TRANSMISSON;?></span></a></li>
      <li class="select03"><a href="<?php echo $code?>/Enterprise-Networks.html" target="_blank"><span><?php echo FS_OEM_ACCESS;?></span></a></li>
    </ul>
  </div>
  <div class="ccc"></div>
  <div class="oem_title"><?php echo FS_OEM_EXACTLY;?></div>
  <p class="oem_customs_padding"><?php echo FS_OEM_CHECK;?></p>
  <div  class="oem_customs_padding oem_customs_iphone"><?php echo FS_OEM_CALL_US;?></div>
  <!-- <p class="oem_customs_padding"><?php echo FS_OEM_STANDARD;?></p>
  <div class="oem_customs_catalog_btn"><a href="<?php echo $code?>/show_all_categories.html" target="_blank"><?php echo FS_OEM_BROWSE;?><span class="icon iconfont">&#xf089;</span></a></div> -->
  <div class="oem_customs_guarantee">
    <ul>
      <li>
        <dl>
          <dt><img src="/images/img/2016oem_icon05.jpg" alt="FiberStore.jpg"></dt>
          <dd><?php echo FS_OEM_METHODS;?> </dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><img src="/images/img/2016oem_icon06.jpg" alt="FiberStore.jpg"></dt>
          <dd><?php echo FS_OEM_GUARANTEE;?></dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><img src="/images/img/2016oem_icon07.jpg" alt="FiberStore.jpg"></dt>
          <dd><?php echo FS_OEM_WARRANTY;?></dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><img src="/images/img/2016oem_icon08.jpg" alt="FiberStore.jpg"></dt>
          <dd><?php echo FS_OEM_SHIPPING;?></dd>
        </dl>
      </li>
    </ul>
  </div>
</div>
