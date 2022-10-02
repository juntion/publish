<div class="lr_footer">
    <p class="lr_footer_font">
        <?php
        //fs.com替换成对应站点的内容
        $fs_str = get_company_name();
        ?>
        <?php if ($_SESSION['languages_code'] == 'jp') {?>
            <?php
            $copy_right_str = str_replace('YEAR', date('Y', time()),FS_FOOTER_COPYRIGHT);
            $copy_right_str = str_replace(FS_LOCAL_COMPANY_NAME,$fs_str,$copy_right_str);
            echo $copy_right_str;?><br>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <!--
            <span>|</span>
            <a href="<?php echo reset_url('/site_map.html');?>"><?php echo FS_SITE_MAP;?></a>
            -->
        <?php } else { ?>
            <?php echo FS_COPY;?> © 2009-<?php echo date('Y',time());?> <?php echo $fs_str . FS_RIGHTS.FS_EMAIL_PERIOD;?><br>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
        <?php }?>
    </p><br>
    <p class="lr_footer_font">
        <?php echo FS_SIGN_IN_NEED_HTLP;?>&nbsp;
    </p><p class="lr_footer_font_new">
        <a href="<?php echo reset_url('/contact_us.html');?>" target="_blank" ><?php echo FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT;?></a>
    </p>
    <div class="lr_footer_pic">
        <?php
        switch ($_SESSION['languages_code']) {
            case 'de':
            case 'dn':
                echo  "<a href=\"javascript:;\" style='margin-left:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                break;
            case 'uk':
                echo  "<a href=\"javascript:;\" style='margin-left:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                break;

            default :
                echo "<a href=\"javascript:;\"style='margin-left:10px;'  onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img  src=\"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a>
                 <div id=\"DigiCertClickID_vyT8OdM_\" data-language=\"en\"> </div>";
        }
        ?>
    </div>
</div>

<?php
//2019.1.17 fairy 只有首页要
// require($template->get_template_dir('tpl_cookie_agree.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . 'tpl_cookie_agree.php'); ?>

<?php require(DIR_WS_TEMPLATES.'/fiberstore/common/fs_footer_js.php');?>