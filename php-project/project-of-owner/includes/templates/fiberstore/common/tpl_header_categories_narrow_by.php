<?php
// 是否是手机
$is_mobile = isMobile();
$common_is_mobile = (!$is_mobile || isset($_COOKIE['c_site']))?0:1;
if (!class_exists('products_narrow_by')) {
    require DIR_WS_CLASSES . 'products_narrow_by.php';
    $products_narrow_by = new products_narrow_by();
}
require_once DIR_WS_CLASSES . 'shipping_info.php';
$showProductsListPost = new ShippingInfo();
$count_of_cPath_array = sizeof($cPath_array);
if($page_jump_links){
    $cpath_url = explode('?',$page_jump_links);
}
$ParentCID = categories_of_parent_id($current_category_id);
$where_clearing = ' and is_clearing = 0 ';
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
<?php if(!$common_is_mobile){//pc端头部筛选?>
    <div class="new_proList_bigTabBox">
        <div class="new_proList_mainProseBox">
            <div class="new_proList_mainProse">
                <?php if (3 > $count_of_cPath_array){?>
                <dl class="popularity_view_listz1 new_proList_autoDev" sameparent="Parent1">
                    <dt class="popularity_view_sortz1">
                        <?php
                        if (!$cPath_array[1]) {
                            echo '<p>' . zen_get_categories_name($cPath_array[1]) . '<span class="iconfont icon">&#xf087;</span></p>';
                        }else {
                            echo '<p>' . BOX_HEADING_CATEGORIES . '<span class="iconfont icon">&#xf087;</span></p>';
                        }
                        echo '</dt><dd class="popularity_view_listz1_li"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
                        if (2 == sizeof($cPath_array)) {
                            if (zen_has_category_subcategories($cPath_array[1])) {
                                $categories = zen_get_subcategories_of_one_category($cPath_array[1],$where_clearing);
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
                                    echo '<div class="popularity_view_listz1_liMain">
                                            <a href="' . $href . '"><div class="new_proList_mainLabel" data="'.$cID.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div></a>
                                      </div>';
                                }

                                if ($cDIV) {
                                    // echo '</div>';
                                    // echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);">'.FS_SHOW_MORE.'</a> </div>';
                                }

                            } else {
                                $categories = zen_get_subcategories_of_one_category($cPath_array[0],$where_clearing);
                                foreach ($categories as $i => $cID) {
                                    if ($cID == (int)$cPath_array[1]) {
                                        echo '<div class="popularity_view_listz1_liMain">
                                            <div class="new_proList_mainLabel choosez" data="'.$cID.'" samedata="Had0">' . zen_get_categories_name($cPath_array[1]) . '</div>
                                      </div>';
                                    } else {
                                        echo '<div class="popularity_view_listz1_liMain">
                                            <a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID) . '"><div class="new_proList_mainLabel" data="'.$cID.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div></a>
                                      </div>';
                                    }
                                }

                            }
                        }
                        echo '</div></dd></dl>';
                        if (zen_has_category_subcategories($cPath_array[1])) {

                            $categories_reset = zen_get_subcategories_of_one_category($cPath_array[1], $where_clearing);
                            $categories = $categories_reset;
                            $href2 = '';
                            $category_narrow = '';
                            $categories_str = '';
                            $fcDIV = false;
                            foreach ($categories as $i => $cID) {
                                $categories_val = zen_get_subcategories_of_one_category($cID, $where_clearing);
                                if ($categories_val) {
                                    foreach ($categories_val as $vvID) {
                                        $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $vvID);
                                        $categories_str .= '<div class="popularity_view_listz1_liMain">
                                            <a href="' . $href2 . '"><div class="new_proList_mainLabel" data="' . $vvID . '" samedata="Had0">' . zen_get_categories_name($vvID) . '</div></a>
                                      </div>';
                                    }
                                }
                            }
                            $showName = getShowName($cPath_array);
                            if($categories_str != '' && 2 != sizeof($cPath_array)){
                                echo '<dl class="popularity_view_listz1 new_proList_autoDev" sameparent = "Parent2">
                            <dt class="popularity_view_sortz1">
                                <p>' . $showName . '<span class="iconfont icon">&#xf087;</span></p>
                            </dt><dd class="popularity_view_listz1_li"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">'.$categories_str.'</div></dd></dl>';
                            }
                        }
                        ?>
                        <?php }else{?>
                        <dl class="popularity_view_listz1 new_proList_autoDev" sameparent="Parent1">
                            <dt class="popularity_view_sortz1">
                                <p><?php ECHO BOX_HEADING_CATEGORIES; ?><span class="iconfont icon">&#xf087;</span></p>
                            </dt>
                            <?php
                            if (zen_has_category_subcategories($cPath_array[1])) {
                                echo '<dd class="popularity_view_listz1_li"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
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
                                        echo '<div class="popularity_view_listz1_liMain">
                                        <div class="new_proList_mainLabel choosez" data="'.$i.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div>
                                  </div>';
                                    } else {
                                        echo '<div class="popularity_view_listz1_liMain">
                                        <a href="' . $href2 . '"><div class="new_proList_mainLabel" data="'.$i.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div></a>
                                  </div>';
                                    }
                                }
                                if ($scDIV) {
                                    // echo '</div>';
                                    // echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);">'.FS_SHOW_MORE.'</a> </div>';
                                }
                                echo '</div></dd></dl>';
                            }
                            if ($cPath_array[2] && zen_has_category_subcategories($cPath_array[2]) && 2 != sizeof($cPath_array) && $current_category_id !=959) { //$current_category_id !=959 XQ20210412004  因四级分类下不展能展示关联组，产品后台重新维护了RJ45 Connectors & Jacks 四级分类筛选项，并需隐藏现有四级分类
                                $showName = getShowName($cPath_array);
                                echo '<dl class="popularity_view_listz1 new_proList_autoDev" sameparent = "Parent2">
                            <dt class="popularity_view_sortz1">
                                <p>' . $showName . '<span class="iconfont icon">&#xf087;</span></p>
                            </dt><dd class="popularity_view_listz1_li"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
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
                                $c_sort = 0;
                                $categories = $categories_reset;
                                $href2 = '';
                                $category_narrow = '';
                                $fcDIV = false;
                                foreach ($categories as $i => $cID) {
                                    $c_sort++;
                                    $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                                    if ($current_category_id == $cID) {
                                        echo '<div class="popularity_view_listz1_liMain">
                                            <div class="new_proList_mainLabel choosez" data="'.$i.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div>
                                      </div>';
                                    } else {
                                        echo '<div class="popularity_view_listz1_liMain">
                                            <a href="' . $href2 . '"><div class="new_proList_mainLabel" data="'.$i.'" samedata="Had0">' . zen_get_categories_name($cID) . '</div></a>
                                      </div>';
                                    }
                                }
                                echo '</div></dd></dl>';
                            }
                            ?>
                            <?php
                            }
                            if (!in_array($current_category_id, array(1, 3, 4, 9, 209, 573, 904, 911,1334))) {
                                $c_pids = array();
                                if ($all_product) {
                                    foreach ($all_product as $kk => $c_pro) {
                                        $c_pids [] = $c_pro['id'];
                                    }
                                }
                                /*if ($cPath_array[1] && !$cPath_array[2] && zen_has_category_subcategories($cPath_array[1])) {
                                    echo 1;
                                    if($cPath_array[1] == 1068 || $cPath_array[1] == 2961){
                                        if(sizeof($c_pids)){
                                            //echo $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,1);
                                        }
                                    }
                                } else  {*/
                                    //var_dump($products_narrow_by->fs_category_products_narrow_option($c_pids,'cpath',$current_category_id));
                                    if (sizeof($c_pids)) {
                                        $key = md5($current_category_id.'_'.json_encode($c_pids).'_'.json_encode($get_narrow).'_'.$_SESSION['languages_code'].'_1');
                                        $data = get_redis_key_value($key,"categories_option");
                                        if($data){
                                            echo $data;
                                        }else{
                                            $data = $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,1);
                                            set_redis_key_value($key,$data,24*3600,"categories_option");
                                            echo $data;
                                        }
                                    }
                                //}
                            }
                            ?>
                            <dl class="popularity_view_listz1 select_two <?php echo $picture_array_page;?>">
                                <dt class="popularity_view_sortz1">
                                    <p><span class="popularity_view_sortTxt"><?php echo FS_SORT_BY;?></span><span class="popularity_view_sortPriceTxt"><?php echo $sort_by;?></span><span class="iconfont icon">&#xf087;</span></p>
                                </dt>
                                <dd class="popularity_view_listz1_li">
                                    <div class="popularity_view_listArrow"></div>
                                    <div data="price" class="popularity_view_listz1_liMain <?php echo $priceselected;?>" onclick="change_sort_order_by($(this).attr('data'),'two',$(this))">
                                        <p><?php echo FS_PRICE_LOW_HIGH;?></p>
                                    </div>
                                    <div data="priced" class="popularity_view_listz1_liMain <?php echo $pricedselected;?>" onclick="change_sort_order_by($(this).attr('data'),'two',$(this))">
                                        <p><?php echo FS_PRICE_HIGH_LOW;?></p>
                                    </div>
                                    <div data="rate" class="popularity_view_listz1_liMain <?php echo $rateselected;?>" onclick="change_sort_order_by($(this).attr('data'),'two',$(this))">
                                        <p><?php echo FS_RATE_HOGH;?></p>
                                    </div>
                                    <div data="new" class="popularity_view_listz1_liMain <?php echo $newselected;?>" onclick="change_sort_order_by($(this).attr('data'),'two',$(this))">
                                        <p><?php echo FS_NEWEST_FIRST;?></p>
                                    </div>
                                    <div data="popularity" class="popularity_view_listz1_liMain <?php if(isset($_GET["sort_order"]) && $_GET["sort_order"]!= "popularity"){ echo '';}else{echo 'choosez';}?>" onclick="change_sort_order_by($(this).attr('data'),'two',$(this))">
                                        <p><?php echo FS_POPULARITY;?></p>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="popularity_view_listz1 select_one <?php echo $video_array_page;?>">
                                <dt class="popularity_view_sortz1">
                                    <p><span class="popularity_view_sortTxt"><?php echo FS_SORT_BY;?></span><span class="popularity_view_sortPriceTxt"><?php echo $sort_by;?></span><span class="iconfont icon">&#xf087;</span></p>
                                </dt>
                                <dd class="popularity_view_listz1_li">
                                    <div data="price" class="popularity_view_listz1_liMain <?php echo $priceselected;?>" onclick="change_sort_order_by($(this).attr('data'),'one',$(this))">
                                        <p><?php echo FS_PRICE_LOW_HIGH;?></p>
                                    </div>
                                    <div data="priced" class="popularity_view_listz1_liMain <?php echo $pricedselected;?>" onclick="change_sort_order_by($(this).attr('data'),'one',$(this))">
                                        <p><?php echo FS_PRICE_HIGH_LOW;?></p>
                                    </div>
                                    <div data="rate" class="popularity_view_listz1_liMain <?php echo $rateselected;?>" onclick="change_sort_order_by($(this).attr('data'),'one',$(this))">
                                        <p><?php echo FS_RATE_HOGH;?></p>
                                    </div>
                                    <div data="new" class="popularity_view_listz1_liMain <?php echo $newselected;?>" onclick="change_sort_order_by($(this).attr('data'),'one',$(this))">
                                        <p><?php echo FS_NEWEST_FIRST;?></p>
                                    </div>
                                    <div data="popularity" class="popularity_view_listz1_liMain <?php if(isset($_GET["sort_order"]) && $_GET["sort_order"]!= "popularity"){ echo '';}else{echo 'choosez';}?>" onclick="change_sort_order_by($(this).attr('data'),'one',$(this))">
                                        <p><?php echo FS_POPULARITY;?></p>
                                    </div>
                                </dd>
                            </dl>
            </div>
            <div class="pro_newSee_allBox">
                <div class="new_proList_resultTxt">
                    <?php
                    if($_SESSION['languages_id'] == 4){
                        echo FS_PRODUCTS.$listing_split->number_of_rows;
                    }else{
                        if($listing_split->number_of_rows>1){
                            echo $listing_split->number_of_rows.' '.FS_PRODUCTS;
                        }else{
                            echo $listing_split->number_of_rows.' '.FS_PRODUCT;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="new_proList_reciveBox">
            <?php
            //        $cPath_id = 0;
            //        if($cPath_array){
            //            foreach ($cPath_array as $cc=>$cPath_val){
            //                if($cc>1){
            //                    $cPath_id++;
            //                    $cc= $cc-1;
            //                    echo '<div class="new_proList_reciveCont">
            //                      <p class="new_proList_reciveTxt">'.zen_get_categories_name($cPath_val).'</p>
            //                     <a href="'.zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_array[$cc]).'"><span class="iconfont icon">&#xf092;</span></a>
            //                     </div>';
            //                }
            //            }
            //        }
            $show_arr = $_GET;
            $show_arr = array_diff_key($show_arr,['main_page'=>'','number_of_uploads'=>'','narrow'=>'','cPath'=>'','sort_order'=>'','count'=>'','settab'=>'','get_qty'=>'','page'=>'','lang'=>'']);
            $scheme = $_SERVER['REQUEST_SCHEME']; //协议
            $domain = $_SERVER['HTTP_HOST']; //域名/主机
            $requestUri = $_SERVER['REQUEST_URI']; //请求参数
            $requestUri = urldecode($requestUri);	//筛选值中有特殊符号的需要解码

            //2020.11.2 by bob 分类页防止通过url进行xss注入
            $requestUri=categories_param_remove_xss($requestUri);

            $narrowUri = '';
            $narrowUri_id = 0;
            $narrowNum = count($narrow_arr);
            if(sizeof($narrow_arr)>0){
                foreach ($narrow_arr as $keyName=>$name) {
                    $narrowUri_id++;
                    $keyName = urldecode($keyName);
                    if($_GET['sort_order']){
                        $narrowUri =  str_replace('&'.$keyName.'='.$name,'',$requestUri);
                    }else{
                        if($narrowNum == 1){
                            $narrowUri =  str_replace('?'.$keyName.'='.$name,'',$requestUri);
                        }elseif ($narrowNum == $narrowUri_id) {
                            $narrowUri = str_replace('&' . $keyName . '=' . $name, '', $requestUri);
                        }else{
                            $narrowUri =  str_replace($keyName.'='.$name.'&','',$requestUri);
                        }
                    }
                    //2020.11.2 by bob 修改跳转方式
                    echo '<div class="new_proList_reciveCont">
                        <a data-narrow="'.$name.'" href="'.reset_url($narrowUri).'">
                          <p class="new_proList_reciveTxt">'.$products_narrow_by->get_option_values_name($name).'</p>
                         <span class="iconfont icon">&#xf092;</span>
                         </a>
                         </div>';
                }
                ?>
            <?php }?>
            <?php
            if($narrowUri_id!=0){
                echo '<span class="new_proList_reciveClebtn">
                        <a href="'.$cpath_url[0].'" class="new_proList_shipTime_link">'.FS_CLEAR_ALL.'</a>
                    </span>';
            }
            ?>
        </div>
        <!--    <div class="new_proList_shipTimeBox">-->
        <!--        -->
        <!--    </div>-->
    </div>
<?php }?>
<?php if($common_is_mobile){ //手机端侧边?>
    <div class="m-product-list-Screening-bg"></div>
    <div class="m-product-list-Screening">
        <div class="m-product-list-Screening-center">
            <div class="m-list-Screening-top">
                <h2 class="m-list-Screening-tit"><?php echo FS_FILTER;?> <i class="iconfont icon m-window-close">&#xf092;</i></h2>
            </div>
            <div class="m-list-Screening-center">
                <?php if (3 > $count_of_cPath_array){ ?>

                    <dl class="m-list-dl categories_by_show">
                        <?php
                        if (!$cPath_array[1]) {
                            echo ' <dt>' . zen_get_categories_name($cPath_array[1]) . '<i class="iconfont icon">&#xf087;</i></dt>';
                        }else {
                            echo ' <dt>' . BOX_HEADING_CATEGORIES . '<i class="iconfont icon">&#xf087;</i></dt>';
                        }
                        if (2 == sizeof($cPath_array)) {
                            echo '<div class="m-list-dd-div">';
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
                                    echo '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                                }
                            } else {
                                $categories = zen_get_subcategories_of_one_category($cPath_array[0],$where_clearing);
                                foreach ($categories as $i => $cID) {
                                    $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                                    if ($cID == (int)$cPath_array[1]) {
                                        echo '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf021;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                                    } else {
                                        echo '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                                    }
                                }

                            }
                            echo '</div>';
                        }
                        ?>
                    </dl>
                <?php }else{?>
                    <?php
                    if (zen_has_category_subcategories($cPath_array[1])) {
                        echo '<dl class="m-list-dl categories_by_show">
                                     <dt>'.BOX_HEADING_CATEGORIES.'<i class="iconfont icon">&#xf087;</i></dt>';
                        $categories_reset = zen_get_subcategories_of_one_category($cPath_array[1], $where_clearing);
                        $categories = $categories_reset;
                        $href2 = '';
                        echo '<div class="m-list-dd-div">';
                        foreach ($categories as $i => $cID) {
                            $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                            if ($current_category_id == $cID || $cPath_array[2] == $cID) {
                                echo '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf021;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            } else {
                                echo '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            }
                        }
                        echo '</div>';
                        echo '</dl>';
                    }
                    $showName = getShowName($cPath_array);
                    if (zen_has_category_subcategories($cPath_array[2])) {
                        echo ' <dl class="m-list-dl categories_by_show">
                                       <dt>' . $showName . '<i class="iconfont icon">&#xf087;</i></dt>';
                        $categories_reset = zen_get_subcategories_of_one_category($cPath_array[2], $where_clearing);
                        $first_categories = array_slice($categories_reset, 0, 7);
                        $categories = $categories_reset;
                        $href2 = '';
                        $category_narrow = '';
                        $fcDIV = false;
                        echo '<div class="m-list-dd-div">';
                        foreach ($categories as $i => $cID) {
                            $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                            if ($current_category_id == $cID) {
                                echo '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf021;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            } else {
                                echo '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            }
                        }
                        echo '</div>';
                        echo '</dl>';
                    }
                }
                ?>
                <?php
                if (!in_array($current_category_id, array(1, 3, 4, 9, 209, 573, 904, 911))) {
                    $c_pids = array();
                    if ($all_product) {
                        foreach ($all_product as $kk => $c_pro) {
                            $c_pids [] = $c_pro['id'];
                        }
                    }
                    if ($cPath_array[1] && !$cPath_array[2] && zen_has_category_subcategories($cPath_array[1])) {
                        if($cPath_array[1] == 1068 || $cPath_array[1] == 2961){
                            if(sizeof($c_pids)){
                                // echo $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,2);
                            }}
                    } else  {
                        if (sizeof($c_pids)) {
                            $key = md5($current_category_id.'_'.json_encode($c_pids).'_'.json_encode($get_narrow).'_'.$_SESSION['languages_code'].'_2');
                            $data = get_redis_key_value($key,"categories_option");
                            if($data){
                                echo $data;
                            }else{
                                $data = $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,2);
                                set_redis_key_value($key,$data,24*3600,"categories_option");
                                echo $data;
                            }
                        }
                    }
                }
                ?>
            </div>
            <div class="m-list-Screening-bottom">
                <a class="m-list-Screening-bottom-a m-list-Screening-bottom-clear" href="<?php echo $cpath_url[0];?>" onclick="spinloader()"><?php echo FS_CLEAR_ALL;?></a>
                <a class="m-list-Screening-bottom-a" id="m_submit_Done" href="javascript:;"><?php echo FS_DONE;?></a>
            </div>
        </div>
    </div>
<?php }?>