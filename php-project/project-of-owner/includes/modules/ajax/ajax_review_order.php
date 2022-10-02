<?php

use App\Services\Common\ApiResponse;
use App\Services\Orders\OrderReviewService;
use App\Request\OrdersReviewRequest;
use App\Services\Customers\CustomerService;
use App\Services\Admins\AdminService;
use App\Services\Scene\SceneService;

$action = trim($_GET['ajax_request_action']) ? trim($_GET['ajax_request_action']) : '';

//语言包可以单独调用
$language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
require_once($language_page_directory . 'views/validation.common.php');
require_once($language_page_directory . 'views/edit_my_account.php');

$api = new ApiResponse();

switch ($action) {
    case "reviewOrder":
        if (!$_POST) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        if (empty($_SESSION['customer_id'])) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        $orders_id = $_POST['orders_id'] ? (int)($_POST['orders_id']) : '';
        $oPid = $_POST['ordersProductId'] ? (int)($_POST['ordersProductId']) : "";
        if (empty($orders_id) || empty($oPid)) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        //判断当前订单是否为当前客户,如果根据当前客户无法查出评价数据,则无法评价
        $orderReviewService = new OrderReviewService();
        $check = $orderReviewService->isAllowVisit($orders_id);
        if (empty($check)) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }
        $reviewInfo = $orderReviewService->getReviewInfo($orders_id, $oPid);
        //如果根据当前客户无法查出评价数据,则无法评
        if (empty($reviewInfo)) {
            $api->setMessage(FS_ACCESS_DENIED)->setStatus(403)->response();
        }

        $reviewInfo = $reviewInfo[0];
        $products_id = $reviewInfo['products_id'];

        //星级评分
        $rating = $_POST['rating'] ? zen_db_prepare_input($_POST['rating']) : '';
        $headline = $_POST['headline'] ? zen_db_prepare_input($_POST['headline']) : '';
        $review_content = $_POST['review_content'] ? str_replace(array('\r\n','\n'), '<br/>', zen_db_prepare_input($_POST['review_content'])) : '';
        $equipment_mode = $_POST['equipment_mode'] ? zen_db_prepare_input($_POST['equipment_mode']) : '';
        $tag_info = $_POST['tag_info'] ? $_POST['tag_info'] : "";
        $tag_info = json_decode($_POST['tag_info'], true);

        /*评论服务*/
        $product_quality = (int)$_POST['product_quality'];
        $price = (int)$_POST['price'];
        $pre_sale_service = (int)$_POST['pre_sale_service'];
        $logistics_service = (int)$_POST['logistics_service'];
        $others = (int)$_POST['others'];

        //剔除内部人员邮箱
        $customer = new CustomerService();
        $current_customer = $customer->setCustomer();
        $check_status = 1;
        //如果为fs内部账号
        if ($current_customer->isFsAccount()) {
            $check_status = 2;
        }
        //1-3星评论需要进行审核
        if (in_array($rating, [1, 2, 3])) {
            $check_status = 0;
        }

        //判断1-2星邮件内容
        if (in_array($rating, [1, 2])) {
            $email_content = false;
        }else{
            $email_content = true;
        }

        //tag图数据处理
        $tagAnchorData = [];
        if ($tag_info) {
            foreach ($tag_info as $tag_k => $tag_v) {
                if ($tag_v['img_content']) {
                    foreach ($tag_v['img_content'] as $img_k => $img_v) {
                        $pid = $img_v['pid'] ? (int)$img_v['pid'] : "";
                        $text = $img_v['txt'] ? $img_v['txt'] : "";
                        $toward = $img_v['toward'];
                        $tagAnchorData[$tag_v['img_id']][] = [
                            'products_id' => $pid,
                            'auto_desc' => $text,
                            'toward' => $toward,
                            'left' => $img_v['left'],
                            'top' => $img_v['top'],
                            'create_time' => date('Y-m-d'),
                            'update_time' => date('Y-m-d'),
                        ];
                    }
                }
            }
        }
        $orderRequest = new OrdersReviewRequest();
        $data = [
            'reviews_rating' => $rating,
            'reviews_headline' => $headline,
            'reviews_text' => $review_content,
            'product_quality' => $product_quality,
            'price' => $price,
            'pre_sale_service' => $pre_sale_service,
            'logistics_service' => $logistics_service,
            'others' => $others
        ];

        $orderRequest->data = $data;
        $error = $orderRequest->checkData();
        if (!empty($error)) {
            $api->setMessage('error')->setStatus(406)->response($error);
        }
        $reviews_data = array(
            'products_id' => $products_id,
            'customers_id' => (int)$_SESSION['customer_id'],
            'reviews_rating' => $rating,
            'reviews_type' => 2,
            'date_added' => date("Y-m-d"),
            'last_modified' => date("Y-m-d"),
            'reviews_read' => 0,
            'orders_products_id' => $oPid,
            'languages_id' => (int)$_SESSION['languages_id'],
            'product_quality' => $product_quality,
            'price' => $price,
            'pre_sale_service' => $pre_sale_service,
            'logistics_service' => $logistics_service,
            'others' => $others,
            'check_status' => $check_status,
            'equipment_mode' => $equipment_mode,
        );
        $reviewDescription = [
            'languages_id' => (int)$_SESSION['languages_id'],
            'reviews_text' => $review_content,
            'reviews_headline' => $headline
        ];
        $data = [
            'reviewData' => $reviews_data,
            'reviewDescription' => $reviewDescription,
            'orders_id' => $orders_id,
            'files' => $_FILES['reviews_img'],
            'tagAnchorData' => $tagAnchorData,
        ];
        $return = $orderReviewService->addReview($data);

        $sceneService = new SceneService();
        $tempResult = $sceneService->existsAdvance();

        if (!$tempResult) {
            $resultStatus = 1;
        } else {
            $resultStatus = 0;
        }

        if($return){
            $admin = new AdminService();
            $admin_id = $admin->getAdminByCustomer();
            $adminInfo = $admin->setAdmin($admin_id->admin_id)->currentAdmin;
            /*
             * 邮件重构后这一块重写
             */
            if(!empty($adminInfo)){
                $admin_id = $adminInfo->admin_id;
                $admin_name = $adminInfo->admin_name;
                $admin_email = $adminInfo->admin_email;
                $customer_email_address = $_SESSION['customers_email_address'];
                $customers_name = $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name'];
                $send_to_email = 'legal@fs.com';
                $send_to_name = STORE_NAME;
                $email_html = zen_get_corresponding_languages_email_common();
                $html_msg['EMAIL_HEADER'] = $email_html['html_header'];
                $html_msg['EMAIL_FOOTER'] = $email_html['html_footer'];
                $html_msg['CUSTOMERS_NAME'] = $admin_name;
                $html_msg ['BACKEND_COMMON_BODY'] = '';
                $text_message = FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME;
                $href = zen_href_link(FILENAME_PRODUCT_INFO . "&products_id=$products_id");
                $html_msg ['BACKEND_COMMON_BODY'] .= "<p>" . EMAIL_BODY_COMMON_CUSTOMER_NAME . "<span>"
                    . $customers_name . "</span></p>
                        <p>" . EMAIL_BODY_COMMON_CUSTOMER_EMAIL . "<span>" . $customer_email_address . "</span></p>
                        <p>" . FS_REVIEWS_URL . ": <span><a style=\"color:#a10000;\" href=" . $href . ">"
                    . zen_get_products_name($products_id, 1) . "</a></span></p>
                        <p>" . FS_REVIEW_RATING . ": <span>" . $rating . "</span></p>
                        <p>" . FS_REVIEW_CONTENT . ": <span style=\"color: #616265;\">" . $review_content . "</span></p>";

                sendwebmail($admin_name, $admin_email, '感谢客户写订单反馈邮件:' .
                    date('Y-m-d h:i:s', time()), $send_to_name, $text_message, $html_msg, 'backend_common');

                /*4,5行评论给客户发送第二封邮件*/
                if (in_array($rating, [4, 5])) {
                    $subjectTittle = EMAIL_REVIEWS_FOUR_FIVE_06;
                    $html_new = common_email_header_and_footer($subjectTittle,EMAIL_REVIEWS_FOUR_FIVE_01);
                    $html_new_msg['EMAIL_HEADER'] = $html_new['header'];
                    $html_new_msg['EMAIL_FOOTER'] = $html_new['footer'];
                    $html_new_msg['EMAIL_REVIEWS_FOUR_FIVE_01'] = EMAIL_REVIEWS_FOUR_FIVE_01;
                    $html_new_msg['EMAIL_REVIEWS_FOUR_FIVE_02'] = EMAIL_REVIEWS_FOUR_FIVE_02;
                    $html_new_msg['EMAIL_REVIEWS_FOUR_FIVE_03'] = EMAIL_REVIEWS_FOUR_FIVE_03;
                    $html_new_msg['EMAIL_REVIEWS_FOUR_FIVE_04'] = EMAIL_REVIEWS_FOUR_FIVE_04;
                    $html_new_msg['EMAIL_REVIEWS_FOUR_FIVE_05'] = EMAIL_REVIEWS_FOUR_FIVE_05;
                    sendwebmail($customers_name, $customer_email_address, '针对4或者5星评论客户进行邀约评价:' .
                        date('Y-m-d h:i:s', time()), $send_to_name,
                        EMAIL_REVIEWS_FOUR_FIVE_07, $html_new_msg, 'high_quality_reviews');
                }
            }
            /**
             * 4,5星订单评论直接展示在前台
             *
             * redis 重构后这一块重写
             */
            if(in_array($rating,[4,5])){
                remove_redis_by_prefix($_SESSION['languages_code'] . '_reviewsData_product_info_' . $products_id); //评论内容缓存
//                remove_redis_by_prefix($_SESSION['languages_code'] . '_reviews_count_' . $products_id); //评论星级占比缓存
//                if (!empty($_FILES['reviewImg'])) {
//                    remove_redis_by_prefix($_SESSION['languages_code'] . "_reviews_image_" . $products_id);
//                }; //评论图片缓存
//                remove_redis_by_prefix($_SESSION['languages_code'] . '_reviews_total_' . $products_id); //评论总数缓存
            }
            $api->response(['redirectUrl'=>zen_href_link('view_reviews'), 'alertStatus' => $resultStatus]);
        }else{
            $api->setMessage(FS_SYSTME_BUSY)->setStatus(500)->response();
        }
        break;
}
