<?php

namespace App\Services\AdminCustomers;

use App\Services\BaseService;
use App\Models\AdminToCustomer;
use App\Models\Customer;
use App\Models\CustomersOffline;
use App\Services\MailSuffix\MailSuffixService;
use App\Models\ManageCustomerCompanyToCustomers;
use App\Models\CustomersSeas;
use App\Models\ManageCustomerDisabled;
use Illuminate\Database\Capsule\Manager as DB;

class AdminCustomersService extends BaseService
{

    private $adminCustomersObj; // public_mail_suffix

    private $customers; // customers

    private $mailSuffixObj;  // public_mail_suffix

    private $customersOffline;  // customers_offline

    private $manageCustomerCompanyTo;  // manage_customer_company_to_customers

    private $customersSeasObj;  // CustomersSeas

    private $manageCustomerDisabled;   //manage_customer_customers_disabled

    public function __construct()
    {
        parent::__construct();
        $this->adminCustomersObj = new AdminToCustomer();
        $this->customers = new Customer();
        $this->mailSuffixObj = new MailSuffixService();
        $this->customersOffline = new CustomersOffline();
        $this->manageCustomerCompanyTo = new ManageCustomerCompanyToCustomers();
        $this->customersSeasObj = new CustomersSeas();
        $this->manageCustomerDisabled = new ManageCustomerDisabled();
    }

    /**
     * 客户分配查询是否有类似的邮箱
     * @param $param
     * @param $customers_fileds
     * @return string
     */
    public function getAdminCustomers($param, $customers_fileds)
    {
        $admin_id = $this->adminCustomersObj
            ->leftJoin('customers', 'customers.customers_id', '=', 'admin_to_customers.customers_id')
            ->where('admin_to_customers.admin_id', '>', 0)
            ->where('customers.is_disabled', 0)
            ->where('customers.customers_email_address', 'like', '%'.$param['postfix_email'])
            ->orderBy('customers.customers_id', 'desc')
            ->limit(1)
            ->get($customers_fileds)
            ->toArray();
        return $admin_id[0]['admin_id'] ? $admin_id[0]['admin_id'] : '';
    }

    /**
     * 前台注册客户分配2
     * @param $customers_id
     * @param $admin_id
     * @param $date
     * @return string
     */
    public function insertAdminCustomer($customers_id, $admin_id, $date)
    {
        try{
            $data = [
                'admin_id' => $admin_id,
                'customers_id' => $customers_id,
                'add_time' => $date,
                'link_id' => 0,
                'create_time' => time(),
            ];
            $res = $this->adminCustomersObj
                ->insert($data);
            return $res ? $res : '';
        }catch (\Exception $e){
            return '';
        }
    }

    /**
     * Note: 获取公司编号下的所有客户
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param string $companyNumber
     * @return array
     */
    public function getAllCustomerCompanyNumber($companyNumber = '')
    {
        if (!$companyNumber) {
            return [];
        }
        $allCustomersNumber = $this->manageCustomerCompanyTo
            ->where('company_number', $companyNumber)
            ->lists('customers_number_new');
        return $allCustomersNumber;
    }

    /**
     * Note: 获取邮箱前缀
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param string $customer_email
     * @return bool
     */
    public function getCustomerEmailPrefix($customer_email = '')
    {
        if (!$customer_email) {
            return false;
        }
        $prefixEmail = explode('@', $customer_email);
        return $prefixEmail[1];
    }

    /**
     * Note: 更新客户线上表
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param array $customer_number_new
     * @param array $fields
     * @return bool
     */
    public function updateCustomer($customer_number_new = [], $fields = [])
    {
        if (!$customer_number_new || !$fields) {
            return false;
        }
        $this->customers
            ->whereIn('customers_number_new', $customer_number_new)
            ->rightJoin('admin_to_customers', function ($join) {
                $join->on('customers.customers_id', '=', 'admin_to_customers.customers_id');
            })
            ->update($fields);
    }

    /**
     * Note: 更新客户线下表
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param array $customer_number_new
     * @param array $fields
     * @return bool
     */
    public function updateCustomerOffline($customer_number_new = [], $fields = [])
    {
        if (!$customer_number_new || !$fields) {
            return false;
        }
        $this->customersOffline
            ->whereIn('customers_number_new', $customer_number_new)
            ->update($fields);
    }

