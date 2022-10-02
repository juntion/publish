<?php
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// 类
require_once DIR_WS_CLASSES.'shipping_info.php';

//常量
if (isMobile()){
    define('CATEGORY_M_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_m_category_'.trim($_GET['cPath']).':');
    define('CATEGORY_M_ALL_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_m_category_'.trim($_GET['cPath']).'_all:');
}else{
    define('CATEGORY_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_category_'.trim($_GET['cPath']).':');
    define('CATEGORY_ALL_REDIS_KEY_PREFIX',$_SESSION['languages_code'].'_category_'.trim($_GET['cPath']).'_all:');
}


//获取当前国家对应的发货仓库
$warehouse_data = fs_products_warehouse_where();
$warehouse_where = $warehouse_data['where'];
$warehouse_code = $warehouse_data['code'];

// 获取勾选的筛选项数组、网址等
$get_narrow = array();$products_narrow_by_option_values_ids = array();$narrow_url='';
$unarrowGET = array('_requestConfirmationToken','cPath','main_page','page','sort','type','count','settab');
$check_narrow = array_merge($unarrowGET, ['lang', 'sort_order']);
$is_list_narrow = false;
foreach($_GET as $getname=>$getvalue){
    if(!in_array($getname,$unarrowGET)){
        if($getvalue && is_numeric($getvalue)){
            $get_narrow [] = $getvalue;
            $narrow_url .='&narrow[]='.$getvalue;
            $narrow_arr [$getname] = $getvalue;
        }
    }
    if(!in_array($getname,$check_narrow)){
        $is_list_narrow = true;
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
//$sql_order_by = ' group by p.products_id  ORDER BY p.products_sort_order asc ';
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
            break;
        default:
            $sql_order_by = " group by p.products_id order by p.products_sort_order asc  ";
            break;
    }
}

