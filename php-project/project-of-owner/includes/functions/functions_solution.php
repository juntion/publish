 <?php
 
 
  function zen_get_solution_cpath($current_category_id = '') {
    global $cPath_array, $db;

    if (zen_not_null($current_category_id)) {
      $cp_size = sizeof($cPath_array);
      if ($cp_size == 0) {
        $cPath_new = $current_category_id;
      } else {
        $cPath_new = '';
        $last_category_query = "select doc_parent_id
                                from " . TABLE_SOLUTION_CATEGORIES . "
                                where doc_categories_id = '" . (int)$cPath_array[($cp_size-1)] . "'";

        $last_category = $db->Execute($last_category_query);

        $current_category_query = "select doc_parent_id
                                   from " . TABLE_SOLUTION_CATEGORIES . "
                                   where doc_categories_id = '" . (int)$current_category_id . "'";

        $current_category = $db->Execute($current_category_query);

        if ($last_category->fields['doc_parent_id'] == $current_category->fields['doc_parent_id']) {
          for ($i=0; $i<($cp_size-1); $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        } else {
          for ($i=0; $i<$cp_size; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        }
        $cPath_new .= '_' . $current_category_id;

        if (substr($cPath_new, 0, 1) == '_') {
          $cPath_new = substr($cPath_new, 1);
        }
      }
    } else {
      $cPath_new = implode('_', $cPath_array);
    }

    return 'cPath=' . $cPath_new;
  }
  
  
  
  ?>