<?php
// 清除缓存
class delcache
{
    // id 在首页管理中用到，当时还没有languages_code
    // 等后期de、dn融合进来，在进行整理
    public $all_sites = array(
        'en' => '1',
        'es' => '2',
        'fr' => '3',
        'ru' => '4',
        'de' => '5',
        'jp' => '8',
        'uk' => '9',
        'au' => '10',
        'mx' => '12',
        'dn' => '11',
        'sg' => '13',
        'it' => '14',
        'en_only' => '1',
        'es_only' => '2',
        'uk_only' => '9',
        'all' => '99',
    );

    //所有的服务器
    public $all_host = array();

    public function __construct()
    {
        $this->power_all_sites_codes = array(); //有权限操作的
        $this->all_sites_codes = array(); //所有的网站
        foreach ($this->all_sites as $key => $val){
            $this->power_all_sites_codes[] = $key;
            if($val!='en_only' && $val!='es_only' && $val!='uk_only' && $val!='all'){
                $this->all_sites_codes[] = $key;
            }
        }
        if($_SERVER['SERVER_NAME']=="www.fs.com"){
            $this->all_host = ['http://ec2-35-167-240-19.us-west-2.compute.amazonaws.com','http://ec2-34-221-155-230.us-west-2.compute.amazonaws.com','http://ec2-52-88-166-186.us-west-2.compute.amazonaws.com'];
        }else{
            $this->all_host = [HTTPS_SERVER];
        }
    }

    /*
     * 清除某个网站的某个块的文件缓存
     * $site：languages_code，每个网站都是唯一的
     * $part：清除缓存的文件夹
     * $db_similar_part：不同语种的相似数据，数据库保存方式，和哪个类似。
     */
    public function get_part_file_dir($part,$site=''){
        switch ($part){
            case 'quickFinder': //所有网站使用的共用QF
                $dir = DIR_WS_MODULES.'quickFinder/';
                break;
        }
        return $dir;
    }

    /*
     * 清除某个网站的某个块的文件缓存
     * @para string $site：languages_code，每个网站都是唯一的
     * @para string $part：清除缓存的文件夹
     * @para string $other_file_para：如果是清楚文件，要填写这个
     * @param string $full_path: 有完整的路径 则直接调取不需要拼接
     */
    public function del_one_site_file_cache($site,$part='products',$other_file_para='',$full_path=''){
        $is_file = false;
        if($full_path){
            $file = $full_path;
        }else{
            $file = '/cache/'.$part.'/'.$site.'/'.$other_file_para;
        }
        $absolute_file = DIR_FS_CATALOG.$file;
        if(($other_file_para && strpos($other_file_para,'.')) || strpos($full_path,'.')){ //如果是文件
//             @unlink($absolute_file);  //本地删除
            $is_file = true;
        }else{
//             delCache($absolute_file,1);//本地删除
        }
        $this->del_cache($file,$is_file);
        /*foreach($this->all_host as $host){
            $result = $this->doCurlPostRequest($host.'/delcache.html?action=clear_by_curl',[
                'file' => $file,
                'is_file' => $is_file,
                'type' =>'clear_file'
            ]);
        }*/
    }

    public function del_cache($file,$is_file){
        $file = DIR_FS_CATALOG.$file;
        if($is_file){ //如果是文件
            @unlink($file);
        }else{
            delCache($file,1);
        }
    }


    /**
     * @desc 封装 curl 的调用接口，post的请求方式
     * @para string $url：网址
     * @para array $requestString：post请求参数
     * @para int $timeout：过期时间
     * @return
     **/
    public function doCurlPostRequest($url,$requestArray,$timeout = 5){
        if($url == '' || $requestArray == '' || $timeout <=0){
            return false;
        }

        if (is_array($requestArray)){
            $requestString = http_build_query($requestArray, null, '&');
        }

        $con = curl_init((string)$url);
        curl_setopt($con, CURLOPT_HEADER, true);  // 不返回HTTP头部信息。
        $header = ['User-Agent:fs.com'];
        curl_setopt($con, CURLOPT_HTTPHEADER, $header);
        curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
        curl_setopt($con, CURLOPT_POST,true);
        curl_setopt($con, CURLOPT_RETURNTRANSFER,true); //设置为1表示稍后执行的curl_exec函数的返回是URL的返回字符串，而不是把返回字符串定向到标准输出并返回TRUE；
        curl_setopt($con, CURLOPT_TIMEOUT,(int)$timeout);
        return curl_exec($con);
    }

