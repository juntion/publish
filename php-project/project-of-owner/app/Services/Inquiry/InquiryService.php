<?php

namespace App\Services\Inquiry;

use App\Models\CustomerInquiry;
use App\Models\CustomerInquiryInfo;
use App\Models\CustomerInquiryProducts;
use App\Models\CustomerInquiryProductsAttributes;
use App\Models\CustomerInquiryProductsLength;
use App\Models\Product;
use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use App\Models\CountryTimeZone;
use App\Models\Currencies;

//2019/11/8 add by ternence
class InquiryService extends BaseService
{
    private $CustomerInquiry;
    private $CustomerInquiryInfo;
    private $CustomerInquiryProducts;
    private $CustomerInquiryProductsAttributes;
    private $CustomerInquiryProductsLength;
    private $Products;
    private $currencies;

    public function __construct()
    {
        parent::__construct();
        $this->CustomerInquiry = new CustomerInquiry();
        $this->CustomerInquiryInfo = new CustomerInquiryInfo();
        $this->CustomerInquiryProducts = new CustomerInquiryProducts();
        $this->CustomerInquiryProductsAttributes = new CustomerInquiryProductsAttributes();
        $this->CustomerInquiryProductsLength = new CustomerInquiryProductsLength();
        $this->Products = new Product();
        $this->currencies = new CurrencyService();
    }

    /**
     * 获取报价日期筛选条件
     *
     * @param string $date_type
     * @return string
     */
    public function getInquiryDateTypeSql($date_type = '')
    {
        $sqlWhere = '';
        switch ($date_type) {
            case 'month':
                $sqlWhere = "DATE_SUB(CURDATE(),  INTERVAL 1 MONTH)<= date(created_at)";
                break;
            case 'three_month':
                $sqlWhere = "DATE_SUB(CURDATE(),  INTERVAL 3 MONTH)<= date(created_at)";
                break;
            case 'year':
                $sqlWhere = "DATE_SUB(CURDATE(),  INTERVAL 1 YEAR)<= date(created_at)";
                break;
            case 'one_year_ago':
                $sqlWhere = "DATE_SUB(CURDATE(),  INTERVAL 1 YEAR) > date(created_at)";
                break;
            default:
                $sqlWhere = "";
                break;
        }
        return $sqlWhere;
    }

    //获取一条报价信息
    public function getOneInquiryInfo(
        $customers_id,
        $page = 'all',
        $number = '',
        $where = "",
        $search_key = "",
        $quote_status = ""
    ) {
        $limit = '';
        $productsData = $this->CustomerInquiry->newQuery()
            ->with(['customerInquiryInfo' => function ($query) {
                $query->select('id', 'inquiry_id', 'origin_file_name', 'attachment_path');
            }])
            ->select([
                'id',
                'customers_id',
                'quote_name',
                'firstname',
                'lastname',
                'email',
                'telephone',
                'country_id',
                'company_name',
                'comment',
                'point_ids',
                'admin_id',
                'inquiry_number',
                'status',
                'order_number',
                'created_at',
                'updated_at',
                'all_price',
                'price_code',
                'from_place',
                'order_id'
            ])
            ->where('customers_id', $customers_id);

        if ($search_key) {
            $productsData->where('inquiry_number', $search_key);
        }
        $productsData->where('status', '<>', 5);
        $dateSqlWhere = $this->getInquiryDateTypeSql($where);
        if ($dateSqlWhere) {
            $productsData->whereRaw($dateSqlWhere);
        }
        if ((int)$quote_status>0) {
            if ($quote_status==1) {
                $productsData->whereRaw("order_id is null and status in (1,2,5) and all_price!=0.00");
            }
            if ($quote_status==4) {
                $productsData->whereRaw("order_id is null and status=".$quote_status."");
            }
            if ($quote_status==6) {
                $productsData->whereRaw("order_id > 0 and status=2");
            }
        }

        $productsData->orderBy('created_at', 'DESC');
        if (!$page && $number) {
            $productsData->offset(0);
            $productsData->limit($number);
        } elseif ($page && $number) {
            $begin_page = ($page - 1) * $number;
            $limit = $begin_page . ',' . $number;
            $productsData->offset($begin_page);
            $productsData->limit($number);
        }
        $result = $productsData->get()->toArray();
        if ($result) {
            foreach ($result as $key => $val) {
                $result[$key]['newStatus'] = $val['status'];
                $result[$key]['status'] = $val['status'] = $this->checkAddInquiryStatus(
                    $val['status'],
                    $val['created_at']
                );
                $result[$key]['newStatusStr'] = $this->getInquiryStatusStr($result[$key]['newStatus']);
                $result[$key]['status_str'] = $this->getInquiryStatusStr($val['status']);
                if ($val['status'] == 4 || ($val['status'] == 1 && $val['from_place'] != 4)) {  //来自于前台
                    $result[$key]['updated_at_str'] = $this->getTime(
                        'default',
                        strtotime($val['updated_at']),
                        $this->countries_iso_code
                    );
                } else {  //来自与后台
                    $result[$key]['updated_at_str'] = $this->getTime(
                        'default',
                        strtotime($val['updated_at']),
                        $this->countries_iso_code,
                        '',
                        false
                    );
                }

                if ($val['price_code'] == 'GBP' && $val['status'] != 1) { //需要重新计算
                    if ($val['all_price']=='0.00') {
                        $result[$key]['all_price'] = $val['all_price'] = $this->getOneInquiryAllPrice($val['id'], true);
                    } else {
                        $result[$key]['all_price'] = $val['all_price'] = $this->zenRounds($val['all_price'] * 1.05, 2);
                    }
                }
                if ($val['price_code'] == 'AUD' && $val['status'] != 1) {
                    $result[$key]['all_price_str'] = $this->getPriceStr($val['all_price']*1.1, $val['price_code']);
                } else {
                    $result[$key]['all_price_str'] = $this->getPriceStr($val['all_price'], $val['price_code']);
                }
            }
        }

        return $result;
    }

