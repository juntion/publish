<div class="eos_container">
    <div class="eos_width">
        <div class="eos_top eos_background">
            <h3 class="eos_top_tit"><?php echo META_TAGS_EOS_TITLE; ?></h3>
            <p class="eos_top_txt"><?php echo EOS_TOP_TXT_1; ?></p>
            <p class="eos_top_txt"><?php echo EOS_TOP_TXT_2; ?></p>
            <p class="eos_top_txt"><?php echo EOS_TOP_TXT_3; ?></p>
            <p class="eos_top_txt"><?php echo EOS_TOP_TXT_4; ?></p>
        </div>
        <div class="eos_bottom" id="eos_bottom">
            <div class="eos_flex">
                <div class="td-left">
                    <div class="left-tree">
                        <div class="download_search_container">
                            <form action="<?php echo zen_href_link('offline_products_eos', '', 'SSL'); ?>" method="get"
                                  id="search_form">
                                <input type="hidden" name="main_page" value="offline_products_eos">
                                <input class="download_search_input" name="eos_keyword" value="<?php echo $eos_keyword; ?>"
                                       placeholder="<?php echo EOS_SEARCH_TITLE; ?>">
                                <a href="javascript:;" id="case_search">
                                    <i class="iconfont icon"></i>
                                </a>
                            </form>
                        </div>

                        <div class="three_level_linkage">
                            <ul class="selector_stair_ul">
                                <?php foreach ($categories_arr as $key => $val) { ?>
                                    <li class="selector_stair_li">
                                        <dl class="selector_stair_dl">
                                            <dt class="selector_stair_dt">
                                                <i class="iconfont icon"><?php if ($parent_id == $val['categories_id']) {
                                                        echo '&#xf087;';
                                                    } else {
                                                        echo '&#xf089;';
                                                    } ?></i>
                                                <span ><?php echo $val['categories_name']; ?></span>
                                            </dt>
                                            <?php if (!empty($val['second'])) { ?>
                                                <dd class="selector_stair_dd"
                                                    style="display: <?php if ($parent_id == $val['categories_id']) {
                                                        echo 'block';
                                                    } else {
                                                        echo 'none';
                                                    } ?>;">
                                                    <?php foreach ($val['second'] as $key2 => $val2) { ?>
                                                        <dl class="second_level_dl <?php if ($cid == $val2['categories_id']) {
                                                            echo 'current';
                                                        } ?>">
                                                            <a href="<?php echo zen_href_link('offline_products_eos', 'pid=' . $val2['parent_id'] . '&cid=' . $val2['categories_id'], 'SSL'); ?>">
                                                                <dt class="second_level_dt"  onclick="showLoading()">
                                                                    <i class="iconfont icon">&#xf089;</i>
                                                                    <span class=" <?php if ($cid == $val2['categories_id']) {
                                                                        echo 'current';
                                                                    } ?>">
                                                                    <?php echo $val2['categories_name']; ?> </span>
                                                                </dt>
                                                            </a>
                                                        </dl>

                                                    <?php } ?>
                                                </dd>
                                            <?php }; ?>
                                        </dl>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <input type="hidden" id="model_keyword" value="">
                    </div>
                </div>

                <div class="td-right">
                    <h4 class="td-right-main-title"><?php echo $search_title; ?></h4>
                    <div class="eos_table">
                        <div class="eos_tr eos_th">
                            <dl class="eos_dl">
                                <dt><?php echo EOS_LIST_TITLE_1; ?></dt>
                                <dd>
                                    <div class="eos_td eos_one">

                                    </div>
                                    <div class="eos_td eos_two">
                                        <span class="eos_date"><?php echo EOS_LIST_TITLE_2; ?></span>
                                    </div>
                                    <div class="eos_td eos_three">
                                        <div class="eos_product"><?php echo EOS_LIST_TITLE_3; ?></div>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                        <div class="eos_empty" style="<?php if($total_num<1){echo 'display:block;';}; ?>">
                            <?php echo EOS_LIST_EMPTY; ?>
                        </div>
                        <div class="eos_content">
                            <?php foreach ($offlineProducts as $key => $val) { ?>

                                <div class="eos_tr">
                                    <dl class="eos_dl">
                                        <dt>
                                            <img src="<?php echo $val['products_image']; ?>"/>
                                        </dt>
                                        <dd>
                                            <div class="eos_td eos_one">
                                                <p class="eos_th_txt"><?php echo $val['products_name']; ?></p>
                                                <p class="eos_model">
                                                    <?php if ($val['products_model']) {
                                                        echo 'FS P/N:' . $val['products_model'];
                                                    } ?>
                                                    <em>#<?php echo $val['products_id']; ?></em></p>
                                            </div>
                                            <div class="eos_td eos_two">
                                            <span class="eos_date">
                                                <em class="eos_640"><?php echo EOS_LIST_TITLE_2; ?>：</em> <?php echo $val['offline_time']; ?></span>
                                            </div>
                                            <div class="eos_td eos_three">
                                                <div class="eos_product">
                                                    <em class="eos_640"><?php echo EOS_LIST_TITLE_3; ?>：</em>
                                                    <?php if ($val['offline_replace_products_id']) {
                                                        echo "<a target='_blank' href='" . $val['offline_replace_products_url'] . "'>#" . $val['offline_replace_products_id'] . "</a>";
                                                    } else {
                                                        echo '/';
                                                    } ?>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <div class="FS_Newpation_en">
                        <?php echo $pageService->pageDisplay(); ?>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<div class="spinWrap list_fsLoading" style="display:none;">
    <div class="bg_color"></div>
    <div id="loader_order_alone" class="loader_order">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
        </svg>
    </div>
</div>
<script>

</script>
<script type="text/javascript">
    Download_Navigation('.selector_stair_dt', '.selector_stair_dd', 1);
    Download_Navigation('.second_level_dt', '.second_level_dd', 2);

    $('#case_search').click(function () {
        showLoading()
        $('#search_form').submit();
    })

    function showLoading(){
        $('.list_fsLoading').show();
    }

    function Download_Navigation(a, b, k) {
        $(a).on('click', function () {

            var _this = $(this).parent();
            if (k == 1) {
                _this = $(this).parent().parent();
            }
            if (_this.hasClass('active')) {
                $('.selector_stair_ul').find('i').removeClass('current');
                $('.selector_stair_ul').find('span').removeClass('current');
                _this.removeClass('active');
                _this.find('.active').removeClass('active');
                _this.find('dd').slideUp(300);
                event.stopPropagation();
            } else {
                $('.selector_stair_ul').find('i').html('&#xf089;');
                $('.selector_stair_ul').find('i').removeClass('current');
                $('.selector_stair_ul').find('span').removeClass('current');
                $(this).next('.selector_stair_dt i').addClass('current');
                $(this).next('.selector_stair_dt span').addClass('current');
                $(this).find('i').addClass('current').html('&#xf087;');
                $(this).find('span').addClass('current');
                _this.addClass('active').siblings().removeClass('active');
                _this.siblings().find('.active').removeClass('active');
                _this.siblings().find('dd').slideUp(300);
                $("#model_keyword").val('');

                //ajax_get_products_models_and_files(k, $(this), '', 1);

                $(this).next(b).slideDown(300);
                event.stopPropagation();
            }
        })
    }
</script>