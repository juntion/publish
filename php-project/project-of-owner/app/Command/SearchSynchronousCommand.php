<?php
require_once 'CommandBaseRequired.php';

use App\Services\ElasticSearch\ElasticSearch;

$es_s = new ElasticSearch();

//捕获所有异常
while (true) {
    $sy_res = $es_s->SyProductsData();
    if($sy_res){
        time_sleep_until(60 * 60 * 24 + time());//每天执行一次
    }
}