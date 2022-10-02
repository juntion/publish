<?php
define('REQUEST_DEMO_BANNER_TITLE', 'ネットワークスイッチのデモ');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','すでにアカウントをお持ちですか ？ <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">ログイン</a> あるいは<a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">新規登録はこちら（無料）</a>');

define('REQUEST_DEMO_INDUSTRY', '業界');
define('REQUEST_DEMO_OPTION_DEFAULT', 'ご選択下さい');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', '芸術/レクリエーション');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', '教育-高等教育');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', '教育-初等/中等教育、パブリック＆プライベート');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', '教育-その他');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'エネルギー/ユーティリティ');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', '金融業務');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', '政府');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', '健康/介護');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'ハイテク-ソフト/ハードウェア');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'ホスピタリティ/ホテル＆レジャー');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', '図書館');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', '製造業');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'メディア/エンターテインメント');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', '非営利団体/メンバー組織');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'その他');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'プロフェッショナルサービス');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', '小売/レストラン');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'サービスプロバイダー');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', '運送業');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', '付加価値再販業者（VAR）/システムインテグレーター');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', '卸売/販売代理店');


define('REQUEST_DEMO_COMPANY', '会社名');
define('REQUEST_DEMO_COMPANY_SIZE', '会社の規模');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', '1-99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', '100-999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', '1,000-1,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', '2,000-3,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', '4,000+');
define('REQUEST_DEMO_COMMENT_OPTIONAL', 'コメント(任意) :');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', '欲しいものが見つかりませんか？問題を投稿して見てみましょう。');
define('REQUEST_DEMO_SEARCH_RESULT', '「#KEYWORD#」に関する結果がありませんが、キーワードを再度ご確認ください。');
define('REQUEST_DEMO_HOT_SEARCH', '人気キーワード:');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', '時間を予約してください');

define('REQUEST_DEMO_TIP_01', 'FSスイッチの試用について');
define('REQUEST_DEMO_TIP_02', '弊社のリモートテストサービスにより、ユーザーはラボで運転されているスイッチを展開・接続し、これらのスイッチにリモートでアクセスして操作することができます。');
define('REQUEST_DEMO_TIP_03', 'FSデモの内容は次のとおり:');
define('REQUEST_DEMO_TIP_04', '100種類以上の機能を体験できる');
define('REQUEST_DEMO_TIP_05', 'パフォーマンステスト');
define('REQUEST_DEMO_TIP_06', 'ブランドスイッチとの互換性');
define('REQUEST_DEMO_TIP_07', '標準的なアプリケーションシナリオ');
define('REQUEST_DEMO_TIP_08', 'カスタムソリューション');
define('REQUEST_DEMO_TIP_09', '提供できるサービスは次のとおり：');
define('REQUEST_DEMO_TIP_10', 'ユーザーシナリオシミュレーション、現場操作感');
define('REQUEST_DEMO_TIP_11', '遅延なし、画面のフリーズなし');
define('REQUEST_DEMO_TIP_12', '1分内アクセス可能、30分の体験時間');
define('REQUEST_DEMO_TIP_13', '1対1の技術エンジニアのオンラインサポート');

define('REQUEST_DEMO_FORM_01', 'どの型番のスイッチに興味がありますか？');
define('REQUEST_DEMO_FORM_02', 'どの機能をテストする予定がありますか？');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'リクエスト#NUMBER#は提出されました。');
define('REQUEST_DEMO_SUCCESS_TIP_02', '弊社は二十四時間内に返信いたします。');

