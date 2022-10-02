<?php

/**
 * 新加披上门服务
 * @author rebirth.ma
 * @date 2019.10.24
 *
 * Class SGInstallerServiceClass
 */
class SGInstallerServiceClass
{
    /**
     *现场技术人员
     * @var string
     */
    private $marketAdmin = "3678";

    /**
     * case_number 表里的content
     * @var string
     */
    private $content = "";

    /**
     * 从on_site_service来源插入数据,此时只有上门服务一种情况
     * add by Jeremy 2019.10.28
     * @param $site_data array 表单
     * @return bool
     */
    public function insertBysignPage($site_data)
    {
        if ($site_data['orders_number']){  //有订单数据
            //二次插入验证
            $installInfo = fs_get_one_data(TABLE_CUSTOMER_APPOINTMENT_INFO, " orders_number = '{$site_data['orders_number']}'");
            if (zen_not_null($installInfo)) { //二次插入的情况
                return false;
            }
            //mark标记插入
            if ($site_data['products_instock_id']){ //线下单
                $where = " products_instock_id=" . $site_data['products_instock_id'] . " and products_id in (" . $site_data['products_ids'] . ") ";;
                zen_db_perform('products_instock_shipping_info', ['is_appointment' => 1], 'update', $where);
            }else{ //线上单
                $where = " orders_id=" . $site_data['orders_id'] . " and products_id in (" . $site_data['products_ids'] . ") ";;
                zen_db_perform(TABLE_ORDERS_PRODUCTS, ['is_install' => 1], 'update', $where);
            }
        }
        $email = $site_data['customer_email'];
        $site_data['market_admin'] = $this->marketAdmin;
        $site_data['appointment_type'] = 4;//上门服务
        $site_data['customer_country'] = 188;//默认新加坡
        $site_data['resource'] = 4;//on-site
        $case_number = createCaseNumber(1,10,$email,$site_data['admin_id'],'',$site_data['customer_id']);
        $site_data['case_number'] = $case_number;
        $site_data['appointment_end_time'] = self::getEndTime($site_data['appointment_start_time']);
        $data = $this->getInsertData($site_data);
        zen_db_perform(TABLE_CUSTOMER_APPOINTMENT_INFO, $data);
        return $case_number;
    }

    /**
     * 预约拜访数据入库
     *  add by Quest 2019.10.25
     * @param $visit_data array 表单数据
     * @param $admin_id array 销售id
     * @param $customer_id array 客户id
     * @return bool
     */
    public function inserByVisit($visit_data,$admin_id,$customer_id){
        $email = $visit_data['customer_email'];

        $case_number = createCaseNumber(1,10,$email,$admin_id,'',$customer_id);
        $visit_data['case_number'] = $case_number;
        $visit_data['market_admin'] = $this->marketAdmin;
        $visit_data['appointment_end_time'] = self::getEndTime($visit_data['appointment_start_time']);

        $data_format = $this->getInsertData($visit_data);

        zen_db_perform(TABLE_CUSTOMER_APPOINTMENT_INFO, $data_format);
        return $case_number;
    }

