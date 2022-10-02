<?php
/*
 *说明：函数功能是把一个图像裁剪为任意大小的图像，图像不变形
 * 参数说明：输入 需要处理图片的 文件名，生成新图片的保存文件名，生成新图片的宽，生成新图片的高
 * written by smallchicken
 * time 2008-12-18
 */
// 获得任意大小图像，不足地方拉伸，不产生变形，不留下空白
function my_image_resize($src_file, $dst_file, $new_width, $new_height) {
	if ($new_width < 1 || $new_height < 1) {
		echo "params width or height error !";
		exit ();
	}
	if (! file_exists ( $src_file )) {
		echo $src_file . " is not exists !";
		exit ();
	}
	// 图像类型
	$type = exif_imagetype ( $src_file );
	$support_type = array (IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF );
	if (! in_array ( $type, $support_type, true )) {
		echo "this type of image does not support! only support jpg , gif or png";
		exit ();
	}
	//Load image
	switch ($type) {
		case IMAGETYPE_JPEG :
			$src_img = imagecreatefromjpeg ( $src_file );
			break;
		case IMAGETYPE_PNG :
			$src_img = imagecreatefrompng ( $src_file );
			break;
		case IMAGETYPE_GIF :
			$src_img = imagecreatefromgif ( $src_file );
			break;
		default :
			echo "Load image error!";
			exit ();
	}
	$w = imagesx ( $src_img );
	$h = imagesy ( $src_img );
	$ratio_w = 1.0 * $new_width / $w;
	$ratio_h = 1.0 * $new_height / $h;
	$ratio = 1.0;
	// 生成的图像的高宽比原来的都小，或都大 ，原则是 取大比例放大，取大比例缩小（缩小的比例就比较小了）
	if (($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1)) {
		if ($ratio_w < $ratio_h) {
			$ratio = $ratio_h; // 情况一，宽度的比例比高度方向的小，按照高度的比例标准来裁剪或放大
		} else {
			$ratio = $ratio_w;
		}
		// 定义一个中间的临时图像，该图像的宽高比 正好满足目标要求
		$inter_w = ( int ) ($new_width / $ratio);
		$inter_h = ( int ) ($new_height / $ratio);
		$inter_img = imagecreatetruecolor ( $inter_w, $inter_h );
		imagecopy ( $inter_img, $src_img, 0, 0, 0, 0, $inter_w, $inter_h );
		// 生成一个以最大边长度为大小的是目标图像$ratio比例的临时图像
		// 定义一个新的图像
		$new_img = imagecreatetruecolor ( $new_width, $new_height );
		imagecopyresampled ( $new_img, $inter_img, 0, 0, 0, 0, $new_width, $new_height, $inter_w, $inter_h );
		switch ($type) {
			case IMAGETYPE_JPEG :
				imagejpeg ( $new_img, $dst_file, 100 ); // 存储图像
				break;
			case IMAGETYPE_PNG :
				imagepng ( $new_img, $dst_file, 100 );
				break;
			case IMAGETYPE_GIF :
				imagegif ( $new_img, $dst_file, 100 );
				break;
			default :
				break;
		}
	} // end if 1
// 2 目标图像 的一个边大于原图，一个边小于原图 ，先放大平普图像，然后裁剪
	// =if( ($ratio_w < 1 && $ratio_h > 1) || ($ratio_w >1 && $ratio_h <1) )
	else {
		$ratio = $ratio_h > $ratio_w ? $ratio_h : $ratio_w; //取比例大的那个值
		// 定义一个中间的大图像，该图像的高或宽和目标图像相等，然后对原图放大
		$inter_w = ( int ) ($w * $ratio);
		$inter_h = ( int ) ($h * $ratio);
		$inter_img = imagecreatetruecolor ( $inter_w, $inter_h );
		//将原图缩放比例后裁剪
		imagecopyresampled ( $inter_img, $src_img, 0, 0, 0, 0, $inter_w, $inter_h, $w, $h );
		// 定义一个新的图像
		$new_img = imagecreatetruecolor ( $new_width, $new_height );
		imagecopy ( $new_img, $inter_img, 0, 0, 0, 0, $new_width, $new_height );
		switch ($type) {
			case IMAGETYPE_JPEG :
				imagejpeg ( $new_img, $dst_file, 100 ); // 存储图像
				break;
			case IMAGETYPE_PNG :
				imagepng ( $new_img, $dst_file, 100 );
				break;
			case IMAGETYPE_GIF :
				imagegif ( $new_img, $dst_file, 100 );
				break;
			default :
				break;
		}
	} // if3
}// end function

