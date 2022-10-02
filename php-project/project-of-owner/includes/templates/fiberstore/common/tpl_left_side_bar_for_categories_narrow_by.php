<?php
$count_of_cPath_array = sizeof($cPath_array);
$ParentCID = categories_of_parent_id($current_category_id);
$where_clearing = ' and is_clearing = 0 ';
?>
<div class="proName_select_left">
<?php
//$file_name = "cache/category_narrow/".$_SESSION['languages_code']."/". $_GET['cPath'] . ".html";
//if (!file_exists($file_name)) {
//    ob_start();
    $simgle_narrow = '';
    if ($_GET['narrow']) {
        for ($ni = 0; $ni < sizeof($_GET['narrow']); $ni++) {
            $simgle_narrow .= '&narrow[]=' . $_GET['narrow'][$ni];
        }
        $simgle_narrow .= '&';
    }
    if ($count_of_cPath_array > 1) {
        $category_title = '';
        $category_title_class = "sidebar_06";
        $secondC_class = "select";
    } else {
        $category_title = '<b>' . FS_SHOW_RESULT . '</b>';
        $category_title_class = "sidebar_04";
        if ($cPath_array[2]) {
            $second_add_class = ' category_02';
        } else {
            $second_add_class = '';
        }
        $secondC_class = "category_01" . $second_add_class;
    }
    ?>

    <?php echo $category_title; ?>
    <?php if (3 > $count_of_cPath_array){ ?>
        <dl class="listSel">
            <?php if (!$cPath_array[1]) { ?>
                <span><a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_array[0]); ?>"><?php echo zen_get_categories_name($cPath_array[0]); ?></a></span>
                <dt style="color:#A10000;font-weight:bold;"><?php echo (2 == sizeof($cPath_array)) ? zen_get_categories_name($cPath_array[1]) : '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_array[1]) . '">' . zen_get_categories_name($cPath_array[1]) . '</a>'; ?></dt>
            <?php } else {
                echo '<dt>' . BOX_HEADING_CATEGORIES . '<i class="up_down_ic iconfont">&#xf049</i></dt>';
            }
            if (2 == sizeof($cPath_array)) {
                if (zen_has_category_subcategories($cPath_array[1])) {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[1],$where_clearing);
                    $S_sort = 1;
                    $cDIV = false;
                    foreach ($categories as $i => $cID) {
                        $S_sort++;
                        $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                        if ($S_sort == 9 && sizeof($categories) > 8) {
                            $cDIV = true;
                            //echo '<div class="all_subcategories_list" id="subcategory_pulldown" style="display:none;">';
                        }
                        if($i == 0){
                            $class_choosez = "listLi choosez";
                        }else{
                            $class_choosez = "listLi";
                        }
                        echo '<dd class="listLi1"><a href="' . $href . '">' . zen_get_categories_name($cID) . '</a></dd>';
                    }
                    if ($cDIV) {
                        // echo '</div>';
                        // echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);">'.FS_SHOW_MORE.'</a> </div>';
                    }

                } else {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[0],$where_clearing);
                    foreach ($categories as $i => $cID) {
                        if ($cID == (int)$cPath_array[1]) {
                            echo '<dd class="listLi1 list_not_alink"><a>' . zen_get_categories_name($cPath_array[1]) . '</a></dd>';
                        } else {
                            echo '<dd class="listLi1"><a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID) . '">' . zen_get_categories_name($cID) . '</a></dd>';
                        }
                    }

                }
            }
            ?>
        </dl>
    <?php }else {
    ?>
    <dl class="listSel">
        <dt><?php ECHO BOX_HEADING_CATEGORIES; ?><i class="up_down_ic iconfont">&#xf049</i></dt>
        <?php
        if (zen_has_category_subcategories($cPath_array[1])) {
            $categories_reset = zen_get_subcategories_of_one_category($cPath_array[1],$where_clearing);
            $c_sort = 0;
            $categories = $categories_reset;
            $href2 = '';
            $scDIV = false;
            foreach ($categories as $i => $cID) {
                $c_sort++;
                // if($cPath_array[0] == 9){
                // if($simgle_narrow && ($cPath_array[1] != 61)){
                // $href2 = zen_href_link(FILENAME_NARROW,$simgle_narrow.'&cPath='.$cID);
                //  }else{
                //  $href2 = zen_href_link(FILENAME_DEFAULT,'cPath='.$cID);
                //  }
                //}else{
                $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                //}

                if ($c_sort == 9 && sizeof($categories) > 8) {
                    $scDIV = true;
                    //echo '<div class="all_subcategories_list" id="subcategory_pulldown" style="display:none;">';
                }
                if ($current_category_id == $cID || $cPath_array[2] == $cID) {
                    echo '<dd class="listLi1 list_not_alink"><a href="javascript:void(0);">' . zen_get_categories_name($cID) . '</a></dt>';
                } else {
                    echo '<dd class="listLi1"><a href="' . $href2 . '">' . zen_get_categories_name($cID)/*.' '.zen_get_products_count_of_category($cID)*/ . '</a></dd>';
                }
            }
            if ($scDIV) {
                // echo '</div>';
                // echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);">'.FS_SHOW_MORE.'</a> </div>';
            }
        } else {
            echo '<dd class="listLi1">' . zen_get_categories_name($cPath_array[1]) ./*' '.zen_get_products_count_of_category($cPath_array[1]).*/
                '</dd>';
        }
        echo ' </dl>';
        if ($cPath_array[0] == 9) {
            $showName = FS_COMPATIBLE_BRANDS;
        } else {
            $showName = BOX_HEADING_CATEGORIES;
        }

        //如果有四级，就显示出来
        //if($cPath_array[0] == 9){
        if (zen_has_category_subcategories($cPath_array[2])) {
            echo '<dl class="listSel">
                	          <dt>' . $showName . '<i class="up_down_ic iconfont">&#xf049</i></dt>';
            $categories_reset = zen_get_subcategories_of_one_category($cPath_array[2],$where_clearing);
            $first_categories = array_slice($categories_reset, 0, 7);
            if (in_array($current_category_id, $first_categories) || !$cPath_array[3]) {
                $subcategories_display = 'style="display:none;"';
                $subcategories_click = FS_SHOW_MORE;
                $click_css = '';
            } else {
                $subcategories_display = 'style="display:block;"';
                $subcategories_click = FS_SHOW_LESS;
                $click_css = 'class="sidebar_more"';
            }
            /*
                   if($cPath_array[0] == 9 && in_array($current_category_id,$categories_reset)){
                   $default_Carray = array($current_category_id);
                   $select_category = true;
                   $c_sort = 1;
                   $categories = array_diff($categories_reset,$default_Carray);
                echo '<dd class="xiand"><a class="default_category" href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$cPath_array[2]).'">'.zen_get_categories_name($current_category_id).'</a></dd>';
                   }else{
                   $c_sort = 0;
                   $categories = $categories_reset;
                   }
             */
            $c_sort = 0;
            $categories = $categories_reset;
            $href2 = '';
            $category_narrow = '';
            $fcDIV = false;
            foreach ($categories as $i => $cID) {
                $c_sort++;
                if ($cPath_array[0] == 9) {
                    $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                } else {
                    $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                }

                if ($c_sort == 9 && sizeof($categories) > 8) {
                    $fcDIV = true;
                    echo '<div class="all_subcategories_list" id="subcategory_pulldown" ' . $subcategories_display . '>';
                }
                if ($current_category_id == $cID) {
                    echo '<dd class="listLi1 list_not_alink"><a href="javascript:;">' . zen_get_categories_name($cID) . '</a></dd>';
                } else {
                    echo '<dd class="listLi1"><a href="' . $href2 . '">' . zen_get_categories_name($cID)/*.' '.zen_get_products_count_of_category($cID)*/ . '</a></dd>';
                }
            }
            if ($fcDIV) {
                echo '</div>';
                echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);" ' . $click_css . '>' . $subcategories_click . '</a> </div>';
            }
        }
        //}
        echo '</dl>';
        } ?>

        <?php
        if (!in_array($current_category_id, array(1, 3, 4, 9, 209, 573, 904, 911))) {
            if (!class_exists('products_narrow_by')) {
                require DIR_WS_CLASSES . 'products_narrow_by.php';
                $products_narrow_by = new products_narrow_by();
            }
            $c_pids = array();
            if ($all_product) {
                foreach ($all_product as $kk => $c_pro) {
                    $c_pids [] = $c_pro['id'];
                }
            }
            if ($cPath_array[1] && !$cPath_array[2] && zen_has_category_subcategories($cPath_array[1])) {
                if($cPath_array[1] == 1068 || $cPath_array[1] == 2961){
                    if(sizeof($c_pids)){
                        echo $products_narrow_by->fs_products_left_list($current_category_id, $c_pids, $get_narrow);
                    }
                }
            } else  {
                if (sizeof($c_pids)) {
                    echo $products_narrow_by->fs_products_left_list($current_category_id, $c_pids, $get_narrow);
                }
            }
        }
        if (sizeof($get_narrow)) {
            ?>
            <div class="clear_narrow">
                <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'cPath=' . $current_category_id); ?>" onclick="spinloader()"><i></i><?php ECHO FS_CLEAR_SELECTIONS; ?></a>
            </div>
            <?php
        }

//        $buffer = ob_get_contents();
//        ob_flush();
//        ob_end_clean();
//        file_put_contents($file_name, $buffer);
//    } else {
//        echo '<!-- cache --> ';
//        $buffer = file_get_contents($file_name);
//        echo $buffer;
//    }
    ?>
</div>
<script type="text/javascript">
    $("#pulldownC").click(function () {
        if ($("#subcategory_pulldown").is(":hidden")) {
            $("#pulldownC").addClass('sidebar_more');
            $("#pulldownC").html('<?php ECHO FS_SHOW_LESS;?>');
            $("#subcategory_pulldown").slideDown();
        } else {
            $("#pulldownC").removeClass('sidebar_more');
            $("#pulldownC").html('<?php ECHO FS_SHOW_MORE;?>');
            $("#subcategory_pulldown").slideUp();
        }
    });
</script>