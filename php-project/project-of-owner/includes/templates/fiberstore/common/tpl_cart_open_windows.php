<div class="ui-overlay" id="save_cart" style="display: none;">

    <div class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed new_popup_main popup_width680 new_ui_car new_carr_01" id="save_cart_main" style="display: none;">
        <div class="public_pop_up_title"><?php echo FS_SHOP_CART_ALERT_JS_72;?></div>
        <div class="popup_con errorParent">
            <p class="popup_con_txt"><?php echo FS_SHOP_CART_ALERT_JS_6; ?></p>

            <h2 class="popup_con_tit"><?php echo FS_SHOP_CART_ALERT_JS_7; ?> <i class="iconfont icon public_close" onclick="$('.ui-widget-overlay,#save_cart,#save_cart_main').hide();$('#datetime').val('').attr('placeholder','<?php echo FS_SHOP_CART_ALERT_JS_58." ".$save_time;?>');" >&#xf092;</i></h2>

            <input type="text" id="datetime" oninput="shopCartName(this)" placeholder="<?php echo FS_SHOP_CART_ALERT_JS_58." ".$save_time; ?>" class="big_input" maxlength="50">
            <div style="display: none;" class="error_prompt"></div>

            <p class="popup_con_txt save_prompt" style="display:none; color: #c00000"></p>
            <div class="popup_con_btn">
                <a class="popup_con_btn_yes" id="save_yes"  href="javascript:;">
                    <span class="popup_con_btn_yesTxt"><?php echo FS_SHOP_CART_ALERT_JS_5; ?></span>
                    <div class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                </a>
                <a class="popup_con_btn_no" href="javascript:;" onclick="$('.ui-widget-overlay,#save_cart,#save_cart_main').hide();$('#datetime').val('').attr('placeholder','<?php echo FS_SHOP_CART_ALERT_JS_58." ".$save_time;?>');"><?php echo FS_SHOP_CART_ALERT_JS_8; ?></a>
            </div>
        </div>
        <!--<div class="box_close">
            <a href="javascript:;" onclick="$('.ui-widget-overlay,#save_cart,#save_cart_main').hide();$('#datetime').val('').attr('placeholder','<?php echo FS_SHOP_CART_ALERT_JS_58." ".$save_time;?>');"><i class="iconfont icon">&#xf092;</i></a>
        </div>-->
    </div>
</div>
<div class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed new_popup_main popup_width680 new_ui_car new_carr_01" id="been_saved_main" style="display: none;">
    <div class="popup_tit"><?php echo FS_SHOP_CART_ALERT_JS_9; ?></div>
    <div class="popup_con">
        <p class="popup_con_txt"><span></span><?php echo FS_SHOP_CART_ALERT_JS_10; ?></p>
        <div class="popup_con_btn">
            <input type="submit" value="Retourner au Paniers Enregistrés" class="popup_con_btn_yes">
            <a class="popup_con_btn_no" href="javascript:;" onclick="$('.ui-widget-overlay,#been_saved,#been_saved_main').hide();"><?php echo FS_SHOP_CART_ALERT_JS_11; ?></a>
        </div>
    </div>
    <div class="box_close">
        <a href="javascript:;" onclick="$('.ui-widget-overlay,#been_saved,#been_saved_main').hide();"><i class="iconfont icon">&#xf092;</i></a>
    </div>
</div>
<div class="ui-overlay" id="been_saved" style="display: none;">
    <div class="ui-widget-overlay" style="display: none;"></div>
    <div class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed new_popup_main popup_width680 new_ui_car new_carr_01" id="been_saved_main" style="display: none;">
        <div class="popup_tit"><?php echo FS_SHOP_CART_ALERT_JS_9;?></div>
        <div class="popup_con">
            <p class="popup_con_txt"><span></span><?php echo FS_SHOP_CART_ALERT_JS_10; ?></p>
            <div class="popup_con_btn">
                <a href="<?php echo zen_href_link('saved_items','type=saved_carts','SSL'); ?>">
                    <input type="submit" value="Retourner au Paniers Enregistrés" class="popup_con_btn_yes">
                    <a>
                        <a class="popup_con_btn_no" href="javascript:;" onclick="$('.ui-widget-overlay,#been_saved,#been_saved_main').hide();">Return Shopping Cart</a>
            </div>
        </div>
        <div class="box_close">
            <a href="javascript:;" onclick="$('.ui-widget-overlay,#been_saved,#been_saved_main').hide();"><i class="iconfont icon">&#xf092;</i></a>
        </div>
    </div>
