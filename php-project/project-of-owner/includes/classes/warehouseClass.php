<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2017/12/28
 * Time: 11:58
 */

namespace classes;

/**
 * Class warehousingNumberException
 *  插入历史表SQL异常处理
 *
 * @package classes
 */
class warehousingNumberException extends \Exception
{
    public $customID = 0;
    public function errorMessage()
    {
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b> ';
        return $errorMsg;
    }

    public function tryAgain()
    {
        $con = @mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
        $connect = '';
        if (!$con) {
            $connect = "连接错误: " . @mysqli_connect_error();
        }
        @mysqli_set_charset($con, DB_CHARSET);
        $sql = $this->getMessage();
        if (!mysqli_query($con, $sql)) {
            if (class_exists('\Predis\Client')) $redisService = new \Predis\Client(['host' => REDIS_HOST, 'port' => REDIS_PORT]);
            if ($redisService) {  // 错误sql临时存到redis
                $data = [
                    'page_link' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                    'admin' => $_SESSION['admin_id'],
                    'sql' => $sql,
                    'error_mes' => @mysqli_errno($con) . ':' . @mysqli_error($con),
                    'time' => date('Y-m-d H:i:s'),
                    'connect_error' => $connect
                ];
                $redisService->rpush('mysqlErrorLog:historyTable', json_encode($data));
            }
            $error = @mysqli_error($con);
            @mysqli_close($con);
            return $error;
        } else {
            $insertID = @mysqli_insert_id($con);
            @mysqli_close($con);
            return $insertID;
        }
    }
}

class shipAreaSign
{
    /**
     * 出入库单号  地区 区分   key 对应历史表record_type  value 对应出入库单号后缀
     *
     * @var array
     */
    protected $signs = [4 => 'WH', 5 => 'SEA', 6 => 'DE', 7 => 'AU', 8 => 'NC', 9 => 'UK', 10 => 'SZ', 11 => 'SEA-B', 12 => 'TL-B'];

    public function getAreaSign($areaType)
    {
        if (is_numeric($areaType)) {
            return $this->signs[$areaType];
        } else {
            return array_search($areaType, $this->signs);
        }
    }
}


class warehouseClass extends shipAreaSign
{
    /**
     * db类
     *
     * @var \queryFactory
     */
    protected $db;

    /**
     * 库存ID
     *
     * @var int|array
     */
    protected $productsInstockId;

    /**
     * 主产品ID
     *
     * @var int
     */
    public $mainProducts = 0;

    /**
     * 原始主id
     *
     * @var int
     */
    public $originMainProducts = 0;

    /**
     * 仓库
     *
     * @var   int|array
     */
    protected $warehouse;

    /**
     * 仓库名 （暂时没用到）
     *
     * @var
     */
    protected $warehouseName;

    /**
     * 处理库存的方式   1 加库存  0 减库存
     *
     * @var int
     */
    protected $handleType;

    /**
     * 改变库存的数量
     *
     * @var int
     */
    protected $changeQty;

    /**
     * 货架ID
     *
     * @var int
     */
    protected $zoneID;

    /**
     * 货架名
     *
     * @var
     */
    protected $zone;

    /**
     * 多个货架（暂未用到）
     *
     * @var
     */
    protected $moreZone;

    /**
     * 库存是否改变
     *
     * @var bool
     */
    protected $instockIsChange = false;

    /**
     * 货架库存是否改变
     *
     * @var bool
     */
    protected $zoneIsChange = false;

    /**
     * 货架库存处理类型  1 加 0 减
     *
     * @var int
     */
    protected $zoneHandleType;

    /**
     * 货架改变数量
     *
     * @var int
     */
    protected $zoneChangeQty;

    /**
     * 需要记录货架历史的和货架库存的仓库ID
     *
     * @var array
     */
    private $needReordWarehouse = [3, 20, 37, 40, 41];

    /**
     * mysql连接
     *
     * @var \mysqli
     */
    private $sqlCon;

    /**
     * 自动获取关联定制半成品
     *
     * @var bool
     */
    public $autoGetCustom = true;

    protected $cacheType = "";

    function __construct()
    {
        global $db;
        $this->db = $db;
        $this->cacheType = sqlCacheType();
//        $this->sqlCon = @mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
//        if ($this->sqlCon) {
//            @mysqli_set_charset($this->sqlCon, DB_CHARSET);
//        }
    }

    /**
     * 设置产品ID
     *
     * @param      $productsID
     * @param bool $getMainID
     * @param  $isChangeMainId
     * @return $this
     */
    public function setProducts($productsID, $getMainID = false,$isChangeMainId = true)
    {
        if ($getMainID) {
            $related = $this->db->Execute("select {$this->cacheType} r.products_id,m.products_id as main_id from products_instock_add_related as r left join products_instock_add_model as m using(model_id) where r.products_id = " . (int)$productsID . ' order by r.warehouse asc limit 1');
            $productsID = $related->fields['main_id'] ? $related->fields['main_id'] : $productsID;
        }
        $this->mainProducts = $productsID;
        if($isChangeMainId){
            $this->originMainProducts = $productsID;
        }
        $this->getInstockID();
        return $this;
    }

    /**
     * 设置仓库   可以是int单个   也可以是数组多个仓库
     *
     * @param $warehouse
     * @return $this
     */
    public function setWarehouse($warehouse)
    {
        if (is_array($warehouse)) {
            foreach ($warehouse as $v) {
                $newArr[] = (int)$v;
            }
            $warehouse = $newArr;
        }
        $this->warehouse = $warehouse;
        $this->getInstockID();
        return $this;
    }

    /**
     * 设置货架   设置货架字符需要在获取库存之后
     *
     * @param $zone
     * @return $this
     */
    public function setZone($zone)
    {
        $this->getInstockID();
        if (is_numeric($zone)) {
            $verify = $this->db->Execute('select instock_zone from products_instock_zone where zone_id=' . (int)$zone);
            if ($verify->fields['instock_zone']) {
                $this->zoneID = $zone;
                $this->zone = $verify->fields['instock_zone'];
            }
        } elseif ($zone && is_numeric($this->productsInstockId)) {
            $verify = $this->db->Execute('select zone_id from products_instock_zone where products_instock_id = ' . (int)$this->productsInstockId . ' and instock_zone="' . $zone . '"');
            if ($verify->fields['zone_id']) {
                $this->zoneID = $verify->fields['zone_id'];
                $this->zone = $zone;
            }
        }
        return $this;
    }