    /**
     * 发送拜访邮件
     * add by Quest 2019.10.28
     * @param $email_data
     */
    public function sendVisitEamil($email_data,$case_number)
    {
        get_email_langpac();
        $html = common_email_header_and_footer(FS_SG_VISIT_EAMIL_TITLE,'test');
        $html_msg['EMAIL_HEADER'] = $html['header'];
        $html_msg['EMAIL_FOOTER'] = $html['footer'];
        $customer_name = $email_data['customer_name'];
        $customer_name = ucwords($customer_name);
        $email_address = $email_data['customer_email'];
        $company_name = $email_data['customer_company_name'];
        $phone_num = $email_data['customer_phone'];
        $tpl_prefix = $email_data['tpl_prefix'];
        $customer_mark = $email_data['customer_remark'];

        $visit_type = '';
        switch ($email_data['customer_number']){
            case 1:
                $customer_numstr = '1-2';
                break;
            case 2:
                $customer_numstr = '3-5';
                break;
            case 3:
                $customer_numstr = '5-10';
                break;
            case 4:
                $customer_numstr = '10-20';
                break;
            case 5:
                $customer_numstr = '20+';
                break;
            default:
                $customer_numstr = '1-2';
                break;
        }

        switch ($email_data['appointment_fourth_type']){
            case 1:
                $visit_type = 'Project/Solution Consulation';
                break;
            case 2:
                $visit_type = 'Cooperation and Consultation';
                break;
            case 3:
                $visit_type = 'Visit Only';
                break;
        }

        $visit_time = strtotime($email_data['appointment_start_time']);
        $visit_date = date('l, M. d | H:i',$visit_time);

        $html_body = '<table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 30px 20px 0" align="left">
                            Dear '.$customer_name.',
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            Your visit request <a style="color: #0070bc;text-decoration: none" href="javascript:;">#'.$case_number.'</a> is received. Please contact us at +(65) 6443 7951 for any questions and keep me informed if there should be any changes.
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #232323;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            Company Name: '.$company_name.' <br />
                            Contact Name: '.$customer_name.' <br />
                            Phone No: '.$tpl_prefix.' '.$phone_num.' <br />
                            Numbers of Visiting Person: '.$customer_numstr.' <br />
                            Visit Type: '.$visit_type.' <br />
                            Scheduled time: '.$visit_date.' <br />
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            Note: '.$customer_mark.'
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;font-size: 14px;color: #333;line-height: 22px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            We are looking forward to seeing you soon.
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse;padding: 0 20px" align="center">
                            <img src="https://img-en.fs.com/includes/templates/fiberstore/images/email/email-sg-map.jpg">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table width="640" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td bgcolor="#fff" style="border-collapse: collapse" height="20">

                        </td>
                    </tr>
                    </tbody>
                </table>';
        $html_msg['EMAIL_BODY'] = $html_body;


        sendwebmail($customer_name,$email_address,'发送拜访邮件给客户:'.date('Y-m-d H:i:s', time()),STORE_NAME,FS_SG_VISIT_EAMIL_END_TITLE,$html_msg,'default');
    }


    /**
     * 从order表获取数据来源插入数据,此时只有上门服务一种情况
     *
     * @param $order_id
     * @param $data
     * @param bool $customerCheck
     * @param array $products_ids
     * @return bool
     */
    public function insertByOrder($order_id, $data, $products_ids, $customerCheck = true)
    {
        //mark的产品必传，不传不生成数据
        $products_ids = $this->toBeInt($products_ids);
        if (!zen_not_null($products_ids)){
            return false;
        }
        //订单验证
        $order_id = $this->toBeInt($order_id);
        //新加坡直发   收货地址国家新加坡  未取消的订单
        $where = " orders_id=" . $order_id . " and delivery_country_id = 188 and is_reissue = 24 and orders_status <> 5 ";
        if ($customerCheck) {
            if (zen_not_null($_SESSION['customer_id'])) {
                $where .= " and customers_id=" . $_SESSION['customer_id'];
            } else {
                return false;
            }
        }
        $orderInfo = fs_get_one_data(TABLE_ORDERS, $where, "customers_email_address,customers_id,orders_number,customers_name,customers_country");
        if (!zen_not_null($orderInfo)) {
            return false;
        }
        //二次插入验证
        $installInfo = fs_get_one_data(TABLE_CUSTOMER_APPOINTMENT_INFO, " orders_number = '{$orderInfo['orders_number']}'");
        if (zen_not_null($installInfo)) { //二次插入的情况
            return false;
        }
        //mark标记插入
        $where = " orders_id=" . $order_id . " and products_id in (" . implode(",", $products_ids) . ") ";;
        zen_db_perform(TABLE_ORDERS_PRODUCTS, ['is_install' => 1], 'update', $where);
        //获取订单对应的销售
        if (zen_not_null( $_SESSION['orders_to_admin_id'])){
            $admin_id =  $_SESSION['orders_to_admin_id'];
            $_SESSION['orders_to_admin_id'] = 0;
            unset($_SESSION['orders_to_admin_id']);
        }else{
            $orderToAdmin = fs_get_one_data(TABLE_ORDER_TO_ADMIN, "orders_id=" . $order_id, "admin_id");
            $admin_id = $orderToAdmin["admin_id"];
        }

        //生成caseNumber
        $caseNumber = createCaseNumber(1, 10, $orderInfo["customers_email_address"], $admin_id, "", $orderInfo['customers_id']);
        $serviceStartTime = zen_db_prepare_input((string)$data['start_time']);
        $insert = [
            'case_number'            => $caseNumber,
            'customer_name'          => $orderInfo['customers_name'],
            'customer_country'       => $orderInfo['customers_country'],
            'appointment_type'       => 3,
            'resource'               => zen_not_null($data['resource'])?7:1,
            'appointment_second_type'=> zen_db_prepare_input((string)$data['second_type']),
            'appointment_third_type' => zen_db_prepare_input((string)$data['third_type']),
            'market_admin'           => $this->marketAdmin,//现场技术人员，后台维护
            'orders_number'          => $orderInfo['orders_number'],
            'customer_remark'        => zen_db_prepare_input((string)$data['customer_remark']), //用户传入的数据
            'customer_remark_file'   => zen_db_prepare_input((string)$data['file']),
            'cancel_remark'          => '',
            'appointment_start_time' => $serviceStartTime,
            'appointment_end_time'   => self::getEndTime($serviceStartTime),
        ];
        $insert = $this->getInsertData($insert);
        zen_db_perform(TABLE_CUSTOMER_APPOINTMENT_INFO, $insert);
        //生成邮件队列
        $this->sgInstallDataToQueueEmail($order_id, $orderInfo['orders_number'], $serviceStartTime);
        return true;
    }

