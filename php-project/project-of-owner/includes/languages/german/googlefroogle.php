<?php
/**
 * googlefroogle.php
 *
 * @package google froogle
 * @copyright Copyright 2007 Numinix Technology http://www.numinix.com
 * @copyright Portions Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: googlefroogle.php 44 2010-11-18 23:41:43Z numinix $
 */
 
define('TEXT_GOOGLE_FROOGLE_STARTED', 'Google Händler Zentrum Feeder v%s begann ' . date("Y/m/d H:i:s"));
define('TEXT_GOOGLE_FROOGLE_FILE_LOCATION', 'Feed Datei - ');
define('TEXT_GOOGLE_FROOGLE_FEED_COMPLETE', 'Google Zentrum der Händler Daten beenden');
define('TEXT_GOOGLE_FROOGLE_FEED_TIMER', 'Zeit:');
define('TEXT_GOOGLE_FROOGLE_FEED_SECONDS', 'Sekunde');
define('TEXT_GOOGLE_FROOGLE_FEED_RECORDS', ' Rekorde');
define('GOOGLE_FROOGLE_TIME_TAKEN', 'In');
define('GOOGLE_FROOGLE_VIEW_FILE', 'Datei sehen:');
define('ERROR_GOOGLE_FROOGLE_DIRECTORY_NOT_WRITEABLE', 'Ihr Google Zentrum der Händler Ordner ist schreibgeschützt! Bitte chmod den /' . GOOGLE_FROOGLE_DIRECTORY . ' Ordner zu 755 oder 777 auf dem Grund von Ihrem Host.');
define('ERROR_GOOGLE_FROOGLE_DIRECTORY_DOES_NOT_EXIST', 'Ihr Google Zentrum der Händler Ausgabeverzeichnis existiert nicht! Bitte errichten Sie ein /' . GOOGLE_FROOGLE_DIRECTORY . ' Verzeichnis und chmod zu 755 oder 777 auf dem Grund von Ihrem Host.');
define('ERROR_GOOGLE_FROOGLE_OPEN_FILE', 'Fehler machen Google Händler Zentrum Ausgabedatei auf"' . DIR_FS_CATALOG . GOOGLE_FROOGLE_DIRECTORY . GOOGLE_FROOGLE_OUTPUT_FILENAME . '"');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_STARTED', 'Hochladen begann...');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_FAILED', 'Hochladen misslungen...');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_OK', 'Hochladen ok!');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP', 'Google Zentrum der Händler Fehler Aufstellung:');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP_L', 'Google Zentrum der Händler Feed Sprache "%s" nicht festgestellt im online Laden.');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP_C', 'Google Zentrum der Händler Stammwährung "%s" nicht festgestellt im online Laden.');

define('FTP_FAILED', 'Ihr Host unterstützt ftp Funktionen nicht.');
define('FTP_CONNECTION_FAILED', 'Misslungene Verbindung:');
define('FTP_CONNECTION_OK', 'Verbunden zu:');
define('FTP_LOGIN_FAILED', 'Misslungenes Einloggen:');
define('FTP_LOGIN_OK', 'Erfolgreiches Einloggen:');
define('FTP_CURRENT_DIRECTORY', 'Gegenwärtiges Verzeichnis ist:');
define('FTP_CANT_CHANGE_DIRECTORY', 'Das Verzeichnis kann nicht ändern auf:');
define('FTP_UPLOAD_FAILED', 'Misslungenes Hochladen');
define('FTP_UPLOAD_SUCCESS', 'Erfolgreiches Hochladen');
define('FTP_SERVER_NAME', 'Name des Servers: ');
define('FTP_USERNAME', ' Benutzername: ');
define('FTP_PASSWORD', ' Passwort: ');
//eof