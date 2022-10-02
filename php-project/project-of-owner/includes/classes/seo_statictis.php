<?php
class seo_statictis{
	
	function __construct(){
		
	}	
	function insert($url,$agent,$ip){
		global $db;
		$arr = explode('/',$url);
		//if($arr[2]){
			//$ip = gethostbyname($arr[2]);
		//}else{
			//$ip = '';
		//}
		if($url){
			$domain = str_replace('www.','',$arr[2]);
			//$db->query("insert into seo_statistics  (url,domain,user_agent,ip,add_time) values ('$url','".$domain."','$agent','$ip','".date('Y-m-d H:i:s',time())."')");
			return true;
		}else{
			return false;
		}
	}
}
?>