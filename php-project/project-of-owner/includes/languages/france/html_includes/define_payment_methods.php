<link rel="stylesheet" type="text/css" media="all" href="/includes/templates/fiberstore/css/PU_payment.css">
<?php
//欧洲国家
$eu_all = array(
    0 => "AL",
    1 => "TT",
    2 => "AD",
    3 => "BE",
    4 => "BA",
    5 => "BG",
    6 => "DK",
    7 => "FI",
    8 => "FR",
    9 => "IS",
    10 => "IT",
    11 => "PL",
    12 => "PT",
    13 => "RO",
    14 => "SM",
    15 => "NO",
    16 => "LI",
    17 => "CH",
    18 => "MD",
    19 => "UA",
    20 => "BY",
    21 => "VA",
    22 => "RU",
    23 => "MC",
    24 => "RS"

);
$eu_arr = array(
    0=>'FR',
    1=>'DE',
    2=>'SE',
    3=>'CZ',
    4=>'NL',
    5=>'LU',
    6=>'PT',
    7=>'EL',
    8=>'IE',
    9=>'PL',
    10=>'LT',
    11=>'LV',
    12=>'EE',
    13=>'FI',
    14=>'AT',
    15=>'HR',
    16=>'HU',
    17=>'SK',
    18=>'RO',
    19=>'BG',
    20=>'BE',
    21=>'IT',
    22=>'ES',
    23=>'CY',
    24=>'SI',
    25=>'DK',
    26=>'MT',
    27=>'UKGB'
);//欧盟国家
$eu_all = array_values(array_diff($eu_all,$eu_arr));
?>
<div class="page_nav">
    <div class="page_nav_con">
        <div class="big_title"><a><?php echo FS_NET_SHIPPING;?></a>

        </div>
        <div class="short_title">
            <a href="payment_methods.html" class="title_selected"><?php echo FS_NET_PAYMENT;?></a>
            <a href="net_30.html" ><?php echo NAVBAR_TITLE;?></a>
            <a href="shipping_delivery.html"><?php echo FS_NET_SHIPMENT;?></a></div>
    </div>
</div>
<div class="PU_banner">
    <div class="PU_content">
        <div class="PU_banner_bg"></div>
        <h2 class="PU_banner_tit"><?php echo FS_PAY_METHODS;?></h2>
        <p class="PU_banner_txt"><?php echo FS_PAY_US_BANNER_TIP;?></p>
    </div>
</div>
<div class="PU_business">
    <div class="PU_content">
        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_US_LEARN_MORE;?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_LEARN_TIP;?></p>
    </div>
</div>

