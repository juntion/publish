<?php

namespace classes;
class codeRelatedProducts
{
    public static $products_id;     // 产品ID
    public static $related_id = 0;      // 关联可改码ID
    public static $db;
    public static $products_num = 0;   // 产品数量
    public static $warehouse;      //  对应仓库
    public static $instock_id = 0;  //  库存ID
    protected static $isCodeRelated;  // 是否是改码关联
    public static $isChangeCode = false;    //  是否是调用可改码产品出库
    public static $isUnderstock = false;    //  可改码产品库存不足
    public $allRelated;
    public $isCustom = false;
    public static $currentQty = 0;
    public static $stockWarehouse;
    protected static $semiFinished = [40 => 98,20 =>104];  // key 成品仓  value 半成品仓 （同地区）
    protected static $cacheType = "";
    function __construct($products_id, $products_num = 0, $warehouse = 3)
    {
        global $db;
        self::$db = $db;
        self::$products_num = $products_num;
        self::$warehouse = $warehouse;
        self::$stockWarehouse = $warehouse;
        $products_id = zen_get_products_related_model($products_id);
        self::$products_id = $products_id;
        self::$currentQty = 0;
        self::$related_id = 0;
        self::$cacheType = sqlCacheType();
        $cacheType = self::$cacheType;
        $res = self::$db->Execute("select {$cacheType} customized_id from products_instock_code_related where products_id = " . $products_id . ' order by sort asc');
        if ($res->RecordCount() > 0) {
            while (!$res->EOF) {
                $customID[] = $res->fields['customized_id'];
                $res->MoveNext();
            }
        }
        if (sizeof($customID)) {
            self::$related_id = $customID[0];
            self::$isCodeRelated = true;
            $this->allRelated = $customID;
        } else {
            self::$isCodeRelated = false;
            $result = self::$db->Execute("select {$cacheType} products_id from products_instock_code_related where customized_id = " . $products_id . ' limit 1');
            if ($result->fields['products_id']) {
                $this->isCustom = true;
            }
        }
    }

    public function getIsCodeRelated()
    {
        return self::$isCodeRelated;
    }

    /**
     * 验证该仓库的库存是否足够发货
     *
     * @param $isStore int
     * @return bool
     */
    public static function verifyProductsInstock($isStore = true)
    {
        $bool = false;
        self::$isChangeCode = false;
        $cacheType = self::$cacheType;
        if (self::$isCodeRelated) {
            $customID = self::$db->Execute("select {$cacheType} customized_id from products_instock_customized_related where products_id = " . self::$products_id . ' or customized_id = ' . self::$products_id . ' limit 1')->fields['customized_id'];
            if ($customID == self::$products_id) {
                $isCustom = true;
            }
            // ID是定制ID  但仓库不是半成品仓 自动切换为半成品   但是改码ID的仓库还是成品仓 因此不改warehouse属性
            if($isCustom && !in_array(self::$warehouse, self::$semiFinished) && self::$semiFinished[self::$warehouse]) {
                $thisMainIdInstockInfo = self::getProductsEnabledNum($customID, self::$semiFinished[self::$warehouse], $isStore, true);
            } else {
                $thisMainIdInstockInfo = self::getProductsEnabledNum(self::$products_id, self::$warehouse, $isStore, true);
            }
            if (!$isCustom && $customID && array_key_exists(self::$warehouse, self::$semiFinished)) {
                $semiFinishedStock = self::getProductsEnabledNum($customID, self::$semiFinished[self::$warehouse], $isStore, true);
            }
            if ($thisMainIdInstockInfo['instock_qty'] >= self::$products_num) {   //  本身主ID产品库存充足时   选择本身主ID出库
                $bool = true;
                self::$instock_id = $thisMainIdInstockInfo['instock_id'];
                self::$currentQty = $thisMainIdInstockInfo['instock_qty'];
                self::$stockWarehouse = $thisMainIdInstockInfo['warehouse'];
            } elseif (isset($semiFinishedStock) && $semiFinishedStock['instock_qty'] >= self::$products_num) { // 关联半成品ID库存
                $bool = true;
                self::$instock_id = $semiFinishedStock['instock_id'];
                self::$currentQty = $semiFinishedStock['instock_qty'];
                self::$stockWarehouse = $semiFinishedStock['warehouse'];
            } else {
                $products_id = self::$products_id;
                $res = self::$db->Execute("select {$cacheType} customized_id from products_instock_code_related where products_id = " . $products_id . ' order by sort asc');
                if ($res->RecordCount() > 0) {
                    while (!$res->EOF) {
                        $customIDs[] = $res->fields['customized_id'];
                        $res->MoveNext();
                    }
                }
                foreach ($customIDs as $id)     {
                    // 改码关联，是存在于，库存主IDA和库存主IDB之前的关联 (已咨询产品组同事)
                    $codeRelatedInstockInfo = self::getProductsEnabledNum($id, self::$warehouse, $isStore, true);
                    if ($codeRelatedInstockInfo['instock_qty'] >= self::$products_num) {
                        $bool = true;
                        self::$isChangeCode = true;
                        self::$instock_id = $codeRelatedInstockInfo['instock_id'];
                        self::$related_id = $id;
                        self::$isUnderstock = false;
                        self::$currentQty = $codeRelatedInstockInfo['instock_qty'];
                        break;
                    }
                    if ($codeRelatedInstockInfo['instock_qty'] > 0 && self::$warehouse == 3 && self::$isUnderstock == false) {
                        //  只有西雅图  改码库存大于0 即使不满足订单数量也可以发货
                        $bool = true;
                        self::$isChangeCode = true;
                        self::$instock_id = $codeRelatedInstockInfo['instock_id'];
                        self::$related_id = $id;
                        self::$currentQty = $codeRelatedInstockInfo['instock_qty'];
                        if ($codeRelatedInstockInfo['instock_qty'] < self::$products_num) {
                            self::$isUnderstock = true;
                        }
                    }
                }
            }
        }
        return $bool;
    }

