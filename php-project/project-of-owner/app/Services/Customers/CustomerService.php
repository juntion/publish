<?php


namespace App\Services\Customers;

use App\Exception\EmptyDataException;
use App\Models\BlackMailSuffix;
use App\Models\CompanyToCustomer;
use App\Models\CustomersOffline;
use App\Models\PartnerRegister;
use App\Services\BaseService;
use App\Models\Customer;
use App\Models\CustomersRegisterAllot;

use App\Models\CustomerOldEmail;




use App\Services\Common\Upload\UploadService;


use Aws\CloudFront\Exception\Exception;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Capsule\Manager as DB;

class CustomerService extends BaseService
{
    //customer model
    private $customerModel;
    public $currentCustomer;
    private $customerOldEmail;
    private $partnerRegister;
    //是否关联country表
    private $isLoadCountry = false;
    //是否关联客户职位表
    private $isLoadPosition = false;
    //线下客户表
    private $customerOffline;
    //线下客户关联公司表
    private $companyToCustomer;
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
    private $manageCustomerdisable;

    private $adminToCustomerModel;
    //注册分配脚本表
    private $customersRegisterAllot;
    /**
     * 默认查询字段
     *
     * @var array
     */
    private $fields = [
        'customers_id',
        'customers_firstname',
        'customers_lastname',
        'customers_authorization',
        'customers_number_new',
        'customers_email_address',
        'customer_country_id'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new Customer();
        $this->customerOldEmail = new CustomerOldEmail();
        $this->partnerRegister = new PartnerRegister();
        $this->customerOffline = new CustomersOffline();
        $this->companyToCustomer = new CompanyToCustomer();
        $this->customersRegisterAllot = new CustomersRegisterAllot();
    }

    /**
     * 设置查询字段
     *
     * @param array $field
     * @return $this
     */
    public function setField($field = [])
    {
        if (!is_array($field)) {
            $field = [$field];
        }
        $this->fields = array_merge($this->fields, $field);
        return $this;
    }

    /**
     * 设置是否关联 country表
     *
     * @param bool $bool
     * @return $this
     */
    public function setLoadCountry($bool = false)
    {
        $this->isLoadCountry = $bool;
        return $this;
    }

    /**
     * 设置是否关联客户职位表
     *
     * @param bool $bool
     * @return $this
     */
    public function setLoadPosition($bool = false)
    {
        $this->isLoadPosition = $bool;
        return $this;
    }


    /**
     * 设置当前查询客户
     *
     * @param int $customer_id
     * @param string $customer_email
     * @return $this
     */
    public function setCustomer($customer_id = 0, $customer_email = "")
    {
        if (!$customer_id) {
            $customer_id = $this->customer_id;
        }

        if ($customer_email) {
            $this->currentCustomer = $this->customerModel->select($this->fields)
                ->where('customers_email_address', $customer_email)
                ->first();
        } else {
            $this->currentCustomer = $this->customerModel->select($this->fields)->find($customer_id);
        }
        if ($this->isLoadCountry) {
            $this->currentCustomer->load(['country' => function ($query) {
                $query->select(['countries_id', 'countries_chinese_name', 'countries_name', 'countries_iso_code_2']);
            }]);
        }
        if ($this->isLoadPosition) {
            $this->currentCustomer->load(['position' => function ($query) {
                $query->select(['position_name', 'position_id']);
            }]);
        }
        return $this;
    }


    /**
     * 获取当前客户公司下 关联的其他所有客户id
     *
     *
     * @return array
     */
    public function getCompanyAllCustomers()
    {
        $customers_id = [];
        if (isset($this->currentCustomer)) {
            $customerData = $this->currentCustomer->toArray();
            if ($customerData['customer_link_account'] == 1) {
                //当前客户的customer_link_account=1 允许查看同公司下的其他客户的所有订单
                $companyToCustomer = $this->companyToCustomer;
                //查找公司编号
                $companyNumber = $companyToCustomer
                    ->where('customers_number_new', $customerData['customers_number_new'])
                    ->pluck('company_number');
                if ($companyNumber) {
                    //查找公司下的所有其他账号
                    $allCustomer = $companyToCustomer
                        ->with(
                            [
                                'customer' => function ($query) {
                                    $query->select(['customers_number_new', 'customers_id']);
                                }
                            ]
                        )
                        ->where('company_number', $companyNumber)
                        ->select(['customers_number_new'])
                        ->get();
                    if ($allCustomer) {
                        $allCustomer = $allCustomer->toArray();
                        foreach ($allCustomer as $key => $value) {
                            if ($value['customer']['customers_id']) {
                                $customers_id[] = $value['customer']['customers_id'];
                            }
                        }
                    }
                }
            }
        }
        if (empty($customers_id)) {
            $customers_id[] = $this->customer_id;
        }
        return $customers_id;
    }