</div>

<!--购物车分享弹窗-->
<!--<div class="ui-overlay send_email_for_cart" id="share_cart" style="display: none;">
    <div class="ui-widget-overlay" style="display: none;"></div>
    <div class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed new_popup_main popup_width680 new_ui_car new_carr_01" id="share_cart_main" style="display: none;">
		<div class="popup_tit"><?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE; }else{ echo FS_SHOP_CART_ALERT_JS_12; }?></div>
        <div class="popup_con">-->
		<div class="public_pop_up_layer_container send_email_for_cart" id="share_cart">
			<div class="public_pop_up_layer_background"></div>
			<div class="public_pop_up_content public_pop_up_widht_680" id="share_cart_main" >
				<p class="public_pop_up_title"><?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE; }else{ echo FS_SHOP_CART_ALERT_JS_12; }?> <i class="iconfont icon public_close" onclick="$(this).closest('.public_pop_up_layer_container').hide();$('html').removeClass('overflow_html');" >&#xf092;</i></p>
				<div class="public_pop_content">
				
				
				
            <h2 class="popup_con_tit"><?php echo str_replace('*','',FS_SHOP_CART_ALERT_JS_13);?></h2>
            <div class="shopCart_your_emailBox after">
                <div class="popup_con_ipt">
                    <input type="text" onkeyup="this.value=this.value.replace(/[, ]/g,'')" id="from_email" name="from_email" placeholder="<?php echo FS_SHOP_CART_ALERT_JS_56; ?>" value="<?php echo isset($_SESSION['customers_email_address'])?$_SESSION['customers_email_address']:"";?>" class="big_input">
                    <p class="popup_con_txt from_email" style="display:none; color: #c00000"><?php echo FS_SHOP_CART_ALERT_JS_44; ?></p>
                </div>
            </div>

            <h2 class="popup_con_tit" style="margin-bottom: 12px"><?php echo str_replace('*', '', FS_SHOP_CART_ALERT_JS_14);?></h2>
                <div class="shopCart_your_emailBox after">
                    <div class="popup_con_ipt">
                        <input type="text" id="to_email"  name="to_email" placeholder="<?php echo FS_SHOP_CART_ALERT_JS_56_1; ?>" class="big_input">
                        <p class="popup_con_txt to_email" style="display:none; color: #c00000"><?php echo FS_SHOP_CART_ALERT_JS_44_01; ?></p>
                    </div>
                </div>
            <?php if($_SESSION['customer_id']){ ?>
            <label class="popup_con_checkbox sendManager nochoose">
                <input name="checkbox" id="sendManager" type="checkbox"><?php echo FS_SHOP_CART_ALERT_JS_46;?>
            </label>
            <?php } ?>
            <h2 class="popup_con_tit popup_con_account_numtit"><?php echo FS_SHOP_CART_ALERT_JS_15;?><span class="popup_con_account_txtnum"><em>0</em>/500</span></h2>
            <textarea class="login_014 popup_con_textarea" maxlength="500" account-txtNun="txtNUm" placeholder="<?php echo FS_SHOP_CART_ALERT_JS_57; ?>"></textarea>
            <div class="popup_con_btn">
                <a type="submit"  id="share_button"  value="<?php echo FS_SHOP_CART_ALERT_JS_76_1; ?>" class="popup_con_btn_yes">
                    <span class="popup_con_btn_yesTxt"><?php echo FS_SHOP_CART_ALERT_JS_76_1; ?></span>
                    <div class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                </a>
                <a class="popup_con_btn_no" href="javascript:;" onclick="$('.ui-widget-overlay,#share_cart,#share_cart_main').hide();$('html').removeClass('overflow_html');"><?php echo FS_CANCEL;?></a>
            </div>
            <p class="popup_con_txt email_error_prompt" style="display:none; color: #c00000; float: right;"></p>
            <input value="" class="pre_saved_list" name="share_list_id" type="hidden">
            <input value="<?php echo $_GET['main_page'];?>" id="from_page" name="from_page" type="hidden">
            <input value="0" id="save_item_id" name="save_item_id" type="hidden">
        </div>
    </div>
