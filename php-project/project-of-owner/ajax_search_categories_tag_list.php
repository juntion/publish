<?php
require 'includes/application_top.php';
//include_once("includes/templates/fiberstore/common/connect.php");
header("Content-Type: text/html; charset=utf-8");

global $db;
$result = array();

$q = strtolower($_GET["q"]);
if (!$q) return;

$count = $db->Execute("select count(*) from meta_tags_of_search_categories where tag_name like '$q%' and language_id='" . (int)$_SESSION['languages_id'] . "'");

if($count->RecordCount() > 0){
	$query =$db->Execute("select tag_categories_id,tag_name from meta_tags_of_search_categories where tag_name like '$q%' and language_id='" . (int)$_SESSION['languages_id'] . "'");
}

while (!$query->EOF) {

if($query->fields['tag_categories_id']){
 $row_url = zen_href_link('tag_categories','tag='.(int)$query->fields['tag_categories_id']);
}
	$result [] = array(
	    	$query->fields['tag_name'] => $row_url
		);
	$query->MoveNext();	
}
foreach ($result as $key=>$value) {
	foreach ($value as $i=>$arr){
		echo "$i|$arr\n";
	}
}
?>
