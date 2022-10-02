<?php
function fliter_safe($str){
	$html_string = array("&amp;","&nbsp;","'",'"',"<", ">","\t","\r");
	$html_clear = array("&"," ","&#39;","&quot;","&lt;","&gt;","&nbsp; &nbsp;","");
	$js_string = array("/<script(.*)<\/script>/isU");
	$js_clear = array("");
	$frame_string = array("/<frame(.*)>/isU","/<\/fram(.*)>/isU","/<iframe(.*)>/isU","/<\/ifram(.*)>/isU",);
	$frame_clear = array("","","","");
	$style_string = array("/<style(.*)<\/style>/isU","/<link(.*)>/isU","/<\/link>/isU");
	$style_clear = array("","","");
	$sql_string = array("select",'insert',"update","delete","\'","\/\*","\.\.\/", "\.\/","union","into","load_file","outfile");
	$sql_clear = array("","","","","","","","","","","","");
	$str = trim($str);
	
	//过滤字符串
	$str = str_replace($html_string,$html_clear,$str);
	
	//过滤JS
	$str = preg_replace($js_string,$js_clear,$str);
	
	//过滤ifram
	$str = preg_replace($frame_string,$frame_clear,$str);
	
	//过滤style
	$str = preg_replace($style_string,$style_clear,$str);
	
	//过滤sql
	$str = str_replace($sql_string,$sql_clear,$str);
	
	$str = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i","&111n\\2",$str);
	
	//$str = preg_replace("/\/\/iesU/",'',$str);
	return $str;
}

/**
 *过滤非法字符
 *params	string/array	$str  	原始数据,可以是字符串或者数组
 *return	string/array	$str	过滤后的数据
 *author	fallwind		2016.9.29 
*/
function fliter_escape($str){
	if(is_array($str)){
		foreach($str as $k=>$v){
			$str[$k] = fliter_safe($v);
		}
	}else{
		$str = fliter_safe($str);
	}
	return $str;
}

function get_save_products_list($share_id){
	global $db;
	$share_data = [];
	if((int)$share_id){
		$query = $db->Execute("SELECT `from_email`,`share_products`,`from_page` FROM `customers_basket_share` WHERE id=".(int)$share_id);
		if($query->RecordCount()){
			$share_data = $query->fields;
		}
	}
	return $share_data;
}

function create_share_products_code($email,$id){
	$code = '';
	if($email && $id){
		$code = md5($email.':'.$id);
	}
	return $code;
}

?>