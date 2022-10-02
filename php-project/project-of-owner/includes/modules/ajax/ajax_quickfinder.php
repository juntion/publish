<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$action = $_GET['ajax_request_action'];
if (isset($action)) {
    $html="";
    if(!empty($_POST)){
		$html.='<div class="list_content"  id="con_one_3">
		<input type="hidden" name="" id="cucid" value="'.$_POST['current_category_id'].'">
		<input type="hidden" name="" id="cupid" value="'.$_POST['category_parentID'].';">
		<input type="hidden" name="" id="cPath" value="'.$_POST['cPath_array'].'">
		<input type="hidden" name="" id="subcPath" value="'.$_POST['cPath_array_1'].'">';
        $current_category_id = $_POST['current_category_id'];
        $category_parentID = $_POST['category_parentID'];
        if(fs_categories_fiber_cables_table($current_category_id)){
            $quickFinder_cid = $current_category_id;
            $parent_id = $_POST['category_parentID'];
        }elseif(fs_categories_fiber_cables_table($category_parentID)) {
            $quickFinder_cid = $category_parentID;
            $parent_id = fs_get_data_from_db_fields('parent_id','categories','categories_id='.$quickFinder_cid,'limit 1');
        }
		$quickFinder_file = get_qf_file($quickFinder_cid,$_POST['warehouse_code']);
        if($quickFinder_file){
			include($quickFinder_file);
		}else{ //如果不存在，重新生成
            fs_products_list_quickfinder_table_update_file_new($quickFinder_cid,$parent_id);
            $quickFinder_file = get_qf_file($quickFinder_cid,$_POST['warehouse_code']);
            if($quickFinder_file){
                include($quickFinder_file);
            }
		}
        $html.='</div>';
        $html.='<script>
        var html=$(".product_table_responsive").html();
        $("#con_one_3").append(html);
        </script>';
    }
    return $html;
}
?>

