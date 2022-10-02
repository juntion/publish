<?php
/**
 * Notes:
 * File name:OrderMiddleField
 * Create by: Jay.Li
 * Created on: 2020/6/29 0029 18:31
 */


namespace App\Services\Orders;

use App\Services\BaseService;
use App\Models\OrderMiddleFields;

class OrderMiddleField extends BaseService
{
    private $orderMiddle;

    public function __construct()
    {
        parent::__construct();

        $this->orderMiddle = new OrderMiddleFields();
    }

    /**
     * Notes:过滤字段
     * User: LiYi
     * Date: 2020/6/29 0029
     * Time: 18:38
     * @param $array
     * @return mixed
     */
    protected function fillData($array)
    {
        $this->orderMiddle->fillable;

        foreach ($array as $k => $item) {
            if (in_array($item, $this->orderMiddle->fillable)) {
                continue;
            }
            unset($array[$k]);
        }

        return $array;
    }


    /**
     * Notes: 添加字段
     * User: LiYi
     * Date: 2020/6/29 0029
     * Time: 18:38
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        try {
            $res = $this->orderMiddle->create($data);

            if (empty($res)) {
                throw new \Exception('error');
            }

            $res = true;
        } catch (\Exception $e) {
            $res = false;
        }

        return $res;
    }
}
