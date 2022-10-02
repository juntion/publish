<?php


namespace App\Services\Products;

/*use App\Enums\WarehouseEnum;
use App\Traits\ProductsInventoryTrait;*/

use Illuminate\Support\Arr;
use App\Models\ProductsInstockAddRelated;
use App\Models\ProductsInstock;
use App\Services\Products\ProductCompositeService;
use App\Services\Products\BaseProductsService;


/**
 * @notes 产品库存查询
 *
 * Class ProductInventoryService
 * @package App\Services\Products
 */
class ProductInventoryService extends BaseProductsService
{
    /**
     * @var array
     */
    protected $productsIds = []; // 原始产品数组
    /**
     * @var array
     */
    protected $warehouse = []; // 当前查询仓库
    /**
     * @var array
     */
    protected $relatedInventoryProducts = []; //产品关联库存信息
    /**
     * @var array
     */
    protected $mainProductsIds = [];//产品关联主id
    /**
     * @var array
     */
    protected $semiWarehouse = []; //需要查询的半成品仓库存
    /**
     * @var array
     */
    protected $recordWarehouse = []; //需要改码的仓库
    /**
     * @var ProductCompositeService
     */
    protected $productCompositeService; //组合产品service

    public $WarehouseEnum = [
        'DE' => 20, //德国仓
        'SG' => 71, //新加坡仓
        'US' => 40, //美东仓
        'AU' => 37,//澳大利亚仓
        'CN' => 1, // 中国华南仓
        'RU' => 67, // 俄罗斯仓
        'US_SEMI' => 98, // 美东半成品仓
        'DE_SEMI' => 104, // 德国半成品仓
        'CN_SEMI' => 102 //中国华南半成品仓
    ];

    /**
     * @var object
     */
    protected $ProductsInstockAddRelated; //主产品id 关联表

    public function __construct()
    {
        parent::__construct();
        $this->productCompositeService = new ProductCompositeService();
        $this->ProductsInstockAddRelated = new ProductsInstockAddRelated();
        $this->ProductsInstock = new ProductsInstock();
    }

    /**
     * @Notes: 设置查询产品,为了避免sql循环查询, 请传递要查询的产品数组 以及需要查询的产品仓库
     *
     * @param array $products // 需要查询的产品[products_id]
     * @param array $warehouse // 查询仓库库存, 默认为查询所有仓库存
     * @return $this
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 11:07
     */
    public function setProducts($products, $warehouse = [])
    {
        //获取关联主产品id,如果未关联到主产品id 则返回原始产品id
        $this->mainProductsIds = $this->transMainId($products);
        $this->relatedInventoryProducts = $this->setWarehouse($warehouse)->getInventory();
        return $this;
    }


    /**
     * @Notes: 将原始产品id 转换成主产品id
     *
     * @param mixed $products
     * @return array
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 11:18
     */

    /**
     * @Notes: 设置当前查询仓库, 并根据当前仓库查询信息自动关联
     *
     * @param array $warehouse
     * @return $this
     * @author: aron
     * @Date: 2020-08-17
     * @Time: 18:31
     */
    private function setWarehouse($warehouse = [])
    {
        $needRelatedSemiWarehouse = [
            $this->WarehouseEnum['US'],
            $this->WarehouseEnum['DE'],
            $this->WarehouseEnum['CN'],
        ];
        $needRelatedRecordWarehouse = [
            $this->WarehouseEnum['US'],
            $this->WarehouseEnum['DE'],
            $this->WarehouseEnum['SG'],
        ];

        $this->warehouse = !empty($warehouse) ? array_unique($warehouse) : $this->WarehouseEnum;

        foreach ($this->warehouse as $k => $v) {
            if (in_array($v, $needRelatedSemiWarehouse)) {
                $tag = $k . "_SEMI";
                $this->semiWarehouse[] = $this->WarehouseEnum[$tag];
            }
            if (in_array($v, $needRelatedRecordWarehouse)) {
                $this->recordWarehouse[] = $v;
            }
        }
        return $this;
    }

