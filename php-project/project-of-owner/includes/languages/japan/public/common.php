<?php
// 公共的语言包都放到这里

// classic/breadcrumb.php
define('FALLWIND','fallwind');

// classic/order.info.php
//Content in My_dashboard
//2016-9-6 add by frankie
define('FIBERSTORE_ORDER_STATUS','Estado del pedido');
define('FIBERSTORE_VIEW_DETAILS','Ver detalles');
define('FIBERSTORE_ORDER_NUMBER','Número del pedido');
define('FIBERSTORE_ORDER_CUSTOMER_NAME','Nombre del cliente');
define('FIBERSTORE_ORDER_TOTAL','合計金額');
define('FIBERSTORE_ORDER_PAYMENT','pago');
define('FIBERSTORE_DASHBOARD_NO_ORDER','No tienes pedidos.');



// classic/show_dialog.php
//2017.5.26		ADD		ERY
define('FS_DIALOG_ASK','Ask ');
define('FS_DIALOG_A',' a question');
define('FS_DIALOG_TITLE','Title');
define('FS_DIALOG_YOUR','Your question subject is required');
define('FS_DIALOG_CONTENT','備考');
define('FS_DIALOG_PLEASE','Please enter your questions');
define('FS_DIALOG_YOUR2','Your content is required');
define('FS_DIALOG_PLEASE1',"Please don't exceed 3,000 characters.");
define('FS_DIALOG_EMAIL','E-mail address');
define('FS_DIALOG_AGAIN','This specified e-mail is invalid , please correct it and try again');
define('FS_DIALOG_COMMENTS','Comments/Questions');
define('FS_DIALOG_THIS','This field is required, Please write at least 10 characters.');


// common/account_left_slide.php
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
define('FS_ADDRESS_BOOK','アドレス帳');

//列表页面为空跳转
define('FS_MEMBER_LIST_EMPTY_PAGE_JUMP','<span class="alone_Special">ホームページ</span> <a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">に戻る</a>');

// english.php
define("FS_COMMON_CONTINUE",'続ける');
define("FS_COMMON_OPERATION",'操作');
define('FS_COMMON_VIEW','表示');
define('FS_PURCHASE_ORDER_NUMBER','発注書番号');
define('FS_FILE_UPLOADED_SUCCESS','ファイルはアップロードしました。');
define("MANAGE_ORDER_UPLOAD_FORMAT_ERROR","許されたファイルタイプ: PDF、JPG、PNG。");
define("MANAGE_ORDER_UPLOAD_ERROR_NEW","許されたファイルタイプ: PDF、JPG、PNG。 <br/>最大ファイルサイズは4MBです。");
define("FS_UPLOAD_PO_FILE",'POファイルを添付');

// 2018.12.7 fairy
define('F_RECEIPT_CONFIRMATION_SUCCESS_TIP','FSでお買い物を頂きまして誠にありがとうございます。また今後のご訪問をお待ちしております。');

// 表单验证
define("ADDRESS_PLACE_HODLER","アパート名、部屋名、組織名、 ユニット名など");
define("ADDRESS_PLACE_HODLER2","通り、建物名、階、気付（～様方）");
define("FS_ZIP_CODE","郵便番号");
define("FS_ADDRESS","アドレス");
define("FS_ADDRESS2","アドレス 2");
define('FS_CHECK_COUNTRY_REGION','お国/地域');
define("FS_CHECKOUT_ERROR1","姓をご入力ください。");
define("FS_CHECKOUT_ERROR2","名をご入力ください。");
define("FS_CHECKOUT_ERROR3","アドレスは必須です。");
define("FS_CHECKOUT_ERROR4","郵便番号をご入力ください。");
define("FS_CHECKOUT_ERROR5","市名をご入力ください。");
define("FS_CHECKOUT_ERROR6","所在国をご入力ください。");
define("FS_CHECKOUT_ERROR7","電話番号は必須です。");
define("FS_CHECKOUT_ERROR8","VAT/TAX番号は必須です。");
define("FS_CHECKOUT_ERROR9","州名をご入力ください。");
define("FS_CHECKOUT_ERROR10","会社名をご入力ください。");
define("FS_CHECKOUT_ERROR11","有効なTAX/VAT 例えば:DE123456789");
define("FS_CHECKOUT_ERROR12","お届け先の住所は最小で4文字を入力しなければならなりません。");
define("FS_CHECKOUT_ERROR13","姓は最小で2文字を入力しなければなりません。");
define("FS_CHECKOUT_ERROR14","名は最小で2文字を入力しなければなりません。");
define("FS_CHECKOUT_ERROR15","3文字以上ご入力ください。");
define("FS_CHECKOUT_ERROR16","私たちは宅配ボックスに配達できかねます。");
define("FS_CHECKOUT_ERROR17","アドレスタイプは必須です。");
define("FS_CHECKOUT_ERROR28","有効な郵便番号を記入してください。");
define("FS_ADDRESS_LINE_TWO_MIN_MAX_TIP","4文字以上35文字以内でご入力ください。");
define("FS_CITY_MIN_MAX_TIP","住所2の長さは1～50文字にしなければなりません。");

// 订单和退换货公共的导航
define('FS_ORDER_ALL','全ての注文');
define('FS_ORDER_PENDING','保留中');
define('FS_ORDER_COMPLETED','完了した');
define('FS_ORDER_CANCELLED','キャンセルした');
define('FS_ORDER_PURCHASE','掛け買い注文');
define('FS_ORDER_PROGRESSING','進行中');
define('FS_ORDER_RETURN_ITEM','返却対象品');

define('FS_FILE_UPLOADED_SUCCESS_TXT','ファイルが添付されました。');


// common/common_service.php
define('COMMON_SERVICE_01','お問い合わせ');
define('COMMON_SERVICE_02','FSは、データセンター、エンタープライズ及び光伝送ネットワークソリューションに注力し、必要なものを正確に構築するのに役立ちます。<br> 連絡を取り合うと、24時間体制で対応致します。');
define('COMMON_SERVICE_03','FSへアクセス方法をもっと探しましょう');
define('COMMON_SERVICE_04','オンラインチャット');
define('COMMON_SERVICE_05','私たちは24時間体制で対応します。迅速な対応のために今すぐメッセージをください。');
define('COMMON_SERVICE_06','今すぐチャットする');
define('COMMON_SERVICE_07','電話をかける');
define('COMMON_SERVICE_08','までお電話ください。');
define('COMMON_SERVICE_09','または、こちらからお電話させて頂いてくだい。');
define('COMMON_SERVICE_10','今すぐ電話する');
define('COMMON_SERVICE_11','電子メールを送る');
define('COMMON_SERVICE_12','当社のカスタマーサービスチームは、できるだけ早くご対応いたします。');
define('COMMON_SERVICE_13','今すぐメールする');
define('COMMON_SERVICE_14','テクニカルサポート');
define('COMMON_SERVICE_15','オンラインでプロジェクトの無料サポート&amp;ソリューション設計をお試しください。');
define('COMMON_SERVICE_16','サポートリクエスト');
define('FS_SHOP_CART_ALERT_JS_13','発信者*');
define('FS_SHOP_CART_ALERT_JS_14','受信者*');
define('FS_SHOP_CART_ALERT_JS_15','個人情報(任意):');
//quote
define('FS_VIEW_QUOTE_SHEET','見積シートを見る');
define('FS_PRODUCT_HAS_BEEN_ADDED','該当製品が既に追加されました。');
define('FS_SAVE_CSRT_LIMIT_TIP','カート名は50文字以内でご入力ください。');
define('FS_QUOTE','お見積もり');
define('FS_SAVED_CART_EMAIL','メール');