function get_additional_images($products_id){
	global $db;
	$array = $db->getAll("select image from products_additional_images where products_id = '$products_id' and is_main = 0 order by sort_order ASC");
	$image_array = array();
	foreach($array as $key=>$v){
		$image_array[] = 'images/'.$v['image'];
	
	}
	return $image_array;
}
function get_additional_products_images($products_id){
    global $db;
    $array = $db->getAll("select additional_images_id,image,is_max_size from products_additional_images where products_id = '$products_id' order by is_main DESC,sort_order ASC");
    $image_array = array();
    foreach($array as $key=>$v){
        $image_array[] = array(
            'img_path' => 'images/'.$v['image'],
            'additional_images_id' => $v['additional_images_id'],
            'is_max_size' => $v['is_max_size']
        );
    }
    return $image_array;
}
function get_additional_id($products_id){
	global $db;
	$array = $db->getAll("select additional_images_id from products_additional_images where products_id = '$products_id'  order by sort_order ASC");
	$image_array = array();
	foreach($array as $key=>$v){
		$image_array[] = $v['additional_images_id'];
	}
	return $image_array;
}

//获取缩略图
function get_additional_thumb_img($products_id, $is_main = 0, $size_w = '', $size_h = '', $additional_id = ''){
    $result = get_redis_key_value('thumb_img_'.$products_id.'_'.$size_w,'thumb_img_'.$products_id.'_'.$size_w);
    if(!$result) {
        global $db;
        $sql = '';
        $where = '';
        $sql .= 'select thumb_images from products_additional_thumb_images where products_id = ' . $products_id;
        if (!empty($additional_id)) {
            $where .= ' AND additional_images_id = ' . $additional_id;
        }
        if ($is_main == 0 || $is_main == 1) {
            $where .= ' AND is_main = ' . $is_main;
        }
        if (!empty($size_w) && !empty($size_h)) {
            $where .= ' AND size_w = ' . $size_w . ' AND size_h = ' . $size_h;
        }
        $sql .= $where;
        //$sql .= ' order by sort_order ASC,size_w ASC';
        $result = $db->getAll($sql);
        set_redis_key_value('thumb_img_'.$products_id.'_'.$size_w,$result,7*24*3600,'thumb_img_'.$products_id.'_'.$size_w);
    }

    return $result;
}

//判断远程资源文件
function check_remote_file_exists($url)
{
    $curl = curl_init($url);
    // 不取回数据
    curl_setopt($curl, CURLOPT_NOBODY, true);
    // 发送请求
    $result = curl_exec($curl);
    $found = false;
    // 如果请求没有发送失败
    if ($result !== false) {
        // 再检查http响应码是否为200
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode == 200) {
            $found = true;
        }
    }
    curl_close($curl);

    return $found;
}

/**
 * 获取远程资源文件
 * @param $product_id 当前的产品id
 * @param $size_w img的宽度
 * @param $size_h img的高度
 * @param string $local_img 本地的img路径，兼容处理时使用
 * @param string $alt_val img标签的alt
 * @param string $title_val img标签的title
 * @param string $param img标签内的其他参数
 * @param bool $is_link 返回是否为链接
 * @return string 返回为img标签或img标签链接(根据$is_link来判断)
 * update by quest 2019-05-23
 */
