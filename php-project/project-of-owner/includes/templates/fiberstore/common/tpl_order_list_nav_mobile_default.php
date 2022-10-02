<?php //移动端订单状态切换和时间选择 fallwind 2017.6.8 ?>
<link rel="stylesheet" type="text/css" media="all"  href="<?php echo auto_version('/includes/templates/fiberstore/css/filterType.css',$code);?>" />
<div class="m_new17my_orders_type">
    <a href="javascript:;">
        <span class="icon iconfont"></span>
        <?php echo MANAGE_ORDER_FILTER;?>
    </a>
</div>
<div class="m_new17my_orders_type_filter_layer">
    <div class="new_popup_main popup_width680 pupop_video alone_wap">
        <h2 class="new_popup_tit">
            <strong><?php echo MANAGE_ORDER_FILTER;?></strong>
            <a href="javascript:;">
                <span class="icon iconfont"></span>
            </a>
        </h2>
        <div class="new_popup_content">
            <!-- 内容 -->
            <div class="select_order">
                <div class="m_footer_03_one m_footer_03_one2">
                    <div class="m_footer_03_inner m_footer_selects">
                        <a href="javascript:;" class="m_footer_p_inner select_ico"><span><?php echo MANAGE_ORDER_TYPE;?></span><i
                                    class="icon iconfont icon_rights icon_rights_2"></i>
                        </a>
                    </div>
                    <div class="m_footer_03_two m_footer_03_Text" style="display: none;">
                        <div class="m_footer_03_text_info">
                            <div class="new_popup_content">
                                <form method="post" id="orderForm" onclick="return false;">
                                    <div class="new_dl_wap01">
                                        <div class="new_input_wap01" id="cancel_reason_block">
                                            <ul class="new_order_ul" name="order_status">
                                                <li <?php echo (!$order_status  || $order_status=='all') ? 'class="active"' : ''; ?> data-text="">
                                                    <a href="javascript:;" data-text="">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_ALL;?></a>
                                                </li>
                                                <li <?php echo ('pending' == $order_status) ? 'class="active"' : ''; ?> data-text="pending">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_PENDING;?></a>
                                                </li>
                                                <li <?php echo ('progressing' == $order_status) ? 'class="active"' : ''; ?> data-text="progressing">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_PROGRESSING;?></a>
                                                </li>
                                                <li <?php echo ('completed' == $order_status) ? 'class="active"' : ''; ?> data-text="completed">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_COMPLETED;?></a>
                                                </li>
                                                <li <?php echo ('canceled' == $order_status) ? 'class="active"' : ''; ?> data-text="canceled">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_CANCELLED;?></a>
                                                </li>
                                                <?php if (in_array($apply_type,[2,13,17])) { ?>
                                                    <li <?php echo ('purchase' == $order_status) ? 'class="active"' : ''; ?> data-text="purchase">
                                                        <a href="javascript:;" data-text="pending">
                                                            <span class="acc_radio"><i></i></span><?php echo FS_ORDER_PURCHASE;?></a>
                                                    </li>
                                                <?php } ?>
                                                <li <?php echo ($_GET['main_page'] == 'sales_service_list') ? 'class="active"' : ''; ?> data-text="sales_service_list">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo FS_ORDER_RETURN_ITEM;?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m_footer_03_one m_footer_03_one2">
                    <div class="m_footer_03_inner m_footer_selects">
                        <a href="javascript:;" class="m_footer_p_inner select_ico"><span><?php echo MANAGE_ORDER_TIME_FILTER;?></span><i
                                    class="icon iconfont icon_rights icon_rights_2"></i>
                        </a>
                    </div>
                    <div class="m_footer_03_two m_footer_03_Text" style="display: none;">
                        <div class="m_footer_03_text_info">
                            <div class="new_popup_content">
                                <form method="post" id="orderForm" onclick="return false;">
                                    <div class="new_dl_wap01">
                                        <div class="new_input_wap01" id="cancel_reason_block">
                                            <ul class="new_order_ul" name="type">
                                                <li <?php echo (!$_GET['type'] || $_GET['type']=='all') ? 'class="active"' : ''; ?> data-text="">
                                                    <a href="javascript:;" data-text="">
                                                        <span class="acc_radio"><i></i></span><?php echo MANAGE_ORDER_ALL;?></a>
                                                </li>
                                                <li <?php echo ($_GET['type'] == 'month') ? 'class="active"' : ''; ?> data-text="month">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo MANAGE_ORDER_MONTH;?></a>
                                                </li>
                                                <li <?php echo ($_GET['type'] == 'three_month') ? 'class="active"' : ''; ?> data-text="three_month">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo MANAGE_ORDER_THREE_MONTHS;?></a>
                                                </li>
                                                <li <?php echo ($_GET['type'] == 'year') ? 'class="active"' : ''; ?> data-text="year">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo MANAGE_ORDER_YEAR;?></a>
                                                </li>
                                                <li <?php echo ($_GET['type'] == 'one_year_ago') ? 'class="active"' : ''; ?> data-text="one_year_ago">
                                                    <a href="javascript:;" data-text="pending">
                                                        <span class="acc_radio"><i></i></span><?php echo MANAGE_ORDER_YEAR_AGO;?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button_box_filter">
            <div class="new_td new_td_three">
                <a class="new_alone_button order_list_btn_common alone_none_border" href="javascript:;" id="mobile_search_submit"><?php echo MANAGE_ORDER_APPLY;?></a>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var language = "<?php echo $_SESSION['languages_code'] == 'en' ? '' : $_SESSION['languages_code'];?>";
        var from_page = "<?php echo $_GET['main_page'];?>";
        // mobile version search start
        $('.m_new17my_orders_type_filter_layer_body li').click(function(){
            $(this).find('input').attr('checked',true);
            $(this).siblings().find('input').attr('checked',false);
            $(this).find('span').html('&#xf021;');
            $(this).siblings().find('span').html('&#xf022;');
        })
        $('.new_popup_tit a').click(function(){
            $('.m_new17my_orders_type_filter_layer').hide();
        })
        $('.m_new17my_orders_type').click(function(){
            $('.m_new17my_orders_type_filter_layer').show();
        })
        $('#mobile_search_submit').click(function(){
            var order_status = $('ul[name=order_status] .active').attr("data-text");
            var type = $('ul[name=type] .active').attr("data-text");
            if(from_page == 'sales_service_list'){
                if(order_status != 'sales_service_list'){
                    location.href = language+'/index.php?main_page=manage_orders&search=&order_status='+order_status+'&type='+type;
                }else{
                    $('#search_time').val(type);
                    $('.search_form').submit();
                }
            }else{
                if(order_status == 'sales_service_list'){
                    location.href = language+'/index.php?main_page=sales_service_list&search=&type='+type;
                }else{
                    $('#order_status').val(order_status);
                    $('#time_type').val(type);
                    $('#order_search_form').submit();
                }
            }

        })
        // mobile version search end
    })
</script>