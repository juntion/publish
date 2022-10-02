<?php

use App\Services\Image\ImageService;
use Illuminate\Database\Capsule\Manager as DB;
use App\Services\Products\ProductInventoryService;


$warehouse = get_site_warehouse_str();
define(INDEX_PRODUCTS_REDIS_KEY_PREFIX, FS_SITE_UNIQUE_LANGUAGE_ID . '_index_products');
$index_products_key = $_SESSION['currency'] . $warehouse;
$country_iso_code = strtoupper($_SESSION['countries_iso_code']);


if (is_support_webp()) {
    $index_products_key = $_SESSION['currency'] . $warehouse . '_webp';
} else {
    $index_products_key = $_SESSION['currency'] . $warehouse;
}
//获取首页数据
$webp_flag = true;
if ($_SERVER['SERVER_NAME'] == "www.fs.com") {
    $featured_products_data = get_redis_key_value($index_products_key, INDEX_PRODUCTS_REDIS_KEY_PREFIX . '_fpe_data');
    $etn_data = get_redis_key_value($index_products_key, INDEX_PRODUCTS_REDIS_KEY_PREFIX . '_etn_data');
    $webp_flag = true;
}

switch ($_SESSION['languages_code']) {
    case 'en':
        $temp_language_id = 1;
        break;
    case 'uk':
        $temp_language_id = 9;
        break;
    case 'dn':
        $temp_language_id = 13;
        break;
    case 'sg':
        $temp_language_id = 11;
        break;
    case 'au':
        $temp_language_id = 10;
        break;
    case 'es':
        $temp_language_id = 2;
        break;
    case 'mx':
        $temp_language_id = 12;
        break;
    default:
        $temp_language_id = $_SESSION['languages_id'];
        break;
}

require_once('includes/classes/homePageClass.php');
$home_page = new homePageClass(['language_id' => $_SESSION['languages_id'], 'warehouse' => $warehouse]);

if (empty($featured_products_data)) {
    $section_data = $home_page->get_section_type();
    $fpe_data = $home_page->index_featured_products_select_new();
    $featured_products_data = [];
    $origin_type_ids = [];
    if (sizeof($section_data)) {
        foreach ($section_data as $k => $section) {
            $products_data = $fpe_data[$section['section_type']];
            if (sizeof($products_data)) {
                foreach ($products_data as $key => $product) {
                    //对图片拼接上images
                    $origin_type_ids[] = $product['id'];
                    $temp = explode('/', $product['section_upload_res']);
                    $temp = array_filter($temp);
                    if (current($temp) != 'images') {
                        $product['section_upload_res'] = HTTPS_IMAGE_SERVER . 'images/' . $product['section_upload_res'];
                    }
                    $products_data[$key] = $product;
                }
                $section['section_img_path'] = HTTPS_IMAGE_SERVER . 'images/' . $section['section_img_path'];
                $section['section_choosing_img_path'] = HTTPS_IMAGE_SERVER . 'images/' . $section['section_choosing_img_path'];
                $section['products_data'] = $products_data;
                $featured_products_data[] = $section;
            }
        }
        //处理图片(是否展示webp格式的图片)
        if (is_support_webp() && $webp_flag) {
            $imageService = new ImageService();
            $webp_paths = $imageService->getwebppathbyids($origin_type_ids, 'index_featured_products', array('section_upload_res', 'section_m_upload_res'), $temp_language_id, array(), $warehouse);
            $webp_paths_keys = array_keys($webp_paths);
            foreach ($featured_products_data as $k => $v) {
                foreach ($v['products_data'] as $kk => $vv) {
                    if (in_array($vv['id'], $webp_paths_keys)) {
                        $vv['section_upload_res'] = HTTPS_IMAGE_SERVER . $webp_paths[$vv['id']]['section_upload_res'];
                    }
                    $v['products_data'][$kk] = $vv;
                }
                $featured_products_data[$k] = $v;
            }

        }
        set_redis_key_value($index_products_key, $featured_products_data, 0, INDEX_PRODUCTS_REDIS_KEY_PREFIX . '_fpe_data');
    }
}

//获取所有的产品id
$products_id_data = [];
array_walk($featured_products_data, function ($value, $key) use (&$products_id_data) {
    $products_id_arr=array_column($value['products_data'], 'products_id');
    $products_id_data=array_merge($products_id_data,$products_id_arr);
});

$products=$products_id_data;
$ProductsModel = new ProductInventoryService();
$now_warehouse_code = strtoupper(get_warehouse_by_code($_SESSION['countries_iso_code']));

