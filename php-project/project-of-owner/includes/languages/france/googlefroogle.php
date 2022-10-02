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
 
define('TEXT_GOOGLE_FROOGLE_STARTED', 'Google Merchant Centre Feeder v%s commencé ' . date("Y/m/d H:i:s"));
define('TEXT_GOOGLE_FROOGLE_FILE_LOCATION', 'Feed Fichier - ');
define('TEXT_GOOGLE_FROOGLE_FEED_COMPLETE', 'Fichier Complet de Google Merchant Centre');
define('TEXT_GOOGLE_FROOGLE_FEED_TIMER', 'Temps:');
define('TEXT_GOOGLE_FROOGLE_FEED_SECONDS', 'Secondes');
define('TEXT_GOOGLE_FROOGLE_FEED_RECORDS', ' Records');
define('GOOGLE_FROOGLE_TIME_TAKEN', 'Dans');
define('GOOGLE_FROOGLE_VIEW_FILE', 'Voir la Fiche:');
define('ERROR_GOOGLE_FROOGLE_DIRECTORY_NOT_WRITEABLE', 'Votre dossier de Google Merchant Centre n\'est pas accessible en écriture! Chmod le /' . GOOGLE_FROOGLE_DIRECTORY . ' dossier à 755 ou 777 en fonction de votre hôte.');
define('ERROR_GOOGLE_FROOGLE_DIRECTORY_DOES_NOT_EXIST', 'Votre répertoire de sortie de Google Merchant Centre n\'existe pas! Créez un /' . GOOGLE_FROOGLE_DIRECTORY . ' répertoire et chmod à 755 ou 777 en fonction de votre hôte.');
define('ERROR_GOOGLE_FROOGLE_OPEN_FILE', 'Erreur d\'ouverture du fichier de sortie de Google Merchant Centre "' . DIR_FS_CATALOG . GOOGLE_FROOGLE_DIRECTORY . GOOGLE_FROOGLE_OUTPUT_FILENAME . '"');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_STARTED', 'Téléchargement commencé...');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_FAILED', 'Téléchargement échoué...');
define('TEXT_GOOGLE_FROOGLE_UPLOAD_OK', 'Téléchargement ok!');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP', 'Istallation d\'erreur de Google Merchant Centre:');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP_L', 'La langue "%s" de Google Merchant Centre n\'est pas définie dans le magasin de zen-cart.');
define('TEXT_GOOGLE_FROOGLE_ERRSETUP_C', 'La monnaie par défaut "%s" de Google Merchant Centre pas définie dans le magasin de zen-cart.');

define('FTP_FAILED', 'Votre hôte ne supporte pas les fonctions de ftp.');
define('FTP_CONNECTION_FAILED', 'Connexion échouée:');
define('FTP_CONNECTION_OK', 'Connecté à:');
define('FTP_LOGIN_FAILED', 'Connexion échouée:');
define('FTP_LOGIN_OK', 'Connexion ok:');
define('FTP_CURRENT_DIRECTORY', 'Répertoire actuel est:');
define('FTP_CANT_CHANGE_DIRECTORY', 'Vous ne pouvez pas changer le répertoire sur:');
define('FTP_UPLOAD_FAILED', 'Téléchargement Échoué');
define('FTP_UPLOAD_SUCCESS', 'Téléchargement avec Succès');
define('FTP_SERVER_NAME', ' Nom de Serveur: ');
define('FTP_USERNAME', ' Nom d\'utilisateur: ');
define('FTP_PASSWORD', ' Mot de passe: ');
//eof