    /*
     * 清除文件缓存
     * @para $site：languages_code，每个网站都是唯一的
     * @para $part：清除缓存的文件夹
     * @para $db_similar_part：不同语种的相似数据，数据库保存方式，和哪个类似。
     * @para $other_file_para：别的文件参数
     * @return 清楚缓存的是哪些网站
     */
    public function clear_file_cache($site,$part='products',$db_similar_part='products',$other_file_para=''){
        if($site == 'all'){ //清除 全部语种 缓存
            foreach ($this->all_sites_codes as $key => $val){
                $this->del_one_site_file_cache($val,$part,$other_file_para);
            }
            return 'all';
        }elseif($site == 'en'){ //清楚
            if($db_similar_part == 'index'){ // 类似于首页 index 所有英语数据使用的是同一个
                $this->del_one_site_file_cache('en',$part,$other_file_para);
                $this->del_one_site_file_cache('au',$part,$other_file_para);
                $this->del_one_site_file_cache('uk',$part,$other_file_para);
                $this->del_one_site_file_cache('sg',$part,$other_file_para);
                $this->del_one_site_file_cache('dn',$part,$other_file_para);
                return 'en、dn、au、uk、sg';
            }else{ // 类似于产品， en、dn、sg 用于数据
                $this->del_one_site_file_cache('en',$part,$other_file_para);
                $this->del_one_site_file_cache('sg',$part,$other_file_para);
                $this->del_one_site_file_cache('dn',$part,$other_file_para);
                return 'en、dn、sg';
            }
        }elseif($site == 'uk'){ // uk、au
            $this->del_one_site_file_cache('uk',$part,$other_file_para);
            $this->del_one_site_file_cache('au',$part,$other_file_para);
        }elseif($site == 'es'){ // es、mx
            $this->del_one_site_file_cache('es',$part,$other_file_para);
            $this->del_one_site_file_cache('mx',$part,$other_file_para);
            return 'es、mx';
        }elseif ($site == 'it'){
            $this->del_one_site_file_cache('it',$part,$other_file_para);
            return 'it';
        }
        else{ // 清楚 单个网站的 缓存
            if($site == 'en_only'){
                $site = 'en';
            }elseif ($site == 'uk_only'){
                $site = 'uk';
            }elseif ($site == 'es_only'){
                $site = 'es';
            }
            $this->del_one_site_file_cache($site,$part,$other_file_para);
            return $site;
        }
    }

    /*
     * 清除redis缓存
     * @para $site：languages_code，每个网站都是唯一的
     * @para $part：清除哪个地方的缓存
     * @para $base_what：依据什么
     * @para $base_data：依据的数据
     * @param $is_common redis缓存是所有站点公用还是各自独立，默认为0各自独立，1是公用
     * @return 清楚缓存的是哪些网站
     */
    public function clear_redis_cache($site,$part,$products_id='',$cPath='',$is_all='',$tip='',$is_common=0){
        $site_id = $this->all_sites[$site];

        $old_part = $part;
        if($products_id){ //删除产品
            $cPath_array_str = get_products_categories_str($products_id);
            $part = $part.'_'.$cPath_array_str.'_'.$products_id;
            $middle_tip = '产品id：'.$products_id;
        }elseif ($cPath){ //删除某个分类的
            if(is_array($cPath)){
                $cPath = implode('_',$cPath);
            }
            $part = $part.'_'.$cPath;
            $middle_tip = '分类：'.$cPath;
        }elseif($is_all){
            $part = $part;
            $middle_tip = '全部';
        }

        if(in_array($part,['index_products','footer_data'])){
            // 首页的产品部分，每个站点（除了es、mx）都是单独管理的
            if($site=='all') {
                foreach ($this->all_sites as $key => $val){
                    if($val){
                        remove_redis_by_prefix($val.'_'.$part);
                    }
                }
                return 'all';
            }elseif ($site == 'es'){
                remove_redis_by_prefix('2_'.$part);
                remove_redis_by_prefix('12_'.$part);
                return 'es、mx';
            }else{
                if($site == 'en_only'){
                    $site_id = '1';
                }elseif ($site == 'uk_only'){
                    $site_id = '9';
                }elseif ($site == 'es_only'){
                    $site_id = '2';
                }elseif ($site == 'en'){
                    foreach ([1,9,10,11,13] as $key => $val){
                        if($val){
                            remove_redis_by_prefix($val.'_'.$part);
                        }
                    }
                    return $site;
                }
                remove_redis_by_prefix($site_id.'_'.$part);
                return $site;
            }
        }else{
            if($is_common==1){
                //各站点公用redis缓存不需要加上站点标识
                remove_redis_by_prefix($part);
            }else{
                if($site == 'all' || ($site == 'en' && ($old_part == 'reviews' || $old_part == 'product_related_attribute' || $old_part == 'product_all' || $old_part == 'reviewsData_product_info' || $old_part == 'product_match'))) { //全部
                    foreach ($this->all_sites_codes as $key => $val){
                        remove_redis_by_prefix($val.'_'.$part);
                    }
                    $site = 'all';
                }elseif($site == 'en') {
                    remove_redis_by_prefix('en_'.$part);
                    remove_redis_by_prefix('sg_'.$part);
                    $site = 'en、dn、sg';
                }elseif ($site == 'es'){
                    remove_redis_by_prefix('es_'.$part);
                    remove_redis_by_prefix('mx_'.$part);
                    $site = 'es、mx';
                }elseif ($site == 'uk'){
                    remove_redis_by_prefix('uk_'.$part);
                    remove_redis_by_prefix('au_'.$part);
                    $site = 'uk、au';
                }else{
                    if($site == 'en_only'){
                        $site = 'en';
                    }elseif ($site == 'uk_only'){
                        $site = 'uk';
                    }elseif ($site == 'es_only'){
                        $site == 'es';
                    }
                    remove_redis_by_prefix($site.'_'.$part);
                }
            }
            if($tip){
                $str = '清空【'.$site.'】【'.$middle_tip.'】【'.$tip.'】';
            }else{
                $str = $site;
            }
            return  $str;
        }
    }

