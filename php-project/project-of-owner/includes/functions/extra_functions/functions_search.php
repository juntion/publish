<?php
// mysql中使用regexp进行匹配之前，需要进行过滤
function mysql_regexp_transfer($str)
{
    $str = str_replace('+', '', $str);
    $str = str_replace('-', '', $str);
    //$str = str_replace('.','',$str);
    $str = str_replace('*', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace(',', '', $str);
    //匹配掉日语的括号
    $str = str_replace('（', ' ', $str);
    $str = str_replace('）', ' ', $str);
    if ($_SESSION['languages_code'] == 'jp') {
        //日语中长短音区别在于长音多一个后缀“ー” 有无“ー”都出相同的搜索结果
        $str_len = mb_strlen($str, 'UTF-8') - 1;
        if (mb_substr($str, $str_len, '1', 'utf-8') == 'ー' && strlen($str) > 1) {
            $str = mb_substr($str, '0', $str_len, 'utf-8');
        }
    }
    return $str;
}

function zen_get_subcategories_of_arr($categories)
{
    global $db;
    $all_categories = array();
    if (sizeof($categories) == 1) {
        $sql = "select categories_id from categories where parent_id=" . $categories[0];
        $p_category = $db->Execute($sql);
        if ($p_category->RecordCount() > 0) {
            while (!$p_category->EOF) {
                $all_categories [] = $p_category->fields['categories_id'];
                $p_category->MoveNext();;
            }
        } else {
            $all_categories [] = $categories[0];
        }
    } else {
        for ($i = 0; $i < sizeof($categories); $i++) {
            $sql = "select categories_id from categories where parent_id=" . $categories[$i];
            $p_category = $db->Execute($sql);
            if ($p_category->RecordCount() > 0) {
                while (!$p_category->EOF) {
                    $all_categories [] = $p_category->fields['categories_id'];
                    $p_category->MoveNext();;
                }
            } else {
                $all_categories [] = $categories[$i];
            }
        }
    }
    return $all_categories;
}

function zen_get_keywords_is_categories_tag($keyword)
{
    global $db;
    $csql = "select categories_id from category_search_tag where tag_keyword='" . $keyword . "' order by weight";
    $categories = $db->Execute($csql);
    $categories_arr = array();
    while (!$categories->EOF) {
        $categories_arr [] = $categories->fields['categories_id'];
        $categories->MoveNext();
    }
    $categories_arr = zen_get_subcategories_of_arr($categories_arr);
    return $categories_arr;
}

// 将数组中的元素  组成所有集
function getRank($arr, $len = 0, $str = "")
{
    global $arr_getrank;
    $arr_len = count($arr);
    if ($len == 0) {
        $arr_getrank[] = $str;
    } else {
        for ($i = 0; $i <= $arr_len; $i++) {
            $tmp = array_shift($arr);
            if (empty($str)) {
                getRank($arr, $len - 1, $tmp);
            } else {
                getRank($arr, $len - 1, $str . " " . $tmp);
            }
        }
    }
    return $tmp;
}

// 将数组中的元素  组成所有同位数集
function getRankArray($arr, $len = 0, $str = "")
{
    global $arr_getrank;
    $arr_len = count($arr);
    if ($len == 0) {
        $arr_getrank[] = $str;
    } else {
        for ($i = 0; $i <= $arr_len; $i++) {
            $tmp = $arr;
            if (empty($str)) {
                getRankArray($arr, $len, $tmp);
            } else {
                getRankArray($arr, $len, $str . " " . $tmp);
            }
        }
    }
    return $tmp;
}

// 去掉数组所有字符串元素两边的空格
function TrimArray($Input)
{
    if (!is_array($Input))
        return trim($Input);
    return array_map('TrimArray', $Input);
}

//数组 字符串中含有的空格来判断单词数量
function countspace($string)
{
    $num = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] == " " || $string[$i] == "　") {
            $num++;
        }
    }
    return $num;
}

//数组重新排序，单词递减
function sortByLen($a, $b)
{
    if (countspace($a) == countspace($b)) {
        return 0;
    } else {
        return (countspace($a) < countspace($b)) ? 1 : -1;
    }
}

function fs_input_search_keyword_reset($keyword)
{
    global $db;
    $reste_key = '';
    $array = explode(" ", $keyword);
    for ($i = 0; $i < sizeof($array); $i++) {
        $key = trim($array[$i]);
        if ($key) {
            $strsql = $db->Execute("select strword from search_replace_word where keyword ='" . $key . "' and language_id =" . $_SESSION['languages_id']);
            if ($strsql->fields['strword']) {
                $reste_key .= $key . "|" . $strsql->fields['strword'] . ' ';
            } else {
                $reste_key .= $key . ' ';
            }
        }
    }
    $reste_key = trim($reste_key);
    return $reste_key;
}

//关键词sql语句查询
function zen_get_keywords_sql_of_array($keyword)
{
    $keyword = strtolower($keyword);
    $keyword = str_replace('-', ' ', $keyword);
    $keyword = str_replace('+', ' ', $keyword);
    $keyword = str_replace('/', ' ', $keyword);
    $keyword = str_replace('（', ' ', $keyword);
    $keyword = str_replace('）', ' ', $keyword);
    $keyword = fs_input_search_keyword_reset($keyword);//处理后返回的关键词中的每两个单词中间只有一个空格
    $keyword = trim($keyword);
    $array = explode(" ", $keyword);
    $where_str = '';
    for ($i = 0; $i < sizeof($array); $i++) {
        $split_key = trim($array[$i]);
        $j = 0;
        $new_arr = explode("|", $split_key);
        foreach ($new_arr as $v) {
            //对负复数进行处理
            if (substr($v, -1) == 's' && strlen($v) > 2) {
                $v = substr($v, 0, -1);
                $v = str_replace("s ", "", $v);
                $v = trim($v);
            }
            //去掉单词中的+-*#符号
            $split_key_regexp = mysql_regexp_transfer($v);
            if ($split_key_regexp) {
                if (!$where_str) {
                    $where_str .= ' ';
                } elseif ($j > 0) {
                    $where_str .= ' or ';
                } else {
                    $where_str .= ' and ';
                }
                if ($j == 0 && sizeof($new_arr) > 1) {
                    $where_str .= ' ( ';
                }
                if (strpos($split_key, "-")) {
                    $where_str .= " CONCAT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(products_name,'/',' '),'+',' '),',',''),'\(',' '),'\)',' '),' ') REGEXP '" . $split_key_regexp . "'";   //如果关键词中有连接符,那么products_name 直接进行匹配
                } else {
                    $where_str .= " CONCAT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(products_name,'-',' '),'/',' '),'+',''),'\(',' '),'\)',' '),',',''),'*',''),' ') REGEXP '" . $split_key_regexp . "'"; //如果关键词中没有连接符,那么products_name 先过滤连接符,再匹配.
                }
                if ($j > 0) {
                    $where_str .= ')';
                }
            }
            $j++;
        }
    }
    $final_where_str = '';
    if ($where_str) {
        $final_where_str .= " and " . $where_str;
    }
    return $final_where_str;
}