    /**
     * @Notes: 对库存id 进行格式化处理
     *
     * @param array $inventory_info 库存信息
     * @return array
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 16:10
     */
    private function formatInventoryId($inventory_info = [])
    {
        $frontLock = !empty($inventory_info['front_lock'][0]) ?
            ($inventory_info['front_lock'][0]['lockQty'] > 0 ? $inventory_info['front_lock'][0]['lockQty'] : 0) : 0;
        $backLock = !empty($inventory_info['back_lock'][0]) ?
            ($inventory_info['back_lock'][0]['lockQty'] > 0 ? $inventory_info['back_lock'][0]['lockQty'] : 0) : 0;
        $lockTotalQty = $frontLock + $backLock;
        $qty = isset($inventory_info['qty']) && $inventory_info['qty'] > 0 ? $inventory_info['qty'] : 0;
        $currentQty = $qty - $lockTotalQty;
        return [
            'products_instock_id' => $inventory_info['products_instock_id'] ?: 0, //产品库存id
            'qty' => $qty, //产品本身库存
            'lockQty' => $lockTotalQty, //产品被锁定库存
            'currentQty' => $currentQty > 0 ? $currentQty : 0 //产品实际可用库存
        ];
    }

    /**
     * @Notes:标记半成品信息
     *
     * @param array $products
     * @return array
     * @example semiInfo => [
     *  is_semi => bool,
     *  inventory_info => [],
     * related_semi_id => int
     * ]
     * @author: aron
     * @Date: 2020-08-17
     * @Time: 15:48
     */
    private function tagSemiProducts($products)
    {
        $related_main_products = $this->uniqueRelatedId($products);

        $data = $this->ProductsInstockCustomizedRelated
            ->selectRaw('GROUP_CONCAT(products_id) as products_ids,  customized_id')
            ->whereIn('products_id', $related_main_products)
            ->groupBy('customized_id')
            ->orWhereIn('customized_id', $related_main_products)->get();

        $customized_id = [];
        $transData = [];
        if (!$data->isEmpty()) {
            $data = $data->toArray();
            $transData = array_column($data, 'products_ids', 'customized_id');
            $customized_id = array_keys($transData);
        }

        $searchSelf = [];
        $searchRelated = [];
        foreach ($products as $k => &$v) {
            $v['semiInfo']['is_semi'] = false;
            $v['semiInfo']['inventory_info'] = [];
            //自身id 为半成品时
            if (in_array($v['related_main_id'], $customized_id)) {
                $v['semiInfo']['is_semi'] = true;
                $searchSelf[$k] = $this->formatMainId($v['related_main_id']);
            }
            //自身关联到对应半成品时
            $filter = array_filter($transData, function ($var) use ($v) {
                $products_ids = explode(',', $var);
                if (in_array($v['related_main_id'], $products_ids)) {
                    return true;
                }
                return false;
            });

            $v['semiInfo']['related_semi_id'] = !empty($filter) ? array_keys($filter)[0] : 0;

            if (!empty($v['semiInfo']['related_semi_id'])) {
                $searchRelated[$k] = $this->formatMainId($v['semiInfo']['related_semi_id']);
            }
        }

        //绑定半成品仓库信息
        if (!empty($this->semiWarehouse)) {
            //自身为半成品时
            if (!empty($searchSelf)) {
                $searchSelfInventory = $this->getInventoryInfo(
                    $searchSelf,
                    $this->semiWarehouse
                );
                foreach ($searchSelfInventory as $kkk => $vvv) {
                    if (!empty($products[$kkk]) && !empty($vvv['inventory_info'])) {
                        $products[$kkk]['semiInfo']['inventory_info'] = $vvv['inventory_info'];
                    }
                }
            }
            //关联到半成品id时
            if (!empty($searchRelated)) {
                $searchSelfInventory = $this->getInventoryInfo(
                    $searchRelated,
                    $this->semiWarehouse
                );
                foreach ($searchSelfInventory as $kk => $vv) {
                    if (!empty($products[$kk]) && !empty($vv['inventory_info'])) {
                        $products[$kk]['semiInfo']['inventory_info'] = $vv['inventory_info'];
                    }
                }
            }
        }
        return $products;
    }

