<?php

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_MODULE_START_META_TAGS');

// Add tertiary section to site tagline
if (strlen(SITE_TAGLINE) > 1) {
    define('TAGLINE', TERTIARY_SECTION . SITE_TAGLINE);
} else {
    define('TAGLINE', '');
}

$review_on = "";
$keywords_string_metatags = "";
if (!defined('METATAGS_DIVIDER')) define('METATAGS_DIVIDER', ', ');

// Get all top category names for use with web site keywords
$sql = "select cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = 0 and c.categories_id = cd.categories_id and cd.language_id='" . (int)$_SESSION['languages_id'] . "' and c.categories_status=1";
$keywords_metatags = $db->Execute($sql);
while (!$keywords_metatags->EOF) {
    $keywords_string_metatags .= zen_clean_html($keywords_metatags->fields['categories_name']) . METATAGS_DIVIDER;
    $keywords_metatags->MoveNext();
}
define('KEYWORDS', str_replace('"','',zen_clean_html($keywords_string_metatags) . CUSTOM_KEYWORDS));

//bof use custom page meta tags
if ($this_is_home_page || FILENAME_DEFAULT != $_GET['main_page']) {
    if(0 != zen_is_set_page_meta_tags($_GET['main_page'],$_SESSION['languages_id'])){
        $meta_info = zen_get_page_meta_tags($_GET['main_page'],$_SESSION['languages_id']);
        if (isset($meta_info[$_SESSION['languages_id']]) && is_array($meta_info[$_SESSION['languages_id']]) && zen_not_null($meta_info[$_SESSION['languages_id']])) {
            define('META_TAG_TITLE', str_replace('"','',$meta_info[$_SESSION['languages_id']]['title'] ));
            define('META_TAG_DESCRIPTION', str_replace('"','',$meta_info[$_SESSION['languages_id']]['description']  . ' '));
            define('META_TAG_KEYWORDS', str_replace('"','',$meta_info[$_SESSION['languages_id']]['keywords'] ));
        }
    }
}
// eof use custom page meta tags



// if per-page metatags overrides have been defined, use those, otherwise use usual defaults:
if ($current_page_base != 'index') {
    if (defined('META_TAG_TITLE_' . strtoupper($current_page_base))) define('META_TAG_TITLE', constant('META_TAG_TITLE_' . strtoupper($current_page_base)));
    if (defined('META_TAG_DESCRIPTION_' . strtoupper($current_page_base))) define('META_TAG_DESCRIPTION', constant('META_TAG_DESCRIPTION_' . strtoupper($current_page_base)));
    if (defined('META_TAG_KEYWORDS_' . strtoupper($current_page_base))) define('META_TAG_KEYWORDS', constant('META_TAG_KEYWORDS_' . strtoupper($current_page_base)));
}

function strip_spanish_special_characters($cName){
    $special = array('Á','á','É','é','Í','í','Ñ','ñ','Ó','ó','Ú','ú','&','®','/','+');
    $general = array('A','a','E','e','I','i','N','n','O','o','U','u','-','-','-','-');
    $cName = str_replace($special, $general, $cName);
    return $cName;
}
// Get different meta tag values depending on main_page values

// 动态专题的meta
if($_GET['from_special_page']){ //动态专题
    $id = $_GET['id'];
    $colums = array('name','meta_keywords','meta_description');
    $sp_data = fs_get_data_from_db_fields_array($colums,'fs_article_descriptions','article_id='.$id.' and language_id='.$_SESSION['languages_id'],'');
    define('META_TAG_TITLE',preg_replace('/FS\s/','FS.COM ',$sp_data[0][0]));
    define('META_TAG_KEYWORDS',$sp_data[0][1]);
    define('META_TAG_DESCRIPTION',$sp_data[0][2]);
}

