<?php
require 'includes/application_top.php';
//include_once("includes/templates/fiberstore/common/connect.php");
header("Content-Type: text/html; charset=utf-8");

global $db;
$result = array();

$q = strtolower($_GET["q"]);
if (!$q) return;

$count = $db->Execute("select count(*) from meta_tags_of_search_products where tag_name like '$q%'");

if($count->RecordCount() > 0){
$query =$db->Execute("select products_id,tag_name from meta_tags_of_search_products where tag_name like '$q%'");
}

while (!$query->EOF) {

$row_url = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.(int)$query->fields['products_id'],'NONSSL');

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
