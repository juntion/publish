<?php
// fairy 2017.12.18 整理
// 语言包中用双引号，考虑到小语种尤其是法语中经常出现单引号的情况。
// 用户登录、注册、企业注册、修改资料。
define('FS_SIGN_IN',"ログイン");
define('FS_JOIN_NOW',"今すぐ新規登録！");
define('FS_WELCOME_BACK',"お帰りなさい");
define('FS_WELCOME',"FSへようこそ");
define('FS_NEW_CUSTOMER',"新規顧客?");
define('FS_CREATE_ACCOUNT',"新規登録(無料)");
define('FS_REGIST_BUSINESS_ACCOUNT',"法人アカウント登録");
define('FS_SUBMIT_UPDATE_TO_BUSINESS_ACCOUNT','法人アカウント');
define('FS_ALREADY_HAS_ACCOUNT',"既にアカウントをお持ちですか?");
define('FS_UPGRADE',"アップグレード");
//密码
define('FS_FORGOT_YOUR_PASSWORD',"パスワードをお忘れの方はこちら");
//其他登录
define('FS_LOGIN_BY_OTHER',"他の方法でログイン");
define('FS_SIGN_IN_GOOGLE',"Googleでログインする");
define('FS_SIGN_IN_PAYPAL',"Paypalでログインする");
define('FS_SIGN_IN_FACEBOOK',"Facebookでログインする");
define('FS_SIGN_IN_LINKEDIN',"Linkedinでログインする");

// 企业注册
define('FS_COMPANY_INFO',"会社情報");
define('FS_CONTACT_INFO',"連絡情報");
define('FS_BUSINESS_REGIST_SUCCESS_TIP', 'おめでとうございます、お客様の法人アカウントは成功に登録されました。');
// 行业选择
define('FS_INDUSTRY_SELECT_COM','通信/テレコミュニケーション');
define('FS_INDUSTRY_SELECT_CONSTRUCT','建設/エンジニアリング');
define('FS_INDUSTRY_SELECT_ENERGY','コンサルティング/ソリューションプロバイダ');
define('FS_INDUSTRY_SELECT_CONSULT','エネルギー/電力/石油');
define('FS_INDUSTRY_SELECT_GOVERNMENT','政府');
define('FS_INDUSTRY_SELECT_HEALTH','健康管理/医療');
define('FS_INDUSTRY_SELECT_IT','ハイテク/IT');
define('FS_INDUSTRY_SELECT_MANU','製造/化学');
define('FS_INDUSTRY_SELECT_MEDIA','メディア/出版/広告');
define('FS_INDUSTRY_SELECT_NON','非営利団体/団体');
define('FS_INDUSTRY_SELECT_RETAIL','小売/販売/貿易/卸売');
define('FS_INDUSTRY_SELECT_SERVICE','サービス');
define('FS_INDUSTRY_SELECT_TRANS','輸送/物流');
// 企业升级
//define('FS_APPLY_BUSINESS_SUCCESS_TIP',"私たちはお客様の申請を受領しました、確認と検証のためにお待ちください。");
define('FS_APPLY_BUSINESS_SUCCESS_TIP',"ご提出頂いたリクエストは既に受領致しましたので、社内確認の手続きを進められます。");
//define('FS_APPLY_BUEINESS_EXIST_TIP',"すみません、このMailboxはすでに法人アカウントになります、またすでに法人アカウントを申請しました。");
define('FS_APPLY_BUEINESS_EXIST_TIP',"すみませんが、このメールアドレスは既に法人アカウントに登録されているか、法人アカウントの申請中でございます。");
define('FS_APPLY_BUSINESS_SUCCESS_JUMP_TIP',"ここををクリックしてください、個人センターにジャンプします。");
// 第3方登录
define('FS_THIRD_PARTY_BIND_TIP',"既にFS.COMアカウントをお持ちの場合は、個人情報と環境設定をよりよく管理するために、FS.COMアカウントをリンクすることができます。");
define('FS_LINK_NOW',"今すぐリンクする");
define('FS_HAVE_FS_ACCOUNT',"FS.COMアカウントを持っていませんか？");
define('FS_GOOGLE_USER_DEAR',"親愛な");
define('FS_GOOGLE_USER_USER',"お客様");
define('FS_GOOGLE_USER_WELCOME',", ようこそ");
define('FS_SKIP',"スキップ");

