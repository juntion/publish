<?php

namespace App\Services\OrderSplit;

use App\Models\OrderSplit;
use App\Models\OrderSplitProduct;
use App\Models\OrderSplitProductAttribute;
use App\Models\OrderProductLength;
use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use App\Services\Products\ProductLengthService;
use App\Services\Products\ProductOptionService;
use App\Models\ProductThumbImage;
use App\Services\Rma\RmaService;
use Illuminate\Database\Capsule\Manager as DB;

class OrderSplitProductService extends BaseService
{
    public $orderProductObj;
    private $orderProductAttributeObj;
    private $orderProductLengthObj;
    private $Cu;    //货币对象
    private $productThumbImage;
    private $checkboxOptions = [];
    //默认产品图片尺寸
    private $defaultImageZie = ['size_w'=>100,'size_h'=>100];
    //是否加载订单产品评论表
    private $isLoadReview = false;

    public function __construct()
    {
        parent::__construct();

        $this->orderProductObj = new OrderSplitProduct();
        $this->orderProductAttributeObj = new OrderSplitProductAttribute();
        $this->orderProductLengthObj = new OrderProductLength();
        $this->productThumbImage = new ProductThumbImage();
        $this->Cu = new CurrencyService();
    }


    /**
     * 是否加载review 表
     *
     * @param bool $bool
     * @return $this
     */
    public function isLoadReview($bool = false)
    {
        $this->isLoadReview = $bool;
        return $this;
    }


    /**
     * 设置图片默认尺寸
     *
     * @param array $size
     * @return $this
     */
    public function setImageSize(array $size)
    {
        $this->defaultImageZie = $size;
        return $this;
    }

    /**
     * 根据指定的订单ID获取订单产品的相关信息
     * @param int $orders_id
     * @param int $orders_products_id
     * @param string $currency
     * @param int $currency_value
     * @param int $discount_rate
     * @param array $split_product_arr
     * @param $discount_rate，客户表中客户的折扣，组合产品的子产品价格计算需要折扣数据
     * @return $this
     */
    public function getOrderProductsInfo(
        $orders_id = 0,
        $orders_products_id = 0,
        $currency = '',
        $currency_value = 0,
        $discount_rate = 1,
        $proIty = []
    ) {
        $warehouseField = self::fsProductsWarehouseWhere($this->countries_iso_code)['code'].'_status';
        $productsInfo = $this->orderProductObj
            ->with(
                [
                    'ordersProductsAttributes' => function ($query) {
                        $query->select(
                            [
                                'orders_products_id',
                                'products_options as options_name',
                                'products_options_values as values_name',
                                'options_values_price',
                                'price_prefix',
                                'products_options_id as options_id',
                                'products_options_values_id as values_id',
                                'upload_file'
                            ]
                        );
                    },
                    'ordersProductsLength' => function ($query) {
                        $query->select(['orders_products_id', 'length_name', 'length_price', 'price_prefix']);
                    },
                    'products' => function ($query) use ($warehouseField) {
                        $query->select(
                            [
                                'products_id', 'products_status',
                                'show_type','products_status',
                                'de_status','us_status','cn_status',
                                'au_status','sg_status','ru_status',
                                $warehouseField
                            ]
                        );
                    }
                ]
            )
            ->where('orders_split_products.orders_id', '=', $orders_id);
        if ($orders_products_id) {
            $productsInfo->where('orders_products_id', $orders_products_id);
        }
        $productsInfo = $productsInfo->select(
            [
                    'products_id',
                    'products_prid',
                    'orders_products_id',
                    'composite_son_products',
                    'products_model',
                    'products_name',
                    'products_price',
                    'final_price',
                    'products_quantity',
                    'orders_id',
                ]
        )->get();
        if ($this->isLoadReview) {
            $productsInfo->load(['review' => function ($query) {
                $query->select('orders_products_id');
            }]);
        }
        $productsData = [];
        if (!empty($productsInfo)) {
            $productsData = $productsInfo->toArray();
            $is_offline = 0;
            $ordersObj = new OrderSplit();
            $ordersData = $ordersObj->where('orders_id', $orders_id)
                ->select(['currency', 'currency_value', 'language_code', 'is_offline'])
                ->first();
            if (!empty($ordersData)) {
                if (!($currency && $currency_value)) {
                    $ordersData = $ordersData->toArray();
                    $currency = $ordersData['currency'];
                    $currency_value = $ordersData['currency_value'];
                }
                $is_offline = $ordersData['is_offline'];
            }
            $ramService = new RmaService();
            //$proIty数据为当前拆单已发货产品信息
            $otherProducts = [];    //获取剩余未发货的产品信息
            if(!empty($proIty)){
                foreach ($productsData as $key => $value) {
                    foreach ($proIty as $pro_key => $pro_val) {
                        if ($pro_key == $value['products_id'].'-'.$value['products_prid']) {
                            $value['products_quantity'] = $pro_val;
                            $otherProducts[] = $value;
                        }
                    }
                }
                $productsData = $otherProducts;
            }
            foreach ($productsData as $key => $value) {
                //货币类处理后 的价格 (线下单产品价格不用汇率计算 后台直接存的对应币种的单价)
                $calculate_currency_value = true;
                if ($is_offline == 1) {
                    $calculate_currency_value = false;
                }
                //货币类处理后 的价格 (线下单产品价格不用汇率计算 后台直接存的对应币种的单价,线上单汇率转换)
                //产品单价
                $productsData[$key]['final_price_currency'] = $this->Cu
                    ->format($value['final_price'], 2, $calculate_currency_value, $currency, $currency_value);
                //产品总价
                $productsData[$key]['total_price_currency'] = $this->Cu
                    ->format($value['final_price']*$value['products_quantity'], 2, $calculate_currency_value, $currency, $currency_value);
                //产品链接
                $productsData[$key]['products_href'] = 'products/'.$value['products_id'].'.html';
                $productsData[$key]['is_custom'] = false;   //是否是定制产品
                if (!empty($value['orders_products_attributes']) || !empty($value['orders_products_length'])) {
                    $productsData[$key]['is_custom'] = true;
                }
                //判断当前产品是否失效
                $productsData[$key]['is_close'] = false;
                if ($value['products']['products_status']==0 || $value['products'][$warehouseField]==0) {
                    //当前产品状态为0或者对应仓库状态关闭 则该产品失效
                    $productsData[$key]['is_close'] = true;
                }
                $productsData[$key]['image'] = $this->productThumbImage->setThumbImage($this->defaultImageZie)
                    ->getResourceImage($value['products_id']);
                //组合产品子产品信息
                $productsData[$key]['son_products_info'] = [];
                if ($value['composite_son_products']) {
                    $productsData[$key]['son_products_info'] = $ramService->getCompositeProductsInfo(
                        $value['composite_son_products'],
                        $currency,
                        $currency_value,
                        $discount_rate
                    );
                }
                //判断当前产品是否允许评价
                $productsData[$key]['review_allow'] = false;
                if ($this->isLoadReview &&
                    !$value['review']['orders_products_id'] && !$productsData[$key]['is_close']) {
                    //完成状态的订单产品允许加载评论表 当前产品是开启状态且没有评论过就允许评论
                    $productsData[$key]['review_allow'] = true;
                }

                // 判断是否是MUX产品   $value['products_id']
                $productsData[$key]['is_mux'] = in_array($value['products_id'], $this->mux_products) ? 1 : 0;
            }
        }
        return $productsData;
    }

