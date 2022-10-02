<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */
define('NAVBAR_TITLE_1', 'Anmelden');
define('NAVBAR_TITLE_2', 'Haben Sie Ihr Passwort vergessen');
define('TEXT_SUBMIT','einreichen');
define('HEADING_TITLE', 'Haben Sie Ihr Passwort vergessen');
define('TEXT_MAIN', 'Geben Sie Ihre E-Mailadresse darunter ein und wir werden Ihnen eine E-Mail senden, die ein neues Passwort für Sie enthält.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Fehler: Die E-Mailadresse ist in unseren Rekorden nicht gefunden. Bitte versuchen Sie noch einmal.');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Neues Passwort');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Ein neues Passwort ist verlangt von ' . $_SERVER['REMOTE_ADDR']  . '.' . "\n\n" . 'Ihr neues Passwort bei \'' . STORE_NAME . '\' ist:' . "\n\n" . '   %s' . "\n\n Nachdem Sie mit dem neuen Passwort eingeloggt haben, können Sie es in 'Mein Konto' ändern.");
define('SUCCESS_PASSWORD_SENT', 'Ein neues Passwort ist zu Ihrer E-Mailadresse gesandt worden.');
define('FORGOTTEN_SUBMIT','Einreichen');

/**********BOF PASSWORD_FORGOTTEN LANGUAGE************/
define('FIBERSTORE_NEW_PWD','Neues Passwort bei Fiberstore');

define('FIBERSTORE_FORGOTTEN_RESET', 'Passwort Zurücksetzen');

define('FIBERSTORE_FORGOTTEN_EMAIL', '*E-Mailadresse:');

define('FIBERSTORE_FORGOTTEN_SEND', ' Geben Sie bitte Ihre E-Mailadresse darunter ein, und wir werden Ihnen eine E-Mail senden, die ein neues Passwort für Sie enthält.');

define('FIBERSTORE_FORGOTTEN_RETURN', 'Zurück für Anmelden');

define('FIBERSTORE_FORGOTTEN_OR', 'oder');

define('FIBERSTORE_FORGOTTEN_PLACE', 'Bestellung online aufgeben');

define('FIBERSTORE_FORGOTTEN_TRACK', 'Ihre Bestellung online verfolgen');

define('FIBERSTORE_FORGOTTEN_VIEW', 'Ihre Bestellhistorie anzeigen');

define('FIBERSTORE_FORGOTTEN_CREATE', 'Favoriten, Wunschzettel und mehr errichten!');

define('FIBERSTORE_FORGOTTEN_MAKE', 'Mit Hilfe des Wunschzettels ein Projekt-Budget machen');

define('FIBERSTORE_FORGOTTEN_SUPPORT', 'Technische Teamunterstützung');

define('FIBERSTORE_FORGOTTEN_HELP', 'Benötigen Sie Hilfe?');

define('TEXT_LOGIN_GUARANTEED','GARANTIERT!');

define('TEXT_LOGIN_HELP','Benötigen Sie Hilfe?');

define('TEXT_LOGIN_OR','Oder');

define('FIBERSTORE_PWD_OF','Ihr neues Passwort bei FiberStore');

define('FIBERSTORE_A_NEWPWD','Ein neues Passwort von Ihrem Konto bei fs.com.');
define('FIBERSTORE_PWD_IS','Ihr neues Passwort ist: ');
define('FIBERSTORE_LOGGED_RECOMMEND','Nachdem Sie mit dem neuen Passwort angemeldet haben, empfehlen wir, dass Sie Ihr Passwort in Mein Konto ändern.');
define('FIBERSTORE_FORGET_SINCERELY','Mit freundlichen Grüßen,');
define('FIBERSTORE_THANKS_AGAIN','Noch einmal vielen Dank für den Einkauf bei uns.');
define('FIBERSTORE_FORGET_NOTE','Bitte achten Sie:');
define('FIBERSTORE_SEND_EMAIL','Diese E-Mail ist von einer E-Mailadresse gesandt, die nur für Benachrichtigung benutzt wird und keine hereinkommende E-Mails akzeptieren kann.');
define('FIBERSTORE_NOT_REPLY','BITTE KEINE RÜCKANTWORT');
define('FIBERSTORE_CONTACT_US','Wenn Sie Problem über dieser E-Mail haben, bitte kontaktieren Sie uns.');
/**********EOF****************************************/


/*********************************/
define('TEXT_LOGIN_HELP_WITH','Ich benötige Hilfe bei');

define('TEXT_LOGIN_RETURNING','Ein Artikel zurückgeben');

define('TEXT_LOGIN_VIEW_THE','anzeigen');

define('TEXT_LOGIN_RMA','RMA-Lösungen');

define('TEXT_LOGIN_PAGE','Kontaktieren Sie uns auf dieser Seite oder durch E-Mail');

define('TEXT_LOGIN_EMAIL','service.us@fs.com');

define('TEXT_LOGIN_CONTACT','Kontaktieren Sie uns');

define('TEXT_VIEW_FAQ','Sehen die Seite von FAQs');

