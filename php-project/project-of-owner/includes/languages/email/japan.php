<?php

// /****************************公共头部***********************************/
// define('EMAIL_HEAHER_RIGHT', '光通信業界で世界一流の<br>供給業者になる');
// define('EMAIL_MENU_HOME','ホーム');
// define('EMAIL_HOME_URL','http://www.fs.com/jp');
// define('EMAIL_MENU_SUPPORT','サポート');
// define('EMAIL_SUPPORT_URL','https://www.fs.com/jp/support.html');
// define('EMAIL_MENU_TUTORIAL','チュートリアル');
// define('EMAIL_TUTORIAL_URL','http://www.fs.com/jp/tutorial.html');
// define('EMAIL_MENU_ABOUT_US','会社概要');
// define('EMAIL_ABOUT_US_URL','https://www.fs.com/jp/about_us.html');
// define('EMAIL_MENU_SERVICE','サービス');
// define('EMAIL_SERVICE_URL','http://www.fs.com/jp/service.html');
define('EMAIL_MENU_CONTACT_US','<a href="'.zen_href_link('contact_us','','SSL').'">お問い合わせください</a>');
// define('EMAIL_CONTACT_US_URL','http://www.fs.com/jp/contact_us.html');
// define('EMAIL_MENU_MY_ACCOUNT','私のアカウント');
// define('EMAIL_MY_ACCOUNT_URL','http://www.fs.com/jp/index.php?main_page=my_dashboard');
// define('EMAIL_MENU_CHECK_ORDER','注文状態をチェックする');
// define('EMAIL_CHECK_ORDER_URL','http://www.fs.com/jp/index.php?main_page=manage_orders');

// /****************************公共底部****************************************/
// define('EMAIL_MENU_PURCHASE_HELP','ショッピングヘルプ');
// define('EMAIL_PURCHASE_HELP_URL',zen_href_link('how_to_buy'));
// define('EMAIL_FOOTER_PROMPT','このメールボックスは配信専用です。このメッセージに返信しないようお願いいたします。<br>  他の質問にはサポートセンターまたは電子メール sales@fs.com までにご連絡ください。');
// define('EMAIL_FOOTER_FS_COPYRIGHT','Copyright &copy; 2002-2018 FS.COMはすべての権利を所有します。');

// // fairy add
define('EMAIL_FOOTER_FACEBOOK','FS.COM Facebook');
define('EMAIL_FOOTER_TWITTER','Twitter');
// fairy add 2017.11.28
define('EMAIL_FOOTER_SINCERELY','どうぞ、宜しくお願い致します。');
define('EMAIL_FOOTER_FS_SERVICE','<a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> 顧客サービス');

//装箱页面新增
define("FS_PRODUCT_INFO_SIZE","サイズ:");
define("FS_PRODUCT_INFO_PIECE","ピースで注文する");
define("FS_PRODUCT_INFO_CASE","ケースで注文する(");
define("FS_PRODUCT_INFO_PIS","ピース/ケース)");