//匹配关键词 搜索产品
//匹配关键词 搜索产品
function zen_get_search_products_of_keywords($keywords, $word, $key_array, $narrow, $sql_order_by = "", $is_warehouse_where = false)
{
    global $db;
    global $fsCurrentInquiryField;
    $keyword = preg_replace('/select|insert|update|delete|\'|\(|\)|$|^|%|"|\*|\=|union|into|load_file|outfile/i', '', $keywords);
    $keyword = trim($keyword);

    $advance_search = new advance_search_detech();
    //这里好像没用了，被liang.zhu  2020.12.29注释掉了
    //$categories_arr = zen_get_keywords_is_categories_tag($keyword);

    $ptc_where = ' ';

    $replace_keyword = str_replace('-', ' ', $keyword);
    $replace_keyword = str_replace('=', ' ', $replace_keyword);
    $replace_keyword = str_replace('/', ' ', $replace_keyword);
    $replace_keyword = str_replace('from', ' ', $replace_keyword);
    $replace_keyword = str_replace('（', ' ', $replace_keyword);
    $replace_keyword = str_replace('）', ' ', $replace_keyword);
    $words = explode(" ", $replace_keyword);

    //搜索筛选项
    $products_narrow_by_option_values_ids = array();

    if (isset($narrow) && is_array($narrow)) {
        foreach ($narrow as $key => $value) {
            $products_narrow_by_option_values_ids [] = (int)$value;
        }
    }

    $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
    $from_narrow_by = '';
    if (zen_not_null($products_narrow_by_option_values_ids)) {
        if (1 == $narrow_by_count) {
            $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp on p.products_id = povp.products_id";
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
                    $where_narrow_by .= ' inner JOIN';
                }
                $where_narrow_by .= $sql_query_array[$i];
                if ($i) {
                    $where_narrow_by .= " ON t" . ($i - 1) . ".products_id = t" . $i . ".products_id ";
                }
            }
            $and_narrow_by = " AND p.products_id in(" . $where_narrow_by . ") ";
        }
    }
    //end 筛选项


    //获取当前国家对应的发货仓库状态字段
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_fields = strtolower($warehouse_data['code']) . '_status';
    $query_warehouse_column = ',' . $warehouse_fields . ' ';
    if ($is_warehouse_where) {
        $warehouse_where = ' ';
    } else {
        $warehouse_where = $warehouse_data['where'];
    }

    // var_dump($keyword);
    /* when search is SKU of product */
    $software_from = ' LEFT JOIN products_composite AS pcom ON ( p.products_id=pcom.products_id ) ';
    if (is_numeric($keyword) && strlen($keyword) >= 5) {  //判断用户输入的是产品ID

        /**
         *为了解决输入5位数字的F/N码时，和产品id重合的问题，先判断$keyword是否为F/N码 Bona.guo 2020/11/19 11:32
         */
        if ($advance_search->search_level($keyword, 2)) {
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_colums = "";
            $query_from = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_colums = ",count(rd.reviews_id) as rating ";
                $query_from = " left join reviews as r  on(r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
            }
            /*
                 * 优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
                 * */

            $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
            $keyword = preg_replace($pattern, '', $keyword);
            $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";
            //$listing_sql = "select  p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $from_narrow_by . $query_from . $software_from . "
            //	where p.products_status = 1
            //	and p.show_type = 0
            //	" . $and_str . $and_narrow_by . $warehouse_where . $sql_order_by;


            $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.{$fsCurrentInquiryField} as is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) " . $from_narrow_by . $query_from . $software_from . "
					where p.products_status = 1
					and p.show_type = 0
					" . $and_str . $and_narrow_by . $warehouse_where . $ptc_where . $sql_order_by;



            $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');

            //將返回值变为数组，以便于后面再次被判断为product_id
            $listing_sql=[$listing_sql];
        } else {

            //搜索产品ID是不用us_status仓库字段状态判断，需要展示推荐产品
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_colums = "";
            $query_from = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_colums = ",count(rd.reviews_id) as rating ";
                $query_from = " left join reviews as r on r.products_id=p.products_id left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
            }
            //$listing_sql = "select  p.products_id,p.integer_state,p.is_min_order_qty,p.offline_replace_products_id,p.offline_replace_products_type,p.products_status,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products " . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $query_from . $software_from . "
            //	where p.products_id = " . (int)$keyword . " and p.show_type = 0 " . $sql_order_by;

            $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.offline_replace_products_id,p.offline_replace_products_type,p.products_status,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.{$fsCurrentInquiryField} is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag " . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) " . $query_from . $software_from . "
					where p.products_id = " . (int)$keyword . " and p.show_type = 0 " . $ptc_where . $sql_order_by;
            // echo '产品id<br/>';
        }
    } else if (preg_match('/^SKU/i', $keyword)) {
        //$listing_sql = "select  p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_warehouse_column . "  from " . TABLE_PRODUCTS . " as p
        //                " . $from_narrow_by . "
        //                " . $software_from . "
        //			where p.products_status = 1
        //			and p.show_type = 0
        //			and p.products_SKU = :keyword " . $and_narrow_by . $warehouse_where;

        $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.{$fsCurrentInquiryField} is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_warehouse_column . "  from " . TABLE_PRODUCTS . " as p
                        left join products_to_categories as ptc using(products_id) " . $from_narrow_by . "
                        " . $software_from . "
						where p.products_status = 1	
						and p.show_type = 0
						and p.products_SKU = :keyword " . $and_narrow_by . $warehouse_where . $ptc_where;
        // echo 'SKU<br/>';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    } else if ($advance_search->search_level($keyword, 2)) {  //判断用户输入的是 F/N 码
        if (!$sql_order_by) {
            $sql_order_by = " order by p.products_sort_order asc ";
        }
        $query_select_colums = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_colums = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r  on(r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
        }
        /*
             * 优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
             * */

        $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
        $keyword = preg_replace($pattern, '', $keyword);
        $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";
        //$listing_sql = "select  p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $from_narrow_by . $query_from . $software_from . "
        //		where p.products_status = 1
        //		and p.show_type = 0
        //		" . $and_str . $and_narrow_by . $warehouse_where . $sql_order_by;

        $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.{$fsCurrentInquiryField} is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) " . $from_narrow_by . $query_from . $software_from . "
					where p.products_status = 1     
					and p.show_type = 0
					" . $and_str . $and_narrow_by . $warehouse_where . $ptc_where . $sql_order_by;
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
        // echo '2<br/>';
    } else if ($advance_search->search_level($keywords, 4)) {
        //$listing_sql = "select p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,pcom.composite_products,
        //p.is_inquiry,p.new_products_tag,p.new_products_time" . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
        //		left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd
        //			on p.products_id = pd.products_id
        //			" . $from_narrow_by . "
        //			" . $software_from . "
        //			where p.products_status = 1
        //			and p.show_type = 0
        //			and language_id = " . $_SESSION['languages_id'] . "
        //			and ((REPLACE(REPLACE(REPLACE(pd.products_name,'\(',' '),'\)',' '),'/',' '))) = :keyword " . $and_narrow_by . $warehouse_where;

        $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,pcom.composite_products,
		p.{$fsCurrentInquiryField} is_inquiry,p.new_products_tag,p.new_products_time" . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p	
				left join products_to_categories as ptc  using(products_id) left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd 
					on p.products_id = pd.products_id
					" . $from_narrow_by . "
					" . $software_from . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					and ((REPLACE(REPLACE(REPLACE(pd.products_name,'\(',' '),'\)',' '),'/',' '))) = :keyword " . $and_narrow_by . $warehouse_where . $ptc_where;
        // echo '4<br/>';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keywords, 'string');
    } else {
        $where_str = zen_get_keywords_sql_of_array($keyword);//获取关键词sql语句查询条件
        if (!$sql_order_by) {
            $order_by = zen_get_count_by_keywords_of_sort($keyword);
        } else {
            $order_by = $sql_order_by;
        }
        $query_select_colums = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_colums = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r on (r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ")";
        }
        //$listing_sql = "select p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
        //		left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
        //		" . $from_narrow_by . $query_from . $software_from . "
        //		where p.products_status = 1
        //		and p.show_type = 0
        //		and language_id = " . $_SESSION['languages_id'] . "
        //		" . $where_str . $warehouse_where . $and_narrow_by . $order_by . "";

        $listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.{$fsCurrentInquiryField} is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
					left join products_to_categories as ptc  using(products_id) left join  " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
					" . $from_narrow_by . $query_from . $software_from . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					" . $where_str . $warehouse_where . $and_narrow_by . $ptc_where . $order_by . "";

        // echo '产品名称<br />';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    }
//     var_dump($listing_sql);
    return $listing_sql;
}





