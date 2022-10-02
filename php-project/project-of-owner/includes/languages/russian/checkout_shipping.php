<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_shipping.php 4042 2006-07-30 23:05:39Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Оформить заказ');
define('NAVBAR_TITLE_2', 'Способ Доставки');

define('HEADING_TITLE', 'Шаг 1 из 3 - информация о доставке');

define('TABLE_HEADING_SHIPPING_ADDRESS', 'Адрес Доставки');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Ваш заказ будет отправлен на адрес слева или вы можете изменить адрес доставки, нажав на кнопку <em>Изменить Адрес</em>.');
define('TITLE_SHIPPING_ADDRESS', '
Информация О Доставке:');

define('TABLE_HEADING_SHIPPING_METHOD', 'Способ Доставки:');
define('TEXT_CHOOSE_SHIPPING_METHOD', ' Выберите, пожалуйста, предпочтительный способ доставки на этот заказ.');
define('TITLE_PLEASE_SELECT', 'Выберите, пожалуйста');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'В настоящее время это единственный способ доставки доступен для использования на данном заказе.');
define('TITLE_NO_SHIPPING_AVAILABLE', 'В данный момент недоступно');
define('TEXT_NO_SHIPPING_AVAILABLE','<span class="alert">К сожалению, мы не отправляем товары в ваш регион в данный момент.</span><br />Свяжитесь с нами для альтернативных механизмов, пожалуйста.');

define('TABLE_HEADING_COMMENTS', 'Специальные инструкции или комментарии по поводу Вашего заказа');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Перейдите к шагу 2');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- выберите способ оплаты.');

// when free shipping for orders over $XX.00 is active
  define('FREE_SHIPPING_TITLE', 'Бесплатная Доставка');
  define('FREE_SHIPPING_DESCRIPTION', 'Бесплатная доставка для заказов свыше %');
?>
