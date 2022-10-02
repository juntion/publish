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

define('NAVBAR_TITLE', 'Nouvelles de Boutique');
define('NAVBAR_TITLE_COMMENTS', 'Commentaires');
define('HEADING_TITLE', 'Nouvelles de Boutique');

define('DATE_FORMAT_NEWS', DATE_FORMAT_SHORT . ' - %I:%M %p');

define('TEXT_ARTICLE_BY_LINE', 'par %s');

define('TEXT_NO_NEWS_COMMENTS', 'Aucun commentaire n\'a été publié.');

define('ENTRY_NEWS_NAME_ERROR', 'Votre nom doit être ' . ENTRY_NEWS_NAME_MIN_LENGTH . ' caractères');
define('ENTRY_NEWS_COMMENTS_ERROR', 'Votre commentaire doit être ' . ENTRY_NEWS_COMMENTS_MIN_LENGTH . ' caractères');

define('COMMENTS_FIELDSET_LEGEND', 'Publiber un commentaire');
define('COMMENTS_FIELDSET_NAME', 'Nom:');
define('COMMENTS_FIELDSET_SUBJECT', 'Sujet:');
define('COMMENTS_FIELDSET_COMMENTS', 'Commentaires:');

define('TEXT_COMMENTS_MUST_LOGIN', 'Vous devez <a href="%s">vous connecter</a> pour soumettre un commentaire.');

define('SUCCESS_NEWS_COMMENTS_SUBMITTED', 'Votre commentaires ont été soumis avec succès');

define('TEXT_NEWS_FOOTER', 'Nouvelles pour %s');
define('TEXT_NEWS_FOOTER_OTHER', 'Autres nouvelles pour %s');
define('TEXT_NEWS_FOOTER_URL', '<u>Voir toutes les nouvelles pour %s sur une page</u>');

define('TEXT_RECENT_NEWS', 'Nouvelles Récentes');

define('TEXT_NEWS_ARCHIVE_LINK', 'Archive des nouvelles');

// email stuff
define('EMAIL_NOTIFICATION_SUBJECT', 'Un commentaire de nouvelles a été soumis');
define('EMAIL_NOTIFICATION_TEXT_INTRO', 'Quelques commentaires de nouvelles ont été soumis à ' . STORE_NAME . '.');
define('EMAIL_NOTIFICATION_TEXT_BODY', '
Soumis par:  %s<br>
Article commenté sur:  <a href="%s">%s</a><br>
Commentaires URL:  %s
');
?>