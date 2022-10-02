<?php

//小语种时间显示(日-月-年)
function get_date_display($date,$language_id,$format='')
{
    $month_number = date('n', strtotime($date));
    $month = get_date_display_month($month_number,$language_id);
    $day = date('d', strtotime($date));
    $year = date('Y', strtotime($date));

    if(!$format){ // 英文站是F j,Y格式的是这样展示
        if ($language_id == 2) {
            //日期 + de + 月份缩写 + de + 年份
            $date = $day.' de ' .$month .' de '.$year;
        } elseif ($language_id == 3) {
            $date = 'le '. $day. ' '.$month.' '.$year;
        } elseif ($language_id == 4) {
            $date = $day.' '.$month.$year;
        } elseif ($language_id == 5) {
            $date = $day . '. ' . $month . $year;
        } elseif ($language_id == 8) {
            $date = $year . '年' . $month . '月' .$day .'日';
        }else{ //英语和其他站
            $date = date('F j,Y', strtotime($date));
        }
    }

    return $date;
}


/*
 * 小语种时间展示格式
 * 调用getTime方法，使用default格式。现在个人中心的case、inquiry、订单列表，
 * fairy 2018.12.20 add
 * @para int $time: 时间戳
 * @para string $format: 格式；
 *      default：年月日 时分；
 *      default1：年月日；
 *      default2：年月日 换行 时分；
 */
function get_all_languages_date_display($time,$format='default')
{
    if ($_SESSION['languages_code'] == 'de') { // 日/月/年 时:分 Uhr（24小时制）
        if($format == 'default'){
            //$date =  date('d/m/Y H:i',$time);
            $date =  date('d.m.Y',$time)." ".date('H:i //',$time);
            $date = str_replace('//','Uhr',$date);
        }elseif ($format == 'default1'){
            //$date =  date('d/m/Y',$time);
            $date =  date('d',$time).'.'.get_date_display_month(date('m',$time),$_SESSION['languages_id']).'.'.date('Y',$time);
        }elseif ($format == 'default2'){
            //$date =  date('d.m.Y H:i /',$time);
            $date =  date('d.m.Y',$time)."<br/> ".date('H:i //',$time);
            $date = str_replace('//','Uhr',$date);
        }elseif ($format == 'default3'){
            $date = date('j',$time).'. '.get_month_display_new(date('n',$time));
        }
    } elseif (in_array($_SESSION['languages_code'],array('fr','ru','es','mx','it'))) { // 日/月/年 时:分（24小时制）
        if($format == 'default'){
            $date =  date('d/m/Y H:i',$time);
        }elseif ($format == 'default1'){
            $date =  date('d/m/Y',$time);
        }elseif ($format == 'default2'){
            $date = date('d/m/Y',$time)."<br/> ".date('H:i',$time);
        }elseif ($format == 'default3'){
            $middle = ' ';
            $format = 'j';
            if($_SESSION['languages_code'] == 'fr'){
                $middle = '. ';
            }
            if($_SESSION['languages_code'] == 'it'){
                $format = 'd';
            }
            $date = date($format,$time).$middle.get_month_display_new(date('n',$time));
        }
    } elseif ($_SESSION['languages_code'] == 'jp') { // 年/月/日 午後时:分 （12小时制）
        if($format == 'default'){
            $date = date('Y/m/d H:i',$time);
            //$date = str_replace('am','午前',$date);
            //$date = str_replace('pm','午後',$date);
        }elseif ($format == 'default1'){
            $date = date('Y年m月d日',$time);
        }elseif ($format == 'default2'){
            $date = date('Y/m/d',$time)."<br/> ".date('H:i',$time);
            //$date = str_replace('am','',$date);
            //$date = str_replace('pm','',$date);
        }elseif ($format == 'default3'){
            $date = get_month_display_new(date('n',$time)).date('j日',$time);
        }
    }elseif (in_array($_SESSION['languages_code'],array('uk','au','dn'))) { // 日/月/年 12h制
        if($format == 'default'){
            $date = date('d/m/Y h:i a',$time);
        }elseif ($format == 'default1'){
            $date = date('j M, Y',$time);
        }elseif ($format == 'default2'){
            $date = date('d/m/Y',$time).'<br/> '.date('h:i a',$time);
        }elseif ($format == 'default3'){
            $date = date('j',$time).getLast(date('j',$time)).'. '.get_month_display_new(date('n',$time));
        }
    }else{ //英语和其他站，月/日/年 时:分 pm
        if($format == 'default'){
            $date = date('m/d/Y h:i a',$time);
        }elseif ($format == 'default1'){
            $date = date('M j, Y',$time);
        }elseif ($format == 'default2'){
            $date = date('m/d/Y',$time).'<br/> '.date('h:i a',$time);
        }elseif ($format == 'default3'){
            $date = get_month_display_new(date('n',$time)).'. '.date('j',$time);
        }
    }
    return $date;
}

/*
 * 流程图时间的显示格式
 * fairy 2018.12.12 add
 * @para string $time：时间戳
 * @return string：带有格式的时间字符串
 */
function get_order_flow_time_show($time){
    /*
    if($_SESSION['languages_code']=='fr'){
        return date("d/m/Y", $time).'<br />'.date("h:i a", $time);
    }else{
        return date("m/d/Y", $time).'<br />'.date("h:i a", $time);
    }
    */
    if($_SESSION['languages_code']=='en'){
        return date("m/d/Y", $time).' <br/>'.date("h:i a", $time);
    }elseif($_SESSION['languages_code']=='jp'){
        return date("Y/m/d", $time).' <br/>'.date("H:i", $time);
    }else{
        return date("d/m/Y", $time).' <br/>'.date("H:i", $time);
    }
}

