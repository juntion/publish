<?php

/**
 * 作用： 注册客户半小时之后才分配
 * 背景： 原有流程无法进行补客户
 */

require_once 'CommandBaseRequired.php';

use App\Models\CustomersRegisterAllot;
use App\Models\Customer;
use App\Services\Customers\CustomerService;
use App\Services\AdminCustomers\AdminCustomersService;
use App\Services\RepeatCustom\RepeateCustomService;
use App\Services\LiveChat\LiveChatAdminService;
use App\Services\AutoGiven\AutoGivenService;
use App\Models\AllotLog;
use App\Services\Email\Base\SendEmailService;
use App\Services\Email\Base\EmailTemplateService;
use App\Models\Admin;
use App\Models\Countries;
use App\Models\DebugData;
use Illuminate\Database\Capsule\Manager as DB;


// 当前注册并未分配的客户
$customer_register_allot_obj = new CustomersRegisterAllot();
$customers_obj = new CustomerService();
$admin_to_customers_obj = new AdminCustomersService();
$repeat_custom_obj = new RepeateCustomService();
$allotLog = new AllotLog();
$live_chat_obj = new LiveChatAdminService();
$customers_model = new Customer();
$admin_obj = new Admin();
$countries_obj = new Countries();
$sendService = new SendEmailService();
$templateService = new EmailTemplateService();



