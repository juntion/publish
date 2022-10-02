<?php
require('includes/application_top.php');
//下面一行代码是将tpl_tutorial_default.php同级视图文件下的tpl_tutorial_right_slide_bar.php文件引用进来
require($template->get_template_dir('tpl_tutorial_right_slide_bar.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/'.'tpl_tutorial_right_slide_bar.php');

if (isset($_GET['page'])) {
    if (isset($_POST['category']) && !empty($_POST['category']) && $_POST['category']!=0) {
        $id=$_POST['category']-1;
        $category = $doc_array[$id]['doc_categories_id'];
        $doc_article = $db->getAll("select doc_article_id from doc_article_category where doc_categories_id=" . $category);
        if (!empty($doc_article)) {
            $doc_article_ids = i_array_column($doc_article, doc_article_id);
            foreach ($doc_article_ids as $k => $v) {
                $doc_article_ids_str .= $v . ",";
            }
            $doc_article_ids_str = rtrim($doc_article_ids_str, ',');
        }
    }
    if ($pages_num == '') {
        if (isset($_GET['page'])) {

            $pages_num = 12;
        }
    }
    //tag id组
    if (!empty($_GET['tag_id'])) {
        $article_ids = $db->getAll("select article_id from doc_tag_article where tag_id=" . $_GET['tag_id'] . "");
        if (!empty($article_ids)) {
            $arr = "";
            foreach ($article_ids as $v) {
                $arr .= $v['article_id'] . ",";
            }
            $arr = rtrim($arr, ",");
        }
        $arrInfo = "";
//        if (!empty($_POST['category'])) {
//            foreach ($article_ids as $k => $v) {
//                foreach ($doc_article_ids as $key => $value) {
//                    if ($v['article_id'] == $value) {
//                        $arrInfo .= $v['article_id'] . ",";
//                    }
//                }
//            }
//            if (!empty($arrInfo)) {
//                $arrInfo = substr($arrInfo, 0, -1);
//            }
//        }
    }
    $limit = (((int)$_GET['page']+1 - 1) * 16) . ',' . 16;
    if (!empty($doc_article_ids_str)) {
        if (!empty($_GET['tag_id']) && !empty($arr) && empty($_POST['category'])) {
            if (empty($arrInfo)) {
                $arrInfo = 0;
            }
            $tutorial_articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id)
	where ad.doc_article_id in ($arrInfo) and doc_article_status = 1 and ad.doc_article_id = a.doc_article_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.language_id = '" . $_SESSION['languages_id'] . "' order by doc_article_last_modified DESC limit ".$limit;
            $tutorial_articles = $db->Execute($tutorial_articles_query);
        } else {
            //分类筛选新闻
            $tutorial_articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id)
	where ad.doc_article_id in ($doc_article_ids_str) and doc_article_status = 1 and ad.doc_article_id = a.doc_article_id and ad.language_id = '" . $_SESSION
                ['languages_id'] . "' and a.language_id = '" . $_SESSION['languages_id'] . "' order by doc_article_last_modified DESC";
            $split = new splitPageResults($tutorial_articles_query, $pages_num, 'ad.doc_article_id', 'page');
//         print_r($split);die;
            if($_GET['page']<=$split->number_of_pages){
                $tutorial_articles = $db->Execute($split->sql_query);
            }else{
                echo '<script>$(".load_more").eq('.$_POST['category'].').hide()</script>';die;
            }
        }} else {
        //全部新闻
        if (!empty($_GET['tag_id']) && !empty($arr) && empty($_POST['category'])) {
            $tutorial_articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id)
	where  ad.doc_article_id in ($arr) and  doc_article_status = 1 and ad.doc_article_id = a.doc_article_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.language_id = '" . $_SESSION['languages_id'] . "' order by doc_article_last_modified DESC limit ".$limit;
            $tutorial_articles = $db->Execute($tutorial_articles_query);
        } else {
            $tutorial_articles_query = "select * from " . TABLE_DOC_ARTICLE_DESCRIPTION . " as ad
	left join " . TABLE_DOC_ARTICLE . " as a using(doc_article_id)
	where doc_article_status = 1 and ad.doc_article_id = a.doc_article_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.language_id = '" . $_SESSION
                ['languages_id'] . "' order by doc_article_last_modified DESC";
            $split = new splitPageResults($tutorial_articles_query, $pages_num, 'ad.doc_article_id', 'page');
            if($_GET['page']<=$split->number_of_pages){
                $tutorial_articles = $db->Execute($split->sql_query);
            }else{
                echo '<script>$(".load_more").eq('.$_POST['category'].').hide()</script>';die;
            }
        }}

    $sql = "select 	index_article_show_num from `doc_set_other` where index_article_show_num <> '' and cate_article_show_num <> '' ";
    $res = $db->Execute($sql);