function zen_get_search_products_of_keywords_v2($keyword, $word, $key_array, $narrow, $sql_order_by = "", $is_warehouse_where = false)
{
    global $db;

    $languages_id = intval($_SESSION['languages_id']);

    //处理$keyword
    $pattern = '/select|insert|update|delete|\'|\(|\)|$|^|%|"|\*|\=|union|into|load_file|outfile/i';
    $keyword = preg_replace($pattern, '', $keyword);
    $keyword = trim($keyword);

    $advance_search = new advance_search_detech();

    $ptc_where = ' ';

    //处理$keyword匹配分类
    $sql = "select categories_id from categories_left_display where LOWER(categories_name)='".$keyword."' and language_id='".intval($_SESSION['languages_id'])."'";
    $result = $db->getAll($sql);
    $categories_ids = [];
    if ($result) {
        $categories_ids = array_column($result, 'categories_id');
    }
    $temp = [];
    if (count($categories_ids)) {
        foreach ($categories_ids as $value) {
            if (zen_has_category_subcategories($value)) {
                $all_subcategories_ids = array();
                $where_clearing = ' and is_clearing = 0 ';
                //查找当前分类下的所有子分类调用redis缓存函数
                zen_get_subcategories_redis($all_subcategories_ids, $value, $where_clearing);
                $all_subcategories_ids[] = $value;

                $temp = array_merge($temp, $all_subcategories_ids);
            } else {
                $temp[] = $value;
            }
        }
    }
    $categories_ids = $temp;


    //搜索筛选项
    $products_narrow_by_option_values_ids = array();
    if (isset($narrow) && is_array($narrow)) {
        foreach ($narrow as $key => $value) {
            $products_narrow_by_option_values_ids [] = (int)$value;
        }
    }
    $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
    $from_narrow_by = '';
    if (zen_not_null($products_narrow_by_option_values_ids)) {
        if (1 == $narrow_by_count) {
            $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp on p.products_id = povp.products_id";
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
                    $where_narrow_by .= ' inner JOIN';
                }
                $where_narrow_by .= $sql_query_array[$i];
                if ($i) {
                    $where_narrow_by .= " ON t" . ($i - 1) . ".products_id = t" . $i . ".products_id ";
                }
            }
            $and_narrow_by = " AND p.products_id in(" . $where_narrow_by . ") ";
        }
    }
    //end 筛选项


    //获取当前国家对应的发货仓库状态字段
    $warehouse_data         = fs_products_warehouse_where();
    $warehouse_fields       = strtolower($warehouse_data['code']) . '_status';
    $query_warehouse_column = ',' . $warehouse_fields . ' ';
    if ($is_warehouse_where) {
        $warehouse_where = ' ';
    } else {
        $warehouse_where = $warehouse_data['where'];
    }


    /* when search is SKU of product */
    $software_from = ' LEFT JOIN products_composite AS pcom ON ( p.products_id=pcom.products_id ) ';


    //匹配分类
    if (count($categories_ids)) {

        $ptc_where = " and ptc.categories_id in (".implode(',', $categories_ids).") ";

        $order_by = $sql_order_by;

        $query_select_columns = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_columns = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r on (r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ")";
        }

        $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_select_columns . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
					left join products_to_categories as ptc  using(products_id) " . $from_narrow_by . $query_from . $software_from . "
					where p.products_status = 1 and p.show_type=0 
					" .  $warehouse_where . $and_narrow_by . $ptc_where . $order_by . "";

        return $listing_sql;
    }

    //判断用户输入的是产品ID
    if (is_numeric($keyword) && strlen($keyword) >= 5) {

        //为了解决输入5位数字的F/N码时，和产品id重合的问题，先判断$keyword是否为F/N码 Bona.guo 2020/11/19 11:32
        if ($advance_search->search_level($keyword, 2)) {
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_columns = "";
            $query_from = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_columns = " ,count(rd.reviews_id) as rating ";
                $query_from           = " left join reviews as r on (r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . $languages_id . ") ";
            }

            //优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
            $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
            $keyword = preg_replace($pattern, '', $keyword);
            $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";


            $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,
            p.offline_sales_num, p.product_sales_total_num, p.products_id, p.integer_state,
            p.is_min_order_qty, p.products_sort_order, p.products_image, p.products_price, p.products_SKU,
            p.products_model, p.is_inquiry, p.new_products_tag, p.new_products_time, pcom.composite_products"
            . $query_select_columns . $query_warehouse_column
            . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) "
            . $from_narrow_by . $query_from . $software_from
            . " where p.products_status = 1 and p.show_type = 0 "
            . $and_str . $and_narrow_by . $warehouse_where . $ptc_where . $sql_order_by;


            $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');

            //將返回值变为数组，以便于后面再次被判断为product_id
            $listing_sql = [$listing_sql];
        } else {

            //搜索产品ID是不用us_status仓库字段状态判断，需要展示推荐产品
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_columns = "";
            $query_from           = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_columns = ",count(rd.reviews_id) as rating ";
                $query_from           = " left join reviews as r on r.products_id=p.products_id left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . $languages_id . ") ";
            }

            $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,
            p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,
            p.is_min_order_qty,p.offline_replace_products_id,p.offline_replace_products_type,
            p.products_status,p.products_sort_order,p.products_image,p.products_price,
            p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,
            pcom.composite_products,p.product_custom_tag "
            . $query_select_columns . $query_warehouse_column
            . " from " . TABLE_PRODUCTS
            . " as p left join products_to_categories as ptc using(products_id) "
            . $query_from . $software_from
            . " where p.products_id = " . (int)$keyword . " and p.show_type = 0 " . $ptc_where . $sql_order_by;

        }
    } else if (preg_match('/^SKU/i', $keyword)) {
        $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_warehouse_column . "  from " . TABLE_PRODUCTS . " as p
                        left join products_to_categories as ptc using(products_id) " . $from_narrow_by . "
                        " . $software_from . "
						where p.products_status = 1	
						and p.show_type = 0
						and p.products_SKU = :keyword " . $and_narrow_by . $warehouse_where . $ptc_where;

        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    } else if ($advance_search->search_level($keyword, 2)) {  //判断用户输入的是 F/N 码
        if (!$sql_order_by) {
            $sql_order_by = " order by p.products_sort_order asc ";
        }
        $query_select_columns = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_columns = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r  on(r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . $languages_id . ") ";
        }

        //优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
        $origin_word = $keyword;
        $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
        $keyword = preg_replace($pattern, '', $keyword);
        $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) or p.products_model regexp '".$origin_word."' or p.old_products_model regexp '".$origin_word."')";

        //$listing_sql = "select distinct p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products" . $query_select_columns . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) " . $from_narrow_by . $query_from . $software_from . "
			//		where p.products_status = 1
			//		and p.show_type = 0
			//		" . $and_str . $and_narrow_by . $warehouse_where . $ptc_where . $sql_order_by;

        $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_select_columns . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p left join products_to_categories as ptc using(products_id) " . $from_narrow_by . $query_from . $software_from . "
					where 1=1 and p.products_status=1 and p.show_type=0
					" . $and_str . $and_narrow_by . $warehouse_where . $ptc_where . $sql_order_by;


        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');

        $listing_sql = [$listing_sql];

    } else if ($advance_search->search_level($keyword, 4)) {
        $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,pcom.composite_products,
		p.is_inquiry,p.new_products_tag,p.new_products_time,p.product_custom_tag" . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p	
				left join products_to_categories as ptc  using(products_id) left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd 
					on p.products_id = pd.products_id
					" . $from_narrow_by . "
					" . $software_from . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					and ((REPLACE(REPLACE(REPLACE(pd.products_name,'\(',' '),'\)',' '),'/',' '))) = :keyword " . $and_narrow_by . $warehouse_where . $ptc_where;
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    } else {
        $where_str = zen_get_keywords_sql_of_array($keyword);//获取关键词sql语句查询条件
        if (!$sql_order_by) {
            $order_by = zen_get_count_by_keywords_of_sort($keyword);
        } else {
            $order_by = $sql_order_by;
        }
        $query_select_columns = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_columns = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r on (r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ")";
        }

        $listing_sql = "select distinct p.products_status,p.offline_replace_products_id,p.offline_replace_products_type,p.offline_sales_num,p.product_sales_total_num,p.products_id,p.integer_state,p.is_min_order_qty,p.products_sort_order,p.products_image,p.products_price,p.products_SKU,p.products_model,p.is_inquiry,p.new_products_tag,p.new_products_time,pcom.composite_products,p.product_custom_tag" . $query_select_columns . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
					left join products_to_categories as ptc  using(products_id) left join  " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
					" . $from_narrow_by . $query_from . $software_from . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					" . $where_str . $warehouse_where . $and_narrow_by . $ptc_where . $order_by . "";

        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    }

    return $listing_sql;
}





