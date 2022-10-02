
<?php

/**
 * how to buy
 * add 2017.9.15.ternence
 */?>

<script>
    //滚动后导航固定
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
<?php if(all_german_warehouse('country_code',strtoupper($_SESSION['languages_code']))){?>
    <div class="alone_banner purchase_help">
        <div class="alone_banner_bg"></div>
        <h2 class="alone_banner_tit alone_center color_White purchase_help"><?php echo FS_HOW_TO_BUY_01; ?></h2>
        <p class="alone_banner_txt alone_center color_White"><?php echo FS_HOW_TO_BUY_02; ?></p>
    </div>
    <div class="purchaseHelp_content_listbox">
        <div class="alone_after">
            <div class="purchaseHelp_left">
                <div class="purchaseHelp_left_fix">
                    <ul class="purchaseHelp_left_list">
                        <li class="purchaseHelp_left_li choosez"><?php echo FS_HOW_TO_BUY_03; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_04; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_05; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_170; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_06; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_07; ?></li>
                        <li class="purchaseHelp_left_li"><?php echo FS_HOW_TO_BUY_08; ?></li>
                    </ul>
                </div>
            </div>
            <div  class="purchaseHelp_right">
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_03; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_09; ?><span class="icon iconfont">&#xf049;</span></h3>
                        <div class="pur_qa_con_main">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_10; ?> </p>
                            <ul class="hasDot_ul">
                                <li><?php echo FS_HOW_TO_BUY_12; ?><a href="<?php echo zen_href_link('login','','SSL');?>"><?php echo FS_HOW_TO_BUY_13; ?></a><?php echo FS_HOW_TO_BUY_14; ?><a href="<?php echo zen_href_link('regist','','SSL');?>"><?php echo FS_HOW_TO_BUY_15; ?></a>”.</li>
                                <li><?php echo FS_HOW_TO_BUY_16; ?><a href="<?php echo zen_href_link('regist','','SSL');?>"><?php echo FS_HOW_TO_BUY_09; ?></a><?php echo FS_HOW_TO_BUY_17; ?></li>
                            </ul>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_18; ?><a href="<?php echo zen_href_link('my_dashboard','','SSL');?>"><?php echo FS_HOW_TO_BUY_03; ?></a><?php echo FS_HOW_TO_BUY_19; ?> </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_21; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_22; ?> </p>
                            <ul class="hasDot_ul choosez">
                                <li><b><a href="<?php echo zen_href_link('edit_my_account','','SSL');?>"> <?php echo FS_HOW_TO_BUY_23; ?></a></b><br/>
                                    <?php echo FS_HOW_TO_BUY_24; ?><a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo FS_HOW_TO_BUY_25; ?></a>".</li>
                                <li><b> <?php echo FS_HOW_TO_BUY_26; ?></b><br/>
                                    <?php echo FS_HOW_TO_BUY_27; ?> "<a href="<?php echo zen_href_link('edit_my_account','','SSL');?>""><?php echo FS_HOW_TO_BUY_23; ?></a>". <?php echo FS_HOW_TO_BUY_28; ?> "<a href="<?php echo zen_href_link('login','','SSL');?>"><?php echo FS_HOW_TO_BUY_29; ?></a>" <?php echo FS_HOW_TO_BUY_30; ?><?php echo FS_HOW_TO_BUY_32; ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_35; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_36; ?> "<a href="<?php echo zen_href_link('manage_addresses','','SSL');?>"><?php echo FS_HOW_TO_BUY_37; ?></a>". <?php echo FS_HOW_TO_BUY_38; ?> "<a href="<?php echo zen_href_link('my_dashboard','','SSL');?>"><?php echo FS_HOW_TO_BUY_03; ?></a>" <?php echo FS_HOW_TO_BUY_39; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_40; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_41; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_42; ?> </p>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_43; ?></p>
                            <ul class="hasDot_ul">
                                <li><?php echo FS_HOW_TO_BUY_44; ?> "<a href="<?php echo zen_href_link('my_cases','','SSL');?>"><?php echo FS_HOW_TO_BUY_45; ?></a>".
                                </li>
                                <li><?php echo FS_HOW_TO_BUY_46; ?></li>
                                <li><?php echo FS_HOW_TO_BUY_47; ?> "<a href="<?php echo zen_href_link('my_cases','','SSL');?>"><?php echo FS_HOW_TO_BUY_45; ?></a>".</li>
                                <li><?php echo FS_HOW_TO_BUY_48; ?><a href="<?php echo zen_href_link('customer_service','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_49; ?></a>".
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_04; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_50; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_51; ?></p>
                            <p class="purchaseHelp_right_txt1">1)&nbsp;&nbsp;<?php echo FS_HOW_TO_BUY_52; ?></p>
                            <p class="purchaseHelp_right_txt1">2)&nbsp;&nbsp;<?php echo FS_HOW_TO_BUY_53; ?><br/>
                                <?php echo FS_HOW_TO_BUY_54; ?>
                            </p>
                            <p class="purchaseHelp_right_txt1">3) <?php echo FS_HOW_TO_BUY_55; ?></p>
                            <ul class="hasDot_ul choosez">
                                <li><b><?php echo FS_HOW_TO_BUY_56; ?></b><br/>
                                    <?php echo FS_HOW_TO_BUY_57; ?> “<?php echo FS_HOW_TO_BUY_58; ?>”. <?php echo FS_HOW_TO_BUY_59; ?>
                                </li>
                                <li><b><?php echo FS_HOW_TO_BUY_60; ?></b><br/>
                                    <?php echo FS_HOW_TO_BUY_61; ?>
                                </li>
                                <li><b><?php echo FS_HOW_TO_BUY_62; ?> </b><br/>
                                    <?php echo FS_HOW_TO_BUY_63; ?> "<?php echo FS_HOW_TO_BUY_64; ?>" <?php echo FS_HOW_TO_BUY_65; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_66; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_67; ?></p>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_68; ?><a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>"> <?php echo FS_HOW_TO_BUY_69; ?></a></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_70; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_71; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_72; ?>
                            </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_73; ?>
                            </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_74; ?>
                            </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_75; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_76; ?> <a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo FS_HOW_TO_BUY_77; ?></a> - <?php echo FS_HOW_TO_BUY_78; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_79; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_80; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_81; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_82; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_83; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_84; ?> <a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo FS_HOW_TO_BUY_77; ?></a>.</p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_85; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_86; ?></p>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_05; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_87; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_88; ?></p>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_89; ?> <a href="<?php echo zen_href_link('payment_methods','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_90; ?></a>. </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_159; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_160; ?></p>
                            <p class="purchaseHelp_right_txt1 purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_161; ?></p>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_162; ?> <a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_163; ?></a></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_164; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_165; ?></p>
                            <p class="purchaseHelp_right_txt1 purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_166; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_167; ?></p>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_168; ?> <a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_169; ?></a></p>
                        </div>
                    </div>



                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_91; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <ul class="hasDot_ul choosez">
                                <li><b><?php echo FS_HOW_TO_BUY_92; ?></b><br/>
                                    <?php echo FS_HOW_TO_BUY_93; ?> ''<a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo FS_HOW_TO_BUY_94; ?></a>'' <?php echo FS_HOW_TO_BUY_95; ?>
                                </li>
                                <li><b><?php echo FS_HOW_TO_BUY_96; ?></b><br/>
                                    <?php echo FS_HOW_TO_BUY_97; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_98; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_99; ?> <a href="<?php echo zen_href_link('partner','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_100; ?></a>, <?php echo FS_HOW_TO_BUY_101; ?></p>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_69; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn">  <?php echo FS_HOW_TO_BUY_102; ?> <span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_103; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_104; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_105; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_106; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_107; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_108; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_109; ?></p>
                            <p  class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_110; ?> <a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_111; ?></a>. </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_112; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_113; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_158; ?></p>
                            <p  class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_114; ?></p>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_06; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_115; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_116; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_117; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_118; ?> </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_119; ?> <span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_120; ?> <a href="<?php echo zen_href_link('solution_support'); ?>"><?php echo FS_HOW_TO_BUY_121;?></a>. <?php echo FS_HOW_TO_BUY_122; ?> </p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn">  <?php echo FS_HOW_TO_BUY_123; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_124; ?> </p>
                            <p  class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_125; ?> </p>
                            <p  class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_126; ?> "<a href=" <?php echo zen_href_link('inquiry_list');?>"><?php echo FS_HOW_TO_BUY_127; ?></a>". <?php echo FS_HOW_TO_BUY_128; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_129; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_130; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_131; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_132; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_133; ?> "<a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo FS_HOW_TO_BUY_77; ?></a>" <?php echo FS_HOW_TO_BUY_134; ?>   </p>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_07; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_135; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_136; ?></p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_137; ?> <a href="<?php echo zen_href_link('day_return_policy','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_138; ?></a> <?php echo FS_HOW_TO_BUY_139; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_140; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_141; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_142; ?> "<a href="<?php echo zen_href_link('warranty','','SSL',true);?>"><?php echo FS_HOW_TO_BUY_143; ?></a>" <?php echo FS_HOW_TO_BUY_144; ?></p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_145; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_146; ?> </p>
                            <ul class="hasDot_ul">
                                <li><?php echo FS_HOW_TO_BUY_147; ?> </li>
                                <li><?php echo FS_HOW_TO_BUY_148; ?></li>
                            </ul>
                            <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_149; ?> </p>
                        </div>
                    </div>
                </div>
                <div class="purchaseHelp_right_cont">
                    <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_08; ?></h1>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_150; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_151; ?> </p>
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_152; ?> <a href="<?php echo zen_href_link('account_newsletters','','SSL');?>"><?php echo FS_HOW_TO_BUY_153; ?></a>.</p>
                        </div>
                    </div>
                    <div class="pur_qa_con">
                        <h3 class="purchaseHelp_right_tit1 relax_pbtn alone_padding_bottom"><?php echo FS_HOW_TO_BUY_154; ?><span class="icon iconfont">&#xf057;</span></h3>
                        <div class="pur_qa_con_main choosez">
                            <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_155; ?> <a href="<?php echo zen_href_link('service_feedback','','SSL');?>"><?php echo FS_HOW_TO_BUY_156; ?></a> <?php echo FS_HOW_TO_BUY_157; ?> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">



        $(function(){
            $('.relax_pbtn').on('click',function(){
                if ($(this).siblings().hasClass('choosez')) {
                    $(this).find('.icon').html('&#xf049;');
                    $(this).parent('.pur_qa_con').siblings().find('.icon').html('&#xf057;');
                    $(this).siblings().slideDown(300).removeClass('choosez');
                    $(this).parent('.pur_qa_con').siblings().find('.pur_qa_con_main').slideUp().addClass('choosez');
                    $(this).parents('.purchaseHelp_right_cont').siblings().find('.pur_qa_con_main').slideUp().addClass('choosez');
                    $(this).parents('.purchaseHelp_right_cont').siblings().find('.pur_qa_con .icon').html('&#xf057;');
                }else{
                    $(this).find('.icon').html('&#xf057;');
                    $(this).siblings().slideUp(300).addClass('choosez');
                }
            })
            $(function(){
                var z = $('.purchaseHelp_right').height()-$('.purchaseHelp_left_fix').height()-60;
                Pbanner = $('.alone_banner').height();
                totalSc = Pbanner+178;
                ch = []
                $('.purchaseHelp_right_cont').each(function(){
                    ch.push($(this).offset().top);
                })
                $(window).on("scroll",function () {
                    setTimeout(function(){
                        for (var i = 0; i < ch.length-1; i++) {
                            if(ch[i] - $(window).scrollTop() <= 60){
                                var chIndex = ch.indexOf(ch[i]);
                                $('.purchaseHelp_left_li').eq(chIndex).addClass('choosez').siblings().removeClass('choosez');
                            }
                        }

                    },50);
                    if($(window).scrollTop() >= $('.purchaseHelp_right').height()){
                        $('.purchaseHelp_left_fix').css({"margin-top": z+'px'}).addClass('choosez1').removeClass('choosez');
                    }else{
                        $('.purchaseHelp_left_fix').css({"margin-top": 0}).removeClass('choosez1');
                        if($(window).scrollTop() >= totalSc) {
                            $('.purchaseHelp_left_fix').addClass('choosez');
                        }else{
                            $('.purchaseHelp_left_fix').removeClass('choosez');
                        };
                    }

                });
                $('.purchaseHelp_left_li').on('click',function(e){
                    var _thisli = $('.purchaseHelp_left_li').index(this);
                    _thistxt = $('.purchaseHelp_right_tit').parent('.purchaseHelp_right_cont').eq(_thisli)
                    _thistit = $('.purchaseHelp_right_tit').parent('.purchaseHelp_right_cont').eq(_thisli).index();
                    $(this).addClass('choosez').siblings('.purchaseHelp_left_li').removeClass('choosez');
                    e.stopPropagation()
                    if (_thisli == _thistit ) {
                        $('html,body').animate({
                            scrollTop: _thistxt.offset().top - 30
                        }, 500);
                    }
                    // $(window).on("scroll",function () {return false;} )
                })

            })
        })


    </script>
