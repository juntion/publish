<?php
function categories_of_parent_id($cid){
    global $db;
    $cacheType = sqlCacheType();
    $categories = $db->Execute("select {$cacheType} parent_id from categories where categories_id =".$cid);
    return $categories->fields['parent_id'];
}

function fs_get_subcategories_of_parent($parent){
    global $db;
    $cacheType = sqlCacheType();
    $arr1 = array();
    $sql= "select {$cacheType} c.categories_id as id,cd.categories_name as name from " .TABLE_CATEGORIES . " as c 
  				left join " .TABLE_CATEGORIES_DESCRIPTION  ." as cd on (c.categories_id = cd.categories_id)
  				where c.categories_status = 1
  				and cd.language_id = " .(int)$_SESSION['languages_id'] . "
  				and c.parent_id = ".$parent."
  				order by c.sort_order ";
    $result = $db->Execute($sql);
    if ($result->RecordCount()){
        while (!$result->EOF){
            $arr1[] = array(
                'id' => $result->fields['id'],
                'name'=>$result->fields['name'],
            );
            $result->MoveNext();
        }
    }
    return $arr1;
}

function fs_get_subcategories_of_son($pids){
    global $db;
    $arr = array();
    $cacheType = sqlCacheType();
    $sql= "select {$cacheType} c.categories_id as id,parent_id as pid,categories_name as name from " .TABLE_CATEGORIES . " as c left join " .
        TABLE_CATEGORIES_DESCRIPTION  ." as cd
	on (c.categories_id = cd.categories_id)
	where c.categories_status = 1
	and cd.language_id = " .(int)$_SESSION['languages_id'] . " 
	and c.parent_id = ".(int)$pids ." 
	order by c.sort_order ";
    $result = $db->Execute($sql);
    while (!$result->EOF){
        $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$result->fields['id']);
        $arr[] = array(
            'id'=>$result->fields['id'],
            'pid'=>$result->fields['pid'],
            'name'=>$result->fields['name'],
            'url'=>$url,
        );
        $result->MoveNext();
    }
    return $arr;
}


/**
 *根据分类id查找分类信息
 *@params  $pid	int  	分类的父id
 *@return  $arr	array	返回分类的信息
 *@author	 fallwind		2016.12.19
 */
function fs_get_subcategories($pid){
    global $db;
    $arr = array();
    $cacheType = sqlCacheType();
    $sql= "select {$cacheType} c.categories_id as id,parent_id as pid,categories_name as name from " .TABLE_CATEGORIES . " as c 
			left join " .TABLE_CATEGORIES_DESCRIPTION  ." as cd on (c.categories_id = cd.categories_id)
			where c.categories_status = 1
			and cd.language_id = " .(int)$_SESSION['languages_id'] . " 
			and c.parent_id = ".(int)$pid ." 
			order by c.sort_order ";
    $result = $db->Execute($sql);
    while (!$result->EOF){
        $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$result->fields['id']);
        $arr[] = array(
            'id'=>$result->fields['id'],
            'pid'=>$result->fields['pid'],
            'name'=>$result->fields['name'],
            'url'=>$url,
        );
        $result->MoveNext();
    }
    return $arr;
}

/**
 *根据分类id查找二级分类信息
 *@params  $pid	int  	分类的父id
 *@return  $arr	array	返回分类的信息
 *@author	 frankie		2017.9.1
 */

function fs_get_second_subcategories($id){
    global $db;
    $arr = array();
    if($id){
        $custom_category = $db->Execute("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$id." and level_id=2 and language_id = ".$_SESSION['languages_id']." order by sort");
        if($custom_category){
            $category_data = $custom_category;
        }else{
            //$category_data = fs_get_subcategories($pid);
        }
    }
    //var_dump($category_data);

    while (!$category_data->EOF){
        $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$category_data->fields['id']);
        $arr[] = array(
            'id'=>$category_data->fields['id'],
            'pid'=>$category_data->fields['pid'],
            'name'=>$category_data->fields['name'],
            'url'=>$url,
        );
        $category_data->MoveNext();
    }

    return $arr;
}

/**
 *根据分类id查找三级分类信息
 *@params  $pid	int  	分类的父id
 *@return  $arr	array	返回分类的信息
 *@author	 frankie		2017.9.1
 */
function fs_get_three_subcategories($id){
    global $db;
    $arr = array();
    if($id){
        $custom_category = $db->Execute("select cid as id,categories_id,categories_name as name,categories_url as url from categories_left_display where parent_id=".$id." and level_id=3 and language_id = ".$_SESSION['languages_id']." order by sort");
        if($custom_category){
            $category_data = $custom_category;
        }else{
            $custom_category = $db->Execute("select categories_id from categories_left_display where cid=".$id." and level_id=2 and language_id = ".$_SESSION['languages_id']." limit 1");
            if($custom_category[0]['categories_id']){
                $category_data = fs_get_subcategories($custom_category[0]['categories_id']);
            }
        }
    }

    while (!$category_data->EOF){
        if($category_data->fields['categories_url']){
            $url=$category_data->fields['categories_url'];
        }else{
            $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$category_data->fields['categories_id']);
        }
        $arr[] = array(
            'id'=>$category_data->fields['id'],
            'pid'=>$category_data->fields['pid'],
            'name'=>$category_data->fields['name'],
            'url'=>$url,
        );
        $category_data->MoveNext();
    }

    return $arr;
}

function fs_get_subcategories_by_id($id){
    global $db;
    $arr = array();
    $cacheType = sqlCacheType();
    $sql= "select {$cacheType} c.categories_id as id,parent_id as pid,categories_name as name from " .TABLE_CATEGORIES . " as c 
			left join " .TABLE_CATEGORIES_DESCRIPTION  ." as cd on (c.categories_id = cd.categories_id)
			where c.categories_status = 1
			and cd.language_id = " .(int)$_SESSION['languages_id'] . " 
			and c.categories_id in($id) order by c.sort_order ";
    $result = $db->Execute($sql);
    while (!$result->EOF){
        $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$result->fields['id']);
        $arr[] = array(
            'id'=>$result->fields['id'],
            'pid'=>$result->fields['pid'],
            'name'=>$result->fields['name'],
            'url'=>$url,
        );
        $result->MoveNext();
    }
    return $arr;
}


