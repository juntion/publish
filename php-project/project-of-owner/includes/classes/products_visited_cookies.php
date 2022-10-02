<?php

class products_visited_cookies{

function RecentViews($num=10,$day=365,$datastr)
{ 
 $id = !empty($datastr) ? $datastr : $_GET['products_id'];
 if(isset($_COOKIE['fs_views']))
 { 
  if($num==1)
  { 
   @setcookie("fs_views",$id,time()+86400*$day,"/");
   $datastr = $_COOKIE['fs_views'];
  }
  else
  { 
   $datastr = $_COOKIE['fs_views'];
   $ids = explode('|',$datastr);
   if(count($ids )< $num){
    if(!in_array($id,$ids)){
     $datastr .= '|'.$id;
     @setcookie("fs_views",$datastr,time()+86400*$day,"/");
    }
   }
   else
   {
    if(!in_array($id,$ids))
    {
     $datastr = str_replace($ids[0].'|','',$datastr);
     $datastr .= '|'.$id;
     @setcookie("fs_views",$datastr,time()+86400*$day,"/");
    }
   }
   
  }
 }
 else
 {
  setcookie("fs_views",$id,time()+86400*$day,"/");

  $datastr = $_COOKIE['fs_views'];
 }
 return $datastr;
}

//浏览历史list
function BrowsingHistory($product_id = '', $remove = false, $day_key = '', $num = 50){
    $history_redis_prefix = 'browsing_history';
    $today = getTime('Y-m-d',time(),$_SESSION['countries_iso_code']);
    $list_history_redis_key = $history_redis_prefix.':'.'browsing_history_list_'.$_SESSION['customer_id'];
    $redis = getRedis();
    if($product_id > 0){
        if($remove && $day_key != ''){
            $redis->lRem($list_history_redis_key,$day_key.':'.$product_id);
        }else{
            $redisSize = $redis->lLen($list_history_redis_key);
            $redis->lRem($list_history_redis_key,$today.':'.$product_id);
            if($redisSize >= $num){
                $redis->rPop($list_history_redis_key);
            }
            $redis->lPush($list_history_redis_key,$today.':'.$product_id);
        }
        return true;
    }else{
        $history_arr = array();
        $history_data = $redis->lGetRange($list_history_redis_key);
        if(sizeof($history_data)){
            foreach ($history_data as $v){
                $arr = explode(':',$v);
                $history_arr[$arr[0]][] = $arr[1];
            }
        }
        return $history_arr;
    }
}

//浏览历史
/*
function BrowsingHistory($product_id='', $remove=false, $day_key='', $num=100){
    $history_redis_key = md5('BROWSING_HISTORY_'.$_SESSION['customer_id'],true);
    $history_redis_prefix = 'browsing_history';
    $history_data = get_redis_key_value($history_redis_key,$history_redis_prefix);
    $today = getTime('Y-m-d',time(),$_SESSION['countries_iso_code']);
    if($product_id > 0){
        $history_arr = json_decode($history_data,true);
        if(!$remove){
            if(sizeof($history_arr)){
                $size = 0;
                foreach ($history_arr as $pids){
                    $size += sizeof($pids);
                }
                krsort($history_arr);
                if($size >= $num && !in_array($product_id,$history_arr[$today])){
                    //去掉最早的一个
                    $i=0;
                    foreach ($history_arr as $k=>$v){
                        $i++;
                        if($i == sizeof($history_arr)){
                            array_pop($history_arr[$k]);
                        }
                    }
                }
                if(is_array($history_arr[$today])){
                    foreach($history_arr[$today] as $k=>$v) {
                        if($product_id == $v) unset($history_arr[$today][$k]);
                    }
                }
                if(sizeof($history_arr[$today])){
                    array_unshift($history_arr[$today], $product_id);
                }else{
                    $history_arr[$today][] = $product_id;
                }
            }else{
                $history_arr = array($today=>array($product_id));
            }
        }
        //删除
        if($remove && $day_key != ''){
            if(sizeof($history_arr[$day_key]) > 1){
                foreach($history_arr[$day_key] as $k=>$v) {
                    if($product_id == $v) unset($history_arr[$day_key][$k]);
                }
            }else{
                unset($history_arr[$day_key]);
            }
        }
        krsort($history_arr);
        $history_data = json_encode($history_arr);
        set_redis_key_value($history_redis_key,$history_data,60*24*3600,$history_redis_prefix);
        //remove_redis_by_key(md5('BROWSING_PRODUCTS_INFO_'.$_SESSION['customer_id'],true),$history_redis_prefix);
    }
    $history_arr = json_decode($history_data,true);
    return $history_arr;
}
*/



}