$auto_given_obj = new AutoGivenService();
while (true) {
// 当前时间差
    $time = time();
    $start = $time - 30 * 60;
    $allot_register = $customer_register_allot_obj->onWriteConnection()
        ->where('create_time', '<', $start)
        ->where('is_allot', 0)
        ->limit(1)
        ->orderBy('id', 'desc')
        ->get()
        ->toArray();

    $email_data_all = $allot_register_info = $allot_register[0];
    if (empty($allot_register_info)) {
        time_sleep_until(60 + time());
        continue;
    }
    $is_make_up = 0;
    $error = [];
    try {
//        $admin_info = $customers_obj->getAdminId($allot_register_info);
        $admin_info = $auto_given_obj->getAdminId($allot_register_info);
    } catch (\Exception $e) {
        $error['err_0'] = $e->getMessage();
    }
    $admin_id = $admin_info['admin_id'];
    $admin_id_from_table = $admin_info['admin_id_from_table'];
    $is_old = $admin_info['is_old'];

    if ($allot_register_info['customer_country_id'] == 176) {
        $allot_register_info['language_id'] = 4;
    }
    //无效客户标记
    $allot_register_info['invalidSign'] = $admin_info['invalidSign'];
    $allot_register_info['customer_number'] = $admin_info['customer_number'];
    $allot_register_info['customer_offline_number'] = $admin_info['customer_offline_number'];

    $compensate_at = date("Y-m-d H:i:s");
    if (!$admin_id) {
        $repeat_type = 10;
        try {
            $is_apply_info = $repeat_custom_obj->getRepeateApply($allot_register_info, $repeat_type);
        } catch (\Exception $e) {
            $error['err_1'] = $e->getMessage();
        }
        $is_apply = $is_apply_info['id'] ? $is_apply_info['id'] : '';
        $is_apply_sale_id = $is_apply_info['sale_id'] ? $is_apply_info['sale_id'] : '';
        date_default_timezone_set("Asia/Shanghai");
        $transChinaTime = date("Y-m", time());  //转换为国内时间
        date_default_timezone_set("America/Los_Angeles");
        if ($is_apply) {
            try {
                $result = $repeat_custom_obj->updateRepeateDdistribution($allot_register_info, $compensate_at, $is_apply);
                $admin_id = $is_apply_sale_id;
                $is_make_up = 1;
                $admin_id_from_table = 'repeat_custom_distribution';
            } catch (\Exception $e) {
                $error['err_2'] = $e->getMessage();
                $result = false;
            }
        } else {
            $admin_id_from_table = 'live_chat_admin';
            //查询当前循环到哪个销售  客户分配处理
            try {
                $admin_id = $live_chat_obj->getCommonFun($allot_register_info);
            } catch (\Exception $e) {
                $error['err_3'] = $e->getMessage();
            }
        }
    }
    $allotLog = new AllotLog();
    $allot_log = [
        'customers_email' => $allot_register_info['customers_email_address'],
        'admin_id' => $admin_id,
        'admin_id_from_table' => $admin_id_from_table,
        'type' => 'register',
        'add_time' => date('Y-m-d H:i:s', time()),
        'loop_field' => 'is_beforeadmin',
        'is_old' => $is_old,
        'is_make_up' => $is_make_up ? $is_make_up : 0,
        'customers_country_id' => $allot_register_info['customer_country_id'],
        'language_id' => $allot_register_info['language_id'],
        'time_flow' => time(),
    ];
    try {
        $res = $allotLog->insert($allot_log);
        $customers_model->where(['customers_id' => $allot_register_info['customers_id']])->update([
            'is_old' => $is_old ? $is_old : 0,
            'is_make_up' => $is_make_up ? $is_make_up : 0
        ]);
    } catch (\Exception $e) {
        $error['err_4'] = $e->getMessage();
    }
    $data = [];
    if ($admin_id) {
        $admin_info = $admin_to_customers_obj->getAdmininfo($allot_register_info['customers_id']);
        if (empty($admin_info->admin_id)) {
            if (empty($admin_info->customers_id)) {
                try {
                    $date = $auto_given_obj->getCommonCnTime();
                    $res = $admin_to_customers_obj->insertAdminCustomer($allot_register_info['customers_id'], $admin_id, $date);
                } catch (\Exception $e) {
                    $error['err_5'] = $e->getMessage();
                }
            }

        // 客户自动关联
            if ($admin_id) {
                $is_online = 1;
                try {
    //                $res = $customers_obj->autoGivenCustomerManage($admin_id, $allot_register_info, $is_online, $data);
                    $res = $auto_given_obj->autoGivenCustomerManage($admin_id, $allot_register_info, $is_online, $data);
                } catch (\Exception $e) {
                    $error['err_6'] = $e->getMessage();
                }
            }
        // fairy 2018.8.31 add 如果不是公共后缀邮箱，把公海中相同后缀也分配
            try {
                $admin_to_customers_obj->autoGivenOpenSeas($allot_register_info, $admin_id);
            } catch (\Exception $e) {
                $error['err_7'] = $e->getMessage();
            }
        }
    }
    if ($email_data_all['customers_id']) {
        $data = [
            'customers_id' => $email_data_all['customers_id'],
            'customers_email_address' => $email_data_all['customers_email_address'],
            'language_code' => $email_data_all['language_code'],
            'customers_telephone' => $email_data_all['customers_telephone'],
            'language_id' => $email_data_all['language_id'],
            'admin_id' => $admin_id,
            'customer_country_id' => $email_data_all['customer_country_id'],
        ];
        // 发送邮件
        $auto_given_obj->sendEmail($data);
    }

    try {// 更新脚本的分配情况
        $isUpdated = $customer_register_allot_obj->where('id', $allot_register_info['id'])->update(['is_allot' => 1]);
        if ($isUpdated != 1) {
            throw new Exception("Update failed");
        }
    } catch (\Exception $e) {
        $error['err_8'] = $e->getMessage();
    }
    if (empty($error)) {
        queueLogReport('success', [
            'email' => $allot_register_info['customers_email_address'],
            'reason' => $error,
        ]);
        (new DebugData())->insert([
            'data' => json_encode(['email' => $allot_register_info['customers_email_address'], 'reason' => $error, 'type' => 'customersRegisterAllot-success']),
        ]);
    } else {
        queueLogReport('failed', [
            'email' => $allot_register_info['customers_email_address'],
            'reason' => $error,
        ]);
        (new DebugData())->insert([
            'data' => json_encode(['email' => $allot_register_info['customers_email_address'], 'reason' => $error, 'type' => 'customersRegisterAllot-failed']),
        ]);

        //如果报错，唤醒时间为60s
        time_sleep_until(60 + time());
        continue;
    }
}
