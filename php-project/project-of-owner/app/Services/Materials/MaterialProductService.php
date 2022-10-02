<?php

namespace App\Services\Materials;

use App\Models\MaterialProductCustomRelated;
use App\Models\MaterialProductStock;
use App\Models\MaterialProductStockLock;
use App\Services\BaseService;
use Illuminate\Database\Capsule\Manager as DB;

class MaterialProductService extends BaseService
{
    private $customRelatedObj;  //毛料和定制产品关联对象
    private $materialStockObj;  //毛料库存对象
    private $materialStockLockObj;  //毛料库存锁定对象

    public function __construct()
    {
        parent::__construct();

        $this->customRelatedObj = new MaterialProductCustomRelated();
        $this->materialStockObj = new MaterialProductStock();
        $this->materialStockLockObj = new MaterialProductStockLock();
    }

    /**
     * 查找定制产品关联的毛料产品ID
     * @param int $customized_id 定制产品ID
     * @param string $option_value_ids  定制产品选择的属性项和属性值  格式:option_id:value_id,option_id:value_id
     * @return array
     */
    public function getRelatedMaterialInfo($customized_id = 0, $option_value_ids = '')
    {
        $customData = [];
        if ($customized_id) {
            $customInfo = $this->customRelatedObj
                ->where('customized_id', $customized_id);
            if ($option_value_ids) {
                $customInfo = $customInfo->where('option_value_ids', $option_value_ids);
            }
            $customInfo = $customInfo->select(['customized_id','products_id','option_ids'])
                ->first();
            if ($customInfo) {
                $customData = $customInfo->toArray();
            }
        }
        return $customData;
    }

    /**
     * 查找有长度属性的定制产品选择属性后关联的毛料ID库存相关数据
     * @param array $config,
     * $config = [
     *      'products_id'=>50147,       //定制产品ID
     *      'length'=>3,                //选择的总长度（长度*数量）（m）
     *      'attribute'=>['98'=>'4295','99'=>'4295','15'=>'5742','35'=>'4331'] 定制产品所有的属性项对应的属性值
     * ]
     * @return array
     */
    public function getCustomRelatedMaterial($config = [])
    {
        $materialData = [];
        if ($config['products_id'] && $config['length']) {
            //先判断当前有长度属性的定制产品是否有关联的毛料ID记录
            $customInfo = $this->getRelatedMaterialInfo($config['products_id']);
            if ($customInfo) {
                //找出定制产品参与匹配毛料ID的属性项（定制产品的部分属性项对应的属性值和毛料ID匹配即可）
                $optionData = explode(',', $customInfo['option_ids']);
                $selectOptionStr = '';
                foreach ($optionData as $key => $value) {
                    if ($config['attribute'][$value]) {
                        $selectOptionStr .= $value.':'.$config['attribute'][$value].',';
                    }
                }
                $selectOptionStr = trim($selectOptionStr, ',');
                if ($selectOptionStr) {
                    //根据当前定制产品ID和选择的属性器匹配关联的毛料ID
                    $relatedMaterialData = $this->getRelatedMaterialInfo($config['products_id'], $selectOptionStr);
                    //找到关联的毛料ID
                    if ($relatedMaterialData['products_id']) {
                        //查找当前毛料ID的库存
                        return $this->getMaterialProductTotalStock(
                            $relatedMaterialData['products_id'],
                            $config['length']
                        );
                    }
                }
            }
        }
        return $materialData;
    }

    /**
     * 查找当前毛料ID的库存与交期
     * @param int $products_id 毛料ID
     * @param int $needLength 所选总长度（长度*数量）
     * @return array
     */
    public function getMaterialProductTotalStock($products_id = 0, $needLength = 0)
    {
        $materialData = [];
        if ($products_id) {
            $stockLength = $leadTime = 0;   //毛料长度库存和交期
            //查找当前毛料产品的库存长度以及交期
            $materialStockInfo = $this->getMaterialStockInfo($products_id);
            //查找当前毛料产品已经被锁定消耗的长度库存
            $materialStockLockLength = $this->getMaterialStockLockInfo($products_id);
            if (!empty($materialStockInfo)) {
                $leadTime = $materialStockInfo['products_leadtime'];
                $totalStockLength = $materialStockInfo['products_length_stock'];
                if ($totalStockLength>$materialStockLockLength) {
                    $stockLength =  $totalStockLength - $materialStockLockLength;
                }

                //选择总长度大于库存，交期延长9个工作日
                $isDelay = 0;
                if ($needLength > $stockLength) {
                    $leadTime += 9;
                    $isDelay = 1;
                }

                $materialData = array(
                    'materialProductsId' => $products_id,
                    'materialStockLength' => $stockLength,
                    'materialLeadTime' => $leadTime,
                    'materialDelay' => $isDelay
                );
            }
        }
        return $materialData;
    }

    /**
     * 获取毛料产品的长度库存数据
     * @param int $products_id
     * @return array
     */
    public function getMaterialStockInfo($products_id = 0)
    {
        $stockData = [];
        if ($products_id) {
            $stockInfo = $this->materialStockObj
                ->where('products_id', $products_id)
                ->select(['products_id','products_leadtime','products_length_stock'])
                ->first();
            if ($stockInfo) {
                $stockData = $stockInfo->toArray();
            }
        }
        return $stockData;
    }

    /**
     * 获取毛料产品已经被锁定消耗的库存长度
     * @param int $products_id
     * @return array
     */
    public function getMaterialStockLockInfo($products_id = 0)
    {
        $stockLockLength = 0;
        if ($products_id) {
            $stockLockLength = $this->materialStockLockObj
                ->where('products_id', $products_id)
                ->where('is_deleted', 0)    //只获取没有删除的库存锁定记录
                ->sum('length_stock');
        }
        return $stockLockLength;
    }
}
