<?php

namespace App\Services\Products;

use App\Services\BaseService;
use App\Services\Common\CurrencyService;
use App\Models\ProductClearanceType;
use App\Models\Product;
use App\Models\ProductThumbImage;
use App\Services\Common\AmericanBritishSpellings;
use Illuminate\Database\Capsule\Manager as DB;

class FsNewProductService extends BaseService
{
    private $clearanceType;
    private $products;
    private $productThumb;
    private $defaultImageZie =['size_w'=>180,'size_h'=>180];
    private $currencyService;
    private $americanBritain;
    public function __construct()
    {
        parent::__construct();
        $this->clearanceType = new ProductClearanceType();
        $this->products = new Product();
        $this->productThumb = new ProductThumbImage();
    }
    // 获取新产品数据
    public function getNewProducts()
    {
        $productsData = $typeData =  [];
        $language_id = $this->language_id ==9 ? 1 : $this->language_id;
        $typeInfo = $this->clearanceType
            ->select(['clearance_id','products_type','type_link'])
            ->where('languages_id', $language_id)
            ->where('is_clearance', 0)
            ->orderBy('sort', 'asc')
            ->orderBy('clearance_id', 'asc')
            ->get();
        if (!empty($typeInfo)) {
            $typeData = $typeInfo->toArray();
            $typeIds = array_map(function ($type) {
                return $type['clearance_id'];
            }, $typeData);
            $before_ninety = time() - 90 * 24 * 3600;
            $before_ninety = date('Y-m-d H:i:s', $before_ninety);
            $warehouseWhere = self::fsProductsWarehouseWhere($this->countries_iso_code)['code'] . '_status';
            $productsInfo = $this->products
                ->with(
                    [
                        'productDescription' => function ($query) {
                            $query->select('products_name', 'products_id')
                                ->where('language_id', $this->language_id);
                        }
                    ]
                )
                ->leftJoin('fs_new_products', 'fs_new_products.products_id', '=', 'products.products_id')
                ->select(
                    [   'products.products_id',
                        'products.products_status',
                        'products.products_price',
                        'products.integer_state',
                        'fs_new_products.clearance_id',
                        'products.product_sales_total_num',
                        'products.offline_sales_num'
                    ]
                )
                ->whereIn('fs_new_products.clearance_id', $typeIds)
                ->where('products.new_products_tag', 1)
                ->where('products.new_products_time', '>=', $before_ninety)
                ->where('products.' . $warehouseWhere, 1)
                ->orderByRaw(DB::raw("sort=0,sort asc"))
                ->orderBy('fs_new_products.clearance_id', 'asc')
                ->orderBy('fs_new_products.id', 'asc')
                ->get();
            if (!empty($productsInfo)) {
                $productsData = $productsInfo->toArray();
            }
            foreach ($typeData as $type_key => $type_value) {
                if (sizeof($productsData)) {
                    foreach ($productsData as $product_key => $product_value) {
                        if ($type_value['clearance_id'] == $product_value['clearance_id']) {
                            $typeData[$type_key]['products_data'][] = array(
                              'products_id' => $product_value['products_id'],
                              'products_status' => $product_value['products_status'],
                              'products_name' => $product_value['product_description']['products_name'],
                              'products_price' => $product_value['products_price'],
                              'integer_state' => $product_value['integer_state'],
                              'product_sales_total_num' => $product_value['product_sales_total_num'],
                              'offline_sales_num' => $product_value['offline_sales_num'],
                            );
                        }
                    }
                    if ($typeData[$type_key]['products_data']) {
                        $typeData[$type_key]['count_product'] = count($typeData[$type_key]['products_data']);
                        $typeData[$type_key]['products_data'] = array_slice($typeData[$type_key]['products_data'], 0, 4);
                    }
                }
            }
            return $typeData;
        }
    }
    public function rangeNewProducts()
    {
        global $currencies;
        $this->currencyService = new CurrencyService();
        $this->americanBritain =  new AmericanBritishSpellings();
        $productsData = $this->getNewProducts();
        $isNeedSwap = in_array($this->language_id, array(1,9)) ? true : false;
        if ($this->language_id) {
            if (sizeof($productsData)) {
                foreach ($productsData as $key => $data) {
                    if ($isNeedSwap) { //分类名称转换
                        $productsData[$key]['products_type'] = $this->americanBritain->swapAmericanSpellingsForBritishSpellings(['text'=>$data['products_type']]);
                    }
                    $productsData[$key]['products_type'] = stripcslashes($productsData[$key]['products_type']);
                    if ($data['products_data']) {
                        foreach ($data['products_data'] as $product_key => $product) {
                            //产品图片
                            $productImage = $this->productThumb
                            ->setThumbImage($this->defaultImageZie)
                            ->getResourceImage($product['products_id'], true);
                            //产品价格
                            $productPrice = $product['products_price'];
                            $integer_state = $product['integer_state'];
                            //产品名称转换
                            if ($isNeedSwap) {
                                $productsData[$key]['products_data'][$product_key]['products_name'] = $this->americanBritain->swapAmericanSpellingsForBritishSpellings(['text'=>$product['products_name']]);
                            }
                            $productsData[$key]['products_data'][$product_key]['products_image'] = $productImage;
                            $productsData[$key]['products_data'][$product_key]['products_price'] = $productPrice;
                            $productsData[$key]['products_data'][$product_key]['integer_state'] = $integer_state;
                        }
                    }
                }
                return $productsData;
            }
        }
        return [];
    }
}
