<?php 
//Content in account left slide
//2016-9-8      add by Frankie 
define('MY_ACCOUNT','私のアカウント');
define('ORDER_CENTER','注文センター');
define('ALL_ORDER','すべての注文');
define('PENDING_ORDER','保留中の注文');
define('TRANSACTION','取引注文');
define('CANCELED_ORDER','キャンセルした注文');
define('EXCHANGE','返品');

define('MY_ADDRESS','私のアドレス');
define('NEWSLETTER','ニュースレター');
define('CHANGE_PASSWORD','パスワードを変更する');
define('MY_REVIEWS','私のレビュー');
define('MY_QUESTION','私の質問');
define('MY_SALES_REPRESENTIVE','私のアカウントマネージャー');
define('MY_CONTACT','お問い合わせ');
define('FS_CONTACT_HELP','何かお手伝いでき<br> ますでしょうか？');
define('FS_CONTACT_CHAT','今 Chat Live');

//2017.5.12   add  by ery
define('ACCOUNT_LEFT_EDIT','アカウントを編集する');
define('ACCOUNT_LEFT_ORDER','注文履歴');
define('ACCOUNT_LEFT_ADDRESS','アドレス');
define('ACCOUNT_LEFT_QUESTION','質問');
define('ACCOUNT_LEFT_MANAGE','購読を管理する');
define('ACCOUNT_LEFT_MY_QUOTES','マイ見積り');

define('ACCOUNT_LEFT_QUOTATION','有効な見積');
define('ACCOUNT_LEFT_QUOTATION_DETAIL','有効な見積詳細');

// 2018.11.29 fairy 个人中心改版
define('FS_MY_ACCOUNT','マイアカウント');
define('ACCOUNT_SETTING','アカウント設定');
define('FS_RETURN_ORDERS','返品注文');
define('FS_MY_QUOTES','マイ見積り');
define('FS_WISH_LIST','希望リスト');
define('FS_MY_CASES','マイケース');
define('FS_ADDRESS_BOOK','アドレス帳');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">ホームページ</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">に戻る</a>');

// english.php
define("FS_COMMON_CONTINUE",'続ける');
define("FS_COMMON_OPERATION",'操作');
define('FS_COMMON_VIEW','表示');
define('FS_PURCHASE_ORDER_NUMBER','注文番号');
define('FS_FILE_UPLOADED_SUCCESS','ファイルはアップロードしました。');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","許されたファイルタイプ: PDF、JPG、PNG。");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","許されたファイルタイプ: PDF、JPG、PNG。 <br/>最大ファイルサイズは4MBです。");
define("FS_UPLOAD_PO_FILE",'POファイルを添付');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','FS.COMでお買い物を頂きまして誠にありがとうございます。また今後のご訪問をお待ちしております。');

// 表单验证
define("ADDRESS_PLACE_HODLER","通り、気付（～様方）");
define("ADDRESS_PLACE_HODLER2","アパート名、部屋名、建物名、その他");
define("FS_ZIP_CODE","郵便番号");
define("FS_ADDRESS","住所");
define("FS_ADDRESS2","住所 2");
define('FS_CHECK_COUNTRY_REGION','お国/地域');
define("FS_CHECKOUT_ERROR1","姓をご入力ください。");
define("FS_CHECKOUT_ERROR2","名をご入力ください。");
define("FS_CHECKOUT_ERROR3","住所は必須です。");
define("FS_CHECKOUT_ERROR4","郵便番号をご入力ください。");
define("FS_CHECKOUT_ERROR5","市名をご入力ください。");
define("FS_CHECKOUT_ERROR6","所在国をご入力ください。");
define("FS_CHECKOUT_ERROR7","電話番号は必須です。");
define("FS_CHECKOUT_ERROR8","VAT/TAX番号は必須です。");
define("FS_CHECKOUT_ERROR9","州名をご入力ください。");
define("FS_CHECKOUT_ERROR10","会社名をご入力ください。");
define("FS_CHECKOUT_ERROR11","有効なTAX/VAT 例えば:DE123456789");
define("FS_CHECKOUT_ERROR12","お届け先の住所は最小で4文字を入力しなければならなりません。");
define("FS_CHECKOUT_ERROR13","苗字は最小で2文字を入力しなければなりません。");
define("FS_CHECKOUT_ERROR14","名前は最小で2文字を入力しなければなりません。");
define("FS_CHECKOUT_ERROR15","郵便番号は最小で3文字を入力しなければなりません。");
define("FS_CHECKOUT_ERROR16","私たちは宅配ボックスに配達できかねます。");
define("FS_CHECKOUT_ERROR17","住所タイプは必須です。");
define("FS_CHECKOUT_ERROR28","有効な郵便番号を記入してください。");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","住所2の長さは4～35文字にしなければなりません。");
define("FS_CITY_MIN_MAX_TIP","住所2の長さは1～50文字にしなければなりません。");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','すべての注文');
define('FS_ORDER_PENDING','保留中');
define('FS_ORDER_COMPLETED','完了した');
define('FS_ORDER_CANCELLED','キャンセルした');
define('FS_ORDER_PURCHASE','購入');
define('FS_ORDER_PROGRESSING','進行中');
define('FS_ORDER_RETURN_ITEM','返却対象品');

define('FS_FILE_UPLOADED_SUCCESS_TXT','ファイルが添付されました。');