//新版匹配关键词 仅用于搜索关键词
function zen_get_search_products_of_keywords_new($keywords, $word, $key_array, $narrow, $sql_order_by = "")
{
    global $db;

    $keyword = preg_replace('/select|insert|update|delete|\'|\(|\)|$|^|%|"|\*|\=|union|into|load_file|outfile/i', '', $keywords);
    $keyword = trim($keyword);
    $advance_search = new advance_search_detech();
    $categories_arr = zen_get_keywords_is_categories_tag($keyword);

    $replace_keyword = str_replace('-', ' ', $keyword);
    $replace_keyword = str_replace('=', ' ', $replace_keyword);
    $replace_keyword = str_replace('/', ' ', $replace_keyword);
    $replace_keyword = str_replace('from', ' ', $replace_keyword);
    $replace_keyword = str_replace('（', ' ', $replace_keyword);
    $replace_keyword = str_replace('）', ' ', $replace_keyword);
    $words = explode(" ", $replace_keyword);
    //搜索筛选项
    $products_narrow_by_option_values_ids = array();

    if (isset($narrow) && is_array($narrow)) {
        foreach ($narrow as $key => $value) {
            $products_narrow_by_option_values_ids [] = (int)$value;
        }
    }

    $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
    $from_narrow_by = '';
    if (zen_not_null($products_narrow_by_option_values_ids)) {
        if (1 == $narrow_by_count) {
            $from_narrow_by = " left join " . TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . " as povp on p.products_id = povp.products_id";
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
                    $where_narrow_by .= ' inner JOIN';
                }
                $where_narrow_by .= $sql_query_array[$i];
                if ($i) {
                    $where_narrow_by .= " ON t" . ($i - 1) . ".products_id = t" . $i . ".products_id ";
                }
            }
            $and_narrow_by = " AND p.products_id in(" . $where_narrow_by . ") ";
        }
    }
    //end 筛选项

    //获取当前国家对应的发货仓库状态字段
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_fields = strtolower($warehouse_data['code']) . '_status';
    $query_warehouse_column = ',' . $warehouse_fields . ' ';
    $warehouse_where = $warehouse_data['where'];
    // var_dump($keyword);
    /* when search is SKU of product */
    if (is_numeric($keyword) && strlen($keyword) >= 5) {

        if ($advance_search->search_level($keyword, 2)) {
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_colums = "";
            $query_from = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_colums = ",count(rd.reviews_id) as rating ";
                $query_from = " left join reviews as r  on(r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
            }
            /*
                 * 优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
                 * */

            $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
            $keyword = preg_replace($pattern, '', $keyword);
            $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";
            $listing_sql = "select  p.products_id,p.products_image,p.product_sales_num" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $from_narrow_by . $query_from . "
					where p.products_status = 1
					and p.show_type = 0
					" . $and_str . $and_narrow_by . $warehouse_where . $sql_order_by;
            $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');

            //將返回值变为数组，以便于后面再次被判断为product_id
            $listing_sql=[$listing_sql];
        }else{

            //搜索产品ID是不用us_status仓库字段状态判断，需要展示推荐产品
            if (!$sql_order_by) {
                $sql_order_by = " order by p.products_sort_order asc ";
            }
            $query_select_colums = "";
            $query_from = "";
            if ($sql_order_by == " group by p.products_id order by rating desc ") {
                $query_select_colums = ",count(rd.reviews_id) as rating ";
                $query_from = " left join reviews as r on r.products_id=p.products_id left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
            }
            $listing_sql = "select  p.products_id,p.products_image,p.product_sales_num" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $query_from . "
					where p.products_id = " . (int)$keyword . " and p.show_type = 0 " . $sql_order_by;
            // echo '产品id<br/>';
        }

    } else if (preg_match('/^SKU/i', $keyword)) {
        $listing_sql = "select  p.products_id,p.products_image,p.product_sales_num" . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
                        " . $from_narrow_by . "
						where p.products_status = 1	
						and p.show_type = 0
						and p.products_SKU = :keyword " . $and_narrow_by . $warehouse_where;
        // echo 'SKU<br/>';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    } else if ($advance_search->search_level($keyword, 2)) {
        if (!$sql_order_by) {
            $sql_order_by = " order by p.products_sort_order asc ";
        }
        $query_select_colums = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_colums = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r  on(r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ") ";
        }
        /*
             * 优化不仅chl-468可以搜索匹配到网站产品，chl468或chl 468也可以搜索到产品
             * */

        $pattern = array('/-/', '/\./', '/\*/', '/\//', '/\s/');
        $keyword = preg_replace($pattern, '', $keyword);
        $and_str = " and ( REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_model,'/',''),'-',''),'.',''),'*',''),' ','') = :keyword or REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.products_MFG_PART,'/',' '),'-',''),'.',''),'*',''),' ','') = :keyword or  find_in_set('" . $keyword . "', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.old_products_model,'/',''),'-',''),'.',''),'*',''),' ','')) )";
        $listing_sql = "select  p.products_id,p.products_image,p.product_sales_num" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p" . $from_narrow_by . $query_from . "
					where p.products_status = 1 
					and p.show_type = 0
					" . $and_str . $and_narrow_by . $warehouse_where . $sql_order_by;
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
        // echo '2<br/>';
    } else if ($advance_search->search_level($keywords, 4)) {
        $listing_sql = "select p.products_id,p.products_image,p.product_sales_num" . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
				left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd
					on p.products_id = pd.products_id
					" . $from_narrow_by . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					and ((REPLACE(REPLACE(REPLACE(pd.products_name,'\(',' '),'\)',' '),'/',' '))) = :keyword " . $and_narrow_by . $warehouse_where;
        // echo '4<br/>';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keywords, 'string');
    } else {
        $where_str = zen_get_keywords_sql_of_array($keyword);//获取关键词sql语句查询条件
        if (!$sql_order_by) {
            $order_by = zen_get_count_by_keywords_of_sort($keyword);
        } else {
            $order_by = $sql_order_by;
        }
        $query_select_colums = "";
        $query_from = "";
        if ($sql_order_by == " group by p.products_id order by rating desc ") {
            $query_select_colums = ",count(rd.reviews_id) as rating ";
            $query_from = " left join reviews as r on (r.products_id=p.products_id) left join reviews_description rd on (r.reviews_id=rd.reviews_id and rd.languages_id =" . (int)$_SESSION['languages_id'] . ")";
        }
        $listing_sql = "select p.products_id,p.products_image,p.product_sales_num" . $query_select_colums . $query_warehouse_column . " from " . TABLE_PRODUCTS . " as p
					left join " . TABLE_PRODUCTS_DESCRIPTION . " as pd on p.products_id = pd.products_id
					" . $from_narrow_by . $query_from . "
					where p.products_status = 1 
					and p.show_type = 0
					and language_id = " . $_SESSION['languages_id'] . "
					" . $where_str . $warehouse_where . $and_narrow_by . $order_by . "";
        // echo '产品名称<br />';
        $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
    }

    return $listing_sql;
}

