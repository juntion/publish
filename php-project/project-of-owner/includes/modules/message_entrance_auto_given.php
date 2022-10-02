<?php
function get_service_admin_id($is_customer_service){
    global  $db;
    $service_ids = array();
    if($is_customer_service){
        $sql = 'select admin_id from admin where is_customer_service in('.join(',',$is_customer_service).')';
        $rst = $db->Execute($sql);
        if($rst->RecordCount()){
            while (!$rst->EOF){
                $service_ids[] = $rst->fields['admin_id'];
                $rst->MoveNext();
            }
        }
    }
    return $service_ids;
}

$service_ids = ''; //分配客服
$area = ''; //客服所属区域

if($customers_country_id){
        $country_website = '';
        $us_customer_service = array(223,38);  //该国家分配到美国客服 3
        $sg_customer_service = array(18,25,32,36,61,96,99,100,113,116,129,130,142,146,149,162,168,188,196,206,209,230); //d 7
        $sale_customer_service = array(240,1,3,4,6,8,9,12,16,17,19,22,23,24,28,29,30,31,34,35,37,39,40,41,42,44,45,46,48,49,50,51,52,55,58,60,63,64,65,66,68,69,71,78,79,82,83,85,86,87,88,90,91,93,94,98,103,104,108,110,111,114,118,119,120,121,125,127,128,131,133,134,135,136,137,139,143,144,145,147,148,151,152,154,155,156,157,158,159,161,163,165,169,173,174,177,178,179,180,181,183,184,185,186,187,191,192,193,194,197,198,200,201,202,208,210,211,212,213,214,215,217,218,219,221,227,231,232,233,234,235,238,239,241,242,243,244,245,250,251);
        if(in_array($customers_country_id,$sg_customer_service)){
            $service_email = 'sg@fs.com';
            $service_name = 'sg';
            $sg_service_ids = get_service_admin_id(array(7));
            $service_ids = implode(',',$sg_service_ids);
            $area = '7';
        }elseif (in_array($customers_country_id,$us_customer_service) && (in_array($_SESSION['languages_code'],['fr','en']))){
            $service_email = 'us@fs.com';
            $service_name = 'us';
            $us_service_ids = get_service_admin_id(array(3,8));
            $service_ids = implode(',',$us_service_ids);
            $area = '3,8';
            if($customers_country_id==38 && $_SESSION['languages_code'] =='fr'){
                $fr_service_ids = array(4255,3495);
                $service_ids = implode(',',$fr_service_ids);
                $service_email = 'fr@fs.com';
                $service_name = 'fr';
                $area = '1,6';
            }
        }elseif($_SESSION['languages_code']=="it"){
            $it_service_ids = array(4297);
            $service_ids = implode(',',$it_service_ids);
            $service_email = 'italy@fs.com';
            $service_name = 'it';
            $area = '4';
        }elseif (in_array($customers_country_id,$sale_customer_service)){
            $service_email = 'sales@fs.com';
            $service_name = 'sales';
            $sale_service_ids = array(3018);
            $service_ids = implode(',',$sale_service_ids);
            $area = '1';
        }
        if (empty($service_ids)){
            $country_name = fs_get_data_from_db_fields('countries_name','countries','countries_id='.$customers_country_id,'limit 1');

            $country_website_data = getWebsiteData(['website'], "country_name= '" . $country_name . "'", "order by sort asc limit 1");
            $country_website = !empty($country_website_data) ? $country_website_data[0][0] : '';

        }
        if($country_website){
            $web_site = $country_website;
        }else{
            $web_site = $_SESSION['languages_code'];
        }

        if($web_site && empty($service_ids) && empty($area)){
            switch ($web_site){
                case 'en':
                    $service_email = 'us@fs.com';
                    $service_name = 'us';
                    $us_service_ids = get_service_admin_id(array(3,8));
                    $service_ids = implode(',',$us_service_ids);
                    $area = '3,8';
                    break;
                case 'sg':
                    $service_email = 'sg@fs.com';
                    $service_name = 'sg';
                    $sg_service_ids = get_service_admin_id(array(7));
                    $service_ids = implode(',',$sg_service_ids);
                    $area = '7';
                    break;
                case 'de-en':
                    if($_SESSION['countries_iso_code']=="it"){
                        $it_service_ids = array(4297);
                        $service_ids = implode(',',$it_service_ids);
                        $service_email = 'italy@fs.com';
                        $service_name = 'it';
                        $area = '4';
                    }else{
                        $uk_service_ids = get_service_admin_id(array(6));
                        $service_ids = implode(',',$uk_service_ids);
                        $service_email = 'eu@fs.com';
                        $service_name = 'uk';
                        $area = '6';
                    }
                    break;
                case 'uk':
                    $uk_service_ids = get_service_admin_id(array(6));
                    $service_ids = implode(',',$uk_service_ids);
                    $service_email = 'uk@fs.com';
                    $service_name = 'uk';
                    $area = '6';
                    break;
                case 'au':
                    $au_service_ids = get_service_admin_id(array(5));
                    $service_ids = implode(',',$au_service_ids);
                    $service_email = 'au@fs.com';
                    $service_name = 'australia';
                    $area = '5';
                    break;
                case 'de':
                    $de_service_ids = get_service_admin_id(array(4));
                    $service_ids = implode(',',$de_service_ids);
                    $service_email = 'de@fs.com';
                    $service_name = 'de';
                    $area = '1';
                    break;
                case 'mx':
                    $mx_service_ids = array(2985,3738,3607,4256);
                    $service_ids = implode(',',$mx_service_ids);
                    $service_email = 'mx@fs.com';
                    $service_name = 'mx';
                    $area = '1,3,6,8';
                    break;
                case 'es':
                    $es_service_ids = array(4256,3607);
                    $service_ids = implode(',',$es_service_ids);
                    $service_email = 'es@fs.com';
                    $service_name = 'es';
                    $area = '1';
                    break;
                case 'ru':
                    $ru_service_ids = get_service_admin_id(array(9));
                    $service_ids = implode(',',$ru_service_ids);
                    $service_email = 'ru@fs.com';
                    $service_name = 'ru';
                    $area = '1';
                    break;
                case 'jp':
                    $jp_service_ids = array(4254);
                    $service_ids = implode(',',$jp_service_ids);
                    $service_email = 'jp@fs.com';
                    $service_name = 'jp';
                    $area = '1';
                    break;
                case 'fr':
                    $fr_service_ids = array(4255,3495);
                    $service_ids = implode(',',$fr_service_ids);
                    $service_email = 'fr@fs.com';
                    $service_name = 'fr';
                    $area = '1';
                    break;
            }
        }
}

?>