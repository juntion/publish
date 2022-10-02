<?php
/**
 * breadcrumb Class.
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: breadcrumb.php 3147 2006-03-10 00:43:57Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

/**
 * The following switch simply checks to see if the setting is already defined, and if not, sets it to true
 * If you desire to have the older behaviour of having all product and category items in the breadcrumb be shown as links
 * then you should add a define() for this item in the extra_datafiles folder and set it to 'false' instead of 'true':
 */
if (!defined('DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM')) define('DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM','true');

/**
 * breadcrumb Class.
 * Class to handle page breadcrumbs
 *
 * @package classes
 */
class breadcrumb extends base {
  var $_trail;

  function breadcrumb() {
    $this->reset();
  }

  function reset() {
    $this->_trail = array();
  }

  function add($title, $link = '', $cID ='') {
    $this->_trail[] = array('title' => $title, 'link' => $link, 'cID' => $cID);
  }

    function addText($text){
        $trail_string = '';
        $trail_string .= '<div class="menu_list_new">
        				<dl class="menu_list_cont">';
        $trail_string .= '<dt class="back_Home">
                		<meta itemprop="title" content="Home">';
        $trail_string .= '<a itemprop="url" href="' .zen_href_link(FILENAME_DEFAULT) . '">
                   		<span>'.HEADER_TITLE_CATALOG.'</span><i></i>
                		</a>
            			</dt>';
        $trail_string.= '<dd class="Home_next">
                    <span>' . $text . '</span>
                </dd>';
        $trail_string .= '</dl></div>';
        return $trail_string;
    }

