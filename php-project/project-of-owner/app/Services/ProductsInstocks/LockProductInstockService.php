<?php


namespace App\Services\ProductsInstocks;

use App\Services\BaseService;
use App\Models\ProductsInstock;

/**
 * 锁定库存service
 *
 * @author aron
 * @date 2020.7.30
 * Class LockProductInstockService
 * @package App\Services\ProductsInstocks
 */
class LockProductInstockService extends ProductsInstockService
{

    /**
     * 库存锁定
     *
     * @param int $products_id 产品id
     * @param int $is_review 产品发货仓标识
     * @param int $orders_id 订单id
     * @param int $qty 产品购买数量
     * @param array $cn_qty_info 中国仓库存信息
     * @param int $products_instock_id 库存锁定id
     * @author aron
     * @date 2020.7.30
     */
    public function lockQty(
        $products_id = 0,
        $is_review = 0,
        $orders_id = 0,
        $qty = 1,
        $products_instock_id = 0,
        $cn_qty_info = []
    ) {
        switch ($is_review) {
            case 6:
                //德国直发
                $warehouse = 20;
                $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $products_instock_id);
                break;
            case 9:
                //澳洲直发
                $warehouse = 37;
                $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $products_instock_id);
                break;
            case 12:
                //美东直发
                $warehouse = 40;
                $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $products_instock_id);
                break;
            case 24:
                //新加坡直发
                $warehouse = 71;
                $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $products_instock_id);
                break;
            case 26://俄罗斯直发
                //俄罗斯直发
                $warehouse = 67;
                $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $products_instock_id);
                break;
            case 7: //德国国内直发
            case 8: //德国转运
            case 10: //澳大利亚转运
            case 25: //新加坡转运
            case 4: // 国内直发
            case 14: //美东国内发
            case 27: //中国直发俄罗斯
            case 28: //俄罗斯转运
                $cn_qty = $cn_qty_info['current']['qty'] ? $cn_qty_info['current']['qty'] : 0;
                $cn_customez_qty = $cn_qty_info['extra']['qty'] ? $cn_qty_info['extra']['qty'] : 0;
                $current_instock_id = $cn_qty_info['current']['instock_id'] ? $cn_qty_info['current']['instock_id'] : 0;
                $customez_instock_id = $cn_qty_info['extra']['instock_id'] ? $cn_qty_info['extra']['instock_id'] : 0;
                if ($cn_qty > 0 || $cn_customez_qty > 0) {
                    if ($cn_qty >= $qty) {
                        $warehouse = 1;
                        $instock_id = $current_instock_id;
                    } elseif ($cn_customez_qty >= $qty) {
                        $warehouse = 102;
                        $instock_id = $customez_instock_id;
                    }
                    if (isset($warehouse) && isset($instock_id)) {
                        $this->__lockQty($products_id, $warehouse, $orders_id, $qty, $instock_id);
                    }
                }
                break;
        }
    }

    /**
     * 库存锁定
     *
     * @param int $products_id
     * @param int $warehouse
     * @param int $orders_id
     * @param int $qty
     * @param int $products_instock_id 库存锁定id
     * @return bool
     * @author aron
     * @date 2019.7.30
     */
    private function __lockQty($products_id = 0, $warehouse = 0, $orders_id = 0, $qty = 1, $products_instock_id = 0)
    {
        try {
            $instock_id = $products_instock_id;
            if (empty($instock_id)) {
                $data = $this->products_instock_model->select('products_instock_id')
                    ->where('warehouse', $warehouse)
                    ->where('products_id', $products_id)->first();
                if (!empty($data) && !empty($data->products_instock_id)) {
                    $instock_id = $instock_id = $data->products_instock_id;
                }
            }
            if (!empty($instock_id)) {
                $lockData = array(
                    'orders_id' => $orders_id,
                    'products_id' => (int)$products_id,
                    'qty' => $qty,
                    'instock_id' => $instock_id,
                    'date' => date('Y-m-d H:i:s'),
                    'seattle_lock' => 0
                );
                $this->lockModel->create($lockData);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