    /*
     * 公共的方法 - 转换价格字符串
     * @return 价格字符串
     */
    public function getPriceStr($price, $currency)
    {
        $currency_value = $this->zenGetCurrenciesValueOfCode($currency);
        return $this->currencies->format($price, 2, false, $currency, $currency_value);
    }

    public function zenGetCurrenciesValueOfCode($code)
    {
        if ($code) {
            $currencies = new Currencies();
            $curr = $currencies->where('code', $code)->pluck('value');
            return $curr;
        }
    }

    /*
     * 查-统计 - 获取一个报价的所有产品的总价格
     * @param $inquiry_id 报价id
     * @param int $decimal_places: 四舍五入单位
     * @return 评论
     */
    public function getOneInquiryAllPrice($inquiry_id, $for_uk_show = false, $decimal_places = 2)
    {

        $result = $this->CustomerInquiryProducts->where('inquiry_id', $inquiry_id)
            ->get([
                'product_num',
                'price_code',
                'products_id',
                'final_product_price'
            ])->toArray();

        $all_price = 0;

        if ($result) {
            foreach ($result as $key => $val) {
                $current_price = 0;
                if ($val['final_product_price'] != '0.00') {
                    if ($val['price_code']=="AUD" && $_GET['main_page']!="inquiry") {
                        $current_price = $this->zenRounds($val['final_product_price'] * 1.1, 2);
                    } else {
                        if ($for_uk_show) {
                            $current_price = $this->zenRounds($val['final_product_price'] * 1.05, 2);
                        } else {
                            $current_price = $this->zenRounds($val['final_product_price'], $decimal_places);
                        }
                    }
                }
                $all_price += $current_price * $val['product_num'];
            }
        }

        return $all_price;
    }

    /*
* 公共的方法 - 新增的虚拟状态，审查中
* 2018.12.5 fairy
* 等后期可以优化成销售查看状态，在设置成reviewing，可以去掉这个方法
* @param $prefix 前缀
* @return 报价单号字符串
*/
    public function checkAddInquiryStatus($inquiry_status, $created_at)
    {
        if ($inquiry_status == 1) {
            $time_cha = time() - strtotime($created_at);
            if ($time_cha > 12 * 60 * 60) { //大于12小时，设置为审查中
                $inquiry_status = 5;
            } else {
                $inquiry_status = 1;
            }
        }
        return $inquiry_status;
    }


    /*
 * 公共的方法 - 获取 报价状态的 字符串
 * @param $inquiry_status 报价状态
 * @return 字符串
 */
    public function getInquiryStatusStr($inquiry_status)
    {
        $result = '';
        switch ($inquiry_status) {
            case '1':
                $result = self::trans('FS_COMMON_PROCESSING');
                break;
            case '2':
                $result = self::trans('INQUIRY_LISTS_2');
                break;
            case '3':
                $result = self::trans('FS_INQUIRY_DEALED');
                break;
            case '4':
                $result = self::trans('FS_INQUIRY_CANCELED_1');
                break;
            case '5':
                $result = self::trans('FS_COMMON_PROCESSING');
                break;
        }

        return $result;
    }