function zen_get_path($current_category_id = '') {
    global $cPath_array, $db;

    if (zen_not_null($current_category_id)) {
        $cp_size = sizeof($cPath_array);
        if ($cp_size == 0) {
            $cPath_new = $current_category_id;
        } else {
            $cPath_new = '';
            $cacheType = sqlCacheType();
            $last_category_query = "select {$cacheType} parent_id
                                from " . TABLE_CATEGORIES . "
                                where categories_id = '" . (int)$cPath_array[($cp_size-1)] . "'";

            $last_category = $db->Execute($last_category_query);

            $current_category_query = "select {$cacheType} parent_id
                                   from " . TABLE_CATEGORIES . "
                                   where categories_id = '" . (int)$current_category_id . "'";

            $current_category = $db->Execute($current_category_query);

            if ($last_category->fields['parent_id'] == $current_category->fields['parent_id']) {
                for ($i=0; $i<($cp_size-1); $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            } else {
                for ($i=0; $i<$cp_size; $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            }
            $cPath_new .= '_' . $current_category_id;

            if (substr($cPath_new, 0, 1) == '_') {
                $cPath_new = substr($cPath_new, 1);
            }
        }
    } else {
        $cPath_new = implode('_', $cPath_array);
    }

    return 'cPath=' . $cPath_new;
}

function zen_get_path_by_categories_id($current_category_id = '') {
    global  $db;
    $cPath = '';
    if (zen_not_null($current_category_id)) {
        zen_get_parent_categories($categories, $current_category_id);

        if (sizeof($categories)){
            $categories = array_reverse($categories);
            $cPath = implode('_', $categories).'_'.$current_category_id;
        }else
            $cPath = $current_category_id;
    }
    return $cPath;
}


function zen_count_products_in_category($category_id, $include_inactive = false) {
    global $db;
    $products_count = 0;
    $cacheType = sqlCacheType();
    if ($include_inactive == true) {
        $products_query = "select {$cacheType} count(*) as total
                         from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                         where p.products_id = p2c.products_id
                         and p2c.categories_id = '" . (int)$category_id . "'";

    } else {
        $products_query = "select {$cacheType} count(*) as total
                         from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                         where p.products_id = p2c.products_id
                         and p.products_status = '1'
                         and p2c.categories_id = '" . (int)$category_id . "'";

    }
    $products = $db->Execute($products_query);
    $products_count += $products->fields['total'];

    $child_categories_query = "select {$cacheType} categories_id
                               from " . TABLE_CATEGORIES . "
                               where parent_id = '" . (int)$category_id . "'";

    $child_categories = $db->Execute($child_categories_query);

    if ($child_categories->RecordCount() > 0) {
        while (!$child_categories->EOF) {
            $products_count += zen_count_products_in_category($child_categories->fields['categories_id'], $include_inactive);
            $child_categories->MoveNext();
        }
    }

    return $products_count;
}

////
// Return true if the category has subcategories
// TABLES: categories
function zen_has_category_subcategories($category_id) {
    global $db;
    $cacheType = sqlCacheType();
    $child_category_query = "select {$cacheType} count(*) as count
                             from " . TABLE_CATEGORIES . "
                             where parent_id = '" . (int)$category_id . "' 
                             and categories_status = 1";

    $child_category = $db->Execute($child_category_query);

    if ($child_category->fields['count'] > 0) {
        return true;
    } else {
        return false;
    }
}

////
function zen_get_categories($categories_array = '', $parent_id = '0', $indent = '', $status_setting = '') {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();

    // show based on status
    if ($status_setting != '') {
        $zc_status = " c.categories_status='" . (int)$status_setting . "' and ";
    } else {
        $zc_status = '';
    }
    $cacheType = sqlCacheType();
    $categories_query = "select {$cacheType} c.categories_id, cd.categories_name, c.categories_status
                         from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                         where " . $zc_status . "
                         parent_id = '" . (int)$parent_id . "'
                         and c.categories_id = cd.categories_id
                         and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         order by sort_order, cd.categories_name";

    $categories = $db->Execute($categories_query);

    while (!$categories->EOF) {
        $categories_array[] = array('id' => $categories->fields['categories_id'],
            'text' => $indent . $categories->fields['categories_name']);

        if ($categories->fields['categories_id'] != $parent_id) {
            $categories_array = zen_get_categories($categories_array, $categories->fields['categories_id'], $indent . '&nbsp;&nbsp;', '1');
        }
        $categories->MoveNext();
    }

    return $categories_array;
}

////
// Return all subcategory IDs
// TABLES: categories
function zen_get_subcategories(&$subcategories_array, $parent_id = 0, $where = '') {
    global $db;
    $cacheType = sqlCacheType();
    $subcategories_query = "select {$cacheType} categories_id
                            from " . TABLE_CATEGORIES . "
                            where parent_id = '" . (int)$parent_id . "'";
    
    $subcategories_query .= " and categories_status='1' ";
    

    $subcategories_query .= $where;
    $subcategories_query .= "order by sort_order ";

    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
        $subcategories_array[sizeof($subcategories_array)] = $subcategories->fields['categories_id'];
        if ($subcategories->fields['categories_id'] != $parent_id) {
            zen_get_subcategories($subcategories_array, $subcategories->fields['categories_id']);
        }
        $subcategories->MoveNext();
    }
}

//通过redis缓存获取当前分类下的所有子分类
function zen_get_subcategories_redis(&$subcategories_array, $parent_id = 0, $where = '') {
    global $db;
    $subcategories_query_md5 = md5('subcategories_by_parent_id_'.$where.'_'.$parent_id);
    $redis_categories = get_redis_key_value($subcategories_query_md5,'sub_categories_all');
    if(!$redis_categories){
        //当前分类下的所有子分类若没有存入redis中就查询数据库
        zen_get_subcategories($subcategories_array, $parent_id, $where);
        set_redis_key_value($subcategories_query_md5,$subcategories_array,24*3600,'sub_categories_all');
    }else{
        foreach($redis_categories as $key=>$value){
            $subcategories_array[sizeof($subcategories_array)] = $value;
        }
    }
    //将数组中重复的分类id去掉
    $subcategories_array = array_flip($subcategories_array);
    $subcategories_array = array_flip($subcategories_array);
}

function zen_get_root_subcategories(&$subcategories_array, $parent_id = 0) {
    global $db;
    $cacheType = sqlCacheType();
    $subcategories_query = "select {$cacheType} categories_id
                            from " . TABLE_CATEGORIES . "
                            where parent_id = '" . (int)$parent_id . "' 
                            and categories_status='1' 
                            order by sort_order ";
    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
        $subcategories_array[sizeof($subcategories_array)] = $subcategories->fields['categories_id'];
        $subcategories->MoveNext();
    }
}

function zen_get_connectors(){
    global $db;
    return $db->getAll("select * from connectors");
}

function zen_get_singlge_connectors($con){
    global $db;
    $sql = "select connector from connectors where id ='".$con."' ";
    $list = $db->Execute($sql);
    $connector = $list->fields['connector'];
    return $connector;
}


function zen_get_products_fiber($option_id){
    global $db;
    return $db->getAll("select options_value_name from products_fiber_options_value pv left join products_fiber_options_value_to_optons po on pv.options_value_id = po.values_id  where options_id  = '".$option_id."' order by sort ASC");
}
function zen_get_connector_end_a(){
    global $db;
    return $db->getAll("select connector_end_a from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by connector_end_a");
}

function zen_get_connector_end_b(){
    global $db;
    return $db->getAll("select connector_end_b from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by connector_end_b");
}
function zen_get_fiber_mode(){
    global $db;
    return $db->getAll("select fiber_mode from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by fiber_mode");
}
function zen_get_length_meter(){
    global $db;
    return $db->getAll("select length_meter from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by length_meter order by length_meter ASC");
}


function zen_get_polish_type(){
    global $db;
    return $db->getAll("select polish_type from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by polish_type");
}


function zen_get_cable_jack(){
    global $db;
    return $db->getAll("select cable_jack from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 group by cable_jack");
}


