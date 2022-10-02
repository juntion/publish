<?php
// 获取不同状态的小红点个数
$coNum = zen_get_order_num_by_status(4);
$progress_num = zen_get_order_num_by_status(array(1,4,5),false);
$peNum = zen_get_order_num_by_status(1);
$serNumRes = $db->Execute("select count(customers_service_id) as total from customers_service where mark=0 and customers_id=".$_SESSION['customer_id']." and service_status in (1,9)");
$serNum  = $serNumRes->fields['total'];
//退换货和订单共用导航 ?>
<ul class="orders_tab_ul">
    <li <?php echo (!$order_status || $order_status=='all') ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'','SSL');?>">
            <span><?php echo FS_ORDER_ALL;?></span>
        </a>
    </li>
    <li <?php echo ('pending' == $order_status) ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=pending','SSL');?>">
            <span><?php echo FS_ORDER_PENDING;?></span>
            <?php if($peNum){echo '<i class="new_i_num">'.$peNum.'</i>';}?>
        </a>
    </li>
    <li <?php echo ('progressing' == $order_status) ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=progressing','SSL');?>">
            <span><?php echo FS_ORDER_PROGRESSING;?></span>
            <?php if($progress_num){echo '<i class="new_i_num">'.$progress_num.'</i>';}?>
        </a>
    </li>
    <li <?php echo ('completed' == $order_status) ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=completed','SSL');?>">
            <span><?php echo FS_ORDER_COMPLETED;?></span>
            <?php if($coNum){echo '<i class="new_i_num">'.$coNum.'</i>';}?>
        </a>
    </li>
    <li <?php echo ('canceled' == $order_status) ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=canceled','SSL');?>">
            <span><?php echo FS_ORDER_CANCELLED;?></span>
        </a>
    </li>
    <?php if ( $common_pro_info['is_po_account']) {  // po账号 ?>
        <li <?php echo ('purchase' == $order_status) ? 'class="active"' : ''; ?>>
            <a href="<?php echo zen_href_link(FILENAME_MANAGE_ORDERS,'&order_status=purchase','SSL');?>">
                <span><?php echo FS_ORDER_PURCHASE;?></span>
            </a>
        </li>
    <?php } ?>
    <li <?php echo ($_GET['main_page'] == 'sales_service_list') ? 'class="active"' : ''; ?>>
        <a href="<?php echo zen_href_link('sales_service_list','','SSL');?>">
            <span><?php echo FS_ORDER_RETURN_ITEM;?></span>
            <?php if($serNum){echo '<i class="new_i_num">'.$serNum.'</i>';}?>
        </a>
    </li>
</ul>