    // Wrapper function for round()
    public function zenRounds($value, $precision = 2)
    {
        $value = round($value * pow(10, $precision), 0);
        $value = $value / pow(10, $precision);
        return $value;
    }

//当前时区设置
    public function getTime(
        $format = "Y-m-d H:i:s",
        $add = "",
        $code = "",
        $zone = "",
        $is_from_home = true,
        $area = ''
    ) {
        $timezone_out = date_default_timezone_get();

        if (empty($add)) {
            $add = time();
        } else {
            if (!$is_from_home) { // 来自于后台；使用php的时间函数的话：后台是东八区，前台西八区
                $add = $add - 16 * 3600;
            }
        }
        if (empty($area)) {
            if (!empty($code)) {
                $code = strtoupper($code);
                $timezone = new CountryTimeZone();
                $area = $timezone->where('code', $code)->pluck('time_zone');
            }
        }
        if (empty($code) || empty($area)) {
            $area = $timezone_out;
        }
        if ($zone) {
            $area = $zone;
        }
        date_default_timezone_set($area);
        if (strpos($format, 'default') !== false) { //使用的公共的日期表达
            $time = $this->getAllLanguagesDateDisplay($add, $format);
        } else {
            $time = date($format, $add);
            //$time = get_date_product_delivery($time,$this->session['languages_id']);
        }
        date_default_timezone_set("America/Los_Angeles");
        return $time;
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
    public function getAllLanguagesDateDisplay($time, $format = 'default')
    {
        $date = '';
        if ($this->session['languages_code'] == 'de') { // 日/月/年 时:分 Uhr（24小时制）
            if ($format == 'default') {
                //$date =  date('d/m/Y H:i',$time);
                $date = date('d.m.Y', $time) . " " . date('H:i //', $time);
                $date = str_replace('//', 'Uhr', $date);
            } elseif ($format == 'default1') {
                //$date =  date('d/m/Y',$time);
                $date = date('d', $time) . '. ' . $this->getDateDisplayMonth(
                    date('m', $time),
                    $this->language_id
                ) . date(' Y', $time);
            } elseif ($format == 'default2') {
                //$date =  date('d.m.Y H:i /',$time);
                $date = date('d.m.Y', $time) . "<br/> " . date('H:i //', $time);
                $date = str_replace('//', 'Uhr', $date);
            }
        } elseif (in_array($this->session['languages_code'], array('fr', 'ru', 'es', 'mx'))) { // 日/月/年 时:分（24小时制）
            if ($format == 'default') {
                $date = date('d/m/Y H:i', $time);
            } elseif ($format == 'default1') {
                $date = date('d/m/Y', $time);
            } elseif ($format == 'default2') {
                $date = date('d/m/Y', $time) . "<br/> " . date('H:i', $time);
            }
        } elseif ($this->session['languages_code'] == 'jp') { // 年/月/日 午後时:分 （12小时制）
            if ($format == 'default') {
                $date = date('Y/m/d H:i', $time);
                //$date = str_replace('am','午前',$date);
                //$date = str_replace('pm','午後',$date);
            } elseif ($format == 'default1') {
                $date = date('Y年m月d日', $time);
            } elseif ($format == 'default2') {
                $date = date('Y/m/d', $time) . "<br/> " . date('H:i', $time);
                //$date = str_replace('am','',$date);
                //$date = str_replace('pm','',$date);
            }
        } elseif (in_array($this->session['languages_code'], array('uk', 'au', 'dn'))) { // 日/月/年 12h制
            if ($format == 'default') {
                $date = date('d/m/Y h:i a', $time);
            } elseif ($format == 'default1') {
                $date = date('j M, Y', $time);
            } elseif ($format == 'default2') {
                $date = date('d/m/Y', $time) . '<br/> ' . date('h:i a', $time);
            }
        } else { //英语和其他站，月/日/年 时:分 pm
            if ($format == 'default') {
                $date = date('m/d/Y h:i a', $time);
            } elseif ($format == 'default1') {
                $date = date('M j, Y', $time);
            } elseif ($format == 'default2') {
                $date = date('m/d/Y', $time) . '<br/> ' . date('h:i a', $time);
            }
        }
        return $date;
    }

    //小语种获取月份
//邮件显示日期  根据不同小语种站显示不同的国家的时间
    public function getDateDisplayMonth($date, $language_id)
    {
        $month = '';
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
            } elseif ($date == 6) {
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
            } elseif ($date == 12) {
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
            } elseif ($date == 12) {
                $month = 'déc. ';
            }
            $date = $month;
            return $date;
        } elseif ($language_id == 4) {
            if ($date == 1) {
                $month = 'янв ';
            } elseif ($date == 2) {
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
            } elseif ($date == 12) {
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
            } elseif ($date == 6) {
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
            } elseif ($date == 12) {
                $month = 'Dezember ';
            }
            return $month;
        } else {
            return $date;
        }
    }

    /**
     *  inquiry的数量
     * @return mixed
     */
    public function inquiryCount()
    {
        return $this->CustomerInquiry
            ->where([
                'customers_id' => $this->customer_id,
                'status'       => 2])
            ->whereRaw('all_price != 0.00')
            ->whereRaw('order_id is null')
            ->count();
    }
}
