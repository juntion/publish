<?php 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_EC', '
Pagamento PayPal Express'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PRO20', 'Pagamento PayPal Express (Pro 2.0 Payflow Edition (Regno Unito)'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_EC', 'PayPal Payflow Pro - Gateway'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_GATEWAY', 'Pagamento PayPal Express tramite Payflow Pro'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_DESCRIPTION', '<strong>Pagamento PayPal Express</strong>%s<br '); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_DESCRIPTION', '<strong>PayPal</strong>'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_TITLE', 'Carta di credito'); 
define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TITLE', 'PayPal'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EC_HEADER', 'Veloce'); 
define('MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TYPE', 'Pagamento PayPal Express'); 
define('MODULE_PAYMENT_PAYPALWPP_DP_TEXT_TYPE', 'PayPal Direct Payment'); 
define('MODULE_PAYMENT_PAYPALWPP_PF_TEXT_TYPE', 'Carta di credito\';  //(utilizzata per le transazioni payflow'); 
define('MODULE_PAYMENT_PAYPALWPP_ERROR_HEADING', 'Spiacenti'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CARD_ERROR', 'I dati della carta di credito che hai immesso contengono un errore.  Verifica e riprova.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_FIRSTNAME', 'Nome carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_LASTNAME', 'Cognome carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_OWNER', 'Nome titolare carta:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_TYPE', 'Tipo carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_NUMBER', 'Numero carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_EXPIRES', 'Data di scadenza carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_ISSUE', 'Data di emissione carta di credito:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER', 'Numero CVV:'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(sul retro della carta di credito)'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_DECLINED', 'La carta di credito è stata rifiutata. Prova con un\'altra carta o rivolgiti al tuo istituto per ulteriori informazioni.'); 
define('MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE', 'Non è stato possibile elaborare il tuo ordine. Riprova'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_ERROR', 'Si è verificato un errore durante il tentativo di comunicazione con il processore del pagamento. Riprova'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_MESSAGE', 'Gentile titolare del negozio'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_SUBJECT', 'AVVISO: Errore pagamento PayPal Express'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR', 'Le informazioni di indirizzo inserite non sembrano valide o non corrispondono. Seleziona o aggiungi un indirizzo diverso e riprova.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CONFIRMEDADDR_ERROR', 'L\'indirizzo che hai selezionato su PayPal non è un indirizzo confermato. Torna su PayPal e seleziona o aggiungi un indirizzo confermato e riprova.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'PayPal non è stato in grado reperire i fondi per questa transazione. Scegli un\'altra opzione di pagamento o rivedi le opzioni di finanziamento nel conto PayPal prima di procedere.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ERROR', 'Si è verificato un errore nel tentativo di elaborare la carta di credito. Riprova'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_CARD', 'Ci scusiamo per l\'inconveniente'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_LOGIN', 'Si è verificato un problema nella convalida del conto. Riprova.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_OWNER', '*Il nome del titolare della carta deve essere almeno di \' . CC_OWNER_MIN_LENGTH . \' caratteri.n'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_NUMBER', '*Il numero di carta di credito deve essere almeno di \' . CC_NUMBER_MIN_LENGTH . \' caratteri.n'); 
define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVS_FAILURE_TEXT', 'AVVISO: Errore verifica indirizzo.'); 
define('MODULE_PAYMENT_PAYPALWPP_ERROR_CVV_FAILURE_TEXT', 'AVVISO: Errore nella verifica del codice CVV della carta.'); 
define('MODULE_PAYMENT_PAYPALWPP_ERROR_AVSCVV_PROBLEM_TEXT', 'L\'ordine è in sospeso e in attesa di revisione da parte del titolare del negozio.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_UNILATERAL', '- Devi registrare le tue credenziali PayPal API per poter elaborare transazioni avanzate.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_STATE_ERROR', 'Lo stato assegnato al tuo account non è valido.  Accedi alle impostazioni del tuo account e modificali.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'Ci scusiamo per l\'inconveniente. Impossibile avviare il pagamento perché il conto PayPal configurato dal titolare del negozio non è un conto PayPal Website Payments Pro oppure i servizi del gateway PayPal non sono stati acquistati.  Seleziona un metodo di pagamento alternativo per il tuo ordine.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_SANDBOX_VS_LIVE_ERROR', 'Ci scusiamo per l\'inconveniente. Le impostazioni di autenticazione del conto PayPal non sono ancora state impostate'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_WPP_BAD_COUNTRY_ERROR', 'Spiacenti -- il conto PayPal configurato dall\'amministratore del negozio è basato in un paese non supportato al momento per i pagamenti Website Pro. Scegli un altro metodo di pagamento per completare l\'ordine.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_CONFIGURED', '<span class="alert">&#160;;(NOTA: Il modulo non è ancora configurato</span>'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GETDETAILS_ERROR', 'Si è verificato un problema nel recupero dei dettagli della transazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_TRANSSEARCH_ERROR', 'Si è verificato un problema nell\'individuazione delle transazioni corrispondenti ai criteri che hai specificato.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_ERROR', 'Si è verificato un problema nell\'annullamento della transazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_ERROR', 'Si è verificato un problema nel reperimento dei fondi per l\'importo della transazione specificato.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_ERROR', 'Si è verificato un problema nell\'autorizzazione della transazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_ERROR', 'Si è verificato un problema nell\'acquisizione della transazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUNDFULL_ERROR', 'La tua richiesta di rimborso è stata rifiutata da PayPal.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_REFUND_AMOUNT', 'Hai richiesto un rimborso parziale senza specificare l\'importo.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_ERROR', 'Hai richiesto un rimborso completo ma non hai selezionato la casella Conferma di verifica dell\'operazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_AUTH_AMOUNT', 'Hai richiesto un\'autorizzazione ma non hai specificato un importo.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_CAPTURE_AMOUNT', 'Hai richiesto un\'acquisizione ma non hai specificato un importo.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', 'Conferma'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_ERROR', 'Hai richiesto di annullare una transazione ma non hai selezionato la casella Conferma di verifica dell\'operazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', 'Conferma'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_CONFIRM_ERROR', 'Hai richiesto un\'autorizzazione ma non hai selezionato la casella Conferma di verifica dell\'operazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', 'Hai richiesto l\'acquisizione di fondi ma non hai selezionato la casella Conferma di verifica dell\'operazione.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_INITIATED', 'Rimborso PayPal per %s avviato. ID transazione: %s. Aggiorna lo schermo per vedere i dettagli aggiornati della conferma nella sezione Storico stato ordini/Commenti.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_INITIATED', 'Autorizzazione PayPal per %s avviata. Aggiorna lo schermo per vedere i dettagli aggiornati della conferma nella sezione Storico stato ordini/Commenti.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_INITIATED', 'Acquisizione PayPal per %s avviata. ID ricevuta: %s. Aggiorna lo schermo per vedere i dettagli aggiornati della conferma nella sezione Storico stato ordini/Commenti.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_INITIATED', 'Richiesta annullamento PayPal avviata. ID transazione: %s. Aggiorna lo schermo per vedere i dettagli aggiornati della conferma nella sezione Storico stato ordini/Commenti.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_API_ERROR', 'Si è verificato un errore nel tentativo di transazione. Consulta la guida di riferimento API o i registri delle transazioni per informazioni dettagliate.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_ZONE_ERROR', 'Ci scusiamo per l\'inconveniente; tuttavia,'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_ORDER_ALREADY_PLACED_ERROR', 'sembra che il tuo ordine sia stato inviato due volte. Consulta l\'area Account personale per vedere i dettagli effettivi dell\'ordine.  Utilizza il modulo Contattaci se il tuo ordine non appare qui ma è già stato pagato dal tuo conto PayPal, in modo che possiamo verificare i nostri archivi e riconciliare la discrepanza.'); 
define('MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', 'Pagamento con PayPal Il più sicuro'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT', 'Fai clic qui per pagare tramite il pagamento PayPal Express'); 
define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_IMG', 'https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif'); 
define('MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_SM_IMG', 'https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckoutsm.gif'); 
define('MODULE_PAYMENT_PAYPALEC_MARK_BUTTON_IMG', 'https://www.paypalobjects.com/en_US/i/logo/PayPal_mark_37x23.gif'); 
define('MODULE_PAYMENT_PAYPALEC_MARK_BUTTON_IMG', 'https://www.paypalobjects.com/en_US/i/logo/PayPal_mark_50x34.gif'); 
define('MODULE_PAYMENT_PAYPALEC_MARK_BUTTON_IMG', 'https://www.paypalobjects.com/en_US/i/bnr/horizontal_solution_PP.gif'); 
define('MODULE_PAYMENT_PAYPALEC_MARK_BUTTON_IMG', 'https://www.paypalobjects.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif'); 
define('MODULE_PAYMENT_PAYPALWPP_HEADER_IMAGE', ''); 
define('MODULE_PAYMENT_PAYPALWPP_PAGECOLOR', ''); 
define('MODULE_PAYMENT_PAYPALWPP_HEADER_BORDER_COLOR', ''); 
define('MODULE_PAYMENT_PAYPALWPP_HEADER_BACK_COLOR', ''); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', 'Nome:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', 'Cognome:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', 'Nome azienda:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'Nome indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'Via indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', 'Città indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'Stato indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', 'CAP indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', 'Paese indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', 'E-mail pagante:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'ID e-bay:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', 'ID pagante:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', 'Stato pagante:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'Stato indirizzo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'Tipo pagamento:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', 'Stato pagamento:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', 'Motivo sospensione:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', 'Fattura:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', 'Data pagamento:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', 'Valuta:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', 'Importo lordo:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'Commissione pagamento:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', 'Tasso di cambio:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'Articoli nel cestino:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'Tipo trans.:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'ID trans.:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'ID Trans. genitore:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>Rimborsi degli ordini</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'Se desideri il rimborso integrale di quest\'ordine'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', 'Esegui rimborso integrale'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', 'Esegui rimborso parziale'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br '); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', 'Inserisci'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'l\'importo del rimborso qui e fai clic su Rimborso parziale'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*Il rimborso integrale potrebbe non essere emesso dopo la richiesta di rimborso parziale.<br '); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>Nota da visualizzare al cliente:</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', 'Rimborsato dall\'amministratore del negozio.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK', 'Conferma:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_COMMENTS', 'Commenti sistema:'); 
define('MODULE_PAYMENT_PAYPALWPP_ENTRY_PROTECTIONELIG', 'Idoneità alla protezione:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>Autorizzazioni dell\'ordine</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'Se desideri autorizzare parte di quest\'ordine'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', 'Esegui autorizzazione'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', ''); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong>Acquisizione delle autorizzazioni</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'Se desideri acquisire tutti o parte degli importi autorizzati in sospeso per quest\'ordine'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'Effettua acquisizione'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'Importo da acquisire:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', 'Questa è l\'acquisizione finale?'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', ''); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>Nota da visualizzare al cliente:</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'Grazie per il tuo ordine.'); 
define('MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_CHECK', 'Conferma:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>Annullamento di autorizzazioni dell\'ordine</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID', 'Se desideri annullare un\'autorizzazione'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>Nota da visualizzare al cliente:</strong>'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'Grazie per essere nostro cliente. Torna a trovarci presto.'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', 'Effettua annullamento'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', ''); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'Stato trans.'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', 'Codice aut.:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'Corrispondenza indirizzo AVS:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'Corrispondenza CAP AVS:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'Corrispondenza CVV2:'); 
define('MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', 'Giorni per saldare:'); 
define('EMAIL_EC_ACCOUNT_INFORMATION', 'Dettagli di accesso al tuo conto'); 
define('MODULES_PAYMENT_PAYPALWPP_LINEITEM_TEXT_ONETIME_CHARGES_PREFIX', 'Addebiti una tantum relativi a'); 
define('MODULES_PAYMENT_PAYPALWPP_LINEITEM_TEXT_SURCHARGES_SHORT', 'Supplementi'); 
define('MODULES_PAYMENT_PAYPALWPP_LINEITEM_TEXT_SURCHARGES_LONG', 'Gestione addebiti e altre spese applicabili'); 
define('MODULES_PAYMENT_PAYPALWPP_LINEITEM_TEXT_DISCOUNTS_SHORT', 'Sconti'); 
define('MODULES_PAYMENT_PAYPALWPP_LINEITEM_TEXT_DISCOUNTS_LONG', 'Crediti applicati'); 
define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_FMF_SUBJECT', 'Pagamento nello stato di Esame anti frode:'); 
define('MODULE_PAYMENT_PAYPALDP_TEXT_EMAIL_FMF_INTRO', 'Questa è una notifica automatica per avvisarti che PayPal ha contrassegnato il pagamento di un nuovo ordine come ordine che Richiede revisione del pagamento da parte del team anti frode. La revisione viene normalmente completata entro 36 ore. Ti CONSIGLIAMO CALDAMENTE di NON SPEDIRE l\'ordine finché la revisione del pagamento non è stata completata. Puoi vedere lo stato della revisione dell\'ordine più recente accedendo al tuo conto PayPal e consultando le transazioni recenti.'); 
?>