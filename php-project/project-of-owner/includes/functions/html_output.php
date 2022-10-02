<?php
function zen_href_link($page = 'index', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true)
{

    $connection = 'SSL';
    /* QUICK AND DIRTY WAY TO DISABLE REDIRECTS ON PAGES WHEN SEO_URLS_ONLY_IN is enabled IMAGINADW.COM */
    $sefu = explode(",", ereg_replace(' +', '', SEO_URLS_ONLY_IN));
    if ((SEO_URLS_ONLY_IN != "") && !in_array($page, $sefu)) {
        return original_zen_href_link($page, $parameters, $connection, $add_session_id, $search_engine_safe, $static, $use_dir_ws_catalog);
    }

    if (!isset($GLOBALS['seo_urls']) && !is_object($GLOBALS['seo_urls'])) {
        include_once(DIR_WS_CLASSES . 'seo.url.php');

        $GLOBALS['seo_urls'] = new SEO_URL($_SESSION['languages_id']);
    }

    return $GLOBALS['seo_urls']->href_link($page, $parameters, $connection, $add_session_id, $static, $use_dir_ws_catalog);
}

function get_product_picture_microdata($product_id)
{
    global $db;

    $sql = "select p.products_id,p.products_image,pd.products_name
           from   " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
           where  p.products_status = '1'
           and    p.products_id = '" . (int)$product_id . "'
           and    pd.products_id = p.products_id
           and    pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
    $product_info = $db->Execute($sql);
    $products_image = "";
    if (!empty($product_info->fields['products_image'])) {
        $products_image = $product_info->fields['products_image'];
    }
    if ($_SESSION['languages_id'] == 1) {
        $water_mark_path = '';
    } else {
        $water_mark_path = '../';
    }

    require(DIR_WS_MODULES . zen_get_module_directory('additional_images'));
    $original_images = array('images/' . $products_image);
    $imagesArr = get_additional_images($product_id);
    $images_array = array();
    if ($imagesArr) {
        $images_array = $imagesArr;
    }
    $original_images = array_merge($original_images, $images_array);

    $wartermark_images = array();
    if (sizeof($original_images)) {
        foreach ($original_images as $i => $img) {
            if (strpos($img, '.')) {
                $path_info = pathinfo($img);
                $define_large_image = $water_mark_path . $path_info['dirname'] . '/' . str_replace('.' . $path_info['extension'], '', $path_info['basename']) . '_LRG.' . $path_info['extension'];
                $ih_image = new ih_image($define_large_image, 600, 600);
                $wartermark_images['big'][$i] = $ih_image->get_local();
                $wartermark_images['small'][$i] = $ih_image->get_local_seo();
            }
        }
    }
    $html = '';
    if (!empty($wartermark_images)) {
        for ($i = 0, $n = sizeof($wartermark_images['small']); $i < $n; $i++) {
            if ($i <= 5) {
                if ($i == 0) {
                    $html .= '<image:image><image:loc>' . HTTPS_IMAGE_SERVER . $wartermark_images['small'][$i] . '</image:loc></image:image>';
                }
            }
        }
    }
    return $html;
}

function map_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true)
{

    $connection = 'SSL';


    include_once(DIR_WS_CLASSES . 'seo.url.php');
    $GLOBALS['seo_urls'] = new SEO_URL($_SESSION['languages_id']);


    return $GLOBALS['seo_urls']->href_link($page, $parameters, $connection, $add_session_id, $static, $use_dir_ws_catalog);
}

/*
 * The HTML href link wrapper function
 */
function original_zen_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true, $static = false, $use_dir_ws_catalog = true)
{
    global $request_type, $session_started, $http_domain, $https_domain;

    if (!zen_not_null($page)) {
        die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine the page link!</strong><br /><br /><!--' . $page . '<br />' . $parameters . ' -->');
    }

    if ($connection == 'NONSSL') {
        $link = HTTP_SERVER;
    } elseif ($connection == 'SSL') {
        if (ENABLE_SSL == 'true') {
            $link = HTTPS_SERVER;
        } else {
            $link = HTTP_SERVER;
        }
    } else {
        die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
    }

    if ($use_dir_ws_catalog) {
        if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            $link .= DIR_WS_HTTPS_CATALOG;
        } else {
            $link .= DIR_WS_CATALOG;
        }
    }
    //拼接各站点标识符
    if (!empty($_GET['lang']) && in_array(trim($_GET['lang']), $GLOBALS['fs_all_site'])) {
        $link .= trim($_GET['lang']) . '/';
    }
    if (!$static) {
        if (zen_not_null($parameters)) {
            $link .= 'index.php?main_page=' . $page . "&" . zen_output_string($parameters);
        } else {
            $link .= 'index.php?main_page=' . $page;
        }
    } else {
        if (zen_not_null($parameters)) {
            $link .= $page . "?" . zen_output_string($parameters);
        } else {
            $link .= $page;
        }
    }

    $separator = '&';

    while ((substr($link, -1) == '&') || (substr($link, -1) == '?')) $link = substr($link, 0, -1);
// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if (($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False')) {
        if (defined('SID') && zen_not_null(SID)) {
            $sid = SID;
//      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL_ADMIN == 'true') ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        } elseif ((($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == 'true')) || (($request_type == 'SSL') && ($connection == 'NONSSL'))) {
            if ($http_domain != $https_domain) {
                $sid = zen_session_name() . '=' . zen_session_id();
            }
        }
    }

// clean up the link before processing
    while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);

    if ((SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true)) {
        while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);

        $link = str_replace('&amp;', '/', $link);
        $link = str_replace('?', '/', $link);
        $link = str_replace('&', '/', $link);
        $link = str_replace('=', '/', $link);

        $separator = '?';
    }

    if (isset($sid)) {
        $link .= $separator . zen_output_string($sid);
    }

// clean up the link after processing
    while (strstr($link, '&amp;&amp;')) $link = str_replace('&amp;&amp;', '&amp;', $link);

    $link = preg_replace('/&/', '&amp;', $link);
    return $link;
}


/*
 * The HTML image wrapper function for non-proportional images
 * used when "proportional images" is turned off or if calling from a template directory
 */
function zen_image_OLD($src, $alt = '', $width = '', $height = '', $parameters = '')
{
    global $template_dir;

//auto replace with defined missing image
    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
        $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ((empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false')) {
        return false;
    }

    // if not in current template switch to template_default
    if (!file_exists($src)) {
        $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) {
        $image .= ' title=" ' . zen_output_string($alt) . ' "';
    }

    if ((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height))) {
        if ($image_size = @getimagesize($src)) {
            if (empty($width) && zen_not_null($height)) {
                $ratio = $height / $image_size[1];
                $width = $image_size[0] * $ratio;
            } elseif (zen_not_null($width) && empty($height)) {
                $ratio = $width / $image_size[0];
                $height = $image_size[1] * $ratio;
            } elseif (empty($width) && empty($height)) {
                $width = $image_size[0];
                $height = $image_size[1];
            }
        } elseif (IMAGE_REQUIRED == 'false') {
            return false;
        }
    }

    if (zen_not_null($width) && zen_not_null($height)) {
        $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
    }

    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    return $image;
}

function zen_image_get_info($src, $alt = '', $width = '', $height = '', $parameters = '')
{
    global $template_dir;
    $info = array();
    // soft clean the alt tag
    $alt = zen_clean_html($alt);

    // use old method on template images
    if (strstr($src, 'includes/templates') or strstr($src, 'includes/languages') or PROPORTIONAL_IMAGES_STATUS == '0') {
        $info['width'] = $width;
        $info['height'] = $height;
        return $info;
    }

//auto replace with defined missing image
    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
        $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ((empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false')) {
        $info['width'] = $width;
        $info['height'] = $height;
        return $info;
    }

    // if not in current template switch to template_default
    if (!file_exists($src)) {
        $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }

    // hook for handle_image() function such as Image Handler etc
    if (function_exists('handle_image')) {
        $newimg = handle_image($src, $alt, $width, $height, $parameters);
        list($src, $alt, $width, $height, $parameters) = $newimg;
    }

    // Convert width/height to int for proper validation.
    // intval() used to support compatibility with plugins like image-handler
    $width = empty($width) ? $width : intval($width);
    $height = empty($height) ? $height : intval($height);

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = zen_output_string($src);
    if (((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)))) {
        if ($image_size = @getimagesize($src)) {
            if (empty($width) && zen_not_null($height)) {
                $ratio = $height / $image_size[1];
                $width = $image_size[0] * $ratio;
            } elseif (zen_not_null($width) && empty($height)) {
                $ratio = $width / $image_size[0];
                $height = $image_size[1] * $ratio;
            } elseif (empty($width) && empty($height)) {
                $width = $image_size[0];
                $height = $image_size[1];
            }
        } elseif (IMAGE_REQUIRED == 'false') {
            $info['width'] = $width;
            $info['height'] = $height;
            $info['image'] = $image;
            return $info;
        }
    }


    if (zen_not_null($width) && zen_not_null($height) and file_exists($src)) {
//      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
// proportional images
        $image_size = @getimagesize($src);
        // fix division by zero error
        $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
        if ($image_size[1] * $ratio > $height) {
            $ratio = $height / $image_size[1];
            $width = $image_size[0] * $ratio;
        } else {
            $height = $image_size[1] * $ratio;
        }
// only use proportional image when image is larger than proportional size
        if ($image_size[0] < $width and $image_size[1] < $height) {
            $width = $image_size[0];
            $height = intval($image_size[1]);
        } else {
            $width = round($width);
            $height = round($height);
        }
    } else {
        // override on missing image to allow for proportional and required/not required
        if (IMAGE_REQUIRED == 'false') {
            $info['width'] = $width;
            $info['height'] = $height;
            $info['image'] = $image;
            return $info;
        } else {
            $info['width'] = intval(SMALL_IMAGE_WIDTH);
            $info['height'] = intval(SMALL_IMAGE_HEIGHT);
            $info['image'] = $image;
        }
    }

    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
        $parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }
    // add $parameters to the tag output
    $info['width'] = $width;
    $info['height'] = $height;
    $info['image'] = $image;
    return $info;
}

