<?php
/*
 * 2018.11.7  fairy add 分类页面单独的控制
 * 以前分类页面没有单独的控制器
 */

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php')); //语言包
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . 'views/product_list.php'); // 调用公共的语言包
require_once(DIR_WS_CLASSES . 'fs_reviews.php');
$fs_reviews = new fs_reviews();
$action = $_GET['ajax_request_action'];
require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
$productRelatedAttributesModel = new productRelatedAttributesModel();
require_once DIR_WS_CLASSES . 'shipping_info.php';
if (!class_exists('products_narrow_by')) {
    require DIR_WS_CLASSES . 'products_narrow_by.php';
    $products_narrow_by = new products_narrow_by();
}
switch ($action) {
    case 'ajax_get_one_product_show':
        //检查，并整理提交的数据
        $products_id = trim($_POST['products_id']) ? (int)zen_db_prepare_input($_POST['products_id']) : '';
        if (!$products_id) {
            exit(json_encode(array('status' => 0, 'info' => FS_PRODUCT_ID_NOT_FILL_TIP, 'data' => '')));
        }
        $show_type = 'image';
        if (isset($_POST['show_type']) && in_array($_POST['show_type'], array('list', 'image'))) {
            $show_type = $_POST['show_type'];
        }
        $first_product = trim($_POST['first_product']) ? (int)zen_db_prepare_input($_POST['first_product']) : '';
        // 判断产品是否存在，或者下线
        $sql = 'SELECT count(*) FROM ' . TABLE_PRODUCTS . ' where products_status = 1 and (products_price>0 || '.$fsCurrentInquiryField.' =1) ';
        $count = $db->getAll($sql);
        if (!$count) {
            exit(json_encode(array('status' => 0, 'info' => FS_SYSTME_BUSY, 'data' => '')));
        }
        $count = $count[0];
        if (!$count) {
            exit(json_encode(array('status' => 0, 'info' => FS_PRODUCT_OFFLINE_TIP, 'data' => '')));
        }

        //获取产品的数据
        $categories = $db->getAll('select * from products_to_categories WHERE products_id='.$products_id);
        $current_categories = $categories[0]['categories_id'];
        $category_arr = (array_reverse(get_category_parent_id($current_categories,array())));
        if (isMobile()) {
            $keyPrefix = 'is_mobile_';
        } else {
            $keyPrefix = 'is_pc_';
        }
        define('PRODUCT_BASIC_LIST_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_basic_'.$keyPrefix.implode('_',$category_arr).'_'.$products_id.'_for_list:');
        $product_redis_key = md5($products_id.$_SESSION['currency'].$SESSION['countries_iso_code'],true);
        $product = get_redis_key_value($product_redis_key,PRODUCT_BASIC_LIST_REDIS_KEY_PREFIX);
        $product_show_str = '';
        if(!$product){
            $sql = 'SELECT P.products_id,P.integer_state,P.products_image,P.products_price,P.products_model,P.is_inquiry,P.is_min_order_qty,P.offline_sales_num,P.product_sales_total_num,PD.products_name,PD.products_common_name,P.new_products_tag,P.new_products_time,P.product_custom_tag
                FROM ' . TABLE_PRODUCTS . ' P
                left join ' . TABLE_PRODUCTS_DESCRIPTION . ' PD on PD.products_id = P.products_id and PD.language_id ="'.(int)$_SESSION['languages_id'].'"
                where P.products_id  = ' . $products_id . '
                limit 1';
            $product = $db->getAll($sql);
            $product = $product[0];
            $product_show_str .= '<!-- product not cache '.PRODUCT_BASIC_LIST_REDIS_KEY_PREFIX.'-->';
            $product = get_product_list_other_data($product,'list',$category_arr);
            //关联组的第一个产品ID 组合在数组中
            $product['first_product_id'] = $first_product;
            set_redis_key_value($product_redis_key,$product,24*3600,PRODUCT_BASIC_LIST_REDIS_KEY_PREFIX);
        }else{
            //实时获取产品的线下销量数据
            $sale_data = fs_get_data_from_db_fields_array(['offline_sales_num','product_sales_total_num'],'products','products_id='.$products_id,'limit 1');
            $product['offline_sales_num'] = $sale_data[0][0];
            $product['product_sales_total_num'] = $sale_data[0][1];
        }

        // 展示数据
        $is_common_title = trim($_POST['is_common_title']) ? (int)zen_db_prepare_input($_POST['is_common_title']) : false;
        $product_show_str .= get_product_list_show_str($product,$show_type,true,true,$is_common_title,true,'list');

        // 返回
        if($product['category_arr'][0] == 9 && $product['category_arr'][1] != 2757){ //属性后面有compatible
            $is_module_products = true;
        }else{
            $is_module_products = false;
        }
        exit(json_encode(array('status' => 1, 'info' => '', 'data' => array('data'=>$product_show_str,'is_module_products'=>$is_module_products, 'languages_code' => $_SESSION['languages_code']))));
        break;

    case 'ajax_get_one_product_qv_show':
        //检查，并整理提交的数据
        $products_id = trim($_POST['products_id'])?(int)zen_db_prepare_input($_POST['products_id']):'';
        if(!$products_id){
            exit(json_encode(array('status' => 0, 'info' => FS_PRODUCT_ID_NOT_FILL_TIP, 'data' => '')));
        }

        // 判断产品是否存在，或者下线
        $sql = 'SELECT count(*) FROM '. TABLE_PRODUCTS .' where products_status = 1 and (products_price>0 || '.$fsCurrentInquiryField.' =1) ';
        $count = $db->getAll($sql);
        if(!$count){
            exit(json_encode(array('status' => 0, 'info' => FS_SYSTME_BUSY, 'data' => '')));
        }
        $count = $count[0];
        if(!$count){
            exit(json_encode(array('status' => 0, 'info' => FS_PRODUCT_OFFLINE_TIP, 'data' => '')));
        }

        $product_show_str = '';
        //获取产品的数据
        $categories = $db->getAll('select * from products_to_categories WHERE products_id='.$products_id);
        $current_categories = $categories[0]['categories_id'];
        $category_arr = (array_reverse(get_category_parent_id($current_categories,array())));
        if (isMobile()) {
            define('PRODUCT_BASIC_QV_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_basic_'.implode('_',$category_arr).'_'.$products_id.'_for_qv_mobile:');
        } else {
            define('PRODUCT_BASIC_QV_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_product_basic_'.implode('_',$category_arr).'_'.$products_id.'_for_qv:');
        }
        $product_redis_key = md5($products_id.$_SESSION['currency'].$SESSION['countries_iso_code'],true);
        $product = get_redis_key_value($product_redis_key,PRODUCT_BASIC_QV_REDIS_KEY_PREFIX);
        if(!$product){
            $sql = 'SELECT P.products_id,P.integer_state,P.products_image,P.products_price,P.products_model,P.'.$fsCurrentInquiryField.' is_inquiry,P.is_min_order_qty,P.discount,P.packing_quantity,P.products_price,P.discount_type,P.discount,PD.packing_unit,PD.products_name,PD.module1,PD.product_details,PD.module_status,PC.composite_products,P.product_custom_tag 
                FROM '.TABLE_PRODUCTS.' P 
                left join '.TABLE_PRODUCTS_DESCRIPTION.' PD on PD.products_id = P.products_id and PD.language_id ="'.(int)$_SESSION['languages_id'].'" 
                LEFT JOIN products_composite PC ON (P.products_id=PC.products_id) 
                where P.products_id  = '.$products_id.'
                limit 1';
            $product = $db->getAll($sql);
            $product = $product[0];

            //这个主要是为了公共标题，公共产品描述，而使用。现在暂时不要了
            $product['first_product_id'] = trim($_POST['first_product_id'])?(int)zen_db_prepare_input($_POST['first_product_id']):0;
            if($product['first_product_id']){
                $sql = 'SELECT PD.products_qv_info
                FROM  '.TABLE_PRODUCTS_DESCRIPTION.' PD
                where PD.products_id  = '.$product['first_product_id'].' limit 1';
                $first_product_description = $db->getAll($sql);
                $first_product_description = $first_product_description[0];
                $product['products_qv_info'] = $first_product_description['products_qv_info'];
            }

            $product_show_str .= '<!-- product not cache -->';
            $product = get_product_list_other_data($product,'qv',$category_arr);
            set_redis_key_value($product_redis_key,$product,24*3600,PRODUCT_BASIC_QV_REDIS_KEY_PREFIX);
        }

        // 展示数据
        $product['attribute_parent_id'] = trim($_POST['attribute_parent_id'])?(int)zen_db_prepare_input($_POST['attribute_parent_id']):0;
        $product_show_str .= get_product_qv_show_str($product);

        // 返回
        exit(json_encode(array('status' => 1, 'info' => '', 'data' =>$product_show_str)));
    case 'ajax_get_product_list_left_show':
        //ajax app
        $get_narrow_arr = [];
        if($_POST['type'] == 1){
            $current_category_id = $_POST['cPath'];
            $cPath_array = (array_reverse(get_category_parent_id($current_category_id,array())));
            $count_of_cPath_array = sizeof($cPath_array);
            $narrow_str = '';
            if (3 > $count_of_cPath_array){
                $narrow_str .= '<dl class="m-list-dl categories_by_show">';
                if (!$cPath_array[1]) {
                    $narrow_str .= '<dt>' . zen_get_categories_name($cPath_array[1]) . '<i class="iconfont icon">&#xf087;</i></dt>';
                }else {
                    $narrow_str .= '<dt>' . BOX_HEADING_CATEGORIES . '<i class="iconfont icon">&#xf087;</i></dt>';
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
                            if ($current_category_id == $cID || $cPath_array[2] == $cID) {
                                $narrow_str .= '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            }else{
                                $narrow_str .= '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1" narrow_id ="2">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            }
                        }
                        if ($cDIV) {
                            // echo '</div>';
                            // echo '<div id="pulldown_category" class="sidebar_more"><a id="pulldownC" href="javascript:void(0);">'.FS_SHOW_MORE.'</a> </div>';
                        }

                    } else {
                        $categories = zen_get_subcategories_of_one_category($cPath_array[0],$where_clearing);
                        foreach ($categories as $i => $cID) {
                            $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                            if ($cID == (int)$cPath_array[1]) {
                                $narrow_str .= '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cPath_array[1]) . '</div>
                                                       </dd>';
                            } else {
                                $narrow_str .= '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                            }
                        }

                    }
                }
                $narrow_str .= '</dl>';
            }else{
                if (zen_has_category_subcategories($cPath_array[1])) {
                    $narrow_str .= '<dl class="m-list-dl categories_by_show">';
                    $narrow_str .= '<dt>' . BOX_HEADING_CATEGORIES . '<i class="iconfont icon">&#xf087;</i></dt>';
                    $categories_reset = zen_get_subcategories_of_one_category($cPath_array[1], $where_clearing);
                    $categories = $categories_reset;
                    $href2 = '';
                    foreach ($categories as $i => $cID) {
                        $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                        if ($current_category_id == $cID || $cPath_array[2] == $cID) {
                            $narrow_str .= '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                        } else {
                            $narrow_str .= '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                        }
                    }
                    $narrow_str .= '</dl>';
                }
                if (zen_has_category_subcategories($cPath_array[2])) {
                    $showName = getShowName($cPath_array);
                    $narrow_str .= '<dl class="m-list-dl categories_by_show">';
                    $narrow_str .= '<dt>' . $showName . '<i class="iconfont icon">&#xf087;</i></dt>';
                    $categories_reset = zen_get_subcategories_of_one_category($cPath_array[2], $where_clearing);
                    $first_categories = array_slice($categories_reset, 0, 7);
                    $categories = $categories_reset;
                    $href2 = '';
                    $category_narrow = '';
                    $fcDIV = false;
                    foreach ($categories as $i => $cID) {
                        $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                        if ($current_category_id == $cID) {
                            $narrow_str .= '<dd class="m_product_list_dd active" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had2">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                        } else {
                            $narrow_str .= '<dd class="m_product_list_dd" id="li_'.$cID.'" onclick="set_narrow(this,'.$cID.',event)">
                                                        <span class="m-Screening-radio iconfont icon">&#xf022;</span>
                                                        <div data="' . $cID . '" data-link="'.$href2.'" samedata = "Had1">' . zen_get_categories_name($cID) . '</div>
                                                       </dd>';
                        }
                    }
                    $narrow_str .= '</dl>';
                }

            }
        }elseif($_POST['type'] == 2){
            $categorie_arr = $_POST['categorie_arr'];
            $get_narrow_arr = $_POST['get_narrow'];
            if(sizeof($categorie_arr)>1){
                $current_category_id = end($categorie_arr);
            }else{
                $current_category_id = $categorie_arr[0];
            }
        }
        $cPath_array = (array_reverse(get_category_parent_id($current_category_id,array())));
        // 获取勾选的筛选项数组、网址等
        $get_narrow = array();$products_narrow_by_option_values_ids = array();$narrow_url='';
        if(sizeof($get_narrow_arr)){
            foreach($get_narrow_arr as $getvalue){
                if($getvalue && is_numeric($getvalue)){
                    $get_narrow [] = $getvalue;
                    $narrow_url .='&narrow[]='.$getvalue;
                }
            }
        }
        $products_narrow_by_option_values_ids = $get_narrow;
        // 获取筛选项的sql 条件
        $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
        $from_narrow_by='';
        if (zen_not_null($products_narrow_by_option_values_ids)){
            if (1 == $narrow_by_count) {
                $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp using(products_id)";
                $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
            }else {
                $from_narrow_by='';
                $where_narrow_by = ' select t0.products_id from ';
                $sql_query_array = array();
                for($i = 0; $i< $narrow_by_count;$i++){
                    $sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
                    where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
                                  ) as t".$i ." ";
                }
                for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
                    if($i){
                        $where_narrow_by .=' CROSS JOIN';
                    }
                    $where_narrow_by .= $sql_query_array[$i];
                    if($i){
                        $where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
                    }
                }
                $and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
            }
        }

        // 分组，排序
        $sql_order_by = ' group by p.products_id  ORDER BY p.products_sort_order asc ';
        if(isset($_GET['sort_order']) && $_GET['sort_order'])
        {
            switch ($_GET['sort_order']){
                case 'priced':
                    $sql_order_by = " group by p.products_id order by p.products_price desc ";
                    break;
                case 'price':
                    $sql_order_by = " group by p.products_id order by p.products_price ";
                    break;
                case 'rate':
                    $sql_order_by = " group by p.products_id order by rating desc ";
                    break;
                case 'new':
                    $sql_order_by = " group by p.products_id order by p.products_date_added desc ";
                    break;
                case 'popularity':
                default:
                    $sql_order_by = " group by p.products_id order by p.products_sort_order asc  ";
                    break;
            }
        }

        // 分类的where条件
        if (zen_has_category_subcategories($current_category_id)) {
            $all_subcategories_ids = array();
            $where_clearing = ' and is_clearing = 0 ';
            zen_get_subcategories_redis($all_subcategories_ids,$current_category_id,$where_clearing);
            $all_subcategories_ids[] = $current_category_id;
            $all_subcategories_ids = array_unique($all_subcategories_ids);
            $count_of_subcategories = sizeof($all_subcategories_ids);
            if ($count_of_subcategories){
                if (1 < $count_of_subcategories) {
                    $category_where_sql = " and ptc.categories_id in(".join(',',$all_subcategories_ids).")";
                }else if (1 == $count_of_subcategories) {
                    $category_where_sql = " and ptc.categories_id = ".$all_subcategories_ids[0];
                }
            }else {
                $category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
            }
        }else {
            $category_where_sql = " and ptc.categories_id = ".(int)$current_category_id;
        }

        // 查询的字段
        $query_select_colums = " select p.products_id,p.integer_state,p.products_image,p.products_price ,p.products_model, {$fsCurrentInquiryField} is_inquiry, is_min_order_qty";

        // 基本sql
        $query_from = " from ". TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";

        //p.is_categories_show 该字段限制该产品是否展示在该分类列表页面，为1展示，为0不展示

        if(count($cPath_array)==4){
            //四级分类隐藏的也展示
            //原因：三级分类会展示4级分类的筛选，产品部门要求全部展示4级分类的筛选。如果不去掉隐藏id的话，会出现很多空链接
            $show_hide_where = '';
        }else{
            $show_hide_where = ' AND p.is_categories_show=1 ';
        }
        $query_where = " WHERE p.products_status = 1 and (p.products_price >0 || {$fsCurrentInquiryField} =1) ".$show_hide_where.$warehouse_where.$category_where_sql;


        // 根据评价排序
        if($_GET['sort_order'] == 'rate'){
            $query_select_colums .= ",count(rd.reviews_id) as rating ";
            $query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =".(int)$_SESSION['languages_id'].") ";
        }

        $listing_sql = $query_select_colums . $query_from . $from_narrow_by .$query_where . $and_narrow_by. $sql_order_by;

        //前台筛选条件
        $count = 24;
        if (isset($_GET['count']) && intval($_GET['count'])) $count = intval($_GET['count']);
        if(strstr($_SERVER['HTTP_REFERER'],"#matrix")){
            $settab = 'three';
        }else{
            if (isset($_GET['settab']) && $_GET['settab']){ $settab = $_GET['settab']; }else{ $settab = 'two'; }
        }

        $listing_split = new splitPageResults($listing_sql, $count, 'products_id', 'page');


        // redis 缓存
        $listing_sql_md5 = md5($listing_split->sql_query.$_SESSION['currency'].$SESSION['countries_iso_code'].$count,true);
        $products = get_redis_key_value($listing_sql_md5,CATEGORY_REDIS_KEY_PREFIX);

        if ($listing_split->number_of_rows < 1)$no_products = true;
        else{
            if(!$products){
                /*not product list cache*/
                $products = $db->getAll($listing_split->sql_query);
                if ($products){
                    foreach ($products as $key => $val){
                        $products[$key] = get_product_list_other_data($val);
                    }
                    set_redis_key_value($listing_sql_md5,$products,24*3600,CATEGORY_REDIS_KEY_PREFIX);
                }
            }
            //分页的跳转链接
            $params_for_categories_split = zen_get_all_get_params(array('page','count','settab'));
            if (isset($current_category_id))
                $params_for_categories_split = zen_get_all_get_params(array('page','cPath','count','settab')).'&cPath='.$current_category_id;

            if(!(isset($_GET['sort_order']) && $_GET['sort_order'])){
                $params_for_categories_split .= '&sort_order=popularity';
            }
            $params_for_categories_split .= $narrow_url;

            $params_for_categories_split .= '&count='.$count.'&settab='.$settab;

            $page_links = $listing_split->display_links_listing_new(1,$params_for_categories_split);
            $page_top_links = $page_links ;

            $page_jump_links = zen_href_link($_GET['main_page'],$params_for_categories_split)  ;

            // 获取所有产品id
            /* update by melo */
            $all_listing_sql = "select products_id " . $query_from .$from_narrow_by .$query_where .$and_narrow_by;
            $listing_sql_key = md5($all_listing_sql.$_SESSION['currency'].$SESSION['countries_iso_code'].$count,true);
            $products_data_key = get_redis_key_value($listing_sql_key,CATEGORY_ALL_REDIS_KEY_PREFIX);
            if($products_data_key){
                $all_products_data = $products_data_key;
            }else{
                $all_products_data = $db->Execute($all_listing_sql);
            }

            if(!$products_data_key){
                $all_product = array();
                if ($all_products_data->RecordCount()){
                    while (!$all_products_data->EOF){
                        $all_product [] = array(
                            'id'  => $all_products_data->fields['products_id'],
                        );
                        $all_products_data->MoveNext();
                    }
                    set_redis_key_value($listing_sql_key,$all_product,24*3600,CATEGORY_ALL_REDIS_KEY_PREFIX);
                }
            }else{
                $all_product = $all_products_data;
            }
            /* eof */
        }
        $narrow_right_str = '';
        if($current_category_id){
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
                            $narrow_right_str = $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,2);
                        }
                    }
                } else  {
                    if (sizeof($c_pids)) {
                        $narrow_right_str = $products_narrow_by->fs_products_header_new_list($current_category_id, $c_pids, $get_narrow,2);
                    }
                }
            }
        }
        $narrow_all_str = $narrow_str.$narrow_right_str;
        exit(json_encode(array('status' => 0, 'info' => '', 'data' => array($current_category_id,$narrow_all_str))));
        break;

}
exit();
