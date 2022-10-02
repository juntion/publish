<?php if($_GET['main_page'] != 'regist'){ ?>
<div class="bottom">
    <div class="login-bottom-ways">
        <span><?php echo FS_LOGIN_OTHER_NEW;?></span>
    </div>
    <div class="login-Third-party">
        <ul class="login-Third-party-ul">
            <li><a href="<?php echo $code;?>/social_media/google.php" title="<?php echo FS_SIGN_IN_GOOGLE;?>" class="iconfont icon">&#xf192;</a></li>
            <li><a href="<?php echo $code;?>/social_media/paypal.php" title="<?php echo FS_SIGN_IN_PAYPAL;?>" class="iconfont icon">&#xf202;</a></li>
            <li><a href="<?php echo $code;?>/social_media/facebook.php" title="<?php echo FS_SIGN_IN_FACEBOOK;?>" class="iconfont icon">&#xf191;</a></li>
            <li><a href="<?php echo $code;?>/social_media/linkedin.php" title="<?php echo FS_SIGN_IN_LINKEDIN;?>" class="iconfont icon">&#xf190;</a></li>

        </ul>
    </div>
    <?php }?>
  <?php if($_GET['main_page'] == 'login_guest'){ ?>
      <!--<label class="login-account"><?php /*echo FS_DONT_HAVE_FS_ACCOUNT;*/?> <a class="alone-a" href="<?php /*echo zen_href_link('regist','','SSL');*/?>"><?php /*echo FS_JOIN_NOW;*/?><i class="iconfont icon">&#xf089;</i></a></label>-->
  <?php }else if($_GET['main_page'] == 'login'){ ?>
    <!--M端登录修改 去掉 Already had an account? 20206-02-26 jay.li-->
    <!--<label class="login-account"><?php /*echo FS_DONT_HAVE_FS_ACCOUNT;*/?></label>
    <a href="<?php /*echo zen_href_link('regist','','SSL');*/?>"><button class="login-button login-guest login-jow"><?php /*echo FS_JOIN_NOW;*/?></button></a>-->
  <?php }else if($_GET['main_page'] == 'regist'){
      ?>
      <div class="login-Submit-container login-Already">
            <button class="lr_submit login-sign login-alone-background" id="submit_regist"><?php echo FS_CREATE_ACCOUNT; ?></button>
          <!--M端注册修改 去掉 Already had an account? 20206-02-26 jay.li-->
          <!--<label class="login-Forgot"><?php /*echo FS_ALREADY_HAS_ACCOUNT;*/?></label>-->
        </div>
    </form>
    <!--M端注册修改 去掉 sign in 20206-02-26 jay.li-->
    <!--<a href="<?php /*echo zen_href_link(FILENAME_LOGIN,'','SSL');*/?>">
        <button class="login-button login-guest"><?php /*echo FS_SIGN_IN;*/?></button>
    </a>-->
    </div>
    <?php }?>
    <label class="login-account login-footer">
        <?php
        //fs.com替换成对应站点的内容
        switch ($_SESSION['languages_code']){
            case 'au':
                $fs_str = ' '.FS_AU_COMPANY_NAME.' ';
                break;

            case 'uk':
                $fs_str = ' '.FS_UK_COMPANY_NAME.' ';
                break;

            case 'sg':
                $fs_str = ' '.FS_SG_COMPANY_NAME.' ';
                break;

            case 'jp':
                $fs_str = ' FiberStore Co., Limited ';
                break;

            case 'de':
            case 'dn':
            case 'es':
                $fs_str = ' '.FS_DE_COMPANY_NAME.' ';
                break;

            case 'en':
            case 'mx':
                if(seattle_warehouse('country_code',$_SESSION['countries_iso_code'])){
                    $fs_str = ' '.FS_US_COMPANY_NAME.' ';
                }else{
                    $fs_str = ' FiberStore Co., Limited ';
                }
                break;

            case 'fr':
            case 'ru':
                if(all_german_warehouse('country_code',$_SESSION['countries_iso_code'])) {
                    $fs_str = ' '.FS_DE_COMPANY_NAME.' ';
                }elseif(seattle_warehouse('country_code',$_SESSION['countries_iso_code'])) {
                    $fs_str = ' '.FS_US_COMPANY_NAME.' ';
                }else{
                    $fs_str = ' '.FS_RU_COMPANY_NAME.' ';
                }
                break;

            default:
                $fs_str = ' ';
                break;
        }
        ?>
        <?php if ($_SESSION['languages_code'] == 'jp') {?>
            <?php echo str_replace('YEAR', date('Y', time()),FS_FOOTER_COPYRIGHT);?><br>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('/site_map.html');?>"><?php echo FS_SITE_MAP;?></a>
        <?php } else { ?>
            <?php echo FS_COPY;?> © 2009-<?php echo date('Y',time());?> <?php echo $fs_str . FS_RIGHTS.FS_EMAIL_PERIOD;?><br>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
        <?php }?>
        </p>
        <!--2020-03-03 去掉M端need help jay-->
        <!--<p class="lr_footer_font">
            <?php /*echo FS_SIGN_IN_NEED_HTLP;*/?>&nbsp;
            <a href="<?php /*echo reset_url('/contact_us.html');*/?>"  target="_blank"><?php /*echo FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT;*/?>
            </a>
        </p>-->
    </label>
    <div class="login-bottom-img">
        <?php
        // $foot_logo = HTTPS_IMAGE_SERVER;
        // switch($_SESSION['languages_code']) {
        //     case 'de':;
        //     case 'dn': $foot_logo .= 'includes/templates/fiberstore/images/footer_logo_de.jpg'; break;
        //     case 'uk': $foot_logo .= 'includes/templates/fiberstore/images/footer_logo_uk.jpg'; break;
        //     default  : $foot_logo .= 'includes/templates/fiberstore/images/footer_logo.jpg';
        // }
        ?>
        <!-- <img src="<?php echo $foot_logo;?>" /> -->
        <?php
        switch ($_SESSION['languages_code']) {
            case 'de':
            case 'dn':
                echo  "<a href=\"javascript:;\" style='margin-right:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                break;
            case 'uk':
                echo  "<a href=\"javascript:;\" style='margin-right:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                break;

            default :
                echo "<a href=\"javascript:;\"style='margin-right:10px;'  onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img  src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a>
                 <div id=\"DigiCertClickID_vyT8OdM_\" data-language=\"en\"> </div> ";
        }
        ?>
    </div>
</div>
<?php require(DIR_WS_TEMPLATES.'/fiberstore/common/fs_footer_js.php');?>