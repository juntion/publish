<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){

    $action = $_GET['ajax_request_action'];
    if(!zen_not_null($action)){
        echo "err";
    }else{
        switch($_GET['ajax_request_action']){
            case 'page':
                $page = $_POST['page'];
                $industry_type = $_POST['industry_type'];
                $case_type = $_POST['case_type'];
                $region_type = $_POST['region_type'];
                $case_studies = get_new_case_studies($page,$region_type,$industry_type,$case_type);
                exit(json_encode(array('status' => 1, 'info' => '', 'data' => array('case_studies_html'=>$case_studies['case_studies_html'],'page_more'=>$case_studies['page_more'],'page'=>$case_studies['page']))));
                break;
            case 'doc_region_type':
            case 'doc_case_type':
            case 'doc_industry_type':
            case 'clear_choose_type':
                $page = $_POST['page'];
                $region_type = $_POST['region_type'] ? $_POST['region_type'] : 0;
                $industry_type = $_POST['industry_type'] ? $_POST['industry_type'] : 0;
                $case_type = $_POST['case_type'] ? $_POST['case_type'] : 0;
                $case_studies = get_new_case_studies($page,$region_type,$industry_type,$case_type);
                exit(json_encode(array('status' => 1, 'info' => '', 'data' => array('case_studies_html'=>$case_studies['case_studies_html'],'page_more'=>$case_studies['page_more'],'region_html'=>$case_studies['region_html'],'case_html'=>$case_studies['case_html'],'industry_html'=>$case_studies['industry_html'],'clear_choose_html'=>$case_studies['clear_choose_html'],'page'=>$case_studies['page']))));
                break;
        }
    }
}
?>

