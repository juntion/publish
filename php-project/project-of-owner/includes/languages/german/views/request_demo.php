<?php
define('REQUEST_DEMO_BANNER_TITLE', 'Demonstration der Netzwerk-Switches');

define('REQUEST_DEMO_ALREADY_HAVE_AN_ACCOUNT','Haben Sie schon ein Konto bei FS? Sie können sich <a href="'.zen_href_link(FILENAME_LOGIN,'','SSL').'">anmelden</a> oder ein <a href="'.zen_href_link(FILENAME_REGIST,'','SSL').'">Konto eröffnen</a>.');

define('REQUEST_DEMO_INDUSTRY', 'Branche');
define('REQUEST_DEMO_OPTION_DEFAULT', 'Auswählen');
define('REQUEST_DEMO_INDUSTRY_OPTION_1', 'Kunst / Erholung');
define('REQUEST_DEMO_INDUSTRY_OPTION_2', 'Bildung - Hochschulbildung');
define('REQUEST_DEMO_INDUSTRY_OPTION_3', 'Bildung - Primar- und Sekundarbildung');
define('REQUEST_DEMO_INDUSTRY_OPTION_4', 'Bildung - Andere');
define('REQUEST_DEMO_INDUSTRY_OPTION_5', 'Energie / Versorgung');
define('REQUEST_DEMO_INDUSTRY_OPTION_6', 'Finanzdienstleistungen');
define('REQUEST_DEMO_INDUSTRY_OPTION_7', 'Regierung');
define('REQUEST_DEMO_INDUSTRY_OPTION_8', 'Gesundheit');
define('REQUEST_DEMO_INDUSTRY_OPTION_9', 'Hightech - Soft / Hardware');
define('REQUEST_DEMO_INDUSTRY_OPTION_10', 'Gastgewerbe / Hotels / Freizeitbranche');
define('REQUEST_DEMO_INDUSTRY_OPTION_11', 'Bibliothek');
define('REQUEST_DEMO_INDUSTRY_OPTION_12', 'Fertigung');
define('REQUEST_DEMO_INDUSTRY_OPTION_13', 'Medien / Unterhaltung');
define('REQUEST_DEMO_INDUSTRY_OPTION_14', 'Gemeinnützige Mitgliederorganisation');
define('REQUEST_DEMO_INDUSTRY_OPTION_15', 'Andere');
define('REQUEST_DEMO_INDUSTRY_OPTION_16', 'Fachdienstleistungen');
define('REQUEST_DEMO_INDUSTRY_OPTION_17', 'Einzelhandel / Restaurant');
define('REQUEST_DEMO_INDUSTRY_OPTION_18', 'Internetanbieter');
define('REQUEST_DEMO_INDUSTRY_OPTION_19', 'Transport');
define('REQUEST_DEMO_INDUSTRY_OPTION_20', 'VAR / Systemintegration');
define('REQUEST_DEMO_INDUSTRY_OPTION_21', 'Großhandel / Vertrieb');


define('REQUEST_DEMO_COMPANY', 'Firma/Institution/Organisation');
define('REQUEST_DEMO_COMPANY_SIZE', 'Betriebsgröße');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_01', '1 bis 99');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_02', '100 bis 999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_03', '1.000 bis 1.999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_04', '2.000 bis 3.999');
define('REQUEST_DEMO_COMPANY_SIZE_TIP_05', 'Mehr als 4.000');

define('REQUEST_DEMO_COMMENT_OPTIONAL', 'Anmerkung (optional):');
define('REQUEST_DEMO_COMMENT_OPTIONAL_PLACEHOLDER', 'Nichts Benötigtes gefunden? Hinterlassen Sie Ihre Probleme.');