// common/footer.php文件
/*底部共用文件*/
// fallwind	2016.8.24	add
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理
// footer computer
define('FS_FOOTER_ABOUT_FS','弊社について');
define('FS_ABOUT_FS_COM','当社について');
define('FS_FOOTER_WHY_US','FSを選ぶのはなぜですか');
define('LATEST_NEWS','最新ニューズ');
define('FS_FOOTER_LATEST','ニュースルーム');
define('FS_FOOTER_CONTACT_US','お問い合わせ');
// Frankie 2018.1.22
define('FS_IMPRINT','Legal Notice');

// footer Customer Service
define('FS_FOOTER_CUSTOMER_SERVICE','迅速なアクセス');
define('FS_FOOTER_OEM','OEM & カスタム');
//fallwind	2017.5.10	tpl_footer.php
define('FS_OEM_AMP_CUSTOM',"OEM &amp; カスタマイズ");
define('FS_FOOTER_WARRANTY','保証');
define('FS_FOOTER_POLICY','返品ポリシー');
define('FS_RETURN_POLICY','返品規則');
define('FS_FOOTER_QUALITY','品質管理');
define('FS_FOOTER_PARTNER','法人アカウント');
define("FS_DAY_RETURN_POLICY","返品規則");


// footer Payment & Shipping
define('FS_FOOTER_PAY_SHIP','お支払方法＆配送方式');
define('FS_PAYMENT_METHODS','お支払方法');
define('FS_NET_AMP_W',"発注書（PO）");
define('FS_FOOTER_DELIVERY','出荷＆配達');

// footer Quick Help
define('FS_FOOTER_QUICK_HELP','クイッククリック');
define('FS_FOOTER_PURCHASE_HELP','ショッピングヘルプ');
define('FS_FORGOT_YOUR_PASSWORD','パスワードをお忘れの方はこちら');
define('FS_FOOTER_FORGET_PASS','パスワードを忘れた？');
define('FS_FOOTER_FAQ','よくあるご質問');
define('FS_SHIPPING_DELIVERY','サポート');

// footer Questions? Aron 2017.8.6
define("FS_YAO1","ご依頼・ご相談・お見積りなど、お気軽にお問い合わせください。<br/>【日本語受付時間】10:30～19:30（土日を除く）");
define("FS_YAO2","私たちは助ける為に24/7ここにいる");
define("FS_YAO3","Live Chat");
define("FS_YAO4","ライブ代表とチャット");

// Popular
define('FS_FOOTER_POPULAR_PAGES','Popular Pages:');    //小语种没有这个

// 手机站切换版本
define('FS_FULL_SITE','メールサポート');
define('FS_MOBILE_SITE','Mobile Site');
define('FS_FOOTER_LIVE_CHAT','Live Chat');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
define("FS_HIGH_QUALITY","高品質");
define("FS_SAFE_SHOPPING","安全ショッピング");
define("FS_FAST_DELIVERY","RETURN_DAYS日間返品");

// 版权相关
define('FS_PRIVACY_AND_POLICY',"プライバシーとクッキー");
define('FS_TERMS_OF_USE',"利用規約");
define('FS_TERMS_OF_USE_DE',"利用規約");
define('FS_SITE_MAP','サイトマップ');
define('FS_FOOTER_FEEDBACK','お客様の声');
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版 新增
//define("FS_FOOTER_COPYRIGHT","著作権©2009-YEAR FiberStore Co., Limitedはすべての権利を留保します。");
define("FS_FOOTER_COPYRIGHT","Copyright &copy; 2009-YEAR ".FS_CN_COMPANY_NAME." All Rights Reserved. ");
define("FS_FOOTER_COPYRIGHT_M","著作権©2009-YEAR <span>".FS_LOCAL_COMPANY_NAME." </span>リミテッド全著作権所有。");
define('FS_FOOTER_REQUEST_A_SAMPLE','サンプルのお貸し出し');
define("FS_HLEP_CENTER","FSサポート");
define('FS_FIBERSTORE_WITH_PARTNERS','パートナー');



// common/header.php文件
/* tpl_header.php */
// Make by Frankie  2016-8-19
// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 整理

// 配置文件 start
define('FS_SITE_UNIQUE_LANGUAGE_ID','8');
// 配置文件 end

// 在线聊天html代码 - 旧，现在可能不用了
define('FS_CHAT_NOW','今すぐチャットする');
define('FS_ONLINE_CAHT','オンラインチャット');
define('FS_LIVE_CAHT','Live Chat');
define('FS_PRE_SALE','発売前サービス');
define('FS_CHAT_WITH','購入前にオンラインセールスとチャットします。');
define('FS_STAR','チャットを始める');
define('FS_AFTER_SALE','アフターサービス');
define('FS_PL_GO','お客様が購入したい場合は、どうぞ、こちらへ ');
define('FS_MY_ORDER','私の注文');
define('FS_PAGE_TO','ページへ注文詳細のライブヘルプを請求されます。');

//by add helun 2018 5 28 手机版 Hot Search
define('FS_HEADER_SEARCH','検索');
define('FS_HEADER_01','サーチ...');
define('FS_HEADER_02','ホットサーチ');
define('FS_HEADER_03','Cisco 40G QSFP+');
define('FS_HEADER_04','100G QSFP28');
define('FS_HEADER_05','10G SFP+ DAC');
define('FS_HEADER_06','DWDM SFP+');
define('FS_HEADER_07','CWDM DWDM MUX');
define('FS_HEADER_08','MTP MPOケーブル');
define('FS_HEADER_09','LC パッチケーブル');
define('FS_HEADER_10','アッテネータ');
define('FS_HEADER_11','検索履歴');
define('FS_HEADER_12','履歴クリア');

