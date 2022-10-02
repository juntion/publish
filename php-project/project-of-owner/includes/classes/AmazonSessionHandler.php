<?php
/**
 * Created by PhpStorm.
 * User: yaowei
 * Date: 2018/11/15
 * Time: 下午9:22
 */
define(AMAZON_ENDPOINT, 'https://doc-fs-online-prodcuts-bcm6sin4ve2v47t7w33t2aluuu.us-west-2.cloudsearch.amazonaws.com');
if (PHP_VERSION >= 5.5) { // 使用亚马逊3版本
    $amazon_core_file = DIR_WS_CLASSES."aws/3.52.20/aws-autoloader.php"; // 调用英文站的
} else { // 使用亚马逊2版本
    $amazon_core_file = DIR_WS_CLASSES."aws/2.8.31/aws-autoloader.php";
}
require_once $amazon_core_file;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\SessionHandler;

class AmazonSessionHandler
{
    private static $_instance = null;
    private static $credentials = array(
        'key' => AMAZON_KEY,
        'secret' => AMAZON_SECRET);

    private static $version = 'latest';

    private static $region = 'us-west-2';

    private static $endpoint = AMAZON_ENDPOINT;

    private static $dynamodb;

    private static $sessionHandler;

    /**
     * AmazonSessionHandler constructor.
     */
    private function __construct()
    {

        self::$dynamodb = DynamoDbClient::factory(
            array(
                'region' => self::$region,
                'version' => self::$version,
                'credentials' => self::$credentials
            )
        );
        self::$sessionHandler = SessionHandler::fromClient(self::$dynamodb, [
            'table_name' => 'sessions',
            'hash_key' => 'id',
            'session_lifetime' => 1800,
            'batch_config' => [
                'batch_size' => 25,
            ]
        ]);
    }

    /**
     * init Class
     * @return AmazonSessionHandler|null
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * seesion 入dynamodb
     */
    public static function initSession()
    {

        self::$sessionHandler->register();
    }

    /**
     * session 回收
     */
    public static function garbageCollect()
    {
        self::$sessionHandler->garbageCollect();
    }
}