	function product_list_new($id=''){
		global $db;
		//新列表页面包屑
		$trail_string = '';
		$trail_string .= '<div class="menu_list_new">
        				<dl class="menu_list_cont">';
		$trail_string .= '<dt class="back_Home">
                		<meta itemprop="title" content="Home">';
		$trail_string .= '<a itemprop="url" href="' .zen_href_link(FILENAME_DEFAULT) . '">
                   		<span>'.HEADER_TITLE_CATALOG.'</span><i></i>
                		</a>
            			</dt>';
		if($id != ''){
		    //is_clearance =1 是清仓产品分类
			$clearance_sql = $db->Execute("select t.products_type,c.clearance_id,c.products_id from products_clearance AS c LEFT JOIN products_clearance_type AS t ON c.clearance_id = t.clearance_id where products_id = ".$id." AND t.is_clearance =1 and languages_id =".$_SESSION['languages_id']);
			$clearance_products_type = $clearance_sql->fields['products_type'];
            $clearance_id = $clearance_sql->fields['clearance_id'];

		}
		if(!$clearance_products_type){
			for ($i = 0, $n = sizeof($this->_trail); $i < $n; $i++) {
				if($this->_trail[$i]['cID'] != NULL) {
                    $style = "";
				    //if(in_array($_SESSION['languages_code'],array('jp','ru'))){
                    //    $categories_name = strip_tags((strlen($this->_trail[$i]['title']) > 0) ? mb_substr($this->_trail[$i]['title'], 0, 40, 'utf-8') . '' : $this->_trail[$i]['title']);
                    //}else{
                        //uk/au转换成英式英语
                        if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
                            $this->_trail[$i]['title'] = swap_american_to_britain( $this->_trail[$i]['title']);
                        }
                    //    $categories_name = strip_tags((strlen($this->_trail[$i]['title']) > 0) ? mb_substr($this->_trail[$i]['title'], 0, 30, 'utf-8') . '' : $this->_trail[$i]['title']);
                    //}

					if($_GET['main_page'] != 'product_info'){
						if($i != $n-1){
							$trail_string .= '<dd class="Home_next" '.$style.'>
							<a href="' . $this->_trail[$i]['link'] . '">
								<span>' . $this->_trail[$i]['title'] . '</span>
							</a>
							</dd>';
						}else{
                            $trail_string .= '<dd class="Home_next" '.$style.'>
								<span>' . $this->_trail[$i]['title'] . '</span>
							</dd>';
						    //分类面包屑分类下拉 要求去掉了
//                            $cPath_arr = (array_reverse(get_category_parent_id($this->_trail[$i]['cID'],array())));
//                            $where_clear = ' and is_clearing = 0 ';
//                            if (3 > sizeof($cPath_arr)){
//                                if (2 == sizeof($cPath_arr)) {
//                                    if (zen_has_category_subcategories($cPath_arr[1])) {
//                                        $categories_arr = zen_get_subcategories_of_one_category($cPath_arr[1],$where_clear);
//                                    }
//                                }
//                            }else{
//                                if(sizeof($cPath_arr) == 3){
//                                    if (zen_has_category_subcategories($cPath_arr[1])) {
//                                        $categories_arr = zen_get_subcategories_of_one_category($cPath_arr[1],$where_clear);
//                                    }
//                                }else{
//                                    if (zen_has_category_subcategories($cPath_arr[2])) {
//                                        $categories_arr = zen_get_subcategories_of_one_category($cPath_arr[2], $where_clear);
//                                    }
//                                }
//                            }
//                            $trail_string .= '<dd class="Home_next">
//							<span class="new_proList_proDrop"><i>'.$this->_trail[$i]['title'].'</i>
//								<span class="iconfont icon">&#xf087;</span>
//								<div class="popularity_view_listz_arrow"></div>
//								<div class="popularity_view_listz">
//	                                <ol>';
//                            if(sizeof($categories_arr)>0){
//                                foreach ($categories_arr as $ii => $cID){
//                                    if($categories_arr[1] == 899){
//                                        $href = zen_href_link(FILENAME_DEFAULT, 'cPath=1120');
//                                        $show_name = zen_get_categories_name(1120);
//                                    }else{
//                                        $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
//                                        $show_name = zen_get_categories_name($cID);
//                                    }
//                                    if($this->_trail[$i]['cID'] == $cID){
//                                        $trail_string .= '<li class="choosez">'.$show_name.'</li>';
//                                    }else{
//                                        $trail_string .= '<li><a href="'.$href.'">'.$show_name.'</a></li>';
//                                    }
//                                }
//                            }
//							$trail_string .= '</ol></div></span></dd>';
						}
					}else{
						$trail_string .= '<dd class="Home_next" '.$style.'>
							<a href="' . $this->_trail[$i]['link'] . '">
								<span>' . $this->_trail[$i]['title'] . '</span>
							</a>
							</dd>';
					}
				}
			}
		}else{
			$trail_string .= '<dd class="Home_next">
							<a href="'.zen_href_link(FILENAME_CLEARANCE).'">
								<span>' . HEADER_TITLE_CLEARANCE . '</span>
							</a>
							</dd>
							<dd class="Home_next">
							<a href="'.zen_href_link(FILENAME_CLEARANCE_LIST,'type='.$clearance_id).'">
								<span>' . $clearance_products_type . '</span>
							</a>
							</dd>';
		}
        if($_GET['main_page'] == 'product_info' && isset($id)){
            $first_category_id = $this->_trail[1]?$this->_trail[1]['cID']:'';
            $trail_string .= '<dd class="Home_next move_href_product">
								<span>' . $id . '</span>
							</dd>';
        }

        if($_GET['main_page'] == FILENAME_ADVANCED_SEARCH_RESULT){
            for ($i = 0, $n = sizeof($this->_trail); $i < $n; $i++) {

                if ($i == ($n - 1)) {
                $trail_string .= '<dd class="Home_next">
								<span>' . $this->_trail[$i]['title'] . '</span>
							</dd>';
                }
            }
        }
        if($_GET['main_page'] == FILENAME_PRODUCT_INFO){
            if ($_GET['products_id']){
                $products_id = (int)$_GET['products_id'];
            }else{
                $products_id = 0;
            }
            $products_name = $db->Execute("select products_name from  ". TABLE_PRODUCTS_DESCRIPTION."  where products_id = '$products_id'")->fields['products_name'];
            $trail_string .= '</dl>
        </div>';
        }else{
            $trail_string .= '</dl></div>';
        }