    /*
     * 设置目录可写的权限
     * @para $dir：目录
     */
    private function add_dir_power($dir){
        if(!is_dir($dir)){
            mkdir($dir);
        }
        chmod($dir,0777);
    }

    /*
     * 设置一个网站，所有缓存文件可写的权限
     * @para $site：languages_code，每个网站都是唯一的
     */
    public function set_cache_dir_power($site,$is_reset_dir = 0){
        if($site == 'all' || $site == 'en_all' || $site == 'es_all' || $site == 'uk_all'){
            return false;
        }
        $fs_catalog = DIR_FS_CATALOG;
        $products_dir = $fs_catalog.'cache/products/';
        $this->add_dir_power($products_dir);
        if($is_reset_dir){
            delCache($products_dir, 1);
        }
        $this->add_dir_power($products_dir.$site.'/');

        $products_attributes_dir = $fs_catalog.'cache/products_attributes/'; //新增的
        $this->add_dir_power($products_attributes_dir);
        if($is_reset_dir){
            delCache($products_attributes_dir, 1);
        }
        $this->add_dir_power($products_attributes_dir.$site.'/');

        $product_list_dir = $fs_catalog.'cache/category_narrow/'; //新增的
        $this->add_dir_power($product_list_dir);
        if($is_reset_dir){
            delCache($product_list_dir, 1);
        }
        $this->add_dir_power($product_list_dir.$site.'/');

        $index_dir = $fs_catalog.'cache/index/';
        $this->add_dir_power($index_dir);
        if($is_reset_dir){
            delCache($index_dir, 1);
        }
        $this->add_dir_power($index_dir.$site.'/');

        $htmls_dir = $fs_catalog.'cache/htmls/';
        $this->add_dir_power($htmls_dir);
        if($is_reset_dir){
            delCache($htmls_dir, 1);
        }
        $this->add_dir_power($htmls_dir.$site.'/');
    }

    /**
     * 往指定文件中写入内容
     * @param $document string 目录路径 根目录开始 eg: cache/index
     * @param $file string  文件名
     * @param $content string 往文件中写入的内容
     */
    public function add_file_content($document, $file, $content){
        /*$param = [
            'file' => $file,
            'document' => $document,
            'content' => $content,
            'type' =>'add'
        ];
        foreach($this->all_host as $host){
            $result = $this->doCurlPostRequest($host.'/delcache.html?action=clear_by_curl',$param);
        }*/
        if($document && $file){
            $document = trim($document);
            $document = trim($document,'/');    //去掉目录首尾的/自行评接
            $path = DIR_FS_CATALOG.$document.'/';
            if(is_dir($path) == false){
                mkdir($path, '0777', true);
                chmod($path, 0777);
            }
            file_put_contents($path.'/'.$file,$content);
        }
    }

    /**
     * 清理多台服务器redis 缓存 该方法是临时添加 后面等多台服务器公用一个redis服务器的时候 可以去掉该方法，直接调用clear_redis_cache()
     */
    public function clear_all_host_redis_cache($site,$part,$products_id='',$cPath='',$is_all='',$tip='',$is_common=0){
        $param = [
            'type' =>'clear_redis',
            'site' => $site,
            'part' => $part,
            'products_id' => $products_id,
            'cPath' => $cPath,
            'is_all' => $is_all,
            'tip' => $tip,
            'is_common' => $is_common
        ];
        $this->clear_redis_cache($site,$part,$products_id,$cPath,$is_all,$tip,$is_common);
        /*foreach($this->all_host as $host){
            $result = $this->doCurlPostRequest($host.'/delcache.html?action=clear_by_curl',$param);
        }*/
    }

}