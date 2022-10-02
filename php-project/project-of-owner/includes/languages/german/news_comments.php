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

define('NAVBAR_TITLE', 'Nachrichten');
define('NAVBAR_TITLE_COMMENTS', 'Kommentare');
define('HEADING_TITLE', 'Nachrichten');

define('DATE_FORMAT_NEWS', DATE_FORMAT_SHORT . ' - %I:%M %p');

define('TEXT_ARTICLE_BY_LINE', 'von %s');

define('TEXT_NO_NEWS_COMMENTS', 'Es gibt noch keine Kommentare.');

define('ENTRY_NEWS_NAME_ERROR', 'Ihr Name muss ' . ENTRY_NEWS_NAME_MIN_LENGTH . ' Schriftzeichens lang sein');
define('ENTRY_NEWS_COMMENTS_ERROR', 'Ihre Kommentare müssen ' . ENTRY_NEWS_COMMENTS_MIN_LENGTH . ' Schriftzeichens lang sein');

define('COMMENTS_FIELDSET_LEGEND', 'Einen Kommentar verfassen');
define('COMMENTS_FIELDSET_NAME', 'Name:');
define('COMMENTS_FIELDSET_SUBJECT', 'Thema:');
define('COMMENTS_FIELDSET_COMMENTS', 'Kommentare:');

define('TEXT_COMMENTS_MUST_LOGIN', 'Sie müssen <a href="%s">einloggen</a> um einen Kommentar einzureichen.');

define('SUCCESS_NEWS_COMMENTS_SUBMITTED', 'Ihr Kommentar ist schon eingereicht worden');

define('TEXT_NEWS_FOOTER', 'Nachricht für%s');
define('TEXT_NEWS_FOOTER_OTHER', 'Andere Nachrichten für %s');
define('TEXT_NEWS_FOOTER_URL', '<u>Alle Nachrichten für %s auf einer Seite</u>');

define('TEXT_RECENT_NEWS', 'Neuliche Nachrichten');

define('TEXT_NEWS_ARCHIVE_LINK', 'Archive der Nachrichten');

// email stuff
define('EMAIL_NOTIFICATION_SUBJECT', 'Einen Kommentar über der Nachricht ist eingereicht worden');
define('EMAIL_NOTIFICATION_TEXT_INTRO', 'Einige Kommentare über der Nachricht sind eingereicht bei ' . STORE_NAME . '.');
define('EMAIL_NOTIFICATION_TEXT_BODY', '
Eingereicht von:  %s<br>
Absatz von Kommentaren uber:  <a href="%s">%s</a><br>
Kommentare URL:  %s
');
?>