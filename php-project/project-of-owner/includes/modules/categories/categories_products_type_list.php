<?php
require($language_page_directory.'views/product_list.php'); // 调用产品列表页语言包，以后产品列表会公共这个语言包
use App\Services\Products\ProductInventoryService;

$config['main_page'] = "index";
//$shipping_info = new ShippingInfo($config);
$cPath_arr = explode('_', $_GET['cPath']);
$cPath_num = sizeof($cPath_arr);
$products_list_info = '';
$products_list_info_grid = '';

if (is_array($products)) {
    require_once DIR_WS_CLASSES . 'shipping_info.php';

    $waterfall_key = isset($_GET['page']) ? ((int)$_GET['page'] - 1) * 24 : 0;
    $final_waterfall_key = $waterfall_key + 24;

    //库存查询新方法 Bona.Guo 2021/2/26 11:57
    $products_id_data=array_column($products, 'products_id');
    if ($products) {
        $ProductsModel = new ProductInventoryService();
        $now_warehouse_code = strtoupper(get_warehouse_by_code($_SESSION['countries_iso_code']));
        $now_warehouse=[
            'DE' => 20, //德国仓
            'SG' => 71, //新加坡仓
            'US' => 40, //美东仓
            'AU' => 37,//澳大利亚仓
            'CN' => 1, // 中国华南仓
            'RU' => 67, // 俄罗斯仓
        ];
        $currentQty_date = $ProductsModel->setProducts($products_id_data,$now_warehouse)->calculateInventory(0);
        //var_dump($currentQty_date);
    }

    foreach ($products as $product_key => $product) {



        $waterfall_key += 1;
        //$waterfall_data 该数据源在default_filter.php文件中
//        if(isset($waterfall_data[$waterfall_key]) && !$is_list_narrow){
//            $products_list_info_grid .= getListWaterfallGridDom($waterfall_data[$waterfall_key]);
////            $waterfall_key += 1;
//        }

        if(!empty($waterfall_data) && !$is_list_narrow){
            foreach ($waterfall_data as $w_k => $w_val){
                if($w_k == $waterfall_key){
                    $products_list_info_grid .= getListWaterfallGridDom($w_val);
                    $waterfall_key += 1;
                }
            }
        }


        if (isset($_GET['_requestConfirmationToken']) || $cPath_num > 3) {
            $images_status = 1;
        } else {
            $images_status = fs_get_data_from_db_fields('is_hidden_images', 'products', 'products_id=' . $product['id'], '');
        }
        //根据产品ID查询出产品状态,然后去掉状态为隐藏的产品
        if ($images_status == 1) {
            if(count($cPath_array)==4){
                //四级分类,不展示属性管理。因为四级分类，显示隐藏id。如果展示，看起来会出现大量重复
                $is_show_attributes = false;
            }else{
                $is_show_attributes = true;
            }

            $productQty=$currentQty_date[$product['products_id']];

            $products_all_info = get_product_list_show_str($product,'all',false,$is_show_attributes,false,true,'list',$productQty);
            //var_dump($products_all_info);die;
            $products_list_info .= $products_all_info['list'];
            $products_list_info_grid .= $products_all_info['image'];
        }
    }

    if($final_waterfall_key != $waterfall_key && !$is_list_narrow){
        for ($i = $waterfall_key; $i <= $final_waterfall_key; $i++) {
            if(isset($waterfall_data[$i])){
                $products_list_info_grid .= getListWaterfallGridDom($waterfall_data[$i]);
            }
        }
    }
}
?>