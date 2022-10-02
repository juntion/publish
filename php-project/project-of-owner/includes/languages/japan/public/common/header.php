<?php
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
define('FS_HEADER_SEARCH','サーチ');
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
define('FS_NEW_CUSTOMER',FS_NEW_CUSTOMER);
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
define('FS_RESOURCES','リソース');
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
define('FS_MY_CASES','マイケース');
define('FS_MY_QUOTES','マイ見積り');
define('FS_ACCOUNT_SETTING','アカウント設定');
define('FS_VIEW_ALL','全てを見る');

// 搜索
define('FS_SEARCH_PRODUCTS','製品を検索する');
define('FS_NEW_CHOOESE_CURRENCY','貨幣を選んでください');
// 2018.7.23 fairy help
define('FS_NEED_HELP','ヘルプをお必要ですか？');
define('FS_NEED_HELP_BIG','ヘルプをお必要ですか？');
define('FS_CHAT_LIVE_WITH_US','当社とチャットする');
define('FS_SEND_US_A_MESSAGE','私たちにメッセージを送る');
define('FS_E_MAIL_NOW','今すぐメールする');
define("FS_LIVE_CHAT","ライブチャット");
define("FS_WANT_TO_CALL","お電話で相談するの？");
define("FS_BREADCRUMB_HOME","ホーム");

/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','技術サポートを求める');
define('FS_CHAT_LIVE_WITH_GET_A','専門家に尋ねる');

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

define('FS_TAGIMG_TITLE','注目のポートフォリオ');
define('FS_INDEX_CATE_PRODUCTS','製品一覧');
?>