    /**
     * 预约时间button
     *
     * @author aron
     * @return string
     */
    public static function getInstallButton($from = '')
    {
        $title = FS_SG_CALENDAR_1.":";
        $placeMessage = FS_SG_CALENDAR_2;
        $placeMessageOther = FS_SG_CALENDAR_3;
        $error= FS_SG_CALENDAR_4;
        $tit = '* '.FS_SG_CALENDAR_10;
        if($from=='site'){
            $tit = '';
        }
        $html = <<<EOF
        <div class="sg_door_time_container">
            <p class="sg_door_time_tit">$title</p>
            <div class="sg_door_time sg_door_time_button" data-disable="1" onclick="showInstallCalendar(this)">
                <i class="iconfont icon"></i>
                 <span class="selectTime">$placeMessage</span>
                 <span class="selectInstall" style="display: none">$placeMessageOther</span>
                 <span class = "selectText"  style="display: none"></span>
            </div>
            <p class="sg_door_time_Prompt" style="display: none">
                 $error
            </p>
            <p class="sg_door_time_checked_items" style="display: none">$tit</p>
        </div>
EOF;
        return $html;
    }

    /**
     * 获取时间日历 弹出 带标题
     *
     * @author aron
     * @return string
     */
    public static function getInstallCalendar()
    {
        $title = FS_SG_CALENDAR_1;
        $error = FS_SG_CALENDAR_4;
        $save = FS_COMMON_SAVE;
        $content = self::getInstallTimeTemplate();
        $html = <<<EOF
<div class="new_popup addCart data_time" id="installCalendar" style="display: none;">
	    <div class="new_popup_bg"></div>
	    <div class="new_popup_main popup_width680" id="" style="">
	        <h2 class="data_time_tit">$title
	        <span class="iconfont icon data_time_close" onclick="$('#installCalendar').hide()"></span></h2>
	        <div class="data_time_container">
	        	<span class="iconfont icon left_slide"></span>
	        	<span class="iconfont icon right_slide"></span>
	        	<div class="time">
			        <div class="date">
			            $content
			        </div>
			    </div>
			     <p class = "InstallSaveError error_prompt time_Prompt">$error</p>
			    <div class="data_time_btn_container">
			         <input type="hidden" name="sgInstallTime" class="installTime" value="">
			    	<button id="confirmInstallChoice" class="data_time_btn" onclick="confirmChoiceTime(this)" href="javascript:;">$save</button>
			    </div>
	        </div>
	    </div>
	</div>
EOF;
        return $html;
    }

