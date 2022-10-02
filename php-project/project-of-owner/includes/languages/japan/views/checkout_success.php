<?php
/*************************content*************************/
//ery		2014-9-14		add
define('FS_SUCCESS_CART','カート');
define('FS_SUCCESS_CHECKOUT','チェックアウト');
define('FS_SUCCESS_SUCCESS','成功');
define('FS_SUCCESS_LIVE','ライブチャット');
define('FS_SUCCESS_THANK','ご注文頂きまして誠に有難うございます！ご注文はすでに受け付けました！');
define('FS_SUCCESS_SUMMARY','注文一覧');
define('FS_SUCCESS_NUMBER','注文番号');
define('FS_SUCCESS_TOTAL','合計');
define('FS_SUCCESS_ITEM','アイテム');
define('FS_SUCCESS_METHOD','配送方法');
define('FS_SUCCESS_DATE','注文日');
define('FS_SUCCESS_PAYMENT','お支払方法');
define('FS_SUCCESS_CREDIT','クレジット/デビットカード');
define('FS_SUCCESS_IF','何か疑問があり私たちと連絡します：　電話：+1 (253) 277 3058　　　電子メール：  ');
define('FS_SUCCESS_SALES','sales@fs.com');
define('FS_SUCCESS_SUPPORT','Support@fiberstore.com');
define('FS_SUCCESS_YOU_CAN','ご注文は成功に提出されました。以下の操作ができます');
define('FS_SUCCESS_VIEW','ご注文を見る');
define('FS_SUCCESS_CHANGE','私のプロフィールを変更します');
define('FS_SUCCESS_SHIPPING','お届け先のアドレス');
define('FS_SUCCESS_BACK','ホームへ戻る');
/*****************html_checkout_success_hsbc.php*****************/
define('FS_SUCCESS_YOUR_NEXT','次は電信送金で支払いを完成します。後は支払詳細を提出してください。');
define('FS_SUCCESS_WIRE','電信送金');
define('FS_SUCCESS_ORDER','注文を印刷');
define('FS_SUCCESS_DETAIL','電信送金受益者の詳細');
define('FS_SUCCESS_BANK_NAME','受益者の銀行名');
define('FS_SUCCESS_HSBC','HSBC Hong Kong');
define('FS_SUCCESS_AC_NAME','受益者口座名');
define('FS_SUCCESS_CO','FS.COM LIMITED');
define('FS_SUCCESS_AC_NO','受益者口座番号');
define('FS_SUCCESS_TEL','817-498231-838');
define('FS_SUCCESS_SWIFT','SWIFTアドレス');
define('FS_SUCCESS_HK','HSBCHKHHHKH');
define('FS_SUCCESS_BANK_ADRESS','受益者銀行アドレス');
define('FS_SUCCESS_ROAD','1 Queen\'s Road Central, Hong Kong');
define('FS_SUCCESS_OUR','当社のアドレス');
define('FS_SUCCESS_NO','Eastern Side, Second Floor, Science &amp; Technology Park, No.6, Keyuan Road, Nanshan District, Shenzhen, China');
/******************html_checkout_success_paypalwpp.php*******************/
define('FS_SUCCESS_PAYPAL','Paypal');
define('FS_SUCCESS_TRANSFER','受益者の振込詳細');
define('FS_SUCCESS_TRANS_CODE','Paypalトランザクションコード');
define('FS_SUCCESS_YOU','お客様はホームページ');
define('FS_SUCCESS_HOME','へ戻る');
define('FS_SUCCESS_OR','または私の注文');
define('FS_SUCCESS_MY','をビューする');
/*****************html_checkout_success_westernunion.php******************/
define('FS_SUCCESS_WES_YOUR','次はウエスタンユニオンへ支払いを完成します、後は支払詳細を提出してください。');
define('FS_SUCCESS_WES_BENE','受益者の詳細');
define('FS_SUCCESS_BENEFICIARY','受益者');
define('FS_SUCCESS_ZYX','ZongYun Xu');
define('FS_SUCCESS_FIRST','姓');
define('FS_SUCCESS_ZY','ZongYun');
define('FS_SUCCESS_LAST','名');
define('FS_SUCCESS_X','Xu');
define('FS_SUCCESS_WES_RECEIVER','受取人の電話番号');
define('FS_SUCCESS_PHONE','13926572260');
define('FS_SUCCESS_ADDRESS','アドレス');
define('FS_SUCCESS_SZ','Shenzhen 518045, China');
define('FS_SUCCESS_WU','ウエスタンユニオン');
define('FS_SUCCESS_NOTE','ご注意');
define('FS_SUCCESS_YOUR_ORDER','ご注文状況は我々がお支払いを確認した後2営業日以内に「支払確認済み」状態になりようです、幾つら注文の確認にはもっと時間がかかります。');
define('FS_CHECKOUT_SUCCESS_05','何か質問があれば、お気軽にお問合わせてください。'.fs_new_get_phone().'までお電話ください。または、');
define('FS_CHECKOUT_SUCCESS_05_1','何かご質問がございましたら、$PHONEまでお電話下さい。または、$EMAILにメールでお問合わせてください。');
//html_checkout_success_echeck.php html_checkout_success_purchase_new.php  中在用FS_CHECKOUT_SUCCESS_05_2
define('FS_CHECKOUT_SUCCESS_05_2', 'ご質問がございましたら、お気軽に'.fs_new_get_phone().'までお電ください。また、メール<a href="mailto:'.get_mail_site_and_country().'">'.get_mail_site_and_country().'</a>にお問い合わせください。');

