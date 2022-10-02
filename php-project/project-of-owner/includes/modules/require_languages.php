<?php
/**
 * loads template specific language override files
 *
 * @package initSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: require_languages.php 4274 2006-08-26 03:16:53Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//echo "I AM LOADING: " . DIR_WS_LANGUAGES . $template_dir_select . $_SESSION['language'] . '.php' . '<br />';
//require(DIR_WS_LANGUAGES . $template_dir_select . $_SESSION['language'] . '.php');
//if (!zen_not_null($template_dir_select)) require(DIR_WS_LANGUAGES . $_SESSION['language'] . '.php');

// determine language or template language file
//查找includes/languages/english/fiberstore/ 文件夹下面是否有当前页面的额外视图文件    $current_page_base获取的是当前页面的原模板文件名

if (file_exists($language_page_directory . $template_dir . '/' . $current_page_base . '.php')) {
  $template_dir_select = $template_dir . '/';       //如果文件存在，则$template_dir_select = "fiberstore/"
} else {
  $template_dir_select = '';
}

// set language or template language file     获取/includes/languages/english语言包下的所有和当前页面的原模板名相同的文件
$directory_array = $template->get_template_part($language_page_directory . $template_dir_select, '/^'.$current_page_base . '/');
$directory_array1 = $template->get_template_part($language_page_directory.'views', '/^'.$current_page_base . '/');
while(list ($key, $value) = each($directory_array)) {
  //echo "I AM LOADING: " . $language_page_directory . $template_dir_select . $value . '<br />';
  require_once($language_page_directory . $template_dir_select . $value);       //如果includes/languages/english/fiberstore/ 下有当前页面的视图文件，则一一加载
}
while(list ($key, $value) = each($directory_array1)) {
  //echo "I AM LOADING: " . $language_page_directory . $template_dir_select . $value . '<br />';
  require_once($language_page_directory.'views/'.$template_dir_select.$value);       //如果includes/languages/english/fiberstore/ 下有当前页面的视图文件，则一一加载
}
// load master language file(s) if lang files loaded previously were "overrides" and not masters.
if ($template_dir_select != '') {
  $directory_array = $template->get_template_part($language_page_directory, '/^'.$current_page_base . '/');
  
  while(list ($key, $value) = each($directory_array)) {
    //echo "I AM LOADING MASTER: " . $language_page_directory . $value.'<br />';
    require_once($language_page_directory . $value);        //加载当前页面的所有语言包
  }

} 

// 首页优化。init_templates文件夹下面有，加载公共的语言包。这里不需要
// fairy 2019.6.19 add
//$public_files = getDir($language_page_directory.'public');
//while(list ($key, $value) = each($public_files)){
//    //echo "I AM LOADING MASTER: " .$value.'<br />';
//    require_once($value);        //加载当前页面的所有语言包
//}

?>