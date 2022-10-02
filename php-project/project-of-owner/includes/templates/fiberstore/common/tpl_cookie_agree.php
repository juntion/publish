<?php if(!isset($_COOKIE['cookieconsent_dismissed']) || $_COOKIE['cookieconsent_dismissed'] != 'yes'){ ?>
    <div class="footer_eu_cookie <?php if (german_warehouse('country_code', $_SESSION['countries_iso_code'])) { echo 'cookie_a_container'; }?> " id="agree_cookie_div">
        <div class="footer_eu_cookie_main">
            <?php if (!german_warehouse('country_code', $_SESSION['countries_iso_code'])) {?>
                <p>
                    <?php $is_mobile = isMobile();
                    if($is_mobile && empty($_COOKIE['c_site'])){
                        echo FS_FOOTER_COOKIE_MOBILE_TIP;
                    }else{
                        echo FS_FOOTER_COOKIE_TIP;
                    } ?>
                </p>
                <a class="footer_eu_cookie_main_accepet icon iconfont" href="javascript:;" id="agree_cookie_btn">&#xf092;</a>
            <?php }else{?>
                <p><?php echo FS_FOOTER_COOKIE_TIP_NEW;?></p>
                <a class="cookie_a" href="javascript:;" id="agree_cookie_btn_google"><?php echo FS_FOOTER_COOKIE_TIP_BTN;?></a>
            <?php }?>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(function () {
        $('#agree_cookie_btn').click(function () {
            if( !$.cookie('cookieconsent_dismissed') ){
                $.cookie('cookieconsent_dismissed', 'yes', { expires: 365 });
            }
            $('#agree_cookie_div').hide();
             $('.m_2017footer,.login_footer').css('margin-bottom',0)
        });


        $('#agree_cookie_btn_google').click(function(){
            if( !$.cookie('fs_google_analytics') ){
                $.cookie('fs_google_analytics', 'yes', { expires: 365 });

                $.cookie('cookieconsent_dismissed', 'yes', { expires: 365 });
            }
            $('#agree_cookie_div').hide();
            $('.m_2017footer,.login_footer').css('margin-bottom',0)
        });

        $('.refuse_cookie_btn_google').click(function(){
            $('#agree_cookie_div').hide();
            $('.m_2017footer,.login_footer').css('margin-bottom',0);
            $.cookie('fs_google_analytics', 'no', { expires: 30 });
            $.cookie('cookieconsent_dismissed', 'yes', { expires: 365 });

            //删除cookie
            $.removeCookie('_ga', {path:'/', domain:'.fs.com'});
            $.removeCookie('_gid', {path:'/', domain:'.fs.com'});
            $.removeCookie('AMP_TOKEN', {path:'/', domain:'.fs.com'});
            $.removeCookie('_ym_isad', {path:'/', domain:'.fs.com'});
            $.removeCookie('_ym_uid', {path:'/', domain:'.fs.com'});
            $.removeCookie('_ym_visorc_48770636', {path:'/', domain:'.fs.com'});
            
        });
    })
</script>