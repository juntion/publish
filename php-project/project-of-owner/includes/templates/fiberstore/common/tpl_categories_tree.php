<?php
$tree_path = DIR_FS_SQL_CACHE."/htmls/".$_SESSION['languages_code']."/";
$tree_name = "download_tree_ob.html";
$tree_path_name = $tree_path.$tree_name;
if (!file_exists($tree_path_name)) {
    ob_start();
    $categories_arr = $category->getCategories(0,0);
    $current_page = $_GET['main_page'];
    ?>
    <div class="three_level_linkage">
        <ul class="selector_stair_ul">
            <input type="hidden" id="category_level" value="1">
            <input type="hidden" id="category_info" c-id="<?php echo $current_category_id;?>" c-url="<?php echo $url_param;?>">
            <?php
            foreach ($categories_arr as $k=>$v){
                ?>
                <li class="selector_stair_li" data-id="<?php echo $v['categories_id'];?>">
                    <dl class="selector_stair_dl">
                        <dt class="selector_stair_dt" c-id="<?php echo $v['categories_id'];?>" c-url="<?php echo $v['categories_url'] ? reset_url($current_page.'/'.$v['categories_url']) : zen_href_link($current_page,'&cPath='.$v['categories_id'],'SSL');?>">
                            <i class="iconfont icon">&#xf089;</i>
                            <span><?php echo $v['categories_name'];?></span>
                        </dt>
                        <dd class="selector_stair_dd">
                            <?php
                            foreach ($v['second'] as $second){
                                if($second['categories_name']) {
                                    ?>
                                    <dl class="second_level_dl" data-id="<?php echo $second['categories_id'];?>">
                                        <dt class="second_level_dt" c-id="<?php echo $second['categories_id'];?>" c-url="<?php echo $second['categories_url'] ? reset_url($current_page.'/'.$second['categories_url']) : zen_href_link($current_page,'&cPath='.$second['categories_id'],'SSL');?>">
                                            <i class="iconfont icon">&#xf089;</i>
                                            <span><?php echo $second['categories_name']; ?></span>
                                        </dt>
                                        <dd class="second_level_dd">
                                            <?php
                                            foreach ($second['third'] as $third){
                                                ?>
                                                <dl class="third_class_dl" data-id="<?php echo $third['categories_id'];?>">
                                                    <dt class="third_class_dt" c-id="<?php echo $third['categories_id'];?>" c-url="<?php echo $third['categories_url'] ? reset_url($current_page.'/'.$third['categories_url']) : zen_href_link($current_page,'&cPath='.$third['categories_id'],'SSL');?>">
                                                        <i class="iconfont icon">&#xf089;</i>
                                                        <span><?php echo $third['categories_name'];?></span>
                                                    </dt>
                                                    <dd class="third_class_dd">
                                                    </dd>
                                                </dl>
                                                <?php
                                            }
                                            ?>
                                        </dd>
                                    </dl>
                                    <?php
                                }
                            }
                            ?>
                        </dd>
                    </dl>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
    $buffer = ob_get_contents();
    ob_flush();
    ob_end_clean();
    if ($buffer) {
        cacheFactory::save_caching_file_contents($tree_name, $tree_path, $buffer);
    }
} else {
    $buffer = file_get_contents($tree_path_name);
    echo $buffer;
}
?>