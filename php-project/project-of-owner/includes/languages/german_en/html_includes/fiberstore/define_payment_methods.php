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
                        <p class="payment-options-con-txt"><?php echo PAYMENT_METHODS_CREDIT_CARD_CONTENT_01;?></p>
                        <?php if(in_array($_SESSION['countries_iso_code'],['dk','no'])){?>
                            <p class="payThods-list-txt03">* <?php echo PAYMENT_CREDIT_TIP;?></p>
                        <?php }?>
                    </li>

                    <li class="payment-options-con">
                        <div class="payment-options-con-tit">
                            <?php if ($_SESSION['countries_iso_code'] == 'de') {?>
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/vorkasse-grey.svg" width="66">
                            <?php }else{?>
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payThods-icon03.svg" width="24">
                            <?php }?>
                            <span><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></span>
                        </div>
                        <p class="payment-options-con-txt">
                            <?php echo PAYMENT_METHODS_BANK_TRANSFER_CONTENT_01;?>
                        </p>
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
                        <p class="payment-options-con-txt">
                            <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01;?>
                        </p>
                        <div class="payment-options-con-href">
                            <a href="<?php echo reset_url('/policies/net_30.html');?>">
                                <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_APPLY;?></span>
                                <span class="icon iconfont">&#xf451;</span>
                            </a>
                        </div>
                    </li>

                    <li class="payment-options-con">
                        <div class="payment-options-con-tit">
                            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/ideal.svg" width="24">
                            <span><?php echo PAYMENT_METHODS_IDEAL;?></span>
                        </div>
                        <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_IDEAL_CONTENT_01;?></p>
                        <div class="payment-options-con-href">
                            <a href="javascript:;" onclick="$('#payThods-popup01').show();">
                                <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS;?></span>
                                <span class="icon iconfont">&#xf451;</span>
                            </a>
                        </div>
                    </li>

                    <li class="payment-options-con">
                        <div class="payment-options-con-tit">
                            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/sofortuberweisung.svg" width="43">
                            <span><?php echo PAYMENT_METHODS_SOFORT;?></span>
                        </div>
                        <p class="payment-options-con-txt">
                            <?php echo PAYMENT_METHODS_SOFORT_CONTENT_01;?>
                        </p>
                        <div class="payment-options-con-href">
                            <a href="javascript:;" onclick="$('#payThods-popup').show();">
                                <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS;?></span>
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
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_06;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_09;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_13;?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                            <td> <?php echo PAYMENT_METHODS_PAYPAL;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                            <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_BANK_TRANSFER;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_11;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_NET_TERM;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_IDEAL;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_12;?></td>
                            <td><?php echo PAYMENT_METHODS_IDEAL;?></td>
                        </tr>
                        <tr>
                            <td> <?php echo PAYMENT_METHODS_SOFORT;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_12;?></td>
                            <td> <?php echo PAYMENT_METHODS_SOFORT;?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP;?></p>
            </div>
        </div>
    </div>
</div>

<!-- de-SOFORT 弹窗： -->
<div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
    <div class="payThods-alone-popupBg"></div>
    <div class="payThods-alone-680">
        <p class="payThods-alone-popupTit">
            <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT;?></span>
            <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
        </p>
        <div class="payThods-popup-content">
            <div class="payThods-txtBox choosez">
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_01;?></p>
                <ul class="sofort_bene_ul after">
                    <li><i class="de"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_01;?></li>
                    <li><i class="at"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_02;?></li>
                    <li><i class="ch"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_03;?></li>
                    <li><i class="be"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_04;?></li>
                    <li><i class="fr"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_05;?></li>
                    <li><i class="nl"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_06;?></li>
                    <li><i class="gb"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_07;?></li>
                    <li><i class="it"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_08;?></li>
                    <li><i class="es"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_09;?></li>
                    <li><i class="pl"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_10;?></li>
                    <li><i class="hu"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_11;?></li>
                    <li><i class="sk"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_12;?></li>
                    <li><i class="cz"></i><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_02_13;?></li>
                </ul>
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_SOFORT_CONTENT_03;?></p>
            </div>
        </div>
    </div>
</div>
<!-- de-iDEAL 弹窗： -->
<div class="payThods-alone-popup" id="payThods-popup01" style="display: none;">
    <div class="payThods-alone-popupBg"></div>
    <div class="payThods-alone-680">
        <p class="payThods-alone-popupTit">
            <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL;?></span>
            <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup01').hide()">&#xf092;</em>
        </p>
        <div class="payThods-popup-content">
            <div class="payThods-txtBox choosez">
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_01;?></p>
                <ul class="iDEAL_bene_ul after">
                    <li>
                        <i class="ab"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_01;?>
                    </li>
                    <li>
                        <i class="an"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_02;?>
                    </li>
                    <li>
                        <i class="in"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_03;?>
                    </li>
                    <li>
                        <i class="kn"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_04;?>
                    </li>
                    <li>
                        <i class="tr"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_05;?>
                    </li>
                    <li>
                        <i class="va"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_06;?>
                    </li>
                    <li>
                        <i class="mo"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_07;?>
                    </li>
                    <li>
                        <i class="ra"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_08;?>
                    </li>
                    <li>
                        <i class="re"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_09;?>
                    </li>
                    <li>
                        <i class="sns"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_10;?>
                    </li>
                    <li>
                        <i class="bu"></i><?php echo PAYMENT_METHODS_PAY_WITH_IDEAL_CONTENT_02_11;?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Bank Transfer弹窗 -->
<div class="payThods-alone-popup" id="payThods-popup02" style="display: none;">
    <div class="payThods-alone-popupBg"></div>
    <div class="payThods-alone-680">
        <p class="payThods-alone-popupTit">
            <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER;?></span>
            <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup02').hide()">&#xf092;</em>
        </p>
        <div class="payThods-popup-content">
            <div class="payThods-txtBox choosez">
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_01;?></p>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="direct-popup-ta">
                    <tbody>
                    <?php if ($_SESSION['currency'] == 'USD') {?>
                        <tr>
                            <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_07;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_11;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_13;?></b></td>
                        </tr>
                    <?php } elseif ($_SESSION['currency'] == 'GBP') {?>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_14;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_15;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_13;?></b></td>
                        </tr>
                    <?php } elseif ($_SESSION['currency'] == 'CHF'){?>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_16;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_17;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_13;?></b></td>
                        </tr>
                    <?php } elseif ($_SESSION['currency'] == 'SEK'){?>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_18;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_19;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_13;?></b></td>
                        </tr>
                    <?php }else{?>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_02;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_03;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_04;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_05;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_06;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_20;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_08;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_09;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_10;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_21;?></b></td>
                        </tr>
                        <tr>
                            <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_12;?></th>
                            <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_BANK_TRANSFER_CONTENT_22;?></b></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