    /**
     * Note: 更新客户关联公司表
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param array $customer_number_new
     * @param array $fields
     * @return bool
     */
    public function updateManageCompanyTo($customer_number_new = [], $fields = [])
    {
        if (!$customer_number_new || !$fields) {
            return false;
        }
        $this->manageCustomerCompanyTo
            ->whereIn('customers_number_new', $customer_number_new)
            ->update($fields);
    }

    public function deleteManageCompanyTo($customer_number_new = [])
    {
        if (!$customer_number_new) {
            return false;
        }
        $this->manageCustomerCompanyTo
            ->whereIn('customers_number_new', $customer_number_new)
            ->delete();
    }

    /**
     * Note: 查询线上线下表同后缀或者全称的所有客户
     * @author: Dylan
     * @Date: 2020/7/8
     *
     * @param string $customer_email
     * @param array $customers_number_new
     * @param bool $isLikeSelect
     * @return array
     */
    public function getOnlineAndOfflineCustomer($customer_email = '', $customers_number_new = [], $isLikeSelect = true)
    {
        $allCustomerNumber = [];
        if (!$customers_number_new) {
            return $allCustomerNumber;
        }
        try {
            $postfixAllCustomers = $this->customers
                ->leftJoin('admin_to_customers', 'customers.customers_id', '=', 'admin_to_customers.customers_id')
                ->whereRaw('(admin_id=0 or admin_id=117)');
            if ($customers_number_new) {
                $postfixAllCustomers = $postfixAllCustomers
                    ->whereIn('customers.customers_number_new', $customers_number_new);
            }
            if ($customer_email) {
                if ($isLikeSelect) {
                    $postfixAllCustomers = $postfixAllCustomers
                        ->Orwhere('customers_email_address', 'like', '%'.$customer_email);
                } else {
                    $postfixAllCustomers = $postfixAllCustomers
                        ->Orwhere('customers_email_address', $customer_email);
                }
            }
            $postfixAllCustomers = $postfixAllCustomers
                ->get(['customers.customers_id', 'customers_number_new', 'is_disabled'])
                ->toArray();

            $postfixAllCustomersOff = $this->customersOffline;
            if ($customers_number_new) {
                $postfixAllCustomersOff = $postfixAllCustomersOff
                    ->whereIn('customers_number_new', $customers_number_new);
            }
            if ($customer_email) {
                if ($isLikeSelect) {
                    $postfixAllCustomersOff = $postfixAllCustomersOff
                        ->Orwhere('customers_email_address', 'like', '%'.$customer_email);
                } else {
                    $postfixAllCustomersOff = $postfixAllCustomersOff
                        ->Orwhere('customers_email_address', $customer_email);
                }
            }

            $postfixAllCustomersOff = $postfixAllCustomersOff
                ->whereRaw('(admin_id=0 or admin_id=117)')
                ->get(['customers_id', 'customers_number_new', 'is_disabled'])
                ->toArray();
            $allCustomerNumber = array_merge($postfixAllCustomers, $postfixAllCustomersOff);
        } catch (\Exception $e) {
            $error['err_7_1'] = $e->getMessage();
        }
        return $allCustomerNumber;
    }