define('EMAIL_HEADER_INFO', '
          <!-- 18.6.26头部-->
   <div style="width:100%; height:100%; font-family:lucida Grande, Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#232323; padding:40px 0;background:#f7f7f7;">
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr><td>
                         <table width="650" border="0" align="center" cellpadding="50" cellspacing="0">
                             <tr>
                                 <td style="background:#fff;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                     <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                         <tbody>
                                             <tr>
                                                 <td style="padding-bottom:50px" align="left"><a href="'.zen_href_link('index').'" target="_blank"><img src="http://www.fs.com/images/logo_fs_email01.png"></a></td>
                                                 <td style="padding-bottom:50px" align="right"><a href="tel:+81 345888332" style="color:#232323; text-decoration:none;">+81 345888332</a><br>
                                                 専門家と<a href="'.zen_href_link('customer_service','','SSL',true).'" target="_blank" style="color:#232323;">Live Chat</a></td>
                                             </tr>
                                         </tbody>
                                     </table>');

define('EMAIL_FOOTER_INFO','
          <!-- 18.6.26底部-->
</tr>
<tr>
    <td style="padding: 20px 50px 0px;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" style="padding-bottom:18px">
                    <a href="'.sourceHtml('youtube', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank">
                        <span style="height:18px;width:18px; display:inline-block;">
                            <img src="http://www.fs.com/images/fs_youtube_icon.png" width="18" height="18">
                        </span> 
                    </a> 
                    <a href="'.sourceHtml('facebook', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank"> 
                       <span style="height:18px;width:18px; display:inline-block;">
                               <img src="http://www.fs.com/images/fs_facebook_icon.png" width="18" height="18">
                           </span> 
                    </a> 
                    <a href="'.sourceHtml('twitter', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank"> 
                        <span style="height:18px;width:18px; display:inline-block;">
                            <img src="http://www.fs.com/images/fs_twitter_icon.png" width="18" height="18">
                        </span> 
                    </a> 
                    <a href="'.sourceHtml('linkedin', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank"> 
                        <span style="height:18px;width:18px; display:inline-block;">
                            <img src="http://www.fs.com/images/fs_linkedin_icon.png" width="18" height="18">
                        </span> 
                    </a> 
                    <a href="https://plus.google.com/+Fiberstore" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank"> 
                        <span style="height:18px;width:18px; display:inline-block;">
                            <img src="http://www.fs.com/images/fs_google_icon.png" width="18" height="18">
                        </span> 
                    </a> 
                    <a href="https://community.fs.com/blog/" style="display:inline-block;width:24px;height:24px;margin-right:25px" target="_blank"> 
                        <span style="height:18px;width:18px; display:inline-block;">
                            <img src="http://www.fs.com/images/fs_blog_icon.png" width="18" height="18">
                        </span> 
                    </a>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding-bottom:10px">
                     <a style="color:#232323; font-size:13px; text-decoration:none; margin-right:20px;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('contact_us').'" target="_blank">お問い合わせ </a> 
                     <a style="color:#232323;font-size:13px; text-decoration:none; margin-right:20px;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('my_dashboard').'" target="_blank">私のアカウント</a> 
                     <a style="color:#232323;font-size:13px; text-decoration:none;margin-right:20px;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('privacy_policy').'" target="_blank">情報セキュリティポリシー</a>
                     <a style="color:#232323;font-size:13px; text-decoration:none;" href="'.zen_href_link('how_to_buy').'" target="_blank">ショッピングヘルプ</a>
                </td>
            </tr>
            <tr>
              <td align="left" style="color:#999;padding-bottom: 6px;">このメッセージは自動的に作成されましたので、このメッセージに返信しないでください。</td>
            </tr>
            <tr>
              <td align="left" style="color:#999;">Copyright © 2002-'.date('Y',time()).' <a href="'.zen_href_link('index').'" target="_blank" style="color:#999; text-decoration:none;">fs.com</a> はすべての権利を保有します。</td>
            </tr>
        </table>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</div>');


define('EMAIL_HEADER_INFO_EU', '
      <!-- 新版头部-->
     <div style="width:100%; height:100%; font-family:lucida Grande, Verdana, Arial, Helvetica, sans-serif; font-size:12px; line-height:22px; color:#232323; padding:40px 0;">
    <table width="650" border="0" align="center" cellpadding="40" cellspacing="0">
        <tbody><tr>
            <td style="border:20px solid #e5e5e5; background:#fff;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="padding-bottom:60px" align="left"><a href="'.zen_href_link('index').'" target="_blank"><img src="http://www.fs.com/images/logo_fs_01.gif"></a></td>
                    <td style="padding-bottom:60px" align="right"><a style="color:#232323; text-decoration:none;">+49 (0) 89 414176412</a><br>
                        <a href="'.reset_url('service/fs_support.html').'" target="_blank" style="color:#232323;">Live Chatします</a>専門家</td>
  		</tr>
  		</tbody>
  		</table>');

define('EMAIL_FOOTER_INFO_EU', '
        <!-- 新版底部-->
             </tr><tr>
            <td style="background:#e5e5e5; padding:10px 0 30px 0;">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>   
					<tr>
						<td align="center" style="padding-bottom:15px">
							<a href="'.sourceHtml('youtube', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_youtube_icon.png" width="24" height="24"></span>
							</a>
							<a href="'.sourceHtml('facebook', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_facebook_icon.png" width="24" height="24"></span>
							</a>
							<a href="'.sourceHtml('twitter', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_twitter_icon.png" width="24" height="24"></span>
							</a>
							<a href="'.sourceHtml('linkedin', false).'" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_linkedin_icon.png" width="24" height="24"></span>
							</a>
							<a href="https://plus.google.com/+Fiberstore" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_google_icon.png" width="24" height="24"></span>
							</a>
							<a href="https://community.fs.com/blog/" style="display:inline-block;width:24px;height:24px;margin-right:25px">
								<span style="height:24px;width:24px; display:inline-block;"><img src="http://www.fs.com/includes/templates/fiberstore/images/email_img/fs_blog_icon.png" width="24" height="24"></span>
							</a>
						</td>
					</tr>
                    <tr>
                        <td align="center" style="padding-bottom:5px">
<a style="color:#232323; font-size:13px; text-decoration:none; margin-right:10px;border-right: 1px solid #a6a6a6;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('contact_us').'" target="_blank">お問い合わせ </a>
<a style="color:#232323;font-size:13px; text-decoration:none; margin-right:10px;border-right: 1px solid #a6a6a6;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('my_dashboard').'" target="_blank">私のアカウント</a>
<a style="color:#232323;font-size:13px; text-decoration:none; margin-right:10px;border-right: 1px solid #a6a6a6;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('privacy_policy').'" target="_blank">情報セキュリティポリシー</a>
<a style="color:#232323;font-size:13px; text-decoration:none; margin-right:10px;border-right: 1px solid #a6a6a6;line-height: 12px;display: inline-block;padding-right: 10px;" href="'.zen_href_link('how_to_buy').'" target="_blank">ショッピングヘルプ</a>
<a style="color:#232323;font-size:13px; text-decoration:none; margin-right:10px;" href="'.zen_href_link('imprint').'" target="_blank">法的通知</a>
					</td>
                    </tr>
                    <tr>
                        <td align="center" style="color:#999;padding-bottom:5px">このメッセージは自動的に作成されましたので、このメッセージに返信しないようお願いいたします。</td>
                    </tr>
                    <tr>
                        <td align="center" style="color:#999;">Copyright @2002-'.date('Y',time()).'<a href="'.zen_href_link('index').'" target="_blank" style="color:#999; text-decoration:none;">fs.com</a>はすべての権利を保有します。</td>
                    </tr>
                    </tbody>
                    </table>
            </td>
        </tr>
        </tbody></table>');

 /*
 * 客户分享产品邮件
 */
define('FS_EMAIL_PRODUCT_SHARE1','私はあなたが');
define('FS_EMAIL_PRODUCT_SHARE2','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE3','私はあなたがFS.COMからこのアイテムに興味があると思います。 ');
define('FS_EMAIL_PRODUCT_SHARE4','もっと見る');
define('FS_EMAIL_PRODUCT_SHARE5','真摯に');
define('FS_EMAIL_PRODUCT_SHARE6','FS.COM');
define('FS_EMAIL_PRODUCT_SHARE7',' 顧客サービスチーム ');
define('FS_EMAIL_PRODUCT_SHARE8','こちらの電子メールはお友達');
define('FS_EMAIL_PRODUCT_SHARE9','の「お友達と共有する」サービスを利用するように送られました。このメッセージを受け取るには、お客様は');
define('FS_EMAIL_PRODUCT_SHARE10','https://www.fs.com/jp');
define('FS_EMAIL_SHARE_TITLE_ONE','FS.COM - あなたのお友達');
define('FS_EMAIL_SHARE_TITLE_TWO','はあなたにこのアイテムをお薦めします');
define('FS_EMAIL_PRODUCT_SHARE11','さんよりのメッセージ');
define('FS_EMAIL_PRODUCT_SHARE12','からこのアイテムに興味があると思います。');
define('FS_EMAIL_PRODUCT_SHARE13','，からの迷惑メールを受け取ることはありません。私たちをもっも見るには');
define('FS_EMAIL_PRODUCT_USING',' using ');
/*
 *客户联系客服email to us
 */
define('FS_EMAIL_TO_US_TITLE','FS.COM - 顧客サービス自動応答電子メール');
define('FS_EMAIL_TO_US_CONTACT','お時間をいただきありがとうございます ');
define('FS_EMAIL_TO_US_DEAR','お客様 ');
define('FS_EMAIL_TO_US_SYSTEM','このシステムメールは、あなたの請求を受け取ったことをお知らせるように発信いたします。 ');
define('FS_EMAIL_TO_US_TEAM','セールスチームはあなたの問題に着手し始めています。そうて、12時間以内にご連絡を差し上げます。');
define('FS_EMAIL_TO_US_REQUIRE','直ちに注意が必要な場合は、即時の注意を必要とする場合、どうぞ、直ちにお電話にてご連絡下さい ');
define('FS_EMAIL_TO_US_FHONE','+1 877 205 5306');
define('FS_EMAIL_TO_US_OR','（米国）または');
define('FS_EMAIL_TO_US_TEL','電話:+49 (0) 89 414176412');
define('FS_EMAIL_TO_US_PHONES','+49 (0) 89 414176412');
define('FS_EMAIL_TO_US_YOU','（ドイツ）。お客様は迅速な対応を得るには');
define('FS_EMAIL_TO_US_LIVE',' live chat');
define('FS_EMAIL_TO_US_GET',' をご利用ください。');
define('FS_EMAIL_TO_US_SALES',' セールスチーム');
define('FS_EMAIL_TO_US_URL',reset_url('service/fs_support.html'));

/*
 * 客户在My account里问销售问题-发给销售和客户
 */
define('FS_EMAIL_MY_ACCOUNT_TITLE','FS.COM - 質問フィードバックの更新');
define('FS_EMAIL_MY_ACCOUNT_YOUR','あなたの質問は現在処理中です。');
define('FS_EMAIL_MY_ACCOUNT_FOR','お客様の質問をご提出いただきありがとうございます！あなたのアカウントマネージャーはあなたの問題に着手し始めています。そうて、12時間以内にご連絡を差し上げます。');
define('FS_EMAIL_MY_ACCOUNT_TIT','タイトル');
define('FS_EMAIL_MY_ACCOUNT_CON','コンテンツ');
define('FS_EMAIL_MY_ACCOUNT_IF','直ちに注意が必要な場合は、即時の注意を必要とする場合、どうぞ、直ちにお電話にてご連絡下さい');
define('FS_EMAIL_MY_ACCOUNT_PHONE','+81 345888332');
define('FS_EMAIL_MY_ACCOUNT_OR',' （米国）または');
define('FS_EMAIL_MY_ACCOUNT_TEL','電話:+49 (0) 89 414176412');
define('FS_EMAIL_MY_ACCOUNT_PHONES','+49 (0) 89 414176412');
define('FS_EMAIL_MY_ACCOUNT_MAY','。お客様は迅速な対応を得るには');
define('FS_EMAIL_MY_ACCOUNT_URL',reset_url('service/fs_support.html'));
define('FS_EMAIL_MY_ACCOUNT_LIVE','live chat');
define('FS_EMAIL_MY_ACCOUNT_GET',' をご利用ください。');
/*
 * 线上PO订单上传邮件
 */
define('FS_EMAIL_MY_PO_UP_TITLE','FS.COM - 注文書#のPO＃確認済 ');
define('FS_EMAIL_MY_PO_UP_TITLES','注文書#が確認された ');
define('FS_EMAIL_MY_PO_UP_PO','あなたのPO# ');
define('FS_EMAIL_MY_PO_UP_HAS','は成功にアップロードされました。');
define('FS_EMAIL_MY_PO_UP_THANK','あなたのPOファイルをいただきありがとうございました。以下を利用して請求書のビューまたは印刷することはできます\'');
define('FS_EMAIL_MY_PO_UP_ORDER','注文No.: ');
define('FS_EMAIL_MY_PO_UP_NO',' PO NO.: ');
define('FS_EMAIL_MY_PO_UP_WILL','ご注文はすぐに処理されます。ご注文について更にご質問がございましたら、どうぞお気軽に ');
define('FS_EMAIL_MY_PO_UP_CONTACT','お問い合わせください');
define('FS_EMAIL_MY_PO_UP_SIN','真摯に');
define('FS_EMAIL_MY_PO_UP_CUS',' 顧客サービスチーム ');
define('FS_EMAIL_MY_PO_UP_MY','私の注文');
define('FS_EMAIL_MY_PO_UP_NOW','\' 。 ');
define('FS_EMAIL_MY_PO_UP_URL','https://www.fs.com/jp/manage_orders.html');
define('FS_EMAIL_MY_PO_UP_URLS',zen_href_link());
/*
 * 线上PO订单确认邮件
 */
define('FS_EMAIL_MY_PO_UP_RUR','ご注文#の注文書確認 ');
define('FS_EMAIL_MY_PO_UP_FOR','お買い上げ誠にありがとうございました -  ');
define('FS_EMAIL_MY_PO_UP_YUOR','ご注文書をいただきありがとうございました！こちらはあなたの注文の詳細です。現在はPOの確認を待っています。');
define('FS_EMAIL_MY_PO_UP_NOR','注文No: ');
define('FS_EMAIL_MY_PO_UP_GO','もしお客様はまたPOファイルをアップロードしない場合、どうぞ、こちらの\'');
define('FS_EMAIL_MY_PO_UP_PAGE','\' ページへ進めてPOファイルをアップロードします。お客様はPOファイルを確認していないならば、ご注文を処理しできかねます。ご了承ください。 ');
define('FS_EMAIL_MY_PO_UP_IF','ご注文について更にご質問がございましたら、どうぞお気軽に ');
define('FS_WRITE_OTHER_DEVICES','例えば：Cisco N9K-C9396PX');
define('HPE_LIMIT','特殊材料のためどうぞ、「HP」の互換性を選択し、それにモデル番号をご記入ください。');
define('ARUBA_LIMIT','特殊材料のためどうぞ、「Aruba」の互換性を選択し、それにモデル番号をご記入ください。');

//add by aron
define("EMAIL_CHECKOUT_WAREHOUSE_THANK","ご注文どうもありがとうございました-");
define("EMAIL_CHECKOUT_WAREHOUSE_LIVE","専門家と");
define("EMAIL_CHECKOUT_WAREHOUSE_WITH","Live Chatします");
define("EMAIL_CHECKOUT_WAREHOUSE_SIN","どうぞ、宜しくお願い致します。");
define("EMAIL_CHECKOUT_WAREHOUSE_DEAR","お客様");
define("EMAIL_CHECKOUT_WAREHOUSE_TEAM","顧客サービスチーム ");
define("EMAIL_CHECKOUT_WAREHOUSE_SHPPING","お届け先のアドレス: ");
define("EMAIL_CHECKOUT_WAREHOUSE_TIT","更にご質問がございましたら、どうぞお気軽に ");
define("EMAIL_CHECKOUT_WAREHOUSE_YOUR","あなたのPO#");
define("EMAIL_CHECKOUT_WAREHOUSE_UP","のアップロードに成功しました");
define("EMAIL_CHECKOUT_WAREHOUSE_INVOICE","あなたのPOファイルをいただきありがとうございました。以下のリンクを利用して請求書のビューまたは印刷することはできます");
define("EMAIL_CHECKOUT_WAREHOUSE_ORDERS","私の注文");
define("EMAIL_CHECKOUT_WAREHOUSE_NOW","。");
define("EMAIL_CHECKOUT_WAREHOUSE_CHARGES","送料");
define("EMAIL_CHECKOUT_WAREHOUSE_TOTAL","総計");
define("EMAIL_CHECKOUT_WAREHOUSE_SUBTOTAL","合計");
define("EMAIL_CHECKOUT_WAREHOUSE_PROCESS","ご注文はすぐに処理されます。ご注文について更にご質問がございましたら、どうぞお気軽に");

/**************************************content common text**************************************/
define('EMAIL_BODY_COMMON_FSCOM','FS.COM');
define('EMAIL_BODY_COMMON_DEAR','お客様');
define('EMAIL_BODY_COMMON_THANKS','ありがとうございます');
define('EMAIL_BODY_COMMON_PHONE','電話番号 : ');
define('EMAIL_BODY_COMMON_PARTNER','パートナー');
define('EMAIL_BODY_COMMON_URL_BASE','https://www.fs.com/jp');

define('EMAIL_BODY_COMMON_PLATFORM','プラットフォーム');
define('EMAIL_BODY_COMMON_BROWSER','ブラウザ');
define('EMAIL_BODY_COMMON_IP_ADDRESS','IPアドレス');
define('EMAIL_BODY_COMMON_UNKNOWN','未知');
define('EMAIL_BODY_COMMON_EAMIL_USER','セキュリティ情報のID番号: ');
define('EMAIL_BODY_COMMON_EAMIL_COUNTRY','国家/区域 ');
define('EMAIL_BODY_COMMON_CUSTOMER_NAME','顧客名: ');
define('EMAIL_BODY_COMMON_CUSTOMER_EMAIL','お客様の電子メール: ');

/********************************************* checkout common ****************************************************************/
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT','FS.COM 注文# %s ');
// add by Aron
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBJECT1','FS.COM 注文# %s 確認済 ');
define('EMAIL_CHECKOUT_COMMON_TO_PURCHASE_CUSTOMER_SUBJECT','FS.COM 注文書# %s ');

define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_NO','注文番号');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDERED_ON','注文日');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_BILL_TO','請求先住所');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PAYMENT_METHOD','お支払い方法');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_TO','お届け先の住所');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_VIA','配送方法');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_NAME','アイテム');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FSID','FS ID#');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ITEM_PRICE','商品価格');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_QTY','数量');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_PRICE','価格');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SUBTOTAL','合計');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_SHIP_CHARGE','送料');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_GRAND_TOTAL','総計');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_FS_SKU','FS SKU#');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_PAYPAL','Paypal');
define('EMAIL_CHECKOUT_COMMON_PAYMENT_METHOD_CARD','クレジット/デビットカード');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_VIEW_OR_MANAGE_ORDER','注文を確認/管理する');
define('EMAIL_CHECKOUT_COMMON_TO_CUSTOMER_ORDER_SUMMARY','ご注文の概要');
//2017-12-7  add   ery
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE','FS.COM - 注文 %s が届きましたので、お支払いを完了してください。');
define('EMAIL_CHECKOUT_COMMON_SUCCESS_TITLE_PO','FS.COM - 注文 %s を受け取り、POの確認を待っています。');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TITLE','FS.COM - 注文 %s 支払いを受け取りました。');
define('EMAIL_CHECKOUT_PO','アップロードは成功しました。');
define("FS_MANAGE_ORDERS_FILE","POファイルをアップロードしてください。");