    /**
     * 获取时间插件时间列表内容;
     *
     * @return string
     */
    public static function getInstallTimeTemplate(){
        $date = self::getSelectTime();
        $content = "<ul>";
        foreach ($date as $k=>$v) {
            $child = "";
            foreach ($v['time'] as $kk => $vv) {
                $invalid = $vv["isDisable"] ? "invalid" : "";
                $child .= "<a class='".$invalid."' onclick='choiceInstallTime(this)' href='javascript:;' data-endTime='".$vv["endTime"]."' data-isDisable='".$vv["isDisable"]."'
                data-beginTime='".$vv["beginTime"]."' data-time='" . $kk . "' data-showTime='".$vv["showTime"]."'>" . $vv['showOriginTime'] . "</a>";
            }
            $content .= '<li>
                    <span><i class="data-time-tit">' .  $v['week'] . '</i><br>'.self::createDay($v["month"],$v["day"]).'</span>
                    <div class="hours">
                    ' . $child . '
</div>
                    </li>';
        }
        $content.="</ul>";
        return $content;
    }

    /**
     * 获取日历可选时间
     *
     * @return array
     */
    public static function getSelectTime()
    {
        $timezone_out = date_default_timezone_get();
        date_default_timezone_set('Asia/Singapore');
        $date = [];
        $currentDateTime = strtotime("+1 hour");
        //获取禁用时间
        $disableDate = self::getDisableTime();
        //默认循环7天
        $days = 7;
        $currentLoop = 0;
        $times = [
            9 => [
                'time' => '9:00 - 10:00',
                'isDisable' => 0,
                'showOriginTime' => "9:00"
            ],
            10 => [
                'time' => '10:00 - 11:00',
                'isDisable' => 0,
                'showOriginTime' => '10:00'
            ],
            11 => [
                'time' => '11:00 - 12:00',
                'isDisable' => 0,
                'showOriginTime' => '11:00'
            ],
            12 => [
                'time' => '12:00 - 13:00',
                'isDisable' => 0,
                'showOriginTime' => '12:00'
            ],
            13 => [
                'time' => '13:00 - 14:00',
                'isDisable' => 0,
                'showOriginTime' => '13:00'
            ],
            14 => [
                'time' => '14:00 - 15:00',
                'isDisable' => 0,
                'showOriginTime' => '14:00'
            ],
            15 => [
                'time' => '15:00 - 16:00',
                'isDisable' => 0,
                'showOriginTime' => '15:00'
            ],
            16 => [
                'time' => '16:00 - 17:00',
                'isDisable' => 0,
                'showOriginTime' => '16:00'
            ]
        ];
        for ($i = 0; $i < $days; $i++) {
            $now = strtotime('+' . $i . ' days');
            $currentMonth = date('n', $now);
            $currentWeek = date('w', $now);
            $currentDay = date('d', $now);
            $currentFullDay = date("Y-m-d", $now);
            //排除双休
            if (in_array($currentWeek, [0, 6])) {
                $days += 1;
                continue;
            }
            //屏蔽节假日
            $festival = [
                '2019-10-27' => 1,
                '2019-10-25' => 0,
                '2020-1-1' => 0,
                '2020-1-25' => 2,
                '2020-4-10' => 2,
                '2020-5-1' => 2,
                '2020-5-7' => 0,
                '2020-5-25' => 0,
                '2020-7-31' => 2,
                "2020-10-9" => 1,
                "2020-12-25" => 2
            ];
            foreach ($festival as $d => $f) {
                for ($loop = 0; $loop <= $f; $loop++) {
                    $future = date("Y-m-d", strtotime("+" . $loop . " days", strtotime($d)));
                    if ($currentFullDay == $future) {
                        $days++;
                        continue 3;
                    }
                }
            }

            $currentLoop++;
            $date[$i]['month'] = self::translateDate()['months'][$currentMonth - 1];
            $date[$i]['week'] = self::translateDate()['week'][$currentWeek];
            $date[$i]['day'] = $currentDay;
            foreach ($times as $kk => $vv){
                $explode = explode(" - ", $vv['time']);
                $times[$kk]['beginTime'] = date("Y-m-d",$now)." "."$explode[0]";
                $times[$kk]['endTime'] = date("Y-m-d",$now)." "."$explode[1]";
                $times[$kk]['showTime']= $date[$i]['week'].FS_EMAIL_PAUSE.self::getSpace() . self::createDay($date[$i]['month'], $currentDay) .'|'.$vv['showOriginTime'];
                $beginToTime = strtotime($times[$kk]['beginTime']);
                $currentTranslate = date('Y-m-d G', $beginToTime);
                $endToTime = strtotime($times[$kk]['endTime']);
                $currentEndTranslate = date('Y-m-d G', $endToTime);

                if (in_array($currentTranslate, $disableDate) || $beginToTime <= $currentDateTime) {
                    $times[$kk]['isDisable'] = 1;
                } else {
                    $times[$kk]['isDisable'] = 0;
                }
            }
            $date[$i]['time'] = $times;
        }
        date_default_timezone_set($timezone_out);
        return $date;
    }

