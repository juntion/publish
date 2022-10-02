<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
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
// $Id: gv_faq.php 4155 2006-08-16 17:14:52Z ajeh $
//

define('NAVBAR_TITLE', TEXT_GV_NAME . ' FAQ');
define('HEADING_TITLE', TEXT_GV_NAME . ' FAQ');

define('TEXT_INFORMATION', '<a name="Top"></a>
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=1','NONSSL').'">Baschaffung ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=2','NONSSL').'">Wie sendet man ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=3','NONSSL').'">Einkaufen mit ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=4','NONSSL').'">Einlösen ' . TEXT_GV_NAMES . '</a><br />
  <a href="'.zen_href_link(FILENAME_GV_FAQ,'faq_item=5','NONSSL').'">Wenn Probleme aufgetreten sind</a><br />
');
switch ($_GET['faq_item']) {
  case '1':
define('SUB_HEADING_TITLE','Beschaffung ' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT', TEXT_GV_NAMES . ' sind eingekauft ebenso wie die andere Artikel in unserem Laden. Sie können unter Verwendung einer normalen Zahlungsmethode von dieser Firma für die Artikel zahlen.
  Sobald Sie die Artikel eingekauft haben, wird ein Gutschein von ' . TEXT_GV_NAME . ' wert zu Ihrer persönlichen Konto hinzugefügt.
   ' . TEXT_GV_NAME . ' . Wenn Sie noch Fond in Ihrem ' . TEXT_GV_NAME . 'Konto haben, werden Sie den Betrag durch den Einkaufswagen erfahren, und wird Ihnen eine verbindung geboten, mit der Sie zu einer Seite gehen können, wo Sie durch E-mail ' . TEXT_GV_NAME . ' zu jemandem senden können.');
  break;
  case '2':
define('SUB_HEADING_TITLE','Wie sendet man' . TEXT_GV_NAMES);
define('SUB_HEADING_TEXT','Um ein ' . TEXT_GV_NAME . ' zu senden, sollen Sie zu unserer Sendenseite' . TEXT_GV_NAME . ' gehen. Sie können die Verbindung zu dieser Seite rechterseits von jeder Seite im Kasten des Einkaufswagens finden.
  Wenn Sie eien ' . TEXT_GV_NAME . ' senden möchten, sollen Sie die Folgenden genau angeben.
  Der Name der Person, zu der Sie ' . TEXT_GV_NAME . ' senden.
  Die E-mailadresse der Person, zu der Sie ' . TEXT_GV_NAME . ' senden.
  Die Menge, die Sie senden möchten (Notiz: Sie müssen nicht alles in Ihrem Konto ' . TEXT_GV_NAME . ' senden.)
  Eine kurze meldung wird in der E-mail sein.
  Bitte stellen Sie sicher, dass Sie alle Informationen richtig eingegeben haben. Wenn auch Sie noch Gelegenheit haben, die Informationen bevor Senden so viel wie möglich zu bearbeiten.');
  break;
  case '3':
  define('SUB_HEADING_TITLE','Einkaufen mit ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Wenn Sie Fond in Ihrem ' . TEXT_GV_NAME . ' Konto haben, können Sie die Fond für Einkaufen der anderen Produkte in unserer Firma benutzen. Bei der Zahlung wird ein zusätzlicher Kasten auftreten. Geben Sie einen Anzahl ein, dann können Sie die Fond in Ihrem Konto ' . TEXT_GV_NAME . ' beantragen.
  Bitte achten, Sie werden eine andere Zahlungsmethode wählen müssen, wenn die Fond in Ihrem Konto ' . TEXT_GV_NAME . ' nicht genug für das zu kaufende Produkt sind.
  Wenn die Fond im Konto ' . TEXT_GV_NAME . ' mehr als die Gesamtsumme der Produkte sind, bleibt der Rest ih Ihrem Konto ' . TEXT_GV_NAME . ' für die Zukunft.');
  break;
  case '4':
  define('SUB_HEADING_TITLE','Einlösen ' . TEXT_GV_NAMES);
  define('SUB_HEADING_TEXT','Wenn Sie eine ' . TEXT_GV_NAME . ' durch E-mail, wird es Details von der Person enthalten, die Ihnen die' . TEXT_GV_NAME . ' senden, zusammen mit einer kurzen Meldung von ihnen. Die E-mail enthält auch
  ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . '. Es ist vielleicht eine gute Idee, diese E-mail für die zukunftigen Referenzen zu drucken. Jetzt können Sie den ' . TEXT_GV_NAME . ' in zwei Tagen einlösen.<br /><br />
  1. Klicken Sie auf die Verbindung, die die E-mailadresse für diesen Expresszweck.
 Durch Diese Verbindung können Sie zur Einlösungsseite ' . TEXT_GV_NAME . ' unseres Ladens gehen. Dann sollen Sie ein Konto errichten, bevor' . TEXT_GV_NAME . ' validiert und zu Ihrem Konto ' . TEXT_GV_NAME . ' geschickt wird, die Sie irgendwenn in der Zukunft ausgeben möchten.<br /><br />
  2. Während des Zahlungsprozesses wird es einen Kasten auf der selben Seite für Auswahl der Zahlungsmethode geben, der für Sie die Einlösungskode ' . TEXT_GV_REDEEM . 'eingeben ist. Geben Sie die Kode' . TEXT_GV_REDEEM . ' hier, und klicken Sie auf den Knopf Einlösen
 Die Kode wird validiert und die Geldsumme wird zu Ihrem Konto ' . TEXT_GV_NAME . ' hinzugefügt. Dann können Sie das Geld für Einkaufen irgendwelches Produktes bei unserem Laden benutzen.');
  break;
  case '5':
  define('SUB_HEADING_TITLE','Wenn Problem auftritt.');
  define('SUB_HEADING_TEXT','Für jede Anforderung in Bezug auf ' . TEXT_GV_NAME . ' System, bitte contaktieren Sie unseren Laden durch E-mail zu '. STORE_OWNER_EMAIL_ADDRESS . '. Bitte stellen Sie sicher, dass Sie uns die Informationen so viel wie möglich in der E-mail geben. ');
  break;
  default:
  define('SUB_HEADING_TITLE','');
  define('SUB_HEADING_TEXT','Bitte wählen Sie eine von den Fragen droben.');

  }

  define('TEXT_GV_REDEEM_INFO', 'Bitte geben Sie Ihre ' . TEXT_GV_NAME . ' Einlösungskode: ');
  define('TEXT_GV_REDEEM_ID', 'Einlösungskode:');
?>