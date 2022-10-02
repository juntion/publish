<?php 
require 'includes/application_top.php';

$page = intval($_POST['pageNum']); //当前页 
$Nyear = intval($_POST['Nyear']); //当前页 

$result = mysql_query("select r.reviews_id from reviews as r join reviews_description as rd on r.reviews_id = rd.reviews_id where r.products_id = $pID"); 
$total = mysql_num_rows($result);//总记录数 
$pageSize = 8; //每页显示数 
$totalPage = ceil($total/$pageSize); //总页数 
 
$startPage = $page*$pageSize; //开始记录 
//构造数组 
$arr['total'] = $total; 
$arr['pageSize'] = $pageSize; 
$arr['totalPage'] = $totalPage; 

$sql = "select r.reviews_id as id,r.products_id as pID,r.customers_name as name,r.date_added,r.reviews_rating as rating,rd.reviews_text as content,lon.r_like,lon.r_bad
from reviews as r join reviews_description as rd on r.reviews_id = rd.reviews_id 
left join reviews_like_or_not as lon on r.reviews_id = lon.reviews_id 
where r.products_id = $pID order by r.reviews_id desc limit $startPage,$pageSize";
//$arr['sql'] = $sql; 
//$comments_count = $db->Execute("select count(comments_id) from reviews_comments as rc left join reviews as r on rc.reviews_id=r.reviews_id");

$query = mysql_query($sql); //查询分页数据 

while($row=mysql_fetch_array($query)){ 
     $arr['list'][] = array( 
        'rid' => $row['id'], 
      	'pid' => $row['pID'], 
     	'name' => $row['name'],
        'date' => date('F j,Y',strtotime($row['date_added'])),
     	'rating' => $row['rating'], 
        'content' => $row['content'],
     	'r_like' => $row['r_like'],
     	'r_bad' => $row['r_bad']
     ); 
} 
echo json_encode($arr); //输出JSON数据 