// 2018.7.5/7.14 小语种/英文新版首页上线 fairy 新版
// top
define('FS_HELP_SUPPORT', 'ヘルプ&サポート');
define('FS_CALL_US', '電話してください');
define('FS_SAVED_CARTS', '保存したカート');
// 用户相关
define('FS_ACCOUNT', 'アカウント');
define('FS_SIGN_IN','ログイン');
define('FS_NEW_CUSTOMER','初めてご利用ですか？');
define('FS_REGISTER_ACCOUNT','新規登録はこちら（無料）');
define('FS_SIGN_OUT','サインアウト');
define('FS_MY_ACCOUNT','マイアカウント');
define('FS_MY_ORDERS','マイオーダー');
define('FS_MY_ORDER','マイオーダー');
define('FS_MY_ADDRESS','マイアドレス');
define('FS_SOLUTIONS','ソリューション');
define('FS_ALL_CATEGORIES','全てのカテゴリ');
define('FS_PROJECT_INQUIRY','プロジェクトのお問合せ');
define('FS_SEE_ALL_OFFERINGS','全ての製品を見る');
define('FS_RESOURCES','その他関連リソース');
define('FS_RELATED_INFO','関連情報');
define('FS_CONTACT_US','お問い合わせ');
// 国家选择
define('FS_PRODUCTS_DIFFERENT','国/地域によって製品の価格と可用性は異なる場合があります。');
define('FS_NEW_LANGUAGE_CURRENCY','言語/貨幣');
define('FS_COUNTRY_REGION','国/地域');

//用户相关，新改版 2019/3/29 rebirth.ma
define('FS_MAIN_MENU','メインメニュー');
define('FS_NETWORKING','ネットワーキング');
define('FS_ORDER_HISTORY','注文履歴');
define('FS_ADDRESS_BOOK','アドレス帳');
define('FS_MY_CASES','ケースセンター');
define('FS_MY_QUOTES','マイ見積り');
define('FS_ACCOUNT_SETTING','アカウント設定');
define('FS_VIEW_ALL','全てを見る');

// 搜索
define('FS_SEARCH_PRODUCTS','製品を検索する');
define('FS_NEW_CHOOESE_CURRENCY','貨幣を選んでください');
// 2018.7.23 fairy help
define('FS_NEED_HELP','何かお困りですか？');
define('FS_NEED_HELP_BIG','何かお困りですか？');
define('FS_CHAT_LIVE_WITH_US','チャットサポート');
define('FS_SEND_US_A_MESSAGE','メールサポート');
define('FS_E_MAIL_NOW','今すぐメールしよう');
define("FS_LIVE_CHAT","チャットサポート");
define("FS_LIVE_CHAT_MOBILE","今すぐチャットしよう");
define("FS_WANT_TO_CALL","電話サポート");
define("FS_BREADCRUMB_HOME","ホーム");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','テクニカルサポート');
define('FS_CHAT_LIVE_WITH_GET_A','今すぐ専門家に聞こう');

// 2018.10.6  ery  头部左上角免运费政策弹窗
define('HEADER_FREE_SHIPPINH_01','迅速な配送&簡単な返品');
define('HEADER_FREE_SHIPPINH_02','%s以上の送料無料');//%s不用翻译替换的是价格,如US $79
define('HEADER_FREE_SHIPPINH_03','ご要望なスケジュールと予算に合わせて、より多くの発送オプションがあります。');
define('HEADER_FREE_SHIPPINH_04','即日発送');
define('HEADER_FREE_SHIPPINH_05','当社の複数倉庫システムに基づく大規模な在庫があります。');
define('HEADER_FREE_SHIPPINH_06','30日間の返品');
define('HEADER_FREE_SHIPPINH_07','もし製品に問題があった場合、ほとんどの注文では返品致します');
define('HEADER_FREE_SHIPPINH_08','商品ページに「無料配送」のメッセージが記載されている商品は無料配送の対象となります。FS.COMはいつでもこのオファーを変更する権利を留保します。詳細は<a href="'.zen_href_link('shipping_delivery').'">配送ポリシー</a>または<a href="'.zen_href_link('day_return_policy').'">返品ポリシー</a>をご覧ください。');
define('HEADER_FREE_SHIPPINH_09','国外の配送ですか？適切なポリシーをチェックするには、ウェブサイトの目的国に切り替える必要があります。');
define('HEADER_FREE_SHIPPINH_10','迅速な配送&簡単な返品');
define('HEADER_FREE_SHIPPINH_11','%s以上の送料無料');//%s不用翻译替换的是价格,如79€
define('HEADER_FREE_SHIPPINH_12','ご要望なスケジュールと予算に合わせて、より多くの発送オプションがあります。');
define('HEADER_FREE_SHIPPINH_13','即日発送');
define('HEADER_FREE_SHIPPINH_14','商品ページに「無料配送」のメッセージが記載されている商品は無料配送の対象となります。FS.COMはいつでもこのオファーを変更する権利を留保します。詳細は<a href="'.zen_href_link('shipping_delivery').'">配送ポリシー</a>または<a href="'.zen_href_link('day_return_policy').'">返品ポリシー</a>をご覧ください。');
define('HEADER_FREE_SHIPPINH_15','国外の配送ですか？適切なポリシーをチェックするには、ウェブサイトの目的国に切り替える必要があります。');
define('HEADER_FREE_SHIPPINH_16','310,000+ 在庫');
define('HEADER_FREE_SHIPPINH_17','光学とネットワーク製品に適用し、ご要望に満足する様にします。');
define('HEADER_FREE_SHIPPINH_18','配送時間は在庫によって影響を受ける可能性があります。詳細は <a href="'.zen_href_link('shipping_delivery').'">配送ポリシー</a>または <a href="'.zen_href_link('day_return_policy').'">返品ポリシー</a>をご覧ください。 ');
define('HEADER_FREE_SHIPPINH_19','配送時間は在庫によって影響を受ける可能性があります。詳細は <a href="'.zen_href_link('shipping_delivery').'">配送ポリシー</a>または <a href="'.zen_href_link('day_return_policy').'">返品ポリシー</a>をご覧ください。 ');

//手机端侧边栏政策页
define('FS_PH_HELP_SETTING','ヘルプ & 設定');

// 浏览器
define('FS_UPGRADE','ブラウザをアップグレードする');
define('FS_UPGRADE_TIP','今は古いバージョンのブラウザを使っています。より良い体験のためにブラウザをアップグレードしてください。');
define('BROWSER_CHROME','Chrome');
define('BROWSER_FIREFOX','Firefox');
define('BROWSER_IE','Internet Explorer');
define('BROWSER_EDGE','Edge');

define('FS_TAGIMG_TITLE','ソリューションを探す');
define('FS_INDEX_CATE_PRODUCTS','製品一覧');



// common/left_side_bar_for_tag.php
define('FIBERSTORE_TRANS1','ネットワークデバイスを通じて探す');
define('FIBERSTORE_TRANS2','オリジナルモデルを通じて探す');
define('FIBERSTORE_CLEAR','選択をクリアする');



