<?php

/**
 * Created by ery.
 * 新闻文章
 * Date: 2019/2/14
 * Time: 10:26
 */
class newsArticleModel
{
    public function __construct(){
    }

    /**
     * 获取文章列表
     */
    public function get_all_news_list($keyword='', $event='', $where='', $limit='')
    {
        global $db;
        $news = array();
        $sql = $this->get_article_list_sql($keyword, $event, $where, $limit);
        $result = $db->Execute($sql);
        while(!$result->EOF){
            $image_src = stripslashes($result->fields['news_image']);
            if($image_src){
                $image_src = zen_get_img_change_src('images/'.$image_src);
            }
            $keywords = trim($result->fields['keywords'],',');
            $keywords = explode(',',$keywords);
            $tag = [];
            if($keywords[0]){
                $tag = $this->get_tag_name($keywords[0]);
            }
            //对article_name 进行处理 fs.com变 fs
            $articleName =  stripslashes($result->fields['news_article_name']);
            $articleName = str_replace('FS.COM Inc','###small###',$articleName);
            $articleName = str_replace('FS.COM INC','###big###',$articleName);

            $articleName = str_replace('FS.COM','FS',$articleName);

            $articleName = str_replace('###small###','FS.COM Inc',$articleName);
            $articleName = str_replace('###big###','FS.COM INC',$articleName);
            //news_artilce_text
            $news_artilce_text = $result->fields['news_article_text'];
            $news_artilce_text = str_replace('FS.COM Inc','###small###',$news_artilce_text);
            $news_artilce_text = str_replace('FS.COM INC','###big###',$news_artilce_text);

            $news_artilce_text = str_replace('FS.COM','FS',$news_artilce_text);

            $news_artilce_text = str_replace('###small###','FS.COM Inc',$news_artilce_text);
            $news_artilce_text = str_replace('###big###','FS.COM INC',$news_artilce_text);


            $news[] = array(
                'articleName' => $articleName,
                'articleLink'=>zen_href_link(FILENAME_NEWS_ARTICLE,'&article_id='.$result->fields['article_id']),
                'news_image' => $image_src,
                'news_date_published'=> $result->fields['news_date_published'],
                'addTime'=> date('M d, Y',strtotime($result->fields['news_date_published'])),
                'news_article_text'=> $news_artilce_text,
                'keywords'=>$tag[0]['keywords'],
                'news_link'=> $result->fields['news_link'],

            );
            $result->MoveNext();
        }
        return $news;
    }


    /*处理新闻banner 广告图的链接  链接可能是博客文章的链接 绝对路径  可能fs.com上的链接 相对路径
     * */
    public function arange_articles_url($url){
        if(strpos($url,'https') !== false){
            $real_url = $url;
        }else{
            $_SESSION['languages_code'] !== 'en' ?  $pre = $_SESSION['languages_code'].'/' : $pre =  '';
            $real_url = $pre . $url;
        }
        return $real_url;
    }


    /**
     * 公用获取SQL
     * $type 区别SQL类型 默认为1获取具体字段内容 type=2统计总数
     */
    public function get_article_list_sql($keyword='', $event='', $where='', $limit='', $type=1){
        global $db;
        $show_where = $this->get_news_where_sql();
        if($keyword){
            //tag标签参数 $keyword既可以是tag标签的ID也可以是name
            if((int)$keyword){
                $tag_id = (int)$keyword;
            }else{
                $tag = $db->getAll("select id from news_keywords where keywords = '" . trim($keyword) . "' limit 1");
                $tag_id = $tag[0]['id'];
            }
            if($tag_id){
                $show_where.= "  AND na.keywords LIKE '%," . $tag_id . ",%' ";
            }
        }
        if($event){
            //年份筛选参数
            $show_where.= " AND date_format(na.news_date_published,'%Y') = ".$event." ";
        }
        $fields = 'nat.article_id,nat.news_article_name,nat.news_article_text,na.keywords,na.news_date_published,na.news_image,nat.news_link';
        if($type==2){
            $fields = ' count(*) as total ';    //统计满足条件的文章总数
        }
        //去掉is_top >1 的查询  发布的新闻之间按照新闻的发布日期倒序
        $sql ="select ".$fields." from ".TABLE_NEWS_ARTICLES_TEXT." as nat left join ".TABLE_NEWS_ARTICLES." as na on nat.article_id = na.article_id  where na.news_status = 1 and nat.language_id = ".$_SESSION['languages_id']." and nat.news_article_text!='' ".$show_where.$where." order by na.news_date_published desc ".$limit;
        return $sql;
    }

    /**
     * 获取满足条件的文章总数
     */
    public function get_article_list_total($keyword='', $event='', $where='', $limit=''){
        global $db;
        $total = 0;
        $sql = $this->get_article_list_sql($keyword, $event, $where, $limit, 2);
        $result = $db->Execute($sql);
        $total = $result->fields['total'];
        return $total;
    }