switch ($_GET['main_page']) {
    case 'print_shopping_list':
        $saved_id = (int)$_GET['saveId'];
        if($saved_id) {
            $save_name = get_save_cart_time($saved_id);
            $save_name = str_replace(array('.','\/','/',':','*','?','"','<','>','|'), '_', $save_name);
            if ($_GET['print_type'] === 'inquiry') {
                define('META_TAG_TITLE', FS_MY_SHOPPING_CART_OFFICIAL_QUOTE.' '.getTime("default3",'',strtoupper($_SESSION['countries_iso_code'])));
            } else {
                define('META_TAG_TITLE', FS_SHOP_CART_ALERT_JS_58.'_'.$save_name);
            }

        }else{
            if ($_GET['print_type'] === 'inquiry') {//Official Quote
                define('META_TAG_TITLE', FS_MY_SHOPPING_CART_OFFICIAL_QUOTE.' '.getTime("default3",'',strtoupper($_SESSION['countries_iso_code'])));
            } else {
                define('META_TAG_TITLE', FS_MY_SHOPPING_CART.' '.getTime("default3",'',strtoupper($_SESSION['countries_iso_code'])));
            }
        }
        define('META_TAG_DESCRIPTION', META_TAGS_COMMON_DESCRIPTION);
        define('META_TAG_KEYWORDS', KEYWORDS . METATAGS_DIVIDER . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : '' ) );
        break;

    case 'fs_special_page':
        $id = $_GET['id'];
        // $colums = array('sp_name','meta_keywords','meta_description');
        // $sp_data = fs_get_data_from_db_fields_array($colums,'fs_special_page','id='.$id.' and language_id='.$_SESSION['languages_id'],'');
        $colums = array('name','meta_keywords','meta_description');
        $sp_data = fs_get_data_from_db_fields_array($colums,'fs_article_descriptions','article_id='.$id.' and language_id='.$_SESSION['languages_id'],'');
        define('META_TAG_TITLE',$sp_data[0][0]);
        define('META_TAG_KEYWORDS',$sp_data[0][1]);
        define('META_TAG_DESCRIPTION',$sp_data[0][2]);

        break;
    case 'advanced_search_result':
        if($_GET['keyword'] == null){
            $url = explode('-po-',$_SERVER['REQUEST_URI']);
            $url = substr($url[0],1);
            $url = str_replace('-',' ',$url);
            $_GET['keyword']=$url;
        }
        $common_title = strip_tags($_GET['keyword']);
        define('META_TAG_TITLE', $common_title);
        define('META_TAG_DESCRIPTION', $common_title);
        define('META_TAG_KEYWORDS', strip_tags($_GET['keyword']));
        break;
    case 'index':
        // bof: categories meta tags
        // run custom categories meta tags
        if(isset($_GET['type'])){
            $type = " type_".$_GET['type'];
        }else $type = "";
        if(isset($_GET['sort_order'])){
            $sort_order = " sort order ".$_GET['sort_order'];
        }else $sort_order = "";
        if(isset($_GET['page'])){
            $page = " page".$_GET['page'];
        }else $page = "";
        $narrow_by = array();
        $unnarrowGET = array('_requestConfirmationToken','cPath','main_page','page','sort_order','type','count','settab');
        if(isset($_GET)){
            foreach($_GET as $k=>$narrow){

                if(!in_array($k,$unnarrowGET)){
                    if($narrow && is_numeric($narrow)){
                        //print_r($narrow);
                        $narrow_by [] = $narrow;

                    }
                }

            }
        }
        //dylan 2019.8.5 Add
        $sql = "select metatags_title,metatags_keywords,metatags_description from " . TABLE_METATAGS_CATEGORIES_DESCRIPTION . " mcd where mcd.categories_id = '" . (int)$current_category_id . "' and mcd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
        $category_metatags = $db->Execute($sql);
        if (!empty($category_metatags->fields['metatags_title']) && empty($narrow_by)) {
            define('META_TAG_TITLE', str_replace('"','',$category_metatags->fields['metatags_title']).$sort_order.$type.$page);
            define('META_TAG_KEYWORDS', str_replace('"','',$category_metatags->fields['metatags_keywords']));
            define('META_TAG_DESCRIPTION', str_replace('"','',$category_metatags->fields['metatags_description']).$sort_order.$type.$page);
        } elseif(isset($narrow_by)){
            for($i=0;$i<sizeof($narrow_by);$i++){
                $sql ="select products_narrow_by_options_values_name  from products_narrow_by_options_values where products_narrow_by_options_values_id  = ".$narrow_by[$i]." and language_id=".(int)$_SESSION['languages_id'];
                $get_narrow_name = $db->getAll($sql);
                foreach($get_narrow_name as $k=> $get_row ){
                    $get_result[]=$get_row;
                    $get_narrow_by .= ', '.$get_result[$i]['products_narrow_by_options_values_name'];
                }
            }
            $categoory_level=get_categories_level($current_category_id);
            $current_cat_name = zen_get_categories_name($current_category_id);//当前分类名称
            $parent_c_name='';
            $parent_c_id = fs_get_data_from_db_fields('parent_id','categories','categories_id='.(int)$current_category_id,'');
            if($parent_c_id !=0){
                $parent_c_name = zen_get_categories_name($parent_c_id);
            }
            $keywords_str = substr(str_replace(',','',$get_narrow_by),1) ? substr(str_replace(',','',$get_narrow_by),1).' - ' : '';
            $get_narrow_by = ($get_narrow_by ? str_replace(',','',trim($get_narrow_by)).' - ' : '');
            define('META_TAG_TITLE', $get_narrow_by.$current_cat_name.' - '.$parent_c_name);
            define('META_TAG_KEYWORDS', $keywords_str.$current_cat_name);
            define('META_TAG_DESCRIPTION', METE_TAGS_CAT_BUY.META_TAG_TITLE.METE_TAGS_CAT_BEST_PRICE.$parent_c_name.META_TAGS_CATEGORIES_DESCRIPTION);
        }
        // custom meta tags
        break;
    //get narrow by meta tags by tom ********************
    case 'narrow':
        require_once DIR_WS_CLASSES.'products_narrow_by.php';
        $products_narrow_by = new products_narrow_by();
        if (isset($_GET['narrow'])) {
            if(sizeof($_GET['narrow']) == 1){
                $meta_narrow = zen_get_meta_of_categories_narrow($current_category_id,$_GET['narrow'][0]);
            }
            if($meta_narrow[0]['id']){
                define('META_TAG_TITLE', $meta_narrow[0]['title']);
                define('META_TAG_KEYWORDS', $meta_narrow[0]['keywords']);
                define('META_TAG_DESCRIPTION', $meta_narrow[0]['description']);
            }else{
                $options_name = $products_narrow_by->get_option_values_name_by_narrows_id($_GET['narrow']);
                for ($i=0,$n=sizeof($options_name);$i<$n;$i++){
                    $values_name .= $options_name[$i].", ";
                    $values_name2 .= $options_name[$i]." ";
                }
                if(isset($_GET['type'])){
                    $type = " type_".$_GET['type'];
                }else $type = "";
                if(isset($_GET['sort_order'])){
                    $sort_order = " sort order ".$_GET['sort_order'];
                }else $sort_order = "";
                if(isset($_GET['page'])){
                    $page = " page".$_GET['page'];
                }else $page = "";
                $current_cat_name = zen_get_categories_name($current_category_id);
                define('META_TAG_TITLE', $values_name.$current_cat_name.$type.$sort_order.$page.METE_TAGS_NARROW_FS);
                define('META_TAG_KEYWORDS', $values_name2.$current_cat_name);
                define('META_TAG_DESCRIPTION', METE_TAGS_CAT_BUY.$values_name2.$current_cat_name.METE_TAGS_NARROW_ONLINE_GLOBAL.$values_name2.$current_cat_name.$type.$sort_order.$page.METE_TAGS_NARROW_OEM_MANUFACTURER);
            }
        }
        break;
    case 'product_reviews_info'://该页面不存在
        $review_on = META_TAGS_REVIEW;
    //  case 'product_info':
    case (strstr($_GET['main_page'], 'product_') or strstr($_GET['main_page'], 'document_')):
        $sql= "select mtpd.metatags_title, mtpd.metatags_keywords, mtpd.metatags_description
                              from  " . TABLE_META_TAGS_PRODUCTS_DESCRIPTION . " as mtpd
                              where mtpd.products_id = '" . (int)$_GET['products_id'] . "' and mtpd.language_id = '" .(int)$_SESSION['languages_id']."'";
        $product_info_metatags = $db->Execute($sql);

        $product_info  = fs_get_data_from_db_fields_array(array('products_name','module_status','product_details','products_title'),TABLE_PRODUCTS_DESCRIPTION,'products_id='.(int)$_GET['products_id'].' and language_id='.(int)$_SESSION['languages_id'],'limit 1');
        $products_name = $product_info[0][0];

        if ($product_info_metatags->EOF) {
            $module_status = $product_info[0][1];
            $products_title = $product_info[0][3];
            $meta_products_name = $products_name;
            $meta_products_key = zen_clean_html($products_name);
            $meta_detail = '';
            //dylan 2019.8.2 Add
            if($product_info[0][2]){
                if($module_status==1){//新版展示products_detail版块前3行
                    $detail = str_replace("；", ";", $product_info[0][2]);
                    $detail = str_replace("：", ":", $detail);
                    //$detail = str_replace(' ','',$detail);
                    $arr = explode(';',$detail);
                    foreach ($arr as $key => $val){
                        if($key==3){
                            break;
                        }
                        $arr_det = explode(':',$val);
                        foreach ($arr_det as $k => $v){
                            $val_det .= trim($v).':';
                        }
                        $meta_detail .= rtrim($val_det,':').',';//去掉末尾冒号
                    }
                }else{//旧版展示标题
                    if($products_title){
                        $meta_detail = $products_title;
                    }
                }
            }
            $meta_detail = trim($meta_detail);
            $meta_products_content = $meta_products_key.','.($meta_detail ? rtrim($meta_detail,',') : "");//去掉末尾逗号
            $meta_products_name = zen_clean_html($meta_products_name);
            define('META_TAG_TITLE', str_replace('"','',$meta_products_name));
            define('META_TAG_DESCRIPTION', str_replace('"','',$meta_products_content));
            define('META_TAG_KEYWORDS', str_replace('"','',$meta_products_key));
        } else {

            if (!empty($product_info_metatags->fields['metatags_title'])) {
                $meta_products_name = '';
                $meta_products_price = '';
                $metatags_keywords = '';
                $meta_products_name .= ($product_info_metatags->fields['metatags_title'] ? $product_info_metatags->fields['metatags_title'] : '');

                if (!empty($product_info_metatags->fields['metatags_description'])) {
                    $metatags_description = $product_info_metatags->fields['metatags_description'];
                } else {
                    $metatags_description = zen_truncate_paragraph(strip_tags(stripslashes($products_name)), MAX_META_TAG_DESCRIPTION_LENGTH);
                }
                $metatags_description = zen_clean_html($metatags_description);

                if (!empty($product_info_metatags->fields['metatags_keywords'])) {
                    $metatags_keywords = $product_info_metatags->fields['metatags_keywords'] ;  // CUSTOM skips categories
                } else {
                    $metatags_keywords = '';
                }

                define('META_TAG_TITLE', str_replace('"','',zen_clean_html($review_on . $meta_products_name)));
                define('META_TAG_DESCRIPTION', str_replace('"','',zen_clean_html($metatags_description . '')));
                define('META_TAG_KEYWORDS', str_replace('"','',$metatags_keywords));

            } else {
                if (META_TAG_INCLUDE_PRICE == '1' and !strstr($_GET['main_page'], 'document_general')) {
                    $P_sql= "select p.products_model, p.products_tax_class_id,p.products_id,p.product_is_free, p.product_is_call
                              from  " . TABLE_PRODUCTS . " as p
                              where p.products_id = '" . (int)$_GET['products_id'] . "'";
                    $product_info_da = $db->Execute($P_sql);
                    if ($product_info_da->fields['product_is_free'] != '1') {
                        if (zen_check_show_prices() == true) {
                            $meta_products_price = zen_get_products_actual_price($product_info_da->fields['products_id']);
                            $prod_is_call_and_no_price = ($product_info_da->fields['product_is_call'] == '1' && $meta_products_price == 0);
                            $meta_products_price = (!$prod_is_call_and_no_price ? SECONDARY_SECTION . $currencies->display_price($meta_products_price, zen_get_tax_rate($product_info_da->fields['products_tax_class_id'])) : '');
                        }
                    } else {
                        $meta_products_price = SECONDARY_SECTION . META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT;
                    }
                } else {
                    $meta_products_price = '';
                }


                //光模块产品调用自定义数据,其他的产品调用模板
                //if($cPath_array[0] == 9){
                // $meta_products_name = $product_info_metatags->fields['metatags_title'] ? $product_info_metatags->fields['metatags_title'] : $products_name;
                // $meta_products_key =  zen_clean_html($product_info_metatags->fields['metatags_keywords']);
                // $meta_products_content = $product_info_metatags->fields['metatags_description'] ? $product_info_metatags->fields['metatags_description'] : $products_name;
                // $meta_products_content = zen_clean_html($meta_products_content);
                //  }else{
                $meta_products_name = $products_name;

                $meta_products_key = zen_clean_html($products_name);
                $meta_products_content = $meta_products_key.METE_TAGS_NARROW_OEM;
                //  }

                $meta_products_name = zen_clean_html($meta_products_name);

                define('META_TAG_TITLE', str_replace('"','',$meta_products_name));
                define('META_TAG_DESCRIPTION', str_replace('"','',$meta_products_content));
                define('META_TAG_KEYWORDS', str_replace('"','',$meta_products_key));

            } // CUSTOM META TAGS
        } // EOF
        break;

    case 'support_detail':
        $meta_support_detail_name = METE_TAGS_SUPPORT_OF_FS ;
        if (isset($_GET['supportid']) && $_GET['supportid']){
            $meta_info = $db->Execute("select support_articles_title as title,meta_title,meta_keyword,meta_description
  		                           from support_articles_description where support_articles_id = " . (int)$_GET['supportid']." and language_id=".(int)$_SESSION['languages_id']);
            $meta_support_detail_name = $meta_info->fields['title'];
            $meta_title = $meta_info->fields['meta_title'];
            $meta_keyword = $meta_info->fields['meta_keyword'];
            $meta_description = $meta_info->fields['meta_description'];
        }

        define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title : $meta_support_detail_name. " : FS.COM") ));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_support_detail_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_support_detail_name) ));
        break;
    //eof support
    //solution
    case 'products_list':
        $meta_support_detail_name = METE_TAGS_SUPPORT_OF_FS;
        if (isset($_GET['s_cid']) && $_GET['s_cid']){
            $meta_info = $db->Execute("select doc_categories_name as title,seo_tag,seo_keyword,seo_description
  		                           from solution_categories_description where doc_categories_id = " . (int)$_GET['s_cid'].' and language_id = '.$_SESSION['languages_id']);
            $meta_support_detail_name = $meta_info->fields['title'];
            $meta_title = $meta_info->fields['seo_tag'];
            $meta_keyword = $meta_info->fields['seo_keyword'];
            $meta_description = $meta_info->fields['seo_description'];
        }

        define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title : $meta_support_detail_name. " : FS.COM") ));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_support_detail_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_support_detail_name) ));
        break	;
    case 'products_detail':
        $meta_support_detail_name = METE_TAGS_SUPPORT_OF_FS;
        if (isset($_GET['s_id']) && $_GET['s_id']){
            $meta_info = $db->Execute("select doc_article_title as title,meta_title,meta_keyword,meta_description
  		                           from solution_article_description where doc_article_id = " . (int)$_GET['s_id'].' and language_id = '.$_SESSION['languages_id']);
            $meta_support_detail_name = strip_spanish_special_characters($meta_info->fields['title']);
            $meta_support_detail_name = preg_replace('/FS\s/','FS.COM ',$meta_support_detail_name);
            $meta_title = $meta_info->fields['meta_title'];
            $meta_title = preg_replace('/FS\s/','FS.COM ',$meta_title);
            $meta_keyword = $meta_info->fields['meta_keyword'];
            $meta_description = $meta_info->fields['meta_description'];
        }

        define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title : $meta_support_detail_name. " : FS.COM") ));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_support_detail_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_support_detail_name) ));
        break	;
    //popular detail
    case 'Product_List'://该页面不存在
        $meta_support_detail_name = METE_TAGS_POPULAR;

