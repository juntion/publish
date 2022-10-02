<?php

/**
 * Class ProductsSalesStatisticsService
 *
 * ery 2020.11.23 add
 * 产品销量统计
 */

namespace App\Services\Products;

use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager as DB;

class ProductsSalesStatisticsService extends BaseService
{

    private $db;
    public $products_id;
    public $products_id_arr; //多个产品数组。和$products_id，2个选择一个就可以。

    public function __construct(){
        parent::__construct();

        $this->db = new DB();
    }

    /**
     * 获取某个产品的统计的总销量的内部方法，是复制后台的方法
     * ery 2020.11.27 add
     * @param string $val
     * @param array $orderType
     * @return string
     */
    private function  fs_pis_conditions($val = 'common', $orderType = []){
        $whereSql = '';
        switch ($val) {
            case 'new': /*新单条件*/
                $whereSql = ' pis.delete_orders_payment =0 
                AND pis.sales_admin > 0 
                AND (pis.order_number !="" OR pis.order_invoice !="") 
                AND pis.change_order =0  
                AND pis.click_status = 1
                AND pis.`is_split` !=1 
                AND (pis.`is_seattle` != 1 OR pis.`origin_id` > 0 OR (pis.`is_seattle` > 0 AND pis.product_length = 0))';
                break;
            case 'common': /*公共部分条件*/
                $whereSql = ' pis.separate_order_status = 0
                AND pis.`is_inspection` IN (0,3) 
                AND (pis.`is_clientArea` !=1 OR pis.shipping_date >"0000-00-00 00:00:00")
                AND pis.`is_return` = 0
                AND pis.is_sample IN (0,1) 
                AND pis.finance_time > "0000-00-00 00:00:00" ';
            break;
        }
        return $whereSql;
    }

    /**
     * 获取某个产品的统计的月销量
     * ery 2020.11.27 add
     * @return array
     */
    public function getStatisticTotalSales(&$return_data=[]){
        $groupListSql = ' pisi.sales_products_id as products_id, ';
        $groupColumnsSql = " GROUP BY pisi.sales_products_id ";

        $fieldSql = ' sum(products_num) as count ';

        if(!empty($this->products_id_arr)){
            $conditionSql = ' and pisi.sales_products_id in ('.implode(',',$this->products_id_arr).') ';
        } else if ($this->products_id) {
            $conditionSql = ' and pisi.sales_products_id ='.$this->products_id;
        } else {
            $conditionSql = ' ';
        }
        $sql = "SELECT 
             {$groupListSql}
              {$fieldSql}
         FROM
             products_instock_shipping AS pis
         LEFT JOIN products_instock_shipping_info AS pisi ON (
             pisi.products_instock_id = pis.products_instock_id
         )
         WHERE
            pis.cancel_order_status = 0
         AND pisi.is_change NOT IN (3,5) AND "
            . $this->fs_pis_conditions('new') . " AND "
            . $this->fs_pis_conditions('common')
            . "{$conditionSql}{$groupColumnsSql}";

        $result = $this->db->connection()->select($sql);
        //var_dump($result);exit();

        if(!empty($this->products_id_arr)){
            foreach ($this->products_id_arr as $key => $val){
                $return_data[$val] = 0;
            }
            if($result){
                foreach ($result as $key => $val){
                    $return_data[$val['products_id']] = $val['count'];
                }
            }
        }else{
            $return_data[$this->products_id] = $result?$result[0]['count']:0;
        }
        return $return_data;
    }

    /**
     * 获取某个产品的最终展示的总销量展示
     * ery 2020.11.27 add
     * @param int $number
     * @return string
     */
    public function handleTotalSalesShow($number){
        //展示逻辑
        if($number < 10000){
            $number_str = $number;
        }elseif ($number>=10000 && $number<1000000){
            $start_number = substr($number,0,2);
            $end_number = substr($number,2);
            $end_number_length = strlen($end_number);
            $new_number = $start_number.'.'.$end_number;
            $new_number = round($new_number);
            $number_str = number_format($new_number * pow(10,$end_number_length)).'+';
        }else{
            $number_str = '1,000,000+';
        }

        return $number_str;
    }

}
