<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tell_a_friend.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'お友達に知らせる');

define('HEADING_TITLE', '以下に内容をお友達に知らせる \'%s\'');

define('FORM_TITLE_CUSTOMER_DETAILS', 'あなたの詳細');
define('FORM_TITLE_FRIEND_DETAILS', 'お友達の詳細');
define('FORM_TITLE_FRIEND_MESSAGE', 'あなたのメッセージ:');

define('FORM_FIELD_CUSTOMER_NAME', 'お名前：');
define('FORM_FIELD_CUSTOMER_EMAIL', 'ご自分の電子メール：');
define('FORM_FIELD_FRIEND_NAME', 'お友達の名前：');
define('FORM_FIELD_FRIEND_EMAIL', 'お友達の電子メール：');

define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'お客様には <strong>%s</strong> に関係する電子メールが以下に発送されました<strong>%s</strong>.');

define('EMAIL_TEXT_HEADER','重要事項!');

define('EMAIL_TEXT_SUBJECT', 'お友達 %s はこの素晴らしい製品を推薦します %s');
define('EMAIL_TEXT_GREET', 'Hi %s!' . "\n\n");
define('EMAIL_TEXT_INTRO', 'お友達 %s はあなたがこの％sに興味があると思いました %s.');

define('EMAIL_TELL_A_FRIEND_MESSAGE','%s メモを送る：');

define('EMAIL_TEXT_LINK', 'この商品を見るには、以下のリンクをクリックしてください、またアドレスをコピーしてブラウザのアドレス欄へ貼り付けます:' . "\n\n" . '%s');
define('EMAIL_TEXT_SIGNATURE', 'よろしくお願いします,' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'エラー：お友達の電子メールは空白にすることはできません');
define('ERROR_TO_ADDRESS', 'エラー：お友達の電子メールアドレスは有効ではありません。再度お試しください。');
define('ERROR_FROM_NAME', 'エラー：お名前は空白にすることはできません');
define('ERROR_FROM_ADDRESS', 'エラー：お客様の電子メールアドレスは有効ではありません。再度お試しください。');
?>
