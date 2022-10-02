<?php 
function fs_web_security_manage($str){

  if(strlen($str) > 255 &&
	strpos($str, "eval(") ||
	strpos($str, "base64") || 
	strpos($str,"union") || 
	strpos($str,"select") || 
	strpos($str,"information_schema") || 
	strpos($str,"md5")){
	
	header('HTTP/1.1 404 Not Found');
zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND));
	
	}
} 


?>