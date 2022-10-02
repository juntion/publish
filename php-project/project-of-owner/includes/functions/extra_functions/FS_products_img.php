<?php

/**
 * 图片重新排序
 * @param $products_id
 */
function rename_img_sort($products_id){

    global $db;

    $fields_array = array('thumb_images','id');
    $data = fs_get_data_from_db_fields_array($fields_array,'products_additional_thumb_images','products_id='.$products_id,'order by is_main DESC,sort_order ASC');

    if(!empty($data)) {
        $res = array(
            '60' => array(),
            '80' => array(),
            '120' => array(),
            '180' => array(),
            '550' => array(),
        );

        foreach ($data as $v) {
            $val = $v[0];
            $id = $v[1];
            $img_path = DIR_FS_CATALOG_IMAGES . 'products/' . $val;

            if (file_exists($img_path)) {
                //获取文件的后缀
                $ext = strtolower(strrchr($img_path, '.'));

                //先重命名为_bak文件
                $name = basename($img_path, $ext);
                $size_path_array = explode('/', $val);
                $size_path = $size_path_array[0];
                $name_bak = DIR_FS_CATALOG_IMAGES . 'products/' . $size_path . '/' . $name . '_bak' . $ext;
                rename($img_path, $name_bak);

                $size_array = explode('x', $val);
                $size = $size_array[0];
                switch ($size) {
                    case 60:
                        $res[60][] = array('img' => $name_bak, 'id' => $id);
                        break;
                    case 80:
                        $res[80][] = array('img' => $name_bak, 'id' => $id);
                        break;
                    case 120:
                        $res[120][] = array('img' => $name_bak, 'id' => $id);
                        break;
                    case 180:
                        $res[180][] = array('img' => $name_bak, 'id' => $id);
                        break;
                    case 550:
                        $res[550][] = array('img' => $name_bak, 'id' => $id);
                        break;
                }
            }
        }

        //将_bak 按规则进行重命名
        foreach ($res as $size => $img_array) {
            foreach ($img_array as $key => $val) {
                $oldname = $val['img'];
                $id = $val['id'];
                if (file_exists($oldname)) {
                    //获取文件的后缀
                    $ext = strtolower(strrchr($oldname, '.'));

                    $alp = 65 + $key;
                    $alp = $alp == 65 ? 'main' : strtoupper(chr($alp));
                    $name = $products_id . '.' . $alp;
                    $newname = DIR_FS_CATALOG_IMAGES . 'products/' . $size . 'x' . $size . '/' . $name . $ext;
                    rename($oldname, $newname);

                    $uplode_thumbdir = 'products/' . $size . 'x' . $size;
                    $filename = $name . $ext;
                    //上传到资源服务器
                    img_ftp_upload(RESOURCES_FTP_IP, RESOURCES_FTP_USERNAME, RESOURCES_FTP_PASSWORD, $uplode_thumbdir, $filename);
                    //上传到国外服务器
                    img_ftp_upload(FOREIGN_FTP_IP, FOREIGN_FTP_USERNAME, FOREIGN_FTP_PASSWORD, $uplode_thumbdir, $filename);
                    //上传到中文站
                    img_ftp_upload(CHAIN_FTP_IP, CHAIN_FTP_USERNAME, CHAIN_FTP_PASSWORD, $uplode_thumbdir, $filename);

                    $newdata = $size . 'x' . $size . '/' . $name . $ext;
                    $query = "UPDATE products_additional_thumb_images SET thumb_images = '$newdata' WHERE id = '$id'";
                    $db->Execute($query);
                }
            }
        }
    }

}

/**
 * @param $origin_img 文件源路径
 * @param $new_name 新的文件名
 */