//add by Aron 2017.7.18
define('FS_SUCCESS_PURCHASE_YOUR_NEXT','次はお客様のPOをアップロードしてください、当社はお客様のPOを受るまで出荷されておりません、ご了承ください。');
define('FS_SUCCESS_PAYMENT_DATE','支払日');

//add by Aron 2017.7.25
define("FS_UPLOAD_TITLE","注文書をアップロードする");
define("FS_UPLOAD_TEXT","あなたのPOをアップロードして時間を保存します。我々はお客様のPOを受けた後注文を処理していきます。どうぞ、必要な署名と情報を提供することをご確認ください。 ");
//add by aron 2017.11.18
define("FS_SUCCESS_GLOABL_THANK","お支払いは成功です。ご注文は処理しています。");
define('FS_SUCCESS_ORDER_DINGDAN','注文 #');
define('FS_SUCCESS_DELIVERY','配達予定日');
define('FS_SUCCESS_SHIP_FROM','出荷地');
define('FS_SUCCESS_ORDER_ORDER','注文');
define('FS_SUCCESS_ORDER_OF','of');
define('FS_SUCCESS_PURCHASE','今回の購買は以下に分かれています：');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ORDER','注文書');
define('FS_CHECKOUT_SUCCESS_DAYS','DAYS');
define('FS_CHECKOUT_SUCCESS_PRINT_ORDER','注文を印刷');
define('FS_CHECKOUT_SUCCESS_14','POファイルを添付');
define('FS_CHECKOUT_SUCCESS_15','購買注文番号');
define('FS_CHECKOUT_SUCCESS_16','注文書番号を空にすることはできません');

//add by frankie 2018.1.2. 
define("FS_SUCCESS_GLOABL_THANK","お支払いは完了しました！ご注文は進行中です。");
define("FS_SUCCESS_PURCHASE_ADDRESS_NOTE","配送先住所が与信申請書のご住所と一致しません。注文を確認して12時間以内に結果をメール致します。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE","ご利用可能な与信限度額は既に使い込んでいます。この注文を迅速に処理するには、前の注文を払い戻してクレジットを復帰するか、<a href ='".zen_href_link('my_dashboard')."'>「マイクレジット」</a>ページに与信限度額を増加することができます。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_DOUBLE_NOTE","配送先住所が与信申請書のご住所と一致せず、ご利用可能な与信限度額も既に使い込んでいます。この注文を迅速に処理するには、前の注文を払い戻してクレジットを復帰するか、<a href ='".zen_href_link('my_dashboard')."'>「マイクレジット」</a>ページに与信限度額を増加することができます。注文を確認して12時間以内に結果をメール致します。7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");
define("FS_SUCCESS_PURCHASE_MONEY_NOTE_1","7営業日以内に注文書ファイルをアップロードしてください。そうしないと、製品の在庫変更のため注文が自動的にキャンセルされます。");define('FIBER_CHECK_SPARK','Sparkasse銀行口座');
define("PICK_UP_ALERT1",'申し訳ありませんが、写真のIDに名前が必要です。');
define("PICK_UP_ALERT2",'申し訳ありませんが、電話番号は必要です。');
define("PICK_UP_ALERT4",'ピックアップ時間が必要です。');
//add by helun 2018.5.15
define('FS_CHECKOUT_SUCCESS_SALES','に電子メールを送付してください。');

