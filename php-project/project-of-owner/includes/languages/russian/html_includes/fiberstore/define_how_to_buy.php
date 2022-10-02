<?php
if($_SESSION['languages_id'] !=1){
    $code = '/'.$language_code;
}else{
    $code ='';
}
?>
<?php if(all_german_warehouse('country_code',$_SESSION['countries_iso_code'])){?>
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
                                    <li><?php echo FS_HOW_TO_BUY_12; ?><a href="index.php?main_page=login"><?php echo FS_HOW_TO_BUY_13; ?></a><?php echo FS_HOW_TO_BUY_14; ?><a href="index.php?main_page=regist"><?php echo FS_HOW_TO_BUY_15; ?></a>”.</li>
                                    <li><?php echo FS_HOW_TO_BUY_16; ?><a href="index.php?main_page=regist"><?php echo FS_HOW_TO_BUY_09; ?></a><?php echo FS_HOW_TO_BUY_17; ?></li>
                                </ul>
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_18; ?><a href="index.php?main_page=my_dashboard"><?php echo FS_HOW_TO_BUY_03; ?></a><?php echo FS_HOW_TO_BUY_19; ?> </p>
                            </div>
                        </div>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_21; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_22; ?> </p>
                                <ul class="hasDot_ul choosez">
                                    <li><b><a href="index.php?main_page=edit_my_account"> <?php echo FS_HOW_TO_BUY_23; ?></a></b><br/>
                                        <?php echo FS_HOW_TO_BUY_24; ?><a href="index.php?main_page=manage_orders"><?php echo FS_HOW_TO_BUY_25; ?></a>".</li>
                                    <li><b> <?php echo FS_HOW_TO_BUY_26; ?></b><br/>
                                        <?php echo FS_HOW_TO_BUY_27; ?> "<a href="index.php?main_page=edit_my_account"><?php echo FS_HOW_TO_BUY_23; ?></a>". <?php echo FS_HOW_TO_BUY_28; ?> "<a href="index.php?main_page=login"><?php echo FS_HOW_TO_BUY_29; ?></a>" <?php echo FS_HOW_TO_BUY_30; ?><?php echo FS_HOW_TO_BUY_32; ?></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_35; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_36; ?> "<a href="index.php?main_page=manage_addresses"><?php echo FS_HOW_TO_BUY_37; ?></a>". <?php echo FS_HOW_TO_BUY_38; ?> "<a href="index.php?main_page=my_dashboard"><?php echo FS_HOW_TO_BUY_03; ?></a>" <?php echo FS_HOW_TO_BUY_39; ?> </p>
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_40; ?></p>
                            </div>
                        </div>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_41; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_42; ?> </p>
                                <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_43; ?></p>
                                <ul class="hasDot_ul">
                                    <li><?php echo FS_HOW_TO_BUY_44; ?> "<a href="index.php?main_page=my_cases"><?php echo FS_HOW_TO_BUY_45; ?></a>".
                                    </li>
                                    <li><?php echo FS_HOW_TO_BUY_46; ?></li>
                                    <li><?php echo FS_HOW_TO_BUY_47; ?> "<a href="index.php?main_page=my_cases"><?php echo FS_HOW_TO_BUY_45; ?></a>".</li>
                                    <li><?php echo FS_HOW_TO_BUY_48; ?><a href="customer_service.html"><?php echo FS_HOW_TO_BUY_49; ?></a>".
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
                                <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_68; ?><a href="shipping_delivery.html"> <?php echo FS_HOW_TO_BUY_69; ?></a></p> 
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_76; ?> <a href="index.php? main_page=manage_orders"><?php echo FS_HOW_TO_BUY_77; ?></a> - <?php echo FS_HOW_TO_BUY_78; ?> </p>
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_84; ?> <a href="index.php?main_page=manage_orders"><?php echo FS_HOW_TO_BUY_77; ?></a>.</p>
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
                                <p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_89; ?> <a href="payment_methods.html"><?php echo FS_HOW_TO_BUY_90; ?></a>. </p>
                            </div>
                        </div>
						<div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_159; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_160; ?></p>
                                <p class="purchaseHelp_right_txt1 purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_161; ?></p>
								<p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_162; ?> <a href="shipping_delivery.html"><?php echo FS_HOW_TO_BUY_163; ?></a></p>
                            </div>
                        </div>
						<div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_164; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_165; ?></p>
                                <p class="purchaseHelp_right_txt1 purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_166; ?></p>
								<p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_167; ?></p>
								<p class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_168; ?> <a href="shipping_delivery.html"><?php echo FS_HOW_TO_BUY_169; ?></a></p>
                            </div>
                        </div>
						
						
						
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_91; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <ul class="hasDot_ul choosez">
                                    <li><b><?php echo FS_HOW_TO_BUY_92; ?></b><br/>
                                        <?php echo FS_HOW_TO_BUY_93; ?> ''<a href="index.php?main_page=manage_orders"><?php echo FS_HOW_TO_BUY_94; ?></a>'' <?php echo FS_HOW_TO_BUY_95; ?>
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_99; ?> <a href="partner.html"><?php echo FS_HOW_TO_BUY_100; ?></a>, <?php echo FS_HOW_TO_BUY_101; ?></p>
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
                                <p  class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_110; ?> <a href="shipping_delivery.html"><?php echo FS_HOW_TO_BUY_111; ?></a>. </p>
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_120; ?><a href="<?php echo zen_href_link('solution_support'); ?>"><?php echo FS_HOW_TO_BUY_121;?></a>. <?php echo FS_HOW_TO_BUY_122; ?> </p>
                            </div>
                        </div>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn">  <?php echo FS_HOW_TO_BUY_123; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_124; ?> </p>
                                <p  class="purchaseHelp_right_txt1"><?php echo FS_HOW_TO_BUY_125; ?> </p>
                                <p  class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_126; ?> "<a href=" index.php?main_page=inquiry_list"><?php echo FS_HOW_TO_BUY_127; ?></a>". <?php echo FS_HOW_TO_BUY_128; ?></p>
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_133; ?> "<a href="index.php?main_page=manage_orders"><?php echo FS_HOW_TO_BUY_77; ?></a>" <?php echo FS_HOW_TO_BUY_134; ?>   </p>
                            </div>
                        </div>
                    </div>
                    <div class="purchaseHelp_right_cont">
                        <h1 class="purchaseHelp_right_tit"><?php echo FS_HOW_TO_BUY_07; ?></h1>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"> <?php echo FS_HOW_TO_BUY_135; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_136; ?></p>
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_137; ?> <a href="day_return_policy.html"><?php echo FS_HOW_TO_BUY_138; ?></a> <?php echo FS_HOW_TO_BUY_139; ?></p>
                            </div>
                        </div>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn"><?php echo FS_HOW_TO_BUY_140; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_141; ?> </p>
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_142; ?> "<a href="warranty.html"><?php echo FS_HOW_TO_BUY_143; ?></a>" <?php echo FS_HOW_TO_BUY_144; ?></p>
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
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_152; ?> <a href="index.php?main_page=account_newsletters"><?php echo FS_HOW_TO_BUY_153; ?></a>.</p>
                            </div>
                        </div>
                        <div class="pur_qa_con">
                            <h3 class="purchaseHelp_right_tit1 relax_pbtn alone_padding_bottom"><?php echo FS_HOW_TO_BUY_154; ?><span class="icon iconfont">&#xf057;</span></h3>
                            <div class="pur_qa_con_main choosez">
                                <p class="purchaseHelp_right_txt"><?php echo FS_HOW_TO_BUY_155; ?> <a href="index.php?main_page=service_feedback"><?php echo FS_HOW_TO_BUY_156; ?></a> <?php echo FS_HOW_TO_BUY_157; ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
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
        <div class="big_title"><a><?php echo FS_HOW_1;?></a>
        </div>
        <div class="short_title"><a href="<?php echo zen_href_link(FILENAME_HOW_TO_BUY);?>" class="title_selected"><?php echo FS_HOW_2;?></a><a href="<?php echo zen_href_link(FILENAME_FAQ);?>"><?php echo FS_HOW_3;?></a></div>
      </div>
    </div>
    <div class="page_banner">
      <div class="page_banner_con purchase_banner">
        <div class="page_banner_text"><span><?php echo FS_HOW_HELP?></span><?php echo FS_HOW_WELCOME?></div>
      </div>
    </div>
    <div class="purchase_con">
      <div class="payment_title"><?php echo FS_HOW_METHOD?></div>
      <div class="fs_net_line">&nbsp;</div>
      <div class="purchase_list">
 <!-- 版块 开始 -->
<div class="bellows single">
  <div class="bellows__item">
    <h3><?php echo FS_HOW_ONLINE?></h3>
    <p><?php echo FS_HOW_FIVE?></p>
    <div class="bellows__content">
      <p><?php echo FS_HOW_ORDER?></p>
    </div>
     <div class="bellows__header"> </div>
  </div>
  <div class="bellows__item">
    <h3><?php echo FS_HOW_PURCHASE?></h3>
    <p><?php echo FS_HOW_PUR_IS?></p>
    <div class="bellows__content">
      <p> <?php echo FS_HOW_MAIL?><span><?php echo FS_HOW_PLEASE?></span></p>
    </div>
  <div class="bellows__header"> </div>
  </div>
  <div class="bellows__item">
    <h3><?php echo FS_HOW_PROFORMA?></h3>
    <p><?php echo FS_HOW_IF?></p>
    <div class="bellows__content">
      <p><?php echo FS_HOW_MESSAGE?></p>
    </div>
   <div class="bellows__header"> </div>
  </div>
</div>
<!-- 版块 结束 -->
      </div>
    </div>
    <div class="fs_net_line">&nbsp;</div>
    <div class="payment_con">
      <div class="payment_title"><?php echo FS_HOW_TO?></div>
      <div class="payment_text"><p><?php echo FS_HOW_SEND?><em><?php echo FS_HOW_NOTE?></em></p></div>
    </div>
    <div class="fs_net_line">&nbsp;</div>
    <div class="payment_con">
      <div class="payment_title"><?php echo FS_HOW_TIME?></div>
      <div class="payment_text">
        <p><?php echo FS_HOW_FIBERSTORE?> </p>
        <p><?php echo FS_HOW_FOLLOW?></p>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><?php echo FS_HOW_FEDEX?></td>
    <td  width="50%"><?php echo FS_HOW_FED_DAYS?></td>
  </tr>
  <tr>
    <td><?php echo FS_HOW_DHL?></td>
    <td><?php echo FS_HOW_DHL_DAYS?></td>
  </tr>
  <tr>
    <td><?php echo FS_HOW_EMS?></td>
    <td><?php echo FS_HOW_EMS_DAYS?></td>
  </tr>
  <tr>
    <td><?php echo FS_HOW_UPS?></td>
    <td><?php echo FS_HOW_UPS_DAYS?></td>
  </tr>
  <tr>
    <td><?php echo FS_HOW_HK?></td>
    <td><?php echo FS_HOW_HK_DAYS?></td>
  </tr>
</table><br />
<p><?php echo FS_HOW_WENSITE?> <a href="<?php echo $code;?>/shipping_delivery.html" target="_blank"><?php echo FS_HOW_GUIDE?></a> <?php echo FS_HOW_AND?> <a href="<?php echo zen_href_link(FILENAME_PAYMENT_METHODS);?>" target="_blank"><?php echo FS_HOW_PAYMWNT?></a>.</p>
      </div>
    </div>
<div class="fs_net_line">&nbsp;</div>
<div class="payment_con">
<div class="payment_title"><?php echo FS_HOW_SERVICE?></div>
<div class="payment_text"><p><?php echo FS_HOW_PROVIDE?></p>
<p><?php echo FS_HOW_WHAT?></p>
</div>
</div>
<!-- Include dependencies --> 
<script src="includes/templates/fiberstore/jscript/velocity.min.js"></script> 
<!-- Include bellows.js --> 
<script src="includes/templates/fiberstore/jscript/bellows.min.js"></script> 
<!-- Construct Bellows --> 
<script>$('.bellows').bellows({
	  singleItemOpen: true,
	  easing: 'ease-in-out',
	   duration: 600
})</script> 
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
<?php }?>