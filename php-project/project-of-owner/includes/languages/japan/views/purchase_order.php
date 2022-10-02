<?php

define('PURCHASE_TITLE_01', '発注書（PO）の提出');
define('PURCHASE_TITLE_02', 'ご発注書のプロセスを効率的、自動的かつ簡単に追跡できます。');

define('PURCHASE_FORM_01', 'ご発注書（PO）注文を迅速かつ簡単に処理するために、次の情報をご入力ください。');
define('PURCHASE_FORM_02', '連絡先');
define('PURCHASE_FORM_03', '姓');
define('PURCHASE_FORM_04', '名');
define('PURCHASE_FORM_05', 'メールアドレス');
define('PURCHASE_FORM_06', '電話番号');
define('PURCHASE_FORM_07', 'POの情報');
define('PURCHASE_FORM_08', 'PO番号');
define('PURCHASE_FORM_09', '見積り書と請求書の番号');
define('PURCHASE_FORM_10', 'ファイルをアップロード');
define('PURCHASE_FORM_11', 'コメント');
define('PURCHASE_FORM_12', 'POを送信');
define('PURCHASE_FORM_13', 'ファイルを選択');

define('PURCHASE_FORM_TIP_01', 'PO番号をご入力ください。');
define('PURCHASE_FORM_TIP_02', 'もし弊社から正式な見積り書と請求書を取得されたことがある場合、RQC2001020006/RQ2001300199/FS20200128000などの関連情報をご提示頂きたいです。');
define('PURCHASE_FORM_TIP_03', 'もし弊社から正式な見積り書を取得されたことがある場合、早速処理できる為に発注書（PO）と一緒にご提示頂きたいです。');
define('PURCHASE_FORM_TIP_04', 'POの関連ファイルをアップロードしてください。');
define('PURCHASE_FORM_TIP_05', 'パッケージの輸送と追跡、製品のカスタマイズニーズなど、ご要望がございましたらコメントを残してください。');
define('PURCHASE_FORM_TIP_06', '500文字以内でご入力ください。');

define('PURCHASE_FORM_TIP_07', 'ご発注書は正常に送信されました。');
define('PURCHASE_FORM_TIP_08', '弊社は12～24時間以内にご注文を早速に処理いたします。また、<a href="'.zen_href_link('purchase_order_list').'">PO提出/履歴</a>で更新ステータスを確認することもできます。');

define('PURCHASE_LIST_01','新しいPOを提出');
define('PURCHASE_LIST_02','マイPOリスト');
define('PURCHASE_LIST_03','PO番号#');
define('PURCHASE_LIST_04','作成日');
define('PURCHASE_LIST_05','ステータス');
define('PURCHASE_LIST_06','注文番号#');
define('PURCHASE_LIST_07','提出済み');
define('PURCHASE_LIST_07_TIP','ご提出頂いたPO情報は以下のとおりです。12～24時間以内に返信致します。');
define('PURCHASE_LIST_08','承認済み');
define('PURCHASE_LIST_08_TIP','ご発注書（PO）が承認されましたので、FS注文を発行する処理を行っております。');
define('PURCHASE_LIST_09','ご注文が発行されました');
define('PURCHASE_LIST_09_TIP','ご発注書（PO）による注文が正常に発行されました。そして、[今すぐ支払う]ボタンをクリックして支払いを完了し、[FSXXX]で注文状況を確認できます。');
define('PURCHASE_LIST_09_TIP1','ご発注書（PO）注文が正常に発行され、現時点は処理中でございます。「FSXXX」から最新の状態を確認できます。');
define('PURCHASE_LIST_EMPTY_01','PO履歴なし');
define('PURCHASE_LIST_EMPTY_02','ご発注書は見つかりません。');
define('PURCHASE_LIST_FORM_01','ご注文を迅速に処理するために、必要なすべての情報がご発注書（PO）に含まれていることをご確認ください。');
define('PURCHASE_LIST_FORM_02','発注番号');
define('PURCHASE_LIST_FORM_03','例：RQC2001020006');
define('PURCHASE_LIST_FORM_04','パッケージの輸送と追跡、製品のカスタマイズニーズなど、ご要望がございましたらコメントを残してください。 ');

define('PURCHASE_PO_DETAILS','発注書の詳細');
define('PURCHASE_PO_DETAILS_DATE','発注書提出日:');
define('PURCHASE_PO_DETAILS_QT','見積番号 #:');
define('PURCHASE_PO_DETAILS_REQUEST','発注書の詳細');
define('PURCHASE_PO_DETAILS_FILES','ファイル:');

//邮件
define('PURCHASE_EMAIL_REVIEWING','ご発注書（PO)を審査中');
define('PURCHASE_EMAIL_TITLE','FS-ご発注書#POXXXは審査中でございます。');
define('PURCHASE_EMAIL_CONTENT_01','ご発注書PO#POXXXを受け取りました。弊社のチームが12～24時間以内にご確認および処理いたします。');
define('PURCHASE_EMAIL_CONTENT_02','アカウントにログインして、<a href="'.zen_href_link('purchase_order_list').'" target="_blank" style="color: #0070bc;text-decoration: none;">注文書提出/履歴</a>をクリックし、最新の状態を確認することができます。');

define('PURCHASE_PROCESS_TIP','ログインまたはアカウントを作成してPOファイルを送信し、そのステータスをオンラインでタイムリーに追跡することはできます。 
');
define('PURCHASE_PROCESS_TITLE','発注書のプロセスはどのように進めるのですか？');
define('PURCHASE_PROCESS_01','POを送信');
define('PURCHASE_PROCESS_01_TIP','発注書（PO）ファイルを送信します。');
define('PURCHASE_PROCESS_02','POの審査・承認');
define('PURCHASE_PROCESS_02_TIP','POが承認されると、FSはオンライン注文を作成します。');
define('PURCHASE_PROCESS_03','注文の支払いと配送');
define('PURCHASE_PROCESS_04','注文をご予約頂いたら、さらに注文を処理して発送プロセスに入るためにオンラインで支払いを完了してください。もし掛売口座をお持っているお客様の場合、POが承認された直後にご注文を早速に処理いたします。製品納品後でお支払いを頂ければよろしいです。');
define('PURCHASE_PROCESS_05','注文の追跡状況の詳細については、「<a href="'.zen_href_link('manage_orders').'" class="alone_a">注文履歴</a>」ページに確認してください。');