/************************************* checkout paypal or credit card ****************************************/
define('EMAIL_CHECKOUT_PAYPAL_TEXT1','ご注文を承りました。お支払いの確証をお待ちしております。');
define('EMAIL_CHECKOUT_PAYPAL_TEXT2','この度はご注文いただきまして誠にありがとうございました -  ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT3','FS.COM');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4','!下記はお客様の最新の予約注文概要です。ただ最後のワンステップでお支払いが完了できったら、すべての製品は手に入る事になります。');
define('EMAIL_CHECKOUT_PAYPAL_TEXT4_1','!下記はお客様の最新の予約注文概要です。ただ最後のワンステップでお支払いが完了できったら、すべての製品は手に入る事になります。');
define('EMAIL_CHECKOUT_PAYPAL_TEXT5','配達予定日');
define('EMAIL_CHECKOUT_PAYPAL_TEXT6','ご注文について更にご質問がございましたら、どうぞお気軽に ');
define('EMAIL_CHECKOUT_PAYPAL_TEXT7','<a href="'.reset_url('service/fs_support.html').'">お問い合わせください</a>');
define('EMAIL_CHECKOUT_PAYPAL_TEXT8',' 顧客サービスチーム ');
define('EMAIL_CHECKOUT_PAYMENT_SUCCESS_TEXT1','FS.COMで注文いただきどうもありがとうございました。こちらはお支払いを受領しました。私たちはなるべく早めにご注文を処理いたします。何か質問があれば、どうぞお気軽に　　　　　　　　　　　<a href="'.reset_url('service/fs_support.html').'" target="_blank">お問い合わせください</a>。');

