<?php
/*
 * fs_article表 文章表 模型
 * 2018.2.23 fairy add
 */
class articleModel{
    public $db;

    public function __construct(){
        global $db;
        $this->db = $db;
    }

    /*
    * 查-列表 - 获取 指定版块的 文章列表的sql
    * @return sql
    */
    public function get_article_list_sql($block_id){
        $where = '';
        if($block_id){
            $sql = 'select article_id
                from fs_article_category_block_relation 
                WHERE block_id='.$block_id;
            $relation = $this->db->getAll($sql);
            $relation_count = count($relation);
            if($relation_count == 1){
                $where .= ' and P.id = '.$relation[0]['article_id'].' ';
            }elseif($relation_count>1){
                $relation_arr = array();
                foreach ($relation as $val){
                    $relation_arr[] = $val['article_id'];
                }
                $relation_str = implode(',',$relation_arr);
                $where .= ' and P.id in ('.$relation_str.') ';
            }else{
                $where .= ' and 1!=1 ';
            }
        }else{
            $where .= ' and P.id!=5 ';//不包含Products Catalogs 版块
        }

        $sql = 'select P.id,P.link,P.is_quote,P.last_update_date,P.last_updated_by,D.name,D.remark,D.status
                from fs_articles P
                LEFT join fs_article_descriptions D on D.article_id = P.id
                WHERE D.language_id='.$_SESSION['languages_id'].$where.'
                order by P.id desc';
        return $sql;
    }

    /*
    * 查-列表 - 获取 指定版块的 文章列表
    * @return 文章列表
    */
    public function get_article_list($block_id){
        $sql = $this->get_article_list_sql($block_id);
        return $this->db->getAll($sql);
    }

    /*
    * 查-one - 获取 指定id的 文章
    * @param $article_id 文章id
    * @return 文章
    */
    public function get_article_one($article_id){
        $sql = 'select P.id,P.link,P.is_quote,P.last_update_date,P.last_updated_by,P.css_link,P.css_link,P.type,P.is_quote_inquiry,
                      D.name,D.remark,D.html,D.meta_keywords,D.meta_description,D.status,D.script_link
                from fs_articles P
                LEFT join fs_article_descriptions D on D.article_id = P.id
                WHERE D.language_id='.$_SESSION['languages_id'].' and P.id='.$article_id.'
                limit 1';

        $result = $this->db->getAll($sql);
        return $result?$result[0]:[];
    }

    /*
    * 查 - 是否存在 指定id的 文章
    * @param $article_id 文章id
    * @return 是否存在
    */
    public function is_exist_article($article_id){
        $sql = 'select count(id) as count
                from fs_articles
                WHERE id='.$article_id.'
                limit 1';
        $result = $this->db->getAll($sql);
        return (!$result || $result[0]['count']==0)?false:true;
    }

    /*
    * 查 - 获取 文章 的版块列表
    * @param $article_id 文章id
    * @return 版块列表
    */
    public function get_article_of_block_list($article_id){
        $sql = 'select B.id,B.name
        from fs_article_category_block_relation R
        LEFT JOIN fs_article_blocks B ON R.block_id = B.id
        where R.article_id='.$article_id;
        $result = $this->db->getAll($sql);
        return $result;
    }

    /*
    * 删除 - 删除一个关系
    * @param $relation_id
    * @return 删除是否成功
    */
    public function del_one_relation($relation_id){
        $delete_sql = 'DELETE FROM `fs_article_category_block_relation_descriptions` WHERE `relation_id` = ' . $relation_id;
        $result = $this->db->Execute($delete_sql);
        if ($result) {
            $delete_sql = 'DELETE FROM `fs_article_category_block_relation` WHERE `id` = ' . $relation_id;
            $result = $this->db->Execute($delete_sql);
        }
        return $result;
    }

    /*
    * 删除 - 删除文章所有的关系
    * @param $article_id 文章id
    * @return 删除是否成功
    */
    public function del_article_relation_list($article_id){
        $sql = 'select id from fs_article_category_block_relation WHERE article_id='.$article_id;
        $relation_arr = $this->db->getAll($sql);
        foreach ($relation_arr as $val){
            $this->del_one_relation($val['id']);
        }
    }

    /*
    * 删除 - 删除文章
    * @param $article_id 文章id
    * @return 删除是否成功
    */
    public function del_one_article($article_id){
        $result = $this->del_article_relation_list($article_id);
        if($result) {
            $delete_sql = 'DELETE FROM `fs_article_descriptions` WHERE `article_id` = ' . $article_id;
            $result = $this->db->Execute($delete_sql);
            if ($result) {
                $delete_sql = 'DELETE FROM `fs_articles` WHERE `id` = ' . $article_id;
                $result = $this->db->Execute($delete_sql);
            }
        }
        return $result;
    }

    /*
    * 公共的方法 - 整理 文章的版块列表
    * @param $article_id 文章id
    * @return 文章的版块列表
    */
    public function get_article_of_block_list_str($article_id){
        $result = $this->get_article_of_block_list($article_id);
        if($result){
            $block_ids = $block_names = array();
            foreach ($result as $val){
                $block_names[] = $val['name'];
                $block_ids[] = $val['id'];
            }
            $new_result['block_names_str'] = implode(',',$block_names);
            $new_result['block_ids'] = $block_ids;
        }else{
            $new_result = '';
        }
        return $new_result;
    }

    /*
    * 公共的方法 - 整理一篇文章，方便展示
    * @param $arr 一篇文章
    * @return 一篇文章
    */
    public function arrange_article_one($arr){
        $arr['link_str'] = reset_url('specials/'.$arr['link'].'-'.$arr['id'].'.html');
        $arr['last_updated_by_str'] = zen_get_admin_name($arr['last_updated_by']);
        $block_id_list_str = $this->get_article_of_block_list_str($arr['id']);
        $arr['block_id_list_str'] = $block_id_list_str['block_names_str'];
        
        return $arr;
    }

    /*
    * 公共的方法 - 整理文章列表，方便展示
    * @param $arr 文章列表
    * @return 文章列表
    */
    public function arrange_article_list($arr){
        foreach ($arr as $key=>$val){
            $arr[$key] = $this->arrange_article_one($val);
        }
        return $arr;
    }
}