//OP下单成功后提示语
define('FS_CHECKOUT_PURCHASE_ADDRESS','配送先住所がクレジット申請書の住所と一致しませんので、ご注文を確認し、12時間以内に結果をメールでお知らせ致します。');
define('FS_CHECKOUT_PURCHASE_EXCESS','利用可能なクレジット限度額が超えましたので、該当注文を迅速に処理するには、以前の注文を返済してクレジット限度額を回収するか、「マイクレジット」にアクセスしてクレジット限度額を増やすことを申し込むことができます。');
define('FS_CHECKOUT_PURCHASE_ALL','配送先住所がクレジット申請書の住所と一致せず、利用可能なクレジット限度額も超えました。該当注文を迅速に処理するには、以前の注文を返済してクレジット限度額を回収するか、「マイクレジット」にアクセスしてクレジット限度額を増やすことを申し込むことができます。ご注文を確認し、12時間以内に結果をメールでお知らせ致します。');

//下单成功优化 add time 2020-04-06 jay
define('FS_CHECKOUT_SUCCESS_NEW_01', 'ご注文ありがとうございます。');
define('FS_CHECKOUT_SUCCESS_NEW_02', '在庫の変更により、７営業日以内にご入金の確認ができない場合、ご注文は自動的にキャンセルされます。ご入金をすばやく確認し、出来るだけ早く製品手配を進めるために、1〜3営業日以内にご送金手続きを完了し、FS注文番号または会社名を記入してください。お急ぎの場合は、他のお支払い方法をお選びください。ご不明な点がございましたらカスタマーサポートまたはアカウントマネージャーにご連絡ください。');
define('FS_CHECKOUT_SUCCESS_NEW_03', '注文情報');
define('FS_CHECKOUT_SUCCESS_NEW_PO_NUMBER_04', 'PO番号');
define('FS_CHECKOUT_SUCCESS_NEW_DELIERY_ADDRESS_05', 'お届け先');
define('FS_CHECKOUT_SUCCESS_NEW_PAYMENT_INSTRUCTIONS_06', 'お支払いのご案内');
define('FS_CHECKOUT_SUCCESS_NEW_07', '送金手続きを完了した後、銀行の送金明細書を');
define('FS_CHECKOUT_SUCCESS_NEW_08', 'またはアカウントマネージャーにご送信ください。ご注文を優先的に処理し、ご注文の自動キャンセルも回避できます。下記の弊社指定口座にご送金ください。');
define('FS_CHECKOUT_SUCCESS_NEW_BSB_09', 'BSB');
define('FS_CHECKOUT_SUCCESS_NEW_ACCOUNT_NO_10', '口座番号');
define('FS_CHECKOUT_SUCCESS_NEW_SWIFT_CODE_11', 'SWIFTコード');
define('FS_CHECKOUT_SUCCESS_NEW_BANK_ADDRESS_12', '銀行住所');
define('FS_CHECKOUT_SUCCESS_NEW_13', '注文番号');
define('FS_CHECKOUT_SUCCESS_NEW_14', 'とメールアドレスを振込メモにご記入ください。');
define('FS_CHECKOUT_SUCCESS_NEW_DELIVERY_POLICY_15', '配送ポリシー');
define('FS_CHECKOUT_SUCCESS_NEW_16', '弊社にてご入金の確認ができたうえで、発送の正式手配となります。');
define('FS_CHECKOUT_SUCCESS_NEW_17', 'ご注文は、平日（祝日を除く）の午前9時から午後5時までお届けします。特定の場合では、指定のアドレスでご注文を受け取ることもあります。');
define('FS_CHECKOUT_SUCCESS_NEW_PRINT_18', '印刷');
define('FS_CHECKOUT_SUCCESS_NEW_DOWNLOAD_19', 'ダウンロード');
define('FS_CHECKOUT_SUCCESS_NEW_ORDER_DETAILS_20','注文詳細');
define('FS_CHECKOUT_SUCCESS_NEW_BILLING_ADDRESS_21', '請求先');
//账期
//　注：这句活放到顾客姓名后面，例如【Bettinaさん、ご注文ありがとうございます。】或者日语也可以不要人名，只放这句话
define('FS_CHECKOUT_SUCCESS_PURCHASE_THINK_YOU_01', 'ご注文ありがとうございます。');

