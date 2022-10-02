<?php
/**
 * split_page_results Class.
 *
 * @package classes
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: split_page_results.php 17066 2010-07-29 19:18:14Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * Split Page Result Class
 *
 * An sql paging class, that allows for sql reslt to be shown over a number of pages using  simple navigation system
 * Overhaul scheduled for subsequent release
 *
 * @package classes
 */

class splitPageResults extends base {
  var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page, $page_name;

  /* class constructor */
    function splitPageResults($query, $max_rows, $count_key = '*', $page_holder = 'page', $debug = false, $is_reviews = 1, $list_w_data = [])
    {
        global $db;
        if ($is_reviews == 2) {
            $max_rows = ($max_rows == '' || $max_rows == 0) ? 20 : $max_rows;
        } else {
            $max_rows = ($max_rows == '' || $max_rows == 0) ? 20 : $max_rows;
        }

        $this->sql_query = preg_replace("/\n\r|\r\n|\n|\r/", " ", $query);
        $this->page_name = $page_holder;

        if ($debug) {
            echo 'original_query=' . $query . '<br /><br />';
        }
        if (isset($_GET[$page_holder])) {
            $page = $_GET[$page_holder];
        } elseif (isset($_POST[$page_holder])) {
            $page = $_POST[$page_holder];
        } else {
            $page = '';
        }

        if (empty($page) || !is_numeric($page)) $page = 1;
        $this->current_page_number = $page;

        $this->number_of_rows_per_page = $max_rows;

        $pos_to = strlen($this->sql_query);

        $query_lower = strtolower($this->sql_query);
        $pos_from = strpos($query_lower, ' from', 0);

        $pos_group_by = strpos($query_lower, ' group by', $pos_from);
        if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

        $pos_having = strpos($query_lower, ' having', $pos_from);
        if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

        $pos_order_by = strpos($query_lower, ' order by', $pos_from);
        if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

        if (strpos($query_lower, 'distinct') || strpos($query_lower, 'group by')) {
            $count_string = 'distinct ' . zen_db_input($count_key);
        } else {
            $count_string = zen_db_input($count_key);
        }
        $count_query = "select count(" . $count_string . ") as total " .
            substr($this->sql_query, $pos_from, ($pos_to - $pos_from));
        if ($debug) {
            echo 'count_query=' . $count_query . '<br /><br />';
        }
        $count = $db->Execute($count_query);

        $this->number_of_rows = $count->fields['total'];

        if(!empty($list_w_data)){
            $this->number_of_rows += count($list_w_data);
        }

        $this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

        if ($this->current_page_number > $this->number_of_pages) {
            $this->current_page_number = $this->number_of_pages;
        }

        $offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

        // fix offset error on some versions
        if ($offset <= 0) {
            $offset = 0;
        }

        //分类列表页加入了瀑布流数据之后的判断
        if(!empty($list_w_data)){
            $limit_str = getListSqlLimitStr($list_w_data, $page, $max_rows);
            $this->sql_query .= $limit_str;
        }else{
            $this->sql_query .= " limit " . ($offset > 0 ? $offset . ", " : '') . $this->number_of_rows_per_page;
        }
    }

  /* class functions */

