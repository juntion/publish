<?php
/** 
 * Music product Type - Database Name Defines
 *
 * @package classes
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: music_type_database_names.php 5916 2007-02-26 05:28:02Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * Database name defines
 *
 */
define('TABLE_MUSIC_GENRE', DB_PREFIX . 'music_genre');
define('TABLE_MUSIC_GENRE_INFO', DB_PREFIX . 'music_genre_info');
define('TABLE_MEDIA_MANAGER', DB_PREFIX . 'media_manager');
define('TABLE_MEDIA_TYPES', DB_PREFIX . 'media_types');
define('TABLE_MEDIA_CLIPS', DB_PREFIX . 'media_clips');
define('TABLE_MEDIA_TO_PRODUCTS', DB_PREFIX . 'media_to_products');
?>