//$pages_num = $res->fields['index_article_show_num'];





    $tutorial_article_array = array();

    if ($tutorial_articles->RecordCount()) {
        while (!$tutorial_articles->EOF) {
            $tutorial_article_array[] = array(
                'id' => $tutorial_articles->fields['doc_article_id'],
                'title' => $tutorial_articles->fields['doc_article_title'],
                'content' => $tutorial_articles->fields['doc_article_content'],
                'image' => $tutorial_articles->fields['doc_article_image'],
                'time' => $tutorial_articles->fields['doc_article_last_modified']
            );
            $tutorial_articles->MoveNext();
        }
    }

    $html = "";
    $html = '<div class="List_middle_container_bg"><input  type="hidden" class="input" value='.$_GET['page'].'>
</div>';
    if (!empty($tutorial_articles)) {
        foreach ($tutorial_article_array as $n => $tutorial_article) {
            $tutorial_article_href = zen_href_link('tutorial_detail', '&a_id=' . $tutorial_article['id'], 'NONSSL');
            $tutorial_article_title = $tutorial_article['title'];
            $tutorial_article_content = $tutorial_article['content'];
            $tutorial_article_image = $tutorial_article['image'];
            $tutorial_article_time = date('F j, Y', strtotime($tutorial_article['time']));
            $tutorial_article_time = date('M d,Y', strtotime($tutorial_article['time']));
            $tutorial_article_title = strip_tags((strlen($tutorial_article_title) > 60) ? substr($tutorial_article_title, 0, 59) . '...' : $tutorial_article_title);
            $tutorial_article_content = strip_tags($tutorial_article_content);
            $tutorial_article_content = (strlen($tutorial_article_content) > 235) ? substr($tutorial_article_content, 0, 234) . '...' : $tutorial_article_content;
            $tag_array = array();
            $result = $db->Execute("select tag_id,tag_name from doc_tag_article left join doc_tag_description using(tag_id) where article_id =" . $tutorial_article['id'] . " 
and language_id=" . $_SESSION['languages_id']);
            if ($result->RecordCount()) {
                while (!$result->EOF) {
                    $tag_array[] = array('id' => $result->fields['tag_id'], 'text' => $result->fields['tag_name']);
                    $result->MoveNext();
                }
                if($tag_array[0]['text']){
                    $tag=" tag";
                }

                $article_logo_img = stripslashes($tutorial_article['content']);
                preg_match_all('/<img.*?src="(.*?)".*?>/is', $article_logo_img, $article_logo_img_array);

                $html .= '<div class="List_middle_container_wap">
<div class="List_middle_container_wrapper">
<a target="_blank" style="text-decoration:none" href=' . $tutorial_article_href . '>
<div class="List_middle_bg'.$tag.'">
<p class="List_middle_bg_p">' . $tutorial_article_content . '</p>
</div></a>';
                $html .= '<div class="List_middle_container_top">';

                if (!empty($tutorial_article_image)) {
                    $html .= '<a href=' . $tutorial_article_href . '><img src="'.HTTPS_IMAGE_SERVER.'images/' . $tutorial_article_image . '" width="373" height="200" /></a>';
                } elseif (!empty($article_logo_img_array[1][0])) {
                    $html .= '<a href=' . $tutorial_article_href . '><img src=' .HTTPS_IMAGE_SERVER. $article_logo_img_array[1][0] . ' width="373" height="200" /></a>';
                } else {
                    $html .= '<a href=' . $tutorial_article_href . '><img src="'.HTTPS_IMAGE_SERVER.'images/tutorial/tutorial_01.jpg" width="373" height="200" /></a>';
                }
                if (is_array($tag_array) && !empty($tag_array)) {
                    $tags = '';
                    $b = 0;
                    foreach ($tag_array as $v) {
                        $b++;
                        if ($b < 2) {
                            $tags .= '<span>' . $v['text'] . '</span>' . ' , ';
                            ['text'].'</a>'.'&nbsp;&nbsp;,&nbsp;&nbsp;';
                        }
                    }
                    if (!empty($new_tags)) {
                        $new_tags = substr($tags, 0, -2);
                    } else {
                        $new_tags = "article";
                    }
                }
                $html.= '<span class="List_middle_container_top_span">' . $new_tags . '</span>
                </div>
                <a target="_blank" style="text-decoration:none" href=' . $tutorial_article_href . '>
                <div class="List_middle_container_middle">
                                <h2 class="List_middle_tit">' . $tutorial_article_title . '</h2>
                                <p class="List_middle_txt">Learn More<i class="icon iconfont">&#xf089;</i></p>
                                </div>
                                </a>
                                </div>
                                </div>';
            }
        }
        if(count($tutorial_article_array)<12){
            if(isset($_GET['tag_id'])){
                $html.='<script>$(".load_more").hide()</script>';
            }else{
                $html.='<script>$(".load_more").eq('.$_POST['category'].').hide()</script>';
            }

        }
        if(empty($tutorial_article_array)){
            echo 1;
        }else{
            echo $html;
        }
    }
}
