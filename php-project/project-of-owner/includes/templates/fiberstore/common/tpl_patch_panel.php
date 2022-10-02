<div class="cat-Ethernet-bottom">
    <ul class="cat-Ethernet-btmList after">
        <?php
            $img_url = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/cat/PerformanceTest.svg';
            $title = NEW_PATCH_PANEL_01;
            $des = NEW_PATCH_PANEL_02;
            $des4 = NEW_PATCH_PANEL_04;
            $des8 = NEW_PATCH_PANEL_08;
            if($current_category_id == 209){
                $img_url = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/cat/lc-images/lc_test.svg';
                $title = NEW_PATCH_PANEL_01_209;
                $des = NEW_PATCH_PANEL_02_209;
            }elseif($current_category_id == 4){
                $des = NEW_PATCH_PANEL_02_4;
                $des8 = NEW_PATCH_PANEL_08_4;
            }elseif($current_category_id == 1){
                $img_url = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/cat/Lots_of_Flex_bility.svg';
                $title = NEW_PATCH_PANEL_01_1;
                $des = NEW_PATCH_PANEL_02_1;
                $des4 = NEW_PATCH_PANEL_04_1;
                $des8 = NEW_PATCH_PANEL_08_4;
            }elseif(in_array($current_category_id,array(1308,911))){
                $img_url = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/cat/fast.svg';
                $title = NEW_PATCH_PANEL_01_911;
                $des = NEW_PATCH_PANEL_02_911;
                $des8 = NEW_PATCH_PANEL_08_4;
            }elseif($current_category_id == 9){
                $img_url = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/specials/cat/wide.svg';
                $title = NEW_PATCH_PANEL_01_9;
                $des = NEW_PATCH_PANEL_02_9;
                $des4 = NEW_PATCH_PANEL_04_9;
                $des8 = NEW_PATCH_PANEL_08_4;
            }
        ?>
        <?php if(!in_array($current_category_id,array(1308,911))){ ?>
            <li>
                <img src="<?php echo $img_url;?>" alt=""  height="48">
                <div class="cat-Ethernet-btmTxt">
                    <div><?php echo $title;?></div>
                    <p><?php echo $des;?></p>
                </div>
            </li>
        <?php }?>
        <li>
            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/cat/QualityAssurance.svg" alt="" width="44" height="48">
            <div class="cat-Ethernet-btmTxt">
                <div><?php echo NEW_PATCH_PANEL_03;?></div>
                <p><?php echo $des4;?></p>
            </div>
        </li>
        <li>
            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/cat/LargeStock.svg" alt="" width="46" height="48">
            <div class="cat-Ethernet-btmTxt">
                <div><?php echo NEW_PATCH_PANEL_05;?></div>
                <p><?php echo NEW_PATCH_PANEL_06;?>
                </p></div></li>
        <li>
            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/cat/Cost-Effective-Deal.svg" alt="" width="52" height="48">
            <div class="cat-Ethernet-btmTxt">
                <div><?php echo NEW_PATCH_PANEL_07;?></div>
                <p><?php echo $des8;?></p>
            </div>
        </li>
        <?php if(in_array($current_category_id,array(1308,911))){ ?>
            <li>
                <img src="<?php echo $img_url;?>" alt="" width="52" height="48">
                <div class="cat-Ethernet-btmTxt">
                    <div><?php echo $title;?></div>
                    <p><?php echo $des;?></p>
                </div>
            </li>
        <?php }?>
    </ul>
</div>