/*********************************** orders status *************************************/
define('EMAIL_ORDERS_STATUS_SUBJECT','注文更新 # ');
define('EMAIL_ORDERS_STATUS_FOR_ORDER','注文No:');
define('EMAIL_ORDERS_STATUS_TEXT1','状態が更新されました。どうぞ、www.fs.com/jpの<a href="http://www.fs.com/jp/index.php?main_page=account_history_info&orders_id=$ORDER_ID">「私の注文」</a> にアクセスして詳細をチェックしてください。 ');
define('EMAIL_ORDERS_STATUS_TEXT2','お手伝いが必要であれば、どうぞ	sales@fs.comまでに電子メールを送ってください。または、こちらまでにお電話ください+81 345888332。	私たちは12時間以内にご連絡差し上げます。');
define('EMAIL_ORDERS_STATUS_TEXT3','ご支援に感謝いたします。');
define('EMAIL_ORDERS_STATUS_TEXT4','どうぞよろしくお願いいたします。');
define('EMAIL_ORDERS_STATUS_TEXT5','FS.COMサービスチーム');

/************************************* checkout purchase ****************************************/

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT3","<p style='color:rgb(51,51,51);margin:0;padding:0;'>ご注文いただき再度ありがとうございました！</p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_INTRODUCTION_PURCHASE_ORDER_TEXT4","<p style='color:rgb(51,51,51);margin:0;padding:0;'>FS.COM 顧客サービス</p>");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START1","PO文書のご提出をいただきどうもありがとうございました。お客様は<a href='".zen_href_link('manage_orders')."'  target='_blank'>'「私の注文」");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START2","にアクセスしてPO（発注書）を見ることができます。ご注文はすぐに処理されます。いったん商品が出荷されたら、すぐに追跡番号をお送りいたします。");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START3","ご質問がございましたら、どうぞお気軽に<a href='".zen_href_link('contact_us')."'  target='_blank'>お問い合わせください </a>。");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START4","どうもありがとうございます！");

