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
         <div class="big_title"><a><?php echo FS_COMPANY_INFO;?></a>
          </div>
        <div class="short_title"><a href="<?php echo zen_href_link('fs_single_pages','name=about_us','SSL');?>"><?php echo FS_ABOUT_US;?></a><a href="<?php echo zen_href_link(FILENAME_WHY_US);?>" class="title_selected"><?php echo FS_WHY_US;?></a><a href="<?php echo zen_href_link(FILENAME_NEWS);?>"><?php echo FS_NEWS_ROOM;?></a><a href="<?php echo zen_href_link(FILENAME_PARTNER);?>"><?php echo FS_BUSINESS_ACCOUNT;?></a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con why_banner">
        <div class="page_banner_text"> <span><?php echo FS_WHY_US;?></span><?php echo FS_WHY_CONSISTENTLY;?></div>
      </div>
    </div>
    <div class="why_con">
      <div class="why_title"><?php echo FS_WHY_COMMITMENT;?></div>
      <div class="why_text">
        <p><?php echo FS_WHY_COM_QUALITY;?><br />
          <?php echo FS_WHY_DEDICATED;?> <br />
          <?php echo FS_WHY_AT_ALL;?></p>
      </div>
      <div class="why_list">
        <ul>
          <li><em class="icon01"></em><span><?php echo FS_WHY_PERSONNEL;?></span>
            <p><?php echo FS_WHY_PER_QUALITY;?></p>
          </li>
          <li><em class="icon02"></em><span><?php echo FS_WHY_PROCESS;?></span>
            <p><?php echo FS_WHY_PRO_QUALITY;?></p>
          </li>
        </ul>
      </div>
      <div class="why_title"><?php echo FS_WHY_CUSTOMER;?></div>
      <div class="why_text">
        <p><?php echo FS_WHY_CLIENT;?> <br />
          <?php echo FS_WHY_HELP;?></p>
      </div>
      <div class="why_pic">
        <dl>
          <dt><img src="/images/Why-Us_01.jpg"/></dt>
          <dd><span><?php echo FS_WHY_ONLINE;?></span>
            <p><?php echo FS_WHY_ORDER;?> </p>
          </dd>
        </dl>
      </div>
      <div class="why_title"><?php echo FS_WHY_WHOLESALE;?></div>
      <div class="why_text">
        <p><?php echo FS_WHY_NOWADAYS;?> <br />
          <?php echo FS_WHY_PRODUCTS;?></p>
      </div>
      <div class="custom_wholesale">
        <div class="why_custom">
          <div class="title_size"> <span>1.</span> <?php echo FS_WHY_CUSTOM;?> </div>
          <p><?php echo FS_WHY_PROVIDE;?></p>
          <p><?php echo FS_WHY_CONTRARY;?></p>
        </div>
        <div class="why_wholesale">
          <div class="title_size"> <span>2.</span> <?php echo FS_WHY_WHO;?> </div>
          <div class="why_wholesale_pic"> <img src="/images/Why_pic.png" /></div>
          <p><?php echo FS_WHY_FOLLOW;?></p>
          <p><?php echo FS_WHY_KINDS;?> </p>
        </div>
      </div>
      <div class="why_title"><?php echo FS_WHY_STOCK;?></div>
      <div class="why_pic">
        <dl>
          <dt><img src="/images/Why-Us_02.jpg"></dt>
          <dd>
            <p><?php echo FS_WHY_REGULAR;?></p>
            <p><?php echo FS_WHY_LOCATED;?></p>
            <p><?php echo FS_WHY_FEDEX;?> </p>
          </dd>
        </dl>
      </div>
      <div class="why_title"><?php echo FS_WHY_EXPER;?></div>
      <div class="why_text">
        <p><?php echo FS_WHY_EXTENSIVE;?> <br />
          <?php echo FS_WHY_FIBERSTORE;?> <br />
          <?php echo FS_WHY_LARGE;?> <br />
          <?php echo FS_WHY_BUDGET;?></p>
      </div>
      <div class="why_expertise">    
      <div class="why_expertise01"><dl><dt><span></span></dt><dd><b><?php echo FS_WHY_BUSINESS;?></b><p><?php echo FS_WHY_BUSINESS_MODEL;?> </p></dd></dl></div>
      <div class="why_expertise02"><dl><dt><span></span></dt><dd><b><?php echo FS_WHY_DOMAIN;?></b><p><?php echo FS_WHY_OUR_RICH;?> </p></dd></dl></div>
      <div class="why_expertise03"><dl><dt><span></span></dt><dd><b><?php echo FS_WHY_TECHNOLOGY;?></b><p><?php echo FS_WHY_OUR_UNIQUE;?></p></dd></dl></div>
      </div>
    </div>

