<?php

// 头部顶部
//terenence-新登陆跳转 10/18
// fairy 2019.2.18 add main_page=captcha,这个是验证码的链接
if(!in_array($_GET['main_page'],array('login','page_notfound','logoff','captcha')) && !empty($_GET['main_page']) && empty($_POST)){
    if(!check_login_id()){
        $_SESSION['navigation']->set_snapshot();
    }else{
        if(in_array($_GET['main_page'],array("shopping_cart","saved_items","saved_cart_details","my_dashboard","manage_orders","sales_service_list","inquiry_list","manage_addresses","my_cases","account_history_info_old","manage_orders_old","sales_service_list","my_cases_details","my_credit","inquiry_detail","account_history_info","sales_service_info","sales_service_details","sales_service_details","coding_requests"))){
            $_SESSION['navigation']->snapshot = array('page' => 'index',
                'mode' => 'NONSSL',
                'get' => array(),
                'post' => array());
        }else{
            $_SESSION['navigation']->set_snapshot();
        }
    }
}

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版修改
if(isset($_GET['c_site']) && !empty($_GET['c_site'])){
    // 手机版切换 电脑版、手机版。设置cookie
    if($_GET['c_site'] === 'w_site'){
        $c_site = $_GET['c_site'].mt_rand();
        setcookie("c_site",$c_site,time()+3600*24,"","",COOKIE_SECURE,COOKIE_HTTPONLY);
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }elseif($_GET['c_site'] === 'p_site'){
        setcookie("c_site","",time()-3600*24);
        zen_redirect(zen_href_link(FILENAME_DEFAULT));
    }
}
if (!class_exists('fiberstore_category')){
    require DIR_WS_CLASSES . 'fiberstore_category.php';
}
if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
}
if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
    echo htmlspecialchars(urldecode($_GET['error_message']));
}
if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
    echo htmlspecialchars($_GET['info_message']);
}

require_once DIR_WS_CLASSES .'set_cookie.php';
$Encryption = new Encryption;
if (isset($_COOKIE['fs_login_cookie'])) {$cookie_customer_decrypt = (int)$Encryption->_decrypt($_COOKIE['fs_login_cookie']);}

if(!isset($_SESSION['customer_id']) && isset($cookie_customer_decrypt) && $cookie_customer_decrypt != null){
    $_SESSION['customer_id'] = $cookie_customer_decrypt;
    $_SESSION['cart']->restore_contents();
}
if(isset($_SESSION['customer_id'])){
    get_customers_member_level();
}
// 判断语言进行跳转
$pos = strpos($_SERVER['HTTP_REFERER'], 'feisu.com');
if ($pos === false){
    $feisu_status = false;
}else{
    $feisu_status = true;
}

