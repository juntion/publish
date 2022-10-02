<?php
if(isset($_GET['request_type'])){
	$debug = false;
	require 'includes/application_top.php';
	
	switch ($_GET['request_type']){
		case 'get_next_cate':
			$pid = (int)$_POST['pid'];
			$html = '';
			if($pid){
				//优先调用自定义二级分类数据
				$custom_category = $db->getAll("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$pid." and level_id=2 and language_id = ".$_SESSION['languages_id']." order by sort");
                if($custom_category){
                    $category_data = $custom_category;
                }else{
                    //$category_data = fs_get_subcategories($pid);
                }
				
				$html .= '<div class="m_categories_two">';
				foreach($category_data as $category_v){
					$html .= '<a href="javascript:;" class="m_categories_inner_m" id="twocate'.$category_v['id'].'" onClick="get_nexts_cate('.$category_v['id'].')">';
					$html .= '<span>'.$category_v['name'].'</span>';
					$html .= '<i class="icon iconfont">&#xf087;</i>';
					$html .= '</a>';
				}
				$html .= '</div>';
				echo $html;
			}
		break;
		
		case 'get_nexts_cate':
			$pid = (int)$_POST['pid'];
			$html = '';
			if($pid){
				//优先调用自定义三级分类数据
                $custom_category = $db->getAll("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$pid." and level_id=3 and language_id = ".$_SESSION['languages_id']." order by sort");
                if($custom_category){
                    $category_data = $custom_category;
                }else{
                    $custom_category = $db->getAll("select categories_id from categories_left_display where cid=".$pid." and level_id=2 and language_id = ".$_SESSION['languages_id']." limit 1");
                    if($custom_category[0]['categories_id']){
                        $category_data = fs_get_subcategories($custom_category[0]['categories_id']);
                    }
                }
				
				if(is_array($category_data)){
					$html .= '<div class="m_categories_three">';
					foreach($category_data as $category_v){
						$html .= '<a href="'.$category_v['url'].'" class="m_categories_inner_t"><span>'.$category_v['name'].'</span></a>';
					}
					$html .= '</div>';
					echo $html;
				}
			}
		break;
	}
}