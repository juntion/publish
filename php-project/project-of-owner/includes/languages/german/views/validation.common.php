<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP',"Bitte geben Sie Ihren Vornamen ein.");
define('FS_FIRST_MIN_TIP',"Der Vorname muss mindestens 2 Zeichen lang sein.");
define('FS_FIRST_MAX_TIP',"Der Vorname darf maximal 32 Zeichen lang sein.");
// lastname
define('FS_LAST_REQUIRED_TIP',"Bitte geben Sie Ihren Nachnamen ein.");
define('FS_LAST_MIN_TIP',"Der Nachname muss mindestens 2 Zeichen lang sein.");
define('FS_LAST_MAX_TIP',"Der Nachname darf maximal 32 Zeichen lang sein.");
// email
define('FS_YOUR_EMAIL_ADDRESS',"Ihre E-Mail-Adresse");
define('FS_EMAIL_REQUIRED_TIP',"Bitte geben Sie Ihre E-Mail-Adresse ein.");
define('FS_EMAIL_FORMAT_TIP',"Geben Sie bitte eine gültige E-Mail-Adresse ein.");
define('FS_EMAIL_HAS_REGISTERED_TIP',"Diese E-Mail-Adresse ist bereits registriert.");
define('FS_EMAIL_HAS_REGISTERED_TIP1',"Entschuldigung, die E-Mail-Adresse wurde registriert. Bitte melden Sie sich an oder ändern Sie die E-Mail-Adresse.");
define('FS_EMAIL_NOT_FOUND_TIP',"Diese E-Mail-Adresse ist nicht registriert.");
define('FS_EMAIL_NOT_ACTIVED_TIP','Es tut uns leid! Ihre Mailbox ist nicht aktiviert, bitte loggen Sie sich ein um sie zu aktivieren.');
define('FS_EMAIL_HAS_REGISTERED_TIP_01',"Konto existiert bereits. Klicken Sie hier zum <a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'>Anmelden</a>.");
// new email
define('FS_NEW_EMAIL_ADDRESS','Neue E-Mail-Adresse');
define('FS_NEW_EMAIL_REQUIRED_TIP',"Eine neue E-Mail-Adresse ist erforderlich.");
// confirm new email
define('FS_CONFIRM_NEW_EMAIL','E-Mail-Adresse Wiederholen');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP',"Geben Sie bitte erneut die E-Mail-Adresse ein.");
define('FS_NEW_EMAIL_MATCH_TIP',"Die eingegebene E-Mail-Adresse muss mit der neuen E-Mail-Adresse übereinstimmen.");
// password
define('FS_PASSWORD_REQUIRED_TIP',"Bitte geben Sie Ihr Passwort ein.");
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"Bitte geben Sie Ihr aktuelles Passwort ein.");
define('FS_PASSWORD_FORMAT_TIP'," Das Passwort muss mindestens 6 Zeichen lang sein und mindestens ein Buchstabe und eine Zahl enthalten. Sonderzeichen (_ ? @ ! # $ % & * .) sind zulässig.");
define('FS_PASSWORD_ERROR_TIP',"Das Passwort ist falsch. Bitte versuchen Sie es noch einmal.");
define('FS_OLD_PASSWORD_ERROR_TIP',"Dein altes Passwort ist nicht korrekt, überprüfe es bitte nochmal!");
// confirm password
define('FS_CONFIRM_PASSWORD',"Passwort bestätigen"); // 只有注册表单才需要
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"Bitte geben Sie das neue Passwort erneut ein.");
define('FS_PASSWORD_MATCH_TIP',"Das erneut eingegebene Passwort muss mit Ihrem Passwort übereinstimmen.");
// new password
define('FS_NEW_PASSWORD','Neues Passwort');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"Bitte geben Sie ein neues Passwort ein.");
define('FS_PASSWORD_REQUIREMENT',"Ihr Passwort soll");
define('FS_PASSWORD_REQUIREMENT1',"mindestens 6 Zeichen,");
define('FS_PASSWORD_REQUIREMENT2',"mindestens ein Buchstabe und eine Nummer enthalten");
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD','Neues Passwort bestätigen');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP',"Bitte bestätigen Sie das neue Passwort.");
define('FS_PASSWORD_DIFFERENT',' Das neue Passwort muss sich vom Alten unterscheiden.');
define('FS_NEW_PASSWORD_MATCH_TIP',"Das erneut eingegebene Passwort muss mit Ihrem Passwort übereinstimmen.");
//验证码
define('FS_IMAGE',"Bild");
define('FS_TRY_DIFFERENT_IMAGE',"Ein anderes Bild ändern");
define('FS_TYPE_CHAR',"Zeichen eingeben");
define('FS_IMAGE_FORM_TIP',"Geben Sie die Zeichen ein, die im Bild angezeigt werden.");
// AGREE
define('FS_AGREE_REQUIRED_TIP',"Bitte akzeptieren Sie unsere Politik, um fortzufahren.");
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP',"Bitte geben Sie Firmenname ein.");
define('FS_COMPANY_NAME_MIN_TIP',"Firmenname muss mindestens 2 Zeichen lang sein.");
define('FS_COMPANY_NAME_MAX_TIP',"Firmenname muss maximal 32 Zeichen lang sein.");
//industry
define('FS_INDUSTRY_REQUIRED_TIP',"Wählen Sie bitte die Branche Ihrer Firma aus!");
//industry
define('FS_SELECT_INDUSTRY','Branche auswählen');
define('FS_INDUSTRY_REQUIRED_TIP',"Wählen Sie bitte die Branche Ihrer Firma aus!");
//TAX/VAT
define('FS_TAX_PLACEHOLDER','z.B:DE123456789');
define('FS_TAX_REQUIRED_TIP','Bitte geben Sie eine USt-IdNr ein.');
define('FS_TAX_FORMAT_TIP','Gültige USt-IdNr. z.B: DE123456789');
define('FS_TAX_FORMAT_ARGENTINA_TIP','Bitte geben Sie eine gültige USt-IdNr. ein z.B: 00.000.000/0000-00.');
define('FS_TAX_FORMAT_BRAZIL_TIP','Bitte geben Sie eine gültige USt-IdNr. ein z.B: 00-00000000-0.');
define('FS_TAX_FORMAT_CHILE_TIP','USt-IdNr. sollte mindestens 7 Ziffern sein.');
//phone
define('FS_PHONE_REQUIRED_TIP','Bitte geben sie Ihre Telefonnummer ein.');
define('FS_PHONE_FORMAT_TIP','Nur Ziffern zulassen, mindestens 7 Einsen.');
//国家
define('FS_SEARCH_YOUR_COUNTRY','Suchen Sie Ihr Land/Region');
define('FS_COUNTRY_REQUIRED_TIP','Bitte wählen Sie Ihr Land/Region.');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP','Die Produktmenge ist Pflichtfeld.');
define('FS_PRODUCT_QTY_FORMAT_TIP','Die Produktmenge ist ungültig. Bitte korrigieren Sie die Menge und versuchen Sie es erneut.');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP','Kommentare/Fragen ist Pflichtfeld.');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP','Bitte bewerten Sie das Produkt.');
define('FEEDBACK_TOPIC_REQUIRED_TIP','Wählen Sie bitte ein Thema aus.');
define('FEEDBACK_CONTENT_REQUIRED_TIP','Geben Sie bitte mehr als 10 Zeichen ein.');
// review
define('FS_REVIEW_RATING_REQUIRED_TIP','Geben Sie bitte eine Gesamtbewertung ab.');
define('FS_REVIEW_TITLE_REQUIRED_TIP','Titel der Bewertung ist Pflichtfeld.');
define('FS_REVIEW_TITLE_MIN_TIP','Der Titel muss mindestens 3 Zeichen lang sein.');
define('FS_REVIEW_TITLE_MAX_TIP',' Der Titel darf maximal 200 Zeichen lang sein.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP','Der Inhalt Ihrer Bewertung ist Pflichtfeld.');
define('FS_REVIEW_CONTENT_MIN_TIP','Bitte geben Sie eine Bewertung mit mehr als 10 Zeichen ein.');
define('FS_REVIEW_CONTENT_MAX_TIP',"Sie können höchstens 5.000 Zeichen eingeben.");
define('FS_CASE_CONTENT_MAX_TIP','Bitte überschreiten Sie nicht mehr als 3.000 Zeichen.');
// my case
define('FS_CASE_TYPE_REQUIRED_TIP','Bitte wählen Sie den Servicetyp.');
define('FS_CASE_CONTENT_REQUIRED_TIP','Bitte beschreiben Sie Ihre Fragen, damit wir Ihre Anfrage schneller bearbeiten können.');
define('FS_CASE_CONTENT_MAX_TIP','Bitte überschreiten Sie nicht mehr als 5.000 Zeichen.');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP','Geben Sie bitte Ihr gewünschtes Kreditlimit ein.');
define('FS_APPLY_MONEY_FORMAT_TIP','Bitte geben Sie einen gültigen Betrag von bis zu 2 Dezimalstellen ein.');
define('FS_APPLY_MONEY_REASON_TIP','Geben Sie bitte mindestens einen Grund für die Änderung des Kreditlimits an.');

//review new
define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'Geben Sie bitte einen Titel ein.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW',' Geben Sie bitte den Inhalt ein.');


define('FS_OLD_PASSWORD_REASON','Das Passwort ist falsch. Bitte versuchen Sie es noch einmal.');