//amazon cloud search
//$narrow 筛选项
//$category_id 分类id
//$narrow_ids 筛选项ids
//$order 排序
//$page_size 每页的个数
//$page 第几页
function zen_get_search_products_from_amazon_cloud_search($keyword, $narrow_arr, $order = '', $page_size = '', $page = '')
{
    global $amazon_search;

    switch ($order) {
        case 'priced':
            $sort = "products_price desc,_score desc";
            break;
        case 'price':
            $sort = "products_price asc,_score desc";
            break;
        case 'rate':
            $sort = "rating desc,_score desc ";
            break;
        case 'new':
            $sort = "products_id desc,_score desc ";
            break;
        default:
            $sort = "products_sort_order asc,_score desc"; //按相关度排序
            break;
    }

    $narrow_arr_count = count($narrow_arr);
    if ($narrow_arr_count == 1) {
        $narrow_FQ = 'option:' . $narrow_arr[0];
    } elseif ($narrow_arr_count > 1) {
        $narrow_FQ = '( or ';
        foreach ($narrow_arr as $val) {
            $narrow_FQ .= ' option:' . $val . ' ';
        }
        $narrow_FQ .= ')';
    }
    $FQ = '';
    if ($narrow_FQ) {
        $FQ = '(and products_status:1 ' . $narrow_FQ . ')';
    } else {
        if (!is_numeric($keyword)) {
            $FQ = 'products_status:1';
        }
    }

    // 参考：控制搜索结果/分页结果
    if ($page) {
        $page_start = ($page - 1) * $page_size;
    } else { //搜索全部的产品
        $page_start = 0;
        $page_size = 10000;
    }

    $config = array(
        "query" => "'" . $keyword . "'",
        "queryParser" => "structured",
        "start" => $page_start,
        "size" => $page_size,
        "sort" => $sort
    );
    if ($FQ) {
        $config['filterQuery'] = $FQ;// 筛选项 $narrow
    }
    // init 类型不能和其他类型一起搜索
    if (is_numeric($keyword) && strlen($keyword) >= 5) {
        $config['queryOptions'] = '{"defaultOperator":"and","fields":["products_id"]}';
    } else {
        $config['queryOptions'] = '{"defaultOperator":"and","fields":["products_name^2","products_mfg_part","products_model"]}';
    }
    //var_dump($config);
    $amazon_result = $amazon_search->search($config);
    if ($amazon_result->getPath('hits/found') === null) { // 发生错误
        //var_dump($amazon_result);
        exit();
    } else {
        $data = array();
        $data["count"] = $amazon_result->getPath('hits/found');
        $data["data"] = $amazon_result->getPath('hits/hit');
    }
    return $data;
}

