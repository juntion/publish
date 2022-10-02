<?php 
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', "define_estimated_lead_time", 'false');

//$breadcrumb->add('Tiempo Estimado de Entrega',zen_href_link(FILENAME_ESTIMATED_TIME));
$breadcrumb->add('Delivery & Shipment');