define('TEXT_LOGIN_QUESTIONS','Haben Sie Probleme mit Auslieferung?');

define('ACCOUNT_FOOTER_TITLE','Einkaufen mit Vertrauen');

define('ACCOUNT_FOOTER_SHOPPING','EINKAUFEN BEI FS.COM');

define('ACCOUNT_FOOTER_SECURE','IST ZUVERLÄSSIG UND GESICHERT.');

define('ACCOUNT_FOOTER_PAY','Sie brauchen nichts zu zahlen,wenn Sie unautorisierte Rechnung wegen des Einkaufens bei fs.com in Kreditkarte erhalten.');

define('ACCOUNT_FOOTER_SAFE','Zuverlässiges Einkaufen garantiert');

define('ACCOUNT_FOOTER_INFORMATION','Alle Informationen sind durch das Secure Sockets Layer (SSL) Protokoll ohne Risiko verschlüsselt und gesendet.');

define('ACCOUNT_FOOTER_HOW','Wie schützen wir Ihre privaten Daten?');

define('ACCOUNT_FOOTER_FREE','Lieferung und Rückgabe sind kostenlos');

define('ACCOUNT_FOOTER_SHOP','Wenn Sie unzufrieden mit dem bei FiberStore Co.Ltd gekauften Artikel sind, können Sie den Artikel in ihrer Originalbedingung innerhalb sieben Tagen für eine Erstattung zurückgeben. Wir werden auch für die Lieferung der Rücksendung zahlen!');

define('ACCOUNT_FOOTER_DELIVER','FiberStore liefert eine lebenslange Garantie als ein standardmäßiges Merkmal für alle Hauptproduktlinien, um eine sorgefreie Operation zu bieten und die Reparaturkosten außerhalb der Garantiezeit zu beseitigen.');

define('ACCOUNT_FOOTER_LEARN','Mehr erfahren?');
/**********************************/

// reason block
define('FS_PS_FORGOTTEN_WHY','Warum können Sie sich nicht anmelden?');
define('FS_PS_FORGOTTEN_REASON1','Ich habe mein Passwort vergessen');
define('FS_PS_FORGOTTEN_REASON2','Ich weiß mein Passwort, kann mich aber nicht anmelden');
define('FS_PS_FORGOTTEN_REASON2_TIP','Tipp: Bitte überprüfen Sie Ihr Konto, ob Sie die richtige E-Mail-Adresse eingeben.');
define('FS_PS_FORGOTTEN_REASON3','Ich denke, jemand benutzt mein FS-Konto');
define('FS_PS_FORGOTTEN_REASON3_TIP','Optional: Warum glauben Sie, dass jemand Zugriff auf Ihr Konto hat?');
define('FS_PS_FORGOTTEN_REASON3_OPTION1','Wählen Sie bitte den Grund aus');
define('FS_PS_FORGOTTEN_REASON3_OPTION2','Jemand sendet E-Mail per meinem Konto');
define('FS_PS_FORGOTTEN_REASON3_OPTION3','Ich sehe ungewöhnliche Anmeldungen auf meiner letzten Aktivitätsseite');
define('FS_PS_FORGOTTEN_REASON3_OPTION4','Jemand hat mir gesagt, dass Hacker in mein Konto eindringt');
define('FS_PS_FORGOTTEN_REASON3_OPTION5','Käufe, die ich nicht autorisiert habe, werden auf meinem Konto angezeigt');
define('FS_PS_FORGOTTEN_REASON3_OPTION6','Andere (Erklären Sie bitte)');
define('FS_PS_FORGOTTEN_REASON3_TEXTAREA','Bitte schreiben Sie Ihre Gründe');
define('FS_PS_FORGOTTEN_NEXT','Nächster');

// tpl_password_forgotten_default.php
define('FS_PS_PROCESSING','Verarbeitet...');
define('FS_PS_RESET_MY_PASSWORD','Passwort zurücksetzen');
define('FS_PS_BACK','Zurück');
define('FS_PS_ENTER_YOUR_EMAIL','Geben Sie bitte die E-Mail-Adresse für Ihr FS-Konto ein. Wir senden Ihnen eine E-Mail mit einem Link zum Zurücksetzen Ihres Passworts.');
define('FS_PS_EMAIL_ADDRESS','E-Mail-Adresse:');
define('FS_PS_PLEASE_ENTER_ACCOUNT_MAIL',' Bitte geben Sie die E-Mail-Adresse Ihres FS-Kontos ein.');
define('FS_PS_SUBMIT','Abschicken');
define('FS_PS_FORGOTTEN_ALSO','Sie können auch:');
define('FS_PS_FORGOTTEN_REGISTER','Ein neues Konto eröffnen');
define('FS_PS_FORGOTTEN_CONTACT','Uns kontaktieren');

// error tip
define('FS_PS_FORGOTTEN_TIP_CHOOSE_REASON','Wählen Sie bitte den Grund aus.');
define('FS_PS_FORGOTTEN_TIP_NOT_FIND_EMAIL','Diese Email-Adresse ist nicht registriert. Bitte versuchen Sie es mit einer anderen.');

?>