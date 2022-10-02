<?php
define('REQUEST_DEMO_BANNER_TITLE', 'Dimostrazioni per gli switch di rete');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','Hai già un account? <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">Accedi</a> o <a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">Crea un account</a>');

define('REQUEST_DEMO_INDUSTRY', 'Industria');
define('REQUEST_DEMO_OPTION_DEFAULT', 'Si prega di selezionare');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', 'Arti/Divertimento');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', 'Educazione - superiore');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', 'Educazione - K-12, Pubblico & Privato');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', 'Educazione - Altri');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'Energia/Utilità');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', 'Servizi finanziari');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', 'Governo');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', 'Assistenza sanitaria');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'Alta tecnologia - Soft/Hardware');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'Ospitalità/Hotel &Tempo libero');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', 'Biblioteca');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', 'Produzione');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'Media/Intrattenimento');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', 'Assenza di scopo di lucro & Organizzazioni di appartenenza');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'Altri');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'Servizi professionali');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', 'Vendita al dettaglio/ristoranti');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'Fornitore di servizio');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', 'Trasporto');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', 'VAR/Integratore di sistemi');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', 'Commercio all\'ingrosso/Distribuzione');


define('REQUEST_DEMO_COMPANY', 'Azienda');
define('REQUEST_DEMO_COMPANY_SIZE', 'Dimensione dell\'azienda');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', 'da 1 a 99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', 'da 100 a 999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', 'da 1,000 a 1,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', 'da 2,000 a 3,999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', '4,000+');

define('REQUEST_DEMO_COMMENT_OPTIONAL', 'Commenti (opzionale) :');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', 'Non trovi quello che vuoi? Prova a postare i tuoi problemi.');

define('REQUEST_DEMO_SEARCH_RESULT', 'Non c\'è nessun risultato per "#KEYWORD#", Si prega di controllare la tua l\'ortografia di nuovo.');
define('REQUEST_DEMO_HOT_SEARCH', 'Ricerca più popolare:');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', 'Si prega di programmare un orario');

define('REQUEST_DEMO_TIP_01', 'Prova gli Switch FS');
define('REQUEST_DEMO_TIP_02', 'Il nostro servizio di test remoto consente agli utenti di visualizzare l\'implementazione e la connessione degli switch nel nostro laboratorio e sperimentare il funzionamento in remoto.');
define('REQUEST_DEMO_TIP_03', 'Cosa può fare per me la dimostrazione di FS:');
define('REQUEST_DEMO_TIP_04', 'Esperienza di 100+ funzioni');
define('REQUEST_DEMO_TIP_05', 'Test di prestazione');
define('REQUEST_DEMO_TIP_06', 'Compatibilità degli switch di marca');
define('REQUEST_DEMO_TIP_07', 'Scenari di applicazione standard');
define('REQUEST_DEMO_TIP_08', 'Soluzioni personalizzate');
define('REQUEST_DEMO_TIP_09', 'Che cosa mi posso aspettare?');
define('REQUEST_DEMO_TIP_10', 'Le simulazione di scenari utente, le sensazione di funzionamento sul posto');
define('REQUEST_DEMO_TIP_11', 'Nessun ritardo, nessun schermo gelido');
define('REQUEST_DEMO_TIP_12', '1 minuto di accesso, 30 minuti di esperienza');
define('REQUEST_DEMO_TIP_13', 'Supporto online di un ingegnere tecnico uno per uno');

define('REQUEST_DEMO_FORM_01', 'A quale switch sei interessato?');
define('REQUEST_DEMO_FORM_02', 'Quali funzioni vorresti provare?');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'La tua richiesta #NUMBER# è stata inviata con successo.');
define('REQUEST_DEMO_SUCCESS_TIP_02', 'Ti contatteremo entro 24 ore.');

