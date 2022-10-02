<?php
header("Access-Control-Allow-Origin:*");
$debug = false;
require 'includes/application_top.php';
if (!class_exists('fiberstore_category')) {
    require DIR_WS_CLASSES . 'fiberstore_category.php';
}
function fs_product_reviews_level_show_create($reviews_score, $reviews_width, $reviews_sums)
{
    $html = array();
    if ($reviews_score < 1.0 && $reviews_score > 0) {
        $html[] = $reviews_width;
    }
    if ($reviews_sums > 0) {
        $html[] = "100";
    }
    if ($reviews_score < 2.0 && $reviews_score >= 1.0) {
        $html[] = $reviews_width;
    }
    if ($reviews_sums > 1) {
        $html[] = "100";
    }
    if ($reviews_score < 3.0 && $reviews_score >= 2.0) {
        $html[] = $reviews_width . "%";
    }
    if ($reviews_sums > 2) {
        $html[] = "100";
    }

    if ($reviews_score < 4.0 && $reviews_score >= 3.0) {
        $html[] = $reviews_width . "%";
    }
    if ($reviews_sums > 3) {
        $html[] = "100";
    }

    if ($reviews_score > 4.0) {
        $html[] = $reviews_width;
    }
    return $html;
}

$wholesaleproducts = fs_get_wholesale_products_array();
$current_category_id = $_GET['c_id'];
if ($_GET['type'] == 'banner') {
    $colums = array('pc_path', 'mobile_path', 'alt', 'url', 'banner_content', 'bgcolor');
    $arr = array();
    $banner = fs_get_data_from_db_fields_array($colums, 'fs_banner_manage_new', 'groups=4 and language_id=' . $_SESSION['languages_id'] . ' and category_id=' . $current_category_id, 'order by sort');
    foreach ($banner as $k => $v) {
        if ($v[0] == '') {
            unset($banner[$k]);
        }
        $arr[$k]["img"] = $v[1];
        $arr[$k]["link"] = $v[3];
    }
    echo json_encode(array("items" => $arr));
}
//获取三级分类入口展示
if ($_GET["type"] == "product1") {
    $arr = array();
    $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
    $str = stripcslashes(zen_get_categories_left_div_set($current_category_id));
    preg_match_all('/<div class="n17categories_hot">(.*)<\/div>/isU', $str, $box);
    preg_match_all('/<div class="n17categories_title">(.*)<\/div>/isU', $str, $title);
    $title = $title[1];
    $box = $box[1];
    foreach ($box as $kk => $vv) {
        preg_match_all('/<a href=\"(.*?)\".*?>(.*?)<\/a>/is', $vv, $text);
        preg_match_all('/<span.*>(.*)<\/span>/isU', $vv, $span);
        preg_match_all($preg, $vv, $matches);
        $span = $span[1];
        $img = $matches[1];
        $href = $text[1];
        $arr[$kk]['title'] = $title[$kk];
        foreach ($href as $k => $v) {
            $arr[$kk]['item'][$k]['link'] = $v;
        }
        foreach ($img as $k => $v) {
            $arr[$kk]['item'][$k]['img'] = $v;
        }
        foreach ($span as $k => $v) {
            $arr[$kk]['item'][$k]['span'] = $v;
        }
    }

    echo json_encode(array("items" => $arr));
}
//获取分类关键词
if ($_GET['type'] == 'keywords') {
    $keyword_columns = array('menu_title', 'menu_link');
    $keyword_where = 'languages_id=' . (int)$_SESSION['languages_id'] . ' and type=2 and categories_id=' . (int)$current_category_id;
    $keyword_data = fs_get_data_from_db_fields_array($keyword_columns, 'categories_index_menu', $keyword_where, 'order by sort');
    $arr = array();
    $host = "https://www.fs.com";
    $host2 = "http://www.fs.com";
    foreach ($keyword_data as $k => $v) {
        $arr[$k]['link'] = str_replace($host, "", $v[1]);
        $arr[$k]['link'] = str_replace($host2, "", $arr[$k]['link']);
        $arr[$k]['name'] = $v[0];
    }
    echo json_encode(array("items" => $arr));
}
if ($_GET['type'] == 'hot') {
    $products_columns = array('products_id', 'hot_pname');
    $num = $_GET['num'];
    $products_where = 'type=2 and language_id=' . $_SESSION['languages_id'] . ' and category_id=' . $current_category_id;
    $products_data = fs_get_data_from_db_fields_array($products_columns, 'hot_products', $products_where, 'order by sort limit ' . $num * ($num - 1) . ',2');
    $arr = array();
    if ($products_data) {
        foreach ($products_data as $k => $p) {
            if ($p[0]) {
                $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $p[0], 'NONSSL');
                $wp_image = zen_get_products_image_of_products_id($p[0]);
                $image_src = file_exists(DIR_WS_IMAGES . $wp_image) ? DIR_WS_IMAGES . $wp_image : DIR_WS_IMAGES . 'no_picture.gif';
                $image = zen_image($image_src, zen_get_products_name($p[0]), 150, 150, 'title="' . $wp_image . '"');
                $wp_price = zen_get_products_price($p[0]);
                $new_product_name = mb_substr($p[1], 0, 70, 'utf-8');
                if (!in_array($p[0], $wholesaleproducts)) {
                    $currency = $currencies->new_format(get_customers_products_level_final_price($wp_price));
                } else {
                    $currency = $currencies->format(get_customers_products_level_final_price($wp_price));
                }
                $arr[$k]['link'] = $href_link;
                $arr[$k]['img'] = $image_src;
                $arr[$k]['name'] = $new_product_name;
                $arr[$k]['price'] = $currency;
                $arr[$k]['instock'] = zen_get_products_instock_total_qty_of_products_id($p[0]);
            }

        }
    }
    if (isset($arr)) {
        echo json_encode(array("items" => $arr));
    }
}
if ($_GET['type'] == 'commend') {
    $special_columns = array('pc_path', 'alt', 'url', 'banner_content');
    $special_where = 'groups=6 and language_id=' . (int)$_SESSION['languages_id'] . ' and category_id=' . $current_category_id;
    $special_data = fs_get_data_from_db_fields_array($special_columns, 'fs_banner_manage_new', $special_where, 'order by sort');
    $arr = array();
    foreach ($special_data as $k => $v) {
        $arr[$k]['link'] = $v[2];
        $arr[$k]['img'] = $v[0];
        $arr[$k]['text'] = $v[3];
        $arr[$k]['alt'] = $v[1];
    }
    echo json_encode(array("items" => $arr));
}


