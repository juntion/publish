<?php
function zen_get_solution_category_name($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_name from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' where doc_categories_id = '.(int)$c_id.' and language_id = '.$_SESSION['languages_id']);
	
	return $get_info->fields['doc_categories_name'];
}

function zen_get_countries_name_of_id($cid){
	global $db;
	$get_info = $db->Execute("select countries_name from " . TABLE_COUNTRIES . ' where countries_id = '.(int)$cid);
	
	return $get_info->fields['countries_name'];

}

function zen_get_solution_article_name($c_id){
	global $db;
	$get_info = $db->Execute("select doc_article_title from " . TABLE_SOLUTION_ARTICLE_DESCRIPTION . ' where doc_article_id = '.(int)$c_id);
	
	return $get_info->fields['doc_article_title'];
}

function zen_get_solution_article_id_of_category_id($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_id from ". TABLE_SOLUTION_ARTICLE_CATEGORY .'   where doc_article_id = '.(int)$c_id);
	//$new_article_time = date('F j, Y',strtotime($get_info->fields['doc_article_last_modified']);
	//$sub_id = $get_info->fields['doc_categories_id'];
	
	//$get_parent = $db->Execute("select doc_parent_id from ". TABLE_SOLUTION_CATEGORIES .'   where doc_categories_id = '.(int)$sub_id);
	return $get_info->fields['doc_categories_id'];
}



function zen_get_solution_article_time($c_id){
	global $db;
	$get_info = $db->Execute("select doc_article_last_modified from " . TABLE_SOLUTION_ARTICLE . ' where doc_article_id = '.(int)$c_id);
	//$new_article_time = date('F j, Y',strtotime($get_info->fields['doc_article_last_modified']);
	return $get_info->fields['doc_article_last_modified'];
}

//   function zen_get_solution_categories_name($sid) {
//    global $db;
//    
//    $the_categories_name_query= "select doc_categories_name from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . " where doc_categories_id= '" . $sid . "' and language_id= '" . (int)$_SESSION['languages_id'] . "'";
//
//    $the_categories_name = $db->Execute($the_categories_name_query);
//
//    return $the_categories_name->fields['doc_categories_name'];
//  }


function zen_get_solution_category_description($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_description from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' where doc_categories_id = '.(int)$c_id);
	
	return $get_info->fields['doc_categories_description'];
}


function zen_get_solution_category_image($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_image from " . TABLE_SOLUTION_CATEGORIES. ' where doc_categories_id = '.(int)$c_id);
	
	return $get_info->fields['doc_categories_image'];
}

function zen_get_solution_category_intro($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_intro from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' where doc_categories_id = '.(int)$c_id);
	
	return $get_info->fields['doc_categories_intro'];
}


function zen_get_solution_category_declare($c_id){
	global $db;
	$get_info = $db->Execute("select doc_categories_declare from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' where doc_categories_id = '.(int)$c_id);
	
	return $get_info->fields['doc_categories_declare'];
}


function zen_get_solution_list_categories($c_id,$other_id){
	global $db;
	$solution_categories = array();
//	$sql = $db->Execute("select doc_categories_id,doc_categories_name from " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . ' as cd left join  where doc_parent_id = '.(int)$c_id);

	$categories_query = "select cd.doc_categories_id,cd.doc_categories_name,sac.doc_article_id from " .TABLE_SOLUTION_CATEGORIES_DESCRIPTION . " as cd
		left join " . TABLE_SOLUTION_CATEGORIES . " as sc  using(doc_categories_id)
		left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as sac  using(doc_categories_id)
		
		where cd.doc_categories_id=sc.doc_categories_id 
		and sac.doc_categories_id = cd.doc_categories_id
		and doc_other_categories_id = ".$other_id."
		and doc_parent_id = ".intval($c_id)." " ;
	
	
	$get_categories = $db->Execute($categories_query);
	if ($get_categories->RecordCount()){
		while(!$get_categories->EOF){
			$solution_categories [] = array(
					'id' => $get_categories->fields['doc_categories_id'],
			        'aid' => $get_categories->fields['doc_article_id'],
					'name' => $get_categories->fields['doc_categories_name']
			);
			$get_categories->MoveNext();
		}
	}
	return $solution_categories;
}


function zen_get_solution_list_article($s_id){
	global $db;
	$solution_articles = array();
	$articles_query = "select a.doc_article_id,ad.doc_article_title,a.doc_article_image,a.doc_article_date_added,doc_article_content from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
		left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id)
		left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as ac  using(doc_article_id)
		where doc_categories_id = ".$s_id . " limit 5 ";
		
	$get_articles = $db->Execute($articles_query);
	
		if ($get_articles->RecordCount()){
		while(!$get_articles->EOF){
			$solution_articles [] = array(
					'id' => $get_articles->fields['doc_article_id'],
			        'iamge' =>$get_articles->fields['doc_article_image'],
			        'add_time' => $get_articles->fields['doc_article_date_added'],
			        'content' =>stripslashes($get_articles->fields['doc_article_content']),
			
					'name' => $get_articles->fields['doc_article_title']
			);
			$get_articles->MoveNext();
		}
	}
	return $solution_articles;
}

