<?php 
if (!class_exists('fiberstore_category')){
	require DIR_WS_CLASSES . 'fiberstore_category.php';
}
echo fiberstore_category::show_top_categories_of_left_side_bar($current_category_id);