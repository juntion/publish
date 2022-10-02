<?php //服务流程类表单的底部
//fs.com替换成对应站点的内容
$fs_str = get_company_name();
?>
    <div class="request-support-btmBox after">
        <div class="request-support-btmBox-left">
            <div>
                <?php echo FS_COPY; ?> © 2009-<?php echo date('Y', time()); ?> <?php echo $fs_str . FS_RIGHTS . '.'; ?>
                <div class="request-support-linkBox">
                    <a href="<?php echo reset_url('policies/privacy_policy.html') ?>">
                        <?php echo FS_POLICY; ?>
                    </a>
                    <span>|</span>
                    <a href="<?php echo reset_url('policies/terms_of_use.html') ?>">
                        <?php echo FS_TERMS_OF_USE; ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="request-support-btmBox-right">
            <div class="after">
                <?php
                switch ($_SESSION['languages_code']) {
                    case 'de':
                    case 'dn':
                        echo "<a href=\"javascript:;\" style='margin-right:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"" . HTTPS_IMAGE_SERVER . "includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"" . HTTPS_IMAGE_SERVER . "includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                        break;
                    case 'uk':
                        echo "<a href=\"javascript:;\" style='margin-right:10px;cursor:default;'> <img width=\"30px\" height=\"30px;\" src=\"" . HTTPS_IMAGE_SERVER . "includes/templates/fiberstore/images/ssl_icon.png\" alt=\"\"></a>
                <a href=\"javascript:;\" onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src=\"" . HTTPS_IMAGE_SERVER . "includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a> ";
                        break;

                    default :
                        echo "<a href=\"javascript:;\"style='margin-right:10px;'  onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img  src=\"" . HTTPS_IMAGE_SERVER . "includes/templates/fiberstore/images/new-pc-img/McAfee.png\" alt=\"\"></a>
                 <div id=\"DigiCertClickID_vyT8OdM_\" data-language=\"en\"> </div>";
                }
                ?>
            </div>
        </div>
    </div>
<?php require_once(DIR_WS_TEMPLATES . '/fiberstore/common/fs_footer_js.php'); ?>