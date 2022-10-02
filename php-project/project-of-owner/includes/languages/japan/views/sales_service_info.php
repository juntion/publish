<?php

define('FS_SALES_INFO_TITLE','RMA（返品・交換）');
define('FS_SALES_INFO_TYPE1','返金');
define('FS_SALES_INFO_TYPE2','交換');
define('FS_SALES_INFO_TYPE3','修理');
define('FS_SALES_INFO_TYPE_SELECT_TIPS','返品の種類をお選びください。');
define('FS_SALES_INFO_Qty','数量：');
define('FS_SALES_INFO_VALIDATE_MAG1','この項目は必須です。');
define('FS_SALES_INFO_REASON','理由：');
define('FS_SALES_INFO_REASON_SELECT','一つをお選びください');//*
define('FS_SALES_INFO_REASON_SELECT_TIPS','1つの理由をお選びください。');
define('FS_SALES_INFO_SERIES_NUMBER_TIPS1','シリアル番号を追記すればより早速プロセスを対処させることに役たちます。');
define('FS_SALES_INFO_SERIES_NUMBER_TIPS2','異なるシリアル番号は「"; , /」で区切ることができます。');
define('FS_SALES_INFO_FMS_TIPS','該当アイテムには以下の製品が含まれています。');
define('FS_SALES_INFO_ADS_TIPS','元の配送先への配送');
define('FS_SALES_INFO_ADS_ADD','新規アドレスを追加');
define('FS_SALES_INFO_RADIO_NONE','まだ製品を選んでいません。');
define('FS_SALES_INFO_CANCEL','Cancel');//*
define('FS_SALES_INFO_SUBMIT','提出');
define('FS_SALES_INFO_INTRODUCE_TITLE','返品説明：');
define('FS_SALES_INFO_CREATE_ADS','配送先をご確認');
define('FS_SALES_INFO_CREATE_ADS_TITLE','デフォルトでは、次のアドレスは元の注文の配送先と同じです。');

//退换货改版2020.3.16 dylan Add
define('FS_SALES_INFO_SERIES_NUMBER','シリアル番号を追加');
define('FS_SALES_INFO_STEPS_TIPS1','1. 返品の種類をご選択');
define('FS_SALES_INFO_STEPS_TIPS2','2. 返却アイテムをご選択');
define('FS_SALES_INFO_STEPS_TIPS3','3. 返品理由をご選択');
define('FS_SALES_INFO_STEPS_TIPS4','4. 返金方法をご選択');
define('FS_SALES_INFO_STEPS_TIPS5','4. 配送先をご記入');
define('FS_SALES_INFO_COMMENTS','追加コメント');
define('FS_SALES_FILE_UPLOAD','ファイルをアップロード');
define('FS_SALES_INFO_COMMENTS_HOLDER','製品上の問題および実際のアプリケーション環境などに関しては、詳しくご説明を頂けますと幸いです。');
define('FS_SALES_INFO_COMMENTS_ERROR','返品リクエストの理由についてコメントを記入してください。');
define('FS_SALES_INFO_RETURN_TO_TYPE1','クレジットカード');
define('FS_SALES_INFO_RETURN_TO_TYPE1_TIPS','お支払された方法と同じ方法で<br>ご返金いたします。');
define('FS_SALES_INFO_RETURN_TO_TYPE2','FSクレジットアカウントに保管');
define('FS_SALES_INFO_RETURN_TO_TYPE2_TIPS','今後のご注文にご利用いただけます。');
define('FS_SALES_INFO_FILE_UPLOAD','許可されているファイルタイプはPDF、JPG、PNGです。<br>ファイルサイズは最大5Mです。');
define('FS_SALES_INFO_SHIP_TO_1','代替品のお届け先');
define('FS_SALES_INFO_SHIP_TO_TIPS_1','これは、代替品のお届け先の住所です。');
define('FS_SALES_INFO_SHIP_TO_2','修理品のお届け先');
define('FS_SALES_INFO_SHIP_TO_TIPS_2','これは、修理品のお届け先の住所です。');
define('FS_SALES_INFO_INTRODUCE_CONT1','FSがRMA申請を早速的に対処できるように、対象製品ごとに、出荷された内容のすべてを、また、製品の説明書、付属品、商標、オリジナル包装なども、必ず一緒にご返送くださいますようお願いいたします。');
define('FS_SALES_INFO_INTRODUCE_CONT2','「RMA申請フォーム」は必ず製品と一緒に梱包してご返送ください。RMAのない返品・交換を受け付けませんので、ご了承ください。');
define('FS_SALES_INFO_INTRODUCE_CONT3','一つの段ボールに複数のRMAを返送する場合は、必ずパッケージに各「RMA申請フォーム」を同梱してください。また、返品部門が早速に識別できるようにボックス内の製品をちゃんとマークを付けてください。');
define('FS_SALES_INFO_INTRODUCE_CONT4',' 弊社の返品規則には特定の製品が含まれないこともありますので、何かご不明な点がございましたら、お問い合わせください。');

define('FS_SALES_INFO_SERVICE_TYPE_1','ご問題の種類');
define('FS_SALES_INFO_SERVICE_TYPE_2','製品はうまく機能できなかった');
define('FS_SALES_INFO_SERVICE_TYPE_3','間違った製品を注文しちゃった');
define('FS_SALES_INFO_SERVICE_TYPE_4','必要なかった');
define('FS_SALES_INFO_SERVICE_TYPE_5','間違った製品を受け取った');
define('FS_SALES_INFO_SERVICE_TYPE_6','示すものと合わなかった');
define('FS_SALES_INFO_SERVICE_TYPE_7','到着時に破損された');
define('FS_SALES_INFO_SERVICE_TYPE_8','思いどおりにならなかった');
define('FS_SALES_INFO_SERVICE_TYPE_9','その他の問題');

define('FS_SALES_INFO_SERVICE_SPE_FMS_TIPS','トランスポンダー/マックスポンダーと100G CFPモジュールを組み合わせてご返送ください。');

define('RMA_RETURN_WIN_01','RMA番号# #RMA_NUMBER#が承認されました。');
define('RMA_RETURN_WIN_02','RMA申請フォームを印刷し、製品と一緒にご返送くださいますようお願いいたします。');
define('RMA_RETURN_WIN_03','RMA番号# #RMA_NUMBER#が正常に送信されました。');
define('RMA_RETURN_WIN_04','該当申請が承認されたら、RMA申請フォームを印刷し、製品と一緒にご返送くださいますようお願いいたします。');

define('RMA_RETURN_IS_SOFTWARE', 'すいませんが、このソフトウェアは返品サービスに適用できかねます。もし何かご不明な点がございましたら、ご専任なアカウントマネージャーにお問い合わせください。');
define('FS_SALES_COMMENTS_OPTIONAL', '追加コメント(任意)');
define('RMA_RETURN_CHANGE', '変更する');
?>