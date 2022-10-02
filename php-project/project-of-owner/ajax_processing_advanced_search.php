<?php
require 'includes/application_top.php';
include_once("includes/templates/fiberstore/common/connect.php");

$result = array();
$q = strtolower($_GET["term"]);

$query=mysql_query("select DISTINCT categories_name from categories_description where categories_name like '$q%' and language_id = ".$_SESSION['languages_id']." limit 0,10");

while ($row=mysql_fetch_array($query)) {
	$result[] = array(
		    //'id' => $row['frequency'],
		    'label' => $row['categories_name']
	);
}
echo json_encode($result,true);

?>
