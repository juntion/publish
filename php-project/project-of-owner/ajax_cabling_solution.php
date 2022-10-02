<?php
require('includes/application_top.php');

if (isset($_GET['page'])) {
    $limit = (((int)$_GET['page']-1) * 12) . ',' . 12;
    if($_POST['type']){
        //获取所有分类
        $support_categories=$db->getAll("select a.doc_categories_id,ad.doc_categories_name from support_categories as a left join support_categories_description as ad  using(doc_categories_id) where ad.language_id = ".(int)$_SESSION['languages_id']." order by doc_sort_order asc");
        $doc_support_articles="";

//获取所有ID
        foreach ($support_categories as $k=>$v){
            if($k==((int)$_POST['type']-1)){
                $doc_support_articles_ids[]=$db->getAll("select doc_article_id from support_articles_category where doc_categories_id='".$v['doc_categories_id']."'");
            }
        }
        $dco_support_info="";
        $data="";
//所有文章相关信息
        foreach ($doc_support_articles_ids as $k=>$v){
            foreach ($v as $key=>$value){
                $data[$k].=$value['doc_article_id'].",";
            }
            if(!empty($data[$k])){
                $data[$k]= substr($data[$k], 0, -1);
                $dco_support_info[]=$db->getAll("select a.support_articles_image,a.support_articles_id,ad.support_articles_intro,ad.support_articles_title,ad.support_articles_description from support_articles as a left join support_articles_description as ad using(support_articles_id) where support_articles_id in ($data[$k]) and a.support_articles_status = 1 and ad.language_id = ".(int)$_SESSION['languages_id']." order by a.support_articles_sort_order asc limit $limit");

            }
        }

        $html = "";
        $html = '<div class="List_middle_container_bg"></div>';
        foreach ($dco_support_info[0] as $k => $v) {
            $description = $v['support_articles_intro'] ? $v['support_articles_intro'] : $v['support_articles_description'];
            if (preg_match('/<style.*<\/style>/', $description)) {
                $description = preg_replace('/<style.*<\/style>/', '', $description);
            }
            if (preg_match('/<script.*<\/script>/', $description)) {
                $description = preg_replace('/<script.*<\/script>/', '', $description);
            }

            $description = strip_tags($description);
            $description = str_replace('&nbsp;', '', $description);
            $image = $v['support_articles_image'];
            if(strlen($description)>120){
                $description=substr($description,0,120).'...';
            }
            $html .= '<div class="List_middle_container_wap">
               <div class="List_middle_container_wrapper">
               <a style="text-decoration:none" target="_blank" href=' . zen_href_link('support_detail', '&supportid=' . $v['support_articles_id']) . '>
                    <div class="List_middle_bg">
                      <p class="List_middle_bg_p">' . $description . '</p>
                   </div>
                   </a>
                   <a style="text-decoration:none " target="_blank"  href=' . zen_href_link('support_detail', '&supportid=' . $v['support_articles_id']) . '>
                    <div class="List_middle_container_top">
                       <img width="330" height="190"  src="'.HTTPS_IMAGE_SERVER.'images/' . $image . '" alt=' . $v['support_articles_title'] . '/>
                    </div>
                    </a>
                    <a style="text-decoration:none" target="_blank" href=' . zen_href_link('support_detail', '&supportid=' . $v['support_articles_id']) . '>
                    <div class="List_middle_container_middle">
                        <h2 class="List_middle_tit">' . $v['support_articles_title'] . '</h2>
                        <p class="List_middle_txt">Learn More<i class="icon iconfont">&#xf089;</i></p>
                    </div>
                    </a>
                </div>
            </div>';
        }
        if(count($dco_support_info[0])<12){

            $html.='<script>$(".load_more").eq('.($_POST['type']-1).').hide()</script>';


        }
    }else {
        //专题
        require_once ('includes/classes/articles/relationModel.php');
        $relationModel = new relationModel();
        $special_list_data = $relationModel->get_relation_list(4,1,'limit '.$limit);
        $html = "";
        $html = '<div class="List_middle_container_bg"></div>';
        foreach ($special_list_data as $special_v) {
            $html .='<div class="List_middle_container_wap">
                        <div class="List_middle_container_wrapper">
                            <a target="_blank" style="text-decoration:none" href='.$special_v['link_str'].'>
                            <div class="List_middle_bg">
                                <p class="List_middle_bg_p">'.$special_v['description'].'</p>
                            </div>
                             </a>
                             <a target="_blank" style="text-decoration:none" href='.$special_v['link_str'].'>
                            <div class="List_middle_container_top">
                                <img width="330" height="190"  src='.$special_v['img_path'].' alt='.$special_v['title'].'/>     
                            </div>
                            </a>
                            <a target="_blank" style="text-decoration:none" href='.$special_v['link'].'>
                            <div class="List_middle_container_middle">
                                <h2 class="List_middle_tit">'.$special_v['title'].'</h2>
                                <p class="List_middle_txt">Learn More<i class="icon iconfont">&#xf089;</i></p>
                            </div>
                            </a>
                        </div>
                    </div>';
        }

    }
    if (empty($dco_support_info[0]) && empty($special_list_data)) {
        echo 1;
    } else {

        echo $html;
    }
}
