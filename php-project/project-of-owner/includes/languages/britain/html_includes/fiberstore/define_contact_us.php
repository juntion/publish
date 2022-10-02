<div class="alone-page-banner">
    <div class="alone-page-banner-font">
        <h2><?php echo FS_CONTACT_01; ?></h2>
    </div>
</div>
<div class="alone-page-content">
    <div class="alone-page-content-main">
        <div class="alone-page-content-left">
            <ul class="alone-page-public-nav-pc-ul">
                <li>
                    <a href="<?php echo reset_url('company/about_us.html')?>"><?php echo FS_HEADER_ABOUT_US;?></a>
                </li>
                <li>
                    <a href="<?php echo reset_url('company/why_us.html');?>"><?php echo FS_FOOTER_WHY_US;?></a>
                </li>
                <li>
                    <a class="active" href="javascript:;"><?php echo FS_HEADER_CONTACT_US;?></a>
                    <div class="alone-page-content-left-m-line"></div>
                </li>
            </ul>
            <ul class="alone-page-public-nav-m-ul">
                <li>
                    <a class="active" href="javascript:;"><?php echo FS_HEADER_CONTACT_US;?></a>
                    <div class="alone-page-content-left-m-line"></div>
                </li>
                <li>
                    <a href="<?php echo reset_url('company/about_us.html')?>"><?php echo FS_HEADER_ABOUT_US;?></a>
                </li>
                <li>
                    <a href="<?php echo reset_url('company/why_us.html');?>"><?php echo FS_FOOTER_WHY_US;?></a>
                </li>
            </ul>
        </div>
        <div class="alone-page-content-right">
            <h2 class="alone-page-content-right-tit"><?php echo FS_CONTACT_LOCATIONS; ?></h2>
            <p class="fs-contact-us-txt"><?php echo FS_CONTACT_WELCOME; ?></p>
            <?php echo $warehouse_map_html; ?>
            <div class="fs-contact-us-need">
                <h3 class="alone-page-content-right-tit"><?php echo FS_CONTACT_46; ?></h3>
                <div class="fs-contact-us-need-dl-container">
                    <dl class="fs-contact-us-need-dl">
                        <dt>
                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/Single_page/fs-new/icon_36px_red_chat.svg"
                                 alt="Fs about_us_3.svg">
                        </dt>
                        <dd>
                            <h5 class="fs-contact-us-need-tit"><?php echo FS_CONTACT_47; ?></h5>
                            <p class="fs-contact-us-need-txt"><?php echo FS_CONTACT_48; ?></p>
                            <a href="javascript:;" onclick="LC_API.open_chat_window();return false;">
                                <span class="fs-contact-us-need-more">
	                        					<span><?php echo FS_CONTACT_49; ?></span>
	                        					<i class="iconfont icon">&#xf089;</i>
	                        				</span>
                            </a>
                        </dd>
                    </dl>
                    <dl class="fs-contact-us-need-dl">
                        <dt>
                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>/includes/templates/fiberstore/images/specials/Single_page/fs-new/icon_36px_red_email.svg"
                                 alt="Fs business16.svg">
                        </dt>
                        <dd>
                            <h5 class="fs-contact-us-need-tit"><?php echo FS_CONTACT_20; ?></h5>
                            <p class="fs-contact-us-need-txt"><?php echo FS_CONTACT_GET_SUPPORT; ?></p>
                            <a class="about_us_a"
                               href="<?php echo reset_url('live_chat_service_mail.html', '', 'SSL', true); ?>">
                                <span class="fs-contact-us-need-more">
	                        					<span><?php echo FS_CONTACT_54; ?></span>
	                        					<i class="iconfont icon">&#xf089;</i>
	                        				</span>
                            </a>
                        </dd>
                    </dl>
                    <dl class="fs-contact-us-need-dl">
                        <dt>
                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>includes/templates/fiberstore/images/specials/Single_page/fs-new/icon_36px_red_Feedback.svg"
                                 alt="Fs about_us_1.svg">
                        </dt>
                        <dd>
                            <h5 class="fs-contact-us-need-tit"><?php echo FS_CONTACT_55; ?></h5>
                            <p class="fs-contact-us-need-txt"><?php echo FS_CONTACT_56; ?></p>
                            <a class="about_us_a" href="<?php echo reset_url('solution_support.html'); ?>">
                                <span class="fs-contact-us-need-more">
	                        					<span><?php echo FS_CONTACT_57; ?></span>
	                        					<i class="iconfont icon">&#xf089;</i>
	                        				</span>
                            </a>
                        </dd>
                    </dl>
                    <dl class="fs-contact-us-need-dl">
                        <dt>
                            <img src="<?php echo HTTPS_IMAGE_SERVER; ?>/includes/templates/fiberstore/images/specials/Single_page/fs-new/icon_36px_red_Support.svg"
                                 alt="Fs become_aSupplier.svg">
                        </dt>
                        <dd>
                            <h5 class="fs-contact-us-need-tit"><?php echo FS_CONTACT_58; ?></h5>
                            <p class="fs-contact-us-need-txt"><?php echo FS_CONTACT_59; ?></p>
                            <a href="javascript:;" id="click_feedback_01">
                                <span class="fs-contact-us-need-more">
	                        					<span><?php echo FS_CONTACT_60; ?></span>
	                        					<i class="iconfont icon">&#xf089;</i>
	                        				</span>
                            </a>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>