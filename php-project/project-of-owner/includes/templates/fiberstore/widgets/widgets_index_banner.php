<?php
//新首页banner图
$colums = array('pc_path','mobile_path','alt','url','banner_content','array_product_id');
$banner = fs_get_data_from_db_fields_array($colums,'fs_banner_manage_new','groups=1 and language_id='.$_SESSION['languages_id'],'order by sort');
foreach($banner as $k=>$v){
	$banner[$k][0] = substr($v[0],1);
	$banner[$k][1] = substr($v[1],1);
	if($v[0]==''){
		unset($banner[$k]);
	}
}
require_once DIR_WS_CLASSES .'set_cookie.php';
$Encryption = new Encryption;
$gb_arr =array('GB');
$au_arr =array('AU');
$countryCode =strtoupper($_SESSION['countries_iso_code']);
$href ="shipping_policy.html";
$au_href ="shipping_delivery.html";
$au_img ='includes/templates/fiberstore/images/banner/w_banner_Australia.jpg';
$m_au_img ='includes/templates/fiberstore/images/banner/m_banner_Australia.jpg';
$ca_img ="includes/templates/fiberstore/images/banner/fs_settle_0206_01.jpg";
$m_ca_img ="includes/templates/fiberstore/images/banner/m_fs_settle_0206_01.jpg";
$eu_img = "includes/templates/fiberstore/images/banner/fs_europe_0404.jpg";
$m_eu_img = "includes/templates/fiberstore/images/banner/m_fs_europe_0404.jpg";
$m_gb_img = "includes/templates/fiberstore/images/banner/m_fs_europe_uk0407.jpg";
if((!seattle_warehouse('country_code',$countryCode)) && (!all_german_warehouse('country_code',$countryCode) && $countryCode != "GB") && (!in_array($countryCode,$gb_arr)) && (!in_array($countryCode,$au_arr))){
	$active = true;
}else{
	$active = false;
}
?>
<style type="text/css">
.content{ padding:0;}
</style>

