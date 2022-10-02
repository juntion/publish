<?php

class Uploads
{
    var $saveName;
    var $savePath;
    var $fileFormat = array("gif", "jpg", "doc", "application/octet-stream");// 文件格式&MIME限定
    var $overwrite = 0;
    var $maxSize = 0;
    var $ext; // 文件扩展名
    var $type;// 文件类型
    var $errno;// 错误代号
    var $returnArray = array(); // 所有文件的返回信息
    var $returninfo = array();// 每个文件返回信息
    var $ftp_server = RESOURCES_FTP_IP;
    var $ftp_user = RESOURCES_FTP_USERNAME;
    var $ftp_pass = RESOURCES_FTP_PASSWORD;
    var $is_uploaded_home = false;
    var $use_go = false;


    //构造函数
    // @param savePath 文件保存路径
    // @param fileFormat 文件格式限制数组
    // @param maxSize 文件最大尺寸
    // @param overwriet 是否覆盖 1 允许覆盖 0 禁止覆盖
    //@pparam $is_uploaded_home 默认是false 是否需要上传到后台服务器，只有产品评论相关的为true,需要放在后台切割
    //@param $ftp_server  FTP服务器ip
    //@param $ftp_user  FTP服务器用户名
    //@param $ftp_pass  FTP服务器密码
    //@param $uplode_thumbdir FTP文件夹路径
    //@param $filename FTP文件名
    function Uploads($savePath, $fileFormat = '', $maxSize = 0, $overwrite = 0, $ftp_server = '', $ftp_user = '', $ftp_pass = '', $is_uploaded_home = false)
    {
        // 设置本地的路径为可写的权限
        $localSavePath = DIR_FS_CATALOG . 'images/' . $savePath; //本地的路径，必须是绝对路径。相对路径会报警告错误
        if (is_dir($localSavePath) == false) {
            mkdir($localSavePath, 0777);
        }

        $this->savePath = $savePath;
        $this->setFileformat($fileFormat);
        $this->setMaxsize($maxSize);
        $this->setOverwrite($overwrite);
        $this->errno = 0;
        if (isset($ftp_server) && !empty($ftp_server)) {
            $this->ftp_server = $ftp_server;
        }
        if (isset($ftp_user) && !empty($ftp_user)) {
            $this->ftp_user = $ftp_user;
        }
        if (isset($ftp_pass) && !empty($ftp_pass)) {
            $this->ftp_pass = $ftp_pass;
        }
        if (isset($is_uploaded_home) && $is_uploaded_home != false) {
            $this->is_uploaded_home = true;
        }
    }

    // 上传
    function run($fileInput, $changeName = 1, $use_go = 0)
    {
        $this->use_go = $use_go;
        if (isset($_FILES[$fileInput])) {
            $fileArr = $_FILES[$fileInput];
            if (is_array($fileArr['name'])) {//上传同文件域名称多个文件
                foreach ($fileArr['name'] as $key =>$value) {
                    if ($fileArr['tmp_name'][$key] != '') {
                        $ar['tmp_name'] = $fileArr['tmp_name'][$key];
                        $ar['name'] = $fileArr['name'][$key];
                        $ar['type'] = $fileArr['type'][$key];
                        $ar['size'] = $fileArr['size'][$key];
                        $ar['error'] = $fileArr['error'][$key];
                        $this->type = $fileArr['type'][$key];
                        $ar['size'] = $fileArr['size'][$key];
                        $this->getExtType($ar);
                        $this->setSavename($changeName == 1 ? '' : $ar['name']);
                        if ($this->copyfile($ar)) {
                            $this->returnArray[] = $this->returninfo;
                        } else {
                            $this->returninfo['error'] = $this->errmsg();
                            $this->returnArray[] = $this->returninfo;
                        }
                    }
                }
                return $this->errno ? false : true;
            } else {//上传单个文件
                $this->getExtType($fileArr);//取得扩展名和类型
                $this->setSavename($changeName == 1 ? '' : $fileArr['name']);//设置保存文件名
                if ($this->copyfile($fileArr)) {
                    $this->returnArray[] = $this->returninfo;
                } else {
                    $this->returninfo['error'] = $this->errmsg();
                    $this->returnArray[] = $this->returninfo;
                }
                return $this->errno ? false : true;
            }
            return false;
        } else {
            $this->errno = 10;
            return false;
        }
    }

