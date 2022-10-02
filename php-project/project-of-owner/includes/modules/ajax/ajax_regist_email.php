<?php

$action = zen_not_null($_GET['ajax_request_action']) ? $_GET['ajax_request_action'] : "";
switch ($action) {
    case 'regist_send_emial' :
        $customers_id = zen_db_prepare_input($_POST['customers_id']);
        $language_code = zen_db_prepare_input($_POST['language_code']);
        $customers_telephone = zen_db_prepare_input($_POST['customers_telephone']);
        $language_id = zen_db_prepare_input($_POST['language_id']);
        $admin_id = zen_db_prepare_input($_POST['admin_id']) ? zen_db_prepare_input($_POST['admin_id']) : zen_get_customer_has_allot_to_admin($customers_id);
        $customer_country_id = zen_db_prepare_input($_POST['customer_country_id']);
        $email_address = zen_db_prepare_input($_POST['customers_email_address']);
        $phone_number = $customers_telephone;
        $language = [
            'en' => 'english',
            'es' => 'Spanish',
            'fr' => 'france',
            'de' => 'german',
            'de-en' => 'german_en',
            'jp' => 'japan',
            'uk' => 'britain',
            'ru' => 'russian',
            'it' => 'italy',
            'au' => 'australia',
        ];
        $language_code = $language[strtolower($language_code)] ? $language[strtolower($language_code)] : 'english';
        $str = DIR_WS_LANGUAGES . $language_code . '.php';
        require_once(DIR_WS_LANGUAGES . strtolower($language_code) . '.php'); // 调用公共的语言包
        // 给对应后台销售发邮件
        $tel_prefix = fs_get_data_from_db_fields('tel_prefix', 'countries', 'countries_id = ' . (int)$customer_country_id, '');
        $customer_number_new = fs_get_data_from_db_fields_array(array('customers_firstname', 'customers_lastname',), 'customers', 'customers_id="' . $customers_id . '"', 'limit 1');
        $sales_email = zen_admin_email_of_id($admin_id);
        $firstname = $customer_number_new[0][0];
        $lastname = $admin_data[0][1];
        $admin_email = $admin_data[0][1];
        $html = zen_get_corresponding_languages_email_common();
        $html_msg['EMAIL_HEADER'] = $html['html_header'];
        $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
        $html_msg['CUSTOMER_NAME'] = $firstname . $lastname ? $firstname . $lastname : 'not set yet';
        $html_msg['NUMBER'] = $phone_number ? $tel_prefix . ' ' . $phone_number : 'not set yet';
        $html_msg['EMAIL_ADDRESS'] = $email_address ? $email_address : 'not set yet';

        sendwebmail($sales_email, $sales_email,'注册销售邮件'.$admin_email.date('Y-m-d H:i:s', time()),STORE_NAME, 'Customer Info', $html_msg, 'regist_to_us',81,'');

        //客户注册给对应区域销售发送邮件
        $regional_sales = '';
        if (au_warehouse($customer_country_id)) {
            $regional_sales = 'au@fs.com';
        } elseif (singapore_warehouse('country_number', $customer_country_id)) {
            $regional_sales = 'sg@fs.com';
        } elseif ($customer_country_id == 176) {
            $regional_sales = 'ru@fs.com';
        }
        if (!empty($regional_sales)) {
            sendwebmail($regional_sales, $regional_sales,'注册客服件'.$regional_sales.date('Y-m-d H:i:s', time()),STORE_NAME, 'Customer Info', $html_msg, 'regist_to_us',81,'');
        }
        echo json_encode([
            "code" => 1,
            "success" => 'email send success',
        ]);
        break;
}