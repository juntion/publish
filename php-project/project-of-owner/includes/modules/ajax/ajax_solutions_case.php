<?php
/**
 * @note:旨在处理solution模块内容接口文件
 * @author:paul
 * @time:2020/6/18
 */

use App\Services\Solution\SolutionServices;
use App\Services\Common\ApiResponse;

$action = $_GET['ajax_request_action'];
$solution = new SolutionServices();
$api = new ApiResponse();
$solution_id = $_POST['solution_id'];

switch ($action){
    case 'solution_attr_change':
        $sku_str = $_POST['sku'];
        $channel_num = $_POST['channel_num'];
        $is_oeo = $_POST['is_oeo'];
        $products = $solution->getSolutionProducts(
            $solution_id,
            $sku_str,
            $channel_num,
            $is_oeo
        );
        $api->setMessage()->setStatus(200)->response($products);
        break;
    case 'solution_brand_jumper_change':
        $site_body = $_POST['sitebody'];
        $solution_id = $_POST['solutionid'];
        $sku_str = $_POST['sku'];
        $products = $solution->getSolutionBrandsProducts($site_body, $sku_str);
        $api->setMessage()->setStatus(200)->response($products);
        break;
}