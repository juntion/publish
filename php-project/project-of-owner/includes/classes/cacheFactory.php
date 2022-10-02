<?php
/**
 * @todo caching html contents of some parts to file  in system
 * @author Kevin
 *
 */
class cacheFactory{
	/**
	 * 
	 * @param unknown $related_file_path
	 * @param unknown $html
	 * @return boolean
	 * 
	 * @todo get cached file contents
	 */
	public static function get_cached_file_contents($related_file_path, & $html){
		if (file_exists($related_file_path) && filesize($related_file_path)) {
			$html = file_get_contents($related_file_path);
			return true;
		}		
		return false;
	}

    /**
     *
     * @param string $file_name：文件名称
     * @param string $file_path：文件路径
     * @param string $html：填写的内容
     * @todo store categories html contents to file of home page
     */
    public static function save_caching_file_contents($file_name,$file_path, $html){
        $file_path_name = $file_path.$file_name;
        if ($html) {
            if(!is_dir($file_path)){
                mkdir($file_path,0777,true);
            }
            chmod($file_path,0777);

            file_put_contents($file_path_name,$html);
        }
    }


	public static function LoadingCache($files){
		global $cache_array_info,$cache_array;
		if($files == 'tpl_box_menu.php'){
			foreach($cache_array_info as $key=>$v){
				if($_GET['main_page'] == $key){
					if(empty($v)){
						if(isset($_GET['page'])){
							$file = $key."_".$_GET['page'];
						}else{
							$file = $key;
						}
					}else{
						if(isset($_GET['page'])){
							$file = md5($v."_".$_GET[$v]."_".$_GET['page']);
						}else{
							$file = md5($v."_".$_GET[$v]);
						}
					}
					//各站点加载对应的缓存
					$file .= '_'.$_SESSION['languages_code'];
					if($_GET['main_page']=='product_info'){

						if(isset($_SESSION['customer_id']) && intval($_SESSION['customer_id'])>0){
						}else{
							if($_SESSION['currency'] == 'USD'){
								if(file_exists(DIR_FS_CATALOG.'cache/products/'.$file.'.html') && filesize(DIR_FS_CATALOG.'cache/products/'.$file.'.html')){
									require(DIR_FS_CATALOG.'cache/products/'.$file.'.html');exit;
								}	
							}
						}
					}else{			
						$cache_file = DIR_FS_CATALOG.'cache/products/'.$key.'/'.$file.'.html';
						if(file_exists($cache_file) && filesize($cache_file)){
							require($cache_file);exit;
						}
					}
				}
			}
			if(in_array($_GET['main_page'],$cache_array)){
				if($_GET['main_page']=='product_info'){
					if(isset($_SESSION['customer_id']) && intval($_SESSION['customer_id'])>0){
					}else{
						if($_SESSION['currency'] == 'USD'){
							ob_start();
						}
					}
				}else{
					ob_start();
				}
			}
		}
		
	}
}