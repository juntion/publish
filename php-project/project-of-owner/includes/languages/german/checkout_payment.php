<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: checkout_payment.php 4087 2006-08-07 04:46:08Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Bezahlen — Schritt 1');
define('NAVBAR_TITLE_2', 'Zahlungsmethode - Schritt 2');

define('HEADING_TITLE', 'Schritt 2 von 3 - Zahlungsinformation ');

define('TABLE_HEADING_BILLING_ADDRESS', 'Rechnungsadresse');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Ihre Rechnungsadresse ist nach links gezeigt. Ihre Rechnungsadresse soll mit der Adresse von der Erklärung Ihrer Kreditkarte übereinstimmen. Sie können die Rechnungsadresse durch einen Klick auf den Knopf <em>Adresse ändern</em> ändern.');
define('TITLE_BILLING_ADDRESS', 'Rechnungsadresse:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Zahlungsmethode');
define('TEXT_SELECT_PAYMENT_METHOD', 'Bitte wählen Sie eine Zahlungsmethode für diese Bestellung.');
define('TITLE_PLEASE_SELECT', 'Bitte wählen Sie');
define('TEXT_ENTER_PAYMENT_INFORMATION', '');
define('TABLE_HEADING_COMMENTS', 'Spezielle Weisungen oder Kommentare der Bestellung');

define('TITLE_NO_PAYMENT_OPTIONS_AVAILABLE', 'Nicht verfügbar in dieser Zeit ');
define('TEXT_NO_PAYMENT_OPTIONS_AVAILABLE','<span class="alert">Entschuldigung, zurzeit akzeptieren wir keine Zahlung aus Ihrer Region. </span><br /> Bitte kontaktieren Sie uns für alternative Arrangement.');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>Weiter zum Schritt 3</strong>');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- Ihre Bestellung zu bestätigen.');

define('TABLE_HEADING_CONDITIONS', '<span class="termsconditions">Allgemeine Geschäftsbedingungen(AGB)</span>');
define('TEXT_CONDITIONS_DESCRIPTION', '<span class="termsdescription">Bitte bestätigen Sie die an dieser Bestellung gebundenen AGB durch Ankreuzen des folgenden Kastens. <a href="' . zen_href_link(FILENAME_CONDITIONS, '', 'SSL') . '"><span class="pseudolink">hier</span></a>.');
define('TEXT_CONDITIONS_CONFIRM', '<span class="termsiagree">Ich habe die an dieser Bestellung gebundenen AGB gelesen und zugestimmt.</span>');

define('TEXT_CHECKOUT_AMOUNT_DUE', 'Fälliger Gesamtbetrag: ');
define('TEXT_YOUR_TOTAL','Ihre Gesamtsumme');
?>