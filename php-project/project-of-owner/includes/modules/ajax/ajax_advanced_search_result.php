<?php

use App\Services\CaseStudies\CaseStudiesService;

$action = isset($_GET['ajax_request_action']) ? zen_db_prepare_input($_GET['ajax_request_action']) : '';

if ($_GET['ajax_request_action'] == "get_case") {

    if ($_POST['keyword']) {
        $keyword = $_POST['keyword'];
        $type = $_POST['type'] ? $_POST['type'] : "";
        $doc_case_type_arr = array(
            1 => array(
                'id' => 1,
                'text' => CASE_STUDIES_10
            ),
            2 => array(
                'id' => 2,
                'text' => CASE_STUDIES_11
            ),
            3 => array(
                'id' => 3,
                'text' => CASE_STUDIES_12
            )
        );
        $categories_code = 'case_studies';
        $doc_categories_id = fs_get_data_from_db_fields('doc_categories_id', 'doc_categories_description', 'language_id = "' . $_SESSION['languages_id'] . '" and categories_code = "' . $categories_code . '"', '');
        $case_studies = new CaseStudiesService();
        $studies_data = $case_studies->keywordsThematicSearch($keyword, $doc_categories_id, $type);
        $case_studies_html = "";

        if (sizeof($studies_data)) {
            foreach ($studies_data as $k => $v) {
                $case_studies_html .= '<li>
                                 <div class="serch_solution_imgBox">
                                     <a href="' . $code . '/' . $v['href_link'] . '" target="_blank"><img src="' . $v['image'] . '" width="80"></a>
                                 </div>
                                 <p class="serch_solution_txt"><a href="' . $code . '/' . $v['href_link'] . '" target="_blank">' . $v['title'] . '</a></p>
                              </li>';
            }
        }
        if ($case_studies_html) {
            echo json_encode(array('status' => 1, 'html' => $case_studies_html));
        } else {
            echo json_encode(array('status' => 2, 'html' => ""));
        }
    }
}elseif($_GET['ajax_request_action'] == "get_news"){
    if ($_POST['keyword']) {
        $category_name = $_POST['category_name'] ? $_POST['category_name'] : "all";
        $news_data = [
            'keyword' => $_POST['keyword'],
            'category_name' => $category_name,
            'page' => 1
        ];
        $news_html = "";

        try {
            if($_SESSION['languages_code']!='en'){
                $news_arr = curl_post($news_data, "https://community.fs.com/".$_SESSION['languages_code']."/api/getNews");
            }else{
                $news_arr = curl_post($news_data, "https://community.fs.com/api/getNews");
            }
            if ($news_arr['data']) {
                foreach ($news_arr['data'] as $kx => $vx) {
                    $href_link = 'https://community.fs.com/news/'.$vx['post_name'].'.html';
                    $image = $vx['post_detail']['guid'];
                    $news_html .= '<li>
                                 <div class="serch_solution_imgBox">
                                     <a href="' . $href_link . '" target="_blank"><img src="' . $image . '" width="80"></a>
                                 </div>
                                 <p class="serch_solution_txt"><a href="' . $href_link . '" target="_blank">' . $vx['post_title'] . '</a></p>
                              </li>';
                }
            }
        } catch (\Exception $e) {
            $news_arr = [];
        }
    }

    if ($news_html) {
        echo json_encode(array('status' => 1, 'html' => $news_html));
    } else {
        echo json_encode(array('status' => 2, 'html' => ""));
    }
}