//获取三级分类大入口展示
if ($_GET['type'] == 'project') {
    $categories_right_div = stripcslashes(zen_get_categories_right_div_set($current_category_id));
    preg_match_all('/<div class="n17categories_title">(.*)<\/div>/isU', $categories_right_div, $title);
    preg_match_all('/<div class="n17categories_title_sub">(.*)<\/div>/isU', $categories_right_div, $sub);
    preg_match_all('/<div class="classified_four_pic"><\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*><\/div>/isU', $categories_right_div, $title_img);
    preg_match_all('/<div class="classified_four_list(.*)">(.*)<\/div>/isU', $categories_right_div, $li);
    $arr = array();
    $title = $title[1];
    $sub = $sub[1];
    $title_img = $title_img[2][0];
    $html = $li[2];
    $html = implode("", $html);
    preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/', $html, $list_img);
    $list_img = $list_img[2];
    preg_match_all('/<a href=\"(.*?)\".*?>(.*?)<\/a>/is', $html, $list_link);
    $list_link = $list_link[1];
    preg_match_all('/<h2>(.*)<\/h2>/isU', $html, $h2);
    $h2 = $h2[1];
    preg_match_all('/<\/h2>\s*<p>(.*)<\/p>/isU', $html, $p);
    $p = $p[1];

    foreach ($list_link as $k => $v) {
        $arr[$k]['link'] = $v;
    }
    foreach ($list_img as $k => $v) {
        $arr[$k]['img'] = $v;
    }
    foreach ($h2 as $k => $v) {
        $arr[$k]['h2'] = $v;
    }
    foreach ($p as $k => $v) {
        $arr[$k]['p'] = $v;
    }
    echo json_encode(array("items" => $arr));
}
if ($_GET['type'] == "project_title") {
    $categories_right_div = stripcslashes(zen_get_categories_right_div_set($current_category_id));
    preg_match_all('/<div class="n17categories_title">(.*)<\/div>/isU', $categories_right_div, $title);
    preg_match_all('/<div class="n17categories_title_sub">(.*)<\/div>/isU', $categories_right_div, $sub);
    preg_match('/<img.*?src=[\"|\']?(.*?)[\"|\'](\.*)?\s.*?>(.*)/', $categories_right_div, $title_img);
    $arr = array();
    $title = $title[1];
    $sub = $sub[1];
    $title_img = $title_img[1];
    $arr[0]['title'] = $title;
    $arr[0]['sub'] = $sub;
    $arr[0]['title_img'] = str_replace("\"", "", $title_img);
    echo json_encode(array("items" => $arr));
}


//获取分类产品