//查找所有doc_parent_id=1 or =2的一级分类
function zen_get_solution_categories_of_parent($pid){
  global $db;
  
  $solution_subcategory = array();
  $categories_parent="select sc.doc_categories_id,scd.doc_categories_name from ".TABLE_SOLUTION_CATEGORIES." as sc
  left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . " as scd  using(doc_categories_id)
  where sc.doc_categories_id = scd.doc_categories_id
  and doc_parent_category=" . $pid . " ";
  
  $parent_category = $db->Execute($categories_parent);
  
if ($parent_category->RecordCount()){
		while(!$parent_category->EOF){
			$solution_subcategory [] = array(
					'id' => $parent_category->fields['doc_categories_id'],
					'name' => $parent_category->fields['doc_categories_name']
			);
			$parent_category->MoveNext();
		}
	}
return $solution_subcategory;
}

//查找二级分类
function zen_get_solution_subcategories($p_cid){
  global $db;
  
  $subcategory_list = array();
  $subcategory_parent="select sc.doc_categories_id,scd.doc_categories_name from ".TABLE_SOLUTION_CATEGORIES." as sc
  left join " . TABLE_SOLUTION_CATEGORIES_DESCRIPTION . " as scd  using(doc_categories_id)
  where sc.doc_categories_id = scd.doc_categories_id
  and doc_parent_id=".$p_cid." ";
  $sub_category = $db->Execute($subcategory_parent);
  
if ($sub_category->RecordCount()){
		while(!$sub_category->EOF){
			$subcategory_list [] = array(
					'id' => $sub_category->fields['doc_categories_id'],
					'name' => $sub_category->fields['doc_categories_name']
			);
			 $sub_category->MoveNext();
		}
	}
return $subcategory_list;
}

function zen_get_solution_article_of_category($cid){
  global $db;
     $cid =array();
	$articles_query = "select a.doc_article_id,ad.doc_article_title,ad.doc_article_content,a.doc_article_image,a.doc_article_last_modified
		    from " .TABLE_SOLUTION_ARTICLE_DESCRIPTION . " as ad
			left join " . TABLE_SOLUTION_ARTICLE ." as a using(doc_article_id)
			left join " . TABLE_SOLUTION_ARTICLE_CATEGORY . " as ac using(doc_article_id)
			where  doc_categories_id in (".join(',',$cid).") ";

		$get_articles = $db->Execute($articles_query);
		$article_array = array();
		if ($get_articles->RecordCount()){
			while (!$get_articles->EOF){
				$article_array[] = array(
						'id' => $get_articles->fields['doc_article_id'],
						'title' => $get_articles->fields['doc_article_title'],
				        'image' => $get_articles->fields['doc_article_image'],
				        'time' => $get_articles->fields['doc_article_last_modified'],
						'content' => stripslashes($get_articles->fields['doc_article_content'])	
				);
				$get_articles->MoveNext();
			}
		}
  	return $article_array;

}

