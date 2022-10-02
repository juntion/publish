<!-- 作为一个公共的部分     by liang.zhu-->
<div class="checkout_Npro_footer">
    <div class="login_footer">
        <div class="footer_fs">
            <div class="login_new_09">
                <?php
                /*开始 这里只是按照需求提出问题进行展示，与其他地方没有任何相关 开始*/
                $company_name = get_company_name();
                echo $company_name;
                /**结束 这里只是按照需求提出问题进行展示，与其他地方没有任何相关 结束**/
                ?>
                <?php if ($_SESSION['languages_code'] == 'jp') {?>
                    <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
                    <span>|</span>
                    <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
                <?php } else {?>
                <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
                <span>|</span>
                <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
                    <?php if ($_SESSION['languages_code'] == 'fr' && german_warehouse('country_code', $_SESSION['countries_iso_code'])&&(!in_array(strtoupper($_SESSION['countries_iso_code']), array("BL", "MF")))) { ?>
                        <span>|</span>
                <a href="<?php echo reset_url('policies/terms_of_use.html#recovery');?>"><?php echo 'Droit de rétractation';?></a>
                    <?php } ?>
                <?php }?>
            </div>

            <div>
                <?php
                if(in_array($_SESSION['languages_code'],['en','mx','sg','au','jp','ru'])){
                    echo '<div id="DigiCertClickID_Er-2fIoO" data-language="en"></div>';
                };
                switch($_SESSION['languages_code']){
                    case 'de':
                    case 'dn':
                        echo '<img width="30px" height="30px" src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/ssl_icon.png">';
                        echo "<a style=\"margin-left:10px;\" href='javascript:;' onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src='".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png'></a>";
                        break;
                    case 'uk';
                        echo '<img width="30px" height="30px" src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/ssl_icon.png">';
                        echo "<a style=\"margin-left:10px;\" href='javascript:;' onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src='".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png'></a>";
                        break;
                    default:
                        echo '<div id="DigiCertClickID_vyT8OdM_" data-language="en"></div>';
                        echo "<a style=\"margin-left:10px;\" href='javascript:;' onclick=\"javascript:window.open('https://www.mcafeesecure.com/verify?host=www.fs.com', 'SealVerification', 'width=568,height=546,left=0,top=0,toolbar=no,location=yes,scrollbars=yes,status=yes,resizable=yes,fullscreen=no');\"><img src='".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/new-pc-img/McAfee.png'></a>";

                }?>
            </div>
            <div class="ccc"></div>
        </div>
    </div>
</div>