if (!isset($flag_disable_header) || !$flag_disable_header) {
    ?>
    <script type="text/javascript">
    function ischina(){
        if(!$.cookie('web_language')){
            var type=navigator.appName;
            if (type=="Netscape"){
                var lang = navigator.language
            }
            else{
                var lang = navigator.userLanguage
            }
            //取得浏览器语言的前两个字母
            var lang = lang.substr(0,2)
        }else{
            var lang = $.cookie('web_language');
        }
        if (lang == "zh"){
             //window.stop();
            //window.location.href="http://www.feisu.com/";
        }
    }

    <?php if($feisu_status == false){ ?>
        if(window.location.href=="http://www.fs.com/"){
            ischina();
        }
    <?php }else{  ?>
        $.cookie('web_language', 'en', { expires: 7 });
    <?php } ?>
    if(window.location.href=="http://www.fs.com/index.php"){
	    $.cookie('web_language', 'en', { expires: 7 });
    }
</script>

    <?php
    require_once($language_page_directory.'views/validation.common.php'); // 调用公共的验证语言包
	//浏览器版本信息
	$MyBrowserType =my_get_browser();
	$NeedUpdateArr =array('Internet Explorer 8.0','Internet Explorer 7.0','Internet Explorer 6.0','Internet Explorer 9.0');
    //公共的数据
    // 是否是手机
    $is_mobile = isMobile();
    $common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
    //购物车
    require DIR_WS_CLASSES.'shopping_cart_help.php';
    $shopping_cart_help = new shopping_cart_help();
    $cart_items = $_SESSION['cart']->count_contents()+$product_off_count;
    $cart_items_real = $_SESSION['cart']->count_contents();
    //默认选择的国家
    $default_country_code = $_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us';
	$default_country_id = fs_get_data_from_db_fields('countries_id','countries','countries_iso_code_2="'.strtoupper($default_country_code).'"','limit 1');
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $country_code = strtolower($default_country_code);
    //默认选择的货币
    if($_SESSION['currency']){
        $symbol_var = $currencies->currencies[$_SESSION['currency']]['symbol_var'];
        if($_SESSION['languages_code'] == 'ru' && $is_mobile){
            $symbol_var = '<i class="icon iconfont currency_rub">&#xf401;</i>';
        }
        $default_currency = $symbol_var.' '.$_SESSION['currency'];
    }else{
        $default_currency = '$ USD';
    }

	//默认国家匹配能跳往的站点
	$mc_html =$wap_html='';
    $mc_languages = getWebsiteData(array('currency','default_site','website'),'country_code="'.strtoupper($_SESSION['countries_iso_code']).'"','ORDER BY sort ASC');
    if($mc_languages){
		foreach($mc_languages as $lang){
			$symbol_var = $currencies->currencies[$lang[0]]['symbol_var'];
			if($lang[0] == 'RUB' && $is_mobile){
                $symbol_var = '<i class="icon iconfont currency_rub">&#xf401;</i>';
            }
			$mc_html .='<li><span data-country="'.$lang[2].'" data-currency="'.$lang[0].'">'.$lang[1].'</span> / <em>'.$symbol_var.' '.$lang[0].' </em></li>';
		    $wap_html .="<li class='index_wap_currency_list";
		    // 当前站点、货币提示
            //国家跳转code变量
            $siteCoutCode = $_SESSION['languages_code'];
            if($_SESSION['languages_code']=='dn'){
                $siteCoutCode = 'de-en';
            }
		    if($_SESSION['currency'] == $lang[0] && $siteCoutCode == $lang[2]){
		        $wap_html .= ' active default';
		    }
		    $wap_html .= "'><a href='javascript:;'><span data-country='".$lang[2]."' data-currency='".$lang[0]."'>".$lang[1]." / ".$symbol_var." ".$lang[0]." </span><icon class='icon iconfont'>&#xf158;</icon></a></li>";
		}
	}else{
		$mc_html .='<li><span data-country="en" data-currency="USD">English</span> / <em>$ USD</em></li>';
		$wap_html.="<li class='index_wap_currency_list'><a href='javascript:;'><span data-country='en' data-currency='USD'>English / $ USD</span></a></li>";
	}
	
	
	$phone_str = '';
	$top_left_href = reset_url('company/about_us.html');
	switch($_SESSION['languages_code']){
		case 'dn':
//			if($_SESSION['countries_iso_code']!='de'){
//				$phone_str ="<span>".FS_CALL_US." <a href='tel:".fs_new_get_phone($_SESSION['countries_iso_code'])."'>".fs_new_get_phone($_SESSION['countries_iso_code'])."</a></span>";
//			}
			//$top_left_href = zen_href_link('legal_notice','','SSL');
            $top_left_href = reset_url('/de-en/legal_notice.html');
			break;
		case 'de':
			//$top_left_href = zen_href_link('legal_notice','','SSL');
            $top_left_href = reset_url('/de/legal_notice.html');
			break;
//		case 'uk':
//			$phone_str = '<span>'.FS_CALL_US.' <a href="tel:'.FS_PHONE_GB.'">'.FS_PHONE_GB.'</a></span>';
//			break;
		default:
			$phone_str = '';
			break;
	}
					
	// 用户
    $common_current_username = $_SESSION['customer_first_name'].' '.$_SESSION['customer_last_name'];
    $common_phone = fs_new_get_phone($_SESSION['countries_iso_code']);
    // 顶部数据 end

    // 头部导航 start
    if(isset($_GET['keyword']) && $_GET['keyword']){
        $common_default_search_key =  strip_tags($_GET['keyword']);
    }else if(isset($_GET['Popular_id'])){
        $common_default_search_key =  strip_tags($keyword);
    }else{
        $common_default_search_key =  HOT_SEARCH_KEYWORDS;
    }
    if(1 == sizeof($cPath_array)){
        $menu_column = array('menu_title','menu_link');
        $menu_where = 'languages_id='.(int)$_SESSION['languages_id'].' and type=1 and categories_id='.(int)$current_category_id;
        $menu_data = fs_get_data_from_db_fields_array($menu_column,'categories_index_menu',$menu_where,'order by sort limit 5');
    }
    // 头部导航 end
    
    // 国家选择
    $common_all_areas = get_all_country_area();
	switch($_SESSION['languages_code']){
		case 'jp':
		$local_language = '日本语';
		break ;
		
		case 'es':
		case 'mx':
		$local_language = 'Español';
		break ;
		
		case 'fr':
		$local_language = 'Français';
		break ;
		
		case 'de':
		$local_language = 'Deutsch';
		break ;
		
		case 'ru':
		$local_language = 'Pусский';
		break ;

        case 'it':
            $local_language = 'Italiano';
            break;
		
		default:
		//$local_language = ucfirst($_SESSION['language']);
		$local_language = 'English';
		break;
	}

    if(!$common_is_mobile){  // pc
        // 顶部数据 start
        $common_fs_site_country_str = get_country_to_state($_SESSION['countries_iso_code']);
        if (empty($common_fs_site_country_str)) {
           $common_fs_site_country_str = get_fs_site_country();
        } else {
            //FS + 国家所属于的洲 2019.9.17  add by liang.zhu
            $common_fs_site_country_str = 'FS ' . $common_fs_site_country_str;
        }

        $header_free_shipping_str = get_header_common_notice();

        //$common_orderNum = zen_get_order_num_by_status(1);
        //改版后的账户中心各状态订单没有展示，取消数字提示 ery 2019.12.12
        $common_orderNum = 0;
        $common_caseNum = getReplayNumbers();
    }else{
        $m_common_hot_search = array(
            FS_HEADER_03 => 'c/cisco-40g-qsfp-1361',
            FS_HEADER_04 => 'c/qsfp28-100g-transceivers-1159',
            FS_HEADER_05 => 'c/10g-sfp-dac-1114',
            FS_HEADER_06 => 'c/dwdm-sfp-plus-66',
            FS_HEADER_07 => 'c/cwdm-dwdm-mux-demux-6',
            FS_HEADER_08 => 'c/mtp-mpo-fiber-cabling-899',
            FS_HEADER_09 => 'c/os2-9-125-singlemode-duplex-897',
            FS_HEADER_10 => 'c/optical-attenuators-1023',
        );
        $header_free_shipping_str = zen_free_shipping_str_mobile();
    }
	//国家跳转code变量
	$siteCoutCode = $_SESSION['languages_code'];
	if($_SESSION['languages_code']=='dn'){
		$siteCoutCode = 'de-en';
	}
    ?>

    <?php
	if($_SESSION['languages_code']=="de"){
        echo de_eu_festival_message();
	}else{
        echo eu_festival_message();
	}

    if(!$common_is_mobile){  // pc
        ?>

        <!-- 顶部 -->
        <div class="top">
            <div class="public_mask"></div>
            <div class="top_main">
                <div class="top_left">
                    <?php if ($common_fs_site_country_str){ ?>
                        <span><a href="<?php echo $top_left_href;?>" target="_blank"><?php echo $common_fs_site_country_str; ?></a></span>
                    <?php } ?>
                    <?php
                    //如果是俄罗斯国家 则展示邮箱
                    if($_SESSION['countries_iso_code'] =='ru'){
                        echo FS_HEADER_EMAIL;
                    }?>
                    <?php echo $phone_str ;?>
                    <a class="Policy_window_a01" href="<?php echo reset_url('shipping_delivery.html');?>" title="<?php echo $header_free_shipping_str; ?>"><?php echo $header_free_shipping_str; ?></a>
                </div>
				<?php 
				//头部左上角free shipping政策窗口
				//echo get_free_shipping_message();
				?>
                <div class="top_right">
					<div class="top_help">
						<a href="<?php echo reset_url('service/fs_support.html'); ?>"><span class="icon iconfont">&#xf209;</span><span class="top_help_font"><?php echo FS_NEED_HELP_BIG; ?></span></a>
						<div class="header_help_more">
							<div class="header_sign_more_arrow"></div>
							<div class="header_help_more_main">
								<div class="header_help_more_main_con livechat">
									<span class="icon iconfont">&#xf209;</span>
									<h2 class="header_help_more_main_con_tit"><?php echo FS_CHAT_LIVE_WITH_US; ?></h2>
                                    <?php if(get_curr_time_section()==1){ ?>
                                        <a class="header_help_more_main_con_href" href="<?php echo reset_url('solution_support.html'); ?>" target="_blank"><?php echo FS_LIVE_CHAT; ?></a>
                                    <?php }else{ ?>
                                        <?php if ($_SESSION['languages_code'] == 'jp' && (!isMobile())){?>
                                            <a class="header_help_more_main_con_href" href="javascript:;" onclick="LC_API.open_chat_window();return false;"><?php echo FS_LIVE_CHAT_MOBILE; ?></a>
                                        <?php }else{?>
                                        <a class="header_help_more_main_con_href" href="javascript:;" onclick="LC_API.open_chat_window();return false;"><?php echo FS_LIVE_CHAT; ?></a>
                                        <?php }?>
                                    <?php } ?>
                                  </div>

								<div class="header_help_more_main_con email">
									<span class="icon iconfont">&#xf205;</span>
									<h2 class="header_help_more_main_con_tit"><?php echo FS_CHAT_LIVE_WITH_GET; ?></h2>
									<a class="header_help_more_main_con_href more_main_con_href_only" href="<?php echo reset_url('solution_support.html');?>"><?php echo FS_CHAT_LIVE_WITH_GET_A; ?></a>
								</div>
								
								
								<div class="header_help_more_main_con email">
									<span class="icon iconfont">&#xf130;</span>
									<h2 class="header_help_more_main_con_tit"><?php echo FS_SEND_US_A_MESSAGE; ?></h2>
									<a class="header_help_more_main_con_href" href="<?php echo reset_url('live_chat_service_mail.html'); ?>"><?php echo FS_E_MAIL_NOW; ?></a>
								</div>
								
								<div class="header_help_more_main_con phone">
									<span class="icon iconfont">&#xf005;</span>
									<h2 class="header_help_more_main_con_tit"><?php echo FS_WANT_TO_CALL; ?></h2>
									<p class="header_help_more_main_con_txt"><?php echo $common_phone;?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="top_right_line"></div>
					    <div class="top_country">
						<span class="top_country_flag <?php echo $country_code; ?> first"></span>
						<span class="top_country_language"><?php echo $default_country_name;?></span>
						<span class="icon iconfont down_arrow">&#xf087;</span>
						<div class="top_country_more">
							<div class="header_sign_more_arrow"></div>
							<div class="top_country_more_main">
								<h2 class="top_country_more_main_smalltit"><?php echo FS_COUNTRY_REGION;?></h2>
								<div class="top_country_choose_country active">
									<em id="current_code" data-class="country_code" class="<?php echo $country_code; ?>"></em>
									<p class="country_name show"><?php echo $default_country_name; ?></p>
									<span class="showMore icon iconfont">&#xf087;</span>
									
								</div>
								<div class="top_country_searchCountry" style=" display:block;">
									<div class="top_country_search_block">
										<input type="text" class="top_country_search_input" placeholder="<?php echo FS_COUNTRY_SEARCH;?>">
										<!-- <span class="icon iconfont">&#xf081;</span> -->
									</div>
									<ul class="top_country_countryList">
										<?php echo get_all_country_info($_SESSION['languages_code'],'');?>
									</ul>
								</div>
							
								<h2 class="top_country_more_main_smalltit"><?php echo FS_NEW_LANGUAGE_CURRENCY;?></h2>
								<div class="top_country_choose_currency">
									<p class="top_country_choose_currency_name">
									<span data-country="<?php echo $siteCoutCode;?>" data-currency="<?php echo $_SESSION['currency'];?>"><?php echo $local_language;?></span> / <em><?php echo $default_currency;?></em></p>
									<span class="showMore icon iconfont">&#xf087;</span>
									
								</div>
								<div class="top_country_choose_currency_choose">
									<ul class="top_country_choose_currency_choose_ul">
										<?php echo $mc_html;?>
									</ul>
									
								</div>
								<div class="top_country_more_main_save_fa">
									<div class='top_country_more_main_save_fa_son'></div>
									<a class="top_country_more_main_save" href="javascript:;" onclick="news_choose_country_second('<?php echo $siteCoutCode;?>',0)"><?php echo FS_COMMON_SAVE;?></a>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
		    <?php if(in_array($MyBrowserType,$NeedUpdateArr)){ ?>
			<div class="new_popup update browser_tip" style="display:block;">
					<div class="new_popup_bg"></div>
					<div class="new_popup_main popup_width680 popup_update">
						<span class="icon iconfont new_popup_close" onclick="$('.browser_tip').hide()">&#xf092;</span>
						<h2 class="new_popup_tit"><?php echo FS_UPGRADE;?></h2>
						<p class="new_popup_txt"><?php echo FS_UPGRADE_TIP;?></p>
						<div class="popup_update_browser">
							<div class="popup_update_browser_con chrome">
								<a href="https://www.google.com/chrome/">
									<span></span>
									<p><?php echo BROWSER_CHROME;?></p>
								</a>
							</div>
							<div class="popup_update_browser_con firefox">
								<a href="https://www.mozilla.org/firefox/">
									<span></span>
									<p><?php echo BROWSER_FIREFOX;?></p>
								</a>
							</div>
							<div class="popup_update_browser_con ie_new">
								<a href="https://support.microsoft.com/help/17621/internet-explorer-downloads">
									<span></span>
									<p><?php echo BROWSER_IE;?></p>
								</a>
							</div>
							<div class="popup_update_browser_con ie_edge">
								<a href="https://www.microsoft.com/windows/microsoft-edge">
									<span></span>
									<p><?php echo BROWSER_EDGE;?></p>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php }?>		
        </div>

        <!-- 导航、搜索 -->
        <div class="header <?php if(!$this_is_home_page){ echo 'header_other_page'; }?> ">
            <?php require_once('includes/templates/fiberstore/widgets/common_header_nav.php'); ?>
        </div>
        <?php if(false){
            $version = fs_get_total_from_db('categories_index_menu','categories_id = '.$current_category_id.' and languages_id = '.$_SESSION['languages_id'].' and type = 0');
            if($version > 0){?>
                <?php require($template->get_template_dir('widgets_index_categories_banner.php',DIR_WS_TEMPLATE, $current_page_base,'widgets'). '/'.'widgets_index_categories_banner.php');?>
                <div class="menu">
                    <?php if($menu_data){
                        $first_menu_name = zen_get_categories_name($current_category_id);
                        echo '<div class="menu_crumbs class-Bread-crumbs"><div class="back_Home"><meta itemprop="title" content="Home"><a itemprop="url" href="' . zen_href_link('index'). '"><span>'.FS_BREADCRUMB_HOME.'</span><i></i></a></div>';
                        echo '<div class="menu_all">
                            <a href="javascript:;" class="index_menu" >
                            '.$first_menu_name.'
                            </a>
                        </div></div>';
                    } ?>
                </div>
            <?php }else{?>
                <div class="menu">
                    <?php if($menu_data){
                        foreach($menu_data as $menu_key => $menu){
                            if( $menu_key==0 ){
                                $first_menu_name = zen_get_categories_name($current_category_id);
                                echo '<div class="menu_crumbs"><div class="back_Home"><meta itemprop="title" content="Home"><a itemprop="url" href="' . zen_href_link('index'). '"><span>'.FS_BREADCRUMB_HOME.'</span><i></i></a></div>';
                                echo '<div class="menu_all">
                                <a href="javascript:;" class="index_menu" >
                                '.$first_menu_name.'
                                </a>
                            </div></div><ul>';
                            }else{
                                if($menu[0] != '' && $menu[1] != ''){
                                    echo '<li><a href="'.reset_url($menu[1]).'">'.$menu[0].'</a></li>';
                                }
                            }
                        }
                        echo '</ul>';
                    } ?>
                </div>
            <?php } ?>
        <?php } ?>

    <?php } else{
        if($this_is_home_page){ ?>
            <script src="includes/templates/fiberstore/jscript/rem.js"></script>
        <?php } ?>
<!--        <link href="includes/templates/fiberstore/css/public.css" media="all" type="text/css" rel="stylesheet">-->
        <div class="m_header <?php echo $this_is_home_page && intval($_COOKIE['covid_c']) == 0 ? 'covid_show_s' : '';?>">
            <div class="m_header_main  <?php if (!$this_is_home_page){ echo "active1"; }?>">
                <!-- 最顶部 -->
<!--                --><?php //if($this_is_home_page && intval($_COOKIE['covid_c']) == 0){?>
<!--                    <div class="m-covid-information covid_general">-->
<!--                        <a href="javascript:;"><span>--><?php //echo FS_NOTICE_HEADER_COMMON_TIPS;?><!--</span></a>-->
<!--                        <icon class="icon iconfont m-covid-information-close covid_close">&#xf092;</icon>-->
<!--                    </div>-->
<!--                --><?php //}?>
                <div class="home_header_Country">
                    <a href="<?php echo reset_url('shipping_delivery.html');?>">
                        <p class="home_header_Shipping"><?php echo $header_free_shipping_str; ?></p>
                    </a>
					<p class="home_header_Country_right header_country_m_swtich">
                        <i class="m-countryFlag-icon">
                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/mCountry-flag/ic_<?php echo $country_code?>.png" height="18">
                        </i>
                        <a class="" href="javascript:;"><?php echo $default_country_name; ?>
                        </a>
                        <span class="iconfont icon">&#xf087;</span>
					</p>
				</div>

                <!-- 顶部 -->
                <div class="header_top">
                    <div class="header_top_list close_side">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                    <a class="header_top_logo" itemprop="url" href="<?php echo zen_href_link(FILENAME_DEFAULT,'','SSL');?>">
                        <?php if($this_is_home_page) echo '<h1></h1>';?>
                    </a>
                    <!-- <a href="javascript:;" class="header_country_code"> -->
                        <?php
                        // 有些国家字母缩写需要改变指定值，在下面添加即可
                        // switch ($country_code){
                        //     case 'gb':
                        //         $country_code='uk';
                        //         break;
                        // }
                        // echo strtoupper($country_code);
                        ?>
                    <!-- </a> -->
                    <span class="iconfont icon m_header_proSearch_btn">&#xf335;</span>
                    <div class="m_cart">
                        <?php  echo $shopping_cart_help->show_cart_products_block($cart_items,1);?>
                    </div>
                </div>

                <!-- 搜索 -->
                <!-- <div class="m_header_search" style="display:none;">
                    <span class="icon iconfont">&#xf143;</span>
                    <input type="text" placeholder="<?php echo FS_HEADER_SEARCH;?>..." />
                </div> -->
                <!-- 搜索块 -->
                <div class="m_search_main">
                    <div class="m_search_main_top">
<!--                        <em class="icon iconfont">&#xf090;</em>-->
                        <div class="m_search_main_search">
                            <span class="icon iconfont">&#xf335;</span>
                            <form action="<?php echo zen_href_link(FILENAME_DEFAULT);?>" id="search_phone" onsubmit="return search_word()">
                                <?php  echo zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);?>
                                <input type="search" value="<?php echo $common_default_search_key; ?>" name="keyword" id="CityAjax_phone" placeholder="<?php echo FS_HEADER_01;?>"  autocomplete="off" onblur="cityAjax_blur(this,'<?php echo FS_HEADER_SEARCH; ?>')">
                                <input type="submit"  value="<?php echo FS_HEADER_SEARCH;?>" name="searchSubmit" class="header_03_02">
                                <i class="icon iconfont" id="clear_word">&#xf092;</i>
                            </form>
                            <em class="m_search_cancelTxt"><?php echo FS_EMAIL_SUBSCRIPTION_14;?></em>
                            <div class="m_ac_results" style="display:none;">
                            </div>
                        </div>
                    </div>

                    <!-- 旧版 m端搜索 -->
                    <div class="m_search_main_box" <?php if (in_array($_SESSION['languages_code'], array('en', 'au', 'uk', 'dn'))) { echo 'style="display:none;"';}else { echo 'style="display:block"'; } ?>>
                        <!-- 热门搜索 -->
                        <div class="m_search_main_box_con">
                            <h2 class="m_search_main_tit">
                                <?php echo FS_HEADER_02;?>
                            </h2>
                            <div class="m_search_main_box_con_main">
                                <?php foreach($m_common_hot_search as $key => $val){ ?>
                                    <a class="m_search_hotword" href="<?php echo reset_url($val);?>"><?php echo $key;?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="m_search_main_box_line"></div>
                        <?php
                        // 搜索历史
                        if(sizeof(unserialize($_COOKIE['keyword_code']))>0 && isset($_COOKIE['keyword_code'])){
                            ?>
                            <div class="m_search_main_box_con">
                                <h2 class="m_search_main_tit">
                                    <?php echo FS_HEADER_11;?>
                                    <span class="iconfont icon m_search_sinDel_icon" onclick="cityAjax_phone_event('<?php echo zen_get_appoint_language_link("");?>')">&#xf027;</span>
                                </h2>
                                <div class="m_search_main_box_con_main">
                                    <?php
                                    $arr = $_COOKIE['keyword_code'];
                                    $search_arr =unserialize($arr);
                                    for($i=0;$i<10;$i++){
                                        $search =$Encryption->_decrypt($search_arr[$i]);
                                        if ($search){
                                            echo '<a class="m_search_historyword" href="'.zen_href_link('advanced_search_result','&keyword='.$search).'">'.$search.'</a>';
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- <a class="m_search_del" href="javascript:;"  onclick="cityAjax_phone_event('<?php echo zen_get_appoint_language_link("");?>')" >
                                    <span class="icon iconfont">&#xf027;</span>
                                    <span ><?php echo FS_HEADER_12;?></span>
                                </a> -->
                            </div>
                        <?php }?>
                    </div>
                    <!-- 旧版 m端搜索 -->


                    <!--开始 新版m端搜索 开始-->
                    <div class="fs_search_default_m" <?php if (in_array($_SESSION['languages_code'], array('en', 'au', 'uk', 'dn'))) { echo 'style="display:block"';}else { echo 'style="display:none"'; } ?> >
                        <div class="fs_search_default">
                            <?php
                            //最近搜索
                            $recent_researches = isset($_COOKIE['recent_searches']) ? $_COOKIE['recent_searches'] : [];
                            if (!empty($recent_researches)) {
                                $recent_researches = json_decode($recent_researches, true);
                            }

                            $current_language_id = $_SESSION['languages_id'];
                            if($_SESSION['languages_code'] == 'au' || $_SESSION['languages_code'] == 'uk' || $_SESSION['languages_code'] == 'dn'){
                                $current_language_id = 1;
                            }
                            //热搜
                            $sql = "select hot_search_id,search_word,weight,search_type from hot_search where language_id=".$current_language_id." order by search_type asc,weight desc limit 0,8";
                            $hot_searches = $db->getAll($sql);
                            if (empty($hot_searches)) {
                                $hot_searches = [];
                            }
                            if (count($hot_searches) > 0) {
                                foreach ($hot_searches as $key => $value) {
                                    //对展示的hot search的次数加1
                                    $db->Execute("update hot_search set show_times=show_times+1 where hot_search_id='".$value['hot_search_id']."' and language_id='".$current_language_id."'");
                                }
                            }
                            ?>
                            <dl class="fs_search_default_dl fs_recent_search" <?php if (count($recent_researches) <= 0) { echo 'style="display:none;"';}else{ echo 'style="display:block;"';} ?> >
                                <dt><?php echo FS_RECENT_SEARCH;?></dt>
                                <dd>
                                    <?php if (count($recent_researches) > 0) {?>
                                        <?php foreach ($recent_researches as $key => $value) {?>
                                        <a target="_blank" href="?main_page=advanced_search_result&keyword=<?php echo $value;?>&searchSubmit=Search">
                                            <?php echo $value;?>
                                            <i class="iconfont icon" onclick="remove_recent_search(this, '<?php echo $value;?>')"></i>
                                        </a>
                                        <?php }?>
                                    <?php }?>
                                </dd>
                            </dl>
                            <div class="fs_m_border"></div>
                            <dl class="fs_search_default_dl fs_hot_search">
                                <dt>
                                    <?php echo FS_HOT_SEARCH;?>
                                    <a href="javascript:;" onclick="change_hot_search(this)">
                                        <i class="iconfont icon"></i>
                                        <span><?php echo FS_CHANGE;?></span>
                                    </a>
                                </dt>
                                <dd>
                                    <?php if (count($hot_searches) > 0) {?>
                                        <?php foreach ($hot_searches as $key => $value) {?>
                                            <a target="_blank" data-page="1" href="?main_page=advanced_search_result&keyword=<?php echo $value['search_word'];?>&searchSubmit=Search"><?php echo $value['search_word'];?></a>
                                        <?php }?>
                                    <?php }?>
                                </dd>
                            </dl>
                        </div>
                        <div class="real_time_results" style="display:none;">
                            <ul class="real_time_results_ul">

                            </ul>
                        </div>
                    </div>
                    <!--结束 新版m端搜索 结束-->

                </div>
                <!-- 导航 -->
                <div class="header_sidebar">
                    <!--第一级（初始菜单）-->
                    <div class="header_sidebar_first">
                        <div class="header_sidebar_first_country_account">
                            <?php if(!check_login_id()){?>

                                <div class="header_sidebar_first_account" language_code="<?php echo $_SESSION['languages_code']=='dn' ? 'de-en' : $_SESSION['languages_code'] ?>">
                                    <div class="header_sidebar_btmLine">
                                        <a href="javascript:;">
                                            <em class="icon iconfont">&#xf336;</em>
                                            <span><?php echo FS_ACCOUNT;?> / <?php echo FS_SIGN_IN;?></span>
                                            <i class="icon iconfont">&#xf089;</i>
                                        </a>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="header_sidebar_first_account is_login">
                                    <div class="header_sidebar_btmLine">
                                        <a href="javascript:;">
                                            <em class="icon iconfont">&#xf336;</em>
                                            <span><?php echo $common_current_username;?></span>
                                            <i class="icon iconfont">&#xf089;</i>
                                        </a>
                                    </div>
                                </div>
                            <?php }?>
                            <!-- <div class="header_sidebar_first_country">
                                <a href="javascript:;">
                                    <em class="flag <?php echo $country_code; ?>"></em>
                                    <span><?php echo $default_country_name; ?></span>
                                    <i class="icon iconfont">&#xf089;</i>
                                </a>
                            </div> -->
                        </div>
                        <!--显示allcategory-->
                        <?php echo fiberstore_category::show_categories_phone_home_first()?>
                        <!--显示help-string-->
                        <?php echo fiberstore_category::show_help_string_phone_home_first()?>
                        <div class="header_sidebar_contactBox">
                            <div class="header_sidebar_contactMain">
                                <div class="header_sidebar_contactCell">
                                    <a href="<?php echo reset_url('solution_support.html');?>">
                                        <div class="header_sidebar_contact_Icbox">
                                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/home/bottom_email.svg" width="36" >
                                        </div>
                                        <p class="header_sidebar_contactTxt"><?php echo FS_AMP_FOOTER_01; ?></p>
                                    </a>
                                </div>
                                <div class="header_sidebar_contactCell">
                                    <a href="tel:<?php echo $common_phone; ?>">
                                        <div class="header_sidebar_contact_Icbox">
                                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/home/bottom_phone.svg" width="36" >
                                        </div>
                                        <p class="header_sidebar_contactTxt"><?php echo $common_phone; ?></p>
                                    </a>
                                </div>
                                <div class="header_sidebar_contactCell">
                                    <a  onclick="LC_API.open_chat_window();return false;" href="javascript:;">
                                        <div class="header_sidebar_contact_Icbox">
                                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/home/bottom_chat.svg" width="36" >
                                        </div>
                                        <p class="header_sidebar_contactTxt"><?php echo FS_AMP_FOOTER_02; ?></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--第二级菜单（专供登陆后的模块）-->
                    <div class="header_sidebar_second show_for_login">
                        <div class="header_sidebar_second_tofirst" style="cursor:pointer"><i class="icon iconfont">&#xf090;</i><?php echo MAIN_MENU; ?></div>
                        <div class="header_sidebar_second_list">
                            <!--登录后的模块-->
                            <ul>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MY_DASHBOARD,'','SSL')?>"><i class="icon iconfont account">&#xf145;</i><?php echo FS_MY_ACCOUNT;?>
                                        <?php
                                        if($_SESSION['customers_number_new']){
                                        ?>
                                        <span class="Numbering-span">
                                        <?php
                                        echo '('.FS_ACCOUNT_NO.'#'.$_SESSION['customers_number_new'].')';
                                        ?>
                                        </span>
                                        <?php
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_EDIT_MY_ACCOUNT,'','SSL')?>"><i class="icon iconfont account">&#xf230;</i><?php echo FS_ACCOUNT_SETTING;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'','SSL')?>"><i class="icon iconfont account">&#xf103;</i><?php echo FS_ORDER_HISTORY;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('orders_review_list','','SSL')?>"><i class="icon iconfont account">&#xf419;</i><?php echo FS_ACCOUNT_ORDER_REVIEWS_COUNT;?></a>
                                </li>
                                <!--
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MANAGE_ADDRESSES,'','SSL')?>"><i class="icon iconfont account">&#xf106;</i><?php echo FS_ADDRESS_BOOK;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MY_CASES,'','SSL')?>"><i class="icon iconfont account">&#xf126;</i><?php echo FS_MY_CASES;?></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_INQUIRY_LIST,'','SSL')?>"><i class="icon iconfont account">&#xf217;</i><?php echo FS_INQUIRY_LIST_1;?></a>
                                </li>
                                -->
                                <li>
                                    <a href="<?php echo zen_href_link('quotes_list','click_type=17&status=1','SSL'); ?>">
                                        <i class="icon iconfont account">&#xf217;</i>
                                        <?php echo FS_INQUIRY_LIST_2;?>
                                        <?php
                                        //add by ternence 新报价单数量
                                        $quote_type=0;
                                        if(check_login_id()){
                                            $quote_type = get_quote_checked_type_number();
                                        }
                                        if((int)$quote_type>0 || $inquiry_count>0){
                                            ?>
                                            <em class="header_number quote_a_number"><?php echo (int)$quote_type>0?$quote_type:$inquiry_count; ?></em>
                                        <?php } ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('saved_items','type=saved_carts','');?>">
                                        <i class="icon iconfont account">&#xf157;</i>
                                        <?php echo FS_SAVED_CARTS;?>
                                        <?php
                                        $saved_carts_num=0;
                                        if(check_login_id()){
                                            $saved_carts_num = get_save_cart_data(' customer_id ='.$_SESSION['customer_id'],false);
                                        }
                                        if($saved_carts_num > 0){?>
                                            <em class="header_number quote_a_number"><?php echo $saved_carts_num;?></em>
                                        <?php } ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('browsing_history','','SSL');?>">
                                        <i class="icon iconfont account">&#xf323;</i>
                                        <?php echo FS_BROWSING_HISTORY;?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="header_sidebar_second_sign_out">
                            
                            <a href="<?php echo zen_href_link(FILENAME_LOGOFF,'','NONSSL');?>">
                                <i class="icon iconfont">&#xf236;</i>
                                <span><?php echo FS_SIGN_OUT;?></span>
                            </a>
                        </div>
                    </div>
                    <!--第二级菜单（第二级分类，单页面）-->
                    <div class="header_sidebar_second show_for_others">
                        <?php echo fiberstore_category::show_phone_second_third_all_categories();?>
                    </div>
                </div>

            </div>
        </div>

        <!--  国家选择  -->
        <div class="index_wap_country" style="display: block;">
			<div class="country_bg"></div>
			<div class="country_overflow_container">
				<div class="index_wap_country_tit">
					<span class="icon iconfont index_wap_country_back">
						<div class="header_top_list active">
							<i class="iconfont icon">&#xf092;</i>
						</div>
					</span>
					<h1><?php echo FS_SELECT_COUNTRY_REGION; ?></h1>
				</div>
				 <div class="index_wap_country_main" style="height: 686px;">
						<div class="index_wap_country_main_sure">
							<a href="javascript:;">
								<span class="index_wap_country_list_name">
									<i class="m-countryFlag-icon">
										<img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/mCountry-flag/ic_<?php echo $country_code?>.png" height="18">
									</i>
									<!-- <em class="flag  <?php echo $country_code; ?>"></em> -->
									<i  data-country="<?php echo $country_code; ?>"><?php echo $default_country_name; ?></i>
								</span>
								<b class="icon iconfont">&#xf089;</b>
							</a>
						</div>
						<div class="index_wap_country_main_country">
							<div class="country_main_country_tit after">
								<a href="javascript:;" class="country_main_country_btn_left" ><i class="iconfont icon">&#xf090;</i></a>
								<a href="javascript:;" class="country_main_country_btn_right" ><i class="iconfont icon">&#xf092;</i></a>
							</div>
							<div class="country_main_country_overflow">
								<div class="index_wap_country_main_search">
									<div class="index_wap_country_search_main">
										<input type="text" placeholder="<?php echo FS_SELECT_COUNTRY_REGION; ?>" class="index_wap_country_search_main_ipt" />
										 <span class="icon iconfont">&#xf335;</span>
									</div>
								</div>
								<ul class="after">
									<?php echo get_all_country_info($_SESSION['languages_code'],$is_moblie_type =true);?>
								</ul>
							</div>
							
						</div>
						<div class="index_wap_currency_main_sure">
							<a href="javascript:;">

								<span class="index_wap_country_list_name">
									<em class="icon iconfont">&#xf271;</em><i data-area="<?php echo $code;?>" data-currency="<?php echo $_SESSION['currency'];?>"><?php echo $local_language;?> / <?php echo $default_currency;?></i>
								</span>
								<?php if(sizeof($mc_languages) != 1){?>
								<b class="icon iconfont">&#xf087;</b>
								<?php }?>
							</a>
						</div>
						<div class="index_wap_country_main_currency">
							<ul class="after">
								<?php echo $wap_html;?>
							</ul>
						</div>
						<div class="index_wap_country_main_btn">
							<a href="javascript:;" class="top_country_more_main_save" onclick="news_choose_country_second('<?php echo $siteCoutCode;?>',1)"><?php echo FS_COMMON_SAVE;?></a>
						</div>

				</div>
	    </div>
		</div>
    <?php }} ?>
