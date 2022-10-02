<?php


namespace App\Services\AutoGiven;

use App\Services\AdminCustomers\AdminCustomersService;
use App\Services\BaseService;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\CustomersOffline;
use App\Services\MailSuffix\MailSuffixService;
use App\Services\ManageDisabled\ManageDisabledService;
use App\Models\AdminToCustomer;
use App\Models\Countries;
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\ManageCustomerCompany;
use App\Models\ManageCustomerCompanyToCustomers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\PmEmailHeaderFooter;

class AutoGivenService extends BaseService
{
    //customer model
    private $customerModel;
    // customers_offline
    private $customerOffline;
    // manage_customer_customers_disabled
    private $manageCustomerdisable;
    // admin_to_customer
    private $adminToCustomerModel;
    // 销售对应的admin
    private $adminModel;
    // 公共邮箱
    private $mailSuffix;
    // admin_to_customers
    private $adminToCustomers;
    // manage_customer_company
    private $manageCustomerCompany;
    // manage_customer_company_to_customers
    private $manageCustomerCompanyTo;
    // manage_customer_customers_disabled
    private $countries;

    private $email;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new Customer();
        $this->customerOffline = new CustomersOffline();
        $this->manageCustomerdisable = new ManageDisabledService();
        $this->adminToCustomerModel = new AdminToCustomer();
        $this->adminModel = new Admin();
        $this->countries = new Countries();
        $this->mailSuffix = new MailSuffixService();
        $this->adminToCustomers = new AdminCustomersService();
        $this->manageCustomerCompany =new ManageCustomerCompany();
        $this->manageCustomerCompanyTo = new ManageCustomerCompanyToCustomers();
        $this->email = new PmEmailHeaderFooter();
    }
    /**
     * @param array $param 传递的参数为数组 ['email' => $customers_email_address,
     * 'language_id' => $language_id,
     * 'post_email' => $post_email,  // 邮箱后缀
     * ]
     * @return int|string
     */
    public function getAdminId($param = [])
    {
        // start 无效客户的类型为1、3的时候不分配 不是的时候重新分配；同时考虑线上表和线上表同时有数据的情况
        $customerInfo = $this->uselessCustomers($param);
        // end
        $admin_info = $this->customerModel
            ->leftJoin('admin_to_customers', 'customers.customers_id', '=', 'admin_to_customers.customers_id')
            ->whereNotNull('admin_to_customers.admin_id')
            ->where('customers.customers_email_address', $param['customers_email_address'])
            ->where('customers.is_disabled', 0)
            ->limit(1)
            ->get(['customers.customers_id', 'admin_to_customers.admin_id',
                'customers.customers_number_new', 'customers.is_disabled'])
            ->toArray();
        $admin_id_from_table = 'admin_to_customers';
        if (!$admin_info[0]['admin_id']) {
            $admin_info = $this->customerOffline
                ->where('admin_id', '!=', 0)
                ->where('customers_email_address', $param['customers_email_address'])
                ->where('is_disabled', 0)
                ->limit(1)
                ->get(['admin_id', 'is_disabled', 'customers_number_new'])
                ->toArray();
            $admin_id_from_table = 'customers_offline';
        }
        $admin_id = $admin_info[0]['admin_id'] ? $admin_info[0]['admin_id'] : '';
        // 匹配邮箱后缀
        if (!$admin_id) {
            $company_mail = ['@fiberstore.com', '@fs.com', '@szyuxuan.com', '@feisu.com'];
            if (in_array($param['postfix_email'], $company_mail)) {
                $admin_info = $this->adminModel->whereIn('admin_level', [2, 5, 13])
                    ->where(function ($query) use ($param) {
                        $query->where('admin_email', $param['customers_email_address'])
                            ->orWhere('admin_email', 'like', $param['prefix_email'].'%');
                    })
                    ->limit(1)
                    ->get(['admin_id'])
                    ->toArray();
                $admin_id = $admin_info[0]['admin_id'] ? $admin_info[0]['admin_id'] : 117;
                $admin_id_from_table = 'admin_fs';
            }
        }
        // 获取公共邮箱后缀
        $postfix_public_mails = $this->mailSuffix->getPublicMailPostfix();
        if (!in_array($param['postfix_email'], $postfix_public_mails)) {
            if (!$admin_id) {
                // 验证customers表是否有邮箱
                $customers_fileds = ['customers.customers_id', 'admin_to_customers.admin_id'];
                $admin_id = $this->adminToCustomers->getAdminCustomers($param, $customers_fileds);
                $admin_id_from_table = 'customers_like';
            }
            if (!$admin_id) {
                $admin_info = $this->customerOffline
                    ->where('is_disabled', 0)
                    ->where('customers_email_address', 'like', '%'.$param['postfix_email'])
                    ->where('admin_id', '!=', 0)
                    ->orderBy('customers_id', 'desc')
                    ->limit(1)
                    ->get(['admin_id'])
                    ->toArray();
                $admin_id = $admin_info[0]['admin_id'];
                $admin_id_from_table = 'customers_offline_like';
            }
        }
        // 判断管理员是否存在
        if ($admin_id) {
            $admin_info = $this->adminModel->where('admin_id', $admin_id)->get(['admin_name'])->toArray();
            $admin_id = !empty($admin_info) ? $admin_id : '';
            if (!$admin_info[0]['admin_name']) {
                $admin_id = null;
                $admin_id_from_table = '';
            }
        }
        $admin_info['admin_id'] = $admin_id;
        $admin_info['admin_id_from_table'] = $admin_id_from_table;
        $is_old = $admin_id ? 1 : 0;
        $admin_info['is_old'] = $is_old;
        $admin_info['invalidSign'] = $customerInfo['invalidSign'];
        $admin_info['customer_number'] = $customerInfo['customer_number'];
        $admin_info['customer_offline_number'] = $customerInfo['customer_offline_number'];
        return $admin_info;
    }

    /**
     * 无效客户处理、尤其是线上线下表都有数据，并且一种一个是无效、一个是有效客户等情况
     * @param array $param
     */
    public function uselessCustomers($param = [])
    {

        if (!empty($param['customers_email_address'])) {
            $cus_fields = ['customers_number_new', 'is_disabled', 'customers_id'];
            $cus_new = $this->getFieldsByEmail($param['customers_email_address'], $cus_fields);
            $off_fields = ['admin_id', 'customers_number_new', 'is_disabled', 'customers_id'];
            $off_new = $this->getFieldsByOfflineEmail($param['customers_email_address'], $off_fields);
            $cus_is_disabled = isset($cus_new['is_disabled']) ? $cus_new['is_disabled'] : 0;
            $off_is_disabled = isset($off_new['is_disabled']) ? $off_new['is_disabled'] : 0;
            $customer_number = isset($cus_new['customers_number_new']) ? $cus_new['customers_number_new'] : '';
            $customer_offline_number = isset($off_new['customers_number_new']) ? $off_new['customers_number_new'] : '';
            $invalidSign = 0;  //标记当前客户是否是无效客户

            // 线上线下表同事存在数据，并且一种一个是无效、一个是有效客户
            $arr = ['admin_id' => 0, 'is_disabled' => 0];
            if ($cus_is_disabled > 0 && $off_is_disabled > 0) {
                $invalidSign = 1;
                $cus_reason = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($cus_new['customers_number_new'], ['reason']);
                $off_reason = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($off_new['customers_number_new'], ['reason']);
                // 线上
                if (in_array($cus_reason['reason'], [1, 3])) {
                    $this->adminToCustomerModel
                        ->where('customers_id', $cus_new['customers_id'])
                        ->update(['admin_id' => 0]);
                    $this->customerModel->where('customers_email_address', $param['customers_email_address'])
                        ->update(['is_disabled' => 0]);
                }

                // 线下
                if (in_array($off_reason['reason'], [1, 3])) {
                    $this->customerOffline->where('customers_email_address', $param['customers_email_address'])
                        ->update($arr);
                }
            } elseif ($cus_is_disabled > 0 && $off_is_disabled == 0 && !empty($off_new)) {
                $invalidSign = 1;
                $res = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($cus_new['customers_number_new'], ['reason']);
                if (in_array($res['reason'], [1, 3])) {
                    $this->customerModel->where('customers_email_address', $param['customers_email_address'])
                        ->update(['is_disabled' => 0]);
                    $this->adminToCustomerModel
                        ->where('customers_id', $cus_new['customers_id'])
                        ->update(['admin_id' => 0]);
                }
            } elseif ($cus_is_disabled == 0 && $off_is_disabled > 0 && !empty($cus_new)) {
                $invalidSign = 1;
                $res = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($off_new['customers_number_new'], ['reason']);
                if (in_array($res['reason'], [1, 3])) {
                    $this->customerOffline->where('customers_email_address', $param['customers_email_address'])
                        ->update($arr);
                }
            } elseif ($cus_is_disabled > 0 && empty($off_new)) {
                $invalidSign = 1;
                $res = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($cus_new['customers_number_new'], ['reason']);
                if (in_array($res['reason'], [1, 3])) {
                    $this->customerModel->where('customers_email_address', $param['customers_email_address'])
                        ->update(['is_disabled' => 0]);
                    $this->adminToCustomerModel
                        ->where('customers_id', $cus_new['customers_id'])
                        ->update(['admin_id' => 0]);
                }
            } elseif ($off_is_disabled > 0 && empty($cus_new)) {
                $invalidSign = 1;
                $res = $this->manageCustomerdisable
                    ->getManageCustomerDisabled($cus_new['customers_number_new'], ['reason']);
                if (in_array($res['reason'], [1, 3])) {
                    $this->customerOffline->where('customers_email_address', $param['customers_email_address'])
                        ->update($arr);
                }
            }
        }

        return [
            'invalidSign' => $invalidSign ? $invalidSign : 0,
            'customer_number' => $customer_number ? $customer_number : '',
            'customer_offline_number' => $customer_offline_number ? $customer_offline_number : '',
        ];
    }

    /**
     * 根据邮箱查customers表
     * @param $email
     * @param string[] $fields
     * @return mixed
     */
    public function getFieldsByEmail($email, $fields = ['*'])
    {
        $info = $this->customerModel->where('customers_email_address', $email)
            ->limit(1)
            ->get($fields)
            ->toArray();
        return $info[0] ? $info[0] : '';
    }

    /**
     * 根据邮箱查customers_offline表
     * @param $email
     * @param string[] $fields
     * @return string
     */
    public function getFieldsByOfflineEmail($email, $fields = ['*'])
    {
        $info = $this->customerOffline->where('customers_email_address', $email)
            ->limit(1)
            ->get($fields)
            ->toArray();
        return $info[0] ? $info[0] : '';
    }


    /**
     * 获取国内时区
     * 如果传入一个 时间 把那个时间转换成北京时间戳
     * @param string $time
     * @return false|int|string
     */
    function getCommonCnTime($time = '')
    {
        date_default_timezone_set("Asia/Shanghai");
        if ($time) {
            $date = strtotime($time);
        } else {
            $date = date("Y-m-d H:i:s");
        }
        date_default_timezone_set("America/Los_Angeles");
        return $date;
    }

    /**
     * 非公共邮箱
     * @param $admin_id
     * @param $allot_register_info
     * @param $flag
     * @param $finalCompany
     * @return array
     */
    public function getFinalCompany($admin_id, $allot_register_info, $flag, $finalCompany)
    {
        $data = [];
        $postfix_public_mails = $this->mailSuffix->getPublicMailPostfix();
        if (!in_array($allot_register_info['postfix_email'], $postfix_public_mails) && $admin_id) {
            $numberArr = [];
            $numberArr1 = [];
            $numberArr2 = [];
            //线上同后缀的客户
            $admin_info = $this->customerModel
                ->leftJoin('admin_to_customers', 'customers.customers_id', '=', 'admin_to_customers.customers_id')
                ->where('customers.customers_email_address', 'like', '%'.$allot_register_info['postfix_email'])
                ->where('admin_to_customers.admin_id', $admin_id)
                ->where('customers.manage_type', 1)
                ->get(['customers.customers_number_new'])
                ->toArray();
            $numberArr1 = !empty($admin_info) ? array_column($admin_info, 'customers_number_new') : [];
            //线下同后缀的客户
            $cus_offline = $this->customerOffline
                ->where('customers_email_address', 'like', '%'.$allot_register_info['postfix_email'])
                ->where('manage_type', 1)
                ->where('admin_id', $admin_id)
                ->get(['customers_number_new'])
                ->toArray();
            $numberArr2 = !empty($cus_offline) ? array_column($cus_offline, 'customers_number_new') : [];
            $numberArr = array_merge($numberArr1, $numberArr2);

            if (sizeof($numberArr)) {
                $resultCompany = $this->manageCustomerCompanyTo
                    ->whereIn('customers_number_new', $numberArr)
                    ->groupBy('company_number')
                    ->get(['company_number'])
                    ->toArray();
                if (sizeof($resultCompany) == 1) {
                    $flag = true;
                    $finalCompany = $resultCompany[0]['company_number'];
                }
            } else {
                //线上同后缀的客户
                $admin_info = $this->customerModel
                    ->leftJoin('admin_to_customers', 'customers.customers_id', '=', 'admin_to_customers.customers_id')
                    ->where('customers.customers_email_address', 'like', '%'.$allot_register_info['postfix_email'])
                    ->where('admin_to_customers.admin_id', 0)
                    ->where('customers.manage_type', 1)
                    ->get(['customers.customers_number_new'])
                    ->toArray();
                $numberArr1 = !empty($admin_info) ? array_column($admin_info, 'customers_number_new') : [];
                //线下同后缀的客户
                $cus_offline = $this->customerOffline
                    ->where('customers_email_address', 'like', '%'.$allot_register_info['postfix_email'])
                    ->where('admin_id', 0)
                    ->where('manage_type', 1)
                    ->get(['customers_number_new'])
                    ->toArray();
                $numberArr2 = !empty($cus_offline) ? array_column($cus_offline, 'customers_number_new') : [];
                $numberArr = array_merge($numberArr1, $numberArr2);
                $resultCompany = $this->manageCustomerCompanyTo
                    ->whereIn('customers_number_new', $numberArr)
                    ->groupBy('company_number')
                    ->get(['company_number'])
                    ->toArray();
                if (sizeof($resultCompany) == 1) {
                    $flag = true;
                    $finalCompany = $resultCompany[0]['company_number'];
                }
            }
        }
        $data = [
            'flag' => $flag ? $flag : false,
            'company_number' => $finalCompany ? $finalCompany : '',
        ];
        return $data;
    }

    /**
     * 自动关联公司
     * @param $finalCompany
     * @param $theCustomerNumber
     * @param $admin_id
     * @param $cus_table
     */
    public function getAutomaticLink($finalCompany, $theCustomerNumber, $admin_id, $cus_table)
    {
//        $customers_info = $this->manageCustomerCompany->setConnection('adminDatabase')
        $customers_info = $this->manageCustomerCompany
            ->where('company_number', $finalCompany)
            ->limit(1)
            ->get(['customers_level', 'company_type'])
            ->toArray();
//        $this->manageCustomerCompany = new ManageCustomerCompany();
        $manage_type =0;
        $customer_level = '';
        if (!empty($customers_info)) {
            $manage_type =1;
            if ($customers_info[0]['company_type'] == 1) {
                $manage_type =2;
            }
            $customer_level = $customers_info[0]['customers_level'];
        }
        $data = [
            'company_number' => $finalCompany,
            'customers_number_new' => $theCustomerNumber,
            'admin_id' => $admin_id,
            'created_at' => date("Y-m-d H:i:s"),
        ];
        //$this->manageCustomerCompanyTo->setConnection('adminDatabase')->insert($data);
        $this->manageCustomerCompanyTo->insert($data);
//        $this->manageCustomerCompanyTo = new ManageCustomerCompanyToCustomers(); // 重置数据库连接
        if ($cus_table == 'customers') {
            $this->customerModel->where('customers_number_new', $theCustomerNumber)
                ->update([
                    'manage_type' => $manage_type,
                    'customers_level' => $customer_level,
                ]);
        } else {
//            $this->customerOffline->setConnection('adminDatabase')
            $this->customerOffline
                ->where('customers_number_new', $theCustomerNumber)
                ->update([
                    'manage_type' => $manage_type,
                    'customers_level' => $customer_level,
                ]);
//            $this->customerOffline = new CustomersOffline(); // 重置数据库连接、后台数据库改为前台数据库
        }
       //同步客户信息到对应的公司（如果请求参数都满足条件）下
        $this->updateNsData($finalCompany);
    }

    /**
     * @param $admin_id
     * @param $allot_register_info
     * @param int $is_online
     * @param array $data
     * @return bool
     */
    public function autoGivenCustomerManage($admin_id, $allot_register_info, $is_online = 1, $data = [])
    {
        $link = true;
        $fields = ['customers_number_new', 'manage_type',
            'customers_firstname', 'customer_country_id', 'customers_level'];
        if ($is_online == 1) {
            $the_customer_number = $this->getFieldsByEmail($allot_register_info['customers_email_address'], $fields);
            $theCustomerNumber = $the_customer_number['customers_number_new'];
            $cus_table = 'customers';
        } else {
            $cus_table = 'customers_offline';
            try {
                // 前后台数据库迁移成同一个数据库、所以不需要再重复连接后台的数据库
                $customers_offline = $this->customerOffline
                    ->where('customers_email_address', $allot_register_info['customers_email_address'])
                    ->limit(1)
                    ->get($fields)
                    ->toArray();
            } catch (\Exception $e) {
                $link = false;
            }
            $the_customer_number = $customers_offline[0];
            $theCustomerNumber = !empty($data['customers_number_new']) ? $data['customers_number_new']
                : $customers_offline[0]['customers_number_new'];
        }
        if ($the_customer_number['manage_type'] > 0 || !$admin_id || !$allot_register_info['customers_email_address']) {
            return false;
        }
        $flag = false;  //是否关联标记
        $finalCompany = '';
        if ($is_online == 1) {
            $customersOffline = $this->customerOffline
                ->where('customers_email_address', $allot_register_info['customers_email_address'])
                ->limit(1)
                ->get(['customers_number_new'])
                ->toArray();
            $customersOfflineNumber = $customersOffline[0];
            if ($customersOfflineNumber['customers_number_new']) {
                $companyNumber = $this->manageCustomerCompanyTo
                    ->where('customers_number_new', $customersOfflineNumber['customers_number_new'])
                    ->limit(1)
                    ->get(['company_number'])
                    ->toArray();
                if ($companyNumber[0]['company_number']) {
                    $flag = true;
                    $finalCompany = $companyNumber[0]['company_number'];
                }
            }
        }
        if (!$flag) {
            $data = $this->getFinalCompany($admin_id, $allot_register_info, $flag, $finalCompany);
            $flag = $data['flag'];
            $finalCompany = $data['company_number'];
        }
        //开始自动关联
        if ($link) {
            if ($flag && $finalCompany) {
                $this->getAutomaticLink($finalCompany, $theCustomerNumber, $admin_id, $cus_table);
            } else {
                if (in_array($allot_register_info['postfix_email'], ['@fs.com', '@feisu.com'])) {
                    return false;
                }
                //创建新公司关联
                $chinaTime = $this->getCommonCnTime();
                $defaultCompanyNumber = 'G' . '00000' . RAND(1000, 9999);
                $defaultCompanyLevel = $the_customer_number['customers_level'] ?
                    $the_customer_number['customers_level'] : 'E';
                $this->createAutomaticLink(
                    $admin_id,
                    $defaultCompanyNumber,
                    $theCustomerNumber,
                    $chinaTime,
                    $defaultCompanyLevel,
                    $the_customer_number,
                    $cus_table,
                    $finalCompany
                );
            }
        }
    }

    /**
     * 创建新公司关联
     * @param $admin_id
     * @param $defaultCompanyNumber
     * @param $theCustomerNumber
     * @param $chinaTime
     * @param $defaultCompanyLevel
     * @param $the_customer_number
     * @param $cus_table
     * @param $finalCompany
     */
    public function createAutomaticLink(
        $admin_id,
        $defaultCompanyNumber,
        $theCustomerNumber,
        $chinaTime,
        $defaultCompanyLevel,
        $the_customer_number,
        $cus_table,
        $finalCompany
    ) {
        $data = [
            'company_number' => $defaultCompanyNumber,
            'created_at' => $chinaTime,
            'customers_country_id' => $the_customer_number['customer_country_id'],
            'customers_company' => $the_customer_number['customers_firstname'],
            'company_type' => 1,
        ];
        try {
//            $newCompanyId = $this->manageCustomerCompany->setConnection('adminDatabase')
            $newCompanyId = $this->manageCustomerCompany
                ->insertGetId($data);
        } catch (\Exception $e) {
//            var_dump($e->getMessage());
        }
        if ($newCompanyId) {
            $newCompanyNumber = $this->setCompanyNumber($newCompanyId);
        }
        $insert_data = [
            'company_number' => $newCompanyNumber,
            'customers_number_new' => $theCustomerNumber,
            'admin_id' => $admin_id,
            'created_at' => date("Y-m-d H:i:s"),
        ];
        try {
//            $this->manageCustomerCompany->setConnection('adminDatabase')
            $this->manageCustomerCompany
                ->where('id', $newCompanyId)
                ->update([
                    'company_number' => $newCompanyNumber,
                    'customers_company' => $newCompanyNumber
                ]);
//            $this->manageCustomerCompanyTo->setConnection('adminDatabase')
            $this->manageCustomerCompanyTo
                ->insert($insert_data);
//            $this->manageCustomerCompany =new ManageCustomerCompany();
//            $this->manageCustomerCompanyTo = new ManageCustomerCompanyToCustomers();
            if ($cus_table == 'customers') {
                $this->customerModel->where('customers_number_new', $theCustomerNumber)
                    ->update(['manage_type' => 2, 'customers_level' => $defaultCompanyLevel]);
            } else {
//                $this->customerOffline->setConnection('adminDatabase')
                $this->customerOffline
                    ->where('customers_number_new', $theCustomerNumber)
                    ->update(['manage_type' => 2, 'customers_level' => $defaultCompanyLevel]);
//                $this->customerOffline = new CustomersOffline();
            }
        } catch (\Exception $e) {
        }
        //同步客户信息到对应的公司（如果请求参数都满足条件
        $this->updateNsData($finalCompany);
    }


    /**
     * 请求ns的接口
     * @param $url
     * @param $defaultEncrypt
     * @param $finalCompany
     * @return array|mixed
     */
    public function nsPostRequest($url, $defaultEncrypt, $finalCompany)
    {
        $httpObj = new Client();
        try {
            $response = $httpObj->post($url, [
                'form_params' => [  //参数组
                    'token' => $defaultEncrypt,
                    'company' => $finalCompany,
                ],
            ]);
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);      // 响应体
        } catch (GuzzleException $e) {
//            echo '<pre>';
            var_dump($e->getMessage());
//            echo '</pre>';
        }
        return $data ? $data : [];
    }


    /**
     * 由curl请求后台更新ns数据 改成 直接插入到表中，然后跑脚本执行
     * @param $finalCompany
     * @return bool
     */
    public function updateNsData($finalCompany)
    {
        $data = [
            'company_number' => $finalCompany,
            'is_update' => 0,
            'from_where' => 1,
            'num' => 0,
            'create_at' => time(),
        ];
        $insert_id = DB::table('customers_seas')->insertGetId($data);
        return $insert_id;
    }

    /**
     * 生成公司编号
     * @param $companyId
     * @return string
     */
    public function setCompanyNumber($companyId)
    {
        //9位数公司编号 1-2位为10-99的随机数 3位 1表示英文站 6表示中文站（暂无） 后位为company_id 中间补0
        $randNum = (string)rand(10, 99);
        $thirdNum = '1';
        $middleNum = '';
        $length = 9 - (strlen($companyId) + 3);
        for ($i = 0; $i < $length; $i++) {
            $middleNum .= '0';
        }
        $companyNum = 'G' . $randNum . $thirdNum . $middleNum . $companyId;

        return $companyNum;
    }

    /**
     * 获取后台token
     * @return string
     */
    public function defaultEncrypt()
    {
        $secretKey = 'xsacsdqweSasdc1d5f2';
        $appId = '34252352343543';
        $secretId = 'acsadsadasda211dacsadsqwe';
        $t = time();
        $r = mt_rand(10000000, 99999999);
        $original = 'u=' . $appId . '&k=' . $secretId . '&t=' . $t . '&r=' . $r . '&f=';
        $signStr = base64_encode(hash_hmac('sha1', $original, $secretKey) . $original);
        return $signStr;
    }

    /**
     * 给对应销售发送邮件
     * @param $data
     * @param $admin_id
     * @return array|mixed
     */
    public function sendEmail($data)
    {
        try {
            $sales_email = $this->adminModel
                ->where('admin_id', $data['admin_id'])
                ->limit(1)
                ->get()
                ->toArray();
            $tel_prefix = $this->countries
                ->where('countries_id', (int)$data['customer_country_id'])
                ->limit(1)
                ->get()
                ->toArray();
            $html = $this->email
                ->where('language_id', (int)$data['language_id'])
                ->limit(1)
                ->get()
                ->toArray();
            $customer_number_new = $this->customerModel
                ->where('customers_id', $data['customers_id'])
                ->limit(1)
                ->get()
                ->toArray();
            $firstname = $customer_number_new[0]['customers_firstname'];
            $lastname = $customer_number_new[0]['customers_lastname'];
            $html_msg['EMAIL_HEADER'] = $html[0]['header'];
            $html_msg['EMAIL_FOOTER'] = $html[0]['footer'];
            $html_msg['CUSTOMER_NAME'] = $firstname . $lastname ? $firstname .' '. $lastname : 'not set yet';
            $html_msg['NUMBER'] = $data['customers_telephone'] ?
                $tel_prefix[0]['tel_prefix'] . ' ' . $data['customers_telephone'] : 'not set yet';
            $html_msg['EMAIL_ADDRESS'] = $data['customers_email_address'] ?
                $data['customers_email_address'] : 'not set yet';
            $new_data = [
                'name'             => $sales_email[0]['admin_email'],
                'user_email'       => $sales_email[0]['admin_email'],
                'email_name'       => '注册销售邮件'.$sales_email[0]['admin_email'].date('Y-m-d H:i:s', time()),
                'email'            => 'FS.COM',
                'title'            => 'Customer Info',
                'block'            => $html_msg,
                'module'           => 'regist_to_us',
                'groups'           => 81,
                'attachments_list' => '',
                'languages_code'   => (string)$data['language_code'] ?: 'en',
                'session'          => isset($_SESSION['customer_email_data']) ? $_SESSION['customer_email_data'] : ''
            ];
            (new \App\Models\RegistEmailQueue())->insert(
                [
                    'customers_id'  => $data['admin_id'],  //销售id
                    'data'       => json_encode($new_data),
                    'created_at' => time()
                ]
            );
            $result =  ([
                "code" => 1,
                "success" => 'email send success',
            ]);
        } catch (GuzzleException $e) {
//            echo '<pre>';
//            var_dump($e->getMessage());
//            echo '</pre>';
            $result =  ([
                "code" => 2,
                "success" => 'email send false',
            ]);
        }
        return $result ? $result : [];
    }
}