<?php if ($_GET['main_page'] == 'checkout_success'){?>
<div class="public_pop_up_layer_container successful_submission_public have_feedback_true" id="checkout_feedback_window" style="display: none;">
    <div class="public_pop_up_layer_background"></div>
    <div class="public_pop_up_content public_pop_up_widht_680 Successful_submission" id="been_sent_main" >
        <p class="public_pop_up_title"> <i class="iconfont icon public_close alert_alaose" onclick="$('.have_feedback_true').hide();" >&#xf092;</i></p>
        <div class="public_pop_content">
            <p class="public_pop_successful_submission_tit"><i class="iconfont icon">&#xf186;</i><?php echo FS_CHECKOUT_FOOTER_NEW_18;?></p>
            <p class="public_pop_successful_submission_txt email_Delete_txt"><?php echo FS_CHECKOUT_FOOTER_NEW_19;?></p>
        </div>
    </div>
</div>

<div class="public_pop_up_layer_container have_feedback"  style="display: none;">
    <div class="public_pop_up_layer_background"></div>
    <div class="public_pop_up_content public_pop_up_widht_680" id="been_sent_main" >
        <p class="public_pop_up_title"><?php echo FS_CHECKOUT_FOOTER_NEW_01;?> <i class="iconfont icon public_close alert_alaose" onclick="$('.have_feedback').hide();" >&#xf092;</i></p>
        <div class="public_pop_content">
            <p class="have_feedback_tit"><?php echo FS_CHECKOUT_FOOTER_NEW_03 . FS_CHECKOUT_FOOTER_NEW_02;?></p>
            <div class="have_feedback_container">
                <p class="have_feedback_select_title"><?php echo FS_CHECKOUT_FOOTER_NEW_04;?></p>
                <select class="have_feedback_select" id="feedback_topic" name="">
                    <option value=""><?php echo FS_CHECKOUT_FOOTER_NEW_05;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_06;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_06;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_07;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_07;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_08;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_08;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_09;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_09;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_10;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_10;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_11;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_11;?></option>
                    <option value="<?php echo FS_CHECKOUT_FOOTER_NEW_12;?>"><?php echo FS_CHECKOUT_FOOTER_NEW_12;?></option>
                </select>
                <div style="display:none" id="feedback_topic_error" class="error_prompt"><?php echo FS_CHECKOUT_FOOTER_NEW_13;?></div>
            </div>
            <div class="have_feedback_textarea_conatiner">
                <div class="public_textarea_container have_feedback_textarea">
                    <textarea maxlength="5000" id="feedback_content" type="text" class="request-support-textarea public_textarea" placeholder="<?php echo FS_CHECKOUT_FOOTER_NEW_14;?>" name="comments_content" onfocus="return(this.placeholder='')" onblur="return(this.placeholder= '<?php echo FS_CHECKOUT_FOOTER_NEW_14;?>')"></textarea>
                    <span class="public_count"><i>0</i>/<em></em></span>
                </div>
                <div style="display:none" id="feedback_content_error" class="error_prompt"><?php echo FS_CHECKOUT_FOOTER_NEW_16;?></div>
            </div>
            <div class="have_feedback_btn_container">
                <a href="javascript:void(0);" id="checkout_feedback"><span><?php echo FS_CHECKOUT_FOOTER_NEW_17;?></span></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var submit_str ="<?php echo FS_SUBMIT;?>";
</script>
<?php }?>
<!--trusted shop徽章代码,评论自动收集 -->
<?php if (in_array($_SESSION['languages_code'], array('de')) && $_GET['main_page'] == 'checkout_success' && !isMobile()) {
    ?>
    <script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge.js');?>"></script>
    <div id="trustedShopsCheckout" style="display: none;">
        <span id="tsCheckoutOrderNr"><?php echo $order_summary['orders_number']; ?></span>
        <span id="tsCheckoutBuyerEmail"><?php echo $_SESSION['customers_email_address']; ?></span>
        <span id="tsCheckoutOrderAmount"><?php echo $order_summary['orders_total']; ?></span>
        <span id="tsCheckoutOrderCurrency"><?php echo $_SESSION['currency']; ?></span>
        <span id="tsCheckoutOrderPaymentType"><?php echo $order_summary['payment_method']; ?></span>
        <span id="tsCheckoutOrderEstDeliveryDate"><?php echo $max_day; ?></span>
    </div>
<?php } ?>
<?php if (in_array($_SESSION['languages_code'], array('dn')) && $_GET['main_page'] == 'checkout_success' && !isMobile()) {
    ?>
    <script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge_dn.js');?>"></script>
    <div id="trustedShopsCheckout" style="display: none;">
        <span id="tsCheckoutOrderNr"><?php echo $order_summary['orders_number']; ?></span>
        <span id="tsCheckoutBuyerEmail"><?php echo $_SESSION['customers_email_address']; ?></span>
        <span id="tsCheckoutOrderAmount"><?php echo $order_summary['orders_total']; ?></span>
        <span id="tsCheckoutOrderCurrency"><?php echo $_SESSION['currency']; ?></span>
        <span id="tsCheckoutOrderPaymentType"><?php echo $order_summary['payment_method']; ?></span>
        <span id="tsCheckoutOrderEstDeliveryDate"><?php echo $max_day; ?></span>
    </div>
<?php } ?>

<?php if (in_array($_SESSION['languages_code'], array('fr')) && $_GET['main_page'] == 'checkout_success' && !isMobile()) {
    ?>
    <script type="text/javascript" src="<?php echo auto_code_version('includes/templates/fiberstore/jscript/trusted_badge_fr.js');?>"></script>
    <div id="trustedShopsCheckout" style="display: none;">
        <span id="tsCheckoutOrderNr"><?php echo $order_summary['orders_number']; ?></span>
        <span id="tsCheckoutBuyerEmail"><?php echo $_SESSION['customers_email_address']; ?></span>
        <span id="tsCheckoutOrderAmount"><?php echo $order_summary['orders_total']; ?></span>
        <span id="tsCheckoutOrderCurrency"><?php echo $_SESSION['currency']; ?></span>
        <span id="tsCheckoutOrderPaymentType"><?php echo $order_summary['payment_method']; ?></span>
        <span id="tsCheckoutOrderEstDeliveryDate"><?php echo $max_day; ?></span>
    </div>
<?php } ?>

<!-- 安全认证-->
<script>
    var __dcid = __dcid || [];__dcid.push(["DigiCertClickID_Er-2fIoO", "15", "m", "black", "Er-2fIoO"]);(function(){var cid=document.createElement("script");cid.async=true;cid.src="//seal.digicert.com/seals/cascade/seal.min.js";var s = document.getElementsByTagName("script");var ls = s[(s.length - 1)];ls.parentNode.insertBefore(cid, ls.nextSibling);}());
</script>