//日期表达（星期几-日-月）
function get_date_product_delivery($date,$language_id,$type = 1){
    if($language_id == 1){
        $date = $date;
        return $date;
    }elseif ($language_id ==2){
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = 'lun. ';
        }elseif (date('w',strtotime($date)) == 2){
            $week = 'mart. ';
        }elseif (date('w',strtotime($date)) == 3){
            $week = 'miérc. ';
        }elseif (date('w',strtotime($date)) == 4){
            $week = 'juev. ';
        }elseif (date('w',strtotime($date)) == 5){
            $week = 'vier. ';
        }elseif (date('w',strtotime($date)) == 6){
            $week = 'sáb. ';
        }elseif (date('w',strtotime($date)) == 0){
            $week = 'dom. ';
        }
        //判断月份
        if(date('n',strtotime($date)) == 1){
            $month = 'en. ';
        }elseif (date('n',strtotime($date)) == 2){
            $month = 'febr. ';
        }elseif (date('n',strtotime($date)) == 3){
            $month = 'mzo. ';
        }elseif (date('n',strtotime($date)) == 4){
            $month = 'abr. ';
        }elseif (date('n',strtotime($date)) == 5){
            $month = 'my. ';
        }elseif (date('n',strtotime($date)) == 6){
            $month = 'jun. ';
        }elseif (date('n',strtotime($date)) == 7){
            $month = 'jul. ';
        }elseif (date('n',strtotime($date)) == 8){
            $month = 'agto. ';
        }elseif (date('n',strtotime($date)) == 9){
            $month = 'sept. ';
        }elseif (date('n',strtotime($date)) == 10){
            $month = 'oct. ';
        }elseif (date('n',strtotime($date)) == 11){
            $month = 'nov. ';
        }else if(date('n',strtotime($date)) == 12){
            $month = 'dic. ';
        }
        $day = date('d',strtotime($date));
        $date = $week . $day . ' de ' . $month;
        return $date;

    }elseif ($language_id ==3){
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = 'lun. ';
        }elseif (date('w',strtotime($date)) == 2){
            $week = 'mar. ';
        }elseif (date('w',strtotime($date)) == 3){
            $week = 'mer. ';
        }elseif (date('w',strtotime($date)) == 4){
            $week = 'jeu. ';
        }elseif (date('w',strtotime($date)) == 5){
            $week = 'ven. ';
        }elseif (date('w',strtotime($date)) == 6){
            $week = 'sam. ';
        }elseif (date('w',strtotime($date)) == 0){
            $week = 'dim. ';
        }
        //判断月份
        if(date('n',strtotime($date)) == 1){
            $month = 'janv. ';
        }elseif (date('n',strtotime($date)) == 2){
            $month = 'févr. ';
        }elseif (date('n',strtotime($date)) == 3){
            $month = 'mars ';
        }elseif (date('n',strtotime($date)) == 4){
            $month = 'avr. ';
        }elseif (date('n',strtotime($date)) == 5){
            $month = 'mai ';
        }elseif (date('n',strtotime($date)) == 6){
            $month = 'juin ';
        }elseif (date('n',strtotime($date)) == 7){
            $month = 'juill. ';
        }elseif (date('n',strtotime($date)) == 8){
            $month = 'août ';
        }elseif (date('n',strtotime($date)) == 9){
            $month = 'sept. ';
        }elseif (date('n',strtotime($date)) == 10){
            $month = 'oct. ';
        }elseif (date('n',strtotime($date)) == 11){
            $month = 'nov. ';
        }else if(date('n',strtotime($date)) == 12){
            $month = 'déc. ';
        }
        $day = date('d',strtotime($date));

        $date = $week . $day . ' ' . $month;
        return $date;

    }elseif ($language_id ==4){
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = 'пнд. ';
        }elseif (date('w',strtotime($date)) == 2){
            $week = 'втр. ';
        }elseif (date('w',strtotime($date)) == 3){
            $week = 'срд. ';
        }elseif (date('w',strtotime($date)) == 4){
            $week = 'чтв. ';
        }elseif (date('w',strtotime($date)) == 5){
            $week = 'птн. ';
        }elseif (date('w',strtotime($date)) == 6){
            $week = 'сбт. ';
        }elseif (date('w',strtotime($date)) == 0){
            $week = 'вск. ';
        }
        if(date('n',strtotime($date)) == 1){
            $month = 'янв ';
        }elseif (date('n',strtotime($date)) == 2){
            $month = 'фев ';
        }elseif (date('n',strtotime($date)) == 3){
            $month = 'мар ';
        }elseif (date('n',strtotime($date)) == 4){
            $month = 'апр ';
        }elseif (date('n',strtotime($date)) == 5){
            $month = 'май ';
        }elseif (date('n',strtotime($date)) == 6){
            $month = 'июн ';
        }elseif (date('n',strtotime($date)) == 7){
            $month = 'июл ';
        }elseif (date('n',strtotime($date)) == 8){
            $month = 'авг ';
        }elseif (date('n',strtotime($date)) == 9){
            $month = 'сен ';
        }elseif (date('n',strtotime($date)) == 10){
            $month = 'окт ';
        }elseif (date('n',strtotime($date)) == 11){
            $month = 'ноя ';
        }else if(date('n',strtotime($date)) == 12) {
            $month = 'дек ';
        }
        $day = 0;
        if ($type == 2) {
            $ex = explode('.', $date);
            $day = (int)end($ex);
        }
        if (!$day) {
            $day = date('d.',strtotime($date));
        }
        $date = $week . $day . ' ' . $month;
        return $date;

    }elseif ($language_id ==5){
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = 'Mo. ';
        }elseif (date('w',strtotime($date)) == 2){
            $week = 'Di. ';
        }elseif (date('w',strtotime($date)) == 3){
            $week = 'Mi. ';
        }elseif (date('w',strtotime($date)) == 4){
            $week = 'Do. ';
        }elseif (date('w',strtotime($date)) == 5){
            $week = 'Fr. ';
        }elseif (date('w',strtotime($date)) == 6){
            $week = 'Sa. ';
        }elseif (date('w',strtotime($date)) == 0){
            $week = 'So. ';
        }
        //判断月份
        if(date('n',strtotime($date)) == 1){
            $month = ' Januar';
        }elseif (date('n',strtotime($date)) == 2){
            $month = 'Februar';
        }elseif (date('n',strtotime($date)) == 3){
            $month = ' März';
        }elseif (date('n',strtotime($date)) == 4){
            $month = ' April';
        }elseif (date('n',strtotime($date)) == 5){
            $month = ' Mai';
        }elseif (date('n',strtotime($date)) == 6){
            $month = ' Juni';
        }elseif (date('n',strtotime($date)) == 7){
            $month = ' Juli';
        }elseif (date('n',strtotime($date)) == 8){
            $month = ' August';
        }elseif (date('n',strtotime($date)) == 9){
            $month = ' September';
        }elseif (date('n',strtotime($date)) == 10){
            $month = ' Oktober';
        }elseif (date('n',strtotime($date)) == 11){
            $month = ' November';
        }else if(date('n',strtotime($date)) == 12){
            $month = ' Dezember';
        }
        $day = date('d.',strtotime($date));
        $date = $week . $day . ' ' . $month;
        return $date;
    }elseif ($language_id ==8){
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = '月';
        }elseif (date('w',strtotime($date)) == 2){
            $week = '火';
        }elseif (date('w',strtotime($date)) == 3){
            $week = '水';
        }elseif (date('w',strtotime($date)) == 4){
            $week = '木';
        }elseif (date('w',strtotime($date)) == 5){
            $week = '金';
        }elseif (date('w',strtotime($date)) == 6){
            $week = '土';
        }elseif (date('w',strtotime($date)) == 0){
            $week = '日';
        }
        //判断月份
        if(date('n',strtotime($date)) == 1){
            $month = '1月';
        }elseif (date('n',strtotime($date)) == 2){
            $month = '2月';
        }elseif (date('n',strtotime($date)) == 3){
            $month = '3月';
        }elseif (date('n',strtotime($date)) == 4){
            $month = '4月';
        }elseif (date('n',strtotime($date)) == 5){
            $month = '5月';
        }elseif (date('n',strtotime($date)) == 6){
            $month = '6月';
        }elseif (date('n',strtotime($date)) == 7){
            $month = '7月';
        }elseif (date('n',strtotime($date)) == 8){
            $month = '8月';
        }elseif (date('n',strtotime($date)) == 9){
            $month = '9月';
        }elseif (date('n',strtotime($date)) == 10){
            $month = '10月';
        }elseif (date('n',strtotime($date)) == 11){
            $month = '11月';
        }else if(date('n',strtotime($date)) == 12){
            $month = '12月';
        }
        $day = date('d',strtotime($date));
        $date = $month . $day. '日' . '(' .$week. ')';
        return $date;
    }
    elseif ($language_id == 14){ //意大利语
        //判断星期几
        if(date('w',strtotime($date)) == 1){
            $week = 'lun. ';
        }elseif (date('w',strtotime($date)) == 2){
            $week = 'mart. ';
        }elseif (date('w',strtotime($date)) == 3){
            $week = 'mer. ';
        }elseif (date('w',strtotime($date)) == 4){
            $week = 'gio. ';
        }elseif (date('w',strtotime($date)) == 5){
            $week = 'ven. ';
        }elseif (date('w',strtotime($date)) == 6){
            $week = 'sab. ';
        }elseif (date('w',strtotime($date)) == 0){
            $week = 'dom. ';
        }
        //判断月份
        if(date('n',strtotime($date)) == 1){
            $month = 'gen.';
        }elseif (date('n',strtotime($date)) == 2){
            $month = 'feb.';
        }elseif (date('n',strtotime($date)) == 3){
            $month = 'mar.';
        }elseif (date('n',strtotime($date)) == 4){
            $month = 'apr.';
        }elseif (date('n',strtotime($date)) == 5){
            $month = 'mag.';
        }elseif (date('n',strtotime($date)) == 6){
            $month = 'giu.';
        }elseif (date('n',strtotime($date)) == 7){
            $month = 'lug.';
        }elseif (date('n',strtotime($date)) == 8){
            $month = 'ago.';
        }elseif (date('n',strtotime($date)) == 9){
            $month = 'set.';
        }elseif (date('n',strtotime($date)) == 10){
            $month = 'ott.';
        }elseif (date('n',strtotime($date)) == 11){
            $month = 'nov.';
        }else if(date('n',strtotime($date)) == 12){
            $month = 'dec.';
        }
        $day = date('d',strtotime($date));
        $date = $week . $day .' '. $month;
        return $date;
    }else{
        return $date;
    }
}
//邮件显示日期  根据不同小语种站显示不同的国家的时间
function get_email_date_display($date,$language_id)
{
    if ($language_id == 1) {
        $date = date('F j,Y', strtotime($date));
        return $date;
    } elseif ($language_id == 2) {

        if (date('n', strtotime($date)+32400) == 1) {
            $month = 'en. ';
        } elseif (date('n', strtotime($date)+32400) == 2) {
            $month = 'febr. ';
        } elseif (date('n', strtotime($date)+32400) == 3) {
            $month = 'mzo. ';
        } elseif (date('n', strtotime($date)+32400) == 4) {
            $month = 'abr. ';
        } elseif (date('n', strtotime($date)+32400) == 5) {
            $month = 'my. ';
        } elseif (date('n', strtotime($date)+32400) == 6) {
            $month = 'jun. ';
        } elseif (date('n', strtotime($date)+32400) == 7) {
            $month = 'jul. ';
        } elseif (date('n', strtotime($date)+32400) == 8) {
            $month = 'agto. ';
        } elseif (date('n', strtotime($date)+32400) == 9) {
            $month = 'sept. ';
        } elseif (date('n', strtotime($date)+32400) == 10) {
            $month = 'oct. ';
        } elseif (date('n', strtotime($date)+32400) == 11) {
            $month = 'nov. ';
        } else if (date('n', strtotime($date)+32400) == 12) {
            $month = 'dic. ';
        }
        $day = date('d', strtotime($date)+32400);
        $year = date('Y', strtotime($date)+32400);
        $h = date(' H:i:s', strtotime($date)+32400);
        $date = $day . ' ' . $month . $year . $h;
        return $date;

    } elseif ($language_id == 3) {
        if (date('n', strtotime($date)+32400) == 1) {
            $month = 'janv. ';
        } elseif (date('n', strtotime($date)+32400) == 2) {
            $month = 'févr. ';
        } elseif (date('n', strtotime($date)+32400) == 3) {
            $month = 'mars ';
        } elseif (date('n', strtotime($date)+32400) == 4) {
            $month = 'avr. ';
        } elseif (date('n', strtotime($date)+32400) == 5) {
            $month = 'mai ';
        } elseif (date('n', strtotime($date)+32400) == 6) {
            $month = 'juin ';
        } elseif (date('n', strtotime($date)+32400) == 7) {
            $month = 'juill. ';
        } elseif (date('n', strtotime($date)+32400) == 8) {
            $month = 'août ';
        } elseif (date('n', strtotime($date)+32400) == 9) {
            $month = 'sept. ';
        } elseif (date('n', strtotime($date)+32400) == 10) {
            $month = 'oct. ';
        } elseif (date('n', strtotime($date)+32400) == 11) {
            $month = 'nov. ';
        } else if (date('n', strtotime($date)+32400) == 12) {
            $month = 'déc. ';
        }
        $day = date('d', strtotime($date)+32400);
        $year = date('Y', strtotime($date)+32400);
        $h = date(' H:i:s', strtotime($date)+32400);
        $date = $day . ' ' . $month . $year . $h;
        return $date;

    } elseif ($language_id == 4) {
        if (date('n', strtotime($date)+36000) == 1) {
            $month = 'янв ';
        } elseif (date('n', strtotime($date)+36000) == 2) {
            $month = 'фев ';
        } elseif (date('n', strtotime($date)+36000) == 3) {
            $month = 'мар ';
        } elseif (date('n', strtotime($date)+36000) == 4) {
            $month = 'апр ';
        } elseif (date('n', strtotime($date)+36000) == 5) {
            $month = 'май ';
        } elseif (date('n', strtotime($date)+36000) == 6) {
            $month = 'июн ';
        } elseif (date('n', strtotime($date)+36000) == 7) {
            $month = 'июл ';
        } elseif (date('n', strtotime($date)+36000) == 8) {
            $month = 'авг ';
        } elseif (date('n', strtotime($date)+36000) == 9) {
            $month = 'сен ';
        } elseif (date('n', strtotime($date)+36000) == 10) {
            $month = 'окт ';
        } elseif (date('n', strtotime($date)+36000) == 11) {
            $month = 'ноя ';
        } else if (date('n', strtotime($date)+36000) == 12) {
            $month = 'дек ';
        }
        $day = date('d', strtotime($date)+36000);
        $year = date('Y', strtotime($date)+36000);
        $h = date(' H:i:s', strtotime($date)+36000);
        $date = $day . ' ' . $month . $year . $h;


        return $date;

    } elseif ($language_id == 5) {
        $date = date('d.m.Y H:i:s', strtotime($date)+32400);
        return $date;
    }else{
        return $date;
    }
}


