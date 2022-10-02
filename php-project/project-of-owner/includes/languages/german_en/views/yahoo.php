<?php
/**
 * yahoo.php
 *
 * @package yahoo product submit
 * @copyright Copyright 2007 Numinix Technology http://www.numinix.com
 * @copyright Portions Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: yahoo.php,v 1.00 12.09.2007 16:54:59 numinix $
 */
 
define('TEXT_YAHOO_STARTED', 'Yahoo! Product Submit Feeder v.' . YAHOO_VERSION . ' started ' . date("Y/m/d H:i:s"));
define('TEXT_YAHOO_FILE_LOCATION', 'Feed file - ');
define('TEXT_YAHOO_FEED_COMPLETE', 'Yahoo! File Complete');
define('TEXT_YAHOO_FEED_TIMER', 'Time:');
define('TEXT_YAHOO_FEED_SECONDS', 'Seconds');
define('TEXT_YAHOO_FEED_RECORDS', ' Records');
define('YAHOO_TIME_TAKEN', 'In');
define('YAHOO_VIEW_FILE', 'View File:');
define('ERROR_YAHOO_DIRECTORY_NOT_WRITEABLE', 'Your Yahoo! folder is not writeable! Please chmod the /' . YAHOO_DIRECTORY . ' folder to 755 or 777 depending on your host.');
define('ERROR_YAHOO_DIRECTORY_DOES_NOT_EXIST', 'Your Yahoo! output directory does not exist! Please create an /' . YAHOO_DIRECTORY . ' directory and chmod to 755 or 777 depending on your host.');
define('ERROR_YAHOO_OPEN_FILE', 'Error opening Yahoo! output file "' . DIR_FS_CATALOG . YAHOO_DIRECTORY . YAHOO_OUTPUT_FILENAME . '"');
define('TEXT_YAHOO_UPLOAD_STARTED', 'Upload started...');
define('TEXT_YAHOO_UPLOAD_FAILED', 'Upload failed...');
define('TEXT_YAHOO_UPLOAD_OK', 'Upload ok!');
define('TEXT_YAHOO_ERRSETUP', 'Yahoo! error setup:');
define('TEXT_YAHOO_ERRSETUP_L', 'Yahoo! Feed Language "%s" not defined in zen-cart store.');
define('TEXT_YAHOO_ERRSETUP_C', 'Yahoo! Default Currency "%s" not defined in zen-cart store.');

define('FTP_FAILED', 'Your hosting does not support ftp functions.');
define('FTP_CONNECTION_FAILED', 'Connection failed:');
define('FTP_CONNECTION_OK', 'Connected to:');
define('FTP_LOGIN_FAILED', 'Login failed:');
define('FTP_LOGIN_OK', 'Login ok:');
define('FTP_CURRENT_DIRECTORY', 'Current Directory Is:');
define('FTP_CANT_CHANGE_DIRECTORY', 'Can not change directory on:');
define('FTP_UPLOAD_FAILED', 'Upload Failed');
define('FTP_UPLOAD_SUCCESS', 'Uploaded Successfully');
define('FTP_SERVER_NAME', ' Server Name: ');
define('FTP_USERNAME', ' Username: ');
define('FTP_PASSWORD', ' Password: ');
?>