// common/patch_panel.php
define('PATCH_PANEL_01','どのようにより多くのサポートが得られますか？');
define('PATCH_PANEL_02','FSは、データセンター、エンタープライズ、光伝送ネットワークソリューションに注力し、必要なものを正確に構築するのに役立ちます。');
define('PATCH_PANEL_03','<a href="mailto:tech@fs.com">tech@fs.com</a>または<a href="mailto:jp@fs.com">jp@fs.com</a>まで電子メールでお問い合わせください。');



// common/phone.php
//各国电话语言包 2017.8.18  ery

define('FS_PHONE_DE','+49 (0) 8165 80 90 517');		// Germany
define('FS_PHONE_HK','+(852) 5808 7203');		// Hong Kong
define('FS_PHONE_MX','+52 (55) 3098 7566');		// Mexico
define('FS_PHONE_CA','+1 (647) 243 6342');		// Canada
define('FS_PHONE_BR','+55 (11) 4349 6175');		// Brazil
define('FS_PHONE_AR','+54 (11) 5031 9542');		// Argentina
define('FS_PHONE_GB','+44 (0) 121 716 1755');	// United Kingdom
define('FS_PHONE_FR','+33 (1) 82 884 336');		// France
define('FS_PHONE_NL','+31 (20) 241 4029');		// Netherlands
define('FS_PHONE_AU','+61 3 9693 3488');		// Australia
define('FS_PHONE_ES','+34 (91) 123 7299');		// Spain
define('FS_PHONE_RU','+7 (499) 643 4876');		// Russian Federation
define('FS_PHONE_SG','+(65) 6443 7951');		// Singapore
define('FS_PHONE_TW','+886 (2) 5592 4011');		// Taiwan
define('FS_PHONE_IT','+44 (0) 121 716 1755');		// Italy
define('FS_PHONE_CH','+41 (43) 508 5909');		// Switzerland
define('FS_PHONE_DK','+45 7876 8321');			// Denmark
define('FS_PHONE_NZ','+64 (9) 985 3566');		// New Zealand
define('FS_PHONE_JP','+81 345888332');			//japan

define('FS_PHONE_SITE_EU','+49 (0) 8165 80 90 517');
define('FS_PHONE_SITE_UK','+44 (0) 121 716 1755');
define('FS_PHONE_SITE_ES','+34 (91) 123 7299');
define('FS_PHONE_SITE_FR','+33 (1) 82 884 336');
define('FS_PHONE_SITE_RU','+7 (499) 643 4876');
define('FS_PHONE_SITE_MX','+52 (55) 3098 7566');
define('FS_PHONE_SITE_AU','+61 3 9693 3488');
define('FS_PHONE_SITE_JP','+81 345888332');
define('FS_PHONE_SITE_SG','+(65) 6443 7951');
if(US_WAREHOUSE_UP){
    define('FS_PHONE_US','+1 (888) 468 7419');		// United States
    define('FS_PHONE_SITE_US','+1 (888) 468 7419');
    define('FS_PHONE_CHECKOUT_US','+1 (888) 468 7419');
}else{
    define('FS_PHONE_US','+1（877）205 5306');		// United States
    define('FS_PHONE_SITE_US','+1 (877) 205 5306 (PST) <br/> +1 (888) 468 7419 (EST)');
    define('FS_PHONE_CHECKOUT_US','+1 (877) 205 5306 (PST) / +1 (888) 468 7419 (EST)');
}
//美东电话
define('FS_PHONE_US_EAST','+1 (888) 468 7419');
//武汉仓电话
define('FS_PHONE_CN','+86 (027) 87639823');



// common/resource.php
//catalog
define('PRODCUT_CATALOGS_01','商品カタログ');
define('PRODCUT_CATALOGS_02','知識ベース');
define('PRODCUT_CATALOGS_03','ソリューション');
define('PRODCUT_CATALOGS_04','製品ビデオ');

define('PRODCUT_CATALOGS_05','すべて');
define('PRODCUT_CATALOGS_06','ネットワーク業務');
define('PRODCUT_CATALOGS_07','ケーブル配線');
define('PRODCUT_CATALOGS_08','WDM & FTTx');
define('PRODCUT_CATALOGS_09','企業ネットワーク');
define('PRODCUT_CATALOGS_10',' テスト & 工具');
define('TUTORIAL_ALL','すべて');
define('TUTORIAL_ALL_ATGS','すべてのタグ');
define('FS_LOAD_MORE','もっと見る');
define('FS_SUPPORT_CASE','ケース ラーニング');

//support
define('SUPPORT_SEC_01','相互接続の解決策');
define('SUPPORT_SEC_02','ケーブル ソリューション');
define('SUPPORT_SEC_03','エンタープライズ ソリューション');
define('SUPPORT_SEC_04','WDM ソリューション');
define('SUPPORT_SEC_05','FTTX ソリューション');
define('FS_SUPPORT_LOAD_MORE','もっと読み込む');




// common/save_shopping_list.php
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT','FS.COMからのウェブページをあなたと共有しました！');
define('EMAIL_SAVE_SHOPPING_LIST_SUBJECT_1','FS.COM - あなたは ');
define('EMAIL_SAVE_DEAR','お客様');
//2017.5.30		add		ery
define('FS_AJAX_PAST','過去の消費購買データからこのページと情報を保存します！');
define('FS_AJAX_THIS','このメールは、あなたはFS.COMのFriend Servicesを使用して送信したものです。このメッセージを受け取るには、お客様はFS.COMからの迷惑メールを受け取ることはありません。私たちをもっも見る ');
define('FS_AJAX_PRIVACY','情報セキュリティポリシー');
define('FS_AJAX_PRIVACY_1','を同意します。');
define('FS_AJAX_WAS',' FS.COMでショッピングをしましたので、このページ＆情報はあなたと共有したいです！');
define('FS_AJAX_SENT','このメールはあなたの友人から送信されました ');
define('FS_AJAX_USING',' FS.COMのFriend Servicesを利用してお友達と共有されます。このメッセージを受け取ったには、お客様はFS.COMからの迷惑メールを受け取ることはありません。私たちをもっも見る');



// common/tracking_info.php
define('MY_ORDER_SUCCESSFULLY','注文が成功に提出しました、お支払いを待っています。');
define('MY_ORDER_WAIT','お支払いは成功に完成しました、出荷のためにお待ちください。');
define('FIBERSTORE_BY_SYSTEM','システムによって');
define('FIBERSTORE_SESTEM','FS.COM システム');
define('FIBERSTORE_INFO_TIME','処理時間');
define('FIBERSTORE_INFO_PROCESS','進捗情報');
define('FIBERSTORE_INFO_OPERATOR','操作員');