    /**
     * 获取结束时间
     *
     * @param string $beginTime
     * @return false|int
     */
    private static function getEndTime($beginTime = ""){
        global $db;
        $timezone_out = date_default_timezone_get();
        date_default_timezone_set('Asia/Singapore');
        $nextDate = date("Y-m-d H:i:s",strtotime("$beginTime +1 hour"));
        $data = $db->getAll("
                select appointment_start_time
                from case_number c 
                left join customer_appointment_info i on c.case_number = i.case_number 
                where c.case_number_from = 10 
                and c.is_del = 0 
                and c.status not in (4,5) 
                and i.resource != 2
                and i.appointment_end_time != '0000-00-00 00:00:00'
                and  appointment_start_time = '{$nextDate}'
                and i.is_split != 1
                limit 1
                "
        );
        $add = 2;
        $hour = date("G",strtotime($beginTime));
        //如果下一个小时的安装时间被占用或者 当前时间为当天最后一次安装时间
        if (!empty($data) || $hour == 16) {
            $add = 1;
        }
        $endTime = date("Y-m-d H:i:s",strtotime("+".$add." hours", strtotime($beginTime)));
        date_default_timezone_set($timezone_out);
        return $endTime;
    }

    /**
     * 根据不同小语种生成月日格式
     *
     * @param string $month
     * @param string $day
     * @return string
     */
    private static function createDay($month = '', $day = '')
    {
        $language_id = $_SESSION['languages_id'];
        switch ($language_id) {
            case 1:
                $str = $month.", ".$day;
                break;
            case 2:
                $str = $day." de ".$month;
                break;
            case 3:
                $str = 'le '.$day." ".$month;
                break;
            case 4:
                $str = $day." ".$month;
                break;
            case 5:
                $str = $day.". ".$month;
                break;
            case 8:
                $str = $month.$day."日";
                break;
            default:
                $str = $month.", ".$day;
        }
        return $str;
    }

    /**
     * 获取时间差
     *
     * @param string $startTime
     * @param string $endTime
     * @return float
     */
    private static function getDifferentHours($startTime="",$endTime=""){
        $hour=floor((strtotime($endTime)-strtotime($startTime))%86400/3600);
        return $hour;
    }

    /**
     * 获取系统禁用时间
     * @param int $intervals
     * @return array
     */
    private static function getDisableTime($intervals = 1)
    {
        global $db;
        $timezone_out = date_default_timezone_get();
        date_default_timezone_set('Asia/Singapore');
        $disableTime = [];
        $data = $db->getAll("
                select appointment_end_time,appointment_start_time
                from case_number c 
                left join customer_appointment_info i on c.case_number = i.case_number 
                where c.case_number_from = 10 
                and c.is_del = 0 
                and c.status not in (4,5) 
                and i.is_split != 1
                and i.resource != 2
                and i.appointment_end_time != '0000-00-00 00:00:00'");
        if (!empty($data)) {
            foreach ($data as $row) {
                $disableTime[] = date("Y-m-d G", strtotime($row['appointment_start_time']));
                $hours = self::getDifferentHours($row['appointment_start_time'], $row['appointment_end_time']);
                for ($i = 0; $i < $hours; $i++) {
                    $disableTime[] = date("Y-m-d G",
                        strtotime("+" . $i . " hours", strtotime($row['appointment_start_time'])));
                }
            }
            $disableTime = array_unique($disableTime);
        }
        date_default_timezone_set($timezone_out);
        return $disableTime;
    }
    /**
     * 根据不同语种翻译月星期
     *
     * @return array
     */
    private static function translateDate()
    {
        $language_id = $_SESSION['languages_id'];
        $week_en = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $week_jp = ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日', '日曜日'];
        $week_es = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $week_fr = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
        $week_de = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
        $week_ru = ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'];
        $month_en = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $month_es = ['en.', 'febr.', 'mzo.', 'abr.', 'my.', 'jun.', 'jul.', 'agto.', 'sept.', 'oct.', 'nov.', 'dic.'];
        $month_fr = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juill.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
        $month_de = ['Jan.', 'Febr.', 'Mrz.', 'Apr.', 'Mai', 'Jun.', 'Jul.', 'Aug.', 'Sept.', 'Okt.', 'Nov.', 'Dez.'];
        $month_ru = ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
        $month_jp = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];
        switch ($language_id) {
            case 1:
                $weeks = $week_en;
                $months = $month_en;
                break;
            case 2:
                $weeks = $week_es;
                $months =$month_es;
                break;
            case 3:
                $weeks = $week_fr;
                $months = $month_fr;
                break;
            case 4:
                $weeks = $week_ru;
                $months = $month_ru;
                break;
            case 5:
                $weeks = $week_de;
                $months = $month_de;
                break;
            case 8:
                $weeks = $week_jp;
                $months = $month_jp;
                break;
            default:
                $weeks = $week_en;
                $months = $month_en;

        }
        return ['week' => $weeks, 'months' => $months];
    }

