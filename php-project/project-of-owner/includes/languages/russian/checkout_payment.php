<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_payment.php 4087 2006-08-07 04:46:08Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Оформить Заказ - Шаг 1');
define('NAVBAR_TITLE_2', 'Способ Оплаты - Шаг 2');

define('HEADING_TITLE', 'Шаг 2 из 3 - информация оплаты');

define('TABLE_HEADING_BILLING_ADDRESS', 'Биллинг Адрес');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Ваш платежный адрес показан слева. Биллинг адрес должен совпадать с адресом в выписке по кредитной карте. Вы можете изменить платежный адрес, нажав кнопку <em>Изменить Адрес</em>.');
define('TITLE_BILLING_ADDRESS', 'Биллинг Адрес:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Способ Оплаты');
define('TEXT_SELECT_PAYMENT_METHOD', 'Выберите способ оплаты для этого заказа, пожалуйста.');
define('TITLE_PLEASE_SELECT', 'Выберайте, пожалуйста ');
define('TEXT_ENTER_PAYMENT_INFORMATION', '');
define('TABLE_HEADING_COMMENTS', 'Специальные Инструкции или Комментарии Заказа');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', 'Нет В Наличии В Данный Момент');
define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE','<span class="alert">К сожалению, мы не принимаем платежи от Вашего региона в это время.</span><br />Свяжитесь с нами для альтернативных механизмов, пожалуйста.');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Перейдите к шагу 3</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- для подтверждения заказа.');

define('TABLE_HEADING_CONDITIONS', '<span class="termsconditions">Условия</span>');
define('TEXT_CONDITIONS_DESCRIPTION', '<span class="termsdescription"> Подтвердите, пожалуйста, Условия привязанные к настоящему приказу, поставив галочку в следующем окне. Условия читать <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '"><span class="pseudolink">здесь</span></a>.');
define('TEXT_CONDITIONS_CONFIRM', '<span class="termsiagree">Я ознакомился и согласен с условиями привязанными к настоящему приказу.</span>');

define('TEXT_CHECKOUT_AMOUNT_DUE', 'Общая Сумма: ');
define('TEXT_YOUR_TOTAL','Ваш Итог');
?>