function zen_get_search_suggest_products_from_amazon_cloud($keyword, $size)
{
    global $amazon_search;
    $config = array(
        "query" => "'" . $keyword . "'",
        "size" => $size,
        "suggester" => "products_name",
    );

    $amazon_result = $amazon_search->suggest($config);
    if ($amazon_result->getPath('suggest/found') === null) { // 发生错误
        var_dump($amazon_result);
        exit();
    } else {
        $data = array();
        $data["count"] = $amazon_result->getPath('suggest/found');
        $data["data"] = $amazon_result->getPath('suggest/suggestions');
    }
    return $data;
}

//每匹配一个关键字，表达式的结果就加1，否则加0，最后计算得出的结果就是匹配关键字的个数
function zen_get_count_by_keywords_of_sort($keyword)
{
    $order_by = '';

    $array = explode(" ", $keyword);
    $split_key = '';
    for ($i = 0; $i < sizeof($array); $i++) {
        $split_key .= trim($array[$i]);
        if ($i == sizeof($array) - 1) {
            $split_key .= '';
        } else {
            $split_key .= '-';
        }
    }
    $split_key = mysql_regexp_transfer($split_key);
    $keyword = mysql_regexp_transfer($keyword);
    if ($split_key && !$keyword) {
        $order_by = " order by (case when pd.products_name REGEXP '" . $split_key . "' then 1 else 0 end ) desc";
    } elseif (!$split_key && $keyword) {
        $order_by = " order by (CASE WHEN pd.products_name REGEXP '" . $keyword . "' THEN 1 ELSE 0 END) desc";
    } elseif ($split_key && $keyword) {
        $order_by = " order by (case when pd.products_name REGEXP '" . $split_key . "' then 1 else 0 end )
                   +(CASE WHEN pd.products_name REGEXP '" . $keyword . "' THEN 1 ELSE 0 END)
                    desc";
    }

    return $order_by;
}

//页面关键词 加样式区分 单词首写字母大写
function zen_get_new_name_display_of_keywords($name, $key_array, $keyword)
{
    //for ($i=0;$i<sizeof($key_array);$i++){
    /*
      if(substr($key_array[$i], -1) == 's' && strlen($key_array[$i]) > 2){
             $key_array[$i] =  substr($key_array[$i], 0, -1);
           }
           */
    //$name = str_replace('<s class="search_keywords">'.$key_array[$i].'</s>',$key_array[$i],$name);
    $name = str_ireplace($key_array[$i], '<s class="search_keywords">' . ucwords($keyword) . '</s>', $name);
    //}
    return $name;
}