// functions/functions_shipping.php
define('FS_SHIP_IN_PERSON','お客様は自分でお店に到着して商品を受け取ります ');


// functions/functions_tutorial.php
//fallwind	2016.8.22	fallwind_test	add
define('ABC','abcabc');


// functions/product_instock.php
define('FS_SHIP_PC',' 個');
define('FS_SHIP_PCS',' 個');
define('FS_SHIP_ROLL',' 卷');
define('FS_SHIP_ROLLS',' 卷	');
define('FS_SHIP_ROLL_1KM',' <em>(1卷 = 1KM)</em>');
define('FS_SHIP_ROLL_2KM',' <em>(1卷 = 2KM)</em>');
define('FS_SHIP_AVAI','提供可能');
define('FS_SHIP_STOCK',' 在庫あり');
define('FS_SHIP_DEVE','発展');
define('FS_SHIP_ESTIMATED','発送予定日');
define('FS_SHIP_INVENTORY','在庫不足、出荷可能は');
define('FS_SHIP_PLACE','本日注文は　 ');
define('FS_SHIP_DAYS',' 営業日以内に出荷されます');


define("CREDIT_HOLDER_NAME_ERROR1","カード名義人の名前が必要です。");
define("CREDIT_HOLDER_NAME_ERROR2","カード名義人の名前が間違っていますので、もう一度入力してください。");
define("CREDIT_CARD_NUMBER_ERROR1","カード番号が必要です。");
define("CREDIT_CARD_NUMBER_ERROR2","ご記入されたカード番号が存在しませんので、有効な番号をご記入ください。");
define("CREDIT_CARD_DATE_ERROR1","有効期限が必要です。");
define("CREDIT_CARD_DATE_ERROR2","有効期限が間違っていますので、もう一度入力してください。");
define("CREDIT_CARD_CODE_ERROR1","セキュリティコードが必要です。");
define("CREDIT_CARD_CODE_ERROR2","セキュリティコードが間違っていますので、もう一度入力してください。");
//Jeremy 2019.07.18 新版一级分类页底部
define('NEW_PATCH_PANEL_01', '性能テスト');
define('NEW_PATCH_PANEL_02', 'すべてのケーブルがフルークチャネルテストに合格しています。');
define('NEW_PATCH_PANEL_03', '品質認証');
define('NEW_PATCH_PANEL_04', 'CE、RoHS、ISO9001の品質認証が保証されています。');
define('NEW_PATCH_PANEL_05', '十分な在庫量');
define('NEW_PATCH_PANEL_06', '十分な在庫で日本時間４時30分前に注文する場合、即日出荷可能です。');
define('NEW_PATCH_PANEL_07', '費用対効果の高い取引');
define('NEW_PATCH_PANEL_08', 'プロジェクト予算を節約するための卸売価格設定ケーブルです。');

define('NEW_PATCH_PANEL_01_209', '厳格なテストプログラム');
define('NEW_PATCH_PANEL_02_209', '端面検査&amp;IL損失&amp;RL損失。');

define('NEW_PATCH_PANEL_01_1', '多くの柔軟性');
define('NEW_PATCH_PANEL_02_1', 'さまざまなビジネスアプリケーションのニーズを満たすために複数のインタフェースをサポートします。');
define('NEW_PATCH_PANEL_04_1', 'すべての製品は厳密にテストされています。');

define('NEW_PATCH_PANEL_01_911', '迅速な配達');
define('NEW_PATCH_PANEL_02_911', '世界市場をカバーする地元の倉庫は貴重な時間を節約します。');

define('NEW_PATCH_PANEL_01_9', '幅広い互換性');
define('NEW_PATCH_PANEL_02_9', 'すべての主要ベンダーおよびシステムと100％互換性があります。');
define('NEW_PATCH_PANEL_04_9', 'CE、RoHS、IEC、FCC、ISO9001、FDA品質認証が保証されています。');

define('NEW_PATCH_PANEL_02_4', 'すべての製品は標準要件を満たすようにテストされています。');
define('NEW_PATCH_PANEL_08_4', '卸売価格は多くのプロジェクト予算を節約することができます。');

define('FS_TRACK_YOUR_PACKAGE','パッケージの追跡');

