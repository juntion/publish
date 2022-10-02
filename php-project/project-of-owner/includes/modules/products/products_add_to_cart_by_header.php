<div class="product_sticky" id="products_add_cart">
    <div class="product_container">
        <div class="product_tab_wap" style="display:none;">
            <div class="product_proinfo">
                <dl class="after">
                    <dt><img src="<?php echo $products_final_image_to_display;?>" class="" alt="<?php echo $products_name;?>" title="<?php echo $products_name;$reviews_score?>"></dt>
                    <dd>
                        <h3><a href="javascript:window.scrollTo( 0, 0 );"><?php echo $products_name;?></a></h3>
                        <div>
                            <a class="gotoReview" href="javascript:;">
                            <?php
                            if ($reviews_total){
                                /*显示评论星级*/
                                $reviews_nums=substr($reviewsTotalInfo['rating'],-1);
                                $reviews_sums=substr($reviewsTotalInfo['rating'],0,1);
                                if($reviews_nums==0){
                                    $reviews_width=100;
                                }else{
                                    $reviews_width=$reviews_nums*10;
                                }
                                echo fs_product_reviews_level_show($reviewsTotalInfo['rating'],$reviews_width,$reviews_sums,'change_head_proStar');
                                ?>
                            </a>
                                <!--<a href="<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'#reviews';?>">-->
                                <a class="top_am por_review_btn" href="javascript:;">
                                    <?php
                                    if($_SESSION['languages_code'] =='ru'){
                                        //echo FS_REVIEWS . '<span> ' . $reviews_total . '</span>';
                                        echo $reviews_total . '<span> ' . FS_REVIEWS . '</span>';
                                    }else{
                                        if($reviews_total>1){
                                            echo '<span>' . $reviews_total . '</span> ' . FS_REVIEWS_SMALL;
                                        }else{
                                            echo '<span>' . $reviews_total . '</span> ' . FS_REVIEW;
                                        }
                                    }
                                    ?>
                                    </a>
                                <a class="product_topfix_help" href="javascript:void(0)" id="sccj7jn"></a>
                            <?php if(get_curr_time_section()==1){ ?>
                                <a href="<?php echo zen_href_link('live_chat_service_mail');?>" target="_blank"><span id="psj7jnl"><?php echo FS_PRODUCT_NEED_HELP;?></span></a>
                                <?php }else{ ?>
                                <a href="#" onclick="LC_API.open_chat_window();return false;"><span id="psj7jnl"><?php echo FS_PRODUCT_NEED_HELP;?></span></a>
                                <?php } ?>
                            <?php }else {?>
                                <span class="p_star11 new_pro_starGray" ></span> <a href="javascript:void(0);">
                                    <?php echo $_SESSION['languages_code'] == 'ru' ? FS_REVIEWS . '0' : '0 ' . FS_REVIEW;?>
                                </a>
                            <?php }?>
                        </div>
                    </dd>
                </dl>
            </div>

            <div class="product_sticky_add <?php echo (in_array($_SESSION['languages_code'],['ru','de','fr'])) ? 'price_stock_other':'';?>">
                <ul>
                    <li>
                        <span class="header_products_price">
                            <?php
                            $jp_products_id = $_GET['products_id']; // 方便计算日语站 JPY的价格
                            $jp_products_price = $length_price = 0;
                            $combination_arr = []; //组合产品
                            if($shipping_info->is_custom()){ //定制产品
                                //$custom_attribute_data['all_Attr']=>带属性项+属性值  $custom_attribute_data['attr']=>属性值
                                $all_length = '';   //详情页初始化加载时长度属性锁定在other length客户自定义填写框 所以此处的长度是空
                                $custom_data = match_product_initialization_information((int)$_GET['products_id'],$custom_attribute_data['all_Attr'],$custom_attribute_data['attr'],$all_length);
                                if($custom_data){
                                    $product_price = $custom_data['total_price'];
                                    $currency = $_SESSION['currency'];
                                    $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];

                                    //$one_price = zen_round($product_price * $currency_value , $currencies->currencies[$currency]['decimal_places']); //当前币种的价格
                                    $one_price = $product_price; //当前产品美元价格

                                    $shipping_info->attr_option_arr = $custom_data['delivery_attr_arr'];
                                    $length_price = $custom_data['length_price']; // 产品的所有属性价格
                                    $combination_arr = $custom_data['combination_arr'];
                                    //匹配到标准产品且为开启状态
                                    if($custom_data['match_products_id']){
                                        $shipping_info->match_product_change_pid((int)$custom_data['match_products_id'][0]);
                                        if($custom_data['match_status']==1){

                                            $shipping_info->attr_option_arr = [];
                                            $jp_products_id = $custom_data['match_products_id'][0]; //匹配到标准产品 就计算标准产品的价格
                                            if($custom_data['is_clearance']){
                                                $clearance_qty = $clearance_other_qty = $shipping_info->getLocalAndWuhanqty();
                                                if($_SESSION['cart']->in_cart($custom_data['match_products_id'][0])){
                                                    //当前清仓产品在购物车中
                                                    $cart_pid_qty = $_SESSION['cart']->contents[$custom_data['match_products_id'][0]]['qty'];
                                                    //可加购的清仓产品数量需要去掉购物车中已经加购的
                                                    $clearance_other_qty = ($clearance_qty-$cart_pid_qty) ? ($clearance_qty-$cart_pid_qty):0;
                                                }
                                            }
                                        }
                                    }
                                    $shipping_info->attributes = $custom_data['attribute'];
                                    $weight_num = $shipping_info->get_weight_for_prdoucts_id();
                                    $shipping_info->weight = $weight_num;
                                    $processing_days = $shipping_info->get_processing_days();
                                }
                            }else{
                                //获取产品的原始价格products表中的products_price的值
                                //返回当前产品取整或不取整后的美元价格
                                $product_price = zen_get_products_final_price((int)$_GET['products_id']);
                            }

                            $pure_price = $product_price;
                            //生成的对应币种的带货币符号的价格
                            $priceText = $currencies->total_format($product_price);
                            if($_SESSION['languages_code'] == 'jp'){
                                if($_SESSION['currency'] != 'JPY'){ //日语货币不是JPY时 展示JPY价格
                                    $jp_products_price = zen_get_products_final_price((int)$jp_products_id,'JPY',$combination_arr);
                                    if(!$combination_arr['is_composite']){
                                        $jp_products_price +=  $custom_data['length_price'];
                                    }
                                }
                            }
                            $priceData = getAfterVatPrice($product_price,$priceText,'',$jp_products_price);
                            echo  $priceData['totalPrice'];
                            ?>
                        </span>
                        <p class="product_sticky_newDetali_txt">
                            <?php