  function display_links_top($parameters = ''){
  	global $request_type;
  	$display_links_string_top = '';

  	if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';


  	if ($this->current_page_number > 1) $display_links_string_top .= '<a class="previous_page" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;&nbsp;'; else $display_links_string_top .= '<span class="previous_page">'.PREVNEXT_BUTTON_PREV .'</span>&nbsp;&nbsp;';
  	if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string_top .= '&nbsp;<a class="next_page" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>&nbsp;&nbsp;';else $display_links_string_top .= '<span class="next_page">'.PREVNEXT_BUTTON_NEXT .'</span>';
  	 return $display_links_string_top ;
  	 //echo PREVNEXT_BUTTON_NEXT;
  }
  /**
   * **********************************tom extra page link
   * Enter description here ...
   * @param unknown_type $max_page_links
   * @param unknown_type $parameters
   */
 	function display_top_links_extra($max_page_links, $parameters = '') {
	 	global $request_type;
	    $display_links_string = '';

	    $first = 1; $class = '';
	    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

	    // previous button - not displayed on first page
	    if ($this->current_page_number > 1) $display_links_string .= '<a class="previous_page" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;';else $display_links_string .= '<span class="previous_page">'.PREVNEXT_BUTTON_PREV .'</span>&nbsp;';

	    if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '<a class="next_page" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>';else $display_links_string .= '&nbsp;<span class="next_page">'.PREVNEXT_BUTTON_NEXT .'</span>';

	    return $display_links_string;
  }
  // display split-page-number-links
  function display_links($max_page_links, $parameters = '') {
    global $request_type;
    $display_links_string = '';

    $first = 1; $class = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    // previous button - not displayed on first page
    if ($this->current_page_number > 1) $display_links_string .= '<a class="previous_page" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a>&nbsp;';else $display_links_string .= '<span class="previous_page">'.PREVNEXT_BUTTON_PREV .'</span>';

    // check if number_of_pages > $max_page_links
    $cur_window_num = intval($this->current_page_number / $max_page_links);
    if ($this->current_page_number % $max_page_links) $cur_window_num++;

    $max_window_num = intval($this->number_of_pages / $max_page_links);
    if ($this->number_of_pages % $max_page_links) $max_window_num++;

    // previous window of pages
    //if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>';
    //echo 1;
    if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $first, $request_type) . '">'.$first.'</a>&nbsp;&nbsp;...';

    // page nn button
    for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
    	if ($jump_to_page == $this->current_page_number) {
    		if ($this->current_page_number == $max_page_links+1){
    			$display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '='.$max_page_links, $request_type) . '">'.$max_page_links.'</a>
	      							  &nbsp;<i>' . $jump_to_page . '</i>&nbsp;';
    		}else{
    			$display_links_string .= '&nbsp;<i>' . $jump_to_page . '</i>&nbsp;';
    		}

    	} else {
    		if ($this->current_page_number == $max_page_links){
    			if ($jump_to_page != 1) $display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>&nbsp;';
	      }else $display_links_string .= '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>&nbsp;';

      }
    }
    // next window of pages
    // if ($cur_window_num < $max_window_num) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>&nbsp;';

    if ($cur_window_num < $max_window_num)
	    if ($this->current_page_number == $max_page_links){
	    	$display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '">'.$jump_to_page.'</a>
	        					&nbsp;...&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '">'.$this->number_of_pages.'</a>&nbsp;';
	    }else $display_links_string .= '...&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '">'.$this->number_of_pages.'</a>&nbsp;';
    // next button
    if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '&nbsp;<a class="next_page" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>&nbsp;';
    else $display_links_string .= '<span class="next_page">'.PREVNEXT_BUTTON_NEXT .'</span>';


    if ($display_links_string == '&nbsp;<a class="first" href="javascript:void(0);">1</a>&nbsp;') {
      return '';
    } else {
      return $display_links_string;
    }
  }

  function display_links_case_number($max_page_links, $parameters = '') {
      global $request_type;
      $display_links_string = '';

      $first = 1; $class = '';

      if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

      // previous button - not displayed on first page
      if ($this->current_page_number > 1){
          $display_links_string .= '<div class="new_right_l"><a class="previous_page" href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' .'<i class="iconfont icon"></i>Previous' . '</a></div>';
      } else {
          $display_links_string .= '<div class="new_right_l active"><a href="javascript:;"><i class="iconfont icon"></i>Previous</a></div>';
      }

      // check if number_of_pages > $max_page_links
      $cur_window_num = intval($this->current_page_number / $max_page_links);
      if ($this->current_page_number % $max_page_links) $cur_window_num++;

      $max_window_num = intval($this->number_of_pages / $max_page_links);
      if ($this->number_of_pages % $max_page_links) $max_window_num++;
      $display_links_string .= '<div class="new_f_middle">';
      // previous window of pages
      //if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>';
      //echo 1;
      if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $first, $request_type) . '">'.'<span>1</span></a>';

      // page nn button
      for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
          if ($jump_to_page == $this->current_page_number) {
              if ($this->current_page_number == $max_page_links+1){
                  $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '='.$max_page_links, $request_type) . '">'.$max_page_links.'</a>
	      							  <span class="active">' . $jump_to_page . '</span>';
              }else{
                  $display_links_string .= '<span>' . $jump_to_page . '</span>';
              }
          } else {
              if ($this->current_page_number == $max_page_links){
                  if ($jump_to_page != 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>';
              }else{
                  $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a>';
              }
          }
      }

      if ($cur_window_num < $max_window_num)
          if ($this->current_page_number == $max_page_links){
              $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '">'.$jump_to_page.'</a>
	        					<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '">'.$this->number_of_pages.'</a>';
          }else {
              $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '">'.$this->number_of_pages.'</a>';
          }
      $display_links_string .= '</div>';
      // next button
      $display_links_string .= '<div class="new_right_r">';
      if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)){
          $display_links_string .= '<a class="next_page" href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a>';
      } else {
          $display_links_string .= '<span class="next_page">Next<i class="iconfont icon"></i></span>';
      }
      $display_links_string .= '</div>';

      if ($display_links_string == '<a class="first" href="javascript:void(0);">1</a>') {
          return '';
      } else {
          return $display_links_string;
      }
    }

  // display number of total products found
  function display_count($text_output) {
    $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
    if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

    $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

    if ($to_num == 0) {
      $from_num = 0;
    } else {
      $from_num++;
    }

    if ($to_num <= 0) {
      // don't show count when 1
      return '';
    }

    else {
      return sprintf($text_output, $from_num, $to_num, $this->number_of_rows);
    }
  }

