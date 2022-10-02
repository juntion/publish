<?php 
define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y' ). ' <a href="' . zen_href_link(FILENAME_DEFAULT). '" target="_blank">' . STORE_NAME . '</a>. Powered by <a href="http://www.zen-cart.cn" target="_blank">Zen Cart</a>');
define('FIBERSTORE_ALL_RIGHTS_RESERVED', 'Tutti i diritti riservati'); 
define('FIBERSTORE_ORDER_HELLO', 'Salve'); 
define('FIBERSTORE_CDN_IMAGES', 'https://d2gwt4r5cjfqmi.cloudfront.net/'); 
define('FIBERSTORE_CDN_IMAGES', 'images/'); 
define('FIBERSTORE_ORDER_LOGIN_AS', 'Connesso come'); 
define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Mostra da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> notizie'); 
define('TEXT_DISPLAY_NUMBER_OF_TUTORIAL', 'Mostra da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> tutorial');
//夏令时--冬令时
define('SUMMER_TIME',true);
if(SUMMER_TIME){
    define('FS_SUMMER_OR_WINTER_TIME','4:30pm (UTC/GMT+2)');
    define('FS_CHECKOUT_TIME','16:30 UTC/GMT+2');
}else{
    define('FS_SUMMER_OR_WINTER_TIME','4pm (UTC/GMT+1)');
    define('FS_CHECKOUT_TIME','16:30 UTC/GMT+1');
}
@setlocale(LC_TIME, 'en_US.UTF-8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

define('FIBERSTORE_REGIST_ERROR', 'Nel nostro sistema è già presente questo indirizzo e-mail - prova ad accedere con tale indirizzo e-mail. Se non utilizzi più quell\'indirizzo puoi correggerlo nell\'area Account personale.'); 
define('FIBERSTORE_REGIST_ERROR', 'Nuestro sistema ya tiene un registro de dicha dirección de correo electrónico - por favor intenta acceder a dicha dirección de correo electrónico. Si usted no usa esa dirección por más tiempo se puede corregir en el area Mi Cuenta'); 
define('FIBERSTORE_LOGIN_ERROR', 'La dirección de email o la contrase?a es incorrecta.'); 
define('FIBERSTORE_WELCOME_MEAASGE', 'Este mensaje fue enviado desde una dirección exclusivamente de notificación que no puede recibir mensajes entrantes. Por favor no responda a este mensaje. Si usted tiene alguna pregunta'); 
define('FIBERSTORE_REVIEW_NO', 'Ninguna revisión actualmente .'); 
define('FIBERSTORE_WELCOME_TO', 'Estimado cliente'); 
define('FIBERSTORE_WELCOME_CART', 'Carrito Permanente'); 
define('FIBERSTORE_CONTACT_ABOUT', 'sobre nosotros contenido de ecoptical.com'); 
define('FIBERSTORE_CUSTOMER_NAME', 'Nombre del cliente:'); 
define('FIBERSTORE_CUSTOMER_EMAIL', 'Cliente E-mail:'); 
define('FIBERSTORE_CONTACT_SUBJECT', 'sujeto'); 
define('FIBERSTORE_CONTACT_CONTENTS', 'Contenido:'); 
define('FIBERSTORE_CONTACT_FROM', 'De http://www.fs.com'); 
define('FIBERSTORE_SELECT', 'Por favor seleccione...'); 
define('FS_FSCOM', 'https://www.fs.com');
define('COPY_RIGHT', 'derechos de autor @ 2009-'.date('Y',time()).' FS.COM Co., Ltd. Todos los Derechos Reservados.');

define('EMAIL_HEADER_INFO', '
	<!-- 2018.6.26头部-->
			<div class="em_img" style="text-align: center;margin-top: 20px;margin-bottom: 8px;">
				<a href="'.zen_href_link('index').'" style="display:inline-block;">
					<img style="display: inline-block;" width="150" src="https://www.fs.com/images/email-logo.png"/>
        </a>	
			</div>
			<div class="em_a" style="text-align: center;margin-bottom: 20px;">
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Data-Center-Products.html').'">Data Center</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/Enterprise-Small-Business.html').'">Enterprise Network</a>
				<em class="em_em" style="display: inline-block;margin-left: 5px;margin-right: 5px;height: 10px;width: 1px;background: #616265;"></em>
				<a style="display: inline-block;font-size: 12px;color: #232323;line-height: 20px;text-decoration: none;" href="'.HTTPS_SERVER.reset_url('support/ISP-Networks.html').'">Optical Transport Network</a>
			</div>');
define('EMAIL_FOOTER_INFO','
			<hr class="em_hr" style="border:none;border-top: 1px solid #e5e5e5;" />
			<div class="em_p" style="margin-top: 36px;margin-bottom: 26px;text-align: center;font-size: 12px;">Share Your Using Experience <a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;padding-bottom: 10px;margin-bottom: 20px;" href="'.zen_href_link('index').'">#FS.COM</a></div>
			<div class="em_icon" style="text-align: center;">
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: 0 0;" href="'.sourceHtml('linkedin', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -20px 0;" href="'.sourceHtml('youtube', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -40px 0;" href="'.sourceHtml('facebook', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -60px 0;" href="'.sourceHtml('twitter', false).'"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -80px 0;" href="https://www.pinterest.co.uk/?show_error=true"></a>
				<a style="display: inline-block;width: 15px;height: 15px;margin: 0 5px;background: url(https://www.fs.com/includes/templates/fiberstore/images/em_icon.png) no-repeat;background-position: -100px 0;" href="'.sourceHtml('instagram', false).'"></a>
			</div>
			<div class="em_a01" style="text-align: center;margin-top: 18px;margin-bottom: 14px;">
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('contact_us').'">Contact Us</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('account_newsletters').'">My Account</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.zen_href_link('shipping_delivery').'">Shipping & Delivery</a>
				<a style="text-decoration: none;font-size: 12px;color: #232323;line-height: 20px;display: inline-block;margin: 0 6px;" href="'.HTTPS_SERVER.reset_url('policies/day_return_policy.html').'">Return Policy</a>
			</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">You are subscribed to this email as $user_email.</div>
			<div class="em_p01" style="font-size: 12px;line-height: 20px;color: #232323;text-align: center;">
				<a style="text-decoration: none;font-size: 12px;line-height: 20px;color: #232323;text-align: center;" href="'.zen_href_link('account_newsletters').'">Click here to modify your preferences or unsubscribe.</a>
			</div>');

/* 产品、分类公用 */
define('FS_ADD_TO_CART', 'Aggiungi al Carrello');
define('FS_ADD', 'Aggiungi...'); 
define('FS_ADDED', 'Aggiunto'); 
define('CATEGORIES_HEADING_DETAILS', 'Visualizza dettagli'); 
define('FS_VIEW_CART', 'Visualizza carrello'); 
define('FS_VIEW', 'Visualizza'); 
define('FS_REVIEWS', 'Recensioni'); 
define('FS_REVIEW', 'Recensione'); 
define('FS_SHARE', 'condividi'); 
define('FS_NEED_HELP', 'Ho bisogno di aiuto'); 
define('FS_PRODUCT_NEED_HELP', 'Hai bisogno di aiuto?'); 
define('FS_COMPATIBLE', 'Compatibile'); 
define('FS_LENGTH', 'Lunghezza'); 
define('FS_TOTAL_LENGTH', 'Lunghezza totale'); 
define('FS_CUSTOM_LENGTH', 'Lunghezza personalizzata'); 
define('FS_CUSTOM', 'Personalizza'); 
define('FS_SHIPPING_COST', 'Costo di consegna'); 
define('FS_SHIP_SAME_DAY', 'Pronto per la spedizione'); 
define('FS_SHIP_SAME_DAY', 'Spedizione odierna'); 
define('FS_SHIP_NEXT_DAY', 'Prevista il giorno successivo'); 
define('FS_OUT_OF_STOCK', 'Esaurito'); 
define('FS_DELETE_PRODUCT', 'Elimina il prodotto'); 
define('FS_AVAILABILTY', 'Disponibilità'); 
define('PRODUCT_INFO_ADD', 'Aggiungi'); 
define('PRODUCT_INFO_ADDED', 'Aggiunto'); 
define('FS_CHOOSE_LENGTH', 'Scegli lunghezza'); 
define('FS_LENGTH_NAME', 'Lunghezza'); 
define('FS_OPTION_NAME', 'Numero modello'); 
define('FS_PRODUCTS_ORDERS_RECEIVED', 'Gli ordini ricevuti entro le ore 13:00 PST (ora Standard del Pacifico Lun-Ven (escluso festivi) vengono spediti il giorno lavorativo successivo.'); 
define('FS_PRODUCTS_ACTUAL_TIME', 'Possono sussistere alcune differenze tra il tempo stimato e quello effettivo.'); 
define('FS_PRODUCTS_ACTUAL_TIME', 'Il tempo di spedizione effettivo può variare insieme a quello previsto'); 
define('F_BODY_HEADER_GS', 'Globale<br>Spedizione'); 
define('F_BODY_HEADER_ITEM', 'Articolo'); 
define('F_BODY_HEADER_ITEM_TWO', 'Articoli'); 
define('F_BODY_HEADER_ITEMS', 'Articolo(i)');
define('BOX_HEADING_SEARCH', 'Cerca'); 
define('FS_TRANSCEIVER_TYPE', 'Tipo ricetrasmettitore:'); 
define('FS_QUICK_VIEW', 'Vista rapida prodotto'); 
define('FS_WAIT', 'Attendi'); 
define('FS_ASK_EXPERT', 'Chiedi al nostro esperto:'); 
define('FS_ASK_EXPERT_1', 'Richiesta'); 
define('SOLUTION_SUB_PAGE_05', 'Richiesta di progetto'); 
define('FIBERSTORE_IMAGES', 'Immagini'); 
define('FIBERSTORE_DETAILS', 'Dettagli'); 
define('FIBERSTORE_SHOWING', 'Visualizzazione'); 
define('FIBERSTORE_OF', 'di'); 
define('FIBERSTORE_RESULTS_BY', 'risultati per'); 
define('FIBERSTORE_YOUR_PRICE', 'Il tuo prezzo'); 
define('FIBERSTORE_QUANTITY', 'Qtà'); 
define('FIBERSTORE_ADD_TO_CART', 'Aggiungi al carrello'); 
define('FIBERSTORE_PRODUCTS', 'prodotti'); 
define('FIBERSTORE_PRODUCT', 'prodotto'); 
define('FIBERSTORE_RESULTS_BY01', 'Ordina per:'); 
define('FIBERSTORE_RESULTS_VIEW', 'Visualizza:'); 
define('FS_SHIP_SAME_DAY', 'Pronto per la spedizione'); 
define('FS_SHIP_SAME_DAY', 'Spedizione odierna'); 
define('FS_SHIP_NEXT_DAY', 'Prevista il giorno successivo'); 
define('FS_PRODUCTS_ORDERS_RECEIVED', 'Gli ordini ricevuti entro le ore 13:00 PST (ora Standard del Pacifico Lun-Ven (escluso festivi) vengono spediti il giorno lavorativo successivo.'); 
define('FS_PRODUCTS_ACTUAL_TIME', 'Possono sussistere alcune differenze tra il tempo stimato e quello effettivo.'); 
define('FS_PRODUCTS_ACTUAL_TIME', 'Il tempo di spedizione effettivo può variare insieme a quello previsto'); 
define('FIBERSTORE_REMOVE', 'Rimuovi'); 
define('FIBERSTORE_CART_TOTAL', 'Totale carrello:'); 
define('FIBERSTORE_EDITE_ORDER', 'Visualizza carrello'); 
define('FIBERSTORE_CHECK_YOU_ORDER', 'Pagamento'); 
define('FIBERSTORE_SHOPPING_HELP', 'Il tuo carrello è vuoto.'); 
define('FS_PROCEED_TO_CHECKOUT', 'PROCEDI AL PAGAMENTO'); 
define('FS_ITEMS', 'articoli'); 
define('FS_CART', 'Carrello'); 
define('FS_VIEW_ALL', 'Visualizza tutti'); 
define('FS_FILTER', 'Filtro'); 
define('FS_SAVED_ITEMS', 'Tutti gli articoli salvati'); 
define('FS_SAVED_CART', 'Carrello salvato'); 
define('FS_SHIP_ORDER', 'Spedisci il mio ordine a'); 
define('FS_CHOOSE_SHIP', 'Scegli il metodo di spedizione'); 
define('ACCOUNT_EDIT_FOOTER_TITLE', 'ACQUISTA CON FIDUCIA'); 
define('ACCOUNT_EDIT_FOOTER_SHOPPING', 'LO SHOPPING SU FS.COM'); 
define('ACCOUNT_EDIT_FOOTER_SECURE', 'È SICURO E PROTETTO.'); 
define('TEXT_LOGIN_GUARANTEED', 'GARANTITO!'); 
define('ACCOUNT_EDIT_FOOTER_PAY', 'Non pagherai nulla se vengono effettuati addebiti non autorizzati sulla tua carta di credito in conseguenza allo shopping fatto su fs.com.'); 
define('ACCOUNT_EDIT_FOOTER_SAFE', 'SHOPPING SICURO GARANTITO'); 
define('ACCOUNT_EDIT_FOOTER_INFORMATION', 'Tutte le informazioni sono crittografate e trasmesse senza rischi tramite il protocollo SSL (Secure Sockets Layer).'); 
define('ACCOUNT_EDIT_FOOTER_HOW', 'Come proteggiamo i tuoi dati personali?'); 
define('ACCOUNT_EDIT_FOOTER_FREE', 'SPEDIZIONI GRATUITE E RESI GRATUITI'); 
define('ACCOUNT_EDIT_FOOTER_SHOP', 'Se'); 
define('ACCOUNT_EDIT_FOOTER_DELIVER', 'Per garantire un\'operazione priva di preoccupazioni ed eliminare il costo associato alle riparazioni fuori garanzia'); 
define('ACCOUNT_EDIT_FOOTER_LEARN', 'Ulteriori informazioni...'); 
define('TEXT_FIBERSTORE_REGIST_RESPECTS', 'fs.com rispetta la tua privacy. Non noleggiamo né cediamo a terzi le tue informazioni personali.'); 
define('TEXT_FIBERSTORE_REGIST_PRIVACY', 'informativa sulla privacy.'); 
define('FS_LOCAL_PICKUP', 'Ritiro locale'); 
define('LANGUAGE_CURRENCY', 'USD');
define('HTML_PARAMS','dir="ltr" lang="en"');
define('CHARSET', 'UTF-8'); 
define('FOOTER_TEXT_REQUESTS_SINCE', 'richieste da'); 
define('TEXT_GV_NAME', 'Certificato regalo'); 
define('TEXT_GV_NAMES', 'Certificati regalo'); 
define('TEXT_GV_REDEEM', 'Codice riscatto'); 
define('BOX_HEADING_GV_REDEEM', 'TEXT_GV_NAME'); 
define('BOX_GV_REDEEM_INFO', 'Codice riscatto:'); 
define('MALE', 'Sig.'); 
define('FEMALE', 'Sig.ra'); 
define('MALE_ADDRESS', 'Sig.'); 
define('FEMALE_ADDRESS', 'Sig.ra'); 
define('DOB_FORMAT_STRING', 'mm/gg/aaaa'); 
define('BOX_HEADING_LINKS', '&#160;;&#160;;[more]'); 
define('BOX_HEADING_CATEGORIES', 'Categorie'); 
define('BOX_HEADING_MANUFACTURERS', 'Produttori'); 
define('BOX_HEADING_WHATS_NEW', 'Nuovi prodotti'); 
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Nuovi prodotti...'); 
define('BOX_HEADING_FEATURED_PRODUCTS', 'In evidenza'); 
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Prodotti in evidenza...'); 
define('TEXT_NO_FEATURED_PRODUCTS', 'Altri prodotti in evidenza saranno aggiunti a breve. Controlla in un secondo momento.'); 
define('TEXT_NO_ALL_PRODUCTS', 'Altri prodotti saranno aggiunti a breve. Controlla in un secondo momento.'); 
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Tutti i prodotti...'); 
define('BOX_HEADING_SEARCH', 'Cerca'); 
define('BOX_SEARCH_ADVANCED_SEARCH', 'Ricerca avanzata'); 
define('HEADING_SEARCH_KEYWORDS_DEFAULT', 'Inserisci i termini di ricerca qui...'); 
define('BOX_HEADING_SPECIALS', 'Specialità'); 
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Specialità...'); 
define('BOX_HEADING_REVIEWS', 'Recensioni'); 
define('BOX_REVIEWS_WRITE_REVIEW', 'Scrivi una recensione su questo prodotto.'); 
define('BOX_REVIEWS_NO_REVIEWS', 'Attualmente non ci sono recensioni di prodotto.'); 
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s di 5 stelle!'); 
define('BOX_HEADING_SHOPPING_CART', 'Carrello');
define('BOX_SHOPPING_CART_EMPTY', 'Il tuo carrello è vuoto.'); 
define('BOX_SHOPPING_CART_DIVIDER', 'cd.-&#160;;'); 
define('BOX_HEADING_CUSTOMER_ORDERS', 'Riordinazione rapida'); 
define('BOX_HEADING_BESTSELLERS', 'Bestseller'); 
define('BOX_HEADING_BESTSELLERS_IN', 'Bestseller in<br '); 
define('BOX_HEADING_NOTIFICATIONS', 'Notifiche'); 
define('BOX_NOTIFICATIONS_NOTIFY', 'Avvisami degli aggiornamenti di <strong>%s</strong>'); 
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Non avvisarmi degli aggiornamenti di <strong>%s</strong>'); 
define('BOX_HEADING_MANUFACTURER_INFO', 'Info produttore'); 
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage'); 
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Altri prodotti'); 
define('BOX_HEADING_LANGUAGES', 'Lingue'); 
define('BOX_HEADING_CURRENCIES', 'Valute'); 
define('BOX_HEADING_INFORMATION', 'Informazioni'); 
define('BOX_INFORMATION_PRIVACY', 'Informativa sulla privacy'); 
define('BOX_INFORMATION_CONDITIONS', 'Condizioni d\'uso'); 
define('BOX_INFORMATION_SHIPPING', 'Spedizione &amp; Resi'); 
define('BOX_INFORMATION_CONTACT', 'Contattaci'); 
define('BOX_BBINDEX', 'Forum'); 
define('BOX_INFORMATION_UNSUBSCRIBE', 'Annulla iscrizione alla newsletter'); 
define('BOX_INFORMATION_SITE_MAP', 'Mappa sito'); 
define('BOX_HEADING_MORE_INFORMATION', 'Altre informazioni'); 
define('BOX_INFORMATION_PAGE_2', 'Pagina 2'); 
define('BOX_INFORMATION_PAGE_3', 'Pagina 3'); 
define('BOX_INFORMATION_PAGE_4', 'Pagina 4'); 
define('BOX_HEADING_TELL_A_FRIEND', 'Dillo a un amico'); 
define('BOX_TELL_A_FRIEND_TEXT', 'Informa qualcuno di questo prodotto.'); 
define('BOX_HEADING_CUSTOMER_WISHLIST', 'La mia lista dei desideri'); 
define('BOX_WISHLIST_EMPTY', 'Non hai alcun articolo nella lista dei desideri'); 
define('IMAGE_BUTTON_ADD_WISHLIST', 'Aggiungi alla lista dei desideri'); 
define('TEXT_WISHLIST_COUNT', 'Attualmente hai %s articolo/i nella tua lista dei desideri.'); 
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> articoli nella tua lista dei desideri'); 
define('NEW_ADDRESS_TITLE', 'Indirizzo di fatturazione'); 
define('JS_ERROR', 'Si sono verificati errori durante l\'elaborazione del tuo modulo.nnEffettua le correzioni seguenti:nn'); 
define('JS_REVIEW_TEXT', '*Aggiungi più dettagli ai tuoi commenti. La recensione deve essere almeno di ' . REVIEW_TEXT_MIN_LENGTH . ' caratteri.');
define('JS_REVIEW_RATING', '*Scegli una valutazione per questo articolo.'); 
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '*Seleziona un metodo di pagamento per il tuo ordine.'); 
define('JS_ERROR_SUBMITTED', 'Questo modulo è già stato inviato. Premi OK e attendi che il processo sia completato.'); 
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Seleziona un metodo di pagamento per il tuo ordine.'); 
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Conferma i termini e le condizioni connessi a quest\'ordine facendo clic sulla casella sottostante.'); 
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Conferma l\'informativa sulla privacy facendo clic sulla casella sottostante.'); 
define('CATEGORY_COMPANY', 'Dettagli società'); 
define('CATEGORY_PERSONAL', 'I tuoi dati personali'); 
define('CATEGORY_ADDRESS', 'Il tuo indirizzo'); 
define('CATEGORY_CONTACT', 'Le tue informazioni di contatto'); 
define('CATEGORY_OPTIONS', 'Opzioni'); 
define('CATEGORY_PASSWORD', 'La tua password'); 
define('CATEGORY_LOGIN', 'Accedi'); 
define('PULL_DOWN_DEFAULT', 'Scegli il tuo paese'); 
define('PLEASE_SELECT', 'Seleziona...'); 
define('TYPE_BELOW', 'Digita una scelta di seguito...'); 
define('ENTRY_COMPANY', 'Nome della società:'); 
define('ENTRY_COMPANY_ERROR', 'Inserisci il nome della società.'); 
define('ENTRY_COMPANY_TEXT', ''); 
define('ENTRY_GENDER', 'Formula introduttiva:'); 
define('ENTRY_GENDER_ERROR', 'Scegli una formula introduttiva.'); 
define('ENTRY_GENDER_TEXT', '*'); 
define('ENTRY_FIRST_NAME', 'Nome:'); 
define('ENTRY_FIRST_NAME_ERROR', 'Il tuo nome è corretto? Il nostro sistema richiede un minimo di ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' caratteri. Riprova.');
define('ENTRY_FIRST_NAME_TEXT', '*'); 
define('ENTRY_LAST_NAME', 'Cognome:'); 
define('ENTRY_LAST_NAME_ERROR', 'Il tuo cognome è corretto? Il nostro sistema richiede un minimo di ' . ENTRY_LAST_NAME_MIN_LENGTH . ' caratteri. Riprova.');
define('ENTRY_LAST_NAME_TEXT', '*'); 
define('ENTRY_DATE_OF_BIRTH', 'Data di nascita:'); 
define('ENTRY_DATE_OF_BIRTH_ERROR', 'La tua data di nascita è corretta? Il nostro sistema richiede che la data sia in questo formato: MM/GG/AAAA (es. 05/21/1970'); 
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (es. 05/21/1970'); 
define('ENTRY_EMAIL_ADDRESS', 'Indirizzo e-mail:'); 
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Il tuo indirizzo e-mail è corretto? Deve contenere almeno ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' caratteri. Riprova.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Spiacenti'); 
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Este e-mail ya existe en nuestra base de datos - por favor'); 
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Nel nostro sistema è già presente questo indirizzo e-mail - prova ad accedere con tale indirizzo e-mail. Se non utilizzi più quell\'indirizzo puoi correggerlo nell\'area Account personale.'); 
define('ENTRY_EMAIL_ADDRESS_TEXT', '*'); 
define('ENTRY_NICK', 'Nickname per il forum:'); 
define('ENTRY_NICK_TEXT', '*'); 
define('ENTRY_NICK_DUPLICATE_ERROR', 'Questo nickname è già in uso. Provane un altro.'); 
define('ENTRY_NICK_LENGTH_ERROR', 'Riprova. Il tuo nickname deve contenere almeno ' . ENTRY_NICK_MIN_LENGTH . ' caratteri.');
define('ENTRY_STREET_ADDRESS', 'Indirizzo postale:'); 
define('ENTRY_STREET_ADDRESS_ERROR', 'Il tuo indirizzo postale deve contenere un minimo di ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' caratteri.');
define('ENTRY_STREET_ADDRESS_TEXT', '*'); 
define('ENTRY_SUBURB', 'Riga indirizzo 2:'); 
define('ENTRY_SUBURB_ERROR', ''); 
define('ENTRY_SUBURB_TEXT', ''); 
define('ENTRY_POST_CODE', 'CAP:'); 
define('ENTRY_POST_CODE_ERROR', 'Il tuo CAP deve contenere un minimo di ' . ENTRY_POSTCODE_MIN_LENGTH . ' caratteri.');
define('ENTRY_POST_CODE_TEXT', '*'); 
define('ENTRY_CITY', 'Città:'); 
define('ENTRY_CUSTOMERS_REFERRAL', 'Codice riferimento:'); 
define('ENTRY_CITY_ERROR', 'La tua città deve contenere un minimo di ' . ENTRY_CITY_MIN_LENGTH . ' caratteri.');
define('ENTRY_CITY_TEXT', '*'); 
define('ENTRY_STATE', 'Stato/Provincia:'); 
define('ENTRY_STATE_ERROR', 'Il tuo stato deve contenere un minimo di ' . ENTRY_STATE_MIN_LENGTH . ' caratteri.');
define('ENTRY_STATE_ERROR_SELECT', 'Seleziona uno stato nell\'elenco a discesa degli Stati.'); 
define('ENTRY_STATE_TEXT', '*'); 
define('JS_STATE_SELECT', '-- Scegliere --'); 
define('ENTRY_COUNTRY', 'Paese:'); 
define('ENTRY_COUNTRY_ERROR', 'Devi selezionare un paese nell\'elenco a discesa dei Paesi.'); 
define('ENTRY_COUNTRY_TEXT', '*'); 
define('ENTRY_TELEPHONE_NUMBER', 'Telefono:'); 
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Il tuo numero di telefono deve contenere un minimo di ' . ENTRY_TELEPHONE_MIN_LENGTH . ' caratteri.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*'); 
define('ENTRY_FAX_NUMBER', 'Numero di fax:'); 
define('ENTRY_FAX_NUMBER_ERROR', ''); 
define('ENTRY_FAX_NUMBER_TEXT', ''); 
define('ENTRY_NEWSLETTER', 'Iscriviti alla nostra newsletter.'); 
define('ENTRY_NEWSLETTER_TEXT', ''); 
define('ENTRY_NEWSLETTER_YES', 'Iscritto'); 
define('ENTRY_NEWSLETTER_NO', 'Annulla iscrizione'); 
define('ENTRY_NEWSLETTER_ERROR', ''); 
define('ENTRY_PASSWORD', 'Password:'); 
define('ENTRY_PASSWORD_ERROR', 'La tua password deve contenere un minimo di ' . ENTRY_PASSWORD_MIN_LENGTH . ' caratteri.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'La conferma della password deve corrispondere alla tua Password.'); 
define('ENTRY_PASSWORD_TEXT', '* (almeno ' . ENTRY_PASSWORD_MIN_LENGTH . ' caratteri');
define('ENTRY_PASSWORD_CONFIRMATION', 'Conferma password:'); 
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*'); 
define('ENTRY_PASSWORD_CURRENT', 'Password corrente:'); 
define('ENTRY_PASSWORD_CURRENT_TEXT', '*'); 
define('ENTRY_PASSWORD_CURRENT_ERROR', 'La tua password deve contenere un minimo di ' . ENTRY_PASSWORD_MIN_LENGTH . ' caratteri.');
define('ENTRY_PASSWORD_NEW', 'Nuova password:'); 
define('ENTRY_PASSWORD_NEW_TEXT', '*'); 
define('ENTRY_PASSWORD_NEW_ERROR', 'La tua nuova password deve contenere un minimo di ' . ENTRY_PASSWORD_MIN_LENGTH . ' caratteri.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'La conferma della password deve coincidere con la nuova password.'); 
define('PASSWORD_HIDDEN', '--NASCOSTO--'); 
define('FORM_REQUIRED_INFORMATION', '*Informazioni obbligatorie'); 
define('ENTRY_REQUIRED_SYMBOL', '*'); 
define('TEXT_RESULT_PAGE', ''); 
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Totale: <strong>%d</strong> Articoli &#160;;&#160;; <strong>%d</strong> / %d'); 
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> prodotti'); 
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> ordini'); 
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> recensioni'); 
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> nuovi prodotti'); 
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> speciali'); 
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> prodotti in evidenza'); 
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Visualizzazione da <strong>%d</strong> a <strong>%d</strong> (di <strong>%d</strong> prodotti'); 
define('TEXT_TOTAL_NUMBER_OF_REVIEWS', '(<strong>%d</strong>'); 
define('PREVNEXT_TITLE_FIRST_PAGE', 'Prima pagina'); 
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Pagina precedente'); 
define('PREVNEXT_TITLE_NEXT_PAGE', 'Pagina successiva'); 
define('PREVNEXT_TITLE_LAST_PAGE', 'Ultima pagina'); 
define('PREVNEXT_TITLE_PAGE_NO', 'Pagina %d'); 
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Serie precedente di %d pagine'); 
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Serie successiva di %d pagine'); 
define('PREVNEXT_BUTTON_FIRST', 'PRIMA'); 
define('PREVNEXT_BUTTON_PREV', 'Prec.'); 
define('PREVNEXT_BUTTON_NEXT', 'Succ.'); 
define('PREVNEXT_BUTTON_LAST', 'ULTIMA'); 
define('TEXT_BASE_PRICE', 'Inizio a:'); 
define('TEXT_CLICK_TO_ENLARGE', 'immagine più grande'); 
define('TEXT_SORT_PRODUCTS', 'Ordina prodotti'); 
define('TEXT_DESCENDINGLY', 'discendente'); 
define('TEXT_ASCENDINGLY', 'ascendente'); 
define('TEXT_BY', 'per'); 
define('TEXT_REVIEW_BY', 'per %s'); 
define('TEXT_REVIEW_WORD_COUNT', '%s parole'); 
define('TEXT_REVIEW_RATING', 'Valutazione: %s [%s]'); 
define('TEXT_REVIEW_DATE_ADDED', 'Data di aggiunta: %s'); 
define('TEXT_NO_REVIEWS', 'Attualmente non ci sono recensioni di prodotto.'); 
define('TEXT_NO_NEW_PRODUCTS', 'Altri nuovi prodotti saranno aggiunti a breve. Torna a trovarci in seguito.'); 
define('TEXT_UNKNOWN_TAX_RATE', 'Tassa di vendita'); 
define('TEXT_REQUIRED', '<span class="errorText">Obbligatorio</span>'); 
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Avvertenza: La directory d\'installazione esiste in: %s. Rimuovi questa directory per motivi di sicurezza.'); 
define('WARNING_CONFIG_FILE_WRITEABLE', 'Avvertenza: sono in grado di scrivere sul file di configurazione: %s. Questo è un potenziale rischio per la sicurezza - imposta le autorizzazioni utente corrette su questo file (solo lettura'); 
define('ERROR_FILE_NOT_REMOVEABLE', 'Errore: Impossibile rimuovere il file specificato. Potresti dover utilizzare FTP per rimuovere il file'); 
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Avvertenza: La directory delle sessioni non esiste: ' . zen_session_save_path() . '. Le sessioni non funzioneranno finché questa directory non sarà creata.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Avvertenza: non sono in grado di scrivere sul file di configurazione: ' . zen_session_save_path() . '. Le sessioni non funzioneranno finché non saranno state impostate le autorizzazioni utente.');
define('WARNING_SESSION_AUTO_START', 'Avvertenza: session.auto_start è abilitato - disabilitare questa funzione PHP in php.ini e riavviare il server Web.'); 
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Avvertenza: La directory dei prodotti scaricabili non esiste: ' . DIR_FS_DOWNLOAD . '. I prodotti scaricabili non funzioneranno finché questa directory non sarà valida.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Avvertenza: La directory della cache SQL non esiste: ' . DIR_FS_SQL_CACHE . '. La memorizzazione sulla cache SQL non funzionerà finché questa directory non sarà creata.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Avvertenza: Non sono in grado di scrivere sulla directory della cache SQL: ' . DIR_FS_SQL_CACHE . '. La memorizzazione sulla cache SQL non funzionerà finché non saranno impostate le autorizzazioni utente.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Sembra che il tuo database necessiti di aggiornamento a un livello superiore. Consulta Admin->Tools->Server Information per rivedere i livelli di aggiornamento.'); 
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'AVVERTENZA: Impossibile individuare il file della lingua:'); 
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'La data di scadenza immessa per la carta di credito non è valida. Verifica la data e riprova.'); 
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Il numero di carta di credito immesso non è valido. Verifica il numero e riprova.'); 
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Il numero della carta di credito che inizia con %s non è stato inserito correttamente'); 
define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Coupon di sconto'); 
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' Domande frequenti (FAQ)');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Saldo');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Account');
define('GV_FAQ', TEXT_GV_NAME . ' Domande frequenti (FAQ)');
define('ERROR_REDEEMED_AMOUNT', 'Congratulazioni'); 
define('ERROR_NO_REDEEM_CODE', 'Non hai immesso un ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Non valido ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
define('TABLE_HEADING_CREDIT', 'Crediti disponibili'); 
define('GV_HAS_VOUCHERB', '><strong>e-mail</strong></a> a qualcuno'); 
define('ENTRY_AMOUNT_CHECK_ERROR', 'Non hai fondi sufficienti per inviare questo importo.'); 
define('BOX_SEND_TO_FRIEND', 'Invia ' . TEXT_GV_NAME );
define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Riscattato');
define('CART_COUPON', 'Coupon:'); 
define('CART_COUPON_INFO', 'altre info'); 
define('TEXT_SEND_OR_SPEND', 'Hai un saldo disponibile nel tuo ' . TEXT_GV_NAME . ' account. Puoi spenderlo o inviarlo a qualcun altro. Per inviare fai clic sul pulsante sottostante.');
define('TEXT_BALANCE_IS', 'Il tuo ' . TEXT_GV_NAME . ' saldo è:');
define('TEXT_AVAILABLE_BALANCE', 'Il tuo ' . TEXT_GV_NAME . ' Account');
define('PAYMENT_METHOD_GV', 'certificato regalo/coupon'); 
define('PAYMENT_MODULE_GV', 'GV/DC'); 
define('TABLE_HEADING_CREDIT_PAYMENT', 'Crediti disponibili'); 
define('TEXT_INVALID_REDEEM_COUPON', 'Codice Coupon non valido'); 
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Devi spendere almeno %s per riscattare questo coupon'); 
define('TEXT_INVALID_STARTDATE_COUPON', 'Questo coupon non è ancora disponibile'); 
define('TEXT_INVALID_FINISHDATE_COUPON', 'Questo coupon è scaduto'); 
define('TEXT_INVALID_USES_COUPON', 'Questo coupon può essere usato solo'); 
define('TIMES', 'volte.'); 
define('TIME', 'volta.'); 
define('TEXT_INVALID_USES_USER_COUPON', 'Hai utilizzato il codice coupon: %s il numero massimo di volte consentito per cliente.'); 
define('REDEEMED_COUPON', 'un coupon valido'); 
define('REDEEMED_MIN_ORDER', 'sugli ordini di oltre'); 
define('REDEEMED_RESTRICTIONS', '[Product-Category restrictions apply]'); 
define('TEXT_ERROR', 'Si è verificato un errore'); 
define('TEXT_INVALID_COUPON_PRODUCT', 'Questo codice coupon non è valido per alcun prodotto presente attualmente nel tuo carrello.'); 
define('TEXT_VALID_COUPON', 'Congratulazioni hai riscattato il coupon di sconto'); 
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Il codice coupon che hai immesso non è valido per l\'indirizzo selezionato.'); 
define('MORE_INFO_TEXT', '...altre info'); 
define('TEXT_YOUR_IP_ADDRESS', 'Il tuo indirizzo IP è:'); 
define('HEADING_ADDRESS_INFORMATION', 'Informazioni di indirizzo'); 
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Quantità nel carrello:'); 
define('PRODUCTS_ORDER_QTY_TEXT', 'Aggiungi al carrello:'); 
define('SUCCESS_ADDED_TO_CART_PRODUCT', 'Prodotto aggiunto correttamente  al carrello...'); 
define('SUCCESS_ADDED_TO_CART_PRODUCTS', 'Prodotto/i selezionato/i aggiunto/i correttamente al carrello...'); 
define('TEXT_PRODUCT_WEIGHT_UNIT', 'kg'); 
define('TEXT_SHIPPING_WEIGHT', 'kg'); 
define('TEXT_SHIPPING_BOXES', 'Scatole'); 
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Risparmi: &#160;;'); 
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% di sconto'); 
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', '&#160;;di sconto'); 
define('PRODUCT_PRICE_SALE', 'Saldo: &#160;;'); 
define('TEXT_NUMBER_SYMBOL', '#'); 
define('BOX_HEADING_BANNER_BOX', 'Sponsor'); 
define('TEXT_BANNER_BOX', 'Visita i nostri sponsor...'); 
define('BOX_HEADING_BANNER_BOX2', 'Hai visto...'); 
define('TEXT_BANNER_BOX2', 'Dai un\'occhiata a questo oggi!'); 
define('BOX_HEADING_BANNER_BOX_ALL', 'Sponsor'); 
define('TEXT_BANNER_BOX_ALL', 'Visita i nostri sponsor...'); 
define('PULL_DOWN_ALL', 'Seleziona'); 
define('PULL_DOWN_MANUFACTURERS', '- Reimposta -'); 
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Seleziona'); 
define('TEXT_INFO_SORT_BY', 'Ordina per:'); 
define('TEXT_CLOSE_WINDOW', '- Fai clic sull\'immagine per chiudere'); 
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Close Window ]'); 
define('ERROR_FILETYPE_NOT_ALLOWED', 'Errore:  Tipo di file non consentito.'); 
define('WARNING_NO_FILE_UPLOADED', 'Avvertenza:  nessun file caricato.'); 
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Riuscito:  file salvato correttamente.'); 
define('ERROR_FILE_NOT_SAVED', 'Errore:  File non salvato.'); 
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Errore:  destinazione non scrivibile.'); 
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Errore: la destinazione non esiste.'); 
define('ERROR_FILE_TOO_BIG', 'Avvertenza: Il file è troppo grande per essere caricato!<br '); 
define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'AVVISO: Questo sito non sarà disponibile per manutenzione programmata il:'); 
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'AVVISO: Il sito Web non è attualmente disponibile al pubblico per manutenzione'); 
define('PRODUCTS_PRICE_IS_FREE_TEXT', 'È gratuito!'); 
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Chiama per il prezzo'); 
define('TEXT_CALL_FOR_PRICE', 'Chiama per il prezzo'); 
define('TEXT_INVALID_SELECTION', 'Hai effettuato una selezione non valida:'); 
define('TEXT_ERROR_OPTION_FOR', 'Sull\'opzione per:'); 
define('TEXT_INVALID_USER_INPUT', 'Input dell\'utente richiesto<br '); 
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Min:'); 
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Unità:'); 
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'Nel carrello:'); 
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Aggiungi supplementare:'); 
define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Max:'); 
define('TEXT_PRODUCTS_MIX_OFF', '*Mix DISATTIVO'); 
define('TEXT_PRODUCTS_MIX_ON', '*Mix ATTIVO'); 
define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br '); 
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Il valore dell\'opzione Misto è ATTIVO<br '); 
define('ERROR_MAXIMUM_QTY', 'La quantità aggiunta al tuo carrello è stata rettificata a causa di una limitazione sul massimo che ti è consentito. Guarda questo articolo:'); 
define('ERROR_CORRECTIONS_HEADING', 'Correggi quanto segue: <br '); 
define('ERROR_QUANTITY_ADJUSTED', 'La quantità aggiunta al tuo carrello è stata rettificata. L\'articolo che desideri non è disponibili in frazioni di quantità. La quantità dell\'articolo:'); 
define('ERROR_QUANTITY_CHANGED_FROM', ''); 
define('ERROR_QUANTITY_CHANGED_TO', 'a'); 
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'NOTA: I download non sono disponibili finché il pagamento non è stato confermato'); 
define('TEXT_FILESIZE_BYTES', 'byte'); 
define('TEXT_FILESIZE_MEGS', 'MB'); 
define('ERROR_PRODUCT', 'L\'articolo:'); 
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br '); 
define('ERROR_PRODUCT_QUANTITY_MIN', ''); 
define('ERROR_PRODUCT_QUANTITY_UNITS', '... Errori Quantità unità -'); 
define('ERROR_PRODUCT_OPTION_SELECTION', '<br '); 
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br '); 
define('ERROR_PRODUCT_QUANTITY_MAX', '... Errori Quantità massima -'); 
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ''); 
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', '... Errori Quantità unità -'); 
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', '... Errori Quantità massima -'); 
define('WARNING_SHOPPING_CART_COMBINED', 'AVVISO: Per tua comodità'); 
define('ERROR_CUSTOMERS_ID_INVALID', 'Le informazioni sul cliente non possono essere convalidate!<br '); 
define('TABLE_HEADING_FEATURED_PRODUCTS', 'Prodotti in evidenza'); 
define('HOT_PRODUCTS', 'I prodotti più richiesti'); 
define('TABLE_HEADING_NEW_PRODUCTS', 'Nuovi prodotti per %s'); 
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Prodotti in arrivo'); 
define('TABLE_HEADING_DATE_EXPECTED', 'Data prevista'); 
define('TABLE_HEADING_SPECIALS_INDEX', 'Specialità mensili per %s'); 
define('CAPTION_UPCOMING_PRODUCTS', 'Questi articoli saranno presto a magazzino'); 
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'la tabella contiene un elenco di prodotti che saranno presto a magazzino e le date in cui è previsto il loro arrivo'); 
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'È gratuito!'); 
define('TEXT_SHOWCASE_ONLY', 'Contattaci'); 
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Prezzo non disponibile'); 
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Accedi per il prezzo'); 
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); 
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'Solo Show Room'); 
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Prezzo non disponibile'); 
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'IN ATTESA DI APPROVAZIONE'); 
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Accedi per acquistare'); 
define('TEXT_CHARGES_WORD', 'Addebito calcolato:'); 
define('TEXT_PER_WORD', '<br '); 
define('TEXT_WORDS_FREE', 'Parola/e gratuita/e'); 
define('TEXT_CHARGES_LETTERS', 'Addebito calcolato:'); 
define('TEXT_PER_LETTER', '<br '); 
define('TEXT_LETTERS_FREE', 'Lettera/e gratuita/e'); 
define('TEXT_ONETIME_CHARGES', '*addebiti una-tantum ='); 
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*addebiti una-tantum =');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Opzione sconti quantità'); 
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'QTÀ'); 
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'PREZZO'); 
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Opzione sconti quantità Addebiti una-tantum'); 
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', 'numero massimo di caratteri consentito'); 
define('TEXT_REMAINING', 'rimanenti'); 
define('CART_SHIPPING_OPTIONS', 'Costi di spedizione previsti');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Please <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>, to display your personal shipping costs.');
define('CART_SHIPPING_METHOD_TEXT', 'Metodi di spedizione disponibili');
define('CART_SHIPPING_METHOD_RATES', 'Tariffe'); 
define('CART_SHIPPING_METHOD_TO', "Consegna verso l'");
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Ship to: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Log In</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Spedizione gratuita');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Download'); 
define('CART_SHIPPING_METHOD_RECALCULATE', 'Ricalcola'); 
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'true'); 
define('CART_SHIPPING_METHOD_ADDRESS', 'Indirizzo:'); 
define('CART_OT', 'Costo totale previsto:'); 
define('CART_OT_SHOW', 'true'); 
define('CART_ITEMS', 'Articoli nel carrello:'); 
define('CART_SELECT', 'Seleziona'); 
define('ERROR_CART_UPDATE', '<strong>Aggiorna il tuo ordine.</strong>'); 
define('IMAGE_BUTTON_UPDATE_CART', 'Aggiorna'); 
define('EMPTY_CART_TEXT_NO_QUOTE', 'Oops! La tua sessione è scaduta... Aggiorna il tuo carrello per il preventivo di spedizione...'); 
define('CART_SHIPPING_QUOTE_CRITERIA', 'I preventivi di spedizione sono basati sulle informazioni dell\'indirizzo selezionato:'); 
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Aggiungi:'); 
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Aggiungi:'); 
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Aggiungi:'); 
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Aggiungi:'); 
define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Sconti qtà Sconto sul prezzo'); 
define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Sconti qtà Nuovo prezzo'); 
define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Sconti qtà Sconto sul prezzo'); 
define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '*Gli sconti possono variare in base alle opzioni precedenti'); 
define('TEXT_HEADER_DISCOUNTS_OFF', 'Sconti q.tà non disponibili...'); 
define('PULL_DOWN_ALL_RESET', '- REIMPOSTA -'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Nome prodotto'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Nome prodotto - desc'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Prezzo - da basso ad alto'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Prezzo - da alto e basso'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Modello'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Data di aggiunta - da nuovo a vecchio'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Data di aggiunta - da vecchio a nuovo'); 
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Visualizzazione predefinita'); 
define('TABLE_HEADING_DOWNLOAD_DATE', 'Il link scade'); 
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Rimanenti'); 
define('HEADING_DOWNLOAD', 'Per scaricare i file fai clic sul pulsante download e scegli "Salva su disco" nel menu a comparsa.'); 
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Nome file'); 
define('TABLE_HEADING_PRODUCT_NAME', 'Nome articolo'); 
define('TABLE_HEADING_BYTE_SIZE', 'Dimensione file'); 
define('TEXT_DOWNLOADS_UNLIMITED', 'Illimitata'); 
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---'); 
define('COLON_SPACER', ':&#160;;&#160;;'); 
define('TABLE_HEADING_QUANTITY', 'Qtà.'); 
define('TABLE_HEADING_PRODUCTS', 'Nome articolo'); 
define('TABLE_HEADING_TOTAL', 'Totale'); 
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Informativa sulla Privacy'); 
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Riconosci di accettare la nostra Informativa sulla privacy selezionando la casella seguente. L\'informativa sulla privacy può essere consultata su <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">here</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Ho letto e accetto la vostra Informativa sulla privacy.'); 
define('TABLE_HEADING_ADDRESS_DETAILS', 'Dettagli indirizzo'); 
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Dettagli di contatto aggiuntivi'); 
define('TABLE_HEADING_DATE_OF_BIRTH', 'Verifica la tua età'); 
define('TABLE_HEADING_LOGIN_DETAILS', 'Dettagli di accesso'); 
define('TABLE_HEADING_REFERRAL_DETAILS', 'Ci sei stato segnalato?'); 
define('ENTRY_EMAIL_PREFERENCE', 'Newsletter e dettagli e-mail'); 
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML'); 
define('ENTRY_EMAIL_TEXT_DISPLAY', 'Solo TESTO'); 
define('EMAIL_SEND_FAILED', 'ERRORE: Errore invio e-mail a: "%s" <%s> con oggetto: "%s'); 
define('DB_ERROR_NOT_CONNECTED', 'Errore - Impossibile connettersi al database'); 
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'AVVERTENZA: INTESTAZIONE PAGINE EZ - Attivo solo per IP admin'); 
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'AVVERTENZA: PIÈ DI PAGINA PAGINE EZ - Attivo solo per IP admin'); 
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'AVVERTENZA: BOX LATERALE PAGINE EZ - Attivo solo per IP admin'); 
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', ''); 
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Articoli che iniziano per...'); 
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Reimposta --');

if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
} else {
    $template_dir_select = '';
}
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

define('FIBERSTORE_VIEW_MORE', 'Altri articoli...'); 
define('FIBERSTORE_WISHLIST_ADD_TO_CART', 'Aggiungi al carrello'); 
define('FIBERSTORE_MESSAGE_ADD_TO_WISHLIST_SUCCESS', 'Aggiungi alla lista dei desideri riuscita'); 
define('FIBERSTORE_DELETE', 'Elimina'); 
define('FIBERSTORE_PRICE', 'PREZZO'); 
define('FIBERSTORE_VIEW_MORE_ORDERS', 'Visualizza tutti gli ordini »'); 
define('FIBERSTORE_ORDER_IMAGE', 'Immagine prodotti'); 
define('FIBERSTORE_POST', 'Post'); 
define('FIBERSTORE_CANCEL_ORDER', 'Annulla ordine'); 
define('FIBERSTORE_PRODTCTS_DETAILS', 'Dettagli prodotti'); 
define('FIBERSTORE_OEM_CUSTOM', 'OEM & CLIENTE'); 
define('FIBERSTORE_ANY_TYPE', 'Qualsiasi tipo'); 
define('FIBERSTORE_ANY_LENGTH', 'Qualsiasi lunghezza'); 
define('FIBERSTORE_ANY_COLOR', 'Qualsiasi colore'); 
define('FIBERSTORE_WORK_PROJECT', 'Lavoriamo con te sul tuo progetto personalizzato'); 
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');
define('TEXT_PREFIX', 'text_prefix_'); 
define('LIVE_CHAT_TIT', 'Ottieni tutto il supporto sull\'acquisto'); 
define('LIVE_CHAT_TIT1', 'Il servizio professionale & il supporto sono disponibili in tre modi diversi'); 
define('LIVE_CHAT_TIT2', 'Pubblicazione del tuo messaggio su FS.COM effettuata correttamente'); 
define('LIVE_CHAT_CON1', 'Chatta dal vivo con FS.COM'); 
define('LIVE_CHAT_CON2', 'Parlare con noi e ottenere immediatamente le informazioni relative.'); 
define('LIVE_CHAT_CON3', 'dalle 8:00 a mezzanotte PST, lun. - ven.'); 
define('LIVE_CHAT_CON4', 'Lasciaci un messaggio'); 
define('LIVE_CHAT_CON5', 'Lascia un messaggio'); 
define('LIVE_CHAT_CON6', 'Invia un\'e-mail a FS.COM'); 
define('LIVE_CHAT_CON7', 'Risposta entro 12 ore'); 
define('LIVE_CHAT_CON8', 'Pubblica una domanda e ottieni una risposta rapida da FS.COM.'); 
define('LIVE_CHAT_CON9', 'Mandaci una e-mail ora'); 
define('LIVE_CHAT_CON10', 'Disponibile'); 
define('LIVE_CHAT_CON11', 'Non disponibile'); 
define('LIVE_CHAT_CON12', 'Effettua una chiamata'); 
define('ALL_ORDER', 'Tutti gli ordini'); 
define('UNPAID_ORDER', 'Ordini in sospeso'); 
define('TRADING_ORDERS', 'Ordini di transazione'); 
define('CLOSED_ORDERS', 'Ordini annullati'); 
define('FIBERSTORE_QUESTION', 'Domanda inviata correttamente'); 
define('FIBERSTORE_ORDER_PRIVATE', 'Ordini privati'); 
define('FIBERSTORE_ORDER_COMPANY', 'Tutti gli ordini della società'); 
define('FIBERSTORE_ORDER_SELECT', 'Seleziona per Data ordine'); 
define('PLEASE', 'Seleziona'); 
define('WEEK', 'Ultima settimana'); 
define('MONTH', 'Ultimo mese'); 
define('THREE_MONTH', 'Ultimi tre mesi'); 
define('FIBERSTORE_ORDER_ENTER', 'Inserisci il N. ordine'); 
define('FIBERSTORE_ORDER_NO', 'N. ordine'); 
define('SEARCH', 'Traccia');
define('FIBERSTORE_ORDER_PROMT', 'Nessun ordine trovato.'); 
define('FIBERSTORE_ORDER_PROMT_RMA', 'N. richiesta RMA'); 
define('FIBERSTORE_ORDER_PROMT1', 'N. richiesta RMA'); 
define('FIBERSTORE_ORDER_PROMT2', 'Nessun ordine trovato.'); 
define('FIBERSTORE_ORDER_PROMT3', 'Annullato'); 
define('FIBERSTORE_ORDER_PROMT4', 'Indirizzo di spedizione'); 
define('FIBERSTORE_ORDER_PICTURE', 'Immagine prodotti'); 
define('FIBERSTORE_ORDER_DATE', 'Data dell\'ordine'); 
define('PAYMENT', 'Pagamento'); 
define('CANCELED', 'Annullato'); 
define('FIBERSTORE_ORDER_OPERATE', 'Opera'); 
define('PREVIOUS', 'Prec.'); 
define('NEXT', 'Succ.'); 
define('FIBERSTORE_ORDER_PAGE', 'Pagina'); 
define('FIBERSTORE_ORDER_OF', 'di'); 
define('FS_LEARN_MORE', 'Ulteriori informazioni'); 
define('CONNECTING_PAYPAL', 'Collegamento a Paypal'); 
define('ARE_YOU_SURE', 'Annullare quest\'ordine?'); 
define('ONCE_YOU_DO', 'Una volta effettuato ciò'); 
define('HOWEVER', 'Tuttavia'); 
define('EXPENSIVE', 'Tassa di spedizione elevata'); 
define('DUPLICATE', 'Ordine duplicato'); 
define('FAILING', 'Mancato pagamento'); 
define('WRONG', 'Informazioni scritte erroneamente'); 
define('OUT', 'Esaurito'); 
define('NO_NEED', 'Non è più necessario');
define('OFFLINE', 'Offerta offline'); 
define('FIBERSTORE_ORDER_CONFIRM', 'Conferma'); 
define('OTHERS', 'Altri'); 
define('BEFORE_SUBMITTING', 'Prima dell\'invio'); 
define('CANCEL', 'Annulla'); 
define('FS_COMPANY', 'Metodo di consegna'); 
define('FS_TIME', 'Consegna prevista'); 
define('FS_COST', 'Costo di spedizione'); 
define('FS_TO', 'a'); 
define('FS_VIA', 'Tramite'); 
define('FS_FREE_SHIP', 'Spedizione gratuita');
define('FS_PREFER', 'Se preferisci utilizzare il tuo account express'); 
define('FS_METHOD', 'Metodo di spedizione'); 
define('FS_ACCOUNt', 'Express Account'); 
define('FS_NO_SHIPPING', 'Nessuna spedizione disponibile per il paese selezionato'); 
define('FS_SHIP_CONFIRM', 'Conferma'); 
define('FS_BUSINESS_DAYS', 'giorni lavorativi');
define('FS_BUSINESS_DAY', 'giorni lavorativi');
define('FS_WORK_DAYS_SERVICE', 'giorni lavorativi');
define('FS_COMMON_CLEAR', 'Cancella selezioni'); 
define('FS_COMMON_COMPLIANT', 'Conforme agli standard IEEE 802.3z per applicazioni Fast Ethernet e Gigabit Ethernet'); 
define('FS_COMMON_ADD', 'Aggiungi'); 
define('FS_COMMON_ADDED', 'Aggiunto'); 
define('FS_COMMON_PROCESSING', 'Elaborando');
define('FS_COMMON_PLEASE_WAIT', 'Attendi'); 
define('FS_COMMON_PRODUCT', 'Vista rapida prodotto'); 
define('FS_COMMON_NEXT', 'Succ.'); 
define('FS_COMMON_PREVIOUS', 'Prec'); 
define('FS_VERIFIED_PUR', 'Acquisto verificato'); 
define('FS_COMMENTS', 'Commenti'); 
define('FS_REVIEWS10', 'Condividi'); 
define('FS_REVIEWS11', 'Commenti'); 
define('FS_CANCEL', 'Annulla'); 
define('FS_SUBMIT', 'Invia'); 
define('FS_DELETE_SUCESS', 'Eliminazione riuscita.'); 
define('FS_DELETE', 'Elimina'); 
define('FS_EDIT_POST', 'Modifica questo post'); 
define('FS_REVIEW_REPORT', 'Report'); 
define('FS_REVIEWS34', 'Voti utili'); 
define('FS_REVIEWS35', 'Voto utile'); 
define('FS_REVIEWS31', 'Visualizzazione'); 
define('FS_REVIEWS32', 'commento'); 
define('FS_REVIEWS36', 'commenti'); 
define('FS_BY', 'Di'); 
define('FS_ADAPTER_TYPE', 'Tipo adattatore'); 
define('FS_TRANS_RELATED', 'Tipo'); 
define('FS_REVIEWS_REPLACE', 'Sostituisci intestazione'); 
define('FS_REVIEWS_EDIT', 'Modifica il tuo profilo'); 
define('FS_REVIEWS_RECOMMENDED', 'Intestazione raccomandata'); 
define('FS_REVIEWS_LOCAL', 'Caricamento locale'); 
define('FS_REVIEWS_ONLY', 'Only supports JPG'); 
define('FS_REVIEWS_SAVE', 'salva'); 
define('ACCOUNT_FOOTER_LEARN', 'Visualizza altro...'); 
define('ACCOUNT_MY_ACCOUNT', 'Mio Account');
define('ACCOUNT_MY_REVIEWS', 'Le mie recensioni'); 
define('ACCOUNT_EDIT_ACCOUNT', 'Impostazioni account'); 
define('ACCOUNT_EDIT_BELOW', 'Modifica le tue informazioni sottostanti'); 
define('ACCOUNT_EDIT_FOLLOW', 'Controlla quanto segue...'); 
define('ACCOUNT_EDIT_SUCCESS', 'Riuscito'); 
define('ACCOUNT_EDIT_ACCOUNT_INFO', 'Informazioni account'); 
define('ACCOUNT_EDIT_UPDATE', 'Aggiorna'); 
define('ACCOUNT_EDIT_EMAIL', 'Indirizzo e-mail'); 
define('ACCOUNT_EDIT_NEW', 'Nuova password'); 
define('ACCOUNT_EDIT_REENTER', 'Inserisci nuovamente la password'); 
define('ACCOUNT_EDIT_ADDRESS', 'Informazioni di indirizzo'); 
define('ACCOUNT_EDIT_FIRST', 'Nome'); 
define('ACCOUNT_EDIT_LAST', 'Cognome'); 
define('ACCOUNT_EDIT_COMPANY', 'Nome della società'); 
define('ACCOUNT_EDIT_STREET', 'Riga indirizzo 1'); 
define('ACCOUNT_EDIT_LINE', 'Riga indirizzo 2'); 
define('ACCOUNT_EDIT_POSTAL', 'CAP'); 
define('ACCOUNT_EDIT_CITY', 'Città'); 
define('ACCOUNT_EDIT_COUNTRY', 'Paese/Regione di destinazione'); 
define('ACCOUNT_EDIT_STATE', 'Stato/Provincia/Regione'); 
define('ACCOUNT_EDIT_PHONE', 'Numero di telefono'); 
define('ACCOUNT_EDIT_EMIAL_MSG', 'L\'indirizzo e-mail che hai inserito non è riconosciuto (esempio: qualcuno@esempio.com).'); 
define('ACCOUNT_EDIT_PASS_MSG', '6 caratteri minimo; almeno una lettera e un numero.'); 
define('ACCOUNT_EDIT_CONFIRM_MSG', 'La password di conferma non corrisponde alla nuova password. Devono essere identici'); 
define('ACCOUNT_EDIT_FIRST_MSG', 'InseriscI il nome.'); 
define('ACCOUNT_EDIT_LAST_MSG', 'Inserisci il cognome.'); 
define('ACCOUNT_EDIT_STREET_MSG', 'Inserisci il tuo indirizzo postale.'); 
define('ACCOUNT_EDIT_POSTAL_MSG', 'Inserisci un CAP valido.'); 
define('ACCOUNT_EDIT_CITY_MSG', 'Inserisci la città.'); 
define('ACCOUNT_EDIT_CITY_FROMAT_TIP', 'La città deve essere come minimo di 2 caratteri.'); 
define('ACCOUNT_EDIT_SUBCITY_FROMAT_TIP', 'La riga del tuo indirizzo 2 deve essere come minimo di 2 caratteri.'); 
define('ACCOUNT_EDIT_COUNTRY_MSG', 'Inserisci il tuo paese/regione.'); 
define('ACCOUNT_EDIT_STATE_MSG', 'Inserisci il tuo Stato/Provincia/Regione.'); 
define('ACCOUNT_EDIT_PHONE_MSG', 'Inserisci il tuo numero di telefono.'); 
define('ACCOUNT_EDIT_HEADER_OUR', 'Nel nostro sistema è già presente un record di quell\'indirizzo e-mail.'); 
define('ACCOUNT_EDIT_HEADER_EDIT', 'Nickname modificato correttamente.'); 
define('ACCOUNT_EDIT_HEADER_FILE', 'Il file è troppo grande!'); 
define('ACCOUNT_EDIT_HEADER_CUSTOMER', 'La foto del cliente è stata modificata.'); 
define('ACCOUNT_EDIT_HEADER_THANKS', 'Grazie'); 
define('ACCOUNT_EDIT_HEADER_FS', 'Servizio clienti FS.COM'); 
define('ACCOUNT_EDIT_HEADER_INFO', 'FS.COM - Aggiornamento informazioni account'); 
define('ACCOUNT_EDIT_HEADER_YOUR', 'Le informazioni del tuo account FS.COM sono state aggiornate. Fai riferimento di seguito per verificare l\'aggiornamento delle informazioni del tuo account'); 
define('FS_QUSTION', 'Domande'); 
define('FS_QUSTI', 'Domanda'); 
define('FS_QUSTION_TELL', 'Condividi eventuali domande riguardanti l\'account'); 
define('FS_QUSTION_ASK', 'Poni una domanda'); 
define('FS_QUSTION_DATE', 'Data'); 
define('FS_QUSTION_STATUS', 'Stato'); 
define('FS_QUSTION_VIEW', 'Visualizza'); 
define('FS_QUSTION_REMOVE', 'Rimuovi'); 
define('FS_QUSTION_ENTRIES', 'Voci'); 
define('FS_QUSTION_NO', 'Nessun titolo compilato.'); 
define('FS_QUSTION_ANSWERS', 'Risposte'); 
define('FS_QUSTION_REPLY', 'Domanda in corso'); 
define('FS_QUSTION_JS', 'Eliminare queste informazioni?'); 
define('FS_QUSTION_STATUS_JS', 'Confermi?'); 
define('FS_ADDRESS_BOOK', 'Impostazione dell\'indirizzo');
define('FS_ADDRESS_NAME', 'Nome'); 
define('FS_ADDRESS_COMPANY', 'Società'); 
define('FS_ADDRESS_ADDRESS', 'Indirizzo'); 
define('FS_ADDRESS_NO', 'Nessun indirizzo trovato'); 
define('FS_ADDRESS_DEFAULT', 'Predefinito'); 
define('FS_ADDRESS_PO', 'PO'); 
define('FS_ADDRESS_SET', 'Imposta come predefinito'); 
define('FS_ADDRESS_EDIT', 'Modifica'); 
define('FS_ADDRESS_CREATE', 'Crea indirizzo'); 
define('FS_ADDRESS_UPDATE', 'Aggiorna voce d\'indirizzo'); 
define('FS_ADDRESS_PLEASE', 'Compila questo modulo per modificare l\'indirizzo'); 
define('FS_ADDRESS_FIRST_REQUIRED_TIP', 'Il tuo nome non può essere vuoto.'); 
define('FS_ADDRESS_FIRST_MSG', 'Il tuo nome deve contenere come minimo 2 caratteri.'); 
define('FS_ADDRESS_LAST_REQUIRED_TIP', 'Il tuo cognome non può essere vuoto.'); 
define('FS_ADDRESS_LAST_MSG', 'Il tuo cognome deve contenere come minimo 2 caratteri.'); 
define('FS_ADDRESS_SORRY', 'Spiacenti'); 
define('FS_ADDRESS_STREET_FORMAT_TIP', 'La riga 1 dell\'indirizzo deve avere lunghezza compresa tra 4 e 35 caratteri.'); 
define('FS_ADDRESS_STREET_PO_BOX_TIP', 'Non effettuiamo spedizioni a caselle postali (PO Box).'); 
define('FS_ADDRESS_POSTAL_REQUIRED_TIP', 'Il tuo CAP non può essere vuoto.'); 
define('FS_ADDRESS_POSTAL_MSG', 'Il tuo CAP deve essere come minimo di 3 caratteri.'); 
define('FS_ADDRESS_COUNTRY_MSG', 'Il tuo paese è obbligatorio.'); 
define('FS_ADDRESS_STATE_MSG', 'Il tuo stato è obbligatorio.'); 
define('FS_ADDRESS_PHONE_REQUIRED_TIP', 'Il numero di telefono non può essere vuoto.'); 
define('FS_ADDRESS_PHONE_MSG', 'Il numero di telefono deve essere almeno di 6 cifre.');
define('FS_ADDRESS_UP_ADDRESS', 'Aggiorna indirizzo'); 
define('FS_ADDRESS_NEW', 'Nuovo indirizzo'); 
define('FS_ADDRESS_NEW_PLEASE', 'Compila questo modulo per aggiungere un nuovo indirizzo'); 
define('FS_ADDRESS_ADD', 'Aggiungi indirizzo'); 
define('FS_ADDRESS_DELETE', 'Indirizzo eliminato correttamente!'); 
define('FS_ADDRESS_SET_SUCCESS', 'Indirizzo predefinito impostato correttamente!'); 
define('FS_ADDRESS_UP_SUCCESS', 'Indirizzo aggiornato correttamente.'); 
define('FS_ADDRESS_ADD_SUCCESS', 'Indirizzo aggiunto correttamente'); 
define('FS_PO_ADDRESS_01', 'Vuoi inviare questo indirizzo come indirizzo del PO?'); 
define('FS_PO_ADDRESS_02', 'La tua domanda è stata inviata correttamente.'); 
define('FS_PO_ADDRESS_03', 'Nota'); 
define('FS_PO_ADDRESS_04', 'Dopo aver effettuato quest\'ordine correttamente'); 
define('FS_PO_ADDRESS_05', 'conferma l\'indirizzo'); 
define('FS_PO_ADDRESS_06', 'riseleziona l\'indirizzo'); 
define('FS_PO_ADDRESS_07', 'Modifica limite di credito'); 
define('FS_PO_ADDRESS_08', 'Aumenta l\'importo'); 
define('FS_PO_ADDRESS_09', 'Sì'); 
define('FS_PO_ADDRESS_10', 'No'); 
define('FS_PO_ADDRESS_11', 'Il tuo credito rimanente non è sufficiente'); 
define('FS_ADDRESS_SET_PO_SUCCESS', 'Il tuo indirizzo PO è stato inviato.'); 
define('MANAGE_ORDER_STATUS', 'Stato dell\'ordine'); 
define('MANAGE_ORDER_ORDER', 'Ordine'); 
define('MANAGE_ORDER_SHIPMENT', 'Consegna');
define('MANAGE_ORDER_INFORMATION', 'Informazioni sull\'ordine'); 
define('MANAGE_ORDER_DATE', 'Data dell\'ordine'); 
define('MANAGE_ORDER_PAYMENT', 'Metodo di pagamento'); 
define('MANAGE_ORDER_SEE', 'Vedi tutti'); 
define('MANAGE_ORDER_PO', 'N. PO'); 
define('MANAGE_ORDER_RMA_NO', 'ID/N. RMA'); 
define('MANAGE_ORDER_TEL', 'tel.'); 
define('MANAGE_ORDER_NOT', 'Non ancora impostato'); 
define('MANAGE_ORDER_SHIPPING', 'Indirizzo di spedizione'); 
define('MANAGE_ORDER_PRODUCT', 'Prodotto'); 
define('MANAGE_ORDER_ITEM', 'Prezzo articolo'); 
define('MANAGE_ORDER_QUANTITY', 'Quantità'); 
define('MANAGE_ORDER_TOTAL', 'Totale'); 
define('MANAGE_ORDER_QTY', 'Qtà'); 
define('MANAGE_ORDER_WRITE', 'Scrivi una recensione'); 
define('MANAGE_ORDER_PRINT', 'Stampa fatture'); 
define('MANAGE_ORDER_REORDER', 'Riordina'); 
define('MANAGE_ORDER_TIME', 'Tempo di elaborazione'); 
define('MANAGE_ORDER_INFO', 'Informazioni sul processo'); 
define('MANAGE_ORDER_OPERATOR', 'Operatore di processo'); 
define('MANAGE_ORDER_COMMODITY', 'Elaborazione prodotti base'); 
define('MANAGE_ORDER_MSG', 'Annullamento dell\'ordine riuscito!'); 
define('MANAGE_ORDER_ALL', 'Tutti gli ordini'); 
define('MANAGE_ORDER_PENDING', 'Ordini in sospeso'); 
define('MANAGE_ORDER_COMPLETED', 'Ordini completati'); 
define('MANAGE_ORDER_CANCELLED', 'Ordini annullati'); 
define('MANAGE_ORDER_RMA', 'RMA'); 
define('MANAGE_ORDER_PLACED', 'Ordine effettuato'); 
define('MANAGE_ORDER_SHIPING', 'Spedizione a'); 
define('MANAGE_ORDER_DETAILS', 'Dettagli ordine'); 
define('MANAGE_ORDER_INVOICE', 'Stampa fattura'); 
define('MANAGE_ORDER_BUY', 'Acquista di nuovo'); 
define('MANAGE_ORDER_VIEW', 'Visualizza più merce nell\'ordine'); 
define('MANAGE_ORDER_PAY', 'Paga ora'); 
define('MANAGE_ORDER_CANCEL', 'Annulla ordine'); 
define('MANAGE_ORDER_DOWNLOAD_INVOICE', 'Scarica fattura'); 
define('MANAGE_ORDER_RETURN', 'Reso/sostituzione'); 
define('MANAGE_ORDER_RESTORE', 'Ripristina ordine'); 
define('MANAGE_ORDER_MONTH', 'Ultimo mese'); 
define('MANAGE_ORDER_THREE_MONTHS', 'Ultimi 3 mesi'); 
define('MANAGE_ORDER_YEAR', 'Ultimo anno'); 
define('MANAGE_ORDER_YEAR_AGO', 'Un anno fa'); 
define('MANAGE_ORDER_SEARCH_NO', 'PO/ID/N. ordine'); 
define('MANAGE_ORDER_HEADER', 'La richiesta di annullamento dell\'ordine è stata inviata correttamente.'); 
define('MANAGE_ORDER_EA', 'cd.'); 
define('MANAGE_ORDER_PURCHASE_ORDER', 'Ordine d\'acquisto'); 
define('MANAGE_ORDER_UPLOAD_PO_FILE', 'Carica file PO'); 
define('MANAGE_ORDER_UPLOAD_PURCHASE_ORDER', 'Carica ordine d\'acquisto'); 
define('MANAGE_ORDER_UPLOAD_MESAAGE', 'Il tuo ordine non sarà spedito finché non sarà ricevuto il documento di PO valido entro 5 giorni.'); 
define('MANAGE_ORDER_UPLOAD_FILE_TEXT', 'Scegli file'); 
define('MANAGE_ORDER_UPLOAD_ERROR', 'Tipi di file consentiti: PDF'); 
define('MANAGE_ORDER_UPLOAD_SUBMIT', 'Carica'); 
define('MANAGE_ORDER_UPLOAD_LABEL', 'Caricamento file'); 
define('FS_SALES_CHOOSE', 'Scegli articoli da restituire'); 
define('FS_SALES_ALL', 'Tutti'); 
define('FS_SALES_RETURN', 'Reso'); 
define('FS_SALES_CONTINUE', 'Continua'); 
define('FS_SALES_SELECT', 'Seleziona i tuoi prodotti'); 
define('FS_SALES_CONFIRM', 'Annullare questo RMA?'); 
define('FS_SALES_REASONS', 'CONFERMA RMA'); 
define('FS_SALES_PLEASE', 'Scegli il tipo di servizio'); 
define('FS_SALES_REFUND', 'Reso & rimborso'); 
define('FS_SALES_REPLACE', 'Sostituzione'); 
define('FS_SALES_MAINTENANCE', 'Manutenzione'); 
define('FS_SALES_WHY', 'Perché restituisci questo?'); 
define('FS_SALES_NO', 'Non più richiesto'); 
define('FS_SALES_INCORRECT', 'Prodotto o misura ordinata non corretta'); 
define('FS_SALES_MATCH', 'Non corrispondente alla descrizione'); 
define('FS_SALES_DAMAGED', 'Danneggiati all\'arrivo'); 
define('FS_SALES_RECEIVED', 'Ricevuti gli articoli errati'); 
define('FS_SALES_NOT', 'Non come previsti'); 
define('FS_SALES_NO_REASON', 'Nessun motivo'); 
define('FS_SALES_OTHER', 'Altro'); 
define('FS_SALES_COMMENTS', 'Commenti (obbligatori)'); 
define('FS_SALES_NOTE', 'NOTA'); 
define('FS_SALES_WE', 'Non siamo in grado di offrire eccezioni della politica in risposta ai commenti'); 
define('FS_SALES_WRITE', 'Scrivi il tuo problema.'); 
define('FS_SALES_SUCCESSFUL', 'riuscito'); 
define('RMA_TRACK_STATUS', 'Traccia lo stato'); 
define('RMA_SERVICE_TYPE', 'Tipo di servizio'); 
define('RMA_REASON', 'Motivazioni per l\'assistenza'); 
define('SALES_DETAILS_CONFIRM', 'Conferma ricezione'); 
define('SALES_DETAILS_RECEIPT', 'Conferma ricezione'); 
define('SALES_DETAILS_SUBMIT', 'Invia domanda di RMA'); 
define('SALES_DETAILS_REJECT', 'Rifiutata'); 
define('SALES_DETAILS_APPROVED', 'Approvata'); 
define('SALES_DETAILS_RETURN', 'Reso'); 
define('SALES_DETAILS_RMA', 'RMA ricevuta'); 
define('SALES_DETAILS_NEW', 'Nuova spedizione'); 
define('SALES_DETAILS_REFUND', 'Rimborso'); 
define('SALES_DETAILS_COMPLETE', 'Completo'); 
define('SALES_DETAILS_SEND', 'Come restituire'); 
define('SALES_DETAILS_SEND_MSG', 'Segui il diagramma di flusso per rendere gli articoli'); 
define('SALES_DETAILS_FROM', 'Reso da'); 
define('SALES_DETAILS_EDIT', 'Modifica'); 
define('SALES_DETAILS_DELIVER', 'Spedizione a');
define('SALES_DETAILS_FILL', 'Compila l\'Awb'); 
define('SALES_DETAILS_AWB', 'Compila l\'AWB in modo tale che la logistica rintracci i pacchi restituiti'); 
define('SALES_DETAILS_TRACKING', 'Numero di registrazione'); 
define('SALES_DETAILS_PLEASE', 'Scrivi il numero di registrazione.'); 
define('SALES_DETAILS_PRINT', 'Stampa RMA'); 
define('SALES_DETAILS_PRINT_MSG', 'L\'RMA può aiutarci a distinguere il tuo pacco, così da elaborare la tua richiesta di RMA fino al passo successivo più velocemente. Stampala e incollala al pacco da restituire.'); 
define('SALES_DETAILS_STEP_CONFIRM', 'Conferma indirizzo'); 
define('SALES_DETAILS_STEP_PRINT', 'Stampa modulo RMA'); 
define('SALES_DETAILS_STEP_ATTACH', 'Allega modulo RMA'); 
define('SALES_DETAILS_STEP_CREATE', 'Crea etichetta di spedizione'); 
define('SALES_DETAILS_STEP_SHIP', 'Spedisci'); 
define('SALES_DETAILS_CANCEL', 'Annulla'); 
define('SALES_MSG_APPROVED', 'La tua domanda di RMA è stata approvata'); 
define('SALES_MSG_SUBMIT', 'La tua domanda di RMA è stata inviata'); 
define('SALES_MSG_RETURN', 'Grazie per averci restituito il/i pacco/i'); 
define('SALES_MSG_COMPLETE', 'L\'RMA è stata completata.'); 
define('F_RECEIPT_CONFIRMATION', 'Conferma ricezione'); 
define('F_REFUNDED_PROCESSING', 'Elaborazione rimborso'); 
define('MANAGE_ORDER_ARE', 'Sei sicuro di aver ricevuto tutti gli articoli?'); 
define('MANAGE_ORDER_YES', 'Sì'); 
define('MANAGE_ORDER_NO', 'No'); 
define('FS_THEA_CTUAL_SHIPPING_TIME', 'Il tempo di spedizione effettivo può variare insieme a quello previsto'); 
define('FS_THEA_CTUAL_SHIPPING_TIME', 'È sempre nostro intento offrire il servizio di consegna più rapido con un sistema multi-magazzino. Ulteriori informazioni sulla nostra <a href="'.reset_url('shipping_delivery.html').'">politica sulle spedizioni</a>.');
define('MANAGE_ORDER_SEARCH', 'Cerca tutti gli ordini'); 
define('MANAGE_ORDER_FILTER', 'Filtra ordini'); 
define('MANAGE_ORDER_BACK', 'Indietro'); 
define('MANAGE_ORDER_APPLY', 'Applica'); 
define('MANAGE_ORDER_TYPE', 'Tipo ordine'); 
define('MANAGE_ORDER_TIME_FILTER', 'Filtro temporale'); 
define('FS_PLEASE_W_REVIEW', 'Scrivi i tuoi commenti...'); 
define('ACCOUNT_TOTAL', 'Subtotale'); 
define('ACCOUNT_OF_SHIPPING', 'Costo di spedizione:'); 
define('ACCOUNT_OF_TOTAL', 'Totale:');
define('ACCOUNT_OF_GSP_TOTAL_AU','Totale GTS incluso');
define('FS_ORDERS_DETAILS_TAX_AU','Importo GST totale');
define('MANAGE_ORDER_VIEW_PO', 'Visualizza il mio PO'); 
define('MANAGE_PO_NUMBER', 'PO/N. ID'); 
define('TITLE_RELARED_DES', 'Ogni ricetrasmettitore è collaudato singolarmente su attrezzature corrispondenti, quali Cisco'); 
define('TITLE_RELARED_01', 'Ricetrasmettitore 40GBASE-SR4 QSFP+ 850 nm 150 m MTP/MPO per MMF'); 
define('TITLE_RELARED_02', 'Ricetrasmettitore QSFP28 100GBASE-SR4 850 nm 100 m'); 
define('TITLE_RELARED_03', 'Ricetrasmettitore 40GBASE-LR4 e OTU3 QSFP+ 1310 nm 10 km LC per SMF'); 
define('TITLE_RELARED_04', 'Ricetrasmettitore QSFP28 100GBASE-LR4 1310 nm 10 km'); 
define('TITLE_RELARED_05', 'Marchio compatibile'); 
define('FS_VAT_PLEASE_REQUIRED', 'IVA/IMPOSTA è un campo obbligatorio.'); 
define('FS_VAT_PLEASE', 'Esempio di numero di PARTITA IVA valido: DE123456789'); 
define('FS_VAT_NO', 'Nessuna partita IVA:'); 
define('FS_CHECK_OUT_STATE', 'seleziona gli stati'); 
define('FS_CHECK_OUT_PLEASE', 'Inserisci il paese'); 
define('FS_CHECK_OUT_INVALID', 'Numero di telefono non valido'); 
define('FS_CHECK_OUT_NEED', 'Ho bisogno di aiuto'); 
define('FS_CHECK_OUT_LIVE', 'Chat dal vivo'); 
define('FS_CHECK_OUT_EMAIL', 'Invia un\'e-mail ora'); 
define('FS_CHECK_OUT_TAX', 'Imposta'); 
define('FS_CHECK_OUT_TAX_RU', 'Imposta'); 
define('FS_CHECK_OUT_ORDER', 'Riepilogo ordine'); 
define('FS_CHECK_OUT_REMARKS', 'Aggiungi commenti sull\'ordine');
define('FS_CHECK_OUT_CHANGE', 'Modifica'); 
define('FS_CHECK_OUT_ADD', 'Aggiungi un nuovo indirizzo'); 
define('FS_CHECK_OUT_REVIEW', 'Rivedi articoli e consegna'); 
define('FS_CHECK_OUT_YOUR', 'Il tuo articolo'); 
define('FS_CHECK_OUT_ADDRESS', 'I tuoi indirizzi'); 
define('EMAIL_CHECKOUT_COMMON_VAT_COST', 'Iva/Imposta (22%)');
define('EMAIL_CHECKOUT_COMMON_VAT_COST2', 'Iva/Imposta (22%)');
define('EMAIL_CHECKOUT_COMMON_VAT_COST_FR', 'Iva/Imposta (20%)');
define('FS_CHECK_OUT_INCLUDEING', '(IVA inclusa)'); 
define('FS_CHECK_OUT_EXCLUDING', '(IVA esclusa)'); 
define('FS_CHECK_ADDRESS_TYPE', 'Tipo di indirizzo'); 
define('FS_CHECK_OUT_ADTYPE_TIT', 'Tipo di indirizzo non può essere vuoto'); 
define('FS_CHECK_OUT_COMPANY_TIT', 'Nome della società non può essere vuoto'); 
define('FS_SER_COMMON_EMALl', 'sales@fs.com'); 
define('FS_CHECK_OUT_SELECT', 'Seleziona'); 
define('FS_CHECK_OUT_BUSINESS', 'Tipo aziendale'); 
define('FS_CHECK_OUT_INDIVIDUAL', 'Tipo individuale');
//checkout快递类型
define('FS_CHECKOUT_UPS_PLUS','UPS Express Plus Next Day 9:00');
define('FS_CHECKOUT_UPS','UPS Express Next Day 12:00');
define('FS_CHECK_ADDRESS_TYPE', 'Tipo di indirizzo'); 
define('FS_CHECK_OUT_ADTYPE_TIT', 'Tipo di indirizzo non può essere vuoto'); 
define('FS_CHECK_OUT_COMPANY_TIT', 'Nome della società non può essere vuoto'); 
define('FS_CHECK_OUT_UPDATE_NEW_TITLE', 'Aggiorna il tuo indirizzo di spedizione'); 
define('FS_CHECK_OUT_UPDATE_NEW_TITLE2', 'Informazioni indirizzo di fatturazione'); 
define('FS_DHLG', 'DHL Express Domestic'); 
define('FS_DHLE', 'DHL Economy'); 
define('FS_DHLEE', 'DHL Express Worldwide'); 
define('FS_WAREHOSE_CA_TIP', 'Spedizione gratuita sugli ordini di oltre $ 79 spediti dal magazzino statunitense'); 
define('FS_WAREHOSE_EU_TIP', 'Consegna gratuita sugli ordini di oltre € 79 spediti dal magazzino europeo (Germania)'); 
define('FS_WAREHOSE_OTHER_TIP', 'Il sistema multi-magazzino di FS.COM garantisce la consegna più rapida a'); 
define('FS_HEADER_FREE_SHIPPING_US_TIP', 'Spedizione gratuita per ordini superiori a $ 79.'); 
define('FS_FOOTER_FREE_SHIPPING_US_TIP', 'Spedizione gratuita'); 
define('FS_HEADER_FREE_SHIPPING_DE_TIP', 'Consegna gratuita per ordini di articoli idonei oltre EUR 79 €'); 
define('FS_FOOTER_FREE_SHIPPING_DE_TIP', 'Consegna gratuita'); 
define('FS_HEADER_FREE_SHIPPING_AU_TIP', 'Consegna gratuita per ordini di articoli idonei oltre A$ 99 spediti dal magazzino AU'); 
define('FS_FOOTER_FREE_SHIPPING_AU_TIP', 'Consegna gratuita'); 
define('FS_HEADER_FREE_SHIPPING_OTHER_TIP', 'Spedizione lo stesso giorno su un\'ampia selezione di articoli a magazzino'); 
define('FS_FOOTER_FREE_SHIPPING_OTHER_TIP', 'Spedizione lo stesso giorno');
define('FS_M_FREE_SHIPPING_DE_TIP','Spedizione gratuita per ordini superiori a $MONEY');
define('FS_M_FREE_SHIPPING_AU_TIP','Spedizione gratuita per ordini superiori a A$99');
define('FS_M_FREE_SHIPPING_FAST_SHIPPING','Spedizione veloce verso');
define('FS_M_SHIPPING_US_TIP','Spedizione gratuita per ordini superiori a US$ 79');
define('PROINFO_CUSTOM_WAVE', 'Scrivi un\'altra lunghezza d\'onda secondo le tue esigenze.'); 
define('PROINFO_CUSTOM_GRID', 'Scrivi un altro canale di griglia secondo le tue esigenze.'); 
define('PROINFO_CUSTOM_RATIO', 'Scrivi un altro rapporto di accoppiamento secondo le tue esigenze.'); 
define('GET_A_QUOTE', 'Ottieni un preventivo'); 
define('FS_STOCK_LIST_OTHER_ID', 'ID'); 
define('FS_STOCK_LIST_CENTER', 'Lunghezza d\'onda centrale (nm'); 
define('FS_STOCK_LIST_CHANNEL', 'Canale'); 
define('FS_STOCK_LIST_CWDM', 'CWDM SFP/SFP+'); 
define('FS_STOCK_LIST_DWDM', '10G DWDM SFP+ 80km'); 
define('FS_DOWNLOAD', 'Download');
define('FS_DOWNLOADS', 'Download');
define('FS_STOCK_LIST', 'Elenco giacenze'); 
define('FS_STOCK_LIST_RECOM', 'Prodotti corrispondenti'); 
define('FS_STOCK_LIST_ADD_TO_CART', 'Aggiungi al carrello'); 
define('FS_STOCK_LIST_PIC', 'Immagini'); 
define('FS_STOCK_LIST_ID', 'N. ID'); 
define('FS_STOCK_LIST_DESC', 'Descrizione'); 
define('FS_STOCK_LIST_PRICE', 'Prezzo'); 
define('FS_STOCK_LIST_STOCK', 'A magazzino'); 
define('FS_PRODUCT_INSTALLATION', 'Installazione:');
define('FS_STOCK_OPTION','Opzione');

define('FS_PRODUCT_INSTALLATION_TEXT','Fit in <a href="'.zen_href_link('product_info','products_id=30408','SSL').'" style="color: #0070BC;">FMU-1UFMX-N</a> chassis che può essere montato a rack');
define('FS_PRODUCT_INSTALLATION_TEXT2','Fit in ');
define('FS_PRODUCT_INSTALLATION_TEXT3','FMT04-CH1U');
define('FS_PRODUCT_INSTALLATION_TEXT4',' chassis che può essere montato a rack');
define('FS_PRODUCT_INSTALLATION_TEXT5','LGX cassette fits in <a href="'.zen_href_link('product_info','products_id=51608','SSL').'" style="color: #0070BC;">FLG-1UFMX-N</a> chassis che può essere montato a rack');
define('FS_PRODUCT_INFO_STEP', 'Fase');

define('FS_PRODUCT_CUSTOMIZATION', 'Nota:'); 
define('FS_PRODUCT_CUSTOMIZATION_TEXT', 'Modulo plug-in FMU inseribile in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT1', 'FMT-CH'); 
define('FS_PRODUCT_CUSTOMIZATION_TEXT2', 'Modulo innestabile inseribile in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT3', 'Modulo Plug-in FUD inseribile in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT4', 'FMU-1UFMX'); 
define('FS_PRODUCT_CUSTOMIZATION_TEXT5', ' chassis che può essere montato a rack');
define('FS_PRODUCT_CUSTOMIZATION_TEXT6', 'FUD-1UFMX-N'); 
define('FS_PRODUCT_CUSTOMIZATION_TEXT7', 'Tipo Plug-in inseribile in ');
define('FS_PRODUCT_CUSTOMIZATION_TEXT8', 'FS-2U-RC001'); 
define('FS_PRODUCT_ITEM', 'Articolo n.:'); 
define('FS_COUNTRY_SEARCH', 'Cerca il tuo paese/regione'); 
define('FS_EMAIL_CART', 'La tua lista del carrello ti aspetta.'); 
define('FS_EMAIL_PAST', 'Dopo di te ha fatto shopping su'); 
define('FS_EMAIL_FS', 'FS.COM'); 
define('FS_EMAIL_SAVED', 'e ha salvato la lista degli articoli per un tuo utilizzo successivo.  Utilizza i link sottostanti per trovare i dettagli su tutti questi articoli e continuare lo shopping'); 
define('FS_EMAIL_FSCOM', 'https://www.fs.com/de-en'); 
define('FS_EMAIL_MESSAGE', 'Il tuo messaggio:'); 
define('FS_EMAIL_LIST', 'https://www.fs.com/index.php?main_page=save_shopping_list'); 
define('FS_EMAIL_SIN', 'Cordialmente'); 
define('FS_EMAIL_TEAM', 'Team Servizio clienti'); 
define('FS_EMAIL_SENT', 'Questa e-mail è stata inviata da te mediante'); 
define('FS_EMAIL_SHARE', 'il servizio Condividi con un amico. Come risultato della ricezione di questo messaggio'); 
define('FS_EMAIL_WERDEN', 'non riceverai alcun messaggio indesiderato da'); 
define('FS_EMAIL_OUR', ''); 
define('FS_EMAIL_POLICY', 'Informativa sulla privacy'); 
define('EMAIL_CUSTOMER_SHOPPING_LIST', 'https://www.fs.com/index.php?main_page=share_shopping_list'); 
define('FS_EMAIL_SENT_1', 'Questa e-mail ti è stata inviata dal'); 
define('FS_EMAIL_CART_1', 'tuo amico'); 
define('FS_EMAIL_CARTS_1', 'ha condiviso una lista del carrello con te!'); 
define('FS_EMAIL_PAST_1', 'ha pensato che questi articoli di FS.COM potrebbero interessarti. Ecco la lista per te. Utilizza i link sottostanti per trovare i dettagli su tutti questi articoli e continuare lo shopping'); 
define('FS_EMAIL_MESSAGE_1', 'Messaggio:'); 
define('FS_EMAIL_THIS_1', 'Questa e-mail ti è stata inviata da un amico'); 
define('FS_EMAIL_USING_1', 'mediante');
define('FS_EMAIL_URL_1',HTTPS_SERVER.reset_url('policies/privacy_policy.html'));
define('FS_EMAIL_PRODUCT_SHARE1', 'Il tuo amico condivide questo articolo solo per te tramite'); 
define('FS_EMAIL_PRODUCT_SHARE2', 'FS.COM.'); 
define('FS_EMAIL_PRODUCT_SHARE3', 'Ho pensato che questa pagina di FS.COM potrebbe'); 
define('FS_EMAIL_PRODUCT_SHARE4', 'Ulteriori informazioni'); 
define('FS_EMAIL_PRODUCT_SHARE5', 'Cordialmente'); 
define('FS_EMAIL_PRODUCT_SHARE6', 'FS.COM'); 
define('FS_EMAIL_PRODUCT_SHARE7', 'Team Servizio clienti'); 
define('FS_EMAIL_PRODUCT_SHARE8', 'Questa e-mail ti è stata inviata dal'); 
define('FS_EMAIL_PRODUCT_SHARE9', 'servizio Condividi con un amico. Come risultato della ricezione di questo messaggio'); 
define('FS_EMAIL_PRODUCT_SHARE10', 'https://www.fs.com/de-en/'); 
define('FS_EMAIL_SHARE_TITLE_ONE', 'interessarti - Il tuo amico'); 
define('FS_EMAIL_SHARE_TITLE_TWO', 'vuole farti vedere quest\'articolo.'); 
define('FS_EMAIL_PRODUCT_SHARE11', 'Messaggio da'); 
define('FS_PRO_SHARE_EMAIL', 'Il tuo messaggio è stato inviato.'); 
define('FS_EMAIL_PRODUCT_SHARE13', ''); 
define('FS_EMAIL_POLICY_2', ''); 
define('FS_EMAIL_PRODUCT_USING', 'mediante'); 
define('FS_EMAIL_TO_US_TITLE', 'FS.COM - E-mail di risposta automatica del servizio clienti'); 
define('FS_EMAIL_TO_US_CONTACT', 'Grazie per averci contattato'); 
define('FS_EMAIL_TO_US_DEAR', 'Gentile ');
define('FS_EMAIL_TO_US_SYSTEM', 'Questa è un\'e-mail di sistema che ti conferma che abbiamo ricevuto la tua richiesta.'); 
define('FS_EMAIL_TO_US_TEAM', 'Il team di vendita esaminerà i tuoi problemi e ti risponderà entro 12 ore.'); 
define('FS_EMAIL_TO_US_REQUIRE', 'Se ti occorre una risposta immediata'); 
define('FS_EMAIL_TO_US_FHONE', '+1 877 205 5306'); 
define('FS_EMAIL_TO_US_OR', '(USA o'); 
define('FS_EMAIL_TO_US_TEL', 'tel:+49 (0 89 414176412'); 
define('FS_EMAIL_TO_US_PHONES', '+49 (0 89 414176412'); 
define('FS_EMAIL_TO_US_YOU', '(Germania). Puoi anche fare una'); 
define('FS_EMAIL_TO_US_LIVE', 'chat dal vivo'); 
define('FS_EMAIL_TO_US_GET', 'per ottenere una risposta rapida.'); 
define('FS_EMAIL_TO_US_SALES', 'Il team di vendita'); 
define('FS_EMAIL_TO_US_URL', 'https://www.fs.com/live_chat_service.html');
/**
 *评论邮件
 */
define('EMAIL_MESSAGE_TITLE_REVIEWS',' Feedback ricevuto');
define('FS_PRODUCT_REVIEW_SUBJECT_TITLE','FS- Grazie per il tuo feedback.');
define('FS_EMAIL_REVIEWS_WELL_CONTENT','Siamo molto grati per le tue gentili parole e lieti di sapere che hai avuto un\'esperienza così positiva interagendo con il nostro team.');
define('FS_EMAIL_REVIEWS_WELL_FEEDBACK','Un feedback come questo ci aiuta a migliorare costantemente le esperienze dei nostri clienti capendo quali sono i nostri pregi ma allo stesso tempo capendo cosa possiamo migliorare.');
define('FS_EMAIL_REVIEWS_BAD_CONTENT','Ci dispiace che la tua esperienza non abbia corrisposto alle tue aspettative. Non e\' da noi e faremo meglio.');
define('FS_EMAIL_REVIEWS_BAD_FEEDBACK','Ti assicuriamo che il tuo gestore d\'account ti contatterà entro 48 ore. Speriamo sinceramente di venirti incontro e risolvere eventuali problemi il più rapidamente possibile.');
define('FS_EMAIL_REVIEWS_THANKS','Grazie');
define('FS_EMAIL_REVIEWS_TEAM','Il team di FS');
define('FS_EMAIL_REVIEWS_WELL_HEADER','Grazie per la tua recensione e continueremo ad offrire i migliori prodotti come al solito.');
define('FS_EMAIL_REVIEWS_BAD_HEADER','Grazie per la tua recensione e ti aiuteremo a risolvere il problema al più presto.');

/*
 * 客户在My account里问销售问题-发给销售和客户
 */
define('FS_EMAIL_MY_ACCOUNT_TITLE', 'FS.COM - Aggiornamento feedback domande'); 
define('FS_EMAIL_MY_ACCOUNT_YOUR', 'La tua domanda è in fase di elaborazione.'); 
define('FS_EMAIL_MY_ACCOUNT_FOR', 'Grazie per aver inviato la tua domanda. Il tuo rappresentante di vendita esaminerà le tue domande e ti risponderà entro 12 ore.'); 
define('FS_EMAIL_MY_ACCOUNT_TIT', 'Titolo'); 
define('FS_EMAIL_MY_ACCOUNT_CON', 'Contenuto'); 
define('FS_EMAIL_MY_ACCOUNT_IF', 'Se ti occorre una risposta immediata'); 
define('FS_EMAIL_MY_ACCOUNT_PHONE', '+1 (877 205 5306'); 
define('FS_EMAIL_MY_ACCOUNT_OR', '(USA o'); 
define('FS_EMAIL_MY_ACCOUNT_TEL', 'tel:+49 (0 89 414176412'); 
define('FS_EMAIL_MY_ACCOUNT_PHONES', '+49 (0 89 414176412'); 
define('FS_EMAIL_MY_ACCOUNT_MAY', '. Puoi anche fare una'); 
define('FS_EMAIL_MY_ACCOUNT_URL', 'http://www.fs.com/it/live_chat_service.html');
define('FS_EMAIL_MY_ACCOUNT_LIVE', 'chat dal vivo'); 
define('FS_EMAIL_MY_ACCOUNT_GET', 'per ottenere una risposta rapida.'); 
define('FS_EMAIL_MY_PO_UP_TITLE', 'FS.COM - N. PO confermato per ordine di acquisto n.'); 
define('FS_EMAIL_MY_PO_UP_TITLES', 'Conferma dell\'ordine di acquisto n.'); 
define('FS_EMAIL_MY_PO_UP_PO', 'Il tuo n. PO'); 
define('FS_EMAIL_MY_PO_UP_HAS', 'è stato caricato correttamente.'); 
define('FS_EMAIL_MY_PO_UP_THANK', 'Grazie per i documento del PO'); 
define('FS_EMAIL_MY_PO_UP_ORDER', 'N. ordine:'); 
define('FS_EMAIL_MY_PO_UP_NO', 'N. PO:'); 
define('FS_EMAIL_MY_PO_UP_WILL', 'Il tuo ordine sarà elaborato presto'); 
define('FS_EMAIL_MY_PO_UP_CONTACT', 'contattaci'); 
define('FS_EMAIL_MY_PO_UP_SIN', 'Cordialmente'); 
define('FS_EMAIL_MY_PO_UP_CUS', 'Team Servizio clienti'); 
define('FS_EMAIL_MY_PO_UP_MY', 'I miei ordini'); 
define('FS_EMAIL_MY_PO_UP_NOW', '\' ora.'); 
define('FS_EMAIL_MY_PO_UP_URL', 'https://www.fs.com/it/manage_orders.html');
define('FS_EMAIL_MY_PO_UP_URLS', 'http://www.fs.com/it/contact_us.html');
define('FS_EMAIL_MY_PO_UP_RUR', 'FS.COM - Conferma dell\'ordine di acquisto per l\'ordine n.'); 
define('FS_EMAIL_MY_PO_UP_FOR', 'Grazie per i tuoi acquisiti con'); 
define('FS_EMAIL_MY_PO_UP_YUOR', 'Grazie per il tuo ordine di acquisto! Ecco i dettagli del tuo ordine. Ora è in attesa della conferma del PO.'); 
define('FS_EMAIL_MY_PO_UP_NOR', 'N. ordine:'); 
define('FS_EMAIL_MY_PO_UP_GO', 'Accedi alla pagina '); 
define('FS_EMAIL_MY_PO_UP_PAGE', '\' per caricare il file del PO se non l\'hai già fatto. Non saremo in grado di elaborare il tuo ordine finché il PO non sarà stato confermato.'); 
define('FS_EMAIL_MY_PO_UP_IF', 'Per qualsiasi ulteriore domanda riguardante il tuo ordine'); 
define('FS_WRITE_OTHER_DEVICES', 'es.: Cisco N9K-C9396PX'); 
define('HPE_LIMIT', 'Scegli la compatibilità "VAL_XXX" per il tuo ordine a causa del materiale speciale, quindi scrivi i numeri di modello.'); 
define('model_number_empty', 'Inserisci il numero di modello del tuo dispositivo.'); 
define('FIBER_CHECK_TWO', 'Servizio UPS 2nd Day®'); 
define('FIBER_CHECK_STAND', 'UPS Ground®'); 
define('FIBER_CHECK_ONE', 'Servizio UPS Next Day®'); 
define('FIBER_FEDEX_CHECK_OVER', 'Servizio FedEx Overnight®'); 
define('FIBER_FEDEX_CHECK_TWO', 'Servizio FedEx 2Day®'); 
define('FIBER_FEDEX_CHECK_GROUND', 'FedEx Ground®'); 
define('FIBER_CHECK_USE', 'Utilizza il tuo account di consegna');
define('FIBER_CHECK_FREE', 'Gratis'); 
define('FIBER_CHECK_FREE_SHIPPING', 'Consegna gratuita'); 
define('PROINFO_CUSTOM_LENGTH', 'Osserva che quando la lunghezza totale del cavo non è superiore a 1 m'); 
define('FS_WRITE_OTHER_DEVICES', 'scrivi i tuoi dispositivi'); 
define('FS_PRODUCTS_CUSTOMIZED', 'Personalizzati'); 
define('FS_COMMON_LEVEL_WAS', 'Era'); 
define('FS_COMMON_REORDER_CLOSE', 'Spiacente'); 
define('FS_COMMON_REORDER_CUSTOM', 'Blow sono prodotti personalizzati'); 
define('FS_COMMON_REORDER_SKIP', 'Ignora e continua'); 
define('FS_POPUP_TIT_ALERT', 'È richiesta la firma per la consegna. Non effettuiamo spedizioni a caselle postali (PO Box).'); 
define('FS_POPUP_TIT_ALERT_NOT_PO', 'È richiesta la firma per la consegna.'); 
define('FS_POPUP_TIT_ALERT2', 'Non effettuiamo spedizioni a caselle postali (PO Box)');
define('HPE_LIMIT2', 'Non è disponibile la compatibilità per "VAL_XXX" per il tuo ordine a causa del suo materiale speciale.');

//2017-12-15  ery  add  前台相关打印发票页面的公司地址
define('FS_COMMON_WAREHOUSE_CN','FS.COM Limited<br> 
			NO.6,Li Miao Road<br> 
			Canglong  Island, Jiangxia Distric<br> 
			Wuhan, 430205, China <br>
			Tel: +86 (027) 87639823');
define('FS_COMMON_WAREHOUSE_CN_NEW','FS.COM LIMITED<br> 
			Unit 1, Warehouse No. 7 <br> 
			South China International Logistics Center <br> 
			Longhua District <br>
			Shenzhen, 518109 <br> China');
define('FS_COMMON_WAREHOUSE_EU','FS.COM GmbH<br> 
			NOVA Gewerbepark, Building 7,<br>
			Am Gfild 7<br>
			85375, Neufahrn bei Munich<br>
			Germania<br>
			Tel: +49 (0) 8165 80 90 517');
define('FS_COMMON_WAREHOUSE_US','FS.COM INC <br>
			380 CENTERPOINT BLVD<br>
			NEW CASTLE, DE 19720<br>
			Stati Uniti <br>
			Tel: +1 (888) 468 7419');
define('FS_COMMON_WAREHOUSE_US_EAST','FS.COM INC<br>
					380 Centerpoint Blvd<br>
					New Castle, DE 19720,<br>
					United States<br>
					Tel: +1 (888) 468 7419');
// 澳洲仓 （澳大利亚）
define('FS_COMMON_WAREHOUSE_AU','FS.COM PTY LTD<br>
				57-59 Edison Road<br>
				Dandenong South<br>
				VIC 3175<br>
				Australia<br>
				Tel: +61 3 9693 3488<br>
				ABN: 71 620 545 502');
define('FS_COMMON_WAREHOUSE_SG','FS TECH PTE. LTD<br>
				30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: (65) 6443 7951<br>
				GST Reg No.: 201818919D');
// 新加坡仓
define('FS_COMMON_WAREHOUSE_DELIVER_TO_SG','ATTN: FS Tech Pte Ltd.<br>
				Indirizzo: 30A Kallang Place #11-10/11/12<br>
				Singapore 339213<br>
				Singapore<br>
				Tel: +(65) 6443 7951');
define('QTY_SHOW_ZERO', 'pz. in'); 
define('QTY_SHOW_MORE', 'pezzi in'); 
define('QTY_SHOW_NEW', 'pezzi in'); 
define('QTY_SHOW_ZERO_STOCK', 'pz.'); 
define('QTY_SHOW_MORE_STOCK', 'pezzi'); 
define('QTY_SHOW_ZERO_STOCK_1', ' In stock');
define('QTY_SHOW_MORE_STOCK_2', ' In stock');
define('QTY_SHOW_AVAILABLE', 'Disponibile'); 
define('QTY_SHOW_AVAILABLE_NEW_INFO', 'In transito'); 
define('QTY_SHOW_AVAILABLE_TAG_NEW_INFO', 'Necessita transito');
define('QTY_SHOW_IN_CN_STOCK_1','In Stock');
define("FS_WAREHOUSE_AREA_PR",'Spedizione da FS Stati Uniti');
define("FS_WAREHOUSE_AREA_1","Spedizione dal magazzino Asia");
define("FS_WAREHOUSE_AREA_2","Spedizione dal magazzino U.S.");
define("FS_WAREHOUSE_AREA_3","Spedizione dal magazzino DE (Germania) ");
define('FS_WAREHOUSE_AREA_4', '- Disponibile per la spedizione immediata'); 
define('FS_WAREHOUSE_AREA_5', '- Disponibile per la spedizione prevista il '); 
define('FS_WAREHOUSE_AREA_6', 'Gli articoli possono essere consegnati entro '); 
define('FS_WAREHOUSE_AREA_7', 'pacchetti separati. '); 
define('FS_WAREHOUSE_AREA_8', 'Articolo(i)');
define('FS_WAREHOUSE_AREA_9', 'Prezzo articolo'); 
define('FS_WAREHOUSE_AREA_10', 'Qtà'); 
define('FS_WAREHOUSE_AREA_11', 'Prezzo'); 
define('FS_WAREHOUSE_AREA_12', 'Accedi alla pagina ');
define('FS_WAREHOUSE_AREA_13', 'I miei ordini'); 
define('FS_WAREHOUSE_AREA_14', ' per caricare il file del PO se non lo hai già fatto. Non saremo in grado di elaborare il tuo ordine finché il PO non sarà stato confermato.');
define('FS_WAREHOUSE_AREA_15', 'Grazie per lo shopping in'); 
define('FS_WAREHOUSE_AREA_16', '! Di seguito è riportato un riepilogo del tuo ultimo ordine aperto. Solo un ultimo passo per concludere il pagamento'); 
define('FS_WAREHOUSE_AREA_17', 'Grazie per aver ordinato da FS.COM! Abbiamo ricevuto il tuo ordine e siamo in attesa di elaborarlo. '); 
define('FS_WAREHOUSE_AREA_18', 'Grazie per i tuoi acquisiti su FS.COM. Il tuo ordine n.'); 
define('FS_WAREHOUSE_AREA_19', ' effettuato il '); 
define('FS_WAREHOUSE_AREA_20', ' è stato ricevuto. Tuttavia non è ancora stato pagato. Se necessiti comunque degli articoli'); 
define('FS_WAREHOUSE_AREA_21', 'Se sussistono eventuali problemi o domande relative al pagamento paypal'); 
define('FS_WAREHOUSE_AREA_22', 'Non ancora impostato'); 
define('FS_WAREHOUSE_AREA_23', 'Ordine ricevuto'); 
define('FS_WAREHOUSE_AREA_24', 'è stato ricevuto. Tuttavia non è ancora stato pagato.'); 
define('FS_WAREHOUSE_AREA_25', 'Se sussistono eventuali problemi o domande relative al pagamento con carta di credito/debito'); 
define('FS_WAREHOUSE_AREA_26', 'Ordine ricevuto'); 
define('FS_WAREHOUSE_AREA_27', 'Se sussistono eventuali problemi o domande relative al'); 
define('FS_WAREHOUSE_AREA_28', 'non esitare a contattarci'); 
define('FS_WAREHOUSE_AREA_29', 'N. ordine:'); 
define('FS_WAREHOUSE_AREA_30', 'Spedizione tramite:'); 
define('FS_WAREHOUSE_AREA_31', 'ordine su FS.COM...'); 
define('FS_WAREHOUSE_AREA_32', 'Grazie per il tuo ordine di acquisto! Ecco i dettagli del tuo ordine. Ora è in attesa della conferma del PO.'); 
define('FS_WAREHOUSE_AREA_33', 'Grazie per il tuo ordine di acquisto! Ecco i dettagli del tuo ordine.</br>Nota: L\'indirizzo di spedizione non corrisponde con quelli indicati sul modulo di domanda di credito.');
define("FS_WAREHOUSE_AREA_34","Grazie per il tuo ordine d'acquisto! Eccone i dettagli.</br>Nota bene: L'indirizzo di spedizione non corrisponde agli indirizzi nel modulo di richiesta di credito e l'importo dell'ordine supera il limite di credito su FS.COM. Per elaborare rapidamente quest'ordine,si prega di pagare gli ordini precedenti per rigenerare il limite di credito, oppure è possibile andare su \"Il mio account\" e fare clic su \"Ordine di acquisto\" per richiedere l'aumento del limite di credito, ti invieremo via e-mail il risultato dopo una revisione.");
define("FS_WAREHOUSE_AREA_35","Grazie per il tuo ordine d'acquisto! Eccone i dettagli.</br>Nota bene: L'importo dell'ordine supera il limite di credito su FS.COM. Per elaborare rapidamente quest'ordine, si prega di pagare gli ordini precedenti per rigenerare il limite di credito, oppure è possibile andare
 su \"Il mio account\" e fare clic su \"Ordine di acquisto\" per richiedere l'aumento del limite di credito, ti invieremo via e-mail il risultato dopo una revisione.");
/*结算页交期气泡提示语*/
define("FS_WAREHOUSE_AREA_TIME_36","La spedizione è stata ritardata a causa di festività nazionali negli Stati Uniti.");
define("FS_WAREHOUSE_AREA_TIME_37","La spedizione è stata ritardata a causa di festività nazionali in Australia.");
define("FS_WAREHOUSE_AREA_TIME_38","La spedizione è stata ritardata a causa di festività nazionali in Germania.");
define("FS_WAREHOUSE_AREA_TIME_39","La spedizione è stata ritardata a causa di festività nazionali in Singapore.");
define("FS_WAREHOUSE_AREA_TIME_42","La spedizione è stata ritardata a causa di festività nazionali in Cina.");
define("FS_WAREHOUSE_AREA_TIME_40","La spedizione è stata ritardata a causa del fine settimana.");
define("FS_WAREHOUSE_AREA_TIME_41",'<div class="track_orders_wenhao shipping_notice m_track_orders_wenhao m-track-alert" style=""><i class="iconfont icon">&#xf071;</i><p></p><div class="new_m_bg1"></div><div class="new_m_bg_wap"><div class="question_text_01 leftjt"><div class="arrow"></div><div class="popover-content">$TIME_TIPS</div><div class="new__mdiv_block"><span class="new_m_icon_Close">Chiudersi</span></div></div></div></div>');
define("FS_WAREHOUSE_AREA_TIME_43","Ritira al magazzino U.S. all'orario desideri");
define("FS_WAREHOUSE_AREA_TIME_44","Ritira al magazzino DE (Germania) all'orario desideri");
define("FS_WAREHOUSE_AREA_TIME_45","Ritira al magazzino AU all'orario desideri");
define("FS_WAREHOUSE_AREA_TIME_46","Ritira al magazzino Asia all'orario desideri");
define("FS_WAREHOUSE_AREA_TIME_47","Ritira al magazzino SG all'orario desideri");
define("FS_WAREHOUSE_AREA_SHIP_CN"," dal magazzino Asia");
define("FS_WAREHOUSE_AREA_SHIP_US","dal magazzino U.S.");
define("FS_WAREHOUSE_AREA_SHIP_AU","dal magazzino AU");
define("FS_WAREHOUSE_AREA_SHIP_DE"," dal magazzino DE (Germania)");
define("FS_WAREHOUSE_AREA_SHIP_SG"," dal magazzino SG");
define("FS_PICK_UP_WAREHOUSE", "Ritira al magazzino");
define('FS_LENGTH_CUSTOM_FEET', 'Piedi O');
define('FS_LENGTH_CUSTOM_METER', 'Metri'); 
define('CHECKOUT_EIDT_TIT_FS', '*Modifica e aggiorna il tuo indirizzo'); 
define('CHECKOUT_EIDT_TIT_FS1', 'Modifica il tuo indirizzo di spedizione'); 
define('CHECKOUT_EIDT_TIT_FS2', 'Modifica il tuo indirizzo di fatturazione'); 
define('CHECKOUT_EIDT_TIT_FS3', '*Modifica e aggiorna il tuo indirizzo di fatturazione'); 
define('REGITS_FROM_GUEST_EMAIL_ERROR1', 'L\'indirizzo e-mail è obbligatorio.'); 
define('REGITS_FROM_GUEST_EMAIL_ERROR2', 'Inserisci un indirizzo e-mail valido. (es.: qualcuno@gmail.com)'); 
define('REGITS_FROM_GUEST_EMAIL_ERROR3', 'Inserisci un indirizzo e-mail valido.'); 
define('REGITS_FROM_GUEST_PASSWORD_ERROR1', '6 caratteri minimo; almeno una lettera e un numero'); 
define('REGITS_FROM_GUEST_PASSWORD_ERROR2', 'La password deve corrispondere.'); 
define('REGITS_FROM_GUEST_ASK', 'Desideri creare un conto adesso?'); 
define('REGITS_FROM_GUEST_CAN', 'Solo un ulteriore passo per ottenere un servizio migliore. Con un account FS'); 
define('REGITS_FROM_GUEST_EASY', 'Tracciamento facile tramite il tuo storico ordini'); 
define('REGITS_FROM_GUEST_FASTER', 'Pagamento più veloce con la rubrica');
define("REGITS_FROM_GUEST_NO","No, grazie.");
define("REGITS_FROM_GUEST_YES","Sì, vorrei creare un account.");
define('REGITS_FROM_GUEST_USE', 'Utilizza la mia e-mail di pagamento'); 
define('REGITS_FROM_GUEST_OR', 'O'); 
define('REGITS_FROM_GUEST_HISTORY', 'Se l\'indirizzo di pagamento e quello dell\'e-mail registrata sono diversi'); 
define('REGITS_FROM_GUEST_PASWORD', 'Password'); 
define('REGITS_FROM_GUEST_CPASWORD', 'Conferma password'); 
define('REGITS_FROM_GUEST_NOTE', 'Nota: Il tuo numero di telefono è utilizzato esclusivamente per contattarti in merito alla consegna'); 
define('REGITS_FROM_GUEST_EXSIT1', 'L\'indirizzo e-mail esiste nel nostro sistema'); 
define('REGITS_FROM_GUEST_EXSIT2', 'Accedi »'); 
define('REGIST_NUM_LENGTH', 'Minimo 6 caratteri'); 
define('REGIST_NUM_LEAST', '6 caratteri minimo; almeno una lettera e un numero.'); 
define('SALES_DETAILS_PRINT_LABEL', 'Stampa l\'etichetta di spedizione prepagata'); 
define('SALES_DETAILS_PSL', 'Stampa l\'etichetta di spedizione'); 
define('FS_SALES_DETAILS_COMMENT', 'Commenti (obbligatori)'); 
define('FS_SALES_DETAILS_REVIEW', 'Revisione reso/sostituzione'); 
define('FS_SALES_DETAILS_NO', 'N. RMA'); 
define('FS_SALES_DETAILS_STATUS', 'Stato RMA'); 
define('FS_SALES_DETAILS_AMOUNT', 'Quantità'); 
define('FS_SALES_DETAILS_RPI', 'Informazioni di pagamento reso'); 
define('FS_SALES_DETAILS_RA', 'Importo rimborso'); 
define('FS_SALES_DETAILS_RM', 'Metodo di rimborso'); 
define('FS_SALES_DETAILS_SAME', 'Stesso metodo di pagamento'); 
define('FS_SALES_DETAILS_NOTE', 'Nota: L\'importo di rimborso finale sarà indicato nell\'e-mail di conferma del reso.'); 
define('FS_SALES_DETAILS_PROCESS', 'Processo RMA'); 
define('FS_SALES_DETAILS_AWB', 'Aggiorna AWB'); 
define('FS_SALES_DETAILS_ADDRESS', 'Conferma indirizzo'); 
define('FS_SALES_INFO_REQUEST', 'Richiesta RMA'); 
define('FS_SALES_INFO_A', 'Una richiesta di reso non garantisce un numero di autorizzazione'); 
define('FS_SALES_INFO_PLEASE', 'Consulta i Termini & condizioni di vendita per la nostra Politica sui resi. Sarai avvisato entro 24 ore se la tua richiesta di reso è stata approvata o rifiutata.'); 
define('FS_SALES_INFO_YOU', 'Puoi inviare fino a'); 
define('FS_SALES_INFO_WHAT', 'Qual è il motivo del reso?'); 
define('FS_SALES_INFO_QI', 'Problemi di qualità'); 
define('FS_SALES_INFO_SI', 'Problemi di servizio'); 
define('FS_SALES_INFO_OI', 'Altri problemi'); 
define('FS_SALES_INFO_WE', 'Non siamo in grado di offrire eccezioni della politica in risposta ai commenti'); 
define('FS_SALES_INFO_ATTA', 'Allegato'); 
define('FS_SALES_INFO_ALLOW', 'Consente file PDF');
define('FS_SALES_INFO_ADD', 'Aggiungi foto'); 
define('FS_SALES_INFO_VERIFY', 'Verifica indirizzo RMA'); 
define('FS_SALES_INFO_KIND', 'Promemoria'); 
define('FS_SALES_INFO_OUR', 'Il nostro centro post-vendita potrebbe farti una telefonata'); 
define('FS_SALES_INFO_I', 'Accetto la'); 
define('FS_SALES_INFO_RP', 'Politica sui resi'); 
define('FS_SALES_INFO_PLEASE_AGREE', 'Ti preghiamo di accettare la nostra Politica sui resi per continuare.'); 
define('FS_SALES_INFO_PLEASE_WRITE', 'Scrivi il problema.'); 
define('FS_SALES_INFO_ITEMS', 'Gli articoli non funzionano correttamente'); 
define('FS_SALES_INFO_MIS', 'Dimensione non corretta'); 
define('FS_SALES_INFO_DID', 'Non corrisponde alla descrizione'); 
define('FS_SALES_INFO_RE', 'Ricevuti gli articoli errati'); 
define('FS_SALES_INFO_UN', 'Spedizione non possibile per quando è necessaria'); 
define('FS_SALES_INFO_DA', 'Danneggiati all\'arrivo'); 
define('FS_SALES_INFO_NO', 'Non più richiesti'); 
define('FS_SALES_INFO_NOT', 'Non come previsti'); 
define('FS_SALES_INFO_WRONG', 'Ricevuti gli articoli errati'); 
define('FS_MANAGE_ORDERS_PO', 'N. PO'); 
define('FS_MANAGE_ORDERS_RE', 'Rivisto'); 
define('FS_MANAGE_ORDERS_TN', 'Numero di registrazione'); 
define('FS_MANAGE_ORDERS_MORE', 'Altro'); 
define('FS_MANAGE_ORDERS_RECORDA', 'record per pagina'); 
define('FS_MANAGE_ORDERS_PURCHASE', 'Il numero di ordine di acquisto non può essere vuoto'); 
define('FS_MANAGE_ORDERS_OC', 'Commenti sull\'ordine'); 
define('FS_MANAGE_ORDERS_FILE', 'Carica il file del PO.'); 
define('FS_SALES_DETAILS_RAE', 'I resi sono facili'); 
define('FS_SALES_DETAILS_NO_LABEL', 'Segui il diagramma di flusso per rendere gli articoli. Ti forniremo l\'indirizzo di spedizione del reso'); 
define('FS_SALES_DETAILS_LABEL', 'Segui il diagramma di flusso per rendere gli articoli. Ti forniremo un\'etichetta di spedizione prepagata per il pacco del reso; porta il pacco presso una sede di spedizione UPS autorizzata'); 
define('FS_SALES_DETAILS_CR', 'Annulla RMA'); 
define('FS_PRODUCT_INFO_ATTR_PLEASE', 'Seleziona un\'opzione per ciascun attributo.'); 
define('FS_GUEST_EMAIL_THANK', 'come guest'); 
define('FS_GUEST_EMAIL_CONTACT', 'Ti aggiorneremo sullo stato dell\'ordine con questo indirizzo e-mail. Per qualsiasi ulteriore domanda riguardante il tuo ordine'); 
define('CHECKOUT_TAXE_US_TIT', 'Informazioni su tassa di vendita & su dazi e imposte'); 
define('CHECKOUT_TAXE_US_FRONT', 'Se gli articoli vengono spediti dal nostro magazzino statunitense a un indirizzo entro lo Stato di Washington'); 
define('CHECKOUT_TAXE_US_BACK', 'Per l\'invio dal magazzino CN'); 
define('CHECKOUT_TAXE_CN_TIT', 'Informazioni su dazi e imposte');
define("CHECKOUT_TAXE_CN_TIT1","Informazioni su Dazi e Tasse");
define("CHECKOUT_TAXE_CN_FRONT","Per gli ordini spediti dal nostro deposito in Asia, addebiteremo SOLTANTO il valore del prodotto e le spese di spedizione. Non verrà addebitata alcuna imposta sulle vendite (es. IVA o GST). Tuttavia, ai pacchi possono essere addebitati dazi doganali o di importazione, a seconda delle leggi/regolamenti dei singoli paesi. Eventuali dazi doganali o di importazione causati dallo sdoganamento devono essere dichiarati e sono a carico del destinatario. Se hai bisogno di aiuto per pagare in anticipo il dazio doganale, ti preghiamo di contattarci.");
define('CHECKOUT_TAXE_DE_TIT', 'Informazioni sull\'IVA & sui dazi e imposte');
define('CHECKOUT_TAXE_DE_FRONT', 'Per tutti gli articoli saranno spediti dal magazzino in Germania e, in conformità con le leggi che regolano i membri dell\'Unione Europea, FS.COM GmbH è obbligata ad addebitare l\'IVA su tutti gli ordini consegnati da Germania verso destinazioni nei paesi membri dell\'UE.');
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Paese di destinazione</div><div>IVA &amp; Tariffe</div></div><div class=\"help-center-taTr\"><div>Germania</div><div>Verrà addebitata un'IVA del 19%.</div></div><div class=\"help-center-taTr\"><div>Francia e Monaco</div><div>Verrà addebitata un'IVA del 20%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Paesi Bassi, Spagna, Belgio</div><div>Verrà addebitata un'IVA del 21%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Italia</div><div>Verrà addebitata un'IVA del 22%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.
</div></div><div class=\"help-center-taTr\"><div>Svezia</div><div>Verrà addebitata un'IVA del 25%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Altri paesei membri dell\UE</div><div>Verrà addebitata un'IVA del 19%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Paesi non parte dell\'UE</div><div>L'IVA non verrà addebitata, ma eventuali costi di sdoganamento saranno a tuo carico. </div></div></div>");
define('CHECKOUT_TAXE_DE_TIT', 'Informazioni sull\'IVA & sui dazi e imposte'); 
define('CHECKOUT_TAXE_DE_FRONT', 'Per tutti gli articoli saranno spediti dal magazzino della Germania e, in conformità con le leggi che regolano i membri dell\'Unione Europea, FS.COM GmbH è obbligata ad addebitare l\'IVA su tutti gli ordini consegnati dalla Germania verso destinazioni nei paesi membri dell\'UE e del Regno Unito.');
define("CHECKOUT_TAXE_DE_BACK","<div class=\"help-center-table\"><div class=\"help-center-taHead help-center-taTr\"><div>Paese di destinazione</div><div>IVA &amp; Tariffe</div></div><div class=\"help-center-taTr\"><div>Germania</div><div>Verrà addebitata un'IVA del 16%.</div></div><div class=\"help-center-taTr\"><div>UK, Isola di Man, Francia e Monaco</div><div>Verrà addebitata un'IVA del 20%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Paesi Bassi, Spagna, Belgio</div><div>Verrà addebitata un'IVA del 21%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Italia</div><div>Verrà addebitata un'IVA del 22%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.
</div></div><div class=\"help-center-taTr\"><div>Svezia</div><div>Verrà addebitata un'IVA del 25%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Altri paesi membri dell'UE</div><div>Verrà addebitata un'IVA del 16%, ma se viene presentato un numero di identificazione IVA UE valido, l'IVA sarà esentata.</div></div><div class=\"help-center-taTr\"><div>Paesi non parte dell'UE</div><div>L'IVA non verrà addebitata, ma eventuali costi di sdoganamento saranno a tuo carico. </div></div></div>");

define('FS_CHECK_OUT_EXCLUDING_CA','(Il totale sopraindicato non include possibili <a href="javascript:void(0);" onclick="show_taxes()" class=" checkout_Npro_priceLiL tax_content tax_color">tasse</a>)');
define('FS_CHECK_OUT_TAX_SG','GST');
define('FS_CHECK_OUT_INCLUDING_SG','(Includendo GST)');
define("FS_SHIPPING_UPS_DE_TIPS_02","Il tempo limite per la consegna DHL è alle 16:30, una richiesta d'ordine ricevuta dopo le 16:30 verrà spedita il giorno lavorativo successivo.");

define('FS_PRICE_LOW_HIGH', 'Prezzo : basso-alto');
define('FS_PRICE_HIGH_LOW', 'Prezzo : alto-basso     ');
define('FS_RATE_HOGH', 'Valutazione : alto-basso');
define('FS_NEWEST_FIRST', 'I più recenti all\'inizio'); 
define('FS_POPULARITY', 'Popolarità'); 
define('CHECKOUT_TAXE_NEW_CN_CONTENT', 'I prodotti in giacenza nel nostro magazzino statunitense saranno spediti direttamente dal Delaware a qualsiasi destinazione degli Stati Uniti. FS.COM addebiterà SOLO il valore del prodotto e le spese di spedizione. Non sarà addebitata alcuna tassa di vendita.<br /><br />Se gli ordini contengono articoli temporaneamente esauriti nel magazzino statunitense');
define("CHECKOUT_TAXE_NEW_CA_CONTENT","I prodotti in stock nel nostro deposito statunitense verranno spediti direttamente dal Delaware verso qualsiasi destinazione in Canada.<br/><br/>Se gli ordini contengono articoli temporaneamente esauriti nel deposito statunitense, li spediremo direttamente dal nostro deposito in Asia per accelerare la consegna. <br/><br/>Quando effettui l'ordine online, FS.COM addebiterà SOLO il valore del prodotto e le spese di spedizione. Eventuali dazi e tariffe causati dallo sdoganamento saranno a carico del cliente.");
define('CHECKOUT_TAXE_NEW_MX_CONTENT', 'I prodotti in giacenza nel nostro magazzino statunitense saranno spediti direttamente dal Delaware a qualsiasi destinazione in Messico.<br /><br />Se gli ordini contengono articoli temporaneamente esauriti nel magazzino statunitense'); 
define('FS_IS_SPRING', '0'); 
define('CN_SPRING_WAREHOUSE_MESSAGE', 'Nota: Gli articoli del magazzino CN non saranno spediti fino alle vacanze di primavera (6 feb). '); 
define('FS_SALES_INFO_NUMBER', 'Numero di serie'); 
define('FS_SALES_INFO_FOR', 'Per i ricetrasmettitori'); 
define('FS_SALES_INFO_BRIEFLY', 'Indicare brevemente il problema'); 
define('FS_REFUND_PROCESSING', 'Elaborazione rimborso'); 
define('FS_REFUND_APPLICATION', 'Domanda di rimborso'); 
define('FS_REFUND_SUCCESS_MSG', 'Rimborso eseguito correttamente'); 
define('FS_REFUND_FAIL_MSG', 'Spiacenti'); 
define('FS_REFUND_APPMSG', 'La tua domanda di rimborso è in corso'); 
define('FS_EMPTY_COST', 'Spiacenti, al momento tutte le aziende di logistica non offrono servizi di spedizione verso il tuo distretto'); 
define('FS_RU_SPRING', 'Durante il festival primaverile cinese (6/02/2018-20/02/2018)'); 
define('FS_QTY_CHANGED', 'completa il pagamento IL PIÙ PRESTO POSSIBILE affinché il tuo ordine sia gestito immediatamente. Altrimenti potrebbe subire ritardi nella consegna a causa della variazione di stoccaggio.'); 
define('FS_MODIFY_EMAIL_MY_CASE_01', 'Il tuo caso'); 
define('FS_MODIFY_EMAIL_MY_CASE_02', 'confermato qui.'); 
define('FS_MODIFY_EMAIL_MY_CASE_03', 'Grazie per aver contattato <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#333; text-decoration:none;">FS.COM</a>');
define('FS_MODIFY_EMAIL_MY_CASE_04', 'Il nostro team di vendita <a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#333; text-decoration:none;">FS.COM</a> esaminerà il tuo caso e ti risponderà entro12 ore.');
define('FS_MODIFY_EMAIL_MY_CASE_05', 'Se ti occorre una risposta immediata'); 
define('FS_MODIFY_EMAIL_MY_CASE_06', 'Cordialmente'); 
define('FS_MODIFY_EMAIL_MY_CASE_07', '<a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#333; text-decoration:none;">FS.COM</a> Team del servizio clienti');
define('FS_MODIFY_EMAIL_MY_CASE_08', 'Gentile'); 
define('FS_MODIFY_EMAIL_MY_CASE_09', 'FS.COM - Numero caso:'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_01', 'Nuova risposta da'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_02', 'sul caso'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_03', 'Gentili'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_04', 'Il cliente'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_05', 'ha risposto sul caso nel modo seguente:'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_06', '- Venditore:'); 
define('FS_MODIFY_EMAIL_MY_CASE_DETAILS_07', '- Tecnico:'); 
define('FS_EMAIL_REQUEST_STOCK_01', 'FS.COM - Richiesta scorte & Numero caso: '); 
define('FS_EMAIL_REQUEST_STOCK_02', 'La tua richiesta di altre scorte dell\'articolo n.'); 
define('FS_EMAIL_REQUEST_STOCK_03', 'Gentile '); 
define('FS_EMAIL_REQUEST_STOCK_04', 'Grazie per aver inviato la richiesta di scorte. I tuoi dati sulle esigenze di giacenza sono molto importanti per noi. Un responsabile di vendita dedicato ti contatterà per discutere con te i dettagli della tua richiesta. Nel frattempo'); 
define('FS_EMAIL_REQUEST_STOCK_05', ' Il team di gestione delle scorte farà riferimento alle tue esigenze e ottimizzerà il nostro piano di gestione scorte. '); 
define('FS_EMAIL_REQUEST_STOCK_06', 'Se ti occorre una risposta immediata'); 
define('FS_EMAIL_REQUEST_STOCK_07', 'Cordialmente'); 
define('FS_EMAIL_REQUEST_STOCK_08', '<a href="'.HTTPS_SERVER.'/" target="_blank" style="color:#333; text-decoration:none;">FS.COM</a> Team del servizio clienti');
define('FS_EMAIL_REQUEST_STOCK_09', 'Gentile'); 
define('FS_EMAIL_REQUEST_STOCK_10', 'FS.COM - Numero caso:'); 
define('FS_CHECKOUT_MONDAY_TO_FRIDAY', ' | lun. - ven.');
define('FS_JS_TIT_CHECK1', '<br/>Orario di ritiro: ');
define('FS_JS_TIT_CHECK2', 'Ora del Pacifico'); 
define('FS_JS_TIT_CHECK3', 'Lunedì - Venerdì'); 
define('FS_JS_TIT_CHECK4', '10:00 - 12:00 '); 
define('FS_JS_TIT_CHECK5', ', 14:00 - 17:30 ');
define('FS_JS_TIT_CHECK_US', '9:30 - 17:30 ');
define('FS_TIME_ZONE_RULE_US', '(PST)');
if(SUMMER_TIME){
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT + 2)");
}else{
    define("FS_TIME_ZONE_RULE_EU"," (UTC/GMT+1)");
}
define('CN_SPRING_WAREHOUSE_MESSAGE1', 'Nota: L\'ordine '); 
define('CN_SPRING_WAREHOUSE_MESSAGE2', 'spedito dal magazzino CN non sarà spedito fino al festival primaverile cinese (6 feb.)'); 
define('FS_ADDRESS_MESSAGE3', 'Indirizzo postale'); 
define('FS_ADDRESS_MESSAGE4', 'Appartamento'); 
define('FIBERSTORE_INFO_WIRE_DE', 'Conto Sparkasse Bank'); 
define('FS_HSBC_INFO1', 'Nome banca beneficiario'); 
define('FS_HSBC_INFO2', 'Nome C/C beneficiario'); 
define('FS_HSBC_INFO3', 'IBAN:');
define('FS_HSBC_INFO4', 'BIC:');
define('FS_HSBC_INFO5', 'Numero Conto:');
define('FS_HSBC_INFO6', 'Indirizzo Banca Beneficiario:');
define('FS_TAX_ERROR_EMPTY', 'Inserisci un codice fiscale valido.'); 
define('FS_SECURITY_ERROR', 'Si è verificato un errore di sicurezza.'); 
define('FS_SYSTME_BUSY', 'Il sistema è occupato. Riprova più tardi'); 
define('FS_ACCESS_DENIED', 'Errore: Accesso negato.'); 
define('FS_ACCESS_DENIED_1', 'Errore: codice 999.'); 
define('FS_FORM_REQUEST_ERROR', 'Spiacenti'); 
define('FS_NON_MANDAROTY', 'Non obbligatorio'); 
define('FS_COMMON_SAVE', 'Salva'); 
define('FS_COMMON_CANCEL', 'Annulla'); 
define('FS_COMMON_YES', 'Sì'); 
define('FS_COMMON_NO', 'No'); 
define('FS_COMMON_SUBMIT', 'Invia');
define('FS_COMMON_PROCESSING', 'Elaborazione in corso'); 
define('FS_COMMON_EDIT', 'Modifica'); 
define('FS_COMMON_LESS', 'Riduci'); 
define('FS_CONFIRM', 'Conferma'); 
define('FS_PLEASE_CHOOSE_ONE', 'Scegline uno...'); 
define('FS_ENTER_CHARACTER', 'Inserisci i caratteri che vedi'); 
define('FS_IMAGE_REQUIRED_TIP', 'Inserisci i caratteri dell\'immagine.'); 
define('FS_IMAGE_ERROR_TIP', 'I caratteri non sono corretti. Riprova.'); 
define('FS_IMAGE_EXPIRE_TIP', 'A causa di un periodo prolungato di inattività'); 
define('FS_IMAGE_FIRST_SHOW_PWD_ERROR_TIP', 'Per proteggere meglio il tuo account'); 
define('FS_IMAGE_FIRST_SHOW_EMAIL_ERROR_TIP', 'Per proteggere meglio il tuo account'); 
define('FS_USERNAME', 'Nome utente'); 
define('FS_FIRST_NAME', 'Nome'); 
define('FS_LAST_NAME', 'Cognome'); 
define('FS_PASSWORD', 'Password'); 
define('FS_EMAIL_ADDRESS', 'Indirizzo e-mail'); 
define('FS_EMAIL_ADDRESS1', 'Indirizzo e-mail'); 
define('FS_COMPANY_WEBSITE', 'Sito Web della società'); 
define('FS_INDUSTRY', 'Settore'); 
define('FS_COMPANY_NAME', 'Nome della società'); 
define('FS_ENTERPRISE_OWNER_NAME', 'Nome titolare impresa'); 
define('FS_YOUR_COUNTRY', 'Il tuo paese/regione'); 
define('FS_COUNTRY', 'Paese/Regione:'); 
define('FS_OTHER_COUNTRIES', 'Altri paesi'); 
define('FS_SELECT_YOUR_COUNTRY_REGION', 'Seleziona il tuo paese/regione'); 
define('FS_SELECT_COUNTRY_REGION', 'Seleziona Paese/Regione'); 
define('FS_VAT_NUMBER', 'PARTITA IVA/Codice fiscale'); 
define('FS_PHONE_NUMBER', 'Numero di telefono'); 
define('FS_COMMON_COMPANY', 'Società'); 
define('FS_FOOTER_COMPANY_INFO', 'Società'); 
define('FS_QTY', 'QTÀ'); 
define('FS_OR', 'O'); 
define('FS_OTHERS', 'Altri'); 
define('FS_LOADING', 'Caricamento in corso'); 
define('FS_SHOW', 'mostra'); 
define('FS_HIDE', 'nascondi'); 
define('FS_HELLO', 'Salve'); 
define('FS_SORT', 'Ordina'); 
define('FS_COMMON_MORE', 'Altro'); 
define('FS_COMMON_CUSTOMIZED', 'Personalizzato'); 
define('FS_NEXT_DAY', 'Giorno successivo'); 
define('FS_COMMON_CLOSE', 'Chiudi');
define('FS_COMMON_FS_PN', 'FS P/N: ');
define('FS_COPY', 'Copyright'); 
define('FS_RIGHTS', 'Tutti i diritti riservati'); 
define('FS_TERMS_OF_USE', 'Termini d\'uso'); 
define('FS_POLICY', 'Informativa sulla privacy'); 
define('FS_AGREE_POLICY', 'Facendo clic sul pulsante sottostante'); 
define('FS_FOOTER_COOKIE_TIP', 'Utilizziamo i cookie per assicurarci di offrirti la migliore esperienza sul nostro sito Web. Continuando a utilizzare questo sito accetti l\'uso dei cookie da parte nostra in accordo con la nostra <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'>Politica sui cookie</a>.');
define('FS_FOOTER_COOKIE_MOBILE_TIP', 'Utilizziamo i cookie per offrirti una migliore esperienza di shopping. Visualizza la <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'>Politica sui cookie</a>.');
define('FS_I_ACCEPT', 'Accetto'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_CN', 'Disponibile per la spedizione immediata dal magazzino cinese'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_US', 'Disponibile per la spedizione immediata dal magazzino statunitense'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_EU', 'Disponibile per la spedizione immediata dal magazzino europeo'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_CN', 'dal magazzino in Cina'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_US', 'dal magazzino in USA'); 
define('FS_SHIPPING_AREA_BY_WAREHOUSE_SHORT_EU', 'dal magazzino in Europa'); 
define('FS_BULK_WAREHOUSE', 'Spedizione dal magazzino CN prevista il'); 
define('FREE_SHIPPING_TEXT1', 'Spedizione gratuita sugli ordini oltre € 79 (articoli di grandi dimensioni esclusi).'); 
define('FREE_SHIPPING_TEXT2', 'Spedizione gratuita sugli ordini oltre $ 79 (articoli di grandi dimensioni esclusi).'); 
define('FS_PRODUCT_INFO_BRAND_PLEASE', 'Scegli un marchio.'); 
define('FS_WAREHOUSE_EU', 'Magazzino DE');
define('FS_WAREHOUSE_US', 'Magazzino U.S.A.'); 
define('FS_WAREHOUSE_CN', 'Magazzino CN'); 
define('FS_WAREHOUSE_AU', 'Magazzino AU'); 
define('FS_WAREHOUSE_', 'Magazzino CN');
define("FS_WAREHOUSE_RU","Magazzino RU");
define('FS_W_DE', 'EU'); 
define('FS_W_US', 'U.S.A.'); 
define('FS_W_CN', 'CN'); 
define('FS_PRODUCT_INFO_BRAND_CHOOSE', 'Scegli un marchio'); 
define('FS_ATTRIBUTE_OEM', 'Servizio OEM/ODM'); 
define('NEWS_FS_ATTRIBUTE_OEM', 'Servizio etichettatura'); 
define('FS_ATTRIBUTE_NONE', 'Nessuno'); 
define('FS_ATTRIBUTE_DESIGN', 'Etichetta disegno'); 
define('FS_ORDER_LOGO_DESIGN', 'Carica logo etichetta disegno'); 
define('FS_ORDER_LOGO_YOUR', 'Carica il logo della tua etichetta del disegno o il nome del tuo fornitore specifico & il numero di parte per riferimento.'); 
define('FS_ORDER_LOGO_WE', 'Ti confermeremo l\'etichetta ed elaboreremo il tuo ordine di conseguenza. Puoi inviarci il logo anche tramite e-mail.'); 
define('FS_ORDER_LOGO_UPLOAD', 'Carica logo'); 
define('FS_ORDER_LOGO_DELETE', 'Eliminare l\'immagine?'); 
define('FS_ORDER_LOGO_UP_SUCCESS', 'File del logo caricato correttamente!'); 
define('FS_ORDER_LOGO_DEL_SUCCESS', 'Immagine eliminata correttamente!'); 
define('FS_LIMIT_MONEY', 'L\'importo totale supera il limite'); 
define('FS_LIMIT_MONEY_15000', 'L\'importo totale supera il limite (€ 15000)');
define('FS_LIMIT_MONEY_10000', 'L\'importo totale supera il limite (€ 10000)');
define('FS_JS_TIT_CHECK6', 'Nome su ID foto'); 
define('FS_JS_TIT_CHECK7', 'Indirizzo e-mail'); 
define('FS_JS_TIT_CHECK8', 'Tel. di ritiro');
define('FS_JS_TIT_CHECK9', 'Orario di ritiro');
define('MY_CASE_UPLOAD_1', 'La tua richiesta di soluzione'); 
define('MY_CASE_UPLOAD_2', 'è stata inviata.'); 
define('MY_CASE_UPLOAD_3', 'Gentile ');
define('MY_CASE_UPLOAD_4', 'Grazie per aver contattato FS.COM Solution Support'); 
define('MY_CASE_UPLOAD_5', 'per la tua richiesta di soluzione.'); 
define('MY_CASE_UPLOAD_6', 'Ti contatteremo entro 24 ore'); 
define('MY_CASE_UPLOAD_7', 'Nel frattempo'); 
define('MY_CASE_UPLOAD_8', 'https://www.fs.com/de-en/Data-Center-Cabling.html'); 
define('MY_CASE_UPLOAD_9', 'https://www.fs.com/de-en/Enterprise-Networks.html'); 
define('MY_CASE_UPLOAD_10', 'https://www.fs.com/de-en/Long-haul-Transmission.html'); 
define('MY_CASE_UPLOAD_11', 'https://www.fs.com/de-en/Optic-OEM-Solution.html'); 
define('MY_CASE_UPLOAD_12', 'Cablaggio per data center'); 
define('MY_CASE_UPLOAD_13', 'Rete enterprise'); 
define('MY_CASE_UPLOAD_14', 'Rete di trasporto ottica'); 
define('MY_CASE_UPLOAD_15', 'Soluzione OEM ottica'); 
define('MY_CASE_UPLOAD_16', 'Cordialmente'); 
define('MY_CASE_UPLOAD_17', 'https://www.fs.com/de-en/'); 
define('MY_CASE_UPLOAD_18', 'FS.COM'); 
define('MY_CASE_UPLOAD_19', 'Supporto soluzione'); 
define('MY_CASE_UPLOAD_20', 'FS.COM - Richiesta soluzione & Numero caso:'); 
define('FS_FOR_FREE_SHIPPING', 'Spedizione GRATUITA'); 
define('FS_FOR_FREE_SHIPPING_US', 'su ordini superiori a $ 79'); 
define('FS_FOR_FREES_SHIPPING_ONE', 'Lo voglio domani '); 
define('FS_FOR_FREES_SHIPPING_TWO', 'Ordina per '); 
define('FS_FOR_FREES_SHIPPING_TIME', '16:00 (PST)'); 
define('FS_FOR_FREES_SHIPPING_THREE', 'e scegli Spedizione il giorno successivo al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FOUR', 'Spedizione:'); 
define('FS_FOR_FREES_SHIPPING_FIVE', 'Ricevilo entro 1-3 giorni lavorativi se ordini entro le ore <span>16:00 (PST)</span>.'); 
define('FS_FOR_FREES_SHIPPING_SIX', 'Lo vuoi martedì? Scegli Spedizione il giorno successivo al pagamento.'); 
define('FS_FOR_FREE_SHIPPING_DE', 'Consegna GRATUITA'); 
define('FS_FOR_FREE_SHIPPING_DE_MONEY', ' sugli ordini superiori a 79 € (IVA esclusa)');
define('FS_FOR_FREE_SHIPPING_PRE_ORDER', 'sugli ordini con MONEY');

//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Consegne & Resi');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Fast Shipping to South-East Asia');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','Dopo la consegna, se si verificano problemi legati alla qualità o se si cambia semplicemente idea, è possibile restituire gli articoli idonei entro 30 giorni. Scopri di più riguardo <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">la Politica sui resi</a> di tutti i prodotti venduti da FS.');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Orders up to $MONEY or more qualify for free delivery on eligible items. For more information on how to qualify, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS provides multiple delivery options to meet your time schedule or budget. And the stock orders will be shipped within 24 business hours after order placed. For more information, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">For Pre-Order items, orders up to $MONEY or more qualify for free delivery. For more information on how to qualify, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_HK_MO_TL','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">All items delivered to HK, Macao and Taiwan can enjoy Free delivery. And the stock orders will be shipped within 24 business hours after order placed. For more information, please visit <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Shipping & Delivery</a>.</div>');

if (get_warehouse_by_code($_SESSION['countries_iso_code']) == 'cn') {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', 'Servizio pre-ordine');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', 'Per meglio servire le nostre PMI e grandi aziende');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', 'Il tempo di lavorazione degli articoli di pre-ordine è all\'incirca di 15 giorni lavorativi. Pertanto');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', 'Li spediremo dopo la produzione e un test scrupoloso. La rapidità della spedizione dipenderà dal metodo di spedizione che scegli durante il pagamento. <br><br> Ulteriori informazioni sulla <a href ="shipping_delivery.html" target="_blank">Politica sulle consegne</a>.');
}else {
    define('FS_PRE_PRODUCTS_SHIPPING_WD_TITLE', 'Consegna gratuita sugli articoli di pre-ordine con MONEY');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO', 'Per godere di consegna gratuita');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_03', 'Il tempo di lavorazione degli articoli di pre-ordine è all\'incirca di 15 giorni lavorativi. Li spediremo dopo la produzione e scrupoloso test. La rapidità della consegna dipenderà dall\'opzione di consegna che scegli durante il pagamento.');
    define('FS_PRE_PRODUCTS_SHIPPING_WD_INFO_04', 'Il servizio di pre-ordine può aiutarti a programmare il tuo progetto in modo più flessibile ed elastico. Ulteriori informazioni sul <a href ="specials/pre-order-service-71.html" target="_blank">Servizio di pre-ordine</a>.');
}
define('FS_SHARE_CART_06', 'Account Manager');
define('FS_FOR_FREES_SHIPPING_FIVE_DE1', ' <span>16:00 (UTC/GMT +1</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE2', ' <span>16:00 (UTC/GMT +2</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE3', 'Vuoi una consegna più veloce? Ordina entro le ore <span>16:00 (UTC/GMT +2</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE4', ' <span>15:00 (UTC/GMT +1</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE5', ' <span>15:00 (UTC/GMT +1</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE6', 'Vuoi una consegna più veloce? Ordina entro le ore <span>11:00 (UTC/GMT -3</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE7', 'Vuoi una consegna più veloce? Ordina entro le ore <span>18:00 (UTC/GMT +4</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE8', 'Vuoi una consegna più veloce? Ordina entro le ore <span>15:00 (UTC/GMT +1</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE9', 'Vuoi una consegna più veloce? Ordina entro le ore <span>17:00 (UTC/GMT +3</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE10', '<span>16:00 (UTC/GMT +3</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE11', 'Vuoi una consegna più veloce? Ordina entro le ore <span>12:00 (UTC/GMT -2</span> e scegli DHL Express al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE12', 'Spedizione martedì e ricevilo entro 1-3 giorni lavorativi.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE13', 'Lo vuoi martedì? Scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE14', ' Lo vuoi martedì? Scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE15', 'Vuoi una consegna più veloce? Scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_FOR_FREES_SHIPPING_FIVE_DE16', 'Vuoi una consegna più veloce? Scegli DHL Express al pagamento.'); 
define('FS_FOR_FREE_SHIPPING_GB1', 'Consegna GRATUITA nel Regno Unito'); 
define('FS_FOR_FREE_SHIPPING_GB3', 'su ordini superiori a £ 79'); 
define('FS_FOR_FREE_SHIPPING_GB4', 'nel Regno Unito'); 
define('FS_ITEM_LOCATION', 'Posizione articolo:'); 
define('FS_SEATTLE_WASHINGTON', 'Seattle'); 
define('FS_SEATTLE_EU', 'Monaco di Baviera'); 
define('FS_SEATTLE_CN', 'Wuhan');
define("FS_SHIPPING_POLICY_US","The delivery date applies to the inventory items purchased by 5pm EST on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_CA","The delivery date applies to the inventory items purchased by 5pm on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_MX","The delivery date applies to the inventory items purchased by 4pm on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_NZ","The delivery date applies to the inventory items purchased by 3:00pm (AEST/AEDT) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_AU","The delivery date applies to the inventory items purchased by 3:00pm (AEST/AEDT) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_GB","The delivery date applies to the inventory items purchased by ".FS_SUMMER_OR_WINTER_TIME." on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define("FS_SHIPPING_POLICY_DE","La data di consegna si applica agli articoli in stock ed acquistati entro le ".(SUMMER_TIME ? '16:30 (UTC/GMT + 2)' : '16:30 (UTC/GMT+1)')." nei giorni lavorativi. Dopodiché, il tuo ordine verrà spedito il giorno lavorativo successivo. Se la quantità richiesta supera le giacenze in magazzino, verrà spedita in un'altra spedizione senza costi aggiuntivi. Per maggiori dettagli, fare riferimento alla pagina di pagamento.");
define('FS_SHIPPING_POLICY_CN', 'La data di consegna si applica agli articoli in giacenza acquistati entro le ore 15.30 (GMT+8 nei giorni lavorativi). Se la tua quantità richiesta supera la giacenza');
define("FS_SHIPPING_POLICY_SG","The delivery date applies to the inventory items purchased by 3:30pm (GMT+8) on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched in another shipment at no extra cost. For more details, please refer to the checkout page.");
define('FS_SHIPPING_POLICY_RU', 'La data di consegna si applica agli articoli in giacenza acquistati entro le ore 10:30am (UTC/GMT+3 nei giorni lavorativi). Se la tua quantità richiesta supera la giacenza');

define('FS_GET_A_QUOTE_BIG', 'Ottieni un preventivo');
define('FS_GET_A_QUOTE_FREE', 'Richiedi una scatola'); 
define('FS_GET_A_QUOTE', 'Ottieni un preventivo'); 
define('FS_REQUEST_DEADLINE', 'La richiesta è stata chiusa come programmata. Una versione aggiornata sarà disponibile a novembre'); 
define('FS_WAREHOSE_GB_TIP', 'Consegna gratuita sugli ordini superiori a £ 79 spediti dal magazzino europeo (Germania)'); 
define('FREE_SHIPPING_TEXT_GB', 'Consegna gratuita sugli ordini superiori a £ 79 (articoli di grandi dimensioni esclusi).'); 
define('FS_COMMON_HEADER_ACCOUNT', 'Account');
define('FS_COMMON_HEADER_CASES', 'Casi'); 
define('FS_COMMON_HEADER_NOT', 'Non sei tu?'); 
define('FS_COMMON_HEADER_OUT', 'Disconnetti'); 
define('MANAGE_ORDER_HISTORY', 'Storico ordini');
define('FS_ACCOUNT_NO','No. ');

define('FS_FOR_FREE_SHIPPING_TO_FREE', 'Gratis'); 
define('FS_FOR_FREE_SHIPPING_TO', ' Consegna a'); 
define('FS_FOR_FREE_SHIPPING_TO_CN', 'Spedizione il '); 
define('FS_FOR_FREE_SHIPPING_TO2', 'Spedizione a '); 
define('FS_FOR_FREE_SHIPPING_ON', 'il'); 
define('FS_FOR_FREE_SHIPPING_TO3', 'a'); 
define('FS_CHECKOUT_EDIT', 'Modifica'); 
define('FS_CHECKOUT_USE_ADDRESS', 'Utilizza il mio indirizzo di consegna come indirizzo di fatturazione'); 
define('FIBERSTORE_YOUR_RECENT_HISTOR', 'Visti di recente'); 
define('FS_PRODUCT_INFO_PREIS', 'Prezzo:'); 
define('FS_NET_PRODUCT16', 'Torna a visitare periodicamente questa pagina dei nuovi prodotti per vedere le nostre ultime offerte'); 
define('FS_NET_PRODUCT19', 'Ordina per'); 
define('FS_NET_PRODUCT20', 'In evidenza'); 
define('FS_NET_PRODUCT17', 'Prezzo: Da basso ad alto'); 
define('FS_NET_PRODUCT18', 'Prezzo: Da alto a basso'); 
define('FS_PRODUCT_INFO_TAX', '(<a href="javascript:;" class="vat_info">IVA tedesca del 19% inclusa)</a>'); 
define('PRODCUT_CATALOGS_01', 'Cataloghi di prodotto'); 
define('PRODCUT_CATALOGS_03', 'Soluzioni'); 
define('PRODCUT_CATALOGS_04', 'Video dei prodotti'); 
define('CHECKOUT_ONESELF_PICH', 'Lo preleverò personalmente'); 
define('FS_LOCAL_URL_MESSAGE', 'Consegna gratuita in Germania sugli ordini superiori a 79'); 
define('FIBER_CHECK_BANK_NUM', 'Numero del conto'); 
define('FIBER_CHECK_BANK_DRESS', ' Indirizzo Banca Beneficiario');
define('FS_ADDERSS_LIMIT', 'Spiacenti'); 
define('FS_CHECKOUT_ADDRESS_ADD', 'Aggiorna indirizzo'); 
define('FS_LOGIN_REGIST_PFICHTFELDER', '*Campi obbligatori'); 
define('FS_CHECK_OUT_GO', 'Governo/organizzazione'); 
define('FS_PAY_RECHNUNG', 'Pagamento per fattura'); 
define('FS_FOR_FREE_SHIPPING_GET', 'ricevilo entro'); 
define('FS_DE_SHIPPING_RESET1', ' <span>16:00 (UTC/GMT +2</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET2', ' Vuoi riceverlo martedì prossimo? Scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET3', ' <span>17:00 (UTC/GMT +3</span> e scegli UPS Express Plus Next Day 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET4', 'Vuoi una consegna più veloce? Ordina entro le ore <span>15:00 (UTC/GMT +1</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET5', 'Vuoi una consegna più veloce? Scegli DHL Express 9:00am al pagamento.'); 
define('FS_DE_SHIPPING_RESET6', 'Vuoi una consegna più veloce? Ordina entro le ore <span>16:00 (UTC/GMT +2</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET7', 'Vuoi una consegna più veloce? Ordina entro le ore <span>15:00 (UTC/GMT +1</span> e scegli DHL Express 9:00 am al pagamento.'); 
define('FS_DE_SHIPPING_RESET8', 'mattino'); 
define('FS_ADDRESS_INVOICE', 'FATTURA'); 
define('FS_ADDRESS_INVOICE', 'FATTURA'); 
define('FS_SUCCESS_RE', 'Pagamento per fattura'); 
define('FS_FESTIVAL1', 'La festività pubblica in Germania inizia il');
define('FS_FESTIVAL4', '°  ');
define('FS_FESTIVAL2', 'FS.COM GmbH tornerà il'); 
define('FS_FESTIVAL3', ' nel magazzino tedesco.'); 
define('FS_FESTIVAL4', '°');
define('FS_FESTIVAL5', ''); //意大利只有每个月的一号有°
define('FS_FESTIVAL6', 'La festività pubblica negli Stati Uniti inizia il'); 
define('FS_FESTIVAL7', ' nel magazzino statunitense.'); 
define('FS_FESTIVAL8', 'Gli ordini effettuati durante le festività saranno allineati ed elaborati il'); 
define('CHECKOUT_TAXE_CN_FRONT1', 'Tutti gli ordini spediti da nostro magazzino CN verso la Cina continentale'); 
define('CHECKOUT_TAXE_CN_FRONT2', 'Mentre'); 
define('FS_PRODUCTS_SHIPPING_CHANGE1', 'Scegli la tua sede di consegna'); 
define('FS_PRODUCTS_SHIPPING_CHANGE2', 'Le opzioni di consegna e la rapidità di consegna possono variare a seconda delle diverse sedi'); 
define('FS_PRODUCTS_SHIPPING_CHANGE3', 'Accedi per visualizzare i tuoi indirizzi'); 
define('FS_PRODUCTS_SHIPPING_CHANGE4', 'o inserisci un CAP'); 
define('FS_PRODUCTS_SHIPPING_CHANGE5', 'Consegna a'); 
define('FS_PRODUCTS_SHIPPING_CHANGE6', 'Cambia'); 
define('FS_PRODUCTS_SHIPPING_CHANGE7', 'La merce non viene consegnata in <font class=\'choice_country\'>Germania</font>. Cambiare alla regione corrispondente?'); 
define('FS_PRODUCTS_SHIPPING_CHANGE8', 'Applica'); 
define('FS_PRODUCTS_SHIPPING_CHANGE9', 'Visualizza altro'); 
define('FS_PRODUCTS_SHIPPING_CHANGE10', 'Gestore rubrica'); 
define('FS_PRODUCTS_SHIPPING_CHANGE11', 'L\'ordine entro le 16:00 (PST) sarà spedito oggi'); 
define('FS_PRODUCTS_SHIPPING_CHANGE12', 'o'); 
define('FS_PRODUCTS_SHIPPING_CHANGE13', 'Aggiungi un nuovo indirizzo'); 
define('FS_PRODUCTS_SHIPPING_CHANGE14', 'Inserisci un codice postale USA valido'); 
define('FS_PRODUCTS_SHIPPING_CHANGE15', 'Spedizione al di fuori degli Stati Uniti'); 
define('FS_PRODUCTS_SHIPPING_CHANGE16', 'Inserisci il codice postale o scegli il paese in cui spedire.'); 
define('FS_PRODUCTS_SHIPPING_CHANGE17', 'Invia'); 
define('FS_FESTIVAL9', '');
define('FS_FESTIVAL10', '');//意大利只有每个月的一号有°
define('FS_FESTIVAL12', ''); 
define('CHECKOUT_TAXE_CN_FRONT1', 'Tutti gli ordini spediti da nostro magazzino CN verso la Cina continentale'); 
define('CHECKOUT_TAXE_CN_FRONT2', 'Mentre'); 
define('FS_ADDRESS_SHIPPING_ERROR', 'Spiacenti'); 
define('FS_GUEST_HAVA', 'L\'indirizzo e-mail esiste nel nostro sistema'); 
define('FS_GUEST_LOGIN', 'accedi'); 
define('FS_CHECK_OUT_TAX_AU', 'GST'); 
define('FS_CHECK_OUT_EXCLUDING_AU', '(Escluso GST)'); 
define('FS_CHECK_OUT_INCLUDING_AU', '(Incluso GST)'); 
define('FS_WAREHOUSE_AREA_AU', 'Spedizione dal magazzino AU'); 
define('CHECKOUT_TAXE_AU_TIT', 'Info su GST e dazi');
define('FREE_SHIPPING_TEXT3', 'Consegna gratuita sugli ordini superiori a AU$ 99.'); 
define('FS_WAREHOUSE_AU', 'Magazzino AU'); 
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU', 'GST'); 
define('PRODUCTS_SHIP_TODAY', 'Spedizione odierna'); 
define('ITEM_LOCATION_AU', 'Melbourne'); 
define('FS_SHOP_CART_ALERT_JS_50', 'Articolo/i'); 
define('FS_SHOP_CART_ALERT_JS_51', 'Subtotale ('); 
define('FS_SHOP_CART_ALERT_JS_52', ':'); 
define('FS_SHOP_CART_ALERT_JS_53', 'Riepilogo carrello'); 
define('FS_SHOP_CART_ALERT_JS_54', '(Costo di consegna non incluso)'); 
define('FS_SHOP_CART_ALERT_JS_55', 'Il tuo nome'); 
define('FS_SHOP_CART_ALERT_JS_55_1', 'Nome del destinatario'); 
define('FS_SHOP_CART_ALERT_JS_56', 'La tua e-mail'); 
define('FS_SHOP_CART_ALERT_JS_56_1', 'Separa più destinatari con un punto e virgola ;');
define('FS_SHOP_CART_ALERT_JS_57', 'Consentiti al massimo 500 caratteri.'); 
define('FS_SHOP_CART_ALERT_JS_58', 'Carrello salvato'); 
define('FS_SHOP_CART_ALERT_JS_59', 'Il tuo ordine gode di consegna GRATUITA'); 
define('FS_SHOP_CART_ALERT_JS_60', 'Consegna a'); 
define('FS_SHOP_CART_ALERT_JS_61', 'Tutti gli ordini di $ 79 o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_62', 'Per godere di consegna GRATUITA'); 
define('FS_SHOP_CART_ALERT_JS_63', 'degli articoli idonei.'); 
define('FS_SHOP_CART_ALERT_JS_64', 'Il tuo ordine gode di consegna GRATUITA'); 
define('FS_SHOP_CART_ALERT_JS_65', 'Tutti gli ordini di 79 € o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_66', 'Tutti gli ordini di 79 € o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_67', 'Tutti gli ordini di 79 € o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_68', 'Tutti gli ordini di 79 € o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_69', 'Procedi al Pagamento');
define('FS_SHOP_CART_ALERT_JS_70', 'Continua lo shopping'); 
define('FS_SHOP_CART_ALERT_JS_71', 'Tutti gli ordini di 99 AUD o superiori di articoli idonei in qualsiasi categoria di prodotto godono di consegna GRATUITA.'); 
define('FS_SHOP_CART_ALERT_JS_72', ' Salva Carrello');
define('FS_SHOP_CART_ALERT_JS_72_1', ' Salva Carrello');
define('FS_SHOP_CART_ALERT_JS_73', 'Invia il carrello via e-mail');
define('FS_SHOP_CART_ALERT_JS_74', 'Stampa'); 
define('FS_SHOP_CART_ALERT_JS_75', 'Condividi di nuovo'); 
define('FS_AJAX_DELETE1', 'è stato rimosso con successo dal tuo carrello.'); 
define('FS_AJAX_DELETE2', 'Annulla'); 
define('FS_SHOP_CART_VAT_COST', 'IVA 19% dei prodotti:'); 
define('FS_SHOP_CART_VAT_COST_FR', 'IVA 20% dei prodotti: '); 
define('FS_SHOP_CART_TOTAL', 'Totale (IVA inclusa:)'); 
define('FS_CART_ITEM', 'Articolo)');
define('FS_CART_ITEMS', 'Articoli)');
define('FS_HELP', 'Guida'); 
define('FS_GIVE_FEEDBACK', 'Condividi il commento'); 
define('FS_GIVE_FEEDBACK_TIP', 'Grazie per aver visitato FS. Il tuo commento ci aiuterà a fornire ai clienti un\'esperienza migliore.'); 
define('FS_RATE_THIS_PAGE', 'Con quale probabilità consiglieresti FS ai tuoi amici?*'); 
define('FS_NOT_LIKELY', 'Non probabile'); 
define('FS_VERY_LIKELY', 'Molto probabile');
define('FS_TELL_US_SUGGESTIONS', 'Seleziona un argomento per il tuo commento.*'); 
define('FS_ENTER_COMMENTS', 'Facci sapere cosa ne pensi.'); 
define('FS_PROVIDE_EMAIL', 'Se desideri ricevere una nostra risposta'); 
define('FS_PROVIDE_EMAIL_TIP', 'Nota: Queste informazioni NON saranno utilizzate per alcun altro scopo. Diamo molto valore alla tua privacy.'); 
define('FS_FEEDBACK_THANKYOU', 'Hai già condiviso con successo.');
define('FS_PRO_SHARE_EMAIL', 'Il tuo messaggio è stato inviato.');
define('FS_FEEDBACK_THANKYOU_TIP_01','La tua opinione è importante per noi, esamineremo il tuo feedback e lo utilizzeremo per migliorare visite future sul nostro sito Web di FS.');
define('FS_FEEDBACK_THANKYOU_TIP_02','La soddisfazione del cliente è la nostra priorità e continueremo a offrirti servizi e un\'esperienza di acquisto migliori.');
define("FS_SEARCH_YOUR_COUNTRY",'Cerca paese/regione');
define('FS_CHOOSE_ONE', 'Scegline uno'); 
define('FS_WEB_ERROR', 'Errore del sito Web'); 
define('FS_FEEDBACK_PRODUCT', 'Prodotto'); 
define('FS_ORDER_SUPPORT', 'Supporto per l\'ordine'); 
define('FS_TECH_SUPPORT', 'Supporto tecnico'); 
define('FS_SITE_SEARCH', 'Ricerca nel sito'); 
define('FS_FEEDBACK_OTHER', 'Altro'); 
define('FS_FEEDBACK_NAME', 'Nome'); 
define('FS_FEEDBACK_EMAIL', 'Indirizzo e-mail'); 
define('FS_CHECK_OUT_TAX_AU', 'GST'); 
define('FS_CHECK_OUT_EXCLUDING_AU', '(Escluso GST)'); 
define('FS_CHECK_OUT_INCLUDING_AU', '(Incluso GST)'); 
define('FS_WAREHOUSE_AREA_AU', 'Spedizione dal magazzino AU'); 
define('CHECKOUT_TAXE_AU_TIT', 'Info su GST e dazi');
define("CHECKOUT_TAXE_AU_CONTENT", "In conformità con <em class='alone_font_italic'> A New Tax System (Tax and Goods) Act 1999 </em>, per la spedizione dal deposito di Melbourne, FS.COM PTY LTD è tenuta ad addebitare GST su tutti gli ordini consegnati a indirizzi in Australia. Tutti gli articoli del nostro settore sono soggetti al normale tasso GST del 10%. Dopo aver completato le informazioni sull'ordine, sarai in grado di vedere l'importo totale comprensivo di GST applicabile nella pagina di riepilogo dell'ordine.</br></br>Per ordini con prodotti non disponibili nel nostro deposito di Melbourne, possono essere spediti da Melbourne dopo il loro trasferimento dal deposito in Asia.</br></br>Per ordini contenenti articoli pesanti o di grandi dimensioni, saranno spediti direttamente dal deposito in Asia. In questo caso, nessun GST viene addebitato al momento dell'ordine. Ma ai pacchi possono essere attribuite tasse di importazione o doganali, a seconda delle leggi dei diversi paesi. Eventuali dazi doganali o di importazione causati dallo sdoganamento dovranno essere dichiarati e sostenuti dal destinatario.");
define('FREE_SHIPPING_TEXT3', 'Consegna gratuita sugli ordini superiori a AU$ 99.'); 
define('FS_WAREHOUSE_AU', 'Magazzino AU'); 
define('EMAIL_CHECKOUT_COMMON_VAT_COST_AU', 'GST'); 
define('PRODUCTS_SHIP_TODAY', 'Spedizione odierna'); 
define('ITEM_LOCATION_AU', 'Melbourne'); 
define('FS_LOGIN_REGIST_PWD_REQUIRED_TIP_COMMON', 'La password è obbligatoria.'); 
define('FS_LOGIN_REGIST_EMAIL_FORMAT_TIP_COMMON', 'Inserisci un indirizzo e-mail valido. (es.: qualcuno@gmail.com)'); 
define('FS_LOGIN_REGIST_EMAIL_REQUIRED_TIP_COMMON', "L\'indirizzo e-mail è obbligatorio.");
define('FS_LOGIN_REGIST_PWD_ERROR_TIP_COMMON', 'La tua password non è corretta'); 
define('FS_LOGIN_REGIST_EMAIL_NOT_FOUND_ERROR_COMMON', 'Errore: L\'indirizzo e-mail non è stato trovato nei nostri archivi; riprova.'); 
define('FS_LOGIN_REGIST_LOGIN_BANNED_COMMON', 'Errore: Accesso negato.'); 
define('FS_LOGIN_POPUP1', 'Sessione scaduta'); 
define('FS_LOGIN_POPUP2', 'La tua sessione è scaduta e sei stato disconnesso.'); 
define('FS_LOGIN_POPUP3', 'Inserisci nuovamente la password per continuare.'); 
define('FS_LOGIN_POPUP4', 'Indirizzo e-mail'); 
define('FS_LOGIN_POPUP5', 'Non sei tu?'); 
define('FS_LOGIN_POPUP6', 'Password'); 
define('FS_LOGIN_POPUP7', 'Password dimenticata?'); 
define('FS_LOGIN_POPUP8', 'mostra'); 
define('FS_LOGIN_POPUP9', 'nascondi'); 
define('FS_ADDRESS_EDIT_TITLE', 'Modifica indirizzo'); 
define('FS_CHECK_OUT_TAX_DE', 'IVA'); 
define('GLOBAL_TEXT_NAME', 'Nome titolare carta'); 
define('FS_CHECKOUT_ERROR1', 'Il tuo nome è obbligatorio'); 
define('FS_CHECKOUT_ERROR2', 'Il tuo cognome è obbligatorio'); 
define('FS_CHECKOUT_ERROR3', 'Il tuo indirizzo è obbligatorio'); 
define('FS_CHECKOUT_ERROR4', 'Il tuo CAP è obbligatorio'); 
define('FS_CHECKOUT_ERROR5', 'La tua città è obbligatoria'); 
define('FS_CHECKOUT_ERROR6', 'Il tuo paese è obbligatorio'); 
define('FS_CHECKOUT_ERROR7', 'Il tuo numero di telefono è obbligatorio'); 
define('FS_CHECKOUT_ERROR8', 'Il tuo CODICE FISCALE/PARTITA IVA è obbligatorio'); 
define('FS_CHECKOUT_ERROR9', 'Il tuo stato è obbligatorio.'); 
define('FS_CHECKOUT_ERROR10', 'Il nome della tua società è obbligatorio.'); 
define('FS_CHECKOUT_ERROR11', 'Esempio di numero di PARTITA IVA valido: DE123456789'); 
define('FS_CHECKOUT_ERROR12', 'La riga 1 dell\'indirizzo deve avere lunghezza compresa tra 4 e 300 caratteri.'); 
define('FS_CHECKOUT_ERROR13', 'Il tuo nome deve contenere come minimo 2 caratteri.'); 
define('FS_CHECKOUT_ERROR14', 'Il tuo cognome deve contenere come minimo 2 caratteri.'); 
define('FS_CHECKOUT_ERROR15', 'Il tuo CAP deve essere come minimo di 3 caratteri.'); 
define('FS_CHECKOUT_ERROR16', 'Non effettuiamo spedizioni a caselle postali (PO Box).'); 
define('FS_CHECKOUT_ERROR17', 'Il tuo tipo di indirizzo è obbligatorio.'); 
define('FS_CHECKOUT_ERROR18', 'Scegli un indirizzo.'); 
define('FS_CHECKOUT_ERROR19', 'L\'indirizzo selezionato è privo del paese'); 
define('FS_CHECKOUT_ERROR20', 'L\'indirizzo che hai scelto è privo di numero di telefono'); 
define('FS_CHECKOUT_ERROR21', 'Aggiorna il tuo indirizzo di spedizione (compila Tipo di indirizzo e PARTITA IVA/CODICE FISCALE).'); 
define('FS_CHECKOUT_DEFAULT', 'predefinito'); 
define('FS_CHECKOUT_EDIT', 'Modifica'); 
define('FS_CHECK_ACCOUNT', 'Account d\'Express');
define('FS_CHECK_SELF', 'Utilizza il mio indirizzo di consegna come indirizzo di fatturazione');
define("FS_NETWORK_ERROR","Siamo spiacenti, si è verificato un errore di rete.");
define('FS_CHECKOUT_ERROR22', 'Express Account non può essere vuoto');
define('FIBER_CHECK_SPARK', 'Conto Sparkasse Bank:');
define("FS_CHECKOUT_ERROR23",'Ci dispiace, nome e cognome sulla Carta ID è neccessario.');
define("FS_CHECKOUT_ERROR24",'Ci dispiace, il numero telefono è neccessario.');
define("FS_CHECKOUT_ERROR25",'Ci dispiace, l\'ora di ritro è neccessario.');
define("FS_CHECKOUT_ERROR26",'Ci dispiace, l\'indirizzo dell\'email è neccessario.');
define('FS_CHECKOUT_ERROR27', 'Aggiorna il tuo indirizzo di spedizione (compila il CAP).'); 
define('FS_CHECKOUT_ERROR28', 'Inserisci un CAP valido'); 
define('FS_CHECKOUT_NEW1', 'Carrello'); 
define('FS_CHECKOUT_NEW2', 'Pagamento'); 
define('FS_CHECKOUT_NEW3', 'Riuscito'); 
define('FS_CHECKOUT_NEW4', 'Indirizzo di consegna'); 
define('FS_CHECKOUT_NEW6', 'Imposta predefinito'); 
define('FS_CHECKOUT_NEW7', 'Aggiungi nuovo indirizzo'); 
define('FS_CHECKOUT_NEW8', 'Aggiungi nuovo indirizzo di fatturazione'); 
define('FS_CHECKOUT_NEW9', 'Indirizzo di fatturazione'); 
define('FS_CHECKOUT_NEW10', 'aggiungi il tuo indirizzo di fatturazione!'); 
define('FS_CHECKOUT_NEW11', 'Metodo di pagamento'); 
define('FS_CHECKOUT_NEW12', 'Termini di pagamento:'); 
define('FS_CHECKOUT_NEW13', 'Consegna e recensione articoli'); 
define('FS_CHECKOUT_NEW14', 'Scegli un\'opzione di consegna'); 
define('FS_CHECKOUT_NEW15', 'I tuoi articoli'); 
define('FS_CHECKOUT_NEW16', 'Aggiungi commenti sull\'ordine'); 
define('FS_CHECKOUT_NEW17', 'Note del cliente'); 
define('FS_CHECKOUT_NEW18', 'Numero P.O.'); 
define('FS_CHECKOUT_NEW19', 'Comunicaci il n. di modello della tua attrezzatura per assicurarci della compatibilità.'); 
define('FS_CHECKOUT_NEW20', 'Note sulla spedizione'); 
define('FS_CHECKOUT_NEW21', 'Riepilogo ordine'); 
define('FS_CHECKOUT_NEW22', 'Subtotale:'); 
define('FS_CHECKOUT_NEW23', 'Costo di consegna:'); 
define('FS_CHECKOUT_NEW24', 'Il tuo ordine gode di consegna GRATUITA'); 
define('FS_CHECKOUT_NEW25', 'Facendo clic su "Procedi con il pagamento sicuro'); 
define('FS_CHECKOUT_NEW26', 'Termini e condizioni'); 
define('FS_CHECKOUT_NEW27', 'Procedi con il pagamento sicuro'); 
define('FS_CHECKOUT_NEW27_01', 'e'); 
define('FS_CHECKOUT_NEW27_02', 'Diritto di recesso'); 
define('FS_CHECKOUT_NEW27_03', '.');
define("FS_CHECKOUT_NEW28","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH All Rights Reserved.");
define('FS_CHECKOUT_NEW29', 'Continua'); 
define('FS_CHECKOUT_NEW30', 'Modifica carrello '); 
define('FS_CHECKOUT_NEW31', 'PayPal'); 
define('FS_CHECKOUT_NEW32', 'Carta di credito/debito'); 
define('FS_CHECKOUT_NEW33', 'Bonifico bancario'); 
define('FS_CHECKOUT_NEW34', 'Ordine d\'acquisto'); 
define('FS_CHECKOUT_NEW35', ' Bpay'); 
define('FS_CHECKOUT_NEW36', ' eNETS'); 
define('FS_CHECKOUT_NEW37', 'YANDEX'); 
define('FS_CHECKOUT_NEW38', 'WEBMONEY'); 
define('FS_CHECKOUT_NEW39', 'iDEAL'); 
define('FS_CHECKOUT_NEW40', 'SOFORT'); 
define('FS_CHECKOUT_NEW41', 'Totale'); 
define('FS_CHECKOUT_NEW42', ' e '); 
define('FS_CHECKOUT_NEW43', 'Diritto di recesso'); 
define('FS_CHECKOUT_NEW44', '.'); 
define('FIBERSTORE_FIRST_NAME', 'Nome'); 
define('FIBERSTORE_LAST_NAME', 'Cognome'); 
define('FIBERSTORE_COUNTRY', 'Paese o Regione'); 
define('FS_CHECKOUT_ERROR30', 'Il tuo indirizzo e-mail è obbligatorio.'); 
define('FS_CHECKOUT_ERROR31', 'Il tuo indirizzo e-mail non è corretto.'); 
define('FS_CHECKOUT_EXPIRED', 'La tua sessione di login è scaduta?'); 
define('FS_CHECKOUT_EXPIRED_CONFIRM', 'conferma'); 
define('CHECK_SEARCH', 'Cerca');
define('FS_CHECKOUT_ERROR29', 'Modifica il tuo indirizzo (inserisci il CAP valido).'); 
define('FS_CHECKOUT_ERROR35', 'Modifica il tuo indirizzo (seleziona il paese valido).'); 
define('FS_AGAINST_BPAY_01', 'Data dell\'ordine:'); 
define('FS_AGAINST_BPAY_02', 'Importo totale:'); 
define('FS_AGAINST_BPAY_03', 'Il tuo acquisto è stato suddiviso in'); 
define('FS_AGAINST_BPAY_04', 'ordini.'); 
define('FS_AGAINST_BPAY_05', 'Consegna prevista'); 
define('FS_AGAINST_BPAY_06', 'Spedizione da'); 
define('FS_AGAINST_BPAY_07', 'Ordine'); 
define('FS_AGAINST_BPAY_08', 'di'); 
define('FS_AGAINST_BPAY_09', 'Procedi a'); 
define('FS_AGAINST_BPAY_10', 'Sparkasse Freising'); 
define('FS_AGAINST_BPAY_11', 'FS.COM GmbH'); 
define('FS_AGAINST_BPAY_12', 'DE16 7005 1003 0025 6748 88'); 
define('FS_AGAINST_BPAY_13', 'BYLADEM1FSI'); 
define('FS_AGAINST_BPAY_14', '25674888'); 
define('FS_AGAINST_BPAY_15', 'Untere Hauptstr.29'); 
define('FS_AGAINST_BPAY_16', '817-888472-838'); 
define('FS_AGAINST_BPAY_17', 'HSBCHKHHHKH'); 
define('FS_CHECKOUT_ERROR35', 'Modifica il tuo indirizzo (seleziona il paese valido). '); 
define('FS_CART_ITEM', 'Articolo'); 
define('FS_CART_ITEMS', 'Articoli'); 
define('CREDIT_CARD_NUMBER', 'Numero carta'); 
define('CREDIT_CARD_DATE', 'Data di scadenza'); 
define('CREDIT_CARD_CVV', 'CVV'); 
define('CREDIT_CARD_PAY', 'Continua'); 
define('FS_META_PRO_01', 'Spedizione in tutto il mondo per '); 
define('FS_META_PRO_02', ' approfittare di un prezzo eccezionale e di un servizio di massimo livello.'); 
define('FS_CHECKOUT_TIP_01', 'FS.COM ti fornisce vari metodi di pagamento. Per ulteriori dettagli'); 
define('FS_CHECKOUT_TIP_02', 'Metodi di pagamento'); 
define('FS_WAREHOUSE_SEA', 'Magazzino di Seattle'); 
define('FS_WAREHOUSE_DEL', 'Magazzino del Delaware');
define("FS_COMMON_CHECKOUT_HSBC","Dopo essere effettuato il pagamento, generalmente verrà ricevuto da FS entro 1-3 giorni lavorativi. Ci occuperemo dell'ordine una volta confermata la rimessa.");
define("FS_COMMON_CHECKOUT_SUCCESS_ORDER_HSBC","Please remark your FS order number when paying so that your order can be processed timely. Usually funds will be received between 1-3 working days. The stock is not reserved until the remittance is confirmed.");


define('FS_WAREHOUSE_AREA_36', 'Spedizione dal magazzino di Seattle');
define('FS_WAREHOUSE_AREA_37', 'Spedizione dal magazzino del Delaware'); 
define('FS_LIVE_CHAT_CHECKOUT', 'Ottieni aiuto nell\'acquisto.  <a  href="javascript:;" onclick="LC_API.open_chat_window();return false;">Chat dal vivo</a> o chiamaci');
define('FS_NEW_POPUP_01', 'Hai appena aggiunto'); 
define('FS_CART_QTY', 'Qtà:');
define('FS_SHOPPING_CART_NEW_SHARE_CART', 'Condividi il carrello');
define('FS_SHOPPING_CART_NEW_PRINT_CART', 'Stampa il carrello');
define("FS_SHOP_CART_ALERT_JS_77","Visualizza il carrello");
define('FS_CONTINUE_SHOPPING', 'Continua lo shopping'); 
define('FS_NEW_POPUP_04', 'Visualizza carrello'); 
define('FS_CUSTOMERS_ALSO', 'I clienti che hanno acquistato questi prodotti.'); 
define('FIBER_CHECK_ANZ', 'Conto bancario ANZ:');
define('FIBER_CHECK_ACCOUNT', 'Nome Conto:');
define('FIBER_CHECK_PTY', 'FS.COM PTY LTD'); 
define('FIBER_CHECK_BSB', 'BSB:');
define('FIBER_CHECK_013', '013160'); 
define('FIBER_CHECK_ACCOUNT_NO', 'Numero conto:');
define('FIBER_CHECK_4167', '416794959'); 
define('FIBER_CHECK_SWIFT_CODE', 'Codice SWIFT:');
define('FIBER_CHECK_ANZBAU3M', 'ANZBAU3M'); 
define('FIBER_CHECK_BANK', 'Indirizzo banca:');
define('FIBER_CHECK_ST_VIC', '230 Swanston St'); 
define('FIBER_CHECK_TITLE_AU', 'Per pagare tramite deposito diretto'); 
define('FS_CHECKOUT_SUCCESS_06', 'Sparkasse Freising'); 
define('FS_CHECKOUT_SUCCESS_07', 'FS.COM GmbH'); 
define('FS_CHECKOUT_SUCCESS_08', 'DE16 7005 1003 0025 6748 88'); 
define('FS_CHECKOUT_SUCCESS_09', 'BYLADEM1FSI'); 
define('FS_CHECKOUT_SUCCESS_10', '25674888'); 
define('FS_CHECKOUT_SUCCESS_11', 'Untere Hauptstr.29'); 
define('FS_SUCCESS_YOUR_NEXT', 'Il tuo passo successivo è completare il pagamento con bonifico bancario e inviare i dettagli del tuo pagamento.'); 
define('FS_SUCCESS_WIRE', 'Bonifico bancario'); 
define('FS_SUCCESS_ORDER', 'Stampa dell\'ordine'); 
define('FS_SUCCESS_DETAIL', 'Dettagli beneficiario bonifico bancario'); 
define('FS_SUCCESS_BANK_NAME', 'Nome banca beneficiario:');
define('FS_SUCCESS_HSBC', 'HSBC Hong Kong'); 
define('FS_SUCCESS_AC_NAME', 'Nome C/C beneficiario:');
define('FS_SUCCESS_CO', 'FS.COM LIMITED'); 
define('FS_SUCCESS_AC_NO', 'N. C/C beneficiario:');
define('FS_SUCCESS_TEL', '817-888472-838'); 
define('FS_SUCCESS_SWIFT', 'Indirizzo SWIFT:');
define('FS_SUCCESS_HK', 'HSBCHKHHHKH'); 
define('FS_SUCCESS_BANK_ADRESS', 'Indirizzo banca beneficiario:');
define('FS_SUCCESS_ROAD', '1 Queen\'s Road Central'); 
define('FS_SUCCESS_OUR', 'Indirizzo della nostra società'); 
define('FS_SUCCESS_NO', 'Eastern Side'); 
define('FS_LOGIN_THIRD1', 'GENTILE'); 
define('FS_LOGIN_THIRD2', 'utente'); 
define('FS_LOGIN_THIRD3', ''); 
define('FS_LOGIN_THIRD4', 'Abbiamo riscontrato che è già stato registrato un account FS.COM con lo stesso indirizzo e-mail. Colleghiamo il tuo account FS.COM per meglio gestire i tuoi dati personali e le tue preferenze. Se non sei a conoscenza di questo account FS.COM'); 
define('FS_LOGIN_THIRD5', ' Reindirizzato al tuo account FS.COM in '); 
define('FS_LOGIN_THIRD6', 's'); 
define('REDIRECT_DEAR', 'Gentile '); 
define('REDIRECT_USER', ' utente '); 
define('REDIRECT_WELCOME', ' benvenuto'); 
define('REDIRECT_NOTICE', 'Hai registrato un account FS con lo stesso indirizzo <br>e-mail. Per fornire la migliore esperienza sulla gestione dell\'account'); 
define('REDIRECT_ACCOUNT', 'Reindirizza in '); 
define('FS_PLEASE_SELECT', 'Seleziona...'); 
define('FS_JUST_ADD', 'Hai appena aggiunto'); 
define('FS_POPUP_ITEM', 'articolo'); 
define('FS_COUNTINUE_SHOPPING', 'Continua lo shopping'); 
define('FS_PRODUCT_SHIPPING', 'Spedizione'); 
define('FS_PRODUCT_RETURNS', 'Resi'); 
define('FS_PRODUCT_LIVE_CHAT', 'Chat dal vivo'); 
define('FS_PRODUCT_EXPERT', 'Chiedi al nostro esperto:'); 
define('FS_PRODUCT_QUESTIONS', 'Domande'); 
define('FS_PRODUCT_QUESTION', 'Domanda'); 
define('FS_REVIEWS_PLACE', 'Scrivi i tuoi commenti...'); 
define('FS_REVIEWS_BY', 'Di'); 
define('FS_REPLY_REVIEWS', 'Visualizzazione di 1 commento'); 
define('FS_PRODUCT_CART_POPUP', 'I clienti che hanno acquistato questi prodotti'); 
define('FS_REVIEWS_REPORT', 'Report'); 
define('FS_PICK_UP_AT_WAREHOUSE', ' Ritiro presso nel nostro magazzino ');
define('FS_TIME_ZONE_RULE_US_ES', '(EST)'); 
define('FS_TIME_ZONE_ADDRESS_US', '<p class=\'pick_title\'>Magazzino FS di Seattle:</p><p>820 SW 34th Street Bldg W7 Suite H<br>Renton'); 
define('FS_TIME_ZONE_ADDRESS_US_ES', '<p class=\'pick_title\'>Magazzino FS Delaware:</p><p>380 Centerpoint Blvd<br>New Castle'); 
define('FS_ITEMS_CK', 'articoli'); 
define('FS_TIME_ZONE_RULE_AU', '(AEST)'); 
define('FS_JS_TIT_CHECK_AU', '10:00 - 17:30 '); 
define('FS_UNITED', 'Stati Uniti'); 
define('FS_AUSTRALIA', 'Australia'); 
define('FS_GERMANY', 'Germania'); 
define('FS_CHECKOUT_GUEST_LOG_MSG', 'L\'indirizzo e-mail esiste nel nostro sistema'); 
define('FS_PRODUCT_INFO_SIZE', 'Dimensione'); 
define('FS_PRODUCT_INFO_PIECE', 'Ordine per pezzo'); 
define('FS_PRODUCT_INFO_CASE', 'Ordine per confezione ('); 
define('FS_PRODUCT_INFO_PIS', 'pz./cf.)'); 
define('FS_PRODUCT_INFO_PIS_1', 'pezzi/'); 
define('FS_PRODUCT_PRICE_EA', '/cd'); 
define('FS_PRODUCTS_INFO_VAT_05', 'Info sull\'imposta IVA'); 
define('FS_PRODUCTS_INFO_VAT_01', 'Tutti gli ordini con destinazione presso un paese dell\'Unione Europea vengono spediti dal nostro magazzino principale di Monaco di Baviera'); 
define('FS_PRODUCTS_INFO_VAT_02', 'Esente IVA'); 
define('FS_PRODUCTS_INFO_VAT_03', 'Gli ordini consegnati nei paesi dell\'UE (tranne la Germania) sono esenti IVA');
define('FS_LIVE_CHAT_MAIL','Thank you for contacting <a href="'.zen_href_link('index','','SSL').'">FS.COM</a>, this is a confirmation email to let you know that your request for support has been received.We will review your message and get back to you within 12 hours.');
define('FS_LIVE_CHAT_MAIL_1', 'FS.COM-Conferma messaggio e-mail'); 
define('FS_LIVE_CHAT_MAIL_2', 'Il tuo tipo di servizio:'); 
define('FS_LIVE_CHAT_MAIL_3', 'Il tuo messaggio:'); 
define('FS_OVERNIGHT_TITLE', 'L\'ordine pagato dopo l\'orario di fine lavoro del magazzino (Delaware 17:00 EST) sarà spedito il giorno lavorativo successivo.'); 
define('FS_OVERNIGHT_TITLE_UP', 'L\'ordine pagato dopo l\'orario di fine lavoro del magazzino (Delaware 17:00) sarà spedito il giorno lavorativo successivo.'); 
define('CHECKOUT_TAX_NZ_CONTENT', 'Per gli ordini consegnati a destinazioni al di fuori dell\'Australia'); 
define('FS_TIME_ZONE_ADDRESS_AU', '<p class=\'pick_title\'>Magazzino FS Melbourne:</p><p>57-59 Edison Rd'); 
define('FS_RELATED_EMAIL_TITLE', 'Condividi le notizie sulla spedizione dell\'ordine'); 
define('FS_RELATED_EMAIL_DESPRECTION', 'L\'avviso di spedizione sarà inviato all\'e-mail da cui è stato effettuato l\'ordine (per impostazione predefinita e l\'e-mail immessa).'); 
define('FS_RELATED_EMAIL_ERROR', 'Inserisci un indirizzo e-mail valido'); 
define('FS_RELATED_EMAIl', 'Indirizzo e-mail'); 
define('FS_RELATED_NAME', 'Nome dell\'amico'); 
define('FS_CHECKOUT_VAX_CH', 'Inserisci un numero di Partita IVA valido, es.: 00.000.000-0.');
define('FS_CHECKOUT_VAX_AR', 'Inserisci un numero di Partita IVA valido, es.: 00-00000000-0.'); 
define('FS_CHECKOUT_VAX_BR_BS', 'Inserisci un numero di Partita IVA valido, es.: 00.000.000/0000-00.'); 
define('FS_CHECKOUT_VAX_BR_IN', 'Inserisci un numero di Partita IVA valido, es.: 000.000.000/00.'); 
define('FS_TAXT_TITLE_NOTICE', 'Il tuo ordine può essere esente IVA fornendo una partita IVA valida e corretta.');

define('FS_TAXT_TITLE_NOTICE_OTHER', 'Per accelerare lo sdoganamento, si prega di inserire un numero di identificazione fiscale valido.');
define('FS_EMAIL_PAUSE',',&nbsp;');

define('FS_NO_FREE_SHIPPING_US_HEAVY', 'L\'ordine contenente articoli pesanti o sovradimensionati non può godere di spedizione gratuita.'); 
define('FS_NO_FREE_SHIPPING_DEAU_HEAVY', 'L\'ordine contenente articoli pesanti o sovradimensionati non può godere di consegna gratuita.'); 
define('FS_NO_FREE_SHIPPING_AU_REMOTE', 'Quest\'ordine viene consegnato al distretto remoto, perciò saranno sostenute spese di spedizione.'); 
define('EMAIL_OVER79_FREE_DELIVERY', '<tr><td style="font-size:12px;font-weight: 400;padding-top: 35px;">Gli ordini di articoli idonei oltre %s possono godere di consegna gratuita. Speriamo di rivederti presto.</td></tr>'); 
define('FS_TRACK_ORDER', 'Puoi tenere traccia dello stato dell\'ordine facendo clic su'); 
define('FS_TRACK_MY_ORDERS', 'I miei ordini'); 
define('FS_ORDER_COMMENTS', 'Commenti sull\'ordine:'); 
define('FS_TRACK_PO_ORDER', 'Puoi tracciare lo stato in'); 
define('FS_TRACK_ACCOUNT_CENTER', 'centro account'); 
define('FS_SURBSTREET_MAXLENGTH_ERROR', 'L\'indirizzo linea 2 deve contenere un massimo di 35 caratteri.'); 
define('FS_TELEPHONE_MAXLENGTH_ERROR', 'Il numero di telefono deve contenere al massimo 15 caratteri.'); 
define('FS_COMPANY_MAXLENGTH_ERROR', 'Company Name must be between 1 and 100 characters long.');
define('FS_FIRSTNAME_MAXLENGTH_ERROR', 'Il nome deve contenere al massimo 35 caratteri.'); 
define('FS_LASTNAME_MAXLENGTH_ERROR', 'Il cognome deve contenere al massimo 35 caratteri.'); 
define('FS_PRICE_EXCL_VAT', ' (IVA esclusa)');
define('FS_PRICE_INCL_VAT', ' (IVA inclusa)');
define('FS_PRODUCTS_REORDERING', 'Riordino'); 
define('FS_FOR_FREE_SHIPPING_GET_AROUND', 'Risolvi il problema'); 
define('FS_CHOOSE_LOCATION', 'Scegli la tua posizione'); 
define('FS_DELIVERY_OPTION', 'Le opzioni di consegna e la rapidità di consegna possono variare secondo le diverse località'); 
define('FS_SHIP_OUTSIDE', 'Spedizione al di fuori '); 
define('FS_SHIP_CONTINUE_SEE', 'Vedrai gli esatti costi di spedizione e le date di arrivo al momento del pagamento.'); 
define('FS_SHIP_DONE', 'Fatto'); 
define('FS_REDIRECT_PART1', 'Continua lo shopping su '); 
define('FS_REDIRECT_PART2', ' e controllare il contenuto specifico con prezzo locale e consegna?'); 
define('FS_SHIP_TO', 'Spedizione a'); 
define('FS_SHIP_CHANGE', 'Cambia'); 
define('FS_SHIP_OR', 'o'); 
define('FS_SHIP_OR_OTHER', 'o modifica il paese'); 
define('FS_SHIP_ENTER', 'o inserisci un '); 
define('FS_SHIP_ZIP_CODE', ' CAP'); 
define('FS_SHIP_APPLY', ' Applica'); 
define('FS_SHIP_ADD_NEW_ADDRESS', 'Aggiungi un nuovo indirizzo');
define("FS_SHIP_SIGN_IN",'<a href="'.zen_href_link("login","","SSL").'"> Accedi</a> per vedere i suoi indirizzi');
define('FS_SHIP_MANAGE', 'Gestisci la rubrica');
define("FS_SHIP_TODAY","Spediamo oggi");
define('FS_PRODUCTS_POST_CODE_EMPTY_INVALID', 'Inserisci un CAP valido.'); 
define('FS_PRODUCTS_CUSTOMIZE', 'Personalizza'); 
define('SEARCH_OFFINE_7', 'Siamo spiacenti, questa pagina web non è stata trovata');
define('SEARCH_OFFINE_8', 'Potrebbe essere perché:'); 
define('SEARCH_OFFINE_9', 'La pagina non esiste più o è stata spostata su un indirizzo diverso'); 
define('SEARCH_OFFINE_10', 'L\'indirizzo Web è stato digitato in modo errato');
define('SEARCH_OFFINE_11','Controllare l\'URL, o andare alla <a href="'.zen_href_link(FILENAME_DEFAULT,'','NONSSL').'">Home</a>.');
define('SEARCH_OFFINE_12', 'homepage.'); 
define('FS_SHIP_LIST_COUNTRY', 'Paese/Regione'); 
define('FS_SHIP_LIST_POST', 'CAP'); 
define('FS_SHIP_DELIVEY_TO', 'Consegna in');
define('FS_CN_HUBEI', 'Wuhan'); 
define('FS_CN_APAC', 'Magazzino asiatico'); 
define('FS_DE_MUNICH', 'Monaco'); 
define('FS_AU_VIC', 'Melbourne'); 
define('FS_US_WA', 'Washington/Delaware'); 
define('FS_FOR_FREE_SHIPPING_GET_ARRIVE', 'Ricevilo entro'); 
define('FS_APAC_NOTICE', 'Il magazzino FS asiatico supporta le spedizioni globali nello stesso giorno verso il Sud America'); 
define('FS_US_NOTICE', 'Magazzini FS statunitensi ubicati rispettivamente a Seattle & nel Delaware'); 
define('FS_US_OTHER_NOTICE', 'Magazzini FS statunitensi ubicati rispettivamente a Seattle & nel Delaware');
define("FS_DE_NOTICE","Il deposito DE FS situato a Monaco di Baviera può provvedere una spedizione veloce. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define("FS_DE_OTHER_NOTICE","Il deposito FS DE, situato a Monaco di Baviera, è in grado di provvedere spedizioni globali verso Regno Unito, UE e altri paesi europei. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_AU_OTHER_NOTICE', 'Magazzino FS AU'); 
define('FS_PRODUCTS_POST_CODE_EMPTY_ERROR', 'Il tuo CAP è obbligatorio'); 
define('FS_NZ_OTHER_NOTICE', 'Magazzino FS AU'); 
define('FS_CN_NOTICE', 'Magazzino FS asiatico ubicato a Wuhan'); 
define('FS_NO_QTY_NOTICE', 'Gli articoli vengono accelerati per il transito dal magazzino globale.'); 
define('FS_NO_QTY_TAG_NOTICE', 'Gli articoli vengono preparati per il transito dal magazzino globale.'); 
define('FS_NO_QTY_TAG_NOTICE_NEW', 'Gli articoli sono in preparazione per il transito dal magazzino asiatico.'); 
define('FS_NO_QTY_NOTICE_NEW', 'Gli articoli sono in transito dal magazzino asiatico.'); 
define('FS_FORWARD_SHIPPING', 'Spedizione dello spedizioniere (con dazi & imposte prepagati)'); 
define('FS_FORWARD_SHIPPING_NOTICE', 'Il prezzo indicato comprende il costo di spedizione'); 
define('FIBER_CHECK_COMMON_ACCOUNT', 'Numero del conto:'); 
define('FIBER_CHECK_COMMON_CODE', 'Numero del codice bancario:'); 
define('FIBER_CHECK_COMMON_IBAN', 'IBAN:'); 
define('FIBER_CHECK_COMMON_BIC', 'BIC:'); 
define('FIBER_CHECK_DO_TITLE', 'Conto in $ USA'); 
define('FIBER_CHECK_DO_ACCOUNT_VALUE', '0902543668'); 
define('FIBER_CHECK_DO_CODE_VALUE', '590 100 66'); 
define('FIBER_CHECK_DO_IBAN_VALUE', 'DE98 5901 0066 0902 5436 68'); 
define('FIBER_CHECK_DO_BIC_VALUE', 'PBNKDEFF590'); 
define('FIBER_CHECK_GB_TITLE', 'Sterlina britannica GBP'); 
define('FIBER_CHECK_GB_ACCOUNT_VALUE', '0902544661'); 
define('FIBER_CHECK_GB_CODE_VALUE', '590 100 66'); 
define('FIBER_CHECK_GB_IBAN_VALUE', 'DE59 5901 0066 0902 5446 61'); 
define('FIBER_CHECK_GB_BIC_VALUE', 'PBNKDEFF590'); 
define('FIBER_CHECK_CH_TITLE', 'Franco svizzero CHF'); 
define('FIBER_CHECK_CH_ACCOUNT_VALUE', '0902545664'); 
define('FIBER_CHECK_CH_CODE_VALUE', '590 100 66'); 
define('FIBER_CHECK_CH_IBAN_VALUE', 'DE41 5901 0066 0902 5456 64'); 
define('FIBER_CHECK_CH_BIC_VALUE', 'PBNKDEFF590'); 
define('FIBER_CHECK_POST_TITLE', 'Conto Postbank'); 
define('FIBER_CHECK_COMMON_ACCOUNT_NAME', 'Nome conto:'); 
define('FIBER_CHECK_COMMON_BANK', 'Nome banca:'); 
define('FIBER_CHECK_COMMON_ADDRESS', 'Indirizzo banca:'); 
define('FIBER_CHECK_COMMON_ACCOUNT_NAME_VALUE', 'FS.COM GmbH'); 
define('FIBER_CHECK_COMMON_BANK_VALUE', 'Postbank'); 
define('FIBER_CHECK_COMMON_CODE_ADDRESS_VALUE', 'Eckenheimer Landstr.242 60320 Frankfurt'); 
define('SEND_MAIL_1', 'Consegna GRATUITA oltre £ 79'); 
define('SEND_MAIL_2', 'Fiberstore Ltd'); 
define('SEND_MAIL_3', 'Spedizione GRATUITA oltre $ 79'); 
define('SEND_MAIL_4', 'FS.COM INC'); 
define('SEND_MAIL_5', 'Consegna GRATUITA oltre € 79'); 
define('SEND_MAIL_6', 'GmbH'); 
define('SEND_MAIL_7', 'Consegna GRATUITA oltre A$ 99'); 
define('SEND_MAIL_8', 'FS.COM Pty Ltd'); 
define('SEND_MAIL_9', 'Spedizione lo stesso giorno sugli articoli a magazzino'); 
define('SEND_MAIL_10', 'FS.COM Limited Room 2702'); 
define('MANAGE_ORDER_RESTORE_1', 'Termina tra 0 h'); 
define('MANAGE_ORDER_RESTORE_2', 'Termina tra'); 
define('MANAGE_ORDER_RESTORE_3', 'Completa il pagamento entro 30 minuti'); 
define('MANAGE_ORDER_RESTORE_4', 'Acquista di nuovo'); 
define('MANAGE_ORDER_RESTORE_5', 'Carica il tuo ordine di acquisto entro 7 giorni'); 
define('MANAGE_ORDER_RESTORE_6', 'Completa il pagamento entro 2 giorni'); 
define('MANAGE_ORDER_RESTORE_7', 'Completa il pagamento entro 7 giorni'); 
define('FS_INQUIRY_CANCELED', 'Annullato'); 
define('FIBER_CHECK_ANZ_UK', 'Conto bancario HSBC'); 
define('FS_SUCCESS_BANK_NAME_UK', 'Nome banca beneficiario'); 
define('FS_SUCCESS_HSBC_UK', 'HSBC Hong Kong'); 
define('FS_SUCCESS_AC_NAME_UK', 'Nome C/C beneficiario'); 
define('FS_SUCCESS_CO_UK', 'FS.COM LIMITED'); 
define('FS_SUCCESS_AC_NO_UK', 'N. C/C beneficiario'); 
define('FS_SUCCESS_TEL_UK', '817-888472-838'); 
define('FS_SUCCESS_SWIFT_UK', 'Indirizzo SWIFT'); 
define('FS_SUCCESS_HK_UK', 'HSBCHKHHHKH'); 
define('FS_SUCCESS_BANK_ADRESS_UK', 'Indirizzo banca beneficiario'); 
define('FS_SUCCESS_ROAD_UK', '1 Queen\'s Road Central'); 
define('FS_SUCCESS_OUR', 'Indirizzo della nostra società'); 
define('FS_SUCCESS_NO', 'Eastern Side'); 
define('FS_ADDED_ONE_ITEM', 'Hai appena aggiunto [ADDITEM] articolo.'); 
define('FS_ADDED_MORE_ITEM', 'Hai appena aggiunto [ADDITEM] articoli.'); 
define('FS_ADDED_TO_CART', 'Aggiunto al carrello'); 
define('FS_EMAIL_COMMA', ''); 
define('FS_EMAIL_POINT', '.'); 
define('FS_EMAIL_PERIOD', '.'); 
define('FS_PRINT_ORDER_TEL', 'Tel.:'); 
define('FS_PRINT_ORDER_NUM', 'Numero IVA:'); 
define('FS_PRINT_ORDER_CREDIT', 'Carta di credito/debito'); 
define('FS_PRINT_ORDER_PURCHASE', 'Ordine d\'acquisto'); 
define('FS_PRINT_ORDER_BANK', 'Bonifico bancario'); 
define('FS_PRINT_ORDER_WESTERN', 'Western Union'); 
define('FS_PRINT_ORDER_FREE', 'Gratis'); 
define('FS_CREDIT_CARD_NUMBER', 'Numero carta'); 
define('FS_CREDIT_EXPIRY_DATE', 'Data di scadenza'); 
define('FS_CREDIT_CONTINUE', 'Continua'); 
define('FS_SHARE_AGAIN', 'Condividi di nuovo'); 
define('FS_MANAGE_ORDERS_PUR', 'Numero ordine di acquisto'); 
define('FS_PAGE_NOT_FOUND', 'Pagina non trovata'); 
define('FS_CUSTOMILIZED_ADD_TO_CART', 'Aggiungi al carrello'); 
define('FS_EMAIL_ERROR', 'Il tuo indirizzo e-mail non è corretto'); 
define('FS_TOTAL_SAVINGS', 'Totale risparmi'); 
define('FS_CANCEL_ORDER', 'Il tuo ordine n.'); 
define('FS_CANCEL_ORDER_1', 'è stato annullato'); 
define('FS_CANCEL_ORDER_2', 'Come da te richiesto'); 
define('FS_CANCEL_ORDER_3', '. Ci spiace che la cosa non sia andata a buon fine, speriamo di rivederti presto a fare shopping con noi.'); 
define('FS_CANCEL_ORDER_4', 'Per qualsiasi domanda'); 
define('FS_CANCEL_ORDER_5', 'Indirizzo e-mail del cliente:'); 
define('FS_CANCEL_ORDER_6', 'Numero d\'ordine: '); 
define('FS_CANCEL_ORDER_7', 'Motivo:*'); 
define('FS_CANCEL_ORDER_8', 'Ordine n.'); 
define('FS_QUSTI', 'Domanda'); 
define('FS_PRODUCTS_JS_MOQ', 'Per questo articolo il MOQ è'); 
define('FS_PRODUCTS_JS_UPPER', 'NESSUN limite superiore'); 
define('FS_EMAIL', 'eu@fs.com'); 
define('FS_PAY_WAY_PAYPAL', 'PayPal'); 
define('FS_PRODUCT_INFO_STEP', 'fase'); 
define('FS_REVIEWS_COMMENT_DEACRIPTION', 'Devi essere connesso oppure devi creare un account per poter lasciare commenti');
define('FS_CATEGORIES_01', 'Tipo di Prodotto');
define('FS_CATEGORIES_02', 'Classificazione prodotto'); 
define('FS_CATEGORIES_03', 'Tipo strumento'); 
define('FS_CATEGORIES_04', 'Tipo convertitori multimediali'); 
define('FS_CATEGORIES_05', 'Tipo cavo'); 
define('FS_CATEGORIES_06', 'Tipo switch KVM'); 
define('FS_CATEGORIES_07', 'Tipo convertitori video');
define('FS_CATEGORIES_08','Applicazione');
define('FS_ECHECK_NOTICE', '* Accettiamo solo assegni elettronici emessi da banche statunitensi. Ci vorrebbe 1-2 giorni lavorativi per elaborare il fondo.');
define('FS_ECHECK_BANK_ACCOUNT', 'Nome conto bancario'); 
define('FS_ECHECK_BANK_ACCOUNT_NUMBER', 'Numero conto bancario'); 
define('FS_ECHECK_BANK_ACCOUNT_TYPE', 'Tipo conto'); 
define('FS_ECHECK_BANK_ACCOUNT_CHECK', 'Controllo in corso'); 
define('FS_ECHECK_BANK_ACCOUNT_SAVE', 'Salvataggio in corso'); 
define('FS_ECHECK_BANK_ACCOUNT_CONFIRM', 'Conferma numero del conto bancario'); 
define('FS_ECHECK_BANK_ACCOUNT_ROUTE', 'Numero routing ABA/ACH'); 
define('FS_ECHECK_ERROR_1', 'Il nome del conto bancario è obbligatorio.'); 
define('FS_ECHECK_ERROR_2', 'Il numero del conto bancario è obbligatorio.'); 
define('FS_ECHECK_ERROR_3', 'Il tipo di conto è obbligatorio.'); 
define('FS_ECHECK_ERROR_4', 'La conferma del numero del conto bancario è obbligatoria.'); 
define('FS_ECHECK_ERROR_5', 'Il numero di routing ABA/ACH della banca è obbligatorio.'); 
define('FS_PRODUCTS_PICK_UP', 'Ritiro gratis'); 
define('FS_PRODUCTS_VIA', 'tramite');
define('FS_PRODUCT_OFF_TEXT','Spiacenti, l\'articolo è stato rimosso e non è più disponibile per l\'acquisto.');
define('FS_PRODUCT_OFF_TEXT_2','Siamo spiacenti, i seguenti articoli potrebbero essere stati rimossi e non saranno più disponibili per l\'acquisto su FS.COM.');
define('FS_PRODUCT_OFF_TEXT_3', 'Seleziona attributi'); 
define('FS_PRODUCT_OFF_TEXT_4', 'Gli attributi dei seguenti articoli personalizzati sono cambiati'); 
define('FS_PRODUCT_OFF_TEXT_5', '*Alcuni degli articoli di quest\'ordine non possono essere aggiunti al carrello della spesa.'); 
define('FS_PRODUCT_OFF_TEXT_6', 'Il tuo ordine contiene articoli non disponibili'); 
define('FS_PRODUCT_OFF_TEXT_7', 'Gli articoli sottostanti non sono più disponibili e non saranno calcolati nel prezzo totale durante il pagamento.');
define('FS_PRODUCT_OFF_TEXT_8','Un articolo nel tuo carrello non è disponibile. Non verrà visualizzato quando si procede al pagamento.');
define('FS_PRODUCT_OFF_TEXT_9','Gli articoli nel tuo carrello non sono disponibili. Non sarà visibile quando si procede al pagamento.');

define('FS_NEW_SHIPPING_FREE', 'Quest\'ordine gode di consegna gratuita!');
define('FS_GO_SHOPPING', 'Continua con gli acquisti');
define('FS_ENTERPRISE_NETWORK', 'Rete enterprise'); 
define('FS_OTN_SOLUTION', 'Soluzione OTN'); 
define('FS_DATA_CENTER_SOLUTION', 'Soluzione per data center'); 
define('FS_OEM_SOLUTION', 'Soluzione OEM'); 
define('FS_RECENTLY_VIEWED', 'Visti di recente');
define('FS_CART_TIP','Hai un account FS? <a target="_blank" href="'.zen_href_link('login','','SSL').'" class="cart_no_23Link">Accedi</a> per vedere gli elementi che hai aggiunto o aggiungere qualcosa di nuovo.');
define('FS_ADDED_TO_CART', 'Aggiunto al carrello'); 
define('FS_REMOVED', 'Rimuovi'); 
define('FS_SHOP_CART_MOVE', 'Sposta nel carrello'); 
define('FS_SHOP_CART_SAVE', 'Salva per dopo.'); 
define('FS_SHOP_CART_SIMILAR', 'Visualizza simile'); 
define('FS_SHOP_CART_SAVED', 'Salva per dopo.'); 
define('FS_CART_EMPTY', 'Il tuo carrello è vuoto.'); 
define('FS_SVAE_FOR_LATER_TIP', 'è stato salvato per dopo.'); 
define('FS_MOVE_TO_CART_TIP', 'è stato spostato nel carrello.'); 
define('FS_DELETE_FOR_LATER', 'Elimina Salva per dopo'); 
define('FS_DELETE_SURE_SAVE', 'Sei sicuro di voler eliminare il prodotto Salva per dopo?'); 
define('FS_DELETE_SURE', 'Sei sicuro di voler eliminare'); 
define('FS_DELETE_CART_TITLE', 'Elimina carrello salvato'); 
define('FS_SYMBOL', ''); 
define('FS_SHOP_CART_ALERT_JS_43', 'Il tuo nome non può essere vuoto.'); 
define('FS_SHOP_CART_ALERT_JS_43_01', 'Il nome del destinatario può essere vuoto.'); 
define('FS_SHOP_CART_ALERT_JS_44', 'La tua e-mail non può essere vuota.'); 
define('FS_SHOP_CART_ALERT_JS_44_01', 'L\'e-mail del destinatario non deve essere vuota.'); 
define('FS_SHOP_CART_ALERT_JS_45', 'Inserisci un indirizzo e-mail valido.'); 
define('FS_SHOP_CART_ALERT_JS_46', 'Invia a gestore di account');
define('FS_SHOP_CART_ALERT_JS_76_1', 'Invia e-mail'); 
define('FS_PLACEHOLDER', 'Consentiti al massimo 500 caratteri.'); 
define('FS_PURCHASE_NUMBER', 'Numero ordine d\'acquisto'); 
define('FS_COLOR_RED', 'Rosso'); 
define('FS_COLOR_BLUR', 'Blu'); 
define('FS_COLOR_GREEN', 'Verde'); 
define('FS_MANAGE_ORDERS_1', 'Le informazioni seguenti sono per l\'utente finale o per l\'operatore dello switch. Sono essenziali per fornire i servizi di supporto tecnico. Accertati che tutte le informazioni siano corrette e aggiornate.'); 
define('FS_MANAGE_ORDERS_2', 'Domanda inviata'); 
define('FS_MANAGE_ORDERS_3', 'Chiave di licenza:'); 
define('FS_MANAGE_ORDERS_4', 'Procedura:'); 
define('FS_MANAGE_ORDERS_5', 'Chiave di licenza ricevuta:'); 
define('FS_MANAGE_ORDERS_6', 'Attivazione completata'); 
define('FS_MANAGE_ORDERS_7', 'Informazioni inviate correttamente Ti invieremo a breve un\'e-mail contenente la chiave di licenza per l\'attivazione dello switch.'); 
define('FS_MANAGE_ORDERS_8', 'Swith Cumulus serie N'); 
define('FS_MANAGE_ORDERS_9', 'Chiave di licenza degli switch Cumulus serie N'); 
define('FS_MANAGE_ORDERS_10', 'Gentile ');
define('FS_MANAGE_ORDERS_11', 'La tua chiave di licenza è'); 
define('FS_MANAGE_ORDERS_12', 'Nota: Saranno necessari circa 3 giorni per verificare la chiave di licenza. Dopo che la verifica è stata completata'); 
define('FS_MANAGE_ORDERS_13', '1 Utilizzo e limitazioni della licenza'); 
define('FS_MANAGE_ORDERS_14', 'La chiave di licenza sarà a lungo termine ed effettiva.'); 
define('FS_MANAGE_ORDERS_15', 'Potrai usufruire di 1 anno e 45 giorni di supporto tecnico dalla data di attivazione (il servizio gratuito supplementare scade se non utilizzato entro 45 giorni).'); 
define('FS_MANAGE_ORDERS_16', 'Una volta scaduto il servizio'); 
define('FS_MANAGE_ORDERS_17', '2 Processo di importazione della chiave di licenza'); 
define('FS_MANAGE_ORDERS_18', 'Verifica le risorse seguenti per l\'importazione della licenza:'); 
define('FS_MANAGE_ORDERS_19', 'Ti invitiamo a contattarci per qualsiasi domanda durante l\'utilizzo della licenza o se desideri estendere i servizi di supporto tecnico. Le nostre informazioni di contatto sono le seguenti:'); 
define('FS_MANAGE_ORDERS_20', 'E-mail:'); 
define('FS_MANAGE_ORDERS_22', '+1 (888 468 7419 (EST)'); 
define('FS_MANAGE_ORDERS_23', 'Accertati di conservare la chiave di licenza in un luogo sicuro e importala nello switch quando necessario.');
define('FS_MANAGE_ORDERS_24', 'Cordialmente'); 
define('FS_MANAGE_ORDERS_25', 'Team tecnico FS.COM'); 
define('FS_MANAGE_ORDERS_26', 'Video:');
define('FS_MANAGE_ORDERS_26_1', 'Video');
define('FS_MANAGE_ORDERS_27', 'PDF:'); 
define('FS_MANAGE_ORDERS_28', 'Telefono:'); 
define('FS_MANAGE_ORDERS_29', 'Spedizione GRATUITA oltre $ 79'); 
define('FS_MANAGE_ORDERS_30', 'Ottieni chiave di licenza'); 
define('FS_MANAGE_ORDERS_31', 'Gentile ');
define('FS_MANAGE_ORDERS_32', 'Ecco la tua chiave di licenza:'); 
define('FS_MANAGE_ORDERS_33', 'Leaf (10G/25G): 556688 <br '); 
define('FS_MANAGE_ORDERS_34', 'Nota:'); 
define('FS_MANAGE_ORDERS_35', '1 La chiave di licenza sarà a lungo termine ed effettiva. Accertati di conservare la chiave di licenza in un luogo sicuro. Saranno necessari circa 3 giorni per verificare la chiave di licenza.'); 
define('FS_MANAGE_ORDERS_36', '2 Una volta completato'); 
define('FS_MANAGE_ORDERS_37', 'Come importare una chiave di licenza'); 
define('FS_MANAGE_ORDERS_38', 'Verifica le risorse seguenti di assistenza:'); 
define('FS_MANAGE_ORDERS_39', 'Ti invitiamo a contattarci per qualsiasi domanda durante l\'utilizzo della licenza o se desideri estendere i servizi di supporto tecnico. Le nostre informazioni di contatto sono le seguenti:'); 
define('FS_MANAGE_ORDERS_40', 'E-mail: <a style="text-decoration: none;color: #333333;">tech@fs.com</a> <br '); 
define('FS_MANAGE_ORDERS_41', 'Cordialmente'); 
define('FS_MANAGE_ORDERS_42', 'Team tecnico FS.COM'); 
define('FS_MANAGE_ORDERS_43', 'Il nome della tua società è obbligatorio'); 
define('FS_MANAGE_ORDERS_44', 'Il tuo nome è obbligatorio'); 
define('FS_MANAGE_ORDERS_45', 'Il tuo numero di telefono è obbligatorio'); 
define('FS_MANAGE_ORDERS_46', 'Il tuo indirizzo e-mail è obbligatorio'); 
define('FS_MANAGE_ORDERS_47', 'L\'indirizzo e-mail che hai inserito non è riconosciuto (esempio: qualcuno@esempio.com).'); 
define('FS_MANAGE_ORDERS_48', 'Fai clic sul pulsante di accettazione del contratto EULA'); 
define('FS_MANAGE_ORDERS_49', 'Il tuo indirizzo Web è obbligatorio'); 
define('FS_MANAGE_ORDERS_50', 'Questo messaggio è stato inviato a'); 
define('FS_MANAGE_ORDERS_51', 'Spedizione gratuita: Si applicano alcune esclusioni.'); 
define('FS_MANAGE_ORDERS_52', 'Leggi altro sul nostro'); 
define('FS_MANAGE_ORDERS_53', 'politica sulle spedizioni'); 
define('FS_MANAGE_ORDERS_54', '<a style="text-decoration: none;color: #333333;">FS.COM</a> Inc.'); 
define('CULUMS_OFF1', 'Richiedi l\'attivazione'); 
define('CULUMS_OFF2', 'Le informazioni seguenti sono per l\'utente finale o per l\'operatore dello switch. Sono essenziali per fornire i servizi di supporto tecnico. Accertati che tutte le informazioni siano corrette e aggiornate. '); 
define('CULUMS_OFF3', 'Nome della società'); 
define('CULUMS_OFF4', 'Nome utente'); 
define('CULUMS_OFF5', 'Telefono'); 
define('CULUMS_OFF6', 'Indirizzo e-mail'); 
define('CULUMS_OFF7', 'Indirizzo Web'); 
define('CULUMS_OFF8', 'Accordo EULA.'); 
define('CULUMS_OFF9', 'Cumulus Networks®'); 
define('CULUMS_OFF11', 'Accordo di licenza software dell\'utente finale'); 
define('CULUMS_OFF12', 'Questi termini di licenza'); 
define('CULUMS_OFF13', 'SE L\'UTENTE NON ACCETTA I PRESENTI TERMINI'); 
define('CULUMS_OFF14', 'VALUTAZIONE'); 
define('CULUMS_OFF15', 'Le parti concordano quanto segue:'); 
define('CULUMS_OFF16', '1. Definizioni'); 
define('CULUMS_OFF17', 'a. Per "Prodotto" s\'intendono le versioni eseguibili del software di networking rese disponibili da Cumulus, così come esplicitamente definito nelle Conferme d\'ordine (secondo quanto riportato nella Sezione 3a disciplinata dal presente Accordo e così come resa disponibile al licenziatario'); 
define('CULUMS_OFF18', 'b. Per "Informazioni proprietarie" s\'intendono tutte le invenzioni'); 
define('CULUMS_OFF19', 'c. Per "Diritti proprietari" s\'intendono i diritti di brevetto'); 
define('CULUMS_OFF20', '2. Concessione di licenza'); 
define('CULUMS_OFF21', 'a. Soggetta al pagamento completo ai sensi della Sezione 3 e alla conformità del Licenziatario agli altri termini e condizioni del presente Accordo'); 
define('CULUMS_OFF22', 'b. La suddetta licenza non consente alcuna sublicenza'); 
define('CULUMS_OFF23', 'c. Il Licenziatario non deve (e non deve consentire al proprio personale o qualsiasi parte terza): (i modificare o creare opere derivate dal Prodotto; (ii eseguire il reverse engineer o tentare di scoprire qualsiasi codice sorgente o idea sottostante o algoritmi del Prodotto (salvo nella misura in cui la legge in vigore vieti limitazioni sul reverse engineering)'); 
define('CULUMS_OFF24', 'd. Il Prodotto comprende pacchetti software open source (collettivamente'); 
define('CULUMS_OFF25', 'e. Il Prodotto è disciplinato dalle leggi sull\'esportazione'); 
define('CULUMS_OFF26', 'f. Il Prodotto (i è stato sviluppato a spese private e comprende segreti commerciali e informazioni riservate; (ii è un articolo commerciale costituito da software per computer commerciale e Documentazione di software per computer commerciale regolati ai sensi del DFARS Sezione 227.7202 e FAR Sezione 12.212 e non deve essere ritenuto software per computer non commerciale o documentazione di software per computer non commerciale ai sensi di nessuna clausola del DFARS; e (iii NON viene offerto ad enti governativi statunitensi ai sensi della Licenza di software per computer commerciale stabilita in FAR 52.227-19. Coerente con il 48 CFR 12.212 e 48 CFR 227.7202 secondo quanto pertinente'); 
define('CULUMS_OFF27', '3. Prezzo; Pagamento; Registrazioni.'); 
define('CULUMS_OFF28', 'a. Nel corso della durata del presente Accordo'); 
define('CULUMS_OFF29', 'b. Nel corso della durata del presente Accordo'); 
define('CULUMS_OFF30', 'c. Il licenziatario pagherà a Cumulus (o a un Rivenditore autorizzato) tutte le commissioni pertinenti stabilite in ciascuna conferma d\'ordine (le "Commissioni" entro trenta giorni (30) giorni dalla ricezione di ciascuna conferma d\'ordine'); 
define('CULUMS_OFF31', 'd. Nel corso della durata del presente Accordo e per un (1) anno a seguito del sua cessazione'); 
define('CULUMS_OFF32', '4. Consegna e supporto.'); 
define('CULUMS_OFF33', 'a. Dopo la consegna della prima conferma d\'ordine ai sensi del presente Accordo'); 
define('CULUMS_OFF34', 'b. Il licenziatario può ordinare servizi di supporto da Cumulus così come stabilito nella corrispondente conferma d\'ordine'); 
define('CULUMS_OFF35', 'c. Salvo divieto contrattuale o legale ad agire in tal modo'); 
define('CULUMS_OFF36', '5. Pubblicità; Divulgazione dell\'Accordo; Marchi commerciali.'); 
define('CULUMS_OFF37', 'a. Cumulus avrà il diritto di riferirsi al Licenziatario come a un cliente senza divulgare i termini del presente Accordo. Salvo secondo quanto richiesto dalla legge o altrimenti stabilito nel presente Accordo'); 
define('CULUMS_OFF38', 'b. Salvo secondo quando diversamente specificato nel presente documento '); 
define('CULUMS_OFF39', '6. Divieto contro l\'assegnamento. Né il presente Accordo né alcun diritto'); 
define('CULUMS_OFF40', '7. Durata dell\'Accordo. La durata del presente Accordo sarà in vigore fino al termine di durata della licenza che scadrà per ultima.  Il presente Accordo cesserà automaticamente'); 
define('CULUMS_OFF41', '8. Sopravvivenza. Diritti al pagamento'); 
define('CULUMS_OFF42', '9. Avvisi e richieste. Tutti gli avvisi'); 
define('CULUMS_OFF43', '10. Leggi disciplinanti; Spese legali. Il presente Accordo sarà disciplinato e interpretato ai sensi delle leggi dello Stato della California e degli Stati Uniti, indipendentemente dalle disposizioni sui conflitti di leggi e dall\'UCITA o dalla Convenzione delle Nazioni Unite sui contratti di vendita internazionale di merci. La sola giurisdizione e sede per le azioni relative a questioni del presente documento saranno lo stato della California e i tribunali federali statunitensi della Contea di Santa Clara'); 
define('CULUMS_OFF44', '11. Riservatezza'); 
define('CULUMS_OFF45', 'Termini relativi ai prezzi del presente Accordo'); 
define('CULUMS_OFF46', '12. Responsabilità limitata. SALVO QUANTO DIVERSAMENTE PREVISTO DI SEGUITO'); 
define('CULUMS_OFF47', '13. Garanzia'); 
define('CULUMS_OFF48', 'a. Cumulus garantisce al Licenziatario che il Prodotto sarà di buona qualità e sviluppato mediante una buona manodopera in accordo ai più elevati standard professionali. Il solo rimedio del Licenziatario per la violazione della presente garanzia o per i difetti nei prodotti sono i sui diritti ai sensi della Sezione 4b. Cumulus non offre alcuna garanzia riguardante l\'assenza di errori o l\'utilizzo ininterrotto.'); 
define('CULUMS_OFF49', '. Il prodotto non è progettato'); 
define('CULUMS_OFF50', 'c. SALVO SECONDO QUANDO ESPLICITAMENTE RIPORTATO IN PRECEDENZA'); 
define('CULUMS_OFF51', 'd. CIASCUNA PARTE RICONOSCE E ACCETTA CHE LE CLAUSOLE DI ESCLUSIONE E I LIMITI DI RESPONSABILITÀ E RIMEDIO NEL PRESENTE ACCORDO SIANO ELEMENTI CONCORDATI COME BASE DEL PRESENTE ACCORDO E CHE SIANO STATI CONSIDERATI E RISPECCHIATI NEL DETERMINARE LA CONSIDERAZIONE CHE DEVE ESSERE DATA DA CIASCUNA PARTE AI SENSI DEL PRESENTE ACCORDO E NELLA DECISIONE DI CIASCUNA PARTE A STIPULARE IL PRESENET ACCORDO.'); 
define('CULUMS_OFF52', '14. Generale. Il presente accordo costituisce l\'intero accordo tra le parti in relazione all\'oggetto del presente documento e unisce tutte le comunicazioni precedenti e attuali. Non deve essere modificato salvo tramite un accordo scritto con data successiva a quella del presente Accordo e firmato per conto del Licenziatario e di Cumulus dai loro debiti rappresentanti autorizzati. Se qualsiasi clausola del presente Accordo viene ritenuta illegale da un tribunale di giurisdizione competente'); 
define('CULUMS_OFF53', 'Invia');
define("CULUMS_OFF54","Copyright &copy; 2002-".date('Y',time())." FS.COM GmbH All Rights Reserved.");
define('CULUMS_OFF55', 'Informativa sulla privacy'); 
define('CULUMS_OFF56', 'Informazioni inviate correttamente Entro 10 minuti ti invieremo un\'e-mail contenente il codice di licenza per l\'attivazione dello switch.'); 
define('CULUMS_OFF57', 'Il nome della tua società è obbligatorio'); 
define('CULUMS_OFF58', 'Il tuo numero di telefono è obbligatorio'); 
define('CULUMS_OFF59', 'Il tuo indirizzo e-mail è obbligatorio'); 
define('CULUMS_OFF60', 'L\'indirizzo e-mail che hai inserito non è riconosciuto. (esempio: qualcuno@esempio.com).'); 
define('CULUMS_OFF61', 'Seleziona il pulsante di accettazione dell\'accordo EULA'); 
define('CULUMS_OFF62', 'Il tuo indirizzo Web è obbligatorio'); 
define('CULUMS_OFF63', 'Hai inviato le informazioni di verifica'); 
define('CULUMS_OFF64', 'Informazioni inviate correttamente'); 
define('CULUMS_OFF65', 'Informazioni articolo'); 
define('CULUMS_OFF66', 'Condividi la tua esperienza di utilizzo '); 
define('FS_ADD_CART_PROCHUSE', 'Subtotale carrello'); 
define('FS_ADD_NEW_ADDRESS', 'Aggiungi un nuovo indirizzo'); 
define('FS_ADD_SHIPPING_ADDRESSES', 'Aggiungi un nuovo indirizzo di spedizione'); 
define('FS_ADD_BILLING_ADDRESS', 'Aggiungi un nuovo indirizzo di fatturazione'); 
define('PAYMENT_AGAINST_PAYPAL', 'PayPal'); 
define('CHECKOUT_BILLING_CREDIT', 'Centro pagamento con carta di credito/debito'); 
define('PAYMENT_AGAINST_PAYPAL_SECURITY', 'Sarai reindirizzato al conto paypal per il pagamento di quest\'ordine.'); 
define('PAYMENT_AGAINST_ECHECK', 'Assegno elettronico'); 
define('PAYMENT_AGAINST_BANK', 'Bonifico bancario'); 
define('PAYMENT_AGAINST_BANK_SENTENCE01', 'I fondi vengono di solito ricevuti in 1-3 giorni lavorativi. Tratteremo l\'ordine non appena la rimessa sarà confermata.'); 
define('PAYMENT_AGAINST_BANK_SPARKASSE', 'Conto Sparkasse Bank'); 
define('PAYMENT_AGAINST_BANK_FILL', 'Compila le informazioni di bonifico bancario'); 
define('PAYMENT_AGAINST_BANK_SENTENCE02', 'Comunicaci quando sei pronto a rimettere il pagamento in modo tale da poter effettuare la verifica e processare il tuo ordine tempestivamente.'); 
define('PAYMENT_AGAINST_BANK_EMAIL', 'Indirizzo e-mail del pagatore'); 
define('PAYMENT_AGAINST_ITEMS', 'articoli'); 
define('PAYMENT_AGAINST_EDIT', 'Modifica'); 
define('GLOABL_GC_LIVECHAT', 'Chat dal vivo'); 
define('GLOBAL_GC_TEXT6', 'Seleziona carta di credito/debito:'); 
define('GLOBAL_GC_TEXT7', 'Riepilogo ordine'); 
define('GLOBAL_GC_TEXT8', 'Numero d\'ordine'); 
define('GLOBAL_GC_TEXT9', 'Hai bisogno di aiuto? '); 
define('GLOBAL_GC_TEXT10', ' Consulta le nostre pagine della Guida o  '); 
define('GLOBAL_GC_TEXT11', ' Indirizzo di fatturazione'); 
define('GLOBAL_GC_TEXT12', 'Modifica'); 
define('GLOBAL_GC_TEXT13', 'Numero carta'); 
define('GLOBAL_GC_TEXT14', 'Data di scadenza'); 
define('GLOBAL_GC_TEXT17', 'Codice di sicurezza'); 
define('GLOBAL_GS_ITEMS', 'articoli'); 
define('GLOBAL_GS_SENTENCE1', 'Nota: per motivi di sicurezza, non salviamo i dati della tua carta di credito');
define('GLOBAL_GS_SENTENCE2', 'Accettiamo le seguenti carte di credito/debito e le P-Card emesse da queste società. Selezionare un tipo di carta, completare le informazioni di seguito e cliccare su Conferma.');
define('FS_AGAINST_WE', 'Accettiamo le seguenti carte di credito/debito e le P-Card emesse da queste società. Selezionare un tipo di carta, completare le informazioni di seguito e cliccare su Conferma.');
define('GLOABL_CART', 'Carrello'); 
define('GLOABL_CHECKETOUT', 'Vai al checkout');
define('GLOABL_SUCCESS', 'Riuscito'); 
define('GLOBAL_EXPECTED_SHIPPING', 'Consegna prevista');
define('GLOBAL_EXPECTED_DELIVERY', 'Consegna prevista');
define('GLOABL_EDIT_BILLING', 'Modifica il tuo indirizzo di fatturazione');
define("FS_CHECKOUT_NEW28","Copyright &copy; 2009-".date('Y',time())." FS.COM GmbH All Rights Reserved.");
define('FS_PAYMENT_CONFIRM', 'Conferma'); 
define('FS_ORDER_UPLOAD_PO_PURCHASE_ERROR_TIP', 'Il numero dell\'ordine di acquisto non può essere vuoto.'); 
define('FS_AGAINST_ITEM', 'Articolo/i'); 
define('FS_AGAINST_SHIPPING', 'Metodo di spedizione'); 
define('FS_AGAINST_ORDER_DATE', 'Data dell\'ordine'); 
define('FS_AGAINST_PAYMENT', 'Metodo di pagamento'); 
define('FS_AGAINST_DETAIL', 'Info conto bancario'); 
define('FS_AGAINST_BENE', 'Nome banca beneficiario'); 
define('FS_AGAINST_HSBC', 'HSBC Hong Kong'); 
define('FS_AGAINST_AC', 'Nome C/C beneficiario'); 
define('FS_AGAINST_CO', 'FS.COM LIMITED'); 
define('FS_AGAINST_NO', 'N. C/C beneficiario'); 
define('FS_AGAINST_SWIFT', 'Indirizzo SWIFT'); 
define('FS_AGAINST_ADDRESS', 'Indirizzo banca beneficiario'); 
define('FS_AGAINST_ROAD', '1 Queen\'s Road Central'); 
define('FS_AGAINST_OUR', 'Indirizzo della nostra società'); 
define('FS_AGAINST_EAST', 'Eastern Side'); 
define('FS_AGAINST_FILL', 'Compila le informazioni di pagamento'); 
define('FS_AGAINST_PAYER', 'Nome del pagatore'); 
define('FS_AGAINST_OR', 'Compila il nome e cognome che utilizzi per effettuare il bonifico bancario'); 
define('FS_AGAINST_COUNTRY', 'Paese'); 
define('FS_AGAINST_CHOOSE', 'Scegli'); 
define('FS_AGAINST_PLE_CHOOSE', 'Scegli il tuo paese.'); 
define('FS_AGAINST_PAY_AMOUNT', 'Importo del pagamento'); 
define('FS_AGAINST_EX', 'Il campo Importo pagamento è obbligatorio. Es.: $ 29,22 o € 29,22 o 29,22 (La valuta predefinita è $'); 
define('FS_AGAINST_PAY_TIME', 'Ora del pagamento'); 
define('FS_AGAINST_YOUR', 'Il campo Ora del pagamento è obbligatorio (Es.: 2014-6-12'); 
define('FS_AGAINST_PHONE', 'Numero telefonico del pagatore'); 
define('FS_AGAINST_MUST', 'Deve essere un numero di telefono valido'); 
define('FS_AGAINST_SEND', 'Invia'); 
define('FS_AGAINST_ANZ', 'Conto bancario ANZ'); 
define('FS_BT_SUCCESSFULLY', 'Aggiornamento corretto!'); 
define('FS_BT_SUCCESSFULLY_SENTENCE_01', 'I fondi vengono di solito ricevuti in 1-3 giorni lavorativi. Ce ne occuperemo nel più breve tempo possibile. Clic'); 
define('FS_BT_SUCCESSFULLY_SENTENCE_02', 'Storico dell\'ordine'); 
define('FS_BT_SUCCESSFULLY_SENTENCE_03', 'per vedere l\'ordine.'); 
define('FS_ORDER_UPLOAD_PO_MESSAGE', 'Il tuo ordine non sarà spedito finché non sarà ricevuto il documento di PO valido entro  7 giorni.');
define('FS_AGAINST_CART', 'Account personale'); 
define('FS_ALLOWED_FILE_TYPES', 'Tipi di file consentiti:'); 
define('FS_SUCCESS_CART', 'Carrello'); 
define('FS_REGIST', 'Regist.'); 
define('FS_GC_TIPS_01', 'Spiacenti'); 
define('FS_GC_TIPS_02', '1 L\'importo totale supera il limite (€ 15000):'); 
define('FS_GC_TIPS_03', '2 La carta non supporta la valuta;'); 
define('FS_GC_TIPS_04', '3 Errore di rete'); 
define('FS_INQUIRY_YOUR_ITEM', 'Il tuo articolo'); 
define('CHECKOUT_TAXE_CLEARANCE_CN_FRONT', 'Per gli ordini spediti da nostro magazzino CN'); 
define('FS_SAMPLE_APPLICATION_SUBMIT', 'Invia...'); 
define('FS_COMMON_FILE', 'Carica file');
define('FS_UPLOAD_ERROR1', 'L\'errore del primo allegato:'); 
define('FS_UPLOAD_ERROR2', 'L\'errore del secondo allegato:'); 
define('FS_UPLOAD_ERROR3', 'L\'errore del terzo allegato:'); 
define('FS_UPLOAD_ERROR4', 'L\'errore del quarto allegato:'); 
define('FS_UPLOAD_ERROR5', 'L\'errore del quinto allegato:'); 
define('FS_UPLOAD_FORMAT_TIP', 'Consenti i tipi di file $FILE_TYPE'); 
define('FS_UPLOAD_SIZE_DEFAULT_TIP', 'Dimensione massima del file 5 MB.'); 
define('GLOABL_TEXT_DECLINED_1', 'Siamo spiacenti che la tua carta sia stata rifiutata per uno dei motivi seguenti:'); 
define('GLOABL_TEXT_DECLINED_2', '1. Accertati che non appaiano nei 30 giorni più di 2 indirizzi di fatturazione univoci per numero di carta o per indirizzo e-mail.'); 
define('GLOABL_TEXT_DECLINED_3', '2. Accertati che il paese di emissione della carta sia lo stesso dell\'indirizzo di spedizione dell\'ordine.'); 
define('GLOABL_TEXT_DECLINED_8', '3. Accertati che l\'indirizzo di fatturazione dell\'ordine sia esattamente così come appare sull\'estratto conto della carta di credito.'); 
define('GLOABL_TEXT_DECLINED_4', 'Puoi rivolgerti anzitutto alla tua banca per informarti sulle motivazioni'); 
define('GLOABL_TEXT_DECLINED_5', 'La tua carta è stata rifiutata dalla banca emittente'); 
define('GLOABL_TEXT_DECLINED_6', 'La tua carta può essere stata rifiutata per svariati motivi'); 
define('GLOABL_TEXT_DECLINED_7', 'Rivolgiti alla tua banca o all\'istituto che ha emesso la carta per informazioni sul motivo specifico'); 
define('GLOABL_TEXT_DECLINED_9', 'Fai clic qui per pagare con un altro metodo di pagamento.'); 
define('GLOABL_TEXT_DECLINED_10', 'Dividi l\'ordine se l\'importo totale è superiore a €15000.00'); 
define('GLOABL_TEXT_DECLINED_11', ' fai clic qui '); 
define('GLOABL_TEXT_DECLINED_12', 'per pagare con un altro metodo.'); 
define('FS_CLEARACNE_05', 'Visualizza tutti'); 
define('FS_CLEARACNE_06', 'carica altri'); 
define('FS_ACCOUNT_HISTORY_1', 'Conferma la ricezione del pacco'); 
define('FS_PRODCUTS_INFO_VIEW', 'Visualizza spec. complete:'); 
define('FS_PRE_ORDER', 'Pre-ordine'); 
define('FS_DAY_PROCESSING', '<span class="process_time_dylan">Tempo di lavorazione $DAYNUMBER</span> giorni'); 
define('FS_DAY_PROCESSING_SEARCH', '<span class="process_time_dylan">Tempo di lavorazione $DAYNUMBER</span> giorni'); 
define('PREORDER_DESPRCTION', 'Il pre-ordine è speciale in Ricerca e Sviluppo e nella linea di assemblaggio orientata al cliente in base al raggiungimento delle economie di scala e produzione automatizzata'); 
define('EMAIL_COMMON_FOOTER_NEW_01', 'Condividi la tua esperienza di utilizzo '); 
define('EMAIL_COMMON_FOOTER_NEW_02', 'Se iscritto a questa e-mail come '); 
define('EMAIL_COMMON_FOOTER_NEW_03', 'Fai clic qui per modificare le tue preferenze oppure annulla l\'iscrizione.'); 
define('EMAIL_COMMON_FOOTER_NEW_04', 'FS.COM Inc'); 
define('EMAIL_COMMON_FOOTER_NEW_05', 'Contattaci'); 
define('EMAIL_COMMON_FOOTER_NEW_06', 'Account personale'); 
define('EMAIL_COMMON_FOOTER_NEW_07', 'Spedizione &amp; Consegna'); 
define('EMAIL_COMMON_FOOTER_NEW_08', 'Politica sui resi'); 
define('EMAIL_COMMON_FOOTER_NEW_09', ' Tutti i diritti riservati.'); 
define('EMAIL_COMMON_FOOTER_NEW_10', 'Copyright &copy; '); 
define('RESET_PASS_SUCCESS_01', 'Hai modificato la password correttamente. La tua nuova password è pronta per l\'uso immediato in tutti i nostri siti.'); 
define('RESET_PASS_SUCCESS_02', 'Accedi al tuo account'); 
define('RESET_PASS_SUCCESS_03', 'Se non hai chiesto di modificare la tua password, si prega di rispondere a questa email o chiamarci +49 8165 7076169');
define('RESET_PASS_SUCCESS_04', 'Grazie<br>Il Team FS'); 
define('RESET_PASS_SUCCESS_05', 'Gentile'); 
define('RESET_PASS_SUCCESS_TITLE', 'Aggiornamento password'); 
define('RESET_PASS_SUCCESS_THEME', 'La tua password è stata aggiornata.');
define('RESET_PASS_SEND_01',"Abbiamo ricevuto una richiesta di reimpostare la password del tuo account FS. Se non hai fatto questa richiesta, ignora questa e-mail e tutto andrà bene. Se hai fatto questa richiesta basta cliccare il pulsante qui sotto per ottenere una nuova password.");
define('RESET_PASS_SEND_02',"Imposta nuova password");
define('RESET_PASS_SEND_03',"Nota: Se hai problemi a cliccare sul pulsante \"imposta nuova password\", copia e incolla il codice di ripristino della password di sotto nella vostra pagina di reimpostare la password.");
define('RESET_PASS_SEND_04', 'Grazie<br>Il Team FS'); 
define('RESET_PASS_SEND_05', 'Gentile'); 
define('RESET_PASS_SEND_06', 'Niente password? Nessun problema. Ti aiuteremo a reimpostarla.'); 
define('RESET_PASS_SEND_TITLE', 'Reimposta password');
define('RESET_PASS_SEND_THEME','Istruzioni per il ripristino della password');
define('RESET_PASS_EXPIRE_TIME','Questo codice di ripristino della password scadrà tra 4 ore. Per ottenere un nuovo link per la reimpostazione della password, visita il sito <a style="color: #0070BC;text-decoration: none" href="'.zen_href_link(FILENAME_LOGIN).'">'.zen_href_link(FILENAME_LOGIN).'</a>');
define('RESET_EMAIL_SUCCESS_01', 'Il tuo indirizzo e-mail è stato modificato in '); 
define('RESET_EMAIL_SUCCESS_02', 'Gentile'); 
define('RESET_EMAIL_SUCCESS_03', 'Utilizza questo indirizzo per accedere al tuo ');
define('RESET_EMAIL_SUCCESS_04', 'Account personale'); 
define('RESET_EMAIL_SUCCESS_05', ' dettagli.'); 
define('RESET_EMAIL_SUCCESS_06', 'Se non hai chiesto di modificare i tuoi dettagli ');
define('RESET_EMAIL_SUCCESS_07', 'Grazie<br>Il Team FS'); 
define('RESET_EMAIL_SUCCESS_TITLE', 'Indirizzo e-mail aggiornato'); 
define('RESET_EMAIL_SUCCESS_THEME', 'FS - Il tuo indirizzo e-mail è stato aggiornato'); 
define('REGIST_EMAIL_SEND_01', 'Il tuo account è stato creato correttamente. Ora puoi accedere con e-mail e password.'); 
define('REGIST_EMAIL_SEND_02', 'Gentile'); 
define('REGIST_EMAIL_SEND_03', 'Il tuo account è stato creato correttamente. Ora puoi '); 
define('REGIST_EMAIL_SEND_04', 'accedere'); 
define('REGIST_EMAIL_SEND_05', ' con la tua e-mail e password.'); 
define('REGIST_EMAIL_SEND_06', 'Dopo l\'accesso'); 
define('REGIST_EMAIL_SEND_07', 'Gestisci il tuo '); 
define('REGIST_EMAIL_SEND_08', 'profilo account FS'); 
define('REGIST_EMAIL_SEND_09', ' e richiedi con facilità l\'accesso ai servizi FS.'); 
define('REGIST_EMAIL_SEND_10', 'Invia '); 
define('REGIST_EMAIL_SEND_11', 'richiesta di supporto tecnico'); 
define('REGIST_EMAIL_SEND_12', ' e ottieni una risposta immediata e gratuita.'); 
define('REGIST_EMAIL_SEND_13', 'Effettua un acquisto online e rintraccia lo stato dell\'ordine in qualsiasi momento.'); 
define('REGIST_EMAIL_SEND_14', 'Grazie<br>Il Team FS'); 
define('REGIST_EMAIL_SEND_TITLE', 'Account creato');
define('REGIST_EMAIL_SEND_THEME', 'Il tuo nuovo account è pronto!');
define('REGIST_COM_EMAIL_SEND_01', 'Abbiamo ricevuto la tua richiesta di account aziendale. È attualmente in fase di verifica e questo processo può richiedere 1-3 giorni lavorativi.'); 
define('REGIST_COM_EMAIL_SEND_02', 'Gentile'); 
define('REGIST_COM_EMAIL_SEND_04', 'Prima dell\'approvazione'); 
define('REGIST_COM_EMAIL_SEND_05', 'accedi'); 
define('REGIST_COM_EMAIL_SEND_06', 'con la tua e-mail e password e inizia ad approfittare dei servizi dell\'account standard.'); 
define('REGIST_COM_EMAIL_SEND_07', 'Dopo l\'accesso'); 
define('REGIST_COM_EMAIL_SEND_08', 'Gestisci il tuo'); 
define('REGIST_COM_EMAIL_SEND_09', 'profilo account FS'); 
define('REGIST_COM_EMAIL_SEND_10', 'e richiedi con facilità l\'accesso ai servizi FS.'); 
define('REGIST_COM_EMAIL_SEND_11', 'Invia'); 
define('REGIST_COM_EMAIL_SEND_12', 'richiesta di supporto tecnico'); 
define('REGIST_COM_EMAIL_SEND_13', 'e ottieni una risposta immediata e gratuita.'); 
define('REGIST_COM_EMAIL_SEND_14', 'Effettua un acquisto online e rintraccia lo stato dell\'ordine in qualsiasi momento.'); 
define('REGIST_COM_EMAIL_SEND_15', 'Grazie<br>Il Team FS');

//新注册邮件语言包
define('REGIST_EMAIL_SEND_NEW_01',"Account creato");
define('REGIST_EMAIL_SEND_NEW_02',"Benvenuto in FS");
define('REGIST_EMAIL_SEND_NEW_03',"Fornitore dei dispositivi di comunicazione Internet & soluzione");
define('REGIST_EMAIL_SEND_NEW_04',"Impegno alla qualità");
define('REGIST_EMAIL_SEND_NEW_05',"Garanzia alla qualità, attenzione al cliente e gestione sostenibile");
define('REGIST_EMAIL_SEND_NEW_06',"Soluzioni personalizzate");
define('REGIST_EMAIL_SEND_NEW_07',"Forniamo la one-stop soluzione innovativa, economica e affidabile.");
define('REGIST_EMAIL_SEND_NEW_08',"Consegna espressa");
define('REGIST_EMAIL_SEND_NEW_09',"Magazzini locali, inventario adeguato e spedizione gratuita.");
define('REGIST_EMAIL_SEND_NEW_10',"Forniamo l'esperienza e lo supporto tecnico, <br> rispondiamo rapidamente per portare avanti <br> la tua attività.");
define('REGIST_EMAIL_SEND_NEW_11',"Visita il nostro blog, wiki, casi e annunci <br> per trovare le soluzioni e <br> gli ottimi consigli.");
define('REGIST_EMAIL_SEND_NEW_12',"Inizia ora");
define('REGIST_EMAIL_SEND_NEW_13',"Supporto tecnico FS");
define('REGIST_EMAIL_SEND_NEW_14',"Comunità FS");

define('REGIST_COM_EMAIL_SEND_TITLE', 'Richiesta ricevuta'); 
define('REGIST_COM_EMAIL_SEND_THEME', 'FS - La tua richiesta di account aziendale è stata ricevuta'); 
define('REGIST_COM_EMAIL_UPGRADE_02', 'Gentile'); 
define('REGIST_COM_EMAIL_UPGRADE_03', 'Abbiamo ricevuto la tua richiesta di upgrade del tuo account. È attualmente in fase di verifica e questo processo può richiedere 1-3 giorni lavorativi. Quando sarà presa la decisione'); 
define('REGIST_COM_EMAIL_UPGRADE_04', 'Grazie<br>Il Team FS'); 
define('REGIST_COM_EMAIL_UPGRADE_TITLE', 'Richiesta ricevuta'); 
define('REGIST_COM_EMAIL_UPGRADE_THEME', 'FS - La tua richiesta di account aziendale è stata ricevuta'); 
define('FS_ORDER_EMAIL_01', 'Grazie per aver scelto FS. Abbiamo ricevuto il tuo ordine in sospeso ');
define('FS_ORDER_EMAIL_02', '. Completa il pagamento affinché il tuo ordine possa essere elaborato al più presto.'); 
define('FS_ORDER_EMAIL_03', 'I dettagli del tuo ordine'); 
define('FS_ORDER_EMAIL_04', 'sono riportati di seguito. Ti invieremo le informazioni di tracciamento non appena un articolo del tuo ordine verrà spedito.'); 
define('FS_ORDER_EMAIL_05', 'I dettagli del tuo ordine'); 
define('FS_ORDER_EMAIL_06', 'sono riportati di seguito. Poiché hai scelto "Ritiro in magazzino”'); 
define('FS_ORDER_EMAIL_07', 'Grazie per aver scelto FS. Abbiamo ricevuto il tuo ordine in sospeso. Completa il pagamento affinché il tuo ordine possa essere elaborato al più presto.'); 
define('FS_ORDER_EMAIL_08', 'I dettagli del tuo ordine sono riportati di seguito. Poiché hai scelto "Ritiro in magazzino”'); 
define('FS_ORDER_EMAIL_09', 'Grazie per i tuoi acquisiti con noi. I dettagli del tuo ordine sono riportati di seguito. Ti invieremo le informazioni di tracciamento non appena un articolo del tuo ordine verrà spedito.'); 
define('FS_ORDER_EMAIL_10', 'Ordine'); 
define('FS_ORDER_EMAIL_11', 'Il tuo acquisto è stato suddiviso in'); 
define('FS_ORDER_EMAIL_12', 'ordini.'); 
define('FS_ORDER_EMAIL_13', 'Gestisci ordini'); 
define('FS_ORDER_EMAIL_14', 'Ordine'); 
define('FS_ORDER_EMAIL_15', 'Ordinato'); 
define('FS_ORDER_EMAIL_16', 'Spedizione prevista'); 
define('FS_ORDER_EMAIL_17', 'Consegna prevista');
define('FS_ORDER_EMAIL_18','Non si preoccupi, le daremo notizie non appena i suoi articoli verranno spediti. Per seguire gli aggiornamenti sullo stato del suo ordine, può controllare ');
define('FS_ORDER_EMAIL_19', 'Account personale'); 
define('FS_ORDER_EMAIL_20', ' in qualsiasi momento.');
define('FS_ORDER_EMAIL_21', 'Se devi modificare o annullare l\'ordine ');
define('FS_ORDER_EMAIL_22', '. Osserva che non sarà più possibile apportare alcuna modifica una volta che gli articoli sono stati spediti.'); 
define('FS_ORDER_EMAIL_23', 'Nessun problema');
define('FS_ORDER_EMAIL_24','Per modificare o annullare l\'ordine, contattare il proprio gestore d\'account. Si prega di notare che non sarà più possibile apportare modifiche una volta che gli articoli saranno spediti.');
define('FS_ORDER_EMAIL_25', 'Completa il pagamento affinché il tuo ordine possa essere elaborato al più presto.'); 
define('FS_ORDER_EMAIL_26', 'Ordine ricevuto'); 
define('FS_ORDER_EMAIL_27', 'Elaborazione dell\'ordine in corso'); 
define('FS_ORDER_EMAIL_28', 'Gentile ');
define('FS_ORDER_EMAIL_29', 'Dettagli della consegna'); 
define('FS_ORDER_EMAIL_30', 'Spedizione a'); 
define('FS_ORDER_EMAIL_31', 'Informazioni di contatto'); 
define('FS_ORDER_EMAIL_32', 'Domande frequenti'); 
define('FS_ORDER_EMAIL_33', 'Dov\'è l\'articolo che ho ordinato?'); 
define('FS_ORDER_EMAIL_34', 'Come faccio a modificare il mio ordine?'); 
define('FS_ORDER_EMAIL_35', 'Dettagli del pagamento'); 
define('FS_ORDER_EMAIL_36', 'Subtotale:'); 
define('FS_ORDER_EMAIL_37', 'Spedizione:'); 
define('FS_ORDER_EMAIL_38', 'Costo totale:'); 
define('FS_ORDER_EMAIL_39', 'Metodo di pagamento:'); 
define('FS_ORDER_EMAIL_40', 'Tutti gli addebiti appariranno come <a style="color: #0681d3;text-decoration: none" href="javascript:;">FS COM</a>.'); 
define('FS_ORDER_EMAIL_41', 'Fatturazione a'); 
define('FS_ORDER_EMAIL_42', 'Grazie per il tuo ordine. Guarda all\'interno per i dettagli del tuo ordine.'); 
define('FS_ORDER_EMAIL_43', 'FS - Abbiamo ricevuto il tuo ordine in sospeso %s'); 
define('FS_ORDER_EMAIL_44', 'Indirizzo di ritiro'); 
define('FS_ORDER_EMAIL_45', 'Persona per il ritiro'); 
define('FS_ORDER_EMAIL_46', '. Carica il file dell\'ordine d\'acquisto affinché il tuo ordine possa essere elaborato al più presto.');
define('FS_ORDER_EMAIL_47', 'FS - Grazie per il tuo ordine %s');
define('FS_ORDER_EMAIL_48', 'Ordine d\'acquisto'); 
define('FS_ORDER_EMAIL_49', 'Pronto'); 
define('FS_ORDER_EMAIL_50', 'Ritiro'); 
define('FS_ORDER_EMAIL_51', 'Grazie per aver scelto FS. Abbiamo ricevuto il tuo ordine in sospeso[ORDERNUMBER]. Il nostro account manager invierà la fattura alla tua e-mail nel più breve tempo possibile.'); 
define('FS_ORDER_EMAIL_52', 'Controlla i dettagli di pagamento:'); 
define('FS_ORDER_EMAIL_53', 'Persona di contatto'); 
define('FS_ORDER_EMAIL_54', 'Numero di telefono*'); 
define('FS_ORDER_EMAIL_55', 'E-mail*'); 
define('FS_ORDER_EMAIL_56', 'Nome dell\'organizzazione*'); 
define('FS_ORDER_EMAIL_57', 'INN*'); 
define('FS_ORDER_EMAIL_58', 'KPP*'); 
define('FS_ORDER_EMAIL_59', 'OKPO'); 
define('FS_ORDER_EMAIL_60', 'BIC*'); 
define('FS_ORDER_EMAIL_61', 'Sede legale*'); 
define('FS_ORDER_EMAIL_62', 'Indirizzo postale'); 
define('FS_ORDER_EMAIL_63', 'Conto corrispondente'); 
define('FS_ORDER_EMAIL_64', 'Nome banca*'); 
define('FS_ORDER_EMAIL_65', 'Conto di pagamento*'); 
define('FS_ORDER_EMAIL_66', 'Nome e cognome del titolare'); 
define('FS_ORDER_EMAIL_67', 'Informazioni di pagamento'); 
define('FS_ORDER_EMAIL_68', 'Lunghezza');
define('FS_ORDER_EMAIL_69','Puoi tenere traccia dell\'avanzamento del tuo ordine accedendo al tuo account e andando sulla ');
define('FS_ORDER_EMAIL_70','pagina');
define('FS_ORDER_EMAIL_71',' Storico Ordini.');
define('FS_ORDER_EMAIL_72','Pagamento ricevuto');
define('FS_ORDER_EMAIL_73','In elaborazione');
define('FS_ORDER_EMAIL_74','In transito');
define('FS_ORDER_EMAIL_75','Consegnato');
define('FS_ORDER_EMAIL_76','Ordine d\'acquisto confermato');
define('FS_ORDER_EMAIL_09_1','Il tuo acquisto è stato diviso in 2 ordini ');
define('FS_ORDER_EMAIL_09_2','I dettagli sono qui sotto. Ti invieremo un\'email non appena avremo ricevuto un aggiornamento sui tuoi ordini.');
define('FS_PURCHASE_ORDER_NUMBER','Ordine d\'acquisto Numero');
define('FS_SEND_EMAIL', 'FS - Abbiamo ricevuto la tua richiesta di preventivo ');
define('FS_SEND_EMAIL_1', 'Abbiamo ricevuto la tua richiesta di preventivo '); 
define('FS_SEND_EMAIL_2', ' e ti invieremo via e-mail i dettagli del preventivo entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_3', 'Richiesta ricevuta'); 
define('FS_SEND_EMAIL_4', ' e ti invieremo via e-mail i dettagli del preventivo entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_5', 'Il tuo messaggio'); 
define('FS_SEND_EMAIL_6', 'Elenco preventivi'); 
define('FS_SEND_EMAIL_7', 'Le tue note aggiuntive'); 
define('FS_SEND_EMAIL_8', 'Qtà: '); 
define('FS_SEND_EMAIL_8_1', 'FS - Abbiamo ricevuto la tua richiesta di soluzione'); 
define('FS_SEND_EMAIL_9', 'Grazie per aver contattato FS; il tuo numero di caso è '); 
define('FS_SEND_EMAIL_10', '. Il nostro team di supporto tecnico ti contatterà entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_11', 'FS - Abbiamo ricevuto la tua domanda relativa all\'articolo #'); 
define('FS_SEND_EMAIL_12', 'Domanda ricevuta'); 
define('FS_SEND_EMAIL_12_1', 'Abbiamo ricevuto la tua domanda relativa all\'articolo #'); 
define('FS_SEND_EMAIL_13', ' e ti invieremo una risposta entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_14', 'Abbiamo ricevuto la tua domanda relativa all\'articolo '); 
define('FS_SEND_EMAIL_15', ' e ti invieremo una risposta entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_16', 'Ci stiamo lavorando'); 
define('FS_SEND_EMAIL_17', 'Abbiamo ricevuto la tua richiesta relativa ai problemi con l\'ordine '); 
define('FS_SEND_EMAIL_18', 'Ti ringraziamo per esserti rivolto a noi!'); 
define('FS_SEND_EMAIL_19', 'FS - Abbiamo ricevuto la tua richiesta di supporto '); 
define('FS_SEND_EMAIL_20', 'Grazie per aver contattato FS. Abbiamo ricevuto la tua richiesta di supporto; sarà nostra cura risponderti entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_21', 'Grazie per aver contattato FS. Abbiamo ricevuto la tua richiesta di supporto; sarà nostra cura risponderti entro un giorno lavorativo. E il tuo numero di caso è'); 
define('FS_SEND_EMAIL_22', 'Abbiamo ricevuto la tua richiesta di scorte relativa all\'articolo #'); 
define('FS_SEND_EMAIL_23', ' e ti contatteremo entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_24', 'Abbiamo ricevuto la tua richiesta di scorte relativa all\'articolo '); 
define('FS_SEND_EMAIL_25', ' e ti contatteremo entro un giorno lavorativo. E questo è il tuo numero di caso '); 
define('FS_SEND_EMAIL_26', '. Puoi fare riferimento a questo numero in tutte le successive comunicazioni relative a questa richiesta.'); 
define('FS_SEND_EMAIL_27', 'Il tuo articolo'); 
define('FS_SEND_EMAIL_28', 'Le tue note aggiuntive'); 
define('FS_SEND_EMAIL_29', 'Qtà richiesta: '); 
define('FS_SEND_EMAIL_30', ' Data di arrivo della richiesta: '); 
define('FS_SEND_EMAIL_31', 'FS - Abbiamo ricevuto la tua richiesta di scorte '); 
define('FS_SEND_EMAIL_32', 'FS - Abbiamo ricevuto la tua richiesta di reso'); 
define('FS_SEND_EMAIL_33', 'Abbiamo ricevuto la tua richiesta di rimborso; sarà nostra cura inviarti via e-mail ulteriori informazioni entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_34', 'FS - Abbiamo ricevuto la tua richiesta di sostituzione'); 
define('FS_SEND_EMAIL_35', 'Abbiamo ricevuto la tua richiesta di sostituzione; sarà nostra cura inviarti via e-mail ulteriori informazioni entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_36', 'FS - Abbiamo ricevuto la tua richiesta di rimanutenzione'); 
define('FS_SEND_EMAIL_37', 'Abbiamo ricevuto la tua richiesta di rimanutenzione; sarà nostra cura inviarti via e-mail ulteriori informazioni entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_38', ' Istruzioni per il tuo reso FS'); 
define('FS_SEND_EMAIL_39', 'Attieniti ai passi seguenti per completare il tuo reso per l\'ordine n.'); 
define('FS_SEND_EMAIL_40', 'Ordine di reso'); 
define('FS_SEND_EMAIL_41', ' e ti invieremo via e-mail ulteriori informazioni sulle tue parti di rimborso entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_42', ' e ti invieremo via e-mail ulteriori informazioni sulle tue parti di sostituzione entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_43', ' e ti invieremo via e-mail ulteriori informazioni sulle tue parti di rimanutenzione entro un giorno lavorativo.'); 
define('FS_SEND_EMAIL_44', 'Parti di rimborso'); 
define('FS_SEND_EMAIL_45', 'Parti di sostituzione'); 
define('FS_SEND_EMAIL_46', 'Parti di rimanutenzione'); 
define('FS_SEND_EMAIL_47', 'Rimborso'); 
define('FS_SEND_EMAIL_48', 'Siamo spiacenti di sapere che gli articoli del tuo ordine');
define('FS_SEND_EMAIL_49', ' non erano quelli giusti per te. Per completare il tuo reso');
define('FS_SEND_EMAIL_50', 'Al ricevimento degli articoli resi, emetteremo un rimborso ');
define('FS_SEND_EMAIL_51', ' sul tuo metodo di pagamento originale entro 1 giorno lavorativo. Il denaro sarà depositato sul tuo conto entro una settimana');
define('FS_SEND_EMAIL_52', ' Panoramica'); 
define('FS_SEND_EMAIL_53', 'Credito costo articoli:'); 
define('FS_SEND_EMAIL_54', 'Costo di spedizione del reso'); 
define('FS_SEND_EMAIL_55', 'Rimborso reso totale:'); 
define('FS_SEND_EMAIL_56', 'Metodo di rimborso:'); 
define('FS_SEND_EMAIL_57', 'Metodo di pagamento originale: '); 
define('FS_SEND_EMAIL_58', 'Per informazioni sulla nostra Politica sui resi'); 
define('FS_SEND_EMAIL_59', 'fai clic qui'); 
define('FS_SEND_EMAIL_60', 'Sostituzione'); 
define('FS_SEND_EMAIL_61', 'Siamo spiacenti di sapere che hai avuto problemi con il tuo ordine'); 
define('FS_SEND_EMAIL_62', ' Per completare la tua sostituzione'); 
define('FS_SEND_EMAIL_63', 'Al ricevimento degli articoli resi, organizzeremo la spedizione dell\'ordine di sostituzione il prima possibile e ti invieremo le informazioni di tracciamento quando disponibili.');
define('FS_SEND_EMAIL_64', 'Manutenzione');
define('FS_SEND_EMAIL_67', 'Al ricevimento degli articoli resi, organizzeremo la spedizione dell\'ordine di manutenzione il prima possibile e ti invieremo le informazioni di tracciamento quando disponibili.');
define('FS_SEND_EMAIL_68', 'Panoramica'); 
define('FS_SEND_EMAIL_69', 'Spedizione a'); 
define('FS_SEND_EMAIL_70', 'Informazioni di contatto'); 
define('FS_SEND_EMAIL_71', 'Rif.: N. PO'); 
define('FS_SEND_EMAIL_83', 'Prezzo: '); 
define('FS_SEND_EMAIL_84', 'Abbiamo ricevuto la tua richiesta di campionatura e ti aggiorneremo sull\'esito entro 24 ore.'); 
define('FS_SEND_EMAIL_85', 'Abbiamo ricevuto la tua richiesta di campionatura; un manager del nostro team dedicato ti contatterà a breve. E questo è il tuo numero di caso '); 
define('FS_SEND_EMAIL_86', '. Puoi fare riferimento a questo numero in tutte le successive comunicazioni relative a questa richiesta.'); 
define('FS_SEND_EMAIL_87', 'Lista campioni'); 
define('FS_SEND_EMAIL_88', 'Qtà richiesta: '); 
define('FS_SEND_EMAIL_89', 'Le tue note aggiuntive'); 
define('FS_SEND_EMAIL_90', 'FS - Abbiamo ricevuto la tua richiesta di campionatura '); 
define('FS_SEND_EMAIL_91', 'Chiave di licenza'); 
define('FS_SEND_EMAIL_92', 'Le tue informazioni di attivazione sono state inviate correttamente.'); 
define('FS_SEND_EMAIL_94', 'La tua chiave di licenza e i dettagli del tuo ordine sono forniti di seguito. Dovrai installare questa chiave di licenza sullo switch per attivare il software. Questa chiave di licenza è univoca per il tuo account. Saranno necessari circa 3 giorni per assisterti nell\'attivazione. Copia e incolla il testo della chiave di licenza al momento appropriato durante il processo di installazione della stessa.'); 
define('FS_SEND_EMAIL_95', 'Nota: La chiave di licenza sarà a lungo termine ed effettiva. Il periodo del servizio di supporto tecnico è di 1 anno ma potrai godere di ulteriori 45 giorni gratis se installi entro i 45 giorni.'); 
define('FS_SEND_EMAIL_96', 'Per qualsiasi domanda o se necessiti di assistenza'); 
define('FS_SEND_EMAIL_97', 'Chiave di licenza'); 
define('FS_SEND_EMAIL_98', 'Per Cumulus Linux 2.5.3 o versioni successive:'); 
define('FS_SEND_EMAIL_99', 'N. ordine: '); 
define('FS_SEND_EMAIL_100', 'Data: '); 
define('FS_SEND_EMAIL_101', 'Visualizza altro'); 
define('FS_SEND_EMAIL_102', 'FS - Chiave di licenza'); 
define('FS_SEND_EMAIL_103', '<br>Nota:'); 
define('FS_SEND_EMAIL_104', ' ti è stata inviata una richiesta di pagamento'); 
define('FS_SEND_EMAIL_105', 'Fattura n.: '); 
define('FS_SEND_EMAIL_106', 'Paga ora'); 
define('FS_SEND_EMAIL_107', 'FS - Hai una richiesta di pagamento da '); 
define('FS_SEND_EMAIL_108', 'Condividi lista del carrello'); 
define('FS_SEND_EMAIL_109', 'Il tuo amico '); 
define('FS_SEND_EMAIL_110', ' ha condiviso una lista del carrello con te.'); 
define('FS_SEND_EMAIL_111', 'Il tuo amico '); 
define('FS_SEND_EMAIL_112', ' ha condiviso una lista del carrello con te. Puoi fare clic sul pulsante sottostante per visualizzare i dettagli completi e aggiungerli al tuo carrello.'); 
define('FS_SEND_EMAIL_113', 'Lista carrello'); 
define('FS_SEND_EMAIL_115', 'Questa e-mail ti è stata inviata da '); 
define('FS_SEND_EMAIL_116', ' mediante '); 
define('FS_SEND_EMAIL_117', 'il servizio Condividi con un amico.'); 
define('FS_SEND_EMAIL_118', 'Come risultato della ricezione di questo messaggio'); 
define('FS_SEND_EMAIL_119', 'altre info sulla nostra '); 
define('FS_SEND_EMAIL_120', 'Informativa sulla privacy'); 
define('FS_SEND_EMAIL_121', 'FS - Il tuo amico '); 
define('FS_SEND_EMAIL_122', ' ha condiviso la tua lista del carrello'); 
define('FS_SEND_EMAIL_123', 'Condividi articolo'); 
define('FS_SEND_EMAIL_124', 'Potresti essere interessato a questo articolo'); 
define('FS_SEND_EMAIL_125', 'Altri dettagli'); 
define('FS_SEND_EMAIL_126', 'il servizio Condividi con un amico. Come risultato della ricezione di questo messaggio'); 
define('FS_SEND_EMAIL_127', ' altre info sulla nostra '); 
define('FS_SEND_EMAIL_129', ' ha condiviso con te un articolo'); 
define('FS_SEND_EMAIL_130', 'Aggiornamento RMA'); 
define('FS_SEND_EMAIL_131', 'La tua domanda di RMA per l\'ordine n. '); 
define('FS_SEND_EMAIL_132', ' è stata annullata. Siamo a tua disposizione per qualsiasi ulteriore problema.'); 
define('FS_SEND_EMAIL_133', 'RMA annullato'); 
define('FS_SEND_EMAIL_135', ' è stato annullato.'); 
define('FS_SEND_EMAIL_136', 'Siamo a tua disposizione per qualsiasi ulteriore problema.'); 
define('FS_SEND_EMAIL_137', 'Parti RMA'); 
define('FS_SEND_EMAIL_138', ' ti è stata inviata una richiesta di pagamento.'); 
define('FS_SEND_EMAIL_139', 'Aggiornamento ordine'); 
define('FS_SEND_EMAIL_140', 'Il tuo ordine n.'); 
define('FS_SEND_EMAIL_141', 'Ordine annullato'); 
define('FS_SEND_EMAIL_142', 'Grazie per aver fatto acquisti con noi e speriamo di rivederti presto.'); 
define('FS_SEND_EMAIL_143', 'Dettagli ordine'); 
define('FS_SEND_EMAIL_144', 'Condividi il commento'); 
define('FS_SEND_EMAIL_145', 'Con quale probabilità consiglieresti FS a un amico o collega?'); 
define('FS_SEND_EMAIL_146', 'Per garantirti la migliore esperienza di shopping possibile'); 
define('FS_SEND_EMAIL_147', 'Argomento del feedback'); 
define('FS_SEND_EMAIL_148', 'Grazie per aver contattato FS. Abbiamo ricevuto la tua e-mail e sarà nostra cura risponderti entro un 12 ore.'); 
define('FS_SEND_EMAIL_149', 'FS - Abbiamo ricevuto il tuo messaggio e-mail'); 
define('FS_SEND_EMAIL_150', 'Grazie per aver contattato FS. Abbiamo ricevuto la tua e-mail e sarà nostra cura risponderti entro un 12 ore. E il tuo numero di caso è '); 
define('FS_SEND_EMAIL_151', 'Condividi articolo'); 
define('FS_SEND_EMAIL_152', 'Potresti essere interessato in questo articolo'); 
define('FS_SEND_EMAIL_153', 'Il tuo amico '); 
define('FS_SEND_EMAIL_154', ' Questa e-mail ti è stata inviata dal '); 
define('FS_SEND_EMAIL_155', ' ha condiviso questo articolo con te tramite '); 
define('FS_SEND_EMAIL_156', 'FS - Il tuo RMA è stato annullato'); 
define('FS_SEND_EMAIL_157', 'FS - Abbiamo ricevuto la tua richiesta di preventivo '); 
define('FS_SEND_EMAIL_158', 'Messaggio da'); 
define('FS_SEND_EMAIL_159', 'Aggiungi alla lista'); 
define('FS_SEND_EMAIL_160', 'Il tuo ordine n.');
define('FS_SEND_EMAIL_160_01',"FS - Il tuo ordine #");
define('FS_SEND_EMAIL_161', 'FS - Il tuo ordine FS '); 
define('FS_SEND_EMAIL_162', 'Istruzioni per i resi'); 
define('FS_SEND_EMAIL_163', '1 Stampa RMA'); 
define('FS_SEND_EMAIL_164', 'L\'RMA può aiutarci a distinguere il tuo pacco. Stampa il modulo RMA e incollalo sulla scatola.'); 
define('FS_SEND_EMAIL_165', '2 Confeziona gli articoli'); 
define('FS_SEND_EMAIL_166', 'Rimuovi le vecchie etichette se utilizzi le scatole originali e incolla l\'RMA'); 
define('FS_SEND_EMAIL_167', '3 Spediscilo'); 
define('FS_SEND_EMAIL_168', 'Restituiscici il pacco');
define('FS_SEND_EMAIL_169', '4 Ricevi il tuo'); 
define('FS_SEND_EMAIL_170', 'Grazie per aver contattato FS. Abbiamo ricevuto la tua richiesta di chiamata e ti contatteremo nel momento per te più congeniale.'); 
define('FS_SEND_EMAIL_171', 'FS - Abbiamo ricevuto la tua richiesta di chiamata'); 
define('FS_SEND_EMAIL_3_1', 'Richiesta di pagamento'); 
define('PRERDER_PROCESSIONG', 'Tutti gli articoli di pre-ordine vengono spediti direttamente dalla fabbrica asiatica.<i class=\'popover_i\'></i>Il tempo di lavorazione si riferisce al giorno lavorativo'); 
define('PRERER_SAVE', ' per risparmiare sul budget del progetto'); 
define('CHECKOUT_CUSTOMER_ACCOUNT1', 'Inserisci un conto valido costituito da 9 numeri'); 
define('CHECKOUT_CUSTOMER_ACCOUNT2', 'Inserisci un conto valido costituito da 6 caratteri'); 
define('FS_CUSTOMIZED_INFORMATION', 'Informazioni personalizzate'); 
define('FS_CUSTOMIZED', 'Personalizzato');
define('FS_PROCESSING','In elaborazione');
define('FS_SHIPPING', 'Spedizione'); 
define('FS_DELIVERED', 'Consegnato'); 
define('FS_PROCESSING_EST', 'Elaborazione in corso:'); 
define('FS_SHIPPING_EST', 'Spedizione:'); 
define('FS_DELIVERED_EST', 'Consegnato:'); 
define('FS_BUSINESS_DAYS_ADD', ' giorni lavorativi');
define('FS_BUSINESS_DAYS_DELIVER_TO', 'giorni lavorativi'); 
define('FS_EST', 'Est.'); 
define('FS_CUSTOMIZED_ADD_TO_CART', 'Conferma'); 
define('FS_KEEP_SHOPPING', 'Continua lo shopping'); 
define('FS_CONTINUE_TO_CART', 'Continua per il carrello'); 
define('FS_ITEM_INCLUDES_PRODUCTS', 'Questo articolo comprende i seguenti prodotti');
define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Imposta'); 
define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Imposta ordine'); 
define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Totale generale'); 
define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Totale ordine'); 
define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', '(+Costo di spedizione):'); 
define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Costo di spedizione dell\'ordine'); 
define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Totale'); 
define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Subtotale ordine'); 
define('FS_SPECILA_INQUIRY_QUESTION', 'Domande? Ti metteremo sulla strada giusta.'); 
define('FS_SPECILA_INQUIRY_ASK', 'Chiedi in merito ai prodotti di pre-ordine o a magazzino'); 
define('FS_FILE_TOO_LARGE', 'File troppo grande'); 
define('FS_Summary', 'Riepilogo'); 
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_GRID', 'Visualizza come griglia'); 
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_LIST', 'Visualizza come elenco'); 
define('TPL_MODULES_INDEX_PRODUCT_LIST_OLD_STYLE_QUICKFINDER', 'Quickfinder'); 
define('FS_FAQ_HELPFUL_01', 'La risposta è stata utile?'); 
define('FS_FAQ_HELPFUL_02', 'Sì'); 
define('FS_FAQ_HELPFUL_03', 'No'); 
define('FS_FAQ_HELPFUL_04', 'Ti ringraziamo dei tuoi commenti.'); 
define('FS_FAQ_HELPFUL_05', 'Cosa possiamo migliorare?'); 
define('FS_FAQ_HELPFUL_06', 'La risposta era confusa'); 
define('FS_FAQ_HELPFUL_07', 'Questo non ha risposto alla mia domanda'); 
define('FS_FAQ_HELPFUL_08', 'Non apprezzo la vostra politica'); 
define('FS_FAQ_HELPFUL_09', 'Invia');
define('FS_CHECKOUT_NEW_CASHLESS', 'Pagamento senza contanti'); 
define('SHIPPING_COURIER_DELIVERY', 'Consegna del corriere');
define('SHIPPING_DELIVERY', 'Consegna');
define("SHIPPING_COURIER_DELIVERY_01"," per persona fisica");
define('CHECKOUT_TAXE_RU_TIT', 'In accordo al Capitolo 21 del Codice fiscale della Federazione Russa'); 
define('FS_CREDIT_CARD_NOTICE', 'Inserisci il tuo indirizzo di fatturazione per procedere al pagamento'); 
define('FS_CREDIT', 'Il mio credito'); 
define('FS_INQUIRY_INFO', 'Scheda preventivo'); 
define('FS_INQUIRY_INFO_1', 'Aggiungi nuovi prodotti'); 
define('FS_INQUIRY_INFO_2', 'Aggiungi'); 
define('FS_INQUIRY_INFO_3', 'L\'ID prodotto online non può essere vuoto'); 
define('FS_INQUIRY_INFO_4', 'Prezzo unitario'); 
define('FS_INQUIRY_INFO_5', ' Prendi nota '); 
define('FS_INQUIRY_INFO_6', 'Modifica'); 
define('FS_INQUIRY_INFO_7', 'Possiedi un account?'); 
define('FS_INQUIRY_INFO_8', 'Accedi</a> o '); 
define('FS_INQUIRY_INFO_9', 'Crea un account'); 
define('FS_INQUIRY_INFO_10', '  per rintracciare la tua richiesta online.'); 
define('FS_INQUIRY_INFO_11', 'Informazioni utili sul preventivo'); 
define('FS_INQUIRY_INFO_12', 'Logo'); 
define('FS_INQUIRY_INFO_13', 'Garanzia'); 
define('FS_INQUIRY_INFO_14', 'Tempo di consegna'); 
define('FS_INQUIRY_INFO_15', 'Prezzo sfuso'); 
define('FS_INQUIRY_INFO_16', 'Ordine PO'); 
define('FS_INQUIRY_INFO_17', 'Commenti aggiuntivi'); 
define('FS_INQUIRY_INFO_18', 'File'); 
define('FS_INQUIRY_INFO_19', 'Allow files type of JPG'); 
define('FS_INQUIRY_INFO_20', 'Invia la richiesta'); 
define('FS_INQUIRY_INFO_21', 'La richiesta di preventivo è vuota.'); 
define('FS_INQUIRY_INFO_22', 'Continua con gli acquisti');
define('FS_INQUIRY_INFO_24', 'La verifica richiederà circa 12 ore.'); 
define('FS_INQUIRY_INFO_25', 'Ottieni un preventivo'); 
define('FS_INQUIRY_INFO_26', 'L\'articolo seguente è un prodotto personalizzato'); 
define('FS_INQUIRY_INFO_26_2', 'L\'ID prodotto'); 
define('FS_INQUIRY_INFO_26_3', 'non è stato trovato nei nostri archivi.'); 
define('FS_INQUIRY_INFO_27', 'La tua richiesta di preventivo N.'); 
define('FS_INQUIRY_INFO_28', ' è stata inviata.');
define("FS_INQUIRY_INFO_29","Elaboreremo il preventivo e ti risponderemo entro 12-24 ore. Potresti visualizzare lo stato del tuo preventivo nel <b>Mio Account</b> > <b>Cronologia Preventivo</b>. ");
define('FS_INQUIRY_INFO_30', 'Salve Guest! '); 
define('FS_INQUIRY_INFO_30_1', 'Seleziona attributo '); 
define('FS_INQUIRY_INFO_31', 'Con un account'); 
define('FS_INQUIRY_INFO_32', '- Tracciamento facile tramite il tuo storico ordini'); 
define('FS_INQUIRY_INFO_33', '- Pagamento più veloce con la rubrica'); 
define('FS_INQUIRY_INFO_34', 'Desideri creare un account adesso?'); 
define('FS_INQUIRY_INFO_35', 'No'); 
define('FS_INQUIRY_INFO_36', 'Sì'); 
define('FS_INQUIRY_INFO_37', 'Storico preventivi');
define('FS_INQUIRY_INFO_38', 'Controlla lo stato dei tuoi preventivi e acquista direttamente con i prezzi preferenziali. '); 
define('FS_INQUIRY_INFO_39', 'Contatta il Servizio clienti'); 
define('FS_INQUIRY_INFO_40', 'Data richiesta preventivo'); 
define('FS_INQUIRY_INFO_41', 'N. preventivo'); 
define('FS_INQUIRY_INFO_42', 'Totale'); 
define('FS_INQUIRY_INFO_43', 'Nome preventivo'); 
define('FS_INQUIRY_INFO_43_1', 'Visualizza altro'); 
define('FS_INQUIRY_INFO_43_2', 'Annulla preventivo'); 
define('FS_INQUIRY_INFO_44', 'Aggiunto all\'elenco preventivi'); 
define('FS_INQUIRY_INFO_45', 'Quantità'); 
define('FS_INQUIRY_INFO_46', 'Vai alla lista'); 
define('FS_INQUIRY_INFO_47', 'Richiedi un preventivo'); 
define('FS_INQUIRY_INFO_48', 'Elenco richieste preventivo'); 
define('FS_INQUIRY_INFO_23', 'La tua richiesta di preventivo.');
define('FS_INQUIRY_INFO_23_1', ' è stata inviata'); 
define('FS_INQUIRY_INFO_49', 'Nome preventivo:'); 
define('FS_INQUIRY_INFO_50', 'Questo preventivo scadrà dopo XX giorni. Effettua il pagamento il più presto possibile.'); 
define('FS_INQUIRY_INFO_51', 'Il tuo preventivo è scaduto.'); 
define('FS_INQUIRY_INFO_52', 'Nota'); 
define('FS_INQUIRY_INFO_54', 'Inserire ID prodotto online (es.: 11522)'); 
define('FS_INQUIRY_INFO_55', 'L\'ID prodotto online non può essere vuoto'); 
define('FS_INQUIRY_INFO_56', 'Nome e cognome*'); 
define('FS_INQUIRY_INFO_57', 'Indirizzo e-mail*'); 
define('FS_INQUIRY_INFO_58', 'Numero di telefono*'); 
define('FS_INQUIRY_INFO_59', 'L\'ID prodotto '); 
define('FS_INQUIRY_INFO_60', ' non è stato trovato nei nostri archivi.'); 
define('FS_INQUIRY_INFO_61', 'Assegna nome al preventivo'); 
define('FS_INQUIRY_INFO_62', 'N. preventivo'); 
define('FS_INQUIRY_INFO_63', 'Seleziona un\'opzione per ciascun attributo in nero.'); 
define('FS_INQUIRY_BUY_TIP', 'Questo preventivo è valido solo per 7 giorni'); 
define('FS_INQUIRY_INFO_53', 'Elenco richieste preventivo'); 
define('FS_INQUIRY_INFO_64', 'Tutti i preventivi'); 
define('FS_INQUIRY_INFO_65', 'Questo preventivo è valido solo per 7 giorni');
define("FS_INQUIRY_INFO_66","Il preventivo è scaduto.");
define('FS_BUSINESS_ACCOUNT_01', 'IL MIO VANTAGGIO FS'); 
define('FS_BUSINESS_ACCOUNT_02', 'Crea un conto aziendale FS oggi stesso e ottieni uno sconto del 2% sui prodotti e servizi'); 
define('FS_BUSINESS_ACCOUNT_03', 'Prezzo preferenziale'); 
define('FS_BUSINESS_ACCOUNT_04', 'Consegna rapida'); 
define('FS_BUSINESS_ACCOUNT_05', 'Preventivi online facili'); 
define('FS_BUSINESS_ACCOUNT_06', 'Personalizzazione professionale'); 
define('FS_BUSINESS_ACCOUNT_07', 'Possiedi già un account? <a class="lr_right_href" href="' . zen_href_link('partner_update') . '">Aggiorna account</a>');
define('FS_BUSINESS_ACCOUNT_08', 'Hai bisogno di aiuto? Siamo qui 24 ore al giorno, 7 giorni su 7.'); 
define('FS_BUSINESS_ACCOUNT_09', 'Chat dal vivo'); 
define('FS_BUSINESS_ACCOUNT_10', '+49 (0 8165 80 90 517'); 
define('FS_BUSINESS_ACCOUNT_11', 'eu@fs.com'); 
define('FS_BUSINESS_ACCOUNT_12', 'Si applica un account aziendale'); 
define('FS_BUSINESS_ACCOUNT_13', 'Benvenuto in FS!'); 
define('FS_BUSINESS_ACCOUNT_14', 'La tua domanda è stata ricevuta'); 
define('FS_BUSINESS_ACCOUNT_15', 'Fai clic qui per accedere al tuo centro account.'); 
define('FS_BUSINESS_ACCOUNT_16', 'La tua domanda di account aziendale è in fase di verifica.'); 
define('FS_BUSINESS_ACCOUNT_17', 'Non hai un account? <a class="lr_right_href" href="' . zen_href_link('partner_submit') . '">  Account aziendale</a>');
define('FS_BUSINESS_ACCOUNT_18', 'Crea un account aziendale'); 
define('FS_BUSINESS_ACCOUNT_19', 'Aggiorna account'); 
define('FS_HEAVY', 'Pesante'); 
define('FS_OVERSIZED', 'Sovradimensionato'); 
define('FS_LOCAL_COMPANY_NAME', 'FS.COM GmbH'); 
define('FS_US_COMPANY_NAME', 'FS.COM INC'); 
define('FS_DE_COMPANY_NAME', 'FS.COM GmbH'); 
define('FS_UK_COMPANY_NAME', 'FIBERSTORE LTD'); 
define('FS_AU_COMPANY_NAME', 'FS.COM PTY LTD'); 
define('FS_SG_COMPANY_NAME', 'FS TECH PTE.LTD'); 
define('FS_RU_COMPANY_NAME', 'FS.COM Ltd.');
define('FS_CN_COMPANY_NAME','FS.COM LIMITED');

define('FS_AMP_CATE_01', '25G/100G'); 
define('FS_AMP_CATE_02', '40G'); 
define('FS_AMP_CATE_03', '10G'); 
define('FS_AMP_CATE_04', 'DAC/AOC'); 
define('FS_AMP_CATE_05', 'Switch'); 
define('FS_AMP_CATE_06', 'WDM<br>MUX'); 
define('FS_AMP_CATE_07', 'Fibra<br>Cavi'); 
define('FS_AMP_CATE_08', 'MTP/MPO<br>Cavi'); 
define('FS_AMP_CATE_09', 'Modulare<br>Cablaggio'); 
define('FS_AMP_CATE_10', 'Rame<br>Rete'); 
define('FS_AMP_INTERCONNECT_01', 'Interconnessione'); 
define('FS_AMP_OPTICAL_TRANS_01', 'Rete di trasporto ottica'); 
define('FS_AMP_NETWORK_CABLE_01', 'Cavi di rete assemblati'); 
define('FS_AMP_SPACE_MANAGE_01', 'Gestione dello spazio'); 
define('FS_AMP_SOLUTION_01', 'Soluzioni'); 
define('FS_AMP_FOOTER_01', 'Inviaci un\'e-mail'); 
define('FS_AMP_FOOTER_02', 'Chat dal vivo'); 
define('FS_AMP_FOOTER_03', 'Supporto chat dal vivo'); 
define('FS_AMP_FOOTER_04', 'Società'); 
define('FS_AMP_FOOTER_05', 'Accesso rapido'); 
define('FS_AMP_FOOTER_06', 'Copyright © 2009-2019 FS.COM Inc Tutti i diritti riservati.'); 
define('FS_AMP_FOOTER_07', 'Informativa sulla privacy'); 
define('FS_AMP_FOOTER_08', 'Termini d\'uso'); 
define('FS_AMP_FIRST_SIDEBAR_01', 'Account / Accedi'); 
define('FS_AMP_FIRST_SIDEBAR_02', 'Tutte le categorie'); 
define('FS_AMP_FIRST_SIDEBAR_03', 'Networking'); 
define('FS_AMP_FIRST_SIDEBAR_04', 'Ricetrasmettitori in fibra ottica'); 
define('FS_AMP_FIRST_SIDEBAR_05', 'Cavi in fibra ottica'); 
define('FS_AMP_FIRST_SIDEBAR_06', 'Rack & recinzioni'); 
define('FS_AMP_FIRST_SIDEBAR_07', 'WDM & accesso ottico'); 
define('FS_AMP_FIRST_SIDEBAR_08', 'Cat5e/Cat6/Cat7/Cat8'); 
define('FS_AMP_FIRST_SIDEBAR_09', 'Tester & strumenti'); 
define('FS_AMP_FIRST_SIDEBAR_10', 'Supporto'); 
define('FS_AMP_FIRST_SIDEBAR_11', 'Società'); 
define('FS_AMP_FIRST_SIDEBAR_12', 'Accesso rapido'); 
define('FS_AMP_FIRST_SIDEBAR_13', 'Impostazione Guida &'); 
define('FS_AMP_SECOND_SIDEBAR_01', 'Menu principale'); 
define('FS_AMP_SECOND_SIDEBAR_02', 'Networking'); 
define('FS_AMP_SECOND_SIDEBAR_03', 'Switch di rete'); 
define('FS_AMP_SECOND_SIDEBAR_04', 'Switch per data center'); 
define('FS_AMP_SECOND_SIDEBAR_05', 'PDU'); 
define('FS_AMP_SECOND_SIDEBAR_06', 'Adattatori di rete'); 
define('FS_AMP_SECOND_SIDEBAR_07', 'Router'); 
define('FS_AMP_SECOND_SIDEBAR_08', 'Convertitori multimediali'); 
define('FS_AMP_SECOND_SIDEBAR_09', 'Ricetrasmettitori in fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_10', 'Ricetrasmettitori 40G/100G'); 
define('FS_AMP_SECOND_SIDEBAR_11', 'Ricetrasmettitori SFP+'); 
define('FS_AMP_SECOND_SIDEBAR_12', 'Ricetrasmettitori SFP'); 
define('FS_AMP_SECOND_SIDEBAR_13', 'Cavi per collegamento diretto'); 
define('FS_AMP_SECOND_SIDEBAR_14', 'Cavi ottici attivi'); 
define('FS_AMP_SECOND_SIDEBAR_15', 'Ricetrasmettitori XFP'); 
define('FS_AMP_SECOND_SIDEBAR_16', 'Ricetrasmettitori video digitali'); 
define('FS_AMP_SECOND_SIDEBAR_17', 'Altri ricetrasmettitori'); 
define('FS_AMP_SECOND_SIDEBAR_18', 'Scatola FS'); 
define('FS_AMP_SECOND_SIDEBAR_19', 'Cavi in fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_20', 'Cablaggio in fibra MTP'); 
define('FS_AMP_SECOND_SIDEBAR_21', 'Cavi patch in fibra'); 
define('FS_AMP_SECOND_SIDEBAR_22', 'Cavi in fibra rinforzati'); 
define('FS_AMP_SECOND_SIDEBAR_23', 'Cablaggio in fibra MPO'); 
define('FS_AMP_SECOND_SIDEBAR_24', 'Cavi in fibra Ultra HD'); 
define('FS_AMP_SECOND_SIDEBAR_25', 'Cavi multifibre pre-terminati'); 
define('FS_AMP_SECOND_SIDEBAR_26', 'Trecce di cavo in fibra'); 
define('FS_AMP_SECOND_SIDEBAR_27', 'Adattatori e connettori per fibre'); 
define('FS_AMP_SECOND_SIDEBAR_28', 'Cavi in fibra sfusi'); 
define('FS_AMP_SECOND_SIDEBAR_29', 'Rack e recinzioni'); 
define('FS_AMP_SECOND_SIDEBAR_30', 'Rack e armadi'); 
define('FS_AMP_SECOND_SIDEBAR_31', 'Recinzioni a fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_32', 'Pannelli Patch in fibra'); 
define('FS_AMP_SECOND_SIDEBAR_33', 'Cassette in fibra MTP'); 
define('FS_AMP_SECOND_SIDEBAR_34', 'Cassette in fibra MPO'); 
define('FS_AMP_SECOND_SIDEBAR_35', 'Cassette in fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_57', 'Pannelli breakout MTP-LC'); 
define('FS_AMP_SECOND_SIDEBAR_58', 'Gestione dei cavi'); 
define('FS_AMP_SECOND_SIDEBAR_59', 'Sistema di raceway'); 
define('FS_AMP_SECOND_SIDEBAR_36', 'WDM & accesso ottico'); 
define('FS_AMP_SECOND_SIDEBAR_37', 'Mux Demux e OADM'); 
define('FS_AMP_SECOND_SIDEBAR_38', 'Componenti passivi'); 
define('FS_AMP_SECOND_SIDEBAR_39', 'Terminazione fibra'); 
define('FS_AMP_SECOND_SIDEBAR_40', 'Piattaforma di trasporto FMT WDM'); 
define('FS_AMP_SECOND_SIDEBAR_41', 'Moduli di infrastruttura FMT'); 
define('FS_AMP_SECOND_SIDEBAR_42', 'Detergente & tester'); 
define('FS_AMP_SECOND_SIDEBAR_43', 'Cat5e/Cat6/Cat7/Cat8'); 
define('FS_AMP_SECOND_SIDEBAR_44', 'Cavi patch'); 
define('FS_AMP_SECOND_SIDEBAR_45', 'Cavi trunk pre-terminati'); 
define('FS_AMP_SECOND_SIDEBAR_46', 'Cavi sfusi'); 
define('FS_AMP_SECOND_SIDEBAR_47', 'Pannelli Patch'); 
define('FS_AMP_SECOND_SIDEBAR_48', 'Gestione dei cavi'); 
define('FS_AMP_SECOND_SIDEBAR_49', 'Strumenti & tester per rame'); 
define('FS_AMP_SECOND_SIDEBAR_50', 'Tester & strumenti'); 
define('FS_AMP_SECOND_SIDEBAR_51', 'Detergente per fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_52', 'Tester per fibre di base'); 
define('FS_AMP_SECOND_SIDEBAR_53', 'Tester per fibre avanzato'); 
define('FS_AMP_SECOND_SIDEBAR_54', 'Lucidatura & giunzione fibre'); 
define('FS_AMP_SECOND_SIDEBAR_55', 'Strumenti per fibra ottica'); 
define('FS_AMP_SECOND_SIDEBAR_56', 'Strumenti & tester per rame'); 
define('FS_AMP_THIRD_SIDEBAR_01', 'Torna indietro'); 
define('FS_AMP_LOGIN_SIDEBAR_01', 'Account personale'); 
define('FS_AMP_LOGIN_SIDEBAR_02', 'Impostazione account'); 
define('FS_AMP_LOGIN_SIDEBAR_03', 'Storico dell\'ordine'); 
define('FS_AMP_LOGIN_SIDEBAR_04', 'Rubrica'); 
define('FS_AMP_LOGIN_SIDEBAR_05', 'I miei casi'); 
define('FS_AMP_LOGIN_SIDEBAR_06', 'I miei preventivi'); 
define('FS_AMP_LOGIN_SIDEBAR_07', 'Disconnetti'); 
define('FS_AMP_SEARCH_01', 'Ricerca più frequente'); 
define('FS_AMP_SELECT_LANG_01', 'Seleziona Paese/Regione'); 
define('FS_AMP_SELECT_LANG_02', 'Salva'); 
define('FS_EMAIL_SUBSCRIPTION_01', 'Iscrizioni e-mail'); 
define('FS_EMAIL_SUBSCRIPTION_02', 'Gestisci le tue preferenze di iscrizione all\'e-mail'); 
define('FS_EMAIL_SUBSCRIPTION_03', 'Iscrizioni e-mail'); 
define('FS_EMAIL_SUBSCRIPTION_04', 'Conferma l\'e-mail di cui desideri gestire l\'iscrizione'); 
define('FS_EMAIL_SUBSCRIPTION_05', 'Iscriviti alle e-mail FS per ulteriori informazioni sulle più recenti politiche preferenziali'); 
define('FS_EMAIL_SUBSCRIPTION_06', 'Le e-mail relative al tuo account e ai tuoi ordini sono importanti. Te le invieremo anche se avrai scelto di non ricevere le e-mail di marketing.'); 
define('FS_EMAIL_SUBSCRIPTION_07', 'Nota: Occorrono fino a 48 ore per l\'applicazione delle modifiche. Riceverai comunque le e-mail relative agli ordini'); 
define('FS_EMAIL_SUBSCRIPTION_08', 'Con quale frequenza desideri ricevere le promozioni?'); 
define('FS_EMAIL_SUBSCRIPTION_09', 'Normale'); 
define('FS_EMAIL_SUBSCRIPTION_10', 'Non più di una volta a settimana'); 
define('FS_EMAIL_SUBSCRIPTION_11', 'Non più di una volta al mese'); 
define('FS_EMAIL_SUBSCRIPTION_12', 'Mai'); 
define('FS_EMAIL_SUBSCRIPTION_13', 'Salva'); 
define('FS_EMAIL_SUBSCRIPTION_14', 'Annulla'); 
define('FS_EMAIL_SUBSCRIPTION_15', 'La tua richiesta è stata inviata correttamente.'); 
define('FS_EMAIL_SUBSCRIPTION_16', 'Ti invieremo una risposta entro 24 ore.'); 
define('FS_EMAIL_SUBSCRIPTION_17', 'Inserisci il tuo indirizzo e-mail.'); 
define('FS_EMAIL_SUBSCRIPTION_18', 'Visualizza');
define('FS_EMAIL_SUBSCRIPTION_19','<span class="iconfont icon">&#xf158;</span> Hai annullato l\'iscrizione con successo');
define('FS_EMAIL_SUBSCRIPTION_20','Non riceverai più le email commerciali.');
define('FS_EMAIL_SUBSCRIPTION_21','<span class="iconfont icon">&#xf158;</span>Ti sei iscritto/a con successo.');
define('FS_EMAIL_SUBSCRIPTION_22','Grazie per esserti iscritto/a alle e-mail di FS.');
define ('FS_EMAIL_SUBSCRIPTION_23', 'Inviami una volta al mese un\'email sull\'ultimo sviluppo di FS.');
define('FS_EMAIL_SUBSCRIPTION_24','Non riceverai più e-mail di richiesta di recensione FS.');
define('FS_EMAIL_SUBSCRIPTION_25','Non riceverai più email promozionali di FS e email di richiesta di recensione.');

define('FS_EMAIL_SUBSCRIPTION_FOOTER_01', 'Iscriviti'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_02', 'Ricevi le ultime notizie da FS'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_03', 'Il tuo indirizzo e-mail'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_04', 'Inserisci il tuo indirizzo e-mail.'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_05', 'Inserisci un indirizzo e-mail valido.'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_06', 'Grazie per la tua iscrizione.'); 
define('FS_EMAIL_SUBSCRIPTION_FOOTER_07','App Mobili');
define('FS_SHIPPING_RETURNS', '<a class="info_returns" href="javascript:;">Resi entro 30 giorni</a>'); 
define('FS_SHIPPING_WARRANTY', '<a class="info_warranty" href="javascript:;">Garanzia</a>'); 
define('FS_SHIPPING_SUPPORT', '<a class="info_support" href="javascript:;">Supporto tecnico</a>'); 
define('FS_SHIPPING_RETURNS_TITLE', 'Resi entro 30 giorni'); 
define('FS_SHIPPING_RETURNS_PART', 'FS fornisce il servizio di reso e sostituzione entro 30 giorni per garantirti un\'esperienza di shopping davvero priva di preoccupazioni. Se il motivo del reso è il risultato di un errore di FS'); 
define('FS_SHIPPING_WARRANTY_TITLE', 'Garanzia su una gamma completa di prodotti'); 
define('FS_SHIPPING_WARRANTY_PART', 'Se qualcosa va storto con il prodotto ma si supera il periodo del servizio di reso'); 
define('FS_SHIPPING_SUPPORT_TITLE', 'Supporto tecnico gratuito'); 
define('FS_SHIPPING_SUPPORT_PART', 'Per rendere la tua connettività più efficiente con un budget inferiore');
define('FS_SHIPPING_SUPPORT_PART_BR',"You can <a href='".reset_url('solution_support.html')."' target='_blank'>Request Technical Support</a> to get timely help for any questions about the items or a free connectivity solution design.");
define('FS_RETURN_BUTTON', 'Restituisci un articolo');
define('FS_PRODUCT_INQUIRY_3', 'La tua richiesta di preventivo è stata ricevuta da FS. Ti forniremo il nostro feedback più tardi.'); 
define('FS_PRODUCT_INQUIRY_1', 'Ti invieremo una risposta entro 24 ore.'); 
define('FS_PRODUCT_INQUIRY_2', 'Facendo clic sul pulsante sottostante'); 
define('FS_SALES_INFO_MODAL_ZIP_CODE', 'CAP*');

//2019.09.11  以下是未翻译
//2019.7.29 helun add 新版账户中心首页语言包
define('FS_ACCOUNT_NEW_01','Need Help?');
define('FS_ACCOUNT_NEW_02','Mon. - Fri.');
define('FS_ACCOUNT_NEW_03','Orders');
define('FS_ACCOUNT_NEW_04','My Orders');
define('FS_ACCOUNT_NEW_05','Returned');
define('FS_ACCOUNT_NEW_06','Available Credit Line:');
define('FS_ACCOUNT_NEW_07','Most Recent Orders');
define('FS_ACCOUNT_NEW_08','View My Orders');
define('FS_ACCOUNT_NEW_09','You haven’t made a purchase in a while.');
define('FS_ACCOUNT_NEW_10','Recently Viewed Products');
define('FS_ACCOUNT_NEW_11','Most Recent Quotes');
define('FS_ACCOUNT_NEW_12','View My Quotes');
define('FS_ACCOUNT_NEW_13','You haven’t created a quote in a while.');

//登陆超时
define('LOING_TIMEOUT','Per motivi di sicurezza,la sessione è scaduta. Si prega di accedere di nuovo.');
//产品详情AOC
define('PRODUCT_AOC','Cable length could be customized from 1m to 300m（3ft to 984.252ft）as you required.');
define('PRODUCT_AOC_1','Cable length could be customized from 1m to 30m（3ft to 98.43ft）as you required.');
//报价列表
define('QUOTE_EMPTY_1','You haven\'t made any quote requests yet.');
define('QUOTE_EMPTY_2','Inizia lo shopping');
define('QUOTE_EMPTY_3','No quote requests found.');

define("ATTRIBUTE_MESSAGE",'Perfettamente compatibile con gli switch Cisco, per la compatibilità Matrix, si prega di <a target="_blank" href="https://tmgmatrix.cisco.com">cliccare qui</a>.');

//购物车登陆且为空的状态 添加save cart入口
define('FS_SAVE_CART_ENTRANCE','Continua gli acquisti su FS o visualizza i tuoi <a target="_blank" href="'.zen_href_link('saved_items','type=saved_carts','SSL').'">carrelli salvati</a>.');
//报价添加打印
define('INQUIRY_GET_A_QUOTE','Need help with your purchase?');
define('INQUIRY_GET_A_QUOTE_1',"We're always committed to offering you the best quality items, favorable price with bulk order, fast processing procedures once order placed Call us at ");
define('INQUIRY_GET_A_QUOTE_2',' or email ');
define('INQUIRY_GET_A_QUOTE_3','Print Quote');
define('INQUIRY_GET_A_QUOTE_4','DETTAGLI PREVENTIVO');
define('INQUIRY_GET_A_QUOTE_5','Qtà (pz)');
define('INQUIRY_GET_A_QUOTE_6','Quote Price');

//add by liang.zhu 2019.07.04 functions_shippgin.php中的 zen_get_order_shipping_method_by_code函数使用
define('FS_CUSTOMER_ACCOUNT', 'Account di cliente');

//qv库存提示
define('QV_SHOW_AVAILABLE_01', 'Available, Need Transit');
define('QV_SHOW_AVAILABLE_02', 'Available, In Transit');


//分类文章
define('CASE_STUDIES_01','Regione');
define('CASE_STUDIES_02','Nord America');
define('CASE_STUDIES_03','America Latina');
define('CASE_STUDIES_04','Europa');
define('CASE_STUDIES_05','Oceania');
define('CASE_STUDIES_06','Africa');
define('CASE_STUDIES_07','Medio Oriente');
define('CASE_STUDIES_08','Asia');
define('CASE_STUDIES_09','Tipo di caso');
define('CASE_STUDIES_10','OTN');
define('CASE_STUDIES_11','Rete aziendale');
define('CASE_STUDIES_12','Cablaggio Centro Dati');
define('CASE_STUDIES_13','Industria');
define('CASE_STUDIES_14','Aerospaziale e difesa');
define('CASE_STUDIES_15','Servizi per i consumatori');
define('CASE_STUDIES_16','Istruzione');
define('CASE_STUDIES_17','Utenze elettriche');
define('CASE_STUDIES_18','Media');
define('CASE_STUDIES_19','ISP');
define('CASE_STUDIES_20','Servizi Informatici');
define('CASE_STUDIES_21','Altro');
define('CASE_CLEAR_ALL','Azzera');
define("FS_PRODUCTS","Risultati");
define("FS_PRODUCT","Risultato");
define('CASE_CATEGORY_MENU_CASE_STUDIES','Casi studi');
define('FS_TEST_TOOL','Strumento di test');

// add yang
define('FS_PRODUCT_INSTALLATION_TEXT_1','Si adatta <a href="c/fhd-rack-mount-45" style="color: #0070BC;">FHD rack mount</a> e <a href="c/fhd-wall-mount-3358" style="color: #0070BC;">alle custodie per fibra FHD </a> per montaggio a parete');
define('FS_PRODUCT_INSTALLATION_TEXT_2','Si adatta <a href="'.zen_href_link('product_info','products_id=68911','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> ad una custodia per fibra che può essere montata su un rack da 19\'\'');
define('FS_PRODUCT_INSTALLATION_TEXT_3','Si adatta <a href="'.zen_href_link('product_info','products_id=72772','SSL').'" style="color: #0070BC;">FHX-1UFSP</a> ad una custodia per fibra che può essere montata su un rack da 19\'\'');
define('FS_PRODUCT_INSTALLATION_TEXT_4','Si adatta <a href="'.zen_href_link('product_info','products_id=74183','SSL').'" style="color: #0070BC;">FHZ-1UFSP</a> ad una custodia per fibra che può essere montata su un rack da 19\'\'');

//dylan 2019.7.26
define('FS_PRODUCT_INSTALLATION_TEXT_5','Si adatta <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> and <a href="'.zen_href_link('product_info','products_id=79273','SSL').'" style="color: #0070BC;"> a mobili per network & server </a> serie HR800');
define('FS_PRODUCT_INSTALLATION_TEXT_6','Si adatta <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">GR600-Series</a> e <a href="'.zen_href_link('product_info','products_id=79272','SSL').'" style="color: #0070BC;"> a mobili per server</a> serie HR600');
define('FS_PRODUCT_INSTALLATION_TEXT_7','Si adatta <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> e <a href="'.zen_href_link('product_info','products_id=73958','SSL').'" style="color: #0070BC;">a mobili </a> serie GR600 ');
define('FS_PRODUCT_INSTALLATION_TEXT_8','Si adatta <a href="'.zen_href_link('product_info','products_id=73579','SSL').'" style="color: #0070BC;">GR800-Series</a> network & server cabinet');
//liang.zhu 2020.1.7
define('FS_PRODUCT_INSTALLATION_TEXT_9',' Il modulo FMX 100G si adatta al chassis <a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id=96454','SSL').'" style="color: #0070BC;">FMX-100G-CH2U</a> che può essere montato su rack');

// add by pico
define('CHECKOUT_ERROR_01', 'Please select the payment type.');
define('CHECKOUT_ERROR_02', 'The Cardholder Name is required.');
define('CHECKOUT_ERROR_03', 'The Card Number is required.');
define('CHECKOUT_ERROR_04', 'The Security Code is required.');

//add by Jeremy 新版一級分類頁
define('FS_IDEAS_ADVICE', 'Cartelle Applicazioni');
define('FS_BEST_SELLERS', 'Più Venduti');
define('FS_CASE_STUDIES', 'Casi Studi');


//add ternence
define('INQUIRY_TITLE','Invia l\'elenco della richiesta di preventivo tramite e-mail ');
define('INQUIRY_TITLE_1','Il tuo elenco di preventivo di condivisione');
define('INQUIRY_TITLE_2','Email inviata con successo');
define('INQUIRY_TITLE_3','L\'hai fatto! La tua richiesta di preventivo è stata inviata al tuo elenco di destinatari.');
define('INQUIRY_TITLE_4','Ritorna all\'elenco di preventivo');
define('INQUIRY_TITLE_5','Email inviata con successo');
define('INQUIRY_TITLE_6','Qualcuno ha creato un elenco di preventivo solo per te in modo che tu possa connetterti! Se hai ancora bisogno di aiuto, puoi sempre');
define('INQUIRY_TITLE_7','Aggiungere alla richiesta di preventivo');
define('INQUIRY_TITLE_8',' di seguito per aggiungere quello che vedi in questa pagina al tuo preventivo.');
define('INQUIRY_TITLE_9','Condividi l\'elenco di preventivo');
define('INQUIRY_TITLE_10','Elenco di preventivo');
define('INQUIRY_TITLE_11',' ti ha condiviso un elenco di richieste di preventivo. Puoi fare clic sul pulsante qui sotto per visualizzare i dettagli completi e aggiungerli al tuo elenco di preventivo.');
define('INQUIRY_TITLE_12',' ti ha condiviso un elenco di preventivi');
define('INQUIRY_TITLE_13','Aggiungi alla richiesta di preventivo');
define("FS_INQUIRY_INFO_67",'La tua richiesta di preventivo è vuota. Se hai già un account, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">accedi</a> per vedere il tuo preventivo.');
define("FS_INQUIRY_INFO_68",'Email');
define("FS_INQUIRY_INFO_69",'Qtà.');
//checkout 修改地址印度税号框提示
define('CHECKOUT_TAX_1','Codice fiscale');
define('CHECKOUT_TAX_2','È possibile essere esentati dal pagare l\'IVA se si dispone di un numero di identificazione fiscale valido.');

// 2019-7-4 potato 登录注册need help
define('FS_SIGN_IN_NEED_HTLP',"Bisogno d'aiuto?");
define('FS_SIGN_IN_CONTACT_CUSTOMER_SUPPORT',"Contatta il Servizio Clienti.");


//ery  add 2019.7.15  赠品提示语
define('FS_GIFT_TITLE_IS','Below item is free gift and will not be calculated in total price when checkout.');
define('FS_GIFT_TITLE_ARE','Below items are free gift and will not be calculated in total price when checkout.');
define('FS_GIFT_TITLE_FREE','<div class="addCrat_item_giftBox after"><span class="iconfont icon"></span><div class="addCrat_item_giftTxt1">Free Gift</div></div>');
define('FS_GIFT_CHECK_TITLE','Free gift is not available for the current shipping address, please choose test tool in product page if needed.');
define('FS_GIFT_TITLE_FREE_EMAIL','<div style="background: #ebf8e7;border-radius: 2px;display: inline-block;padding: 3px 10px;margin-bottom: 8px;line-height: 20px;"><span style="font-size: 16px;float: left;color: #18a109;"><img src="https://img-en.fs.com/includes/templates/fiberstore/images/pro-gift.png"></span><div style="padding-left: 21px;color: #18a109;">Free Gift</div></div>');

//新品标记
define('NEW_PRODUCTS_TAG','Nuovo');

//热卖标记
define('HOT_PRODUCTS_TAG','Hot');


define("INVALID_CVV_ERROR",'Security code is incorrect. Please enter the correct code and try again.');

//2019.8.20 jeremy 产品改码相关
define('FS_ACCOUNT_CODING_REQUESTS','Coding Requests');
define('FS_ACCOUNT_MY_CODING_REQUESTS','My Coding Requests');
define('FS_ACCOUNT_CODING_REQUEST_BTN','Request Coding');
define('CODING_REQUESTS_LIST','Coding Request Lists');
define('CODING_REQUESTS_CODING_DETAILS','Coding Request Details');

// 2019-7-19 potato 地址编辑提示修改
define('ACCOUNT_EDIT_CITY_AU','Suburb');
define('ACCOUNT_EDIT_STATE_AU','State');
define('FS_CITY_TITLE_ERROR','Your suburb is required.');
define('FS_POST_CODE_TITLE_ERROR','Il CAP è obbligatorio.');
define("FS_ZIP_CODE_AU_NEW","Postcode");

//add by liang.zhu 2019.09.02
define('FS_COMMON_LEARN_MORE', 'Scopri di più');
define('FS_COMMON_SEE_MORE', 'Vedi altro');
define('FS_COMMON_SEE_LESS', 'Vedi meno');

//模块标签属性
define('FS_PLACEHOLDER_EG','es: ');
define('FS_OPTIONAL',' (Opzionale)');

// 2019-9-2 potato 俄罗斯的税号
define('FS_CHECK_OUT_TAX_NEW_RU','VAT');
define('FS_CHECK_OUT_INCLUDEING_RU','(Including VAT)');
define('FS_CHECK_OUT_EXCLUDING_RU','(Excluding VAT)');

define("FS_CART_ITEM_TOTAL","Totale articolo");
define("FS_CART_ATTR_BTN","Select attribute(s)");
define("FS_CART_ATTR_CONTENT","This is a customized product. Please select attribute(s) first.");

// 表单次数提交频繁
define('FS_SUBMIT_TOO_OFTEN','Hai provato a portare a termine l\'azione troppe volte. Si prega di riprovare più tardi.');
define('FS_ROBOT_VERIFY_PROMOPT','Si prega di seguire le istruzioni per completare la verifica.');
//define('FS_STATE_EUROPE', 'Germania');
define("CHECKOUT_TAXE_SG_TIT", "Riguardo GTS e Tariffe");
define("CHECKOUT_TAXE_SG_FRONT", "Per gli ordini spediti dal deposito di Singapore e consegnati in luoghi all'interno di Singapore, FS è tenuta ad addebitare GST sul valore del prodotto e sulle spese di spedizione al tasso del 7%.<br/><br/> Se il prodotto(i) ordinato/i non sono attualmente disponibile/i, lo/li spediremo direttamente dal deposito in Asia (Cina) e non addebiteremo nessun GST. Tuttavia, a questi pacchi possono essere attribuiti dazi doganali o di importazione. Eventuali dazi doganali o di importazione devono essere dichiarati e saranno a carico del destinatario.");
//新加坡其他10国家
define("CHECKOUT_TAXE_SG_OTHERS_TIT", "Informazioni su dazi e tasse");
define("CHECKOUT_TAXE_SG_OTHERS_FRONT", "Per gli ordini consegnati verso destinazioni al di fuori di Singapore, addebiteremo solo il valore del prodotto e le spese di spedizione. Non verranno addebitate imposte sulle vendite (es. VAT o GST). Tuttavia, ai pacchi possono essere attribuiti dazi doganali o di importazione, a seconda delle leggi / regolamenti dei singoli paesi. Eventuali dazi doganali o di importazione causati dallo sdoganamento devono essere dichiarati e a saranno a carico del destinatario.");

//mtp退货货提示语
define('FS_RETURN_ALL_MTP_PRODUCTS','Si prega di restituire tutti questi accessori insieme.');
//2019-09-17 liang.zhu 国家所属于的洲
//北美洲
define('FS_STATE_NORTH_AMERICA', 'America del Nord');
//澳洲
define('FS_STATE_OCEANIA', 'Oceania');
//亚洲
define('FS_STATE_ASIA', ' Asia');
//欧洲
define('FS_STATE_EUROPE', 'Europa');
define('FS_PORTFOLIOS','cartelle');
define('FS_ORDER_LINK_REMARK','Osservazione');
define('FS_VIEW_INVOICE_BUBBLE','Contatta il tuo gestore dell\'account per ottenere la fattura aggiornata per questo ordine.');

define("FS_TIME_ZONE_RULE_SG","(GMT+8)");
define("FS_JS_TIT_CHECK_SG","9:00 - 17:00 ");
define("FS_SHIPPING_SG_GRAB_TIPS"," Questo servizio è disponibile per gli ordini di singole spedizioni spedite dal deposito SG e pagati entro le 15:00 nei giorni lavorativi.");
define("FS_TIME_ZONE_ADDRESS_SG","<span>FS Magazzino Singapore:</span> 30A Kallang Pl, #11-10/11/12, Singapore 339213 | +65 6443 7951");

//新加坡税号标题 add by quest
define('FS_SG_VAT_NUMBER',"GTS Registrazione numero");

//无时差报价
define('FS_SHOP_CART_ALERT_JS_121','Invia per email il tuo preventivo');
define("FS_INQUIRY_REVIEWING_1",'Inviato');
define("FS_INQUIRY_QUOTED_1",'Approvato');
define('FS_QUOTE_INFO_1','Dettagli sul Preventivo');
define("FS_INQUIRY_CANCELED_1",'Scaduto');
define('FS_QUOTE_INFO_2','Prezzo unitario');
define('FS_QUOTE_INFO_3','Prezzo indicativo');
define('FS_QUOTE_INFO_4','Prezzo preventivato');
define('FS_QUOTE_INFO_5','(Prezzo senza includere tasse e spese di spedizione)');
define('FS_QUOTE_INFO_6','Tutto');
define('FS_QUOTE_INFO_8','Seleziona prima l\'articolo .');
define('FS_QUOTE_INFO_9','Grazie. Abbiamo inviato via email il tuo preventivo al tuo elenco di destinatari.');
define('FS_QUOTE_INFO_10','Torna ai dettagli del preventivo');
define('FS_QUOTE_INFO_11','Richiedi un ulteriore preventivo');
define('FS_QUOTE_INFO_12','Preventivo veloce');
define('FS_QUOTE_INFO_13','Riepilogo (');
define('FS_QUOTE_INFO_14',' Prodotti');
define('FS_QUOTE_INFO_15','Target:');
define('FS_QUOTE_INFO_16','Prezzo senza includere tasse e spese di spedizione');
define('FS_QUOTE_INFO_17','A questo preventivo è stato abbinato uno sconto in base all\'insieme di prodotti selezionati. Se effettui il checkout con prodotti parziali, lo sconto non sarà più valido.');
define('FS_QUOTE_INFO_18','A questo preventivo sono stati abbinati specifici sconti in base alla quantità di ciascun prodotto selezionati. Se riduci la quantità dei prodotti durante il check-out, lo sconto per i prodotti selezionati non sarà più valido.');
define('FS_QUOTE_INFO_19','Creato');
define('FS_SEND_EMAIL_2019_1',"Abbiamo ricevuto la tua richiesta di un preventivo  ");
define('FS_SEND_EMAIL_2019_2',", il gestore del tuo account ti invierà il preventivo tra 30 minuti. Per favore trovalo in ");
define('FS_SEND_EMAIL_2019_3',"I miei preventivi");
define('FS_SEND_EMAIL_2019_4'," più tardi.");
define('FS_SEND_EMAIL_2019_5',"Il tuo cliente ");
define('FS_SEND_EMAIL_2019_6',"Richiesta preventivo");
define('FS_SEND_EMAIL_2019_7',"Il tuo prodotto");
define('FS_SEND_EMAIL_2019_8',"Quantità: ");
define('FS_SEND_EMAIL_2019_9',"Tuo Prodotto");
define('FS_SEND_EMAIL_2019_10',"Quantità");
define('FS_SEND_EMAIL_2019_11',"Prezzo indicativo");
define('FS_SEND_EMAIL_2019_12',"Prezzo Unitario");
define('FS_SEND_EMAIL_2019_13',"Subtotale:");
define('FS_SEND_EMAIL_2019_14',"Target:");
define('FS_SEND_EMAIL_2019_15',"Vai al preventivo");
define("FS_INQUIRY_INFO_65_1","Questo preventivo è valido solo per 15 giorni e scade  ");
define("FS_INQUIRY_INFO_65_2",", scadrà il ");
define("FS_INQUIRY_INFO_65_3","Totale complessivo:");

// rebirth  2019.08.16  订单支付超时提示语
define('FS_ORDERS_OVERTIMES_01','Si prega di completare il pagamento entro ');
define('FS_ORDERS_OVERTIMES_02','');
define('FS_ORDERS_OVERTIMES_03','');
define('FS_ORDERS_OVERTIMES_02_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_03_PO','');//德语的在po方面有语法区别
define('FS_ORDERS_OVERTIMES_04','In caso contrario, l\'ordine verrà annullato automaticamente a causa del cambiamento dell\' inventario degli articoli.');
define('FS_ORDERS_OVERTIMES_05','Si prega di caricare l\'ordine d\'acquisto entro ');
define('FS_ORDERS_OVERTIMES_06','Nota bene: Se si specifica il numero dell\'ordine FS al momento del trasferimento, l\'ordine verrà elaborato tempestivamente. Di solito la somma sarà ricevuta in 1-3 giorni lavorativi.');
define('FS_ORDERS_OVERTIMES_07','Il tuo ordine deve essere rivisto a causa del seguente motivo:');
define('FS_ORDERS_OVERTIMES_08','L\'indirizzo di spedizione non corrisponde agli indirizzi nel modulo di domanda di credito');
define('FS_ORDERS_OVERTIMES_09','Anche il tuo credito disponibile è stato superato');
define('FS_ORDERS_OVERTIMES_10','Si prega di pagare gli ordini precedenti per recuperare il credito o andare su "Il mio credito" per richiedere l\'aumento del limite di credito. Esamineremo l\'ordine e ti invieremo via email l\'esito.');
define('FS_ORDERS_OVERTIMES_11','Esamineremo l\'ordine e ti invieremo l\'esito via e-mail entro 12 ore.');
define('FS_ORDERS_OVERTIMES_12','Per elaborare rapidamente questo ordine, si prega di pagare gli ordini precedenti per recuperare il credito, oppure è possibile andare su "Il mio credito" per richiedere l\'aumento del limite di credito.');
define('FS_ORDERS_OVERTIMES_13','Termina tra');
define('FS_ORDERS_OVERTIMES_14','d'); //天  这三个是英文的 giorno ora minuto 首字母缩写
define('FS_ORDERS_OVERTIMES_15','h'); //时
define('FS_ORDERS_OVERTIMES_16','m'); //分
define('FS_ORDERS_OVERTIMES_17','Siamo spiacenti, il tuo ordine è stato annullato a causa del superamento della scadenza per il pagamento.');
define('FS_ORDERS_OVERTIMES_18','Puoi trovarlo nello Storico ordini e fare clic su "Acquista di nuovo" per effettuare un altro ordine.');
define('FS_ORDERS_OVERTIMES_19','Qualcosa è andato storto con il tuo ordine......');
define('FS_ORDERS_OVERTIMES_20','Abbiamo ricevuto la tua rimessa da');
define('FS_ORDERS_OVERTIMES_21','Purtroppo, l\'ordine è stato chiuso a causa del superamento della scadenza (indicata sugli ordini in sospeso di FS) per il pagamento. Contatta il tuo gestore account per ripristinare l\'ordine. Ci scusiamo per l\'inconveniente!');
define('FS_ORDERS_OVERTIMES_22','Ci sono fatture scadute nel tuo conto Net Term. Si prega di pagare gli ordini precedenti. Oppure il tuo gestore account dedicato ti contatterà e chiederà ulteriori documenti per la revisione.');
// rebirth  2019.09.06  订单支付超时  提醒邮件语言包
define('FS_ORDERS_OVERTIMES_36','Promemoria ordine FS - Pagamento in sospeso ');
define('FS_ORDERS_OVERTIMES_23','Promemoria ordine');
define('FS_ORDERS_OVERTIMES_24','Grazie per aver scelto FS. Abbiamo notato che hai lasciato un ordine non pagato <b style="font-weight: 600;">');
define('FS_ORDERS_OVERTIMES_25','<b style="font-weight: 600;">Nota bene </b>: se hai pagato l\'ordine, ignora questa email. Elaboreremo presto il tuo ordine. Se non desideri questo ordine, ignora questa email. L\'ordine verrà annullato dal sistema in seguito automaticamente se non viene pagato.');
define('FS_ORDERS_OVERTIMES_26','Le auguriamo una buona giornata!');
define('FS_ORDERS_OVERTIMES_27','</b>.  Le ricordiamo che verrà annullato automaticamente in seguito ');
define('FS_ORDERS_OVERTIMES_28','. Solo <a style="color: #0070bc;text-decoration:none;" href="');
define('FS_ORDERS_OVERTIMES_29','">Clicca qui</a> per completare l\'acquisto così da poter elaborare il tuo ordine al più presto.');



//by rebirth 2019.10.18 新版上传提示 英语
define("FS_UPLOAD_NEW_NOTICE_ONE","Si prega di tilizzare un documento PDF, JPG, PNG, DOC, DOCX, XLS, XLSX o TXT.");
define("FS_UPLOAD_NEW_NOTICE_TWO","Si prega di tilizzare un documento JPG, GIF, PNG, JPEG o BMP.");
define("FS_UPLOAD_NEW_NOTICE_THREE","Dimensione massima 5M.");
define("FS_UPLOAD_NEW_NOTICE_FOUR","Dimensione massima 300KB.");
define("FS_UPLOAD_NEW_ERROR_1","Il file caricato non è consentito!"); //该文件不允许上传
define("FS_UPLOAD_NEW_ERROR_2","Il file esiste già!");  //文件已存在
define("FS_UPLOAD_NEW_ERROR_3","Impossibile caricare i documenti sul server cloud."); //文件上传云服务器失败
define('FS_UPLOAD_NEW_ERROR_4', 'Il file caricato supera la direttiva upload_max_filesize in php.ini.');//文件大小超过php.ini的限制
//quest 新加坡安装
define('FS_SHOP_CART_SG_INSTALL','Installazione gratuita disponibile per articoli nel deposito SG. Fai checkout per scoprire di più.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_1','Hai selezionato il servizio di installazione. Quando l\'ordine sarà pronto per la spedizione, il nostro specialista tecnico ti contatterà prima di recarsi al tuo domicilio.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_2','Hai selezionato il servizio di installazione. Assicurati di completare il pagamento prima dell\'orario di installazione pianificato, altrimenti il servizio potrebbe essere ritardato.');
define('FS_CHECKOUT_SGINSTALL_SUCCESS_3','Hai selezionato il servizio di installazione. Assicurarsi di caricare il file dell\'ordine d\'acquisto prima del\'orario di installazione pianificato, altrimenti il servizio potrebbe essere ritardato.');

//Quest 2019.10.24 新加坡上门安装提示语
define('FS_CHECKOUT_SGINSTALL_CC','Hai selezionato il servizio di installazione. Assicurati di completare il pagamento prima dell\'orario di installazione pianificato, altrimenti il servizio potrebbe essere ritardato.');
define('FS_SG_DELIVERY_FREE_RETURNS_CONTENT','Il servizio di installazione gratuito è supportato per tutti i prodotti in stock. Puoi scegliere il servizio alla pagina di pagamento.');
define('FS_SG_DELIVERY_RETURN','Installazione gratuita');
define('FS_SHIPPING_SG_INSTALL_TIPS','Per questa consegna, è possibile selezionare l\'orario di installazione più comodo per te. I servizi di installazione sono disponibili solo con consegna FS e installazione gratuita.');

//aron 2019.10.24 新加坡安装时间
define('FS_SG_CALENDAR_1',"Seleziona fascia oraria per l\'installazione");
define('FS_SG_CALENDAR_2',"Ottine orari per l\'installazione disponibili");
define('FS_SG_CALENDAR_3',"Si prega di selezionare la consegna e l'installazione di FS");
define('FS_SG_CALENDAR_4',"Si prega di selezionare l\'orario di installazione più comodo per lei.");
define("FS_SG_CALENDAR_5","Installazione in loco");
define("FS_SG_CALENDAR_6",'Cambio di consegna');
define("FS_SG_CALENDAR_7","Hai annullato tutte le richieste di installazione. Organizzeremo per te la consegna dei pacchi.");
define("FS_SG_CALENDAR_8","Annulla");
define("FS_SG_CALENDAR_9","Sì,grazie");
define("FS_SG_CALENDAR_10",'Solo gli articoli selezionati verranno installati dopo la consegna.');
define("FS_SG_CALENDAR_11",'* Il servizio di installazione è attualmente disponibile per gli articoli spediti dal deposito SG. Siamo spiacenti per l\'inconveniente.');
//rebirth 2019.10.25 新加坡上门服务-账户中心
define("FS_SG_CALENDAR_100","Richiedi l\'installazione");
define("FS_SG_CALENDAR_101","Scegli il tipo di servizio");
define("FS_SG_CALENDAR_102","Si prega di selezionare");
define("FS_SG_CALENDAR_103","Supporto progetto");
define("FS_SG_CALENDAR_104","Risoluzione dei problemi e riparazione");
define("FS_SG_CALENDAR_105","Seleziona il tipo di servizio.");
define("FS_SG_CALENDAR_106","Descrivi i dettagli della tua richiesta*");
define("FS_SG_CALENDAR_107","Descrivi la tua richiesta.");
define("FS_SG_CALENDAR_108","Il contenuto deve contenere almeno 4 caratteri.");
define("FS_SG_CALENDAR_109","Il contenuto deve contenere al massimo 500 caratteri.");
define("FS_SG_CALENDAR_110","Richiesta di installazione");
define("FS_SG_CALENDAR_111","Tipo di servizio");
define("FS_SG_CALENDAR_112","Orario pianificato");
define("FS_SG_CALENDAR_113","Dettagli richiesta");
define("FS_SG_CALENDAR_114","Installazione pianificata");
define("FS_SG_CALENDAR_115","La tua richiesta di installazione è stata ricevuta.");
define("FS_SG_CALENDAR_116","Il nostro specialista tecnico ti contatterà prima di recarsi al tuo domicilio.");

// add by quest 20190.10.26 新加坡表单验证提示语
define('FS_SGVISIT_FROM_ERROR1','Inserire il proprio nome.');
define('FS_SGVISIT_FROM_ERROR2','Inserire indirizzo email.');
define('FS_SGVISIT_FROM_ERROR3','Inserire nome della propria azienda.');
define('FS_SGVISIT_FROM_ERROR4','Il numero di telefono deve essere composto da cifre.');
define('FS_SGVISIT_FROM_ERROR5','È richiesto il numero di visitatori.');
define('FS_SGVISIT_FROM_ERROR6','Il numero dei visitatori devono essere cifre.');
define('FS_SGVISIT_FROM_ERROR7','Si prega di pianificare un orario di visita.');
define('FS_SGVISIT_FROM_ERROR8','Si prega di inserire un indirizzo email valido.');

define('FS_FESTIVAL16','Festività nazionale in Singapore il');
define('FS_FESTIVAL17',' nel deposito SG.');

//ternence 新加坡上门服务邮件
define("FS_SG_EMAIL","Grazie per aver scelto FS Singapore, abbiamo ricevuto il tuo ordine ");
define("FS_SG_EMAIL_1","Complete the payment and you will hear from us again once the order is scheduled for free installation.");
define("FS_SG_EMAIL_2","Alcuni prodotti sono elegibili per l\'installazione gratuita, puoi <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">richiedere il servizio di installazione</a> se la necessiti. Completa il pagamento e ti terremo aggiornato.");
define("FS_SG_EMAIL_3","Hai selezionato il servizio di installazione per il tuo ordine ");
define("FS_SG_EMAIL_4"," Ti contatteremo quando il nostro specialista tecnico si dirigerà verso il tuo indirizzo di consegna.");
define("FS_SG_EMAIL_5","Tieni traccia dell\'avanzamento del tuo ordine accedendo al tuo account e andando su ");
define("FS_SG_EMAIL_6","Dettagli del tuo ordine ");
define("FS_SG_EMAIL_7","sono qui sotto. Ti invieremo un\'email non appena ci saranno aggiornamenti riguardi il tuo ordine.");
define("FS_SG_EMAIL_8","Puoi tenere traccia dell\'avanzamento del tuo ordine accedendo al tuo account e andando su ");
define("FS_SG_EMAIL_9"," Si prega di notare che l\'installazione gratuita è disponibile per quest\'ordine, puoi selezionare un orario <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">qui</a>.");
define("FS_SG_EMAIL_10","Il tuo ordine ");
define("FS_SG_EMAIL_11"," è pronto per l\'installazione e il nostro specialista tecnico si recherà tempestivamente al tuo indirizzo.");
define("FS_SG_EMAIL_12","Per eventuali modifiche, la preghiamo di contattarci a <a style=\"color: #0070bc;text-decoration: none\" href=\"tel:+(65) 6443 7951\">+(65) 6443 7951</a> o via email a <a style=\"color: #0070bc;text-decoration: none\" href=\"mailto:sg@fs.com\">sg@fs.com</a>.");
define("FS_SG_EMAIL_13","Grazie");
define("FS_SG_EMAIL_14","Il Team FS");
define("FS_SG_EMAIL_15","Info contatti:");
define("FS_SG_EMAIL_16","Numero di telefono:");
define("FS_SG_EMAIL_17","Indirizzo:");
define("FS_SG_EMAIL_18","Orario programmato:");
define("FS_SG_EMAIL_19","Ordine FS numero #");
define("FS_SG_EMAIL_20"," - Promemoria dell\'installazione");
define("FS_SG_EMAIL_21","Grazie per aver scelto FS Singapore. Abbiamo notato che hai lasciato un ordine in sospeso");
define("FS_SG_EMAIL_22","con servizio di installazione in loco. Le ricordiamo che il servizio è stato annullato.");
define("FS_SG_EMAIL_23","Solo <a href=".zen_href_link('manage_orders')." style=\"color: #0070BC;text-decoration: none\" target=\"_blank\">Clicca qui</a> per completare l\'acquisto e puoi selezionare un nuovo orario comodo per il servizio di installazione su Il mio account.");
define("FS_SG_EMAIL_24","Il tuo ordine FS #");
define("FS_SG_EMAIL_25"," è stato spedito");
define("FS_SG_EMAIL_26","Promemoria installazione");
define("FS_SG_EMAIL_27","Installazione annullata");
define("FS_SG_EMAIL_28","Promemoria pagamento");

//新加坡拜访邮件
define('FS_SG_VISIT_EAMIL_TITLE','Richiesta ricevuta');
define('FS_SG_VISIT_EAMIL_END_TITLE','Visitaci Email');

define('FS_SG_DELIVERY_INSTALLATION', 'Consegna FS e installazione gratuita');
define('FS_SG_NEXT_WORKING_DAY', 'Consegna FS entro il giorno lavorativo successivo');
define('FS_SG_SAME_WORKING_DAY', 'Consegna FS nello stesso giorno lavorativo');
define('FS_ACCOUNT_DETELE','Il corrente account è stato eliminato');
define('FS_SG_SIMPLYPOST_SHIPPING', 'SimplyPost 1-3 giorni lavorativi');

//rebirth 2019.10.17 订单超时,分钟,工作日的单复数处理
define('FS_ORDERS_OVERTIMES_30','minuto');
define('FS_ORDERS_OVERTIMES_31','minuti');
define('FS_ORDERS_OVERTIMES_32','giorno lavorativo');
define('FS_ORDERS_OVERTIMES_33','giorni lavorativi');
define('FS_ORDERS_OVERTIMES_34','');
define('FS_ORDERS_OVERTIMES_35','');

//liang.zhu 2019.10.31 product_support页面的service type, 同时也在my_case_details页面上使用
define('PRODUCT_SUPPORT_SERVICE_TYPE', 'Tipo di servizio');
define('PRODUCT_SUPPORT_SERVICE_TYPE_01', 'Supporto per l\'utilizzo del prodotto');
define('PRODUCT_SUPPORT_SERVICE_TYPE_02', 'Supporto connettività link');
define('PRODUCT_SUPPORT_SERVICE_TYPE_03', 'Supporto per l\'installazione e configurazione');
define('PRODUCT_SUPPORT_SERVICE_TYPE_04', 'Altro');

//邀请评论
define("EMAIL_MESSAGE_TITTLE","Condividi l'esperienza");
define("EMAIL_MESSAGE_01","Che ne dici di noi?");
define("EMAIL_MESSAGE_02","Scrivi la tua recensione");
define('EMAIL_MESSAGE_CONTENT', 'Ti saremmo molto grati se ci aiuti e gli altri clienti scrivendo la recensione per i prodotti che hai acquistato recentemente per l\'ordine <a style="color: #0070bc;text-decoration: none;" href="javascript:;">#ORDER_NUMBER</a>. Ci vuole solo un minuto e aiuterebbe davvero gli altri. Clicca sul pulsante in basso e scrivi la tua recensione!');
define('EMAIL_MESSAGE_SUBTITLE', ' Hai delle domande sul tuo ordine?');
define('EMAIL_MESSAGE_SUB_CONTENT', 'Che si tratti di supporto tecnico, domande sulla garanzia o sulla consegna, siamo lieti di aiutarti. Vai a <a style="color: #0070bc;text-decoration: none;" href="javascript:;">Centro Assistenza</a> per un\'assistenza rapida e utile.');
define('EMAIL_TO_LICENSE_5','Vedi altro');
define('EMAIL_TO_LICENSE_6','Ecco un nuovo articolo per cui puoi scrivere la recensione su FS.COM');


//针对4，5星评论给客户发送第二封邮件
define('EMAIL_REVIEWS_FOUR_FIVE_01', 'Grazie per il tuo sostegno');
define('EMAIL_REVIEWS_FOUR_FIVE_02', 'Apprezzeremmo molto il tuo feedback sulla tua esperienza su Trustpilot. Ti preghiamo di dedicare un momento per valutare FS.');
define('EMAIL_REVIEWS_FOUR_FIVE_03', 'La tua valutazione');
define('EMAIL_REVIEWS_FOUR_FIVE_04', 'La tua recensione (buona, cattiva o altra) verrà pubblicata immediatamente su Trustpilot.com per aiutare le altre persone a prendere decisioni più consistenti.');
define('EMAIL_REVIEWS_FOUR_FIVE_05', 'Grazie ancora per il tempo dedicato a fornire il tuo feedback e non vediamo l\'ora di vederti di nuovo presto! <br>FS Team.');
define('EMAIL_REVIEWS_FOUR_FIVE_06', 'Valutaci');
define('EMAIL_REVIEWS_FOUR_FIVE_07', 'La tua opinione conta - Grazie per la condivisione');

//表达修改 by rebirth  2019/11/13
define('FS_TECHNICAL_SUPPORT','Supporto Tecnico');
define('FS_REQUEST_SUPPORT','Richiedi supporto');

//账户中心报价改版2019/11/20
define("FS_INQUIRY_LIST_1",'Stato del preventivo');
define("FS_INQUIRY_LIST_2",'Preventivo attivo');
define("FS_INQUIRY_LIST_3",'Contatta il servizio clienti');
define("FS_INQUIRY_LIST_4",'Preventivi attivi:');
define("FS_INQUIRY_LIST_5",'Preventivo numero #');
define("FS_INQUIRY_LIST_6",'Cerca');
define("FS_INQUIRY_LIST_7",'Data richiesta preventivo:');
define("FS_INQUIRY_LIST_8",'Subtotale');
define("FS_INQUIRY_LIST_9",'Quantità:');
define("FS_INQUIRY_LIST_10",'Vedi altro ...');
define("FS_INQUIRY_LIST_11",'Il preventivo è valido fino al ');
define("FS_INQUIRY_LIST_12",'Il preventivo è scaduto il ');
define("FS_INQUIRY_LIST_13",'NESSUN PREVENTIVO TROVATO.');
define("FS_INQUIRY_LIST_14",'Inizia ad acquistare');
define("FS_INQUIRY_LIST_15",'Se non riesci a trovare il tuo preventivo, prova a selezionare differenti opzioni di filtro.');
define("FS_INQUIRY_LIST_16",'Dettagli richiesta preventivo');
define("FS_INQUIRY_LIST_17",'Nome preventivo:');
define("FS_INQUIRY_LIST_18",'Richiedi un ulteriore preventivo');
define("FS_INQUIRY_LIST_19",'Aggiungi al carrello');
define("FS_INQUIRY_LIST_20",'Stampa questa pagina');
define("FS_INQUIRY_LIST_21",'Richiesta preventivo');
define("FS_INQUIRY_LIST_22",'Prodotto');
define("FS_INQUIRY_LIST_23",'Prezzo articolo');
define("FS_INQUIRY_LIST_24",'Quantità');
define("FS_INQUIRY_LIST_25",'Prezzo preventivato');
define("FS_INQUIRY_LIST_26",'Identificativo cliente:');
define("FS_INQUIRY_LIST_27",'Gestore account:');
define("FS_INQUIRY_LIST_28",'Telefono numero #:');
define("FS_INQUIRY_LIST_29",'Subtotale preventivato:');
define("FS_INQUIRY_LIST_30",'Di seguito è riportato il preventivo che hai richiesto, il tuo gestore d\'account ti risponderà entro 24 ore.');
define("FS_INQUIRY_LIST_30_1",'Il preventivo è in fase di revisione da parte del tuo gestore account, riceverai una risposta entro 24 ore.');
define("FS_INQUIRY_LIST_31",'Il preventivo è in fase di revisione da parte del tuo gestore account, riceverai una risposta entro 24 ore.');
define("FS_INQUIRY_LIST_32",'Di seguito è riportato il dettaglio del preventivo. Questo preventivo è valido fino al ');
define("FS_INQUIRY_LIST_33",'Questo preventivo è scaduto il ');
define("FS_INQUIRY_LIST_34",'.Puoi richiedere un ulteriore preventivo se necessario.');

define("FS_INQUIRY_LIST_35",'Preventivo numero#');
define("FS_INQUIRY_LIST_36",'Data richiesta preventivo:');
define("FS_INQUIRY_LIST_37",'Preventivo numero #:');
define("FS_INQUIRY_LIST_38",'Articolo numero: #');
define("FS_INQUIRY_LIST_38_1",'Articolo numero #: ');
define("FS_INQUIRY_LIST_39",'Di seguito è riportato il preventivo di vendita che hai richiesto.');
define("FS_INQUIRY_LIST_40",'RIFERIMENTO');
define("FS_INQUIRY_LIST_41",'Stampa questa pagina');
define("FS_INQUIRY_LIST_42",'Data preventivo:');

// manage address
define("FS_CREATE_NEW_ADDRESS", 'Crea un nuovo indirizzo');
define("FS_DEFAULT", 'Predefinito');
define("FS_SAVE_ADDRESSES", 'Indirizzi salvati');
define("FS_EDIT_REMOVE", 'Modifica/ Rimuovi');
define("FS_EDIT", 'Modifica');
define("FS_REMOVE", 'Rimuovi');
define("FS_NO_SHIPPING_ADDRESS_HISTORY", 'NESSUNO STORICO DI INDIRIZZI DI SPEDIZIONE.');
define("FS_NO_BILLING_ADDRESS_HISTORY", 'NESSUNO STORICO DI INDIRIZZI DI FATTURAZIONE.');

//2019.11.22 ery  add 账户中心订单产品加购提示语
define('FS_MANAGE_CUSTOM_TIP', 'Questo prodotto è personalizzato, vai alla pagina sui dettagli del prodotto per selezionarne le caratteristiche specifiche.');
define('FS_MANAGE_CLOSE_TIP', 'Questo prodotto non è più disponibile online. Si prega di contattare il proprio gestore account per verificare ciò, oppure puoi controllare se è disponibile online un prodotto simile.');

/**
 * by  rebirth   账户中心改版——my_credit页面
 */
define('FS_NEW_ACCOUNT_MY_CREDIT_01','Il tuo stato');
define('FS_NEW_ACCOUNT_MY_CREDIT_02',' Termini');
define('FS_NEW_ACCOUNT_MY_CREDIT_03','Bilancio consumato');
define('FS_NEW_ACCOUNT_MY_CREDIT_04','Limite credito totale');
define('FS_NEW_ACCOUNT_MY_CREDIT_05','Richiedi un aumento');
define('FS_NEW_ACCOUNT_MY_CREDIT_06','Cerca ordine');
define('FS_NEW_ACCOUNT_MY_CREDIT_07','Ordine d\'acquisto numero#, Ordine numero#');
define('FS_NEW_ACCOUNT_MY_CREDIT_08','Data');
define('FS_NEW_ACCOUNT_MY_CREDIT_09','NESSUNO STORICO DI ORDINI DI ACQUISTO.');
define('FS_NEW_ACCOUNT_MY_CREDIT_10','Inizia ad acquistare');
define('FS_NEW_ACCOUNT_MY_CREDIT_11','NESSUN ORDINE DI ACQUISTO TROVATO.');
define('FS_NEW_ACCOUNT_MY_CREDIT_12', 'Cerca');

// 账户中心首页
define("FS_ACCOUNT_ADMINISTRATOR",' Amministratore Account:');
define("FS_ACCOUNT_NEW",'Numero account:');
define("FS_NAME",'Nome');
define("FS_ACCOUNT_MANAGE_CONTACT",' Contatto Manager d\'account:');
define("FS_ACCOUNT_PHONE",'Telefono:');
define("FS_ACCOUNT_ORDERS_PENDING",'Ordini in sospeso');
define("FS_ACCOUNT_ORDERS_PROGRESSING",'In progresso');
define("FS_ACCOUNT_ORDERS_COMPLETED",'Completato');
define("FS_ACCOUNT_ORDERS_ACTIVE_QUOTE",'Preventivo attivo');
define("FS_ACCOUNT_ORDERS_RMA",'Richiesta di autorizzazione al reso');
define("FS_ACCOUNT_ORDERS",'ORDINI');
define("FS_ACCOUNT_VIEW_TRACK_ORDERS",'Vedi e traccia ordini recenti');
define("FS_ACCOUNT_HISTORY",'Storico ordini');
define("FS_ACCOUNT_NEW_QUOTE_REQUEST",'Richiesta di un nuovo preventivo');
define("FS_ACCOUNT_QUOTE_STATUS",'Stato/Storico preventivo');
define("FS_ACCOUNT_NEW_RMA_REQUEST",'Richiesta di una nuova autorizzazione al reso ');
define("FS_ACCOUNT_RMA_STATUS",'Stato/Storico richieste di autorizzazione al reso');
define("FS_ACCOUNT_REVIEW_PURCHASES",'Rivedi i tuoi acquisti');
define("FS_ACCOUNT_QUOTE_STATUS_TRACKING",'Controlla lo stato dell\'ordine, il tracking e lo storico.');
define("FS_ACCOUNT_VIEW_ORDERS",'Vedi ordini');
define("FS_ACCOUNT_SEARCH_ORDERS",'Cerca ordini:');
define("FS_ACCOUNT_PO_ORDER_ID",'Ordine d\'acquisto numero#, Ordine numero #, Numero identificatico dell\'articolo');
define("FS_ACCOUNT_SEARCH",'Cerca');
define("FS_ACCOUNT_NET_TERMS",'ACCOUNT CREDITO');
define("FS_ACCOUNT_BUY_NOW_PAY_LATER",'Acquista ora, paga in seguito');
define("FS_ACCOUNT_CURRENT_BALANCE",'Bilancio consumato');
define("FS_ACCOUNT_VIEW_CREDIT_DETAILS",'Vedi i dettagli del tuo credito');
define("FS_ACCOUNT_NACCOUNT_SETTINGS",'IMPOSTAZIONI ACCOUNT');
define("FS_ACCOUNT_PASSWORD_MAIL",'Password e E-mail');
define("FS_ACCOUNT_USER_PHOTO",'Foto utente');
define("FS_ACCOUNT_USER_NAME",'Nome utente');
define("FS_ACCOUNT_EMAIL_ADDRESS",'Indirizzo Email');
define("FS_ACCOUNT_EMAIL_PASSWORD",'Password');
define("FS_ACCOUNT_EMAIL_PREFERENCES",'Preferenze sottoscrizione via email');
define("FS_ACCOUNT_SHOPPING_TOOLS",'STRUMENTI D\'ACQUISTO');
define("FS_ACCOUNT_USEFUL_SHOPPING",'Strumenti utili all\'acquisto');
define("FS_ACCOUNT_REQUEST_SAMPLE",'Richiedi un campione');
define("FS_ACCOUNT_WRITE_REVIEW",'Scrivi una recensione riguardo FS');
define("FS_ACCOUNT_USER_INFORMATION",'INFORMAZIONI UTENTE');
define("FS_ACCOUNT_CASES_AND_ADDRESSES",'Casi e indirizzi');
define("FS_ACCOUNT_ADDRESS_BOOK",'Impostazione dell\'indirizzo');
define("FS_ACCOUNT_CASE_CENTER",'Ticket di assistenza');
define("FS_ACCOUNT_TAX_EXEMPTION",'FS.COM INC charges tax on orders shipping to a number of states where FS is required to collect tax. If you are a  tax-exemption organization, you may click "<a class="alone_a" href="'.zen_href_link('tax_exemption','','SSL').'">Apply for Tax Exemption</a>" for tax exempted.');

define("FS_ACCOUNT_CASE_E_MAIL",'E-mail:');
define("FS_CREATE_SHIPPING_ADDRESS",'Crea un nuovo indirizzo di consegna');
define("FS_CREATE_BILLING_ADDRESS",'Crea un nuovo indirizzo di fatturazione');
define("FS_EDIT_SHIPPING_ADDRESS",'Modifica il tuo indirizzo di consegna');
define("FS_EDIT_BILLING_ADDRESS",'Modifica il tuo indirizzio di fatturazione');
define("FS_CONFIRMATION",'Conferma');
define("FS_DELETE_THIS_ADDRESS",'Eliminare qusto indirizzo?');
define("FS_SAVED_ADDRESSES",'Indirizzi salvati');
define("FS_SAVE_AS_DEFAULT",'Salva come predefinito');

//2019.11.26 quest 售后地址表单
define('FS_SALES_INFO_MODAL_TITLE','Aggiungi un nuovo indirizzo');
define('FS_SALES_INFO_MODAL_FNAME','Nome');
define('FS_SALES_INFO_MODAL_LNAME','Cognome');
define('FS_SALES_INFO_MODAL_COUNTRY','Paese/Regione');
define('FS_SALES_INFO_MODAL_ADS_TYPE','Tipo di indirizzo');
define('FS_SALES_INFO_MODAL_COMPANT','Nome dell\'azienda');
define('FS_SALES_INFO_MODAL_VAT','NUMERO IVA/TASSA');
define('FS_SALES_INFO_MODAL_ADS1','Indirizzo');
define('FS_SALES_INFO_MODAL_ADS2','Indirizzo 2');
define('FS_SALES_INFO_MODAL_CITY','Città/Paese');
define('FS_SALES_INFO_MODAL_SPR','Stato/Provincia/Regione');
define('FS_SALES_INFO_MODAL_STATE','Si prega di selezionare lo Stato');
define('FS_SALES_INFO_MODAL_ZIP_CODE_NEW','Codice postale');
define('FS_SALES_INFO_MODAL_PHONE_NUM','Numero di telefono');
define('FS_SALES_INFO_MODAL_BTN_CANCEL','Annulla');
define('FS_SALES_INFO_MODAL_BTN_SAVE','Salva');
define('FS_SALES_INFO_MODAL_ADS1_HOLDER','Indirizzo,c/o');
define('FS_SALES_INFO_MODAL_ADS2_HOLDER','Appartamento,Suite,piano,etc.');

define('FS_SALES_DETILS_TYPE1','Rimborso');
define('FS_SALES_DETILS_TYPE2','Sostituzione');
define('FS_SALES_DETILS_TYPE3','Riparazione');
define('FS_RMA_NAVI1','Conferma di richiesta autorizzazione al reso');
define('FS_RMA_NAVI2','Storico richieste autorizzazioni al reso');
define('FS_RMA_NAVI3','Dettaglio richiesta autorizzazione al reso');
define('FS_RMA_NAVI4','Richiesta autorizzazione al reso');
define('FS_RMA_NAVI5','Nuova richiesta di autorizzazione al reso');
define('FS_RMA_DETAILS_NAVI1','Dettagli reso & rimborso ');
define('FS_RMA_DETAILS_NAVI2','Dettagli sostituzione');
define('FS_RMA_DETAILS_NAVI3','Dettagli riparazione');

//2019.11.26 再次付款页面提示语
define('FS_CHECKOUT_AGAINST_TRANSFER_PLEASE', 'Si prega di trasferire al seguente account.');

define('FS_RMA_SEARCH_TIPS','Tutte le RMA');

define("FS_ACCOUNT_REQUEST_A_SAMPLE",'Richiedi un campione');
define("FS_ACCOUNT_USEFUL_TOOLS",'STRUMENTI UTILI');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Supporto e Feedback');
define("FS_ACCOUNT_SUPPORT_FEEDBACK",'Supporto e Feedback');
define("FS_ACCOUNT_CANCEL",'Elimina');
define("FS_ACCOUNT_SHIPPING_ADDRESS",'INDIRIZZI DI CONSEGNA');
define("FS_ACCOUNT_BILLING_ADDRESS",'INDIRIZZI DI FATTURAZIONE');
define('ACCOUNT_MY_HOME','Home');
define("FS_REVIEW_PURCHASE_10",'Ordine numero #, Articolo #');

//首页版块
define('FS_INDEX_FPE_TITLE',' Prodotti in Evidenza');
define('FS_INDEX_ETN_TITLE','Esplora il Network');
define('FS_INDEX_SERVICE_TITLE','Servizi');
define('FS_ACCOUNT_TITLE','Stato dell\'ordine');
define('FS_ACCOUNT_BTN','Vedi ordini');
define('FS_ACCOUNT_CONTENT','Traccia il tuo ordine per sapere lo stato del pacco più recente e i tempi di consegna stimati.');
define('FS_ACCOUNT_TITLE_REGISTER','Crea Account');

//打印相关
define('FS_PRINT_QTY','Quantità');
define('FS_PRINT_UNIT_PRICE','Prezzo');
define('FS_PRINT_TOTAL','Totale');
define('FS_PRINT_SHIPMENT','Spedizione');
define('FS_PRINT_SUBTOTAL','Subtotale:');
define('FS_PRINT_SHIPPING_COST','Spese di spedizione:');
define('FS_PRINT_SHIPPING_TAX','IVA:');
define('FS_PRINT_TOTAL_WIDTH_COLON','Totale:');
define('FS_PRINT_ITEM','Articolo');

//税后价公用语言包 add dylan 2020.5.13
define('FS_BLANKET_32','Tassa di spedizione');
define('FS_BLANKET_33','Importo GST totale');
define('FS_BLANKET_34','Totale');
define('FS_BLANKET_35','GST Incluso');

define('FIBER_SPARKASSE_BANK_NAME','Nome della Banca:');

//报价相关
define('INQUIRY_QUOTE_LIST_1','Vedi preventivo');
define('INQUIRY_QUOTE_LIST_2','Storico preventivi');

define('FS_CHECKOUT_ERROR_VAT','Inserisci un numero di partita IVA valido. eg: $VAT');
define('FS_CHECKOUT_POPUP_TIPS','Sei sicuro di voler tornare al tuo carrello?');
define('FS_CHECKOUT_POPUP_BUTTON1','Rimani al Checkout');
define('FS_CHECKOUT_POPUP_BUTTON2','Ritorna al carrello');
define('FS_CHECKOUT_PAYMENT','Pagamento');
define('FS_CHECKOUT_PAYMENT_PO','Carica Ordine d\'acquisto');


// MUX流程轴节点
define('FS_ORDER_CUSTOMIZED','Personalizzato');
define('FS_ORDER_MANUFACTURING','Manifattura');
define('FS_ORDER_TEST_PASS','Test superato');
define('FS_ORDER_SHIPPED','Spedito');
define('FS_ORDER_TEST_REPORT','Rapporto sul test di prova');

define('FS_PRODUCTS_INFO_NOTE_TITLE','Si prega di notare: ');
define('FS_PRODUCTS_INFO_NOTE_TIPS','Il ricetrasmettitore CFP Coerente 100G è incluso nel prodotto.');


/**
 *   po 暂停授信提示语 add by rebirth  2020/01.07
 */
define('FS_PO_FORZEN_NOTICE_01','Il tuo account credito è in uno stato di "Sospensione del credito" e l\'opzione di pagamento Net Terms non è disponibile. Si prega di <a href="'.zen_href_link('manage_orders','','SSL').'" target="_blank">pagare le fatture in sospeso/a> o scegliere altre opzioni di pagamento.');
define('FS_PO_FORZEN_NOTICE_02','Il tuo account credito è in uno stato di "Sospensione del credito". Vedi di più sulla pagina Dettagli credito.');

define('FS_PO_FORZEN_NOTICE_03','Il tuo account credito è in uno stato di "Sospensione del credito". Si prega di <a href="'.zen_href_link('manage_orders','','SSL').'">pagare le fatture in sospeso</a> o scegliere altre opzioni di pagamento.');


define("FS_ACCOUNT_RMA_ORDERS",'  Ordini in richiesta di autorizzazione al reso (RMA)');
define("FS_ACCOUNT_PO_NUMBER",'Ordine d\'acquisto numero #');
define("FS_ACCOUNT_REQUEST_RMA",'Richiedi un autorizzazione al reso');
define("FS_ACCOUNT_RMA_HISTORY",'Storico richieste di autorizzazione al reso');
define("FS_ACCOUNT_PO_ORDER",'Invia/Vedi Ordine d\'acquisto');
define("FS_ACCOUNT_REVIEW_YOUR_ORDER",'Rivedi il tuo ordine');
define("FS_ACCOUNT_QUOTES",'PREVENTIVI');
define("FS_ACCOUNT_QUICK_QUOTE",'Preventivo veloce e Vedi Stato');
define("FS_ACCOUNT_ACTIVE",'Preventivo attivo');
define("FS_ACCOUNT_QUOTE_HISTORY",'Cronologia ordini');
define("FS_ACCOUNT_REQUEST_QUOTE",'Richiedi un preventivo');
define("FS_ACCOUNT_ORDER_PENDING",'Ordini in attesa');
define("FS_ACCOUNT_ORDER_PROGRESSING",'Ordini in elaborazione');
define("FS_ACCOUNT_ORDER_COMMENTS",'Commenti sull\'ordine:');

//support
define("SUPPORT_PAGE","Benvenuto nell'assistenza clienti di FS. Come possiamo aiutarla?");
define("SUPPORT_PAGE_1","Aiuto istantaneo");
define("SUPPORT_PAGE_2","Chat dal vivo");
define("SUPPORT_PAGE_3","Supporto prodotti");
define("SUPPORT_PAGE_4","Scopri di più");
define("SUPPORT_PAGE_5","Supporto tecnico");
define("SUPPORT_PAGE_6","Supporto preventivo");
define("SUPPORT_PAGE_7","Casi studi");
define("SUPPORT_PAGE_8","Video di supporto");
define("SUPPORT_PAGE_9","Comunità");
define("SUPPORT_PAGE_10","Altre risorse di supporto");
define("SUPPORT_PAGE_11","Politiche di reso");
define("SUPPORT_PAGE_12","Traccia il tuo pacco");
define("SUPPORT_PAGE_13","Richiedi un campione");
define("SUPPORT_PAGE_14","Centro assistenza");
define('FS_SUPPORT','Supporto');

//首页cart sign in翻译
define('FILENAME_SIGN_IN','Accedi');
define('FILENAME_HOME_CART','Carrello');
// 2018.7.23 fairy help
define('FS_NEED_HELP_BIG','Bisogno di aiuto?');
define('FS_CHAT_LIVE_WITH_US','Chatta dal vivo con noi');
define('FS_SEND_US_A_MESSAGE','Mandaci un messaggio');
define('FS_E_MAIL_NOW','Invia Email ora');
define("FS_LIVE_CHAT","Chat dal vivo");
define("FS_WANT_TO_CALL"," Parliamo l'italiano. Chiamaci");
define("FS_BREADCRUMB_HOME","Home");
/*2018-9-22.顶部增加一个版块*/
define('FS_CHAT_LIVE_WITH_GET','Ottieni supporto tecnico');
define('FS_CHAT_LIVE_WITH_GET_A','Chiedi ad un esperto');

define('FS_SIGN_IN','Accedi');
//登陆超时
define('LOING_TIMEOUT','Per motivi di sicurezza, la sessione è scaduta. Accedi di nuovo.');

define("FS_INQUIRY_INFO_67",'La tua richiesta di preventivo è vuota. Se hai già un account, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">accedi</a> per vedere il tuo preventivo.');
define('FS_EMAIL_SUBSCRIPTION_23','Inviami email su offerte, supporto tecnico e altro ancora.');

// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY','Dichiaro di essere d\'accordo con le politiche di FS riguardo <a href='.reset_url('policies/privacy_policy.html').' target="_blank" style=\'color: #232323\'>la Privacy</a> e <a href='.reset_url('policies/terms_of_use.html').' target="_blank" style=\'color: #232323\'>le Condizioni d\'uso</a>.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Assicurati di accettare la nostra Informativa sulla privacy e le Condizioni d\'uso.');

define('FS_OPTIONAL_COMPANY',' (opzionale)');

define("FS_SHIPPING_UPS_DE_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (Monaco ".FS_CHECKOUT_TIME.") verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");
define("FS_SHIPPING_SG_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (15:30, GMT + 8) verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");

//产品详情页相关
define("FS_WAREHOUSE_SG","Magazzino SG");
//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Consegna e resi');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Spedizione veloce al sud-est asiatico');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','Dopo la consegna, se si verificano problemi di qualità o si cambia semplicemente idea, è possibile restituire gli articoli in condizioni idonee entro 30 giorni. Scopri di più riguardo <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">riguardo le Politiche di Reso</a> di tutti i prodotti venduti da FS.');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Gli ordini fino a $MONEY o più si qualificano per la consegna gratuita di articoli idonei. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS offre diverse opzioni di consegna per rispettare le tue tempistiche o il tuo budget. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega du visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Per gli articoli pre-ordinati, gli ordini fino a $MONEY  o più si qualificano per la consegna gratuita. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_HK_MO_TL','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Tutti gli articoli consegnati a HK, Macao e Taiwan possono usufruire della consegna gratuita. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega di visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');

define('FS_REVIEWS_STARS_TITLE','su 5 stelle');
define('FS_REVIEWS_SMALL', 'Recensioni');


//定制产品属性类型选择
define('FS_SELECT_TYPE','Le specifiche più comuni selezionate dai nostri clienti.');
define('FSCHOOSE_SPECI','Scegli le specifiche:');
define('FS_SELECT_DEFAULT','Default');
define('FS_SELECT_CUSTOMIZE','Personalizza');


define("FS_NZ_OTHER_NOTICE","Il deposito australiano di FS, con sede a Melbourne, Victoria, puo' portare a termine spedizioni veloci in giornata verso la Nuova Zelanda. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define("FS_CN_NOTICE","Il deposito Globale di in Asia puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Disponibile, in transito</p> Gli articoli sono diretti verso il nostro deposito e verranno spediti una volta arrivati. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Disponibile, necessita transito</p> Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_AU_NOTICE',"Il deposito australiano di FS con sede a Melbourne puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_BUCK_NOTICE',"Gli articoli pesanti o di grandi dimensioni saranno spediti dal deposito in Asia.");
define('FS_SG_NOTICE',"Il deposito singaporiano di FS situato a Singapore puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leggi di più</a>");
define("FS_TIME_ZONE_ADDRESS_DE","<span>Posizione del Deposito:</span> NOVA Gewerbepark Building 7, Am Gfild 7, 85375 Neufahrn Germany | +49 (0) 8165 80 90 517 ");
define('FS_CHECK_OUT_INSURANCE','Assicurazione');
//add by liang.zhu
define('FS_READ_MORE','Leggi di più');
define('FS_SEE_LESS','Leggi meno');
define('FS_SIGN_IN','Accedi');
//登陆超时
define('LOING_TIMEOUT','Per motivi di sicurezza, la sessione è scaduta. Accedi di nuovo.');

define("FS_INQUIRY_INFO_67",'La tua richiesta di preventivo è vuota. Se hai già un account, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">accedi</a> per vedere il tuo preventivo.');
define('FS_EMAIL_SUBSCRIPTION_23','Inviami email su offerte, supporto tecnico e altro ancora.');

// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY',' Sono d\'accordo con la Informativa sulla Privacy  <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank"> e </a> con le Condizioni d\'uso <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">di FS</a>.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Assicurati di accettare la nostra Informativa sulla privacy e le Condizioni d\'uso.');

define('FS_OPTIONAL_COMPANY',' (opzionale)');

define("FS_SHIPPING_UPS_DE_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (Monaco ".FS_CHECKOUT_TIME.") verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");
define("FS_SHIPPING_SG_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (15:30, GMT + 8) verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");

//产品详情页相关
define("FS_WAREHOUSE_SG","Deposito SG");
//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Consegna e resi');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Spedizione veloce al sud-est asiatico');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','Dopo la consegna, se si verificano problemi di qualità o si cambia semplicemente idea, è possibile restituire gli articoli in condizioni idonee entro 30 giorni. Scopri di più riguardo <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">riguardo le Politiche di Reso</a> di tutti i prodotti venduti da FS.');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Gli ordini fino a $MONEY o più si qualificano per la consegna gratuita di articoli idonei. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS offre diverse opzioni di consegna per rispettare le tue tempistiche o il tuo budget. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega du visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Per gli articoli pre-ordinati, gli ordini fino a $MONEY  o più si qualificano per la consegna gratuita. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_HK_MO_TL','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Tutti gli articoli consegnati a HK, Macao e Taiwan possono usufruire della consegna gratuita. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega di visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');

define('FS_REVIEWS_STARS_TITLE','su 5 stelle');
define('FS_REVIEWS_SMALL', 'Recensioni');


//定制产品属性类型选择
define('FS_SELECT_TYPE','Le specifiche più comuni selezionate dai nostri clienti.');
define('FSCHOOSE_SPECI','Scegli le specifiche:');
define('FS_SELECT_DEFAULT','Default');
define('FS_SELECT_CUSTOMIZE','Personalizza');

define('FS_READ_MORE','Leggi di più');

define("FS_NZ_OTHER_NOTICE","Il deposito australiano di FS, con sede a Melbourne, Victoria, puo' portare a termine spedizioni veloci in giornata verso la Nuova Zelanda. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define("FS_CN_NOTICE","Il deposito Globale di in Asia puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Disponibile, in transito</p> Gli articoli sono diretti verso il nostro deposito e verranno spediti una volta arrivati. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Disponibile, necessita transito</p> Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_AU_NOTICE',"Il deposito australiano di FS con sede a Melbourne puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_BUCK_NOTICE',"Gli articoli pesanti o di grandi dimensioni saranno spediti dal deposito in Asia.");
define('FS_SG_NOTICE',"Il deposito singaporiano di FS situato a Singapore puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leggi di più</a>");

//add by liang.zhu
define('FS_READ_MORE','Leggi di più');
define('FS_SEE_LESS','Leggi meno');
define('FS_SIGN_IN','Accedi');
//登陆超时
define('LOING_TIMEOUT','Per motivi di sicurezza, la sessione è scaduta. Accedi di nuovo.');

define("FS_INQUIRY_INFO_67",'La tua richiesta di preventivo è vuota. Se hai già un account, <a class="quote_sing" target="_blank" href="'.zen_href_link('login','','SSL').'">accedi</a> per vedere il tuo preventivo.');
define('FS_EMAIL_SUBSCRIPTION_23','Inviami email su offerte, supporto tecnico e altro ancora.');

// 2019-8-7 potato 隐私政策
define('FS_COMMON_PRIVACY_POLICY',' Sono d\'accordo con la Informativa sulla Privacy  <a href='.HTTPS_SERVER.reset_url('policies/privacy_policy.html').' target="_blank"> e </a> con le Condizioni d\'uso <a href='.HTTPS_SERVER.reset_url('policies/terms_of_use.html').' target="_blank">di FS</a>.');
define('FS_COMMON_PRIVACY_POLICY_ERROR','Assicurati di accettare la nostra Informativa sulla privacy e le Condizioni d\'uso.');

define('FS_OPTIONAL_COMPANY',' (opzionale)');

define("FS_SHIPPING_UPS_DE_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (Monaco ".FS_CHECKOUT_TIME.") verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");
define("FS_SHIPPING_SG_TIPS","Ordini per cui il pagamento viene ricevuto dopo l'orario di chiusura dei nostri depositi (15:30, GMT + 8) verranno spediti il giorno lavorativo successivo.
Ordini da consegnare in aree remote richiederanno più tempo.");

//产品详情页相关
define("FS_WAREHOUSE_SG","Deposito SG");
//Delivery & Return Dylan 2019.8.7
define('FS_DELIVERY_RETURN','Consegna e resi');
define('FS_FAST_SHIPPING_SOUTH_EAST_ASIA','Spedizione veloce al sud-est asiatico');
define('FS_DELIVERY_FREE_RETURNS_CONTENT','Dopo la consegna, se si verificano problemi di qualità o si cambia semplicemente idea, è possibile restituire gli articoli in condizioni idonee entro 30 giorni. Scopri di più riguardo <a href="'.reset_url("/policies/day_return_policy.html ").'" target="_blank">riguardo le Politiche di Reso</a> di tutti i prodotti venduti da FS.');
define('FS_SHIPPING_INFO_DETAIL_FREE_SHIPPING_STANDARD','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Gli ordini fino a $MONEY o più si qualificano per la consegna gratuita di articoli idonei. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_BUCK','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">FS offre diverse opzioni di consegna per rispettare le tue tempistiche o il tuo budget. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega du visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_FAST_SHIPPING_PRE','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Per gli articoli pre-ordinati, gli ordini fino a $MONEY  o più si qualificano per la consegna gratuita. Per ulteriori informazioni su come ottenerla, visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');
define('FS_SHIPPING_INFO_DETAIL_HK_MO_TL','<div class="newDetail-plaintext-txt2 newDetail-plaintext-marBtm">Tutti gli articoli consegnati a HK, Macao e Taiwan possono usufruire della consegna gratuita. E gli ordini in stock verranno spediti entro 24 ore lavorative dal momento in cui l\'ordine viene effettuato. Per maggiori informazioni si prega di visitare <a href="'.reset_url("shipping_delivery.html").'" target="_blank">Spedizioni & Consegne</a>.</div>');

define('FS_REVIEWS_STARS_TITLE','su 5 stelle');
define('FS_REVIEWS_SMALL', 'Recensioni');


//定制产品属性类型选择
define('FS_SELECT_TYPE','Le specifiche più comuni selezionate dai nostri clienti.');
define('FSCHOOSE_SPECI','Scegli le specifiche:');
define('FS_SELECT_DEFAULT','Default');
define('FS_SELECT_CUSTOMIZE','Personalizza');

define('FS_READ_MORE','Leggi di più');

define("FS_NZ_OTHER_NOTICE","Il deposito australiano di FS, con sede a Melbourne, Victoria, puo' portare a termine spedizioni veloci in giornata verso la Nuova Zelanda. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define("FS_CN_NOTICE","Il deposito Globale di in Asia puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");

//dylan 2019.8.28 add
define('FS_CUSTOM_NOTICE',"Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_INSTOCK_NOTICE',"<p class='pro_font_w'>Disponibile, in transito</p> Gli articoli sono diretti verso il nostro deposito e verranno spediti una volta arrivati. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_TRANSIT_NOTICE',"<p class='pro_font_w'>Disponibile, necessita transito</p> Gli articoli saranno spediti una volta preparati. Potrebbero esserci tempi di consegna legati alla produzione. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_AU_NOTICE',"Il deposito australiano di FS con sede a Melbourne puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href=".zen_href_link("shipping_delivery","","SSL").">Leggi di più</a>");
define('FS_BUCK_NOTICE',"Gli articoli pesanti o di grandi dimensioni saranno spediti dal deposito in Asia.");
define('FS_SG_NOTICE',"Il deposito singaporiano di FS situato a Singapore puo' portare a termine spedizioni veloci in giornata. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leggi di più</a>");
//清仓产品加购限制 Dylan 2019.8.27
define('FS_CLEARANCE_TIPS_TITLE','Quantità disponibile insufficiente');
define('FS_CLEARANCE_TIPS_CONTENT','La quantità selezionata supera quella disponibile in stock <span class="clearance_total_qty">$QTY</span> pezzo(i), si prega di contattare il proprio gestore d\'account per ulteriori quantità.');
define('QV_CLEARANCE_TIPS','La quantità selezionata supera quella disponibile in stock <span class="clearance_total_qty">$QTY</span> pezzo(i).');
define('QV_CLEARANCE_EMPTY_QTY_TIPS','Il prodotto è esaurito, contattare il proprio gestore d\'account per avere aggiutive informazioni sulla disponibilità.');
define('FS_INQUIRY_EMPTY_TXT','La richiesta di preventivo è vuota.');
define('FS_INQUIRY_EMPTY_TXT_01','Invia una richiesta di preventivo su Dettagli del prodotto o inserisci direttamente il numero di un articolo online.');
define('FS_INQUIRY_EMPTY_TXT_A','<p class="empty_txt">Se hai già un account FS, <a href="'.zen_href_link('login','','SSL').'">Accedi</a> per vedere la tua richiesta per un preventivo.</p>');
//询价相关
define('INQUIRY_LISTS_1','Tutti i preventivi');
define('INQUIRY_LISTS_2','Attivo');
define('INQUIRY_LISTS_3','Acquistato');
define('INQUIRY_LISTS_4','Il preventivo è stato generato per ordinare correttamente.');
define('INQUIRY_LISTS_5','RIFERIMENTO');
define('INQUIRY_LISTS_6','Dettagli preventivo');
define('FS_INQUIRY_INFO_66_1','Questa richiesta di preventivo è scaduta il ');
define('FS_INQUIRY_INFO_66_6','Questa richiesta di preventivo è scaduta il ');
define('FS_INQUIRY_INFO_66_2',' Puoi richiedere un ulteriore preventivo, se lo necessiti.');
define('FS_INQUIRY_INFO_66_3','Questo preventivo è scaduto il ');
define('FS_INQUIRY_INFO_66_7','Questo preventivo è scaduto il ');
define('FS_INQUIRY_INFO_66_4','Questa richiesta di preventivo è valida fino al ');
define("FS_INQUIRY_LIST_27",'Responsabile del cliente:');
define('FS_INQUIRY_INFO_66_5','Puoi effettuare il checkout direttamente dopo aver ricevuto il preventivo dal tuo gestore d\'account.');


define('FS_QUOTE','Quote');
define('INQUIRY_LISTS_7','Tutti');
define('INQUIRY_LISTS_8','Storico preventivi');
define('INQUIRY_LISTS_9','storico preventivi');
define('INQUIRY_LISTS_10','Richiesta Preventivo');
define('INQUIRY_LISTS_11','Richiesta preventivo');
define('INQUIRY_LISTS_12','Scade il: ');
define('INQUIRY_LISTS_13','Creato da: ');
define('INQUIRY_LISTS_14','Gestore di account: ');
define('INQUIRY_LISTS_15','Ritorna al preventivo');
define('FS_FEEDBACK_SELECT_8', 'Suggerimento sito');
define('FS_PRINT_INQUIRY_TO','Rilasciato da:');

define("FS_CHECKOUT_NEW17_NEW_BLIND",'Lascia un commento se hai qualche richiesta, come spedizione cieca, esigenze di personalizzazione dei prodotti, ecc.');


define('FS_SEND_EMAIL_PAYMENT',"Richiesta di pagamento");

define('FS_BY_CLICKING','Cliccando su Conferma ordine, accetti i nostri');
define('FS_TERMS_AND_CONDITIONS','Termini e Condizioni');
define('FS_PRIVACY_AND_COOKIES',' la nostra normativa sulla Privacy e Cookie');
define('FS_AND_RIGHT_OF_WITHDRAWL',' e le nostre norme sul Diritto di Recesso.');
define("FS_ZIP_CODE_EU","Codice postale");
define("FS_ADDRESS_EU","Via e numero civico");
define("FS_ADDRESS2_EU","Indirizzi aggiuntivi");
define('ACCOUNT_EDIT_CITY_EU','Città');

//feedback select 2020-03-02 jay
define('FS_GIVE_FEEDBACK_TIP_1','Grazie per aver visitato FS. Per assistenza immediata, visitare');
define('FS_GIVE_FEEDBACK_TIP_2','Supporto FS');//链接
define('FS_GIVE_FEEDBACK_TIP_3','o');
define('FS_GIVE_FEEDBACK_TIP_4','Chatta Vivo ');//链接
define('FS_GIVE_FEEDBACK_TIP_5','con noi.');
define('FS_FEEDBACK_SELECT_1', 'Design del sito');
define('FS_FEEDBACK_SELECT_2', 'Ricerca e navigazione');
define('FS_FEEDBACK_SELECT_3', 'Prodotto');
define('FS_FEEDBACK_SELECT_4', 'Checkout e pagamento');
define('FS_FEEDBACK_SELECT_5', 'Spedizione e consegna');
define('FS_FEEDBACK_SELECT_6', 'Resi e sostituzioni');
define('FS_FEEDBACK_SELECT_7', 'Assistenza e supporto');
define('FS_FEEDBACK_SELECT_8', 'Suggerimento sito Web');


define('FS_AND',' e ');
define('FS_RIGHT_OF_WITHDRAWL','Diritto di Recesso');
define('FS_RIGHT_OF_WITHDRAWL_01','');
define('FS_CHECKOUT_ERROR3_EU','La via e il numero civico sono obbligatori');
define('INQUIRY_LISTS_15','Ritorna al preventivo');


define('CART_SHIPPING_METHOD_CHECKOUT_PRE','Spese di Spedizione:');
define('CART_SHIPPING_METHOD_CHECKOUT_TEXT','Calcolate al Checkout');
define('FS_COMMON_GSP_1','spedito da FS Asia');
define('FS_COMMON_GSP_2','Tasse di importazione');
define('FS_COMMON_GSP_3','inclusa');
define('FS_COMMON_GSP_4','Spese di importazione incluse al momento dell\'acquisto più sdoganamento gestito da FS.');
define('FS_COMMON_5','Chiudi');


define("FS_SHOP_CART_LIST_SUB",'Subtotale');

//详情页定制弹窗文字 2020.3.19  ery
define('FS_DETAIL_CUSTOM_1', 'Personalizzazione');
define('FS_DETAIL_CUSTOM_2', 'Produzione');
define('FS_DETAIL_CUSTOM_3', 'Spedito');
define('FS_DETAIL_CUSTOM_4', 'Consegnato');
define('FS_DETAIL_CUSTOM_5', 'Tempo di produzione stimato: ');
define('FS_DETAIL_CUSTOM_6', 'Spedizione prevista: ');
define('FS_DETAIL_CUSTOM_7', 'Consegna prevista: ');

//GSP库存展示相关文字 2020.0.20 ery
define('FS_GSP_STOCK_1', 'Customized');
define('FS_GSP_STOCK_2', 'Prodotto internazionale');
define('FS_GSP_STOCK_3', 'ship from ');
define('FS_GSP_STOCK_4', 'FS Asia');
define('FS_GSP_STOCK_5', 'Import Fees');
define('FS_GSP_STOCK_6', 'included');
define('FS_GSP_STOCK_7', 'L\'articolo verrà spedito dal deposito globale dell\'Asia tramite <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">il programma di spedizione globale (Global Shipping Program - GSP)</a>. Le tasse di importazione,incluse al momento dell\'acquisto,più lo sdoganamento sono gestiti da FS. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Scopri di più</a>');
define('FS_GSP_STOCK_8', 'Close');
define('FS_GSP_STOCK_9', 'L\'articolo verrà spedito dal deposito globale dell\'Asia tramite <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">il programma di spedizione globale (Global Shipping Program - GSP)</a>. Le tasse di importazione,incluse al momento dell\'acquisto,più lo sdoganamento sono gestiti da FS. Le tasse di vendita saranno incluse al checkout. <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Scopri di più</a>');
define('FS_AVAILABLE', 'Disponibile');
define('FS_LOACAL_EMPTY_INSTOCK_SHOW',"L'articolo verrà spedito dal deposito globale in Asia.");
define('FS_MOBILE_CLOSE','Chiudi');

// 2020-03-16  e-rate   rebirth
define('FS_ERate_01','E-rate');
define('FS_ERate_02','E-rate for Education & Learning');
define('FS_ERate_03','Server Room');
define('FS_ERate_04','Classroom');
define('FS_ERate_05','Lecture Hall');
define('FS_ERate_06','Laboratory');
define('FS_ERate_07','Contact an EDU specialist today');
define('FS_ERate_08','Mon - Fri, 9:00 am. - 5:00 pm. EST');
define('FS_ERate_09','+1 (888) 468 7419');
define('FS_ERate_10','E-rate Discounts');
define('FS_ERate_11','Take advantage of E-rate funding to receive discounts on networking equipment. Most public, private, and charter schools & libraries qualify. We proudly serve teachers, principals, and IT support staff by sourcing the best technology solutions for classrooms—at every level of education.');
define('FS_ERate_12','FS SPIN (Form 498 ID): 143051712');
define('FS_ERate_13','Get Started for E-rate');
define('FS_ERate_14','Leave your contact or call us for assistant');
define('FS_ERate_15','Please enter your email address.');
define('FS_ERate_16','Please enter a valid email address.');
define('FS_ERate_17','Thank you. We will get in touch with you ASAP.');
define('FS_ERate_18','10G DWDM Interconnections Over 120km in Campus Network');
define('FS_ERate_19','FS FMU DWDM and FMT series enable good quality transmission over long distance in a simple way.');
define('FS_ERate_20','Read more');
define('FS_ERate_21','Sir/Madam');
define('FS_ERate_22','We\'ve received your E-Rate request and will get in touch with you soon. Here is your case number $CNxxxxxxx, you can refer to this number in all follow-up communications regarding this request.');
define('FS_ERate_23','FS - We received your E-Rate request ');
define('FS_ERate_24','Featured Case');
define('FS_ERate_25','Laboratory');
define('FS_ERate_26','Your Email Address');
define('FS_ERate_27','E-rate for Educaiton ');
define('FS_ERate_28','E-rate Support');
define('FS_ERate_29','Receive discounts with E-rate funding');

define('FS_OUTBREAK_NOTICE', "Siamo qui per essere d'aiuto - Una lettera su COVID-19 da FS");
define('FS_OUTBREAK_NOTICE_M', 'Una lettera su COVID-19 da FS');
define('FS_OUTBREAK_READ_MORE', 'Leggi di più');

//subtotal(有税收的带上税收)
define('FS_SHOP_CART_SUBTOTAL','Subtotale:');
define('FS_SHOP_CART_EXCL_VAT','IVA ($VAT)');
define('FS_SHOP_CART_EXCL_SG_VAT','GST (7%)');
define('FS_SHOP_CART_EXCL_AU_VAT','Australia GST (10%)');
define('FS_SHOP_CART_EXCL_DE_VAT','IVA Germania ($VAT)');

//详情页交期提示语
define('FS_GSP_LOCAL_STOCK_DELIVERY_TIPS','The delivery date applies to the inventory items purchased by 5pm EST on business days. After that, your order will ship on the next business day. If your requested quantity exceeds the inventory, it will be dispatched from FS Asia warehouse with <a target="_blank" href="'.reset_url('/specials/global-shipping-program-107.html').'">Global Shipping Program (GSP)</a>.');
define('FS_GSP_COVID_TIPS','Potrebbero esserci ritardi nel servizio di consegna a causa del COVID-19 e dell\'aumento del volume di esse. Per ulteriori dettagli riguardo l\'avanzamento degli ordini, fare riferimento al <a href="'.reset_url('/login.html').'" target="_blank">Mio Account</a>. ');

define('FS_CHECK_OUT_EXCLUDING_RU_NATURE','(Escluse tasse)');
define("CHECKOUT_TAXE_RU_TIT_FOR_NATURAL","Per ordini da persona fisica e spediti dal nostro deposito internazionale, addebiteremo SOLO il valore del prodotto e le spese di spedizione. Eventuali dazi doganali o di importazione causati dallo sdoganamento devono essere dichiarati e saranno a carico del destinatario. Dal 1 ° gennaio 2020, la soglia per gli acquisti duty-free è stata ridotta a 200 € e fino a 31 kg per pacco. Se sei interessato ad altri metodi di consegna o non desideri pagare in contanti, contatta il gestore del tuo account.");
define('PRODUCTS_WARRANTY',' per Ricetrasmettitori');
define('PRODUCTS_WARRANTY_1','Professionale ');
define('PRODUCTS_WARRANTY_2','Programma di Test di Qualità');
define('PRODUCTS_WARRANTY_3',' ');
define('PRODUCTS_WARRANTY_4','Spedizioni &amp; Consegne');
define('PRODUCTS_WARRANTY_5','Garanzia di WARRANTY_YEARS Anni');
define('PRODUCTS_WARRANTY_5_1','Garanzia di WARRANTY_YEARS Anni');
define('PRODUCTS_WARRANTY_6','Garanzia a vita');
define('PRODUCTS_WARRANTY_7','Resi gratuiti');

//打印发票 VAT No 本地化
define('FS_VAT_NO_EU','Numero IVA.: ');
define('FS_VAT_NO_AU','ABN: ');
define('FS_VAT_NO_SG','GTS numero registrazione: ');
define('FS_VAT_NO_BR','CNPJ: ');
define('FS_VAT_NO_CL','RUT: ');
define('FS_VAT_NO_AR','CUIT: ');
define('FS_VAT_NO_DEFAULT','Tassa numero: ');
define('FS_VAT_NO_DEFAULT','Tax No.: ');

//购物车saved_items、saved_cart_details
define('FS_SAVED_CARTS','Carrelli salvati');
define('FS_ALL_SAVED_CARTS','Tutti i carrelli salvati');
define('FS_ADD_ALL_TO_CARTS','Aggiungi tutto al carrello');
define('FS_GO','AVANTI');
define('FS_SHOW_CART','Mostra');
define('FS_SEARCH','cerca');
define('FS_CART_NAME','Nome del Carrello');
define('FS_SEARCH_SAVED_CARTS','Cerca carrello salvato');
define('FS_DATE_SAVED','Data Salvata');
define('FS_CUSTOMER_ID','ID del Cliente');
define('FS_ACCOUNT_MANAGER','Manager d\'account');
define('FS_PHONE','Telefono#');
define('FS_SUBTOTAL','Subtotale');
define('FS_VIEW_SHIPPING_CART','Vedi carrello');
define('FS_SAVE_CART_CONDITIONS','Se non riesci a trovare un carrello salvato, prova a selezionare filtri di ricerca diversi.');
define('FS_NO_SAVED_CART_FOUND','NESSUN CARRELLO SALVATO TROVATO.');
define('FS_CRET_REFERENCE','RIFERIMENTO CARRELLO');
define('FS_CART_DELETE','Elimina');
define('FS_CART_NEW_ITEMS','Nuovi articoli sono stati aggiunti al tuo');
define('FS_CART_SUCCESSFULLY_UPDATED','Il tuo carrello è stato aggiornato con successo');
define('FS_CART_SAVED_CART_NAME','Nome carrello salvato');
define('FS_CART_NEW_CART_CREATE','Il nuovo carrello è stato creato.');
define('FS_CART_HAS_BEEN_ADD','è stato aggiunto ai tuoi carrelli salvati.');
define('FS_CART_NAME_ALREADY_EXISTED','Questo nome esiste già. Si prega di utilizzare un nome diverso.');
define('FS_ADD_TO_SAVED_CART','Aggiungi al carrello');
define('FS_SAVE_CART_SELECT','Seleziona carrello salvato');
define('FS_ADD_THE_ITEMS','In alternativa, aggiungi gli articoli in un carrello salvato esistente.');
define('FS_NAME_YOUR_SAVED_CART','Assegna un nome al carrello salvato');
define('FS_ADD_TO_CART','Aggiungi al carrello ');
define('FS_EMIAL_YOUR_CART','Invia il tuo carrello via email');
define('FS_PRINT_THIS_PAGE','Stampa pagina');
define('FS_SAVED_CART_DETAILS','Dettagli Carrelli Salvati');
define('FS_BELOW_IS_THE_CART','Di seguito sono riportati i dettagli del carrello che hai salvato.');
define('FS_CART_CONTACT_CUSTOMER_SERVICE','Contatta il Servizio Clienti');
define('FS_UPDATED_SUCCESSFULLY','Il tuo carrello è stato aggiornato con successo.');
define('FS_NEW_ITEM_CART','Nuovi articoli sono stati aggiunti al tuo carrello salvato ');
define('FS_CART_ALL_ITEMS','Tutti gli articoli in questo carrello non sono più disponibili per l\'acquisto. Per scoprirne la disponibilità, contatta il tuo gestore d\'account.');
define('FS_CART_SOME_CUSTOMIZED','Alcuni articoli personalizzati in questo carrello sono stati modificati, vai alla pagina dei dettagli del prodotto per selezionarne le caratteristiche specifiche.');
define('FS_CART_ALL_CUSTOMEIZED_ITEMS','Tutti gli articoli in questo carrello sono stati modificati, vai alla pagina dei dettagli del prodotto per selezionarne le caratteristiche specifiche.');
define('FS_CART_THE_QUANTITY','La quantità che hai selezionato supera la quantità in stock ed è stata modificata di conseguenza, contatta il gestore del tuo account per maggiori quantità.');
define('FS_CART_SHOPPING_CART_DIRECTLY','Gli articoli in questo carrello non sono più disponibili per l\'acquisto online, si prega di contattare il proprio gestore d\'account per conoscerne la disponibilità. Nel frattempo, gli articoli disponibili sono stati spostati direttamente nel carrello.');
define('FS_CART_QUANTITY_ADDITIONAL','La quantità che hai selezionato supera la quantità in stock ed è stata modificata di conseguenza, contatta il gestore del tuo account per maggiori quantità.');
define('FS_CART_CUSTOMIZED_SHOPPING_CART','Gli articoli personalizzati in questo carrello sono stati modificati, vai alla pagina dei dettagli del prodotto per selezionarne le caratteristiche specifiche. Nel frattempo, gli articoli disponibili sono stati spostati direttamente nel carrello.');
define('FS_SAVE_CSRT_LIMIT_TIP_CART','Inserisci il nome del carrello fino ad un massimo di 150 parole.');
define('FS_FROM','Da');
define('FS_TO_EMAIL','A');
define('FS_SELECT_SAVE_CART','Seleziona Salva carrello.');


define('FS_NOTICE_FREE_SHIPPING','Spedizione gratuita per ordini superiori a $MONEY');
define('FS_NOTICE_FREE_DELIVERY','Consegna gratuita sugli ordini superiori a $MONEY (IVA esclusa)');
define('FS_NOTICE_FAST_SHIPPING','Spedizione veloce verso $COUNTRY');
define('FS_NOTICE_HEADER_COMMON_TIPS',' A causa di COVID-19, i tempi di consegna possono essere più lunghi del solito.');

define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day-Early® service');
define('DHL_EXPRESS_WORLDWIDE_1_2_BUSINESS_DAY', 'DHL Express Worldwide® 1-2 giorni lavorativi');
define('UPS_NEXT_DAY_AIR_EARLY', 'UPS Next Day Air Early® service');
define('FS_SERVICE_WORD', '');

// add by rebirth  2020.04.09  下单付款邮件优化
define('FS_EMAIL_OPTIMIZE_01', 'Esegui pagamento');
define('FS_EMAIL_OPTIMIZE_02', 'Nota: se hai già effettuato il pagamento, ti preghiamo di ignorare questa email, grazie.');
define('FS_EMAIL_OPTIMIZE_03', 'Ci siamo!');
define('FS_EMAIL_OPTIMIZE_04', 'I dettagli per il tuo ordine #ORDER_NUMBER sono riportati di seguito. Ti invieremo le informazioni per seguirne l\'avanzamento non appena avremo eventuali aggiornamenti.');
define('FS_EMAIL_OPTIMIZE_05', 'Vedi ordine');
define('FS_EMAIL_OPTIMIZE_06', 'Nota: se hai già caricato l\'ordine d\'acquisto, ignora questa email, grazie.');
define('FS_EMAIL_OPTIMIZE_07', 'Grazie per il tuo ordine');
define('FS_EMAIL_OPTIMIZE_08', 'Si prega di completare il pagamento entro 7 giorni lavorativi. In caso contrario, l\'ordine verrà annullato a causa del cambiamento della disponibilità degli articoli in stock. Dopo aver completato il pagamento, riceverai una notifica di conferma del pagamento per informarti che FS ha confermato il tuo ordine.');
define('FS_EMAIL_OPTIMIZE_09', 'Istruzioni per il pagamento');
define('FS_EMAIL_OPTIMIZE_10', 'Dopo che il pagamento è stato inviato correttamente, si prega di inviare la ricevuta bancaria a $FS_EMAIL. o al tuo gestore d\'account. Ciò contribuirà a elaborare il tuo ordine in via prioritaria ed evitarne l\'annullamento. Si prega di inviare il pagamento al seguente account.');
define('FS_EMAIL_OPTIMIZE_11', 'Nota: si prega di lasciare il numero dell\'ordine $ORDER_NUMBER e l\'indirizzo e-mail nella nota del bonifico bancario.');
define('FS_EMAIL_OPTIMIZE_12', 'Politiche di consegna');
define('FS_EMAIL_OPTIMIZE_13', 'I tempi di consegna stimati non iniziano finché non avremo ricevuto il pagamento');
define('FS_EMAIL_OPTIMIZE_14', 'Il tuo ordine verrà consegnato tra le 9:00 e le 17:00, dal lunedì al venerdì (esclusi i giorni festivi). Qualcuno dovrà essere all\'indirizzo indicato per accettare e firmare per la consegna.');

define('FS_PLEASE_CHECK_THE_URL','Controllare l\'URL, o andare alla ');
define('FS_HOMEPAGE','Homepage');
define('FS_GO_TO_HOMEPAGE','Vai alla Home');

define('STARTRACK_PREMIUM_EXPRESS', 'StarTrack Premium 1-3 giorni lavorativi');
define('TNT_ROAD_EXPRESS_1_4', 'TNT Road Express 1-4 giorni lavorativi');
define('DHL_EXPRESS_1_3', 'DHL Express 1-3 giorni lavorativi');

define("FS_WORD_CLOSE", 'Close');


//报价购物车
define('FS_NEW_OTHER_LENGTH','Altra lunghezza');
define('FS_INQUIRY_CART_1',"Richiedi un Preventivo");
define('FS_INQUIRY_CART_2',"Info contatto per il preventivo");
define('FS_INQUIRY_CART_3',"Nome*");
define('FS_INQUIRY_CART_4',"Cognome*");
define('FS_INQUIRY_CART_5',"Email*");
define('FS_INQUIRY_CART_6',"Telefono");
define('FS_INQUIRY_CART_7',"Commenti");
define('FS_INQUIRY_CART_8',"Carica file");
define('FS_INQUIRY_CART_9',"Tipi di file consentiti PDF, JPG, PNG.<br>Dimensioni file massime 5M.");
define('FS_INQUIRY_CART_10',"Aggiungi i dettagli degli articoli al preventivo in modo rapido inserendo l'ID del prodotto e la quantità.");
define('FS_INQUIRY_CART_11',"Aggiungi");
define('FS_INQUIRY_CART_12',"Richiesta preventivo");
define('FS_INQUIRY_CART_13',"Si prega di lasciare un messaggio qualora si avessero esigenze particolari.");
define('FS_INQUIRY_CART_14',"Inserisci l'ID prodotto");
define('FS_INQUIRY_CART_15',"Inserire ID del prodotto.");

define('UPS_EXPRESS_NEXT_DAY_SERVICE', 'Servizio UPS Express Saver® giorno successivo');
define("FS_BLANK", ' ');

// 结算页美国、澳大利亚跳转
define('AUSTRALIA_HREF_1',"Gli ordini su questo sito non possono essere consegnati in Australia. Passare gentilmente a ");
define('FS_AUSTRALIA_CHECKOUT',"FS Australia");
define('AUSTRALIA_HREF_2'," se si desidera una consegna in Australia");
define('UNITED_STATES_SITE_HREF_1',"Gli ordini su questo sito non possono essere consegnati negli Stati Uniti. Passare gentilmente al ");
define('FS_UNITED_STATES_SITE',"sito FS degli Stati Uniti ");
define('UNITED_STATES_SITE_HREF_2'," se si desidera una consegna negli Stati Uniti.");
define('RUSSIAN_SITE_HREF_1',"For Legal Person, orders need to be paid via Cashless Payment with rubles. Please kindly go to ");
define('FS_RUSSIAN_SITE',"FS Russian Federation");
define('RUSSIAN_SITE_HREF_2'," if you wish to place the order.");


//头部购物车loading板块提示语
define('FS_TOP_CART_LOAD_TITLE', 'Caricamento carrello');

define('FS_VAX_TITLE_US_TAX','Tasse di vendita');

define('FS_VAX_US_TIPS','Secondo le leggi fiscali statali, FS è tenuta a riscuotere l\'imposta sulle vendite dai soggetti non esenti. <a href="https://www.fs.com/service/sales_tax.html" target="_blank">Leggi di piu</a>');


//账户中添加查看评论入口
define('FS_ACCOUNT_VIEW_REVIEWS', "Vedi recensioni");
define('FS_VIEW_REVIEWS_WRITE_A_REVIEW', "Scrivi una recensione");
define('FS_VIEW_REVIEWS_SEARCH', "Cerca");
define('FS_VIEW_REVIEWS_SEARCH_REVIEWS', "Cerca recensioni:");
define('FS_VIEW_REVIEWS_ITEM', "Articolo #");
define('FS_VIEW_REVIEWS_1', "Nessuna recensione trovata.");
define('FS_VIEW_REVIEWS_2', "Trova il tuo ordine e condividi la tua recensione.");
define('FS_VIEW_REVIEWS_REVIEWED_ON', "Recensione del ");
define('FS_VIEW_REVIEWS_VERY_SATISFIED', "Molto soddisfatto");
define('FS_VIEW_REVIEWS_READ_MORE', "Leggi di piu'");
define('FS_VIEW_REVIEWS_MORE', "Altro");
define('FS_VIEW_REVIEWS_SHOW', "Mostra");
define('FS_VIEW_REVIEWS_COMMENTS', "commenti");


define('FS_SRVICE_WORD', "service");
define('FS_PRODUCT_MATERIAL_M','m');
define('FS_PRODUCT_MATERIAL_CABLE',' Materiali dei cavi');
define('FS_PRODUCT_MATERIAL_TIP','I tempi di consegna saranno piu\' lunghi siccome la quantita\' richiesta oltrepassa quelle in stock. Per richiedere una spedizione separata degli articoli in stock, si prega di contattare il proprio gestore d\'account..');

define('FS_INQUIRY_PRODUCTS_NUM',"Si prega di controllare le informazioni sul prodotto tra i dettagli del preventivo.");

//前台账期申请  rebirth.ma   2020.05.22
define('FS_NET_30_01', 'Si prega di inserire il proprio nome e cognome.');
define('FS_NET_30_02', 'Si prega di caricare modulo della richiesta.');
define('FS_NET_30_03', 'L\'Account di Credito esiste già.');
define('FS_NET_30_04', 'FS - Richiesta per Net Terms ricevuta');
define('FS_NET_30_05', 'Abbiamo ricevuto la tua richiesta di Net Terms. È attualmente in fase di revisione e questo processo può richiedere circa 2-3 giorni lavorativi. Quando sarà stata presa una decisione, sarai avvisato tempestivamente via e-mail da FS.');
define('FS_NET_30_06', 'Stato della richiesta');
define('FS_NET_30_07', 'Inviata');
define('FS_NET_30_08', 'Sotto revisione');
define('FS_NET_30_09', 'Approvata');
define('FS_NET_30_10', 'Rifiutata');
define('FS_NET_30_11', 'Invia modulo di richiesta');
define('FS_NET_30_12', 'Nome e cognome');
define('FS_NET_30_13', 'Email');
define('FS_NET_30_14', 'Telefono');
define('FS_NET_30_15', 'Carica file');
define('FS_NET_30_16', 'Seleziona file');
define('FS_NET_30_17', 'Il modulo di richiesta è stato inviato correttamente.');
define('FS_NET_30_18', 'Invieremo il risultato della revisione entro 2-3 giorni lavorativi via e-mail, puoi anche tracciare gli aggiornamenti su "#CASE_CENTER" tramite il proprio account FS.');
define('FS_NET_30_19', 'Grazie! Il modulo di richiesta di Credito è stato inviato correttamente.');
define('FS_NET_30_20', 'La tua richiesta di Net Terms è in fase di revisione, si prega di consentire circa 2-3 giorni lavorativi per l\'elaborazione.');
define('FS_NET_30_21', 'Siamo lieti di comunicarti che la tua richiesta di Net Terms è stata approvata. Puoi effettuare un ordine su FS con Net Terms già da ora.');
define('FS_NET_30_22', 'Puoi anche visualizzare i dettagli del tuo Credito su "#FS_CREDIT".');
define('FS_NET_30_23', 'Siamo spiacenti ma la tua richiesta di Net Terms è stata respinta. ');//与后面还有一句话，注意本句话最后面的空格
define('FS_NET_30_24', 'Vuoi richiedere nuovamente Net Terms?');
define('FS_NET_30_25', 'Compilare e inviare il modulo di richiesta su "#NET_TERMS".');
define('FS_NET_30_26', 'Per qualsiasi domanda, non esitare a contattare il gestore del tuo account #ACCOUNT_MANAGER.');
define('FS_NET_30_27', 'Paese/Regione');
define('FS_NET_30_28', 'Commenti');
define('FS_NET_30_29', 'Carica');
define('FS_NET_30_30', 'Grazie<br>Il Team FS');
define('FS_NET_30_31', 'Richiesta ricevuta');
define('FS_NET_30_32', 'Ordine d\'acquisto');

//new-product
define('FS_NEW_PRODUCT_EXPLORE','Esplora le ultime innovazioni');

//取消订阅
define('FS_UNSUBSCRIBE_MAIL_1','FS Newsletter');
define('FS_UNSUBSCRIBE_MAIL_2','per saperne di più sulle ultime politiche preferenziali, notizie sull\'inventario, supporto tecnico e così via.');
define('FS_UNSUBSCRIBE_MAIL_3','E-mail di richiesta di recensione');
define('FS_UNSUBSCRIBE_MAIL_4','Le e-mail di richiesta di recensione saranno inviate dopo 7 giorni dalla consegna dell\'ordine.');
define('FS_UNSUBSCRIBE_MAIL_5','Gestisci le tue preferenze di iscrizione per ricevere e-mail da FS.');
define('FS_UNSUBSCRIBE_MAIL_6','Le e-mail sul tuo account e sugli ordini sono importanti. Le inviamo anche se hai scelto di non ricevere tutte le seguenti e-mail.');

//账户中心添加关于俄罗斯对公支付
define('FS_ACCOUNT_MY_COMPANIES', 'Companies');

/*wdm库存展示版块语言包*/
define('FS_WDM_WAVELENGTH_NM','Lunghezza d\'onda (nm)');


define("FS_CHECKOUT_RU_FILE_TIPS_2", "Allow files of type JPG, JPGE, PDF, PNG, DOC, DOCX, XLS, XLSX. Maximum file size 5M.");


//100G产品提示语
define("FS_COHERENT_CFP","The coherent CFP transceiver isn't sold separately.");



//checkout 账单地址邮编验证提示
define('FS_ZIP_VALID_1','The address you selected does not match postal service records. Please double-check your address.');
define('FS_ZIP_VALID_2','Please enter a valid Postal Code.');


//solution专题的常量定义
define("FS_SOLUTION_CLICK_OPEN_VIEW","Clicca per aprire la versione ampliata");
define("FS_CUSTOMIZE_YOUR_SOLUTION","Scegli &amp; Personalizza Soluzioni");
define("FS_TECH_SPEC_CUSTOMOZATION","Specifiche tecniche");
define("FS_SOLUTION_OVERVIEW",'Overview');
define("FS_SOLUTION_CUSTOMIZED",'Aggiungi al carrello');
define("FS_SOLUTION_EDIT",'Modifica');
define("FS_SOLUTION_CONFIGURATION",'Configurazione della soluzione');
define("FS_SOLUTION_MORE",'Più');
define("FS_SOLUTION_LESS",'Meno');
define("FS_SOLUTION_DEVICES",'Dispositivi');
define("FS_SOLUTION_TRANSCEIVER",'Ricetrasmettitore');
define("FS_SOLUTION_WAVE_COM_BAR",'Lunghezza d\'onda & Marche Compatibili');
define("FS_SOLUTION_ACCESSORIES",'Accessori');
define("FS_SOLUTION_CHOOSE_LENGTH",'Scegliere Lunghezza');
define("FS_SOLUTION_INFO",'Informazioni sulla soluzione');

define('FS_SOLUTION_PERSONALIZATION','Personalizzato');
define('FS_SOLUTION_MANUFACTURING','In produzione');
define('FS_SOLUTION_SHIPPED','Spedito');
define('FS_SOLUTION_ARRIVED','Arrivato');
define('FS_SOLUTION_CON_LIST','Elenco di configurazione della soluzione');
define('FS_SOLUTION_QUANTITY','Quantità');
define('FS_SOLUTION_TOTAL','Totale');

define('FS_SOLUTION_SITEA','sitoA');
define('FS_SOLUTION_SITEB','Sito B');

define('FS_SOLUTION_NAV_01','Rete di Trasporto Ottica');
define('FS_SOLUTION_NAV_02','Rete del Campus');
define('FS_SOLUTION_NAV_03','Data Center');
define('FS_SOLUTION_NAV_04','Cablaggio Strutturato ');
define('FS_SOLUTION_NAV_05','Per Applicazione');
define('FS_SOLUTION_NAV_06','Rete in Fibra Doppia 10G CWDM');
define('FS_SOLUTION_NAV_07','Rete in Fibra Singola 10G CWDM');
define('FS_SOLUTION_NAV_08','Rete in Fibra Doppia 10G DWDM');
define('FS_SOLUTION_NAV_09','Rete in Fibra Singola 10G DWDM');
define('FS_SOLUTION_NAV_10','Rete in Fibra Doppia 25G DWDM');
define('FS_SOLUTION_NAV_11','Rete in Fibra Singola 25G DWDM');
define('FS_SOLUTION_NAV_12','Rete Coerente 40/100G');
define('FS_SOLUTION_NAV_13','Rete Aziendale');
define('FS_SOLUTION_NAV_14','Wireless e Mobilità');
define('FS_SOLUTION_NAV_15','Rete Multi-Filiale');
define('FS_SOLUTION_NAV_16','Networking Gestita nel Cloud');
define('FS_SOLUTION_NAV_17','Cablaggio Strutturato per Data Center');
define('FS_SOLUTION_NAV_18','Cablaggio MTP®/MPO ad Alta Densità');
define('FS_SOLUTION_NAV_19','Migrazione 40G/100G');
define('FS_SOLUTION_NAV_20','Cablaggio in Rame Preterminato');
define('FS_SOLUTION_NAV_21','Soluzione CWDM Multiservizio');
define('FS_SOLUTION_NAV_22','Trasporto a Lungo Raggio 10G DWDM');
define('FS_SOLUTION_NAV_23','WDM 25G per Fronthaul 5G');
define('FS_SOLUTION_NAV_24','Soluzione DWDM Coerente 100G');
define('FS_SOLUTION_NAV_25','Ottimizzazione della Rete MLAG');
define('FS_SOLUTION_NAV_26','Commutazione della Rete Principale di Data Center');
define('FS_SOLUTION_NAV_27','Soluzione Power over Ethernet');
define('FS_SOLUTION_NAV_28','Soluzione Wireless Sicura');
define('FS_SOLUTION_NAV_29','Cablaggio Strutturato per Data Center');
define('FS_SOLUTION_NAV_30','Cablaggio MTP®/MPO ad Alta Densità');
define('FS_SOLUTION_NAV_31','Migrazione 40G/100G');
define('FS_SOLUTION_NAV_32','Cablaggio in Rame Preterminato');
define('FS_SOLUTION_NAV_33','Team Tecnico & Supporto per Soluzioni Professionali');
define('FS_SOLUTION_NAV_34','Data Center Aziendale');
define('FS_SOLUTION_NAV_35','Data Center del Fornitore di Servizi');
define('FS_SOLUTION_NAV_36','Hyperscale e Data Center Cloud');
define('FS_SOLUTION_NAV_37','Data Center Multi-Tenant');
//solutions 版块新增专题
define('FS_SOLUTION_NAV_M6200','DWDM 10G a lungo raggio delle serie M6200');
define('FS_SOLUTION_NAV_M6500','Banda elevata 100G/200G delle serie M6500');
define('FS_SOLUTION_NAV_M6800','Soluzione 1.6T per DCI delle seire M6800');
define('FS_SOLUTION_NAV_WiFi6','Soluzioni di rete Wi-Fi 6');
//新加坡
define("FS_CHECKOUT_ERROR_SG_01","Your Address 2 is required.");
define("FS_CHECKOUT_ERROR_SG_02","Apt, Suite, Floor/Unit No.");
define("FS_CHECKOUT_ERROR_SG_03","Ticket Number");
define("FS_CHECKOUT_ERROR_SG_04","To ensure a smooth delivery, please provide a Ticket Number for parcels sent to Equinix.");
define("FS_CHECKOUT_ERROR_SG_05","*During COVID-19 special management period, it is recommended to fill in your house address to ensure the timeliness of receipt.");
define("FS_CHECKOUT_ERROR_SG_06","Please fill in your shipping address completely.");

define('FS_CHECKOUT_ERROR_001',"You've reached the maximum units allowed for the purchase of below items. All available products are added into the cart.");
define('FS_CHECKOUT_ERROR_002','Please select <span>4</span> different Channels.');
    
define("FS_SEE_ALL_RESULTS","Visualizza tutti i risultati");

//账户中心展示交换机软件更新
define('FS_SOFTWARE_DOWNLOAD',"Download del software");
define('FS_CHECK',"Controlla l'ultima versione software degli switch che hai acquistato");
define('FS_SOFWARE','Download del Software');
define('FS_SOFWARE_1','Contattare il servizio clienti');
define('FS_SOFWARE_2','Controlla l\'ultima versione software degli switch che hai acquistato. Per ulteriori versioni del software, vai a');
define('FS_SOFWARE_4','Centro Download');
define('FS_SOFWARE_5','Mostra:');
define('FS_SOFWARE_6','Switch Network');
define('FS_SOFWARE_7','1G/10G Switch');
define('FS_SOFWARE_8','25G Switch');
define('FS_SOFWARE_9','40G Switch');
define('FS_SOFWARE_10','100G Switch');
define('FS_SOFWARE_11','400G Switch');
define('FS_SOFWARE_12','Cerca articolo:');
define('FS_SOFWARE_13','Cerca');
define('FS_SOFWARE_14','Informazioni sui file più recenti');
define('FS_SOFWARE_15','ID del prodotto');
define('FS_SOFWARE_16','Data di Versione');
define('FS_SOFWARE_17','Dimensione');
define('FS_SOFWARE_18','Software');
define('FS_SOFWARE_19','Notifica di software');
define('FS_SOFWARE_20','Informazioni sui file più recenti');
define('FS_SOFWARE_22','Nota di Versione');
define('FS_SOFWARE_23','Versione');
define('FS_SOFWARE_24','Software');
define('FS_SOFWARE_25','Download');
define('FS_SOFWARE_26','Notifica del software');
define('FS_SOFWARE_27','Annulla l\'iscrizione');
define('FS_SOFWARE_28','Iscriviti');
define('FS_SOFWARE_29','Annulla l\'iscrizione alla nuova versione del software?');
define('FS_SOFWARE_30','Iscriviti alla nuova versione del software?');
define('FS_SOFWARE_31','Se non riesci a locare il software, prova a selezionare condizioni di filtro diverse.');
define('FS_SOFWARE_32','Non hai mai acquistato gli switch FS prima, vai a comprare gli switch FS.');
define('FS_SOFWARE_33','Inizia lo shopping');
define('FS_SOFWARE_34','Ti sei iscritto/a con successo.');
define('FS_SOFWARE_35','Riceverai email della notifica sul software più recente.');
define('FS_SOFWARE_36','Ti sei iscritto/a con successo.');
define('FS_SOFWARE_37','Hai annullato con successo l\'iscrizione.');
define('FS_SOFWARE_38','Non riceverai più email della notifica sul software più recente.');
define('FS_SOFWARE_39','ID del prodotto');
define('FS_SOFWARE_40','Nessun SOFTWARE Trovato.');

define('FS_SOFWARE_41','Isrivizione confermata');
define('FS_SOFWARE_42','Ti sei iscritto/a con successo agli aggiornamenti software per lo switch di seguito, ti invieremo una notifica quando sarà disponibile l\'ultima versione.');
define('FS_SOFWARE_43','Forse ti interesserebbe...');
define('FS_SOFWARE_44','Scopri cosa abbiamo offerto ai nostri clienti in tutto il mondo.');
define('FS_SOFWARE_45','Visualizza gli ultimi prodotti innovativi & <br> gli eventi aziendali.');
define('FS_SOFWARE_46','FS - Iscrizione agli aggiornamenti software');
define('FS_SOFWARE_47','Annulla con successo l\'iscrizione');
define('FS_SOFWARE_48','Non riceverai più email della notifica sul software più recente per gli switch di seguito');
define('FS_SOFWARE_49','In caso di errore, iscriviti nuovamente facendo clic sul pulsante in basso.');
define('FS_SOFWARE_50','Iscriviti di nuovo');
define('FS_SOFWARE_51','Teniamoci in contatto');
define('FS_SOFWARE_52','Iscrizione al software');
define('FS_SOFWARE_53','Eventi di successo del cliente FS');
define('FS_SOFWARE_54','Nuovo annuncio di FS');

define('FS_CHECKOUT_SPEC_PRODUCTS_DOUBT','Impossibile trovare un\'opzione di spedizione?');
define('FS_CHECKOUT_SPEC_PRODUCTS_TIPS','A causa della limitazione del corriere sulla dimensione dell\'articolo, gli ordini contenenti #73579/#73958 non possono essere spediti con consegna espressa generale. Puoi utilizzare il tuo corriere o consultare il tuo manager dell\'account per la spedizione tramite spedizioniere. Ci dispiace davvero per l\'inconveniente.');

//checkout_footer_new
define('FS_CHECKOUT_FOOTER_NEW_01', 'Ho un feedback su');
define('FS_CHECKOUT_FOOTER_NEW_02', '<a href="' . reset_url('service/fs_support.html'). '" target="_blank" >Centro Assistenza</a> o <a target="_blank" href="' . reset_url('contact_us.html') . '">Contattaci</a>.');
define('FS_CHECKOUT_FOOTER_NEW_03', ' Per assistenza immediata, visita il nostro ');
define('FS_CHECKOUT_FOOTER_NEW_04', 'Seleziona un Argomento*');
define('FS_CHECKOUT_FOOTER_NEW_05', 'Seleziona ... ');
define('FS_CHECKOUT_FOOTER_NEW_06', 'Accesso/Creazione di un account');
define('FS_CHECKOUT_FOOTER_NEW_07', 'Carrello');
define('FS_CHECKOUT_FOOTER_NEW_08', 'Tasse');
define('FS_CHECKOUT_FOOTER_NEW_09', 'Indirizzo di fatturazione & Spedizione');
define('FS_CHECKOUT_FOOTER_NEW_10', 'Spedizione');
define('FS_CHECKOUT_FOOTER_NEW_11', 'Pagamento');
define('FS_CHECKOUT_FOOTER_NEW_12', 'Altri');
define('FS_CHECKOUT_FOOTER_NEW_13', 'Seleziona un argomento.');
define('FS_CHECKOUT_FOOTER_NEW_14', 'Cosa possiamo fare per migliorare la tua esperienza?');
define('FS_CHECKOUT_FOOTER_NEW_15', 'I tuoi commenti aiuteranno FS a rispondere più rapidamente.');
define('FS_CHECKOUT_FOOTER_NEW_16', 'Inserisci più di 10 caratteri.');
define('FS_CHECKOUT_FOOTER_NEW_17', 'Invia');
define('FS_CHECKOUT_FOOTER_NEW_18', 'Grazie per il tuo feedback.');
define('FS_CHECKOUT_FOOTER_NEW_19', 'Controlleremo il tuo suggerimento e lo useremo per migliorare il sito web di FS per le tue visite future.');
define('FS_CHECKOUT_SUCCESS_EMAIL_01', 'Hai ricevuto un nuovo feedback');
define('FS_CHECKOUT_SUCCESS_EMAIL_02', 'Il cliente ha inviato le seguenti informazioni nella pagina di pagamento riuscito, si prega gentilmente di ricontattarlo se necessario.');
define('FS_CHECKOUT_SUCCESS_EMAIL_03', 'Nome di cliente:');
define('FS_CHECKOUT_SUCCESS_EMAIL_04', 'Email di cliente');
define('FS_CHECKOUT_SUCCESS_EMAIL_05', 'Numero di ordine:');
define('FS_CHECKOUT_SUCCESS_EMAIL_06', 'Argomento di feedback:');
define('FS_CHECKOUT_SUCCESS_EMAIL_07', 'Contenuti aggiuntivi:');
define('FS_CHECKOUT_SUCCESS_EMAIL_08', 'Argomento di feedback');

define('FS_PRINT',"To protect customer's privacy, please enter the FS account of user who placed this order to check the order details:");
define('FS_PRINT_1',"Confirm");
define('FS_PRINT_2',"The email you entered does not match the order information. Please verify and enter again.");
define('FS_PRINT_3',"Please enter the email address.");

//评论改版
define('FS_REVIEW_07','Modello di attrezzo');
define('FS_REVIEW_08','L\'aggiunta del modello della tua attrezzatura aiuta gli altri clienti');
define('FS_REVIEW_09','Supporta i file di tipo JPG, JPEG, PNG, dimensione massima di 5 MB');
//define('FS_REVIEW_10','Allowd file types: PDF, JPG, PNG');
define('FS_REVIEW_11','Optional');

define('FS_REVIEW_ATTRIBUTE_CONTENT', 'Compatibility');


//liang.zhu 2020.08.03
define('FS_CLEARANCE_TIP_01_01', 'Questo prodotto promozionale è limitato a $QTY pezzo/i e verrà rimosso una volta esaurito.');
define('FS_CLEARANCE_TIP_01_02', 'Per più quantità, consigliamo di acquistare il prodotto alternativo "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_02_01', 'Questo prodotto promozionale è esaurito e verrà presto rimosso.');
define('FS_CLEARANCE_TIP_02_02', 'Per più quantità, consigliamo di acquistare il prodotto alternativo "<a style="color:#0070BC;" target="_blank" href="'.reset_url('/products/$PRODUCTS_ID.html').'">$PRODUCTS_ID</a>".');
define('FS_CLEARANCE_TIP_03_01', 'Questo prodotto promozionale è limitato a $QTY pc(s) pezzo/i e verrà rimosso una volta esaurito.');
define('FS_CLEARANCE_TIP_03_02', 'Per più quantità, contatta il tuo manager dell\'account.');
define('FS_CLEARANCE_TIP_04_01', 'Questo prodotto promozionale è esaurito e verrà presto rimosso.');
define('FS_CLEARANCE_TIP_04_02', 'Per ulteriori quantità, contatta il tuo manager dell\'account.');


define('CHECKOUT_COMPANY_TYPE', 'Il tipo di indirizzo è errore');



## 添加 Delivery Instructions信息
define("FS_DELIVERY_TITLE", "Istruzioni di consegna (opzionale)");
define("FS_DELIVERY_TICKET_NUMBER", "Numero del biglietto, codice di sicurezza ecc.");
define("FS_DELIVERY_OTHER_INFO", "Tempo di consegna o altre istruzioni di consegna");
define("FS_DELIVERY_PROMPT", "Le tue istruzioni ci aiuteranno a consegnare il pacco");
define('FS_DELIVERY_INSTRUCTIONS', 'Istruzioni di spedizione');


//PO
define('FS_PO_FILE','Ordine di Acquisto(PO)');
define('FS_PO_FILE_1','FS.COM Inc.');
define('FS_PO_FILE_2','380 Centerpoint Blvd, New Castle,<br /> DE 19720, United States');
define('FS_PO_FILE_3','Ordine di Acquisto(PO)');
define('FS_PO_FILE_4','Data: 08/08/2020<br />PO #: PO0001');
define('FS_PO_FILE_5','Fornitore');
define('FS_PO_FILE_6','Spedizione a');
define('FS_PO_FILE_7','Fatturazione a');
define('FS_PO_FILE_8','FS.COM Pty Ltd');
define('FS_PO_FILE_9','57-59 Edison Rd, Dandenong South, <br />VIC 3175, Australia <br />ABN 71 620 545 502');
define('FS_PO_FILE_10','Manager d\'account: ');
define('FS_PO_FILE_11','Ann.Smith');
define('FS_PO_FILE_12','Email: ');
define('FS_PO_FILE_13','Ann.Smith@fs.com');
define('FS_PO_FILE_14','FS.COM Pty Ltd');
define('FS_PO_FILE_15','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_16','Telefono #: ');
define('FS_PO_FILE_17','+1 (888) 468 7419');
define('FS_PO_FILE_18','Destinatario: ');
define('FS_PO_FILE_19','Steven');
define('FS_PO_FILE_20','FS.COM Inc.');
define('FS_PO_FILE_21','380 Centerpoint Blvd <br />New Castle, <br />DE 19720');
define('FS_PO_FILE_22','Telefono #: ');
define('FS_PO_FILE_23','+1 (888) 468 7419');
define('FS_PO_FILE_24','Destinatario: ');
define('FS_PO_FILE_25','Steven');
define('FS_PO_FILE_26','Termine di Pagamento');
define('FS_PO_FILE_27','Richiesto da');
define('FS_PO_FILE_28','Reparto');
define('FS_PO_FILE_29','Bonifico Bancario');
define('FS_PO_FILE_30','Steven Jones');
define('FS_PO_FILE_31','Direzione Acquisti');
define('FS_PO_FILE_32','FS RQC #: RQC2008010003');
define('FS_PO_FILE_33','<th>Des. di Articolo</th><th>ID Articolo</th><th>Qtà</th><th>Prezzo Unitario</th><th>Totale</th>');
define('FS_PO_FILE_36','SUBTOTALE:');
define('FS_PO_FILE_38','Spese di Spedizione:');
define('FS_PO_FILE_39','TASSE/IVA:');
define('FS_PO_FILE_40','TOTALE:');
define('FS_PO_FILE_41',"Che cosa è un file di acquisto d'ordine (PO) ?");
define('FS_PO_FILE_42','Il file dell\'ordine di acquisto (PO) viene utilizzato come buono per gli ordini di acquisto e generalmente include il seguente contenuto: ');
define('FS_PO_FILE_43','Data e numero dell\'ordine di acquisto;');
define('FS_PO_FILE_44','Informazioni sulla società dell\'acquirente e del fornitore;');
define('FS_PO_FILE_45',"Indirizzo di spedizione e fatturazione; Termine di pagamento;");
define('FS_PO_FILE_46','Info e prezzo dell\'articolo FS.');
define('FS_PO_FILE_47',"Scopri un esempio del file PO ");

//线下订单列表
define('FS_OFFLINE_01','Download Invioce');
define('FS_OFFLINE_02','Order Placed on: ');
define('FS_OFFLINE_03','Order #: ');
define('FS_OFFLINE_04','Items Subtotal: ');
define('FS_OFFLINE_05','Shipping Cost: ');
define('FS_OFFLINE_06','GST: ');
define('FS_OFFLINE_07','Insurance: ');
define('FS_OFFLINE_08','TOTAL: ');
define('FS_OFFLINE_09','Your order has been shipped according to the selected method during checkout. You may view the tracking status by clicking the Tracking Number below or in the notification e-mail. However, some shipping carriers do not always update tracking information immediately, the status of your shipment may be deferred.');
define('FS_OFFLINE_10','The delivery has been replaced by a new order');
define('FS_OFFLINE_11','Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements,Main advantages are its passive nature – no power supply or cooling  necessary, and robustness – no special microclimate requirements, Main advantages are its passive nature – no power ');
define('FS_OFFLINE_12','Confirm Receipt');
define('FS_OFFLINE_13','This delivery has been canceled, please contact your account manager if you have any questions.');
define('FS_OFFLINE_14','View ');
define('FS_OFFLINE_15',' more deliveries');
define('FS_OFFLINE_16',' in this order.');
define('FS_OFFLINE_17','Processing');
define('FS_OFFLINE_18','ok');
define('FS_OFFLINE_19','Order # ');
define('FS_OFFLINE_20','(current order)');
define('FS_OFFLINE_21','NESSUN ORDINE TROVATO.');
define('FS_OFFLINE_22','Se non riesci a trovare il tuo ordine, prova a selezionare diverse condizioni di filtro o controlla l\'ordine#.<br/>Gli ordini offline possono essere cercati solo dopo la spedizione. Potresti consultare il tuo manager d\'account prima.');
//线下订单订单详情
define('FS_OFFLINE_ORDERS','Offline Orders');
define('FS_OFFLINE_COMBINED_SHIPMENT','Combined Shipment');
define('FS_OFFLINE_COMBINED_SHIPMENT_DETAILAS','To reduce the amount of deliveries and help protect environment, FS has arranged to ship your orders below together. Click order # to check details of respective order.');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_01','If the order status hasn\'t been updated, please consult your account manager. You\'ll see this order in "');
define('FS_OFFLINE_TRACK_YOUR_PACKAGE_02','" when it\'s shipped out.');
define('FS_OFFINE_TRANSACTION_1','This delivery has been canceled, please contact your account manager if you have any questions.');
define('FS_OFFLINE_POPUP','There are other orders combined into this shipment.');
define('FS_OFFINE_TRANSACTION','Offline Transaction');
define('FS_OFFINE_TRANSACTION_2','See Tracking info below under the delivery');
define('FS_OFFINE_TRANSACTION_4','Your order is being Processed.');
//my credit orders 页面
define('FS_VIEW_CONTENT','This order is divided into several deliveries, you may view all invoices in order details as the invoices are seperated for each delievery. Click to ');
define('FS_VIEW_LINK','view all invoices.');
define('FS_MY_CREDIT_01','Show:');
define('FS_MY_CREDIT_02','Ordini online');
define('FS_MY_CREDIT_03','Ordini offline');
define('FS_MY_CREDIT_04','Go');
define('FS_OFFINE_TRACK_INFO_1','If the order status hasn\'t been updated, please consult your account manager. You\'ll see this order in "<a class="new_alone_a" href="'.zen_href_link('manage_orders').'">Order History</a>" when it\'s shipped out.');
define('FS_PRINT_AVE_1','FS.COM LIMITED</br>Unit 1, Warehouse No. 7</br>South China International Logistics Center</br>Longhua District</br>Shenzhen, 518109');
define('FS_PRINT_US_1','China');

//结算页
define('FS_CHECK_OUT_EXCLUDING1','Excluding Duties and Taxes');

//搜索V2版本
define('FS_SEARCH_NEW','Risultati ricerca per ');
define('FS_SEARCH_NEW_1','Prodotto');
define('FS_SEARCH_NEW_2','Documento &amp; Risorse');
define('FS_SEARCH_NEW_3','Soluzioni');
define('FS_SEARCH_NEW_4','Casi Studio');
define('FS_SEARCH_NEW_5','Download');
define('FS_SEARCH_NEW_6','Cancella Tutto');
define('FS_SEARCH_NEW_7','Soluzioni');
define('FS_SEARCH_NEW_8','Casi Studio');
define('FS_SEARCH_NEW_9','Nome');
define('FS_SEARCH_NEW_10','Tipo');
define('FS_SEARCH_NEW_11','Data');
define('FS_SEARCH_NEW_12','File');
define('FS_SEARCH_NEW_13','Notizie');
define('FS_SEARCH_NEW_14','non è più disponibile online, visualizza il prodotto simile ');
define('FS_SEARCH_NEW_15',' come di seguito.');
define('FS_SEARCH_NEW_16',' non è più disponibile online, si prega di richiedere un preventivo per assistenza.');

define('FS_ACCOUNT_SEARCH_ALL_TIMES', 'Tutti');

define('FS_MY_SHOPPING_CART','Il Mio Carrello');
define('GET_A_QUOTE_TIP_1',"*Per richieste di informazioni suL tempo di esecuzione o sulla spedizione, aiutaci a compilare le informazioni seguenti e inviare il preventivo, ti risponderemo il prima possibile.");

define("FS_INQUIRY_NEW_EMAIL"," ti ha inviato una richiesta della modifica di #");
define("FS_INQUIRY_NEW_EMAIL_1"," Modifica di Preventivo");
define("FS_INQUIRY_NEW_EMAIL_2"," ti ha inviato una richiesta per modificare il preventivo");
define("FS_INQUIRY_NEW_EMAIL_3",", si prega di controllare i dettagli di seguito e fare il preventivo di nuovo al più presto.");
define("FS_INQUIRY_NEW_EMAIL_4","Numero di Caso:");
define("FS_INQUIRY_NEW_EMAIL_5","Articolo(i)");
define("FS_INQUIRY_NEW_EMAIL_6","Quantità");
define("FS_INQUIRY_NEW_EMAIL_7","Prezzo Unitario");
define("FS_INQUIRY_NEW_EMAIL_8","Prezzo Preventivo");
define("FS_INQUIRY_NEW_EMAIL_9","Totale Originale:");
define("FS_INQUIRY_NEW_EMAIL_10","Totale Preventivo:");
define("FS_INQUIRY_NEW_EMAIL_11","Si prega di rispondere a ");
define("FS_INQUIRY_NEW_EMAIL_12"," o inviare il preventivo all' account.");
define("FS_INQUIRY_NEW_EMAIL_13","Il tuo commento è stato inviato.");
define("FS_INQUIRY_NEW_EMAIL_14","Abbiamo ricevuto la tua email. Il tuo manager d'account ti risponderà entro 12-24 ore.");


/**
 * quote 2020 07 改版
 */
define('FS_QUOTE_INQUIRY_01', 'Seleziona il File');
define('FS_QUOTE_INQUIRY_02', 'Carica Elenco di Prodotti');
define('FS_QUOTE_INQUIRY_03', "Inserisce l'ID prodotto o carica l'elenco dei prodotti di cui hai bisogno di fare il preventivo.");
define('FS_QUOTE_INQUIRY_04', 'La tua richiesta di preventivo è stata inviata con successo.');
define('FS_QUOTE_INQUIRY_05', "Il tuo manager d'account elaborerà il preventivo entro 12-24 ore e ti invierà un'email quando il preventivo sarà pronto.");
define("FS_QUOTE_EDIT_QUOTE", "Modifica Preventivo");
define("FS_QUOTE_QUOTE_REQUEST", "RICHIESTA PREVENTIVO");
define("FS_QUOTE_INQUIRY_06", "Invia email al tuo manager d 'account su questo preventivo");
define("FS_QUOTE_INQUIRY_07", "Il Tuo Preventivo ");
define("FS_QUOTE_INQUIRY_08", "è attivo, ");
define("FS_QUOTE_INQUIRY_09", "puoi effettuare direttamente il checkout.");
define("FS_QUOTE_INQUIRY_10", "Se hai bisogno di modificare questo preventivo o hai domande al riguardo, potresti compilare le informazioni seguenti. Verrà inviata un'email al tuo manager d'account in base al tuo messaggio.");
define("FS_QUOTE_INQUIRY_11", "Da:");
define("FS_QUOTE_INQUIRY_12", "Manager d'account risponderà a questa email.");
define("FS_QUOTE_INQUIRY_13", "A:");
define("FS_QUOTE_INQUIRY_14", "Contenuto di cui vuoi parlare");
define("FS_QUOTE_INQUIRY_15", "Se desideri aggiungere o modificare i prodotti, è consigliato che annota l'ID del prodotto (es. #11552) e la quantità desiderata.");
define("FS_QUOTE_INQUIRY_16", "Invia un'e-mail");
define("FS_QUOTE_INQUIRY_17", "Stampa Carrello");
define("FS_QUOTE_INQUIRY_18", "Stampa Come Preventivo");
define("FS_QUOTE_INQUIRY_19", "Hai bisogno di modificare questo preventivo?");
define("FS_QUOTE_INQUIRY_20", "Articolo(i)");
define("FS_QUOTE_INQUIRY_21", "CARICA ELENCO DI PRODOTTI");
define("FS_QUOTE_INQUIRY_22", "Elenco di Prodotti:");
define("FS_QUOTE_INQUIRY_23", "Stato della Richiesta di Preventivo ");
define("FS_QUOTE_INQUIRY_24", "è stato aggiornato. Controlla di nuovo.");
define("FS_QUOTE_INQUIRY_25", "Carica i file relativi all'Ordine d'acquisto(PO).");
define("FS_QUOTE_INQUIRY_26", "Commenti (OPZIONALE)");
define("FS_QUOTE_INQUIRY_28", "Contenuto");
define("FS_JUST_ITEM", "Articolo");


//消费税邮件
define('FS_TAX_EMAIL_01','Application Received');
define('FS_TAX_EMAIL_02','FS - Your Tax Exemption Application Received');
define('FS_TAX_EMAIL_03','Your application is under review.');
define('FS_TAX_EMAIL_04','Tax Exemption State:');
define('FS_TAX_EMAIL_05','We\'ll let you know the result of your application within 1-2 business days, you can view the progress of the application by clicking the button below.');
define('FS_TAX_EMAIL_06','View application');
define('FS_TAX_EMAIL_07','If you have any questions in relation to this Tax Exemption Application, please <a href="'.HTTPS_SERVER.reset_url('service/sales_tax.html').'" target="_blank" style="color: #0070BC;text-decoration: none">learn</a> about the U.S. Sales Tax in FS.com Purchases, or <a href="'.zen_href_link(FILENAME_CONTACT_US).'" target="_blank" style="color: #0070BC;text-decoration: none">Contact Us</a> for help.');
define('FS_CHECKOUT_PAY_01','Paga');
define('FS_COMMON_DHL','DHL Economy Select®');

//详情页新文件标记
define('FS_NEW_FILE_TAG','Nuovo');

//inquiry
define('FS_INQUIRY_EDIT_SUCCESS_1','La tua modifica di ');
define('FS_INQUIRY_EDIT_SUCCESS_2',' è stata inviata con successo.');
define('FS_MY_SHOPPING_CART_OFFICIAL_QUOTE','Mio preventivo ufficiale');

define('FS_XING_HAO', '*');


//下单邮件公司信息底部展示
// 深圳仓
define('FS_CHECKOUT_FS_NAME_CN', "FS.COM LIMITED");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_CN','
			Unit 1, Warehouse No. 7,
			South China International Logistics Center,
			Longhua District,
			Shenzhen, 518109, China');
// 德国仓
define('FS_CHECKOUT_FS_NAME_EU', "FS.COM GmbH");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_EU','  
			NOVA Gewerbepark, Building 7,
			Am Gfild 7,
			85375, Neufahrn bei Munich,
			Germania
');
define('FS_CHECKOUT_EMAIL_TEL_EU', '+49 (0) 8165 80 90 517');
define('FS_CHECKOUT_EMAIL_EU', 'de@fs.com');

// 美东仓
define('FS_CHECKOUT_FS_NAME_US', "FS.COM INC ");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_US',' 
			380 CENTERPOINT BLVD,
			NEW CASTLE, DE 19720,
			Stati Uniti
');
define('FS_CHECKOUT_EMAIL_TEL_US', 'Tel: +1 (888) 468 7419');
define('FS_CHECKOUT_EMAIL_US', 'us@fs.com');
// 澳洲仓 （澳大利亚）
define('FS_CHECKOUT_FS_NAME_AU', "FS.COM PTY LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_AU','
				57-59 Edison Road,
				Dandenong South,
				VIC 3175,
				Australia,
				ABN: 71 620 545 502
');
define('FS_CHECKOUT_EMAIL_TEL_AU', 'Tel: +61 3 9693 3488');
define('FS_CHECKOUT_EMAIL_AU', 'au@fs.com');
// 新加坡仓
define('FS_CHECKOUT_FS_NAME_SG', "FS TECH PTE. LTD");
define('FS_CHECKOUT_EMAIL_WAREHOUSE_SG','
				30A Kallang Place #11-10/11/12,
				Singapore 339213,
				Singapore,
				GST Reg No.: 201818919D');
define('FS_CHECKOUT_EMAIL_TEL_SG', 'Tel: (65) 6443 7951');
define('FS_CHECKOUT_EMAIL_SG', 'sg@fs.com');



define ('FS_ORDERS_TRACKING_NINJA_STATUS1', 'Raccolto con successo dal mittente - FS');
define ('FS_ORDERS_TRACKING_NINJA_STATUS2', 'Il pacco è in elaborazione nel magazzino di Ninja Van - Impianto di smistamento Ninja Van');
define ('FS_ORDERS_TRACKING_NINJA_STATUS3', 'Il pacco sta arrivando');
define ("FS_ORDERS_TRACKING_NINJA_STATUS4", "Consegnato con successo");
define('FS_CHECKOUT_SUCCESS_PURCHASE_03', 'è confermato. Si prega di caricare il file dell\'ordine di acquisto (PO) entro 7 giorni lavorativi. In caso contrario, l\'ordine verrà annullato automaticamente in base al cambio di inventario degli articoli.');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04', 'Carica il file dell\'ordine di acquisto (PO)');
define('FS_CHECKOUT_SUCCESS_PURCHASE_04_1', 'Cos\'è un file PO?');

//账户中心确认收货弹窗
define("FS_ACCOUNT_ORDER_REVIEWS_COUNT",'Recensione per ordine');
define('FS_ACCOUNT_HISTORY_INFO_THANK', "Grazie per aver scelto noi.");
define('FS_ACCOUNT_HISTORY_INFO_REVIEWS', "La tua recensione è preziosa per gli altri clienti, ci piacerebbe avere tue notizie. <br />Fai clic sul pulsante e lascia la tua recensione!");
define('FS_ACCOUNT_HISTORY_INFO_NOT_NOW', "Non adesso");
define('FS_FOOTER_COOKIE_TIP_NEW','Utilizziamo i cookie per assicurarci di offrirti la migliore esperienza sul nostro sito web. Fai clic su "Accetta cookie" o continua a proseguire nella navigazione del nostro sito, acconsenti al nostro utilizzo dei cookie <br />in accordo con nostro <a href="'.HTTPS_SERVER.reset_url('policies/privacy_policy.html').'">Privacy e Cookie</a>. Puoi rifiutare l\'utilizzo dei cookie <a href="javascript:;" class="refuse_cookie_btn_google">Qui</a>.');
define('FS_FOOTER_COOKIE_TIP_BTN','Accetta cookie');



//新增俄罗斯仓库
define("FS_MAGAZZINO_RU","Magazzino RU");
define('FS_RU_NOTIZIA',"Il magazzino FS RU situato a Mosca supporta la spedizione veloce in giornata. <a target='_blank' href='".zen_href_link("shipping_delivery","","SSL")."'>Leggi di più</a>");
define('FS_COMMON_MAGAZZINO_RU','《FiberStore.COM》Ltd.<br>
            No.4062, d. 6, str. 16<br>
            Proektiruemyy proezd<br>
            Moscow 115432<br>
            Federazione Russa<br>
            Tel: +7 (499) 643 4876');
define("FS_AREA_MAGAZZINO_TEMPO_48","Ritiro al Magazzino RU all'orario desiderato");
define("FS_MAGAZZINO_AREA_NAVIGAZIONE_RU"," da Magazzino RU");
define("FS_WAREHOUSE_AREA_RU","ship from RU Warehouse");

//销量语言包
define('FS_PRODUCTS_SALES_SOLD', '%s Venduto');
define('FS_PRODUCTS_SALES_SOLDS', '%s Venduti');
define('FS_PRODUCTS_SALES_REVIEW', '%s Recensione');
define('FS_PRODUCTS_SALES_REVIEWS', '%s Recensioni');


define("FS_NOTES",'Note');

define('FS_REVIEWS_TAG_01', 'Recensioni dei Clienti');
define('FS_REVIEW_NEW_15', 'Clicca sull\'immagine per aggiungere i tag, puoi anche aggiungere');
define('FS_REVIEW_NEW_16', 'tag');
define('FS_REVIEW_NEW_17', 'Salva');
define('FS_REVIEW_NEW_18', 'Modifica i tag');
define('FS_REVIEW_NEW_19', 'Acquistato recentemente');
define('FS_REVIEW_NEW_20', 'Nessun ordine trovato.');
define('FS_REVIEW_NEW_21', 'Conferma');
define('FS_REVIEW_NEW_22', 'Clicca e inserisci ID/titolo di prodotto');
define('FS_REVIEW_NEW_23', 'Si prega di inserire l\'ID prodotto/titolo del prodotto.');
define('FS_REVIEW_NEW_24', 'Tagga i prodotti');
define('FS_REVIEW_NEW_25', 'Vedi tutta la galleria clienti');
define('FS_REVIEW_NEW_26', 'tag');

//详情优化
define('FS_PRODUCT_SPOTLIGHTS_01', "Caratteristiche dell'articolo");
define('FS_PRODUCT_COMMUNITY_01', 'Comunità');
define('FS_PRODUCT_COMMUNITY_02', 'Idee');
define('FS_PRODUCT_COMMUNITY_03', 'Disimballaggio dello Switch S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_04', 'Test Ixia RFC2544 per Switch S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_05', 'Video prodotto:S5860-20SQ | FS');
define('FS_PRODUCT_COMMUNITY_06', 'Come collegare lo switch FS con lo switch Cisco | FS');
define('FS_PRODUCT_COMMUNITY_07', 'Unboxing the S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_08', 'Ixia RFC2544 Test for S3910-24TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_09', 'S3910-24TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_10', 'Unboxing the S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_11', 'Unboxing the S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_12', 'Ixia RFC2544 Test for S3910-48TS Switch | FS');
define('FS_PRODUCT_COMMUNITY_13', 'S3910-48TS: Product Video | FS');
define('FS_PRODUCT_COMMUNITY_14', 'First Look at S5860-24XB-U Switch | FS');
define('FS_PRODUCT_COMMUNITY_15', 'S5860-24XB-U Multi-Gig L3 Switch Ixia RFC2544 Test | FS');
define('FS_PRODUCT_COMMUNITY_16', 'Uninterruptible Power Supply Test on S5860-24XB-U | FS');
define('FS_PRODUCT_COMMUNITY_17', 'How to Connect FS Multi-Gig L3 Switch with Cisco Switch | FS');
define('FS_PRODUCT_COMMUNITY_18', 'Unboxing L2+ PoE+ Switch S3410-24TS-P | FS');
define('FS_PRODUCT_COMMUNITY_19', 'Take You to Know S3410-24TS-P in Short | FS');
define('FS_PRODUCT_COMMUNITY_20', 'How to Check Power Status of PoE Port via Web | FS');
define('FS_PRODUCT_COMMUNITY_21', 'IXIA RFC2544 Test on S3410-24TS-P PoE Switch | FS');
define('FS_PRODUCT_COMMUNITY_22', 'Come sostituire gli alimentatori e le ventole | FS');
define('FS_PRODUCT_HIGHLIGHTS_01', 'Caratteristiche del prodotto');

define('FS_PRODUCT_HIGHLIGHTS_01', 'Caratteristiche del prodotto');

//报价PDF语言包
define('FS_QUOTES_PDF_01', 'Preventivo ufficiale');
define('FS_QUOTES_PDF_01_TAX', 'Preventivo ufficiale');
define('FS_QUOTES_PDF_02', 'No. richiesta preventivo');
define('FS_QUOTES_PDF_03', 'Creato da');
define('FS_QUOTES_PDF_04', '1. Il preventivo è valido solo per 15 giorni, si prega di contattare il tuo account manager per richiedere nuovamente dopo la scadenza.');
define('FS_QUOTES_PDF_05', '2. Si prega di lasciare un messaggio con il numero della richiesta preventivo di questo ordine, o il nome della tua azienda quando paghi questo ordine.');
define('FS_QUOTES_PDF_TOTAL_TAX', 'Totale');
//报价成功邮件语言包
define('EMAIL_QUOTES_SUCCESS_01', "Abbiamo ricevuto la tua richiesta preventivo ");
define('EMAIL_QUOTES_SUCCESS_02', ' e ti invierà un\'e-mail con i dettagli del preventivo entro un giorno lavorativo.');
define('EMAIL_QUOTES_SUCCESS_03', 'Il tuo messaggio');
define('EMAIL_QUOTES_SUCCESS_04', 'Request quote, please give me your best offer.');
define('EMAIL_QUOTES_SUCCESS_05', 'Visualizza nel mio account');
define('EMAIL_QUOTES_SUCCESS_06', 'Scarica il PDF');
//报价分享邮件语言包
define('EMAIL_QUOTES_SHARE_01', 'È possibile visualizzare e convertire questo preventivo in un ordine in "Conto/Preventivo” .');
define('EMAIL_QUOTES_SHARE_02', 'Se hai domande sulla configurazione, sui prezzi e sulla verifica del contratto, ');
define('EMAIL_QUOTES_SHARE_03', 'si prega di contattare il tuo account manager.');
define('EMAIL_QUOTES_SHARE_04', 'Aggiornamento del preventivo');
define('EMAIL_QUOTES_SHARE_05', 'Hai ricevuto un nuovo preventivo da FS.COM.');


//报价详情页语言包
define('FS_QUOTES_DETAILS_01', 'L‘’Inventario,la data di consegna,le imposte stimate e i costi di spedizione sono soggetti a modifiche e saranno ricalcolati al checkout.');
define('FS_QUOTES_DETAILS_02', 'Vai al checkout');
define('FS_QUOTES_DETAILS_03', 'Di seguito è riportato il tuo preventivo. Questo preventivo è valido fino al $TIME.');
define('FS_QUOTES_DETAILS_04', 'Richiesta preventivo #:');
define('FS_QUOTES_DETAILS_05', 'Scarica il preventivo');
define('FS_QUOTES_DETAILS_06', 'Data di richiesta preventivo:');
define('FS_QUOTES_DETAILS_07', 'Data preventivo:');
define('FS_QUOTES_DETAILS_08', 'ID del cliente:');
define('FS_QUOTES_DETAILS_09', 'No.  #');
define('FS_QUOTES_DETAILS_10', 'Manager del cliente:');
define('FS_QUOTES_DETAILS_11', 'Telefono #:');
define('FS_QUOTES_DETAILS_12', 'Spedizione a');
define('FS_QUOTES_DETAILS_13', 'Metodo di spedizione: ');
define('FS_QUOTES_DETAILS_14', 'Fattura a');
define('FS_QUOTES_DETAILS_15', 'Metodo di pagamento:');
define('FS_QUOTES_DETAILS_16', 'Vedi tutto');
define('FS_QUOTES_DETAILS_17', 'Riferimento');
define('FS_QUOTES_DETAILS_18', 'Spiacenti, l\'articolo è stato rimosso e non è più disponibile per l\'acquisto.');
define('FS_QUOTES_DETAILS_19', 'Lunghezza: ');
define('FS_QUOTES_DETAILS_20', 'Più');
define('FS_QUOTES_DETAILS_21', 'Questo articolo comprende i seguenti prodotti');
define('FS_QUOTES_DETAILS_22', 'Iva/Tassa:');
define('FS_QUOTES_DETAILS_23', 'Questo preventivo è scaduto il $TIME. È possibile richiedere un preventivo di nuovo in caso di necessità.');
define('FS_QUOTES_DETAILS_24', 'Il preventivo è stato ordinato con successo.');


//报价列表页语言包
define('QUOTES_LIST_BRED_CRUMBS','Storico preventivi');

define('QUOTES_LIST_TIME_TYPE_1', 'Tutti i tempi cornici');
define('QUOTES_LIST_TIME_TYPE_2', 'Ultimo mese');
define('QUOTES_LIST_TIME_TYPE_3', 'Ultimi 3 mesi');
define('QUOTES_LIST_TIME_TYPE_4', 'Ultimo anno');
define('QUOTES_LIST_TIME_TYPE_5', 'Un anno fa');

define('QUOTES_LIST_STATUS_TYPE_1', 'Preventivi online');
define('QUOTES_LIST_STATUS_TYPE_2', 'Attivo');
define('QUOTES_LIST_STATUS_TYPE_3', 'Valido');
define('QUOTES_LIST_STATUS_TYPE_4', 'Scaduto');
define('QUOTES_LIST_STATUS_TYPE_5', 'Preventivi offline');
define('QUOTES_LIST_STATUS_TYPE_6', 'Tutti gli stati');

define('QUOTES_LIST_RESULT_SINGULAR', 'Risultato');
define('QUOTES_LIST_RESULT_PLURAL', 'Risultati');
define('QUOTES_LIST_UPDATE_TIME', 'Prezzo aggiornato il $TIME');
define('QUOTES_LIST_EXPIRE_TIME', 'Scaduto il $TIME');
define('QUOTES_LIST_EXPIRE_TIME_ACTIVE', 'Scadrà il $TIME');
define('QUOTES_LIST_QUOTE_AGAIN', 'Richiedi di nuovo');
define('QUOTES_LIST_VIEW_ORDERS', 'Visualizza l\'ordine & Paga');
define('QUOTES_LIST_SEARCH_PLACEHOLDER', 'Ricerca per #preventivo, Descrizione dell\'ordine …');

define('FS_SHOPPING_CART_CREATE_QUOTE', 'Crea preventivo');
define('FS_QUOTES_ORDERS_NUMBER', 'Numero dell\'ordine');
define('QUOTES_LIST_EMPTY_TIPS', 'Nessun preventivo trovato.');
define('FS_QUOTES_CREATE_EMAIL_THEME','FS - Abbiamo ricevuto la tua richiesta di preventivo $NUM');
define('FS_QUOTES_SHARE_EMAIL_THEME','FS - Il tuo amico $EMAIL ti ha condiviso un preventivo');
define('FS_QUOTES_OFFLINE_DETAIL_TIPS', 'Le spese di spedizione e le tasse saranno calcolate al checkout.');

define('FS_INQUIRY_SUBMITED', 'Inviato');

define('FS_RECENT_SEARCH', 'Ricerche recenti');
define('FS_HOT_SEARCH', 'Più cercati');
define('FS_CHANGE', 'Cambia');

define('FS_VIEW_WORD', 'Visualizza');

//一级分类页
define('FS_CATEGORIES_POPULAR', 'Categorie Popolari');
define('FS_CATEGORIES_BEST_SELLERS', 'Più venduti');
define('FS_CATEGORIES_NETWORK', 'Assemblaggi di Rete');
define('FS_CATEGORIES_DISCOVERY', 'Scopri');

define('CARD_NOT_SUPPORT', 'Questo metodo di pagamento non è attualmente supportato. Si prega di scegliere un metodo diverso.');
//全站help center 调整为FS Support 2021.1.15  ery
define('FS_COMMON_FS_SUPPORT','Supporto FS');


define('FS_ADVANCED_SEARCH_RESULT_TIP_1', '<span class="new_proList_proListNtit">Risultato trovato per</span> "###RECOMMEND_WORD###"<span class="new_proList_proListNtit">, perché nessun risultato trovato per</span> "###SEARCH_WORD###"<span class="new_proList_proListNtit">.</span>');
define('FS_ADVANCED_SEARCH_RESULT_TIP_2', 'Hai cercato <a href="###HREF_LINK###" target="_blank">###RECOMMEND_WORD###</a>');

define('SEARCH_OFFLINE_PRODUCT_TIP_1_V2', 'Il nuovo prodotto aggiornato è raccomandato come di seguito per il tuo riferimento.');
define('SEARCH_OFFLINE_PRODUCT_TIP_2_V2', 'Il prodotto simile è raccomandato come di seguito per il tuo riferimento.');
define('SEARCH_OFFLINE_PRODUCT_TIP_3_V2', 'Il prodotto personalizzato è consigliato come di seguito per il tuo riferimento.');
define('SEARCH_OFFLINE_PRODUCT_TIP_4_V2', ' Non trovi quello che ti serve? Contattaci per assistenza.');
define('SEARCH_OFFLINE_PRODUCT_TIP', '"KEYWORD" non è più disponibile online, ma è ancora possibile fornire da FS. Per maggiori dettagli, fai riferimento alla pagina <a  style="color: #0070BC;text-decoration: none" href="'.zen_href_link('offline_products_eos').'" target="_blank">Politica di fine vendita</a>.');
//信用卡语言包
define("CREDIT_CARD_ERROR_303","Riufitato - Nessun'altra informazione viene fornita dall'emittente");
define("CREDIT_CARD_ERROR_606","l'emittente non consente questo tipo di operazione");
define("CREDIT_CARD_ERROR_08","Dati CVV2/CID/CVC2 non verificati");
define("CREDIT_CARD_ERROR_22","Numeri della carta di credito non validi");
define("CREDIT_CARD_ERROR_25","Data di scadenza non valida");
define("CREDIT_CARD_ERROR_26","Importo non valido");
define("CREDIT_CARD_ERROR_27","Titolare della carta non valida");
define("CREDIT_CARD_ERROR_28","Autorizzazione N. non valida");
define("CREDIT_CARD_ERROR_31","Stringa di verifica non valida");
define("CREDIT_CARD_ERROR_32","Codice di transazione non valida");
define("CREDIT_CARD_ERROR_57","N. di riferimento non valido");
define("CREDIT_CARD_ERROR_58","Stringa AVS non valida, la lunghezza della stringa AVS ha superato il massimo di 40 caratteri");
define('CREDIT_CARD_ERROR_260','Il servizio non disponibile temporaneamente a causa di un errore di rete. Prova più tardi o contatta il tuo gestore di account.');
define('CREDIT_CARD_ERROR_301','Il servizio non disponibile temporaneamente a causa di un errore di rete. Prova più tardi o contatta il tuo gestore di account.');
define('CREDIT_CARD_ERROR_304',"L'account non viene trovato. Si prega di controllare le informazioni o contattare la banca emittente");
define('CREDIT_CARD_ERROR_401',"L'emittente vuole contattare con il titolare della carta tramite vocale. Si prega di chiamare la banca emittente.");
define('CREDIT_CARD_ERROR_502','La carta è segnalata smarrita/rubata. Si prega di contattare la banca emittente. Nota: Non si applica ad American Express.');
define('CREDIT_CARD_ERROR_505',"Il tuo account è sul file negativo. Si prega di provare un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_509',"Superamento del limite di prelievo o dell'importo dell'attività. Prova un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_510',"Superamento del limite di prelievo o del conteggio delle attività. Prova un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_519',"Il tuo account è su file negativo. Si prega di provare un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_521',"L'importo totale supera il limite di credito. Si prega di provare un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_522','La sua carta è scaduta. Si prega di controllare la data di scadenza o provare un altro metodo di pagamento.');
define('CREDIT_CARD_ERROR_530','Mancanza delle informazioni fornite dalla banca emittente. Si prega di contattare la banca o provare un altro metodo di pagamento.');
define('CREDIT_CARD_ERROR_531',"L'emittente ha rifiutato la richiesta di autorizzazione. Si prega di contattare la banca emittente o provare un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_591',"Errore dell'emittente. Si prega di contattare la banca emittente o provare con un'altra carta.");
define('CREDIT_CARD_ERROR_592',"Errore dell'emittente. Si prega di contattare la banca emittente o provare con un'altra carta.");
define('CREDIT_CARD_ERROR_594',"Errore dell'emittente. Si prega di contattare la banca emittente o provare con un'altra carta.");
define('CREDIT_CARD_ERROR_776','Duplicazione della transazione, si prega di contattare il tuo gestore di account per confermare lo stato della transazione.');
define('CREDIT_CARD_ERROR_787',"Le transazioni sono rifiutate a causa dell'alto rischio. Si prega di provare un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_806',"La sua carta è stata limitata. Si prega di prova un'altra carta o un altro metodo di pagamento.");
define('CREDIT_CARD_ERROR_825',"L'account non viene trovato. Si prega di controllare le informazioni e riprovare.");
define('CREDIT_CARD_ERROR_902','Il servizio non disponibile temporaneamente a causa di un errore di rete. Si prega di provare più tardi o contattare il tuo gestore di account.');
define('CREDIT_CARD_ERROR_904','La tua carta non è attiva. Si prega di contattare la banca emittente.');
define('CREDIT_CARD_ERROR_201','Numero di account non valido/formato non corretto. Si prega di controllare il numero e riprovare.');
define('CREDIT_CARD_ERROR_204','Errore non identificabile. si prega di provare più tardi o usare un altro metodo di pagamento.');
define('CREDIT_CARD_ERROR_233',"Il numero della carta di credito non corrisponde al tipo di pagamento o BIN non valido. Si prega di provare un'altra carta o metodo di pagamento.");
define('CREDIT_CARD_ERROR_239',"La carta non è supportata. Si prega di provare un'altra carta o metodo di pagamento.");
define('CREDIT_CARD_ERROR_261',"Numero di account non valido/formato non corretto. Si prega di controllare i numeri e riprovare.");
define('CREDIT_CARD_ERROR_351','Il servizio non disponibile temporaneamente a causa di un errore di rete. Si prega di provare più tardi o contattare il tuo gestore di account.');
define('CREDIT_CARD_ERROR_755',"L'account non viene trovato. Si prega di controllare le informazioni o contattare la banca emittente.");
define('CREDIT_CARD_ERROR_758','Il conto è congelato. Si prega di contattare la banca emittente o provare un altro metodo di pagamento.');
define('CREDIT_CARD_ERROR_834',"La carta non è supportata. Si prega di provare un'altra carta o altro metodo di pagamento.");
define('HISTORY_TIPS', 'Puoi selezionare le quotazioni offline create dal tuo gestore di account qui.');
define('TIPS_BUTTON', 'Vai');

define('FS_CHECKOUT_EPIDEMIC_TIPS', 'La consegna può essere soggetta a ritardi o restrizioni a causa di misure amministrative ufficiali. 
Si prega di assicurarsi che ci sia qualcuno che riceve il pacco, altrimenti il pacco verrebbe restituito al mittente.');
define('FS_CHECKOUT_CUSTOMS_CLEARANCE_TIPS', 'L\'ordine potrebbe subire ritardi per motivi di sdoganamento.');

define('QUOTES_NOTE_TITLE','Nota:');
define('QUOTES_NOTE_TIPS','L\'inventario, la data di consegna, la tassa stimata e le spese di spedizione sono soggette a modifiche e saranno ricalcolate al checkout.');
define('QUOTES_RQN_NUMBER_TITLE','Numero di RQN:');
define('QUOTES_TRADE_TERM_TITLE','Termine commerciale:');
define('QUOTES_PAYMENT_TERM_TITLE','Termine di pagamento:');
define('QUOTES_SHIP_VIA_TITLE','Spedizione via:');
define('QUOTES_DATE_ISSUED_TITLE','Data di emissione:');
define('QUOTES_EXPIRES_TITLE','Data di scadenza:');
define('QUOTES_ACCOUNT_MANAGER_TITLE','Gestore di account:');
define('QUOTES_ACCOUNT_EMAIL_TITLE','E-mail:');
define('QUOTES_DELIVER_TO','Spedizione a');
define('QUOTES_BILLING_TO','Fatturazione a');
define('QUOTES_QUOTE_TITLE1','Articolo(i)');
define('QUOTES_QUOTE_TITLE2','Quantità');
define('QUOTES_QUOTE_TITLE3','Prezzo unitario');
define('QUOTES_QUOTE_TITLE4','Prezzo preventivo');

define('FS_CHECKOUT_POPUP_TIPS_QUOTE','Sei sicuro di vuoi tornare al tuo preventivo ?');

define('FS_WHAT_IS_DIFFERENCE', "Qual è la differenza?");
define('FS_AVAILABILITY', 'Disponibilità');
define('FS_ON_SALE', 'Disponibile');
define('FS_END_SALE', 'Non disponibile');
define('FS_DIFFERENCES', 'Si prega di controllare attentamente i parametri dettagliati per comprendere appieno le differenze dei prodotti prima di effettuare un acquisto.');

define('FS_CN_LIMIT_TIPS', 'Nota: quest\'articolo non può essere consegnato in Cina');
define('FS_INQUIRY_INFO_17', 'Commenti aggiuntivi');
define('QUOTE_MESSAGE_TXT_1', 'Commenti aggiuntivi (da '. $_SESSION['customer_first_name'].')');
define('QUOTE_MESSAGE_TXT_2', 'Commenti aggiuntivi (da gestore di account | FS)');
define('FS_IT_TEL_TIP','(Il nostro servizio clienti parla anche la tua lingua)');