if ($_GET['type'] == "status") {
    if ($_GET['c_id'] === 1) {
        echo json_encode(array("msg" => "没有数据"));
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
//get narrow by values id
    $get_narrow = array();
    $products_narrow_by_option_values_ids = array();
    $unarrowGET = array('_requestConfirmationToken', 'cPath', 'main_page', 'page', 'sort', 'type', 'count', 'settab', 'c_id', 'type');
    foreach ($_GET as $getname => $getvalue) {
        if (!in_array($getname, $unarrowGET)) {
            if ($getvalue && is_numeric($getvalue)) {
                $get_narrow [] = $getvalue;
                $narrow_url .= '&narrow[]=' . $getvalue;
            }
        }
    }
    $products_narrow_by_option_values_ids = $get_narrow;

    $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
    $from_narrow_by = '';
    if (zen_not_null($products_narrow_by_option_values_ids)) {
        if (1 == $narrow_by_count) {
            $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp using(products_id)";
            $and_narrow_by = " and povp.products_narrow_by_options_values_id = " . (int)$products_narrow_by_option_values_ids[0];
        } else {
            $from_narrow_by = '';
            $where_narrow_by = ' select t0.products_id from ';
            $sql_query_array = array();
            for ($i = 0; $i < $narrow_by_count; $i++) {
                $sql_query_array[] = " (select products_id from  " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
					where products_narrow_by_options_values_id = " . (int)$products_narrow_by_option_values_ids[$i] . "
								  ) as t" . $i . " ";
            }
            for ($i = 0, $n = sizeof($sql_query_array); $i < $n; $i++) {
                if ($i) {
                    $where_narrow_by .= ' CROSS JOIN';
                }
                $where_narrow_by .= $sql_query_array[$i];
                if ($i) {
                    $where_narrow_by .= " ON t" . ($i - 1) . ".products_id = t" . $i . ".products_id ";
                }
            }
            $and_narrow_by = " AND p.products_id in(" . $where_narrow_by . ")";
        }
    }

    $get_narrow = $_GET['narrow'] ? $_GET['narrow'] : array();
    $sql_order_by = ' ORDER BY p.products_sort_order asc ';
    if (isset($_GET['sort_order']) && $_GET['sort_order']) {
        switch ($_GET['sort_order']) {
            case 'priced':
                $sql_order_by = " group by p.products_id order by p.products_price desc ";
                break;
            case 'price':
                $sql_order_by = " group by p.products_id order by p.products_price ";
                break;
            case 'sellers':
                $sql_order_by = " group by p.products_id order by sales desc ";
                break;
            case 'rate':
                $sql_order_by = " group by p.products_id order by rating desc ";
                break;
            case 'new':
                $sql_order_by = " group by p.products_id order by p.products_date_added desc ";
                break;

            case 'productname':
                $sql_order_by = " order by pd.products_name ";
                break;
            case 'productnamed':
                $sql_order_by = " order by pd.products_name desc ";
                break;

            case 'popularity':

            default:
                $sql_order_by = " group by p.products_id order by p.products_sort_order asc ";
                break;
        }
    }
    if (zen_has_category_subcategories($current_category_id)) {
        $all_subcategories_ids = array();
        zen_get_subcategories($all_subcategories_ids, $current_category_id);
        $all_subcategories_ids = array_unique($all_subcategories_ids);
        $count_of_subcategories = sizeof($all_subcategories_ids);
        if ($count_of_subcategories) {
            if (1 < $count_of_subcategories) {
                $category_where_sql = " AND ptc.categories_id in(" . join(',', $all_subcategories_ids) . ")";
            } else if (1 == $count_of_subcategories) {
                $category_where_sql = " AND ptc.categories_id = " . $all_subcategories_ids[0];
            }
        } else {
            $category_where_sql = " AND ptc.categories_id = " . (int)$current_category_id;
        }
    } else {
        $category_where_sql = " AND ptc.categories_id = " . (int)$current_category_id;
    }

    $query_select_colums = " select p.products_id,p.products_image,p.products_price ,products_SKU,p.products_model, is_inquiry, is_min_order_qty,wavelenght,distance,data_rate";

    $query_from = " from " . TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";

    $query_where = " WHERE p.products_status = 1 and (p.products_price >0 || is_inquiry =1) " . $category_where_sql;

    if ($_GET['sort_order'] == 'sellers') {
        $query_select_colums .= ",sum(op.products_quantity) as sales ";
        $query_from .= " left join orders_products as op using(products_id) ";
    }
    if ($_GET['sort_order'] == 'rate') {
        $query_select_colums .= ",count(rd.reviews_id) as rating ";
        $query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
    }
    $listing_sql = $query_select_colums . $query_from . $from_narrow_by . $query_where . $and_narrow_by . $sql_order_by;

    $all_listing_sql = "select products_id " . $query_from . $from_narrow_by . $query_where . $and_narrow_by;

    $all_products = $db->Execute($all_listing_sql);
    $count = 24;

    if (isset($_GET['count']) && intval($_GET['count'])) $count = intval($_GET['count']);
    if (isset($_GET['settab']) && $_GET['settab']) {
        $settab = $_GET['settab'];
    } else {
        $settab = 'two';
    }
    if (strstr($_SERVER['HTTP_REFERER'], "#matrix")) {
        $settab = 'three';
    } else {
        if (isset($_GET['settab']) && $_GET['settab']) {
            $settab = $_GET['settab'];
        } else {
            $settab = 'two';
        }
    }

    $listing_split = new splitPageResults($listing_sql, $count, 'products_id', 'page');

//echo $listing_split->sql_query;exit;
    $get_products = $db->Execute($listing_split->sql_query);
//echo $listing_split->sql_query;

    if ($listing_split->number_of_rows < 1) $current_catgegory_no_products = true;
    else {
        $products = array();
        if ($get_products->RecordCount()) {
//		$page_links = $listing_split->get_current_page_of_total_page('Page %d of %d') .' '. $listing_split->display_links(5,zen_get_all_get_params(array('page')));
            $params_for_categories_split = zen_get_all_get_params(array('page', 'count', 'settab'));
            if ($current_category_id) $params_for_categories_split = zen_get_all_get_params(array('page', 'cPath', 'count', 'settab')) . '&cPath=' . $current_category_id;

            //$page_links = $listing_split->display_links(5,$params_for_categories_split);
            //$page_top_links = $listing_split->display_top_links_extra(1,$params_for_categories_split);

            if (!(isset($_GET['sort_order']) && $_GET['sort_order'])) {
                $params_for_categories_split .= '&sort_order=popularity';
            }
            $params_for_categories_split .= $narrow_url;
            $params_for_categories_split .= '&count=' . $count . '&settab=' . $settab;
            $page_links = $listing_split->display_links_listing(1, $params_for_categories_split);
            $page_top_links = $page_links;
            $page_jump_links = zen_href_link($_GET['main_page'], $params_for_categories_split);


            while (!$get_products->EOF) {
                $products [] = array(
                    'id' => $get_products->fields['products_id'],
                    'name' => zen_get_products_name($get_products->fields['products_id']),
                    'image' => $get_products->fields['products_image'],
                    'price' => $get_products->fields['products_price'],
                    'sku' => $get_products->fields['products_SKU'],
                    'model' => $get_products->fields['products_model'],
                    'is_inquiry' => $get_products->fields['is_inquiry'],
                    'is_min_order_qty' => $get_products->fields['is_min_order_qty'],
                    'wavelenght' => $get_products->fields['wavelenght'],
                    'distance' => $get_products->fields['distance'],
                    'data_rate' => $get_products->fields['data_rate']
                );
                $get_products->MoveNext();
            }
        }

        $all_product = array();
        if ($all_products->RecordCount()) {
            while (!$all_products->EOF) {
                $all_product [] = array(
                    'id' => $all_products->fields['products_id'],
                );
                $all_products->MoveNext();
            }
        }
    }
    $cPath_num = sizeof($cPath);
    $products_list_info = '';
    if (is_array($products)) {
        require(DIR_WS_CLASSES . 'fs_reviews.php');
        $fs_reviews = new fs_reviews();
        foreach ($products as $k => $v) {
            if (isset($_GET['_requestConfirmationToken']) || $cPath_num > 3) {
                $images_status = 1;
            } else {
                $images_status = fs_get_data_from_db_fields('is_hidden_images', 'products', 'products_id=' . $v['id'], '');
            }
            if ($images_status == 1) {
                $href_link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id=' . $v['id'], 'NONSSL');
                $image_src = file_exists(DIR_WS_IMAGES . $v['image']) ? DIR_WS_IMAGES . $v['image'] : DIR_WS_IMAGES . 'no_picture.gif';
                $image = zen_image($image_src, $v['name'], 200, 200, 'title="' . $v['name'] . '"');
                $new_product_price = $v['price'];
                $description = strip_tags(zen_get_products_description($v['id']));
                $description = (220 < strlen($description)) ? substr($description, 0, 220) . '...' : $description;
                $name = $v['name'];
                $product_stock = zen_get_product_has_stock($v['id']);
                $stock_num = zen_get_products_instock_total_qty_of_products_id($v['id']);
                $param = '';
                $param_html = '';
                $product_title = '';
                $product_param = '';
                $param = fs_get_data_from_db_fields('products_param', 'products_description', 'products_id = ' . (int)$v['id'] . ' and language_id = ' . (int)$_SESSION['languages_id'], '');
                if ($param) {
                    $param_array = explode('|', $param);
                    $product_param = explode(';', $param_array[0]);
                    $product_title = $param_array[1];
                    if ($param_array[0]) {
                        foreach ($product_param as $kk => $vv) {
                            $products[$k]['cable_list'][$kk] = $vv;
                        }
                    }
                }
                $reviews = fs_get_data_from_db_fields('reviews_id', 'reviews', 'products_id=' . $v['id'], 'limit 1');
                $reviews_score = $fs_reviews->fs_get_product_reviews_score($v['id']);
                $stars_matcher = array(1 => 'p_star05', 2 => 'p_star04', 3 => 'p_star03', 4 => 'p_star02', 5 => 'p_star01',);
                if ($reviews) {
                    $reviews_nums = substr($reviews_score, -1);
                    $reviews_sums = substr($reviews_score, 0, 1);
                    if ($reviews_nums == 0) {
                        $reviews_width = 100;
                    } else {
                        $reviews_width = $reviews_nums * 10;
                    }
                    $stars = fs_product_reviews_level_show_create($reviews_score, $reviews_width, $reviews_sums);
                    for ($o = 0; $o < 5; $o++) {
                        $products[$k]["star" . $o] = $stars[$o];
                    }
                } else {
                    for ($o = 0; $o < 5; $o++) {
                        $products[$k]["star" . $o] = 0;
                    }
                }
                $name = ($product_title) ? $product_title : $name;
                $products[$k]['name'] = $name;
                $products[$k]['instock'] = $product_stock;
                $products[$k]['description'] = $description;
                $products[$k]['instock_num'] = $stock_num;
                $products[$k]['delivery_time'] = zen_get_products_instock_shipping_date_of_products_id($v['id'], $stock_num, $countries_code_2);
                if (!in_array($v['id'], $wholesaleproducts)) {
                    $products[$k]['price'] = $currencies->new_format(get_customers_products_level_final_price($new_product_price));
                } else {
                    $products[$k]['price'] = $currencies->format(get_customers_products_level_final_price($new_product_price));
                }
            }
        }
        $total =  $listing_split -> number_of_rows;
        echo json_encode(array("items" => array(array("total"=>$total,"title" => zen_get_categories_name($current_category_id), "products" => $products))));
    } else {
        echo json_encode(array("items" => "无产品"));
    }
}
//获取分类产品标题
if ($_GET["type"] == "get_title") {
    if ($_GET['c_id'] === 1) {
        echo json_encode(array("msg" => "没有数据"));
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
    $arr = array(array("title" => zen_get_categories_name($current_category_id)));
    echo json_encode(array("items" => $arr));
}
if ($_GET["type"] == 'cates_sub') {
    if ($_GET['c_id'] === 1) {
        echo 1;
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
    $count_of_cPath_array = sizeof($cPath_array);
    if ($cPath_array[0] == 9) {
        $showName = 'Compatible Brands';
    } else {
        $showName = 'Catagories';
    }
    if (zen_has_category_subcategories($cPath_array[2])) {
        $categories_reset = zen_get_subcategories_of_one_category($cPath_array[2]);
        $first_categories = array_slice($categories_reset, 0, 7);
        $c_sort = 0;
        $categories = $categories_reset;
        $href2 = '';
        $category_narrow = '';
        $fcDIV = false;
        $arr = array();
        foreach ($categories as $i => $cID) {
            $c_sort++;
            if ($cPath_array[0] == 9) {
                $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
            } else {
                $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
            }

            if ($current_category_id == $cID) {
                $arr[$i]['href'] = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_array[2]);
                $arr[$i]['name'] = zen_get_categories_name($cID);
            } else {
                $arr[$i]['href'] = $href2;
                $arr[$i]['name'] = zen_get_categories_name($cID);
            }
        }
    }
    echo json_encode(array("items" => array(array("cat_name" => $showName, "item" => $arr))));
}
//获取产品分类页面属性
if ($_GET["type"] == "get_attribute") {
    if ($_GET['c_id'] === 1) {
        echo 1;
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
    $count_of_cPath_array = sizeof($cPath_array);
    if (!in_array($current_category_id, array(1, 3, 4, 9, 209, 999, 573, 904))) {
        if (!class_exists('products_narrow_by')) {
            require DIR_WS_CLASSES . 'products_narrow_by.php';
            $products_narrow_by = new products_narrow_by();
        }
        $c_pids = array();
        //get narrow by values id
        $get_narrow = array();
        $products_narrow_by_option_values_ids = array();
        $unarrowGET = array('_requestConfirmationToken', 'cPath', 'main_page', 'page', 'sort', 'type', 'count', 'settab', 'c_id', 'type');
        foreach ($_GET as $getname => $getvalue) {
            if (!in_array($getname, $unarrowGET)) {
                if ($getvalue && is_numeric($getvalue)) {
                    $get_narrow [] = $getvalue;
                    $narrow_url .= '&narrow[]=' . $getvalue;
                }
            }
        }
        $products_narrow_by_option_values_ids = $get_narrow;

        $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
        $from_narrow_by = '';
        if (zen_not_null($products_narrow_by_option_values_ids)) {
            if (1 == $narrow_by_count) {
                $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp using(products_id)";
                $and_narrow_by = " and povp.products_narrow_by_options_values_id = " . (int)$products_narrow_by_option_values_ids[0];
            } else {
                $from_narrow_by = '';
                $where_narrow_by = ' select t0.products_id from ';
                $sql_query_array = array();
                for ($i = 0; $i < $narrow_by_count; $i++) {
                    $sql_query_array[] = " (select products_id from  " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
					where products_narrow_by_options_values_id = " . (int)$products_narrow_by_option_values_ids[$i] . "
								  ) as t" . $i . " ";
                }
                for ($i = 0, $n = sizeof($sql_query_array); $i < $n; $i++) {
                    if ($i) {
                        $where_narrow_by .= ' CROSS JOIN';
                    }
                    $where_narrow_by .= $sql_query_array[$i];
                    if ($i) {
                        $where_narrow_by .= " ON t" . ($i - 1) . ".products_id = t" . $i . ".products_id ";
                    }
                }
                $and_narrow_by = " AND p.products_id in(" . $where_narrow_by . ")";
            }
        }

        $get_narrow = $_GET['narrow'] ? $_GET['narrow'] : array();
        $sql_order_by = ' ORDER BY p.products_sort_order asc ';
        if (isset($_GET['sort_order']) && $_GET['sort_order']) {
            switch ($_GET['sort_order']) {
                case 'priced':
                    $sql_order_by = " group by p.products_id order by p.products_price desc ";
                    break;
                case 'price':
                    $sql_order_by = " group by p.products_id order by p.products_price ";
                    break;
                case 'sellers':
                    $sql_order_by = " group by p.products_id order by sales desc ";
                    break;
                case 'rate':
                    $sql_order_by = " group by p.products_id order by rating desc ";
                    break;
                case 'new':
                    $sql_order_by = " group by p.products_id order by p.products_date_added desc ";
                    break;

                case 'productname':
                    $sql_order_by = " order by pd.products_name ";
                    break;
                case 'productnamed':
                    $sql_order_by = " order by pd.products_name desc ";
                    break;

                case 'popularity':

                default:
                    $sql_order_by = " group by p.products_id order by p.products_sort_order asc ";
                    break;
            }
        }
        if (zen_has_category_subcategories($current_category_id)) {
            $all_subcategories_ids = array();
            zen_get_subcategories($all_subcategories_ids, $current_category_id);
            $all_subcategories_ids = array_unique($all_subcategories_ids);
            $count_of_subcategories = sizeof($all_subcategories_ids);
            if ($count_of_subcategories) {
                if (1 < $count_of_subcategories) {
                    $category_where_sql = " AND ptc.categories_id in(" . join(',', $all_subcategories_ids) . ")";
                } else if (1 == $count_of_subcategories) {
                    $category_where_sql = " AND ptc.categories_id = " . $all_subcategories_ids[0];
                }
            } else {
                $category_where_sql = " AND ptc.categories_id = " . (int)$current_category_id;
            }
        } else {
            $category_where_sql = " AND ptc.categories_id = " . (int)$current_category_id;
        }

        $query_select_colums = " select p.products_id,p.products_image,p.products_price ,products_SKU,p.products_model, is_inquiry, is_min_order_qty,wavelenght,distance,data_rate";

        $query_from = " from " . TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";

        $query_where = " WHERE p.products_status = 1 and (p.products_price >0 || is_inquiry =1) " . $category_where_sql;

        if ($_GET['sort_order'] == 'sellers') {
            $query_select_colums .= ",sum(op.products_quantity) as sales ";
            $query_from .= " left join orders_products as op using(products_id) ";
        }
        if ($_GET['sort_order'] == 'rate') {
            $query_select_colums .= ",count(rd.reviews_id) as rating ";
            $query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
        }
        $listing_sql = $query_select_colums . $query_from . $from_narrow_by . $query_where . $and_narrow_by . $sql_order_by;

        $all_listing_sql = "select products_id " . $query_from . $from_narrow_by . $query_where . $and_narrow_by;

        $all_products = $db->Execute($all_listing_sql);

        $count = 24;
        $all_product = array();
        if ($all_products->RecordCount()) {
            while (!$all_products->EOF) {
                $all_product [] = array(
                    'id' => $all_products->fields['products_id'],
                );
                $all_products->MoveNext();
            }
        }
        //$all_product
        if ($all_product) {
            foreach ($all_product as $kk => $c_pro) {
                $c_pids [] = $c_pro['id'];
            }
        }
        if ($cPath_array[1] && !$cPath_array[2] && zen_has_category_subcategories($cPath_array[1])) {
        } else {
            if (sizeof($c_pids)) {
                $html = fs_products_narrow_by_list($current_category_id, $c_pids, $get_narrow);
                $html = array_values($html);
				if(is_array($html)&&sizeof($html)){
					echo json_encode(array("items" => $html));
				}else{
					echo json_encode(array("items"=>array(array("title"=>""))));
				}
               
            }
        }

    }

}
function fs_products_narrow_by_list($current_category_id, $pids, $get_narrow)
{
    global $cPath_array;
    global $products_narrow_by;
    $narrow_by_hidding = false;
    //默认展开
    $display_css_class = 'sidebar_06_js';
    $display_dd_css_class = '';
    $narrow_by_html = '';
    $arr = array();
    $category_options = $products_narrow_by->fs_category_products_narrow_option($pids, 'cpath', $current_category_id);  //分类产品拥有的筛选项
    $narrow_by_options = $products_narrow_by->sort_order_narrow_by_options($category_options);  //筛选项排序
    $trim = true;
    //筛选项循环
    $get_narrow_option = array();
    if (sizeof($get_narrow)) {
        for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
            $get_narrow_option [] = $products_narrow_by->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
        }
    }
    foreach ($narrow_by_options as $i => $oID) {
        $products_narrow_value = $products_narrow_by->fs_narrow_by_values_by_select_products($oID, $pids);   //当前产品,当前筛选项下拥有的筛选值
        if (sizeof($products_narrow_value) < 2 && !in_array($oID, $get_narrow_option)) {

        } else {
            //剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
            $replace_option = array();
            for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                } else {
                    $replace_option [] = $get_narrow[$ni];
                }
            }
            // 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
            if (sizeof($get_narrow)) {
                $narrow_option_values = $products_narrow_by->zen_get_count_products_of_alnoe_narrow($replace_option, $oID, $current_category_id);
            }
            $arr[$i][title] = $products_narrow_by->get_products_narrow_by_option_name($oID);
            $narrow_by_values = $products_narrow_by->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
            if (sizeof($narrow_by_values)) {
                $narrow_by_values = $products_narrow_by->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
                $nvi = 0;
                $cDIV = false;
                $hideNV = false;
                foreach ($narrow_by_values as $ii => $vID) {
                    $is_current = $narrow_get_parmas_string = '';
                    //$page = FILENAME_NARROW;
                    $page = FILENAME_DEFAULT;
                    $except_values = array('cPath', 'narrow');
                    $new_narrow_by_array = array();
                    $href = $name = $count_of_narrow_by_products = '';
                    $class = '';
                    if (zen_not_null($get_narrow)) {
                        if (in_array($vID, $get_narrow)) {  //已选择的筛选值,添加样式
                            $is_current = 'xiand';
                            $class = $is_current;
                        }
                    } else {
                        $new_narrow_by_array = array();
                    }
                    $_GET['narrow'] = $new_narrow_by_array;

                    $name = $products_narrow_by->get_option_values_name($vID);

                    $narrow_url = '';
                    $replace_narrow = array();

                    //其他参数 : 排序,页数,标签
                    if (isset($_GET['sort_order']) && $_GET['sort_order']) $narrow_url .= '&sort_order=' . $_GET['sort_order'] . '';
                    if (isset($_GET['count']) && intval($_GET['count'])) $narrow_url .= '&count=' . $_GET['count'];
                    if (isset($_GET['settab'])) {
                        $narrow_url .= '&settab=' . $_GET['settab'];
                    }
                    //如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
                    for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                        if ($vID == $get_narrow[$ni]) {    //取消已选择的筛选值
                            $narrow_url .= '';
                        } else if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                            $narrow_url .= '&narrow[]=' . $vID;
                        } else {
                            $narrow_url .= '&narrow[]=' . $get_narrow[$ni];
                        }
                    }
                    if ($get_narrow_option) {
                        if (!in_array($oID, $get_narrow_option)) {        //没有勾选的筛选项
                            if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                                $hideNV = true;
                            } else {
                                $hideNV = false;
                                $nvi++;
                            }
                        } else {   //同选中的筛选项,替换之后会有产品,才能显示
                            //if(sizeof($get_narrow_option) > 1){
                            //交叉筛选时,才用这个.两个及以上的筛选
                            if (in_array($vID, $narrow_option_values)) {  //筛选条件下,是否有产品
                                $hideNV = false;
                                $nvi++;
                            } else {
                                $hideNV = true;
                            }
                            //}
                        }
                        //过滤该option下的vid  , 从产品中查询是否有该vID
                        if (!in_array($oID, $get_narrow_option)) {  //除去当前筛选,选择新的筛选值时,新增URL参数
                            $narrow_url .= '&narrow[]=' . $vID;
                        }
                    } else {
                        if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                            $hideNV = true;
                        } else {
                            $hideNV = false;
                            $nvi++;
                        }
                        $narrow_url .= '&narrow[]=' . $vID;
                    }
                    $href = zen_href_link($page, $narrow_url . '&cPath=' . $current_category_id);
                    if( !$hideNV){
                        $arr[$i]["item"][$ii]['href'] = $href;
                        $arr[$i]["item"][$ii]['name'] = $name;
                        $arr[$i]["item"][$ii]['if_show'] ="show";
                    }else{
                        $arr[$i]["item"][$ii]['href'] = "none";
                        $arr[$i]["item"][$ii]['name'] = "none";
                        $arr[$i]["item"][$ii]['if_show'] ="hide";
                    }
                }
            }
        }
    }
    if (sizeof($arr)) {
        return $arr;
    }
}