<?php }else{?>
    <div class="page_nav">
        <div class="page_nav_con">
            <div class="big_title"><a><?php echo FS_HOW_TO_BY_1; ?></a>
            </div>
            <div class="short_title"><a href="<?php echo zen_href_link('how_to_buy');?>" class="title_selected"><?php echo FS_HOW_TO_BY_2; ?></a>
                <a href="index.php?main_page=password_forgotten"><?php echo FS_HOW_TO_BY_3; ?></a>
                <a href="<?php echo zen_href_link('faq');?>">FAQ</a><a href="<?php echo $code;?>/service_view_order_online.html"><?php echo FS_HOW_TO_BY_4; ?></a></div>
        </div>
    </div>
    <div class="Rec_banner">
        <div class="Rec_banner_bg Transceiver_banner_bg"></div>
        <h2 class="Rec_banner_tit"><?php echo FS_HOW_TO_BY_5; ?></h2>
        <p class="Rec_banner_txt"><?php echo FS_HOW_TO_BY_6; ?></p>
    </div>

    <div class="Pu_container">
        <h2 class="Pu_tit"><?php echo FS_HOW_TO_BY_7; ?></h2>
        <p class="Pu_txt"><?php echo FS_HOW_TO_BY_8; ?></p>
    </div>


    <div class="Rec_Stairs">
        <div class="Rec_Stairs_bg"></div>
        <div class="Rec_Stairs_position">
            <ul class="Rec_Stairs_ul Wdm_ul">
                <li class="active">
                    <dl class="Pu_dl">
                        <dt class="Pu_dt Pu_dt_one"></dt>
                        <dd><?php echo FS_HOW_TO_BY_9; ?></dd>
                    </dl>
                </li>
                <li>
                    <dl class="Pu_dl">
                        <dt class="Pu_dt Pu_dt_two"></dt>
                        <dd><?php echo FS_HOW_TO_BY_10; ?></dd>
                    </dl>
                </li>
                <li>
                    <dl class="Pu_dl">
                        <dt class="Pu_dt Pu_dt_three"></dt>
                        <dd><?php echo FS_HOW_TO_BY_11; ?></dd>
                    </dl>
                </li>
                <li>
                    <dl class="Pu_dl">
                        <dt class="Pu_dt Pu_dt_four"></dt>
                        <dd><?php echo FS_HOW_TO_BY_12; ?></dd>
                    </dl>
                </li>
                <li>
                    <dl class="Pu_dl">
                        <dt class="Pu_dt Pu_dt_five"></dt>
                        <dd><?php echo FS_HOW_TO_BY_13; ?></dd>
                    </dl>
                </li>
            </ul>
            <!--<a class="Rec_Stairs_a" href=""><i></i>DOWNLOAD WHITE PAPER</a>	-->
        </div>

    </div>

    <div class="Rec_Stairs_container">
        <ul class="Rec_Stairs_container_ul">
            <li>
                <div class="Pu_li_tit"><i></i><p><?php echo FS_HOW_TO_BY_14; ?></p></div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_15; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_16; ?></p>
                            <p><?php echo FS_HOW_TO_BY_17; ?><a href="<?php echo $code;?>/service_view_order_online.html"><?php echo FS_HOW_TO_BY_18; ?></a>&nbsp;<?php echo FS_HOW_TO_BY_19; ?></p>
                            <p><?php echo FS_HOW_TO_BY_20; ?><a href="<?php echo zen_href_link('manage_orders');?>"><?php echo FS_HOW_TO_BY_21; ?></a><?php echo FS_HOW_TO_BY_22; ?></p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_100;?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_99; ?><a href="<?php echo zen_href_link('manage_orders');?>"><?php echo FS_HOW_TO_BY_23; ?></a><?php echo FS_HOW_TO_BY_24; ?></p>
                            <p><?php echo FS_HOW_TO_BY_25; ?></p>
                        </dd>
                    </dl>
                </div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_26; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_27; ?></p>
                            <p><?php echo FS_HOW_TO_BY_28; ?></p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_29; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_30; ?></p>
                            <p><?php echo FS_HOW_TO_BY_31; ?><a href="<?php echo zen_href_link('manage_orders');?>"><?php echo FS_HOW_TO_BY_32; ?></a><?php echo FS_HOW_TO_BY_33; ?></p>
                        </dd>
                    </dl>
                </div>

            </li>

            <li>
                <div class="Pu_li_tit Pu_li_bg_two"><i></i><p><?php echo FS_HOW_TO_BY_34;?></p></div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_35; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_36; ?></p>
                            <p><?php echo FS_HOW_TO_BY_37; ?></p>
                            <p><?php echo FS_HOW_TO_BY_38; ?> <a href="<?php echo zen_href_link('payment_methods');?>"><?php echo FS_HOW_TO_BY_39; ?></a> <?php echo FS_HOW_TO_BY_40; ?></p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_41; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_42; ?><br><?php echo FS_HOW_TO_BY_42_1; ?><p><?php echo FS_HOW_TO_BY_43; ?>
                                <a href="<?php echo zen_href_link('partner');?>"><?php echo FS_HOW_TO_BY_44; ?></a>.</p>
                        </dd>
                    </dl>
                </div>
            </li>


            <li>
                <div class="Pu_li_tit Pu_li_bg_three"><i></i><p><?php echo FS_HOW_TO_BY_45; ?></p></div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_46; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_47; ?></p>
                            <p><?php echo FS_HOW_TO_BY_48; ?></p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_49; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_50; ?></p>
                            <p><?php echo FS_HOW_TO_BY_51; ?>
                                <a href="<?php echo zen_href_link('shipping_delivery');?>"><?php echo FS_HOW_TO_BY_52; ?></a><?php echo FS_HOW_TO_BY_53; ?></p>
                        </dd>
                    </dl>
                </div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_54; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_55; ?></p>
                            <p><?php echo FS_HOW_TO_BY_56; ?></p>
                            <p><?php echo FS_HOW_TO_BY_57; ?><a href="<?php echo zen_href_link('shipping_delivery');?>"><?php echo FS_HOW_TO_BY_58; ?></a> <?php echo FS_HOW_TO_BY_59; ?></p>
                        </dd>
                    </dl>
                </div>

            </li>
            <li>
                <div class="Pu_li_tit Pu_li_bg_four"><i></i><p><?php echo FS_HOW_TO_BY_60; ?></p></div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_61; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_62; ?></p>
                            <p><?php echo FS_HOW_TO_BY_63; ?><br>

                            <p> <?php echo FS_HOW_TO_BY_64; ?><a href="<?php echo zen_href_link('day_return_policy');?>"><?php echo FS_HOW_TO_BY_65; ?></a> and <a href="<?php echo zen_href_link('warranty');?>"><?php echo FS_HOW_TO_BY_66; ?></a>.</p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_67; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_68; ?></p>
                            <p><?php echo FS_HOW_TO_BY_69; ?><p><?php echo FS_HOW_TO_BY_70; ?><a href="<?php echo zen_href_link('day_return_policy');?>"><?php echo FS_HOW_TO_BY_71; ?></a>.</p></p>
                        </dd>
                    </dl>
                </div>

            </li>

            <li>
                <div class="Pu_li_tit Pu_li_bg_five"><i></i><p><?php echo FS_HOW_TO_BY_72; ?></p></div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_74; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_75; ?></p>
                            <p><?php echo FS_HOW_TO_BY_76; ?></p>
                            <p><?php echo FS_HOW_TO_BY_77; ?><a href="<?php echo zen_href_link('regist');?>"><?php echo FS_HOW_TO_BY_78; ?></a><?php echo FS_HOW_TO_BY_79; ?></p>
                        </dd>
                    </dl>
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_801; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_80; ?></p>
                            <p><?php echo FS_HOW_TO_BY_81; ?><a href="<?php echo zen_href_link('my_dashboard');?>"><?php echo FS_HOW_TO_BY_82; ?></a><?php echo FS_HOW_TO_BY_83; ?></p>
                        </dd>
                    </dl>
                </div>
                <div class="Pu_public">
                    <dl class="Pu_public_dl">
                        <dt><?php echo FS_HOW_TO_BY_84; ?></dt>
                        <dd>
                            <p><?php echo FS_HOW_TO_BY_85; ?></p>
                            <p><?php echo FS_HOW_TO_BY_86; ?><a href="<?php echo zen_href_link('password_forgotten');?>"><?php echo FS_HOW_TO_BY_87; ?></a><?php echo FS_HOW_TO_BY_88; ?></p>
                        </dd>
                    </dl>
                </div>

            </li>
        </ul>
    </div>

    <div class="Pu_bottom">
        <h2><?php echo FS_HOW_TO_BY_89; ?></h2>
        <p><?php echo FS_HOW_TO_BY_90; ?><a href="<?php echo zen_href_link('customer_service');?>"><?php echo FS_HOW_TO_BY_91; ?></a><?php echo FS_HOW_TO_BY_92; ?></p>
    </div>
    <script type="text/javascript">
        var $Height = $('.Rec_Stairs').height();
        var $width = $(window).width();
        var $top = $('.Rec_Stairs').offset().top;

        $('.Rec_Stairs_container_ul li').each(function(){
            var $ttop = $(this).offset().top;
            if(top>=$ttop-$Height){
                var index = $(this).index();
                $('.Rec_Stairs_ul li').eq(index).addClass('active').siblings().removeClass('active');
            }
        })


        //滚动后导航固定
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






        $('.Rec_Stairs_ul li').click(function(){

            var t = $(window).scrollTop();

            $this=$(this).index();
            var $top = $('.Rec_Stairs_container_ul li').eq($this).offset().top;

            if( t <= 500){
                $("body,html").animate({scrollTop:$top},500);
            }else{
                $("body,html").animate({scrollTop:$top-80},500);
            }
        })
    </script>
<?php }?>