    /**
     * 获取指定产品指定仓库  前台下单是可以使用库存   用于判断国内外发货
     *
     * @param $id  int|array  传入数组的话  返回所有ID库存总和
     * @param $warehouse
     * @param $isStore bool 区分前后台
     * @param $isMainID  boolean 传入ID是否是主ID
     * @return array
     */
    public static function getProductsEnabledNum($id, $warehouse, $isStore = true, $isMainID = false)
    {
        $enabledQty = $mainInstockId = 0;
        $result = [];
        $cacheType = self::$cacheType;
        if (is_array($id)) {
            $res = self::$db->Execute("select {$cacheType} instock_qty,products_instock_id from products_instock where products_id in (" . implode(',', $id) . ') and warehouse = ' . (int)$warehouse);
            $allInstock = [];
            $sum = $tempLockCount = $orderLockCount = 0;
            while (!$res->EOF) {
                $allInstock[] = $res->fields['products_instock_id'];
                if($res->fields['products_instock_id'] && $res->fields['instock_qty'] > 0){
                    $tempLockCount = self::$db->Execute("SELECT sum(change_qty)as total FROM products_instock_history_temp WHERE products_instock_id = ".$res->fields['products_instock_id']." and type=0 ")->fields['total'];
                    $orderLockCount = fs_get_data_from_db_fields('sum(qty)', 'products_instock_orders', 'instock_id=' . $res->fields['products_instock_id'], '');
                    $sum += ($res->fields['instock_qty'] - $tempLockCount - $orderLockCount > 0 ? $res->fields['instock_qty'] - $tempLockCount - $orderLockCount : 0);
                }
                $res->MoveNext();
            }
            $enabledQty = $sum > 0 ? $sum : 0;
            $result = array('instock_qty' => $enabledQty, 'instock_id' => 0);
        } elseif ($id) {
            if ($isMainID){
                $main_id = $id;
            } else {
                $main_id = zen_get_products_related_model((int)$id);
            }
            $res = self::$db->Execute("select {$cacheType} instock_qty,products_instock_id from products_instock where products_id = " . (int)$main_id . ' and warehouse = ' . (int)$warehouse . ' limit 1')->fields;
            if (sizeof($res)) {
                $main_id_instock_qty = $res['instock_qty'];
                $mainInstockId = $res['products_instock_id'];
            }
            if ($main_id_instock_qty > 0) {
                //前台订单临时锁定库存
                $lock_front = fs_get_data_from_db_fields('sum(qty)', 'products_instock_orders', 'instock_id=' . $mainInstockId, '');
                //  后台录单锁定库存
                $instock = self::$db->Execute("SELECT sum(change_qty)as total FROM products_instock_history_temp WHERE products_instock_id =" . (int)$mainInstockId . " and type=0 ");
                if (!$isStore) $lock_front = 0;
                $lockTotal = (int)$instock->fields['total'] + (int)$lock_front;
                $enabledQty = $main_id_instock_qty - $lockTotal;
                $enabledQty = $enabledQty < 0 ? 0 : $enabledQty;
            }
            $result = array('instock_qty' => $enabledQty, 'instock_id' => $mainInstockId, 'warehouse' => $warehouse);
        }
        return $result;
    }

    public static function getThisIstockID()
    {
        return self::$instock_id;
    }

