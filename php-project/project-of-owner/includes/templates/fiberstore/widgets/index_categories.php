<?php
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版首页分类 使用数据库管理
require_once('includes/classes/homePageClass.php');
$file_path = DIR_FS_SQL_CACHE.'/index/'.$_SESSION['languages_code'].'/';
$file_name = 'index_categories_ob_'.$common_is_mobile.'.html';
$file_path_name = $file_path.$file_name;
if (!file_exists($file_path_name)) {
    ob_start();
    // 获取数据
    require_once('includes/classes/homePageClass.php');
    $home_category_list = new homePageClass(['language_id' => $_SESSION['languages_id']]);
    $home_category = $home_category_list->index_categories_select();
?>
    <?php if(!$common_is_mobile){ // pc ?>
        <div class="categories <?php echo $_SESSION['languages_code'] == 'uk' ? 'categoriesUk':'';?>">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach($home_category as $k=>$v){
                        //au、uk、dn使用英式英语
                        if($_SESSION['languages_code']=='au' || $_SESSION['languages_code']=='uk' ||  $_SESSION['languages_code'] =='dn'){
                            $title = $v['title_british'] ? $v['title_british'] : $v['title'];
                        }else{
                            $title = $v['title'];
                        }
                    ?>
                        <div class="swiper-slide">
                            <a href="<?php echo reset_url($v['link']); ?>">
                                <i></i>
                                <p><?php echo $title; ?></p>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="m-module-new">
            <div class="m-module-container">
                <ul class="m-module-ul">
                    <?php foreach($home_category as $k=>$v){
                        //au、uk、dn使用英式英语
                        if($_SESSION['languages_code']=='au' || $_SESSION['languages_code']=='uk' ||  $_SESSION['languages_code'] =='dn' ){
                            $title_mobile = $v['title_mobile_british'] ? $v['title_mobile_british'] : $v['title_mobile'];
                        }else{
                            $title_mobile = $v['title_mobile'];
                        }
                    ?>
                        <li>
                            <a href="<?php echo reset_url($v['link']); ?>">
                            <i></i>
                            <p class="m-module-txt"><?php echo $title_mobile; ?></p>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
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