//shopping_cart/save_cart/inquiry的email功能 ery 2019-08-12 add
define('FS_EMIAL_BOTTOM_MSG','<table width="640" border="0" cellpadding="0" cellspacing="0">
    <tr><td bgcolor="#ffffff" style="border-collapse: collapse;font-size: 13px;color: #232323;line-height: 20px;font-family: Open Sans,arial,sans-serif;padding: 0 20px" align="left">
                            このメールは<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a><a style="color: #232323;text-decoration: none;" href="javascript:;"></a>の機能を利用して送信されています。
                             このメッセージを受信しても、<a style="color: #232323;text-decoration: none;" href="'.zen_href_link('index').'">FS.COM</a>からの迷惑メッセージは受信されません。詳細では当社の<a style="color: #232323;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">プライバシーポリシー</a>をご覧下さい。</td></tr></table> ');

//邮件
define('SAMPLE_EMAIL_DEAR','お客様');
define('SAMPLE_EMAIL_01', 'ご提出されたリクエストは既に受領されましたので、間もなくご連絡申し上げます。');
define('SAMPLE_EMAIL_02', 'ケース番号は<a style="color: #0070bc;text-decoration: none" href="javascript:;">###case_number###</a>です。該当お申し込みに関する今後のご連絡では該当番号をご利用いただけます。');
define('SAMPLE_EMAIL_03', '連絡先情報：');
define('SAMPLE_EMAIL_04', 'メールアドレス：');
define('SAMPLE_EMAIL_05', '国：');
define('SAMPLE_EMAIL_06', '電話番号：');
define('SAMPLE_EMAIL_07', '追加コメント：');
define('SAMPLE_EMAIL_08', 'どうぞよろしくお願い致します。');
define('SAMPLE_EMAIL_09', 'FSチーム');
define('SAMPLE_EMAIL_30', '該当ケースのケース番号は<a style="color: #0070bc;text-decoration: none" href="$HREF">###case_number###</a>です。<a style="color: #0070bc;text-decoration: none" href="$HREF">オンラインケースセンター</a>でこのケース番号を利用して該当ケースの最新の情報を追跡できます。');

define('FS_CONTACT_GET_SUPPORT','メールでご連絡ください。ご不明な点がございましたら、お気軽にお問い合わせください。');
define('FS_CONTACT_LEAVE','メッセージをお残しください ');

define('CUSTOMER_SERVICE_OTHERS_46', '既にアカウントをお持ちですか？<a style="color: #0070bc;" href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '">ログイン</a>または<a style="color: #0070bc;" href="'.zen_href_link(FILENAME_REGIST, '', 'SSL').'">アカウントを作成</a>してください。');
define('CUSTOMER_SERVICE_OTHERS_47','<a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">ログイン</a>または<a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">新規登録</a>され、パーソナライズドサービスをご利用いただけます。');
define('CUSTOMER_SERVICE_OTHERS_48','既にアカウントをお持ちですか？<a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">ログイン</a>/<a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">アカウントを作成してください</a>。');

//服务页面公用
define('FS_SUPPORT_FORM_TXT','情報をご記入ください。できる限り早めにご連絡申し上げます。');
define('FS_SUPPORT_FORM_PLACEHOLDER','お客様のコメントはFSの対応効率の改善に役立ててまいります。');
define('FS_PLEASE_ENTER_COMMENTS','リクエストに関する内容をより詳しくご記入ください。');
define('FS_COMMON_AT_LEAST','3文字以上ご記入ください。');
define('FS_COMMON_AT_MOST','1000文字以内ご記入ください。');
define('FS_SUPPORT_EMAIL','メールアドレス');
define('FS_SUPPORT_PHONE','電話番号');
define('FS_FIRST_NAME_PLEASE','姓をご入力ください。');
define('FS_LAST_NAME_PLEASE','名をご入力ください。');
define('FS_SUPPORT_COMMENTS','コメント');
define('FS_SUPPORT_FIRST_NAME','姓');
define('FS_SUPPORT_LAST_NAME','名');
define('SOLUTION_PRIVACY_POLICY','FSの<a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>情報セキュリティポリシー</a>と<a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>利用規約</a>に同意します。');
define('FS_SUPPORT_EMAIL_TOUCH_SOON','サポートリクエストは既に受領されましたので、間もなくご連絡申し上げます。');

//shopping_cart save_items 页面的 meta标签 2019.12.23
define('META_TAGS_SHOPPING_CART_TITLE', 'ショッピングカート');
define('META_TAGS_SHOPPING_CART_DESCRIPTION', '最高のデータセンター、エンタープライズネットワーク及びインターネットアクセス製品を購入することで、IT業者がビジネスソリューションを簡単かつ費用対効果の高く実現します。');
define('META_TAGS_SAVED_ITEMS_TITLE', '保存したカート');
define('META_TAGS_SAVED_ITEMS_DESCRIPTION', '製品をカートに追加した後、「保存したカート」をクリックすると、カート内の製品がフォルダとして保存されます。保存したカートはいくつでも作成できます。ご注文の際に、保存したカートは繰り返しご利用いただけます。');

//sfp_optical_module 页面的 meta标签 2020.08.05
define('META_TAGS_SFP_TITLE', '10G CWDM/DWDM SFP+の在庫一覧');
define('META_TAGS_SFP_DESCRIPTION', '10G CWDM/DWDM SFP+モジュールの完全な製品ポートフォリオ（DWDM SFP+ 80km/40km、CWDM SFP+ 80km/40km/20km/10km）は、製品の在庫状況をすばやく確認し、WDMソリューションを提供するのに役立ちます。');

//专题  walking_through   gr_series_cabinet   sfp_optical_module 语言包
define('FS_SPECIAL_GOALS','ご要望の実現における弊社の活躍にご期待ください');
define('FS_SPECIAL_DESIGN_CENTER','デザインセンター');
define('FS_SPECIAL_DESIGN_CENTER_DES','要件を結合する専門知識、革新的で費用<br/>対効果の高い信頼できるワンストップ<br/>ソリューションを提供いたします。');
define('FS_SPECIAL_QUALITY','品質センター');
define('FS_SPECIAL_QUALITY_DES','厳格なテストに合格し、業界標準の<br/>認証を取得した高品質の製品を<br/>提供いたします。');
define('FS_SPECIAL_TEC','テクニカルサポート');
define('FS_SPECIAL_TEC_SMALL','サポートをリクエスト');
define('FS_SPECIAL_TEC_DES','オンラインでプロジェクトの無料サポート &<br/>ソリューション設計をお試しください。');
define('FS_SUBMIT_SUCCESS','リクエスト##number##が送信されました。');
define('FS_SUBMIT_SUCCESS_TIP_TXT_SAMPLE','FSは、営業時間内の場合、1～3時間以内に電話またはメールにてご連絡申し上げます。');

define('SAMPLE_EMAIL_31','アドレス： ');
define('SAMPLE_EMAIL_32','ご希望の数量： ');
define('SAMPLE_EMAIL_33','サンプルリスト');

define('FS_BROWSING_HISTORY','閲覧履歴');

define('FS_PRODUCT_DOWNLOAD', '資料ダウンロード');
define('FS_PRODUCT_MORE', 'もっと見る');
define('FS_PRODUCT_SUPPORT','製品サポート');
//结算页、订单确认成功页、银行转账邮件、订单详情
define("PAYMENT_BANK_ACH","電信送金/ACH送金");
define("PAYMENT_BANK_ACH_CA","電信送金");
define("PAYMENT_BANK_OF_US","アメリカ銀行");
define("PAYMENT_BANK_VIA","電信送金経由");
define("PAYMENT_BANK_ACCOUNT_NAME","FS COM INC");
define("PAYMENT_BANK_WIRE_ROUTING","電信送金用ABAナンバー:");
define("PAYMENT_BANK_SWIFT_CODE","スウィフトコード:");
define("PAYMENT_BANK_ACH_ROUTING"," ACH送金用ABAナンバー:");
define("PAYMENT_BANK_VIA_ACH","ACH経由");

define("PAYMENT_BANK_ACCOUNT_NAME_COMMON",FIBER_CHECK_COMMON_ACCOUNT_NAME);
define("PAYMENT_BANK_ACCOUNT",FS_COMMON_HEADER_ACCOUNT.':');
define("PAYMENT_BANK_ADDRESS",FS_ADDRESS_ADDRESS.':');

//QV弹窗公用语言包
define('FS_COMMON_QTY_SMALL','数量');
define('FS_QV_QUICK_VIEW','クイックビュー');
define('FS_SEE_FULL_DETAILS','詳細を見る');
define('FS_CUSTOMIZED','カートにいれる');
define('FS_PRODUCTS_INFORMATION','製品情報');
define('FS_CUSTOMER_ALSO_VIEWED','他の顧客はまた、これらの製品をチェックしました。');

// fairy 2019.1.15 add 公共标题需要
define('FS_TITLE_COMPATIBLE','対応互換');
define('FS_TITLE_COMPATIBLE_01','互換');

//ery 2020.05.25  buy more 功能相关语言包
define('FS_BUY_MORE_01', 'もう一度購入する');
define('FS_BUY_MORE_02', '「もう一度購入する」を経由して購入したアイテムは、以前のご注文%sと同じになります。');	//%s会替换成订单号
define('FS_BUY_MORE_03', 'このアイテムは以前のご注文%sと同じです。');		//%s会替换成订单号

//头部下拉版块
define('FS_HEADER_SUPPORT','サポート');
define('FS_HEADER_TEC_SUPPORT','テクニカルサポート');
define('FS_HEADER_CUSTOMER_SUPPORT','カスタマーサポート');
define('FS_HEADER_SERVICE_SUPPORT','サービスサポート');
define('FS_HEADER_TEC_DES','弊社のリソースライブラリでドキュメント、ケーススタディ、ビデオなどを検索するか、テクニカルサポートに依頼して、カスタマイズされたソリューションを入手できます。');
define('FS_HEADER_TEC_URL_01','技術ドキュメント');
define('FS_HEADER_TEC_URL_02','試験台');
define('FS_HEADER_TEC_URL_03','ソフトウェアダウンロード');
define('FS_HEADER_TEC_URL_04','品質管理');
define('FS_HEADER_TEC_URL_05','ケーススタディ ');
define('FS_HEADER_TEC_URL_06','保証');
define('FS_HEADER_TEC_URL_07','ビデオライブラリー');
define('FS_HEADER_SUPPORT_RIGHT_DES','FS専門家サービスの提供');
define('FS_HEADER_SUPPORT_RIGHT_URL','連絡しましょう');
define('FS_HEADER_CUSTOMER_DES','購入前または購入後、注文に関するお問い合わせ、注文の発行および追跡、またはその他の関連する問題をすぐに確認できます。');
define('FS_HEADER_CUSTOMER_URL_01','お見積のお申込み');
define('FS_HEADER_CUSTOMER_URL_02','返品と返金のリクエスト');
define('FS_HEADER_CUSTOMER_URL_03','サンプルのお貸し出し');
define('FS_HEADER_CUSTOMER_URL_04','掛売決済');
define('FS_HEADER_CUSTOMER_URL_05','発注書の提出');
define('FS_HEADER_CUSTOMER_URL_07','パッケージの追跡');
define('FS_HEADER_CUSTOMER_URL_08','新着製品');
define('FS_HEADER_CUSTOMER_URL_09','在庫一掃');
define('FS_HEADER_CUSTOMER_URL_10','製品の真偽についての確認');
define('FS_HEADER_CUSTOMER_URL_11','デモのリクエスト');
define('FS_HEADER_CUSTOMER_URL_12','お見積り依頼');
define('FS_HEADER_SERVICE_DES','弊社は、最も簡単な購入体験をお届けることに努力しており、アカウント、配送、返品などで人気のトピックを探索しましょう。');
define('FS_HEADER_SHIPPING_DELIVERY','出荷 & 配達');
define('FS_HEADER_RETURN_POLICY','返品規則');
define('FS_HEADER_PAYMENT','お支払い方法');
define('FS_HEADER_HELP_CENTER','ヘルプセンター');
define('FS_HEADER_COMPANY','弊社について');
define('FS_HEADER_ABOUT_US','会社概要');
define('FS_HEADER_CONTACT_US','お問い合わせ');
define('FS_HEADER_NEWS','パートナー');
define('FS_HEADER_ABOUT_DES','弊社は、世界をリードする通信ハードウェアおよびプロジェクトソリューションプロバイダーです。私たちは、お客様の光学インフラストラクチャの構築、接続、保護、最適化を支援することに専念しております。');
define('FS_HEADER_ABOUT_EXPLORE','FSを探索する');
define('FS_HEADER_CONTACT_DES','弊社は常にご質問をお受付しておりますので、迅速かつ最高なテクニカルサポートとカスタマサービスを入手ならばどうぞご連絡ください。');
define('FS_HEADER_LEARN_MORE','もっと見る');
//以下部分 因分仓、站点各异
define('FS_HEADER_NEWS_READ_MORE','<a class="home_solution_sub_level_right_dd_a" href="'.reset_url('company/fiberstore_with_partners.html').'"><span>パートナーを見る</span><i class="iconfont icon">&#xf089;</i></a>');
define('FS_HEADER_NEWS_DES','<dd>弊社は、お客様のビジネスに合わせてカスタマイズされた費用対効果の高いネットワークソリューションを提供いたします。そして、弊社の製品とサービスは、世界で最も影響力のある企業から信頼されています。</dd>');
define('FS_HEADER_NEWS_RIGHT_DES','FSが一連の権威ある国際認証を取得');
define('FS_HEADER_NEWS_RIGHT_DATE','2020年6月8日');

define('FS_CUSTOMER_SUPPORT_TIP','製品ID＃XXXはカスタム品ですので、オンラインにてサンプルのお貸し出しに適用できません。詳細についてはご専任なアカウントマネージャーにご相談ください。');

// 武汉仓
define('FS_RMA_WAREHOUSE_CN','<dt>ATTN: FS. COM LIMITED</dt>
			<dd>Address: A115 Jinhetian Business Centre No.329, Longhuan Third Rd, Longhua District Shenzhen, 518109, China </dd> 
			<dd>Tel: +86-0755-83571351</dd> ');

// 德国仓
define('FS_RMA_WAREHOUSE_EU','<dt>FS.COM GmbH </dt>
			<dd>NOVA Gewerbepark, Building 7, Am Gfild 7 85375, Neufahrn bei Munich Germany</dd> 
			<dd>Tel: +49 (0) 8165 80 90 517</dd> ');

define('FS_RMA_WAREHOUSE_US','<dt>FS.COM INC </dt>
			<dd>380 CENTERPOINT BLVD, NEW CASTLE, DE 19720, United States</dd> 
			<dd>Tel: +1 (888) 468 7419</dd> ');
// 美东仓
define('FS_RMA_WAREHOUSE_US_EAST','<dt>ATTN: FS.COM Inc.</dt>
					<dd>Address: 380 Centerpoint Blvd, New Castle, DE 19720, United States</dd> 
					<dd>Tel: +1 (888) 468 7419</dd> ');
// 澳洲仓 （澳大利亚）
define('FS_RMA_WAREHOUSE_AU','<dt>FS.COM PTY LTD</dt>
				<dd>57-59 Edison Road, Dandenong South, VIC 3175, Australia</dd> 
				<dd>Tel: +61 3 9693 3488</dd> 
				<dd>ABN: 71 620 545 502</dd> ');

// 新加坡仓
define('FS_RMA_WAREHOUSE_SG','<dt>ATTN: FS Tech Pte Ltd.</dt>
				<dd>Address: 30A Kallang Place #11-10/11/12, Singapore 339213</dd> 

				<dd>Tel: +(65) 6443 7951</dd>');
define('FS_RMA_WAREHOUSE_RU','<dt>《FiberStore.COM》Ltd.</dt>
            <dd>No.4062, d. 6, str. 16, Proektiruemyy proezd, Moscow 115432, Russian Federation</dd>
            <dd>Tel: +7 (499) 643 4876</dd>');


//TW账户中心改版
define('FS_ACCOUNT_TW_QUOTE','お見積');
define('FS_ACCOUNT_TW_CREDIT','掛売口座');
define('FS_ACCOUNT_TW_CREDIT_DETAILS','口座の詳細');
define('FS_ACCOUNT_TW_USER','ユーザー情報');
define('FS_ACCOUNT_TW_SUPPORT','ケースセンター');
define('FS_ACCOUNT_TW_TAX','免税適用');
define('FS_ACCOUNT_TW_USEFUL','クイッククリック');
define('FS_ACCOUNT_TW_ACCOUNT','アカウント情報');
define('FS_ACCOUNT_TW_YOU','まだ支払われていない注文があります。');
define('FS_ACCOUNT_TW_ORDERS','注文');
define('FS_ACCOUNT_TW_MOST_ORDER','最新の注文');
define('FS_ACCOUNT_TW_VIEW_ORDERS','注文一覧');
define('FS_ACCOUNT_TW_ORDERS_SEARCH','注文#、PO#、アイテム#、P/N、コメント...');
define('FS_ACCOUNT_TW_PENDING_PAYMENT','支払い保留中');
define('FS_ACCOUNT_TW_WAIT','出荷待ち');
define('FS_ACCOUNT_TW_TRANSIT','運送中');
define('FS_ACCOUNT_TW_DELIVERED','配達完了');
define('FS_ACCOUNT_TW_PENDING_REVIEW','保留中のレビュー');
define('FS_ACCOUNT_TW_NO_ORDER','ご注文が見つかりません。');
define('FS_ACCOUNT_TW_VIEW_CART','カート一覧');
define('FS_ACCOUNT_TW_VIEW_TICKETS','ケース一覧');
define('FS_ACCOUNT_TW_CREATE_TICKET','ケースを作成');
define('FS_ACCOUNT_TW_SEARCH_TICKET','ケース#、コンテンツ…');
define('FS_ACCOUNT_TW_TICKET','ケース#');
define('FS_ACCOUNT_TW_TICKET_TYPE','サービスタイプ');
define('FS_ACCOUNT_TW_TICKET_COMMENT','コンテンツ');
define('FS_ACCOUNT_TW_TICKET_DATE','提出日');
define('FS_ACCOUNT_TW_TICKET_STATUS','ステータス');
define('FS_ACCOUNT_TW_TICKET_ACTION','操作');
define('FS_ACCOUNT_TW_NO_TICKET','ケース履歴がありません。');
define('FS_ACCOUNT_TW_ORDER','注文#');
define('FS_ACCOUNT_TW_SPLIT_ORDER','分割注文');
define('FS_ACCOUNT_TW_DELIVERY','配送');
define('FS_ACCOUNT_TW_DELIVERY_ON','配送先');
define('FS_ACCOUNT_TW_THE','次の特別な理由により、以下の製品を直接に再度注文することができません。「スキップ＆続行する」ボタンをクリックして、残りの商品をカートに再度追加してください。');
define('FS_ACCOUNT_TW_THE_NO','次の特別な理由により、以下の製品を直接に再度注文することができません。');
define('FS_ACCOUNT_TW_ITEMS','「もう一度購入する」を経由して購入したアイテムは、以前のご注文#%s.と同じになります。 ');
define('FS_ACCOUNT_TW_YOU_CAN','このボタンを使用して、すべての製品をカートに再度入れることができます。');
define('FS_ACCOUNT_TW_ORDER_AGAIN','もう一度購入する');
define('FS_ACCOUNT_TW_CREATE_TICKET','ケースを作成');
define('FS_ACCOUNT_TW_SUPPORT_TYPE','サービスタイプ');
define('FS_ACCOUNT_TW_ATTACH_PO','POを添付');
define('FS_ACCOUNT_TW_SHOW_MORE','もっと見る');
define('FS_ACCOUNT_TW_BASIC_INFO','基本情報');
define('FS_ACCOUNT_TW_ADDRESS_INFO','アドレス情報');
define('FS_ACCOUNT_TW_QUOTES_LIST_TIPS','以下の製品をカートに入れて、見積依頼書を生成します。');
define('FS_ACCOUNT_TW_MOST_QUOTE','最近のお見積');
define('FS_ACCOUNT_TW_VIEW_QUOTES','お見積一覧');
define('FS_ACCOUNT_TW_NO_QUOTE','お見積が見つかりません。');
define('FS_ACCOUNT_TW_QUOTE_ITEM','見積番号#、製品番号#');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS1','次の特定の理由により、以下の製品を直接見積もることはできません。');
define('FS_ACCOUNT_TW_QUOTE_AGAIN_TIPS2','次の特定の理由により、以下の製品を直接見積もることはできません。 [スキップ＆続行する]ボタンをクリックして、残りの製品をカートに追加し、見積もり依頼を再度ご提出お願いたします。');

define('FS_FOOTER_EXPLORE','コミュニティ');
define('FS_HEADER_NEW_PRODUCT','新着製品');
define('FS_HEADER_CHANGE','変換する');
define('FS_COMMON_VIEW_MORE','もっと見る');
define('FS_CART_EMPTY_TIP','ログインして、追加したアイテムを確認したり、新しいアイテムを追加したりできます。');
define('BIllS_TIPS1','ここで全ての請求書を確認できます。');
define('BIllS_TIPS2','ここで掛売口座の利用状態及び全ての請求書を確認できます。');
define('TIPS_BUTTON', '了解！');
define('TIPS_NEW', '新しい');
define('FS_ATTRIBUTE_CUSTOMIZED','カスタム');
//warranty 新增分类质保信息
define('FS_WARRANTY_YEARS',' 年間');
define('FS_WARRANTY_YEAR',' 年間');
define('FS_WARRANTY_DAYS',' 日間');
define('FS_WARRANTY_CONSUMABLE','消耗品');
define('FS_WARRANTY_UNAVAILABLE','適用しない');
define('FS_WARRANTY_SUB_CATEGORY','サブカテゴリー');
define('FS_WARRANTY_RETURN','返品<br>窓口');
define('FS_WARRANTY_CHANGE','交換<br>窓口');
define('FS_WARRANTY_PERIOD','保証<br>期間');

define('FS_WARRANTY_NOTE','備考');

define('ORDER_PAYMENT_TIPS','請求先がカード発行会社に登録されている情報と一致していることをご確認ください。');
define('ORDER_PAYMENT_SAFE','暗号化された安全支払い');
define('ORDER_PAYMENT_TIPS_2','お客様の情報はこの注文の処理にのみ使用され、一切弊社内で保存をしておりません。');