function get_resources_img($product_id, $size_w, $size_h, $local_img = '', $alt_val = '', $title_val = '', $param = '',$is_link = false){

    $size_array = array('60', '80', '120', '180', '550');
    for($i=0; $i<count($size_array); $i++){
        if($size_array[$i] >= $size_w){
            $size_rel_w = $size_array[$i];
            $size_rel_h = $size_array[$i];
            break;
        };
    };

    if(empty($alt)){
        $alt = 'alt="'.$alt_val.'"';
    }
    if(empty($title)){
        $title = 'title="'.$title_val.'"';
        $param .= $title;
    }

    $thumb = get_additional_thumb_img($product_id, 1, $size_rel_w, $size_rel_h);
    if(!empty($thumb)){
        $image_src = 'products/'.$thumb['0']['thumb_images'];

        //如果图片后缀是.webp格式的，并且不支持.webp格式的，则展示原图
        if ((strpos($image_src, '.webp') !== false) && (!is_support_webp())) {
            $image_src = substr($image_src, 0, strrpos($image_src, '.webp'));
        }

        if($is_link){
            $image = HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES .$image_src;
        }else{
            $image = '<img  src="'.HTTPS_PRODUCTS_SERVER.DIR_WS_IMAGES .$image_src.'"'. $alt . $title . ' width="'.$size_w.'" height="'.$size_h.'"'. $param .'>';
        }
    }else {
        if(empty($local_img)){
            $image_src = zen_get_fs_products_image($product_id,$size_w,$size_h);
        }else{
            $image_src = file_exists(DIR_WS_IMAGES . $local_img) ? DIR_WS_IMAGES . $local_img : DIR_WS_IMAGES . 'no_picture.gif';
        }

        //如果图片后缀是.webp格式的，并且不支持.webp格式的，则展示原图
        if ((strpos($image_src, '.webp') !== false) && (!is_support_webp())) {
            $image_src = substr($image_src, 0, strrpos($image_src, '.webp'));
        }

        if($is_link){
            $image = HTTPS_PRODUCTS_SERVER.$image_src;
        }else{
            $pat = '/[a-z]+[-]*[a-z]+[.]{1}[a-z\d\-]+[.]{1}[a-z\d]*[\/]{1}/';
            $img_host = strstr($image_src,'no_picture.gif') ?  'img-en.fs.com/' : 'www.fs.com/';
            $image = zen_image($image_src, $alt_val, $size_w, $size_h, $param);
            $image = preg_replace($pat, $img_host, $image);
        }
    }

    return $image;
}

/**
 * 获取offline quotes 产品图片文件
 * @param $product_id 当前的产品id
 * @param $size_w img的宽度
 * @param $size_h img的高度
 * @param string $alt_val img标签的alt
 * @param string $title_val img标签的title
 * update by Bona.Guo 2021/1/30 11:21
 */
function get_inquiry_img($product_id, $size_w, $size_h,  $alt_val = '', $title_val = '',$param = ''){

    $size_array = array('60', '80', '120', '180', '550');
    for($i=0; $i<count($size_array); $i++){
        if($size_array[$i] >= $size_w){
            $size_rel_w = $size_array[$i];
            $size_rel_h = $size_array[$i];
            break;
        };
    };

    if(empty($alt)){
        $alt = 'alt="'.$alt_val.'"';
    }
    if(empty($title)){
        $title = 'title="'.$title_val.'"';
        $param .= $title;
    }

    $thumb = get_additional_thumb_img($product_id, 1, $size_rel_w, $size_rel_h);

    $image_degault_src = HTTPS_PRODUCTS_SERVER . 'includes/templates/fiberstore/images/logo_trad.jpg';

    if (!empty($thumb)) {

        $image_src = HTTPS_PRODUCTS_SERVER . DIR_WS_IMAGES . 'products/' . $thumb['0']['thumb_images'];
        $image = '<img src="' . $image_src . '" ' . $alt . $title . ' width="' . $size_w . '" height="' . $size_h . '"' . $param . '>';
    } else {
        $image_src = $image_degault_src;
        $image = '<img src="' . $image_src . '" ' . $alt . $title . ' width="' . $size_w . '" height="' . $size_h . '"' . $param . '>';
    }

    return $image;
}