    public function getCodeRelatedTotalInstockQty($warehouse, $containCustom = true, $isStore = true)
    {
        $productsID = self::$products_id;
        $total = 0;
        $allID = [];
        $cacheType = self::$cacheType;
        if (self::$isCodeRelated) {
            $customID = fs_get_data_from_db_fields('customized_id', 'products_instock_customized_related',
                'products_id = ' . $productsID, '');
            if ($customID && $containCustom) {
                $customRes = self::$db->getAll("select {$cacheType} products_id from products_instock_customized_related 
                    where customized_id = " . $customID . ' and products_id <> ' . $productsID);
                if(!empty($customRes)){
                    foreach ($customRes as $v){
                        $customResArr[] = (int)$v['products_id'];
                    }
                    $customResArr[] = $customID;
                    if(!empty($customResArr)){
                        $customResArr = implode(',',$customResArr);
                        if($customResArr && is_string($customResArr)){
                            $customResArr = "(".$customResArr.")";
                            $data = self::$db->getAll("select {$cacheType} products_id from products_instock_code_related where products_id in "
                                . $customResArr  . ' or customized_id in ' . $customResArr);
                            if(!empty($data)){
                                foreach($data as $v) {
                                    $allID[] = $v['products_id'];
                                }
                                $allID = array_unique($allID);
                            }
                        }
                    }
                }
            }
            if (self::$isCodeRelated && is_array($this->allRelated)) {
                foreach ($this->allRelated as $id) {
                    if (!in_array($id, $allID)) {
                        $allID[] = $id;
                    }
                }
            }
            if(!empty($allID)){
                foreach ($allID as $k => $v){
                    if($v == $productsID){
                        unset($allID[$k]);
                    }
                }
            }
            if (sizeof($allID)) {
                $instockInfo = self::getProductsEnabledNum($allID, $warehouse, $isStore); // 传入数组一次性查出来
                $total = $instockInfo['instock_qty'];
            }
        }
        return $total;
    }
    /**
     * 西雅图改码库存不足提醒客户邮件      客户邮件谨慎调用
     *
     * @param $orders_id
     */
    public static function sendEmailToCustomer($orders_id)
    {
        if ($orders_id) {
            $res = self::$db->Execute('select orders_number,customers_name,customers_email_address,customers_id from orders where orders_id = '.(int)$orders_id)->fields;
            if (sizeof($res)) {
                $orders_num = $res['orders_number'];
                $customerName = $res['customers_name'];
                $customerEmail = $res['customers_email_address'];
                $customers_id = $res['customers_id'];
            }
            if (empty($customerEmail) && $customers_id) {
                $customerEmail = fs_get_data_from_db_fields('customers_email_address', 'customers', 'customers_id=' . $customers_id, '');
            }
            $object = 'Products for Your Order#' . $orders_num . ' are in Transfer -- FS.COM';
            $html = zen_get_corresponding_languages_email_common('admin');
            $html_msg['EMAIL_HEADER'] = $html['html_header'];
            $html_msg['EMAIL_FOOTER'] = $html['html_footer'];
            $html_content = '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#333333; line-height:18px; border:0;">
        <tbody>
          <tr>
            <td bgcolor="#ffffff" colspan="2" style=" padding:10px 30px 0 30px; font-size:11px;">
              <b style=" display:block; padding-top:10px;">Dear ' . $customerName . ',</b>
              </td>
          </tr>
          <tr>
            <td  colspan="2" bgcolor="#ffffff" style=" padding:0 30px; font-size:11px;">
              <br>
              We are happy to update that your order ' . $orders_num . ' is now in processing.
             </td>
          </tr>
          <tr>
            <td  colspan="2" bgcolor="#ffffff" style=" padding:0 30px; font-size:11px;">
              <br>
              Please allow 48 hours for the transferring of our stocks, to our local shipping warehouse. Due to high demand, our local warehouse is temporally out of stock but we are working hard to ensure a secure and timely delivery.
             </td>
          </tr>
          <tr>
            <td  colspan="2" bgcolor="#ffffff" style=" padding:0 30px; font-size:11px;">
              <br>
              We will arrange the shipment once we receive the transferred items. Sincerely sorry for this inconvenience this may cause.
             </td>
          </tr>
          <tr>
              <td colspan="2" style=" padding:0 30px 20px 30px; font-size:11px;">
            <br>
            Thanks for your patience in advance.<br><br>FS.COM </td>

          </tr>

          </tbody></table>';
            $html_msg['EMAIL_BODY'] = $html_content;
            if ($customerEmail) {
                zen_mail($customerName, $customerEmail, $object, '', 'FS.COM', 'noreply@fs.com', $html_msg, 'default');
            }
        }
    }

}
