<?php

  define('FOOTER_TEXT_BODY', 'Copyright＆Copy; ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. 供給する
 <a href="http://www.zen-cart.cn" target="_blank">Zen Cart</a>');
  define('FIBERSTORE_ALL_RIGHTS_RESERVED','はすべての権利を保有します。');
  /*bof language for my_account*/
  define('FIBERSTORE_ORDER_HELLO','こんにちは！ ');
  //define('FIBERSTORE_CDN_IMAGES','https://d2gwt4r5cjfqmi.cloudfront.net/');
  define('FIBERSTORE_CDN_IMAGES','images/');
  define('FIBERSTORE_ORDER_LOGIN_AS',' テーマ ');
  define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> News )');
  define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Show <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> Tutorial )');
  /*eof*/

  //夏令时--冬令时
  define('SUMMER_TIME',true);
  if(SUMMER_TIME){
      //define('FS_SUMMER_OR_WINTER_TIME','3:30pm (UTC/GMT+1)');
      define('FS_CHECKOUT_TIME','4:30pm UTC/GMT+2');
  }else{
      //define('FS_SUMMER_OR_WINTER_TIME','3:00pm (UTC/GMT)');
      define('FS_CHECKOUT_TIME','午後4時UTC/GMT+1');
  }

  @setlocale(LC_TIME, 'en_US.UTF-8');
  define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
  define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
  define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
  define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
 // define('FIBERSTORE_REGIST_ERROR','Our system already has a record of that email address - please try logging in with that email address. If you do not use that address any longer you can correct it in the My Account area.');

  //装箱页面新增
  define("FS_PRODUCT_INFO_SIZE","パッケージ:");
  define("FS_PRODUCT_INFO_PIECE","1個");
  define("FS_PRODUCT_INFO_CASE","ケースで注文する(");
  define("FS_PRODUCT_INFO_PIS","個/箱");
  define("FS_PRODUCT_INFO_PIS_1","個/");

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
				</a>		
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Data-Center-Products.html').'">データセンター</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html').'">企業ネットワーク</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/ISP-Networks.html').'">光伝送ネットワーク</a>
			</div>');
define('EMAIL_FOOTER_INFO','

			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">ショッピング体験を私達に共有しましょう <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="'.zen_href_link('index').'">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('contact_us').'">お問い合わせ</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('account_newsletters').'">マイアカウント</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('shipping_delivery').'">出荷 & 配達</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'">返品規則</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">$user_email としてこのメールを購読しています。</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="'.zen_href_link('account_newsletters').'">ここをクリックして、ご設定を変更するか、または購読を解除することができます。</a>
			</div>');


/* 产品、分类公用 */
define('FS_CUSTOMILIZED_ADD_TO_CART','カートに入れる');
define('FS_ADD_TO_CART', 'カートに入れる');
define('CATEGORIES_HEADING_DETAILS','商品詳細を見る');
define('FS_VIEW_CART', 'カートを見る');
define('FS_REVIEWS', 'レビュー');
define('FS_REVIEWS_SMALL', 'レビュー');
define('FS_REVIEW', 'レビュー');
define('FS_SHARE', 'シェアする');
define('FS_NEED_HELP', 'ヘルプを求める');
define('FS_COMPATIBLE', '互換性');
define('FS_LENGTH', '長さ');
define('FS_TOTAL_LENGTH', '全長');
define('FS_CUSTOM_LENGTH', 'カスタマイズ長さ');
define('FS_CUSTOM', 'カスタマイズ');
define('FS_SHIPPING_COST', '送料');
define('FS_SHIP_SAME_DAY', '即日出荷');
define('FS_SHIP_NEXT_DAY', '翌日予定');
define('FS_OUT_OF_STOCK', '在庫切れ');
define('FS_DELETE_PRODUCT', 'この商品を削除します');
define('FS_AVAILABILTY', '在庫情報');
define('PRODUCT_INFO_ADD','追加する');
define('PRODUCT_INFO_ADDED','追加された');
define('FS_ADD','追加する');
define('FS_ADDED','追加された');
//products移动公共文件
define('FS_PRODUCTS_ORDERS_RECEIVED','太平洋標準時により月曜日～金曜日の午後1時後のご注文（休日以外）は翌営業日配送予定です，ご了承お願いします。');
define('FS_PRODUCTS_ACTUAL_TIME','実際日は予定日と少々相違しております、ご了承ください。');

define('F_BODY_HEADER_GS','グローバル配送');
define('F_BODY_HEADER_ITEM','アイテム');
define('F_BODY_HEADER_ITEM_TWO','アイテム');
define('F_BODY_HEADER_ITEMS','点');
define('BOX_HEADING_SEARCH','検索する');
define('FS_TRANSCEIVER_TYPE', 'トランシーバーのタイプ');

define('FS_QUICK_VIEW', '商品クイックビュー');
define('FS_WAIT', '少々お待ちください');
/* 放到公用文件 */


 /* 搜索相关 */
define('FIBERSTORE_IMAGES','画像');
define('FIBERSTORE_DETAILS','詳細');
define('FIBERSTORE_SHOWING','表示');
define('FIBERSTORE_OF','の');
define('FIBERSTORE_RESULTS_BY',' 結果');
define('FIBERSTORE_YOUR_PRICE','価格');
define('FIBERSTORE_QUANTITY','数量');
define('FIBERSTORE_ADD_TO_CART','カートにいれる');
/* end 搜索 */

/* 购物车层 */
define('FIBERSTORE_REMOVE','削除する');
define('FIBERSTORE_CART_TOTAL','ショッピングカート一覧');
define('FIBERSTORE_EDITE_ORDER','カート一覧');
define('FIBERSTORE_CHECK_YOU_ORDER','決済へ進む');
define('FIBERSTORE_SHOPPING_HELP','ショッピングカートに商品が入っていません。');
define('FS_PROCEED_TO_CHECKOUT','購入する');
define('FS_ITEMS','アイテム');
define('FS_CART','カート');
define('FS_VIEW_ALL','すべて見る');
define('FS_FILTER', 'フィルター');
/* end 购物车 */

//module shipping   运费模块
define('FS_SHIP_ORDER','お届け先');
define('FS_CHOOSE_SHIP','配送方法を選んでください');

 define('ACCOUNT_EDIT_FOOTER_TITLE','購買には保障がある');

 define('ACCOUNT_EDIT_FOOTER_SHOPPING','FS.COMにショッピングする');

 define('ACCOUNT_EDIT_FOOTER_SECURE','安全とも保障ともある。');

 define('TEXT_LOGIN_GUARANTEED','保障!');

 define('ACCOUNT_EDIT_FOOTER_PAY','FS.COMにショッピング時、お客様のクレジットカードに許可しないお金を受け取れば、お金を支払わないてください。');

 define('ACCOUNT_EDIT_FOOTER_SAFE','安全なショッピング保障');

 define('ACCOUNT_EDIT_FOOTER_INFORMATION','すべてのインフォメーションはSSL (Secure Sockets Layer)プロトコルを利用して暗号化に転送していきます。');

 define('ACCOUNT_EDIT_FOOTER_HOW','個人情報の保護方法について？');

 define('ACCOUNT_EDIT_FOOTER_FREE','送料無料＆返品送料無料');

 define('ACCOUNT_EDIT_FOOTER_SHOP','万が一、到着した商品に100%ご満足いただけない場合、できるだけ早めにオリジナルパッケージを利用し、再び販売可能な状 態でご返品下さい。私たちは返品送料も承ります。');

 define('ACCOUNT_EDIT_FOOTER_DELIVER','違和感がない操作を提供するために、また、保証修理に伴うコストを削減し、FS.COM標準製品においてライフタイム保証を提供します。');

 define('ACCOUNT_EDIT_FOOTER_LEARN','もっと見る...');

 define('TEXT_FIBERSTORE_REGIST_RESPECTS','FS.COMはお客様のプライバシーを尊重しています、お客様の個人情報を販売、レンタルしておりません。');

define('TEXT_FIBERSTORE_REGIST_PRIVACY','情報セキュリティポリシー。');

define('FS_LOCAL_PICKUP','得意先まで受け取り');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
  if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false) {
      if ($reverse) {
        return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
      } else {
        return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
      }
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
  define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
  define('HTML_PARAMS','dir="ltr" lang="en"');

// charset for web pages and emails
  define('CHARSET', 'UTF-8');

// footer text in includes/footer.php
  define('FOOTER_TEXT_REQUESTS_SINCE', '今から請求する');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
  define('TEXT_GV_NAME','ギフト券');
  define('TEXT_GV_NAMES','ギフト券情報');

// used for redeem code, redemption code, or redemption id
  define('TEXT_GV_REDEEM','クーポンコード');

// used for redeem code sidebox
  define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
  define('BOX_GV_REDEEM_INFO', 'クーポンコード： ');

// text for gender
  define('MALE', '様');
  define('FEMALE', '様');
  define('MALE_ADDRESS', '様');
  define('FEMALE_ADDRESS', '様');

// text for date of birth example
  define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

//text for sidebox heading links
  define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[もっと]');

// categories box text in sideboxes/categories.php
  define('BOX_HEADING_CATEGORIES', 'カテゴリ');

// manufacturers box text in sideboxes/manufacturers.php
  define('BOX_HEADING_MANUFACTURERS', '製造者');

// whats_new box text in sideboxes/whats_new.php
  define('BOX_HEADING_WHATS_NEW', '新製品');
  define('CATEGORIES_BOX_HEADING_WHATS_NEW', '新商品 ...');

  define('BOX_HEADING_FEATURED_PRODUCTS', 'おすすめ');
  define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'おすすめ商品 ...');
  define('TEXT_NO_FEATURED_PRODUCTS', '他のおすすめ商品は更新しています、後でもう一度FS.COMをチェックしてください。');

  define('TEXT_NO_ALL_PRODUCTS', '他の商品は更新しています、後でもう一度FS.COMをチェックしてください。');
  define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', '全部商品 ...');

// quick_find box text in sideboxes/quick_find.php
  define('BOX_SEARCH_ADVANCED_SEARCH', '条件指定検索する');
   define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'あなたのキーワードを記入してください ...');
// specials box text in sideboxes/specials.php
  define('BOX_HEADING_SPECIALS', 'スペシャル');
  define('CATEGORIES_BOX_HEADING_SPECIALS','スペシャル商品 ...');

// reviews box text in sideboxes/reviews.php
  define('BOX_HEADING_REVIEWS', 'レビュー');
  define('BOX_REVIEWS_WRITE_REVIEW', 'この商品レビューを編集してください。');
  define('BOX_REVIEWS_NO_REVIEWS', 'この商品にはレビューがありませんでした。');
  define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s 星5!');

// shopping_cart box text in sideboxes/shopping_cart.php
  define('BOX_HEADING_SHOPPING_CART', 'ショッピングカート');
  define('BOX_SHOPPING_CART_EMPTY', 'あなたのカートに商品が入っていませんでした。');
  define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
  define('BOX_HEADING_CUSTOMER_ORDERS', 'クイックリオーダー');

// best_sellers box text in sideboxes/best_sellers.php
  define('BOX_HEADING_BESTSELLERS', '人気アイテム');
  define('BOX_HEADING_BESTSELLERS_IN', '人気商品は<br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
  define('BOX_HEADING_NOTIFICATIONS', 'お知らせ');
  define('BOX_NOTIFICATIONS_NOTIFY', '以下の更新情報を知らせてください <strong>%s</strong>');
  define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', '以下の更新情報を通知しません <strong>%s</strong>');

// manufacturer box text
  define('BOX_HEADING_MANUFACTURER_INFO', '製造者のインフォメーション');
  define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s ホームページ');
  define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', '別の商品');

// languages box text in sideboxes/languages.php
  define('BOX_HEADING_LANGUAGES', '言語');

// currencies box text in sideboxes/currencies.php
  define('BOX_HEADING_CURRENCIES', '貨幣');

// information box text in sideboxes/information.php
  define('BOX_HEADING_INFORMATION', 'インフォメーション');
  define('BOX_INFORMATION_PRIVACY', 'プライバシー声明');
  define('BOX_INFORMATION_CONDITIONS', '使用条件');
  define('BOX_INFORMATION_SHIPPING', '配送 &amp; 返品');
  define('BOX_INFORMATION_CONTACT', 'お問い合わせ');
  define('BOX_BBINDEX', 'フォーラム');
  define('BOX_INFORMATION_UNSUBSCRIBE', 'ニュースレターの購読取消し');

  define('BOX_INFORMATION_SITE_MAP', 'サイトマップ');

// information box text in sideboxes/more_information.php - were TUTORIAL_
  define('BOX_HEADING_MORE_INFORMATION', 'もっと見る');
  define('BOX_INFORMATION_PAGE_2', 'ページ2');
  define('BOX_INFORMATION_PAGE_3', 'ページ3');
  define('BOX_INFORMATION_PAGE_4', 'ページ4');

// tell a friend box text in sideboxes/tell_a_friend.php
  define('BOX_HEADING_TELL_A_FRIEND', '友達に伝える');
  define('BOX_TELL_A_FRIEND_TEXT', 'この商品についての了解は他人に伝えていきます。');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', '私のウィッシュリスト');
  define('BOX_WISHLIST_EMPTY', 'あなたのウィッシュリストに商品が入っていませんでした。');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'ウィッシュリストに追加される');
  define('TEXT_WISHLIST_COUNT', 'お客様は現在ご覧になる %s アイテムがウィッシュリストにあります。');
  define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', '<strong>%d</strong> は <strong>%d</strong> に追加される ( <strong>%d</strong> アイテムはウィッシュリストに入ります');

//New billing address text
  define('SET_AS_PRIMARY' , 'お届け先を編集します');
  define('NEW_ADDRESS_TITLE', '請求先住所');

// javascript messages
  define('JS_ERROR', 'フォーム処理時、エラーが発生しています。\n\nの部分は以下に変更してください：\n\n');

  define('JS_REVIEW_TEXT', '* 意見欄にいくつかの文字を追加してください、レビューには ' . REVIEW_TEXT_MIN_LENGTH . ' の文字が必要とされます。');
  define('JS_REVIEW_RATING', '* このアイテムに点数をつけてください。');

  define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* お支払い方法を選択してください。');

  define('JS_ERROR_SUBMITTED', 'このフォームはすでに提出しました。OKを押し、このプロセスが完了するのをお待ちください。');

  define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'お支払い方法を選択してください。');
  define('ERROR_CONDITIONS_NOT_ACCEPTED', '以下四角の枠にはご注文の条款と条件を確認ください。');
  define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', '以下四角の枠にはプライバシー声明を確認ください。');

  define('CATEGORY_COMPANY', '会社概要');
  define('CATEGORY_PERSONAL', 'あなたの個人情報');
  define('CATEGORY_ADDRESS', 'お届け先情報');
  define('CATEGORY_CONTACT', 'あなたの連絡情報');
  define('CATEGORY_OPTIONS', 'オプション');
  define('CATEGORY_PASSWORD', 'あなたのパスワード');
  define('CATEGORY_LOGIN', 'ログイン');
  define('PULL_DOWN_DEFAULT', 'お届け先国を選択してください');
  define('PLEASE_SELECT', 'お選びください...');
  define('TYPE_BELOW', '以下に選択してください ...');

  define('ENTRY_COMPANY', '会社名:');
  define('ENTRY_COMPANY_ERROR', '「会社名」を入力してください。');
  define('ENTRY_COMPANY_TEXT', '');
  define('ENTRY_GENDER', 'お呼び名:');
  define('ENTRY_GENDER_ERROR', 'お呼び名を選択してください。');
  define('ENTRY_GENDER_TEXT', '*');
  define('ENTRY_FIRST_NAME', '姓:');
  define('ENTRY_FIRST_NAME_ERROR', 'あなたの苗字をご確認ください、システムには' . ENTRY_FIRST_NAME_MIN_LENGTH . ' 文字以上が必要とされます。お手数ですが、再度お試しください。');
  define('ENTRY_FIRST_NAME_TEXT', '*');
  define('ENTRY_LAST_NAME', '名:');
  define('ENTRY_LAST_NAME_ERROR', 'あなたの名をご確認ください、システムには' . ENTRY_LAST_NAME_MIN_LENGTH . ' 文字以上が必要とされます。お手数ですが、再度お試しください。');
  define('ENTRY_LAST_NAME_TEXT', '*');
  define('ENTRY_DATE_OF_BIRTH', '生年月日:');
  define('ENTRY_DATE_OF_BIRTH_ERROR', 'あなたの生年月日をご確認ください、システムには: MM/DD/YYYY (eg 05/21/1970)という格式が必要とされます。');
  define('ENTRY_DATE_OF_BIRTH_TEXT', '* (例： 05/21/1970)');
  define('ENTRY_EMAIL_ADDRESS', 'メールアドレス:');
  define('ENTRY_EMAIL_ADDRESS_ERROR', 'あなたのメールアドレスをご確認ください、システムには' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' 文字以上が必要とされます。お手数ですが、再度お試しください。');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'すみません、システムにはあなたのメールアドレスを識別できかねます。お手数ですが、再度お試しください。');
 // define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor, entre con otro e-mail o cree otra cuenta con una dirección de e-mail diferen.');
  define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'システムには該当電子メールアドレスの記録はすでに存在するので、このメールアドレスを利用して登録してください。もしこのメールアドレスを使用しない場合であれば、「私のアカウント」へ進めて変更していきます。');

  define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
  define('ENTRY_NICK', 'ニックネーム');
  define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
  define('ENTRY_NICK_DUPLICATE_ERROR', '該当ニックネームは他人に使用されます。他のニックネームを使用してください。');
  define('ENTRY_NICK_LENGTH_ERROR', 'もう一度試してください、ニックネームは ' . ENTRY_NICK_MIN_LENGTH . ' 文字以上を使用する必要があります。');
  define('ENTRY_STREET_ADDRESS', '街アドレス:');
  define('ENTRY_STREET_ADDRESS_ERROR', 'ご入力される街名には ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_STREET_ADDRESS_TEXT', '*');
  define('ENTRY_SUBURB', '住所2:');
  define('ENTRY_SUBURB_ERROR', '');
  define('ENTRY_SUBURB_TEXT', '');
  define('ENTRY_POST_CODE', '郵便番号');
  define('ENTRY_POST_CODE_ERROR', 'ご入力される郵便番号には ' . ENTRY_POSTCODE_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_POST_CODE_TEXT', '*');
  define('ENTRY_CITY', '市名:');
  define('ENTRY_CUSTOMERS_REFERRAL', '推薦コード:	');

  define('ENTRY_CITY_ERROR', 'ご入力される市名には ' . ENTRY_CITY_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_CITY_TEXT', '*');
  define('ENTRY_STATE', '洲名/市名: ');
  define('ENTRY_STATE_ERROR', 'ご入力される国名には' . ENTRY_STATE_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_STATE_ERROR_SELECT', 'プルダウンメニューからあなたの国名を選択してください。');
  define('ENTRY_STATE_TEXT', '*');
  define('JS_STATE_SELECT', '-- 選択してください --');
  define('ENTRY_COUNTRY', '国名: ');
  define('ENTRY_COUNTRY_ERROR', 'プルダウンメニューからあなたの国名を選択することが必要です。');
  define('ENTRY_COUNTRY_TEXT', '*');
  define('ENTRY_TELEPHONE_NUMBER', '電話番号:');
  define('ENTRY_TELEPHONE_NUMBER_ERROR', 'ご入力される電話番号には ' . ENTRY_TELEPHONE_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
  define('ENTRY_FAX_NUMBER', 'ファックス番号:');
  define('ENTRY_FAX_NUMBER_ERROR', '');
  define('ENTRY_FAX_NUMBER_TEXT', '');
  define('ENTRY_NEWSLETTER', '会社ニュースの購読');
  define('ENTRY_NEWSLETTER_TEXT', '');
  define('ENTRY_NEWSLETTER_YES', '購読する');
  define('ENTRY_NEWSLETTER_NO', '購読しない');
  define('ENTRY_NEWSLETTER_ERROR', '');
  define('ENTRY_PASSWORD', 'パスワード:');
  define('ENTRY_PASSWORD_ERROR', 'ご入力されるパスワードには' . ENTRY_PASSWORD_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'ご入力されるパスワードはパスワードと一致することが必要です。');
  define('ENTRY_PASSWORD_TEXT', '* ( ' . ENTRY_PASSWORD_MIN_LENGTH . '文字以上を推奨します。)');
  define('ENTRY_PASSWORD_CONFIRMATION', 'パスワードを確認する:');
  define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT', '今のパスワード:');
  define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT_ERROR', 'ご入力されるパスワードには' . ENTRY_PASSWORD_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_PASSWORD_NEW', '新パスワード:');
  define('ENTRY_PASSWORD_NEW_TEXT', '*');
  define('ENTRY_PASSWORD_NEW_ERROR', 'ご入力される新パスワードには ' . ENTRY_PASSWORD_MIN_LENGTH . ' 文字以上が必要とされます。');
  define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'ご入力されるパスワードは新パスワードと一致することが必要です。');
  define('PASSWORD_HIDDEN', '--非表示--');

  define('FORM_REQUIRED_INFORMATION', '* 必要情報');
  define('ENTRY_REQUIRED_SYMBOL', '*');

  // constants for use in zen_prev_next_display function
  define('TEXT_RESULT_PAGE', '');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '全部： <strong>%d</strong> アイテム &nbsp;&nbsp; <strong>%d</strong> / %d');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '表示 <strong>%d</strong> から <strong>%d</strong> まで (<strong>%d</strong> products)件商品');
  define('TEXT_DISPLAY_NUMBER_OF_ORDERS', '表示 <strong>%d</strong> から <strong>%d</strong> まで (<strong>%d</strong> 件注文)');
  define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', '表示 <strong>%d</strong> から <strong>%d</strong> まで(<strong>%d</strong> 条レビュー)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', '表示 <strong>%d</strong> から <strong>%d</strong> まで(<strong>%d</strong> 件新商品)');
  define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', '表示 <strong>%d</strong> から <strong>%d</strong> まで(<strong>%d</strong> 件スペシャル商品)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', '表示 <strong>%d</strong> から <strong>%d</strong> まで(<strong>%d</strong> 件おすすめ商品)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', '表示 <strong>%d</strong> から <strong>%d</strong> まで(<strong>%d</strong> 件商品)');
  define('TEXT_TOTAL_NUMBER_OF_REVIEWS','(<strong>%d</strong>)');


  define('PREVNEXT_TITLE_FIRST_PAGE', 'ページ1');
  define('PREVNEXT_TITLE_PREVIOUS_PAGE', '前のページ');
  define('PREVNEXT_TITLE_NEXT_PAGE', '次のページ');
  define('PREVNEXT_TITLE_LAST_PAGE', '最後のページ');
  define('PREVNEXT_TITLE_PAGE_NO', 'ページ %d');
  define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', '前セット %d ページ');
  define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', '次セット %d ページ');
  define('PREVNEXT_BUTTON_FIRST', '最前');
  define('PREVNEXT_BUTTON_PREV', '前へ');
  define('PREVNEXT_BUTTON_NEXT', '次へ');
  define('PREVNEXT_BUTTON_LAST', '最後');

  define('TEXT_BASE_PRICE','始める: ');

  define('TEXT_CLICK_TO_ENLARGE', '大きな画像');

  define('TEXT_SORT_PRODUCTS', 'カテゴリ ');
  define('TEXT_DESCENDINGLY', '逓減');
  define('TEXT_ASCENDINGLY', '逓増');
  define('TEXT_BY', ' によって ');

  define('TEXT_REVIEW_BY', 'によって %s');
  define('TEXT_REVIEW_WORD_COUNT', '%s 単語');
  define('TEXT_REVIEW_RATING', '評価: %s [%s]');
  define('TEXT_REVIEW_DATE_ADDED', '追加日付: %s');
  define('TEXT_NO_REVIEWS', 'この商品にはレビューがありませんでした。');

  define('TEXT_NO_NEW_PRODUCTS', '他の新商品は更新していますので、後で確認してください。');

  define('TEXT_UNKNOWN_TAX_RATE', '消費税');

  define('TEXT_REQUIRED', '<span class="errorText">必需</span>');

  define('WARNING_INSTALL_DIRECTORY_EXISTS', '警告：インストールディレクトリは: %sに置いています。安全性のためにこのディレクトリを削除してください。');
  define('WARNING_CONFIG_FILE_WRITEABLE', '警告：このWebサイトは配置ファイル: %sに編集するできますが、潜在的なセキュリティリスクになります - 正しいユーザー権限を設定してください（読むのみ、CHMOD 644と444は典型なタイプです）。この権限はコントロールパネル/ファイル管理システムのみ変更できます。あなたのウェブホストに連絡してヘルプを尋ねます。<a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">よくあるご質問をご覧ください。</a></a>');
  define('ERROR_FILE_NOT_REMOVEABLE', 'エラー：この指定ファイルは削除できません。サーバーのアクセス許可を設定するために、FTPを通してこのファイルを削除してください。');
  define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', '警告：このセッションディレクトリが存在しません: ' . zen_session_save_path() . '. このディレクトリが作成されるまでにセッションは役に立ちません。 ');
  define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', '警告：このセッションディレクトリを編集できません :' . zen_session_save_path() . '. サーバーのアクセス許可が作成されるまでにセッションは役に立ちません。');
  define('WARNING_SESSION_AUTO_START', '警告：セッション.自動_使用ができます - php.iniのPHPの機能を使用禁止状態になりとウェブサーバーを再起動してください。');
  define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', '警告：ダウンロードディレクトリが存在しません: ' . DIR_FS_DOWNLOAD . '. ダウンロード商品はこのディレクトリが有効になるまで作業しません。');
  define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', '警告：このSQLキャッシュディレクトリが存在しません: ' . DIR_FS_SQL_CACHE . '.  SQLキャッシュはこのディレクトリが作成されるまで作業しません。');
  define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', '警告：このSQLキャッシュディレクトリは編集できません: ' . DIR_FS_SQL_CACHE . '. SQLキャッシュは正しいユーザー権限を設定されるまで作業しません。');
  define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'あなたのデータベースはより高いレベルにパッチする必要があるようです。 Admin->Tools->情報を提供してパッチレベルを見ます。');
  define('WARNING_COULD_NOT_LOCATE_LANG_FILE', '警告：言語ファイルを見つからない: ');

  define('TEXT_CCVAL_ERROR_INVALID_DATE', 'このジットカードの有効期限が無効です。お手数ですが、ご確認の上再度お試しください。');
  define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'このクレジットカード番号が無効です。お手数ですが、ご確認の上再度お試しください。');
  define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', '%s で始まるクレジットカード番号が正しく入力されていない、またはこのカードは弊社が受け入れません。すみません、別のクレジットカードを使用してください。');

  define('BOX_INFORMATION_DISCOUNT_COUPONS', '割引クーポン');
  define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' よくあるご質問');
  define('VOUCHER_BALANCE', TEXT_GV_NAME . ' 残高 ');
  define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' アカウント');
  define('GV_FAQ', TEXT_GV_NAME . ' よくあるご質問');
  define('ERROR_REDEEMED_AMOUNT', 'おめでとう、あなたのクーポンが利用しました。 ');
  define('ERROR_NO_REDEEM_CODE', 'あなたは'. TEXT_GV_REDEEM . 'を入力しません。');
  define('ERROR_NO_INVALID_REDEEM_GV', '無効 ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
  define('TABLE_HEADING_CREDIT', 'クレジット利用可能');
  define('GV_HAS_VOUCHERA', 'アカウントには ' . TEXT_GV_NAME . '资金があり、もし <br />という要望があれば、
                           この <a class="pageResults" href="を通して资金を送ることができます。');

  define('GV_HAS_VOUCHERB', '"><strong>電子メール</strong></a> 他人に送る');
  define('ENTRY_AMOUNT_CHECK_ERROR', 'あなたの送金金額が不足です。');
  define('BOX_SEND_TO_FRIEND', '発送 ' . TEXT_GV_NAME . ' ');// payment method is GV/Discount


  define('VOUCHER_REDEEMED',  TEXT_GV_NAME . ' 両替する');
  define('CART_COUPON', 'クーポン券 :');
  define('CART_COUPON_INFO', 'もっと見る');
  define('TEXT_SEND_OR_SPEND','あなたのアカウントには ' . TEXT_GV_NAME . ' 残高があり、ご利用できます/お友達に送ることができます。お友達に送る場合、下のボタンを押してください。');
  define('TEXT_BALANCE_IS', 'あなたの' . TEXT_GV_NAME . ' 残高は：');
  define('TEXT_AVAILABLE_BALANCE', 'あなたの' . TEXT_GV_NAME . 'アカウント ');

// payment method is GV/Discount
  define('PAYMENT_METHOD_GV', 'ギフト券/クーポン');
  define('PAYMENT_MODULE_GV', 'GV/DC');

  define('TABLE_HEADING_CREDIT_PAYMENT', 'クレジットポイント利用可能');

  define('TEXT_INVALID_REDEEM_COUPON', '無効クーポンコード');
  define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'このクーポンを利用するには、%sのお支払いが必要です。');
  define('TEXT_INVALID_STARTDATE_COUPON', 'このクーポンはまだ利用できません。');
  define('TEXT_INVALID_FINISHDATE_COUPON', 'このクーポンは期限切れです');
  define('TEXT_INVALID_USES_COUPON', 'このクーポンは使用のみご了承ください ');
  define('TIMES', ' 時間。');
  define('TIME', ' 時間。');
  define('TEXT_INVALID_USES_USER_COUPON', '他のクーポンを使用しました：お一人様 %s 枚まで利用可能 ');
  define('REDEEMED_COUPON', 'クーポン値引き ');
  define('REDEEMED_MIN_ORDER', '注文について');
  define('REDEEMED_RESTRICTIONS', ' [商品カテゴリの制限]');
  define('TEXT_ERROR', 'エラーが発生しました');
  define('TEXT_INVALID_COUPON_PRODUCT', 'このクーポンコードは現在カートに入っている商品には無効です。');
  define('TEXT_VALID_COUPON', '割引クーポンをお買い上げいただきおめでとうございます。');
  define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'ご入力されたクーポンコードは、ご選びアドレスに対して無効です。');

// more info in place of buy now
  define('MORE_INFO_TEXT','詳しくはこちら ... ');

// IP Address
  define('TEXT_YOUR_IP_ADDRESS','あなたのIDアドレス：');

//Generic Address Heading
  define('HEADING_ADDRESS_INFORMATION','住所情報');

// cart contents
  define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','カート商品数量: ');
  define('PRODUCTS_ORDER_QTY_TEXT','カートにいれる: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCT', 'カートに商品を追加しました ...');
// only for where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'ご選択された商品を成功にカートに追加されました ...');

  define('TEXT_PRODUCT_WEIGHT_UNIT','kg');

// Shipping
  define('TEXT_SHIPPING_WEIGHT','kg');
  define('TEXT_SHIPPING_BOXES', 'ボックス');

// Discount Savings
  define('PRODUCT_PRICE_DISCOUNT_PREFIX_1','OFF &nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PREFIX','OFF:&nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE','% 割引');
  define('PRODUCT_PRICE_DISCOUNT_AMOUNT','&nbsp;割引');

// Sale Maker Sale Price
  define('PRODUCT_PRICE_SALE','価格:&nbsp;');

//universal symbols
  define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
  define('BOX_HEADING_BANNER_BOX','スポンサー');
  define('TEXT_BANNER_BOX','私たちのスポンサーを訪問してください ...');

// banner box 2
  define('BOX_HEADING_BANNER_BOX2','ご覧になりましたか...');
  define('TEXT_BANNER_BOX2','今日はこれをチェックしましょう!');

// banner_box - all
  define('BOX_HEADING_BANNER_BOX_ALL','スポンサー');
  define('TEXT_BANNER_BOX_ALL','私たちのスポンサーを訪問してください ...');

// boxes defines
  define('PULL_DOWN_ALL','お選びください');
  define('PULL_DOWN_MANUFACTURERS','- リセット -');
// shipping estimator
  define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'お選びください');

// general Sort By
  define('TEXT_INFO_SORT_BY','並べ替え: ');

// close window image popups
  define('TEXT_CLOSE_WINDOW',' - 画像：');
// close popups
  define('TEXT_CURRENT_CLOSE_WINDOW','[ ウィンドウを閉じる ]');

// iii 031104 added:  File upload error strings
  define('ERROR_FILETYPE_NOT_ALLOWED', 'エラー：ファイルの種類が許可されていません。');
  define('WARNING_NO_FILE_UPLOADED', '警告：アップロードされたファイルがありません。');
  define('SUCCESS_FILE_SAVED_SUCCESSFULLY', '成功：ファイルが正常に保存されました。');
  define('ERROR_FILE_NOT_SAVED', 'エラー：ファイルが保存されていません。');
  define('ERROR_DESTINATION_NOT_WRITEABLE', 'エラー：宛先は書き込み不可です。');
  define('ERROR_DESTINATION_DOES_NOT_EXIST', 'エラー：宛先が存在しません。');
  define('ERROR_FILE_TOO_BIG', '警告：ファイルが大きすぎてアップロードできません！<br />注文を放置することは可能ですが、本サイトに連絡してアップロードのヘルプを得てきます。');
// End iii added

  define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', '注意：このウェブサイトは以下により停止してメンテナンスを実行します:  ');
  define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', '注意：今ウェブサイトは公衆に向けてメンテナンスを提供しています。');

  define('PRODUCTS_PRICE_IS_FREE_TEXT','これは無料です!');
  define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT','価格を求める');
  define('TEXT_CALL_FOR_PRICE','価格を求める');

  define('TEXT_INVALID_SELECTION',' 無効なオプションうを選択しました: ');
  define('TEXT_ERROR_OPTION_FOR',' 以下なオプション: ');
  define('TEXT_INVALID_USER_INPUT', 'ユーザー入力必須<br />');

// product_listing
  define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING','Min: ');
  define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING','単価: ');
  define('PRODUCTS_QUANTITY_IN_CART_LISTING','ショッピングカート一覧:');
  define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING','追加金額:');

  define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING','Max:');

  define('TEXT_PRODUCTS_MIX_OFF','*混合表示しない');
  define('TEXT_PRODUCTS_MIX_ON','*混合表示');

  define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART','<br />*このアイテムにオプションを混ぜて最小注文量の要件を満たすことはできません。*<br />');
  define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART','*混合オプション値は: <br />');

  define('ERROR_MAXIMUM_QTY','あなたのカートに追加された数量はすでにご許可された最大値により調整してしました。このアイテムを見る：');
  define('ERROR_CORRECTIONS_HEADING','以下の内容を修正してください: <br />');
  define('ERROR_QUANTITY_ADJUSTED', 'あなたのカートに追加された数量はすでに調整しました。今のアイテムがご望みアイテムの数量に足りない、現在アイテムの数量は：');
  define('ERROR_QUANTITY_CHANGED_FROM', ', :から変更した ');
  define('ERROR_QUANTITY_CHANGED_TO', ' へ ');

// Downloads Controller
  define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','ご注意：お支払を確認するまでにダウンロードは利用できません');
  define('TEXT_FILESIZE_BYTES', ' バイト');
  define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
  define('ERROR_PRODUCT','このアイテム: ');
  define('ERROR_PRODUCT_STATUS_SHOPPING_CART','<br />すみません、この商品は今在庫切れです。<br />ショッピングカートから削除してください。');
  define('ERROR_PRODUCT_QUANTITY_MIN',',  ... 最小注文量エラー - ');
  define('ERROR_PRODUCT_QUANTITY_UNITS',' ... 数量単位エラー - ');
  define('ERROR_PRODUCT_OPTION_SELECTION','<br /> ... 無効なオプションを選択しました ');
  define('ERROR_PRODUCT_QUANTITY_ORDERED','<br /> ご注文合計: ');
  define('ERROR_PRODUCT_QUANTITY_MAX',' ... 最大注文量エラー - ');
  define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART',', 最小注文量制限があります。 ');
  define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART',' ... 数量単位エラー - ');
  define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART',' ... 最大注文量エラー - ');

  define('WARNING_SHOPPING_CART_COMBINED', '注意：お客様の利便性のため、現在のショッピングカートは、最後の訪問時のショッピングカートと組み合わされています。 お客様は決算する前にショッピングカートをチェックしてください。');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
  define('ERROR_CUSTOMERS_ID_INVALID', '顧客情報は検証できません！<br />アカウントを登録するまたは顧客情報を再作成してください ...');

  define('TABLE_HEADING_FEATURED_PRODUCTS','おすすめ商品');

  define('TABLE_HEADING_NEW_PRODUCTS', '新商品 %s');
  define('TABLE_HEADING_UPCOMING_PRODUCTS', '更新いている商品');
  define('TABLE_HEADING_DATE_EXPECTED', '到着予定日');
  define('TABLE_HEADING_SPECIALS_INDEX', '月間スペシャル %s');

  define('CAPTION_UPCOMING_PRODUCTS','これらのアイテムはすぐに入荷予定です');
  define('SUMMARY_TABLE_UPCOMING_PRODUCTS','テーブルには在庫予定商品と入荷予定日の情報を提供しています');

// meta tags special defines
  define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT','これは無料です!');

// customer login
  define('TEXT_SHOWCASE_ONLY','お問い合わせ');
// set for login for prices
  define('TEXT_LOGIN_FOR_PRICE_PRICE','無効な価格');
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','価格へログインする');
// set for show room only
  define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','ショールームのみ');

// authorization pending
  define('TEXT_AUTHORIZATION_PENDING_PRICE', '無効な価格');
  define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', '承認待ち');
  define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','ショップへのログイン');

// text pricing
  define('TEXT_CHARGES_WORD','合計金額（税込）：:');
  define('TEXT_PER_WORD','<br />一つ単語の価格: ');
  define('TEXT_WORDS_FREE',' 単語無料 ');
  define('TEXT_CHARGES_LETTERS','合計金額（税込）:');
  define('TEXT_PER_LETTER','<br />一つ字母の価格: ');
  define('TEXT_LETTERS_FREE',' 送信無料 ');
  define('TEXT_ONETIME_CHARGES','*一度の料金 = ');
  define('TEXT_ONETIME_CHARGES_EMAIL',"\t" . '*一度の料金 = ');
  define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'オプションに対する数量割引');
  define('TABLE_ATTRIBUTES_QTY_PRICE_QTY','数量');
  define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE','価格');
  define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'オプションに対する数量割引は1回払いです');

// textarea attribute input fields
  define('TEXT_MAXIMUM_CHARACTERS_ALLOWED',' 許可される最大文字数');
  define('TEXT_REMAINING','残り');

// Shipping Estimator
  define('CART_SHIPPING_OPTIONS', '送料計算');
  define('CART_SHIPPING_OPTIONS_LOGIN', 'どうぞ <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">ログイン</span></a>, 個人的な輸送費を表示します。');
  define('CART_SHIPPING_METHOD_TEXT', '利用可能な配送方法');
  define('CART_SHIPPING_METHOD_RATES', '料金');
  define('CART_SHIPPING_METHOD_TO','お届け先: ');
  define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'お届け先: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">ログイン</span></a>');
  define('CART_SHIPPING_METHOD_FREE_TEXT','送料無料');
  define('CART_SHIPPING_METHOD_ALL_DOWNLOADS','- ダウンロード');
  define('CART_SHIPPING_METHOD_RECALCULATE','再計算する');
  define('CART_SHIPPING_METHOD_ZIP_REQUIRED','実現');
  define('CART_SHIPPING_METHOD_ADDRESS','アドレス:');
  define('CART_OT','合計金額計算:');
  define('CART_OT_SHOW','実現'); // set to false if you don't want order totals
  define('CART_ITEMS','ショッピングカートのアイテム一覧: ');
  define('CART_SELECT','選択する');
  define('ERROR_CART_UPDATE', '<strong>どうそ、ご注文を更新してください。</strong> ');
  define('IMAGE_BUTTON_UPDATE_CART', '準備中');
  define('EMPTY_CART_TEXT_NO_QUOTE', 'うわー！ あなたのセッションは期限切れです ... 送料計算のためにショッピングカートを更新してください ...');
  define('CART_SHIPPING_QUOTE_CRITERIA', '送料は、お届け先に基づいて計算します：');

// multiple product add to cart
  define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', '合計（金額）: ');
  define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', '合計（金額）: ');
  define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', '合計（金額）: ');
  define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', '合計（金額）: ');
  //moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
  define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', '割引金額');
  define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', '割引後商品金額');
  define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', '割引金額');
  define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* 上記のオプションに基づいて割引が異なる場合があります');
  define('TEXT_HEADER_DISCOUNTS_OFF', '数量割引は利用できません...');

// sort order titles for dropdowns
  define('PULL_DOWN_ALL_RESET','- リセット - ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', '商品名');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', '商品名 - desc');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', '価格 - 安い順');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', '価格 - 高い順');
  define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'モデル');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', '追加された日付 - 新から旧へ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', '追加された日付 - 旧から新へ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'デフォルト表示');

// downloads module defines
  define('TABLE_HEADING_DOWNLOAD_DATE', 'リンク期限切れ');
  define('TABLE_HEADING_DOWNLOAD_COUNT', '残り');
  define('HEADING_DOWNLOAD', 'あなたのファイルをダウンロードには、ダウンロードボタンを押して、ポップアップメニューから「ディスクに保存」を選択します。');
  define('TABLE_HEADING_DOWNLOAD_FILENAME','ファイル名');
  define('TABLE_HEADING_PRODUCT_NAME','アイテム名');
  define('TABLE_HEADING_BYTE_SIZE','ファイルサイズ');
  define('TEXT_DOWNLOADS_UNLIMITED', '無制限');
  define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
  define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
  define('TABLE_HEADING_QUANTITY', '数量.');
  define('TABLE_HEADING_PRODUCTS', 'アイテム名');
  define('TABLE_HEADING_TOTAL', '全部');

// create account - login shared
  define('TABLE_HEADING_PRIVACY_CONDITIONS', 'プライバシー声明');
  define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '私どものプライバシーに関する声明に同意の上、以下のボックスに押してください。 プライバシーに関する声明は　<a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>　に読むことができます。.');
  define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '私はプライバシーに関する声明を読んで、同意しました。');
  define('TABLE_HEADING_ADDRESS_DETAILS', '住所情報');
  define('TABLE_HEADING_PHONE_FAX_DETAILS', '他の連絡方式');
  define('TABLE_HEADING_DATE_OF_BIRTH', 'あなたの年齢を確認します');
  define('TABLE_HEADING_LOGIN_DETAILS', 'ログインの詳細');
  define('TABLE_HEADING_REFERRAL_DETAILS', 'あなたは私たちを参照しましたか?');

  define('ENTRY_EMAIL_PREFERENCE','ニュースレターと電子メールの詳細');
  define('ENTRY_EMAIL_HTML_DISPLAY','HTML');
  define('ENTRY_EMAIL_TEXT_DISPLAY','テキストのみ');
  define('EMAIL_SEND_FAILED','ERROR: エラー：電子メールの送信に失敗しました: "%s" <%s> with subject: "%s"');

  define('DB_ERROR_NOT_CONNECTED', 'エラー - データベースに接続できません');

  // EZ-PAGES Alerts
  define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', '警告： EZ-PAGES HEADER - 管理専用IP');
  define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', '警告： EZ-PAGES FOOTER - 管理専用IP');
  define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', '警告： EZ-PAGES SIDEBOX - 管理専用IP');

// extra product listing sorter
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', '...から始まる項目');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- リセット --');

///////////////////////////////////////////////////////////
// include email extras
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS

  //define('FIBERSTORE_VIEW_MORE', 'カートのアイテムをもっと見る...');
  define('FIBERSTORE_VIEW_MORE', 'もっと見る...');
  define('FIBERSTORE_WISHLIST_ADD_TO_CART','カートにいれる');
  define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS','成功にウィッシュリストに追加されました');
  define('FIBERSTORE_DELETE','削除する');
  define('FIBERSTORE_PRICE','価格');
  define('FIBERSTORE_VIEW_MORE_ORDERS','すべての注文を見る »');
  define('FIBERSTORE_ORDER_IMAGE','商品画像');
  define('FIBERSTORE_POST','ポスト');
  define('FIBERSTORE_CANCEL_ORDER','注文をキャンセルする');
  define('FIBERSTORE_PRODTCTS_DETAILS','商品詳細');

  define('FIBERSTORE_OEM_CUSTOM','OEM＆カスタマイズ');
  define('FIBERSTORE_ANY_TYPE','任意タイプ');
  define('FIBERSTORE_ANY_LENGTH','任意長さ');
  define('FIBERSTORE_ANY_COLOR','任意カラー');
  define('FIBERSTORE_WORK_PROJECT','あなたのカスタムプロジェクトに協力させていただきます。');

  define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
  define('TEXT_PREFIX','text_prefix_');
  //2016-5-25. by peter
  define('LIVE_CHAT_TIT','購入サポートを獲得する');
define('LIVE_CHAT_TIT1','3つの異なる方法でプロフェッショナルなサービス＆サポートを提供する');
define('LIVE_CHAT_TIT2','あなたのメッセージは成功にFS.COMに投稿されました、ありがとう！');
define('LIVE_CHAT_CON1','FS.COMとLive Chat');
define('LIVE_CHAT_CON2','すぐに関係情報を求めるために私たちと連絡します');
define('LIVE_CHAT_CON3','月曜日～金曜日8：00～24：00（太平洋標準時により）');
define('LIVE_CHAT_CON4','私達にメッセージを出しください、私たちはすぐに返答します。');
define('LIVE_CHAT_CON5','メッセージを出す');
define('LIVE_CHAT_CON6','メールを送る');
define('LIVE_CHAT_CON7','ご返信には12時以内いただいております');
define('LIVE_CHAT_CON8','お見積もりをリクエストし、FS.COMは迅速な反応をお届け致します。');
define('LIVE_CHAT_CON9','今メールを送る');
define('LIVE_CHAT_CON10','利用可能');
define('LIVE_CHAT_CON11','利用不可');
define('LIVE_CHAT_CON12','電話で相談する');

//订单页面公共部分  常量
//2016-9-7 add by  Frankie
define('ALL_ORDER','すべての注文');
define('UNPAID_ORDER','保留中の注文');
define('TRADING_ORDERS','取引注文');
define('CLOSED_ORDERS','キャンセルした注文');
define('FIBERSTORE_QUESTION','質問が成功に提出されました');
define('FIBERSTORE_ORDER_PRIVATE','プライベート注文');
define('FIBERSTORE_ORDER_COMPANY','該当会社の全ての注文');
define('FIBERSTORE_ORDER_SELECT','注文日で選択してください');
define('PLEASE','お選びください');
define('WEEK','最新の週');
define('MONTH','最新の月');
define('THREE_MONTH','最新の3ヶ月');
define('FIBERSTORE_ORDER_ENTER','あなたの注文番号を入力してください');
define('FIBERSTORE_ORDER_NO','注文番号');
define('SEARCH','検索');
define('FIBERSTORE_ORDER_PROMT','ご注文は見つかりません。');
define('FIBERSTORE_ORDER_PROMT_RMA','RMA要求はありませんてした。');
// add by Aron
define('FIBERSTORE_ORDER_PROMT1','RMA要求はありませんてした。');
define('FIBERSTORE_ORDER_PROMT2','注文は見つかりませんでした。');
define('FIBERSTORE_ORDER_PROMT3','キャンセルした');
define('FIBERSTORE_ORDER_PROMT4','お届け先のアドレス');
define('FIBERSTORE_ORDER_PICTURE','商品画像');
define('FIBERSTORE_ORDER_DATE','注文日');
define('PAYMENT','支払');
define('CANCELED','キャンセル');
define('FIBERSTORE_ORDER_OPERATE','実行する');
define('PREVIOUS','前');
define('NEXT','次');
define('FIBERSTORE_ORDER_PAGE','ページ');
define('FIBERSTORE_ORDER_OF','の');
define('FS_LEARN_MORE','もっと見る');
define('CONNECTING_PAYPAL','Paypalに接続する');
define('ARE_YOU_SURE','もう一度確認してください、この注文をキャンセルしましょうか？');
define('ONCE_YOU_DO','一度実行すると、回復することはできません。');
define('HOWEVER','すみません、この注文をキャンセルすれば、取消の理由を教えてくれませんか。');
define('EXPENSIVE','高価な送料');
define('DUPLICATE','重複注文');
define('FAILING','支払失敗');
define('WRONG','間違った情報を書き込む');
define('OUT','在庫切れ');
define('NO_NEED','必要なし');
define('OFFLINE','オフライン取引');
define('FIBERSTORE_ORDER_CONFIRM','確認');
define('OTHERS','その他');
define('BEFORE_SUBMITTING','ご提出する前に、この注文がキャンセルした理由を記入していただけませんか');
define('CANCEL','キャンセル');

/*module shipping   运费模块 */
define('FS_COMPANY','お配送方法');
define('FS_TIME','お届け予定日');
define('FS_COST','送料');
define('FS_TO','へ');
define('FS_VIA','経由');
define('FS_FREE_SHIP','送料無料');
define('FS_PREFER','もしお客様が個人の配達アカウントを利用すれば、あなたの配達アカウントを提供してください、これは送料無料です。');
define('FS_METHOD','配達方式');
define('FS_ACCOUNt','配達アカウント');
define('FS_NO_SHIPPING','ご選択されたお届け先国は送料無料です。');
define('FS_SHIP_CONFIRM','確認');
define('FS_BUSINESS_DAYS','営業日');
define('FS_BUSINESS_DAY','営業日');
define('FS_WORK_DAYS_SERVICE', '平日');


define('FS_COMMON_CLEAR','選択を空にする');
define('FS_COMMON_COMPLIANT','ファーストイーサネットとギガビットイーサネット・アプリケーションの802.3z標準に達する');
define('FS_COMMON_ADD','追加');
define('FS_COMMON_ADDED','追加される');
define('FS_COMMON_PROCESSING','処理中');
define('FS_COMMON_PLEASE_WAIT','少々お待ちください');
define('FS_COMMON_PRODUCT','商品一覧を見る');
define('FS_COMMON_NEXT','次');
define('FS_COMMON_PREVIOUS','前');

//2016.12.6 added
define('FS_VERIFIED_PUR','FS認証購入者');
define('FS_COMMENTS','コメント');
//2016.12.13评论ajax
define('FS_REVIEWS10','シェアする');
define('FS_REVIEWS11','コメント');
define('FS_CANCEL','キャンセル');
define('FS_SUBMIT', '送信する');
define('FS_DELETE_SUCESS','成功に削除されました。');
define('FS_DELETE','削除する');
define('FS_EDIT_POST','この文章を編集します');

//评论相关页面编辑头像 2017.4.10  ery
define('FS_ADAPTER_TYPE', 'アダプタのタイプ');
define('FS_TRANS_RELATED', 'タイプ');

define('FS_REVIEWS_REPLACE','ヘッドの交換する');
define('FS_REVIEWS_EDIT','あなたの個人情報を編集します');
define('FS_REVIEWS_RECOMMENDED','お勧めプロフィール画像');
define('FS_REVIEWS_LOCAL','ローカルアップロード');
define('FS_REVIEWS_ONLY','JPG、GIF、PNG、JPEG、BMP形式のみを受け付け、ファイルは300KB未満必要');
define('FS_REVIEWS_SAVE','保存する');
define('ACCOUNT_FOOTER_LEARN','もっと見る...');

//账户中心相关页面公用向量   2017.5.12  ery  add
/*edit_my_account页面*/
define('ACCOUNT_MY_ACCOUNT','マイアカウント');
define('ACCOUNT_EDIT_ACCOUNT','アカウントの設定');
define('ACCOUNT_EDIT_BELOW','以下の情報を編集し、その後ボタンを押して更新してください。');
define('ACCOUNT_EDIT_FOLLOW','以下の内容を確認してください…');
define('ACCOUNT_EDIT_SUCCESS','成功');
define('ACCOUNT_EDIT_ACCOUNT_INFO','アカウント情報');
define('ACCOUNT_EDIT_UPDATE','更新する');
define('ACCOUNT_EDIT_EMAIL','電子メールアドレス');
define('ACCOUNT_EDIT_NEW','新パスワード');
define('ACCOUNT_EDIT_REENTER','パスワード再入力');
define('ACCOUNT_EDIT_ADDRESS','住所情報');
define('ACCOUNT_EDIT_FIRST','姓');
define('ACCOUNT_EDIT_LAST','名');
define('ACCOUNT_EDIT_COMPANY','会社名');
define('ACCOUNT_EDIT_STREET','アドレス1');
define('ACCOUNT_EDIT_LINE','アドレス2（任意）');
define('ACCOUNT_EDIT_POSTAL','郵便番号');
define('ACCOUNT_EDIT_CITY','市名');
define('ACCOUNT_EDIT_COUNTRY','宛先国/地域');
define('ACCOUNT_EDIT_STATE','州/県/区');
define('ACCOUNT_EDIT_PHONE','電話番号');
define('ACCOUNT_EDIT_EMIAL_MSG','ご提出されたメールアドレスが識別できかねます。(example:someone@example.com).');
define('ACCOUNT_EDIT_PASS_MSG','ご入力されるパスワードには7字以上が必要とされます。');
define('ACCOUNT_EDIT_CONFIRM_MSG',"この確認用パスワードは新パスワードと相違しています。両方は一致することが必要です。");
define('ACCOUNT_EDIT_FIRST_MSG','姓をご入力ください。');
define('ACCOUNT_EDIT_LAST_MSG','名をご入力ください。');
define('ACCOUNT_EDIT_STREET_MSG','あなたの街アドレスを記入してください。');
define('ACCOUNT_EDIT_POSTAL_MSG','あなたの郵便番号を記入してください。');
define('ACCOUNT_EDIT_CITY_MSG','市名をご入力ください。');
define('ACCOUNT_EDIT_COUNTRY_MSG','あなたの国名を記入してください。');
define('ACCOUNT_EDIT_STATE_MSG','あなたの州/県/区を記入してください。');
define('ACCOUNT_EDIT_PHONE_MSG','あなたの電話番号を記入してください。');
define('ACCOUNT_EDIT_HEADER_OUR','システムには該当電子メールアドレスの記録はすでに存在しています。');
define('ACCOUNT_EDIT_HEADER_EDIT','ニックネームは成功に編集されました。');
define('ACCOUNT_EDIT_HEADER_FILE','ファイルが大きすぎです!');
define('ACCOUNT_EDIT_HEADER_CUSTOMER','写真を更新されました。');
define('ACCOUNT_EDIT_HEADER_THANKS','ありがとうございます');
define('ACCOUNT_EDIT_HEADER_FS','FS.COM 顧客サービス');
define('ACCOUNT_EDIT_HEADER_INFO','FS.COM - アカウント情報の更新');
define('ACCOUNT_EDIT_HEADER_YOUR','お客様のFS.COMアカウント情報がすでに更新されました。 アップデートアカウントの情報を確認するには下記を参照してください');

/*my_questions和my_questions_details页面*/
define('FS_QUSTION','Q&A(QA_COUNT)');
define('FS_QUSTION_01','QA_COUNT Q&A');
define('FS_QUSTI','問題');
define('FS_QUSTION_TELL','お客様のアカウント、注文、RMA、テクニカルサポートに関するの質問をお伝えください。私たちはぜひ迅速に対応致します。');
define('FS_QUSTION_ASK','質問する');
define('FS_QUSTION_DATE','日付');
define('FS_QUSTION_STATUS','状態');
define('FS_QUSTION_VIEW','表示');
define('FS_QUSTION_REMOVE','削除する');
define('FS_QUSTION_ENTRIES','エントリー');
define('FS_QUSTION_NO','タイトルは記入されていません。');
define('FS_QUSTION_ANSWERS','応答');
define('FS_QUSTION_REPLY','ご質問は処理中になり、しばらくお待ちください。');
define('FS_QUSTION_JS','この情報を削除しますか？');
/*manage_address页面*/
define('FS_ADDRESS_BOOK','アドレス帳');
define('FS_ADDRESS_NAME','名前');
define('FS_ADDRESS_COMPANY','会社名');
define('FS_ADDRESS_ADDRESS','アドレス');
define('FS_ADDRESS_NO','住所を見つかりませんでした');
define('FS_ADDRESS_DEFAULT','デフォルト');
define('FS_ADDRESS_SET','既定値を設定する');
define('FS_ADDRESS_EDIT','編集する');
define('FS_ADDRESS_CREATE','アドレスを新規する');
define('FS_ADDRESS_UPDATE','アドレスエントリを更新する');
define('FS_ADDRESS_PLEASE','アドレスを編集するには、このフォームを入力して更新ボタンを押してください。');
define('FS_ADDRESS_FIRST_MSG','姓は最小で2文字を入力しなければなりません。');
define('FS_ADDRESS_LAST_MSG','名は最小で2文字を入力しなければなりません。');
define('FS_ADDRESS_SORRY','申し訳ありませんが、配送先が必要です。');
define('FS_ADDRESS_POSTAL_MSG','ZIP /郵便番号は最小で3文字を入力しなければなりません。');
define('FS_ADDRESS_COUNTRY_MSG','あなたの国家が必要です。');
define('FS_ADDRESS_STATE_MSG','州名入力が必要です。');
define('FS_ADDRESS_PHONE_MSG','お電話番号は少なくとも6桁でなければなりません。');
define('FS_ADDRESS_UP_ADDRESS','アドレスを更新する');
define('FS_ADDRESS_NEW','新しいアドレス');
define('FS_ADDRESS_NEW_PLEASE',' 新しいアドレスを追加するにはこのフォームに記入し、下のボタンをクリックしてください。');
define('FS_ADDRESS_ADD','アドレスを追加する');
define('FS_ADDRESS_DELETE','アドレスは成功に削除されました。');
define('FS_ADDRESS_SET_SUCCESS','デフォルトアドレスは成功に設定されました！');
define('FS_ADDRESS_UP_SUCCESS','アドレスは成功に更新されました。');
define('FS_ADDRESS_ADD_SUCCESS','アドレスは成功に追加されました。');
/*manage_order相关页面*/
define('MANAGE_ORDER_STATUS','注文の状態');
define('MANAGE_ORDER_HISTORY','注文履歴');
define('MANAGE_ORDER_ORDER','注文番号:');
define('MANAGE_ORDER_SHIPMENT','パッケージ');
define('MANAGE_ORDER_INFORMATION','注文情報');
define('MANAGE_ORDER_DATE','注文日');
define('MANAGE_ORDER_PAYMENT','お支払い方法');
define('MANAGE_ORDER_SEE','詳細を見る');
define('MANAGE_ORDER_PO','PO番号');
define('MANAGE_ORDER_RMA_NO','RMA NO．/ID');
define('MANAGE_ORDER_TEL','Tel');
define('MANAGE_ORDER_NOT','まだ設定されていません');
define('MANAGE_ORDER_SHIPPING','お届け先のアドレス');
define('MANAGE_ORDER_PRODUCT','商品');
define('MANAGE_ORDER_ITEM','商品価格');
define('MANAGE_ORDER_QUANTITY','数量');
define('MANAGE_ORDER_TOTAL','合計');
define('MANAGE_ORDER_TOTAL_JAPAN','合計（税抜）');
define('MANAGE_ORDER_QTY','数量');
define('MANAGE_ORDER_WRITE','レビューを書く');
define('MANAGE_ORDER_PRINT','請求書を印刷する');
define('MANAGE_ORDER_REORDER','再注文する');
define('MANAGE_ORDER_TIME','処理時間');
define('MANAGE_ORDER_INFO','処理進捗');
define('MANAGE_ORDER_OPERATOR','操作員');
define('MANAGE_ORDER_COMMODITY','商品処理');
define('MANAGE_ORDER_MSG','注文は成功にキャンセルされました！');
define('MANAGE_ORDER_ALL','すべての注文');
define('MANAGE_ORDER_PENDING','予約注文');
define('MANAGE_ORDER_COMPLETED','完了の注文');
define('MANAGE_ORDER_CANCELLED','キャンセルした注文');
define('MANAGE_ORDER_RMA','返品保証');
define('MANAGE_ORDER_PLACED','発注日');
define('MANAGE_ORDER_SHIPING','お届け先');
define('MANAGE_ORDER_DETAILS','注文詳細');
define('MANAGE_ORDER_INVOICE','請求書を印刷する');
define('MANAGE_ORDER_BUY','再注文');
define('MANAGE_ORDER_VIEW','注文には他の商品を見ます');
define('MANAGE_ORDER_PAY','今すぐ支払う');
define('MANAGE_ORDER_CANCEL','注文をキャンセル');
define('MANAGE_ORDER_RETURN','返品/交換');
define('MANAGE_ORDER_RESTORE','注文を復元する');
define('MANAGE_ORDER_MONTH','直近1ヶ月');
define('MANAGE_ORDER_THREE_MONTHS','直近３ヶ月');
define('MANAGE_ORDER_YEAR','直近12ヶ月');
define('MANAGE_ORDER_YEAR_AGO','一年前');
define('MANAGE_ORDER_NO','注文 No./ID');
define('MANAGE_ORDER_HEADER','ご注文取消の請求は成功に提出されました、しばらくお待ちください。');
define('MANAGE_ORDER_EA','個');

// add by aron 2017.7.17
define("MANAGE_ORDER_PURCHASE_ORDER",'注文書');
define("MANAGE_ORDER_UPLOAD_PO_FILE",'POファイルを添付');
define("MANAGE_ORDER_UPLOAD_PURCHASE_ORDER",'注文書をアップロードする');
define("MANAGE_ORDER_UPLOAD_MESAAGE",'お客様からPOを受け取るまでに商品を出荷されておりません。ご了承ください。POは5日以内に受領しなければなりません。なお、POには注文番号を記入してください。');
define("MANAGE_ORDER_UPLOAD_FILE_TEXT",' ファイルを選ぶ ');
define("MANAGE_ORDER_UPLOAD_ERROR","PDF、JPG、PNGタイプのファイルを許可します。最大ファイルサイズ：4MB");
define("MANAGE_ORDER_UPLOAD_SUBMIT","添付");
define("MANAGE_ORDER_UPLOAD_LABEL",'ファイルをアップロードする');




/*sales_service页面*/
define('FS_SALES_CHOOSE','返品のアイテムを選びます');
define('FS_SALES_ALL','すべて');
define('FS_SALES_RETURN','返品');
define('FS_SALES_CONTINUE','続ける');
define('FS_SALES_SELECT','あなたの商品を選択してください');
define('FS_SALES_CONFIRM','このRMA をキャンセルしませんか？');
/*sales_service_info页面*/
define('FS_SALES_REASONS','RMAの確認');
define('FS_SALES_PLEASE','サービスタイプをご選択ください。');
define('FS_SALES_REFUND','返品＆返金');
define('FS_SALES_REPLACE','交換');
define('FS_SALES_MAINTENANCE','メンテナンス');
define('FS_SALES_WHY','お客様の返品理由を教えていただけませんか?');
define('FS_SALES_NO','すでに必要なし');
define('FS_SALES_INCORRECT','不適な商品または間違いサイズの注文');
define('FS_SALES_MATCH',"説明と相違している");
define('FS_SALES_DAMAGED','到着時に壊れていました');
define('FS_SALES_RECEIVED','違う商品が届きました');
define('FS_SALES_NOT','予想通りではない');
define('FS_SALES_NO_REASON','理由なし');
define('FS_SALES_OTHER','その他');
define('FS_SALES_OTHER_ISSUES', 'その他の問題');
define('FS_SALES_COMMENTS','コメント（必須）');
define('FS_SALES_NOTE','注意');
define('FS_SALES_WE',"私たちはコメントの応答以外のポリシーを提供できません");
define('FS_SALES_WRITE','あなたの質問を記入してください。');
define('FS_SALES_SUCCESSFUL','成功');
define('RMA_TRACK_STATUS','状態を追跡する');
define('RMA_SERVICE_TYPE','サービスの種類');
define('RMA_REASON','サービスの理由');
/*sales_service_details*/
define('SALES_DETAILS_CONFIRM','領収書の確認');
define('SALES_DETAILS_RECEIPT','受領確認');
define('SALES_DETAILS_SUBMIT',' RMA 申请を提出する');
define('SALES_DETAILS_REJECT','拒否する');
define('SALES_DETAILS_APPROVED','承認済み');
define('SALES_DETAILS_RETURN','返品');
define('SALES_DETAILS_RMA','RMAを受けた');
define('SALES_DETAILS_NEW','新規商品');
define('SALES_DETAILS_REFUND','返金');
define('SALES_DETAILS_COMPLETE','完了');
define('SALES_DETAILS_SEND','返品方法 ');
define('SALES_DETAILS_SEND_MSG',' 以下のフローチャートに沿って返品してください。「出荷ラベルの作成」については、エクスプレス会社のウェブサイトともローカル運送会社とも受け取りできます。もしFS.COMから出荷ラベルをもらうとすれば、電話とメールで私たちと連絡してください。電話番号：+1 253 2773058　　電子メールアドレス：service.us@fs.com');
define('SALES_DETAILS_FROM','郵送先');
define('SALES_DETAILS_EDIT','編集する');
define('SALES_DETAILS_DELIVER','返送先');
define('SALES_DETAILS_FILL','このAwb（航空貨物運送状）を書き込んでいます');
define('SALES_DETAILS_AWB','配達進捗を追跡するために、このAWBを書き込んでください。返品受領後、返金または修理がすぐに処理されます。');
define('SALES_DETAILS_TRACKING','追跡番号');
define('SALES_DETAILS_PLEASE','追跡番号を書き留めてください。');
define('SALES_DETAILS_PRINT','印刷');
define('SALES_DETAILS_PRINT_MSG','AWBは、お客様の返品を迅速に区別してRMA請求が次のステップに進めていることに役立ちますように。どうぞ、それを印刷し、返品と一緒に添付してください。');
define('SALES_DETAILS_STEP_CONFIRM','アドレスをご確認ください');
define('SALES_DETAILS_STEP_PRINT','RMAフォームを印刷する');
define('SALES_DETAILS_STEP_ATTACH','RMAフォームを添付する');
define('SALES_DETAILS_STEP_CREATE','出荷ラベルを作成する');
define('SALES_DETAILS_STEP_SHIP','出荷する');
define('SALES_DETAILS_CANCEL','キャンセル');

/*售后流程状态提示*/
define('SALES_MSG_APPROVED','ご提出頂いたRMA申請書が既に受領されましたが、審査するまで少々お待ちください。');
//define('SALES_MSG_SUBMIT','あなたのRMA申請書が提出されました。どうぞ、審査の結果を待ってください。');
define('SALES_MSG_SUBMIT','RMA申請書が提出されました。どうぞ、審査の結果を待ってください。');
define('SALES_MSG_RETURN','ご返品の配達をいただくありがとうございます、私たちの物流部門は運送状況を見守ります。');
define('SALES_MSG_COMPLETE','このRMAは処理完了しました。');

//2017.6.6		add		ery   manage_orders & account_history_info
define('F_RECEIPT_CONFIRMATION','受領確認');
define('F_REFUNDED_PROCESSING','返金処理');
define('MANAGE_ORDER_ARE','この商品はすでに受領されたでしょうか? ');
define('MANAGE_ORDER_YES','はい');
define('MANAGE_ORDER_NO','いいえ');

//2017.6.7
//define('FS_THEA_CTUAL_SHIPPING_TIME','実際出荷時間は予定日と少々相違しております、処理時間、宛先郵便番号、お選びなさる出荷サービス、決済の領収書によって異なります。');
define('FS_THEA_CTUAL_SHIPPING_TIME','私たちは常にマルチ倉庫システムで最速の配送を提供することに専念しています。詳細については、<a href="'.zen_href_link('shipping_delivery').'">配送ポリシー</a>をご覧下さい。');
//manage_orders & sales_service_list  2017.6.10		add 	ery
define('MANAGE_ORDER_SEARCH','すべての注文を検索します');
define('MANAGE_ORDER_FILTER','注文を選別する');
define('MANAGE_ORDER_BACK','戻る');
define('MANAGE_ORDER_APPLY','申請する');
define('MANAGE_ORDER_TYPE','注文タイプ');
define('MANAGE_ORDER_TIME_FILTER','時間を選別する');
define('FS_PLEASE_W_REVIEW','コメントを書いてください...');
define('ACCOUNT_TOTAL','小計');
define('ACCOUNT_OF_SHIPPING','送料：');
define('ACCOUNT_OF_TOTAL','合計：');
define('ACCOUNT_OF_TOTAL_JAPAN', '合計（税抜）：');
define("MANAGE_ORDER_VIEW_PO","POを見る");
define("MANAGE_PO_NUMBER","PO/ID#");
define('FS_REVIEWS_COMMENT_DEACRIPTION','すいませんが、コメントを残す前にログインするかアカウントを作成する必要があります。');
define('ACCOUNT_OF_GSP_TOTAL_AU','総GST金額');
define('FS_ORDERS_DETAILS_TAX_AU','合計');

//2017.8.3 add by frankie
define('TITLE_RELARED_DES',"すべてのトランシーバは対応機器、Cisco、Arista、Juniper、Dell、Brocadeなどブランドを利用して単独なテストを受け取りました。それに、FS.COMの自動品質保証システムに監視されて合格になります。");
define('TITLE_RELARED_01','40GBASE-SR4 850nm 150m MMF MTP/MPOコネクタ QSFP+ 光トランシーバ　');
define('TITLE_RELARED_02','100GBASE-SR4 850nm 100m QSFP28 光Transceiver');
define('TITLE_RELARED_03','40GBASE-LR4 および OTU3 1310nm 10km SMF LCコネクタ QSFP+ 光トランシーバ');
define('TITLE_RELARED_04','100GBASE-LR4 1310nm 10km QSFP28 光トランシーバ');
define('TITLE_RELARED_05','互換ブランド');

//2017.8.9 		add 	ery  税号
define('FS_VAT_PLEASE','有効な税金/付加価値税：例：DE123456789');
define('FS_VAT_NO','付加価値税番号がない');
define('FS_CHECK_OUT_STATE','州名を選択してください');
define('FS_CHECK_OUT_PLEASE','あなたの国名を入力してください');
define('FS_CHECK_OUT_INVALID','電話番号が無効です。もう一度お試しください。');
define('FS_CHECK_OUT_NEED','ヘルプを求める');
define('FS_CHECK_OUT_LIVE','ライブチャット');
define('FS_CHECK_OUT_EMAIL','今メールを送る');
define('FS_CHECK_OUT_TAX','税金');
define('FS_CHECK_OUT_TAX_RU','税金');
define('FS_CHECK_OUT_ORDER','注文一覧');
define('FS_CHECK_OUT_REMARKS','注文コメントを追加する（PO参照）');
define('FS_CHECK_OUT_CHANGE','編集する');
define('FS_CHECK_OUT_ADD','新しいアドレスを追加する');
define('FS_CHECK_OUT_REVIEW','商品＆配送情報一覧');
define('FS_CHECK_OUT_YOUR','製品');
define('FS_CHECK_OUT_ADDRESS','あなたの住所');
define('EMAIL_CHECKOUT_COMMON_VAT_COST','付加価値税');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2','付加価値税');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR','付加価値税');
define('FS_CHECK_OUT_INCLUDEING','(税込)');
define('FS_CHECK_OUT_EXCLUDING','(税抜)');

define('FS_CHECK_OUT_EXCLUDING_CA','上記合計には<a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">税金</a>が含まれておりません。');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE','(税抜)');

define('FS_CHECK_ADDRESS_TYPE',"アドレスタイプ");
define('FS_CHECK_OUT_ADTYPE_TIT',"このアドレスタイプは空白にすることはできません");
define('FS_CHECK_OUT_COMPANY_TIT',"この会社名は空白にすることはできません");
define('FS_ADDRESS_INVOCE','この注文請求書を電子メールで受信したい');

//checkout 运输方式
define('FS_CHECK_OTHERS','その他');
//2017.8.15 add  全站通用常量
define('FS_SER_COMMON_EMALl','Sales@fs.com');
define('FS_EMAIL','jp@fs.com');
//2017.8.24  add  ery checkout页面地址公司类型
define('FS_CHECK_OUT_SELECT','お選びください');
define('FS_CHECK_OUT_BUSINESS','企業');
define('FS_CHECK_OUT_INDIVIDUAL','個人');

//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');

//add by aron
define('FS_CHECK_OUT_UPDATE_NEW_TITLE',"配送先住所を更新する");
define('FS_CHECK_OUT_UPDATE_NEW_TITLE2',"請求先住所情報を編集する");

//add by frankie 2017.9.1
define('FS_DHLG','DHLエクスプレスドメスティック');
define('FS_DHLE','DHLエコノミーセレクト');
define('FS_DHLEE','DHLエクスプレスワールドワイド');
//add by frankie 2017.9.7
define('FS_WAREHOSE_CA_TIP','米国での倉庫、US$79以上のご注文は送料無料です');
define('FS_WAREHOSE_EU_TIP','ドイツでの倉庫、高速船舶の目的地： ');
define('FS_WAREHOSE_OTHER_TIP','中国での倉庫、高速船舶の目的地： ');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 免运费提示信息（每个站点显示不一样。不是直接翻译的）
define('FS_HEADER_FREE_SHIPPING_US_TIP','幅広い在庫製品は即日出荷可能です');
define('FS_FOOTER_FREE_SHIPPING_US_TIP','即日出荷');
define('FS_HEADER_FREE_SHIPPING_DE_TIP','幅広い在庫製品は即日出荷可能です');
define('FS_FOOTER_FREE_SHIPPING_DE_TIP','即日出荷');
define('FS_HEADER_FREE_SHIPPING_AU_TIP','幅広い在庫製品は即日出荷可能です');
define('FS_FOOTER_FREE_SHIPPING_AU_TIP','即日出荷');
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP','幅広い在庫製品は即日出荷可能です');
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP','即日出荷');

define('FS_M_FREE_SHIPPING_DE_TIP','$MONEY以上のご注文で送料無料');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','への高速配送');
define('FS_M_FREE_SHIPPING_AU_TIP','A$99以上のご注文で送料無料');
define('FS_M_SHIPPING_US_TIP','US$ 79以上のご注文で送料無料');

//2017-9-12  ery   add 层级属性定制提示语
define('PROINFO_CUSTOM_WAVE','他のご要求に応じて波長を書き込んでください。');
define('PROINFO_CUSTOM_GRID','他のご要求に応じてチャネル規格を書き込んでください。');
define('PROINFO_CUSTOM_RATIO','他のご要求に応じてカップリング率を書き込んでください。');
//2017-9-16   ery
define('GET_A_QUOTE','御見積書のお申し込み');
//add  by  ery  2017-10-12    产品详情页stock list板块
define('FS_STOCK_LIST_OTHER_ID','ID');
define('FS_STOCK_LIST_CENTER','中心波長(nm)');
define('FS_STOCK_LIST_CHANNEL','チャネル');
define('FS_STOCK_LIST_CWDM','SFP+ 10G CWDM 80km');
define('FS_STOCK_LIST_DWDM','SFP+ 10G DWDM 80km');
define('FS_DOWNLOAD','ダウンロード');
define('FS_DOWNLOADS', '資料ダウンロード');
define('FS_STOCK_LIST','在庫情報');
define('FS_STOCK_LIST_RECOM','マッチング製品');
define('FS_STOCK_LIST_ADD_TO_CART','カートに入れる');
define('FS_STOCK_LIST_PIC','画像');
define('FS_STOCK_LIST_ID','ID#');
define('FS_STOCK_LIST_DESC','商品説明');
define('FS_STOCK_LIST_PRICE','価格');
define('FS_STOCK_LIST_STOCK','在庫');
define('FS_SAVED_ITEMS','お気に入り品リスト');
define('FS_STOCK_OPTION','オプション');

//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_INSTALLATION','装備：');
define('FS_PRODUCT_INSTALLATION_TEXT','ラックに取り付けられる <a href="'.zen_href_link('product_info','products_id=30408','SSL').'" style="color: #0070BC;">FMU-1UFMX</a>シャーシに適用する');
define('FS_PRODUCT_INSTALLATION_TEXT2','ラックに取り付けられる');
define('FS_PRODUCT_INSTALLATION_TEXT3','FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4','シャーシに適用する');
define('FS_PRODUCT_INSTALLATION_TEXT5','ラックにマウント可能な<a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a>シャーシ用LGXカセット');
define('FS_PRODUCT_INFO_STEP','ステップ');

//2019.1.10 详情页评论
define('FS_REVIEWS34',' 役に立つ');
define('FS_REVIEWS35',' 役に立つ');
define('FS_REVIEW_REPORT','報告する');
define('FS_REVIEWS31','表示している');
define('FS_REVIEWS32','コメント');
define('FS_REVIEWS31_01','コメントを');
define('FS_REVIEWS32_01','つ表示');
define('FS_BY','より');
define('FS_REVIEWS36','コメント');
define('FS_REVIEWS_STARS_TITLE','顧客のレビュー：');
define('FS_READ_MORE','続きを読む');
define('FS_SEE_LESS','少なく読む');

define('FS_MOBILE_CLOSE','閉じる');

//2017.11.28 dylan 产品详情页图标描述
define('PRO_AUTHENTICATION_ICON_PLEASE','認証の詳細に関してはどうぞ<a href="'.zen_href_link('contact_us').'" target="_blank">お問い合わせください</a>。');
define('PRO_AUTHENTICATION_ICON_01','この製品は、EU RoHS 指令2015/863に準拠しています。RoSH2指令では電気・電子機器において具体的に、カドミウム、鉛、水銀、六価クロム、PBB（ポリ臭化ビフェニル）、PBDE（ポリ臭化ジフェニルエーテル）、フタル酸エステルなど4種類、合計10有害物質の使用が制限または禁止されています。');
define('PRO_AUTHENTICATION_ICON_02','この製品は、当社の最大の誠実さを反映することを目的とした生涯保証を提供します。');
define('PRO_AUTHENTICATION_ICON_03','この製品はISO9001に準拠しています。このシステムは、光ファイバー製品の開発、製造、供給サービスに携わる企業に有効です。');
define('PRO_AUTHENTICATION_ICON_04','この製品は、必須の健康と安全に適合していることを示すCEの要件に基づいて製造されています。');
define('PRO_AUTHENTICATION_ICON_05','この製品は、電波と磁界をより合理的に管理することを目的としたFCCと完全に合致しています。');
define('PRO_AUTHENTICATION_ICON_06','FDAは放射線放出電子製品の規制を担当しています。電子製品からの放射線への危険かつ不必要な暴露から人々を保護できます。');
define('PRO_AUTHENTICATION_LEARN','認証の詳細に関してはどうぞ');

//new
define('PRO_AUTHENTICATION_ICON_07','この製品はETLに完全に準拠しており、電気製品または機械製品に関連する業界標準に適合しています。');
define('PRO_AUTHENTICATION_ICON_08','この製品は、グローバルな安全コンサルティングおよび認証であるULの要件に基づいて製造されました。');
define('PRO_AUTHENTICATION_ICON_09','CBはIECEEが運営する国際システムです。この製品は、電気製品の安全性能をテストするためのIEC規格に準処しています。');

//
define('PRO_AUTHENTICATION_ICON_10','REACHは、化学物質の固有の特性をより早くかつ早期に特定することによって、人の健康と環境の保護を向上させることを目的とした欧州連合の規制です。');
define('PRO_AUTHENTICATION_ICON_11','この製品はRCMに準拠しております。これは、電気安全、EMC、EME、および電気通信の法的要件への準拠を示します。');
define('PRO_AUTHENTICATION_ICON_12', 'この製品は、EUの環境規制であるWEEEに完全に準拠しており、製品の回収、処理、リサイクルの向上を目的としています。');
define('PRO_AUTHENTICATION_ICON_13', 'この製品は3C認証に準拠しています。これは、消費者の個人の安全と国家の安全を保護し、製品の品質管理を強化するために、各国政府の法規制に従って実施される製品適合性評価システムです。');
define('PRO_AUTHENTICATION_ICON_14', 'VCCI（情報処理装置等電波障害自主規制協議会）マークは、日本のマルチメディア機器（MME）の必須認証であり、特にIT機器、製品のEMC認証である電磁式発射制御用です。この製品は、日本のVCCI認証に完全に準拠しています。');
define('PRO_AUTHENTICATION_ICON_15', 'TELECは、日本でのワイヤレス製品の強制認証であり、日本ではMIC認証とも呼ばれます。この製品は、日本に輸出されるワイヤレス製品（ブルートゥース製品、携帯電話、WIFIルーター、ドローンなど）に必要なTELEC認証に準拠しています。');
define('PRO_AUTHENTICATION_ICON_16', 'この製品はISO14001標準に満たされています。ISO14001とは、国際標準化機構（ISO）が策定した環境マネジメントシステムの認証規格であり、社会経済的ニーズとバランスを取りながら、環境を保護し、変化する環境状態に対応するための枠組みを組織に提供することを目的としています。');
define('PRO_AUTHENTICATION_ICON_17', 'この製品はロシアのTR CU認証（EAC認証）の基準に満たされています。これは、関税同盟加盟国の基準、および品質と安全性の要求を満たされていることを示します。');
define('PRO_AUTHENTICATION_ICON_18', 'この製品はUL（Underwriters Laboratories Inc.）に完全に準拠しており、ULによって確立された安全要件を満たしていることを示しています。 ');

//2018.9.6 Yoyo  add 产品详情  shipping&returns
define('FS_ASK_EXPERT','専門家に聞く:');
define('FS_ASK_EXPERT_1','お問い合わせ');
define('SOLUTION_SUB_PAGE_05','プロジェクトのお問合せ');

//fairy 整理公共的
// 公共表单
define('FS_TAX_ERROR_EMPTY','有効な税番号をご入力ください。');
define('FS_SECURITY_ERROR', 'セキュリティエラーが発生しました。'); // token验证不正确
define('FS_SYSTME_BUSY', 'アクセスが集中しておりますので、少し時間が経ってからもう一度お試しください。'); // 异步提交，连接服务器出现error情况
define('FS_ACCESS_DENIED', 'エラー：アクセスが拒否されました。'); //没有权限访问
define('FS_ACCESS_DENIED_1', 'エラー: コード999');
define('FS_FORM_REQUEST_ERROR', 'システムがビジー状態です,もう一度試してください');
define('FS_NON_MANDAROTY',"必須ではない");
define('FS_COMMON_SAVE',"保存する");
define('FS_COMMON_CANCEL',"キャンセル");
define('FS_COMMON_YES',"はい");
define('FS_COMMON_NO',"いいえ");
define('FS_COMMON_SUBMIT',"提出");
define('FS_COMMON_EDIT','編集');
define('FS_COMMON_LESS',"隠す");
define('FS_CONFIRM','確認する');
define("FS_PLEASE_CHOOSE_ONE",'一つ選んでください...');

//验证码 start
define('FS_ENTER_CHARACTER',"下の絵に出てくる文字を入力してください。");
define('FS_IMAGE_REQUIRED_TIP',"画像に文字を入力してください。");
//验证码-服务器端的验证
define('FS_IMAGE_ERROR_TIP',"入力されたコードが画像と一致しませんので、もう一度お試しください。");
define('FS_IMAGE_EXPIRE_TIP',"長時間の操作はありませんので、文字を更新して再入力してください。");
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP',"アカウントをより安全に保護するために、パスワードを再入力してから、次の画像に表示されている通りに文字を入力してください。");
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP',"アカウントをより安全に保護するために、メールアドレスを再入力してから、次の画像に表示されている通りに文字を入力してください。");
//验证码 end

// 公共的
define('FS_USERNAME','ユーザー名');
define('FS_FIRST_NAME',"姓");
define('FS_LAST_NAME',"名");
define('FS_PASSWORD',"パスワード");
define('FS_EMAIL_ADDRESS',"メールアドレス");
define('FS_EMAIL_ADDRESS1',"メールアドレス");
define('FS_COMPANY_WEBSITE',"会社ウェブサイト");
define('FS_INDUSTRY',"業界");
define('FS_COMPANY_NAME',"会社名");
define('FS_ENTERPRISE_OWNER_NAME',"企業所有者の名前");
define('FS_YOUR_COUNTRY',"国/地域");
define('FS_COUNTRY',"国家");
define('FS_OTHER_COUNTRIES'," 他の国々/区域");
define('FS_SELECT_YOUR_COUNTRY_REGION','あなたの国/地域を選択してください');
define('FS_SELECT_COUNTRY_REGION','国/地域の選択');
define('FS_COMMON_COUNTRY_REGION','共通の国/地域');
define('CURRENT','現行');
define('MAIN_MENU','メインメニュー');
define('FS_SELECT_CURRENCY','言語/貨幣をお選びください');
define('FS_LANGUAGE_CURRENCY','言語/貨幣');
define('FS_VAT_NUMBER',"付加価値税/税号");
define('FS_PHONE_NUMBER',"電話番号");
define('FS_COMMON_COMPANY','会社');
define('FS_FOOTER_COMPANY_INFO',"会社概要");
define('FS_EMAIL_FSCOM',zen_href_link(FILENAME_DEFAULT));
define('FS_QTY','数量');
define('FS_OPTIONAL_COMPANY',' (任意)');
// 公共的
define('FS_OR', 'または ');
define('FS_OTHERS','その他');
define('FS_LOADING',"読み込み中");
define('FS_SHOW',"表示する");
define('FS_HIDE',"隠す");
define('FS_HELLO','こんにちは');
define('FS_HELLO_JP','様、');
define('FS_HELLO_JP_NEW','様');
define('FS_SORT','ソート');
define('FS_COMMON_MORE','もっと');
define('FS_COMMON_CUSTOMIZED','カスタム');
// 公共的
define('FS_COPY',"Copyright");
define('FS_RIGHTS',"All Rights Reserved");
define('FS_TERMS_OF_USE',"利用規約");
define('FS_POLICY',"情報セキュリティポリシー ");
define('FS_AGREE_POLICY','下のボタンをクリックすると、当社の<a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'" target="_blank">情報セキュリティポリシーに関するポリシー</a>と<a href="'.HTTPS_SERVER.reset_url('policies/terms_of_use.html').'" target="_blank">利用規約</a>に同意したことになります。');
define('FS_FOOTER_COOKIE_TIP','お客様にベストな体験をご提供するために弊社ウェブサイト上でCookieを使用いたします。このサイトを引き続き使用することにより、<a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">クッキーポリシー</a>に同意したものと見なされます。');
define('FS_FOOTER_COOKIE_MOBILE_TIP','お客様に良いショッピング体験を提供するためにCookieを使用しています<a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Cookie ポリシー</a>をご覧ください。');
define('FS_I_ACCEPT','I accept');
define('FS_WRITE_OTHER_DEVICES','例:Cisco N9K-C9396PX');
define('HPE_LIMIT', '特別な材質のため、ご注文商品に対応ブランド「VAL_XXX」をご選択頂き、デバイス番号もご記入頂くようにお願いたします。');
define('model_number_empty','お使いのデバイスのモデル番号をご記入ください。');

// 2018.4.3 fairy 报价
define('FS_GET_A_QUOTE_BIG', '御見積書のお申し込み');
define('FS_GET_A_QUOTE_FREE', 'ボックスを申請する');
define('FS_GET_A_QUOTE', '御見積書のお申し込み');
define('FS_REQUEST_DEADLINE','リクエストは予定どおりに終了しました。アップデートされたバージョンがすぐに利用可能になりますので、待ちください。');

//2018.5.2 add by frankie
define("FS_WAREHOUSE_EU","ドイツ倉庫");
define("FS_WAREHOUSE_US","アメリカ倉庫");
define("FS_WAREHOUSE_CN","中国倉庫");
define("QTY_SHOW_ZERO","在庫あり、");
define("QTY_SHOW_MORE","在庫あり、");
define("QTY_SHOW_ZERO_STOCK","個数");
define("QTY_SHOW_MORE_STOCK","個数");
define("QTY_SHOW_ZERO_STOCK_1","在庫あり");
define("QTY_SHOW_MORE_STOCK_2","在庫あり");
define("QTY_SHOW_AVAILABLE","提供可能");
define('QTY_SHOW_IN_CN_STOCK_1','在庫納入中');
//add by quest 2019-03-08
define("QTY_SHOW_AVAILABLE_NEW_INFO","在庫納入中");
define("QTY_SHOW_AVAILABLE_TAG_NEW_INFO","在庫納入必要");

//2018.5.17
define('FS_MANAGE_ORDERS_RECORDA','1ページあたりの記録');
define('MANAGE_ORDER_SEARCH_NO','PO/注文番号/ID');
define('FIBER_CHECK_USE','自分の配送口座を使用する');
define('FIBER_CHECK_FREE','無料');
define('FIBER_CHECK_FREE_SHIPPING','無料');
define('FS_ORDER_DATE','注文日付:');
define('FS_TOTAL_AMOUNT','合計金額:');
define('FS_HOME','ホーム');
define('FS_TOTAL','全部');
define('FS_ALL_REVIEWS','すべてのレビュー');
define('FS_REVIEWS_WITH_PICTURES','写真付き評価する');
define('FS_CUSTOMER_REVIEWS','顧客レビュー');
define('FS_YOUR_RECENT_HISTORY','最近チェックした商品');
define('FS_PROCEED_A','へ進む ');
define('FS_ADDRESS_FIRST_REQUIRED_TIP','姓をご入力ください。');
define('FS_ADDRESS_LAST_REQUIRED_TIP','名をご入力ください。');
define('FS_ADDRESS_POSTAL_REQUIRED_TIP','ZIP/郵便番号をご入力ください。');
define('FS_BULK_WAREHOUSE','中国倉庫から配送');
define('REGITS_FROM_GUEST_EXSIT1','この電子メールアドレスはすでにシステムに存在しています、どうぞ、直接にログインしてください。');
define('REGITS_FROM_GUEST_EXSIT2','ログイン »');
define('FS_QTY_CHANGED','ご注文を迅速に処理するために早めにご完済ください。そうしないと、多分在庫変更の原因でご注文は配送が遅れる可能性があります。');
define('HOT_PRODUCTS','人気な商品');

//春节设置,请勿乱修改,1->开启春节分仓 0->关闭春节分仓
define("FS_IS_SPRING",0);

// fairy 2018.05.18 搜索页面
define('FS_PRICE_LOW_HIGH', '価格: 安い順');
define('FS_PRICE_HIGH_LOW', '価格: 高い順');
define('FS_RATE_HOGH', '評点：高い順');
define('FS_NEWEST_FIRST', '新着順');
define('FS_POPULARITY', '人気');

/*仓库表达*/
define("FS_FOR_FREE_SHIPPING_GB1"," イギリス 配送無料");
define("FS_FOR_FREE_SHIPPING_GB3","$79以上のご注文で");
define("FS_FOR_FREE_SHIPPING_GB4","イギリス");
define('FS_ITEM_LOCATION','アイテム所在地:');
define('FS_SEATTLE_WASHINGTON','シアトル、アメリカ');
define('FS_SEATTLE_EU','ミュンヘン、ドイツ');
define('FS_SEATTLE_CN','中国武漢');

//详情页Compatible Brands提示 dylan 2019.11.18
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_01','例: Cisco N9K-C9396PX to Juniper MX960');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_02','例: Cisco N9K-C9396PX QSFP+ to Juniper MX960 SFP+');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_03','例: Cisco N9K-C9396PX QSFP+ to Juniper EX4200 XFP');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_04','例: Cisco N9K-C9396PX QSFP28 to Juniper QFX5200 SFP28');
define('FS_PRODUCTS_COMPATIBLE_BRANDS_TIPS_05','例: Cisco Nexus 5696Q CXP to Juniper MX960 QSFP+');

define('FS_SELECT_TYPE','これは弊社のお客様がよく購入する製品仕様です。');
define('FS_SELECT_DEFAULT','デフォルト');
define('FS_SELECT_CUSTOMIZE','カスタム');
define('FSCHOOSE_SPECI','仕様をご選択：');

define("FS_WAREHOUSE_AREA_SG","シンガポール倉庫から出荷");
define("FS_WAREHOUSE_AREA_PR",'FSアメリカから出荷');
//分仓分库语言包
define("FS_ITEMS_CK","あなたの商品");
define("FS_WAREHOUSE_AREA_1","アジア倉庫から出荷");
define("FS_WAREHOUSE_AREA_2","アメリカ倉庫から出荷");
define("FS_WAREHOUSE_AREA_3","ドイツ倉庫から出荷");
define("FS_WAREHOUSE_AREA_4","- 利用可能、即日発送");
define("FS_WAREHOUSE_AREA_5","- 利用可能、発送予定日 ");
define("FS_WAREHOUSE_AREA_6","今回の購買は以下に分かれています： ");
define("FS_WAREHOUSE_AREA_7","パッケージ");
define("FS_WAREHOUSE_AREA_8","アイテム");
define("FS_WAREHOUSE_AREA_9","商品価格");
define("FS_WAREHOUSE_AREA_10","数量");
define("FS_WAREHOUSE_AREA_11","単価");
define("FS_WAREHOUSE_AREA_12","お客様はまだPO（注文書）ファイルをアップロードしていないならば、どうぞ");
define("FS_WAREHOUSE_AREA_13","私の注文");
define("FS_WAREHOUSE_AREA_14","ページにアクセスしアップロードしてください。PO（注文書）が確かめられるまで、ご注文を処理することができません。");
define("FS_WAREHOUSE_AREA_15","この度はご注文いただきまして誠にありがとうございました -");
define("FS_WAREHOUSE_AREA_16","! 下記はお客様の最新の予約注文概要です。ただ最後のワンステップでお支払いが完了できったら、すべての製品は手に入る事になります。");
define("FS_WAREHOUSE_AREA_17","この度ご注文いただき誠にありがとうございました！ご注文を承りました。ご注文の処理をお待ちしております。 ");
define("FS_WAREHOUSE_AREA_18","FS.COMにてお買い上げいただき、ありがとうございます。 ご注文 #");
define("FS_WAREHOUSE_AREA_19"," は ");
define("FS_WAREHOUSE_AREA_20"," 承りました。しかし、お支払い手続きは完了していません。これらのアイテムを必要とするならば、直接当社のpaypal口座に送金することができます：paypal@fs.com　。");
define("FS_WAREHOUSE_AREA_21","もしpaypal(ペイパル)お支払いに関する問題または質問があれば、私たちにご連絡ください。 ");
define("FS_WAREHOUSE_AREA_22","まだ設定されていません");
define("FS_WAREHOUSE_AREA_23","受注済み、処理待ち");
define("FS_WAREHOUSE_AREA_24","ご注文を承りました。しかし、お支払い手続きは完了していません。");
define("FS_WAREHOUSE_AREA_25","クレジットやデビットカードでのお支払いに関する問題または質問があれば、私たちにご連絡ください。");
define("FS_WAREHOUSE_AREA_26","受注済み、保留中");
define("FS_WAREHOUSE_AREA_27","何か問題や質問がございましたら、");
define("FS_WAREHOUSE_AREA_28","どうぞ、お気軽にこちらまでご連絡ください。");
define("FS_WAREHOUSE_AREA_29","注文番号：");
define("FS_WAREHOUSE_AREA_30","配送方法：");
define("FS_WAREHOUSE_AREA_31","FS.COMよりのご注文...");
define("FS_WAREHOUSE_AREA_32","お買い上げ誠にありがとうございました。こちらはご注文の詳細でございます。今はPO（注文書）の確認をお待ちしております。");
define("FS_WAREHOUSE_AREA_33","お買い上げ誠にありがとうございました。こちらはご注文の詳細でございます。</br>注意：お届け先住所は、与信取引申請書にある住所と一致しません。ご注文は審査が必要となり、結果は12時間以内にあなたに電子メールで送られます。");
define("FS_WAREHOUSE_AREA_34","お買い上げ誠にありがとうございました。こちらはご注文の詳細でございます。</br>注意：お届け先住所は、与信取引申請書にある住所と一致しません。ご注文金額はFS.COMの与信限度額を超えています。
 迅速に注文の処理を取得するには、与信限度額を上げるために以前の注文をご完済ください。または、「私のアカウント」ページへ進んで「注文書」をクリックし、「与信限度額を上げる」を申し込んでください。審査の結果はメールでお知らせいたします。");
define("FS_WAREHOUSE_AREA_35","お買い上げ誠にありがとうございました。こちらはご注文の詳細でございます。</br>注意：ご注文金額はFS.COMの与信限度額を超えています。迅速に注文の処理を取得するには、与信限度額を上げるために以前の注文をご完済ください。
 または、「私のアカウント」ページへ進んで「注文書」をクリックし、「与信限度額を上げる」を申し込んでください。審査の結果はメールでお知らせいたします。");

/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36","アメリカの祝日のため、出荷が遅れる場合もございますのでご注意下さい。");
define("FS_WAREHOUSE_AREA_TIME_37","オーストラリアの祝日のため、出荷が遅れる場合もございますのでご注意下さい。");
define("FS_WAREHOUSE_AREA_TIME_38","ドイツの祝日のため、出荷が遅れる場合もございますのでご注意下さい。");
define("FS_WAREHOUSE_AREA_TIME_39","シンガポールの祝日のため、出荷が遅れる場合もございますのでご注意下さい。");
define("FS_WAREHOUSE_AREA_TIME_42","中国の祝日のため、出荷が遅れる場合もございますのでご注意ください。");
define("FS_WAREHOUSE_AREA_TIME_40","週末のため、出荷が遅れる場合もございますのでご注意下さい。");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">閉じる</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","ご都合の良い時間でアメリカ倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_TIME_44","ご都合の良い時間でドイツ倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_TIME_45","ご都合の良い時間でオーストラリア倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_TIME_46","ご都合の良い時間でアジア倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_TIME_47","ご都合の良い時間でシンガポール倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_SHIP_CN"," アジア倉庫から出荷");
define("FS_WAREHOUSE_AREA_SHIP_US","アメリカ倉庫から出荷");
define("FS_WAREHOUSE_AREA_SHIP_AU","オーストラリア倉庫から出荷");
define("FS_WAREHOUSE_AREA_SHIP_DE","ドイツ倉庫から出荷");
define("FS_WAREHOUSE_AREA_SHIP_SG","·シンガポール倉庫から出荷");
define("FS_PICK_UP_WAREHOUSE", "倉庫にピックアップ");
/*end*/

//公用头部账户板块
define('FS_COMMON_HEADER_ACCOUNT','アカウント');
define('FS_COMMON_HEADER_CASES','ケース');
define('FS_COMMON_HEADER_NOT','本人じゃないの？');
define('FS_COMMON_HEADER_OUT','ログアウト');
define('FS_ACCOUNT_NO','No. ');

//2017-12-15  ery  add  前台相关打印发票页面的公司地址
// 武汉仓
define('FS_COMMON_WAREHOUSE_CN','ATTN: FS. COM LIMITED<br> 
			Address: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China<br>
			Tel: +86-0755-83571351');
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');

// 德国仓
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany<br>
			Tel: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States <br>
			Tel: +1 (888) 468 7419');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST','ATTN: FS.COM Inc.<br>
					Address: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States<br>
					Tel: +1 (888) 468 7419');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','ATTN: FS Tech Pte Ltd.<br>
				Address: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: +(65) 6443 7951');
//游客页面注册
define("REGITS_FROM_GUEST_EMAIL_ERROR1","電子メールアドレスは必要とされます。");
define("REGITS_FROM_GUEST_EMAIL_ERROR2","有効な電子メールアドレスをご記入ください。（例：someone@gmail.com)");
define("REGITS_FROM_GUEST_EMAIL_ERROR3","有効な電子メールアドレスを記入してください。");
define("REGITS_FROM_GUEST_PASSWORD_ERROR1","6文字以上でなければならないようにします；少なくとも1つの字母と1つの数字");
define("REGITS_FROM_GUEST_PASSWORD_ERROR2","パスワードは一致している必要があります。");
define("REGITS_FROM_GUEST_ASK","今すぐアカウントを作成しますか？");
define("REGITS_FROM_GUEST_CAN","良いサービスのためにもう一つのステップだけです。FS.COMアカウントを利用すれば下記のメリットを楽しめます：");
define("REGITS_FROM_GUEST_EASY","注文履歴による簡単に追跡できる");
define("REGITS_FROM_GUEST_FASTER","アドレス帳を利用して迅速にチェックアウトできる");
define("REGITS_FROM_GUEST_NO","いいえ、結構です。");
define("REGITS_FROM_GUEST_YES","はい、アカウントを作成したいです。");
define("REGITS_FROM_GUEST_USE","チェックアウト用電子メールを使用");
define("REGITS_FROM_GUEST_OR","または");
define("REGITS_FROM_GUEST_HISTORY","お客様のチェックアウト電子メールアドレスは登録電子メールアドレスと相違あれば、良いサービスのために両方は自動に関連付けられます。注文に関する確認メールは登録した時ご利用になった電子メールに送信されます。この登録電子メールを利用し、お客様はいつでもご注文を管理＆追跡できます。");
define("REGITS_FROM_GUEST_PASWORD","パスワード");
define("REGITS_FROM_GUEST_CPASWORD","パスワードを確認する");
define("REGITS_FROM_GUEST_NOTE",'ご注意：国際配送のために、配送会社のシステムには日本語入力ができませんので、お客様の住所を英語で入力してください。お客様の電話番号は、配送するためにのみ使用されます。及びお客様の電子メールアドレスはご注文ステータスの更新ために使用されます。<br>もっと情報を見るために <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">情報セキュリティポリシー、クッキー（Cookie）ポリシー</a>をご覧ください。');
define("REGIST_NUM_LENGTH","6文字以上");
define("REGIST_NUM_LEAST","6文字以上でなければならないようにします；少なくとも1つの字母と1つの数字を含んでいます。");

/*
 *客户分享购物车邮件（不同部分）
 */
define('FS_EMAIL_PAST','購買履歴および ');
define('FS_EMAIL_SAVED','今後のために保存済みアイテムに関するカートリストを受けています。下のリンクを押し、これらのアイテムの詳細をご覧ください。さらに、お買い物しましょう');
define('FS_EMAIL_MESSAGE','あなたのメッセージ:');
define('FS_EMAIL_SENT','こちらの電子メールはあなたのカートリストから ');
define('FS_EMAIL_CART','送られてきました。');
define('FS_EMAIL_PAST_1',' さんはあなたがFS.COMからこれらのアイテムに興味があると思います。下のリンクを押し、これらのアイテムの詳細をご覧ください。さらに、お買い物しましょう⇒');
define('FS_EMAIL_MESSAGE_1',"さんよりのメッセージ：");
define('FS_EMAIL_SENT_1','こちらの電子メールはお友達 ');
define('FS_EMAIL_URL_1',HTTPS_SERVER.reset_url('policies/privacy_policy.html'));
define('FS_EMAIL_USING_1',' が ');
define('FS_EMAIL_SHARE',"の「共有するサービス」を利用するで送られました。このメッセージを受け取るには、お客様はFS.COMからの迷惑メールを受け取ることはありません。 ");
define('FS_EMAIL_OUR',"私たちをもっと見るには、 ");
define('FS_EMAIL_POLICY',"情報セキュリティポリシー");
define('FS_EMAIL_POLICY_1',"の");
define('FS_EMAIL_POLICY_2',"を同意します。");
define('FS_EMAIL_CART_1','お友達');
define('FS_EMAIL_CARTS_1','からのカートリストをあなたと共有しました！');
define('FS_EMAIL_TO_US_DEAR','お客様 ');
define('FS_EMAIL_SIN','真摯に');
define('FS_EMAIL_TEAM','顧客サービスチーム');
define('FS_EMAIL_FS','FS.COM');

//产品详情页
define("FS_FOR_FREE_SHIPPING","US$79以上のご注文は");
define("FS_SG_FREE_SHIPPING","無料配送とインストール");
define("FS_SG_NO_FREE_SHIPPING","無料インストール");
define("FS_FOR_FREE_SHIPPING_US","は送料無料です。");
define("FS_FOR_FREES_SHIPPING_ONE","明日それを買う");
define("FS_FOR_FREES_SHIPPING_TWO","お客様が ");
define("FS_FOR_FREES_SHIPPING_TIME","午後4時（PST）");
define("FS_FOR_FREES_SHIPPING_TIME_UP","午後4時（PST）");
define("FS_FOR_FREES_SHIPPING_THREE","までに発注するご注文はチェックアウトする時に、「Overnight Shipping」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FOUR","配送する：");
define("FS_FOR_FREES_SHIPPING_FIVE","<span>午後4時（PST）</span>までに発注するご注文は、1〜3営業日以内に配達されます。");
define("FS_FOR_FREES_SHIPPING_FIVE_CA_UP","<span>午後4時（PST）</span>までに発注するご注文は、1〜3営業日以内に配達されます。");
define("FS_FOR_FREES_SHIPPING_FIVE_MX_UP","<span>午後4時（PST）</span>までに発注するご注文は、1〜3営業日以内に配達されます。");
define("FS_FOR_FREES_SHIPPING_SIX","火曜日に配送したいですか？チェックアウト時に「Overnight Shipping」をご選択ください。");
define("FS_FOR_FREE_SHIPPING_DE","US$79以上のご注文は ");
define("FS_FOR_FREE_SHIPPING_DE_MONEY"," は送料無料です。");


//add by quest 2019-03-11   // 2019 3.18 po产品 shipping弹窗 pico
define("FS_FOR_FREE_SHIPPING_PRE_ORDER","は送料無料です。");
define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE',"先行予約サービス、大量供給 & 節約予算");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO',"中小企業と大企業により良いサービスを提供するために、FSは10,000平方メートルの製造業者に投資し、大量生産によって予算を削減し、プロジェクトの納入を達成するのに役立つ先行予約サービス指向の生産ラインを追加しております。");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', "予約商品の処理時間は約15営業日です。したがって、お客様は事前にスケジュールされたプロジェクトの購入計画を立てることができます。");
define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', "当社は製造と徹底的なテストの後に商品を出荷します。発送速度は、チェックアウト時に選択した発送方法によって異なります。<br><br> <a href ='".zen_href_link('index')."specials/pre-order-service-71.html' target='_blank'>先行予約サービス</a>の詳細をご覧ください。");


//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','保証 & 返品');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','東南アジアへの高速配送');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','<p>製品が到着後、もしご満足いただけない場合、FS保証により、製品の返品、交換、修理が可能です。</p><br/>
<p>ほとんどの在庫品について、製品が到着後日30以内に、返品＆払い戻し及び交換サービスを提供しております。保証期間内の場合、無料の修理サービスも引き続き提供しております。</p><br/>
<p>消耗品については、保証期間及び無料の修理サービスを提供しておりません。製品が到着後、もし品質上に問題がある場合、お気軽にお問い合わせください。素早く対応いたします。詳しい内容については、<a href="'.reset_url("/jp/policies/day_return_policy.html").'" target="_blank">返品規則</a>及び<a href="'.reset_url("/jp/policies/warranty.html").'" target="_blank">保証</a>ページをご覧ください。</p>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FSは、スケジュールや予算に合わせて複数の配送オプションを提供しております。在庫がある注文は、注文後24営業時間以内に発送されます。詳細については、<a href="'.reset_url("shipping_delivery.html").'" target="_blank">出荷 & 配達</a>をご覧ください。</div>');


//修改2018.5.8
define("FS_FOR_FREES_SHIPPING_FIVE_DE1"," <span>午後4時（UTC/GMT +2）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE2"," <span>午後4時（UTC/GMT +2）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE3","より迅速な配達をしたいですか？<span>午後4時（UTC/GMT +2）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE4"," <span>午後3時（UTC/GMT +1）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE5"," <span>午後3時（UTC/GMT +1）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE6","より迅速な配達をしたいですか？<span>午前11時（UTC/GMT -3）</span>までに発注するご注文はチェックアウトする時に、「DHL Express 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE7","より迅速な配達をしたいですか？<span>午後6時（UTC/GMT +4）</span>までに発注するご注文はチェックアウトする時に、「DHL Express 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE8","より迅速な配達をしたいですか？<span>午後3時（UTC/GMT +1）</span>までに発注するご注文はチェックアウトする時に、「DHL Express 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE9","より迅速な配達をしたいですか？<span>午後5時（UTC/GMT +3）</span>までに発注するご注文はチェックアウトする時に、「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE10"," <span>午後4時（UTC/GMT +3）</span>までに発注するご注文はチェックアウトする時に、「DHL Express 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE11","より迅速な配達をしたいですか？<span>午前12時（UTC/GMT -2）</span>までに発注するご注文はチェックアウトする時に、「DHL Express」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE12","火曜日に配送するには、1〜3営業日以内に配達されます。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE13","火曜日に配送したいですか？チェックアウト時に「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE14","火曜日に配送したいですか？チェックアウト時に「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE15","より迅速な配達をしたいですか？チェックアウト時に「UPS Express Plus Next Day 9:00am」をご選択ください。");
define("FS_FOR_FREES_SHIPPING_FIVE_DE16","より迅速な配達をしたいですか？チェックアウト時に「DHL Express」をご選択ください。");


define("FS_SHIPPING_POLICY_US","配達予定日は営業日の午後5時（EST）までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_CA","配達予定日は営業日の午後5時までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_MX","配達予定日は営業日の午後4時までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_NZ","配達予定日は営業日の午後3時（AEST/AEDT）までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_AU","配達予定日は営業日の午後3時（AEST/AEDT）までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_GB","配達予定日は営業日の".FS_SUMMER_OR_WINTER_TIME."までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_DE","配達予定日は営業日の".(SUMMER_TIME ? '4:30pm (UTC/GMT+2)' : '4pm (UTC/GMT+1)')."までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_CN","ここで表示された配達日は、営業日の日本時間午後4時30分までに購入された在庫品目に適用されます。ご希望の数量が在庫量を超える場合は、追加費用なしで別のパッケージで発送されます。詳しい情報については、決済ページをご覧下さい。");
define("FS_SHIPPING_POLICY_SG","配達予定日は営業日の午後3時30分（GMT+8）までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、追加送料なしで2つのパッケージに分割されて配送されます。詳細は決済ページをご覧ください。");
define("FS_SHIPPING_POLICY_RU","ここで表示された配達日は、営業日の日本時間午前10：30(UTC/GMT+3)までに購入された在庫品目に適用されます。ご希望の数量が在庫量を超える場合は、追加費用なしで別のパッケージで発送されます。詳しい情報については、決済ページをご覧下さい。");

//2017-11-2   add  ery  国家下拉框搜索提示语
define('FS_COUNTRY_SEARCH','国/地域をご検索ください。');
define('FS_COUNTRY_US','アメリカ合衆国');

//运费公共
define('FIBER_CHECK_TWO', 'UPS 2nd Day Air® サービス');
define('FIBER_CHECK_TWO_AM','UPS 2nd Day A.M.® サービス');
define('FIBER_CHECK_STAND','UPS Ground® サービス');
define('FIBER_CHECK_ONE','UPS 翌日® サービス');

define('FIBER_FEDEX_CHECK_OVER','FedEX Overnight® サービス');
define('FIBER_FEDEX_CHECK_TWO','FedEX 2Day® サービス');
define('FIBER_FEDEX_CHECK_GROUND','FedEX Ground® サービス');

define('FS_CHECKOUT_SERVICE','サービス');

//支付方式
define('FS_PAYMENT_METHOD_PAYPAL','Paypal（ペイパル）');
define('FS_PAYMENT_METHOD_WESTERN_UNION','ウエスタンユニオン国際送金');
define('FS_PAYMENT_METHOD_WIRE_TRANSFER','電信送金');
define('FS_PAYMENT_METHOD_PURCHASE_ORDER','注文書（PO）');
define('FS_PAYMENT_METHOD_CREDIT_CARD','クレジット/デビットカード');
define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | 月曜日-金曜日');
define("FS_JS_TIT_CHECK1","</br>ピックアップ時間：");
define("FS_JS_TIT_CHECK2","太平洋標準時：");
define("FS_JS_TIT_CHECK3","月曜日 - 金曜日");
define("FS_JS_TIT_CHECK4","10:00am - 12:00am");
define("FS_JS_TIT_CHECK5",", 2:00pm - 5:30am ");
define("FS_JS_TIT_CHECK_US","午前9時30分 ～ 午後5時30分");
define("FS_JS_TIT_CHECK6","写真付きの身分証明書にあるお名前");
define("FS_JS_TIT_CHECK7","電子メールアドレス");
define("FS_JS_TIT_CHECK8","電話番号");
define("FS_JS_TIT_CHECK9","貨物引取り時間");
define("FS_TIME_ZONE_RULE_AU","(AEST)");
define("FS_JS_TIT_CHECK_AU","9:30am - 5pm ");
define("FREE_SHIPPING_TEXT1","€79以上のお買い上げは送料無料（大型商品を除く）。");
define("FREE_SHIPPING_TEXT2","$79以上のお買い上げは送料無料（大型商品を除く）。");
define("FS_TIME_ZONE_RULE_US","(UTC/GMT+1)");
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
define("FS_POPUP_TIT_ALERT2","当社は私書箱に配送しません");
define('FS_LIMIT_MONEY',"総金額は制限を超えましたので、注文を分割してまたは他のお支払い方法をお選びください！");
define('FS_LIMIT_MONEY_15000',"決済金額が上限（€15000）を超える場合は、注文を分割するか、他の支払い方法をご選択ください。");
define('FS_LIMIT_MONEY_10000',"決済金額が上限（€10000）を超える場合は、注文を分割するか、他の支払い方法をご選択ください。");

define('FS_ADDRESS_PHONE_REQUIRED_TIP','お電話番号をご入力ください。');
define('ACCOUNT_EDIT_CITY_FROMAT_TIP','市名は最小で2文字を入力しなければなりません。');
define('FS_VAT_PLEASE_REQUIRED','TAX/VATは必須です。');
define('FS_ADDRESS_STREET_FORMAT_TIP','住所欄1は4〜35文字で入力する必要があります。');
define('FS_ADDRESS_STREET_PO_BOX_TIP','私たちはPOボックスには出荷しません。');
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP','住所2は最小で2文字を入力しなければなりません。');

//产品详情页长度定制框语言包
define('FS_LENGTH_CUSTOM_FEET','フィートまたは');
define('FS_LENGTH_CUSTOM_METER','メートル');
define('FS_PRODUCTS_AOC_LENGTH_ERROR','ケーブルの長さは、必要に応じて0.5m～100m（1.64ft～328.084.ft）にカスタマイズできます。');

//2018-3-15  ery  add  订单上传logo
define('FS_ATTRIBUTE_OEM','OEM/ODMサービス');
define('NEWS_FS_ATTRIBUTE_OEM','カスタムラベルサービス');
define('FS_ATTRIBUTE_NONE','なし');
define('FS_ATTRIBUTE_DESIGN','ラベルデザイン');

//2017-10.12  dylan 产品详情页installation属性
define('FS_PRODUCT_CUSTOMIZATION_TEXT','FMUプラグインモジュールはラックに取り付けられる ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1','FMT-CH');
define('FS_PRODUCT_CUSTOMIZATION_TEXT2','プラグ可能モジュールはラックに取り付けられる ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3','FUDプラグインモジュールはラックに取り付けられる ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4','FMU-1UFMX');
define('FS_PRODUCT_CUSTOMIZATION_TEXT5',' シャーシに適用する');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6','FUD-1UFMX-N');
define('FS_PRODUCT_CUSTOMIZATION_TEXT7','プラグインタイプに適合する ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8','FS-2U-RC001');
define('FS_PRODUCT_ITEM','製品ID: ');

define('FS_PRODUCT_INFO_BRAND_CHOOSE','ブランドを選択する');
define('HPE_LIMIT','特殊材料のためどうぞ、"VAL_XXX" の互換性を選択し、それにモデル番号をご記入ください。');
define('HPE_LIMIT2', '特殊な素材により、「VAL_XXX」との互換性はご注文にはご利用いただけません。');
define('FS_CHECKOUT_PAYMENT_ORDER_ORDER','今回の購買は二つの注文に分かれています。');
define('FS_MANAGE_ORDERS_PURCHASE',"注文書番号を空にすることはできません");
define("FS_MANAGE_ORDERS_FILE","POファイルを添付してください。");

//2018-3-15  ery  add  订单上传logo
define('FS_ORDER_LOGO_DESIGN',"ラベル・ロゴデザインをアップロードする");
define('FS_ORDER_LOGO_YOUR',"参考のために、あなたのラベル・ロゴデザイン、特定のベンダー名または製品番号をアップロードしてください。");
define('FS_ORDER_LOGO_WE',"我々はあなたに連絡してご注文に応じるラベルを確認していきます。それに、お客様に完成したロゴをメール（画像）で送信します。");
define('FS_ORDER_LOGO_UPLOAD',"ロゴをアップロードする");
define('FS_ORDER_LOGO_DELETE',"この画像を削除しますか？");
define('FS_ORDER_LOGO_UP_SUCCESS','ロゴファイルのアップロードに成功しました！');
define('FS_ORDER_LOGO_DEL_SUCCESS','この画像の削除に成功しました！');

//客户追问成功
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01','新しい返信 - ');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02','ケース');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03','各位様');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04','お客様');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05','に提出されたケースは以下の通り回答します：');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06','-アカウントマネージャー:');
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07','-エンジニア:');

define('FS_COMMON_LEVEL_WAS','原価');
define('FS_SALES_DETAILS_NO','RMA番号');
define('FS_SALES_DETAILS_STATUS','RMA ステータス');
define('FS_SALES_DETAILS_CR','RMAをキャンセル');
define('FS_SALES_DETAILS_REVIEW','返品/交換レビュー');
define('FS_SALES_DETAILS_AMOUNT','金額');
define('FS_SALES_DETAILS_COMMENT','コメント（必須）');
define('FS_SALES_INFO_NUMBER','シリーズ番号');
define('FS_SALES_DETAILS_RPI','返品支払情報');
define('FS_SALES_DETAILS_RA','払い戻し額');
define('FS_SALES_DETAILS_RM','返金方法');
define('FS_SALES_DETAILS_SAME','同じ支払い方法');
define('FS_SALES_DETAILS_NOTE','ご注意ください：最終返金額は返品確認メールに記載されます。');
define('FS_SALES_DETAILS_PROCESS','RMAプロセス');
define('FS_SALES_DETAILS_RAE','返品は簡単です');
define('FS_SALES_DETAILS_NO_LABEL','下記のフローチャートに従ってアイテムを返送してください。我々は返品先の住所をお知らせします。お客様は自分で選んだ運送業者を利用して送料を負担し、出荷ラベルも提供してください。そして、あなたの追跡番号を更新してください。何か質問があれば、即時支援を得るには問い合わせください。');
define('FS_SALES_DETAILS_LABEL','以下のフローチャートに従ってアイテムを返送してください。我々はご返品パッケージに前払い出荷ラベルも提供いたします。これらを持ち込んで認可されたUPS出荷場所へアップロードします。この出荷ラベルを利用してパッケージを追跡することができます。');
define('FS_SALES_DETAILS_AWB','AWB（航空貨物運送状）を更新する');
define('FS_SALES_DETAILS_ADDRESS','住所確認');
define('SALES_DETAILS_PRINT_LABEL','前払いの出荷ラベル');
define('SALES_DETAILS_LABEL_MSG','FS.COMは便利な機能を提供しており、出荷する前に、任意のインターネット接続が可能なコンピュータでこの前払い出荷ラベルを簡単に印刷することができます。これを元のパッケージの中に添付して一緒にお客様所在地最寄りのUPSドロップボックスにアップロードしておくこと。');
define('SALES_DETAILS_PSL','出荷ラベルを印刷する');
define('FS_SALES_INFO_YOU','上限数量は%sです。');

//request_stock
define("FS_EMAIL_REQUEST_STOCK_01","FS.COM - 在庫情報を求める & ケース番号 ");
define("FS_EMAIL_REQUEST_STOCK_02","アイテム#");
define('FS_EMAIL_REQUEST_STOCK_11',' に対する在庫リクエストは既に受領致しました。<br />
ケース番号:');
define("FS_EMAIL_REQUEST_STOCK_03","お客様 ");
define("FS_EMAIL_REQUEST_STOCK_04","在庫リクエストを送信して頂きありがとうございます。在庫が必要な数量は、私たちにとって非常に重要です。細部のご要求について、専用のアカウントマネージャーの方は連絡を取ってから、フォローしてくれます。一方、");
define("FS_EMAIL_REQUEST_STOCK_05","在庫管理チームは在庫ニーズを参照し、在庫計画を最適化します。");
define('FS_EMAIL_REQUEST_STOCK_06','お客様は即時情報が必要であれば、私たちに電話してください。<a href="tel:+81 345888332" style="color:#232323; text-decoration:none;">+81 345888332</a>（米国）；<a href="tel:+49 (0) 89 414176412" style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a>（ドイツ）。お客様はまた、迅速な応答を得るためにライブチャットをご利用ください。');
define('FS_EMAIL_REQUEST_STOCK_07','真摯に');
define('FS_EMAIL_REQUEST_STOCK_08','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> 顧客サービスチーム ');
define('FS_EMAIL_REQUEST_STOCK_09','お客様');
define('FS_EMAIL_REQUEST_STOCK_10','FS.COM - ケース番号:');

//helun 客户提出问提成功
define('FS_MODIFY_EMAIL_MY_CASE_01',' ご提出頂いたケース');
define('FS_MODIFY_EMAIL_MY_CASE_02','は既に受領致しました。');
define('FS_MODIFY_EMAIL_MY_CASE_03','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>にお問い合わせいただきありがとうございます。これは、');
define('FS_MODIFY_EMAIL_MY_CASE_04','弊社の<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>日本アカウントマネージャーはご質問を確認した後、12時間以内にご連絡致します。');
define('FS_MODIFY_EMAIL_MY_CASE_05','直ちに注意が必要な場合は、<a href="tel:+81 345888332" style="color:#232323; text-decoration:none;">+81 345888332</a>までご連絡ください。または、迅速な応答を得るためにライブチャットすることがあります。');
define('FS_MODIFY_EMAIL_MY_CASE_06','どうそ、宜しくお願致します。');
define('FS_MODIFY_EMAIL_MY_CASE_07','<a href="'.zen_href_link('index').'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> 顧客サービスチーム ');
define('FS_MODIFY_EMAIL_MY_CASE_08','お客様');
define('FS_MODIFY_EMAIL_MY_CASE_09','FS.COM - ケース番号: ');
define('FS_MODIFY_EMAIL_MY_CASE_10','のケースでのサポートの要請を受けたことをお知らせする確認メールです。');

//2017-12-14  ery  add  manage_orders和account_history_info页面reorder提示语，
define('FS_COMMON_REORDER_CLOSE','申し訳ありませんが、以下のアイテムは削除されましたので、ご購入していただくことはできません。');
define('FS_COMMON_REORDER_CUSTOM','ブローはカスタム製品で、製品紹介の文字を再選択してください。');
define('FS_COMMON_REORDER_SKIP','スキップして続行する');

define('FS_AJAX_REVIEW_PAGE_01','件のコメントを表示する');
define('FS_AJAX_REVIEW_PAGE_02','より');
define('FS_AJAX_REVIEW_PAGE_03','役に立つ');
define('FS_AJAX_REVIEW_PAGE_04','顧客');
define('FS_AJAX_REVIEW_PAGE_05','報告する');
define('FS_AJAX_REVIEW_PAGE_06','あなたのコメントを書き込んでください...');
define('FS_AJAX_REVIEW_PAGE_07','コメントを表示する');
define('FS_PRODUCTS_CUSTOMIZED','カスタム');

define('FS_MANAGE_ORDERS_UPLOAD_FILE','該当ファイルのアップロードは成功しています。');
define('FS_EMAIL_MANAGE_ORDERS_ORDER_NO','注文 NO.');
define('FS_EMAIL_MANAGE_ORDERS_SHIP_VIA','配送方法');
define('FS_EMAIL_MANAGE_ORDERS_ITEM','アイテム');
define('FS_EMAIL_MANAGE_ORDERS_ITEM_PRICE','商品価格');
define('FS_EMAIL_MANAGE_ORDERS_QTY','数量');
define('FS_EMAIL_MANAGE_ORDERS_PRICE','価格');

define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','（GSTを含む）');

//新增加
define('FS_CHECK_OUT_TAX_AU','GST');
define('FS_CHECK_OUT_EXCLUDING_AU','（GSTを除外する）');
define('FS_CHECK_OUT_INCLUDING_AU','（GSTを含む）');
define("FS_WAREHOUSE_AREA_AU","オーストラリア倉庫から出荷");
define("CHECKOUT_TAXE_AU_TIT","GSTと関税について");
define("CHECKOUT_TAXE_AU_CONTENT", "<em class='alone_font_italic'>1999年新税制（物品サービス税）法</em>に従い、FS.COM PTY LTDはメルボルン倉庫からオーストラリア国内のお客さまへ販売されるすべての製品に対し、10％の物品サービズ税 ( GST ) を徴収する義務があります。GSTを含む詳しい金額は決済ページの注文一覧に表示されます。</br></br>メルボルン倉庫に在庫がない製品ついては、アジア倉庫から転送され、メルボルン到着時に配送する場合があります。</br></br>重いアイテムまたは特大のアイテムは、アジア倉庫からお客様に直送いたします。注文時にGSTは請求されません。ただし、法律に応じて、通関諸費用が課せられる場合があります。通関手続きに起因する通関諸費用はお客様側で申告しご負担頂きます。");
define("FREE_SHIPPING_TEXT3","AU$99以上のご注文は送料無料です。");
define("FS_WAREHOUSE_AU","オーストラリア倉庫");
define("FS_WAREHOUSE_SG","シンガポール倉庫");
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU','GST');
define('PRODUCTS_SHIP_TODAY','即日出荷');
define('ITEM_LOCATION_AU','メルボルン、オーストラリア ');
define('FS_COMMON_WAREHOUSE_AU','FS.COM Pty Ltd<br>
			ABN 71 620 545 502 <br>
			Room 2314, HWT Tower,<br>
			40 City Road, Southbank,<br>
			Melbourne VIC 3006, Australia<br>
			電話番号: +61 (2) 8317 1119');
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON',"パスワードをご入力ください。");
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON',"有効な電子メールアドレスを記入してください。（例：someone@gmail.com）");
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON',"電子メールアドレスは必須です。");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON',"ご入力されたパスワードは正しくないです、もう一度試してください。");
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON',"エラー：このメールアドレスが当社に記録されておりません、もう一度試してください。");
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'エラー：アクセスが拒否されました。');
define("FS_LOGIN_POPUP1","セッションの有効期限が切れています");
define("FS_LOGIN_POPUP2","セッションは時間切れです。アカウントはログオフ状態になります。");
define("FS_LOGIN_POPUP3","続行するにはパスワードを再入力してください。");
define("FS_LOGIN_POPUP4","電子メールアドレス");
define("FS_LOGIN_POPUP5","本人じゃないの？");
define("FS_LOGIN_POPUP6","パスワード");
define("FS_LOGIN_POPUP7","パスワードを忘れた？");
define("FS_LOGIN_POPUP8","表示");
define("FS_LOGIN_POPUP9","非表示");
define("FS_ADDRESS_EDIT_TITLE","アドレスを編集する");
define('FS_CHECK_OUT_TAX_DE','VAT/Tax');
define('FS_COMMON_WAREHOUSE_US_ES','FS.COM INC<br>
			380 Centerpoint Blvd<br>
			New Castle, DE 19720,<br>
			United States<br>
			電話番号: +1 (888) 468 7419
			');
define("GLOBAL_TEXT_NAME","クレジットカードの名義人");
define("FS_HSBC_INFO1","受益者の銀行名");
define("FS_HSBC_INFO2","受益者口座名");
define("FS_HSBC_INFO3","IBAN:");
define("FS_HSBC_INFO4","BIC:");
define("FS_HSBC_INFO5","口座番号:");
define("FS_HSBC_INFO6","受益者銀行アドレス:");


// 2018.7.23 fairy 底部反馈弹窗
define('FS_GIVE_FEEDBACK','FSフィードバック');
define('FS_GIVE_FEEDBACK_TIP','ご訪問いただきまして誠にありがとうございます。お寄せいただいた貴重なご提案・ご感想は今後のサービス向上に役立ててまいります。');
define('FS_RATE_THIS_PAGE','FSの総合的な体験に対する評価をお伺いさせて頂きます。*');
define('FS_NOT_LIKELY','不満');
define('FS_VERY_LIKELY','満足');
define('FS_TELL_US_SUGGESTIONS','フィードバックのトピックをお選びください。*');
define('FS_ENTER_COMMENTS','お問い合わせ・ご意見・ご感想をお聞かせください。');
define('FS_PROVIDE_EMAIL','弊社からの返信をご希望の場合は、お手数をお掛けしますが連絡先情報をご記入ください。');
define('FS_PROVIDE_EMAIL_TIP','ご注意：この情報は他の目的では使用されません。 当社はあなたのプライバシーを大切にします。');
define('FS_FEEDBACK_THANKYOU','ご提示頂いた内容をお受け取り致しましたので、24時間以内に早速にご連絡します。');
define('FS_FEEDBACK_THANKYOU_TIP_01','お客様のご意見はとても大切な宝物で、いただいた内容は全社で共有の上分析し、ウェブサイトの改善に努めております。');
define('FS_FEEDBACK_THANKYOU_TIP_02','お客様の満足度は弊社の絶え間ない追求で、今後ともより良いサービスとショッピング体験を提供し続けます。');
define('FS_PRO_SHARE_EMAIL','メッセージが送信されました。');
define('FS_CHOOSE_ONE','一つを選んでください');
define('FS_WEB_ERROR','ウェブサイトのエラー');
define('FS_FEEDBACK_PRODUCT','製品');
define('FS_ORDER_SUPPORT','注文サポート');
define('FS_TECH_SUPPORT','技術サポート');
define('FS_SITE_SEARCH','サイトの検索');
define('FS_FEEDBACK_OTHER','その他');
define('FS_FEEDBACK_NAME','お名前');
define('FS_FEEDBACK_EMAIL','メールアドレス');

define('FS_SHARE_CART_06','アカウントマネージャー. ');

//add ternence 2018-7-9
define('FS_SHOP_CART_ALERT_JS_50','アイテム');
define('FS_SHOP_CART_ALERT_JS_51','小計 (');
define('FS_SHOP_CART_ALERT_JS_52',')：');
define('FS_SHOP_CART_ALERT_JS_53','カートの概要');
define('FS_SHOP_CART_ALERT_JS_54','（送料と税金抜き）');
define('FS_SHOP_CART_ALERT_JS_55','名前');
define('FS_SHOP_CART_ALERT_JS_55_1','受信者の名前');
define('FS_SHOP_CART_ALERT_JS_56','メールアドレス');
define('FS_SHOP_CART_ALERT_JS_56_1',"複数の受信者の場合、セミコロンで区切る様にして下さい。");
define('FS_SHOP_CART_ALERT_JS_57',' 最大500文字入力できます。');
define('FS_SHOP_CART_ALERT_JS_58','保存したカート');
define('FS_SHOP_CART_ALERT_JS_59','ご注文は送料無料の対象となります ');
define('FS_SHOP_CART_ALERT_JS_60','配達先');
define('FS_SHOP_CART_ALERT_JS_61','US$79以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_62','無料配送の対象とするには、他には ');
define('FS_SHOP_CART_ALERT_JS_63',' 適格品目を追加します。 ');
define('FS_SHOP_CART_ALERT_JS_64','ご注文は送料無料の対象となります ');
define('FS_SHOP_CART_ALERT_JS_65','€79以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_66','£7979以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_67','€7979以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_68','£7979以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_69','安全な決済へ進む');
define('FS_SHOP_CART_ALERT_JS_70','ショッピングを続ける');
define('FS_SHOP_CART_ALERT_JS_71','AUD$99以上のご注文は送料無料です。任意の製品カテゴリの製品に含まれています。');
define('FS_SHOP_CART_ALERT_JS_72','カートを保存する');
define('FS_SHOP_CART_ALERT_JS_72_1','カートを保存する');
define('FS_SHOP_CART_ALERT_JS_73','メールでカートを送る');
define('FS_SHOP_CART_ALERT_JS_74','印刷する');
define("FS_SHOP_CART_ALERT_JS_76_1","メールを送る");
define("FS_AJAX_DELETE1","はカートから削除されました。");
define("FS_AJAX_DELETE2","取り消し");
define('FS_SHOP_CART_WAS_UD','すべての商品がカートに入ってしまいます。');
define('FS_CART_ITEM','点)');
define('FS_CART_ITEMS','点)');
define("CHECK_SET_DEFAULT","デフォルト設定");
define("CHECK_SEARCH","検索");
define("FS_ADDRESS_MESSAGE3","住所、c/o");
define("FS_ADDRESS_MESSAGE4","アパート、スイート、ユニット、建物、フロアなど。");
define("CHECKOUT_TAXE_CN_FRONT1","CN倉庫から中国本土、香港、マカオ、台湾に出荷されるすべての注文は、送料が無料になります（中国本土はデフォルトでSF Expressとなり、香港、マカオ、台湾はデフォルトFedex IEになります）。");
define("CHECKOUT_TAXE_CN_FRONT2","一方、中華人民共和国税法（以下は「LATC」という）の法律に基づき、FS.COMは、中国本土へのすべての受注に対して13％の付加価値税を課す義務があります。また、HK、マカオ、台湾に配達された注文については、付加価値税は課税されませんが、特定の目的地の法律/規制に応じて、これらのパッケージは輸入税または通関手数料が課されることがあります。通関手数料は受取人が負担しなければなりません。");
define("FS_CHECKOUT_ERROR29","住所を編集してください（有効な郵便番号を入力してください）。");
define("FS_CHECKOUT_ERROR35","住所を編集してください（有効な国を選択してください）。");
//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","発注書の添付");
define("FS_UPLOAD_TEXT","発注書を添付して時間を節約しましょう。POファイルを受け取るとすぐに購入注文の処理を開始いたします。必要な署名と情報がすべて提供されていることを確認してください。");
//add by aron 2017.11.18
define("FS_SUCCESS_GLOABL_THANK","お支払いは成功です！ご注文は進行中です。");
//add by frankie 2018.1.2.
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","配送先住所が与信申請書のご住所と一致しません。注文を確認して12時間以内に結果をメール致します。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","ご利用可能な与信限度額は既に使い込んでいます。この注文を迅速に処理するには、前の注文を払い戻してクレジットを復帰するか、<a href ='".zen_href_link('my_dashboard')."'>「マイクレジット」</a>ページに与信限度額を増加することができます。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","配送先住所が与信申請書のご住所と一致せず、ご利用可能な与信限度額も既に使い込んでいます。この注文を迅速に処理するには、前の注文を払い戻してクレジットを復帰するか、<a href ='".zen_href_link('my_dashboard')."'>「マイクレジット」</a>ページに与信限度額を増加することができます。注文を確認して12時間以内に結果をメール致します。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");define('FIBER_CHECK_SPARK','Sparkasse銀行口座: ');
//po相关语言包
define("FS_PO_ADDRESS_01",'この住所をPO住所として提出しますか？');
define("FS_PO_ADDRESS_02",'ごアプリケーションは既に正常に提出されましたので、お知らせをお待ちください。');
define("FS_PO_ADDRESS_03",'注：');
define("FS_PO_ADDRESS_04",'この注文を正常に完了した後は、配送先住所が「PO」アイコンでマークされていないので、ご注文の安全性を確認する必要があります。');
define("FS_PO_ADDRESS_05",'住所を確認する');
define("FS_PO_ADDRESS_06",'住所を再選択する');
define("FS_PO_ADDRESS_07",'与信限度を編集する');
define("FS_PO_ADDRESS_08",'金額を増やす');
define("FS_PO_ADDRESS_09",'はい');
define("FS_PO_ADDRESS_10",'いいえ');
define("FS_PO_ADDRESS_11",'残りの与信限度額が不十分になっていますので、与信限度額をを引き上げたいですか？');
define('FS_ADDRESS_SET_PO_SUCCESS','ごPO住所は既に提出されましたので、承認をお待ちください。');
define('FS_ADDRESS_SET_PO_SUCCESS','ごPO住所は既に提出されましたので、承認をお待ちください。');
define("FS_POPUP_TIT_ALERT","配送には署名が必要です。私たちはPO Boxには出荷しません。また、国際配送のために、配送会社のシステムには日本語入力ができませんので、アドレスを英語でご入力お願い致します。");
define("FS_POPUP_TIT_ALERT_NOT_PO","国際配送のために、配送会社のシステムには日本語入力ができませんので、お客様の住所を英語で入力してください。");
define("FS_SUCCESS_ORDER_01","注文");
//meta
define("FS_META_PRO_01","最適な価格で ");
define("FS_META_PRO_02"," データセンター、エンタープライズ、ISPネットワークソリューションメーカーから購入します。");
define("FS_META_PRO_03"," を最適な価格で販売しております。大量在庫があり、2-4営業日でお手元にお届けいたします。【品質認証がございます】。");
define("FS_META_PRO_04","このページで ");

define('FS_TOTAL_SAVINGS','以下の金額を節約できる');

//结账页面新增
define("FS_LIVE_CHAT_CHECKOUT","ご不明な点がございましたら、<a  href='javascript:;' onclick='LC_API.open_chat_window();return false;'>ライブチャット</a>または電話");
define("FS_LIVE_CHAT_CHECKOUT_01", 'でご連絡ください。');

//2018-8-29  credit付款页面
define('FS_CREDIT_CARD_NUMBER','カード番号');
define('FS_CREDIT_EXPIRY_DATE',"有効期限");
define('FS_CREDIT_CONTINUE','続行');

define("FIBERSTORE_PRODUCTS","製品");
define("FIBERSTORE_PRODUCT","製品");
define("FIBERSTORE_RESULTS_BY01","順位付け :");
define("FIBERSTORE_RESULTS_VIEW","表示 :");
define("FS_FESTIVAL8","FS.COMが復活する");
define("FS_FESTIVAL8_01","FS.COMが復活する");
define("FS_FESTIVAL9","th");
define("FS_FESTIVAL10","rd");
define('FS_CHOOSE_LENGTH','長さを選択する');
define('FS_LENGTH_NAME','長さ');
define('FS_OPTION_NAME','デバイス番号');
//english.php   checkout结算页面
define("CHECKOUT_TAXE_CN_TIT","関税と税金について");
define("CHECKOUT_TAXE_CN_TIT1","関税と税金について");
define("CHECKOUT_TAXE_CN_FRONT","当社のCN倉庫から出荷される注文については、当社は製品価値と送料のみを請求します。売上税（VATまたはGST）は課金されません。ただし、特定の国/地域の法律と規制に応じて、パッケージに輸入関税または通関関税を査定することがあります。<b>通関手続きに起因する関税や輸入関税は、お客様自身で申告し、負担するものとします。</b>関税を先払いする手助けが必要な場合は、当社にご連絡ください。");

define("CHECKOUT_TAXE_DE_TIT","付加価値税と関税＆税金");
define("CHECKOUT_TAXE_DE_FRONT","全ての製品はドイツ倉庫から発送されます。EU加盟国の法律に従い、FS.COM GmbHはドイツからEUおよび英国の加盟国に配送される全ての注文にVATを課す義務があります。");
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>お届け国/地域</div><div>付加価値税（VAT）&amp; 関税</div></div><div class=\"help-center-taTr\"><div>ドイツ</div><div>19％の付加価値税（VAT）が請求されます。</div></div><div class=\"help-center-taTr\"><div>フランスとモナコ</div><div>20％の付加価値税（VAT）が請求されますが、有効なEU付加価値税（VAT）識別番号を持っている場合、付加価値税（VAT）は請求されません。 
</div></div><div class=\"help-center-taTr\"><div>オランダ、スペイン、ベルギー</div><div>21％の付加価値税（VAT）が請求されますが、有効なEU付加価値税（VAT）識別番号を持っている場合、付加価値税（VAT）は請求されません。</div></div><div class=\"help-center-taTr\"><div>イタリア</div><div>22%の付加価値税（VAT）が請求されますが、有効なEU付加価値税（VAT）識別番号を持っている場合、付加価値税（VAT）は請求されません。</div></div><div class=\"help-center-taTr\"><div>スウェーデン</div><div>25％の付加価値税（VAT）が請求されますが、有効なEU付加価値税（VAT）識別番号を持っている場合、付加価値税（VAT）は請求されません。</div></div><div class=\"help-center-taTr\"><div>他のEUメンバー</div><div>19% の付加価値税（VAT）が請求されますが、有効なEU付加価値税（VAT）識別番号を持っている場合、付加価値税（VAT）は請求されません。</div></div><div class=\"help-center-taTr\"><div>EU以外の国</div><div>付加価値税（VAT）は請求されませんが、通関手続きによる料金は受取人にご負担いただきます。</div></div></div>");

//共用 支付成功语言包   checkout_payment_against再次付款页面
define('FS_AGAINST_BPAY_01','注文日:');
define('FS_AGAINST_BPAY_02','合計金額:');
define('FS_AGAINST_BPAY_03','ご購入は以下に分割されています：');
define('FS_AGAINST_BPAY_04','注文');
define('FS_AGAINST_BPAY_05','配達予定日');
define('FS_AGAINST_BPAY_06','発送元');
define('FS_AGAINST_BPAY_07','注文');
define('FS_AGAINST_BPAY_08','of');
define('FS_AGAINST_BPAY_09','へ進む');
define('FS_AGAINST_BPAY_10','Sparkasse Freising');
define('FS_AGAINST_BPAY_11','FS.COM GmbH');
define('FS_AGAINST_BPAY_12','DE16 7005 1003 0025 6748 88');
define('FS_AGAINST_BPAY_13','BYLADEM1FSI');
define('FS_AGAINST_BPAY_14','25674888');
define('FS_AGAINST_BPAY_15','Untere Hauptstr.29, 85354, Freising');
define('FS_AGAINST_BPAY_16','817-888472-838');
define('FS_AGAINST_BPAY_17','HSBCHKHHHKH');

define("FS_COMMON_CHECKOUT_HSBC","弊社宛て御送金は海外送金であるため、入金確認までに通常2～3営業日がかかります。お急ぎの場合は、他のお支払い方法をお選びください。ご不明な点がございましたらカスタマーサポートまたはアカウントマネージャーにご連絡ください。");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","ご注文がタイムリーに処理できるように、お支払うときにFS注文番号を記入してください。ご送金は通常1〜3営業日以内に受領されますので、ご送金が確認されるまで在庫は保留されません。");
define("FS_WAREHOUSE_SEA","シアトル倉庫");
define("FS_WAREHOUSE_DEL","デラウェア倉庫");
define("FS_WAREHOUSE_AREA_36","シアトル倉庫からの配送");
define("FS_WAREHOUSE_AREA_37","デラウェア倉庫からの配送");

//2018-8-31   shoppint_cart 页面分享
define('FS_SHARE_AGAIN','もう一度シェアする');
define('HEADER_TITLE_CLEARANCE','在庫一掃');
//站点融合整理 邮件标点符号整理成常量
define('FS_EMAIL_COMMA',':');   //逗号
define('FS_EMAIL_POINT','。'); //句号
define('FS_EMAIL_PERIOD','');
define('FS_EMAIL_MARK','!');//感叹号
define('FS_EMAIL_PAUSE','、');

//2018-1-8   ery  add   产品详情页未勾选属性的提示语
define('FS_PRODUCT_INFO_ATTR_PLEASE','各属性のオプションをお選びください。');
//产品详情页加入购物车后弹出框
define('FS_CONTINUE_SHOPPING','お買い物を続ける');
define('FS_CUSTOMERS_ALSO','他の顧客はまた、これらの製品を購入しました。');

//au单独的RMA地址
define('FIBER_CHECK_ANZ','ANZ銀行口座:');
define('FIBER_CHECK_ACCOUNT','受益者の銀行名:');
define('FIBER_CHECK_PTY','HSBC Hong Kong');
define('FIBER_CHECK_BSB','受益者口座名:');
define('FIBER_CHECK_013','	FS.COM LIMITED');
define('FIBER_CHECK_ACCOUNT_NO','口座番号:');
define('FIBER_CHECK_4167','817-888472-838');
define('FIBER_CHECK_SWIFT_CODE','SWIFTコード:');
define('FIBER_CHECK_ANZBAU3M','HSBCHKHHHKH');
define('FIBER_CHECK_BANK','受益者銀行アドレス:');
define('FIBER_CHECK_ST_VIC','1 Queen\'s Road Central, Hong Kong');
define('FIBER_CHECK_TITLE_AU','To pay via direct deposit, please use the following bank account information:');

define("FS_PICK_UP_AT_WAREHOUSE","倉庫からピックアップ ");
define("FS_TIME_ZONE_RULE_US_ES"," (EST)");
define("FS_TIME_ZONE_ADDRESS_US","<span>倉庫住所：</span>820 SW 34th Street Bldg W7 Suite H Renton, WA 98057, United States | +1 (877) 205 5306 ");
define("FS_TIME_ZONE_ADDRESS_DE","<span>倉庫住所：</span>NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define("FS_TIME_ZONE_ADDRESS_US_ES","<span>倉庫住所：</span>380 Centerpoint Blvd, New Castle, DE 19720, United States | +1 (888) 468 7419 ");
define("CN_SPRING_WAREHOUSE_MESSAGE1","ご注意:この注文 ");
define("CN_SPRING_WAREHOUSE_MESSAGE2","は中国の春祭り（2018年2月6日〜2018年2月20日）が終了するまでに当社の中国倉庫から出荷されます。");

//产品详情页产品加入购物车后的弹出框信息
define('FS_JUST_ADDED','先程追加したばかり ');
define('FS_JUST_ITEM',' 商品');
define('FS_JUST_ITEMS',' 商品');
define('FS_CART_QTY','数量:');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'カートをシェア');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'カートをプリント');
define("FS_SHOP_CART_ALERT_JS_77","カート一覧");

//hsbc
define('FIBERSTORE_INFO_WIRE_DE','Sparkasse Bank Account');
define('FS_SUCCESS_YOUR_NEXT','次は電信送金で支払いを完成します。後は支払詳細を提出してください。');
define('FS_SUCCESS_WIRE','電信送金');
define('FS_SUCCESS_ORDER','注文を印刷');
define('FS_SUCCESS_DETAIL','銀行振込受益者の詳細');
define('FS_SUCCESS_BANK_NAME','受益者の銀行名:');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','受益者口座名:');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','受益者口座番号:');
define('FS_SUCCESS_TEL','817-888472-838');
define('FS_SUCCESS_SWIFT','SWIFTアドレス:');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','受益者銀行アドレス:');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
//UK
define('FIBER_CHECK_ANZ_UK','HSBC Bank Account');
define('FS_SUCCESS_BANK_NAME_UK','受益者の銀行名');
define('FS_SUCCESS_HSBC_UK','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME_UK','受益者口座名');
define('FS_SUCCESS_CO_UK','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO_UK','受益者口座番号');
define('FS_SUCCESS_TEL_UK','817-888472-838');
define('FS_SUCCESS_SWIFT_UK','SWIFTアドレス');
define('FS_SUCCESS_HK_UK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS_UK','受益者銀行アドレス');
define('FS_SUCCESS_ROAD_UK','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','当社のアドレス');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');

//2018 1-9.aRON 游客邮件
define("FS_GUEST_EMAIL_THANK","");
define("FS_GUEST_EMAIL_CONTACT","更にご質問がございましたら、どうぞお気軽に ");
//2018-9-15  add  ery  游客结算页面账号已存在提示语
define('FS_CHECKOUT_GUEST_LOG_MSG','ごメールアドレスがシステムにありましたので、直接ログインしてください。<a href="'.zen_href_link('login').'">ログイン »</a>');
//推荐版块
define('FS_PRODUCT_RELATED','関連製品');
//产品详情货币单位
define('FS_PRODUCT_PRICE_EA','/個');
//产品详情页 选择产品属性
define('PLEASE_SELECT', '選択してください');

//2018-9-11
define('EMAIL_OVER79_FREE_DELIVERY','<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">%s以上の適格品目の注文は無料でお届けします。また会うのを楽しみにしています。</td></tr>');
define('FS_TRACK_MY_ORDERS','「私の注文」');
define('FS_TRACK_ORDER','次のリンクをクリックして、注文ステータスを追跡することができます。');
define('FS_ORDER_COMMENTS','注文コメント: ');
define('FS_TRACK_ACCOUNT_CENTER','「アカウントセンター」');
define('FS_TRACK_PO_ORDER','でステータスを追跡できます。 ');

//print_order & print_main_order
define('FS_PRINT_ORDER_TEL','Tel : ');
define('FS_PRINT_ORDER_NUM','VAT番号: ');
define('FS_PRINT_ORDER_CREDIT','クレジット/デビットカード');
define('FS_PRINT_ORDER_PURCHASE','発注書（PO）');
define('FS_PRINT_ORDER_BANK','銀行振込');
define('FS_PRINT_ORDER_WESTERN','ウエスタンユニオン');
define('FS_PAY_WAY_PAYPAL','Paypal');
define('FS_PAY_WAY_PAYEEZY','Payeezy');
define("FS_CHECKOUT_NEW42","電子チェック");
define('FS_PRINT_ORDER_FREE','無料');

/**
 *评论邮件
 */
define('EMAIL_MESSAGE_TITLE_REVIEWS',' フィードバック受領');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS-フィードバックをご送信いただき誠に感謝いたします。');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','ご親切なお言葉をいただいたことに感謝しており、弊社のチームとの交流の中でとてもいい体験をなさったことにも嬉しく存じます。');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','お客様からのフィードバックは、私たちの行動の指針となり、お客様の体験を改善することにも役立ててまいります。');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','ご期待に応えられず申し訳ございません。今後このような事がないよう努めて参ります。');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','アカウントマネージャーが48時間以内にご連絡させていただきます。できる限り迅速に問題を解決するために、ご協力を賜りますようお願い致します。');
define('FS_EMAIL_REVIEWS_THANKS','よろしくお願い致します。');
define('FS_EMAIL_REVIEWS_TEAM','FSチーム');
define('FS_EMAIL_REVIEWS_WELL_HEADER','レビューを書いていただき誠にありがとうございます。今後も引き続き最高の製品をご提供いたします。');
define('FS_EMAIL_REVIEWS_BAD_HEADER','レビューを書いていただき誠にありがとうございます。できるだけ早くご問題を解決いたします。');

//客户取消订单邮件
define('FS_CANCEL_ORDER',"今回の注文#");
define('FS_CANCEL_ORDER_1',"キャンセルされました。");
define('FS_CANCEL_ORDER_2',"ご要望に応じて、予約注文#をキャンセル致しました。 ");
define('FS_CANCEL_ORDER_3'," ご注文はうまく行かなかった申し訳ありませんが、今度FS.COMで買い物してくれることを願っています。");
define('FS_CANCEL_ORDER_4',"ご不明な点がございましたら、 <a href='contact_us.html'>お問い合わせ</a>ください。また会えるのを楽しみにしています！");
define('FS_CANCEL_ORDER_5',"お客様のメールアドレス:");
define('FS_CANCEL_ORDER_6',"注文番号: ");
define('FS_CANCEL_ORDER_7',"理由:");
define('FS_CANCEL_ORDER_8','注文# ');

//live chat留言邮件
define('FS_LIVE_CHAT_MAIL','<a href="'.zen_href_link('index','','SSL').'"> FS.COM </a>にお問い合わせいただきありがとうございます。これは、サポートのリクエストが受領されたことをお知らせする確認メールです。ご提出頂いたメッセージを確認し、12時間以内に返信致します。');
define('FS_LIVE_CHAT_MAIL_1','FS.COM-メールメッセージの確認 ');
define('FS_LIVE_CHAT_MAIL_2','今回のサービスタイプ:');
define('FS_LIVE_CHAT_MAIL_3','ご提出頂いたメッセージ:');
define("FS_OVERNIGHT_TITLE","締切時間後（EST午後5時）に受領した注文は、翌営業日に発送されます。配達は営業日に行われます。");
define("FS_OVERNIGHT_TITLE_UP","締切時間後（EST午後5時）に受領した注文は、翌営業日に発送されます。配達は営業日に行われます。");

define("FS_ECHECK_NOTICE","*弊社はアメリカ銀行が発行した電子小切手のみを受け付けています。処理には1〜2営業日かかる場合があります。");
define("FS_ECHECK_BANK_ACCOUNT","銀行口座名");
define("FS_ECHECK_BANK_ACCOUNT_NUMBER","銀行口座番号");
define("FS_ECHECK_BANK_ACCOUNT_TYPE","口座種類");
define("FS_ECHECK_BANK_ACCOUNT_CHECK","確認中");
define("FS_ECHECK_BANK_ACCOUNT_SAVE","保存中");
define("FS_ECHECK_BANK_ACCOUNT_CONFIRM","銀行口座番号を確認する");
define("FS_ECHECK_BANK_ACCOUNT_ROUTE","ABA/ACHルーティング番号");
define("FS_ECHECK_ERROR_1","銀行口座名が必要でございます。");
define("FS_ECHECK_ERROR_2","銀行口座番号が必要でございます。");
define("FS_ECHECK_ERROR_3","口座種類が必要でございます。");
define("FS_ECHECK_ERROR_4","銀行口座番号を確認することが必要でございます。");
define("FS_ECHECK_ERROR_5","ABA/ACHルーティング番号が必要でございます。");



//专题页面加购弹窗语言包翻译
define('FS_SUPPORT_ADD','追加...');
define('FS_SUPPORT_ADDED','追加された');
define("FS_SUCCESS_ECHECK","Electronic Check");
define("CHECKOUT_TAX_NZ_CONTENT","オーストラリア外での注文については、FS.COMは発注時に商品と送料のみを請求します。ただし、これらのパッケージは、対象国の法律に基づいて、輸入税または通関手数料を評価することもあります。<br/><br/>パッケージが目的地に到着すると、関税や輸入関税が課されます。 通関手数料は、お客様自身が負担しなければなりません。");
define("FS_TIME_ZONE_ADDRESS_AU","<span>FSメルボルン倉庫:</span> 57-59 Edison Rd、Dandenong South、VIC 3175、Australia | +61 3 9693 3488 ");
//checkout_success
define('FS_PURCHASE_NUMBER','発注書番号');
//购物车分享相关 移动到公共语言包部分
define('FS_SHOP_CART_ALERT_JS_31','カートを選ぶ:');
define('FS_SHOP_CART_ALERT_JS_43','お名前をご入力ください。');
define('FS_SHOP_CART_ALERT_JS_43_01',"受信者の名前をご入力ください。");
define('FS_SHOP_CART_ALERT_JS_44','メールアドレスを入力してください。');
define('FS_SHOP_CART_ALERT_JS_44_01',"受信者のメールアドレスをご入力ください。");
define('FS_SHOP_CART_ALERT_JS_45','有効なメールアドレスをご入力ください。');
define('FS_SHOP_CART_ALERT_JS_46','ご専属なアカウントマネージャーに送信する');
//第三方登录提示语
define("REDIRECT_DEAR","親愛な ");
define("REDIRECT_USER"," ユーザーの ");
define("REDIRECT_WELCOME"," FSへようこそ！");
define("REDIRECT_NOTICE","FSアカウントを同じEメールアドレスで登録しました。<br>アカウント管理に関するより良い経験を提供するために、<br>FSアカウントにログインするようにします。このFSアカウント<br>を知らない場合は、遠慮なく当社にご連絡ください");
define("REDIRECT_ACCOUNT","以内でリダイレクトする ");
//支付方法  移动到公共文件 checkout,ccheckout_guest,邮件共用
define("FS_CHECKOUT_NEW31","PayPal");
define("FS_CHECKOUT_NEW32","クレジット/デビットカード");
define("FS_CHECKOUT_NEW33","銀行振込");
define("FS_CHECKOUT_NEW34","掛売決済");
define("FS_CHECKOUT_NEW35"," BPAY");
define("FS_CHECKOUT_NEW36"," eNETS");
define("FS_CHECKOUT_NEW37","YANDEX");
define("FS_CHECKOUT_NEW38","WEBMONEY");
define("FS_CHECKOUT_NEW39","iDEAL");
define("FS_CHECKOUT_NEW40","SOFORT");
define('MY_CASE_UPLOAD_18','ファイバーストア株式会社');

// 税号模板 start
//新增结账税号验证
define("FS_CHECKOUT_VAX_CH","有効な納税者番号を入力してください（例：00.000.000-0）。");
define("FS_CHECKOUT_VAX_AR","有効な納税者番号を入力してください（例：00-00000000-0）。");
define("FS_CHECKOUT_VAX_BR_BS","有効な納税者番号を入力してください（例：00.000.000/0000-00）。");
define("FS_CHECKOUT_VAX_BR_IN","有効な納税者番号を入力してください（例：000.000.000/00）。");
define("FS_TAXT_TITLE_NOTICE","正しい有効なVAT番号を提供すると、ご注文は付加価値税（VAT）を免除することができます。");
define("FS_TAXT_TITLE_NOTICE_OTHER","通関手続きをスピードアップするには、有効な納税者番号を記入してください。");
// 税号模块 end

//manage_orders
define('FS_MANAGE_ORDERS_PUR','注文番号');

define("FS_NO_FREE_SHIPPING_US_HEAVY","重いや大きめの製品が含まれている注文は送料無料を楽しむことができません。");
define("FS_NO_FREE_SHIPPING_DEAU_HEAVY","重いや大きめの製品が含まれている注文は無料配送を楽しむことができません。");
define("FS_NO_FREE_SHIPPING_AU_REMOTE","この注文は遠隔地に送られますので、送料をお支払う必要があります。");


define("CHECKOUT_TAXE_US_TIT","消費税 & 税金について");
define("CHECKOUT_TAXE_US_FRONT","商品が米国倉庫からワシントン州内の住所に発送される場合、ワシントン州の税法に従って10％の消費税が課金されます。ただし、ご所在する州の有効な免税証明書を提出できれば、売上税は徴収されません。カナダとメキシコに出荷される商品には消費税はありませんが、購入者より通関手数料と税金を負担します。注文をオンラインで行う際には、送料を請求し、注文合計（FS.COMのデフォルト値）から関税を除外します。必要に応じて、FS.COMは税金を事前に支払う手配を手助けすることができます。");
define("CHECKOUT_TAXE_US_BACK","中国の倉庫から発送する場合に、注文時にFS.COMは商品と送料のみを請求します。ただし、これらのパッケージは、特定の国の法律に基づいて輸入税または通関手数料として査定されることもあります。パッケージが目的地に到着すると、関税や輸入関税が課されます。通関手続きのための追加料金は受領者が負担しなければなりません。私たちはこれらの費用を支配しておらず、彼らが何であるかを予測することはできません。税関の方針は国によって大きく異なるため、詳細については地元の税関にお問い合わせください。必要に応じて、FS.COMは税金を事前に支払う手配を手助けすることができます。");

define("CHECKOUT_TAXE_CN_FRONT","当社の中国倉庫から出荷された注文については、当社は製品価値と送料のみを請求します。売上税（VATまたはGST）は課金されません。ただし、パッケージは、特定の国の法律/規制に応じて、輸入関税または通関関税として査定することもあります。通関によって生じた関税や輸入関税は、受領者が申告し、負担するものとします。関税を先払いする手助けが必要な場合は、当社にご連絡ください。");

define("CHECKOUT_TAXE_DE_TIT","付加価値税（VAT） & 税金について");
define("CHECKOUT_TAXE_DE_FRONT","FS.COM GmbHは、ドイツミュンヘンの倉庫からEUの加盟国への発注について付加価値税を課す義務があります。弊社のカタログに掲載されているすべての商品は、ドイツの一般税法に基づく19％の通常付加価値税率が適用されています。注文情報を完了すると、注文の要約に該当する付加価値税を含めた総額を確認することができます。");

define("CHECKOUT_TAXE_NEW_CN_CONTENT","弊社米国の倉庫で在庫がある製品は、デラウェア州から米国のあらゆる目的地に直接出荷されます。FS.COMは、製品代金と送料を請求するだけです。消費税はかかりません。<br/><br/>米国の倉庫で一時的に在庫切れの製品が注文に含まれている場合は、アジアの倉庫から直接配送して配達をスピードアップします。製品ページに「送料無料」というメッセージが表示されている場合、FS.COMは通関手続きによって引き起こす可能性のあるすべての関税および税率を負担します。 <br/><br/>製品ページに「送料無料」というメッセージが表示されていない商品の場合、製品が重いか、または大きすぎる製品です。それらはアジアの倉庫から直接出荷され、無料発送サービスを受けることはできません。そして通関手続きによって引き起こす可能性のあるすべての関税および税率でも受取人が負担されるべきです。");
define("CHECKOUT_TAXE_NEW_CA_CONTENT","弊社米国の倉庫で在庫がある製品は、デラウェア州からカナダのあらゆる目的地に直接出荷されます。<br/><br/>米国の倉庫で一時的に在庫切れの製品が注文に含まれている場合は、アジアの倉庫から直接配送して配達をスピードアップします。<br/><br/>FS.COMはオンライン注文をする際に製品代金と送料を請求するだけです。通関手続きによって引き起こす可能性のあるすべての関税および税率でも受取人が負担されるべきです。");
define("CHECKOUT_TAXE_NEW_MX_CONTENT","弊社米国の倉庫で在庫がある製品は、デラウェア州からメキシコのあらゆる目的地に直接出荷されます。<br/><br/>米国の倉庫で一時的に在庫切れの製品が注文に含まれている場合は、アジアの倉庫から直接配送して配達をスピードアップします。<br/><br/>FS.COMはオンライン注文をする際に製品代金と送料を請求するだけです。通関手続きによって引き起こす可能性のあるすべての関税および税率でも受取人が負担されるべきです。");


//产品详情404页面
define('FS_404_HOT_PRODUCTS','人気な製品');
define('SEARCH_OFFINE_1','申し訳ありませんが、この製品はオンラインでは提供できなくなりました。');
define('SEARCH_OFFINE_2','オフラインでお問い合わせをするには見積もりを求めることができます。');
define('SEARCH_OFFINE_3','お見積りを求める');
define('SEARCH_OFFINE_4','もっと助けが必要ですか？詳細については、 ');
define('SEARCH_OFFINE_5','ヘルプセンター');
define('SEARCH_OFFINE_6','をご覧ください。');
define('SEARCH_OFFINE_7','申し訳ありませんが、このページが見つかりません。');
define('SEARCH_OFFINE_8','これは次の原因による可能性があります:');
define('SEARCH_OFFINE_9','別のページに移動しました。');
define('SEARCH_OFFINE_10','Ｗebアドレスが間違って入力されています。');
define('SEARCH_OFFINE_11','URLを確認するか、<a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">ホームページに戻りましょう</a>。');
define('SEARCH_OFFINE_12','ホームページに戻りましょう。');
define('SEARCH_OFFINE_13','に戻ってください。');
define('FS_OUTDATED_LINK','ページはもはや存在しません。');

//faq问题汇总
define('FS_FAQ_HELPFUL_01',"この回答は役に立ちましたか？");
define('FS_FAQ_HELPFUL_02',"はい");
define('FS_FAQ_HELPFUL_03',"いいえ");
define('FS_FAQ_HELPFUL_04',"ごフィードバック頂きありがとうございます！");
define('FS_FAQ_HELPFUL_05',"私たちは何を改善できますか？");
define('FS_FAQ_HELPFUL_06',"これは混乱させてしまった");
define('FS_FAQ_HELPFUL_07',"これは私の質問に答えなかった");
define('FS_FAQ_HELPFUL_08',"この規則に異議を唱える");
define('FS_FAQ_HELPFUL_09',"送信する");


define("FS_PRODUCTS_REORDERING","並べ替え");
define("FS_FOR_FREE_SHIPPING_GET_AROUND","それを取得する");
define("FS_CHOOSE_LOCATION","配達場所をお選びください");
define("FS_DELIVERY_OPTION","配送オプションと配送速度は場所によって異なる場合があります。");
define("FS_SHIP_OUTSIDE","外で出荷する ");//注意：日语语法限制，国家要放在前面
define("FS_SHIP_CONTINUE_SEE","チェックアウト時に、正確な送料と到着日が表示されます。");
define("FS_SHIP_DONE","完了");
define("FS_REDIRECT_PART1","でショッピングを続けて、");//注意：日语语法显示，网址test.whgxwl.com:8000/au要放在最前面
define("FS_REDIRECT_PART2"," 地元の価格と配送で特定のコンテンツをチェックしますか？");
define("FS_SHIP_TO","お届け先");
define("FS_SHIP_CHANGE","変更する");
define("FS_SHIP_OR","または");
define("FS_SHIP_ENTER","または郵便番号 ");
define("FS_SHIP_ZIP_CODE","を入力してください。");
define("FS_SHIP_APPLY"," 申し込む");
define("FS_SHIP_ADD_NEW_ADDRESS","新しいアドレスを追加する");
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> 登録して</a>アドレスをご確認ください');
define("FS_SHIP_MANAGE","アドレス帳を管理する");
define("FS_SHIP_TODAY","即日出荷");
define("FS_SHIP_GET_TODAY","即日配達できます。");
define("FS_PRODUCTS_POST_CODE_EMPTY_INVALID","有効な郵便番号を入力してください。");
define('FS_PRODUCTS_CUSTOMIZE','カスタム');

define("FS_SHIP_LIST_COUNTRY","国/地域");
define("FS_SHIP_LIST_POST","郵便番号");
define("FS_SHIP_DELIVEY_TO","お届け先");

define("FS_CN_HUBEI","中国、湖北武漢");
define("FS_CN_APAC","アジア倉庫");
define("FS_DE_MUNICH","ミュンヘン、バイエルン");
define("FS_AU_VIC","メルボルン、ビクトリア州");
define("FS_US_WA","ワシントン/デラウェア州");
define("FS_FOR_FREE_SHIPPING_GET_ARRIVE","配達予定日");
define("FS_APAC_NOTICE","FSアジア倉庫は、南米、アフリカ、アジア太平洋及びその他の地域へのグローバル即日出荷をサポートしています。<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_US_NOTICE","FSアメリカ倉庫はデラウェア州にあり、即日出荷をサポートしております。<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define("FS_US_UP_NOTICE","FS米国の倉庫はそれぞれシアトル&デラウェアに設置され、米国、アラスカ、ハワイ、APO/FPOの軍事住所、プエルトリコなど国内の高速輸送と、カナダ、メキシコへの国際輸送をサポートしています。<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_US_OTHER_NOTICE","FS米国の倉庫は、それぞれシアトルとデラウェアに設置され、米国、カナダ、メキシコへの即日出荷をサポートしています。<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_US_UP_OTHER_NOTICE","FS米国の倉庫は、それぞれシアトルとデラウェアに設置され、米国、カナダ、メキシコへの即日出荷をサポートしています。<a  target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_DE_NOTICE","FSヨーロッパ倉庫はミュンヘンにあり、即日出荷をサポートしております。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define("FS_DE_OTHER_NOTICE","バイエルン州ミュンヘンにあるFS DE倉庫は、英国、EU及びその他のヨーロッパ諸国へのグローバル出荷をサポートしています。 <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_AU_OTHER_NOTICE","ビクトリア州メルボルンにあるFS AU倉庫は、オーストラリア国内での即日高速輸送とニュージーランドへの国際輸送をサポートしています。");
define("FS_NZ_OTHER_NOTICE","ビクトリア州メルボルンにあるFS AU倉庫は、ニュージーランドへの即日出荷をサポートしています。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">続きを読む</a>");
define("FS_CN_NOTICE","FSグローバル倉庫はアジアにあり、即日出荷をサポートしております。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"発送の準備ができるまで、製造リードタイムが要るかもしれません。準備ができ次第、すぐにご発送いたします。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>提供可能、在庫納入中</p>該当製品は倉庫に向かう途中で、到着し次第、すぐにご発送いたします。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>提供可能、在庫納入必要</p>発送の準備ができるまで、製造リードタイムが要るかもしれません。準備ができ次第、すぐにご発送いたします。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define('FS_AU_NOTICE',"FSオーストラリア倉庫はメルボルンにあり、即日出荷をサポートします。<a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">もっと見る</a>");
define('FS_BUCK_NOTICE',"重い製品または特大製品を含む注文は、アジアの倉庫から発送されます。");
define('FS_SG_NOTICE',"FS シンガポール倉庫はシンガポールにあり、即日出荷をサポートしております。 <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>もっと見る</a>");

//add by quest 2019-03-08
define("FS_NO_QTY_NOTICE","該当製品の在庫はグローバル倉庫から迅速に輸送されています。");
define("FS_NO_QTY_TAG_NOTICE","該当製品の在庫はグローバル倉庫から輸送するように準備中です。");
define("FS_NO_QTY_TAG_NOTICE_NEW","該当製品の在庫はグローバル倉庫から輸送するように準備されています。");
define("FS_NO_QTY_NOTICE_NEW","この品目はアジア倉庫から輸送されています。");
define("FS_SHIP_OR_OTHER","または他の国/地域を変更する");

define("FS_SURBSTREET_MAXLENGTH_ERROR","住所欄2は最大35文字まで入力する必要があります。");
define("FS_TELEPHONE_MAXLENGTH_ERROR","電話番号は15文字まで入力する必要があります。");
define("FS_COMPANY_MAXLENGTH_ERROR","会社名は1文字以上100文字以内にする必要があります。");
define("FS_FIRSTNAME_MAXLENGTH_ERROR","姓は最大35文字まで入力する必要があります。");
define("FS_LASTNAME_MAXLENGTH_ERROR","名は最大35文字まで入力する必要があります。");
define("FS_CHECKOUT_ERROR12","4文字以上300文字以内でご入力ください。");
define("FS_PRODUCTS_POST_CODE_EMPTY_ERROR","郵便番号をご入力ください。");

define('FAIL_TO_OPEN_SOURCE','画像を開けない');
define('FAIL_TO_CONNECT_FTP','サーバー接続できない');

//超时取消订单
define('MANAGE_ORDER_RESTORE_1','終了時間：Oh.');
define('MANAGE_ORDER_RESTORE_2','終了時間： ');
define('MANAGE_ORDER_RESTORE_3','30分以内にお支払いを完了してください。さもなければ、注文は商品の在庫変更のために自動的にキャンセルされます。');
define('MANAGE_ORDER_RESTORE_4','もう一度購入する');
define('MANAGE_ORDER_RESTORE_5','注文書ファイルを7日以内にアップロードしてください。さもなければ、商品の在庫変更のため注文が自動的にキャンセルされます。');
define('MANAGE_ORDER_RESTORE_6','2日以内にお支払いを完了してください。さもなければ、注文は商品の在庫変更のために自動的にキャンセルされます。');
define('MANAGE_ORDER_RESTORE_7','7日以内にお支払いを完了してください。さもなければ、注文は商品の在庫変更のために自動的にキャンセルされます。');
define("FS_INQUIRY_SUBMITED",'提出済み');
define("FS_INQUIRY_QUOTED",'見積完了');
define("FS_INQUIRY_DEALED",'処理済み');
define("FS_INQUIRY_CANCELED",'キャンセルした');
define("FS_INQUIRY_REVIEWING",'検討中');

// 个人中心详情页面
define("FS_INQUIRY_SUBTOTAL",'合計');
define("FS_INQUIRY_CHECKOUT",'決済');
define("FS_INQUIRY_ADD_FILE",'ファイルを追加する');
define("FS_INQUIRY_CANCEL_SUCCESS",'キャンセルが成功しました。');
define("FS_NOTES",'備考');

// 个人中心列表页面
define("FS_INQUIRY_TOTAL_QUOTE_NUMBER",'すべての見積り依頼：QUOTE_NUMBER件');
define("FS_INQUIRY_VIEW",'詳細を見る');
define("FS_INQUIRY_CANCEL_THIS_QUOTE",'この見積もりを取り消しますか？');
define("FS_INQUIRY_CANCEL_QUOTE_TIP1",'一度実行すると、回復することはできません。');
define("FS_INQUIRY_CANCEL_QUOTE_TIP2",'お手数ですが、もしこの見積もりをキャンセルすれば、取消の理由を教えてくれませんか： ');
define("FS_INQUIRY_CANCEL_REASON1",'すでに他人から購入した');
define("FS_INQUIRY_CANCEL_REASON2",'重複見積もり');
define("FS_INQUIRY_CANCEL_REASON3",'私の希望製品ではない');
define("FS_INQUIRY_CANCEL_REASON4",'保証の問題');
define("FS_INQUIRY_CANCEL_REASON5",'長すぎる納期');
define("FS_INQUIRY_CANCEL_REASON6",'高すぎる値段');
define("FS_INQUIRY_CANCEL_REASON7",'必要なし');
define("FS_INQUIRY_CANCEL_REQUIRED_TIP",'お手数をお掛け致しますが、送信する前に見積もりをキャンセルする理由をご記入ください。');
define('FS_INQUIRY_EMPTY_PAGE_TIP','お見積もり依頼はまだございませんので、製品ページでお見積もりを取得してください。');
define('FS_INQUIRY_LIST_TIP','お見積もりの状況を確認し、より優遇な価格で直接購入可能です。');
define('FS_CANCEL_QUOTE','見積もりをキャンセル');

define("FS_FORWARD_SHIPPING","貨物運送業者 (関税 & 税金を前払い)");
define("FS_FORWARD_SHIPPING_NOTICE","この価格には、送料、関税と税金が含まれています。そして、必要な保険料も請求され、合計価格に計算され、「注文一覧」に表示されます。");
define('FS_CHECK_OUT_INSURANCE','保険料');
//产品详情页产品树收起提示语
define('FS_COMMON_CLOSE','表示を減らす');
define('FS_COMMON_FS_PN', 'FS P/N: ');


//新版邮件
define("SEND_MAIL_1","£79.00以上のご注文で送料無料");
define("SEND_MAIL_2","Fiberstore Ltd, Part 7th Floor, 45 CHURCH STREET, Birmingham, B3 2RT");
define("SEND_MAIL_3","$79以上のご注文で送料無料");
define("SEND_MAIL_4","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> INC, 380 CENTERPOINT BLVD, NEW CASTLE, DE 19720");
define("SEND_MAIL_5","€79以上のご注文で送料無料");
define("SEND_MAIL_6","GmbH, NOVA Gewerbepark, Building 7, Am Gfild 7, 85375 Neufahrn, Germany");
define("SEND_MAIL_7","A$99以上のご注文で送料無料");
define("SEND_MAIL_8","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Pty Ltd, ABN 71 620 545 502,57-59 Edison Rd, Dandenong South, VIC 3175, Australia");
define("SEND_MAIL_9","在庫品目で即日発送可能");
define("SEND_MAIL_10","<a href='".zen_href_link('index')."' style='text-decoration:none;color: #232323;'>FS.COM</a> Limited Room 2702, 27 Floor Yisibo Software Building, Haitian Second Road, Yuehai Street Nanshan District, Shenzhen, 518054, China");
//Postbank账户
define('FIBER_CHECK_COMMON_ACCOUNT','口座番号:');
define('FIBER_CHECK_COMMON_CODE','銀行コード番号:');
define('FIBER_CHECK_COMMON_IBAN','IBAN:');
define('FIBER_CHECK_COMMON_BIC','BIC:');

define('FIBER_CHECK_DO_TITLE','US-$口座');
define('FIBER_CHECK_DO_ACCOUNT_VALUE','0902543668');
define('FIBER_CHECK_DO_CODE_VALUE','590 100 66');
define('FIBER_CHECK_DO_IBAN_VALUE','DE98 5901 0066 0902 5436 68');
define('FIBER_CHECK_DO_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_GB_TITLE','英ポンドGBP');
define('FIBER_CHECK_GB_ACCOUNT_VALUE','0902544661');
define('FIBER_CHECK_GB_CODE_VALUE','590 100 66');
define('FIBER_CHECK_GB_IBAN_VALUE','DE59 5901 0066 0902 5446 61');
define('FIBER_CHECK_GB_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_CH_TITLE','スイスフランCHF');
define('FIBER_CHECK_CH_ACCOUNT_VALUE','0902545664');
define('FIBER_CHECK_CH_CODE_VALUE','590 100 66');
define('FIBER_CHECK_CH_IBAN_VALUE','DE41 5901 0066 0902 5456 64');
define('FIBER_CHECK_CH_BIC_VALUE','PBNKDEFF590');

define('FIBER_CHECK_POST_TITLE','ポストバンク口座');
define('FIBER_CHECK_COMMON_ACCOUNT_NAME','口座名:');
define('FIBER_CHECK_COMMON_BANK','銀行名:');
define('FIBER_CHECK_COMMON_ADDRESS','銀行の住所:');

define('FIBER_CHECK_SG_TITLE','OCBC銀行口座');
define('FIBER_CHECK_SG_OCBC_USD','OCBC USD口座番号:');
define('FIBER_CHECK_SG_OCBC_SGD','OCBC SGD口座番号:');
define('FIBER_CHECK_SG_INT_BANK','仲介銀行（米ドルのTTの場合）');
define('FIBER_CHECK_SG_SWIFT','SWIFTコード:');
define('FIBER_CHECK_SG_BANK_CODE','銀行コード:');
define('FIBER_CHECK_SG_BRANCH_CODE','支店コード:');
define('FIBER_CHECK_SG_BRANCH_CODE_CONTENT','口座番号-最初の3桁');
define('FIBER_CHECK_SG_BRANCH_NAME','支店名:');
define('FIBER_CHECK_SG_BRANCH_NAME_CONTENT','北支店');
define('FIBER_CHECK_SG_BANK_ADDRESS','銀行アドレス:');
define('FIBER_CHECK_SG_BANK_ADDRESS_CONTENT','65 Chulia Street, OCBC Centre, Singapore 049513');

define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE','FS.COM GmbH');
define('FIBER_CHECK_COMMON_BANK_VALUE','ポストバンク');
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE','Eckenheimer Landstr.242 60320 Frankfurt');
define('FS_CHECKOUT_SUCCESS_01','注文');
define('FS_CHECKOUT_SUCCESS_02','プリント注文');
define('FS_CHECKOUT_SUCCESS_03','注文');
define('FS_CHECKOUT_SUCCESS_04','の');
define('FS_CHECKOUT_SUCCESS_06','Sparkasse Freising');
define('FS_CHECKOUT_SUCCESS_07','FS.COM GmbH');
define('FS_CHECKOUT_SUCCESS_08','DE16 7005 1003 0025 6748 88');
define('FS_CHECKOUT_SUCCESS_09','BYLADEM1FSI');
define('FS_CHECKOUT_SUCCESS_10','25674888');
define('FS_CHECKOUT_SUCCESS_11','Untere Hauptstr.29, 85354, Freising');
define('FS_CHECKOUT_SUCCESS_12','注文書');
define('FS_CHECKOUT_SUCCESS_13','営業日');
define('FS_CHECKOUT_SUCCESS_14','POファイルを添付');
//new_cart
define('FS_NEW_SHIPPING_FREE','この注文は送料無料の対象となります！');
define('FS_GO_SHOPPING','お買い物を続ける');
define('FS_ENTERPRISE_NETWORK','企業ネットワーク');
define('FS_OTN_SOLUTION','OTNソリューション');
define('FS_DATA_CENTER_SOLUTION','データセンターソリューション');
define('FS_OEM_SOLUTION','OEMソリューション');
define('FS_RECENTLY_VIEWED','最近閲覧した製品');
define('FS_CART_TIP','既にアカウントをお持ちですか?<a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link">ログイン</a>して、追加したアイテムを確認したり、新しいアイテムを追加したりできます。');
define('FS_ADDED_TO_CART','カートに追加された');
define('FS_REMOVED','削除する');
define('FS_SHOP_CART_MOVE','カートに移動する');
define('FS_SHOP_CART_SAVE','後で買う');
define('FS_SHOP_CART_SIMILAR','類似製品を見る');
define('FS_SHOP_CART_SAVED','後で買う');
define('FS_CART_EMPTY','ショッピングカートに商品が入っていません。');
define('FS_SVAE_FOR_LATER_TIP',' は今後のために保存されました。');
define('FS_MOVE_TO_CART_TIP',' はカートに移動されました。');
define('FS_DELETE_FOR_LATER','今後のために保存する製品を削除する');
define('FS_DELETE_SURE_SAVE','今後のために保存する製品を削除してよろしいですか？');
define('FS_DELETE_SURE','を削除しますか。');
define('FS_DELETE_CART_TITLE','保存したカートを削除する');
define('FS_SYMBOL','、');



//四级分类名称
define('FS_CATEGORIES_01','製品の種類');
define('FS_CATEGORIES_02','製品の分類');
define('FS_CATEGORIES_03','ツールの種類');
define('FS_CATEGORIES_04','メディアコンバーターの種類');
define('FS_CATEGORIES_05','ケーブルの種類');
define('FS_CATEGORIES_06','KVMスイッチタイプ');
define('FS_CATEGORIES_07','ビデオコンバータータイプ');
define('FS_CATEGORIES_08','アプリケーション');

//下架产品气泡，提示
define('FS_PRODUCT_OFF_TEXT','申し訳ありませんが、該当商品は削除されたためオンラインで購入できなくなりました。');
define('FS_PRODUCT_OFF_TEXT_2','申し訳ございませんが、次の製品は既に削除された可能性があり、FS.COMから購入することができません。');
define('FS_PRODUCT_OFF_TEXT_3','属性をご選択ください。');
define('FS_PRODUCT_OFF_TEXT_4','以下のカスタム製品の属性が変更されました。製品の詳細ページに移動して属性をご選択ください。');
define('FS_PRODUCT_OFF_TEXT_5','*この注文の一部の製品はカートに追加できません。');
define('FS_PRODUCT_OFF_TEXT_6','この注文は利用できない製品を含みますので、スキップしてPOファイルのアップロードを続けてください。');
define('FS_PRODUCT_OFF_TEXT_7','以下の商品はもうオフラインにしましたので、チェックアウトする時合計金額で計算されません。');
define('FS_PRODUCT_OFF_TEXT_8','カート内のアイテムは提供できませんので、決済ページに表示されません。');
define('FS_PRODUCT_OFF_TEXT_9','カート内のアイテムは提供できませんので、決済ページに表示されません。');

//清仓产品气泡,提示
define('FS_PRODUCT_CLEARANCE_TEXT','次の製品は在庫切れになっている可能性があるので、詳しい在庫状況については、アカウントマネージャーにお問い合わせください。');
define('FS_PRODUCT_CLEARANCE_TEXT_1','ご指定の数量が使用可能な在庫を超えているため、在庫状況に応じて調整されています。数量の追加については、アカウントマネージャーにお問い合わせください。');

// 添加购物车成功弹窗
define('FS_ADDED_ONE_ITEM','[ADDITEM]個商品を追加されました。');
define('FS_ADDED_MORE_ITEM','[ADDITEM]個商品を追加されました。');
define('FS_PRODUCTS_JS_MOQ','こちらの商品のMOQは');
define('FS_PRODUCTS_JS_UPPER','上限なし');

define("FS_PRODUCTS_PICK_UP","無料ピックアップ、月～金曜日間に対応可能 ");
define("FS_PRODUCTS_VIA","配送方法");


//fairy 2019.1.15 add
define('FS_COLOR_RED','赤色');
define('FS_COLOR_BLUR','青色');
define('FS_COLOR_GREEN','緑色');

//账户中心
define('FS_MANAGE_ORDERS_1','以下の情報はすべてエンドユーザーまたはスイッチオペレーターに関するものです。技術サポートのサービスを提供することが不可欠ですので、すべての情報が真実かつ有効であることをご確認ください。');
define('FS_MANAGE_ORDERS_2','リクエスト提出済み');
define('FS_MANAGE_ORDERS_3','ライセンスキー : ');
define('FS_MANAGE_ORDERS_4','手順 : ');
define('FS_MANAGE_ORDERS_5','ライセンスキー受領済み');
define('FS_MANAGE_ORDERS_6','アクティベーション終了済み');
define('FS_MANAGE_ORDERS_7','ご提供頂いた情報は正常に送信されました。スイッチを有効にするために、できるだけ早く登録コードを記載したメールをお送り致します。');
define('FS_MANAGE_ORDERS_8','NシリーズCumulusスイッチ');
define('FS_MANAGE_ORDERS_9','NシリーズCumulusスイッチの登録コード');
define('FS_MANAGE_ORDERS_10','お客様 ');
define('FS_MANAGE_ORDERS_11','ご所属なライセンスキーは ');
define('FS_MANAGE_ORDERS_12','注：ライセンスキーを確認する為、約3日を掛かります。確認が完了したら、それをスイッチにインポートできます。');
define('FS_MANAGE_ORDERS_13','1. ライセンスの使用法と制限');
define('FS_MANAGE_ORDERS_14','ライセンスキーは長期間有効になります。');
define('FS_MANAGE_ORDERS_15','アクティベーションの日から、1年間と45日間の技術サポートをご享受頂けます（45日以内に使用しない場合は、追加の無料サービスが期限切れになります）。');
define('FS_MANAGE_ORDERS_16','サービスの有効期限が切れた後も、ご必要に応じてサービスの購入を続けることができます。');
define('FS_MANAGE_ORDERS_17','2. ライセンスキーのインポートプロセス');
define('FS_MANAGE_ORDERS_18','ライセンスをインポートするには、以下のリソースをご確認ください。:');
define('FS_MANAGE_ORDERS_19','ライセンスプロセスの間、ご質問や技術サポートの展開を希望される場合、是非ご連絡頂いてください。連絡先は次の通りです:');
define('FS_MANAGE_ORDERS_20','メールアドレス: ');
define('FS_MANAGE_ORDERS_21','電話番号: +81 345888332');
define('FS_MANAGE_ORDERS_23','このライセンスキーが安全であることを確認し、ご必要に応じてスイッチにインポートしてください。');
define('FS_MANAGE_ORDERS_24','どうぞ、宜しくお願致します。');
define('FS_MANAGE_ORDERS_25','FS.COM技術チーム');
define('FS_MANAGE_ORDERS_26','ビデオ: ');
define('FS_MANAGE_ORDERS_26_1','ビデオ');
define('FS_MANAGE_ORDERS_27','PDF: ');
define('FS_MANAGE_ORDERS_28','電話番号: ');
define('FS_MANAGE_ORDERS_29','在庫品目で即日発送可能');
define('FS_MANAGE_ORDERS_30','ライセンスキーを入手する');
define('FS_MANAGE_ORDERS_31','お客様');
define('FS_MANAGE_ORDERS_32','これはライセンスキーです: ');
define('FS_MANAGE_ORDERS_33','リーフ(10G/25G): 556688 <br />スパイン(40G/100G): 335521');
define('FS_MANAGE_ORDERS_34','ご注意ください: ');
define('FS_MANAGE_ORDERS_35','1.ライセンスキーは長期間有効なりますので、このライセンスキーが安全であることを確認してください。ライセンスキーを確認する為、約3日を掛かります。');
define('FS_MANAGE_ORDERS_36','2.確認が完了したら、スイッチにインポートできます。1年間と45日間の技術サポートをご享受頂けます（45日以内に使用しない場合は、追加の無料サービスが期限切れになります）。サービスの有効期限が切れた後も、ご必要に応じてサービスの購入を続けることができます。');
define('FS_MANAGE_ORDERS_37','ライセンスキーをインポートする方法');
define('FS_MANAGE_ORDERS_38','以下の資料を参考としてご確認ください:');
define('FS_MANAGE_ORDERS_39','ライセンスプロセスの間、ご質問や技術サポートの展開を希望される場合、是非ご連絡頂いてください。連絡先は次の通りです:');
define('FS_MANAGE_ORDERS_40','電子メール: <a style="text-decoration: 無し;色: #232323;">tech@fs.com</a> <br />電話番号: +81 345888332');
define('FS_MANAGE_ORDERS_41','どうぞ、宜しくお願致します。');
define('FS_MANAGE_ORDERS_42','FS.COM技術チーム');
define('FS_MANAGE_ORDERS_43','会社名をご入力ください');
define('FS_MANAGE_ORDERS_44','名前をご入力ください');
define('FS_MANAGE_ORDERS_45','電話番号をご入力ください');
define('FS_MANAGE_ORDERS_46','メールアドレスをご入力ください');
define('FS_MANAGE_ORDERS_47','ご送信されたメールアドレスが認識されません。(例: someone@example.com)。');
define('FS_MANAGE_ORDERS_48','EULA契約ボタンをクリックしてください');
define('FS_MANAGE_ORDERS_49','Webアドレスをご入力ください');
define('FS_MANAGE_ORDERS_50','このメッセージは××に送信されました。');//日语的语法显示，收件人需放在××的位置
define('FS_MANAGE_ORDERS_51','送料無料:いくつかの例外に適用されます。');
define('FS_MANAGE_ORDERS_52','詳細は弊社の ');
define('FS_MANAGE_ORDERS_53','配送ポリシー');
define('FS_MANAGE_ORDERS_53_1','をご覧下さい。');//日语的语法显示，超链接左右都有内容，麻烦处理一下
define('FS_MANAGE_ORDERS_54','FS.COM Limited');
define("CULUMS_OFF1","アクティベーションの申請");
define("CULUMS_OFF2","以下の情報はエンドユーザーとスイッチオペレーターのためのものです。技術サポートのサービスを提供することが重要です。すべての情報が真実で有効であることを確認してください。");
define("CULUMS_OFF3","社名");
define("CULUMS_OFF4","ユーザー名");
define("CULUMS_OFF5","電話番号");
define("CULUMS_OFF6","電子メールアドレス");
define("CULUMS_OFF7","ウェブアドレス");
define("CULUMS_OFF8","EULA契約");
define("CULUMS_OFF9","Cumulus Networks®");
define("CULUMS_OFF10","アクティベーションの申請");
define("CULUMS_OFF11","エンドユーザーソフトウェア使用許諾契約書");
define("CULUMS_OFF12","これらのライセンス条項と注文確認書お客様に（「ライセンシー」）Cumulus Networksによって提供されます。（「Cumulus」）またはCumulusがお客様にソフトウェアを配布することを許可されたディーラー（「認定ディーラー」）は、Cumulusとお客様の間の合意です。これらの条件は、配布されたソフトウェア（該当する場合）を含むメディアに適用されます。これらの条件は、Cumulusがお客様に提供する可能性があるソフトウェアのCumulusアップデート、サプリメント、およびサポートサービスにも適用されます（ただし、これらの項目に追加の条件が付いていない限ります）。その場合、それらの条件が適用されます。このソフトウェアを使用することにより、使用するソフトウェアの全部のコピーに対して有効な注文確認書があること、および全部のコピーに関連する条件に同意することを確認することができます。");
define("CULUMS_OFF13","これらの条件に同意しない場合は、このソフトウェアを使用しないでください。本ソフトウェアを使用する場合、お客様は本ソフトウェア使用許諾契約書（以下「本契約書」）を承諾し、これに同意するものとします。");
define("CULUMS_OFF14","評価、ベータおよびNFRのライセンスについて　Cumulusによって識別される評価ライセンスまたはベータライセンスを受け取った場合、ライセンスには以下の追加制限が適用されます: Cumulusの書面による別段の許可がない限り、本製品の使用は内部の非生産環境（テストおよび評価のみ）で30日間に許可されています;Cumulusが別段の許可を得ていない限り、本製品を同時に5つ以上使用することはできません。お客様が所有しているか、または単独で管理するハードウェア上のみで使用できます。CumulusがNFR（Not-For-Resale）ライセンスとして特定した製品のライセンスを受け取った場合、ライセンスには以下の追加制限が適用されます。製品の使用は、お客様が所有または単独で管理するハードウェア上の1つのインスタンスに対してのみ許可されていますが、Cumulusパートナープログラムのもとで評判の良いパートナーであるため、NFライセンスを受ける資格を持ってられます。製品のデモンストレーション、テスト、トレーニングのみに限定されます。（生産、情報処理、インフラストラクチャーの使用は許可されていません）。何らか規定を違反する場合、ベータライセンス、NFRライセンス製品およびその一部の製品（またはその一部）が何らかの保証、サポートまたは保証なしで「現状のまま」提供されます。評価、ベータライセンス、およびNFRライセンス製品の使用に関連するすべてのリスクをを負わなければなりません。本契約はCUMULUS NETWORKSとの別途書面による合意によってのみ置き換えられます。");
define("CULUMS_OFF15","当事者は次のように同意します：");
define("CULUMS_OFF16","１．定義について");
define("CULUMS_OFF17","a.「製品」はCumulusが提供するネットワークソフトウェアの実行可能バージョンです。本契約で定義されている注文確認（第3条（a）で定義）は、ライセンシーに明確に定義され、利用できます。本契約に基づいてライセンシーにすべてのアップデート、新バージョンの製品および該当するエンドユーザ文書を提供されます。");
define("CULUMS_OFF18","b.「プロプライエタリ情報」とはすべての発明、アルゴリズム、ノウハウおよびアイデアおよびその他のビジネス、人は、開示の内容または状況を考慮して、そのような情報が秘密であると推定します。もしa）開示時と公開前に秘密または専有と特定された場合b）当事者が開示の内容または状況を考慮して、そのような情報が秘密であると推定します。");
define("CULUMS_OFF19","c.「所有権」とは特許権、著作権、営業秘密の権利、世代別データベースの権利、その他の知的財産権および工業所有権を意味するものとします。");
define("CULUMS_OFF20","２．ライセンス交付金について");
define("CULUMS_OFF21","a. 第3条に基づく全額の支払いおよびライセンシーが本契約のその他の条件を遵守することを条件として、Cumulusはライセンシーにライセンスを付与し、Cumulusの所有権下でライセンシーのみに限定して、ライセンシーの利益のために、適用されるライセンス期間の長さ（以下「ライセンス期間」といいます）についてのみ、適用可能なスイッチシリコンのみで、各注文確認書（第3条（a）で定義されている）で指定されている最大ポート速度までしか使用できません。");
define("CULUMS_OFF22","b. 前述のライセンスは第三者への本製品のサブライセンス、配布または開示を許可せず、ライセンシーはそのようなサブライセンス、開示または配布に関与しないことに同意します。");
define("CULUMS_OFF23","c.ライセンシーは（人員または第三者に以下を許可してはならない）:（i）製品の派生品を修正し、作成します。（ii）製品のソースコードまたは根底にあるアイデアやアルゴリズムをリバースエンジニアリングまたは発見しようとする場合があります（適用法でリバースエンジニアリングの制限が禁止されている場合を除く）、（iii）製品の識別、商標、著作権またはその他の通知が製品内に埋め込まれているか、製品内または製品上に現れます。（iv）Cumulusの事前の書面による同意なしに、ベンチマーキングまたはパフォーマンス調査の結果を第三者に公開、公表、配布することはできません。ライセンシーは、その従業員、請負業者、サービスプロバイダー、代理店、およびライセンシーの措置または不作為の結果として本製品へのアクセスが許可されている第三者によるすべての契約条件の遵守と遵守について単独で責任を負うものとします。ライセンシーは、製品の不正使用または不法使用または流通に関連して発生したすべての請求または訴訟（弁護士費用および手数料を含む）を補償し、Cumulusおよびそのライセンサーを損害から守ります。");
define("CULUMS_OFF24","d. 本製品にはオープンソースソフトウェアパッケージ（総称して「オープンソースソフトウェア」）が含まれています。本製品に含まれる各オープンソースソフトウェアパッケージは、該当するオープンソースソフトウェアパッケージライセンスに従ってライセンシーに提供されます。オープンソースソフトウェアパッケージライセンスと本契約のテキストとの間に矛盾が生じた場合、オープンソースソフトウェアパッケージライセンスは、その特定のオープンソースパッケージのみを管理するものとします。");
define("CULUMS_OFF25","e. 本製品は米国の輸出法、規制および規制に準拠しています。ライセンシーはそのような法律、規制または規制に違反して、製品の輸出または再輸出を許可しません。");
define("CULUMS_OFF26","f. 本製品（i）これは私的費用で開発され、営業秘密と機密情報が含まれています。（ii）これはDFARS第227.7202項およびFAR第12.212項の下で規制される商業用コンピュータソフトウェアおよび商用コンピュータソフトウェアの文書で構成された商用品であり、DFARSの規定に基づいて非商用コンピュータソフトウェアまたは非商用コンピュータソフトウェア文書であるとはみなされません。（iii）FAR 52.227-19に規定された商用コンピュータソフトウェアライセンスの下で米国政府機関に提供されていません。該当する場合は、48 CFR 12.212および48 CFR 227.7202に準拠して、本製品は政府のエンドユーザーに対して、本契約の条件に基づいて他のエンドユーザーに付与された権利のみを商用アイテムとしてのみ使用許諾されます。このセクション2（f）は、FAR、DFAR、またはその他のFAR補足条項のいかなる条項にも代わるものであり、それに代わるものです。米国の著作権法により公開されていない権利は保護されています。");
define("CULUMS_OFF27","３．価格、支払および記録について");
define("CULUMS_OFF28","a. 本契約の期間中、ライセンシーはCumulusまたは認定ディーラーに注文書を提出することにより、追加の購入ライセンスの要求を行うことができます。Cumulusまたは認定ディーラーは購入したライセンスの数、ライセンス期間、総価格、税金、購入したライセンスに関する追加の条件を確認する正式で受け入れられた注文書に応答します（それぞれの形式、 注文確認）。購入確認書に記載された各購入ライセンスは、ライセンシーが第２項に記載されたライセンス交付金に従って製品の単一コピーを作成し、製品のコピーを使用することを可能にするものとします。");
define("CULUMS_OFF29","b. 本契約の期間中、ライセンシーはCumulusがライセンシーに提供した注文確認書（税を除く）に基づいて、購入したライセンスを購入する権利を有します。対応する注文確認で指定されている場合、以前に購入したライセンスはその注文確認書に記載されているとおりに直ちに終了し、新しい購入済みライセンス（そのような交換、「変換」）に置き換えられます。コンバージョンに適用される条件は対応する注文確認書またはコンバージョンの詳細を記述するスケジュール（そのようなスケジュール、「コンバージョン通知」）で指定されます。");
define("CULUMS_OFF30","c. ライセンシーは各注文確認書を受領してから３０日以内にライセンシーと認定ディーラーとの間で合意したとおり、各受注確認書に記載されているすべての適用料金（「料金」）をCumulus（または認定ディーラー）に支払うものとします。該当する通貨は注文確認書に記載されます。それ以外の場合は米ドルです。手数料は返金されません。Cumulusの純利益に関する税金（総称して「税金」といいます）を除いて、注文確認書に税金として明示されていない限り、税金、源泉徴収、義務、課税、関税、その他の政府費用（VATを含むがこれに限定されません）、ライセンシーはすべての税金の支払いを担当します。当事者は合理的に税金を合法的に最小限に抑えるために協力します。ライセンシーはCumulusまたは認定販売代理店に料金の一部を支払っていない場合にCumulusまたは認定販売代理店に支払期限の月の未払い総額の1.5％の金額を支払うものとします。ライセンシーと認定ディーラーとの間で別段の合意がない限り、かかる料金は延滞しています。");
define("CULUMS_OFF31","d. 本契約の期間中および終了後１年間、ライセンシーはライセンシーの本製品使用に関する記録を作成し、維持します。この記録には本製品のコピーの各インストールとインストールされているハードウェアの一意の識別子（総称して「レコード」）が含まれます。（これに限定されません）。Cumulusの要請により、ライセンシーは本契約の遵守を検証する目的で、迅速にCumulusにそのようなレコードを提供します。ライセンシーが、本条に基づいて必要に応じてレコードを作成、保守、提供することができなかった場合、またはかかるレコードの正確性に関する紛争が発生した場合、Cumulusはライセンシーの使用を監査することができます。（例えば、ログファイルなど）、ライセンシーが製品をインストールしたまたは他の方法で使用した場所で使用することができます。");
define("CULUMS_OFF32","４．配達とサポートについて");
define("CULUMS_OFF33","a. 本契約に基づく最初の注文確認書の納品後、Cumulusは直ちに、実行の可能形式で製品の１つのコピーをライセンシーに提供します。");
define("CULUMS_OFF34","b. ライセンシーは対応する注文確認書に記載されているようにCumulusからサポートサービスを注文することができ、ライセンシーによる該当するサポート料金の支払いを条件とします。ライセンシーがCumulusのサポートは次のURL<a href='javascript:;'>https://cumulusnetworks.com/support/overview/</a> （「Cumulusサポートプログラム」）に記載されている条件に従うことを認め、同意します。");
define("CULUMS_OFF35","c. 契約と法律で禁止されている場合を除いて、CumulusはCumulusのお客様に一般に市販されているライセンシーのアップデートおよび製品の新リリースを提供し、ライセンシーは購入したライセンスを1つ以上購入します。ライセンシーは対応する注文確認書に明記されているCumulus サポートプログラムを発注して支払いました。");
define("CULUMS_OFF36","５.宣伝、契約の開示および商標について");
define("CULUMS_OFF37","a. Cumulusは本契約の条件を開示することないの場合にライセンシーを顧客として参照する権利を有します。法律と本契約書に記載されている場合を除き、本契約の条項に関するすべての公表はCumulusとライセンシーの間で相互合意によって調整されます。");
define("CULUMS_OFF38","b. 本契約に記載されている場合を除き、当事者の書面（電子通信を含む）の承認を除いて、第三者の商標およびサービスマーク（「マーク」）を使用することはできません。ライセンシーは顧客としてライセンシーを識別する唯一の目的で、ライセンシーのマーク使用ガイドラインに従ってライセンシーのマークを使用するための限定ライセンスをCumulusに付与します。当事者は世界のどこにいても、他者の商標を使用したり、登録したりすることはできません。いずれの当事者も、当事者のいずれかの商標の使用による他者による使用または認可を世界のどこにでも争うことはありません。本契約に基づいて、商標、商号またはその他の指定に関して他の権利とライセンスは付与されません。");
define("CULUMS_OFF39","６．課題に対する禁止について 本契約、本契約に基づく権利、ライセンスまたは義務は非割当当事者の書面による事前の承認なしに、いずれの当事者によっても割り当てられないものとします。 禁止されているステートメントは無効となります。上記にかかわらず、どちらの当事者も当事者の本資産に関連する当事者の資産、事業、株式証券の全部または実質的にすべての取得者に本契約を譲渡するか、またはその権利義務を委任することができます。そのような譲渡のうち、譲渡通知を受領した場合、譲受人は書面による通知により本契約を終了させるため30日を要するものとします。");
define("CULUMS_OFF40","７．契約期間について 本契約の期間は最後のライセンス期間が終了するまで実行されます。ライセンシーがセクション2の条件のいずれかを遵守しなかった場合、セクション2のライセンス付与を含む、本契約は自動的に終了します。この契約はいずれかの当事者が本契約または本契約の重要な規定を実質的に遵守しなかった場合に終了することがあります。終了はそのような30日の期間内に債務不履行が治癒されなかった場合に、債務不履行当事者への終了の通知から30日後に有効とします。");
define("CULUMS_OFF41","８．生存について　第1条、第2条(b-e)、第3条(b)、第6条、第7条、第8条、第9条、第11条、第12条、第13条(b-d)および第14条に基づく支払の権利、終了前に本契約の違反に対する訴訟は、本契約の終了後も存続するものとします。Cumulusによる違反が解消された場合、購入したすべてのライセンスは該当するライセンス期間が終了するまで終了します。ライセンシーの違反が解消された場合、購入したすべてのライセンスは直ちに終了するものとします。");
define("CULUMS_OFF42","９．通知と要請について 本契約に関連するの通知、同意、承認および要求は航空便特急便で送付された後、直ちに行われたものとみなされます。本契約が適用される最新の注文確認書に記載されている適用なアドレス、通知または要求を受け取る当事者となる他の住所に法務部への注意を払い、この第9条の書面通知によって他者に指定することができます。");
define("CULUMS_OFF43","１０．規制法 & 弁護士費用について　本契約はUCITAまたは国際物品売買契約に関する国連条約とは無関係に、抵触法条項に関係なく、カリフォルニア州および米国の法律に準拠し、解釈されるものとします。本合意の主題に関連する訴訟の唯一の管轄権および会場は、カリフォルニア州サンタクララ郡のカリフォルニア州および米国連邦裁判所でなければなりません。両当事者はかかる裁判所の管轄および会場に同意し、カリフォルニアまたは連邦法により認められているように、通知を与えるために本明細書に記載された方法で処理が提供されることに同意するものとします。紛争の当事者である当事者は、合理的な費用弁護士費用およびその他の費用を回収する権利を有するものとします。");
define("CULUMS_OFF44","１１．機密保持について");
define("CULUMS_OFF45","本契約の価格設定条項、製品、基礎発明、アルゴリズム、ノウハウおよびアイデアの価格条件は全部Cumulusの専有情報です。ライセンシーは明示的に許可されている場合を除き、秘密情報を保持し、秘密情報を使用または開示することはなく、従業員および請負業者も同様に書面で拘束されます。本契約書のどこかで明示的に許可されている場合を除き、開示当事者の機密情報を本契約の目的のために「必要に応じて」のみ開示または使用することを本契約の締約国は認めません。本契約が終了すると、ライセンシーは本契約書に別段の定めがある場合を除き、所有情報およびそのコピー、抽出物および派生物を速やかに返却または破棄します。さらに、ライセンシーは、該当する購入済みライセンスが製品のコピーに関して期限切れになるとすぐにi）製品のすべてのコピーを速やかに削除します。 ii）製品がハードウェア・リセラーまたは製造業者を含む第三者にインストールされているハードウェアの配布前です。各当事者は本第11条の違反により、金銭的損害が適切な救済手段ではない、他のものに回復不能な傷害を引き起こすことを認めています。したがって、当事者はそのような違反があった場合に差し止め命令およびその他の公平な救済措置を求めることができます。");
define("CULUMS_OFF46","１２．有限責任について　以下に記載されている場合を除き、本契約のいかなる部分にもかかわらず、当事者は、本契約のいかなる部分の下でまたは契約、過失、過失責任、その他の法律上または妥当な理論の下で責任を負わないものとします。（A）ライセンス料の総額を超えたいかなる金額（CUMULUSの場合とライセンシーの場合）（B）偶発的と必然的な損害、利益の損失（ただし、それ以上の金額を支払う場合を除きます）を除いて、すべての賠償金（第3項に基づいて支払う金額を除く）（C）代用品、技術またはサービスの調達費用が全部ライセンシーによって負担されます。この第12条の制限は第2条（b-e）項、第11条の違反または本契約の許諾範囲の範囲外のライセンシーの訴訟に適用されないものとします。");
define("CULUMS_OFF47","１３．保証について");
define("CULUMS_OFF48","a. Cumulusはライセンシーに製品が良質であり、最高の専門基準に基づいて優れた技量を使用して開発されることを保証します。本保証の違反または製品の欠陥に対する唯一の救済措置は第4条（b）に基づく権利です。 Cumulusはバグや中断のないことを保証しません。");
define("CULUMS_OFF49","b. 本製品は危険なシステム、アプリケーションの操作用のコンポーネントまたはシステム（武器、兵器システム、原子力施設、大量輸送手段、航空、生命維持用コンピュータまたは機器（蘇生を含む）機器および外科用インプラント）、汚染管理、有害物質管理または他の危険なアプリケーションの場合）、製品の故障により人身事故または死亡事態が発生する可能性があります。ライセンシーはそのようなアプリケーションでの本製品の使用が完全にライセンシーのリスクであることを理解しており、ライセンシーはそのようなすべてのリスクを前提としています。");
define("CULUMS_OFF50","c. 前述のとおり明示的に定められている場合を除き、クムルスは商品に関する人物または団体に対するいかなる保証も行わず、商品性および特定の目的への適合性および非侵害性の保証を含め、すべての黙示的な保証を否認します。");
define("CULUMS_OFF51","d.各当事者は本契約の保証責任および責任と救済の制限が本契約の根拠として補償され、本契約および本契約の下で各当事者が払い込むべきとの判断を下したことを考慮していることを認識し、各当事者が本契約に同意します。");
define("CULUMS_OFF52","１４．一般について 本契約は本件の主題に関する両当事者間の完全な合意を構成し、これまでのすべての通信を併合します。本契約締結日以後の書面による合意を除いて、ライセンシーとCumulusの正式な権限を有する代理人によって署名された場合を除き、これは変更することはできません。管轄裁判所が本契約のいずれかの条項を違法、無効または執行不可能とする場合、本条項は本契約が完全な効力を持ち強制可能な限り最小限に制限または排除されるものとします。本契約のいかなる条項のいかなる違反も放棄することは、その前の、同時のまたはその後の違反の放棄を構成するものではありません。書面で行われ、免責された当事者の許可された代表者によって署名されない限り、権利放棄は効力を生じません。");
define("CULUMS_OFF53","提出する");
define("CULUMS_OFF54","著作権©2002-".date('Y',time())." FS.COMリミテッド全著作権所有");
define("CULUMS_OFF55","情報セキュリティポリシー");
define("CULUMS_OFF56","情報が正常に送信されました。10分以内にスイッチを有効にするためのライセンスコードを記載したメールをお送り致します。");
define("CULUMS_OFF57","会社名は必須です。");
define("CULUMS_OFF58","お電話番号は必須です。");
define("CULUMS_OFF59","メールアドレスは必須です。");
define("CULUMS_OFF60","送信したメールアドレスが認識されません（例：someone@example.com）。");
define("CULUMS_OFF61","EULA契約ボタンにチェックを入れてください。");
define("CULUMS_OFF62","ウェブアドレスは必須です。");
define("CULUMS_OFF63","ご確認情報は既に提出されましたので、再度送信しないでください。");
define("CULUMS_OFF64","情報は既に正常に送信されましたので、もう一度送信する必要はありません。");
define("CULUMS_OFF65","製品情報");
define("CULUMS_OFF66","ショッピング体験を私達に共有しましょう ");

define('MY_CASE_UPLOAD_1','ご提出頂いたソリューションリクエスト');
define('MY_CASE_UPLOAD_2','が既に送信されました。');
define('MY_CASE_UPLOAD_3','お客様');
define('MY_CASE_UPLOAD_4','FS.COMソリューションサポートにお問い合わせいただきありがとうございます。ご提出頂いたリクエストは既に受領されましたので、ごソリューションリクエストによる');
define('MY_CASE_UPLOAD_5','ケースを作成しました。');
define('MY_CASE_UPLOAD_6','弊社は24時間以内にご連絡いたしますので、お手数ですが電子メールをご確認ください。');
define('MY_CASE_UPLOAD_7','それまでの間、これらのリソースが役に立つと存じるかもしれません。');
define('MY_CASE_UPLOAD_8','https://www.fs.com/jp/support/Data-Center-Products.html');
define('MY_CASE_UPLOAD_9','https://www.fs.com/jp/support/Enterprise-Small-Business.html');
define('MY_CASE_UPLOAD_10','https://www.fs.com/jp/support/Long-haul-Transmission.html');
define('MY_CASE_UPLOAD_11','https://www.fs.com/jp/support/Optic-OEM-Solution.html');
define('MY_CASE_UPLOAD_12','データセンターのケーブル接続');
define('MY_CASE_UPLOAD_13','企業ネットワーク');
define('MY_CASE_UPLOAD_14','光伝送ネットワーク');
define('MY_CASE_UPLOAD_15','光学OEMソリューション');
define('MY_CASE_UPLOAD_16','どうぞ、宜しくお願致します。');
define('MY_CASE_UPLOAD_17',zen_href_link('索引'));
define('MY_CASE_UPLOAD_19','ソリューションサポート');
define('MY_CASE_UPLOAD_20','FS.COM - ソリューションリクエスト & ケース番号：');

//加购弹窗
define('FS_ADD_CART_PROCHUSE','カート小計');

//地址模块 start
define("FS_ADD_NEW_ADDRESS","新しいアドレスを追加する");
define('FS_ADD_SHIPPING_ADDRESSES','新しいアドレスを追加する');
define('FS_ADD_BILLING_ADDRESS','新しい請求先を追加する');
//地址模块 end

//2019-01-07 继续付款，再次付款，付款成功
define('FS_GC_TIPS_01','申し訳ありませんが、ご提出頂いたリクエストは拒否されました。次の理由を確認してもう一度やり直すか、別の支払い方法をご選択ください。');
define('FS_GC_TIPS_02','1.決済金額が制限を超えています（€15000）。');
define('FS_GC_TIPS_03','2.カードは通貨をサポートしていません。');
define('FS_GC_TIPS_04','3.ネットワークエラーが発生しましたので、しばらくしてからもう一度お試しください。');

//define('FS_PAYMENT_CONFIRM','確認する');
define('FS_PAYMENT_CONFIRM','提出する');
define('PAYMENT_AGAINST_PAYPAL_SECURITY','この注文を支払うためにPayPalアカウントに移動します。');
define('PAYMENT_AGAINST_BANK_SENTENCE01','通常、お金は1-3営業日以内に受け取られます。ご入金の確認が出来次第、早速にご注文を処理致します。');
define('PAYMENT_AGAINST_BANK_SENTENCE02','弊社はご送金を確認し、ご注文を早速に処理できる様に、お支払いをする準備ができているならばお知らせください。');
define('PAYMENT_AGAINST_BANK_FILL','銀行振込情報をご入力ください。');
define('PAYMENT_AGAINST_PAYPAL','PayPal');
define('PAYMENT_AGAINST_BANK','銀行振込');
define('PAYMENT_AGAINST_EDIT','編集する');
define('PAYMENT_AGAINST_BANK_EMAIL','お支払い人のメールアドレス');

define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP','発注書番号は必須です。');
define("FS_ORDER_UPLOAD_PO_MESSAGE",'有効なPOファイルを7営業日以内にご添付ください。そうでない場合、ご注文は配送されませんので、ご了承ください。');

define('FS_AGAINST_PAYER','お支払い人の名前');
define('FS_AGAINST_PAY_TIME','お支払い時間');
define('FS_AGAINST_PAY_AMOUNT','お支払い金額');
define('FS_AGAINST_COUNTRY','お国');
define('FS_AGAINST_PHONE','お支払い人の電話番号');
define('FS_AGAINST_OR','銀行振込に使用する氏名（個人または会社）をご記入ください。');
define('FS_AGAINST_YOUR','お支払いの時間は必須項目です（例：2014-6-12）。');
define('FS_AGAINST_MUST','必要ならばご連絡を差し上げますので、有効な電話番号でしなければなりません。');

define('FS_BT_SUCCESSFULLY','更新しました！');
define('FS_BT_SUCCESSFULLY_SENTENCE_01','通常、お金は1-3営業日以内に受け取られます。ご入金の確認が出来次第、早速にご注文を処理致します。注文を見るには、');
define('FS_BT_SUCCESSFULLY_SENTENCE_02',' 注文履歴 ');
define('FS_BT_SUCCESSFULLY_SENTENCE_03','をクリックしてください。');

//define("FS_CHECKOUT_NEW28","著作権&copy;2009-".date('Y', time())." FiberStore Co., Limitedはすべての権利を留保します。");
define("FS_CHECKOUT_NEW28","Copyright &copy; 2009-" . date('Y', time()) . " ファイバーストア株式会社 All Rights Reserved.");

define('GLOBAL_GS_SENTENCE1','ご注意ください：セキュリティのためにクレジットカードのデータを保存することはありません。');
define('GLOBAL_GS_SENTENCE2','以下の会社により発行されたクレジットカード/デビットカードおよびPカードをご利用いただけます。カードの種類を選択し、以下の情報を入力して「支払う」をクリックしてください。');
define('GLOBAL_GS_SENTENCE3','次のクレジットカード/デビットカードを使用できます。セキュリティ確保のために、当社はお客様のクレジットカードデータを保存しておりません。');
define('FS_AGAINST_WE','以下の会社により発行されたクレジットカード/デビットカードおよびPカードをご利用いただけます。カードの種類を選択し、以下の情報を入力して「支払う」をクリックしてください。');
define("GLOBAL_GC_TEXT6","クレジットカード/デビットカードを選択する:");
define("GLOBAL_GC_TEXT7","注文の概要");
define("GLOBAL_GC_TEXT8","注文番号");
define("GLOBAL_GC_TEXT11","請求先");
define("GLOABL_GC_LIVECHAT","ライブチャット");
define("GLOABL_CART","カート");
define("GLOABL_CHECKETOUT","決済");
define("GLOABL_SUCCESS","成功");
define("GLOBAL_EXPECTED_SHIPPING","発送予定日");
define("GLOBAL_EXPECTED_DELIVERY","配達予定日");
define('FS_ALLOWED_FILE_TYPES','以下のファイル種類のみを許可する: ');
define('CHECKOUT_BILLING_CREDIT','クレジット/デビットカード支払中心');

define('FS_REGIST','登録する');

//询价弹窗
define("FS_INQUIRY_YOUR_ITEM",'対象製品');

define("CHECKOUT_TAXE_CLEARANCE_CN_FRONT","CN倉庫から出荷された注文の場合、弊社は商品代金と送料を請求するだけです。消費税（VAT、GSTなど）は請求されません。しかし、特定の国の法律に応じて、これらのパッケージは輸入関税または関税料金を査定される可能性があります。通関手続きによって生じた関税または輸入関税は受取人が申告し負担する必要があります。マレーシア、インドネシア、フィリピンに出荷された注文については、お客様がオンライン通関で発生する関税や税金を前払いするのを手伝うのために、「貨物運送業者」の発送方法を提供しています。他の地域のお客様として、関税を前払いするのを手伝うことが必要とする場合、当社にご連絡ください。");
define('SAMPLE_EMAIL_SIN','どうぞ、宜しくお願い致します。');

// 上传 start
//2018-9-20 ery add
define('FS_COMMON_FILE','ファイル');
//服务器端的提示
define("FS_UPLOAD_ERROR1",'1番目の添付ファイルのエラー：');
define("FS_UPLOAD_ERROR2",'2番目の添付ファイルのエラー： ');
define("FS_UPLOAD_ERROR3",'3番目の添付ファイルのエラー： ');
define("FS_UPLOAD_ERROR4",'4番目の添付ファイルのエラー： ');
define("FS_UPLOAD_ERROR5",'5番目の添付ファイルのエラー： ');
// 2019.2.26 fairy add
define("FS_UPLOAD_FORMAT_TIP",'以下のファイルの種類を許可する：$FILE_TYPE');
define("FS_UPLOAD_SIZE_DEFAULT_TIP",'ファイルサイズは最大5Mです。');
// 上传 end

//信用卡新加坡渠道弹窗
define("GLOABL_TEXT_DECLINED_1","1. 請求先住所の国家は配送先住所の国家と一致する必要があります。配達先に記載される国家と同じ発行国のクレジットカードを使用してください。");
define("GLOABL_TEXT_DECLINED_2","2 .請求先住所と今回の購買に利用したクレジットカードの住所＆名前が一致しておりませんので、今回注文の請求先住所をチェックしてください。");
define("GLOABL_TEXT_DECLINED_3","3. クレジットカード決済には一つの注文の金額は€15000.00未満必要です。金額が€15000.00以上の場合、幾つらに分けるて支払いを続けます。");
define("GLOABL_TEXT_DECLINED_4","また、支払方法をPayPalや電信送金に変更できます、または支払方法をPayPalに変更して実行することができ、PayPalページを通じてクレジットカードを支払います。");
define("GLOABL_TEXT_DECLINED_5","お支払いはクレジットカードの発行銀行によって拒否されました!");
define("GLOABL_TEXT_DECLINED_6","当社のリスクコントロールのためにお支払いが拒否されました!");
define("GLOABL_TEXT_DECLINED_7"," あなたの銀行と連絡してこの理由と解決策を尋ね、または別のクレジットカードを使用します。それともお支払い方法をPayPalや電信送金に変更して行うこともできます。");
define("GLOABL_TEXT_DECLINED_8","");
define('F_LOADING','読み込み中');

define("GLOABL_TEXT_DECLINED_9","他の支払い方法に切り替えるにはここをクリックしてください。");
define("GLOABL_TEXT_DECLINED_10","ご注文の合計金額は€15000.00を超過した場合は、ご注文を分割してください。また、");
define("GLOABL_TEXT_DECLINED_11"," ここをクリックしてください、");
define("GLOABL_TEXT_DECLINED_12","他の支払い方法に切り替えます。");

define('FS_CLEARACNE_05','すべて見る');
define('FS_CLEARACNE_06','もっと読み込む');

//退换货提示
define('FS_ACCOUNT_HISTORY_1','荷物の受け取りをご確認頂き、返品と交換が有効になります。');

//详情页定制产品加购弹窗
define('FS_CUSTOMIZED_INFORMATION','カスタム情報');
define('FS_CUSTOMIZED','カスタム');
define('FS_PROCESSING','処理中');
define('FS_SHIPPING','配送日数');
define('FS_DELIVERED','配達日');
define('FS_PROCESSING_EST','納入日数: ');
define('FS_EST','予定');
define('FS_SHIPPING_EST','配送日数: ');
define('FS_DELIVERED_EST','配達日: ');
define('FS_BUSINESS_DAYS_ADD',' 営業日');
define('FS_BUSINESS_DAYS_DELIVER_TO',' 営業日予定、配達先 ');
define('FS_CUSTOMIZED_ADD_TO_CART','確認する');
define('FS_KEEP_SHOPPING','買い物を続ける');
define('FS_CONTINUE_TO_CART','カートに進む');

define('FS_PRODCUTS_INFO_VIEW','仕様書:');
define('FS_PRODUCTS_INFO_VIEW_NEW','もっと見る');


define('FS_PRE_ORDER','先行予約');
define('FS_DAY_PROCESSING','<span class="process_time_dylan">$DAYNUMBER</span>日間の処理時間');
define('FS_DAY_PROCESSING_SEARCH','<span class="process_time_dylan">$DAYNUMBER</span>日間の処理時間');
define("PREORDER_DESPRCTION","先行予約は規模の経済と自動化された製造の達成に基づく研究開発と顧客志向の組立ラインに特化しています。予算が厳しく管理されている大量購入とプロジェクトの顧客に費用対効果の高い商品を提供しており、他のトレーダーよりもはるかに速い配達を保証できるようにします。");


//新版邮件公共头尾语言包
define('EMAIL_COMMON_FOOTER_NEW_01',"ショッピング体験を私達に共有しましょう #");
define('EMAIL_COMMON_FOOTER_NEW_02',"でこのメールを購読しています。");
define('EMAIL_COMMON_FOOTER_NEW_03',"ここをクリックして、ご設定を変更するか、または購読を解除することができます。");
define('EMAIL_COMMON_FOOTER_NEW_04',"FS.COM Inc, 380 Centerpoint Blvd, New Castle, DE 19720");
define('EMAIL_COMMON_FOOTER_NEW_05',"お問い合わせ先");
define('EMAIL_COMMON_FOOTER_NEW_06',"マイアカウント");
define('EMAIL_COMMON_FOOTER_NEW_07',"出荷 &amp; 配達");
define('EMAIL_COMMON_FOOTER_NEW_08',"返品規則");
define('EMAIL_COMMON_FOOTER_NEW_09',"はすべての権利を留保します。");
define('EMAIL_COMMON_FOOTER_NEW_10',"著作権");

//密码重置成功之后的邮件
define('RESET_PASS_SUCCESS_01',"パスワードを変更しました。ただ今新しいパスワードで当社のウェブサイトにアクセス可能です。");
define('RESET_PASS_SUCCESS_02','アカウントにログインする');
define('RESET_PASS_SUCCESS_03',"パスワードの変更を求めない場合は、こちらのメールに返信するか、+81 345888332にお電話ください。");
define('RESET_PASS_SUCCESS_04','どうぞ宜しくお願い致します。<br>FSチーム');
define('RESET_PASS_SUCCESS_05','お客様');
define('RESET_PASS_SUCCESS_TITLE','パスワードは更新されました。');
define('RESET_PASS_SUCCESS_THEME','パスワードが更新されました。');

//发送重置密码的邮件
define('RESET_PASS_SEND_01',"FSアカウントのパスワードをリセットするリクエストを受け取りました。このリクエストを行わなかった場合はこのメールを無視してください。このリクエストを行った場合は、下のボタンをクリックして、新しいパスワードを取得することができます。");
define('RESET_PASS_SEND_02',"新しいパスワードを設定する");
define('RESET_PASS_SEND_03',"ご注意ください：パスワードリセットボタンのクリックに問題がある場合は、以下のパスワードリセットコードをコピーしてリセットページに貼り付けてください。パスワードリセットボタンのクリックに問題がある場合は、以下のパスワードリセットコードをコピーしてリセットページに貼り付けてください。");
define('RESET_PASS_SEND_04',"どうぞ宜しくお願い致します。<br>FSチーム");
define('RESET_PASS_SEND_05',"お客様");
define('RESET_PASS_SEND_06',"パスワードなし？問題なし。リセットするようお手伝い致します。");
define('RESET_PASS_SEND_TITLE','パスワードの再設定について');
define('RESET_PASS_SEND_THEME','パスワードのリセット手順');
define('RESET_PASS_EXPIRE_TIME','このパスワードリセットコードは4時間で期限切れになります。新しいパスワードリセットリンクを取得するには、<a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>とのリンクにアクセスしてください。');

//修改邮箱成功之后的邮件
define('RESET_EMAIL_SUCCESS_01',"変更されたメールアドレス：");
define('RESET_EMAIL_SUCCESS_02','お客様');
define('RESET_EMAIL_SUCCESS_03','このアドレスを使用して');
define('RESET_EMAIL_SUCCESS_04',"マイアカウント");
define('RESET_EMAIL_SUCCESS_05',"の詳細情報にアクセス可能です。");
define('RESET_EMAIL_SUCCESS_06',"詳細情報を変更しない場合は、");
define('RESET_EMAIL_SUCCESS_07',"どうぞ宜しくお願い致します。<br>FSチーム");
define('RESET_EMAIL_SUCCESS_08',"にアクセスしてください。");
define('RESET_EMAIL_SUCCESS_TITLE','メールアドレスは更新されました。');
define('RESET_EMAIL_SUCCESS_THEME','FS - メールアドレスが更新されました。');

//个人用户注册
define('REGIST_EMAIL_SEND_01',"FSアカウントに登録頂きましてありがとうございます！今すぐ電子メールアドレスとパスワードでログインすることができます。");
define('REGIST_EMAIL_SEND_02',"お客様");
define('REGIST_EMAIL_SEND_03',"アカウントが正常に作成されました。今すぐ電子メールアドレスとパスワードで ");
define('REGIST_EMAIL_SEND_04',"ログインする");
define('REGIST_EMAIL_SEND_05',"ことができます。");
define('REGIST_EMAIL_SEND_06',"ログイン後、次のことができます：");
define('REGIST_EMAIL_SEND_07',"FSアカウントプロファイル");//超链接需放在07行上
define('REGIST_EMAIL_SEND_08',"を管理し、");
define('REGIST_EMAIL_SEND_09'," 簡単にFSサービスへのアクセス可能です。");
define('REGIST_EMAIL_SEND_10',"技術サポートリクエスト");//超链接需放在10行上
define('REGIST_EMAIL_SEND_11',"を送信して、");
define('REGIST_EMAIL_SEND_12',"無料 & 即時回答を入手可能です。");
define('REGIST_EMAIL_SEND_13',"オンラインで購入し、注文状況をいつでも追跡可能です。");
define('REGIST_EMAIL_SEND_14',"どうぞ宜しくお願い致します。<br>FSチーム");
define('REGIST_EMAIL_SEND_15',"この度は、FSアカウント基本情報のご登録、誠にありがとうございます。このメールはアカウント登録完了のお知らせメールです。アカウント番号は ");
define('REGIST_EMAIL_SEND_16',"です。今すぐ電子メールアドレスとパスワードで");
define('REGIST_EMAIL_SEND_TITLE','アカウントは作成されました。');
define('REGIST_EMAIL_SEND_THEME','新規FSアカウントを早速にご使用可能です！');

//企业用户注册(新用户注册)
define('REGIST_COM_EMAIL_SEND_01','ご提出頂いた法人アカウントのリクエストを受け取りました。現在は審査中で、このプロセスには1-3営業日を掛かる必要がございます。');
define('REGIST_COM_EMAIL_SEND_03','ご提出頂いた法人アカウントのリクエストを受け取りました。現在は審査中で、このプロセスには1-3営業日を掛かる必要がございます。審査が終了すると、FSは早速にメールでお知らせ致します。');
define('REGIST_COM_EMAIL_SEND_02','お客様');
define('REGIST_COM_EMAIL_SEND_04','審査承認される前に、電子メールとパスワードで');
define('REGIST_COM_EMAIL_SEND_05','ログインする');
define('REGIST_COM_EMAIL_SEND_06','ことで、最初に標準的なアカウントサービスを楽しむことができます。');
define('REGIST_COM_EMAIL_SEND_07','ログイン後、次のことができます：');
define('REGIST_COM_EMAIL_SEND_08','FSアカウントプロファイル');//超链接需放在08行上
define('REGIST_COM_EMAIL_SEND_09','を管理し、');
define('REGIST_COM_EMAIL_SEND_10','簡単にFSサービスへのアクセス可能です。');
define('REGIST_COM_EMAIL_SEND_11','技術サポートリクエスト');//超链接需放在11行上
define('REGIST_COM_EMAIL_SEND_12','を送信して、');
define('REGIST_COM_EMAIL_SEND_13','無料 & 即時回答を入手可能です。');
define('REGIST_COM_EMAIL_SEND_14','オンラインで購入し、注文状況をいつでも追跡可能です。');
define('REGIST_COM_EMAIL_SEND_15','どうぞ宜しくお願い致します。<br>FSチーム');
define('REGIST_COM_EMAIL_SEND_TITLE','リクエスト受領済み');
define('REGIST_COM_EMAIL_SEND_THEME','FS - 法人アカウントのリクエストを受信しました。');

//企业用户注册(新用户注册)
define('REGIST_EMAIL_SEND_NEW_01',"アカウントが作成された");
define('REGIST_EMAIL_SEND_NEW_02',"FSへようこそ");
define('REGIST_EMAIL_SEND_NEW_03',"世界をリードするインターネット通信デバイス & ソリューションプロバイダー");
define('REGIST_EMAIL_SEND_NEW_04',"品質管理");
define('REGIST_EMAIL_SEND_NEW_05',"品質は核心的価値であるという理念を掲げながら、常にお客様を中心に、ご期待以上の最高なサービスを届けることに努めております。");
define('REGIST_EMAIL_SEND_NEW_06',"パーソナライズされたソリューション");
define('REGIST_EMAIL_SEND_NEW_07',"革新的で費用効果が高く、信頼できるワンストップソリューションを提供致します。");
define('REGIST_EMAIL_SEND_NEW_08',"迅速な配達");
define('REGIST_EMAIL_SEND_NEW_09',"グローバルな倉庫サービスを提供し、迅速な配達を実現するための十分な在庫を確保します。");
define('REGIST_EMAIL_SEND_NEW_10',"専門知識と技術サポートを提供し、<br>迅速に対応してビジネスを<br>前進させます。");
define('REGIST_EMAIL_SEND_NEW_11',"優れた適切な解決案を取得する為、<br>弊社のブログ、ウィキ、ケース、<br>お知らせにアクセスしてください。");
define('REGIST_EMAIL_SEND_NEW_12',"お買い物を始める");
define('REGIST_EMAIL_SEND_NEW_13',"FSテクニカルサポート");
define('REGIST_EMAIL_SEND_NEW_14',"FSコミュニティ");

//老用户升级
define('REGIST_COM_EMAIL_UPGRADE_01','ご提出頂いた法人アカウントのリクエストを受け取りました。現在は審査中で、このプロセスには1-3営業日を掛かる必要がございます。');
define('REGIST_COM_EMAIL_UPGRADE_02','お客様');
define('REGIST_COM_EMAIL_UPGRADE_03','ご提出頂いた法人アカウントのリクエストを受け取りました。現在は審査中で、このプロセスには1-3営業日を掛かる必要がございます。審査が終了すると、FSは早速にメールでお知らせ致します。');
define('REGIST_COM_EMAIL_UPGRADE_04','どうぞ宜しくお願い致します。<br>FSチーム');
define('REGIST_COM_EMAIL_UPGRADE_TITLE','リクエスト受領済み');
define('REGIST_COM_EMAIL_UPGRADE_THEME','FS - 法人アカウントのリクエストを受信しました。');

//订单邮件语言包
define('FS_ORDER_EMAIL_01','FSをお選びいただきまして誠にありがとうございます。ご予約頂いた注文');
define('FS_ORDER_EMAIL_02','は既に受領致しました。お支払いを完了すると、ご注文はできるだけ早い段階で処理可能でございます。');
define('FS_ORDER_EMAIL_03','ご注文');//（订单号放在之后）
define('FS_ORDER_EMAIL_04','の詳細は次の通りです。ご注文の状態が更新され次第、メールにてお知らせします。');
define('FS_ORDER_EMAIL_05','ご注文 ');
define('FS_ORDER_EMAIL_06','の詳細は以下の通りです。「倉庫でピックアップ」が選択されたので、ご注文が準備完了するとピックアップの説明を電子メールでご送信致します。');
define('FS_ORDER_EMAIL_07','FSをお選びいただきまして誠にありがとうございます。ご予約頂いた注文は既に受領致しました。お支払いを完了すると、ご注文はできるだけ早い段階で処理可能でございます。');
define('FS_ORDER_EMAIL_08','ご注文の詳細は以下の通りです。「倉庫でピックアップ」が選択されたので、ご注文が準備完了するとピックアップの説明を電子メールでご送信致します。');
define('FS_ORDER_EMAIL_09','弊社にお買い物を頂きまして誠にありがとうございます。ご注文の詳細は以下の通りです。ご注文の商品が出荷され次第、早速に追跡情報をお送り致します。');
define('FS_ORDER_EMAIL_10','注文');
define('FS_ORDER_EMAIL_11','今回の購買は以下に分かれています：');
define('FS_ORDER_EMAIL_12','パッケージ ');//（数字放在前面）
define('FS_ORDER_EMAIL_13','注文を管理する');
define('FS_ORDER_EMAIL_14','注文番号');
define('FS_ORDER_EMAIL_15','注文日');
define('FS_ORDER_EMAIL_16','発送予定日');
define('FS_ORDER_EMAIL_17','配達予定日');
define('FS_ORDER_EMAIL_18','ご注文の商品が出荷され次第、すぐご連絡致します。ご注文の最新の状態を確認するには、いつでも');
define('FS_ORDER_EMAIL_19','マイアカウント');
define('FS_ORDER_EMAIL_20','でチェックできますので、ご安心ください。');
define('FS_ORDER_EMAIL_21','注文を変更またはキャンセルする必要がある場合は、');//（超链接放在にアクセスしてください。前）
define('FS_ORDER_EMAIL_22','にアクセスしてください。製品が出荷されたら、それ以上の変更を加えることができないことにご注意ください。');
define('FS_ORDER_EMAIL_23','ご注文の商品が出荷され次第、すぐご連絡致しますので、ご安心ください。注文の最新の状態を確認するには、いつでも当社にご連絡ください。');
define('FS_ORDER_EMAIL_24','注文を変更またはキャンセルする必要がある場合は、ご専属なアカウントマネージャーにご連絡ください。製品が出荷されたら、それ以上の変更を加えることができないことにご注意ください。');
define('FS_ORDER_EMAIL_25','お支払いを完了すると、ご注文はできるだけ早い段階で処理可能でございます。');
define('FS_ORDER_EMAIL_26','注文受領済み');
define('FS_ORDER_EMAIL_27','注文処理中');
define('FS_ORDER_EMAIL_28','お客様');
define('FS_ORDER_EMAIL_29','出荷の詳細');
define('FS_ORDER_EMAIL_30','お届け先');
define('FS_ORDER_EMAIL_31','連絡先情報');
define('FS_ORDER_EMAIL_32','よくある質問');
define('FS_ORDER_EMAIL_33','注文した製品は今どこですか？');
define('FS_ORDER_EMAIL_34','注文を変更する方法がなんですか？');
define('FS_ORDER_EMAIL_35','お支払い詳細');
define('FS_ORDER_EMAIL_36','小計:');
define('FS_ORDER_EMAIL_37','送料:');
define('FS_ORDER_EMAIL_38','合計:');
define('FS_ORDER_EMAIL_39','お支払い方法:');
define('FS_ORDER_EMAIL_40','すべての料金は<a style="color: #0070BC;text-decoration: none" href="javascript:;">FS COM</a>として請求されます。');//（链接放在になります。前面）
define('FS_ORDER_EMAIL_41','請求先');
define('FS_ORDER_EMAIL_42','ご注文どうもありがとうございました。ご注文#の詳細についてはメール中身をご覧ください。');//（订单号放在#后面）
define('FS_ORDER_EMAIL_43','FS-注文%sは既に受領されましたので、お支払いを完了してください。');
define('FS_ORDER_EMAIL_44','ピックアップ住所');
define('FS_ORDER_EMAIL_45','ピックアップ者');
define('FS_ORDER_EMAIL_46','POファイルをアップロードすると、ご注文はできるだけ早い段階で処理可能でございます。');
define('FS_ORDER_EMAIL_47','ご注文%sのご送金は確認されましたので、FSでお買い物いただきありがとうございました。');
define('FS_ORDER_EMAIL_48','注文書');
define('FS_ORDER_EMAIL_49','準備中');
define('FS_ORDER_EMAIL_50','ピックアップ');
//2019.4.9 新增俄罗斯对公支付 邮件语言包 [ORDERNUMBER]不需要翻译保留即可，只有一单时会替换成对应的订单号，多单时会替换为空
define('FS_ORDER_EMAIL_51', "FSをお選びいただきまして誠にありがとうございます。ご予約頂いた注文[ORDERNUMBER]は既に受領致しました。弊社のアカウントマネージャーより早速に請求書を電子メールにご送信致します。");
define('FS_ORDER_EMAIL_52','お支払い情報をご確認ください:');
define('FS_ORDER_EMAIL_53','連絡先');
define('FS_ORDER_EMAIL_54','電話番号*');
define('FS_ORDER_EMAIL_55','電子メール*');
define('FS_ORDER_EMAIL_56','組織の名前*');
define('FS_ORDER_EMAIL_57','INN*');
define('FS_ORDER_EMAIL_58','KPP*');
define('FS_ORDER_EMAIL_59','OKPO');
define('FS_ORDER_EMAIL_60','BIC*');
define('FS_ORDER_EMAIL_61','法的住所*');
define('FS_ORDER_EMAIL_62','私書箱の住所');
define('FS_ORDER_EMAIL_63','コルレス口座');
define('FS_ORDER_EMAIL_64','銀行名*');
define('FS_ORDER_EMAIL_65','決済口座*');
define('FS_ORDER_EMAIL_66','保有者の氏名');
define('FS_ORDER_EMAIL_67','お支払情報');
define('FS_ORDER_EMAIL_68','長さ');
define('FS_ORDER_EMAIL_09_1','ご購入いただいた製品は、');
define('FS_ORDER_EMAIL_09_2','の2つのパッケージに分割されています。詳細は次の通りです。');
define('FS_ORDER_EMAIL_69','');
define('FS_ORDER_EMAIL_70','注文履歴');
define('FS_ORDER_EMAIL_71','ページでご注文のステークスを追跡できます。');
define('FS_ORDER_EMAIL_72','入金確認');
define('FS_ORDER_EMAIL_73','進行中');
define('FS_ORDER_EMAIL_74','輸送中');
define('FS_ORDER_EMAIL_75','配達完了');
define('FS_ORDER_EMAIL_76','PO確認済み');
//邮件系统改版语言包
//在线询价(A)
define('FS_SEND_EMAIL','FS - お見積もりは既に受領されました。');
define('FS_SEND_EMAIL_1',"お見積依頼 ");
define('FS_SEND_EMAIL_2'," を受領されましたので、1営業日以内に見積もりの詳細をメールでお知らせ致します。");
define('FS_SEND_EMAIL_3',"ご提出頂いたお申し込み");
define('FS_SEND_EMAIL_3_1','サンプルのお申し込み$CASENUMBERが受領されました');
define('FS_SEND_EMAIL_4'," を受け取ってから、1営業日以内に見積もりの詳細をメールでお知らせ致します。");
define('FS_SEND_EMAIL_5',"追加コメント");
define('FS_SEND_EMAIL_6',"お見積もり品一覧");
define('FS_SEND_EMAIL_7',"追加コメント");
define('FS_SEND_EMAIL_8',"数量: ");
//在线技术咨询A
define('FS_SEND_EMAIL_8_1','FS-サポートリクエスト#NUMBER#は既に受領されました。');
define('FS_SEND_EMAIL_8_2', 'FS - 製品のテクニカルリクエストは既に受領されました。 ');//product_support页面，发送邮件
define('FS_SEND_EMAIL_9',"FSにご連絡頂きまして誠にありがとうございます。ケース番号は");
define('FS_SEND_EMAIL_10',"。FSのテクニカルサポートチームが6-18時間以内にご連絡いたします。");
define('FS_SEND_EMAIL_10_1',"6～18時間以内にご連絡いたします。");//product_support页面，发送邮件
//产品QA邮件
define('FS_SEND_EMAIL_11',"FS - 製品#に関する質問は既に受領されました。");
define('FS_SEND_EMAIL_12',"受け取った質問");
define('FS_SEND_EMAIL_12_1',"製品#に関するご質問は既に受領されましたので、");
define('FS_SEND_EMAIL_13'," 1営業日以内にお返事致します。");
define('FS_SEND_EMAIL_14',"製品に関するご質問は既に受領されましたので、");
define('FS_SEND_EMAIL_15'," 1営業日以内にお返事致します。");
//退换货all
define('FS_SEND_EMAIL_16',"処理中");
define('FS_SEND_EMAIL_17',"注文の問題に関するご依頼は既に受領されました。");
define('FS_SEND_EMAIL_18',"今までお世話になりまして誠にありがとうございます！");
define('FS_SEND_EMAIL_19',"FS - サポートリクエストは既に受領されました。");
define('FS_SEND_EMAIL_20',"FSにご連絡頂きましてありがとうございます。ごサポートリクエストは既に受領されましたので、1営業日以内にお返事致します。");
define('FS_SEND_EMAIL_21',"FSにご連絡頂きましてありがとうございます。ごサポートリクエストは既に受領されましたので、1営業日以内にお返事致します。ケース番号は");
define('FS_SEND_EMAIL_22',"製品#に関する在庫のご請求は既に受領されましたので、");
define('FS_SEND_EMAIL_23'," 1営業日以内にご連絡致します。");
define('FS_SEND_EMAIL_24',"製品に関する在庫のご請求は既に受領されましたので、");
define('FS_SEND_EMAIL_25'," 1営業日以内にご連絡致します。ケース番号は ");
define('FS_SEND_EMAIL_26',"。ご依頼に関するその後すべてのやり取りはこの番号を参照することができます。");
define('FS_SEND_EMAIL_27',"対象品目");
define('FS_SEND_EMAIL_28',"追加コメント");
define('FS_SEND_EMAIL_29',"請求数量: ");
define('FS_SEND_EMAIL_30',"要望到着日: ");
define('FS_SEND_EMAIL_31',"FS - 在庫の請求は既に受領されました。");
define('FS_SEND_EMAIL_32',"FS - 返金のお申込みは既に受領されました。");
define('FS_SEND_EMAIL_33',"払い戻しのリクエストは届きましたので、1営業日以内に詳細をメールでお知らせ致します。");
define('FS_SEND_EMAIL_34',"FS - 交換のお申込みは既に受領されました。");
define('FS_SEND_EMAIL_35',"交換リクエストは届きましたので、1営業日以内に詳細をメールでお知らせ致します。");
define('FS_SEND_EMAIL_36',"FS -メンテナンスのお申込みは既に受領されました。");
define('FS_SEND_EMAIL_37',"メンテナンス依頼は届きましたので、1営業日以内に詳細をメールでお知らせ致します。");
define('FS_SEND_EMAIL_38'," FS返品・交換についてのご案内");
define('FS_SEND_EMAIL_39',"注文に対する返品を完了するには、次の手順に従ってください。");
define('FS_SEND_EMAIL_40',"返品注文");
define('FS_SEND_EMAIL_41',"そして、1営業日以内に払い戻し品目に関する詳細な情報をメールでお知らせ致します。");
define('FS_SEND_EMAIL_42',"そして、1営業日以内に交換品目に関する詳細情報をメールでお知らせ致します。");
define('FS_SEND_EMAIL_43',"そして、1営業日以内にメンテナンス品目に関する詳細情報をメールでお知らせ致します。");
define('FS_SEND_EMAIL_44',"払い戻し品目");
define('FS_SEND_EMAIL_45',"交換品目");
define('FS_SEND_EMAIL_46',"メンテナンス品目");
define('FS_SEND_EMAIL_47',"払い戻し");
define('FS_SEND_EMAIL_48',"ご注文#");
define('FS_SEND_EMAIL_49',"にての製品はご期待にお応えすることが出来ず、誠に申し訳ございません。返金の手続きを効率的に進めるには、次の簡単な手順に従ってください：");
define('FS_SEND_EMAIL_50',"返品品目の到着を確認後、1営業日以内に購入時ご利用いただいた決済サービス事業者経由で");
define('FS_SEND_EMAIL_51',"の払い戻しの手続きが行われます。1週間以内にアカウントに返金する見込みです。");
define('FS_SEND_EMAIL_52',"の概要");
define('FS_SEND_EMAIL_53',"製品価格:");
define('FS_SEND_EMAIL_54',"返品送料:");
define('FS_SEND_EMAIL_55',"返金全額:");
define('FS_SEND_EMAIL_56',"返金方法:");
define('FS_SEND_EMAIL_57',"元のお支払い方法 ");
define('FS_SEND_EMAIL_58',"返品条件については、");
define('FS_SEND_EMAIL_59',"ここをクリックしてください。");
define('FS_SEND_EMAIL_60',"交換");
define('FS_SEND_EMAIL_61',"注文にての製品はご期待に応えなかったのはお詫び申し上げます。");
define('FS_SEND_EMAIL_62'," 交換を完了するには、次の簡単な手順に従ってください:");
define('FS_SEND_EMAIL_63',"返品品目の到着を確認後、代替製品を発送させて頂き、追跡情報もお送りします。");
define('FS_SEND_EMAIL_64',"メンテナンス");
define('FS_SEND_EMAIL_67',"メンテナンス完了後、返品品目が配送され次第、追跡情報もお送りします。");
define('FS_SEND_EMAIL_68',"の概要");
define('FS_SEND_EMAIL_69',"お届け先");
define('FS_SEND_EMAIL_70',"連絡先情報");
define('FS_SEND_EMAIL_71',"参考: PO#");
define('FS_SEND_EMAIL_83',"価格: ");
//样品申请邮件
define('FS_SEND_EMAIL_84',"ご提出頂いたサンプルリクエストは既に受領されましたので、24時間以内にご返信致します。");
define('FS_SEND_EMAIL_85',"ご提出頂いたサンプルリクエストが届きましたので、当社の専門チームマネージャーはできるだけ早くご連絡を差し上げます。ケース番号は");
define('FS_SEND_EMAIL_86',"。ご請求に関するその後すべてのやり取りはこの番号を参照することができます。");
define('FS_SEND_EMAIL_87',"サンプル一覧");
define('FS_SEND_EMAIL_88',"リクエスト数: ");
define('FS_SEND_EMAIL_89',"追加コメント");
define('FS_SEND_EMAIL_90',"FS - サンプルリクエストは既に受領されました。");
//cumlums交换机发送激活码邮件
define('FS_SEND_EMAIL_91',"ライセンスキー");
define('FS_SEND_EMAIL_92',"アクティベーション情報は正常に送信されました。");
define('FS_SEND_EMAIL_94',"ライセンスキーと注文の詳細は次のとおりです。ソフトウェアをアクティブにするには、このライセンスキーをスイッチにインストールする必要があります。このライセンスキーはアカウントに対して固有です。それを有効にするのを助けるために約3日を費やします。ライセンスのインストールプロセス中の適切なタイミングでライセンスキーテキストをコピーして貼り付けてください。");
define('FS_SEND_EMAIL_95',"ご注意ください:ライセンスキーは長期間有効です。テクニカルサポートサービスの期間は1年ですが、45日以内にインストールすれば、45日間無料でお楽しめます。");
define('FS_SEND_EMAIL_96',"ご質問またはサポートが必要な場合は、までご連絡ください。");
define('FS_SEND_EMAIL_97',"ライセンスキー");
define('FS_SEND_EMAIL_98',"Cumulus Linux 2.5.3または以降のバージョンの場合:");
define('FS_SEND_EMAIL_99',"注文番号: ");
define('FS_SEND_EMAIL_100',"日付: ");
define('FS_SEND_EMAIL_101',"詳細はこちらへ");
define('FS_SEND_EMAIL_102',"FS - ライセンスキー");
//付款链接
define('FS_SEND_EMAIL_103',"<br>備考:");
define('FS_SEND_EMAIL_104',"からお支払い請求が送られました。");
define('FS_SEND_EMAIL_105',"請求書番号 : ");
define('FS_SEND_EMAIL_106',"今すぐお支払う");
define('FS_SEND_EMAIL_107',"FS - からのお支払い請求があります。");
//分享购物车
define('FS_SEND_EMAIL_108',"カートリストを共有する");
define('FS_SEND_EMAIL_109',"お友達 ");
define('FS_SEND_EMAIL_110'," はカートリストを共有しました。");
define('FS_SEND_EMAIL_111',"お友達");
define('FS_SEND_EMAIL_112'," はショッピングカートを共有しました。下のボタンをクリックして詳細を確認し、自分のショッピングカートのリストに追加することができます。");
define('FS_SEND_EMAIL_113',"カート一覧");
define('FS_SEND_EMAIL_115',"この電子メール ");
define('FS_SEND_EMAIL_116'," は");
define('FS_SEND_EMAIL_117',"'FS.COMの 「友達とシェア」サービスを使って");
define('FS_SEND_EMAIL_118',"As a result of receiving this message, you will not receive any unsolicited message from ");
define('FS_SEND_EMAIL_119',"詳細では ");
define('FS_SEND_EMAIL_120',"プライバシーポリシー");
define('FS_SEND_EMAIL_121',"FS - お友達");
define('FS_SEND_EMAIL_122'," はショッピングカートを共有しました。");
//分享产品
define('FS_SEND_EMAIL_123',"製品を共有する");
define('FS_SEND_EMAIL_124',"この製品に興味があるかもしれません。");
define('FS_SEND_EMAIL_125',"詳細はこちらへ");
define('FS_SEND_EMAIL_126',"'s Share With A Friend service. As a result of receiving this message, you will not receive any unsolicited message from ");
define('FS_SEND_EMAIL_127'," 詳細では");
define('FS_SEND_EMAIL_129',"は製品を共有しました。");
//RMA取消订单邮件
define('FS_SEND_EMAIL_130',"RMAの更新");
define('FS_SEND_EMAIL_131',"ご注文# ");
define('FS_SEND_EMAIL_132',"のRMA申請はキャンセルされました。さらなる問題がありましたら、お気軽にご連絡ください。");
define('FS_SEND_EMAIL_133',"キャンセルされたRMA");
define('FS_SEND_EMAIL_135',"はキャンセルされました。");
define('FS_SEND_EMAIL_136',"さらなる問題がありましたら、お気軽にライブチャットまたは+81 345888332にご連絡ください。");
define('FS_SEND_EMAIL_137',"RMA品目");
//订单评价成功邮件
define('FS_SEND_EMAIL_138',"お支払い要求が送信されました。");
define('FS_SEND_EMAIL_139',"注文の更新");
define('FS_SEND_EMAIL_140',"ご注文#");
define('FS_SEND_EMAIL_141',"キャンセルされた注文");
define('FS_SEND_EMAIL_142',"ご注文頂きましてありがとうございます。今後の連携を期待しております。");
define('FS_SEND_EMAIL_143',"注文詳細");
//留言入口客户调查问卷
define('FS_SEND_EMAIL_144',"フィードバックを共有する");
define('FS_SEND_EMAIL_145',"FSを友人や同僚に推薦する可能性はどれくらいですか？");
define('FS_SEND_EMAIL_146',"最高のショッピング体験を楽しむことを確実にするために、<br>お手数ですが上記の質問にお答えください。ご応答頂くとき、レビューについての簡単な説明<br>をするように頼まれます。すべてのフィードバックは非常に役に立ちます。");
//live_chat留言
define('FS_SEND_EMAIL_147',"フィードバックの話題");
define('FS_SEND_EMAIL_148',"FSにご連絡頂きましてありがとうございます。メールは既に受領されましたので、当社は12時間以内にお返事致します。");
define('FS_SEND_EMAIL_149',"FS - メールメッセージを受け取りました。");
define('FS_SEND_EMAIL_150',"FSにご連絡頂きましてありがとうございます。メールは既に受領されましたので、当社は12時間以内にお返事致します。ケース番号は");
define('FS_SEND_EMAIL_151',"製品を共有する");
define('FS_SEND_EMAIL_152',"この製品に興味があるかもしれません。");
define('FS_SEND_EMAIL_153',"お友達");
define('FS_SEND_EMAIL_154'," この電子メールは");
define('FS_SEND_EMAIL_155'," によって送信されました。");
define('FS_SEND_EMAIL_156',"FS - RMAはキャンセルされました。");
define('FS_SEND_EMAIL_157',"FS - ご提供頂いたお見積もり依頼は既に受領されました。 ");
define('FS_SEND_EMAIL_158',"からのメッセージ");
define('FS_SEND_EMAIL_159',"リストに追加する");
//退换货
define('FS_SEND_EMAIL_160',"ご注文#");
define('FS_SEND_EMAIL_160_01',"FS-注文#");
define('FS_SEND_EMAIL_161',"FS - ご所属なFS注文");
define('FS_SEND_EMAIL_162',"返却手順");
define('FS_SEND_EMAIL_163',"1. RMAを印刷する");
define('FS_SEND_EMAIL_164',"RMAフォームで荷物を見分けることができますので、お手数ですが、RMAフォームを印刷してカートン・段ボールに貼り付けてください。");
define('FS_SEND_EMAIL_165',"2. 製品を梱包する");
define('FS_SEND_EMAIL_166',"元のカートン・段ボールをご利用の場合、古いラベルを剥がしてください。");
define('FS_SEND_EMAIL_167',"3. 荷物を出荷する");
define('FS_SEND_EMAIL_168',"パッケージを弊社に送ってください。");
define('FS_SEND_EMAIL_169',"4. 返却品を受け取る");
define('FS_SEND_EMAIL_170',"FSにご連絡頂きましてありがとうございます。弊社は既にご提出頂いたお電話依頼を受け取りましたので、連絡を取れるために最適な時間にご連絡差し上げます。");
define('FS_SEND_EMAIL_171',"FS - ご提出頂いたお電話依頼を受け取りました。");
define('FS_SEND_EMAIL_3_1',"お支払い請求");
define("PRERDER_PROCESSIONG","<i class='popover_i'></i>先行予約商品の処理時間は営業日で計算され、生産及び測定時間が含まれています。輸送時間が別として選択された配送方法によって決定されます。");
define("PRERER_SAVE"," プロジェクト予算を節約する目的");

//quest add 2019-03-01
define('CHECKOUT_CUSTOMER_ACCOUNT1','9桁の有効な口座をご入力てください。');
define('CHECKOUT_CUSTOMER_ACCOUNT2','6文字の有効な口座をご入力てください。');

// fairy 2019.1.17 组合子产品
define("FS_ITEM_INCLUDES_PRODUCTS","この製品は以下の部品で構成されています。");


define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total general');
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');

define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+)Shipping Cost:');
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Total');
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');

//2019.3.9   ery  add 专题询价板块
define('FS_SPECILA_INQUIRY_QUESTION', 'お質問ですか？ 早速ご応答致します。');
define('FS_SPECILA_INQUIRY_ASK', '価格、納期などについて何かご不明な所がございましたら、お気軽にお尋ねください。当社の高度に訓練された日本アカウントマネージャーは、待機する準備ができています。');
define("FS_SEARCH_YOUR_COUNTRY",'国/地域を検索してください');

//rebirth.ma  2019.03.12  上传错误定义
define("FS_FILE_TOO_LARGE","ファイルが大きすぎるので、アップロードに失敗しました。");

define('FIBERSTORE_PRODUCT_DETAIL','製品詳細');
//rebirth.ma  2019.03.22  购物车样式调整
define("FS_Summary","注文内容");


define('FS_SAMPLE_APPLICATION_SUBMIT','提出中...');

//liang.zhu 2019.04.02 定义tpl_modules_index_product_list_old_style.php
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'グリッドビュー');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'リストビュー');
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'クイックファインダー');

//2019.4.4  ery  ADD俄罗斯对公支付方式名
define("FS_CHECKOUT_NEW_CASHLESS","キャッシュレス支払い");
define("SHIPPING_COURIER_DELIVERY","宅配便");
define("SHIPPING_DELIVERY","配送方法");
define("SHIPPING_COURIER_DELIVERY_01","（個人のみに適用）");
//2019.4.11  ery add  俄罗斯对公支付收税政策文字表达优化
define('CHECKOUT_TAXE_RU_TIT', 'ロシア連邦税法第21章に従い、FS.COM Ltdはロシアに配達されたすべての注文に対してVATを課す義務を負います。 ロシアの一般税法によると、当社のカタログのすべての製品は20％の標準付加価値税（VAT）の対象となります。 注文に必要なすべての情報（企業の種類と配送先住所を含む）を入力すると、お支払いを行う前にVATを含めた合計金額がわかります。');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","個人のお客様からのご注文が国際倉庫から出荷される場合、製品の価格と配送料のみを請求いたします。通関手続きに起因する関税または輸入関税は、受領人が申告しご負担いただきます。2020年1月1日から、免税購入の基準額は200ユーロに引き下げられ、パッケージあたりの最大重量は31kgになります。他の配送方法に関心がございましたら、またはキャッシュレス決済をご希望の場合、ご専属なアカウントマネージャーにお問い合わせください。");
define("FS_EMAIL_ERROR","あなたのEメールアドレスが正しくありません");
define("FS_CREDIT_CARD_NOTICE","お支払いを続けるには、請求先住所を入力してください。");

//报价改版 ternence 2019.04.17
define("FS_INQUIRY_INFO","お見積もり書");
define("FS_INQUIRY_INFO_1","新製品を追加する");
define("FS_INQUIRY_INFO_2","追加する");
define("FS_INQUIRY_INFO_3","オンライン製品IDをご入力ください。");
define("FS_INQUIRY_INFO_4","単価");
define("FS_INQUIRY_INFO_5"," ノートを取る");
define("FS_INQUIRY_INFO_6","編集する");
define("FS_INQUIRY_INFO_7","既存のアカウントをお持ちですか？");
define("FS_INQUIRY_INFO_8","ログイン</a>/");
define("FS_INQUIRY_INFO_9","アカウントを作成");
define("FS_INQUIRY_INFO_10","し、オンラインでお見積を追跡します。");
define("FS_INQUIRY_INFO_11","お見積もりについてお知りになりたい情報");
define("FS_INQUIRY_INFO_12","ロゴ");
define("FS_INQUIRY_INFO_13","保証");
define("FS_INQUIRY_INFO_14","納期");
define("FS_INQUIRY_INFO_15","量販価格");
define("FS_INQUIRY_INFO_16","PO注文");
define("FS_INQUIRY_INFO_17","備考");
define("FS_INQUIRY_INFO_18","ファイル");
define("FS_INQUIRY_INFO_19","以下のファイルの種類を許可する：JPG、PDF、PNG、XLS、XLSX <br>ファイルサイズは最大5Mです。");
define("FS_INQUIRY_INFO_20","送信");
define("FS_INQUIRY_INFO_21","見積もり依頼はまだありません。");
define("FS_INQUIRY_INFO_22","お買い物を続ける");
define("FS_INQUIRY_INFO_24","審査には約12時間を掛かります。");
define("FS_INQUIRY_INFO_25","御見積書のお申し込み");
define("FS_INQUIRY_INFO_26","以下の製品はカスタマイズ製品ですので、製品ページで属性を選択してから見積もりリストに追加してください。");
define("FS_INQUIRY_INFO_26_2","製品ID");
define("FS_INQUIRY_INFO_26_3","がレコードに見つかりませんでした。");
define("FS_INQUIRY_INFO_27","お見積り番号のリクエスト");
define("FS_INQUIRY_INFO_28","が送信されました。");
define("FS_INQUIRY_INFO_29","早速見積もりを処理し、12〜24時間以内にご返信いたします。<b>マイアカウント</b> > <b>お見積履歴</b>で見積りのステータスを確認できます。");
define("FS_INQUIRY_INFO_30","こんにちは！");
define("FS_INQUIRY_INFO_30_1","属性を選択する");
define("FS_INQUIRY_INFO_31","アカウントを使用すると、アカウント内の見積もりを簡単に確認したり、次のような優れたFSサービスを利用することができます:");
define("FS_INQUIRY_INFO_32","- 注文履歴を通じて簡単に追跡可能");
define("FS_INQUIRY_INFO_33","- アドレス帳による迅速なチェックアウト可能");
define("FS_INQUIRY_INFO_34","今すぐアカウントを作りましょうか？");
define("FS_INQUIRY_INFO_35","いいえ、結構です。(その為、当社には電子メールでお見積もり書をご連絡させてください。)");
define("FS_INQUIRY_INFO_36","はい、今すぐアカウントを作成に参ります。");

define("FS_INQUIRY_INFO_37","お見積履歴");
define("FS_INQUIRY_INFO_38","お見積もりの状況を確認し、より優遇な価格で直接購入可能です。 ");
define("FS_INQUIRY_INFO_39","カスタマーサービスに連絡する");
define("FS_INQUIRY_INFO_40","見積り提出日");
define("FS_INQUIRY_INFO_41","見積り番号");
define("FS_INQUIRY_INFO_42","合計");
define("FS_INQUIRY_INFO_43","見積もり名");
define("FS_INQUIRY_INFO_43_1","もっと見る");
define("FS_INQUIRY_INFO_43_2","見積もりをキャンセル");

define("FS_INQUIRY_INFO_44","お見積に入れる");
define("FS_INQUIRY_INFO_45","数量");
define("FS_INQUIRY_INFO_46","リストへ");
define("FS_INQUIRY_INFO_47","御見積り依頼");
define("FS_INQUIRY_INFO_48","お見積依頼リスト");
define("FS_INQUIRY_INFO_23","御見積り依頼 ");
define("FS_INQUIRY_INFO_23_1","は送信されました。");
define("FS_INQUIRY_INFO_49","見積り名:");
define("FS_INQUIRY_INFO_50","この見積もりはX日後に期限切れになります。できるだけ早くチェックアウトしてください。");
define("FS_INQUIRY_INFO_51","御見積もりは期限切れです。");
define("FS_INQUIRY_INFO_52","ノート");
define("FS_INQUIRY_INFO_54","製品IDをご入力");
define("FS_INQUIRY_INFO_55","オンラインの製品IDをご入力ください。");
define("FS_INQUIRY_INFO_56","お名前*");
define("FS_INQUIRY_INFO_57","メールアドレス*");
define("FS_INQUIRY_INFO_58","電話番号*");
define("FS_INQUIRY_INFO_59","製品ID ");
define("FS_INQUIRY_INFO_60"," が当社のレコードに見つかりませんでした。");
define("FS_INQUIRY_INFO_61","御見積もりに名前を付けて下さい。");
define('FS_MANAGE_ORDERS_MORE','もっと');
define("FS_INQUIRY_INFO_62","見積り番号");
define("FS_INQUIRY_INFO_63","各属性のオプションをお選びください。");
define("FS_INQUIRY_BUY_TIP",'この見積もりは15日間のみ有効ですので、できるだけ早くチェックアウトしてください。そして、購入数量はお問い合わせ以上でなければなりません。');
define("FS_INQUIRY_INFO_53","お見積リスト");
define("FS_INQUIRY_INFO_64","全てのお見積");
define("FS_INQUIRY_INFO_65","この見積もりは15日間有効ですので、できるだけ早くチェックアウトしてください。");
define("FS_INQUIRY_INFO_66","お見積依頼は期限切れです。");

define('FS_INQUIRY_EMPTY_TXT','お見積依頼はまだありません。');
define('FS_INQUIRY_EMPTY_TXT_01','製品の詳細ページでお見積依頼をご送信ください。または、オンラインアイテム番号を直接ご入力ください。');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">もし既にアカウントをお持ちの場合は、<a href="'.zen_href_link('login','','SSL').'">ログイン</a>してお見積依頼をチェックしてください。</p>');


define('FS_CREDIT','マイ掛売口座');

define('FS_ACCOUNT_NEW_01','ヘルプをお必要ですか？');
define('FS_ACCOUNT_NEW_02','月-金');
define('FS_ACCOUNT_NEW_03','注文履歴');
define('FS_ACCOUNT_NEW_04','マイオーダー');
define('FS_ACCOUNT_NEW_05','返品した');
define('FS_ACCOUNT_NEW_06','利用可能なクレジット限度額:');
define('FS_ACCOUNT_NEW_07','最近の注文');
define('FS_ACCOUNT_NEW_08','注文履歴');
define('FS_ACCOUNT_NEW_09','まだ何も購入していません。');
define('FS_ACCOUNT_NEW_10','最近閲覧した製品');
define('FS_ACCOUNT_NEW_11','最近の御見積もり');
define('FS_ACCOUNT_NEW_12','御見積もりを見る');
define('FS_ACCOUNT_NEW_13','見積もり依頼はまだありません。');

//2019.5.3 pico 企业账号注册

define("FS_BUSINESS_ACCOUNT_01","法人アカウント");
define("FS_BUSINESS_ACCOUNT_02","今すぐFS法人アカウントを作成して、商品やサービスの2％割引、そしてその他の大きな特典を手に入れましょう。");
define("FS_BUSINESS_ACCOUNT_03","優遇な価格");
define("FS_BUSINESS_ACCOUNT_04","迅速的な配送");
define("FS_BUSINESS_ACCOUNT_05","簡単なオンライン見積");
define("FS_BUSINESS_ACCOUNT_06","専門的なカスタマイズ");
define("FS_BUSINESS_ACCOUNT_07",'すでにアカウントをお持ちですか？ <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">アカウントをアップグレード</a>');
define("FS_BUSINESS_ACCOUNT_08",'ヘルプをお必要ですか？私達は年中無休、24時間受付対応可能です。');
define("FS_BUSINESS_ACCOUNT_09",'ライブチャット');
define("FS_BUSINESS_ACCOUNT_10",'+81 345888332');
define("FS_BUSINESS_ACCOUNT_11",'jp@fs.com');
define("FS_BUSINESS_ACCOUNT_12",'法人アカウントは申請中でございます。');
define("FS_BUSINESS_ACCOUNT_13",'FSに参加することを大歓迎致します。ご提出頂いた法人アカウントのリクエストを受け取りましたので、ご専属なアカウントマネージャーはできるだけ早く法人アカウントとしてアカウントを審査致します。');
define("FS_BUSINESS_ACCOUNT_14",'ご提出頂いた法人アカウントのリクエストを受け取りましたが、確認と審査まで少々お待ちください。');
define("FS_BUSINESS_ACCOUNT_15",'アカウントセンターに入るにはここをクリックしてください。');
define("FS_BUSINESS_ACCOUNT_16",'法人アカウントの申請は審査中でございます。');
define("FS_BUSINESS_ACCOUNT_17",'アカウントを持っていませんか？ <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">法人アカウントを登録しましょう</a>');
define("FS_BUSINESS_ACCOUNT_18",'法人アカウントを作成する');
define("FS_BUSINESS_ACCOUNT_19",'アカウントをアップグレード');
define("FS_BUSINESS_ACCOUNT_20",'法人アカウントは申請中でございます。');
//add by rebirth  结算页超重超大标签
define('FS_HEAVY','重い');
define('FS_OVERSIZED','特大');
//2019 5 3 定义武汉仓发货的文案优化
define('FS_HEADER_FREE_SHIPPING_CNJP_TIP','への迅速な出荷');
define('FS_FOOTER_FREE_SHIPPING_CNJP_TIP','即日出荷');
define('FS_BANNER_FREE_SHIPPING_CNJP_TIP','へ即日出荷');

//add by jeremy 各语种公司名称
define('FS_LOCAL_COMPANY_NAME','ファイバーストア株式会社');
define('FS_US_COMPANY_NAME','FS.COM Inc.');
define('FS_DE_COMPANY_NAME','FS.COM GmbH');
define('FS_UK_COMPANY_NAME','FIBERSTORE Ltd.');
define('FS_AU_COMPANY_NAME','FS.COM Pty Ltd');
define('FS_SG_COMPANY_NAME','FS Tech Pte Ltd.');
define('FS_RU_COMPANY_NAME','FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');

//amp语言包
//十个专题模块
define('FS_AMP_CATE_01','25G/100G');
define('FS_AMP_CATE_02','40G');
define('FS_AMP_CATE_03','10G');
define('FS_AMP_CATE_04','DAC/AOC');
define('FS_AMP_CATE_05','スイッチ');
define('FS_AMP_CATE_06','WDM<br>MUX');
define('FS_AMP_CATE_07','ファイバ<br>ケーブル');
define('FS_AMP_CATE_08','MTP/MPO<br>ケーブル');
define('FS_AMP_CATE_09','モジュラー<br>ケーブル');
define('FS_AMP_CATE_10','銅<br>ネットワーク');
//Interconnection产品模块
define('FS_AMP_INTERCONNECT_01','相互接続');
//Optical Transport Network产品模块
define('FS_AMP_OPTICAL_TRANS_01','光伝送ネットワーク（OTN）');
//Network Cable Assemblies产品模块
define('FS_AMP_NETWORK_CABLE_01','ネットワークケーブルアセンブリー');
//Space Management产品模块
define('FS_AMP_SPACE_MANAGE_01','スペース管理');
//Solution模块
define('FS_AMP_SOLUTION_01','ソリューション');
//公共底部模块tpl
define('FS_AMP_FOOTER_01','メールサポート');
define('FS_AMP_FOOTER_02','チャットサポート');
define('FS_AMP_FOOTER_03','Live ChaSupport');
define('FS_AMP_FOOTER_04','Company');
define('FS_AMP_FOOTER_05','Quick Access');
define('FS_AMP_FOOTER_06','Copyright © 2009-2019 FS.COM Inc All Rights Reserved.');
define('FS_AMP_FOOTER_07','Privacy policy');
define('FS_AMP_FOOTER_08','Terms of use');
//第一级侧边栏
define('FS_AMP_FIRST_SIDEBAR_01','アカウント / ログイン');
define('FS_AMP_FIRST_SIDEBAR_02','全てのカテゴリ');
define('FS_AMP_FIRST_SIDEBAR_03','ネットワーキング');
define('FS_AMP_FIRST_SIDEBAR_04','光モジュール');
define('FS_AMP_FIRST_SIDEBAR_05','光ケーブル');
define('FS_AMP_FIRST_SIDEBAR_06','ラック & エンクロージャー');
define('FS_AMP_FIRST_SIDEBAR_07','WDM & 光アクセス');
define('FS_AMP_FIRST_SIDEBAR_08','Cat5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_FIRST_SIDEBAR_09','光テスター & ツール');
define('FS_AMP_FIRST_SIDEBAR_10','Support');
define('FS_AMP_FIRST_SIDEBAR_11','Company');
define('FS_AMP_FIRST_SIDEBAR_12','Quick Access');
define('FS_AMP_FIRST_SIDEBAR_13','ヘルプ & 設定');
//所有二级分类侧边栏
define('FS_AMP_SECOND_SIDEBAR_01','メインメニュー');
define('FS_AMP_SECOND_SIDEBAR_02','ネットワーキング');
define('FS_AMP_SECOND_SIDEBAR_03','ネットワークスイッチ');
define('FS_AMP_SECOND_SIDEBAR_04','データセンタースイッチ');
define('FS_AMP_SECOND_SIDEBAR_05','PDU、UPS、電源システム');
define('FS_AMP_SECOND_SIDEBAR_06','ネットワークアダプター');
define('FS_AMP_SECOND_SIDEBAR_07','ルーター & サーバー');
define('FS_AMP_SECOND_SIDEBAR_08','メディアコンバーター、KVM、タップ');
define('FS_AMP_SECOND_SIDEBAR_09','光モジュール');
define('FS_AMP_SECOND_SIDEBAR_10','40G/100Gモジュール');
define('FS_AMP_SECOND_SIDEBAR_11','SFP+モジュール');
define('FS_AMP_SECOND_SIDEBAR_12','SFPモジュール');
define('FS_AMP_SECOND_SIDEBAR_13','ダイレクトアタックケーブル（DAC）');
define('FS_AMP_SECOND_SIDEBAR_14','アクティブオプティカルケーブル（AOC）');
define('FS_AMP_SECOND_SIDEBAR_15','XFPモジュール');
define('FS_AMP_SECOND_SIDEBAR_16','デジタルビデオモジュール');
define('FS_AMP_SECOND_SIDEBAR_17','他のモジュール');
define('FS_AMP_SECOND_SIDEBAR_18','FSボックス');
define('FS_AMP_SECOND_SIDEBAR_19','光ケーブル');
define('FS_AMP_SECOND_SIDEBAR_20','MTPコネクタ付き光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_21','光パッチケーブル');
define('FS_AMP_SECOND_SIDEBAR_22','高耐久性光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_23','MPOコネクタ付き光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_24','超高密度光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_25','事前終端光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_26','ピッグテール光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_27','光ファイバアダプタ & コネクタ');
define('FS_AMP_SECOND_SIDEBAR_28','バルク光ファイバケーブル');
define('FS_AMP_SECOND_SIDEBAR_29','ラック & エンクロージャー');
define('FS_AMP_SECOND_SIDEBAR_30','ラック/キャビネット');
define('FS_AMP_SECOND_SIDEBAR_31','光ファイバエンクロージャー');
define('FS_AMP_SECOND_SIDEBAR_32','光ファイバパッチパネル');
define('FS_AMP_SECOND_SIDEBAR_33','MTPファイバカセット');
define('FS_AMP_SECOND_SIDEBAR_34','MPOファイバカセット');
define('FS_AMP_SECOND_SIDEBAR_35','光ファイバカセット');

define('FS_AMP_SECOND_SIDEBAR_57','MTP-LC ブレイクアウトパネル');
define('FS_AMP_SECOND_SIDEBAR_58','ケーブル管理');
define('FS_AMP_SECOND_SIDEBAR_59','レースウェイシステム');

define('FS_AMP_SECOND_SIDEBAR_36','WDM & 光アクセス');
define('FS_AMP_SECOND_SIDEBAR_37','波長合分波モジュール & OADM');
define('FS_AMP_SECOND_SIDEBAR_38','光パッシブ製品');
define('FS_AMP_SECOND_SIDEBAR_39','光ファイバ終端');
define('FS_AMP_SECOND_SIDEBAR_40','FMT WDM トランスポートプラットフォーム');
define('FS_AMP_SECOND_SIDEBAR_41','FMTインフラモジュール');
define('FS_AMP_SECOND_SIDEBAR_42','光クリーナー & テスター');
define('FS_AMP_SECOND_SIDEBAR_43','Cat5e/Cat 6/Cat 7/Cat 8');
define('FS_AMP_SECOND_SIDEBAR_44','LANパッチケーブル');
define('FS_AMP_SECOND_SIDEBAR_45','事前終端トランクケーブル');
define('FS_AMP_SECOND_SIDEBAR_46','LANバルクケーブル');
define('FS_AMP_SECOND_SIDEBAR_47','パッチパネル＆ウォールプレート');
define('FS_AMP_SECOND_SIDEBAR_48','ケーブル管理');
define('FS_AMP_SECOND_SIDEBAR_49','銅線テスター & ツール');
define('FS_AMP_SECOND_SIDEBAR_50','光テスター & ツール');
define('FS_AMP_SECOND_SIDEBAR_51','光ファイバ清掃用具');
define('FS_AMP_SECOND_SIDEBAR_52','基本光ファイバテスター');
define('FS_AMP_SECOND_SIDEBAR_53','高級光ファイバテスター');
define('FS_AMP_SECOND_SIDEBAR_54','光ファイバ研磨 & 接続');
define('FS_AMP_SECOND_SIDEBAR_55','光ファイバツール');
define('FS_AMP_SECOND_SIDEBAR_56','銅線テスター & ツール');
//三级分类侧边栏
define('FS_AMP_THIRD_SIDEBAR_01','Go back');
//登陆后侧边栏
define('FS_AMP_LOGIN_SIDEBAR_01','My Account');
define('FS_AMP_LOGIN_SIDEBAR_02','Account Setting');
define('FS_AMP_LOGIN_SIDEBAR_03','Order History');
define('FS_AMP_LOGIN_SIDEBAR_04','Address Book');
define('FS_AMP_LOGIN_SIDEBAR_05','My Cases');
define('FS_AMP_LOGIN_SIDEBAR_06','My Quotes');
define('FS_AMP_LOGIN_SIDEBAR_07','Sign out');
//搜索侧边栏
define('FS_AMP_SEARCH_01','ホットサーチ');
//语言选择
define('FS_AMP_SELECT_LANG_01','国/地域の選択');
define('FS_AMP_SELECT_LANG_02','保存する');
//订阅功能语言包(单页面，账户中心)
define('FS_EMAIL_SUBSCRIPTION_01','メールマガジン登録');
define('FS_EMAIL_SUBSCRIPTION_02','メールマガジン登録設定を管理し、FSから最新のニュースを入手しましょう。');
define('FS_EMAIL_SUBSCRIPTION_03','メールマガジン登録');
define('FS_EMAIL_SUBSCRIPTION_04','登録管理用の電子メールをご確認ください。');
define('FS_EMAIL_SUBSCRIPTION_05','FSメールマガジンを登録することによって、最新の優遇ポリシー、在庫情報、テクニカルサポートなどの詳細を把握できます。新製品から、データセンターソリューションまで、FSメールは常に最新情報を提供いたします！');
define('FS_EMAIL_SUBSCRIPTION_06','アカウントと注文に関するメールは重要なので、マーケティングメールの受信を既に中止した場合でも送信いたしますので、ご了承ください。');
define('FS_EMAIL_SUBSCRIPTION_07','ご注意ください：変更が適用されるまでは最大48時間ほどかかります。メールマガジンの受信を既に中止した場合でも、注文、最新の優遇ポリシー、在庫情報、テクニカルサポートについてのメールを送信いたします。');
define('FS_EMAIL_SUBSCRIPTION_08','どのくらいの頻度でプロモーションを受けたいですか？');
define('FS_EMAIL_SUBSCRIPTION_09','定期的');
define('FS_EMAIL_SUBSCRIPTION_10','週に1回以下');
define('FS_EMAIL_SUBSCRIPTION_11','月に1回以下');
define('FS_EMAIL_SUBSCRIPTION_12','登録解除');
define('FS_EMAIL_SUBSCRIPTION_13','保存する');
define('FS_EMAIL_SUBSCRIPTION_14','取り消す');
define('FS_EMAIL_SUBSCRIPTION_15','ご提出したリクエストは正常に送信されました。');
define('FS_EMAIL_SUBSCRIPTION_16','24時間以内に早速にご返信いたします。');
define('FS_EMAIL_SUBSCRIPTION_17','自身のメールアドレスをご入力ください。');
define('FS_EMAIL_SUBSCRIPTION_18','購読を表示、変更、またはキャンセルします。');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span>購読を解除しました。');
define('FS_EMAIL_SUBSCRIPTION_20','FSのプロモーションメールはもう届きません。');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>購読しました。');
define('FS_EMAIL_SUBSCRIPTION_22','FSメールを購読していただきありがとうございました。');
define('FS_EMAIL_SUBSCRIPTION_23','ご注文、御見積もりおよびFSの最新進展などの情報をメールにお届けします。');
define('FS_EMAIL_SUBSCRIPTION_24','今後FSのレビューリクエストメールは送信されません。');
define('FS_EMAIL_SUBSCRIPTION_25','今後FSのプロモーションとレビューリクエストメールは送信されません。');
//底部订阅语言包
define('FS_EMAIL_SUBSCRIPTION_FOOTER_01','メールマガジン登録（無料）');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02','FSからの最新ニュースを入手しましょう。');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03','メールアドレス');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04','メールアドレスを入力してください。');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05','有効なメールアドレスをご入力ください。');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06','ご購読を頂きましてありがとうございました！');
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','モバイルアプリ');
//2019.5.27 新政策弹窗 pico
define('FS_SHIPPING_RETURNS','<a class="info_returns" href="javascript:;">'.FS_DELIVERY_RETURN.'</a>');
define('FS_SHIPPING_WARRANTY','<a class="info_warranty" href="javascript:;">保証</a>');
define('FS_SHIPPING_SUPPORT','<a class="" href="'.reset_url('product_support.html?products_id=###').'" target="_blank">テクニカルサポート</a>');
define('FS_SHIPPING_RETURNS_TITLE','30日間の返品');
define('FS_SHIPPING_RETURNS_PART',"FSは安心のショッピング体験を保証するために商品到着から30日以内の返品 & 交換サービスを提供しております。それが返品または交換を引き起こすことが当社の理由であるならば、当社は発生する送料と税金のすべてに対して責任を負います。さまざまな製品の返品詳細については、どうぞ<a href ='".zen_href_link('index')."policies/day_return_policy.html' target='_blank'>返品規則</a>をご覧ください。");
define('FS_SHIPPING_WARRANTY_TITLE','製品の全範囲に対する保証');
define('FS_SHIPPING_WARRANTY_PART',"製品に問題がある場合、返品時間を過ぎても心配しないでください。製品が保証期間内である限り、無料のメンテナンスサービスを受けることができます。<a href ='".zen_href_link('index')."policies/warranty.html' target='_blank'>保証ポリシー</a>で製品の特定の保証期間をご覧下さい。");
define('FS_SHIPPING_SUPPORT_TITLE','無料の技術サポート');
define('FS_SHIPPING_SUPPORT_PART',"FSは、お客様の信頼できるパートナーになることを約束し、デジタルインフラストラクチャ製品の全般的なポートフォリオと包括的なワンストップデジタルソリューションをご提供いたします。");
define('FS_SHIPPING_SUPPORT_PART_BR',"<a href='".reset_url('solution_support.html')."' target='_blank'>ソリューションのサポート</a>にアクセスし製品に関する質問や無料の接続ソリューションの設計について、タイムリーなヘルプを受けることができます。");

//add by ternence 询价产品弹窗
define('FS_PRODUCT_INQUIRY_3','ご提出したお見積書は受領されましたので、後でフィードバックさせていただきます。');
define('FS_PRODUCT_INQUIRY_1','24時間以内にご返信致します。');
define('FS_PRODUCT_INQUIRY_2','下のボタンをクリックすると、当社の<a href="javascript:;" class="">プライバシーとクッキーに関するポリシー</a>と<a href="javascript:;">利用規約</a>に同意したことになります。');

//add by ternence 结算页面地址提示
define('FS_SALES_INFO_MODAL_ZIP_CODE','郵便番号*');
//退换货指引入口
define('FS_RETURN_BUTTON','返品');

//登陆超时
define('LOING_TIMEOUT','セキュリティ確保のために、セッションの期限が切れました。もう一度ログインしてください。');

//产品详情AOC
define('PRODUCT_AOC','ケーブルの長さは、ごニーズに応じて1mから300m（3ftから984.252ft）までカスタマイズできます。');
define('PRODUCT_AOC_1','ケーブルの長さは、ごニーズに応じて1mから30m（3ftから98.43ft）までカスタマイズできます。');
//报价列表
define('QUOTE_EMPTY_1','御見積もり依頼はまだありません。');
define('QUOTE_EMPTY_2','買い物を始める');
define('QUOTE_EMPTY_3','御見積もり依頼は見つかりませんでした。');

define("ATTRIBUTE_MESSAGE",'Cisco製スイッチと完全な互換性があり、互換性マトリックスに関しては <a target="_blank" href="https://tmgmatrix.cisco.com"> ここをクリック</a>してください。');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','ログイン');
define('FILENAME_HOME_CART','カート');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','<a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">保存したカート</a>で製品を探し、またはお買い物を続けましょう。');
//报价添加打印
define('INQUIRY_GET_A_QUOTE','購入ヘルプをご必要ですか？');
define('INQUIRY_GET_A_QUOTE_1',"当社は常に最高品質の製品、大量注文で優遇な価格、ご注文が受領されたら迅速な処理手順を提供する様に専念しております。何かお手伝いできる事がございましたら、どうぞ ");
define('INQUIRY_GET_A_QUOTE_2',' にお電話いただくか、<a href="mailto: jp@fs.com"><i class="email_icon"></i>jp@fs.com</a> に電子メールでご送信頂いてください。');
define('INQUIRY_GET_A_QUOTE_3','見積りを印刷');
define('INQUIRY_GET_A_QUOTE_4','見積詳細');
define('INQUIRY_GET_A_QUOTE_5','数量(pcs)');
define('INQUIRY_GET_A_QUOTE_6','見積もり価格');

//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', '顧客アカウント');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', '提供可能、在庫納入必要');
define('QV_SHOW_AVAILABLE_02', '提供可能、在庫納入中');

//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','在庫数量不足');
define('FS_CLEARANCE_TIPS_CONTENT','ご指定の数量が使用可能な在庫量<span class="clearance_total_qty">$QTY</span>を超えております。数量の追加については、ご専属のアカウントマネージャーにお問い合わせください。');
define('QV_CLEARANCE_TIPS','ご指定の数量が使用可能な在庫量<span class="clearance_total_qty">$QTY</span>を超えております。');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','この製品は一時的に在庫切れになってしまいましたので、詳しい状況についてはご専属のアカウントマネージャーにお問い合わせください。');

//文章分类
define('CASE_STUDIES_01','地域');
define('CASE_STUDIES_02','北アメリカ');
define('CASE_STUDIES_03','ラテンアメリカ');
define('CASE_STUDIES_04','ヨーロッパ');
define('CASE_STUDIES_05','オセアニア');
define('CASE_STUDIES_06','アフリカ');
define('CASE_STUDIES_07','中東');
define('CASE_STUDIES_08','アジア');
define('CASE_STUDIES_09','ケースタイプ');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','企業ネットワーク');
define('CASE_STUDIES_12','データセンターのケーブル接続');
define('CASE_STUDIES_13','業種');
define('CASE_STUDIES_14','金融業');
define('CASE_STUDIES_15','教育業');
define('CASE_STUDIES_16','医療');
define('CASE_STUDIES_17','ISP');
define('CASE_STUDIES_18','製造業');
define('CASE_STUDIES_19','運輸業');
define('CASE_STUDIES_20','小売業');
define('CASE_CLEAR_ALL','全て取り消す');
define("FS_PRODUCTS","件の結果");
define("FS_PRODUCT","件の結果");
define('CASE_CATEGORY_MENU_CASE_STUDIES','ケーススタディ');
define('FS_TEST_TOOL','テストツール');
define('FS_ADDRESS_PO','PO');


// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','<a href="jp/c/fhd-rack-mount-45" style="color: #0070BC;">FHDラックマウント型ファイバエンクロージャー</a> と <a href="jp/c/fhd-wall-mount-3358" style="color: #0070BC;">FHDウォールマウント型ファイバーエンクロージャー</a>に収まる');
define('FS_PRODUCT_INSTALLATION_TEXT_2','19インチラックにマウント可能な<a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>ファイバエンクロージャーに収まる');
define('FS_PRODUCT_INSTALLATION_TEXT_3','19インチラックにマウント可能な<a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a>ファイバエンクロージャーに収まる');
define('FS_PRODUCT_INSTALLATION_TEXT_4','19インチラックにマウント可能な<a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a>ファイバエンクロージャーに収まる');
define('FS_ADDRESS_PO','PO');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','<a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800シリーズ</a>あるいは<a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;">HR800シリーズ</a>ネットワーク&サーバーキャビネットに適合する');
define('FS_PRODUCT_INSTALLATION_TEXT_6','<a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600シリーズ</a>あるいは<a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;">HR600シリーズ</a>サーバーキャビネットに適合する');
define('FS_PRODUCT_INSTALLATION_TEXT_7','<a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800シリーズ</a>あるいは<a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600シリーズ</a>キャビネットに適合する');
define('FS_PRODUCT_INSTALLATION_TEXT_8','<a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800シリーズ</a>ネットワーク & サーバーキャビネットに適合する');
define('FS_PRODUCT_INSTALLATION_TEXT_9','FMX 100Gモジュールはラックに取り付け可能な<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U</a>シャーシに適しております。');

// add by pico
define('CHECKOUT_ERROR_01', 'お支払い方法をご選択ください。');
define('CHECKOUT_ERROR_02', 'カード会員名が必要です。');
define('CHECKOUT_ERROR_03', 'カード番号が必要です。');
define('CHECKOUT_ERROR_04', 'セキュリティコードが必要です。');
define("GLOBAL_GC_TEXT13","カード番号");
define("GLOBAL_GC_TEXT14","有効期限");
define("GLOBAL_GC_TEXT17","セキュリティコード");

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'ソリューションを探す');
define('FS_BEST_SELLERS', '人気な製品');
define('FS_CASE_STUDIES', 'ケーススタディ');


//add ternence
define('INQUIRY_TITLE','見積り依頼リストをメールで送る');
define('INQUIRY_TITLE_1','共有した見積りリスト');
define('INQUIRY_TITLE_2','メールが正常に送信された');
define('INQUIRY_TITLE_3','見積り依頼が成功に受取人リストに送られました。');
define('INQUIRY_TITLE_4','見積りリストに戻る');
define('INQUIRY_TITLE_5','メールが正常に送信された');
define('INQUIRY_TITLE_6','お友達から見積りリストを共有されたことがありますので、簡単にアクセス可能です。それでもお手助けが必要な場合は、');
define('INQUIRY_TITLE_7','見積りにリストを追加');
define('INQUIRY_TITLE_8','いつでもこのページに表示されているものを見積もりに追加することができます。');
define('INQUIRY_TITLE_9','見積りリストをシェア');
define('INQUIRY_TITLE_10','見積りリスト');
define('INQUIRY_TITLE_11',' は見積り依頼リストを共有されました。下のボタンをクリックして詳細をチェックできる上で、この内容を自分の見積りリストに追加することができます。');
define('INQUIRY_TITLE_12','から見積もりリストを共有された');
define('INQUIRY_TITLE_13','見積り依頼に追加');
define("FS_INQUIRY_INFO_67",'まだ見積り依頼はありませんでした。もし既にアカウントをお持ちの場合は、<a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">ログイン</a>して見積もり書をチェックしてください。');
define("FS_INQUIRY_INFO_68",'メール');
define("FS_INQUIRY_INFO_69",'数量');

//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','納税者番号（任意）');
define('CHECKOUT_TAX_2','有効な納税者番号「Tax」をお持ちの場合は、付加価値税「VAT」を免除することができます。');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"何かお困りですか。");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"カスタマーサポートをご利用ください。");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','以下のアイテムは贈り物であり、チェックアウトの時合計金額には含まれません。');
define('FS_GIFT_TITLE_ARE','以下のアイテムは贈り物であり、チェックアウトの時合計金額には含まれません。');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">贈り物</div></div>');
define('FS_GIFT_CHECK_TITLE','現在の配送先では贈り物は提供されません。ご必要に応じて、製品ページでテストツールを選択してください。');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">贈り物</div></div>');


// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY','FSの<a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank">情報セキュリティポリシー</a>と<a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">利用規約</a>に同意します。');
define('FS_COMMON_PRIVACY_POLICY_ERROR','FSの情報セキュリティポリシーと利用規約に同意したことをご確認頂くようお願い致します。');

define('NEW_PRODUCTS_TAG','新製品');

define('HOT_PRODUCTS_TAG','人気製品');

define("INVALID_CVV_ERROR",'パスワードが間違っています。 もう一度お試しください。');

define('FS_ACCOUNT_CODING_REQUESTS','コーディングリクエスト');
define('FS_ACCOUNT_MY_CODING_REQUESTS','マイコーディングリクエスト');
define('FS_ACCOUNT_CODING_REQUEST_BTN','コーディングをリクエスト');
define('CODING_REQUESTS_LIST','コーディングリクエスト一覧');
define('CODING_REQUESTS_CODING_DETAILS','コーディングリクエストの詳細');

// 2019-7-19 potato 地址编辑提示修改
define("FS_POST_CODE_TITLE_ERROR","郵便番号をご入力ください。");
define("FS_CITY_TITLE_ERROR","町名が必要です。");
define("FS_CHECKOUT_ERROR28_AU","有効な郵便番号を入力してください。");
define("ACCOUNT_EDIT_CITY_AU","町名");
define("ACCOUNT_EDIT_STATE_AU","州名");
define("FS_ZIP_CODE_AU_NEW","郵便番号");


// add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'もっと見る');
define('FS_COMMON_SEE_MORE', 'もっと見る');
define('FS_COMMON_SEE_LESS', 'ページを減らす');
//模块标签属性
define('FS_PLACEHOLDER_EG','例:');
define('FS_OPTIONAL',' (任意)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','付加価値税');
define('FS_CHECK_OUT_INCLUDEING_RU','(付加価値税込み)');
define('FS_CHECK_OUT_EXCLUDING_RU','(付加価値税抜き)');


//2019-9-7 Jeremy 购物车改版
define("FS_CART_ITEM_TOTAL","合計金額");
define("FS_CART_ATTR_BTN","属性を選択");
define("FS_CART_ATTR_CONTENT","これはカスタム製品です。まず属性をお選びください。");

// 表单提交次数频繁
define('FS_SUBMIT_TOO_OFTEN','操作が頻繁に行われています。後でもう一度やり直してください。');
define('FS_ROBOT_VERIFY_PROMOPT','プロンプトに従って確認の手続きをご完成ください。');

//2019-09-17 liang.zhu
define("CHECKOUT_TAXE_SG_TIT", "消費税 （GST）と関税について");
define("CHECKOUT_TAXE_SG_FRONT", "シンガポールの倉庫から発送され、シンガポール国内の場所に配送された注文については、FSは、製品価格と送料に7％の率で消費税（GST）をご請求致します。<br/><br/> もしご注文の製品が一時在庫切れになり、アジア倉庫（中国）から直接出荷する場合は、消費税（GST）を課さないことになります。ただし、これらのパッケージは輸入関税または関税を課される場合があるかもしれません。通関のための関税または輸入関税を、お客様にご負担していただきます。");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "関税と諸税金について");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "シンガポール以外の目的地に配送された注文については、製品の価格と送料のみをご請求致します。消費税（VATまたはGSTなど）は請求されません。ただし、それらのパッケージは、特定の国の法律/規制に応じて、輸入関税または関税を課される場合があるかもしれません。通関のための関税または輸入関税を、お客様にご負担していただきます。");

//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','これらすべてのアクセサリーも同梱してご返送ください。');
//2019-09-17 add by liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', '北アメリカ');
//澳洲
define('FS_STATE_OCEANIA', 'オセアニア');
//亚洲
define('FS_STATE_ASIA', ' アジア');
//欧洲
define('FS_STATE_EUROPE', 'ヨーロッパ');
define('FS_PORTFOLIOS','ポートフォリオ');
define('FS_ORDER_LINK_REMARK','備考');
define('FS_VIEW_INVOICE_BUBBLE','アカウントマネージャーに連絡して、この注文の最新の請求書をご入手ください。');
define('FS_VIEW_INVOICE_PRE_BUBBLE','アカウントマネージャーに連絡して、この注文の最新の領収書をご入手ください。');
define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00am - 5:00pm ");
define("FS_SHIPPING_SG_GRAB_TIPS","このサービスは、シンガポール倉庫から発送され、営業日の午後3時前に支払われる単一のパッケージで利用できます。");
define("FS_TIME_ZONE_ADDRESS_SG","<span>FSシンガポール倉庫:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

define('FS_SG_VAT_NUMBER',"GST登録番号");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','御見積りをメールで送信');
define("FS_INQUIRY_REVIEWING_1",'提出済み');
define("FS_INQUIRY_QUOTED_1",'承認済み');
define('FS_QUOTE_INFO_1','お見積依頼詳細');
define("FS_INQUIRY_CANCELED_1",'期限切れ');
define('FS_QUOTE_INFO_2','単価');
define('FS_QUOTE_INFO_3','目標価格');
define('FS_QUOTE_INFO_4','御見積り価格');
define('FS_QUOTE_INFO_5','(この価格には税金と送料は含まれていません。)');
define('FS_QUOTE_INFO_6','すべて');
define('FS_QUOTE_INFO_8','まずは製品をお選びください。');
define('FS_QUOTE_INFO_9','ありがとうございました。メールでお見積りを受信者に送信しました。');
define('FS_QUOTE_INFO_10','御見積り詳細に戻る');
define('FS_QUOTE_INFO_11','再見積依頼');
define('FS_QUOTE_INFO_12','クイック見積り');
define('FS_QUOTE_INFO_13','御見積り一覧 (');
define('FS_QUOTE_INFO_14',' 製品');
define('FS_QUOTE_INFO_15','目標価格:');
define('FS_QUOTE_INFO_16','この価格には税金と送料は含まれていません。');
define('FS_QUOTE_INFO_17','この見積もりには、製品リスト全体に基づいて割引が提供されています。一部の製品だけでチェックアウトすると、割引が無効になります。');
define('FS_QUOTE_INFO_18','この見積もりには、各製品の数量に基づいてさまざまな割引が提供されています。チェックアウトする時、製品の数量を減らすと、選択した製品の割引が無効になります。');
define('FS_SEND_EMAIL_2019_1',"御見積依頼を受け取りました。");
define('FS_SEND_EMAIL_2019_2',",アカウントマネージャーが30分以内にお見積もりをお送りいたしますので、後で");
define('FS_SEND_EMAIL_2019_3',"「マイ見積り」");
define('FS_SEND_EMAIL_2019_4',"でチェックしてください。");
define('FS_SEND_EMAIL_2019_5',"お客様");
define('FS_SEND_EMAIL_2019_6',"お見積り依頼");
define('FS_SEND_EMAIL_2019_7',"製品");
define('FS_SEND_EMAIL_2019_8',"数量: ");
define('FS_SEND_EMAIL_2019_9',"製品");
define('FS_SEND_EMAIL_2019_10',"数量");
define('FS_SEND_EMAIL_2019_11',"目標価格");
define('FS_SEND_EMAIL_2019_12',"単価");
define('FS_SEND_EMAIL_2019_13',"小計:");
define('FS_SEND_EMAIL_2019_14',"合計目標価格:");
define('FS_SEND_EMAIL_2019_15',"御見積もりへ");
define('FS_QUOTE_INFO_19','見積り提出日');
define("FS_INQUIRY_INFO_65_1","この見積りの有効期限は15日間のみで、XXで有効期限が切れます。");
define("FS_INQUIRY_INFO_65_2","XXで期限切れになる");
define("FS_INQUIRY_INFO_65_3","合計:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','以内にお支払いをご完了ください。');
define('FS_ORDERS_OVERTIMES_02','');
define('FS_ORDERS_OVERTIMES_03','');
define('FS_ORDERS_OVERTIMES_02_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04','お支払い時間を過ぎると、製品の在庫変更により注文は自動的にキャンセルされます。');
define('FS_ORDERS_OVERTIMES_05','以内にPOファイルを添付してください。');
define('FS_ORDERS_OVERTIMES_06','注：送金手続きを行う時にFS注文番号を付記すると、注文がタイムリーに処理されます。通常、資金は1-3営業日以内に受領されます。');
define('FS_ORDERS_OVERTIMES_07','次の理由により、ご注文を再確認する必要があります:');
define('FS_ORDERS_OVERTIMES_08','配送先がクレジット申請書のアドレスとは一致しません');
define('FS_ORDERS_OVERTIMES_09','利用可能なクレジット限度額がオーバーしてしまいます');
define('FS_ORDERS_OVERTIMES_10','以前の注文を支払ってクレジットの利用可能額を回復し、または「マイクレジット」に移動してクレジットのご利用枠の引き上げをご申請ください。ご請求を確認し、その結果をメールでご送信いたします。');
define('FS_ORDERS_OVERTIMES_11','12時間以内にご請求を確認し、その結果をメールでお知らせします。');
define('FS_ORDERS_OVERTIMES_12','この注文が迅速に処理されるには、以前の注文を支払ってクレジットの利用可能額を回復し、または「マイクレジット」に移動してクレジットのご利用枠の引き上げをご申請ください。');
define('FS_ORDERS_OVERTIMES_13','で終了');
define('FS_ORDERS_OVERTIMES_14','日'); //天  这三个是英文的 day  hour minute 首字母缩写
define('FS_ORDERS_OVERTIMES_15','時間'); //时
define('FS_ORDERS_OVERTIMES_16','分間'); //分
define('FS_ORDERS_OVERTIMES_17','お支払い期限を過ぎたため、ご注文はクローズされました。');
define('FS_ORDERS_OVERTIMES_18','「注文履歴」に移動して、「再注文」をクリックしてもう一度注文することができます。');
define('FS_ORDERS_OVERTIMES_19','ご注文に問題が発生しました。');
define('FS_ORDERS_OVERTIMES_20','からの送金を受け取りました！');
define('FS_ORDERS_OVERTIMES_21','お支払いの期限（FSの注文履歴に表示される）を過ぎたため、ご注文はクローズされました。お手数ですが、ご専属の営業担当者に連絡してご注文をご復元ください。ご不便をおかけしまして申し訳ございません。');
define('FS_ORDERS_OVERTIMES_22','掛売口座に期限切れの請求書があるので、その注文をご完済ください。そうでない場合、今回の注文の審査のために弊社のアカウントマネージャーからご連絡し、追加のドキュメントを要求することになります。');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','FSお支払いリマインダ - ご注文保留中');
define('FS_ORDERS_OVERTIMES_23','お支払いリマインダ');
define('FS_ORDERS_OVERTIMES_24','ご注文ありがとうございました。未払いの注文<b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">ご注意ください</b>:既にお支払いが完了した場合、またはこの注文が必要でない場合は、このメールを無視してください。ご完了の注文は早速に処理されます。未払いの状態では、この注文は後でシステムによって自動的にキャンセルされます。');
define('FS_ORDERS_OVERTIMES_26','どうぞ宜しくお願い致します。');
define('FS_ORDERS_OVERTIMES_27','</b>があり、');
define('FS_ORDERS_OVERTIMES_28','後に自動的にキャンセルされますので、<a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">ここをクリックして</a>お支払いをご完了ください。完了した後、ご注文は早速に処理されます。');


//by rebirth 2019.10.18 新版上传提示 日语
define("FS_UPLOAD_NEW_NOTICE_ONE","許可されているファイルタイプはPDF、JPG、PNG、DOC、DOCX、XLS、XLSX、TXTです。");
define("FS_UPLOAD_NEW_NOTICE_TWO","JPG、GIF、PNG、JPEG、BMPファイルをサポートします。");
define("FS_UPLOAD_NEW_NOTICE_THREE","最大サイズ5Mです。");
define("FS_UPLOAD_NEW_NOTICE_FOUR","最大ファイルサイズは300KBです。");
define("FS_UPLOAD_NEW_ERROR_1","アップロードされたファイルは許可されません！"); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","ファイルは既に存在します！");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","クラウドサーバーへのファイルのアップロードに失敗しました。"); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'アップロードされたファイルは、php.iniのupload_max_filesizeディレクティブを超えています。');//文件大小超过php.ini的限制

define('FS_SHOP_CART_SG_INSTALL','シンガポール倉庫の製品の無料インストールが可能になります。お支払いをしてからその詳細をご覧ください。');

define('FS_CHECKOUT_SGINSTALL_CC','インストールサービスをご選択になりました。予定されているインストール時間までに支払いをご完了ください。完了しないと、サービスが遅れる場合があります。');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','在庫のあるすべての製品を対象に無料のインストールサービスはご利用いただけます。チェックアウトページでサービスを選択できます。');
define('FS_SG_DELIVERY_RETURN','無料インストール');

define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','インストールサービスをご選択になりました。ご注文の発送準備ができたら、当社の技術専門家がお客様のご指定の場所に向かう前にご連絡いたします。');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','インストールサービスをご選択になりました。予定されているインストール時間までにお支払いをご完了ください。完了しないと、サービスが遅れる場合があります。');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','インストールサービスをご選択になりました。予定されているインストール時間の前にPOファイルをアップロードしてください。アップロードしないと、サービスが遅れる場合があります。');

define('FS_SG_CALENDAR_1',"インストール時間帯をご選択ください。");
define('FS_SG_CALENDAR_2',"利用可能なインストール時間をご選択");
define('FS_SG_CALENDAR_3',"FS配送＆インストールをご選択ください。");
define('FS_SG_CALENDAR_4',"ご希望のインストール時間をご選択ください。");
define("FS_SG_CALENDAR_5","オンサイトインストール");
define("FS_SG_CALENDAR_6",'配送変更');
define("FS_SG_CALENDAR_7","すべてのインストールリクエストをキャンセルします。配送を準備いたします。");
define("FS_SG_CALENDAR_8","キャンセル");
define("FS_SG_CALENDAR_9","はい");
define("FS_SG_CALENDAR_10",'選択された製品のみが配送後にインストールされます。');
define("FS_SG_CALENDAR_11",'*現在のところ、シンガポール倉庫から出荷されたアイテムだけインストールサービスをご利用いただけます。ご不便をおかけして申し訳ございません。');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","インストールをリクエスト");
define("FS_SG_CALENDAR_101","サービスの種類をご選択");
define("FS_SG_CALENDAR_102","ご選択ください");
define("FS_SG_CALENDAR_103","プロジェクトサポート");
define("FS_SG_CALENDAR_104","トラブル対応と修理");
define("FS_SG_CALENDAR_105","サービスの種類をご選択ください。");
define("FS_SG_CALENDAR_106","リクエストの詳細をご説明ください*");
define("FS_SG_CALENDAR_107","リクエストについてご説明ください。");
define("FS_SG_CALENDAR_108","少なくとも4文字をご入力ください。");
define("FS_SG_CALENDAR_109","最大500文字までご入力ください。");
define("FS_SG_CALENDAR_110","インストールリクエスト");
define("FS_SG_CALENDAR_111","サービスの種類");
define("FS_SG_CALENDAR_112","予約時間");
define("FS_SG_CALENDAR_113","リクエスト詳細");
define("FS_SG_CALENDAR_114","予約時間");
define("FS_SG_CALENDAR_115","インストールリクエストは既に受領されました。");
define("FS_SG_CALENDAR_116","当社の技術専門家がご指定のアドレスに向かう前にご連絡いたします。");

define('FS_FESTIVAL16','シンガポールの祝日');
define('FS_FESTIVAL17', 'シンガポール倉庫で');

//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","FSシンガポールをお選びいただきありがとうございます。ご注文");
define("FS_SG_EMAIL_1","ご注文の無料インストールがスケジュールされる時、再度ご連絡いたします。");
define("FS_SG_EMAIL_2","一部の製品は無料でインストールできます。もし必要であれば<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">インストールリクエスト</a>サービスをご利用いただけます。お支払いを完了すると、再度ご連絡いたします。");
define("FS_SG_EMAIL_3","ご注文");
define("FS_SG_EMAIL_4","にインストールサービスをご選択になりました。 当社の技術専門家がご指定のアドレスに向かう前にご連絡いたします。");
define("FS_SG_EMAIL_5","アカウントにログインして");
define("FS_SG_EMAIL_6","ご注文の詳細");
define("FS_SG_EMAIL_7","は次の通りです。ご注文の状態が更新され次第、メールでお知らせします。");
define("FS_SG_EMAIL_8","アカウントにログインして");
define("FS_SG_EMAIL_9"," ご注文には無料のインストールをご利用いただけますので、詳細について<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">ここ</a>をご覧ください。");
define("FS_SG_EMAIL_10","ご注文");
define("FS_SG_EMAIL_11","のインストール準備が整い、当社の技術専門家ができるだけ早くご指定のアドレスにお向かいします。");
define("FS_SG_EMAIL_12","何か変更がある場合は、事前に<a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a>までお電話ください。または<a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>までご連絡ください。");
define("FS_SG_EMAIL_13","どうぞよろしくお願い致します。");
define("FS_SG_EMAIL_14","FSチーム");
define("FS_SG_EMAIL_15","連絡先情報：");
define("FS_SG_EMAIL_16","TEL：");
define("FS_SG_EMAIL_17","アドレス：");
define("FS_SG_EMAIL_18","予約時間：");
define("FS_SG_EMAIL_19","FS注文");
define("FS_SG_EMAIL_20"," - インストールリマインダー");
define("FS_SG_EMAIL_21","FSシンガポールをお選びいただきありがとうございます。オンサイトのインストールサービスをお選びいただいた未払いの注文");
define("FS_SG_EMAIL_22","があり、そのサービスがキャンセルされたことをお知らせします。");
define("FS_SG_EMAIL_23","<a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">ここをクリックして</a>購入を完了すると、「マイアカウント」でインストールサービスためのご都合の良い時間をもう一度選択できます。");
define("FS_SG_EMAIL_24","ご注文#");
define("FS_SG_EMAIL_25"," が出荷されました。");
define("FS_SG_EMAIL_26","インストールリマインダー");
define("FS_SG_EMAIL_27","インストールがキャンセルされました");
define("FS_SG_EMAIL_28","お支払いリマインダー");
define('FS_SHIPPING_SG_INSTALL_TIPS','この配達では、ご希望のインストール時間を選択できます。インストールサービスは、FS Delivery＆Free Installationでのみご利用いただけます。');

define('FS_ACCOUNT_DETELE','現在のアカウントは既に削除されました。');
define('FS_SG_DELIVERY_INSTALLATION', 'FS Delivery & Free Installation');
define('FS_SG_NEXT_WORKING_DAY', 'FS Next Working Day Delivery');
define('FS_SG_SAME_WORKING_DAY', 'FS Same Working Day Delivery');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 Working Days');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','分');
define('FS_ORDERS_OVERTIMES_31','営業日');
define('FS_ORDERS_OVERTIMES_32','');
define('FS_ORDERS_OVERTIMES_33','');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'サービスの種類');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', '製品使い方サポート');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'リンク接続サポート');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'インストール & 構成サポート');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'その他');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","お買い物体験を共有しよう");
define("EMAIL_MESSAGE_01","我々が改善すべきこと");
define("EMAIL_MESSAGE_02","レビューを書く");
define('EMAIL_MESSAGE_CONTENT', 'お客様がいい体験のできることを望んでおり、ご意見もお伺いしたいと存じます。貴重なお時間を割いて、最近ご購入の製品<a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>にレビューを書いて頂けますでしょうか。お手数をお掛け致しますが、下のボタンをクリックしてレビューをお書き留めて頂けますと嬉しいです！');
define('EMAIL_MESSAGE_SUBTITLE', 'ご注文について質問があるのですか？');
define('EMAIL_MESSAGE_SUB_CONTENT', 'テクニカルサポート、保証、配送に関する質問がございましたら、喜んでお手伝いするため遠慮なくどうぞお申し付けてください。そして、この<a style="color: #0070bc;text-decoration: none;" href="javascript:;">ヘルプセンター</a>ページにアクセスして迅速かつ役立つなサポートも取得することはできます。');
define('EMAIL_TO_LICENSE_5','もっと見る');
define('EMAIL_TO_LICENSE_6','FSで評価する新しいアイテムがあります。');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'ご好評ご協力を頂きまして有難うございました！');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Trustpilotのご利用についてフィードバックをお寄せいただき、誠にありがとうございます。FSを評価するために時間を少しお掛けていただけば助かります。');
define('EMAIL_REVIEWS_FOUR_FIVE_03', '貴方の評価');
define('EMAIL_REVIEWS_FOUR_FIVE_04', '貴方の評価（良いか悪いかに関わらず）は、他の人々がより多くの情報に基づいた決定を行うのを助けるためにTrustpilot.comにすぐに投稿されます。');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'お時間を頂き誠に有難うございました。またお互いに連携を達成できることを楽しみにしています！今後ともどうか宜しくお願い申し上げます。<br>FSチーム');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'FSを評価してください');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'お買い物体験をご共有頂き誠に有難うございます。');


//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','テクニカルサポート');
define('FS_REQUEST_SUPPORT','サポートリクエスト');

//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Technical Support');
define('FS_REQUEST_SUPPORT','Request Support');


//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'お見積ステータス');
define("FS_INQUIRY_LIST_2",'有効なお見積');
define("FS_INQUIRY_LIST_3",'カスタマーサービスのお問合せ');
define("FS_INQUIRY_LIST_4",'見積を検索：');
define("FS_INQUIRY_LIST_5",'見積番号');
define("FS_INQUIRY_LIST_6",'検索');
define("FS_INQUIRY_LIST_7",'お見積もり依頼日:');
define("FS_INQUIRY_LIST_8",'小計');
define("FS_INQUIRY_LIST_9",'数量');
define("FS_INQUIRY_LIST_10",'もっと見る');
define("FS_INQUIRY_LIST_11",'該当お見積はXXまで有効です。');
define("FS_INQUIRY_LIST_12",'該当お見積はXXに期限切れになりました。');
define("FS_INQUIRY_LIST_13",'お見積が見つかりません。');
define("FS_INQUIRY_LIST_14",'買い物を始める');
define("FS_INQUIRY_LIST_15",'お見積が見つからない場合は、他の検索条件でお試し下さい。');
define("FS_INQUIRY_LIST_16",'お見積依頼詳細');
define("FS_INQUIRY_LIST_17",'見積り名：');
define("FS_INQUIRY_LIST_18",'再見積依頼');
define("FS_INQUIRY_LIST_19",'カートに入れる');
define("FS_INQUIRY_LIST_20",'このページを印刷');
define("FS_INQUIRY_LIST_21",'お見積依頼');
define("FS_INQUIRY_LIST_22",'対象製品');
define("FS_INQUIRY_LIST_23",'製品価格');
define("FS_INQUIRY_LIST_24",'数量');
define("FS_INQUIRY_LIST_25",'見積価格');
define("FS_INQUIRY_LIST_26",'お客様ID：');
define("FS_INQUIRY_LIST_28",'TEL:');
define("FS_INQUIRY_LIST_29",'合計：');
define("FS_INQUIRY_LIST_30",'以下はご提出されたお見積です。ご専任のアカウントマネージャーは24時間以内にご連絡致します。');
define("FS_INQUIRY_LIST_30_1",'該当お見積は審査中ですので、ご専任のアカウントマネージャーは24時間以内にご連絡致します。');
define("FS_INQUIRY_LIST_31",'ご専任のアカウントマネージャーが該当お見積を確認しましたので、24時間以内にご連絡致します。');
define("FS_INQUIRY_LIST_32",'以下はお見積詳細です。該当お見積はXXまで有効です。');
define("FS_INQUIRY_LIST_33",'該当お見積は');
define("FS_INQUIRY_LIST_34",'に期限切れになりましたので、ご入用の際はもう一度お申し込みできます。');

define("FS_INQUIRY_LIST_35",'見積番号');
define("FS_INQUIRY_LIST_36",'見積もりの発行日:');
define("FS_INQUIRY_LIST_37",'見積番号:');
define("FS_INQUIRY_LIST_38",'製品:#');
define("FS_INQUIRY_LIST_38_1",'製品#: ');
define("FS_INQUIRY_LIST_39",'以下はご提出されたお見積です。');
define("FS_INQUIRY_LIST_40",'備考');
define("FS_INQUIRY_LIST_41",'このページを印刷');
define("FS_INQUIRY_LIST_42",'お見積もり発行日:');
// manage address
define("FS_CREATE_NEW_ADDRESS", '新しいアドレスの追加');
define("FS_DEFAULT", 'デフォルト');
define("FS_SAVE_ADDRESSES", 'アドレスを保存');
define("FS_EDIT_REMOVE", '編集/削除');
define("FS_EDIT", '編集');
define("FS_REMOVE", '削除');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", '配送先情報はまだ登録していません。');
define("FS_NO_BILLING_ADDRESS_HISTORY", '請求先情報はまだ登録していません。');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', '該当製品はカスタマイズされるものですので、製品の詳細ページで属性をお選びください。');
define('FS_MANAGE_CLOSE_TIP', 'この製品はオンラインで既に提供されていませんので、詳細についてアカウントマネージャーにお問い合わせください。また、類似製品をオンラインで確認できます。');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','口座の種類');
define('FS_NEW_ACCOUNT_MY_CREDIT_02','掛売口座');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','利用可能な与信限度額');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','合計与信限度額');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','ご利用枠引き上げ');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','ご注文を検索');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','PO番号/注文番号');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','注文日');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','購入履歴はまだありません。');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','お買い物を始めよう');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','注文が見つかりません。');
define('FS_NEW_ACCOUNT_MY_CREDIT_12','検索');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",'アカウント管理者：');
define("FS_ACCOUNT_NEW",'アカウント番号:');
define("FS_NAME",'お名前');
define("FS_ACCOUNT_MANAGE_CONTACT",'アカウントマネージャーの連絡先：');
define("FS_ACCOUNT_PHONE",'TEL：');
define("FS_ACCOUNT_ORDERS_PENDING",'保留中');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'進行中');
define("FS_ACCOUNT_ORDERS_COMPLETED",'完了した');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'有効なお見積');
define("FS_ACCOUNT_ORDERS_RMA",'RMA（返品・交換）');
define("FS_ACCOUNT_ORDERS",'注文一覧');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'ご注文の確認と追跡');
define("FS_ACCOUNT_HISTORY",'注文履歴');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'新規お見積依頼');
define("FS_ACCOUNT_QUOTE_STATUS",'見積ステータス・履歴');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'新規RMA（返品・交換）申請');
define("FS_ACCOUNT_RMA_STATUS",'RMAステータス・履歴');
define("FS_ACCOUNT_REVIEW_PURCHASES",'製品レビューを書く');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'注文ステータスと履歴を確認します。');
define("FS_ACCOUNT_VIEW_ORDERS",'注文を見る');
define("FS_ACCOUNT_SEARCH_ORDERS",'注文を検索：');
define("FS_ACCOUNT_PO_ORDER_ID",'PO/注文番号/製品ID');
define("FS_ACCOUNT_SEARCH",'検索');
define("FS_ACCOUNT_NET_TERMS",'掛売口座');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'今すぐ購入、後で支払う');
define("FS_ACCOUNT_CURRENT_BALANCE",'利用可能な与信限度額');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'口座の詳細を見る');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'アカウント設定');
define("FS_ACCOUNT_PASSWORD_MAIL",'パスワードとメール');
define("FS_ACCOUNT_USER_PHOTO",'写真');
define("FS_ACCOUNT_USER_NAME",'ユーザー名');
define("FS_ACCOUNT_EMAIL_ADDRESS",'メールアドレス');
define("FS_ACCOUNT_EMAIL_PASSWORD",'パスワード');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'メールマガジン登録の設定');
define("FS_ACCOUNT_SHOPPING_TOOLS",'クイッククリック');
define("FS_ACCOUNT_USEFUL_SHOPPING",'サポートとフィードバック');
define("FS_ACCOUNT_REQUEST_SAMPLE",'サンプルのお貸出');
define("FS_ACCOUNT_WRITE_REVIEW",'フィードバックを送信');
define("FS_ACCOUNT_USER_INFORMATION",'ユーザー情報');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'ケースとアドレス帳');
define("FS_ACCOUNT_ADDRESS_BOOK",'アドレス帳');
define("FS_ACCOUNT_CASE_CENTER",'ケースセンター');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define("FS_ACCOUNT_CASE_E_MAIL",'メール:');
define("FS_CREATE_SHIPPING_ADDRESS",'新しい配送先の追加');
define("FS_CREATE_BILLING_ADDRESS",'新しい請求先の追加');
define("FS_EDIT_SHIPPING_ADDRESS",'配送先を編集');
define("FS_EDIT_BILLING_ADDRESS",'請求先を編集');
define("FS_CONFIRMATION",'アドレス削除');
define("FS_DELETE_THIS_ADDRESS",'このアドレスを削除しますか？');
define("FS_SAVED_ADDRESSES",'アドレスを保存');
define("FS_SAVE_AS_DEFAULT",'既定の住所に設定');

define('FS_SALES_INFO_MODAL_TITLE','新しい住所を追加する');
define('FS_SALES_INFO_MODAL_FNAME','姓');
define('FS_SALES_INFO_MODAL_LNAME','名');
define('FS_SALES_INFO_MODAL_COUNTRY','お国/地域');
define('FS_SALES_INFO_MODAL_ADS_TYPE','アドレスタイプ');
define('FS_SALES_INFO_MODAL_COMPANT','会社名');
define('FS_SALES_INFO_MODAL_VAT','付加価値税/納税者番号');
define('FS_SALES_INFO_MODAL_ADS1','アドレス');
define('FS_SALES_INFO_MODAL_ADS2','アドレス 2');
define('FS_SALES_INFO_MODAL_CITY','市/町');
define('FS_SALES_INFO_MODAL_SPR','州/県/区');
define('FS_SALES_INFO_MODAL_STATE','州名をお選びください。');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','郵便番号');
define('FS_SALES_INFO_MODAL_PHONE_NUM','電話番号');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','キャンセル');
define('FS_SALES_INFO_MODAL_BTN_SAVE','保存する');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','通り、気付（～様方）');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','アパート名、部屋名、建物名、その他');

define('FS_SALES_DETILS_TYPE1','返金');
define('FS_SALES_DETILS_TYPE2','交換');
define('FS_SALES_DETILS_TYPE3','修理');
define('FS_RMA_NAVI1','RMA確認');
define('FS_RMA_NAVI2','RMA履歴');
define('FS_RMA_NAVI3','RMA詳細');
define('FS_RMA_NAVI4','RMA');
define('FS_RMA_NAVI5','新規RMA（返品・交換）申請');
define('FS_RMA_DETAILS_NAVI1','返品と返金の詳細');
define('FS_RMA_DETAILS_NAVI2','交換の詳細');
define('FS_RMA_DETAILS_NAVI3','修理の詳細');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', '送金を下記の口座にご転送ください。');

define('FS_RMA_SEARCH_TIPS','全てのRMA');

define("FS_ACCOUNT_REQUEST_A_SAMPLE",'サンプルのお申し込み');
define("FS_ACCOUNT_USEFUL_TOOLS",'クイッククリック');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'サポートとフィードバック');
define("FS_ACCOUNT_CANCEL",'確認');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'配送先');
define("FS_ACCOUNT_BILLING_ADDRESS",'請求先');
define('ACCOUNT_MY_HOME','ホーム');
define("FS_REVIEW_PURCHASE_10",'注文番号/製品ID');

define('FS_INDEX_FPE_TITLE','おすすめ製品');
define('FS_INDEX_ETN_TITLE','ネットワーク探索');
define('FS_INDEX_SERVICE_TITLE','サービス');
define('FS_ACCOUNT_TITLE','注文ステータス');
define('FS_ACCOUNT_BTN','ご注文を見る');
define('FS_ACCOUNT_CONTENT','ご注文を追跡し、最新の配達状況及び推定配達時間を把握します。');
define('FS_ACCOUNT_TITLE_REGISTER','アカウントを作成');

define('FIBER_SPARKASSE_BANK_NAME','銀行名:');

//订单详情
define('FS_PRINT_QTY','数量');
define('FS_PRINT_UNIT_PRICE','単価');
define('FS_PRINT_TOTAL','金額');
define('FS_PRINT_SHIPMENT','パッケージ');
define('FS_PRINT_SUBTOTAL','小計：');
define('FS_PRINT_SHIPPING_COST','送料：');
define('FS_PRINT_SHIPPING_TAX','Vat/Tax：');
define('FS_PRINT_TOTAL_WIDTH_COLON','合計：');
define('FS_PRINT_ITEM','アイテム');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','送料無料');
define('FS_BLANKET_33','総GST金額');
define('FS_BLANKET_34','合計');
define('FS_BLANKET_35','GST込み');

//报价相关
define('INQUIRY_QUOTE_LIST_1','お見積のお申込み');
define('INQUIRY_QUOTE_LIST_2','お見積履歴');

define('FS_CHECKOUT_ERROR_VAT','有効なVAT番号をご入力ください。例：$VAT');
define('FS_CHECKOUT_POPUP_TIPS','ショッピングカートに戻ってもよろしいでしょうか。');
define('FS_CHECKOUT_POPUP_TIPS_QUOTE','お見積履歴に戻ってもよろしいでしょうか。');
define('FS_CHECKOUT_POPUP_BUTTON1','決済を続ける');
define('FS_CHECKOUT_POPUP_BUTTON2','カートに戻る');
define('FS_CHECKOUT_PAYMENT','決済');
define('FS_CHECKOUT_PAYMENT_PO','POファイルを添付');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','カスタマイズ');
define('FS_ORDER_MANUFACTURING','製造中');
define('FS_ORDER_TEST_PASS','テストに合格');
define('FS_ORDER_SHIPPED','出荷済み');
define('FS_ORDER_TEST_REPORT','テストレポート');

define('FS_PRODUCTS_INFO_NOTE_TITLE','ご注意ください： ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','コヒーレントCFPモジュールを個別に販売することはできません。');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','掛売口座は「利用停止」の状態になり、掛売決済は利用できません。<a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">未払いの掛け買い注文をお支払いください。</a>または、他の決済オプションをお選びください。');
define('FS_PO_FORZEN_NOTICE_02','掛売口座は「利用停止」の状態です。詳細については、口座の詳細ページをご覧ください。');
define('FS_PO_FORZEN_NOTICE_03','掛売口座は「利用停止」の状態です。<a href="'.zen_href_link('manage_orders','','SSL').'">未払いの掛け買い注文をお支払いください。</a>または、詳細については、アカウントマネージャーにお問い合わせください。');

define("FS_ACCOUNT_RMA_ORDERS",'RMA履歴');
define("FS_ACCOUNT_PO_NUMBER",'PO番号');
define("FS_ACCOUNT_REQUEST_RMA",'新規RMA（返品・交換）申請');
define("FS_ACCOUNT_RMA_HISTORY",'RMA履歴');
define("FS_ACCOUNT_PO_ORDER",'注文書提出/履歴');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'製品レビューを書く');
define("FS_ACCOUNT_QUOTES",'お見積');
define("FS_ACCOUNT_QUICK_QUOTE",'クイック見積と見積ステータス');
define("FS_ACCOUNT_ACTIVE",'有効なお見積');
define("FS_ACCOUNT_QUOTE_HISTORY",'お見積履歴');
define("FS_ACCOUNT_REQUEST_QUOTE",'新規お見積依頼');
define("FS_ACCOUNT_ORDER_PENDING",'保留中');
define("FS_ACCOUNT_ORDER_PROGRESSING",'進行中');
define("FS_ACCOUNT_ORDER_COMMENTS",'注文備考：');

//support
define("SUPPORT_PAGE","FSカスタマーサポートへようこそ。何かお困りですか。");
define("SUPPORT_PAGE_1","即時対応");
define("SUPPORT_PAGE_2","ライブチャット");
define("SUPPORT_PAGE_3","ダウンロードセンター");
define("SUPPORT_PAGE_4","もっと見る");
define("SUPPORT_PAGE_5","テクニカルサポートをリクエスト");
define("SUPPORT_PAGE_6","お見積のお申込み");
define("SUPPORT_PAGE_7","ケーススタディ");
define("SUPPORT_PAGE_8","サポートビデオ");
define("SUPPORT_PAGE_9","コミュニティ");
define("SUPPORT_PAGE_10","他のサポートリソース");
define("SUPPORT_PAGE_11","返品規則");
define("SUPPORT_PAGE_12","パッケージの追跡");
define("SUPPORT_PAGE_13","サンプルのお貸し出し");
define("SUPPORT_PAGE_14","ヘルプセンター");
define('FS_SUPPORT','サポート');

define('FS_BY_CLICKING','上のボタンをクリックすると、');
define('FS_TERMS_AND_CONDITIONS','弊社の利用規約、');
define('FS_PRIVACY_AND_COOKIES','情報セキュリティポリシーと');
define('FS_AND_RIGHT_OF_WITHDRAWL','取消権に同意したものとみなします。');
define("FS_ZIP_CODE_EU","郵便番号");
define("FS_ADDRESS_EU","アドレス");
define("FS_ADDRESS2_EU","アドレス 2");
define('ACCOUNT_EDIT_CITY_EU','市名');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','FSをご訪問いただきありがとうございます。お困りのことがございましたら、');
define('FS_GIVE_FEEDBACK_TIP_2','FSサポート');//链接
define('FS_GIVE_FEEDBACK_TIP_3','にアクセスするか、');
define('FS_GIVE_FEEDBACK_TIP_4','ライブチャット ');//链接
define('FS_GIVE_FEEDBACK_TIP_5','でお問い合わせください。');
define('FS_FEEDBACK_SELECT_1', 'ウェブサイトデザイン');
define('FS_FEEDBACK_SELECT_2', '検索とナビゲーション');
define('FS_FEEDBACK_SELECT_3', '製品');
define('FS_FEEDBACK_SELECT_4', '決済/お支払い');
define('FS_FEEDBACK_SELECT_5', '出荷と配達');
define('FS_FEEDBACK_SELECT_6', '返品と交換');
define('FS_FEEDBACK_SELECT_7', 'サービスとサポート');
define('FS_FEEDBACK_SELECT_8', 'ウェブサイトへのアドバイス');


define('FS_AND',' と ');
define('FS_RIGHT_OF_WITHDRAWL','撤回権');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','アドレスは必須です。');

//报价语言包
define('INQUIRY_LISTS_1','全てのお見積');
define('INQUIRY_LISTS_2','有効なお見積');
define('INQUIRY_LISTS_3','購入済み');
define('INQUIRY_LISTS_4','お見積の手続きが完了しました。');
define('INQUIRY_LISTS_5','お見積照合');
define('INQUIRY_LISTS_6','お見積詳細');
define('FS_INQUIRY_INFO_66_1','お見積はXXに期限切れになりました。');
define('FS_INQUIRY_INFO_66_6','お見積はXXに期限切れになりました。');
define('FS_INQUIRY_INFO_66_2','ご入用の際はもう一度お申し込みできます。');
define('FS_INQUIRY_INFO_66_3','該当お見積はXXに期限切れです。');
define('FS_INQUIRY_INFO_66_7','該当お見積はXXに期限切れです。');
define('FS_INQUIRY_INFO_66_4','お見積はXXまで有効です。');
define("FS_INQUIRY_LIST_27",'アカウントマネージャー：');
define('FS_INQUIRY_INFO_66_5','ご専属なアカウントマネージャーがご依頼のお見積を作成した後、直接決済できます。');
define('FS_QUOTE','お見積');
define('INQUIRY_LISTS_7','全てのお見積');
define('INQUIRY_LISTS_8','お見積履歴');
define('INQUIRY_LISTS_9','お見積履歴');
define('INQUIRY_LISTS_10','見積番号');
define('INQUIRY_LISTS_11','見積番号');
define('INQUIRY_LISTS_12','有効期限: ');
define('INQUIRY_LISTS_13','申込者: ');
define('INQUIRY_LISTS_14','アカウントマネージャー: ');
define('INQUIRY_LISTS_15','お見積履歴に戻る');


// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00am-5:00pm EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Read more');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Education ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');

define('CART_SHIPPING_METHOD_CHECKOUT_PRE','送料:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','決済時に計算');
define('FS_COMMON_GSP_1','FSアジアから出荷');
define('FS_COMMON_GSP_2','輸入税等');
define('FS_COMMON_GSP_3','を含む');
define('FS_COMMON_GSP_4','購入時と通関でかかる輸入税､関税､その他手数料の合計金額です。');
define('FS_COMMON_5','閉じる');


define("FS_SHOP_CART_LIST_SUB",'小計');

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'カスタム');
define('FS_DETAIL_CUSTOM_2', '製造中');
define('FS_DETAIL_CUSTOM_3', '出荷完了');
define('FS_DETAIL_CUSTOM_4', '配達完了');
define('FS_DETAIL_CUSTOM_5', '推定製造時間: ');
define('FS_DETAIL_CUSTOM_6', '出荷予定日: ');
define('FS_DETAIL_CUSTOM_7', '到着予定日: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', '国際的製品');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees Deposit');
define('FS_GSP_STOCK_6', 'included');
define('FS_GSP_STOCK_7', 'このアイテムを、<a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">グローバル配送プログラム（GSP）</a>にてアジアのグローバル倉庫から発送いたします。購入時にFSが徴収する輸入税等は購入時と通関でかかる輸入税､関税､その他手数料の合計金額です。<a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">もっと見る</a>');
define('FS_GSP_STOCK_8', 'Close');
define('FS_GSP_STOCK_9', 'この製品は<a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">グローバル配送プログラム（GSP）</a>を介して、アジアのグローバル倉庫から発送されます。購入時に含まれる輸入手数料と通関手数は弊社より負担となります。また、消費税は決済時に合計金額に含まれます。<a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">もっと見る</a>');
define('FS_AVAILABLE', '利用可能');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW','該当アイテムはアジアのグローバル倉庫から発送されます。');

define('FS_OUTBREAK_NOTICE', '何かお困りですか-FSの新型コロナウイルス感染症（COVID-19）への対応について');
define('FS_OUTBREAK_NOTICE_M', 'FSの新型コロナウイルス感染症（COVID-19）への対応について');
define('FS_OUTBREAK_READ_MORE', 'もっと見る');

//subtotal(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','小計:');
define('FS_SHOP_CART_EXCL_VAT','VAT ($VAT)');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%)');
define('FS_SHOP_CART_EXCL_AU_VAT','オーストラリアGST (10%)');
define('FS_SHOP_CART_EXCL_DE_VAT','ドイツVAT ($VAT)');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','配達予定日は営業日の午後5時（EST）までに購入された在庫アイテムに適用されます。その後の注文は翌営業日に発送されます。ご注文の数量が在庫量を超えた場合、<a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">グローバルシッピングプログラム（GSP）</a>を使用してFSアジア倉庫から発送されます。');
define('FS_GSP_COVID_TIPS','COVID-19の影響とパッケージの増加により、配送サービスが遅れる場合があります。詳し情報については、<a href="'.reset_url('/login.html').'" target="_blank">マイアカウント</a>をチェックしてください。 ');


define('PRODUCTS_WARRANTY','モジュール向けの');
define('PRODUCTS_WARRANTY_1','XXプロフェッショナル品質');
define('PRODUCTS_WARRANTY_2','テストプログラム');
define('PRODUCTS_WARRANTY_3','です');
define('PRODUCTS_WARRANTY_4','出荷 & 配達');
define('PRODUCTS_WARRANTY_5','WARRANTY_YEARS年間保証');
define('PRODUCTS_WARRANTY_5_1','WARRANTY_YEARS年間保証');
define('PRODUCTS_WARRANTY_6','生涯保証');
define('PRODUCTS_WARRANTY_7','無料返品');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','VAT番号: ');
define('FS_VAT_NO_AU','ABN: ');
define('FS_VAT_NO_SG','GST登録番号: ');
define('FS_VAT_NO_BR','CNPJ: ');
define('FS_VAT_NO_CL','RUT: ');
define('FS_VAT_NO_AR','CUIT: ');
define('FS_VAT_NO_DEFAULT','納税者番号: ');

//add by liang.zhu 2020.03.30
define('FS_SALES_INFO_ALLOW','許可されているファイルタイプはPDF、JPG、PNGです。');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','保存したカート');
define('FS_ALL_SAVED_CARTS','全て');
define('FS_ADD_ALL_TO_CARTS','全てをカートに入れる');
define('FS_GO','検索');
define('FS_SHOW_CART','表示');
define('FS_SEARCH','検索');
define('FS_CART_NAME','カート名');
define('FS_SEARCH_SAVED_CARTS','保存したカートを検索');
define('FS_DATE_SAVED','保存日');
define('FS_CUSTOMER_ID','お客様番号');
define('FS_ACCOUNT_MANAGER','アカウントマネージャー');
define('FS_PHONE','電話番号#');
define('FS_SUBTOTAL','小計');
define('FS_VIEW_SHIPPING_CART','ショッピングカートを見る');
define('FS_SAVE_CART_CONDITIONS','保存したカートが見つからない場合は、別の条件で試してみてください。');
define('FS_NO_SAVED_CART_FOUND','保存したカートが見つかりません。');
define('FS_CRET_REFERENCE','カートの照会');
define('FS_CART_DELETE','削除');
define('FS_CART_NEW_ITEMS','に新しいアイテムが追加されました。');
define('FS_CART_SUCCESSFULLY_UPDATED','カートが更新されました。');
define('FS_CART_SAVED_CART_NAME','保存したカート名');
define('FS_CART_NEW_CART_CREATE','新しいカートが作成されました。');
define('FS_CART_HAS_BEEN_ADD','が保存したカートリストに追加されました。');
define('FS_CART_NAME_ALREADY_EXISTED','このカート名は既に存在します。別のカート名をお付けください。');
define('FS_ADD_TO_SAVED_CART','保存したカートに追加');
define('FS_SAVE_CART_SELECT','保存したカートをご選択');
define('FS_ADD_THE_ITEMS','または、アイテムを既存の保したカートにお入れください。');
define('FS_NAME_YOUR_SAVED_CART','保存したカートに名前を付ける');
define('FS_ADD_TO_CART','カートに入れる ');
define('FS_EMIAL_YOUR_CART','カートをメールで送信');
define('FS_PRINT_THIS_PAGE','このページを印刷');
define('FS_SAVED_CART_DETAILS','保存したカートの詳細');
define('FS_BELOW_IS_THE_CART','保存したカートの詳細は下記の通りです。');
define('FS_CART_CONTACT_CUSTOMER_SERVICE','カスタマーサービスにお問合せ');
define('FS_UPDATED_SUCCESSFULLY','カートが更新されました。');
define('FS_NEW_ITEM_CART','新しいアイテムが保存したカートに追加されました。');
define('FS_NEW_ITEM_CART1','新しいアイテムが保存したカート');
define('FS_NEW_ITEM_CART2','测试に追加されました。');
define('FS_CART_ALL_ITEMS','このカートのすべてのアイテムが購入できなくなりました。詳しい状況については、アカウントマネージャーにお問い合わせください。');
define('FS_CART_SOME_CUSTOMIZED','このカートの一部のカスタムアイテムに変更があります。製品の詳細ページに移動して属性をご選択ください。');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS','このカートのすべてのアイテムが変更されました。製品の詳細ページに移動して属性をご選択ください。');
define('FS_CART_THE_QUANTITY','ご指定の数量は利用可能な在庫数を超えており、在庫数以内にご指定下さい。利用可能な数量については、アカウントマネージャーにお問い合わせください。');
define('FS_CART_SHOPPING_CART_DIRECTLY','このカートのアイテムはオンラインで購入できなくなりました。詳しい状況については、アカウントマネージャーにお問い合わせください。利用可能なアイテムは直接ショッピングカートに移動されました。');
define('FS_CART_QUANTITY_ADDITIONAL','ご指定の数量は利用可能な在庫数を超えており、在庫数以内にご指定下さい。利用可能な数量については、アカウントマネージャーにお問い合わせください。');
define('FS_CART_CUSTOMIZED_SHOPPING_CART','このカートのカスタムアイテムに変更があります。製品の詳細ページに移動して属性をご選択ください。利用可能なアイテムは直接ショッピングカートに移動されました。');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','カート名は150文字以内でご入力ください。');
define('FS_FROM','差出人');
define('FS_TO_EMAIL','受取人');
define('FS_SELECT_SAVE_CART','カートをご選択ください。');


define('FS_NOTICE_FREE_SHIPPING','$MONEY以上のご注文で送料無料です');
define('FS_NOTICE_FREE_DELIVERY','$MONEY以上のご注文は送料無料です');
define('FS_NOTICE_FAST_SHIPPING','$COUNTRYへの迅速な出荷です');
define('FS_NOTICE_HEADER_COMMON_TIPS',' COVID-19の影響により、通常より配送日数が長くなる場合がございます。');

define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 Business Day Service');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('FS_SERVICE_WORD', 'service');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'お支払いはこちら');
define('FS_EMAIL_OPTIMIZE_02', 'ご注意ください：もし既にお支払いいただいているようでしたら、このメールは無視してください。');
define('FS_EMAIL_OPTIMIZE_03', 'ご注文が処理中でございます！');
define('FS_EMAIL_OPTIMIZE_04', 'ご注文#ORDER_NUMBERの詳細は下記の通りです。ご注文状態が更新次第、追跡情報をご送信します。');
define('FS_EMAIL_OPTIMIZE_05', 'ご注文を見る');
define('FS_EMAIL_OPTIMIZE_06', 'ご注意ください：もし既にPOをアップロードしていただいているようでしたら、このメールを無視してください。');
define('FS_EMAIL_OPTIMIZE_07', 'ご注文いただきありがとうございます。');
define('FS_EMAIL_OPTIMIZE_08', 'ご注文確定後7営業日以内に弊社指定口座にご入金ください。期日までにご入金がない場合、製品の在庫変更によりご注文をキャンセルさせていただく場合があります。弊社にてご入金の確認ができたうえで、ご注文確認メールをお送りします。');
define('FS_EMAIL_OPTIMIZE_09', 'お支払いのご案内');
define('FS_EMAIL_OPTIMIZE_10', '送金手続きを完了した後、銀行の送金明細書を$FS_EMAILまたはアカウントマネージャーにご送信ください。ご注文を優先的に処理し、ご注文の自動キャンセルリスクも回避できます。下記の弊社指定口座にご送金ください。');
define('FS_EMAIL_OPTIMIZE_11', 'ご注意ください：注文番号$ORDER_NUMBERとメールアドレスを振込メモにご記入ください。');
define('FS_EMAIL_OPTIMIZE_12', '配送ポリシー');
define('FS_EMAIL_OPTIMIZE_13', '弊社にてご入金の確認ができたうえで、発送の正式手配となります。');
define('FS_EMAIL_OPTIMIZE_14', 'ご注文は、平日（祝日を除く）の午前9時から午後5時までお届けします。特定の場合では、指定のアドレスでご注文を受け取ることもあります。');

define('FS_PLEASE_CHECK_THE_URL','URLを確認するか、 ');
define('FS_HOMEPAGE','ホームページに戻りましょう。');
define('FS_GO_TO_HOMEPAGE','ホームページに戻る');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 Business Days');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 Business Days');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 Business Days');

define("FS_WORD_CLOSE", '閉じる');

//报价购物车
define('FS_NEW_OTHER_LENGTH','他の長さ');
define('FS_INQUIRY_CART_1',"御見積書のお申し込み");
define('FS_INQUIRY_CART_2',"見積連絡先情報");
define('FS_INQUIRY_CART_3',"姓*");
define('FS_INQUIRY_CART_4',"名*");
define('FS_INQUIRY_CART_5',"メールアドレス*");
define('FS_INQUIRY_CART_6',"電話番号");
define('FS_INQUIRY_CART_7',"コメント");
define('FS_INQUIRY_CART_8',"ファイルをアップロード");
define('FS_INQUIRY_CART_9',"許可されているファイルタイプはPDF、JPG、PNGです。<br>ファイルサイズは最大5Mです。");
define('FS_INQUIRY_CART_10',"製品IDと数量を入力することで、アイテムが見積もり詳細にすばやく追加されます。");
define('FS_INQUIRY_CART_11',"追加する");
define('FS_INQUIRY_CART_12',"送信する");
define('FS_INQUIRY_CART_13',"特別な要件がある場合はメッセージを残してください。");
define('FS_INQUIRY_CART_14',"製品IDをご入力");
define('FS_INQUIRY_CART_15',"製品IDをご入力ください。");



define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'UPS Express Saver® Next Day Service');

define("FS_BLANK", ' ');

// 结算页美国、澳大利亚跳转
define('AUSTRALIA_HREF_1',"この言語のサイトでのご注文はオーストラリアに配送できません。ご希望の配送先住所がオーストラリア場合は、");
define('FS_AUSTRALIA_CHECKOUT',"FSオーストラリア");
define('AUSTRALIA_HREF_2'," にアクセスしてください。");
define('UNITED_STATES_SITE_HREF_1',"この言語のサイトでのご注文はアメリカに配送できません。ご希望の配送先住所がアメリカの場合は、");
define('FS_UNITED_STATES_SITE',"FSアメリカ合衆国サイト");
define('UNITED_STATES_SITE_HREF_2',"にアクセスしてください。");
define('RUSSIAN_SITE_HREF_1',"法人の場合、ご注文はルーブルを使ったキャッシュレス支払いで決済する必要があります。ご注文を希望される場合は、");
define('FS_RUSSIAN_SITE',"FSロシアサイト");
define('RUSSIAN_SITE_HREF_2',"にアクセスしてください。");



//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'カートの読み込み中');

define('FS_VAX_TITLE_US','消費税');
define('FS_VAX_TITLE_US_TAX','消費税');

//消费税提示小气泡
define('FS_VAX_US_TIPS','州の税法によると、FSは免税対象でない当事者から売上税を徴収するために必要です。<a href="https://www.fs.com/service/sales_tax.html" target="_blank">もっと見る</a>');

//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "レビューをチェック");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "製品レビューを書く");
define('FS_VIEW_REVIEWS_SEARCH', "検索");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "レビューを検索");
define('FS_VIEW_REVIEWS_ITEM', "アイテム#");
define('FS_VIEW_REVIEWS_1', "レビューは見つかりませんでした。");
define('FS_VIEW_REVIEWS_2', "ご注文を見つけてレビューを共有しましょう。");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "FSより発表された ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "非常に満足");
define('FS_VIEW_REVIEWS_READ_MORE', "続きを読む");
define('FS_VIEW_REVIEWS_MORE', "もっと見る");
define('FS_VIEW_REVIEWS_SHOW', "表示");
define('FS_VIEW_REVIEWS_COMMENTS', "コメント");


define('FS_SRVICE_WORD', "");

define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE','ケーブル材質');
define('FS_PRODUCT_MATERIAL_TIP','ご依頼数量が現行品の在庫数量を超えるため、超える分が弊社の工場側に生産され納入する形になります。在庫状況によって分割発送をご希望の場合は、ご専属なアカウントマネージャーにご連絡ください。');

define('FS_INQUIRY_PRODUCTS_NUM',"お見積もり詳細の製品情報をご確認ください。");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'お名前をご入力ください。');
define('FS_NET_30_02', '申請書をアップロードしてください。');
define('FS_NET_30_03', '掛売口座は既に存在されています。');
define('FS_NET_30_04', 'FS-与信取引のご申請は受領されました。');
define('FS_NET_30_05', '与信取引のご申請を受け取りました。現在審査中ですので、このプロセスには約2～3営業日かかる場合があります。結果が確認でき次第、すぐにFSメールでお知らせ致します。');
define('FS_NET_30_06', '申請ステータス');
define('FS_NET_30_07', '提出済み');
define('FS_NET_30_08', '審査中');
define('FS_NET_30_09', '承認済み');
define('FS_NET_30_10', '拒否された');
define('FS_NET_30_11', '申請書をご提出');
define('FS_NET_30_12', 'お名前');
define('FS_NET_30_13', 'メールアドレス');
define('FS_NET_30_14', '電話番号');
define('FS_NET_30_15', 'ファイルをアップロード');
define('FS_NET_30_16', 'ファイルをご選択');
define('FS_NET_30_17', 'ご提出頂いた与信限度申請書は正常に送信されました。');
define('FS_NET_30_18', '2～3営業日以内に審査結果をメールで送信します。また、FSアカウントを使用して“#CASE_CENTER”で更新を追跡することもできます。');
define('FS_NET_30_19', 'ご協力いただきましてありがとうございました！与信限度申請書は正常に送信されました。');
define('FS_NET_30_20', '与信取引のご申請は審査中です。このプロセスには約2～3営業日かかります。');
define('FS_NET_30_21', '与信取引のご申請が承認されたことをお知らせします。これで、掛売決済で購入を開始できるようになりました。');
define('FS_NET_30_22', '“#FS_CREDIT”で掛売口座の詳細を表示することもできます。');
define('FS_NET_30_23', '与信取引のご申請が拒否されたとのこと、申し訳ございません。');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', '与信取引を再申請しますか？');
define('FS_NET_30_25', '“#NET_TERMS”に完成した与信取引申請書に記入して頂き、弊社にご送信頂いてください。');
define('FS_NET_30_26', 'もしご不明な点がございましたら、ご専属なアカウントマネージャー#ACCOUNT_MANAGERまでお気軽にお問い合わせください。');
define('FS_NET_30_27', '国/地域');
define('FS_NET_30_28', 'コメント');
define('FS_NET_30_29', 'アップロード');
define('FS_NET_30_30','どうぞ宜しくお願い致します。<br>FSチーム');
define('FS_NET_30_31','ご申請は受領済み');
define('FS_NET_30_32','掛売決済');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','イノベーションの最新動向を探る');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1','FSメールマガジン');
define('FS_UNSUBSCRIBE_MAIL_2','FSメールマガジンによって、最新の優遇ポリシー、在庫情報、テクニカルサポートなどの詳細を把握できます。');
define('FS_UNSUBSCRIBE_MAIL_3','レビューリクエストメール');
define('FS_UNSUBSCRIBE_MAIL_4','レビューリクエストメールは、ご注文が配達されてから一週間後に送信されます。');
define('FS_UNSUBSCRIBE_MAIL_5','FSからメールを受信するためのサブスクリプション設定を管理します。');
define('FS_UNSUBSCRIBE_MAIL_6','アカウントと注文に関するメールは重要ですので、これらのメールの購読を解除することを選択した場合でも送信されます。');
//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', '企業');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','波長(nm)');

//100G产品提示语
define("FS_COHERENT_CFP","コヒーレントCFPモジュールは別売りされていません。");


//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1','ご選択の住所は郵便番号で表示されたエリアと一致しません。ご住所を再確認してください。');
define('FS_ZIP_VALID_2','有効な郵便番号をご入力ください。');


define("FS_SOLUTION_CLICK_OPEN_VIEW","クリックで画像を拡大する");
define("FS_CUSTOMIZE_YOUR_SOLUTION","ソリューションをカスタマイズ＆選択");
define("FS_TECH_SPEC_CUSTOMOZATION","技術仕様");
define("FS_SOLUTION_OVERVIEW",'概要');
define("FS_SOLUTION_CUSTOMIZED",'カートに入れる');
define("FS_SOLUTION_EDIT",'編集する');
define("FS_SOLUTION_CONFIGURATION",'ソリューション構成');
define("FS_SOLUTION_MORE",'もっと見る');
define('FS_SOLUTION_LESS','表示を減らす');
define("FS_SOLUTION_DEVICES",'デバイス');
define("FS_SOLUTION_TRANSCEIVER",'モジュール');
define("FS_SOLUTION_WAVE_COM_BAR",'波長と互換ブランド');
define("FS_SOLUTION_ACCESSORIES",'付属品');
define("FS_SOLUTION_CHOOSE_LENGTH",'長さを選択する');
define("FS_SOLUTION_INFO",'ソリューション情報');

define('FS_SOLUTION_PERSONALIZATION','カスタマイズ');
define('FS_SOLUTION_MANUFACTURING','製造');
define('FS_SOLUTION_SHIPPED','発送');
define('FS_SOLUTION_ARRIVED','納品');
define('FS_SOLUTION_CON_LIST','ソリューション構成リスト');
define('FS_SOLUTION_QUANTITY','数量');
define('FS_SOLUTION_TOTAL','合計');

define('FS_SOLUTION_SITEA','サイトA');
define('FS_SOLUTION_SITEB','サイトB');

define('FS_SOLUTION_NAV_01','光伝送ネットワーク');
define('FS_SOLUTION_NAV_02','キャンパスネットワーク');
define('FS_SOLUTION_NAV_03','データセンター');
define('FS_SOLUTION_NAV_04','構造化ケーブル');
define('FS_SOLUTION_NAV_05','アプリケーション別');
define('FS_SOLUTION_NAV_06','10G CWDMデュアルファイバネットワーク');
define('FS_SOLUTION_NAV_07','10G CWDMシングルファイバネットワーク');
define('FS_SOLUTION_NAV_08','10G DWDMデュアルファイバネットワーク');
define('FS_SOLUTION_NAV_09','10G DWDMシングルファイバネットワーク');
define('FS_SOLUTION_NAV_10','25G DWDMデュアルファイバネットワーク');
define('FS_SOLUTION_NAV_11','25G DWDMシングルファイバネットワーク');
define('FS_SOLUTION_NAV_12','40G/100Gコヒーレントネットワーク');
define('FS_SOLUTION_NAV_13','企業ネットワーク');
define('FS_SOLUTION_NAV_14','ワイヤレスとモビリティ');
define('FS_SOLUTION_NAV_15','マルチブランチネットワーク');
define('FS_SOLUTION_NAV_16','クラウド管理ネットワーク');
define('FS_SOLUTION_NAV_17','データセンターの構造化ケーブル');
define('FS_SOLUTION_NAV_18','高密度MTP®/MPOケーブル');
define('FS_SOLUTION_NAV_19','40G/100G移行');
define('FS_SOLUTION_NAV_20','事前終端銅製ケーブル');
define('FS_SOLUTION_NAV_21','マルチサービスCWDMソリューション');
define('FS_SOLUTION_NAV_22','10G DWDM長距離トランスポート');
define('FS_SOLUTION_NAV_23','5Gフロントホール向け25G WDM');
define('FS_SOLUTION_NAV_24','100GコヒーレントDWDMソリューション');
define('FS_SOLUTION_NAV_25','MLAGネットワークの最適化');
define('FS_SOLUTION_NAV_26','データセンターコアネットワークスイッチング');
define('FS_SOLUTION_NAV_27','パワーオーバーイーサネットソリューション');
define('FS_SOLUTION_NAV_28','安全なワイヤレスソリューション');
define('FS_SOLUTION_NAV_29','データセンターの構造化ケーブル');
define('FS_SOLUTION_NAV_30','高密度MTP®/MPOケーブル');
define('FS_SOLUTION_NAV_31','40G/100G移行');
define('FS_SOLUTION_NAV_32','事前終端銅製ケーブル');
define('FS_SOLUTION_NAV_33','プロのソリューション技術チームとサポート');
define('FS_SOLUTION_NAV_34','エンタープライズデータセンター');
define('FS_SOLUTION_NAV_35','サービスプロバイダーデータセンター');
define('FS_SOLUTION_NAV_36','ハイパースケールとクラウドデータセンター');
define('FS_SOLUTION_NAV_37','マルチテナントデータセンター');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','M6200シリーズ10G DWDM長距離');
define('FS_SOLUTION_NAV_M6500','M6500シリーズ100G/200G高帯域幅');
define('FS_SOLUTION_NAV_M6800','DCI用のM6800シリーズ1.6Tソリューション');
define('FS_SOLUTION_NAV_WiFi6','Wi-Fi 6ネットワークソリューション');

//新加坡
define("FS_CHECKOUT_ERROR_SG_01","アドレス2は必須です。");
define("FS_CHECKOUT_ERROR_SG_02","アパート名、部屋名、組織名、ユニット名、建物名、階、その他");
define("FS_CHECKOUT_ERROR_SG_03","チケット番号");
define("FS_CHECKOUT_ERROR_SG_04","スムーズな配達を確保するために、Equinixに配送されたパッケージのチケット番号をご提供ください。");
define("FS_CHECKOUT_ERROR_SG_05","*COVID-19の特別管理期間中は、受領の適時性を確保するために、自宅のアドレスを記入することをお勧めします。");
define("FS_CHECKOUT_ERROR_SG_06","配送先住所を完全にご入力ください。");

define('FS_CHECKOUT_ERROR_001',"上記アイテムのご購入で許可されている最大ユニット数に達しました。利用可能なすべての製品がカートに追加されています。");
define('FS_CHECKOUT_ERROR_002','<span>4</span>つの異なるチャネルを選択してください。');

define("FS_SEE_ALL_RESULTS","すべての結果を見る");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"ソフトウェアダウンロード");
define('FS_CHECK',"ご購入したスイッチの最新ソフトウェアバージョンを取得することはできます。");
define('FS_SOFWARE','ソフトウェアダウンロード');
define('FS_SOFWARE_1','カスタマーサービスのお問合せ');
define('FS_SOFWARE_2','ご購入したスイッチの最新ソフトウェアバージョンを取得することはできます。その他のソフトウェアバーションについては、');
define('FS_SOFWARE_4','ダウンロードセンター');
define('FS_SOFWARE_4_1','にアクセスしてください');
define('FS_SOFWARE_5','カタログによって検索:');
define('FS_SOFWARE_6','ネットワークスイッチ');
define('FS_SOFWARE_7','1G/10Gスイッチ');
define('FS_SOFWARE_8','25Gスイッチ');
define('FS_SOFWARE_9','40Gスイッチ');
define('FS_SOFWARE_10','100Gスイッチ');
define('FS_SOFWARE_11','400Gスイッチ');
define('FS_SOFWARE_12','製品IDによって検索:');
define('FS_SOFWARE_13','検索');
define('FS_SOFWARE_14','最新のファイル情報');
define('FS_SOFWARE_15','製品ID');
define('FS_SOFWARE_16','更新日');
define('FS_SOFWARE_17','サイズ');
define('FS_SOFWARE_18','ソフトウェア');
define('FS_SOFWARE_19','ソフトウェア通知');
define('FS_SOFWARE_20','最新のファイル情報');
define('FS_SOFWARE_22','参考資料はこちらへ');
define('FS_SOFWARE_23','更新する');
define('FS_SOFWARE_24','ソフトウェア');
define('FS_SOFWARE_25','ダウンロード');
define('FS_SOFWARE_26','ソフトウェア更新のお知らせ');
define('FS_SOFWARE_27','購読解除');
define('FS_SOFWARE_28','購読');
define('FS_SOFWARE_29','ソフトウェア更新通知の購読を解除しますか？');
define('FS_SOFWARE_30','ソフトウェア更新通知を定期的に購読しますか？');
define('FS_SOFWARE_31','ソフトウェアが見つからない場合は、別の絞り込みたい項目を選択してみてください。');
define('FS_SOFWARE_32','今まで弊社のスイッチを購入したことがないようですが、先行して購入しましょうか。');
define('FS_SOFWARE_33','お買い物を始める');
define('FS_SOFWARE_34','ソフトウェア更新通知は購読されました。');
define('FS_SOFWARE_35','最新のソフトウェアに関するメール通知をお届けします。');
define('FS_SOFWARE_36','ソフトウェア更新通知は購読されました。');
define('FS_SOFWARE_37','ソフトウェア更新通知の購読は解除されました。');
define('FS_SOFWARE_38','最新のソフトウェアに関するメール通知を受信しなくなります。');
define('FS_SOFWARE_39','製品ID');
define('FS_SOFWARE_40','ソフトウェアが見つかりません。');
define('FS_SOFWARE_41','購読確認済み');
define('FS_SOFWARE_42','以下スイッチのソフトウェア更新通知は購読されました。最新バージョンが利用可能になり次第、お知らせ致します。');
define('FS_SOFWARE_43','下記にもご興味がおありかもしれません...');
define('FS_SOFWARE_44','世界中のお客様にご提供したものを<br>ご覧ください。');
define('FS_SOFWARE_45','最新の革新的な製品と企業のイベントを<br>ご覧ください。');
define('FS_SOFWARE_46','FS-ソフトウェア更新の購読');
define('FS_SOFWARE_47','購読を解除済み');
define('FS_SOFWARE_48','以下のスイッチのソフトウェア更新通知を受信中止になります。');
define('FS_SOFWARE_49','間違いがある場合は、下のボタンをクリックして再購読してください。');
define('FS_SOFWARE_50','再購読');
define('FS_SOFWARE_51','連絡を取り合いましょう');
define('FS_SOFWARE_52','ソフトウェアの購読');
define('FS_SOFWARE_53','FSの成功事例');
define('FS_SOFWARE_54','FSの最新ニュース');


define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','配送オプションがお見つからないのですか？');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','運送業者の発送物寸法の制限により、製品ID＃73579または＃73958を含むご注文は、通常便で発送することは出来かねます。発送可能な方法に関しては、ご自身の運送業者を使用するか、ご専任なアカウントマネージャーに乙仲業者を利用するかをご相談いただきたくと存じます。ご不便をおかけして申し訳ありませんが、ご了承ご容赦を頂けますと幸いです。');

define('FS_CHECKOUT_FOOTER_NEW_01', "フィードバックを送信");
define('FS_CHECKOUT_FOOTER_NEW_02', "<a href=". reset_url('service/fs_support.html')." target='_blank'>ヘルプセンター</a>にアクセスするか、<a target='_blank' href=" . reset_url('contact_us.html') . ">お問い合わせ</a>ください。");
define('FS_CHECKOUT_FOOTER_NEW_03', "お困りのことがございましたら、");
define('FS_CHECKOUT_FOOTER_NEW_04', "トピックをお選びください*");
define('FS_CHECKOUT_FOOTER_NEW_05', "ご選択ください...");
define('FS_CHECKOUT_FOOTER_NEW_06', "ログイン/新規登録");
define('FS_CHECKOUT_FOOTER_NEW_07', "ショッピングカート");
define('FS_CHECKOUT_FOOTER_NEW_08', "税金");
define('FS_CHECKOUT_FOOTER_NEW_09', "お届け先＆請求先");
define('FS_CHECKOUT_FOOTER_NEW_10', "お届け先");
define('FS_CHECKOUT_FOOTER_NEW_11', "お支払い");
define('FS_CHECKOUT_FOOTER_NEW_12', "その他");
define('FS_CHECKOUT_FOOTER_NEW_13', "トピックをお選びください。");
define('FS_CHECKOUT_FOOTER_NEW_14', "お問い合わせ・ご意見・ご感想をお聞かせください。");
define('FS_CHECKOUT_FOOTER_NEW_15', "お客様からお寄せいただきました「ご意見・ご要望」は、弊社のサービス品質の向上に活かしております。");
define('FS_CHECKOUT_FOOTER_NEW_16', "10文字以上ご入力ください。");
define('FS_CHECKOUT_FOOTER_NEW_17', "提出する");
define('FS_CHECKOUT_FOOTER_NEW_18', "ご意見をいただきありがとうございます。");
define('FS_CHECKOUT_FOOTER_NEW_19', "ご送信の内容を確認し、今後のアクセスのために、FS Webサイトを改善するのにご意見をご利用させて頂きます。");
define('FS_CHECKOUT_SUCCESS_EMAIL_01', "新しいフィードバックを受け取りました");
define('FS_CHECKOUT_SUCCESS_EMAIL_02', "お客様が決済ページで次の情報を送信しました。ご要望に応じてフォローアップしてください。");
define('FS_CHECKOUT_SUCCESS_EMAIL_03', "お客様の名前：");
define('FS_CHECKOUT_SUCCESS_EMAIL_04', "メールアドレス：");
define('FS_CHECKOUT_SUCCESS_EMAIL_05', "注文番号：");
define('FS_CHECKOUT_SUCCESS_EMAIL_06', "フィードバックのトピック：");
define('FS_CHECKOUT_SUCCESS_EMAIL_07', "追加コンテンツ：");
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'フィードバックのトピック');

define('FS_PRINT',"お客様のプライバシーを保護するために、注文の詳細を確認するにはご発注時に使用されたFSアカウントを入力してください。");
define('FS_PRINT_1',"確認");
define('FS_PRINT_2',"ご入力したメールが注文情報に関連付けられたメールと一致しませんので、ご確認した後にもう一度入力してください。");
define('FS_PRINT_3',"メールアドレスを入力してください。");

//liang.zhu 2020.08.03
define('FS_CLEARANCE_TIP_01_01', 'この販促品は$QTY pcsの在庫品しかありませんので、売り切れ次第削除されます。');
define('FS_CLEARANCE_TIP_01_02', 'より多くの数量を購入する場合は、代替品「<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>」を選択することをお勧めします。');
define('FS_CLEARANCE_TIP_02_01', 'この販促品は在庫切れで、間もなく削除されます。');
define('FS_CLEARANCE_TIP_02_02', 'より多くの数量を購入する場合は、代替品「<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>」を選択することをお勧めします。');
define('FS_CLEARANCE_TIP_03_01', 'この販促品は$QTY pcsの在庫品しかありませんので、売り切れ次第削除されます。');
define('FS_CLEARANCE_TIP_03_02', 'より多くの数量を購入する場合は、アカウントマネージャーにお問い合わせください。');
define('FS_CLEARANCE_TIP_04_01', 'この販促品は在庫切れで、間もなく削除されます。');
define('FS_CLEARANCE_TIP_04_02', 'より多くの数量を購入する場合は、アカウントマネージャーにお問い合わせください。');



//评论改版
define('FS_REVIEW_07','機器モデル');
define('FS_REVIEW_08','機器のモデル名を追加すると、他のお客様がより簡単に購入できるようになります。');
define('FS_REVIEW_09','許可されているファイルタイプはJPG、JPEG、PNGです。最大ファイルサイズは5MBです。');
define('FS_REVIEW_11','任意');

define('FS_REVIEW_ATTRIBUTE_CONTENT', '互換ブランド');


define('CHECKOUT_COMPANY_TYPE', 'ご選択のアドレスタイプが間違っています。');


## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "出荷指示（任意）");
define("FS_DELIVERY_TICKET_NUMBER", "チケット番号、セキュリティコードなど");
define("FS_DELIVERY_OTHER_INFO", "配達時間、またはその他の出荷指示");
define("FS_DELIVERY_PROMPT", "出荷指示はご注文が予定通りに届けるのを助けます。");
define('FS_DELIVERY_INSTRUCTIONS', '出荷指示');

//PO
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', 'が確認されました。7営業日以内に発注書（PO）ファイルをアップロードしてください。それ以外の場合、製品の在庫変更によりご注文をキャンセルさせていただく場合があります。');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', '発注書（PO）ファイルのアップロード');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'POファイルとは何ですか？');
define('FS_PO_FILE','発注書');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','発注書');
define('FS_PO_FILE_4','発行日:2020年08月08日<br />PO #: PO0001');
define('FS_PO_FILE_5','サプライヤー');
define('FS_PO_FILE_6','お届け先');
define('FS_PO_FILE_7','ご請求先');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','アカウントマネージャー：');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','メールアドレス: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','電話番号#: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','受取人: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','電話番号: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','受取人: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','お支払い方法');
define('FS_PO_FILE_27','依頼者');
define('FS_PO_FILE_28','部門');
define('FS_PO_FILE_29','銀行振込');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','購買部');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>製品説明</th><th>製品ID</th><th>数量（pcs）</th><th>単価<th>合計</th>');
define('FS_PO_FILE_36','小計:');
define('FS_PO_FILE_38','送料:');
define('FS_PO_FILE_39','TAX/VAT:');
define('FS_PO_FILE_40','合計（税抜）');
define('FS_PO_FILE_41',"POファイルとは何ですか？");
define('FS_PO_FILE_42',"発注書（PO）は実際ご購入および製品手配の証拠として使われて、通常は次のものが含まれます。");
define('FS_PO_FILE_43',"注文日と注文番号;");
define('FS_PO_FILE_44',"買い手と売り手の会社情報;");
define('FS_PO_FILE_45',"配送先住所 & 請求先住所;支払い条件;");
define('FS_PO_FILE_46',"FSの製品情報と価格");
define('FS_PO_FILE_47',"POファイルの例を見る");

//线下订单列表
define('FS_OFFLINE_01','領収書をダウンロード');
define('FS_OFFLINE_02','注文日： ');
define('FS_OFFLINE_03','注文番号#: ');
define('FS_OFFLINE_04','小計： ');
define('FS_OFFLINE_05','送料: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','保険料: ');
define('FS_OFFLINE_08','合計: ');
define('FS_OFFLINE_09','ご注文は決済時にお選びになった配送方法に従って輸送されています。以下の追跡番号をクリックするか、通知メールで追跡ステータスを確認頂けます。ただし、一部の運送業者は常に追跡情報をすぐに更新するわけではなく、配送状況の更新が延期される場合があります。');
define('FS_OFFLINE_10','この配送状況は新しい注文の配送状況になりました。');
define('FS_OFFLINE_11','主な利点は、そのパッシブな性質–電源または冷却が不要であり、堅牢性–特別な微気候要件はありません。主な利点は、そのパッシブな性質–電源または冷却が不要であり、堅牢性–特別な微気候要件はありません。主な利点は、そのパッシブな性質–電源または冷却が不要であり、堅牢性–特別な微気候要件はありません。主な利点は、そのパッシブな性質–電源または冷却が不要であり、堅牢性–特別な微気候要件はありません。主な利点は、そのパッシブな性質–電源または冷却が不要であり、堅牢性–特別な微気候要件はありません。主な利点は、その受動的な性質–電力がないことです。');
define('FS_OFFLINE_12','領収書を確認');
define('FS_OFFLINE_13','この配送はキャンセルされました。もしご不明な点がございましたら、ご専任なアカウントマネージャーにお問い合わせください。');
define('FS_OFFLINE_14','詳しくは');
define('FS_OFFLINE_15','注文で');
define('FS_OFFLINE_16',' ご確認ください');
define('FS_OFFLINE_17','処理中');
define('FS_OFFLINE_18','はい');
define('FS_OFFLINE_19','注文番号# ');
define('FS_OFFLINE_20','（現在の注文）');
define('FS_OFFLINE_21','ご注文は見つかりませんでした。');
define('FS_OFFLINE_22','注文が見つからない場合は、別のフィルター条件を選択するか、注文番号を確認してください。<br/>オフライン注文は発送後にのみ検索できます。その前にご専任なアカウントマネージャーに相談することができます。');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','オフライン注文');
define('FS_OFFLINE_COMBINED_SHIPMENT','同梱発送');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','配送量を減らし、環境を保護するために、FSは以下の注文をまとめて発送するように手配しています。注文番号をクリックして、それぞれの注文詳細を確認できます。');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','注文ステータスが更新されていない場合は、ご専任なアカウントマネージャーにご相談ください。ご注文が出荷されると、「"');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','"」に進捗を確認することもできます。');
define('FS_OFFINE_TRANSACTION','オフライン取引');
define('FS_OFFINE_TRANSACTION_1','この配送はキャンセルされました。もしご不明な点がございましたら、専任なアカウントマネージャーにお問い合わせください。');
define('FS_OFFLINE_POPUP','このパッケージには他のご注文品も含まれています。');
define('FS_OFFINE_TRANSACTION','オフライン取引');
define('FS_OFFINE_TRANSACTION_2','下記の配送追跡情報を参照してください。');
define('FS_OFFINE_TRANSACTION_4','ご注文が処理中でございます。');
//my credit orders 页面
define('FS_VIEW_CONTENT','この注文は複数のパッケージに分割して配達されます。請求書はそれぞれの配達ごとに分けられているため、注文の詳細ですべての請求明細を確認することはできます。');
define('FS_VIEW_LINK',"<a href=".zen_href_link('account_offline_history_info','orders_id='.$item['orders_id'],'SSL')." style='color: #0070BC;'>ここをクリック</a>してすべての請求明細を確認に行きます。");
define('FS_MY_CREDIT_01','詳細');
define('FS_MY_CREDIT_02','オンライン注文');
define('FS_MY_CREDIT_03','オフライン注文');
define('FS_MY_CREDIT_04','検索');
define('FS_OFFINE_TRACK_INFO_1','注文ステータスが更新されていない場合は、ご専任なアカウントマネージャーにご相談ください。ご注文が出荷されると、「"<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">注文履歴</a>"」に進捗を確認することもできます。');
define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');

//结算页
define('FS_CHECK_OUT_EXCLUDING1','税抜');


define('FS_SEARCH_NEW','の検索結果 ');
define('FS_SEARCH_NEW_1','製品');
define('FS_SEARCH_NEW_2','ドキュメントとリソース');
define('FS_SEARCH_NEW_3','ソリューション');
define('FS_SEARCH_NEW_4','ケーススタディ');
define('FS_SEARCH_NEW_5','資料ダウンロード');
define('FS_SEARCH_NEW_6','すべてクリア');
define('FS_SEARCH_NEW_7','ソリューション');
define('FS_SEARCH_NEW_8','ケーススタディ');
define('FS_SEARCH_NEW_9','ファイル名');
define('FS_SEARCH_NEW_10','タイプ');
define('FS_SEARCH_NEW_11','更新日');
define('FS_SEARCH_NEW_12','ファイル');
define('FS_SEARCH_NEW_13','ニュース');
define('FS_SEARCH_NEW_14','はオンラインでご利用いただけなくなりましたで、以下のような類似製品 ');
define('FS_SEARCH_NEW_15','をお勧めします。');
define('FS_SEARCH_NEW_16','はオンラインでご利用いただけなくなりましたで、御見積りのお申し込みにてお問い合わせください。');

define('FS_ACCOUNT_SEARCH_ALL_TIMES', '全ての注文');

define('FS_MY_SHOPPING_CART','マイショッピングカート');
define('GET_A_QUOTE_TIP_1',"※納期および発送情報のお問い合わせに関しては、以下の情報をご記入いただく上、御見積もり依頼の形でご送信下さいます様にお願いたします。そして、ご専任なアカウントマネージャーは早速にご対応・ご回答致します。");

define("FS_INQUIRY_NEW_EMAIL_0","の変更リクエスト");
define("FS_INQUIRY_NEW_EMAIL","を受領済み");
define("FS_INQUIRY_NEW_EMAIL_1","見積もりの変更依頼");
define("FS_INQUIRY_NEW_EMAIL_2_0","お客様");
define("FS_INQUIRY_NEW_EMAIL_2_1","からお見積書");
define("FS_INQUIRY_NEW_EMAIL_2","の変更リクエストを受け取りました。");
define("FS_INQUIRY_NEW_EMAIL_3","以下の詳細を確認し、できるだけ早く見積書を修正・更新して再度ご送付をお願い致します。");
define("FS_INQUIRY_NEW_EMAIL_4","ケース番号:");
define("FS_INQUIRY_NEW_EMAIL_5","製品説明");
define("FS_INQUIRY_NEW_EMAIL_6","数量(pcs)");
define("FS_INQUIRY_NEW_EMAIL_7","単価");
define("FS_INQUIRY_NEW_EMAIL_8","合計");
define("FS_INQUIRY_NEW_EMAIL_9","小計:");
define("FS_INQUIRY_NEW_EMAIL_10","合計:");
define("FS_INQUIRY_NEW_EMAIL_11","に返信するか、");
define("FS_INQUIRY_NEW_EMAIL_12"," このアカウントに見積もりを同期更新してください。");
define("FS_INQUIRY_NEW_EMAIL_13","コメントが送信されました。");
define("FS_INQUIRY_NEW_EMAIL_14","メールを受信しましたので、ご専任なアカウントマネージャーが12〜24時間以内に致します。");

define('FS_QUOTE_INQUIRY_01', 'ファイルを選択');
define('FS_QUOTE_INQUIRY_02', '製品リストをアップロード');
define('FS_QUOTE_INQUIRY_03', '製品IDを入力するか、見積もり依頼対象製品リストをアップロードしてください。');
define('FS_QUOTE_INQUIRY_04', '御見積り依頼が送信されました。');
define('FS_QUOTE_INQUIRY_05', 'ご専任なアカウントマネージャーが12～24時間以内に見積もりを処理しますので、正式なお見積書を作成され次第、すぐにメールでお知らせ致します。');
define("FS_QUOTE_EDIT_QUOTE", "見積もりを編集");
define("FS_QUOTE_QUOTE_REQUEST", "御見積書のお申し込み");
define("FS_QUOTE_INQUIRY_06", "この見積もりについてアカウントマネージャーにメールを送信してください。");
define("FS_QUOTE_INQUIRY_07", "見積もり");//后面接询盘号
define("FS_QUOTE_INQUIRY_08", "が有効ですので、");
define("FS_QUOTE_INQUIRY_09", "直接ご決済いただけます。");
define("FS_QUOTE_INQUIRY_10", "この見積もり内容を変更する必要がある場合、またはご不明な点ございましたら、以下に情報を入力してください。ご記入頂いたメッセージがアカウントマネージャーに送信されます。");
define("FS_QUOTE_INQUIRY_11", "発信者:");
define("FS_QUOTE_INQUIRY_12", "ご専任なアカウントマネージャーがこのメールに返信致します。");
define("FS_QUOTE_INQUIRY_13", "受信者:");
define("FS_QUOTE_INQUIRY_14", "何か気になる点がございましたら、メッセージを残してください。");
define("FS_QUOTE_INQUIRY_15", "アイテムを追加または変更する場合は、お見積書を修正・更新するためにアイテムID（例：＃11552）と予定購入数量を教えていただければ幸いです。");
define("FS_QUOTE_INQUIRY_16", "メールを送る");
define("FS_QUOTE_INQUIRY_17", "ショッピングカートを印刷");
define("FS_QUOTE_INQUIRY_18", "見積もりとして印刷");
define("FS_QUOTE_INQUIRY_19", "この見積もりを変更する必要がありますか？");
define("FS_QUOTE_INQUIRY_20", "アイテム");
define("FS_QUOTE_INQUIRY_21", "製品リストをアップロード");
define("FS_QUOTE_INQUIRY_22", "製品リスト：");
define("FS_QUOTE_INQUIRY_23", "お見積依頼 ");//后面接询盘号
define("FS_QUOTE_INQUIRY_24", "のステータスが更新されました。もう一度チェックしてください。");
define("FS_QUOTE_INQUIRY_25", "POの関連ファイルをアップロードしてください。");
define("FS_QUOTE_INQUIRY_26", "コメント（任意）");
define("FS_QUOTE_INQUIRY_28", "コンテンツ");

//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_COMMON_DHL','DHL Economy Select®');

define('FS_CHECKOUT_PAY_01','お支払う');

//详情页新文件标记
define('FS_NEW_FILE_TAG','新着');

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','への変更が正常に送信されました。');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','マイ正式見積り');

define('FS_XING_HAO', '*');

//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7,
			South China International Logistics Center,
			Longhua District,
			Shenzhen, 518109, China
');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7,
			Am Gfild 7,
			85375, Neufahrn bei Munich,
			Germany
');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM INC ");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			380 CENTERPOINT BLVD, 
			NEW CASTLE, DE 19720, 
			United States');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tel: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tel: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST Reg No.: 201818919D');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tel: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');


define('FS_ORDERS_TRACKING_NINJA_STATUS1', 'ご注文製品のパッケージは既にピックアップされましたーFS');
define('FS_ORDERS_TRACKING_NINJA_STATUS2', '今のところで対象パッケージはNinja Van倉庫により処理中です-Ninja Van仕分け施設');
define('FS_ORDERS_TRACKING_NINJA_STATUS3', 'ご注文は輸送中です。');
define('FS_ORDERS_TRACKING_NINJA_STATUS4', '配達完了');

//账户中心确认收货弹窗
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'注文レビュー');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "FSにお買い物を頂きまして有難うございます。");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "貴方のレビューは他の顧客にとって価値がありますので、貴方からのレビューを心からお待ちしております。<br />下のボタンをクリックして、レビューを残してください！");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "今じゃない");
define('FS_FOOTER_COOKIE_TIP_NEW','弊社はクッキーを使用して、お客様にWebサイトでの最高の体験を提供することを確保しています。「クッキーを受け入れる」をクリックするか、このサイトを引き続き使用することにより、<br /><a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">クッキーポリシー</a>に従ってクッキーを使用することに同意したことになります。<a href="javascript:;" class="refuse_cookie_btn_google">ここ</a>でクッキーの使用を拒否できます。');
define('FS_FOOTER_COOKIE_TIP_BTN','クッキーを受け入れる');


//新增俄罗斯仓库
define("FS_WAREHOUSE_RU","ロシア倉庫");
define('FS_RU_NOTICE',"モスクワにあるFSロシア倉庫は即日出荷をサポートしています。<a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>もっと見る</a>");
define('FS_COMMON_WAREHOUSE_RU','《FiberStore.COM》Ltd.<br>
            No.4062, d. 6, str. 16<br>
            Proektiruemyy proezd<br>
            Moscow 115432<br>
            Russian Federation<br>
            Tel: +7 (499) 643 4876');
define("FS_WAREHOUSE_AREA_TIME_48","ご都合の良い時間でロシア倉庫にパッケージをピックアップ");
define("FS_WAREHOUSE_AREA_SHIP_RU","ロシア倉庫から出荷");
define("FS_WAREHOUSE_AREA_RU","ship from RU Warehouse");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s 販売数');
define('FS_PRODUCTS_SALES_REVIEW', '%s レビュー');
define('FS_PRODUCTS_SALES_REVIEWS', '%s レビュー');


define('FS_REVIEWS_TAG_01', 'レビュー');
define('FS_REVIEW_NEW_15', '画像をクリックして、あと');
define('FS_REVIEW_NEW_16', 'タグを付けます');
define('FS_REVIEW_NEW_17', '保存する');
define('FS_REVIEW_NEW_18', 'タグの編集');
define('FS_REVIEW_NEW_19', '最近の注文');
define('FS_REVIEW_NEW_20', 'ご注文を見つかりません');
define('FS_REVIEW_NEW_21', '確認する');
define('FS_REVIEW_NEW_22', 'クリックで商品ID/タイトルを入力');
define('FS_REVIEW_NEW_23', '製品ID/タイトルを入力してください。');
define('FS_REVIEW_NEW_24', '製品にタグ付けする');
define('FS_REVIEW_NEW_25', '全てのカスタマーギャラリーを見る');
define('FS_REVIEW_NEW_26', 'タグ');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', 'アイテムスポットライト');
define('FS_PRODUCT_COMMUNITY_01', 'コミュニティ');
define('FS_PRODUCT_COMMUNITY_02', 'アイディア');
define('FS_PRODUCT_COMMUNITY_03', 'S5860-20SQスイッチの開封| FS');
define('FS_PRODUCT_COMMUNITY_04', 'S5860-20SQスイッチのIxiaRFC2544テスト| FS');
define('FS_PRODUCT_COMMUNITY_05', 'S5860-20SQ：製品ビデオ| FS');
define('FS_PRODUCT_COMMUNITY_06', 'FSスイッチをCiscoスイッチに接続する方法| FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', '電源とファンの交換方法について | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', '製品ハイライト');

define('FS_PRODUCT_HIGHLIGHTS_01', '製品ハイライト');


//报价PDF语言包
define('FS_QUOTES_PDF_01', '公式見積');
define('FS_QUOTES_PDF_01_TAX', '公式見積（税抜）');
define('FS_QUOTES_PDF_02', 'RQ番号');
define('FS_QUOTES_PDF_03', '作成者');
define('FS_QUOTES_PDF_04', '1. 本見積り書は15日間のみ有効ですので、有効期限が切れたらご専属のアカウントマネージャーに再度お問い合わせください。');
define('FS_QUOTES_PDF_05', '2. この注文を支払う際は、RQ番号または会社名のメッセージを残してください。');
define('FS_QUOTES_PDF_TOTAL_TAX', '合計（税抜）');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "ご見積依頼は送信されました。お見積もり依頼");
define('EMAIL_QUOTES_SUCCESS_02', 'を受け取りましたので、1営業日以内に見積もりの詳細をメールでお知らせ致します。');
define('EMAIL_QUOTES_SUCCESS_03', '追加コメント');
define('EMAIL_QUOTES_SUCCESS_05', 'マイアカウントで確認');
define('EMAIL_QUOTES_SUCCESS_06', '見積書を取得');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'この見積もりは「アカウント/お見積」で確認して、注文に転換することができます。');
define('EMAIL_QUOTES_SHARE_02', '製品の構成、価格、又は見積もりの​​他の内容について質問がある場合は、');
define('EMAIL_QUOTES_SHARE_03', 'アカウントマネージャーにお問い合わせください。');
define('EMAIL_QUOTES_SHARE_04', '見積もりの更新');
define('EMAIL_QUOTES_SHARE_05', 'FS.COMからの新規見積りを受信しました。');


//报价详情页语言包
define('FS_QUOTES_DETAILS_01', '在庫、納期、推定税額、送料は変更される場合があり、決済時に再計算されます。');
define('FS_QUOTES_DETAILS_02', '決済');
define('FS_QUOTES_DETAILS_03', '以下は見積もりの詳細です。該当お見積は$TIMEまで有効です。');
define('FS_QUOTES_DETAILS_04', 'お見積り依頼#:');
define('FS_QUOTES_DETAILS_05', '見積をダウンロード');
define('FS_QUOTES_DETAILS_06', 'お見積もり依頼日:');
define('FS_QUOTES_DETAILS_07', 'お見積もり発行日:');
define('FS_QUOTES_DETAILS_08', 'お客様ID：');
define('FS_QUOTES_DETAILS_09', 'No.#');
define('FS_QUOTES_DETAILS_10', 'アカウントマネージャー：');
define('FS_QUOTES_DETAILS_11', '電話番号#：');
define('FS_QUOTES_DETAILS_12', 'お届け先');
define('FS_QUOTES_DETAILS_13', '配送方法: ');
define('FS_QUOTES_DETAILS_14', '請求先');
define('FS_QUOTES_DETAILS_15', 'お支払い方法:');
define('FS_QUOTES_DETAILS_16', '全て見る');
define('FS_QUOTES_DETAILS_17', 'お見積照合');
define('FS_QUOTES_DETAILS_18', '申し訳ありませんが、この製品は削除され、購入できなくなりました。');
define('FS_QUOTES_DETAILS_19', '長さ: ');
define('FS_QUOTES_DETAILS_20', 'もっと');
define('FS_QUOTES_DETAILS_21', 'このアイテムには、次の製品が含まれます');
define('FS_QUOTES_DETAILS_22', '付加価値税（Vat）/税金:');
define('FS_QUOTES_DETAILS_23', '該当お見積は$TIMEに期限切れになりましたので、必要に応じて再度依頼することが可能です。');
define('FS_QUOTES_DETAILS_24', 'この見積は注文に転換されました。');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','お見積履歴');

define('QUOTES_LIST_TIME_TYPE_1', '全てのお見積');
define('QUOTES_LIST_TIME_TYPE_2', '直近1ヶ月');
define('QUOTES_LIST_TIME_TYPE_3', '直近3ヶ月');
define('QUOTES_LIST_TIME_TYPE_4', '直近12ヶ月');
define('QUOTES_LIST_TIME_TYPE_5', '一年前');

define('QUOTES_LIST_STATUS_TYPE_1', 'オンライン見積');
define('QUOTES_LIST_STATUS_TYPE_2', '有効なお見積');
define('QUOTES_LIST_STATUS_TYPE_3', '購入済み');
define('QUOTES_LIST_STATUS_TYPE_4', '期限切れ');
define('QUOTES_LIST_STATUS_TYPE_5', 'オフライン見積');
define('QUOTES_LIST_STATUS_TYPE_6', '全てのお見積');

define('QUOTES_LIST_RESULT_SINGULAR', '件の結果');
define('QUOTES_LIST_RESULT_PLURAL', '件の結果');
define('QUOTES_LIST_UPDATE_TIME', '価格は$TIMEに更新されました。');
define('QUOTES_LIST_EXPIRE_TIME', '該当お見積は$TIMEに期限切れです。');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', '該当お見積は$TIMEに期限切れです。');
define('QUOTES_LIST_QUOTE_AGAIN', '見積を再依頼する');
define('QUOTES_LIST_VIEW_ORDERS', '注文履歴一覧');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', '見積番号#、注文詳細などで検索してください');

define('FS_SHOPPING_CART_CREATE_QUOTE', '見積依頼書を生成');
define('FS_QUOTES_ORDERS_NUMBER', '注文番号');
define('QUOTES_LIST_EMPTY_TIPS', 'お見積が見つかりません。');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - お見積依頼$NUMは既に受領されました。');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - お友達$EMAILは見積を共有しました。');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', '送料と税金に関しては決済ページに表示および説明が載せてあります。');


define('FS_RECENT_SEARCH', '最近の検索');
define('FS_HOT_SEARCH', '人気キーワード検索');
define('FS_CHANGE', '更新する');

define('FS_VIEW_WORD', '詳細');

//一级分类页
define('FS_CATEGORIES_POPULAR', '人気のカテゴリ');
define('FS_CATEGORIES_BEST_SELLERS', '人気商品');
define('FS_CATEGORIES_NETWORK', 'ネットワークアセンブリ');
define('FS_CATEGORIES_DISCOVERY', 'ディスカバリー');


define('CARD_NOT_SUPPORT', 'このお支払い方法はサポートされていませんので、別の種類のクレジットカードを入力してください。');
//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','FSサポート');


define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '「###SEARCH_WORD###」<span class="new_proList_proListNtit">に関する結果がございませんので、</span>「###RECOMMEND_WORD###」<span class="new_proList_proListNtit">の検索結果を表示しています。</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'もしかして<a target="_blank" href="###HREF_LINK###">###RECOMMEND_WORD###</a>');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', '以下の同類後継製品をご参考してください。');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', '以下の同類製品をご参考してください。');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', '以下のカスタム製品をご参考してください。');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', '必要なものが見つかりませんか？いつでもお問い合わせてください。');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" はオンラインでご利用いただけなくなりましたが、弊社は引き続き技術サービスを提供しております。もっと詳しい情報は<a  style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">販売中止ポリシー</a>をご参照ください。');
//信用卡语言包
define("CREDIT_CARD_ERROR_303","支払い拒否-発行銀行から他の情報が提供されていません。");
define("CREDIT_CARD_ERROR_606","発行銀行はこのタイプのトランザクションを許可しません。");
define("CREDIT_CARD_ERROR_08","CVV2/CID/CVC2データは検証されていません。");
define("CREDIT_CARD_ERROR_22","クレジットカード番号が無効です。");
define("CREDIT_CARD_ERROR_25","有効期限切れです。");
define("CREDIT_CARD_ERROR_26","無効な金額です。");
define("CREDIT_CARD_ERROR_27","無効なカード所有者です。");
define("CREDIT_CARD_ERROR_28","無効な承認番号です。");
define("CREDIT_CARD_ERROR_31","無効な検証文字列です。");
define("CREDIT_CARD_ERROR_32","無効なトランザクションコードです。");
define("CREDIT_CARD_ERROR_57","無効な参照番号です。");
define("CREDIT_CARD_ERROR_58","無効なAVS文字列、AVS文字列の長さが最大値40桁を超えました。");
define('CREDIT_CARD_ERROR_260','ネットワークエラーのため、一時的にサービスをご利用いただけません。しばらく待ってから再度試して、またはアカウントマネージャーに連絡してください。');
define('CREDIT_CARD_ERROR_301','ネットワークエラーのため、一時的にサービスをご利用いただけません。しばらく待ってから再度試して、またはアカウントマネージャーに連絡してください。');
define('CREDIT_CARD_ERROR_304','アカウントが見つかりませんため、情報を再度確認して、または発行銀行にお問い合わせください。');
define('CREDIT_CARD_ERROR_401','発行銀行はカード所有者と音声通話することを要求します。発行銀行に電話してください。');
define('CREDIT_CARD_ERROR_502','カードは紛失/盗難したことが報告されます。発行銀行ご連絡してください。注：American Expressには適用されません。');
define('CREDIT_CARD_ERROR_505','アカウントのクレジットファイルは無効です。別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_509','アクティビティ数の制限を超えていますので、別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_510','アクティビティ数の制限を超えていので、別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_519','アカウントのクレジットファイルは無効です。別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_521','お支払い金額は与信限度額を超えていので、別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_522','カードの有効期限が切れています。有効期限を確認して、または別のお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_530','発行銀行から提供された情報が不足していますので、銀行に連絡して、または別の支払い方法を試してください。');
define('CREDIT_CARD_ERROR_531','発行銀行は認証要求を拒否しました。発行銀行に連絡して、または別の支払い方法を試してください。');
define('CREDIT_CARD_ERROR_591','発行銀行によるお支払いエラーです。発行銀行に連絡して、または別のカードを試してください。');
define('CREDIT_CARD_ERROR_592','発行銀行によるお支払いエラーです。発行銀行に連絡して、または別のカードを試してください。');
define('CREDIT_CARD_ERROR_594','発行銀行によるお支払いエラーです。発行銀行に連絡して、または別のカードを試してください。');
define('CREDIT_CARD_ERROR_776','トランザクションが重複していますので、アカウントマネージャーに連絡して、取引状況を確認してください。');
define('CREDIT_CARD_ERROR_787','リスクが高いため、取引は拒否されますので、別のお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_806','該当カードが制限されていますので、別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_825','アカウントが見つかりませんため、情報を確認して、再度お試しください。');
define('CREDIT_CARD_ERROR_902','ネットワークエラーのため、一時的にサービスをご利用いただけません。しばらく待ってから再度試して、またはアカウントマネージャーに連絡してください。');
define('CREDIT_CARD_ERROR_904','該当カードは有効化されていませんため、発行銀行にお問い合わせください。');
define('CREDIT_CARD_ERROR_201','口座番号/フォーマットが正しくありませんため、番号を確認して、再度お試しください。');
define('CREDIT_CARD_ERROR_204','未知のエラーです。しばらく待ってから再度試して、または別の支払い方法に変更してください。');
define('CREDIT_CARD_ERROR_233','クレジットカード番号がお支払い方法と一致しなく、またはBINが無効です。別のカードまたはお支払い方法をお試しください。');
define('CREDIT_CARD_ERROR_239','該当カードは対応されていませんため、別のカードを試して、または他の支払い方法を選択してください。');
define('CREDIT_CARD_ERROR_261','口座番号/フォーマットが正しくありませんため、番号を確認して、再度お試しください。');
define('CREDIT_CARD_ERROR_351','ネットワークエラーのため、一時的にサービスをご利用いただけません。しばらく待ってから再度試して、またはアカウントマネージャーに連絡してください。');
define('CREDIT_CARD_ERROR_755','アカウントが見つかりませんため、情報を再度確認して、または発行銀行にお問い合わせください。');
define('CREDIT_CARD_ERROR_758','アカウントが凍結されています。発行銀行に連絡して、または別の支払い方法を試してください。');
define('CREDIT_CARD_ERROR_834','該当カードは対応されていませんため、別のカードまたはお支払い方法をお試しください。');
define('HISTORY_TIPS', 'オフライン見積を選択してアカウントマネージャーによって作成されたお見積書を確認できます。');
define('TIPS_BUTTON', '了解！');

define('FS_CHECKOUT_EPIDEMIC_TIPS', '行政措置により、配達が遅れたり制限されたりする場合がありますので、うまく配達できるため商品の受け取りをご注意くださいますようお願いたします。そうでない場合、荷物は荷送人に返送されることもありますが、ご了承ください。');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', '通関の理由により、お届けが遅れる場合があります。');

define('QUOTES_NOTE_TITLE','ご注意ください:');
define('QUOTES_NOTE_TIPS','在庫、納期及び送料は変更される場合があり、決済時に再計算されます。');
define('QUOTES_RQN_NUMBER_TITLE','RQN番号:');
define('QUOTES_TRADE_TERM_TITLE','取引条件:');
define('QUOTES_PAYMENT_TERM_TITLE','お支払方法:');
define('QUOTES_SHIP_VIA_TITLE','配送方法:');
define('QUOTES_DATE_ISSUED_TITLE','発行日:');
define('QUOTES_EXPIRES_TITLE','有効期限:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','アカウントマネージャー:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','メールアドレス:');
define('QUOTES_DELIVER_TO','お届け先');
define('QUOTES_BILLING_TO','ご請求先');
define('QUOTES_QUOTE_TITLE1','製品');
define('QUOTES_QUOTE_TITLE2','数量');
define('QUOTES_QUOTE_TITLE3','単価');
define('QUOTES_QUOTE_TITLE4','合計');

define('FS_WHAT_IS_DIFFERENCE',"相違点");
define('FS_AVAILABILITY','販売状況');
define('FS_ON_SALE','販売中');
define('FS_END_SALE','販売中止');
define('FS_DIFFERENCES', 'ご購入する前に、詳細なパラメータを慎重にチェックして、製品の相違点を十分に理解してください。');

define('FS_CN_LIMIT_TIPS', '当商品は中国に発送できませんのでご注意ください。');
define('QUOTE_MESSAGE_TXT_1', ''. $_SESSION['customer_first_name'].'さんからのコメント');
define('QUOTE_MESSAGE_TXT_2', 'FSアカウントマネージャーからのコメント');