    /**
     * 直接设置库存ID
     *
     * @param $instockID
     * @return $this
     */
    public function setInstockID($instockID, $zone = null)
    {
        $this->productsInstockId = $instockID;
        if (is_numeric($zone)) {
            $verify = $this->db->Execute('select instock_zone from products_instock_zone where zone_id=' . (int)$zone);
            if ($verify->fields['instock_zone']) {
                $this->zoneID = $zone;
                $this->zone = $verify->fields['instock_zone'];
            }
        } elseif ($zone) {
            $verify = $this->db->Execute('select zone_id from products_instock_zone where products_instock_id = ' . (int)$instockID . ' and instock_zone="' . $zone . '"');
            if ($verify->fields['zone_id']) {
                $this->zoneID = $verify->fields['zone_id'];
                $this->zone = $zone;
            }
        }
        return $this;
    }

    /**
     * 获取库存对应的仓库id或者仓库名称
     *
     * @param int $instockID 库存id
     * @param bool $cnName 是否取仓库名
     * @return mixed|null
     */
    public function getThisInstockWarehouse($instockID = 0, $cnName = false)
    {
        $instockID = $instockID ? $instockID : $this->productsInstockId;
        if (is_numeric($instockID)) {
            $info = $this->getInstockInfoByInstockID($instockID);
            if ($cnName) {
                return $this->getWarehouseNameByWID($info['warehouse']);
            } else {
                return $info['warehouse'];
            }
        } else {
            return null;
        }
    }

    /**
     * 根据仓库id查仓库名
     *
     * @param $warehouseID
     * @return mixed
     */
    public function getWarehouseNameByWID($warehouseID)
    {
        $res = $this->db->Execute('select description from products_instock_warehouse where id = ' . (int)$warehouseID);
        return $res->fields['description'];
    }

    /**
     * 根据库存id查仓库名
     *
     * @param $productsInstockId
     * @return mixed
     */
    public function getWarehouseNameByInstockID($productsInstockId)
    {
        $res = $this->db->Execute("SELECT pw.description FROM products_instock_warehouse pw LEFT JOIN products_instock pi ON (pw.id = pi.warehouse and pi.warehouse > 0) WHERE pi.products_instock_id = " . $productsInstockId . " limit 1");
        return $res->fields['description'] ?: '';
    }

    /**
     * 获取当前设置的库存数量  多个仓库的话是累加数量
     *
     * @return int|mixed
     */
    public function getThisInstockQty()
    {
        if (is_numeric($this->productsInstockId)) {
            $data = $this->getInstockInfoByInstockID();
        } elseif (is_array($this->productsInstockId)) {
            $total = 0;
            foreach ($this->productsInstockId as $id) {
                $info = $this->getInstockInfoByInstockID($id);
                $total += $info['instock_qty'];
            }
        }
        if ($data) {
            return $data['instock_qty'];
        } elseif ($total) {
            return $total;
        } else {
            return 0;
        }
    }

    /**
     * 获取当前库存的可用数量    多个仓库的则返回多个库存数的数组   键值为库存ID
     *
     * @param bool $containStoreLock
     * @return int|mixed
     */
    public function getThisInstockUsableQty($containStoreLock = false)
    {
        $instockData = $this->getInstockInfoByInstockID();
        if ($instockData) {
            $lockTotal = 0;
            if($instockData['instock_qty'] && $instockData['instock_qty'] > 0){
                $lockTotal = $this->getInstockLockQty($this->productsInstockId, $containStoreLock);
            }
            $usableQty = $instockData['instock_qty'] - $lockTotal;
            $usableQty = $usableQty > 0 ? $usableQty : 0;
            return $usableQty;
        } elseif (is_array($this->productsInstockId)) {
            $total = [];
            foreach ($this->productsInstockId as $warehouse => $id) {
                $lockTotal = 0;
                $info = $this->getInstockInfoByInstockID($id);
                if($info['instock_qty'] && $info['instock_qty'] > 0){
                    $lockTotal = $this->getInstockLockQty($id, $containStoreLock);
                }
                $total[$id] = $info['instock_qty'] - $lockTotal > 0 ? $info['instock_qty'] - $lockTotal : 0;
            }
            return $total;
        } else {
            return 0;
        }
    }

    /**
     * 获取当前的库存ID
     *
     * @return array|mixed|null
     */
    public function getThisInstockID()
    {
        return $this->productsInstockId;
    }

    /**
     * 获取当前货架的ID
     *
     * @return mixed
     */
    public function getThisInstockZoneID()
    {
        return $this->zoneID;
    }

    /**
     * 获取当前的货架号
     *
     * @return mixed
     */
    public function getCurrentZone()
    {
        return $this->zone;
    }

    /**
     * 判断库存是否更新    如果有入库记录  则是返回FALSE
     *
     * @return bool
     */
    public function thisInstockIsChange()
    {
        return $this->instockIsChange;
    }

    /**
     * 获取库存的货架信息
     *
     * @param int $instockID
     * @return array|null
     */
    public function getThisInstockZones($instockID = 0)
    {
        $productsInstockID = is_numeric($this->productsInstockId) ? $this->productsInstockId : 0;
        $instockID = $instockID ? $instockID : $productsInstockID;
        if ($instockID) {
            $res = $this->db->Execute('select products_instock_id,instock_zone,instock_type,zone_type,instock_qty,zone_id from products_instock_zone where products_instock_id = ' . (int)$instockID);
            while (!$res->EOF) {
                $data[] = [
                    'instock_zone' => $res->fields['instock_zone'],
                    'products_instock_id' => $res->fields['products_instock_id'],
                    'instock_type' => $res->fields['instock_type'],
                    'zone_type' => $res->fields['zone_type'],
                    'instock_qty' => $res->fields['instock_qty'],
                    'zone_id' => $res->fields['zone_id'],
                ];
                $res->MoveNext();
            }
            return $data;
        } else {
            return null;
        }
    }

