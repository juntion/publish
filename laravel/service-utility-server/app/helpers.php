<?php

use App\Enums\ProjectManage\ProductStatus;
use App\Enums\WsGateway\WsNotificationType;
use App\ProjectManage\Models\Product;
use App\Support\WsGateway;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * 获取用户真实ip
 */
if (!function_exists('getIP')) {
    function getIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
}

/**
 * 据用户IP获取地区
 */
if (!function_exists('getCityFromIp')) {
    function getCityFromIp($ip = '')
    {
        try {
            $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=2TGbi6zzFm5rjYKqPPomh9GBwcgLW5sS&ip={$ip}&coor=bd09ll");
            $json = json_decode($content);
            $address = $json->{'content'}->{'address'};//按层级关系提取address数据
            $data['address'] = $address;
            $data['province'] = mb_substr($data['address'], 0, 3, 'utf-8');
            $data['city'] = mb_substr($data['address'], 3, 3, 'utf-8');
            return $data['address'];
        } catch (\Exception $e) {
            // \Log::error('获取用户登录地区错误', [$e->getMessage()]);
            return '';
        }
    }
}

/**
 * 获取用户浏览器
 */
if (!function_exists('getBrowser')) {
    function getBrowser()
    {
        $flag = $_SERVER['HTTP_USER_AGENT'];
        $para = array();
        // 检查操作系统
        if (preg_match('/Windows[\d\. \w]*/', $flag, $match)) $para['OS'] = $match[0];

        if (preg_match('/Chrome\/[\d\.\w]*/', $flag, $match)) {
            // 检查Chrome
            $para['browser'] = '谷歌浏览器';
        } elseif (preg_match('/Safari\/[\d\.\w]*/', $flag, $match)) {
            // 检查Safari
            $para['browser'] = $match[0];
        } elseif (preg_match('/MSIE [\d\.\w]*/', $flag, $match)) {
            // IE
            $para['browser'] = $match[0];
        } elseif (preg_match('/Opera\/[\d\.\w]*/', $flag, $match)) {
            // opera
            $para['browser'] = $match[0];
        } elseif (preg_match('/Firefox\/[\d\.\w]*/', $flag, $match)) {
            // Firefox
            $para['browser'] = $match[0];
        } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $flag, $match)) {
            //OmniWeb
            $para['browser'] = $match[2];
        } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $flag, $match)) {
            //Netscape
            $para['browser'] = $match[2];
        } elseif (preg_match('/Lynx\/([^\s]+)/i', $flag, $match)) {
            //Lynx
            $para['browser'] = $match[1];
        } elseif (preg_match('/360SE/i', $flag, $match)) {
            //360SE
            $para['browser'] = '360安全浏览器';
        } elseif (preg_match('/SE 2.x/i', $flag, $match)) {
            //搜狗
            $para['browser'] = '搜狗浏览器';
        } else {
            $para['browser'] = 'unkown';
        }
        return $para;
    }
}

/**
 * 是否是测试环境
 */
if (!function_exists('isTesting')) {
    function isTesting()
    {
        return in_array(config('app.env'), ['test', 'testing', 'local']);
    }
}

if (!function_exists('getAllParentsOfProduct')){
    function getAllParentsOfProduct(Product $product, $pid = [])
    {
        $project = Product::query()->find($product->parent_id);
        $pid[$project->id] = [
            'product_type' => $project->type
        ];
        // 模块和标签 直接从request里获取
        if ($product_modules =request()->input('product_modules')){
            foreach ($product_modules as $module){
                $pid[$module['module_id']] = [
                    'product_type' => ProductStatus::TypeModule
                ];
                if(isset($module['label_ids'])){
                    $label_ids = $module['label_ids'];
                    foreach ($label_ids as $label_id) {
                        $pid[$label_id] = [
                            'product_type' => ProductStatus::TypeCategory
                        ];
                    }
                }
            }
        }
        return $pid;
    }
}

if (!function_exists('getExplodeValue')){
    /**
     * @param $value
     * @param string $needles
     * @return \Illuminate\Support\Collection
     * @author: King
     * @version: 2019/12/21 12:02
     */
    function getExplodeValue($value, $needles = ',')
    {
        if (Str::contains($value, $needles)) {
            return collect(explode($needles, $value));
        }else{
            return collect($value);
        }
    }
}

if (!function_exists('getUserNameById')) {
    /**
     * @param $id
     * @return string | null
     */
    function getUserNameById($id)
    {
        $cacheName = 'users_name_cache';
        if ($name = Cache::tags($cacheName)->get($id)) {
            return $name;
        }
        if ($user = \App\Models\User::query()->withTrashed()->find($id)) {
            if ($user->deleted_at) {
                $name = "离职人员(" . $user->name . ")";
            } else {
                $name = $user->name;
            }
            Cache::tags($cacheName)->put($user->id, $name, 86400 * 7);
            return $name;
        }
        return null;
    }
}

if (!function_exists('sendWSNotification')) {
    /**
     * 发送 Websocket 通知
     * @param int| array $userId
     * @param string $title
     * @param string $message
     */
    function sendWSNotification($userId, $title, $message)
    {
        $data = [
            'type' => WsNotificationType::NOTIFICATION,
            'title' => $title,
            'content' => $message,
        ];
        WsGateway::sendToUid($userId, $data);
    }
}

/**
 * 记录sql日志，调试用
 */
if (!function_exists('logSql')) {
    function logSql()
    {
        info('----------------------------------------------------');
        \DB::listen(function ($query) {
            foreach ($query->bindings as $key => $binding) {
                if (is_string($binding)) {
                    $query->bindings[$key] = "'" . $binding . "'";
                }
            }
            info("Sql: " . Str::replaceArray("?", $query->bindings, $query->sql));
        });
    }
}
/**
 * 记录内存使用
 */
if (!function_exists('logMemory')) {
    function logMemory()
    {
        $memory = memory_get_peak_usage() / 1024 / 1024;
        info('内存: ' . $memory . " MB");
    }
}

if (!function_exists('data_path')) {
    /**
     * 获取data目录绝对路径
     * @param string $path
     * @return string
     */
    function data_path($path = '')
    {
        if ($path == '') {
            return base_path('data');
        }

        return base_path('data/' . $path);
    }
}

if (!function_exists('getDataContents')) {
    /**
     * 获取data目录下文件内容
     * @param string $path
     * @return mixed
     */
    function getDataContents($path = '')
    {
        $json = @file_get_contents(data_path($path));
        return @json_decode($json, true);
    }
}

if (!function_exists('getWorkDays')) {
    /**
     * 计算两个日期之间的工作日天数
     * @param string $begin 开始日期 Y-m-d
     * @param string $end 结束日期 Y-m-d
     * @return int|float
     */
    function getWorkDays($begin, $end)
    {
        $workSchedules = \App\Models\WorkSchedule\WorkSchedule::query()->whereBetween('date', [$begin, $end])->get();
        $totalWorkload = $workSchedules->sum('workload');
        return ($totalWorkload == floor($totalWorkload)) ? (int)$totalWorkload : $totalWorkload;
    }
}
