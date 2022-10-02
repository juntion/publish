<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$action = $_GET['ajax_request_action'];

if (isset($action)) {
    switch ($action) {
        case "match_country":
            $zip = zen_db_prepare_input($_POST['zip']);
            if ($zip == "") {
                echo json_encode(array("msg" => "zip can't be empty", "type" => "error"));
                return false;
            }
            $sql = "SELECT states,city,country_code FROM `countries_to_zip`  WHERE zip = '$zip'";
            $ret = $db->Execute($sql);
            $au_sql ="SELECT city,state FROM `countries_au_zip` WHERE postcode = '$zip'";
            $au_ret = $db->Execute($au_sql);
            if(!empty($ret) && $ret->fields['country_code']=="US"){
                $data = array("city" => $ret->fields['city'], "states" => $ret->fields['states']);
                echo json_encode(array("type" => "success", "data" => $data,'code'=>1,'country_id'=>223));
            }elseif(!empty($au_ret)){
                $data = array("city" => $au_ret->fields['city'], "states" => $au_ret->fields['state']);
                echo json_encode(array("type" => "success", "data" => $data,'code'=>2,'country_id'=>13));
            }else{
                echo json_encode(array("type" => "empty"));
            }
            break;
        case "validate_post_code":
            $post_code = $_POST['entry_postcode'];
            $sql = "SELECT zip FROM `countries_to_zip`  WHERE zip = '$zip'";
            $ret = $db->Execute($sql);
            if (empty($ret->fields['zip'])) {
                exit("false");
            }
            exit("true");
            break;

        default:
    }
}

?>