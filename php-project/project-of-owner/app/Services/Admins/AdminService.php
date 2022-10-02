<?php


namespace App\Services\Admins;

use App\Models\Admin;
use App\Models\AdminToCustomer;
use App\Services\BaseService;

/**
 * 销售服务者
 *
 * @author aron
 * @date 2019.11.11
 * Class AdminService
 * @package App\Services\Admins
 */
class AdminService extends BaseService
{
    private $admin;
    private $adminToCustomer;
    public $currentAdmin;
    private $fields = [
        'admin_email',
        'admin_name',
        'admin_id'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->admin = new Admin();
        $this->adminToCustomer = new AdminToCustomer();
    }

    /**
     * 设置当前销售信息
     *
     * @param int $adminId
     * @return $this
     */
    public function setAdmin($adminId = 0)
    {
        $this->currentAdmin = $this->admin->select($this->fields)->find($adminId);
        return $this;
    }

    /**
     * 设置查询字段
     *
     * @param array $field
     * @return $this
     */
    public function setField($field = [])
    {
        $this->fields = array_merge($this->fields, $field);
        return $this;
    }

    /**
     * 根据客户id 获取销售信息
     *
     * @param int $customerId
     * @return mixed
     */
    public function getAdminByCustomer($customerId = 0)
    {
        if (empty($customerId)) {
            $customerId = $this->customer_id;
        }
        return $this->adminToCustomer->select('admin_id')
            ->where('customers_id', $customerId)->first();
    }
}
