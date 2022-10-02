<?php


namespace App\Services\Common\Download;

use App\Services\BaseService;
use Respect\Validation\Exceptions\EachException;

class DownloadService extends BaseService
{
    protected $config; // 配置文件

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $file 下载文件
     * @return bool|mixed|string
     */
    public function packZip($file = [])
    {
        $f_conn = ftp_connect(self::trans('RESOURCES_FTP_IP'));
        // 进行ftp登录，使用给定的ftp登录用户名和密码进行login
        $f_login = ftp_login($f_conn, self::trans('RESOURCES_FTP_USERNAME'), self::trans('RESOURCES_FTP_PASSWORD'));
        $pasv = ftp_pasv($f_conn, true);
        if (!$pasv) {
            return false;
        }
        $path = 'mux/' . $file['products_instock_id'] . '/' . $file['products_id'] . '/test_report.zip';
        $zip_path = 'mux/' . $file['products_instock_id'] . '/' . $file['products_id'];
        unset($file['products_instock_id']);
        unset($file['products_id']);
        if (ftp_size($f_conn, $path) > 0) {
            return $path;
        } else {
            // 触发脚本打包
            $mux_zip = $this->zipProcess($zip_path, $file);
            return $mux_zip;
        }
    }

    /**
     * @param $path 存储路径
     * @param $file 存储文件 array
     * @return mixed
     */
    public function zipProcess($path, $file)
    {
        $data_string = json_encode(array('path' => $path, 'file' => $file));
        $url = self::trans('HTTPS_IMAGE_SERVER') . 'mux_zip.php';
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $res = curl_exec($curl); // 执行操作
        return json_decode($res, true);
    }
}