<div class="PU_paypai">

    <div class="PU_paypai_top">
        <div class="PU_content">
            <div class="PU_paypai_top_left">
                <img class="PU_margin" src="/includes/templates/fiberstore/images/payment_img/Paypal-01.png" />
                <h2 class="PU_business_tit"><?php echo FS_PAY_US_PAY_NEW;?></h2>
                <p class="PU_business_txt"><?php echo FS_PAY_US_PAY_NEW_TIT;?><br><?php echo FS_PAY_US_PAY_NEW_TIT_TWO;?> <a class="PU_a" href="mailto: paypal@fs.com">paypal@fs.com</a>.</p>
                <img class="PU_paypai_top_left_img_bottom PU_margin" src="/includes/templates/fiberstore/images/payment_img/Paypal-03.png" />
            </div>
            <div class="PU_paypai_top_right">
                <img class="margin_auto" width="290" height="224" src="/includes/templates/fiberstore/images/payment_img/Paypal-02.jpg" />
            </div>
        </div>
    </div>

    <div class="PU_paypai_bottom">
        <div class="PU_content">
            <div class="PU_paypai_top_right PU_left">
                <img class="PU_paypai_top_right_img_top" src="/includes/templates/fiberstore/images/payment_img/Credit-01.png" />
                <h2 class="PU_business_tit"><?php echo FS_PAY_US_CREDIT_NEW_TIT;?></h2>
                <p class="PU_business_txt"><?php echo FS_PAY_US_CREDIT_NEW_TIT_TWO;?></p>
                <p class="PU_business_txt PU_txt"><?php echo FS_PAY_US_CREDIT_NEW_TIT_THREE;?></p>
                <p class="PU_business_txt"><?php echo FS_PAY_US_CREDIT_NEW_TIT_FOURTH;?></p>
                <img class="PU_paypai_top_left_img_bottom PU_img_bottom PU_margin" src="/includes/templates/fiberstore/images/payment_img/Credit-03.png" />
            </div>
            <div class="PU_paypai_top_left">
                <img class="PU_paypai_top_left_img_top PU_margin margin_auto" src="/includes/templates/fiberstore/images/payment_img/Credit-02.png" />
            </div>
        </div>
    </div>

    <?php
    //俄罗斯国家
        if($country_code=="RU"){
    ?>
    <div class="PU_paypai_top PU_paypai_top_right_img_top">
        <div class="PU_content">
            <div class="PU_paypai_top_left">
                <img class="PU_margin" src="/includes/templates/fiberstore/images/payment_img/logo_Yandex  money.png" />
                <h2 class="PU_business_tit"><?php echo FS_PAY_ADD_1;?></h2>
                <p class="PU_business_txt"><?php echo FS_PAY_ADD_2;?></p>

                <ul class="pu_ul">
                	<li><i>*</i><?php echo FS_PAY_ADD_3; ?></li>
                	<li><i>*</i><?php echo FS_PAY_ADD_4; ?></li>
                	<li><i>*</i><?php echo FS_PAY_ADD_5; ?></li>
                </ul>

                <img class="PU_paypai_top_left_img_bottom PU_margin" src="/includes/templates/fiberstore/images/payment_img/Payment-Methods_01.png" />
            </div>
            <div class="PU_paypai_top_right">
                <img width="379" height="342" src="/includes/templates/fiberstore/images/payment_img/Payment-Methods_19.png" />
            </div>
        </div>
    </div>
    <div class="PU_paypai_bottom">
        <div class="PU_content">
            <div class="PU_paypai_top_right PU_left">
                <img class="PU_paypai_top_right_img_top" src="/includes/templates/fiberstore/images/payment_img/logo_Web Money.png" />
                <h2 class="PU_business_tit"><?php echo FS_PAY_ADD_6; ?></h2>
                <p class="PU_business_txt"><?php echo FS_PAY_ADD_7; ?></p>

                <ul class="pu_ul">
                	<li><i>*</i><?php echo FS_PAY_ADD_8; ?></li>
                	<li><i>*</i><?php echo FS_PAY_ADD_9; ?></li>
                	<li><i>*</i><?php echo FS_PAY_ADD_10; ?></li>
                </ul>

                <img class="PU_paypai_top_left_img_bottom PU_margin pu_margin_only" src="/includes/templates/fiberstore/images/payment_img/Payment-Methods_01.png" />
            </div>
            <div class="PU_paypai_top_left">
                <img class="pu_margin_right" src="/includes/templates/fiberstore/images/payment_img/Payment-Methods_24.png" />
            </div>
        </div>
    </div>
<?php } ?>
</div>

<?php
 if($country_code!="DE"){
?>
<div class="PU_wire border_bottom">
    <div class="PU_content">
        <img class="PU_content_img" style="height: 50px" src="https://www.fs.com/includes/templates/fiberstore/images/payment_img/Bank Transfer.svg" />
        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_US_WIRE_NEW_TIT;?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_WIRE_NEW_TIT_ONE;?></p>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_WIRE_NEW_TIT_TWO;?> <a  class="PU_a" href="mailto: Finance@fs.com">Finance@fs.com</a> <?php echo FS_PAY_US_WIRE_NEW_TIT_THREE.FS_PHONE_US;?>.</p>

        <div class="PU_beneficiary">
            <table class="PU_beneficiary_table" cellpadding="0" cellspacing="0">
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_BANK_NAME;?></td>
                    <td><?php echo FS_PAY_HK;?></td>
                </tr>
                <tr class="PU_beneficiary_blue">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_AC_NAME;?></td>
                    <td><?php echo FS_PAY_CO;?></td>
                </tr>
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_AC_NO;?></td>
                    <td>817-498231-838</td>
                </tr>
                <tr class="PU_beneficiary_blue">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_SWIFT;?></td>
                    <td><?php echo FS_PAY_HSBC;?></td>
                </tr>
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADDRESS;?></td>
                    <td><?php echo FS_PAY_QUEEN;?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php } ?>
