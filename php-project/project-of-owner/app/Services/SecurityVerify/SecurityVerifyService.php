<?php


namespace App\Services\SecurityVerify;

use App\Models\SecurityCodeInfo;
use App\Models\SecurityCodeSearchLog;
use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager as DB;

class SecurityVerifyService extends BaseService
{
    protected $securityCodeInfo;
    protected $securityCodeSearchLog;

    public function __construct()
    {
        parent::__construct();

        $this->securityCodeInfo = new SecurityCodeInfo();
        $this->securityCodeSearchLog = new SecurityCodeSearchLog();
    }


    /**
     * @Notes:验证防伪码
     *
     * @param string $security_code_number
     * @param array $fields
     * @auther: helun
     * @Date: 2020/11/10
     * @Time: 11:58
     */
    public function getSecurityCode($security_code_number, $fields = ['search_num'])
    {
        try {
            $result = ['state'=>false, 'verify_data'=>[]];
            $verifyInfo = $this->securityCodeInfo
                        ->where('security_code_number', $security_code_number)
                        ->where('status', 0)
                        ->first($fields);

            if ($verifyInfo) {
                $verifyInfo = $verifyInfo->toArray();
                $result = ['state'=>true, 'verify_data'=>$verifyInfo];
            }
        } catch (\Exception $e) {
            $result = ['state'=>false, 'verify_data'=>[]];
        }
        return $result;
    }

    /**
     * @Notes:修改防伪码数据查询次数以及记录查询记录
     *
     * @param $updateData
     * @return boolean
     * @auther: helun
     * @Date: 2020/11/10
     * @Time: 15:54
     */
    public function setSecurityCode($updateData)
    {
        try {
            if ($updateData) {
                $search_num = $updateData['search_num'] + 1;
                $editData = [
                    'search_num' => $search_num
                ];
                $this->securityCodeInfo
                    ->where('security_code_number', $updateData['security_code_number'])
                    ->update($editData);
                $insertData = [
                    'security_code_number' => $updateData['security_code_number'],
                    'create_time' => time(),
                    'ip_address' => $updateData['ip_address'],
                    'resource' => $updateData['resource']
                ];
                $this->securityCodeSearchLog
                    ->create($insertData);
            }
            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }
        return $result;
    }

    /**
     * @Notes:比较时间之间同个ip查询次数
     *
     * @param $startDay //开始时间
     * @param $endDay //结束时间
     * @param $code //防伪码
     * @param $ip_address //ip地址
     * @return int|null
     * @auther: helun
     * @Date: 2020/11/16
     * @Time: 17:48
     */
    public function getToDaySelectCode($startDay, $endDay, $code, $ip_address)
    {
        try {
            $result = $this->securityCodeSearchLog
                    ->where('security_code_number', $code)
                    ->where('ip_address', $ip_address)
                    ->whereBetween('create_time',[$startDay, $endDay])
                    ->count();
        } catch (\Exception $e) {
            $result = null;
        }
        return $result;
    }
}