/*
 * The HTML image wrapper function
 */
function zen_image($src, $alt = '', $width = '', $height = '', $parameters = '')
{
    global $template_dir;

    // soft clean the alt tag
    $alt = zen_clean_html($alt);

    // use old method on template images
    if (strstr($src, 'includes/templates') or strstr($src, 'includes/languages') or PROPORTIONAL_IMAGES_STATUS == '0') {
        return zen_image_OLD($src, $alt, $width, $height, $parameters);
    }

//auto replace with defined missing image
    if ($src == DIR_WS_IMAGES and PRODUCTS_IMAGE_NO_IMAGE_STATUS == '1') {
        $src = DIR_WS_IMAGES . PRODUCTS_IMAGE_NO_IMAGE;
    }

    if ((empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false')) {
        return false;
    }

    // if not in current template switch to template_default
    if (!file_exists($src)) {
        $src = str_replace(DIR_WS_TEMPLATES . $template_dir, DIR_WS_TEMPLATES . 'template_default', $src);
    }

    // hook for handle_image() function such as Image Handler etc
    if (function_exists('handle_image')) {
        $newimg = handle_image($src, $alt, $width, $height, $parameters);
        list($src, $alt, $width, $height, $parameters) = $newimg;
    }

    // Convert width/height to int for proper validation.
    // intval() used to support compatibility with plugins like image-handler
    $width = empty($width) ? $width : intval($width);
    $height = empty($height) ? $height : intval($height);

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . HTTPS_IMAGE_SERVER . '/' . zen_output_string($src) . '" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) {
        $image .= ' title=" ' . zen_output_string($alt) . ' "';
    }

    if (((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)))) {
        if ($image_size = @getimagesize($src)) {
            if (empty($width) && zen_not_null($height)) {
                $ratio = $height / $image_size[1];
                $width = $image_size[0] * $ratio;
            } elseif (zen_not_null($width) && empty($height)) {
                $ratio = $width / $image_size[0];
                $height = $image_size[1] * $ratio;
            } elseif (empty($width) && empty($height)) {
                $width = $image_size[0];
                $height = $image_size[1];
            }
        } elseif (IMAGE_REQUIRED == 'false') {
            return false;
        }
    }


    if (zen_not_null($width) && zen_not_null($height) and file_exists($src)) {
//      $image .= ' width="' . zen_output_string($width) . '" height="' . zen_output_string($height) . '"';
// proportional images
        $image_size = @getimagesize($src);
        // fix division by zero error
        $ratio = ($image_size[0] != 0 ? $width / $image_size[0] : 1);
        if ($image_size[1] * $ratio > $height) {
            $ratio = $height / $image_size[1];
            $width = $image_size[0] * $ratio;
        } else {
            $height = $image_size[1] * $ratio;
        }
// only use proportional image when image is larger than proportional size
        if ($image_size[0] < $width and $image_size[1] < $height) {
            $image .= ' width="' . $image_size[0] . '" height="' . intval($image_size[1]) . '"';
        } else {
            $image .= ' width="' . round($width) . '" height="' . round($height) . '"';
        }
    } else {
        // override on missing image to allow for proportional and required/not required
        if (IMAGE_REQUIRED == 'false') {
            return false;
        } else {
            $image .= ' width="' . intval($width) . '" height="' . intval($height) . '"';
        }
    }

    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
        $parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }
    // add $parameters to the tag output
    if (zen_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';

    // $c = 'https://cdn.fs.com/';
    // $i = "imgCache/";
    // $image = str_replace($i,$c,$image);

    return $image;
}

/*
 * The HTML form submit button wrapper function
 * Outputs a "submit" button in the selected language
 */
function zen_image_submit($image, $alt = '', $parameters = '', $sec_class = '')
{
    global $template, $current_page_base, $zco_notifier;
    if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes' && strlen($alt) < 30) return zenCssButton($image, $alt, 'submit', $sec_class /*, $parameters = ''*/);
    $zco_notifier->notify('PAGE_OUTPUT_IMAGE_SUBMIT');

    $image_submit = '<input type="image" src="' . zen_output_string($template->get_template_dir($image, DIR_WS_TEMPLATE, $current_page_base, 'buttons/' . $_SESSION['language'] . '/') . $image) . '" alt="' . zen_output_string($alt) . '"';

    if (zen_not_null($alt)) $image_submit .= ' title=" ' . zen_output_string($alt) . ' "';

    if (zen_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
}

/*
 * Output a function button in the selected language
 */
function zen_image_button($image, $alt = '', $parameters = '', $sec_class = '')
{
    global $template, $current_page_base, $zco_notifier;

    // inject rollover class if one is defined. NOTE: This could end up with 2 "class" elements if $parameters contains "class" already.
    if (defined('IMAGE_ROLLOVER_CLASS') && IMAGE_ROLLOVER_CLASS != '') {
        $parameters .= (zen_not_null($parameters) ? ' ' : '') . 'class="rollover"';
    }

    $zco_notifier->notify('PAGE_OUTPUT_IMAGE_BUTTON');
    if (strtolower(IMAGE_USE_CSS_BUTTONS) == 'yes') return zenCssButton($image, $alt, 'button', $sec_class, $parameters = '');
    return zen_image($template->get_template_dir($image, DIR_WS_TEMPLATE, $current_page_base, 'buttons/' . $_SESSION['language'] . '/') . $image, $alt, '', '', $parameters);
}


/**
 * generate CSS buttons in the current language
 * concept from contributions by Seb Rouleau and paulm, subsequently adapted to Zen Cart
 * note: any hard-coded buttons will not be able to use this function
 **/
function zenCssButton($image = '', $text, $type, $sec_class = '', $parameters = '')
{

    // automatic width setting depending on the number of characters
    $min_width = 80; // this is the minimum button width, change the value as you like
    $character_width = 6.5; // change this value depending on font size!
    // end settings
    // added html_entity_decode function to prevent html special chars to be counted as multiple characters (like &amp;)
    $width = strlen(html_entity_decode($text)) * $character_width;
    $width = (int)$width;
    if ($width < $min_width) $width = $min_width;
    $style = ' style="width: ' . $width . 'px;"';
    // if no secondary class is set use the image name for the sec_class
    if (empty($sec_class)) $sec_class = basename($image, '.gif');
    if (!empty($sec_class)) $sec_class = ' ' . $sec_class;
    if (!empty($parameters)) $parameters = ' ' . $parameters;
    $mouse_out_class = 'cssButton' . $sec_class;
    $mouse_over_class = 'cssButtonHover' . $sec_class . $sec_class . 'Hover';
    // javascript to set different classes on mouseover and mouseout: enables hover effect on the buttons
    // (pure css hovers on non link elements do work work in every browser)
    $css_button_js .= 'onmouseover="this.className=\'' . $mouse_over_class . '\'" onmouseout="this.className=\'' . $mouse_out_class . '\'"';

    if ($type == 'submit') {
// form input button
        $css_button = '<input class="' . $mouse_out_class . '" ' . $css_button_js . ' type="submit" value="' . $text . '"' . $parameters . $style . ' />';
    }

    if ($type == 'button') {
// link button
        $css_button = '<span class="' . $mouse_out_class . '" ' . $css_button_js . $style . ' >&nbsp;' . $text . '&nbsp;</span>'; // add $parameters ???
    }
    return $css_button;
}


/*
 *  Output a separator either through whitespace, or with an image
 */
function zen_draw_separator($image = 'true', $width = '100%', $height = '1')
{

    // set default to use from template - zen_image will translate if not found in current template
    if ($image == 'true') {
        $image = DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_BLACK_SEPARATOR;
    } else {
        if (!strstr($image, DIR_WS_TEMPLATE_IMAGES)) {
            $image = DIR_WS_TEMPLATE_IMAGES . $image;
        }
    }
    return zen_image($image, '', $width, $height);
}

/*
 *  Output a form
 */
function zen_draw_form($name, $action, $method = 'post', $parameters = '')
{
    $form = '<form name="' . zen_output_string($name) . '" action="' . zen_output_string($action) . '" method="' . zen_output_string($method) . '"';

    if (zen_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    return $form;
}

/*
 *  Output a form input field
 */
function zen_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true)
{
    $field = '<input type="' . zen_output_string($type) . '" name="' . zen_sanitize_string(zen_output_string($name)) . '"';
    if ((isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) && ($reinsert_value == true)) {
        $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    } elseif (zen_not_null($value)) {
        $field .= ' value="' . zen_output_string($value) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
}

/*
 *  Output a form password field
 */
function zen_draw_password_field($name, $value = '', $parameters = 'maxlength="40"')
{
    return zen_draw_input_field($name, $value, $parameters, 'password', true);
}

/*
 *  Output a selection field - alias function for zen_draw_checkbox_field() and zen_draw_radio_field()
 */
function zen_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '', $is_disabled = false)
{
    $selection = '<input type="' . zen_output_string($type) . '" name="' . zen_output_string($name) . '" ' . ($is_disabled ? "disabled" : "");

    if (zen_not_null($value)) $selection .= ' value="' . zen_output_string($value) . '"';

    if (($checked == true) || (isset($GLOBALS[$name]) && is_string($GLOBALS[$name]) && (($GLOBALS[$name] == 'on') || (isset($value) && (stripslashes($GLOBALS[$name]) == $value))))) {
        $selection .= ' checked="checked"';
    }

    if (zen_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />';

    return $selection;
}

/*
 *  Output a form checkbox field
 */
function zen_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '', $is_disabled = false)
{
    return zen_draw_selection_field($name, 'checkbox', $value, $checked, $parameters, $is_disabled);
}

/*
 *  Output a form checkbox field
 */
function zen_draw_checkbox_inquiry_field($name, $value = '', $checked = false, $parameters = '', $is_disabled = false,$attr_name,$option_id)
{
    $selection ='<span class="re_radio"  rel="'.$value.'" "'.$parameters.'" id="'.$option_id.'-'.$value.'"   attr_products=""><i class="iconfont icon">&#xf372;</i>'.$attr_name.'
    <input type="hidden" name="'.$name.'" value="' . zen_output_string($value) . '" disabled="disabled"></span>';
    return $selection;
}

/*
 * Output a form radio field
 */
function zen_draw_radio_field($name, $value = '', $checked = false, $parameters = '')
{
    return zen_draw_selection_field($name, 'radio', $value, $checked, $parameters);
}

/*
 *  Output a form textarea field
 */
function zen_draw_textarea_field($name, $width, $height, $text = '~*~*#', $parameters = '', $reinsert_value = true)
{
    $field = '<textarea name="' . zen_output_string($name) . '" cols="' . zen_output_string($width) . '" rows="' . zen_output_string($height) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ($text == '~*~*#' && (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) && ($reinsert_value == true)) {
        $field .= stripslashes($GLOBALS[$name]);
    } elseif ($text != '~*~*#' && zen_not_null($text)) {
        $field .= $text;
    }

    $field .= '</textarea>';

    return $field;
}

/*
 *  Output a form hidden field
 */
function zen_draw_hidden_field($name, $value = '', $parameters = '')
{
    $field = '<input type="hidden" name="' . zen_sanitize_string(zen_output_string($name)) . '"';

    if (zen_not_null($value)) {
        $field .= ' value="' . zen_output_string($value) . '"';
    } elseif (isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) {
        $field .= ' value="' . zen_output_string(stripslashes($GLOBALS[$name])) . '"';
    }

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
}

/*
 * Output a form file-field
 */
function zen_draw_file_field($name, $required = false)
{
    $field = zen_draw_input_field($name, '', ' size="50" ', 'file');

    return $field;
}


/*
 *  Hide form elements while including session id info
 *  IMPORTANT: This should be used in every FORM that has an OnSubmit() function tied to it, to prevent unexpected logouts
 */
function zen_hide_session_id()
{
    global $session_started;

    if (($session_started == true) && defined('SID') && zen_not_null(SID)) {
        return zen_draw_hidden_field(zen_session_name(), zen_session_id());
    }
}

/*
 *  Output a form pull down menu
 *  Pulls values from a passed array, with the indicated option pre-selected
 */
function zen_draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false, $please_select = true)
{
    $field = '<select class="login_country changez" name="' . zen_output_string($name) . '" ';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if ($please_select) {
        $field .= '<option value="0">' . PLEASE_SELECT . '</option>' . "\n";
    }

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        //echo "<style=\"display:none\">".$values[$i]['id']."</div>";
        //if (0 != $values[$i]['id']){
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
        if ($default == $values[$i]['id']) {
            $field .= ' selected="selected"';
        }

        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
        //}
    }
    $field .= '</select>' . "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