    /**
     * 非公共邮箱相同后缀关联公司公海客户分配
     * @param $allot_register_info
     * @param $admin_id
     */
    public function autoGivenOpenSeas($allot_register_info, $admin_id)
    {
        $mail_suffix = $this->mailSuffixObj->getMailSuffix($allot_register_info['postfix_email']);
        $allIsDisabled = $allEndisabled = $invalid_customers_number = $all_invalid_customers_number = [];
        //无效客户标记
        $invalidSign = $allot_register_info['invalidSign'] ? $allot_register_info['invalidSign'] : 0;

        if (!$allot_register_info['customers_email_address'] || !$admin_id) {
            return false;
        }

        //获取当前客户编号
        $customerNumberNew = $allot_register_info['customer_number'] ? $allot_register_info['customer_number'] : '';
        if (!$customerNumberNew) {
            $customerNumberNew = $allot_register_info['customer_offline_number']
                ? $allot_register_info['customer_offline_number'] : '';
        }

        $currentCompanyNumber = $this->manageCustomerCompanyTo
            ->where('customers_number_new', $customerNumberNew)
            ->select(['company_number'])
            ->first()
            ->company_number;

        if (!$currentCompanyNumber) {
            return;
        }

        $user_reason = 0;
        //如果当前客户为无效客户，再去查无效客户类型表
        if ($invalidSign) {
            $user_reason = $this->manageCustomerDisabled
                ->select(['reason'])
                ->where('customers_number_new', $customerNumberNew)
                ->first()
                ->reason;
        }

        $adminArr = ['admin_id' => $admin_id];
        $isDisabledArr = ['is_disabled' => 0];
        if (!$mail_suffix) {
            // 无效客户处理

            if ($user_reason) {
                switch ($user_reason) {
                    case 1:
                        //可能一个公司编号对应多个客户
                        $companyAllCustomersNumber = $this->getAllCustomerCompanyNumber($customerNumberNew);

                        $onlineAndOfflineCustomer =
                            $this->getOnlineAndOfflineCustomer($allot_register_info['postfix_email'], $companyAllCustomersNumber);


                        foreach ($onlineAndOfflineCustomer as $k => $v) {
                            if ($v['is_disabled'] == 1) {
                                $allIsDisabled[] = $v['customers_number_new'];
                            } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                                $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
                            }
                        }

                        //如果存在无效客户
                        if ($allIsDisabled) {
                            $allCompanyReason = $this->manageCustomerDisabled
                                ->whereIn('customers_number_new', $allIsDisabled)
                                ->orderBy('id', 'DESC')
                                ->get(['customers_number_new', 'reason'])
                                ->toArray();

                            //由于一个客户可能存在多个无效客户类型，故获取最新的类型
                            foreach ($allCompanyReason as $k => $v) {
                                $all_invalid_customers_number[$v['customers_number_new']] = $v['reason'];
                            }
                            foreach ($all_invalid_customers_number as $number => $reason) {
                                if (in_array($reason, [1,3])) {
                                    $invalid_customers_number[] =  $number;
                                }
                            }
                        }
                        $invalid_customers_number = array_merge($invalid_customers_number, $allEndisabled);
                        if (!empty($invalid_customers_number)) {
                            $this->updateCustomer($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                            $this->updateCustomerOffline($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                            $this->updateManageCompanyTo($invalid_customers_number, $adminArr);
                            foreach ($invalid_customers_number as $value) {
                                $customers_seas_data = [
                                    'customer_number_new' => $value,
                                    //分配时的公司编号,若公海客户没有公司 都用此公司编号
                                    'company_number' => $currentCompanyNumber,
                                    'create_at' => time(),
                                    'is_update' => 0
                                ];
                                $this->customersSeasObj->insert($customers_seas_data);
                            }
                        }
                        break;
                    case 3:
                        //可能一个公司编号对应多个客户
                        $companyAllCustomersNumber = $this->getAllCustomerCompanyNumber($customerNumberNew);

                        $allCustomersNumber =
                            $this->getOnlineAndOfflineCustomer(
                                '',
                                $companyAllCustomersNumber,
                                false
                            );


                        foreach ($allCustomersNumber as $k => $v) {
                            if ($v['is_disabled'] == 1) {
                                $allIsDisabled[] = $v['customers_number_new'];
                            } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                                $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
                            }
                        }

                        //如果存在无效客户
                        if ($allIsDisabled) {
                            $allCompanyReason = $this->manageCustomerDisabled
                                ->whereIn('customers_number_new', $allIsDisabled)
                                ->orderBy('id', 'DESC')
                                ->get(['customers_number_new', 'reason'])
                                ->toArray();

                            //由于一个客户可能存在多个无效客户类型，故获取最新的类型
                            foreach ($allCompanyReason as $k => $v) {
                                $all_invalid_customers_number[$v['customers_number_new']] = $v['reason'];
                            }
                            foreach ($all_invalid_customers_number as $number => $reason) {
                                if (in_array($reason, [1,3])) {
                                    $invalid_customers_number[] =  $number;
                                } else {
                                    $invalid_customers_number_not[] = $number;   // 获得需要解除绑定的账号
                                }
                            }
                        }
                        $invalid_customers_number = array_merge($invalid_customers_number, $allEndisabled);
                        // 无效类型是非1和3解除公司绑定
                        if (!empty($invalid_customers_number_not)) {
                            $this->deleteManageCompanyTo($invalid_customers_number_not);
                            $this->updateCustomer($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
                            $this->updateCustomerOffline($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
                        }

                        if (!empty($invalid_customers_number)) {
                            $this->updateCustomer($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                            $this->updateCustomerOffline($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                            $this->updateManageCompanyTo($invalid_customers_number, $adminArr);
                            foreach ($invalid_customers_number as $value) {
                                $customers_seas_data = [
                                    'customer_number_new' => $value,
                                    //分配时的公司编号,若公海客户没有公司 都用此公司编号
                                    'company_number' => $currentCompanyNumber,
                                    'create_at' => time(),
                                    'is_update' => 0
                                ];
                                $this->customersSeasObj->insert($customers_seas_data);
                            }
                        }
                        break;
                }
            } else {
                //可能一个公司编号对应多个客户
                $companyAllCustomersNumber = $this->getAllCustomerCompanyNumber($currentCompanyNumber);
                // 有效客户的处理方式  同后缀（非1或3 不需要解除与员公司绑定）
                $allCustomersNumber =
                    $this->getOnlineAndOfflineCustomer(
                        $allot_register_info['postfix_email'],
                        $companyAllCustomersNumber
                    );

                foreach ($allCustomersNumber as $k => $v) {
                    if ($v['is_disabled'] == 1) {
                        $allIsDisabled[] = $v['customers_number_new'];
                    } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                        $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
                    }
                }

                //如果存在无效客户
                if ($allIsDisabled) {
                    $allCompanyReason = $this->manageCustomerDisabled
                        ->whereIn('customers_number_new', $allIsDisabled)
                        ->orderBy('id', 'ASC')
                        ->get(['customers_number_new', 'reason'])
                        ->toArray();

                    foreach ($allCompanyReason as $k => $v) {
                        $all_invalid_customers_number[$v['customers_number_new']] = $v['reason'];
                    }

                    foreach ($all_invalid_customers_number as $number => $reason) {
                        if (in_array($reason, [1])) {
                            $invalid_customers_number[] =  $number;
                        } else {
                            $invalid_customers_number_not[] = $number;   // 获得需要解除绑定的账号
                        }
                    }
                }
                $invalid_customers_number = array_merge($invalid_customers_number, $allEndisabled);

                // 无效类型是非1和3解除公司绑定
                if (!empty($invalid_customers_number_not)) {
                    $this->deleteManageCompanyTo($invalid_customers_number_not);
                    $this->updateCustomer($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
                    $this->updateCustomerOffline($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
                }
                if (!empty($invalid_customers_number)) {
                    $this->updateCustomer($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                    $this->updateCustomerOffline($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                    $this->updateManageCompanyTo($invalid_customers_number, $adminArr);
                    foreach ($invalid_customers_number as $value) {
                        $customers_seas_data = [
                            'customer_number_new' => $value,
                            //分配时的公司编号,若公海客户没有公司 都用此公司编号
                            'company_number' => $currentCompanyNumber,
                            'create_at' => time(),
                            'is_update' => 0
                        ];
                        $this->customersSeasObj->insert($customers_seas_data);
                    }
                }
            }
        } else {
            // 获取当前客户的公司下所有的客户编号
            $companyAllCustomersNumber = $this->getAllCustomerCompanyNumber($currentCompanyNumber);

            $allCustomersNumber =
                $this->getOnlineAndOfflineCustomer('', $companyAllCustomersNumber, false);

            foreach ($allCustomersNumber as $k => $v) {
                if ($v['is_disabled'] == 1) {
                    $allIsDisabled[] = $v['customers_number_new'];
                } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                    $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
                }
            }

            if ($allIsDisabled) {
                $PublicCustomerReason = $this->manageCustomerDisabled
                    ->whereIn('customers_number_new', $allIsDisabled)
                    ->orderBy('id', 'DESC')
                    ->get(['customers_number_new', 'reason'])
                    ->toArray();
                //由于一个客户可能存在多个无效客户类型，故获取最新的类型
                foreach ($PublicCustomerReason as $k => $v) {
                    $all_invalid_customers_number[$v['customers_number_new']] = $v['reason'];
                }
                foreach ($all_invalid_customers_number as $number => $reason) {
                    if (in_array($reason, [1,3])) {
                        $invalid_customers_number[] =  $number;
                    } else {
                        $invalid_customers_number_not[] = $number;   // 获得需要解除绑定的账号
                    }
                }
            }
            $invalid_customers_number = array_merge($invalid_customers_number, $allEndisabled);
            if (!empty($invalid_customers_number_not)) {
                $this->deleteManageCompanyTo($invalid_customers_number_not);
                $this->updateCustomer($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
                $this->updateCustomerOffline($invalid_customers_number_not, ['manage_type' => 0, 'customers_level' => '']);
            }

            if (!empty($invalid_customers_number)) {
                $this->updateCustomer($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                $this->updateCustomerOffline($invalid_customers_number, array_merge($adminArr, $isDisabledArr));
                $this->updateManageCompanyTo($invalid_customers_number, $adminArr);
                foreach ($invalid_customers_number as $value) {
                    $customers_seas_data = [
                        'customer_number_new' => $value,
                        //分配时的公司编号,若公海客户没有公司 都用此公司编号
                        'company_number' => $currentCompanyNumber,
                        'create_at' => time(),
                        'is_update' => 0
                    ];
                    $this->customersSeasObj->insert($customers_seas_data);
                }
            }
        }
    }

    /**
     * @param $customers_id
     */
    public function getAdmininfo($customers_id)
    {
        try {
            $info = $this->adminCustomersObj->where('customers_id', $customers_id)->first();
        } catch (\Exception $e) {
        }
        return $info ? $info : '';
    }


    /**
     * Note: 获取所有公海客户以及无效类型1或者3的所有客户
     * @author: Dylan
     * @Date: 2020/7/10
     *
     * @param array $data
     * @return bool
     */
    public function autoGivenSeasCustomers($data = [])
    {
        $customerNumberNew = $data['customers_number_new'];
        $mail_suffix = $data['mail_suffix'];
        $email = $data['email'];
        $adminArr = $data['admin_Arr'];
        if (!$email || !$customerNumberNew) {
            return false;
        }
        $companyAllCustomersNumber = $this->getAllCustomerNumber($customerNumberNew);

        $onlineAndOfflineCustomer =
            $this->getOnlineAndOfflineCustomer($mail_suffix, $companyAllCustomersNumber);

        $allCustomersNumber = array_merge($companyAllCustomersNumber, $onlineAndOfflineCustomer);


        foreach ($allCustomersNumber as $k => $v) {
            if ($v['is_disabled'] == 1) {
                $allIsDisabled[] = $v['customers_number_new'];
            } elseif ($v['admin_id'] == 0 && $v['is_disabled'] == 0) {
                $allEndisabled[] = $v['customers_number_new']; //有效客户公海客户
            }
        }

        //如果存在无效客户
        if ($allIsDisabled) {
            $allCompanyReason = $this->manageCustomerDisabled
                ->whereIn('customers_number_new', $allCustomersNumber)
                ->get(['customers_number_new', 'reason'])
                ->toArray();

            foreach ($allCompanyReason as $k => $v) {
                if (in_array($v['reason'], [1,3])) {
                    $invalid_customers_number[] =  $v['customers_number_new'];
                } else {
                    $invalid_customers_number_not[] = $v['customers_number_new'];   // 获得需要解除绑定的账号
                }
            }
        }

        // 无效类型是非1和3解除公司绑定
        if (!empty($invalid_customers_number_not)) {
            $this->deleteManageCompanyTo($invalid_customers_number_not);
        }

        if (!empty($invalid_customers_number)) {
            $this->updateCustomer($invalid_customers_number, $adminArr);
            $this->updateCustomerOffline($invalid_customers_number, $adminArr);
            $this->updateManageCompanyTo($invalid_customers_number, $adminArr);
        }
    }
}