//检测hot search的关键词是否有效
if ($action == 'check_hot_search_validate_word') {

    // 整理keyword
    $keyword =  isset($_GET['keyword']) ? zen_db_prepare_input($_GET['keyword']) : '';
    $keyword = strip_tags(trim($keyword));
    $final_keyword = $keyword; // 搜索结果展示的时候需要要用
    $keyword = arrange_keyword_new($keyword);

    if (empty($keyword)) {
        echo json_encode(array('code' => -1, 'msg' => 'keyword不能为空'));
        exit;
    }

    if (!empty($keyword) && strpos($keyword, '#') === 0) {
        //如果搜索 #36157，则是搜索36157
        $keyword = explode('#', $keyword)[1];
    }

    require_once DIR_WS_CLASSES . 'shipping_info.php';

    if (!class_exists('products_narrow_by')) {
        require DIR_WS_CLASSES . 'products_narrow_by.php';
        $products_narrow_by = new products_narrow_by();
    }

    // 获取相关的搜索词
    $relate_key_arr = search_relate_keywords_new($keyword);

    // 筛选项的处理
    $get_narrow = array();
    $narrow_url = '';
    $get_narrow_redis = '';
    $unarrowGET = array(
        'searchSubmit',
        'keyword',
        'main_page',
        'page',
        'sort',
        'style',
        'count',
        'Popular_id'
    );

    foreach ($_GET as $getname => $getvalue) {
        if (!in_array($getname, $unarrowGET)) {
            if ($getvalue && is_numeric($getvalue) || $getname == 'screen') {
                if ($getname == 'screen') {
                    $narrow = explode('-', $getvalue);
                    foreach ($narrow as $v) {
                        $get_narrow [] = $v;
                        $narrow_url .= '&narrow[]=' . $v;
                    }
                } else {
                    $get_narrow [] = $getvalue;
                    $narrow_url .= '&narrow[]=' . $getvalue;
                }
            }
        }
    }

    if ($get_narrow) {
        $get_narrow_redis = implode(',', $get_narrow);
    }

    // 用空格分割关键字
    $words = explode_keyword_new($keyword, 7);
    $words = $words['arr'];

    $key_array = array();

    $style = '';
    if (isset($_GET['style']) && $_GET['style']) {
        $style = $_GET['style'];
    }
    if (!in_array($style, array('list', 'images'))) {
        $style = 'images';
    }

    $order = trim($_GET['sort_order']);
    $count = (int)$_GET['count'] ? (int)$_GET['count'] : 24;
    $page  = (int)$_GET['page'] ? (int)$_GET['page'] : 1;

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
                $sql_order_by = "";
                break;
        }
    }

    require DIR_WS_CLASSES . 'advance_search_detech.php';
    $advance_search = new advance_search_detech();

    $listing_sql = zen_get_search_products_of_keywords($keyword, $words, $key_array, $get_narrow, $sql_order_by, true);
    $products_page_state = 1; //正常
    $is_show_attributes = false; //产品列表是否获取关联属性

    // F/N码判断,将$listing_sql还原为字符串，并添加新的产品id判断条件 Bona.guo 2020/11/19 11:47
    if (is_array($listing_sql)) {
        $listing_sql = $listing_sql[0];
        $is_fn = true;
    } else {
        $is_fn = false;
    }


    // 下线产品处理 start
    // 2018.05.22 fairy 下架产品采用另外方式展示
    //添加判断条件，$listing_sql若为数组表示$keyword部位产品id Bona.guo 2020/11/19 11:46
    if (is_numeric($keyword) && strlen($keyword) >= 5 && !$is_fn) { // 如果是产品id
        $offline_products = $db->getAll($listing_sql);
        if ($offline_products) {
            $offline_products = $offline_products[0];
            // 产品详情下线、搜索下线产品，2个地方要保持统一。fairy 2019.4.12 add
            //如果该产品的products_status字段或者对应的仓库状态字段[cn_status]为0则该产品不展示
            if (!$offline_products['products_status']) {
                if (offline_products_is_show_new_page($offline_products['products_id'])) {
                    $products_page_state = 3; //如果是符合条件的下架产品
                    $offline_page_data = get_offline_page_data($offline_products['products_id'], $offline_products['offline_replace_products_id']);
                    $offline_products = $offline_page_data['offline_products'];
                    $offline_replace_products = $offline_page_data['offline_replace_products'];
                } else {
                    $products_page_state = 2; //页面不存在
                }
            }
        }
    }

    // 下线产品处理 end
    $product_off_tpye = 1;
    if ($products_page_state != 1) {
        //如果是下架的产品
        $search_products_total_num = 0;
        $search_products_next_page = 1;
        $search_products_total_page = 0;
        $product_off_tpye = 0;
        echo json_encode(array('code' => 0, 'msg' => '没有相应的搜索结果'));
        exit;
    } else {
        $fs_result = new splitPageResults($listing_sql, $count, 'p.products_id', 'page');
        $search_products_total_num = $fs_result->number_of_rows;
        $search_products_next_page = $fs_result->current_page_number;
        $search_products_total_page = $fs_result->number_of_pages;
    }

    //搜索
    if ($search_products_total_num) {
        echo json_encode(array('code' => 1, 'msg' => '有相应的搜索结果'));
        exit;
    } else {
        echo json_encode(array('code' => 0, 'msg' => '没有相应的搜索结果'));
        exit;
    }
}

die;