define('FS_CHECKOUT_SUCCESS_PURCHASE_YOUR_ORDER_02', 'ご注文');
define('FS_CHECKOUT_SUCCESS_PURCHASE_05', "POファイルを受領し次第、ご注文の処理を開始します。必要な署名と情報がすべて提供されていることをご確認ください。後で");
define('FS_CHECKOUT_SUCCESS_PURCHASE_LATER_06', 'にPOファイルをアップロードすることもできます。');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ORDER_AMOUNT_07', '金額');
define('FS_CHECKOUT_SUCCESS_PURCHASE_TOTAL_08', '合計');
define('FS_CHECKOUT_SUCCESS_PURCHASE_09', 'POファイルの確認ができたうえで、発送の正式手配となります。');
define('FS_CHECKOUT_SUCCESS_PURCHASE_10', 'ご注文は、平日（祝日を除く）の午前9時から午後5時までお届けします。特定の場合では、指定のアドレスでご注文を受け取ることもあります。');
define('FS_CHECKOUT_SUCCESS_PURCHASE_ACCOUNT_CENTER_11', 'アカウントセンター');
define('FS_CHECKOUT_SUCCESS_PURCHASE_12', 'ご注文の確認メールをお送りしました。ご不明な点がございましたら、');
define('FS_CHECKOUT_SUCCESS_PURCHASE_13', 'マイアカウント');
define('FS_CHECKOUT_SUCCESS_PURCHASE_14', 'FSがどのようにしてオンラインショッピングをより簡単にするかをご覧ください。');
define('FS_CHECKOUT_SUCCESS_PURCHASE_15', 'マイPOを見る');
define('FS_CHECKOUT_SUCCESS_PURCHASE_16', 'パッケージの追跡');
define('FS_CHECKOUT_SUCCESS_PURCHASE_17', '注文履歴');

define('FS_CHECKOUT_SUCCESS_PURCHASE_18', "ご注文のお支払い");
define('FS_CHECKOUT_SUCCESS_PURCHASE_19', "jp@fs.com");
define('FS_CHECKOUT_SUCCESS_PURCHASE_20', "発送予定日");
define('FS_CHECKOUT_SUCCESS_PURCHASE_21', "までお電話ください。");
define('FS_CHECKOUT_SUCCESS_PURCHASE_22', "注文日");
define('FS_CHECKOUT_SUCCESS_PURCHASE_23', "注文番号");
define('FS_CHECKOUT_SUCCESS_PURCHASE_24', "注文情報");
define('FS_CHECKOUT_SUCCESS_PURCHASE_25', "請求書を印刷");

// 武汉仓
define('FS_COMMON_WAREHOUSE_CN_CHECKOUT_SUCCESS','ATTN: FS. COM LIMITED<br> 
			Address: A115 Jinhetian Business Centre No.329,<br> 
			Longhuan Third Rd<br> 
			Longhua District<br> 
			Shenzhen, 518109, China');
define('FS_COMMON_WAREHOUSE_CN_NEW_CHECKOUT_SUCCESS','FS.COM LIMITED<br> 
			A115 Jinhetian Business Centre <br> 
			No.329, Longhuan Third Rd <br> 
			Longhua District <br>
			Shenzhen, 518109, <br> China');

// 德国仓
define('FS_COMMON_WAREHOUSE_EU_CHECKOUT_SUCCESS','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germany');
define('FS_COMMON_WAREHOUSE_US_CHECKOUT_SUCCESS','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			United States');
// 美东仓
define('FS_COMMON_WAREHOUSE_US_EAST_CHECKOUT_SUCCESS','ATTN: FS.COM Inc.<br>
					Address: 380 Centerpoint Blvd,<br>
					New Castle, DE 19720,<br>
					United States');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU_CHECKOUT_SUCCESS','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175, Australia');
define('FS_COMMON_WAREHOUSE_SG_CHECKOUT_SUCCESS','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG_CHECKOUT_SUCCESS','ATTN: FS Tech Pte Ltd.<br>
				Address: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore');

define('FS_COMMON_FEEDBACK_TIP','引き続きより良いショッピング体験を提供するために、ご意見・ご提案がございましたら、<a href="javascript:;" style="color:#0070BC;" onclick="$(\'.have_feedback\').show()" id="have_checkout_feedback">このページ</a>までお寄せください。');
?>