function rename_img_copy($origin_img, $new_name, $new_folder){

    $img_path = DIR_FS_CATALOG_IMAGES.'products/'.$origin_img;
    if(file_exists($img_path)){
        //获取文件的后缀
        $ext = strtolower(strrchr($img_path, '.'));
        $file_name = $new_name.$ext;
        $uplode_thumbdir = 'products/'.$new_folder;
        $new_path = DIR_FS_CATALOG_IMAGES.$uplode_thumbdir.'/'.$file_name;
        @copy($img_path,$new_path);

        //上传到资源服务器
        img_ftp_upload(RESOURCES_FTP_IP,RESOURCES_FTP_USERNAME,RESOURCES_FTP_PASSWORD, $uplode_thumbdir, $file_name);
        //上传到国外服务器
        img_ftp_upload(FOREIGN_FTP_IP,FOREIGN_FTP_USERNAME,FOREIGN_FTP_PASSWORD, $uplode_thumbdir, $file_name);
        //上传到中文站
        img_ftp_upload(CHAIN_FTP_IP,CHAIN_FTP_USERNAME,CHAIN_FTP_PASSWORD, $uplode_thumbdir, $file_name);

        $file_data = $new_folder.'/'.$file_name;
        return $file_data;
    }

}

/**
 * 生成本地缩略图
 * @param $src_path 源图路径
 * @param $max_w 缩略图长
 * @param $max_h 缩略图宽
 * @param $foldername 缩略图文件夹
 * @param $filename 缩略图名称
 * @return string
 */
function makeThumbImg($src_path,$max_w,$max_h, $foldername, $filename, $imgtype = '')
{
    //获取文件的后缀
    $ext = strtolower(strrchr($src_path, '.'));

    //判断文件格式
    switch($ext)
    {
        case '.jpg':
            $type='jpeg';
            break;
        case '.gif':
            $type='gif';
            break;
        case '.png':
            $type='png';
            break;
        default:
            return false;
    }
    //拼接打开图片的函数
    $open_fn = 'imagecreatefrom'.$type;
    //打开源图
    $src = $open_fn($src_path);
    //源图的宽
    $src_w = imagesx($src);
    //源图的高
    $src_h = imagesy($src);

    if($imgtype == 'review' && $max_w == 100){
        if ($max_w/$max_h < $src_w/$src_h) {
            //横屏图片以宽为标准
            $dst_h = $max_h;
            $dst_w = $max_h * $src_w/$src_h;
        }else{
            //竖屏图片以高为标准
            $dst_w = $max_w;
            $dst_h = $max_w * $src_h/$src_w;
        }
    }else{
        if ($max_w/$max_h < $src_w/$src_h) {
            //横屏图片以宽为标准
            $dst_w = $max_w;
            $dst_h = $max_w * $src_h/$src_w;
        }else{
            //竖屏图片以高为标准
            $dst_h = $max_h;
            $dst_w = $max_h * $src_w/$src_h;
        }
    }

    $dst_w = ceil($dst_w);
    $dst_w = $dst_w%2 == 1 ? $dst_w+1 : $dst_w;

    $dst_h = ceil($dst_h);
    $dst_h = $dst_h%2 == 1 ? $dst_h+1 : $dst_h;

    if($imgtype == 'review'){
        $filename = $filename.'.'.$dst_w.'x'.$dst_h;
    }
    $filename = $filename.$ext;

    if (is_dir(DIR_WS_IMAGES.$foldername) == false) {
        mkdir(DIR_WS_IMAGES.$foldername, 0777, true);
    }
    //缩略图存放路径
    $thumb_path = DIR_WS_IMAGES.$foldername.'/'.$filename;

    //创建目标图
    $dst = @imagecreatetruecolor($dst_w,$dst_h);
    $color = @imagecolorallocate($dst, 255, 255, 255);//背景色填充为白色
    imagefill($dst,0,0,$color);

    //在目标图上显示的位置
    $dst_x = 0;
    $dst_y = 0;

    //生成缩略图
    imagecopyresampled($dst,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$src_w,$src_h);

    if($max_w == '550'){
        $water_path = DIR_WS_IMAGES.'watermark/watermark_550x550.png';
        $water = imagecreatefromstring(file_get_contents($water_path));

        //获取水印图片的宽高
        $waterinfo = @getimagesize($water_path);
        $water_x = (abs($max_w-$waterinfo[0]))/2;
        $water_y = (abs($max_h-$waterinfo[1]))/2;

        imagecopy($dst, $water, $water_x, $water_y, 0, 0, $waterinfo[0], $waterinfo[1]);
    }

    //把缩略图上传到指定的文件夹
    imagejpeg($dst,$thumb_path,95);//设置图片质量0-100

    //销毁图片资源
    imagedestroy($dst);
    imagedestroy($src);

    //返回新的缩略图的文件名
    $res = array(
        'file_name' => $filename,
        'size_w' => $dst_w,
        'size_h' => $dst_h
    );
    return $res;
}


