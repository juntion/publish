<?php
class search_words {
	
	function __construct(){}

    function add_search_keywords_statistics($keyword){
        global $db;
        $keyword = zen_db_prepare_input($keyword);
        $time = date('Y-m-d H:i:s');
        $created_person = $_SESSION['customer_id']?$_SESSION['customer_id']:0;
        if ($this->is_search_words_exist($keyword)){
            $info = $this->get_search_words_info($keyword);
            $info['frequency'] = (int)$info['frequency'] + 1;
            $set_data = '`frequency` = "'.$info['frequency'].'" ,`updated_at`="'.$time.'",`updated_person`="'.$created_person.'"';
            $db->Execute("update  " . TABLE_SEARCH_WORDS . " set ".$set_data." where search_id = '".$info['id']."'");
        }else {
            $search_data = array(
                'search_words' => $keyword,
				'frequency' => 1,
				'created_at' => $time,
				'created_person' => $created_person,
				'updated_at' => $time,
				'updated_person' => $created_person,
			);
			zen_db_perform(TABLE_SEARCH_WORDS, $search_data);
		}
    }
	function is_search_words_exist($keyword){
		global $db;
		$info = $db->Execute("select count(search_id) as total from " . TABLE_SEARCH_WORDS . " where search_words = '".$keyword."'");
		return ($info->fields['total'] > 0 ? true : false);
	} 
	function get_search_words_info($keyword){
		global $db;
		$info = $db->Execute("select search_id,frequency from " . TABLE_SEARCH_WORDS . " where search_words = '".$keyword."'");
		return array('id'=>$info->fields['search_id'],'frequency'=>$info->fields['frequency']);
	}

	/*
	 * 添加搜索关键字统计
	 * @para string $search_words: 搜索关键字
	 * @para string $is_statistics_keyword: 是否参与统计数量。
	 * @para int $result_numbers: 搜索结果的产品个数
	 * 添加数据库成功
	 */
	public function  add_search_keywords_statistics_new($search_words,$is_statistics_keyword=true,$result_numbers=''){
        $search_words = zen_db_prepare_input($search_words);
	    if(!$search_words){
            return false;
        }
        global $db;
        $visited_page = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $use_ip = getCustomersIP() ;
        $date = date('Y-m-d');
        $time = date('Y-m-d H:i:s');
        $updated_person = isset($_SESSION['customer_id'])?$_SESSION['customer_id']:'0';
        if ($use_ip) {
            $sql="SELECT id,visited_total 
			      FROM customers_visited_search_pages 
			      WHERE search_words='". $search_words ."' AND `visited_time`='".$date."' and use_ip ='".$use_ip."' and language_id=".$_SESSION['languages_id']." LIMIT 1" ;
            $visited_result = $db->Execute($sql);
            if ($visited_result->RecordCount()) {
                $data = array(
                    'updated_person' => $updated_person,
                    'updated_at' => $time
                );
                if($is_statistics_keyword){
                    $data['visited_total']  = $visited_result->fields['visited_total']+1;
                }else{
                    if($result_numbers){
                        $data['result_numbers']  = $result_numbers;
                    }
                }
                zen_db_perform('customers_visited_search_pages', $data,'update','id='.$visited_result->fields['id']);
            }else{
                $sql="SELECT result_numbers
			    FROM customers_visited_search_pages 
			    WHERE search_words='". $search_words ."' order by id desc LIMIT 1" ;
                $old_data = $db->getAll($sql);
                $data = array(
                    'search_words' => $search_words,
                    'visited_page_url' => $visited_page,
                    'language_id' => $_SESSION['languages_id'],
                    'visited_time' => $date,
                    'use_ip' => $use_ip,
                    'result_numbers' =>$result_numbers,
                    'created_person' => $updated_person,
                    'updated_person' => $updated_person,
                    'created_at' => $time,
                    'updated_at' => $time,
                );
                if($old_data){
                    $data['result_numbers'] = $old_data[0]['result_numbers'];
                }
                zen_db_perform('customers_visited_search_pages', $data);
            }
        }
    }

}