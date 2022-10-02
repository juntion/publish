<div class="lr_footer">
    <p class="lr_footer_txt">
        <?php echo FS_COPY;?> © 2009-<?php echo date('Y',time());?> FS.COM <?php echo FS_RIGHTS;?>.
        <a href="terms_of_use.html"><?php echo FS_TERMS_OF_USE;?></a>
        <a href="privacy_policy.html"><?php echo FS_POLICY;?></a>
    </p>
</div>

<?php
//2019.1.17 fairy 只有首页要
// require($template->get_template_dir('tpl_cookie_agree.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . 'tpl_cookie_agree.php');?>

<!-- loading -->
<div class="login_loading_bg" id="login_loading_bg"></div>
<div id="fs_loading" class="processing" style="display:none">
    <div class="processing_sub"><img src="<?php echo HTTPS_IMAGE_SERVER;?>/images/loading.gif">
        <div class="loader">
            <div class="loader-inner line-scale">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <?php ECHO FS_LOADING;?> ...
</div>

<?php require(DIR_WS_TEMPLATES.'/fiberstore/common/fs_footer_js.php');?>