</div>
<!--购物车分享弹窗 end-->



<!--<div class="new_popup addCart show " id="shopping_cart_save" style="display: none;">
    <div class="new_popup_bg"></div>
    <div class="new_popup_main popup_width680 pupop_video">
        <h2 class="new_popup_addCart_tit new_popup_changeTit01">
            <div class="addCrat_item_number">
                <span class="addCrat_item_numberTit"><?php echo FS_SHOP_CART_ALERT_JS_72;?></span>
            </div>
            <span class="icon iconfont" onclick="close_cart_window()"></span>
        </h2>-->
		
<div class="public_pop_up_layer_container public_pop_up_switch" id="shopping_cart_save">
	<div class="public_pop_up_layer_background"></div>
	<div class="public_pop_up_content public_pop_up_widht_680">
		<p class="public_pop_up_title"><?php echo FS_SHOP_CART_ALERT_JS_72;?> <i class="iconfont icon public_close" onclick="$(this).closest('.public_pop_up_layer_container').hide();" >&#xf092;</i></p>
		<div class="public_pop_content">
			<div class="Save_Cart_form errorParent">
				<p class="Save_Cart_title"><?php echo FS_NAME_YOUR_SAVED_CART;?>:</p>
				<div class="Save_Cart_input_container">
					<input class="Save_Cart_input" type="" name="" id="save_cart_name" value="" oninput="shopCartName(this)" placeholder="<?php echo FS_SHOP_CART_ALERT_JS_58." ".$save_time; ?>" /><input class="Save_Cart_input" type="hidden" name="" id="save_cart_name_val" value="" />
					<a class="Save_Cart_a" id="shipping_save_cart" href="javascript:;"><?php echo FS_SHOP_CART_ALERT_JS_72_1;?></a>
				</div>
                <div style="display: none;" id="save_cart_error" class="error_prompt"></div>
            </div>
			<?php if (!empty($shop_cart_name_list)) { ?>
			<div class="Save_Cart_form">
				<p class="Save_Cart_title"><?php echo FS_ADD_THE_ITEMS;?></p>
				<div class="Save_Cart_input_container">
					<select class="Save_Cart_select" name="select_cart_name" id="select_cart_name">
						<option value=""><?php echo FS_SAVE_CART_SELECT;?></option>
						<?php foreach ($shop_cart_name_list as $k => $v) { ?>
						<option value="<?php echo $k;?>"><?php echo $v;?></option>
						<?php } ?>
					</select>
					<a class="Save_Cart_a" id="update_save_cart_name" href="javascript:;"><?php echo FS_ADD_TO_SAVED_CART;?></a>
				</div>
				<div style="display: none;" id="save_cart_name_error" class="error_prompt"></div>
			</div>
			<?php } ?>
	   </div>


	</div>
</div>

<div class="new_popup addCart show  Save_window" id="saved_cart_name_success" style="display: none;">
    <div class="new_popup_bg"></div>
    <div class="new_popup_main popup_width680 pupop_video">
        <h2 class="new_popup_addCart_tit">
            <span class="icon iconfont" onclick="$('.addCart').hide();"></span>
        </h2>
        <div class="new_popup_content addCart_cont">
            <p class="Save_Cart_window_tit"><i class="iconfont icon">&#xf186;</i><?php echo FS_CART_NEW_CART_CREATE;?></p>
            <p class="Save_Cart_window_txt"><a href=""><?php echo FS_CART_SAVED_CART_NAME;?></a> <?php echo FS_CART_HAS_BEEN_ADD;?></p>
        </div>

    </div>