//搜索左边显示二级
function zen_get_categories_is_not_subcategories($cid)
{
    global $db;
    $cache = sqlCacheType();
    $parent_sql = "select {$cache} categories_id as id from categories where parent_id = 0 ";  // all parent
    $parent = $db->Execute($parent_sql);
    $parent_array = array();
    while (!$parent->EOF) {
        $parent_array [] = $parent->fields['id'];
        $parent->MoveNext();;
    }
    $sub_sql = " select {$cache} categories_id as id from categories where parent_id in ( " . join(',', $parent_array) . " ) ";
    $sub = $db->Execute($sub_sql);
    $sub_array = array();
    while (!$sub->EOF) {
        $sub_array [] = $sub->fields['id'];
        $sub->MoveNext();;
    }
    if (in_array($cid, $sub_array)) {
        return $cid;
    } else {
        $c_sql = " select {$cache} parent_id from categories where categories_id = " . (int)$cid;
        $categories = $db->Execute($c_sql);
        $cp_id = $categories->fields['parent_id'];
        if (in_array($cp_id, $sub_array)) {
            return $cp_id;
        } else {
            $f_sql = " select {$cache} parent_id from categories where categories_id = " . (int)$cp_id;
            $fcategories = $db->Execute($f_sql);
            if (in_array($fcategories->fields['parent_id'], $sub_array)) {
                return $cp_id;
            }
        }
    }
}


//搜索建议词组
function search_keyword_relate($word)
{
    global $db;
    $tagWord = array();
    if ($word) {
        $sql = "select tag_word_id,tag_id from seo_tag_word where tag_word ='" . $word . "' and language_id = '" . $_SESSION['languages_id'] . "' ";
        $tag = $db->Execute($sql);
        if ($tag->fields['tag_word_id'] && $tag->fields['tag_id']) {
            $tagSQL = $db->Execute("select tag_word from seo_tag_word where tag_id = '" . $tag->fields['tag_id'] . "' and tag_word_id != '" . $tag->fields['tag_word_id'] . "' ");

            if ($tagSQL->RecordCount()) {
                while (!$tagSQL->EOF) {
                    $tagWord [] = $tagSQL->fields['tag_word'];
                    $tagSQL->MoveNext();
                }
            }
        }
    }
    return $tagWord;
}

//获取相关搜索词
function search_relate_keywords($keyword, $connector = 'and')
{
    global $db;

    $keyword = preg_replace('/select|insert|update|delete|\'|\(|\)|$|^|%|"|\*|union|into|load_file|outfile/i', '', $keyword);
    $keyword = str_replace('#', '', $keyword);

    $replace_keyword = str_replace('-', ' ', $keyword);
    $replace_keyword = str_replace('=', ' ', $replace_keyword);
    $replace_keyword = str_replace('from', ' ', $replace_keyword);
    $replace_keyword = str_replace('+', ' ', $replace_keyword);
    $words = explode(' ', $replace_keyword);
    $keyword_like_id = 0;
    if (!empty($replace_keyword)) {
        $sql = 'select products_tag as id from products_tags where tag_keywords regexp "' . mysql_regexp_transfer($replace_keyword) . '" limit 1';
        $result = $db->Execute($sql);
        $keyword_like_id = $result->fields['id'];
    }
    $relate_key = array();
    if (sizeof($words) == 1 && zen_not_null($words[0])) {
        $where .= ' where (tag_keywords regexp "' . mysql_regexp_transfer($words[0]) . '" ';
    } elseif (sizeof($words) == 2 && zen_not_null($words[1]) && zen_not_null($words[0])) {
        $where .= ' where (tag_keywords regexp "' . mysql_regexp_transfer($words[0]) . '" ' . $connector . ' tag_keywords regexp "' . mysql_regexp_transfer($words[1]) . '" ';
    } else {
        foreach ($words as $k => $v) {
            if ($k < sizeof($words) - 1 && !empty($v)) {
                $v_regexp = mysql_regexp_transfer($v);
                if ($k == 0) {
                    $where .= ' where (tag_keywords regexp "' . $v_regexp . '" ';
                } else {
                    $where .= ' ' . $connector . ' tag_keywords regexp "' . $v_regexp . '"';
                }
            }
        }
    }
    if ($keyword_like_id) {
        $where .= ') and products_tag != ' . (int)$keyword_like_id;
    } else {
        $where .= ')';
    }
    $key_relate_sql = 'select products_tag as id,tag_keywords as keywords from products_tags ' . $where . ' limit 0,100';
    $result = $db->Execute($key_relate_sql);
    if ($result->RecordCount()) {
        while (!$result->EOF) {
            $relate_key_all[] = $result->fields['keywords'] . '|' . $result->fields['id'];
            $result->MoveNext();
        }
    }
    if (!empty($relate_key_all) && sizeof($relate_key_all) > 5) {
        if (sizeof($relate_key_all) > 5) {
            $relate_key_value = array_rand($relate_key_all, 5);
            foreach ($relate_key_value as $v) {
                $relate_key[$v] = $relate_key_all[$v];
            }
        } else {
            $relate_key = $relate_key_all;
        }
        usort($relate_key, 'sortByLen');
        $relate_key = array_reverse($relate_key);
    } elseif ($connector = 'or') {
        return $relate_key;
    } else {
        return search_relate_keywords($keyword, $connector = 'or');
    }
    return $relate_key;
}


