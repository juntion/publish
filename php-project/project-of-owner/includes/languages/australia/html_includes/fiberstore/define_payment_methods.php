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
                    <?php if ($_SESSION['languages_code'] == 'au' && $_SESSION['countries_iso_code'] == 'nz') {?>
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
                            <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/direct-deposit-grey.svg" width="43">
                            <span><?php echo PAYMENT_METHODS_DIRECT_DEPOSIT;?></span>
                        </div>
                        <p class="payment-options-con-txt">  <?php echo PAYMENT_METHODS_DIRECT_DEPOSIT_CONTENT_01;?></p>
                        <div class="payment-options-con-href">
                            <a href="javascript:;" onclick="$('#payThods-popup').show();">
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
                    <?php }else{?>
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
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/direct-deposit-grey.svg" width="43">
                                <span><?php echo PAYMENT_METHODS_DIRECT_DEPOSIT;?></span>
                            </div>
                            <p class="payment-options-con-txt"> <?php echo PAYMENT_METHODS_DIRECT_DEPOSIT_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup').show();">
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
                            <p class="payment-options-con-txt">  <?php echo PAYMENT_METHODS_NET_TERM_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <a href="<?php echo reset_url('/policies/net_30.html');?>">
                                    <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_APPLY;?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>

                        <li class="payment-options-con">
                            <div class="payment-options-con-tit">
                                <img src="<?php echo HTTPS_IMAGE_SERVER;?>includes/templates/fiberstore/images/specials/payment_met/payment-Methods-cheque.svg" width="28">
                                <span><?php echo PAYMENT_METHODS_CHEQUE;?></span>
                            </div>
                            <p class="payment-options-con-txt">       <?php echo PAYMENT_METHODS_CHEQUE_CONTENT_01;?></p>
                            <div class="payment-options-con-href">
                                <a href="javascript:;" onclick="$('#payThods-popup01').show();">
                                    <span><?php echo PAYMENT_METHODS_LEARN_MORE_AND_INSTRUCTIONS;?></span>
                                    <span class="icon iconfont">&#xf451;</span>
                                </a>
                            </div>
                        </li>

                    <?php }?>
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
                            <td><?php echo PAYMENT_METHODS_PAYPAL;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                            <td><?php echo PAYMENT_METHODS_CREDIT_CARD;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_DIRECT_DEPOSIT;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_11;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></td>
                        </tr>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_NET_TERM;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_08;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_10;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_15;?></td>
                        </tr>
                        <?php if ($_SESSION['languages_code'] == 'au' && $_SESSION['countries_iso_code'] != 'nz') {?>
                        <tr>
                            <td><?php echo PAYMENT_METHODS_CHEQUE;?></td>
                            <td> <?php echo PAYMENT_METHODS_TABLE_CONTENT_07;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_12;?></td>
                            <td><?php echo PAYMENT_METHODS_TABLE_CONTENT_14;?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>

                <p class="compare-features-txt">*<?php echo PAYMENT_METHODS_PAYMENT_TIP;?></p>
            </div>
        </div>
    </div>
</div>

<!-- au-Direct Deposit 弹框 -->
<div class="payThods-alone-popup" id="payThods-popup" style="display: none;">
    <div class="payThods-alone-popupBg"></div>
    <div class="payThods-alone-680">
        <p class="payThods-alone-popupTit">
            <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT;?></span>
            <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup').hide()">&#xf092;</em>
        </p>
        <div class="payThods-popup-content">
            <div class="payThods-txtBox choosez">
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_01;?></p>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="direct-popup-ta">
                    <tbody>
                    <tr>
                        <th width="200" valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_02;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_03;?></b></td>
                    </tr>
                    <tr>
                        <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_04;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_05;?></b></td>
                    </tr>
                    <tr>
                        <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_06;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_07;?></b></td>
                    </tr>
                    <tr>
                        <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_08;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_09;?></b></td>
                    </tr>
                    <tr>
                        <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_10;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_11;?></b></td>
                    </tr>
                    <tr>
                        <th valign="top"><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_12;?></th>
                        <td valign="top"><b><?php echo PAYMENT_METHODS_PAY_WITH_DIRECT_DEPOSIT_CONTENT_13;?></b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- check 弹框 -->
<div class="payThods-alone-popup" id="payThods-popup01" style="display: none;">
    <div class="payThods-alone-popupBg"></div>
    <div class="payThods-alone-680">
        <p class="payThods-alone-popupTit">
            <span class="choosez"><?php echo PAYMENT_METHODS_PAY_WITH_CHEQUE;?></span>
            <em class="iconfont icon payThods-alaose" onclick="$('#payThods-popup01').hide()">&#xf092;</em>
        </p>
        <div class="payThods-popup-content">
            <div class="payThods-txtBox choosez">
                <p class="payThods-popup-txt"><?php echo PAYMENT_METHODS_PAY_WITH_CHEQUE_CONTENT_01;?></p>
                <div class="payThods-checkAddress-box">
                    <?php echo PAYMENT_METHODS_PAY_WITH_CHEQUE_CONTENT_02;?>
                </div>
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