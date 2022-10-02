<?php
//新首页banner图
$colums = array('pc_path','mobile_path','alt','url','banner_content','bgcolor');
$banner = fs_get_data_from_db_fields_array($colums,'fs_banner_manage_new','groups=4 and language_id='.$_SESSION['languages_id'].' and category_id='.$current_category_id,'order by sort');
foreach($banner as $k=>$v){
    if($v[0]==''){
        unset($banner[$k]);
    }
}
$banner_num = count($banner);
if($banner_num){
    $version = fs_get_total_from_db('categories_index_menu','categories_id = '.$current_category_id.' and languages_id = '.$_SESSION['languages_id'].' and type = 0');
    if($version > 0){
        if(!$is_mobile || isset($_COOKIE['c_site'])){?>
            <div class="class-top">
                <div class="swiper-container swiper_banner">
                    <div class="swiper-wrapper">
                        <?php foreach($banner as $banner_k=>$banner_v){ ?>
                            <div class="swiper-slide" style="background: <?php echo $banner_v[5];?>;">
                                <a href="<?php echo reset_url($banner_v[3]);?>">
                                    <div class="class-banner-background" style="background-image: url('<?php echo zen_get_img_change_src($banner_v[0]);?>')"></div>
                                    <div class="class-banner-txt-content">
                                        <?php if($banner_v[4]){echo stripslashes($banner_v[4]);}?>
                                    </div>
                                </a>
                            </div>
                        <?php }?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next iconfont icon">&#xf089;</div>
                    <div class="swiper-button-prev iconfont icon">&#xf090;</div>
                </div>
                <?php echo fiberstore_category::show_index_categories($current_category_id);?>
            </div>
        <?php }else{?>
            <div class="m_fc_banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach($banner as $banner_k=>$banner_v){?>
                            <div class="swiper-slide">
                                <a href="<?php echo reset_url($banner_v[3]);?>">
                                    <img src="<?php echo zen_get_img_change_src($banner_v[1]);?>" alt="<?php echo $banner_v[2]?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
                        <?php for($i=0;$i<sizeof($banner);$i++){ ?>
                            <span class="swiper-pagination-bullet <?php if($i==0)echo 'swiper-pagination-bullet-active';?>"></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php }else{?>
        <div class="n17categories_banner">
            <?php
            if(!$is_mobile || isset($_COOKIE['c_site'])){ ?>
                <div class="n17categories_banner_con">
                    <ul>
                        <?php
                        $i = 0;
                        foreach($banner as $banner_k=>$banner_v){
                            $i++;
                            $style = '';
                            if($banner_v[5]){$style = 'style="background:'.$banner_v[5].'"';}
                            ?>
                            <li <?php if($i==1)echo 'class="active" style="opacity:1"';?>>
                                <a href="<?php echo reset_url($banner_v[3]);?>">
                                    <div class="n17categories_banner_bg01" <?php echo $style;?>></div>
                                    <?php if($banner_v[4]){
                                        echo stripslashes($banner_v[4]);}?>
                                    <img src="<?php echo zen_get_img_change_src($banner_v[0]);?>" alt="<?php echo $banner_v[2];?>" />
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="n17categories_banner_btn">
                    <div class="n17categories_banner_btn_prev">
                        <i></i>
                        <span></span>
                    </div>
                    <div class="n17categories_banner_btn_next">
                        <i></i>
                        <span></span>
                    </div>
                    <div class="n17categories_banner_btn_dot">
                        <?php
                        $str_html = '';
                        for($i=0;$i<$banner_num;$i++){
                            $str_html .='<em><span></span><i></i></em>';
                        }
                        echo $str_html;
                        ?>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="swiper-container swiper-container-horizontal home_mobile_banner">
                    <div class="swiper-wrapper">
                        <?php foreach($banner as $banner_k=>$banner_v){ ?>
                            <div class="swiper-slide" style="width: 375px;">
                                <a href="<?php echo reset_url($banner_v[3]);?>">
                                    <?php if($banner_v[4])echo stripslashes($banner_v[4]);?>
                                    <img src="<?php echo zen_get_img_change_src($banner_v[1]);?>" alt="<?php echo $banner_v[2]?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
                        <?php for($i=0;$i<sizeof($banner);$i++){ ?>
                            <span class="swiper-pagination-bullet <?php if($i==0)echo 'swiper-pagination-bullet-active';?>"></span>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }?>
<?php }?>