function zen_get_all_products_fiber($page){
    global $db;
    $Rpage = $page ? $page : 1;
    $start = ($Rpage-1)*AJAX_NUM;
    return $db->getAll("select pf.* from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 order by products_id DESC limit $start,".AJAX_NUM."");
}
function zen_get_all_count_products_fiber(){
    global $db;
    $re = $db->Execute("select count(pf.products_id) as count from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1");
    return $re->fields['count'];
}
function zen_get_all_products_bulk_fiber($page){
    global $db;
    $Rpage = $page ? $page : 1;
    $start = ($Rpage-1)*AJAX_NUM;
    return $db->getAll("select * from products_bulk_fiber_cables order by products_id DESC limit $start,".AJAX_NUM."");
}
function zen_get_all_count_products_bulk_fiber(){
    global $db;
    $re = $db->Execute("select count(products_id) as count from products_bulk_fiber_cables");
    return $re->fields['count'];
}

function zen_get_all_products_fiber_optic_transceivers($page){
    global $db;
    $Rpage = $page ? $page : 1;
    $start = ($Rpage-1)*AJAX_NUM;
    return $db->getAll("select * from products_transceivers order by products_id DESC limit $start,".AJAX_NUM."");
}
function zen_get_all_count_products_fiber_optic_transceivers(){
    global $db;
    $re = $db->Execute("select count(products_id) as count from products_transceivers");
    return $re->fields['count'];
}

function zen_get_all_where_products_fiber($a,$b,$page){
    global $db;
    $Rpage = $page ? $page : 1;
    $start = ($Rpage-1)*AJAX_NUM;
    return $db->getAll("select pf.* from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 and connector_end_a = '".$a."' and connector_end_b = '".$b."' order by products_id DESC limit $start,".AJAX_NUM."");
}

function zen_get_all_count_where_products_fiber($a,$b){
    global $db;
    $re = $db->Execute("select count(pf.products_id) as count from products_fiber as pf,products as p  where pf.products_id = p.products_id and p.products_status = 1 and connector_end_a = '".$a."' and connector_end_b = '".$b."'");
    return $re->fields['count'];
}


function __zen_get_products_instock($p_id){
    global $db;
    $NowInstockQTY = zen_get_products_instock_total_qty_of_products_id($p_id);
    $deliver_time = zen_get_products_instock_shipping_date_of_products_id($p_id,$NowInstockQTY);

    $html = '<link itemprop="itemCondition" href="http://schema.org/NewCondition" /><span class="products_in_stock">'. $NowInstockQTY.','.'</span> '.$deliver_time;
    if($deliver_time == '<b>Ship same day</b>'){
        $html .= '<link itemprop="availability" href="http://schema.org/InStock"/>';
    }
    if($deliver_time != '<b>Ship same day</b>'){
        $html .= '<div class="track_orders_wenhao">
		<div class="question_bg"></div>
		 <div class="question_text_01 leftjt"><div class="arrow"></div>
			<div class="popover-content">';
        if($deliver_time == '<b>Estimated the next day</b>'){

            $html .='Orders received by 1:00pm by PST (Pacific Standard Time) Mon-Fri (excluding holidays) would be shipped on the next business day.<br/>
					                                 There may be some difference between the estimated time and the actual time.';
        }else{
            $html .='There may be some difference between the estimated time and the actual time.';
        }

        $html .= '<link itemprop="availability" href="http://schema.org/PreOrder"/>';

        $html .=  '</div></div></div>';
    }
    return $html;
}

function zen_get_subcategories_of_one_category_ids($products_id) {
    global $db;
    $cacheType = sqlCacheType();
    $subcategories_query = "select {$cacheType} a.categories_id from products as p left join products_to_categories as a on p.products_id=a.products_id left join categories_description as b on a.categories_id=b.categories_id left join categories as c on b.categories_id = c.parent_id 
        where 
        b.language_id = ".(int)$_SESSION['languages_id']."
        and p.products_status = 1 and p.products_id = ".$products_id."
        order by p.products_sort_order";
    $subcategories = $db->getAll($subcategories_query);
    if(!empty($subcategories)){
        $pids = $db->getAll("select {$cacheType} parent_id from categories where categories_id=".$subcategories[0]['categories_id']."");
    }
    $pids = array(
        0=>$subcategories[0]['categories_id'],
        1=>$pids[0]['parent_id']
    );
    return isset($pids)?$pids:"";

}

function zen_get_subcategories_of_one_category($categories_id, $where = '') {
    global $db;
    $subcategories_array = array();
    $cacheType = sqlCacheType();
    $subcategories_query = "select {$cacheType} categories_id
                            from " . TABLE_CATEGORIES . " as c 
                            left join ".TABLE_CATEGORIES_DESCRIPTION ." as cd 
                            using(categories_id) 
                            where 
                            language_id = ".(int)$_SESSION['languages_id']."		
                            and parent_id = '" . (int)$categories_id . "' 
                            and categories_status = 1 ";
    $subcategories_query .= $where;
    $subcategories_query .= "order by c.sort_order";

    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {
        $subcategories_array[] = $subcategories->fields['categories_id'];
        $subcategories->MoveNext();
    }

    return $subcategories_array;
}
function zen_get_dwdm_subcategories_of_one_category($categories_id) {
    global $db;
    $subcategories_array = array();
    $subcategories_query = "select categories_id,categories_image,categories_name
                            from " . TABLE_CATEGORIES . " as c
                            left join ".TABLE_CATEGORIES_DESCRIPTION ." as cd
                            using(categories_id)
                            where
                            language_id = ".(int)$_SESSION['languages_id']."
                            and parent_id = '" . (int)$categories_id . "'
                            and categories_status = 1
                            order by c.sort_order";
    $subcategories = $db->Execute($subcategories_query);

    while (!$subcategories->EOF) {

        $subcategories_array[] = array(
            'categories_id'=>$subcategories->fields['categories_id'],
            'categories_image'=>$subcategories->fields['categories_image'],
            'categories_name'=>$subcategories->fields['categories_name'],
        );
        $subcategories->MoveNext();
    }

    return $subcategories_array;
}


function zen_get_products_count_of_category($categories_id){
    global $db;
    $sql  = '';
    $sub_categories_ids = array($categories_id);
    $cacheType = sqlCacheType();
    if (zen_category_has_sub_category($categories_id)){
        zen_get_subcategories_redis($sub_categories_ids,$categories_id);
        $where_categories_id_string = join(',',$sub_categories_ids);
        if (',' == $where_categories_id_string{0}) {
            $where_categories_id_string = substr($where_categories_id_string,1);
        }
        $length = strlen($where_categories_id_string);
        if (',' == $where_categories_id_string{($length-1)}) {
            $where_categories_id_string = substr($where_categories_id_string,$length,-1);
        }
        $categories_id_str = " and categories_id in(".$where_categories_id_string.")";
    }else{
        $categories_id_str  = " and categories_id=".(int)$sub_categories_ids[0];
    }
    $sql  = "select {$cacheType} count(products_id) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " as ptc
  				join ".TABLE_PRODUCTS ." as p
  				using(products_id)
  				join ".TABLE_PRODUCTS_DESCRIPTION." as pd
  				using(products_id)
  				where p.products_status = 1
  				and pd.language_id = :language_id  "
    ;
    $sql = $sql  .$categories_id_str;
    $sql = $db->bindVars($sql, ':language_id', (int)$_SESSION['languages_id'], 'integer');
    $result = $db->Execute($sql);
    //enf categories num
    return ($result->fields['total']) ? ' <em>('.$result->fields['total'].')</em>' : '';
}

