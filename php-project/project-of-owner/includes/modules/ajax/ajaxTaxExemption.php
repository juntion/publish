<?php

use App\Services\Common\ApiResponse;
use App\Services\Avatax\AvaTaxExemptionsService;
use App\Services\Customers\CustomerService;
use App\Services\Admins\AdminService;
use App\Services\taxExemption\TaxExemptionService;

$avaTaxExemptions = new AvaTaxExemptionsService();
$customer = new CustomerService();
$api = new ApiResponse();
$customers_info = $customer->setCustomer()->currentCustomer;
$customers_number_new = $customers_info->customers_number_new;

$action = trim($_GET['ajax_request_action']) ? trim($_GET['ajax_request_action']) : '';

switch ($action) {
    case "uploadPdf":
        if (!$_POST) {
            echo 1;exit;
        }
        if ($_POST['id']) {
            $customers_info = $customer->setCustomer()->currentCustomer;
            $customers_number_new = $customers_info->customers_number_new;
            $data = $avaTaxExemptions->setCustomers($customers_number_new)->getPdf((int)$_POST['id']);
            if ($data['status']) {
                header('Content-Type:application/pdf;chartset=UTF-8');
                echo $data['data'];exit;
            } else {
                echo 1;exit;
            }
        }else{
            echo 1;exit;
        }
        break;
    case 'getCertificates':
        if (!$_POST) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        if ($_POST['id']) {
            $stateName = '';
            $result = $avaTaxExemptions->setCustomers($customers_number_new)->getCertificates((int)$_POST['id']);
            if ($result['status']) {
                $infoArr = json_decode($result['data'],true);
                if ($infoArr['exposure_zone']['state']) {
                    $stateName =  $infoArr['exposure_zone']['state']['name'];
                    $api->setMessage('success')->setStatus(200)->response(['stateName' => $stateName]);
                }
            }
            if (!$stateName) {
                $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
            }
        }else{
            $api->setMessage(FS_SYSTME_BUSY)->setStatus(500)->response();
        }
        break;
    case 'removeCertificates':
        if (!$_POST) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        if ($_POST['id']) {
            $data = $avaTaxExemptions->setCustomers($customers_number_new)->removeCertificates((int)$_POST['id']);
            if ($data['status']) {
                $taxExemption= new TaxExemptionService();
                $taxExemption->editAvatax($customers_number_new, (int)$_POST['id']);
                $api->setMessage('success')->setStatus(200)->response();
            } else {
                $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
            }

        }else{
            $api->setMessage(FS_SYSTME_BUSY)->setStatus(500)->response();
        }
        break;

    case 'addFsInfo':
        if (!$_POST) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        if ($_POST['certificate_id'] && $_POST['state_check']) {
            $certificate_ids = $_POST['certificate_id'];
            $stateCheck = zen_db_input($_POST['state_check']);
//            $stateCheckArr = explode('|',$stateCheck);
//            $certificate_ids = explode(',',$certificate_id);
            $customer->setField(['customers_level'])->setCustomer();
            $customer_level = $customers_email = '';
            $admin_id = 0;
            if ($customer->currentCustomer) {
                $customer_data = $customer->currentCustomer->toArray();
                $customer_level = $customer_data['customers_level'];
                $customers_email = $customer_data['customers_email_address'];
                $customers_new = $customer_data['customers_number_new'];
                $customers_name = $customer_data['customers_firstname'] . ' ' . $customer_data['customers_lastname'];
                $admin_service = new AdminService();
                $admin_id  = $admin_service->getAdminByCustomer($customer_data['customers_id'])->admin_id;
                if (!$admin_id) {
                    $admin_id = 0;
                }
            }
            $taxExemption= new TaxExemptionService();
            $applyId = $taxExemption->getApplyId($customers_number_new);
            if (!$applyId) {
                $applyData = array(
                    'customers_NO'        =>  $customers_number_new,
                    'country'             =>  'United States',
                    'customers_email'     =>  $customers_email,
                    'customer_grade'      =>  $customer_level,
                    'apply_admin'         =>  $admin_id,
                    'apply_time'          =>  date('Y-m-d h:i:s'),
                    'create_order'        =>  2,
                    'status'              =>  0,
                    'apply_type'          =>  15
                );
                $applyId = $taxExemption->createApplyData($applyData);
            }
            if ($applyId) {
                if ($certificate_ids) {
                    if (is_array($certificate_ids)) {
                        foreach ($certificate_ids as $v) {
                            $avataxData = array(
                                'releate' =>  $applyId,
                                'customers_number_new' => $customers_number_new,
                                'state' => $stateCheck,
                                'avatax_certificate_id' => $v ? $v :0,
                                'create_time' => date('Y-m-d h:i:s'),
                            );
                            $taxExemption->createAvatax($avataxData);
                        }
                    } else {
                        $avataxData = array(
                            'releate' =>  $applyId,
                            'customers_number_new' => $customers_number_new,
                            'state' => $stateCheck,
                            'avatax_certificate_id' => $certificate_ids,
                            'create_time' => date('Y-m-d h:i:s'),
                        );
                        $taxExemption->createAvatax($avataxData);
                    }
                    //发邮件
                    $admin_info = $admin_service->setAdmin($admin_id)->currentAdmin;
                    if ($admin_info) {
                        $admin_name = $admin_info['admin_name'];
                        $admin_email = $admin_info['admin_email'];
                    }
                    $taxArray = [
                        'admin_name'    =>  $admin_name,
                        'admin_email'   =>  $admin_email,
                        'state'         =>  $stateCheck,
                        'customers_name' => $customers_name,
                        'customers_email'=> $customers_email,
                        'customers_new' => $customers_new

                    ];
                    sendTaxExemptionEmail($taxArray);
                    $api->setMessage('success')->setStatus(200)->response();
                } else {
                    $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
                }
            }
        } else {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        break;
}