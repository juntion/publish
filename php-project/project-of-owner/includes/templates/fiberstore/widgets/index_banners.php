<?php
use App\Services\Image\ImageService;

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版首页banner 使用数据库管理
$banner_warehouse_str = get_warehouse_banner_str();
$file_path = DIR_FS_SQL_CACHE.'/index/'.$_SESSION['languages_code'].'/';
//判断是否支持webp格式的，缓存也要区分，不然切换浏览器之后，缓存会出现图片不显示的问题
if (is_support_webp()) {
    $file_name = 'index_banners_ob_'.$banner_warehouse_str.'_'.$_SESSION['countries_iso_code'].'_'.$common_is_mobile.'_webp'.'.html';
} else {
    $file_name = 'index_banners_ob_'.$banner_warehouse_str.'_'.$_SESSION['countries_iso_code'].'_'.$common_is_mobile.'.html';
}
$file_path_name = $file_path.$file_name;
if (!file_exists($file_path_name)) {
    ob_start();
    // 获取数据
    if(!$home_custom_model){
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
    }
    $banner = $home_custom_model->get_index_banners_data($banner_warehouse_str);

    if(is_show_mts()){
        if($_SESSION['languages_code'] == 'ru'){
            $title = 'FS × #CloudMTS для СКС в ЦОД';
            $tip = 'Повышение облачных сервисов на более высокий уровень';
            $img_mobile_path = 'dataCenter-structure-img/MTSbanner-m-ru.jpg';
        }else{
            $title = 'FS Contributes to #CloudMTS Data Center SCS';
            $tip = 'Boosting Its Cloud Project into a Greater Level';
            $img_mobile_path = 'dataCenter-structure-img/MTSbanner-m_en.jpg';
        }
        $content = '<div class="banner_main_font white" style="width: 100%;left: 0;text-align: center">
                    <h2>'.$title.'</h2>
                    <p>'.$tip.'</p>
                    <span class="banner_main_font_more" style="color: #fff;">'.FS_LEARN_MORE.'
                    <em class="icon iconfont"></em></span></div>';

        array_unshift($banner, array(
            'img_mobile_path' => 'https://img-en.fs.com/includes/templates/fiberstore/images/specials/'.$img_mobile_path,
            'img_pc_path' => 'https://img-en.fs.com/includes/templates/fiberstore/images/specials/100g_new_products/100g_banner_new.jpg',
            'url_str' => reset_url('/specials/data-center-structured-cabling-108.html'),
            'content' => $content
        ));
    }

    //webp的图片
    if (is_support_webp()) {
        $temp_language_id = $_SESSION['languages_id'];
        switch ($_SESSION['languages_code']) {
            case 'dn':
                $temp_language_id = 1;
                break;
            case 'uk':
                $temp_language_id = 1;
                break;
            case 'au':
                $temp_language_id = 1;
                break;
            case 'sg':
                $temp_language_id = 1;
                break;
        }
        //index_banner部分仓库
        $temp_warehouse = 0;

        $origin_type_ids = array();
        foreach ($banner as $key => $value) {
            $origin_type_ids[] = $value['id'];
        }

        if (count($origin_type_ids)) {
            $imageService = new ImageService();

            $webp_paths = $imageService->getwebppathbyids($origin_type_ids, 'fs_home_custom_des', array('img_pc_path', 'img_mobile_path'), $temp_language_id, array(), $temp_warehouse);
            $webp_paths_keys = array_keys($webp_paths);

            foreach ($banner as $k => $v) {
                if (in_array($v['id'], $webp_paths_keys)) {
                    if (isset($webp_paths[$v['id']]['img_pc_path'])) {
                        $v['img_pc_path'] = $webp_paths[$v['id']]['img_pc_path'];
                    }
                    if (isset($webp_paths[$v['id']]['img_mobile_path'])) {
                        $v['img_mobile_path'] = $webp_paths[$v['id']]['img_mobile_path'];
                    }

                }
                $banner[$k] = $v;
            }
        }
    }
?>
    <?php if(!$common_is_mobile){ // pc ?>
        <div class="banner">
            <div class="banner_main">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach($banner as $banner_k=>$banner_v){
                            if (empty($banner_v['img_pc_path']) || (is_show_mts() && strpos($banner_v['url_str'],'100g-fmx-transport-platform-103'))) {
                                continue;
                            }
                            ?>
                            <div class="swiper-slide" data-home-custom-name="<?php echo $banner_v['home_custom_name'];?>">
                                <div class="banner_main_pic pic01" style="background-image: url('<?php echo zen_get_img_change_src($banner_v['img_pc_path']);?>');"></div>
                                <a href="<?php echo $banner_v['url_str']; ?>">
                                    <div class="slide_main">
                                        <?php
                                        if (get_warehouse_by_code($_SESSION['countries_iso_code']) == 'cn' && $banner_v['content'] && strstr($banner_v['url_str'],'shipping_delivery.html')){ //武汉仓发货
                                            $str = preg_replace("/[\t\n\r]+/","",$banner_v['content']);
                                            if (strstr($str,'</h2>')){
                                                $tips = zen_banner_tip();
                                                echo preg_replace('/<h2.*<\/h2>/','<h2>'.$tips.'</h2>',$str);
                                            }else{
                                                echo $banner_v['content'];
                                            }
                                        }else{
                                            echo $banner_v['content'];
                                        }
                                        ?>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination">
                        <?php foreach($banner as $banner_k=>$banner_v){ ?>
                            <span class="swiper-pagination-bullet"></span>
                        <?php } ?>
                    </div>
                    <div class="swiper-button-switch-container">
                        <div class="swiper-button-next icon iconfont">&#xf089;</div>
                        <div class="swiper-button-prev icon iconfont">&#xf090;</div>
                    </div>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="index_wap_banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach($banner as $banner_k=>$banner_v){
                        if (empty($banner_v['img_mobile_path']) || (is_show_mts() && strpos($banner_v['url_str'],'100g-fmx-transport-platform-103'))) {
                            continue;
                        }
                        ?>
                        <div class="swiper-slide" data-home-custom-name="<?php echo $banner_v['home_custom_name'];?>">
                            <a href="<?php echo $banner_v['url_str'];?>">
                                <img src="<?php echo zen_get_img_change_src($banner_v['img_mobile_path']);?>" />
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination">
                    <?php foreach($banner as $banner_k=>$banner_v){ ?>
                        <span class="swiper-pagination-bullet"></span>
                    <?php } ?>
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
    echo '<!-- banner cache -->';
    $buffer = file_get_contents($file_path_name);
    echo $buffer;
}
?>