<?php
//created by aron
//2018.5.10
require_once('includes/classes/simple_html_dom.php');
//改变整个dom a链接
function change_link($content)
{
   /* if (!isset($_GET['lang'])) {
        echo $content;
        return;
    }*/
    //it站点批量替换eu邮箱
    if($_SESSION['countries_iso_code']=="it") {
        $content = str_replace("eu@fs.com","italy@fs.com",$content);
    }
    $simple_dom = new simple_html_dom();
    $html = $simple_dom->load($content);
    $a = $html->find('a');
    $en = trim($_GET['lang']);
	$site_arr = ['es','mx','ru','jp','au','uk','fr','de','en','sg','it'];
    $skip_url = array("cloud.fs.com/","javascript:;",'javascript:void(0)',"mailto:","tel:","fsbox.com","community.fs.com");
    foreach ($a as $k) {
		foreach($skip_url as $sval){
			if(strpos($k->href,$sval)!==false){
				continue 2;
			}
		}
        $k->href = str_replace(' ','',$k->href);
        $link_arr = explode("/", $k->href);
        $last_element = end($link_arr);
        if (empty($link_arr[0]) || preg_match("/^(http|https)/", ltrim($link_arr[0]))) {
            if (preg_match("/^(http|https)/", $link_arr[0])) {
				if(preg_match("/fs.com/", $link_arr[2])){
					unset($link_arr[1]);
					unset($link_arr[2]);
					if($link_arr[3]=='de' && $link_arr[4]=='en'){
						//德语英文站的链接是de/en要把这个去掉
						unset($link_arr[3]);
						unset($link_arr[4]);
					}
					if($link_arr[3]==$en || $link_arr[3]=='es'){
						unset($link_arr[3]);
					}
				}else{
					continue ;
				}
            }
            unset($link_arr[0]);
            $link_arr = array_values($link_arr);
        }
		if(in_array($link_arr[0], $site_arr)){
			unset($link_arr[0]);
			if($link_arr[1]=='en') unset($link_arr[1]);
			$link_arr = array_values($link_arr);
		}
        $length = sizeof($link_arr);
        if (in_array($link_arr[0], array("javascript","javscript:;"))) {
            continue;
        }
        if (in_array(substr($last_element, strrpos($last_element, '.') + 1), array("pdf", "jpg", "png", "rar", "zip", "7z"))) { //7z也是压缩包的一种
            //图片以及PDF调用资源服务器
            if (isset($k->href)) {
                $k->href = HTTPS_IMAGE_SERVER.implode("/", $link_arr);
            }
            continue;
        }
        if($en && in_array($en,$GLOBALS['fs_all_site'])) {
            for ($i = 0; $i < $length; $i++) {
                if ($link_arr[$i] == $en) {
                    break;
                }
                if ($link_arr[$i] == $en) {
                    array_splice($link_arr, $i + 1, 0, $en);
                    break;
                }else {
                    array_unshift($link_arr, $en);
                    break;
                }
            };
        }
        if (isset($k->href)) {
            $k->href = implode("/", $link_arr);
        }
    }
    echo $html;
    //避免解析器消耗过多内存
    $simple_dom->clear();
}
/*
* @Author: dori
* @Date: 2019/6/20
* @para:String $keyword：要替换的字符串,String $dataPage：页面内容,Array $tag_img_list：tag图的数组数据
*@para string $page：tpl_fs_single_pages_default.php
* @return array：Array $tag_img_list:带有标题和内容和替换之后的文本的数组
* @description:替换文本编辑器中的特定字符，取出特定字符中间的数据，组成数组返回
*/
function match_get_content($keyword,$dataPage,$tag_img_list=[],$num=7){
    //匹配标题内容
    $match = '/{'.$keyword.'_\d}.*{\/'.$keyword.'}/isU';
    preg_match_all($match, $dataPage, $data);
    $tag_img_list['dataPage'] = $dataPage;
    foreach ($data[0] as $key=>$val){
        //替换关键字
        $tag_img_list['dataPage'] = str_replace($val,'',$tag_img_list['dataPage']);
        for($i=1;$i<$num;$i++){
            $val = str_replace('{'.$keyword.'_'.$i.'}','',$val);
        }
        $val = str_replace('{/'.$keyword.'}','',$val);
        $tag_img_list[$key][$keyword] = $val;
    }
    return $tag_img_list;
}

