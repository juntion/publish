<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'ログイン');
define('NAVBAR_TITLE_2', 'パスワードを忘れた');

define('HEADING_TITLE', 'パスワードを忘れた');

define('TEXT_MAIN', '下にメールアドレスを入力すると、新しいパスワードが記載されたメールが送信されます。');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'エラー：当社のレコードにこの電子メールアドレスが見つかりませんでした。もう一度お試しください。');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - 新しいパスワード');
define('EMAIL_PASSWORD_REMINDER_BODY', 'A new password was requested from ' . $_SERVER['REMOTE_ADDR']  . '.' . "\n\n" . 'Your new password to \'' . STORE_NAME . '\' is:' . "\n\n" . '   %s' . "\n\nAfter you have logged in using the new password, you may change it by going to the 'My Account' area.");

define('SUCCESS_PASSWORD_SENT', '新しいパスワードがごメールアドレスに送信されました。');





/**********BOF PASSWORD_FORGOTTEN LANGUAGE************/
define('FIBERSTORE_NEW_PWD','FS.COMからの新しいパスワード');

define('FIBERSTORE_FORGOTTEN_RESET', 'パスワードをリセットする');

define('FIBERSTORE_FORGOTTEN_EMAIL', '*電子メールアドレス:');

define('FIBERSTORE_FORGOTTEN_SEND', ' 下にメールアドレスを入力すると、新しいパスワードが記載されたメールが送信されます。');

define('FIBERSTORE_FORGOTTEN_RETURN', 'ログインに戻る');

define('FIBERSTORE_FORGOTTEN_OR', 'または');

define('FIBERSTORE_FORGOTTEN_PLACE', 'オンラインで注文する');

define('FIBERSTORE_FORGOTTEN_TRACK', 'オンラインで注文を追跡する');

define('FIBERSTORE_FORGOTTEN_VIEW', '注文履歴を見る');

define('FIBERSTORE_FORGOTTEN_CREATE', 'お気に入り、希望品リストなどを作成する！');

define('FIBERSTORE_FORGOTTEN_MAKE', '希望品リストを使ってプロジェクト予算を作る');

define('FIBERSTORE_FORGOTTEN_SUPPORT', '技術チームのサポート');

define('FIBERSTORE_FORGOTTEN_HELP', 'ヘルプを求める？');

define('TEXT_LOGIN_GUARANTEED','保証！');

define('TEXT_LOGIN_HELP','ヘルプを求める？');

define('TEXT_LOGIN_OR','または');

define('FIBERSTORE_PWD_OF','FS.COMの新しいパスワード');

define('FIBERSTORE_A_NEWPWD','FS.COMアカウントの新しいパスワードは以下の通りです。');
define('FIBERSTORE_PWD_IS','新しいパスワードは: ');
define('FIBERSTORE_LOGGED_RECOMMEND','新しいパスワードを使用してログインした後、「私のアカウント」に移動してアカウント設定を入力して変更することをお勧めします。');
define('FIBERSTORE_FORGET_SINCERELY','どうぞ、宜しくお願いたします。');
define('FIBERSTORE_THANKS_AGAIN','FS.COMを選んで頂きありがとうございます。');
define('FIBERSTORE_FORGET_NOTE','ご注意ください:');
define('FIBERSTORE_SEND_EMAIL','このメールメッセージは、通知専用アドレスから送信されていますので、メールを受信できません。');
define('FIBERSTORE_NOT_REPLY','このメッセージには返信');
define('FIBERSTORE_CONTACT_US','しないでください。ご不明な点がございましたら、お問い合わせください。');
/**********EOF****************************************/






/*********************************/


define('TEXT_LOGIN_HELP_WITH','ヘルプを求める');

define('TEXT_LOGIN_RETURNING','返品');

define('TEXT_LOGIN_RMA','RMAソリューション');

define('TEXT_LOGIN_VIEW_THE','のページを見るか、');

define('TEXT_LOGIN_EMAIL','service@fiberstore.com');

define('TEXT_LOGIN_PAGE','まで電子メールで');

define('TEXT_LOGIN_CONTACT','お問い合わせください');

define('TEXT_VIEW_FAQ','FAQページを見る');

define('TEXT_LOGIN_QUESTIONS','配送と配達について質問がありますか？');

define('ACCOUNT_FOOTER_TITLE','買い物に保証がある');