<script type="text/javascript">
    var oTopCountrySearch = "<?php echo FS_COUNTRY_SEARCH; ?>";
    var main_page_str = "<?php echo $_GET['main_page']; ?>";
    var shopping_jump_url = "<?php echo zen_href_link('shopping_cart');?>";
    var isMobileJs = "<?php echo $common_is_mobile;?>";
    var siteCodeJs = "<?php echo $code;?>";
    var common_phone = "<?php echo $common_phone;?>";
</script>
<?php $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']:'';
if(strpos($url,'localhost')  || strpos($url,'www.fs.com')){
    $url="";
} ?>
<script type="text/javascript">
    var c_site = "<?php echo $_COOKIE['c_site']?>";
    var wap_code ="<?php echo $code;?>";

    // Start of LiveChat (www.livechatinc.com) code
    var countryCode = "<?php echo $_SESSION['user_ip_info']['ipCountryCode']; ?>";
    var code_array = ["BY", "BI", "CF","CU","CG","IR","Iraq","LB","LY","KP","SO","SD","SS","SY","CRIMEA.RU","VE","YE","ZW","NI"];
    if(jQuery.inArray(countryCode,code_array)==-1) {
        window.__lc = window.__lc || {};
        window.__lc.license = 9563165;
        <?php if($_SESSION['languages_id']==1){ //en ?>
        window.__lc.group = 8;
        <?php }elseif($_SESSION['languages_id']==2){ //es ?>
        window.__lc.group = 10;
        <?php }elseif($_SESSION['languages_id']==3){ //fr ?>
        window.__lc.group = 12;
        <?php }elseif($_SESSION['languages_id']==4){ //ru ?>
        window.__lc.group = 11;
        <?php }elseif($_SESSION['languages_code']=='de'){ //de ?>
        window.__lc.group = 9;
        <?php }elseif($_SESSION['languages_code']=='dn'){ //de ?>
        window.__lc.group = 16;
        <?php }elseif($_SESSION['languages_id']==8){ //jp ?>
        window.__lc.group = 13;
        <?php } ?>

        (function() {
            var lc = document.createElement('script');
            lc.type = 'text/javascript';
            lc.async = true;
            lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
    }
    <?php //等后期js公共出来，在转移到公共的js中 ?>
    function checkSearhEmpty(){
        if($.trim($('#CityAjax').val()) == ''){
            console.log('false');
            return false;
        }else{
            if (typeof _faq !== 'undefined') {
                //add by ternence
                _faq.push(['trackEvent', 'main_search_click', {"content": $('#CityAjax').val()}, 1]);
            }
            return true;
        }
    }

    var emptyCartHtml = '<b class="no_add_cart"><?php echo FIBERSTORE_SHOPPING_HELP;?></b>';
    $("#ShoppingCartInfo").hover(function(){
        if($('.top_cart_num').length){
            if($("#ShoppingCartInfo #loader_order_alone.loading_products").length){
                $.ajax({
                    url:"ajax_shopping_cart.php?request_type=showTopCart",
                    type:"POST",
                    dataType:"json",
                    success:function(msg){
                        $("#shopping_cart").html(msg.cartHtml);
                        if(!msg.cartItems){
                            $("#ShoppingCartInfo .top_cart_num").remove();
                            $('.top_cart_more_main').addClass('no_goods');
                        }else{
                            $('.top_cart_more_main').removeClass('no_goods');
                        }
                    }
                });
            }
        }else{
            $("#shopping_cart").html(emptyCartHtml);
            $('.top_cart_more_main').addClass('no_goods');
        }

    });
</script>
<script>
    var is_mobile ='<?php echo $is_mobile ?>';
    if(is_mobile !=""){
        var header_sidebar_data = '<?php //echo success(1, fiberstore_category::show_phone_second_third_all_categories()); ?>';
    }
</script>
<?php
    function success($code, $data){
        if (!$code) {
            $code = 1;
        }
        return json_encode($data);
    }
?>

<script src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/header.js');?>"></script>