//改变单个a链接
function reset_url($url,$is_reset=false)
{
    $en = $_GET['lang'];
    $link_arr = explode("/", $url);
    $last_element = end($link_arr);
    if (empty($link_arr[0]) || preg_match("/^(http|https)/", ltrim($link_arr[0]))) {
        //https://community.fs.com/  https://www.youtube.com/FiberStore  不切割路径
        if(in_array($link_arr[2],array('community.fs.com','www.youtube.com'))){
            return $url;
        }
        if (preg_match("/^(http|https)/", $link_arr[0])) {
            unset($link_arr[1]);
            unset($link_arr[2]);
            if($link_arr[3]==$en){
                unset($link_arr[3]);
            }
        }
        unset($link_arr[0]);
        $link_arr = array_values($link_arr);
    }
    $length = sizeof($link_arr);
    if (in_array($link_arr[0], array('file', "javascript"))) {
        return $url;
    }
    if (in_array(substr($last_element, strrpos($last_element, '.') + 1), array("pdf", "jpg"))) {
        return $url;
    }
    if($en && in_array($en,$GLOBALS['fs_all_site'])) {
        for ($i = 0; $i < $length; $i++) {
            if ($link_arr[$i] == $en) {
                break;
            }
            if ($link_arr[$i] == $en) {
                array_splice($link_arr, $i + 1, 0, $en);
                break;
            } else {
                array_unshift($link_arr, $en);
                break;
            }
        }
    }
    if (isset($url)) {
        $url = implode("/", $link_arr);
    }
    $url = trim($url);
	if(substr($url,0,1)!='/'){
		$url = '/'.$url;
	}
    return $url;
}
//判断是否为ajax请求
function isAjax()
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}
//end

function isGet()
{
    return (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'GET'));
}

function isPost()
{
    return (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'POST'));
}

/**
 * add by aron 2019/2/13
 * 对content 进行图片路径替换等处理 (后续文本处理都可以用改函数)
 * @param string $content
 * @return string
 */
function handle_content($content = "")
{
    if (empty($content)) {
        return "";
    }
    if (!is_string($content)) {
        return $content;
    }
    $simple_dom = new simple_html_dom();
    $html = $simple_dom->load($content);
    $img = $html->find("img");
    //兼容测试站资源服务器域名
    $resource_server = explode('/',HTTPS_IMAGE_SERVER)[2];
    if($img){
        foreach ($img as $imgs){
            if(isset($imgs->src)){
                $host_status = true;   //图片链接是否有评接域名
                if(strpos($imgs->src,'www.fs.com')===false && strpos($imgs->src,$resource_server)===false && strpos($imgs->src,'img-en.fs.com')===false){
                    $host_status = false;
                }
                if(STATIC_RESOURCE_UP){
                    $imgs->src = str_replace("www.fs.com", "img-en.fs.com", $imgs->src);
                    if(!$host_status){
                        if(substr($imgs->src,0,1)=='/'){
                            $imgs->src = substr($imgs->src,1);
                        }
                        $imgs->src = HTTPS_IMAGE_SERVER.$imgs->src;
                    }
                }else{
                    $imgs->src = str_replace("img-en.fs.com", "www.fs.com", $imgs->src);
                }
            }
        }
    }
    return $html;
}

/**
 * add by Jeremy 2020/6/8
 * 对content 中的mtp进行正则
 * @param string $content
 * @param int $cid
 * @return string
 */
function content_preg_mtp($content = "", $cid = 0)
{
    if (empty($content)) {
        return "";
    }
    $flag = true;
    if($cid > 0){
        if(!in_array((int)$cid,array(209,1308))){
            $flag = false;
        }
    }
    if($flag){
        //MTP增加R标识
        $content = preg_replace('#MTP(?!®)\b#', 'MTP®', $content);
    }

    return $content;
}
?>