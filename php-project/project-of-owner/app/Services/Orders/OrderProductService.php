<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductAttribute;
use App\Models\OrderProductLength;
use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use App\Services\Products\ProductLengthService;
use App\Services\Products\ProductOptionService;
use App\Models\ProductThumbImage;
use App\Services\Rma\RmaService;

class OrderProductService extends BaseService
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

        $this->orderProductObj = new OrderProduct();
        $this->orderProductAttributeObj = new OrderProductAttribute();
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
     * @param $discount_rate，客户表中客户的折扣，组合产品的子产品价格计算需要折扣数据
     * @param $is_au_gsp 是否为澳大利亚税后价
     * @return $this
     */
    public function getOrderProductsInfo(
        $orders_id = 0,
        $orders_products_id = 0,
        $currency = '',
        $currency_value = 0,
        $discount_rate = 1,
        $is_au_gsp = 0
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
                        $query->select(['products_id', 'products_status', 'show_type', $warehouseField]);
                    }
                ]
            )
            ->where('orders_products.orders_id', '=', $orders_id);
        if ($orders_products_id) {
            $productsInfo->where('orders_products_id', $orders_products_id);
        }
        $productsInfo = $productsInfo->select(
            [
                    'products_id',
                    'products_prid',
                    'orders_products_id',
                    'composite_son_products',
                    'composite_son_products_tax',
                    'products_model',
                    'products_name',
                    'products_price',
                    'final_price',
                    'products_quantity',
                    'orders_id',
                    'tax_after_price',
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
            if (!($currency && $currency_value)) {
                $ordersObj = new Order();
                $ordersData = $ordersObj->where('orders_id', $orders_id)
                    ->select(['currency', 'currency_value', 'language_code'])
                    ->first();
                if (!empty($ordersData)) {
                    $ordersData = $ordersData->toArray();
                    $currency = $ordersData['currency'];
                    $currency_value = $ordersData['currency_value'];
                }
            }
            $ramService = new RmaService();
            foreach ($productsData as $key => $value) {
                //货币类处理后 的价格
                //如果有税后价就展示税后价
                $final_price = $is_au_gsp == 1 ? $value['tax_after_price'] : $value['final_price'];

                //产品单价
                $productsData[$key]['final_price_currency'] = $this->Cu
                    ->format($final_price, 2, true, $currency, $currency_value);
                //产品总价
                $productsData[$key]['total_price_currency'] = $this->Cu
                    ->format($final_price*$value['products_quantity'], 2, true, $currency, $currency_value);
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
                    ->getResourceImage($value['products_id'], false, $value['products']['products_status']);
                //组合产品子产品信息
                $productsData[$key]['son_products_info'] = [];
                if ($value['composite_son_products']) {
                    $fms_str = $is_au_gsp == 1 ? $value['composite_son_products_tax'] :
                        $value['composite_son_products'];
                    $productsData[$key]['son_products_info'] = $ramService->getCompositeProductsInfo(
                        $fms_str,
                        $currency,
                        $currency_value,
                        $discount_rate
                    );
                }
                //判断当前产品是否允许评价
                $productsData[$key]['review_allow'] = false;
                $productsData[$key]['is_reviewed'] = false;
                if ($this->isLoadReview &&
                    !$value['review']['orders_products_id'] && !$productsData[$key]['is_close']) {
                    //完成状态的订单产品允许加载评论表 当前产品是开启状态且没有评论过就允许评论
                    $productsData[$key]['review_allow'] = true;
                }
                if ($value['review']['orders_products_id']) {
                    $productsData[$key]['is_reviewed'] = true;
                }

                // 判断是否是MUX产品   $value['products_id']
                $productsData[$key]['is_mux'] = in_array($value['products_id'], $this->mux_products) ? 1 : 0;
            }
        }
        return $productsData;
    }

    /**
     * 根据客户订单产品属性 生成购物车类add_cart方法中第三个$real_ids属性数组参数
     * @param array $products   getOrderProductsInfo()方法获取的单个产品的所有数据
     * @return array
     */
    public function createAttributeForAddCart($products = [])
    {
        $real_ids = [];
        if (!empty($products)) {
            if (empty($this->checkboxOptions)) {
                $options = new ProductOptionService();
                $this->checkboxOptions = $options->getCheckboxOptionId();
            }
            if (!empty($products['orders_products_attributes'])) {
                foreach ($products['orders_products_attributes'] as $kk => $attribute) {
                    if ($attribute['upload_file']) {
                        //是file类型的属性项
                        $real_ids['upload_prefix_'.$attribute['options_id']] = array(
                            'products_options_value_text' =>  $attribute['values_name'],
                            'upload_file' => $attribute['upload_file'],
                        );
                    } else {
                        if ($attribute['values_id']==0) {
                            //text类型的属性项
                            $real_ids['text_prefix_'.$attribute['options_id']] = $attribute['values_name'];
                        } else {
                            if (in_array($attribute['options_id'], $this->checkboxOptions)) {
                                //多选类型属性项
                                $real_ids[$attribute['options_id']][$attribute['values_id']] = $attribute['values_id'];
                            } else {
                                $real_ids[$attribute['options_id']] = $attribute['values_id'];
                            }
                        }
                    }
                }
            }
            //长度属性
            if (!empty($products['orders_products_length'])) {
                $length = new ProductLengthService();
                $real_ids['length'] = $length->getLengthIdByLength(
                    $products['products_id'],
                    $products['orders_products_length']['length_name']
                );
            }
        }
        return $real_ids;
    }

    /**
     * 获取下单定制产品的属性项ID和属性值ID数据
     * @param array $products getOrderProductsInfo()方法获取的单个产品的所有数据
     * @return array
     */
    public function resetAttributesInfo($products = []){
        $info = [];
        if (!empty($products['orders_products_attributes'])) {
            foreach ($products['orders_products_attributes'] as $kk => $attribute) {
                $info[$attribute['options_id']][] = $attribute['values_id'];
            }
        }
        return $info;
    }
}