define("EMAIL_CHECKOUT_WOW_TO_CUSTOMER_START_NO","PO NO  ");

/************************************** sales manager to customer *********************************************/
define('EMAIL_SALES_MANAGER_SUBJECT','管理者はお客様のために購買コンサルタントを指定します -- FS.COM');
define('EMAIL_SALES_MANAGER_TEXT1','良い一日！ <br><br>FS.COMのメンバーになっていただきありがとうございます。 ');
define('EMAIL_SALES_MANAGER_TEXT2','私は');
define('EMAIL_SALES_MANAGER_TEXT3',' あなたのアカウントマネージャーです。 ');
define('EMAIL_SALES_MANAGER_TEXT4','何かニーズまたは弊社の製品またはFS.COMに関する他の関連情報についての質問があれば、どうぞお気軽に私にご連絡ください。あなたにサービスを提供することができると喜びます<br><br><br>
			<span style="font-family:Calibri;font-size:13px;">私の連絡先：</span>');
define('EMAIL_SALES_MANAGER_TEL','電話番号： ');
define('EMAIL_SALES_MANAGER_MOBILE','携帯電話：');
define('EMAIL_SALES_MANAGER_EMAIL','電子メール： ');
define('EMAIL_SALES_MANAGER_TEXT5','（12/7 セールス &amp;サポート）');
define('EMAIL_SALES_MANAGER_TEXT6','<span style="font-family:Calibri;font-size:13px;">Room 301, Third Floor, Weiyong Building, No. 10, Kefa Road, Nanshan District, Shenzhen, 518057, CHINA</span>');
define('EMAIL_SALES_MANAGER_TEXT7','真摯に');

/************************************ backend common *********************************************/
//update orders status 
define('EMAIL_BACKEND_COMMON_PAYMENT_RECEIVED',' お支払いを受領しました');
define('EMAIL_BACKEND_COMMON_YOUR_ORDER','お客様の注文：');
define('EMAIL_BACKEND_COMMON_TEXT1','状態が更新されました：');
define('EMAIL_BACKEND_COMMON_TRACK_INFORMATION','追跡情報：');
define('EMAIL_BACKEND_COMMON_PROCESSING',' 処理中');
define('EMAIL_BACKEND_COMMON_TRACKING_INFO',' 追跡情報');
define('EMAIL_BACKEND_COMMON_TEXT2',' お客様が注文したすべての製品はすでに出荷され、お届け先住所に到着するまでに3～4日かかります。そして、お客様はFS.COMの「私のアカウント」で追跡情報を得ることができます。');
define('EMAIL_BACKEND_COMMON_SHIPPING_METHOD','配送方法：');
define('EMAIL_BACKEND_COMMON_TACKINF_NUMBER','追跡番号：');
define('EMAIL_BACKEND_COMMON_TEXT3','すでに出荷されました。');
define('EMAIL_BACKEND_COMMON_REFUNDED',' 返金した');
define('EMAIL_BACKEND_COMMON_IS_CANCELED',' はキャンセルされました');
define('EMAIL_BACKEND_COMMON_CANCELED','キャンセルした');
define('EMAIL_BACKEND_COMMON_COMPLETED',' 完了した');
define('EMAIL_BACKEND_COMMON_NO_INFO','情報なし');
define('EMAIL_BACKEND_COMMON_TEXT4','Tips: 詳細を見るには、FS.COMのアカウントにログインしてください。何かご質問があれば、どうぞ');
//reviews to customer
define('EMAIL_BACKEND_COMMON_REVIEWS_REPLY_SUBJECT','FS.COMからの新しいレビューに対する返信');
define('EMAIL_BACKEND_COMMON_YOUR_REVIEW','あなたのレビュー：');
define('EMAIL_BACKEND_COMMON_PRODUCTS_NAME_URL','製品名|レビューのURL：');
define('EMAIL_BACKEND_COMMON_REPLY_BY','返信：');
define('EMAIL_BACKEND_COMMON_REPLY_CONTENT','返信内容：');

/*********************************** business account success to customer *************************************************/
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_SUBJECT','お客様の法人アカウントへの申し込みは受け入れられました');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT1','おめでとうございます。法人アカウントへの申し込みは受け入れられました。');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT2','法人アカウントを使用することで、お客様は以下のサービスを楽しむことができます：');
define('EMAIL_BUSINESS_ACCOUNT_SUCCESS_TEXT3','1. $PER割引を楽しむ<br>
        2. 最良の配送方法<br>
        3. プロのアカウントマネージャーと技術サポート<br>
        <br><br>どうぞよろしくお願いいたします。<br><br>
        FS.COM LIMITED');

/************************    customer question to customer     *********************/
define('EMAIL_CUSTOMER_QUESTION_TC_SUBJECT','ご質問はFS.COMに回答されました。');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT1','この質問にご意見をお寄せいただきありがとうございます。');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT2','お客様に包括的なソリューションを更新するのに全力を尽くします。');
define('EMAIL_CUSTOMER_QUESTION_TC_TEXT3','真摯に');

