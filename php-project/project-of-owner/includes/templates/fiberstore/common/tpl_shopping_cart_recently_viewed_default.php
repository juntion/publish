<!--购物车底部产品轮播-->
<?php if(isset($_COOKIE['fs_views'])){
    if(isMobile()){
        $swiper = 'my-swiper';
    }else{
        $swiper = 'swiper';
    }
    ?>
<div class="shopcart-carousel-container">
    <div class="cart-title-md">
        <?php echo FS_RECENTLY_VIEWED;?>
    </div>
    <div class="v_show_shopping_cart shopcart-carousel-wrap">
        <div class="<?php echo isMobile() ? $swiper : 'v_show';?>">
            <?php
                $pIDs = array_reverse(explode('|',$_COOKIE['fs_views']));
                $wholesale_products = fs_get_wholesale_products_array();
                $country_code_iso = strtolower($_SESSION['countries_iso_code']);
                if($pIDs){ ?>
                    <div class="swiper-container <?php echo $swiper;?>-container swiper-container-horizontal" style="display:block;">
                        <div class="<?php echo $swiper;?>-wrapper after">
                            <?php
                            //最多展示10条浏览记录
                            foreach(array_slice($pIDs,0,10) as $value=>$pID) {
                                $status = 0;
                                $is_inquiry = 0;
                                if ($pID) {
                                    $products_data = fs_get_data_from_db_fields_array(['products_status',$fsCurrentInquiryField.' as is_inquiry'],'products', 'products_id=' . (int)$pID, 'limit 1');
                                    $status = $products_data[0][0];
                                    $is_inquiry = $products_data[0][1];
                                }
                                if ($status == 1) {
                                    $current_product_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . (int)$pID, 'NONSSL');
                                    if ($is_inquiry == 1) {
                                        $products_price = '<a href="' . $current_product_link . '" target="_blank">' . GET_A_QUOTE . '</a>';
                                    } else {

                                        /* dylan 2020.5.18
                                         * $is_composite_products = false;
                                        if (class_exists('classes\CompositeProducts')) {
                                            $CompositeProducts = new classes\CompositeProducts(intval($pID));
                                            $composite_product_price = $CompositeProducts->get_composite_product_price(false);
                                            if(!empty($composite_product_price['composite_product_price'])){
                                                $is_composite_products = true;
                                            }
                                        }
                                        if ($is_composite_products) {//判断是否是组合产品
                                            $final_price = $composite_product_price['composite_product_price_str'];
                                        }else {

                                            if (!in_array($pID, $wholesale_products)) {
                                                $final_price = $currencies->new_display_price(zen_get_products_base_price((int)$pID), 0);
                                            } else {
                                                $final_price = $currencies->display_price(zen_get_products_base_price((int)$pID), 0);
                                            }
                                        }*/

                                        //价格展示优化
                                        $products_price = zen_get_products_final_price((int)$pID);
                                        $products_price = $currencies->total_format($products_price);
                                    }
                                    // 被删除的星星评价 <div class="shopcart-products-reviews after">' . $fs_reviews->get_product_list_review_show($pID) . '</div>
                                    $products_name = zen_get_products_name($pID, $_SESSION['languages_id']);
                                    if (zen_get_products_name($pID, $_SESSION['langusges_id']) != null) {
                                        echo '<div class="'.$swiper.'-slide swiper-no-swiping">
                                              <div class="list_10">
                                              <a target="_blank" href="' . $current_product_link . '">' . get_resources_img($pID, '120', '120') . '</a>
                                              </div><span><a target="_blank" title="' . $products_name . '" href="' . $current_product_link . '">' . $products_name . '</a>
                                              </span>' . '<p>' . $products_price . '</p>
                                              </div>';

                                    }
                                }
                            }
                            ?>

                        </div>
                        <?php $swiper_silde_length = sizeof($pIDs);?>
                        <?php if(!isMobile()){?>
                            <div class="swiper-button-prev icon iconfont" style="display: none">&#xf090;</div>
                            <div class="swiper-button-next icon iconfont" style="display: none">&#xf089;</div>
                        <?php }?>
                    </div>
                <?php } ?>
            <?php if(isMobile()){?>
                <div class="proDetail-recent-more" onclick="_recentMore(this)" style="display: none;">
                    <span class="iconfont icon">&#xf087;</span>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php  }else{ ?>
    <div class="v_show" style="display: none;">
        <div class="swiper-container">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
<?php } ?>
<script>
    function setSwip() {
        var cartlist = $('#cart_form').find('.shipment-shopcart-list');
        var SwiperHotProduct;
        if(typeof(Swiper)!=='function'){
            return false
        }else{
            var str = '.v_show';
            if($(".v_show").length < 1){
                str = '.my-swiper';
            }
            if($('.flter_cart').is(':hidden')){
                SwiperHotProduct = new Swiper(str + ' .swiper-container', {
                    paginationClickable: true,
                    slidesPerView: 6,
                    slidesPerGroup : 6,
                    prevButton:str + ' .swiper-button-prev',
                    nextButton:str + ' .swiper-button-next',
                    spaceBetween: 30,
                    //onlyExternal:false,
                    preventClicks:true,
                    //observer:true,
                    //observeParents:true,
                    breakpoints: {
                        1440: {
                            slidesPerView: 4,
                            spaceBetween: 10,
                            slidesPerGroup : 4
                        },
                        1220: {
                            slidesPerView: 4,
                            spaceBetween: 10,
                            slidesPerGroup : 4
                        },
                        960: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                            slidesPerGroup : 3
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 10,
                            slidesPerGroup : 2
                        },
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 10,
                            slidesPerGroup : 2
                        },
                        380: {
                            slidesPerView: 2,
                            spaceBetween: 10,
                            slidesPerGroup : 2
                        }
                    }
                });
            }else{
                if($('#cart_form .shipment-shopcart-list').hasClass('is_deleted')){
                        SwiperHotProduct = new Swiper(str + ' .swiper-container', {
                        paginationClickable: true,
                        slidesPerView: 6,
                        slidesPerGroup : 6,
                        prevButton:str + ' .swiper-button-prev',
                        nextButton:str + ' .swiper-button-next',
                        spaceBetween: 30,
                        //onlyExternal:false,
                        preventClicks:true,
                        //observer:true,
                        //observeParents:true,
                        breakpoints: {
                            1440: {
                                slidesPerView: 4,
                                spaceBetween: 10,
                                slidesPerGroup : 4
                            },
                            1220: {
                                slidesPerView: 4,
                                spaceBetween: 10,
                                slidesPerGroup : 4
                            },
                            960: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                                slidesPerGroup : 3
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            },
                            480: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            },
                            380: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            }
                        }
                    });
                }else{
                    SwiperHotProduct = new Swiper(str + ' .swiper-container', {
                        paginationClickable: true,
                        slidesPerView: 5,
                        slidesPerGroup : 5,
                        prevButton:str + ' .swiper-button-prev',
                        nextButton:str + ' .swiper-button-next',
                        spaceBetween: 10,
                        //onlyExternal:false,
                        preventClicks:true,
                        //observer:true,
                        //observeParents:true,
                        breakpoints: {
                            1440: {
                                slidesPerView: 3,
                                spaceBetween: 10,
                                slidesPerGroup : 3
                            },
                            1220: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            },
                            960: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                                slidesPerGroup : 3
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            },
                            480: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            },
                            380: {
                                slidesPerView: 2,
                                spaceBetween: 10,
                                slidesPerGroup : 2
                            }
                        }
                    });
                }
            }
            // if(cartlist.length>0 || !cartlist.hasClass('is_deleted')){
            //     if(cartlist.length == 1 && cartlist.hasClass('is_deleted')){
            //         SwiperHotProduct = new Swiper(str + ' .swiper-container', {
            //             paginationClickable: true,
            //             slidesPerView: 6,
            //             slidesPerGroup : 6,
            //             prevButton:str + ' .swiper-button-prev',
            //             nextButton:str + ' .swiper-button-next',
            //             spaceBetween: 30,
            //             //onlyExternal:false,
            //             preventClicks:true,
            //             //observer:true,
            //             //observeParents:true,
            //             breakpoints: {
            //                 1440: {
            //                     slidesPerView: 4,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 4
            //                 },
            //                 1220: {
            //                     slidesPerView: 4,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 4
            //                 },
            //                 960: {
            //                     slidesPerView: 3,
            //                     spaceBetween: 20,
            //                     slidesPerGroup : 3
            //                 },
            //                 768: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 480: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 380: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 }
            //             }
            //         });
            //     }else if(cartlist.length == 0){
            //         SwiperHotProduct = new Swiper(str + ' .swiper-container', {
            //             paginationClickable: true,
            //             slidesPerView: 6,
            //             slidesPerGroup : 6,
            //             prevButton:str + ' .swiper-button-prev',
            //             nextButton:str + ' .swiper-button-next',
            //             spaceBetween: 30,
            //             //onlyExternal:false,
            //             preventClicks:true,
            //             //observer:true,
            //             //observeParents:true,
            //             breakpoints: {
            //                 1440: {
            //                     slidesPerView: 4,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 4
            //                 },
            //                 1220: {
            //                     slidesPerView: 4,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 4
            //                 },
            //                 960: {
            //                     slidesPerView: 3,
            //                     spaceBetween: 20,
            //                     slidesPerGroup : 3
            //                 },
            //                 768: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 480: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 380: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 }
            //             }
            //         });
            //     }else{
            //         console.log(123)
            //         SwiperHotProduct = new Swiper(str + ' .swiper-container', {
            //             paginationClickable: true,
            //             slidesPerView: 5,
            //             slidesPerGroup : 5,
            //             prevButton:str + ' .swiper-button-prev',
            //             nextButton:str + ' .swiper-button-next',
            //             spaceBetween: 10,
            //             //onlyExternal:false,
            //             preventClicks:true,
            //             //observer:true,
            //             //observeParents:true,
            //             breakpoints: {
            //                 1440: {
            //                     slidesPerView: 3,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 3
            //                 },
            //                 1220: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 7,
            //                     slidesPerGroup : 2
            //                 },
            //                 960: {
            //                     slidesPerView: 3,
            //                     spaceBetween: 20,
            //                     slidesPerGroup : 3
            //                 },
            //                 768: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 480: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 },
            //                 380: {
            //                     slidesPerView: 2,
            //                     spaceBetween: 10,
            //                     slidesPerGroup : 2
            //                 }
            //             }
            //         });
            //     }
            // }else{
            //     SwiperHotProduct = new Swiper(str + ' .swiper-container', {
            //         paginationClickable: true,
            //         slidesPerView: 6,
            //         slidesPerGroup : 6,
            //         prevButton:str + ' .swiper-button-prev',
            //         nextButton:str + ' .swiper-button-next',
            //         spaceBetween: 30,
            //         //onlyExternal:false,
            //         preventClicks:true,
            //         //observer:true,
            //         //observeParents:true,
            //         breakpoints: {
            //             1440: {
            //                 slidesPerView: 4,
            //                 spaceBetween: 7,
            //                 slidesPerGroup : 4
            //             },
            //             1220: {
            //                 slidesPerView: 4,
            //                 spaceBetween: 7,
            //                 slidesPerGroup : 4
            //             },
            //             960: {
            //                 slidesPerView: 3,
            //                 spaceBetween: 20,
            //                 slidesPerGroup : 3
            //             },
            //             768: {
            //                 slidesPerView: 2,
            //                 spaceBetween: 10,
            //                 slidesPerGroup : 2
            //             },
            //             480: {
            //                 slidesPerView: 2,
            //                 spaceBetween: 10,
            //                 slidesPerGroup : 2
            //             },
            //             380: {
            //                 slidesPerView: 2,
            //                 spaceBetween: 10,
            //                 slidesPerGroup : 2
            //             }
            //         }
            //     });
            // }
            SwiperHotProduct.update(true);
            // SwiperHotProduct.reLoop();
            SwiperHotProduct.slideTo(0, 1, false);
            windows_with_change()
        }
    }
    function windows_with_change(){
        var swiper_with =  $('.shopcart-carousel-container').width()
        var max_num = 6
        switch (true) {
            case swiper_with >= 1420:

                break;
            case swiper_with >= 1000:
                max_num = 5
                break;
            case swiper_with >= 800:
                max_num = 4
                break;
            case swiper_with >= 560:
                max_num = 3
                break;
            default :
                max_num = 2
                break;
        }
        swiper_button_toshow(max_num)
    }

    function swiper_button_toshow(slide_length_max_num){
        var slide_length = '<?php echo $swiper_silde_length; ?>' - 0 ;
        if (slide_length > slide_length_max_num){
            $('.swiper-button-prev').show()
            $('.swiper-button-next').show()
        }else{
            $('.swiper-button-prev').hide()
            $('.swiper-button-next').hide()
        }
    }

    $(function () {
        setSwip()
    });
    //
    var reHight = $(".my-swiper-wrapper").height();
    if($(window).width() <= 960 && $('.my-swiper-slide').length > 4){
        $(".proDetail-recent-more").show();
    }
    if($(window).width() <= 480 && $('.my-swiper-slide').length > 2){
        $(".proDetail-recent-more").show();
    }
    function _recentMore(th) {
        var _height = $(th).siblings('.my-swiper-container').find('.my-swiper-wrapper').height();
        if (!$(th).hasClass('choosez')) {
            $(th).addClass('choosez').siblings('.my-swiper-container').animate({height:_height + 'px'},300);
            $(th).find('.icon').html("&#xf088;");
        }else {
            $(th).removeClass('choosez').siblings('.my-swiper-container').animate({height:'224px'},300);
            $(th).find('.icon').html("&#xf087;");
        }
    }
</script>