    /**
     *  时间弹窗js
     *
     * @author aron
     * return string
     */
    public static function installScript()
    {
        $script = <<<EOF
        <script>
        //展示日历弹窗
        function showInstallCalendar(obj){
               var disable = $(obj).attr('data-disable');
               if(disable == 0){
                    return;
               }
               var input_class = $(obj).attr('data-name');
               $('#confirmInstallChoice').attr('data-name',input_class);
               var default_val = $(".installTime").val();
               $.ajax({
                    type: "POST",
                    url:  "index.php?modules=ajax&handler=ajax_sg_install_service&ajax_request_action=getInstallTime&action=getInstallTime",           
                    dataType: "json",
                    beforeSend:function(){
                      $("#confirmInstallChoice").attr('disabled',true);  
                    },
                    success: function (data) {
                        var data = data.data;
                        $(".data_time_container .date").html(data);
                        if(default_val){
                            var begin_time = (default_val.split("|"))[0];
                        
                            $(".time .hours a").each(function() {
                                 if($(this).attr('data-beginTime')==begin_time){
                                     if(!$(this).hasClass('invalid')){
                                        $(".time .hours a").removeClass("choose");
                                        $(this).addClass("choose");
                                        return false;   
                                     }else{
                                         $(".installTime").val("");
                                     }
                                  }
                            })
                        }
                         $("#confirmInstallChoice").attr('disabled',false);  
                        
            var time_width;
        	var document_width = $(document).width();
        	if($(document).width()<=700 && $(document).width() >480){
		time_width =parseInt(($('.time').width()-20)/3);
		$('.date li').width(time_width);
		$('.date').width($('.date li').length * (time_width+10) - 10)
	}else if($(document).width()<=480){
		time_width =parseInt(($(document).width()-60)/3);
		$('.date li').width(time_width);
		$('.date').width($('.date li').length * (time_width+10) - 10)
	}
                    },
                    error: function (msg) {
                  
                        return false;
                    }
               });
               $("#installCalendar").fadeIn();
        }
        	
        var lock=true;
	        $('.left_slide').click(function(){
        //锁为false进不来,要动画执行完锁才释放
        
        var time_width1;
        var document_width = $(document).width();
        time_width1 =parseInt(($('.time').width()-20)/3);
	    if(lock){
	    	if(document_width>700){
	    		var right = parseInt($('.date').css("margin-left"))+120;
	    	}else{
	    		var right = parseInt($('.date').css("margin-left")) + (time_width1+10);
	    	}
	    	
	    	
	    	if(document_width>700){
		    	if(right == 120){
					return false;
				}else{
					//执行的动画
			        $('.date').animate({
						marginLeft:right+'px'
					    },500,function(){
			            //动画执行完毕的回调函数,设置锁为true
			            lock=true;
			        })	
				}	
	    	}else{
	    		if(right == (time_width1+10)){
					return false;
				}else{
					//执行的动画
			        $('.date').animate({
						marginLeft:right+'px'
					    },500,function(){
			            //动画执行完毕的回调函数,设置锁为true
			            lock=true;
			        })	
				}	
	    	}
	    	
	    	
	    }
	    //设置锁为false
	    lock=false;
	})
	 var lock2=true;
	$('.right_slide').click(function(){

        var time_width1;
        var document_width = $(document).width();
        time_width1 =parseInt(($('.time').width()-20)/3);
		var width = $(document).width();
	    //锁为false进不来,要动画执行完锁才释放
	    if(lock2){
	    	
	    	if(document_width>700){
	    		var left = parseInt($('.date').css("margin-left"))-120;
	    	}else{
	    		var left = parseInt($('.date').css("margin-left")) - (time_width1+10);
	    	}
	    	
	    	
	    	var Number = -(time_width1+10)*5;
	    	
	    	if(width>700){
		    	if(left == -360){
					return false;
				}else{
					//执行的动画
			        $('.date').animate({
						marginLeft:left+'px'
					    },500,function(){
			            //动画执行完毕的回调函数,设置锁为true
			            lock2=true;
			        })	
				}	
	    	}else{
	    		if(left == Number){
					return false;
				}else{
					//执行的动画
			        $('.date').animate({
						marginLeft:left+'px'
					    },500,function(){
			            //动画执行完毕的回调函数,设置锁为true
			            lock2=true;
			        })	
				}	
	    	}
	    	
	    	
	    	
	    }
	    //设置锁为false
	    lock2=false;
	})
	
    function choiceInstallTime(obj){
	    if($(obj).hasClass('invalid')){
	        return;
	    }
	   $(".hours a").removeClass('choose');
       $(obj).addClass('choose');
       $(".InstallSaveError").hide();
    }
    
    function confirmChoiceTime(obj) {
	    var isChoice = $(".hours a.choose").length;
	    if(!isChoice){
	         $(".InstallSaveError").show();
	        return;
	    }
	    $(".InstallSaveError").hide();
        var beginTime = $(".hours a.choose").attr("data-beginTime");
        var endTime = $(".hours a.choose").attr("data-endTime");
        var val = beginTime;
        var text =  $(".hours a.choose").attr("data-showTime");
        var input_name = $(obj).attr('data-name');
        $('.installTime').val(val);
        $('#installCalendar').hide();
        $(".sg_door_time_checked_items").show();
        $(".sg_door_time_Prompt").hide();
        $(".selectText").show().html(text).siblings('span').hide();
        
        if($('.'+input_name).length != 0){
            $('.'+input_name).val(beginTime);
        }
    }
        </script>
EOF;
        return $script;
    }