define('REQUEST_DEMO_SEARCH_DEFAULT_ARRAY', json_encode(array(
    array('id' => 1, 'txt' => 'VLAN'),
    array('id' => 2, 'txt' => 'QINQ'),
    array('id' => 3, 'txt' => 'LACP'),
    array('id' => 4, 'txt' => 'スタティックルーティング'),
    array('id' => 5, 'txt' => 'RIP'),
    array('id' => 6, 'txt' => 'RIPng'),
    array('id' => 7, 'txt' => 'OSPFv2'),
    array('id' => 8, 'txt' => 'OSPFv3'),
    array('id' => 9, 'txt' => 'BGP4'),
    array('id' => 10, 'txt' => 'SNMP'),
    array('id' => 11, 'txt' => 'Web'),
    array('id' => 12, 'txt' => 'sFlow'),
    array('id' => 13, 'txt' => 'SSH'),
    array('id' => 14, 'txt' => 'DHCPスヌーピング'),
    array('id' => 15, 'txt' => 'DHCPサーバー'),
    array('id' => 16, 'txt' => 'DHCPクライアント'),
    array('id' => 17, 'txt' => 'DHCPリレー'),
    array('id' => 18, 'txt' => 'NTP'),
    array('id' => 19, 'txt' => 'スタキング')
)));
define('REQUEST_DEMO_SEARCH_OTHERS_ARRAY', json_encode(array(
    array('id' => 20, 'txt' => 'フロー制御'),
    array('id' => 21, 'txt' => 'STP'),
    array('id' => 22, 'txt' => 'RSTP'),
    array('id' => 23, 'txt' => 'MSTP'),
    array('id' => 24, 'txt' => 'ストーム制御'),
    array('id' => 25, 'txt' => 'ミラー'),
    array('id' => 26, 'txt' => 'スタティックMACアドレス'),
    array('id' => 27, 'txt' => 'RLDP'),
    array('id' => 28, 'txt' => 'lldp'),
    array('id' => 29, 'txt' => 'レイヤー2 プロトコルトンネル'),
    array('id' => 30, 'txt' => 'REUP'),
    array('id' => 31, 'txt' => 'G.8032'),
    array('id' => 32, 'txt' => 'VCT'),
    array('id' => 33, 'txt' => 'igmpスヌーピング'),
    array('id' => 34, 'txt' => 'MLDスヌーピング'),
    array('id' => 35, 'txt' => 'ipv4 vrf'),
    array('id' => 36, 'txt' => 'ipv6'),
    array('id' => 37, 'txt' => 'IGMP'),
    array('id' => 38, 'txt' => 'PIM-DM'),
    array('id' => 39, 'txt' => 'PIM-SM'),
    array('id' => 40, 'txt' => 'PIM-SSM'),
    array('id' => 41, 'txt' => 'RIPng'),
    array('id' => 42, 'txt' => 'ospfv3'),
    array('id' => 43, 'txt' => 'BGP4+'),
    array('id' => 44, 'txt' => 'ACL'),
    array('id' => 45, 'txt' => 'QoS'),
    array('id' => 46, 'txt' => 'Tacacs+'),
    array('id' => 47, 'txt' => '802.1x'),
    array('id' => 48, 'txt' => 'ポートセキュリティ'),
    array('id' => 49, 'txt' => 'DAI'),
    array('id' => 50, 'txt' => 'ipソースガード'),
    array('id' => 51, 'txt' => 'TFTP'),
    array('id' => 52, 'txt' => 'FTP'),
    array('id' => 53, 'txt' => 'SNTP'),
    array('id' => 54, 'txt' => 'VRRP')
)));

define('REQUEST_DEMO_FORM_TIP_01', '業界を選択してください。');
define('REQUEST_DEMO_FORM_TIP_02', '会社名を入力してください。');
define('REQUEST_DEMO_FORM_TIP_03', '会社の規模を選択してください。');
define('REQUEST_DEMO_FORM_TIP_04', 'スイッチを選択してください。');
define('REQUEST_DEMO_FORM_TIP_05', '少なくとも1つの機能を選択してください。');
define('REQUEST_DEMO_FORM_TIP_06', '時間を選択してください。');
define('REQUEST_DEMO_EMAIL_01','FS-ご提出したデモリクエスト #NUMBER#を確認できました。');
define('REQUEST_DEMO_EMAIL_02','ご提出したデモリクエスト<a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a>を確認できましたが、これからの連絡でこの番号を参照できます。');
define('REQUEST_DEMO_EMAIL_03','以下はテスト情報:');
define('REQUEST_DEMO_EMAIL_04','スイッチ型番: ');
define('REQUEST_DEMO_EMAIL_05','興味のある機能: ');
define('REQUEST_DEMO_EMAIL_06','予定時間: ');
define('REQUEST_DEMO_EMAIL_07','デモテスト開始する前に、<a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a>を用意してください。弊社の技術チームはまもなく連絡します。');
define('REQUEST_DEMO_EMAIL_08','TeamViewer<b>パートナー（FS）IDは658526138</b>になりますが、パスワードは予定時間の十五分前に発送されます。');

define('REQUEST_DEMO_SEARCH','検索する');