<?php
/**
 * 搜索下拉推荐
 * 2018.10.23 fairy add
 */
class search_recommend{
	/**
	 *  对于搜索的下拉推荐，处理搜索字符串。将关键字转换成后台填写的格式。小写，以“_”间距
     * @para str $search_key 关键字
     * @return string $new_search_key 处理之后的关键字
     */
    public function handle_search_key_for_recommend($search_key){
        $search_key = strtolower(zen_db_prepare_input($search_key));
        if ($search_key === "0" || $search_key === 0) {
            $search_key_arr  = explode(' ',$search_key);
        } else {
            $search_key_arr  = explode(' ',$search_key);
            $search_key_arr = array_filter($search_key_arr);
        }

        $new_search_key = implode('_',$search_key_arr);
        return $new_search_key;
    }

    /**
     *  对于搜索的下拉推荐，处理搜索字符串。将关键字转换成后台填写的格式。小写，以“_”间距
     * @para str $search_key 关键字
     * @para str $search_words_languages_id 语种id
     * @para str $limit 获取限制 limit 10
     * @para str $return_data_type 返回的数据类型 list/count
     * @return str $new_search_key 处理之后的关键字
     */
//    public function get_search_recommend_list($search_key,$search_words_languages_id,$limit='',$return_data_type='list'){
//        global $db;
//        $order = ' order by sort desc ';
//        $where = ' fs_search_words like "'.$search_key.'%" and language_id = "'.(int)$search_words_languages_id.'" ';
//
//        if($return_data_type == 'list'){
//            $field = ' fs_search_id,fs_search_words,fs_search_link ';
//        }else{
//            $field = ' count(*) as count ';
//        }
//        $sql = 'select '.$field.' from fs_search_words where '.$where.$order.$limit;
//        $result = $db->getAll($sql);
//        if($return_data_type == 'list'){
//            return $result;
//        }else{
//            return $result?$result[0]['count']:0;
//        }
//    }

    public function get_search_recommend_list($search_key,$search_words_languages_id,$limit,$return_data_type='list'){
        global $db;

        if($limit!=5){
            $limit = " limit 10 ";
        }else{
            $limit = " limit 5 ";
        }

        //$order = ' group by fs_search_words order by sort desc,click_times desc,is_model,pid';
        $order = ' order by sort desc,click_times desc,is_model,pid';
        $where = ' fs_search_words like "' . preg_replace('/_/',' ',$search_key) . '%" and language_id = "' . (int)$search_words_languages_id . '" ';
        $field = ' fs_search_id,fs_search_words,fs_search_link,level,img_src ';

        $where .= ' and fs_search_words !="'.strtolower(substr($search_key, 0, 1)).'" ';


        $sql = 'select ' . $field . ' from fs_search_words where ' . $where . $order .$limit.'';
        $result = $db->getAll($sql);
        $list_array = $result ;

        if($return_data_type == 'list'){
            return $list_array;
        }else{
            return count($list_array);
        }
    }


    //处理搜索词
    public function handle_search_key_v2()
    {
        //处理近义词
    }


    /**
     * @param $search_key
     * @return string
     */
    public function handle_search_key_for_recommend_v2($search_key)
    {
        //将输入的全部转化为小写的
        $search_key = strtolower(zen_db_prepare_input($search_key));

        if ($search_key === "0" || $search_key === 0) {
            $search_key_arr = explode(' ',$search_key);
        } else {
            $search_key_arr = explode(' ',$search_key);
            $search_key_arr = array_filter($search_key_arr);
        }

        $new_search_key = implode('_', $search_key_arr);


        return $new_search_key;
    }

    /**
     * @param $search_key_arr
     * @param $languages_id
     * @param int $limit
     * @return array
     */
    public function get_search_recommend_list_v2($search_key_arr, $languages_id, $limit = 10)
    {
        global $db;

        if (!is_array($search_key_arr)) {
            $search_key_arr = (array)$search_key_arr;
        }

        $search_key_arr = array_filter($search_key_arr);
        if (empty($search_key_arr)) {
            return [];
        }

        $fields = array('fs_search_id', 'fs_search_words', 'fs_search_link', 'level,img_src');
        $fields_str = implode(',', $fields);

        if (empty($limit) || (!is_numeric($limit))) {
            $limit = 10;
        }
        $limit = " limit " . $limit . " ";

        $order = ' order by sort desc,click_times desc,is_model,pid';

        $where = ' 1=1 ';

        if (is_array($search_key_arr) && (count($search_key_arr) > 1)) {
            $where .= ' and (';
            foreach ($search_key_arr as $key => $search_key) {
                if ($key == 0) {
                    $where .= ' fs_search_words like "' . preg_replace('/_/',' ', $search_key) . '%"';
                } else {
                    $where .= ' or fs_search_words like "' . preg_replace('/_/',' ', $search_key) . '%"';
                }
            }
            $where .= ' )';

            foreach ($search_key_arr as $key => $search_key) {
                $where .= ' and fs_search_words !="' . strtolower(substr($search_key, 0, 1)) . '" ';
            }
        } elseif (count($search_key_arr) > 0) {
            $where .= ' and fs_search_words like "' . preg_replace('/_/',' ', current($search_key_arr)) . '%"';
            $where .= ' and fs_search_words !="' .strtolower(substr(current($search_key_arr), 0, 1)).'" ';
        }

        $where .= ' and language_id = "' . (int)$languages_id . '" ';
        $sql    = 'select ' . $fields_str . ' from fs_search_words where ' . $where . $order . $limit . ' ';

        $result     = $db->getAll($sql);

        if (empty($result)) {
            $result = [];
        }


        return $result;
    }
}