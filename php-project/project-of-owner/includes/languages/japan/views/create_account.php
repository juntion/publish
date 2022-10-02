<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 15405 2010-02-03 06:29:33Z drbyte $
 */

define('NAVBAR_TITLE', 'アカウントを新規する');

define('HEADING_TITLE', '私のアカウント情報');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">ご注意:</strong> もしお客様は既に当社のアカウントを持ちました場合、以下にログインしてください<a href="%s">ログインページ</a>.');




// greeting salutation
define('EMAIL_SUBJECT', 'ようこそ ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'お試しいただけます <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'おめでとう！お客様にもっと有意義な経験をもたらす次に当社のオンラインショップをお訪ねられるために、以下に記載されている割引クーポンをお客様に送り致します' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'この割引クーポンを使用するには、このコードが' . TEXT_GV_REDEEM . ' チェックアウト際に入力します:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>この割引クーポンの使用有効範囲は %s ～ %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', '今日が締め切り、我々は貴方に以下をお送りしました： %s!' . "\n");
define('EMAIL_GV_REDEEM', 'この ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' は: %s ' . "\n\n" . 'お客様は店舗に商品を選択した後、チェックアウト際に以下を入力してください ' . TEXT_GV_REDEEM . ' 。');
define('EMAIL_GV_LINK', ' または、今すぐに割引クーポンを買い上げるにはこのリンクをご利用ください: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','お客様は一度この' . TEXT_GV_NAME . 'をアカウントに追加すれば、この' . TEXT_GV_NAME . 'を自分で使用できます、または友人に送ります!' . "\n\n");

define('EMAIL_TEXT', 'お客様は当社の店舗に登録するとアカウント特権を持ちます:あなたのアカウントを利用してください、私たちはお客様にこの<strong>様々なサービス</strong>を提供しています。これらのサービスの中には:' . "\n\n<ul>" . '<li><strong>注文履歴</strong> - 当社の店舗に完成した注文の詳細を見ます。' . "\n\n" . '<li><strong>永久的なカート</strong> - お客様に追加されたオンラインカートのすべて製品について、お客様はこの製品を削除した限りに、またはチェックアウトした限りに消しておりません。' . "\n\n" . '<li><strong>アドレス帳</strong> - 我々はお客様の製品をご自分の住所以外のアドレスに配送できます!これは誕生日の贈り物を送る際に最適となります。.' . "\n\n" . '<li><strong>商品レビュー</strong> - 他の顧客に当社製品のご意見・ご感想をお寄せ下さい。' . "\n\n</ul>");
define('EMAIL_CONTACT', '当社のオンラインサービスに関する何か支援を必要とする場合、当社の店舗に電子メールをお送りします: <a href="メールアドレス:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE', "\n" . 'Sincerely,' . "\n\n" . STORE_OWNER . "\nご主人様\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'この電子メールアドレスは貴方または我々のお客様から取ります。もし貴方はアカウントをお持ちでない場合、またはこのメールは間違い投稿すれば、どうぞ、以下に送信します%s ');
