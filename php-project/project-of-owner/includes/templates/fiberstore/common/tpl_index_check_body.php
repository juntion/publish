<?php
/**
 * footer for fiberstore
 */
?>

<?php
$body_parts = array('tpl_box_header.php','tpl_box_menu.php','tpl_index_box_content.php');
foreach ($body_parts as $part){
    cacheFactory::LoadingCache($part);
    require($template->get_template_dir($part,DIR_WS_TEMPLATE, $current_page_base,'common'). '/'.$part);
}
?>
</div>
<?php// require $body_code;?>
