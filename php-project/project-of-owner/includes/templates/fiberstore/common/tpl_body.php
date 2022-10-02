<?php
/**
 * footer for fiberstore
 */
?>
<div class="box">
	<?php 
	$body_parts = array('tpl_box_header.php','tpl_box_menu.php','tpl_breadcrumb.php','tpl_box_content.php');
	foreach ($body_parts as $part){	
		cacheFactory::LoadingCache($part);
		require($template->get_template_dir($part,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$part);
	}
	?>