/*
 *  Output a form pull down menu
 *  Pulls values from a passed array, with the indicated option pre-selected
 */
function zen_draw_pull_down_inquiry_menu($name, $values, $default = '', $parameters = '', $required = false, $please_select = true,$attr_product_id,$option_id,$type)
{

    $product_id=0;
    $is_attr="";
    if($attr_product_id){
        $is_attr  = explode(':',$attr_product_id)[1];
    }
    if($type==true){
        $field = '<select class="re_select '.$is_attr.'" onchange="changeNotAttribute(\''.$attr_product_id.'\',this)" id="attrib-'.$option_id.'"  attr_pro="'.$is_attr.'" name="' . zen_output_string($name) . '"';
    }else{
        $field = '<select class="re_select '.$is_attr.'" onchange="change_attribute(this,3)" id="attrib-'.$option_id.'"  attr_pro="'.$is_attr.'" name="' . zen_output_string($name) . '"';
    }
    $field .= '>' . "\n";
//线轴属性 不需要Select Attribute字样  直接选中
    if($option_id !=341) {
//    if ($please_select) {
        $field .= '<option value="" selected="selected">' . FS_INQUIRY_INFO_30_1 . '</option>' . "\n";
//    }
    }

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        //echo "<style=\"display:none\">".$values[$i]['id']."</div>";
        //if (0 != $values[$i]['id']){
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
//        if ($default == $values[$i]['id']) {
//            $field .= ' selected="selected"';
//        }

        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
        //}
    }
    $field .= '</select>' . "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

function zen_draw_pull_down_menu_optic_network($name, $values, $default = '', $parameters = '', $required = false, $options_id, $products_options_name)
{
    if ($result = Channels_Port_option_value_id($options_id, $products_options_name)) {
        $html = "<input type='hidden' name='channels_port_option_count' id='channels_port_option_count' value= '" . count($result) . "'>";
    }
    $field = '<select class="login_country" name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
        if ($default == $values[$i]['id']) {
            $field .= ' selected="selected"';
        }
        //if(stripos($values[$i]['text'],'+')){
        //$values[$i]['text'] = substr($values[$i]['text'],0,-1)."/km)";
        //}
        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
    }
    $field .= '</select>' . "\n";

    if ($html) {
        $field .= $html;
    }

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

function zen_draw_pull_down_menu_outer_jacket($name, $values, $default = '', $parameters = '', $required = false, $options_id, $products_options_name)
{
    $field = '<select class="login_country" name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);
    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
        if ($default == $values[$i]['id']) {
            $field .= ' selected="selected"';
        }
        if (stripos($values[$i]['text'], '+')) {
            $values[$i]['text'] = substr($values[$i]['text'], 0, -1) . "/km)";
        }
        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
    }
    $field .= '</select>' . "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

function zen_draw_pull_down_menu_fiber_count($name, $values, $default = '', $parameters = '', $required = false, $options_id, $products_options_name)
{
    $field = '<select onchange = "custom_select(' . $_GET['products_id'] . ')" class="login_country" name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
        if ($default == $values[$i]['id']) {
            $field .= ' selected="selected"';
        }

        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
    }
    $field .= '</select>';
    $html = fiber_output_html($products_options_name);
    $field .= $html;
    $field .= "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

