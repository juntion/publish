<div class="location_text_pro">
        <div class="location_text">
            <?php echo $shipping_info->get_warehouse_location();?>
        </div>
    <div class="product_03_01 product_03_13 detail_seattle_z" id="fs_availabilty">

        <div class="warehouse_text warehouse_details_text">
            <?php echo '<i class="iconfont warehouse_details_baoguoIc">&#xf429;</i>'.$shipping_info->getStockShipping($pure_price); ?>
        </div>
        <div class="shipping_text">
            <?php echo $shipping_info->getShippingDayInfo($pure_price); ?>
        </div>

<!--Dylan 2019.9.18-->
<!--        --><?php //if(in_array(strtoupper($_SESSION['countries_iso_code']),array('MY','ID','PH'))){ ?>
<!--        <div class="shipping_text">-->
<!--            --><?php //echo FS_CLEARANCE_TIP;?>
<!--            <div class="track_orders_wenhao">-->
<!--                <div class="question_bg_icon iconfont icon">&#xf228;</div>-->
<!--                <div class="question_text_01 leftjt">-->
<!--                    <div class="arrow"></div>-->
<!--                    <div class="popover-content">--><?php //echo FS_CLEARANCE_TIP_ARROW;?><!--</a></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //}?>
    </div> 
</div>