/**
 * get search count by categories_name *****************tom   05_28****************************************
 */
function get_products_count_of_search_category($categories_id,$keywords){
    global $db;
    $sql  = '';
    $and = " and (pd.products_name REGEXP '".$keywords."' or p.products_model REGEXP '".$keywords."' or p.products_MFG_PART REGEXP '".$keywords."')";
    //$and = " and (pd.products_name REGEXP '".$keywords."')";
    $sub_categories_ids = array($categories_id);
    if (zen_category_has_sub_category($categories_id)){
        zen_get_subcategories_redis($sub_categories_ids,$categories_id);
        $where_categories_id_string = join(',',$sub_categories_ids);
        if (',' == $where_categories_id_string{0}) {
            $where_categories_id_string = substr($where_categories_id_string,1);
        }
        $length = strlen($where_categories_id_string);
        if (',' == $where_categories_id_string{($length-1)}) {
            $where_categories_id_string = substr($where_categories_id_string,$length,-1);
        }
        $categories_id_str = " and categories_id in(".$where_categories_id_string.")";
    }else{
        $categories_id_str  = " and categories_id=".(int)$sub_categories_ids[0];
    }
    $sql  = "select count(products_id) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " as ptc
  				join ".TABLE_PRODUCTS ." as p
  				using(products_id)
  				join ".TABLE_PRODUCTS_DESCRIPTION." as pd
  				using(products_id)
  				where p.products_status = 1
  				and pd.language_id = :language_id
  						"  ;
    $sql = $sql  .$categories_id_str . $and;
    $sql = $db->bindVars($sql, ':language_id', (int)$_SESSION['languages_id'], 'integer');

    //echo $sql;
    $result = $db->Execute($sql);
    return ($result->fields['total']) ? ' <em>('.$result->fields['total'].')</em>' : '';
}

////
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
function zen_get_parent_categories(&$categories, $categories_id) {
    global $db;
    $cacheType = sqlCacheType();
    $parent_categories_query = "select {$cacheType} parent_id
                                from " . TABLE_CATEGORIES . "
                                where categories_id = '" . (int)$categories_id . "'";

    $parent_categories = $db->Execute($parent_categories_query);

    while (!$parent_categories->EOF) {
        if ($parent_categories->fields['parent_id'] == 0) return true;
        $categories[sizeof($categories)] = $parent_categories->fields['parent_id'];
        if ($parent_categories->fields['parent_id'] != $categories_id) {
            zen_get_parent_categories($categories, $parent_categories->fields['parent_id']);
        }
        $parent_categories->MoveNext();
    }
}

////
// Construct a category path to the product
// TABLES: products_to_categories
function zen_get_product_path($products_id) {
    global $db;
    $cPath = '';

    /*  $category_query = "select p.products_id, p.master_categories_id
                        from " . TABLE_PRODUCTS . " p
                        where p.products_id = '" . (int)$products_id . "' limit 1"; */
    $cacheType = sqlCacheType();
    $category_query = "select {$cacheType}  categories_id as master_categories_id
                       from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                       where products_id = '" . (int)$products_id . "' order by sort_order asc limit 1";

    $category = $db->Execute($category_query);

    if ($category->RecordCount() > 0) {

        $categories = array();
        zen_get_parent_categories($categories, $category->fields['master_categories_id']);

        $categories = array_reverse($categories);

        $cPath = implode('_', $categories);

        if (zen_not_null($cPath)) $cPath .= '_';
        $cPath .= $category->fields['master_categories_id'];
    }

    return $cPath;
}

////
// Parse and secure the cPath parameter values
function zen_parse_category_path($cPath) {
// make sure the category IDs are integers
    $cPath_array = array_map('zen_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i=0; $i<$n; $i++) {
        if (!in_array($cPath_array[$i], $tmp_array)){
            $tmp_array[] = $cPath_array[$i];
        }
    }

    return $tmp_array;
}

function zen_product_in_category($product_id,$cat_id){
    global $db;
    $in_cat=false;
    $category_query_raw = "select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                           where products_id = '" . (int)$product_id . "'";
    $category = $db->Execute($category_query_raw);
    while (!$category->EOF) {
        if ($category->fields['categories_id'] == $cat_id) $in_cat = true;
        if (!$in_cat) {
            $parent_categories_query = "select parent_id from " . TABLE_CATEGORIES . "
                                    where categories_id = '" . $category->fields['categories_id'] . "'";

            $parent_categories = $db->Execute($parent_categories_query);
//echo 'cat='.$category->fields['categories_id'].'#'. $cat_id;

            while (!$parent_categories->EOF) {
                if (($parent_categories->fields['parent_id'] !=0) ) {
                    if (!$in_cat) $in_cat = zen_product_in_parent_category($product_id, $cat_id, $parent_categories->fields['parent_id']);
                }
                $parent_categories->MoveNext();
            }
        }
        $category->MoveNext();
    }
    return $in_cat;
}

function zen_product_in_parent_category($product_id, $cat_id, $parent_cat_id="") {
    global $db;
//echo $cat_id . '#' . $parent_cat_id;
    $in_cat = false;
    if ($cat_id == $parent_cat_id) {
        $in_cat = true;
    } else {
        $cacheType = sqlCacheType();
        $parent_categories_query = "select {$cacheType} parent_id from " . TABLE_CATEGORIES . "
                                  where categories_id = '" . (int)$parent_cat_id . "'";

        $parent_categories = $db->Execute($parent_categories_query);

        while (!$parent_categories->EOF) {
            if ($parent_categories->fields['parent_id'] !=0 && !$in_cat) {
                $in_cat = zen_product_in_parent_category($product_id, $cat_id, $parent_categories->fields['parent_id']);
            }
            $parent_categories->MoveNext();
        }
    }
    return $in_cat;
}