</div>



<!--<div class="ui-overlay" id="been_sent" style="display: none;">
    <div class="ui-widget-overlay" style="display: none;"></div>
    <div class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed new_popup_main popup_width680 new_ui_car new_carr_01" id="been_sent_main" style="display: none;">
        <div class="popup_tit"><?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE_2; }else{ echo FS_SHOP_CART_ALERT_JS_18; } ?></div>
        <div class="popup_con">-->
		
<div class="public_pop_up_layer_container" id="been_sent">
	<div class="public_pop_up_layer_background"></div>
	<div class="public_pop_up_content public_pop_up_widht_680" id="been_sent_main" >
		<p class="public_pop_up_title"><?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE_2; }else{ echo FS_SHOP_CART_ALERT_JS_18; } ?> <i class="iconfont icon public_close" onclick="$(this).closest('.public_pop_up_layer_container').hide();$('html').removeClass('overflow_html');" >&#xf092;</i></p>
		<div class="public_pop_content">  
			<p class="popup_con_txt">
                <?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE_3;  }else{ echo FS_SHOP_CART_ALERT_JS_41; };?>
            </p>
            <div class="popup_con_btn">
                <input type="submit" value="<?php echo FS_SHARE_AGAIN;?>" class="popup_con_btn_yes">
                <a class="popup_con_btn_no" href="javascript:;" onclick="$('.ui-widget-overlay,#been_sent,#been_sent_main').hide();$('html').removeClass('overflow_html');"><?php if($_GET['main_page']=='inquiry'){ echo INQUIRY_TITLE_4;}else{echo FS_SHOP_CART_ALERT_JS_11;}?></a>
            </div>
        </div>
    </div>
</div>

<div class="login_loading_bg" id="fs_loading_bg_cart" style="z-index:10000000;"></div>
<div id="fs_loading_cart" class="processing" style="display:none;z-index:10000001;">
    <div class="spinWrap">
        <div id="loader_order_alone" class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>
    </div>
</div>