//详情页评论缩略图等比缩放
function zen_products_geo_images($img_src, $width, $height){
    $image_info = getimagesize($img_src);
    list($real_width, $real_height) = $image_info;
    $zen_width = '';
    $zen_height = '';
    if($real_width > $real_height){
        $zen_height = $width;
        $zen_width = $real_width * ($zen_height/$real_height);
        $zen_width = ceil($zen_width);
    }else{
        $zen_width = $height;
        $zen_height = $real_height * ($zen_width/$real_width);
        $zen_height = ceil($zen_height);
    }

    $zen_width = $zen_width%2 == 0 ? $zen_width : ($zen_width + 1);
    $zen_height = $zen_height%2 == 0 ? $zen_height : ($zen_height + 1);

    return array('width' => $zen_width, 'height' => $zen_height);
}

/*
 * 获取产品的所有图片展示，类似产品详情页面坐便套
 * @para int $products_id: 产品id
 * @return array $wartermark_images: 产品图片数组
 * fairy 2018.11.7 add
 */
function get_one_product_all_images($products_id,$products_image){
    global $db;

    $wartermark_images = array();

    if ($products_image == '' && PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
        $products_image = PRODUCTS_IMAGE_NO_IMAGE;
        $original_images = array(HTTPS_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif'); //原始图片数组
    } else {

        require_once(DIR_WS_MODULES . zen_get_module_directory('additional_images'));

        $main_thumb = get_additional_thumb_img($products_id,'1');
        $original_images_one = DIR_WS_IMAGES . 'no_picture.gif'; //是否有图片
        if($main_thumb){ //如果存在主图切割，则从切割表中获取数据
            $original_images = get_additional_products_images($products_id);
            $big_images_string = '';
            if(sizeof($original_images)){
                foreach ($original_images as $i => $img_array) {
                    $img = $img_array['img_path'];
                    $thumb_img = $db->getAll("SELECT thumb_images,is_main FROM `products_additional_thumb_images` WHERE additional_images_id = '{$img_array['additional_images_id']}' AND (size_w ='60' OR size_h = '550') ORDER BY size_w ASC");
                    if(!empty($thumb_img)) {
                        if ($thumb_img['1']['is_main'] == 1) {
                            $original_images_one = HTTPS_PRODUCTS_SERVER . 'images/products_cache/' . $thumb_img['1']['thumb_images'];
                        }
                        $wartermark_images['big'][$i] = HTTPS_PRODUCTS_SERVER . 'images/products_cache/' . $thumb_img['1']['thumb_images'];
                        $wartermark_images['small'][$i] = HTTPS_PRODUCTS_SERVER . 'images/products/' . $thumb_img['0']['thumb_images'];
                        $big_images_string .= 'images/products_cache/' . $thumb_img['1']['thumb_images'].',';
                    }elseif (strpos($img, '.')) {

                        //本地的图片不存在 通过本非获取图片生成缩略图 没有意义 暂时删除 用no_picture  YOYO 2019.8.30
                        $wartermark_images['big'][$i] = HTTPS_IMAGE_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif';
                        $wartermark_images['small'][$i] = HTTPS_IMAGE_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif';
                    }
                }

            }else{
                $original_images = array(HTTPS_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif');
            }
        }else{
            //本地的图片不存在  原来的判断没有意义 暂时删除  没有切割图 就用no_picture  YOYO 2019.8.30
            $original_images = array(HTTPS_IMAGE_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif');
            $original_images_one = HTTPS_IMAGE_SERVER.DIR_WS_IMAGES . 'no_picture.gif';
        }

    }

    //生成水印图
    if(!empty($big_images_string)) {
        $big_images_string = trim($big_images_string, ',');
        create_cdn_watermark_images($big_images_string);
    }

    // 获取视频的图片 或者 没有图片时候展示的图片
    $products_final_image_to_display = count($wartermark_images) ? $wartermark_images['small'][0]:HTTPS_SERVER.'/'.DIR_WS_IMAGES . 'no_picture.gif';

    return array(
        'wartermark_images' => $wartermark_images,
        'products_final_image_to_display' => $products_final_image_to_display,
        'original_images_one' => $original_images_one, // 暂时没有用到
    );
}


//删除ftp的图片
function del_ftp_images($file_src){
    //1.链接ftp
    $ftp_server = RESOURCES_FTP_IP;
    $ftp_user = RESOURCES_FTP_USERNAME;
    $ftp_pass = RESOURCES_FTP_PASSWORD;
    $conn_id = ftp_connect($ftp_server);
    $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
    if ((!$conn_id) || (!$login_result)) {
       return false;
    } else {
//            echo "连接服务器成功";
    }
    ftp_pasv($conn_id, TRUE);   //被动传输模式
    //删除
    if(!ftp_delete($conn_id,$file_src)) {
        return false;
    }else{
        return true;
    }
    ftp_close($conn_id);
}

function resource_exit_or_not($resoure_src){
   $src = file_get_contents(HTTPS_IMAGE_SERVER.$resoure_src);
   if(!empty($src)){
       return true;
   }else{
       return false;
   }

}


function zen_change_url ($src){
    $src_arr  = explode('/',$src);
	$last_element = end($src_arr);
    if(preg_match("/^(http|https)/",$src_arr[0]) || empty($src_arr[0])){
        if(preg_match("/(www.fs.com|img-en.fs.com|static.whgxwl.com:6060)/", $src_arr[2])){
            unset( $src_arr[1]);
            unset( $src_arr[2]);
			if (in_array(substr($last_element, strrpos($last_element, '.') + 1), array("css", "js"))) {
				//css和js文件要把域名后的个小语种站点的code也去掉
				$site_arr = $GLOBALS['fs_all_site'];
				if(in_array(trim($src_arr[3]), $site_arr)){
					unset($src_arr[3]);
				}
				if(trim($src_arr[4])=='en'){
					//德英站的de/en后面的en也要去掉
					unset($src_arr[4]);
				}
			}
        }
        unset( $src_arr[0]);
    }
    $real_src = implode('/',$src_arr);
   return $real_src;
}

function zen_get_img_change_src($src){
	if($src){
		$src = zen_change_url($src);
        if(STATIC_RESOURCE_UP){
            $src = HTTPS_IMAGE_SERVER.$src;
        }
	}
	return $src;
}

/**
 * 获取一级分类页图片结构
 * @param $img_info 当前的产品id或图片路径
 * @param $img_title 当前的产品id或图片路径
 * @param $size_w img的宽度
 * @param $size_h img的高度
 * @return string 返回为img标签或img标签链接(根据$is_link来判断)
 * add by Jeremy 2019-07-27
 */
function get_img_of_index_category($img_info,$img_title,$size_w = '150',$size_h = '150',$is_link = false){
    if(is_numeric($img_info)){
        $wp_image = zen_get_products_image_of_products_id($img_info);
        $product_name = zen_get_products_name($img_info);
        $image = get_resources_img($img_info,$size_w,$size_h,$wp_image,$product_name,$product_name,'',$is_link);
    }else{
        if($is_link){
            $image = HTTPS_IMAGE_SERVER.$img_info;
        }else{
            $image = '<img src="'.HTTPS_IMAGE_SERVER.$img_info.'" alt="'.$img_title.'" title="'.$img_title.'" style="width:'.$size_w.'px;height:'.$size_h.'px;">';
        }
    }
    return $image;
}


/**
 * 产品详情页download版块图标链接临时替换为对应样式class
 * @param $img_basename 图片路径的basename
 * @return string 样式class
*/
function changeImageToIconClass($img_basename){
    switch ($img_basename){
        case '20200401152623_775.png':
            return 'type_one';
        case '20200401153323_500.png':
            return 'type_two';
        case '20200401153422_925.png':
            return 'type_three';
        case '20200401152945_660.png':
            return 'type_four';
        case '20200401152730_409.png':
            return 'type_five';
        case '20200401152834_730.png':
            return 'type_nine';
        default:
            return $img_basename;
            break;
    }
}

function is_support_webp()
{
    $webp = strpos($_SERVER['HTTP_ACCEPT'], 'image/webp');

    if ($webp === false) {
        return false;
    } else {
        return true;
    }
}

function is_show_mts()
{
    //Armenia, Azerbaijan, Moldova, Kazakhstan, Kyrgyzstan, Tajikistan, Uzbekistan, Russia
    if(in_array($_SESSION['countries_iso_code'],['ru','am','az','kz','kg','md','tj','uz'])){
        return true;
    }else{
        return false;
    }
}

