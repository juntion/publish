<style type="text/css">
.categories_select ul { margin:0; padding:0; }
.categories_select ul li { width: 32%; margin-right: 2%; float: left; margin-top: 10px; height:200px; margin-bottom:20px; float:left; transition:box-shadow .2s linear;
}
.categories_select ul li:last-child { margin-right: 0; }
.categories_select .select01 { background:url(/images/all_categories/cate_select01.jpg) no-repeat center; }
.categories_select .select02 { background:url(/images/all_categories/cate_select02.jpg) no-repeat center; }
.categories_select .select03 { background:url(/images/all_categories/cate_select03.jpg) no-repeat center; }
.categories_select ul li a { color:#fff; font-size:16px; text-align:center; display:block; text-decoration:none; height:200px; line-height:200px; }
.categories_select ul li span { background-color:rgba(0, 0, 0, 0.3); padding:10px 20px; }
.categories_select ul li:hover { z-index:2; -webkit-box-shadow:0 15px 30px rgba(0, 0, 0, 0.1); box-shadow:0 15px 30px rgba(0, 0, 0, 0.1); }
 @media (max-width:960px) {
 .categories_select ul {
margin:0 auto;
}
.categories_select ul li:hover {
box-shadow: none
}
}
@media (max-width:768px) {
.categories_select ul li {
margin:0 auto 20px auto;
width:inherit;
float:none;
}
}
@media (max-width:480px) {
.categories_select ul {
}
.categories_select ul li a {
width:inherit;
}
}
</style>
<?php 
//������� �����ӽ��д��� 
$language_code = fs_get_data_from_db_fields('code','languages','languages_id='.$_SESSION['languages_id'],'');
if($_SESSION['languages_id'] !=1){
	$code = '/'.$language_code; 
}else{
	$code ='';
}
?>
<div class="oem_top_pic">
  <div class="oem_top_pic_con">
    <div class="oem_top_pic_text"><img src="/includes/templates/fiberstore/images/oem_bg_icon.png" alt="FiberStore.jpg"> <br /><em><?php echo FS_OEM_CUSTOMS;?></em> <span><?php echo FS_OEM_EXCELLENT;?></span> </div>
  </div>
</div>
<div class="oem_customs_con">
  <div class="oem_title"><?php echo FS_OEM_MANUFACTURING;?></div>
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
  <p class="oem_customs_padding"><?php echo FS_OEM_FULL_SERVICE;?></p>
  <div class="oem_customs_type">
    <ul>
      <li>
        <dl>
          <dt><a href="<?php echo $code;?>/custom-fiber-cable-assemblies.html" target="_blank"><img src="/images/img/2016oem_pic01.jpg" alt="FiberStore.jpg"></a></dt>
          <dd><span><?php echo FS_OEM_ASSEMBLIES;?></span>
            <p><?php echo FS_OEM_SUPPLIER;?> </p>
            <a href="<?php echo $code;?>/custom-fiber-cable-assemblies.html" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><a href="<?php echo $code;?>/custom-fiber-optic-transceivers.html" target="_blank"><img src="/images/img/2016oem_pic02.jpg" alt="FiberStore.jpg"></a></dt>
          <dd><span><?php echo FS_OEM_MODULES;?></span>
            <p><?php echo FS_OEM_GUIDE;?></p>
            <a href="<?php echo $code;?>/custom-fiber-optic-transceivers.html" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
      <li>
        <dl>
          <dt><a href="<?php echo $code;?>/c/fiber-enclosures-2997" target="_blank"><img src="/images/img/2016oem_pic03.jpg" alt="FiberStore.jpg"></a></dt>
          <dd><span><?php echo FS_OEM_PATCHING;?></span>
            <p><?php echo FS_OEM_OPTIONS_ALLOWING;?></p>
            <a href="<?php echo $code;?>/c/fiber-enclosures-2997" target="_blank"><?php echo FS_OEM_VIEW_MORE;?><img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a> </dd>
        </dl>
      </li>
    </ul>
  </div>
  <div class="oem_title"><?php echo FS_OEM_INDUSTRY;?></div>
  <p class="oem_customs_padding"><?php echo FS_OEM_LOOKING;?></p>
  <div class="categories_select">
    <ul>
      <li class="select01"><a href="c/racks-enclosures-1308" target="_blank"><span><?php echo FS_OEM_CLOUD;?></span></a></li>
      <li class="select02"><a href="support/custom-wdm-otn-solutions-for-long-haul-applications-100" target="_blank"><span><?php echo FS_OEM_ACCESS;?></span></a></li>
      <li class="select03"><a href="Enterprise-Networks.html" target="_blank"><span><?php echo FS_OEM_TRANSMISSON;?></span></a></li>
    </ul>
  </div>
  <div class="ccc"></div>
  <div class="oem_title"><?php echo FS_OEM_EXACTLY;?></div>
  <p class="oem_customs_padding"><?php echo FS_OEM_CHECK;?></p>
    <div  class="oem_customs_padding oem_customs_iphone"><?php echo FS_OEM_CALL_US;?><a href="mailto:legal@fs.com"><?php echo FS_SER_COMMON_EMALl;?></a></div>
  <!-- <p class="oem_customs_padding"><?php echo FS_OEM_STANDARD;?></p>
  <div class="oem_customs_catalog_btn"><a href="<?php echo $code;?>/show_all_categories.html" target="_blank"><?php echo FS_OEM_BROWSE;?> <img src="/images/img/2016oem_jian.png" alt="FiberStore.jpg"></a></div> -->
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