//                            $instock_info =$shipping_info->get_header_instock_info();
                            $instock_info =$shipping_info->get_warehouse_instock_qty();
                            $instock_info = str_replace('<span>', '', explode(',', $instock_info)[0]);
                            echo $instock_info;?>
                        </p>
                    </li>
                    <li>
                        <input type="text" value="<?php if($products_is_min_order_qty){echo $products_is_min_order_qty;} else { echo (isset($_GET['cart_quantity']) && 0 < (int)$_GET['cart_quantity']) ? (int)$_GET['cart_quantity'] : '1';} ?>" class="p_07 product_sticky_qty" name="cart_quantity" maxlength = "5"  min="1" id="move_cart_quantity" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onafterpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="move_check_min_qty(this,<?php echo $_GET['products_id'];?>)" onfocus="move_enterKey(this)" onblur="this.style.border='';" <?php echo $disabled;?>>
                        <div class="pro_mun">
                            <a href="javascript:void(move_cart_quantity_change(1));" class="cart_qty_add <?php echo $choosez;?>"></a>
                            <a href="javascript:void(move_cart_quantity_change(0));" class="cart_qty_reduce cart_reduce <?php echo $disabled ? $choosez : "";?>"></a>
                        </div>
                    </li>

                    <li class="product_sticky_btn">
                        <?php
                        $onclick='';$quicktocart = false;
                        if (!sizeof($options_name_new) && !$productLengthInfo) {
                            $quicktocart = true;
//                            echo ' <a href="'.zen_href_link('shopping_cart').'" class="img_add_cart" id="img_go_to_cart_'.(int)$_GET['products_id'].'">'.FS_VIEW_CART.'<i class=""></i> </a>
//		<input type="submit" id="pro_add_'.(int)$_GET['products_id'].'" onclick="HeadAddToCart('.(int)$_GET['products_id'].',$(this))" value="'.FS_ADD_TO_CART.'" name="Add to Cart" class="button_02 button_10">';
                            echo '<button type="button" id="img_go_to_cart_'.(int)$_GET['products_id'].'" onclick="HeadAddToCart('.(int)$_GET['products_id'].',$(this))" value="'.FS_ADD_TO_CART.'" name="Add to Cart" class="new_pro_addCart_btn">
                                        <div class="new_pro_addCart_mainDev after">
		                                <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>
		                                '.($is_pre_order ? FS_PRE_ORDER : FS_ADD_TO_CART).'
		                                </div> 
		                                <div class="new_addCart_loading choosez">
                                        <div class="new_chec_bg"></div>
                                        <div class="loader_order">
                                        <svg class="circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                        </svg>
                                        </div>
                                        </div>
		                                </button>';
                        }else{
                            $category_data = get_product_category_key($_GET['products_id']);
                            $category_key = $category_data['key'];
                            $retail_status = get_retail_status($_GET['products_id']);
                            $categories_id = isset($cPath_array[1]) ? $cPath_array[1]:$cPath_array[2];
                            $quicktocart = false;
                            echo '<button onclick="add_to_carts('.$category_key.','.$retail_status.','.$categories_id.','.$current_category_id.',$(\'#add_to_cart\'),1)" id="move_add_to_cart" value="'.FS_CUSTOMILIZED_ADD_TO_CART.'" name="'.FS_ADD_TO_CART.'" class="new_pro_addCart_btn ">
                                            <div class="new_pro_addCart_mainDev after">
                                            <span class="icon iconfont add_to_cart_iconfont">&#xf142;</span>
                                            '.($is_pre_order ? FS_PRE_ORDER : FS_ADD_TO_CART).'
                                            </div>
                                            <div class="new_addCart_loading choosez">
                                            <div class="new_chec_bg"></div>
                                                <div class="loader_order">
                                                    <svg class="circular" viewBox="25 25 50 50">
                                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                    </svg>
                                                </div>
                                            </div>
                                            </button>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        if (in_array($cPath_array[1], array(1071, 3079, 2997, 1037)) || in_array($cPath_array[2], array(1038, 13, 1186, 1135, 1140)) || in_array($cPath_array[3], array(2892))) {
            $specification_word = FS_PRODUCTS_ACCESSORIES;
        }elseif((in_array((int)$_GET['products_id'], array(68541, 68540, 57342, 57341, 57038, 57037, 57017, 57016, 35510)))){
            $specification_word = FS_PRODUCTS_SOLUTION;
        }else {
            $specification_word = FS_PRODUCTS_SPECIFICATION;
        }
        ?>
        <?php
        $file_path = "cache/products";
        $file_name = "products_descreption_top_".$_SESSION['language']."_".(int)$_GET['products_id']."_".date("Ymd").".html";
        $file = $file_path."/".$file_name;
        if(file_exists($file)){
            echo file_get_contents($file);
        }else{
        ob_start();//开启ob缓存
        ?>
        <div class="product_tab01">
            <ul class="product_tab01_ul after">
                <li class="hover QA_discription" id="productinfotab_specifications">
                    <a href="javascript:;"><?php echo FS_PRODUCTS_SPECIFICATIONS;?></a>
                </li>

                <?php if ($is_show_products_tree) {?>
                    <li id="productinfotab_productstree">
                        <a href="javascript:;"><?php echo FS_NETWORK_CONNECTIVITY;?></a>
                    </li>
                <?php }?>
                <?php if ($products_highlights) {?>
                    <li id="productinfo_highlights">
                        <a href="javascript:;"><?php echo FS_PRODUCT_HIGHLIGHTS_01;?></a>
                    </li>
                <?php }?>
                <?php if ($platform_support) {?>
                    <li id="productinfo_platformsupports">
                        <a href="javascript:;"><?php echo FS_OURFACTORY_PIC2;?></a>
                    </li>
                <?php }?>
                <?php  if (!empty($communityArr)) {?>
                    <li id="productinfo_community" class="">
                        <a href="javascript:;"><?php echo FS_PRODUCT_COMMUNITY_01;?></a>
                    </li>
                <?php }?>
                <?php if($_SESSION['languages_code'] != 'ru'){?>
                <li id="productinfotab_qa">
                    <a href="javascript:;"><?php echo FS_PRODUCTS_QA; ?></a>
                </li>
                <?php }?>
                <li id="productinfotab_reviews">
                    <a href="javascript:;"><?php echo FS_REVIEWS; ?></a>
                </li>
                <?php if ($is_show_download_resources_content_new){?>
                <li id="productinfotab_technicaldocs">
                    <a href="javascript:;"><?php echo FS_RESOURCES; ?></a>
                </li>
                <?php }?>
                <?php if ($is_show_match_product) {?>
                    <li id="productinfotab_match">
                        <a href="javascript:;" ><?php echo FS_STOCK_LIST_RECOM;?></a>
                    </li>
                <?php }?>
                <span class="home_compati"></span>
            </ul>
        </div>

            <?php
            $content =  ob_get_contents();
            if(!file_exists($file_path)){
                mkdir($file_path,0777,true);
            }
            ob_flush();
            flush();//立即输出到浏览器
            ob_end_clean();//关闭并且清空ob缓存内容
            file_put_contents($file,$content);
        } ?>
    </div>
</div>
<script type="text/javascript">
    //carr开始
    $(function(){
        // $('.top_am,.gotoReview').click(function(){
        //     var oConLength = $('.product_tab01_ul li').length;
        //     var $top = $('.por_review_btn').offset().top-100;
        //     var Menubox = $('.Menubox').offset().top-30;
        //     if($('.product_tab01_ul li.active').index() == 0){
        //         $('html,body').animate({scrollTop:$top},1000);
        //     }else if($('.product_tab01_ul li.active').index() != 0){
        //         //setTabNew('one', '12', 11, setTabNewOne12);
        //         $('html,body').animate({scrollTop:Menubox},1000);
        //         $('.product_tab01_ul li').eq(oConLength - 1).addClass('active').siblings().removeClass('active');
        //     }
        // });

        $('.gotoQuestion').click(function(){
            var qa_top = $('#qa').offset().top-130;
            $('html,body').animate({scrollTop:qa_top+'px'},1000);
        })

        $('.gotoReview,.top_am').click(function(){
            var reviews_top = $('#reviews').offset().top-130;
            $('html,body').animate({scrollTop:reviews_top+'px'},1000);
        })


        $('.menubox_details_ul li').click(function() {
            var index = $(this).index();
            $(this).addClass('hover').siblings('li').removeClass('hover');
            $('.product_tab01_ul li').eq(index).addClass('active').siblings('li').removeClass('active');

            var product_tab01_ul_index = $('.product_tab01_ul li').eq(index);
            var width = (product_tab01_ul_index.width() - 40) / 2;
            var left = (product_tab01_ul_index.offset().left - $('.product_tab01_ul').offset().left + width) + 'px';
            $('.home_compati').css('left', left);
        })

        var Switch = false;
        var Timer_number = 0;
        var flag = true;
        var initial_class = $('.product_tab01_ul li').eq(0).attr('id');
        var Current_class = '';
        function Timer(){
            if(flag){
                setInterval(function(){
                    Timer_number ++;
                },1000)
            }
            flag = false;
        }

        $(window).scroll(function() {
            var window_height = $(document).scrollTop();
            $('.menubox_details_ul li').each(function() {
                var id_scroll = $(this).attr('id').split('_')[1];
                var height_scroll = ($("#" + id_scroll).offset().top - 131);
                if(window_height >= height_scroll) {
                    $('.menubox_details_ul li').eq($(this).index()).addClass('hover').siblings('li').removeClass('hover');
                    $('.product_tab01_ul li').eq($(this).index()).addClass('active').siblings('li').removeClass('active');
                    var product_index = $('.product_tab01_ul li').eq($(this).index());
                    var width = (product_index.width() - 40) / 2;
                    var left = (product_index.offset().left - $('.product_tab01_ul').offset().left + width) + 'px';
                    $('.home_compati').css('left', left);
                }
            })

            if($('.product_sticky').is(':hidden')){
                //显示状态　　
                Switch = true;
            }
            $('.product_tab01_ul li').each(function(){
                if($(this).hasClass('active')){
                    Current_class = $(this).attr('id');
                    if(Current_class == initial_class){
                        Timer();
                    }
                    if(Current_class != initial_class){
                        if  (Timer_number > 0){
                            //数据统计 add by tim
                            var idArr = [
                                'productinfotab_specifications',
                                'productinfotab_productstree',
                                'productinfo_highlights',
                                'productinfo_community',
                                'productinfotab_qa',
                                'productinfotab_reviews',
                                'productinfotab_technicaldocs',
                            ];
                            var tab_value = idArr.indexOf(initial_class) + 1;
                            if (typeof _faq !== 'undefined') {
                                _faq.push(['trackEvent', 'area_stay_time', {"tab_value" : tab_value, "viewing_time" : Timer_number}, 4]);
                            }
                        }
                        Current_class = $(this).attr('id');
                        initial_class = $(this).attr('id');
                        Timer_number = 0;
                    }
                }
            })

        })

        // $('.Menubox ul li').click(function(){
        //     var $index1 = $(this).index();
        //     $('.product_tab01_ul li').eq($index1).addClass('active').siblings().removeClass('active');
        //     $(this).addClass('hover').siblings().removeClass('hover');
        // });

        // $('.product_tab01_ul li').click(function(){
        //     var Menubox = $('.Menubox').offset().top-30;
        //     $('html,body').animate({scrollTop:Menubox},1000);
        //     var $index = $(this).index();
        //     var $ID = $(this).attr('id').replace(/\D/ig,"");
        //     if($ID == 1){
        //         setTabNew('one',$ID,11,setTabNewOne1);
        //     }else if($ID == 7) {
        //         setTabNew('one', $ID, 11, setTabNewOne7);
        //     }else if($ID == 10){
        //         setTabNew('one', $ID, 11, setTabNewOne10);
        //     }else if($ID == 12){
        //         setTabNew('one', $ID, 11, setTabNewOne12);
        //     }else{
        //         setTabNew('one',$ID,11);
        //     };
        //     $(this).addClass('active').siblings().removeClass('active');
        //     setTimeout(function(){
        //         $("#products_add_cart").removeClass('active');
        //     },1100);
        //
        //     $('.Menubox ul li').eq($index).addClass('hover').siblings().removeClass('hover');
        // })

        animate_menubox('.product_tab01_ul li');
        animate_menubox('.menubox_details_ul li');
        // $('.product_tab01_ul li').click(function(){
        //     var id = $(this).attr('id').split('_')[1];
        //     var height = ($("#"+id).offset().top-51) + 'px';
        //     $('html , body').animate({scrollTop: height},300);
        // });

        $('#product_cart_popup').on('click','.new_popup_addCart_tit>span,.fs_customer_btnG01',function () {
            $("#products_add_cart").removeClass('active');
            /*setTimeout(function () {
             $("#products_add_cart").addClass('active');
             },100)*/
        })

    });

    function animate_menubox(obj){
        $(obj).click(function(){
            var id = $(this).attr('id').split('_')[1];
            var height = ($("#"+id).offset().top-120) + 'px';
            $('html , body').animate({scrollTop: height},300);
            //数据统计 add by tim
            if (typeof _faq !== 'undefined') {
                var index = $(this).index();
                var type = parseInt(index) + 1;
                var _paul = $(this).parent();
                if (_paul.hasClass('menubox_details_ul')) {
                    var site = 1;
                } else {
                    var site = 2;
                }
                _faq.push(['trackEvent', 'quick_tab_click', {"type" : type, "site" : site}, 4]);
            }
        });
    }


    function HeadAddToCart(id,obj){
        var qty =  $("#move_cart_quantity").val();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"?modules=ajax&handler=products_quote_info&ajax_request_action=actionAddProduct",
            data:"products_id="+id+"&cart_quantity="+qty+"&type=1&clearance_qty="+clearance_qty+"&is_clearance="+is_clearance_pri,
            beforeSend:function(){
                obj.addClass('addLoad_animation');
                obj.find('.new_addCart_loading').removeClass('choosez');
                obj.find('.add_to_cart_iconfont').hide();
                obj.find('.new_pro_addCart_mainDev').css('opacity','0');
            },
            success:function(data){
                obj.removeClass('addLoad_animation');
                obj.find('.new_addCart_loading').addClass('choosez');
                obj.find('.add_to_cart_iconfont').show();
                obj.find('.new_pro_addCart_mainDev').css('opacity','');
                if(data.status == 'success'){
                    dataLayer.push({
                        "event": "addToCart",
                        "ecommerce": {
                            "currencyCode": data.currencyCode,
                            "add": {
                                "products": [data.products_info]
                            }
                        }
                    });
                    $("#ShoppingCartInfo").html(data.html);
                    $('#popup_catr_nunm').html(qty);
                    $('#addCart_qty_num').html(qty);
                    $('#product_cart_popup').html(data.addCarthtml);
                    $('.new_product_popup_addCart').show();
                    $(".new_popup_bg").show();
                    $("#pro_add_"+id).addClass('button_10_01').val('Added');
                    $("#img_go_to_cart_"+id).addClass('go-to-cart-page-01');
                    $("#move_cart_quantity").val('1');
//                        /setTimeout("imgcodefans("+id+")",3000);
                    setTimeout(fnAlertEven($('.new_product_popup_addCart .new_popup_main')),100);
                    $('body').css({'overflow':"hidden","padding-right":'15px'});
                    $('html').css({'overflow':"hidden"});
                    if (typeof _faq !== "undefined") {
                        //数据统计 add by tim
                        _faq.push(['trackEvent', 'add_cart_click', {"p_id": id, "p_num": qty, "site" : 2}, 4]);
                    }
                }else if (data.status == 'error'){
                    $('#newDetail-purchasing-limit').show();
                }
            }
        });
    }

    function imgcodefans(id){
        $("#img_go_to_cart_"+id).removeClass('go-to-cart-page-01');
        $("#pro_add_"+id).removeClass('button_10_01').val('<?php echo FS_ADD_TO_CART;?>').attr('disabled',false);
    }
</script>