define('ACCOUNT_FOOTER_SHOPPING','FS.COMでの買い物 ');

define('ACCOUNT_FOOTER_SECURE','は安全で保証があります。');

define('ACCOUNT_FOOTER_PAY','FS.COMで買い物をした結果、クレジットカードに不正な請求があった場合は、何も支払いません。');

define('ACCOUNT_FOOTER_SAFE','安全な買い物保証');

define('ACCOUNT_FOOTER_INFORMATION','すべての情報は暗号化され、SSL（セキュア ソケット レイヤー）プロトコルを使用して危険なく送信されます。');

define('ACCOUNT_FOOTER_HOW','私たちはどのようにお客様の個人情報を保護しますか？');

define('ACCOUNT_FOOTER_FREE','無料配送と無料返品');

define('ACCOUNT_FOOTER_SHOP','もしFS.COMからの購入に満足していない場合は、払い戻しのために7日以内に元の状態に戻すことができます。私たちは返品送料まで支払うこともあります！');

define('ACCOUNT_FOOTER_DELIVER','FS.COMは、心配のない購入環境を保証し、保証期間外の修理に伴う費用を削減するために、すべての主要製品ラインに標準機能としてライフタイム保証を提供しています。');

define('ACCOUNT_FOOTER_LEARN','もっと見るの？');
/**********************************/



// reason block
define('FS_PS_FORGOTTEN_WHY','ログインできない原因は何ですか？');
define('FS_PS_FORGOTTEN_REASON1','パスワードをお忘れた場合');
define('FS_PS_FORGOTTEN_REASON2','パスワードが知っていますが、うまくログインできない場合');
define('FS_PS_FORGOTTEN_REASON2_TIP','ヒント：ログインしようとしているアカウントをもう一度確認してください。時には、電子メールアドレスを誤って入力するかもしれません。また、アカウントに正しいドメイン（hotmail.com、live.com、またはoutlook.comなど）を使用してください。');
define('FS_PS_FORGOTTEN_REASON3','他人が私のアカウントを使用していると思った場合');
define('FS_PS_FORGOTTEN_REASON3_TIP','オプション：なぜ他人がFS.COMのごアカウントにアクセスできると思いますか？');
define('FS_PS_FORGOTTEN_REASON3_OPTION1','理由をお選びください');
define('FS_PS_FORGOTTEN_REASON3_OPTION2','他人が私のアカウントからメールを送信しています。');
define('FS_PS_FORGOTTEN_REASON3_OPTION3','最近の活動ページに異常なログイン表示があります。');
define('FS_PS_FORGOTTEN_REASON3_OPTION4','誰かが私のアカウントがハッカーに侵入されていたと言われました。');
define('FS_PS_FORGOTTEN_REASON3_OPTION5','私の許可していないアカウントで購入が表示されています。');
define('FS_PS_FORGOTTEN_REASON3_OPTION6','その他（説明してください）');
define('FS_PS_FORGOTTEN_REASON3_TEXTAREA','理由をご記入ください。');
define('FS_PS_FORGOTTEN_NEXT','次へ');

// tpl_password_forgotten_default.php
define('FS_PS_PROCESSING','処理中...');
define('FS_PS_RESET_MY_PASSWORD','パスワードをリセット');
define('FS_PS_BACK','戻る');
//define('FS_PS_ENTER_YOUR_EMAIL','Enter your email address below and we will send you an email message containing your new password.');
define('FS_PS_ENTER_YOUR_EMAIL','FSアカウントのメールアドレスをご入力ください。パスワードをリセットするための安全なリンクをご送信いたします。');
define('FS_PS_EMAIL_ADDRESS','電子メールアドレス:');
define('FS_PS_PLEASE_ENTER_ACCOUNT_MAIL','メールアドレスを入力してください。');
define('FS_PS_SUBMIT','提出する');
define('FS_PS_FORGOTTEN_ALSO','または:');
define('FS_PS_FORGOTTEN_REGISTER','新しいアカウントに登録するのか？');
define('FS_PS_FORGOTTEN_CONTACT','お問い合わせ？');

// error tip
define('FS_PS_FORGOTTEN_TIP_CHOOSE_REASON','理由を選んでください。');
define('FS_PS_FORGOTTEN_TIP_NOT_FIND_EMAIL','このメールはFSアカウントに紐付けられていませんので、別のメールをお試しください。');







?>
