<?php /** * how to buy * add 2017.9.15.ternence */?>
  <script>//滚动后导航固定
    $(function() {
      $(window).scroll(function() {
        height = $(window).scrollTop();
        if (height > 170) {
          $('.page_nav').fadeIn();
        } else {
          $('.page_nav').stop(true).hide();
        };

      });
    });</script>
  <div class="page_nav">
      <div class="page_nav_con">
        <div class="big_title"><a><?php echo FS_FOOTER_QUICK_HELP;?></a>
        </div>
        <div class="short_title"><a class="title_selected" href="<?php echo zen_href_link(FILENAME_SAMPLE_APPLICATION);?>"><?php echo FS_FOOTER_REQUEST_A_SAMPLE;?></a><a href="<?php echo zen_href_link(FILENAME_HOW_TO_BUY);?>"><?php echo FS_FOOTER_PURCHASE_HELP;?></a><a  href="<?php echo zen_href_link(FILENAME_FAQ);?>"><?php echo FS_FOOTER_FAQ;?></a></div>
      </div>
  </div>
  <div class="Rec_banner">
    <div class="Rec_banner_bg Transceiver_banner_bg"></div>
    <h2 class="Rec_banner_tit">
      <?php echo FS_HOW_TO_BY_5; ?></h2>
    <p class="Rec_banner_txt">
      <?php echo FS_HOW_TO_BY_6; ?></p>
  </div>
  <div class="Pu_container">
    <h2 class="Pu_tit">
      <?php echo FS_HOW_TO_BY_7; ?></h2>
    <p class="Pu_txt">
      <?php echo FS_HOW_TO_BY_8; ?></p>
  </div>
  <div class="Rec_Stairs">
    <div class="Rec_Stairs_bg"></div>
    <div class="Rec_Stairs_position">
      <ul class="Rec_Stairs_ul Wdm_ul">
        <li class="active">
          <dl class="Pu_dl">
            <dt class="Pu_dt Pu_dt_one"></dt>
            <dd>
              <?php echo FS_HOW_TO_BY_9; ?></dd>
          </dl>
        </li>
        <li>
          <dl class="Pu_dl">
            <dt class="Pu_dt Pu_dt_two"></dt>
            <dd>
              <?php echo FS_HOW_TO_BY_10; ?></dd>
          </dl>
        </li>
        <li>
          <dl class="Pu_dl">
            <dt class="Pu_dt Pu_dt_three"></dt>
            <dd>
              <?php echo FS_HOW_TO_BY_11; ?></dd>
          </dl>
        </li>
        <li>
          <dl class="Pu_dl">
            <dt class="Pu_dt Pu_dt_four"></dt>
            <dd>
              <?php echo FS_HOW_TO_BY_12; ?></dd>
          </dl>
        </li>
        <li>
          <dl class="Pu_dl">
            <dt class="Pu_dt Pu_dt_five"></dt>
            <dd>
              <?php echo FS_HOW_TO_BY_13; ?></dd>
          </dl>
        </li>
      </ul>
      <!--<a class="Rec_Stairs_a" href=""><i></i>DOWNLOAD WHITE PAPER</a>	--></div>
  </div>
  <div class="Rec_Stairs_container">
    <ul class="Rec_Stairs_container_ul">
      <li>
        <div class="Pu_li_tit">
          <i>
          </i>
          <p>
            <?php echo FS_HOW_TO_BY_14; ?></p>
        </div>
        <div class="Pu_public">
		  <dl class="Pu_public_dl">
            <dt><?php echo FS_HOW_TO_BY_93;?></dt>
            <dd><?php echo $code.'/';?>
              <p><?php echo FS_HOW_TO_BY_94;?><a href="<?php echo $code.'/';?>">www.fs.com</a>. <?php echo FS_HOW_TO_BY_95;?></p>
              <p><?php echo FS_HOW_TO_BY_96;?></p>
              <p><?php echo FS_HOW_TO_BY_97;?><a href="<?php echo $code.'/';?>"><?php echo FS_HOW_TO_BY_98;?></a>.</p>
            </dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_15; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_16; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_17; ?>
                  <a href="index.php?main_page=manage_orders">
                    <?php echo FS_HOW_TO_BY_18; ?>
              <p>
                <?php echo FS_HOW_TO_BY_20; ?>.</p>
            </dd>
          </dl>
        </div>
        <div class="Pu_public">
		  <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_100;?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_99; ?>
                  <a href="<?php echo zen_href_link('manage_orders','','SSL');?>">
                    <?php echo FS_HOW_TO_BY_23; ?></a>
                  <?php echo FS_HOW_TO_BY_24; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_25; ?></p>
            </dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_26; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_27; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_28; ?></p>
            </dd>
          </dl>
        </div>
		<div class="Pu_public">
		  <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_29; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_30; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_31; ?>
                  <a href="<?php echo zen_href_link('manage_orders','','SSL');?>">
                    <?php echo FS_HOW_TO_BY_32; ?></a>
                  <?php echo FS_HOW_TO_BY_33; ?></p>
            </dd>
          </dl>
		</div>
      </li>
      <li>
        <div class="Pu_li_tit Pu_li_bg_two">
          <i>
          </i>
          <p>
            <?php echo FS_HOW_TO_BY_34;?></p>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_35; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_36; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_37; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_38; ?>
                  <a href="<?php echo zen_href_link('payment_methods','','SSL',true);?>">
                    <?php echo FS_HOW_TO_BY_39; ?></a>.</p>
            </dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_41; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_42; ?>
                  <br>
                  <?php echo FS_HOW_TO_BY_42_1; ?>
                    <p>
                      <?php echo FS_HOW_TO_BY_43; ?>
                        <a href="<?php echo zen_href_link('partner','','SSL',true);?>">
                          <?php echo FS_HOW_TO_BY_44; ?></a>.</p>
            </dd>
          </dl>
        </div>
      </li>
      <li>
        <div class="Pu_li_tit Pu_li_bg_three">
          <i>
          </i>
          <p>
            <?php echo FS_HOW_TO_BY_45; ?></p>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_46; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_47; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_48; ?></p>
            </dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_49; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_50; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_51; ?>
                  <a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>">
                    <?php echo FS_HOW_TO_BY_52; ?></a>.</p>
            </dd>
          </dl>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_54; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_55; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_56; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_57; ?>
                  <a href="<?php echo zen_href_link('shipping_delivery','','SSL',true);?>">
                    <?php echo FS_HOW_TO_BY_58; ?></a>.</p>
            </dd>
          </dl>
        </div>
      </li>
      <li>
        <div class="Pu_li_tit Pu_li_bg_four">
          <i>
          </i>
          <p>
            <?php echo FS_HOW_TO_BY_60; ?></p>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_61; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_62; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_63; ?>
                  <br>
                  <p>
                    <?php echo FS_HOW_TO_BY_64; ?>
                      <a href="<?php echo zen_href_link('day_return_policy','','SSL',true);?>">
                        <?php echo FS_HOW_TO_BY_65; ?></a> <?php echo FS_HOW_TO_BY_AND;?>
                      <a href="<?php echo zen_href_link('warranty','','SSL',true);?>">
                        <?php echo FS_HOW_TO_BY_66; ?></a>.</p></dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_67; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_68; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_69; ?>
                  <p>
                    <?php echo FS_HOW_TO_BY_70; ?>
                      <a href="<?php echo zen_href_link('day_return_policy','','SSL',true);?>">
                        <?php echo FS_HOW_TO_BY_71; ?></a>.</p>
              </p>
            </dd>
          </dl>
        </div>
      </li>
      <li>
        <div class="Pu_li_tit Pu_li_bg_five">
          <i>
          </i>
          <p>
            <?php echo FS_HOW_TO_BY_72; ?></p>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_74; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_75; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_76; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_77; ?>
                  <a href="<?php echo zen_href_link('regist','','SSL');?>">
                    <?php echo FS_HOW_TO_BY_78; ?></a>
                  <?php echo FS_HOW_TO_BY_79; ?></p>
            </dd>
          </dl>
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_801; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_80; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_81; ?>
                  <a href="<?php echo zen_href_link('my_dashboard','','SSL');?>">
                    <?php echo FS_HOW_TO_BY_82; ?></a>
                  <?php echo FS_HOW_TO_BY_83; ?></p>
            </dd>
          </dl>
        </div>
        <div class="Pu_public">
          <dl class="Pu_public_dl">
            <dt>
              <?php echo FS_HOW_TO_BY_84; ?></dt>
            <dd>
              <p>
                <?php echo FS_HOW_TO_BY_85; ?></p>
              <p>
                <?php echo FS_HOW_TO_BY_86; ?>
                  <a href="<?php echo zen_href_link('password_forgotten','','SSL',true);?>">
                    <?php echo FS_HOW_TO_BY_87; ?></a>
                  <?php echo FS_HOW_TO_BY_88; ?></p>
            </dd>
          </dl>
        </div>
      </li>
    </ul>
  </div>
 
  <script type="text/javascript">$('.Wdm_ul li').click(function() {
      $(this).addClass('active').siblings().removeClass('active');
    }); var $Height = $('.Rec_Stairs').height();
    var $width = $(window).width();
    var $top = $('.Rec_Stairs').offset().top;

    $('.Rec_Stairs_container_ul li').each(function() {
      var $ttop = $(this).offset().top;
      if (top >= $ttop - $Height) {
        var index = $(this).index();
        $('.Rec_Stairs_ul li').eq(index).addClass('active').siblings().removeClass('active');
      }
    })

    //滚动后导航固定
    $(function() {
      $(window).scroll(function() {
        height = $(window).scrollTop();
        if (height > 170) {
          $('.page_nav').fadeIn();
        } else {
          $('.page_nav').stop(true).hide();
        };

      });
    });

    $('.Rec_Stairs_ul li').click(function() {

      var t = $(window).scrollTop();

      $this = $(this).index();
      var $top = $('.Rec_Stairs_container_ul li').eq($this).offset().top;

      if (t <= 500) {
        $("body,html").animate({
          scrollTop: $top
        },
        500);
      } else {
        $("body,html").animate({
          scrollTop: $top - 80
        },
        500);
      }
    })</script>