//rma_success   售后单申请成功邮件
define('EMAIL_RMA_SUCCESS_APPROVED_YRR','あなたのRMA申請 # %s は承認されました。');
define('EMAIL_RMA_SUCCESS_APPROVED_YOUR','あなたのRMA申請 # %s は承認されました。オンラインのフローチャートに従い、指定住所に返品荷物を送ってください。');
define('EMAIL_RMA_SUCCESS_APPROVED_WE','こちらは返品パッケージを受け取ったら、すぐに処理いたします。お手伝いが必要であれば、どうぞお気軽に<a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。');
define('EMAIL_RMA_SUCCESS_SUBMIT_YOUR','あなたのRMA申請 # %s は現在審査中です。');
define('EMAIL_RMA_SUCCESS_SUBMIT_WE','こちらはすでにお客様のRMA申込みを受け取り、なるべく早めに処理致します。プロセスに関して詳しくは、あなたのアカウントマネージャーが更新いたします。');
define('EMAIL_RMA_SUCCESS_SUBMIT_FOR','お手伝いが必要であれば、どうぞお気軽に<a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。');
define('EMAIL_RMA_SUCCESS_TITLE','FS.COM - RMA申請 # %s');

/*********************************contact us to customer*************************************/
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT1','あなたの質問を受け取りました。ご返信は12時間以内に送ります。また、12時間以内に返信が届かなかった場合、あなたのゴミボックスをご確認ください。');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT2','クイックヘルプを求める？よくある質問をチェックしてください。ご回答はこちらで見つけるかもしれません。または、サポートのためにアカウントマネージャーまたは顧客サービスセンターにご連絡ください。彼らは常にご質問をお待ちしております。');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT3','8 am.- 5 pm. PST. Mon. to Fri. ：+81 345888332');
define('EMAIL_CONTACT_US_TO_CUSTOMER_TEXT4','PS. このメッセージに返信しないようお願いいたします。メール受信は承りかねますので、あらかじめご了承願います。');
define('EMAIL_CONTACT_US_TO_SUBJECT','あなたからのメッセージに感謝いたします  -- FS.COM');

