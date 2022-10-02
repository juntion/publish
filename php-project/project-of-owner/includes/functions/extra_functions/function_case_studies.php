<?php
/**
 * add by jeremy 2019/5/31
 * 获取Industry筛选项
 * @$parent_id int 一级筛选项ID
 * @$instudy_id int/array 二级筛选项ID
 * $type int 返回数组类型 1：一级筛选项ID数组 2：二级筛选项ID数组
 * @return Array
 */
function get_industry_type_arr($parent_id=0,$instudy_id=0,$type=0){
    global $db;
    $where = " parent_id = ".$parent_id;
    if($instudy_id){
        if(is_array($instudy_id)){
            $where = " industry_id in (".implode(',',$instudy_id).")";
        }else{
            $where = " industry_id = ".$instudy_id;
        }
    }
    $industry_res = $db->Execute("select industry_id,parent_id,industry_name,industry_icon_path from doc_categories_industry_options where ".$where." and language_id = ".(int)$_SESSION['languages_id']." order by industry_id asc");
    $result = array();
    while (!$industry_res->EOF) {
        if($type==1){
            $result[] = $industry_res->fields['parent_id'];
        }elseif($type==2){
            $result[] = $industry_res->fields['industry_id'];
        }else{
            $industry_icon_path = $industry_res->fields['industry_icon_path'] ? $industry_res->fields['industry_icon_path'] : '/includes/templates/fiberstore/images/case_customer/case_svg07.svg';
            $result[] = array(
                'id' => $industry_res->fields['industry_id'],
                'text' => $industry_res->fields['industry_name'],
                'icon' => zen_get_img_change_src('images/'.$industry_icon_path),
            );
        }
        $industry_res->MoveNext();
    }
    if($type == 1){
        if(is_array($instudy_id)){
            $result = array_merge($result,$instudy_id);
        }else{
            $result[] = $instudy_id;
        }
    }elseif($type==2){
        $result[] = $parent_id;
    }
    return $result;
}

