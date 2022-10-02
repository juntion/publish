<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/26
 * Time: 3:04
 */

namespace App\Services\Saved;

use App\Models\CustomersSaved;
use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager as DB;

class CustomersSavedService extends BaseService
{
    private $customersSavedObj;

    private $fields = ['customers_saved_id', 'add_time', 'user_save_time', 'cart_value', 'is_new'];

    public function __construct()
    {
        parent::__construct();
        $this->customersSavedObj = new CustomersSaved();
    }

    /**
     *  购物车列表页
     * @param string $type
     * @param string $cart_name
     * @param string $limit
     * @param $is_need_total
     * @return mixed
     */
    public function getCartList($type = '', $cart_name = '', $limit = '', $is_need_total = 1)
    {
        $cart_where = $this->customersSavedObj
            ->select($this->fields)
            ->where('customer_id', $this->customer_id)
            ->where('cart_value', '!=', '');
        $cart_time = [
            'month' => strtotime("-1 month"),
            'three_month' => strtotime("-3 month"),
            'year' => strtotime("-1 year"),
        ];
        if ($type && in_array($type, ['all', 'month', 'three_month', 'year', 'one_year_ago'])) {
            if ($type == 'one_year_ago') {
                $cart_where->where('add_time', '<', $cart_time['year']);
            } else {
                if ($type !== 'all') {
                    $cart_where->where('add_time', '>', $cart_time[$type]);
                }
            }
        }
        if ($cart_name) {
            $cart_where->where('user_save_time', 'like', '%' . $cart_name . '%');
        }
        if ($is_need_total > 0) {
            $cart_count = $cart_where->count();
            $result['count'] = $cart_count;
        }
        $result['data'] = $cart_where
            ->orderBy('add_time', 'desc')
            ->offset($limit['start'])
            ->limit($limit['num'])
            ->get($this->fields)
            ->toArray();
        return $result;
    }

    /**
     * 购物车总数量
     * @return mixed
     */
    public function getCartTotal()
    {
        return $this->customersSavedObj
            ->where([
                'customer_id' => $this->customer_id
            ])
            ->count();
    }

    /**
     * 购物车详情页
     * @param string $cart_id
     * @return mixed
     */
    public function getCartDetail($cart_id = '')
    {
        $where = [
            'customer_id' => $this->customer_id
        ];
        if ($cart_id) {
            $where['customers_saved_id'] = $cart_id;
        }
        $data = $this->customersSavedObj
            ->where($where)
            ->get($this->fields)
            ->toArray();
        return $data;
    }

    /**
     *  条件查询
     * @param $where
     * @param array $fields
     * @return array
     */
    public function savedCartInfo($where, $fields = ['*'])
    {
        $data = $this->customersSavedObj
            ->orderBy('customers_saved_id', 'desc')
            ->where($where)
            ->get($fields)
            ->toArray();
        if (!$data) {
            $data = [];
        }
        return $data;
    }
}