    // 单个文件上传
    function copyfile($fileArray)
    {
        $this->returninfo = array();
        // 返回信息
        $this->returninfo['name'] = $fileArray['name'];
        $this->returninfo['saveName'] = $this->saveName;
        $this->returninfo['size'] = number_format(($fileArray['size']) / 1024, 0, '.', ' ');//以 B 为单位
        $this->returninfo['type'] = $fileArray['type'];
        // 检查文件格式
        if (!$this->validateFormat()) {
            $this->errno = 11;
            return false;
        }
        // 如果有大小限制，检查文件是否超过限制
        if ($this->maxSize != 0) {
            if ($fileArray["size"] > $this->maxSize) {
                $this->errno = 14;
                return false;
            }
        }

        //创建
        if (is_dir(DIR_WS_IMAGES . $this->savePath) == false) {
            mkdir(DIR_WS_IMAGES . $this->savePath, 0777, true);
        }
//                echo DIR_WS_IMAGES.$this->savePath;
//                var_dump(is_writable(DIR_WS_IMAGES.$this->savePath));
        //检查文件是否可写
        if (!@is_writable(DIR_WS_IMAGES . $this->savePath)) {
            $this->errno = 12;
            return false;
        }

        // 如果不允许覆盖，检查文件是否已经存在
        if ($this->overwrite == 0 && @file_exists(DIR_WS_IMAGES . $this->savePath . '/' . $fileArray['name'])) {
            $this->errno = 13;
            return false;
        }
        //上传到前台服务器
        if (!@copy($fileArray["tmp_name"], DIR_WS_IMAGES . '/' . $this->savePath . '/' . $this->saveName)) {
            $this->errno = $fileArray["error"];
            return false;
        }
        //上传到资源服务器
        if (!$this->is_uploaded_home) {
            if (CLI_UPLOAD_ENABLE === true) {
                $res = $this->image_go_upload($this->savePath, $this->saveName, $this->is_uploaded_home);
//                    $this->img_ftp_upload($this->ftp_server,$this->ftp_user,$this->ftp_pass,$this->savePath,$this->saveName,$this->is_uploaded_home);
                if (!$res) return false;
            } else {
//                        $res = $this->image_go_upload($this->savePath,$this->saveName,$this->is_uploaded_home);
                $this->img_ftp_upload($this->ftp_server, $this->ftp_user, $this->ftp_pass, $this->savePath, $this->saveName, $this->is_uploaded_home);
//                        if (!$res) return false;
            }

        }

        // 删除临时文件
        if (!@$this->del($fileArray["tmp_name"])) {
            return false;
        }
        return true;
    }

    // 文件格式检查
    function validateFormat()
    {
        if (!is_array($this->fileFormat) || in_array(strtolower($this->ext), $this->fileFormat) || in_array(strtolower($this->type), $this->fileFormat)) return true;
        else return false;
    }

    /*
@desc：获取文件真实后缀
@param   name    文件名
@return  suffix  文件后缀
*/
    function getfilesuffix($name)
    {
        $fp = fopen($name, "rb");
        $bin = fread($fp, 2); //只读2字节
        fclose($fp);
        $str_info = @unpack("C2chars", $bin);
        $type_code = intval($str_info['chars1'] . $str_info['chars2']);
        $file_type = '';
        switch ($type_code) {
            case 7790:
                $file_type = 'exe';
                break;
            case 7784:
                $file_type = 'midi';
                break;
            case 8075:
                $file_type = 'zip';  // docx 和 xlsx 都是此格式
                break;
            case 8297:
                $file_type = 'rar';
                break;
            case 255216:
                $file_type = 'jpg';
                break;
            case 7173:
                $file_type = 'gif';
                break;
            case 6677:
                $file_type = 'bmp';
                break;
            case 13780:
                $file_type = 'png';
                break;
            case 3780:
            case 60115:
                $file_type = 'pdf';
                break;
            case 208207:
                $file_type = 'xls';  //doc 和 xls 都是此格式
                break;
            default:
                $file_type = 'unknown';
                break;
        }
        return $file_type;
    }