//当查询库存的时候，若当前仓库无库存则显示CN仓库存，直接查当前仓和CN仓两个仓的数据；
$now_warehouse = [
    $now_warehouse_code => $ProductsModel->WarehouseEnum[$now_warehouse_code],
    'CN' => 1
];

$currentQty_date=$ProductsModel->setProducts($products, $now_warehouse)->calculateInventory(0);

if (empty($etn_data)) {
    $data = $home_page->indexExploreTheNetwork($_SESSION['languages_id']);
    $etn_data = [];
    $origin_type_ids = [];
    $article_ids = [];
    foreach ($data as $key => $value) {
        $origin_type_ids[] = $value['id'];
        if ($value['article_id']) {
            $article_ids[] = $value['article_id'];
        }
        $temp_pc = explode('/', $value['pc_img_path']);
        $temp_pc = array_filter($temp_pc);
        if (current($temp_pc) != 'images') {
            $value['pc_img_path'] = 'images/' . $value['pc_img_path'];
        }
        if ($value['type'] == 0) {
            $value['name'] = 'FS';
            $value['photo'] = '';
            $value['read_account'] = 0;
            $value['video_time'] = 0;
            $etn_data['data'][$value['article_id']] = $value;
        } else {
            $etn_data['btn_data'] = $value;
        }
    }
    if (sizeof($article_ids)) {
        try {
            $community_db = DB::connection('community');
            if (in_array($_SESSION['languages_code'], ['de', 'es', 'fr', 'it', 'jp', 'ru'])) {
                $detail_table = 'post_' . $_SESSION['languages_code'] . '_details';
            } else {
                $detail_table = 'post_details';
            }
            $article_ids = implode(',', $article_ids);
            $sql = "select pd.post_id,a.name,a.photo,pd.read_account,pd.video_time from post_details as pd
                    inner join authors as a on pd.virtual_author = a.id
                    where pd.post_id in (" . $article_ids . ") and post_type = 'post' and post_status in ('publish', 'future')";
            $find_sql = str_replace('post_details', $detail_table, $sql);
            $result = $community_db->select($find_sql);
            $result = sizeof($result) ? $result : $community_db->select($sql);
            if (sizeof($result)) {
                foreach ($result as $value) {
                    //$etn_data['data'][$value['post_id']]['name'] = $value['name'];
                    //$etn_data['data'][$value['post_id']]['photo'] = HTTPS_IMAGE_SERVER.$value['photo'];
                    //$etn_data['data'][$value['post_id']]['read_account'] = $value['read_account'];
                    if (!in_array($value['video_time'], ['', '00:00'])) {
                        $etn_data['data'][$value['post_id']]['video_time'] = $value['video_time'];
                    }
                }
            }
        } catch (\Exception $e) {
            echo "<div style='display: none;'>" . $e->getMessage() . "</div>";
        }
    }

    //处理图片
    if (is_support_webp() && $webp_flag) {
        $type_field = array('pc_img_path');

        $imageService = new ImageService();
        $etn_webp_paths = $imageService->getwebppathbyids($origin_type_ids, 'index_explore_the_network', $type_field, $temp_language_id, array(), $warehouse);
        $etn_webp_paths_keys = array_keys($etn_webp_paths);
        foreach ($etn_data['data'] as $key => $value) {
            if (in_array($value['id'], $etn_webp_paths_keys)) {
                $value['pc_img_path'] = $etn_webp_paths[$value['id']]['pc_img_path'];
            }

            $etn_data['data'][$key] = $value;
        }
    }


    set_redis_key_value($index_products_key, $etn_data, 0, INDEX_PRODUCTS_REDIS_KEY_PREFIX . '_etn_data');
}
/*$hse_data = get_redis_key_value($index_products_key,INDEX_PRODUCTS_REDIS_KEY_PREFIX.'_hse_data');
if(empty($hse_data)) {
    $hse_data = $home_page->indexHomeServicesEnglish($_SESSION['languages_id']);
    set_redis_key_value($index_products_key,$hse_data,0,INDEX_PRODUCTS_REDIS_KEY_PREFIX.'_hse_data');
}*/