define('REQUEST_DEMO_SEARCH_RESULT', 'Keine Ergebnisse für „#KEYWORD#“. Überprüfen Sie bitte Ihre Eingabe.');
define('REQUEST_DEMO_HOT_SEARCH', 'Angesagte Suchbegriffe:');
define('REQUEST_DEMO_HOT_SCHEDULE_TIME', 'Zeit wählen');

define('REQUEST_DEMO_TIP_01', 'Demonstration anfragen');
define('REQUEST_DEMO_TIP_02', 'Mithilfe unserem Remote-Service können Sie entfernt die Bereitstellung, den Anschluss und den Betrieb der Switches in unserem Labor realisieren.');
define('REQUEST_DEMO_TIP_03', 'Was ist in der Demo von FS enthalten?');
define('REQUEST_DEMO_TIP_04', 'Vorführung von mehr als 100 Funktionen');
define('REQUEST_DEMO_TIP_05', 'Leistungstests');
define('REQUEST_DEMO_TIP_06', 'Kompatibilität mit Switches großer Marken');
define('REQUEST_DEMO_TIP_07', 'Anwendung in Standardszenarien');
define('REQUEST_DEMO_TIP_08', 'Maßgeschneiderte Lösungen');
define('REQUEST_DEMO_TIP_09', 'Vorteile der Produkt-Demo von FS:');
define('REQUEST_DEMO_TIP_10', 'Simulation verschiedener Szenarien für authentische Erfahrung');
define('REQUEST_DEMO_TIP_11', 'Keine Verzögerung, kein Einfrieren');
define('REQUEST_DEMO_TIP_12', '30 Minuten Demo mit nur 1 Minute Vorbereitung');
define('REQUEST_DEMO_TIP_13', 'Individueller Tech-Support');

define('REQUEST_DEMO_FORM_01', 'Switch wählen');
define('REQUEST_DEMO_FORM_02', 'Funktionen, die Sie ausprobieren möchten');

define('REQUEST_DEMO_SUCCESS_TIP_01', 'Ihre Anfrage #NUMBER# wurde erfolgreich eingereicht.');
define('REQUEST_DEMO_SUCCESS_TIP_02', 'Wir werden Sie innerhalb von 24 Stunden kontaktieren.');