/**
 * ****************page up & page down******************
 */
  function display_page_count($text_output) {
    $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
    if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

    $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

    if ($to_num == 0) {
      $from_num = 0;
    } else {
      $from_num++;
    }

	if (($this->number_of_rows)/36 != 0){
		$page_count = ($this->number_of_rows)/36 + 1;
	}else $page_count = ($this->number_of_rows)/36;

    if ($to_num <= 1) {
      // don't show count when 1
      return '';
    } else {
      return sprintf($text_output, $this->number_of_rows, $this->current_page_number, $page_count);
    }
  }

  /**
   *
   * this would look like this: page 1 of 12
   * @param unknown_type $text_out
   */
  function get_current_page_of_total_page($text_out){
  	 return sprintf($text_out,$this->current_page_number,$this->number_of_pages);
  }

  function get_current_page_of_total_page_end($text_out){
  	return sprintf($this->number_of_pages);
  }

function no_current_display_links($max_page_links, $parameters = '') {
    global $request_type,$current_page;
    $display_links_string = '';

    $class = '';

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    // previous button - not displayed on first page
    //if ($this->current_page_number > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><span class="prev_page">' . PREVNEXT_BUTTON_PREV . '</span></a>';

    // check if number_of_pages > $max_page_links
    $cur_window_num = intval($this->current_page_number / $max_page_links);
    if ($this->current_page_number % $max_page_links) $cur_window_num++;

    $max_window_num = intval($this->number_of_pages / $max_page_links);
    if ($this->number_of_pages % $max_page_links) $max_window_num++;

    // previous window of pages
    //if ($cur_window_num > 1) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>';

    // page nn button
    for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
      if ($jump_to_page == $this->current_page_number) {
        $display_links_string .= '&nbsp;<a href="'. HTTP_SERVER.DIR_WS_CATALOG.$current_page.'/'.$_GET['letter'].'/'.$jump_to_page.'.html" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' "><span class="current">' . $jump_to_page . '</span></a>';
      } else {
        $display_links_string .= '&nbsp;<a href="'. HTTP_SERVER.DIR_WS_CATALOG.$current_page.'/'.$_GET['letter'].'/'.$jump_to_page.'.html" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' "><span>' . $jump_to_page . '</span></a>';
      }
    }

    // next window of pages
    //if ($cur_window_num < $max_window_num) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a>&nbsp;';
   // if ($cur_window_num < $max_window_num) $display_links_string .= '&nbsp;...&nbsp;&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $this->number_of_pages, $request_type) . '">'.$this->number_of_pages.'</a>';

    // next button
    //if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' "><span class="next_page">' . PREVNEXT_BUTTON_NEXT . '</span></a>';

    if ($display_links_string == '&nbsp;<a href="' . zen_href_link($_GET['main_page'], $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' "><span class="current">1</span></a>&nbsp;') {
      return '&nbsp;';
    } else {
      return $display_links_string;
    }
  }







    function display_top_links_listing($max_page_links, $parameters = '') {
    global $request_type;
    $display_links_string = '';

  if( $this->number_of_pages > 1  ){

    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

    $display_links_string .= '<div class="new_page_prev">';

    if ($this->current_page_number > 1)
	    $display_links_string .= '<a  href="' . zen_href_link($_GET['main_page'], $parameters .
	                             $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '"
	                             title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i></i></a>';
    else $display_links_string .= '<span><i></i></span>' ;

    $display_links_string .= '</div>';

    $display_links_string .= '<div class="new_page_next">';

    if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
         $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' "><i></i></a>';
    else $display_links_string .= '<span><i></i></span>' ;

    $display_links_string .= '</div>';

    $display_links_string .= 'Page '.$this->current_page_number;

  }
      return $display_links_string;
  }

    function display_links_listing($max_page_links, $parameters = '') {
        global $request_type;
        $display_links_string = '';

        if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

        $display_links_string .= '<div class="new_page_prev">';

        if ($this->current_page_number > 1)
            $display_links_string .= '<a  href="' . zen_href_link($_GET['main_page'], $parameters .
                    $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '"
	                             title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i></i>' . PREVNEXT_BUTTON_PREV . '</a>';
        else $display_links_string .= '<span><i></i>'.PREVNEXT_BUTTON_PREV .'</span>';

        $display_links_string .= '</div>';

        $display_links_string .= '<div class="new_page_next">';

        if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
            $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '<i></i></a>';
        else $display_links_string .= '<span>'.PREVNEXT_BUTTON_NEXT.'<i></i></span>' ;

        $display_links_string .= '</div>';

        $display_links_string .= '<div class="new_page_center">Page '.$this->current_page_number;
        $display_links_string .= ' of '.$this->number_of_pages.'</div>';

        return $display_links_string;
    }

    function display_links_listing_finder($max_page_links, $parameters = '') {
        global $request_type;
        $display_links_string = '';

        if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';

        $display_links_string .= '<div class="new_page_prev">';

        if ($this->current_page_number > 1)
            $display_links_string .= '<a  href="' . zen_href_link($_GET['main_page'], $parameters , $request_type) .'&'.
                $this->page_name . '=' . ($this->current_page_number - 1). '"
	                             title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i></i>' . PREVNEXT_BUTTON_PREV . '</a>';
        else $display_links_string .= '<span><i></i>'.PREVNEXT_BUTTON_PREV .'</span>';

        $display_links_string .= '</div>';

        $display_links_string .= '<div class="new_page_next">';

        if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
            $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters , $request_type) . '&page=' . ($this->current_page_number + 1). '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '<i></i></a>';
        else $display_links_string .= '<span>'.PREVNEXT_BUTTON_NEXT.'<i></i></span>' ;

        $display_links_string .= '</div>';

        $display_links_string .= '<div class="new_page_center">Page '.$this->current_page_number;
        $display_links_string .= ' of '.$this->number_of_pages.'</div>';

    return $display_links_string;
  }

  //helun 2018.7.2
  function display_links_listing_new($max_page_links, $parameters = '', $ajax = 0, $page_count='') {
    global $request_type;
    $display_links_string = '';
    if (zen_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
    $page_num = $this->number_of_pages;
    if($page_count == ''){
        $page = $this->current_page_number;
    }else{
        $page = $page_count;
    }

    //初始化数据
    $start = 1;
    $end = $this->number_of_pages;
    //第一页显示数量
    $showPage = 5;
    //中间显示数量以及偏移量
    $cenPage = 3;
    $pageoffset = ($cenPage -1)/2;
    if($page_num > $showPage){
      //中间循坏输出
      if($page >= $showPage && $page <= $page_num -$cenPage) {
        $start = $page - $pageoffset;
        $start = (int)$start;
        $end = $page_num >$page + $pageoffset ? $page + $pageoffset :$page_num;
        $end = (int)$end;
      }else{
        //起始循坏
        $start = 1;
        $end = $page_num > $showPage ? $showPage : $page_num;
        $end = (int)$end;
      }
      //结尾循坏
      if ($page > $page_num -$cenPage && $page >= $showPage) {
        $start = $page_num -$cenPage;
        $end = $page_num;
      }
    }
    if($page){
      $next_page = $page+1;
      $prev_page = $page-1;
    }else{
      $next_page = 2;
    }
    if($end <2){
        $class = 'style = "display:none;"';
    }
    $display_links_string .= '<div class="FS_Newpation_box" '.$class.'>';
    if($ajax == 1){
        if ($page && $page!=1)
            $display_links_string .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" onclick="ajax_case_page('.$prev_page.')" data = "'.$prev_page.'"><i class="iconfont icon">&#xf090;</i></a>';
        else $display_links_string .= '<a href="javascript:;" class="list_Newpro_page choosez"><i class="iconfont icon">&#xf090;</i></a>';
        $display_links_string .= '<ul class="FS_Newpation_cont">';
        if($start >1){
            $display_links_string .= '<li class="FS_Newpation_item" onclick="ajax_case_page(1)"><a href="javascript:;"
                class="the_page" data="1">1</a></li>';
        }
        if($page >=$showPage && $page_num>$showPage){
            $display_links_string .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page" data="0">...</span>
                       </li>';
        }
        if($page){
            for($i=$start;$i<=$end;$i++){
                if($i==$page){
                    $display_links_string .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;"
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                }else{
                    $display_links_string .= '<li class="FS_Newpation_item" onclick="ajax_case_page('.$i.')">
                    <a href="javascript:;"
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                }
            }
        }
        if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
            $display_links_string .= '<li class="FS_Newpation_item omit">
                           <span href="javascript:;" class="the_page">...</span>
                       </li>';
        }
        if($end <= $page_num-1){
            $display_links_string .= '<li class="FS_Newpation_item" onclick="ajax_case_page('.$page_num.')">
                    <a href="javascript:;"
                              class="the_page" data = "'.$page_num.'">'.$page_num.'</a></li>';
        }
        $display_links_string .= '</ul>';
        if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
            $display_links_string .= '<a href="javascript:;" onclick="ajax_case_page('.$next_page.')" class="list_Newnext_page not_first_page"><i class="iconfont icon">&#xf089;</i></em></a>';
        else $display_links_string .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="'.$next_page.'"><i class="iconfont icon">&#xf089;</i></em></a>';
    }else{
        if ($page && $page!=1)
            $display_links_string .= '<a  href="' . zen_href_link($_GET['main_page'], $parameters .
                    $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" class="list_Newpro_page not_first_page" onclick="spinloader()" data = "'.$prev_page.'"><i class="iconfont icon">&#xf090;</i></a>';
        else $display_links_string .= '<a href="javascript:;" class="list_Newpro_page choosez"><i class="iconfont icon">&#xf090;</i></a>';
        $display_links_string .= '<ul class="FS_Newpation_cont">';
        if($start >1){
            $display_links_string .= '<li class="FS_Newpation_item" onclick="spinloader()"><a href="' . zen_href_link($_GET['main_page'], $parameters .
                    $this->page_name . '=' . (1), $request_type) . '"
                class="the_page" data="1">1</a></li>';
        }
        if($page >=$showPage && $page_num>$showPage){
            $display_links_string .= '<li class="FS_Newpation_item omit">
                           <span href="javascript::" class="the_page" data="0">...</span>
                       </li>';
        }
        if($page){
            for($i=$start;$i<=$end;$i++){
                if($i==$page){
                    $display_links_string .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;"
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                }else{
                    $display_links_string .= '<li class="FS_Newpation_item" onclick="spinloader()">
                    <a href="' . zen_href_link($_GET['main_page'], $parameters .
                            $this->page_name . '=' . ($i), $request_type) . '"
                              class="the_page" data = "'.$i.'">'.$i.'</a></li>';
                }
            }
        }
        if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
            $display_links_string .= '<li class="FS_Newpation_item omit">
                           <span href="javascript::" class="the_page">...</span>
                       </li>';
        }
        if($end <= $page_num-1){
            $display_links_string .= '<li class="FS_Newpation_item" onclick="spinloader()">
                    <a href="' . zen_href_link($_GET['main_page'], $parameters .
                    $this->page_name . '=' . ($page_num), $request_type) . '"
                              class="the_page" data = "'.$page_num.'">'.$page_num.'</a></li>';
        }
        $display_links_string .= '</ul>';
        if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1))
            $display_links_string .= '<a href="' . zen_href_link($_GET['main_page'], $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" onclick="spinloader()" class="list_Newnext_page not_first_page"><i class="iconfont icon">&#xf089;</i></em></a>';
        else $display_links_string .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="'.$next_page.'"><i class="iconfont icon">&#xf089;</i></em></a>';
    }

    $display_links_string .= '</div>';
    return $display_links_string;
  }
}