//{A} {Page 2}-Fiberstore

// {A}{Page 2}

        if (isset($_GET['tag_type']) && $_GET['tag_type']){
            $sql = "select tag_name from products_tag_type where tag_id =".(int)$_GET['tag_type'];
            $meta_info = $db->Execute($sql);
            $meta_support_detail_name = $meta_info->fields['tag_keywords'];

            $meta_keyword = METE_TAGS_PRODUCTS_LIST.$meta_info->fields['tag_name'];
            $meta_title = METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST.$meta_info->fields['tag_name'].META_TAGS_FIBERSTORE;
            $meta_description = META_TAGS_THE_LEADING. $meta_keyword;
            if($_GET['page']){
                $meta_keyword = $meta_keyword .$_GET['page'];
                $meta_title = ' Fiber optic products list '.$meta_info->fields['tag_name']. $_GET['page'].META_TAGS_FIBERSTORE;
                $meta_description = $meta_description .$_GET['page'];
            }
        }

        define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title: $meta_support_detail_name) ));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_support_detail_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_support_detail_name) ));
        break;
    //fallwind 	2016.9.27
    case 'service':
        $meta_service_name = META_TAGS_CUSTOMER_SERVICE ;
        define('META_TAG_TITLE', str_replace('"','',$meta_service_name ));
        break;
    // bof tutorial
    case 'tutorial_list':
        $meta_tutorail_category_name = META_TAGS_TUTORIAL_OF_COM ;
        if (isset($_GET['c']) && $_GET['c']){
            $meta_info = $db->Execute("select doc_categories_name,meta_title,meta_keyword,meta_description from " .TABLE_DOC_CATEGORIES_DESCRIPTION . " where doc_categories_id = " . (int)$_GET['c'] ." and language_id = ".$_SESSION['languages_id']);
            $meta_tutorail_category_name = $meta_info->fields['doc_categories_name']. " : FS.COM";
            $title = !empty($meta_info->fields['meta_title'])?$meta_info->fields['meta_title']:$meta_tutorail_category_name;
            $keyword = !empty($meta_info->fields['meta_keyword'])?$meta_info->fields['meta_keyword']:$meta_tutorail_category_name;
            $description = !empty($meta_info->fields['meta_description'])?$meta_info->fields['meta_description']:$meta_tutorail_category_name;
        }
        define('META_TAG_TITLE', str_replace('"','',$title ));
        define('META_TAG_DESCRIPTION', str_replace('"','',$description ));
        define('META_TAG_KEYWORDS', str_replace('"','',$keyword ));

        /*define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title : $meta_tutorail_category_name) . ""));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_tutorail_category_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_tutorail_category_name) ));*/


        break;
    case 'tutorial_detail':
        $meta_tutorail_detail_name = META_TAGS_TUTORIAL_OF_COM ;
        if (isset($_GET['a_id']) && $_GET['a_id']){
            $meta_info = $db->Execute("select doc_article_title,meta_title,meta_keyword,meta_description
  		                           from " .TABLE_DOC_ARTICLE_DESCRIPTION . " where doc_article_id = " . (int)$_GET['a_id']." and language_id = ".$_SESSION['languages_id']);
            $meta_tutorail_detail_name = $meta_info->fields['doc_article_title'];
            $meta_title = $meta_info->fields['meta_title'];
            $meta_keyword = $meta_info->fields['meta_keyword'];
            $meta_description = $meta_info->fields['meta_description'];
        }
        define('META_TAG_TITLE', str_replace('"','',(($meta_title) ? $meta_title : $meta_tutorail_detail_name) . ""));
        define('META_TAG_DESCRIPTION', str_replace('"','',(($meta_description) ? $meta_description : $meta_tutorail_detail_name) ));
        define('META_TAG_KEYWORDS', str_replace('"','',(($meta_keyword) ? $meta_keyword : $meta_tutorail_detail_name) ));
        break;
    // eof tutorial
    // bof news
    case 'news_article':
        $meta_news_name = META_TAGS_NEWS_OF_COM ;
        if (isset($_GET['article_id']) && $_GET['article_id']){
            $meta_info = $db->Execute("select news_article_name,meta_title,meta_keyword,meta_description from " .TABLE_NEWS_ARTICLES_TEXT . " where article_id = " . (int)$_GET['article_id']);
            $meta_news_name = $meta_info->fields['news_article_name'];
        }
        if($meta_info->fields['meta_title']){
            define('META_TAG_TITLE', str_replace('"','',$meta_info->fields['meta_title'] . ""));
        }else{
            define('META_TAG_TITLE', str_replace('"','',$meta_news_name . ""));
        }

        if($meta_info->fields['meta_keyword']){
            define('META_TAG_KEYWORDS', $meta_info->fields['meta_keyword']);
        }else{
            define('META_TAG_KEYWORDS', str_replace('"','',$meta_news_name ));
        }
        if($meta_info->fields['meta_title']){
            define('META_TAG_DESCRIPTION', $meta_info->fields['meta_description']);
        }else{
            define('META_TAG_DESCRIPTION', str_replace('"','',$meta_news_name  ));
        }
        break;
    case 'page':
        $ezpage_id = (int)$_GET['id'];
        $chapter_id = (int)$_GET['chapter'];
        if (defined('META_TAG_TITLE_EZPAGE_'.$ezpage_id)) define('META_TAG_TITLE', constant('META_TAG_TITLE_EZPAGE_'.$ezpage_id));
        if (defined('META_TAG_DESCRIPTION_EZPAGE_'.$ezpage_id)) define('META_TAG_DESCRIPTION', constant('META_TAG_DESCRIPTION_EZPAGE_'.$ezpage_id));
        if (defined('META_TAG_KEYWORDS_EZPAGE_'.$ezpage_id)) define('META_TAG_KEYWORDS', constant('META_TAG_KEYWORDS_EZPAGE_'.$ezpage_id));

    case 'customer_qa':
        $qid = $_GET['qid'];
        if($qid){
            $sql = "SELECT qaq.content as qaq_content,qaa.content as qaa_content from question_answer_questions qaq LEFT JOIN question_answer_answers qaa ON(qaq.id=qaa.question_id) WHERE qaq.id=".(int)$qid." LIMIT 1";
            $rst = $db->Execute($sql);
            $qaq_content = $rst->fields['qaq_content'];//问题
            $qaa_content = $rst->fields['qaa_content'];//回答
            $qaa_content = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $qaa_content);
            define('META_TAG_TITLE', $qaq_content);
            define('META_TAG_DESCRIPTION', $qaa_content);
            define('META_TAG_KEYWORDS', KEYWORDS . METATAGS_DIVIDER . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : ''));
        }
        break;
    case 'shopping_cart':
        define('META_TAG_TITLE', META_TAGS_SHOPPING_CART_TITLE);
        define('META_TAG_DESCRIPTION', META_TAGS_SHOPPING_CART_DESCRIPTION);
        define('META_TAG_KEYWORDS', '');
        break;
    case 'saved_items':
        define('META_TAG_TITLE', META_TAGS_SAVED_ITEMS_TITLE);
        define('META_TAG_DESCRIPTION', META_TAGS_SAVED_ITEMS_DESCRIPTION);
        define('META_TAG_KEYWORDS', '');
        break;
    case 'e_rate':
        define('META_TAG_TITLE', FS_ERate_27);
        define('META_TAG_DESCRIPTION', META_TAGS_COMMON_DESCRIPTION);
        define('META_TAG_KEYWORDS', KEYWORDS . METATAGS_DIVIDER . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : '' ) );
        break;
    case 'sfp_optical_module':
        define('META_TAG_TITLE', META_TAGS_SFP_TITLE);
        define('META_TAG_DESCRIPTION', META_TAGS_SFP_DESCRIPTION);
        define('META_TAG_KEYWORDS', KEYWORDS . METATAGS_DIVIDER . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : '' ) );
        break;
