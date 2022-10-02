<?php
use App\Services\Reviews\ReviewServices;
use App\Services\Common\ApiResponse;

if (!isset($_GET['action']) && !$_GET['action']) {
    zen_redirect(zen_href_link(FILENAME_DEFAULT,'','SSL'));
}
require 'includes/application_top.php';
$action = $_GET['action'];

$api = new ApiResponse();
$reviewServices = new ReviewServices();
switch ($action) {
    case 'search_reviews_tag':
        $search = zen_db_input($_POST['search']);
        if (!$search) {
            $api->setStatus(406)->setMessage("error")->response(['info' => FS_SYSTME_BUSY]);
        }
        $data = $reviewServices->searchTagInfo($search);
        exit(json_encode(array('data' => $data, 'status' => 1)));
        break;
}