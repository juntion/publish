<?php
/**
 * site_map.php
 *
 * @package general
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: site_map.php 3041 2006-02-15 21:56:45Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * site_map.php
 *
 * @package general
 */
 class zen_SiteMapTree {
   var $root_category_id = 0,
       $max_level = 0,
       $data = array(),
       $root_start_string = '',
       $root_end_string = '',
       $parent_start_string = '',
       $parent_end_string = '',
       $parent_group_start_string = "\n<ul>",
       $parent_group_end_string = "</ul>\n",
       $child_start_string = '<li>',
       $child_end_string = "</li>\n",
       $spacer_string = '',
       $spacer_multiplier = 1;

   function zen_SiteMapTree($load_from_database = true) {
     global $languages_id, $db;
  $this->data = array();
 $categories_query = "select c.categories_id, cd.categories_name, c.parent_id
                      from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                      where c.categories_id = cd.categories_id
                      and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                      and c.categories_status != '0'
                      order by c.parent_id, c.sort_order, cd.categories_name";
         $categories = $db->Execute($categories_query);
         while (!$categories->EOF) {
           $this->data[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'count' => 0);
           $categories->MoveNext();
         }
   }

   function buildBranch($parent_id, $level = 0, $parent_link = '') {
    $result = $this->parent_group_start_string;

    if (isset($this->data[$parent_id])) {
      foreach ($this->data[$parent_id] as $category_id => $category) {
        $category_link = $parent_link . $category_id;
        $result .= $this->child_start_string;
        if (isset($this->data[$category_id])) {
          $result .= $this->parent_start_string;
        }

        if ($level == 0) {
          $result .= $this->root_start_string;
        }
        $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level) . '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_link) . '">';
        $result .= $category['name'];
        $result .= '</a>';

        if ($level == 0) {
          $result .= $this->root_end_string;
        }

        if (isset($this->data[$category_id])) {
          $result .= $this->parent_end_string;
        }

//        $result .= $this->child_end_string;

       if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {
         $result .= $this->buildBranch($category_id, $level+1, $category_link . '_');
       }
       $result .= $this->child_end_string;

     }
   }

    $result .= $this->parent_group_end_string;

    return $result;
  }
   function buildTree() {
     return $this->buildBranch($this->root_category_id);
   }
   /**
    * 
    * @param int $top_category_id
    * @return array:
    * @todo get all third path categories
    */
   function get_third_categories_of_top_category($top_category_id){
   		$all_third_categories = array();
   		$second_categories = zen_get_subcategories_of_one_category($top_category_id);
   		$size = sizeof($second_categories);
   		if ($size) {
   			foreach ($second_categories as $i => $category){
   				$temp_array = zen_get_subcategories_of_one_category($category);
   				$all_third_categories = array_merge($all_third_categories,$temp_array);
   			}
   		}
   		return $all_third_categories;
   }
   function get_all_categories(){
   		global $db;
   		$categories = array();
   		$sql = "SELECT c.categories_id AS id , cd.categories_name AS name FROM ".TABLE_CATEGORIES." AS c
				LEFT JOIN ".TABLE_CATEGORIES_DESCRIPTION." AS cd 
				ON (c.categories_id = cd.categories_id AND cd.language_id = :languages_id:) 
				WHERE c.parent_id = 0 AND c.categories_status = 1;";
   		$sql = $db->bindVars($sql,':languages_id:',(int)$_SESSION['languages_id'],'integer');
   		$result = $db->Execute($sql);
   		while (!$result->EOF) {
   			$thirdCategories = $this->get_third_categories_of_top_category($result->fields['id']);
   			$categories [] = array('id' => $result->fields['id'],'name' => $result->fields['name'],'third'=>$thirdCategories);
   			$result->MoveNext();
   		}
   		return $categories;
   }
   /**
    * get all categories list 
    */
   function buildFiberStoreTree(){
   		global $db;
   		
   		$html = '';
   		
   		$all_categories = $this->get_all_categories();
   		$size = sizeof($all_categories);
   		if ($size) {
   			foreach ($all_categories as $i => $top){
   				$html .= '
   				<dl class="site_map">
              <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$top['id']).'">'.$top['name'].'</a></dt>';
              
   				if (sizeof($top['third'])) {
   					$flag = 0;
   					foreach ($top['third'] as $ii => $category){
   						$html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$category).'">'.zen_get_categories_name($category).'</a></dd>';
//    						if($flag && 0 == ($flag++ +1) % 6)
//    							$html .='<div class="ccc"></div>';
   						
   					}
   				}
              	
              	 $html .='
              	 		<div class="ccc"></div>
              </dl>		
   						
   						
   						';
   			}
   		}
   		
   		echo $html;
   }

     function newBuildFiberStoreTree($footer_data)
     {
         $content = array(
             0 => array(
                 'title' => FS_SITE_MAP_PRODUCT_CATEGORIES,
                 'content' => array()
             ),
             1 => array(
                 'title' => FS_HEADER_COMPANY,
                 'content' => array()
             ),
             2 => array(
                 'title' => FS_SITE_MAP_SERVICE_SUPPORT,
                 'content' => array(
                     0 => array(
                         'title' => FS_HEADER_HELP_CENTER,
                         'link' => reset_url('service/fs_support.html')
                     ),
                     1 => array(
                         'title' => FS_HEADER_SHIPPING_DELIVERY,
                         'link' => zen_href_link('shipping_delivery')
                     ),
                     2 => array(
                         'title' => FS_HEADER_PAYMENT,
                         'link' => zen_href_link('payment_methods')
                     ),
                     3 => array(
                         'title' => FS_FOOTER_QUALITY,
                         'link' => reset_url('company/quality_control.html')
                     ),
                     4 => array(
                         'title' => FS_HEADER_TEC_URL_06,
                         'link' => reset_url('policies/warranty.html')
                     ),
                     5 => array(
                         'title' => FS_HEADER_RETURN_POLICY,
                         'link' => reset_url('policies/day_return_policy.html')
                     ),
                     6 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_04,
                         'link' => reset_url('policies/net_30.html')
                     ),
                     7 => array(
                         'title' => FS_HEADER_TEC_URL_01,
                         'link' => zen_href_link('products_support')
                     ),
                     8 => array(
                         'title' => FS_HEADER_TEC_URL_05,
                         'link' => reset_url('case-studies.html')
                     ),
                     9 => array(
                         'title' => FS_HEADER_TEC_URL_02,
                         'link' => reset_url('support/test-assured-program.html')
                     ),
                     10 => array(
                         'title' => FS_HEADER_TEC_URL_07,
                         'link' => 'https://www.youtube.com/FiberStore'
                     ),
                 )
             ),
             3 => array(
                 'title' => FS_MY_ACCOUNT,
                 'content' => array(
                     0 => array(
                         'title' => FS_SITE_MAP_ACCOUNT,
                         'link' => zen_href_link('login')
                     ),
                     1 => array(
                         'title' => FS_ORDER_HISTORY,
                         'link' => zen_href_link('manage_orders')
                     ),
                     2 => array(
                         'title' => INQUIRY_QUOTE_LIST_2,
                         'link' => zen_href_link('inquiry_list')
                     ),
                     3 => array(
                         'title' => FS_SAVED_CARTS,
                         'link' => zen_href_link('saved_items','type=saved_carts')
                     ),
                     4 => array(
                         'title' => FS_RECENTLY_VIEWED,
                         'link' => zen_href_link('browsing_history')
                     ),
                     5 => array(
                         'title' => FS_RETURN_BUTTON,
                         'link' => zen_href_link('sales_service_request_list')
                     ),
                     6 => array(
                         'title' => FS_ACCOUNT_REVIEW_YOUR_ORDER,
                         'link' => zen_href_link('orders_review_list')
                     ),
                 )
             ),
             4 => array(
                 'title' => FS_SITE_MAP_QUICK_HELP,
                 'content' => array(
                     0 => array(
                         'title' => FS_TECHNICAL_SUPPORT,
                         'link' => reset_url('solution_support.html')
                     ),
                     1 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_11,
                         'link' => reset_url('request_demo.html')
                     ),
                     2 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_03,
                         'link' => reset_url('sample_application.html')
                     ),
                     3 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_05,
                         'link' => zen_href_link('purchase_order')
                     ),
                     4 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_08,
                         'link' => reset_url('new-product.html')
                     ),
                     5 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_09,
                         'link' => reset_url('clearance.html')
                     ),
                     6 => array(
                         'title' => FS_HEADER_CUSTOMER_URL_10,
                         'link' => reset_url('verify.html')
                     ),
                 )
             ),
             5 => array(
                 'title' => FS_PRODUCT_COMMUNITY_01,
                 'content' => array()
             )
         );
         if ($_SESSION['countries_iso_code'] == 'us') {
             $content[2]['content'][] = array(
                 'title' => FS_VAX_TITLE_US_TAX,
                 'link' => reset_url('service/sales_tax.html')
             );
         }
         if ($_SESSION['countries_iso_code'] == 'pr' || $_SESSION['countries_iso_code'] == 'us') {
             $content[2]['content'][] = array(
                 'title' => FS_ERate_01,
                 'link' => zen_href_link('e_rate')
             );
         }
         if ($_SESSION['countries_iso_code'] == 'jp') {
             //  日本站特殊要求
             $content[4]['content'][] = array(
                 'title' => FS_HEADER_CUSTOMER_URL_12,
                 'link' => zen_href_link('shopping_cart')
             );
         }
         foreach ($footer_data as $data) {
             if ($data['title'] == FS_HEADER_COMPANY) {
                 //  company信息
                 foreach ($data['data']['list'] as $item) {
                     $_item = array(
                         'title' => $item['title'],
                         'link' => $item['url']
                     );
                     if (isset($item['is_click'])) {
                         $_item['is_click'] = $item['is_click'];
                     }
                     $content[1]['content'][] = $_item;
                }
             }
             if ($data['title'] == FS_PRODUCT_COMMUNITY_01) {
                 //  Community
                 foreach ($data['data']['list'] as $item) {
                     $_item = array(
                         'title' => $item['title'],
                         'link' => ($item['url'])
                     );
                     $content[5]['content'][] = $_item;
                 }
             }
         }
         $category = new App\Services\Categories\CategoryService();
         $all_categories = $category->getCategories(0,0);
         if (sizeof($all_categories)) {
             foreach ($all_categories as $category){
                 $second_content = array();
                 if(sizeof($category['second'])){
                     foreach ($category['second'] as $second){
                         $third_content = array();
                         if(sizeof($second['third'])){
                             foreach ($second['third'] as $third){
                                 $link = $third['categories_url'] ? reset_url($third['categories_url']) : zen_href_link(FILENAME_DEFAULT,'cPath='.$third['categories_id'],'SSL');
                                 $third_content[] = array(
                                     'title' => $third['categories_name'],
                                     'link' => $link,
                                 );
                             }
                         }
                         $link = $second['categories_url'] ? reset_url($second['categories_url']) : zen_href_link(FILENAME_DEFAULT,'cPath='.$second['categories_id'],'SSL');
                         $second_content[] = array(
                             'title' => $second['categories_name'],
                             'link' => $link,
                             'content' => $third_content
                         );
                     }
                 }
                 //$num = zen_count_products_in_category($category['categories_id']);
                 $content[0]['content'][] = array(
                     'title' => $category['categories_name'],
                     'link' => zen_href_link(FILENAME_DEFAULT,'cPath='.$category['categories_id']),
                     //'products_count' => $num,
                     'content' => $second_content
                 );
             }
         }
         return $content;
     }
 }
