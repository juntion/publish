<?php 
/**
 * left slide bar for account pages
 * session name email ..................by tom
 */

require_once DIR_WS_CLASSES .'set_cookie.php';
$Encryption = new Encryption;
if (isset($_COOKIE['fs_login_cookie'])){
	$cookie_customer_decrypt = $Encryption->_decrypt($_COOKIE['fs_login_cookie']);
}else $cookie_customer_decrypt = $_SESSION['customer_id'];


$check_customer_query = "SELECT customers_id, customers_firstname, customers_lastname, customers_password,
                                    customers_email_address, customers_default_address_id,
                                    customers_authorization, customers_referral
                           FROM " . TABLE_CUSTOMERS . "
                           WHERE customers_id = :customers_id";

$check_customer_query  =$db->bindVars($check_customer_query, ':customers_id', $cookie_customer_decrypt, 'integer');
$check_customer = $db->Execute($check_customer_query);

$_SESSION['customer_id'] = $check_customer->fields['customers_id'];
$_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
$_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
$_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
$_SESSION['customer_last_name'] = $check_customer->fields['customers_lastname'];
$_SESSION['customers_email_address'] = $check_customer->fields['customers_email_address'];
$_SESSION['name'] = ucfirst($check_customer->fields['customers_firstname'])." ".ucfirst($check_customer->fields['customers_lastname']);

$sql = "select c.countries_name from `countries` as c left join `customers` as ct on ct.customer_country_id = c.countries_id where ct.customers_id = ".$_SESSION['customer_id'];
$res = $db->Execute($sql);
$customers_countries = $res->fields['countries_name'];
$countries_arr = array(
	'United States'=>FS_PHONE_SITE_US,
	'Mexico'=>FS_PHONE_MX,
	'Canada'=>FS_PHONE_CA,
	'Brazil'=>FS_PHONE_BR,
	'Argentina'=>FS_PHONE_AR,
	'United Kingdom'=>FS_PHONE_GB,
	'France'=>FS_PHONE_FR,
	'Netherlands'=>FS_PHONE_NL,
	'Germany'=>FS_PHONE_DE,
	'Spain'=>FS_PHONE_ES,
	'Switzerland'=>FS_PHONE_CH,
	'Denmark'=>FS_PHONE_DK,
	'Russia'=>FS_PHONE_RU,
	'Singapore'=>FS_PHONE_SG,
	'Hong Kong'=>FS_PHONE_HK,
	'Taïwan'=>FS_PHONE_TW,
	'Australia'=>FS_PHONE_AU,
	'New Zealand'=>FS_PHONE_NZ,
    'Japan'=>FS_PHONE_JP,
);
    $user_countries = fs_new_get_phone($_SESSION['countries_iso_code']);


//如果这个客户存在quotation才显示
$show_quotation = (int)fs_get_data_from_db_fields('quotation_id',TABLE_QUOTATION,'customers_id='.$_SESSION['customer_id'],'LIMIT 1');

?>
<div class="new17my_account_menu">
  <div class="new17my_account_menu_icon"><font class="icon iconfont">&#xf057;</font></div>
  <ul>
	<li <?php echo ('edit_my_account' == $_GET['main_page']) ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link('edit_my_account','','SSL');?>"><?php echo ACCOUNT_LEFT_EDIT;?></a></li>
	<li <?php echo (in_array($_GET['main_page'],array('manage_orders_old','sales_service_list','sales_service','sales_service_info','sales_service_details','account_history_info_old'))) ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link('manage_orders_old','','SSL');?>"><?php echo ACCOUNT_LEFT_ORDER;?></a></li>
    <li <?php echo (in_array($_GET['main_page'],array('my_cases','my_cases_details'))) ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link(FILENAME_MY_CASES,'','SSL');?>"><?php echo ACCOUNT_LEFT_CASES;?></a></li>

      <?php //上线新的报价，屏蔽旧的报价 ?>
      <?php if (!FS_IS_OPEN_HOME_INQUIRY && $show_quotation){ ?>
          <li <?php echo (in_array($_GET['main_page'],array(FILENAME_VALID_QUOTATION,FILENAME_VALID_QUOTATION_DETAIL))) ? 'class="active"' : ''; ?>>
              <a href="<?php echo zen_href_link(FILENAME_VALID_QUOTATION,'','SSL');?>">
                  <?php echo ACCOUNT_LEFT_QUOTATION;?>
              </a>
          </li>
      <?php } ?>

    <?php if (FS_IS_OPEN_HOME_INQUIRY){ ?>
	<li <?php echo ($_GET['main_page'] == 'inquiry_list' || $_GET['main_page'] == 'inquiry_detail') ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link('inquiry_list','','SSL');?>"><?php echo ACCOUNT_LEFT_MY_QUOTES;?></a></li>
    <?php } ?>

	<li <?php echo ('manage_addresses' == $_GET['main_page']) ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link(FILENAME_MANAGE_ADDRESSES,'','SSL');?>"><?php echo ACCOUNT_LEFT_ADDRESS;?></a></li>
	<!--<li <?php /*echo (in_array($_GET['main_page'],array('my_questions','my_questions_details'))) ? 'class="active"' : ''; */?>><a href="<?php /*echo zen_href_link(FILENAME_MY_QUESTIONS,'','SSL');*/?>"><?php /*echo ACCOUNT_LEFT_QUESTION;*/?></a></li>-->
	<!--<li <?php /*echo (in_array($_GET['main_page'],array('my_cases','my_cases_details'))) ? 'class="active"' : ''; */?>><a href="<?php /*echo zen_href_link(FILENAME_MY_CASES,'','SSL');*/?>"><?php /*echo ACCOUNT_LEFT_CASES;*/?></a></li>-->
	<li <?php echo ('account_newsletters' == $_GET['main_page']) ? 'class="active"' : ''; ?>><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS,'','SSL');?>"><?php echo ACCOUNT_LEFT_MANAGE;?></a></li>
  </ul>
</div>
<script>
	$('.new17my_account_menu_icon').click(function(){
		$(this).siblings('ul').slideToggle();
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		}
	})
</script>