// 分类的where条件
if (zen_has_category_subcategories($current_category_id)) {
    $all_subcategories_ids = array();
    $where_clearing = ' and is_clearing = 0 ';
    //查找当前分类下的所有子分类调用redis缓存函数
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
$query_select_colums = " select p.product_sales_total_num,p.products_id,p.integer_state,p.products_image,p.products_price ,p.products_model,p.".$fsCurrentInquiryField." as is_inquiry, is_min_order_qty, new_products_tag, new_products_time,p.offline_sales_num,ptc.categories_id,p.is_heavy, pcl.products_clearance_price, pcom.composite_products,p.product_custom_tag ";

// 基本sql
$query_from = " from ". TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";
$query_from .= " left join products_clearance AS pcl using(products_id)";
$query_from .= " left join products_composite AS pcom using(products_id) ";

//p.is_categories_show 该字段限制该产品是否展示在该分类列表页面，为1展示，为0不展示
$cPath_array = (array_reverse(get_category_parent_id($current_category_id,array())));
if(count($cPath_array)==4){
    //四级分类隐藏的也展示
    //原因：三级分类会展示4级分类的筛选，产品部门要求全部展示4级分类的筛选。如果不去掉隐藏id的话，会出现很多空链接
    $show_hide_where = '';
}else{
    /*产品在对应分类下隐藏,当一个产品属于两个分类时要求一个分类下展示，另一个隐藏，所以在products_to_categories表中新增了is_show字段，之前的products表中的is_categories_show字段弃用*/
    $show_hide_where = ' AND ptc.is_show=1 ';
}
$query_where = " WHERE p.is_important!=10 and p.products_status = 1 and (p.products_price >0 || {$fsCurrentInquiryField} =1) ".$show_hide_where.$warehouse_where.$category_where_sql;


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

$waterfall_arr = getListWaterfallData($current_category_id);
$waterfall_data = $waterfall_arr['waterfall_data'];
ksort($waterfall_data);
$w_limit = $waterfall_arr['limit_data'];

$listing_split = new splitPageResults($listing_sql, $count, 'products_id', 'page','','',$w_limit);

// redis 缓存
$listing_sql_md5 = md5($listing_split->sql_query.$_SESSION['currency'].$SESSION['countries_iso_code'].$count,true);
if (isMobile()) {
    $products = get_redis_key_value($listing_sql_md5, CATEGORY_M_REDIS_KEY_PREFIX);
}else{
    $products = get_redis_key_value($listing_sql_md5, CATEGORY_REDIS_KEY_PREFIX);
}
if ($listing_split->number_of_rows < 1)$no_products = true;
else{
    require_once(DIR_WS_CLASSES . 'fs_reviews.php');
    $fs_reviews = new fs_reviews();
    require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
    $productRelatedAttributesModel = new productRelatedAttributesModel();
    require_once DIR_WS_CLASSES . 'shipping_info.php';

    // 获取所有产品id
    /* update by melo */
    $all_listing_sql = "select products_id " . $query_from .$from_narrow_by .$query_where .$and_narrow_by;

    $listing_sql_key = md5($all_listing_sql.$_SESSION['currency'].$SESSION['countries_iso_code'].$count,true);
    if (isMobile()) {
        $products_data_key = get_redis_key_value($listing_sql_key,CATEGORY_M_ALL_REDIS_KEY_PREFIX);
    }else{
        $products_data_key = get_redis_key_value($listing_sql_key,CATEGORY_ALL_REDIS_KEY_PREFIX);
    }
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
            if (isMobile()) {
                set_redis_key_value($listing_sql_key,$all_product,24*3600,CATEGORY_M_ALL_REDIS_KEY_PREFIX);
            }else{
                set_redis_key_value($listing_sql_key,$all_product,24*3600,CATEGORY_ALL_REDIS_KEY_PREFIX);
            }
        }
    }else{
        $all_product = $all_products_data;
    }
    /* eof */

    /***** 获取产品的销量数据 start 2020.11.27 ery *****/
    /***** 调整销量请注意 列表页和详情页需保持一致，列表页不能直接用缓存数据 还有列表页切换不同属性展示不同产品信息的地方也需要处理 *****/
    //define('CATEGORIES_PRODUCTS_SALES_PREFIX', 'products_total_sale_cPath_');
    //$all_sale_products = $salesData = $productsSaleData = [];
    //$salesDataResult = get_redis_key_value($cPath_array[1], CATEGORIES_PRODUCTS_SALES_PREFIX);
    //if(!$salesDataResult){
    //    $all_sale_products = array_column($all_product, 'id');
    //}else{
    //    $salesData = $salesDataResult;
    //    $products_key = array_keys($salesData);
    //    foreach($all_product as $aKey=>$aValue){
    //        if(!in_array($aValue['id'],$products_key)){
    //            $all_sale_products[] = $aValue['id'];
    //        }
    //    }
    //}
    //if(!empty($all_sale_products)){
    //    $saleService = new App\Services\Products\ProductsSalesStatisticsService();
    //    $saleService->products_id_arr = $all_sale_products;
    //    $saleService->getStatisticTotalSales($salesData);
    //    set_redis_key_value($cPath_array[1],$salesData,2*3600,CATEGORIES_PRODUCTS_SALES_PREFIX);
    //}

    /***** 获取产品的销量数据 end 2020.11.27 ery *****/
    if(!$products){
        echo '<!-- not product list cache -->';
        $products = $db->getAll($listing_split->sql_query);
        if ($products){
            foreach ($products as $key => $val){
                $products[$key] = get_product_list_other_data($val);
            }
            if (isMobile()) {
                set_redis_key_value($listing_sql_md5,$products,24*3600,CATEGORY_M_REDIS_KEY_PREFIX);
            }else{
                set_redis_key_value($listing_sql_md5,$products,24*3600,CATEGORY_REDIS_KEY_PREFIX);
            }
        }
    }else{
        //实时获取产品的线下销量 和详情页保持一致 线下销量没有缓存
        $products_key = array_column($all_product,'id');
        if(count($products_key)){
            $offline_sale = $product_sales_total = [];
            $offline_sale_query = $db->Execute("SELECT products_id,offline_sales_num,product_sales_total_num FROM products WHERE products_id IN (".join($products_key,',').")");
            while(!$offline_sale_query->EOF){
                $offline_sale[$offline_sale_query->fields['products_id']] = $offline_sale_query->fields['offline_sales_num'];
                $product_sales_total[$offline_sale_query->fields['products_id']] = $offline_sale_query->fields['product_sales_total_num'];
                $offline_sale_query->MoveNext();
            }
            foreach($products  as $kk=>$val){
                $products[$kk]['offline_sales_num'] = $offline_sale[$val['products_id']];
                $products[$kk]['product_sales_total_num'] = $product_sales_total[$val['products_id']];
            }
        }
    }

    //分页的跳转链接
    $params_for_categories_split = zen_get_all_get_params(array('page','count','settab'));
    if (isset($current_category_id))
        $params_for_categories_split = zen_get_all_get_params(array('page','cPath','count','settab')).'&cPath='.$current_category_id;

    if(!(isset($_GET['sort_order']) && $_GET['sort_order'])){
        $params_for_categories_split .= '&sort_order=popularity';
    }
    //筛选列表产品有无库存 暂时不调取了
    if(!(isset($_GET['get_qty']) && $_GET['get_qty'])){
        $get_qty = 1;
    }else{
        $get_qty = $_GET['get_qty'];
        $getUri = '?get_qty='.$_GET['get_qty'];
    }
    $params_for_categories_split .= $narrow_url;

    $params_for_categories_split .= '&count='.$count.'&settab='.$settab;

    $page_links = $listing_split->display_links_listing_new(1,$params_for_categories_split);
    $page_top_links = $page_links ;

    $page_jump_links = zen_href_link($_GET['main_page'],$params_for_categories_split)  ;



    if($_GET['type']){
        zen_redirect(zen_href_link('index','cPath='.$current_category_id));
    }
}
//var_dump($products);
