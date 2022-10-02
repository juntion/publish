
<div class="new_popup fs-subSuccess-alertChange" id="new_popup_quote" style="display: none;">
    <div class="new_popup_bg"></div>
    <div class="new_popup_main popup_width680 new_proquote_alert">
        <h2 class="new_popup_tit">
            <strong></strong>
            <span class="icon iconfont"></span>
        </h2>
        <div class="new_popup_content addCart_cont">
            <form id="quote_form" novalidate="novalidate">
                <input type="hidden" name="products_id" id="quote_products_id" value="">
                <div class="new_proquote_alert_txt" style="display: none">*<?php echo FS_REQUEST_DEADLINE;?></div>
                <div class="Failure_pub">
                    <div class="fa_tr">
                        <div class="fa_th fa_one"></div>
                        <div class="fa_th fa_two"><?php echo FS_INQUIRY_YOUR_ITEM;?></div>
                        <div class="fa_th fa_three"><?php echo FS_CART_QTY;?></div>
                    </div>
                    <div class="fa_tr">
                        <div class="fa_td fa_one shopping_quote_image">
                            <img src="">
                        </div>
                        <div class="fa_td fa_two get-quote-txtBox">
                            <p></p>
                            <span class="get-quote-idNum"></span>
                            <span id="attrs"></span>
                            <span id="quote_arr"></span>
                        </div>
                        <div class="fa_td fa_three">
                            <?php ?>
                            <div class="cart_basket_btn">
                                <input type="hidden" name="product_min_qty">
                                <input class="shopping_cart_quote_products_id" type="hidden" name="products_id" value="">
                                <input type="text" name="product_qty" value="1" id="quote_product_qty" onblur="quote_check_min_qty(this);" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')" class="shopping_cart_01" autocomplete="off" min="1">
                                <div class="pro_mun">
                                    <a href="javascript:void(0);" onclick="change_product_quote_num('1',this)" class="shopping_add"></a>
                                    <a href="javascript:void(0);" onclick="change_product_quote_num('0',this)" class="cart_reduce shopping_minus"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new_proquote_alert_txt">
                    <?php echo "*".GET_A_QUOTE_TIP; ?>
                </div>
                <ul class="login_regist_21 p_ly_mian fs-newquote-subList">
                    <li>
                        <div class="product_li_left01">
                            <span><?php echo FS_FIRST_NAME; ?><em>*</em></span>
                            <input type="text" name="firstname" id="quote_firstname" class="big_input" placeholder="" value="<?php echo $_SESSION['customer_first_name']?>"><i class="help_info"></i>
                            <div class="error_prompt quote_firstname_error_prompt"></div>
                        </div>
                        <div class="product_li_right01">
                            <span><?php echo FS_LAST_NAME; ?><em>*</em></span>
                            <input type="text" name="lastname" id="quote_lastname" class="big_input" value="<?php echo $_SESSION['customer_last_name']?>"><i class="help_info"></i>
                            <div class="error_prompt quote_lastname_error_prompt"></div>
                        </div>
                    </li>
                    <li>
                        <div class="product_li_left01">
                            <span><?php ECHO FS_COUNTRY;?><em>*</em></span>
                            <?php echo zen_draw_countries_pull_down_add_tag_new('quote_country','quote_country','session');?>
                        </div>
                        <div class="product_li_right01">
                            <span><?php echo FS_PHONE_NUMBER; ?><em>*</em></span>
                            <input type="text" name="phone_number" id="quote_phone_number" class="big_input"><i class="help_info"></i>
                            <div class="error_prompt"></div>
                        </div>
                    </li>
                    <li>
                        <div class="product_li_left01">
                            <span><?php echo FS_EMAIL_ADDRESS1; ?><em>*</em></span>
                            <input type="text" name="email" onkeyup="this.value=this.value.replace(/[, ]/g,'')" id="quote_email" class="big_input" value="<?php echo $_SESSION['customers_email_address']?>" aria-required="true">
                            <i class="help_info"></i>
                            <div class="error_prompt"></div>
                        </div>
                    </li>
                    <li class="height_01"><span><?php echo COMMENTS_OR_QUESTIONS;?><em>*</em></span>
                        <textarea name="enquiry" id="quote_enquiry" class="login_014 aaa"></textarea>
                        <i class="help_info"></i>
                        <div class="error_prompt"></div>
                        <div class="ccc"></div>
                    </li>
                    <li>
                        <div class="input-block privacy_policy_font_style">
                            <input type="checkbox" name="privacy_policy" class="privacy_policy_checkoutbox" value='' id="privacy_policy"/>
                            <?php echo FS_COMMON_PRIVACY_POLICY;?>
                            <p class="error_prompt" style="display: none;"></p>
                        </div>
                    </li>
                    <li class="">
                        <div class="set_button fs-newquote-subBtn">
                            <button type="button" value="<?php echo FS_COMMON_SUBMIT;?>" id="quote_submit" class="button_02 new_proDetails_loadBtn new_proDetails_pinkLoad">
                                <div class="new_proDetails_loadTxt"><?php echo FS_COMMON_SUBMIT;?></div>
                                <div class="loader_order">
                                    <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </li>
                    <div class="ccc"></div>

                </ul>
            </form>
        </div>
    </div>
</div>
<div class="new_popup fs-subSuccess-alertChange inquiry_quote" style="display: none;">
    <div class="new_popup_bg"></div>
    <div class="new_popup_main popup_width680 pupop_video fs-subSuccess-alert">
        <h2 class="new_popup_addCart_tit">
            <span class="icon iconfont" onclick="$('.inquiry_quote').hide();">&#xf092;</span>
        </h2>
        <div class="new_popup_content addCart_cont">
            <div class="addCrat_item_number continue_paySuccess_txt">
                <span class="icon iconfont">&#xf186;</span>
                <?php echo FS_PRODUCT_INQUIRY_3; ?>
            </div>
            <div class="continue_paySuccess_txt01">
                <?php echo FS_PRODUCT_INQUIRY_1; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var privacy_policy_error = "<?php echo FS_COMMON_PRIVACY_POLICY_ERROR; ?>";
    function quote_check_min_qty(evt) {
        pid = $(".shopping_cart_quote_products_id").val();

        if(!pid){
            return false;
        }
        var evt_val = $.trim($(evt).val());
        if(evt_val.length==0){
            $(evt).val(1);
        }
    }

    function change_product_quote_num(type,obj) {
        pid = $(".shopping_cart_quote_products_id").val();
        var input_val = $("#quote_product_qty").val();
        input_val = parseInt(input_val);
        if(type==1){
            if(input_val>=99999){
                return false;
            }
            input_val+=1;
            $("#quote_product_qty").val(input_val);
        }else{
            if(input_val<=1){
                return false;
            }
            input_val-=1;
            $("#quote_product_qty").val(input_val);
        }
    }


</script>