function zen_draw_pull_down_menu_others($name, $values, $default = '', $parameters = '', $required = false, $options_id)
{
    global $db;
    $list = $db->getAll("select products_options_name from products_options where products_options_id = '" . $options_id . "' and language_id =1");
    if ($list) {
        $result = $db->getAll("select products_options_id from products_options where products_options_id <> '" . $options_id . "' and language_id =1 and products_options_name = '" . $list[0]['products_options_name'] . "' and products_options_type = 1 limit 1");
        if ($result) {
            $products_options_id = $result[0]['products_options_id'];
        } else {
            $products_options_id = 0;
        }
    } else {
        $products_options_id = 0;
    }
    $products_options_name = $list[0]['products_options_name'];
    if (set_block_inline($products_options_name)) {
        $display = 'inline';
    } else {
        $display = 'block';
    }
    $attribute_id = 'attribute-' . $products_options_id . '-0';
    $attrib_id = 'attrib-' . $products_options_id . '-0';
    if (zen_not_null($parameters)) {
        $select_id = str_replace('id=', '', $parameters);
        $select_id = str_replace('"', '', $select_id);
    }

    $brand_attribute_id = 0;
    $brand_attrib_id = 0;

    $field = '<select class="login_country" onchange="set_attribute_others(\'' . $attribute_id . '\',\'' . $select_id . '\',\'' . $attrib_id . '\',\'' . $brand_attribute_id . '\',\'' . $brand_attrib_id . '\',\'' . $display . '\')" name="' . zen_output_string($name) . '"';

    if (zen_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>' . "\n";

    if (empty($default) && isset($GLOBALS[$name]) && is_string($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
        $field .= '  <option value="' . zen_output_string($values[$i]['id']) . '"';
        if ($default == $values[$i]['id']) {
            $field .= ' selected="selected"';
        }

        $field .= '>' . zen_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>' . "\n";
    }
    $field .= '</select>';

    $field .= '<input type="hidden" name="select_option_id" id="select_option_id" value="' . $options_id . '"><input type="hidden" name="input_option_id" id="input_option_id" value="' . $products_options_id . '">';
    $field .= '<div class="ccc"></div>';

    $field .= '<p id="attribute-' . $products_options_id . '-0" style="display:none" class="product_04_22"><input id="attrib-' . $products_options_id . '-0" class="attr_input_2" type="text" value="" maxlength="19" size="19" name="id[text_prefix_' . $products_options_id . ']">';

    if (option_name_detail($products_options_name)) {
        $field .= '&nbsp;&nbsp;(eg,Cisco Nexus 7000)';
    }
    $field .= '</p>' . "\n";

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

/*
 * Creates a pull-down list of countries
 */
function zen_get_country_list($name, $selected = '', $parameters = '')
{
    $countriesAtTopOfList = array();
    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
    $countries = zen_get_countries();

    // Set some default entries at top of list:
    if (STORE_COUNTRY != SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY) $countriesAtTopOfList[] = SHOW_CREATE_ACCOUNT_DEFAULT_COUNTRY;
    $countriesAtTopOfList[] = STORE_COUNTRY;
    // IF YOU WANT TO ADD MORE DEFAULTS TO THE TOP OF THIS LIST, SIMPLY ENTER THEIR NUMBERS HERE.
    // Duplicate more lines as needed
    // Example: Canada is 108, so use 108 as shown:
    //$countriesAtTopOfList[] = 108;

    //process array of top-of-list entries:
    foreach ($countriesAtTopOfList as $key => $val) {
        $countries_array[] = array('id' => $val, 'text' => zen_get_country_name($val));
    }
    // now add anything not in the defaults list:
    for ($i = 0, $n = sizeof($countries); $i < $n; $i++) {
        $alreadyInList = FALSE;
        foreach ($countriesAtTopOfList as $key => $val) {
            if ($countries[$i]['countries_id'] == $val) {
                // If you don't want to exclude entries already at the top of the list, comment out this next line:
                $alreadyInList = TRUE;
                continue;
            }
        }
        if (!$alreadyInList) $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }

    return zen_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
}

/*
 * Assesses suitability for additional parameters such as rel=nofollow etc
 */
function zen_href_params($page = '', $parameters = '')
{
    global $current_page_base;
    $addparms = '';
    // if nofollow has already been set, ignore this function
    if (stristr($parameters, 'nofollow')) return $parameters;
    // if list of skippable pages has been set in meta_tags.php lang file (is by default), use that to add rel=nofollow params
    if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($page, explode(",", constant('ROBOTS_PAGES_TO_SKIP')))
        || $current_page_base == 'down_for_maintenance'
    ) $addparms = 'rel="nofollow"';
    return ($parameters == '' ? $addparms : $parameters . ' ' . $addparms);
}

/*
	* 获取每个站点默认显示在前面的国家
	*/
function zen_get_default_countries()
{
    $default_countries = array();
    //languages_code为语种的标识
    switch ($_SESSION['languages_code']) {
        case 'de':
        case 'dn':
            $default_countries = array(
                81 => 'Germany',
                14 => 'Austria',
                204 => 'Switzerland',
                124 => 'Luxembourg',
                21 => 'Belgium',
                105 => 'Italy',
                122 => 'Liechtenstein',
                150 => 'Netherlands',
                57 => 'Denmark',
            );
            break;
        case 'fr':
            $default_countries = array(
                73 => 'France',
                38 => 'Canada',
                21 => 'Belgium',
                204 => 'Switzerland',
                57 => 'Denmark',
                141 => 'Monaco',
                81 => 'Germany',
                222 => 'United Kingdom',
                195 => 'Spain',
            );
            break;
        case 'ru':
            $default_countries = array(
                176 => 'Russian Federation',
                220 => 'Ukraine',
                109 => 'Kazakhstan',
                117 => 'Latvia',
                80 => 'Georgia',
                123 => 'Lithuania',
            );
            break;
        case 'es':
        case 'mx':
            $default_countries = array(
                195 => 'Spain',
                250 => 'Canary Islands',
                138 => 'Mexico',
                223 => 'United States',
                30 => 'Brazil',
                47 => 'Colombia',
                10 => 'Argentina',
                43 => 'Chile',
                167 => 'Peru',
            );
            break;
        case 'jp':
            $default_countries = array(
                107 => 'Japan',
                223 => 'United States',
                222 => 'United Kingdom',
                38 => 'Canada',
                13 => 'Australia',
                73 => 'France',
                81 => 'Germany',
                195 => 'Spain',
                150 => 'Netherlands',
                176 => 'Russian Federation',
                99 => 'India',
                30 => 'Brazil',
                204 => 'Switzerland',
                105 => 'Italy',
            );
            break;
        case 'sg':
            $default_countries = array(
                188 => 'Singapore',
                129 => 'Malaysia',
                100 => 'Indonesia',
                209 => 'Thailand',
                168 => 'Philippines',
                223 => 'United States',
                222 => 'United Kingdom',
                38 => 'Canada',
                13 => 'Australia',
                73 => 'France',
                81 => 'Germany',
                195 => 'Spain',
                150 => 'Netherlands',
                176 => 'Russian Federation',
                99 => 'India',
                30 => 'Brazil',
                204 => 'Switzerland',
                105 => 'Italy',
            );
            break;
        case 'au':
            $default_countries = array(
                13 => 'Australia',
                153 => 'New Zealand',
            );
            break;
        case 'uk':
            $default_countries = array(
                222 => 'United Kingdom',
                244 => 'Isle of Man',
                243 => 'Guernsey',
                245 => 'Jersey',
                103 => 'Ireland',
                21 => 'Belgium',
                81 => 'Germany',
                73 => 'France',
                195 => 'Spain',
                105 => 'Italy',
                84 => 'Greece',
                150 => 'Netherlands',
                124 => 'Luxembourg',
                57 => 'Denmark',
                171 => 'Portugal',
                14 => 'Austria',
                203 => 'Sweden',

            );
            break;
        default:
            $default_countries = array(
                223 => 'United States',
                222 => 'United Kingdom',
                38 => 'Canada',
                13 => 'Australia',
                73 => 'France',
                81 => 'Germany',
                195 => 'Spain',
                105 => 'Italy',
                150 => 'Netherlands',
                176 => 'Russian Federation',
                99 => 'India',
                30 => 'Brazil',
                204 => 'Switzerland',
            );
            break;
    }
    return $default_countries;
}

//获取每个站点国家名称字段名
function zen_get_countries_fields()
{
    $field_name = '';
    //languages_code为语种的标识
    switch ($_SESSION['languages_code']) {
        case 'de':
            $field_name = 'de_countries_name';
            break;

        case 'fr':
            $field_name = 'fr_countries_name';
            break;

        case 'ru':
            $field_name = 'ru_countries_name';
            break;

        case 'es':
        case 'mx':
            $field_name = 'es_countries_name';
            break;

        case 'jp':
            $field_name = 'jp_countries_name';
            break;

        case 'it':
            $field_name = 'it_countries_name';
            break;

        default:
            $field_name = 'countries_name';
            break;
    }
    return $field_name;
}

//获取每个站点默认国家ID
function zen_get_default_country_id()
{
    $default_country_id = 223;
    //languages_code为语种的标识
    switch ($_SESSION['languages_code']) {
        case 'de':
            $default_country_id = 81;
            break;

        case 'fr':
            $default_country_id = 73;
            break;

        case 'ru':
            $default_country_id = 176;
            break;

        case 'es':
        case 'mx':
            $default_country_id = 195;
            break;

        case 'jp':
            $default_country_id = 107;
            break;
        case 'sg':
            $default_country_id = 188;
            break;
        case 'au':
            $default_country_id = 13;
            break;
        case 'uk':
            $default_country_id = 222;
            break;
        default:
            $default_country_id = 223;
            break;
    }
    return $default_country_id;
}

//获取国家名称
function zen_get_countries_name_by_id($country_id)
{
    global $db;
    if (!$country_id) $country_id = 223;
    $field_name = zen_get_countries_fields();
    $country_name = '';
    $result = $db->Execute("SELECT " . $field_name . " FROM `countries` WHERE `countries_id`={$country_id} LIMIT 1");
    $country_name = $result->fields[$field_name];
    return $country_name;
}

/*
 * 2019.6.15 Yang add
 * 按照 字母 分组 并 排序
 *
 * @param {Array} $list ; 需要 排序的 数据， 一维数组
 * @param {string} $field ; 排序 需要 依据 的字段，该字段 必须为 拼音
 */
function data_letter_sort($list, $field)
{
    $resault = array();

    foreach ($list as $key => $val) {
        // 添加 # 分组，用来 存放 首字母不能 转为 大写英文的 数据
        $resault['#'] = array();
        // 首字母 转 大写英文
        $letter = strtoupper(substr($val[$field], 0, 1));
        // 是否 大写 英文 字母
        if (!preg_match('/^[A-Z]+$/', $letter)) {
            $letter = '#';
        }
        // 创建 字母 分组
        if (!array_key_exists($letter, $resault)) {
            $resault[$letter] = array();
        }
        // 字母 分组 添加 数据
        Array_push($resault[$letter], $val);
    }
    // 依据 键名 字母 排序，该函数 返回 boolean
    ksort($resault);
    // 将 # 分组 放到 最后
    $arr_last = $resault['#'];
    unset($resault['#']);
    $resault['#'] = $arr_last;

    return $resault;
}

//获取所有国家
function zen_get_countries_by_code($countries_id = '', $with_iso_codes = false)
{
    global $db;
    $countries_array = array();
    //获取每个站点国家对应的字段名
    $field_name = zen_get_countries_fields();
    $redisKey = __FUNCTION__.$field_name.$countries_id.$with_iso_codes;
    $data = get_redis_key_value($redisKey,'countryList');
    if(!empty($data)){
        return $data;
    }
    if (zen_not_null($countries_id)) {
        if ($with_iso_codes == true) {
            $countries = "select " . $field_name . ", countries_iso_code_2, countries_iso_code_3,tel_prefix
						  from " . TABLE_COUNTRIES . "
						  where countries_id = '" . (int)$countries_id . "'
						  order by " . $field_name . " ";

            $countries_values = $db->Execute($countries);

            $countries_array = array(
                'countries_name' => $countries_values->fields[$field_name],
                'countries_iso_code_2' => $countries_values->fields['countries_iso_code_2'],
                'countries_iso_code_3' => $countries_values->fields['countries_iso_code_3']
            );
        } else {
            $countries = "select " . $field_name . " from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "'";
            $countries_values = $db->Execute($countries);
            $countries_array = array('countries_name' => $countries_values->fields[$field_name]);
        }
    } else {
        $sql = "select countries_id,countries_name, " . $field_name . ",countries_iso_code_2, tel_prefix
						from " . TABLE_COUNTRIES . " where status=1
						order by " . $field_name . "";
        $countries_values1 = $db->getAll($sql);
        // 2019-7-25 potato 将国家的id作为数组的键，同时组装一个数组方便后面赋值
        foreach ($countries_values1 as $val) {
            $ids[$val['countries_id']] = $val[$field_name];
            $countries_ids[$val['countries_id']]['countries_id'] = $val['countries_id'];
            $countries_ids[$val['countries_id']][$field_name] = $val[$field_name];
            $countries_ids[$val['countries_id']]['countries_iso_code_2'] = $val['countries_iso_code_2'];
            $countries_ids[$val['countries_id']]['tel_prefix'] = $val['tel_prefix'];
            $countries_ids[$val['countries_id']]['countries_name'] = $val['countries_name'];
        }
        // 去掉hongkong，macao，taiwan这个三个地方，方便下面拼接排序
        unset($ids['96']);
        unset($ids['125']);
        unset($ids['206']);
        // 获取数组所有的键，并截取成字符串
        $str = implode(',', array_keys($ids));
        // 拼接成新的字符串
        $contries_ids = str_replace(',44,', ',44,96,125,206,', $str);
        // 转换成数组
        $arr = explode(',', $contries_ids);
        // 将数据赋值给新的数组
        foreach ($arr as $ke => $va) {
            $countries_array[$ke]['countries_id'] = $countries_ids[$va]['countries_id'];
            $countries_array[$ke]['countries_name'] = $countries_ids[$va][$field_name];
            $countries_array[$ke]['english_countries_name'] = $countries_ids[$va]['countries_name'];
            $countries_array[$ke]['countries_iso_code_2'] = $countries_ids[$va]['countries_iso_code_2'];
            $countries_array[$ke]['tel_prefix'] = $countries_ids[$va]['tel_prefix'];
        }
    }
    set_redis_key_value($redisKey,$countries_array,0,'countryList');
    return $countries_array;
}

/**
 *
 * @param int $default_country_id
 * @param string $name html tag name
 * @param string $params html tag attributes
 * @return string $string countries list in  html select tag style
 * @todo get countries list
 */
function zen_draw_countries_pull_down($name = '', $params = '', $default_country_id = 223)
{
    //获取默认推荐展示的国家
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();

    $keys = array_keys($default_countries);
    $string = '<select name="' . $name . '" ' . $params . ">\n";

    // 	group 1
    $string .= '<optgroup label="Please select ...">' . "\n";
    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<option class="flag ' . zen_get_country_iso_code($i) . '"';
        if ($default_country_id && $default_country_id == (int)$i) {
            $string .= ' selected="selected" ';
        }
        $string .= 'value="' . $i . '">&nbsp;<em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</option>' . "\n";
    }
    $string .= '</optgroup>' . "\n";

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();
    $string .= '<optgroup label="--------------------------">' . "\n";
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<option  class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"';
            if ($default_country_id && $default_country_id == $country['countries_id']) {
                $string .= ' selected="selected" ';
            }
            $string .= ' value="' . $country['countries_id'] . '">&nbsp;<em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country['countries_name'] . '</option>' . "\n";
        }
    }
    $string .= '</optgroup>' . "\n";
    $string .= '</select>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag($name = '', $params = '', $default_country_id = 223)
{
    //default countries list
    $default_countries = zen_get_default_countries();
    //$default_country_id = zen_get_default_country_id();
    $default_country_id = fs_get_country_id_of_code($_SESSION['countries_iso_code']);
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string = '
  	          <div ctr="{area:country}" id="curCountry" class="btn-group curCountry">
  	          <input type="hidden" name="country" id="country" value="' . $default_country_id . '"/>
  	          <span class="big_input country_01" >
  	          <div id="your_currency" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
  	          <ul class="dropdown-menu form-horizontal pull-right" id="box4" style="display:none;">
  	          <li>
  	          <ul>
  	          ';


    foreach ($default_countries as $i => $country) {
        $string .= '<li class="">';
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_solution($name = '', $params = '', $default_country_id = 223)
{
    //default countries list
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();

    $keys = array_keys($default_countries);
    $string = '<ul class="countryList">';

    foreach ($default_countries as $i => $country) {
        $string .= '<li class="">';
        $country_name = zen_get_countries_name_by_id($i);
        $warehouse = '';
        $country_iso_code = zen_get_country_iso_code($i);
        if(is_array($params) && in_array('warehouse',$params)){
            $warehouse = get_warehouse_by_code($country_iso_code);
        }
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" tag-warehouse="' . $warehouse . '" ctr="{\'change_to_country\':\'' . $country_iso_code . '\'}"><em class="' . $country_iso_code . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<div class="divider"></div>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $warehouse = '';
            $country_iso_code = zen_get_country_iso_code($country['countries_id']);
            if(is_array($params) && in_array('warehouse',$params)){
                $warehouse = get_warehouse_by_code($country_iso_code);
            }
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" tag-warehouse="' . $warehouse . '" ctr="{\'change_to_country\':\'' . $country_iso_code . '\'}"><em class="flag ' . $country_iso_code . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    //函数里面直接返回国家下拉框核心部分  其余的html 结构在模板中拼接  可适用于不同结构的模板  Yoyo  2019.11.20
    $string .= '</ul>';
//		$string .= '</ul></li></ul>';
//		$string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_new($input_name = 'country', $input_id = "", $default_country_according = 'languages_id', $default_country_id = "", $hide_country = array())
{
    global $db;
    if (!$input_id) {
        $input_id = $input_name;
    }
    $default_countries = zen_get_default_countries_new();
    $keys = array_keys($default_countries);
    //$default_country_id = zen_get_default_country_id();
    //国家选项框变为随动,根据右上角的选择而展示
    if (!$default_country_id) {
        $default_country_id = fs_get_country_id_of_code($_SESSION['countries_iso_code']);
    }

    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $string = '';
    $string .=
        '<div class="ce_form_choose_country">
                        <input type="hidden" name="' . $input_name . '" id="' . $input_id . '" value="' . $default_country_id . '">
                        <em data-class="country_code" class="' . $default_country_code . '" id="currenct_code"></em>
                        <p class="country_name" id="country_show_name">' . $default_country_name . '</p><span class="showMore"></span>
                        <div class="ce_form_searchCountry" style="display: none;">
                            <div class="ce_form_search_block">
                                <input type="text" class="ce_form_search_input" placeholder="' . FS_COUNTRY_SEARCH . '">
                            </div>
                            <ul class="ce_form_countryList">
                      ';
    //group 1
    // 2019-7-25 potato 不用foreach循环查数据，用in
    $country_names = zen_get_countries_name_by_id_new($default_countries);
    $country_codes = zen_get_country_iso_code_new($default_countries);
    foreach ($country_codes as $k => $countries) {
        $web_site_tag = "";
        if ($countries) {
            if (!empty($hide_country) && in_array($countries, $hide_country)) {
                continue;
            }
            $web_site_data = getWebsiteData(['website'], "country_code= '" . $countries . "'", " LIMIT 1");
            $web_site_tag = $web_site_data[0][0];
        }
        $string .= '<li><a class="aclass" href="javascript:void(0);" data-website="' . $web_site_tag . '" tag="' . $k . '"  tag_name="' . $country_names[$k] . '"><em class="' . $countries . '"></em>' . $country_names[$k] . '</a></li>';
    }

    //group 2
    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $web_site_tag = "";
            if ($country['countries_iso_code_2']) {
                if (!empty($hide_country) && in_array($country['countries_iso_code_2'], $hide_country)) {
                    continue;
                }


                $web_site_data = getWebsiteData(['website'], "country_code= '" . $country['countries_iso_code_2'] . "'", " LIMIT 1");
                $web_site_tag = $web_site_data[0][0];

            }
            $string .= '<li><a class="aclass" href="javascript:void(0);" data-website="' . $web_site_tag . '" tag="' . $country['countries_id'] . '"  tag_name="' . $country['countries_name'] . '"><em class="' . strtolower($country['countries_iso_code_2']) . '"></em>' . $country['countries_name'] . '</a></li>';
        }
    }
    $string .= '</ul>';
    $string .= '</div></div>';
    return $string;
}

/**
 *request stock
 */
function zen_draw_countries_request_stock($input_name = 'country', $countries_name, $countries_code_2, $countries_id, $input_id = "")
{
    if (!$input_id) {
        $input_id = $input_name;
    }
    //default countries list
    $default_countries = zen_get_default_countries();

    $keys = array_keys($default_countries);
    $string = '<div class="ce_form_choose_country">
                    <input type="hidden" name="' . $input_name . '" id="' . $input_id . '" value="' . $countries_id . '">
                    <em class=" ' . strtolower($countries_code_2) . '" id="country_show_icon"></em>
                    <p id="country_show_name">' . $countries_name . '</p><span class="showMore"></span>
                    <div class="ce_form_searchCountry" style="display: none;">
                        <div class="ce_form_search_block">
                            <input type="text" class="ce_form_search_input" placeholder="' . FS_COUNTRY_SEARCH . '">
                        </div>
                        <ul class="ce_form_countryList">
                  ';

    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li><a class="aclass" href="javascript:void(0);" tag="' . $i . '"  tag_name="' . $country_name . '"><em class="' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>';
    }

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li><a class="aclass" href="javascript:void(0);" tag="' . $country['countries_id'] . '" tag_name="' . $country['countries_name'] . '"><em class="' . strtolower($country['countries_iso_code_2']) . '"></em>' . $country['countries_name'] . '</a></li>';
        }
    }
    $string .= '</ul>';
    $string .= '</div></div>';
    return $string;
}


/**
 *live chat two country select
 */
function zen_draw_countries_pull_down_add_tag_two($name = '', $params = '', $default_country_id = 223)
{
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $keys = array_keys($default_countries);
    $string = '
  	          <div ctr="{area:country}" id="email_curCountry" class="btn-group curCountry">
  	          <input type="hidden" name="email_country" id="country"/>
  	          <span class="big_input country_01" >
  	          <div id="email_your_currency" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
  	          <ul class="dropdown-menu form-horizontal pull-right" id="email_box4" style="display:none;">
  	          <li>
  	          <ul>
  	          ';
    foreach ($default_countries as $i => $country) {
        $string .= '<li class="">';
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';
    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';

            $string .= ' <a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . strtolower($country['countries_iso_code_2']) . '\'}"><em class="flag ' . strtolower($country['countries_iso_code_2']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_shipping($name = '', $params = '', $default_country_id = 223, $countries_name, $countries_code_2)
{
    //default countries list
    $default_countries = zen_get_default_countries();

    $keys = array_keys($default_countries);
    $string = '
				  <div ctr="{area:country}" id="curCountry1" class="btn-group curCountry">
  	          <input type="hidden" name="countries_iso_code_2" id="countries_iso_code_2"/>
  	          <span class="big_input country_01" >
  	          <div id="your_currency" class="yourCurrency"><em class="flag ' . strtolower($countries_code_2) . '"></em>' . $countries_name . '<span class="caret"></span></div></span>
  	          <ul class="dropdown-menu form-horizontal pull-right" id="box41" style="display:none;">
  	          <li>
  	          <ul>
  	          ';


    foreach ($default_countries as $i => $country) {
        $countries_iso_code_2 = fs_get_data_from_db_fields('countries_iso_code_2', TABLE_COUNTRIES, 'countries_id =' . $i, 'limit 1');
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $countries_iso_code_2 . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_iso_code_2'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

//melo
function zen_draw_countries_pull_down_select_country($name = '', $params = '', $default_country_id = 223)
{

    //default countries list
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);

    $string = '
				  <div ctr="{area:country}" id="SelCountry" class="btn-group curCountry">
				  <input type="hidden" name="countries_iso_code_2" id="countries_iso_code_2"/>
				  <span class="big_input country_01" >
				  <div id="Cus_country" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
				  <ul class="dropdown-menu form-horizontal pull-right" id="Country_box" style="display:none;">
				  <li>
				  <ul>
				  ';

    foreach ($default_countries as $i => $country) {
        $countries_iso_code_2 = fs_get_data_from_db_fields('countries_iso_code_2', TABLE_COUNTRIES, 'countries_id =' . $i, 'limit 1');
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $countries_iso_code_2 . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_iso_code_2'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}


function zen_draw_countries_pull_down_select_new_country($name = '', $params = '', $default_country_id = 223, $countries_iso_code = 'us')
{
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $keys = array_keys($default_countries);
    $string = '
				  <div ctr="{area:country}" id="SelCountry" class="btn-group curCountry">
  	          <input type="hidden" name="countries_iso_code_2" id="countries_iso_code_2"/>
  	          <span class="big_input country_01" >
  	          <div id="Cus_country" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
  	          <ul class="dropdown-menu form-horizontal pull-right" id="Country_box" style="display:none;">
  	          <li>
  	          <ul>
  	          ';

    foreach ($default_countries as $i => $country) {
        $countries_iso_code_2 = fs_get_data_from_db_fields('countries_iso_code_2', TABLE_COUNTRIES, 'countries_id =' . $i, 'limit 1');
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';

        $string .= '<a href="javascript:void(0);" tag="' . $countries_iso_code_2 . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_iso_code_2'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}


function zen_draw_countries_pull_down_add_tag_image($name = 'tagcountry', $params = ' id="tagcountry" class="login_country" ', $default_country_id = 223)
{
    //default countries list
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $keys = array_keys($default_countries);
    $string = '
  	          <div ctr="{area:country}" id="billingCountry" class="btn-group curCountry">
  	          <input type="hidden" name="' . $name . '" value="' . $default_country_id . '" ' . $params . '/>
  	          <span class="big_input country_01" >
  	          <div id="tag_currency" class="yourCurrency"><em class="flag ' . default_country_code . '"></em>' . default_country_name . '<span class="caret"></span></div></span>
  	          <ul class="dropdown-menu form-horizontal pull-right" id="box44" style="display:none;">
  	          <li>
  	          <ul>
  	          ';


    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    // 	iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

/**
 * ======================country name select   tom==================================
 */
function zen_draw_countries_select_name($name = '', $params = '', $default_country_id = 223)
{

    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string .= '<select ' . $params . $params . '>';

    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<option value="' . $i . '" class="flag ' . zen_get_country_iso_code($i) . '">' . $country_name . '</option>';
    }
    $string .= '<option disabled>------------------------</option>';
    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {  /* class="flag '.zen_get_country_iso_code($i).'"*/
            $string .= '<option value="' . $country['countries_id'] . '" class="flag ' . zen_get_country_iso_code($country['countries_id']) . '">' . $country['countries_name'] . '</option>';
        }
    }
    $string .= '</select>';
    return $string;
}

/**
 * *******$options = array("Peter"=>"35","Ben"=>"37","Joe"=>"43")
 */
function zen_draw_select_key_value($name = '', $params = '', $options, $default_option = '- Please select one -')
{
    $string .= '<select name=' . $name . ' ' . $params . '>';
    $string .= '<option value=""></option>';
    foreach ($options as $key => $option) {
        $string .= '<option value="' . $key . '">' . $option . '</option>';
    }
    $string .= '</select>';
    return $string;
}

/**
 * *******$options = array("Peter","Ben","Joe")
 */
function zen_draw_select_value($name = '', $params = '', $options, $default_option = '- Please select one -')
{
    $string .= '<select name=' . $name . ' ' . $params . '>';
    $string .= '<option value=""></option>';
    foreach ($options as $key => $option) {
        $string .= '<option value="' . $option . '">' . $option . '</option>';
    }
    $string .= '</select>';
    return $string;
}

/**
 * *******$options = array("Peter","Ben","Joe")
 */
function zen_draw_select_sort_by_value($name = '', $params = '', $options, $current_category_id)
{
    $string .= '<select name=' . $name . ' ' . $params . '>';
    $string .= '<option value=""></option>';
    if (!isset($page_handler)) {
        $page_handler = FILENAME_DEFAULT;
    }
    foreach ($options as $key => $option) {
        $string .= '<option ' . $str . ' id="' . $key . '" value="' . $key . '" tag="' . zen_href_link($page_handler, '&cPath=' . $current_category_id . '&sort_order=' . $key . '&' . zen_get_all_get_params(array('cPath', 'sort_order')), 'NONSSL') . '">' . $option . '</option>';
    }
    $string .= '</select>';
    return $string;
}

function zen_draw_countries_for_tutorial($name = '', $params = '', $default_country_id = 223, $countries_iso_code = 'us')
{
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $keys = array_keys($default_countries);
    $string = '<div class="choose_tutorial_country" ' . $params . '>' . FS_TUTORIAL_COUNTRY . '
				<span class="tutorial_showMore"></span>
				<div class="tutorial_searchCountry">
				<input type="text" class="tutorial_search_input big_input"  />
				<p class="tutorial_text">' . FS_TUTORIAL_SEARCH . '</p>
				<ul class="tutorial_countryList">';
    foreach ($default_countries as $i => $country) {
        $string .= '<li class="">';
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";

    }
    $string .= '<li class="divider" style="height:0px"></li>';

    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></div></div>';
    return $string;
}


//add by aron 7.17/
function zen_draw_countries_pull_for_checkout_common($name = '', $params = '', $default_country_id = 223, $has_default_country_id = false)
{
    //default countries list
    $default_country_id = !empty($default_country_id) ? $default_country_id : 223;
    $default_countries = zen_get_default_countries();
    //$default_country_id = zen_get_default_country_id();
    //国家选项框变为随动,根据右上角的选择而展示
    if (!$has_default_country_id) {
        $default_country_id = fs_get_country_id_of_code($_SESSION['countries_iso_code']);
    }
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $country_box = $params['country_box'];
    $entry_country_id = $params['entry_country_id'];

    $keys = array_keys($default_countries);
    $string = '
              <div ctr="{area:country}"  class="btn-group curCountry ' . $country_box . '">
              <input type="hidden" name=' . "$name" . '  class="' . $entry_country_id . '" value="' . $default_country_id . '">
              <span class="big_input country_01" >
              <div class="yourCurrency tag_currency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
              <ul class="dropdown-menu form-horizontal pull-right box44" style="display:none;">
							<li><ul>';
    foreach ($default_countries as $i => $country) {
        $code = zen_get_country_iso_code($i);
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="' . $code . '">';
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . $code . '\'}"><em class="flag ' . $code . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    //  iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $code = zen_get_country_iso_code($country['countries_id']);
            $string .= '<li class="' . $code . '">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . $code . '\'}"><em class="flag ' . $code . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_image_checkout($name = '', $params = '', $default_country_id = 223)
{

    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string = '
              <div ctr="{area:country}" id="billingCountry" class="btn-group curCountry">
              <input type="hidden" name=' . "$name" . '  id="entry_country_id"/>
              <span class="big_input country_01" >
              <div  class="yourCurrency tag_currency" id="tag_currency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
              <ul class="dropdown-menu form-horizontal pull-right box44" id="box44" style="display:none;">
              <li><ul>';


    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    //  iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_image_checkout_new($name = '', $params = '', $default_country_id = 223)
{
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string = '
              <div ctr="{area:country}" id="billingCountry_new" class="btn-group curCountry">
              <input type="hidden" name=' . "$name" . '  id="entry_country_id_new" value="' . $default_country_id . '"/>
              <span class="big_input country_01" >
              <div id="tag_currency_new" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
              <ul class="dropdown-menu form-horizontal pull-right" id="box44_new" style="display:none;">
              <li><ul>';

    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    //  iterate countries from db
    $countiries = zen_get_countries_by_code();
    //$string .= '<optgroup label="--------------------------">'."\n";

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_image_checkout_guest($name = '', $params = '', $default_country_id = 223)
{

    //default countries list
    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string = '
              <div ctr="{area:country}" id="billingCountry_popup" class="btn-group curCountry">
              <input type="hidden" name=' . "$name" . '  id="guest_conuntry_id" value=' . $default_country_id . '/>
              <span class="big_input country_01" >
              <div id="tag_currency_popup" class="yourCurrency"><em class="flag ' . $default_country_code . '"></em>' . $default_country_name . '<span class="caret"></span></div></span>
              <ul class="dropdown-menu form-horizontal pull-right" id="box44_popup" style="display:none;">
              <li>
              <ul>
              ';


    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="flag ' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    //group 2
    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="flag ' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div>';
    return $string;
}

function zen_draw_countries_pull_down_add_tag_image_search($arr = array())
{
    if (!empty($arr)) {
        $default_country_code = isset($arr['default_country_code']) ? $arr['default_country_code'] : "us";
        $default_country_name = isset($arr['default_country_name']) ? $arr['default_country_name'] : "United States";
        $search_name = isset($arr['search_name']) ? $arr['search_name'] : FS_COUNTRY_SEARCH;
    }

    //default countries list
    $default_countries = zen_get_default_countries();

    $keys = array_keys($default_countries);
    $string = '<div class="choose_country">
                <em class="' . $default_country_code . '" style="left: 12px;"></em><p>' . $default_country_name . '</p>
                <span class="showMore"></span>
               <div class="searchCountry" style="display: none;">
                 <div class="search_block">
                      <p class="pc_prompt">' . "$search_name " . '</p>
                      <input type="text" class="search_input">
                  </div>
                  <ul class="countryList">';


    foreach ($default_countries as $i => $country) {
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<li class="">';
        $string .= '<a class="countryList_a" href="javascript:void(0);" tag="' . $i . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    //group 2
    $countiries = zen_get_countries_by_code();

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';
            $string .= ' <a class="countryList_a" href="javascript:void(0);" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></div>';

    $string .= '</div>';
    return $string;
}

function zen_draw_countries_for_general($class = '', $params = '', $default_country_id = 223)
{
    $string = '';

    $default_countries = zen_get_default_countries();
    //$default_country_id = zen_get_default_country_id();
    //国家选项框变为随动,根据右上角的选择而展示
    $default_country_id = fs_get_country_id_of_code($_SESSION['countries_iso_code']);
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);

    $keys = array_keys($default_countries);
    $string .= '<div class="' . $class . '_choose_country"><input type="hidden" name="' . $class . '_chooseCountry" ' . $params . ' value="' . $default_country_id . '">';
    $string .= '<em class="' . $default_country_code . '" style="left: 12px;"></em><p>' . $default_country_name . '</p><span class="showMore"></span>';

    $string .= '<div class="' . $class . '_searchCountry" style="display: none;"><div class="' . $class . '_search_block">
		<input type="text" class="' . $class . '_search_input" placeholder="' . FS_COUNTRY_SEARCH . '"></div>';
    $string .= '<ul class="' . $class . '_countryList">';
    foreach ($default_countries as $key => $value) {
        $aclass = 'countryList_a';
        if ($key == $default_country_id) $aclass = $class . '_countryList_a';
        $country_name = zen_get_countries_name_by_id($key);
        $string .= '<li class="">
							<a class="' . aclass . '" href="javascript:void(0);" tag_name="' . $country_name . '" tag="' . $key . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($key) . '\'}"><em class="' . zen_get_country_iso_code($key) . '"></em>' . $country_name . '</a></li>';
    }
    $countiries = zen_get_countries_by_code();
    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">
							<a class="countryList_a" href="javascript:void(0);" tag_name="' . $country['countries_name'] . '" tag="' . $country['countries_id'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>';
        }
    }
    $string .= '</ul>';
    $string .= '</div>';
    $string .= '</div>';
    return $string;
}

//shipping 下拉框
function zen_draw_countries_for_shipping($class = '', $params = '', $default_country_id = 223)
{

    $default_countries = zen_get_default_countries();
    $default_country_id = zen_get_default_country_id();
    $default_country_code = zen_get_country_iso_code($default_country_id);
    $default_country_name = zen_get_countries_name_by_id($default_country_id);
    $keys = array_keys($default_countries);
    $string = '
             <div class="ce_form_choose_country">
                  <input type="hidden" class="change_shipping_country" name="change_shipping_country"  value="">
                  <em class="cn nob" id="icon_shippngs"></em>
                  <p class="country_show_name_shipping" class="show">' . FS_PRODUCTS_SHIPPING_CHANGE15 . '</p>
                  <span class="showMore"></span>
                  <div class="ce_form_searchCountry">
                      <div class="ce_form_search_block">
                          <input type="text" class="ce_form_search_input" placeholder="' . FS_COUNTRY_SEARCH . '">
                      </div>
                      <ul class="ce_form_countryList">';


    foreach ($default_countries as $i => $country) {
        $string .= '<li class="">';
        $country_name = zen_get_countries_name_by_id($i);
        $string .= '<a href="javascript:void(0);" tag="' . $i . '" tag_name="' . $country . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($i) . '\'}"><em class="' . zen_get_country_iso_code($i) . '"></em>' . $country_name . '</a></li>' . "\n";
    }
    $string .= '<li class="divider"></li>';

    $countiries = zen_get_countries_by_code();

    foreach ($countiries as $i => $country) {
        if (!in_array($country['countries_id'], $keys)) {
            $string .= '<li class="">';

            $string .= ' <a href="javascript:void(0);" tag="' . $country['countries_id'] . '" tag_name="' . $country['countries_name'] . '" ctr="{\'change_to_country\':\'' . zen_get_country_iso_code($country['countries_id']) . '\'}"><em class="' . zen_get_country_iso_code($country['countries_id']) . '"></em>' . $country['countries_name'] . '</a></li>' . "\n";
        }
    }
    $string .= '</ul></li></ul>';
    $string .= '</div></div>';
    return $string;
}

/**
 * @function:该函数没有什么意思，只是按照用户分析部的意愿展示图标而已。
 * 该函数在partner/header.php和sample_application/header.php中用到
 * @author:liang.zhu
 * 2019-06-26 10:18:22
 */
function get_icons()
{
    /*开始  add by liang.zhu 控制图标   开始*/
    $temp = $_SESSION['languages_code'];
    $warehouse = get_warehouse_by_code($_SESSION['countries_iso_code']);
    if ($_SESSION['languages_code'] == 'de') {
        $temp = 'dn';
    }
    if ($_SESSION['languages_code'] == 'es') {
        $temp = 'dn';
    }
    if ($_SESSION['languages_code'] == 'fr') {
        if ($warehouse == 'de') {
            $temp = 'dn';
        }
        if ($_SESSION['countries_iso_code'] == 'ca') { //加拿大
            $temp = 'en';
        }
        if ($_SESSION['countries_iso_code'] == 'fr') {
            $temp = 'dn';
        }
    }
    if ($_SESSION['languages_code'] == 'jp') {
        $temp = 'en';
    }
    if ($_SESSION['languages_code'] == 'mx') {
        $temp = 'en';
    }
    if ($_SESSION['languages_code'] == 'ru') {
        if ($warehouse == 'cn') {
            $temp = 'en';
        }
        if ($warehouse == 'de') {
            $temp = 'dn';
        }
    }
    $path = 'includes/templates/fiberstore/images/spanish/Sample_application/images/';
    //默认
    $icon_arr = array('Google.png', 'Microsoft.png', 'Intel.png', 'Cloudflare.png', 'Dell.png', 'Amazon.png');
    switch ($temp) {
        case 'au':
            $icon_arr = array('Google.png', 'Microsoft.png', 'Vocus.png', 'Tpg.png', 'OverTheWire.png', 'Superloop.png',);
            break;
        case 'uk':
            $icon_arr = array('Google.png', 'Microsoft.png', 'Eset.png', 'Virgin.png', 'Gtt.png', 'Mrv.png',);
            break;
        case 'dn':
            $icon_arr = array('Google.png', 'Microsoft.png', 'Cloudflare.png', 'Eset.png', 'Gtt.png', 'Mrv.png');
            break;
        case 'sg':
            $icon_arr = array('Google.png', "Microsoft.png", "Intel.png", "Cloudflare.png", "Dell.png", "Amazon.png");
            break;
        case 'en':
            //默默为en
            $icon_arr = array('Google.png', 'Microsoft.png', 'Intel.png', 'Cloudflare.png', 'Dell.png', 'Amazon.png');
    }
    foreach ($icon_arr as $key => $value) {
        $icon_arr[$key] = $path . $value;
    }
    return $icon_arr;
}

/**
 * @notes :获取每个站点默认显示在前面的国家,不使用switch
 * @author:potato
 * @date  :2019/7/24
 * @return array|mixed
 */
function zen_get_default_countries_new()
{
    $countries = [
        'de' => [
            81 => 'Germany',
            14 => 'Austria',
            204 => 'Switzerland',
            124 => 'Luxembourg',
            21 => 'Belgium',
            105 => 'Italy',
            122 => 'Liechtenstein',
            150 => 'Netherlands',
            57 => 'Denmark',
        ],
        'dn' => [
            81 => 'Germany',
            14 => 'Austria',
            204 => 'Switzerland',
            124 => 'Luxembourg',
            21 => 'Belgium',
            105 => 'Italy',
            122 => 'Liechtenstein',
            150 => 'Netherlands',
            57 => 'Denmark',
        ],
        'fr' => [
            73 => 'France',
            38 => 'Canada',
            21 => 'Belgium',
            204 => 'Switzerland',
            57 => 'Denmark',
            141 => 'Monaco',
            81 => 'Germany',
            222 => 'United Kingdom',
            195 => 'Spain',
        ],
        'ru' => [
            176 => 'Russian Federation',
            220 => 'Ukraine',
            109 => 'Kazakhstan',
            117 => 'Latvia',
            80 => 'Georgia',
            123 => 'Lithuania',
        ],
        'es' => [
            195 => 'Spain',
            250 => 'Canary Islands',
            138 => 'Mexico',
            223 => 'United States',
            30 => 'Brazil',
            47 => 'Colombia',
            10 => 'Argentina',
            43 => 'Chile',
            167 => 'Peru',
        ],
        'mx' => [
            195 => 'Spain',
            250 => 'Canary Islands',
            138 => 'Mexico',
            223 => 'United States',
            30 => 'Brazil',
            47 => 'Colombia',
            10 => 'Argentina',
            43 => 'Chile',
            167 => 'Peru',
        ],
        'jp' => [
            107 => 'Japan',
            223 => 'United States',
            222 => 'United Kingdom',
            38 => 'Canada',
            13 => 'Australia',
            73 => 'France',
            81 => 'Germany',
            195 => 'Spain',
            150 => 'Netherlands',
            176 => 'Russian Federation',
            99 => 'India',
            30 => 'Brazil',
            204 => 'Switzerland',
            105 => 'Italy',
        ],
        'sg' => [
            188 => 'Singapore',
            129 => 'Malaysia',
            100 => 'Indonesia',
            209 => 'Thailand',
            168 => 'Philippines',
            223 => 'United States',
            222 => 'United Kingdom',
            38 => 'Canada',
            13 => 'Australia',
            73 => 'France',
            81 => 'Germany',
            195 => 'Spain',
            150 => 'Netherlands',
            176 => 'Russian Federation',
            99 => 'India',
            30 => 'Brazil',
            204 => 'Switzerland',
            105 => 'Italy',
        ],
        'au' => [
            13 => 'Australia',
            153 => 'New Zealand',
        ],
        'uk' => [
            222 => 'United Kingdom',
            103 => 'Ireland',
            21 => 'Belgium',
            81 => 'Germany',
            73 => 'France',
            195 => 'Spain',
            105 => 'Italy',
            84 => 'Greece',
            150 => 'Netherlands',
            124 => 'Luxembourg',
            57 => 'Denmark',
            171 => 'Portugal',
            14 => 'Austria',
            203 => 'Sweden',
        ],
        'default' => [
            223 => 'United States',
            222 => 'United Kingdom',
            38 => 'Canada',
            13 => 'Australia',
            73 => 'France',
            81 => 'Germany',
            195 => 'Spain',
            150 => 'Netherlands',
            176 => 'Russian Federation',
            99 => 'India',
            30 => 'Brazil',
            204 => 'Switzerland',
            105 => 'Italy',
        ]
    ];
    $default_countries = array_key_exists($_SESSION['languages_code'], $countries) ? $countries[$_SESSION['languages_code']] : $countries['default'];
    return $default_countries;
}

/**
 * @notes :获得国家名称 基于 zen_get_countries_name_by_id 修改
 * @author:potato
 * @date  :2019/7/26
 * @param $country_id
 * @return mixed
 */
function zen_get_countries_name_by_id_new($country_id)
{
    global $db;
    if (!$country_id) $country_id = 223;
    $field_name = zen_get_countries_fields();
    if (is_array($country_id)) {
        $country_ids = array_keys($country_id);
        $country_id = implode(',', $country_ids);
        $sql = "SELECT " . $field_name . ",countries_id FROM `countries` WHERE `countries_id` in ($country_id)";
        $result = $db->getAll($sql);
        foreach ($result as $k => $v) {
            $res[$v['countries_id']] = $v[$field_name];
        }
        return $res;
    } else {
        $result = $db->Execute("SELECT " . $field_name . " FROM `countries` WHERE `countries_id`={$country_id} LIMIT 1");
    }
    $country_name = $result->fields[$field_name];
    return $country_name;
}

function get_select_type_html()
{
    $html = '<div class="custom_select_container after">
                <span class="choose_specifications"><label>' . FSCHOOSE_SPECI . '</label></span>
                <div class="custom_select_right">
                    <span class="custom_select_span active">
                        <label data="0">
                            <i class="iconfont icon custom_select_icon">&#xf021;</i>' . FS_SELECT_DEFAULT . '
                            <input type="radio" name="custom_select">
                        </label>
                        ' . getNewWordHtml(FS_SELECT_TYPE) . '
                    </span>
                    <span class="custom_select_span">
                        <label data="1">
                            <i class="iconfont icon custom_select_icon">&#xf022;</i>' . FS_SELECT_CUSTOMIZE . '
                            <input type="radio" name="custom_select">
                        </label>
                    </span>
                </div>
            </div>';
    return $html;
}

//获取当前站点博客链接 Ternence/2020/1/16
function get_community_url()
{
    $url = "https://community.fs.com/";
    if ($_SESSION['languages_code'] == 'mx') {
        $url .= 'es/';
    } else {
        if (!in_array($_SESSION['languages_code'], array('au', 'en', 'uk', 'dn', 'sg'))) {
            $url .= $_SESSION['languages_code'] . "/";
        }
    }
    return $url;
}

function zen_alert_success()
{
    if ($_SESSION['languages_code'] != 'en') {
        return '';
    }
    return '<div class="review_alert_alone" id="review_alert_alone" style="display: none">
            <input type="hidden" name="orders_review_list">
			<div class="review_alert_alone_bg"></div>
			<div class="review_alert_content review_alert_wd480 ">
				<p class="review_alert_title">
					<span></span>
					<i class="iconfont icon review_alert_closeicon close_review_alert_alone" data-status="2"></i>
				</p>
				<div class="review_alert_imgbox">
					<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-box.png">
				</div>
				<div class="review_alert_popup_content">
					<div class="review_alert_maintxt01">Thanks for your review</div>
					<p class="review_alert_maintxt02">Stay Tuned to Share & Win Activity</p>
					<div class="review_alert_giftlist">
						<div class="review_alert_giftbox">
							<div class="review_alert_giftmian">
								<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-icon2.svg" width="20"><p>Share Your Project with Photos and Stories</p>
							</div>
							<div class="review_alert_giftmian">
								<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-icon1.svg" width="20"><p>Get $20 Gift Card &amp; Win iPhone 12 Pro Max</p>
							</div>
						</div>
					</div>
					<p class="review_alert_maintxt05">(Gift cards can be redeemed within U.S.)</p>
					<p class="review_alert_maintxt03">Coming Soon: 2020.11.20 - 2021.2.20</p>
					<div class="review_alert_btnbox">
						<button type="button" class="review_alert_btn01 fs-comSub-loadBtn close_review_alert_alone" data-status="1">
						    <span class="fs-comSub-loadBtn_txt">Got it! </span>
						    <div class="loader_order">
		                        <svg class="circular" viewBox="25 25 50 50">
		                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
		                        </svg>
		                    </div>
						</button><br>
						<button type="button" data-status="2" class="review_alert_btn02 close_review_alert_alone">
							No, thanks
						</button>
					</div>
					<p class="review_alert_maintxt04 close_review_alert_alone" data-status="3">
					    <span>Do not show me this again</span>
					</p>
				</div>
			</div>
		</div>';
}

function zen_alert_writing()
{
    if ($_SESSION['languages_code'] != 'en') {
        return '';
    }
    return '<div class="review_alert_alone" id="review_alert_alone">
			<div class="review_alert_alone_bg"></div>
			<div class="review_alert_content review_alert_wd480 ">
				<p class="review_alert_title">
					<span></span>
					<i class="iconfont icon review_alert_closeicon close_review_alert_alone" data-status="2"></i>
				</p>
				<div class="review_alert_imgbox">
						<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-box.png">
					</div>
				<div class="review_alert_popup_content review_alert_popup_first">
				
					<div class="review_alert_maintxt01">Writing reviews</div>
					<div class="review_alert_giftlist">
						<div class="review_alert_giftbox">
							<div class="review_alert_giftmian">
								<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-icon3.svg" width="22"><p>Get Privilege for Share & Win Activity</p>
							</div>
							<div class="review_alert_giftmian">
								<img src="'.HTTPS_PRODUCTS_SERVER.'images/popup-icon1.svg" width="20"><p>Get $20 Gift Card &amp; Win iPhone 12 Pro Max</p>
							</div>
						</div>
					</div>
					<p class="review_alert_maintxt05">(Gift cards can be redeemed within U.S.)</p>
					<p class="review_alert_maintxt03">Coming Soon: 2020.11.20 - 2021.2.20</p>
					<div class="review_alert_btnbox">
						<button type="button" class="review_alert_btn01 fs-comSub-loadBtn close_review_alert_alone" data-status="1">
						    <span class="fs-comSub-loadBtn_txt">Learn More &amp; Join</span>
						    <div class="loader_order">
		                        <svg class="circular" viewBox="25 25 50 50">
		                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
		                        </svg>
		                    </div>
						</button><br>
						<button type="button" data-status="2" class="review_alert_btn02 close_review_alert_alone">
							No, thanks
						</button>
					</div>
					<p class="review_alert_maintxt04 close_review_alert_alone" data-status="3">
					    <span>Do not show me this again</span>
					</p>
				</div>
			</div>
		</div>';
}

function sourceHtml($str, $type = true)
{
    $data = [
        'twitter' => 'https://twitter.com/FSCOM_official',
        'facebook' => 'https://www.facebook.com/FSCOMofficial/',
        'youtube' => 'https://www.youtube.com/c/fscom_official/videos',
        'linkedin' => 'https://www.linkedin.com/company/fscomofficial/',
        'instagram' => 'https://www.instagram.com/fscom_official/',
        'pinterest' => 'https://www.pinterest.com/FSCOM_official/_created/',
    ];

    if ($type) {
        echo $data[$str];
    } else {
        return $data[$str];
    }
}