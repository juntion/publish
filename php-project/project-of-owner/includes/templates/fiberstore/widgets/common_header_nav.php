<?php
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版导航 使用后台管理
// 是否显示 en、小语种、de-en\uk\au代码不一样
$file_nav_path = DIR_FS_SQL_CACHE."/htmls/".$_SESSION['languages_code'].'/';
$file_nav_name = "header_nav_ob_".$common_is_mobile.'_'.$_SESSION['countries_iso_code'].'.html';  //头部company 图片本地化区分分仓
$file_nav_path_name = $file_nav_path.$file_nav_name;
?>
<div class="header_main">
    <?php
    if (!file_exists($file_nav_path_name) || $_SERVER['SERVER_NAME'] != "www.fs.com") {
        ob_start();
        // 获取数据
        require_once('includes/classes/homePageClass.php');
        $home_page = new homePageClass(['language_id' => $_SESSION['languages_id']]);
        $header_data = $home_page->get_header_or_footer_data();
        ?>
        <div class="header_main_list_more_all">
            <div class="header_main_list_more nav0">
                <div class="header_main_list_more allcategories show">
                    <div class="fs_home_nav_bg"></div>
                    <div class="home_solution_container">
                        <?php echo fiberstore_category::show_categories_new_home_new();?>
                    </div>
                </div>
            </div>

            <?php if(sizeof($header_data)){
                foreach ($header_data as $k => $nav){
                    ?>
                    <div class="header_main_list_more nav<?php echo $k + 1;?>">
                        <div class="home_solution_container">
                            <div class="home_solution_flex_container">
                                <h3 class="fs_home_tit"><?php echo $nav['title'];?></h3>
                                <a href="javascript:;" class="iconfont icon home_solution_close"></a>
                                <?php if($k <= 2){ ?>
                                    <div class="new_support_content">
                                        <div class="new_support_content_left">
                                            <p class="new_support_content_tit"><?php echo $nav['left_content'];?></p>
                                            <ul class="new_support_content_ul after">
                                                <?php if(sizeof($nav['data']['list'])){
                                                    foreach ($nav['data']['list'] as $dk => $data){
                                                        $style = '';
                                                        if(!$data['url']){
                                                            $data['url'] = 'javascript:void(0);';
                                                            $style = 'style="text-decoration: none;"';
                                                        }
                                                        echo '<li><a '.$style.' '.$data['is_click'].' href="'.$data['url'].'">'.$data['title'].'</a></li>';
                                                    }
                                                }?>
                                            </ul>
                                        </div>
                                        <div class="new_support_content_right">
                                            <img class="home_solution_img" src="<?php echo HTTPS_IMAGE_SERVER.$nav['left_img'];?>" alt="<?php echo $nav['left_title'];?>">
                                        </div>
                                    </div>
                                <?php }elseif ($k == 3){ ?>
                                    <div class="home_solution_flex">
                                        <dl class="home_solution_dl">
                                            <dt>
                                                <a target="_blank" href="<?php echo $nav['community_data'][0]['community_url'];?>">
                                                    <img class="home_solution_img" src="<?php echo HTTPS_IMAGE_SERVER.$nav['left_img'];?>" alt="<?php echo $nav['left_title'];?>">
                                                </a>
                                                <span class="fs_home_insights"><?php echo $nav['community_data'][0]['community_sign'];?><i></i></span>
                                                <?php if($nav['community_data'][0]['community_video_time']){
                                                    echo '<span class="fs_home_video_time"><i class="iconfont icon">&#xf449;</i>'.$nav['community_data'][0]['community_video_time'].'<em></em></span>';
                                                }?>

                                            </dt>
                                            <dd>
                                                <h3 class="home_solution_ul_tit"><a target="_blank" href="<?php echo $nav['community_data'][0]['community_url'];?>"><?php echo $nav['community_data'][0]['community_title'];?></a></h3>
                                                <p class="home_solution_ul_txt"><?php echo $nav['community_data'][0]['community_content'];?></p>
                                            </dd>
                                        </dl>
                                        <dl class="home_solution_dl">
                                            <dt>
                                                <img class="home_solution_img" src="<?php echo HTTPS_IMAGE_SERVER.$nav['right_img'];?>" alt="<?php echo $nav['right_title'];?>">
                                                <div class="fs_home_ommunity_bg">
                                                    <div>
                                                        <p class="fs_home_ommunity_tit"><?php echo $nav['right_title'];?></p>
                                                        <?php if($nav['data']['button']){
                                                            ?>
                                                            <a class="fs_home_ommunity_a" target="_blank" href="<?php echo $nav['data']['button'][0]['url'];?>"><?php echo $nav['data']['button'][0]['title'];?></a>
                                                            <?php
                                                        }?>
                                                    </div>
                                                </div>
                                            </dt>
                                            <dd>
                                                <ul class="fs_home_service_ul">
                                                    <?php if(sizeof($nav['data']['list'])){
                                                        foreach ($nav['data']['list'] as $key => $data){
                                                            $title = $data['url'] ? '<a target="_blank" href="'.$data['url'].'">'.$data['title'].'</a>' : $data['title'];
                                                            echo '<li>'.$title.'</li>';
                                                        }
                                                    }?>
                                                </ul>
                                            </dd>
                                        </dl>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }?>
        </div>
        <div class="ob_nav_bar">
            <a class="header_logo" href="<?php echo zen_href_link(FILENAME_DEFAULT,'','SSL');?>">
                <img width="72" height="35" src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/new-pc-img/fs-logo-pc.png" alt="Fs logo.svg">
            </a>
            <ul class="header_main_firstul <?php echo in_array($_SESSION['languages_code'],array('es','mx')) ? 'header_main_firstul_es' : '';?>">
                <li class="header_main_list header_main_index_0">
                    <p class="header_main_list_font"><?php echo FS_ALL_CATEGORIES?></p>
                </li>
                <?php if(sizeof($header_data)){
                    foreach ($header_data as $key => $nav){
                        ?>
                        <li class="header_main_list header_main_index_<?php echo $key + 1;?>">
                            <p class="header_main_list_font"><?php echo $nav['title']; ?></p>
                        </li>
                        <?php
                    }
                }?>
                <i class="header_sign_more_arrow pc-header_sign_more_arrow" style="left: 112.133px;"></i>
                <span class="home_drop_down_carrier"></span>
            </ul>

            <script type="text/javascript">
                $(function () {
                    $('.categories-new, .categories-hot').each(function(){
                        $(this).closest('p').addClass('choose');
                    })

                    /*var ajax_flag = true;
                    $('.fs_home_new_product_change').click(function(){
                        $('.fs_home_new_product_bg,.fs_home_new_product #loader_order_alone').show();
                        var $obj = $(this).parents('.fs_home_new_product');
                        var index = $obj.find('.fs_home_new_product_public.active').index() + 1;
                        var maxlength = $obj.find('.fs_home_new_product_public').length;
                        if(ajax_flag){
                            var cid = $(this).attr('cid'),
                                page = parseInt($(this).attr('page'));
                            page++;
                            $(this).attr("page",page);
                            $.ajax({
                                url: "index.php?modules=ajax&handler=ajax_get_products&ajax_request_action=header_nav",
                                data: {'cid':cid,'page':page},
                                type: "POST",
                                dataType: "json",
                                beforeSend: function(){
                                },
                                success: function(response){
                                    if(response.status == 200){
                                        if(response.data.html != ''){
                                            $obj.find('.fs_home_new_product_container').append(response.data.html);
                                            $obj.find('.fs_home_new_product_public').eq(index).addClass('active').siblings('.fs_home_new_product_public').removeClass('active');
                                        }else{
                                            ajax_flag = false;
                                        }
                                    }
                                    $('.fs_home_new_product_bg,.fs_home_new_product #loader_order_alone').hide();
                                }
                            });
                        }else{
                            if (index == maxlength) {
                                $obj.find('.fs_home_new_product_public').eq(0).addClass('active').siblings('.fs_home_new_product_public').removeClass('active');
                            } else {
                                $obj.find('.fs_home_new_product_public').eq(index).addClass('active').siblings('.fs_home_new_product_public').removeClass('active');
                            }
                            setTimeout(function () {
                                $('.fs_home_new_product_bg,.fs_home_new_product #loader_order_alone').hide();
                            },300);
                        }
                    })*/
                })
            </script>
        <?php
        $buffer = ob_get_contents();
        ob_flush();
        ob_end_clean();
        if ($buffer) {
            cacheFactory::save_caching_file_contents($file_nav_name, $file_nav_path, $buffer);
        }
    } else {
        $buffer = file_get_contents($file_nav_path_name);
        echo $buffer;
    }
    ?>
        <div class="top_cart" id="ShoppingCartInfo" >
            <?php  echo $shopping_cart_help->show_cart_products_block($cart_items);?>
        </div>
        <?php
        $inquiry_cart_number = 0;
        if($_SESSION['inquiry_cart']['contents']){
            foreach ($_SESSION['inquiry_cart']['contents'] as $item){
                $inquiry_cart_number += (int)$item['qty'];
            }
            ?>
        <?php } ?>
        <div class="top_sign">
            <?php
            //ternence 2019.11.25 获取报价单数量
            if(check_login_id()) {
                $inquiry_count = zenGetQuotesNewCount();
            }
            if (!check_login_id()){ ?>
                <a href="<?php echo zen_href_link(FILENAME_LOGIN,'','SSL');?>" class="top_sign_a"><i class="iconfont icon"></i><span><?php echo FILENAME_SIGN_IN; ?></span></a>
                <div class="header_sign_more">
                    <div class="header_sign_more_arrow"></div>
                    <div class="header_sign_more_main">
                        <div class="hreder_wrapp">
                            <a class="header_sign_more_main_sign " onclick="$(this).addClass('choosez').find('.header_signTxt').css('opacity','0');" href="<?php if($_SESSION['login_timeout']){
                                echo zen_href_link(FILENAME_LOGIN,'type=1','SSL');
                            }else{
                                echo zen_href_link(FILENAME_LOGIN,'','SSL');
                            } ?>"><span class="header_signTxt"><?php echo FS_SIGN_IN;?></span>
                                <div class="loader_order"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                            </a>
                            <p class="header_sign_more_main_register"><?php echo FS_NEW_CUSTOMER;?>
                                <a href="<?php echo zen_href_link('regist','','SSL');?>"><?php echo FS_REGISTER_ACCOUNT;?></a>
                            </p>
                        </div>

                        <div class="header_not_log">
                            <ul class="header_not_ul">
                                <li>
                                    <span class="header_not_ul_font">
                                        <?php
                                        if ($_SESSION['languages_code'] == 'fr') {
                                            echo strtoupper(str_replace('N° de ', '', FS_COMMON_HEADER_ACCOUNT));
                                        } else {
                                            echo strtoupper(FS_COMMON_HEADER_ACCOUNT);
                                        }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'','SSL');?>"><span><?php echo MANAGE_ORDER_HISTORY;?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('orders_review_list','','SSL');;?>"><span><?php echo FS_ACCOUNT_ORDER_REVIEWS_COUNT;?></span></a>
                                </li>
                                <li>
                                    <!--                                            <a href="--><?php //echo zen_href_link("inquiry","","SSL") ?><!--">--><?php //echo FS_INQUIRY_INFO_47; ?><!----><?php //  if($_SESSION['inquiry_cart']['contents']){ ?><!--<em class="header_number quote_a_number">--><?php //echo $inquiry_count; ?><!--</em>--><?php //}?><!--</a>-->
                                    <a href="<?php echo zen_href_link('quotes_list','status=1','SSL'); ?>"><span><?php echo FS_INQUIRY_INFO_37; ?></span><?php   if((int)$quote_type>0 || $inquiry_count>0){ ?><em class="header_number quote_a_number"><?php echo $inquiry_count; ?></em><?php }?></a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('saved_items','type=saved_carts','SSL');?>"><span><?php echo FS_SAVED_CARTS;?></span></a>
                                </li>
                                <?php if (check_login_id()){ ?>
                                    <li><i class="iconfont icon">&#xf254;</i>
                                        <a href="<?php echo zen_href_link('sales_service_request_list','','SSL');?>"><span><?php echo FS_RETURN_BUTTON;?></span></a>
                                    </li>
                                <?php } ?>
                                <!--
                                            <li><i class="iconfont icon">&#xf342;</i>
                                                <a href="<?php //echo zen_href_link('service_view_order_online');?>"><?php //echo FS_TRACK_YOUR_PACKAGE;?></a>
                                            </li>
                                            -->
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }else{
                $customer_first_name = ucfirst(zen_get_customer_fname_of_id($_SESSION['customer_id']));
                ?>
                <a href="<?php echo zen_href_link(FILENAME_MY_DASHBOARD,'','SSL');?>" class="top_sign_a hadLogin">
                    <i class="iconfont icon"></i>
                    <span  class="top_customer_name">
                                    <?php
                                    if($_SESSION['languages_code'] == 'jp'){
                                        echo $customer_first_name.FS_HELLO_JP_NEW;
                                    }else{
                                        echo $customer_first_name;
                                    }
                                    ?>
                                    <em class="iconfont top-new-downIc">&#xf087;</em>
                                </span>
                </a>
                <div class="header_sign_more">
                    <div class="header_sign_more_arrow"></div>
                    <div class="header_sign_more_main">
                        <div class="New-Numbering">
                            <a href="<?php echo zen_href_link(FILENAME_MY_DASHBOARD,'','SSL');?>">
                                <span class="top_hello">
                            <?php
                            if($_SESSION['languages_code'] == 'jp'){
                                echo $customer_first_name.FS_HELLO_JP.FS_HELLO.'！';
                            }elseif($_SESSION['languages_code'] == 'de'){
                                echo FS_HELLO.' '.$customer_first_name;
                            }else{
                                echo FS_HELLO.', '.$customer_first_name;
                            }
                            ?>
                                </span>
                            </a>
                            <div class="header_sign_more_accountNo">
                            <span class="Numbering-span">
                                 <?php echo FS_ACCOUNT_NEW;?>
                                 <a href="<?php echo zen_href_link(FILENAME_MY_DASHBOARD,'','SSL');?>">
                                     <?php echo $_SESSION['customers_number_new'];?>
                                 </a>
                            </span>
                            </div>
                        </div>
                        <div class="header_not_log">
                            <ul class="header_not_ul">
                                <li>
                                    <span class="header_not_ul_font">
                                        <?php
                                            if ($_SESSION['languages_code'] == 'fr') {
                                                echo strtoupper(str_replace('N° de ', '', FS_COMMON_HEADER_ACCOUNT));
                                            } else {
                                                echo strtoupper(FS_COMMON_HEADER_ACCOUNT);
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'','SSL');?>"><span><?php echo MANAGE_ORDER_HISTORY;?></span></a><?php
                                    if($common_orderNum){echo '<em class="header_number">'.$common_orderNum.'</em>';}?>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('orders_review_list','','SSL');;?>"><span><?php echo FS_ACCOUNT_ORDER_REVIEWS_COUNT;?></span></a>
                                </li>
                                <li>
                                    <?php
                                    //add by ternence 新报价单数量
                                    $quote_type=0;
                                    if(check_login_id()){
                                        $quote_type = get_quote_checked_type_number();
                                    }
                                    ?>
                                    <a href="<?php echo zen_href_link('quotes_list','click_type=17&status=1','SSL'); ?>"><span><?php echo FS_INQUIRY_LIST_2; ?></span>
                                        <?php if((int)$quote_type>0){ ?>
                                            <em class="header_number quote_a_number">
                                                <?php echo (int)$quote_type>0?$quote_type:$inquiry_count; ?>
                                            </em>
                                        <?php }?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo zen_href_link('saved_items','type=saved_carts','');?>">
                                        <span><?php echo FS_SAVED_CARTS;?></span>
                                        <?php
                                        $saved_carts_num = get_save_cart_data(' customer_id ='.$_SESSION['customer_id'],false);
                                        if($saved_carts_num > 0){
                                            echo '<em class="header_number quote_a_number">'.$saved_carts_num.'</em>';
                                        }
                                        ?>
                                    </a>
                                </li>
                                <li class="already_sign_last_href">
                                    <a href="<?php echo zen_href_link('browsing_history');?>"><span><?php echo FS_RECENTLY_VIEWED;?></span></a>
                                </li>
                                <!--
                                            <li><i class="iconfont icon">&#xf254;</i>
                                                <a href="<?php //echo zen_href_link('sales_service_request_list','','SSL');?>"><?php echo FS_RETURN_BUTTON;?></a>
                                                <?php //if($common_caseNum){echo '<em class="header_number">'.$common_caseNum.'</em>';}?>
                                            </li>
                                            <li><i class="iconfont icon">&#xf342;</i>
                                                <a href="<?php //echo zen_href_link('service_view_order_online');?>"><?php //echo FS_TRACK_YOUR_PACKAGE;?></a>
                                            </li>
                                            -->
                            </ul>
                        </div>

                        <div class="header_not_btm">
                            <h2><a href="<?php echo zen_href_link(FILENAME_LOGOFF,'','SSL');?>" onclick="localStorage.removeItem('fs_is_login');localStorage.removeItem('fs_session_select_send_time');"><?php echo FS_COMMON_HEADER_OUT;?></a></h2>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="header_main_search">
            <span class="aron_barry_clear_input icon iconfont" <?php if($common_default_search_key){ echo 'style="display: inline;"';} ?>>&#xf092;</span>
            <form action="<?php echo zen_href_link(FILENAME_DEFAULT); ?>" onsubmit="return checkSearhEmpty();">
                <?php echo zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);?>
                <input type="text" class="header_main_search_txt" name="keyword" id="CityAjax" autocomplete="off" value="<?php echo $common_default_search_key; ?>" />
                <button type="submit" class="header_main_search_btn icon iconfont" name="searchSubmit" value="<?php echo FS_HEADER_SEARCH;?>">&#xf143;</button>
                <div class="ac_results"></div>

                <!-- hot search -->
                <div class="fs_search_results">
                    <div class="fs_search_default">
                        <?php
                        //最近搜索
                        $recent_researches = isset($_COOKIE['recent_searches']) ? $_COOKIE['recent_searches'] : [];
                        if (!empty($recent_researches)) {
                            $recent_researches = json_decode($recent_researches, true);
                        }

                        $current_language_id = $_SESSION['languages_id'];
                        if($_SESSION['languages_code'] == 'au' || $_SESSION['languages_code'] == 'uk' || $_SESSION['languages_code'] == 'dn'){
                            $current_language_id = 1;
                        }
                        //热搜
                        $sql = "select hot_search_id,search_word,weight,search_type from hot_search where language_id=".$current_language_id." order by search_type asc,weight desc limit 0,8";
                        $hot_searches = $db->getAll($sql);
                        if (empty($hot_searches)) {
                            $hot_searches = [];
                        }

                        if (count($hot_searches) > 0) {
                            foreach ($hot_searches as $key => $value) {
                                //对展示的hot search的次数加1
                                $db->Execute("update hot_search set show_times=show_times+1 where hot_search_id='".$value['hot_search_id']."' and language_id='".$current_language_id."'");
                            }
                        }


                        ?>
                        <dl class="fs_search_default_dl fs_recent_search" <?php if (count($recent_researches) <= 0) { echo 'style="display:none;"';} ?> >
                            <dt><?php echo FS_RECENT_SEARCH;?></dt>
                            <dd>
                                <?php if (count($recent_researches) > 0){?>
                                    <?php foreach ($recent_researches as $key => $value) {?>
                                    <a target="_blank" href="<?php echo reset_url('index.php')?>?main_page=advanced_search_result&keyword=<?php echo $value;?>&searchSubmit=Search">
                                        <?php echo $value;?>
                                        <i class="iconfont icon" onclick="remove_recent_search(this, '<?php echo $value;?>')"></i>
                                    </a>
                                    <?php }?>
                                <?php }?>

                            </dd>
                        </dl>
                        <dl class="fs_search_default_dl fs_hot_search">
                            <dt>
                                <?php echo FS_HOT_SEARCH;?>
                                <a href="javascript:;" onclick="change_hot_search(this)"><i class="iconfont icon"></i><span><?php echo FS_CHANGE;?></span></a>
                            </dt>
                            <dd>
                                <?php if (count($hot_searches) > 0) {?>
                                    <?php foreach ($hot_searches as $key => $value) {?>
                                        <a target="_blank" data-page="1" href="<?php echo reset_url('index.php')?>?main_page=advanced_search_result&keyword=<?php echo $value['search_word'];?>&searchSubmit=Search"><?php echo $value['search_word'];?></a>
                                    <?php }?>
                                <?php }?>
                            </dd>
                        </dl>
                    </div>

                    <div class="real_time_results" style="display:none;">
                        <ul class="real_time_results_ul">

                        </ul>
                    </div>

                </div>
                <!-- hot search -->

            </form>
        </div>
    </div>
</div>