		return $trail_string;
	}

	function trail($separator = '&nbsp;&nbsp;')
	{
		if ($_GET['main_page'] == 'index' && $this->_trail[2]['cID'] != NULL || $_GET['main_page'] == 'product_info' || $_GET['main_page'] == FILENAME_ADVANCED_SEARCH_RESULT || $_GET['main_page'] == FILENAME_SUBMIT_REVIEW) {
			return $this->product_list_new($_GET['products_id']);
		}elseif($_GET['main_page']=="inquiry"){
            return $this->addText(FS_QUOTE_INFO_12);
        }elseif(in_array($_GET['main_page'],["question_list","products_support"])){
		    return $this->trail_new('');
        } else {
			//fallwind	2017.2.21
            $extra_class = '';
            if(in_array($_GET['main_page'],array('customer_qa','qa_list'))){
                $extra_class = ' menu_02_eidt';
            }elseif ($_GET['main_page'] == FILENAME_PAGE_NOT_FOUND){
                $extra_class = ' menu_list_cont';
            }
			if ($_GET['main_page'] == 'support_detail') {
				$trail_string = '<div class="menu_02 breadcrumb-container support_menu"><dl class="breadcrumb" id="site-breadcrumb">';
			} else {
                $addStyle = '';
			    if ($_GET['main_page'] == 'solution_info'){
			        $addStyle = 'style="display: none;"';
                }
				$trail_string = '<div class="menu_02 breadcrumb-container'.$extra_class.'"><dl class="breadcrumb" id="site-breadcrumb" '.$addStyle.'>';
			}

			//$trail_string = '<div class="menu_02 breadcrumb-container"><dl class="breadcrumb" id="site-breadcrumb">';
			global $db, $cPath_array;
			//var_dump($this->_trail);

			for ($i = 0, $n = sizeof($this->_trail); $i < $n; $i++) {
//    echo 'breadcrumb ' . $i . ' of ' . $n . ': ' . $this->_trail[$i]['title'] . '<br />';

				$skip_link = false;
				if ($i == ($n - 1) && DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM == 'true') {
					$skip_link = true;
				}
				if (isset($this->_trail[$i]['link']) && zen_not_null($this->_trail[$i]['link']) && !$skip_link) {
					// this line simply sets the "Home" link to be the domain/url, not main_page=index?blahblah:
					if ($this->_trail[$i]['title'] == HEADER_TITLE_CATALOG) {
						//$trail_string .= '  <span><a href="' . HTTPS_SERVER . DIR_WS_CATALOG . '">' . $this->_trail[$i]['title'] . '</a></span>';
						$trail_string .= '  <dt itemscope="" itemtype="https://data-vocabulary.org/Breadcrumb"><meta itemprop="title" content="' . $this->_trail[$i]['title'] . '"><a itemprop="url" href="' . zen_href_link(FILENAME_DEFAULT). '"><span>'.HEADER_TITLE_CATALOG.'</span><i></i></a></span></dt>';
					} else {
						if ($this->_trail[$i]['cID'] != NULL) {
							$categories_name = strip_tags((strlen($this->_trail[$i]['title']) > 30) ? mb_substr($this->_trail[$i]['title'], 0, 30,'utf-8') . '' : $this->_trail[$i]['title']);

							$trail_string .= '<dd itemscope="" itemtype="https://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' . $this->_trail[$i]['link'] . '"><span itemprop="title">' . $categories_name . '</span></a>';

							$sql = "select categories_id as id,parent_id as pid from " . TABLE_CATEGORIES . "
						where categories_status = 1 and parent_id = " . $this->_trail[$i]['cID'] . " order by sort_order";
							$result = $db->Execute($sql);
							$trail_string .= '<b></b><dl>';
							while (!$result->EOF) {
								$trail_string .= '<dd ><a  href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $result->fields['id']) . '"><span >' . zen_get_categories_name($result->fields['id']) . '</span></a></dd>';
								$result->MoveNext();
							}
							$trail_string .= '</dl>';


						} else $trail_string .= '<dd class="my_dashboard" itemscope="" itemtype="https://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="' . $this->_trail[$i]['link'] . '"><span itemprop="title">' . $this->_trail[$i]['title'] . '</span></a>';
						$trail_string .= '</dd>';
					}
				} else {
					if ($this->_trail[$i]['cID'] != null) {
						$sql = "select categories_id as id,parent_id as pid from " . TABLE_CATEGORIES . "
		  			where categories_status = 1 and parent_id = " . $this->_trail[$i]['cID'] . " order by sort_order";
						$result = $db->Execute($sql);
						if ($result->RecordCount()) {
							$class = '';
						} else {
							$class = "last_no";
						}

						if ($this->_trail[$i]['cID'] == 3067) {
							$cpath_link = zen_href_link(FILENAME_WHOLESALE);
						} else {
							$cpath_link = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $this->_trail[$i]['cID']);
						}
						//if(in_array($this->_trail[$i]['cID'],array(1,2,3,4,9,209,573,904,999))){
						$trail_string .= '<dd itemscope="" itemtype="https://data-vocabulary.org/Breadcrumb" class="' . $class . '">
						 <a itemprop="url" href="' . $cpath_link . '">
						 <span itemprop="title">' . strip_tags((strlen($this->_trail[$i]['title']) > 30) ? mb_substr($this->_trail[$i]['title'], 0, 30,'utf-8') . '' : $this->_trail[$i]['title']) . '</span></a>';


						if ($result->RecordCount()) {
							$trail_string .= '<b></b><dl>';
						}
						while (!$result->EOF) {
							$trail_string .= '<dd ><a  href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $result->fields['id']) . '"><span >' . zen_get_categories_name($result->fields['id']) . '</span></a></dd>';
							$result->MoveNext();
						}
						if ($result->RecordCount()) {
							$trail_string .= '</dl>';
						}
						$trail_string .= '</dd>';

						//}

						/*
                           $sql = "select parent_id as pid from " .TABLE_CATEGORIES . "
                                     where categories_status = 1 and categories_id = ".$this->_trail[$i]['cID'] ;
                           $result = $db->Execute($sql);
                             if(!in_array($result->fields['pid'],array(56,57,58,61,889,1113) )){

                              $class_add = "";
                                if($_GET['main_page'] == FILENAME_DEFAULT || $_GET['main_page'] == FILENAME_PRODUCTS_SEARCH || $_GET['main_page'] == FILENAME_NARROW){
                                    if(fs_get_categories_status($this->_trail[$i]['cID'])){
                                           $class_add = 'bg_triangle';
                                    }
                                }
                                $trail_string .= '<dd itemscope="" itemtype="https://data-vocabulary.org/Breadcrumb" class="last_no '.$class_add.'">
                                <a itemprop="url" href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$this->_trail[$i]['cID']).'">
                                <span itemprop="title">'.strip_tags((strlen($this->_trail[$i]['title']) > 30 ) ? substr($this->_trail[$i]['title'], 0, 30).'' :$this->_trail[$i]['title']).'</span></a></dd>';

                                   if($_GET['main_page'] == FILENAME_DEFAULT || $_GET['main_page'] == FILENAME_PRODUCTS_SEARCH || $_GET['main_page'] == FILENAME_NARROW){
                                       if(fs_get_categories_status($this->_trail[$i]['cID'])){

                                   $trail_string .= '<dd class="last_no"><form action="index.php?main_page=products_search">
                             <input type="hidden" value="products_search" name="main_page"><input type="hidden" value="'.$this->_trail[$i]['cID'].'" name="categories"><input type="text" class="menu_02_search" id="CityAjax" name="keyword" value="'.$_GET['keyword'].'" placeholder="Search in this category">
                             <input type="submit"  name="searchSubmit" value="search" class="menu_02_search_btn">
                             '. zen_draw_hidden_field('sort_order',$_GET['sort_order']) .'
                             <div class="ccc"></div>
                           </form></dd>';
                                       }
                                   }

                                }
                           */
					} else {
						if (isset($_GET['products_id'])) {
							if (zen_get_products_has_no_cid($_GET['products_id'])) {
								$trail_string .= '<dd class="last_no"><a href="javascript:;" ><span>' . mb_substr(0,30,$this->_trail[$i]['title'],'utf-8') . '</span></a></dd>';
							}
						} else {
							$span_class = '';
							if ($_GET['main_page'] == 'shopping_cart') {
								$last_link = HTTPS_SERVER . DIR_WS_CATALOG;
								$span_class = 'class="new17home"';
							} else if ($this->_trail[$i]['link'] != null) {
								$last_link = $this->_trail[$i]['link'];
							} else {
								$last_link = 'javascript:;';
							}
							$trail_string .= '<dd class="last_no"><a href="' . $last_link . '" itemprop="url"><span ' . $span_class . ' itemprop="title">' . $this->_trail[$i]['title'] . '</span></a></dd>';
						}
					}
					$trail_string .= '<div class="ccc"></div>';
				}

				if (($i + 1) < $n) $trail_string .= $separator;
				$trail_string .= "\n";
			}

			return $trail_string . '</dl></div>';
		}
	}
  function custom_get_trail($separator = '&nbsp;&nbsp;', $cpath){
  	global $db;
  	$this->reset();
  	$this->add(HEADER_TITLE_CATALOG, zen_href_link(FILENAME_DEFAULT));

  	for ($i=0, $n=sizeof($cpath); $i<$n; $i++) {
    	$categories_query = "select categories_name
                           from " . TABLE_CATEGORIES_DESCRIPTION . "
                           where categories_id = '" . (int)$cpath[$i] . "'
                           and language_id = '" . (int)$_SESSION['languages_id'] . "'";
    	$categories = $db->Execute($categories_query);

	    if ($categories->RecordCount() > 0) {
			//$this->add($categories->fields['categories_name'], zen_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cpath, 0, ($i+1)))));

	    	$this->add($categories->fields['categories_name'], fs_get_rewrite_url('category', $cpath[(sizeof($cpath)-1)]), $cpath[(sizeof($cpath)-1)]);
	    } elseif(SHOW_CATEGORIES_ALWAYS == 0) {
	      // if invalid, set the robots noindex/nofollow for this page
	      $robotsNoIndex = true;
	      break;
	    }

  	}

  	$trail_string = '';

    for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
//    echo 'breadcrumb ' . $i . ' of ' . $n . ': ' . $this->_trail[$i]['title'] . '<br />';

      $skip_link = false;
		  if ($i==($n-1) && DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM =='true') {
        	$skip_link = true;
      	  }

      if (isset($this->_trail[$i]['link']) && zen_not_null($this->_trail[$i]['link']) && !$skip_link ) {

        // this line simply sets the "Home" link to be the domain/url, not main_page=index?blahblah:

        if ($this->_trail[$i]['title'] == HEADER_TITLE_CATALOG) {

          $trail_string .= '  <a href="' .zen_href_link(FILENAME_DEFAULT). '">' . $this->_trail[$i]['title'] . '</a>';

        } else {

          $trail_string .= '  <a href="' . $this->_trail[$i]['link'] . '">' . $this->_trail[$i]['title'] . '</a>';

        }

      } else {

        $trail_string .= '<span>'.$this->_trail[$i]['title'].'</span>';

      }



      if (($i+1) < $n) $trail_string .= $separator;

      $trail_string .= "\n";

    }

    return $trail_string;

  }
  function last() {
    $trail_size = sizeof($this->_trail);
    return $this->_trail[$trail_size-1]['title'];
  }
    function trail_new($separator = '&nbsp;&nbsp;'){
        $trail_string = '';
        $trail_string .= '<div class="menu_list_new">
        				<dl class="menu_list_cont">';
        $trail_string .= '<dt class="back_Home">
                		<meta itemprop="title" content="Home">';
        $trail_string .= '<a itemprop="url" href="' .zen_href_link(FILENAME_DEFAULT) . '">
                   		<span>'.HEADER_TITLE_CATALOG.'</span><i></i>
                		</a>
            			</dt>';
        for ($i = 0, $n = sizeof($this->_trail); $i < $n; $i++) {
            if($this->_trail[$i]['title']!=HEADER_TITLE_CATALOG){
                if($this->_trail[$i]['link']){
                    $trail_string .= '<dd class="Home_next">
                                         <a itemprop="url" href="' .$this->_trail[$i]['link']. '">
                                            <span>' .$this->_trail[$i]['title']. '</span></a>
                                        </dd>';
                }else{
                    $trail_string .= '<dd class="Home_next">
                        <span>' .$this->_trail[$i]['title']. '</span>
                    </dd>';
                }
            }
        }
        $trail_string .= '</dl></div>';
        return $trail_string;
    }
}