    public function getSplitProduct($orders_id, $split_product_arr = [])
    {
        $proIty = [];
        if ($orders_id) {
            $product_info = $this->orderProductObj
                ->select(
                    [
                        'products_id',
                        'products_quantity',
                        'products_prid',
                    ]
                )
                ->where('orders_id', $orders_id)
                ->get();
            if ($product_info) {
                $product_data = $product_info->toArray();
                $result = [];
                foreach ($split_product_arr as $item) {
                    $key = $item['products_id'] . '-' . $item['products_prid'];
                    if (!isset($result[$key])) {
                        $result[$key] = $item['products_quantity'];
                    } else {
                        $result[$key] += $item['products_quantity'];
                    }
                }
                $res = [];
                foreach ($product_data as $value) {
                    $key = $value['products_id'] . '-' . $value['products_prid'];
                    $res[$key] = $value['products_quantity'];
                }
                foreach ($res as $key => $value) {
                    if ($value - $result[$key] != 0) {
                        $proIty[$key] = $value - $result[$key];
                    }
                }
            }
        }
        return $proIty;
    }

    /**
     * $Notes: 查看线下单是否完全同步至前台
     *
     * $author: Quest
     * $Date: 2020/8/21
     * $Time: 14:26
     * @param $main_orders
     * @param $son_orders
     * @return bool
     */
    public function getSplitCompleteStatus($main_orders, $son_orders)
    {
        $is_complete = false;
        $all_qty = $this->orderProductObj
            ->select(
                DB::connection()->raw('SUM(products_quantity) as number')
            )
            ->where('orders_id', $main_orders)
            ->first()->toArray();

        $son_qty = $this->orderProductObj
            ->select(
                DB::connection()->raw('SUM(products_quantity) as number')
            )
            ->whereIn('orders_id', $son_orders)
            ->first()->toArray();
        $check = intval($all_qty['number']) - intval($son_qty['number']);
        if ($check == 0) {
            $is_complete = true;
        }
        return $is_complete;
    }
}
