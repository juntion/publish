<?php
function get_help_string_categories_amp($current_block_id = '80/82')
{
    require_once('includes/classes/home_custom.php');
    $home_custom_model = new homeCustomModel();
    $m_warehouse = '';
    if ($_SESSION['languages_code'] == 'fr') {
        if (seattle_warehouse($code = "country_code", $_SESSION['countries_code_21'])) {
            $m_warehouse = 1;
        } else {
            $m_warehouse = 2;
        }
    }
    if ($_SESSION['languages_code'] == 'ru') {
        if (all_german_warehouse($code = "country_code", $_SESSION['countries_code_21'])) {
            $m_warehouse = 2;
        } else {
            $m_warehouse = 4;
        }
    }
    $header_is_german_warehouse = all_german_warehouse('country_code', $_SESSION['countries_iso_code']);
    $header_data = $home_custom_model->get_footer_data($header_is_german_warehouse, $m_warehouse, $current_block_id, 1);
    return $header_data;
}

function get_label_list_amp($product)
{
    global $db;
    if (in_array($_SESSION['languages_code'], array('uk', 'dn', 'au', 'en'))) {
        $session = 1;
    } else {
        $session = $_SESSION['languages_id'];
    }
    $tagInfo = $db->Execute("select tags, vice_tags from products_list_tags where products_id = " . $product['id'] . " and languages_id =" . $session);

    //主标签
    $pro_tags = $tagInfo->fields['tags'];
    $pro_tags_arr = [];
    if ($pro_tags) { //主标签
        $p_tags = explode('#', $pro_tags);
        $p_tags = array_filter($p_tags); //去掉数组中的空元素
        if (sizeof($p_tags)) {
            foreach ($p_tags as $key => $p_tag) {
                if ($p_tag != '') {
                    $p_tag = content_preg_mtp($p_tag, $product['category_arr'][0]);
                    $pro_tags_arr[] = $p_tag;
                }
            }
        }
    }

    //副标签
    $pro_vice_tags = $tagInfo->fields['vice_tags'];
    $pro_vice_tags_arr = [];
    if ($pro_vice_tags) { //副标签
        $p_vice_tags = explode('#', $pro_vice_tags);
        $p_vice_tags = array_filter($p_vice_tags); //去掉数组中的空元素
        if (sizeof($p_vice_tags)) {
            foreach ($p_vice_tags as $p_tag) {
                if ($p_tag != '') {
                    $pro_vice_tags_arr[] = $p_tag;
                }
            }
        }
    }

    return [
        'primary_label' => $pro_tags_arr,
        'secondary_label' => $pro_vice_tags_arr,
    ];
}

