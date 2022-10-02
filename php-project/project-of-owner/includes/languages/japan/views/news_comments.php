<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004-2005 Joshua Dechant                               |
// |                                                                      |   
// | Portions Copyright (c) 2004 The zen-cart developers                  |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: news_comments.php v2.000 2004-01-23 dreamscape <dechantj@pop.belmont.edu>
//

define('NAVBAR_TITLE', '店舗ニュース');
define('NAVBAR_TITLE_COMMENTS', 'コメント');
define('HEADING_TITLE', '店舗ニュース');

define('DATE_FORMAT_NEWS', DATE_FORMAT_SHORT . ' - %I:%M %p');

define('TEXT_ARTICLE_BY_LINE', 'により %s');

define('TEXT_NO_NEWS_COMMENTS', '何かコメントが投稿されていませんでした。');

define('ENTRY_NEWS_NAME_ERROR', 'ご名前は' . ENTRY_NEWS_NAME_MIN_LENGTH . '文字以上が必要とされます');
define('ENTRY_NEWS_COMMENTS_ERROR', 'ごコメントは ' . ENTRY_NEWS_COMMENTS_MIN_LENGTH . ' 文字以上が必要とされます');

define('COMMENTS_FIELDSET_LEGEND', 'コメントを投稿する');
define('COMMENTS_FIELDSET_NAME', '名前：');
define('COMMENTS_FIELDSET_SUBJECT', '主題：');
define('COMMENTS_FIELDSET_COMMENTS', 'コメント：');

define('TEXT_COMMENTS_MUST_LOGIN', 'このコメントを投稿するために<a href="%s">お客様はログインする</a>必要があります。');

define('SUCCESS_NEWS_COMMENTS_SUBMITTED', 'あなたのコメントは成功に提出されました。');

define('TEXT_NEWS_FOOTER', 'ニュース %s');
define('TEXT_NEWS_FOOTER_OTHER', '他のニュース %s');
define('TEXT_NEWS_FOOTER_URL', '<u>一枚のページには %s すべてのニュースを見ます</u>');

define('TEXT_RECENT_NEWS', '最近のニュース');

define('TEXT_NEWS_ARCHIVE_LINK', '新しいアーカイブ');

// email stuff
define('EMAIL_NOTIFICATION_SUBJECT', '新しいコメントが提出されました。');
define('EMAIL_NOTIFICATION_TEXT_INTRO', '幾つか新しいコメントはこれに提出されました' . STORE_NAME .  '.');
define('EMAIL_NOTIFICATION_TEXT_BODY', '
投稿より：  %s<br>
文章にコメントを加えます：  <a href="%s">%s</a><br>
コメントへのリンクURL:  %s
');
?>