<div class="banner_right">

	 <?php
    //if(!$is_mobile || isset($_COOKIE['c_site'])){
    ?>
	<ul class="banner_right_slide">
	    <?php if(seattle_warehouse('country_code',$countryCode)){?>
		   <li  <?php echo 'class="active"  style="opacity:1"';?> >
				<a href="<?php echo $href?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to U.S.,<br/>Canada & Mexico</h1>
						<h2>
							Free Shipping<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$ca_img;?>" />
				</a>
		  </li>
		<?php }?>
		<?php if(all_german_warehouse('country_code',$countryCode) && $countryCode != "GB"){?>
		   <li  <?php echo 'class="active"  style="opacity:1"';?> >
				<a href="<?php echo $href?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to EU, UK, <br/>and Most European Areas</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$eu_img;?>" />
				</a>
		  </li>
		<?php }?>
		
		<?php if(in_array($countryCode,$gb_arr)){?>
		   <li  <?php echo 'class="active"  style="opacity:1"';?> >
				<a href="<?php echo $href?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to EU, UK, <br/>and Most European Areas</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$eu_img;?>" />
				</a>
		  </li>
		<?php }?>
		
		<?php if(in_array($countryCode,$au_arr)){?>
		   <li  <?php echo 'class="active"  style="opacity:1"';?> >
				<a href="<?php echo $au_href?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to Australia</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$au_img;?>" />
				</a>
		  </li>
		<?php }?>
	
		<?php foreach($banner as $banner_k=>$banner_v){ ?>
		<li <?php if($active){if($banner_k==0)echo 'class="active"  style="opacity:1"';}?> >
			<a href="<?php echo $banner_v[3]?>">
				<?php if($banner_v[4]) {
					if ($banner_v[5]) {
						$arr_id = explode(',', $banner_v[5]);
						/*var_dump($arr_id);*/
						$price = "";
						$price_sub_id="";
						$i = 0;
						foreach ($arr_id as $arr_pro_id) {
							$i++;
							$price .= 'PRICE' . $i . ",";
							$product_price = zen_get_products_price($arr_pro_id);
							$price_sub_sss = get_products_specail_currency_final_price($currencies->total_format_new($product_price));
							$price_sub_id .=$price_sub_sss."_";
						}
						/*var_dump($price_sub_id);*/
						$currency_symbol_left = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
						$price_arr = explode(',', rtrim($price, ','));
						$price_sub_id_arr = explode('_', rtrim($price_sub_id, '_'));
						/*var_dump($price_sub_id_arr);*/
						$banner_content_price = str_replace($price_arr, $price_sub_id_arr, $banner_v[4]);
						$banner_content = str_replace('SYMBOL',$currency_symbol_left,$banner_content_price);
						echo stripslashes($banner_content);
						/*var_dump($price_arr);
                        var_dump($banner_content);
                        */
					} else {
						echo stripslashes($banner_v[4]);
					}
				}?>
				<img src="<?php echo HTTPS_IMAGE_SERVER.$banner_v[0];?>" />
			</a>
		</li>
		<?php } ?>
	</ul>
	<div class='banner_right_slide_prev'><i></i><span></span></div>
	<div class='banner_right_slide_next'><i></i><span></span></div>
	<div class='banner_right_slide_dot'  
	<?php if(seattle_warehouse('country_code',$countryCode)){
		    echo 'style= margin-left:-180px';
		  }elseif(all_german_warehouse('country_code',$countryCode) && $countryCode != "GB"){
			  echo 'style= margin-left:-180px';
		  }elseif(in_array($countryCode,$gb_arr)){
			  echo 'style= margin-left:-180px';
		  }elseif(in_array($countryCode,$au_arr)){
			  echo 'style= margin-left:-180px';
		  }else{
			  echo 'style= margin-left:-150px';
		  }?>>
	    <?php if(seattle_warehouse('country_code',$countryCode)){?>
		<em><span></span><i></i></em>
		<?php } ?>
		<?php if(all_german_warehouse('country_code',$countryCode) && $countryCode != "GB"){?>
		<em><span></span><i></i></em>
		<?php } ?>
		<?php if(in_array($countryCode,$gb_arr)){?>
		<em><span></span><i></i></em>
		<?php } ?>
		<?php if(in_array($countryCode,$au_arr)){?>
		<em><span></span><i></i></em>
		<?php } ?>
		<?php for($i=0;$i<sizeof($banner);$i++){ ?>
		<em><span></span><i></i></em>
		<?php } ?>
	</div>
	
	<?php //}else{ ?>
	<div class="swiper-container swiper-container-horizontal home_mobile_banner">
		<div class="swiper-wrapper">
		  <?php if(seattle_warehouse('country_code',$countryCode)){?>
			<div class="swiper-slide" style="width: 375px;">
				<a href="<?php echo $href;?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to U.S.,<br/>Canada & Mexico</h1>
						<h2>
							Free Shipping<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$m_ca_img;?>" alt="<?php echo $m_ca_img;?>">
				</a>
			</div>
		  <?php } ?>
		  <?php if(all_german_warehouse('country_code',$countryCode) && $countryCode != "GB"){?>
			<div class="swiper-slide" style="width: 375px;">
				<a href="<?php echo $href;?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to EU, UK, <br/>and Most European Areas</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$m_eu_img;?>" alt="<?php echo $m_eu_img;?>">
				</a>
			</div>
		  <?php } ?>
		  
		  <?php if(in_array($countryCode,$gb_arr)){?>
			<div class="swiper-slide" style="width: 375px;">
				<a href="<?php echo $href;?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to EU, UK, <br/>and Most European Areas</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$m_gb_img;?>" alt="<?php echo $m_gb_img;?>">
				</a>
			</div>
		  <?php } ?>
		  
		  <?php if(in_array($countryCode,$au_arr)){?>
			<div class="swiper-slide" style="width: 375px;">
				<a href="<?php echo $au_href;?>">
					<div class="banner_17text">
						<h1>
							Same Day Shipping to Australia</h1>
						<h2>
							Free Delivery<br/>
							24/7 Live Tech Support</h2>
					<span class="banner_17btn">Learn More</span>		
					</div>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$m_au_img;?>" alt="<?php echo $m_au_img;?>">
				</a>
			</div>
		  <?php } ?>
		 	
			<?php foreach($banner as $banner_k=>$banner_v){ ?>
			<div class="swiper-slide" style="width: 375px;">
				<a href="<?php echo $banner_v[3]?>">
					<?php if($banner_v[4]) {
						if ($banner_v[5]) {
							$arr_id = explode(',', $banner_v[5]);
							/*var_dump($arr_id);*/
							$price = "";
							$price_sub_id="";
							$i = 0;
							foreach ($arr_id as $arr_pro_id) {
								$i++;
								$price .= 'PRICE' . $i . ",";
								$product_price = zen_get_products_price($arr_pro_id);
								$price_sub_sss = get_products_specail_currency_final_price($currencies->total_format_new($product_price));
								$price_sub_id .=$price_sub_sss."_";
							}
							/*var_dump($price_sub_id);*/
							$currency_symbol_left = $currencies->currencies[$_SESSION['currency']]['symbol_left'];
							$price_arr = explode(',', rtrim($price, ','));
							$price_sub_id_arr = explode('_', rtrim($price_sub_id, '_'));
							/*var_dump($price_sub_id_arr);*/
							$banner_content_price = str_replace($price_arr, $price_sub_id_arr, $banner_v[4]);
							$banner_content = str_replace('SYMBOL',$currency_symbol_left,$banner_content_price);
							echo stripslashes($banner_content);
							/*var_dump($price_arr);
                            var_dump($banner_content);
                            */
						} else {
							echo stripslashes($banner_v[4]);
						}
					}?>
					<img src="<?php echo HTTPS_IMAGE_SERVER.$banner_v[1];?>" alt="<?php echo $banner_v[2]?>">
				</a>
			</div>
			<?php } ?>
		</div>
		
		<div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
			<?php for($i=0;$i<sizeof($banner);$i++){ ?>
			<span class="swiper-pagination-bullet <?php if($i==0)echo 'swiper-pagination-bullet-active';?>"></span>
			<?php } ?>
		</div>
	</div>
	<?php //} ?>
</div>