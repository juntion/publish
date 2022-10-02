<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 10330 2008-10-10 20:14:32Z drbyte $
 */

// page title
define('TITLE', 'FS.COM');

// Site Tagline
define('SITE_TAGLINE', '');

// Custom Keywords
define('CUSTOM_KEYWORDS', 'Transceivers, Patchkabel, Adapter, Dämpfungsglied ,FiberStore, online einkaufen');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'FiberStore-Einkaufen für LWL-Transceiver ,Mux / Demux , LWL-Medienkonverter, Video Multiplexer, LWL-Patch Kordel ,LWL-Patch Panel , LWL-Kabel Verbinder und andere LWL Netzwerk Accessoires');
  define('HOME_PAGE_META_KEYWORDS', 'LWL-Kommunikation, LWL-Netzwerk, LWL-Produkte');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', 'FiberStore - Faser Netzwerk Lösungen, Alles im FiberStore! '); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it.
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_page_name','');
  define('META_TAG_TITLE_page_name', '');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'Kommentare: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','Einloggen, Ausloggen, Konto anlegen, Konto, Konto bearbeiten, Kontohistorie, Information der Kontohistorie, Konto_Newsletters, Konto_Benachrichtigungen, Konto_Passwort, Adressebuch, advanced_Suchen, advanced_Suchen_Ergebnis, Abmelden_Erfolgreich, Abmelden_verlauf, Abmelden_Lieferung, Abmelden_Zahlung, Abmelden_Bestätigung, cookie_Anwendung, Konto erfolgreich errichten, Kontakt mit uns, Herunterladen, Zeit für Herunterladen ist um, Kunden_Autorisierung, Zugemacht für Instandhaltung, Passwort_vergegessen, Zeit ist um, abbestellen, info_Einkaufswagen, pop-up_Bild, pop-up_Bild_zusätzlich, Produkt_Kommentare_verfassen, ssl_prüfen');


// favicon setting
// There is usually NO need to enable this unless you need to specify a path and/or a different filename
//  define('FAVICON','favicon.ico');
define('META_WDM01','WDM Integrierte optische Transportplattform');
define('META_WDM02','Mit der FS WDM Transport Platform können Unternehmen, ISP und Dienstleister die Geschwindigkeit und Kapazität optischer Netzwerke kosteneffizient ausbauen oder verbessern.');
define('META_WDM03','Langstreckenübertragung, Netzwerk-Management-System, Optisches Transportnetzwerk');


//dylan 2019.8.5 Add
define('METE_TAGS_CAT_BUY','Kaufen Sie ');
define('METE_TAGS_CAT_BEST_PRICE',' online, wählen best ');
define('META_TAGS_CATEGORIES_DESCRIPTION',' bei FS.COM.');

/*narrow*/
define('METE_TAGS_NARROW_FS',', FS.com durchsuchen');
define('METE_TAGS_NARROW_ONLINE_GLOBAL',' Online von Global ');
define('METE_TAGS_NARROW_OEM_MANUFACTURER',' OEM-Hersteller mit Großhandelspreis bei FS.com');
define('METE_TAGS_NARROW_OEM',' OEM-Hersteller. Kaufen und individualisieren Sie faseroptische Produkte von FS.com!');

/*support*/
define('METE_TAGS_SUPPORT_OF_FS','Unterstützung von FS.com');

define('METE_TAGS_POPULAR','Beliebt -FS.com');
define('METE_TAGS_PRODUCTS_LIST','Produktliste ');
define('METE_TAGS_FIBER_OPTIC_PRODUCTS_LIST',' Liste der Glasfaserprodukte ');
define('META_TAGS_FIBERSTORE',' -FS.com');
define('META_TAGS_THE_LEADING','Die führenden OEM-Hersteller für Glasfaserprodukte. Auf dieser Seite können Sie leicht alle Fiberstore-Produkte finden, die das Wort enthalten, das durch den Buchstaben eingeleitet wurde ');
define('META_TAGS_CUSTOMER_SERVICE','Kundendienst');
define('META_TAGS_TUTORIAL_OF_COM','Tutorial von FS.com');
define('META_TAGS_NEWS_OF_COM','Nachrichten von FS.com');

define('META_TAGS_COMMON_TITLE','Rechenzentrum, Unternehmen, Telekommunikation');
define('META_TAGS_COMMON_DESCRIPTION','FS ist eine neue Marke für Data Center, Enterprise, Telekommunikation Solutions. Wir machen es IT-Experten einfach und kostengünstig, ihre Geschäftslösungen zu ermöglichen.');

//solutions页面meta相关
define('FS_SOLUTION_META_TITLE_O1','FS OTN-Lösung für 10G DWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O1','FS bietet eine kostengünstige, einfach zu verwaltende integrierte 10G DWDM-Lösung für DCI- (Data Center Interconnect) und Unternehmensanwendungen.');
define('FS_SOLUTION_META_TITLE_O2','FS OTN-Lösung für 10G DWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O2','FS bietet eine kostengünstige, einfach zu verwaltende integrierte 10G DWDM-Lösung für DCI- (Data Center Interconnect) und Unternehmensanwendungen.');
define('FS_SOLUTION_META_TITLE_O3','FS OTN-Lösung für 25G DWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O3','FS bietet eine 25G DWDM-Lösung mit einfacher Skalierbarkeit und intelligenter Verwaltung für die Verbindung bei 25G Ethernet, 5G Fronthaul und Rechenzentren.');
define('FS_SOLUTION_META_TITLE_O4','FS OTN-Lösung für 25G DWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O4','FS bietet eine 25G DWDM-Lösung mit einfacher Skalierbarkeit und intelligenter Verwaltung für die Verbindung bei 25G Ethernet, 5G Fronthaul und Rechenzentren.');
define('FS_SOLUTION_META_TITLE_O5','FS OTN-Lösung für 10G CWDM Doppelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O5','FS bietet eine kostengünstige 10G CWDM-Lösung mit großer Kapazität für Kurzstrecken-Übertragungsnetze in Großstädten.');
define('FS_SOLUTION_META_TITLE_O6','FS OTN-Lösung für 10G CWDM Einzelfaser-Netzwerk');
define('FS_SOLUTION_META_DESCRIPTION_O6','FS bietet eine kostengünstige 10G CWDM-Lösung mit großer Kapazität für Kurzstrecken-Übertragungsnetze in Großstädten.');
