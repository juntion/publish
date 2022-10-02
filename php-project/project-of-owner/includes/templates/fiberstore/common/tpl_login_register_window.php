<?php
// 2018.8.17 用户登录注册弹窗。
// 用于 用于销售帮客户下单后发送的付款链接页面、补款链接页面
?>
<style>
.Login_registration:after{content:"";display:block;clear:both;}
.Login_registration{width: auto;float: left;}
.login_new_popup li.login_new_popup_li{display: none;}
.login_new_popup li.login_new_popup_li.active{display: block;}
.Login_registration li{line-height: 60px;float: left;width: auto;margin-right: 30px;}
.Login_registration li a{color: #616265;margin-bottom: -1px;font-size: 20px;line-height: 60px;display: inline-block;}
.Login_registration li a:hover{text-decoration: none;}
.Login_registration li.active a{border-bottom: 2px solid #232323;}
.new_popup_tit:after{content:"";display:block;clear:both;}
.new_popup_tit{border-bottom: 1px solid #E5E5E5;box-sizing: border-box;}
.login_new_popup_container{width: 380px;margin: 0 auto;padding-top: 34px;}
.lr_new_a_container{text-align: center;padding-top: 8px;}
.lr_new_a_container a{color: #616265;font-size: 13px;line-height: 22px;}
#password_login{margin-bottom: 0;}
.login-bottom-ways{height:1px;width:100%;position:relative;background:#e5e5e5;margin-top:62px;margin-bottom:24px}
.login-bottom-ways span{display:inline-block;position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);background:#fff;padding:0 10px;vertical-align:middle;margin-top:-2px;font-size:13px;color:#616265}
.new_popup_main{position:relative;left:0;top:0;display:inline-block;vertical-align:middle;text-align:left;margin:0;transform:none;overflow: initial}
.new_popup_main:after{content:"";display:block;clear:both}
.new_popup{text-align:center}

.lr_content_ipt{height: 40px;border-color: #E5E5E5;margin-bottom: 0px;}
.input_block{margin-bottom: 14px;}
.input_block:nth-child(2){margin-bottom: 0;}
.lr_content_otherlogin a{background: none;width: auto;height: 26px;color: #616265;float: inherit;margin: 0 20px;font-size: 24px;}
.lr_content_otherlogin a:hover{text-decoration: none;}
.lr_content_otherlogin{overflow: initial;text-align: center;}
.lr_content_otherlogin:after{content:"";display:block;clear:both;}
.lr_content_name div{width: 185px;}
.ce_form_choose_country{border-color: #E5E5E5;height: 40px;margin-bottom: 10px;}
.ce_form_choose_country p{line-height: 38px;}
.ce_form_choose_country em{top: 12px;}
.eu_cookie a{color: #232323 !important;}
.lr_submit{margin-top: 18px;margin-bottom: 50px;}
.product_login{padding-bottom: 48px;}

.quote_new_tip{font-size: 13px;color: #616265;line-height: 20px;margin-bottom: 15px;}
#server_tip{margin-bottom: 15px;}

@media (max-width: 960px){
	.new_popup_main.pupop_video.popup_width680 {
	    width: 480px;
	    left: inherit;
	    margin: 0;
	}
	.new_popup_tit{padding:0 20px}
}
@media (max-width: 480px){
	.new_popup_main.pupop_video.popup_width680 {
	    width: 100%;
	    height: 100%;
	    left: 0;
	    right: 0;
	    margin: 0;
	    position: fixed;
	}
	.login_new_popup_container{width: 100%;}
	.new_popup_content{padding: 0 15px;box-sizing: border-box;}
	.lr_content_name div{width: 48%;}
}

.po_login_prompt {
    font-size: 13px;
    color: #616265;
    line-height: 22px;
    padding-bottom: 12px;
}

</style>

<?php
// 验证码
define('LOGIN_ERROR_REDIS_KEY_PREFIX','login_error:');
$ip_address = getCustomersIP();
$ip_login_error_old = get_redis_key_value($ip_address,LOGIN_ERROR_REDIS_KEY_PREFIX);
$is_show_ver = false;
// 10s3次错误，显示验证码。登录成功或者redis过期，重新开始
if($ip_login_error_old['third_login_error_date'] && $ip_login_error_old['third_login_error_date']-$ip_login_error_old['first_login_error_date']<=10){
    $is_show_ver = true;
}
$is_show_ver = false; // 2019.8.2 暂时屏蔽验证码

$form_data=[];

if($_GET['main_page']=="inquiry" && $_SESSION['inquiry_form']){
   $form_data =  $_SESSION['inquiry_form'];
}elseif($_GET['main_page']=="sample_application" && $_SESSION['sample_form']){
    $form_data = $_SESSION['sample_form'];
}
$customers_country_id =fs_get_country_id_of_code($_SESSION['countries_code_21']);
$tel_prefix = fs_get_data_from_db_fields('tel_prefix','countries','countries_id = '.(int)$customers_country_id,'');
$countries = zen_get_countries();
$country_prefix  = array();
foreach ($countries as $country){
    $country_prefix[$country['countries_id']] = $country['tel_prefix'];
}

$po_tip = '';
if($_GET['main_page']=="purchase_order"){
    $po_tip =  '<p class="po_login_prompt">'.PURCHASE_PROCESS_TIP.'</p>';
}
?>


<div class="ui-widget-overlay" id="fs_overlay" style="display: none;"></div>
<div class="new_popup new_order" id="fs_popup_cancel" style="display: none;">
    <div class="new_popup_main popup_width680 pupop_video alone_wap">
        <h2 class="new_popup_tit">
            <ul class="Login_registration">
                <li class="active"><a href="javascript:void(0);"><?php echo FILENAME_SIGN_IN;?></a></li>
                <li><a href="javascript:void(0);"><?php echo FS_INQUIRY_INFO_9;?></a></li>
            </ul>
            <a href="javascript:void(0);" onclick="$('#fs_overlay,#fs_popup_cancel').hide();">
                <span class="icon iconfont"></span>
            </a>
        </h2>
        <div class="new_popup_content">
            <div class="login_new_popup_container">
                <?php if ($_GET['main_page'] == 'inquiry' && defined('FS_QUOTE_LOGIN_TIP')) { ?>
                    <p class="quote_new_tip">
                        <?php echo FS_QUOTE_LOGIN_TIP; ?>
                    </p>
                <?php } ?>
                <p class="tishi_02 display_none" id="server_tip"><span></span></p>
                <?php echo $po_tip;?>
                <ul class="login_new_popup">
                    <li class="login_new_popup_li active">
                        <form id="form_login" name="form_login" method="post">
                            <?php echo zen_draw_hidden_field('securityToken',$_SESSION['securityToken']);?>
                            <div class="product_login product_ul_on01">
                                <div class="input-block input_block">
                                    <h6 class="lr_content_tit"><?php ECHO FS_EMAIL_ADDRESS;?></h6>
                                    <input class="lr_content_ipt" type="text" value="<?php echo !empty($form_data['email'])?$form_data['email']:""; ?>" id="email_login" name="email">
                                    <p class="error_prompt"></p>
                                </div>
                                <div class="input-block input_block">
                                    <h6 class="lr_content_tit"><?php ECHO FS_PASSWORD;?></h6>
                                    <div class="lr_content_password">
                                        <input type="password" class="lr_content_ipt" id="password_login" autocomplete="off" name="password">
                                        <span class="lr_content_password_show"><?php echo FS_SHOW;?></span>
                                    </div>
                                    <p class="error_prompt"></p>
                                </div>
                                <div class="lr-character-group <?php if($is_show_ver){?>active<?php } ?>" id="validate_div">
                                    <h2 class="lr_left_main_tit"><?php echo FS_ENTER_CHARACTER; ?></h2>
                                    <div class="lr-character-wrap after input_block">
                                        <div class="lr-character-ipt">
                                            <input type="text" class="lr_ipt valid" name="validate" id="validate">
                                        </div>
                                        <div class="lr-character-panel">
                                            <span class="lr-character-img">
                                                <img src="<?php echo zen_href_link(FILENAME_CAPTCHA);?>" align="absbottom" onclick="refresh_code();" id="validecode_image" ondragstart="return false;">
                                            </span>
                                            <span class="lr-character-btn icon iconfont" onclick="refresh_code()">&#xf224;</span>
                                        </div>
                                        <p class="error_prompt" style="display: none;"></p>
                                    </div>
                                </div>
                                <button class="lr_submit" id="submit_login"><?php echo FS_SIGN_IN; ?></button>
                                <div class="lr_new_a_container">
                                    <a class="forgot_password" <?php if(in_array($_GET['main_page'],array('inquiry','purchase_order','sample_application'))){echo 'target="_blank"'; } ?> href="<?php echo zen_href_link(FILENAME_PASSWORD_FORGOTTEN,'','SSL')?>"><?php echo FS_FORGOT_YOUR_PASSWORD;?></a>
                                </div>
                                <div class="login-bottom-ways">
                                    <span><?php echo FS_LOGIN_BY_OTHER;?></span>
                                </div>
                                <div class="lr_content_otherlogin">
                                    <a href="social_media/google.php" title="<?php echo FS_SIGN_IN_GOOGLE;?>" class="google_plus iconfont icon">&#xf192;</a>
                                    <a href="social_media/paypal.php" title="<?php echo FS_SIGN_IN_PAYPAL;?>" class="paypal iconfont icon">&#xf202;</a>
                                    <a href="social_media/facebook.php" title="<?php echo FS_SIGN_IN_FACEBOOK;?>" class="facebook iconfont icon">&#xf191;</a>
                                    <a href="social_media/linkedin.php" title="<?php echo FS_SIGN_IN_LINKEDIN;?>" class="linkedin iconfont icon">&#xf190;</a>
                                </div>
                            </div>
                        </form>
                    </li>

                    <li class="login_new_popup_li">
                        <form id="form_regist" name="form_regist"  method="post" novalidate="novalidate">
                            <div class="input-block">
                                <div class="lr_content_name">
                                    <div class="lr_content_firstname">
                                        <h6 class="lr_content_tit"><?php echo FS_FIRST_NAME;?></h6>
                                        <input class="lr_content_ipt" type="text" value="<?php echo !empty($form_data['entry_firstname'])?$form_data['entry_firstname']:''; ?>" id="firstname_regist" name="firstname">
                                        <p class="error_prompt firstname_regist_error_prompt"></p>
                                    </div>
                                    <div class="lr_content_lastname">
                                        <h6 class="lr_content_tit"><?php echo FS_LAST_NAME;?></h6>
                                        <input class="lr_content_ipt" type="text" value="<?php echo !empty($form_data['entry_lastname'])?$form_data['entry_lastname']:''; ?>" id="lastname_regist" name="lastname">
                                        <p class="error_prompt lastname_regist_error_prompt"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="input-block">
                                <h6 class="lr_content_tit"><?php echo FS_EMAIL_ADDRESS;?></h6>
                                <input type="text" class="lr_content_ipt" name="email" value="<?php echo !empty($form_data['email'])?$form_data['email']:''; ?>" id="email_regist" value="">
                                <p class="error_prompt"></p>
                            </div>

                            <div class="input-block">
                                <h6 class="lr_content_tit"><?php echo FS_PASSWORD;?></h6>
                                <div class="lr_content_password">
                                    <input type="password" class="lr_content_ipt" autocomplete="off" name="password" id="password_regist">
                                    <span class="lr_content_password_show"><?php echo FS_SHOW;?></span>
                                    <p class="error_prompt"></p>
                                </div>
                            </div>

                            <div class="input-block">
                                <h6 class="lr_content_tit"><?php echo FS_YOUR_COUNTRY;?></h6>
                                <?php echo zen_draw_countries_pull_down_add_tag_new('country','','session'); ?>
                                <p class="error_prompt"></p>
                            </div>
                            <h2 class="lr_left_main_tit"><?php echo FS_PHONE_NUMBER;?>*</h2>
                            <div class="input-block" style="position: relative">
                                <span id="tel_prefix_phone_regist"><?php echo $tel_prefix?$tel_prefix:"+1"; ?></span>
                                <input type="text" class="lr_ipt" name="phone_number" value="<?php echo !empty($form_data['phone'])?$form_data['phone']:''; ?>" id="telephone_regist" value="" />
                                <p class="error_prompt" style="display: none;"></p>
                            </div>
                            <div class="input-block">
                                <h2 class="lr_left_main_tit"><?php echo FS_COMPANY_NAME;?><span style="color: #8D8D8F"><?php echo FS_OPTIONAL_COMPANY;?></span></h2>
                                <input type="text" class="lr_ipt" name="customers_company" id="company_regist" value="" />
                                <p class="error_prompt" style="display: none;"></p>
                            </div>
                            <div class="input-block rem_container_privacy_policy">
                                <span class="fl fl_privacy_policy">
                                    <i class="iconfont icon active">&#xf078;</i>
                                    <?php echo FS_COMMON_PRIVACY_POLICY;?>
                                </span>
                                <input type="checkbox" style="position:absolute; height:0; width:0; border:0;" name="privacy_policy" value="1" id="privacy_policy" checked/>
                                <p class="error_prompt" id="privacy_policy_error_prompt" style="display: none;"><?php echo FS_COMMON_PRIVACY_POLICY_ERROR; ?></p>
                            </div>

                            <button class="lr_submit g-recaptcha"  data-sitekey="6Lfn2LMUAAAAAMxWMK6drNI_sprQfREFROthz-Ta" data-callback='onSubmits' id="submit_regist"  onclick="regist_recaptcha_windows('<?php echo $_GET['main_page']; ?>')"><?php echo FS_CREATE_ACCOUNT; ?></button>
                        </form>
                    </li>
                </ul>

            </div>

        </div>
    </div>
</div>


<!-- display login and regist  -->

<?php
$login_valide = get_current_valide('username', array(
    'email' => array(), 'password' => array('common_name'=>'old_password'), 'validate' => array()
));
echo '<script> var login_valide = '.json_encode($login_valide).'; </script> ';
$regist_valide = get_current_valide('username', array(
    'firstname' => array(),'lastname' => array(),'email' => array(),'focusInvalid'=>false,
    'password' => array(),'country'=>array(), 'phone_number'=>array(), 'tax_number'=>array('common_name'=>'tax_number_new')
));

echo '<script> var regist_valide = '.json_encode($regist_valide).'; </script> ';
?>
<script>
    var show_str = "<?php echo FS_SHOW;?>";
    var hide_str = "<?php echo FS_HIDE;?>";
    var system_busy_tip = "<?php echo FS_SYSTME_BUSY;?>";
    var email_has_registered_tip = "<?php echo FS_EMAIL_HAS_REGISTERED_TIP;?>";
	var country_input_name = "country";
	var MODULUS = "<?php echo RSA_MODULUS;?>";
    var fs_recaptcha_switch = "<?php if (defined('FS_RECAPTCHA_SWITCH')) {
        echo FS_RECAPTCHA_SWITCH;
    } else {
        echo 0;
    }?>";
    var quote_type = "<?php if($_GET['main_page']=='inquiry'){echo "quote"; }?>";
    var inquiry_type = "<?php if($_GET['inquiry']==1){echo $_GET['inquiry'];} ?>";
    var country_to_telephone = <?php echo json_encode($country_prefix)?>;
    var privacy_policy_error = "<?php echo FS_COMMON_PRIVACY_POLICY_ERROR; ?>";
</script>