<?php
$all_hide = array("US","RU");
if(!in_array($country_code,$all_hide)){
?>
<?php
if(!in_array($country_code,$eu_all) && in_array($country_code,$eu_arr)){
?>

<div class="PU_wire pu_only">
	<div class="pu_bg"></div>
    <div class="PU_content">
        <img class="PU_content_img pu_padding_bottom" src="/includes/templates/fiberstore/images/payment_img/logo_vorkasse.png" />
        <p class="pu_txt PU_tit_center"><?php echo FS_PAY_ADD_11; ?></p>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_ADD_12; ?></p>

        <div class="PU_beneficiary">
            <table class="PU_beneficiary_table" cellpadding="0" cellspacing="0">
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_13; ?></td>
                    <td><?php echo FS_PAY_ADD_14; ?></td>
                </tr>
                <tr class="PU_beneficiary_blue">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_38; ?></td>
                    <td><?php echo FS_PAY_ADD_15; ?></td>
                </tr>
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_16; ?> </td>
                    <td>DE16 7005 1003 0025 6748 88</td>
                </tr>
                <tr class="PU_beneficiary_blue">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_17; ?></td>
                    <td>BYLADEM1FSI</td>
                </tr>
                <tr class="PU_beneficiary_gray">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_18; ?></td>
                    <td>25674888</td>
                </tr>
                <tr class="PU_beneficiary_blue">
                    <td class="PU_beneficiary_left"><?php echo FS_PAY_ADD_19; ?></td>
                    <td><?php echo FS_PAY_ADD_20; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php } ?>
<?php if(in_array($country_code,$eu_all) || in_array($country_code,$eu_arr)){ ?>
<div class="PU_wire pu_wire_only">
    <div class="PU_content">
        <img class="PU_content_img pu_padding_bottom" src="/includes/templates/fiberstore/images/payment_img/logo_sofort.png" />
        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_ADD_21; ?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_ADD_22; ?></p>
        <p class="pu_txt PU_tit_center"><?php echo FS_PAY_ADD_23; ?></p>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_ADD_24; ?></p>

        <div class="PU_beneficiary">
        	<ul class="pu_bene_ul">
        		<li><i class="de"></i><?php echo FS_PAY_ADD_25; ?></li>
        		<li><i class="au"></i><?php echo FS_PAY_ADD_26; ?></li>
        		<li><i class="ch"></i><?php echo FS_PAY_ADD_27; ?></li>
        		<li><i class="be"></i><?php echo FS_PAY_ADD_28; ?></li>
        		<li><i class="fr"></i><?php echo FS_PAY_ADD_29; ?></li>

        		<li><i class="nl"></i><?php echo FS_PAY_ADD_30; ?></li>
        		<li><i class="gb"></i><?php echo FS_PAY_ADD_31; ?></li>
        		<li><i class="it"></i><?php echo FS_PAY_ADD_32; ?></li>
        		<li><i class="es"></i><?php echo FS_PAY_ADD_33; ?></li>
        		<li><i class="pl"></i><?php echo FS_PAY_ADD_34; ?></li>

        		<li><i class="hu"></i><?php echo FS_PAY_ADD_35; ?></li>
        		<li><i class="sk"></i><?php echo FS_PAY_ADD_36; ?></li>
        		<li><i class="cz"></i><?php echo FS_PAY_ADD_37; ?></li>
        	</ul>
        </div>
    </div>
</div>
<?php } ?>
<?php } ?>
<?php
$btn =  false;
if($btn){
?>
<div class="PU_wire PU_wire_none">
    <div class="PU_wire_bg"></div>
    <div class="PU_content">
        <img class="PU_content_img" src="/includes/templates/fiberstore/images/payment_img/WU-01.png" />
        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_US_UNION_NEW_TIT;?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_UNION_NEW_TIT_TWO;?></p>

        <div class="PU_prepare">
            <dl class="PU_prepare_dl">
                <dt><img src="/includes/templates/fiberstore/images/payment_img/WU-02.png" /></dt>
                <dd>
                    <p class="PU_business_txt PU_txt"><?php echo FS_PAY_US_UNION_NEW_TIT_1;?></p>
                    <p class="PU_business_txt PU_business_txt_fl"><?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_1;?></p>
                </dd>
            </dl>
            <dl class="PU_prepare_dl">
                <dt><img src="/includes/templates/fiberstore/images/payment_img/WU-03.png" /></dt>
                <dd>
                    <p class="PU_business_txt PU_txt"><?php echo FS_PAY_US_UNION_NEW_TIT_2;?></p>
                    <p class="PU_business_txt PU_business_txt_fl"><?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_2;?><br><?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_3;?><br>
                        <?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_4;?><br><?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_5;?></p>
                </dd>
            </dl>
            <dl class="PU_prepare_dl">
                <dt><img src="/includes/templates/fiberstore/images/payment_img/WU-04.png" /></dt>
                <dd>
                    <p class="PU_business_txt PU_txt"><?php echo FS_PAY_US_UNION_NEW_TIT_3;?></p>
                    <p class="PU_business_txt PU_business_txt_fl"><?php echo FS_PAY_US_UNION_NEW_TIT_TEXT_6;?> <a class="PU_a" href="mailto: Finance@fs.com">Finance@fs.com</a>. </p>
                </dd>
            </dl>
        </div>
    </div>
</div>
<?php }?>