function get_related_model_amp($product)
{
    $cPath_array = $product['category_arr'];
    $cPath_array_str = implode('_', $cPath_array);
    define('PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX', $_SESSION['languages_code'] . '_product_related_attribute_' . $cPath_array_str . '_' . $product['id'] . '_for_list:');
    $related_attribute_redis_key = md5($product['id'] . $_SESSION['countries_iso_code'], true);
    $related_attributes_array = get_redis_key_value($related_attribute_redis_key, PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
    if (!$related_attributes_array) {
        if (!$productRelatedAttributesModel) {
            require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
            $productRelatedAttributesModel = new productRelatedAttributesModel();
        }
        $related_attributes_array = $productRelatedAttributesModel->get_product_list_related_attribute($product['id'], $product['is_not_custom_str']);
        set_redis_key_value($related_attribute_redis_key, $related_attributes_array, 24 * 3600, PRODUCT_LIST_RELATED_ATTRIBUTE_REDIS_KEY_PREFIX);
    }
    return $related_attributes_array ? $related_attributes_array : [];
}


// 匹配img标签里面得src
function get_img_src_amp($content)
{
    $preg = '/<img.*?src=[\"|\']+(.*?)[\"|\']+.*?>/';
    preg_match_all($preg, $content, $match);
    $count = count($match[1]);
    $filepaths = '';
    if ($count > 0) {
        for ($i = 0; $i < $count; $i++) {
            if ($i != $count - 1) {
                $filepaths .= $match[1][$i] . ',';
            } else {
                $filepaths .= $match[1][$i];
            }
        }
    }
    return $filepaths;
}

header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Origin:https://www-fs-com.cdn.ampproject.org");
header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
header("AMP-Access-Control-Allow-Source-Origin: https://www.fs.com");
require 'includes/application_top.php';
if (!class_exists('fiberstore_category')) {
    require DIR_WS_CLASSES . 'fiberstore_category.php';
}
$action = $_GET['action'];
$cid = $_GET['cid'] ? (int) $_GET['cid'] : '';
switch ($action) {
    case 'left_bar':
        $data = [];
        $header_data = get_help_string_categories_amp();
        foreach ($header_data as $k => $v) {
            $data[$k]['index'] = $k;
            $data[$k]['url'] = $v['url'] ? HTTPS_SERVER . reset_url($v['url']) : '';
            $data[$k]['title'] = $v['title'];
            $one_cate = get_help_string_categories_amp($v['new_parent_ids_path']);
            foreach ($one_cate as $one_k => $one_v) {
                $data[$k]['sub'][$one_k]['index'] = $one_k;
                $data[$k]['sub'][$one_k]['url'] = $one_v['url'] ? HTTPS_SERVER . reset_url($one_v['url']) : '';
                $data[$k]['sub'][$one_k]['title']  = $one_v['title'];
            }
        }
        $contact_us = [
            [
                'index' => $k + 1,
                'url' => zen_href_link(FILENAME_CONTACT_US),
                'title' => BOX_INFORMATION_CONTACT,
                'sub' => []
            ],
        ];
        $data = array_merge($data, $contact_us);
        $return['items'] = $data;
        echo json_encode($return);
        break;

    case 'countries':
        if ($_SESSION['languages_code'] == 'fr') {
            $countries_name = 'ru_countries_name';
        } elseif ($_SESSION['languages_code'] == 'es') {
            $countries_name = 'es_countries_name';
        } elseif ($_SESSION['languages_code'] == 'jp') {
            $countries_name = 'jp_countries_name';
        } elseif ($_SESSION['languages_code'] == 'de') {
            $countries_name = 'de_countries_name';
        } elseif ($_SESSION['languages_code'] == 'ru') {
            $countries_name = 'ru_countries_name';
        } else {
            $countries_name = 'countries_name';
        }
        function search_countries($search_key, $countries_name)
        {
            global $db;
            $order = '';
            $field = ' countries_iso_code_2,countries_id,' . $countries_name . ' ';
            $where = ' ' . $countries_name . ' like "' . preg_replace('/_/', ' ', $search_key) . '%" ';
            $sql = 'select ' . $field . ' from countries where ' . $where . $order . ' limit 10';
            $result = $db->getAll($sql);
            return $result;
        }
        $search_key = $_GET["search_key"];
        $data = search_countries($search_key, $countries_name);
        echo json_encode($data);
        break;

    case 'search':
        if ($_SESSION['languages_code'] == 'au' || $_SESSION['languages_code'] == 'uk') {
            $search_words_languages_id = 1;
        } else {
            $search_words_languages_id = $_SESSION['languages_id'];
        }

        require(DIR_WS_CLASSES . 'search_recommend.php'); //类或者方法
        $search_recommend = new search_recommend();

        $search_key = $search_recommend->handle_search_key_for_recommend($_GET["search_key"]);
        if ($search_key) {
            $count = $search_recommend->get_search_recommend_list($search_key, $search_words_languages_id, '', 'count');
            if ($count > 0) {
                $data = $search_recommend->get_search_recommend_list($search_key, $search_words_languages_id, ' limit 10 ');
                if ($data) {
                    foreach ($data as $key => $val) {
                        if ($val['fs_search_link']) {
                            $data[$key]['link'] = str_replace("https://www.fs.com", $_GET['lang'], $val['fs_search_link']);
                        } else {
                            $data[$key]['link'] = str_replace("https://www.fs.com", $_GET['lang'], zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '&keyword=' . $val['fs_search_words'], 'SSL'));
                        }
                        unset($data[$key]['fs_search_id']);
                        unset($data[$key]['fs_search_link']);
                        unset($data[$key]['level']);
                    }
                }
            }
        }
        $return['items'] = $data ? $data : [];
        echo json_encode($return);
        exit();
        break;

    case 'hot_search':
        $data = [
            [
                'name' => FS_HEADER_03,
                'link' => 'c/cisco-40g-qsfp-1361'
            ],
            [
                'name' => FS_HEADER_04,
                'link' => 'c/qsfp28-100g-transceivers-1159'
            ],
            [
                'name' => FS_HEADER_05,
                'link' => 'c/10g-sfp-dac-1114'
            ],
            [
                'name' => FS_HEADER_06,
                'link' => 'c/dwdm-sfp-plus-66'
            ],
            [
                'name' => FS_HEADER_07,
                'link' => 'c/cwdm-dwdm-mux-demux-6'
            ],
            [
                'name' => FS_HEADER_08,
                'link' => 'c/mtp-mpo-fiber-cabling-899'
            ],
            [
                'name' => FS_HEADER_09,
                'link' => 'c/os2-9-125-singlemode-duplex-897'
            ],
            [
                'name' => FS_HEADER_10,
                'link' => 'c/optical-attenuators-1023'
            ],
        ];
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == 'link') {
                    $data[$key][$k] = reset_url($v);
                }
            }
        }
        $return['items'] = $data;
        echo json_encode($return);
        exit();
        break;

    case 'index_banners':
        $banner_warehouse_str = get_warehouse_banner_str();
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
        $banner = $home_custom_model->get_index_banners_data($banner_warehouse_str);
        $data = [];
        foreach ($banner as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == 'url_str') {
                    $data[$key][$k] = $v;
                }
                if ($k == 'img_mobile_path') {
                    $data[$key][$k] = HTTPS_IMAGE_SERVER . $v;
                }
            }
        }
        $data = array_values($data);
        $data_arr = [['values' => $data]];
        $return['items'] = $data_arr;
        echo json_encode($return);
        exit();
        break;

    case 'index_products':
        $group = $_GET['group'] ? (int) $_GET['group'] : '';
        $warehouse = get_site_warehouse_str();
        if (!$home_custom_model) {
            require_once('includes/classes/home_custom.php');
            $home_custom_model = new homeCustomModel();
        }
        if ($_SESSION['languages_code'] == 'mx') {
            $index_products_site_id = $_SESSION['languages_id'];
        } else {
            $index_products_site_id = FS_SITE_UNIQUE_LANGUAGE_ID;
        }
        if ($_SESSION['languages_code'] == 'au') {
            $index_products = $home_custom_model->get_index_products_data($warehouse);
        } else {
            $index_products = $home_custom_model->get_index_products_data($warehouse, $index_products_site_id);
        }

        foreach ($index_products as $key => $val) {
            $first_proudcts_id = $val['first']['products_id'];
            $index_products[$key]['first']['price'] = str_replace('&nbsp;', ' ', get_products_price($first_proudcts_id, $wholesaleproducts));
            $index_products[$key]['first']['stock'] = get_instock_for_index($first_proudcts_id, true);
            foreach ($val['second'] as $key1 => $val1) {
                $current_proudcts_id = $val1['products_id'];

                $is_composite_products = false;
                if (class_exists('classes\CompositeProducts')) {
                    $CompositeProducts = new classes\CompositeProducts(intval($current_proudcts_id));
                    $composite_product_price = $CompositeProducts->get_composite_product_price(false);
                    if (!empty($composite_product_price['composite_product_price'])) {
                        $is_composite_products = true;
                    }
                }
                if ($is_composite_products) {
                    $index_products[$key]['second'][$key1]['price'] = $composite_product_price['composite_product_price_str'];
                } else {
                    $index_products[$key]['second'][$key1]['price'] = get_products_price($current_proudcts_id, $wholesaleproducts);
                }

                $index_products[$key]['second'][$key1]['stock'] = get_instock_for_index($current_proudcts_id, true);
            }
        }

        $data = [];
        foreach ($index_products as $key => $value) {
            if ($key == $group) {
                $data['first'] = $value['first'];
                $data['first']['link'] = zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $value['first']['products_id'], 'SSL');
                foreach ($value['second'] as $k => $v) {
                    $data['parentEle'][] = [
                        'childEle' => [
                            [
                                'img' => $v['img_mobile_path'],
                                'title' => $v['title'],
                                'price' => str_replace('&nbsp;', ' ', $v['price']),
                                'stock' => $v['stock'],
                                'link' => zen_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $v['products_id'], 'SSL')
                            ]
                        ]
                    ];
                }
            }
        }

        $data['parentEle'][0] = array_merge($data['parentEle'][0]['childEle'], $data['parentEle'][1]['childEle']);
        $data['parentEle'][1] = array_merge($data['parentEle'][2]['childEle'], $data['parentEle'][3]['childEle']);
        $data['parentEle'][2] = array_merge($data['parentEle'][4]['childEle'], $data['parentEle'][5]['childEle']);
        $data['parentEle'][3] = array_merge($data['parentEle'][6]['childEle'], $data['parentEle'][7]['childEle']);
        unset($data['parentEle'][4]);
        unset($data['parentEle'][5]);
        unset($data['parentEle'][6]);
        unset($data['parentEle'][7]);

        $arr = [];
        $arr_2 = [];
        foreach ($data['parentEle'] as $kkk => $vvv) {
            $arr_2['childEle'] = $vvv;
            $arr[] = $arr_2;
        }
        $data['parentEle'] = $arr;
        $return['items'] = [$data];
        echo json_encode($return);
        exit();
        break;

    case 'solution':
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
        $home_solution = $home_custom_model->get_index_solutions_data();
        $data = [];
        foreach ($home_solution['list'] as $k => $v) {
            $data[$k]['url'] = reset_url($v['url']);
            $data[$k]['img'] = zen_get_img_change_src($v['img_mobile_path']);
            $data[$k]['title'] = $v['title'];
        }

        $return['items'] = $data;
        echo json_encode($return);

        break;

    case 'footer':
        $group = $_GET['group'] ? (int) $_GET['group'] : '';
        require_once('includes/classes/home_custom.php');
        $home_custom_model = new homeCustomModel();
        $warehouse = '';
        if ($_SESSION['languages_code'] == 'fr') {
            if (seattle_warehouse($code = "country_code", $_SESSION['countries_code_21'])) {
                $warehouse = 1;
            } else {
                $warehouse = 2;
            }
        }
        if ($_SESSION['languages_code'] == 'ru') {
            if (all_german_warehouse($code = "country_code", $_SESSION['countries_code_21'])) {
                $warehouse = 2;
            } else {
                $warehouse = 4;
            }
        }

        $footer_data = $home_custom_model->get_footer_data($footer_is_german_warehouse, $warehouse);

        $data = [];
        foreach ($footer_data as $i => $footer_first) {
            $data[$i]['index'] = $i;
            $data[$i]['title'] = $footer_first['title'];
            foreach ($footer_first['list'] as $ii => $footer_second) {
                $data[$i]['sub'][$ii]['index'] = $ii;
                $data[$i]['sub'][$ii]['title'] = $footer_second['title'];
                $data[$i]['sub'][$ii]['url'] =  $footer_second['url'] ? HTTPS_SERVER . reset_url($footer_second['url']) : '';
            }
        }

        $return['items'] = $data;
        echo json_encode($return);
        break;

    case 'list_products':
        $retrun_arr = array();
        if (!(isset($current_category_id) && is_numeric($current_category_id) && $current_category_id > 0)) {
            echo json_encode('para data wrong');
            exit();
        }

        // 每页显示多少个
        $count = 24;
        $symbol_left = $_SESSION['currency'];

        $cPath_array = (array_reverse(get_category_parent_id($current_category_id, array())));
        $count_of_cPath_array = sizeof($cPath_array);

        //seo
        if (!isset($GLOBALS['seo_urls']) && !is_object($GLOBALS['seo_urls'])) {
            include_once(DIR_WS_CLASSES . 'seo.url.php');
            $GLOBALS['seo_urls'] = new SEO_URL($_SESSION['languages_id']);
        }

        //获取当前国家对应的发货仓库
        $warehouse_data = fs_products_warehouse_where();
        $warehouse_where = $warehouse_data['where'];
        $warehouse_code = $warehouse_data['code'];

        //筛选开始
        $get_narrow = array();
        $products_narrow_by_option_values_ids = array();
        $unarrowGET = array(
            '_requestConfirmationToken',
            'cPath',
            'main_page',
            'page',
            'sort',
            'type',
            'count',
            'settab'
        );
        foreach ($_GET as $getname => $getvalue) {
            if (!in_array($getname, $unarrowGET)) {
                if ($getvalue && is_numeric($getvalue)) {
                    $get_narrow[] = $getvalue;
                    // $narrow_url .='&narrow[]='.$getvalue;
                }
            }
        }
        $products_narrow_by_option_values_ids = $get_narrow;

        // 如果只是第一需要返回 所有的数据 不然就只需要返回产品的数据
        if (sizeof($get_narrow) || $_GET['sort_order'] || $_GET['page']) {
            $put_flag = false;
        } else {
            $put_flag = true;
        }

        $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
        $from_narrow_by = '';
        if ($narrow_by_count > 0 && zen_not_null($products_narrow_by_option_values_ids)) {
            if (1 == $narrow_by_count) {
                $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp using(products_id)";
                $and_narrow_by = " and povp.products_narrow_by_options_values_id = " . (int) $products_narrow_by_option_values_ids[0];
            } else {
                $from_narrow_by = '';
                $where_narrow_by = ' select t0.products_id from ';
                $sql_query_array = array();
                for ($i = 0; $i < $narrow_by_count; $i++) {
                    $sql_query_array[] = " (select products_id from  " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
						where products_narrow_by_options_values_id = " . (int) $products_narrow_by_option_values_ids[$i] . "
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

        $sql_order_by = ' ORDER BY p.products_sort_order asc ';

        if (isset($_GET['sort_order']) && $_GET['sort_order']) {
            switch ($_GET['sort_order']) {
                case 'priced':
                    $sql_order_by = " order by p.products_price desc ";
                    break;
                case 'price':
                    $sql_order_by = " order by p.products_price ";
                    break;
                case 'sellers':
                    $sql_order_by = " group by p.products_id order by sales desc ";
                    break;
                case 'rate':
                    $sql_order_by = " group by p.products_id order by rating desc ";
                    break;
                case 'new':
                    $sql_order_by = " order by p.products_date_added desc ";
                    break;

                case 'productname':
                    $sql_order_by = " order by pd.products_name ";
                    break;
                case 'productnamed':
                    $sql_order_by = " order by pd.products_name desc ";
                    break;

                case 'popularity':
                default:
                    $sql_order_by = " order by p.products_sort_order asc  ";
                    break;
            }
        }

        if (zen_has_category_subcategories($current_category_id)) {
            $all_subcategories_ids = array();
            //zen_get_subcategories($all_subcategories_ids,$current_category_id);
            $where_clearing = ' and is_clearing = 0 ';
            zen_get_subcategories($all_subcategories_ids, $current_category_id, $where_clearing);
            $all_subcategories_ids = array_unique($all_subcategories_ids);
            $all_subcategories_ids = array_unique($all_subcategories_ids);
            $count_of_subcategories = sizeof($all_subcategories_ids);
            if ($count_of_subcategories) {

                if (1 < $count_of_subcategories) {

                    if ($current_category_id == 576) {
                        array_push($all_subcategories_ids, $current_category_id);
                    }

                    $category_where_sql = " and ptc.categories_id in(" . join(',', $all_subcategories_ids) . ")";
                } else {
                    if (1 == $count_of_subcategories) {
                        $category_where_sql = " and ptc.categories_id = " . $all_subcategories_ids[0];
                    }
                }
            } else {
                $category_where_sql = " and ptc.categories_id = " . (int) $current_category_id;
            }
        } else {
            $category_where_sql = " and ptc.categories_id = " . (int) $current_category_id;
        }

        $query_select_colums = " select DISTINCT(p.products_id),p.products_image,p.products_price ,products_SKU,p.products_model,p.products_status,is_inquiry, is_min_order_qty,wavelenght,distance,data_rate";

        $query_from = " from " . TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";

        $query_where = " WHERE p.products_status = 1 and (p.products_price >0 || is_inquiry =1) " . $warehouse_where . $category_where_sql;

        /* 2015.9.29 beyond */
        if ($_GET['sort_order'] == 'sellers') {
            $query_select_colums .= ",sum(op.products_quantity) as sales ";
            $query_from .= " left join orders_products as op using(products_id) ";
        }
        if ($_GET['sort_order'] == 'rate') {
            $query_select_colums .= ",count(rd.reviews_id) as rating ";
            $query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int) $_SESSION['languages_id'] . ") ";
        }
        /* end */

        $listing_sql = $query_select_colums . $query_from . $from_narrow_by . $query_where . $and_narrow_by . $sql_order_by;

        if ($put_flag) {
            $all_listing_sql = "select products_id " . $query_from . $from_narrow_by . $query_where . $and_narrow_by;
            $all_products = $db->Execute($all_listing_sql);
        }

        $listing_split = new splitPageResults($listing_sql, $count, 'products_id', 'page');

        $get_products = $db->Execute($listing_split->sql_query);

        $products = array();
        if ($listing_split->number_of_rows < 1 || $_GET['page'] > $listing_split->number_of_pages) {
        } else {
            require_once(DIR_WS_CLASSES . 'fs_reviews.php');
            $fs_reviews = new fs_reviews();
            if ($get_products->RecordCount()) {
                $wholesale_products = fs_get_wholesale_products_array();
                while (!$get_products->EOF) {
                    $wholesale_products = fs_get_wholesale_products_array();
                    //$uPrice = phone_product_price_no_symbol($get_products->fields ['products_id'],$wholesaleproducts);

                    //$instocks = fs_products_instock_total_qty_of_products_id($get_products->fields ['products_id']);
                    //$stock_info = phone_get_product_stock($get_products->fields['products_id']);
                    //$image = app_proess_image($get_products->fields ['products_image']);
                    //$big_image = app_proess_image($get_products->fields ['products_image'], 550, 550);
                    $reviews_score = $fs_reviews->get_reviews_score($get_products->fields['products_id']);
                    $products[] = array(
                        'id' => $get_products->fields['products_id'],
                        'products_status' => $get_products->fields['products_status'],
                        'name' => zen_get_products_name($get_products->fields['products_id']),
                        'image' => $image,
                        'big_image' => $big_image,
                        'symbol_left' => $symbol_left,
                        //'currency_left' => zen_get_symbolLeft($_SESSION ['currency']),
                        'price' => $uPrice,
                        'sku' => $get_products->fields['products_SKU'] ? $get_products->fields['products_SKU'] : '',
                        'model' => $get_products->fields['products_model'],
                        'is_inquiry' => $get_products->fields['is_inquiry'],
                        'is_min_order_qty' => $get_products->fields['is_min_order_qty'] ? $get_products->fields['is_min_order_qty'] : '',
                        'wavelenght' => $get_products->fields['wavelenght'],
                        'distance' => $get_products->fields['distance'],
                        'data_rate' => $get_products->fields['data_rate'],
                        'stock' => $stock_info['stock'],
                        'instock' => $stock_info['instock'],
                        'reviews_score' => (string) $reviews_score
                    );
                    $get_products->MoveNext();
                }
            }

            /* update by melo */

            if ($put_flag) {
                $all_product = array();
                if ($all_products->RecordCount()) {
                    while (!$all_products->EOF) {
                        $all_product[] = array(
                            'id' => $all_products->fields['products_id']
                        );
                        $all_products->MoveNext();
                    }
                }
            }

            /* eof */
        }

        if ($put_flag) {

            // 筛选项
            $filter_arr = array();
            $temp_arr = array();

            if (3 > $count_of_cPath_array) {
                if (2 == sizeof($cPath_array)) {

                    if (zen_has_category_subcategories($cPath_array[1])) {
                        $categories = zen_get_subcategories_of_one_category($cPath_array[1]);

                        if ($cPath_array[1] == 1113) {
                            $temp_arr[] = array(
                                'cPath' => '1117',
                                'name' => zen_get_categories_name(1117)
                            );
                            $temp_arr[] = array(
                                'cPath' => '1116',
                                'name' => zen_get_categories_name(1116)
                            );
                            $temp_arr[] = array(
                                'cPath' => '1114',
                                'name' => zen_get_categories_name(1114)
                            );
                        }

                        foreach ($categories as $i => $cID) {
                            $temp_arr[] = array(
                                'cPath' => $cID,
                                'name' => zen_get_categories_name($cID)
                            );
                        }

                        if ($cPath_array[1] == 899) {
                            $temp_arr[] = array(
                                'cPath' => 1135,
                                'name' => zen_get_categories_name(1135)
                            );
                            $temp_arr[] = array(
                                'cPath' => 1140,
                                'name' => zen_get_categories_name(1140)
                            );
                        }
                        if ($cPath_array[1] == 959) {
                            $temp_arr[] = array(
                                'cPath' => 962,
                                'name' => zen_get_categories_name(962)
                            );
                            $temp_arr[] = array(
                                'cPath' => 964,
                                'name' => zen_get_categories_name(964)
                            );
                            $temp_arr[] = array(
                                'cPath' => 594,
                                'name' => zen_get_categories_name(594)
                            );
                        }
                    } else {
                        $categories = zen_get_subcategories_of_one_category($cPath_array[0]);
                        foreach ($categories as $i => $cID) {
                            $temp_arr[] = array(
                                'cPath' => $cID,
                                'name' => zen_get_categories_name($cID)
                            );
                        }
                    }

                    $filter_arr[] = array(
                        'title' => BOX_HEADING_CATEGORIES,
                        'data' => $temp_arr
                    );
                    // $filter_arr['data'] = $temp_arr ;
                }
            } else {

                // Categories
                if ($cPath_array[1] && zen_has_category_subcategories($cPath_array[1])) {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[1]);
                    foreach ($categories as $i => $cID) {
                        $temp_arr[] = array(
                            'cPath' => $cID,
                            'name' => zen_get_categories_name($cID)
                        );
                    }
                } else {
                    $temp_arr[] = array(
                        'cPath' => $cPath_array[1],
                        'name' => zen_get_categories_name($cPath_array[1])
                    );
                }

                $filter_arr[] = array(
                    'title' => 'Categories',
                    'data' => $temp_arr
                );

                $temp_arr = array();
                // Compatible Brands
                if ($cPath_array[0] == 9) {
                    $showName = 'Compatible Brands';
                } else {
                    $showName = 'Catagories';
                }

                if ($cPath_array[2] && zen_has_category_subcategories($cPath_array[2])) {
                    $categories = zen_get_subcategories_of_one_category($cPath_array[2]);
                    foreach ($categories as $i => $cID) {
                        $temp_arr[] = array(
                            'cPath' => $cID,
                            'name' => zen_get_categories_name($cID)
                        );
                    }

                    $filter_arr[] = array(
                        'title' => $showName,
                        'data' => $temp_arr
                    );
                }
            }

            if (!in_array($current_category_id, array(1, 3, 4, 9, 209, 999, 573, 904))) {
                if (!class_exists('products_narrow_by')) {
                    require DIR_WS_CLASSES . 'products_narrow_by.php';
                    $products_narrow_by = new products_narrow_by();
                }
                $c_pids = array();
                // $all_product
                if ($all_product) {
                    foreach ($all_product as $kk => $c_pro) {
                        $c_pids[] = $c_pro['id'];
                    }
                }

                if ($cPath_array[1] && !$cPath_array[2] && zen_has_category_subcategories($cPath_array[1])) {
                } else {
                    // echo
                    // $products_narrow_by->fs_products_narrow_by_list($current_category_id,$c_pids,$get_narrow);
                    // 当前已选择的筛选值代表的筛选项
                    if (is_array($get_narrow) && sizeof($get_narrow)) {
                        foreach ($get_narrow as $vn => $noID) {
                            $select_narrow_option_array[] = zen_get_narrow_by_option_id_of_values_id($noID);
                        }
                    }

                    if (sizeof($c_pids)) {
                        $category_options = $products_narrow_by->fs_category_products_narrow_option($c_pids, 'cpath', $current_category_id); // 分类产品拥有的筛选项
                        $narrow_by_options = $products_narrow_by->sort_order_narrow_by_options($category_options); // 筛选项排序
                    } else {
                        $narrow_by_options = array();
                    }

                    $trim = true;
                    // 筛选项循环
                    $get_narrow_option = array();
                    if (sizeof($get_narrow)) {
                        for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                            $get_narrow_option[] = $products_narrow_by->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
                        }
                    }

                    foreach ($narrow_by_options as $i => $oID) {

                        // 筛选项 头部 标题 title
                        // $products_narrow_by->get_products_narrow_by_option_name($oID)

                        $temp_title = $products_narrow_by->get_products_narrow_by_option_name($oID);
                        $temp_arr = array();

                        // $narrow_by_values =
                        // $products_narrow_by->fs_narrow_by_opions_values_by_oID_products($oID);
                        // //分类产品筛选项下的筛选值
                        // 筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏

                        $products_narrow_value = $products_narrow_by->fs_narrow_by_values_by_select_products($oID, $c_pids); // 当前产品,当前筛选项下拥有的筛选值
                        if (sizeof($products_narrow_value)) {

                            $narrow_by_values = $products_narrow_by->sort_order_narrow_by_values($products_narrow_value); // 筛选值排序
                            $nvi = 0;
                            $cDIV = false;
                            $hideNV = false;
                            foreach ($narrow_by_values as $ii => $vID) {

                                $name = $products_narrow_by->get_option_values_name($vID);

                                $url_narrow_by_part = $GLOBALS['seo_urls']->strip($GLOBALS['seo_urls']->get_narrow_by_option_value_name($vID)) . '=' . $vID;

                                $temp_arr[] = array(
                                    'cPath' => $current_category_id,
                                    'name' => $name,
                                    'narrow' => $url_narrow_by_part
                                );
                            }
                        }
                        // end of narrow values foreach
                        $filter_arr[] = array(
                            'title' => $temp_title,
                            'data' => $temp_arr
                        );
                    }
                }
            }
        }

        $retrun_arr['result'] = 'success';
        $retrun_arr['msg'] = '';

        if ($put_flag) {
            $retrun_arr['sort_order'] = array(
                'price',
                'priced',
                'rate',
                'new',
                'popularity'
            );
        }

        $type = $_GET['type'];
        switch ($type) {
            case 'filter':
                $data['filter'] = $filter_arr;
                echo json_encode($data);
                break;
            case 'products':
                $data['items'] = $products;
                echo json_encode($data);
                break;
            default:
                echo json_encode([
                    'code' => '400',
                    'msg' => 'Parameter Error'
                ]);
                break;
        }
        // $retrun_arr['category']['cPath'] = $current_category_id;
        // $retrun_arr['category']['name'] = zen_get_categories_name($current_category_id);
        // $retrun_arr['split_page']['number_of_rows'] = $listing_split->number_of_rows;
        // $retrun_arr['split_page']['number_of_pages'] = $listing_split->number_of_pages;
        // $retrun_arr['split_page']['current_page_number'] = $listing_split->current_page_number;
        // $retrun_arr['split_page']['number_of_rows_per_page'] = $listing_split->number_of_rows_per_page;

        // if ($put_flag) {
        //     $retrun_arr['filter'] = $filter_arr;
        // }
        // $retrun_arr['products'] = $products;
        // $_SESSION['cart']->store_contents();
        // $retrun_arr['cart_items'] = $_SESSION['cart']->count_contents();
        // //热搜关键字，每次随机返回5个
        // //$retrun_arr['search_hot'] = phone_get_hot_keywords();
        // echo json_encode($retrun_arr);
        break;

    case 'all_categories':
        $categories = [];
        $sql = "select c.categories_id,cd.categories_name from " . TABLE_CATEGORIES . " as c left join " .
            TABLE_CATEGORIES_DESCRIPTION  . " as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1
  		and cd.language_id = " . (int) $_SESSION['languages_id'] . "
  		and c.parent_id = 0
  		order by c.sort_order ";

        $result = $db->Execute($sql);
        if ($result->RecordCount()) {
            $count = 0;
            while (!$result->EOF) {
                $categories[] = [
                    'index' => $count,
                    'categories_id' => $result->fields['categories_id'],
                    'categories_name' => html_entity_decode($result->fields['categories_name'], ENT_QUOTES),
                ];
                $count++;
                $result->MoveNext();
            }
        }

        require_once(DIR_WS_CLASSES . '/fiberstore_category.php');
        foreach ($categories as $k => $category) {
            $sub_categories = [];
            $all_subs = fiberstore_category::get_subs_of_root_category($category['categories_id']);

            if ($all_subs['custom']) {
                for ($i = 0, $n = sizeof($all_subs) - 1; $i < $n; $i++) {
                    $third_categories = [];
                    $categories_custom_third = zen_get_categories_has_custom_display($all_subs[$i]['cid'], $level = 3);

                    if ($len = sizeof($categories_custom_third)) {
                        for ($l = 0; $l < $len; $l++) {
                            //说明自定义的三级分类有对应的产品三级分类
                            if ($categories_custom_third[$l]['categories_id']) {
                                $image = '';
                                if ($categories_custom_third[$l]['categories_of_image_app']) {
                                    $image = HTTPS_IMAGE_SERVER . $categories_custom_third[$l]['categories_of_image_app'];
                                }
                                $third_categories[] = [
                                    'cid' => $all_subs[$i]['categories_id'],
                                    'categories_id'    => $categories_custom_third[$l]['categories_id'],
                                    'categories_name'  => $categories_custom_third[$l]['name'],
                                    'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$categories_custom_third[$l]['categories_id'],
                                ];
                            } else {
                                //自定义分类不对应产品分类的，则根据分类链接来匹配产品分类的ID，然后来显示出这个分类的图片
                                $url = $categories_custom_third[$l]['url'];
                                $url = explode('?', $url);
                                $url = explode('-', $url[0]);
                                $id = end($url);
                                $query = $db->Execute("select categories_of_image_app from categories where categories_id=" . intval($id));
                                if ($query->fields['categories_of_image_app']) {
                                    $image = HTTPS_IMAGE_SERVER . $query->fields['categories_of_image_app'];
                                } else {
                                    $image = '';
                                }
                                $third_categories[] = [
                                    'cid' => $all_subs[$i]['categories_id'],
                                    'categories_id'    => $id,
                                    'categories_name'  => $categories_custom_third[$l]['name'],
                                    'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$categories_custom_third[$l]['categories_id'],
                                ];
                            }
                        }
                    } else {
                        $subs = fiberstore_category::get_second_categories($all_subs[$i]['categories_id']);
                        if (sizeof($subs)) {
                            foreach ($subs as $ii => $sub) {
                                $image = '';
                                if ($sub['categories_of_image_app']) {
                                    $image = HTTPS_IMAGE_SERVER . $sub['categories_of_image_app'];
                                }

                                $third_categories[] = [
                                    'categories_id'    => $sub['id'],
                                    'cid' => $all_subs[$i]['categories_id'],
                                    'categories_name'  => str_replace('&#39;', "'", $sub['name']),
                                    'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$sub['id'],
                                ];
                            }
                        }
                    }
                    array_unshift(
                        $third_categories,
                        [
                            'cid' => $all_subs[$i]['categories_id'],
                            'categories_id' => $all_subs[$i]['categories_id'],
                            'categories_name' => 'View All',
                            'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$all_subs[$i]['categories_id'],
                        ]
                    );
                    $sub_categories[] = [
                        'index' => $i,
                        'categories_id' => $all_subs[$i]['categories_id'],
                        //&#39; 表示html实体单引号
                        'categories_name' => str_replace('&#39;', "'", zen_get_categories_name($all_subs[$i]['categories_id'])),
                        'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$all_subs[$i]['categories_id'],
                        'subs' => $third_categories
                    ];
                }
            } else {
                for ($i = 0, $n = sizeof($all_subs); $i < $n; $i++) {
                    $third_categories = [];
                    $id = $all_subs[$i]['id'];
                    $name = $all_subs[$i]['name'];
                    $subs = $all_subs[$i]['subs'];
                    $res = $db->Execute("select cid from categories_left_display where categories_id=" . $id . " and language_id = " . (int) $_SESSION['languages_id']) . " and level=2";
                    $categories_custom_third = zen_get_categories_has_custom_display($res->fields['cid'], $level = 3);
                    if ($len = sizeof($categories_custom_third)) {
                        for ($l = 0; $l < $len; $l++) {
                            if ($categories_custom_third[$l]['categories_id']) {
                                $image = '';
                                if ($categories_custom_third[$l]['categories_of_image_app']) {
                                    $image = HTTPS_IMAGE_SERVER . $categories_custom_third[$l]['categories_of_image_app'];
                                }
                                $third_categories[] = [
                                    'categories_id' => $categories_custom_third[$l]['categories_id'],
                                    'cid' => $id,
                                    'categories_name'  => str_replace('&#39;', "'", $categories_custom_third[$l]['name']),
                                    'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$categories_custom_third[$l]['categories_id'],
                                ];
                            } else {
                                //自定义分类不对应产品分类的，则根据分类链接来匹配产品分类的ID，然后来显示出这个分类的图片
                                $url = $categories_custom_third[$l]['url'];
                                $url = explode('?', $url);
                                $url = explode('-', $url[0]);
                                $id = end($url);

                                $query = $db->Execute("select categories_of_image_app from categories where categories_id=" . intval($id));
                                if ($query->fields['categories_of_image_app']) {
                                    $image = HTTPS_IMAGE_SERVER . $query->fields['categories_of_image_app'];
                                } else {
                                    $image = '';
                                }

                                $third_categories[] = [
                                    'categories_id' => $id,
                                    'cid' => $id,
                                    'categories_name'  => $categories_custom_third[$l]['name'],
                                    'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$categories_custom_third[$l]['categories_id'],
                                ];
                            }
                        }
                    } else {
                        foreach ($subs as $ii => $sub) {
                            $image = '';
                            if ($sub['categories_of_image_app']) {
                                $image = HTTPS_IMAGE_SERVER . $sub['categories_of_image_app'];
                            }

                            $third_categories[] = [
                                'categories_id' => $sub['id'],
                                'cid' => $id,
                                'categories_name'  => str_replace('&#39;', "'", $sub['name']),
                                'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$sub['id'],
                            ];
                        }
                    }
                    array_unshift(
                        $third_categories,
                        [
                            'cid' => $id,
                            'categories_id' => $id,
                            'categories_name' => 'View All',
                            'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$id,
                        ]
                    );
                    $sub_categories[] = [
                        'index' => $i,
                        'categories_id' => $id,
                        'categories_name' => str_replace('&#39;', "'", $name),
                        'categories_url' => HTTPS_SERVER.'/amp_list_page.php?cPath='.$id,
                        'subs' => $third_categories,
                    ];
                }
            }

            foreach ($sub_categories as $sub_category_key => $sub_category_value) {
                if ($sub_category_value['id'] == 3915) {
                    unset($sub_categories[$sub_category_key]);
                } else {
                    $sub_categories[$sub_category_key] = $sub_category_value;
                }
            }

            $category['second_categories'] = $sub_categories;

            $categories[$k] = $category;
        }
        $return_arr = [
            'items' => $categories,
        ];
        echo json_encode($return_arr);
        break;

    case 'total_cart_items':
        $return_arr['cart_items'] = $_SESSION['cart']->count_contents();
        echo json_encode($return_arr);
        break;

    case 'products_list':
        if (!(isset($current_category_id) && is_numeric($current_category_id) && $current_category_id > 0)) {
            echo json_encode('Parameter Wrong');
            exit();
        }

        // 引入这个文件专门来取products得数据
        // require_once(DIR_WS_INCLUDES . zen_get_index_filters_directory('default_filter.php'));

        // 类
        require_once DIR_WS_CLASSES . 'shipping_info.php';
        require_once DIR_WS_CLASSES . 'fs_reviews.php';
        $fs_reviews = new fs_reviews();

        //常量
        if (isMobile()) {
            define('CATEGORY_M_REDIS_KEY_PREFIX', $_SESSION['languages_code'] . '_m_category_' . trim($_GET['cPath']) . ':');
            define('CATEGORY_M_ALL_REDIS_KEY_PREFIX', $_SESSION['languages_code'] . '_m_category_' . trim($_GET['cPath']) . '_all:');
        } else {
            define('CATEGORY_REDIS_KEY_PREFIX', $_SESSION['languages_code'] . '_category_' . trim($_GET['cPath']) . ':');
            define('CATEGORY_ALL_REDIS_KEY_PREFIX', $_SESSION['languages_code'] . '_category_' . trim($_GET['cPath']) . '_all:');
        }


        //获取当前国家对应的发货仓库
        $warehouse_data = fs_products_warehouse_where();
        $warehouse_where = $warehouse_data['where'];
        $warehouse_code = $warehouse_data['code'];

        // 获取勾选的筛选项数组、网址等
        $get_narrow = array();
        $products_narrow_by_option_values_ids = array();
        $narrow_url = '';
        $unarrowGET = array('_requestConfirmationToken', 'cPath', 'main_page', 'page', 'sort', 'type', 'count', 'settab');
        foreach ($_GET as $getname => $getvalue) {
            if (!in_array($getname, $unarrowGET)) {
                if ($getvalue && is_numeric($getvalue)) {
                    $get_narrow[] = $getvalue;
                    $narrow_url .= '&narrow[]=' . $getvalue;
                    $narrow_arr[$getname] = $getvalue;
                }
            }
        }
        $products_narrow_by_option_values_ids = $get_narrow;


        // 获取筛选项的sql 条件
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
                $and_narrow_by =  " AND p.products_id in(" . $where_narrow_by . ")";
            }
        }


        // 分组，排序
        $sql_order_by = ' group by p.products_id  ORDER BY p.products_sort_order asc ';
        if (isset($_GET['sort_order']) && $_GET['sort_order']) {
            switch ($_GET['sort_order']) {
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
            //查找当前分类下的所有子分类调用redis缓存函数
            zen_get_subcategories_redis($all_subcategories_ids, $current_category_id, $where_clearing);
            $all_subcategories_ids[] = $current_category_id;
            $all_subcategories_ids = array_unique($all_subcategories_ids);
            $count_of_subcategories = sizeof($all_subcategories_ids);
            if ($count_of_subcategories) {
                if (1 < $count_of_subcategories) {
                    $category_where_sql = " and ptc.categories_id in(" . join(',', $all_subcategories_ids) . ")";
                } else if (1 == $count_of_subcategories) {
                    $category_where_sql = " and ptc.categories_id = " . $all_subcategories_ids[0];
                }
            } else {
                $category_where_sql = " and ptc.categories_id = " . (int)$current_category_id;
            }
        } else {
            $category_where_sql = " and ptc.categories_id = " . (int)$current_category_id;
        }

        // 查询的字段
        $query_select_colums = " select p.products_id,p.integer_state,p.products_image,p.products_price ,p.products_model, is_inquiry, is_min_order_qty, new_products_tag, new_products_time,ptc.categories_id";

        // 基本sql
        $query_from = " from " . TABLE_PRODUCTS . " AS p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc using(products_id)";

        //p.is_categories_show 该字段限制该产品是否展示在该分类列表页面，为1展示，为0不展示
        $cPath_array = (array_reverse(get_category_parent_id($current_category_id, array())));
        if (count($cPath_array) == 4) {
            //四级分类隐藏的也展示
            //原因：三级分类会展示4级分类的筛选，产品部门要求全部展示4级分类的筛选。如果不去掉隐藏id的话，会出现很多空链接
            $show_hide_where = '';
        } else {
            /*产品在对应分类下隐藏,当一个产品属于两个分类时要求一个分类下展示，另一个隐藏，所以在products_to_categories表中新增了is_show字段，之前的products表中的is_categories_show字段弃用*/
            $show_hide_where = ' AND ptc.is_show=1 ';
        }
        $query_where = " WHERE p.is_important!=10 and p.products_status = 1 and (p.products_price >0 || is_inquiry =1) " . $show_hide_where . $warehouse_where . $category_where_sql;


        // 根据评价排序
        if ($_GET['sort_order'] == 'rate') {
            $query_select_colums .= ",count(rd.reviews_id) as rating ";
            $query_from .= " left join reviews as r using(products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
        }

        $listing_sql = $query_select_colums . $query_from . $from_narrow_by . $query_where . $and_narrow_by . $sql_order_by;

        //前台筛选条件
        $count = 200;
        if (isset($_GET['count']) && intval($_GET['count'])) $count = intval($_GET['count']);
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

        //if($current_category_id==57){
        //var_dump($listing_split);
        //}

        // redis 缓存
        $listing_sql_md5 = md5($listing_split->sql_query . $_SESSION['currency'] . $SESSION['countries_iso_code'] . $count, true);
        if (isMobile()) {
            $products = get_redis_key_value($listing_sql_md5, CATEGORY_M_REDIS_KEY_PREFIX);
        } else {
            $products = get_redis_key_value($listing_sql_md5, CATEGORY_REDIS_KEY_PREFIX);
        }
        if ($listing_split->number_of_rows < 1) $no_products = true;
        else {
            require_once(DIR_WS_CLASSES . 'fs_reviews.php');
            $fs_reviews = new fs_reviews();
            require_once(DIR_WS_CLASSES . 'productRelatedAttributesModel.php');
            $productRelatedAttributesModel = new productRelatedAttributesModel();
            require_once DIR_WS_CLASSES . 'shipping_info.php';

            if (!$products) {
                $products = $db->getAll($listing_split->sql_query);
                if ($products) {
                    foreach ($products as $key => $val) {
                        $products[$key] = get_product_list_other_data($val);
                    }
                    if (isMobile()) {
                        set_redis_key_value($listing_sql_md5, $products, 24 * 3600, CATEGORY_M_REDIS_KEY_PREFIX);
                    } else {
                        set_redis_key_value($listing_sql_md5, $products, 24 * 3600, CATEGORY_REDIS_KEY_PREFIX);
                    }
                }
            }

            //分页的跳转链接
            $params_for_categories_split = zen_get_all_get_params(array('page', 'count', 'settab'));
            if (isset($current_category_id))
                $params_for_categories_split = zen_get_all_get_params(array('page', 'cPath', 'count', 'settab')) . '&cPath=' . $current_category_id;

            if (!(isset($_GET['sort_order']) && $_GET['sort_order'])) {
                $params_for_categories_split .= '&sort_order=popularity';
            }
            //筛选列表产品有无库存 暂时不调取了
            if (!(isset($_GET['get_qty']) && $_GET['get_qty'])) {
                $get_qty = 1;
            } else {
                $get_qty = $_GET['get_qty'];
                $getUri = '?get_qty=' . $_GET['get_qty'];
            }
            $params_for_categories_split .= $narrow_url;

            $params_for_categories_split .= '&count=' . $count . '&settab=' . $settab;

            $page_links = $listing_split->display_links_listing_new(1, $params_for_categories_split);
            $page_top_links = $page_links;

            $page_jump_links = zen_href_link($_GET['main_page'], $params_for_categories_split);

            // 获取所有产品id
            /* update by melo */
            $all_listing_sql = "select products_id " . $query_from . $from_narrow_by . $query_where . $and_narrow_by;

            $listing_sql_key = md5($all_listing_sql . $_SESSION['currency'] . $SESSION['countries_iso_code'] . $count, true);
            if (isMobile()) {
                $products_data_key = get_redis_key_value($listing_sql_key, CATEGORY_M_ALL_REDIS_KEY_PREFIX);
            } else {
                $products_data_key = get_redis_key_value($listing_sql_key, CATEGORY_ALL_REDIS_KEY_PREFIX);
            }
            if ($products_data_key) {
                $all_products_data = $products_data_key;
            } else {
                $all_products_data = $db->Execute($all_listing_sql);
            }

            if (!$products_data_key) {
                $all_product = array();
                if ($all_products_data->RecordCount()) {
                    while (!$all_products_data->EOF) {
                        $all_product[] = array(
                            'id'  => $all_products_data->fields['products_id'],
                        );
                        $all_products_data->MoveNext();
                    }
                    if (isMobile()) {
                        set_redis_key_value($listing_sql_key, $all_product, 24 * 3600, CATEGORY_M_ALL_REDIS_KEY_PREFIX);
                    } else {
                        set_redis_key_value($listing_sql_key, $all_product, 24 * 3600, CATEGORY_ALL_REDIS_KEY_PREFIX);
                    }
                }
            } else {
                $all_product = $all_products_data;
            }
            /* eof */

            if ($_GET['type']) {
                zen_redirect(zen_href_link('index', 'cPath=' . $current_category_id));
            }
        }

        // 产品related_model


        // 加入标签数据
        foreach ($products as $p => $product) {
            $label_data = get_label_list_amp($product);
            $related_model = get_related_model_amp($product);
            $related_model_arr = [];
            if ($related_model) {
                $count = count($related_model['product_list']);
                if ($count <= 2) {
                    $n = 1;
                    foreach ($related_model['product_list'] as $o => $related_product) {
                        $related_model_arr[] = [
                            'title' => $related_product['attribute_val_str'],
                            'products_id' => $related_product['product_id'],
                            'bg' => 1,
                        ];
                        $n++;
                    }
                } else {
                    $related_products = array_values($related_model['product_list']);
                    $related_model_arr = [
                        [
                            'title' => $related_products[0]['attribute_val_str'],
                            'products_id' =>  $related_products[0]['product_id'],
                            'bg' => 1,
                        ],
                        [
                            'title' => "+" . ($count - 1),
                            'products_id' =>  $related_products[1]['product_id'],
                            'bg' => 2,
                        ]
                    ];
                }
            }

            //产品库存部分
            $shippingInfo = new shippingInfo(array('pid' => $product['id'], "current_category" => $product['category_arr'], "is_set_custome_tag" => $product['is_not_custom_str']));
            $shippingInfo->pure_price = $product['products_price_str'];
            $products_instock_info = $shippingInfo->showIntockDate($product['is_not_custom_str'], 1, $product['products_price_str']);
            $instock = explode("</div>", $products_instock_info);
            $warehouse = explode('</span>', $instock[0]);

            $products[$p]['secondary_label'] = $label_data['secondary_label'];
            $products[$p]['primary_label'] = is_array($label_data['primary_label']) ? implode(' / ', $label_data['primary_label']) : '';
            $products[$p]['products_review_number'] = $fs_reviews->get_nums_reviews($product['id'], '');
            $products[$p]['products_review_score'] = $fs_reviews->get_reviews_score($product['id']);
            $products[$p]['products_image'] = HTTPS_IMAGE_SERVER . 'images/' . $product['products_image'];
            $products[$p]['image_str'] = get_img_src_amp($product['image_str']);
            $products[$p]['is_youtube_video'] = preg_match('/youtube/i', $product['list_video']) ? true : false;
            $products[$p]['related_mode'] = $related_model_arr;
            $products[$p]['instock'] = strip_tags($warehouse[0]);
            $products[$p]['warehouse'] = strip_tags($warehouse[1]);
            $products[$p]['expected_time'] = strip_tags($instock[1]);

            //去掉不需要得字段
            unset($products[$p]['products_review_str']);
        }

        $page = $_GET['page'] ? $_GET['page'] : 1;
        if ($page > $listing_split->number_of_pages) {
            $next = '';
        } else {
            $next = '/amp_categories.php?action=products_list&cPath=' . $current_category_id . '&page=' . ($page + 1);
        }

        $return_arr = [
            'items' => $products,
            // 'next' => $next,
        ];
        echo json_encode($return_arr);
        exit();
        break;
}
