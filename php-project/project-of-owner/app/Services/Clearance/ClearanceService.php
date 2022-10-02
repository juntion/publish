<?php


namespace App\Services\Clearance;

use App\Models\ProductClearanceType;
use App\Models\ProductsClearance;
use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager as DB;

class ClearanceService extends BaseService
{
    protected $productClearanceType;
    protected $productClearance;

    public function __construct()
    {
        parent::__construct();
        $this->productClearanceType = new ProductClearanceType();
        $this->productClearance = new ProductsClearance();
    }

    /**
     * 获取清仓分类
     *
     * @param int $clearance_id
     * @return array $result
     */
    public function getClearanceType($clearance_id = 0)
    {
        try {
            $warehouWhereFiled = $this->fsProductsWarehouseWhere($this->countries_iso_code)['code'] . '_status';
            $result = $this->productClearanceType;
            if ($clearance_id) {
                $result = $result->where('clearance_id', $clearance_id);
            }
            $result = $result->with([
                'ProductRow' => function($query) use ($warehouWhereFiled) {
                    $query->select(
                        DB::connection()->raw('count(*) as row')
                    )
                        ->where('products.' . $warehouWhereFiled, 1)
                        ->where('products.products_status', 1)
                        ->groupBy('products_clearance.clearance_id');
                }
            ]);
            $result = $result->where('languages_id', $this->language_id)
                    ->where('is_clearance', 1)
                    ->orderBy('sort', 'asc')
                    ->get([
                        'clearance_id',
                        'products_type',
                        'parent_id'
                    ])
                    ->toArray();
        } catch (\Exception $e) {
            $result = [];
        }
        return $result;
    }

    /**
     * 获取清仓主页面数据
     *
     * @param int $page
     * @param int $clearance_id
     * @return array $result
     */
    public function getClearanceTypeProduct($page = 0,  $clearance_id = 0)
    {
        try {
            $warehouseCode = self::fsProductsWarehouseWhere($this->countries_iso_code)['code'];
            $warehouWhereFiled = $warehouseCode. '_status';
            $inquiryField = 'is_'.$warehouseCode.'_inquiry';
            $result = $this->productClearanceType
                    ->with([
                        'ProductRow' => function($query) use ($warehouWhereFiled) {
                            $query->select(
                                DB::connection()->raw('count(*) as row')
                            )
                                ->where('products.' . $warehouWhereFiled, 1)
                                ->where('products.products_status', 1)
                                ->groupBy('products_clearance.clearance_id');
                        },
                        'TypeProduct'  =>  function($query) use ($page, $warehouWhereFiled, $inquiryField) {
                            $query->select(
                                [
                                    'products_clearance.id',
                                    'products_clearance.products_id',
                                    'products_clearance.clearance_id',
                                    'products_clearance.products_clearance_price',
                                    'products.products_status',
                                    'products.products_image',
                                    'products.'.$inquiryField.' as is_inquiry',
                                    'products.is_customized',
                                    'products_clearance.products_sort',
                                    'products.product_sales_total_num',
                                    'products.offline_sales_num'
                                ]
                            )
                                //->whereRaw("(select count(id) from products_clearance as pc where pc.clearance_id = `products_clearance`.`clearance_id` and products_clearance.id < pc.id) < 5")
                                ->where('products.products_status', 1)
                                ->where('products.' . $warehouWhereFiled, 1)
                                ->orderBy('products_sort', 'asc');
                            if ($page) {
                                $page = ($page - 1) * 24;
                                $query->offset($page)->limit(24);
                            }
                        },
                    ])
                ->where('languages_id', $this->language_id)
                ->where('is_clearance', 1)
                ->where(function($query) use ($clearance_id) {
                    if ($clearance_id) {
                        $query->where('clearance_id', $clearance_id);
                    }
                })
                ->orderBy('sort', 'asc')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $result = [];
        }
        return $result;
    }


    public function getTree($arr, $parent_id,  $flag = false, $id_key = 'id', $parent_id_key = 'parent_id_key')
    {
        $temp = array();
        if ($flag) {
            $temp = array();
        }
        foreach ($arr as $key => $value) {
            if ($value[$parent_id_key] == $parent_id) {

                $children = $this->getTree($arr, $value[$id_key], false, $id_key, $parent_id_key);
                $value['children'] = $children;
                $temp[] = $value;
            }
        }
        return $temp;
    }
}