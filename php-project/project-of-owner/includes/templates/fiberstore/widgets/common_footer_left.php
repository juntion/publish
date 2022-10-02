<?php
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版尾部 使用数据库管理
// 除了uk、au、jp，没有$footer_is_german_warehouse，其他都有

$file_footer_path = DIR_FS_SQL_CACHE.'/htmls/'.$_SESSION['languages_code'].'/';
if (in_array(strtolower($_SESSION['countries_iso_code']), ['us', 'pr'])) {
    if(strtolower($_SESSION['countries_iso_code']) == 'us'){
        $file_footer_name = 'footer_left_ob_e_rate_'.$footer_is_german_warehouse.'_'.$_SESSION['countries_iso_code'].'_'.$common_is_mobile.'.html';
    }else{
        $file_footer_name = 'footer_left_ob_e_rate_'.$footer_is_german_warehouse.'_'.$common_is_mobile.'.html';
    }
}else{
    $file_footer_name = 'footer_left_ob_'.$footer_is_german_warehouse.'_'.$common_is_mobile.'.html';
}
$file_footer_path_name = $file_footer_path.$file_footer_name;
if (!file_exists($file_footer_path_name)) {
    echo '<!-- no cache -->';
    ob_start();
    // 获取数据
    if(!$home_custom_model){
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
    }
    $warehouse = '';
    if($_SESSION['languages_code'] == 'fr'){
        if(seattle_warehouse($code = "country_code",$_SESSION['countries_code_21'])){
            $warehouse = 1;
        }else{
            $warehouse = 2;
        }
    }
    if($_SESSION['languages_code'] == 'ru'){
        if(all_german_warehouse($code="country_code",$_SESSION['countries_code_21'])){
            $warehouse = 2;
        }else{
            $warehouse = 4;
        }
    }
    $footer_data = $home_custom_model->get_footer_data($footer_is_german_warehouse,$warehouse);
?>
    <?php if(!$common_is_mobile){ // pc ?>
        <?php foreach($footer_data as $key => $val){ ?>
            <dl>
                <dt><?php echo $val['title']; ?></dt>
                <dd>
                    <?php foreach($val['list'] as $key1 => $val1){
                        $target = strpos($val1['url'],'youtube') ? 'target="_blank"' : '';
                        ?>
                        <p><a <?php echo $target;?> href="<?php echo $val1['url']?reset_url($val1['url']):'javascript:;'; ?>"  <?php if($val1['id']){ echo 'id="'.$val1['id'].'"';} ?> ><?php echo $val1['title']; ?></a></p>
                    <?php } ?>
                </dd>
            </dl>
        <?php } ?>
    <?php }else{ ?>
        <div class="m_footer_03">
            <?php foreach($footer_data as $key => $val){
                ?>
                <div class="m_footer_03_one">
                    <div class="m_footer_03_inner"><a href="javascript:;"><span><?php echo $val['title']; ?></span><i class="icon iconfont footer_category"></i></a></div>
                    <div class="m_footer_03_two">
                        <?php foreach($val['list'] as $key1 => $val1){?>
                            <a href="<?php echo $val1['url']?reset_url($val1['url']):'javascript:;'; ?>"  <?php if($val1['id']){ echo 'id="'.$val1['id'].'"';} ?> ><?php echo $val1['title']; ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php
    $buffer = ob_get_contents();
    ob_flush();
    ob_end_clean();

    if ($buffer) {
        cacheFactory::save_caching_file_contents($file_footer_name, $file_footer_path, $buffer);
    }
} else {
    $buffer = file_get_contents($file_footer_path_name);
    echo $buffer;
}
?>