?>
<?php if (sizeof($featured_products_data)) { ?>
    <div class="fs_content_public home_fs_content_public_first">
        <div class="fs_home_width">
            <h3 class="fs_home_tit"><?php echo FS_INDEX_FPE_TITLE; ?></h3>
            <div class="fs_home_nav_shadow">
                <div class="fs_home_nav_ul_overflow">


                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($featured_products_data as $key => $value) {
                                $active = $key == 0 ? 'active' : '';
                                $img = $key == 0 ? $value['section_choosing_img_path'] : $value['section_img_path'];
                                ?>
                                <div class="swiper-slide <?php echo $active; ?>"
                                     img="<?php echo $value['section_img_path']; ?>"
                                     choose-img="<?php echo $value['section_choosing_img_path']; ?>">
                                    <i class="fs_nav_backgroundimg"
                                       style="background-image: url('<?php echo $value['section_img_path']; ?>');"></i>
                                    <i class="fs_nav_backgroundimg fs_nav_backgroundimg_two"
                                       style="background-image: url('<?php echo $value['section_choosing_img_path']; ?>');"></i>
                                    <p class="fs_nav_txt"
                                       title="<?php echo $value['section_info_title']; ?>"><?php echo $value['section_info_title']; ?></p>
                                    <span class="fs_home_nav_ul_hover_carrier"></span>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <span class="home_compati"></span>
            </div>

            <div class="swiper-container fs_home_nav_content_ul">
                <div class="swiper-wrapper fs_home_nav_content_wrapper">
                    <?php
                    foreach ($featured_products_data as $key => $value) {
                        $active = $key == 0 ? 'active' : '';
                        ?>
                        <div class="fs_home_nav_content_li swiper-slide <?php echo $active; ?>">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php if (sizeof($value['products_data'])) {
                                        $i = 0;
                                        foreach ($value['products_data'] as $product) {
                                            $i++;
                                            if ($i > 10) {
                                                break;
                                            }
                                            ?>
                                            <div class="swiper-slide">
                                                <dl class="fs_home_nav_content_dl">
                                                    <a href="<?php echo zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id'], 'SSL'); ?>">
                                                        <dt>
                                                            <img src="<?php echo $product['section_upload_res']; ?>"/>
                                                            <?php if ($product['is_show_new']) {
                                                                echo '<span class="fs_home_new">' . NEW_PRODUCTS_TAG . '</span>';
                                                            } ?>
                                                        </dt>
                                                        <dd class="<?php echo in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de' ? 'de_tax_dd' : '' ;?>">
                                                            <div class="fs_home_nav_content_dl_top">
                                                                <span class="fs_home_red"><i></i></span>
                                                                <h3 class="fs_home_nav_content_tit">
                                                                    <?php echo $product['section_title']; ?>
                                                                </h3>
                                                            </div>
                                                            <div class="fs_home_nav_content_dl_bottom">
                                                                <p class="fs_home_nav_content_price">
                                                                    <?php
                                                                    $product_price = zen_get_products_final_price((int)$product['products_id']);

                                                                    if (in_array($_SESSION['languages_code'],['de','dn']) && strtolower($_SESSION['countries_iso_code'])=='de') {
                                                                        $priceHtml = '';
                                                                        $priceHtml .= '<span class="de_price_text">'.$currencies->total_format($product_price).FS_PRICE_EXCL_VAT.'</span>';
                                                                        //法国德英站详情页产品含税价格按照19%计算
                                                                        $taxPriceText = $currencies->total_format($product_price * 1.19);
                                                                        $priceHtml .= '<span class="de_tax_price_text">'.$taxPriceText.FS_PRICE_INCL_VAT.'</span>';
                                                                        echo  $priceHtml;
                                                                    } else {
                                                                        echo  $currencies->total_format($product_price);
                                                                    }

                                                                    ?>
                                                                </p>
                                                                <p class="fs_home_nav_content_stock">
                                                                    <?php echo $ProductsModel->getIndexInstockQtyHtml($product['products_id'],$currentQty_date[$product['products_id']],$now_warehouse_code);?>
                                                                </p>
                                                            </div>
                                                        </dd>
                                                    </a>
                                                </dl>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                </div>
                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                        <?php
                    }
                    ?>


                </div>
                <div class="swiper-pagination fs_home_nav_pagination"></div>
                <div class="swiper-button-next fs_home_nav_next iconfont icon">&#xf089;</div>
                <div class="swiper-button-prev fs_home_nav_prev iconfont icon">&#xf090;</div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (sizeof($etn_data['data'])) { ?>
    <div class="fs_content_public fs_home_background_bg">
        <div class="fs_home_width">
            <h3 class="fs_home_explore_tit">
                <span><?php echo FS_PRODUCT_COMMUNITY_01; ?></span>
                <?php if ($etn_data['btn_data']) {
                    ?>
                    <div class="fs_home_view_more">
                        <a href="<?php echo $etn_data['btn_data']['link']; ?>"
                           target="_blank"><?php echo $etn_data['btn_data']['title']; ?><i class="iconfont icon">&#xf089;</i></a>
                    </div>
                    <?php
                } ?>
            </h3>
            <div class="fs_home_explore_dl_container">
                <?php
                $i = 0;
                foreach ($etn_data['data'] as $explore) {
                    $i++;
                    if ($i > 6) {
                        break;
                    }
                    ?>
                    <dl class="fs_home_explore_dl" sort="<?php echo $explore['sort']; ?>">
                        <a href="<?php echo $explore['link']; ?>" target="_blank">
                            <dt>
                                <img src="<?php echo HTTPS_IMAGE_SERVER . $explore['pc_img_path']; ?>"/>
                                <span class="fs_home_insights"><?php echo $explore['tag_name']; ?><i></i></span>
                                <?php if ($explore['video_time']) { ?>
                                    <div class="fs_home_explore_video"><span
                                                class="icon iconfont">&#xf449;</span><span><?php echo $explore['video_time']; ?></span>
                                    </div>
                                <?php } ?>
                            </dt>
                            <dd>
                                <h3 class=""><?php echo $explore['title']; ?></h3>
                                <!--<div class="fs_home_community_information">
                                        <div class="fs_home_community_name">
                                            <img src="<?php /*echo $explore['photo'];*/
                                ?>">
                                            <p><?php /*echo $explore['name'];*/
                                ?></p>
                                        </div>
                                        <div class="fs_home_community_views">
                                            <span class="icon iconfont">&#xf452;</span>
                                            <p><?php /*echo $explore['read_account'];*/
                                ?></p>
                                        </div>
                                    </div>-->
                            </dd>
                        </a>
                    </dl>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    var fs_home_nav_content_li_swiper;
    var fs_home_nav_content_ul_swiper;
    if ($(window).width() < 960) {
        fs_home_nav_content_li_swiper = new Swiper('.fs_home_nav_ul_overflow .swiper-container', {
            paginationClickable: true,
            spaceBetween: 40,
            slidesPerView: 'auto',
            breakpoints: {
                960: {
                    spaceBetween: 0,
                },
                640: {
                    spaceBetween: 28,
                }
            }
        });
        // fs_home_swiper('.fs_home_nav_content_li.active .swiper-container','.fs_home_nav_content_li.active .swiper-pagination');
    }

    if ($(window).width() > 960) {
        fs_home_nav_content_ul_swiper = new Swiper('.fs_home_nav_content_ul.swiper-container', {
            paginationClickable: true,
            spaceBetween: 40,
            slidesPerView: 'auto',
            pagination: '.fs_home_nav_content_ul .fs_home_nav_pagination',
            nextButton: '.fs_home_nav_next ',
            prevButton: '.fs_home_nav_prev',
            onlyExternal: true,
            preventClicks: false,
            loop: true,
            onSlideChangeStart: function (swiper) {
                var index = $('.fs_home_nav_content_li.swiper-slide-active').index() - $('.fs_home_nav_ul_overflow').find('.swiper-slide').length;
                if (index > ($('.fs_home_nav_ul_overflow').find('.swiper-slide').length - 1)) {
                    index = 0;
                }
                // var choose_img = $('.fs_home_nav_ul_overflow').find('.swiper-slide').eq(index).attr('choose-img');
                // for(let i=0;i<$('.fs_home_nav_ul_overflow .swiper-slide').length;i++){
                //     var oDefaultImg = $('.fs_home_nav_ul_overflow .swiper-slide').eq(i).attr('img');
                //     $('.fs_home_nav_ul_overflow .swiper-slide').eq(i).find('i').css("background-image","url(" + oDefaultImg + ")");
                // }
                // $('.fs_home_nav_ul_overflow').find('.swiper-slide').eq(index).find('i').css("background-image","url(" + choose_img + ")");

                $('.fs_home_nav_ul_overflow').find('.swiper-slide').eq(index).addClass('active').siblings('.swiper-slide').removeClass('active');
                var swiper_index = $('.fs_home_nav_ul_overflow').find('.swiper-slide').eq(index);
                var slide_width = (swiper_index.width() - 40) / 2;
                var slide_left = (swiper_index.offset().left - $('.fs_home_nav_shadow').offset().left + slide_width) + 'px';
                $('.home_compati').css('left', slide_left);
            }
        });
    }


    if ($(window).width() > 960) {
        var index_0 = $('.fs_home_nav_ul_overflow .swiper-slide').eq(0);
        var slide_width = (index_0.width() - 40) / 2;
        var slide_left = (index_0.offset().left - $('.fs_home_nav_shadow').offset().left + slide_width) + 'px';
        $('.home_compati').css('left', slide_left);
    }


    var timer;
    var settime = 0;
    $('.fs_home_nav_ul_overflow .swiper-slide').hover(function () {
        if ($(window).width() > 960) {
            settime = 300;
        }
        timer = setTimeout(() => {
            var index = $(this).index();
            var swiper_index = index + $('.fs_home_nav_ul_overflow .swiper-slide').length;
            $(this).addClass('active').siblings('.swiper-slide').removeClass('active');
            var width = ($(this).width() - 40) / 2;
            var left = ($(this).offset().left - $('.fs_home_nav_shadow').offset().left + width) + 'px';
            $('.home_compati').css('left', left);
            resetBackImg();
            $('.fs_home_nav_content_ul .fs_home_nav_content_li').eq(index).addClass('active').siblings('.fs_home_nav_content_li').removeClass('active');


            if ($(window).width() > 960) {
                fs_home_nav_content_ul_swiper.slideTo(swiper_index, 300, false);
            }


            if ($(window).width() < 960) {
                fs_home_nav_content_li_swiper.slideTo(index, 300, false);

            }
        }, settime);
    }, function () {
        clearTimeout(timer)
    })

    if ($(window).width() < 960) {
        $('.fs_home_nav_ul_overflow .swiper-slide').click(function () {
            var index = $(this).index();
            var fs_home_nav_content_li_top = $('.fs_home_nav_content_wrapper .fs_home_nav_content_li').eq(index).offset().top - $('.header_top').height() - $('.fs_home_nav_shadow').height() - 16 + 'px';
            $('html , body').animate({scrollTop: fs_home_nav_content_li_top}, 300);
        })
        $(window).scroll(function () {
            var topp = $(document).scrollTop();
            $('.fs_home_nav_content_li').each(function () {
                var thistop = $(this).offset().top - $('.header_top').height() - $('.fs_home_nav_shadow').height() - 18;
                if (topp >= thistop) {
                    var this_index = $(this).index();
                    fs_home_nav_content_li_swiper.slideTo(this_index, 300, false);
                    $('.fs_home_nav_ul_overflow .swiper-slide').eq(this_index).addClass('active').siblings('.swiper-slide').removeClass('active');

                }
            })
        })
    }

    // if($(window).width()<960){
    //     var topp1 = $(document).scrollTop();
    //     var offsetTop = $('.fs_home_nav_shadow').offset().top;
    //     if(topp1 >= offsetTop){
    //             $('.fs_home_nav_ul_overflow').addClass('active');
    //         }else{
    //             $('.fs_home_nav_ul_overflow').removeClass('active');
    //         }
    //     $(window).scroll(function(){
    //         var topp = $(document).scrollTop();
    //         if(topp > offsetTop){
    //             $('.fs_home_nav_ul_overflow').addClass('active');
    //         }else{
    //             $('.fs_home_nav_ul_overflow').removeClass('active');
    //         }
    //     })
    // }


    $(function () {
        if ($('#agree_cookie_div').length > 1) {
            var cookie_height = $('#agree_cookie_div').height() + 'px';
            $('.fs_public_footer').css('padding-bottom', cookie_height);
        }
    })

    // $(function(){
    //     var indexLeft = ($('.fs_home_nav_ul li.active').offset().left - $('.fs_home_nav_ul').offset().left) + 'px';
    //     var indexWidth = $('.fs_home_nav_ul li.active').width() + 'px';
    //     $('.fs_home_nav_ul_hover_carrier').css({'left':indexLeft,'width':indexWidth});
    // })

    function resetBackImg() {
        $('.fs_home_nav_ul li').each(function (e, o) {
            var img = $(o).attr('img');
            $(o).find('i').css("background-image", "url(" + img + ")");
        })
    }


    function fs_home_swiper(a, b) {
        var fs_home_nav_content_li_swiper = new Swiper(a, {
            pagination: b,
            paginationClickable: true,
            spaceBetween: 16,
            slidesPerView: 3,
            slidesPerColumn: 2,
            slidesPerGroup: 3,
            observer: true, //修改swiper自己或子元素时，自动初始化swiper
            observeParents: true, //修改swiper的父元素时，自动初始化swiper
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                }
            }
        });
    }
</script>
