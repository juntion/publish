<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 15405 2010-02-03 06:29:33Z drbyte $
 */

define('NAVBAR_TITLE', 'Создать Аккаунт');

define('HEADING_TITLE', 'Информация Моего Аккаунта ');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTE:</strong> Если у вас уже есть аккаунт с нами,  войдите, пожалуйста, на<a href="%s"> страницу входа</a>.');




// greeting salutation
define('EMAIL_SUBJECT', 'Добро пожаловать' . STORE_NAME);
define('EMAIL_GREET_MR', 'Уважаемый %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Уважаемая %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Уважаемые %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'Мы хотим приветствовать Вас на <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Поздравляем вас! Чтобы сделать ваш следующий визит в наш онлайн магазин более полезным опытом, ниже перечисленые реквизиты для купон на скидку созданы именно для вас!' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'Чтобы использовать купон на скидку, введите' . TEXT_GV_REDEEM . ' код во время оформления заказа:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Купон действует между %s и %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Просто зашел сегодня, мы отправили вам ' . TEXT_GV_NAME . ' для %s!' . "\n");
define('EMAIL_GV_REDEEM', 'этот ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' является: %s ' . "\n\n" . 'Вы можете ввести ' . TEXT_GV_REDEEM . ' во время оформления заказа, после выбора в магазине. ');
define('EMAIL_GV_LINK', ' Или, вы можете выкупить его прямо сейчас по этой ссылке: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','После того как вы добавили ' . TEXT_GV_NAME . ' на ваш счет, вы можете использовать ' . TEXT_GV_NAME . ' для себя или отправить его другу!' . "\n\n");

define('EMAIL_TEXT', 'Теперь вы зарегистрированы на сайте нашего магазина и приобрестили привилегии учетной записи:   с вашей учетной записи вы можете теперь принимать участие в <strong>various services</strong> мы должны предложить вам. Некоторые из этих много сервисов включают в себя:' . "\n\n<ul>" . '<li><strong>Order History</strong> - Посмотрите детали заказоа, которые вы прошли с нами.' . "\n\n" . '<li><strong>Permanent Cart</strong> - Любые товары, добавленные в ваш онлайн корзину, остаются там до тех пор, пока вы их не удалите или оплатите их.' . "\n\n" . '<li><strong>Address Book</strong> - Мы можем доставить ваши товары по адресу других, а не по вашему! Это идеальный вариант, чтобы отправить подарки прямо людям на день рождения самим.' . "\n\n" . '<li><strong>Обзоры Продукции</strong> - Поделитесь своими мнениями о нашей продукции с другими клиентами.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'Любые онлайн-сервисы, желающие оказать нам помощи, напишите почту магазин-владельцу, пожалуйста: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'С уважением,' . "\n\n" . STORE_OWNER . "\nВладелец Магазина\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Этот адрес электронной почты нам была дана вами или одним из наших клиентов. Если Вы не зарегистрированы, или вам кажется, что получили данное письмо по ошибке, отправьте, пожалуйста, письмо на %s ');
define('EXSIT_EMAIL_ADDRESS','Наша система уже есть запись этого адреса электронной почты - попробуйте войти посредством этого адреса электронной почты, пожалуйста. <br /> Если вы больше не используете этот адрес, вы можете исправить его в Мой Аккаунт.
');