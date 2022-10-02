<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_payment.php 4087 2006-08-07 04:46:08Z drbyte $
 */

define('NAVBAR_TITLE_1', 'チェックアウト - ステップ1');
define('NAVBAR_TITLE_2', 'お支払い方法 - ステップ2');

define('HEADING_TITLE', 'ステップ2/3 - 支払情報');

define('TABLE_HEADING_BILLING_ADDRESS', '請求先アドレス');
define('TEXT_SELECTED_BILLING_DESTINATION', 'あなたの請求先住所が左側に表示されます。この請求先住所はあなたのクレジットカードの明細書の住所と一致する必要があります、ご確認ください。<em>住所変更</ em>ボタンをクリックして請求先住所が変更できます。');
define('TITLE_BILLING_ADDRESS', '請求先アドレス:');

define('TABLE_HEADING_PAYMENT_METHOD', 'お支払い方法');
define('TEXT_SELECT_PAYMENT_METHOD', 'この注文の支払い方法を選んでください。');
define('TITLE_PLEASE_SELECT', '選択してください');
define('TEXT_ENTER_PAYMENT_INFORMATION', '');
define('TABLE_HEADING_COMMENTS', '特記事項や注文備考');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', '今回は利用できません');
define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE','<span class="alert">申し訳ございません、現時点には、お客様の地域がこの支払い方法を受け取りません。</span><br />交互配列のためにお問い合わせください。');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>ステップ3に進む</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- ご注文を確認します。');

define('TABLE_HEADING_CONDITIONS', '<span class="termsconditions">利用規約</span>');
define('TEXT_CONDITIONS_DESCRIPTION', '<span class="termsdescription">この注文に付随する利用規約をご確認いただくと、ボタンが押せるようになります。利用規約をご覧ください <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_CONDITIONS_CONFIRM', '<span class="termsiagree">この注文の利用規約を読む上に同意しました。</span>');

define('TEXT_CHECKOUT_AMOUNT_DUE', '総合計： ');
define('TEXT_YOUR_TOTAL','あなたの合計');
?>