    /**
     * 新加坡时间转换
     *
     * @param string $time   新加坡的 Y-m-d H:i:s
     * @param string $type  showtime   timestamp
     * @return string
     */
    public static function  sgInstallTimeTrans($time,$type = 'showtime'){
        date_default_timezone_set('Asia/Singapore');
        switch ($type){
            case "showtime":
                $now = strtotime($time);
                $currentMonth = date('n', $now);
                $currentWeek = date('w', $now);
                $currentDay = date('d', $now);
                $date['month'] = self::translateDate()['months'][$currentMonth - 1];
                $date['week'] = self::translateDate()['week'][$currentWeek];
                $res =  $date['week'].FS_EMAIL_PAUSE.self::getSpace() . self::createDay($date['month'], $currentDay) . '丨' . date('H:i', $now);
                break;
            default:
                $res = strtotime($time);
        }
        date_default_timezone_set(date_default_timezone_get());
        return  $res;
    }

    /**
     * 前台取消新加坡上门服务的地方
     *
     * @param $orderId int  订单id
     * @param $reason int
     * @param bool $checkPending  检验订单状态是否是pending单
     */
    public function  cancelCase($orderId,$reason = 0,$checkPending = true){

        $mid = abs((int)$orderId);
        $where = " (orders_id = " . $mid ." or main_order_id = " . $mid. ")";
        if ($checkPending){
            $where .= " and orders_status in (1,5)"; //调用此流程时   cancel单也是符合的
        }
        $orders = fs_get_datas(TABLE_ORDERS, $where ,"orders_number,orders_id");
        if (zen_not_null(count($orders))){
            //组装查出来的订单编号
            $nums = [];
            $ids = [];
            foreach ($orders as $order){
                $nums[] = $order['orders_number'];
                $ids[] = $order['orders_id'];
            }
            $numStr = $this->arrToSqlStr($nums);
            $idsStr = $this->arrToSqlStr($ids);
            //一单里面只可能有一个子单直发，符合新加坡上门服务的流程
            $cai = fs_get_one_data(TABLE_CUSTOMER_APPOINTMENT_INFO, " orders_number in " .$numStr, "case_number" );
            if (zen_not_null($cai)){
                $caseUpdate = [
                    'status' => 5,
                ];
                $caiUpdate = [
                    'cancel_remark' => $this->cancelCaseReason($reason)
                ];
                $opUpdate = [
                  "is_install" => 0
                ];
                zen_db_perform('case_number',$caseUpdate,"update",' case_number= \'' . $cai['case_number'] ."'");
                zen_db_perform(TABLE_CUSTOMER_APPOINTMENT_INFO,$caiUpdate,"update",' case_number= \'' . $cai['case_number']."'");
                zen_db_perform(TABLE_ORDERS_PRODUCTS,$opUpdate,"update",' orders_id  in ' . $idsStr);
                //删除邮件队列里的数据
                global $db;
                $db->Execute("DELETE FROM " . TABLE_CUSTOMER_APPOINTMENT_QUEUE . " WHERE `orders_id` in " . $idsStr);
            }
        }
    }

