<?php

/* 客户 订单产品是否需要销售录单
manage_customer_company 是以组为单位，代表该组下的所有客户
link_id 相同的为同一组客户，线上客户与线下客户有可能属于同一组
*/
function fs_customer_order_product_is_instock($customer, $online = false, $customerNumberNew = '')
{
    global $db;
    $type = $autoOrder = 0;
    $companyNumber = '';
    if ($customer || $customerNumberNew) {
        //通过客户ID 或 客户编号 得到该客户的公司编号
        if ($customerNumberNew) {
            $companyNumber = fs_get_data_from_db_fields('company_number', 'manage_customer_company_to_customers', "`customers_number_new` = '{$customerNumberNew}'");
        } else {
            $table = $online ? 'customers' : 'customers_offline';
            $sql = "SELECT mcctc.`company_number`,c.`customers_number_new` FROM `manage_customer_company_to_customers` mcctc 
            RIGHT JOIN `{$table}` c ON c.`customers_number_new` = mcctc.`customers_number_new`
            WHERE c.`customers_id` = '{$customer}'";
            $result = $db->Execute($sql);
            $companyNumber = $result->fields['company_number'];
            $customerNumberNew = $result->fields['customers_number_new'];
        }

        if ($companyNumber) {
            $autoOrder = fs_get_data_from_db_fields('auto_order', 'manage_customer_company', "`company_number` = '{$companyNumber}'", 'limit 1');
        }

        if ($autoOrder == 1) {  //所有产品需要销售录单
            $type = 1;
        } else {

            if ($companyNumber && $autoOrder > 0) {
                $categories = fs_get_data_from_db_fields_array(array('categories_id'), 'manage_customer_to_categories', "`company_number` = '{$companyNumber}'", '');

                if (sizeof($categories)) {
                    foreach ($categories as $c) {
                        $arr['cid'][] = $c[0];
                    }
                }
            }

            if ($customerNumberNew) {
                $product_id = $db->Execute("select product_id from company_special_tag_for_product where customers_number_new = '" . $customerNumberNew . "'")->fields['product_id'];
                if ($product_id) {
                    $arr['pid'] = explode(';', $product_id);
                }
            }

            if ($arr) {
                $type = $arr;
            }
        }


    }

    return $type;
}

function fs_customer_order_product_auto_instock($pid, $CategoryArray)
{
    if (isset($CategoryArray['pid']) && !empty($CategoryArray['pid'])) {//如果标记的指定产品id
        if (in_array($pid, $CategoryArray['pid'])) {
            return 0;
        }
    }

    $categories = array();
    $categoriesID = fs_get_data_from_db_fields('categories_id', 'products_to_categories', 'products_id=' . (int)$pid, 'order by sort_order limit 1');
    zen_get_parent_categories($categories, $categoriesID);
    $categories [] = $categoriesID;
    $is_confirm = array_intersect($categories, $CategoryArray['cid']); //分类交集，有 则表示该产品需要销售确认
    if ($is_confirm) {
        $update_status = 0;
    } else {
        $update_status = 1;
    }
    return $update_status;
}

?>