/**
 * 给图片加水印
 * @param $src_path 源图路径
 * @param $foldername 水印图文件夹
 * @param $filename 水印图名称
 * @return bool|string
 */
function addWatermark($src_path, $foldername, $filename)
{
    //获取文件的后缀
    $ext=  strtolower(strrchr($src_path,'.'));
    $filename = $filename.$ext;

    //水印图存放路径
    $thumb_path = DIR_FS_CATALOG_IMAGES.$foldername.'/'.$filename;

    //判断文件格式
    switch($ext)
    {
        case '.jpg':
            $type='jpeg';
            break;
        case '.gif':
            $type='gif';
            break;
        case '.png':
            $type='png';
            break;
        default:
            return false;
    }

    $water_path = DIR_FS_CATALOG_IMAGES.'/watermark/watermark_550x550.png';

    //创建图片的实例
    $dst = imagecreatefromstring(file_get_contents($src_path));
    $water = imagecreatefromstring(file_get_contents($water_path));

    //获取水印图片的宽高
    $waterinfo = @getimagesize($water_path);
    $dstinfo = @getimagesize($src_path);
    $water_x = (abs($dstinfo[0]-$waterinfo[0]))/2;
    $water_y = (abs($dstinfo[1]-$waterinfo[1]))/2;

    imagecopy($dst, $water, $water_x, $water_y, 0, 0, $waterinfo[0], $waterinfo[1]);

    //把水印图上传到指定的文件夹
    imagejpeg($dst,$thumb_path,95);

    imagedestroy($dst);
    imagedestroy($water);

    return $filename;
}


//设置缩略图
function getReviewimgThumbname($prefix = 'fs')
{
    //设置缩略图文件
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    $rand_name = '';
    for ($i = 0; $i < 8; $i++) {
        $rand_name .= $pattern{mt_rand(0, 35)};
    }

    //文件名
    $date = date('YmdHis');
    $year = substr($date, 2, 2);
    return $prefix . $year . $rand_name . $date;
}

/**
 * 生成远程水印图片
 * @param string $images_string 图片路径字符串,用逗号分隔
 * @param string $url 资源服务器地址
 * create by Quest 2019-10-14
 */
function create_cdn_watermark_images($images_string = '', $url = HTTPS_PRODUCTS_SERVER){

    $data_string = json_encode(array('images_ori' => $images_string));
    $url .= 'create_img_watermark_cache.php';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);// 跳过证书检查
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)
    ));
    curl_exec($ch);
    curl_close($ch);

}

/**
 * 切换ftp上传模式为curl上传模式
 *
 * @param $uplode_thumbdir
 * @param $filename
 * @param $folder_path
 * @return bool
 */
function image_curl_go_upload($uplode_thumbdir, $filename, $folder_path)
{
    $source_file = $uplode_thumbdir . '/' . $filename;
    $f = fopen($source_file, 'r');
    if (!$f) {
        fclose($f);
        return false;
    }
    fclose($f);
    if (class_exists("CURLFile")) {
        $path = new CURLFile(realpath($source_file));
    } else {
        $path = "@" . realpath($source_file);
    }

    $post_data = array(
        "file" => $path,
        "path" => $folder_path,
        "name" => realpath($source_file)
    );
    $current_root_dir = str_replace('cache', '', DIR_FS_SQL_CACHE);
    $inquiry_log_dir = $current_root_dir . 'debug/upload.log';

    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, RESOURCES_GO_SERVER); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $result = curl_exec($curl); // 执行操作
    curl_close($curl); // 关闭CURL会话
    if (!$result) {
        error_log(date('Y-m-d H:i:s') . "\n 【ERROR: " . json_encode($post_data) ."----false" . "】\n\n", 3, $inquiry_log_dir);
        return false;
    } else {
        $res = json_decode($result);
        error_log(date('Y-m-d H:i:s') . "\n 【ERROR: " . json_encode($post_data) ."----".json_encode($res) . "】\n\n", 3, $inquiry_log_dir);
        if (!$res->Code) {
            return false;
        }
        return true;
    }
}

?>