define('REQUEST_DEMO_SEARCH_DEFAULT_ARRAY', json_encode(array(
    array('id' => 1, 'txt' => 'VLAN'),
    array('id' => 2, 'txt' => 'QINQ'),
    array('id' => 3, 'txt' => 'LACP'),
    array('id' => 4, 'txt' => 'Routing statico'),
    array('id' => 5, 'txt' => 'RIP'),
    array('id' => 6, 'txt' => 'RIPng'),
    array('id' => 7, 'txt' => 'OSPFv2'),
    array('id' => 8, 'txt' => 'OSPFv3'),
    array('id' => 9, 'txt' => 'BGP4'),
    array('id' => 10, 'txt' => 'SNMP'),
    array('id' => 11, 'txt' => 'Web'),
    array('id' => 12, 'txt' => 'sFlusso'),
    array('id' => 13, 'txt' => 'SSH'),
    array('id' => 14, 'txt' => 'DHCP Snooping'),
    array('id' => 15, 'txt' => 'DHCP Server'),
    array('id' => 16, 'txt' => 'DHCP Cliente'),
    array('id' => 17, 'txt' => 'DHCP Relay'),
    array('id' => 18, 'txt' => 'NTP'),
    array('id' => 19, 'txt' => 'Impilamento')
)));
define('REQUEST_DEMO_SEARCH_OTHERS_ARRAY', json_encode(array(
    array('id' => 20, 'txt' => 'controllo di flusso'),
    array('id' => 21, 'txt' => 'STP'),
    array('id' => 22, 'txt' => 'RSTP'),
    array('id' => 23, 'txt' => 'MSTP'),
    array('id' => 24, 'txt' => 'Soppressione della tempesta'),
    array('id' => 25, 'txt' => 'Specchio'),
    array('id' => 26, 'txt' => 'Indirizzi MAC statici'),
    array('id' => 27, 'txt' => 'RLDP'),
    array('id' => 28, 'txt' => 'lldp'),
    array('id' => 29, 'txt' => 'Galleria del protocollo a livello 2'),
    array('id' => 30, 'txt' => 'REUP'),
    array('id' => 31, 'txt' => 'G.8032'),
    array('id' => 32, 'txt' => 'VCT'),
    array('id' => 33, 'txt' => 'igmp-snooping'),
    array('id' => 34, 'txt' => 'MLD snooping'),
    array('id' => 35, 'txt' => 'ipv4 vrf'),
    array('id' => 36, 'txt' => 'ipv6'),
    array('id' => 37, 'txt' => 'IGMP'),
    array('id' => 38, 'txt' => 'PIM-DM'),
    array('id' => 39, 'txt' => 'PIM-SM'),
    array('id' => 40, 'txt' => 'PIM-SSM'),
    array('id' => 41, 'txt' => 'RIPng'),
    array('id' => 42, 'txt' => 'ospfv3'),
    array('id' => 43, 'txt' => 'BGP4+'),
    array('id' => 44, 'txt' => 'ACL'),
    array('id' => 45, 'txt' => 'QoS'),
    array('id' => 46, 'txt' => 'Tacacs+'),
    array('id' => 47, 'txt' => '802.1x'),
    array('id' => 48, 'txt' => 'sicurezza della porta'),
    array('id' => 49, 'txt' => 'DAI'),
    array('id' => 50, 'txt' => 'ip source guard'),
    array('id' => 51, 'txt' => 'TFTP'),
    array('id' => 52, 'txt' => 'FTP'),
    array('id' => 53, 'txt' => 'SNTP'),
    array('id' => 54, 'txt' => 'VRRP')
)));

define('REQUEST_DEMO_FORM_TIP_01', 'Si prega di selezionare l\'industria.');
define('REQUEST_DEMO_FORM_TIP_02', 'Si prega di inserire il nome della tua azienda.');
define('REQUEST_DEMO_FORM_TIP_03', 'Si prega di selezionare la dimensione della tua azienda.');
define('REQUEST_DEMO_FORM_TIP_04', 'Si prega di selezionare uno switch.');
define('REQUEST_DEMO_FORM_TIP_05', 'Si prega di selezionare almeno una funzione.');
define('REQUEST_DEMO_FORM_TIP_06', 'Si prega di selezionare l\'ora.');

define('REQUEST_DEMO_EMAIL_01','FS - Abbiamo ricevuto la tua richiesta dimostrazione ');
define('REQUEST_DEMO_EMAIL_02','Abbiamo ricevuto la tua richiesta dimostrazione <a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a>, puoi fare riferimento a questo numero in tutte le comunicazioni successive.');
define('REQUEST_DEMO_EMAIL_03','Di seguito sono le informazioni di test:');
define('REQUEST_DEMO_EMAIL_04','Modello di Switch: ');
define('REQUEST_DEMO_EMAIL_05','Funzioni interessate: ');
define('REQUEST_DEMO_EMAIL_06','Orario previsto: ');
define('REQUEST_DEMO_EMAIL_07','Si prega di preparati bene con <a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a>prima di iniziare la tua test dimostrazione, il nostro gruppo in contatto con te al più presto.');
define('REQUEST_DEMO_EMAIL_08','la tua TeamViewer <b>ID del partner (FS) è 658526138</b>, la password ti sarà inviata 15 minuti prima dell\'orario previsto.');

define('REQUEST_DEMO_SEARCH','Ricerca');