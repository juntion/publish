<?php
require 'includes/application_top.php';
require DIR_WS_CLASSES . 'advance_search_detech.php';
$action = trim($_GET['action'])?trim($_GET['action']):'';
global $db;

// au、uk使用的是用于的数据
if($_SESSION['languages_code'] == 'au' || $_SESSION['languages_code'] == 'uk' || $_SESSION['languages_code'] == 'dn'){
    $search_words_languages_id = 1;
}else{
    $search_words_languages_id = $_SESSION['languages_id'];
}

require(DIR_WS_CLASSES . 'search_recommend.php'); //类或者方法
$search_recommend = new search_recommend();

switch ($action) {
    //添加统计次数
    case 'add_search_words_statistics':

        $click_search_words_id = (int)(zen_db_prepare_input($_POST['id']));
        $search_key = zen_db_prepare_input($_POST['search_key']);
        $updated_person = isset($_SESSION['customer_id'])?$_SESSION['customer_id']:'0';
        // 增加点击次数
        $sql = 'update fs_search_words set 
				click_times=click_times+1,
				click_rate_is_compute=0,
				updated_at=now(),
				updated_person='.$updated_person.' 
			where fs_search_id='.$click_search_words_id;
        $db->query($sql);

        exit(json_encode(array('status' => 1, 'info' => '', 'data' => '')));

        break;

    case 'remove_recent_search':

        $keyword = isset($_POST['keyword']) ? zen_db_prepare_input($_POST['keyword']) : '';

        //recent searches
        $recent_searches = isset($_COOKIE['recent_searches']) ? $_COOKIE['recent_searches'] : [];
        if (!empty($recent_searches)) {
            $recent_searches = json_decode($recent_searches, true);
        }

        $temp_index = -1;
        foreach ($recent_searches as $key=>$value) {
            if ($value == $keyword) {
                $temp_index = $key;
            } else {
                continue;
            }
        }
        if ($temp_index >= 0) {
            unset($recent_searches[$temp_index]);
        }

        setcookie('recent_searches', json_encode($recent_searches), 0, "", "", COOKIE_SECURE, COOKIE_HTTPONLY);

        $html_recent = '';
        if (count($recent_searches)) {
            foreach ($recent_searches as $key => $value) {
                $link = '?main_page=advanced_search_result&keyword='.$value.'&searchSubmit=Search';
                $html_recent .= '<a target="_blank" href="'.$link.'">'.$value.'<i class="iconfont icon" onclick="remove_recent_search(this, \''.$value.'\')"></i></a>';
            }
        }

        echo json_encode(array('code' => 1, 'data' => array('html_recent' => $html_recent, 'recent_searches' => $recent_searches)));
        exit;


    case 'get_hot_search':
        //获取热搜词的接口
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $per_page = 8;

        //计算总数
        $sql = "select count(*) as total from hot_search where language_id=".$search_words_languages_id." order by search_type asc,weight desc";
        $total = $db->Execute($sql);
        $total = $total->fields['total'];
        $total_page = ceil($total/$per_page);
        if ($total_page <= 1) {
            $total_page = 1;
        }

        if ($page > $total_page) {
            $page = 1;
        }

        //计算开始
        $start = ($page - 1) * $per_page;

        $sql = "select hot_search_id,search_word,weight,search_type from hot_search where language_id=".$search_words_languages_id." order by search_type asc,weight desc limit {$start},{$per_page}";
        $hot_searches = $db->getAll($sql);
        if (empty($hot_searches)) {
            $hot_searches = [];
        }

        $html = '';
        if (count($hot_searches)) {
            foreach ($hot_searches as $key => $value) {
                $value['link'] ='?main_page=advanced_search_result&keyword='.$value['search_word'].'&searchSubmit=Search';
                $html .= '<a target="_blank" data-page="'.$page.'" href="'.$value['link'].'">'.$value['search_word'].'</a>';

                $hot_searches[$key] = $value;

                //对展示的hot search的次数加1
                $db->Execute("update hot_search set show_times=show_times+1 where hot_search_id='".$value['hot_search_id']."' and language_id='".$search_words_languages_id."'");
            }
        }

        //recent searches
        $recent_searches = isset($_COOKIE['recent_searches']) ? $_COOKIE['recent_searches'] : [];
        if (!empty($recent_searches)) {
            $recent_searches = json_decode($recent_searches, true);
        }

        $html_recent = '';
        if (count($recent_searches)) {
            foreach ($recent_searches as $key => $value) {
                $link = '?main_page=advanced_search_result&keyword='.$value.'&searchSubmit=Search';
                $html_recent .= '<a target="_blank" href="'.$link.'">'.$value.'<i class="iconfont icon" onclick="remove_recent_search(this, \''.$value.'\')"></i></a>';
            }
        }


        echo json_encode(array('code' => 1, 'data' => array('html_recent' => $html_recent, 'html' => $html, 'hot_searches' => $hot_searches, 'total' => $total, 'page' => $page, 'total_page' => $total_page)));
        exit;

        break;

    case 'get_fs_search_words':

        $return_data = [];

        $search_key = isset($_POST["search_key"]) ? zen_db_prepare_input($_POST['search_key']) : '';
        $search_key = arrange_keyword_new($search_key);
        $keyword_arr        = explode(' ', $search_key);
        $keyword_arr        = array_filter($keyword_arr);
        array_unshift($keyword_arr, $keyword);

        //对用户输入的词进行处理停用词 (将用户输入的词过滤掉停用词再进行搜索,该停用词是在后台设置的)
        $sql = "select aw.abnormal_search_id,aw.abnormal_search_word,am.search_type,am.correct_search_word from abnormal_search_word_warehouse aw left join abnormal_search_manage am on aw.abnormal_search_id=am.abnormal_search_id where am.search_type=3 ";
        $result = $db->getAll($sql);
        if ($result) {
            $result = array_column($result, 'abnormal_search_word');
            if (count($result) > 1) {
                $pattern = '/';
                foreach ($result as $key => $value) {
                    if (strpos($value, '/') !== false || strpos($value, '|') !== false) {
                        $value = str_replace(array('/', '|'), array('\/', '\|'), $value);
                    }
                    if ($key == 0) {
                        $pattern .= '\b' . $value  . '\b';
                    } else {
                        $pattern .= '|' . '\b' . $value  . '\b';
                    }
                }
                $pattern .= '/';
            } else {
                if (strpos($result[0], '/') !== false || strpos($result[0], '|') !== false) {
                    $result[0] = str_replace(array('/', '|'), array('\/', '\|'), $result[0]);
                }
                $pattern = '/'.$result[0].'/';
            }
            $search_key = preg_replace($pattern, ' ', $search_key);
            $search_key = trim($search_key);

            $keyword_arr[] = $search_key;
        }


        $origin_keyword = $search_key;



        $search_key = $search_recommend->handle_search_key_for_recommend_v2($search_key);
        if ($search_key || $search_key === '0' || $search_key === 0) {
            $data = $search_recommend->get_search_recommend_list_v2($search_key, $search_words_languages_id);

            $count = count($data);

            if ($count > 0) {
                foreach ($data as $key => $value) {
                    $value['fs_search_words'] = strtolower($value['fs_search_words']);
                    $link = $value['fs_search_link'];
                    if (empty($link)) {
                        $link = '?main_page=advanced_search_result&keyword='.$value['fs_search_words'].'&searchSubmit=Search';
                    }
                    $return_data[] = array(
                        'id'     => $value['fs_search_id'],
                        'link'   => $link,
                        'name'   => $value['fs_search_words'],
                        'key'    => $value['fs_search_words'],
                        'type'   => 'fs_search_words'
                    );
                }

            } else {
                //查找近义词，纠错词, 停用词，

                //$sql = "select aw.abnormal_search_id,aw.abnormal_search_word,am.search_type,am.correct_search_word from abnormal_search_word_warehouse aw left join abnormal_search_manage am on aw.abnormal_search_id=am.abnormal_search_id where abnormal_search_word='".$origin_keyword."' order by instr('1,3,2',am.search_type) ";
                $sql = "select aw.abnormal_search_id,aw.abnormal_search_word,am.search_type,am.correct_search_word from abnormal_search_word_warehouse aw left join abnormal_search_manage am on aw.abnormal_search_id=am.abnormal_search_id where abnormal_search_word='".$origin_keyword."' order by instr('1,2',am.search_type) ";
                $result = $db->getAll($sql);

                $search_key_arr = [];
                if ($result) {
                    foreach ($result as $key => $value) {
                        if (!$value['correct_search_word']) {
                            continue;
                        }
                        $search_key_arr[] = $search_recommend->handle_search_key_for_recommend_v2($value['correct_search_word']);;
                        ////将先从词库里匹配的返回
                        //$link = '?main_page=advanced_search_result&keyword='.$value['correct_search_word'].'&searchSubmit=Search';
                        //$return_data[] = array(
                        //    'id'     => '',
                        //    'link'   => $link,
                        //    'name'   => $value['correct_search_word'],
                        //    'key'    => $value['search_type'],
                        //    'type'   => '1',
                        //);

                        $keyword_arr[] = substr($search_key, 0, strspn($search_key ^ $value['correct_search_word'], "\0"));
                    }
                }

                if (count($search_key_arr)) {
                    $data = $search_recommend->get_search_recommend_list_v2($search_key_arr, $search_words_languages_id);
                    if (count($data)) {
                        foreach ($data as $key => $value) {
                            $value['fs_search_words'] = strtolower($value['fs_search_words']);
                            $link = '?main_page=advanced_search_result&keyword='.$value['fs_search_words'].'&searchSubmit=Search';
                            $return_data[] = array(
                                'id'     => $value['fs_search_id'],
                                'link'   => $link,
                                'name'   => $value['fs_search_words'],
                                'key'    => $value['fs_search_words'],
                                'type'   => 'fs_search_words'
                            );
                        }
                    }
                }

            }
        }

        $html = '';
        if (count($return_data) >= 10) {
            $return_data = array_slice($return_data, 0, 10);
        }

        $updated_person = isset($_SESSION['customer_id'])?$_SESSION['customer_id']:'0';

        $keyword_pattern = '';
        if (count($keyword_arr) > 1) {
            foreach ($keyword_arr as $key => $value) {
                if ($value) {
                    $keyword_pattern .= $value . '|';
                }
            }

            $keyword_pattern = rtrim($keyword_pattern, '|');
            $keyword_pattern = '/('.$keyword_pattern.')/i';
        } else {
            $keyword_pattern = '/(' . $search_key . ')/i';
        }


        foreach ($return_data as $key => $value) {
            $link = $value['link'];
            $value['name'] = preg_replace($keyword_pattern, '<span>'.'$1'.'</span>', $value['name']);

            $html .= '<li onclick="add_search_words_statistics(this)" data-link="'.$link.'" data-type="'.$value['type'].'" data-id="'.$value['id'].'" data-search-key="'.$value['key'].'">';
            $html .= '<a   data-href="'.$link.'" href="'.$link.'" target="_blank">'.$value['name'].'</a>';
            $html .= '</li>';


            //给展示的词次数加1
            $sql = 'update fs_search_words set show_times=show_times+1, click_rate_is_compute=0,updated_at=now(),
					updated_person='.$updated_person.'
				where fs_search_id="'.intval($value['id']).'"';
            $db->query($sql);

        }

        exit(json_encode(array('status' => 1, 'info' => '', 'html' => $html, 'data' => $return_data)));

        break;

        //搜索v2   ---- 秦聪
    default :
        $str = '';
        $image="";
        $html="";
        $product_link="";

        /*判断是否为F/N码 Bona.guo 2020/11/19 14:44*/
        $advance_search = new advance_search_detech();
        $fn_check=$advance_search->search_level($_POST['search_key'], 2);
        //$fn_check=0;
        /*end Bona.guo 2020/11/19 14:44*/




        //匹配产品ID
        if(!empty($_POST['search_key']) && is_numeric($_POST['search_key']) &&!$fn_check&& in_array(strlen(zen_db_prepare_input($_POST['search_key'])),array(5,6))){
            //获取当前国家对应的发货仓库
            $warehouse_data = fs_products_warehouse_where();
            $warehouse_where = $warehouse_data['where'];
            $warehouse_fields = strtolower($warehouse_data['code']).'_status';
            $query_warehouse_column = ','.$warehouse_fields.' ';
            // 这里的sql语句不能加下线产品不显示的限制。因为下线产品也会显示，只不过显示推荐页面
            $sql = "select products_id,products_price,products_priced_by_attribute,products_status,offline_replace_products_id,products_leadtime,related_preorder_product_id,integer_state" . $query_warehouse_column . " 
          from " . TABLE_PRODUCTS . "
          where  products_id = '" . (int)$_POST['search_key'] . "' and show_type=0 ";
            $res = $db->Execute($sql);
            $products_page_state=0;
            if ($res->fields['products_status'] == 0 || !$res->fields[$warehouse_fields]) {  // $res->fields[$warehouse_fields]    de_status  德国仓是否开启
                if(offline_products_is_show_new_page((int)$_POST['search_key'],'categories_id' )){
                    $products_page_state = 3; //如果是符合条件的下架产品
                }
                if ($products_page_state==3 && $res->fields['offline_replace_products_id']) {
                    $product_link = zen_href_link('product_info','products_id='.(int)$res->fields['offline_replace_products_id'],'SSL');
                }else{
                    $product_link = zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT,'&keyword='.$_POST['search_key']);
                }
            }else{
                $product_link = zen_href_link('product_info','products_id='.(int)$_POST['search_key'],'SSL');
            }


            $product_name = zen_get_products_name($_POST['search_key']);
            $image = get_resources_img(intval(zen_db_prepare_input($_POST['search_key'])),'60','60',zen_get_products_name($_POST['search_key']),'','',' border="0" ');
            if($product_name){
                $html.='<ul><li class="select_input_search" data-link="'.$product_link.'" data-id="" data-search-key="'.(int)$_POST['search_key'].'">';
                if($products_page_state==3){
                    //下架产品
                    if($res->fields['offline_replace_products_id']){
                        if($_SESSION['languages_code']=='jp'){
                            $html.= '<div class="serch_downPro_txt">
                                   <strong>"'.$_POST['search_key'].'"</strong> '.FS_SEARCH_NEW_14.'"'.$res->fields['offline_replace_products_id'].'" '.FS_SEARCH_NEW_15.'
                            </div>';
                        }elseif($_SESSION['languages_code']=='de'){
                            $html.= '<div class="serch_downPro_txt">
                                 '.FS_SEARCH_NEW_13_1.' <strong>'.$_POST['search_key'].'</strong> '.FS_SEARCH_NEW_14.''.$res->fields['offline_replace_products_id'].' '.FS_SEARCH_NEW_15.'
                            </div>';
                        }else{
                            $html.= '<div class="serch_downPro_txt">
                                   <strong>"' . $_POST['search_key'] . '"</strong> '.FS_SEARCH_NEW_14.'"'.$res->fields['offline_replace_products_id'].'" '.FS_SEARCH_NEW_15.'
                            </div>';
                        }
                        $product_name = zen_get_products_name($res->fields['offline_replace_products_id']);
                    }else{
                        if($_SESSION['languages_code']=='jp') {
                            $html .= '<div class="serch_downPro_txt">
                               <strong>「' . $_POST['search_key'] . '」</strong> ' . FS_SEARCH_NEW_16 . '
                        </div>';
                        }elseif($_SESSION['languages_code']=='de'){
                            $html .= '<div class="serch_downPro_txt">
                               ' . FS_SEARCH_NEW_13_1 . ' <strong>' . $_POST['search_key'] . '</strong> ' . FS_SEARCH_NEW_16 . '
                        </div>';
                        }else{
                            $html .= '<div class="serch_downPro_txt">
                               <strong>"' . $_POST['search_key'] . '"</strong> ' . FS_SEARCH_NEW_16 . '
                        </div>';
                        }
                    }
                }

                if ($products_page_state==3 && $res->fields['offline_replace_products_id']) {
                    //下架推荐产品
                    $image  = zen_get_products_image(intval(zen_db_prepare_input($res->fields['offline_replace_products_id'])),'60','60');
                    $product_link = zen_href_link('product_info','products_id='.$res->fields['offline_replace_products_id'],'SSL');
                    $html.='<dl class="select_input_search_dl after">
                            <dt>
                                <a href="'.$product_link.'">'.str_replace('images/no_picture.gif','includes/templates/fiberstore/images/specials/sample_request/ypsq-sy-bg.jpg',$image).'</a>
                            </dt>
                            <dd>
                                <div class="select_input_search_flex">
                                    <div class="select_input_search_flex_content">
                                        <p class="select_input_search_tit" title="'.$product_name.'">'.$product_name.'</p>
                                        <p class="select_input_search_tit select_input_search_id">#<b>'.zen_db_prepare_input($res->fields['offline_replace_products_id']).'</b></p>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </li></ul>';
                }else{
                    //在线产品
                    $html.='<dl class="select_input_search_dl after">
                            <dt>
                                <a href="'.$product_link.'">'.str_replace('images/no_picture.gif','includes/templates/fiberstore/images/specials/sample_request/ypsq-sy-bg.jpg',$image).'</a>
                            </dt>
                            <dd>
                                <div class="select_input_search_flex">
                                    <div class="select_input_search_flex_content">
                                        <p class="select_input_search_tit" title="'.$product_name.'">'.$product_name.'</p>
                                        <p class="select_input_search_tit select_input_search_id">#<b>'.zen_db_prepare_input($_POST['search_key']).'</b></p>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </li></ul>';
                }
            }
            exit(json_encode(array('status' => 2, 'info' => '', 'data' =>'1','html'=> $html, 'type' => 'product')));
        }else{

            //匹配产品型号/关键词，这里与搜索结果页的查询方法一致
            $search_key = $search_recommend->handle_search_key_for_recommend($_POST["search_key"]);
            $words = explode_keyword_new($_POST["search_key"], 7);

            $words = $words['arr'];
            $get_narrow = array();
            $listing_sql = zen_get_search_products_of_keywords_new($_POST["search_key"], $words, array(), $get_narrow, " ORDER BY p.product_sales_num desc,p.products_sort_order asc limit 5");

            if (is_array($listing_sql)) {
                $listing_sql = $listing_sql[0];
            }


        $words = array_map('strtolower',$words);

        //关键词中含有 converter或transponder 时，置顶显示107365，Bona.guo 2020/12/18 18:10
        if(in_array('converter',$words)||in_array('transponder',$words)){
            $listing_sql = str_replace('ORDER BY ','ORDER BY p.products_id =107365 desc , ',$listing_sql);
        }

        //关键词中含有 switch 时，置顶显示 108710 108716，Bona.guo 2020/12/18 18:10
        if(in_array('switch',$words)){
            $listing_sql = str_replace('ORDER BY ','ORDER BY p.products_id in(108710,108716) desc , ',$listing_sql);
        }

        $products_info = $db->getAll($listing_sql);



            $is_Model = false;

            if(!empty($_POST["search_key"])){
                $is_Model = $db->Execute("select products_model from ".TABLE_PRODUCTS." where products_model ='".$_POST["search_key"]."' and products_status=1 and show_type = 0")->fields['products_model'];
            }

            if ($search_key){
                if(count($products_info) > 0) {
                    if ($products_info) {
                        $html .= '<ul>';
                        foreach ($products_info as $key => $val){
                            $products_info[$key]['link'] = zen_href_link('product_info','products_id='.$val['products_id']);
                            $product_name = zen_get_products_name($val['products_id']);
                            $img_src = $products_info[$key]['products_image']!=""? HTTPS_IMAGE_SERVER."images/".$products_info[$key]['products_image']:"".HTTPS_IMAGE_SERVER."includes/templates/fiberstore/images/specials/sample_request/ypsq-sy-bg.jpg";
                            $html .= '<li class="select_input_search" data-id="'.$products_info[$key]['fs_search_id'].'" data-search-key="'.$products_info[$key]['fs_search_words'].'" data-link="'.$products_info[$key]['link'].'">
                            <dl class="select_input_search_dl after">
                                <dt>
                                    <img src="'.$img_src.'" style="width: 60px;height: 60px;"alt="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/sample_request/ypsq-sy-bg.jpg">
                                </dt>
                                <dd>
                                    <div class="select_input_search_flex">
                                        <div class="select_input_search_flex_content">
                                            <p class="select_input_search_tit" title="'.$product_name.'">'.str_ireplace($_POST["search_key"],'<b>'.$_POST["search_key"].'</b>',$product_name).'</p>';
                            //型号名搜索
                            if($is_Model){
                                $html .= '<p class="select_input_search_tit select_input_search_id"><b>'.$is_Model.'</b></p>';
                            }
                            $html .='</div>
                                    </div>
                                </dd>
                            </dl>
                        </li>';
                        }
                        $html .= '</ul>';
                        $type=0;
                        if(isMobile()){
                            $type=1;
                        }else{
                            $type=0;
                        }
                        //查看更多搜索结果页按钮
                        if (count($products_info) > 1) {
                            $html .= '<div class="see_all_results">
                            <a href="javascript:;" onclick=see_results('.$type.');>
                            <span>'.FS_SEE_ALL_RESULTS.'</span>
                            <i class="iconfont icon">&#xf089;</i>
                            </a>
                         </div>';
                        }
                    }
                }
            }
            exit(json_encode(array('status' => 1, 'info' => '', 'html' => $html, 'type' => 'product')));
        }


        break;
}





?>