function get_offline_replace_products($offline_replace_products_id)
{
    global $db;
    global $currencies;
    global $fsCurrentInquiryField;
    $products = [];
    if (!$offline_replace_products_id) {
        return $products;
    }
    $offline_replace_products_id = str_replace('，', ',', $offline_replace_products_id);
    $pos = strpos($offline_replace_products_id, ',');
    if (!$pos) {
        $where = ' and P.products_id=' . $offline_replace_products_id;
    } else {
        $where = ' and P.products_id in(' . $offline_replace_products_id . ') order by field (P.products_id, ' . $offline_replace_products_id . ')';
    }
    //获取当前国家对应的发货仓库
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = $warehouse_data['where'];
    $sql = 'select P.offline_sales_num,P.product_sales_total_num,P.products_id,P.is_min_order_qty,P.products_image,P.integer_state,P.'.$fsCurrentInquiryField.' is_inquiry,P.products_price,PD.products_name,PD.products_name_info,P.products_model
    FROM  ' . TABLE_PRODUCTS . ' P
    left join  ' . TABLE_PRODUCTS_DESCRIPTION . ' PD on P.products_id = PD.products_id
    where 1 and P.products_status=1  ' .$warehouse_where. $where;

    $products = $db->getAll($sql);
    if ($products) {
        foreach ($products as $key => $val) {
            $products_id = $val['products_id'];
            $products[$key]['image_str'] = get_resources_img($products_id, 180, 180);
            $products[$key]['is_min_order_qty'] = $products[$key]['is_min_order_qty'] ? $products[$key]['is_min_order_qty'] : 1;

            //获取评论等级
            $sql = "select count(r.reviews_id) as count
                        from " . TABLE_REVIEWS . " AS r
                        LEFT JOIN " . TABLE_REVIEWS_DESCRIPTION . " AS rd ON(rd.reviews_id = r.reviews_id) and rd.languages_id = " . (int)$_SESSION['languages_id'] . "
                        WHERE r.products_id = " . $products_id . " AND r.status = 1 AND r.check_status=1
                        limit 8";
            $content_of_reviews = $db->getAll($sql);
            $content_of_reviews = $content_of_reviews[0]['count'];
            if ($content_of_reviews) {
                $fs_reviews = new fs_reviews();
                $reviews_score = $fs_reviews->get_reviews_score($products_id);
                $reviews_nums = substr($reviews_score, -1);
                $reviews_sums = substr($reviews_score, 0, 1);
                if ($reviews_nums == 0) {
                    $reviews_width = 100;
                } else {
                    $reviews_width = $reviews_nums * 10;
                }
                $review_info = fs_product_reviews_level_show($reviews_score, $reviews_width, $reviews_sums, 'change_head_proStar', $products_id);
            } else {
                $review_info = '<span class="p_star11" ></span>';
            }
            $products[$key]['review_info'] = $review_info;

            //库存
            $options_name = fs_products_option_info($products_id);
            $productLengthInfo = fs_product_length_info($products_id);
            if (sizeof($options_name) || $productLengthInfo) {
                $isNotCustom = false;
            } else {
                $isNotCustom = true;
            }
            $products[$key]['isNotCustom'] = $isNotCustom;
            $products[$key]['instock_info'] = get_instock_info($products_id, $isNotCustom, false);


            // 产品价格
            $new_product_price = zen_get_products_base_price_other($val['products_price']);

            //澳大利亚展示税后价
            $currency = $_SESSION['currency'] ? $_SESSION['currency'] : 'USD';
            $currency_value = $currencies->currencies[$currency]['value'];
            if ($val['integer_state'] == 0) {
                $price = get_products_all_currency_final_price($new_product_price * $currency_value);
            } else {
                $price = get_products_specail_currency_final_price($new_product_price * $currency_value);
            }
            //返回的仍然是美元为单位的价格
            $price = $price / $currency_value;
            // 澳大利亚税后价在是否取整之后*1.1
            $price = get_gsp_tax_price($_SESSION['countries_iso_code'], $price);
            $price = $currencies->total_format($price);

            $products[$key]['price_str'] = $price;
            $products[$key]['id'] = $val['products_id'];
        }
    }
    if (!is_array($products)) {
        $products = [];
    }
    return $products;
}

/**
 * 下线产品 是否可以 搜索到（通过 搜索 或者 网址products/products_id.html）
 * @param int $products_id ：产品id
 * @return bool
 */
function offline_products_is_show_new_page($products_id, $field = '')
{
    global $db;
    // 2019-7-23 potato 只查询想要的字段，可以用字符串拼接的也可以用数组，例如：$field = 'categories_id,is_show' 或者 $field = ['categories_id','is_show']
    if ($field) {
        is_array($field) ? $fields = implode(',', $field) : $fields = $field;
    } else {
        $fields = '*';
    }
    $sql = 'select ' . $fields . ' from products_to_categories WHERE products_id=' . $products_id;
    $categories = $db->getAll($sql);
    if (empty($categories)) { //没有分类id的
        return false;
    }
    $current_categories = $categories[0]['categories_id'];
    $cPath_array = (array_reverse(get_category_parent_id($current_categories, array())));
    if ($cPath_array[0] == 3067 || $cPath_array[0] == 3139) { // 一级是closed、采购部-配件和耗材-专区。不显示下架产品的搜索页面
        return false;
    } else {
        return true;
    }
}

// 获取下架产品的数据
function get_offline_page_data($products_id, $offline_replace_products_id)
{
    global $db;
    $product_des = "select pd.products_name,pd.products_name_info,p.products_image,p.offline_replace_products_type,pd.offline_replace_products_attribute_one,pd.offline_replace_products_attribute_two,pd.offline_replace_products_attribute_three,p.products_model
                    from " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd using(products_id)
                    where products_id = '" . (int)$products_id . "'
                    and language_id = '" . (int)$_SESSION['languages_id'] . "' limit 1";
    $product_des = $db->getAll($product_des);
    $product_des = $product_des[0];
    $offline_products = array();
    $offline_products['products_id'] = $products_id;
    $offline_products['products_name'] = $product_des['products_name'];
    $offline_products['products_image'] = $product_des['products_image'];
    $offline_products['products_model'] = $product_des['products_model'];
    $offline_products['offline_replace_products_type'] = $product_des['offline_replace_products_type'];
    $offline_products['image_str'] = '<img src="' . HTTPS_PRODUCTS_SERVER . DIR_WS_IMAGES . (!empty($product_des['products_image']) ? $product_des['products_image'] : 'no_picture.gif') . '"' . ' width = 200 height=200>';

    //获取下架产品的替代产品
    $offline_replace_products = get_offline_replace_products($offline_replace_products_id);

    //只展示一个推荐的产品
    $offline_replace_products = array_slice($offline_replace_products, 0, 1);

    //推荐产品的属性
    $offline_replace_products_attributes = array();
    $offline_replace_products_attributes = array_merge($offline_replace_products_attributes, explode('{{{', $product_des['offline_replace_products_attribute_one']));
    $offline_replace_products_attributes = array_merge($offline_replace_products_attributes, explode('{{{', $product_des['offline_replace_products_attribute_two']));
    $offline_replace_products_attributes = array_merge($offline_replace_products_attributes, explode('{{{', $product_des['offline_replace_products_attribute_three']));

    return array(
        'offline_products' => $offline_products,
        'offline_replace_products' => $offline_replace_products,
        'offline_replace_products_attributes'   => $offline_replace_products_attributes
    );
}

//end of new search
?>
