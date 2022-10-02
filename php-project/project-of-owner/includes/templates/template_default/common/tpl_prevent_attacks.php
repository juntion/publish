<?php
/**
 * Created by PhpStorm.
 * User: yaowei
 * Date: 2018/12/24
 * Time: 下午3:58
 */
require_once("includes/classes/PreventingAttacks.php");
$PreventingCCAttacks =  new PreventingAttacks();
$status = $PreventingCCAttacks::PreventingCCAttacks();
$status = $status['status'];
if($status!=200){
    header("HTTP/1.1 403 access denied");
    require('includes/500.html');
    exit;
}