    /**
     * 获取通过产品ID和仓库查找的库存ID
     *
     * @return array|mixed|null
     */
    protected function getInstockID()
    {
        if ($this->mainProducts && $this->warehouse) {
            if (is_array($this->warehouse)) {
                $res = $this->db->Execute("select {$this->cacheType} products_instock_id,warehouse from products_instock where products_id = " . (int)$this->mainProducts . ' and warehouse in (' . implode(',', $this->warehouse) . ')');
            } else {
                $res = $this->db->Execute("select {$this->cacheType} products_instock_id,warehouse from products_instock where products_id = " . (int)$this->mainProducts . ' and warehouse = ' . (int)$this->warehouse);
            }
            while (!$res->EOF) {
                $customInstockID = 0;
                if ($res->fields['warehouse'] == 6 && $this->autoGetCustom) {
                    $customId = fs_get_data_from_db_fields('customized_id', 'products_instock_customized_related', 'customized_id =' . (int)$this->mainProducts . ' or products_id= ' . (int)$this->mainProducts, ' limit 1');
                    if ($customId) {
                        $customInstockID = fs_get_data_from_db_fields('products_instock_id', 'products_instock', 'warehouse = 6 and products_id = ' . $customId);
                    }
                }
                $data[] = $customInstockID ? $customInstockID : $res->fields['products_instock_id'];
                $warehouse[] = $res->fields['warehouse'];
                $res->MoveNext();
            }
            if (sizeof($data) == 1) {
                $this->productsInstockId = $data[0];
                return $data[0];
            } else {
                $newData = [];
                if(!empty($data)){
                    foreach ($data as $k => $v) {
                        $newData[$warehouse[$k]] = $v;
                    }
                }
                $this->productsInstockId = $newData;
                return $data;
            }
        } else {
            return null;
        }
    }

    /**
     * 通过库存ID获取库存数据
     *
     * @param int $instockID
     * @return array|null
     */
    protected function getInstockInfoByInstockID($instockID = 0)
    {
        if (is_numeric($this->productsInstockId)) {
            $productsInstockID = $this->productsInstockId;
        }
        $instockID = $instockID ? $instockID : $productsInstockID;
        if (empty($instockID)) {
            return null;
        }
        $res = $this->db->Execute("select {$this->cacheType} instock_qty,instock_number,admin,`time`,warehouse,zone_qty,products_id from products_instock where products_instock_id = " . (int)$instockID);
        $goodsType = "";
        $data = [
            'instock_qty' => $goodsType == 1 ? $res->fields['instock_qty'] / 1000 : $res->fields['instock_qty'],
            'instock_number' => $res->fields['instock_number'],
            'admin' => $res->fields['admin'],
            'time' => $res->fields['time'],
            'warehouse' => $res->fields['warehouse'],
            'products_id' => $res->fields['products_id'],
            'zone_qty' => $goodsType == 1 ? $res->fields['zone_qty'] / 1000 : $res->fields['zone_qty'],
            'products_instock_id' => $instockID,
        ];
        return $data;
    }

    /**
     * 通过库存ID获取库存锁定数量
     *
     * @param int $instockID
     * @param bool $containStoreLock
     * @return int|null
     */
    protected function getInstockLockQty($instockID = 0, $containStoreLock = true)
    {
        if (is_numeric($this->productsInstockId)) {
            $productsInstockID = $this->productsInstockId;
        }
        $instockID = $instockID ? $instockID : $productsInstockID;
        if (empty($instockID)) {
            return null;
        }
        $backstageLock = $this->db->Execute("select {$this->cacheType} sum(change_qty) as total from products_instock_history_temp where type=0 and products_instock_id = " . (int)$instockID);
        $backstageLockQty = $backstageLock->fields['total'];
        if ($containStoreLock) {
            $storeLock = $this->db->Execute("select {$this->cacheType} sum(qty) as total from products_instock_orders where instock_id = " . (int)$instockID);
            $storeLockQty = $storeLock->fields['total'];
        }
        return (int)$backstageLockQty + (int)$storeLockQty;
    }