    /**
     * @Notes: 改码产品关联
     *
     * @param array $products
     * @return array
     * @example recordInfo => [
     *  related_semi_record => [] 半成品关联改码以及自身改码产品汇总
     *  self_related_semi_id => '' 自身改码产品关联汇总
     * ]
     * @author: aron
     * @Date: 2020-08-18
     * @Time: 16:23
     */
    private function tagRecordProducts($products)
    {
        $main_products_ids = $this->uniqueRelatedId($products);
        $relatedCode = $this->ProductsInstockCodeRelated
            ->selectRaw('products_id, GROUP_CONCAT(customized_id) as customized_ids ')
            ->whereIn('products_id', $main_products_ids)->groupBy('products_id')->get();
        if (!$relatedCode->isEmpty()) {
            $relatedCode = $relatedCode->toArray();
            $relatedCode = array_column($relatedCode, 'customized_ids', 'products_id');
        }
        foreach ($products as $k => &$v) {
            $v['recordInfo'] = [
                'related_semi_record' => [],
                'self_related_semi_id' => []
            ];
            //只有本身产品有关联改码产品时,关联半成品产品
            if (!empty($relatedCode[$v['related_main_id']])) {
                $relate_record_id = $relatedCode[$v['related_main_id']];
                //关联半成品对应的成品id 改码产品 以及 本身改码产品
                if (!empty($v['semiInfo']) && !empty($v['semiInfo']['related_semi_id'])) {
                    $related_semi_products = $this->ProductsInstockCustomizedRelated
                        ->select('products_id')
                        ->where('products_id', '<>', $v['related_main_id'])
                        ->where('customized_id', $v['semiInfo']['related_semi_id'])->get()->toArray();

                    if (!empty($related_semi_products)) {
                        $related_semi_products = array_column($related_semi_products, 'products_id');
                        $relatedSemiCode = $this->ProductsInstockCodeRelated
                            ->select('products_id')
                            ->whereIn('products_id', $related_semi_products)
                            ->orWhereIn('customized_id', $related_semi_products)
                            ->get('products_id')->toArray();
                        if (!empty($relatedSemiCode)) {
                            $relatedSemiCode = array_column($relatedSemiCode, 'products_id');
                            $relatedSemiCode = implode(',', $relatedSemiCode);
                            $relate_record_id .= "," . $relatedSemiCode;
                        }
                    }
                }

                $relate_record_id = array_unique(explode(',', $relate_record_id));
                $transData = [];
                foreach ($relate_record_id as $kk => $vv) {
                    if ($vv == $v['related_main_id']) {
                        continue;
                    }
                    $transData[$vv] = $this->formatMainId((int)$vv);
                }
                $transData = $this->getInventoryInfo($transData, $this->recordWarehouse);

                $v['recordInfo']['related_semi_record'] = $transData;
                $v['recordInfo']['self_related_semi_id'] = $relatedCode[$v['related_main_id']];
            }
        }
        return $products;
    }


    /**
     * @Notes: 获取产品所有库存信息
     *
     * @param array $products
     * @param array $warehouse
     * @return array
     * @author: aron
     * @Date: 2020-08-17
     * @Time: 18:37
     */
    public function getInventory($products = [], $warehouse = [])
    {
        if (empty($products)) {
            $products = $this->mainProductsIds;
        }
        if (empty($warehouse)) {
            $warehouse = $this->warehouse;
        }
        //获取当前产品库存基本信息
        $inventoryInfo = $this->getInventoryInfo($products, $warehouse);

        //组合产品关联
        $inventoryInfo = $this->tagCompositeProducts($inventoryInfo);

        //获取当前产品关联半成品信息(美国 德国 中国走此流程)
        $inventoryInfo = $this->tagSemiProducts($inventoryInfo);

        //获取当前产品关联的改码产品
        if (!empty($this->recordWarehouse)) {
            $inventoryInfo = $this->tagRecordProducts($inventoryInfo);
        }
        return $inventoryInfo;
    }

