<?php
function getBreadCrumb(){
	global $db;
	/**
	 * add category names or the manufacturer name to the breadcrumb trail
	 */
	$robotsNoIndex = false;
	// might need isset($_GET['cPath']) later ... right now need $cPath or breaks breadcrumb from sidebox etc.
	if (isset($cPath_array) && isset($cPath)) {
	  for ($i=1, $n=sizeof($cPath_array); $i<$n; $i++) {
	    $categories_query = "select categories_name
	                           from " . TABLE_CATEGORIES_DESCRIPTION . "
	                           where categories_id = '" . (int)$cPath_array[$i] . "'
	                           and language_id = '" . (int)$_SESSION['languages_id'] . "'";
	
	    $categories = $db->Execute($categories_query);
	//echo 'I SEE ' . (int)$cPath_array[$i] . '<br>';
	    if ($categories->RecordCount() > 0) {
	//      	$breadcrumb->add($categories->fields['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
				$breadcrumb->add($categories->fields['categories_name'], HTTP_SERVER.'/'.preg_replace('/(\/|[[:space:]]{1,})/i', '-', $categories->fields['categories_name']).'-c' . implode('_', array_slice($cPath_array, 0, ($i+1))));
	    } elseif(SHOW_CATEGORIES_ALWAYS == 0) {
	      // if invalid, set the robots noindex/nofollow for this page
	      $robotsNoIndex = true;
	      break;
	    }
	  }
	}
	/**
	 * add get terms (e.g manufacturer, music genre, record company or other user defined selector) to breadcrumb
	 */
	 /*
	$sql = "select *
	        from " . TABLE_GET_TERMS_TO_FILTER;
	$get_terms = $db->execute($sql);
	while (!$get_terms->EOF) {
		if (isset($_GET[$get_terms->fields['get_term_name']])) {
			$sql = "select " . $get_terms->fields['get_term_name_field'] . "
			        from " . constant($get_terms->fields['get_term_table']) . "
			        where " . $get_terms->fields['get_term_name'] . " =  " . (int)$_GET[$get_terms->fields['get_term_name']];
			$get_term_breadcrumb = $db->execute($sql);
	    if ($get_term_breadcrumb->RecordCount() > 0) {
	      $breadcrumb->add($get_term_breadcrumb->fields[$get_terms->fields['get_term_name_field']], zen_href_link(FILENAME_DEFAULT, $get_terms->fields['get_term_name'] . "=" . $_GET[$get_terms->fields['get_term_name']]));
	    }
		}
		$get_terms->movenext();
}

*/
}