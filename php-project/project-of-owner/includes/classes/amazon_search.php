<?php
/*
 * 大概流程
 * 注册亚马逊账号，填写域名、索引项目
 * 提交数据亚马逊
 * 配置相应的搜索条件，进行搜索（配置不同的数据类型，就会自动有不同的搜索。例如数据类型为text，自动分词搜索）
 */

// AMAZON_ENDPOINT,在亚马逊2版本的文件中有使用
define(AMAZON_ENDPOINT,'https://doc-fs-online-prodcuts-bcm6sin4ve2v47t7w33t2aluuu.us-west-2.cloudsearch.amazonaws.com');
if(PHP_VERSION>=5.5){ // 使用亚马逊3版本
    $amazon_core_file = "/includes/classes/aws/3.52.20/aws-autoloader.php"; // 调用英文站的
}else{ // 使用亚马逊2版本
    $amazon_core_file = "/includes/classes/aws/2.8.31/aws-autoloader.php";
}
require_once $amazon_core_file;
use Aws\CloudSearchDomain\CloudSearchDomainClient;
//var_dump($amazon_core_file);echo '<br/>';

class AmazonSearch{
    
    private $credentials = array(
            'key'    => AMAZON_KEY,
            'secret' => AMAZON_SECRET);

    private  $version = '2013-01-01';

    private $region  = 'us-west-2';

    private $endpoint = AMAZON_ENDPOINT;

    public $search_client;

    public function __construct()
    {
     $this->search_client =  CloudSearchDomainClient::factory(array(
            'credentials' => $this->credentials,
            'version' => $this->version,
            'region'  => $this->region,
            'endpoint' => $this->endpoint
        ));
    }

    /*
     * 搜索
     * @para $config 搜索的一些配置
     * @return $result 处理结果
     */
    public function search($config){
        $result = $this->search_client->search($config);
        return $result;
    }

    /*
     * 搜索
     * @para $config 搜索的一些配置
     * @return $result 处理结果
     */
    public function suggest($config){
        $result = $this->search_client->suggest($config);
        return $result;
    }

    /*
     * 上传json文件到亚马逊
     * @para $json_content 必须json数据
     * @return $result 处理结果
     */
    public function upload_document($json_content){
        $config = array(
            'documents' => $json_content,
            'contentType' => "application/json",
        );
        $result = $this->search_client->uploadDocuments($config);
        return $result;
    }

}

?>