// NO "break" here. Allow defaults if not overridden at the per-page level
    case 'offline_products_eos':
        define('META_TAG_TITLE', META_TAGS_EOS_TITLE);
        define('META_TAG_DESCRIPTION', META_TAGS_EOS_DESCRIPTION);
        define('META_TAG_KEYWORDS', '');
        break;
    default:
        //先查询数据库中是否有模板
        $meta_info = zen_get_page_meta_tags('default',$_SESSION['languages_id']);
        if (isset($meta_info[$_SESSION['languages_id']]) && is_array($meta_info[$_SESSION['languages_id']]) && zen_not_null($meta_info[$_SESSION['languages_id']])) {
            define('META_TAG_TITLE', str_replace('"','',$meta_info[$_SESSION['languages_id']]['title'] ));
            define('META_TAG_DESCRIPTION', str_replace('"','',$meta_info[$_SESSION['languages_id']]['description']  . ' '));
            define('META_TAG_KEYWORDS', str_replace('"','',$meta_info[$_SESSION['languages_id']]['keywords'] ));
        }else{
            //没有数据则用前台写死的模板
            define('META_TAG_TITLE', META_TAGS_COMMON_TITLE);
            define('META_TAG_DESCRIPTION', META_TAGS_COMMON_DESCRIPTION);
            define('META_TAG_KEYWORDS', KEYWORDS . METATAGS_DIVIDER . (defined('NAVBAR_TITLE') ? NAVBAR_TITLE : '' ) );
        }

}
// meta tags override due to 404, missing products_id, cPath or other EOF issues
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_MODULE_END_META_TAGS');
?>