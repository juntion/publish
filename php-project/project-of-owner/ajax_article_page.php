<?php
require('includes/application_top.php');
require('includes/classes/articles/relationModel.php');
require('includes/languages/'.$_SESSION['language'].'/views/resources.php');//加载选择语言包的文件，该文件里面定义加载了要使用的语言包


$type_arr = array(
    'all',
    'videos',
    'case_studies',
    'buying_guide',
    'spotlight',
    'know_how'
);

if(!isset($_POST['type']) || !isset($_POST['page'])){
    return false;
}
$type = $_POST['type'];
if(!in_array($type,$type_arr)){
    return false;
}
$page = (int)$_POST['page'];
$tag = (int)$_POST['tag'];
$tag_arr = array(1,2,3);
switch($type){
    //All
    case 'all':
        $page_num = 5;//每页个数
        $start_num = $page * $page_num;//起始数
        if(in_array($tag,$tag_arr)){
            $where = ' and a.doc_type_id = '.$tag;
            $case_where = ' and A.doc_type_id = '.$tag;
        }else{
            $where = '';
            $case_where = '';
        }

        //获取分类
        $categories_array = array();
        $results = $db->Execute("select doc_categories_id from doc_categories left join doc_categories_description using(doc_categories_id) where language_id=".$_SESSION['languages_id']." and doc_categories_status = 1 and categories_code in ('videos','case_studies','buying_guide','spotlight','know_how')");
        if($results->RecordCount()){
            while(!$results->EOF){
                $categories_array[] = $results->fields['doc_categories_id'];
                $results->MoveNext();
            }
        }
        $categories_str = join(',',$categories_array);

        //image code
        $image_code_arr = array(
            'videos'=>RESOURCE_IMAGE_TAGS_VIDEOS,
            'case_studies'=>RESOURCE_IMAGE_TAGS_CASE_STUDIES,
            'buying_guide'=>RESOURCE_IMAGE_TAGS_BUYING_GUIDE,
            'spotlight'=>RESOURCE_IMAGE_TAGS_SPOTLIGHT,
            'know_how'=>RESOURCE_IMAGE_TAGS_KNOW_HOW
        );

        //总结果数
        $articles_re_query = "select count(*) as total from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
            left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) 
            LEFT JOIN doc_article_category AS ac USING(doc_article_id)
            where ad.doc_des_status = 1 and ad.doc_article_id = a.doc_article_id 
            and ad.language_id = '" . $_SESSION['languages_id'] . "' and ac.doc_categories_id in(".$categories_str.") ".$where;
        $res_count = $db->Execute($articles_re_query);
        $total_num = $res_count->fields['total'];

        //显示的数据
        $article_array = array();
        $articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
            left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) 
            LEFT JOIN doc_article_category AS ac USING(doc_article_id) 
            where ad.doc_des_status = 1 and ad.doc_article_id = a.doc_article_id 
            and ad.language_id = '" . $_SESSION['languages_id'] . "' and ac.doc_categories_id in(".$categories_str.") ".$where."
            order by doc_article_des_last_modified DESC limit ".$start_num.",".$page_num;
        $res_articles = $db->Execute($articles_query);
        if ($res_articles->RecordCount()) {
            while (!$res_articles->EOF) {
                $article_href = zen_href_link('tutorial_detail','&a_id='.$res_articles->fields['doc_article_id'],'NONSSL');
                $article_time = date('Y-m-d',strtotime($res_articles->fields['doc_article_des_last_modified']));
                $res_articles->fields['doc_article_title'] = str_replace('FS.COM','FS',$res_articles->fields['doc_article_title']);
                $article_title = $res_articles->fields['doc_article_title'];
                $categories_code = fs_get_data_from_db_fields('categories_code','doc_categories_description','doc_categories_id = '.$res_articles->fields['doc_categories_id'],'');
                if($categories_code == 'case_studies' && $_SESSION['languages_id'] == 1){
                    $article_content = stripcslashes($res_articles->fields['doc_article_des']);
                    $writer = TUTORIAL_DETAIL_04;
                }else{
                    $article_content = str_replace ('###article-head###','', $res_articles->fields['doc_article_content']);
                    $article_content = strip_tags($article_content);
                    $article_content = str_replace('FS.COM','FS',$article_content);
                    $article_content = (strlen($article_content) > 235 ) ? mb_substr($article_content, 0, 234, 'utf-8').'...' :$article_content;
                    $writer = RESOURCE_OFFICAL;
                }
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $article_title = swap_american_to_britain($article_title);
                    $article_content = swap_american_to_britain($article_content);
                }
                $image_code = $image_code_arr[$categories_code];
                $iamge = zen_get_img_change_src('images/'.$res_articles->fields['doc_article_image']);
                $article_array[] = array(
                    'id' => $res_articles->fields['doc_article_id'],
                    'title' => $article_title,
                    'content' => $article_content,
                    'image' => $iamge,
                    'code' => $image_code,
                    'time' => $article_time,
                    'img_type' => $res_articles->fields['img_type'],
                    'url' => $article_href,
                    'writer' => $writer
                );
                $res_articles->MoveNext();
            }
        }

        //显示的数据个数
        $count = count($article_array);


        //专题获取
        $data_sql = "select * from fs_article_category_block_relation R
                LEFT join fs_article_category_block_relation_descriptions D on D.relation_id = R.id and D.language_id= {$_SESSION['languages_id']}
                LEFT join fs_article_blocks B on R.block_id = B.id
                LEFT join fs_articles A on R.article_id = A.id
                WHERE R.block_id = 4 and D.status = 1 {$case_where} order by A.last_update_date desc,R.sort asc,R.id desc limit 0,3";
        $relationModel = new relationModel();
        $arr = $db->getAll($data_sql);
        $case_array = $relationModel->arrange_relation_list($arr);
        foreach($case_array as $k=>$v){
            if(strlen($v['description'])>120){
                $case_array[$k]['description'] = mb_substr($v['description'],0,120,'utf-8').'...';
            }
            if(strlen($v['title'])>50){
                $case_array[$k]['title'] = mb_substr($v['title'],0,50,'utf-8').'...';
            }
        }


        //是否显示加载按钮
        if($start_num + $page_num < $total_num){
            $btn = 'show';
        }else{
            $btn = 'hide';
        }

        //返回的json数据
        $json = array(
            'total' => $total_num,
            'count' => $count,
            'data' => $article_array,
            'case_data' =>$case_array,
            'btn' => $btn
        );
        echo json_encode($json);
        exit;
        break;

    //case studies
    case 'case_studies':
        $page_num = 9;//每页个数
        $start_num = $page * $page_num;//起始数
        $categories_code = $type;

        if(in_array($tag,$tag_arr)){
            $where = ' and A.doc_type_id = '.$tag;
        }else{
            $where = '';
        }

        //专题总数量
        $sql = "select count(*) as total
                from fs_article_category_block_relation R
                LEFT join fs_article_category_block_relation_descriptions D on D.relation_id = R.id and D.language_id= {$_SESSION['languages_id']}
                LEFT join fs_article_blocks B on R.block_id = B.id
                LEFT join fs_articles A on R.article_id = A.id
                WHERE R.block_id = 4 and D.status = 1 ".$where;
        $res_count = $db->Execute($sql);
        $total_num = $res_count->fields['total'];

        //专题数据查询
        $data_sql = "select * from fs_article_category_block_relation R
                LEFT join fs_article_category_block_relation_descriptions D on D.relation_id = R.id and D.language_id= {$_SESSION['languages_id']}
                LEFT join fs_article_blocks B on R.block_id = B.id
                LEFT join fs_articles A on R.article_id = A.id
                WHERE R.block_id = 4 and D.status = 1 {$where} order by A.last_update_date DESC,R.sort asc,R.id desc limit {$start_num},{$page_num}";
        $relationModel = new relationModel();
        $arr = $db->getAll($data_sql);
        $article_array = $relationModel->arrange_relation_list($arr);

        //显示的数据个数
        $count = count($article_array);

        //是否显示加载按钮
        if($start_num + $page_num < $total_num){
            $btn = 'show';
        }else{
            $btn = 'hide';
        }

        //返回的json数据
        $json = array(
            'total' => $total_num,
            'count' => $count,
            'data' => $article_array,
            'btn' => $btn
        );
        echo json_encode($json);
        exit;
        break;

    //videos and others
    default :
        $page_num = 9;//每页个数
        $start_num = $page * $page_num;//起始数

        $categories_code_arr = array('spotlight','buying_guide');
        if(in_array($type,$categories_code_arr)){
            $categories_code = $categories_code_arr;
        }else{
            $categories_code = explode(",", $type);
        }
        foreach($categories_code as $v){
            $doc_categories_id[] = fs_get_data_from_db_fields('doc_categories_id','doc_categories_description','language_id = "'.$_SESSION['languages_id'].'" and categories_code = "'.$v.'"','');
        }
        $doc_categories_id = implode(",",$doc_categories_id);
        if(strstr($doc_categories_id,",")){
            $doc_categories_id = "in (".$doc_categories_id.")";
        }else{
            $doc_categories_id = "= ".$doc_categories_id;
        }

        if(in_array($tag,$tag_arr)){
            $where = ' and a.doc_type_id = '.$tag;
        }else{
            $where = '';
        }

        //总结果数
        $articles_re_query = "select count(*) as total from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
            left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) LEFT JOIN doc_article_category AS dac USING(doc_article_id) where ad.doc_des_status = 1 and ad.doc_article_id = a.doc_article_id 
            and ad.language_id = '" . $_SESSION['languages_id'] . "' and doc_categories_id ".$doc_categories_id.$where;
        $res_count = $db->Execute($articles_re_query);
        $total_num = $res_count->fields['total'];

        //显示的数据
        $article_array = array();
        $articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
            left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id) LEFT JOIN doc_article_category AS dac USING(doc_article_id) where ad.doc_des_status = 1 and ad.doc_article_id = a.doc_article_id 
            and ad.language_id = '" . $_SESSION['languages_id'] . "' and doc_categories_id ".$doc_categories_id.$where."
            order by doc_article_des_sort_order != 0 DESC,doc_article_des_sort_order ASC,doc_article_des_last_modified DESC limit ".$start_num.",".$page_num;

        $res_articles = $db->Execute($articles_query);
        if ($res_articles->RecordCount()) {
            while (!$res_articles->EOF) {
                $article_href = zen_href_link('tutorial_detail','&a_id='.$res_articles->fields['doc_article_id'],'NONSSL');
                $article_time = date('Y-m-d H:i',strtotime($res_articles->fields['doc_article_des_last_modified']));
                $res_articles->fields['doc_article_title'] = str_replace('FS.COM','FS',$res_articles->fields['doc_article_title']);
                $article_title = strip_tags( (strlen($res_articles->fields['doc_article_title']) > 60 ) ? mb_substr($res_articles->fields['doc_article_title'], 0, 59,'utf-8').'...' :$res_articles->fields['doc_article_title']);
                $article_content = strip_tags($res_articles->fields['doc_article_content']);
                $article_content = str_replace('FS.COM','FS',$article_content);
                $article_content = (strlen($article_content) > 235 ) ? mb_substr($article_content, 0, 234,'utf-8').'...' :$article_content;
                if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                    $article_title = swap_american_to_britain($article_title);
                    $article_content = swap_american_to_britain($article_content);
                }
                $iamge = zen_get_img_change_src('images/'.$res_articles->fields['doc_article_image']);
                $article_array[] = array(
                    'id' => $res_articles->fields['doc_article_id'],
                    'title' => $article_title,
                    'content' => $article_content,
                    'image' => $iamge,
                    'time' => $article_time,
                    'img_type' => $res_articles->fields['img_type'],
                    'url' => $article_href
                );
                $res_articles->MoveNext();
            }
        }

        //显示的数据个数
        $count = count($article_array);

        //是否显示加载按钮
        if($start_num + $page_num < $total_num){
            $btn = 'show';
        }else{
            $btn = 'hide';
        }

        //返回的json数据
        $json = array(
            'total' => $total_num,
            'count' => $count,
            'data' => $article_array,
            'btn' => $btn
        );
        echo json_encode($json);
        exit;
        break;
}