//case studies文章页面
function get_new_case_studies($page=0,$region_type=0,$industry_type=0,$case_type=0){
    global $db;
    $doc_region_type_arr = array(
        0=>array(
            'id'=>1,
            'text'=>CASE_STUDIES_02
        ),
        1=>array(
            'id'=>2,
            'text'=>CASE_STUDIES_03
        ),
        2=>array(
            'id'=>3,
            'text'=>CASE_STUDIES_04
        ),
        3=>array(
            'id'=>4,
            'text'=>CASE_STUDIES_05
        ),
        4=>array(
            'id'=>5,
            'text'=>CASE_STUDIES_06
        ),
        5=>array(
            'id'=>6,
            'text'=>CASE_STUDIES_07
        ),
        6=>array(
            'id'=>7,
            'text'=>CASE_STUDIES_08
        ),
    );

    $doc_case_type_arr = array(
        0=>array(
            'id'=>1,
            'text'=>CASE_STUDIES_10
        ),
        1=>array(
            'id'=>2,
            'text'=>CASE_STUDIES_11
        ),
        2=>array(
            'id'=>3,
            'text'=>CASE_STUDIES_12
        )
    );

    //code
    $categories_code = 'case_studies';

    $doc_categories_id = fs_get_data_from_db_fields('doc_categories_id','doc_categories_description','language_id = "'.$_SESSION['languages_id'].'" and categories_code = "'.$categories_code.'"','');

    $where = '';
    $clear_choose_html = '<div class="new_proList_reciveBox">';
    if($region_type !=0){
        $where.= ' and doc_region_type_id = '.$region_type;
        $clear_choose_html .='<div class="new_proList_reciveCont">
                             <a data-id="'.$region_type.'" data-type="1">
                              <p class="new_proList_reciveTxt"></p><span class="iconfont icon"></span>
                              '.CASE_STUDIES_01.': '.$doc_region_type_arr[$region_type-1]['text'].'
                             </a>
                          </div>';
    }
    if($case_type !=0){
        $where.= ' and doc_case_type_id = '.$case_type;
        $clear_choose_html .='<div class="new_proList_reciveCont">
                             <a data-id="'.$case_type.'" data-type="2">
                              <p class="new_proList_reciveTxt"></p><span class="iconfont icon"></span>
                              '.CASE_STUDIES_09.': '.$doc_case_type_arr[$case_type-1]['text'].'
                             </a>
                          </div>';
    }
    if($industry_type !=0){
        $parent_ids = get_industry_type_arr($industry_type,0,2);//获取二级分类
        $industry_type_ids = implode(',',$parent_ids);
        $where.= ' and doc_industry_type_id in ('.$industry_type_ids.')';
        $doc_industry_name = get_industry_type_arr(0,$industry_type);//获取一级分类
        $clear_choose_html .='<div class="new_proList_reciveCont">
                     <a data-id="'.$industry_type.'" data-type="3">
                      <p class="new_proList_reciveTxt"></p><span class="iconfont icon"></span>
                      '.CASE_STUDIES_13.': '.$doc_industry_name[0]['text'].'
                     </a>
                  </div>';
    }
    $clear_choose_html .='    <span class="new_proList_reciveClebtn">
                            <a href="'.zen_href_link('case_studies').'" class="new_proList_shipTime_link">'.CASE_CLEAR_ALL.'</a>
                         </span>';

    $tutorial_article_array = array();
    
    $articles_query_sql= "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) LEFT JOIN doc_article_category AS dac USING(doc_article_id) where doc_des_status = 1 and ad.doc_article_id = a.doc_article_id 
	and ad.language_id = '" . $_SESSION['languages_id'] . "' and doc_categories_id = ".$doc_categories_id.$where." order by doc_article_des_sort_order != 0 DESC,doc_article_des_sort_order ASC,doc_article_des_last_modified DESC";

    if($page == 0){
        $page = 1;
    }
    $start = ($page-1) * 6;
    $limit = " limit ".$start.",6";
    //echo $limit;
    $res_articles = $db->Execute($articles_query_sql.$limit);
    //该分类文章下面所展示的类型
    $case_id_arr = [];
    $industry_id_arr = [];
    $region_id_arr = [];
    $all_article_type = $db->Execute($articles_query_sql);
    if($all_article_type->RecordCount()){
        while (!$all_article_type->EOF){
            $case_id_arr[] = $all_article_type->fields['doc_case_type_id'];
            $industry_id_arr[] = $all_article_type->fields['doc_industry_type_id'];
            $region_id_arr[] = $all_article_type->fields['doc_region_type_id'];
            $all_article_type->MoveNext();
        }
    }
    $clear_choose_html .='<div class="new_proList_resultTxt">'.sizeof($region_id_arr) .' '. (sizeof($region_id_arr)>1 ? FS_PRODUCTS : FS_PRODUCT).'</div>';
    $clear_choose_html .='</div>';



    $case_html = '';
    $industry_html = '';
    $region_html = '';
    $case_id_arr = array_filter(array_unique($case_id_arr));
    $industry_id_arr = array_filter(array_unique($industry_id_arr));
    $region_id_arr = array_filter(array_unique($region_id_arr));
    if($case_id_arr || $industry_id_arr || $region_id_arr){
        if($region_id_arr){
            foreach ($region_id_arr as $v){
                $class='';
                if($region_type == $v){
                    $class .= "choosez";
                }
                $region_html .='<li onclick="doc_region_type('.$v.')" class="'.$class.'" data-region="'.$v.'">'.$doc_region_type_arr[$v-1]['text'].'</li>';
            }
        }
        if($case_id_arr){
            foreach ($case_id_arr as $v){
                $class='';
                if($case_type == $v){
                    $class .= "choosez";
                }
                $case_html .='<li onclick="doc_case_type('.$v.')" class="'.$class.'" data-case="'.$v.'">'.$doc_case_type_arr[$v-1]['text'].'</li>';
            }
        }
        if($industry_id_arr){
            $industry_id_arr = get_industry_type_arr(0,$industry_id_arr,1);//1级分类
            $industry_id_arr = get_industry_type_arr(0,$industry_id_arr);
            foreach ($industry_id_arr as $vv){
                $class='';
                if($industry_type == $vv['id']){
                    $class .= "choosez";
                }
                $industry_html .='<li onclick="doc_industry_type('.$vv['id'].')" class="'.$class.'" data-industry="'.$vv['id'].'">'.$vv['text'].'</li>';
            }
        }
    }

    $listing_split = new splitPageResults($articles_query_sql, 6, 'a.doc_article_id', 'page');
    $totalNum = $listing_split->number_of_rows;
    //$page_links = $listing_split->display_links_listing_new(1,'',1,$page);


    if ($res_articles->RecordCount()) {
        while (!$res_articles->EOF) {
            $article_href = zen_href_link('tutorial_detail','&a_id='.$res_articles->fields['doc_article_id'],'NONSSL');
            $article_time = date('Y-m-d H:i',strtotime($res_articles->fields['doc_article_des_last_modified']));
            $res_articles->fields['doc_article_title'] = str_replace('FS.COM','FS',$res_articles->fields['doc_article_title']);
            $article_title = strip_tags( (strlen($res_articles->fields['doc_article_title']) > 60 ) ? mb_substr($res_articles->fields['doc_article_title'], 0, 59,'utf-8').'...' :$res_articles->fields['doc_article_title']);
            $images = zen_get_img_change_src('images/'.$res_articles->fields['doc_article_image']);
            $logo_images = zen_get_img_change_src('images/'.$res_articles->fields['doc_article_logo_image']);
            $tutorial_article_array[] = array(
                'id' => $res_articles->fields['doc_article_id'],
                'title' => $article_title,
                'doc_article_des' => $res_articles->fields['doc_article_des'],
                //'content' => $article_content,
                'image' => $images,
                'logo_image' => $logo_images,
                'doc_company_name'=> $res_articles->fields['doc_company_name'],
                'doc_country_info_id'=> $res_articles->fields['doc_country_info_id'],
                'time' => $article_time,
                'img_type' => $res_articles->fields['img_type'],
                'url' => $article_href
            );
            $res_articles->MoveNext();
        }
    }

    $case_studies_html  = '';
    if(count($tutorial_article_array)){
        foreach($tutorial_article_array as $article){
            $logo_html = '';
            if($article['logo_image']){
                $logo_html = $article['logo_image'];
            }
            $countries_name = get_countries_name($article['doc_country_info_id']);
            $case_studies_html .='<dl class="Case_dl">';
            $case_studies_html .='
                <a class="Coll_Subject_bottom_a01" href="'.$article['url'].'">
                    <dt>
                        <img src="'.$article['image'].'">
                        <span class="Coll_Subject_Content_sign">'.CASE_CATEGORY_MENU_CASE_STUDIES.'</span>
                    </dt>
                    <dd class="Case_dd_active">
                        <div class="Coll_Subject_bottom">
                            <h2 class="Coll_Subject_bottom_tit">
                            '.$article['title'].'
                            </h2>
                            <div class="fs-caseStudy-bottomTxt">
                                '.stripcslashes($article['doc_article_des']).'
                            </div>
                        </div>
                    </dd>
                </a>
            </dl>';
        }
    }

    if((sizeof($tutorial_article_array) + ($page-1)*6) < $totalNum){
        $page_more = 'show';
    }else{
        $page_more = 'hide';
    }
    return array(
        'case_studies_html' => $case_studies_html,
        'page_more' => $page_more,
        'case_html' => $case_html,
        'industry_html' => $industry_html,
        'region_html' => $region_html,
        'clear_choose_html' => $clear_choose_html,
        'page'=> ($page+1),
    );
}