    /**
     * 跟新客户信息
     *
     * @param array $customerInfo
     */
    public function updateCustomerInfo($customerInfo = [])
    {
        if (!empty($customerInfo['customers_password'])) {
            $customerInfo['customers_password'] = $this->enctypePassword($customerInfo['customers_password']);
        }
        $this->customerModel->where('customers_id', $this->customer_id)->update($customerInfo);
    }

    /**
     * 更新企业客户信息
     *
     * @param array $data
     */
    public function updatePartnerInfo($data = [])
    {
        $this->partnerRegister->where('company_email', $this->currentCustomer->customers_email_address)->update($data);
    }

    /**
     * 更新客户头像
     *
     * @param string $fileInput
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateCustomerPhoto($fileInput = '')
    {
        $upload = new UploadService();
        $photo_dir = 'profile/' . $this->customer_id;
        $upload->setConfig(['fileSize' => '300k', 'savePath' => $photo_dir]);
        $bool = $upload->upload($fileInput);
        if ($bool) {
            $data = [
                'customer_photo' => $upload->storagePath
            ];
            $this->updateCustomerInfo($data);
            return ['code' => 1, 'path' => $upload->storagePath, 'errors' => []];
        } else {
            return ['code' => 0, 'message' => '', 'error' => $upload->errors];
        }
    }

    /**
     * 检验客户密码
     *
     * @param string $password
     * @return bool
     */
    public function checkPassword($password = "")
    {
        if (isset($this->currentCustomer)) {
            $db_password = $this->currentCustomer->customers_password;
            return $this->validatePassword($password, $db_password);
        }
        return false;
    }

    /**
     * 检测邮箱是否注册
     *
     * @param string $email
     * @return bool
     */
    public function checkEmail($email = "")
    {
        $customer = $this->customerModel->select($this->fields)
            ->where('customers_email_address', $email)
            ->first();
        $partner = $this->partnerRegister->where('company_email', $email)->first();
        if (!empty($customer) || !empty($partner)) {
            return false;
        }
        return true;
    }


    /**
     * 密码验证
     *
     * @param String $plain
     * @param string $encrypted
     * @return bool
     */
    private function validatePassword($plain = '', $encrypted = '')
    {
        if (!empty($encrypted) && !empty($plain)) {
            $stack = explode(':', $encrypted);

            if (sizeof($stack) != 2) {
                return false;
            }

            if (md5($stack[1] . $plain) == $stack[0]) {
                return true;
            }
        }

        return false;
    }

    /**
     * 加密密码
     *
     * @param string $plain
     * @return string
     */
    public function enctypePassword($plain = '')
    {
        $password = '';

        for ($i = 0; $i < 10; $i++) {
            $password .= self::zenRand();
        }

        $salt = substr(md5($password), 0, 2);

        $password = md5($salt . $plain) . ':' . $salt;

        return $password;
    }

    /**
     * 更新账户修改记录
     *
     * @param array $data
     * @author aron
     * @date 2019.11.11
     */
    public function createEditEmailLog()
    {
        $old_emails_data = array(
            'customers_id' => $this->customer_id,
            'email' => $this->currentCustomer->customers_email_address,
            'created_person' => $this->customer_id,
            'updated_person' => $this->customer_id,
            'created_at' => time(),
            'updated_at' => time()
        );
        $this->customerOldEmail->create($old_emails_data);
    }

    /**
     * 获取企业用户折扣率
     * @return int
     */
    public function getCustomerRate()
    {
        $rate_info = $this->customerModel->where('customers_id', $this->customer_id)
            ->first(['discount_rate', 'member_level'])
            ->toArray();
        $rate = !empty($rate_info['member_level']) && !empty($rate_info['discount_rate'])
            ? $rate_info['discount_rate'] : 1;
        return $rate;
    }

    /**
     * 获取客户信息
     *
     * @return mixed
     */
    public function getCustomerInfo()
    {
        if (isset($this->currentCustomer->customer_photo)) {
            $this->currentCustomer->customer_photo = self::imagePath(self::trans('DIR_WS_IMAGES') .
                $this->currentCustomer->customer_photo);
        }
        $this->currentCustomer->customerFirstNameFirstWord = substr(
            $this->currentCustomer->customers_firstname,
            0,
            1
        );
        return $this->currentCustomer;
    }