////
// products with name, model and price pulldown
function zen_draw_products_pull_down($name, $parameters = '', $exclude = '') {
    global $currencies, $db;

    if ($exclude == '') {
        $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
        $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $products = $db->Execute("select p.products_id, pd.products_name, p.products_price
                              from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                              where p.products_id = pd.products_id
                              and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                              order by products_name");

    while (!$products->EOF) {
        if (!in_array($products->fields['products_id'], $exclude)) {
            $display_price = zen_get_products_base_price($products->fields['products_id']);
            $select_string .= '<option value="' . $products->fields['products_id'] . '">' . $products->fields['products_name'] . ' (' . $currencies->format($display_price) . ')</option>';
        }
        $products->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
}

////
// product pulldown with attributes
function zen_draw_products_pull_down_attributes($name, $parameters = '', $exclude = ''){
    global $db, $currencies;

    if($exclude == ''){
        $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if($parameters){
        $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $new_fields=', p.products_model';

    $products = $db->Execute("select distinct p.products_id, pd.products_name, p.products_price" . $new_fields ."
                              from " . TABLE_PRODUCTS . " p, " .
        TABLE_PRODUCTS_DESCRIPTION . " pd, " .
        TABLE_PRODUCTS_ATTRIBUTES . " pa " ."
                              where p.products_id= pa.products_id and p.products_id = pd.products_id
                              and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                              order by products_name");

    while (!$products->EOF){
        if(!in_array($products->fields['products_id'], $exclude)){
            $display_price = zen_get_products_base_price($products->fields['products_id']);
            $select_string .= '<option value="' . $products->fields['products_id'] . '">' . $products->fields['products_name'] . ' (' . TEXT_MODEL . ' ' . $products->fields['products_model'] . ') (' . $currencies->format($display_price) . ')</option>';
        }
        $products->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
}


////
// categories pulldown with products
function zen_draw_products_pull_down_categories($name, $parameters = '', $exclude = '') {
    global $db, $currencies;

    if ($exclude == '') {
        $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
        $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $categories = $db->Execute("select distinct c.categories_id, cd.categories_name " ."
                                from " . TABLE_CATEGORIES . " c, " .
        TABLE_CATEGORIES_DESCRIPTION . " cd, " .
        TABLE_PRODUCTS_TO_CATEGORIES . " ptoc " ."
                                where ptoc.categories_id = c.categories_id
                                and c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                order by categories_name");

    while (!$categories->EOF) {
        if (!in_array($categories->fields['categories_id'], $exclude)) {
            $select_string .= '<option value="' . $categories->fields['categories_id'] . '">' . $categories->fields['categories_name'] . '</option>';
        }
        $categories->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
}

////
// categories pulldown with products with attributes
function zen_draw_products_pull_down_categories_attributes($name, $parameters = '', $exclude = '') {
    global $db, $currencies;

    if ($exclude == '') {
        $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
        $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';

    $categories = $db->Execute("select distinct c.categories_id, cd.categories_name " ."
                                from " . TABLE_CATEGORIES . " c, " .
        TABLE_CATEGORIES_DESCRIPTION . " cd, " .
        TABLE_PRODUCTS_TO_CATEGORIES . " ptoc, " .
        TABLE_PRODUCTS_ATTRIBUTES . " pa " ."
                                where pa.products_id= ptoc.products_id
                                and ptoc.categories_id= c.categories_id
                                and c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                order by categories_name");

    while (!$categories->EOF) {
        if (!in_array($categories->fields['categories_id'], $exclude)) {
            $select_string .= '<option value="' . $categories->fields['categories_id'] . '">' . $categories->fields['categories_name'] . '</option>';
        }
        $categories->MoveNext();
    }

    $select_string .= '</select>';

    return $select_string;
}

////
// look up categories product_type
function zen_get_product_types_to_category($lookup) {
    global $db;

    $lookup = str_replace('cPath=','',$lookup);

    $sql = "select product_type_id from " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " where category_id='" . (int)$lookup . "'";
    $look_up = $db->Execute($sql);

    if ($look_up->RecordCount() > 0) {
        return $look_up->fields['product_type_id'];
    } else {
        return false;
    }
}

//// look up parent categories name
function zen_get_categories_parent_name($categories_id) {
    global $db;
    $cacheType = sqlCacheType();
    $lookup_query = "select {$cacheType} parent_id from " . TABLE_CATEGORIES . " where categories_id='" . (int)$categories_id . "'";
    $lookup = $db->Execute($lookup_query);

    $lookup_query = "select {$cacheType} categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id='" . (int)$lookup->fields['parent_id'] . "' and language_id= " . $_SESSION['languages_id'];
    $lookup = $db->Execute($lookup_query);

    return $lookup->fields['categories_name'];
}


function zen_get_categorie_name($categories_id) {
    global $db;
    $cacheType = sqlCacheType();
    $categories_query = "select {$cacheType} categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id='" . (int)$categories_id . "' and language_id= " . $_SESSION['languages_id'];
    $categories = $db->Execute($categories_query);

    return $categories->fields['categories_name'];
}

////
// Get all products_id in a Category and its SubCategories
// use as:
// $my_products_id_list = array();
// $my_products_id_list = zen_get_categories_products_list($categories_id)
function zen_get_categories_products_list($categories_id, $include_deactivated = false, $include_child = true, $parent_category = '0', $display_limit = '') {
    global $db;
    global $categories_products_id_list;
    $childCatID = str_replace('_', '', substr($categories_id, strrpos($categories_id, '_')));

    $current_cPath = ($parent_category != '0' ? $parent_category . '_' : '') . $categories_id;

    $sql = "select p.products_id
            from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
            where p.products_id = p2c.products_id
            and p2c.categories_id = '" . (int)$childCatID . "'" .
        ($include_deactivated ? " and p.products_status = 1" : "") .
        $display_limit;

    $products = $db->Execute($sql);
    while (!$products->EOF) {
        $categories_products_id_list[$products->fields['products_id']] = $current_cPath;
        $products->MoveNext();
    }

    if ($include_child) {
        $sql = "select categories_id from " . TABLE_CATEGORIES . "
              where parent_id = '" . (int)$childCatID . "'";

        $childs = $db->Execute($sql);
        if ($childs->RecordCount() > 0 ) {
            while (!$childs->EOF) {
                zen_get_categories_products_list($childs->fields['categories_id'], $include_deactivated, $include_child, $current_cPath, $display_limit);
                $childs->MoveNext();
            }
        }
    }
    return $categories_products_id_list;
}

//// bof: manage master_categories_id vs cPath
function zen_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
    global $db;

    if (!is_array($categories_array)) $categories_array = array();
    $cacheType = sqlCacheType();
    if ($from == 'product') {
        $categories = $db->Execute("select {$cacheType} categories_id
                                  from " . TABLE_PRODUCTS_TO_CATEGORIES . "
                                  where products_id = '" . (int)$id . "'");

        while (!$categories->EOF) {
            if ($categories->fields['categories_id'] == '0') {
                $categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
            } else {
                $category = $db->Execute("select {$cacheType} cd.categories_name, c.parent_id
                                    from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                    where c.categories_id = '" . (int)$categories->fields['categories_id'] . "'
                                    and c.categories_id = cd.categories_id
                                    and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");

                $categories_array[$index][] = array('id' => $categories->fields['categories_id'], 'text' => $category->fields['categories_name']);
                if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
                $categories_array[$index] = array_reverse($categories_array[$index]);
            }
            $index++;
            $categories->MoveNext();
        }
    } elseif ($from == 'category') {
        $category = $db->Execute("select {$cacheType} cd.categories_name, c.parent_id
                                from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                                where c.categories_id = '" . (int)$id . "'
                                and c.categories_id = cd.categories_id
                                and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");

        $categories_array[$index][] = array('id' => $id, 'text' => $category->fields['categories_name']);
        if ( (zen_not_null($category->fields['parent_id'])) && ($category->fields['parent_id'] != '0') ) $categories_array = zen_generate_category_path($category->fields['parent_id'], 'category', $categories_array, $index);
    }

    return $categories_array;
}

function zen_output_generated_category_path($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = zen_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
        for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
//        $calculated_category_path_string .= $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
            $calculated_category_path_string = $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;' . $calculated_category_path_string;
        }
        $calculated_category_path_string = substr($calculated_category_path_string, 0, -16) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
}

function zen_get_generated_category_path_ids($id, $from = 'category') {
    global $db;
    $calculated_category_path_string = '';
    $calculated_category_path = zen_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
        for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
            $calculated_category_path_string .= $calculated_category_path[$i][$j]['id'] . '_';
        }
        $calculated_category_path_string = substr($calculated_category_path_string, 0, -1) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
}

function zen_get_generated_category_path_rev($this_categories_id) {
    $categories = array();
    zen_get_parent_categories($categories, $this_categories_id);

    $categories = array_reverse($categories);

    $categories_imploded = implode('_', $categories);

    if (zen_not_null($categories_imploded)) $categories_imploded .= '_';
    $categories_imploded .= $this_categories_id;

    return $categories_imploded;
}
//// bof: manage master_categories_id vs cPath



function zen_get_sub_category_id($parent_id,$sub_category_name)
{
    global $db;
    $cacheType = sqlCacheType();
    $get_sub_categories_id = $db->Execute("select {$cacheType} c.categories_id from " . TABLE_CATEGORIES . " as c,".
        TABLE_CATEGORIES_DESCRIPTION . " as cd ".
        " where c.categories_id = cd.categories_id 
     			      and  c.parent_id = " . $parent_id. "  
     			      and  c.categories_status = 1 
     			      and cd.categories_name = '".$sub_category_name."'");
    if ($get_sub_categories_id->RecordCount() > 0)
    {
        return $get_sub_categories_id->fields['categories_id'];
    }

    return null;
}


function fs_get_categories_path($categories_id){
    $cPach = array();
    /*$cPach_string = 'cPath=';*/
    $cPach_string = '-c';
    /*here get cpath array*/
    if (fs_get_categories_cpath_array($cPach,$categories_id) && sizeof($cPach)){
        foreach (array_reverse($cPach) as $key => $value){
            $cPach_string .= $value .'_';
        }
    }
    return !empty($cPach_string) ? $cPach_string.$categories_id : $cPach_string.$categories_id;

}

function fs_get_categories_cpath_array(& $cPach,$categories_id){
    global  $db;$index = 0;
    $cacheType = sqlCacheType();
    $get_parent_id = $db->Execute("select {$cacheType} parent_id from " .TABLE_CATEGORIES . " where categories_id = " . intval($categories_id));
    if ($get_parent_id->RecordCount() && 0 != $get_parent_id->fields['parent_id']){
        /*if this has parent*/
        $cPach[] = $get_parent_id->fields['parent_id'];
        fs_get_categories_cpath_array( $cPach,$get_parent_id->fields['parent_id']);
    }
    return true;
}
// by henly
function fs_get_categories_status($categories_id){
    global  $db;
    $cacheType = sqlCacheType();
    $status = $db->Execute("select {$cacheType} parent_id from categories where categories_id = '$categories_id'");
    if($status->fields['parent_id'] == 0){
        return false;
    }else{
        return true;
    }
}

function zen_get_root_categories_images($cid){
    global  $db;
    $re = $db->Execute("select * from categories where categories_id = '".$cid."' limit 1");
    if($re){
        return $re->fields['categories_of_image'];
    }else{
        return "";
    }
}

function categories_products_sort_list($cid){
    global $db;
    $ca = $db->Execute("select sort_sale from categories where categories_id = ".$cid);
    return $ca->fields['sort_sale'];
}

//获取产品分类的QF属性
function fs_products_list_quickfinder_table_update_file_new($current_category_id,$pid){
    require_once DIR_WS_CLASSES . 'shipping_info.php';
    global $db;
    $fiber_optic_list = fs_categories_fiber_cables_table($current_category_id) ? fs_categories_fiber_cables_table($current_category_id) : fs_categories_fiber_cables_table($pid) ;
    //分仓区域展示产品，每个仓都需要一个静态文件
    $quickfinder_html = $us_html = $de_html = $au_html = $sg_html = '';
    $wareArr = array('cn_status'=>'quickfinder_html','us_status'=>'us_html','de_status'=>'de_html','au_status'=>'au_html','sg_status'=>'sg_html','ru_status'=>'ru_html');
    if(count($fiber_optic_list)>1){
        foreach($wareArr as $wkey=>$wcode){
            $$wcode .='<div class="product_table_responsive">';
        }
    }

    $transceivers = array(9,2997);
    $categories []=$current_category_id;
    zen_get_parent_categories($categories,$current_category_id);
    $is_transceivers = array_intersect($categories,$transceivers); //模块交集
    if($is_transceivers){
        $quickfinderHide = true;
        $quickfinderCSS ='style="display:none;"';
    }else{
        $quickfinderShow = false;
        $quickfinderCSS ='';
    }

    $productsID_arr=[];

    for($t=0;$t<sizeof($fiber_optic_list);$t++){
        foreach($wareArr as $wkey=>$wcode){
            if($filter==str_replace('(*)','',$fiber_optic_list[$t]['filter'])){
                $$wcode .= '<div><h3 class="title categories_name_s '.$filter_id.'" id="table_name_'.$filter_id.'" style="display: block;">'.$filter_name.'</h3>';
                $$wcode .= '<div class="categories_table_list">
                            <div class="categories_table_list_ovAuto">
                			<table class="table_array_tal filter_connector '.$filter_id.'" width="100%" cellspacing="0" cellpadding="0" id="table_'.$filter_id.'" style="display: table;">';
                $filter_name="";
            }else{
                $filter_name = content_preg_mtp($fiber_optic_list[$t]['filter'],$categories[sizeof($categories)-1]);
                $$wcode .= '<div><h3 class="title categories_name_s '.$fiber_optic_list[$t]['id'].'" id="table_name_'.$fiber_optic_list[$t]['id'].'" style="display: block;">'.$filter_name.'</h3>';
                $$wcode .= '<div class="categories_table_list">
                            <div class="categories_table_list_ovAuto">
                			<table class="table_array_tal filter_connector '.$fiber_optic_list[$t]['id'].'" width="100%" cellspacing="0" cellpadding="0" id="table_'.$fiber_optic_list[$t]['id'].'" style="display: table;">';
            }
        }

        $table_brand = fs_quickfinder_table_brand_remove_custom($fiber_optic_list[$t]['id']);

        if(sizeof($table_brand)){
            //过滤了相同类型的产品
            $table_type = fs_quickfinder_table_type($fiber_optic_list[$t]['id']);

            $typeName = '';$Custom=false;
            foreach($wareArr as $wkey=>$wcode){
                $$wcode .= '<tr>';
            }
            $first_products=$image_src=$image='';
            for($tb=0;$tb<sizeof($table_brand);$tb++){             //展示品牌
                /* 第一个产品图片 */
                foreach($wareArr as $wkey=>$wcode){
                    if($tb == 0){
                        $$wcode .= '<th class="pro_type"><span>'.$table_brand[$tb]['brand_name'];
                    }else{
                        $$wcode .= '<th class="pro_type"><div>'.$table_brand[$tb]['brand_name'];
                    }
                }
                if($tb >0){
                    $first_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$tb]['brand_id'],$table_type[0]['type_id']);
                    if(is_numeric($first_products)){
                        $image = get_resources_img($first_products,'40','40',zen_get_products_image_of_products_id($first_products),zen_get_products_name($first_products),zen_get_products_name($first_products));
                        foreach($wareArr as $wkey=>$wcode){
                            $$wcode .= '<br/>'.$image;
                        }
                    }else{
                        //如果该品牌不存在第一个产品 调用下面的产品的图
                        $last_products = 0;
                        for($i=1;$i<sizeof($table_type);$i++){
                            $next_products =fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$tb]['brand_id'],$table_type[$i]['type_id']);
                            //直到有产品为止
                            if(is_numeric($next_products)){
                                $last_products =$next_products;
                                break;
                            }
                        }
                        $image = '';
                        if($last_products){
                            $image = get_resources_img($last_products,'40','40',zen_get_products_image_of_products_id($last_products),zen_get_products_name($last_products),zen_get_products_name($last_products));
                        }
                        foreach($wareArr as $wkey=>$wcode){
                            $$wcode .= '<br/>'.$image;
                        }
                    }
                }
                foreach($wareArr as $wkey=>$wcode){
                    if($tb == 0){
                        $$wcode .= '</span></th>';
                    }else{
                        $$wcode .= '</div></th>';
                    }
                }
            }
            foreach($wareArr as $wkey=>$wcode){
                $$wcode .= '</tr>';
            }

            for($num=0;$num<sizeof($table_type);$num++){
                //$quickfinder_html .= '<tr>';
                foreach($wareArr as $wkey=>$wcode){
                    $$wcode .= '<tr>';
                }
                $typeName = $table_type[$num]['type_name'];
                if($table_type[$num]['type_name'] == 'Custom'){
                    $Custom = true;
                }else{
                    $Custom = false;
                }
                //search到相同类型的产品
                $sameType='';
                $sameType = fs_quickfinder_table_type_same($fiber_optic_list[$t]['id'],$typeName);
                $brand_products='';$PinstockID='';$PinstockQTY=0;$InstockPCS='';

                for($bs=0;$bs<sizeof($table_brand);$bs++){            //展示品牌下产品
                    if($bs ==0){
                        //$quickfinder_html .= '<td class="auto_width">'.$typeName.'</td>';
                        foreach($wareArr as $wkey=>$wcode){
                            $$wcode .= '<td class="pro_type pro_type1"><span>'.$typeName.'</span></td>';
                        }
                    }else{

                        //下面这个循环速度很慢  要找出对应产品以及产品的库存数量
                        $brand_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$bs]['brand_id'],$table_type[$num]['type_id']);
                        if($brand_products!='--'){
                            $productsID_arr[]=(int)$brand_products;
                        }
                        //对应品牌,同类型下有多个产品,显示或隐藏
                        $brand_type_P = fs_quickfinder_table_brand_type_products($fiber_optic_list[$t]['id'],$table_brand[$bs]['brand_id'],$typeName);

                        $moreProducts ='';
                        if(sizeof($brand_type_P) > 1 && $quickfinderHide){
                            $moreProducts =   '<a id="pulldownC_'.$table_type[$num]['type_id'].'_'.$bs.'"  class="sidebar_more" onclick="GetMoreType('.$table_type[$num]['type_id'].','.sizeof($sameType).','.$bs.')"><i class="icon iconfont">&#xf087;</i></a>';
                        }
                        //有产品id的则显示
                        if(is_numeric($brand_products) && $brand_products > 0){
                            if($Custom){
                                $custom_href = '<?php echo reset_url("products/'.$brand_products.'.html");?>';
                                $productsID = '<a class="alink" href="'.$custom_href.'" target="_blank">'.$brand_products.'</a>';
                            }else{
                                if($fiber_optic_list[$t]['table_info'] == 1){
                                    $productsID = '<a class="alink" data-all-ids="'.$table_brand[$bs]['brand_id'].'-'.$table_type[$num]['type_id'].'" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'.(int)$brand_products.'">'.zen_get_products_model_PART((int)$brand_products).'</a>';
                                }else{
                                    $productsID = '<a class="alink" data-all-ids="'.$table_brand[$bs]['brand_id'].'-'.$table_type[$num]['type_id'].'" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'.(int)$brand_products.'">'.$brand_products.'</a>';
                                }
                            }
                            $InstockPCS = '';
                            if(!$Custom){
                                //定制产品没有展示属性不显示库存
                                $isCustom = true;
                                $options_name = fs_products_option_info($brand_products);
                                $productLengthInfo = fs_product_length_info($brand_products);
                                if(sizeof($options_name) || $productLengthInfo){
                                    $isCustom = false;
                                }
                                if($isCustom){
                                    $InstockPCS = '<?php 
                                               
                                                $html_SInstockPCS = fs_get_Index_Instock_Qty_Html($html_SInstockPCS_Arr['.$brand_products.']);
                                                if($html_SInstockPCS > 0){
                                                    if ($html_SInstockPCS <= 1) {
                                                        $unit = QTY_SHOW_ZERO_STOCK;
                                                    } else {
                                                        $unit = QTY_SHOW_MORE_STOCK;
                                                    }
                                                    echo "<div class=\"pcs\"><span class=\"circle\"></span>{$html_SInstockPCS} {$unit}</div>";
                                                }else{
                                                    echo "";
                                                }
                                            ?>';
                                }
                            }
                            $pdata = $db->getAll("select products_status,cn_status,de_status,us_status,au_status,sg_status,ru_status from products where products_id=".$brand_products);

                            foreach($wareArr as $wkey=>$wcode){
                                if($pdata[0][$wkey]){
                                    $$wcode .= '<td>'.$productsID.$moreProducts.$InstockPCS.'</td>';
                                }else{
                                    $$wcode .= '<td></td>';
                                }
                            }
                        }else{
                            if($brand_products ==0 && $cPath_array[0] == 9){
                                $productsID ='';
                            }else{
                                $productsID = str_replace('--','',$brand_products);
                            }

                            $InstockPCS ='';
                            foreach($wareArr as $wkey=>$wcode){
                                $$wcode .= '<td>'.$productsID.$moreProducts.$InstockPCS.'</td>';
                            }
                        }
                    }
                }

                foreach($wareArr as $wkey=>$wcode){
                    $$wcode .= '</tr>';
                }
                if(sizeof($sameType) > 1){
                    $autoID=0;$sameCustom = false;
                    for($st=1;$st<sizeof($sameType);$st++){          // 相同类型的第一个在前面已经显示
                        $SPinstockID='';$SPinstockQTY=0;$SInstockPCS='';
                        $autoID++;

                        if($sameType[$st]['type_name'] == 'Custom'){
                            $sameCustom = true;
                        }else{
                            $sameCustom = false;
                        }
                        //$quickfinder_html .= '<tr id="type_'.$table_type[$num]['type_id'].'_'.$autoID.'" '.$quickfinderCSS.'>';
                        foreach($wareArr as $wkey=>$wcode){
                            $$wcode .= '<tr id="type_'.$table_type[$num]['type_id'].'_'.$autoID.'" '.$quickfinderCSS.'>';
                        }
                        $S_products='';
                        for($bbs=0;$bbs<sizeof($table_brand);$bbs++){            //展示品牌下产品
                            if($bbs ==0){
                                foreach($wareArr as $wkey=>$wcode){
                                    $$wcode .= '<td class="pro_type pro_type2">'.$sameType[$st]['type_name'].'</td>';
                                }
                            }else{
                                $S_products = fs_quickfinder_table_brand_products($fiber_optic_list[$t]['id'],$table_brand[$bbs]['brand_id'],$sameType[$st]['type_id']);

                                if($S_products!='--') {
                                    $productsID_arr[] = (int)$S_products;
                                }

                                if(is_numeric($S_products) && $S_products > 0){
                                    if($sameCustom){
                                        $custom_href = '<?php echo reset_url("products/'.$S_products.'.html");?>';
                                        $SproductsID = '<a class="alink" href="'.$custom_href.'" target="_blank">'.$S_products.'</a>';
                                    }else{
                                        if($fiber_optic_list[$t]['table_info'] == 1){
                                            $SproductsID = '<a class="alink" data-all-ids="'.$table_brand[$bbs]['brand_id'].'-'.$sameType[$st]['type_id'].'" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'.(int)$S_products.'">'.zen_get_products_model_PART((int)$S_products).'</a>';
                                        }else{
                                            $SproductsID = '<a class="alink" data-all-ids="'.$table_brand[$bbs]['brand_id'].'-'.$sameType[$st]['type_id'].'" onclick="ajax_get_one_product_qv_show(this)" data-product-id="'.(int)$S_products.'">'.$S_products.'</a>';
                                        }
                                    }
                                    $SInstockPCS = '';
                                    if(!$sameCustom){
                                        //定制产品没有展示属性不显示库存
                                        $isCustom = true;
                                        $options_name = fs_products_option_info($S_products);
                                        $productLengthInfo = fs_product_length_info($S_products);
                                        if(sizeof($options_name) || $productLengthInfo){
                                            $isCustom = false;
                                        }
                                        if($isCustom){
                                            $SInstockPCS = '<?php 
                                                $html_SInstockPCS = fs_get_Index_Instock_Qty_Html($html_SInstockPCS_Arr['.$S_products.']);
                                                if($html_SInstockPCS > 0){
                                                    if ($html_SInstockPCS <= 1) {
                                                        $unit = QTY_SHOW_ZERO_STOCK;
                                                    } else {
                                                        $unit = QTY_SHOW_MORE_STOCK;
                                                    }
                                                    echo "<div class=\"pcs\"><span class=\"circle\"></span>{$html_SInstockPCS} {$unit}</div>";
                                                }else{
                                                    echo "";
                                                }
                                            ?>';
                                        }
                                    }
                                    $pdata = $db->getAll("select products_status,cn_status,de_status,us_status,au_status from products where products_id=".$S_products);
                                    foreach($wareArr as $wkey=>$wcode){
                                        if($pdata[0][$wkey]){
                                            $$wcode .= '<td>'.$SproductsID.$SInstockPCS.'</td>';
                                        }else{
                                            $$wcode .= '<td></td>';
                                        }
                                    }

                                }else{
                                    if(is_numeric($S_products) && $S_products ==0){
                                        $SproductsID ='';
                                    }else{
                                        $SproductsID = str_replace('--','',$S_products) ;
                                    }

                                    $SInstockPCS ='';
                                    foreach($wareArr as $wkey=>$wcode){
                                        $$wcode .= '<td>'.$SproductsID.$SInstockPCS.'</td>';
                                    }
                                }
                            }
                        }

                        foreach($wareArr as $wkey=>$wcode){
                            $$wcode .= '</tr>';
                        }
                    }
                }
            }
        }
        foreach($wareArr as $wkey=>$wcode){
            $$wcode .= '</table></div><div class="categories_table_listBg"></div></div>';
        }
    }
    $productsID_arr=implode(',',$productsID_arr);

    $productsID_arr_html='<?php $html_SInstockPCS_Arr = fs_get_quickfinder_products_instock_arr("'.$productsID_arr.'");?>';

    if(count($fiber_optic_list)>1){
        foreach($wareArr as $wkey=>$wcode){
            $$wcode .= '</div>';
        }
    }

    if($current_category_id){
        $file_all = DIR_WS_MODULES .'quickFinder';
        if(is_dir($file_all) == false){
            mkdir($file_all,0777,true);
        }
        $file_arr = array('cn'=>'quickfinder_html','us'=>'us_html','de'=>'de_html','au'=>'au_html','sg'=>'sg_html');
        foreach($file_arr as $code=>$name){
            /* 创建 MVC-C */
            $file_C = $current_category_id.'_'.$code.'.php';

            /* 在当前目录下新建主页面文件 MVC-V */
            $fopen        = fopen($file_all.'/'.$file_C,   'w+b');

            $page_code = "<?php ?>".$productsID_arr_html.$$name." "; //页面尾部

            fputs($fopen,$page_code);//向文件中写入内容;
            fclose($fopen);
        }
    }
}


// 获取QF文件
function get_qf_file($quickFinder_cid,$warehouse_code){
    $warehouse_file = DIR_WS_MODULES . 'quickFinder/'.$quickFinder_cid.'_'.$warehouse_code.'.php';
    if(file_exists($warehouse_file)){
        return $warehouse_file;
    }else{
        $no_warehouse_file = DIR_WS_MODULES . 'quickFinder/'.$quickFinder_cid.'.php';
        if(file_exists($no_warehouse_file)){
            return $no_warehouse_file;
        }else{
            return '';
        }
    }
}
//对应分类标题
function get_show_categories_name($title_id=0,$cpath_type){
    //$title_id分类下的标题（3 三级分类下的四级标题）
    //$cpath_type分类ID
    if($title_id == 2){
        switch ($cpath_type) {
            case '1309':
            case '2997':
                return FS_CATEGORIES_01;
                break;
            case '1334':
                return FS_CATEGORIES_02;
                break;
            case '3368':
                return FS_CATEGORIES_03;
                break;
            case '3396':
                return FS_CATEGORIES_04;
                break;
            case '573':
                return FS_CATEGORIES_05;
                break;
            case '3079':
            case '3265':
                return FS_CATEGORIES_08;
                break;
            default:
                return BOX_HEADING_CATEGORIES;
                break;
        }
    }
    if($title_id == 3){
        switch ($cpath_type) {
            case '3266':
                return FS_CATEGORIES_06;
                break;
            case '1181':
                return FS_CATEGORIES_07;
                break;
            case '3091':
                return FS_CATEGORIES_01;
                break;
            default:
                return BOX_HEADING_CATEGORIES;
                break;
        }
    }
}

function getShowName($cPath_array){
    if ($cPath_array[0] == 9) {
        $showName = FS_COMPATIBLE_BRANDS;
    } elseif ($cPath_array[2] && in_array($cPath_array[2],[3266,1181,3091])){
        $showName = get_show_categories_name(3,$cPath_array[2]);
    }else {
        $showName = get_show_categories_name(2,$cPath_array[1]);
    }
    return $showName;
}

?>
