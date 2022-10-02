<?php

define('PURCHASE_TITLE_01', 'Invia un Ordine d\'acquisto');
define('PURCHASE_TITLE_02', 'Rendi il processo dell\'ordine d\'acquisto efficiente, automatico e facile da tracciare');

define('PURCHASE_FORM_01', 'Fornisci le seguenti informazioni per poter elaborare il tuo ordine di acquisto in modo rapido e semplice.');
define('PURCHASE_FORM_02', 'Dati Personali');
define('PURCHASE_FORM_03', 'Nome');
define('PURCHASE_FORM_04', 'Cognome');
define('PURCHASE_FORM_05', 'Indirizzo email');
define('PURCHASE_FORM_06', 'Telefono');
define('PURCHASE_FORM_07', 'Informazioni d\'ordine d\'acquisto');
define('PURCHASE_FORM_08', 'Numero ordine di acquisto');
define('PURCHASE_FORM_09', 'Preventivo/numero Pl');
define('PURCHASE_FORM_10', 'Carica file');
define('PURCHASE_FORM_11', 'Commenti');
define('PURCHASE_FORM_12', 'Invia ordine di acquisto');
define('PURCHASE_FORM_13', 'Seleziona file');

define('PURCHASE_FORM_TIP_01', 'Si prega di inserire il numero del proprio ordine di acquisto.');
define('PURCHASE_FORM_TIP_02', 'Se hai già ricevuto un preventivo ufficiale da FS, puoi annotare le relative informazioni, ad esempio RQC2001020006/RQ2001300199/FS20200128000.');
define('PURCHASE_FORM_TIP_03', 'Se hai già ricevuto un preventivo ufficiale da FS, puoi caricare i file correlati insieme all\'ordine di acquisto per la conferma.');
define('PURCHASE_FORM_TIP_04', 'Si prega di caricare i file correlati all\'ordine di acquisto.');
define('PURCHASE_FORM_TIP_05', 'Lascia un commento se hai qualche richiesta, come spedizione cieca, numero del ticket, esigenze di personalizzazione dei prodotti, ecc.');
define('PURCHASE_FORM_TIP_06', 'Il contenuto non deve contenere più di 500 caratteri.');

define('PURCHASE_FORM_TIP_07', 'Il tuo ordine d\'acquisto è stato inviato correttamente.');
define('PURCHASE_FORM_TIP_08', 'Elaboreremo l\'ordine entro 12-24 ore e potresti anche visualizzare lo stato dell\'aggiornamento in <a href="'.zen_href_link('purchase_order_list').'">Invia/Visualizza ordine di acquisto</a>.');

define('PURCHASE_LIST_01','Invia un nuovo ordine di acquisto');
define('PURCHASE_LIST_02','La tua lista di ordini di acquisti');
define('PURCHASE_LIST_03','Ordine d\'acquisto numero #');
define('PURCHASE_LIST_04','Data di creazione');
define('PURCHASE_LIST_05','Stato');
define('PURCHASE_LIST_06','Ordine #');
define('PURCHASE_LIST_07','Inviato');
define('PURCHASE_LIST_07_TIP','Di seguito sono riportate le informazioni dell\'ordine di acquisto che hai inviato, ti risponderemo entro 12-24 ore.');
define('PURCHASE_LIST_08','Approvato');
define('PURCHASE_LIST_08_TIP','Il tuo ordine di acquisto è stato approvato e ci stiamo ora attivando per elaborare il tuo ordine.');
define('PURCHASE_LIST_09','Ordine creato');
define('PURCHASE_LIST_09_TIP','Il tuo ordine di acquisto è stato creato correttamente, clicca sul pulsante "Paga adesso" per completare il pagamento e visualizzare lo stato dell\'ordine tramite “FSXXX”.');
define('PURCHASE_LIST_09_TIP1','Il tuo ordine di acquisto è stato creato correttamente ed è ora in fase di elaborazione, puoi visualizzare aggiornamenti sullo stato dell\'ordine tramite “FSXXX”.');
define('PURCHASE_LIST_EMPTY_01','NESSUNO STORICO ORDINI DI ACQUISTO.');
define('PURCHASE_LIST_EMPTY_02','NESSUN ORDINE DI ACQUISTO TROVATO.');
define('PURCHASE_LIST_FORM_01','Assicurarsi che il proprio ordine di acquisto includa tutte le informazioni necessarie per una più rapida elaborazione degli ordini.');
define('PURCHASE_LIST_FORM_02','Ordine di acquisto numero');
define('PURCHASE_LIST_FORM_03','Es: RQC2001020006');
define('PURCHASE_LIST_FORM_04','Lascia un commento se hai qualche richiesta, come spedizione cieca, numero del ticket, esigenze di personalizzazione dei prodotti, ecc. ');

define('PURCHASE_PO_DETAILS','Dettagli ordine di acquisto');
define('PURCHASE_PO_DETAILS_DATE','Data richiesta ordine di acquisto:');
define('PURCHASE_PO_DETAILS_QT','Preventivo numero #:');
define('PURCHASE_PO_DETAILS_REQUEST','Richiesto ordine di acquisto');
define('PURCHASE_PO_DETAILS_FILES','File:');

//邮件
define('PURCHASE_EMAIL_REVIEWING','Revisione ordine di acquisto');
define('PURCHASE_EMAIL_TITLE','FS - Il tuo ordine di acquisto #POXXX è in fase di revisione');
define('PURCHASE_EMAIL_CONTENT_01','Abbiamo ricevuto il tuo ordine di acquisto: #POXXX, il nostro team lo esaminerà e lo elaborerà entro 12-24 ore.');
define('PURCHASE_EMAIL_CONTENT_02','Puoi tenere traccia degli aggiornamento accedendo al tuo account e andando sulla pagina <a href="'.zen_href_link('purchase_order_list').'" target="_blank">Invia/ vedi Ordine d\'acquisto</a>.');

define('PURCHASE_PROCESS_TIP','Sign in or create an account to submit PO file and track its status online timely.');
define('PURCHASE_PROCESS_TITLE','Come effettuare un ordine d\'acquisto?');
define('PURCHASE_PROCESS_01','Inviare un ordine d\'acquisto');
define('PURCHASE_PROCESS_01_TIP','Invia il tuo file dell\'ordine d\'acquisto.');
define('PURCHASE_PROCESS_02','In corso di elaborazione');
define('PURCHASE_PROCESS_02_TIP','FS crea un ordine online per te una volta approvato l\'ordine d\'acquisto');
define('PURCHASE_PROCESS_03','Pagamento e Spedizione');
define('PURCHASE_PROCESS_04','Una volta creato l\'ordine in corso di elaborazione, completa il pagamento online per ulteriori elaborazioni e spedizioni. Per i Clienti con Account di Credito, il tuo ordine verrà elaborato direttamente una volta approvato l\'ordine di acquisto e l\'ordine di credito verrà spedito per primo e il pagamento ricevuto successivamente');
define('PURCHASE_PROCESS_05','Per ulteriori informazioni sullo stato dell\'ordine, potresti controllare "Per ulteriori informazioni sullo stato dell\'ordine, potresti controllare “<a href="'.zen_href_link('manage_orders').'" class="alone_a">Storico Ordini</a>”.');