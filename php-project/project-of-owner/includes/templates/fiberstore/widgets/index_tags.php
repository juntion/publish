<?php
use App\Services\Image\ImageService;

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版首页视频 使用数据库管理
$file_path = DIR_FS_SQL_CACHE.'/index/'.$_SESSION['languages_code'].'/';

//判断是否支持webp格式的，缓存也要区分，不然切换浏览器之后，缓存会出现图片不显示的问题
if (is_support_webp()) {
    $file_name = 'index_videos_ob_'.$_SESSION['currency'].'_'.$common_is_mobile.'_webp'.'.html';
} else {
    $file_name = 'index_videos_ob_'.$_SESSION['currency'].'_'.$common_is_mobile.'.html';
}

$file_path_name = $file_path.$file_name;
if (!file_exists($file_path_name)) {
    ob_start();
    // 获取数据
    if(!$home_custom_model){
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
    }
    $home_video_list = $home_custom_model->get_index_tagimg_data();

    ?>
    <?php if(!$common_is_mobile){ // pc ?>
        <h2 class="index_main_tit"><?php echo FS_TAGIMG_TITLE;?> 
        <span>
            <a href="<?php echo reset_url('ideas.html');?>">
                <em><?php echo FS_TAGIMG_LEARN_MORE; ?></em>
            
                <i class="iconfont icon">&#xf089;</i>
            </a>
        </span> 
    </h2>
        <div class="index_main_con">
            <div class="index_main_con_product">
                <div class="pc-advice-flex-container">
                    <?php
                        $scene_ids = [];

                        foreach ($home_video_list as $tag_val) {
                            $scene_ids[] = intval($tag_val['scene_id']);
                        }
                        //避免sql报错
                        $scene_ids[] = 0;
                        $scene_arr = get_products_tag_by_ids($scene_ids);

                        $origin_type_ids = [];
                        foreach ($scene_arr as $key => $val) {
                            $origin_type_ids[] = $val['images_id'];
                        }

                        //将图片转化为webp格式的图片
                        $webp_paths = array();
                        if (is_support_webp()) {
                            $imageService = new ImageService();
                            $webp_paths = $imageService->getwebppathbyids($origin_type_ids, 'tag', array('thumb_one_url', 'thumb_two_url'), 0);
                            $webp_paths_keys = array_keys($webp_paths);
                        }

                        foreach ($scene_arr as $tag_val){
                            if (isset($webp_paths) && isset($webp_paths_keys) && $webp_paths_keys && in_array($tag_val['images_id'], $webp_paths_keys)) {
                                $tag_val['thumb_one_url'] = $webp_paths[$tag_val['images_id']]['thumb_one_url'];
                            } else {
                                if ((!is_support_webp()) && (strrpos($tag_val['thumb_one_url'], '.webp') !== false)) {
                                    $tag_val['thumb_one_url'] = substr($tag_val['thumb_one_url'], 0, strrpos($tag_val['thumb_one_url'], '.'));
                                }
                            }
                    ?>
                        <dl class="pc-advice-dl">
                            <dt class="new-mtp-img-container">
                                <img src="<?php echo HTTPS_IMAGE_SERVER.$tag_val['thumb_one_url'];?>">
                                <?php
                                $points_data = get_all_points_html($tag_val['points_data']);
                                echo $points_data;
                                ?>
                            </dt>
                        </dl>
                    <?php };?>
                </div>
            </div>
        </div>
        <!-- QV window -->
        <div class="new_popup addCart show new_pro_QV qv_edition_eightAugust" id="new_pro_QV" style="display: none;">
            <div class="new_popup_bg"></div>
            <div class="new_popup_main popup_width880" id="new_pro_QV_window">
                <div class="new_popup_content addCart_cont product_email_share" id="new_pro_QV_inner">

                </div>
                <input type="hidden" id="qv_first_product_id" value="">
            </div>
        </div>
        <!-- add cart new success -->
        <div id="product_cart_popup">
        </div>
    <?php }else{ ?>
        <div class="m-alone-block">
            <h2 class="m-block-tit"><?php echo FS_TAGIMG_TITLE; ?><span><a href="<?php echo reset_url('ideas.html');?>"><?php echo FS_TAGIMG_LEARN_MORE; ?><i class="iconfont icon">&#xf089;</i></a></span></h2>
            <div class="m-swiper-con">
                <div class="swiper-container swiper-tag">
                    <div class="swiper-wrapper swiper-slide-active" >
                    <?php
                        $scene_ids = [];
                        foreach ($home_video_list as $tag_val) {
                            $scene_ids[] = intval($tag_val['scene_id']);
                        }
                        //避免sql报错
                        $scene_ids[] = 0;
                        $scene_arr = get_products_tag_by_ids($scene_ids);

                        $origin_type_ids = [];
                        foreach ($scene_arr as $key => $val) {
                            $origin_type_ids[] = $val['images_id'];
                        }

                        //将图片转化为webp格式的图片
                        $webp_paths = array();
                        if (is_support_webp()) {
                            $imageService = new ImageService();
                            $webp_paths = $imageService->getwebppathbyids($origin_type_ids, 'tag', array('thumb_one_url'), 0);
                            $webp_paths_keys = array_keys($webp_paths);
                        }

                        foreach ($scene_arr as $tag_val){

                            if (isset($webp_paths) && isset($webp_paths_keys) && $webp_paths_keys) {
                                if (in_array($tag_val['images_id'], $webp_paths_keys)) {
                                    $tag_val['thumb_one_url'] = $webp_paths[$tag_val['images_id']]['thumb_one_url'];
                                }
                            }
                    ?>
                        <div class="swiper-slide">
                            <dl class="pc-advice-dl">
                                <dt class="new-mtp-img-container">
                                    <img src="<?php echo HTTPS_IMAGE_SERVER.$tag_val['thumb_one_url'];?>">
                                    <?php
                                    $points_data = get_all_points_html($tag_val['points_data']);
                                    echo $points_data;
                                    ?>
                                </dt>
                            </dl>
                        </div>
                        <?php };?>
                    </div>
					<div class="swiper-pagination  pag-new-Paging">
						<span class="swiper-pagination-bullet"></span>
						<span class="swiper-pagination-bullet"></span>
						<span class="swiper-pagination-bullet"></span>
					</div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    $buffer = ob_get_contents();
    ob_flush();
    ob_end_clean();
    if ($buffer) {
        cacheFactory::save_caching_file_contents($file_name, $file_path, $buffer);
    }
} else {
    $buffer = file_get_contents($file_path_name);
    echo $buffer;
}
?>
<script>var oMobile = <?php echo $common_is_mobile; ?></script>