    /**
     * 将一维数组转换为可用于mysql查询的字符串
     *
     * @param $arr
     * @return string
     */
    private function arrToSqlStr($arr){
        return "('" . implode("','", $arr) . "')";
    }

    /**
     * 新加坡上门服务case取消的原因
     *
     * @param int $type
     * @return string
     */
    private function cancelCaseReason($type = 0){
        $reasons = [
            '线上订单cancel，自动取消',
            '客户前台手动取消订单,自动取消case',
            '前台订单已失效,自动取消case',
            '截止预约时间,自动取消case'
        ];
        if (!zen_not_null($reasons[$type])){
            $type = 0;
        }
        return  $reasons[$type];
    }

    /**
     * 插入数据格式化
     * @param $insert
     * @return array
     */
    private function getInsertData($insert)
    {
        $cloumns = $this->insertColumns();
        $insertData = [];
        foreach ($cloumns as $cloumn) {
            $insertData[$cloumn] = isset($insert[$cloumn]) ? $insert[$cloumn] : '';
        }
        return $insertData;
    }


    /**
     * sg上门安装服务邮件数据插入
     *
     * @param $id
     * @param $number
     * @param $time
     */
    private function sgInstallDataToQueueEmail($id, $number, $time)
    {
        if (defined("FS_TEST_SERVICE") && FS_TEST_SERVICE === true){
            $time = time() + 180; //测试环境设置成数据生成时3分钟钟后发送
        }else{
            $time = self::sgInstallTimeTrans($time, '') - 7200;
        }
        $data = [
            'orders_id'      => $id,
            'orders_number'  => $number,
            'addtime'        => $time,
            'languages_code' => $_SESSION['languages_code'],
            'num'            => 0
        ];
        zen_db_perform(TABLE_CUSTOMER_APPOINTMENT_QUEUE, $data);
    }

    /**
     * 最终插入数据库的字段
     * @return array
     */
    private function insertColumns()
    {
        return [
            'case_number',
            'customer_name',
            'customer_country',
            'appointment_type',
            'appointment_second_type',
            'appointment_third_type',
            'appointment_fourth_type',
            'market_admin',
            'customer_phone',
            'customer_number',
            'customer_company_name',
            'customer_title',
            'orders_number',
            'customer_remark',
            'customer_remark_file',
            'cancel_remark',
            'appointment_start_time',
            'appointment_end_time',
            'products_ids',
            'customer_address',
            'resource'
        ];
    }

    /**
     * 转换为数字
     *
     * @param $params
     * @return int/array
     */
    private function toBeInt($params)
    {
        if (is_array($params)) {
            foreach ($params as &$param) {
                $param = (int)$param;
            }
        } else {
            $params = (int)$params;
        }
        return $params;
    }

    /**
     * 不同语种的空格展示
     *
     * @return string
     */
    private static function getSpace(){
        if (strtolower($_SESSION['languages_code']) == "jp"){
            return "";
        }else{
            return " ";
        }
    }
}
