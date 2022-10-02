<?php
// 分割关键字
function explode_keyword_new($keyword,$length=''){
    $replace_keyword = str_replace('+', ' ', $keyword);
    $replace_keyword = str_replace('-', ' ', $replace_keyword);
    $replace_keyword = str_replace('=', ' ',$replace_keyword);
    $replace_keyword = str_replace('from', ' ', $replace_keyword);
    $words = array(
        'str' => '',
        'arr' => array()
    );
    if($replace_keyword){ //处理之后仍然有值
        $words = explode(" ",$replace_keyword);
        if($length && sizeof($words) >= $length){
            $words = array_slice($words,0,$length);
        }
        $words['arr'] = $words;
    }

    return $words;
}

// 屏蔽特殊符号
function arrange_keyword_new($keyword){
    if ($keyword === ''  || preg_match('/^(#*( )*)*$/',$keyword)){ //如果是全部是#，空格
        $keyword = '';
    }else{
        $keyword = preg_replace('/\+|\,|select|SELECT|insert|update|delete|union|into|load_file|outfile|SLEEP|sleep|\/|\$|\^|\(|\)|\[|\]|\{|\}|\?|\'|\"|\%|\|/i',' ',$keyword);
        $keyword = str_replace('\\','',$keyword);
    }
    return $keyword;
}

//获取相关搜索词
function search_relate_keywords_new($keyword,$connector ='and'){
    global $db;

    $words = explode_keyword_new($keyword);
    $replace_keyword = $words['str'];
    $words = $words['arr'];
    $words_count = sizeof($words);

    $relate_key = array();
    $where = '';
    if($words_count==1){
        $words[0] = mysql_regexp_transfer($words[0]);
        if( $words[0] ){
            $where .= ' and (tag_keywords regexp "'.$words[0].'") ';
        }
    }elseif($words_count>1){
        $more_where = '';
        foreach($words as $k=>$v){
            $v_regexp = mysql_regexp_transfer($v);
            if(!empty($v_regexp)){
                if(!$more_where){
                    $more_where .= ' ( ';
                }else{
                    $more_where .=' '.$connector.' ';
                }
                $more_where .= ' tag_keywords regexp "'.$v_regexp.'" ';
            }
        }
        if($more_where){
            $where .=  ' and '.$more_where.') ';
        }
    }

    //找出和当前搜索匹配的一个
    if(!empty($replace_keyword)){
        $sql = 'select products_tag as id from products_tags where tag_keywords regexp "'.mysql_regexp_transfer($replace_keyword).'" limit 1';
        $result = $db->Execute($sql);
        $keyword_like_id = $result->fields['id'];
        if($keyword_like_id){
            $where .= ' and products_tag != '.(int)$keyword_like_id;
        }
    }

    $relate_key_all = array();
    $key_relate_sql = 'select products_tag as id,tag_keywords as keywords,tag_url from products_tags where 1 '.$where .' limit 0,100';
    $result = $db->Execute($key_relate_sql);
    if($result->RecordCount()){
        while (!$result->EOF){
            $relate_key_all[$result->fields['keywords']] = array(
                'keywords' => $result->fields['keywords'],
                'id' => $result->fields['id'],
                'tag_url' => $result->fields['tag_url'],
            );
            $result->MoveNext();
        }
    }
    if(!empty($relate_key_all)){
        if(sizeof($relate_key_all)>5){
            $new_relate_key = array();
            $relate_key = array_rand($relate_key_all,5);
            foreach ($relate_key as $val){
                $new_relate_key[$val] = $relate_key_all[$val];
            }
        }else{
            $new_relate_key = $relate_key_all;
        }
        $keywords_arr = array();
        foreach ($new_relate_key as $relate_key_one) {
            $keywords_arr[] = $relate_key_one['keywords'];
        }
        array_multisort($keywords_arr, SORT_ASC, $new_relate_key);
        return $new_relate_key;
    }elseif($connector='or'){
        return $relate_key_all;
    }else{
        return search_relate_keywords($keyword,$connector ='or');
    }
}