define('REQUEST_DEMO_SEARCH_DEFAULT_ARRAY', json_encode(array(
    array('id' => 1, 'txt' => 'VLAN'),
    array('id' => 2, 'txt' => 'QINQ'),
    array('id' => 3, 'txt' => 'LACP'),
    array('id' => 4, 'txt' => 'Statisches Routing'),
    array('id' => 5, 'txt' => 'RIP'),
    array('id' => 6, 'txt' => 'RIPng'),
    array('id' => 7, 'txt' => 'OSPFv2'),
    array('id' => 8, 'txt' => 'OSPFv3'),
    array('id' => 9, 'txt' => 'BGP4'),
    array('id' => 10, 'txt' => 'SNMP'),
    array('id' => 11, 'txt' => 'Web'),
    array('id' => 12, 'txt' => 'sFlow'),
    array('id' => 13, 'txt' => 'SSH'),
    array('id' => 14, 'txt' => 'DHCP-Snooping'),
    array('id' => 15, 'txt' => 'DHCP-Server'),
    array('id' => 16, 'txt' => 'DHCP-Client'),
    array('id' => 17, 'txt' => 'DHCP-Relay'),
    array('id' => 18, 'txt' => 'NTP'),
    array('id' => 19, 'txt' => 'Stacking')
)));
define('REQUEST_DEMO_SEARCH_OTHERS_ARRAY', json_encode(array(
    array('id' => 20, 'txt' => 'Flow-Control'),
    array('id' => 21, 'txt' => 'STP'),
    array('id' => 22, 'txt' => 'RSTP'),
    array('id' => 23, 'txt' => 'MSTP'),
    array('id' => 24, 'txt' => 'Storm Suppression'),
    array('id' => 25, 'txt' => 'Mirror'),
    array('id' => 26, 'txt' => 'Statische MAC-Adressen'),
    array('id' => 27, 'txt' => 'RLDP'),
    array('id' => 28, 'txt' => 'LLDP'),
    array('id' => 29, 'txt' => 'Layer 2 Protokoll Tunnel'),
    array('id' => 30, 'txt' => 'REUP'),
    array('id' => 31, 'txt' => 'G.8032'),
    array('id' => 32, 'txt' => 'VCT'),
    array('id' => 33, 'txt' => 'IGMP-Snooping'),
    array('id' => 34, 'txt' => 'MLD-Snooping'),
    array('id' => 35, 'txt' => 'IPV4 VRF'),
    array('id' => 36, 'txt' => 'IPV6'),
    array('id' => 37, 'txt' => 'IGMP'),
    array('id' => 38, 'txt' => 'PIM-DM'),
    array('id' => 39, 'txt' => 'PIM-SM'),
    array('id' => 40, 'txt' => 'PIM-SSM'),
    array('id' => 41, 'txt' => 'RIPng'),
    array('id' => 42, 'txt' => 'OSPFv3'),
    array('id' => 43, 'txt' => 'BGP4+'),
    array('id' => 44, 'txt' => 'ACL'),
    array('id' => 45, 'txt' => 'QoS'),
    array('id' => 46, 'txt' => 'Tacacs+'),
    array('id' => 47, 'txt' => '802.1x'),
    array('id' => 48, 'txt' => 'Anschlusssicherheit'),
    array('id' => 49, 'txt' => 'DAI'),
    array('id' => 50, 'txt' => 'IP Source Guard'),
    array('id' => 51, 'txt' => 'TFTP'),
    array('id' => 52, 'txt' => 'FTP'),
    array('id' => 53, 'txt' => 'SNTP'),
    array('id' => 54, 'txt' => 'VRRP')
)));

define('REQUEST_DEMO_FORM_TIP_01', 'Dies ist ein Pflichtfeld.');
define('REQUEST_DEMO_FORM_TIP_02', 'Dies ist ein Pflichtfeld.');
define('REQUEST_DEMO_FORM_TIP_03', 'Dies ist ein Pflichtfeld.');
define('REQUEST_DEMO_FORM_TIP_04', 'Dies ist ein Pflichtfeld.');
define('REQUEST_DEMO_FORM_TIP_05', 'Dies ist ein Pflichtfeld.');
define('REQUEST_DEMO_FORM_TIP_06', 'Dies ist ein Pflichtfeld.');

define('REQUEST_DEMO_EMAIL_01','FS - Anfrage der Produkt-Demonstration ');
define('REQUEST_DEMO_EMAIL_02','Wir haben Ihre Anfrage <a style="color: #0070bc;text-decoration: none" target="_blank" href="#HREF#">#NUMBER#</a> erhalten. Mit dieser Anfragenummer können Sie alle zusätzliche Anmerkungen oder Fragen finden.');
define('REQUEST_DEMO_EMAIL_03','Anfragedetails:');
define('REQUEST_DEMO_EMAIL_04','Switch-Modell: ');
define('REQUEST_DEMO_EMAIL_05','Ausgewählte Funktionen: ');
define('REQUEST_DEMO_EMAIL_06','Ausgewählte Zeit: ');
define('REQUEST_DEMO_EMAIL_07','Bitte bereiten Sie sich vor der Demonstration mit dem <a style="color: #0070bc;text-decoration: none" target="_blank" href="https://www.teamviewer.com/download/windows/">TeamViewer</a> vor. Wir werden uns bald bei Ihnen melden.');
define('REQUEST_DEMO_EMAIL_08','Ihre TeamViewer <b>Partner(FS)-ID lautet 658526138</b>. Das Passwort wird Ihnen 15 Minuten vor Ihrer geplanten Zeit gesendet.');

define('REQUEST_DEMO_SEARCH','Suchen');