function get_article_one($cate_id = 0){
global $db;
$categories = array();
$condition = '';
if($cate_id == 0){
    $condition = 'and c.doc_categories_is_new = 1';
}
$sql = "SELECT c.doc_categories_id AS id , cd.doc_categories_name AS name, cd.doc_categories_description as description , c.doc_categories_image as image,c.doc_categories_image_attribute as image_alt  FROM ".TABLE_SOLUTION_CATEGORIES." AS c LEFT JOIN ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION." AS cd ON (c.doc_categories_id = cd.doc_categories_id)
WHERE c.doc_parent_id = ".$cate_id." and  cd.language_id = ".(int)$_SESSION['languages_id']."  ".$condition." order by  c.doc_sort_order";

$result = $db->Execute($sql);
while (!$result->EOF) {
    $categories [] = array('id' => $result->fields['id'],'image' => $result->fields['image'],
                           'image_alt' => $result->fields['image_alt'],'name' => $result->fields['name'],
                           'description' => $result->fields['description'],
                           );
    $result->MoveNext();
}
return $categories;
}

function get_article_one_id($cate_id = 0){
global $db;
$categories = array();
$condition = '';
if($cate_id == 0){
    $condition = 'and c.doc_categories_is_new = 1';
}
$sql = "SELECT c.doc_categories_id AS id   FROM ".TABLE_SOLUTION_CATEGORIES." AS c LEFT JOIN ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION." AS cd ON (c.doc_categories_id = cd.doc_categories_id)
WHERE c.doc_parent_id = ".$cate_id." and  cd.language_id = ".(int)$_SESSION['languages_id']."  ".$condition." order by  c.doc_sort_order";

$result = $db->Execute($sql);
while (!$result->EOF) {
    $solution_c = $db->Execute("select sc.doc_categories_id as id,doc_parent_id,scd.doc_categories_name as name,scd.doc_categories_description as 	content,sc.doc_categories_image as image from solution_categories as sc left join solution_categories_description as scd on(sc.doc_categories_id =scd.doc_categories_id) where sc.doc_parent_id = ". $result->fields['id'] ." and scd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		
	$categories[] = $solution_c->fields['id'];
    $result->MoveNext();
}
return $categories;
}

function get_article_two($cate_id = 0){
    /*    $dblink = mysql_connect("localhost", "fiberstoredb", "yUxuan3507");
        mysql_select_db("fiberstore_spain",$dblink);
        mysql_query("SET names UTF8");
        header("Content-Type: text/html; charset=utf-8");*/

    $categories = array();
    $condition = '';
    if($cate_id == 0){
        $condition = 'and c.doc_categories_is_new = 0';
    }
    $sql = "SELECT c.doc_categories_id AS id , cd.doc_categories_name AS name, cd.doc_categories_description as description , c.doc_categories_image as image,c.doc_categories_image_attribute as image_alt  FROM ".TABLE_SOLUTION_CATEGORIES." AS c LEFT JOIN ".TABLE_SOLUTION_CATEGORIES_DESCRIPTION." AS cd ON (c.doc_categories_id = cd.doc_categories_id)
WHERE c.doc_parent_id = ".$cate_id."  and  cd.language_id = '".$_SESSION['languages_id']."' ".$condition." order by  c.doc_sort_order";

    $result = mysql_query($sql);
    while ($row = mysql_fetch_assoc($result)) {
        $categories [] = $row;
    }
    return $categories;
}

function get_article_three($page){
global $db;
$Spage = $page ? $page : 1 ;  
$limit =($Spage-1)*15;
$products_latest = "select sa.support_articles_id,sa.support_articles_image,sad.support_articles_title,sad.support_articles_intro,sad.support_articles_description
	from support_articles as sa left join support_articles_description as sad on(sa.support_articles_id = sad.support_articles_id)
	where sad.language_id = '".$_SESSION['languages_id']."' and sa.support_articles_status=1 order by sa.support_articles_sort_order desc limit ".$limit.",15";
$get_products_latest = $db->Execute($products_latest);
    $support_article_array = array();
while(!$get_products_latest->EOF){
    $support_article_array[] = array(
        'id' => $get_products_latest->fields['support_articles_id'],
        'title' => $get_products_latest->fields['support_articles_title'],
        'description' => stripslashes($get_products_latest->fields['support_articles_description']),
        'intro' => stripslashes($get_products_latest->fields['support_articles_intro']),
        'image' => $get_products_latest->fields['support_articles_image'],
    );
    $get_products_latest->MoveNext();
}
    return $support_article_array;
}

function get_solution_count(){
	global $db;
	$sql = "select count(sa.support_articles_id) as total from support_articles as sa left join support_articles_description as sad on(sa.support_articles_id = sad.support_articles_id)
	where sad.language_id = '".$_SESSION['languages_id']."' and sa.support_articles_status=1 ";
	$get_total = $db->Execute($sql);
	$total =$get_total->fields['total'];
	return $total;
}

/*
 *得到总的评论数
 *params	integer	  $solution_id	 解决方案的id
 *return	integer	  $total_nums	当前解决方案的总评论数
 *author	fallwind  2016.9.29
*/
function get_total_reviews_num($solution_id){
	global $db;
	$reviews_nums_query = "SELECT count(review_id) as total_nums FROM `solutions_reviews` where solution_id = ".$solution_id;
	$res = $db->Execute($reviews_nums_query);
	$total_nums = $res->fields['total_nums'];
	return $total_nums;
}

/*
 *得到总的感谢数
 *params	integer	  $solution_id	 解决方案的id
 *return	integer	  $thanks_nums	当前解决方案的感谢数
 *author	fallwind  2016.9.29
*/
function get_total_thanks_num($solution_id){
	global $db;
	$reviews_thanks_query = "SELECT  total_thanks FROM `solution_method` where solution_id = ".$solution_id;
	$res = $db->Execute($reviews_thanks_query);
	$thanks_nums = $res->fields['total_thanks'];
	return $thanks_nums;
}

/*
 *得到所有的评论
 *params	integer	  $solution_id	 解决方案的id
 *params	array	  $reviews_array 保存所有评论的数组
 *params	integer	  $reply_id		 回复的id
 *return	array	  $reviews_array 所有评论的数组
 *author	fallwind  2016.9.29
*/
function get_solution_all_reviews($solution_id,&$reviews_array=array(),$reply_id=0){
	global $db;
	$sql = "SELECT *,c.customers_firstname as user_name FROM `solutions_reviews` as sr 
			left join `customers` as c on c.customers_id = sr.user_id
			WHERE sr.solution_id = $solution_id and sr.reply_id = $reply_id";
	$res = $db->Execute($sql);
	
	$reply_name = '';
	if($reply_id != 0){
		$sql2 = "SELECT c.customers_firstname as reply_name FROM `customers` as c
			left join `solutions_reviews` as sr on sr.user_id = c.customers_id
			WHERE sr.solution_id = $solution_id and sr.review_id = $reply_id";
		$res2 = $db->Execute($sql2);
		$reply_name = $res2->fields['reply_name'];
	}
	
	if($res->RecordCount()){
		while (!$res->EOF){
			$reviews_array[] = array(
				'review_id' => $res->fields['review_id'],
				'reply_id' => $res->fields['reply_id'],
				'solution_id' => $res->fields['solution_id'],
				'user_id' => $res->fields['user_id'],
				'reply_name'=>$reply_name,
				'user_name'=>$res->fields['user_name'],
				'praise_num' => $res->fields['praise_num'],	
				'review_content'=>$res->fields['review_content'],
				'create_time'=>$res->fields['create_time']
			);
			get_solution_all_reviews($solution_id,$reviews_array,$res->fields['review_id']);
			$res->MoveNext();
		}
	}

	return $reviews_array;
}

/*
 *查看对话的内容
 *params	integer	  $review_id	 当前评论人的review_id
 *params	integer	  $first_id 	 等于$review_id
 *params	array	  $view_dialog	 两个对话的数组
 *return	array	  $view_dialog
 *author	fallwind  2016.9.29
*/
function getViewDialog($review_id,$first_id,&$view_dialog=array(),$i=1){
	global $db;
	$first_review_id = $first_id;
	if($review_id != 0){
		$sql = "SELECT *,c.customers_firstname as user_name FROM `solutions_reviews` as sr 
			left join `customers` as c on c.customers_id = sr.user_id
			WHERE sr.review_id = $review_id";
		$res = $db->Execute($sql);
		$reply_id = $res->fields['reply_id'];
	
		if($i == 1 || $reply_id == 0 || $reply_id == $first_review_id){
			$sql2 = "SELECT c.customers_firstname as reply_name FROM `customers` as c
				left join `solutions_reviews` as sr on sr.user_id = c.customers_id
				WHERE sr.review_id = $reply_id";
			
			$res2 = $db->Execute($sql2);
			$reply_name = $res2->fields['reply_name'];
			while (!$res->EOF){
				$view_dialog[] = array(
					'review_id' => $res->fields['review_id'],
					'reply_id' => $res->fields['reply_id'],
					'solution_id' => $res->fields['solution_id'],
					'user_id' => $res->fields['user_id'],
					'reply_name'=>$reply_name,
					'user_name'=>$res->fields['user_name'],
					'praise_num' => $res->fields['praise_num'],	
					'review_content'=>$res->fields['review_content'],
					'create_time'=>$res->fields['create_time']
				);	
				
				getViewDialog($res->fields['reply_id'],$first_review_id,$view_dialog,++$i);
				$res->MoveNext();
			}
		}
	}
	
	return $view_dialog;
}

/*
 *获取一个solution文章的banner图内容
 *params	integer	  $a_id	 文章id
 *return	array	  		 banner图内容
 *author	fallwind  2016.10.12
*/
function get_banner_content($a_id){
	global $db;
	$sql = "select banner_content from `support_articles_description` where support_articles_id = $a_id and language_id = ".$_SESSION['languages_id'];
	$res = $db->Execute($sql);
	return $res->fields['banner_content'];
}

function get_curr_time_section()
{
    //ternence 2019/6/13 由于客服周末也在线，关闭留言入口
    return 2;
    exit;
//	$time=time();
//	$checkDayStr = date('Y-m-d ',$time);
////周末
//	if(date('w',$time)==6){
//		return 1;
//		exit;
//	}elseif(date('w',$time)==5){
//		//周五
//		$timeBegin1 = strtotime($checkDayStr."20:30".":00");
//		$timeEnd1 = strtotime($checkDayStr."23:59".":59");
//		if($time >= $timeBegin1 && $time <= $timeEnd1)
//		{
//			return 1;
//			exit;
//		}
//	}elseif(date('w',$time)==0){
//		//周日
//		$timeBegin2 = strtotime($checkDayStr."00:00".":00");
//		$timeEnd2 = strtotime($checkDayStr."16:30".":00");
//		if($time >= $timeBegin2 && $time <= $timeEnd2)
//		{
//			return 1;
//			exit;
//		}
//	}
//	return 2;
}


//add by ternence 获取此文章点赞数量
function zen_get_doc_like($doc_id){
	global $db;
	if(in_array($_SESSION['languages_id'],array(1,9,10,11,13))){
		$give_number = $db->Execute("select COUNT(id) from ".TABLE_GIVE_A_LIKE." where doc_article_id=".$doc_id." and language_id in(1,9,10,11,13) and type=1")->fields['COUNT(id)'];
	}else{
		$give_number = $db->Execute("select COUNT(id) from ".TABLE_GIVE_A_LIKE." where doc_article_id=".$doc_id." and language_id=".$_SESSION['languages_id']." and type=1")->fields['COUNT(id)'];

	}
	return $give_number?$give_number:0;
}