/************************************regist to customer*********************************************/
define('EMAIL_REGIST_TO_CUSTOMER_SUBJECT','FS.COM - 顧客アカウントの作成');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT1','FS.COMにご登録いただき、誠にありがとうございます。あなたのマイアカウントは成功に作成されました。それにここをチェックして<a href="'.zen_href_link(FILENAME_MY_DASHBOARD,'','SSL').'">\'私のアカウント\'</a>に進めることができます。');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT2','このアカウントを利用することにより、現在以下のサービスが楽しめます：<br />
1. あなたの注文履歴を簡単に追跡する<br />
2. アドレス帳を利用して迅速にチェックアウトできる<br />
3. 電子メール通知設定で新品とプロモーションを更新する<br />
4. 無料＆即時技術支援<br />
<br />
何かの理由で私たちに連絡したい場合、どうぞ当社の<a href="'.zen_href_link(FILENAME_SUPPORT).'" target="_blank">サービスセンター</a>にお問い合わせください。彼らはあなたのアカウント、配達オプション、返品処理など他にすべて関心のあることをご回答いたします。');
define('EMAIL_REGIST_TO_CUSTOMER_TEXT3','ご注意: たとえお客様の電子メールがゴミボックスで見つかられた場合、どうぞ<a href="mialto:sales@fs.com">sales@fs.com</a>を友達として追加してください。 <br />
もう一度、ようこそ<a href="'.zen_href_link(FILENAME_DEFAULT,'','SSL').'">FS.COM</a>へ
<br />
<br />真摯に<br /><br />
FS.COM 顧客サービス<br />
820 SW 34th Street Bldg W7 Suite H, Renton, WA 98057, United States <br />
電話: + 81 345888332<br />');

//fairy
// 个人、企业激活邮件内容
define('EMAIL_REGIST_COMMON_VERIFY_EMAIL','メールアドレスの認証');
define('EMAIL_REGIST_COMMON_VERIFYT_TITLE2','リンクが機能しない場合、あなたブラウザのアドレスバーにこのURLをコピーしてみてください：');
define('EMAIL_REGIST_COMMON_VERIFYT_TIME','このリンクはこの電子メールが送られた3日後に期限切れになります。');
define('EMAIL_REGIST_COMMON_SINCERELY','真摯に');
define('EMAIL_REGIST_COMMON_FS','FS.COM 顧客サービス');
// 个人、企业激活邮件内容
define('EMAIL_REGIST_TO_CUSTOMER_THANK','FS.COMアカウントを設定していただき誠にありがとうございます！');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO','FS.COMアカウントはすべてのすばらしい機能を登録ユーザーに提供します。以下を含む：');
define('EMAIL_REGIST_TO_CUSTOMER_INTRO_DES','<li>あなたの注文履歴を簡単に追跡する</li>
                  <li>アドレス帳を利用して迅速にチェックアウトできる</li>
                  <li>電子メール通知設定で新品とプロモーションを更新する</li>
                  <li>無料＆即時技術支援</li>');
define('EMAIL_REGIST_TO_CUSTOMER_VERIFYT_TITLE','これらの機能が役立つために、下記のリンクをクリックしてあなたの電子メールアドレスを認証してください。');
// 企业激活邮件
define('EMAIL_REGIST_TO_COMPANY_THANK','FS.COM法人アカウントを申し込んでいただき、誠にありがとうございます！');
define('EMAIL_REGIST_TO_COMPANY_INTRO','ご請求は現在審査中です。申請が承認されたら、当社は24時間以内お客様に通知メールを送ります。');
define('EMAIL_REGIST_TO_COMPANY_VERIFYT_TITLE','アカウントの設定を完了するために、下記のリンクをクリックしてあなたの電子メールアドレスを認証してください。');
define('EMAIL_REGIST_TO_COMPANY_THANK_AGAIN','ご協力ありがとうございました。FS.COMを信頼していただき誠にありがとうございます。');
// 个人用户升级企业用户邮件
define('EMAIL_UPGRADE_TO_COMPANY_CONSULT','更にご質問がございましたら、どうぞお気軽に<a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。 ');

//fairy 个人注册
define('EMAIL_REGIST_TO_CUSTOMER_THANK_AGAIN','今はアカウントにアクセスすることができます。更にご要望がございましたら、どうぞ弊社へお気軽に<a href="'.zen_href_link('contact_us').'" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。');

/***************************** password forgotten to customer ***************************************/
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_SUBJECT','FS.COM - パスワード再設定の申請');

// fairy 2017.11.28
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TITLE','どのようにあなたの<a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>アカウントを再設定しますか？');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT1','この電子メールは、ご要望に応じてあなたの<a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> アカウントを修正するために送られました。');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT2','下記のリンクをクリックし、<a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a>サイトにアクセスしてパスワードを再設定してください： ');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_RESET_BUTTON','パスワードを再設定する');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT3','上記のリンクには3日だけ有効である点に注意してください。');
define('EMAIL_PWD_FORGOTTEN_TO_CUSTOMER_TEXT4','もしあなたはこの変更をしていなければ、または未許可の人があなたのアカウントにアクセスしたと思っているならば、すぐに <a href="RESET_PWD_LINK" target="_blank" style="color:#0070BC; text-decoration:none;">パスワードを再設定</a>してください。それから、<a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">ログイン</a>するとあなたのセキュリティ設定をチェックして更新してください。');

/***************************** 修改密码成功之后发的邮件 ***************************************/
// fairy 修改密码成功之后的邮件 add 2017.11.28
define('FS_PWD_UPDATE_SUCCESS_EAMIL_THEME','FS.COM - アカウントパスワードの変更');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_TITLE','パスワードが成功に変更されました ');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON1','あなたの <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>) のパスワードは<b>EMAIL_TIME</b>成功に変更されました');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON2','現在あなたは新しいセキュリティ情報でアカウントにログインすることができます。更にヘルプが必要であれば、どうぞ<a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。');
define('FS_PWD_UPDATE_SUCCESS_EAMIL_CON3','もしお客様はこの変更をしていなければ、または未許可の人があなたのアカウントにアクセスしたと思っているならば、すぐに <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">パスワードを再設定</a>してください。それから、<a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">ログイン</a>してセキュリティ設定をチェックして更新します。');

