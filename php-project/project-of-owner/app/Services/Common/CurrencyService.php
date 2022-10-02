<?php


namespace App\Services\Common;

use App\Models\Currency as Cu;
use App\Services\BaseService;

class CurrencyService extends BaseService
{
    // 所有币种的信息数组
    public $currencies;
    // currency模型对象
    //private $currency;
    // 当前币种
    public $current_currency_type;
    // 当前币种的汇率
    public $current_currency_value;

    /**
     * 价格货币处理
     *
     * @param string $currencyCode
     * @author aron
     * @date 2019.10.15
     * CurrencyService constructor.
     */
    public function __construct($currencyCode = 'USD')
    {
        parent::__construct();

        $this->currency = new Cu();
        $data = $this->currency->getAllCurrency();
        foreach ($data as $v) {
            $this->currencies[$v['code']] = array('title' => $v['title'],
                'symbol_left' => !empty($v['symbol_right']) ? '' : $v['symbol_left'],
                'symbol_google_left' => $v['symbol_google_left'],
                'symbol_var' => $v['symbol_var'],
                'symbol_right' => $v['symbol_right'],
                'decimal_point' => $v['decimal_point'],
                'thousands_point' => $v['thousands_point'],
                'decimal_places' => $v['decimal_places'],
                'value' => $v['value']);
        }

        // 当前网站的币种
        $this->current_currency_type = $currencyCode;
        $this->current_currency_value = $this->currencies[$this->current_currency_type]['value'];
    }

    /**
     * @param int $number: 必填。价格
     * @param int $integer_state:
     *      产品表product中的integer_state字段。产品价格取整判断。
     *      0取整，1不取整 ，2是价格不需要取整或不取整操作
     * @param bool $calculate_currency_value: 是否计算汇率。
     * @param string $currency_type
     * @param string $currency_value
     * @param bool $is_symbol
     * @return string
     */
    public function format(
        $number = 0,
        $integer_state = 2,
        $calculate_currency_value = true,
        $currency_type = '',
        $currency_value = '',
        $is_symbol = true
    ) {
        $currency_type = !empty($currency_type) ? $currency_type : $this->current_currency_type;
        $rate = !empty($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];

        if ($calculate_currency_value == true) {
            $num = $number * $rate;
            $num = $this->getProductFinalPrice($num, $integer_state);
        } else {
            $num = $number;
        }

        $string = number_format(
            self::zenRound(
                $num,
                $this->currencies[$currency_type]['decimal_places']
            ),
            $this->currencies[$currency_type]['decimal_places'],
            $this->currencies[$currency_type]['decimal_point'],
            $this->currencies[$currency_type]['thousands_point']
        );

        //俄语站价格特殊展示
        $string = $currency_type == 'RUB' ? str_replace(',', ' ', $string) : $string;

        if ($is_symbol) {
            $format_string = $this->currencies[$currency_type]['symbol_left'] . $string .
                $this->currencies[$currency_type]['symbol_right'];
        } else {
            $format_string = $string;
        }

        return $format_string;
    }


    /**
     * 产品价格取整规则
     *
     * @param float $price
     * @return float|int
     */
    private function getOtherProductPrice($price)
    {
        $products_price = round($price, 2);
        if ($products_price<1) {
            $products_price = round($products_price, 2);
        } elseif ($products_price>=1 && $products_price<10) {
            $products_price = round($products_price, 1);
        } elseif ($products_price>=10 && $products_price<100) {
            $products_price = round($products_price, 0);
        } elseif ($products_price>=100 && $products_price<1000) {
            $products_price = round($products_price/10, 0)*10;
        } elseif ($products_price>=1000 && $products_price<10000) {
            $products_price = round($products_price/100, 0)*100;
        } elseif ($products_price>=10000) {
            $products_price = round($products_price/1000, 0)*1000;
        }

        return $products_price;
    }

    /**
     * 产品价格不取整规则
     *
     * @param float $price
     * @return float|int
     */
    private function getSpecialProductPrice($price)
    {
        $products_price = round($price, 2);
        if ($products_price<1) {
            $products_price = round($products_price, 2);
        } elseif ($products_price>=1 && $products_price<10) {
            $products_price = round($products_price, 1);
        } elseif ($products_price>=10) {
            $products_price = round($products_price, 0);
        }
        return $products_price;
    }

    /**
     * 经过取整规则之后的价格
     *
     * @param float $num: 是计算汇率之后的价格
     * @param int $integer_state
     * @return float|int
     */
    public function getProductFinalPrice($num, $integer_state)
    {
        if ($integer_state == 1) { //产品价格不取整
            $num = $this->getSpecialProductPrice($num);
        } elseif ($integer_state == 0) { // 产品价格取整
            $num = $this->getOtherProductPrice($num);
        }
        // 其他情况。比如计算属性价格。不需要任何取整
        return $num;
    }

    /**
     * 根据取整规则，美元把转换成对应币种，在转化成美元。
     * 为产品属性计算提供正确的基本属性价格
     *
     * @param float $num: 是计算汇率之前的价格
     * @param int $special_product
     * @return float|int
     */
    public function getWholeDollarPrice($num, $special_product)
    {
        // 根据取整规则，美元把转换成对应币种
        $num = $num*$this->current_currency_value;
        // 这里本应该调用getProductFinalPrice方法。但是原来代码有bug，只调用了统一取整。
        $num = $this->getProductFinalPrice($num, $special_product);
        // 在转化成美元
        $num = $num/$this->current_currency_value;
        return $num;
    }

    /**
     * 获取当前汇率
     * 因为其他server调用是使用门典类的方式。导致不能\Currency直接获取属性。加了这个方法
     *
     * @return mixed
     */
    public function getCurrentCurrencyValue()
    {
        return $this->current_currency_value;
    }

    public function findCurrenciesValue($where, $fields)
    {
        try {
            $result = $this->currencies->where($where)->first($fields);
            if (empty($result)) {
                throw new \Exception('ERROR!');
            }
            $result = $result->toArray();
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}