//获取分类产品页面分类链接

if ($_GET["type"] == 'cates') {
    if ($_GET['c_id'] === 1) {
        echo 1;
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
    $count_of_cPath_array = sizeof($cPath_array);
    $ParentCID = categories_of_parent_id($current_category_id);
    if ($_GET['narrow']) {
        for ($ni = 0; $ni < sizeof($_GET['narrow']); $ni++) {
            $simgle_narrow .= '&narrow[]=' . $_GET['narrow'][$ni];
        }
        $simgle_narrow .= '&';
    }
    $arr = array();
    $server_host = zen_href_link(FILENAME_DEFAULT);
    $selected = zen_get_categories_name($current_category_id);
    if ($count_of_cPath_array >= 3) {
        if (zen_has_category_subcategories($cPath_array[1])) {
            $categories_reset = zen_get_subcategories_of_one_category($cPath_array[1]);
            $c_sort = 0;
            $categories = $categories_reset;
            $href2 = '';
            $scDIV = false;
            foreach ($categories as $i => $cID) {
                $c_sort++;
                $href2 = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                $href2 = "/" . str_replace($server_host, "", $href2);
                if ($c_sort == 9 && sizeof($categories) > 8) {
                    $scDIV = true;
                    //echo '<div class="all_subcategories_list" id="subcategory_pulldown" style="display:none;">';
                }
                if ($current_category_id == $cID || $cPath_array[2] == $cID) {
                    $arr[$i]["link"] = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_array[1]);
                    $arr[$i]["link"] = "/" . str_replace($server_host, "", $arr[$i]["link"]);
                    $arr[$i]['name'] = zen_get_categories_name($cID);
                } else {
                    $arr[$i]["link"] = $href2;
                    $arr[$i]['name'] = zen_get_categories_name($cID);
                }
                if ($arr[$i]['name'] == $selected) {
                    $arr[$i]['selected'] = "choose";
                } else {
                    $arr[$i]['selected'] = "";
                }
            }
        } else {
            $arr[0]['name'] = zen_get_categories_name($cPath_array[1]);
        }
        $cat_name = "Categories";
    } else {

        if (!$cPath_array[1]) {
            $cat_name = zen_get_categories_name($cPath_array[1]);
        } else {
            $cat_name = "Categories";
            $n = 0;
            if (2 == sizeof($cPath_array)) {
                if (zen_has_category_subcategories($cPath_array[1])) {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[1]);
                    $S_sort = 1;
                    $cDIV = false;
                    foreach ($categories as $i => $cID) {
                        $S_sort++;
                        $n++;
                        $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                        $arr[$i]["link"] = "/" . str_replace($server_host, "", $href);
                        if ($S_sort == 9 && sizeof($categories) > 8) {
                            $cDIV = true;
                        }
                        $arr[$i]['name'] = zen_get_categories_name($cID);
                    }
                } else {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[0]);
                    foreach ($categories as $i => $cID) {
                        if ($cID == (int)$cPath_array[1]) {
                            $arr[$i]['name'] = zen_get_categories_name($cPath_array[1]);
                        } else {
                            $arr[$i]['name'] = zen_get_categories_name($cID);
                            $arr[$i]['link'] = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                            $arr[$i]['link'] = str_replace($server_host, "", $arr[$i]['link']);
                        }
                    }
                }
            }
        }
    }
    echo json_encode(array("items" => array(array("cat_name" => $cat_name, "item" => $arr))));
}