    /**
     * 判断当前客户是否为飞速账号
     *
     * @return bool
     */
    public function isFsAccount()
    {
        if (!empty($this->currentCustomer)) {
            $customer_email = $this->currentCustomer->customers_email_address;
            $mail_suffix = strrchr($customer_email, '@');
            if (in_array($mail_suffix, array('@fs.com', '@feisu.com', '@szyuxuan.com'))) {
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * 获取客户公司编号
     *
     * @return string
     */
    public function getCompanyNumber()
    {
        if (!empty($this->currentCustomer)) {
            $customers_number_new = $this->currentCustomer->customers_number_new;
            $customer_email_address = $this->currentCustomer->customers_email_address;
            if (!$customers_number_new && !empty($customer_email_address)) {
                $customers_number_info = $this->customerOffline->select('customers_number_new')
                    ->where('customers_email_address', $customer_email_address)
                    ->first();
                if (!empty($customers_number_info)) {
                    $customers_number_new = $customers_number_info->customers_number_new;
                }
            }
            if ($customers_number_new) {
                $company_number_info = $this->companyToCustomer->select('company_number')
                    ->where('customers_number_new', $customers_number_new)->first();
                if (!empty($company_number_info)) {
                    $company_number = $company_number_info->company_number;
                    return $company_number;
                }
                return "";
            }
        }
        return "";
    }

    /**
     * 获取线下客户的一些信息
     * @param string $customer_id 用户customers_id
     * @param string $customer_email 用户邮箱
     * @param array $fields 查询的字段
     * @return mixed
     */
    public function getOfflineCustomer($customer_id = '', $customer_email = '', $fields = [])
    {
        if ($customer_id) {
            return $this->customerOffline->select($fields)->where('customers_id', $customer_id)->first();
        }
        if ($customer_email) {
            return $this->customerOffline->select($fields)->where('customers_email_address', $customer_email)->first();
        }
    }

    public function checkBlack()
    {
        if (isset($this->currentCustomer->customers_authorization)
            && $this->currentCustomer->customers_authorization == 4
        ) {
            return true;
        }
        return false;
    }

    public function checkBlackEmail($email)
    {
        $black_email_list = [];
        if (strpos($email, "@") !== false) {
            $translate_email = explode("@", $email);
            $suffix = "@" . $translate_email[1];
            $black_email_list = (new BlackMailSuffix())
                ->select(['id'])
                ->where('mail_suffix', $email)
                ->orwhere('mail_suffix', $suffix)
                ->get();
        }
        return count($black_email_list);
    }

    /**
     * Notes:得到客户信息
     * User: LiYi
     * Date: 2020/8/11 0011
     * Time: 18:23
     * @param bool $type
     * @return array
     */
    public function firstCustomer($customers_id = '')
    {
        if(empty($customers_id)){
            $customers_id = $this->customer_id;
        }

        try {
            $result = $this->customerModel->where('customers_id', $customers_id)
                ->with(['adminToCustomer' => function ($query) {
                    $query->select("admin.admin_name", "admin.admin_id", "admin.admin_email", "admin.code_email")->first();
                }])
                ->first($this->fields);
            if (empty($result)) {
                throw new \Exception('客户信息不存在！');
            }
            $result = $result->toArray();

            if (!empty($result['admin_to_customer'])) {
                $result['admin_to_customer'] = $result['admin_to_customer'][0];
            }
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }

    /**
     * Note: 如果在注册半小时内，客户更改邮箱，停止注册分配脚本
     * @author: Dylan
     * @Date: 2020/9/14
     *
     * @param int $customers_id
     * @param string $customer_email_address
     */
    public function updateCustomerAutoGivenInfo($customers_id = 0, $customer_email_address = '')
    {
        if (!$customers_id) {
            $customers_id = $this->customer_id;
        }
        if (strpos($customer_email_address, "@") !== false) {
            $translate_email = explode("@", $customer_email_address);
            $prefix_email = $translate_email[0] . '@';
            $postfix_email = "@" . $translate_email[1];
            $data = array(
                'customers_email_address' => $customer_email_address,
                'prefix_email' => $prefix_email,
                'postfix_email' => $postfix_email,
            );
            $this->customersRegisterAllot->where('customers_id', $customers_id)->update($data);
        }
    }
}
