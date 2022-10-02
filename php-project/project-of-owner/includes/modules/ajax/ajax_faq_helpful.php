<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){

    $action = $_GET['ajax_request_action'];
    if(!zen_not_null($action)){
        echo "err";
    }else{
        switch($_GET['ajax_request_action']){
            /**
             * update by rebirth 2019/07/30
             *
             */
            case 'yes':
                global $db;
                $id = (int)$_POST['id'];
                $selectSql = "select yes_num from fs_faq_helpful where id = ".$id;
                $res = $db->Execute($selectSql);
                if ($res->EOF){
                    echo  isset($_POST['num']) ? (int)$_POST['num'] : 0;  //表示没找到,非法请求
                }
                $yes_num = $res->fields['yes_num'] + 1;
                $update_arr = array(
                    'yes_num' => $yes_num,
                );
                $where = 'id='.$id;
                zen_db_perform('fs_faq_helpful', $update_arr, 'update', $where);
                echo $yes_num;   //表示已修改
                break;
            case 'no':
                $id = (int)$_POST['id'];
                $no_id = (int)$_POST['no_id'];
//                $no_num = $_POST['num']+1;
//                $no_cause = $_POST['no_cause']+1;
                if($no_id == 1){
                    $no_cause_name = 'no_cause1';
                }elseif($no_id == 2){
                    $no_cause_name = 'no_cause2';
                }else{
                    $no_cause_name = 'no_cause3';
                }
                $selectSql = "select no_num, ".$no_cause_name." from fs_faq_helpful where id = ".$id;
                $res = $db->Execute($selectSql);
                if ($res->EOF){
                    echo  isset($_POST['num']) ? (int)$_POST['num'] : 0;  //表示没找到,非法请求
                }
                $no_num = $res->fields['no_num'] + 1;
                $no_cause = $res->fields[$no_cause_name] + 1;
                $update_arr = array(
                    'no_num' => $no_num,
                    $no_cause_name => $no_cause
                );
                $where = 'id='.$id;
                zen_db_perform('fs_faq_helpful', $update_arr, 'update', $where);
                echo $no_num;
                break;
            case 'submit_suggestions':
                $country_code = strtolower($_SESSION['countries_iso_code'] ? $_SESSION['countries_iso_code'] : 'us');
                $reason = $_POST['reason'] ? $_POST['reason'] : '';
                $type = $_POST['type'];
                $suggestion = $_POST['suggestion'] ? $_POST['suggestion'] : '';
                if(seattle_warehouse('country_code',$country_code)) {
                    $warehouseName = 'US';
                }elseif(all_german_warehouse('country_code',$country_code)) {
                    $warehouseName = 'DE';
                }elseif(au_warehouse($country_code,'country_code')){
                    $warehouseName = 'AU';
                }else{
                    $warehouseName = 'CN';
                }
                $yes_num = $no_num =0;
                if($type ==1){
                    $yes_num = 1;
                }else{
                    $no_num = 1;
                }
                $customers_country_id = fs_get_data_from_db_fields('countries_id','countries','	countries_iso_code_2="'.$_SESSION['countries_iso_code'].'"');
                $add_data = array(
                    'languages_id' =>$_SESSION['languages_id'],
                    'languages_code' => $_SESSION['languages_code'],
                    'yes_num'  => $yes_num,
                    'no_num' => $no_num,
                    'causes'=> $reason,
                    'warehouse_name' => $warehouseName,
                    'customers_suggestions' => $suggestion,
                    'which_page_from' => 2,
                    'customers_country_id' =>$customers_country_id,
                );
                $res = zen_db_perform('shipping_delivery_feedback', $add_data);
                if($res){
                    exit(json_encode(array('status'=>1)));
                }
                break;
        }
    }
}
?>

