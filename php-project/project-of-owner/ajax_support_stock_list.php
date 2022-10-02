<?php
if(isset($_GET['request_type'])){
	require 'includes/application_top.php';		
	switch($_GET['request_type']){
		case 'getNextCate':
			$first_id = $_POST['id'];
			$group_id = $_POST['group_id'];
			$a_id = $_POST['a_id'];
			$html = '';
	
			$fileName = $a_id.'_'.$group_id.'_'.$first_id.'.html';
		    $file_path = DIR_FS_SQL_CACHE.'/stock list/';
            $file_name = $fileName;
            $file_path_name = $file_path.$file_name;

			if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
				echo $html;
				exit;
			}
	
			$groups = fs_get_data_from_db_fields_array(array('group_id'),'doc_support_stock_list_level',"`a_id`='{$a_id}' and `language_id`='{$_SESSION['languages_id']}'",'group by `group_id`');
			for($i=$group_id+1;$i<=sizeof($groups);$i++){
				$html .= '<div class="DAC_content" id="cate'.$i.'">';
				static $pid;
				$pid = !empty($pid) ? $pid : $first_id;
				$cate_colums = array('id','pid','group_id','a_id','content','is_css');
				$cate_data = fs_get_data_from_db_fields_array($cate_colums,'doc_support_stock_list_level',"pid='{$pid}' and group_id='{$i}' and a_id='{$a_id}' and is_show=1 and language_id=".$_SESSION['languages_id'],'order by sort');
				foreach($cate_data as $cate_k=>$cate_v){
					$hover='';
					switch($cate_v[5]){
						case 'DAC_tittle01':		//下划线
							if($cate_k==0){$hover='DAC_tittle01_hover';}
							$html .= '<li class="DAC_tittle01 '.$hover.'" onclick="showNextCate('.$cate_v[0].','.$cate_v[2].','.$cate_v[3].','.$cate_k.','.$i.')" >'.$cate_v[4].'</li>';
						break;
						
						case 'stock_brand_title':	//勾选框
							if($cate_k==0){$hover='stock_brand_hover';}
							$html .= '<li class="stock_brand_title '.$hover.'"  onclick="showNextCate('.$cate_v[0].','.$cate_v[2].','.$cate_v[3].','.$cate_k.','.$i.')" >'.$cate_v[4].'</li>';
						break;
						
						case 'stock_type':			//切换框
							if($cate_k==0){$hover='type_hover';}
							$html .= '<li class="stock_type '.$hover.'"  onclick="showNextCate('.$cate_v[0].','.$cate_v[2].','.$cate_v[3].','.$cate_k.','.$i.')" ><span></span>'.$cate_v[4].'</li>';
						break;
						
						default:
							$qf = explode(',',$cate_v[4]);
							$html .= fs_products_list_quickfinder_table_new($qf[2],$qf[1],$qf[0],$qf[1]);
					}
				}
				$html .= '</div>';
				$pid = $cate_data[0][0];
			} 
			//$fileName = $a_id.'_'.$group_id.'_'.$first_id.'.html';
			cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
			echo $html;
		break;
    }
}