    //获取文件扩展名
    function getExtType($file)
    {
        $file_type = $this->getfilesuffix($file['tmp_name']);
        $fileNameExt = end(explode(".",$file['name']));
        if (
            ($file_type == "zip" && in_array($fileNameExt,['docx','xlsx','xls'])) ||
            ($file_type == 'unknown' && $fileNameExt == "txt") ||
            ($file_type == 'xls' && in_array($fileNameExt,['doc','xls']))
        ){
            $file_type = $fileNameExt;
        }
        $this->ext = $file_type;
    }

    //设置上传文件的最大字节限制
    // @param $maxSize 文件大小(bytes) 0:表示无限制
    function setMaxsize($maxSize)
    {
        $this->maxSize = $maxSize;
    }
    //设置文件格式限定
    // @param $fileFormat 文件格式数组
    function setFileformat($fileFormat)
    {
        if (is_array($fileFormat)) {
            $this->fileFormat = $fileFormat;
        }
    }

    //设置覆盖模式
    // @param overwrite 覆盖模式 1:允许覆盖 0:禁止覆盖
    function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;
    }


    //设置保存路径
    // @param $savePath 文件保存路径：以 "/" 结尾，若没有 "/"，则补上
    function setSavepath($savePath)
    {
        $this->savePath = substr(str_replace("\\", "/", $savePath), -1) == "/" ? $savePath : $savePath . "/";
        if (!is_dir($this->savePath)) {
            $d = str_replace("\\", "/", $this->savePath);
            $dir_arr = explode("/", $d);
            if (count($dir_arr) > 0) {
                $end_dir = "";
                for ($i = 0; $i < count($dir_arr); $i++) {
                    $end_dir .= $dir_arr[$i] . "/";
                    if (!is_dir($end_dir)) mkdir($end_dir, 0777);
                }
            }
        }
    }

    //设置文件保存名
    // @saveName 保存名，如果为空，则系统自动生成一个随机的文件名
    function setSavename($saveName)
    {
        if ($saveName == '') {
            $name = date('His', time()) . rand(100, 999) . '.' . $this->ext;
        } else {
            $name = $saveName;
        }
        //$this->saveName = $name;
        $this->saveName = str_replace(' ', '-', $name);
    }

    //删除文件
    // @param $fileName 所要删除的文件名
    function del($fileName)
    {
        if (!@unlink($fileName)) {
            $this->errno = 15;
            return false;
        }
        return true;
    }

    // 返回上传文件的信息
    function getInfo()
    {
        return $this->returnArray;
    }

    // 得到错误信息
    function errmsg()
    {
        $uploadClassError = array(
            0 => 'There is no error, the file uploaded with success.',
            1 => FS_UPLOAD_NEW_ERROR_4,
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.  ',
            3 => 'The uploaded file was only partially uploaded. ',
            4 => 'No file was uploaded. ',
            6 => 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3. ',
            7 => 'Failed to write file to disk. Introduced in PHP 5.1.0. ',
            10 => 'Input name is not unavailable!',
            11 => FS_UPLOAD_NEW_ERROR_1,
            12 => 'Directory unwritable!',
            13 => FS_UPLOAD_NEW_ERROR_2,
            14 => ACCOUNT_EDIT_HEADER_FILE,
            15 => 'Delete file unsuccessfully!',
            //ftp上传相关
            16 => FAIL_TO_CONNECT_FTP,  //服务器连接失败
            17 => FAIL_TO_OPEN_SOURCE, //打开资源失败
            18 => FS_UPLOAD_NEW_ERROR_3,
        );

        if ($this->errno == 0){
            return false;
        }else{
            return isset($uploadClassError[$this->errno]) ? $uploadClassError[$this->errno] : $uploadClassError["11"];
        }
    }

    /**
     * @param $ftp_server  FTP服务器ip
     * @param $ftp_user  FTP服务器用户名
     * @param $ftp_pass  FTP服务器密码
     * @param $uplode_thumbdir FTP文件夹路径
     * @param $filename FTP文件名
     */
    function img_ftp_upload($ftp_server, $ftp_user, $ftp_pass, $uplode_thumbdir, $filename, $is_uploaded_home)
    {
        //  var_dump($is_uploaded_home);
        //文件上传到资源服务器
        // set up a connection or die
        $conn_id = ftp_connect($ftp_server);
        $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
        ftp_pasv($conn_id, TRUE);   //被动传输模式

        if ((!$conn_id) || (!$login_result)) {
            $this->errno = 16;
            return false;
        } else {
            //      echo "连接服务器成功".$ftp_server;
        }
        // try to login
        if ($is_uploaded_home == true) {
            $folder_path = '/' . $uplode_thumbdir;
        } else {
            $folder_path = '/images/' . $uplode_thumbdir;
        }
//     $filename = DIR_WS_IMAGES . $savepath . 'tb/' . $tb_res['file_name'];
        $source_file = 'images/' . $uplode_thumbdir . '/' . $filename;
        $destination_file = $folder_path . '/' . $filename; //远程服务器目录
        if (!fopen($source_file, 'r')) {
            $this->errno = 17;
            return false;
        }


        if (!ftp_chdir($conn_id, $folder_path)) {
            //上传到后台服务器的路径
            if ($is_uploaded_home == true) {
                $this->re_resources_mkdir($conn_id, $uplode_thumbdir, '/');
            } else {
                $this->re_resources_mkdir($conn_id, $uplode_thumbdir, '/images');
            }
        }

        $ret = ftp_nb_put($conn_id, $destination_file, $source_file, FTP_BINARY);

        while ($ret == FTP_MOREDATA) {
            // 继续传送...
            $ret = ftp_nb_continue($conn_id);
        }
        if ($ret != FTP_FINISHED) {
            return false;
        }
//        var_dump($ret);

        ftp_quit($conn_id);
        //上传结束

    }

    /**
     * add by rebirth 2019/06/18
     * 切换ftp上传模式为curl上传模式
     *
     * @param $uplode_thumbdir
     * @param $filename
     * @param $is_uploaded_home
     * @return bool
     */
    function image_go_upload($uplode_thumbdir, $filename, $is_uploaded_home)
    {
        $source_file = 'images/' . $uplode_thumbdir . '/' . $filename;
        $f = fopen($source_file, 'r');
        if (!$f) {
            $this->errno = 17;
            fclose($f);
            return false;
        }
        fclose($f);
        if (class_exists("CURLFile")) {
            $path = new CURLFile(realpath($source_file));
        } else {
            $path = "@" . realpath($source_file);
        }

        if ($is_uploaded_home == true) {
            $folder_path = '/' . $uplode_thumbdir;
        } else {
            $folder_path = '/images/' . $uplode_thumbdir;
        }

        $post_data = array(
            "file" => $path,
            "path" => $folder_path,
            "name" => realpath($source_file)
//            "id" => zen_not_null($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0
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
//        if (curl_errno($curl)) {
//            echo 'Errno' . curl_error($curl);//捕抓异常
//        }
        curl_close($curl); // 关闭CURL会话
        if (!$result) {
            error_log(date('Y-m-d H:i:s') . "\n 【ERROR: " . json_encode($post_data) ."----false" . "】\n\n", 3, $inquiry_log_dir);
            $this->errno = 18;
            return false;
        } else {
            $res = json_decode($result);
            error_log(date('Y-m-d H:i:s') . "\n 【ERROR: " . json_encode($post_data) ."----".json_encode($res) . "】\n\n", 3, $inquiry_log_dir);
            if (!$res->Code) {
                $this->errno = $res->Message;
                return false;
            }
            return true;
        }
    }


    /**
     * 递归远程创建文件夹
     * @param $conn_id
     * @param $path
     * @param $domain
     * @return bool
     */
    function re_resources_mkdir($conn_id, $path, $domain)
    {
        $dir = split("/", $path);
        $path = $domain;
        $ret = true;

        for ($i = 0; $i < count($dir); $i++) {
            $path .= '/' . $dir[$i];
            if (!@ftp_chdir($conn_id, $path)) {
                //@ftp_chdir($conn_id,"/");
                if (!@ftp_mkdir($conn_id, $path)) {
                    $ret = false;
                    break;
                } else {
                    ftp_chmod($conn_id, 0777, $path);
                }
            }
        }
        return $ret;
    }
}

?>