<div class="PU_wire">
    <div class="PU_content">
        <img class="PU_content_img" src="/includes/templates/fiberstore/images/payment_img/PURCHASE-01.png" />
        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_US_PURCHASE_TIT;?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_PURCHASE_TIT_ONE;?><br><?php echo FS_PAY_US_PURCHASE_TIT_TWO;?><br><?php echo FS_PAY_US_PURCHASE_TIT_THREE;?> </p>

        <div class="PU_div">
            <dl class="PU_div_dl">
                <dt>
                <h2><?php echo FS_PAY_US_PURCHASE_TIT_PART1;?></h2>
                <p><?php echo FS_PAY_US_PURCHASE_TIT_PART2;?></p>
                </dt>
                <dd>
                    <img src="/includes/templates/fiberstore/images/payment_img/PURCHASE-02.jpg" />
                </dd>
            </dl>

            <dl class="PU_div_dl">
                <dt>
                <h2><?php echo FS_PAY_US_PURCHASE_TIT_PART3;?></h2>
                <p><?php echo FS_PAY_US_PURCHASE_TIT_PART4;?></p>
                </dt>
                <dd>
                    <img src="/includes/templates/fiberstore/images/payment_img/PURCHASE-03.jpg" />
                </dd>
            </dl>
        </div>

        <h2 class="PU_business_tit PU_tit_center"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM;?></h2>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM1;?> <a class="PU_a" href="mailto: Finance@fs.com">Finance@fs.com</a> <?php echo FS_PAY_US_PURCHASE_TIT_OR.FS_PHONE_US.FS_PAY_US_PURCHASE_TIT_BOTTOM2;?><br>
            <?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM3;?><br>
            <?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM4;?><br> <?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM5;?></p>
    </div>
</div>

<div class="PU_wire PU_bottom">
    <div class="PU_content">
        <dl class="PU_bottom_dl">
            <dt><img src="/includes/templates/fiberstore/images/payment_img/PURCHASE-04.png" /></dt>
            <dd>
                <p class="PU_business_txt"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM6;?><a class="PU_a" href="mailto: Finance@fs.com">Finance@fs.com</a> <?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM7.FS_PHONE_US;?>.</p>
            </dd>
        </dl>
        <dl class="PU_bottom_dl">
            <dt><img src="/includes/templates/fiberstore/images/payment_img/PURCHASE-05.png" /></dt>
            <dd>
                <p class="PU_business_txt"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM8;?> <a class="PU_a" target="_blank" href="https://img-en.fs.com/includes/templates/fiberstore/images/PDF/Global_Credit_Application_Form.pdf"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM9;?></a><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM10;?></p>
            </dd>
        </dl>
        <dl class="PU_bottom_dl">
            <dt><img src="/includes/templates/fiberstore/images/payment_img/PURCHASE-06.png" /></dt>
            <dd>
                <p class="PU_business_txt"><?php echo FS_PAY_US_PURCHASE_TIT_BOTTOM11;?></p>
            </dd>
        </dl>
    </div>
</div>
<?php
//美国
if($country_code=='US'){
?>
<div class="PU_wire">
    <div class="PU_content">
        <img class="PU_content_img padding_none" src="/includes/templates/fiberstore/images/payment_img/W9-01.png" />
        <p class="PU_business_txt PU_tit_center PU_txt_bottom"><?php echo FS_PAY_US_PURCHASE_TIT_W9;?></p>
        <p class="PU_business_txt PU_tit_center"><?php echo FS_PAY_US_PURCHASE_TIT_W9_TEXT;?></p>
        <div class="PU_bottom_div">
            <a target="_blank" href="/social_media/Fiberstore Inc.W9.pdf" ><img src="/includes/templates/fiberstore/images/payment_img/W9-02.png" /> <?php echo FS_PAY_US_PURCHASE_TIT_W9_BUTTON;?></a>
        </div>
    </div>
</div>
<?php } ?>
<script>
    //�����󵼺��̶�
    $(function(){
        $(window).scroll(function(){
            height = $(window).scrollTop();
            if(height > 170){
                $('.page_nav').fadeIn();
            }else{
                $('.page_nav').stop(true).hide();
            };

        });
    });
</script>