// 获取amazon搜索的所有的产品，方便左边筛选项使用
// 并设置缓存
function get_amazon_search_all_products($keyword,$get_narrow){
    if($get_narrow){
        $get_narrow_redis = implode(',',$get_narrow);
    }
    $all_products_key = $keyword.$get_narrow_redis.$_SESSION['currency'].$_SESSION['countries_iso_code'];
    $all_products_data = get_redis_key_value($all_products_key,AMAZON_SEARCH_ALL_REDIS_KEY_PREFIX);
    if($all_products_data){
        $all_search_product = $all_products_data;
    }else{ //echo '亚马逊搜索全部-没有缓存<br/>';
        $all_search_product = array();    //所有产品
        $all_pro_cloud = zen_get_search_products_from_amazon_cloud_search($keyword, $get_narrow);
        foreach ($all_pro_cloud['data'] as $key => $value) {
            $all_search_product [] = $value['fields']['products_id'][0];
        }
        set_redis_key_value($all_products_key,$all_search_product,0,AMAZON_SEARCH_ALL_REDIS_KEY_PREFIX); // 不需要每天更新redis，上传产品到亚马逊时候更新
    }
    return $all_search_product;
}

// 获取原来的搜索的所有的产品，方便左边筛选项使用
// 并设置缓存
function get_old_search_all_products($keyword,$words,$key_array,$get_narrow){
    global $db;
    $all_listing_sql = zen_get_search_products_of_keywords($keyword,$words,$key_array,$get_narrow);
    // F/N码判断,将$listing_sql还原为字符串，并添加新的产品id判断条件 Bona.guo 2020/11/19 11:47
    if (is_array($all_listing_sql)) {
        $all_listing_sql = $all_listing_sql[0];
    }

        $listing_sql_key = $all_listing_sql.$_SESSION['currency'].$_SESSION['countries_iso_code'];
    $all_products_data = get_redis_key_value($listing_sql_key,SEARCH_ALL_REDIS_KEY_PREFIX);
    if($all_products_data){
        $all_search_product = $all_products_data;
    }else{ //echo '普通搜索全部-没有缓存<br/>';
        $all_products = $db->Execute($all_listing_sql);
        $all_search_product = array();    //所有产品
        if ($all_products->RecordCount()){
            while (!$all_products->EOF){
                $all_search_product [] = $all_products->fields['products_id'];
                $all_products->MoveNext();
            }
            set_redis_key_value($listing_sql_key,$all_search_product,24*3600,SEARCH_ALL_REDIS_KEY_PREFIX);
        }
    }
    return $all_search_product;
}
//end of new search

/**
 * 将搜索的所有产品ID放到一个数组中，并存入redis
 * @param $keyword
 * @param $words
 * @param $key_array
 * @param $get_narrow
 * @return array|string
 */
function get_old_search_all_products_v2($keyword, $words, $key_array, $get_narrow)
{
    global $db;

    //获取数据
    $all_listing_sql = zen_get_search_products_of_keywords_v2($keyword, $words, $key_array, $get_narrow);

    // F/N码判断,将$listing_sql还原为字符串，并添加新的产品id判断条件 Bona.guo 2020/11/19 11:47
    if (is_array($all_listing_sql)) {
        $all_listing_sql = $all_listing_sql[0];
    }

    $listing_sql_key = $all_listing_sql.$_SESSION['currency'].$_SESSION['countries_iso_code'];
    $all_products_data = get_redis_key_value($listing_sql_key,SEARCH_ALL_REDIS_KEY_PREFIX);
    if($all_products_data){
        $all_search_product = $all_products_data;
    }else{

        $all_products = $db->Execute($all_listing_sql);
        //所有产品
        $all_search_product = array();
        if ($all_products->RecordCount()){
            while (!$all_products->EOF){
                $all_search_product[] = $all_products->fields['products_id'];
                $all_products->MoveNext();
            }
            set_redis_key_value($listing_sql_key, $all_search_product,24*3600,SEARCH_ALL_REDIS_KEY_PREFIX);
        }
    }


    return $all_search_product;
}

/**
 * 返回所有的产品ID
 * @param $listing_sql
 * @return array|string
 */
function get_all_search_products_ids_v2($listing_sql)
{
    global $db;

    if (empty($listing_sql)) {
        return array();
    }

    //redis的key
    $listing_sql_key = $listing_sql.$_SESSION['currency'].$_SESSION['countries_iso_code'];

    $products_ids = get_redis_key_value($listing_sql_key,SEARCH_ALL_REDIS_KEY_PREFIX);

    if (empty($products_ids)) {
        $query = $db->Execute($listing_sql);
        //所有产品的产品ID
        $products_ids = array();
        if ($query->RecordCount()){
            while (!$query->EOF){
                $products_ids[] = $query->fields['products_id'];
                $query->MoveNext();
            }
            set_redis_key_value($listing_sql_key, $products_ids,24*3600,SEARCH_ALL_REDIS_KEY_PREFIX);
        }
    }

    return $products_ids;
}

?>