// 游客登录页面   
define('FS_LOGIN_REGIST_GUEST','ゲストとしてのチェックアウト');
define('FS_LOGIN_REGIST','アカウントを作成する');
define('FS_LOGIN_REGIST_1','ゲスト決済');
define('FS_LOGIN_REGIST_2','まだアカウントを持っていませんか?');
define('FS_LOGIN_REGIST_3','購入することはより簡単になります：');
define('FS_LOGIN_REGIST_4','配送先住所の事前登録');
define('FS_LOGIN_REGIST_5','買い物リスト');
define('FS_LOGIN_REGIST_6','簡単に注文履歴にアクセスする');
define('FS_LOGIN_REGIST_7','新規登録しましょうか。');
define('FS_LOGIN_REGIST_8','決済に進み、後でアカウントを作成してください。');

// fairy 2018.8.8 改版  
define('FS_MY_FS_ADVANTAGE',"FSアカウント登録のメリット");
define('FS_MY_FS_ADVANTAGE0',"買い物をより簡単にしよう");
define('FS_MY_FS_ADVANTAGE1',"迅速で簡単に決済できる");
define('FS_MY_FS_ADVANTAGE2',"注文履歴を見て配送状況を追跡できる");
define('FS_MY_FS_ADVANTAGE3',"お見積もりおよび発注書を効率的に処理できる");
define('FS_MY_FS_ADVANTAGE4',"テクニカルサポートとソリューションデザインを取得できる");
define('FS_DONT_HAVE_FS_ACCOUNT',"アカウントを持っていませんか？");
define('FS_QUICKLY_SET_UP_ACCOUNT',"早速安全なアカウントを設定しましょう。");
define('FS_LOG_ADVANTAGE',"早速決済できるようアカウント情報でログインしましょう。");
define('FS_UPGRADE_NEW','アップグレード');
define('FS_SIGN_OR_LOGIN','FSアカウントにログインまたは<a href="'.zen_href_link('regist','','SSL').'">新規登録(無料)</a>');
define('FS_HAVE_ACCOUNT','既にアカウントをお持ちですか?<a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">ログイン</a>');

//2018-10-9carr m端游客入口
define('FS_LOG_ChecGuest',"ゲスト決済");

//2018 12 4 helun
define('FS_LOG_RE_01',"新規顧客");
define('FS_LOG_RE_02',"後で登録");
define('FS_LOG_RE_03',"アカウント登録せず一時チェックアウト可能です。");
define('FS_LOG_RE_04',"今すぐ登録");
define('FS_LOG_RE_05',"早速なチェックアウトでき、注文履歴も簡単にチェックできる様にFS.COMアカウントを作成しましょう。");

// 登录页面remember me和气泡
define('FS_REMEMBER_ME',"ログインしたまま");
define('FS_SIGN_IN_REMEMBER_ME_01',"アカウントのセキュリティを確保するため、個人でお使いの");
define('FS_SIGN_IN_REMEMBER_ME_02',"デバイスでのみこのオプションを使うようにしてください。");

// 2020-02-25 登录注册页文案优化
define('FS_LOGIN_RIGHT_TITLE', 'FSアカウントにログインまたは');
define('FS_FORGOT_PASSWORD',"パスワードをお忘れの方はこちら");
define('FS_LOGIN_KEEP_ME_SIGNED_IN', 'ログイン状態を保持する');
define('FS_LOGIN_OTHER_NEW', '別の方法でログイン');
define('FS_EMAIL_ADDRESS_NEW',"メールアドレス");

// 2020-10-12 第三方登陆
define('FS_3RD_01','パスワード');
define('FS_3RD_02','パスワードを確認');
define('FS_3RD_03','提出する');
define('FS_3RD_04','既にアカウントをお持ちですか?');
define('FS_3RD_05','既存のアカウントへの紐づけ');
define('FS_3RD_06','@@@ 電子メールアドレス:');
define('FS_3RD_07','@@@電子メールを使用してFSアカウントを作成します。');
define('FS_3RD_08','新規登録(無料)');
define('FS_3RD_09','既存のアカウントを紐づける');
define('FS_3RD_10','FSにログインして、既存のアカウントと@@@電子メールの紐づけを完了します。');
define('FS_3RD_11','FSメール');
define('FS_3RD_12','FSパスワード');
define('FS_3RD_14','アカウントを紐づける');
define('FS_3RD_15','次のようなことができます：');

define('FS_3RD_16','正常に紐づけられました。');
define('FS_3RD_17','これで、＠＠＠アカウントを使用してFS IDに素早くログインできます。');
define('FS_3RD_18','新規登録(無料)');

// 2020-10-27 忘记密码
define('FS_PS_PASSWORD_FORGOTTEN_TOO_FREQUENT','リクエストが頻繁すぎますので、 少なくとも1分後に再試行してください。');