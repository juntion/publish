<?php
/**
 * why us
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
    <div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo FS_FOOTER_COMPANY_INFO;?></a>
          </div>
        <div class="short_title"><a href="<?php echo zen_href_link('fs_single_pages','name=about_us','SSL');?>"><?php echo FS_FOOTER_ABOUT_FS;?></a><a class="title_selected" href="<?php echo zen_href_link(FILENAME_WHY_US);?>"><?php echo FS_FOOTER_WHY_US;?></a><a href="<?php echo zen_href_link(FILENAME_NEWS);?>"><?php echo LATEST_NEWS;?></a><a href="<?php echo zen_href_link(FILENAME_CONTACT_US);?>"><?php echo FS_FOOTER_CONTACT_US;?></a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con why_banner">
        <div class="page_banner_text"> <span><?php echo FS_WHY_US;?></span><?php echo FS_WHY_CONSISTENTLY;?></div>
      </div>
    </div>
    
    <div class="whyus17con">
       <div class="whyus17text">
       <?php echo FS_WHY_COMMITMENT;?>
       </div>
       <!--块1-->
       <div class="whyus17conhow m_whyus17conhowbg">
         <div class="whyus17con_bg"></div>
         <div class="whyus17contit"><?php echo FS_WHY_COM_QUALITY;?></div>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us01.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_DEDICATED;?></b>
             <p><?php echo FS_WHY_AT_ALL;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us02.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_PERSONNEL;?></b>
             <p><?php echo FS_WHY_PER_QUALITY;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us03.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_PROCESS;?></b>
             <p><?php echo FS_WHY_PRO_QUALITY;?></p>
           </dd>
         </dl>
       </div>
       <!--块2-->
       <div class="whyus17conhow ">
         <div class="whyus17contit"><?php echo FS_WHY_CUSTOMER;?></div>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us04.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_CLIENT;?></b>
             <p><?php echo FS_WHY_HELP;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us05.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_ONLINE;?></b>
             <p><?php echo FS_WHY_ORDER;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us06.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_WHOLESALE;?></b>
             <p><?php echo FS_WHY_NOWADAYS;?></p>
           </dd>
         </dl>
       </div>
       <!--块3-->
       <div class="whyus17conhow m_whyus17conhowbg">
         <div class="whyus17con_bg"></div>
         <div class="whyus17contit"><?php echo FS_WHY_PRODUCTS;?></div>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us08.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_CUSTOM;?></b>
             <p><?php echo FS_WHY_WHO;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us09.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_PROVIDE;?></b>
             <p><?php echo FS_WHY_CONTRARY;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us07.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_FOLLOW;?></b>
             <p><?php echo FS_WHY_KINDS;?></p>
           </dd>
         </dl>
       </div>
       <!--块4-->
       <div class="whyus17conhow">
         <div class="whyus17contit"><?php echo FS_WHY_STOCK;?></div>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us10.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_REGULAR;?></b>
             <p><?php echo FS_WHY_LOCATED;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us11.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_FEDEX;?></b>
             <p><?php echo FS_WHY_EXPER;?></p>
           </dd>
         </dl>
         <dl>
           <dt><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/why_us/why-us12.png" width="290" height="130" /></dt>
           <dd>
             <b><?php echo FS_WHY_EXTENSIVE;?></b>
             <p><?php echo FS_WHY_FIBERSTORE;?></p>
           </dd>
         </dl>
       </div>

   </div>
    
