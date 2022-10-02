<?php
// 公共表单验证
// firstname
define('FS_FIRST_REQUIRED_TIP', 'Inserisci un nome.');
define('FS_FIRST_MIN_TIP', 'Il nome deve contenere come minimo 2 caratteri.');
define('FS_FIRST_MAX_TIP', 'Il nome deve contenere al massimo 32 caratteri.');
// lastname
define('FS_LAST_REQUIRED_TIP', 'Inserisci il cognome.');
define('FS_LAST_MIN_TIP', 'Il cognome deve contenere come minimo 2 caratteri.');
define('FS_LAST_MAX_TIP', 'Il cognome deve contenere al massimo 32 caratteri.');
// email
define('FS_YOUR_EMAIL_ADDRESS', 'Il tuo indirizzo e-mail');
define('FS_EMAIL_REQUIRED_TIP', 'Inserisci il tuo indirizzo e-mail.');
define('FS_EMAIL_FORMAT_TIP', 'Inserisci un indirizzo e-mail valido.');
define('FS_EMAIL_HAS_REGISTERED_TIP', 'Questa e-mail è già registrata.');
define('FS_EMAIL_HAS_REGISTERED_TIP1',"Siamo spiacenti, l'email è già stata registrata.Si prega di accedere.");
define('FS_EMAIL_NOT_FOUND_TIP',"This email address is not registered.");
define('FS_EMAIL_NOT_ACTIVED_TIP','Sorry! Your mailbox is not activated, please log in to activate.');
// new email
define('FS_NEW_EMAIL_ADDRESS', 'Nuovo indirizzo e-mail');
define('FS_NEW_EMAIL_REQUIRED_TIP', 'Nuovo indirizzo e-mail non può essere vuoto.');
// confirm new email
define('FS_CONFIRM_NEW_EMAIL', 'Inserisci di nuovo la nuova e-mail');
define('FS_CONFIRM_NEW_EMAIL_REQUIRED_TIP', 'Inserisci di nuovo la nuova e-mail non può essere vuoto.');
define('FS_NEW_EMAIL_MATCH_TIP', 'Il nuovo indirizzo e-mail deve corrispondere.');
// password
define('FS_PASSWORD_REQUIRED_TIP', 'Inserisci la tua password.');
define('FS_CURRENT_PASSWORD_REQUIRED_TIP',"Si prega di inserire la password attuale.");
define('FS_PASSWORD_FORMAT_TIP',"Minimo 6 caratteri; almeno una lettera e un numero.<br/>Caratteri speciali consentiti (_ ? @ ! # $ % & * .).");
define('FS_PASSWORD_ERROR_TIP', 'La password non è corretta. Riprova.');
define('FS_OLD_PASSWORD_ERROR_TIP', 'La tua vecchia password non è corretta');
// confirm password
define('FS_CONFIRM_PASSWORD', 'Conferma password');
define('FS_CONFIRM_PASSWORD_REQUIRED_TIP',"Si prega di confermare la password nuova.");
define('FS_PASSWORD_MATCH_TIP', 'La password deve corrispondere.');
// new password
define('FS_NEW_PASSWORD', 'Nuova password');
define('FS_NEW_PASSWORD_REQUIRED_TIP',"Si pregai di inserire la password nuova.");
define('FS_PASSWORD_REQUIREMENT', 'La tua password deve essere:');
define('FS_PASSWORD_REQUIREMENT1', '6 caratteri minimo');
define('FS_PASSWORD_REQUIREMENT2', 'almeno una lettera e un numero');
// confirm new password
define('FS_CONFIRM_NEW_PASSWORD', 'Conferma nuova password');
define('FS_CONFIRM_NEW_PASSWORD_REQUIRED_TIP', 'Conferma nuova password non può essere vuoto.');
define('FS_PASSWORD_DIFFERENT', 'La nuova password deve essere diversa dalla vecchia password');
define('FS_NEW_PASSWORD_MATCH_TIP', 'La nuova password deve corrispondere.');
//验证码
define('FS_IMAGE', 'Immagine');
define('FS_TRY_DIFFERENT_IMAGE', 'Prova un\'immagine diversa');
define('FS_TYPE_CHAR', 'Digita i caratteri');
// AGREE
define('FS_AGREE_REQUIRED_TIP', 'Accetta l\'Informativa sulla privacy.');
//Company name
define('FS_COMPANY_NAME_REQUIRED_TIP', 'Inserisci il nome della tua società.');
define('FS_COMPANY_NAME_MIN_TIP', 'Il nome della società deve contenere come minimo 2 caratteri.');
define('FS_COMPANY_NAME_MAX_TIP', 'Il nome della società deve contenere al massimo 300 caratteri.');
//industry
define('FS_SELECT_INDUSTRY', 'Seleziona settore');
define('FS_INDUSTRY_REQUIRED_TIP', 'Seleziona a quale settore appartiene la tua società.');
//TAX/VAT
define('FS_TAX_PLACEHOLDER', 'es: DE123456789');
define('FS_TAX_REQUIRED_TIP', 'Inserisci il numero di PARTITA IVA.');
define('FS_TAX_FORMAT_TIP', 'Esempio di numero di PARTITA IVA valido: DE123456789');
define('FS_TAX_FORMAT_ARGENTINA_TIP', 'Inserisci un numero di Partita IVA valido, es.: 00.000.000/0000-00.');
define('FS_TAX_FORMAT_BRAZIL_TIP', 'Inserisci un numero di Partita IVA valido, es.: 00-00000000-0.');
define('FS_TAX_FORMAT_CHILE_TIP', 'Il numero di Partita IVA deve essere come minimo di 7 cifre.');
//phone
define('FS_PHONE_REQUIRED_TIP', 'Inserisci il numero di telefono.');
define('FS_PHONE_FORMAT_TIP', 'Consenti solo cifre');
//国家
define('FS_SEARCH_YOUR_COUNTRY', 'Cerca il tuo paese');
define('FS_COUNTRY_REQUIRED_TIP', 'Seleziona il tuo paese/regione.');
//QTY
define('FS_PRODUCT_QTY_REQUIRED_TIP', 'La QTÀ prodotto non può essere vuota.');
define('FS_PRODUCT_QTY_FORMAT_TIP', 'Questa qtà prodotto non è valida');
// get a quote
define('COMMENTS_OR_QUESTIONS_REQUIRED_TIP', 'I commenti/domande non possono essere vuoti.');
// feedback
define('FEEDBACK_RATE_REQUIRED_TIP', 'Seleziona un\'opzione da 1 a 5.');
define('FEEDBACK_TOPIC_REQUIRED_TIP', 'Seleziona un argomento.');
define('FEEDBACK_CONTENT_REQUIRED_TIP', 'Inserisci più di 10 caratteri.');
// review
define('FS_REVIEW_RATING_REQUIRED_TIP', 'Valuta questo prodotto.');
define('FS_REVIEW_TITLE_REQUIRED_TIP', 'Il titolo della tua recensione è obbligatorio.');
define('FS_REVIEW_TITLE_MIN_TIP', 'Il titolo della tua recensione deve essere come minimo di 3 caratteri.');
define('FS_REVIEW_TITLE_MAX_TIP', 'Il titolo della tua recensione deve contenere al massimo 200 caratteri.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP', 'Il contenuto della tua recensione è obbligatorio.');
define('FS_REVIEW_CONTENT_MIN_TIP', 'Il contenuto della tua recensione deve essere come minimo di 10 caratteri.');
define('FS_REVIEW_CONTENT_MAX_TIP',"Le recensioni non devono superare i 5,000 caratteri.");
// my case
define('FS_CASE_TYPE_REQUIRED_TIP', 'Scegli il tipo di servizio.');
define('FS_CASE_CONTENT_REQUIRED_TIP', 'Descrivi le tue domande in modo che possiamo gestire la tua richiesta più rapidamente.');
define('FS_CASE_CONTENT_MAX_TIP', 'Non superare il limite di 3');
// apply money
define('FS_APPLY_MONEY_REQUIRED_TIP', 'Inserisci l\'importo previsto.');
define('FS_APPLY_MONEY_FORMAT_TIP', 'Inserisci un importo valido fino a 2 decimali.');
define('FS_APPLY_MONEY_REASON_TIP', 'Spiega perché hai bisogno di aumentare l\'importo. Sarà utile nella gestione della tua richiesta.');
define('FS_EMAIL_HAS_REGISTERED_TIP_01',"L\'account esiste già. Clicca qui per <a href='".zen_href_link(FILENAME_LOGIN,'','SSL')."'>accedere</a>.");
define("FS_REVIEW_TITLE_REQUIRED_TIP_NEW",'Si prega di inserire il titolo della recensione.');
define('FS_REVIEW_CONTENT_REQUIRED_TIP_NEW','Si prega di inserire la recensione.');

define('FS_OLD_PASSWORD_REASON','La tua vecchia password non è corretta, si prrga di ricontrollare.');
define('FS_SUBMIT_TOO_FREQUENT','Submission is too frequent');
?>