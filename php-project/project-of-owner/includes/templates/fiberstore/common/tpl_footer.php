<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
    // 判断是否是欧盟国家
    $footer_is_german_warehouse = all_german_warehouse('country_code', $_SESSION['countries_iso_code']);

    //第3方
    $footer_third_data_en = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292;'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com', 'icon' => '&#xf338;'),
    );
    $footer_third_data_fr = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292;'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com/fr', 'icon' => '&#xf338;'),
    );

    $footer_third_data_es = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292;'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com/es', 'icon' => '&#xf338;'),
    );

    $footer_third_data_sg = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com', 'icon' => '&#xf338;'),
    );

    $footer_third_data_jp = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com/jp', 'icon' => '&#xf338;'),
    );

    $footer_third_data_ru = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292'),
        'facebook' => array('link' => sourceHtml('facebook', false), 'icon' => '&#xf286;'),
        'vk' => array('link' => 'https://vk.com/fiberstore', 'icon' => '&#xf298;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com/ru', 'icon' => '&#xf338;'),
    );
    $footer_third_data_de = array(
        'linkedin' => array('link' => sourceHtml('linkedin', false), 'rel' => 'nofollow', 'icon' => '&#xf289;'),
        'instagram' => array('link' => sourceHtml('instagram', false), 'rel' => 'publisher', 'icon' => '&#xf292;'),
        'facebook' => array('link' => 'https://www.facebook.com/FSCOMofficial/', 'icon' => '&#xf286;'),
        'twitter' => array('link' => sourceHtml('twitter', false), 'icon' => '&#xf287;'),
        'pinterest' => array('link' => sourceHtml('pinterest', false), 'icon' => '&#xf290;'),
        'youtube' => array('link' => sourceHtml('youtube', false), 'icon' => '&#xf288;'),
        'community' => array('link' => 'https://community.fs.com/de', 'icon' => '&#xf338;'),
    );


    switch ($_SESSION['languages_code']) {
        case 'es':
        case 'mx':
            $footer_third_data = $footer_third_data_es;
            break;
        case 'sg':
            $footer_third_data = $footer_third_data_sg;
            break;
        case 'fr':
            $footer_third_data = $footer_third_data_fr;
            break;
        case 'jp':
            $footer_third_data = $footer_third_data_jp;
            break;
        case 'ru':
            $footer_third_data = $footer_third_data_ru;
            break;
        case 'de':
            $footer_third_data = $footer_third_data_de;
            break;
        default:
            $footer_third_data = $footer_third_data_en;
            break;
    }


    if ($common_is_mobile) { //手机站
        //版 权信息
        $footer_copyright_str = str_replace('YEAR', date('Y', time()), FS_FOOTER_COPYRIGHT_M);
    } else {
        //是否免税
        $footer_free_shipping_str = zen_free_shipping_str('footer');
        //版权信息
        $footer_copyright_str = str_replace('YEAR', date('Y', time()), FS_FOOTER_COPYRIGHT);
    }
    //把公司名称换成对应站点名称
    $company_name = get_company_name();
    $footer_copyright_str = str_replace(FS_LOCAL_COMPANY_NAME,$company_name,$footer_copyright_str);

    $footer_data = [];
    $warehouse = get_site_warehouse_str();
    $footer_key = $_SESSION['currency'].$warehouse;
    //获取首页数据
    require_once('includes/classes/homePageClass.php');
    $home_page = new homePageClass(['language_id' => $_SESSION['languages_id']]);
    if($_SERVER['SERVER_NAME'] == "www.fs.com"){
        $footer_data = get_redis_key_value($footer_key,FS_SITE_UNIQUE_LANGUAGE_ID.'_footer_data_'.$_SESSION['countries_iso_code']);
    }

    if(!$footer_data){
        $footer_data = $home_page->get_header_or_footer_data(2);
        set_redis_key_value($footer_key, $footer_data,0,FS_SITE_UNIQUE_LANGUAGE_ID.'_footer_data_'.$_SESSION['countries_iso_code']);
    }
    if (!$common_is_mobile) { //pc
        ?>
        <div class="fs_public_footer">
            <div class="fs_width1420">
                <ul class="fs_footer_flex_ul">
                    <?php if(sizeof($footer_data)){
                        foreach ($footer_data as $key => $value){
                            ?>
                            <li class="fs_footer_flex_li">
                                <dl class="fs_footer_flex_dl">
                                    <dt><?php echo $value['title'];?></dt>
                                    <?php
                                    if(sizeof($value['data']['list'])){
                                        foreach ($value['data']['list'] as $data){
                                            ?>
                                            <dd>
                                                <?php if($data['img']){ ?>
                                                    <i class="iconfont iocn"><img src="<?php echo HTTPS_IMAGE_SERVER.$data['img'];?>"></i>
                                                <?php }?>
                                                <a class="fs_footer_a" href="<?php echo $data['url'];?>" <?php echo $data['is_click'];?>><?php echo $data['title'];?></a>
                                            </dd>
                                            <?php
                                        }
                                    }
                                    if(sizeof($value['data']['button'])){
                                        foreach ($value['data']['button'] as $data){
                                            ?>
                                            <dd>
                                                <?php if($data['img']){ ?>
                                                    <i class="iconfont iocn"><img src="<?php echo HTTPS_IMAGE_SERVER.$data['img'];?>"></i>
                                                <?php }?>
                                                <a class="fs_footer_dl_a" href="<?php echo $data['url'];?>" <?php echo $data['is_click'];?>><?php echo $data['title'];?></a>
                                            </dd>
                                            <?php
                                        }
                                    }
                                    ?>
                                </dl>
                            </li>
                            <?php
                        }
                    }?>
                    <li class="fs_footer_flex_li">
                        <dl class="fs_footer_flex_dl">
                            <dt><?php echo FS_EMAIL_SUBSCRIPTION_FOOTER_01;?></dt>
                            <dd>
                                <div class="new_footer_main_list_third">
                                    <div class="footer_subscribe_inp_box">
                                        <input class="footer_subscribe_inp" onkeyup="this.value=this.value.replace(/[, ]/g,'')" id="subscription_footer_input" type="text" placeholder="<?php echo FS_EMAIL_SUBSCRIPTION_FOOTER_03;?>" name="subscription_footer_input">
                                        <div class="icon iconfont footer_arrow_right " id="subscription_footer_submit">&#xf089;</div>
                                        <div class="error_prompt email_subscription_error_prompt"></div>
                                    </div>

                                    <div class="iconfont_container">
                                        <?php foreach ($footer_third_data as $key => $val) {
                                            if($key != 'community'){
                                                ?>
                                                <a class="footer_main_list_third_a icon iconfont"
                                                   title="<?php if ($_SESSION['languages_code'] == 'ru' && $key == 'vk') { echo 'FS ' . strtoupper($key);} else{ echo 'FS ' . ucfirst($key); } ?>"
                                                   target="_blank" href="<?php echo $val['link']; ?>" rel="noreferer noopener <?php echo $val['rel'];?>"><?php echo $val['icon']; ?></a>
                                                <?php
                                            }
                                        } ?>
                                    </div>
                                    <!--<a class="explore_a" target="_blank" href="<?php /*echo $footer_third_data['community']['link']; */?>"><?php /*echo FS_PRODUCT_COMMUNITY_01;*/?><i class="iconfont icon">&#xf089;</i></a>-->
                                    <p class="new_acc_sub_p mobile_apps"><i class="iconfont icon">&#xf409;</i><a href="<?php echo zen_href_link('appdownload');?>"><?php echo FS_EMAIL_SUBSCRIPTION_FOOTER_07;?></a></p>
                                </div>
                            </dd>
                        </dl>
                    </li>
                </ul>
                <div class="fs_bottom_explain">
                    <p class="fs_bottom_explain_txt">
                        <?php echo $footer_copyright_str . ($_SESSION['languages_code'] == 'sg' ? '30A Kallang Pl, #11-10/11/12, Singapore 339213' : ''); ?>
                    </p>
                    <p class="fs_bottom_explain_txt">
                        <?php if($_SESSION['languages_code'] == 'au'){?>
                            <a href="<?php echo reset_url('contact_us.html') ?>">ABN 71 620 545 502</a>
                            <em>|</em>
                        <?php }?>
                        <a href="<?php echo reset_url('policies/privacy_policy.html') ?>">
                            <?php if ($footer_is_german_warehouse) {
                                echo FS_PRIVACY_AND_POLICY;
                            } else {
                                echo FS_POLICY;
                            } ?>
                        </a>
                        <em>|</em>
                        <a href="<?php echo reset_url('policies/terms_of_use.html'); ?>">
                            <?php if ($footer_is_german_warehouse) {
                                echo FS_TERMS_OF_USE_DE;
                            } else {
                                echo FS_TERMS_OF_USE;
                            } ?>
                        </a>
                        <em>|</em>
                        <a href="<?php echo reset_url("site_map.html"); ?>"><?php echo FS_SITE_MAP; ?></a>
                    </p>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="m_2017footer">
            <?php //require_once('includes/templates/fiberstore/widgets/common_footer_left.php'); ?>
            <div class="m_footer_03">
                <?php if(sizeof($footer_data)){
                    foreach ($footer_data as $key => $value){
                        ?>
                        <div class="m_footer_03_one">
                            <div class="m_footer_03_inner"><a href="javascript:;"><span><?php echo $value['title'];?></span><i class="icon iconfont footer_category"></i></a></div>
                            <div class="m_footer_03_two">
                                <?php
                                if(sizeof($value['data']['list'])){
                                    foreach ($value['data']['list'] as $data){
                                        ?>
                                        <a href="<?php echo $data['url'];?>" <?php echo $data['is_click'];?> <?php if($data['id']){ echo 'id="'.$data['id'].'"';} ?> ><?php echo $data['title']; ?></a>
                                        <?php
                                    }
                                }
                                if(sizeof($value['data']['button'])){
                                    foreach ($value['data']['button'] as $data){
                                        ?>
                                        <a href="<?php echo $data['url'];?>" <?php echo $data['is_click'];?> <?php if($data['id']){ echo 'id="'.$data['id'].'"';} ?> ><?php echo $data['title']; ?></a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }?>
            </div>
            <div class="m_footer_country">
                <a href="javascript:;" class="m_footer_country_currency">
                    <div class="m-countryFlag-icon">
                        <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/mCountry-flag/ic_<?php echo $default_country_code?>.png" height="18">
                    </div>
                    <span><?php echo $default_country_name; ?></span>
                    <icon class="icon iconfont">&#xf087;</icon>
                </a>
            </div>
            <div class="m_footer_share">
                <?php foreach ($footer_third_data as $key => $val) { ?>
                    <a class="footer_fastlink_main02_content_share  icon iconfont"
                       title="<?php echo ($key == 'APP' ? 'FS.COM ' : 'fiberstore ') . $key; ?>" target="_blank"
                       href="<?php echo $val['link']; ?>"
                        <?php if ($val['rel']) {
                            echo 'rel="' . $val['rel'] . '"';
                        } ?> ><?php echo $val['icon']; ?></a>
                <?php } ?>
            </div>
            <div class="ccc"></div>
            <div class="footer_08 m_display">
                <div><?php echo $footer_copyright_str; ?>&nbsp;
                    <?php if ($_SESSION['languages_code'] == 'en') { ?>
                        <div class="footer_08_href">
                            <a href="<?php echo reset_url('policies/privacy_policy.html') ?>">
                                <?php if ($footer_is_german_warehouse) {
                                    echo FS_PRIVACY_AND_POLICY;
                                } else {
                                    echo FS_POLICY;
                                } ?>
                            </a><span>|</span>
                            <a href="<?php echo reset_url('policies/terms_of_use.html'); ?>">
                                <?php if ($footer_is_german_warehouse) {
                                    echo FS_TERMS_OF_USE_DE;
                                } else {
                                    echo FS_TERMS_OF_USE;
                                } ?>
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    <?php }
} // flag_disable_footer ?>

<?php
// 2018.7.23 fairy feedback window
//uk 底部暂时不放rating
//if ($_SESSION['languages_code'] != 'uk') {
    $feedback_valide = get_current_valide('feedback', array(
        'rating' => array(),'topic'=>array(), 'content' => array()
    ));
//} else {
//    $feedback_valide = get_current_valide('feedback', array(
//        'email' => array()
//    ));
//}

$common_customer_name = $_SESSION['name'];
$common_customer_email = $_SESSION['customer_id'] ? $_SESSION['customers_email_address'] : "";
echo '<script type="text/javascript">
            var feedback_valide = ' . json_encode($feedback_valide) . ';
            var submit_str = "' . FS_SUBMIT . '";
            var system_buy_str = "' . FS_SYSTME_BUSY . '";
            var customer_email = "' . $common_customer_email . '";
    </script> ';
?>
<div class="ui-widget-overlay" id="feedback_overlay"></div>
<!--
<div class="ui_fixed_alert fixed_ture pro_share_email_success" id="feedback_tip_window">
    <span class="iconfont icon email_Delete" onclick="$('#feedback_overlay').hide();$('#feedback_tip_window').hide();">&#xf092;</span>
    <h2 class="email_delete_img">
        <i class="iconfont icon">&#xf158;</i><span><?php echo FS_FEEDBACK_THANKYOU; ?></span>
    </h2>
    <p class="email_Delete_txt"></p>
</div>
-->
<div class="public_pop_up_layer_container successful_submission_public fixed_ture pro_share_email_success" id="feedback_tip_window">
	<div class="public_pop_up_layer_background"></div>
	<div class="public_pop_up_content public_pop_up_widht_680 Successful_submission" id="been_sent_main" >
		<p class="public_pop_up_title"> <i class="iconfont icon public_close alert_alaose email_Delete" onclick="$('#feedback_tip_window').hide();$('html').removeClass('overflow_html');" >&#xf092;</i></p>
		<div class="public_pop_content">
			<p class="public_pop_successful_submission_tit"><i class="iconfont icon">&#xf158;</i><?php echo FS_FEEDBACK_THANKYOU; ?></p>
			<p class="public_pop_successful_submission_txt email_Delete_txt"></p>
		</div>
	</div>
</div>




<div class="ui_fixed_Evaluation public_pop_up_layer_container" id="feedback_window">
	<div class="public_pop_up_layer_background"></div>
	<div class="public_pop_up_content public_pop_up_widht_680">
		<p class="public_pop_up_title"><?php echo FS_ACCOUNT_WRITE_REVIEW; ?> <i class="iconfont icon public_close" onclick="$(this).closest('.public_pop_up_layer_container').hide();$('html').removeClass('overflow_html');" >&#xf092;</i></p>
		<div class="public_pop_content">
			<div class="Evaluation_posi">
        <form id="feedback_form">
            
            <!--<h2 class="Evaluation_tit"><?php echo FS_ACCOUNT_WRITE_REVIEW; ?></h2>-->
            <?php if ($_SESSION['languages_code'] == 'jp'){?>
            <p class="Evaluation_txt"><?php echo FS_GIVE_FEEDBACK_TIP_1;?><a style="color:#0070BC;" target="_blank" href="<?php echo reset_url('service/fs_support.html'); ?>"><?php echo FS_GIVE_FEEDBACK_TIP_2;?></a><?php echo FS_GIVE_FEEDBACK_TIP_3;?><a style="color:#0070BC;" href="javascript:;" onclick="LC_API.open_chat_window();return false;"><?php echo FS_GIVE_FEEDBACK_TIP_4;?></a><?php echo FS_GIVE_FEEDBACK_TIP_5;?></p>
            <?php }else{?>
                <p class="Evaluation_txt">
                    <?php echo FS_GIVE_FEEDBACK_TIP_1; ?>
                    <a style="color:#0070BC;" target="_blank" href="<?php echo reset_url('service/fs_support.html'); ?>">
                        <?php echo FS_GIVE_FEEDBACK_TIP_2; ?>
                    </a>
                    <?php echo FS_GIVE_FEEDBACK_TIP_3; ?>
                    <a style="color:#0070BC;" href="javascript:;" onclick="LC_API.open_chat_window();return false;">
                        <?php echo FS_GIVE_FEEDBACK_TIP_4; ?></a><?php echo FS_GIVE_FEEDBACK_TIP_5; ?>
                </p>
            <?php }?>
            <p class="Evaluation_txt eva_top uk"><?php echo FS_RATE_THIS_PAGE; ?></p>
<!--            --><?php //if ($_SESSION['languages_code'] != 'uk') { ?>
                <div class="eva_container" id="feedback_rate_block">
                    <div class="Evaluation_centent" data-id="1">
                        <i class="iconfont icon">1</i>
                    </div>
                    <div class="Evaluation_centent" data-id="2">
                        <i class="iconfont icon">2</i>
                    </div>
                    <div class="Evaluation_centent" data-id="3">
                        <i class="iconfont icon">3</i>
                    </div>
                    <div class="Evaluation_centent" data-id="4">
                        <i class="iconfont icon">4</i>
                    </div>
                    <div class="Evaluation_centent" data-id="5">
                        <i class="iconfont icon">5</i>
                    </div>
                </div>
                <div class="eva_not">
                    <span class="eva_public eva_left"><?php echo FS_NOT_LIKELY; ?></span>
                    <span class="eva_public eva_right"><?php echo FS_VERY_LIKELY; ?></span>
                    <br/>
                    <input type="hidden" name="rating" id="feedback_rating" value="">
                    <div class="error_prompt"></div>
                </div>
<!--            --><?php //} ?>
            <h2 class="eva_website"><?php echo FS_TELL_US_SUGGESTIONS; ?></h2>
            <div class="pro_new_select01_wap">
                <div tabindex="1" class="pro_new_select01">
                    <span class="pro_new_select01_span"><?php echo PLEASE_SELECT; ?></span>
                    <em class="iconfont"></em>
                </div>
                <input type="hidden" name="topic" id="feedback_topic" value="">
                <div class="error_prompt" id="topic_erro"></div>
                <div class="pro_new_select01_x" style="display: none;">
                    <ul>
                        <?php //2020-03-02 文案修改 jay  ?>
                        <li data="<?php echo FS_FEEDBACK_SELECT_1; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_1; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_1; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_2; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_2; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_2; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_3; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_3; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_3; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_4; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_4; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_4; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_5; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_5; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_5; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_6; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_6; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_6; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_7; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_7; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_7; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_SELECT_8; ?>" hidden_value="<?php echo FS_FEEDBACK_SELECT_8; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_SELECT_8; ?>
                            </a>
                        </li>
                        <li data="<?php echo FS_FEEDBACK_OTHER; ?>" hidden_value="<?php echo FS_FEEDBACK_OTHER; ?>">
                            <a href="javascript:;">
                                <?php echo FS_FEEDBACK_OTHER; ?>
                            </a>
                        </li>
                        <!--<li data="Website error" hidden_value="After-sales &amp; RMA"><a
                                href="javascript:;"><?php /*echo FS_WEB_ERROR; */?></a></li>
                        <li data="Product" hidden_value="Product &amp; Technical Support"><a
                                href="javascript:;"><?php /*echo FS_FEEDBACK_PRODUCT; */?></a></li>
                        <li data="Order support" hidden_value="Product &amp; Technical Support"><a
                                href="javascript:;"><?php /*echo FS_ORDER_SUPPORT; */?></a></li>
                        <li data="Tech support" hidden_value="Product &amp; Technical Support"><a
                                href="javascript:;"><?php /*echo FS_TECH_SUPPORT; */?></a></li>
                        <li data="Site search" hidden_value="Product &amp; Technical Support"><a
                                href="javascript:;"><?php /*echo FS_SITE_SEARCH; */?></a></li>-->
                    </ul>
                </div>
            </div>
            <div class="eva_textarea eva_not">
				<div class="public_textarea_container">
					<textarea class="eva_public_input public_textarea" rows="" cols="" maxlength="5000"
							  placeholder="<?php echo FS_ENTER_COMMENTS; ?>" name="content"
							  id="feedback_content"></textarea>
					<span class="public_count"><i>0</i>/<em></em></span>
                    <div class="error_prompt"></div>
				</div>
            </div>


            <h2 class="eva_Please"><?php echo FS_PROVIDE_EMAIL; ?></h2>
            <div class="eva_input_wap after">
                <input class="eva_input eva_public_input eva_sg_name" name="feedback_name"
                       placeholder="<?php echo FS_FEEDBACK_NAME; ?>" id="feedback_name"
                       value="<?php echo $common_customer_name; ?>" type="text"/>
                <input class="eva_input eva_public_input eva_sg_email" name="email"
                       placeholder="<?php echo FS_FEEDBACK_EMAIL; ?>" id="feedback_email"
                       onkeyup="this.value=this.value.replace(/[, ]/g,'')"
                       value="<?php echo $common_customer_email; ?>" type="text"/>
            </div>
            <!--            <p class="eva_help">--><?php //echo FS_SG_VISTI_HELP; ?><!--</p>-->
            <div class="eva_btn">
                <a href="javascript:;" class="button_02 eva_button eva_red" id="feedback_submit"><?php echo FS_SUBMIT; ?></a>
            </div>
        </form>
    </div>
		</div>
	</div>
</div>

<?php //公共的成功或者失败弹窗 ?>
<div class="new_popup alone_btn_ui approved_ui" id="result_window">
    <div class="new_popup_bg"></div>
    <div class="new_popup_main popup_width680 pupop_video">
        <h2 class="new_popup_tit">
            <a href="javascript:;" id="result_window_close"><span class="icon iconfont">&#xf092;</span></a>
        </h2>
        <div class="new_popup_content">
            <h2 class="approved_h2">
                <i class="iconfont icon" id="result_window_success_icon">&#xf158;</i>
                <i class="iconfont icon iconfont_Defeat" id="result_window_error_icon">&#xf071;</i>
                <span id="result_window_content"></span>
            </h2>
            <!-- <p class="approved_p"></p>-->
        </div>
    </div>
</div>


<div class="alert_alone_container" id="new_result_alert" style="display: none;">
    <div class="alert_alone_bg"></div>
    <div class="alert_content alert_alone_680 Successful_submission">
        <p class="alert_alone_tit">
            <em class="iconfont icon alert_alaose" onclick="location.reload();">&#xf092;</em>
        </p>
        <div class="alert_popup_content">
            <p class="Successful_submission_tit"></p>
            <p class="Successful_submission_txt" style="display: none;"></p>
        </div>
    </div>
</div>


<?php
//2019.1.17 fairy 只有首页要
if($this_is_home_page){
    require($template->get_template_dir('tpl_cookie_agree.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . 'tpl_cookie_agree.php');
}
?>
<?php require_once(DIR_WS_TEMPLATES . '/fiberstore/common/fs_footer_js.php'); ?>
<script src="<?php echo auto_version('includes/templates/fiberstore/jscript/footer.js'); ?>"></script>

<?php $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if (strpos($url, 'localhost') || strpos($url, 'www.fs.com')) {
    $url = "";
}
if (FILENAME_CHECKOUT == $_GET['main_page'] || FILENAME_PRODUCT_INFO == $_GET['main_page'] || FILENAME_CHECKOUT_SUCCESS == $_GET['main_page']) {
    ?>
    <!-- BEGIN GCR Badge Code -->
    <!-- <script src="https://apis.google.com/js/platform.js?onload=renderBadge"
            async defer>
    </script>
    <script>
        window.renderBadge = function() {
            var ratingBadgeContainer = document.createElement("div");
            document.body.appendChild(ratingBadgeContainer);
            window.gapi.load('ratingbadge', function() {
                window.gapi.ratingbadge.render(
                    ratingBadgeContainer, {
                        // REQUIRED
                        "merchant_id": "9038559",
                        // OPTIONAL
                        "position": "BOTTOM_RIGHT"
                    });
            });
        }
    </script>
    <script>
	  window.___gcfg = {
		lang: 'en_US'
	  };
	</script>
    <script>
		window.___gcfg = {
			lang: 'en_US'
		};
	</script> -->
    <!-- END GCR Badge Code -->
<?php } ?>
<script type="text/javascript">
    <?php
    //if($_SESSION['customer_id']){
    if (FILENAME_PRODUCT_INFO == $_GET['main_page'] && isset($_GET['products_id'])){
    ?>
    $.ajax({
        url: "ajax_process_other_requests.php?request_type=save_custoemr_visted",
        type: 'POST',
        data: 'pd_id=<?php echo isset($_GET['products_id']) ? $_GET['products_id'] : '0' ?>&customer_id=<?php echo $_SESSION['customer_id'] ? $_SESSION['customer_id'] : '0' ?>'
    });
    <?php }
    //}
    ?>
</script>

<script type="text/javascript">
    
    $('#feedback_window .pro_new_select01_wap').click(function () {
        if($(this).hasClass('active')){
            $(this).removeClass('active').find('.pro_new_select01_x').slideUp();
        }else{
            $(this).addClass('active').find('.pro_new_select01_x').slideDown();
        }
        //$('#feedback_window .pro_new_select01_x').slideToggle();
    })
    var choose_one = $(".pro_new_select01_span").html();
    $(".pro_new_select01_x ul li").click(function () {
        $("#feedback_topic").val($(this).attr('data'));
        $(".pro_new_select01_span").addClass('active').html($(this).html());
        $("#topic_erro").hide();
        $(this).closest('.pro_new_select01_wap').removeClass('active');
        $('.pro_new_select01_x').slideUp();
        event.stopPropagation();
    });
    $(document).click(function (e) {
        var target = $(e.target);
        if (target.closest('.pro_new_select01_wap').length < 1) {
            $('.pro_new_select01_x').slideUp();
            $('.pro_new_select01').removeClass('show');
            $('.pro_new_select01_wap').removeClass('active');
        }
    });
</script>

<?php if($_SESSION['languages_code']=="jp" && $_GET['main_page']!="regist_success"){ ?>
<script type="text/javascript">
    (function () {
        var tagjs = document.createElement("script");
        var s = document.getElementsByTagName("script")[0];
        tagjs.async = true;
        tagjs.src = "//s.yjtag.jp/tag.js#site=LEgcFuX";
        s.parentNode.insertBefore(tagjs, s);
    }());
</script>
<noscript>
    <iframe src="//b.yjtag.jp/iframe?c=LEgcFuX" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>
<?php } ?>
<script type="text/javascript">
var email_text= "<?php echo FS_EMAIL_SUBSCRIPTION_FOOTER_05; ?>";
var email_present = "<?php echo FS_EMAIL_SUBSCRIPTION_FOOTER_04; ?>"

//View Cart add by ternence
var page_type =  1;
<?php if(in_array($_GET['main_page'], array('index')) && !isset($_GET['cPath'])){ ?>
page_type =  2;
<?php  }elseif(in_array($_GET['main_page'], array('index')) && isset($_GET['cPath'])){ ?>
page_type =  3;
<?php  }elseif(in_array($_GET['main_page'], array('product_info'))){ ?>
page_type =  4;
<?php  }elseif(in_array($_GET['main_page'], array('shopping_cart'))){ ?>
page_type =  5;
<?php  } ?>


$('.top_edit_order').click(function(){
    if (typeof _faq !== 'undefined') {
        _faq.push(['trackEvent', 'view_cart_click', {}, page_type]);
    }
})
$('.top_cart_more_main_checkout_btn').click(function(){
    if (typeof _faq !== 'undefined') {
        _faq.push(['trackEvent', 'check_out_click', {}, page_type]);
    }
})
$('#checkoutBtn').click(function(){
    if (typeof _faq !== 'undefined') {
        _faq.push(['trackEvent', 'check_out_click', {}, page_type]);
    }
})
$('.Cou_right_dl_02 a').click(function(){
    var text = $(this).text();
    if(text==""){
        text = $(this).parents("dt").siblings("dd").find("a").text();
    }
    if (typeof _faq !== 'undefined') {
        _faq.push(['trackEvent', 'internal_chain_click', {"title": text}, 8]);
    }
})
$('#news_project a').click(function(){
    if (typeof _faq !== 'undefined') {
        _faq.push(['trackEvent', 'customer_reviews_more_click', {}, 10]);
    }
})
</script>

<?php if (in_array($_SESSION['languages_code'], array('de')) && (!empty($_GET['cPath']) || $this_is_home_page || $_GET['main_page'] == 'product_info') && !isMobile()) { ?>
    <script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge.js');?>"></script>
<?php } ?>
<?php if (in_array($_SESSION['languages_code'], array('dn')) && (!empty($_GET['cPath']) || $this_is_home_page || $_GET['main_page'] == 'product_info') && !isMobile()) { ?>
    <script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge_dn.js');?>"></script>
<?php } ?>
<?php
if ($_SESSION['languages_code'] == 'fr' && (!empty($_GET['cPath']) || $this_is_home_page || $_GET['main_page'] == 'product_info') && !isMobile()) {?>
<script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge_fr.js');?>"></script>
<?php } ?>

