<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP',"姓をご入力ください。");
define('FS_FIRST_MIN_TIP',"姓を1文字以上でご入力ください。");
define('FS_FIRST_MAX_TIP',"姓を最大32文字までご入力ください");
// lastname
define('FS_LAST_REQUIRED_TIP',"名をご入力ください。");
define('FS_LAST_MIN_TIP',"名を1文字以上でご入力ください。");
define('FS_LAST_MAX_TIP',"名を最大32文字までご入力ください。");
// email
//define('FS_YOUR_EMAIL_ADDRESS',"あなたのメールアドレス");
define('FS_YOUR_EMAIL_ADDRESS',"メールアドレス");
define('FS_EMAIL_REQUIRED_TIP',"メールアドレスをご入力ください。");
define('FS_EMAIL_FORMAT_TIP',"有効なメールアドレスをご入力ください。");
define('FS_EMAIL_HAS_REGISTERED_TIP',"このメールアドレスは既に登録されています。");
define('FS_EMAIL_HAS_REGISTERED_TIP1',"すみません、このメールアドレスはすでに登録されたので、どうぞ、他のメールアドレスをログインします、またはアカウントを持つことを選択します。");
define('FS_EMAIL_NOT_FOUND_TIP',"このメールアドレスは登録されていません。");
define('FS_EMAIL_NOT_ACTIVED_TIP','ごめんなさい！このメールボックスが活性化されていません、アカウントを有効にしてログインしてください。');
define('FS_EMAIL_HAS_REGISTERED_TIP_01',"アカウントはすでに存在しています。ここをクリックして<a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'>ログイン</a>してください。");
// new email
define('FS_NEW_EMAIL_ADDRESS','新しいメールアドレス');
define('FS_NEW_EMAIL_REQUIRED_TIP',"新しいメールアドレスをご入力ください。");
// confirm new email
define('FS_CONFIRM_NEW_EMAIL','新しいメールアドレス再入力');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP',"新しいメールアドレスを再度ご記入ください。");
define('FS_NEW_EMAIL_MATCH_TIP',"メールアドレスが一致しません。");
// password
define('FS_PASSWORD_REQUIRED_TIP',"パスワードをご入力ください。");
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"使用しているパスワードをご入力ください。");
define('FS_PASSWORD_FORMAT_TIP',"最低6文字をご入力ください。少なくとも1つの英字と1つの数字を含める必要があります。");
define('FS_PASSWORD_ERROR_TIP',"パスワードが間違っています。 もう一度お試しください。");
define('FS_OLD_PASSWORD_ERROR_TIP',"ご入力された旧パスワードは正しくないです、もう一度試してください。");
// confirm password
define('FS_CONFIRM_PASSWORD',"パスワード確認"); // 只有注册表单才需要
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"新しいパスワードをご確認ください。");
define('FS_PASSWORD_MATCH_TIP',"パスワードが一致しません。");
// new password
define('FS_NEW_PASSWORD','新しいパスワード');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"新しいパスワードをご入力ください。");
define('FS_PASSWORD_REQUIREMENT',"ご入力されたパスワードは");
define('FS_PASSWORD_REQUIREMENT1',"6文字以上でなければならないようにします；");
define('FS_PASSWORD_REQUIREMENT2',"少なくとも1つの字母と1つの数字を含んでいます。");
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD','新しいパスワード確認');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP',"新しいパスワードをご確認ください。");
define('FS_PASSWORD_DIFFERENT','新しいパスワードは以前のパスワードと異なる必要があります。');
define('FS_NEW_PASSWORD_MATCH_TIP',"新しいパスワードは一致している必要があります。");
//验证码
define('FS_IMAGE',"画像");
define('FS_TRY_DIFFERENT_IMAGE',"別の画像をお試しください。");
define('FS_TYPE_CHAR',"文字を入力する");
define('FS_IMAGE_FORM_TIP',"この画像に表示されるために文字を入力します。");
// AGREE
define('FS_AGREE_REQUIRED_TIP',"このプライバシーポリシーにご同意いただくことが必須となります。");
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP',"会社名をご記入ください。");
define('FS_COMPANY_NAME_MIN_TIP',"会社名は2文字以上の入力が必須です。");
define('FS_COMPANY_NAME_MAX_TIP',"会社名は300文字以上の入力が必須です。");
//industry
//define('FS_INDUSTRY_REQUIRED_TIP',"あなたの会社が属する業界をご選択ください。");
define('FS_INDUSTRY_REQUIRED_TIP',"会社に属する業界をお選びください。");
//industry
define('FS_SELECT_INDUSTRY','業界を選択する');

//TAX/VAT
define('FS_TAX_FORMAT_TIP','例：DE123456789');
define('FS_TAX_REQUIRED_TIP','税番号を入力してください。');
define('FS_TAX_FORMAT_TIP','有効なTAX/VATの例：DE123456789');
define('FS_TAX_FORMAT_ARGENTINA_TIP','有効な税番号（例：00.000.000 / 0000-00）を入力してください。');
define('FS_TAX_FORMAT_BRAZIL_TIP','有効な税番号（例：00-00000000-0）を入力してください。');
define('FS_TAX_FORMAT_CHILE_TIP','税番号は最低7桁でなければなりません。');
//phone
define('FS_PHONE_REQUIRED_TIP','電話番号をご入力ください。');
define('FS_PHONE_FORMAT_TIP','少なくとも7つの数字を入力してください。');
//国家
define('FS_SEARCH_YOUR_COUNTRY','国/地域を検索する');
define('FS_COUNTRY_REQUIRED_TIP','国/地域を選択してください。');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP','製品数量は必要とされます。');
define('FS_PRODUCT_QTY_FORMAT_TIP','こちらの商品の数量が無効です。お手数ですが、ご修正の上、再度お試しください。');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP','コメント/質問は必要とされます。');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP','お手数ですが、一つお選びください。');
define('FEEDBACK_TOPIC_REQUIRED_TIP','トピックをお選びください。');
define('FEEDBACK_CONTENT_REQUIRED_TIP','10文字以上ご入力ください。');
// review
define('FS_REVIEW_RATING_REQUIRED_TIP','該当製品をご評価ください。');
define('FS_REVIEW_TITLE_REQUIRED_TIP','レビューの件名は必須です。');
define('FS_REVIEW_TITLE_MIN_TIP','タイトルは3文字以上ご入力ください。');
define('FS_REVIEW_TITLE_MAX_TIP','ご入力された文字が100文字を超えていますので、タイトルを簡略化してください。');
define('FS_REVIEW_CONTENT_REQUIRED_TIP','レビューの本文は必須です。');
define('FS_REVIEW_CONTENT_MIN_TIP','レビュの本文は10文字以上ご入力ください。');
define('FS_REVIEW_CONTENT_MAX_TIP',"レビューを5000文字以下にしてください。");
// my case
define('FS_CASE_TYPE_REQUIRED_TIP','サービスタイプをお選びください。');
define('FS_CASE_CONTENT_REQUIRED_TIP','リクエストをより迅速に処理できる様に質問をご説明ください。');
define('FS_CASE_CONTENT_MAX_TIP','3,000文字を超えないでください。');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP','ご希望の新しいご利用枠を入力してください。');
define('FS_APPLY_MONEY_FORMAT_TIP','最大2桁まで小数点の有効金額をご入力ください。');
define('FS_APPLY_MONEY_REASON_TIP','ご利用枠変更の理由を入力してください。');

define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'タイトルをご入力ください。');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW','レビューの本文をご入力ください。');

define('FS_OLD_PASSWORD_REASON','旧パスワードが間違っていますので、もう一度お試しください。');