//小语种获取月份
//邮件显示日期  根据不同小语种站显示不同的国家的时间
function get_date_display_month($date,$language_id)
{
    if ($language_id == 2) {
        if ($date == 1) {
            $month = 'en. ';
        } elseif ($date == 2) {
            $month = 'febr. ';
        } elseif ($date == 3) {
            $month = 'mzo. ';
        } elseif ($date == 4) {
            $month = 'abr. ';
        } elseif ($date == 5) {
            $month = 'my. ';
        } elseif ($date== 6) {
            $month = 'jun. ';
        } elseif ($date == 7) {
            $month = 'jul. ';
        } elseif ($date == 8) {
            $month = 'agto. ';
        } elseif ($date == 9) {
            $month = 'sept. ';
        } elseif ($date == 10) {
            $month = 'oct. ';
        } elseif ($date == 11) {
            $month = 'nov. ';
        } else if ($date == 12) {
            $month = 'dic. ';
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 3) {
        if ($date == 1) {
            $month = 'janv. ';
        } elseif ($date == 2) {
            $month = 'févr. ';
        } elseif ($date == 3) {
            $month = 'mars ';
        } elseif ($date == 4) {
            $month = 'avr. ';
        } elseif ($date == 5) {
            $month = 'mai ';
        } elseif ($date == 6) {
            $month = 'juin ';
        } elseif ($date == 7) {
            $month = 'juill. ';
        } elseif ($date == 8) {
            $month = 'août ';
        } elseif ($date == 9) {
            $month = 'sept. ';
        } elseif ($date == 10) {
            $month = 'oct. ';
        } elseif ($date == 11) {
            $month = 'nov. ';
        } else if ($date == 12) {
            $month = 'déc. ';
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 4) {
        if ($date == 1) {
            $month = 'янв ';
        } elseif ($date== 2) {
            $month = 'фев ';
        } elseif ($date == 3) {
            $month = 'мар ';
        } elseif ($date == 4) {
            $month = 'апр ';
        } elseif ($date == 5) {
            $month = 'май ';
        } elseif ($date == 6) {
            $month = 'июн ';
        } elseif ($date == 7) {
            $month = 'июл ';
        } elseif ($date == 8) {
            $month = 'авг ';
        } elseif ($date == 9) {
            $month = 'сен ';
        } elseif ($date == 10) {
            $month = 'окт ';
        } elseif ($date == 11) {
            $month = 'ноя ';
        } else if ($date == 12) {
            $month = 'дек ';
        }
        $date = $month;
        return $date;
    } elseif ($language_id == 5) {
        if ($date == 1) {
            $month = '01';
        } elseif ($date== 2) {
            $month = '02';
        } elseif ($date == 3) {
            $month = '03';
        } elseif ($date == 4) {
            $month = '04';
        } elseif ($date == 5) {
            $month = '05';
        } elseif ($date == 6) {
            $month = '06';
        } elseif ($date == 7) {
            $month = '07';
        } elseif ($date == 8) {
            $month = '08';
        } elseif ($date == 9) {
            $month = '09';
        } elseif ($date == 10) {
            $month = '10';
        } elseif ($date == 11) {
            $month = '11';
        } else if ($date == 12) {
            $month = '12';
        }
        return $month;
    }else{
        return $date;
    }
}
function get_date_translate($date,$language_id)
{
    $origin_data = $date;
    $date = strtolower($date);
    if ($language_id == 2) {
        if ($date == "january") {
            $month = 'en. ';
        } elseif ($date == "february") {
            $month = 'febr. ';
        } elseif ($date == "march") {
            $month = 'mzo. ';
        } elseif ($date == "april") {
            $month = 'abr. ';
        } elseif ($date == "may") {
            $month = 'my. ';
        } elseif ($date== "june") {
            $month = 'jun. ';
        } elseif ($date == "july") {
            $month = 'jul. ';
        } elseif ($date == "august") {
            $month = 'agto. ';
        } elseif ($date == "september") {
            $month = 'sept. ';
        } elseif ($date == "october") {
            $month = 'oct. ';
        } elseif ($date == "november") {
            $month = 'nov. ';
        } else if ($date == "december") {
            $month = 'dic. ';
        }else{
            $month = $date;
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 3) {
        if ($date == "january") {
            $month = 'janv. ';
        } elseif ($date == "february") {
            $month = 'févr. ';
        } elseif ($date == "march") {
            $month = 'mars ';
        } elseif ($date == "april") {
            $month = 'avr. ';
        } elseif ($date == "may") {
            $month = 'mai ';
        } elseif ($date== "june") {
            $month = 'juin ';
        } elseif ($date == "july") {
            $month = 'juill. ';
        } elseif ($date == "august") {
            $month = 'août ';
        } elseif ($date == "september") {
            $month = 'sept. ';
        } elseif ($date == "october") {
            $month = 'oct. ';
        } elseif ($date == "november") {
            $month = 'nov. ';
        } else if ($date == "december") {
            $month = 'déc. ';
        }else{
            $month = $date;
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 4) {
        if ($date == "january") {
            $month = 'янв ';
        } elseif ($date == "february") {
            $month = 'фев ';
        } elseif ($date == "march") {
            $month = 'мар ';
        } elseif ($date == "april") {
            $month = 'апр ';
        } elseif ($date == "may") {
            $month = 'май ';
        } elseif ($date== "june") {
            $month = 'июн ';
        } elseif ($date == "july") {
            $month = 'июл ';
        } elseif ($date == "august") {
            $month = 'авг ';
        } elseif ($date == "september") {
            $month = 'сен ';
        } elseif ($date == "october") {
            $month = 'окт ';
        } elseif ($date == "november") {
            $month = 'ноя ';
        } else if ($date == "december") {
            $month = 'дек ';
        }else{
            $month = $date;
        }
        $date = $month;
        return $date;
    } elseif ($language_id == 5) {
        if ($date == "january") {
            $month = 'Januar ';
        } elseif ($date == "february") {
            $month = 'Februar ';
        } elseif ($date == "march") {
            $month = 'März ';
        } elseif ($date == "april") {
            $month = 'April ';
        } elseif ($date == "may") {
            $month = 'Mai ';
        } elseif ($date== "june") {
            $month = 'Juni ';
        } elseif ($date == "july") {
            $month = 'Juli ';
        } elseif ($date == "august") {
            $month = 'August ';
        } elseif ($date == "september") {
            $month = 'September ';
        } elseif ($date == "october") {
            $month = 'Oktober ';
        } elseif ($date == "november") {
            $month = 'November ';
        } else if ($date == "december") {
            $month = 'Dezember ';
        }else{
            $month = $date;
        }
        return $month;
    } elseif ($language_id == 14) {//意大利语
        if ($date == "january") {
            $month = 'gennaio ';
        } elseif ($date == "february") {
            $month = 'febbraio ';
        } elseif ($date == "march") {
            $month = 'marzo ';
        } elseif ($date == "april") {
            $month = 'aprile ';
        } elseif ($date == "may") {
            $month = 'maggio ';
        } elseif ($date== "june") {
            $month = 'giugno ';
        } elseif ($date == "july") {
            $month = 'luglio ';
        } elseif ($date == "august") {
            $month = 'agosto ';
        } elseif ($date == "september") {
            $month = 'settembre ';
        } elseif ($date == "october") {
            $month = 'ottobre ';
        } elseif ($date == "november") {
            $month = 'novembre ';
        } else if ($date == "december") {
            $month = 'dicembre ';
        }else{
            $month = $date;
        }
        return $month;
    }else{
        return $origin_data;
    }
}
function get_date_display_month_new($date,$language_id)
{
    if ($language_id == 2) {
        if ($date == 1) {
            $month = 'en. ';
        } elseif ($date == 2) {
            $month = 'febr. ';
        } elseif ($date == 3) {
            $month = 'mzo. ';
        } elseif ($date == 4) {
            $month = 'abr. ';
        } elseif ($date == 5) {
            $month = 'my. ';
        } elseif ($date== 6) {
            $month = 'jun. ';
        } elseif ($date == 7) {
            $month = 'jul. ';
        } elseif ($date == 8) {
            $month = 'agto. ';
        } elseif ($date == 9) {
            $month = 'sept. ';
        } elseif ($date == 10) {
            $month = 'oct. ';
        } elseif ($date == 11) {
            $month = 'nov. ';
        } else if ($date == 12) {
            $month = 'dic. ';
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 3) {
        if ($date == 1) {
            $month = 'janv. ';
        } elseif ($date == 2) {
            $month = 'févr. ';
        } elseif ($date == 3) {
            $month = 'mars ';
        } elseif ($date == 4) {
            $month = 'avr. ';
        } elseif ($date == 5) {
            $month = 'mai ';
        } elseif ($date == 6) {
            $month = 'juin ';
        } elseif ($date == 7) {
            $month = 'juill. ';
        } elseif ($date == 8) {
            $month = 'août ';
        } elseif ($date == 9) {
            $month = 'sept. ';
        } elseif ($date == 10) {
            $month = 'oct. ';
        } elseif ($date == 11) {
            $month = 'nov. ';
        } else if ($date == 12) {
            $month = 'déc. ';
        }
        $date = $month;
        return $date;

    } elseif ($language_id == 4) {
        if ($date == 1) {
            $month = 'янв ';
        } elseif ($date== 2) {
            $month = 'фев ';
        } elseif ($date == 3) {
            $month = 'мар ';
        } elseif ($date == 4) {
            $month = 'апр ';
        } elseif ($date == 5) {
            $month = 'май ';
        } elseif ($date == 6) {
            $month = 'июн ';
        } elseif ($date == 7) {
            $month = 'июл ';
        } elseif ($date == 8) {
            $month = 'авг ';
        } elseif ($date == 9) {
            $month = 'сен ';
        } elseif ($date == 10) {
            $month = 'окт ';
        } elseif ($date == 11) {
            $month = 'ноя ';
        } else if ($date == 12) {
            $month = 'дек ';
        }
        $date = $month;
        return $date;
    } elseif ($language_id == 5) {
        if ($date == 1) {
            $month = 'Januar ';
        } elseif ($date == 2) {
            $month = 'Februar ';
        } elseif ($date == 3) {
            $month = 'März ';
        } elseif ($date == 4) {
            $month = 'April ';
        } elseif ($date == 5) {
            $month = 'Mai ';
        } elseif ($date== 6) {
            $month = 'Juni ';
        } elseif ($date == 7) {
            $month = 'Juli ';
        } elseif ($date == 8) {
            $month = 'August ';
        } elseif ($date == 9) {
            $month = 'September ';
        } elseif ($date == 10) {
            $month = 'Oktober ';
        } elseif ($date == 11) {
            $month = 'November ';
        } else if ($date == 12) {
            $month = 'Dezember ';
        }else{
            $month = $date;
        }
        return $month;
    }else{
        return $date;
    }
}

function get_time_english_display($str,$languages_id=1){
    if($languages_id == 1){
        $str = $str;
        return $str;
    }elseif($languages_id == 8){
        $arr_split_m = explode('月',$str);
        $arr_split_d = explode('日',$arr_split_m[1]);
        $arr_split_d[1] = trim($arr_split_d[1],'(');
        $arr_split_d[1] = trim($arr_split_d[1],')');
        if($arr_split_d[1] == '月'){
            $arr_split_d[1] = 'Mon';
        }elseif($arr_split_d[1] = '火'){
            $arr_split_d[1] = 'Tue';
        }elseif($arr_split_d[1] = '水'){
            $arr_split_d[1] = 'Wed';
        }elseif($arr_split_d[1] = '木'){
            $arr_split_d[1] = 'Thu';
        }elseif($arr_split_d[1] = '金'){
            $arr_split_d[1] = 'Fri';
        }elseif($arr_split_d[1] = '土'){
            $arr_split_d[1] = 'Sat';
        }elseif($arr_split_d[1] = '日'){
            $arr_split_d[1] = 'Sun';
        }
        
        if($arr_split_m[0] == 1){
            $arr_split_m[0] = 'Jan';
        }elseif($arr_split_m[0] == 2){
            $arr_split_m[0] = 'Feb';
        }elseif($arr_split_m[0] == 3){
            $arr_split_m[0] = 'Mar';
        }elseif($arr_split_m[0] == 4){
            $arr_split_m[0] = 'Apr';
        }elseif($arr_split_m[0] == 5){
            $arr_split_m[0] = 'May';
        }elseif($arr_split_m[0] == 6){
            $arr_split_m[0] = 'Jun';
        }elseif($arr_split_m[0] == 7){
            $arr_split_m[0] = 'Jul';
        }elseif($arr_split_m[0] == 8){
            $arr_split_m[0] = 'Aug';
        }elseif($arr_split_m[0] == 9){
            $arr_split_m[0] = 'Sep';
        }elseif($arr_split_m[0] == 10){
            $arr_split_m[0] = 'Oct';
        }elseif($arr_split_m[0] == 11){
            $arr_split_m[0] = 'Nov';
        }elseif($arr_split_m[0] == 12){
            $arr_split_m[0] = 'Dec';
        }

        $str_english = $arr_split_d[1].'. '.$arr_split_m[0].'. '.$arr_split_d[0];
        return $str_english;

    }elseif($languages_id == 2){
        $str = trim($str,' ');
        $arr =  explode(' ',$str);
        
        if($arr[0] == 'Lun.'){
            $arr[0] = 'Mon';
        }elseif($arr[0] = 'Mart.'){
            $arr[0] = 'Tue';
        }elseif($arr[0] = 'Miérc.'){
            $arr[0] = 'Wed';
        }elseif($arr[0] = 'Juev.'){
            $arr[0] = 'Thu';
        }elseif($arr[0] = 'Vier.'){
            $arr[0] = 'Fri';
        }elseif($arr[0] = 'Sáb.'){
            $arr[0] = 'Sat';
        }elseif($arr[0] = 'Dom.'){
            $arr[0] = 'Sun';
        }

        if($arr[2] == 'En.'){
            $arr[2] = 'Jan';
        }elseif($arr[2] == 'Febr.'){
            $arr[2] = 'Feb';
        }elseif($arr[2] == 'Mzo.'){
            $arr[2] = 'Mar';
        }elseif($arr[2] == 'Abr.'){
            $arr[2] = 'Apr';
        }elseif($arr[2] == 'My.'){
            $arr[2] = 'May';
        }elseif($arr[2] == 'Jun.'){
            $arr[2] = 'Jun';
        }elseif($arr[2] == 'Jul.'){
            $arr[2] = 'Jul';
        }elseif($arr[2] == 'Agto.'){
            $arr[2] = 'Aug';
        }elseif($arr[2] == 'Sept.'){
            $arr[2] = 'Sep';
        }elseif($arr[2] == 'Oct.'){
            $arr[2] = 'Oct';
        }elseif($arr[2] == 'Nov.'){
            $arr[2] = 'Nov';
        }elseif($arr[2] == 'Dic.'){
            $arr[2] = 'Dec';
        }
        $str_english = $arr[0].'. '.$arr[2].'. '.$arr[1];
        return $str_english;   
    }elseif($languages_id == 3){
        $str = trim($str,' ');
        $arr =  explode(' ',$str);

        if($arr[0] == 'lun.'){
            $arr[0] = 'Mon';
        }elseif($arr[0] = 'mar.'){
            $arr[0] = 'Tue';
        }elseif($arr[0] = 'mer.'){
            $arr[0] = 'Wed';
        }elseif($arr[0] = 'jeu.'){
            $arr[0] = 'Thu';
        }elseif($arr[0] = 'ven.'){
            $arr[0] = 'Fri';
        }elseif($arr[0] = 'sam.'){
            $arr[0] = 'Sat';
        }elseif($arr[0] = 'dim.'){
            $arr[0] = 'Sun';
        }

        if($arr[2] == 'janv.'){
            $arr[2] = 'Jan';
        }elseif($arr[2] == 'févr.'){
            $arr[2] = 'Feb';
        }elseif($arr[2] == 'mars'){
            $arr[2] = 'Mar';
        }elseif($arr[2] == 'avr.'){
            $arr[2] = 'Apr';
        }elseif($arr[2] == 'mai'){
            $arr[2] = 'May';
        }elseif($arr[2] == 'juin'){
            $arr[2] = 'Jun';
        }elseif($arr[2] == 'juill.'){
            $arr[2] = 'Jul';
        }elseif($arr[2] == 'août'){
            $arr[2] = 'Aug';
        }elseif($arr[2] == 'sept.'){
            $arr[2] = 'Sep';
        }elseif($arr[2] == 'oct.'){
            $arr[2] = 'Oct';
        }elseif($arr[2] == 'nov.'){
            $arr[2] = 'Nov';
        }elseif($arr[2] == 'déc.'){
            $arr[2] = 'Dec';
        }
        $str_english = $arr[0].'. '.$arr[2].'. '.$arr[1];
        return $str_english;
    }elseif($languages_id == 4){
        $str = trim($str,' ');
        $arr =  explode(' ',$str);

        if($arr[0] == 'пнд'){
            $arr[0] = 'Mon';
        }elseif($arr[0] = 'втр'){
            $arr[0] = 'Tue';
        }elseif($arr[0] = 'срд'){
            $arr[0] = 'Wed';
        }elseif($arr[0] = 'чтв'){
            $arr[0] = 'Thu';
        }elseif($arr[0] = 'птн'){
            $arr[0] = 'Fri';
        }elseif($arr[0] = 'сбт'){
            $arr[0] = 'Sat';
        }elseif($arr[0] = 'вск'){
            $arr[0] = 'Sun';
        }

        if($arr[2] == 'янв'){
            $arr[2] = 'Jan';
        }elseif($arr[2] == 'фев'){
            $arr[2] = 'Feb';
        }elseif($arr[2] == 'мар'){
            $arr[2] = 'Mar';
        }elseif($arr[2] == 'апр'){
            $arr[2] = 'Apr';
        }elseif($arr[2] == 'май'){
            $arr[2] = 'May';
        }elseif($arr[2] == 'июн'){
            $arr[2] = 'Jun';
        }elseif($arr[2] == 'июл'){
            $arr[2] = 'Jul';
        }elseif($arr[2] == 'авг'){
            $arr[2] = 'Aug';
        }elseif($arr[2] == 'сен'){
            $arr[2] = 'Sep';
        }elseif($arr[2] == 'окт'){
            $arr[2] = 'Oct';
        }elseif($arr[2] == 'ноя'){
            $arr[2] = 'Nov';
        }elseif($arr[2] == 'дек'){
            $arr[2] = 'Dec';
        }
        $str_english = $arr[0].'. '.$arr[2].'. '.$arr[1];
        return $str_english;
    }elseif($languages_id == 5){
        $str = trim($str,' ');
        $arr =  explode(' ',$str);

        if($arr[0] == 'Mo.'){
            $arr[0] = 'Mon';
        }elseif($arr[0] = 'Di.'){
            $arr[0] = 'Tue';
        }elseif($arr[0] = 'Mi.'){
            $arr[0] = 'Wed';
        }elseif($arr[0] = 'Do.'){
            $arr[0] = 'Thu';
        }elseif($arr[0] = 'Fr.'){
            $arr[0] = 'Fri';
        }elseif($arr[0] = 'Sa.'){
            $arr[0] = 'Sat';
        }elseif($arr[0] = 'So.'){
            $arr[0] = 'Sun';
        }

        if($arr[3] == 'Januar'){
            $arr[3] = 'Jan';
        }elseif($arr[3] == 'Februar'){
            $arr[3] = 'Feb';
        }elseif($arr[3] == 'März'){
            $arr[3] = 'Mar';
        }elseif($arr[3] == 'April'){
            $arr[3] = 'Apr';
        }elseif($arr[3] == 'Mai'){
            $arr[3] = 'May';
        }elseif($arr[3] == 'Juni'){
            $arr[3] = 'Jun';
        }elseif($arr[3] == 'Juli'){
            $arr[3] = 'Jul';
        }elseif($arr[3] == 'August'){
            $arr[3] = 'Aug';
        }elseif($arr[3] == 'September'){
            $arr[3] = 'Sep';
        }elseif($arr[3] == 'Oktober'){
            $arr[3] = 'Oct';
        }elseif($arr[3] == 'November'){
            $arr[3] = 'Nov';
        }elseif($arr[3] == 'Dezember'){
            $arr[3] = 'Dec';
        }
        $str_english = $arr[0].'. '.$arr[3].'. '.$arr[1];
        return $str_english; 
    }elseif($languages_id == 9){
        $str_arr = explode("/",$str);
        $month_arr = array(
            '01' => "Jan",
            '02' => "Feb",
            '03' => "Mar",
            '04' => "Apr",
            '05' => "May",
            '06' => "Jun",
            '07' => "Jul",
            '08' => "Aug",
            '09' => "Sep",
            '10' => "Oct",
            '11' => "Nov",
            '12' => "Dec"
        );
        $newstr = $str_arr[0]." ".$month_arr[$str_arr[1]]." ".$str_arr[2];
        return $newstr;
    }else{
        return $str;
    }
}

/**
 * $type  1.返回工作日+周末  2.具体日期
 * @param $day
 * @return false|string
 */
function get_specific_date_of_days($day,$type=1,$spring_days=0,$country_iso_code=""){
    $str = '';
    $total_weekday = 0;
    $country_code = $country_iso_code ? strtoupper($country_iso_code) : strtoupper($_SESSION['countries_iso_code']);
    $spring_days = (int)$spring_days;
    $day = (int)$day;
    if ($spring_days) {
        $sun_date= getTime("D",strtotime('+'.$spring_days.' days'),$country_code);
    } else {
        $sun_date= getTime("D",time(),$country_code);
    }

    if($day > 0){
        //$festival_day = get_festival_day($country_code);
        if($spring_days){
            $start_weekday = getTime("N",strtotime('+'.$spring_days. 'days'),$country_code); //星期几
        }else{
            $start_weekday = getTime("N",time(),$country_code); //星期几
        }

        $sun_day = 0;
        if (($sun_date == "Sun" || $sun_date == "Sat" || $sun_date == "Fri")) {
            if($sun_date == "Fri"){
                $sun_day = 2;
            }elseif ($sun_date == "Sat"){
                $sun_day = 2;
            }else{ //周五发货，从周一开始算，周六发货，直接从周二开始算
                $sun_day = 1;
            }
            if(($day) % 5 == 0){
                //因为周六和周日的交期是从周一开始算，故需要多一个周末
                if ($sun_date == "Sun" || $sun_date == "Sat") {
                    $add_time = 2;
                }
                if($day==5){
                    $total_weekday = $sun_day + $add_time;
                }else{
                    $total_weekday = (floor($day / 5)-1) * 2 + $sun_day + $add_time;
                }
            }else{
                if($day<5){
                    $total_weekday = $sun_day;
                }else{
                    $total_weekday = (floor($day / 5)) * 2 + $sun_day;
                }
            }
        }else{
            $prev_days = intval(5-$start_weekday); //去掉前一个星期的天数

            if($day > 5){
                $remaining_days = intval($day - $prev_days); //剩余天数
                if($remaining_days % 5 == 0){
                    $total_weekday = (floor($remaining_days / 5)) * 2;
                }else{
                    $total_weekday = (floor($remaining_days / 5) + 1) * 2;
                }
            }else{
                if($prev_days >= $day){
                    $total_weekday = 0;
                }else{
                    $total_weekday = 2;
                }
            }
        }
        $day = intval($day + $total_weekday);
    }else{
        if (($sun_date == "Sun" || $sun_date == "Sat")) {
            if ($sun_date == "Sat") {
                $day += 2;
            } else {
                $day += 1;
            }
        }
    }
    $str = get_date_time_format($day);
    if($type==1){
        return $str;
    }else{
        return $day;
    }

}

/**  展示对应本地时间格式
 * @param int $days
 * @return false|mixed|string
 */
function get_date_time_format($days=0,$country_code="",$area="") {
    global $db;
    $country_code = $country_code ? strtoupper($country_code) : strtoupper($_SESSION['countries_iso_code']);
    if(empty($area)){
        $area = $db->Execute("select time_zone from country_time_zone where code='".$country_code."' limit 1");
        $area = $area->fields['time_zone'];
    }

    if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
        $date = getTime('D. ', strtotime('+'. $days . ' days'),$country_code,"",true,$area).getTime('j', strtotime('+'. $days . ' days'),$country_code,"",true,$area).getLast(getTime('j', strtotime('+'. $days . ' days'),$country_code,"",true,$area)).' '.getTime('M.', strtotime('+'. $days . ' days'),$country_code,"",true,$area);
    }else{
        $date = getTime('D. M. j', strtotime('+'. $days . ' days'),$country_code,"",true,$area);
    }
    $ship_on = get_date_product_delivery($date,$_SESSION['languages_id'],2);
    if($country_code=="LV"){
        $ship_on = getTime('d. m. Y', strtotime('+'. $days . ' days'),$country_code,"",true,$area);
    }
    return $ship_on;
}

function get_month_display_new($month){
    if(!$month){
        $month = getTime("n");
    }
    $language_id = $_SESSION['languages_id'];
    switch ($language_id) {
        case 2://es
            $months = ['en.', 'febr.', 'mzo.', 'abr.', 'my.', 'jun.', 'jul.', 'agto.', 'sept.', 'oct.', 'nov.', 'dic.'];
            return 'de '.$months[$month-1];
            break;
        case 3://fr
            $months = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juill.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
            break;
        case 4://ru
            $months = ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
            break;
        case 5://de
            $months = ['Jan.', 'Febr.', 'März', 'Apr.', 'Mai', 'Juni', 'Juli', 'Aug.', 'Sept.', 'Okt.', 'Nov.', 'Dez.'];
            break;
        case 8://jp
            $months = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];
            break;
        case 14://it
            $months = ['gen.', 'feb.', 'mar.', 'apr.', 'mag.', 'giu.', 'lug.', 'ago.', 'set.', 'ott.', 'nov.', 'dic.'];
            break;
        default:
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            break;
    }
    return $months[$month-1];
}