if ($_GET["type"] == "get_crumbs") {
    if ($_GET['c_id'] === 1) {
        echo 1;
        exit;
    }
    $cPath = explode("/", $_GET['c_id']);
    $cPath = $cPath[count($cPath) - 1];
    $current = explode("-", $cPath);
    $current_size = count($current);
    $cPath = $current[$current_size - 1];
    if (zen_not_null($cPath)) {
        if (!strpos($cPath, '_')) {
            $cPath = zen_get_path_by_categories_id((int)$cPath);
        } else {
            $acture_category_id = substr($cPath, (strrpos($cPath, '_') + 1));
            $cPath = zen_get_path_by_categories_id((int)$acture_category_id);
        }
    }
    $show_welcome = false;
    if (isset($cPath)) {
        $cPath = $cPath;
    } elseif (isset($_GET['products_id']) ) {
        $cPath = zen_get_product_path($_GET['products_id']);
    } else {
        if (SHOW_CATEGORIES_ALWAYS == '1' ) {
            $show_welcome = true;
            $cPath = (defined('CATEGORIES_START_MAIN') ? CATEGORIES_START_MAIN : '');
        } else {
            $show_welcome = false;
            $cPath = '';
        }
    }
    if (zen_not_null($cPath)) {
        $cPath_array = zen_parse_category_path($cPath);
        $cPath = implode('_', $cPath_array);
        $current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
    } else {
        $current_category_id = 0;
        $cPath_array = array();
    }
    echo json_encode(array("items" => array(array("crumb" => zen_get_categories_parent_name($current_category_id),
        "link" =>  zen_href_link(FILENAME_DEFAULT, 'cPath=' .zen_get_categories_parent_id($current_category_id))))));
}
function zen_get_categories_parent_id($categories_id) {
    global $db;
    $lookup_query = "select parent_id from " . TABLE_CATEGORIES . " where categories_id='" . (int)$categories_id . "'";
    $lookup = $db->Execute($lookup_query);

    return $lookup->fields['parent_id'];
}


?>