// fairy 修改密码成功
define('FS_MODIFY_PWD_EAMIL_SUCCESS_THEME','FS.COM - アカウントパスワードの変更');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_TITLE','パスワードが成功に変更されました');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT1','あなたの <a href="'.zen_href_link(FILENAME_DEFAULT).'" target="_blank" style="color:#232323; text-decoration:none;">FS.COM</a> ID (<a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none;"><b>EMAIL_USER_EMAIL</b></a>)  のパスワードは<b>EMAIL_TIME</b>成功に変更されました。');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT2','現在あなたは新しいセキュリティ情報でアカウントにログインすることができます。更にヘルプが必要であれば、どうぞ <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">お問い合わせください</a>。');
define('FS_MODIFY_PWD_EAMIL_SUCCESS_CONTENT3','もしお客様はこの変更をしていなければ、または未許可の人があなたのアカウントにアクセスしたと思っているならば、すぐに <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">パスワードを再設定</a> してください。それから、 <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">ログイン</a> してセキュリティ設定をチェックして更新します。');

/**************************************** company_regist *****************************************************/
define('EMAIL_COMPANY_REGIST_SUBJECT','FS.COM - 法人アカウントの申し込み');
define('EMAIL_COMPANY_REGIST_TEXT1','お客様はより良いビジネス関係を築くために、当社の法人アカウントを申し込んでいただきまして誠にありがとうございます！<br><br>
ご依頼の件は現在審査中です。申請が承認されたら、私たちは24時間以内お客様に通知メールを送ります。');
define('EMAIL_COMPANY_REGIST_TEXT2','よろしくお願い致します。');
define('EMAIL_COMPANY_REGIST_TEXT3','FS.COM 顧客サービス');

// fairy 申请报价之后的邮件
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_THEME','FS.COM - お見積もり依頼 INQUIRY_NUMBER');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE','ご提出頂いたお見積もり依頼 INQUIRY_NUMBERは既に受領致しました。');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_TITLE_SALE','あなたは新しい見積依頼 INQUIRY_NUMBERを持っています。');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT1','お見積もり依頼の詳細は下記でご覧ください。ご専属なアカウントマネージャーは依頼内容を確認でき次第に、早速で返信致します。');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT2','お見積り詳細');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT3','登録ユーザーの場合、自分のアカウントセンターで該当お見積りの進捗を追跡することができます。こちらの<a href="'.zen_href_link('inquiry_list').'" style="color: #0070BC;">アカウントセンター</a>をクリックして、ご確認お願いたします。');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_CONTENT4','お見積もり依頼をご提出頂き誠に感謝致します。ご専属なアカウントマネージャーは依頼内容を確認でき次第に、早速で返信致します。');
define('FS_APPLY_INQUIRY_EAMIL_SUCCESS_RQ_NUMBER','RQ番号');

// 电汇确认信息
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_01','お客様のご注文 ');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_02',' について電子送金による支払いは成功に提出されました。 以下の情報をご確認ください。');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_03','お支払情報');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_04',' 注文番号：');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_05','支払者の名前：');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_06','国家：');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_07','お支払い金額：');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_08','お支払い時間：');
define('EMAIL_CHECKOUT_WESTWIRE_SEND_TO_US_09','支払者の電話番号：');

// fairy 修改邮件成功
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_THEME','FS.COM - 電子メールアドレスの変更');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_TITLE','ご登録メールアドレスは成功に変更されました ');
                                               // 電子メールアドレスは成功に変更されました  06/26/2018 04:27(GMT)
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT1','電子メールアドレスは<b>EMAIL_TIME</b>成功に変更されました。 あなたの新しい電子メールアドレスは <a href="mailto:EMAIL_USER_EMAIL" style="color:#232323; text-decoration:none; font-weight:600;">EMAIL_USER_EMAIL</a>です。');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT2','現在お客様は新しいアドレスを使用してアカウントにログインすることができます。お手伝いが必要であれば、どうぞお気軽に <a href="'.zen_href_link('contact_us').'" target="_blank" style="color:#0070BC; text-decoration:none;">お問い合わせ</a>ください。');
define('FS_MODIFY_EMAIL_SUCCESS_EAMIL_CONTENT3','もしお客様はこの変更をしていなければ、または未許可の人があなたのアカウントにアクセスしたと思っているならば、すぐに <a href="'.zen_href_link('password_forgotten').'" target="_blank" style="color:#0070BC; text-decoration:none;">パスワードを再設定</a> してください。それから、 <a href="'.zen_href_link('login').'" target="_blank" style="color:#0070BC; text-decoration:none;">ログイン</a> してセキュリティ設定を更新してください。');

//add Yoyo 一般的线上付款
define("EMAIL_CHECKOUT_SUCCESS_YOUR"," ご入金が確認されました。");
define("EMAIL_CHECKOUT_SUCCESS_THANK","の支払いを受領しました。ご協力ありがとうございました。");
define("EMAIL_CHECKOUT_SUCCESS_WE","ご注文");

// fairy 修改邮件给销售的
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_THEME','FS.COM - Your Customer\'s Email Address Changed');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_TITLE','Your customer(CUSTOMER_NAME）has changed email address.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT1','The email address of your customer(CUSTOMER_NAME）has been successfully changed on <b>EMAIL_TIME</b>.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT2','Former email address is OLD_EMAIL.');
define('FS_MODIFY_EMAIL_SUCCESS_SALE_EAMIL_CONTENT3','New email address is NEW_EMAIL.');
define('EMAIL_BODY_COMMON_TAX_NUMBER','VAT番号');

//fairy 个人中心用户添加评论，给对应销售发的邮件
define('FS_PRODUCT_REVIEW_SUCCESS_SALE_EMAIL_THEME','FS製品に関する新しい顧客レビュー');
define('FS_CUSTOMER_REVIEWS', '顧客レビュー');
define('FS_REVIEWS_URL', '製品名|レビューURL');
define('FS_REVIEW_RATING', 'レビュー等級');
define('FS_REVIEW_CONTENT', 'レビュー内容');
