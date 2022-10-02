<?php


namespace App\Services\Common\Upload;

use App\Services\BaseService;
use GuzzleHttp\Client;
use Upload\Storage\FileSystem;
use Upload\File;
use App\Services\Common\Upload\MineType;
use Upload\Validation\Extension;

/**
 * 上传类
 *
 * @author aron
 * @date 2019.11.11
 * Class UploadService
 * @package App\Services\Common\Upload
 */
class UploadService extends BaseService
{
    private $storage;
    private $uploadInfo;
    public $errors = [];
    private $config;
    private $rootPath;
    private $staticLink;
    private $isUploadHome = false;
    //数据库存储路径
    public $storagePath;
    //文件存储名
    public $fileName;


    public function __construct()
    {
        parent::__construct();
        $this->rootPath = self::trans('DIR_FS_CATALOG') . 'images/';
        $this->staticLink = self::trans("RESOURCES_GO_SERVER");
        $this->config = [
            'savePath' => "",
            'fileSize' => "5M",
            'isChangeName' => true,
            'changeName' => 1,
            'fileExtension' => ['image/png', 'image/gif', 'image/jpg', 'image/bmp', 'image/jpeg']
        ];
    }

    /**
     * 设置上传config
     *
     * @param array $config
     * @return $this
     */
    public function setConfig($config = [])
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }


    /**
     * upload 文件上传
     *
     * @param string $inputFile
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload($inputFile = '')
    {
        $config = $this->config;
        $savePath = $this->rootPath . $config['savePath'];
        $fileExtension = $config['fileExtension'];
        //传入可上传文件的后缀
        if (!empty($config['extension'])) {
            $tanrs = $config['extension'];
        } else {
            $tanrs = array_map(function ($item) {
                return explode('/', $item)[1] ? explode('/', $item)[1] : $item;
            }, $fileExtension);
        }

        $fileSize = $config['fileSize'];

        if (is_dir($savePath) == false) {
            mkdir($savePath, 0777, true);
        }
        $isChangeName = $config['isChangeName'];
        $changeName = $config['changeName'];
        try {
            $storage = new FileSystem($savePath);
            $file = new File($inputFile, $storage);
        } catch (\Exception $e) {
            return false;
        }
        try {
            $file->addValidations(
                [
                    //list http://www.iana.org/assignments/media-types/media-types.xhtml
                    new MineType($fileExtension),

                    //5M (use "B", "K", M", or "G")
                    new Size($fileSize),

                    new Extension($tanrs),
                ]
            );
        } catch (\Exception $e) {
            $bool = $this->validate($file);
            if (!$bool) {
                return false;
            }
        }
        $fileName = $file->getName();
        if ($changeName == 2) {
            $fileName = date('His', time()) . rand(100, 999);
            $file->setName($fileName);
        } else {
            if ($isChangeName) {
                $fileName = uniqid();
                $file->setName($fileName);
            }
        }
        $this->fileName = $fileName . "." . $file->getExtension();
        try {
            $file->upload();
            if ($this->isUploadHome == true) {
                $uploadPath = $config['savePath'];
            } else {
                $uploadPath = "/images/" . $config['savePath'];
            }
            $this->storagePath = $config['savePath'] . "/" . $fileName . "." . $file->getExtension();
            $isUpload = $this->staticImageUpload(
                $config['savePath'],
                $savePath . '/' . $fileName . '.' . $file->getExtension()
            );
            return $isUpload;
        } catch (\Exception $e) {
            $this->errors = $file->getErrors();
            return false;
        }
    }

    /**
     * 批量上传文件
     *
     * @param array $inputFile
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploads($inputFile = [])
    {
        $uploadPath = [];
        $fileInput = [];
        if (!empty($inputFile) && is_array($inputFile)) {
            foreach ($inputFile as $k => $item) {
                foreach ($item as $kk => $v) {
                    $fileInput['createBySystem' . $kk][$k] = $v;
                }
            }
        }
        if (!empty($fileInput)) {
            foreach ($fileInput as $k => $item) {
                if (!empty($item)) {
                    $_FILES[$k] = $item;
                    $bool = $this->upload($k);
                    if ($bool) {
                        $uploadPath[] = [
                            'path' => $this->storagePath,
                            'fileName' => $this->fileName
                        ];
                    }
                }
            }
        }
        return $uploadPath;
    }

    /**
     *  type resp struct {
     * Code    int    //1上传成功   0上传失败
     * Message string //返回信息
     * Path    string //上传成功时的文件地址
     * Status  int    /[表情]tp状态码
     * }
     *
     *
     * Notes: 上传图片到资源服务器
     * Function Name: staticImageUpload
     * User: Aron,YAo
     * Date: 2019\11\11 0004
     * Time: 17:20
     * @param string $uplodThumbdir 设置资源服务器的文件
     * @param string $filename 将要上传到服务器上文件的绝对路径
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function staticImageUpload($uplodThumbdir = "", $filename = "")
    {
        $f = fopen($filename, 'r');
        $is_uploaded_home = $this->isUploadHome;
        if (!$f) {
            fclose($f);
            $errorMsg = self::trans('FAIL_TO_OPEN_SOURCE');
            array_push($this->errors, $errorMsg);
            return false;
        }
        fclose($f);
        if ($is_uploaded_home == true) {
            $folder_path = '/' . $uplodThumbdir;
        } else {
            $folder_path = '/images/' . $uplodThumbdir;
        }
        $post_data = [
            'multipart' => [
                [
                    "contents" => fopen($filename, 'r'),
                    "name" => 'file'
                ],
                [
                    'name' => 'path',
                    'contents' => $folder_path
                ]
            ]
        ];
        $client = new Client();
        $uri = $this->staticLink;
        try {
            $response = $client->post($uri, $post_data);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);
            if ($res['Code'] == 0) {
                array_push($this->errors, $this->errMsg($res['Message']));
                return false;
            }
            return true;
        } catch (\Exception $e) {
            array_push($this->errors, self::trans('FS_UPLOAD_NEW_ERROR_3'));
            return false;
        }
    }

    /**
     * 返回错误信息
     *
     * @param int $code
     * @return mixed|string
     */
    private function errMsg($code = 0)
    {
        $uploadClassError = array(
            0 => 'There is no error, the file uploaded with success.',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.  ',
            3 => 'The uploaded file was only partially uploaded. ',
            4 => 'No file was uploaded. ',
            6 => 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3. ',
            7 => 'Failed to write file to disk. Introduced in PHP 5.1.0. ',
            10 => 'Input name is not unavailable!',
            11 => self::trans('FS_UPLOAD_NEW_ERROR_1'),
            12 => 'Directory unwritable!',
            13 => self::trans('FS_UPLOAD_NEW_ERROR_2'),
            14 => self::trans('ACCOUNT_EDIT_HEADER_FILE'),
            15 => 'Delete file unsuccessfully!',
            //ftp上传相关
            16 => self::trans(' FAIL_TO_CONNECT_FTP'),  //服务器连接失败
            17 => self::trans('FAIL_TO_OPEN_SOURCE'), //打开资源失败
            18 => self::trans('FS_UPLOAD_NEW_ERROR_3'),
        );
        return $uploadClassError[$code] ? $uploadClassError[$code] : '';
    }


    /**
     * 获取上传错误
     *
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * 检验上传文件
     *
     * @param File $file
     * @return bool
     */
    public function validate(File $file)
    {
        $size = $this->checkSize($file);
        $type = $this->checkType($file);
        if (!$size || !$type) {
            return false;
        }
        return true;
    }


    public function checkSize(File $file)
    {
        $size = $file->getSize();
        $maxSize = File::humanReadableToBytes($this->config['fileSize']);
        if ($size > $maxSize) {
            array_push($this->errors, self::trans("FS_UPLOAD_NEW_NOTICE_FOUR"));
            return false;
        }
        return true;
    }

    public function checkType(File $file)
    {
        $fileExtension = $this->config['fileExtension'];
        $type = $this->getMineType($file);
        if (!in_array($type, $fileExtension)) {
            array_push($this->errors, self::trans("FS_UPLOAD_NEW_ERROR_1"));
            return false;
        }
        return true;
    }

    public function getMineType(File $file)
    {
        $fp = fopen($file->getRealPath(), "rb");
        $bin = fread($fp, 2); //只读2字节
        fclose($fp);
        $str_info = @unpack("C2chars", $bin);
        $type_code = intval($str_info['chars1'] . $str_info['chars2']);

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
        return MineType::getMimeType($file_type);
    }

    /**
     * Notes:得到需要保存的路径
     * User: LiYi
     * Date: 2020/5/27 0027
     * Time: 14:13
     * @return string
     */
    public function getSavePath()
    {
        return $this->rootPath . $this->config['savePath'];
    }

    /**
     * Notes:只验证后缀
     * User: LiYi
     * Date: 2020/6/9 0009
     * Time: 17:32
     * @param $ext
     * @return bool
     */
    private function validateExtension($ext)
    {
        if (!in_array(strtolower($ext), $this->config['fileExtension'])) {
            array_push($this->errors, self::trans("FS_UPLOAD_NEW_ERROR_1"));
            return false;
        }

        return true;
    }

    /**
     * Notes:俄罗斯对公支付添加
     * User: LiYi
     * Date: 2020/6/9 0009
     * Time: 17:36
     * @param File $file
     * @return bool
     */
    public function newValidate(File $file)
    {
        $size = $this->checkSize($file);
        $type = $this->validateExtension($file->getExtension());
        if (!$size || !$type) {
            return false;
        }
        return true;
    }

    public function newUpload($inputFile, $overwrite = false)
    {
        $config = $this->config;
        $savePath = $this->rootPath . $config['savePath'];

        if (is_dir($savePath) == false) {
            mkdir($savePath, 0777, true);
        }

        try {
            $storage = new FileSystem($savePath, $overwrite);
            $file = new File($inputFile, $storage);
        } catch (\Exception $e) {
            return false;
        }
        try {
            $res = $this->newValidate($file);
            if (!$res) {
                throw new \Exception(self::trans("FS_UPLOAD_NEW_ERROR_1"));
            }
        } catch (\Exception $e) {
            $bool = $this->validate($file);
            if (!$bool) {
                return false;
            }
        }
        //防止中文文件名截取失败 pathinfo()函数问题
        if ($overwrite) {
            $fileName = str_replace('.' . $file->getExtension(), '', $_FILES[$inputFile]['name']);
            $vowels = ["!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "+", "=", ";", ":", "'", "\"", ",",
                ".", "<", ">", "?", "/", "{", "}", "[", "]", "|", "\\", "~", "`", "；", "：", "“", "”", " ", "《", "》",
                "。", "？", "【", "】", "！", "￥", "…", "（", "）", "，"];
            $fileName = str_replace($vowels, '', $fileName);
            $file->setName($fileName);
        } else {
            $fileName = date('H-i-s') . '-' . uniqid();
            $file->setName($fileName);
        }

        $this->fileName = $fileName . "." . $file->getExtension();

        try {
            $res = $file->upload();

            if (!$res) {
                throw new \Exception(' error !');
            }
            $this->storagePath = $config['savePath'] . "/" . $fileName . "." . $file->getExtension();
            $isUpload = $this->staticImageUpload(
                $config['savePath'],
                $savePath . '/' . $fileName . '.' . $file->getExtension()
            );

            if (!$isUpload) {
                throw new \Exception(' error !');
            }
            $result = true;
        } catch (\Exception $e) {
            $this->errors = $file->getErrors();
            $result = false;
        }

        return $result;
    }
}
