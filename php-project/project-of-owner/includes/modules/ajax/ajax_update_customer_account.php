<?php

use App\Services\Customers\CustomerService;
use App\Request\AccountSettingRequest;
use App\Services\Admins\AdminService;
use App\Services\Common\ApiResponse;
use App\Services\Subscription\SubscriptionService;
use App\Services\NsManages\NsSubscriptService;

//语言包可以单独调用
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require_once($language_page_directory . 'views/validation.common.php');
require_once($language_page_directory . 'views/edit_my_account.php');

$api = new ApiResponse();
$action = $_GET['ajax_request_action'];
if (empty($action) || empty($_SESSION['customer_id'])) {
    $redirect_url = zen_href_link(FILENAME_LOGIN);
    $api->setStatus(403)->setMessage(FS_SYSTME_BUSY)->response(['redirect_url'=>$redirect_url]);
}

$validate = new AccountSettingRequest();
$customer = new CustomerService();
/**
 * 表单验证统一返回406
 * 服务器 第三方错误统一500
 * 发送邮件流程需要重构
 */
switch ($action) {
    //更新用户头像
    case 1:
        $data = [
            'type' => 1,
            'customers_photo' => $_FILES['customers_photo']
        ];
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response($error);
        }
        $customer = $customer->setCustomer();
        $updateInto = $customer->updateCustomerPhoto('customers_photo');
        if ($updateInto['code'] == 1) {
            $api->setMessage(FS_UPDATE_SUCCESS_PHOTO)->response(['path' => $updateInto['path']]);
        } else {
            $api->setStatus(406)->setMessage("error")->response(['customers_photo' => $updateInto['error'][0]]);
        }
        break;
    //更新用户姓名
    case 2:
        $firstName = zen_db_input($_POST['firstName']);
        $lastName = zen_db_input($_POST['lastName']);
        $data = [
            'customers_firstname' => $firstName,
            'customers_lastname' => $lastName,
            'type' => 2
        ];
        $customer = $customer->setCustomer();
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response($error);
        }
        try {
            unset($data['type']);
            $customer->updateCustomerInfo($data);
            $_SESSION['customer_first_name'] = $firstName;
            $api->setMessage(FS_UPDATE_SUCCESS_NAME)->response();
        } catch (Exception $e) {
            $api->setStatus(500)->setMessage($e->getMessage())->response();
        }
        break;
    //更新用户邮箱
    case 3:
        $password = zen_db_prepare_input($_POST['customers_password']);
        $email = zen_db_input($_POST['customers_email_address']);
        $reEmail = zen_db_input($_POST['customers_reEmail']);
        $bool = $customer->setField(['customers_password'])->setCustomer()->checkPassword($password);
        $customer = $customer->setCustomer();
        $data = [
            'customers_password' => $password,
            'customers_email_address' => $email,
            'customers_reEmail' => $reEmail,
            'type' => 3
        ];

        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response($error);
        }
        if (!$bool) {
            $api->setStatus(406)->setMessage('error')->response(['customers_password' => FS_PASSWORD_ERROR_TIP]);
        }
        $checkEmail = $customer->checkEmail($email);
        if (!$checkEmail) {
            $api->setStatus(406)->setMessage('error')
                ->response(['customers_email_address' => FS_EMAIL_HAS_REGISTERED_TIP]);
        }
        unset($data['type']);
        unset($data['customers_reEmail']);
        unset($data["customers_password"]);
        try {
            $customer->updateCustomerInfo($data);
            $companyEmail['company_email'] = $data['customers_email_address'];

            //更新注册分配表信息
            $customer->updateCustomerAutoGivenInfo('', $email);
            //更新 客户关联信息
            $customer->updatePartnerInfo($companyEmail);
            //更新客户邮件更新日志
            $customer->createEditEmailLog();
            // 给新旧邮箱都发邮件
            $old_email = $customer->currentCustomer->customer_email_address?$customer->currentCustomer->customer_email_address:$_SESSION['customers_email_address'];
            $firstName = $customer->currentCustomer->customers_firstname?$customer->currentCustomer->customers_firstname:$_SESSION['customer_first_name'];
            $lastName = $customer->currentCustomer->customers_lastname?$customer->currentCustomer->customers_lastname:$_SESSION['customer_last_name'];
            sendEmailModifySuccessEmail($email, ucwords($firstName . ' ' . $lastName), $old_email, $email);

            //给对应销售发邮件
            $admin = new AdminService();
            //根绝当前客户获取 对应销售信息
            $admin_info = $admin->getAdminByCustomer();
            if (!empty($admin_info)) {
                $admin_id = $admin_info->admin_id;
                $current_admin = $admin->setAdmin($admin_id)->currentAdmin;
                if (isset($current_admin) && isset($current_admin->admin_email)) {
                    sendEmailModifySuccessEmailToSaler($current_admin->admin_email, $current_admin->admin_name
                        , $firstName . '.' . $lastName, $old_email, $email);
                }
            }
            //清除登录信息重新登录
            remove_login_id(true);
            zen_session_destroy();
            $redirect_url = zen_href_link(FILENAME_LOGIN);
            $api->setMessage(FS_UPDATE_SUCCESS_EMAIL)->response(['redirect_url' => $redirect_url]);

        } catch (Exception $e) {
            $api->setStatus(422)->setMessage(FS_SYSTME_BUSY)->response();
        }
        break;
    //更新订阅信息
    case 4:
        $newsLetter = (int)$_POST['newsletter'];
        $message = FS_UPDATE_SUCCESS_SUB;
        $comment_mail_subscribe = (int)$_POST['comment_mail_subscribe'];
        $data = [
            'type' => 4,
            'newsletter' => $newsLetter,
            'comment_mail_subscribe' => $comment_mail_subscribe,
        ];
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response($error);
        }
        $admin = new AdminService();
        $admin_info = $admin->getAdminByCustomer();
        $customer_info = $customer
            ->setField(['office', 'customers_level', 'customers_birthday'])
            ->setLoadCountry(true)
            ->setLoadPosition(true)
            ->setCustomer()->currentCustomer;

        //发送邮件给销售
        if (!empty($admin_info)) {
            $admin_id = $admin_info->admin_id;

            /**
             * 这段代码因为邮件的原因后面需要重构
             */
            $current_admin = $admin->setAdmin($admin_id)->currentAdmin;
            $admin_name = $current_admin->admin_name;
            $admin_email = $current_admin->admin_email;
            $customer_first_name = $customer_info->customers_firstname;
            $customer_last_name = $customer_info->customers_lastname;
            $customer_email = $customer_info->customers_email_address;

            $html = common_email_header_and_footer('Marketing Emails', '', '');
            $html_msg['EMAIL_HEADER'] = $html['header'];
            $html_msg['EMAIL_FOOTER'] = $html['footer'];
            $html_msg['NAME'] = $admin_name;
            $html_msg['CUSTOMER_NAME'] = $customer_first_name . ' ' . $customer_last_name;
            $html_msg['CUSTOMER_EMAIL'] = $customer_email;
            $regular = $week = $month = $never = 'no';
            if ($newsLetter == 0) {
                $never = 'yes';
            } elseif ($newsLetter == 1) {
                $regular = 'yes';
            } elseif ($newsLetter == 2) {
                $week = 'yes';
            } elseif ($newsLetter== 3) {
                $month = 'yes';
            }
            $html_msg['NEVER'] = $never;
            $html_msg['REGULAR'] = $regular;
            $html_msg['WEEK'] = $week;
            $html_msg['MONTH'] = $month;

            $email_title = 'email subscription';
            sendwebmail(
                $admin_name,
                $admin_email,
                '客户订阅邮件通知' . $admin_email .
                date('Y-m-d H:i:s', time()), STORE_NAME, $email_title, $html_msg,
                'admin_subscription', 81, '');

            //同步第三方接口数据， customers_level为E或者D时，同步到DMT平台

//            if(in_array($customer_info->customers_level,['D','E'])){
                if (!empty($customer_info)) {
                    $customer_info = $customer_info->toArray();
                    $customer_info['admin_name'] = $admin_name;
                    $customer_info['admin_id'] = $admin_id;
                    if(in_array($customer_info->customers_level,['D','E'])) { //同步第三方接口数据， customers_level为E或者D时，同步到DMT平台
                        $subscribe = new SubscriptionService();
                        //取消第三方订阅
                        $bool = $subscribe->setData($customer_info)->requestApi($newsLetter);
                        if (!$bool) {
                            $api->setMessage('error')->setStatus(500)->setMessage(FS_SYSTME_BUSY)->response();
                        }
                    }
                    //跟新customer 数据
                    $data = [
                        'customers_newsletter' => $newsLetter,
                        'comment_mail_subscribe' => $comment_mail_subscribe,
                    ];
                    $customer->updateCustomerInfo($data);
                    $api->setStatus(200)->setMessage($message)->response();
                }
//            }
        }

        break;
    //更新用户密码
    case 5:
        $password = zen_db_prepare_input($_POST['password']);
        $new_password = zen_db_prepare_input($_POST['new_password']);
        $new_password_c = zen_db_prepare_input($_POST['new_password_c']);
        $data = [
            'type' => 5,
            'password' => $password,
            'new_password' => $new_password
        ];
        $validate->data = $data;
        $error = $validate->checkData();
        if (!empty($error)) {
            $api->setStatus(406)->setMessage('error')->response($error);
        }
        $bool = $customer->setField(['customers_password'])->setCustomer()->checkPassword($password);
        $current_customer = $customer->currentCustomer;
        if (!$bool) {
            $api->setStatus(406)->setMessage('error')->response(['password' => FS_OLD_PASSWORD_REASON]);
        }
        if($customer->checkPassword($new_password)){
            $api->setStatus(406)->setMessage('error')->response(['new_password' => FS_PASSWORD_DIFFERENT]);
        }
        $pass_data = array("customers_password" => $new_password);
        $customer->updateCustomerInfo($pass_data);

        sendPwdResetSuccessEmail($current_customer->customers_email_address,
            ucwords($current_customer->customers_firstname .
                ' ' . $current_customer->customers_lastname));

        //密码修改成功，清除登录信息重新登录
        $session_navigation = $_SESSION['navigation'];
        remove_login_id(true);
        zen_session_destroy();
        $_SESSION['navigation'] = $session_navigation;
        $redirect_url = zen_href_link(FILENAME_LOGIN);
        $api->setMessage(FS_UPDATE_SUCCESS_PASSWORD)->response(['redirect_url' => $redirect_url]);
        break;
    //验证邮箱是否注册
    case 6:
        $email = zen_db_input($_POST['customers_email_address']);
        $current_customer = $customer->setCustomer($email);
        echo $current_customer->checkEmail($email) ? 'true' : 'false' ;
        break;
}
