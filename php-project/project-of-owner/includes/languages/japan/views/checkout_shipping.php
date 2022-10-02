<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_shipping.php 4042 2006-07-30 23:05:39Z drbyte $
 */

define('NAVBAR_TITLE_1', 'チェックアウト');
define('NAVBAR_TITLE_2', '配送方法');

define('HEADING_TITLE', 'ステップ1/3 - 配送情報');

define('TABLE_HEADING_SHIPPING_ADDRESS', 'お届け先のアドレス');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'お客様の注文は左側に表示されたアドレスへ配送します。もしお届け先のアドレスを変更する場合この <em>アドレスを変更する</em> ボタンをクリックしてください。');
define('TITLE_SHIPPING_ADDRESS', '配送情報：');

define('TABLE_HEADING_SHIPPING_METHOD', '配送方法：');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'お客様の注文のために行き付け配送方法を選択してください。');
define('TITLE_PLEASE_SELECT', '選んでください');
define('TEXT_ENTER_SHIPPING_INFORMATION', '現在、これはご注文に適用された唯一の配送方法です。');
define('TITLE_NO_SHIPPING_AVAILABLE', '今回は無効です');
define('TEXT_NO_SHIPPING_AVAILABLE','<span class="alert">すみません、今、当社はお客様の地域に配送しておりません。</span><br />交互配列のために私たちとお問い合わせください。');

define('TABLE_HEADING_COMMENTS', 'ご注文について特記事項やコメント');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'ステップ2に進む');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- 配送方法を選択してください。');

// when free shipping for orders over $XX.00 is active
  define('FREE_SHIPPING_TITLE', '送料無料');
  define('FREE_SHIPPING_DESCRIPTION', '以上のご注文は送料無料です％s');
?>