    /**
     * @Notes: 查询产品库存信息
     *
     * @param array $products eg:[products_id => ['main_related_products' => main_products_id]]
     * @parma array $warehouse 所属仓库
     * @return array
     * @author: aron
     * @Date: 2020-08-13
     * @Time: 16:51
     */
    private function getInventoryInfo($products = [], $warehouse = [])
    {
        if (empty($warehouse)) {
            return $products;
        }
        $related_main_products = $this->uniqueRelatedId($products);

        $data = $this->ProductsInstock->select(
            'products_instock_id',
            'products_id',
            'warehouse',
            'instock_qty as qty'
        )->with(['frontLock' => function ($query) {
            $query->selectRaw('sum(qty) as lockQty,instock_id')
                ->groupBy('instock_id');
        }, 'backLock' => function ($query) {
            $query->selectRaw('sum(change_qty) as lockQty,products_instock_id')->where('type', '=', 0)
                ->groupBy('products_instock_id');
        }])->whereIn('warehouse', $warehouse)->whereIn('products_id', $related_main_products)->get();
        $transData = [];
        if (!$data->isEmpty()) {
            $data = $data->toArray();
            foreach ($data as $item) {
                $transData[$item['warehouse']][$item['products_id']] = $item;
            }
        }


        foreach ($products as $kk => &$vv) {
            foreach ($warehouse as $w) {
                $inventory_info = [];

                $warehouseName = $w ? array_search($w, $this->WarehouseEnum) : '';

                if (isset($transData[$w]) && isset($transData[$w][$vv['related_main_id']])) {
                    $inventory_info = $transData[$w][$vv['related_main_id']];
                }
                if (!empty($warehouseName)) {
                    $vv['inventory_info'][$warehouseName] = $this->formatInventoryId($inventory_info);
                }
            }
        }
        return $products;
    }

