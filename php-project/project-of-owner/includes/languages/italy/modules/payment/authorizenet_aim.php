<?php 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_ADMIN_TITLE', '
Authorize.net (AIM'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_DESCRIPTION', '<a target="_blank" href="https://account.authorize.net/">Login negozianti Authorize.net</a>\' . (MODULE_PAYMENT_AUTHORIZENET_AIM_TESTMODE != \'Produzione\' ? \'<br '); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_DESCRIPTION', '<a target="_blank" href="http://reseller.authorize.net/application.asp?id=131345">Fai clic qui per registrare un account</a><br '); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_ERROR_CURL_NOT_FOUND', 'Funzioni CURL non trovate - richieste per il modulo di pagamento AIM Authorize.net'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CATALOG_TITLE', 'Carta di credito'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CREDIT_CARD_TYPE', 'Tipo carta di credito:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CREDIT_CARD_OWNER', 'Nome titolare carta:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CREDIT_CARD_NUMBER', 'Numero carta di credito:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CREDIT_CARD_EXPIRES', 'Data di scadenza:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CVV', 'Numero CVV:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_POPUP_CVV_LINK', 'Che cos\'è?'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_JS_CC_OWNER', '*Il nome del titolare della carta di credito deve essere almeno di \' . CC_OWNER_MIN_LENGTH . \' caratteri.n'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_JS_CC_NUMBER', '*Il numero di carta di credito deve essere almeno di \' . CC_NUMBER_MIN_LENGTH . \' caratteri.n'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_JS_CC_CVV', '*Il numero CVV di 3 o 4 cifre da immettere è riportato sul retro della carta di credito.n'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_DECLINED_MESSAGE', 'Non è stato possibile autorizzare la carta di credito per il seguente motivo. Correggi le informazioni e riprova oppure contattaci per ulteriore assistenza.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_ERROR', 'Errore carta di credito!'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_AUTHENTICITY_WARNING', 'AVVERTENZA: Problema hash di sicurezza. Contatta immediatamente il titolare del negozio. L\'ordine *non* è stato completamente autorizzato.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_BUTTON_TEXT', 'Effettua il rimborso'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_REFUND_CONFIRM_ERROR', 'Errore: È stato richiesto di effettuare un rimborso ma non è stata selezionata la casella Conferma.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_INVALID_REFUND_AMOUNT', 'Errore: È stato richiesto un rimborso ma l\'importo immesso non è valido.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CC_NUM_REQUIRED_ERROR', 'Errore: È stato richiesto un rimborso ma non sono state inserite le ultime 4 cifre del numero di carta di credito.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_REFUND_INITIATED', 'Rimborso iniziato. ID transazione: %s - Codice aut.: %s'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CAPTURE_CONFIRM_ERROR', 'Errore: È stato richiesto di effettuare un\'acquisizione ma non è stata selezionata la casella Conferma.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_BUTTON_TEXT', 'Effettua acquisizione'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_INVALID_CAPTURE_AMOUNT', 'Errore: È stata richiesta un\'acquisizione ma è necessario inserire un importo.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_TRANS_ID_REQUIRED_ERROR', 'Errore: È necessario specificare un ID transazione.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CAPT_INITIATED', 'Acquisizione fondi iniziata. Importo: %s.  ID transazione: %s - Codice aut.: %s'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID_BUTTON_TEXT', 'Effettua annullamento'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_VOID_CONFIRM_ERROR', 'Errore: È stato richiesto un annullamento ma non è stata selezionata la casella Conferma.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_VOID_INITIATED', 'Annullamento iniziato. ID transazione: %s - Codice aut.: %s'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_TITLE', '<strong>Transazioni di rimborso</strong>'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND', 'È possibile rimborsare il denaro sulla carta di credito del cliente qui:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_REFUND_CONFIRM_CHECK', 'Seleziona questa casella per confermare l\'operazione:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_AMOUNT_TEXT', 'Inserisci l\'importo da rimborsare'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_CC_NUM_TEXT', 'Inserisci le ultime 4 cifre del numero della carta di credito su cui accreditare il rimborso.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_TRANS_ID', 'Inserisci l\'ID transazione originale:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_TEXT_COMMENTS', 'Annotazioni (saranno riportate sullo storico ordini:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_DEFAULT_MESSAGE', 'Rimborso emesso'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_REFUND_SUFFIX', 'È possibile rimborsare un ordine fino al massimo dell\'importo già acquisito. È necessario fornire le ultime 4 cifre del numero di carta di credito utilizzata sull\'ordine iniziale.<br '); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_TITLE', '<strong>Acquisire le transazioni</strong>'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE', 'È possibile acquisire i fondi precedentemente autorizzati qui:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_AMOUNT_TEXT', 'Inserisci l\'importo da acquisire:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_CAPTURE_CONFIRM_CHECK', 'Seleziona questa casella per confermare l\'operazione:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_TRANS_ID', 'Inserisci l\'ID transazione originale:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_TEXT_COMMENTS', 'Annotazioni (saranno riportate sullo storico ordini:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Fondi precedentemente autorizzati saldati.'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_CAPTURE_SUFFIX', 'Le acquisizioni devono essere eseguite entro 30 giorni dall\'autorizzazione originale. È possibile acquisire un ordine solo UNA VOLTA. <br '); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID_TITLE', '<strong>Annullamento delle transazioni</strong>'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID', 'È possibile annullare una transazione che non è ancora stata saldata:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_TEXT_VOID_CONFIRM_CHECK', 'Seleziona questa casella per confermare l\'operazione:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID_TEXT_COMMENTS', 'Annotazioni (saranno riportate sullo storico ordini:'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID_DEFAULT_MESSAGE', 'Transazione annullata'); 
define('MODULE_PAYMENT_AUTHORIZENET_AIM_ENTRY_VOID_SUFFIX', 'L\'annullamento deve essere completato prima che la transazione originale venga saldata nel batch giornaliero.'); 
?>