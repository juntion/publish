<?php if ($warehouse == 'us') {?>
    <div class="alone-page-banner">
        <div class="alone-page-banner-font">
            <h2>
                <?php echo PAYMENT_METHODS_BANNER_TITLE;?>
            </h2>
            <p>
                <?php echo PAYMENT_METHODS_BANNER_CONTENT;?>
            </p>
        </div>
    </div>

    <div class="alone-page-content">
        <div class="alone-page-content-main">
            <div class="alone-page-content-left">
                <ul class="<?php echo $isMobile ? 'alone-page-public-nav-m-ul' : 'alone-page-public-nav-pc-ul';?>">
                    <li>
                        <a class="active" href="javascript:;"><?php echo FS_PAYMENT_METHODS;?></a>
                        <div class="alone-page-content-left-m-line"></div>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('shipping_delivery.html');?>"><?php echo FS_FOOTER_DELIVERY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/day_return_policy.html');?>"><?php echo FS_RETURN_POLICY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/net_30.html');?>"><?php echo FS_HEADER_CUSTOMER_URL_04;?></a>
                    </li>
                    <?php if($_SESSION['countries_iso_code'] == 'us'){?>
                        <li>
                            <a href="<?php echo reset_url('service/sales_tax.html');?>"><?php echo FS_HEADER_SALES_TAX;?>
                            </a>
                        </li>
                    <?php }?>
                    <?php if(in_array($_SESSION['countries_iso_code'],['us','pr'])){?>
                        <li>
                            <a href="<?php echo zen_href_link('e_rate')?>"><?php echo FS_HEADER_CUSTOMER_URL_06;?></a>
                        </li>
                    <?php }?>
                </ul>
            </div>
            <div class="alone-page-content-right">
                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_PAYMENT_OPTIONS;?></h2>
                <div class="payment-options">
                    <ul>
                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon01.svg" width="20">
                                <span><?php echo PAYMENT_METHODS_PAYPAL;?></span>
                            </div>

                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_PAYPAL_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_PAYPAL_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon02.svg" height="24">
                                <span><?php echo PAYMENT_METHODS_CREDIT_CARD;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_CREDIT_CARD_CONTENT_01;?></p>
                            <?php if($_SESSION['countries_iso_code'] == 'pr'){?>
                                <p class="payThods-list-txt03">* <?php echo PAYMENT_CREDIT_TIP;?></p>
                            <?php }?>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/wire_transfer_grey.svg" width="40">
                                <span>
                                <?php
                                if (in_array($_SESSION['countries_iso_code'], array('us', 'pr'))) { echo PAYMENT_METHODS_WIRE_OR_ACH_TRANSFER;} else { echo PAYMENT_METHODS_WIRE_TRANSFER;}
                                ?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_WIRE_TRANSFER_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_WIRE_TRANSFER_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon04.svg" width="21">
                                <span><?php echo PAYMENT_METHODS_NET_TERM;?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01;?></p>

                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon05.svg" width="28">
                                <span> <?php if (in_array($_SESSION['countries_iso_code'], array('us'))){?>
                                        <span><?php echo PAYMENT_METHODS_ECHECK_OR_CHECK;?></span>
                                    <?php }else{?>
                                        <span><?php echo PAYMENT_METHODS_CHECK;?></span>
                                    <?php }?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php
                                if (in_array($_SESSION['countries_iso_code'], array('us'))) {
                                    echo PAYMENT_METHODS_ECHECK_CONTENT_01;
                                } else {
                                    echo PAYMENT_METHODS_CHECK_CONTENT_01;
                                }
                                ?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;">
                                    <?php echo PAYMENT_METHODS_CHECK_CONTENT_02;?>
                                </a>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon06.svg" width="20">
                                <span>   <?php echo PAYMENT_METHODS_ORDER_BY_PHONE;?></span>
                            </div>
                            <p class="payment-options-con-txt">    <?php echo PAYMENT_METHODS_ORDER_BY_PHONE_CONTENT_01;?></p>
                        </li>
                    </ul>
                </div>

                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_COMPARE_FEATURES;?></h2>
                <div class="compare-features">
                    <div class="compare-features-main">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_06; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_09; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_13; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_PAYPAL; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_PAYPAL; ?></td>
                            </tr>
                            <tr>
                                <td> <?php echo PAYMENT_METHODS_CREDIT_CARD; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD; ?></td>
                            </tr>
                            <tr>
                                <?php if (in_array($_SESSION['countries_iso_code'], array('us', 'pr'))) { ?>
                                    <td>
                                        <?php echo PAYMENT_METHODS_WIRE_OR_ACH_TRANSFER; ?>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <?php echo PAYMENT_METHODS_WIRE_TRANSFER; ?>
                                    </td>
                                <?php } ?>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_11; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_NET_TERM; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15; ?></td>
                            </tr>
                            <?php if (in_array($_SESSION['countries_iso_code'], array('us'))) { ?>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_ECHECK; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td> <?php echo PAYMENT_METHODS_TABLE_CONTENT_18; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14; ?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_CHECK; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_12; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_ORDER_BY_PHONE; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP; ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (in_array($_SESSION['countries_iso_code'], array('us', 'pr'))){?>
    <!-- 弹窗主站 -->
    <div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span id="transfer-txt" class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_WIRE_OR_ACH_TRANSFER;?></span>
                <span id="check-txt"><?php  if (in_array($_SESSION['countries_iso_code'], array('us'))) { echo PAYMENT_METHODS_PAY_WITH_ECHECK_OR_CHECK;}else{echo PAYMENT_METHODS_PAY_WITH_CHECK;}?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox" demData="transfer-txt">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_14;?></p>
                    <p class="payThods-popup-txt03"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_15;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_16;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_07;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_11;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="payThods-popup-txt03"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_17;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_16;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_18;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_19;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="payThods-txtBox choosez" demData="check-txt">
                    <p class="payThods-popup-txt"><?php if (in_array($_SESSION['countries_iso_code'], array('us'))) { echo PAYMENT_METHODS_PAY_WITH_CONTENT_20;}else{ echo PAYMENT_METHODS_PAY_WITH_CONTENT_12;}?></p>
                    <?php if (in_array($_SESSION['countries_iso_code'], array('us'))) {?>
                    <p class="payThods-popup-txt03"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_21;?></p>
                    <div>
                        <p style="color:#616265;"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_22;?></p>
                        <ul class="payThods-popup-txtList">
                            <li>
                                <i></i><div><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_23;?></div>
                            </li>
                            <li>
                                <i></i><div><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_24;?></div>
                            </li>
                            <li>
                                <i></i><div><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_25;?></div>
                            </li>
                        </ul>
                    </div>
                    <?php }?>
                    <p class="payThods-popup-txt03"><?php echo PAYMENT_METHODS_PAY_WITH_CHECK;?></p>
                    <div class="payThods-popup-txt04">
                       <?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_13;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>

    <?php if (in_array($_SESSION['countries_iso_code'], array('mx', 'ca'))){?>
        <!-- 弹窗美加墨 -->
        <div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
            <div class="payThods-alone-popupBg"></div>
            <div class="payThods-alone-680">
                <p class="payThods-alone-popupTit">
                    <span id="transfer-txt" class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_WIRE_TRANSFER;?></span>
                    <span id="check-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CHECK;?></span>
                    <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
                </p>
                <div class="payThods-popup-content">
                    <div class="payThods-txtBox choosez" demData="transfer-txt">
                        <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_01;?></p>

                        <table style="margin-top:15px;" width="100%" border="0" cellpadding="0" cellspacing="0" class="wire_info">
                            <tbody>

                            <tr>
                                <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_16;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></b></td>
                            </tr>

                            <tr>
                                <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_06;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_07;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_09;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_10;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_11;?></b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="payThods-txtBox" demData="check-txt">
                        <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_12;?></p>
                        <div class="payThods-popup-txt02">
                           <?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_13;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>

    <script type="text/javascript">
        // 弹窗展示和内容上的切换
        function payAlertCheck(dem) {
            $("#payThods-popup").show();
            $("#"+dem).addClass("choosez").siblings("span").removeClass("choosez");
            $(".payThods-txtBox[demData="+dem+"]").addClass("choosez").siblings(".payThods-txtBox").removeClass("choosez");
        }
    </script>
<?php } elseif ($_SESSION['languages_code'] == 'sg'){?>
    <div class="alone-page-banner">
        <div class="alone-page-banner-font">
            <h2><?php echo PAYMENT_METHODS_BANNER_TITLE; ?></h2>
            <p><?php echo PAYMENT_METHODS_BANNER_CONTENT; ?></p>
        </div>
    </div>

    <div class="alone-page-content">
        <div class="alone-page-content-main">
            <div class="alone-page-content-left">
                <ul class="<?php echo $isMobile ? 'alone-page-public-nav-m-ul' : 'alone-page-public-nav-pc-ul';?>">
                    <li>
                        <a class="active" href="javascript:;"><?php echo FS_PAYMENT_METHODS;?></a>
                        <div class="alone-page-content-left-m-line"></div>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('shipping_delivery.html');?>"><?php echo FS_FOOTER_DELIVERY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/day_return_policy.html');?>"><?php echo FS_RETURN_POLICY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/net_30.html');?>"><?php echo FS_HEADER_CUSTOMER_URL_04;?></a>
                    </li>
                </ul>
            </div>
            <div class="alone-page-content-right">
                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_PAYMENT_OPTIONS; ?></h2>
                <div class="payment-options">
                    <ul>
                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon01.svg"
                                     width="20">
                                <span><?php echo PAYMENT_METHODS_PAYPAL; ?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_PAYPAL_CONTENT_01; ?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_PAYPAL_CONTENT_02; ?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon02.svg"
                                     height="24">
                                <span><?php echo PAYMENT_METHODS_CREDIT_CARD; ?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_SG; ?></p>
                            <?php if ($_SESSION['countries_iso_code'] != 'sg') { ?>
                                <p class="payThods-list-txt03">* <?php echo PAYMENT_CREDIT_TIP; ?></p>
                            <?php } ?>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon03.svg"
                                     width="24">
                                <span><?php echo PAYMENT_METHODS_BANK_TRANSFER; ?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_BANK_TRANSFER_CONTENT_01_SG; ?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup02').show();">
                                    <span><?php echo PAYMENT_METHODS_ACCOUNT_NUMBERS_AND_INSTRUCTIONS; ?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon04.svg"
                                     width="21">
                                <span><?php echo PAYMENT_METHODS_NET_TERM; ?></span>
                            </div>
                            <p class="payment-options-con-txt">   <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01; ?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_02; ?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/checkout-eNETS-grey.svg"
                                     width="50">
                                <span><?php echo PAYMENT_METHODS_ENETS; ?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_ENETS_CONTENT_01; ?></p>
                        </li>


                        <li class="payment-options-con" <?php echo ($_SESSION['countries_iso_code'] !='sg' ? 'style="visibility:hidden;"' : '')?>>
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon05.svg"
                                     width="28">
                                <span><?php echo PAYMENT_METHODS_CHECK; ?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_CHECK_CONTENT_01; ?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup01').show();">
                                    <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS; ?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_COMPARE_FEATURES; ?></h2>
                <div class="compare-features">
                    <div class="compare-features-main">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_06; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_09; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_13; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_PAYPAL; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_PAYPAL; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_BANK_TRANSFER; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_16; ?></td>
                                <td><?php echo PAYMENT_METHODS_BANK_OF_SINGAPORE; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_NET_TERM; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_ENETS; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10; ?></td>
                                <td><?php echo PAYMENT_METHODS_ENETS; ?></td>
                            </tr>
                            <?php if ($_SESSION['countries_iso_code'] == 'sg') { ?>
                            <tr>
                                <td> <?php echo PAYMENT_METHODS_CHECK; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_17; ?></td>
                                <td> <?php echo PAYMENT_METHODS_BANK_OF_SINGAPORE; ?></td>
                            </tr>
                            <?php }?>

                            </tbody>
                        </table>
                    </div>

                    <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- check 弹框 -->
    <div class="payThods-alone-popup" id="payThods-popup01" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_CHECK;?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup01').hide()">&#xf092;</em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox choosez">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_19_SG;?></p>
                    <div class="payThods-checkAddress-box">
                        <?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_20_SG;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Transfer弹窗 -->
    <?php if (strtoupper($_SESSION['currency']) == 'USD') {?>
    <div class="payThods-alone-popup" id="payThods-popup02" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER;?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup02').hide()">&#xf092;</em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox choosez">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_01_SG;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sgBank-popup-ta">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02_SG;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_14_SG;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_15_SG;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_16_SG;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_17_SG;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_18_SG;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php }else {?>
    <div class="payThods-alone-popup" id="payThods-popup02" style="display: none;">
            <div class="payThods-alone-popupBg"></div>
            <div class="payThods-alone-680">
                <p class="payThods-alone-popupTit">
                    <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER;?></span>
                    <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup02').hide()">&#xf092;</em>
                </p>
                <div class="payThods-popup-content">
                    <div class="payThods-txtBox choosez">
                        <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_01_SG;?> </p>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sgBank-popup-ta">
                            <tbody>
                            <tr>
                                <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?> </th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03_SG;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08;?> </th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_06_SG;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_07_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08_SG;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_09_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_10_SG;?></th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_11_SG;?></b></td>
                            </tr>
                            <tr>
                                <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_12_SG;?> </th>
                                <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_13_SG;?></b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>


    <script type="text/javascript">
        // 弹窗展示和内容上的切换
        function payAlertCheck(dem) {
            $("#payThods-popup").show();
            $("#"+dem).addClass("choosez").siblings("span").removeClass("choosez");
            $(".payThods-txtBox[demData="+dem+"]").addClass("choosez").siblings(".payThods-txtBox").removeClass("choosez");
        }
    </script>
<?php } elseif ($_SESSION['countries_iso_code'] == 'ru') {?>
    <div class="alone-page-banner">
        <div class="alone-page-banner-font">
            <h2><?php echo PAYMENT_METHODS_BANNER_TITLE;?></h2>
            <p><?php echo PAYMENT_METHODS_BANNER_CONTENT;?></p>
        </div>
    </div>

    <div class="alone-page-content">
        <div class="alone-page-content-main">
            <div class="alone-page-content-left">
                <ul class="<?php echo $isMobile ? 'alone-page-public-nav-m-ul' : 'alone-page-public-nav-pc-ul';?>">
                    <li>
                        <a class="active" href="javascript:;"><?php echo FS_PAYMENT_METHODS;?></a>
                        <div class="alone-page-content-left-m-line"></div>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('shipping_delivery.html');?>"><?php echo FS_FOOTER_DELIVERY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/day_return_policy.html');?>"><?php echo FS_RETURN_POLICY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/net_30.html');?>"><?php echo FS_HEADER_CUSTOMER_URL_04;?></a>
                    </li>
                </ul>
            </div>
            <div class="alone-page-content-right">
                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_PAYMENT_OPTIONS;?></h2>
                <div class="payment-options">
                    <ul>
                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/checkout_cashless_grey.svg" width="34">
                                <span><?php echo PAYMENT_METHODS_CASHLESS_PAYMENT;?></span>
                            </div>
                            <p class="payment-options-con-txt">
                                <?php echo PAYMENT_METHODS_CASHLESS_PAYMENT_CONTENT_01;?>
                            </p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup').show();">
                                    <span><?php echo PAYMENT_METHODS_ACCOUNT_NUMBERS_AND_INSTRUCTIONS;?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon01.svg" width="20">
                                <span><?php echo PAYMENT_METHODS_PAYPAL;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_PAYPAL_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_PAYPAL_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon02.svg" height="24">
                                <span><?php echo PAYMENT_METHODS_CREDIT_CARD;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_01;?></p>
                            <p class="payThods-list-txt03">* <?php echo PAYMENT_CREDIT_TIP;?></p>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/bank_transfer_grey.svg" width="40">
                                <span><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_BANK_TRANSFER_CONTENT_01_SG;?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup02').show();">
                                    <span><?php echo PAYMENT_METHODS_ACCOUNT_NUMBERS_AND_INSTRUCTIONS;?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon04.svg" width="21">
                                <span><?php echo PAYMENT_METHODS_NET_TERM;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <a href="<?php echo reset_url('/policies/net_30.html');?>">
                                    <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_APPLY;?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_COMPARE_FEATURES;?></h2>
                <div class="compare-features">
                    <div class="compare-features-main">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_06; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_09; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_13; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_CASHLESS_PAYMENT;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_12_CN;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_20;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_12_CN;?></td>
                                <td><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_13_CN;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_NET_TERM;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15;?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP;?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ru-Cashless Payment弹框 -->
    <div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT;?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox choosez">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_01;?></p>
                    <p class="payThods-popup-txt06"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_02;?></p>
                    <p class="payThods-popup-txt06"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_03;?></p>
                    <p class="payThods-popup-txt07"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_RU;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cashless-popup-ta">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_04;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_16;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_17;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_16;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_06 . '/' . PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_07 . '/' . PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_11;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_13;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_14;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CASHLESS_PAYMENT_CONTENT_15;?></b></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="payThods-alone-popup" id="payThods-popup02" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER;?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup02').hide()"></em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox choosez">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_01_CN;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sgBank-popup-ta">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_06_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_07_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_09_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_10_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_11_CN;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // 弹窗展示和内容上的切换
        function payAlertCheck(dem) {
            $("#payThods-popup").show();
            $("#"+dem).addClass("choosez").siblings("span").removeClass("choosez");
            $(".payThods-txtBox[demData="+dem+"]").addClass("choosez").siblings(".payThods-txtBox").removeClass("choosez");
        }
    </script>
<?php } elseif ($warehouse == 'cn') {?>
    <div class="alone-page-banner">
        <div class="alone-page-banner-font">
            <h2>
                <?php echo PAYMENT_METHODS_BANNER_TITLE;?>
            </h2>
            <p>
                <?php echo PAYMENT_METHODS_BANNER_CONTENT;?>
            </p>
        </div>
    </div>

    <div class="alone-page-content">
        <div class="alone-page-content-main">
            <div class="alone-page-content-left">
                <ul class="<?php echo $isMobile ? 'alone-page-public-nav-m-ul' : 'alone-page-public-nav-pc-ul';?>">
                    <li>
                        <a class="active" href="javascript:;"><?php echo FS_PAYMENT_METHODS;?></a>
                        <div class="alone-page-content-left-m-line"></div>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('shipping_delivery.html');?>"><?php echo FS_FOOTER_DELIVERY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/day_return_policy.html');?>"><?php echo FS_RETURN_POLICY;?></a>
                    </li>
                    <li>
                        <a href="<?php echo reset_url('policies/net_30.html');?>"><?php echo FS_HEADER_CUSTOMER_URL_04;?></a>
                    </li>
                </ul>
            </div>
            <div class="alone-page-content-right">
                <h2 class="alone-page-content-right-tit">  <?php echo PAYMENT_METHODS_PAYMENT_OPTIONS;?></h2>
                <div class="payment-options">
                    <ul>
                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon01.svg" width="20">
                                <span><?php echo PAYMENT_METHODS_PAYPAL;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_PAYPAL_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_PAYPAL_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon02.svg" height="24">
                                <span><?php echo PAYMENT_METHODS_CREDIT_CARD;?></span>
                            </div>
                            <p class="payment-options-con-txt">  <?php echo PAYMENT_METHODS_CREDIT_CARD_CONTENT_01_CN;?></p>
                            <p class="payThods-list-txt03">* <?php echo PAYMENT_CREDIT_TIP;?></p>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/bank_transfer_grey.svg" width="55">
                                <span><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_BANK_TRANSFER_CONTENT_01_SG;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_WIRE_TRANSFER_CONTENT_02;?>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon04.svg" width="21">
                                <span><?php echo PAYMENT_METHODS_NET_TERM;?></span>
                            </div>
                            <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_02;?>
                            </div>
                        </li>

                    </ul>
                </div>

                <h2 class="alone-page-content-right-tit"><?php echo PAYMENT_METHODS_COMPARE_FEATURES;?></h2>
                <div class="compare-features">
                    <div class="compare-features-main">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_06; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_09; ?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_13; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_13_CN;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                                <td><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_12_CN;?></td>
                                <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                            </tr>
                            <tr>
                                <td><?php echo PAYMENT_METHODS_NET_TERM;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                                <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15;?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP;?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bank Transfer弹窗 -->
    <div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
        <div class="payThods-alone-popupBg"></div>
        <div class="payThods-alone-680">
            <p class="payThods-alone-popupTit">
                <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER;?></span>
                <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
            </p>
            <div class="payThods-popup-content">
                <div class="payThods-txtBox choosez">
                    <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_01_CN;?></p>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sgBank-popup-ta">
                        <tbody>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_02_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_03_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_04_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_05_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_06_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_07_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_08_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_09_CN;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_10_CN;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_CONTENT_11_CN;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // 弹窗展示和内容上的切换
        function payAlertCheck(dem) {
            $("#payThods-popup").show();
            $("#"+dem).addClass("choosez").siblings("span").removeClass("choosez");
            $(".payThods-txtBox[demData="+dem+"]").addClass("choosez").siblings(".payThods-txtBox").removeClass("choosez");
        }
    </script>
<?php }?>