    /**
     * @Notes: 根据库存信息,计算当前产品库存数量 该函数类不允许有任何 库存查询,所有库存信息获取必须提前关联
     *
     * @param int $type 库存计算方式 0.汇总改码关联以及半成品关联 1.根据filterQty 来筛选出应该使用的 库存id 以及 库存数量
     * @param array $filterQty 用于筛选库存信息的参数 eg: 该参数通常为客户购买产品数量
     * @return array 当产品为组合产品时 products_inventory_id 为数组
     * @author: aron
     * @Date: 2020-08-18
     * @Time: 18:45
     */
    public function calculateInventory($type = 0, $filterQty = [])
    {
        $products = $this->relatedInventoryProducts;
        $return = [];
        foreach ($products as $i => $product) {
            //改码关联库存总数量,包含半成品关联成品产品 改码关联
            $recordProductsTotal = [];
            //半成品关联信息
            $semiInfo = $product["semiInfo"] ?: [];
            //改码关联汇总信息
            $recordInfo = $product["recordInfo"] ?: [];
            //组合产品汇总信息
            $compositeInfo = $product['compositeInfo'] ?: [];
            //对产品库存信息进行过滤
            foreach ($product['inventory_info'] as $kk => $vv) {
                $return[$i][$kk]['currentQty'] = $vv['currentQty'];
                $return[$i][$kk]['products_inventory_id'] = $vv['products_instock_id'];
            }
            //var_dump($return[$i]);die;
            foreach ($return[$i] as $k => &$v) {
                //半成品库存数量
                $semiQty = 0;
                try {
                    $currentSemiWarehouse = $this->WarehouseEnum[$k . '_SEMI'] ?: '';
                } catch (\Throwable $e) {
                    $currentSemiWarehouse = '';
                }
                //如果当前产品为组合产品,直接返回当前库存数据
                if (!empty($compositeInfo)) {
                    $compositeData = $this->calculateCompositeProducts($compositeInfo);
                    $v['currentQty'] = $compositeData[$k]['qty'] ?: 0;
                    $v['products_inventory_id'] = $compositeData[$k]['inventory_id'] ?: 0;
                    continue;
                }
                //如果当前产品为半成品 或者关联到半产品
                if (!empty($semiInfo)) {
                    $semi_inventory_info = $semiInfo['inventory_info'];
                    //如果当前产品为半成品时, 将该产品信息转换成对应半成品信息
                    if ($semiInfo['is_semi'] && isset($semi_inventory_info[$k . "_SEMI"])) {
                        $v['currentQty'] = $semi_inventory_info[$k . "_SEMI"]['currentQty'];
                        $v['products_inventory_id'] = $semi_inventory_info[$k . "_SEMI"]['products_instock_id'];
                    }
                    if (!empty($semiInfo['related_semi_id']) &&
                        isset($semi_inventory_info[$k . "_SEMI"])) {
                        $semiQty = $semi_inventory_info[$k . "_SEMI"]['currentQty'];
                    }
                }
                //计算改码关联汇总库存
                if (!empty($recordInfo)) {
                    $recordProductsTotal = $this->calculateRecordProducts($recordInfo);
                }
                switch ($type) {
                    case 0:
                        if (!$semiInfo['is_semi']) {
                            $v['currentQty'] += $semiQty;
                        }
                        $v['currentQty'] += $recordProductsTotal[$k] ?: 0;
                        break;
                    case 1:
                        $semi_inventory_info = $semiInfo['inventory_info'];
                        $purchase = $filterQty[$i] ?: 1;
                        //当前产品信息小于filterQty时
                        if ($v['currentQty'] < $purchase) {
                            //如果 关联的半成品产品数量大于 筛选数量,则返回关联半成品产品信息
                            if ($semiQty >= $purchase && $currentSemiWarehouse) {
                                $v['currentQty'] = $semi_inventory_info[$k . "_SEMI"]['currentQty'];
                                $v['products_inventory_id'] = $semi_inventory_info[$k . "_SEMI"]['products_instock_id'];
                            } else {
                                //判断当前关联改码产品库存是否满足出货
                                if (!empty($recordProductsTotal) && !empty($recordInfo['self_related_semi_id'])) {
                                    $self_related_semi_id = explode(',', $recordInfo['self_related_semi_id']);
                                    foreach ($self_related_semi_id as $vvv) {
                                        $currentRecord = $recordInfo['related_semi_record'][$vvv] ?: [];
                                        if ($currentRecord && isset($currentRecord['inventory_info'][$k])) {
                                            if ($currentRecord['inventory_info'][$k]['currentQty'] >= $purchase) {
                                                $v['currentQty'] = $currentRecord['inventory_info'][$k]['currentQty'];
                                                $v['products_inventory_id'] = $currentRecord['inventory_info'][$k]
                                                ['products_instock_id'];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        }
        return $return;
    }

    /**
     * @Notes: 改码关联库存汇总
     *
     * @param array $calculateInfo
     * @return array
     * @author: aron
     * @Date: 2020-08-19
     * @Time: 09:37
     */
    private function calculateRecordProducts($calculateInfo = [])
    {
        if (empty($calculateInfo) || empty($calculateInfo['related_semi_record'])) {
            return [];
        }
        $total = [];
        $inventory = array_column($calculateInfo['related_semi_record'], 'inventory_info');
        foreach ($inventory as $i => $item) {
            foreach ($item as $ii => $t) {
                $total[$ii] = $total[$ii] ?: 0;
                $total[$ii] += $t['currentQty'];
            }
        }
        return $total;
    }

    /**
     * @Notes: 关联组合产品
     *
     * @param array $products
     * @return array
     * @author: aron
     * @Date: 2020-08-21
     * @Time: 15:30
     */
    private function tagCompositeProducts($products = [])
    {
        //关联组合产品信息
        $inventoryInfo = $this->productCompositeService->setProducts($products)->getRelatedCompositeProducts();

        foreach ($inventoryInfo as $i => &$item) {
            $compositeInfo = $item['compositeInfo'] ?: [];
            if (!empty($compositeInfo)) {
                $searchProducts = array_column($compositeInfo['related'], 'id');
                $searchMainId = [];
                foreach ($searchProducts as $vv) {
                    $searchMainId[$vv] = $this->formatMainId($vv);
                }
                $searchInventory = $this->getInventoryInfo($searchMainId, $this->warehouse);
                $searchInventory = array_column($searchInventory, 'inventory_info', 'related_main_id');
                $item['compositeInfo']['inventoryInfo'] = $searchInventory;
            }
        }
        return $inventoryInfo;
    }

    /**
     * @Notes:计算组合产品库存
     *
     * @param array $compositeInfo
     * @return array
     * @author: aron
     * @Date: 2020-10-10
     * @Time: 11:42
     */
    public function calculateCompositeProducts($compositeInfo = [])
    {
        $type = $compositeInfo['type'];
        $inventoryInfo = $compositeInfo['inventoryInfo'];
        $related = $compositeInfo['related'];
        $collect = [];
        foreach ($inventoryInfo as $i => $item) {
            foreach ($item as $ii => $t) {
                if (!empty($t['products_instock_id'])) {
                    $collect[$ii]['qty'][] = ['qty' => $t['currentQty'], 'id' => $i];
                    $collect[$ii]['inventory_id'][] = $t['products_instock_id'];
                }
            }
        }
        switch ($type) {
            case 1:
            case 3:
                foreach ($collect as $k => &$v) {
                    $qty = array_column($v['qty'], 'qty');
                    $v['qty'] = min($qty);
                }
                break;
            case 2:
                $relatedInfo = array_column($related, 'type', 'id');
                foreach ($collect as $k => &$v) {
                    $qty = $v['qty'];
                    foreach ($qty as &$j) {
                        $j['type'] = $relatedInfo[$j['id']] ?: '';
                    }
                    $qty = array_column($qty, "qty", 'type');
                    $compositeC = $qty['composite_c'] ?: 0;
                    $compositeB = $qty['composite_b'] ?: 0;
                    if ($compositeC <= 1) {
                        $v['qty'] = 0;
                    } elseif ($compositeC > 1 && $compositeB < floor($compositeC / 2)) {
                        $v['qty'] = $compositeB;
                    } elseif ($compositeC > 1 && $compositeB >= floor($compositeC / 0)) {
                        $v['qty'] = floor($compositeC / 2);
                    } else {
                        $v['qty'] = 0;
                    }
                }
                break;
            case 4:
                foreach ($collect as $k => &$v) {
                    $qty = $v['qty'];
                    $relatedInfo = array_column($related, 'num', 'id');
                    foreach ($qty as &$j) {
                        $num = $relatedInfo[$j['id']] ?: 1;
                        $j['qty'] = floor($j['qty'] / $num);
                    }
                    $qty = array_column($v['qty'], 'qty');
                    $v['qty'] = min($qty);
                }
                break;
        }
        return $collect;
    }


    /**
     * @Notes: 获取转换后产品信息
     *
     * @return array
     * @author: aron
     * @Date: 2020-08-24
     * @Time: 10:53
     */
    public function getRelatedInventoryProducts()
    {
        return $this->relatedInventoryProducts;
    }

    /**
     * @Notes: 首页返回库存显示信息 Bona.Guo 2021/2/26 10:55
     * @param int $pid 产品id
     * @param Array $instockArr 库存数组信息
     * @param string $now_warehouse_code 当前站点所属仓库code
     * @return string
     */
    public function getIndexInstockQtyHtml($pid, $instockArr, $now_warehouse_code)
    {
        //当前仓库库存
        $instockQty = $instockArr[$now_warehouse_code]['currentQty'];

        //若无库存则显示CN仓库存
        if ($instockQty < 1) {
            $instockQty = $instockArr['CN']['currentQty'];
        }

        //仍旧无库存，返回描述
        if ($instockQty < 1) {
            return QTY_SHOW_AVAILABLE;
        }

        $str = QTY_SHOW_ZERO_STOCK_1;

        //此判断逻辑来源于旧版本首页库存显示逻辑，我不知
        if (in_array($pid, array(51308, 31866, 31909, 31922))) {
            $NowInstockQTY = '<i>' . $instockQty . ' KM</i>' . FS_SHIP_STOCK;
        } else {
            $NowInstockQTY = $instockQty . " " . $str;
        }
        return $NowInstockQTY;
    }

}