    /**
     * 库存处理    库存加减
     *
     * @param     $qty
     * @param     $type 1 加 0 减
     * @param     $length float 长度km
     * @return $this|null
     */
    public function stockpilingHandle($qty, $type, $length = 0.000)
    {
        $debugData = [
            'products_instock_id' => $this->productsInstockId,
            'main_products_id' => $this->mainProducts,
            'qty' => $qty,
            'type' => $type,
            'length' => $length,
            'log_type' => 'optical_cable'
        ];
        $this->instockIsChange = false;
        if (is_numeric($this->productsInstockId)) {
            $qty = abs($qty);
            $this->changeQty = $qty;
            $kmQty = $qty;//单位为km时的光缆数量,非光缆时，默认为$qty的数量，用于判断库存是否充足
            if (is_numeric($length) && $length > 0) {
                /*光缆产品单位转换m后出入库*/
                $qty = $qty * $length * 1000;
                $kmQty = $kmQty * $length;//单位为km时的光缆数量
            }
            $instockQty = $this->getThisInstockQty();
            $debugData['instock_qty'] = $instockQty;
            $debugData['m_qty'] = $qty;
            $debugData['km_qty'] = $kmQty;
            $zoneQty = fs_get_data_from_db_fields('instock_qty', 'products_instock_zone', 'zone_id = ' . (int)$this->zoneID);
            if ($type == 1) {
                $this->handleType = 1;
                if ($this->productsInstockId > 0) {
                    $this->db->Execute('update products_instock set instock_qty=instock_qty+' . (int)$qty . ' where products_instock_id = ' . (int)$this->productsInstockId);
                }
                $this->instockIsChange = true;
                //如果设置了货架  且是满足货架记录条件
                if ($this->zone && $this->zoneID && $this->needRecordZoneHistory()) {
                    $this->db->Execute('update products_instock_zone set instock_qty=instock_qty+' . (int)$qty . ' where zone_id = ' . (int)$this->zoneID);
                    $this->zoneIsChange = true;
                    $this->zoneChangeQty = $qty;
                    $this->zoneHandleType = 1;
                }
            } else {
                $this->handleType = 0;
                //若是光缆产品$instockQty的库存数据为除1000后的值，需要转换单位判断大小
                if ($instockQty >= $kmQty || $this->productsInstockId == 0) {
                    if ($this->productsInstockId > 0) {
                        $this->db->Execute('update products_instock set instock_qty=instock_qty-' . (int)$qty . ' where products_instock_id = ' . (int)$this->productsInstockId);

                        /*删除 武汉成品仓 海外调仓专区库存为零的货架位*/
                        $warehouse = fs_get_data_from_db_fields('warehouse', 'products_instock', ' products_instock_id= ' . (int)$this->productsInstockId);
                        if ($this->getThisInstockQty() == 0 && in_array($warehouse, array(2, 31))) {
                            $this->db->Execute('update products_instock_zone set products_instock_id = 0,products_instock_log_id = ' . (int)$this->productsInstockId . ' where products_instock_id = ' . (int)$this->productsInstockId);
                        }

                    }
                    $this->instockIsChange = true;
                }
                if ($this->zone && $this->zoneID && $this->needRecordZoneHistory() && $zoneQty >= $qty) {
                    $this->db->Execute('update products_instock_zone set instock_qty=instock_qty-' . (int)$qty . ' where zone_id = ' . (int)$this->zoneID);
                    $this->zoneIsChange = true;
                    $this->zoneChangeQty = $qty;
                    $this->zoneHandleType = 0;
                }
            }
            $debugData['instock_is_change'] = $this->instockIsChange ? 1 : 0;
            $id = fs_get_data_from_db_fields('id', 'products_fields', "products_id=" . (int)$this->getInstockProductsID() . " AND goods_type=1");
            if ($id > 0) debug_data($debugData);
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * 货架表绑定库存操作
     *
     * @param $qty   调整数量
     * @param $type  调整类型   1 入库  0 出库
     * @return $this|null
     */
    public function instockZoneHandle($qty, $type)
    {
        $zoneQty = fs_get_data_from_db_fields('instock_qty', 'products_instock_zone', 'zone_id = ' . (int)$this->zoneID);
        if (is_numeric($this->productsInstockId) && $this->zoneID && $this->needRecordZoneHistory()) {
            $qty = abs($qty);
            /*判断产品类型是否光缆产品*/
            $productsId = fs_get_data_from_db_fields('products_id', 'products_instock', 'products_instock_id=' . $this->productsInstockId, '');
            $goodsType = fs_get_data_from_db_fields('goods_type', 'products_fields', 'products_id=' . $productsId);
            if ($goodsType == 1) {
                /*光缆产品单位转换m后出入库*/
                $qty = $qty * 1000;
            }
            if ($type == 1) {
                $this->zoneHandleType = 1;
                $this->db->Execute('update products_instock_zone set instock_qty=instock_qty+' . (int)$qty . ' where zone_id = ' . (int)$this->zoneID);
                $this->zoneIsChange = true;
            } elseif ($zoneQty >= $qty) {
                $this->zoneHandleType = 0;
                $this->db->Execute('update products_instock_zone set instock_qty=instock_qty-' . (int)$qty . ' where zone_id = ' . (int)$this->zoneID);
                $this->zoneIsChange = true;
            }
            $this->zoneChangeQty = $qty;
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * 出入库历史表记录
     *
     * @param array $history 插入数据数组   数组键值为products_instock_history表的字段名
     * @param bool $isNormal 是否是正常出入库
     * @param null $area 区域   武汉 WH   西雅图  SEA  德国  DE   严格填写
     * @param bool $signs 特殊处理
     * @return int|null
     */
    public function recordHistory(array $history, $isNormal = false, $area = null, $signs = false)
    {
        if ($this->zoneIsChange) {
            $this->recordZoneHistory(0, ['remark' => $history['zone_remark'] ? $history['zone_remark'] : $history['message']]);
        }
        $sign = $this->getAreaSign($area);
        $sign = $isNormal ? $sign : 0;
        if (is_numeric($this->productsInstockId) && $this->changeQty && $this->instockIsChange) {
            $recordType = $isNormal ? 1 : 0;
            $changeQty = $this->handleType == 1 ? $this->changeQty : -$this->changeQty;
            $warehousingNumber = fs_create_warehousing_number($this->handleType, $recordType, $area);
            if ($history['warehousing_number']) {
                $warehousingNumber = $history['warehousing_number'];
            }

            /*获取光缆产品的长度*/
            $productsLength = 0;
            if (!is_numeric($history['products_length']) || $history['products_length'] <= 0) {
                if ((int)$history['products_shipping_info_id'] > 0) {
                    $productsLength = fs_get_data_from_db_fields('products_length', 'products_instock_shipping_info', 'products_shipping_info_id=' . (int)$history['products_shipping_info_id'], '');
                } else if ((int)$history['shipping_info_id'] > 0) {
                    $productsLength = fs_get_data_from_db_fields('products_length', 'products_instock_shipping_info', 'products_shipping_info_id=' . (int)$history['shipping_info_id'], '');
                } else if ((int)$history['apply_id'] > 0) {
                    $productsLength = fs_get_data_from_db_fields('products_length', 'purchase_apply_instock_info', 'info_id=' . (int)$history['apply_id'], '');
                } else if ((int)$history['products_check_id'] > 0) {
                    $tempInfo = fs_get_data_from_db_fields_array(array('products_instock_info_id', 'purchase_info_id', 'pack_instock_id'), 'products_instock_check', 'products_check_id=' . (int)$history['products_check_id'], '');
                    if ($tempInfo[0][0] > 0) {
                        $productsLength = fs_get_data_from_db_fields('products_length', 'products_instock_shipping_info', 'products_shipping_info_id=' . (int)$tempInfo[0][0], '');
                    } else if ($tempInfo[0][1] > 0) {
                        $productsLength = fs_get_data_from_db_fields('products_length', 'purchase_apply_instock_info', 'info_id=' . (int)$tempInfo[0][1], '');
                    } else if ($tempInfo[0][2] > 0) {
                        $tempInfoId = fs_get_data_from_db_fields('products_shipping_info_id', 'products_instock_packing', 'products_instock_packing_id=' . $tempInfo[0][2], '');
                        if ($tempInfoId > 0) {
                            $productsLength = fs_get_data_from_db_fields('products_length', 'products_instock_shipping_info', 'products_shipping_info_id=' . (int)$tempInfoId, '');
                        }
                    }
                }
            } else {
                $productsLength = (float)$history['products_length'];
            }
            if (empty($history['virtual_products_id']) && ($history['products_shipping_info_id'] || $history['shipping_info_id'])) {
                $virtualProducts = fs_get_data_from_db_fields('virtual_products_id', 'products_instock_shipping_info', 'products_shipping_info_id=' . ($history['products_shipping_info_id'] ? (int)$history['products_shipping_info_id'] : (int)$history['shipping_info_id']));
                $history['virtual_products_id'] = $virtualProducts;
            }
            if ($history['virtual_products_id']) {
                $bindID = $this->getVirtualProductsBindID($history['virtual_products_id'], $this->productsInstockId, true);
                if ($bindID) {
                    $this->handleVirtualProductsInstock($bindID, $this->handleType, $this->changeQty, ($history['products_length'] > 0 ? $history['products_length'] : $productsLength));
                }
            }
            $time = $history['date'] ? $history['date'] : 'now()';
            $record = $sign ? $sign : (int)$history['record_type'];
            $recPID = $history['products_id'] ? $history['products_id'] : $this->mainProducts;
            if ($history['apply_id'] > 0 && $record == 4 && $this->handleType == 1 && empty($history['virtual_products_id'])) {
                $originID = fs_get_data_from_db_fields('products_shipping_info_id', 'purchase_apply_instock_info', 'apply_type=11 and info_id = ' . $history['apply_id']);
                if ($originID) {
                    $history['virtual_products_id'] = fs_get_data_from_db_fields('virtual_products_id', 'products_instock_shipping_info', 'products_shipping_info_id = ' . (int)$originID);
                }
            }
            $insertData = [
                'products_instock_id' => (int)$this->productsInstockId,
                'products_shipping_info_id' => (int)$history['products_shipping_info_id'],
                'products_id' => (int)$recPID,
                'order_number' => $history['order_number'],
                'instock_number' => $history['instock_number'],
                'outstock_number' => $history['outstock_number'],
                'warehousing_number' => $signs ? '' : $warehousingNumber,
                'change_type' => $signs ? 20 : (int)$history['change_type'],
                'qty' => (int)$history['qty'],
                'change_qty' => $changeQty,
                'admin' => $history['admin'] ? $history['admin'] : $_SESSION['admin_id'],
                'message' => $history['message'],
                'apply_id' => (int)$history['apply_id'],
                'products_price' => $history['products_price'],
                'products_rate' => $history['products_rate'],
                'manufacturer' => $history['manufacturer'],
                'shipping_price' => $history['shipping_price'],
                'purchase_admin' => (int)$history['purchase_admin'],
                'date' => $signs ? '2018-01-02 09:45:00' : $time,
                'status' => (int)$history['status'],
                'is_agree' => (int)$history['is_agree'],
                'remark' => $history['remark'],
                'is_ship' => (int)$history['is_ship'],
                'apply_instock_id' => (int)$history['apply_instock_id'],
                'products_check_id' => (int)$history['products_check_id'],
                'warehouse_remark' => $history['warehouse_remark'],
                'return_info_id' => (int)$history['return_info_id'],
                'record_type' => $signs ? 0 : $record,
                'history_number' => $history['history_number'],
                'instock_zone' => $this->zone ? $this->zone : $history['instock_zone'],
                'abort_info_id' => (int)$history['abort_info_id'],
                'shipping_info_id' => (int)$history['shipping_info_id'],
                'parts_id' => (int)$history['parts_id'],
                'is_delete' => (int)$history['is_delete'],
                'virtual_products_id' => (int)$history['virtual_products_id'],
                'products_length' => (float)$productsLength,
                'instock_products_id' => zen_get_products_related_model($recPID),
            ];
            //zen_db_perform('products_instock_history', $insertData);
            $insertID = $this->insertHistory($insertData, $this->handleType, $recordType, $area);
            $this->instockIsChange = false;
            return $insertID;
        } else {
            return null;
        }
    }

    /**
     * 记录货架历史表数据
     *
     * @param int $recordType
     * @return int|null
     */
    public function recordZoneHistory($recordType = 0, $data = array())
    {
        if (is_numeric($this->productsInstockId) && $this->zone && $this->zoneIsChange) {
            $zoneType = substr($this->zone, 0, 1);
            $qty = $this->zoneHandleType == 1 ? $this->zoneChangeQty : -$this->zoneChangeQty;
            $insertData = [
                'products_instock_id' => $this->productsInstockId,
                'instock_zone' => $this->zone,
                'zone_type' => $zoneType,
                'qty' => $qty,
                'admin_id' => $_SESSION['admin_id'],
                'date' => 'now()',
                'type' => $recordType,
                'remark' => $data['remark'],
            ];
            zen_db_perform('products_instock_zone_history', $insertData);
            $this->zoneIsChange = false;
            return $this->db->insert_ID();
        } else {
            return null;
        }
    }

    /**
     * 新增货架
     *
     * @param     $zone      货架名称 example E01-001
     * @param int $zoneQty 货架绑定数量
     * @param int $instockID 库存ID
     * @return warehouseClass|null
     */
    public function addInstockZone($zone, $zoneQty = 0, $instockID = 0)
    {
        $productsInstockID = is_numeric($this->productsInstockId) ? $this->productsInstockId : 0;
        $instockID = $instockID ? $instockID : $productsInstockID;
        $result = null;
        if ($instockID && $zone) {
            $zoneType = substr($zone, 0, 1);
            $instockType = substr($zone, 0, strpos($zone, '-'));
            $verify = $this->db->Execute('select zone_id from products_instock_zone where products_instock_id = ' . (int)$instockID . ' and instock_zone="' . $zone . '"');
            if (empty($verify->fields['zone_id'])) {
                $this->db->Execute("insert into products_instock_zone (`products_instock_id`, `instock_zone`, `instock_type`, `zone_type`, `instock_qty`) values 
                                    ({$instockID},'{$zone}','{$instockType}','{$zoneType}',{$zoneQty})");
                $zoneID = $this->db->insert_ID();
                if ($zoneID && $this->needRecordZoneHistory($instockID)) {
                    $this->zone = $zone;
                    $this->zoneID = $zoneID;
                    $this->zoneChangeQty = $zoneQty;
                    $this->zoneIsChange = true;
                    $this->zoneHandleType = 1;
                    $this->recordZoneHistory(1);
                }
                $result = $this;
            }
        }
        return $result;
    }

    /**
     * 删除货架
     *
     * @param int $zoneID
     * @return bool
     */
    public function deleteInstockZone($zoneID = 0)
    {
        $zoneID = $zoneID ? $zoneID : $this->zoneID;
        $bool = false;
        if ($zoneID) {
            $verify = $this->db->Execute('select instock_zone,zone_type,instock_qty,products_instock_id from products_instock_zone where zone_id=' . (int)$zoneID);
            if ($verify->fields['instock_qty'] == 0) {
                $this->db->Execute('delete from products_instock_zone where zone_id=' . (int)$zoneID);
                $bool = true;
                if ($this->needRecordZoneHistory($verify->fields['products_instock_id'])) {
                    $this->zone = $verify->fields['instock_zone'];
                    $this->zoneID = $zoneID;
                    $this->zoneChangeQty = $verify->fields['products_instock_id'];
                    $this->zoneIsChange = true;
                    $this->zoneHandleType = 1;
                    $this->recordZoneHistory(2);
                }
            }
        }
        return $bool;
    }

    /**
     * 验证库存ID是否需要记录货架历史表
     *
     * @param int $instockID
     * @return bool
     */
    protected function needRecordZoneHistory($instockID = 0)
    {
        $productsInstockID = is_numeric($this->productsInstockId) ? $this->productsInstockId : 0;
        $instockID = $instockID ? $instockID : $productsInstockID;
        $result = false;
        if ($instockID) {
            $verify = $this->db->Execute('select warehouse from products_instock where products_instock_id = ' . (int)$instockID);
            if (in_array($verify->fields['warehouse'], $this->needReordWarehouse)) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * 是否创建过库存    产品ID必须是主产品ID
     *
     * @param int $productsID
     * @param int $warehouseID
     * @return bool
     */
    public function whetherMakerStock($productsID = 0, $warehouseID = 0)
    {
        $warehouse = is_numeric($this->warehouse) ? $this->warehouse : 0;
        $productsID = $productsID ? $productsID : $this->mainProducts;
        $warehouseID = $warehouseID ? $warehouseID : $warehouse;
        $bool = false;
        if ($productsID && $warehouseID) {
            if (empty($this->mainProducts)) {
                $this->mainProducts = $productsID;
            }
            if (empty($this->warehouse)) {
                $this->warehouse = $warehouseID;
            }
            $verify = $this->db->Execute('select products_instock_id from products_instock where products_id = ' . (int)$productsID . ' and warehouse = ' . (int)$warehouseID);
            if ($verify->fields['products_instock_id']) {
                $bool = true;
            }
        }
        return $bool;
    }

    /**
     * 创建库存
     *
     * @return int
     */
    public function createInstock()
    {
        $instockID = 0;
        if ($this->warehouse && is_numeric($this->warehouse) && $this->mainProducts) {
            $insertData = [
                'products_id' => $this->mainProducts,
                'warehouse' => $this->warehouse,
                'admin' => $_SESSION['admin_id'],
                'time' => 'now()',
            ];
            zen_db_perform('products_instock', $insertData);
            $instockID = $this->db->insert_ID();
            if ($instockID) {
                if (empty($this->productsInstockId)) {
                    $this->productsInstockId = $instockID;
                }
                $prefix = $this->db->Execute('select `name` from products_instock_warehouse where id = ' . (int)$this->warehouse);
                $instockNumber = $prefix->fields['name'] . str_pad($instockID, 5, '0', STR_PAD_LEFT);
                $this->db->Execute('update products_instock set instock_number = "' . $instockNumber . '" where products_instock_id = ' . $instockID);
            }
        }
        return $instockID;
    }

    /**
     * 历史表插入记录
     * ------------------
     * 添加了异常处理，warehousing_number为唯一字段    并发时php插入可能会重复
     * 再执行一次SQL 用新的warehousing_number替换
     * ------------------
     *
     * @param       $table
     * @param array $insertData
     * @param       $recordType
     * @param       $area
     * @return int|string
     */
    public function insertHistory(array $insertData, $handleType, $recordType, $area)
    {
        $fields = ' (';
        $values = ' (';
        foreach ($insertData as $key => $val) {
            $fields .= "`{$key}`,";
            if ($key == 'date' && $val == 'now()') {
                $values .= "now(),";
            } else {
                $values .= "'{$val}',";
            }
        }
        $fields = substr($fields, 0, -1) . ')';
        $values = substr($values, 0, -1) . ')';
        $sql = 'insert into products_instock_history' . $fields . ' values ' . $values;
        try {
            // 当执行插入SQL出错时 抛出异常  异常处理类中再执行一次SQL  （只会执行一次，再次执行会抑制报错）
            if (!mysqli_query($this->sqlCon, $sql)) {
                $fields = '(';
                $values = '(';
                foreach ($insertData as $key => $val) {
                    $fields .= "`{$key}`,";
                    /*if ($key == 'warehousing_number') {
                        $values .= "'" . fs_create_warehousing_number($handleType, $recordType, $area) . "',";
                    } else*/
                    if ($key == 'date') {
                        $values .= "now(),";
                    } else {
                        $values .= "'{$val}',";
                    }
                }
                $errorData = [
                    'sql' => $sql,
                    'error_mes' => @mysqli_errno($this->sqlCon) . ':' . @mysqli_error($this->sqlCon),
                    'mysql' => is_resource($this->sqlCon)
                ];
                //set_log_to_redis_list('warehouseError:log',$errorData);//sql出错的话 就存日志
                $fields = substr($fields, 0, -1) . ')';
                $values = substr($values, 0, -1) . ')';
                $sql = 'insert into products_instock_history ' . $fields . ' values ' . $values;
                throw new warehousingNumberException($sql);
            } else {
                $insertID = @mysqli_insert_id($this->sqlCon);
                @mysqli_close($this->sqlCon);
                return $insertID;
            }
        } catch (warehousingNumberException $exception) {
            return $exception->tryAgain();
        }
    }

    /**
     * 获取库存对应的产品ID
     *
     * @param int $instockID
     * @return mixed|null
     */
    public function getInstockProductsID($instockID = 0)
    {
        $instockData = $this->getInstockInfoByInstockID($instockID);
        if ($instockData) {
            return $instockData['products_id'];
        } else {
            return null;
        }
    }

    /**
     * 定制ID库存绑定虚拟标准ID
     *
     * @param     $virtualProductsID
     * @param int $instockID
     * @return int|null
     */
    public function instockBindVirtualProducts($virtualProductsID, $instockID = 0)
    {
        $instockID = $instockID ? $instockID : $this->productsInstockId;
        if ($virtualProductsID && $instockID) {
            $instockInfo = $this->getInstockInfoByInstockID($instockID);
            $goodsType = fs_get_data_from_db_fields('goods_type', 'products_fields', 'products_id=' . (int)$instockInfo['products_id']);
            $status = 1;
            if ($goodsType == 1) {
                $status = 2;
            }
            $insertData = [
                'virtual_products_id' => $virtualProductsID,
                'products_instock_id' => $instockID,
                'warehouse' => $instockInfo['warehouse'],
                'admin' => $_SESSION['admin_id'],
                'created_at' => 'now()',
                'updated_at' => 'now()',
                'status' => $status,
            ];
            zen_db_perform('products_instock_bind_virtual_products', $insertData);
            return $this->db->insert_ID();
        } else {
            return null;
        }
    }

    /**
     * 获取定制ID库存绑定虚拟ID的  关联ID
     *
     * @param      $virtualProductsID
     * @param int $instockID
     * @param bool $autoCreate
     * @return int|null
     */
    public function getVirtualProductsBindID($virtualProductsID, $instockID = 0, $autoCreate = false)
    {
        $instockID = $instockID ? $instockID : $this->productsInstockId;
        $bind_id = 0;
        if ($virtualProductsID && $instockID) {
            if (is_array($instockID)) {
                $instockID = implode('', $instockID);
            }
            $res = $this->db->Execute('select bind_id from products_instock_bind_virtual_products where virtual_products_id = ' . (int)$virtualProductsID . ' and products_instock_id = ' . $instockID);
            if ($res->fields['bind_id']) {
                $bind_id = $res->fields['bind_id'];
            }
        }
        if (empty($bind_id) && $autoCreate) {
            $bind_id = $this->instockBindVirtualProducts($virtualProductsID, $instockID);
        }
        return $bind_id;
    }

    /**
     * 虚拟ID绑定库存 处理方法
     *
     * @param $bindID
     * @param $handleType
     * @param $changeQty
     * @param $productsLength
     */
    public function handleVirtualProductsInstock($bindID, $handleType, $changeQty, $productsLength = 0.000)
    {
        if ($bindID && $changeQty) {
            if ($productsLength > 0 && is_numeric($productsLength)) {
                $changeQty = $changeQty * $productsLength * 1000;
            }
            if ($handleType == 1) {
                $this->db->Execute('update products_instock_bind_virtual_products set bind_qty = bind_qty + ' . (int)$changeQty . ',updated_at = now() where bind_id = ' . (int)$bindID);
            } else {
                $res = $this->db->Execute('select bind_qty from products_instock_bind_virtual_products where bind_id = ' . (int)$bindID);
                if ($res->fields['bind_qty'] < $changeQty) {
                    $changeQty = $res->fields['bind_qty'];
                }
                $this->db->Execute('update products_instock_bind_virtual_products set bind_qty = bind_qty - ' . (int)$changeQty . ',updated_at = now() where bind_id = ' . (int)$bindID);
            }
        }
    }

    /**
     * 获取虚拟ID的库存数据
     *
     * @param     $virtualProductsID
     * @param int $instockID
     * @return array
     */
    public function getVirtualProductsInstock($virtualProductsID, $instockID = 0)
    {
        $data = null;
        $instockID = $instockID ? $instockID : $this->productsInstockId;
        if ($instockID && $virtualProductsID) {
            $res = $this->db->Execute('select bind_id,bind_qty,products_instock_id,warehouse,status from products_instock_bind_virtual_products where virtual_products_id= ' . (int)$virtualProductsID . ' and products_instock_id=' . (int)$instockID);
            if ($res->fields['bind_id']) {
                $data = [
                    'bind_id' => $res->fields['bind_id'],
                    'bind_qty' => ($res->fields['status'] == 2 ? $res->fields['bind_qty'] / 1000 : $res->fields['bind_qty']),
                    'warehouse' => $res->fields['warehouse'],
                ];
            }
        }
        return $data;
    }

    /**
     * 根据产品获取前台库存
     *
     * @author  aron
     * @date 2019.7.3
     * @param $isSemiFinished 是否半成品
     * @param $products_id
     * @param $warehouse
     * @return int
     */
    public function getFrontInstock($products_id, $warehouse,$isSemiFinished = false)
    {
        $this->autoGetCustom = false;
        if ($warehouse == "US") {
            $type = 3;
        } elseif ($warehouse == "DE") {
            $type = 20;
            if($isSemiFinished){
                $type = 104;
            }
        } elseif ($warehouse == "AU") {
            $type = 37;
        } elseif ($warehouse == "US-ES") {
            $type = 40;
            if($isSemiFinished){
                $type = 98;
            }
        }elseif ($warehouse == "SG") {
            $type = 71;
        }elseif ($warehouse == "RU") {
            $type = 67;
        } else {
            $type = 2;
        }
        $qty = 0;
        $extra_qty = 0;
        $current_qty = 0;
        if ($type == 3) {
            return $qty;
        }
        if ($type == 2) {
            $is_customized = fs_get_data_from_db_fields( 'id', 'products_instock_customized_related',
                'products_id >0 and customized_id= ' . (int)$products_id, ' limit 1');
            if ($is_customized) {
                $current_qty = $this->setProducts($products_id, true)->setWarehouse(102)
                    ->getThisInstockUsableQty(true);

            } else {
                $current_qty = $this->setProducts($products_id, true)
                    ->setWarehouse([1])
                    ->getThisInstockUsableQty(true);
                $customId = fs_get_data_from_db_fields('customized_id', 'products_instock_customized_related', 'customized_id =' . (int)$this->mainProducts . ' or products_id= ' . (int)$this->mainProducts, ' limit 1');
                if ($customId) {
                    $extra_qty = $this->setProducts($customId, true,false)->setWarehouse(102)
                        ->getThisInstockUsableQty(true);
                }
            }
            if (is_array($current_qty)) {
                foreach ($current_qty as $v) {
                    $qty += (int)$v;
                }
            } else {
                $qty = (int)$current_qty;
            }
            if (is_array($extra_qty)) {
                foreach ($extra_qty as $e) {
                    $qty += (int)$e;
                }
            } else {
                $qty += (int)$extra_qty;
            }
            $qty = (int)$qty > 0 ? (int)$qty : 0;
            return $qty;
        }
        $current_qty = $this->setProducts($products_id, true)->setWarehouse($type)
            ->getThisInstockUsableQty(true);
        if (is_array($current_qty)) {
            foreach ($current_qty as $v) {
                $qty += (int)$v;
            }
        } else {
            $qty = (int)$current_qty;
        }
        $qty = (int)$qty > 0 ? (int)$qty : 0;
        return $qty;
    }

    /**
     * 判断产品是否为定制产品
     *
     * @param int $products_id
     * @return bool
     */
    public function isCustom($products_id = 0)
    {
        $related = $this->db->Execute("select {$this->cacheType} r.products_id,m.products_id as main_id from products_instock_add_related as r left join products_instock_add_model as m using(model_id) where r.products_id = " . (int)$products_id . ' order by r.warehouse asc limit 1');
        $products_id = $related->fields['main_id'] ? $related->fields['main_id'] : $products_id;
        $customID = $this->db->Execute("select {$this->cacheType} customized_id from products_instock_customized_related where
                    products_id = " . $products_id . ' or customized_id = ' . $products_id  . ' limit 1')
            ->fields['customized_id'];
        $this->customID = $customID;
        if ($customID && $customID == $products_id) {
            return true;
        }
        return false;

    }

    /**
     * 中国仓已清点 未入库库存查询
     * 不在展示流转区库存
     *
     * @update 2020.7.8
     * @author aron
     * @return int
     */
    public function getCnTempStock(){
        $qty = 0;
        if(empty($this->originMainProducts)){
            return $qty;
        }
        return $qty;
        $data = $this->db->Execute("SELECT sum(inventory_number-instock_into_qty) as total FROM `purchase_apply_instock_info` WHERE
                orders_num like 'CG%' and locate('-',orders_num)>0 and 
                instock_into_qty != products_num and cancel_order=0 and products_id={$this->originMainProducts} and inventory_number>0");
        if(!$data-> EOF){
            $qty = $data->fields["total"] > 0 ?  $data->fields["total"] : 0;
        }
        return $qty;
    }
    public function getCnInstock($products_id)
    {
        $qty = 0;
        $extra_qty = 0;
        $is_customized = fs_get_data_from_db_fields('id', 'products_instock_customized_related',
            'products_id >0 and customized_id= ' . (int)$products_id, ' limit 1');
        $extra = [
            'instock_id' => 0,
            'qty' => 0
        ];
        if ($is_customized) {
            $current_qty = $this->setProducts($products_id, true)->setWarehouse(102)
                ->getThisInstockUsableQty(true);
            if (is_array($current_qty)) {
                foreach ($current_qty as $v) {
                    $qty += (int)$v;
                }
            } else {
                $qty = (int)$current_qty;
            }
            return [
                'current' => [
                    'instock_id' => is_array($this->productsInstockId) ? ($this->productsInstockId[0] ?
                        $this->productsInstockId[0] : 0) : ($this->productsInstockId ? $this->productsInstockId : 0),
                    'qty' => $qty > 0 ? $qty : 0
                ],
                'extra' => [
                    'instock_id' => 0,
                    'qty' => $extra_qty
                ]
            ];
        } else {
            $current_qty = $this->setProducts($products_id, true)
                ->setWarehouse([1])
                ->getThisInstockUsableQty(true);
            if (is_array($current_qty)) {
                foreach ($current_qty as $v) {
                    $qty += (int)$v;
                }
            } else {
                $qty = (int)$current_qty;
            }
            $current = [
                'instock_id' => is_array($this->productsInstockId) ? ($this->productsInstockId[0] ? $this->productsInstockId[0] : 0) :
                    ($this->productsInstockId ? $this->productsInstockId : 0),
                'qty' => $qty > 0 ? $qty : 0
            ];
            $customId = fs_get_data_from_db_fields('customized_id', 'products_instock_customized_related',
                'customized_id =' . (int)$this->mainProducts . ' or products_id= ' . (int)$this->mainProducts, ' limit 1');
            if ($customId) {
                $extra_data = $this->setProducts($customId, true, false)->setWarehouse(102)
                    ->getThisInstockUsableQty(true);
                if (is_array($extra_data)) {
                    foreach ($extra_data as $e) {
                        $extra_qty += (int)$e;
                    }
                }else{
                    $extra_qty += (int)$extra_data;
                }
                $instockId = is_array($this->productsInstockId) ? ($this->productsInstockId[0] ? $this->productsInstockId[0] : 0) :
                    ($this->productsInstockId ? $this->productsInstockId : 0);
                $extra = [
                    'instock_id' => $instockId,
                    'qty' => $extra_qty > 0 ? $extra_qty  : 0
                ];
            }
            return ['current' => $current, 'extra' => $extra];
        }
    }
}
