<?php


namespace App\Traits;

/**
 * 公用工具方法
 *
 * Trait ToolsTrait
 * @package App\Traits
 */
trait ToolsTrait
{
    use TransTrait;

    public static function zenRand($min = null, $max = null)
    {
        static $seeded;

        if (!isset($seeded)) {
            mt_srand((double)microtime() * 1000000);
            $seeded = true;
        }

        if (isset($min) && isset($max)) {
            if ($min >= $max) {
                return $min;
            } else {
                return mt_rand($min, $max);
            }
        } else {
            return mt_rand();
        }
    }

    public static function zenRound($value, $precision = 2)
    {
        $value = round($value * pow(10, $precision), 0);
        $value = $value / pow(10, $precision);
        return $value;
    }

    /**
     * 判断当前国家是否属于德国仓
     * @param $country_code
     * @param string $code 值为country_number或者country_code
     * @return bool
     */
    public static function germanWarehouse($country_code, $code = "country_number")
    {
        $arr = array();
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        if ($code == "country_code") {
            $arr = array(
                "BE", "FR", "DE", "IT", "NL", "LU", "DK",
                "IE", "ES", "GR", "PT", "AT", "SE", "FI", "MT",
                "CY", "PL", "HU", "CZ", "SK", "SI", "EE", "LV",
                "LT", "RO", "BG", "HR", "MC");
        } elseif ($code == "country_number") {
            $arr = array(
                21, 73, 81, 105, 150, 124,
                57, 103, 195, 84, 171, 14, 203,
                72, 132, 55, 170, 97, 56, 189,
                190, 67, 117, 123, 175, 33, 53, 141);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    //其它欧洲国家
    public static function otherEuWarehouse($country_code, $code = "country_number")
    {
        $arr = array();
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        if ($code == "country_code") {
            $arr = array(
                "IS", "BA", "RS", "ME", "MK", "AL", "MD",
                "NO", "CH", "AD", "LI", "SM", "JE", "FO",
                "GL", "GP", "GF", "MQ", "YT", "AW", "IC", 'GG', "VA" , "GB", 'IM', "BL", "MF"); //英国脱欧
        } elseif ($code == "country_number") {
            $arr = array(98, 27, 236, 242, 126, 2, 140, 160, 204, 5, 122, 182,
                245, 70, 85, 87, 75, 134, 137, 12, 250, 243, 228, 222, 244, 253, 254);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    public static function allGermanWarehouse($country_code, $code = "country_number")
    {
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        if (self::germanWarehouse($country_code, $code) || self::otherEuWarehouse($country_code, $code)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 根据国家判断 西雅图仓
     * @param string $country_code
     * @param $code
     * @return bool
     */
    public static function seattleWarehouse($country_code, $code = "country_number")
    {
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        $arr = [];
        if ($code == "country_code") {
            $arr = array("US", "MX", "CA", "PR");
        } elseif ($code == "country_number") {
            $arr = array(38, 223, 138, 172);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 澳大利亚仓
     * @param $country_code
     * @param string $code
     * @return bool
     */
    public static function auWarehouse($country_code, $code = "country_number")
    {
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        $arr = [];
        if ($code == "country_code") {
            $arr = array("AU", "NZ");
        } elseif ($code == "country_number") {
            $arr = array(13, 153);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断当前国家是否属于新加坡仓
     * @param $country_code
     * @param string $code
     * @return bool
     */
    public static function singaporeWarehouse($country_code, $code = "country_number")
    {
        $arr = array();
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        if ($code == "country_code") {
            $arr = array("SG", "KH", "LA", "MY", "TL", "ID", "BN", "MM", "PH", "TH", "VN");
        } elseif ($code == "country_number") {
            $arr = array(32, 100, 36, 116, 146, 129, 168, 188, 209, 61, 230);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断当前国家是否属于俄罗斯仓
     * @param $country_code
     * @param string $code
     * @return bool
     */
    public static function ruWarehouse($country_code, $code = "country_number")
    {
        $arr = array();
        if (!is_numeric($country_code)) {
            $country_code = strtoupper($country_code);
        }
        if ($code == "country_code") {
            $arr = array("RU");
        } elseif ($code == "country_number") {
            $arr = array(176);
        }
        if (in_array($country_code, $arr)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取当前国家所对应的仓库 判断产品在当前仓是否展示
     * @param $countries_code
     * @return array
     */
    public static function fsProductsWarehouseWhere($countries_code)
    {
        if (self::allGermanWarehouse($countries_code, 'country_code')) {
            //德国仓
            $code = 'de';
            $where = ' and de_status=1 ';
        } elseif (self::seattleWarehouse($countries_code, 'country_code')) {
            //西雅图仓
            $code = 'us';
            $where = ' and us_status=1 ';
        } elseif (self::auWarehouse($countries_code, 'country_code')) {
            //澳大利亚仓
            $code = 'au';
            $where = ' and au_status=1 ';
        } elseif (self::singaporeWarehouse($countries_code, 'country_code')) {
            //新加坡仓库
            $code = 'sg';
            $where = ' and sg_status=1 ';
        } elseif (self::ruWarehouse($countries_code, 'country_code')) {
            //俄罗斯仓库
            $code = 'ru';
            $where = ' and ru_status=1 ';
        } else {
            $code = 'cn';
            $where = ' and cn_status=1 ';
        }
        $data = array('code' => $code, 'where' => $where);
        return $data;
    }

    /**
     * 格式化价格
     * @param $price
     * @param int $rate
     * @param int $decimals
     * @param int $precision
     * @param string $de_point
     * @return float|int|string
     */
    public static function getFormatNmber($price, $rate = 1, $decimals = 2, $precision = 2, $de_point = '.')
    {
        $price = round($price * pow(10, $precision), 0);
        $price = $price / pow(10, $precision);
        $price = number_format($price * $rate, $decimals, $de_point, '');

        return $price;
    }


    public static function zenChangeUrl($src)
    {
        $src_arr = explode('/', $src);
        $last_element = end($src_arr);
        if (preg_match("/^(http|https)/", $src_arr[0]) || empty($src_arr[0])) {
            if (preg_match("/(www.fs.com|img-en.fs.com|static.whgxwl.com:6060)/", $src_arr[2])) {
                unset($src_arr[1]);
                unset($src_arr[2]);
                if (in_array(substr($last_element, strrpos($last_element, '.') + 1), array("css", "js"))) {
                    //css和js文件要把域名后的个小语种站点的code也去掉
                    $site_arr = ['sg', 'au', 'uk', 'es', 'mx', 'de', 'de-en', 'ru', 'jp', 'fr'];
                    if (in_array(trim($src_arr[3]), $site_arr)) {
                        unset($src_arr[3]);
                    }
                    if (trim($src_arr[4]) == 'en') {
                        //德英站的de/en后面的en也要去掉
                        unset($src_arr[4]);
                    }
                }
            }
            unset($src_arr[0]);
        }
        $real_src = implode('/', $src_arr);
        return $real_src;
    }

    /**
     * 图片路径处理，全站统一调用
     *
     * @author aron
     * @date 2019.11.11
     * @param $src
     * @return string
     */
    public static function imagePath($src)
    {
        if ($src) {
            $src = self::zenChangeUrl($src);
            if (self::trans('STATIC_RESOURCE_UP')) {
                $src = self:: trans("HTTPS_IMAGE_SERVER") . $src;
            }
        }
        return $src;
    }

    /**
     * 根据订单状态获取颜色样式
     * @param $status 订单状态
     * @return string
     */
    public static function getOrderStatusClass($status)
    {
        if ($status == '1') {
            $statusClass = 'red';
        } elseif ($status == '4' || $status == '5') {
            $statusClass = 'gray';
        } else {
            $statusClass = 'green';
        }
        return $statusClass;
    }

    /**
     * 获取下单订单的付款方式
     * @param $payment_method
     * @param $delivery_country_id
     * @return string
     */
    public static function zenGetOrderPaymentMethod($payment_method, $delivery_country_id = '')
    {
        switch (1) {
            case preg_match('/paypal/i', $payment_method):
                $method = self:: trans("FS_PAY_WAY_PAYPAL");
                break;
            case preg_match('/west/i', $payment_method):
                $method = self:: trans("FS_PRINT_ORDER_WESTERN");
                break;
            case preg_match('/hsbc/i', $payment_method):
                if (in_array($delivery_country_id, [223,172])) {
                    $method = self:: trans("PAYMENT_BANK_ACH");
                } elseif (in_array($delivery_country_id, [38,138])) {
                    $method = self:: trans("PAYMENT_BANK_ACH_CA");
                } else {
                    $method = self:: trans("FS_PRINT_ORDER_BANK");
                }
                break;
            case preg_match('/purchase/i', $payment_method):
                $method = self:: trans("FS_PRINT_ORDER_PURCHASE");
                break;
            case preg_match('/globalcollect/i', $payment_method):
                $method = self:: trans("FS_PRINT_ORDER_CREDIT");
                break;
            case preg_match('/echeck/i', $payment_method):
                $method = self:: trans("FS_CHECKOUT_NEW42");
                break;
            case preg_match('/payeezy/i', $payment_method):
                $method = self:: trans("FS_PRINT_ORDER_CREDIT");
                break;
            case preg_match('/alfa/i', $payment_method):
                $method = self:: trans("FS_CHECKOUT_NEW_CASHLESS");
                break;
            case preg_match('/bpay/i', $payment_method):
                $method = self:: trans("FS_CHECKOUT_NEW35");
                break;
            default:
                $method = $payment_method;
                break;
        }
        return $method;
    }

    /**
     * @author potato
     * array_column函数只支持5.5+，所以重写改方法
     * @param $input 数组
     * @param $columnKey
     * @param null $indexKey
     * @return array
     */
    public function arrayColumnNew($input, $columnKey, $indexKey = null)
    {
        if (!function_exists('array_column')) {
            $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
            $indexKeyIsNull            = (is_null($indexKey))?true :false;
            $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
            $result                         = array();
            foreach ((array)$input as $key => $row) {
                if ($columnKeyIsNumber) {
                    $tmp= array_slice($row, $columnKey, 1);
                    $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
                } else {
                    $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
                }
                if (!$indexKeyIsNull) {
                    if ($indexKeyIsNumber) {
                        $key = array_slice($row, $indexKey, 1);
                        $key = (is_array($key) && !empty($key))?current($key):null;
                        $key = is_null($key)?0:$key;
                    } else {
                        $key = isset($row[$indexKey])?$row[$indexKey]:0;
                    }
                }
                $result[$key] = $tmp;
            }
            return $result;
        } else {
            return array_column($input, $columnKey, $indexKey);
        }
    }

    /**
     * 获取订单日期筛选条件
     * @param string $date_type
     * @param string $sql_str
     * @return string
     */
    public function getDateTypeFormatSql($date_type = '', $sql_str = '')
    {
        switch ($date_type) {
            case 'month':   // Latest Month
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 MONTH)<= date('.$sql_str.')';
                break;
            case 'three_month':     // Latest 3 Months
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 3 MONTH)<= date('.$sql_str.')';
                break;
            case 'year':    // Latest Year
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 YEAR)<= date('.$sql_str.')';
                break;
            case 'one_year_ago':    //One Year Ago
                $sqlWhere = 'DATE_SUB(CURDATE(),  INTERVAL 1 YEAR) > date('.$sql_str.')';
                break;
            default:
                $sqlWhere = '';
                break;
        }
        return $sqlWhere;
    }


    /**
     * 识别文本中的链接加上A标签
     *
     * @param string $text
     * @return string
     */
    public function autoLink($text = '')
    {
        if ((strpos($text, 'target="_blank"') && !strpos($text, '></a>')) || $text == '') {
            return $text;
        } else {
            if (strpos($text, '</a>')) {
                $text = str_replace('<a', '<a target="_blank"', $text);
            } else {
                $domainList = array("com", "cn", "edu", "org", "net", "info", "int");
                $domainReg = implode("|", $domainList);

                $urlReg = "/(((http|https|ftp|ftps|www)\:\/\/)?[a-zA-Z0-9\-\.]+\.($domainReg)(\/\S*)?)/";
                if (preg_match($urlReg, $text)) {
                    $text_arr = explode(',', $text);
                    $text = '';
                    $i = 0;
                    foreach ($text_arr as $v) {
                        $i++;
                        $text .= preg_replace($urlReg, "<a href=\"http://$1\" target=\"_blank\">$1</a>", $v);
                        if ($i != sizeof($text_arr)) {
                            $text .= ',';
                        }
                    }
                }

                $text = str_replace("http://http://", "http://", $text);
                $text = str_replace("http://http://", "http://", $text);
                $text = str_replace("http://https://", "https://", $text);
                $text = str_replace("http://ftp://", "ftp://", $text);
                $text = str_replace("http://ftps://", "ftps://", $text);
            }
            return $text;
        }
    }

    /**
     * 文本中的换行
     *
     * @param string $text
     * @return string
     */
    public function autoNextLine($text = '')
    {
        if ($text == '') {
            return $text;
        }
        if (strpos($text, '\n')) {
            return str_replace(['\r\n', '\n'], '<br>', $text);
        } else {
            return json_decode(str_replace(['\r\n', '\n'], '<br>', json_encode($text)));
        }
    }

    /**
     * 根据不同站点获取对应的国家名称字段
     * @param int $language_id
     * @return string
     */
    public static function getCountriesNameFields($language_id = 1)
    {
        switch ($language_id) {
            case 2:
                $field_name = 'es_countries_name';
                break;
            case 3:
                $field_name = 'fr_countries_name';
                break;

            case 4:
                $field_name = 'ru_countries_name';
                break;
            case 5:
                $field_name = 'de_countries_name';
                break;
            case 8:
                $field_name = 'jp_countries_name';
                break;
            case 14:
                $field_name = 'it_countries_name';
                break;
            default:
                $field_name = 'countries_name';
                break;
        }
        return $field_name;
    }

    /**
     *
     *
     * @param $value
     * @return bool
     */
    public static function zenNotNull($value)
    {
        if (is_array($value)) {
            if (sizeof($value) > 0) {
                return true;
            } else {
                return false;
            }
        } elseif (is_a($value, 'queryFactoryResult')) {
            if (sizeof($value->result) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function encryptUrl($url, $key)
    {
        return rawurlencode(base64_encode(self::encrypt($url, $key)));
    }

    public static function encrypt($txt, $key)
    {
        $encrypt_key = md5(mt_rand(0, 100));
        $ctr = 0;
        $tmp = "";
        for ($i = 0, $iMax = strlen($txt); $i < $iMax; $i++) {
            if ($ctr == strlen($encrypt_key)) {
                $ctr = 0;
            }
            $tmp .= substr($encrypt_key, $ctr, 1) . (substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
            $ctr++;
        }
        return self::keyED($tmp, $key);
    }

    public static function keyED($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = "";
        for ($i = 0, $iMax = strlen($txt); $i < $iMax; $i++) {
            if ($ctr == strlen($encrypt_key)) {
                $ctr = 0;
            }
            $tmp .= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1);
            $ctr++;
        }
        return $tmp;
    }

    /**
     * $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
     * Output a raw date string in the selected locale date format
     * @param $raw_date
     * @return bool|string
     */
    public static function zenDateLong($raw_date)
    {
        if (($raw_date == '0001-01-01 00:00:00') || ($raw_date == '')) {
            return false;
        }

        $year = (int)substr($raw_date, 0, 4);
        $month = (int)substr($raw_date, 5, 2);
        $day = (int)substr($raw_date, 8, 2);
        $hour = (int)substr($raw_date, 11, 2);
        $minute = (int)substr($raw_date, 14, 2);
        $second = (int)substr($raw_date, 17, 2);

        return strftime(self::trans('DATE_FORMAT_LONG'), mktime($hour, $minute, $second, $month, $day, $year));
    }

    /**
     * Output a raw date string in the selected locale date format
     * $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
     * NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
     * @param $raw_date
     * @return bool|false|string|string[]|null
     */
    public static function zenDateShort($raw_date)
    {
        if (($raw_date == '0001-01-01 00:00:00') || empty($raw_date)) {
            return false;
        }
        $year = substr($raw_date, 0, 4);
        $month = (int)substr($raw_date, 5, 2);
        $day = (int)substr($raw_date, 8, 2);
        $hour = (int)substr($raw_date, 11, 2);
        $minute = (int)substr($raw_date, 14, 2);
        $second = (int)substr($raw_date, 17, 2);

        // error on 1969 only allows for leap year
        $dateFormat = self::trans('DATE_FORMAT');
        if ($year != 1969 && @date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
            return date($dateFormat, mktime($hour, $minute, $second, $month, $day, $year));
        }
        return preg_replace('/2037$/', $year, date($dateFormat, mktime($hour, $minute, $second, $month, $day, 2037)));
    }

    /**
     * @param $code
     * @return string
     */
    public static function getLinkLang($code)
    {
        $code = strtolower(trim((string)$code));
        $siteArr = [
            'sg'    => 'sg',
            'au'    => 'au',
            'uk'    => 'uk',
            'es'    => 'es',
            'mx'    => 'ma',
            'de'    => 'de',
            'dn'    => 'de-en',
            'de-en' => 'de-en',
            'ru'    => 'ru',
            'jp'    => 'jp',
            'fr'    => 'fr',
            'it'    => 'it',
        ];
        return isset($siteArr[$code]) ? $siteArr[$code] : '';
    }

    /**
     * 判断是否为json
     *
     * @param $str
     * @return bool
     */
    public function is_not_json($str)
    {
        return is_null(json_decode($str));
    }


    /**
     * @param $zip_code 待验证的邮编
     * @param $post_array 邮编长字符串
     * @param $str_param 分割字符
     * @return bool
     */
    public static function checkAuZipCode($zip_code, $post_array, $str_param)
    {
        $check_flag = false;
        foreach ($post_array as $value) {
            $val = $value[0];
            $val_array = explode($str_param, $val);
            foreach ($val_array as $val_num) {
                if (strpos($val_num, '-')) {
                    $val_num = explode('-', $val_num);
                    $val_start = $val_num[0];
                    $val_end = $val_num[1];
                    if ($zip_code >= $val_start && $zip_code <= $val_end) {
                        $check_flag = true;
                        break;
                    }
                } else {
                    if ($zip_code == $val_num && !empty($val_num)) {
                        $check_flag = true;
                        break;
                    }
                }
            }
            if ($check_flag) {
                break;
            }
        }
        return $check_flag;
    }

    /**
     * 获取最终产品价格
     * @param $price
     * @param $integer
     * @param $currency_value
     * @return float|int
     */
    public function getFormatProductsPrice($price, $integer, $currency_value, $member_rate, $decimal)
    {
        $currency_price = $price * $currency_value;

        if ($integer == 1) {//价格取整
            $currency_price = $this->getIntFormatPrice($currency_price);
        } else {
            $currency_price = $this->getFormatPrice($currency_price);
        }

        //是企业会员
        if ($member_rate != 1) {
            $currency_price = round($currency_price * $member_rate, $decimal);
        }

        $final_price = $currency_price / $currency_value;

        return $final_price;
    }

    /**
     * 获取非整数格式化产品价格
     * @param $price
     * @return float|int
     */
    public function getFormatPrice($price)
    {
        $products_price = round($price, 2);

        switch (true) {
            case $products_price < 1:
                $products_price = round($products_price, 2);
                break;
            case $products_price >= 1 && $products_price < 10:
                $products_price = round($products_price, 1);
                break;
            case $products_price >= 10 && $products_price < 100:
                $products_price = round($products_price, 0);
                break;
            case $products_price >= 100 && $products_price < 1000:
                $products_price = round($products_price / 10, 0) * 10;
                break;
            case $products_price >= 1000 && $products_price < 10000:
                $products_price = round($products_price / 100, 0) * 100;
                break;
            case $products_price >= 10000:
                $products_price = round($products_price / 1000, 0) * 1000;
                break;
        }

        return $products_price;
    }

    /**
     * 获取整数格式化产品价格
     * @param $price
     * @return float|int
     */
    public function getIntFormatPrice($price)
    {
        $products_price = round($price, 2);

        switch (true) {
            case $products_price < 1:
                $products_price = round($products_price, 2);
                break;
            case $products_price >= 1 && $products_price < 10:
                $products_price = round($products_price, 1);
                break;
            case $products_price >= 10:
                $products_price = round($products_price, 0);
                break;
        }

        return $products_price;
    }


    /**
     * 获取表格语种简称
     * @param string $langauge_code
     * @return string
     */
    public function getTableLanguageCode($langauge_code = 'en')
    {
        $code = $langauge_code;
        switch ($langauge_code) {
            case 'en':
            case 'au':
            case 'uk':
            case 'dn':
            case 'sg':
                $code = 'en';
                break;
            case 'mx':
                $code = 'es';
                break;
        }
        return $code;
    }

    public function auUseGspTax($country = '')
    {
        $country = $country ?: $_SESSION['countries_iso_code'];
        if (strtoupper($country) != 'AU') {
            return false;
        }

        return true;
    }

    /**
     * @param $diff_time
     * @param string $stamp
     * @return array
     */
    public function getWhereTimeStamp($diff_time, $stamp = '')
    {
        $stamp = empty($stamp) ? time() : (int)$stamp;

        $res_stamp = $stamp;
        switch ($diff_time){
            case 1:
                $res_stamp = $stamp - 86400 * 30;
                break;
            case 2:
                $res_stamp = $stamp - 86400 * 30 * 3;
                break;
            case 3:
            case 4:
                $res_stamp = $stamp - 86400 * 30 * 24;
                break;
        }

        return array('min' => $res_stamp, 'max' => $stamp);
    }

    /**
     * $Notes: 生成并导出csv文件
     *
     * $author: Quest
     * $Date: 2021/1/14
     * $Time: 15:20
     * @param $data
     * @param $file_name
     * @param $header
     */
    public function ExportBillsCsv($data, $file_name, $header)
    {
        ob_end_clean();
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $file_name);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        $fp = fopen('php://output','a');
        foreach ($header as $i => $v) {
            $header[$i] = iconv('utf-8', 'utf-8//TRANSLIT', $v);
        }
        fputcsv($fp, $header);
        foreach ($data as $i => $v){
            $header[$i] = iconv('utf-8', 'gb2312//IGNORE', $v);
            $v = str_replace('&nbsp;',' ',$v);
            $v = str_replace('&pound;','£',$v);
            fputcsv($fp, $v);
        }
        unset($data);
        ob_flush();
        flush();
        die;
    }

    /**
     * $Notes: 转换为GBK格式
     *
     * $author: Quest
     * $Date: 2021/1/14
     * $Time: 15:22
     * @param $data
     * @return string
     */
    public function utfToGbk($data)
    {
        return iconv("utf-8","gb2312", $data);
    }

}
