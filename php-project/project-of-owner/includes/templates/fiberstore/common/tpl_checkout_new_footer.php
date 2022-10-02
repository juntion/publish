<?php
//$the_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//if(strpos($the_url,'/sg/') !== false ||
//    strpos($the_url,'/jp/') !== false ||
//    strpos($the_url,'/fr/') !== false ||
//    strpos($the_url,'/es/') !== false ||
//    strpos($the_url,'/mx/') !== false){?>
<!--<div class="login_footer">-->
<!--    <div class="footer_fs">-->
<!--        <div class="login_new_09">Copyright © 2009---><?php //echo date('Y',time());?><!-- FS.COM  All Rights Reserved.</div>-->
<!--        <img class="bbb" src="../images/footer_logo.jpg">-->
<!--        <div class="ccc"></div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<?php // require($template->get_template_dir('tpl_cookie_agree.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . 'tpl_cookie_agree.php'); ?>
<?php //}else{?>
<div class="cnp_footer">
    <p class="cnp_footer_font">
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
            <?php echo str_replace('YEAR', date('Y', time()),FS_FOOTER_COPYRIGHT);?>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('/site_map.html');?>"><?php echo FS_SITE_MAP;?></a>
        <?php } else { ?>
            <?php echo FS_COPY;?> © 2009-<?php echo date('Y',time());?> <?php echo $fs_str . FS_RIGHTS.FS_EMAIL_PERIOD;?>
            <a href="<?php echo reset_url('policies/terms_of_use.html');?>"><?php echo FS_TERMS_OF_USE;?></a>
            <span>|</span>
            <a href="<?php echo reset_url('policies/privacy_policy.html');?>"><?php echo FS_POLICY;?></a>
        <?php }?>
    </p>
    <div class="cnp_footer_pic">
        <?php
        $foot_logo = HTTPS_IMAGE_SERVER;
        switch($_SESSION['languages_code']) {
            case 'de': $foot_logo .= 'includes/templates/fiberstore/images/footer_logo_de.jpg'; break;
            case 'dn': $foot_logo .= 'includes/templates/fiberstore/images/footer_logo_de.jpg'; break;
            case 'uk': $foot_logo .= 'includes/templates/fiberstore/images/footer_logo_uk.jpg'; break;
            default  : $foot_logo .= 'includes/templates/fiberstore/images/footer_logo.jpg';
        }
        ?>
        <img src="<?php echo $foot_logo;?>" />
    </div>
</div>
<?php //}?>
<?php if(FILENAME_CHECKOUT_SUCCESS == $_GET['main_page'] && $_SESSION['languages_code'] != 'de'){ ?>
    <!-- BEGIN GCR Opt-in Module Code -->
    <script src="https://apis.google.com/js/platform.js?onload=renderOptIn"
            async defer>
    </script>
    <script>
        window.renderOptIn = function() {
            window.gapi.load('surveyoptin', function() {
                window.gapi.surveyoptin.render(
                    {
                        // REQUIRED
                        "merchant_id": 9038559,
                        "order_id": "<?php echo $orders_id ?>",
                        "email": "<?php echo  zen_get_customer_email_address_of_id($orders_id);?>",
                        "delivery_country": "<?php  echo $_SESSION['countries_code_21'];?>",
                        "estimated_delivery_date": "<?php echo $delivery_date ?>",

                        // OPTIONAL
                        "opt_in_style": "CENTER_DIALOG"
                    });
            });
        }
    </script>
    <script>
        window.___gcfg = {
            lang: 'en_US'
        };
    </script>
    <!-- END GCR Opt-in Module Code -->
<?php }?>


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

<script>
    // common way start
    // show or hide loading
    // type: show/hide
    // way
    function show_loading(_this,type,way,is_new){
        way = way?way:1;
        is_new = is_new?is_new:0;
        if(type == 'show'){
            if(way == 1){ //
                if(is_new){
                    $('#new_common_loading').show();
                }else{
                    $('#fs_loading_bg,#fs_loading').show();
                }
                if(_this){
                    _this.attr('disabled', 'disabled');
                }
            }else if(way == 2){ // 2
                _this.closest('.new_details_tr').append('<div class="shopping_cart_pro_con_bg"></div><div id="loader_order_alone" class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>');
            }else if(way == 3){ //3
                var html = '<div class="spinWrap public_bg_wap background"><div class="bg_color"></div><div id="loader_order_alone" class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div></div>';
                var load = _this.closest(".alone_wap").find(".public_bg_wap");
                var length = load.length;
                if (!length) {
                    _this.closest(".alone_wap").append(html);
                }
                var type = _this.prop("tagName");
                if (type == "INPUT" || type == "BUTTON") {
                    _this.addClass("loading_button").attr("disabled", true);
                }
                load.show();
            }
        }else{
            if(way == 1){
                if(is_new){
                    $('#new_common_loading').hide();
                }else{
                    $('#fs_loading_bg,#fs_loading').hide();
                }
                if(_this){
                    _this.removeAttr('disabled');
                }
            }else if(way == 2){  // 2
                _this.closest('.new_details_tr').find('.shopping_cart_pro_con_bg').remove();
                _this.closest('.new_details_tr').find('.loader_order').remove();
            }else if(way == 3){  // 3
                _this.closest('.alone_wap').find('.public_bg_wap').remove();
                _this.removeClass("loading_button").attr("disabled", false);
            }
        }
    }

    /*
    * show or hide success or error result
    * templates in tpl_account_left_slide_bar_new.php
    */
    function show_server_tip_window(config_outer){
        var config = {
            type:'success',  //type: success/error
            content:'',
            is_auto_hide:false,
            is_jump:false,
            jump_url:'', //default reload
            is_window:true, //default window
            close_fun:'', //close，do other action
        };
        config=$.extend(config,config_outer);

        if(config.is_window){
            if(config.type == 'success'){
                $('#result_window_success_icon').show();
                $('#result_window_error_icon').hide();
            }else{
                $('#result_window_error_icon').show();
                $('#result_window_success_icon').hide();
            }
            $('#result_window_content').html(config.content);
            $('#result_window').show();
            if(config.is_auto_hide){
                setTimeout(function(){
                    $('#result_window').hide();
                    if(config.close_fun){
                        config.close_fun();
                    }
                },3000);
            }
            $('#result_window_close').click(function () { //hand hide the result window
                $('#result_window').hide();
                if(config.close_fun){
                    config.close_fun();
                }
            })
        }else{
            $('#service_'+config.type+'_tip_content').html(config.content);
            $('#service_'+config.type+'_tip').show();
            setTimeout(function () {
                $('#service_'+config.type+'_tip').hide();
                $('#service_'+config.type+'_tip_content').html('');
            },3000);
        }
        if(config.is_jump){
            setTimeout(function () {
                if(config.jump_url){
                    location.href = revise_ajax_return_link(config.jump_url);
                }else{
                    location.reload();
                }
            },3000);
        }
    }

    /*
    * ajax 返回的链接，要进行处理。把&amp;改成&
     */
    function revise_ajax_return_link(str){
        var reg = new RegExp( '&amp;' , "g" )
        return str.replace( reg , '&' );
    }
    // common way end
</script>
