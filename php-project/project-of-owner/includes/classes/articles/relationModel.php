<?php
/*
 * fs_article_category_block_relation 模型
 * 2018.2.23 fairy add
 */
class relationModel{
    public $db;

    public function __construct(){
        global $db;
        $this->db = $db;
    }

    /*
    * 查-列表 - 获取 指定版块的 关系列表的sql
    * @return sql
    */
    public function get_relation_list_sql($block_id,$status='',$limit=''){
        $where = '';
        if($block_id){
            $where .= ' and R.block_id='.$block_id.' ';
            $order = 'R.sort asc,';
        }
        if($status){
            $where .= ' and D.status='.$status.' ';
        }

        $sql = 'select R.id,R.block_id,R.sort,R.article_id,D.title,D.title,D.description,D.img_path,D.status,B.name as block_name,A.link,A.type
                from fs_article_category_block_relation R
                LEFT join fs_article_category_block_relation_descriptions D on D.relation_id = R.id and D.language_id='.$_SESSION['languages_id'].'
                LEFT join fs_article_blocks B on R.block_id = B.id
                LEFT join fs_articles A on R.article_id = A.id
                WHERE 1 '.$where.'
                order by '.$order.'R.id desc '.$limit;
        return $sql;
    }

    /*
    * 查-列表 - 获取 指定版块的 关系列表
    * @return 关系列表
    */
    public function get_relation_list($block_id,$status='',$limit=''){
        $sql = $this->get_relation_list_sql($block_id,$status,$limit);
        $arr = $this->db->getAll($sql);
        $arr = $this->arrange_relation_list($arr);
        return $arr;
    }

    /*
    * 查-one - 获取 指定id的 关系
    * @param $relation_id 关系id
    * @return 关系
    */
    public function get_relation_one($relation_id){
        $sql = 'select R.id,R.block_id,R.sort,R.article_id,D.title,D.title,D.description,D.img_path,D.status
                from fs_article_category_block_relation R
                LEFT join fs_article_category_block_relation_descriptions D on D.relation_id = R.id and D.language_id='.$_SESSION['languages_id'].'
                WHERE R.id='.$relation_id.' 
                limit 1';

        $result = $this->db->getAll($sql);
        return $result?$result[0]:'';
    }

    /*
    * 公共方法 - 整理一个relation
    * @param $special_v 一个relation
    * @return 一个relation
    */
    public function arrange_relation_one($special_v){
        if(preg_match('/<style.*<\/style>/',$special_v['description'])){
            $special_v['description'] = preg_replace('/<style.*<\/style>/','',$special_v['description']);
        }
        if(preg_match('/<script.*<\/script>/',$special_v['description'])){
            $special_v['description'] = preg_replace('/<script.*<\/script>/','',$special_v['description']);
        }
        $special_v['description'] = strip_tags($special_v['description']);
        $special_v['description'] = str_replace('&nbsp;','',$special_v['description']);
        $special_v['description'] = str_replace('\\','',$special_v['description']);
        $special_v['description'] = str_replace('FS.COM','FS',$special_v['description']);
        if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
            $special_v['description'] = swap_american_to_britain($special_v['description']);
            $special_v['title'] = swap_american_to_britain( $special_v['title'] );
        }
        if($special_v['type']==1){ // 动态页面
            $special_v['link_str'] = reset_url('special_page/'.$special_v['link'].'-'.$special_v['article_id'].'.html');
        }else{
            $special_v['link_str'] = reset_url('specials/'.$special_v['link'].'-'.$special_v['article_id'].'.html');
        }
		$special_v['img_path'] = zen_get_img_change_src($special_v['img_path']);
        return $special_v;
    }

    /*
    * 公共方法 - 整理多个relation
    * @param $arr 多个relation
    * @return 多个relation
    */
    public function arrange_relation_list($arr){
        foreach ($arr as $key => $value){
            $arr[$key] = $this->arrange_relation_one($value);
        }
        return $arr;
    }
}