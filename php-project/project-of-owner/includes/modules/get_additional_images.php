<?php

$images_array = array();
	// do not check for additional images when turned off
	if ($products_image != '' && $flag_show_product_info_additional_images != 0) {
	  // prepare image name
	  $products_image_extension = substr($products_image, strrpos($products_image, '.'));
	  $products_image_base = str_replace($products_image_extension, '', $products_image);

	  // if in a subdirectory
	  if (strrpos($products_image, '/')) {
	    $products_image_match = substr($products_image, strrpos($products_image, '/')+1);
	    //echo 'TEST 1: I match ' . $products_image_match . ' - ' . $file . ' -  base ' . $products_image_base . '<br>';
	    $products_image_match = str_replace($products_image_extension, '', $products_image_match) . '_';
	    $products_image_base = $products_image_match;
	  }

	  $products_image_directory = str_replace($products_image, '', substr($products_image, strrpos($products_image, '/')));
	  if ($products_image_directory != '') {
	    $products_image_directory = DIR_WS_IMAGES . str_replace($products_image_directory, '', $products_image) . "/";
	  } else {
	    $products_image_directory = DIR_WS_IMAGES;
	  }

	  // Check for additional matching images
	  $file_extension = $products_image_extension;
	  $products_image_match_array = array();
	  if ($dir = @dir($products_image_directory)) {
	    while ($file = $dir->read()) {
	      if (!is_dir($products_image_directory . $file)) {
	        if (substr($file, strrpos($file, '.')) == $file_extension) {
	          //          if(preg_match("/" . $products_image_match . "/i", $file) == '1') {
	          if(preg_match("/" . $products_image_base . "/i", $file) == 1) {


	          	if ($products_image_directory.$file != $products_image)
	          	{
			          	if ($products_image_base . str_replace($products_image_base, '', $file) == $file) {
			          		//  echo 'I AM A MATCH ' . $file . '<br>';
			                $images_array[] = $file;
			              } else {
			                //  echo 'I AM NOT A MATCH ' . $file . '<br>';
			              }
	          	}

	          }
	        }
	      }
	    }
	    if (sizeof($images_array)) {
	      sort($images_array);
	    }
	    $dir->close();
	  }
	}
	$num_images = sizeof($images_array);

	if(!empty($images_array) && is_array($images_array) && sizeof($images_array) > 0)
		//get the largest image to show
		for ($i=0, $n=$num_images; $i<$n; $i++) {
	    	$file = $images_array[$i];

	    	if (!empty($file))
	    	{
    	    	$products_image_large = str_replace(DIR_WS_IMAGES, DIR_WS_IMAGES . 'large/', $products_image_directory) . str_replace($products_image_extension, '', $file) . IMAGE_SUFFIX_LARGE . $products_image_extension;
    	    	$base_image = $products_image_directory . $file;


    	    	if (file_exists($products_image_large))	$images_array[$i] = $products_image_large;
    	    	else $images_array[$i] = $base_image;
	    	}
		}
	?>