<script>
    var FS_SHOP_CART_ALERT_JS_56_1 = "<?php echo FS_SHOP_CART_ALERT_JS_56_1;?>";
    var main_page = "<?php echo $_GET['main_page'];?>";
    var admin_name = "<?php echo $admin_email;?>";
    var customer_email = "<?php echo $_SESSION['customers_email_address'];?>";
    var sendEmail = '<?php echo FS_SHOP_CART_ALERT_JS_76_1; ?>';
    var submitAfter = '<?php echo FS_SAMPLE_APPLICATION_SUBMIT;?>';
    var create_title = '<?php echo FS_CART_NEW_CART_CREATE;?>';
    var create_has_add = '<?php echo FS_CART_HAS_BEEN_ADD;?>';
    //var update_success = '<?php //echo FS_CART_SUCCESSFULLY_UPDATED;?>//';
    var update_success = '<?php echo FS_UPDATED_SUCCESSFULLY;?>';
    var update_success_word = '<?php echo FS_NEW_ITEM_CART;?>';
    var update_success_word1 = '<?php echo FS_NEW_ITEM_CART1;?>';
    var update_success_word2 = '<?php echo FS_NEW_ITEM_CART2;?>';
    var lang = '<?php echo $_SESSION['languages_code']?>';
    var ajax_cart_num = 0;
    // 输入时隐藏提示信息
    $('#from_name').bind('input propertychange',function() {
        $('.from_name').hide();
    });
    $('#from_email').bind('input propertychange',function() {
        $('.from_email').hide();
    });
    $('#to_name').bind('input propertychange',function() {
        $('.to_name').hide();
    });

    // 输入时验证是否存在对应销售邮箱
    $('#to_email').bind('input propertychange',function() {
        var msg = $(this).val();
        var msg_arr = msg.split(';');
        var manager_email = "<?php echo $admin_email;?>";//对应邮箱
        $('.to_email').hide();
        if($('#to_email').val().length<=0){
            $('.sendManager').addClass('nochoose').find('#sendManager').attr('checked',false);
        }
        if(msg_arr.indexOf(manager_email)<0){
            $('.sendManager').addClass('nochoose').find('#sendManager').attr('checked',false);
        }else{
            $('.sendManager').removeClass('nochoose').find('#sendManager').attr('checked',true);
        }
        $(this).attr("placeholder",FS_SHOP_CART_ALERT_JS_56_1);
    });
    //saved_items和saved_cart_details公用
    function open_email_windows(type) {
        $("#save_item_id").val(type);
        $('#new_ui_car,#share_cart,#share_cart_main').show();
    }
    // 点击显示对应销售邮箱
    $('.popup_con_checkbox.sendManager').on('click',function(){
        var msg = $('#to_email').val();
        var msg_arr = msg.split(';');
        var manager_email = "<?php echo $admin_email;?>";//对应邮箱
        var manager_plh = "<?php echo FS_SHOP_CART_ALERT_JS_56_1; ?>";
        var str = '';
        if($(this).find('input').is(':checked')){
            if(msg_arr.indexOf(manager_email)<0){
                str = manager_email +';'+ msg;
                $('#to_email').val(str).blur();
            }
        }else{
            if(msg_arr.indexOf(manager_email)>=0){
                var index = msg_arr.indexOf(manager_email);
                msg_arr.splice(index,1,'');
                for(var j=0;j<msg_arr.length;j++){
                    if(msg_arr[j].length>0&&j<msg_arr.length-1){
                        str+=msg_arr[j]+';';
                    }else if(j===(msg_arr.length-1)){
                        str+=msg_arr[j];
                    }
                }
                $('#to_email').val(str).blur();
            }
        }
        $('#to_email').attr("placeholder",manager_plh);
    });

    // 点击发送邮件
    $("#share_button").click(function(){
        var from_email = $("input[name='from_email']").val().replace(/\s/g,"");
        var to_emails_value = $("input[name='to_email']").val().replace(/\s/g,"");
        var to_emails = to_emails_value.split(';');
        var share_list_id = $("input[name='share_list_id']").val();
        var from_content = $("textarea[class='login_014 popup_con_textarea']").val();
        var	patten = /^[0-9A-Za-z][\w\.\-\+]*\@[\w\.\-\+]+\.[\w\.\-]+[A-Za-z]$/;
        var checkbox = $("#checkbox").is(':checked');
        var from_page = $("#from_page").val();
        var save_item_id = $("#save_item_id").val();
        if(!from_email){
            $('.from_email').text("<?php echo FS_SHOP_CART_ALERT_JS_44; ?>").show();
        }else if(from_email.length > 0 && !patten.test(from_email)){
            $('.from_email').text("<?php echo FS_SHOP_CART_ALERT_JS_45; ?>").show();
        }else{
            $('.from_email').hide();
        }
        if(to_emails_value.length<=0){
            $('.to_email').text("<?php echo FS_SHOP_CART_ALERT_JS_44_01; ?>").show();
            return false
        }else{
            for(var i=0;i<to_emails.length;i++){
                if(!patten.test(to_emails[i]) && to_emails[i].length>0){
                    $('.to_email').text("<?php echo FS_SHOP_CART_ALERT_JS_45; ?>").show();
                    return false
                }
            }
        }

        if(!from_email || from_email.length < 4 || !patten.test(from_email)){
            return false;
        }else {
            $.ajax({
                url: "ajax_save_shopping_list.php?type=save_share_new",
                type: "POST",
                data: {
                    from_email:from_email,
                    to_emails:to_emails_value,
                    from_content:from_content,
                    share_list_id:share_list_id,
                    from_page:from_page,
                    save_item_id:save_item_id
                },
                dataType: "json",
                beforeSend: function(){
                    $("#share_button").attr('disabled',true).addClass('choosez');
                },
                success: function(data){
                    if(data.result){
                        $('#share_cart,#share_cart_main').hide();
                        $('#been_sent,#been_sent_main').show();
                        $("#share_button").removeAttr('disabled').removeClass('choosez');;
                        if(customer_email){
                            $("#from_email").val(customer_email);
                            $("#to_email").val(admin_name);
                        }else{
                            $("#from_email").val("");
                            $("#to_email").val("");
                        }
                        $(".popup_con_textarea").val("");
                        $("#share_button").val(sendEmail).remove('disabled');
                    }else{
                        $('.email_error_prompt').html(data.msg).show();
                        // window.location.reload();
                    }

                }
            });
        }
    });

    // 邮箱验证
    $('.send_email_for_cart .big_input').blur(function(){
        var from_email = $("input[name='from_email']").val().replace(/\s/g,"");
        var to_email = $("input[name='to_email']").val().replace(/\s/g,"");
        var	patten = /^[0-9A-Za-z][\w\.\-\+]*\@[\w\.\-\+]+\.[\w\.\-]+[A-Za-z]$/;
        var mailArr = to_email.split(';');
        $(this).siblings('.popup_con_txt').hide();
        if($(this).attr('name') === 'from_email'){
            if(!patten.test($(this).val()) && $(this).val().length>0){
                $(this).siblings('.popup_con_txt').text('<?php echo FS_SHOP_CART_ALERT_JS_45; ?>').show();
            }else{
                $(this).siblings('.popup_con_txt').text("<?php echo FS_SHOP_CART_ALERT_JS_44_01; ?>").hide();
            }
        }
        if($(this).attr('name') === 'to_email'){
            for(var i=0;i<mailArr.length;i++){
                if(!patten.test(mailArr[i]) && mailArr[i].length>0){
                    $(this).siblings('.popup_con_txt').text('<?php echo FS_SHOP_CART_ALERT_JS_45; ?>').show();
                }
            }
        }
    });

    $('#save_cart_name').bind('input propertychange',function () {
        $('#save_cart_error').hide();
    });

    var oSaveCartNameTime = $('#save_cart_name').attr('placeholder');

    $('#save_cart_name').focus(function(){
        oSaveCartNameTime = $(this).attr('placeholder');
        $(this).attr('placeholder','');
    });

    $('#save_cart_name').blur(function(){
        var date = $('#save_cart_name').val();
        if($(this).val() === ""){
            $(this).attr('placeholder',oSaveCartNameTime);
            $(this).val(oSaveCartNameTime);
            oSaveCartNameTime = "";
        }else{
            oSaveCartNameTime = $(this).val();
        }
    });

    $('#datetime').bind('input propertychange',function () {
        $('.save_prompt').hide();
    });

    var oSaveCartName = $('#datetime').attr('placeholder');

    $('#datetime').focus(function(){
        oSaveCartName = $(this).attr('placeholder');
        $(this).attr('placeholder','');
    });

    $('#datetime').blur(function(){
        var date = $('#datetime').val();
        if($(this).val() === ""){
            $(this).attr('placeholder',oSaveCartName);
            $(this).val(oSaveCartName);
            oSaveCartName = "";
        }else{
            oSaveCartName = $(this).val();
        }
    });

    $('#datetime').on('keyup',function () {
        if($(this).val().length>49){
            $('.save_prompt').text('<?php echo FS_SAVE_CSRT_LIMIT_TIP;?>').show();
        }else{
            $('.save_prompt').hide();
        }
    });

    $('#save_yes').click(function(){
        var text =  $('#datetime').val();
        var date = (text!== "") ? $.trim(text) : oSaveCartName;
        var errorDom = $('.save_prompt');
        if(date.length===""){
            errorDom.text('<?php echo FS_SHOP_CART_ALERT_JS_47; ?>').show();
            return false;
        }
        if(date==='0'){
            errorDom.text('<?php echo FS_SHOP_CART_ALERT_JS_48; ?>').show();
            return false;
        }
        if(date.length>49){
            errorDom.text('<?php echo FS_SAVE_CSRT_LIMIT_TIP;?>').show();
            return false;
        }
        $.ajax({
            url: "index.php?modules=ajax&handler=ajax_saved_shopping_cart&ajax_request_action=saved_shipping",
            data: {date:date},
            type: "POST",
            success: function(data){// data字符串类型
                if (typeof _faq !== 'undefined') {
                    //数据统计 add by ternence
                    _faq.push(['trackEvent', 'save_cart_click', {}, '5']);
                }
                if(data == 1){
                    window.location.href="<?php echo zen_href_link('login'); ?>";
                }else if(data == 2){
                    errorDom.text('<?php echo FS_SHOP_CART_ALERT_JS_49; ?>').show();
                }else{
                    window.location.href="<?php echo zen_href_link('saved_cart_details').'&type='; ?>"+data;
                }
            }
        });
    })

    $('#shipping_save_cart').click(function(){
        // var cart_save_name =  $('#save_cart_name').val();
        var text =  $('#save_cart_name').val();
        var cart_save_name = (text!== "") ? $.trim(text) : oSaveCartNameTime;
        var errorDom = $('#save_cart_error');
        var is_true = cart_save_name;
        if(cart_save_name.length===""){
            errorDom.text('<?php echo FS_SHOP_CART_ALERT_JS_47; ?>').show();
            return false;
        }
        if(cart_save_name==='0'){
            errorDom.text('<?php echo FS_SHOP_CART_ALERT_JS_48; ?>').show();
            return false;
        }
        if(cart_save_name.length>149){
            errorDom.text('<?php echo FS_SAVE_CSRT_LIMIT_TIP_CART;?>').show();
            return false;
        }
        var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
        if(pattern.test(cart_save_name)){
            $('#save_cart_error').html(123123123123);
        }
        if (!is_true) {
            errorDom.text('<?php echo FS_CART_NAME_ALREADY_EXISTED;?>').show();
            return false;
        }
        $.ajax({
            url: "index.php?modules=ajax&handler=ajax_saved_shopping_cart&ajax_request_action=saved_shipping",
            data: {date:cart_save_name},
            type: "POST",
            beforeSend: function () {
                $('#fs_loading_bg_cart,#fs_loading_cart').show();
            },
            success: function(data){// data字符串类型
                if (typeof _faq !== 'undefined') {
                    //数据统计 add by ternence
                    _faq.push(['trackEvent', 'save_cart_click', {}, '5']);
                }
                if(data == 1){
                    window.location.href="<?php echo zen_href_link('login'); ?>";
                }else if(data == 2){
                    errorDom.text('<?php echo FS_CART_NAME_ALREADY_EXISTED; ?>').show();
                }else if(data == 4){
                    $('#fs_loading_bg_cart,#fs_loading_cart').hide();
                    errorDom.text('<?php echo FS_CART_NAME_ALREADY_EXISTED;?>').show();
                }else{
                    var locad_url = "<?php echo zen_href_link('saved_cart_details').'&type='; ?>"+data;
                    $('#fs_loading_bg_cart,#fs_loading_cart').hide();
                    $('#shopping_cart_save').hide();
                    var html = '<p class="Save_Cart_window_tit"><i class="iconfont icon">&#xf186;</i>'+create_title +'</p>\n' +
                        '    <p class="Save_Cart_window_txt"><a href="'+ locad_url +'"> '+cart_save_name+' </a>'+ create_has_add +'</p>';
                    if (lang == 'jp') {
                        html = '<p class="Save_Cart_window_tit"><i class="iconfont icon">&#xf186;</i>'+create_title +'</p>\n' +
                            '    <p class="Save_Cart_window_txt">'+''+'<a href="'+ locad_url +'">'+cart_save_name+'</a>'+'が保存したカートリストに追加されました。' +'</p>';
                    }
                    $('.addCart_cont').html(html);
                    $('#saved_cart_name_success').show();
                    $('#saved_cart_name_update').val();
                    setTimeout(function () {
                        window.location.href="<?php echo zen_href_link('saved_cart_details').'&type='; ?>"+data;
                    },3000);
                }
            }
        });
    });
    
    function close_cart_window() {
        $('#save_cart_name').val('');
        $('#save_cart_error').hide();
        $('#shopping_cart_save').hide();
    }
    
    function shopCartName(_this) {
        var cart_save_name = $(_this).val();
        var errorDom = $(_this).parents('.errorParent').find('.error_prompt');
        if(cart_save_name.length>149){
            errorDom.text('<?php echo FS_SAVE_CSRT_LIMIT_TIP_CART;?>').show();
            return false;
        }
        var request_url = "index.php?modules=ajax&handler=ajax_saved_shopping_cart&ajax_request_action=saved_shipping_name";
        $.ajax({
            url: request_url,
            type: "POST",
            data: "cart_save_name=" + cart_save_name,
            dataType: "json",
            success: function (msg) {
                if (msg.status == 200) {
                    $('#save_cart_name_val').val(1);
                    $('#save_cart_error').hide();
                    return true;
                }
                $('#save_cart_name_val').val('');
                errorDom.html('<?php echo FS_CART_NAME_ALREADY_EXISTED;?>').show();
                return false;
            }
        })
    }
    $('#select_cart_name').click(function () {
        var cart_name = $('#select_cart_name').val();
        if (cart_name) {
            $('#save_cart_name_error').text('<?php echo FS_SELECT_SAVE_CART;?>').hide();
        }
    });
    $('#update_save_cart_name').click(function () {
        var options=$("#select_cart_name option:selected");
        var select_option = options.text();
        var cart_name = $('#select_cart_name').val();
        if (!cart_name){
            $('#save_cart_name_error').text('<?php echo FS_SELECT_SAVE_CART;?>').show();
            return false;
        }
        $.ajax({
            url: "index.php?modules=ajax&handler=ajax_saved_shopping_cart&ajax_request_action=update_save_cart",
            data: {cart_name:cart_name},
            type: "POST",
            beforeSend: function () {
                $('#fs_loading_bg_cart,#fs_loading_cart').show();
            },
            success: function(msg){// data字符串类型
                if (typeof _faq !== 'undefined') {
                    //数据统计 add by ternence
                    _faq.push(['trackEvent', 'save_cart_click', {}, '5']);
                }
                if(msg == 0){
                    window.location.href="<?php echo zen_href_link('login'); ?>";
                }else if (msg == 200) {
                    var redir_url = "<?php echo zen_href_link('saved_cart_details').'&type='; ?>"+cart_name;
                    $('#shopping_cart_save').hide();
                    $('#fs_loading_bg_cart,#fs_loading_cart').hide();
                    var html = '<p class="Save_Cart_window_tit"><i class="iconfont icon">&#xf186;</i>'+update_success +'</p>\n';
                    if (lang == 'jp') {
                        html +=  '    <p class="Save_Cart_window_txt">'+'新しいアイテムが保存したカート'+'<a href="'+redir_url+'">'+select_option+'</a>'+'に追加されました。'+'</p>';
                    } else if (lang == 'de') {
                        html +=  '    <p class="Save_Cart_window_txt">'+'Neue Artikel wurden Ihrem gespeicherten Warenkorb '+'<a href="'+redir_url+'">'+select_option+'</a> '+ 'hinzugefügt.' +'</p>';
                    } else if (lang == 'es') {
                        html +=  '    <p class="Save_Cart_window_txt">'+update_success_word+'<a href="'+redir_url+'"> '+select_option+'</a>.</p>';
                    } else {
                        html +=  '    <p class="Save_Cart_window_txt">'+update_success_word+'<a href="'+redir_url+'"> '+select_option+'</a></p>';
                    }
                    $('.addCart_cont').html(html);
                    $('#saved_cart_name_success').show();
                    $('#saved_cart_name_update').val();
                    setTimeout(function () {
                        window.location.href="<?php echo zen_href_link('saved_cart_details').'&type='; ?>"+cart_name;
                    },3000);
                }
            }
        });
    });
</script>
