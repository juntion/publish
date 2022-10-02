<?php
//$file文件路径，$code站点名
/**
 * update by rebirth  2019/10/04
 * 清除自动增加版本号的功能
 *
 * @param $file
 * @param string $code
 * @return mixed
 */
function auto_version($file, $code = '')
{
    //echo $code;
    $file_true = $file;
    $first_letter = substr($file, 0, 1);
    $replaceStr = 'includes/templates/fiberstore/';
    if ($first_letter != '/' && $first_letter != '\\') {
        $file_true = '/' . $file_true;
    }
    $code = '';
    if ($code) {
        $file_true = $code . $file_true;
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file_true)) {
        $version = md5(filemtime($_SERVER['DOCUMENT_ROOT'] . $file_true));
    } else {
        $version = md5(time());
    }
    $baseUrl = '';
    if (IS_USE_REMOTE_STORAGE) {
        $baseUrl = RESOURCE_STATIC_URL;
        $file = str_replace($replaceStr, '',$file);
        if (!strStartWith($file, '/')) {
            $baseUrl .= '/';
        }
		return $baseUrl . $file . '?id=' . $version;
    }
	//兼容历史版本
	$v = get_redis_key_value("commonVersion");
	if(!$v){
		$v = time();
		set_redis_key_value("commonVersion",$v);
	}
	return $file.'?v='.$v;
}

function strStartWith($haystack, $needles){
	foreach ((array) $needles as $needle) {
		if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
			return true;
		}
	}

	return false;
}
/**
 * update by rebirth  2019/10/04
 * 清除自动增加版本号的功能
 *
 * @param $file
 * @param string $code
 * @return mixed
 */
function auto_code_version($file){
	$file_code = '';
	if(strpos($file,'?')!==false){
		$file_arr = explode('?',$file);
		$file = $file_arr[0];
	}
    if($_SESSION['languages_code']!='en'){
		//加载对应站点的文件
		$file_arr = explode('/',$file);
		foreach($file_arr as $key=>$val){
			if($val){
				if(in_array($val,array('css','jscript'))){
					$file_code .= $val.'/'.$_SESSION['languages_code'].'/';
				}else{
					$file_code .= $val.'/';
				}
			}
		}
        $file_code = substr($file_code,0,strlen($file_code)-1);

		//如果对应小语种的样式文件不存在就加载英文站样式
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_code)){
			$file_code = $file;
		}
    }else{
		$file_code = $file;
	}
//	$file_true = $file_code;
//	$first_letter = substr($file_true,0,1);
//    if($first_letter != '/' && $first_letter != '\\'){
//        $file_true = '/'.$file_true;
//    }
//    if(file_exists($_SERVER['DOCUMENT_ROOT'].$file_true)){
//        $version = filemtime($_SERVER['DOCUMENT_ROOT'].$file_true);
//    }else{
//        $version = 1;
//    }
//    return $file_code.'?v='.$version;
	$file_code = auto_version($file_code);
	return $file_code;
}
?>