    /**
     * 获取指定文章的相关内容
     */
    public function get_article_info_by_id($id){
        global $db;
        $data = [];
        $where = $this->get_news_where_sql();
        $sql = "select na.keywords,na.news_date_published,na.news_image,nat.news_banner,nat.news_adv,nat.recommend_articles,nat.news_article_name,nat.news_article_text,nat.news_adv_link,nat.recommend_articles_link,nat.news_banner_link from " . TABLE_NEWS_ARTICLES . " na left join " . TABLE_NEWS_ARTICLES_TEXT . " nat on na.article_id = nat.article_id and nat.language_id = '" . (int)$_SESSION['languages_id'] . "' where na.news_status = '1' ".$where." and na.article_id = '" . (int)$id . "'";

        $result = $db->Execute($sql);
        if($result->RecordCount() > 0){
            $data['article_id'] = $id;
            $image_src = stripslashes($result->fields['news_image']);
            $image_src = zen_get_img_change_src('images/'.$image_src);
            $data['news_image'] = $image_src;
            $articleName = stripslashes($result->fields['news_article_name']);
            $articleName = str_replace('FS.COM Inc','###small###', $articleName);
            $articleName = str_replace('FS.COM INC','###big###',$articleName);
            $articleName = str_replace('FS.COM','FS',$articleName);
            $articleName = str_replace('###small###','FS.COM Inc',$articleName);
            $articleName = str_replace('###big###','FS.COM INC',$articleName);
            $data['news_article_name'] = $articleName;
            $data['news_date_published'] = $result->fields['news_date_published'];
            $articleText = stripslashes($result->fields['news_article_text']);
            $articleText = str_replace('FS.COM Inc','###small###',$articleText);
            $articleText = str_replace('FS.COM INC','###big###',$articleText);
            $articleText = str_replace('FS.COM','FS',$articleText);
            $articleText = str_replace('###small###','FS.COM Inc',$articleText);
            $articleText = str_replace('###big###','FS.COM INC',$articleText);
             $data['news_article_text'] =  $articleText;
            $data['keywords'] = trim($result->fields['keywords'],',');
            $data['news_banner'] = stripslashes($result->fields['news_banner']);
            $data['news_adv'] = stripslashes($result->fields['news_adv']);
            $data['recommend_articles'] = stripslashes($result->fields['recommend_articles']);
            $data['recommend_articles_link'] = stripslashes($result->fields['recommend_articles_link']);
            $news_adv_link = $this->arange_articles_url(stripslashes($result->fields['news_adv_link']));
            $data['news_adv_link'] = $news_adv_link;
            $news_banner_link = $this->arange_articles_url(stripslashes($result->fields['news_banner_link']));
            $data['news_banner_link'] = $news_banner_link;



            //tag标签的相关数据
            $keywords_data = [];
            if($data['keywords']){
                $keywords = explode(',',$data['keywords']);
                foreach($keywords as $tID){
                    if (!is_numeric($tID)){
                        //若是以前保存的tag标签名 则先查出对应的tagID
                        $newTag = $db->getAll("select id from news_keywords WHERE keywords ='" . $tID . "'");
                        $tID = $newTag[0]['id'];
                    }
                    if($tID){
                        $tagData = $this->get_tag_name($tID);
                        $keywords_data[] = array(
                            'id' => $tID,
                            'keywords' => $tagData[0]['keywords'],
                            'total' => $this->get_tag_article_num($tID)
                        );
                    }
                }
            }
            $data['keywords_data'] = $keywords_data;
            //获取改文章未绑定的其他tag标签的相关数据
            $tag_where = " WHERE `id` not in (".$data['keywords'].") ";
            $other_tag = $this->get_tag_name(0, $tag_where);
            foreach($other_tag as $key=>$val){
                $other_tag[$key]['total'] = $this->get_tag_article_num($val['id']);
            }
            $data['other_tag'] = $other_tag;
        }
        return $data;
    }

    /**
     * 获取文章的所有年份
     */
    public function get_news_all_year()
    {
        global $db;
        $Eyear = array();
        $where = $this->get_news_where_sql();
        $event_sql ="select date_format(news_date_published,'%Y') as Eyear from ".TABLE_NEWS_ARTICLES." as na where 1 ".$where." group by date_format(news_date_published,'%Y') ORDER BY news_date_published desc ";
        $event_result = $db->Execute($event_sql);
        while (!$event_result->EOF){
            $time = $event_result->fields['Eyear'];
            if($time!='2012' && $time!='2013' && $time!='2014') {
                $Eyear[] = $time;
            }
            $event_result->MoveNext();
        }
        return $Eyear;
    }

    /**
     * 获取文章展示的限制条件
     * TABLE_NEWS_ARTICLES表中的news_date_published字段文章发布时间到了指定发布时间才展示
     */
    public function get_news_where_sql($where='')
    {
        $where_sql = $where ? $where : " AND '".date('Y-m-d H:i:s')."' > na.news_date_published ";
        return $where_sql;
    }

    /**
     * 获取tag标签名称
     */
    public function get_tag_name($id=0, $where=''){
        global $db;
        $data = [];
        if((int)$id){
            $data = $db->getAll("SELECT `id`,`keywords` FROM `news_keywords` WHERE `id`=".$id." LIMIT 1");
        }else{
            $data = $db->getAll("SELECT `id`,`keywords` FROM `news_keywords` ".$where." ORDER BY `order_by` ");
        }
        return $data;
    }

    /**
     * 获取tag标签被调用的文章总数
     */
    public function get_tag_article_num($tag_id){
        global $db;
        $total = 0;
        $where = $this->get_news_where_sql();
        $totalRes = $db->getAll("select count(1) as total from " . TABLE_NEWS_ARTICLES . " na left join " . TABLE_NEWS_ARTICLES_TEXT . " nat on na.article_id = nat.article_id where na.news_status = '1' and na.keywords LIKE '%," . $tag_id . ",%' and nat.language_id ='" . (int)$_SESSION['languages_id'] . "'".$where);
        if($totalRes[0]['total']){
            $total = $totalRes[0]['total'];
        }
        return $total;
    }
}